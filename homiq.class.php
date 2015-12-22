<?php

$CONST_TEMP_DIR = '/tmp';

error_reporting(7);

require (dirname(__FILE__).'/db.class.php');
require (dirname(__FILE__).'/crc.php');
require (dirname(__FILE__).'/shmop.db.php');

define ('DEBUG_BASIC', 1);
define ('DEBUG_DB',2);
define ('DEBUG_RFRAMES',4);
define ('DEBUG_SFRAMES',8);
define ('DEBUG_AFRAMES',16);
define ('DEBUG_PFRAMES',32);


define ('_SIGUSR1',10);
define ('_SIGHUP',1);
define ('_SIGTERM',15);
define ('_SIGINT',2);
define ('_SIGKILL',9);




class HOMIQ
{
	var $s;
	var $dbconnect;
	var $adodb;
	var $masters;
	var $semafor=false;
	var $debug;
	var $inifile;
	var $child=0;
	var $uptime=0;
	var $servermode;
	var $macro_stack=array();
	var $pkt_id;
	var $sendmem=null;



	function HOMIQ($debug=0,$server=true)
	{
		$this->debug=$debug;
		$this->servermode=$server;
		$this->init('',$server);
		$this->sendmem=new SCHMOP_DB('send');
	}

	function debug($txt,$state)
	{
		if (! ($this->debug & $state) ) return;

		$child=$this->child ? " [child pid=".$this->child.']' : ''; 
		$txt=trim($txt);
		$debug='['.date('d-m-Y, H:i:s')."] $txt$child\n";
		echo $debug;
	}



	function init($file='')
	{
		if ($file=='') $file=dirname(__FILE__).'/homiq.ini';
		$ini=parse_ini_file($file,true);
		


		$this->inifile=$file;

		$this->debug("Init from $file, my pid=".posix_getpid(),DEBUG_BASIC);

		if ($this->servermode && isset($ini['debug']['server'])) 
		{
			$olddebug=$this->debug;
			$debug=$ini['debug']['server'];
			eval("\$this->debug=$debug;");
			$newdebug=$this->debug;
			$this->debug("Debug $olddebug -> $newdebug",DEBUG_BASIC);
			
		}

		if ($this->servermode)
		{
			$plik=fopen(dirname(__FILE__).'/homiq.pid','w');
			fwrite($plik,posix_getpid());
			fclose($plik);
		}

		$this->dbconnect=$ini['database'];
		$this->opendb($this->servermode);
		$this->uptime=time();
	}

	function ado($name,$p1=null,$p2=null)
	{
		switch (strtolower($name))
		{
			case 'close':
				$this->adodb->close();
				break;

			case 'execute':
				$sql=$p1;
				$sql="SQL:\n$sql";
				$sql=str_replace("\t",'',$sql);
				$sql=str_replace("\n","\n\t",$sql);
				$this->debug($sql,DEBUG_DB);
				return $this->adodb->execute($p1);
				break;
			
			case 'ado_explodename':
				return($this->adodb->ado_ExplodeName($p1,$p2));
				break;

			case 'ado_query2url':
				$sql=$p1;
				$sql="SQL:\n$sql";
				$sql=str_replace("\t",'',$sql);
				$sql=str_replace("\n","\n\t",$sql);
				$this->debug($sql,DEBUG_DB);
				return($this->adodb->ado_query2url($p1));
				break;

			default:
				$this->debug("Unknown ADO command - $name",DEBUG_BASIC);
				break;
		}
	}

	function opendb($initmasters=true)
	{

		while (true)
		{
			$adodb=new HDB($this->dbconnect['type'],$this->dbconnect['host'], $this->dbconnect['user'], $this->dbconnect['pass'], $this->dbconnect['name']);

			if ($adodb->_connectionID) break; 
			$this->debug("Database ".$this->dbconnect['name']." not opened",DEBUG_BASIC);
			sleep(1);
		}

		$this->debug("Database ".$this->dbconnect['name']." OK",DEBUG_BASIC);

		if ($this->debug & DEBUG_DB) $adodb->debug=1;
		$this->adodb=$adodb;

		if (!$initmasters) return;

		$this->masters=array();
		$sql="SELECT * FROM masters WHERE m_active=1";
		
		$res=$this->ado('execute',$sql);

		if ($res) for ($i=0;$i<$res->RecordCount();$i++)
		{
			parse_str($this->ado('ado_ExplodeName',$res,$i));

			$this->debug("Master $m_name [$m_cid] initiated",DEBUG_BASIC);

			$this->masters[$m_cid]['id']=$m_cid;
			$this->masters[$m_cid]['name']=$m_name;
			$this->masters[$m_cid]['host']=$m_ip;
			$this->masters[$m_cid]['port']=$m_port;

			
		}
		
	}

	function reconnect($signo=0)
	{
		//$sql="INSERT INTO log(l_line) VALUES ('RESTART: $signo')";
		//$this->ado('execute',$sql);

		$this->semafor=true;
		$this->debug("Signal $signo detected",DEBUG_BASIC);
		$this->close();
		sleep(1);
		$this->init($this->inifile);
		$this->connect();
		$this->semafor=false;
	}


	function connect()
	{
		if (!is_array($this->masters)) return;

		$t=time();


		if ($this->sendmem) {
			$this->sendmem->delete(array(
				array('s_sent',0),
				array('s_queue',$t,'<')
			));
		} else {
			$sql="DELETE FROM send WHERE s_sent=0 AND s_queue<$t";
			$this->ado('execute',$sql);
		}

		



		//$sql="INSERT INTO log(l_line) VALUES ('START')";
		//$this->ado('execute',$sql);

		$anymasterisalife=false;
		foreach ($this->masters AS $id=>$m)
		{
			$this->s[$id]=socket_create(AF_INET,SOCK_STREAM,SOL_TCP);

			if (@socket_connect($this->s[$id],$m['host'],$m['port']))
			{
				$this->debug('Master '.$m['id'].' connected',DEBUG_BASIC);

				$anymasterisalife=true;
				$fork=pcntl_fork();
				if ($fork) 
				{
					$this->masters[$id]['child']=$fork;


					if ($this->sendmem) {
						$send=$this->sendmem->select(array(
							array('s_sent',0,'>'),
							array('s_pkt',1,'>'),
							array('s_master','$id'),
							)
						);
						if (count($send))
						{
							$k=max(array_keys($send));
							if (isset($send[$k]['s_pkt'])) $this->pkt_id[$id]=$send[$k]['s_pkt'];
						}

					} else {
						$sql="SELECT s_pkt FROM send WHERE s_sent>0 AND s_pkt>1 AND s_master='$id' ORDER BY s_id DESC LIMIT 1";
						parse_str($this->ado('ado_query2url',$sql));
						$this->pkt_id[$id]=$s_pkt;
					}


				}
				else $this->reader($id);
				 
			}
			else
			{
				$this->debug('Master '.$m['id']. ' is not connectable',DEBUG_BASIC);
			}
		}

		if (!$anymasterisalife) return false;


		declare(ticks=1);
		pcntl_signal(_SIGUSR1,array(&$this, 'sendqueue'));
		pcntl_signal(_SIGHUP,array(&$this, 'reconnect'));
		pcntl_signal(_SIGTERM,array(&$this,"close"));
		pcntl_signal(_SIGINT,array(&$this,"close"));


		$this->ado('close');
		$this->opendb(false);

		return true;

	}

	function restore($id)
	{
		$sql="SELECT * FROM outputs WHERE o_master='$id' AND o_active=1";
		
		$res=$this->ado('execute',$sql);

		if ($res) for ($i=0;$i<$res->RecordCount();$i++)
		{
			parse_str($this->ado('ado_ExplodeName',$res,$i));

			if ($o_state) $this->send($id,'O.'.$o_adr,$o_state,$o_module);
		}
	}
	
	function initinput($id,$input)
	{
		$sql="SELECT i_adr FROM inputs WHERE i_master='$id' AND i_module='$input' AND i_type=0";
		$res2=$this->ado('execute',$sql);

		if ($res2) for ($j=0;$j<$res2->RecordCount();$j++)
		{
			parse_str($this->ado('ado_ExplodeName',$res2,$j));
			if (strlen($i_adr)) $this->send($id,'IM.'.$i_adr,0,$input);
		}
	}

	function initinputs($id)
	{
		//return;

		$this->debug("Init inputs",DEBUG_BASIC);

		$sql="UPDATE inputs SET i_state=i_state_default WHERE i_active=1";
		$this->ado('execute',$sql);

		$this->uptime=time();
		$sql="SELECT * FROM modules WHERE m_master='$id' AND m_active=1 AND m_type='I'";
		
		$res=$this->ado('execute',$sql);

		if ($res) for ($i=0;$i<$res->RecordCount();$i++)
		{
			parse_str($this->ado('ado_ExplodeName',$res,$i));

			$this->send($id,'GI',1,$m_adr);
			$this->initinput($id,$m_adr);
		}


	}

	function send($id,$cmd,$val,$dst,$when=0,$runsql='',$src=0,$pkt=0,$top='s',$zer='0')
	{
		$t=time()+$when;
		$insert=time();
		$runsql=addslashes($runsql);


		if ($this->sendmem) {
			$this->sendmem->insert(array(
				's_insert'=>$insert,
				's_queue'=>$t,
				's_time'=>0,
				's_sent'=>0,
				's_master'=>$id,
				's_cmd'=>$cmd,
				's_val'=>$val,
				's_src'=>$src,
				's_dst'=>$dst,
				's_pkt'=>$pkt,
				's_top'=>$top,
				's_zero'=>$zer,
				's_sql'=>$runsql,
			));
		} else {
			$sql="INSERT INTO send
 				(s_insert,s_queue,s_time,s_master,s_cmd,s_val,s_src,s_dst,s_pkt,s_top,s_zero,s_sql) 
				VALUES ($insert,$t,0,'$id','$cmd','$val','$src','$dst',$pkt,'$top',$zer,'$runsql')";
			$this->ado('execute',$sql);
		}

		$this->update_macro_stack($t);


		$pid=$this->masters[$id]['child']?posix_getpid():posix_getppid();

		if (!is_array($this->masters))
		{
			$pid=@implode('',file(dirname(__FILE__).'/homiq.pid'));
		}

		
		if ($pid) posix_kill($pid, _SIGUSR1);
	}

	function microtime_float() 
	{ 
   		list($usec, $sec) = explode(" ", microtime()); 
   		return ((float)$usec + (float)$sec); 
	} 

	function sendframe($url)
	{
		static $lastsend;

		while ( $this->microtime_float()-$lastsend < 0.02) usleep(10000);
		$lastsend=$this->microtime_float();
		
		parse_str($url);

		if ($s_cmd=='PG') $s_pkt=1; 
		if ($s_pkt==0) 
		{
			$id=$s_master;
			if ($this->pkt_id[$id]>512 || !$this->pkt_id[$id]) $this->pkt_id[$id]=2;
			else $this->pkt_id[$id]++;
			$s_pkt=$this->pkt_id[$id];
		}

		if (!strlen($s_cmd) || !strlen($s_val) )
		{
			//$this->debug("SHIT ($url)",DEBUG_BASIC);
			//print_r($this->adodb);
			return;
		}

		$s_zero=hcrc($s_cmd.$s_val.$s_src.$s_dst.$s_pkt.$s_top);
		//hcrc("$cmd"."$val"."$src"."$dst"."$ser"."$type")
		$frame="<;$s_cmd;$s_val;$s_src;$s_dst;$s_pkt;$s_top;$s_zero;>\r\n";
		$tframe=trim($frame);

		$len=@socket_write($this->s[$s_master],$frame);

		$result=($len==strlen($frame))?1:0;

		if (!$s_retry) $s_retry=0;
		if (($this->debug & DEBUG_PFRAMES) || !in_array($s_cmd,array('PG','HB','T.0')) ) 
			$this->debug(($s_top=='a'?'ACK ':'')."To $s_master: $tframe [sid=$s_id,retr=$s_retry,signo=$signo] = $result", ($s_top=='a') ? DEBUG_AFRAMES : DEBUG_SFRAMES);



		//$sql="INSERT INTO log (l_master,l_cmd,l_dst,l_val,l_line,l_top,l_res) VALUES ('T.$s_master','$s_cmd','$s_dst','$s_val','$tframe','$s_top',$result)";
		//$this->ado('execute',$sql);


		if ($len==strlen($frame))
		{
			$t=time();

			if ($this->sendmem) {
			
				$data=array('s_time'=>$t, 's_pkt'=>$s_pkt);
				if ($s_top=='a') $data['s_sent']=$t;
			
				$this->sendmem->update($s_id,$data);
			} else {
				$sent=($s_top=='a')?",s_sent=$t":'';
				$sql="UPDATE send SET s_time=$t,s_pkt=$s_pkt $sent WHERE s_id=$s_id";
				$this->ado('execute',$sql);
			}

			return true;
		}
		
		$this->debug("Could not send ".trim($frame)." to $s_master, len=$len",DEBUG_SFRAMES);
		return false;

	}

	function sendqueue($signo=0)
	{
		//echo "sendqueue($signo).(".$this->semafor.")\n";
		//usleep(1000);

		if ($this->semafor) return;
		$this->semafor=true;

		$t=time();

		/*OLD SEND BY DB

		*/

		if ($this->sendmem) {
			$send=$this->sendmem->select(array(
				array('s_top','a'),
				array('s_sent',0),
				array('s_queue',$t,'<='),
			));

			foreach ($send AS $k=>$s)
			{
				$url=$this->sendmem->array2url($s).'&s_id='.$k;
				$this->sendframe($url."&signo=$signo");
			}


			$send=$this->sendmem->select(array(
				array('s_top','s'),
				array('s_sent',0),
				array('s_queue',$t,'<='),
			));

		} else {
			$sql="SELECT * FROM send WHERE s_sent=0 AND s_top='a' AND s_queue<=$t ORDER BY s_id";
			$res=@$this->ado('execute',$sql);
			if (!$res)
			{
				$this->reconnect();
				return;
			}
			if ($res) for ($i=0;$i<$res->RecordCount();$i++)
			{
				$this->sendframe($this->ado('ado_ExplodeName',$res,$i)."&signo=$signo");
			}
		}

		if (!$this->sendmem) {
			$send=array();
			$sql="SELECT * FROM send WHERE s_sent=0 AND s_top='s' AND s_queue<=$t ORDER BY s_queue,s_id";
			$res=$this->ado('execute',$sql);
			if ($res) for ($i=0;$i<$res->RecordCount();$i++) $send[]=$this->ado('ado_ExplodeName',$res,$i);
				
		}


		foreach ($send AS $k=>$s)	
		{
			$url=$this->sendmem ? $this->sendmem->array2url($s).'&s_id='.$k : $s;
			$s_retry=0;
			$s_time=0;
			parse_str($url);

			$t=time();
			if ( $t-$s_time<2 ) continue;

			if ( $s_retry>5 ) 
			{
				if ($this->sendmem) {
					$this->sendmem->delete($k);
					
				} else {
					$sql="DELETE FROM send WHERE s_id=$s_id";
					$res=$this->ado('execute',$sql);
				}
				$this->debug("Deleting send request (sid=$s_id) due to $s_retry retry failures",DEBUG_BASIC);	
				continue;
			}

			if ( $s_time && $t-$s_time>=2 ) 
			{
				$url.="&s_pkt=0&s_retry=".($s_retry+1);
				
				if ($this->sendmem) {
					$this->sendmem->update($k,'s_retry',$s_retry+1);
				} else {
					$sql="UPDATE send SET s_retry=s_retry+1,s_queue=$t WHERE s_id=$s_id";
					$res=$this->ado('execute',$sql);
				}
			}
			
			$this->sendframe($url."&signo=$signo");
			break;
		}
		
		$this->semafor=false;
	}





	function nextsign($sign)
	{
		$digits=array('0','1','2','3','4','5','6','7','8','9');

		if (in_array($sign,$digits)) 
		{
			$sign++;
			if ($sign==10) $sign='A';
		}
		else 
		{
			if ($sign!='Z') $sign=chr(ord($sign)+1);
		}

		return $sign;
	}

	function newmodule($id)
	{
		$d1='0';
		$d2='1';

		while (true)
		{
			$m_id=0;
			$newadr=$d1.$d2;
			$sql="SELECT max(m_id) AS m_id FROM modules WHERE m_master='$id' AND m_adr='$newadr'";
			parse_str($this->ado('ado_query2url',$sql));
			if (!$m_id) return $newadr;

			$_d2=$this->nextsign($d2);
			if ($d2!=$_d2) $d2=$_d2;
			else 
			{
				$d1=$this->nextsign($d1);
				$d2='0';
			}
		}
	}

	function reader($id)
	{
		$this->child=posix_getpid();

		$this->send=new SCHMOP_DB('send');
		
		$this->debug("Child $id started",DEBUG_BASIC);
		$this->ado('close');
		$this->opendb(false);

		$this->initinputs($id);
		$this->restore($id);


		while(1)
		{




			$txt=socket_read($this->s[$id],64,PHP_NORMAL_READ);
			if (!$txt)
			{
				$this->debug("Error reading frame, killhuping parent",DEBUG_BASIC);
				posix_kill(posix_getppid(), _SIGHUP);
				die();
			}


	

			//<;CMD;VAL;SRC;DST;pkt_id;TOP;0;>
			$txt=trim($txt);
			$f=explode(';',substr($txt,2));
			$cmd=$f[0];
			$val=$f[1];
			$src=$f[2];
			$dst=$f[3];
			$pkt=$f[4];
			$top=$f[5];
			$zer=$f[6];

			$result=($txt[0]!='<')?0:1;

			//$sql="INSERT INTO log (l_master,l_cmd,l_dst,l_val,l_line,l_top,l_res) VALUES ('F.$id','$cmd','$src','$val','$txt','$top',$result)";
			//if (strlen($txt)) $this->ado('execute',$sql);

			if ($txt[0]!='<') continue;

			if ($top=='a') 
			{
				$this->debug("ACK from $id: $txt",DEBUG_AFRAMES);
				$t=time();

				$s_id=0;
				$s_sql='';
				
		
				/*OLD SEND BY DB

				*/

				if ($this->sendmem) {
					$send=$this->sendmem->select(array(
						array('s_master',$id),
						array('s_pkt',$pkt),
						array('s_top','s'),
						array('s_dst',$src),
						array('s_sent',0),
						array('s_time',$t-60,'>'),
					));
					if (count($send))
					{
						$k=max(array_keys($send));
						$this->sendmem->update($k,'s_sent',$t);
						$s_sql=$send[$k]['s_sql'];	
						$this->debug("Frame marked as sent [src=$src, sid=$k, pkt=$pkt]. Total frames ".count($send), DEBUG_BASIC);
					}

				} else {
					$sql="SELECT s_id,s_sql FROM send 
						WHERE s_master='$id' AND s_pkt=$pkt AND s_time>$t-60 AND s_top='s' AND s_sent=0 
						AND s_dst='$src'
						ORDER BY s_id DESC LIMIT 1";
					parse_str($this->ado('ado_query2url',$sql));

					$sql="UPDATE send SET s_sent=$t WHERE s_id=$s_id";
					$this->ado('execute',$sql);
					$this->debug("Frame marked as sent [src=$src, sid=$k, pkt=$pkt].", DEBUG_BASIC);
				}

						
				if (strlen($s_sql)) 
				{
					$res=$this->ado('execute',stripslashes($s_sql));
					$this->debug("running sql after ack: ".stripslashes($s_sql),DEBUG_BASIC);
				}
				

				if ($cmd=='GS')
				{
					$sql="UPDATE modules SET m_serial='$val' WHERE m_master='$id' AND m_adr='$src'";
					$this->ado('execute',$sql);
				}
				if ($cmd=='T.0')
				{
					//BUG FIX
					$vv=explode('.',$val);
					if (strlen($vv[1])==1) $vv[1]='0'.$vv[1];
					$vv[1].='0';
					$val=$vv[0].'.'.$vv[1];
					//BUG FIX END

					$sql="INSERT INTO temp (t_master,t_module,t_temp) VALUES ('$id','$src',$val)";
					$this->ado('execute',$sql);
				}
				posix_kill(posix_getppid(), _SIGUSR1);
				continue;
			}
			if (($this->debug & DEBUG_PFRAMES) ||  !in_array($cmd,array('PG','HB','T.0')) ) $this->debug("From $id: $txt",DEBUG_RFRAMES);

			

			if ($cmd!='PG')
			{
				$s_queue=0;
				/*OLD SEND BY DB

				*/

				if ($this->sendmem) {
					$send=$this->sendmem->select(array(
						array('s_master',$id),
						array('s_pkt',$pkt),
						array('s_top','a'),
						array('s_cmd',$cmd),
						array('s_dst',$src),
					));
					if (count($send))
					{
						$s_queues=array();
						foreach ($send AS $s) $s_queues[]=$s['s_queue'];
						$s_queue=max($s_queues);
					}

				} else {
					$sql="SELECT max(s_queue) AS s_queue FROM send 
						WHERE s_master='$id' AND s_dst='$src' AND s_top='a' AND s_pkt=$pkt AND s_cmd='$cmd'";
					parse_str($this->ado('ado_query2url',$sql));
				}


				if ( time()-$s_queue < 30 && $cmd!='ID.0' )
				{
					$tim=time()-$s_queue;
					//$this->debug("Ignoring input $txt, but sending ACK, $tim sec.",DEBUG_BASIC);
					//$this->send($id,$cmd,$val,$src,0,'',$dst,$pkt,'a',$zer);
					continue;
				}
			}

			$this->send($id,$cmd,$val,$src,0,'',$dst,$pkt,'a',$zer);

			if ( time()-$this->uptime < 10 && $cmd!='ID.0')
			{
				$t=time()-$this->uptime;
				$this->debug("Ignoring input - $t seconds since started",DEBUG_BASIC);
				continue;
			}
			
			switch ($cmd)
			{
				case 'PG':
					break;

				case 'ID.0':
					if (strlen($val)==2)
					{
						$m_id=0;
						$sql="SELECT m_id FROM modules WHERE m_master='$id' AND m_adr='$val'";
						parse_str($this->ado('ado_query2url',$sql));

						$this->debug("Identyfication $id-$val",DEBUG_BASIC);
						if (!$m_id)
						{
							$name="$id-$val";
							$this->debug("Adding module $name",DEBUG_BASIC);
							$sql="INSERT INTO modules (m_name,m_master,m_adr) VALUES ('$name','$id','$val')";
							$this->ado('execute',$sql);
						}
						$this->initinput($id,$val);
					}
					break;

				case 'S.0':
						$m_id=0;
						$m_adr='';
						$sql="SELECT m_id,m_adr FROM modules WHERE m_master='$id' AND m_serial='$val'";
						parse_str($this->ado('ado_query2url',$sql));

	
						if (!$m_id)
						{
							$m_adr=$this->newmodule($id);
							$name="$id-$m_adr";
							$this->debug("Adding module $name",DEBUG_BASIC);
							$sql="INSERT INTO modules (m_name,m_master,m_adr,m_serial) VALUES ('$name','$id','$m_adr','$val')";
							$this->ado('execute',$sql);
						}

						if (strlen($m_adr))
						{
							$this->send($id,'ID.0',$m_adr,$val);
						}
					
					break;

				default:
					if (substr($cmd,0,2)=='I.')
					{
						$i_id=0;
						$adr=substr($cmd,2);
						$sql="SELECT * FROM inputs WHERE i_master='$id' AND i_adr='$adr' AND i_module='$src'";
						parse_str($this->ado('ado_query2url',$sql));
						if (!$i_id)
						{
							$name="$id-$src-$adr";
							$this->debug("Adding input $name",DEBUG_BASIC);
							$sql2="INSERT INTO inputs (i_name,i_master,i_adr,i_module,i_symbol) VALUES ('$name','$id','$adr','$src','$id$src$adr')";
							$this->ado('execute',$sql2);
							parse_str($this->ado('ado_query2url',$sql));
						}

						if ($i_state!=$val)
						{
							$sql="UPDATE inputs SET i_state=$val WHERE i_id=$i_id";
							$this->ado('execute',$sql);
							$this->debug("Input $i_name -> $val",DEBUG_BASIC);
						}
						else
						{
							$this->debug("Input $i_name's state is still $val",DEBUG_BASIC);
						}

						$m_id=0;
						$sql="SELECT m_id,m_type,m_active FROM modules WHERE m_master='$id' AND m_adr='$src'";
						parse_str($this->ado('ado_query2url',$sql));
						if ($m_type!='I' && $m_type!='O')
						{
							$sql="UPDATE modules SET m_type='I' WHERE m_id=$m_id";
							$this->ado('execute',$sql);
						}

						
						
						if ($i_active && $m_active && $i_state!=$val) $this->action($id,$src,$adr,$val);
				
					}
					else $this->debug("Unknown frame from $id: $txt",DEBUG_BASIC);
					
					break;
			}

		}
	}

	function close($signo='')
	{
		$this->debug("Closing due to signal $signo",DEBUG_BASIC);
		
		if (is_array($this->masters))
		{
			foreach ($this->masters AS $id=>$m)
			{
				if ($m['child']) posix_kill($m['child'],_SIGKILL);
				$this->debug("Killing child $id, pid=".$m['child'],DEBUG_BASIC);
				@socket_close ($this->s[$id]);
			}
		}
		$this->ado('close');
		$this->debug("Database closed",DEBUG_BASIC);
		if ($signo>0) 
		{
			$this->debug("Exiting",DEBUG_BASIC);
			if ($this->servermode) unlink(dirname(__FILE__).'/homiq.pid');
			die();
		}
	}

	function clearsendmem()
	{
		foreach ($this->masters AS $id=>$m)
		{
			if ($this->sendmem) {

				$where=array(
					array('s_sent',0,'>'),
					array('s_pkt',1,'>'),
					array('s_top','s'),
					array('s_master',$id),
				);
				$send=$this->sendmem->select($where);
				if (is_array($send) && count($send))
				{
					$k=max(array_keys($send));
					$where=array(
						array('s_sent',0,'>'),
						array('s_sent',time()-60,'<'),
						array('s_master',$id),
						array('s_sent',$send[$k]['s_sent'],'!=')
					);
					$this->sendmem->delete($where);
				}
			} else {
				$sql="DELETE FROM send WHERE s_master=$id AND s_sent<".(time()-24*3600);
				$res=$this->ado('execute',$sql);
			}
		}
	}



	function deadlockdetection()
	{

		foreach ($this->masters AS $id=>$m)
		{
			$lastping=0;
			$lastsent=0;

			if ($this->sendmem) {
				$send=$this->sendmem->select(array(
					array('s_master',$id),
					array('s_top','a'),
				));
				if (count($send))
				{
					$s_queues=array();
					foreach ($send AS $s) $s_queues[]=$s['s_queue'];
					$lastping=max($s_queues);
				}

				$send=$this->sendmem->select(array(
					array('s_master',$id),
					array('s_top','s'),
				));
				if (count($send))
				{
					$s_sents=array();
					foreach ($send AS $s) $s_sents[]=$s['s_sent'];
					$lastsend=max($s_sents);
				}
			} else {
				$sql="SELECT max(s_queue) AS lastping FROM send WHERE s_master='$id' AND s_top='a'";
				parse_str($this->ado('ado_query2url',$sql));			

				$sql="SELECT max(s_sent) AS lastsent FROM send WHERE s_master='$id' AND s_top='s'";
				parse_str($this->ado('ado_query2url',$sql));	
			}



			$last=max($lastping,$lastsent);
			$ile=$last?time()-$last:0;

			if ($ile>10 )
			{
				//$this->debug("No ping from $id for $ile sec.",DEBUG_BASIC);
			}

			if ($ile>15 )
			{
				//$this->initinputs($id);
				//$this->send($id,'PG','1','00');
			}

			if ($ile>20 && time()-$this->uptime > 20)
			{
				$this->debug("No ping detected from $id for $ile sec.",DEBUG_BASIC);
				$this->reconnect('no ping');
			}
		}
	}



	function action($master,$module,$adr,$state)
	{
		$sql="SELECT * FROM global";
		parse_str($this->ado('ado_query2url',$sql));




		$pow=pow(2,$adr);
		$sql="SELECT * FROM action WHERE a_active=1 
				AND a_input_master='$master' AND a_input_module='$module' AND a_input_adr & $pow>0
				AND a_input_state IN ('$state','') 
				ORDER BY a_pri";
		

		$res=$this->ado('execute',$sql);


		//echo "\n$sql\n\n";

		$postsql=array();
		$macros=array();
		$postsenddeletes=array();

		if ($res) for ($i=0;$i<$res->RecordCount();$i++)
		{
			parse_str($this->ado('ado_ExplodeName',$res,$i));

			if (strlen($a_global))
			{
				$neg=false;
				if ($a_global[0]=='!')
				{
					$neg=true;
					$a_global=substr($a_global,1);
				}
				$action_ok=false;
				$str2eval='if ('.($neg?'!':'').'$'.$a_global.') $action_ok=true;';
				eval($str2eval);
				$this->debug($str2eval,DEBUG_BASIC);
				
				if (!$action_ok) continue;

			}

			if ($g_alarm && !strstr(strtolower($a_name),'alarm') )
			{
				$this->debug("Ignoring input - ALARM ",DEBUG_BASIC);
				continue;
			}


			$m_id=0;$m_type='';$m_state='';
			$sql="SELECT m_id,m_type,m_state,m_name,m_sleep FROM modules 
				WHERE m_master='$a_output_master' AND m_adr='$a_output_module' AND m_active=1";
			parse_str($this->ado('ado_query2url',$sql));

			$o_id=0;
			if ( ($m_type=='I' || $m_type=='O') && strlen($a_output_adr))
			{
				$sql="SELECT o_state AS m_state,o_id,o_name AS m_name,o_sleep AS m_sleep,o_active 
					FROM outputs WHERE o_master='$a_output_master' AND o_module='$a_output_module' AND o_adr=$a_output_adr";
				parse_str($this->ado('ado_query2url',$sql));

				if (!$o_active) continue;

			}

			if (!$m_id) 
			{
				if (strlen($a_macro)) 
				{
					usleep(100);
					$this->macro($a_macro);
				}
				continue;
			}
			//echo "\nPOROWNANIE: $a_name:$a_input_module_state(warunek):$m_state(jest)\n";
			if (strlen($a_input_module_state) && $a_input_module_state!=$m_state) continue;

			if ($a_sleep==-1) $a_sleep=$m_sleep;

			$debug="ACTION $m_name: $a_name [type=$m_type] $a_output_master-$a_output_module-$a_output_adr: $a_output_val";
			if (strlen($a_output_state)) $debug.=", set state=$a_output_state";
			if ($a_sleep) $debug.=", exe in $a_sleep sek.";
			$this->debug($debug,DEBUG_BASIC);



			$t=time();


			switch ($m_type)
			{
				case 'R':
					
					$runsql='';
					if (strlen($a_output_state)) 
					{
						$sql="UPDATE modules SET m_state='$a_output_state' WHERE m_id=$m_id";
						//if ($a_sleep==0) $postsql[]=$sql;
						//else $runsql=$sql;

						// RUNSQL AFTER ACK:
						$runsql=$sql;

					}
					$s_cmd='UD';
					$this->send($a_output_master,$s_cmd,$a_output_val,$a_output_module,$a_sleep,$runsql);
					
					if ($a_sleep==0)
					{

						
						$postsql[]="DELETE FROM send WHERE s_master='$a_output_master' 
								AND s_top='s' AND s_dst='$a_output_module'
								AND s_queue>$t AND s_val='$a_output_val'";
						

						$postsenddeletes[]=array(
							array('s_master',$a_output_master),
							array('s_top','s'),
							array('s_dst',$a_output_module),
							array('s_val',$a_output_val),
							array('s_queue',$t,'>'),
						);
					
						$this->debug("Deleting all future commands ON $a_output_master;$a_output_module -> $a_output_val",DEBUG_BASIC);	
					}
					break;


				case 'I':
				case 'O':
					
					$runsql='';
					if (strlen($a_output_state)) 
					{
						$sql="UPDATE outputs SET o_state='$a_output_state' WHERE o_id=$o_id";
						//if ($a_sleep==0) $postsql[]=$sql;
						//else $runsql=$sql;
						// RUNSQL AFTER ACK:
						$runsql=$sql;
					}
					if (strlen($a_output_val))
					{
						$s_cmd='O.'.$a_output_adr;
						$this->send($a_output_master,$s_cmd,$a_output_val,$a_output_module,$a_sleep,$runsql);
						
						
						$postsql[]="DELETE FROM send WHERE s_master='$a_output_master' 
								AND s_top='s' AND s_dst='$a_output_module'
								AND s_cmd='$s_cmd' AND s_val='$a_output_val' 
								AND s_queue>$t AND s_insert<$t";
						

						$postsenddeletes[]=array(
							array('s_master',$a_output_master),
							array('s_top','s'),
							array('s_dst',$a_output_module),
							array('s_val',$a_output_val),
							array('s_cmd',$s_cmd),
							array('s_queue',$t,'>'),
							array('s_insert',$t,'<'),
						);

						$this->debug("Deleting all future commands ON $a_output_master;$a_output_module;$s_cmd->$a_output_val",DEBUG_BASIC);						
					}
					break;

			}

			if (strlen($a_macro)) $macros[]=$a_macro;



			
		}


		if ($this->sendmem) {
			foreach ($postsenddeletes AS $where)
			{
				$this->sendmem->delete($where);
			}
		} else {
			foreach ($postsql AS $sql) 
			{
				$this->ado('execute',$sql);
			}
		}

		foreach ($macros AS $macro) 
		{
			usleep(200);
			$this->macro($macro);
		}

		if (!$this->sendmem) {
			$t=time();
			$sql="SELECT min(s_queue-$t) AS f,count(*) AS c FROM send WHERE s_queue>$t";
			parse_str($this->ado('ado_query2url',$sql));
			if ($c) $this->debug("FUTURE $f, all=$c",DEBUG_BASIC);
		}
	}

	function update_macro_stack($t)
	{
		if (!count($this->macro_stack)) return;
		$m_ids = implode(',',$this->macro_stack);
		$sql="UPDATE macro SET m_end=$t WHERE m_id IN ($m_ids)";
		$this->ado('execute',$sql);
	
	}


	function macro($symbol,$params=array())
	{


		if (!is_array($params) && strlen($params)) $params=unserialize(base64_decode($params));

		$sql="SELECT * FROM macro WHERE m_symbol='$symbol'";
		parse_str($this->ado('ado_query2url',$sql));
		if (!$m_id) 
		{
			$this->debug("Can't find macro '$symbol' ",DEBUG_BASIC);
			return false;
		}

		if (!$m_active)
		{
			$this->debug("Inactive macro '$symbol' ($m_master,$m_module,$m_adr)",DEBUG_BASIC);
			return;
		}

		array_push($this->macro_stack,$m_id);

		$this->debug("Entering macro '$symbol' ($m_master,$m_module,$m_adr)",DEBUG_BASIC);

		$sql="SELECT * FROM global";
		parse_str($this->ado('ado_query2url',$sql));

		if (strlen($m_global))
		{
			$neg=false;
			if ($m_global[0]=='!')
			{
				$neg=true;
				$m_global=substr($m_global,1);
			}
			$action_ok=false;
			$str2eval='if ('.($neg?'!':'').'$'.$m_global.') $action_ok=true;';
			eval($str2eval);
			$this->debug($str2eval,DEBUG_BASIC);
			
			if (!$action_ok) 
			{
				$this->debug("Canceling macro '$symbol' - global",DEBUG_BASIC);
				array_pop($this->macro_stack);
				return;
			}

		}

		if ($m_master=='*')
		{
			if (!strlen($params['m_master']))
			{
				$this->multimacro($symbol);
				array_pop($this->macro_stack);
				return;
			}
			else
			{
				$m_master='';
				$m_module='';
				$m_adr='';
			}
			
		}



		if (!isset($m_master) || !strlen($m_master)) $m_master=$params['m_master'];
		if (!isset($m_module) || !strlen($m_module)) $m_module=$params['m_module'];
		if (!isset($m_adr) || !strlen($m_adr)) $m_adr=$params['m_adr'];

		if (strlen($m_sql))
		{
			parse_str($this->ado('ado_query2url',stripslashes($m_sql)));
		}


		if (isset($m_cancel) && $m_cancel) return;


		if (strlen($m_cmd))
		{
			if (strlen($m_master) && strlen($m_module))
			{

					$sql="SELECT m_id,m_sleep AS module_sleep,m_serial,m_state AS old_state 
						FROM modules WHERE m_master='$m_master' AND m_adr='$m_module'";
					parse_str($this->ado('ado_query2url',$sql));

					if (strlen($m_adr))
					{
						$sql="SELECT o_id,o_id AS module_sleep,o_state AS old_state,o_sleep AS module_sleep
							FROM outputs WHERE o_master='$m_master' AND o_module='$m_module' AND o_adr='$m_adr'";
						parse_str($this->ado('ado_query2url',$sql));

						$m_cmd.=".$m_adr";
					}

					if (strlen($m_state_cond) && $m_state_cond!=$old_state) 
					{
						$m_id=0; // nie wykonuj makra
						$this->debug("Canceling macro '$symbol': $m_state_cond!=$old_state (m_state_cond!=state)",DEBUG_BASIC);
						if ($m_quit_on_cond_fail)
						{
							array_pop($this->macro_stack);
							return;
						}
					}

					if ($m_id)
					{
						if ($m_sleep==-1) $m_sleep=$module_sleep;
						$t=time();
						if ($m_sleep==0) 
						{
							
							$where=array(
								array('s_master',$m_master),
								array('s_top','s'),
								array('s_dst',$m_module),
								array('s_queue',$t,'>'),
							);
							$sql="DELETE FROM send WHERE s_master='$m_master' AND s_top='s' 
								AND s_dst='$m_module' AND s_queue>$t";
							$debug="$m_master;$m_module";
							if ($o_id) 
							{
								$where[]=array('s_cmd',$m_cmd);
								$sql.=" AND s_cmd='$m_cmd'";
								$debug="$m_master;$m_module,$m_cmd";
							}
							else
							{
								$where[]=array('s_val',$m_val);
								$sql.=" AND s_val='$m_val'";
								$debug="$m_master;$m_module -> $m_val";
							}
							
							$this->debug("Deleting all future $debug",DEBUG_BASIC);	
							
							if ($this->sendmem) $this->sendmem->delete($where);
							else $this->ado('execute',$sql);
						}

						if ($m_sleep>0 && $o_id)
						{
							
							if ($this->sendmem) {
								$where=array(
									array('s_master',$m_master),
									array('s_top','s'),
									array('s_dst',$m_module),
									array('s_queue',$t,'>'),
									array('s_cmd',$m_cmd),
									array('s_val',$m_val),
								);
								$send=$this->sendmem->select($where);
								$ile_takich_samych_komend=count($send);
							} else {
								$q="SELECT count(*) AS ile_takich_samych_komend 
									FROM send WHERE s_master='$m_master' AND s_top='s' 
									AND s_dst='$m_module' AND s_queue>$t AND 
									s_cmd='$m_cmd' AND s_val='$m_val'";
								parse_str($this->ado('ado_query2url',$q));
							}

							if ($ile_takich_samych_komend)
							{
								$m_id=0;
								if ($m_quit_on_cond_fail)
								{
									$this->debug("Quiting: future cmds count = $ile_takich_samych_komend",DEBUG_BASIC);
									array_pop($this->macro_stack);
									return;
								}
							}
						}

						$runsql='';

						if (strlen($m_state)) 
						{	
							$sql = $o_id ? 
								"UPDATE outputs SET o_state='$m_state' WHERE o_id=$o_id" 
								: 
								"UPDATE modules SET m_state='$m_state' WHERE m_id=$m_id";

							//if ($m_sleep==0) $this->ado('execute',$sql);
							//else $runsql=$sql;
							// RUNSQL AFTER ACK:
							$runsql=$sql;
						}

						if ($m_cmd=='ID.0')
						{
							$m_val=$m_module;
							$m_module=$m_serial;

						}

						if ($m_id) $this->send($m_master,$m_cmd,$m_val,$m_module,$m_sleep,$runsql);
					}
			}

		}

		if (strlen($m_sh))
		{
			if (strstr($m_sh,'$')) eval("\$m_sh=\"$m_sh\";");
			if (strstr($m_sh_arg1,'$')) eval("\$m_sh_arg1=\"$m_sh_arg1\";");
			if (strstr($m_sh_arg2,'$')) eval("\$m_sh_arg2=\"$m_sh_arg2\";");
			if (strstr($m_sh_arg3,'$')) eval("\$m_sh_arg3=\"$m_sh_arg3\";");
			system("$m_sh $m_sh_arg1 $m_sh_arg2 $m_sh_arg3");
		}



		$params['m_master']=$m_master;
		$params['m_module']=$m_module;
		$params['m_adr']=$m_adr;


		$sql="SELECT mm_child,mm_params,mm_sleep FROM macromacro WHERE mm_parent='$symbol'  AND (mm_sleep IS NULL OR mm_sleep>=0) ORDER BY mm_id";
		$res=$this->ado('execute',$sql);

		if ($res) for ($i=0;$i<$res->RecordCount();$i++)
		{
			parse_str($this->ado('ado_ExplodeName',$res,$i));
			$sql="INSERT INTO macro_future(mf_symbol,mf_time,mf_params) VALUES ('$mm_child',".(time()+$mm_sleep).",
				'".base64_encode(serialize($params))."')";
			$this->ado('execute',$sql);
			$this->update_macro_stack(time()+$mm_sleep);

		}

		if ($res) if ($res->RecordCount()) $this->macro_future();
		array_pop($this->macro_stack);
	}

	function macro_future()
	{
		$t=time();

		$sql="SELECT * FROM macro_future WHERE mf_time<=$t ORDER BY mf_time,mf_id";
                $res=$this->ado('execute',$sql);

		if ($res) for ($i=0;$i<$res->RecordCount();$i++)
		{
			parse_str($this->ado('ado_ExplodeName',$res,$i));

			$sql="DELETE FROM macro_future WHERE mf_id=$mf_id";
			$this->ado('execute',$sql);

			$this->macro($mf_symbol,$mf_params);
		}


	}


	function multimacro($symbol)
	{
		
		$sql="SELECT * FROM macro WHERE m_symbol='$symbol'";
		parse_str($this->ado('ado_query2url',$sql));


		$sql="SELECT * FROM outputs WHERE o_active=1";
		
		if (strlen($m_master) && $m_master!='*') $sql.=" AND o_master='$m_master'";
		if (strlen($m_module) && $m_module!='*') $sql.=" AND o_module='$m_module'";
		if (strlen($m_adr) && $m_adr!='*') $sql.=" AND o_adr='$m_adr'";
		if (strlen($m_type)) $sql.=" AND o_type='$m_type'"; 
		$sql.=" ORDER BY o_id";

		$res=$this->ado('execute',$sql);

		if ($res) for ($i=0;$i<$res->RecordCount();$i++)
		{
			parse_str($this->ado('ado_ExplodeName',$res,$i));

			$params['m_master']=$o_master;
			$params['m_module']=$o_module;
			$params['m_adr']=$o_adr;
			
			$this->macro($symbol,$params);		
		}
	}

	function cleandb()
	{
		$t=time()-12*3600;

		if (!$this->sendmem) {
			$sql="DELETE FROM send WHERE s_sent<$t;";
			$res=$this->ado('execute',$sql);
		}
		$sql="DELETE FROM log WHERE l_timestamp<CURRENT_DATE-1";
		$res=$this->ado('execute',$sql);
		$sql="DELETE FROM power WHERE p_time<".(time()-60*24*3600);
		$res=$this->ado('execute',$sql);
		$sql="DELETE FROM temp WHERE t_time<".(time()-60*24*3600);
		$res=$this->ado('execute',$sql);

	}

	function cron()
	{
		$min=date('i')+0;
		$hour=date('H')+0;
		$day=date('d')+0;
		$month=date('m')+0;
		$dow=date('w')+0;
		$now=date('Y-m-d H:i');

		$sql="SELECT * FROM cron LEFT JOIN macro ON c_macro_id=m_id
			WHERE c_active=1 AND (
			(
				(c_min='*' OR ','||c_min||',' ~ ',$min,')
				AND (c_hour='*' OR ','||c_hour||',' ~ ',$hour,')
				AND (c_day='*' OR ','||c_day||',' ~ ',$day,')
				AND (c_month='*' OR ','||c_month||',' ~ ',$month,')
				AND (c_dow='*' OR ','||c_dow||',' ~ ',$dow,')
			) OR c_when='$now')
			ORDER BY c_pri
			";

		$res=$this->ado('execute',$sql);

		if ($res) for ($i=0;$i<$res->RecordCount();$i++)
	    	{
			parse_str($this->ado('ado_ExplodeName',$res,$i));

			if ($c_nottoday)
			{
				$sql="UPDATE cron SET c_nottoday=0 WHERE c_id=$c_id";
				$this->ado('execute',$sql);
				continue;
			}

			$this->macro($m_symbol);
		}

	}

	function hb()
	{
		static $serial;
		static $lastsend;


		if (time()-$lastsend<18) return;

		if (!$serial || $serial==256) $serial=1;

		$url="s_cmd=HB&s_val=1&s_src=0&s_dst=yy&s_top=s&s_pkt=$serial&s_id=0"; 

		foreach (array_keys($this->masters) AS $master) $this->sendframe($url.'&s_master='.$master);
		$lastsend=time();
		$serial++;
	}


	function run()
	{
		if (!$this->connect()) return;
	
		$lastcron=date('i');
		while(true) 
		{
			$t=time();
			if ($lastcron!=date('i'))
			{
				$lastcron=date('i');
				$this->cron();
			}
			sleep(1);
			$this->macro_future();
			if ($t%5==0) 
			{
				$this->deadlockdetection();
				$this->clearsendmem();
				$this->sendqueue();
				
			}
			$this->hb();
		}		
	}

}



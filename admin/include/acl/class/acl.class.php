<?php

class ACL
{
	var $session,$sessid,$session_file_prefix,$cookie_name,$session_timeout;
	var $system=1;
	var $adb;
	var $login,$login_id;
	var $debug=false;
	var $last_debug_msg;
	var $need_cookie=false;
	var $log_level=1;
	var $label;


	function ACL(&$adb,$session_valid_time=0)
	{
		$this->adb=$adb;
		if ($session_valid_time) $this->session_timeout=$session_valid_time;
	}

	function getSesionDir()
	{
		global $CONST_TEMP_DIR;
		$check=array($CONST_TEMP_DIR,ini_get ("session.save_path"),"/var/tmp","/tmp");

		foreach ($check AS $pwd) if (strlen($pwd) && is_writable($pwd)) return $pwd;	
	}

	function log($txt,$level)
	{
		if ($level>$this->log_level) return;

		$system=$this->system;
		$user=$this->login;


		$sql="INSERT INTO acl_log (al_user,al_level,al_txt,al_system) VALUES ('$user',$level,'$txt',$system)";
		$this->adb->execute($sql);

	}

	function label($txt,$lang)
	{
		if (!is_array($this->label))
		{
			@include(dirname(__FILE__).'/../lang/'.$lang.'.php');
			$this->label[$lang]=$label;
		}

		return isset($this->label[$lang][$txt]) ? $this->label[$lang][$txt] : $txt;
	}

	function debug($txt)
	{
		$this->last_debug_msg=$txt;
		if (!$this->debug) return;

		switch ($this->debug)
		{
			case 2:
				if (!isset($this->session['debug'])) $this->session['debug']=array();
				$this->session['debug'][]=date('H:i:s, ').$txt;
				break;
			default:
				echo "$txt<br />";
		}
	}

	function dbPushPop()
	{

		if ($this->adb->_connectionID && $this->adb->_connectionSTR)
		{
			$this->addToSession('db.string',$this->adb->_connectionSTR,true);
			$this->addToSession('db.type',$this->adb->type,true);
		}

		
		if (!$this->adb->_connectionID && $this->session['db.string'])
		{
			$this->adb=new ACL_DB($this->session['db.type'],$this->session['db.string']);
		}
	}

	function session_start()
	{
		$this->cookie_name = strlen($_COOKIE["WKSESSID"]) ? "WKSESSID" : "ACLSESSID";
		$this->session_file_prefix= strlen($_COOKIE["WKSESSID"]) ? "wksess_" : "aclsess_";

		while (strlen($_COOKIE[$this->cookie_name])) 
		{

			$sid=$_COOKIE[$this->cookie_name];
			$plik=$this->getSesionDir()."/".$this->session_file_prefix.$sid;
			$session="";

			if (file_exists("$plik.acl")) $plik="$plik.acl";

			$fs=0;$fe=0;
			$try=3;
			while ($try && file_exists($plik)) 
			{
				$fe=1;
				$fp=fopen($plik,"r");
				flock($fp, LOCK_EX);
				$session=@unserialize(fread($fp, filesize($plik) ));
				fclose($fp);
				if (strlen($session['login.login'])) break;
				$try--;
				usleep(200);
			}

			$this->session=$session;
			$this->sessid=$sid;

			$this->debug("SESSION: $plik");

			$this->dbPushPop();

			if ($this->session_timeout && isset($this->session['login.timestamp']) )
			{
				if (time()>$this->session['login.timestamp']+$this->session_timeout)
				{
					$this->logout();
					break;
				}
			}

			$this->session['login.timestamp']=time();
			return $sid;
		}
		

		$RA=$_SERVER['REMOTE_ADDR'];
		$sid="php_acl".rand(100000,999999)."${RA}".time();
		$sid=md5($sid);

		if (headers_sent()) $this->need_cookie=true;
		@SetCookie($this->cookie_name,$sid,0,"/");
		$this->sessid=$sid;
		$_COOKIE[$this->cookie_name]=$sid;

		$this->debug("SESSION new: ".$this->getSesionDir()."/".$this->session_file_prefix.$sid.'.acl');

		$this->dbPushPop();

		$this->session['login.timestamp']=time();
	}


	function kameleon($system=0)
	{
		if (!$system) $system=$this->system;

		$sql="SELECT as_kameleon FROM acl_system WHERE as_id=$system";
		@parse_str($this->adb->query2url($sql));

		return $as_kameleon;
	}



	function init($system='',$kameleon=0)
	{
		$system=preg_replace('/[^a-z0-9_]/','',strtolower($system));
		$requested_system=$system;


		if ($this->debug==2)
		{
			$this->adb->debug=&$this->session['debug'];
		}

		if ($kameleon)
		{
			$sys=$this->getFromSession('kameleon.'.$kameleon);
			if (!strlen($sys))
			{
				$sql="SELECT as_name AS sys FROM acl_system WHERE as_kameleon=$kameleon";
				@parse_str($this->adb->query2url($sql));
				if (strlen($sys)) $this->addToSession('kameleon.'.$kameleon,$sys);
			}
			if (strlen($sys)) $system=$sys;
		}

		if (strlen($system))
		{
			if ($this->session['systems'][$system]) 
			{
				$this->system = $this->session['systems'][$system];
				return $this->system;
			}
			$sql="SELECT as_id FROM acl_system WHERE as_name='$system'";
			@parse_str($this->adb->query2url($sql));
			

			if (!$as_id)
			{
				$sql="INSERT INTO acl_system (as_name,as_kameleon) VALUES ('$system',$kameleon); $sql";
				@parse_str($this->adb->query2url($sql));
			}

			$system=$as_id;
		}
		if (!$system) $system=$this->getFromSession('system');
		$this->system=$system;
		if ($system) $this->addToSession('system',$system,true);

		if (strlen($requested_system) && $system) $this->session['systems'][$requested_system]=$system;

		return $this->system;
	}


	function system_name($system=0)
	{
		if (!$system) $system=$this->system;
		if (!$system) return '';

		$as_name=@array_search($system,$this->session['systems']);

		if ($as_name) return $as_name;

		$sql="SELECT as_name FROM acl_system WHERE as_id=$system";
		parse_str($this->adb->query2url($sql));
		if ($as_name) $this->session['systems'][$as_name]=$system;
		return $as_name;
	}

	function close($pukeJavaScriptCookie=true)
	{
		if ($this->system) $this->addToSession('system',$this->system,true);

		$sid=$this->sessid;
		$cn=$this->cookie_name;
		if ($pukeJavaScriptCookie && $this->need_cookie) echo "<script language=\"javascript\">document.cookie='$cn=$sid; path=/'</script>";


		$plik=@fopen($this->getSesionDir()."/".$this->session_file_prefix.$sid.'.acl',"w");
		flock($plik, LOCK_EX);
		$session=$this->session;
		@fwrite($plik,serialize($session));
		fclose($plik);

	}

	function logout()
	{
		$this->session=null;
		$sid=$this->sessid;
		$plik=$this->getSesionDir()."/".$this->session_file_prefix.$sid.'.acl';
		@SetCookie($this->cookie_name,'',0,"/");
		@unlink($plik);

	}

	function addToSession($name, $value, $overwrite=true)
	{
		$sessionArray = $this->session;
		
		if ( !isset($sessionArray[$name]) )
		{
			$sessionArray[$name] = $value;
		}
		else if ( isset($sessionArray[$name]) && $overwrite == true )
		{
			$sessionArray[$name] = $value;
		}

		$this->session = $sessionArray;
	}
	

	function getFromSession($name)
	{
		$sessionArray = $this->session;
		return $sessionArray[$name];
	}

	function delSessionVar($name)
	{
		$sessionArray =$this->session;
		unset($sessionArray[$name]);
		$this->session = $sessionArray;
	}


	function hasRight($right,$resource,$id='',$user='')
	{
		if (!strlen($user)) $user=$this->getFromSession('login.login');

		if (!strlen($user)) 
		{
			$sql="SELECT count(*) AS c FROM acl_user";
			@parse_str($this->adb->query2url($sql));
			return $c?false:true;
		}

		if (!is_array($id) && strlen($id) ) $id=array($id);


		$system=$this->system_name();
		
		$token_general="$system.$user.$right.$resource.";
		$token=$token_general;
		if (is_array($id)) $token.=implode(',',$id);

		//$this->debug("trying '$token'");

		if (strlen($this->session['acl'][$token]))
		{
			$this->debug("cache for '$token' = ".$this->session['acl'][$token]);
			return $this->session['acl'][$token]=='+' ? true : false;
		}

		$sql="SELECT count(*) AS c FROM acl$system WHERE a_resource='$resource' AND a_right='$right'";
		@parse_str($this->adb->query2url($sql));
		if (!$c)
		{
			$this->debug("0 => $sql ... '$token'=+");
			$this->session['acl'][$token]='+';
			return true;
		}

		if (is_array($id))
		{
			$ids=implode("','",$id);
			$sql="SELECT count(*) AS c FROM acl$system WHERE a_resource='$resource' AND a_right='$right' AND a_resource_id IN '$ids'";
			@parse_str($this->adb->query2url($sql));
			if (!$c)
			{
				$this->debug("0 => $sql ... '$token'=+");
				$this->session['acl'][$token]='+';
				return true;
			}

		}

		$sql="SELECT count(*) AS c FROM acl$system WHERE a_token='$token_general'";
		parse_str($this->adb->query2url($sql));
		if ($c)
		{
			$this->debug("$c => $sql ... '$token_general'=+");
			$this->session['acl'][$token]='+';
			return true;
		}

		if (is_array($id)) foreach ($id AS $_id)
		{
			$_token=$token_general.$_id;
			$sql="SELECT count(*) AS c FROM acl$system WHERE a_token='$_token'";
			parse_str($this->adb->query2url($sql));
			if ($c)
			{
				$this->debug("$c => $sql ... '$token'=+");
				$this->session['acl'][$token]='+';
				return true;
			}
		}

		$this->session['acl'][$token]='-';
		return false;
	}


	function hasRightMatrix($_right,$_resource,$_resource_id,$_user,$_group)
	{

		if (is_array($_resource_id))
		{
			foreach ($_resource_id AS $_id)
			{
				if ( $this->hasRightMatrix($_right,$_resource,$_id,$_user,$_group) ) return true;
			}
			return false;
		}

		$sql="SELECT am_grant FROM acl_matrix WHERE am_right=$_right AND am_resource=$_resource AND am_resource_id='$_resource_id'";
		if ($_user) $sql.=" AND am_user=$_user";
		if ($_group) $sql.=" AND am_group=$_group";
		parse_str($this->adb->query2url($sql));
		return $am_grant;
	}


	function login($user='',$pass='',$dont_check_pass=false)
	{
		if (strlen($user) && strlen($pass))
		{
			$sql="SELECT * FROM acl_user WHERE au_login='$user'";
			@parse_str($this->adb->query2url($sql));

			if (!strlen($au_pass))
			{
				$c='';
				$q="SELECT count(*) AS c FROM acl_user";
				@parse_str($this->adb->query2url($q));
				if (!strlen($c))
				{
					$this->initdb();
				}
				if (!$c)
				{
					$p=strlen($pass)>24 ? $pass : crypt($pass);
					$q="INSERT INTO acl_user (au_login,au_pass) VALUES ('$user','$p')";
					@parse_str($this->adb->query2url("$q;$sql"));
					
				}
			}

			$fail = (($pass!=$au_pass && $au_pass!=crypt($pass,$au_pass) && $au_pass!='!') || !strlen($pass) || !strlen($au_pass) || ($au_pass=='!' && $pass==$au_pass) ) ? true : false;
			if ($dont_check_pass) $fail=false;

			
			if ($fail) 
			{
				$this->debug("Login for $user failed");
				return false;
			}

			if (strlen($au_active) && !$au_active)
			{
				$this->debug("User $user inactive");
				return false;
			}

			if (strlen($au_expire) && $au_expire<time())
			{
				$this->debug("User $user expired");
				return false;
			}


			$this->debug("Login $user OK");

			$this->addToSession('login.login',$user,true);
			$this->addToSession('login.phash',md5($au_pass),true);
			$this->addToSession('login.cpass',($pass==$au_pass?$pass:$au_pass));
			$this->addToSession('login.alreadyLogedIn', true, true);
			$this->addToSession('login.id',$au_id,true);
			$this->session['acl']=array();

			$this->close();
		}
		else
		{
			$user=$this->getFromSession('login.login');

			if (!strlen($user)) 
			{
				$this->debug("No session login");
				return false;
			}
			$this->debug("Login $user session");
			
			if (!$this->getFromSession('login.alreadyLogedIn')) return false;

		}

		$id=$this->getFromSession('login.id');
		

		if (!$id)
		{

			$sql="SELECT au_id FROM acl_user WHERE au_login='$user'";
			@parse_str($this->adb->query2url($sql));

			
			$id=$au_id;
			$this->addToSession('login.id',$id,true);
		}

		$this->login=$user;
		$this->login_id=$id;
		return $id;
	}

	function loginInfoUrl($user=0)
	{
		if (!$user) $user=0+$this->login_id;
	
		if (strlen($this->session['login.user_info'][$user])) return $this->session['login.user_info'][$user];
		
		$sql="SELECT * FROM acl_user WHERE au_id=$user";
		$url=$this->adb->query2url($sql);

		$system=$this->system;
		$sql="SELECT ag_name 
				FROM acl_user_group LEFT JOIN acl_group ON aug_group=ag_id
				WHERE aug_user=$user AND ag_system=$system
				ORDER BY ag_name";


		$res=@$this->adb->execute($sql);
		for ($i=0;$i<$res->RecordCount();$i++)
		{
			parse_str($this->adb->explodeName($res,$i));
			$url.="&group[$i]=$ag_name";	
		}

		$this->session['login.user_info'][$user]=$url;
		return $url;
	}


	function loginInfo($user=0)
	{
		parse_str($this->loginInfoUrl($user));
		$ret=get_defined_vars();
		unset($ret['this']);
		unset($ret['user']);
		unset($ret['au_pass']);
		unset($ret['au_pass2']);

		return $ret;
	}

	function matrix($matrix,$url='',$system=0)
	{
		if (!$system) $system=$this->system;

		foreach ($matrix AS $k=>$v)
		{
			$_url=$url;
			if (is_array($v))
			{
				$k=urlencode($k);
				if (!strlen($url)) 
				{
					$_url="$k=";
				}
				elseif (substr($url,strlen($url)-1)=='=')
				{
					$_url.=$k;
				}
				else
				{
					$_url.="&$k=";
				}

				$this->matrix($v,$_url,$system);
			}
			else
			{
				if (substr($url,strlen($url)-1)=='=') $_url.=urlencode($k);
				parse_str($_url);

				$grant=$v+0;
				if ($resource_id==GRANT_ALL)
				{
					$resource_id='';
				}

				if ($resource && $right && ($group+$user))
				{
					$user_group_warunek='';
					if ($user) $user_group_warunek.=" AND am_user=$user";
					if ($group) $user_group_warunek.=" AND am_group=$group";

					$am_id=0;
					$sql="SELECT am_id,am_grant,
							acl_resource.ar_name AS _resource,
							acl_right.ar_name AS _right,
							au_login AS _user,
							ag_name AS _group
							FROM acl_matrix
							LEFT JOIN acl_resource ON am_resource=acl_resource.ar_id
							LEFT JOIN acl_user ON am_user=au_id
							LEFT JOIN acl_group ON am_group=ag_id
							LEFT JOIN acl_right ON am_right=acl_right.ar_id
							WHERE am_system=$system AND am_resource=$resource AND am_resource_id='$resource_id' AND am_right=$right $user_group_warunek";
					parse_str($this->adb->query2url($sql));
					
					if (strlen($resource_id)) $_resource.="[$resource_id]";
					$matrix="$_right@$_resource for $_user";
					if (strlen($_group)) $matrix.="group $_group"; 
					$sql='';
					if (!$am_id)
					{
						$ins='';$val='';
						if ($user) $ins.=",am_user";
						if ($group) $ins.=",am_group";
						if ($user) $val.=",$user";
						if ($group) $val.=",$group";
						$sql="INSERT INTO acl_matrix (am_system,am_resource,am_resource_id,am_right,am_grant$ins) VALUES ($system,$resource,'$resource_id',$right,$grant$val)";
						$this->log("new group matrix",1);
					}
					else
					{
						if ($am_grant!=$grant) 
						{
							$sql="UPDATE acl_matrix SET am_grant=$grant WHERE am_id=$am_id";
							$this->log("matrix($matrix) -> $grant",1);
						}
					}

					if (strlen($sql)) $this->adb->execute($sql);
				}

				//echo "$sql [$_url]: $resource_id,$k,$v\n";
			}
		}

	}



	function initdb()
	{
		$sql="SELECT * FROM acl_system";
		$res=@$this->adb->execute($sql);

		if (!$res)
		{
			$sql=file_get_contents(dirname(__FILE__).'/../.sql/db.sql');
			$this->adb->execute($sql);
			
		}

		$sql=file_get_contents(dirname(__FILE__).'/../.sql/fun.sql');
		if (strlen($sql)) $this->adb->execute($sql);


		$t=time();
		$handle=@opendir(dirname(__FILE__).'/../update');
		while (($file = @readdir($handle)) !== false) 
		{

			if ($file[0]==".") continue;

			$au_time=0;
			$sql="SELECT au_time FROM acl_update WHERE au_file='$file'";
			parse_str($this->adb->query2url($sql));


			if (!$au_time)
			{
				$sql=file_get_contents(dirname(__FILE__).'/../update/'.$file);
				$sql.="; INSERT INTO acl_update (au_file,au_time) VALUES ('$file',$t);";
				
				$this->adb->execute($sql);
			}
		}
		@closedir($handle);

	}

	function userPass($new,$old=null,$user=0)
	{
		$this->debug("enetering chpass($new,$old,$user)");
		if (!$user) $user=0+$this->login_id;

		if (!strlen($new)) return;

		$sql="SELECT * FROM acl_user WHERE au_id=$user";
		parse_str($this->adb->query2url($sql));

		if ($old!==null)
		{
			if (!strlen($old)) return false;
			if (crypt($old,$au_pass)!=$au_pass) return false;
		}
		
		$pass=crypt($new);
		$sql="UPDATE acl_user SET au_pass='$pass' WHERE au_id=$user";
		$this->adb->execute($sql);
		$this->log("user $au_login chpass",1);
		$this->debug("user $au_login chpass");

		return true;
	}

	function userExists($user)
	{
		$sql="SELECT au_id FROM acl_user WHERE au_login='$user'";
		parse_str($this->adb->query2url($sql));

		return $au_id;
	}


	function userActive($user_id,$hash='',$active='')
	{

		if (strlen($active)==1)
		{
			$sql="UPDATE acl_user SET au_hash='$hash',au_active=$active WHERE au_id=$user_id";
			$this->adb->execute($sql);
			return $active;
		}
		if (strlen($hash) && strlen($active)==0)
		{
			$sql="SELECT au_hash FROM acl_user WHERE au_id=$user_id";
			parse_str($this->adb->query2url($sql));

			$active = ($hash==$au_hash) ? 1 : 0;

			$sql="UPDATE acl_user SET au_active=$active WHERE au_id=$user_id";
			$this->adb->execute($sql);
			return $active;

		}

		$sql="SELECT au_active FROM acl_user WHERE au_id=$user_id";
		parse_str($this->adb->query2url($sql));
		return $au_active;
	}


	function userDel($user=0)
	{
		if (!$user) $user=0+$this->login_id;
		if (!$this->hasRight('delete','user')) return false;
	
		$sql="DELETE FROM acl_user_group WHERE aug_user=$user;
				DELETE FROM acl_matrix WHERE am_user=$user;
				DELETE FROM acl_user WHERE au_id=$user";
		$this->adb->execute($sql);

		return true;
	}

	function userAdd($user,$pass,$name,$g0='',$g1='',$g2='',$g3='',$g4='')
	{

		if (!$this->hasRight('insert','user')) return false;

		$au_id=$this->userExists($user);

		if ($au_id) 
		{
			$this->debug("userAdd: $user exists, exiting");
			return false;
		}

		$cpass = (substr($pass,0,6)=='crypt:') ? substr($pass,6) : crypt($pass);
		$sql="INSERT INTO acl_user (au_login,au_pass,au_name)
				VALUES ('$user','$cpass','$name');
				SELECT au_id FROM acl_user WHERE au_login='$user'";

		parse_str($this->adb->query2url($sql));

		if ($au_id) 
		{
			$this->debug("userAdd: $user:$pass ($cpass), id=$au_id ... OK");
			$this->log("user $user added",1);
		}
		$system=$this->system;

		$g=0;
		while($au_id)
		{
			eval("\$group=\$g$g;");
			if (!strlen($group)) break;
			$g++;

			$ag_id =0;
			$sql="SELECT ag_id FROM acl_group WHERE ag_name='$group' AND ag_system=$system";
			parse_str($this->adb->query2url($sql));
			if (!$ag_id)
			{
				$sql="INSERT INTO acl_group (ag_name,ag_system) VALUES ('$group',$system); $sql";
				parse_str($this->adb->query2url($sql));
			}

			$this->debug("userAdd: $user -> group $group ($ag_id)");
			$this->log("user $user added to group $group",1);

			$sql="INSERT INTO acl_user_group (aug_user,aug_group) VALUES ($au_id,$ag_id)";
			$this->adb->execute($sql);

		}

		$this->save();
		return $au_id;
	}

	function resourceAdd($resource)
	{
		$system=$this->system;

		$ar_id=$this->getFromSession('cache.resource.'.$system.'.'.$resource);
		if (!$ar_id)
		{
			$query="SELECT ar_id FROM acl_resource WHERE ar_name='$resource' AND ar_system=$system";
			parse_str($this->adb->query2url($query));
			$this->addToSession('cache.resource.'.$system.'.'.$resource,$ar_id,true);
		}
		else return $ar_id;
	

		if (!$ar_id && $this->hasRight('insert','resource') )
		{
			$sql="INSERT INTO acl_resource (ar_name,ar_system) VALUES ('$resource','$system'); $query";	
			parse_str($this->adb->query2url($sql));	
			$this->log("adding resource $resource",1);
		}

		return $ar_id;
	}

	function rightAdd($right)
	{
		$system=$this->system;



		$ar_id=$this->getFromSession('cache.right.'.$system.'.'.$right);
		if (!$ar_id)
		{
			$query="SELECT ar_id FROM acl_right WHERE ar_name='$right' AND ar_system=$system";
			parse_str($this->adb->query2url($query));
			$this->addToSession('cache.right.'.$system.'.'.$right,$ar_id,true);
		}
		else return $ar_id;




		if (!$ar_id && $this->hasRight('insert','right') )
		{
			$sql="INSERT INTO acl_right (ar_name,ar_system) VALUES ('$right','$system'); $query";	
			parse_str($this->adb->query2url($sql));	
			$this->log("adding right $right",1);
		}

		return $ar_id;
	}



	function groupAdd($group)
	{
		$system=$this->system;


		$ag_id=$this->getFromSession('cache.group.'.$system.'.'.$group);
		if (!$ag_id)
		{
			$query="SELECT ag_id FROM acl_group WHERE ag_name='$group' AND ag_system=$system";
			parse_str($this->adb->query2url($query));
			$this->addToSession('cache.group.'.$system.'.'.$group,$ag_id,true);
		}
		else return $ag_id;



		if (!$ag_id && $this->hasRight('insert','group') )
		{
			$sql="INSERT INTO acl_group (ag_name,ag_system) VALUES ('$group','$system'); $query";	
			parse_str($this->adb->query2url($sql));	
			$this->log("adding group $group",1);
		}

		return $ag_id;
	}

	function needSave($system=0)
	{
		if (!$system) $system=$this->system;


		$sql="SELECT * FROM acl_system WHERE as_id=".$system;
		parse_str($this->adb->query2url($sql));

		return $as_last_update>$as_last_save;
	}


	function save($system=0)
	{
		if (!$system) $system=$this->system;




		$sql="SELECT * FROM acl_system WHERE as_id=".$system;
		parse_str($this->adb->query2url($sql));

		$token="cast ('$as_name' AS varchar(40))||'.'||acl_user.au_login||'.'||acl_right.ar_name||'.'||acl_resource.ar_name||'.'||am_resource_id";

		$fields="	cast ('$as_name' AS varchar(40)) AS a_system,
					acl_resource.ar_name AS a_resource,
					am_resource_id AS a_resource_id,
					acl_right.ar_name AS a_right,
					acl_user.au_login AS a_login,
					$token AS a_token
		";

		$groupby="acl_resource.ar_name,am_resource_id,acl_right.ar_name,acl_user.au_login";



		$tempname="${as_name}_tmp";
		$name="acl$as_name";

		$sql="	DROP TABLE IF EXISTS $tempname;
				SELECT $fields			
				INTO $tempname 
				FROM acl_matrix
				LEFT JOIN acl_resource ON am_resource=acl_resource.ar_id
				LEFT JOIN acl_right ON am_right=acl_right.ar_id
				LEFT JOIN acl_user_group ON am_group=aug_group 
				LEFT JOIN acl_user ON aug_user=au_id
				WHERE am_system=$system AND am_grant=1 AND acl_user.au_login<>''
				GROUP BY $groupby;
				
				INSERT INTO $tempname
				SELECT $fields
				FROM acl_matrix
				LEFT JOIN acl_resource ON am_resource=acl_resource.ar_id
				LEFT JOIN acl_right ON am_right=acl_right.ar_id 
				LEFT JOIN acl_user ON am_user=au_id
				WHERE am_system=$system AND am_grant=1 AND acl_user.au_login<>''
				AND $token NOT IN (SELECT a_token FROM $tempname);
				
				DELETE FROM $tempname WHERE
				(a_system,a_resource,a_resource_id,a_right,a_login) IN
				(SELECT
					cast ('$as_name' AS varchar(40)) AS a_system,
					acl_resource.ar_name AS a_resource,
					am_resource_id AS a_resource_id,
					acl_right.ar_name AS a_right,
					acl_user.au_login AS a_login
				FROM acl_matrix
				LEFT JOIN acl_resource ON am_resource=acl_resource.ar_id
				LEFT JOIN acl_right ON am_right=acl_right.ar_id 
				LEFT JOIN acl_user ON am_user=au_id
				WHERE am_system=$system AND am_grant=0 AND acl_user.au_login<>''
				);
				
				";

		$this->adb->execute($sql);

		//echo $sql;

		$sql="	DROP INDEX IF EXISTS ${name}_token_key;
				DROP INDEX IF EXISTS ${name}_resource_key;

				CREATE UNIQUE INDEX ${name}_token_key ON $tempname(a_token);
				CREATE INDEX ${name}_resource_key ON $tempname(a_resource,a_resource_id,a_right);
				DROP TABLE IF EXISTS $name;
				ALTER TABLE $tempname RENAME TO $name;

				UPDATE acl_system SET as_last_save=EXTRACT(EPOCH FROM CURRENT_TIMESTAMP) WHERE as_id=$system
				";
		$this->adb->execute($sql);

		//echo $sql;

		$this->log("system save",1);
		$this->session['acl']=array();
	}


	function redirect($path='',$redirect_right='',$redirect_resource='',$redirect_id='')
	{
		if (strlen($path))
		{
			if (!strlen($this->session['redirect.path']))
			{
				$this->debug("adding redirect path: $path");
				$this->session['redirect.path']=$path;
				$this->session['redirect.right']=$redirect_right;
				$this->session['redirect.resource']=$redirect_resource;
				$this->session['redirect.id']=$redirect_id;
			}

		}
		elseif (isset($this->session['redirect.path']) && strlen($this->session['redirect.path'])) 
		{
			if (strlen($this->session['redirect.right']))
			{
				if (!$this->hasRight($this->session['redirect.right'],$this->session['redirect.resource'],$this->session['redirect.id'])) return;
			}
			Header('Location: '.$this->session['redirect.path']);
			$this->session['redirect.path']='';
			$this->close();
			die();

		}

		//$right,$resource,$id=''

	}



	function resourceId($resource)
	{
		$system=$this->system;

		$sql="SELECT ar_id FROM acl_resource WHERE ar_system=$system AND ar_name='$resource'";
		parse_str($this->adb->query2url($sql));

		return $ar_id;
		
	}


	function rightId($right)
	{
		$system=$this->system;

		$sql="SELECT ar_id FROM acl_right WHERE ar_system=$system AND ar_name='$right'";
		parse_str($this->adb->query2url($sql));

		return $ar_id;
		
	}


	function puke_debug_as_comment($return=false)
	{
		if (!count($this->session['debug'])) return;

		$ile=0+ACL_DEBUG_COUNT;

		while ($ile && count($auth_acl->session['debug']) > $ile )
		{
			$ak=array_keys($this->session['debug']);
			unset($this->session['debug'][$ak[0]]);
		}
		
		$wynik="\n<!--\n".implode("\n",$this->session['debug'])."\n-->";		
		if ($return) return $wynik;
		echo $wynik;
	}

}


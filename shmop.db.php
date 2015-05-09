<?php
class SCHMOP_DB
{
	public static $size=1000000;
	public static $deadlock_time=10000;

	protected $id;
	protected $mylock;

	public function __construct($name)
	{
		$key=crc32($name.'63');

		$this->id=shmop_open($key, "c", 0666, self::$size);
		$this->mylock=false;
	}


	protected function lock($locker='')
	{
		if ($this->mylock) return;
		$deadlock=self::$deadlock_time;
		while (0+shmop_read ($this->id ,0 ,1) && $deadlock--)  usleep(20);
		if ($deadlock<=0) echo "DEADLOCK $locker\n";
		shmop_write ($this->id,'1',0 );
		$this->mylock=true;
	}

	protected function unlock()
	{
		shmop_write ($this->id,'0',0);
		$this->mylock=false;
	}

	protected function get_array()
	{
		$size=0+shmop_read($this->id ,1 ,strlen(self::$size));
		if ($size)
		{
			$a=unserialize(shmop_read($this->id ,1+strlen(self::$size),$size));
		}
		else
		{
			$a=array();
		}

		return $a;
	}

	protected function write($a)
	{
		$as=serialize($a);
		$size=substr(strlen($as).'                         ',0,strlen(self::$size));

		if ($size+1+strlen(self::$size) > self::$size)
		{
			echo "SHMOP PANIC: ".$size."\n";
			return;
		}
		shmop_write ($this->id,$size,1);	

		shmop_write ($this->id,$as,1+strlen(self::$size));
	
		//echo "SHMOP: ".$size."\n";
	}

	public function insert($data=array())
	{
		$this->lock('insert');

		$a=$this->get_array();
		$max=1;
		if (count($a)) $max+=max(array_keys($a));
		$a[$max]=$data;

		$this->write($a);

		$this->unlock();

		return $max;
	}

	public function update($key, $set, $value=null)
	{
		$this->lock('update');
		$a=$this->get_array();

		if (isset($a[$key]))
		{
			if (is_array($set)) 
			{
				foreach ($set AS $k=>$v) $a[$key][$k]=$v;
			}
			else 
			{
				$a[$key][$set]=$value;
			}

			$this->write($a);
		}
		

		$this->unlock();
	}


	public function array2url($a)
	{
		$url='';

		foreach($a AS $k=>$v)
		{
			if (strlen($url)) $url.='&';
			$url.=$k.'='.urlencode($v);
		}	
		return $url;
	}	

	public function select($s=null)
	{
		$this->lock('select');
		$a=$this->get_array();
		$this->unlock();

		if (is_null($s)) return $a;
		elseif (is_integer($s)) return $a[$s];
		elseif (is_array($s) && is_array($a) && count($a) )
		{
			foreach ($a AS $i=>$rek)
			{
				$ok=true;
				foreach ($s AS $where)
				{
					if (!is_array($where)) $where=array($where);
					$k=$where[0];
					if (!isset($rek[$k]))
					{
						$ok=false;
						break;
					}
					if (!isset($where[1]))
					{
						if (!$rek[$k])
						{
							$ok=false;
							break;
						}
					}
					else
					{
						$operator = isset($where[2])?$where[2]:'==';
						$val=is_string($where[1])?"'".$where[1]."'":$where[1];
						$cond = '$rek[\''.$k.'\']'.$operator.$val;
						$str2eval='$ok = '.$cond.';';
						eval ($str2eval);
						//echo "$str2eval ... $ok\n";
						if (!$ok) break;
					}

					

				}
				if (!$ok) unset($a[$i]);
				
			}
		}

		return $a;
	}

	public function delete($s=null)
	{
		$this->lock('delete 1');
		$a=$this->get_array();

		if (is_null($s)) $a=array();
		elseif (is_integer($s)) {if (isset($a[$s])) unset($a[$s]);}
		else foreach ($this->select($s) AS $k=>$v) {if (isset($a[$k])) unset($a[$k]);}

		$this->lock('delete 2');
		$this->write($a);
		$this->unlock();
		
	}
}


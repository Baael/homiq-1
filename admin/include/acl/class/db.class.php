<?


class ACL_RES
{
	var $type;
	var $res;
	var $count=-1;

	function ACL_RES($dbtype,$res)
	{
		$this->type=$dbtype;
		$this->res=$res;

		if ($res) $this->count=$this->RecordCount();
	}

	function close()
	{
		settype($this, 'null');
	}


	function RecordCount()
	{
		if ($this->count!=-1) return $this->count;
		switch ($this->type)
		{
			case 'postgres':
				return pg_numRows($this->res);

		}
	}

	function row($row)
	{
		switch ($this->type)
		{
			case 'postgres':
				return pg_fetch_row($this->res,$row);

		}
	}

	function fields()
	{
		switch ($this->type)
		{
			case 'postgres':
				return pg_NumFields($this->res);

		}
		
	}

	function field($col)
	{
		switch ($this->type)
		{
			case 'postgres':
				return pg_FieldName($this->res,$col);

		}
	}
}


class ACL_DB
{
	var $type;
	var $_connectionID=0;
	var $_connectionSTR='';
	var $debug=null;
	var $connected=false;
	var $anyquery=false;

	var $last;



	function ACL_DB($C_DB_CONNECT_DBTYPE,$C_DB_CONNECT_HOST='*', $C_DB_CONNECT_USER='*',$C_DB_CONNECT_PASSWORD='*', $C_DB_CONNECT_DBNAME='*')
	{
		if (is_resource($C_DB_CONNECT_DBTYPE))
		{
			$this->connected=true;
			$this->_connectionID=$C_DB_CONNECT_DBTYPE;
			$this->_connectionSTR=$C_DB_CONNECT_HOST;
			$C_DB_CONNECT_DBTYPE=get_resource_type($this->_connectionID);
		}
		if (strstr($C_DB_CONNECT_DBTYPE,'pgsql')) $C_DB_CONNECT_DBTYPE='postgres.db';

		$this->type=$C_DB_CONNECT_DBTYPE;
			
		$this->now=time();
		$this->timer_total=$this->microtime_float();


		switch ($this->type)
		{
			case 'postgres':
				if ($C_DB_CONNECT_USER=='*') 
				{
					$this->_connectionID=pg_Connect($C_DB_CONNECT_HOST);
					$this->_connectionSTR=$C_DB_CONNECT_HOST;
				}
				else
				{
					$h=explode(':',$C_DB_CONNECT_HOST);
					if (!strlen($h[1])) $h[1]='5432';
					$this->_connectionSTR="host=$h[0] port=$h[1] user=$C_DB_CONNECT_USER password=$C_DB_CONNECT_PASSWORD dbname=$C_DB_CONNECT_DBNAME";
					$this->_connectionID=@pg_Connect($this->_connectionSTR);
					if (!$this->_connectionID) return null;
					break;
				}

			case 'postgres.db':
				$this->type='postgres';
				break;
		}
	}

	function debug($txt)
	{
		if (is_array($this->debug))
		{
			$this->debug[]=date('H:i:s, ').'[DB]: '.$txt;
		}
	}


	function connect()
	{
		switch ($this->type)
			{
				case 'postgres':
					$this->_connectionID=@pg_Connect($this->_connectionSTR);
					if ($this->_connectionID) $this->connected=true;
					break;

			}
		return $this->_connectionID;
	}


	function db()
	{
		return $this->_connectionID;
	}


	function execute($query)
	{
		$wynik = null;


		if (!$this->connected) $this->connect();
		if (!$this->anyquery)
		{
			$this->anyquery=true;
			$this->debug('connecting due to '.str_replace("\n",' ',$query));
			
		}
		switch ($this->type)
		{
			case 'postgres':
				$res=pg_exec($this->_connectionID,$query);
				if ($res)
				{
					$wynik=new ACL_RES($this->type,$res);
				}
				$this->last['sql']=$query;
				$this->last['res']=$wynik;
				break;
		}

		
		return $wynik;
	}

	
	function microtime_float() 
	{ 
   		list($usec, $sec) = explode(" ", microtime()); 
   		return ((float)$usec + (float)$sec); 
	} 

	


	function query2url($query)
	{
		$wynik='';
		$result=$this->Execute($query);
		
		if (!$result) return;
		if ( $result->RecordCount()>0 ) $wynik=$this->ExplodeName($result,0);
		$result->Close();
		return ($wynik);
	}

 	function ExplodeName ($result,$row)
 	{
		$text="";
		$cols=$result->fields();
		$data=$result->row($row);

		
		for ($i=0;$i<$cols;$i++)
		{
			$name=$result->field($i);
			$value=urlencode(trim($data[$i]));
			$text.="$name=$value";
			if ($i!=$cols-1) $text.="&";
		}
		if ($row==$result->RecordCount()-1) $result->Close();

		return $text;
	}






	function close()
	{
		switch ($this->type)
		{
			case 'postgres':
				pg_close($this->_connectionID);
				break;
		}
	}




}


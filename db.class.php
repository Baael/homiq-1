<?php


class RES
{
	var $type;
	var $res;
	var $count=-1;

	function RES($dbtype,$res)
	{
		$this->type=$dbtype;
		$this->res=$res;

		if ($res) $this->count=$this->RecordCount();
	}

	function close()
	{
		//settype(&$this, 'null');
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

class HDB
{
	var $type;
	var $_connectionID=0;
	var $debug=0;
	var $_connectionSTR='';

	var $last;




	function HDB($C_DB_CONNECT_DBTYPE,
				 $C_DB_CONNECT_HOST, $C_DB_CONNECT_USER, 
				 $C_DB_CONNECT_PASSWORD, $C_DB_CONNECT_DBNAME)
	{

		$this->type=$C_DB_CONNECT_DBTYPE;
		
			
		$this->now=time();
		$this->timer_total=$this->microtime_float();

		switch ($this->type)
		{
			case 'postgres':
				$h=explode(':',$C_DB_CONNECT_HOST);
				if (!isset($h[1])) $h[1]='5432'; 
				$this->_connectionSTR="host=$h[0] port=$h[1] user=$C_DB_CONNECT_USER password=$C_DB_CONNECT_PASSWORD dbname=$C_DB_CONNECT_DBNAME";
				$this->_connectionID=@pg_Connect($this->_connectionSTR);
				if (!$this->_connectionID) return null;
				break;
		}

	
	}


	function debug($q,$t0)
	{
		if (!$this->debug) return;

		$plik=fopen('/tmp/db-'.getmypid().'.csv','a');
		$q=preg_replace("/[\n\r\t ]+/",' ',$q);
		$t=round($this->microtime_float()-$t0,4);
		fwrite($plik,"$t,".'"'.$q.'"'."\n");
		fclose($plik);
	}




	function execute($query)
	{
		$wynik = null;

		switch ($this->type)
		{
			case 'postgres':
				if ($this->debug) $t0=$this->microtime_float();
				$res=pg_exec($this->_connectionID,$query);
				if ($this->debug) $this->debug($query,$t0);
				if ($res)
				{
					$wynik=new RES($this->type,$res);
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

	


	function ado_query2url($query)
	{
		$wynik='';
		$result=$this->Execute($query);
		
		if (!$result) return;
		if ( $result->RecordCount()>0 ) $wynik=$this->ado_ExplodeName($result,0);
		$result->Close();
		return ($wynik);
	}

 	function ado_ExplodeName ($result,$row)
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

?>

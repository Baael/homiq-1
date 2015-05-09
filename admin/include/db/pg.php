<?php

if (!function_exists("FormatujDate")) {
		function FormatujDate ($d)
		{
		   return substr($d,8,2)."-".substr($d,5,2)."-".substr($d,0,4);
		}
	}
	
	
if (!function_exists("FormatujDateSQL")) {
	function FormatujDateSQL ($d)
	{
	   return substr($d,6,4)."-".substr($d,3,2)."-".substr($d,0,2);
	}
}

if (!function_exists("query2url")) {		
	function query2url($query)
	{
		global $db;
		$result=pg_Exec($db,$query);
		if ( pg_numRows($result)!=1 ) return "";
	
		$data=pg_fetch_row($result,0);
		$wynik="";
		for ($i=0;$i<count($data);$i++)
		{	
			if ($i) $wynik.="&";
			$wynik.=pg_fieldname($result,$i)."=".urlencode(trim($data[$i]));
		}
		return $wynik;
	}
}


if (!function_exists("pg_ExplodeName")) {		
	function pg_ExplodeName ($result,$row)
	{
	 $text="";
	 $cols=pg_NumFields($result);
	 $data=pg_fetch_row($result,$row);
	 for ($i=0;$i<$cols;$i++)
	 {
	  $name=pg_FieldName($result,$i);
	  $value=urlencode(trim($data[$i]));
	  $text.="$name=$value";
	  if ($i!=$cols-1)
	   $text.="&";
	 }
	 return $text;
	}
}


if (!function_exists("pg_ObjectArray")) {		
	function pg_ObjectArray($db,$query)
	{
		$wynik="";
		$result=pg_Exec($db,$query);
		
		$cols=pg_NumFields($result);
		for ($j=0;$j<$cols;$j++) $pola[]=pg_FieldName($result,$j);
		for ($i=0;$i<pg_NumRows($result);$i++)
		{
			$obj=pg_Fetch_Object($result,$i);
			for ($j=0;$j<$cols;$j++) $obj->$pola[$j]=trim($obj->$pola[$j]);
			$wynik[]=$obj;
		}
		return($wynik);
	}
}




?>
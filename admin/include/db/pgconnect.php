<?
	foreach (array('CONST_DB_CONNECT','C_DB_CONNECT') AS $str)
	{
		if (strlen($$str)) 
		{
			$db=@pg_Connect($$str);
			break;
		}
	}


	

?>
<?

	$wynik=array();

	$sql="SELECT o_id,o_state,o_type FROM outputs WHERE o_lastchange>=".$_REQUEST['t'];
	$res=pg_Exec($db,$sql);

	for ($i=0; $i < pg_numRows($res); $i++)
	{
		parse_str(pg_ExplodeName($res,$i));
	
		$wynik[]="o:$o_id:$o_type:$o_state";
	}
	
	$sql="SELECT m_id,m_state,m_type FROM modules WHERE m_lastchange>=".$_REQUEST['t'];
	$res=pg_Exec($db,$sql);

	for ($i=0; $i < pg_numRows($res); $i++)
	{
		parse_str(pg_ExplodeName($res,$i));
	
		$wynik[]="$m_type:$m_id:$m_state";
	}

	$t=$_REQUEST['t']-3;
	$sql="SELECT m_id,m_end>$t AS m_active FROM macro WHERE m_end>=".($_REQUEST['t']-10);
	$res=pg_Exec($db,$sql);

	for ($i=0; $i < pg_numRows($res); $i++)
	{
		parse_str(pg_ExplodeName($res,$i));
	
		$state=($m_active=='t')?'a':'';
		$wynik[]="M:$m_id:$state";
	}


	echo implode(',',$wynik);

<?

	include_once ("$INCLUDE_PATH/cache/javascriptcache.php");
	include_once ("$INCLUDE_PATH/js/selecty/tab2js.php");

	$sql="SELECT m_name AS master_name, m_cid FROM masters";
	$res_masters=pg_Exec($db,$sql);
	for ($i=0; $i < pg_numRows($res_masters); $i++)
	{
		parse_str(pg_ExplodeName($res_masters,$i));

		$sql="SELECT * FROM modules WHERE m_master='$m_cid' AND m_type IN ('I','O')";
		$res_modules=pg_Exec($db,$sql);

		//echo pg_numRows($res_modules).":$sql<br>";

		for ($j=0; $j < pg_numRows($res_modules); $j++)
		{
			parse_str(pg_ExplodeName($res_modules,$j));

			$sql="SELECT * FROM inputs WHERE i_master='$m_cid' AND i_module='$m_adr' ORDER BY i_adr";
			$res_inputs=pg_Exec($db,$sql);

			//echo pg_numRows($res_inputs).":$sql<br>";
			for ($k=0; $k < pg_numRows($res_inputs); $k++)
			{
				parse_str(pg_ExplodeName($res_inputs,$k));
			

				$we[k][]=array($m_cid,$m_adr.'.'.$m_cid,$i_adr.'.'.$m_adr.'.'.$m_cid);
				$we[n][]=array("$master_name [$m_cid]","$m_name [$m_adr]","$i_name [$i_adr]");
			}
		}
	
		$sql="SELECT * FROM modules WHERE m_master='$m_cid' ";
		$res_modules=pg_Exec($db,$sql);
		for ($j=0; $j < pg_numRows($res_modules); $j++)
		{
			parse_str(pg_ExplodeName($res_modules,$j));

			$sql="SELECT * FROM outputs WHERE o_master='$m_cid' AND o_module='$m_adr' ORDER BY o_adr";
			$res_outputs=pg_Exec($db,$sql);
			for ($k=0; $k < pg_numRows($res_outputs); $k++)
			{
				parse_str(pg_ExplodeName($res_outputs,$k));

				$wy[k][]=array($m_cid,$m_adr.'.'.$m_cid,$o_adr.'.'.$m_adr.'.'.$m_cid);
				$wy[n][]=array("$master_name [$m_cid]","$m_name [$m_adr]","$o_name [$o_adr]");
			}

			if (!pg_numRows($res_outputs))
			{
				$wy[k][]=array($m_cid,$m_adr.'.'.$m_cid,'');
				$wy[n][]=array("$master_name [$m_cid]","$m_name [$m_adr]","");
			}
		}		


	}

	$wy[k][]=array('*','*.*','*.*.*');
	$wy[n][]=array("* - wszystkie urządzenia","* - wszystkie moduły","* - wszystkie adresy");

	$jswe=tab2js($we,'we');
	$jswy=tab2js($wy,'wy');

?>



<script language="JavaScript" type="text/javascript"> 

<?=$jswe?>

<?=$jswy?>


selectWeOnChange(null,-1);
selectWyOnChange(null,-1);

</script>
<?
	require (dirname(__FILE__).'/homiq.class.php');


	if ($_SERVER["argc"]!=5) 
	{
		echo $_SERVER["argv"][0]." master cmd val adr\n";
		die();
	}

	$h=new HOMIQ(DEBUG_BASIC,false);
	

	$h->send($_SERVER["argv"][1],$_SERVER["argv"][2],$_SERVER["argv"][3],$_SERVER["argv"][4]);

	$h->close(1);
?>

<?
	require (dirname(__FILE__).'/homiq.class.php');

	$h=new HOMIQ(DEBUG_BASIC,false);

	$h->macro($_SERVER["argv"][1]);

	$h->close(1);
?>

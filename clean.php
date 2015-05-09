<?
	require (dirname(__FILE__).'/homiq.class.php');

	$h=new HOMIQ(0,false);
	$h->cleandb();
	$h->close(1);

?>

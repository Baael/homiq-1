<?
	require (dirname(__FILE__).'/homiq.class.php');


	if (!strlen($_SERVER["argv"][1])) die();

	if (!file_exists($_SERVER["argv"][1])) die();
	
	$h=new HOMIQ(DEBUG_BASIC,false);


	$sql=implode('',file($_SERVER["argv"][1]));
	$h->ado('execute',$sql);

	$h->close(1);
?>

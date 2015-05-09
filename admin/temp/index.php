<?
	$page=0;
	$INCLUDE_PATH=dirname(__FILE__)."/../include";
	include($INCLUDE_PATH.'/pre.php');

	$sql="SELECT * FROM global";
	parse_str(query2url($sql));

	$t=number_format($g_t1,2,',','');
	$oz=$g_empty?'Z':'O';
	$czas=date('H:i');
?>
<?="$t#$oz|$czas#\n"?>
<?=file_get_contents('http://www.promienko.pl/temp/ip.php');?>

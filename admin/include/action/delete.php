<?

	$t=explode(',',$_REQUEST['table']);
	if (!strlen($t[0]) || !strlen($t[1]) ) return;

	$id=$_REQUEST[$t[1]];

	$sql="DELETE FROM $t[0] WHERE $t[1]=$id";
	pg_exec($db,$sql);

	$location_action=$sortowanie;

?>
<?
	if (!$_REQUEST['o_id']) return;

	$sql="SELECT * FROM outputs WHERE o_id=".$_REQUEST['o_id'];
	parse_str(query2url($sql));


	if (!strlen($o_master) || !strlen($o_module) || !strlen($o_adr)) return;

	
	$o_state=$o_state?0:1;
	$sql="UPDATE outputs SET o_state='$o_state' WHERE o_id=$o_id";
	$homiq->send($o_master,'O.'.$o_adr,$o_state,$o_module,0,$sql);
	
	$sql="UPDATE outputs SET o_state=o_state WHERE o_id=$o_id";
	pg_exec($db,$sql);

	$location_action=$sortowanie;

	echo $o_state;
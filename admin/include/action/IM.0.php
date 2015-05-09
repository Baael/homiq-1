<?
	if (!$_REQUEST['i_id']) return;

	$sql="SELECT * FROM inputs WHERE i_id=".$_REQUEST['i_id'];
	parse_str(query2url($sql));


	if (!strlen($i_master) || !strlen($i_module) || !strlen($i_adr)) return;

	$type=($i_type==1)?0:1;

	$homiq->send($i_master,'IM.'.$i_adr,$type,$i_module);
	$sql="UPDATE inputs SET i_type='$type' WHERE i_id=$i_id";
	pg_exec($db,$sql);

	$location_action=$sortowanie;
?>
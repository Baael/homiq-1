<?
	if (!$_REQUEST['m_id']) return;

	$sql="SELECT * FROM modules WHERE m_id=".$_REQUEST['m_id'];
	parse_str(query2url($sql));


	if (!strlen($m_master) || !strlen($m_serial)) return;

	if (!strlen($m_adr)) $m_adr=$homiq->newmodule($m_master);

	$homiq->send($m_master,'ID.0',$m_adr,$m_serial);
	$sql="UPDATE modules SET m_adr='$m_adr' WHERE m_id=$m_id";
	pg_exec($db,$sql);

	$location_action=$sortowanie;
?>
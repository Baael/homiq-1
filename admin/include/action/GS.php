<?
	if (!$_REQUEST['m_id']) return;

	$sql="SELECT * FROM modules WHERE m_id=".$_REQUEST['m_id'];
	parse_str(query2url($sql));


	if (!strlen($m_master) || !strlen($m_adr)) return;

	$homiq->send($m_master,'GS','1',$m_adr);
	$location_action=$sortowanie;
?>
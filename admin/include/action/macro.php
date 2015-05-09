<?
	if (!$_REQUEST['m_id']) return;

	$sql="SELECT * FROM macro WHERE m_id=".$_REQUEST['m_id'];
	parse_str(query2url($sql));

	$homiq->macro($m_symbol);

	$location_action=$sortowanie;
?>
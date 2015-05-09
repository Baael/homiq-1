<?
	if (!$_REQUEST['m_id']) return;

	$sql="SELECT * FROM modules WHERE m_id=".$_REQUEST['m_id'];
	parse_str(query2url($sql));


	if (!strlen($m_master) || !strlen($m_adr)) return;



	

	$postsql='';
	switch ($_REQUEST['action'])
	{
		case 'u':
			$newstate='u';
			$postsql="UPDATE modules SET m_state='U' WHERE m_id=$m_id";
			break;

		case 'd':
			$newstate='d';
			$postsql="UPDATE modules SET m_state='D' WHERE m_id=$m_id";
			break;

		case 's':
			switch ($m_state)
			{
				case 'u':
					$newstate='U';
					break;
				case 'd':
					$newstate='D';
					break;
				default:
					$newstate=$m_state;

			}
			break;


	}
	$homiq->send($m_master,'UD',$_REQUEST['action'],$m_adr,0,"UPDATE modules SET m_state='$newstate' WHERE m_id=$m_id");

	$t=time();

	$sql="DELETE FROM send WHERE s_master='$m_master' AND s_top='s' AND s_dst='$m_adr' AND s_queue>$t";
	pg_exec($db,$sql);

	if (strlen($postsql) && $m_sleep>0) $homiq->send($m_master,'UD','s',$m_adr,$m_sleep,$postsql);

	$location_action=$sortowanie;

	echo $newstate;
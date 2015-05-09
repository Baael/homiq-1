<?
	global $hf_editmode;

	if (!$hf_editmode) return;

	require_once(dirname(__FILE__).'/fun.php');


	echo "<b>ACL foot for kameleon, user: ".$acl->login.'</b>';

	if (!$acl->system)
	{
		$acl->initdb();
		return;
	}



	$sql="SELECT * FROM acl_system WHERE as_id=".$acl->system;
	$res=@$acl->adb->execute($sql);
	if (!$res)
	{
		$acl->initdb();
		return;
	}

	if (!acl_hasPageRight($page,PAGE_GRANT_RIGHT)) return;

	if (is_array($_REQUEST['prawa'][$sid]))
	{
		$acl->matrix($_REQUEST['prawa'][$sid]);
	}


?>
<form method="post" action="<?=$self?>">

<?
	include(dirname(__FILE__).'/matrix.php');
?>

<input type="submit" class="k_button" value="zapisz">
</form>

<?
	$sql="SELECT * FROM acl_system WHERE as_id=".$acl->system;
	parse_str($acl->adb->query2url($sql));

	if ($as_last_save<$as_last_update) $zapisac=" - trzeba zapisać zmiany";
?>
<a href="<?=$INCLUDE_PATH?>/acl/index.php/system/system/<?=$acl->system?>/return_href/<?=base64_encode($_SERVER['REQUEST_URI'])?>">Zarządzanie<?=$zapisac?></a>


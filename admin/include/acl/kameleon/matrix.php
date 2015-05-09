<?

	require_once(dirname(__FILE__).'/fun.php');

	if (!strlen($RESOURCE)) 
	{
		$RESOURCE=PAGE_RESOURCE;
		$RESOURCE_ID=$page;
	}

	if (!is_array($exclude_rights)) $exclude_rights=array();

	$system=$acl->system;

	$acl_right=$acl->session['cache']['rights.'.$system];

	if (!is_array($acl_right))
	{
		$acl_right=array();

		$sql="SELECT * FROM acl_right WHERE ar_system=$system ORDER BY ar_name";
		$res=$acl->adb->execute($sql);
		if ($res)
		{
			$count=$res->RecordCount();
			if ($res) for ($i=0;$i<$count;$i++)
			{
				$url=$acl->adb->explodeName($res,$i);
				parse_str($url);

				$acl_right[]=array('am_right'=>$ar_id,'right'=>$ar_name);
			}

		}
		$acl->session['cache']['rights.'.$system]=$acl_right;
	}

	$acl_group=$acl->session['cache']['groups.'.$system];

	if (!is_array($acl_group))
	{
		$acl_group=array();

		$sql="SELECT * FROM acl_group WHERE ag_system=$system ORDER BY ag_name";
		$res=$acl->adb->execute($sql);
		$count=$res->RecordCount();
		if ($res) for ($i=0;$i<$count;$i++)
		{
			$url=$acl->adb->explodeName($res,$i);
			parse_str($url);
			$acl_group[]=array('am_group'=>$ag_id,'group'=>$ag_name);
		}

		$acl->session['cache']['groups.'.$system]=$acl_group;
	}

	$am_resource=$acl->resourceAdd($RESOURCE);


?>


<table cellspacing="0" border="1">
<tr>
	<th rowspan="2"><?=$acl->label('groups',$lang)?></th>
	<th colspan="<?=count($acl_right)-count($exclude_rights)?>"><?=$acl->label('this element',$lang)?></th>
	<?php if (isset($_SERVER['tree'])) : ?>
	<th colspan="<?=count($acl_right)-count($exclude_rights)?>"><?=$acl->label('tree',$lang)?> <?=$RESOURCE_ID;?>+</th>
	<?php endif ?>

</tr>
<tr>
	<? 
			foreach ($acl_right AS $r) if (!in_array($r['right'],$exclude_rights)) echo "	<th>".$acl->label('right_'.$r['right'],$lang)."</th>\n";
			if (isset($_SERVER['tree'])) foreach ($acl_right AS $r) if (!in_array($r['right'],$exclude_rights)) echo "	<th>".$acl->label('right_'.$r['right'],$lang)."</th>\n";
	?>

</tr>
<?
	$tree2=ereg_replace("([0-9]):","\\1+,",substr($tree,1));
	$tree2=explode(',',$tree2);

	foreach ($acl_group AS $g)
	{
		echo "<tr>\n	<td>$g[group]</td>\n";
	

		foreach ($acl_right AS $r) 
		{
			if (in_array($r['right'],$exclude_rights)) continue;

			$name="prawa[$RESOURCE_ID][group][$g[am_group]][right][$r[am_right]][resource][$am_resource][resource_id][$RESOURCE_ID]";
			$checked=$acl->hasRightMatrix($r['am_right'],$am_resource,"$RESOURCE_ID",0,$g['am_group']) ? 'checked' : '';

			$td="<input type=\"hidden\" name=\"$name\" value=\"0\"/><input type=\"checkbox\" name=\"$name\" value=\"1\" $checked/>";
			if ($acl->hasRightMatrix($r['am_right'],$am_resource,$tree2,0,$g['am_group']) ) $td='+';
			echo "	<td>$td</td>\n";
		}

		if (isset($_SERVER['tree'])) foreach ($acl_right AS $r) 
		{
			if (in_array($r['right'],$exclude_rights)) continue;

			$name="prawa[$RESOURCE_ID][group][$g[am_group]][right][$r[am_right]][resource][$am_resource][resource_id][$RESOURCE_ID+]";
			$checked=$acl->hasRightMatrix($r['am_right'],$am_resource,"$RESOURCE_ID+",0,$g['am_group']) ? 'checked' : '';
	
			$td="<input type=\"hidden\" name=\"$name\" value=\"0\"/><input type=\"checkbox\" name=\"$name\" value=\"1\" $checked/>";
			if ($acl->hasRightMatrix($r['am_right'],$am_resource,$tree2,0,$g['am_group']) ) $td='+';
			echo "	<td>$td</td>\n";
		}

	
		echo "</tr>\n";
	}


?>

</table>

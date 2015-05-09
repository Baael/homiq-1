<?

	$update=array();
	foreach ($_REQUEST AS $nazwa=>$a) if (is_array($a))
	{
		$c='';
		$sql="SELECT count(*) AS c FROM $nazwa";
		@parse_str(query2url($sql));



		if (!strlen($c)) continue;	
		
		foreach ($a AS $k=>$v)
		{
			$_k=explode('_',$k);
			if ($_k[1]=='id')
			{
				$update[$nazwa]['keyname']=$k;
				$update[$nazwa]['keyvalue']=$v;
				continue;
			}
			$v=addslashes(stripslashes($v));
			$update[$nazwa]['inserts'][]=$k;
			$update[$nazwa]['values'][]="'$v'";
			$update[$nazwa]['set'][]="$k='$v'";
		}
	}

	//print_r($update);
	//print_r($_REQUEST);

	foreach ($update AS $table=>$v)
	{
		if ($v['keyvalue']) $sql="UPDATE $table SET ".implode(',',$v['set']).' WHERE '.$v['keyname'].'='.$v['keyvalue'];
		else $sql="INSERT INTO $table (".implode(',',$v['inserts']).") VALUES (".implode(',',$v['values']).")";

		if (is_array($v['set']) && count($v['set'])) if (!pg_exec($db,$sql)) echo $sql;
	}

	$location_action=array_merge($sortowanie,array('m_id'=>'*'));

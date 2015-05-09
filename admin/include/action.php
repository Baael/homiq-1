<?
	ob_start();
	$action=$_REQUEST['action'];

	

	$sortowanie=array('f'=>'*','orderby'=>'*','orderhow'=>'*','strona'=>'*','crc'=>'*');

	if (strlen($_REQUEST['dontforget']))
	{
		$dontforget=explode(',',$_REQUEST['dontforget']);
		foreach ($dontforget AS $df)
		{
			if (strlen($_REQUEST[$df])) $sortowanie[$df]=$_REQUEST[$df];
		}
	}

	$previous_action="";
	while( strlen($action) && !strlen($error) && $action!=$previous_action )
	{
		$previous_action=$action;
		$INCLUDE_PATH_ACTION="$INCLUDE_PATH/action/$action.php";

		if (file_exists($INCLUDE_PATH_ACTION))
		{
			include($INCLUDE_PATH_ACTION);
		}
		else
		{
			$error="Brak: $INCLUDE_PATH_ACTION";
			break;
		}
	}
	$action="";

	if (strlen($error))
	{
		echo "<script>alert('$error');history.go(-1);</script>";
		die();
	}


	$rzygi=ob_get_contents();
	ob_end_clean();


	if ($_REQUEST['ajax_action'])
	{
		echo $rzygi;
		ob_start();
		include("$INCLUDE_PATH/post.php");
		ob_end_clean();
		die();
	}


	if (is_array($location_action) && !$KAMELEON_MODE && strlen($rzygi)<10)
	{
		$link='';
		foreach ($location_action AS $k=>$v)
		{
			if ($v=='*') $v=$_REQUEST[$k];
			if (is_array($v))
			{
				foreach ($v AS $kk=>$vv)
				{
					if (!strlen($vv)) continue;
					if (strlen($link)) $link.='&';
					$link.=urlencode("${k}[$kk]").'='.urlencode($vv);
				}
				continue;

			}
			if (!strlen($v)) continue;
			if (strlen($link)) $link.='&';			
			$link.=urlencode($k).'='.urlencode($v);
		}
		if (strlen($link)) $link="?$link";
		Header ("Location: ".$_SERVER['SCRIPT_NAME']."$link");
		die();
	}

	if (strlen($rzygi)) echo "<pre>$rzygi</pre>";

	$_REQUEST['action']='';
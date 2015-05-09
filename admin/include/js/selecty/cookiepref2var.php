<?
global $_COOKIE;
if (is_array($_COOKIE[pref]))
{
	global $HTTP_GET_VARS,$HTTP_POST_VARS;

	//print_r($_COOKIE[pref]);

	reset($_COOKIE[pref]);
	while (list($token,$val) = each ($_COOKIE[pref]) )
	{
		eval ("global \$$token ;");
		$cmd="if (!isset(\$$token)) \$$token = \$val;";
		eval ($cmd);
		if (!isset($HTTP_GET_VARS[$token])) $HTTP_GET_VARS[$token]=$val;
		if (!isset($HTTP_POST_VARS[$token])) $HTTP_POST_VARS[$token]=$val;
		if (!isset($_REQUEST[$token])) $_REQUEST[$token]=$val;
	}

}
?>
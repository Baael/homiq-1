<?
	Header('Content-Type: application/x-javascript');

	if (is_array($_COOKIE[pref]))
	{
		reset($_COOKIE[pref]);
		while (list($token,$val) = each ($_COOKIE[pref]) )
		{
			if (!is_array($val)) 
			{
				echo "Preferencje['$token']='$val';\n";
			}
		}
	}
?>
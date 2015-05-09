<?
	if (strlen($CACHE_PAGES_TOKEN))
	{
		cacheJS($CACHE_PAGES_TOKEN,ob_get_contents());
		ob_end_flush();
		cacheJS($CACHE_PAGES_TOKEN, '',true);
	}
?>
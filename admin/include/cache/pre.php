<?
	include_once("$INCLUDE_PATH/cache/javascriptcache.php");
	$CACHE_PAGES_TOKEN='';

	if ($KAMELEON_MODE || $WEBTD->sid || $BAT_MODE || $JS_MODE || !strlen($_SERVER['REMOTE_ADDR'])) return;


	// Wymagane jest ustawienie zmiennej $CACHE_PAGES_DIR

	if ( is_array($_POST) && count($_POST) ) return;
	if (!strlen($CACHE_PAGES_DIR)) return;

	$md5=md5($_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_FILENAME"]);
	if ($CACHE_IGNORE_HTTP_HOST) $md5=md5($_SERVER["SCRIPT_FILENAME"]);

	$CACHE_PAGES_TOKEN="$CACHE_PAGES_DIR/$md5.page.$page";

	if (is_array($_GET) && count($_GET)) $CACHE_PAGES_TOKEN.='.'.base64_encode($_SERVER["QUERY_STRING"]);

	$CACHE_PAGES_TOKEN.='.html';

	if (cacheJS($CACHE_PAGES_TOKEN))
	{
		echo cacheContent($CACHE_PAGES_TOKEN);
		cacheJS($CACHE_PAGES_TOKEN, '',true);
		exit();
	}

	ob_start();
?>

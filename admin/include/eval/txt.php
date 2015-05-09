<?
$txt=ob_get_contents();
$_REQUEST[$costxt]=$txt;
ob_end_clean();ob_start();
?>
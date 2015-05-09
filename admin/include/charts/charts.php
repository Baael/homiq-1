<?

	$IP=$KAMELEON_MODE?$INCLUDE_PATH:$REMOTE_INCLUDE_PATH;

	$path=$IP.'/charts';

	$r='';
	$_xml="$path/sample.xml";
	if (strlen($costxt))
	{
		$_xml=urlencode("$IP/$costxt");
		$r="+'".(strstr($xml,'?')?'&':'?')."r='+Math.random()";
	}

?>


<script language="javascript">AC_FL_RunContent = 0;</script>
<script language="javascript"> DetectFlashVer = 0; </script>
<script src="<?=$path?>/AC_RunActiveContent.js" language="javascript"></script>
<script language="JavaScript" type="text/javascript"> 
<!--
var requiredMajorVersion = 9;
var requiredMinorVersion = 0;
var requiredRevision = 45;

-->
</script>
 
 
<script language="JavaScript" type="text/javascript"> 
<!--
function chartXmlAdd()
{
	if (typeof(chartXmlAdd_<?=$sid?>)=='function') return chartXmlAdd_<?=$sid?>();
	return '';
}

if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '<?=$WEBTD->width?>',
			'height', '<?=$WEBTD->size?>',
			'scale', 'noscale',
			'salign', 'TL',
			'bgcolor', '#777788',
			'wmode', 'opaque',
			'movie', '<?=$path?>/charts',
			'src', '<?=$path?>/charts',
			'FlashVars', 'library_path=<?=$path?>/charts_library&xml_source=<?=$_xml?>'+chartXmlAdd(), 
			'id', 'my_chart',
			'name', 'my_chart',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}
// -->
</script>

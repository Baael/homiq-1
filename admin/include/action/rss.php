<?php
	if ($KAMELEON_MODE) 
	{
		ob_start();
	}

	$sql="SELECT * FROM global";
	parse_str(query2url($sql));

	$t=number_format($g_t1,2,',','');

	$img='';

	$host='http://'.$_SERVER['HTTP_HOST'];

	if ($g_alarm) $img.='<img src="'.$host.'/images/alarm.png" />';
	if (!$g_empty)  $img.='<img src="'.$host.'/images/fullhouse.png" />';

	if ($g_daylight) $img.='<img src="'.$host.'/images/dzien.png" />';
	else $img.='<img src="'.$host.'/images/noc.png" />';

	echo '<?xml version="1.0" encoding="UTF-8" ?>';



?>
<rss version="2.0">
<channel>
        <title>Temperatura</title>
        <description>Temperatura w domu</description>
        <link>http://piaskowa.promienko.pl/</link>
        <lastBuildDate><?=date('r')?></lastBuildDate>
        <pubDate><?=date('r')?></pubDate>
 
        <item>
                <title><![CDATA[<?=$t?> °C]]></title>
                <description><![CDATA[<?=$img?>]]>.</description>
                <link><?=$host?>/promienko/</link>
                <guid>temp</guid>
                <pubDate><?=date('r')?></pubDate>
        </item>
 
</channel>
</rss>
<? 

	if ($KAMELEON_MODE) 
	{
		$txt=htmlspecialchars(ob_get_contents());
		ob_end_clean();

		echo "</div><pre>$txt";
	}


	die();

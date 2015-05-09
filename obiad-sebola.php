<?
include_once(dirname(__FILE__).'/str_to_url_utf.php');

$obiady=file_get_contents("http://ssp4.pl/index.php?option=com_content&view=article&id=1019&Itemid=102");

//$obiady=file_get_contents("http://ssp4.pl/index.php?view=article&catid=114%3Amenu&id=1019%3Amenu-obiadowe-szkolne&tmpl=component&print=1&layout=default&page=&option=com_content&Itemid=102");

$obiady=substr($obiady,strpos($obiady,"MENU OBIADOWE SZKOLNE - TYDZIE"));

$token='alamakota';
$obiady=preg_replace('/([0-9]*[0-9]\.[0-9][0-9]\.[0-9][0-9][0-9][0-9])/',$token.'\\1',$obiady);


$t=time();
//$t=strtotime('04-02-2012');

while(1)
{
	$pos=strpos($obiady,$token);
	if (!$pos) break;
	$obiady=substr($obiady,$pos+strlen($token));
	$data=str_replace('.','-',substr($obiady,0,10));

	$data = preg_replace("/[^0-9\-]/",'',$data)." 23:59:59";

	if (strtotime($data)>$t) break;

}


if (strtotime($data)<$t) die();

//die($data);
$haczyk='valign="top" width="461">';

$obiady=substr($obiady,strpos($obiady,$haczyk)+strlen($haczyk));

$obiady=substr($obiady,0,strpos($obiady,'</td>'));

$obiady=preg_replace('/<!--.*-->/','',$obiady);
$obiady=trim(preg_replace('/<[^>]*>/',"",$obiady));



$txt=urlencode(str_to_url($obiady));
$nr=48502288002;
//$nr=48601704847;



$url="http://api.gsmservice.pl/send.php?login=pudel&pass=spierdalaj&recipient=$nr&text=$txt&type=1&sender=Szkola";

//die($url);

//file($url);


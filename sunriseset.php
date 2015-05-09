#!/usr/bin/php
<?
	require (dirname(__FILE__).'/homiq.class.php');

	$text=implode('',file('http://www.gaisma.com/en/location/poznan.html'));

	$pos=strpos($text,'Today');
	if (!$pos) return;

	$text=substr($text,$pos,100);

	#echo "$text\n";
	$text=ereg_replace('[^0-9]*([0-9][0-9]:[0-9][0-9])[^0-9]*([0-9][0-9]:[0-9][0-9]).*',"\\1,\\2",$text);
	echo $text;

	
	$sunriseset=explode(',',$text);

	$sunrise=explode(':',$sunriseset[0]);
	$sunset=explode(':',$sunriseset[1]);


	$h=new HOMIQ(0,false);
	if (strlen($sunrise[0]) && strlen($sunrise[1]) )
	{
		$sh=$sunrise[0]+0;
		$sm=$sunrise[1]+0;
		$sql="UPDATE cron SET c_hour='$sh', c_min='$sm' WHERE c_symbol='sunrise'";
		$h->adodb->execute($sql);
	}
	if (strlen($sunset[0]) && strlen($sunset[1]) )
	{
		$sh=$sunset[0]+0;
		$sm=$sunset[1]+0;
		$sql="UPDATE cron SET c_hour='$sh', c_min='$sm' WHERE c_symbol='sunset'";
		$h->adodb->execute($sql);
	}

	if (strlen($sunriseset[0]) && strlen($sunriseset[1]))
	{
		$sql="INSERT INTO sunriseset (s_rise,s_set) VALUES ('$sunriseset[0]','$sunriseset[1]')";
		$h->adodb->execute($sql);
	}

	$h->close(1);

?>

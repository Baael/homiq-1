<?
	$INCLUDE_PATH=dirname(__FILE__).'/admin/include';

	include($INCLUDE_PATH.'/pre.php');

	$sql="SELECT * FROM global";
	parse_str(query2url($sql));



	if ($g_watch ) 
	{
		$sql="SELECT max(a_time) AS t FROM alarms";
		parse_str(query2url($sql));
		#if (time()-$t > 900 ) system('/home/homiq/alarm.sh kamera');
		$sql="INSERT INTO alarms (a_opis) VALUES ('kamera - wiata')";
		pg_exec($sql);
		return;
	}

	$name='/home/homiq/kamera/rm-'.time().'.sh';
	$plik=fopen($name,'w');
	fwrite($plik,'cd '.dirname($name)."\n");
	fwrite($plik,"sleep 60\n");
	fwrite($plik,'mv 00B80000B670\(002cohb\)_1_'.date('YmdHi',time()-60)."* 24\n");
	fwrite($plik,'mv 00B80000B670\(002cohb\)_1_'.date('YmdHi')."* 24\n");
	fwrite($plik,'mv 00B80000B670\(002cohb\)_1_'.date('YmdHi',time()+60)."* 24\n");
	fwrite($plik,"rm -f $name\n");
	fclose($plik);

	system("sh $name >/dev/null 2>/dev/null &");


	$dir = dirname($name)."/24";

	if (is_dir($dir)) 
	{
		if ($dh = opendir($dir)) 
		{
			while (($file = readdir($dh)) !== false) 
			{
				if ($file[0]=='.' || $file=='index.php') continue;

				//if (filemtime ("$dir/$file")+1*24*3600<time()) echo date('d-m-Y H:i:s',filemtime ("$dir/$file")).' ... '.date('d-m-Y H:i:s')."<br>";
		                if (filemtime ("$dir/$file")+1*24*3600<time()) unlink("$dir/$file");
			}
		        closedir($dh);
		}
	}		


<?php
	$dir = "./";

	if (is_dir($dir)) 
	{
		if ($dh = opendir($dir)) 
		{
			while (($file = readdir($dh)) !== false) 
			{
				if ($file[0]=='.') continue;
				if ($file=='index.php') continue;

				$fd=explode('.',$file);

				if ($fd[count($fd)-1]!='jpg') continue;


				$t=filemtime($file);

				$d=date('d-m-Y H:i:s',$t);
				$files[date('Y-m-d H:i:s',$t).$file]='<a href="'.$file.'">'.'<img width="250px" title="'.$d.'" src="'.$file.'" border="0" />'.'</a>';
        		}
		}
		@krsort($files);
	
        	closedir($dh);
	}					    

	$files2=array();
	if (is_array($files)) foreach ($files AS $f) $files2[]=$f;

	$size=count($files);
	$limit=35;

	echo "<p>Strony: ";
	for ($i=0;$i<$size/$limit;$i++)
	{
		$style=$_REQUEST['page']+0==$i?'style="font-weight: bold; color: red"':'style="color:black"';
		echo '<a href="index.php?page='.$i.'" '.$style.'>'.($i+1).'</a>, ';
	}
	echo '</p>';

	for ($i=$limit*$_REQUEST['page']; $i<$limit*(1+$_REQUEST['page']);$i++)
	{
		echo $files2[$i]. ' ';
		
	}
						    

<?

	if (!function_exists('url2array'))
	{
		function url2array($url)
		{
			if (!strlen($url)) return;
			foreach (explode('&',$url) AS $para)
			{
				$p=explode('=',$para);
				$wynik[urldecode($p[0])]=urldecode($p[1]);
			}
			return $wynik;
		}

		function array2url($tab)
		{
			if (!is_array($tab)) return;

			while(list($k,$v)=each($tab)) if (!is_array($v)) $url[]=$k.'='.urlencode($v);
			return implode('&',$url);
		}
	}

	if (!function_exists('db_navi'))
	{
		function db_navi($navi,$wszystko,$size,$c_ile_stron,$strona)
		{
			if ($wszystko<=$size || !$size) return "";

			$ile_stron=ceil($wszystko/$size);
			$navi[ile]=$wszystko;
			$navi[first]=0;
			$navi[last]=$ile_stron-1;
			
			$additional_array=$navi;

			$start_page=0;
			$end_page=$c_ile_stron;
			if ($c_ile_stron>$ile_stron) $end_page=$ile_stron;
			else
			{
				while($end_page<$strona)
				{
					$start_page++;
					$end_page++;
				}

				while($end_page<$ile_stron && $start_page<$strona-($c_ile_stron/2))
				{
					$start_page++;
					$end_page++;
				}
			}


			for ($i=$start_page;$i<$end_page;$i++)
			{
				$s=array('strona'=>$i);
				$s[text]=$i+1;
				$s[active]=($strona==$i)?'active':'';
				$s=array_merge($additional_array,$s);
				
				$navi[strony][]=$s;
			}


			return array($navi);
		}
	}


	global $_REQUEST;

	$_table=unserialize(base64_decode($costxt));
	$sql_table=array();

	if (strlen($_table['eval'])) eval($_table['eval']);

	$sql_filtr="";
	$sql_filtr_where="";

	//echo '<pre>';print_r($_REQUEST);echo '</pre>';


	if ($_table['header'] || $size)
	{
		?>


<style type="text/css">
			.sql_table_order 		
			{
				background-image: url(<?=$INCLUDE_PATH?>/sql_table/down.gif);
				background-repeat: no-repeat;
				background-position: right; 
			}
			.sql_table_order_desc	
			{
				background-image: url(<?=$INCLUDE_PATH?>/sql_table/up.gif);
				background-repeat: no-repeat;
				background-position: right; 
			}
</style>

		<?
		include("$INCLUDE_PATH/sql_table/sql_table_header.php");
	}
	
	$sql_my_where=strlen($sql_filtr_where)?'AND':'WHERE';

	if (isset($navi)) unset($navi);

	$sql="";
	$str2eval='$sql="'.$_table[sql].'";';

	eval($str2eval);
	if (!strlen($sql)) echo $str2eval;

	if ($size)
	{
		$sql2="";
		$str2eval='$sql2="'.$_table['count'].'";';
		eval($str2eval);
		if (!strlen($sql2)) echo $str2eval;
		$result = pg_exec($db,$sql2);
		$ile=0;

		if ($result) if (pg_num_rows($result)) 
		{
			$ile=pg_fetch_row($result,0);
			$ile=$ile[0];
		}

		if ($ile && $ile>$size) 
		{
			$navi[sid]=$sid;
			$navi=db_navi($navi,$ile,$size,10,$_REQUEST[strona]+0);
			$sql.="\nLIMIT $size OFFSET ".($_REQUEST[strona]*$size);
		}

		
	}





	$t1=time();
	$result = @pg_exec($db,$sql); 
	$t2=time();


	$additional_array=array('next'=>$next,'more'=>$more,'self'=>$self,'sign'=>$KAMELEON_MODE?'&':'?',
						'UIMAGES'=>$UIMAGES,'IMAGES'=>$IMAGES,'UFILES'=>$UFILES);
	if ($result)
	{
	
		$ile = pg_num_rows($result); 

		if ($ile) $sql_table=array();

		for ($i=0;$i<$ile;$i++) 
		{
			$tab=url2array(pg_explodeName($result,$i));
			if (is_array($additional_array)) $tab=array_merge($additional_array,$tab);
			$tab[parity]=($i%2)?'odd':'even';
			$tab[lp]=$i+1+$_REQUEST[strona]*$size;
			if (strlen($_table[loop_eval])) eval($_table[loop_eval]);
			
			$sql_table[]=$tab;
		}
	
		if ($ile==1) parse_str(array2url($tab));

		if  (count($sql_table)) $_REQUEST[sql_table]=$sql_table;
		else 
		{
			unset($_REQUEST[sql_table]);
			unset($sql_table);
		}
	}


	if ($_table[debug] || $KAMELEON_MODE)
	{
		echo '<fieldset style="width:99%; margin:5px; text-align:left">';
		echo "<legend title=\"kliknij aby rozwi±æ\" style=\"cursor:pointer; color:red; font-weight:bold\" onclick=\"document.getElementById('sql_table_debug_$sid').style.display=(document.getElementById('sql_table_debug_$sid').style.display=='none')?'':'none'\">Debug</legend>";
		echo "<span id=\"sql_table_debug_$sid\" style=\"display:none\" >";
		echo "Czas: ".($t2-$t1)." sek.<br>";
		echo nl2br($sql).'<pre>';
		print_r($sql_table);
		echo '</pre></span></fieldset>';
	}


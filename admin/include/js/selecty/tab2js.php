<?
if (function_exists('tab2js')) return;

function tab2js($tab,$varname,$sort=array())
{
	global $KAMELEON_MODE;

	$wynik="var $varname=new Array();\n";
	$wynik.="${varname}['k']=new Array();\n";
	$wynik.="${varname}['n']=new Array();\n";
	$wynik.="${varname}['s']=new Array();\n";

	for ($i=0;$i<count($tab[k]);$i++)
	{
		for ($j=0;$j<count($tab[k][$i]);$j++)
		{
			if ( !is_array($sel[$j]) || !in_array($tab[k][$i][$j],$sel[$j]) )
			{
				$sel[$j][]=$tab[k][$i][$j];
				$opt[$j][]=$tab[n][$i][$j];
			}

			$x[$i][]=array_search($tab[k][$i][$j],$sel[$j]);
		}
	}



	for ($i=0;$i<count($sel); $i++)
	{
		$wynik.="${varname}['k'][$i]=new Array(";
		foreach ($sel[$i] AS $k)
		{
			$k=str_replace("'","\\'",$k);
			$wynik.="'$k',";
		}
		if ($max[$i]<count($sel[$i])) $max[$i]=count($sel[$i]);
		
		$wynik=substr($wynik,0,strlen($wynik)-1);
		$wynik.=");\n";

		$wynik.="${varname}['n'][$i]=new Array(";
		foreach ($opt[$i] AS $k)
		{
			$k=str_replace("'","\\'",$k);
			$wynik.="'$k',";	
		}

		$wynik=substr($wynik,0,strlen($wynik)-1);
		$wynik.=");\n";
	}

	$wynik.="${varname}['x']='";


	foreach ($x AS $wyst)
	{
		for ($i=0;$i<count($wyst);$i++)
		{
			$szablon="%03X";
			if ($max[$i]<=256) $szablon="%02X";
			if ($max[$i]<=16) $szablon="%X";

			$wynik.=sprintf($szablon,$wyst[$i]);
		}
	}

	$wynik.="';\n";

	
	return $wynik;
}
?>
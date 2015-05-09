<?


	function url2array($url)
	{
		foreach (explode('&',$url) AS $u)
		{
			$_u=explode('=',$u);
			$array[urldecode($_u[0])]=urldecode($_u[1]);

		}
	
		return $array;
	}


	function input2sql($a)
	{
		
		foreach ($a AS $k=>$v)
		{
			$_k=explode('_',$k);
			if ($_k[1]=='id')
			{
				$wynik['keyname']=$k;
				$wynik['keyvalue']=$v;
				continue;
			}
			$v=addslashes(stripslashes($v));
			$wynik['inserts'][]=$k;
			$wynik['values'][]="'$v'";
			$wynik['set'][]="$k='$v'";
		}


		return $wynik;
	}
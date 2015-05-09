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

			while(list($k,$v)=each($tab)) $url[]=$k.'='.urlencode($v);
			return implode('&',$url);
		}
	}

?>
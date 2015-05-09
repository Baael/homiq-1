<?php

if (!function_exists('_ob_replace_tokens'))
{
	function _ob_replace_tokens($parser_content,$vars)
	{
		$parser_startpos=0;

		global $_SERVER,$_REQUEST;

		foreach ($_SERVER AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v;
		foreach ($_REQUEST AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v;
		

		while (1)
		{
			$parser_content=substr($parser_content,$parser_startpos);
			$parser_proc1=strpos($parser_content,"{");
			$parser_proc2=strpos(substr($parser_content,$parser_proc1+1),"}");
			$parser_proc3=strpos(substr($parser_content,$parser_proc1+1),"{");
			if (!strlen($parser_proc1) || !strlen($parser_proc2) )
			{
				$wynik.=$parser_content;
				break;
			}

			if ( strlen($parser_proc3) && $parser_proc3<$parser_proc2 )
			{
				$wynik.=substr($parser_content,0,$parser_proc1+1);
				$parser_startpos=$parser_proc1+1;
				continue;
			}


			$parser_token=substr($parser_content,$parser_proc1+1,$parser_proc2);
			$parser_startpos=$parser_proc1+$parser_proc2+2;
			$wynik.=substr($parser_content,0,$parser_proc1);



			if (substr(strtolower($parser_token),0,5)=='loop:')
			{
				$arrayname=substr($parser_token,5);
				
				$end_token=strtolower("{endloop:$arrayname}");
				$pos=strpos(strtolower($parser_content),$end_token);

				if ($pos)
				{
					$inside_content=substr($parser_content,$parser_startpos,$pos-$parser_startpos);
					$parser_startpos=$pos+strlen($end_token);

					$arrayname_array=explode(':',$arrayname);

					if (is_array($vars[$arrayname_array[0]])) 
						foreach ($vars[$arrayname_array[0]] AS $varset)
						{
							foreach($vars AS $k=>$v) if (!is_array($v) && !isset($varset[$k])) $varset[$k]=$v;
							$wynik.=_ob_replace_tokens($inside_content,$varset);
						}
				}
			
			}
			elseif (substr(strtolower($parser_token),0,3)=='if:')
			{
				$ifname=substr($parser_token,3);
				
				$end_token=strtolower("{endif:$ifname}");
				$pos=strpos(strtolower($parser_content),$end_token);
				$NOT=false;
				if ($ifname[0]=='!')
				{
					$NOT=true;
					$ifname=substr($ifname,1);
				}

				if ($pos)
				{
					$ifname_array=explode(':',$ifname);
					
					$zmienna=explode('=',$ifname_array[0]);
					if (count($zmienna)==1)
					{
						if (!$vars[$ifname_array[0]] && !$NOT ) $parser_startpos=$pos+strlen($end_token);
						if ($vars[$ifname_array[0]] && $NOT ) $parser_startpos=$pos+strlen($end_token);
					}
					else
					{
						if ($vars[$zmienna[0]]!=$zmienna[1] && !$NOT ) $parser_startpos=$pos+strlen($end_token);
						if ($vars[$zmienna[0]]==$zmienna[1] && $NOT ) $parser_startpos=$pos+strlen($end_token);
					}
				}
			}
			else
			{
				if (isset($vars[$parser_token])) $wynik.=$vars[$parser_token];
				elseif (isset($vars->$parser_token)) $wynik.=$vars->$parser_token;
				elseif (strstr($parser_token,"\n") ) $wynik.='{'.$parser_token.'}';
				elseif ($vars['_OB_TOKEN_BLANK'] || $vars->_OB_TOKEN_BLANK) $wynik.='';
				elseif ( !strstr($parser_token,':') ) $wynik.='{'.$parser_token.'}';


			}

		}

		return $wynik;
	}
}

$_p=$smekta;

//$_p=eregi_replace("<!--[ ]*loop:([^> -]+)[ ]*-->","{loop:\\1}",$_p);
//$_p=eregi_replace("<!--[ ]*if:([^> -]+)[ ]*-->","{if:\\1}",$_p);
//$_p=eregi_replace("<\!--[ ]*end([a-z]+):([^> -]+)[ ]*-->","{end\\1:\\2}",$_p);


$_p=preg_replace("#<!--[ ]*loop:([^> -]+)[ ]*-->#","{loop:\\1}",$_p);
$_p=preg_replace("#<!--[ ]*if:([^> -]+)[ ]*-->#","{if:\\1}",$_p);
$_p=preg_replace("#<\!--[ ]*end([a-z]+):([^> \-]+)[ ]*-->#","{end\\1:\\2}",$_p);


while (1) 
{
	$__p=$_p;
	$_p=preg_replace("#\[\!(.*)\!\]#","{\\1}",$__p);
	if (strlen($_p)==strlen($__p)) break;
}

$vars=get_defined_vars();

foreach(array('smekta','argv','argc','adb','acl','sql','url','res') AS $k ) unset($vars[$k]);

foreach(array_keys($vars) AS $k) 
{
	if (strlen($k)==1) unset($vars[$k]);
	if (strtoupper($k)==$k) unset($vars[$k]);
	if ($k[0]=='_') unset($vars[$k]);


	if (is_array($vars[$k]) && is_array($vars[$k][0]) )
	{
		$vars[$k][0]['first']=1;
		$vars[$k][count($vars[$k])-1]['last']=1;
	}
}

if (strstr($smekta,'{get_defined_vars}'))
{
	ob_start();
	print_r($vars);
	$vars['get_defined_vars']=ob_get_contents();
	ob_end_clean();
}

$vars['acl']=$acl;
echo _ob_replace_tokens($_p,$vars);


<?php $page="5";  $ver="1";  $lang="pl";  $tree=":0:100:3:";  $INCLUDE_PATH="include";  $MAIN_INCLUDE_PATH="include";  $PAGE_PATH="php";  $IMAGES="images/1";  $UIMAGES="images";  $UFILES="att";  $SERVER_ID="11";  $prevpage="inputs.php";  $pagetype=1; include("include/pre.php");?><?php include("include/action.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Wejście</title>
	<meta name="Robots" content="all">
	<meta name="generator" content="WebKameleon 5.06">
	<meta name="WebKameleonId" content="server=11; page=5; ver=1; lang=pl" />

	<meta name="ftpdate" content="Mon, 21 Nov 2011 18:06:06 +0100" />
	
		
	
	
	<link href="images/1/textstyle.css" rel="stylesheet" type="text/css" />
	<link href="images/1/szablon.css" rel="stylesheet" type="text/css" />
	
	
	<script language="JavaScript" type="text/javascript">
		var JSTITLE = "Wejście";
		var JSCLOSE = "Zamknij okno";
		var JSWAIT = "Proszę czekać na załadowanie strony...";
		var JSUIMAGES = "images";
		var JSIMAGES = "images/1";
	</script>
	<script language="Javascript" type="text/javascript" src="php/popupimg.enc.js"></script>
	<script src="images/1/js/a_jquery.js" type="text/javascript"></script>
	<script src="images/1/js/b_jcarousel.js" type="text/javascript"></script>
	<script src="images/1/js/d_swfobject.js" type="text/javascript"></script>
	<script src="images/1/js/dhtmlxcommon.js" type="text/javascript"></script>
	<script src="images/1/js/dhtmlxtabbar.js" type="text/javascript"></script>
	<script src="images/1/js/x_site.js" type="text/javascript"></script>
  	<link href="images/1/css.php?p=images/1&t=" rel="stylesheet" type="text/css" />
				<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
				<link href="images/1/druk.css" rel="stylesheet" type="text/css"  media="print" />	
</head>
<body    ><div class="body_h">
	
  </div>
  <div class="body_menu">
  	<div class="szukaj"><?php parse_str("more=input.php&cos=&next=input.php&size=&class=&costxt=&title=&pagetype=1&self=input.php&tree=:0:100:3:&sid=4226&prevpage=inputs.php&INCLUDE_PATH=include&html=js.php"); 
 include("include/js.php");  ?></div>
  	<div class="menu"></div>
	<div class="web"></div>
  </div><div class="body_m" >
	<div>
      <div class="body_m_l">
        	 <?php ob_start(); ?><ul><li ><a href="promienko/">PROMIENKO</a></li>
<li ><a href="masters.php">Urządzenia</a></li>
<li ><a href="modules.php">Moduły</a></li>
<li class="active"><a href="inputs.php">Wejścia</a></li>
<li ><a href="outputs.php">Wyjścia</a></li>
<li ><a href="macros.php">Makra</a></li>
<li ><a href="promienko/akcje/">Akcje</a></li>
<li ><a href="crons.php">Kalendarz</a></li>
<li ><a href="temperatury.php">Temperatury</a></li>
<li ><a href="promienko/historia/">Historia</a></li>
<li ><a href="promienko/pobor-energii/">Pobór energii</a></li>
</ul> <?php if (!function_exists('_ob_replace_tokens')) { function _ob_obj2arr(&$obj,$depth=0) { static $hash; if (!function_exists('spl_object_hash')) return $obj; if (!is_array($obj) && !is_object($obj)) return $obj; if ($depth==0) $hash=array(); $wynik=array(); foreach ($obj AS $k=>$v) { if (is_object($v)) { $spl=spl_object_hash($v); if (isset($hash[$spl])) continue; $hash[$spl]=true; } $wynik[$k] =  ($k!='GLOBALS' && (is_array($v)||is_object($v)) ) ? _ob_obj2arr($v,$depth+1) : $v; } return $wynik; } function _post_parse_token($token,$fun=array(),$param=array()) { for ($f=0;$f<count($fun);$f++) { if (!function_exists($fun[$f])) continue; if (is_array($param[$f])) $param[$f]=array_merge(array($token),$param[$f]); elseif (strlen(trim($param[$f]))) $param[$f]=array($token,$param[$f]); else $param[$f]=array($token); $token=call_user_func_array($fun[$f],$param[$f]); } return $token; } function _dig_deep_in_array($vars_array,$key_array) { if (!is_array($key_array)) $key_array=array($key_array); $wynik=$vars_array; foreach ($key_array AS $key) { $wynik=$wynik[$key]; } return $wynik; } function _ob_replace_tokens($parser_content,$vars) { $parser_startpos=0; global $_SERVER,$_REQUEST; foreach ($_SERVER AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; foreach ($_REQUEST AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; while (1) { $parser_content=substr($parser_content,$parser_startpos); $parser_proc1=strpos($parser_content,"{"); $parser_proc2=strpos(substr($parser_content,$parser_proc1+1),"}"); $parser_proc3=strpos(substr($parser_content,$parser_proc1+1),"{"); if (!strlen($parser_proc1) || !strlen($parser_proc2) ) { $wynik.=$parser_content; break; } if ( strlen($parser_proc3) && $parser_proc3<$parser_proc2 ) { $wynik.=substr($parser_content,0,$parser_proc1+1); $parser_startpos=$parser_proc1+1; continue; } $parser_token=substr($parser_content,$parser_proc1+1,$parser_proc2); $parser_startpos=$parser_proc1+$parser_proc2+2; $wynik.=substr($parser_content,0,$parser_proc1); if (substr(strtolower($parser_token),0,5)=='with:') { $arrayname=substr($parser_token,5); $end_token=strtolower("{endwith:$arrayname}"); $pos=strpos(strtolower($parser_content),$end_token); if ($pos) { $inside_content=substr($parser_content,$parser_startpos,$pos-$parser_startpos); $parser_startpos=$pos+strlen($end_token); $arrayname_array=explode(':',$arrayname); $arrayname=$arrayname_array[0]; if (is_array($vars[$arrayname])) { $varset=$vars[$arrayname]; foreach($vars AS $k=>$v) { if (!is_object($v) && !is_array($v) && !isset($varset[$k])) $varset[$k]=$v; } $wynik.=_ob_replace_tokens($inside_content,$varset); } } } elseif (substr(strtolower($parser_token),0,5)=='loop:') { $arrayname=substr($parser_token,5); $end_token=strtolower("{endloop:$arrayname}"); $pos=strpos(strtolower($parser_content),$end_token); if ($pos) { $inside_content=substr($parser_content,$parser_startpos,$pos-$parser_startpos); $parser_startpos=$pos+strlen($end_token); $arrayname_array=explode(':',$arrayname); $_loop_var=explode('.',$arrayname_array[0]); $loop_var = (count($_loop_var)==1)?$vars[$_loop_var[0]]:$vars[$_loop_var[0]][$_loop_var[1]]; $loop_i=0; if (is_array($loop_var))  foreach ($loop_var AS $__k__ => $varset) { if (!is_array($varset)) { $varset=array('loop'=>$varset); $varset[$arrayname_array[0]]=$varset['loop']; } $varset['__loop__']=$__k__; foreach($vars AS $k=>$v) { if (!is_array($v) && !isset($varset[$k])) $varset[$k]=$v; } $loop_i++; if ( preg_match('/^[0-9\-]+$/',$arrayname_array[1]) ) { $fromto=explode('-',$arrayname_array[1]); if (!$fromto[1]) $fromto[1]=$fromto[0]; if ($loop_i < $fromto[0] || $loop_i > $fromto[1]) continue; } $wynik.=_ob_replace_tokens($inside_content,$varset); } } } elseif (substr(strtolower($parser_token),0,3)=='if:') { $ifname=substr($parser_token,3); $end_token=strtolower("{endif:$ifname}"); $pos=strpos(strtolower($parser_content),$end_token); $NOT=false; if ($ifname[0]=='!') { $NOT=true; $ifname=substr($ifname,1); } if ($pos) { $ifname_array=explode(':',$ifname); $_zmienna=explode('=',$ifname_array[0]); $__zmienna=explode('.',$_zmienna[0]); if (count($__zmienna)==1) { $test_zmienna=$vars[$__zmienna[0]]; } else { if (is_object($vars[$__zmienna[0]])) $test_zmienna=$vars[$__zmienna[0]]->$__zmienna[1]; else $test_zmienna=$vars[$__zmienna[0]][$__zmienna[1]]; } if (count($_zmienna)==1) { if (!$test_zmienna && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($test_zmienna && $NOT ) $parser_startpos=$pos+strlen($end_token); } else { if ($test_zmienna!=$_zmienna[1] && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($test_zmienna==$_zmienna[1] && $NOT ) $parser_startpos=$pos+strlen($end_token); } } } else { $fun=array(); $param=array(); $default_value=null; if (strstr($parser_token,'?') && !strstr($parser_token,"\n") ) { $_parser_token=explode('?',$parser_token); $default_value=$_parser_token[1]; $parser_token=$_parser_token[0]; } if (strstr($parser_token,'|') && !strstr($parser_token,"\n") ) { $_parser_token=explode('|',$parser_token); $parser_token=$_parser_token[0]; for ($f=1;$f<count($_parser_token);$f++) { $_parser_token[$f]=str_replace("\\:",'__dwukropek__',$_parser_token[$f]); $_parser_token_fun=explode(':',$_parser_token[$f]); $_fun=$_parser_token_fun[0]; $_parser_token_fun[1]=str_replace("\\,",'__przcinek__',$_parser_token_fun[1]); $_param=explode(',',$_parser_token_fun[1]); if (!strlen($_parser_token_fun[1])) $_param=array(); $_param=str_replace('__przcinek__',',',$_param); $_param=str_replace('__dwukropek__',':',$_param); $fun[]=$_fun; $param[]=$_param; } } if (strstr($parser_token,'.') && !strstr($parser_token,"\n") ) { $_parser_token=explode('.',$parser_token); $parser_token=$_parser_token[0]; if (isset($vars[$parser_token][$_parser_token[1]])) { $wynik.=_post_parse_token(_dig_deep_in_array($vars,$_parser_token),$fun,$param); } } elseif (isset($vars[$parser_token])) $wynik.=_post_parse_token($vars[$parser_token],$fun,$param); elseif (strstr($parser_token,"\n") ) $wynik.='{'.$parser_token.'}'; elseif ( !is_null($default_value)) $wynik.= _post_parse_token($default_value,$fun,$param);   elseif ($vars['_OB_TOKEN_BLANK'] || $vars->_OB_TOKEN_BLANK) $wynik.=''; elseif ($vars['KAMELEON_OB_TOKEN_BLANK'] || $vars->KAMELEON_OB_TOKEN_BLANK) $wynik.=''; elseif ( !strstr($parser_token,':') ) $wynik.='{'.$parser_token.'}'; } } return $wynik; } } $_p=ob_get_contents(); ob_end_clean(); $_p=preg_replace("#<!--[ ]*loop:([^> -]+)[ ]*-->#","{loop:\\1}",$_p); $_p=preg_replace("#<!--[ ]*with:([^> -]+)[ ]*-->#","{with:\\1}",$_p); $_p=preg_replace("#<!--[ ]*if:([^> -]+)[ ]*-->#","{if:\\1}",$_p); $_p=preg_replace("#<\!--[ ]*end([a-z]+):([^> \-]+)[ ]*-->#","{end\\1:\\2}",$_p); $_p=preg_replace("#<!--[ ]*([a-z_]+)[ ]*-->#","{\\1}",$_p); while (1)  { $__p=$_p; $_p=preg_replace("#\[\!(.*)\!\]#","{\\1}",$__p); if (strlen($_p)==strlen($__p)) break; } $s=$WEBTD->sid?$WEBTD->sid:$sid; if (!$_REQUEST['hidden_'.$s])  { if (isset($kameleon_ob_replace_tokens_vars)) { $__vars=$kameleon_ob_replace_tokens_vars; } else { $__vars=$WEBTD->sid?$adodb->kameleon_after_include_vars:get_defined_vars(); } $str2echo = _ob_replace_tokens($_p,_ob_obj2arr($__vars)); $wynik=function_exists('kameleon_ob_replace_post') ? kameleon_ob_replace_post($str2echo) : $str2echo; if (isset($kameleon_ob_replace_tokens_result)) { $kameleon_ob_replace_tokens_result=$wynik; } else { echo $wynik; } } ?> 
    		
    		
      </div>
      <div class="body_s_r">
      		
    		
    		 <?php ob_start(); ?><div class="box">
  <div class="title"><h2>Wejście <img src=images/1/szablon/dot.png></h2></div>
  <div  class="txt"><form method="post" action="inputs.php" id="kameleon_form_sid_4210" name="kameleon_form_1">
	<p><input name="action" type="hidden" value="update" /> <input name="inputs[i_id]" type="hidden" value="{i_id}" /> {sql_table_form}</p>
	<table border="1" cellpadding="4" cellspacing="0" class="tabela_1">
		<tbody>
			<tr>
				<td>
					Nazwa:</td>
				<td>
					<input name="inputs[i_name]" size="30" type="text" value="{i_name}" /></td>
			</tr>
			<tr>
				<td>
					Symbol:</td>
				<td>
					<input name="inputs[i_symbol]" size="5" type="text" value="{i_symbol}" /></td>
			</tr>
			<tr>
				<td>
					Aktywny:</td>
				<td>
					<input name="inputs[i_active]" type="hidden" value="0" /> {if:i_active}<input checked="checked" name="inputs[i_active]" type="checkbox" value="1" />{endif:i_active}{if:!i_active}<input name="inputs[i_active]" type="checkbox" value="1" />{endif:!i_active}</td>
			</tr>



				<td>
					Historia:</td>
				<td>
					<input name="inputs[i_history]" type="hidden" value="0" /> {if:i_history}<input checked="checked" name="inputs[i_history]" type="checkbox" value="1" />{endif:i_history}{if:!i_history}<input name="inputs[i_history]" type="checkbox" value="1" />{endif:!i_history}</td>
			</tr>




		</tbody>
	</table>
	<p><input class="button" type="submit" value="Zapisz" /></p>
</form><?php parse_str("more=input.php&cos=&next=inputs.php&size=&class=&costxt=base64%3AYToyOntzOjM6InNpZCI7czo0OiI0MjEwIjtzOjM6InBocCI7czoyMDI6InBhcnNlX3N0cihxdWVyeTJ1cmwoIlNFTEVDVCAqIEZST00gaW5wdXRzIFdIRVJFIGlfaWQ9Ii4oMCskX0dFVFsnaV9pZCddKSkpOw0KDQoNCmlmICghJF9HRVRbJ2lfaWQnXSkgJF9SRVFVRVNUWydLQU1FTEVPTl9PQl9UT0tFTl9CTEFOSyddPTE7DQppbmNsdWRlKCIkSU5DTFVERV9QQVRIL3NxbF90YWJsZS9zcWxfdGFibGVfaGlkZGVuLnBocCIpOw0KDQoiO30%3D&title=Wej%C5%9Bcie&pagetype=1&self=input.php&tree=:0:100:3:&sid=4210&prevpage=inputs.php&INCLUDE_PATH=include&html=eval/eval.php"); 
 include("include/eval/eval.php");  ?>
 	
  </div>
</div> <?php if (!function_exists('_ob_replace_tokens')) { function _ob_obj2arr(&$obj,$depth=0) { static $hash; if (!function_exists('spl_object_hash')) return $obj; if (!is_array($obj) && !is_object($obj)) return $obj; if ($depth==0) $hash=array(); $wynik=array(); foreach ($obj AS $k=>$v) { if (is_object($v)) { $spl=spl_object_hash($v); if (isset($hash[$spl])) continue; $hash[$spl]=true; } $wynik[$k] =  ($k!='GLOBALS' && (is_array($v)||is_object($v)) ) ? _ob_obj2arr($v,$depth+1) : $v; } return $wynik; } function _post_parse_token($token,$fun=array(),$param=array()) { for ($f=0;$f<count($fun);$f++) { if (!function_exists($fun[$f])) continue; if (is_array($param[$f])) $param[$f]=array_merge(array($token),$param[$f]); elseif (strlen(trim($param[$f]))) $param[$f]=array($token,$param[$f]); else $param[$f]=array($token); $token=call_user_func_array($fun[$f],$param[$f]); } return $token; } function _dig_deep_in_array($vars_array,$key_array) { if (!is_array($key_array)) $key_array=array($key_array); $wynik=$vars_array; foreach ($key_array AS $key) { $wynik=$wynik[$key]; } return $wynik; } function _ob_replace_tokens($parser_content,$vars) { $parser_startpos=0; global $_SERVER,$_REQUEST; foreach ($_SERVER AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; foreach ($_REQUEST AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; while (1) { $parser_content=substr($parser_content,$parser_startpos); $parser_proc1=strpos($parser_content,"{"); $parser_proc2=strpos(substr($parser_content,$parser_proc1+1),"}"); $parser_proc3=strpos(substr($parser_content,$parser_proc1+1),"{"); if (!strlen($parser_proc1) || !strlen($parser_proc2) ) { $wynik.=$parser_content; break; } if ( strlen($parser_proc3) && $parser_proc3<$parser_proc2 ) { $wynik.=substr($parser_content,0,$parser_proc1+1); $parser_startpos=$parser_proc1+1; continue; } $parser_token=substr($parser_content,$parser_proc1+1,$parser_proc2); $parser_startpos=$parser_proc1+$parser_proc2+2; $wynik.=substr($parser_content,0,$parser_proc1); if (substr(strtolower($parser_token),0,5)=='with:') { $arrayname=substr($parser_token,5); $end_token=strtolower("{endwith:$arrayname}"); $pos=strpos(strtolower($parser_content),$end_token); if ($pos) { $inside_content=substr($parser_content,$parser_startpos,$pos-$parser_startpos); $parser_startpos=$pos+strlen($end_token); $arrayname_array=explode(':',$arrayname); $arrayname=$arrayname_array[0]; if (is_array($vars[$arrayname])) { $varset=$vars[$arrayname]; foreach($vars AS $k=>$v) { if (!is_object($v) && !is_array($v) && !isset($varset[$k])) $varset[$k]=$v; } $wynik.=_ob_replace_tokens($inside_content,$varset); } } } elseif (substr(strtolower($parser_token),0,5)=='loop:') { $arrayname=substr($parser_token,5); $end_token=strtolower("{endloop:$arrayname}"); $pos=strpos(strtolower($parser_content),$end_token); if ($pos) { $inside_content=substr($parser_content,$parser_startpos,$pos-$parser_startpos); $parser_startpos=$pos+strlen($end_token); $arrayname_array=explode(':',$arrayname); $_loop_var=explode('.',$arrayname_array[0]); $loop_var = (count($_loop_var)==1)?$vars[$_loop_var[0]]:$vars[$_loop_var[0]][$_loop_var[1]]; $loop_i=0; if (is_array($loop_var))  foreach ($loop_var AS $__k__ => $varset) { if (!is_array($varset)) { $varset=array('loop'=>$varset); $varset[$arrayname_array[0]]=$varset['loop']; } $varset['__loop__']=$__k__; foreach($vars AS $k=>$v) { if (!is_array($v) && !isset($varset[$k])) $varset[$k]=$v; } $loop_i++; if ( preg_match('/^[0-9\-]+$/',$arrayname_array[1]) ) { $fromto=explode('-',$arrayname_array[1]); if (!$fromto[1]) $fromto[1]=$fromto[0]; if ($loop_i < $fromto[0] || $loop_i > $fromto[1]) continue; } $wynik.=_ob_replace_tokens($inside_content,$varset); } } } elseif (substr(strtolower($parser_token),0,3)=='if:') { $ifname=substr($parser_token,3); $end_token=strtolower("{endif:$ifname}"); $pos=strpos(strtolower($parser_content),$end_token); $NOT=false; if ($ifname[0]=='!') { $NOT=true; $ifname=substr($ifname,1); } if ($pos) { $ifname_array=explode(':',$ifname); $_zmienna=explode('=',$ifname_array[0]); $__zmienna=explode('.',$_zmienna[0]); if (count($__zmienna)==1) { $test_zmienna=$vars[$__zmienna[0]]; } else { if (is_object($vars[$__zmienna[0]])) $test_zmienna=$vars[$__zmienna[0]]->$__zmienna[1]; else $test_zmienna=$vars[$__zmienna[0]][$__zmienna[1]]; } if (count($_zmienna)==1) { if (!$test_zmienna && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($test_zmienna && $NOT ) $parser_startpos=$pos+strlen($end_token); } else { if ($test_zmienna!=$_zmienna[1] && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($test_zmienna==$_zmienna[1] && $NOT ) $parser_startpos=$pos+strlen($end_token); } } } else { $fun=array(); $param=array(); $default_value=null; if (strstr($parser_token,'?') && !strstr($parser_token,"\n") ) { $_parser_token=explode('?',$parser_token); $default_value=$_parser_token[1]; $parser_token=$_parser_token[0]; } if (strstr($parser_token,'|') && !strstr($parser_token,"\n") ) { $_parser_token=explode('|',$parser_token); $parser_token=$_parser_token[0]; for ($f=1;$f<count($_parser_token);$f++) { $_parser_token[$f]=str_replace("\\:",'__dwukropek__',$_parser_token[$f]); $_parser_token_fun=explode(':',$_parser_token[$f]); $_fun=$_parser_token_fun[0]; $_parser_token_fun[1]=str_replace("\\,",'__przcinek__',$_parser_token_fun[1]); $_param=explode(',',$_parser_token_fun[1]); if (!strlen($_parser_token_fun[1])) $_param=array(); $_param=str_replace('__przcinek__',',',$_param); $_param=str_replace('__dwukropek__',':',$_param); $fun[]=$_fun; $param[]=$_param; } } if (strstr($parser_token,'.') && !strstr($parser_token,"\n") ) { $_parser_token=explode('.',$parser_token); $parser_token=$_parser_token[0]; if (isset($vars[$parser_token][$_parser_token[1]])) { $wynik.=_post_parse_token(_dig_deep_in_array($vars,$_parser_token),$fun,$param); } } elseif (isset($vars[$parser_token])) $wynik.=_post_parse_token($vars[$parser_token],$fun,$param); elseif (strstr($parser_token,"\n") ) $wynik.='{'.$parser_token.'}'; elseif ( !is_null($default_value)) $wynik.= _post_parse_token($default_value,$fun,$param);   elseif ($vars['_OB_TOKEN_BLANK'] || $vars->_OB_TOKEN_BLANK) $wynik.=''; elseif ($vars['KAMELEON_OB_TOKEN_BLANK'] || $vars->KAMELEON_OB_TOKEN_BLANK) $wynik.=''; elseif ( !strstr($parser_token,':') ) $wynik.='{'.$parser_token.'}'; } } return $wynik; } } $_p=ob_get_contents(); ob_end_clean(); $_p=preg_replace("#<!--[ ]*loop:([^> -]+)[ ]*-->#","{loop:\\1}",$_p); $_p=preg_replace("#<!--[ ]*with:([^> -]+)[ ]*-->#","{with:\\1}",$_p); $_p=preg_replace("#<!--[ ]*if:([^> -]+)[ ]*-->#","{if:\\1}",$_p); $_p=preg_replace("#<\!--[ ]*end([a-z]+):([^> \-]+)[ ]*-->#","{end\\1:\\2}",$_p); $_p=preg_replace("#<!--[ ]*([a-z_]+)[ ]*-->#","{\\1}",$_p); while (1)  { $__p=$_p; $_p=preg_replace("#\[\!(.*)\!\]#","{\\1}",$__p); if (strlen($_p)==strlen($__p)) break; } $s=$WEBTD->sid?$WEBTD->sid:$sid; if (!$_REQUEST['hidden_'.$s])  { if (isset($kameleon_ob_replace_tokens_vars)) { $__vars=$kameleon_ob_replace_tokens_vars; } else { $__vars=$WEBTD->sid?$adodb->kameleon_after_include_vars:get_defined_vars(); } $str2echo = _ob_replace_tokens($_p,_ob_obj2arr($__vars)); $wynik=function_exists('kameleon_ob_replace_post') ? kameleon_ob_replace_post($str2echo) : $str2echo; if (isset($kameleon_ob_replace_tokens_result)) { $kameleon_ob_replace_tokens_result=$wynik; } else { echo $wynik; } } ?> 
            
    		
      </div>
      <div class="clean"></div>
    </div>
</div><div class="body_f">
		<br />
        <div class="stopka">
			<div class="mapa"></div>
			<div class="info"></div>
        </div>
		
</div></body>
</html><?include("include/post.php");?>
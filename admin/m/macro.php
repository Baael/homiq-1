<?php $page="11";  $ver="5";  $lang="pl";  $tree=":0:100:8:";  $INCLUDE_PATH="../include";  $MAIN_INCLUDE_PATH="../include";  $PAGE_PATH="php";  $IMAGES="../images/5";  $UIMAGES="../images";  $UFILES="../att";  $SERVER_ID="11";  $prevpage="macros.php";  $pagetype=1; include("../include/pre.php");?><?php include("../include/action.php");?><!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
	<title>Promienko - Makro</title>
	<meta name="Robots" content="all"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="Content-Language" content="pl"/>
    <link media="handheld" type="text/html" href="http://m.ue.poznan.pl/" title="Mobile/PDA" rel="alternate">
	<meta content="640" name="MobileOptimized">
	<meta content="width = device-width; user-scalable=no" name="viewport">
	<meta content="True" name="HandheldFriendly">
	<meta content="no-cache" http-equiv="Cache-Control">
	<meta name="CMSWebKameleon" content="server=11; page=11; ver=5; lang=pl" />
	<meta name="copyright" content="Pudel w Poznaniu 2011" />
	<meta name="ftpdate" content="Fri, 04 Nov 2011 20:28:26 +0100" />
		
	
	
	
	<script language="JavaScript" type="text/javascript">
		var JSTITLE = "Makro";
		var JSCLOSE = "Zamknij okno";
		var JSWAIT = "Proszę czekać na załadowanie strony...";
		var JSUIMAGES = "../images";
		var JSIMAGES = "../images/5";
	</script>
	<script language="Javascript" type="text/javascript" src="php/popupimg.enc.js"></script>
	<script src="../images/5/js/sc.js" type="text/javascript"></script>
	<script src="../images/5/js/scripts.js" type="text/javascript"></script>
	<script src="../images/5/js/ufo.js" type="text/javascript"></script>
	<script src="../images/5/jq/jquery-1.3.2.js" type="text/javascript"></script>

<style type="text/css"> 
	span.white {color:#FFF;padding:4px; }
	span.black {color:#000000;padding:4px;}
	img.noborder {border:0px; }
	a {text-decoration:none; color:#007800;}
	a.white {color:#FFFFFF;  text-decoration:none;  }
	a.white_active {color:#FFF; font-weight:bold; text-decoration:none;}
	a.black {color:#000000;  text-decoration:none;  } 
	a.black_active {color:#000; font-weight:bold; text-decoration:none;}
	a.grey {color:#505050;  text-decoration:none;  }  
	body {background-color:#fff;color:#000000;font-family:Tahoma,Verdana,ArialCE,HelvaticaCE,Arial,Helvetica,sans-serif; font-size:11px;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px; }  
	hr.th0 {color:#0a4225;border-width:1px 0px 0px 0px;border-style:solid;margin:2px; }  
	table.width{ width:100%; }  
	table.green{ width:100%;background-color:#0a4225;color:#FFFFFF;font-size:8pt;}  
	table.gray{ width:100%;background-color:#e0e0e0;color:#505050;font-size:8pt; }   
	td.left{ text-align:left;padding:4px; }  
	
	td.left table {width:100%;}
	
	ul {padding-left:20px; margin:2px;}
	li { padding: 10px 2px 2px 0; font-weight:bold;}
	blockquote a {color:#000000;  text-decoration:none; }
	h1 {width: 100%; font-size:11px;}
	.std2 { width:100%;}
</style>
</head>
<body><table width="100%" class="width">
<tbody>
	<tr>
    	<td>
		
		</td>
	</tr>
</tbody>
</table>
<table cellspacing="0" cellpadding="0" width="100%" class="green">
<tbody>
<tr>
	<td class="left">
		<div class="pl"  class="std1">
		<?php parse_str("more=macro.php&cos=&next=macro.php&size=&class=&costxt=&title=&pagetype=1&self=macro.php&tree=:0:100:8:&sid=4226&prevpage=macros.php&INCLUDE_PATH=../include&html=js.php"); 
 include("../include/js.php");  ?></div>
	</td>
</tr>
</tbody>
</table>
<hr class="th0"><table cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
	<td class="left">
      		
    		
    		 <?php ob_start(); ?><div class="pl"  class="std1" style="">
		Macro<form action="{if:m_visible}{next}{endif:m_visible}{if:!m_visible}{more}{endif:!m_visible}" id="macro_form" method="post" name="kameleon_form_1">
	<p><input id="macro_form_action" name="action" type="hidden" value="update" /> <input name="macro[m_id]" type="hidden" value="{m_id}" /> {sql_table_form}</p>
	<table border="1" cellpadding="4" cellspacing="0" class="tabela_1">
		<tbody>
			<tr>
				<td>
					Nazwa:</td>
				<td>
					<input name="macro[m_name]" size="30" type="text" value="{m_name}" /></td>
			</tr>
			<tr>
				<td>
					Symbol:</td>
				<td>
					<input maxlength="10" name="macro[m_symbol]" size="10" type="text" value="{m_symbol}" /></td>
			</tr>
			<tr>
				<td>
					Master:</td>
				<td>
					<select id="wy_master" onchange="selectWyOnChange(this,0)"></select><input id="_wy_master" name="macro[m_master]" type="hidden" value="{m_master}" /></td>
			</tr>
			<tr>
				<td>
					Moduł:</td>
				<td>
					<select id="wy_module" onchange="selectWyOnChange(this,1)"></select><input id="_wy_module" name="macro[m_module]" type="hidden" value="{m_module}" /></td>
			</tr>
			<tr>
				<td>
					Adres:</td>
				<td>
					<select id="wy_output" onchange="selectWyOnChange(this,2)"></select><input id="_wy_output" name="macro[m_adr]" type="hidden" value="{m_adr}" /></td>
			</tr>
			<tr>
				<td>
					Stan (warunek):</td>
				<td>
					<input autocomplete="OFF" maxlength="1" name="macro[m_state_cond]" size="1" type="text" value="{m_state_cond}" /></td>
			</tr>
			<tr>
				<td>
					Typ (warunek):</td>
				<td>
					<input autocomplete="OFF" maxlength="2" name="macro[m_type]" size="1" type="text" value="{m_type}" /></td>
			</tr>
			<tr>
				<td>
					Stan systemu:</td>
				<td>
					<select name="macro[m_global]"><!-- global --></select></td>
			</tr>
			<tr>
				<td>
					Czas:</td>
				<td>
					<input maxlength="5" name="macro[m_sleep]" size="5" type="text" value="{m_sleep}" /> sek. (<em>-1 oznacza domyślny dla modułu</em>)</td>
			</tr>
			<tr>
				<td>
					Komenda:</td>
				<td>
					<select name="macro[m_cmd]"><!-- cmds --></select></td>
			</tr>
			<tr>
				<td>
					Wysłać wartość:</td>
				<td>
					<input maxlength="5" name="macro[m_val]" size="5" type="text" value="{m_val}" /></td>
			</tr>
			<tr>
				<td>
					Ustawić stan na:</td>
				<td>
					<input autocomplete="OFF" maxlength="5" name="macro[m_state]" size="5" type="text" value="{m_state}" /></td>
			</tr>
			<tr>
				<td>
					Wykonać SQL:</td>
				<td>
					<textarea name="macro[m_sql]" style="width: 500px; height: 150px;">{m_sql}</textarea></td>
			</tr>
			<tr>
				<td>
					Wykonać komendę shell:</td>
				<td>
					<input autocomplete="OFF" name="macro[m_sh]" style="width: 400px;" type="text" value="{m_sh}" /></td>
			</tr>
			<tr>
				<td>
					Grupa:</td>
				<td>
					<input name="macro[m_group]" size="30" type="text" value="{m_group}" /></td>
			</tr>
			<tr>
				<td>
					Widoczne jako gł&oacute;wne:</td>
				<td>
					<input name="macro[m_visible]" type="hidden" value="0" /> {if:m_visible}<input checked="checked" name="macro[m_visible]" onclick="zmienAction(this,'{next}','{more}')" type="checkbox" value="1" />{endif:m_visible}{if:!m_visible}<input name="macro[m_visible]" onclick="zmienAction(this,'{next}','{more}')" type="checkbox" value="1" />{endif:!m_visible}</td>
			</tr>
			<tr>
				<td>
					Aktywne:</td>
				<td>
					<input name="macro[m_active]" type="hidden" value="0" /> {if:m_active}<input checked="checked" name="macro[m_active]" type="checkbox" value="1" />{endif:m_active}{if:!m_active}<input name="macro[m_active]" type="checkbox" value="1" />{endif:!m_active}</td>
			</tr>
			<tr>
				<td>
					Zatrzymaj jeżeli warunek stanu zawiedzie:</td>
				<td>
					<input name="macro[m_quit_on_cond_fail]" type="hidden" value="0" /> {if:m_quit_on_cond_fail}<input checked="checked" name="macro[m_quit_on_cond_fail]" type="checkbox" value="1" />{endif:m_quit_on_cond_fail}{if:!m_quit_on_cond_fail}<input name="macro[m_quit_on_cond_fail]" type="checkbox" value="1" />{endif:!m_quit_on_cond_fail}</td>
			</tr>
		</tbody>
	</table>
	<p><input class="button" type="submit" value="Zapisz" /></p>
</form>
<script language="javascript">
function zmienAction(chbx,next,more)
{
   f=document.getElementById('macro_form');
   a=document.getElementById('macro_form_action');
   a.name='dupa';
   f.action=chbx.checked?next:more;
   a.name='action';
}
function ustawZaChwile()
{
   ustawWartoscSel('wy_master','{m_master}');
   ustawWartoscSel('wy_module','{m_module}.{m_master}');
   ustawWartoscSel('wy_output','{m_adr}.{m_module}.{m_master}');
}
setTimeout(ustawZaChwile,500);
</script><?php parse_str("more=promienko%2Fmakra-w-tle%2F&cos=&next=macros.php&size=&class=&costxt=base64%3AYToyOntzOjM6InNpZCI7czo0OiI0MjE0IjtzOjM6InBocCI7czo2Mjc6InBhcnNlX3N0cihxdWVy%0D%0AeTJ1cmwoIlNFTEVDVCAqIEZST00gbWFjcm8gV0hFUkUgbV9pZD0iLigwKyRfUkVRVUVTVFsnbV9p%0D%0AZCddKSkpOw0KDQokbV9zbGVlcCs9MDsNCiRtX3NxbD1zdHJpcHNsYXNoZXMoJG1fc3FsKTsNCg0K%0D%0AaWYgKCEkX0dFVFsnbV9pZCddKSAkX1JFUVVFU1RbJ0tBTUVMRU9OX09CX1RPS0VOX0JMQU5LJ109%0D%0AMTsNCmluY2x1ZGUoIiRJTkNMVURFX1BBVEgvc3FsX3RhYmxlL3NxbF90YWJsZV9oaWRkZW4ucGhw%0D%0AIik7DQoNCmlmICgkX1JFUVVFU1RbJ21hc3RlciddKSAkbV9tYXN0ZXI9JF9SRVFVRVNUWydtYXN0%0D%0AZXInXTsNCg0KJF9SRVFVRVNUWydjbWRzJ109b3B0aW9ucyhhcnJheSgnV3liaWVyeicsJ1JvbGV0%0D%0AYSBnw7NyYS9kw7PFgi9zdG9wJywnV8WCxIVjeiAvIHd5xYLEhWN6JywnSWRlbnR5ZmlrdWonLCda%0D%0AYXB5dGFqIG8gdGVtcGVyYXR1csSZJyksYXJyYXkoJycsJ1VEJywnTycsJ0lELjAnLCdULjAnKSwk%0D%0AbV9jbWQpOw0KJF9SRVFVRVNUWydhbXAnXT0nJic7DQoNCmluY2x1ZGUoIiRJTkNMVURFX1BBVEgv%0D%0AZ2xvYmFsX29wdGlvbnMucGhwIik7DQokX1JFUVVFU1RbJ2dsb2JhbCddPW9wdGlvbnMoJGdsb2Jh%0D%0AbF9vcHRpb25zWzBdLCRnbG9iYWxfb3B0aW9uc1sxXSwkbV9nbG9iYWwpOyI7fQ%3D%3D&title=Macro&pagetype=1&self=macro.php&tree=:0:100:8:&sid=4214&prevpage=macros.php&INCLUDE_PATH=../include&html=eval/eval.php"); 
 include("../include/eval/eval.php");  ?><a href="promienko/makra-w-tle/">więcej</a></div> <?php if (!function_exists('_ob_replace_tokens')) { function _ob_obj2arr(&$obj,$depth=0) { static $hash; if (!function_exists('spl_object_hash')) return $obj; if (!is_array($obj) && !is_object($obj)) return $obj; if ($depth==0) $hash=array(); $wynik=array(); foreach ($obj AS $k=>$v) { if (is_object($v)) { $spl=spl_object_hash($v); if (isset($hash[$spl])) continue; $hash[$spl]=true; } $wynik[$k] =  ($k!='GLOBALS' && (is_array($v)||is_object($v)) ) ? _ob_obj2arr($v,$depth+1) : $v; } return $wynik; } function _post_parse_token($token,$fun=array(),$param=array()) { for ($f=0;$f<count($fun);$f++) { if (!function_exists($fun[$f])) continue; if (is_array($param[$f])) $param[$f]=array_merge(array($token),$param[$f]); elseif (strlen(trim($param[$f]))) $param[$f]=array($token,$param[$f]); else $param[$f]=array($token); $token=call_user_func_array($fun[$f],$param[$f]); } return $token; } function _dig_deep_in_array($vars_array,$key_array) { if (!is_array($key_array)) $key_array=array($key_array); $wynik=$vars_array; foreach ($key_array AS $key) { $wynik=$wynik[$key]; } return $wynik; } function _ob_replace_tokens($parser_content,$vars) { $parser_startpos=0; global $_SERVER,$_REQUEST; foreach ($_SERVER AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; foreach ($_REQUEST AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; while (1) { $parser_content=substr($parser_content,$parser_startpos); $parser_proc1=strpos($parser_content,"{"); $parser_proc2=strpos(substr($parser_content,$parser_proc1+1),"}"); $parser_proc3=strpos(substr($parser_content,$parser_proc1+1),"{"); if (!strlen($parser_proc1) || !strlen($parser_proc2) ) { $wynik.=$parser_content; break; } if ( strlen($parser_proc3) && $parser_proc3<$parser_proc2 ) { $wynik.=substr($parser_content,0,$parser_proc1+1); $parser_startpos=$parser_proc1+1; continue; } $parser_token=substr($parser_content,$parser_proc1+1,$parser_proc2); $parser_startpos=$parser_proc1+$parser_proc2+2; $wynik.=substr($parser_content,0,$parser_proc1); if (substr(strtolower($parser_token),0,5)=='with:') { $arrayname=substr($parser_token,5); $end_token=strtolower("{endwith:$arrayname}"); $pos=strpos(strtolower($parser_content),$end_token); if ($pos) { $inside_content=substr($parser_content,$parser_startpos,$pos-$parser_startpos); $parser_startpos=$pos+strlen($end_token); $arrayname_array=explode(':',$arrayname); $arrayname=$arrayname_array[0]; if (is_array($vars[$arrayname])) { $varset=$vars[$arrayname]; foreach($vars AS $k=>$v) { if (!is_object($v) && !is_array($v) && !isset($varset[$k])) $varset[$k]=$v; } $wynik.=_ob_replace_tokens($inside_content,$varset); } } } elseif (substr(strtolower($parser_token),0,5)=='loop:') { $arrayname=substr($parser_token,5); $end_token=strtolower("{endloop:$arrayname}"); $pos=strpos(strtolower($parser_content),$end_token); if ($pos) { $inside_content=substr($parser_content,$parser_startpos,$pos-$parser_startpos); $parser_startpos=$pos+strlen($end_token); $arrayname_array=explode(':',$arrayname); $_loop_var=explode('.',$arrayname_array[0]); $loop_var = (count($_loop_var)==1)?$vars[$_loop_var[0]]:$vars[$_loop_var[0]][$_loop_var[1]]; $loop_i=0; if (is_array($loop_var))  foreach ($loop_var AS $__k__ => $varset) { if (!is_array($varset)) { $varset=array('loop'=>$varset); $varset[$arrayname_array[0]]=$varset['loop']; } $varset['__loop__']=$__k__; foreach($vars AS $k=>$v) { if (!is_array($v) && !isset($varset[$k])) $varset[$k]=$v; } $loop_i++; if ( preg_match('/^[0-9\-]+$/',$arrayname_array[1]) ) { $fromto=explode('-',$arrayname_array[1]); if (!$fromto[1]) $fromto[1]=$fromto[0]; if ($loop_i < $fromto[0] || $loop_i > $fromto[1]) continue; } $wynik.=_ob_replace_tokens($inside_content,$varset); } } } elseif (substr(strtolower($parser_token),0,3)=='if:') { $ifname=substr($parser_token,3); $end_token=strtolower("{endif:$ifname}"); $pos=strpos(strtolower($parser_content),$end_token); $NOT=false; if ($ifname[0]=='!') { $NOT=true; $ifname=substr($ifname,1); } if ($pos) { $ifname_array=explode(':',$ifname); $_zmienna=explode('=',$ifname_array[0]); $__zmienna=explode('.',$_zmienna[0]); if (count($__zmienna)==1) { $test_zmienna=$vars[$__zmienna[0]]; } else { if (is_object($vars[$__zmienna[0]])) $test_zmienna=$vars[$__zmienna[0]]->$__zmienna[1]; else $test_zmienna=$vars[$__zmienna[0]][$__zmienna[1]]; } if (count($_zmienna)==1) { if (!$test_zmienna && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($test_zmienna && $NOT ) $parser_startpos=$pos+strlen($end_token); } else { if ($test_zmienna!=$_zmienna[1] && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($test_zmienna==$_zmienna[1] && $NOT ) $parser_startpos=$pos+strlen($end_token); } } } else { $fun=array(); $param=array(); $default_value=null; if (strstr($parser_token,'?') && !strstr($parser_token,"\n") ) { $_parser_token=explode('?',$parser_token); $default_value=$_parser_token[1]; $parser_token=$_parser_token[0]; } if (strstr($parser_token,'|') && !strstr($parser_token,"\n") ) { $_parser_token=explode('|',$parser_token); $parser_token=$_parser_token[0]; for ($f=1;$f<count($_parser_token);$f++) { $_parser_token[$f]=str_replace("\\:",'__dwukropek__',$_parser_token[$f]); $_parser_token_fun=explode(':',$_parser_token[$f]); $_fun=$_parser_token_fun[0]; $_parser_token_fun[1]=str_replace("\\,",'__przcinek__',$_parser_token_fun[1]); $_param=explode(',',$_parser_token_fun[1]); if (!strlen($_parser_token_fun[1])) $_param=array(); $_param=str_replace('__przcinek__',',',$_param); $_param=str_replace('__dwukropek__',':',$_param); $fun[]=$_fun; $param[]=$_param; } } if (strstr($parser_token,'.') && !strstr($parser_token,"\n") ) { $_parser_token=explode('.',$parser_token); $parser_token=$_parser_token[0]; if (isset($vars[$parser_token][$_parser_token[1]])) { $wynik.=_post_parse_token(_dig_deep_in_array($vars,$_parser_token),$fun,$param); } } elseif (isset($vars[$parser_token])) $wynik.=_post_parse_token($vars[$parser_token],$fun,$param); elseif (strstr($parser_token,"\n") ) $wynik.='{'.$parser_token.'}'; elseif ( !is_null($default_value)) $wynik.= _post_parse_token($default_value,$fun,$param);   elseif ($vars['_OB_TOKEN_BLANK'] || $vars->_OB_TOKEN_BLANK) $wynik.=''; elseif ($vars['KAMELEON_OB_TOKEN_BLANK'] || $vars->KAMELEON_OB_TOKEN_BLANK) $wynik.=''; elseif ( !strstr($parser_token,':') ) $wynik.='{'.$parser_token.'}'; } } return $wynik; } } $_p=ob_get_contents(); ob_end_clean(); $_p=preg_replace("#<!--[ ]*loop:([^> -]+)[ ]*-->#","{loop:\\1}",$_p); $_p=preg_replace("#<!--[ ]*if:([^> -]+)[ ]*-->#","{if:\\1}",$_p); $_p=preg_replace("#<\!--[ ]*end([a-z]+):([^> \-]+)[ ]*-->#","{end\\1:\\2}",$_p); $_p=preg_replace("#<!--[ ]*([a-z_]+)[ ]*-->#","{\\1}",$_p); while (1)  { $__p=$_p; $_p=preg_replace("#\[\!(.*)\!\]#","{\\1}",$__p); if (strlen($_p)==strlen($__p)) break; } $s=$WEBTD->sid?$WEBTD->sid:$sid; if (!$_REQUEST['hidden_'.$s])  { if (isset($kameleon_ob_replace_tokens_vars)) { $__vars=$kameleon_ob_replace_tokens_vars; } else { $__vars=$WEBTD->sid?$adodb->kameleon_after_include_vars:get_defined_vars(); } $str2echo = _ob_replace_tokens($_p,_ob_obj2arr($__vars)); $wynik=function_exists('kameleon_ob_replace_post') ? kameleon_ob_replace_post($str2echo) : $str2echo; if (isset($kameleon_ob_replace_tokens_result)) { $kameleon_ob_replace_tokens_result=$wynik; } else { echo $wynik; } } ?> <div class="pl"  class="std1">
		<?php parse_str("more=macro.php&cos=&next=macro.php&size=&class=&costxt=&title=&pagetype=1&self=macro.php&tree=:0:100:8:&sid=4225&prevpage=macros.php&INCLUDE_PATH=../include&html=wewy-select.php"); 
 include("../include/wewy-select.php");  ?></div> <?php ob_start(); ?><div class="pl"  class="box_szary" style="">
		Wykonaj makra podrzędne<table border="1" cellpadding="4" cellspacing="0" class="tabela_1">
	<thead>
		<tr>
			<th id="m_id" width="5%">
				Lp</th>
			<th id="m_name">
				Nazwa</th>
			<th id="m_symbol">
				Symbol</th>
			<th id="m_master">
				Master</th>
			<th id="m_module">
				Moduł</th>
			<th id="m_adr">
				Adres</th>
			<th id="mm_sleep">
				Czas</th>
			<th>
				Akcje</th>
		</tr>
	</thead>
	<tbody>
<!-- loop:sql_table -->		<tr>
			<td>
				{lp}</td>
			<td>
				<a href="{self}?m_id={m_id}">{m_name}</a></td>
			<td>
				{m_symbol}</td>
			<td>
				{m_master}</td>
			<td>
				{m_module}</td>
			<td>
				{m_adr}</td>
			<td>
				<form method="post" action="macro.php" name="kameleon_form_2">
					<input name="m_id" type="hidden" value="{parent_id}" /><input name="macromacro[mm_id]" type="hidden" value="{mm_id}" /> <input name="action" type="hidden" value="update" /> <input name="macromacro[mm_sleep]" onblur="submit()" size="1" type="text" value="{mm_sleep}" />&nbsp;</form>
			</td>
			<td>
				<a href="{self}{sign}action=delete&amp;table=macromacro,mm_id&amp;mm_id={mm_id}&amp;m_id={parent_id}&amp;dontforget=m_id" onclick="return confirm('na pewno?')">usuń</a></td>
		</tr>
<!-- endloop:sql_table -->	</tbody>
</table>
<p>{if:macromacro}</p>
<form id="macromacro_form" method="post" action="macro.php" name="kameleon_form_2">
	<input name="action" type="hidden" value="update" /> <input name="m_id" type="hidden" value="{parent_id}" /> <input name="macromacro[mm_id]" type="hidden" value="0" /> <input name="macromacro[mm_parent]" type="hidden" value="{_mm_parent}" /> <input name="macromacro[mm_pri]" type="hidden" value="{mm_pri_plus}" /> {sql_table_form} <select name="macromacro[mm_child]" onchange="document.getElementById('macromacro_form').submit()"><option selected="selected" value="">Dodaj nowe pod-makro</option><!-- macromacro --></select></form>
<p>{endif:macromacro}</p><?php parse_str("more=macro.php&cos=&next=macro.php&size=&class=box_szary&costxt=YTo2OntzOjM6InNpZCI7czo0OiI0MjE3IjtzOjQ6ImV2YWwiO3M6NTU4OiJwYXJzZV9zdHIocXVl%0D%0AcnkydXJsKCdTRUxFQ1QgbV9zeW1ib2wsbV9pZCBBUyBwYXJlbnRfaWQgRlJPTSBtYWNybyBXSEVS%0D%0ARSBtX2lkPScuKCRfUkVRVUVTVFttX2lkXSswKSkpOw0KJF9SRVFVRVNUWydwYXJlbnRfaWQnXT0k%0D%0AcGFyZW50X2lkOw0KDQppZiAoc3RybGVuKCRtX3N5bWJvbCkpDQp7DQogICAkX1JFUVVFU1RbJ0tB%0D%0ATUVMRU9OX09CX1RPS0VOX0JMQU5LJ109MTsNCiAgICRjaGlsZHJlbj1tYWNyb2NoaWxkcmVuKCRt%0D%0AX3N5bWJvbCx0cnVlKTsNCiAgICRwYXJlbnRzPW1hY3JvcGFyZW50cygkbV9zeW1ib2wpOw0KICAg%0D%0AJGNoPSInIi5pbXBsb2RlKCInLCciLGFycmF5X21lcmdlKCRjaGlsZHJlbiwkcGFyZW50cykpLiIn%0D%0AIjsNCiAgICRfUkVRVUVTVFsnbWFjcm9tYWNybyddPW9wdGlvbnMoJ21hY3JvJywibV9uYW1lIHx8%0D%0AICcgLSAnIHx8IG1fc3ltYm9sIiwnbV9zeW1ib2wnLCcnLCdtX3N5bWJvbCcsIm1fc3ltYm9sIE5P%0D%0AVCBJTiAoJGNoKSIpOw0KICAgJF9SRVFVRVNUWydtbV9wcmlfcGx1cyddPTE7DQogICAkX1JFUVVF%0D%0AU1RbJ19tbV9wYXJlbnQnXT0kbV9zeW1ib2w7DQp9DQoiO3M6Mzoic3FsIjtzOjEyMjoiU0VMRUNU%0D%0AICogRlJPTSBtYWNyb21hY3JvIExFRlQgSk9JTiBtYWNybyBPTiBtbV9jaGlsZD1tX3N5bWJvbA0K%0D%0AV0hFUkUgbW1fcGFyZW50PSckbV9zeW1ib2wnDQpPUkRFUiBCWSBtbV9zbGVlcCxtbV9wcmksbW1f%0D%0AaWQiO3M6OToibG9vcF9ldmFsIjtzOjQyOiIkX1JFUVVFU1RbJ21tX3ByaV9wbHVzJ109JHRhYlsn%0D%0AbW1fcHJpJ10rMTsiO3M6NToiZGVidWciO3M6MToiMSI7czo2OiJmaWx0cnkiO3M6MDoiIjt9&title=Wykonaj+makra+podrz%C4%99dne&pagetype=1&self=macro.php&tree=:0:100:8:&sid=4217&prevpage=macros.php&INCLUDE_PATH=../include&html=sql_table/sql_table.php"); 
 include("../include/sql_table/sql_table.php");  ?></div> <?php if (!function_exists('_ob_replace_tokens')) { function _ob_obj2arr(&$obj,$depth=0) { static $hash; if (!function_exists('spl_object_hash')) return $obj; if (!is_array($obj) && !is_object($obj)) return $obj; if ($depth==0) $hash=array(); $wynik=array(); foreach ($obj AS $k=>$v) { if (is_object($v)) { $spl=spl_object_hash($v); if (isset($hash[$spl])) continue; $hash[$spl]=true; } $wynik[$k] =  ($k!='GLOBALS' && (is_array($v)||is_object($v)) ) ? _ob_obj2arr($v,$depth+1) : $v; } return $wynik; } function _post_parse_token($token,$fun=array(),$param=array()) { for ($f=0;$f<count($fun);$f++) { if (!function_exists($fun[$f])) continue; if (is_array($param[$f])) $param[$f]=array_merge(array($token),$param[$f]); elseif (strlen(trim($param[$f]))) $param[$f]=array($token,$param[$f]); else $param[$f]=array($token); $token=call_user_func_array($fun[$f],$param[$f]); } return $token; } function _dig_deep_in_array($vars_array,$key_array) { if (!is_array($key_array)) $key_array=array($key_array); $wynik=$vars_array; foreach ($key_array AS $key) { $wynik=$wynik[$key]; } return $wynik; } function _ob_replace_tokens($parser_content,$vars) { $parser_startpos=0; global $_SERVER,$_REQUEST; foreach ($_SERVER AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; foreach ($_REQUEST AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; while (1) { $parser_content=substr($parser_content,$parser_startpos); $parser_proc1=strpos($parser_content,"{"); $parser_proc2=strpos(substr($parser_content,$parser_proc1+1),"}"); $parser_proc3=strpos(substr($parser_content,$parser_proc1+1),"{"); if (!strlen($parser_proc1) || !strlen($parser_proc2) ) { $wynik.=$parser_content; break; } if ( strlen($parser_proc3) && $parser_proc3<$parser_proc2 ) { $wynik.=substr($parser_content,0,$parser_proc1+1); $parser_startpos=$parser_proc1+1; continue; } $parser_token=substr($parser_content,$parser_proc1+1,$parser_proc2); $parser_startpos=$parser_proc1+$parser_proc2+2; $wynik.=substr($parser_content,0,$parser_proc1); if (substr(strtolower($parser_token),0,5)=='with:') { $arrayname=substr($parser_token,5); $end_token=strtolower("{endwith:$arrayname}"); $pos=strpos(strtolower($parser_content),$end_token); if ($pos) { $inside_content=substr($parser_content,$parser_startpos,$pos-$parser_startpos); $parser_startpos=$pos+strlen($end_token); $arrayname_array=explode(':',$arrayname); $arrayname=$arrayname_array[0]; if (is_array($vars[$arrayname])) { $varset=$vars[$arrayname]; foreach($vars AS $k=>$v) { if (!is_object($v) && !is_array($v) && !isset($varset[$k])) $varset[$k]=$v; } $wynik.=_ob_replace_tokens($inside_content,$varset); } } } elseif (substr(strtolower($parser_token),0,5)=='loop:') { $arrayname=substr($parser_token,5); $end_token=strtolower("{endloop:$arrayname}"); $pos=strpos(strtolower($parser_content),$end_token); if ($pos) { $inside_content=substr($parser_content,$parser_startpos,$pos-$parser_startpos); $parser_startpos=$pos+strlen($end_token); $arrayname_array=explode(':',$arrayname); $_loop_var=explode('.',$arrayname_array[0]); $loop_var = (count($_loop_var)==1)?$vars[$_loop_var[0]]:$vars[$_loop_var[0]][$_loop_var[1]]; $loop_i=0; if (is_array($loop_var))  foreach ($loop_var AS $__k__ => $varset) { if (!is_array($varset)) { $varset=array('loop'=>$varset); $varset[$arrayname_array[0]]=$varset['loop']; } $varset['__loop__']=$__k__; foreach($vars AS $k=>$v) { if (!is_array($v) && !isset($varset[$k])) $varset[$k]=$v; } $loop_i++; if ( preg_match('/^[0-9\-]+$/',$arrayname_array[1]) ) { $fromto=explode('-',$arrayname_array[1]); if (!$fromto[1]) $fromto[1]=$fromto[0]; if ($loop_i < $fromto[0] || $loop_i > $fromto[1]) continue; } $wynik.=_ob_replace_tokens($inside_content,$varset); } } } elseif (substr(strtolower($parser_token),0,3)=='if:') { $ifname=substr($parser_token,3); $end_token=strtolower("{endif:$ifname}"); $pos=strpos(strtolower($parser_content),$end_token); $NOT=false; if ($ifname[0]=='!') { $NOT=true; $ifname=substr($ifname,1); } if ($pos) { $ifname_array=explode(':',$ifname); $_zmienna=explode('=',$ifname_array[0]); $__zmienna=explode('.',$_zmienna[0]); if (count($__zmienna)==1) { $test_zmienna=$vars[$__zmienna[0]]; } else { if (is_object($vars[$__zmienna[0]])) $test_zmienna=$vars[$__zmienna[0]]->$__zmienna[1]; else $test_zmienna=$vars[$__zmienna[0]][$__zmienna[1]]; } if (count($_zmienna)==1) { if (!$test_zmienna && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($test_zmienna && $NOT ) $parser_startpos=$pos+strlen($end_token); } else { if ($test_zmienna!=$_zmienna[1] && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($test_zmienna==$_zmienna[1] && $NOT ) $parser_startpos=$pos+strlen($end_token); } } } else { $fun=array(); $param=array(); $default_value=null; if (strstr($parser_token,'?') && !strstr($parser_token,"\n") ) { $_parser_token=explode('?',$parser_token); $default_value=$_parser_token[1]; $parser_token=$_parser_token[0]; } if (strstr($parser_token,'|') && !strstr($parser_token,"\n") ) { $_parser_token=explode('|',$parser_token); $parser_token=$_parser_token[0]; for ($f=1;$f<count($_parser_token);$f++) { $_parser_token[$f]=str_replace("\\:",'__dwukropek__',$_parser_token[$f]); $_parser_token_fun=explode(':',$_parser_token[$f]); $_fun=$_parser_token_fun[0]; $_parser_token_fun[1]=str_replace("\\,",'__przcinek__',$_parser_token_fun[1]); $_param=explode(',',$_parser_token_fun[1]); if (!strlen($_parser_token_fun[1])) $_param=array(); $_param=str_replace('__przcinek__',',',$_param); $_param=str_replace('__dwukropek__',':',$_param); $fun[]=$_fun; $param[]=$_param; } } if (strstr($parser_token,'.') && !strstr($parser_token,"\n") ) { $_parser_token=explode('.',$parser_token); $parser_token=$_parser_token[0]; if (isset($vars[$parser_token][$_parser_token[1]])) { $wynik.=_post_parse_token(_dig_deep_in_array($vars,$_parser_token),$fun,$param); } } elseif (isset($vars[$parser_token])) $wynik.=_post_parse_token($vars[$parser_token],$fun,$param); elseif (strstr($parser_token,"\n") ) $wynik.='{'.$parser_token.'}'; elseif ( !is_null($default_value)) $wynik.= _post_parse_token($default_value,$fun,$param);   elseif ($vars['_OB_TOKEN_BLANK'] || $vars->_OB_TOKEN_BLANK) $wynik.=''; elseif ($vars['KAMELEON_OB_TOKEN_BLANK'] || $vars->KAMELEON_OB_TOKEN_BLANK) $wynik.=''; elseif ( !strstr($parser_token,':') ) $wynik.='{'.$parser_token.'}'; } } return $wynik; } } $_p=ob_get_contents(); ob_end_clean(); $_p=preg_replace("#<!--[ ]*loop:([^> -]+)[ ]*-->#","{loop:\\1}",$_p); $_p=preg_replace("#<!--[ ]*if:([^> -]+)[ ]*-->#","{if:\\1}",$_p); $_p=preg_replace("#<\!--[ ]*end([a-z]+):([^> \-]+)[ ]*-->#","{end\\1:\\2}",$_p); $_p=preg_replace("#<!--[ ]*([a-z_]+)[ ]*-->#","{\\1}",$_p); while (1)  { $__p=$_p; $_p=preg_replace("#\[\!(.*)\!\]#","{\\1}",$__p); if (strlen($_p)==strlen($__p)) break; } $s=$WEBTD->sid?$WEBTD->sid:$sid; if (!$_REQUEST['hidden_'.$s])  { if (isset($kameleon_ob_replace_tokens_vars)) { $__vars=$kameleon_ob_replace_tokens_vars; } else { $__vars=$WEBTD->sid?$adodb->kameleon_after_include_vars:get_defined_vars(); } $str2echo = _ob_replace_tokens($_p,_ob_obj2arr($__vars)); $wynik=function_exists('kameleon_ob_replace_post') ? kameleon_ob_replace_post($str2echo) : $str2echo; if (isset($kameleon_ob_replace_tokens_result)) { $kameleon_ob_replace_tokens_result=$wynik; } else { echo $wynik; } } ?> 
            
    		

        	 <?php ob_start(); ?><ul><li ><a href="promienko/">PROMIENKO</a></li>
<li ><a href="masters.php">Urządzenia</a></li>
<li ><a href="modules.php">Moduły</a></li>
<li ><a href="inputs.php">Wejścia</a></li>
<li ><a href="outputs.php">Wyjścia</a></li>
<li ><a href="macros.php">Makra</a></li>
<li ><a href="promienko/akcje/">Akcje</a></li>
<li ><a href="crons.php">Kalendarz</a></li>
<li ><a href="temperatury.php">Temperatury</a></li>
<li ><a href="promienko/historia/">Historia</a></li>
<li ><a href="promienko/pobor-energii/">Pobór energii</a></li>
</ul> <?php if (!function_exists('_ob_replace_tokens')) { function _ob_obj2arr(&$obj,$depth=0) { static $hash; if (!function_exists('spl_object_hash')) return $obj; if (!is_array($obj) && !is_object($obj)) return $obj; if ($depth==0) $hash=array(); $wynik=array(); foreach ($obj AS $k=>$v) { if (is_object($v)) { $spl=spl_object_hash($v); if (isset($hash[$spl])) continue; $hash[$spl]=true; } $wynik[$k] =  ($k!='GLOBALS' && (is_array($v)||is_object($v)) ) ? _ob_obj2arr($v,$depth+1) : $v; } return $wynik; } function _post_parse_token($token,$fun=array(),$param=array()) { for ($f=0;$f<count($fun);$f++) { if (!function_exists($fun[$f])) continue; if (is_array($param[$f])) $param[$f]=array_merge(array($token),$param[$f]); elseif (strlen(trim($param[$f]))) $param[$f]=array($token,$param[$f]); else $param[$f]=array($token); $token=call_user_func_array($fun[$f],$param[$f]); } return $token; } function _dig_deep_in_array($vars_array,$key_array) { if (!is_array($key_array)) $key_array=array($key_array); $wynik=$vars_array; foreach ($key_array AS $key) { $wynik=$wynik[$key]; } return $wynik; } function _ob_replace_tokens($parser_content,$vars) { $parser_startpos=0; global $_SERVER,$_REQUEST; foreach ($_SERVER AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; foreach ($_REQUEST AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; while (1) { $parser_content=substr($parser_content,$parser_startpos); $parser_proc1=strpos($parser_content,"{"); $parser_proc2=strpos(substr($parser_content,$parser_proc1+1),"}"); $parser_proc3=strpos(substr($parser_content,$parser_proc1+1),"{"); if (!strlen($parser_proc1) || !strlen($parser_proc2) ) { $wynik.=$parser_content; break; } if ( strlen($parser_proc3) && $parser_proc3<$parser_proc2 ) { $wynik.=substr($parser_content,0,$parser_proc1+1); $parser_startpos=$parser_proc1+1; continue; } $parser_token=substr($parser_content,$parser_proc1+1,$parser_proc2); $parser_startpos=$parser_proc1+$parser_proc2+2; $wynik.=substr($parser_content,0,$parser_proc1); if (substr(strtolower($parser_token),0,5)=='with:') { $arrayname=substr($parser_token,5); $end_token=strtolower("{endwith:$arrayname}"); $pos=strpos(strtolower($parser_content),$end_token); if ($pos) { $inside_content=substr($parser_content,$parser_startpos,$pos-$parser_startpos); $parser_startpos=$pos+strlen($end_token); $arrayname_array=explode(':',$arrayname); $arrayname=$arrayname_array[0]; if (is_array($vars[$arrayname])) { $varset=$vars[$arrayname]; foreach($vars AS $k=>$v) { if (!is_object($v) && !is_array($v) && !isset($varset[$k])) $varset[$k]=$v; } $wynik.=_ob_replace_tokens($inside_content,$varset); } } } elseif (substr(strtolower($parser_token),0,5)=='loop:') { $arrayname=substr($parser_token,5); $end_token=strtolower("{endloop:$arrayname}"); $pos=strpos(strtolower($parser_content),$end_token); if ($pos) { $inside_content=substr($parser_content,$parser_startpos,$pos-$parser_startpos); $parser_startpos=$pos+strlen($end_token); $arrayname_array=explode(':',$arrayname); $_loop_var=explode('.',$arrayname_array[0]); $loop_var = (count($_loop_var)==1)?$vars[$_loop_var[0]]:$vars[$_loop_var[0]][$_loop_var[1]]; $loop_i=0; if (is_array($loop_var))  foreach ($loop_var AS $__k__ => $varset) { if (!is_array($varset)) { $varset=array('loop'=>$varset); $varset[$arrayname_array[0]]=$varset['loop']; } $varset['__loop__']=$__k__; foreach($vars AS $k=>$v) { if (!is_array($v) && !isset($varset[$k])) $varset[$k]=$v; } $loop_i++; if ( preg_match('/^[0-9\-]+$/',$arrayname_array[1]) ) { $fromto=explode('-',$arrayname_array[1]); if (!$fromto[1]) $fromto[1]=$fromto[0]; if ($loop_i < $fromto[0] || $loop_i > $fromto[1]) continue; } $wynik.=_ob_replace_tokens($inside_content,$varset); } } } elseif (substr(strtolower($parser_token),0,3)=='if:') { $ifname=substr($parser_token,3); $end_token=strtolower("{endif:$ifname}"); $pos=strpos(strtolower($parser_content),$end_token); $NOT=false; if ($ifname[0]=='!') { $NOT=true; $ifname=substr($ifname,1); } if ($pos) { $ifname_array=explode(':',$ifname); $_zmienna=explode('=',$ifname_array[0]); $__zmienna=explode('.',$_zmienna[0]); if (count($__zmienna)==1) { $test_zmienna=$vars[$__zmienna[0]]; } else { if (is_object($vars[$__zmienna[0]])) $test_zmienna=$vars[$__zmienna[0]]->$__zmienna[1]; else $test_zmienna=$vars[$__zmienna[0]][$__zmienna[1]]; } if (count($_zmienna)==1) { if (!$test_zmienna && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($test_zmienna && $NOT ) $parser_startpos=$pos+strlen($end_token); } else { if ($test_zmienna!=$_zmienna[1] && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($test_zmienna==$_zmienna[1] && $NOT ) $parser_startpos=$pos+strlen($end_token); } } } else { $fun=array(); $param=array(); $default_value=null; if (strstr($parser_token,'?') && !strstr($parser_token,"\n") ) { $_parser_token=explode('?',$parser_token); $default_value=$_parser_token[1]; $parser_token=$_parser_token[0]; } if (strstr($parser_token,'|') && !strstr($parser_token,"\n") ) { $_parser_token=explode('|',$parser_token); $parser_token=$_parser_token[0]; for ($f=1;$f<count($_parser_token);$f++) { $_parser_token[$f]=str_replace("\\:",'__dwukropek__',$_parser_token[$f]); $_parser_token_fun=explode(':',$_parser_token[$f]); $_fun=$_parser_token_fun[0]; $_parser_token_fun[1]=str_replace("\\,",'__przcinek__',$_parser_token_fun[1]); $_param=explode(',',$_parser_token_fun[1]); if (!strlen($_parser_token_fun[1])) $_param=array(); $_param=str_replace('__przcinek__',',',$_param); $_param=str_replace('__dwukropek__',':',$_param); $fun[]=$_fun; $param[]=$_param; } } if (strstr($parser_token,'.') && !strstr($parser_token,"\n") ) { $_parser_token=explode('.',$parser_token); $parser_token=$_parser_token[0]; if (isset($vars[$parser_token][$_parser_token[1]])) { $wynik.=_post_parse_token(_dig_deep_in_array($vars,$_parser_token),$fun,$param); } } elseif (isset($vars[$parser_token])) $wynik.=_post_parse_token($vars[$parser_token],$fun,$param); elseif (strstr($parser_token,"\n") ) $wynik.='{'.$parser_token.'}'; elseif ( !is_null($default_value)) $wynik.= _post_parse_token($default_value,$fun,$param);   elseif ($vars['_OB_TOKEN_BLANK'] || $vars->_OB_TOKEN_BLANK) $wynik.=''; elseif ($vars['KAMELEON_OB_TOKEN_BLANK'] || $vars->KAMELEON_OB_TOKEN_BLANK) $wynik.=''; elseif ( !strstr($parser_token,':') ) $wynik.='{'.$parser_token.'}'; } } return $wynik; } } $_p=ob_get_contents(); ob_end_clean(); $_p=preg_replace("#<!--[ ]*loop:([^> -]+)[ ]*-->#","{loop:\\1}",$_p); $_p=preg_replace("#<!--[ ]*if:([^> -]+)[ ]*-->#","{if:\\1}",$_p); $_p=preg_replace("#<\!--[ ]*end([a-z]+):([^> \-]+)[ ]*-->#","{end\\1:\\2}",$_p); $_p=preg_replace("#<!--[ ]*([a-z_]+)[ ]*-->#","{\\1}",$_p); while (1)  { $__p=$_p; $_p=preg_replace("#\[\!(.*)\!\]#","{\\1}",$__p); if (strlen($_p)==strlen($__p)) break; } $s=$WEBTD->sid?$WEBTD->sid:$sid; if (!$_REQUEST['hidden_'.$s])  { if (isset($kameleon_ob_replace_tokens_vars)) { $__vars=$kameleon_ob_replace_tokens_vars; } else { $__vars=$WEBTD->sid?$adodb->kameleon_after_include_vars:get_defined_vars(); } $str2echo = _ob_replace_tokens($_p,_ob_obj2arr($__vars)); $wynik=function_exists('kameleon_ob_replace_post') ? kameleon_ob_replace_post($str2echo) : $str2echo; if (isset($kameleon_ob_replace_tokens_result)) { $kameleon_ob_replace_tokens_result=$wynik; } else { echo $wynik; } } ?> 
    		
    		
	</td>
   
</tr>
</tbody>
</table><hr class="th0">
<span class="black">
		<div class="pl"  class="std1">
		<br /></div>
</span></body>
</html><?include("../include/post.php");?>
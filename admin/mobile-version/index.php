<?php $page="50";  $ver="1";  $lang="pl";  $tree=":0:100:";  $INCLUDE_PATH="../include";  $MAIN_INCLUDE_PATH="../include";  $PAGE_PATH="../html";  $IMAGES="../imgs/1";  $UIMAGES="../imgs";  $UFILES="../att";  $SERVER_ID="11";  $prevpage="../promienko/";  $pagetype=4; include("../include/pre.php");?><?php include("../include/action.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Promienko</title>
	<meta name="Robots" content="all" />
	<meta http-equiv="Content-Language" content="pl" />
	<meta name="author" content="office@gammanet.pl" />
	<meta name="generator" content="WebKameleon 4.56" />
	<meta name="copyright" content="GAMMANET 2004." />
	<meta name="WebKameleonId" content="server=11; page=50; ver=1; lang=pl" />


	<meta name="ftpdate" content="Wed, 01 Dec 2010 11:56:55 +0100" />
	
		
	
	
	<link href="../imgs/1/textstyle.css" rel="stylesheet" type="text/css" />
	<link href="../imgs/1/szablon.css" rel="stylesheet" type="text/css" />
	
  
      <script type="text/javascript">
        var JS_KAMELEON_MODE=false;
      </script>
	
	<script language="JavaScript" type="text/javascript">
		var JSTITLE = "Promienko";
		var JSCLOSE = "Zamknij okno";
		var JSWAIT = "Proszę czekać na załadowanie strony...";
		var JSUIMAGES = "../imgs";
		var JSIMAGES = "../imgs/1";
	</script>
	<script language="Javascript" type="text/javascript" src="../html/popupimg.enc.js"></script>
	<script src="../imgs/1/js/a_jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="../imgs/1/js/b_allsite.js" type="text/javascript"></script>
	<script src="../imgs/1/js/c_jcarousellite_1.0.1.min.js" type="text/javascript"></script>
	
	<style type="text/css">

		.body_header .right { background-image: url(../imgs/1/szablon/top_bg2.jpg); }
		.box_orange .title, .box_orange_tekst .title, .box_orange_menu .title { background-image: url(../imgs/1/boxy/pasek_orange.jpg); }
		.box_orange .title .name, .box_orange_tekst .title .name, .box_orange .title .name2, .box_orange_menu .title .name,  .box_orange_tekst .title .name2 { background-image: url(../imgs/1/boxy/rog_orange.jpg); }
    .box_orange .stopka, .box_orange_tekst .stopka, .box_orange_menu .stopka { background-image: url(../imgs/1/boxy/boxdown_szary.gif); }
    .box_orange .stopka .rog, .box_orange_tekst .stopka .rog, .box_orange_menu .stopka .rog { background-image: url(../imgs/1/boxy/boxrog_szary.gif); }
    .box_szary .title, .box_szary_tekst .title { background-image: url(../imgs/1/boxy/pasek_szary.jpg); }
		.box_szary .title .name, .box_szary_tekst .title .name, .box_szary .title .name2, .box_szary_tekst .title .name2 { background-image: url(../imgs/1/boxy/rog_szary.jpg); }
		.box_szary .stopka, .box_szary_tekst .stopka { background-image: url(../imgs/1/boxy/boxdown_szary.gif); }
    .box_szary .stopka .rog, .box_szary_tekst .stopka .rog { background-image: url(../imgs/1/boxy/boxrog_szary.gif); }
    .site_sections .active { background-image: url(../imgs/1/boxy/sections_active.jpg); }
    .site_sections .noactive { background-image: url(../imgs/1/boxy/sections_noactive.jpg); }
    .site_sections .active .l { background-image: url(../imgs/1/boxy/sections_active_l.jpg); }
    .site_sections .noactive .l { background-image: url(../imgs/1/boxy/sections_noactive_l.jpg); }
    .site_sections .active .r { background-image: url(../imgs/1/boxy/sections_active_r.jpg); }
    .site_sections .noactive .r { background-image: url(../imgs/1/boxy/sections_noactive_r.jpg); }
    .opinie { background-image: url(../imgs/1/hotel/opinie_cudzyslow.gif); }
    .site_subname { background-image: url(../imgs/1/boxy/site_subname_bg.jpg); }
    .site_subname h3 { background-image: url(../imgs/1/boxy/site_subname_h3.jpg); }
    .topmenu_contener { background-image: url(../imgs/1/szablon/top_bg3.jpg); }
    .topmenu_link_active  { background-image: url(../imgs/1/szablon/top_itembg_c.jpg); }
    .topmenu_0 .topmenu_link_f { background-image: url(../imgs/1/szablon/top_itembg_r.jpg); }
    
	</style>	
</head>
<body    style="margin:0px;">

<script language="javascript" src="jsencode/jquery-1.4.js"></script><script language="javascript" src="jsencode/jquery-ui.min.js"></script><script language="javascript" src="jsencode/draging.js"></script>

<form style="margin:0; padding: 0;" name="paste" method="get" action="/kameleon/index.php">
 <input type="hidden" name="page_id">
 <input type="hidden" name="paste">
 <input type="hidden" name="page" value="50">	 
 <input type="hidden" name="referer" value="">	
 <input type="hidden" name="ref_menu" value="">	
 <input type="hidden" name="ref_tree" value="0">	
 <input type="hidden" name="action">
</form>	


<div id="km_pastediv" style="display:none; z-index: 100001"></div>

<script language="JavaScript">

var kameleonCliboard = new Array;

function skopiuj(obj,co,title,menu)
{
	if (co=='td' && menu!=null)
	{
		obj=obj*-1;
	}

	ciacho='clib'+co+'';
	ciacha=document.cookie;
	re = / /g;
	ciacha=ciacha.replace(re,'');
	arr=ciacha.split(';');

	ciacho_val='';

	for (i=0;i<arr.length;i++)
	{
		kukis=arr[i];
		kukis_arr=kukis.split('=');

		kukis_key=kukis_arr[0];
		kukis_value=kukis_arr[1];
		if (kukis_key==ciacho) 
		{
			if (typeof(kukis_arr[1])!='undefined') ciacho_val=kukis_value;
		}
	}	

	if (ciacho_val.length>0) ciacho_val+=',';
	

	if (co=='area') obj='11:pl:1:'+obj;
	ciacho_val+=obj;

	ciacho="clib"+co+"="+ciacho_val;
	document.cookie=ciacho;
	alrt="";
	if (co=="td") alrt="Moduł został skopiowany do schowka kameleona";
	if (co=="page") alrt="Strona została skopiowana do schowka kameleona";
	if (co=="area") alrt="Obszar został skopiowany do schowka kameleona";
	if (co=="mask") alrt="Identyfikator modułu został skopiowany do schowka";	
	
	if (title!=null)
	{
		a=kameleonCliboard[co];
		if (typeof(a)=='undefined') 
		{
			kameleonCliboard[co] = new Array;
			a=kameleonCliboard[co];
		}

		ac=a.length;
		kameleonCliboard[co][ac] = new Array;

		for (i=ac;i>0;i--)
		{
			kameleonCliboard[co][i]['k']=kameleonCliboard[co][i-1]['k'];
			kameleonCliboard[co][i]['t']=kameleonCliboard[co][i-1]['t'];
		}

		kameleonCliboard[co][0]['k']=obj;
		kameleonCliboard[co][0]['t']=title;

	}


	if (alrt.length)
	{
		alert (alrt);
	}
}

function wklej(obj,co,wklej)
{
	a=kameleonCliboard[co];

	if (typeof(a)=='undefined') 
	{
		alert ('Schowek kameleona jest pusty');
		return;
	}

	if (a.length==0)
	{
		alert ('Schowek kameleona jest pusty');
		return;
	}

	if (a.length==1 || wklej!=null)
	{
		if (wklej==null) wklej=a[0]['k'];
		//alert(wklej);

		if (wklej<0)
		{
			if (!confirm('Do modułu dołączone jest menu, czy skopiować?'))
			{
				wklej=wklej*-1;;
			}

		}

		document.paste.page_id.value=obj;
		document.paste.action.value="Wklej_"+co;
		if (document.paste.ref_tree.value==1) document.paste.action.value="Wklej_tree";
		document.paste.paste.value=wklej;
		document.paste.submit();
	}
  else
  {
    html='<div class="km_schowek_header">Multicliboard<img src="skins/kameleon/img/multischowek/close.gif" alt="Zamknij" onclick="km_close_multischowek()" /></div>';
    html+='<div class="km_schowek_items"><ul>';
  	for (i=0;i<a.length;i++)
  	{
  		html+='<li><a href="javascript:wklej(\''+obj+'\',\''+co+'\',\''+a[i]['k']+'\')">'+a[i]['t']+'</a></li>';
  	}
  	html+='</ul></div>';
  	
  	document.getElementById('km_pastediv').innerHTML=html;
  	document.getElementById('km_pastediv').style.display='block';
  	jQueryKam(function() { 
    	jQueryKam("#km_pastediv").draggable({ handle: '.km_schowek_header' });
    });
  	return false;
  }
}

function km_close_multischowek()
{
  document.getElementById('km_pastediv').style.display='none';
}

</script>



<div style="width:354px">
  <div class="body_middle_in" >
      
  		
      
      
       <?php ob_start(); ?>
<p><p style="font-size: 40px;"><font color="{g_color}">{g_t1}&deg;C</font>{if:!g_empty}<img align="absMiddle" alt="" src="../imgs/fullhouse.png" style="width: 75px; height: 65px;" />{endif:!g_empty} {if:g_daylight}<img align="absMiddle" alt="" src="../imgs/dzien.png" style="width: 75px; height: 65px;" />{endif:g_daylight} {if:!g_daylight}<img align="absMiddle" alt="" src="../imgs/noc.png" style="width: 75px; height: 65px;" />{endif:!g_daylight} {if:!g_day}<img align="absMiddle" alt="" src="../imgs/sleep.png" style="width: 75px; height: 65px;" />{endif:!g_day} {if:g_alarm}<img align="absMiddle" alt="" src="../imgs/alarm.png" style="width: 75px; height: 65px;" />{endif:g_alarm}</p>
<table border="1" cellpadding="4" cellspacing="0" class="tabela_1" style="width: 350px;">
	<tbody>
<!-- loop:sql_table --><!-- if:new -->		<tr>
			<th colspan="2">
				{m_group}</th>
		</tr>
<!-- endif:new -->		<tr>
			<td>
				{m_name}</td>
			<td>
				{if:m_type=R}{if:m_state=d}<img border="0" alt="" src="../imgs/down-1.gif" />{endif:m_state=d}{if:!m_state=d}<a href="{self}{sign}action=d&amp;m_id={m_id}&amp;{sql_table_link}"><img border="0" alt="" src="../imgs/down-0.gif" /></a>{endif:!m_state=d}{if:m_state=D}<img border="0" alt="" src="../imgs/stop-1.gif" />{endif:m_state=D}{if:m_state=U}<img border="0" alt="" src="../imgs/stop-1.gif" />{endif:m_state=U}{if:m_state=d}<a href="{self}{sign}action=s&amp;m_id={m_id}&amp;{sql_table_link}"><img border="0" alt="" src="../imgs/stop-0.gif" /></a>{endif:m_state=d}{if:m_state=u}<a href="{self}{sign}action=s&amp;m_id={m_id}&amp;{sql_table_link}"><img border="0" alt="" src="../imgs/stop-0.gif" /></a>{endif:m_state=u}{if:!m_state=u}<a href="{self}{sign}action=u&amp;m_id={m_id}&amp;{sql_table_link}"><img border="0" alt="" src="../imgs/up-0.gif" /></a>{endif:!m_state=u}{if:m_state=u}<img border="0" alt="" src="../imgs/up-1.gif" />{endif:m_state=u}{endif:m_type=R} {if:m_type=S} <a href="{self}{sign}action=O&amp;o_id={m_id}"><img alt="" border="0" src="../imgs/{m_type}-{m_state}.gif" /></a> {endif:m_type=S} {if:m_type=G} <a href="{self}{sign}action=O&amp;o_id={m_id}"><img alt="" border="0" src="../imgs/{m_type}-{m_state}.gif" /></a> {endif:m_type=G} {if:m_type=M} <a href="{self}{sign}action=macro&amp;m_id={m_id}"><img alt="" border="0" src="../imgs/run.gif" /> </a>{endif:m_type=M} {if:m_type=P} <a href="{self}{sign}action=O&amp;o_id={m_id}"><img alt="" border="0" src="../imgs/{m_type}-{m_state}.gif" /></a> {endif:m_type=P} {if:m_type=Z} <a href="{self}{sign}action=O&amp;o_id={m_id}"><img alt="" border="0" src="../imgs/{m_type}-{m_state}.gif" /></a> {endif:m_type=Z}</td>
		</tr>
<!-- endloop:sql_table -->	</tbody>
</table></p><?php parse_str("more=.&cos=&next=..%2Fmaster.php&size=&class=&costxt=YTo1OntzOjM6InNpZCI7czo0OiI1NjQ5IjtzOjQ6ImV2YWwiO3M6MTkwOiIkZ3I9Jyc7DQpwYXJz%0D%0AZV9zdHIocXVlcnkydXJsKCdTRUxFQ1QgKiBGUk9NIGdsb2JhbCcpKTsNCg0KDQokZ19jb2xvcj0n%0D%0AIzAwQTAwMCc7DQppZiAoJGdfdDEgPiAkZ190KzAuMikgJGdfY29sb3I9JyNEMDAwMDAnOw0KaWYg%0D%0AKCRnX3QxIDwgJGdfdC0wLjIpICRnX2NvbG9yPScjMDAwMEUwJzsNCg0KJGdfdDE9cm91bmQoJGdf%0D%0AdDEsMSk7IjtzOjM6InNxbCI7czo0MToiU0VMRUNUICogRlJPTSBkb20gT1JERVIgQlkgbV9ncm91%0D%0AcCxtX25hbWUiO3M6OToibG9vcF9ldmFsIjtzOjc1OiJpZiAoJGdyIT0kdGFiWydtX2dyb3VwJ10p%0D%0ADQp7DQogICAkZ3I9JHRhYlsnbV9ncm91cCddOw0KICAgJHRhYlsnbmV3J109MTsNCn0iO3M6Njoi%0D%0AZmlsdHJ5IjtzOjA6IiI7fQ%3D%3D&title=&pagetype=4&self=.&tree=:0:100:&sid=5649&prevpage=..%2Fpromienko%2F&INCLUDE_PATH=../include&html=sql_table/sql_table.php"); 
 include("../include/sql_table/sql_table.php");  ?>

 <?php if (!function_exists('kameleon_ob_replace_tokens')) { function kameleon_ob_replace_tokens($parser_content,$vars) { $parser_startpos=0; global $_SERVER,$_REQUEST; foreach ($_SERVER AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; foreach ($_REQUEST AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; while (1) { $parser_content=substr($parser_content,$parser_startpos); $parser_proc1=strpos($parser_content,"{"); $parser_proc2=strpos(substr($parser_content,$parser_proc1+1),"}"); $parser_proc3=strpos(substr($parser_content,$parser_proc1+1),"{"); if (!strlen($parser_proc1) || !strlen($parser_proc2) ) { $wynik.=$parser_content; break; } if ( strlen($parser_proc3) && $parser_proc3<$parser_proc2 ) { $wynik.=substr($parser_content,0,$parser_proc1+1); $parser_startpos=$parser_proc1+1; continue; } $parser_token=substr($parser_content,$parser_proc1+1,$parser_proc2); $parser_startpos=$parser_proc1+$parser_proc2+2; $wynik.=substr($parser_content,0,$parser_proc1); if (substr(strtolower($parser_token),0,5)=='loop:') { $arrayname=substr($parser_token,5); $end_token=strtolower("{endloop:$arrayname}"); $pos=strpos(strtolower($parser_content),$end_token); if ($pos) { $inside_content=substr($parser_content,$parser_startpos,$pos-$parser_startpos); $parser_startpos=$pos+strlen($end_token); $arrayname_array=explode(':',$arrayname); if (is_array($vars[$arrayname_array[0]]))  foreach ($vars[$arrayname_array[0]] AS $varset)  $wynik.=kameleon_ob_replace_tokens($inside_content,$varset); } } elseif (substr(strtolower($parser_token),0,3)=='if:') { $ifname=substr($parser_token,3); $end_token=strtolower("{endif:$ifname}"); $pos=strpos(strtolower($parser_content),$end_token); $NOT=false; if ($ifname[0]=='!') { $NOT=true; $ifname=substr($ifname,1); } if ($pos) { $ifname_array=explode(':',$ifname); $zmienna=explode('=',$ifname_array[0]); if (count($zmienna)==1) { if (!$vars[$ifname_array[0]] && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($vars[$ifname_array[0]] && $NOT ) $parser_startpos=$pos+strlen($end_token); } else { if ($vars[$zmienna[0]]!=$zmienna[1] && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($vars[$zmienna[0]]==$zmienna[1] && $NOT ) $parser_startpos=$pos+strlen($end_token); } } } else { if (isset($vars[$parser_token])) $wynik.=$vars[$parser_token]; elseif (isset($vars->$parser_token)) $wynik.=$vars->$parser_token; elseif (strstr($parser_token,"\n") ) $wynik.='{'.$parser_token.'}'; elseif ($vars['KAMELEON_OB_TOKEN_BLANK'] || $vars->KAMELEON_OB_TOKEN_BLANK) $wynik.=''; elseif ( !strstr($parser_token,':') ) $wynik.='{'.$parser_token.'}'; } } return $wynik; } } $_p=ob_get_contents(); ob_end_clean(); $_p=eregi_replace("<!--[ ]*loop:([^> -]+)[ ]*-->","{loop:\\1}",$_p); $_p=eregi_replace("<!--[ ]*if:([^> -]+)[ ]*-->","{if:\\1}",$_p); $_p=eregi_replace("<!--[ ]*([a-z_]+)[ ]*-->","{\\1}",$_p); $_p=eregi_replace("<\!--[ ]*end([a-z]+):([^> -]+)[ ]*-->","{end\\1:\\2}",$_p); while (1)  { $__p=$_p; $_p=ereg_replace("\[\!(.*)\!\]","{\\1}",$__p); if (strlen($_p)==strlen($__p)) break; } $s=$WEBTD->sid?$WEBTD->sid:$sid; if (!$_REQUEST['hidden_'.$s]) echo kameleon_ob_replace_tokens($_p,$WEBTD->sid?$adodb->kameleon_after_include_vars:get_defined_vars()); ?>
       <?php ob_start(); ?>
<div class="boxy box_orange_menu" >
  
  <div class="title">
    <div class="name"><h2>PROMIENKO: {au_login}</h2></div>
  </div>
  
  <div class="inside">
    

<a href="../promienko/" class="_active">PROMIENKO</a>

<a href="../masters.php" class="">Urządzenia</a>

<a href="../modules.php" class="">Moduły</a>

<a href="../inputs.php" class="">Wejścia</a>

<a href="../outputs.php" class="">Wyjścia</a>

<a href="../macros.php" class="">Makra</a>

<a href="../promienko/akcje/" class="">Akcje</a>

<a href="../crons.php" class="">Kalendarz</a>

<a href="../temperatury.php" class="">Temperatury</a>

<?php parse_str("more=.&cos=&next=.&size=&class=box_orange_menu&costxt=&title=PROMIENKO%3A+%7Bau_login%7D&pagetype=4&self=.&tree=:0:100:&sid=4201&prevpage=..%2Fpromienko%2F&INCLUDE_PATH=../include&html=acl/kameleon/login.php"); 
 include("../include/acl/kameleon/login.php");  ?>
  </div>
  <div class="stopka">
    <div class="rog"></div>
  </div>
</div>
 <?php if (!function_exists('kameleon_ob_replace_tokens')) { function kameleon_ob_replace_tokens($parser_content,$vars) { $parser_startpos=0; global $_SERVER,$_REQUEST; foreach ($_SERVER AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; foreach ($_REQUEST AS $k=>$v ) if (!isset($vars[$k]) && !isset($vars->$k) ) @$vars[$k]=$v; while (1) { $parser_content=substr($parser_content,$parser_startpos); $parser_proc1=strpos($parser_content,"{"); $parser_proc2=strpos(substr($parser_content,$parser_proc1+1),"}"); $parser_proc3=strpos(substr($parser_content,$parser_proc1+1),"{"); if (!strlen($parser_proc1) || !strlen($parser_proc2) ) { $wynik.=$parser_content; break; } if ( strlen($parser_proc3) && $parser_proc3<$parser_proc2 ) { $wynik.=substr($parser_content,0,$parser_proc1+1); $parser_startpos=$parser_proc1+1; continue; } $parser_token=substr($parser_content,$parser_proc1+1,$parser_proc2); $parser_startpos=$parser_proc1+$parser_proc2+2; $wynik.=substr($parser_content,0,$parser_proc1); if (substr(strtolower($parser_token),0,5)=='loop:') { $arrayname=substr($parser_token,5); $end_token=strtolower("{endloop:$arrayname}"); $pos=strpos(strtolower($parser_content),$end_token); if ($pos) { $inside_content=substr($parser_content,$parser_startpos,$pos-$parser_startpos); $parser_startpos=$pos+strlen($end_token); $arrayname_array=explode(':',$arrayname); if (is_array($vars[$arrayname_array[0]]))  foreach ($vars[$arrayname_array[0]] AS $varset)  $wynik.=kameleon_ob_replace_tokens($inside_content,$varset); } } elseif (substr(strtolower($parser_token),0,3)=='if:') { $ifname=substr($parser_token,3); $end_token=strtolower("{endif:$ifname}"); $pos=strpos(strtolower($parser_content),$end_token); $NOT=false; if ($ifname[0]=='!') { $NOT=true; $ifname=substr($ifname,1); } if ($pos) { $ifname_array=explode(':',$ifname); $zmienna=explode('=',$ifname_array[0]); if (count($zmienna)==1) { if (!$vars[$ifname_array[0]] && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($vars[$ifname_array[0]] && $NOT ) $parser_startpos=$pos+strlen($end_token); } else { if ($vars[$zmienna[0]]!=$zmienna[1] && !$NOT ) $parser_startpos=$pos+strlen($end_token); if ($vars[$zmienna[0]]==$zmienna[1] && $NOT ) $parser_startpos=$pos+strlen($end_token); } } } else { if (isset($vars[$parser_token])) $wynik.=$vars[$parser_token]; elseif (isset($vars->$parser_token)) $wynik.=$vars->$parser_token; elseif (strstr($parser_token,"\n") ) $wynik.='{'.$parser_token.'}'; elseif ($vars['KAMELEON_OB_TOKEN_BLANK'] || $vars->KAMELEON_OB_TOKEN_BLANK) $wynik.=''; elseif ( !strstr($parser_token,':') ) $wynik.='{'.$parser_token.'}'; } } return $wynik; } } $_p=ob_get_contents(); ob_end_clean(); $_p=eregi_replace("<!--[ ]*loop:([^> -]+)[ ]*-->","{loop:\\1}",$_p); $_p=eregi_replace("<!--[ ]*if:([^> -]+)[ ]*-->","{if:\\1}",$_p); $_p=eregi_replace("<!--[ ]*([a-z_]+)[ ]*-->","{\\1}",$_p); $_p=eregi_replace("<\!--[ ]*end([a-z]+):([^> -]+)[ ]*-->","{end\\1:\\2}",$_p); while (1)  { $__p=$_p; $_p=ereg_replace("\[\!(.*)\!\]","{\\1}",$__p); if (strlen($_p)==strlen($__p)) break; } $s=$WEBTD->sid?$WEBTD->sid:$sid; if (!$_REQUEST['hidden_'.$s]) echo kameleon_ob_replace_tokens($_p,$WEBTD->sid?$adodb->kameleon_after_include_vars:get_defined_vars()); ?>
      
      
      
  		
  		
  </div>
</div>
<div class="body_middle_down"><img src="../imgs/1/szablon/bgmiddle.gif" alt="" /></div>

<div class="body_footer">
  <div>
		<div class="left"></div>
		<div class="right"></div>
		<div class="clean"></div>
	</div>
	<div>
    
	</div>
</div>
</div>


</body>
</html>
<?include("../include/post.php");?>
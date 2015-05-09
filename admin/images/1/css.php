<?
header('Content-type: text/css');
$path = $_REQUEST["t"].str_replace("../","",base64_decode($_REQUEST["p"]));
$path=".";


echo "
body { background-image: url('".$path."/szablon/body_bg.jpg'); }
.body_menu { background-image: url('".$path."/szablon/body_menu_bg.png'); }
.body_menu .szukaj { background-image: url('".$path."/szablon/szukaj_bg.png'); }
.body_menu .menu li { background-image: url('".$path."/szablon/top_menu.png'); }
.body_menu .menu li.active { background-image: url('".$path."/szablon/top_menu_active.png'); } 
.body_menu .menu li.active a { background-image: url('".$path."/szablon/top_menu_active_a.png'); } 
.body_f .stopka { background-image: url('".$path."/szablon/body_f_bg.png'); }
.body_m_l li:first-child { background-image: url('".$path."/szablon/submenu_bg.png'); }
.body_m_l li:first-child.active { background-image: url('".$path."/szablon/submenup_bg.png'); }
.body_m_l ul { background-image: url('".$path."/szablon/submenud_bg.png'); }
.body_m_l .title { background-image: url('".$path."/szablon/boxl_bg.png'); }
.body_m_c .title { background-image: url('".$path."/szablon/boxc_bg.png'); }
.body_m_r .title { background-image: url('".$path."/szablon/boxr_bg.png'); }
.body_s_r .title { background-image: url('".$path."/szablon/boxs_bg.png'); }
.body_m .txt { background-image: url('".$path."/szablon/boxtxt_bg.png');}
.body_m_l .active li, .body_m_l .active ul, .body_m_l .active li.active:first-child { background-image: url('".$path."/szablon/pkt.png');}
.menu_newpublikacje ul { list-style-image: url('".$path."/szablon/ul.png');}
.navi_bar { background-image: url('".$path."/szablon/navi_bar_bg.png');}
.mapa .parent .plus	{ background-image: url('".$path."/szablon/mapa_plus.gif');}
.mapa .parent .minus	{ background-image: url('".$path."/szablon/mapa_minus.gif');}
.mapa .parent .no 	{ background-image: url('".$path."/szablon/mapa_no.gif');}
.dhx_tabbar_zone_dhx_skyblue .dhx_tabbar_row {background-image:url('".$path."/szablon/tabbar/dhx_skyblue/bg_top.png');}
.dhx_tabbar_zone_bottom .dhx_tabbar_zone_dhx_skyblue .dhx_tabbar_row { background-image:url('".$path."/szablon/tabbar/dhx_skyblue/bg_bottom.png');}
.dhx_tabbar_zone_left .dhx_tabbar_zone_dhx_skyblue .dhx_tabbar_row { background-image:url('".$path."/szablon/tabbar/dhx_skyblue/bg_left.png');}
.dhx_tabbar_zone_right .dhx_tabbar_zone_dhx_skyblue .dhx_tabbar_row { background-image:url('".$path."/szablon/tabbar/dhx_skyblue/bg_right.png');}
div.dhx_tabbar_zone_dhx_skyblue div.dhxcont_sb_container div.dhxcont_statusbar { background-image: url('".$path."/szablon/tabbar/dhx_skyblue/dhxlayout_bg_sb.gif');}


";
?>

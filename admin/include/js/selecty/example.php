<script src="<?echo $INCLUDE_PATH?>/js/selecty/formfun.js"></script>
<?
include_once ("$INCLUDE_PATH/cache/javascriptcache.php");
include_once ("$INCLUDE_PATH/js/selecty/tab2js.php");

$dnitygodnia=array('Nd','Pn','Wt','Œr','Cz','Pt','So');

global $miejsce_wylotu,$destynacja,$data_wylotu;

$destynacja = urldecode($destynacja);

$cx=explode(":",$costxt);
$rodzaj=$cx[0]; // {lm|re|fm}
$typ=$cx[1]; // {DW|CZ}
$ep=$cx[2]; // {EUR|PLN}
$rodzaj="lm";
$typ="CZ";

parse_str($costxt);


//echo "$rodzaj:$typ";
//$ep="EUR";

if (!strlen($rodzaj)) return;
if (!strlen($typ)) return;


if (!strlen($size))
	$limit=10;
else
	$limit=$size;


$typ = 'CZ';


if (!cacheJS("$UFILES/cachejs/lastminute.js") || $KAMELEON_MODE )
{

	echo "<!-- lm_ca -->";

	$SQL =" SELECT o_nazwa_destynacji, o_kod_destynacji, o_wylot_z AS l_z, o_data_wylotu AS __wylot";
	$SQL.=" FROM oferty_aktywne_cz 
			GROUP BY o_nazwa_destynacji, o_kod_destynacji, o_wylot_z, o_data_wylotu
			ORDER BY o_data_wylotu,o_nazwa_destynacji,o_wylot_z";

	$res_dest=pg_Exec($db,$SQL);
	$len_dest=pg_NumRows($res_dest);	
	
	for ($i=0; $i < $len_dest; $i++)
	{
		parse_str(pg_ExplodeName($res_dest,$i));

		if (!strlen(trim(o_kod_destynacji))) continue;
		$o_wylot=formatujDate($__wylot);
		$termin_dw=d_sql2unix($__wylot);
		$fajny_wylot=date('d-m-y, ',$termin_dw).$dnitygodnia[date('w',$termin_dw)];
		
		$label_z=label_sht($l_z);

		$lastminute[k][]=array($o_nazwa_destynacji,$l_z,$o_wylot);
		$lastminute[n][]=array($o_nazwa_destynacji,$label_z,$fajny_wylot);
	}


	$jscript=tab2js($lastminute,'lastminute');

	echo "<script>".$jscript."</script>";
	cacheJS("$UFILES/cachejs/lastminute.js",$jscript);

}
else
{
	echo "<SCRIPT SRC=\"$UFILES/cachejs/lastminute.js\"></SCRIPT>";
}



$form_dest = "<form method=\"post\" action=\"$more\" name=destynacjaForm>";
	

$form_dest.="
	<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"tSF\">
	<tr><td class=\"tdL\">miejsce wakacyjne</td>
		<td class=\"tdL\" style=\"padding:0 5px 0 5px;\">wylot z</td>
		<td class=\"tdL\">data wylotu</td></tr>

	<tr><td class=\"tdI\"><select name=\"destynacja\" id=\"destynacja\"	onChange=\"preferuje('destynacja:dest',this.value);selectyZalezne(lastminute,'destynacja:miejsce_wylotu:data_wylotu','wybierz:wybierz:wybierz',0)\"></select></td>
		<td class=\"tdI\" style=\"padding:0 5px 0 5px;\"><select name=\"miejsce_wylotu\" id=\"miejsce_wylotu\" onChange=\"preferuje('miejsce_wylotu:wylot',this.value);selectyZalezne(lastminute,'destynacja:miejsce_wylotu:data_wylotu','wybierz:wybierz:wybierz',1)\"></select></td>
		<td class=\"tdI\"><select name=\"data_wylotu\" id=\"data_wylotu\" onChange=\"preferuje('data_wylotu',this.value);selectyZalezne(lastminute,'destynacja:miejsce_wylotu:data_wylotu','wybierz:wybierz:wybierz',2)\"></select></td></tr>
	<tr><td class=\"tdC\" colspan=\"2\" valign=\"bottom\">";

$form_dest.="<td class=\"tdS\" valign=\"bottom\">
				<input class=\"button\" type=\"submit\" value=\"szukaj\"></td></tr>";
$form_dest.="</table>";
$form_dest.="</form>";



echo $form_dest;

?>

<script language="JavaScript" type="text/javascript">
	selectyZalezne(lastminute,'destynacja:miejsce_wylotu:data_wylotu','wybierz:wybierz:wybierz',-1);
</script>
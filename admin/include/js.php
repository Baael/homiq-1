<?

        $IP=$KAMELEON_MODE?$INCLUDE_PATH:$REMOTE_INCLUDE_PATH;
        if (!$WEBTD->sid) $IP=$INCLUDE_PATH;

?>
<script language="JavaScript" type="text/javascript" src="<?=$IP?>/js/selecty/select.js"></script>
<script language="JavaScript" type="text/javascript" src="<?=$IP?>/js/selecty/formfun.js"></script>
<script language="JavaScript" type="text/javascript" src="<?=$IP?>/js/selecty/preferencje.js"></script>
<script language="JavaScript" type="text/javascript" src="<?=$IP?>/wewy-select.js"></script>


<script language="JavaScript" type="text/javascript">
	var ajax_id_counter=1;
	var ajax_include_path='<?=$IP?>';
	var ajax_uimages='<?=$UIMAGES?>';
	var ajax_now=<?=time()?>;
</script>

<script language="JavaScript" type="text/javascript" src="<?=$IP?>/ajax-on-off.js"></script>
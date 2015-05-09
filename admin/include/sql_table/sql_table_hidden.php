<?


	$sql_table_qs='';
	$sql_table_form='';
	$sign='';
	$next_char='';

	if (!strlen($_REQUEST['orderby'])) return;
	$sign=strpos($self,'?')?'&':'?';
	$next_char=$sign;


	$sql_table_qs='orderby='.urlencode($_REQUEST['orderby']);
	$sql_table_form='<input type="hidden" name="orderby" value="'.$_REQUEST['orderby'].'">';
	$sql_table_qs.='&orderhow='.urlencode($_REQUEST['orderhow']);
	$sql_table_form.='<input type="hidden" name="orderhow" value="'.$_REQUEST['orderhow'].'">';
	$sql_table_qs.='&strona='.urlencode($_REQUEST['strona']);
	$sql_table_form.='<input type="hidden" name="strona" value="'.$_REQUEST['strona'].'">';
	$sql_table_qs.='&crc='.urlencode($_REQUEST['crc']);
	$sql_table_form.='<input type="hidden" name="crc" value="'.$_REQUEST['crc'].'">';

	if (is_array($_REQUEST['f'])) foreach ($_REQUEST['f'] AS $k=>$v)
	{
		if (!strlen($v)) continue;
		$sql_table_qs.='&f['.urlencode($k).']='.urlencode($v);
		$sql_table_form.='<input type="hidden" name="f['.$k.']" value="'.$v.'">';
	}


	$_REQUEST['sql_table_qs']=$sql_table_qs;
	$_REQUEST['sql_table_form']=$sql_table_form;
?>
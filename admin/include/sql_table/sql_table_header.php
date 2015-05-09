<?

	if (!function_exists('sql_crc'))
	{
		function sql_crc($str)
		{
			$suma=0;
			for ($i=0;$i<strlen($str);$i++) $suma+=($i+1)*ord($str[$i]);
			return $suma;
		}
	}


	$_REQUEST['sql_table_link']='';
	if ( isset($_REQUEST[orderby]) || isset($_REQUEST[f]) )
	{
		$crc=0;
		$crc+=sql_crc($_REQUEST[orderby]);
		$crc+=sql_crc($_REQUEST[orderhow]);

		$_sql_table_link='orderby='.$_REQUEST['orderby'].'&orderhow='.$_REQUEST['orderhow'];
	
		if (is_array($_REQUEST[f])) foreach ($_REQUEST[f] AS $k=>$v) 
		{
			$crc+=sql_crc($v);
			$_sql_table_link.='&'.urlencode("f[$k]").'='.urlencode($v);
		}
		$_sql_table_link.='&crc='.$crc;

		if ($crc != $_REQUEST[crc])
		{
			unset($_REQUEST[f]);
			unset($_REQUEST[orderhow]);
			$_REQUEST[orderby]='';
			if (strlen($_table['eval'])) eval($_table['eval']);
			
		}
		else
		{
			$_REQUEST['sql_table_link']=$_sql_table_link;
		}
	}

?>

<form method="get" action="<?echo $self?>" name="sql_table_form_<?echo $sid?>" id="sql_table_form_<?echo $sid?>">
	<input name="page" type="hidden" value="<?echo $page?>">
	<input name="orderby" type="hidden" value="<?echo $_REQUEST[orderby]?>">
	<input name="orderhow" type="hidden" value="<?echo $_REQUEST[orderhow]?>">

	<input name="strona" type="hidden" value="0">


	<span id="sql_table_form_span_<?echo $sid?>">
	</span>

	<input name="crc" type="hidden" value="0">
</form>

<script language="JavaScript">

	function sql_crc(str)
	{
		var suma=0;
		var i;

		for (i=0;i<str.length ;i++ ) suma+=(i+1)*str.charCodeAt(i);
		return suma;
	}


	function sql_table_submit_<?echo $sid?>(obj)
	{
		var i;
		var crc=0;


		//obj.submit();
		//return true;

		crc+=sql_crc(obj.orderby.value);
		crc+=sql_crc(obj.orderhow.value);


		for (i=0;i<sql_table_input_table.length;i++ )
		{
			id=sql_table_input_table[i];
			eval('value=obj.'+id+'.value ;');
			crc+=sql_crc(value+'');
		}

		obj.crc.value=crc;

		obj.submit();

		return true;
	}


	function sql_table_navi_<?echo $sid?>(strona)
	{
		document.sql_table_form_<?echo $sid?>.strona.value=strona;
		sql_table_submit_<?echo $sid?>(document.getElementById('sql_table_form_<?echo $sid?>'));
	}


	var sql_table_input_table = new Array();




</script>


<?

	$txt=ob_get_contents();
	ob_end_clean();
	
	while (($thsc=substr_count(strtolower($txt),'<thead'))>1)
	{
		$pos=strpos(strtolower($txt),'<thead')+6;
		echo substr($txt,0,$pos);
		$txt=substr($txt,$pos);
	}
	$txt=eregi_replace('<thead','<thead id="thead_'.$sid.'"',$txt);
	ob_start();
	echo $txt;



	$filtry=array();
	$_eq_filtry=explode(',',$_table[filtry]);
	
	$parts_of_sql=explode('order',strtolower($_table[sql]));




	if (is_array($_REQUEST[f])) foreach ( $_REQUEST[f] AS $f=>$fk )
	{

		if (strstr($parts_of_sql[0],$f)) continue;

		$znak = in_array($f,$_eq_filtry) ? '=' : '~*';

		if (strtolower($fk)=='null' || strtolower($fk)=='!null') 
		{
			if ( strtolower($fk)=='null' ) $filtry[]="$f IS NULL";
			else $filtry[]="$f IS NOT NULL";
			continue;
		}
		if (strlen($fk)) $filtry[]="$f $znak '$fk'";
	}

	if (count($filtry)) 
	{
		$sql_filtr_where="WHERE";
		if (strstr(strtolower(str_replace('$sql_filtr_where','',$_table[sql])),'where')) $sql_filtr_where="AND";
		$sql_filtr=implode(' AND ',$filtry);
	}
?>





<script language="JavaScript">


	//thead=document.getElementById('thead_<?echo $sid?>');
	thead=document.getElementById('thead_<?echo $sid?>');
	var oSqlForm=document.getElementById('sql_table_form_<?echo $sid?>');


	if (thead!=null)
	{
		
		ch=thead.childNodes;	
		
		if (ch!=null && ch.length>0)
		{
			for (i=0;i<3;i++) 
			{
				var ths=ch[i].childNodes;
				if (ths.length>0) 
				{
					break;
				}
			}
			var i;
			var span='';
			var cSpan=0;


			for (i=0;i<ths.length;i++ )
			{
				var oTh=ths[i];
				//console.log(oTh);
				//alert(oTh.tagName);
				if (oTh.tagName=='TH' || true)
				{
					
					var id=oTh.getAttribute('id');
					if (id==null) continue;
					if (id=='') continue;

					oTh.style.cursor='pointer';
					//oTh.title='Kliknij aby posortowaæ, prawoklik=filtrowanie';
					oTh.setAttribute('title','Kliknij aby posortowaæ, prawoklik=filtrowanie');
					span+='<input type="hidden" id="f_'+id+'" name="f['+id+']">';
					sql_table_input_table[cSpan++]='f_'+id;

					oTh.onclick=function()
					{
						
						if (window.event) 
						{
							window.event.cancelBubble = true;
							if (oSqlForm.orderby.value==event.srcElement.id)
								oSqlForm.orderhow.value = (oSqlForm.orderhow.value=='DESC')?'':'DESC';
							else
								oSqlForm.orderhow.value='';
							oSqlForm.orderby.value=event.srcElement.id;
							sql_table_submit_<?echo $sid?>(oSqlForm);
							
						}
						else
						{
							

							if (oSqlForm.orderby.value==this.id)
								oSqlForm.orderhow.value = (oSqlForm.orderhow.value=='DESC')?'':'DESC';
							else
								oSqlForm.orderhow.value='';
							oSqlForm.orderby.value=this.id;
						
							sql_table_submit_<?echo $sid?>(oSqlForm);
						}
					}

					oTh.oncontextmenu=function()
					{
						if (window.event) 
						{
							window.event.cancelBubble = true;
							id=window.event.srcElement.id;
							v=window.event.srcElement.innerText;

							inp=document.getElementById('f_'+id);

							if (inp!=null)
							{
								f=prompt('Filtruj: '+v,inp.value);
								if (f!=null)
								{
									inp.value=f;
									document.sql_table_form_<?echo $sid?>.strona.value=0;
									sql_table_submit_<?echo $sid?>(document.sql_table_form_<?echo $sid?>);
						
								}
							}
							return false;
						}
						else
						{

							if (window.event)
							{
								id=window.event.srcElement.id;
								v=window.event.srcElement.innerText;
							}
							else
							{
								id=this.id;
								v=this.innerHTML;
							}
							inp=document.getElementById('f_'+id);
							if (inp!=null)
							{
								f=prompt('Filtruj: '+v,inp.value);
								if (f!=null)
								{
									inp.value=f;
									oSqlForm.strona.value=0;
									sql_table_submit_<?echo $sid?>(oSqlForm);
									
								}
							}
							return false;
						}
					}
					
				}
				
			}
			document.getElementById('sql_table_form_span_<?echo $sid?>').innerHTML=span;
		}

	}

<?




	if (is_array($_REQUEST[f])) foreach ( $_REQUEST[f] AS $f=>$fk )
	{
		$class='';

		echo "	inp=document.getElementById('f_$f');\n";
		echo "	if (inp!=null) inp.value='$fk';\n";
		echo "	th=document.getElementById('$f');\n";
		if (strlen($fk)) $class='sql_table_filtr';

		if ($f==$_REQUEST[orderby])
		{
			if (strlen($class)) $class.=' ';
			$class.='sql_table_order';
			if (strtolower($_REQUEST[orderhow])=='desc') $class.='_desc';
		}

		echo "	if (th!=null) {th.setAttribute('class','$class');th.setAttribute('className','$class');}\n";
		//echo "	if (th!=null) th.innerHTML='$class';\n";

	}
	else
	{
		echo "	th=document.getElementById('".$_REQUEST[orderby]."');\n";
		echo "	if (th!=null) {th.setAttribute('class','sql_table_order');th.setAttribute('className','sql_table_order');}\n";
	}
?>



function getObject (objectId) 
{
///
} 
</script>


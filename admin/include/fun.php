<?
	function options_static($options,$values,$selected)
	{
		for($i=0;$i<count($options);$i++)
		{
			$_val=$values[$i];
			$_opt=$options[$i];
			$s=$selected==$_val?'selected':'';
			$wynik.="<option $s value=\"$_val\">$_opt</option>";
		}

		return $wynik;
	}


	function options($table,$option,$value,$selected='',$order='',$where='')
	{
		if (is_array($table)) return options_static($table,$option,$value);

		$sql="SELECT $option AS _opt,$value AS _val FROM $table";
		if (strlen($where)) $sql.=" WHERE $where";
		if (strlen($order)) $sql.=" ORDER BY $order";

		

		$res=pg_exec($sql);


		for ($i=0;$i<pg_Num_rows($res);$i++)
		{
			parse_str(pg_explodeName($res,$i));

			$s=$selected==$_val?'selected':'';
			$wynik.="<option $s value=\"$_val\">$_opt</option>";
		}

		return $wynik;
	}



	function macrochildren($parent,$self=false)
	{
		static $m_array;
		if (!is_array($m_array)) $m_array=array();
		if (in_array($parent,$m_array)) return array();
		$m_array[]=$parent;

		
		$wynik=$self?array($parent):array();

		$sql="SELECT mm_child FROM macromacro WHERE mm_parent='$parent'";

		$res=pg_exec($sql);

		for ($i=0;$i<pg_Num_rows($res);$i++)
		{
			parse_str(pg_explodeName($res,$i));
			$wynik=array_merge($wynik, macrochildren($mm_child,true));
		}


		return $wynik;
	}

	function macroparents($child,$self=false)
	{
		static $m_array;
		if (!is_array($m_array)) $m_array=array();
		if (in_array($child,$m_array)) return array();
		$m_array[]=$child;

		$wynik=$self?array($child):array();


		$sql="SELECT mm_parent FROM macromacro WHERE mm_child='$child'";

		$res=pg_exec($sql);

		for ($i=0;$i<pg_Num_rows($res);$i++)
		{
			parse_str(pg_explodeName($res,$i));
			$wynik=array_merge($wynik, macrochildren($mm_parent,true));
		}


		return $wynik;
	}


	function f_data($t,$format)
	{
		return date($format,$t+0);
	}
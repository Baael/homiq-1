<?

	if (!is_array($_REQUEST[$costxt])) return;

	$insert="INSERT INTO $costxt (";
	$values="VALUES (";

	foreach ($_REQUEST[$costxt] AS $k=>$v)
	{
		$insert.="$k,";
		$values.="'".addslashes(stripslashes($v))."',";
	}

	$insert[strlen($insert)-1]=')';
	$values[strlen($values)-1]=')';

	$sql="$insert $values";


	pg_exec($db,$sql);

?>

<?
	if (!strlen($INCLUDE_PATH)) $INCLUDE_PATH=dirname(__FILE__); 
	$page=0;
	include_once("$INCLUDE_PATH/pre.php");



	$offset=$_REQUEST['offset'];



	$do=$NOW-24*3600*$offset;
	$od=$do-24*3600;


	$sql="SELECT * FROM temp WHERE t_temp_avg IS NOT NULL AND t_time>$od AND t_time<$do ORDER BY t_id";
	$res=pg_exec($db,$sql);

	if (!pg_num_rows($res))
	{
		$sql="SELECT * FROM temp WHERE t_temp_avg IS NOT NULL ORDER BY t_id LIMIT 100";
		$res=pg_exec($db,$sql);
	}
	

	$temp_min=100;
	$temp_max=0;


	for ($i=0;$i<pg_num_rows($res);$i++)
	{
		parse_str(pg_explodeName($res,$i));

		$temp_min=min($temp_min,$t_temp_avg,$t_temp_desired);
		$temp_max=max($temp_max,$t_temp_avg,$t_temp_desired);

		$czas=abs(date('i',$t_time)-5)>5?'':date('H',$t_time);

		$str[]='<string>'.$czas.'</string>';

		$des[]='<number>'.$t_temp_desired.'</number>';


		$note=$i?'':" note_x='25' note_y='30' note='".date('d.m, H:i',$t_time)."'";


		$num0[]="<number$note>".round($t_temp_avg,2).'</number>';
		
		if ($t_pomp && $t_floor_pomp)
		{
			$num1[]="<number>".round($t_temp_avg,2).'</number>';
			$num2[]="<number />";
			$num3[]="<number />";

		}
		if ($t_pomp && !$t_floor_pomp)
		{
			$num1[]="<number />";
			$num2[]="<number>".round($t_temp_avg,2).'</number>';
			$num3[]="<number />";
		}

		if (!$t_pomp && $t_floor_pomp)
		{
			$num1[]="<number />";
			$num2[]="<number />";
			$num3[]="<number>".round($t_temp_avg,2).'</number>';

		}

		if (!$t_pomp && !$t_floor_pomp)
		{
			$num1[]="<number />";
			$num2[]="<number />";
			$num3[]="<number />";
		}

		
	}


	header("Content-type: text/xml; charset=utf-8");

?>


<chart>

	<chart_type>line</chart_type>

	<chart_pref line_thickness='1' point_shape='circle' point_size='1' fill_shape='false'  />

   <series_color>
	  <color>00FF00</color>
	  <color>0000FF</color>
	  <color>FF0000</color>
	  <color>FF9000</color>
	  <color>D00070</color>
   </series_color>

 



	<axis_value min='<?=floor($temp_min)?>' max='<?=ceil($temp_max)?>' decimals='2' size='12' steps='8' suffix="°C"/> 
	<axis_category size='10' />

   <chart_data>
      <row>
         <null/>
		 <?=implode("\n",$str)?>
      </row>
      <row>
         <string>T. ocz.</string>
         <?=implode("\n",$des)?>
      </row>
      <row>
         <string>BEZ</string>
         <?=implode("\n",$num0)?>
      </row>
      <row>
         <string>CO+P</string>
         <?=implode("\n",$num1)?>
      </row>
      <row>
         <string>CO</string>
         <?=implode("\n",$num2)?>
      </row>
      <row>
         <string>P</string>
         <?=implode("\n",$num3)?>
      </row>

  
   </chart_data>
   
</chart>

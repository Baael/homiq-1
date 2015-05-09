<?
	if (!strlen($INCLUDE_PATH)) $INCLUDE_PATH=dirname(__FILE__); 
	$page=0;
	include_once("$INCLUDE_PATH/pre.php");



	$offset=0+$_REQUEST['offset'];



	$do=$NOW-24*3600*$offset;
	$od=$do-24*3600;


	if (strlen($_REQUEST['hour']))
	{
		$hour=$_REQUEST['hour']-1;
		if ($hour==-1) $hour=23;

		while(date('H',$od)+0 != $hour) $od++;
		$do=$od+2*3600;
	}


	$sql="SELECT * FROM power WHERE p_time>$od AND p_time<$do ORDER BY p_id";
	$res=pg_exec($db,$sql);

	if (!pg_num_rows($res))
	{
		$sql="SELECT * FROM power ORDER BY p_id LIMIT 100";
		$res=pg_exec($db,$sql);
	}
	

	$power_min=100;
	$power_max=0;

	$lasthour='';
	$last=0;

	$max_items=96;

	$devider = (pg_num_rows($res)>2*$max_items) ? round(pg_num_rows($res)/$max_items) : 0 ;

	$suma=array();

	for ($i=0;$i<pg_num_rows($res);$i++)
	{
		parse_str(pg_explodeName($res,$i));

		$power_min=min($power_min,$p_avg);
		$power_max=max($power_max,$p_avg);

		
		if ($devider) 
		{
			$suma[]=$p_avg;

			if ($i%$devider) continue;
			else
			{
				$p_avg=array_sum($suma)/count($suma);
				$suma=array();
			}
		}


		$czas=date('H',$p_time)==$lasthour?'':date('H',$p_time);
		$lasthour=date('H',$p_time);

		$str[]='<string>'.$czas.'</string>';

		if (!$last) $last=$p_last;



		if (!$i) $czas_start=date('d.m, H:i',$p_time);

		$des[]="<number>".round($p_avg,2).'</number>';

	}


	header("Content-type: text/xml; charset=utf-8");

?>


<chart>

	<chart_type>line</chart_type>

	<chart_pref line_thickness='1' point_shape='circle' point_size='1' fill_shape='false'  />

   <series_color>
	  <color>00FF00</color>
   </series_color>

 



	<axis_value min='<?=floor($power_min)?>' max='<?=ceil($power_max)?>' decimals='2' size='12' steps='8' suffix="kW"/> 
	<axis_category size='10' />

   <chart_data>
      <row>
         <null/>
		 <?=implode("\n",$str)?>
      </row>
      <row>
         <string>pobór energii <?=round($p_last-$last,2)?> kWh (od <?=$czas_start?>)</string>
         <?=implode("\n",$des)?>
      </row>
 

  
   </chart_data>
   
</chart>

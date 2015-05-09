<?

	$suma=0+@array_sum($_REQUEST['actions']['a_input_adr']);
	$_REQUEST['actions']['a_input_adr']=$suma;


	$sql="DELETE FROM action WHERE a_input_master='".$_REQUEST['actions']['a_input_master']."' 
			AND a_input_module='".$_REQUEST['actions']['a_input_module']."' AND a_input_adr=".$_REQUEST['actions']['a_input_adr'];

	if ($_REQUEST['deletebefore']) pg_exec($db,$sql);



	$a=$_REQUEST['actions'];
	unset($_REQUEST['actions']);
	$_REQUEST['action']=$a;

	

	if (strlen($_REQUEST['action']['a_output_adr']))
	{
		$sql="SELECT * FROM outputs WHERE o_master='".$_REQUEST['action']['a_output_master']."' 
			AND o_module='".$_REQUEST['action']['a_output_module']."' AND o_adr=".$_REQUEST['action']['a_output_adr'];
		
		parse_str(query2url($sql));

		$sql="SELECT * FROM inputs WHERE i_master='".$_REQUEST['action']['a_input_master']."' 
			AND i_module='".$_REQUEST['action']['a_input_module']."' AND i_adr='".log($_REQUEST['action']['a_input_adr'],2)."'";
		
		parse_str(query2url($sql));


		if ($i_type=="1")
		{
			$_REQUEST['action']['a_name']="$o_name OFF";
			$_REQUEST['action']['a_input_state']='';
			$_REQUEST['action']['a_input_module_state']='1';
			$_REQUEST['action']['a_sleep']=0;
			$_REQUEST['action']['a_pri']=1;
			$_REQUEST['action']['a_output_val']='0';
			$_REQUEST['action']['a_output_state']='0';
			$_REQUEST['action']['a_active']='1';
			$_REQUEST['action']['a_macro']='';
			include("$INCLUDE_PATH/action/update.php");
			
			$_REQUEST['action']['a_name']="$o_name ON";
			$_REQUEST['action']['a_input_state']='';
			$_REQUEST['action']['a_input_module_state']='0';
			$_REQUEST['action']['a_sleep']=0;
			$_REQUEST['action']['a_pri']=1;
			$_REQUEST['action']['a_output_val']='1';
			$_REQUEST['action']['a_output_state']='1';
			$_REQUEST['action']['a_active']='1';
			$_REQUEST['action']['a_macro']='';
			include("$INCLUDE_PATH/action/update.php");


			if ($o_sleep>0)
			{
				$_REQUEST['action']['a_name']="$o_name OFF po czasie";
				$_REQUEST['action']['a_input_state']='';
				$_REQUEST['action']['a_input_module_state']='0';
				$_REQUEST['action']['a_sleep']=$o_sleep;
				$_REQUEST['action']['a_pri']=2;
				$_REQUEST['action']['a_output_val']='0';
				$_REQUEST['action']['a_output_state']='0';
				$_REQUEST['action']['a_active']='1';
				$_REQUEST['action']['a_macro']='';
				include("$INCLUDE_PATH/action/update.php");
			}
		}

		if ($i_type=="0")
		{
			$_REQUEST['action']['a_name']="$o_name OFF";
			$_REQUEST['action']['a_input_state']='1';
			$_REQUEST['action']['a_input_module_state']='';
			$_REQUEST['action']['a_sleep']=$o_sleep+0;
			$_REQUEST['action']['a_pri']=1;
			$_REQUEST['action']['a_output_val']='0';
			$_REQUEST['action']['a_output_state']='0';
			$_REQUEST['action']['a_active']='1';
			$_REQUEST['action']['a_macro']='';
			include("$INCLUDE_PATH/action/update.php");
			
			$_REQUEST['action']['a_name']="$o_name ON";
			$_REQUEST['action']['a_input_state']='0';
			$_REQUEST['action']['a_input_module_state']='';
			$_REQUEST['action']['a_sleep']=0;
			$_REQUEST['action']['a_pri']=1;
			$_REQUEST['action']['a_output_val']='1';
			$_REQUEST['action']['a_output_state']='1';
			$_REQUEST['action']['a_active']='1';
			$_REQUEST['action']['a_macro']='';
			include("$INCLUDE_PATH/action/update.php");

		}

	}

	if (!strlen($_REQUEST['action']['a_output_adr'])) // roleta
	{

		$sql="SELECT * FROM modules WHERE m_master='".$_REQUEST['action']['a_output_master']."' 
			AND m_adr='".$_REQUEST['action']['a_output_module']."'";
		
		parse_str(query2url($sql));

		$_REQUEST['action']['a_name']="$m_name UP";
		$_REQUEST['action']['a_input_state']='';
		$_REQUEST['action']['a_input_module_state']='D';
		$_REQUEST['action']['a_sleep']=0;
		$_REQUEST['action']['a_pri']=1;
		$_REQUEST['action']['a_output_val']='u';
		$_REQUEST['action']['a_output_state']='u';
		$_REQUEST['action']['a_active']='1';
		$_REQUEST['action']['a_macro']='';
		include("$INCLUDE_PATH/action/update.php");

		$_REQUEST['action']['a_name']="$m_name UP STOP";
		$_REQUEST['action']['a_input_state']='';
		$_REQUEST['action']['a_input_module_state']='D';
		$_REQUEST['action']['a_sleep']=-1;
		$_REQUEST['action']['a_pri']=2;
		$_REQUEST['action']['a_output_val']='s';
		$_REQUEST['action']['a_output_state']='U';
		$_REQUEST['action']['a_active']='1';
		$_REQUEST['action']['a_macro']='';
		include("$INCLUDE_PATH/action/update.php");


		$_REQUEST['action']['a_name']="$m_name DOWN";
		$_REQUEST['action']['a_input_state']='';
		$_REQUEST['action']['a_input_module_state']='U';
		$_REQUEST['action']['a_sleep']=0;
		$_REQUEST['action']['a_pri']=1;
		$_REQUEST['action']['a_output_val']='d';
		$_REQUEST['action']['a_output_state']='d';
		$_REQUEST['action']['a_active']='1';
		$_REQUEST['action']['a_macro']='';
		include("$INCLUDE_PATH/action/update.php");

		$_REQUEST['action']['a_name']="$m_name DOWN STOP";
		$_REQUEST['action']['a_input_state']='';
		$_REQUEST['action']['a_input_module_state']='U';
		$_REQUEST['action']['a_sleep']=-1;
		$_REQUEST['action']['a_pri']=2;
		$_REQUEST['action']['a_output_val']='s';
		$_REQUEST['action']['a_output_state']='D';
		$_REQUEST['action']['a_active']='1';
		$_REQUEST['action']['a_macro']='';
		include("$INCLUDE_PATH/action/update.php");

		$_REQUEST['action']['a_name']="$m_name STOP";
		$_REQUEST['action']['a_input_state']='';
		$_REQUEST['action']['a_input_module_state']='d';
		$_REQUEST['action']['a_sleep']=0;
		$_REQUEST['action']['a_pri']=1;
		$_REQUEST['action']['a_output_val']='s';
		$_REQUEST['action']['a_output_state']='D';
		$_REQUEST['action']['a_active']='1';
		$_REQUEST['action']['a_macro']='';
		include("$INCLUDE_PATH/action/update.php");

		$_REQUEST['action']['a_name']="$m_name STOP";
		$_REQUEST['action']['a_input_state']='';
		$_REQUEST['action']['a_input_module_state']='u';
		$_REQUEST['action']['a_sleep']=0;
		$_REQUEST['action']['a_pri']=1;
		$_REQUEST['action']['a_output_val']='s';
		$_REQUEST['action']['a_output_state']='U';
		$_REQUEST['action']['a_active']='1';
		$_REQUEST['action']['a_macro']='';
		include("$INCLUDE_PATH/action/update.php");


	}


	//print_r($_REQUEST);

	$location_action=$sortowanie;
?>
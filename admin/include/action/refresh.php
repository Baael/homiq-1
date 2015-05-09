<?
	if (!$_REQUEST['o_id']) return;

	$sql="SELECT * FROM outputs WHERE o_id=".$_REQUEST['o_id'];
	parse_str(query2url($sql));


	if (!strlen($o_master) || !strlen($o_module) || !strlen($o_adr)) return;

	
	$sql="	INSERT INTO action
			(a_name,a_active,a_input_master,a_input_module,a_input_adr,a_input_state,a_input_module_state,a_pri,a_sleep,
			a_output_master,a_output_module,a_output_adr,a_output_val,a_output_state,a_macro,a_macro_param)
			SELECT trim(a_name)||' a potem OFF',a_active,a_input_master,a_input_module,a_input_adr,a_input_state,a_input_module_state,a_pri,-1,
			a_output_master,a_output_module,a_output_adr,'0','0',a_macro,a_macro_param
			FROM action WHERE a_output_master='$o_master' AND a_output_module='$o_module' AND a_output_adr='$o_adr'
			AND a_output_state=1";

	pg_exec($db,$sql);

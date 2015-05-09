<?

	$suma=0+@array_sum($_REQUEST['actions']['a_input_adr']);
	$_REQUEST['actions']['a_input_adr']=$suma;

	//print_r($_REQUEST);

	$a=$_REQUEST['actions'];
	unset($_REQUEST['actions']);
	$_REQUEST['action']=$a;

	$action='update';

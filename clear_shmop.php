<?php
	require (dirname(__FILE__).'/shmop.db.php');

	$send=new SCHMOP_DB('send');


	$send->delete();
	

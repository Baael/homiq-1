<?php
	require (dirname(__FILE__).'/homiq.class.php');

	$h=new HOMIQ(DEBUG_BASIC + DEBUG_RFRAMES + DEBUG_SFRAMES );

	$h->run();

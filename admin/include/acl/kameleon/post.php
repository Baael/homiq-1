<?php
	if ($WEBTD->sid) return;

	$acl->puke_debug_as_comment();
	$acl->close();
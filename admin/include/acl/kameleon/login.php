<?
	$url=$acl->loginInfoUrl();
	parse_str($url);

	$info=$acl->session['login.info'];
	$acl->session['login.info']='';

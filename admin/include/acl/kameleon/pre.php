<?
	if ($WEBTD->sid) return;


	if (!is_resource($db) && file_exists("$INCLUDE_PATH/acl/const.php") ) include("$INCLUDE_PATH/acl/const.php");
	require_once("$INCLUDE_PATH/acl/class/db.class.php");
	require_once("$INCLUDE_PATH/acl/class/acl.class.php");

	include(dirname(__FILE__).'/const.php');

	require_once("$INCLUDE_PATH/acl/kameleon/fun.php");

	$_SERVER['tree']=$tree;


	if (is_resource($db))
	{
		$adb=new ACL_DB($db,$C_DB_CONNECT);
	}
	else
	{
		$adb=new ACL_DB($C_DB_TYPE,$C_DB_CONNECT);
	}

	$acl=new ACL($adb,ACL_SESSION_TIME);
	$acl->debug=ACL_DEBUG_LEVEL;

	$acl->session_start();
	$acl->init('',$SERVER_ID);

	$_SERVER['acl']=$acl;
	$_SERVER['adb']=$adb;


	if (strlen($_REQUEST['login']) && strlen($_REQUEST['pass']))
	{
		$login_id=$acl->login($_REQUEST['login'],$_REQUEST['pass']);
		if (!$login_id) 
		{

			$acl->session['login.info']=ACL_NO_LOGIN;
			Header("Location: $prevpage?t=".time());
			$acl->close();
			die();
		}

	}
	else
	{
		$login_id=$acl->login();
	}

	if ($login_id) 
	{
		$_REQUEST['login_id']=$login_id;
		$_REQUEST['login']=$acl->login;
		$login=$_REQUEST['login'];
	}

	$acl->debug("Entering page $page right check");
	$access=acl_Page($page);
	$acl->debug("End page $page right check");


	
	if (!$access && $page)
	{
		$acl->session['login.info']=ACL_NO_PRIV_VISIT;
		$acl->redirect($_SERVER['REQUEST_URI'],PAGE_VISIT_RIGHT,PAGE_RESOURCE,acl_treeArray($page,$tree));
		$redirectnow="$prevpage?t=".time();
		@Header("Location: $redirectnow");
		$acl->debug("redirecting to $redirectnow");
		$acl->close();
		die();
	}
	$acl->redirect();

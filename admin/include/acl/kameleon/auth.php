<?

	require_once(dirname(__FILE__).'/../class/db.class.php');
	require_once(dirname(__FILE__).'/../class/acl_core.class.php');
	require_once(dirname(__FILE__).'/../class/fun.php');


	$C_DB_TYPE='';

	if (file_exists(dirname(__FILE__).'/../const.php'))
	{
		include(dirname(__FILE__).'/../const.php');
	}

	if (strlen($C_DB_TYPE) && strlen($C_DB_CONNECT))
	{
		$adb2=new ACL_DB($C_DB_TYPE,$C_DB_CONNECT);
	}
	else
	{
		$adb2=new ACL_DB($adodb->_connectionID);
	}

	include(dirname(__FILE__).'/const.php');
	include_once(dirname(__FILE__).'/fun.php');	
	


	$auth_acl=new ACL($adb2);
	$auth_acl->debug=ACL_DEBUG_LEVEL;
	$auth_acl->session_start();
	

	if (strlen($_POST['u']) && strlen($_POST['p']))
	{
		$_auth=explode("@",$_POST['u']);		
		$USERNAME=$_auth[0];
		$PASSWORD=$_POST['p'];
		$SERVER = $_auth[1];
		$login_id=$auth_acl->login($USERNAME,$PASSWORD);
		$adodb->addToSession('login.alreadyLogedIn', true, true);
	}
	else
	{
		$login_id=$auth_acl->login();
	}


	if (!$login_id) unauthorize($auth_acl->last_debug_msg);

	if ($auth_acl->getFromSession('login.alreadyLogedIn'))
	{
		$USERNAME=$auth_acl->getFromSession('login.login');
		$SERVER=$auth_acl->getFromSession('login.server');
		$cpass=$auth_acl->getFromSession('login.cpass');
	}


	$login_path='login.php';
	$limit=5;
	while ($limit--)
	{
		if (file_exists($login_path)) break;
		$login_path="../$login_path";
	}

	$dn=dirname($_SERVER['SCRIPT_NAME']);
	if ($dn=='/') $dn='';


	$login_path=str_replace(realpath($_SERVER['DOCUMENT_ROOT']),'',realpath($_SERVER['DOCUMENT_ROOT'].$dn.'/'.$login_path));
	


	if (strlen($_POST['p']) && $_POST['p']!=$cpass && $_POST['r'])
	{
		SetCookie('wku',$USERNAME,time()+365*24*3600,$login_path);
		SetCookie('wkp',$cpass,time()+365*24*3600,$login_path);
	}
	if (strlen($_POST['p']) && $_POST['p']==$cpass && !$_POST['r'])
	{
		SetCookie('wku','',time()+365*24*3600,$login_path);
		SetCookie('wkp','0',time()+365*24*3600,$login_path);
	}

	if (!$ADMIN_MODE)
	{

		if (!is_array($_server) || !count($_server) ) 
		{
			$server=login_time_server($USERNAME);

			if (!$server)
			{
				$sql='SELECT id,nazwa FROM servers WHERE id>0';
				$rs=$adodb->execute($sql);
				for ($i=0;$i<$rs->RecordCount();$i++)
				{
					parse_str(ado_explodeName($rs,$i));

					$auth_acl->init($nazwa,$id);
					if ($auth_acl->hasRight('read','kameleon'))
					{
						$server=$id;
						break;
					}
				}
				
			}

			$server+=0;
			$query="SELECT * FROM servers WHERE id=$server";
			$_server=ado_ObjectArray($adodb,$query);
		}

		if (!is_array($_server) || !count($_server) ) unauthorize("Server not found");

		$SERVER=$_server[0];

		//print_r($SERVER);die();

		$auth_acl->init($SERVER->nazwa,$SERVER->id);


		$auth_acl->resourceAdd('kameleon');
		$auth_acl->resourceAdd(PAGE_RESOURCE);
		$auth_acl->resourceAdd(MENU_RESOURCE);
		$auth_acl->resourceAdd(TD_RESOURCE);
		$auth_acl->resourceAdd('class');

		$auth_acl->groupAdd('kameleon');
		$auth_acl->groupAdd('admin');

		$auth_acl->rightAdd(FTP_RIGHT);
		$auth_acl->rightAdd(PROOF_RIGHT);

		
		if (!$auth_acl->hasRight('read','kameleon')) unauthorize("Insufficient rights: read kameleon - ".$auth_acl->system_name());



		$SERVER_ID=$SERVER->id;
		$SERVER_NAME=$SERVER->nazwa;

	}

	$u=$auth_acl->loginInfo();

	//echo '<pre>'.print_r($u,true).'</pre>';

	$KAMELEON['username']=$u['au_login'];
	$KAMELEON['fullname']=$u['au_name'];
	$KAMELEON['email']=$u['au_email'];
	$KAMELEON['password']=$cpass;

	$forget_help=$u['au_forget_help'];

	$kameleon->user=$KAMELEON;
	//$kameleon->user[pages]=$pages;
	$kameleon->user['admin']=$auth_acl->hasRight('grant','kameleon');
	//$kameleon->user[menus]=$menus;
	$kameleon->user[skin]=$u['au_skin'];
	$kameleon->current_server=$SERVER;
	$kameleon->user[skinpath]=$CONST_SKINS_DIR."/".$kameleon->user[skin];


	$LICENSE_AGREEMENT=$u['au_license_agreement'];
	$ADMIN_RIGHTS=$kameleon->user['admin'];
	$TEMPL_RIGHTS=$auth_acl->hasRight('write','kameleon');

	if (strlen($u['au_lang'])>0) $kameleon->setlang($u['au_lang']);


	$FTP_RIGHTS=$auth_acl->hasRight(FTP_RIGHT,PAGE_RESOURCE,$page+0);
	$CLASS_RIGHTS=$auth_acl->hasRight('read','class');

	$PAGE_RIGHTS=array('fun'=>'acl_hasPageRight($nr,WRITE_RIGHT)');
	$MENU_RIGHTS=array('obj'=>&$auth_acl,'fun'=>'hasRight(WRITE_RIGHT,MENU_RESOURCE,$nr)');
	$PROOF_RIGHTS=array('fun'=>'acl_hasPageRight($nr,PROOF_RIGHT)');

	$_SERVER['acl']=&$auth_acl;




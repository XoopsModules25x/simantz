<?php
	include_once ('../../mainfile.php');
	include_once (XOOPS_ROOT_PATH.'/header.php');
	include_once 'class/Permission.php';
	include_once 'class/Organization.php';
	include_once 'class/Log.php';
	$log = new Log();


	$url=XOOPS_URL;
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$tableinvoice=$tableprefix . "simtrain_student";
	$tableinvoiceline=$tableprefix . "simtrain_ProductMaster";
	$tablecustomer=$tableprefix . "simitrain_organization";
	$tableuser= $tableprefix . "users";
	$backuppath=XOOPS_ROOT_PATH."/../backup";

	$module_id=$xoopsModule->getVar('mid');
//	$slogan = "SLOGAN TUITION CENTER";
	$errorstart="<b style='color:red'>";
	$errorend="</b>";

	$permission = new Permission($xoopsDB,$tableprefix,$log,$module_id);
	$break=explode('/',$_SERVER['SCRIPT_NAME']);
	$usefilename=$break[count($break)-1];

	global $xoopsUser;
	if(!$xoopsUser)
		redirect_header($url,2,"<b style='color:red'>Session expired, please relogin.</b>");
	else
	$userid=$xoopsUser->getVar('uid');


	session_start(); 

	$o = new Organization();
//	$a = new Accounts();


	if( $_GET['switchorg']=='Y')
	$_SESSION['defaultorganization_id']=$_GET['defaultorganization_id'];

	$defaultorganization_id=$_SESSION['defaultorganization_id'];
	//$orgid=$_POST['organization_id'];

	if($defaultorganization_id=='' ){
		$defaultorganization_id=0;//$o->getDefaultOrganization($userid);
		$_SESSION['defaultorganization_id']=$defaultorganization_id; 

	}

	/*

	if(!$permission->checkPermission($userid,$module_id,$usefilename))
		 redirect_header("index.php",$pausetime,
			"<b style='color:red'>You don't have permission to access this page, back to home.</b>");
	*/

	$menuname=$permission->checkPermission($userid,$module_id,$usefilename);
	
	
	if($menuname == "")
		 redirect_header("index.php",$pausetime,
			"<b style='color:red'>You don't have permission to access this page, back to home.</b> ");

	$orgwhereaccess=$permission->orgWhereStr($userid);
	include "setting.php";



	?>

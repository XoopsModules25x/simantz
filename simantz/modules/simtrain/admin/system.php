<?php
	include_once "admin_header.php" ;
	include_once "../class/Log.php";
	include_once "../class/Permission.php";

	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

	$module_id=$xoopsModule->getVar('mid');
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$log = new Log();
	$permission = new Permission($xoopsDB,$tableprefix,$log,$module_id);

	$userid=$xoopsUser->getVar('uid');
	$sql="SELECT count(uid) as canaccess from $tableprefix"."groups_users_link 
		where uid=$userid and groupid=1";
	$row=$xoopsDB->fetchArray($xoopsDB->query($sql));
	$canaccess=$row['canaccess'];
	$pausetime=1;
	$tokenlife=700;
	if($canaccess==0){
		redirect_header("../index.php",3,"<b style='color:red'>Only webmaster can access this url,redirect to main page.");
	exit (1);}
	include "../setting.php";
	?>

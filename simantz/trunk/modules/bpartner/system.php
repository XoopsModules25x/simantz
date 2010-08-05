<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	include "../simantz/system.php";
      include_once '../simantz/setting.php';
	include "setting.php";
	include "setting.php";
	
	$break=explode('/',$_SERVER['SCRIPT_NAME']);
	$usefilename=$break[count($break)-1];
	$uid=$xoopsUser->getVar('uid');
	$uname=$xoopsUser->getVar('uname');
	$url=XOOPS_URL;
	
	
	$tablebpartner=$tableprefix."bpartner";
	$tablebpartnergroup=$tableprefix."bpartnergroup";
	$tableindustry=$tableprefix."industry";
        $tableterms=$tableprefix."terms";

	$tableaccountclass=$tableprefix."simbiz_accountclass";
	$tableaccountgroup=$tableprefix."simbiz_accountgroup";
	$tableaccounts=$tableprefix."simbiz_accounts";
//	$tableterms=$tableprefix."terms";
	

?>

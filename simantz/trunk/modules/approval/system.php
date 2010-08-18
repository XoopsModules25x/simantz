<?php
	//include_once '../simantz/class/Permission.php';
//	include_once '../simantz/class/Organization.inc.php';
//	include_once 'class/Accounts.php';
//	include_once 'accounts.php';

	//include_once '../simantz/class/Log.inc.php';

	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	include "../simantz/system.php";
      include_once '../simantz/setting.php';
	include "setting.php";
        
        
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$tableuser= $tableprefix . "users";
	$tablecountry=$tableprefix."country";
	$tablebpartner=$tableprefix."bpartner";
	$tablebpartnergroup=$tableprefix."bpartnergroup";
	$tableconversion=$tableprefix."conversionrate";
	$tablecurrency=$tableprefix."currency";
	$tableorganization=$tableprefix."organization";
	$tableperiod=$tableprefix."period";
	$tablegroups=$tableprefix."groups";
	$tableterms=$tableprefix."terms";
	
    $tablewindow=$tableprefix."window";
	$tablegroups_users_link=$tableprefix."groups_users_link";
	$tablegrouppermission=$tableprefix."group_permission";
	$tablemodules=$tableprefix."modules";
	$tableconversionrate=$tableprefix."conversionrate";
	$tableusers=$tableprefix."users";
	$tableraces= $tableprefix . "races";
    $tablereligion= $tableprefix . "religion";
    $tableyear=$tableprefix."year";
  
?>

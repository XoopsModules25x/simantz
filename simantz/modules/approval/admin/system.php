<?php
	include_once "admin_header.php" ;
	include_once '../../simantz/class/Log.inc.php';
	include_once '../class/Permission.php';
	include "../setting.php";
        include_once "../../simantz/class/datepicker/class.datepicker.php";
	include_once '../../simantz/class/SelectCtrl.inc.php';

	//include_once '../class/Permission.php';

	//$ctrl=new SelectCtrl();

	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	$log = new Log();
	$url=XOOPS_URL;
	$url=XOOPS_URL."/modules/simantz";

	xoops_cp_header();
	$module_id=$xoopsModule->getVar('mid');
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$userid=$xoopsUser->getVar('uid');
	//$pausetime=0;
	//$tokenlife=600;
	//$permission = new Permission();
	$tablecountry=$tableprefix."country";
	$tableaccountclass=$tableprefix."simbiz_accountclass";
	$tableaccountgroup=$tableprefix."simbiz_accountgroup";
	$tableaccounts=$tableprefix."simbiz_accounts";
	$tablebatch=$tableprefix."simbiz_batch";
	$tablebpartner=$tableprefix."bpartner";
	$tablebpartnergroup=$tableprefix."bpartnergroup";
	$tableconversion=$tableprefix."simbiz_conversion";
	$tablecurrency=$tableprefix."currency";
	$tableorganization=$tableprefix."organization";
	$tableperiod=$tableprefix."period";
	$tabletax=$tableprefix."simbiz_tax";
	$tablegroups=$tableprefix."groups";
	$tableterms=$tableprefix."terms";
	$tabletransaction=$tableprefix."simbiz_transaction";
	$tabletranssummary=$tableprefix."simbiz_transsummary";
	$tablewindow=$tableprefix."simedu_window";
	$tableheapermission=$tableprefix."simedu_heapermission";
    $tablehespermission=$tableprefix."simedu_hespermission";
    $tablehrpermission=$tableprefix."simedu_hrpermission";
    $tablehostelpermission=$tableprefix."simedu_hostelpermission";
    $tablefinancepermission=$tableprefix."simedu_financepermission";
	$tablegroups_users_link=$tableprefix."groups_users_link";
	$tablegrouppermission=$tableprefix."group_permission";
	$tablemodules=$tableprefix."modules";
	$tableusers=$tableprefix."users";

	$defaultorganization_id=$_SESSION['defaultorganization_id'];

    $permission = new Permission();
	?>

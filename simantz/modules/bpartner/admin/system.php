<?php
include_once "../../../mainfile.php";
include_once XOOPS_ROOT_PATH . "/include/cp_header.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
//$xoopsTpl->assign('xoops_pagetitle', $menuname);

xoops_cp_header();

include_once "../setting.php";
include_once '../class/Log.php';
$log = new Log();
$url=XOOPS_URL;
$isadmin=$xoopsUser->getVar('uid');
$tableprefix= XOOPS_DB_PREFIX . "_";
$tableuser= $tableprefix . "users";
$tableraces= $tableprefix . "races";
$tableaddress=$tableprefix."address";
$tablecontacts=$tableprefix."contacts";
$tableaccounts=$tableprefix."simbiz_accounts";
$tabletax=$tableprefix."simbiz_tax";
$tablecountry=$tableprefix."country";
$tablebpartner=$tableprefix."bpartner";
$tablebpartnergroup=$tableprefix."bpartnergroup";
$tablecurrency=$tableprefix."currency";
$tableorganization=$tableprefix."organization";
$tableperiod=$tableprefix."period";
$tablegroups=$tableprefix."groups";
$tableregion=$tableprefix."region";
$tablereligion=$tableprefix."religion";
$tableterms=$tableprefix."terms";
$tabletransaction=$tableprefix."simbiz_transaction";
$tabletranssummary=$tableprefix."simbiz_transsummary";
$tableconversionrate=$tableprefix."conversionrate";
$tablebatch=$tableprefix."simbiz_batch";
$tableinventorychangeline=$tableprefix."simiterp_inventorychangeline";
$tableinventorychange=$tableprefix."simiterp_inventorychange";
$tableproject=$tableprefix."simiterp_project";
$tablewindow=$tableprefix."window";
$tablepermission=$tableprefix."permission";
$tablegroups_users_link=$tableprefix."groups_users_link";
$tablegrouppermission=$tableprefix."group_permission";
$tablemodules=$tableprefix."modules";

$tablesystemlist=$tableprefix."simiterp_systemlist";
$tablestatus=$tableprefix."simiterp_status";
$tabletype=$tableprefix."simiterp_type";
$tablestafftype=$tableprefix."simiterp_stafftype";
$tableindustry=$tableprefix."industry";
$tableusers=$tableprefix."users";
$tablestock=$tableprefix."simiterp_currentstock";
$tableproducttransaction=$tableprefix."simiterp_producttransaction";
$defaultorganization_id=0;
$tableuom=$tableprefix."simiterp_uom";
$tableinventorymovement=$tableprefix."simiterp_productmovement";
$tableinventorymovementline=$tableprefix."simiterp_productmovementline";
$tableshipment=$tableprefix."simiterp_shipment";
$tableshipmentline=$tableprefix."simiterp_shipmentline";
$tableproduction=$tableprefix."simiterp_production";
$tableproductionoutput=$tableprefix."simiterp_productionoutput";
$tableproductionline=$tableprefix."simiterp_productionline";
$tableemployee=$tableprefix."simiterp_employee";
$tablepricelist=$tableprefix."simiterp_pricelist";
$tablefollowuptype=$tableprefix."followuptype";
$tablefollowup=$tableprefix."followup";


?>

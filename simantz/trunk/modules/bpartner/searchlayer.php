<?php

include('../../mainfile.php');
include(XOOPS_ROOT_PATH.'/header.php');

include '../simantz/class/Log.inc.php';
include '../simantz/class/SelectCtrl.inc.php';
include('../bpartner/class/SearchLayer.inc.php');

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
        $tablerelationship=$tableprefix."simedu_relationship";
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

        $tablepricelist=$tableprefix."simiterp_pricelist";
        $tablefollowuptype=$tableprefix."followuptype";
        $tablefollowup=$tableprefix."followup";

        $tablegroupuserslink=$tableprefix."groups_users_link";
        $tablegroups=$tableprefix."groups";
        
        
$log=new Log();
$ctrl=new SelectCtrl();
$o=new SearchLayer();


$action=$_REQUEST['action'];
$searchtxt=$_REQUEST['searchtxt'];
$col=$_REQUEST['col'];
$o->searchbpartner_no=$_REQUEST['searchbpartner_no'];
$o->searchbpartner_name=$_REQUEST['searchbpartner_name'];
$o->searchbpartnergroup_id=$_REQUEST['searchbpartnergroup_id'];
$o->searchindustry_id=$_REQUEST['searchindustry_id'];
$o->searchpic=$_REQUEST['searchpic'];
$o->searchisactive=$_REQUEST['searchisactive'];
$o->currency_id=$_REQUEST['currency_id'];
$o->bpartneraccounttype=$_REQUEST['bpartneraccounttype'];

//$ctrl=
switch($action){

	
	case "jsbpartner":
		$o->showBPartnerJS();
	break;
	case "showBPartnerSearchForm":
    $o->GetBpartnerWindow($searchtxt,$col,$o->bpartneraccounttype);
	break;
	case "showBPartnerSearchResult":
		$o->showBPartnerResult();
	break;	
	default:
		echo "Invalid action!";
		
	break;
	
	}

<?php
	include_once ('../../mainfile.php');
	include_once (XOOPS_ROOT_PATH.'/header.php');

        include_once ('class/Log.inc.php');
        include_once "class/Save_Data.inc.php";
        //include_once("class/nitobi.xml.php");
     	include_once "class/EBAGetHandler.php";

        include_once "setting.php";
        $defaultorganization_id=$_SESSION['defaultorganization_id'];

$log=new Log();
$o=new Save_Data();

$saveHandler = new EBASaveHandler();
$saveHandler->ProcessRecords();
$timestamp=date("Y-m-d H:i:s",time());
$createdby=$xoopsUser->getVar('uid');
$uname=$xoopsUser->getVar('uname');
$uid=$xoopsUser->getVar('uid');

$isadmin=$xoopsUser->isAdmin();
$action=$_GET['action'];

if($isadmin)
$log->showLog(3,"Current user is admin user");


//$log->cleanLog();

switch($action){
        case "country":

            $o->saveCountry();
            break;
        case "window":
            $o->saveWindow();
            break;
        case "currency":
            $o->saveCurrency();
            break;
        case "conversionrate":
            $o->saveConversionRate();
            break;
        case "period":
            $o->savePeriod();
            break;
         case "races":

                        $o->saveRaces();
                     break;
        case "region":
                        $o->saveRegion();
                     break;
        case "religion":
                        $o->saveReligion();
                     break;
        case "bpartnergroup":
                $o->saveBPartnerGroup();
                break;
        case "bpartner":
                $o->saveBPartner();
                break;
        case "terms":
                $o->saveTerms();
                break;
        case "industry":
                $o->saveIndustry();
                break;
        case "followuptype":
                $o->saveFollowUpType();
                break;
            default :
        case "savebpartnerfromtablelist":
                $o->saveBPartnerFromTableList();
                break;
        case "workflow":

                $o->saveWorkflow();
                break;
        
            default :
                break;
}
?>
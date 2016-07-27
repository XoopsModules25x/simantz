<?php
	include_once ('../../mainfile.php');
//	include_once (XOOPS_ROOT_PATH.'/header.php');
        include_once "class/Load_Data.inc.php";
 	include_once "class/EBAGetHandler.php";
        include_once "class/Log.inc.php";
        include_once "setting.php";
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    //    header('Content-type: text/xml');
        $defaultorganization_id=$_SESSION['defaultorganization_id'];
        $defaultpagesize=15;
        $action=$_GET['action'];

        $log = new Log();
      //  $log->cleanLog();
        $o = new Load_Data();
        $getHandler = new EBAGetHandler();
        $isadmin=$xoopsUser->isAdmin();

        $log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
//$getHandler->
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
        switch($action){
            case "country":
                break;
            case "region":
            $wherestring=" WHERE region_id>0 ";
                $o->showReligion($wherestring);
                break;

         case "currency":
             $wherestring=" WHERE currency_id>0";
                $o->showCurrency($wherestring);
                break;
         case "window":
             $wherestring=" WHERE window_id>0";
                $o->showWindow($wherestring);
                break;
         case "conversionrate":
            $wherestring=" WHERE conversion_id>0 and organization_id=$defaultorganization_id";
                $o->showConversionRate($wherestring);
                break;
        case "period":
            $wherestring=" WHERE period_id>0 ";
                $o->showPeriod($wherestring);
             break;
        case "races":
            $wherestring=" WHERE races_id>0 ";
                $o->showRaces($wherestring);
             break;
        case "region":
            $wherestring=" WHERE religion_id>0 ";
                $o->showRegion($wherestring);
             break;
        case "religion":
            $wherestring=" WHERE religion_id>0 ";
                $o->showReligion($wherestring);
             break;
        case "bpartnergroup":
            $wherestring=" WHERE bpartnergroup_id>0  and organization_id=$defaultorganization_id";
                $o->showBPartnerGroup($wherestring);
                break;
        case "bpartner":
            $wherestring=" WHERE bpartner_id>0  and organization_id=$defaultorganization_id";
                $o->showBPartner($wherestring);
                break;
        case "terms":
            $wherestring=" WHERE terms_id>0  and organization_id=$defaultorganization_id";
                $o->showTerms($wherestring);
                break;
        case "industry":
            $wherestring=" WHERE industry_id>0 ";
                $o->showIndustry($wherestring);
                break;
        case "followuptype":
            $wherestring=" WHERE followuptype_id>0  and organization_id=$defaultorganization_id";
                $o->showFollowUpType($wherestring);
                break;
        case "followup":
            $wherestring=" WHERE followuptype_id>0  and organization_id=$defaultorganization_id";
                $o->showFollowUp($wherestring);
                break;
        case "workflow":
                $wherestring=" WHERE workflow_id>0";
                $o->showWorkflow($wherestring);
                break;

            default :
                break;

        }
      

$getHandler->completeGet();

?>
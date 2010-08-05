<?php
	include_once ('../../mainfile.php');
//	include_once (XOOPS_ROOT_PATH.'/header.php');
        include_once "class/Lookup.inc.php";
        include_once "class/Log.inc.php";
        include_once "setting.php";
 	include_once "class/EBAGetHandler.php";
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        header('Content-type: text/xml');
        $log=new Log();
        $o = new Lookup();
        $action=$_GET['action'];
        $defaultorganization_id=$_SESSION['defaultorganization_id'];
        $lookupdelay=1000;
        $pagesize=&$_GET["pagesize"];
        $ordinalStart=&$_GET["startrecordindex"];
        $sortcolumn=&$_GET["sortcolumn"];
         $sortdirection=&$_GET["sortdirection"];

         $getHandler = new EBAGetHandler();
         $getHandler->ProcessRecords();
        switch($action){
            case "country":
                  $getHandler->DefineField("country_id");
                $wherestring=" WHERE country_id>0 and isdeleted=0";
                $o->showCountry();
                break;
             case "module":
                  $getHandler->DefineField("mid");
                $wherestring=" WHERE mid>0";
                $o->showModule();
                break;
              case "window":
                  $getHandler->DefineField("window_id");
                $wherestring=" WHERE window_id>=0";
                $o->showWindow();
                break;

              case "libwindow":
                  $getHandler->DefineField("window_id");
                $wherestring=" WHERE window_id>=0";
                $o->showLibWindow();
                break;
             case "currency":
             $getHandler->DefineField("currency_id");
             $wherestring=" WHERE currency_id>0";
                $o->showCurrency();
                break;
            case "period":
             $getHandler->DefineField("period_id");
             $wherestring=" WHERE period_id>0";
                $o->showCurrency();
                break;
        case "races":
            $getHandler->DefineField("period_id");
            $wherestring=" WHERE races_id>0 ";
                $o->showRaces($wherestring);
             break;
        case "region":
            $getHandler->DefineField("religion_id");
            $wherestring=" WHERE religion_id>0 ";
                $o->showRegion($wherestring);
             break;
        case "religion":
            $getHandler->DefineField("religion_id");
            $wherestring=" WHERE religion_id>0 ";
                $o->showReligion($wherestring);
             break;
        case "bpartnergroup":
            $getHandler->DefineField("bpartnergroup_id");
            $wherestring=" WHERE bpartnergroup_id>0  and organization_id=$defaultorganization_id";
                $o->showBPartnerGroup($wherestring);
                break;
        case "bpartner":
            $getHandler->DefineField("bpartner_id");
            $wherestring=" WHERE bpartner_id>0  and organization_id=$defaultorganization_id";
                $o->showBPartner($wherestring);
                break;
        case "terms":
            $getHandler->DefineField("terms_id");
            $wherestring=" WHERE terms_id>0  and organization_id=$defaultorganization_id";
                $o->showTerms($wherestring);
                break;
        case "industry":
            $getHandler->DefineField("industry_id");
            $wherestring=" WHERE industry_id>0 ";
                $o->showIndustry($wherestring);
                break;
        case "followuptype":
            $getHandler->DefineField("followuptype_id");
            $wherestring=" WHERE followuptype_id>0  and organization_id=$defaultorganization_id";
                $o->showFollowUpType($wherestring);
                break;
        case "usergroup":
            $getHandler->DefineField("groupid");
            $wherestring=" WHERE groupid>0";
            $o->showUsergroup();
                break;
        case "employee":
            $getHandler->DefineField("workflow_owneruid");
            $wherestring=" WHERE employee_id>0";
            $o->showEmployee();
                break;
            default :
                break;

        }
      

        
       



$getHandler->completeGet();

?>

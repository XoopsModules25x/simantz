<?php
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        include_once("class/nitobi.xml.php");
	include_once ('../../mainfile.php');
        include_once "class/Selection.inc.php";
        include_once "class/Log.inc.php";
        include_once "setting.php";


        $id=$_GET['id'];
        $defaultorganization_id=$_SESSION['defaultorganization_id'];
        $defaultpagesize=15;
        $action=$_GET['action'];

        $log = new Log();
        $o = new Selection();
        $isadmin=$xoopsUser->isAdmin();
        
       $getHandler = new EBAGetHandler();

  switch($action){
            case "country":
                $wherestring=" WHERE country_id>0 and isdeleted=0";
                $o->showCountry();
                break;
             case "module":
                $wherestring=" WHERE mid>0";
                $o->showModule();
                break;
              case "window":
                $wherestring=" WHERE window_id>=0";
                $o->showWindow();
                break;
             case "currency":
             $wherestring=" WHERE currency_id>0";
                $o->showCurrency();
                break;
            case "period":
             $wherestring=" WHERE period_id>0";
                $o->showCurrency();
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
        case "employee":
            $wherestring=" WHERE employee_id>0  and organization_id=$defaultorganization_id";
                $o->showEmployee($wherestring);
                break;
        case "terms":
            $wherestring=" WHERE terms_id>0  and organization_id=$defaultorganization_id";
                $o->showTerms($wherestring);
                break;
        case "industry":
            $wherestring=" WHERE industry_id>0 ";
                $o->showIndustry($wherestring);
                break;
        case "tax":
            $wherestring=" WHERE tax_id>0 ";
                $o->showTax($wherestring);
                break;
        case "pricelist":
            $wherestring=" WHERE pricelist_id>0 ";
                $o->showPriceList($wherestring);
                break;
        case "accounts":
            $wherestring=" WHERE accounts_id>0 ";
                $o->showAccounts($wherestring);
                break;
        case "followuptype":
            $wherestring=" WHERE followuptype_id>0  and organization_id=$defaultorganization_id";
                $o->showFollowUpType($wherestring);
                break;
            default :
                break;

        }


$getHandler->CompleteGet();



?>
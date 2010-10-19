<?php

	include_once ('../../mainfile.php');
        
        include "../simantz/class/Log.inc.php";
        include "../simantz/class/Lookup.inc.php";
        include "../bpartner/class/BPartnerLookup.inc.php";

        include "../simantz/setting.php";
        include "setting.php";

 	include "../simantz/class/EBAGetHandler.php";

        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        header('Content-type: text/xml');

        $log=new Log();
        $o = new BPartnerLookup();

        $action=$_GET['action'];
        $lookupdelay=1000;
        $pagesize=&$_GET["pagesize"];
        $ordinalStart=&$_GET["startrecordindex"];
        $sortcolumn=&$_GET["sortcolumn"];
         $sortdirection=&$_GET["sortdirection"];
        $searchstring=&$_GET["SearchString"];
        $uid=$xoopsUser->getVar('uid');
         $getHandler = new EBAGetHandler();
         $getHandler->ProcessRecords();
         $showNull=$_GET['showNull'];
     
        switch($action){

        case "searchbpartnercombo":

            $getHandler->DefineField("bpartner_id");
            $o->showBPartnerCombo();
                break;
              case "searchbpartnergrid":

            $getHandler->DefineField("bpartner_id");
            $o->showBPartnerGridLookup();
                break;
            default :
                break;

        }

$getHandler->completeGet();
<?php

	include_once ('../../mainfile.php');
        
        include "../simantz/class/Log.inc.php";
        include "../simantz/class/Lookup.inc.php";
        include "../simbiz/class/SimbizLookup.inc.php";

        include "../simantz/setting.php";
        include "setting.php";

 	include "../simantz/class/EBAGetHandler.php";

        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        header('Content-type: text/xml');

        $log=new Log();
        $o = new SimbizLookup();

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
        case "getaccountlistgrid": //return xml table to grid

            $getHandler->DefineField("accounts_cell");
            $wherestring=" WHERE (accounts_id>0 and placeholder=0) or accounts_id=0 ";
            $o->getSelectAccountGridLookup($wherestring);
        break;
        case "gettaxlistgrid": //return xml table to grid
            $getHandler->DefineField("tax_cell");
            $wherestring=" WHERE tax_id>=0 ";
            $o->getSelectTax($wherestring);
        break;
        case "gettracklist1grid": //return xml table to grid

            $getHandler->DefineField("track1_cell");
            $wherestring=" WHERE track_id>=0 and trackheader_id = 1 OR trackheader_id = 0   ";
            $o->getSelectTrack($wherestring);
           break;
        case "gettracklist2grid": //return xml table to grid

            $getHandler->DefineField("track2_cell");
            $wherestring=" WHERE track_id>=0 and trackheader_id = 2 OR trackheader_id = 0    ";
            $o->getSelectTrack($wherestring);
        break;
        case "gettracklist3grid": //return xml table to grid
            $getHandler->DefineField("track3_cell");
            $wherestring=" WHERE track_id>=0 and trackheader_id = 3 OR trackheader_id = 0  ";
            $o->getSelectTrack($wherestring);
        break;
        case "getbranchlistgrid": //return xml table to grid

            $getHandler->DefineField("organization_cell");
            $wherestring=" WHERE organization_id > 0 ";
            $o->getSelectBranch($wherestring);
        break;

            default :
                break;

        }

$getHandler->completeGet();
<?php
include "system.php";
include_once '../simantz/class/Period.inc.php';
include_once '../simantz/class/SelectCtrl.inc.php';

$o = new Period();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
$action=$_REQUEST['action'];
$isadmin=$xoopsUser->isAdmin();
$uid = $xoopsUser->getVar('uid');


switch($action){
case "search": //return xml table to grid
    $wherestring=" WHERE period_id>0";
    $o->showPeriod($wherestring);
    exit; //after return xml shall not run more code.
    break;
case "lookup": //return xml table to grid
     	include_once "../simantz/class/EBAGetHandler.php";
        $defaultorganization_id=$_SESSION['defaultorganization_id'];
        $lookupdelay=1000;
        $pagesize=&$_GET["pagesize"];
        $ordinalStart=&$_GET["startrecordindex"];
        $sortcolumn=&$_GET["sortcolumn"];
        $sortdirection=&$_GET["sortdirection"];

        $getHandler = new EBAGetHandler();
        $getHandler->ProcessRecords();
        $wherestring=" WHERE period_id>0";
        $o->showLookupPeriod($wherestring);
    exit; //after return xml shall not run more code.
    break;
case "save": //process submited xml data from grid

     $o->savePeriod();

    break;
default:

case "generatePeriod": //process submited xml data from grid

     $o->generateYear=$_REQUEST['generateYear'];
     $o->generatePeriod();
     $arr = array("status"=>1);
     echo json_encode($arr);

    break;
default:
    
include "menu.php";
$xoTheme->addStylesheet("$url/modules/simantz/include/popup.css");
$xoTheme->addScript("$url/modules/simantz/include/popup.js");
$xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
$xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.toolkit.js");
$xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.css");
$xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.js");
$xoTheme->addScript("$url/modules/simantz/include/firefox3_6fix.js");

$o->yearctrl=$ctrl->getSelectYear();

$o->showSearchForm(); //produce search form, comment here to hide search form
$o->getPeriodform();

require(XOOPS_ROOT_PATH.'/footer.php');

    break;
}


?>

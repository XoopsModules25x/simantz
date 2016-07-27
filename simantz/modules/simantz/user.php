<?php
include "system.php";
include_once '../simantz/class/User.inc.php';

$o = new User();
$s = new XoopsSecurity();
$action=$_REQUEST['action'];
$isadmin=$xoopsUser->isAdmin();
$uid = $xoopsUser->getVar('uid');


switch($action){


case "search": //return xml table to grid
    $wherestring=" WHERE uid>0";
    $o->showUser($wherestring);
    exit; //after return xml shall not run more code.
    break;

case "save": //process submited xml data from grid
     $o->saveUser();

case "searchsetting": //return xml table to grid
    $wherestring=" WHERE usersetting_id>0";
    $o->showSetting($wherestring);
    exit; //after return xml shall not run more code.
    break;

case "savesetting": //process submited xml data from grid
     $o->saveSetting();


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
        $wherestring=" WHERE uid>0";
        $o->showLookupUser($wherestring);
    exit; //after return xml shall not run more code.
    break;


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

$o->showSearchForm(); //produce search form, comment here to hide search form
$o->getUserform();
require(XOOPS_ROOT_PATH.'/footer.php');

    break;
}


?>

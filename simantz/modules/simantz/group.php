<?php
include "system.php";
include '../simantz/class/Group.inc.php';

$o = new Group();
$s = new XoopsSecurity();
$action=$_REQUEST['action'];
$o->isAdmin=$xoopsUser->isAdmin();
$uid = $xoopsUser->getVar('uid');


switch($action){

case "search": //return xml table to grid
    $wherestring=" WHERE groupid>0";
    $o->showGroup($wherestring);
    exit; //after return xml shall not run more code.
    break;





case "save": //process submited xml data from grid
     $o->saveGroup();
    break;

case "searchgroupline": //return xml table to grid
    $wherestring=" WHERE groupid >0";
    $o->showGroupline($wherestring);
    exit; //after return xml shall not run more code.
    break;

case "savegroupline": //process submited xml data from grid
    $o->saveGroupline();
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
$o->getGroup();
require(XOOPS_ROOT_PATH.'/footer.php');
    break;
}


?>

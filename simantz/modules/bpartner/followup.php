<?php
include "system.php";
include_once '../bpartner/class/FollowUp.inc.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
$o = new FollowUp();
$s = new XoopsSecurity();
$action=$_REQUEST['action'];
$dp=new datepicker($url);
$dp->dateFormat='Y-m-d';
$isadmin=$xoopsUser->isAdmin();
$uid = $xoopsUser->getVar('uid');
$o->createdby = $xoopsUser->getVar('uid');
$o->organization_id=$_REQUEST['organization_id'];

$year=date("Y",time());
$month=date("m",time());
$o->followup_id=$_REQUEST['followup_id'];
$o->followup_name=$_REQUEST['followup_name'];
$o->followuptype_id=$_REQUEST['followuptype_id'];


switch($action){
    case "editlayer":
        echo "ASD";
        break;



}
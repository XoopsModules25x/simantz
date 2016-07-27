<?php
include_once './class/Attendance.php';
include_once "system.php" ;
include_once "menu.php";
include_once './class/Log.php';
include_once 'class/Period.php';
include_once 'class/RegClass.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Attendance($xoopsDB, $tableprefix, $log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$period = new Period($xoopsDB,$tableprefix,$log);
$r= new RegClass ($xoopsDB,$tableprefix,$log);
$pausetime=10;

if (isset ($_POST['action']))
{
$o->tuitionclass_id=$_POST["tuitionclass_id"];
$o->period_id=$_POST["period_id"];
	$action=$_POST['action'];
}
elseif(isset($_GET['action'])){
$o->tuitionclass_id=$_GET["tuitionclass_id"];
$o->period_id=$_GET["period_id"];
	$o->area_id=$_GET['area_id'];
}
else
$action="";
if (isset($_POST['active']))
{$r->studentclass_id=$_POST["studentclass_id"];
$r->fetchRegClassInfo($r->studentclass_id);
$r->isactive=$_POST["isactive"];
$r->updateStudentClass();
}
if (isset($_POST['delete']))
{$r->studentclass_id=$_POST["studentclass_id"];
$r->fetchRegClassInfo($r->studentclass_id);
$r->deleteStudentClass($r->studentclass_id);
}

 switch ($action){
	//When user submit new organization
  case "create" :
break;
default:
$log->showLog(3,"Period: $o->period_id, Tuitionclass: $o->tuitionclass_id");
$o->periodctrl=$period->getPeriodList($o->period_id);
$o->getInputForm($o->tuitionclass_id, $o->period_id);
$o->fetchTuitionClassDetail($o->tuitionclass_id, $o->period_id);
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$o->showStudentClassTable($o->tuitionclass_id, $o->period_id);
break;
}
require(XOOPS_ROOT_PATH.'/footer.php');
?>
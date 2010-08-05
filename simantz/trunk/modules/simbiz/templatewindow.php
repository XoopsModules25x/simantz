<?php
include_once "system.php";
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/SelectCtrl.php';
include_once "../../class/datepicker/class.datepicker.php";
include_once('../../class/fpdf/fpdf.php');

$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include "system.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

include "../class/LoginHistory.php";
include "../class/datepicker/class.datepicker.php";
$url = XOOPS_URL."/modules/simantz";
$o = new LoginHistory();
$dp=new datepicker($url);
$dp->dateFormat='Y-m-d';

$action=$_POST['action'];
$o->activity=$_POST['activity'];
$o->datefrom=$_POST['datefrom'];
$o->dateto=$_POST['dateto'];

$o->showcalendarfrom=$dp->show("datefrom");
$o->showcalendarto=$dp->show("dateto");

if(isset($_POST['user_id']))
$o->user_id=$_POST['user_id'];
else
$o->user_id;

switch ($action){

    case "search":
          $o->showSearchForm();
          $wherestring=$o->genWhereString($o->user_id, $o->activity, $o->datefrom, $o->dateto,$action);
          $o->showTable($wherestring,"ORDER BY e.eventdatetime DESC");
        break;
    case "delete":
          $wherestring=$o->genWhereString($o->user_id, $o->activity, $o->datefrom, $o->dateto,$action);
          if($o->deleteEventRecord($wherestring))
           redirect_header("index.php",3,"Data remove from database successfully");
          else
           redirect_header("index.php",3,"<b style='color:red'>Data cannot remove from database!</b>");

        break;

    default:
        $o->showSearchForm();

        break;
}
xoops_cp_footer();
?>

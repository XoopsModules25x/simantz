<?php

include_once "system.php";
include_once "menu.php";
include_once "./class/Log.php";
include_once "./class/RegClass.php";
include_once "./class/Employee.php";
include_once "./class/TuitionClass.php";
include_once "./class/Period.php";
include_once "datepicker/class.datepicker.php";
$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$showdate=$dp->show("tuitiondate");

$o=new TuitionClass($xoopsDB, $tableprefix,$log);
$log=new Log();
$r=new RegClass($xoopsDB,$tableprefix,$log);
$p=new Period($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);
$uid=$xoopsUser->getVar('uid');
$orgctrl=$permission->selectionOrg($uid,$defaultorganization_id);

$selectday=$o->selectDay($o->day);
$selectperiod=$p->getPeriodList(0);

$o->day=$_POST['day'];
$o->period_id=$_POST['period_id'];

$log->showLog(3,"Period: $o->period_id, Day: $o->day");
echo <<< EOF
<script type='text/javascript'>

	function autofocus(){
	
		document.forms['frmPickUpList'].showdate.focus();
	}
</script>


<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Transport Pick Up List</span></big></big></big></div><br>-->
<form name="frmPickUpList" action="pickuplist.php" method="POST" target="_blank">
<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
  <tbody>
    <tr>
      <td class='head'>Date(YYYY-MM-DD)</td>
      <td class='odd'><input id='tuitiondate' name='tuitiondate'><input type='button' name='showdate' onclick="$showdate" value='Date'></td>
      <td class='head'>Organization</td>
      <td class='odd'>$orgctrl</td>
      <td class='head'>Transport Type</td>
      <td class='odd'><SELECT name='transporttype'><option value='0'>Come</option><option value='1'>Back</option></SELECT></td>
    </tr>
</tbody>
</table><br>
<input type='submit' value='Generate Pick Up Report' name='submit' style='font-size:22px;'><input type='hidden' value='come' name='case'></form>
EOF;


require(XOOPS_ROOT_PATH.'/footer.php');
?>
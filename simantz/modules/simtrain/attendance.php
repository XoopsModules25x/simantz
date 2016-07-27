<?php

include_once "system.php" ;
include_once ("menu.php");
include_once './class/Attendance.php';
include_once './class/Student.php';

include_once './class/Log.php';
include_once 'class/Period.php';
include_once 'class/RegClass.php';


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Attendance($xoopsDB, $tableprefix, $log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$period = new Period($xoopsDB,$tableprefix,$log);
$r= new RegClass ($xoopsDB,$tableprefix,$log);
$st = new Student($xoopsDB, $tableprefix,$log);
$o->cur_symbol=$cur_symbol;
$o->cur_name=$cur_name;
$r->cur_symbol=$cur_symbol;
$r->cur_name=$cur_name;

if (isset ($_POST['action']))
{
$o->tuitionclass_id=$_POST["tuitionclass_id"];
//$o->period_id=$_POST["period_id"];
	$action=$_POST['action'];
}
elseif(isset($_GET['action'])){
$o->tuitionclass_id=$_GET["tuitionclass_id"];
//$o->period_id=$_GET["period_id"];
	$action=$_GET['action'];
}
else
$action="";

$attendance_date=date("Y-m-d", time()) ;
echo <<< EOF
<script type="text/javascript">
	function loadattendance(){
		
		document.forms['frmAttendance'].submit.click();
	}
	function autofocus(){
		document.getElementById("divAddAttendance").style.display='none';
		document.getElementById("divRemoveAttendance").style.display='none';
	}

	function removeAttendance(id){
	if(confirm("Delete this attendance?")){
		document.frmRemoveAttendance.attendance_id.value=id;
		document.frmRemoveAttendance.submit.click();
	}
	else
		return false;
	}

	function addAttendance(schedule_id,student_id){
		var curtime = new Date();

		var curhour = curtime.getHours();
 		 var curmin = curtime.getMinutes();
 		 var cursec = curtime.getSeconds();
 		 var time = "";

		  time = "$attendance_date " +(curhour < 10 ? "0" : "") + curhour + ":" +
  		       (curmin < 10 ? "0" : "") + curmin + ":" +
   		      (cursec < 10 ? "0" : "") + cursec ;

		var time1=prompt("Enter value time in(YYYY-MM-DD HH:MM:SS)",time);
		if(time1=="" || time1==null)
		return false;
		//alert (time1);
		document.frmAddAttendance.student_id.value=student_id;
		document.frmAddAttendance.schedule_id.value=schedule_id;
		document.frmAddAttendance.attendance_time.value=time1;
		//document.frmAddAttendance.attendance_time.value=curtime;
		document.frmAddAttendance.submit.click();
	}


	function zoom(){
		
		var tuitionclass_id=document.forms['frmAttendance'].tuitionclass_id.value;
		
		window.open("tuitionclass.php?action=edit&tuitionclass_id="+tuitionclass_id);
	}
</script>
<div id='divAddAttendance'>
<form action='attendance.php' method='POST' name='frmAddAttendance'>
	<input name='schedule_id'>
	<input name='student_id'>
	<input name='attendance_time'>
	<input name='tuitionclass_id' value="$o->tuitionclass_id">
	<input name='action' value='addtime'>
	<input name='submit' type='submit'>
</form>
</div>
<div id='divRemoveAttendance'>
<form action='attendance.php'  method='POST' name='frmRemoveAttendance'>
	<input name='attendance_id'>
	<input name='tuitionclass_id' value="$o->tuitionclass_id">
	<input name='action' value='deletetime'>
	<input type='submit' name='submit'>
</form>
</div>
EOF;

$student_id=$_POST['student_id'];
$schedule_id=$_POST['schedule_id'];
$attendance_time=$_POST['attendance_time'];
$attendance_id=$_POST['attendance_id'];
$o->token=$s->createToken($tokenlife,"CREATE_REGC");
$log->showLog(3,"Time1:".$o->time1);

switch ($action){
case "addtime":

if($o->addAttendance($schedule_id,$student_id,$attendance_time,$userid)){
$o->getInputForm($o->tuitionclass_id, $o->period_id);
$o->fetchTuitionClassDetail($o->tuitionclass_id, $o->period_id);
$o->studentctrl=$st->getStudentSelectBox(0);
$o->showStudentClassTable($o->tuitionclass_id, $o->period_id);
}
break;
case "deletetime":
if($o->deleteAttendance($attendance_id)){
$o->getInputForm($o->tuitionclass_id, $o->period_id);
$o->fetchTuitionClassDetail($o->tuitionclass_id, $o->period_id);
$o->studentctrl=$st->getStudentSelectBox(0);
$o->showStudentClassTable($o->tuitionclass_id, $o->period_id);
}
break;

default:
$log->showLog(3,"Period: $o->period_id, Tuitionclass: $o->tuitionclass_id");
//$o->periodctrl=$period->getPeriodList($o->period_id);
$o->getInputForm($o->tuitionclass_id, $o->period_id);
$o->fetchTuitionClassDetail($o->tuitionclass_id, $o->period_id);
$o->studentctrl=$st->getStudentSelectBox(0);
$o->showStudentClassTable($o->tuitionclass_id, $o->period_id);

break;
}
require(XOOPS_ROOT_PATH.'/footer.php');
?>

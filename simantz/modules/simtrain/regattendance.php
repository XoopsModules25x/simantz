<?php
include_once "system.php";
include_once "menu.php";
include_once "class/Log.php";
include_once "class/Employee.php";
include_once "class/Student.php";
include_once "class/RegAttendance.php";
include_once "datepicker/class.datepicker.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

$log = new Log();
$e = new Employee($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$st = new Student($xoopsDB,$tableprefix,$log);
$o= new RegAttendance($xoopsDB, $tableprefix,$log);
$o->showcalendar=$dp->show("attendance_date");

if (isset($_POST['action'])){
	$action=$_POST['action'];
$o->regattendance_id=$_POST['regattendance_id'];
}
if (isset($_GET['action'])){
	$action=$_GET['action'];

$o->regattendance_id=$_GET['regattendance_id'];
}

if($_POST['organization_id']!="")
	$o->organization_id=$_POST['organization_id'];
elseif($_GET['organization_id']!="")
	$o->organization_id=$_GET['organization_id'];
else
$o->organization_id=0;

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->attendance_date=$_POST['attendance_date'];

$o->day_no=$_POST['day_no'];
$o->attendance_time=$_POST['attendance_time'];
$o->student_id=$_POST['student_id'];
$o->student_code=$_POST['student_code'];
$o->studentclass_id=$_POST['studentclass_id'];

echo <<< EOF

<script language="Javascript">


function autofocus () {
  document.regattendance.student_code.focus();
}
</script>

EOF;

switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create attendance record event");
	$test=$o->prepareData($o->student_code,$o->student_id,$o->attendance_date,
			$o->attendance_time,$o->organization_id);

	if($test==1){
		
		if($o->insertAttendance())
			redirect_header("regattendance.php",$pausetime,"Data is saved, this record added into class <b>$o->description ($o->tuitionclass_code)</b> at <b>$o->starttime</b>. Back to attendance main page now.");
		else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
			$o->orgctrl=$permission->selectionOrg($o->created,$organization_id);
			$o->studentctrl=$st->getStudentSelectBox($o->student_id);
			$o->getInputForm();
			$o->showAttendanceTable("","ORDER BY att.regattendance_id desc");
		}
	}
	elseif($test==0 or $test==""){
			redirect_header("regattendance.php?organization_id=$o->organization_id",3,"$errorstart No student or suitable class for this time, record won't save.$errorend");

		
	}
	else
		$o->showConflicForm($student_code,$student_id,$attendance_date,$attendance_time,$organization_id);
break;
case "choose":
	if($o->insertAttendance())
			redirect_header("regattendance.php",$pausetime,"Data is saved, this record added into class <b>$o->description ($o->tuitionclass_code)</b> at <b>$o->starttime</b>. Back to attendance main page now.");
break;
  case "delete" :
		if($o->deleteAttendance($o->regattendance_id))
			redirect_header("regattendance.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("regattendance.php",$pausetime,"$errorstart Warning! Can't delete data from database.$errorend");
  break;
 case "empty" :
		if($o->emptyAttendance())
			redirect_header("regattendance.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("regattendance.php",$pausetime,"$errorstart Warning! Can't delete data from database.$errorend");
  break;
  default :
	if($o->attendance_date=="")
		$o->attendance_date=date("Y-m-d", time()) ;
	$o->orgctrl=$permission->selectionOrg($o->createdby,$defaultorganization_id);
	$o->studentctrl=$st->getStudentSelectBox(0);
	$o->getInputForm();
	$o->showAttendanceTable("","ORDER BY att.regattendance_id desc");
	//$o->showCategoryTable();
  break;

}


echo "</td>";
include "../../footer.php";
?>

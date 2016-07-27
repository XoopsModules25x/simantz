<?php
include_once "system.php" ;
include_once ("menu.php");
include_once './class/Employee.php';
include_once 'class/TuitionClass.php';
include_once './class/Address.php';
include_once './class/Log.php';
include_once './class/Schedule.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


echo <<< EOF
<script type="text/javascript">

	function validateAddress(){
	
	
		if (confirm("Confirm to save record?")){
			return true;
		}
		else
			return false;
}
</script>
EOF;


$log = new Log();
$ad= new Address($xoopsDB,$tableprefix,$log);
$o= new Schedule($xoopsDB,$tableprefix,$log);
$t=new TuitionClass($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log,$ad);
$s = new XoopsSecurity();



$action="";
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->tuitionclass_id=$_POST["tuitionclass_id"];
	$o->schedule_id=$_POST["schedule_id"];

$o->employee_id=$_POST["employee_id"];
}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->tuitionclass_id=$_GET["tuitionclass_id"];
	$o->schedule_id=$_GET["schedule_id"];

$o->employee_id=$_GET["employee_id"];
}
else
$action="";

$token=$_POST['token'];
//$o->no=$_POST["no"];
$o->class_datetime=$_POST["class_datetime"];
$o->lineclass_datetime=$_POST["lineclass_datetime"];
$o->lineemployee_id=$_POST["lineemployee_id"];
$o->lineschedule_id=$_POST["lineschedule_id"];
$o->updatedby=$xoopsUser->getVar('uid');
//$o->tuitionclass_id=$_POST["tuitionclass_id"];



 switch ($action){
	//when user request to edit particular address
  case "edit" :
	$token=$s->createToken($tokenlife,"CREATE_SCD");
	if($o->tuitionclass_id>0)
		{
		$t->showClassHeader($o->tuitionclass_id);
		$o->showInputForm($o->tuitionclass_id,$token,$e);
	}
	else	//if can't find particular address from database, return error message
		redirect_header("tuitionclass.php?action=edit&tuitionclass_id=$o->tuitionclass_id",$pausetime,"Some error on viewing your address service data, probably database corrupted");
  
break;
//when user press save for change existing address data
  case "update" :

	if ($s->check(false,$token,"CREATE_SCD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateSchedule()) //if data save successfully
			redirect_header("schedule.php?action=edit&tuitionclass_id=$o->tuitionclass_id",$pausetime,"Update: Your data is saved.");
		else
			redirect_header("schedule.php?action=edit&tuitionclass_id=$o->tuitionclass_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("schedule.php?action=edit&tuitionclass_id=$o->tuitionclass_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  
  default :
	$token=$s->createToken($tokenlife,"CREATE_SCD");
	if($o->tuitionclass_id>0)
		{
		$t->showClassHeader($o->tuitionclass_id);
		$o->showInputForm($o->tuitionclass_id);
	}
	else	//if can't find particular address from database, return error message
		redirect_header("tuitionclass.php?action=edit&tuitionclass_id=$o->tuitionclass_id",$pausetime,"Some error on viewing your address service data, probably database corrupted");
  break;

}
require(XOOPS_ROOT_PATH.'/footer.php');
?>

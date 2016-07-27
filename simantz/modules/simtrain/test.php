<?php

include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Test.php';
include_once 'class/TuitionClass.php';
include_once 'class/Employee.php';
include_once "menu.php";
include_once "class/Student.php";
include_once ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

$log = new Log();
$o = new Test($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);
$t = new TuitionClass($xoopsDB,$tableprefix,$log);
$st=new Student($xoopsDB,$tableprefix,$log);
$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmTest'].test_name.focus();
	}

	function validateTest(){
		var name=document.forms['frmTest'].test_name.value;
		if(confirm('Save Record?')){
		if(name =="" ){
			alert("Please make sure 'Test Name' is filled in.");
			return false;
		}
		else
			return true;
		}
		else{
			document.forms['frmTest'].deleteline.value=0;
			return false;
		}
	}

	function changeDeleteID(id){
		document.forms['frmTest'].deleteline.value=id;
		document.forms['frmTest'].submit.click();

	}
</script>

EOF;

$o->test_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->test_id=$_POST["test_id"];
	$o->tuitionclass_id=$_POST["tuitionclass_id"];
	$o->employee_id=$_POST["employee_id"];
}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->test_id=$_GET["test_id"];
	$o->tuitionclass_id=$_GET["tuitionclass_id"];
	$o->employee_id=$_GET["employee_id"];
}
else
$action="";
$deleteline=$_POST['deleteline'];
$o->showDate=$dp->show("testdate");
$o->linetestline_id=$_POST['linetestline_id'];
$o->lineresult=$_POST['lineresult'];
$o->linedescription=$_POST['linedescription'];
$o->student_id=$_POST['student_id'];
$token=$_POST['token'];
$o->test_description=$_POST["test_description"];
$o->test_name=$_POST["test_name"];
$o->testdate=$_POST['testdate'];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	


$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');




 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with test name=$o->test_name");

	if ($s->check(false,$token,"CREATE_TST")){
		
		
		
	if($o->insertTest()){
		 $o->test_id=$o->getLatestTestID();
		  if($o->generateTestLine())
			 redirect_header("test.php?action=edit&test_id=$o->test_id",$pausetime,
				"Your data is saved, the new id=$o->test_id");
		   else
			 redirect_header("test.php?action=edit&test_id=$o->test_id",$pausetime,
				"Your data is saved, however there is some error on generating student list. Redirect 
					to this test (ID=$o->test_id)");
		}
	else {
				echo "Can't create test!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_TST");
		$o->getInputForm("new",-1,$token);
		$o->showTestTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchTest($o->test_id)){
		//create a new token for editing a form
		$o->showHeader($o->test_id);
		$o->employeectrl=$e->getEmployeeList($o->employee_id);
		$token=$s->createToken($tokenlife,"CREATE_TST"); 
		$o->classctrl="<input type='hidden' name='tuitionclass_id' value='$o->tuitionclass_id'>Refer Header";
		$o->getInputForm("edit",$o->test_id,$token);
		$o->studentctrl=$st->getStudentSelectBox(1,'N');
		$o->showAddTestLine($token);

	//	$o->showTestTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("test.php",3,"Some error on viewing your test data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_TST")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->deleteTestLine($deleteline) && $o->updateTestLine($deleteline) &&  $o->updateTest()) //if data save successfully
			redirect_header("test.php?action=edit&test_id=$o->test_id",$pausetime,"Your data is saved.");
		else
			redirect_header("test.php?action=edit&test_id=$o->test_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("test.php?action=edit&test_id=$o->test_id",$pausetime,"Warning! Can't save the data due to token expired or error.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_TST")){
		if($o->deleteTest($o->test_id))
			redirect_header("tuitionclass.php?action=edit&tuitionclass_id=$o->tuitionclass_id",$pausetime,"Data removed successfully, redirect to tuitionclass.");
		else
			redirect_header("test.php?action=edit&test_id=$o->test_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("test.php?action=edit&test_id=$o->test_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "addline" :
	if ($s->check(false,$token,"CREATE_TST")){
		if($o->addTestLine())
				redirect_header("test.php?action=edit&test_id=$o->test_id",$pausetime,"Add line successfully.");
		else
			redirect_header("test.php?action=edit&test_id=$o->test_id",$pausetime,"Warning! Can't add student into this test.");
	}
	else
		redirect_header("test.php?action=edit&test_id=$o->test_id",$pausetime,"Warning! Can't add data into database due to token expired or error.");
	
  break;
default:
	$o->employeectrl=$e->getEmployeeList($o->employee_id);
	$o->classctrl=$t->getSelectTuitionClass($o->tuitionclass_id,'Y');
	$token=$s->createToken($tokenlife,"CREATE_TST");
	$o->orgctrl=$permission->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);

  break;


}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

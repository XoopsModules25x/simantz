<?php
include_once "system.php";
include_once "menu.php";
include_once "class/RegClass.php";
include_once "class/Log.php";
include_once "class/Employee.php";
include_once "class/Student.php";
include_once "class/TuitionClass.php";
include_once "class/Area.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();

$t = new Student($xoopsDB,$tableprefix,$log);
$c = new TuitionClass($xoopsDB,$tableprefix,$log);
$o = new RegClass($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);
$a = new Area($xoopsDB,$tableprefix,$log);

$action="";

echo <<< EOF
<script type="text/javascript">
	function validateClass(){
		var starttime=document.forms['frmRegClass'].starttime.value;
		var endtime=document.forms['frmRegClass'].endtime.value;
		
		if(name =="" || code==""){
			alert('Please make sure Product no and name is filled in.');
			return false;
		}
		else
			return true;
	}
</script>
EOF;


if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->studentclass_id=$_POST["studentclass_id"];
	$o->student_id=$_POST["student_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->studentclass_id=$_GET["studentclass_id"];
	$o->student_id=$_GET["student_id"];
}
else
$action="";

//search information
$o->student_code=$_POST['student_code'];
$o->student_name=$_POST['student_name'];
$o->ic_no=$_POST['ic_no'];

$o->tuitionclass_id=$_POST['tuitionclass_id'];
$o->backareafrom_id=$_POST['backareafrom_id'];
$o->backareato_id=$_POST['backareato_id'];
$o->comeareafrom_id=$_POST['comeareafrom_id'];
$o->comeareato_id=$_POST['comeareato_id'];
$o->transactiondate=$_POST['transactiondate'];
$o->trainingfees=$_POST['trainingfees'];
$o->transportfees=$_POST['transportfees'];
$o->transportationmethod=$_POST['transportationmethod'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

$token=$_POST['token'];

$o->organization_id=$_POST['organization_id'];

$isactive=$_POST['isactive'];


$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';



echo '<td>';

switch ($action){
 case "create":
	if ($s->check(false,$token,"CREATE_REGC")){
		$log->showlog(3,"Saving data for Student_id=$o->student_id, and class_id=$o->tuitionclass_id");
		if($o->insertRegClass()){
		 $latest_id=$o->getLatestStudentClassID();
		 redirect_header("regclass.php?action=choosed&student_id=$o->student_id",$pausetime,"Your data is saved.");
		}
		else
		redirect_header("regclass.php?action=choose&student_id=$o->student_id",$pausetime,"You data cannot be save, return to previous page");
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showlog(3,"Choose Student_id=$o->student_id for class registration");
		if($t->fetchStudentInfo($o->student_id)){
			$o->student_code=$t->student_code;
			$o->student_name=$t->student_name;
			$o->ic_no=$t->ic_no;
			$o->areacf_ctrl=$a->getAreaList($o->comeareafrom_id,'comeareafrom_id');
			$o->areact_ctrl=$a->getAreaList($o->comeareato_id,'comeareato_id');
			$o->areabf_ctrl=$a->getAreaList($o->backareafrom_id,'backareafrom_id');
			$o->areabt_ctrl=$a->getAreaList($o->backareato_id,'backareato_id');
			$o->showRegistrationHeader();
			$o->showRegisteredTable('student',"WHERE t.student_id=$o->student_id",'ORDER BY c.tuitionclass_code');
			$o->studentctrl=$t->getStudentSelectBox(-1);
			$token=$s->createToken(120,"CREATE_REGC");
			$o->showInputForm('new',-1,$token);
		}
		else
			$log->showlog(1,"Error: can't retrieve student information: $o->student_id");
	}
 break;
 case "choosed":
	
	$log->showlog(3,"Choose Student_id=$o->student_id for class registration");
	if($t->fetchStudentInfo($o->student_id)){
		
		$o->student_code=$t->student_code;
		$o->student_name=$t->student_name;
		$o->ic_no=$t->ic_no;
		$o->orgctrl=$permission->selectionOrg($o->createdby,0);
		$o->areacf_ctrl=$a->getAreaList(0,'comeareafrom_id');
		$o->areact_ctrl=$a->getAreaList(0,'comeareato_id');
		$o->areabf_ctrl=$a->getAreaList(0,'backareafrom_id');
		$o->areabt_ctrl=$a->getAreaList(0,'backareato_id');
		$o->showRegistrationHeader();
		$o->studentctrl=$t->getStudentSelectBox(-1);
		$o->showRegisteredTable('student',"WHERE sc.student_id=$o->student_id",'ORDER BY c.tuitionclass_code','regclass');
		$token=$s->createToken(120,"CREATE_REGC");
		$o->showInputForm('new',0,$token);
	}
	else
		$log->showlog(1,"Error: can't retrieve student information: $o->student_id");
 break;
 case "update":
	$log->showlog(3,"Saving data for Student_id=$o->student_id, and class_id=$o->studentclass_id");
	if ($s->check(false,$token,"CREATE_REGC")){
		if($o->updateStudentClass()) //if data save successfully
			redirect_header("regclass.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"Your data is saved.");
		else
			redirect_header("regclass.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("regclass.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"Warning! Can't save the data, due to form's token expired, please re-enter the data.");
	}
 break;
 case "search":
	$log->showlog(3,"Search Student_id=$o->student_id,student_code=$o->student_code,student_name=$o->student_name,ic_no=$o->ic_no");
	$wherestring= cvSearchString($o->student_id,$o->student_code,$o->student_name,$o->ic_no);
	if($o->student_id==0){
		if ($wherestring!="")
			$wherestring="WHERE " . $wherestring;
			$t->showStudentTable($wherestring," ORDER BY student_name",0,'regclass');
	}
	else
		redirect_header("regclass.php?action=choosed&student_id=$o->student_id",$pausetime,"Opening Student for registration.");
 break;
 case "delete":
	if ($s->check(false,$token,"CREATE_REGC")){
		if($o->deleteStudentClass($o->studentclass_id))
			redirect_header("regclass.php?action=choosed&student_id=$o->student_id",$pausetime,"Data removed successfully.");
		else
			redirect_header("regclass.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("regclass.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"Warning! Can't delete data from database due to token expired, please re-delete the data.");
 break;
 case "edit":
	$log->showlog(3,"Editing data studentclass_id:$o->studentclass_id");
	if ($o->fetchRegClassInfo($o->studentclass_id)){
		if($t->fetchStudentInfo($o->student_id)){
			$o->student_code=$t->student_code;
			$o->student_name=$t->student_name;
			$o->ic_no=$t->ic_no;
		}
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->areacf_ctrl=$a->getAreaList($o->comeareafrom_id,'comeareafrom_id');
		$o->areact_ctrl=$a->getAreaList($o->comeareato_id,'comeareato_id');
		$o->areabf_ctrl=$a->getAreaList($o->backareafrom_id,'backareafrom_id');
		$o->areabt_ctrl=$a->getAreaList($o->backareato_id,'backareato_id');
		$o->showRegistrationHeader();
//		$o->showRegisteredTable('student',"WHERE t.student_id=$o->student_id",'ORDER BY c.tuitionclass_code');
	$o->studentctrl=$t->getStudentSelectBox(-1);

		$token=$s->createToken(120,"CREATE_REGC");
		$o->showInputForm('edit',$o->studentclass_id,$token);

	}
 break;
 default:
	
	$o->studentctrl=$t->getStudentSelectBox(-1);
	$o->showSearchForm();
 break;


}


echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

//convert 4 criterial into 1 search string
function cvSearchString($student_id,$student_code,$student_name,$ic_no){
$filterstring="";
$needand="";
if($student_id > 0 ){
	$filterstring=$filterstring . " student_id=$student_id";
	$needand='AND';
}
else
	$needand='';

if($student_code!=""){
	$filterstring=$filterstring . " $needand student_code LIKE '$student_code' ";
	$needand='AND';
}
else
$needand='';

if ($student_name!=""){
$filterstring=$filterstring . " $needand student_name LIKE '$student_name'";
	$needand='AND';
}
else
	$needand='';

if($ic_no!="")
$filterstring=$filterstring . "  $needand ic_no LIKE '$ic_no'";
	
return $filterstring;
}

?>

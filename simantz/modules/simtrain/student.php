<?php
include_once "system.php" ;
include_once "menu.php";
include_once './class/Student.php';
//include_once './class/Employee.php';
include_once './class/Standard.php';
include_once './class/Parents.php';
include_once './class/Races.php';
include_once './class/Religion.php';
include_once './class/School.php';
include_once './class/Log.php';
include_once './class/Address.php';
include_once ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

//marhan add here --> ajax
echo "<iframe src='student.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
/////////////////////

echo <<< EOF

<script type="text/javascript">

	function nextSave(){
	document.forms['frmStudent'].submit();
	}

	function checkName() {//example of ajax
		student_name = document.forms['frmStudent'].student_name.value;
	
		var arr_fld=new Array("action","student_name");//name for POST
		var arr_val=new Array("checkname",student_name);//value for POST
		
		getRequest(arr_fld,arr_val);
		
	}

		function autofocus(){
	
		document.forms['frmStudent'].student_name.focus();
	}

	function validateStudent(){
		var studentcode=document.frmStudent.student_code.value;
		var ic_no=document.frmStudent.ic_no.value;
		var student_name=document.frmStudent.student_name.value;
		var dateofbirth=document.frmStudent.dateofbirth.value;

		if (confirm("Confirm to save record?")){
			if (studentcode!="" && ic_no!="" && student_name!="" && isDate(dateofbirth) ){
				
				if(document.forms['frmStudent'].action.value == "create"){
				//alert(document.forms['frmStudent'].action.value);
				checkName();
				return false;
				}else{
				return true;
				}
			}
			else{
				alert ("Please make sure student code, IC Number, Student Name, format of 'Date Of Birth' is correct.")
				return false;
			}
		}
		else
			return false;
}

	function validateStudent2(){
		var studentcode=document.frmStudent.student_code.value;
		var ic_no=document.frmStudent.ic_no.value;
		var student_name=document.frmStudent.student_name.value;
		var dateofbirth=document.frmStudent.dateofbirth.value;

		if (confirm("Confirm to save record?")){
			if (studentcode!="" && ic_no!="" && student_name!="" && isDate(dateofbirth) ){
				return true;
			}
			else{
				alert ("Please make sure student code, IC Number, Student Name, format of 'Date Of Birth' is correct.")
				return false;
			}
		}
		else
			return false;
}

function zoomParents(){
		var id = document.forms['frmStudent'].parents_id.value;
		if(id==0)
		window.open("parents.php");
		else
		window.open("parents.php?action=edit&parents_id="+id);
	}
</script>
EOF;


$log = new Log();
$o= new Student($xoopsDB,$tableprefix,$log);
$std= new Standard($xoopsDB,$tableprefix,$log);
$r= new Races($xoopsDB,$tableprefix,$log);
$re= new Religion($xoopsDB,$tableprefix,$log);
$sch= new School($xoopsDB,$tableprefix,$log);
$p= new Parents($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity();
//$e = new Employee($xoopsDB,$tableprefix,$log,$ad);


$action="";
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->student_id=$_POST["student_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->student_id=$_GET["student_id"];

}
else
$action="";

$token=$_POST['token'];
$o->student_name=$_POST["student_name"];
$o->alternate_name=$_POST['alternate_name'];
$o->student_code=$_POST["student_code"];
$o->organization_id=$_POST["organization_id"];
$o->dateofbirth=$_POST["dateofbirth"];
$o->gender=$_POST["gender"];
$o->ic_no=$_POST["ic_no"];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$o->school_id=$_POST["school_id"];
$o->standard_id=$_POST['standard_id'];
$o->levela=$_POST['levela'];
$o->levelb=$_POST['levelb'];
$o->levelc=$_POST['levelc'];
$o->description=$_POST['description'];
$o->email=$_POST['email'];
$o->web=$_POST['web'];
$o->hp_no=$_POST["hp_no"];
$o->tel_1=$_POST["tel_1"];
$o->tel_2=$_POST["tel_2"];
$o->joindate=$_POST["joindate"];
$o->showcalendar=$dp->show("dateofbirth");
$o->showjoindatectrl=$dp->show("joindate");
$o->parents_id=$_POST["parents_id"];
$o->religion_id=$_POST['religion_id'];
$o->races_id=$_POST['races_id'];
$o->isAdmin=$xoopsUser->isAdmin();
$filterstring=$_GET['filterstring'];
$isactive=$_POST['isactive'];
if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';

$phototmpfile= $_FILES["studentphoto"]["tmp_name"];
$photofilesize=$_FILES["studentphoto"]["size"] / 1024;
$photofiletype=$_FILES["studentphoto"]["type"];
$o->removepic=$_POST['removepic'];

$sqlstudentcount="SELECT count(student_id) as studentqty from $tableprefix"."simtrain_student where isactive='Y'";
$querystudentcount=$xoopsDB->query($sqlstudentcount);
$studentcount=0;
if($row=$xoopsDB->fetchArray($querystudentcount))
$studentcount=$row['studentqty'];
echo <<< EOF
<b>* $studentcount active students</b><br>
EOF;
if($filterstring=="")
$filterstring=$o->searchAToZ();
else
$o->searchAToZ();
 switch ($action) {
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	if ($s->check(false,$token,"CREATE_STU")){
		$o->createdby=$xoopsUser->getVar('uid');
		$o->updatedby=$xoopsUser->getVar('uid');
		//create new address for organization
		
		//if organization saved
		if($o->insertStudent()){
		 $latest_id=$o->getLatestStudentID();
		 redirect_header("student.php?action=edit&student_id=$latest_id",$pausetime,"Your data is saved.");
		}
		else {
			$token=$s->createToken($tokenlife,"CREATE_STU");
			$o->orgctrl=$permission->selectionOrg($xoopsUser->getVar('uid'),$o->organization_id);
			$o->racesctrl=$r->getSelectRaces($o->races_id,'Y');
			$o->schoolctrl=$sch->getSelectSchool($o->school_id,'Y');
			$o->standardctrl=$std->getSelectStandard($o->standard_id,'Y');
			$log->showLog(1, "<b style='color:red'>Data can't save, please verified your IC and Student Number is unique</b>");
			$o->getInputForm("edit",0,$token);
			$o->searchAToZ();
			if ($filterstring=="")
				$filterstring="A";
			$o->showStudentTable(" WHERE s.student_name LIKE '$filterstring%' and s.organzation_id = $defaultorganization_id ");

		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1, "<b style='color:red'>Data can't save due to token expired.</b>");
		$token=$s->createToken($tokenlife,"CREATE_STU");
		$o->orgctrl=$permission->selectionOrg($xoopsUser->getVar('uid'),$o->orgaization_id);
		$o->racesctrl=$r->getSelectRaces($o->races_id,'Y');
		$o->religionctrl=$re->getSelectReligion($o->religion_id,'Y');
		$o->schoolctrl=$sch->getSelectSchool($o->school_id,'Y');
		$o->standardctrl=$std->getSelectStandard($o->standard_id,'Y');
		$o->getInputForm("new",-1,$token);
		$o->showStudentTable(" WHERE s.student_name LIKE '$filterstring%' and s.organzation_id = $defaultorganization_id "); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchStudentInfo($o->student_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_STU"); 
		$o->orgctrl=$permission->selectionOrg($xoopsUser->getVar('uid'),$o->organization_id);
			$o->racesctrl=$r->getSelectRaces($o->races_id,'Y');
			$o->religionctrl=$re->getSelectReligion($o->religion_id,'Y');
			$o->schoolctrl=$sch->getSelectSchool($o->school_id,'Y');
			$o->standardctrl=$std->getSelectStandard($o->standard_id,'Y');
		$o->parentsctrl=$p->getSelectParents($o->parents_id,'Y');
		$o->getInputForm("edit",$o->student_id,$token);

	//	if ($filterstring=="")
	//		$filterstring="A";
	//	$o->showStudentTable(" WHERE s.student_name LIKE '$filterstring%' and s.isactive='Y'");

	}
	else	//if can't find particular organization from database, return error message
		redirect_header("student.php",3,"<b style='color:red'>Some error on viewing your student data, probably database corrupted.</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_STU")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateStudent()){ //if data save successfully

			if($o->removepic=='on')
				$o->deletephoto($o->student_id);


			if($photofilesize>0 && $photofilesize<100 && $photofiletype=='image/jpeg'){
				$o->deletephoto($o->student_id);
				$o->savephoto($phototmpfile);
			}elseif($photofilesize>0)
				$uploaderror="<b style='color: red'> but fail to upload photo file, please make sure you upload jpg file and file size smaller than 100kb</b>";
		
		redirect_header("student.php?action=edit&student_id=$o->student_id",$pausetime,"Your data is saved$uploaderror.");

		}
		else
			redirect_header("student.php?action=edit&student_id=$o->student_id",$pausetime,"<b style='color:red'>Warning! Can't save the data, please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("student.php?action=edit&student_id=$o->student_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->student_name' due to token expired.</b>");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_STU")){
		if($o->delStudent($o->student_id)){
			$o->deletephoto($o->student_id);
			redirect_header("student.php",$pausetime,"Data removed successfully.");
		}
		else
			redirect_header("student.php?action=edit&student_id=$o->student_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to data dependency error.</b>");
	}
	else
		redirect_header("student.php?action=edit&student_id=$o->student_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to token expired</b>");
	
  break;
//  case "showall" :
//	$o->showAllStudentTable();
 // break;
  case "search" :
	$o->orgctrl=$permission->selectionOrg($xoopsUser->getVar('uid'),$defaultorganization_id);
		$o->religionctrl=$re->getSelectReligion(0,'Y');
		$o->racesctrl=$r->getSelectRaces(0,'Y');
		$o->schoolctrl=$sch->getSelectSchool(0,'Y');
		$o->standardctrl=$std->getSelectStandard(0,'Y');
		$o->studentctrl=$o->getStudentSelectBox(0,'Y');
		$o->parentsctrl=$p->getSelectParents(0,'Y');
		$o->showSearchForm();
  break;
  case "searchstudent" :
	if($_POST['isactive']=="Y")
		$o->isactive='Y';
	elseif($_POST['isactive']=="N")
		$o->isactive='N';
	else
		$o->isactive='-';
	$o->parentsctrl=$p->getSelectParents(0);

	$wherestr=generateWhereStr( $o->races_id,$o->school_id,$o->standard_id,$o->student_id,$o->dateofbirth,$o->isactive,
				$o->gender,$o->ic_no,$o->student_code,$o->student_name,$o->parents_id,
				$o->alternate_name,$o->levela,$o->levelb,$o->levelc,$o->religion_id,$o->joindate,$o->organization_id);
	$o->racesctrl=$r->getSelectRaces($o->races_id,'Y');
	$o->schoolctrl=$sch->getSelectSchool($o->school_id,'Y');
	$o->standardctrl=$std->getSelectStandard($o->standard_id,'Y');
	$o->parentsctrl=$p->getSelectParents($o->parents_id,'Y');
	$o->religionctrl=$re->getSelectReligion($o->religion_id,'Y');
	$o->studentctrl=$o->getStudentSelectBox($o->student_id,'Y');
	$o->orgctrl=$permission->selectionOrg($xoopsUser->getVar('uid'),$o->organization_id);
	$o->showSearchForm();
	$o->showStudentTable($wherestr);

  break;


  case "checkname" :
	$isexistname = $o->checkName($_POST['student_name']);
	
	if($isexistname[0] > 0){
	
	$student_name = $isexistname[1];
	$student_id = $isexistname[0];
	$student_code = $isexistname[2];
	
	$existing_student = 
	"<b><font color=red>Same Student Name !! : <a href=student.php?action=edit&student_id=$student_id target=blank> $student_name ($student_code)</a> ".
	"To Ignore Press This Button <input value=Submit type=button onclick=nextSave()></font></b>";
	echo "<script type='text/javascript'>self.parent.document.getElementById('sameNameId').innerHTML = '$existing_student';</script>";
	}else{
	echo "<script type='text/javascript'>self.parent.document.getElementById('sameNameId').innerHTML = '';</script>";
	echo "<script type='text/javascript'>self.parent.document.forms['frmStudent'].submit();</script>";
	}
  break;

  default :
	$token=$s->createToken($tokenlife,"CREATE_STU");
	$o->orgctrl=$permission->selectionOrg($xoopsUser->getVar('uid'),$defaultorganization_id);
			$o->racesctrl=$r->getSelectRaces(0,'Y');
			$o->schoolctrl=$sch->getSelectSchool(0,'Y');
			$o->religionctrl=$re->getSelectReligion(0,'Y');

			$o->standardctrl=$std->getSelectStandard(0,'Y');
	$o->parentsctrl=$p->getSelectParents(0,'Y');
	$o->getInputForm("new",0,$token);
	if ($filterstring=="")
		$filterstring="A";
	$o->showStudentTable(" WHERE s.student_name LIKE '$filterstring%' AND s.isactive='Y' and s.student_id>0 and s.organization_id = $defaultorganization_id ");
  break;

}

function generateWhereStr($races_id,$school_id,$standard_id,$student_id,$dateofbirth,$isactive,$gender,$ic_no,
			$student_code,$student_name,$parents_id,$alternate_name,$levela,$levelb,$levelc,$religion_id,
			$joindate,$organization_id){
$filterstring="";
$needand="";
if($races_id > 0 ){
	$filterstring=$filterstring . " s.races_id=$races_id AND";
}

if($religion_id > 0 ){
	$filterstring=$filterstring . " s.religion_id=$religion_id AND";
}

if($school_id>0){
	$filterstring=$filterstring . " s.school_id=$school_id AND";
}

if($standard_id>0){
	$filterstring=$filterstring . " s.standard_id=$standard_id AND";
}

if($student_id>0){
	$filterstring=$filterstring . " s.student_id=$student_id AND";
}

if ($isactive!="-"){
$filterstring=$filterstring . " s.isactive = '$isactive' AND";
}

if ($gender!="-"){
$filterstring=$filterstring . " s.gender = '$gender' AND";
}

if($ic_no!=""){
$filterstring=$filterstring . "  s.ic_no LIKE '$ic_no' AND";
}


if ($student_code!=""){
$filterstring=$filterstring . " s.student_code LIKE '$student_code' AND";
}


if ($dateofbirth!=""){
$filterstring=$filterstring . " s.dateofbirth LIKE '$dateofbirth' AND";
}
if ($joindate!=""){
$filterstring=$filterstring . " s.joindate LIKE '$joindate' AND";
}

if ($student_name!="")
$filterstring=$filterstring . " s.student_name LIKE '$student_name' AND";

if ($alternate_name!="")
$filterstring=$filterstring . " s.alternate_name LIKE '$alternate_name' AND";

if ($parents_id!=0)
$filterstring=$filterstring . " p.parents_id = '$parents_id' AND";


if ($levela!="")
$filterstring=$filterstring . " s.levela LIKE '$levela' AND";

if ($levelb!="")
$filterstring=$filterstring . " s.levelb LIKE '$levelb' AND";

if ($levelc!="")
$filterstring=$filterstring . " s.levelc LIKE '$levelc' AND";

if ($filterstring=="")
	return "WHERE s.student_id>0 and s.organization_id=$organization_id";
else {
	$filterstring =substr_replace($filterstring,"",-3);  

	return "WHERE s.student_id>0 AND s.organization_id=$organization_id AND $filterstring ";
	}
}

require(XOOPS_ROOT_PATH.'/footer.php');
?>

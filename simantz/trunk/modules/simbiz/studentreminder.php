<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once 'class/StudentReminder.php';
//include_once 'class/SelectCtrl.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';


//$log = new Log();
$o = new StudentReminder();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";

$o->stylewidthstudent = "style='width:200px'";

//marhan add here --> ajax
echo "<iframe src='studentreminder.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

$action="";

echo <<< EOF
<script type="text/javascript">
function autofocus(){
document.forms['frmStudentReminder'].studentreminder_id.focus();
}
function IsNumeric(sText)
{
   var ValidChars = "0123456789.-";
   var IsNumber=true;
   var Char;


   for (i = 0; i < sText.length && IsNumber == true; i++)
      {
      Char = sText.charAt(i);
      if (ValidChars.indexOf(Char) == -1)
         {
         IsNumber = false;
         }
      }
   return IsNumber;

   }


	function validateStudentReminder(){

		var student_id=document.forms['frmStudentReminder'].student_id.value;
		var semester_id=document.forms['frmStudentReminder'].semester_id.value;
		var reminder_id=document.forms['frmStudentReminder'].reminder_id.value;
		var reminder_date=document.forms['frmStudentReminder'].reminder_date.value;


		if(confirm("Save record?")){
		if(student_id == 0 || semester_id == 0 || reminder_id == 0){
			alert('Please make sure Student, Semester, Reminder is selected');
			return false;
		}
		else{
                        if(!isDate(reminder_date))
			return false;
                        else
                        return true;
                }

		}
		else
			return false;
	}
</script>

EOF;

$o->studentreminder_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->studentreminder_id=$_POST["studentreminder_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->studentreminder_id=$_GET["studentreminder_id"];

}
else
$action="";

$token=$_POST['token'];


if($_POST){
$o->reminder_id=$_POST["reminder_id"];
$o->student_id=$_POST["student_id"];
$o->semester_id=$_POST['semester_id'];
$o->issearch = $_POST['issearch'];
}else{
$o->student_id = $_GET['student_id'];
$o->semester_id = $_GET['semester_id'];
$o->reminder_id = $_GET['reminder_id'];
$o->issearch = $_GET['issearch'];

}




$o->reminder_date=$_POST['reminder_date'];
$o->organization_id=$_POST['organization_id'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->remarks = $_POST['remarks'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();
$isactive=$_POST['isactive'];

$o->reminderdatectrl=$dp->show("reminder_date");

if ($isactive==1 or $isactive=="on")
	$o->isactive=1;
else
	$o->isactive=0;


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with student reminder id=$o->studentreminder_id");

	if ($s->check(false,$token,"CREATE_ACG")){



	if($o->insertStudentReminder()){
	$latest_id=$o->getLatestStudentReminderID();
         $log->saveLog($latest_id,$tablestudentreminder,"$o->changesql","I","O");
			 redirect_header("studentreminder.php",$pausetime,"Your data is saved. Create More Records");
		}
	else {
        $log->saveLog(0,$tablestudentreminder,"$o->changesql","I","F");
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
                $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
                $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
                $o->reminderctrl= $ctrl->getSelectReminder($o->reminder_id,"Y");
		$o->getInputForm("new",-1,$token);
		$o->showStudentReminderTable("WHERE studentreminder_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,studentreminder_id");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
        $log->saveLog(0,$tablestudentreminder,"$o->changesql","I","F");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
                $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
                $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
                $o->reminderctrl= $ctrl->getSelectReminder($o->reminder_id,"Y");
		$o->getInputForm("new",-1,$token);
		$o->showStudentReminderTable("WHERE studentreminder_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,studentreminder_id");
	}

break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchStudentReminder($o->studentreminder_id)){

            if($o->semester_id=="")
                $o->semester_id=0;
            if($o->student_id=="")
                $o->student_id=0;
            if($o->reminder_id=="")
                $o->reminder_id=0;
                
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
                $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
                $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
                $o->reminderctrl= $ctrl->getSelectReminder($o->reminder_id,"Y");
		$o->getInputForm("edit",$o->studentreminder,$token);
		//$o->showStudentReminderTable("WHERE studentreminder_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,studentreminder_id");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("studentreminder.php",3,"Some error on viewing your reminder data, probably database corrupted");

break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateStudentReminder()){ //if data save successfully
                        $log->saveLog($o->studentreminder_id,$tablestudentreminder,"$o->changesql","U","O");
			redirect_header("studentreminder.php?action=edit&studentreminder_id=$o->studentreminder_id",$pausetime,"Your data is saved.");
        }else{
             $log->saveLog($o->studentreminder_id,$tablestudentreminder,"$o->changesql","U","F");
			redirect_header("studentreminder.php?action=edit&studentreminder_id=$o->studentreminder_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
         $log->saveLog($o->studentreminder_id,$tablestudentreminder,"$o->changesql","U","F");
		redirect_header("studentreminder.php?action=edit&studentreminder_id=$o->studentreminder_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteStudentReminder($o->studentreminder_id)){
            $log->saveLog($o->studentreminder_id,$tablestudentreminder,"$o->changesql","D","O");
			redirect_header("studentreminder.php",$pausetime,"Data removed successfully.");
        }else{
            $log->saveLog($o->studentreminder_id,$tablestudentreminder,"$o->changesql","D","F");
			redirect_header("studentreminder.php?action=edit&studentreminder_id=$o->studentreminder_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else
		redirect_header("studentreminder.php?action=edit&studentreminder_id=$o->studentreminder_id",$pausetime,"Warning! Can't delete data from database.");

  break;

  case "showReminder" :
      $student_id = $_GET['student_id'];

          
      $o->showStudentReminderTable("WHERE a.student_id = $student_id","");

  break;
  case "search" :
      if($o->semester_id=="")
          $o->semester_id=0;

      if($o->student_id=="")
          $o->student_id=0;
      if($o->reminder_id=="")
          $o->reminder_id=0;

      $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
      $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
      $o->reminderctrl= $ctrl->getSelectReminder($o->reminder_id,"Y");

      $o->showSearchform();
  break;


   case "getlistdbstudent" :
	$strchar = $_POST["strchar"];
	$idinput = $_POST["idinput"];
	$idlayer = $_POST["idlayer"];
	$ctrlid = $_POST["ctrlid"];
	$ocf = $_POST["ocf"];
	$line = $_POST["line"];
    $wherestr = $_POST["wherestr"];

    $wherestr = str_replace("#"," ",$wherestr);
    $wherestr = str_replace("*'","'",$wherestr);
    //echo $wherestr;

	$selectionlist = $o->getSelectDBAjaxStudent($strchar,$idinput,$idlayer,$ctrlid,$ocf,$tablestudent,"student_id","student_name"," and isactive $wherestr ","$line");

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;
  
  default :

      if($o->semester_id=="")
          $o->semester_id=0;
     
      if($o->student_id=="")
          $o->student_id=0;
      if($o->reminder_id=="")
          $o->reminder_id=0;
          
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');

        $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
        $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        $o->reminderctrl= $ctrl->getSelectReminder($o->reminder_id,"Y");
	$o->getInputForm("new",0,$token);
	//$o->showStudentReminderTable("WHERE a.studentreminder_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,a.studentreminder_id");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once '../hea/class/Studentfeedback.php';
//include_once 'class/SelectCtrl.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


//$log = new Log();
$o = new Studentfeedback();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

//marhan add here --> ajax
echo "<iframe src='studentfeedback.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">
function showPreview(studentfeedback_id){
window.open("viewstudentfeedback.php?action=printpreview&studentfeedback_id="+studentfeedback_id);
}

function printStudentList(subjectclass_id){
window.open('viewstudentclass.php?action=printpreview&subjectclass_id='+subjectclass_id);
}

function confirmChangeClass(){
    subjectclasschange_id = document.forms['frmApproval'].subjectclasschange_id.value;

    if(confirm('Confirm change class for selected student?')){

            if(subjectclasschange_id == 0){
            alert('Please Select New Class');
            return false;
            }else{
            document.forms['frmApproval'].action.value = "changeclass";
            document.forms['frmApproval'].submit();
            return true;
            }
    
    }else{
    return false;
    }
}

function changeClass(){

document.getElementById('idChangeClass').style.display = "";
}

function approveSelected(type){

    if(type == 'approveline'){

        if(confirm("Approve Selected Line?")){
        document.forms['frmApproval'].action.value = type;
        document.forms['frmApproval'].submit();
        }else{
        document.forms['frmApproval'].action.value = "";
        }

    }else if(type == 'rejectline'){

        if(confirm("Reject Selected Line?")){
        document.forms['frmApproval'].action.value = type;
        document.forms['frmApproval'].submit();
        }else{
        document.forms['frmApproval'].action.value = "";
        }

    }else if(type == 'deleteline'){

        if(confirm("Delete Selected Line?")){
        document.forms['frmApproval'].action.value = type;
        document.forms['frmApproval'].submit();
        }else{
        document.forms['frmApproval'].action.value = "";
        }

    }
    
}

function getDetails(studentfeedback_id){

window.open('studentfeedback.php?action=viewdetails&studentfeedback_id='+studentfeedback_id);
}

function selectAll(val){

    var i=0;
    while(i< document.forms['frmApproval'].elements.length){
    var ctlname = document.forms['frmApproval'].elements[i].name;
    var data = document.forms['frmApproval'].elements[i].value;

    ctlname = ctlname.substring(0,ctlname.indexOf("["))
    if(ctlname=="isselected"){

    document.forms['frmApproval'].elements[i].checked = val;
    }

    i++;

}


}



function checkAddSelect(){
employee_id = document.forms['frmStudentfeedback'].addemployee_id.value;

if(employee_id == 0){
alert('Please Select Lecturer.');
}else{

    if(validateStudentfeedback()){
    selectAll(false);
    document.forms['frmStudentfeedback'].submit();
    }else
    return false;
}

}

function autofocus(){
document.forms['frmStudentfeedback'].studentfeedback_name.focus();
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


	function validateStudentfeedback(){
		
		var name=document.forms['frmStudentfeedback'].studentfeedback_name.value;
		var defaultlevel=document.forms['frmStudentfeedback'].defaultlevel.value;
        var studentfeedback_crdthrs1=document.forms['frmStudentfeedback'].studentfeedback_crdthrs1.value;
        var studentfeedback_crdthrs2=document.forms['frmStudentfeedback'].studentfeedback_crdthrs2.value;
		var studentfeedback_no=document.forms['frmStudentfeedback'].studentfeedback_no.value;
	
			
		if(confirm("Save record?")){
		if(name =="" || !IsNumeric(defaultlevel) || defaultlevel=="" || studentfeedback_no =="" || !IsNumeric(studentfeedback_crdthrs1) || studentfeedback_crdthrs1=="" || !IsNumeric(studentfeedback_crdthrs2) || studentfeedback_crdthrs2==""){
			alert('Please make sure Studentfeedback Name, Studentfeedback Code is filled in, Default Level and Credit Hours filled with numeric value');
			return false;
		}
		else
            return true;
		}
		else
			return false;
	}
function gotoAction(action){
	document.forms['frmStudentfeedback'].action.value = action;
	document.forms['frmStudentfeedback'].submit();
	}

</script>

EOF;
$widthsubject = "style = 'width:300px' ";

$o->studentfeedback_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
}
else
$action="";

$token=$_POST['token'];

$o->subject_id=$_POST["subject_id"];

if(isset($_POST["year_id"]))
$o->year_id=$_POST["year_id"];
else
$o->year_id=$_GET["year_id"];

if(isset($_POST["session_id"]))
$o->session_id=$_POST["session_id"];
else
$o->session_id=$_GET["session_id"];

$o->course_id=$_POST["course_id"];
$o->semester_id=$_POST["semester_id"];
$o->group_no=$_POST["group_no"];

if(isset($_POST["feedback_status"]))
$o->feedback_status=$_POST['feedback_status'];
else
$o->feedback_status=$_GET["feedback_status"];

$o->courseline_id=$_POST["courseline_id"];
$o->semesterline_id=$_POST["semesterline_id"];


$isactive=$_POST['isactive'];
$o->organization_id=$_POST['organization_id'];
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

if(isset($_POST["issearch"]))
$o->issearch=$_POST['issearch'];
else
$o->issearch=$_GET['issearch'];


if(isset($_POST['studentfeedback_id']))
$o->studentfeedback_id=$_POST['studentfeedback_id'];
else
$o->studentfeedback_id=$_GET['studentfeedback_id'];

$o->pic_description=$_POST['pic_description'];
$o->feedback_progress=$_POST['feedback_progress'];
//$o->feedback_status=$_POST['feedback_status'];

$o->isselected=$_POST['isselected'];

if ($isactive=="1" || $isactive=="on")
	$o->isactive=1;
else if ($isactive=="null")
	$o->isactive="null";
else
	$o->isactive=0;

$o->subjectwidth = "style = 'width:200px' ";

 switch ($action){
	//When user submit new organization

    case "approveline" :

    if($o->graduateApproval('A')){

        $log->saveLog(0,$tablestudentfeedback,"$o->changesql","U","O");

    }else{
        $log->saveLog(0,$tablestudentfeedback,"$o->changesql","U","F");
        echo "<b><font color=red>$o->warningtxt</font></b>";
    }

    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->subjectctrl=$ctrl->getSelectSubject($o->subject_id,"Y","","subject_id","","subject_id","$widthsubject","Y",0);
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
	$o->showSearchForm();
    $o->showStudentfeedbackTable($wherestr,"",$limitstr);
   
  break;

  case "rejectline" :

    if($o->graduateApproval('R')){

        $log->saveLog(0,$tablestudentfeedback,"$o->changesql","U","O");

    }else{
        $log->saveLog(0,$tablestudentfeedback,"$o->changesql","U","F");
        echo "<b><font color=red>$o->warningtxt</font></b>";
    }
    
    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->subjectctrl=$ctrl->getSelectSubject($o->subject_id,"Y","","subject_id","","subject_id","$widthsubject","Y",0);
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
	$o->showSearchForm();
    $o->showStudentfeedbackTable($wherestr,"",$limitstr);
  break;



    case "search" :

	$wherestr =" WHERE sb.subject_id>0 and sc.organization_id=$defaultorganization_id ";

    $limitstr = "";
	if($o->issearch == "Y"){
	$wherestr .= $o->getWhereStr();
    }else{
    $limitstr = " limit 50 ";
	$o->year_id = 0;
    $o->session_id = 0;
    $o->course_id = 0;
    $o->semester_id = 0;
    $o->subject_id = 0;
	}

    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->subjectctrl=$ctrl->getSelectSubject($o->subject_id,"Y","","subject_id","","subject_id","$widthsubject","Y",0);
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
	$o->showSearchForm();
	//if($o->issearch == "Y")
	$o->showStudentfeedbackTable($wherestr," ORDER BY sc.year_id,sc.session_id,sc.course_id,sc.semester_id,sb.subject_no,sc.group_no ",$limitstr);
  break;


case "getlistdb" :
	$strchar = $_POST["strchar"];
	$idinput = $_POST["idinput"];
	$idlayer = $_POST["idlayer"];
	$ctrlid = $_POST["ctrlid"];
	$ocf = $_POST["ocf"];
	$line = $_POST["line"];
    $wherestr = $_POST["wherestr"];
    $wherestr = str_replace("#"," ",$wherestr);
    $wherestr = str_replace("*","'",$wherestr);
    //$wherestr .= " and sb.subject_no like '%$strchar%' ";
    //$wherestr .= " and sc.subject_id and sb.subject_id and sc.course_id = cr.course ";

	$selectionlist = $o->getSelectDBAjaxSubjectclass($strchar,$idinput,$idlayer,$ctrlid,$ocf,$o->tablesubjectclass,"sc.subjectclass_id","sb.subject_name","$wherestr","$line");

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

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

	$selectionlist = $o->getSelectDBAjaxStudent($strchar,$idinput,$idlayer,$ctrlid,$ocf,$o->tablestudent,"student_id","student_name"," and isactive $wherestr ","$line");

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;

    case "getlistdba" :
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

	$selectionlist = $o->getSelectDBAjax($strchar,$idinput,$idlayer,$ctrlid,$ocf,$o->tablestudent,"student_id","student_name"," and isactive =1 $wherestr ","$line");

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;

  case "getlistdbsubject" :
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

	$selectionlist = $o->getSelectDBAjaxSubject($strchar,$idinput,$idlayer,$ctrlid,$ocf,$o->tablesubject,"subject_id","subject_name"," and isactive =1 $wherestr ","$line");

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;



  case "changeclass" :

    $subjectclass_id = $_POST['subjectclass_id'];
    $subjectclasschange_id = $_POST['subjectclasschange_id'];

    $subjectregisterline_id = $_POST['subjectregisterline_id'];
    $isapproval_line = $_POST['isapproval_line'];
    $approval_type = $_POST['approval_type'];
    $subjectregister_type = $_POST['subjectregister_type'];


    if(count($subjectregisterline_id) >0){

        if($o->changeClass($subjectclasschange_id,$subjectregisterline_id,$isapproval_line)){
        $log->saveLog($o->subjectregister_id,$tablesubjectregister,"$o->changesql","U","O");
        }else{
            
        $log->saveLog($o->subjectregister_id,$tablesubjectregister,"$o->changesql","U","F");
        }

    }

    if($o->liststudent !=""){
        echo "<font color=red>Failed To Change Student : <br>$o->liststudent</font>";
    }
    $o->subjectclassctrl=$ctrl->getSelectSubjectclass(0,"Y","","subjectclasschange_id"," and sc.year_id = $o->year_id and sc.session_id = $o->session_id ","subjectclasschange_id","","Y",0);
    $o->showDetailsList($subjectclass_id,$o->course_id,$o->semester_id,$o->group_no);

    //$o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    //$o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    //$o->coursectrl=$ctrl->getSelectCourse($o->course_id,"N");
    //$o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
	//$o->showSearchForm();
	//if($o->issearch == "Y")
	//$o->showStudentfeedbackTable($wherestr," ORDER BY st.year_id,st.session_id,st.course_id,sm.semester_id,sb.subject_no ",$limitstr);
  break;

case "updatedetails" :

    if ($s->check(false,$token,"CREATE_ACG")){
        $o->updatedby=$xoopsUser->getVar('uid'); //get current uid

        if($o->updateDetails()){

            $log->saveLog(0,$tablestudentfeedback,"$o->changesql","U","O");
        }else{

            $log->saveLog(0,$tablestudentfeedback,"$o->changesql","U","F");
        }
    }else{
        $o->txtwarning = "Approval Failed. Please Try Again";
        $log->saveLog(0,$tablestudentfeedback,"$o->changesql","U","F");
    }

        echo "<font color=red><b>$o->txtwarning</b></font>";

    $o->showDetailsForm($token);

break;

  case "viewdetails" :
    $token=$s->createToken($tokenlife,"CREATE_ACG");

    $o->showDetailsForm($token);
  break;
  
  default :
    if($o->year_id=="")
    $o->year_id = 0;
    if($o->session_id=="")
	$o->session_id = 0;
    if($o->course_id=="")
    $o->course_id = 0;
    if($o->semester_id=="")
    $o->semester_id = 0;
    if($o->subject_id=="")
    $o->subject_id = 0;
	

    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->subjectctrl=$ctrl->getSelectSubject($o->subject_id,"Y","","subject_id","","subject_id","$widthsubject","Y",0);
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
	$o->showSearchForm();
	//if($o->issearch == "Y")
	//$o->showStudentfeedbackTable($wherestr,"ORDER BY a.defaultlevel,a.studentfeedback_no",$limitstr);
    
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once '../hea/class/Studentapplication.php';
//include_once 'class/SelectCtrl.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


//$log = new Log();
$o = new Studentapplication();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

//marhan add here --> ajax
echo "<iframe src='studentapplication.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">
function checkHostel(){

    hostel_amtcost = document.forms['frmViewDetailsHostel'].hostel_amtcost.value;

    if(confirm('Update Information')){
            if(!IsNumeric(hostel_amtcost) || hostel_amtcost == ""){
            alert("Please Filled In Assumption Cost with Numeric Value.");
            return false;
            }else{
            return true;
            }
    }else{
    return false;
    }
}

function showPreview(mainapplication_id){
window.open("viewstudentapplication.php?action=printpreview&mainapplication_id="+mainapplication_id);
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

function getDetails(mainapplication_id,approvalbyname){

window.open('studentapplication.php?action=viewdetails&mainapplication_id='+mainapplication_id+'&approvalbyname='+approvalbyname);
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
employee_id = document.forms['frmStudentapplication'].addemployee_id.value;

if(employee_id == 0){
alert('Please Select Lecturer.');
}else{

    if(validateStudentapplication()){
    selectAll(false);
    document.forms['frmStudentapplication'].submit();
    }else
    return false;
}

}

function autofocus(){
document.forms['frmStudentapplication'].studentapplication_name.focus();
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


	function validateStudentapplication(){

		var name=document.forms['frmStudentapplication'].studentapplication_name.value;
		var defaultlevel=document.forms['frmStudentapplication'].defaultlevel.value;
        var studentapplication_crdthrs1=document.forms['frmStudentapplication'].studentapplication_crdthrs1.value;
        var studentapplication_crdthrs2=document.forms['frmStudentapplication'].studentapplication_crdthrs2.value;
		var studentapplication_no=document.forms['frmStudentapplication'].studentapplication_no.value;


		if(confirm("Save record?")){
		if(name =="" || !IsNumeric(defaultlevel) || defaultlevel=="" || studentapplication_no =="" || !IsNumeric(studentapplication_crdthrs1) || studentapplication_crdthrs1=="" || !IsNumeric(studentapplication_crdthrs2) || studentapplication_crdthrs2==""){
			alert('Please make sure Studentapplication Name, Studentapplication Code is filled in, Default Level and Credit Hours filled with numeric value');
			return false;
		}
		else
            return true;
		}
		else
			return false;
	}
function gotoAction(action){
	document.forms['frmStudentapplication'].action.value = action;
	document.forms['frmStudentapplication'].submit();
	}

</script>

EOF;
$widthsubject = "style = 'width:300px' ";

$o->mainapplication_id=0;
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

if(isset($_POST["mainapplication_status"]))
$o->mainapplication_status=$_POST["mainapplication_status"];
else
$o->mainapplication_status=$_GET['mainapplication_status'];



if(isset($_POST["approvalbyname"]))
$o->approvalbyname=$_POST["approvalbyname"];
else
$o->approvalbyname=$_GET["approvalbyname"];


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


if(isset($_POST['mainapplication_id']))
$o->mainapplication_id=$_POST['mainapplication_id'];
else
$o->mainapplication_id=$_GET['mainapplication_id'];

// hea
$o->hea_remarks=$_POST['hea_remarks'];
$o->hea_approvalremarks=$_POST['hea_approvalremarks'];

if(isset($_POST["hea_approval"]))
$o->hea_approval=$_POST['hea_approval'];
else
$o->hea_approval=$_GET['hea_approval'];

//hostel
$o->hostel_action1=$_POST['hostel_action1'];
$o->hostel_action2=$_POST['hostel_action2'];
$o->hostel_action3=$_POST['hostel_action3'];
$o->hostel_action4=$_POST['hostel_action4'];
$o->hostel_action5=$_POST['hostel_action5'];
$o->hostel_action6=$_POST['hostel_action6'];
$o->hostel_others=$_POST['hostel_others'];
$o->hostel_amtcost=$_POST['hostel_amtcost'];
$o->hostel_comment=$_POST['hostel_comment'];
$o->isreturndeposit=$_POST['isreturndeposit'];
$o->hostel_approval=$_POST['hostel_approval'];

// finance
$o->finance_remarks=$_POST['finance_remarks'];
$o->finance_approvalremarks=$_POST['finance_approvalremarks'];
$o->finance_approval=$_POST['finance_approval'];

// hes
$o->hes_comment=$_POST['hes_comment'];
$o->hes_remarks=$_POST['hes_remarks'];
$o->hes_approvalremarks=$_POST['hes_approvalremarks'];
$o->hes_approval=$_POST['hes_approval'];

// hes
$o->mainapplication_remarks=$_POST['mainapplication_remarks'];
//$o->mainapplication_status=$_POST['mainapplication_status'];

if ($o->isreturndeposit=="1" || $o->isreturndeposit=="on")
$o->isreturndeposit=1;
else
$o->isreturndeposit=0;

if ($o->hostel_action1=="1" || $o->hostel_action1=="on")
$o->hostel_action1=1;
else
$o->hostel_action1=0;

if ($o->hostel_action2=="1" || $o->hostel_action2=="on")
$o->hostel_action2=1;
else
$o->hostel_action2=0;

if ($o->hostel_action3=="1" || $o->hostel_action3=="on")
$o->hostel_action3=1;
else
$o->hostel_action3=0;

if ($o->hostel_action4=="1" || $o->hostel_action4=="on")
$o->hostel_action4=1;
else
$o->hostel_action4=0;

if ($o->hostel_action5=="1" || $o->hostel_action5=="on")
$o->hostel_action5=1;
else
$o->hostel_action5=0;

if ($o->hostel_action6=="1" || $o->hostel_action6=="on")
$o->hostel_action6=1;
else
$o->hostel_action6=0;

$o->isselected=$_POST['isselected'];

if ($isactive=="1" || $isactive=="on")
	$o->isactive=1;
else if ($isactive=="null")
	$o->isactive="null";
else
	$o->isactive=0;

$o->subjectwidth = "style = 'width:200px' ";

$o->approval_windows = "finance";

 switch ($action){
	//When user submit new organization

    case "approveline" :

    if($o->graduateApproval('A')){

        $log->saveLog(0,$tablestudentapplication,"$o->changesql","U","O");

    }else{
        $log->saveLog(0,$tablestudentapplication,"$o->changesql","U","F");
        echo "<b><font color=red>$o->warningtxt</font></b>";
    }

    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->subjectctrl=$ctrl->getSelectSubject($o->subject_id,"Y","","subject_id","","subject_id","$widthsubject","Y",0);
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
	$o->showSearchForm();
    $o->showStudentapplicationTable($wherestr,"",$limitstr);

  break;

  case "rejectline" :

    if($o->graduateApproval('R')){

        $log->saveLog(0,$tablestudentapplication,"$o->changesql","U","O");

    }else{
        $log->saveLog(0,$tablestudentapplication,"$o->changesql","U","F");
        echo "<b><font color=red>$o->warningtxt</font></b>";
    }

    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->subjectctrl=$ctrl->getSelectSubject($o->subject_id,"Y","","subject_id","","subject_id","$widthsubject","Y",0);
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
	$o->showSearchForm();
    $o->showStudentapplicationTable($wherestr,"",$limitstr);
  break;



    case "search" :

	$wherestr =" WHERE ma.organization_id=$defaultorganization_id ";

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


	$o->showStudentapplicationTable($o->approval_windows,$wherestr," ORDER BY sc.year_id,sc.session_id,sc.course_id,sc.semester_id,sb.subject_no,sc.group_no ",$limitstr);
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
	//$o->showStudentapplicationTable($wherestr," ORDER BY st.year_id,st.session_id,st.course_id,sm.semester_id,sb.subject_no ",$limitstr);
  break;

case "updatehea" :

    if ($s->check(false,$token,"CREATE_ACG")){
        $o->updatedby=$xoopsUser->getVar('uid'); //get current uid

        if($o->updateHea()){

            $log->saveLog($o->mainapplication_id,$tablemainapplication,"$o->changesql","U","O");
        }else{

            $log->saveLog($o->mainapplication_id,$tablemaintapplication,"$o->changesql","U","F");
        }
    }else{
        $o->txtwarning = "Approval Failed. Please Try Again";
        $log->saveLog(0,$tablemainapplication,"$o->changesql","U","F");
    }

        echo "<font color=red><b>$o->txtwarning</b></font>";

    $o->showDetailsFormHea($token);

break;

case "updatehostel" :

    if ($s->check(false,$token,"CREATE_ACG")){
        $o->updatedby=$xoopsUser->getVar('uid'); //get current uid

        if($o->updateHostel()){

            $log->saveLog($o->mainapplication_id,$tablemainapplication,"$o->changesql","U","O");
        }else{

            $log->saveLog($o->mainapplication_id,$tablemaintapplication,"$o->changesql","U","F");
        }
    }else{
        $o->txtwarning = "Approval Failed. Please Try Again";
        $log->saveLog(0,$tablemainapplication,"$o->changesql","U","F");
    }

        echo "<font color=red><b>$o->txtwarning</b></font>";

    $o->showDetailsFormHostel($token);

break;

case "updatefinance" :

    if ($s->check(false,$token,"CREATE_ACG")){
        $o->updatedby=$xoopsUser->getVar('uid'); //get current uid

        if($o->updateFinance()){

            $log->saveLog($o->mainapplication_id,$tablemainapplication,"$o->changesql","U","O");
        }else{

            $log->saveLog($o->mainapplication_id,$tablemaintapplication,"$o->changesql","U","F");
        }
    }else{
        $o->txtwarning = "Approval Failed. Please Try Again";
        $log->saveLog(0,$tablemainapplication,"$o->changesql","U","F");
    }

        echo "<font color=red><b>$o->txtwarning</b></font>";

    $o->showDetailsFormFinance($token);

break;

case "updatehes" :

    if ($s->check(false,$token,"CREATE_ACG")){
        $o->updatedby=$xoopsUser->getVar('uid'); //get current uid

        if($o->updateHes()){

            $log->saveLog($o->mainapplication_id,$tablemainapplication,"$o->changesql","U","O");
        }else{

            $log->saveLog($o->mainapplication_id,$tablemaintapplication,"$o->changesql","U","F");
        }
    }else{
        $o->txtwarning = "Approval Failed. Please Try Again";
        $log->saveLog(0,$tablemainapplication,"$o->changesql","U","F");
    }

        echo "<font color=red><b>$o->txtwarning</b></font>";

    $o->showDetailsFormHes($token);

break;

case "updateadmin" :

    if ($s->check(false,$token,"CREATE_ACG")){
        $o->updatedby=$xoopsUser->getVar('uid'); //get current uid

        if($o->updateAdmin()){

            $log->saveLog($o->mainapplication_id,$tablemainapplication,"$o->changesql","U","O");
        }else{

            $log->saveLog($o->mainapplication_id,$tablemaintapplication,"$o->changesql","U","F");
        }
    }else{
        $o->txtwarning = "Approval Failed. Please Try Again";
        $log->saveLog(0,$tablemainapplication,"$o->changesql","U","F");
    }

        echo "<font color=red><b>$o->txtwarning</b></font>";

    $o->showDetailsFormAdmin($token);

break;

  case "viewdetails" :
    $token=$s->createToken($tokenlife,"CREATE_ACG");

    if($o->approvalbyname == "hea")
    $o->showDetailsFormHea($token);
    else if($o->approvalbyname == "hostel")
    $o->showDetailsFormHostel($token);
    else if($o->approvalbyname == "finance")
    $o->showDetailsFormFinance($token);
    else if($o->approvalbyname == "hes")
    $o->showDetailsFormHes($token);
    else if($o->approvalbyname == "admin")
    $o->showDetailsFormAdmin($token);
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
	//$o->showStudentapplicationTable($wherestr,"ORDER BY a.defaultlevel,a.studentapplication_no",$limitstr);

  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>
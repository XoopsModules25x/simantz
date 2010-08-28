<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once 'class/Studentonline.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';

//$log = new Log();
$o = new Studentonline();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";

$o->createddatectrl=$dp->show("created");
$o->createddateupdatectrl=$dp->show("update_date");
$o->createdby=$xoopsUser->getVar('uid');
$action="";

//if(!copy("../../../instedtonline/upload/applicantfile/test.txt", "../hes/upload/student/test.txt"))
//echo "cannot";

//marhan add here --> ajax
echo "<iframe src='studentonline.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">

function getPageDetails(val){

document.forms['frmSearch'].page_no.value = val;
document.forms['frmSearch'].submit();
}

function generateStudent(){

    if(confirm("Confirm Generate Student For The Selected Record?")){

        document.forms['frmApproval'].action.value = "generatestudent";
        document.forms['frmApproval'].submit();
    }else{
    return false;
    }
}

function checkRecord(){

    if(confirm("Save Listed Record?")){

        var i=0;
        while(i< document.forms['frmApproval'].elements.length){
        var ctlname = document.forms['frmApproval'].elements[i].name;
        var data = document.forms['frmApproval'].elements[i].value;

        ctlname = ctlname.substring(0,ctlname.indexOf("["))

        if(ctlname=="invoice_amt" || ctlname=="paid_amt"){

            if(data == ""){

            }else{
                if(!IsNumeric(data) || data == ""){
                document.forms['frmApproval'].elements[i].style.backgroundColor = "#FF0000";
                alert("Please make sure Amount is Filled In With Numeric Value.");
                return false;
                }
            }
        }

        document.forms['frmApproval'].elements[i].style.backgroundColor = "#FFFFFF"

        i++;

        }

        document.forms['frmApproval'].action.value = "updatelist";
        document.forms['frmApproval'].submit();

    }else{
    return false;
    }
}

function validate(){
    var action=document.frmApproval.action.value;
    var confirmtext="";
    if(action=='sendsms')
        confirmtext=prompt("Confirm send SMS? It will charge RM0.15 per message","No");
    else if(action=='sendemail')
        confirmtext=prompt("Confirm send out this email?","No");
     if(confirmtext=='Yes' || confirmtext=='yes' || confirmtext=='YES')
        return true;
     else
        return false;
}

function updateField(fldname,fldval){


    var i=0;
    while(i< document.forms['frmApproval'].elements.length){
    var ctlname = document.forms['frmApproval'].elements[i].name;
    var data = document.forms['frmApproval'].elements[i].value;

    ctlname = ctlname.substring(0,ctlname.indexOf("["))

    if(ctlname==fldname){

        startstr = document.forms['frmApproval'].elements[i].name.indexOf("[")+1;
        endstr = document.forms['frmApproval'].elements[i].name.indexOf("]");
        line = document.forms['frmApproval'].elements[i].name.substring(startstr,endstr);

        selectval = document.getElementById("isselected"+line).checked;



        if(selectval == true)
        document.forms['frmApproval'].elements[i].value = fldval;
    }

    i++;

    }

}

function showTextArea(line){
    var styletxt = document.getElementById('idTextArea'+line).style.display;

    if(styletxt == "none")
    document.getElementById('idTextArea'+line).style.display = "";
    else
    document.getElementById('idTextArea'+line).style.display = "none";
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

function getDetails(subjectclass_id){

window.open('studentonline.php?action');
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
employee_id = document.forms['frmStudentonline'].addemployee_id.value;

if(employee_id == 0){
alert('Please Select Lecturer.');
}else{

    if(validateStudentonline()){
    selectAll(false);
    document.forms['frmStudentonline'].submit();
    }else
    return false;
}

}

function autofocus(){
document.forms['frmStudentonline'].studentonline_name.focus();
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


	function validateStudentonline(){
		
		var name=document.forms['frmStudentonline'].studentonline_name.value;
		var defaultlevel=document.forms['frmStudentonline'].defaultlevel.value;
        var studentonline_crdthrs1=document.forms['frmStudentonline'].studentonline_crdthrs1.value;
        var studentonline_crdthrs2=document.forms['frmStudentonline'].studentonline_crdthrs2.value;
		var studentonline_no=document.forms['frmStudentonline'].studentonline_no.value;
	
			
		if(confirm("Save record?")){
		if(name =="" || !IsNumeric(defaultlevel) || defaultlevel=="" || studentonline_no =="" || !IsNumeric(studentonline_crdthrs1) || studentonline_crdthrs1=="" || !IsNumeric(studentonline_crdthrs2) || studentonline_crdthrs2==""){
			alert('Please make sure Studentonline Name, Studentonline Code is filled in, Default Level and Credit Hours filled with numeric value');
			return false;
		}
		else
            return true;
		}
		else
			return false;
	}
function gotoAction(action){
	document.forms['frmStudentonline'].action.value = action;
	document.forms['frmStudentonline'].submit();
	}

</script>

EOF;
$widthsubject = "style = 'width:300px' ";

$o->studentonline_id=0;
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
$o->coursetype_id=$_POST["coursetype_id"];
$o->group_no=$_POST["group_no"];

if(isset($_POST["studentonline_status"]))
$o->studentonline_status=$_POST['studentonline_status'];
else
$o->studentonline_status=$_GET["studentonline_status"];

$o->courseline_id=$_POST["courseline_id"];
$o->semesterline_id=$_POST["semesterline_id"];

if(isset($_POST["iscreatetostudent"]))
$o->iscreatetostudent=$_POST["iscreatetostudent"];
else
$o->iscreatetostudent=$_GET["iscreatetostudent"];

$isactive=$_POST['isactive'];
$o->organization_id=$_POST['organization_id'];
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

if(isset($_POST["issearch"]))
$o->issearch=$_POST['issearch'];
else
$o->issearch=$_GET['issearch'];

$o->page_no=$_POST['page_no'];

if($o->page_no <= 0)
$o->page_no = 1;


// line


$o->isselected=$_POST['isselected'];
$o->invoice_amt=$_POST['invoice_amt'];
$o->paid_amt=$_POST['paid_amt'];
$o->payment_method=$_POST['payment_method'];
$o->doc_no=$_POST['doc_no'];
$o->finance_remarks=$_POST['finance_remarks'];
$o->description=$_POST['description'];
$o->student_newicno=$_POST['student_newicno'];

if(isset($_POST['student_id']))
$o->student_id=$_POST['student_id'];
else
$o->student_id=$_GET['student_id'];

if ($isactive=="1" || $isactive=="on")
	$o->isactive=1;
else if ($isactive=="null")
	$o->isactive="null";
else
	$o->isactive=0;

$o->subjectwidth = "style = 'width:200px' ";

 switch ($action){
	//When user submit new organization


    case "generatestudent" :

    if($o->generateStudent()){

        $log->saveLog(0,$tablestudentonline,"$o->changesql","U","O");
        echo "<b><font color=blue>$o->warningtxt</font></b>";

    }else{
        $log->saveLog(0,$tablestudentonline,"$o->changesql","U","F");
        echo "<b><font color=red>$o->warningtxt</font></b>";
    }

    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->coursetypectrl=$ctrl->getSelectCoursetype($o->coursetype_id,"Y");
    $o->showSearchForm();
    $o->showStudentonlineTable($wherestr,"",$limitstr);

  break;

  
    case "updatelist" :

    if($o->updateList()){

        $log->saveLog(0,$tablestudentonline,"$o->changesql","U","O");

    }else{
        $log->saveLog(0,$tablestudentonline,"$o->changesql","U","F");
        echo "<b><font color=red>$o->warningtxt</font></b>";
    }

    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->coursetypectrl=$ctrl->getSelectCoursetype($o->coursetype_id,"Y");
    $o->showSearchForm();
    $o->showStudentonlineTable($wherestr,"",$limitstr);

  break;
  
    case "approveline" :

    if($o->graduateApproval('A')){

        $log->saveLog(0,$tablestudentonline,"$o->changesql","U","O");

    }else{
        $log->saveLog(0,$tablestudentonline,"$o->changesql","U","F");
        echo "<b><font color=red>$o->warningtxt</font></b>";
    }

    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->coursetypectrl=$ctrl->getSelectCoursetype($o->coursetype_id,"Y");
	$o->showSearchForm();
    $o->showStudentonlineTable($wherestr,"",$limitstr);
   
  break;

  case "rejectline" :

    if($o->graduateApproval('R')){

        $log->saveLog(0,$tablestudentonline,"$o->changesql","U","O");

    }else{
        $log->saveLog(0,$tablestudentonline,"$o->changesql","U","F");
        echo "<b><font color=red>$o->warningtxt</font></b>";
    }
    

    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->coursetypectrl=$ctrl->getSelectCoursetype($o->coursetype_id,"Y");
	$o->showSearchForm();
    $o->showStudentonlineTable($wherestr,"",$limitstr);
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
    $o->coursetype_id = 0;
    $o->subject_id = 0;
	}


    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->coursetypectrl=$ctrl->getSelectCoursetype($o->coursetype_id,"Y");
	$o->showSearchForm();
	//if($o->issearch == "Y")
	$o->showStudentonlineTable($wherestr,"",$limitstr);
  break;


case "sendemail":
    include "../system/class/SendMessage.php.inc";
    include "../system/class/Mail.php";
    $m=new SendMessage();

    $m->emailtitle=$_POST['emailtitle'];
    $m->message=$_POST['msg'];
    $m->textlength=$_POST['textlength'];
    $m->receipient=$o->getEmail();


		$headers = array ('Subject' => $m->emailtitle,'From' => $smtpuser,
		'To' => $m->receipient);
		$smtp = Mail::factory('smtp',
		array ('host' => "$m->smtpserver",
		'auth' => true,
		'username' => $m->smtpuser,
		'password' => $m->smtppassword));

		$mail = $smtp->send($m->receipient, $headers, $m->message);

		if (PEAR::isError($mail)) {
		echo("<p>" . $mail->getMessage() . "</p>");
		} else {
		echo("<p>Message sent! click <a href='index.php'>here</a> for back to home.</p> The receipient as below:<br>$m->receipient");
		}

//    $m->sendemail();
    break;
case "sendsms":
    global $sendsmsgroup;

    if($o->isGroup($sendsmsgroup)){
        include_once "../system/class/SendMessage.php.inc";
        $m=new SendMessage();

        $m->emailtitle=$_POST['emailtitle'];
        $m->message=$_POST['msg'];
        $m->textlength=$_POST['textlength'];
        $m->subscriber_number=$o->getNumber();
        $m->sendsms();
    }
    else
        //redirect_header("studentonline.php",$pausetime,"You do not have a permission to send SMS");
        echo "You do not have a permission to send SMS";
    break;


  case "viewdetail" :

  $o->getViewDetails($o->student_id);
  break;
  default :

    if($o->course_id=="")
    $o->course_id = 0;
    if($o->coursetype_id=="")
    $o->coursetype_id = 0;
	

    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->subjectctrl=$ctrl->getSelectSubject($o->subject_id,"Y","","subject_id","","subject_id","$widthsubject","Y",0);
    $o->coursetypectrl=$ctrl->getSelectCoursetype($o->coursetype_id,"Y");
	$o->showSearchForm();
	//if($o->issearch == "Y")
	//$o->showStudentonlineTable($wherestr,"ORDER BY a.defaultlevel,a.studentonline_no",$limitstr);
    
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

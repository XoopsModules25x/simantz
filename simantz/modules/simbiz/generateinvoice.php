<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once 'class/Generateinvoice.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
include_once "../simbiz/class/AccountsAPI.php";
include_once "../simbiz/class/Studentinvoice.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';


//$log = new Log();
$o = new Generateinvoice();
$s = new XoopsSecurity();
$api = new AccountsAPI();
$studentinv = new Studentinvoice();
$orgctrl="";

$o->subjectwidth = "style = 'width:200px' ";


$action="";

//marhan add here --> ajax
echo "<iframe src='generateinvoice.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">

function updateReactivate(generatestudentinvoice_id,line){

    if(confirm("Confirm Re-activate Invoice For This Academic Session?\\n(Will Effect Account)")){
    document.getElementById('btnVoid'+line).style.display = "none";
    val = false;

	var arr_fld=new Array("action","generatestudentinvoice_id","ispublish");//name for POST
	var arr_val=new Array("publishsetinvoice",generatestudentinvoice_id,val);//value for POST

	getRequest(arr_fld,arr_val);
    }else{
    }
}

function updatePublish(generatestudentinvoice_id,line){

    if(confirm("Confirm Publish Invoice For This Academic Session?")){

    val = true;
	var arr_fld=new Array("action","generatestudentinvoice_id","ispublish");//name for POST
	var arr_val=new Array("publishsetinvoice",generatestudentinvoice_id,val);//value for POST

	getRequest(arr_fld,arr_val);
    }else{
    }
}


function editStudentInvoice(studentinvoice_id){
window.open("studentinvoice.php?action=edit&studentinvoice_id="+studentinvoice_id);
}

function viewStudentList(course_id,generatestudentinvoice_id){

}

function publishSetInvoice(generatestudentinvoice_id,val,line){

    if(confirm("Confirm Publish Invoice For This Academic Session?")){

    if(val == true)
    document.getElementById('btnVoid'+line).style.display = "none";
    else
    document.getElementById('btnVoid'+line).style.display = "";

	var arr_fld=new Array("action","generatestudentinvoice_id","ispublish");//name for POST
	var arr_val=new Array("publishsetinvoice",generatestudentinvoice_id,val);//value for POST

	getRequest(arr_fld,arr_val);
    }else{

        if(val == true)
        document.getElementById('ispublish'+line).checked = false;
        else
        document.getElementById('ispublish'+line).checked = true;
    }
}

function viewStudentInvoice(studentinvoice_id){
window.open("viewstudentinvoice.php?studentinvoice_id="+studentinvoice_id);
}

function viewAllStudent(){
document.forms['frmCourseList'].course_id.value = 0;
document.forms['frmCourseList'].submit();
}

function viewSetInvoice(generatestudentinvoice_id){
        document.forms['frmListAll'].action.value = "viewsetinvoice";
        document.forms['frmListAll'].generatestudentinvoice_id.value = generatestudentinvoice_id;
        document.forms['frmListAll'].submit();
}

function voidInvoice(generatestudentinvoice_id){
    if(confirm('Void This Set Of Invoice For This Session?')){
        document.forms['frmListAll'].action.value = "voidinvoice";
        document.forms['frmListAll'].generatestudentinvoice_id.value = generatestudentinvoice_id;
        document.forms['frmListAll'].submit();
    }else{
        return false;
    }
}

function saveUpdate(){

    if(confirm("Confirm Save Update?")){
        document.forms['frmViewResult'].action.value = "saveupdate";
        document.forms['frmViewResult'].submit();
    }else{
        return false;
    }
}

function printResultList(){

document.forms['frmList'].action = "printresult.php";
document.forms['frmList'].target = "_blank";
document.forms['frmList'].action.value = "printpreview";
document.forms['frmList'].submit();


document.forms['frmList'].action = "generateinvoice.php";
document.forms['frmList'].target = "";
document.forms['frmList'].action.value = "search";

}

function printResult(studentcgpa_id){
window.open("printresult.php?action=printpreview&studentcgpa_id="+studentcgpa_id);
}


function deleteLine(){

    if(confirm("Delete Selected Line?")){
    document.forms['frmShowList'].action.value = "deleteline";
    document.forms['frmShowList'].submit();
    return true;
    }else{
    document.forms['frmShowList'].action.value = "";
    return false;
    }

}




function autofocus(){
document.forms['frmGenerateinvoice'].generateinvoice_name.focus();
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


	function validateGenerateinvoice(){
		
		var year_id=document.forms['frmGenerateinvoice'].year_id.value;
        var session_id=document.forms['frmGenerateinvoice'].session_id.value;
	
			
		if(confirm("Generate Student Invoice?")){
		if(year_id == 0 || session_id == 0 ){
			alert('Please select Year & Session');
			return false;
		}
		else
            return true;
		}
		else
			return false;
	}
function gotoAction(action){
	document.forms['frmGenerateinvoice'].action.value = action;
	document.forms['frmGenerateinvoice'].submit();
	}

function validateGenerateinvoiceEdit(){

		var generateinvoice_date=document.forms['frmGenerateinvoice'].generateinvoice_date.value;
        var generateinvoice_starttime=document.forms['frmGenerateinvoice'].generateinvoice_starttime.value;
        var generateinvoice_endtime=document.forms['frmGenerateinvoice'].generateinvoice_endtime.value;


		if(confirm("Confirm Update Time Table?")){
		if(generateinvoice_starttime == "" || generateinvoice_endtime == "" ){
			alert('Please Make Sure Start Time & End Time Is Filled In.');
			return false;
		}
		else{

                if(!isDate(generateinvoice_date)){
                return false;
                }else
                return true;
        }
		}
		else
			return false;
	}

function selectAll(val){

    var i=0;
    while(i< document.forms['frmStudentList'].elements.length){
    var ctlname = document.forms['frmStudentList'].elements[i].name;
    var data = document.forms['frmStudentList'].elements[i].value;

    ctlname = ctlname.substring(0,ctlname.indexOf("["))
    if(ctlname=="isselect"){

    document.forms['frmStudentList'].elements[i].checked = val;
    }

    i++;

}


}

</script>

EOF;


$o->generatestudentinvoice_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->generatestudentinvoice_id=$_POST["generatestudentinvoice_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->generatestudentinvoice_id=$_GET["generatestudentinvoice_id"];

}
else
$action="";

$token=$_POST['token'];

if (isset($_POST['year_id'])){
$o->year_id=$_POST["year_id"];
}else{
$o->year_id=$_GET["year_id"];
}

if (isset($_POST['session_id'])){
$o->session_id=$_POST["session_id"];
}else{
$o->session_id=$_GET["session_id"];
}

if (isset($_POST['course_id'])){
$o->course_id=$_POST["course_id"];
}else{
$o->course_id=$_GET["course_id"];
}

if (isset($_POST['semester_id'])){
$o->semester_id=$_POST["semester_id"];
}else{
$o->semester_id=$_GET["semester_id"];
}

if (isset($_POST['subject_id'])){
$o->subject_id=$_POST["subject_id"];
}else{
$o->subject_id=$_GET["subject_id"];
}

if (isset($_POST['student_id'])){
$o->student_id=$_POST["student_id"];
}else{
$o->student_id=$_GET["student_id"];
}

$isactive=$_POST['isactive'];

$o->isempty=$_POST['isempty'];
$o->week_no=$_POST['week_no'];
$o->organization_id=$_POST['organization_id'];

$o->subject_id=$_POST['subject_id'];
$o->employee_id=$_POST['employee_id'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

if (isset($_POST['issearch'])){
$o->issearch=$_POST['issearch'];
}else{
$o->issearch=$_GET['issearch'];
}

if (isset($_POST['search_type'])){
$o->search_type=$_POST['search_type'];
}else{
$o->search_type=$_GET['search_type'];
}

if (isset($_POST['search_category'])){
$o->search_category=$_POST["search_category"];
}else{
$o->search_category=$_GET["search_category"];
}

if (isset($_POST['showtt'])){
$o->showtt=$_POST['showtt'];
}else{
$o->showtt=$_GET['showtt'];
}

if ($isactive=="1" || $isactive=="on")
	$o->isactive=1;
else if ($isactive=="null")
	$o->isactive="null";
else
	$o->isactive=0;

$o->isdeleteline = $_POST['isdeleteline'];
    
$o->generateinvoicedatectrl=$dp->show("generateinvoice_date");

$o->subjectclasssearch_id = $_POST['subjectclasssearch_id'];
$o->subjectsearch_id = $_POST['subjectsearch_id'];

$o->ischeckexist = $_POST['ischeckexist'];

$o->stylewidthstudent = "style='width:200px'";

 switch ($action){
	//When user submit new organization
  case "create" :
      //$o->copyGenerateinvoiceWeek();
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with generateinvoice name=$o->generateinvoice_name");

	if ($s->check(false,$token,"CREATE_ACG")){
       
        if($o->isempty=="1")
        $isemptytrue = true;
        else
        $isemptytrue = false;


       
        if($o->generateStudentInvoice($o->year_id,$o->session_id,$isemptytrue,0,$o->ischeckexist)){
            $o->updateGenerateSuccess("C",$o->generatestudentinvoice_id);
            //$log->saveLog(0,$tablegenerateinvoice,"$o->changesql","I","O");
            redirect_header("generateinvoice.php?issearch=Y&action=search&search_type=typecourse&year_id=$o->year_id&session_id=$o->session_id",$pausetime,"Invoice Generated Successfully.");
        }else {
            if($o->generatestudentinvoice_id >0)
            $o->updateGenerateSuccess("V",$o->generatestudentinvoice_id);
            else
            echo "<b><font color=red>$o->txtwarning</font></b>";
               //$log->saveLog(0,$tablegenerateinvoice,"$o->changesql","I","F");
        }
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
        //$log->saveLog(0,$tablegenerateinvoice,"$o->changesql","I","F");
	}

    	$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
		$o->getInputForm("new",-1,$token);

break;

  
	//when user request to edit particular organization
  case "edit" :
      
	if($o->fetchGenerateinvoice($o->generatestudentinvoice_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG");
        
		//$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"N");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"N");
        $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"N");
        $o->lecturerroomctrl=$ctrl->getSelectLecturerroom($o->lecturerroom_id,"N");
        $o->subjectclassctrl=$ctrl->getSelectSubjectclass($o->subjectclass_id,"Y","","subjectclass_id"," and sc.year_id = $o->year_id and sc.session_id = $o->session_id ","subjectclass_id",$o->subjectwidth,"Y",0);
        $o->subjectctrl=$ctrl->getSelectSubject($o->subject_id,"Y","","subject_id","","subject_id","$o->subjectwidth","Y",0);
        $o->getEditForm($token,"update");
        
		//$o->getInputForm("edit",$o->generateinvoice,$token);
		//$o->showGenerateinvoiceTable("WHERE a.generatestudentinvoice_id>0 and a.organization_id=$defaultorganization_id","ORDER BY defaultlevel");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("generateinvoice.php",3,"Some error on viewing your generateinvoice data, probably database corrupted");
  
break;

//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
        
		if($o->updateGenerateinvoice()){ //if data save successfully
            $log->saveLog($o->generatestudentinvoice_id,$tablegenerateinvoice,"$o->changesql","U","O");
			redirect_header("generateinvoice.php?action=edit&generatestudentinvoice_id=$o->generatestudentinvoice_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->generatestudentinvoice_id,$tablegenerateinvoice,"$o->changesql","U","F");
			redirect_header("generateinvoice.php?action=edit&generatestudentinvoice_id=$o->generatestudentinvoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog($o->generatestudentinvoice_id,$tablegenerateinvoice,"$o->changesql","U","F");
		redirect_header("generateinvoice.php?action=edit&generatestudentinvoice_id=$o->generatestudentinvoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteGenerateinvoice($o->generatestudentinvoice_id)){
            $log->saveLog($o->generatestudentinvoice_id,$tablegenerateinvoice,"$o->changesql","D","O");
			redirect_header("generateinvoice.php",$pausetime,"Data removed successfully.");
        }else{
            $log->saveLog($o->generatestudentinvoice_id,$tablegenerateinvoice,"$o->changesql","D","F");
			redirect_header("generateinvoice.php?action=edit&generatestudentinvoice_id=$o->generatestudentinvoice_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else
		redirect_header("generateinvoice.php?action=edit&generatestudentinvoice_id=$o->generatestudentinvoice_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

    case "search" :
    $token=$s->createToken($tokenlife,"CREATE_ACG");

	$wherestr =" WHERE gi.generatestudentinvoice_id > 0 ";
    $wheresubject = "";
	if($o->issearch == "Y"){
	$wherestr .= $o->getWhereStr();
    }else{
	$o->year_id = 0;
    $o->session_id = 0;
    $o->course_id = 0;
    $o->student_id=0;
	}

     if($o->year_id=="")
    $o->year_id=0;
    if($o->session_id=="")
    $o->session_id=0;
    if($o->course_id=="")
    $o->course_id=0;
    if($o->student_id=="")
    $o->student_id=0;
    if($o->semester_id=="")
    $o->semester_id=0;


    //echo $o->issearch;
    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
    $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","$wherestudent","student_id","$o->stylewidthstudent","Y",0);

	$o->showSearchForm();
	if($o->issearch == "Y"){
	$o->showListSet($wherestr,$token,$dp);
    }
    
  break;

  case "updateclosing" :

      if($_POST['isclosed_line'] == "true")
      $value = 1;
      else
      $value = 0;

      if($o->updateClosing($o->generatestudentinvoice_id,$value)){
      $log->saveLog($o->generatestudentinvoice_id,$tablegenerateinvoice,"$o->changesql","U","O");
      }else{
      $log->saveLog($o->generatestudentinvoice_id,$tablegenerateinvoice,"$o->changesql","U","F");
      }
  break;

  case "addnew" :
        if($o->year_id=="")
        $o->year_id=0;
        if($o->session_id=="")
        $o->session_id=0;
         if($o->employee_id=="")
        $o->employee_id=0;
         if($o->lecturerroom_id=="")
        $o->lecturerroom_id=0;
         if($o->subjectclass_id=="")
        $o->subjectclass_id=0;

      $token=$s->createToken($tokenlife,"CREATE_ACG");

		//$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"N");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"N");
        $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"N");
        $o->lecturerroomctrl=$ctrl->getSelectLecturerroom($o->lecturerroom_id,"N");
        $o->subjectclassctrl=$ctrl->getSelectSubjectclass($o->subjectclass_id,"Y","","subjectclass_id"," and sc.year_id = $o->year_id and sc.session_id = $o->session_id ","subjectclass_id",$o->subjectwidth,"Y",0);
        $o->subjectctrl=$ctrl->getSelectSubject($o->subject_id,"Y","","subject_id","","subject_id","$o->subjectwidth","Y",0);
        $o->getEditForm($token,"createnew");
        
  break;

 case "createnew" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with generateinvoice name=$o->generateinvoice_name");

	if ($s->check(false,$token,"CREATE_ACG")){



	if($o->insertGenerateinvoice()){
		 $latest_id=$o->getLatestGenerateinvoiceID();
         $log->saveLog($latest_id,$tablegenerateinvoice,"$o->changesql","I","O");
			 redirect_header("generateinvoice.php?action=edit&generatestudentinvoice_id=$latest_id",$pausetime,"Your data is saved.");
		}
	else {
        $log->saveLog(0,$tablegenerateinvoice,"$o->changesql","I","F");
	    $token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->yearctrl=$ctrl->getSelectYear($o->year_id,"N");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"N");
        $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"N");
        $o->lecturerroomctrl=$ctrl->getSelectLecturerroom($o->lecturerroom_id,"N");
        $o->subjectclassctrl=$ctrl->getSelectSubjectclass($o->subjectclass_id,"Y","","subjectclass_id"," and sc.year_id = $o->year_id and sc.session_id = $o->session_id ","subjectclass_id",$o->subjectwidth,"Y",0);
        $o->subjectctrl=$ctrl->getSelectSubject($o->subject_id,"Y","","subject_id","","subject_id","$o->subjectwidth","Y",0);
        $o->getEditForm($token,"createnew");
		//$o->getInputForm("new",-1,$token);
		//$o->showGenerateinvoiceTable("WHERE a.generatestudentinvoice_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
        $log->saveLog(0,$tablegenerateinvoice,"$o->changesql","I","F");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->yearctrl=$ctrl->getSelectYear($o->year_id,"N");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"N");
        $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"N");
        $o->lecturerroomctrl=$ctrl->getSelectLecturerroom($o->lecturerroom_id,"N");
        $o->subjectclassctrl=$ctrl->getSelectSubjectclass($o->subjectclass_id,"Y","","subjectclass_id"," and sc.year_id = $o->year_id and sc.session_id = $o->session_id ","subjectclass_id",$o->subjectwidth,"Y",0);
        $o->subjectctrl=$ctrl->getSelectSubject($o->subject_id,"Y","","subject_id","","subject_id","$o->subjectwidth","Y",0);
        $o->getEditForm($token,"createnew");
		//$o->getInputForm("new",-1,$token);
		//$o->showGenerateinvoiceTable("WHERE a.generatestudentinvoice_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel");
	}

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

	$selectionlist = $o->getSelectDBAjax($strchar,$idinput,$idlayer,$ctrlid,$ocf,$o->tablesubjectclass,"sc.subjectclass_id","sb.subject_name","$wherestr","$line");

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

  case "getlistdbemployee" :
	$strchar = $_POST["strchar"];
	$idinput = $_POST["idinput"];
	$idlayer = $_POST["idlayer"];
	$ctrlid = $_POST["ctrlid"];
	$ocf = $_POST["ocf"];
	$line = $_POST["line"];
    $wherestr = $_POST["wherestr"];
    $wherestr = str_replace("#"," ",$wherestr);
    $wherestr = str_replace("*","'",$wherestr);

	$selectionlist = $o->getSelectDBAjaxEmployee($strchar,$idinput,$idlayer,$ctrlid,$ocf,$o->tableemployee,"employee_id","employee_name","$wherestr",0);

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;
  
  case "showlist" :

    $token=$s->createToken($tokenlife,"CREATE_ACG");

    $token=$s->createToken($tokenlife,"CREATE_ACG");
    $o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->subjectclassctrl=$ctrl->getSelectSubjectclass($o->subjectclass_id,"Y","","subjectclass_id"," and sc.year_id = $o->year_id and sc.session_id = $o->session_id ","subjectclass_id",$o->subjectwidth,"Y",0);
    $o->subjectctrl=$ctrl->getSelectSubject($o->subject_id,"Y","","subject_id","","subject_id","$o->subjectwidth","Y",0);
    $o->getInputForm("new",0,$token);

    $o->showListSet($token);
  
  break;



  case "viewallresult" :

    $isview = $_GET['isview'];

    if($isview == 1)
    $token= "";
    else
    $token=$s->createToken($tokenlife,"CREATE_ACG");
    
    $o->showAllResult($o->student_id,$token);
    
  break;


  case "voidinvoice" :
      if ($s->check(false,$token,"CREATE_ACG")){

        
        if($o->voidInvoice($o->generatestudentinvoice_id)){
            $log->saveLog(0,$tablegeneratestudentinvoice,"$o->changesql","U","O");
        }else{
            echo "<b><font color=red>$o->txtwarning</font></b>";
            $log->saveLog(0,$tablegeneratestudentinvoice,"$o->changesql","U","F");
        }
      }else{
            echo "<b><font color=red>$o->txtwarning</font></b>";
            $log->saveLog(0,$tablegeneratestudentinvoice,"$o->changesql","U","F");
      }

    $token=$s->createToken($tokenlife,"CREATE_ACG");

    $wherestr =" WHERE gi.generatestudentinvoice_id > 0 ";
    $wheresubject = "";
    if($o->issearch == "Y"){
    $wherestr .= $o->getWhereStr();
    }else{
    $o->year_id = 0;
    $o->session_id = 0;
    $o->course_id = 0;
    $o->student_id=0;
    }

    if($o->year_id=="")
    $o->year_id=0;
    if($o->session_id=="")
    $o->session_id=0;
    if($o->course_id=="")
    $o->course_id=0;
    if($o->student_id=="")
    $o->student_id=0;
    if($o->semester_id=="")
    $o->semester_id=0;


    //echo $o->issearch;
    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
    $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","$wherestudent","student_id","$o->stylewidthstudent","Y",0);

    $o->showSearchForm();
    if($o->issearch == "Y"){
    $o->showListSet($wherestr,$token,$dp);
    }

  break;

  case "viewsetinvoice" :
     if($o->year_id=="")
    $o->year_id=0;
    if($o->session_id=="")
    $o->session_id=0;
    if($o->course_id=="")
    $o->course_id=0;
    if($o->student_id=="")
    $o->student_id=0;
    if($o->semester_id=="")
    $o->semester_id=0;


    //echo $o->issearch;
    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
    $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","$wherestudent","student_id","$o->stylewidthstudent","Y",0);

    $o->showSearchForm();

    $o->showListCourse($o->generatestudentinvoice_id);
  break;

  case "viewstudentinvoice" :
    if($o->year_id=="")
    $o->year_id=0;
    if($o->session_id=="")
    $o->session_id=0;
    if($o->course_id=="")
    $o->course_id=0;
    if($o->student_id=="")
    $o->student_id=0;
    if($o->semester_id=="")
    $o->semester_id=0;


    //echo $o->issearch;
    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
    $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","$wherestudent","student_id","$o->stylewidthstudent","Y",0);

    $o->showSearchForm();

    $o->showListStudent($o->generatestudentinvoice_id,$o->course_id);
  break;

  case "publishsetinvoice" :
      $ispublish = $_POST['ispublish'];

      if($o->publishSetInvoice($o->generatestudentinvoice_id,$ispublish)){

          if($studentinv->completeSetInvoice($o->generatestudentinvoice_id,$ispublish,$api,$xoopsUser)){
              //echo "<script type='text/javascript'>alert()</script>";
          }
          $log->saveLog(0,$tablegeneratestudentinvoice,"$o->changesql","U","O");
      }else{
          $log->saveLog(0,$tablegeneratestudentinvoice,"$o->changesql","U","F");
      }

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.forms['frmListAll'].action.value = "search";
    	self.parent.document.forms['frmListAll'].submit();
	</script>
EOF;
                                                                            
  break;
  default :
    if($o->year_id=="")
    $o->year_id=0;
    if($o->session_id=="")
    $o->session_id=0;
        if($o->subject_id=="")
    $o->subject_id=0;
    
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->subjectclassctrl=$ctrl->getSelectSubjectclass($o->subjectclass_id,"Y","","subjectclass_id"," and sc.year_id = $o->year_id and sc.session_id = $o->session_id ","subjectclass_id",$o->subjectwidth,"Y",0);
    $o->subjectctrl=$ctrl->getSelectSubject($o->subject_id,"Y","","subject_id","","subject_id","$o->subjectwidth","Y",0);
	$o->getInputForm("new",0,$token);
	//$o->showGenerateinvoiceTable("WHERE a.generatestudentinvoice_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once 'class/Student.php';
//include_once 'class/SelectCtrl.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';


//$log = new Log();
$o = new Student();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

//marhan add here --> ajax
echo "<iframe src='student.php' name='nameValidate' id='idValidate' width='70%' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">

function viewTempAddress(value){

if(value==1)
document.getElementById('idTempAddress').style.display = "none";
else
document.getElementById('idTempAddress').style.display = "";

}

function checkSelectedTemplate(){

studentletter_id = document.forms['frmShowLetter'].studentletter_id.value;

    if(studentletter_id == 0){
    alert('Please Select Template.');
    return false;
    }else{
    return true;
    }
}

function generateLetter(){

    var istrue = false;
    var i=0;
    while(i< document.forms['frmListTable'].elements.length){
    var ctlname = document.forms['frmListTable'].elements[i].name;
    var data = document.forms['frmListTable'].elements[i].value;
    var ctltrue = document.forms['frmListTable'].elements[i].checked;



    ctlname = ctlname.substring(0,ctlname.indexOf("["))
    if(ctlname=="isselected"){

            if(ctltrue == true)
            istrue = true;

    }

    i++;

    }


    if(istrue == false){
    alert("Please Select Student");
    }else{
    document.forms['frmListTable'].submit();
    }

}

function selectAll(val){

    var i=0;
    while(i< document.forms['frmListTable'].elements.length){
    var ctlname = document.forms['frmListTable'].elements[i].name;
    var data = document.forms['frmListTable'].elements[i].value;

    ctlname = ctlname.substring(0,ctlname.indexOf("["))
    if(ctlname=="isselected"){

    document.forms['frmListTable'].elements[i].checked = val;
    }

    i++;

}


}


function previewDisciplineLine(studentdisciplineline_id){

window.open("viewstudentdiscipline.php?action=printpreview&studentdisciplineline_id="+studentdisciplineline_id);
}

function gotoNew(){
self.location = "student.php?action=new";
}

function gotoSearch(){
self.location = "student.php?action=search";
}

function backToStudentProfile(student_id){

self.location = "student.php?tab_id=4&action=edit&student_id="+student_id;
}

function editDisciplineLine(studentdisciplineline_id,student_id){

self.location = "student.php?action=editdiscipline&studentdisciplineline_id="+studentdisciplineline_id+"&student_id="+student_id;

}


function deleteLoanLine(studentloanline_id){

    if(confirm('Please Save Before Add Line. Continue To Delete Line?')){
        document.forms['frmStudent'].action.value = "deleteloanline";
        document.forms['frmStudent'].deleteloanline_id.value = studentloanline_id;
        document.forms['frmStudent'].submit();
    }else{
    }
}

function deleteDisciplineLine(studentdisciplineline_id){

    if(confirm('Please Save Before Add Line. Continue To Delete Line?')){
        document.forms['frmStudent'].action.value = "deletedisciplineline";
        document.forms['frmStudent'].deletedisciplineline_id.value = studentdisciplineline_id;
        document.forms['frmStudent'].submit();
    }else{
    }
}

function viewDisciplineDesc(line){
    var txt = document.getElementById('txtDiscTxt'+line).innerHTML;

    post = txt.indexOf("Hide");

    if(parseFloat(post) < 0){

    document.getElementById('txtDiscTxt'+line).innerHTML = "Hide Description";
    document.getElementById('idDisciplineDesc'+line).style.display = "";
    }else{

    document.getElementById('txtDiscTxt'+line).innerHTML = "View Description";
    document.getElementById('idDisciplineDesc'+line).style.display = "none";
    }
}

function checkFormDiscipline(){

    studentdiscipline_keydate = document.forms['frmDiscipline'].studentdiscipline_keydate.value;
    studentdiscipline_date = document.forms['frmDiscipline'].studentdiscipline_date.value;

    if(confirm("Save Discipline Record?")){
        if(!isDate(studentdiscipline_keydate) || !isDate(studentdiscipline_date))
        return false;
        else
        return true;
    }else{
    return false;
    }
}

function addDisciplineLine(student_id){
//window.open("student.php?action=adddiscipline&student_id="+student_id);

if(confirm('Please Save Before Add Line. Continue?')){
self.location = "student.php?action=adddiscipline&student_id="+student_id;
}

}

function addLoanLine(){
    semester_addline = document.forms['frmStudent'].semester_addline.value;
    amount_addline = document.forms['frmStudent'].amount_addline.value;

    if(confirm('Please Save Before Add Line. Continue?')){

        if(semester_addline == 0 || amount_addline == "" || !IsNumeric(amount_addline)){
        alert("Please Select Semester & Amount");
        return false;
        }else{
        document.forms['frmStudent'].action.value = "addloanline";
        document.forms['frmStudent'].submit();
        }
    }else{
    }
}

function deleteSPMSubject(studentspm_id){

    if(confirm('Please Save Before Add Line. Continue To Delete Line?')){
        document.forms['frmStudent'].action.value = "deletespmline";
        document.forms['frmStudent'].deletespmline_id.value = studentspm_id;
        document.forms['frmStudent'].submit();
    }else{
    }
}

function addSPMLine(){

    if(confirm('Please Save Before Add Line. Continue?')){
        document.forms['frmStudent'].action.value = "addspmline";
        document.forms['frmStudent'].submit();
    }else{
    }
}

function viewTabDetailsTxt(){
tdt = (self.parent.document.getElementById("txtViewID").innerHTML).toString();

if(self.parent.document.getElementById("txtViewID").innerHTML == "View Details &gt;&gt;" || tdt.indexOf("View Details") != -1){
self.parent.document.getElementById("txtViewID").innerHTML = "View Header &gt;&gt";
self.parent.document.getElementById("idTblHeader").style.display = "none";
document.getElementById("tdDelete").style.display = "none";
viewTabDetails(1);

}else{
self.parent.document.getElementById("txtViewID").innerHTML = "View Details &gt;&gt";
self.parent.document.getElementById("idTblHeader").style.display = "";
document.getElementById("tdDelete").style.display = "";
viewTabDetails(0);
}

}

function viewTabDetails(tab_id){

document.forms['frmStudent'].tab_id.value = tab_id;

document.getElementById("idTab1").style.display = "none";
document.getElementById("idTab2").style.display = "none";
self.parent.document.getElementById("idTab3").style.display = "none";
self.parent.document.getElementById("idTab4").style.display = "none";

if(tab_id > 0){
document.getElementById("idTblHeader").style.display = "none";
document.getElementById("tdDelete").style.display = "none";

document.getElementById("idTab"+tab_id).style.display = "";
}

/*
document.forms['frmStudent'].tab_id.value = tab_id;
var arr_fld=new Array("action","tab_id");//name for POST
var arr_val=new Array("viewtabdetails",tab_id);//value for POST

getRequest(arr_fld,arr_val);
*/

}

function resetpassword(student_id){

var arr_fld=new Array("action","student_id");//name for POST
var arr_val=new Array("resetpassword",student_id);//value for POST

getRequest(arr_fld,arr_val);
}

function autofocus(){
document.forms['frmStudent'].student_name.focus();
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


	function validateStudent(){
		
		var name=document.forms['frmStudent'].student_name.value;
		var defaultlevel=document.forms['frmStudent'].defaultlevel.value;
        var course_id=document.forms['frmStudent'].course_id.value;
        var year_id=document.forms['frmStudent'].year_id.value;
        var session_id=document.forms['frmStudent'].session_id.value;
		var student_no=document.forms['frmStudent'].student_no.value;
        var student_newicno=document.forms['frmStudent'].student_newicno.value;
        var student_dob=document.forms['frmStudent'].student_dob.value;
        var student_hpno=document.forms['frmStudent'].student_hpno.value;
        var total_loan=document.forms['frmStudent'].total_loan.value;
        var student_postpone=document.forms['frmStudent'].student_postpone.value;
        var studentfather_salary=document.forms['frmStudent'].studentfather_salary.value;
        var studentmother_salary=document.forms['frmStudent'].studentmother_salary.value;
        var studenthier_salary=document.forms['frmStudent'].studenthier_salary.value;
	
			
		if(confirm("Save record?")){
		if(student_hpno == "" || student_newicno == "" || name =="" || !IsNumeric(defaultlevel) || defaultlevel=="" || student_no =="" || !IsNumeric(total_loan) || total_loan=="" || !IsNumeric(student_postpone) || student_postpone==""){
			alert('Please make sure Student Name, Matrix No, IC No, HP No is filled in, Default Level and Total Loan filled with numeric value');
            self.parent.document.getElementById("idTblHeader").style.display = "";
			return false;
		}
		else{
                if(course_id == 0 || year_id == 0  || session_id == 0 ){
                self.parent.document.getElementById("idTblHeader").style.display = "";
                alert("Please make sure Course, Year & Session is selected.");
                return false;
                }else{
                        if(!isDate(student_dob)){
                        self.parent.document.getElementById("idTblHeader").style.display = "";
                        return false;
                        }
                        else{
                            if(!IsNumeric(studentfather_salary) || studentfather_salary=="" || !IsNumeric(studentmother_salary) || studentmother_salary=="" ||!IsNumeric(studenthier_salary) || studenthier_salary==""){
                            self.parent.document.getElementById("idTblHeader").style.display = "";
                            alert("Please make sure Salary is filled with numeric value.");
                            return false;
                             }else
                            return true;
                        }

                }
                
            }
		}
		else
			return false;
	}
function gotoAction(action){
	document.forms['frmStudent'].action.value = action;
	document.forms['frmStudent'].submit();
	}

</script>

EOF;

$o->student_id=0;
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

if(isset($_POST["tab_id"]))
$o->tab_id=$_POST["tab_id"];
else
$o->tab_id=$_GET["tab_id"];

$o->student_name=$_POST["student_name"];
$o->student_no=$_POST["student_no"];

$o->student_newicno=$_POST['student_newicno'];
$o->student_oldicno=$_POST['student_oldicno'];
$o->ishostel=$_POST['ishostel'];
$o->student_tempaddress=$_POST['student_tempaddress'];
$o->student_address=$_POST['student_address'];
$o->gender=$_POST['gender'];
$o->student_postcode=$_POST['student_postcode'];
$o->student_state=$_POST['student_state'];
$o->student_city=$_POST['student_city'];
$o->country_id=$_POST['country_id'];
$o->student_telno=$_POST['student_telno'];
$o->student_hpno=$_POST['student_hpno'];
$o->religion_id=$_POST['religion_id'];
$o->races_id=$_POST['races_id'];
$o->uid=$_POST['uid'];
$o->email=$_POST['email'];
$o->marital_status=$_POST['marital_status'];
$o->loantype_id=$_POST['loantype_id'];
$o->total_loan=$_POST['total_loan'];
$o->student_postpone=$_POST['student_postpone'];
$o->studentpostpone_remarks=$_POST['studentpostpone_remarks'];

$o->filephoto=$_POST['filephoto'];
$o->fileic=$_POST['fileic'];
$o->filespm=$_POST['filespm'];

$o->spm_year=$_POST['spm_year'];
$o->spm_school=$_POST['spm_school'];
$o->year_id=$_POST['year_id'];
$o->session_id=$_POST['session_id'];
$o->course_id=$_POST['course_id'];
$o->student_dob=$_POST['student_dob'];

$isuitmstudent=$_POST['isuitmstudent'];
$isbumiputerastudent=$_POST['isbumiputerastudent'];
$isactive=$_POST['isactive'];
$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

// details parents
$o->studentfather_name=$_POST['studentfather_name'];
$o->studentfather_newic=$_POST['studentfather_newic'];
$o->studentfather_oldic=$_POST['studentfather_oldic'];
$o->studentfather_address=$_POST['studentfather_address'];
$o->studentfather_postcode=$_POST['studentfather_postcode'];
$o->studentfather_state=$_POST['studentfather_state'];
$o->studentfather_city=$_POST['studentfather_city'];
$o->studentfather_country=$_POST['studentfather_country'];
$o->studentfather_telno=$_POST['studentfather_telno'];
$o->studentfather_hpno=$_POST['studentfather_hpno'];
$o->studentfather_salary=$_POST['studentfather_salary'];
$o->studentfather_description=$_POST['studentfather_description'];
$o->studentmother_name=$_POST['studentmother_name'];
$o->studentmother_newic=$_POST['studentmother_newic'];
$o->studentmother_oldic=$_POST['studentmother_oldic'];
$o->studentmother_address=$_POST['studentmother_address'];
$o->studentmother_postcode=$_POST['studentmother_postcode'];
$o->studentmother_state=$_POST['studentmother_state'];
$o->studentmother_city=$_POST['studentmother_city'];
$o->studentmother_country=$_POST['studentmother_country'];
$o->studentmother_telno=$_POST['studentmother_telno'];
$o->studentmother_hpno=$_POST['studentmother_hpno'];
$o->studentmother_salary=$_POST['studentmother_salary'];
$o->studentmother_description=$_POST['studentmother_description'];
$o->studenthier_name=$_POST['studenthier_name'];
$o->studenthier_newic=$_POST['studenthier_newic'];
$o->studenthier_oldic=$_POST['studenthier_oldic'];
$o->studenthier_address=$_POST['studenthier_address'];
$o->studenthier_postcode=$_POST['studenthier_postcode'];
$o->studenthier_state=$_POST['studenthier_state'];
$o->studenthier_city=$_POST['studenthier_city'];
$o->studenthier_country=$_POST['studenthier_country'];
$o->studenthier_telno=$_POST['studenthier_telno'];
$o->studenthier_hpno=$_POST['studenthier_hpno'];
$o->studenthier_salary=$_POST['studenthier_salary'];
$o->studenthier_description=$_POST['studenthier_description'];

// SPM result line
$o->subjectspm_id=$_POST['subjectspm_id'];
$o->studentspm_id=$_POST['studentspm_id'];
$o->result_name=$_POST['result_name'];
$o->result_type=$_POST['result_type'];
$o->deletespmline_id=$_POST['deletespmline_id'];
$o->gradelevel_id=$_POST['gradelevel_id'];
//end

// Loan result line
$o->studentloanline_id=$_POST['studentloanline_id'];
$o->semester_id=$_POST['semester_id'];
$o->line_amt=$_POST['line_amt'];
$o->descriptionline=$_POST['descriptionline'];
$o->deleteloanline_id=$_POST['deleteloanline_id'];
$o->semester_addline=$_POST['semester_addline'];
$o->amount_addline=$_POST['amount_addline'];
//end

// Discipline

if(isset($_POST['studentdisciplineline_id']))
$o->studentdisciplineline_id=$_POST['studentdisciplineline_id'];
else
$o->studentdisciplineline_id=$_GET['studentdisciplineline_id'];

$o->studentdiscipline_date=$_POST['studentdiscipline_date'];
$o->studentdiscipline_place=$_POST['studentdiscipline_place'];
$o->studentdiscipline_keydate=$_POST['studentdiscipline_keydate'];
$o->witness_name=$_POST['witness_name'];
$o->witness_icno=$_POST['witness_icno'];
$o->descriptionline=$_POST['descriptionline'];
//end

$o->dobdatectrl=$dp->show("student_dob");
$o->studentdiscipline_keydatectrl=$dp->show("studentdiscipline_keydate");
$o->studentdiscipline_datectrl=$dp->show("studentdiscipline_date");

$o->issearch=$_POST['issearch'];

if ($isactive=="1" || $isactive=="on")
	$o->isactive=1;
else if ($isactive=="null")
	$o->isactive="null";
else
	$o->isactive=0;

if ($isuitmstudent=="1" || $isuitmstudent=="on")
	$o->isuitmstudent=1;
else if ($isuitmstudent=="null")
	$o->isuitmstudent="null";
else
	$o->isuitmstudent=0;

if ($isbumiputerastudent=="1" || $isbumiputerastudent=="on")
	$o->isbumiputerastudent=1;
else if ($isbumiputerastudent=="null")
	$o->isbumiputerastudent="null";
else
	$o->isbumiputerastudent=0;

// photo attachment
$o->filephototmp= $_FILES["filephoto"]["tmp_name"];
$o->filephotosize=$_FILES["filephoto"]["size"];
$o->filephototype=$_FILES["filephoto"]["type"];
$o->filephotoname=$_FILES["filephoto"]["name"];
$file_ext_photo = strrchr($o->filephotoname, '.');

// photo ic
$o->fileictmp= $_FILES["fileic"]["tmp_name"];
$o->fileicsize=$_FILES["fileic"]["size"];
$o->fileictype=$_FILES["fileic"]["type"];
$o->fileicname=$_FILES["fileic"]["name"];
$file_ext_ic = strrchr($o->fileicname, '.');

// photo spm
$o->filespmtmp= $_FILES["filespm"]["tmp_name"];
$o->filespmsize=$_FILES["filespm"]["size"];
$o->filespmtype=$_FILES["filespm"]["type"];
$o->filespmname=$_FILES["filespm"]["name"];
$file_ext_spm = strrchr($o->filespmname, '.');

$o->deleteAttachmentPhoto=$_POST["deleteAttachmentPhoto"];
$o->deleteAttachmentIc=$_POST["deleteAttachmentIc"];
$o->deleteAttachmentSpm=$_POST["deleteAttachmentSpm"];
$o->createnewrecord=$_POST["createnewrecord"];

//generate letter
$o->studentarr_id=$_POST["studentarr_id"];
$o->isselected=$_POST["isselected"];

$o->showtempcoloumn=$_POST["showtempcoloumn"];


$widthuser = "style= 'width:200px' ";

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with student name=$o->student_name");

	if ($s->check(false,$token,"CREATE_ACG")){
		
		
		
	if($o->insertStudent()){
		 $latest_id=$o->getLatestStudentID();
         $log->saveLog($latest_id,$tablestudent,"$o->changesql","I","O");
        $o->student_id = $latest_id;
        
            $filephotonamenew=$o->student_id."_photo".$file_ext_photo;
            $fileicnamenew=$o->student_id."_ic".$file_ext_ic;
            $filespmnamenew=$o->student_id."_spm".$file_ext_spm;

            if($o->filephotosize>0 && $file_ext_photo == ".jpg")
            $o->savefile($o->filephototmp,$filephotonamenew,$o->student_id,"filephoto");
            if($o->fileicsize>0 && $file_ext_ic == ".jpg")
            $o->savefile($o->fileictmp,$fileicnamenew,$o->student_id,"fileic");
            if($o->filespmsize>0 && $file_ext_spm == ".jpg")
            $o->savefile($o->filespmtmp,$filespmnamenew,$o->student_id,"filespm");

            if($o->createnewrecord == "on")
			redirect_header("student.php",$pausetime,"Your data is saved. Create More Records");
            else
            redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Your data is saved.");
		}
	else {
        $log->saveLog(0,$tablestudent,"$o->changesql","I","F");
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
        $o->racesctrl=$ctrl->getSelectRaces($o->races_id,'N');
        $o->religionctrl=$ctrl->getSelectReligion($o->religion_id,'N');
        $o->countryctrl=$ctrl->getSelectCountry($o->country_id,'N');
        $o->loantypectrl=$ctrl->getSelectLoantype($o->loantype_id,'Y');
        $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        $o->countrymotherctrl=$ctrl->getSelectCountry($o->studentmother_country,'N','studentmother_country');
        $o->countryfatherctrl=$ctrl->getSelectCountry($o->studentfather_country,'N','studentfather_country');
        $o->countryhierctrl=$ctrl->getSelectCountry($o->studenthier_country,'N','studenthier_country');
        $o->uidctrl=$permission->selectAvailableSysUser($o->uid,'Y',"uid",""," and isstudent = 1 ","uid",$widthuser,"Y",0);
		$o->getInputForm("new",-1,$token);
		$o->showStudentTable("WHERE a.student_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,a.student_no");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
        $log->saveLog(0,$tablestudent,"$o->changesql","I","F");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
        $o->racesctrl=$ctrl->getSelectRaces($o->races_id,'N');
        $o->religionctrl=$ctrl->getSelectReligion($o->religion_id,'N');
        $o->countryctrl=$ctrl->getSelectCountry($o->country_id,'N');
        $o->loantypectrl=$ctrl->getSelectLoantype($o->loantype_id,'Y');
        $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        $o->countrymotherctrl=$ctrl->getSelectCountry($o->studentmother_country,'N','studentmother_country');
        $o->countryfatherctrl=$ctrl->getSelectCountry($o->studentfather_country,'N','studentfather_country');
        $o->countryhierctrl=$ctrl->getSelectCountry($o->studenthier_country,'N','studenthier_country');
        $o->uidctrl=$permission->selectAvailableSysUser($o->uid,'Y',"uid",""," and isstudent = 1 ","uid",$widthuser,"Y",0);
		$o->getInputForm("new",-1,$token);
		$o->showStudentTable("WHERE a.student_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,a.student_no");
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchStudent($o->student_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
        $o->racesctrl=$ctrl->getSelectRaces($o->races_id,'N');
        $o->religionctrl=$ctrl->getSelectReligion($o->religion_id,'N');
        $o->countryctrl=$ctrl->getSelectCountry($o->country_id,'N');
        $o->loantypectrl=$ctrl->getSelectLoantype($o->loantype_id,'Y');
        $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        $o->countrymotherctrl=$ctrl->getSelectCountry($o->studentmother_country,'N','studentmother_country');
        $o->countryfatherctrl=$ctrl->getSelectCountry($o->studentfather_country,'N','studentfather_country');
        $o->countryhierctrl=$ctrl->getSelectCountry($o->studenthier_country,'N','studenthier_country');
        $o->uidctrl=$permission->selectAvailableSysUser($o->uid,'Y',"uid",""," and isstudent = 1 ","uid",$widthuser,"Y",0);
        
		$o->getInputForm("edit",$o->student,$token);
		//$o->showStudentTable("WHERE a.student_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,a.student_no");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("student.php",3,"Some error on viewing your student data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateStudent()){ //if data save successfully
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","U","O");
            $o->updateEmail();
            $filephotonamenew=$o->student_id."_photo".$file_ext_photo;
            $fileicnamenew=$o->student_id."_ic".$file_ext_ic;
            $filespmnamenew=$o->student_id."_spm".$file_ext_spm;


            if($o->filephotosize>0 && $file_ext_photo == ".jpg")
            $o->savefile($o->filephototmp,$filephotonamenew,$o->student_id,"filephoto");
            if($o->fileicsize>0 && $file_ext_ic == ".jpg")
            $o->savefile($o->fileictmp,$fileicnamenew,$o->student_id,"fileic");
            if($o->filespmsize>0 && $file_ext_spm == ".jpg")
            $o->savefile($o->filespmtmp,$filespmnamenew,$o->student_id,"filespm");

            
            if($o->deleteAttachmentPhoto == "on")
            $o->deletefile($o->student_id,"filephoto");
            if($o->deleteAttachmentIc == "on")
            $o->deletefile($o->student_id,"fileic");
            if($o->deleteAttachmentSpm == "on")
            $o->deletefile($o->student_id,"filespm");

            $isfailed = false;

		/*
            //update spm details
            if(count($o->studentspm_id) > 0){

                if($o->updateSPMResult()){
                    $log->saveLog($o->student_id,$tablestudent,"$o->changesql","U","O");
                }else{
                    $isfailed = true;
                    $log->saveLog($o->student_id,$tablestudent,"$o->changesql","U","F");
                }
                
            }
		*/

            
            //update loan details
            if(count($o->studentloanline_id) > 0){

                if($o->updateLoan()){
                    $log->saveLog($o->student_id,$tablestudent,"$o->changesql","U","O");
                }else{
                    $isfailed = true;
                    $log->saveLog($o->student_id,$tablestudent,"$o->changesql","U","F");
                }

            }//end
            

            if($isfailed == false){
                if($o->createnewrecord == "on")
                redirect_header("student.php",$pausetime,"Your data is saved. Create More Records");
                else
                redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Your data is saved.");
            }else{
                redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
            }

           
        }else{
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","U","F");
			redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog($o->student_id,$tablestudent,"$o->changesql","U","F");
		redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteStudent($o->student_id,$o->student_no)){
            $o->deletefile2($o->student_id."_photo.jpg");
            $o->deletefile2($o->student_id."_ic.jpg");
            $o->deletefile2($o->student_id."_spm.jpg");
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","D","O");
			redirect_header("student.php",$pausetime,"Data removed successfully.");
        }else{
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","D","F");
			redirect_header("student.php?action=edit&student_id=$o->student_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else
		redirect_header("student.php?action=edit&student_id=$o->student_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

    

case "viewtabdetails" :
$tabdetails = "";

$tab_id = $_POST['tab_id'];

echo <<< EOF
<script type="text/javascript">

self.parent.document.getElementById("idTab1").style.display = "none";
self.parent.document.getElementById("idTab2").style.display = "none";
//self.parent.document.getElementById("idTab3").style.display == "none";
//self.parent.document.getElementById("idTab4").style.display == "none";

if($tab_id > 0){
self.parent.document.getElementById("idTblHeader").style.display = "none";
self.parent.document.getElementById("idTab$tab_id").style.display = "";
}


/*
if(self.parent.document.getElementById("idTab$tab_id").style.display == "none"){
self.parent.document.getElementById("idTab$tab_id").style.display = "";
self.parent.document.getElementById("txtViewID").innerHTML = "Hide Details >>";
}else{
self.parent.document.getElementById("idTab$tab_id").style.display = "none";
self.parent.document.getElementById("txtViewID").innerHTML = "View Details >>";
}*/

</script>
EOF;
break;

  case "getlistdbuser" :
	$strchar = $_POST["strchar"];
	$idinput = $_POST["idinput"];
	$idlayer = $_POST["idlayer"];
	$ctrlid = $_POST["ctrlid"];
	$ocf = $_POST["ocf"];
	$line = $_POST["line"];
    $wherestr = $_POST["wherestr"];
    $wherestr = str_replace("#"," ",$wherestr);
    $wherestr = str_replace("*","'",$wherestr);

    $wherestr .= " and isstudent = 1 ";

	$selectionlist = $o->getSelectDBAjax($strchar,$idinput,$idlayer,$ctrlid,$ocf,$o->tableusers,"uid","name","$wherestr",0);

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;

  case "addspmline" :

      $add_line = $_POST['addLine'];

      if($o->addSPMLine($add_line)){
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","I","O");
            redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Line add successfully.");
      }else{
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","I","F");
            redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Failed To Add Line.");
      }

  break;

   case "addloanline" :

      if($o->addLoanLine()){
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","I","O");
            redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Line add successfully.");
      }else{
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","I","F");
            redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Failed To Add Line.");
      }

  break;

  case "deletespmline" :

      $deletespmline_id = $_POST['deletespmline_id'];

      if($o->deleteSPMLine($deletespmline_id)){
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","D","O");
            redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Line Deleted successfully.");
      }else{
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","D","F");
            redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Failed To Delete Line.");
      }

  break;

  case "deleteloanline" :

      $deleteloanline_id = $_POST['deleteloanline_id'];

      if($o->deleteLoanLine($deleteloanline_id)){
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","D","O");
            redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Line Deleted successfully.");
      }else{
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","D","F");
            redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Failed To Delete Line.");
      }

  break;

  case "deletedisciplineline" :

      $deletedisciplineline_id = $_POST['deletedisciplineline_id'];

      if($o->deleteDisciplineLine($deletedisciplineline_id)){
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","D","O");
            redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Line Deleted successfully.");
      }else{
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","D","F");
            redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=$o->tab_id",$pausetime,"Failed To Delete Line.");
      }

  break;

    case "editdiscipline":
    $token=$s->createToken($tokenlife,"CREATE_ACG");

    $o->showDisciplineLine($token,$action);
  break;
  
  case "adddiscipline":
    $token=$s->createToken($tokenlife,"CREATE_ACG");

    $o->showDisciplineLine($token,$action);
  break;

  case "creatediscipline" :

      	if ($s->check(false,$token,"CREATE_ACG")){

            if($o->addDisciplineLine()){
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","I","O");
            redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=4",$pausetime,"Line Add successfully.");
            }else{
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","I","F");
            redirect_header("student.php?action=adddiscipline&student_id=$o->student_id",$pausetime,"Failed To Add Line.");
            }
        }
  break;


  case "updatediscipline" :

      	if ($s->check(false,$token,"CREATE_ACG")){

            if($o->updateDisciplineLine($o->studentdisciplineline_id)){
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","U","O");
            redirect_header("student.php?action=edit&student_id=$o->student_id&tab_id=4",$pausetime,"Line Save successfully.");
            }else{
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","U","F");
            redirect_header("student.php?action=editdiscipline&student_id=$o->student_id&studentdisciplineline_id=$o->studentdisciplineline_id",$pausetime,"Failed To Save Line.");
            }
        }
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
    include_once "../system/class/SendMessage.php.inc";
    $m=new SendMessage();

    $m->emailtitle=$_POST['emailtitle'];
    $m->message=$_POST['msg'];
    $m->textlength=$_POST['textlength'];
    $m->subscriber_number=$o->getNumber();
    $m->sendsms();
    break;
case "resetpassword":
    $message="";
    if($o->resetPassword())
        $message="Password reset to no matrix successfully!";
    else
        $message="Cannot reset password!";
    echo <<< EOF
	<script type='text/javascript'>
	alert('$message');
	</script>
EOF;
    break;
case "generateletter" :
    $o->studentletterctrl = $ctrl->getSelectStudentletter(0,'Y');
    $o->generateLetter();
break;

case "updatestudentsemester":
    $o->updateStudentSemester();
break;
  
default :

	$wherestr =" WHERE a.student_id>0 and a.organization_id=$defaultorganization_id ";

    $limitstr = "";
	if($o->issearch == "Y"){
	$wherestr .= $o->getWhereStr();
    }else{
    $limitstr = " limit 50 ";
	$o->studenttype_id = 0;
    $o->course_id = 0;
    $o->semester_id = 0;
    $o->year_id = 0;
    $o->session_id = 0;
    $o->races_id = 0;
    $o->religion_id = 0;
    $o->country_id = 0;
    $o->loantype_id = 0;
    $o->studentmother_country = 0;
    $o->studentfather_country = 0;
    $o->studenthier_country = 0;
	}


    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    
    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y","","year_id",'',0,false); 
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y","","session_id",'',0,false);
    $o->racesctrl=$ctrl->getSelectRaces($o->races_id,'Y');
    $o->religionctrl=$ctrl->getSelectReligion($o->religion_id,'Y');
    $o->countryctrl=$ctrl->getSelectCountry($o->country_id,'Y');
    $o->loantypectrl=$ctrl->getSelectLoantype($o->loantype_id,'Y');
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
    $o->countrymotherctrl=$ctrl->getSelectCountry($o->studentmother_country,'N','studentmother_country');
    $o->countryfatherctrl=$ctrl->getSelectCountry($o->studentfather_country,'N','studentfather_country');
    $o->countryhierctrl=$ctrl->getSelectCountry($o->studenthier_country,'N','studenthier_country');
	$o->showSearchForm();
	if($o->issearch == "Y")
	$o->showStudentTable($wherestr,"ORDER BY a.defaultlevel,a.student_no",$limitstr);
  break;

  case "xxx" :
    if($o->studenttype_id=="")
    $o->studenttype_id=0;
    if($o->course_id=="")
    $o->course_id=0;
    if($o->semester_id=="")
    $o->semester_id=0;
    if($o->year_id=="")
    $o->year_id=0;
    if($o->session_id=="")
    $o->session_id=0;
    if($o->races_id=="")
    $o->races_id=0;
    if($o->religion_id=="")
    $o->religion_id=0;
    if($o->country_id=="")
    $o->country_id=0;
    if($o->loantype_id=="")
    $o->loantype_id=0;
    if($o->studentmother_country=="")
    $o->studentmother_country=0;
    if($o->studentfather_country=="")
    $o->studentfather_country=0;
    if($o->studenthier_country=="")
    $o->studenthier_country=0;
    if($o->uid=="")
    $o->uid=0;

	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
    
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->racesctrl=$ctrl->getSelectRaces($o->races_id,'N');
    $o->religionctrl=$ctrl->getSelectReligion($o->religion_id,'N');
    $o->countryctrl=$ctrl->getSelectCountry($o->country_id,'N');
    $o->loantypectrl=$ctrl->getSelectLoantype($o->loantype_id,'Y');
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
    $o->countrymotherctrl=$ctrl->getSelectCountry($o->studentmother_country,'N','studentmother_country');
    $o->countryfatherctrl=$ctrl->getSelectCountry($o->studentfather_country,'N','studentfather_country');
    $o->countryhierctrl=$ctrl->getSelectCountry($o->studenthier_country,'N','studenthier_country');
    $o->uidctrl=$permission->selectAvailableSysUser($o->uid,'Y',"uid",""," and isstudent = 1 ","uid",$widthuser,"Y",0);
	//$o->getInputForm("new",0,$token);
	//$o->showStudentTable("WHERE a.student_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,a.student_no", " limit 50 ");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

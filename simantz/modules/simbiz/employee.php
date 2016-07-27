<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once 'class/Employee.php';
//include_once 'class/SelectCtrl.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';


//$log = new Log();
$o = new Employee();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

//marhan add here --> ajax
echo "<iframe src='employee.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">

    function viewRate(value){

        if(value == true)
        document.getElementById('idOTRate').style.display = "";
        else
        document.getElementById('idOTRate').style.display = "none";
    }

    function viewRemarks(idLine){

        var styleline = document.getElementById(idLine).style.display;

        if(styleline == "none")
        document.getElementById(idLine).style.display = "";
        else
        document.getElementById(idLine).style.display = "none";
    }

    function deleteAppraisal(){
        if(confirm("Delete This Appraisal?")){
            if(document.forms['frmAppraisal'].appraisalline_id.value > 0){
            document.forms['frmAppraisal'].action.value = "deleteappraisal";
            document.forms['frmAppraisal'].submit();
            }

        }else{
        return false;
        }
    }

    function newAppraisal(){
    document.forms['frmAppraisal'].reset() ;
    document.forms['frmAppraisal'].appraisalline_id.value=0 ;
    document.forms['frmAppraisal'].action.value="newappraisal" ;
    self.parent.document.getElementById('idBtnViewRecordAppraisal').style.display = "none";
    self.parent.document.getElementById('idBtnDeleteAppraisal').style.display = "none";

    }

    function editAppraisal(appraisalline_id){

    var arr_fld=new Array("action","appraisalline_id");//name for POST
    var arr_val=new Array("editappraisal",appraisalline_id);//value for POST

    getRequest(arr_fld,arr_val);
    }

    function validateAppraisal(){

        appraisalline_date = document.forms['frmAppraisal'].appraisalline_date.value;
        appraisalline_name = document.forms['frmAppraisal'].appraisalline_name.value;
        appraisalline_increment = document.forms['frmAppraisal'].appraisalline_increment.value;

        if(confirm("Confirm Save Appraisal?")){
            if(appraisalline_name == "" || appraisalline_increment == "" || !IsNumeric(appraisalline_increment)){
            alert("Make Sure Appraisal Is Filled In and Increment filled in with numeric value.");
            return false;
            }else{
                if(!isDate(appraisalline_date)){
                return false;
                }else
                return true;
            }

        }else{
        return false;
        }
    }

    function showHideAppraisal(){
    var btnvalue =  self.parent.document.forms['frmAppraisal'].btnShowForm.value;

    if(btnvalue == "Show Form"){
    self.parent.document.forms['frmAppraisal'].btnShowForm.value = "Hide Form";
    self.parent.document.getElementById('tableAppraisal').style.display = "";
    }else{
    self.parent.document.forms['frmAppraisal'].btnShowForm.value = "Show Form";
    self.parent.document.getElementById('tableAppraisal').style.display = "none";
    }

    }

function deletePortfolio(){
        if(confirm("Delete This Portfolio?")){
            if(document.forms['frmPortfolio'].portfolioline_id.value > 0){
            document.forms['frmPortfolio'].action.value = "deleteportfolio";
            document.forms['frmPortfolio'].submit();
            }

        }else{
        return false;
        }
    }

    function newPortfolio(){
    document.forms['frmPortfolio'].reset() ;
    document.forms['frmPortfolio'].portfolioline_id.value=0 ;
    document.forms['frmPortfolio'].action.value="newportfolio" ;
    self.parent.document.getElementById('idBtnViewRecordPortfolio').style.display = "none";
    self.parent.document.getElementById('idBtnDeletePortfolio').style.display = "none";

    }

    function editPortfolio(portfolioline_id){

    var arr_fld=new Array("action","portfolioline_id");//name for POST
    var arr_val=new Array("editportfolio",portfolioline_id);//value for POST

    getRequest(arr_fld,arr_val);
    }

    function validatePortfolio(){

        portfolioline_datefrom = document.forms['frmPortfolio'].portfolioline_datefrom.value;
        portfolioline_dateto = document.forms['frmPortfolio'].portfolioline_dateto.value;
        portfolioline_name = document.forms['frmPortfolio'].portfolioline_name.value;

        if(confirm("Confirm Save Portfolio?")){
            if(portfolioline_name == "" ){
            alert("Make Sure Portfolio Is Filled In");
            return false;
            }else{
                if(!isDate(portfolioline_datefrom) || !isDate(portfolioline_dateto)){
                return false;
                }else
                return true;
            }

        }else{
        return false;
        }
    }

    function showHidePortfolio(){
    var btnvalue =  self.parent.document.forms['frmPortfolio'].btnShowForm.value;

    if(btnvalue == "Show Form"){
    self.parent.document.forms['frmPortfolio'].btnShowForm.value = "Hide Form";
    self.parent.document.getElementById('tablePortfolio').style.display = "";
    }else{
    self.parent.document.forms['frmPortfolio'].btnShowForm.value = "Show Form";
    self.parent.document.getElementById('tablePortfolio').style.display = "none";
    }

    }


function deleteAttachment(){
        if(confirm("Delete This Attachment?")){
            if(document.forms['frmAttachment'].attachmentline_id.value > 0){
            document.forms['frmAttachment'].action.value = "deleteattachment";
            document.forms['frmAttachment'].submit();
            }

        }else{
        return false;
        }
    }

    function newAttachment(){
    document.forms['frmAttachment'].reset() ;
    document.forms['frmAttachment'].attachmentline_id.value=0 ;
    document.forms['frmAttachment'].action.value="newattachment" ;
    self.parent.document.getElementById('idBtnViewRecordAttachment').style.display = "none";
    self.parent.document.getElementById('idBtnDeleteAttachment').style.display = "none";

    }

    function editAttachment(attachmentline_id){

    var arr_fld=new Array("action","attachmentline_id");//name for POST
    var arr_val=new Array("editattachment",attachmentline_id);//value for POST

    getRequest(arr_fld,arr_val);
    }

    function validateAttachment(){

        //attachmentline_file = document.forms['frmAttachment'].attachmentline_date.value;
        attachmentline_name = document.forms['frmAttachment'].attachmentline_name.value;

        if(confirm("Confirm Save Attachment?")){
            if(attachmentline_name == "" ){
            alert("Make Sure Title Is Filled In");
            return false;
            }else{
                return true;
            }

        }else{
        return false;
        }
    }

    function showHideAttachment(){
    var btnvalue =  self.parent.document.forms['frmAttachment'].btnShowForm.value;

    if(btnvalue == "Show Form"){
    self.parent.document.forms['frmAttachment'].btnShowForm.value = "Hide Form";
    self.parent.document.getElementById('tableAttachment').style.display = "";
    }else{
    self.parent.document.forms['frmAttachment'].btnShowForm.value = "Show Form";
    self.parent.document.getElementById('tableAttachment').style.display = "none";
    }

    }

        function deleteActivity(){
        if(confirm("Delete This Activity?")){
            if(document.forms['frmActivity'].activityline_id.value > 0){
            document.forms['frmActivity'].action.value = "deleteactivity";
            document.forms['frmActivity'].submit();
            }

        }else{
        return false;
        }
    }

    function newActivity(){
    document.forms['frmActivity'].reset() ;
    document.forms['frmActivity'].activityline_id.value=0 ;
    document.forms['frmActivity'].action.value="newactivity" ;
    self.parent.document.getElementById('idBtnViewRecordActivity').style.display = "none";
    self.parent.document.getElementById('idBtnDeleteActivity').style.display = "none";

    }

    function editActivity(activityline_id){

    var arr_fld=new Array("action","activityline_id");//name for POST
    var arr_val=new Array("editactivity",activityline_id);//value for POST

    getRequest(arr_fld,arr_val);
    }

    function validateActivity(){

        activityline_datefrom = document.forms['frmActivity'].activityline_datefrom.value;
        activityline_dateto = document.forms['frmActivity'].activityline_dateto.value;
        activityline_name = document.forms['frmActivity'].activityline_name.value;

        if(confirm("Confirm Save Activity?")){
            if(activityline_name == "" ){
            alert("Make Sure Activity Is Filled In");
            return false;
            }else{
                if(!isDate(activityline_datefrom) || !isDate(activityline_dateto)){
                return false;
                }else
                return true;
            }

        }else{
        return false;
        }
    }

    function showHideActivity(){
    var btnvalue =  self.parent.document.forms['frmActivity'].btnShowForm.value;

    if(btnvalue == "Show Form"){
    self.parent.document.forms['frmActivity'].btnShowForm.value = "Hide Form";
    self.parent.document.getElementById('tableActivity').style.display = "";
    }else{
    self.parent.document.forms['frmActivity'].btnShowForm.value = "Show Form";
    self.parent.document.getElementById('tableActivity').style.display = "none";
    }

    }

    function deleteDiscipline(){
        if(confirm("Delete This Discipline?")){
            if(document.forms['frmDiscipline'].disciplineline_id.value > 0){
            document.forms['frmDiscipline'].action.value = "deletediscipline";
            document.forms['frmDiscipline'].submit();
            }

        }else{
        return false;
        }
    }

    function newDiscipline(){
    document.forms['frmDiscipline'].reset() ;
    document.forms['frmDiscipline'].disciplineline_id.value=0 ;
    document.forms['frmDiscipline'].action.value="newdiscipline" ;
    self.parent.document.getElementById('idBtnViewRecordDiscipline').style.display = "none";
    self.parent.document.getElementById('idBtnDeleteDiscipline').style.display = "none";

    }

    function editDiscipline(disciplineline_id){

    var arr_fld=new Array("action","disciplineline_id");//name for POST
    var arr_val=new Array("editdiscipline",disciplineline_id);//value for POST

    getRequest(arr_fld,arr_val);
    }

    function validateDiscipline(){

        disciplineline_date = document.forms['frmDiscipline'].disciplineline_date.value;
        disciplineline_name = document.forms['frmDiscipline'].disciplineline_name.value;

        if(confirm("Confirm Save Discipline?")){
            if(disciplineline_name == "" ){
            alert("Make Sure Discipline Is Filled In");
            return false;
            }else{
                if(!isDate(disciplineline_date)){
                return false;
                }else
                return true;
            }

        }else{
        return false;
        }
    }

    function showHideDiscipline(){
    var btnvalue =  self.parent.document.forms['frmDiscipline'].btnShowForm.value;

    if(btnvalue == "Show Form"){
    self.parent.document.forms['frmDiscipline'].btnShowForm.value = "Hide Form";
    self.parent.document.getElementById('tableDiscipline').style.display = "";
    }else{
    self.parent.document.forms['frmDiscipline'].btnShowForm.value = "Show Form";
    self.parent.document.getElementById('tableDiscipline').style.display = "none";
    }

    }

    function showJobDescription(){
        var stylejob = document.forms['frmEmployee'].employee_jobdescription.style.display;
        if(stylejob == "none")
        document.forms['frmEmployee'].employee_jobdescription.style.display = "";
        else
        document.forms['frmEmployee'].employee_jobdescription.style.display = "none";
    }

    function deleteAllowance(){
        if(confirm("Delete This Allowance?")){
            if(document.forms['frmAllowance'].allowanceline_id.value > 0){
            document.forms['frmAllowance'].action.value = "deleteallowance";
            document.forms['frmAllowance'].submit();
            }

        }else{
        return false;
        }
    }

    function showHideAllowance(){
    var btnvalue =  self.parent.document.forms['frmAllowance'].btnShowForm.value;

    if(btnvalue == "Show Form"){
    self.parent.document.forms['frmAllowance'].btnShowForm.value = "Hide Form";
    self.parent.document.getElementById('tableAllowance').style.display = "";
    }else{
    self.parent.document.forms['frmAllowance'].btnShowForm.value = "Show Form";
    self.parent.document.getElementById('tableAllowance').style.display = "none";
    }

    }

    function newAllowance(){
    document.forms['frmAllowance'].reset() ;
    document.forms['frmAllowance'].allowanceline_id.value=0 ;
    document.forms['frmAllowance'].action.value="newallowance" ;
    self.parent.document.getElementById('idBtnViewRecord').style.display = "none";
    self.parent.document.getElementById('idBtnDelete').style.display = "none";

    }
    function editAllowance(allowanceline_id){
    var arr_fld=new Array("action","allowanceline_id");//name for POST
    var arr_val=new Array("editallowance",allowanceline_id);//value for POST

    getRequest(arr_fld,arr_val);
    }

function validateAllowance(){

    allowanceline_no = document.forms['frmAllowance'].allowanceline_no.value;
    allowanceline_name = document.forms['frmAllowance'].allowanceline_name.value;
    allowanceline_amount = document.forms['frmAllowance'].allowanceline_amount.value;

    if(confirm("Confirm Save Allowance?")){
        if(allowanceline_no == "" || !IsNumeric(allowanceline_no) || allowanceline_amount == "" || !IsNumeric(allowanceline_amount) || allowanceline_name == ""){
        alert("Make Sure Allowance Name, Seq No and Amount Is Filled In");
        return false;
        }else
        return true;
    }else{
    return false;
    }
}

function updateEmpInfo(employeegroup_id){
var arr_fld=new Array("action","employeegroup_id");//name for POST
var arr_val=new Array("updateempinfo",employeegroup_id);//value for POST

getRequest(arr_fld,arr_val);
}

function viewTabDetails(){
var arr_fld=new Array("action");//name for POST
var arr_val=new Array("viewtabdetails");//value for POST

getRequest(arr_fld,arr_val);

}

function autofocus(){
document.forms['frmEmployee'].employee_name.focus();
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


	function validateEmployee(){
		
		var name=document.forms['frmEmployee'].employee_name.value;
		var defaultlevel=document.forms['frmEmployee'].defaultlevel.value;
        var department_id=document.forms['frmEmployee'].department_id.value;
        var employeegroup_id=document.forms['frmEmployee'].employeegroup_id.value;
		var employee_no=document.forms['frmEmployee'].employee_no.value;
        var employee_newicno=document.forms['frmEmployee'].employee_newicno.value;
        var employee_dob=document.forms['frmEmployee'].employee_dob.value;
        var employee_hpno=document.forms['frmEmployee'].employee_hpno.value;
        var employee_salary=document.forms['frmEmployee'].employee_salary.value;
        var employee_ottrip=document.forms['frmEmployee'].employee_ottrip.value;
        var employee_othour=document.forms['frmEmployee'].employee_othour.value;
        var annual_leave=document.forms['frmEmployee'].annual_leave.value;

			
		if(confirm("Save record?")){
		if(employee_hpno == "" || employee_newicno == "" || name =="" || !IsNumeric(defaultlevel) || defaultlevel=="" || employee_no ==""){
			alert('Please make sure Employee Name, Employee No, IC No, HP No is filled in, Default Level filled with numeric value');
			return false;
		}
		else{
                if(department_id == 0 || employeegroup_id == 0 ){
                alert("Please make sure Group & Department is selected.");
                return false;
                }else{
                        if(!isDate(employee_dob)){
                        return false;
                        }
                        else{
                            if(!IsNumeric(employee_salary) || employee_salary=="" || !IsNumeric(annual_leave) || annual_leave=="" || !IsNumeric(employee_ottrip) || employee_ottrip=="" || !IsNumeric(employee_othour) || employee_othour==""){
                            alert("Please make sure Annual Leave & Salary & OT Rate is filled with numeric value.");
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
	document.forms['frmEmployee'].action.value = action;
	document.forms['frmEmployee'].submit();
	}

</script>

EOF;

$o->employee_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->employee_id=$_POST["employee_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->employee_id=$_GET["employee_id"];

}
else
$action="";

$token=$_POST['token'];

$o->employee_name=$_POST["employee_name"];
$o->employee_no=$_POST["employee_no"];

$o->employee_altname=$_POST['employee_altname'];
$o->ic_placeissue=$_POST['ic_placeissue'];
$o->ic_color=$_POST['ic_color'];
$o->contact_address=$_POST['contact_address'];
$o->employee_jobdescription=$_POST['employee_jobdescription'];

$o->contact_postcode=$_POST['contact_postcode'];
$o->contact_city=$_POST['contact_city'];
$o->contact_state=$_POST['contact_state'];
$o->contact_telno=$_POST['contact_telno'];
$o->place_dob=$_POST['place_dob'];
$o->department_id=$_POST['department_id'];
$o->employeegroup_id=$_POST['employeegroup_id'];
$o->employee_joindate=$_POST['employee_joindate'];
$o->employee_confirmdate=$_POST['employee_confirmdate'];
$o->employee_socsono=$_POST['employee_socsono'];
$o->employee_epfno=$_POST['employee_epfno'];
$o->employee_taxno=$_POST['employee_taxno'];
$o->employee_pencenno=$_POST['employee_pencenno'];
$o->employee_salary=$_POST['employee_salary'];
$o->employee_ottrip=$_POST['employee_ottrip'];
$o->employee_othour=$_POST['employee_othour'];
$o->annual_leave=$_POST['annual_leave'];

$o->supervisor_1=$_POST['supervisor_1'];
$o->supervisor_2=$_POST['supervisor_2'];
$o->employee_newicno=$_POST['employee_newicno'];
$o->jobposition_id=$_POST['jobposition_id'];
$o->employee_salarymethod=$_POST['employee_salarymethod'];
$o->employee_oldicno=$_POST['employee_oldicno'];
$o->permanent_address=$_POST['permanent_address'];
$o->gender=$_POST['gender'];
$o->permanent_postcode=$_POST['permanent_postcode'];
$o->permanent_state=$_POST['permanent_state'];
$o->permanent_city=$_POST['permanent_city'];
$o->permanent_country=$_POST['permanent_country'];
$o->contact_country=$_POST['contact_country'];
$o->permanent_telno=$_POST['permanent_telno'];
$o->employee_hpno=$_POST['employee_hpno'];
$o->religion_id=$_POST['religion_id'];
$o->races_id=$_POST['races_id'];
$o->uid=$_POST['uid'];
$o->marital_status=$_POST['marital_status'];
$o->filephoto=$_POST['filephoto'];
$o->employee_dob=$_POST['employee_dob'];
$o->employee_epfrate=$_POST['employee_epfrate'];
$o->employee_accno=$_POST['employee_accno'];
$o->employee_bankname=$_POST['employee_bankname'];
$o->employee_cardno=$_POST['employee_cardno'];
$islecturer=$_POST['islecturer'];
$isovertime=$_POST['isovertime'];
$isfulltime=$_POST['isfulltime'];
$issalesrepresentative=$_POST['issalesrepresentative'];

if(isset($_POST['isactive']))
$isactive=$_POST['isactive'];
else
$isactive=$_GET['isactive'];

$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

$o->dobdatectrl=$dp->show("employee_dob");
$o->confirmdatectrl=$dp->show("employee_confirmdate");
$o->joindatectrl=$dp->show("employee_joindate");
$o->disciplinedatectrl=$dp->show("disciplineline_date");
$o->activitydatefromctrl=$dp->show("activityline_datefrom");
$o->activitydatetoctrl=$dp->show("activityline_dateto");

if(isset($_POST['issearch']))
$o->issearch = $_POST['issearch'];
else
$o->issearch=$_GET['issearch'];

if ($isactive=="1" || $isactive=="on")
$o->isactive=1;
else if ($isactive=="null")
$o->isactive="null";
else
$o->isactive=0;

if ($islecturer=="1" || $islecturer=="on")
$o->islecturer=1;
else if ($islecturer=="null")
$o->islecturer="null";
else
$o->islecturer=0;

if ($isovertime=="1" || $isovertime=="on")
$o->isovertime=1;
else if ($isovertime=="null")
$o->isovertime="null";
else
$o->isovertime=0;

if ($isfulltime=="1" || $isfulltime=="on")
$o->isfulltime=1;
else if ($isfulltime=="null")
$o->isfulltime="null";
else
$o->isfulltime=0;

if ($issalesrepresentative=="1" || $issalesrepresentative=="on")
$o->issalesrepresentative=1;
else if ($issalesrepresentative=="null")
$o->issalesrepresentative="null";
else
$o->issalesrepresentative=0;


if(isset($_POST['isappraisal_alert']))
$o->isappraisal_alert = $_POST['isappraisal_alert'];
else
$o->isappraisal_alert = $_GET['isappraisal_alert'];

// photo attachment
$o->filephototmp= $_FILES["filephoto"]["tmp_name"];
$o->filephotosize=$_FILES["filephoto"]["size"];
$o->filephototype=$_FILES["filephoto"]["type"];
$o->filephotoname=$_FILES["filephoto"]["name"];
$file_ext_photo = strrchr($o->filephotoname, '.');

$o->deleteAttachmentPhoto=$_POST["deleteAttachmentPhoto"];
$o->createnewrecord=$_POST["createnewrecord"];

//line allowance
$o->allowanceline_id=$_POST["allowanceline_id"];
$o->allowanceline_no=$_POST["allowanceline_no"];
$o->allowanceline_name=$_POST["allowanceline_name"];
$o->allowanceline_amount=$_POST["allowanceline_amount"];
$o->allowanceline_epf=$_POST["allowanceline_epf"];
$o->allowanceline_socso=$_POST["allowanceline_socso"];
$o->allowanceline_active=$_POST["allowanceline_active"];
$o->allowanceline_type=$_POST["allowanceline_type"];

//line discipline
$o->disciplineline_id=$_POST["disciplineline_id"];
$o->disciplineline_date=$_POST["disciplineline_date"];
$o->disciplineline_name=$_POST["disciplineline_name"];
$o->disciplineline_remarks=$_POST["disciplineline_remarks"];

//line appraisal
$o->appraisalline_id=$_POST["appraisalline_id"];
$o->appraisalline_date=$_POST["appraisalline_date"];
$o->appraisalline_name=$_POST["appraisalline_name"];
$o->appraisalline_remarks=$_POST["appraisalline_remarks"];
$o->appraisalline_result=$_POST["appraisalline_result"];
$o->appraisalline_increment=$_POST["appraisalline_increment"];

//line activity
$o->activityline_id=$_POST["activityline_id"];
$o->activityline_datefrom=$_POST["activityline_datefrom"];
$o->activityline_dateto=$_POST["activityline_dateto"];
//$o->activityline_type=$_POST["activityline_type"];
$o->activityline_name=$_POST["activityline_name"];
$o->activityline_remarks=$_POST["activityline_remarks"];

//line portfolio
$o->portfolioline_id=$_POST["portfolioline_id"];
$o->portfolioline_datefrom=$_POST["portfolioline_datefrom"];
$o->portfolioline_dateto=$_POST["portfolioline_dateto"];
$o->portfolioline_type=$_POST["portfolioline_type"];
$o->portfolioline_name=$_POST["portfolioline_name"];
$o->portfolioline_remarks=$_POST["portfolioline_remarks"];

//line attachment
$o->attachmentline_id=$_POST["attachmentline_id"];
$o->attachmentline_name=$_POST["attachmentline_name"];
$o->attachmentline_remarks=$_POST["attachmentline_remarks"];
$o->isremove=$_POST["isremove"];
// line attachment
$o->attachmentline_filetmp= $_FILES["attachmentline_file"]["tmp_name"];
$o->attachmentline_filesize=$_FILES["attachmentline_file"]["size"];
$o->attachmentline_filetype=$_FILES["attachmentline_file"]["type"];
$o->attachmentline_filename=$_FILES["attachmentline_file"]["name"];
$file_ext_attachment = strrchr($o->attachmentline_filename, '.');

$widthuser = "style= 'width:200px' ";

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with employee name=$o->employee_name");

	if ($s->check(false,$token,"CREATE_ACG")){
		
		
		
	if($o->insertEmployee()){
		 $latest_id=$o->getLatestEmployeeID();
         $log->saveLog($latest_id,$tableemployee,"$o->changesql","I","O");
        $o->employee_id = $latest_id;
        
            $filephotonamenew=$o->employee_id."_photo".$file_ext_photo;

            if($o->filephotosize>0 && $file_ext_photo == ".jpg")
            $o->savefile($o->filephototmp,$filephotonamenew,$o->employee_id,"filephoto");

            if($o->createnewrecord == "on")
			redirect_header("employee.php",$pausetime,"Your data is saved. Create More Records");
            else
            redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
		}
	else {
        $log->saveLog(0,$tableemployee,"$o->changesql","I","F");
			$token=$s->createToken($tokenlife,"CREATE_ACG");
        $o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        
        $o->racesctrl=$ctrl->getSelectRaces($o->races_id,'N');
        $o->religionctrl=$ctrl->getSelectReligion($o->religion_id,'N');
        $o->employeegroupctrl=$ctrl->getSelectEmployeegroup($o->employeegroup_id,"Y");
        $o->departmentctrl=$ctrl->getSelectDepartment($o->department_id,"Y");
        $o->permanentcountryctrl=$ctrl->getSelectCountry($o->permanent_country,'N','permanent_country');
        $o->contactcountryctrl=$ctrl->getSelectCountry($o->contact_country,'N','contact_country');
        $o->uidctrl=$permission->selectAvailableSysUser($o->uid,'Y',"uid",""," and isstudent = 0 ","uid",$widthuser,"Y",0);
        $o->supervisor1ctrl=$ctrl->getSelectEmployee($o->supervisor_1,'Y',"","supervisor_1","","supervisor_1","style='width:200px'","Y",0);
        $o->supervisor2ctrl=$ctrl->getSelectEmployee($o->supervisor_2,'Y',"","supervisor_2","","supervisor_2","style='width:200px'","Y",0);
        $o->jobpositionctrl=$ctrl->getSelectJobposition($o->jobposition_id,"Y","","jobposition_id","","jobposition_id","","Y",0);
		$o->getInputForm("new",-1,$token);
		$o->showEmployeeTable("WHERE a.employee_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,cast(a.employee_no as signed)");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
        $log->saveLog(0,$tableemployee,"$o->changesql","I","F");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');

        $o->racesctrl=$ctrl->getSelectRaces($o->races_id,'N');
        $o->religionctrl=$ctrl->getSelectReligion($o->religion_id,'N');
        $o->employeegroupctrl=$ctrl->getSelectEmployeegroup($o->employeegroup_id,"Y");
        $o->departmentctrl=$ctrl->getSelectDepartment($o->department_id,"Y");
        $o->permanentcountryctrl=$ctrl->getSelectCountry($o->permanent_country,'N','permanent_country');
        $o->contactcountryctrl=$ctrl->getSelectCountry($o->contact_country,'N','contact_country');
        $o->uidctrl=$permission->selectAvailableSysUser($o->uid,'Y',"uid",""," and isstudent = 0 ","uid",$widthuser,"Y",0);
        $o->supervisor1ctrl=$ctrl->getSelectEmployee($o->supervisor_1,'Y',"","supervisor_1","","supervisor_1","style='width:200px'","Y",0);
        $o->supervisor2ctrl=$ctrl->getSelectEmployee($o->supervisor_2,'Y',"","supervisor_2","","supervisor_2","style='width:200px'","Y",0);
        $o->jobpositionctrl=$ctrl->getSelectJobposition($o->jobposition_id,"Y","","jobposition_id","","jobposition_id","","Y",0);
		$o->getInputForm("new",-1,$token);
		$o->showEmployeeTable("WHERE a.employee_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,cast(a.employee_no as signed)");
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchEmployee($o->employee_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');

        $o->racesctrl=$ctrl->getSelectRaces($o->races_id,'N');
        $o->religionctrl=$ctrl->getSelectReligion($o->religion_id,'N');
        $o->employeegroupctrl=$ctrl->getSelectEmployeegroup($o->employeegroup_id,"Y");
        $o->departmentctrl=$ctrl->getSelectDepartment($o->department_id,"Y");
        $o->permanentcountryctrl=$ctrl->getSelectCountry($o->permanent_country,'N','permanent_country');
        $o->contactcountryctrl=$ctrl->getSelectCountry($o->contact_country,'N','contact_country');
        $o->uidctrl=$permission->selectAvailableSysUser($o->uid,'Y',"uid",""," and isstudent = 0 ","uid",$widthuser,"Y",0);
        $o->supervisor1ctrl=$ctrl->getSelectEmployee($o->supervisor_1,'Y',"","supervisor_1","","supervisor_1","style='width:200px'","Y",0);
        $o->supervisor2ctrl=$ctrl->getSelectEmployee($o->supervisor_2,'Y',"","supervisor_2","","supervisor_2","style='width:200px'","Y",0);
        $o->jobpositionctrl=$ctrl->getSelectJobposition($o->jobposition_id,"Y","","jobposition_id","","jobposition_id","","Y",0);
		$o->getInputForm("edit",$o->employee,$token);
		//$o->showEmployeeTable("WHERE a.employee_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,cast(a.employee_no as signed)");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("employee.php",3,"Some error on viewing your employee data, probably database corrupted");
  
break;

case "view" :
    
	if($o->fetchEmployee($o->employee_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');

        $o->racesctrl=$ctrl->getSelectRaces($o->races_id,'N',"disabled");
        $o->religionctrl=$ctrl->getSelectReligion($o->religion_id,'N',"disabled");
        $o->employeegroupctrl=$ctrl->getSelectEmployeegroup($o->employeegroup_id,"Y","disabled");
        $o->departmentctrl=$ctrl->getSelectDepartment($o->department_id,"Y","disabled");
        $o->permanentcountryctrl=$ctrl->getSelectCountry($o->permanent_country,'N','permanent_country',"disabled");
        $o->contactcountryctrl=$ctrl->getSelectCountry($o->contact_country,'N','contact_country',"disabled");
        $o->uidctrl=$permission->selectAvailableSysUser($o->uid,'Y',"uid",""," and isstudent = 0 ","uid",$widthuser,"N",0);
        $o->supervisor1ctrl=$ctrl->getSelectEmployee($o->supervisor_1,'Y',"disabled","supervisor_1","","supervisor_1","style='width:200px'","N",0);
        $o->supervisor2ctrl=$ctrl->getSelectEmployee($o->supervisor_2,'Y',"disabled","supervisor_2","","supervisor_2","style='width:200px'","N",0);
        $o->jobpositionctrl=$ctrl->getSelectJobposition($o->jobposition_id,"Y","disabled","jobposition_id","","jobposition_id","","N",0);
		$o->getInputForm("view",$o->employee,$token);
		//$o->showEmployeeTable("WHERE a.employee_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,cast(a.employee_no as signed)");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("employee.php",3,"Some error on viewing your employee data, probably database corrupted");

break;


//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateEmployee()){ //if data save successfully
            $log->saveLog($o->employee_id,$tableemployee,"$o->changesql","U","O");

            $filephotonamenew=$o->employee_id."_photo".$file_ext_photo;

            if($o->filephotosize>0 && $file_ext_photo == ".jpg")
            $o->savefile($o->filephototmp,$filephotonamenew,$o->employee_id,"filephoto");

            
            if($o->deleteAttachmentPhoto == "on")
            $o->deletefile($o->employee_id,"filephoto");

            if($o->createnewrecord == "on")
			redirect_header("employee.php",$pausetime,"Your data is saved. Create More Records");
            else
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->employee_id,$tableemployee,"$o->changesql","U","F");
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog($o->employee_id,$tableemployee,"$o->changesql","U","F");
		redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteEmployee($o->employee_id)){
            $o->deletefile2($o->employee_id."_photo.jpg");

            $log->saveLog($o->employee_id,$tableemployee,"$o->changesql","D","O");
			redirect_header("employee.php",$pausetime,"Data removed successfully.");
        }else{
            $log->saveLog($o->employee_id,$tableemployee,"$o->changesql","D","F");
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else
		redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

    case "search" :

	$wherestr =" WHERE a.employee_id>0 and a.organization_id=$defaultorganization_id ";

    $limitstr = "";
	if($o->issearch == "Y"){
	$wherestr .= $o->getWhereStr();
    }else{
    $limitstr = " limit 50 ";
	$o->employeegroup_id = 0;
    $o->department_id = 0;
    $o->permanent_country = 0;
    $o->contact_country = 0;
    $o->races_id = 0;
    $o->religion_id = 0;
	}

    $o->racesctrl=$ctrl->getSelectRaces($o->races_id,'Y');
    $o->religionctrl=$ctrl->getSelectReligion($o->religion_id,'Y');
    $o->employeegroupctrl=$ctrl->getSelectEmployeegroup($o->employeegroup_id,"Y");
    $o->departmentctrl=$ctrl->getSelectDepartment($o->department_id,"Y");
    $o->permanentcountryctrl=$ctrl->getSelectCountry($o->permanent_country,'N','permanent_country');
    $o->contactcountryctrl=$ctrl->getSelectCountry($o->contact_country,'N','contact_country');
    $o->jobpositionctrl=$ctrl->getSelectJobposition($o->jobposition_id,"Y","","jobposition_id","","jobposition_id","","Y",0);
	$o->showSearchForm();
	if($o->issearch == "Y")
	$o->showEmployeeTable($wherestr,"ORDER BY a.defaultlevel,cast(a.employee_no as signed)",$limitstr);
  break;


case "updateempinfo" :


$empInfo = $o->updateEmpInfo($o->employeegroup_id);
$islecturer = $empInfo['islecturer'];
$isovertime = $empInfo['isovertime'];
$isfulltime = $empInfo['isfulltime'];
$issalesrepresentative = $empInfo['issalesrepresentative'];



echo <<< EOF
<script type="text/javascript">

if("$islecturer" == 1)
self.parent.document.forms['frmEmployee'].islecturer.checked = true;
else
self.parent.document.forms['frmEmployee'].islecturer.checked = false;

if("$isovertime" == 1){
self.parent.document.forms['frmEmployee'].isovertime.checked = true;
self.parent.viewRate(true);
}else{
self.parent.document.forms['frmEmployee'].isovertime.checked = false;
self.parent.viewRate(false);
}

if("$isfulltime" == 1)
self.parent.document.forms['frmEmployee'].isfulltime.checked = true;
else
self.parent.document.forms['frmEmployee'].isfulltime.checked = false;

if("$issalesrepresentative" == 1)
self.parent.document.forms['frmEmployee'].issalesrepresentative.checked = true;
else
self.parent.document.forms['frmEmployee'].issalesrepresentative.checked = false;

</script>
EOF;
break;

case "viewtabdetails" :
$tabdetails = "";
echo <<< EOF
<script type="text/javascript">
if(self.parent.document.getElementById("idTabDetails").style.display == "none"){
self.parent.document.getElementById("idTabDetails").style.display = "";
self.parent.document.getElementById("txtViewID").innerHTML = "Hide Details >>";
}else{
self.parent.document.getElementById("idTabDetails").style.display = "none";
self.parent.document.getElementById("txtViewID").innerHTML = "View Details >>";
}

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

    $wherestr .= " and isstudent = 0 ";

	$selectionlist = $o->getSelectDBAjax($strchar,$idinput,$idlayer,$ctrlid,$ocf,$o->tableusers,"uid","name","$wherestr",0);

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

    //$wherestr .= " and isstudent = 0 ";

	$selectionlist = $o->getSelectDBAjaxEmployee($strchar,$idinput,$idlayer,$ctrlid,$ocf,$tableemployee,"employee_id","employee_name","$wherestr",0);

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;

  case "getlistdbjobposition" :
	$strchar = $_POST["strchar"];
	$idinput = $_POST["idinput"];
	$idlayer = $_POST["idlayer"];
	$ctrlid = $_POST["ctrlid"];
	$ocf = $_POST["ocf"];
	$line = $_POST["line"];
    $wherestr = $_POST["wherestr"];
    $wherestr = str_replace("#"," ",$wherestr);
    $wherestr = str_replace("*","'",$wherestr);

    //$wherestr .= " and isstudent = 0 ";

	$selectionlist = $o->getSelectDBAjaxJobposition($strchar,$idinput,$idlayer,$ctrlid,$ocf,$tablejobposition,"jobposition_id","jobposition_name","$wherestr",0);

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;

  case "newallowance":
      if ($s->check(false,$token,"CREATE_ACG")){

        if($o->insertAllowance()){
             $latest_id=$o->getLatestMaxID($tableallowanceline,"allowanceline_id");
             $log->saveLog($latest_id,$tableallowanceline,"$o->changesql","I","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog(0,$tableallowanceline,"$o->changesql","I","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Save Record.");
        }
      }else{
            $log->saveLog(0,$tableallowanceline,"$o->changesql","I","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Save Record.");
      }
  break;

   case "updateallowance":
      if ($s->check(false,$token,"CREATE_ACG")){

        if($o->updateAllowance()){
             $log->saveLog($o->allowanceline_id,$tableallowanceline,"$o->changesql","U","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->allowanceline_id,$tableallowanceline,"$o->changesql","U","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Update Record.");
        }
      }else{
            $log->saveLog($o->allowanceline_id,$tableallowanceline,"$o->changesql","U","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Update Record.");
      }
  break;

 case "deleteallowance":
     
      if ($s->check(false,$token,"CREATE_ACG")){
            if($o->deleteAllowance($o->allowanceline_id)){
             $log->saveLog($o->allowanceline_id,$tableallowanceline,"$o->changesql","D","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Allowance Deleted.");
            }else{
             $log->saveLog($o->allowanceline_id,$tableallowanceline,"$o->changesql","D","F");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Delete Allowance");
            }
      }else{
            $log->saveLog($o->allowanceline_id,$tableallowanceline,"$o->changesql","D","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Delete Allowance");
      }

  break;
  case "editallowance":

      $o->fetchAllowance($o->allowanceline_id);

    $epfchecked = "false";
    $socsochecked = "false";
    $activechecked = "false";
    if($o->allowanceline_epf == 1)
    $epfchecked = "true";
    if($o->allowanceline_socso == 1)
    $socsochecked = "true";
    if($o->allowanceline_active == 1)
    $activechecked = "true";
    
echo <<< EOF
    <script type='text/javascript'>
    self.parent.document.forms['frmAllowance'].allowanceline_name.value = "$o->allowanceline_name";
    self.parent.document.forms['frmAllowance'].allowanceline_no.value = "$o->allowanceline_no";
    self.parent.document.forms['frmAllowance'].allowanceline_amount.value = "$o->allowanceline_amount";
    self.parent.document.forms['frmAllowance'].allowanceline_epf.checked = $epfchecked;
    self.parent.document.forms['frmAllowance'].allowanceline_socso.checked = $socsochecked;
    self.parent.document.forms['frmAllowance'].allowanceline_active.checked = $activechecked;
    self.parent.document.forms['frmAllowance'].allowanceline_type.value = "$o->allowanceline_type";
    self.parent.document.forms['frmAllowance'].allowanceline_id.value = "$o->allowanceline_id";
    self.parent.document.getElementById('idViewRecord').value = "$o->allowanceline_id";

    self.parent.document.forms['frmAllowance'].action.value = "updateallowance";
    self.parent.document.getElementById('tableAllowance').style.display = "";
    self.parent.document.forms['frmAllowance'].btnShowForm.value = "Hide Form";
    self.parent.document.getElementById('idBtnViewRecord').style.display = "";
    self.parent.document.getElementById('idBtnDelete').style.display = "";
    </script>
EOF;
  break;

  case "newdiscipline":
      if ($s->check(false,$token,"CREATE_ACG")){

        if($o->insertDiscipline()){
             $latest_id=$o->getLatestMaxID($tabledisciplineline,"disciplineline_id");
             $log->saveLog($latest_id,$tabledisciplineline,"$o->changesql","I","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog(0,$tabledisciplineline,"$o->changesql","I","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Save Record.");
        }
      }else{
            $log->saveLog(0,$tabledisciplineline,"$o->changesql","I","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Save Record.");
      }
  break;

   case "editdiscipline":

      $o->fetchDiscipline($o->disciplineline_id);

        $o->disciplineline_remarks = str_replace( array("\r\n", "\n","\r"), "\\n", $o->disciplineline_remarks );
        //$o->disciplineline_remarks = str_replace( " ", "&nbsp;", $o->disciplineline_remarks );
echo <<< EOF
    <script type='text/javascript'>

    self.parent.document.forms['frmDiscipline'].disciplineline_name.value = "$o->disciplineline_name";
    self.parent.document.forms['frmDiscipline'].disciplineline_date.value = "$o->disciplineline_date";
    self.parent.document.forms['frmDiscipline'].disciplineline_remarks.value = "$o->disciplineline_remarks";

    self.parent.document.forms['frmDiscipline'].disciplineline_id.value = "$o->disciplineline_id";
    self.parent.document.getElementById('idViewRecordDiscipline').value = "$o->disciplineline_id";

    self.parent.document.forms['frmDiscipline'].action.value = "updatediscipline";
    self.parent.document.getElementById('tableDiscipline').style.display = "";
    self.parent.document.forms['frmDiscipline'].btnShowForm.value = "Hide Form";
    self.parent.document.getElementById('idBtnViewRecordDiscipline').style.display = "";
    self.parent.document.getElementById('idBtnDeleteDiscipline').style.display = "";
    </script>
EOF;
  break;

case "updatediscipline":
      if ($s->check(false,$token,"CREATE_ACG")){

        if($o->updateDiscipline()){
             $log->saveLog($o->disciplineline_id,$tabledisciplineline,"$o->changesql","U","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->disciplineline_id,$tabledisciplineline,"$o->changesql","U","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Update Record.");
        }
      }else{
            $log->saveLog($o->disciplineline_id,$tabledisciplineline,"$o->changesql","U","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Update Record.");
      }
  break;

 case "deletediscipline":

      if ($s->check(false,$token,"CREATE_ACG")){
            if($o->deleteDiscipline($o->disciplineline_id)){
             $log->saveLog($o->disciplineline_id,$tabledisciplineline,"$o->changesql","D","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Discipline Deleted.");
            }else{
             $log->saveLog($o->disciplineline_id,$tabledisciplineline,"$o->changesql","D","F");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Delete Discipline");
            }
      }else{
            $log->saveLog($o->disciplineline_id,$tabledisciplineline,"$o->changesql","D","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Delete Discipline");
      }

  break;

  case "newactivity":
      if ($s->check(false,$token,"CREATE_ACG")){

        if($o->insertActivity()){
             $latest_id=$o->getLatestMaxID($tableactivityline,"activityline_id");
             $log->saveLog($latest_id,$tableactivityline,"$o->changesql","I","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog(0,$tableactivityline,"$o->changesql","I","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Save Record.");
        }
      }else{
            $log->saveLog(0,$tableactivityline,"$o->changesql","I","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Save Record.");
      }
  break;

   case "editactivity":

      $o->fetchActivity($o->activityline_id);

        $o->activityline_remarks = str_replace( array("\r\n", "\n","\r"), "\\n", $o->activityline_remarks );
        //$o->activityline_remarks = str_replace( " ", "&nbsp;", $o->activityline_remarks );
echo <<< EOF
    <script type='text/javascript'>

    self.parent.document.forms['frmActivity'].activityline_name.value = "$o->activityline_name";
    self.parent.document.forms['frmActivity'].activityline_datefrom.value = "$o->activityline_datefrom";
    self.parent.document.forms['frmActivity'].activityline_dateto.value = "$o->activityline_dateto";
    self.parent.document.forms['frmActivity'].activityline_type.value = "$o->activityline_type";
    self.parent.document.forms['frmActivity'].activityline_remarks.value = "$o->activityline_remarks";

    self.parent.document.forms['frmActivity'].activityline_id.value = "$o->activityline_id";
    self.parent.document.getElementById('idViewRecordActivity').value = "$o->activityline_id";

    self.parent.document.forms['frmActivity'].action.value = "updateactivity";
    self.parent.document.getElementById('tableActivity').style.display = "";
    self.parent.document.forms['frmActivity'].btnShowForm.value = "Hide Form";
    self.parent.document.getElementById('idBtnViewRecordActivity').style.display = "";
    self.parent.document.getElementById('idBtnDeleteActivity').style.display = "";
    </script>
EOF;
  break;

case "updateactivity":
      if ($s->check(false,$token,"CREATE_ACG")){

        if($o->updateActivity()){
             $log->saveLog($o->activityline_id,$tableactivityline,"$o->changesql","U","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->activityline_id,$tableactivityline,"$o->changesql","U","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Update Record.");
        }
      }else{
            $log->saveLog($o->activityline_id,$tableactivityline,"$o->changesql","U","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Update Record.");
      }
  break;

 case "deleteactivity":

      if ($s->check(false,$token,"CREATE_ACG")){
            if($o->deleteActivity($o->activityline_id)){
             $log->saveLog($o->activityline_id,$tableactivityline,"$o->changesql","D","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Activity Deleted.");
            }else{
             $log->saveLog($o->activityline_id,$tableactivityline,"$o->changesql","D","F");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Delete Activity");
            }
      }else{
            $log->saveLog($o->activityline_id,$tableactivityline,"$o->changesql","D","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Delete Activity");
      }

  break;



  case "newattachment":
      if ($s->check(false,$token,"CREATE_ACG")){

        if($o->insertAttachment()){
             $latest_id=$o->getLatestMaxID($tableattachmentline,"attachmentline_id");

            $fileattachmentline=$latest_id."".$file_ext_attachment;

            if($o->attachmentline_filesize>0 )
            $o->savefileAttachment($o->attachmentline_filetmp,$fileattachmentline,$latest_id);

             $log->saveLog($latest_id,$tableattachmentline,"$o->changesql","I","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog(0,$tableattachmentline,"$o->changesql","I","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Save Record.");
        }
      }else{
            $log->saveLog(0,$tableattachmentline,"$o->changesql","I","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Save Record.");
      }
  break;

   case "editattachment":

      $o->fetchAttachment($o->attachmentline_id);

        $o->attachmentline_remarks = str_replace( array("\r\n", "\n","\r"), "\\n", $o->attachmentline_remarks );
        //$o->attachmentline_remarks = str_replace( " ", "&nbsp;", $o->attachmentline_remarks );

    $pathfile = "upload/employee/attachment/$o->attachmentline_file";

    if(!file_exists($pathfile) || $o->attachmentline_file == ""){
    $viewfile = "<font color=red>No Attachment<font>";
    }else
    $viewfile = "<a href='$pathfile' target='blank'>View File</a>";

echo <<< EOF
    <script type='text/javascript'>

    self.parent.document.forms['frmAttachment'].attachmentline_name.value = "$o->attachmentline_name";
    //self.parent.document.forms['frmAttachment'].attachmentline_date.value = "$o->attachmentline_date";
    self.parent.document.forms['frmAttachment'].attachmentline_remarks.value = "$o->attachmentline_remarks";
    self.parent.document.getElementById('idAttachment').innerHTML = "$viewfile";

    self.parent.document.forms['frmAttachment'].attachmentline_id.value = "$o->attachmentline_id";
    self.parent.document.getElementById('idViewRecordAttachment').value = "$o->attachmentline_id";


    self.parent.document.forms['frmAttachment'].action.value = "updateattachment";
    self.parent.document.getElementById('tableAttachment').style.display = "";
    self.parent.document.forms['frmAttachment'].btnShowForm.value = "Hide Form";
    self.parent.document.getElementById('idBtnViewRecordAttachment').style.display = "";
    self.parent.document.getElementById('idBtnDeleteAttachment').style.display = "";
    </script>
EOF;
  break;

case "updateattachment":
      if ($s->check(false,$token,"CREATE_ACG")){

        if($o->updateAttachment()){

            $fileattachmentline=$o->attachmentline_id."".$file_ext_attachment;

            if($o->attachmentline_filesize>0 )
             $o->savefileAttachment($o->attachmentline_filetmp,$fileattachmentline,$o->attachmentline_id);

            if($o->isremove == "on")
            $o->deletefileAttachment($o->attachmentline_id);

             $log->saveLog($o->attachmentline_id,$tableattachmentline,"$o->changesql","U","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->attachmentline_id,$tableattachmentline,"$o->changesql","U","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Update Record.");
        }
      }else{
            $log->saveLog($o->attachmentline_id,$tableattachmentline,"$o->changesql","U","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Update Record.");
      }
  break;

 case "deleteattachment":

      if ($s->check(false,$token,"CREATE_ACG")){
            if($o->deleteAttachment($o->attachmentline_id)){
             $log->saveLog($o->attachmentline_id,$tableattachmentline,"$o->changesql","D","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Attachment Deleted.");
            }else{
             $log->saveLog($o->attachmentline_id,$tableattachmentline,"$o->changesql","D","F");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Delete Attachment");
            }
      }else{
            $log->saveLog($o->attachmentline_id,$tableattachmentline,"$o->changesql","D","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Delete Attachment");
      }

  break;


  case "newportfolio":
      if ($s->check(false,$token,"CREATE_ACG")){

        if($o->insertPortfolio()){
             $latest_id=$o->getLatestMaxID($tableportfolioline,"portfolioline_id");
             $log->saveLog($latest_id,$tableportfolioline,"$o->changesql","I","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog(0,$tableportfolioline,"$o->changesql","I","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Save Record.");
        }
      }else{
            $log->saveLog(0,$tableportfolioline,"$o->changesql","I","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Save Record.");
      }
  break;

   case "editportfolio":

      $o->fetchPortfolio($o->portfolioline_id);

        $o->portfolioline_remarks = str_replace( array("\r\n", "\n","\r"), "\\n", $o->portfolioline_remarks );
        //$o->portfolioline_remarks = str_replace( " ", "&nbsp;", $o->portfolioline_remarks );
echo <<< EOF
    <script type='text/javascript'>

    self.parent.document.forms['frmPortfolio'].portfolioline_name.value = "$o->portfolioline_name";
    self.parent.document.forms['frmPortfolio'].portfolioline_datefrom.value = "$o->portfolioline_datefrom";
    self.parent.document.forms['frmPortfolio'].portfolioline_dateto.value = "$o->portfolioline_dateto";
    //self.parent.document.forms['frmPortfolio'].portfolioline_type.value = "$o->portfolioline_type";
    self.parent.document.forms['frmPortfolio'].portfolioline_remarks.value = "$o->portfolioline_remarks";

    self.parent.document.forms['frmPortfolio'].portfolioline_id.value = "$o->portfolioline_id";
    self.parent.document.getElementById('idViewRecordPortfolio').value = "$o->portfolioline_id";

    self.parent.document.forms['frmPortfolio'].action.value = "updateportfolio";
    self.parent.document.getElementById('tablePortfolio').style.display = "";
    self.parent.document.forms['frmPortfolio'].btnShowForm.value = "Hide Form";
    self.parent.document.getElementById('idBtnViewRecordPortfolio').style.display = "";
    self.parent.document.getElementById('idBtnDeletePortfolio').style.display = "";
    </script>
EOF;
  break;

case "updateportfolio":
      if ($s->check(false,$token,"CREATE_ACG")){

        if($o->updatePortfolio()){
             $log->saveLog($o->portfolioline_id,$tableportfolioline,"$o->changesql","U","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->portfolioline_id,$tableportfolioline,"$o->changesql","U","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Update Record.");
        }
      }else{
            $log->saveLog($o->portfolioline_id,$tableportfolioline,"$o->changesql","U","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Update Record.");
      }
  break;

 case "deleteportfolio":

      if ($s->check(false,$token,"CREATE_ACG")){
            if($o->deletePortfolio($o->portfolioline_id)){
             $log->saveLog($o->portfolioline_id,$tableportfolioline,"$o->changesql","D","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Portfolio Deleted.");
            }else{
             $log->saveLog($o->portfolioline_id,$tableportfolioline,"$o->changesql","D","F");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Delete Portfolio");
            }
      }else{
            $log->saveLog($o->portfolioline_id,$tableportfolioline,"$o->changesql","D","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Delete Portfolio");
      }

  break;

  case "newappraisal":
      if ($s->check(false,$token,"CREATE_ACG")){

        if($o->insertAppraisal()){
             $latest_id=$o->getLatestMaxID($tableappraisalline,"appraisalline_id");
             $log->saveLog($latest_id,$tableappraisalline,"$o->changesql","I","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog(0,$tableappraisalline,"$o->changesql","I","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Save Record.");
        }
      }else{
            $log->saveLog(0,$tableappraisalline,"$o->changesql","I","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Save Record.");
      }
  break;

   case "editappraisal":

      $o->fetchAppraisal($o->appraisalline_id);

        $o->appraisalline_remarks = str_replace( array("\r\n", "\n","\r"), "\\n", $o->appraisalline_remarks );
        //$o->appraisalline_remarks = str_replace( " ", "&nbsp;", $o->appraisalline_remarks );
echo <<< EOF
    <script type='text/javascript'>

    self.parent.document.forms['frmAppraisal'].appraisalline_name.value = "$o->appraisalline_name";
    self.parent.document.forms['frmAppraisal'].appraisalline_date.value = "$o->appraisalline_date";
    self.parent.document.forms['frmAppraisal'].appraisalline_remarks.value = "$o->appraisalline_remarks";
    self.parent.document.forms['frmAppraisal'].appraisalline_result.value = "$o->appraisalline_result";
    self.parent.document.forms['frmAppraisal'].appraisalline_increment.value = "$o->appraisalline_increment";

    self.parent.document.forms['frmAppraisal'].appraisalline_id.value = "$o->appraisalline_id";
    self.parent.document.getElementById('idViewRecordAppraisal').value = "$o->appraisalline_id";

    self.parent.document.forms['frmAppraisal'].action.value = "updateappraisal";
    self.parent.document.getElementById('tableAppraisal').style.display = "";
    self.parent.document.forms['frmAppraisal'].btnShowForm.value = "Hide Form";
    self.parent.document.getElementById('idBtnViewRecordAppraisal').style.display = "";
    self.parent.document.getElementById('idBtnDeleteAppraisal').style.display = "";
    </script>
EOF;
  break;

case "updateappraisal":
      if ($s->check(false,$token,"CREATE_ACG")){

        if($o->updateAppraisal()){
             $log->saveLog($o->appraisalline_id,$tableappraisalline,"$o->changesql","U","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->appraisalline_id,$tableappraisalline,"$o->changesql","U","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Update Record.");
        }
      }else{
            $log->saveLog($o->appraisalline_id,$tableappraisalline,"$o->changesql","U","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Update Record.");
      }
  break;

 case "deleteappraisal":

      if ($s->check(false,$token,"CREATE_ACG")){
            if($o->deleteAppraisal($o->appraisalline_id)){
             $log->saveLog($o->appraisalline_id,$tableappraisalline,"$o->changesql","D","O");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Appraisal Deleted.");
            }else{
             $log->saveLog($o->appraisalline_id,$tableappraisalline,"$o->changesql","D","F");
             redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Delete Appraisal");
            }
      }else{
            $log->saveLog($o->appraisalline_id,$tableappraisalline,"$o->changesql","D","F");
            redirect_header("employee.php?action=view&employee_id=$o->employee_id",$pausetime,"Failed To Delete Appraisal");
      }

  break;

  default :
    if($o->employeegroup_id=="")
    $o->employeegroup_id=0;
    if($o->department_id=="")
    $o->department_id=0;
    if($o->permanent_country=="")
    $o->permanent_country=0;
    if($o->contact_country=="")
    $o->contact_country=0;
     if($o->races_id=="")
    $o->races_id=0;
    if($o->religion_id=="")
    $o->religion_id=0;
    if($o->uid=="")
    $o->uid=0;
    if($o->supervisor_1=="")
    $o->supervisor_1=0;
    if($o->supervisor_2=="")
    $o->supervisor_2=0;
    if($o->jobposition_id=="")
    $o->jobposition_id=0;
    
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');

    $o->racesctrl=$ctrl->getSelectRaces($o->races_id,'N');
    $o->religionctrl=$ctrl->getSelectReligion($o->religion_id,'N');
    $o->employeegroupctrl=$ctrl->getSelectEmployeegroup($o->employeegroup_id,"Y","onchange='updateEmpInfo(this.value)'");
    $o->departmentctrl=$ctrl->getSelectDepartment($o->department_id,"Y");
    $o->permanentcountryctrl=$ctrl->getSelectCountry($o->permanent_country,'N','permanent_country');
    $o->contactcountryctrl=$ctrl->getSelectCountry($o->contact_country,'N','contact_country');
    $o->uidctrl=$permission->selectAvailableSysUser($o->uid,'Y',"uid",""," and isstudent = 0 ","uid",$widthuser,"Y",0);
    $o->supervisor1ctrl=$ctrl->getSelectEmployee($o->supervisor_1,'Y',"","supervisor_1","","supervisor_1","style='width:200px'","Y",0);
    $o->supervisor2ctrl=$ctrl->getSelectEmployee($o->supervisor_2,'Y',"","supervisor_2","","supervisor_2","style='width:200px'","Y",0);
    $o->jobpositionctrl=$ctrl->getSelectJobposition($o->jobposition_id,"Y","","jobposition_id","","jobposition_id","","Y",0);
	$o->getInputForm("new",0,$token);
	//$o->showEmployeeTable("WHERE a.employee_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,cast(a.employee_no as signed)", " limit 50 ");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

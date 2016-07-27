<?php
include_once "system.php";
include_once "menu.php";
include_once "class/RegClass.php";
include_once "class/Log.php";
//include_once "class/Employee.php";
include_once "class/Student.php";
include_once "class/TuitionClass.php";
include_once "class/Area.php";
include_once "datepicker/class.datepicker.php";

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';


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

	function selectAll(type){

	if(type == "1")
	value= true;
	else
	value= false;
	//check all line
	var i=0;

	while(i< document.forms['frmRegClass'].elements.length){
		var ctl = document.forms['frmRegClass'].elements[i].name; 
		var val = document.forms['frmRegClass'].elements[i].checked;
		
		ctlname = ctl.substring(0,ctl.indexOf("["))
		
		if(ctlname=="isselect_arr"){
		document.forms['frmRegClass'].elements[i].checked = value;
		}
		i++;
	}//end of check line
	}

	function validateRegClassAdvance(){
	var myaction=document.frmRegClass.action.value;
	var transactiondate=document.frmRegClass.transactiondate.value;

	//!isDate() 
	var additionalstring="";
	var result;


	if (myaction=="createadvance")
	  additionalstring="The default training fees and transport fees will auto generated, do any changes on next screen after you press ok.";

	if(confirm("Do you want to save this record? "+additionalstring)){
		if(!isDate(transactiondate) || transactiondate==""){
			//alert('Please make transaction date is fill in properly');
			return false;

		}
		else{
			
			//check all line
			var i=0;
			var isselect=0;
			while(i< document.forms['frmRegClass'].elements.length){
				var ctl = document.forms['frmRegClass'].elements[i].name; 
				var val = document.forms['frmRegClass'].elements[i].checked;
				
				ctlname = ctl.substring(0,ctl.indexOf("["))
				
				if(ctlname=="isselect_arr"){
					if(val==true)
					isselect++;
				}
				i++;
			}//end of check line
			
			if(isselect>0)
			return true;
			else{
			alert('Please Select Tuition Class.');
			return false;
			}
		}
	}
	else
		return false;
	}

	function validateRegClass(){
	var myaction=document.frmRegClass.action.value;
	var transactiondate=document.frmRegClass.transactiondate.value;

	//!isDate() 
	var additionalstring="";
	var result;
//	if(isObject(document.frmRegClass.amt)){
	//do something 
//		alert(document.frmRegClass.amt.value);
//	}
	//alert(document.frmRegClass.amt.value);//=="undefined";

	if (myaction=="create")
	  additionalstring="The default training fees and transport fees will auto generated, do any changes on next screen after you press ok.";

	if(confirm("Do you want to save this record? "+additionalstring)){
		if(!isDate(transactiondate) || transactiondate==""){
			//alert('Please make transaction date is fill in properly');
			return false;

		}
		else{
			return true;
		}
	}
	else
		return false;
	}	

	function zoomClass(){
		var id=document.frmRegClass.tuitionclass_id.value;
		window.open("tuitionclass.php?action=edit&tuitionclass_id="+id);
	}
function autofocus(){
	
		document.forms['frmSearchStudent'].student_code.focus();
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
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$c->cur_name=$cur_name;
$c->cur_symbol=$cur_symbol;
$o->tuitionclass_id=$_POST['tuitionclass_id'];
//$o->backareafrom_id=$_POST['backareafrom_id'];
$o->backareato_id=$_POST['backareato_id'];
$o->comeareafrom_id=$_POST['comeareafrom_id'];
//$o->comeareato_id=$_POST['comeareato_id'];
$o->amt=$_POST['amt'];
$o->transportfees=$_POST['transportfees'];
$o->futuretrainingfees=$_POST['futuretrainingfees'];
$o->futuretransportfees=$_POST['futuretransportfees'];
$o->advance_mode=$_POST['advance_mode'];

if($_POST['updatestandard']=='on')
	$o->updatestandard=true;
else
	$o->updatestandard=false;

//$o->transportationmethod=$_POST['transportationmethod'];
$o->transactiondate=$_POST['transactiondate'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->showcalendar=$dp->show("transactiondate");
$o->classjoindatectrl=$dp->show("classjoindate");
$o->showdatefrom=$dp->show("datefrom");
$o->showdateto=$dp->show("dateto");
$o->datefrom=$_POST['datefrom'];
$o->description=$_POST['description'];
$o->dateto=$_POST['dateto'];
$o->isAdmin=$xoopsUser->isAdmin();
$token=$_POST['token'];
$o->organization_id=$_POST['organization_id'];
$isactive=$_POST['isactive'];
$o->classjoindate=$_POST['classjoindate'];
$comeactive=$_POST['comeactive'];
$backactive=$_POST['backactive'];


$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

/*
if ($classjoindate=="Y" or $classjoindate=="on")
	$o->classjoindate='Y';
else
	$o->classjoindate='N';
*/
if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';
if ($comeactive=="Y" or $comeactive=="on")
	$o->comeactive='Y';
else
	$o->comeactive='N';
if ($backactive=="Y" or $backactive=="on")
	$o->backactive='Y';
else
	$o->backactive='N';


switch ($action){
 case "create":
	if ($s->check(false,$token,"CREATE_REGC")){
		$log->showlog(3,"Saving data for Student_id=$o->student_id, and class_id=$o->tuitionclass_id");
		if($o->notAllowJoinClass())
		redirect_header("regclass.php?action=choosed&student_id=$o->student_id",3,"<b style='color:red'>You data cannot be save,make sure this student never registered in this class and all input data is correct.</b> Return to previous page");
		if($o->insertRegClass()){
		 $latest_id=$o->getLatestStudentClassID();

		if($o->updatestandard)
			$o->updateStudentStandard();

		 redirect_header("regclass.php?action=edit&studentclass_id=$latest_id",$pausetime,"Your data is saved.");
		}
		else
		redirect_header("regclass.php?action=choosed&student_id=$o->student_id",$pausetime,"$errorstart You data cannot be save, please verified your data $errorend");
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showlog(1,"Warning! Record cannot save due to token expired!");
		if($t->fetchStudentInfo($o->student_id)){
			$o->student_code=$t->student_code;
			$o->student_name=$t->student_name;
			$o->ic_no=$t->ic_no;
			$o->areacf_ctrl=$o->getcomeAddressList($o->comeareafrom_id);
			//$o->areact_ctrl=$a->getAreaList($o->comeareato_id,'comeareato_id');
			//$o->areabf_ctrl=$a->getAreaList($o->backareafrom_id,'backareafrom_id');
			$o->areabt_ctrl=$o->getbackAddressList($o->backareato_id);
			$o->showRegistrationHeader();
			$o->showRegisteredTable('student',"WHERE t.student_id=$o->student_id",'ORDER BY c.tuitionclass_code');
			$o->classctrl=$c->getSelectTuitionClass(0);
			$token=$s->createToken($tokenlife,"CREATE_REGC");
			$o->showInputForm('new',-1,$token);
			$o->showRegisteredTable('student',"WHERE t.student_id=$o->student_id",'ORDER BY c.tuitionclass_code');
//			$o->transportFees($o->transportationmethod,$o->orgctrl,$o->areacf_ctrl);

		}
		else
			redirect_header("regclass.php?action=choosed&student_id=$o->student_id",$pausetime,"$errorstart You data cannot be save, return to previous page$errorend");
	}
 break;

case "createadvance":

	
	if ($s->check(false,$token,"CREATE_REGC")){
		
		$log->showlog(3,"Saving data for Student_id=$o->student_id, and class_id=$o->tuitionclass_id");

		$isselect_arr = $_POST['isselect_arr'];
		$tuitionclassid_arr = $_POST['tuitionclassid_arr'];

		$i=0;
		$issave=0;
		$issame=0;
		foreach ($tuitionclassid_arr as $tuitionclass_id){
		$i++;
		
		$isselect = $isselect_arr[$i];

		if($isselect == "on"){
		$o->tuitionclass_id = $tuitionclass_id;

		if($o->notAllowJoinClass()){
		$issame++;
		}else{
			
			if($o->insertRegClass()){
			$latest_id=$o->getLatestStudentClassID();
	
			if($o->updatestandard)
				$o->updateStudentStandard();
			
			$issave++;
	
			}
		}

		}
		

		}

		if($issame > 0)
		redirect_header("regclass.php?action=choosed&student_id=$o->student_id",$pausetime,"<b style='color:red'>Some data cannot be save,make sure this student never registered in this class and all input data is correct.</b><br> Return to previous page");
		else if($issave > 0)
		redirect_header("regclass.php?action=choosed&student_id=$o->student_id",$pausetime,"Your data is saved.");
		else
		redirect_header("regclass.php?action=choosed&student_id=$o->student_id",$pausetime,"$errorstart You data cannot be save, please verified your data $errorend");
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showlog(1,"Warning! Record cannot save due to token expired!");
		if($t->fetchStudentInfo($o->student_id)){
			$o->student_code=$t->student_code;
			$o->student_name=$t->student_name;
			$o->ic_no=$t->ic_no;
			$o->areacf_ctrl=$o->getcomeAddressList($o->comeareafrom_id);
			//$o->areact_ctrl=$a->getAreaList($o->comeareato_id,'comeareato_id');
			//$o->areabf_ctrl=$a->getAreaList($o->backareafrom_id,'backareafrom_id');
			$o->areabt_ctrl=$o->getbackAddressList($o->backareato_id);
			$o->showRegistrationHeader();
			$o->showRegisteredTable('student',"WHERE t.student_id=$o->student_id",'ORDER BY c.tuitionclass_code');
			$o->classctrl=$c->getSelectTuitionClass(0);
			$token=$s->createToken($tokenlife,"CREATE_REGC");
			$o->showInputForm('new',-1,$token);
			$o->showRegisteredTable('student',"WHERE t.student_id=$o->student_id",'ORDER BY c.tuitionclass_code');
//			$o->transportFees($o->transportationmethod,$o->orgctrl,$o->areacf_ctrl);

		}
		else
			redirect_header("regclass.php?action=choosed&student_id=$o->student_id",$pausetime,"$errorstart You data cannot be save, return to previous page$errorend");
	}
 break;

 case "choosed":
	$log->showlog(3,"Choose Student_id=$o->student_id for class registration");
	if($t->fetchStudentInfo($o->student_id)){
		
		$o->student_code=$t->student_code;
		$o->student_name=$t->student_name;
		$o->ic_no=$t->ic_no;
		$o->orgctrl=$permission->selectionOrg($o->createdby,0);
		$o->areacf_ctrl=$o->getcomeAddressList($o->comeareafrom_id);
		//$o->areact_ctrl=$a->getAreaList(0,'comeareato_id');
		//$o->areabf_ctrl=$a->getAreaList(0,'backareafrom_id');
		$o->areabt_ctrl=$o->getbackAddressList($o->backareato_id);
		$o->showRegistrationHeader();
		$o->showRegisteredTable('student',"WHERE sc.student_id=$o->student_id and c.isactive='Y' and c.product_id>0",
				'ORDER BY c.tuitionclass_code','regclass');
		$o->classctrl=$c->getSelectTuitionClass(0);
		$token=$s->createToken($tokenlife,"CREATE_REGC");

		if($o->advance_mode == "Y")
		$o->showInputFormAdvance('new',0,$token);
		else
		$o->showInputForm('new',0,$token);
	}
	else
		$log->showlog(1,"Error: can't retrieve student information: $o->student_id");
 break;

 case "update":
	$log->showlog(3,"Saving data for Student_id=$o->student_id, and class_id=$o->studentclass_id");
	if ($s->check(false,$token,"CREATE_REGC")){
		
		if( $o->notAllowJoinClass() && $o->tuitionclass_id != $_POST['oldtuitionclass_id'])		
		  redirect_header("regclass.php?action=choosed&student_id=$o->student_id",3,
			"<b style='color:red'>You data cannot be save,make sure this student never 
			registered in this class and all input data is correct.</b> Return to previous page");


		if($o->updateStudentClass()){ //if data save successfully
			if($o->updatestandard)
				$o->updateStudentStandard();
			redirect_header("regclass.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("regclass.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"$errorstart Warning! Can't save the data, please make sure all value is insert properly.$errorend");
		}
	else{
		redirect_header("regclass.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"$errorstart Warning! Can't save this record due to token expired.$errorend");
	}
 break;
 case "search":
	$log->showlog(3,"Search Student_id=$o->student_id,student_code=$o->student_code,student_name=$o->student_name,ic_no=$o->ic_no");
	$wherestring= cvSearchString($o->student_id,$o->student_code,$o->student_name,$o->ic_no);
	
	//if ($wherestring=="")
	//$wherestring .= " WHERE 1 ";
	
	$wherestring .= " and s.organization_id = $defaultorganization_id ";


	if($o->student_id==0){
		if ($wherestring!="")
			$wherestring="WHERE " . $wherestring;
			echo '<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big>'.
				'<span style="font-weight: bold;">Choose Student for Class Registration</span></big></big></big></div><br>';
			$t->showStudentTable($wherestring," ORDER BY s.student_name",0,'regclass');
	}
	else
		redirect_header("regclass.php?action=choosed&student_id=$o->student_id",$pausetime,"Opening Student for registration.");
 break;
 case "delete":
	if ($s->check(false,$token,"CREATE_REGC")){
		if($o->deleteStudentClass($o->studentclass_id))
			redirect_header("regclass.php?action=choosed&student_id=$o->student_id",$pausetime,"Data removed successfully.");
		else
			redirect_header("regclass.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"$errorstart Warning! Can't delete data from database due to data dependency error. $errorend");
	}
	else
		redirect_header("regclass.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"$errorstart Warning! Can't delete data from database due to token expired, please re-delete the data.$errorend");
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
		$o->areacf_ctrl=$o->getcomeAddressList($o->comeareafrom_id);
		//$o->areact_ctrl=$a->getAreaList($o->comeareato_id,'comeareato_id');
		//$o->areabf_ctrl=$a->getAreaList($o->backareafrom_id,'backareafrom_id');
		$o->areabt_ctrl=$o->getbackAddressList($o->backareato_id);
		$log->showLog(4,"areafrom $o->comeareafrom_id, areato: $o->backareato_id");
		$o->showRegistrationHeader();
		$o->showRegisteredTable('student',"WHERE sc.student_id=$o->student_id and c.isactive='Y'",'ORDER BY c.tuitionclass_code');
		$o->classctrl=$c->getSelectTuitionClass($o->tuitionclass_id);
		$token=$s->createToken($tokenlife,"CREATE_REGC");
		$o->showInputForm('edit',$o->studentclass_id,$token);
//		$o->transportFees($o->transportationmethod,$o->orgctrl,$o->areacf_ctrl);
//		$o->fetchRegClassInfo($o->studentclass_id);

	}
	else
	redirect_header("regclass.php",3,"$errorstart Some error on viewing your this record, probably database corrupted.$errorend");
 break;
 case "filter":
 	$log->showlog(3,"Choose Student_id=$o->student_id for class registration, but filtering date between: $o->datefrom & $o->dateto");
	if($t->fetchStudentInfo($o->student_id)){
		
		$o->student_code=$t->student_code;
		$o->student_name=$t->student_name;
		$o->ic_no=$t->ic_no;
		$o->orgctrl=$permission->selectionOrg($o->createdby,0);
		$o->areacf_ctrl=$o->getcomeAddressList($o->comeareafrom_id);
		//$o->areact_ctrl=$a->getAreaList(0,'comeareato_id');
		//$o->areabf_ctrl=$a->getAreaList(0,'backareafrom_id');
		$o->areabt_ctrl=$o->getbackAddressList($o->backareato_id);
		$o->showRegistrationHeader();
		if($o->datefrom=="")
			$o->datefrom="1900-01-01";
		if($o->dateto=="")
			$o->dateto="2999-12-31";

		$o->showRegisteredTable('student',"WHERE sc.student_id=$o->student_id and ".
				"sc.transactiondate between '$o->datefrom' and '$o->dateto' and c.tuitionclass_id>0" , 'ORDER BY c.tuitionclass_code','regclass');
		$o->classctrl=$c->getSelectTuitionClass(0);
		$token=$s->createToken($tokenlife,"CREATE_REGC");
		$o->showInputForm('new',0,$token);
	}
	else
		$log->showlog(1,"Error: can't retrieve student information: $o->student_id");
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
	$filterstring=$filterstring . " s.student_id=$student_id";
	$needand='AND';
}
else
	$needand='';

if($student_code!=""){
	$filterstring=$filterstring . " $needand s.student_code LIKE '$student_code' ";
	$needand='AND';
}
else
$needand='';

if ($student_name!=""){
$filterstring=$filterstring . " $needand s.student_name LIKE '$student_name'";
	$needand='AND';
}
else
	$needand='';

if($ic_no!="")
$filterstring=$filterstring . "  $needand s.ic_no LIKE '$ic_no'";
if($filterstring=="")
return "s.student_id>0 ";
else	
return "s.student_id>0 AND ".$filterstring;
}

?>

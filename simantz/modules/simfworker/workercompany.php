<?php
include "system.php";
include "menu.php";
include "class/WorkerCompany.php";
include "class/Log.php";
include "class/Currency.php";
include "class/Company.php";
include "class/Worker.php";

require "datepicker/class.datepicker.php";

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$log = new Log();

$c = new Company($xoopsDB,$tableprefix,$log);
$o = new WorkerCompany($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$w = new Worker($xoopsDB,$tableprefix,$log);
$cr = new Currency($xoopsDB,$tableprefix,$log);

$action="";
echo <<< EOF

<script type="text/javascript">
	function validateWorkerCompany(){
	var myaction=document.frmWorkerCompany.action.value;
	var transactiondate=document.frmWorkerCompany.transactiondate.value;

	//!isDate() 
	var additionalstring="";
	var result;
//	if(isObject(document.frmWorkerCompany.amt)){
	//do something
//		alert(document.frmWorkerCompany.amt.value);
//	}
	//alert(document.frmWorkerCompany.amt.value);//=="undefined";

	if (myaction=="create")
	  additionalstring="The default training fees and transport fees will auto generated, do any changes on next screen after you press ok.";

	if(confirm("Do you want to save this record? "+additionalstring)){
		if(!isDate(transactiondate)){
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
		var id=document.frmWorkerCompany.tuitionclass_id.value;
		window.open("tuitionclass.php?action=edit&tuitionclass_id="+id);
	}

</script>
EOF;

$o->workercompany_id=0;
$o->worker_id=0;
$o->company_id=0;
if (isset($_POST['action'])){

	$action=$_POST['action'];
	$o->workercompany_id=$_POST["workercompany_id"];

	if(isset($_POST['worker_id']))
		$o->worker_id=$_POST['worker_id'];
	if(isset($_POST['company_id']))
		$o->company_id=$_POST['company_id'];

}
elseif(isset($_GET['action'])){

	$action=$_GET['action'];

	$o->workercompany_id=$_GET["workercompany_id"];
	if(isset($_GET['worker_id']))
		$o->worker_id=$_GET['worker_id'];
	if(isset($_GET['company_id']))
		$o->company_id=$_GET['company_id'];
}

else
$action="";

$o->department=$_POST['department'];
$o->salary=$_POST['salary'];
$o->joindate=$_POST['joindate'];
$o->resigndate=$_POST['resigndate'];
$o->street1=$_POST['street1'];
$o->street2=$_POST['street2'];
$o->postcode=$_POST['postcode'];
$o->city=$_POST['city'];
$o->state1=$_POST['state1'];
$o->country=$_POST['country'];
$o->payfrequency=$_POST['payfrequency'];
$o->position=$_POST['position'];
$o->currency_id=$_POST['currency_id'];
$o->supervisor=$_POST['supervisor'];
$o->supervisor_contact=$_POST['supervisor_contact'];

$o->usecompany_address=$_POST['usecompany_address'];
if ($o->usecompany_address=='on' || $o->usecompany_address=='1')
	$o->usecompany_address=1;
else
	$o->usecompany_address=0;
$o->workerstatus=$_POST['workerstatus'];
$o->worker_no=$_POST['worker_no'];
$o->othersinfo=$_POST['othersinfo'];
$o->created=date("y/m/d H:i:s", time()) ;
$o->updated=date("y/m/d H:i:s", time()) ;
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->showcalendar1=$dp->show("joindate");
$o->showcalendar2=$dp->show("resigndate");
$token=$_POST['token'];
switch ($action){
 case "create":
	if ($s->check(false,$token,"CREATE_WKCP")){
		$log->showlog(3,"Saving data for worker_id=$o->worker_id, and company_id=$o->company_id");
		if($o->insertWorkerCompany()){
		 $latest_id=$o->getLatestWorkerCompanyID();
			if($o->usecompany_address==1)
				$o->updateCompanyAddress($latest_id,$o->company_id);
		 redirect_header("workercompany.php?action=editworker&workercompany_id=$latest_id",$pausetime,"Your data is saved.");
		}
		else
		redirect_header("workercompany.php?action=editworker&worker_id=$o->worker_id",$pausetime,"You data cannot be save, return to previous page");
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showlog(3,"Token expired! Choose worker_id=$o->worker_id for register new employment record");
		if($w->fetchWorker($o->worker_id)){
			$o->companyctrl=$c->getSelectCompany($o->company_id);
			$o->worker_code=$t->worker_code;
			$o->workert_name=$t->worker_name;

			$w->showWorkerHeader($o->worker_id);
			$o->showWorkerEmploymentTable("WHERE w.worker_id=$o->worker_id",'ORDER BY wc.joindate',1,99999);
			$token=$s->createToken($tokenlife,"CREATE_WKCP");
			$o->showInputForm('new',-1,$token);
			//$o->showRegisteredTable('student',"WHERE t.student_id=$o->student_id",'ORDER BY c.tuitionclass_code');
//			$o->transportFees($o->transportationmethod,$o->orgctrl,$o->areacf_ctrl);

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
		$o->orgctrl=$e->selectionOrg($o->createdby,0);
		$o->areacf_ctrl=$o->getcomeAddressList($o->comeareafrom_id);
		//$o->areact_ctrl=$a->getAreaList(0,'comeareato_id');
		//$o->areabf_ctrl=$a->getAreaList(0,'backareafrom_id');
		$o->areabt_ctrl=$o->getbackAddressList($o->backareato_id);
		$o->showRegistrationHeader();
		$o->showRegisteredTable('student',"WHERE sc.student_id=$o->student_id and c.isactive='Y'",
				'ORDER BY c.tuitionclass_code','regclass');
		$o->classctrl=$c->getSelectTuitionClass(0);
		$token=$s->createToken($tokenlife,"CREATE_WKCP");
		$o->showInputForm('new',0,$token);
	}
	else
		$log->showlog(1,"Error: can't retrieve student information: $o->student_id");
 break;
 case "update":
	$log->showlog(3,"Saving data for Worker_id=$o->worker_id, and class_id=$o->workercompany_id");
	if ($s->check(false,$token,"CREATE_WKCP")){
		if($o->updateWorkerCompany()){ //if data save successfully
			if($o->usecompany_address==1)
				$o->updateCompanyAddress($o->workercompany_id,$o->company_id);
			redirect_header("workercompany.php?action=editworker&workercompany_id=$o->workercompany_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("workercompany.php?action=editworker&workercompany_id=$o->workercompany_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("workercompany.php?action=edit&workercompany_id=$o->workercompany_id",$pausetime,"Warning! Can't save the data, due to form's token expired, please re-enter the data.");
	}
 break;
 case "search":
	$log->showlog(3,"Search Student_id=$o->student_id,student_code=$o->student_code,student_name=$o->student_name,ic_no=$o->ic_no");
	$wherestring= cvSearchString($o->student_id,$o->student_code,$o->student_name,$o->ic_no);
	if($o->student_id==0){
		if ($wherestring!="")
			$wherestring="WHERE " . $wherestring;
			echo '<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big>'.
				'<span style="font-weight: bold;">Choose Student for Class Registration</span></big></big></big></div><br>';
			$t->showStudentTable($wherestring," ORDER BY student_name",0,'regclass');
	}
	else
		redirect_header("workercompany.php?action=choosed&student_id=$o->student_id",$pausetime,"Opening Student for registration.");
 break;
 case "delete":
	if ($s->check(false,$token,"CREATE_WKCP")){
		if($o->deleteWorkerCompany($o->workercompany_id))
			redirect_header("workercompany.php?action=choosed&student_id=$o->student_id",$pausetime,"Data removed successfully.");
		else
			redirect_header("workercompany.php?action=edit&workercompany_id=$o->workercompany_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("workercompany.php?action=edit&workercompany_id=$o->workercompany_id",$pausetime,"Warning! Can't delete data from database due to token expired, please re-delete the data.");
 break;
 case "editworker":
	$log->showlog(3,"Editing data workercompany_id:$o->workercompany_id");

	if ($o->fetchWorkerCompanyInfo($o->workercompany_id)){
/*		$w->showWorkerHeader($o->worker_id);
		$o->showWorkerEmploymentTable("WHERE w.worker_id=$o->worker_id",
				'ORDER BY wc.joindate',0,99999);
		$token=$s->createToken($tokenlife,"CREATE_WKCP");
		$o->workerstatusctrl=workerstatusctrl($o->workerstatus);
		$o->companyctrl=$c->getSelectCompany($o->company_id);
		$o->currencyctrl=$cr->getSelectCurrency($o->currency_id);

		$o->showInputForm('editworker',$o->workercompany_id,$token);
*/
		if($w->fetchWorker($o->worker_id)){
			$o->worker_code=$w->worker_code;
			$o->worker_name=$w->worker_name;
		}
	
	$token=$s->createToken($tokenlife,"CREATE_WKCP");
	echo <<< EOF
	<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">
	Worker Employment History</span></big></big></big></div><br>
EOF;
	$filterstring=$w->searchAToZ();
	if($_GET['filterstring']!="")
	$filterstring=$_GET['filterstring'];

	$w->showWorkerHeader($o->worker_id);
	$o->showWorkerEmploymentTable("WHERE w.worker_id=$o->worker_id",
				'ORDER BY wc.joindate',0,99999);

	$o->companyctrl=$c->getSelectCompany($o->company_id);
	$o->currencyctrl=$cr->getSelectCurrency($o->currency_id);
	$o->workerstatusctrl=workerstatusctrl($o->workerstatus);
	$o->showInputForm("editworker",$o->workercompany_id,$token);

	}
 break;
 /*case "editcompany":
	$log->showlog(3,"Editing data workercompany_id:$o->workercompany_id");

	if ($o->fetchWorkerCompanyInfo($o->workercompany_id)){
		if($c->fetchCompany($o->company_id)){
			$o->company_no=$c->company_no;
			$o->company_name=$c->company_name;
		}
		$c->showCompanyHeader($o->company_id);
		$o->showCompanyEmploymentTable("WHERE c.company_id=$o->company_id",
				'ORDER BY wc.joindate',0,99999);worker
		$token=$s->createToken($tokenlife,"CREATE_WKCP");
		$o->workerstatusctrl=workerstatusctrl($o->workerstatus);
		$o->currencyctrl=$cr->getSelectCurrency($o->currency_id);

		$o->workerctrl=$c->getSelectWorker($o->worker_id);
		$o->showInputForm('editcompany',$o->workercompany_id,$token);

	}
 break;
*/
 case "filter":
 	$log->showlog(3,"Choose Student_id=$o->student_id for class registration, but filtering date between: $o->datefrom & $o->dateto");
	if($t->fetchStudentInfo($o->student_id)){
		
		$o->student_code=$t->student_code;
		$o->student_name=$t->student_name;
		$o->ic_no=$t->ic_no;
		$o->orgctrl=$e->selectionOrg($o->createdby,0);
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
				"sc.transactiondate between '$o->datefrom' and '$o->dateto'" , 'ORDER BY c.tuitionclass_code','regclass');
		$o->classctrl=$c->getSelectTuitionClass(0);
		$token=$s->createToken($tokenlife,"CREATE_WKCP");
		$o->showInputForm('new',0,$token);
	}
	else
		$log->showlog(1,"Error: can't retrieve student information: $o->student_id");
 break;
 default:
	$o->companyctrl=$c->getSelectCompany(0);
	$token=$s->createToken($tokenlife,"CREATE_WKCP");
	echo <<< EOF
	<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">
	Worker Employment History</span></big></big></big></div><br>
EOF;
	$filterstring=$w->searchAToZ();
	if($_GET['filterstring']!="")
	$filterstring=$_GET['filterstring'];

	$w->showWorkerHeader($o->worker_id);
	$o->showWorkerEmploymentTable("WHERE w.worker_id=$o->worker_id",
				'ORDER BY wc.joindate',0,99999);
	$o->currencyctrl=$cr->getSelectCurrency(0);
	$o->workerstatusctrl=workerstatusctrl("default");
	$o->showInputForm("new",0,$token);
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

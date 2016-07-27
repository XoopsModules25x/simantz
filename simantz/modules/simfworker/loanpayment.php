<?php
include "system.php";
include "menu.php";
include "class/LoanPayment.php";
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
$o = new LoanPayment($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$w = new Worker($xoopsDB,$tableprefix,$log);
$cr = new Currency($xoopsDB,$tableprefix,$log);

$action="";
echo <<< EOF

<script type="text/javascript">
	function onOpen(){
	if(document.frmLoanPayment.type.value==-1){
	document.frmLoanPayment.installment_amt.type='hidden';
	document.frmLoanPayment.monthcount.type='hidden';
	document.frmLoanPayment.installment_amt.value=0;
	document.frmLoanPayment.monthcount.value=0;
	}
	else{
	document.frmLoanPayment.installment_amt.type='text';
	document.frmLoanPayment.monthcount.type='text';
	}

	}

	function validateLoanPayment(){
	var myaction=document.frmLoanPayment.action.value;
	var transactiondate=document.frmLoanPayment.transactiondate.value;

	//!isDate() 
	var additionalstring="";
	var loanpayment_status;
//	if(isObject(document.frmMedical.amt)){
	//do something
//		alert(document.frmMedical.amt.value);
//	}
	//alert(document.frmMedical.amt.value);//=="undefined";

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
		var id=document.frmLoanPayment.tuitionclass_id.value;
		window.open("tuitionclass.php?action=edit&tuitionclass_id="+id);
	}

</script>
EOF;

$o->loanpayment_id=0;
$o->worker_id=0;
$o->company_id=0;
if (isset($_POST['action'])){

	$action=$_POST['action'];
	$o->loanpayment_id=$_POST["loanpayment_id"];

	if(isset($_POST['worker_id']))
		$o->worker_id=$_POST['worker_id'];
	if(isset($_POST['company_id']))
		$o->company_id=$_POST['company_id'];

}
elseif(isset($_GET['action'])){

	$action=$_GET['action'];

	$o->loanpayment_id=$_GET["loanpayment_id"];

	if(isset($_GET['worker_id']))
		$o->worker_id=$_GET['worker_id'];
	if(isset($_GET['company_id']))
		$o->company_id=$_GET['company_id'];
}

else
$action="";
$o->worker_id=$_POST['worker_id'];
$o->company_id=$_POST['company_id'];
$o->loanpayment_date=$_POST['loanpayment_date'];
$o->nextpayment_date=$_POST['nextpayment_date'];

$o->document_no=$_POST['document_no'];
$o->amount=$_POST['amount'];
$o->installment_amt=$_POST['installment_amt'];
$o->monthcount=$_POST['monthcount'];
if($_POST['loanpayment_status']=='on')
	$o->loanpayment_status=1;
else
	$o->loanpayment_status=0;

$o->description=$_POST['description'];
$o->type=$_POST['type'];
$o->reference_id=$_POST['reference_id'];
$o->created=date("y/m/d H:i:s", time()) ;
$o->updated=date("y/m/d H:i:s", time()) ;
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->showcalendar1=$dp->show("loanpayment_date");
$o->showcalendar2=$dp->show("nextpayment_date");
$token=$_POST['token'];
echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Worker Master Data</span></big></big></big></div><br>
EOF;
$filterstring=$w->searchAToZ();


switch ($action){
 case "create":
	if ($s->check(false,$token,"CREATE_CKP")){
		$log->showlog(3,"Saving data for worker_id=$o->worker_id, and company_id=$o->company_id");
		if($o->insertLoanPayment()){
		 $latest_id=$o->getLatestLoanPaymentID();

		 redirect_header("loanpayment.php?action=edit&loanpayment_id=$latest_id",$pausetime,"Your data is saved.");
		}
		else
		redirect_header("loanpayment.php?action=choose&worker_id=$o->worker_id",$pausetime,"You data cannot be save, return to previous page");
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showlog(3,"Token expired!ee $token");
		if($w->fetchWorker($o->worker_id)){
			$o->companyctrl=$c->getSelectCompany($o->company_id);
			$o->worker_code=$t->worker_code;
			$o->workert_name=$t->worker_name;

			$w->showWorkerHeader($o->worker_id);
			$o->showWorkerEmploymentTable("WHERE w.worker_id=$o->worker_id",'ORDER BY wc.joindate',1,99999);
			$token=$s->createToken($tokenlife,"CREATE_CKP");
			$o->showInputForm('new',-1,$token);
			//$o->showRegisteredTable('worker',"WHERE t.worker_id=$o->worker_id",'ORDER BY c.tuitionclass_code');
//			$o->transportFees($o->transportationmethod,$o->orgctrl,$o->areacf_ctrl);

		}
		else
			$log->showlog(1,"Error: can't retrieve worker information: $o->worker_id");
	}
 break;
  case "update":
	$log->showlog(3,"Saving data for Worker_id=$o->worker_id, and class_id=$o->loanpayment_id");
	if ($s->check(false,$token,"CREATE_CKP")){
		if($o->updateLoanPayment()){ //if data save successfully
			redirect_header("loanpayment.php?action=edit&loanpayment_id=$o->loanpayment_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("loanpayment.php?action=edit&loanpayment_id=$o->loanpayment_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("loanpayment.php?action=edit&loanpayment_id=$o->loanpayment_id",$pausetime,"Warning! Can't save the data, due to form's token expired, please re-enter the data.");
	}
 break;
 case "searchform":
	$o->companyctrl=$c->getSelectCompany(-1);
	$o->workerctrl=$w->getSelectWorker(-1);
	$o->showSearchForm();
	$o->showLoanPaymentTable("","ORDER BY m.loanpayment_date desc,c.company_name,w.worker_name",0,50);

 break;
 case "search":
	$log->showlog(3,"Search Worker_id=$o->worker_id,worker_code=$o->worker_code,worker_name=$o->worker_name,ic_no=$o->ic_no");
	$o->companyctrl=$c->getSelectCompany(-1);
	$o->workerctrl=$w->getSelectWorker(-1);
	$o->showSearchForm();

	$wherestring=cvSearchString($document_no,$loanpayment_date,$nextpayment_date,$worker_id,$company_id,$doctor,$clinic,$loanpayment_status);
	$o->showLoanPaymentTable("","ORDER BY m.loanpayment_date desc,c.company_name,w.worker_name",0,50);

 break;
 case "delete":
	if ($s->check(false,$token,"CREATE_CKP")){
		if($o->deleteLoanPayment($o->loanpayment_id))
			redirect_header("worker.php?action=edit&worker_id=$o->worker_id",$pausetime,"Data removed successfully.");
		else
			redirect_header("loanpayment.php?action=edit&loanpayment_id=$o->loanpayment_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("loanpayment.php?action=edit&loanpayment_id=$o->loanpayment_id",$pausetime,"Warning! Can't delete data from database due to token expired, please re-delete the data.");
 break;
 case "edit":
	$log->showlog(3,"Editing data loanpayment_id:$o->loanpayment_id");

	if ($o->fetchLoanPaymentInfo($o->loanpayment_id)){
		$o->workerctrl=$w->getSelectWorker($o->worker_id);
		$token=$s->createToken($tokenlife,"CREATE_CKP");
		$o->companyctrl=$c->getSelectCompany($o->company_id);
		$o->currencyctrl=$cr->getSelectCurrency($o->currency_id);

		$w->showWorkerHeader($o->worker_id);
		$o->showInputForm('edit',$o->loanpayment_id,$token);
		$o->showLoanPaymentTable("WHERE m.worker_id=$o->worker_id","ORDER BY m.loanpayment_date asc",0,9999);
	}
 break;
 
 case "filter":
 	$log->showlog(3,"Choose Worker_id=$o->worker_id for class registration, but filtering date between: $o->datefrom & $o->dateto");
	if($t->fetchWorkerInfo($o->worker_id)){
		
		$o->worker_code=$t->worker_code;
		$o->worker_name=$t->worker_name;
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

		$o->showRegisteredTable('worker',"WHERE sc.worker_id=$o->worker_id and ".
				"sc.transactiondate between '$o->datefrom' and '$o->dateto'" , 'ORDER BY c.tuitionclass_code','regclass');
		$o->classctrl=$c->getSelectTuitionClass(0);
		$token=$s->createToken($tokenlife,"CREATE_CKP");
		$o->showInputForm('new',0,$token);
	}
	else
		$log->showlog(1,"Error: can't retrieve worker information: $o->worker_id");
 break;
 default:

	$w->showWorkerHeader($o->worker_id);
	$token=$s->createToken($tokenlife,"CREATE_CKP");
	$o->showInputForm("new",0,$token);
	$o->showLoanPaymentTable("WHERE m.worker_id=$o->worker_id","ORDER BY m.loanpayment_date asc",0,9999);
 break;


}


echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

//convert 4 criterial into 1 search string
function cvSearchString($document_no,$loanpayment_date,$nextpayment_date,$worker_id,$company_id,$doctor,$clinic,$loanpayment_status){
$filterstring="";
$needand="";
if($worker_id > 0 ){
	$filterstring=$filterstring . " worker_id=$worker_id";
	$needand='AND';
}
else
	$needand='';

if($worker_code!=""){
	$filterstring=$filterstring . " $needand worker_code LIKE '$worker_code' ";
	$needand='AND';
}
else
$needand='';

if ($worker_name!=""){
$filterstring=$filterstring . " $needand worker_name LIKE '$worker_name'";
	$needand='AND';
}
else
	$needand='';

if($ic_no!="")
$filterstring=$filterstring . "  $needand ic_no LIKE '$ic_no'";
	
return $filterstring;
}

?>

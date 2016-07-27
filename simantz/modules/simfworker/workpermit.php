<?php
include "system.php";
include "menu.php";
include "class/WorkPermit.php";
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
$o = new WorkPermit($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$w = new Worker($xoopsDB,$tableprefix,$log);
$cr = new Currency($xoopsDB,$tableprefix,$log);

$action="";
echo <<< EOF

<script type="text/javascript">
	function validateWorkPermit(){
	var myaction=document.frmWorkPermit.action.value;
	var transactiondate=document.frmWorkPermit.transactiondate.value;

	//!isDate() 
	var additionalstring="";
	var permitstatus;
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
		var id=document.frmWorkPermit.tuitionclass_id.value;
		window.open("tuitionclass.php?action=edit&tuitionclass_id="+id);
	}

</script>
EOF;

$o->workpermit_id=0;
$o->worker_id=0;
$o->company_id=0;
if (isset($_POST['action'])){

	$action=$_POST['action'];
	$o->workpermit_id=$_POST["workpermit_id"];

	if(isset($_POST['worker_id']))
		$o->worker_id=$_POST['worker_id'];
	if(isset($_POST['company_id']))
		$o->company_id=$_POST['company_id'];

}
elseif(isset($_GET['action'])){

	$action=$_GET['action'];

	$o->workpermit_id=$_GET["workpermit_id"];

	if(isset($_GET['worker_id']))
		$o->worker_id=$_GET['worker_id'];
	if(isset($_GET['company_id']))
		$o->company_id=$_GET['company_id'];
}

else
$action="";
$o->worker_id=$_POST['worker_id'];
$o->company_id=$_POST['company_id'];
$o->register_date=$_POST['register_date'];
$o->expired_date=$_POST['expired_date'];
$o->register_dateto=$_POST['register_dateto'];
$o->expired_dateto=$_POST['expired_dateto'];
$o->document_no=$_POST['document_no'];

$o->permitstatus=$_POST['permitstatus'];
$o->description=$_POST['description'];
$o->othersinfo=$_POST['othersinfo'];
$o->created=date("y/m/d H:i:s", time()) ;
$o->updated=date("y/m/d H:i:s", time()) ;
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->showcalendar1=$dp->show("register_date");
$o->showcalendar2=$dp->show("expired_date");
$o->showcalendar1to=$dp->show("register_dateto");
$o->showcalendar2to=$dp->show("expired_dateto");
$token=$_POST['token'];

switch ($action){
 case "create":
	if ($s->check(false,$token,"CREATE_CKP")){
		$log->showlog(3,"Saving data for worker_id=$o->worker_id, and company_id=$o->company_id");
		if($o->insertWorkPermit()){
		 $latest_id=$o->getLatestWorkPermitID();

		 redirect_header("workpermit.php?action=edit&workpermit_id=$latest_id",$pausetime,"Your data is saved.");
		}
		else
		redirect_header("workpermit.php?action=choose&worker_id=$o->worker_id",$pausetime,"You data cannot be save, return to previous page");
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
	$log->showlog(3,"Saving data for Worker_id=$o->worker_id, and class_id=$o->workpermit_id");
	if ($s->check(false,$token,"CREATE_CKP")){
		if($o->updateWorkPermit()){ //if data save successfully
			redirect_header("workpermit.php?action=edit&workpermit_id=$o->workpermit_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("workpermit.php?action=edit&workpermit_id=$o->workpermit_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("workpermit.php?action=edit&workpermit_id=$o->workpermit_id",$pausetime,"Warning! Can't save the data, due to form's token expired, please re-enter the data.");
	}
 break;
 case "searchform":
	$o->companyctrl=$c->getSelectCompany(-1);
	$o->workerctrl=$w->getSelectWorker(-1);
	$o->showSearchForm();
	$o->showWorkPermitTable("","ORDER BY m.register_date desc,c.company_name,w.worker_name",0,50);

 break;
 case "search":
	$log->showlog(3,"Search Worker_id=$o->worker_id,worker_code=$o->worker_code,worker_name=$o->worker_name,ic_no=$o->ic_no");
	$o->companyctrl=$c->getSelectCompany(-1);
	$o->workerctrl=$w->getSelectWorker(-1);
	$o->showSearchForm();

	$wherestring=cvSearchString($o->document_no,$o->register_date,$o->register_dateto,
			$o->expired_date,$o->expired_dateto,
			$o->worker_id,$o->company_id,$o->permitstatus);

	$o->showWorkPermitTable($wherestring,"ORDER BY m.register_date desc,c.company_name,w.worker_name",0,50);

 break;
 case "delete":
	if ($s->check(false,$token,"CREATE_CKP")){
		if($o->deleteWorkPermit($o->workpermit_id))
			redirect_header("workpermit.php?action=choosed&worker_id=$o->worker_id",$pausetime,"Data removed successfully.");
		else
			redirect_header("workpermit.php?action=edit&workpermit_id=$o->workpermit_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("workpermit.php?action=edit&workpermit_id=$o->workpermit_id",$pausetime,"Warning! Can't delete data from database due to token expired, please re-delete the data.");
 break;
 case "edit":
	$log->showlog(3,"Editing data workpermit_id:$o->workpermit_id");

	if ($o->fetchWorkPermitInfo($o->workpermit_id)){
		$o->workerctrl=$w->getSelectWorker($o->worker_id);
		$token=$s->createToken($tokenlife,"CREATE_CKP");
		$o->companyctrl=$c->getSelectCompany($o->company_id);
		$o->currencyctrl=$cr->getSelectCurrency($o->currency_id);
		$o->showInputForm('edit',$o->workpermit_id,$token);
		$o->showWorkPermitTable("","ORDER BY m.register_date desc,c.company_name,w.worker_name",0,50);
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
	$o->companyctrl=$c->getSelectCompany(0);
	$o->workerctrl=$w->getSelectWorker(0);
	$token=$s->createToken($tokenlife,"CREATE_CKP");
	$o->showInputForm("new",0,$token);
	$o->showWorkPermitTable("","ORDER BY m.register_date desc,c.company_name,w.worker_name",0,50);
 break;


}


echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

//convert 4 criterial into 1 search string
function cvSearchString($document_no,$register_date,$register_dateto,$expired_date,
			$expired_dateto,$worker_id,$company_id,$permitstatus){
$filterstring="";

if($worker_id > 0 )
	$filterstring=$filterstring . " m.worker_id=$worker_id AND";

if($document_no!="")
	$filterstring=$filterstring." m.document_no LIKE '$document_no' AND";


if($company_id>0)
	$filterstring=$filterstring." m.company_id =$company_id AND";

if($register_date=="")
	$register_date="0000-00-00";

if($register_dateto=="")
	$register_dateto="9999-12-31";

if($expired_date=="")
	$expired_date="0000-00-00";

if($expired_dateto=="")
	$expired_dateto="9999-12-31";
//016-7769898/Thomas
	$filterstring=$filterstring." m.register_date between '$register_date' AND '$register_dateto' AND";
	$filterstring=$filterstring." m.expired_date between '$expired_date' AND '$expired_dateto' AND";

if($permitstatus!="-")
	$filterstring=$filterstring." m.result = '$permitstatus' AND";

if ($filterstring=="")
	return "";
else {
	$filterstring =substr_replace($filterstring,"",-3);

	return "WHERE $filterstring";
	}
}

?>

<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Employee.php';
include_once 'class/Period.php';
include_once ("datepicker/class.datepicker.php");
include_once 'class/Payslip.php';
include_once 'class/PayslipLine.php';
include_once 'class/Log.php';
$log = new Log();
$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$period=new Period($xoopsDB,$tableprefix,$log);
$e=new Employee($xoopsDB,$tableprefix,$log);
$e->cur_symbol=$cur_symbol;
$o = new Payslip($xoopsDB,$tableprefix,$log);
$pl = new PayslipLine($xoopsDB,$tableprefix,$log);

$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);


echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		if(document.forms['frmPayslip'].needrecalculate.value=='Y'){
		alert('This Payslip need to re-calculate and save, please press "OK" to perform calculation.');
			document.forms['frmPayslip'].save.click();
		}
	}

</script>

EOF;

$o->payslip_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->payslip_id=$_POST["payslip_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->payslip_id=$_GET["payslip_id"];
	

}
else
$action="";

$token=$_POST['token'];

$o->showdatefrom=$dp->show("datefrom");
$o->showdateto=$dp->show("dateto");
$o->showpayslipdate=$dp->show("payslipdate");
$o->employee_id=$_POST['employee_id'];
$o->period_id=$_POST['period_id'];

$o->datefrom=$_POST['datefrom'];
$o->dateto=$_POST['dateto'];
$o->position=$_POST['position'];
$o->department=$_POST['department'];
$o->basicsalary=$_POST['basicsalary'];
$o->commissionamt=$_POST['commissionamt'];
$o->hourlycommisionamt=$_POST['hourlycommisionamt'];

$o->employee_epfamt=$_POST['employee_epfamt'];
$o->employee_socsoamt=$_POST['employee_socsoamt'];
$o->employee_pcbamt=$_POST['employee_pcbamt'];
$o->employer_epfamt=$_POST['employer_epfamt'];
$o->employer_socsoamt=$_POST['employer_socsoamt'];
$o->totalincomeamt=$_POST['totalincomeamt'];
$o->totaldeductamt=$_POST['totaldeductamt'];
$o->netpayamt=$_POST['netpayamt'];
$o->epfbaseamt=$_POST['epfbaseamt'];
$o->socsobaseamt=$_POST['socsobaseamt'];
$iscomplete=$_POST['iscomplete'];
$o->description=$_POST['description'];
$o->remarks=$_POST['remarks'];
$o->epftype=$_POST['epftype'];
$o->payslipdate=$_POST['payslipdate'];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$pl->cur_name=$cur_name;
$pl->cur_symbol=$cur_symbol;
$isactive=$_POST['isactive'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

$pl->payslipline_id=$_POST['payslipline_id'];
$pl->linepayslipline_id=$_POST['linepayslipline_id'];
$pl->linedescription=$_POST['linedescription'];
$pl->lineseqno=$_POST['lineseqno'];
$pl->lineiscalc_epf=$_POST['lineiscalc_epf'];
$pl->lineiscalc_socso=$_POST['lineiscalc_socso'];
$pl->lineamount=$_POST['lineamount'];

//line item
$pl->seqno=$_POST['addseqno'];
$pl->description=$_POST['adddescription'];
$pl->amount=$_POST['addamount'];
$pl->linetype=$_POST['addlinetype'];
if($_POST['addiscalc_epf']=='on')
$pl->iscalc_epf=1;
else
$pl->iscalc_epf=0;

if($_POST['addiscalc_socso']=='on')
$pl->iscalc_socso=1;
else
$pl->iscalc_socso=0;


if ($iscomplete=="Y" or $iscomplete=="on")
	$o->iscomplete='Y';
else
	$o->iscomplete='N';

echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Payroll Record</span></big></big></big></div><br>-->
EOF;

 switch ($action){
	//When user submit new organization
  case "create";
	$log->showLog(3,"Creating new payslip with paramenter employee_id:$o->employee_id,period_id:$o->period_id");
	$e->employee_id=$o->employee_id;
	$e->fetchEmployee($o->employee_id);

	$o->department=	$e->department;
	$o->epftype=$e->epftype;
	$o->basicsalary = $e->basicsalary;
	$o->position = $e->position;
	$pl->employee_id=$o->employee_id;

	switch($e->salarytype){
	case "B":
		$o->commissionamt=0;
		$o->hourlycommisionamt=0;
	break;
	case "C":
		$o->commissionamt=$o->getCommssionPercentAmt();
		$o->hourlycommisionamt=0;
	break;
	case "H":
		$o->commissionamt=0;
		$o->hourlycommisionamt=$o->getHourlyAmt();
	break;
	case "A":
		$o->commissionamt=$o->getCommssionPercentAmt();
		$o->hourlycommisionamt=$o->getAdditionalHourlyAmt();
	break;
	default:
		$o->commissionamt=0;
		$o->hourlycommisionamt=0;
	break;
	}

	if($o->autogenerate()) {
		$pl->payslip_id=$o->payslip_id;
		if($pl->createEmployeeItem())
			redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,
				"Record produced, redirect to new payslip.");
		else
		redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,
			"$errorstart Cannot generate default item for this employee,redirect you to this payslip$errorend");

	}
	else
		redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,
		"$errorstartRecord exist,redirect you to existing payslip $errorend");
  break;
  case "addnewitem":
	$log->showLog(3,"Adding new item into payslip");
	$msg = "";
	$pl->payslip_id=$o->payslip_id;
	if($pl->insertPaslipLine())
		$msg="New Item generated successfully";
	else
		$msg="$errorstartRecord could not add into this payslip due to internal error, 
			back to this payslip$errorend";	
		redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,
		$msg);

  break;
  case "enable":
	if($o->enablePayslip($o->payslip_id))
		redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,"Payslip re-activated, editing this record.");
	else
		redirect_header("listpayslip.php",$pausetime,"$errorstart Warning! This payslip can't reactivate! Probably there is internal error in database.$errorend");
  break;
  case "edit":
	if($o->fetchPayslip()){
	  if($o->iscomplete=='Y')
		redirect_header("listpayslip.php",$pausetime,
			"<b style='color:red;'>This payslip is completed,you need to re-activate if you 
				intend to do any modification.</b>");
		$token=$s->createToken($tokenlife,"CREATE_PRN");
		$e->employee_id=$o->employee_id;
		$e->fetchEmployee($o->employee_id);
		$e->showEmployeeHeader('N');
		//$o->commissionamt=
	//	$o->getCommssionPercentAmt();
		//$o->hourlycommisionamt=
	//	$o->getHourlyAmt();

		$pl->payslip_id=$o->payslip_id;
		$period->fetchPeriod($o->period_id);
		$o->period_name=$period->period_name;
		$o->incomesubtable=$pl->showPayslipLine($o->payslip_id,1);
		$o->deductsubtable=$pl->showPayslipLine($o->payslip_id,-1);
		$o->othersubtable=$pl->showPayslipLine($o->payslip_id,0);
		$o->linecount=$pl->currentlineno;
		$o->showInputForm($token);
		$pl->showInputForm();
		$o->showTutorCommissionTable($o->period_id,$o->employee_id);
	}
	else
		redirect_header("payslip.php",3,
		"$errorstart Cannot find this record, redirect back to payslip window.$errorend");
  break;
  case "update":
	if ($s->check(false,$token,"CREATE_PRN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$requestnewupdate='N';
		$removeitem_id=$_POST['removepayslipitem_id'];
		if($removeitem_id>0){
			$pl->deleteItem($removeitem_id);
			$requestnewupdate='Y';	
		}
		if($o->updatePayslip($requestnewupdate) && $pl->updatePayslipLine() && $o->calculation()){ //if data save successfully
			if($o->iscomplete=='Y')
			redirect_header("printpayslip.php?payslip_id=$o->payslip_id",$pausetime,"Your data is completed.");
			redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,
			 "$errorstartWarning! Can't save the data, please make sure all value
				 is insert properly.$errorend");
		}
	else{
		redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,
			"$errorstart Warning! You data cannot be save due to token expired, this 
				form will refresh for data entry.$errorend");
	}
  break;
  case "delete":
	if ($s->check(false,$token,"CREATE_PRN")){
		if($o->deletePayslip($o->payslip_id)){
			redirect_header("payslip.php",$pausetime,"Data removed successfully.");
		}
		else
			redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,"$errorstart Warning! Can't delete data from database.$errorend");
	}
	else
		redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,"$errorstart Warning! Can't delete data from database due to token expired.$errorend");
	
  break;

  default : //showsearch/generate form

	$o->periodctrl=$period->getPeriodList(0,'period_id','Y');
	$o->employeectrl=$e->getEmployeeList(0,'M','employee_id','Y');
	$o->showProcessHeader();

  break;

}

function generateWhereStr($isactive,$parents_name,$organization_id){

$filterstring="";
$needand="";
if ($isactive!="-"){
$filterstring=$filterstring . " p.isactive = '$isactive' AND";
}

if ($organization_id>=0){
$filterstring=$filterstring . " p.organization_id = $organization_id AND";
}

if ($parents_name!="")
$filterstring=$filterstring . " p.parents_name LIKE '$parents_name' AND";

if ($filterstring=="")
	return "WHERE p.parents_id>0";
else {
	$filterstring =substr_replace($filterstring,"",-3);  

	return "WHERE p.parents_id>0 AND $filterstring";
	}
}


echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

<?php
include_once "system.php" ;
include_once "menu.php";
include_once '../hr/class/Employee.php';
include_once '../system/class/Period.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
include_once 'class/Payslip.php';
include_once 'class/PayslipLine.php';
include_once 'class/Log.php';
include_once "../simbiz/class/AccountsAPI.php";

$log = new Log();
$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$period=new Period($xoopsDB,$tableprefix,$log);
$e=new Employee($xoopsDB,$tableprefix,$log);
$e->cur_symbol=$cur_symbol;
$o = new Payslip($xoopsDB,$tableprefix,$log);
$pl = new PayslipLine($xoopsDB,$tableprefix,$log);
$api = new AccountsAPI();

$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);

$o->isAdmin=$xoopsUser->isAdmin();
//marhan add here --> ajax
echo "<iframe src='payslip.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">

        function getListEmployee(period_id){

        self.location = "payslip.php?action=getlistemployee&period_id="+period_id;
        }

	function viewItineraryDetails(payslip_id,employee_id){
	
	self.location = 'selectitinerary.php?action=view&employee_id='+employee_id+'&payslip_id='+payslip_id;
	//window.open('itinerary.php?itinerary_id='+itinerary_id);
	}

	function viewPayslip(payslip_id,count_itinerary){
	
	window.open('printpayslip.php?payslip_id='+payslip_id);
	if(count_itinerary>0)
	window.open('itinerarypayslip.php?payslip_id='+payslip_id);
	}

	function ProcessPayslip(employee_id,period_id){

	var arr_fld=new Array("action","employee_id","period_id");//name for POST
	var arr_val=new Array("processpayslip",employee_id,period_id);//value for POST
	
	getRequest(arr_fld,arr_val);
	}

	function validateGeneratePayslip(){
	var employee_id=document.forms['frmGeneratePayslip'].employee_id.value;
	var period_id=document.forms['frmGeneratePayslip'].period_id.value;
	if(confirm('Confirm to generate new payslip?')){
		if(employee_id ==0 || period_id==0){
			alert("Please make sure you'd choose proper employee and period!");
			return false;	
		}
		else
			return true;
	}
	else
		return false;

	}

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

if(isset($_POST['period_id']))
$o->period_id=$_POST['period_id'];
else
$o->period_id=$_GET['period_id'];

$o->batch_id=$_POST['batch_id'];
$o->batch_no=$_POST['batch_no'];

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

EOF;

 switch ($action){
	//When user submit new organization
  case "create";
	$log->showLog(3,"Creating new payslip with paramenter employee_id:$o->employee_id,period_id:$o->period_id");
	$e->employee_id=$o->employee_id;
	$e->fetchEmployee($o->employee_id);

        $o->employee_epfrate=$e->employee_epfrate;
	$o->department=	$e->department_name;
	$o->basicsalary = $e->employee_salary;
	$o->position = $e->jobposition_name;
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
        $pl->datefrom=$o->datefrom;
        $pl->dateto=$o->dateto;
        $pl->employee_id=$o->employee_id;
        $pl->basicsalary=$o->basicsalary;

		if($pl->createEmployeeItem()){

		redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,
				"Record produced, redirect to new payslip.");
		}else
		redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,
			"<b style='color:red;'>Cannot generate default item for this employee,redirect you to this payslip</b>");

	}
	else
		redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,
		"<b style='color:red;'>Record exist,redirect you to existing payslip</b>");
  break;
  case "addnewitem":
	$log->showLog(3,"Adding new item into payslip");
	$msg = "";
	$pl->payslip_id=$o->payslip_id;
	if($pl->insertPaslipLine())
		$msg="New Item generated successfully";
	else
		$msg="<b style='color:red;'>Record could not add into this payslip due to internal error, 
			back to this payslip</b>";	
		redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,
		$msg);

  break;
  case "enable":
	if($o->enablePayslip($o->payslip_id)){

	
	// simbiz AccountsAPI function here
	$return_true = $api->reverseBatch($o->batch_id);

	if($return_true){
	$o->updateBatchInfoPayslip("batch_id",0,$o->payslip_id);
	$o->updateBatchInfoPayslip("batch_no","",$o->payslip_id);
	}else{
	$o->enablePayslip($o->payslip_id,'Y');
	}
	// end of simbiz AccountsAPI function
	

	redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,"Payslip re-activated, editing this record.");
	}else
	redirect_header("listpayslip.php",$pausetime,"This payslip can't reactivate! Probably there is internal error in database.");
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

        $o->employee_epfrate=	$e->employee_epfrate;
		$pl->payslip_id=$o->payslip_id;
		$period->fetchPeriod($o->period_id);
		$o->period_name=$period->period_name;
		$o->incomesubtable=$pl->showPayslipLine($o->payslip_id,1);
		$o->deductsubtable=$pl->showPayslipLine($o->payslip_id,-1);
		$o->othersubtable=$pl->showPayslipLine($o->payslip_id,0);
		$o->linecount=$pl->currentlineno;
		$o->showInputForm($token);
		$pl->showInputForm();
		//$o->showTutorCommissionTable($o->period_id,$o->employee_id);
	}
	else
		redirect_header("payslip.php",3,
		"<b style='color:red;'>Cannot find this record, redirect back to payslip window.</b>");
  break;
  case "update":
	if ($s->check(false,$token,"CREATE_PRN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$requestnewupdate='N';
		$removeitem_id=$_POST['removepayslipitem_id'];
        $e->fetchEmployee($o->employee_id);

        $o->employee_epfrate=	$e->employee_epfrate;

		if($removeitem_id>0){
			$pl->deleteItem($removeitem_id);
			$requestnewupdate='Y';	
		}
		if($o->updatePayslip($requestnewupdate) && $pl->updatePayslipLine() && $o->calculation()){ //if data save successfully
		
			if($o->iscomplete=='Y'){

			$return_true = false;
			if(checkExtraAccount()){// add import function here
			$list_import = $o->batchImportAPIPayslip($o->payslip_id);
			$uid = $xoopsUser->getVar('uid');
			//echo $list_import[6][1];
	
            /*
            PostBatch($uid,$date,$systemname,$batch_name,
            $description,$totaltransactionamt,$documentnoarray,$accountsarray,
            $amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,
            $transtypearray,$linetypearray,$chequenoarray,$linedesc="")
            *
            */

			/*$return_true = $api->PostBatch($uid,$list_import[0],$list_import[1],$list_import[2],
            $list_import[3],$list_import[4],$list_import[5],$list_import[6],
            $list_import[7],$list_import[8],$list_import[9],$list_import[10],$list_import[11],
            $list_import[12],$list_import[13],$list_import[14]);
	
			if($return_true){
			$o->updateBatchInfoPayslip("batch_id",$api->resultbatch_id,$o->payslip_id);
			$o->updateBatchInfoPayslip("batch_no",$api->resultbatch_no,$o->payslip_id);*/

			//if($o->checkItineraryPayslip($o->payslip_id) > 0)
			//echo "<script type='text/javascript'>window.open('itinerarypayslip.php?payslip_id=$o->payslip_id');</script>";

			redirect_header("printpayslip.php?payslip_id=$o->payslip_id",$pausetime,"Your data is completed.");
			//}
			
			}// end of import function

			if($return_true==false){//if cant post
			$o->iscomplete = 'N';
			$o->updatePayslip($requestnewupdate);
			$pl->updatePayslipLine();
			$o->calculation();
			redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,"Your data is saved.");
			
			}

			
			}
			
			redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,
			 "<b style='color:red;'>Warning! Can't save the data, please make sure all value
				 is insert properly.</b>");
		}
	else{
		redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,
			"<b style='color:red;'>Warning! You data cannot be save due to token expired, this 
				form will refresh for data entry.</b>");
	}
  break;
  case "delete":
	if ($s->check(false,$token,"CREATE_PRN")){
		if($o->deletePayslip($o->payslip_id)){
			redirect_header("payslip.php",$pausetime,"Data removed successfully.");
		}
		else
			redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("payslip.php?action=edit&payslip_id=$o->payslip_id",$pausetime,"Warning! Can't delete data from database due to token expired.");
	
  break;

  case "processpayslip":

	$employee_id = $_POST["employee_id"];
	$period_id = $_POST["period_id"];
	
	$exist_payslip_id = $o->getExistPayslip($employee_id,$period_id);
	
	if($exist_payslip_id > 0)
	echo "<script type='text/javascript'>
	alert('Record Exist. Redirect To Record');
	self.parent.location = 'payslip.php?action=edit&payslip_id=$exist_payslip_id';
	</script>";

    /*
	$isitinerary = $o->checkItineraryList($employee_id);

	if($isitinerary > 0)
	echo "<script type='text/javascript'>
	if(self.parent.validateGeneratePayslip()){
	self.parent.document.getElementById('ifItineraryList').src = 'selectitinerary.php?employee_id=$employee_id&payslip_id=$o->payslip_id';
	self.parent.document.getElementById('trIDIFrame').style.display = '';
	}
	</script>";
	else
     *      * */
     
	echo "<script type='text/javascript'>
	self.parent.document.getElementById('trIDIFrame').style.display = 'none';
	if(self.parent.validateGeneratePayslip()){
	self.parent.document.forms['frmGeneratePayslip'].submit();
	}
	</script>";

     
  break;

  case "processgenerate" : //showsearch/generate form
	$o->periodctrl=$ctrl->getSelectPeriod($o->period_id,'Y',"","period_id",'');
	$o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,'Y',"","employee_id",'');
	//$o->employeectrl=$e->getEmployeeList(0,'M','employee_id','Y');
	//$o->periodctrl=$period->getPeriodList(0,'period_id','Y');
	//$o->employeectrl=$e->getEmployeeList(0,'M','employee_id','Y');
	$o->showProcessHeader();

  break;

  case "getlistemployee" :

      	$o->periodctrl=$ctrl->getSelectPeriod($o->period_id,'Y',"onchange=getListEmployee(this.value)","period_id",'');


	$o->showTablePeriod();
        $o->getListEmployee($o->period_id);
  break;

  default : //showsearch/generate form
	$o->periodctrl=$ctrl->getSelectPeriod(0,'Y',"onchange=getListEmployee(this.value)","period_id",'');

	
	$o->showTablePeriod();

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

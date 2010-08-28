<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once 'class/BankReconcilation.php';
include_once 'class/Transaction.php';

//include_once 'class/SelectCtrl.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
//include_once "../system/class/Period.php";
$dp=new datepicker($url);
$dp->dateFormat='Y-m-d';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


//$log = new Log();

$s = new XoopsSecurity();

$trans= new Transaction();
$o = new BankReconcilation();
$orgctrl="";


$action="";

//marhan add here --> ajax
echo "<iframe src='bankreconcilation.php' name='nameValidate' id='idValidate' style='display:none' width='100%'></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">


	function refreshAccounts(accounts_id){
		//batchdate = document.forms['frmBankReconcilation'].batchdate.value;
		var id = document.forms['frmBankReconcilation'].bankreconcilation_id.value;

		var arr_fld=new Array("action","accounts_id","bankreconcilation_id");//name for POST
		var arr_val=new Array("refreshaccounts",accounts_id,id);//value for POST
	
	//	if(accounts_id>0)
		getRequest(arr_fld,arr_val);

	}

	function autofocus(){
		document.forms['frmBankReconcilation'].statementbalance.focus();
		document.forms['frmBankReconcilation'].statementbalance.select();
		calculation();
	}


	function calculateBalance(){
		var linecount=document.forms['frmBankReconcilation'].linecount.value;
		var differencamtctrl=document.forms['frmBankReconcilation'].differenceamt;
		var statementbalancectrl=document.forms['frmBankReconcilation'].statementbalance;
		var laststatementbalancectrl=document.forms['frmBankReconcilation'].laststatementbalance;
		var accountbalancectrl=document.forms['frmBankReconcilation'].account_balance;
		var btncompletectrl=document.forms['frmBankReconcilation'].btncomplete;
		var reconcilamtctrl=document.forms['frmBankReconcilation'].reconcilamt;
		var unreconcilamtctrl=document.forms['frmBankReconcilation'].unreconcilamt;

		var reconcilamt=0;
		var unreconcilamt=0;

		for(i=0;i<linecount;i++){
			if(document.getElementById("linecheck"+i).checked==true)
				reconcilamt=reconcilamt+parseFloat(document.getElementById("lineamt"+i).value);
			else
				unreconcilamt=unreconcilamt+parseFloat(document.getElementById("lineamt"+i).value);

		}
		
		differencamtctrl.value=(parseFloat(laststatementbalancectrl.value)+parseFloat(reconcilamt) -parseFloat(statementbalancectrl.value)).toFixed(2) ;
		/*
		differencamtctrl.value=(parseFloat(laststatementbalancectrl.value)+parseFloat(reconcilamt) -parseFloat(statementbalancectrl.value)).toFixed(2) ;
		*/
		reconcilamtctrl.value=parseFloat(reconcilamt) ;
		unreconcilamtctrl.value=parseFloat(unreconcilamt) ;

		if(differencamtctrl.value==0)
			btncompletectrl.style.display="";
		else
			btncompletectrl.style.display="none";

	}

		function validateBankReconcilation(){
			accounts = document.forms['frmBankReconcilation'].accounts_id.value;
			statementbalance = document.forms['frmBankReconcilation'].statementbalance.value;
			bankreconcilationdate = document.forms['frmBankReconcilation'].bankreconcilationdate.value;

			if(confirm('Save Record?')){

			if(accounts == 0){
			alert("Please Select Banks Accounts");
			return false;
			}else{

			if(!IsNumeric(statementbalance)){
			alert("Make sure New Statement Balance is numeric.");
			return false;
			}else{

			if(!isDate(bankreconcilationdate)){
			return false;
			}else
			return true;

			}

			}

			}else
			return false;
			
		}
</script>

EOF;

$o->bankreconcilation_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->bankreconcilation_id=$_POST["bankreconcilation_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->bankreconcilation_id=$_GET["bankreconcilation_id"];

}
else
$action="";

$token=$_POST['token'];



$reuse=$_POST['reuse'];
$o->organization_id=$_POST['organization_id'];
$o->bankreconcilationno=$_POST['bankreconcilationno'];

//$period= new Period();
$o->accounts_id=$_POST['accounts_id'];
$o->differenceamt=$_POST['differenceamt'];
$o->iscomplete=$_POST['iscomplete'];
$o->period_id=$_POST['period_id'];
$o->statementbalance=$_POST['statementbalance'];
$o->bankreconcilationdate=$_POST['bankreconcilationdate'];
$o->laststatementdate=$_POST['laststatementdate'];
$o->laststatementbalance=$_POST['laststatementbalance'];
$o->account_balance=$_POST['account_balance'];
$o->reconcilamt=$_POST['reconcilamt'];
$o->unreconcilamt=$_POST['unreconcilamt'];

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$o->createdby;
$trans->createdby=$o->createdby;
$trans->updatedby=$trans->createdby;

$trans->linetrans_id=$_POST['linetrans_id'];
$trans->linechecked=$_POST['linechecked'];
$o->showcalendar=$dp->show("bankreconcilationdate");

$o->bankreconcilationdatefrom=$_POST['bankreconcilationdatefrom'];
$o->bankreconcilationdateto=$_POST['bankreconcilationdateto'];


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with bankreconcilation name=$o->bankreconcilation_name");

	if ($s->check(false,$token,"CREATE_ACG")){
		
		
		
	if($o->insertBankReconcilation()){
		$latest_id=$o->getLatestBankReconcilationID();
		$trans->updateBankReconcilationInfo($latest_id);
		redirect_header("bankreconcilation.php?action=edit&bankreconcilation_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");

	}else {
		
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->accountsctrl=$simbizctrl->getSelectAccounts($o->accounts_id,'Y',"onchange='refreshAccounts(this.value)'",
			"accounts_id",'and account_type=4');
		$o->periodctrl=$simbizctrl->getSelectPeriod($o->period_id);
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->getInputForm("new",-1,$token);

		}
	}else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data

		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->periodctrl=$simbizctrl->getSelectPeriod($o->accounts_id,'N');
		$o->periodctrl=$simbizctrl->getSelectPeriod($o->period_id);
		$o->accountsctrl=$simbizctrl->getSelectAccounts($o->accounts_id,'Y',"onchange='refreshAccounts(this.value)'",
			"accounts_id",'and account_type=4');
		$o->getInputForm("new",-1,$token);
	}
 
break;
	//when user request to edit particular organization
  case "edit" :

	if($o->fetchBankReconcilation($o->bankreconcilation_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->periodctrl=$simbizctrl->getSelectPeriod($o->accounts_id,'N');
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->accountsctrl=$simbizctrl->getSelectAccounts($o->accounts_id,'Y',"onchange='refreshAccounts(this.value)'",
			"accounts_id",'and account_type=4','Y');
		$o->transctrl=$o->genChildList($o->accounts_id,$o->bankreconcilation_id,$o->iscomplete);
		$o->periodctrl=$simbizctrl->getSelectPeriod($o->period_id);
		//$o->transactiontable=$trans->showTransTable($o->bankreconcilation_id,$o->iscomplete);
		$o->getInputForm("edit",$o->bankreconcilation,$token);	
		}
	else	//if can't find particular organization from database, return error message
		redirect_header("bankreconcilation.php",3,"Some error on viewing your bankreconcilation data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
			$trans->updateBankReconcilationInfo($o->bankreconcilation_id,$o->bankreconcilationdate);
			if( $o->updateBankReconcilation()) {
			//if data save successfully
			redirect_header("bankreconcilation.php?action=edit&bankreconcilation_id=$o->bankreconcilation_id",$pausetime,"Your data is saved.");

		}
		else
			redirect_header("bankreconcilation.php?action=edit&bankreconcilation_id=$o->bankreconcilation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("bankreconcilation.php?action=edit&bankreconcilation_id=$o->bankreconcilation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		
		//if($o->iscomplete == 1){		
		//$trans->reverseSummary($o->bankreconcilation_id);
		//}

		if($o->deleteBankReconcilation($o->bankreconcilation_id)){
			redirect_header("bankreconcilation.php",$pausetime,"Data removed successfully.");
		}else
			redirect_header("bankreconcilation.php?action=edit&bankreconcilation_id=$o->bankreconcilation_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("bankreconcilation.php?action=edit&bankreconcilation_id=$o->bankreconcilation_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "reactivate" :
		if($o->fetchBankReconcilation($o->bankreconcilation_id)){
		$o->iscomplete=0;
		$o->updateBankReconcilation();


		redirect_header("bankreconcilation.php?action=edit&bankreconcilation_id=$o->bankreconcilation_id",$pausetime,"Your data is reactivated.");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("bankreconcilation.php",3,"Some error on viewing your bankreconcilation data, probably database corrupted");
	
  break;


  case "showsearchform":
	//$o->periodctrl=$ctrl->getSelectPeriod(0,'N');
	$o->accountsctrl=$simbizctrl->getSelectAccounts(0,'Y',"","accounts_id",'and account_type=4');
	$o->showcalendarfrom=$dp->show("bankreconcilationdatefrom");
	$o->showcalendarto=$dp->show("bankreconcilationdateto");
	$o->periodctrl=$simbizctrl->getSelectPeriod(0,"Y","","period_id", " and period_id > 0 ");
	$o->showSearchForm();
  break;

  case "search":
	
	//$o->periodctrl=$ctrl->getSelectPeriod(0,'N');
	$o->accountsctrl=$simbizctrl->getSelectAccounts($o->accounts_id,'Y',"","accounts_id",'and account_type=4');
	$o->showcalendarfrom=$dp->show("bankreconcilationdatefrom");
	$o->showcalendarto=$dp->show("bankreconcilationdateto");
	$o->periodctrl=$simbizctrl->getSelectPeriod($o->period_id,"Y","","period_id", " and period_id > 0 ");
	$o->showSearchForm();
	//$o->periodctrl=$ctrl->getSelectPeriod();
	$wherestr = $o->genWhereString($o->bankreconcilationdatefrom,$o->bankreconcilationdateto,
			$o->bankreconcilationno,$o->accounts_id,$o->period_id,$o->iscomplete);
	$o->showBankReconcilationTable("$wherestr"," order by br.bankreconcilationdate ");
  break;

 

  case "refreshaccounts" :
	$accounts_id=$_POST['accounts_id'];
	$bankreconcilation_id=$_POST['bankreconcilation_id'];
	include_once "class/Accounts.php";
	$acc= new Accounts();
	$acc->fetchAccounts($accounts_id);
	$childtable=$o->genChildList($accounts_id,$bankreconcilation_id);

	if($accounts_id!=0){
		if($o->getLastStatementInfo($accounts_id)){
		$laststatementdate=$o->laststatementdate;
		$laststatementbalance=$o->laststatementbalance;
		}
		else{
			$laststatementdate="0000-00-00";
			$laststatementbalance=0;
		}
	}
	else{
		$laststatementdate="";
		$laststatementbalance="";

	}

echo <<< EOF
	<script type="text/javascript">
		self.parent.document.forms['frmBankReconcilation'].account_balance.value = ($acc->lastbalance).toFixed(2);
		self.parent.document.forms['frmBankReconcilation'].differenceamt.value = 0;
		self.parent.document.forms['frmBankReconcilation'].laststatementdate.value = "$laststatementdate";
		self.parent.document.forms['frmBankReconcilation'].laststatementbalance.value = "$laststatementbalance";
		self.parent.document.forms['frmBankReconcilation'].statementbalance.value = ($acc->lastbalance).toFixed(2);
		self.parent.document.getElementById("childtable").innerHTML="$childtable";

	</script>
EOF;

  break;

  default :

	
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	$o->accountsctrl=$simbizctrl->getSelectAccounts(0,'Y',"onchange='refreshAccounts(this.value)'",
		"accounts_id",'and account_type=4');
	$o->periodctrl=$simbizctrl->getSelectPeriod(0);
	$o->getInputForm("new",0,$token);
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

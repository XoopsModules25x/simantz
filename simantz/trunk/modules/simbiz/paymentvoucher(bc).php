<?php
include "system.php";
include "menu.php";
include_once 'class/Log.php';
include_once 'class/PaymentVoucher.php';
include_once 'class/SelectCtrl.php';
include_once "../../class/datepicker/class.datepicker.php";
//include_once "../system/class/Period.php";
$dp=new datepicker($url);
$dp->dateFormat='Y-m-d';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$o = new PaymentVoucher();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
$orgctrl="";


$action="";
//marhan add here --> ajax
echo "<iframe src='paymentvoucher.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////
echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	document.frmPaymentVoucher.paymentvoucher_date.focus();
	document.frmPaymentVoucher.paymentvoucher_date.select();
	}


	function validatePaymentVoucher(){
		
	/*	var documentno=document.forms['frmReceipt'].receipt_no.value;
		var paidfrom=document.forms['frmReceipt'].paidfrom.value;
		var exchangerate=document.forms['frmReceipt'].exchangerate.value;
		var divbpartner =document.getElementById("divbpartner");
		var bpartnerctrl = document.getElementById("bpartner_id2") ? document.getElementById("bpartner_id2") : false;
		
		if(bpartnerctrl==false)
			alert('no bpartner');
		else
			alert('have bpartner');
*/
		var documentno=document.forms['frmPaymentVoucher'].paymentvoucher_no.value;
		var paidto=document.forms['frmPaymentVoucher'].paidto.value;
		var exchangerate=document.forms['frmPaymentVoucher'].exchangerate.value;
		var accountsfrom=document.forms['frmPaymentVoucher'].accountsfrom_id.value;
		//var bpartner_id2=document.forms['frmReceipt'].bpartner_id2.value;
		var accountsto=document.forms['frmPaymentVoucher'].accountsto_id.value;
		var originalamt=document.forms['frmPaymentVoucher'].originalamt.value;
	
		if(confirm("Save record?")){

		if(documentno=="" || accountsfrom==0 || accountsto==0){
		alert("Please make sure Payment Voucher No No, From Accounts, To Accounts is filled in.");
		return false;
		}else{
			
			if(!IsNumeric(exchangerate) || !IsNumeric(originalamt)){
			alert("Please make sure Exchange Rate and Amount filled in with numeric.");
			return false;
			}else{
			var paymentvoucher_date=document.forms['frmPaymentVoucher'].paymentvoucher_date.value;
			if(!isDate(paymentvoucher_date)){
			return false;
			}else
			return true;
			}
		}

		}else
			return false;
	}

	function reloadAccountFrom(accounts_id){

	var arr_fld=new Array("action","accounts_id");//name for POST
	var arr_val=new Array("refreshaccountsfrom",accounts_id);//value for POST
	
	getRequest(arr_fld,arr_val);

	}
	function reloadAccountTo(accounts_id){

	var arr_fld=new Array("action","accounts_id");//name for POST
	var arr_val=new Array("refreshaccountsto",accounts_id);//value for POST
	
	getRequest(arr_fld,arr_val);

	}
	function refreshCurrency(currency_id){

	var arr_fld=new Array("action","currency_id");//name for POST
	var arr_val=new Array("refreshcurrency",currency_id);//value for POST

	getRequest(arr_fld,arr_val);


	}
function changePaidTo(ctrl){
		try {
		var selected_text =ctrl.options[ctrl.selectedIndex].text;
		document.forms['frmPaymentVoucher'].paidto.value=selected_text;
		document.forms['frmPaymentVoucher'].bpartner_id.value=ctrl.value;
		}catch (error) {
		document.forms['frmPaymentVoucher'].paidto.value="";
		}

		
	}
</script>

EOF;

$o->paymentvoucher_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->paymentvoucher_id=$_POST["paymentvoucher_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->paymentvoucher_id=$_GET["paymentvoucher_id"];

}
else
$action="";

$token=$_POST['token'];

$o->paidto=$_POST["paidto"];

$iscomplete=$_POST['iscomplete'];
$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->currency_id=$_POST['currency_id'];
$o->bpartner_id=$_POST['bpartner_id'];
$o->paymentvoucher_no=$_POST['paymentvoucher_no'];
$o->amt=$_POST['amt'];
$o->chequeno=$_POST['chequeno'];
$o->originalamt=$_POST['originalamt'];
$o->paidto=$_POST['paidto'];
$o->batch_id=$_POST['batch_id'];
$o->accountsfrom_id=$_POST['accountsfrom_id'];
$o->accountsto_id=$_POST['accountsto_id'];
$o->exchangerate=$_POST['exchangerate'];
$o->paymentvoucher_date=$_POST['paymentvoucher_date'];
$o->receivedby=$_POST['receivedby'];
$o->isAdmin=$xoopsUser->isAdmin();
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->showCalendar=$dp->show('paymentvoucher_date');
$o->showDateFrom=$dp->show('datefrom');
$o->showDateTo=$dp->show('dateto');
$chkAddNew=$_POST['chkAddNew'];
if ($iscomplete==1 or $iscomplete=="on")
	$o->iscomplete=1;
else
	$o->iscomplete=0;


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with paymentvoucher name=$o->paidto");

	if ($s->check(false,$token,"CREATE_ACG")){
		


	  if($o->insertPaymentVoucher()){
		 $latest_id=$o->getLatestPaymentVoucherID();
		if($o->iscomplete==1){
			include_once "class/AccountsAPI.php";
			$accapi=new AccountsAPI();
			$accountsarray=array($o->accountsfrom_id,$o->accountsto_id);
			$amtarray=array($o->amt,$o->amt*-1);
			$currencyarray=array($o->currency_id,$o->currency_id);
			$conversionarray=array($o->exchangerate,$o->exchangerate);
			$bpartnerarray=array(0,$o->bpartner_id);
			$originalamtarray=array($o->originalamt,$o->originalamt*-1);
			$transtypearray=array("","");
			$linetypearray=array(0,1);
			$documentnoarray=array($o->paymentvoucher_no,$o->paymentvoucher_no);
			$chequenoarray=array($o->chequeno,$o->chequeno);
			$result=$accapi->PostBatch($o->createdby,$o->paymentvoucher_date,"simbiz","Post from Simbiz payment voucher $o->paymentvoucher_no",
				$o->description,$o->amt,$documentnoarray,
				$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,
				$transtypearray,$linetypearray,$chequenoarray);

			if($result){

				$o->fetchPaymentVoucher($latest_id);
				$o->batch_id=$accapi->resultbatch_id;
				$o->iscomplete=1;
				$o->paymentvoucher_id=$latest_id;
				$o->updatePaymentVoucher();
			}
			else{
				$o->fetchPaymentVoucher($latest_id);
				$o->iscomplete=0;
				$o->updatePaymentVoucher();
			 redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$latest_id",$pausetime,"<b style='color:red'>Your data is saved but can't complete due to internal error on posting. Reverse this document to draft mode.</b>");
			}
			

		}

		if($chkAddNew=='on')
			 redirect_header("paymentvoucher.php",$pausetime,"Your data is saved, creating new record");
		else
			 redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$latest_id",$pausetime,"Your data is saved");

		}
	  else {
			echo "<b style='color:red'>Record cannot save, please reverified data you insert into this record.</b>";
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->accountsfromctrl=$ctrl->getSelectAccounts($o->accountsfrom_id,'Y',"onchange='reloadAccountFrom(this.value)' ",
			"accountsfrom_id","and (account_type=4 or account_type=7)");
		$o->accountstoctrl=$ctrl->getSelectAccounts($o->accountsto_id,'Y',"onchange='reloadAccountTo(this.value)'",
			"accountsto_id","and (account_type=1 OR account_type=2 OR account_type=3)");
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N',"currency_id","","onchange='refreshCurrency(this.value)'");

		include_once "class/Accounts.php";
		$acc= new Accounts();
		$acc->fetchAccounts($o->accountsfrom_id);
		if($acc->account_type==2)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'N',"onchange='changePaidTo(this)'",
			"bpartner_id",	" and (debtoraccounts_id = $o->accountsto_id and isdebtor=1) ",'N',"bpartner_id");
		elseif( $acc->account_type==3)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'N',"onchange='changePaidTo(this)'",
			"bpartner_id",	" and (creditoraccounts_id = $o->accountsto_id and iscreditor=1) ",'N',"bpartner_id");

		$acc->fetchAccounts($o->accountsto_id);

		if($acc->account_type==4)
				$o->displaychequenostyle="";
		else
				$o->displaychequenostyle="style='display:none'";




		$o->getInputForm("new",-1,$token);
		$o->showPaymentVoucherTable("WHERE paymentvoucher_id>0 and organization_id=$defaultorganization_id","ORDER BY f.paidto"); 
		}

	}
	else{
		// if the token is not valid or the token is expired, it back to previous form with previous inputed data
			echo "<b style='color:red'>Record cannot save due to token expired, please resave this record.</b>";
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');

		$o->accountsfromctrl=$ctrl->getSelectAccounts($o->accountsfrom_id,'Y',"onchange='reloadAccountFrom(this.value)' ",
			"accountsfrom_id","and (account_type=4 or account_type=7)");
		$o->accountstoctrl=$ctrl->getSelectAccounts($o->accountsto_id,'Y',"onchange='reloadAccountTo(this.value)'",
			"accountsto_id","and (account_type=1 OR account_type=2 OR account_type=3)");
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N',"currency_id","","onchange='refreshCurrency(this.value)'");

		include_once "class/Accounts.php";
		$acc= new Accounts();
		$acc->fetchAccounts($o->accountsfrom_id);
		if($acc->account_type==2)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'N',"onchange='changePaidTo(this)'",
			"bpartner_id",	" and (debtoraccounts_id = $o->accountsto_id and isdebtor=1) ",'N',"bpartner_id");
		elseif( $acc->account_type==3)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'N',"onchange='changePaidTo(this)'",
			"bpartner_id",	" and (creditoraccounts_id = $o->accountsto_id and iscreditor=1) ",'N',"bpartner_id");

		$acc->fetchAccounts($o->accountsto_id);

		if($acc->account_type==4)
				$o->displaychequenostyle="";
		else
				$o->displaychequenostyle="style='display:none'";




		$o->getInputForm("new",-1,$token);
		$o->showPaymentVoucherTable("WHERE paymentvoucher_id>0 and organization_id=$defaultorganization_id","ORDER BY f.paidto"); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchPaymentVoucher($o->paymentvoucher_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');

		include_once "class/Accounts.php";
		$acc= new Accounts();
		$acc->fetchAccounts($o->accountsto_id);
		if($acc->account_type==2)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'N',"onchange='changePaidTo(this)'",
			"bpartner_id",	" and (debtoraccounts_id = $o->accountsto_id and isdebtor=1) ",'N',"bpartner_id");
		elseif( $acc->account_type==3)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'N',"onchange='changePaidTo(this)'",
			"bpartner_id",	" and (creditoraccounts_id = $o->accountsto_id and iscreditor=1) ",'N',"bpartner_id");


		$acc->fetchAccounts($o->accountsfrom_id);

		if($acc->account_type==4)
				$o->displaychequenostyle="";
		else
				$o->displaychequenostyle="style='display:none'";




		$o->accountsfromctrl=$ctrl->getSelectAccounts($o->accountsfrom_id,'Y',"onchange='reloadAccountFrom(this.value)' ",
			"accountsfrom_id","and (account_type=4 or account_type=7)");


		$o->accountstoctrl=$ctrl->getSelectAccounts($o->accountsto_id,'Y',"onchange='reloadAccountTo(this.value)'",
			"accountsto_id","and (account_type=1 OR account_type=2 OR account_type=3)");
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N',"currency_id","","onchange='refreshCurrency(this.value)'");


		$o->getInputForm("edit",$o->paymentvoucher,$token);
		$o->showPaymentVoucherTable("WHERE f.paymentvoucher_id>0 and f.organization_id=$defaultorganization_id","ORDER BY f.paymentvoucher_no limit 0,30"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("paymentvoucher.php",3,"Some error on viewing your paymentvoucher data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
	

		if($o->updatePaymentVoucher()) {//if data save successfully

		if($o->iscomplete==1){
			include_once "class/AccountsAPI.php";
			$accapi=new AccountsAPI();
			$accountsarray=array($o->accountsfrom_id,$o->accountsto_id);
			$amtarray=array($o->amt,$o->amt*-1);
			$currencyarray=array($o->currency_id,$o->currency_id);
			$conversionarray=array($o->exchangerate,$o->exchangerate);
			$bpartnerarray=array(0,$o->bpartner_id);
			$originalamtarray=array($o->originalamt,$o->originalamt*-1);
			$transtypearray=array("","");
			$linetypearray=array(0,1);
			$documentnoarray=array($o->paymentvoucher_no,$o->paymentvoucher_no);
			$chequenoarray=array($o->chequeno,$o->chequeno);
			$result=$accapi->PostBatch($o->createdby,$o->paymentvoucher_date,"simbiz",
				"Post from Simbiz Payment Voucher $o->paymentvoucher_no",
				$o->description,$o->amt,$documentnoarray,
				$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,
				$transtypearray,$linetypearray,$chequenoarray);

			if($result){

				$o->fetchPaymentVoucher($o->paymentvoucher_id);
				$o->batch_id=$accapi->resultbatch_id;
				$o->updatePaymentVoucher();
			}
			else{
				$o->fetchPaymentVoucher($o->paymentvoucher_id);
				$o->iscomplete=0;
				$o->updatePaymentVoucher();
			 redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"<b style='color:red'>Your data is saved but can't complete due to internal error on posting. Reverse this document to draft mode.</b>");
			}
			}



		if($chkAddNew=='on')
			 redirect_header("paymentvoucher.php",$pausetime,"Your data is saved, creating new record");
		else
			redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");


	}
	else{
		redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"Warning! Can't save the data, due to token expired.");			}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deletePaymentVoucher($o->paymentvoucher_id))
			redirect_header("paymentvoucher.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

case "refreshcurrency":
	include_once '../system/class/Currency.php';
	$cur = new Currency();
	$currency_id=$_POST['currency_id'];

	//$unitprice =999;
	$exchangerate = $cur->checkExchangeRate($currency_id,$defaultcurrency_id);
	
	if($exchangerate == 0 && $currency_id>0)
	echo "<script type='text/javascript'>alert('Detect exchange rate =0, please verified your currency table.')
	self.parent.document.frmPaymentVoucher.exchangerate.value=1;
	</script>";
	//else
	echo "<script type='text/javascript'>
	self.parent.document.frmPaymentVoucher.exchangerate.value=$exchangerate;
	self.parent.document.frmPaymentVoucher.amt.value=($exchangerate*parseFloat(self.parent.document.frmPaymentVoucher.originalamt.value)).toFixed(2);
	</script>";

break;

  case "refreshaccountsfrom":
		$accounts_id=$_POST['accounts_id'];

	include_once "class/Accounts.php";
	$acc= new Accounts();
	$acc->fetchAccounts($accounts_id);
	if($acc->account_type==4 )
	$displaychequenostyle='';
	else
	$displaychequenostyle='none';

echo <<< EOF
	<script type="text/javascript">

		self.parent.document.forms['frmPaymentVoucher'].chequeno.style.display = "$displaychequenostyle";


	</script>
EOF;
  break;
case "reactivate":
if($o->fetchPaymentVoucher($o->paymentvoucher_id)){
		
		$o->iscomplete=0;
		include_once "class/AccountsAPI.php";
		$accapi=new AccountsAPI();
		$result=$accapi->reverseBatch($o->batch_id);

		if($result){

					$o->iscomplete=0;
				$o->batch_id=0;
				$o->updatePaymentVoucher();
			 redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"Record reactivated, transaction in accounts is reversed.");

			}
			else{
			redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"<b style='color:red'>Payment Voucher can't reactivated due to internal error.</b>");
			}




	}
  break;
  case "refreshaccountsto":
		$accounts_id=$_POST['accounts_id'];
	include_once "class/Accounts.php";
	$acc= new Accounts();

	$acc->fetchAccounts($accounts_id);
	if($acc->account_type==2)
	$bpartnerctrl=$ctrl->getSelectBPartner(0,'N',"onchange='changePaidTo(this)'","bpartner_id",
			" and (debtoraccounts_id = $accounts_id and isdebtor=1) ",'N',"bpartner_id");
	elseif( $acc->account_type==3)
	$bpartnerctrl=$ctrl->getSelectBPartner(0,'N',"onchange='changePaidTo(this)'","bpartner_id",
			" and (creditoraccounts_id = $accounts_id and iscreditor=1) ",'N',"bpartner_id");
	else
	$bpartnerctrl="<input name='bpartner_id' value='0' type='hidden'>";

echo <<< EOF
	<script type="text/javascript">
			//alert("$o->bpartnerctrl");	
		self.parent.document.getElementById('divbpartner').innerHtml="";
		//alert(self.parent.document.getElementById('divbpartner').innerHTML);
		self.parent.document.getElementById('divbpartner').innerHTML="$bpartnerctrl";

		//if($acc->account_type != 2 || $acc->account_type !=3)
		//	self.parent.document.getElementById('bpartner_id').value=0;

		if($acc->account_type == 2 || $acc->account_type ==3)
		self.parent.document.getElementById('bpartnerID').innerHTML="";
	

		self.parent.changePaidTo(self.parent.document.frmPaymentVoucher.bpartner_id);

	</script>
EOF;

  break;
  case "showSearchForm":
	$o->accountsfromctrl=$ctrl->getSelectAccounts(0,'Y',"","accountsfrom_id","and (account_type=1 OR account_type=2 OR account_type=3)");
	$o->accountstoctrl=$ctrl->getSelectAccounts(0,'Y',"","accountsto_id","and (account_type=4 or account_type=7)");
	$o->currencyctrl=$ctrl->getSelectCurrency($defaultcurrency_id,'N');
	$o->bpartnerctrl=$ctrl->getSelectBPartner(0,'Y');
	$o->showSearchForm();
  break;
  case "search":
	$o->datefrom=$_POST['datefrom'];
	$o->dateto=$_POST['dateto'];
	$o->paymentvoucherfrom_no=$_POST['paymentvoucherfrom_no'];
	$o->paymentvoucherto_no=$_POST['paymentvoucherto_no'];
	$o->iscomplete=$_POST['iscomplete'];
	$o->accountsfromctrl=$ctrl->getSelectAccounts($o->accountsfrom_id,'Y',"","accountsfrom_id","and (account_type=1 OR account_type=2 OR account_type=3)");
	$o->accountstoctrl=$ctrl->getSelectAccounts($o->accountsto_id,'Y',"","accountsto_id","and (account_type=4 or account_type=7)");
	$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N');
	$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'Y');
	$o->showSearchForm();
	$wherestr=$o->genWhereString();
	$o->showpaymentvoucherTable("WHERE f.paymentvoucher_id>0 and f.organization_id=$defaultorganization_id $wherestr","ORDER BY f.paymentvoucher_no");	

  break;

  default :
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	//$o->accounclassctrl=$ctrl->getAccClass(0,'N');
	$o->accountsfromctrl=$ctrl->getSelectAccounts(0,'Y',"onchange='reloadAccountFrom(this.value)'","accountsfrom_id","and (account_type=4 OR  account_type=7)");
	$o->accountstoctrl=$ctrl->getSelectAccounts(0,'Y',"onchange='reloadAccountTo(this.value)'","accountsto_id","and (account_type=1 or account_type=2 or account_type=3)");
	$o->currencyctrl=$ctrl->getSelectCurrency($defaultcurrency_id,'N',"currency_id","","onchange='refreshCurrency(this.value)'");
	//$o->bpartnerctrl=$ctrl->getSelectBPartner(0,'Y',"style='display:none' onchange='changePaidFrom(this.selectedIndex)'");
	$o->getInputForm("new",0,$token);
	$o->showPaymentVoucherTable("WHERE f.paymentvoucher_id>0 and f.organization_id=$defaultorganization_id","ORDER BY f.paymentvoucher_no limit 0,30");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

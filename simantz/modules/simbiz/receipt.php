<?php
include "system.php";

include_once '../simbiz/class/Receipt.php';
include_once '../simbiz/class/ReceiptLine.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
include_once '../simantz/class/Currency.inc.php';

$cur = new Currency();
//include_once "../system/class/Period.php";
$dp=new datepicker($url);
$dp->dateFormat='Y-m-d';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$o = new Receipt();
$pl = new ReceiptLine();
$s = new XoopsSecurity();
$orgctrl="";


$action="";


$o->receipt_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->receipt_id=$_POST["receipt_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->receipt_id=$_GET["receipt_id"];

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
$o->receipt_prefix=$_POST['receipt_prefix'];
$o->receipt_no=$_POST['receipt_no'];
$o->amt=$_POST['amt'];
$o->chequeno=$_POST['chequeno'];
$o->originalamt=$_POST['originalamt'];
$o->paidfrom=$_POST['paidfrom'];
$o->batch_id=$_POST['batch_id'];
$o->accountsfrom_id=$_POST['accountsfrom_id'];
//$o->accountsto_id=$_POST['accountsto_id'];
$o->exchangerate=$_POST['exchangerate'];
$o->receipt_date=$_POST['receipt_date'];
$o->receivedby=$_POST['receivedby'];
$o->isAdmin=$xoopsUser->isAdmin();
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->showCalendar=$dp->show('receipt_date');
$o->showDateFrom=$dp->show('datefrom');
$o->showDateTo=$dp->show('dateto');
$chkAddNew=$_POST['chkAddNew'];

$pl->linereceiptline_id  =$_POST['linereceiptline_id'];
$pl->linesubject =$_POST['linesubject'];
$pl->lineamt =$_POST['lineamt'];
$pl->linechequeno =$_POST['linechequeno'];
$pl->lineaccounts_id=$_POST['lineaccounts_id'];
$pl->linedescription =$_POST['linedescription'];
$pl->linedel=$_POST['linedel'];
$chkAddNew=$_POST['chkAddNew'];
$o->addreceiptlineqty=$_POST['addreceiptlineqty'];

if ($iscomplete==1 or $iscomplete=="on")
	$o->iscomplete=1;
else
	$o->iscomplete=0;


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with receipt name=$o->paidto");

	if ($s->check(true,$token,"CREATE_ACG")){



	  if($o->insertReceipt()){
		 $latest_id=$o->getLatestReceiptID();

		/*
		if($o->iscomplete==1){
			include_once "class/AccountsAPI.php";
			$accapi=new AccountsAPI();
			$accountsarray=array($o->accountsto_id,$o->accountsfrom_id);
			$amtarray=array($o->amt,$o->amt*-1);
			$currencyarray=array($o->currency_id,$o->currency_id);
			$conversionarray=array($o->exchangerate,$o->exchangerate);
			$bpartnerarray=array(0,$o->bpartner_id);
			$originalamtarray=array($o->originalamt,$o->originalamt*-1);
			$transtypearray=array("","");
			$linetypearray=array(0,1);
			$documentnoarray=array($o->receipt_no,$o->receipt_no);
			$chequenoarray=array($o->chequeno,$o->chequeno);
			$result=$accapi->PostBatch($o->createdby,$o->receipt_date,"simbiz","Post from Simbiz Official Receipt $o->receipt_no",
				$o->description,$o->amt,$documentnoarray,
				$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,
				$transtypearray,$linetypearray,$chequenoarray);

			if($result){

				$o->fetchReceipt($latest_id);
				$o->batch_id=$accapi->resultbatch_id;
				$o->iscomplete=1;
				$o->receipt_id=$latest_id;
				$o->updateReceipt();
			}
			else{
				$o->fetchReceipt($latest_id);
				$o->iscomplete=0;
				$o->updateReceipt();
			 redirect_header("receipt.php?action=edit&receipt_id=$latest_id",$pausetime,"<b style='color:red'>Your data is saved but can't complete due to internal error on posting. Reverse this document to draft mode.</b>");
			}


		}*/

		if($o->addreceiptlineqty > 0)
		$pl->createReceiptLine($latest_id,$o->addreceiptlineqty);

		if($chkAddNew=='on')
			 redirect_header("receipt.php",$pausetime,"Your data is saved, creating new record");
		else
			 redirect_header("receipt.php?action=edit&receipt_id=$latest_id",$pausetime,"Your data is saved, redirect to existing record (id=$latest_id)");
		}
	  else {
			echo "<b style='color:red'>Record cannot save, please reverified data you insert into this record.</b>";
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->accountsfromctrl=$ctrl->getSelectAccounts($o->accountsfrom_id,'Y',"onchange='reloadAccountFrom(this.value)'","accountsfrom_id","and (account_type=1 OR account_type=2 OR account_type=3)");
		//$o->accountstoctrl=$ctrl->getSelectAccounts($o->accountsto_id,'Y',"onchange='reloadAccountTo(this.value)'","accountsto_id","and (account_type=4 or account_type=7)");
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N',"currency_id","","onchange='refreshCurrency(this.value)'");

		include_once "class/Accounts.php";
		$acc= new Accounts();
		$acc->fetchAccounts($o->accountsfrom_id);
		if($acc->account_type==2)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'N',"onchange='changePaidFrom(this)'",
			"bpartner_id",	" and (debtoraccounts_id = $o->accountsfrom_id and isdebtor=1) ",'N',"bpartner_id");
		elseif( $acc->account_type==3)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'N',"onchange='changePaidFrom(this)'",
			"bpartner_id",	" and (creditoraccounts_id = $o->accountsfrom_id and iscreditor=1) ",'N',"bpartner_id");

		/*
		$acc->fetchAccounts($o->accountsto_id);

		if($acc->account_type==4)
				$pl->displaychequenostyle="";
		else
				$pl->displaychequenostyle="style='display:none'";*/





		$o->getInputForm("new",-1,$token);

		$o->showReceiptTable("WHERE receipt_id>0 and organization_id=$defaultorganization_id","ORDER BY f.paidto");
		}

	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		echo "<b style='color:red'>Record cannot save due to token expired or invalid. Please resave this record.</b>";
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->accountsfromctrl=$ctrl->getSelectAccounts($o->accountsfrom_id,'Y',"onchange='reloadAccountFrom(this.value)'","accountsfrom_id","and (account_type=1 OR account_type=2 OR account_type=3)");
		//$o->accountstoctrl=$ctrl->getSelectAccounts($o->accountsto_id,'Y',"onchange='reloadAccountTo(this.value)'","accountsto_id","and (account_type=4 or account_type=7)");
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N',"currency_id","","onchange='refreshCurrency(this.value)'");

		include_once "class/Accounts.php";
		$acc= new Accounts();
		$acc->fetchAccounts($o->accountsfrom_id);
		if($acc->account_type==2)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'N',"onchange='changePaidFrom(this)'",
			"bpartner_id",	" and (debtoraccounts_id = $o->accountsfrom_id and isdebtor=1) ",'N',"bpartner_id");
		elseif( $acc->account_type==3)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'N',"onchange='changePaidFrom(this)'",
			"bpartner_id",	" and (creditoraccounts_id = $o->accountsfrom_id and iscreditor=1) ",'N',"bpartner_id");


		/*
		$acc->fetchAccounts($o->accountsto_id);

		if($acc->account_type==4)
				$pl->displaychequenostyle="";
		else
				$pl->displaychequenostyle="style='display:none'";
		*/



		$o->getInputForm("new",-1,$token);
		$o->showReceiptTable("WHERE receipt_id>0 and organization_id=$defaultorganization_id","ORDER BY f.paidto");
	}

break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchReceipt($o->receipt_id)){
                include "menu.php";
   $xoTheme->addScript($url.'/modules/simantz/include/validatetext.js');
    $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
      $o->showJavascript();
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');

		include_once "../simbiz/class/Accounts.php";
		$acc= new Accounts();
		$acc->fetchAccounts($o->accountsfrom_id);

		if($acc->account_type==2)
		$o->bpartnerctrl=$simbizctrl->getSelectBPartner($o->bpartner_id,'N',"onchange='changePaidFrom(this)'",
			"bpartner_id",	" and (debtoraccounts_id = $o->accountsfrom_id and isdebtor=1) ",'N',"bpartner_id");
		elseif( $acc->account_type==3)
		$o->bpartnerctrl=$simbizctrl->getSelectBPartner($o->bpartner_id,'N',"onchange='changePaidFrom(this)'",
			"bpartner_id",	" and (creditoraccounts_id = $o->accountsfrom_id and iscreditor=1) ",'N',"bpartner_id");


		$acc->fetchAccounts($o->accountsto_id);

		/*
		if($acc->account_type==4)
				$pl->displaychequenostyle="";
		else
				$pl->displaychequenostyle="style='display:none'";
		*/





		$o->accountsfromctrl=$simbizctrl->getSelectAccounts($o->accountsfrom_id,'Y',"onchange='reloadAccountFrom(this.value)' ",
			"accountsfrom_id","and (account_type=1 OR account_type=2 OR account_type=3)");

		//$o->accountstoctrl=$ctrl->getSelectAccounts($o->accountsto_id,'Y',"onchange='reloadAccountTo(this.value)'",
		//	"accountsto_id","and (account_type=4 or account_type=7)");
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N',"currency_id","","onchange='refreshCurrency(this.value)'");

		include_once "class/Accounts.php";
		$acc= new Accounts();
		$acc->fetchAccounts($o->bpartneraccounts_id);
		$o->receiptlinectrl=$pl->showReceiptLine($o->receipt_id,'N');

		$o->receiptlinectrl=$o->receiptlinectrl.
				"<tr><th></th><th></th><th></th><th>Total:</th>
				<th><input value='$o->originalamt' name='originalamt'
					size='12' maxlength='12' style='text-align:right' readonly></th>
				<th></th>

				</tr></tbody></table></th></tr>";

		$o->getInputForm("edit",$o->receipt,$token);
		//$o->showReceiptTable("WHERE f.receipt_id>0 and f.organization_id=$defaultorganization_id","ORDER BY f.receipt_no limit 0,30");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("receipt.php",3,"<b style='color:red'>Some error on viewing your receipt data, probably database corrupted.</b>");

break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(true,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid

		$pl->updateReceiptLine();
		if($o->updateReceipt()) {//if data save successfully

			if($o->iscomplete==1){
			include_once "class/AccountsAPI.php";
			$accapi=new AccountsAPI();
			/*
			$accountsarray=array($o->accountsto_id,$o->accountsfrom_id);
			$amtarray=array($o->amt,$o->amt*-1);
			$currencyarray=array($o->currency_id,$o->currency_id);
			$conversionarray=array($o->exchangerate,$o->exchangerate);
			$bpartnerarray=array(0,$o->bpartner_id);
			$originalamtarray=array($o->originalamt,$o->originalamt*-1);
			$transtypearray=array("","");
			$linetypearray=array(0,1);
			$documentnoarray=array($o->receipt_no,$o->receipt_no);
			$chequenoarray=array($o->chequeno,$o->chequeno);*/

			$arrayValue = $o->getArrayPOST($o->receipt_id);
//echo $arrayValue[15];
			if($arrayValue[15] == 0){//if have accounts > 0

			$result=$accapi->PostBatch($o->createdby,$arrayValue[0],$arrayValue[1],$arrayValue[2],
				$arrayValue[3],$arrayValue[4],$arrayValue[5],
				$arrayValue[6],$arrayValue[7],$arrayValue[8],$arrayValue[9],$arrayValue[10],$arrayValue[11],
				$arrayValue[12],$arrayValue[13],$arrayValue[14],$arrayValue[16]);
			}

			/*
			$result=$accapi->PostBatch($o->createdby,$o->receipt_date,"simbiz","Post from Simbiz Official Receipt $o->receipt_no",
				$o->description,$o->amt,$documentnoarray,
				$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,
				$transtypearray,$linetypearray,$chequenoarray);
			*/

			if($result){

				$o->fetchReceipt($o->receipt_id);
				$o->batch_id=$accapi->resultbatch_id;
				$o->updateReceipt();
			}
			else{
				$o->fetchReceipt($o->receipt_id);
				$o->iscomplete=0;
				$o->updateReceipt();
			 redirect_header("receipt.php?action=edit&receipt_id=$o->receipt_id",$pausetime,"<b style='color:red'>Your data is saved but can't complete due to internal error on posting. Reverse this document to draft mode.</b>");
			}

			$pl->deleteUnuseLine($o->receipt_id);
			}else{

				if($o->addreceiptlineqty > 0)
				$pl->createReceiptLine($o->receipt_id,$o->addreceiptlineqty);
			}


			$pl->updateTotalAmt($o->receipt_id,$cur,$o->currency_id);

			if($chkAddNew=='on')
				 redirect_header("receipt.php",$pausetime,"Your data is saved, creating new record");
			else
				redirect_header("receipt.php?action=edit&receipt_id=$o->receipt_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("receipt.php?action=edit&receipt_id=$o->receipt_id",$pausetime,"<b style='color:red'>Warning! Can't save the data, please make sure all value is insert properly.</b>");


	}
	else{
		redirect_header("receipt.php?action=edit&receipt_id=$o->receipt_id",$pausetime,"Warning! Can't save the data, due to token expired.");			}
  break;
  case "delete" :
	if ($s->check(true,$token,"CREATE_ACG")){
		if($o->deleteReceipt($o->receipt_id))
			redirect_header("receipt.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("receipt.php?action=edit&receipt_id=$o->receipt_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database.</b>");
	}
	else
		redirect_header("receipt.php?action=edit&receipt_id=$o->receipt_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database.</b>");

  break;

case "refreshcurrency":

	$currency_id=$_POST['currency_id'];

	//$unitprice =999;
	$exchangerate = $cur->checkExchangeRate($currency_id,$defaultcurrency_id);

	if($exchangerate == 0 && $currency_id>0)
	echo "<script type='text/javascript'>alert('Detect exchange rate =0, please verified your currency table.')
	self.parent.document.frmReceipt.exchangerate.value=1;
	</script>";
	//else
	echo "<script type='text/javascript'>
	self.parent.document.frmReceipt.exchangerate.value=$exchangerate;
	self.parent.document.frmReceipt.amt.value=($exchangerate*parseFloat(self.parent.document.frmReceipt.originalamt.value)).toFixed(2);
	</script>";

break;
case "getaccountinfo":

      include "../simantz/class/SelectCtrl.inc.php";
      $ctrl=new SelectCtrl();

      include "../simbiz/class/SimbizSelectCtrl.inc.php";
      $simbizctrl=new SimbizSelectCtrl();

     $accounts_id=$_REQUEST['accounts_id'];

      echo $simbizctrl->getSelectBPartner(0,'Y',"","bpartner_id"," and (creditoraccounts_id =$accounts_id or debtoraccounts_id=$accounts_id)");
      die;
      break;
case "checkisbank":
    include "../simbiz/class/Accounts.php";
$acc = new Accounts();
    $acc->fetchAccounts($_REQUEST["accounts_id"]);
        if($acc->account_type==4)
                    echo 1;
        else
                echo 0;
        die;
    break;

case "reactivate":
	if($o->fetchReceipt($o->receipt_id)){

		$o->iscomplete=0;
		include_once "class/AccountsAPI.php";
		$accapi=new AccountsAPI();
		$result=$accapi->reverseBatch($o->batch_id);

		if($result){

					$o->iscomplete=0;
				$o->batch_id=0;
				$o->updateReceipt();
			 redirect_header("receipt.php?action=edit&receipt_id=$o->receipt_id",$pausetime,"Record reactivated, transaction in accounts is reversed.");

			}
			else{
			redirect_header("receipt.php?action=edit&receipt_id=$o->receipt_id",$pausetime,"<b style='color:red'>Receipt can't reactivated due to internal error.</b>");
			}




	}
  break;

  case "showSearchForm":
                include "menu.php";

	$o->iscomplete = "";

	$o->accountsfromctrl=$simbizctrl->getSelectAccounts(0,'Y',"","accountsfrom_id","and (account_type=1 OR account_type=2 OR account_type=3)");
	//$o->accountstoctrl=$ctrl->getSelectAccounts(0,'Y',"","accountsto_id","and (account_type=4 or account_type=7)");
	$o->currencyctrl=$ctrl->getSelectCurrency(0,'Y');
	$o->bpartnerctrl=$simbizctrl->getSelectBPartner(0,'Y');
	$o->showSearchForm();
  break;
  case "search":
                      include "menu.php";

	$o->datefrom=$_POST['datefrom'];
	$o->dateto=$_POST['dateto'];
	$o->receiptfrom_no=$_POST['receiptfrom_no'];
	$o->receiptto_no=$_POST['receiptto_no'];
	$o->iscomplete=$_POST['iscomplete'];

	if($o->currency_id == "")
	$o->currency_id = 0;

	$o->accountsfromctrl=$simbizctrl->getSelectAccounts($o->accountsfrom_id,'Y',"","accountsfrom_id","and (account_type=1 OR account_type=2 OR account_type=3)");
	//$o->accountstoctrl=$ctrl->getSelectAccounts($o->accountsto_id,'Y',"","accountsto_id","and (account_type=4 or account_type=7)");
	$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'Y');
	$o->bpartnerctrl=$simbizctrl->getSelectBPartner($o->bpartner_id,'Y');
	$o->showSearchForm();
	$wherestr=$o->genWhereString();
	$o->showReceiptTable("WHERE f.receipt_id>0 and f.organization_id=$defaultorganization_id $wherestr","ORDER BY f.receipt_no");

  break;
  default :

     include "menu.php";
   $xoTheme->addScript($url.'/modules/simantz/include/validatetext.js');
    $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
      $o->showJavascript();
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	//$o->accounclassctrl=$ctrl->getAccClass(0,'N');
	$o->accountsfromctrl=$simbizctrl->getSelectAccounts(0,'Y',"onchange='reloadAccountFrom(this.value)'","accountsfrom_id","and (account_type=1 OR account_type=2 OR account_type=3)");
	//$o->accountstoctrl=$ctrl->getSelectAccounts(0,'Y',"onchange='reloadAccountTo(this.value)'","accountsto_id","and (account_type=4 or account_type=7)");
	$o->currencyctrl=$ctrl->getSelectCurrency($defaultcurrency_id,'N',"currency_id","","onchange='refreshCurrency(this.value)'");
	$o->bpartnerctrl="<option value='0'>Null</option>";
	//echo "<input name='bpartner_id' value='0' type='hidden'>";
	$o->receivedby=$xoopsUser->getVar("name");
	$o->getInputForm("new",0,$token);
	//$o->showReceiptTable("WHERE f.receipt_id>0 and f.organization_id=$defaultorganization_id","ORDER BY f.receipt_no limit 0,30");
  break;

}
echo "</td>";
require(XOOPS_ROOT_PATH.'/footer.php');

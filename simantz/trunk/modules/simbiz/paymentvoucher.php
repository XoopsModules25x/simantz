<?php
include "system.php";


include_once '../simbiz/class/PaymentVoucher.php';
include_once '../simbiz/class/PaymentVoucherLine.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
include_once '../simantz/class/Currency.inc.php';

$cur = new Currency();

//include_once "../system/class/Period.php";

$dp=new datepicker($url);
$dp->dateFormat='Y-m-d';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$o = new PaymentVoucher();
$pl = new PaymentVoucherLine();
$s = new XoopsSecurity();
$orgctrl="";


$action="";


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

//$o->paidto=$_POST["paidto"];

$iscomplete=$_POST['iscomplete'];
$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->currency_id=$_POST['currency_id'];
$o->bpartner_id=$_POST['bpartner_id'];
$o->paymentvoucher_prefix=$_POST['paymentvoucher_prefix'];
$o->paymentvoucher_no=$_POST['paymentvoucher_no'];
$o->chequeno=$_POST['chequeno'];
$o->amt=$_POST['amt'];
$o->originalamt=$_POST['originalamt'];
$o->paidto=$_POST['paidto'];
$o->batch_id=$_POST['batch_id'];
$o->accountsfrom_id=$_POST['accountsfrom_id'];
//$o->accountsto_id=$_POST['accountsto_id'];
$o->exchangerate=$_POST['exchangerate'];
$o->paymentvoucher_date=$_POST['paymentvoucher_date'];
$o->paymentvoucher_type=$_POST['paymentvoucher_type'];
$o->preparedby=$_POST['preparedby'];
$o->isAdmin=$xoopsUser->isAdmin();
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->showCalendar=$dp->show('paymentvoucher_date');
$o->showDateFrom=$dp->show('datefrom');
$o->showDateTo=$dp->show('dateto');
$chkAddNew=$_POST['chkAddNew'];

$pl->linepaymentvoucherline_id  =$_POST['linepaymentvoucherline_id'];
$pl->linesubject =$_POST['linesubject'];
$pl->lineamt =$_POST['lineamt'];
$pl->linechequeno =$_POST['linechequeno'];
$pl->lineaccounts_id=$_POST['lineaccounts_id'];
$pl->linebpartner_id=$_POST['linebpartner_id'];
$pl->linedescription =$_POST['linedescription'];
$pl->linedel=$_POST['linedel'];
$chkAddNew=$_POST['chkAddNew'];
$o->addpaymentvoucherlineqty=$_POST['addpaymentvoucherlineqty'];

if ($iscomplete==1 or $iscomplete=="on")
	$o->iscomplete=1;
else
	$o->iscomplete=0;


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with paymentvoucher name=$o->paidto");

	if ($s->check(true,$token,"CREATE_ACG")){
		


	  if($o->insertPaymentVoucher()){
		 $latest_id=$o->getLatestPaymentVoucherID();

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
			$documentnoarray=array($o->paymentvoucher_no,$o->paymentvoucher_no);
			$chequenoarray=array($o->chequeno,$o->chequeno);
			$result=$accapi->PostBatch($o->createdby,$o->paymentvoucher_date,"simbiz","Post from Simbiz Official PaymentVoucher $o->paymentvoucher_no",
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
			

		}*/

		if($o->addpaymentvoucherlineqty > 0)
		$pl->createPaymentVoucherLine($latest_id,$o->addpaymentvoucherlineqty);
		
		if($chkAddNew=='on')
			 redirect_header("paymentvoucher.php",$pausetime,"Your data is saved, creating new record");
		else
			 redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$latest_id",$pausetime,"Your data is saved, redirect to existing record (id=$latest_id)");
		}
	  else {
			echo "<b style='color:red'>Record cannot save, please reverified data you insert into this record.</b>";
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->accountsfromctrl=$ctrl->getSelectAccounts($o->accountsfrom_id,'Y',"onchange='reloadAccountFrom(this.value)'","accountsfrom_id","");
		//$o->accountstoctrl=$ctrl->getSelectAccounts($o->accountsto_id,'Y',"onchange='reloadAccountTo(this.value)'","accountsto_id","");
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
		
		//$o->showPaymentVoucherTable("WHERE paymentvoucher_id>0 and organization_id=$defaultorganization_id","ORDER BY f.paidto"); 
		}

	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		echo "<b style='color:red'>Record cannot save due to token expired or invalid. Please resave this record.</b>";
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->accountsfromctrl=$ctrl->getSelectAccounts($o->accountsfrom_id,'Y',"onchange='reloadAccountFrom(this.value)'","accountsfrom_id","");
		//$o->accountstoctrl=$ctrl->getSelectAccounts($o->accountsto_id,'Y',"onchange='reloadAccountTo(this.value)'","accountsto_id","");
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
		//$o->showPaymentVoucherTable("WHERE paymentvoucher_id>0 and organization_id=$defaultorganization_id","ORDER BY f.paidto"); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchPaymentVoucher($o->paymentvoucher_id)){
                  include "menu.php";
   $xoTheme->addScript($url.'/modules/simantz/include/validatetext.js');
    $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
      $o->showJavascript();
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
      
		include_once "class/Accounts.php";
          
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
			"accountsfrom_id","");

		//$o->accountstoctrl=$ctrl->getSelectAccounts($o->accountsto_id,'Y',"onchange='reloadAccountTo(this.value)'",
		//	"accountsto_id","");
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N',"currency_id","","onchange='refreshCurrency(this.value)'");

		include_once "class/Accounts.php";
		$acc= new Accounts();
		$acc->fetchAccounts($o->bpartneraccounts_id);

		$o->paymentvoucherlinectrl=$pl->showPaymentVoucherLine($o->paymentvoucher_id,'N');

		$o->paymentvoucherlinectrl=$o->paymentvoucherlinectrl.
				"<tr><th></th><th></th><th>Total:</th>
				<th><input value='$o->originalamt' name='originalamt' 
					size='12' maxlength='12' style='text-align:right' readonly></th>
				<th></th>
				
				</tr></tbody></table></th></tr>";

		$o->getInputForm("edit",$o->paymentvoucher,$token);
		//$o->showPaymentVoucherTable("WHERE f.paymentvoucher_id>0 and f.organization_id=$defaultorganization_id","ORDER BY f.paymentvoucher_no limit 0,30"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("paymentvoucher.php",3,"<b style='color:red'>Some error on viewing your paymentvoucher data, probably database corrupted.</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	//if ($s->check(true,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
	
		$pl->updatePaymentVoucherLine();
		if($o->updatePaymentVoucher()) {//if data save successfully
		
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
			$documentnoarray=array($o->paymentvoucher_no,$o->paymentvoucher_no);
			$chequenoarray=array($o->chequeno,$o->chequeno);*/

			$arrayValue = $o->getArrayPOST($o->paymentvoucher_id);
//echo $arrayValue[15];
			if($arrayValue[15] == 0){//if have accounts > 0
			
			$result=$accapi->PostBatch($o->createdby,$arrayValue[0],$arrayValue[1],$arrayValue[2],
				$arrayValue[3],$arrayValue[4],$arrayValue[5],
				$arrayValue[6],$arrayValue[7],$arrayValue[8],$arrayValue[9],$arrayValue[10],$arrayValue[11],
				$arrayValue[12],$arrayValue[13],$arrayValue[14],$arrayValue[16]);
			}

			/*
			$result=$accapi->PostBatch($o->createdby,$o->paymentvoucher_date,"simbiz","Post from Simbiz Official PaymentVoucher $o->paymentvoucher_no",
				$o->description,$o->amt,$documentnoarray,
				$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,
				$transtypearray,$linetypearray,$chequenoarray);
			*/

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

			$pl->deleteUnuseLine($o->paymentvoucher_id);
			}else{

				if($o->addpaymentvoucherlineqty > 0)
				$pl->createPaymentVoucherLine($o->paymentvoucher_id,$o->addpaymentvoucherlineqty);
			}


			$pl->updateTotalAmt($o->paymentvoucher_id,$cur,$o->currency_id);

			if($chkAddNew=='on')
				 redirect_header("paymentvoucher.php",$pausetime,"Your data is saved, creating new record");
			else		
				redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"<b style='color:red'>Warning! Can't save the data, please make sure all value is insert properly.</b>");


	//}
	//else{
	//	redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"Warning! Can't save the data, due to token expired.");			}
  break;
  case "delete" :
	if ($s->check(true,$token,"CREATE_ACG")){
		if($o->deletePaymentVoucher($o->paymentvoucher_id))
			redirect_header("paymentvoucher.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database.</b>");
	}
	else
		redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database.</b>");
	
  break;

case "refreshcurrency":
	
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

  case "refreshaccountsfrom2":
	$accounts_id=$_POST['accounts_id'];
	include_once "class/Accounts.php";
	$acc= new Accounts();

	$acc->fetchAccounts($accounts_id);
	if($acc->account_type==2)
	$bpartnerctrl=$ctrl->getSelectBPartner(0,'N',"onchange='changePaidFrom(this)'","bpartner_id",
			" and (debtoraccounts_id = $accounts_id and isdebtor=1) ",'N',"bpartner_id");
	elseif( $acc->account_type==3)
	$bpartnerctrl=$ctrl->getSelectBPartner(0,'N',"onchange='changePaidFrom(this)'","bpartner_id",
			" and (creditoraccounts_id = $accounts_id and iscreditor=1) ",'N',"bpartner_id");
	else
	$bpartnerctrl="<input name='bpartner_id' value='0' type='hidden'>";

echo <<< EOF
	<script type="text/javascript">
		
			//alert("$o->bpartnerctrl");	
		self.parent.document.getElementById('divbpartner').innerHtml="";
		//alert(self.parent.document.getElementById('divbpartner').innerHTML);
		self.parent.document.getElementById('divbpartner').innerHTML="$bpartnerctrl";

		if($acc->account_type == 2 || $acc->account_type ==3)
		self.parent.document.getElementById('bpartnerID').innerHTML="";
		//	self.parent.document.getElementById('bpartner_id').value=0;

		self.parent.changePaidFrom(self.parent.document.frmPaymentVoucher.bpartner_id);
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
			redirect_header("paymentvoucher.php?action=edit&paymentvoucher_id=$o->paymentvoucher_id",$pausetime,"<b style='color:red'>PaymentVoucher can't reactivated due to internal error.</b>");
			}




	}
  break;

  case "refreshaccountsto":
	$accounts_id=$_POST['accounts_id'];
	$line=$_POST['line'];
	include_once "class/Accounts.php";
	$acc= new Accounts();
        $paid_to = 0;

	$acc->fetchAccounts($accounts_id);
	if($acc->account_type==2)
	$bpartnerctrl=$ctrl->getSelectBPartner(0,'N',"onchange='changePaidTo(this)' onKeyDown=changearrayfieldEnter(event,'linebpartner_id','$nextid','$previousid','linebpartner_id',this)","linebpartner_id[$line]"," and (debtoraccounts_id = $accounts_id and isdebtor=1) ",'N',"linebpartner_id$line");
	elseif( $acc->account_type==3)
	$bpartnerctrl=$ctrl->getSelectBPartner(0,'N',"onchange='changePaidTo(this)' onKeyDown=changearrayfieldEnter(event,'linebpartner_id','$nextid','$previousid','linebpartner_id',this)","linebpartner_id[$line]"," and (creditoraccounts_id = $accounts_id and iscreditor=1) ",'N',"linebpartner_id$line");
	else{
	$bpartnerctrl="<input name='linebpartner_id[$line]' value='0' type='hidden'>";
        $paid_to = 1;
        }

echo <<< EOF
	<script type="text/javascript">
			
		//self.parent.document.getElementById('divbpartner').innerHtml="";


		self.parent.document.getElementById("idBPartner$line").innerHTML="$bpartnerctrl";

		/*if($acc->account_type == 2 || $acc->account_type ==3)
		self.parent.document.getElementById('bpartnerID').innerHTML="";*/
	
                if($paid_to == 0)
		self.parent.changePaidTo(self.parent.document.getElementById("linebpartner_id$line"));

	</script>
EOF;

  break;

  case "refreshaccountsto2":
	$accounts_id=$_POST['accounts_id'];
	$line=$_POST['line'];
	$bankreconcilation_id=$_POST['bankreconcilation_id'];
	include_once "class/Accounts.php";
	$acc= new Accounts();
	$acc->fetchAccounts($accounts_id);
	if($acc->account_type==4 ){
	$displaychequenostyle='';
	}else{
	$displaychequenostyle='none';
	}

echo <<< EOF
	<script type="text/javascript">

	//alert("linechequeno$line");
		
		//self.parent.document.forms['frmPaymentVoucher'].chequeno+'['+0].style.display = "$displaychequenostyle";
		self.parent.document.getElementById("linechequeno$line").style.display = "$displaychequenostyle";
		//self.parent.document.getElementById("idCNo$line").style.display = "$displaychequenostyle";

		//self.parent.document.getElementById("linechequeno0").style.display = "none";

//alert(self.parent.document.getElementById("linechequeno$line").style.display);

	</script>
EOF;
  break;

  case "gettypeno":
	$paymentvoucher_no = $o->getTypeNo($o->paymentvoucher_type);

        $prefix_doc = "";
        if($o->paymentvoucher_type == "B")
        $prefix_doc = $prefix_pv;
        else if($o->paymentvoucher_type == "C")
        $prefix_doc = $prefix_pvcash;
echo <<< EOF
	<script type="text/javascript">

		self.parent.document.forms['frmPaymentVoucher'].paymentvoucher_prefix.value = "$prefix_doc";
		self.parent.document.forms['frmPaymentVoucher'].paymentvoucher_no.value = "$paymentvoucher_no";

	</script>
EOF;
  break;

  case "showSearchForm":
      include "menu.php";
	$o->iscomplete="";
	$o->accountsfromctrl=$simbizctrl->getSelectAccounts(0,'Y',"","accountsfrom_id","");
	//$o->accountstoctrl=$ctrl->getSelectAccounts(0,'Y',"","accountsto_id","");
	$o->currencyctrl=$ctrl->getSelectCurrency(0,'Y');
//	$o->bpartnerctrl=$ctrl->getSelectBPartner(0,'Y');
	$o->showSearchForm();
  break;
  case "search":
      include "menu.php";
	$o->datefrom=$_POST['datefrom'];
	$o->dateto=$_POST['dateto'];
	$o->paymentvoucherfrom_no=$_POST['paymentvoucherfrom_no'];
	$o->paymentvoucherto_no=$_POST['paymentvoucherto_no'];
	$o->iscomplete=$_POST['iscomplete'];
	
	if($o->currency_id == "")
	$o->currency_id = 0;

	$o->accountsfromctrl=$simbizctrl->getSelectAccounts($o->accountsfrom_id,'Y',"","accountsfrom_id","");
	//$o->accountstoctrl=$ctrl->getSelectAccounts($o->accountsto_id,'Y',"","accountsto_id","");
	$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'Y');
	//$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'Y');
	$o->showSearchForm();
	$wherestr=$o->genWhereString();
	$o->showPaymentVoucherTable("WHERE f.paymentvoucher_id>0 and f.organization_id=$defaultorganization_id $wherestr","ORDER BY f.paymentvoucher_no");	

  break;
  case "getaccountinfo":
      include "../simantz/class/SelectCtrl.inc.php";
      $ctrl=new SelectCtrl();
      
      include "../simbiz/class/SimbizSelectCtrl.inc.php";
      $simbizctrl=new SimbizSelectCtrl();
      
     $accounts_id=$_REQUEST['accounts_id'];
  
      echo $simbizctrl->getSelectBPartner(0,$showNull='N',"","bpartner_id"," and (creditoraccounts_id =$accounts_id or debtoraccounts_id=$accounts_id)");
      die;
      break;

  default :
//and (account_type=4 or account_type=7)
      include "menu.php";
   $xoTheme->addScript($url.'/modules/simantz/include/validatetext.js');
    $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
      $o->showJavascript();
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	//$o->accounclassctrl=$ctrl->getAccClass(0,'N');
//	$o->accountsfromctrl=$ctrl->getSelectAccounts(0,'Y',"onchange='reloadAccountFrom(this.value)'","accountsfrom_id","");
	$o->accountsfromctrl=$simbizctrl->getSelectAccounts(0,'Y',"onchange='reloadAccountFrom(this.value)'","accountsfrom_id","");
	//$o->accountstoctrl=$ctrl->getSelectAccounts(0,'Y',"onchange='reloadAccountTo(this.value)'","accountsto_id","");
	$o->currencyctrl=$ctrl->getSelectCurrency($defaultcurrency_id,'N',"currency_id","","onchange='refreshCurrency(this.value)'");
//	$o->bpartnerctrl=$ctrl->getSelectBPartner(0,'Y',"style='display:none' onchange='changePaidFrom(this.selectedIndex)'");
	//echo "<input name='bpartner_id' value='0' type='hidden'>";
	$o->preparedby=$xoopsUser->getVar("name");
        
	$o->getInputForm("new",0,$token);
	//$o->showPaymentVoucherTable("WHERE f.paymentvoucher_id>0 and f.organization_id=$defaultorganization_id","ORDER BY f.paymentvoucher_no limit 0,30");
       	$o->showPaymentVoucherTable("WHERE f.paymentvoucher_id>0 and f.organization_id=$defaultorganization_id and f.iscomplete=0","ORDER BY f.paymentvoucher_no");

  break;

}
echo "</td>";
require(XOOPS_ROOT_PATH.'/footer.php');

?>

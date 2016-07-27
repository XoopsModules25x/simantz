
<?php
include_once "system.php";
include_once "menu.php";

include_once 'class/Invoice.php';
include_once 'class/InvoiceLine.php';

//include_once 'class/SelectCtrl.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
//include_once "../system/class/Period.php";
$dp=new datepicker($url);
$dp->dateFormat='Y-m-d';
include_once "../bpartner/class/BPSelectCtrl.inc.php";

$bpctrl= new BPSelectCtrl();
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

global $log ;
$o = new Invoice();
$pl = new InvoiceLine();

$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";


$action="";


//marhan add here --> ajax
echo "<iframe src='invoice.php' name='nameValidate' id='idValidate' style='display:none' width='100%'></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">
	function saveRecord(){

	if(validateInvoice())
	document.forms['frmInvoice'].submit();

	}

	function autofocus(){
	document.frmInvoice.document_date.focus();
	document.frmInvoice.document_date.select();
	}


	
	function calculatesummary(){
		itemqty=parseFloat(document.getElementById("itemqty").value);
	
		exchangerate=document.forms['frmInvoice'].exchangerate.value
		var totaltonnage=0;
		var totaloritonnage=0;
		var amt=0;

		for(i=0;i<itemqty;i++){

			amt=amt+parseFloat(document.getElementById("lineamt"+i).value);
		}
		amt=amt.toFixed(2);
		document.forms['frmInvoice'].originalamt.value=amt;
		document.forms['frmInvoice'].amt.value=(amt* parseFloat(exchangerate)).toFixed(2);

		}

	function showHideDesc(i){
		var descctrl=document.getElementById("linedescription"+i);
		if(descctrl.style.display=="none")
			descctrl.style.display="";
		else
			descctrl.style.display="none";

	}

	function gotoAction(action){
	document.forms['frmInvoice'].action.value = action;
	document.forms['frmInvoice'].submit();
	}

	function reloadBPartnerAccount(bpartneraccounts_id){
	var arr_fld=new Array("action","bpartneraccounts_id");//name for POST
	var arr_val=new Array("refreshbpartneraccounts",bpartneraccounts_id);//value for POST
	
	getRequest(arr_fld,arr_val);
	}

	function changeBPartner(bpartner_id){
	document.forms['frmInvoice'].bpartner_id.value=bpartner_id;
	}
	function validateInvoice(){
		var action = document.forms['frmInvoice'].action.value;

		if(action == "edit")
		calculatesummary();
		
		var date=document.forms['frmInvoice'].document_date.value;
		var no=document.forms['frmInvoice'].document_no.value;
		var bpartner_id=document.forms['frmInvoice'].bpartner_id.value;
		var documenttype=document.forms['frmInvoice'].documenttype.value;
		var exchangerate=document.forms['frmInvoice'].exchangerate.value;

		if(confirm("Save record?")){
		if(no =="" ||   date=="" || bpartner_id==0 || documenttype==0){
			alert('Please make sure Document No, Date, Type and supplier is fill with appropriate value before you save the record.');
			return false;
		}else{

			if(!IsNumeric(exchangerate)){
			alert("Exchange Rate is not numeric, please insert appropriate +ve value!");
			return false;
			}

			if(action == "update"){
			var i=0;
			while(i< document.forms['frmInvoice'].elements.length){
				var ctlname = document.forms['frmInvoice'].elements[i].name; 
				var data = document.forms['frmInvoice'].elements[i].value;
			
				if(ctlname.substring(0,13)=="lineunitprice" || ctlname.substring(0,7)=="lineqty" || ctlname=="exchangerate" ){
				
					if(!IsNumeric(data))
						{
							alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
							document.forms['frmInvoice'].elements[i].style.backgroundColor = "#FF0000";
							document.forms['frmInvoice'].elements[i].focus();
							return false;
						}	
						else
						document.forms['frmInvoice'].elements[i].style.backgroundColor = "#FFFFFF";
						
						
				}
				
				i++;
				
			}
			}

		return true;
		}
		}
		else
			return false;
	}

	function refreshUnitPrice(currency_id){
	//bpartner,species_id,girth
	var arr_fld=new Array("action","currency_id");//name for POST
	var arr_val=new Array("refreshunitprice",currency_id);//value for POST
	
	getRequest(arr_fld,arr_val);
	}

	function reloadDocumentNo(id,documenttype){
	var arr_fld=new Array("action","invoice_id","documenttype");//name for POST
	var arr_val=new Array("getnewdocumentno",id,documenttype);//value for POST
	if(documenttype !=0 && id <=0)
		getRequest(arr_fld,arr_val);
	}

	function calculateLine(i){
			var amt=parseFloat(document.getElementById("lineunitprice"+i).value)*parseFloat(document.getElementById("lineqty"+i).value);
			document.getElementById("lineamt"+i).value=amt.toFixed(2);
	}


</script>

EOF;

$o->invoice_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->invoice_id=$_POST["invoice_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->invoice_id=$_GET["invoice_id"];

}
else
$action="";

$token=$_POST['token'];

$o->document_no=$_POST["document_no"];
$o->spinvoice_prefix=$_POST["spinvoice_prefix"];
$o->documenttype=$_POST['documenttype'];

$o->invoice_no_from=$_POST["invoice_no_from"];
$o->invoice_no_to=$_POST["invoice_no_to"];
$o->document_date=$_POST['document_date'];
$o->document_datefrom=$_POST['document_datefrom'];
$o->document_dateto=$_POST['document_dateto'];

$o->organization_id=$_POST['organization_id'];


$o->showcalendar=$dp->show("document_date");
$o->showcalendarfrom=$dp->show("document_datefrom");
$o->showcalendarto=$dp->show("document_dateto");
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->bpartner_id=$_POST['bpartner_id'];
$o->ref_no=$_POST['ref_no'];
$o->currency_id=$_POST['currency_id'];
$o->exchangerate=$_POST['exchangerate'];
$o->amt=$_POST['amt'];
$o->originalamt=$_POST['originalamt'];
$o->itemqty=$_POST['itemqty'];
$o->lineqty=$_POST['lineqty'];
$o->remarks=$_POST['remarks'];
$o->description=$_POST['description'];
$o->bpartneraccounts_id=$_POST['bpartneraccounts_id'];
$o->accounts_id=$_POST['accounts_id'];
$o->batch_id=$_POST['batch_id'];
$o->issearch=$_POST['issearch'];
$o->iscomplete=$_POST['iscomplete'];
$pl->lineinvoiceline_id  =$_POST['lineinvoiceline_id'];
$pl->lineqty =$_POST['lineqty'];
$pl->lineuom  =$_POST['lineuom'];
$pl->linesubject =$_POST['linesubject'];
$pl->lineamt =$_POST['lineamt'];
$pl->lineunitprice=$_POST['lineunitprice'];
$pl->lineaccounts_id=$_POST['lineaccounts_id'];
$pl->linedescription =$_POST['linedescription'];
$pl->linedel=$_POST['linedel'];
$chkAddNew=$_POST['chkAddNew'];
$o->addinvoicelineqty=$_POST['addinvoicelineqty'];



 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with invoice name=$o->invoice_no");

	if ($s->check(true,$token,"CREATE_NOTE")){
		
		

	if($o->insertInvoice()){
		 $latest_id=$o->getLatestInvoiceID();
		if($pl->createInvoiceLine($latest_id,$o->addinvoicelineqty)){
	
			if($chkAddNew=='on')
			 redirect_header("invoice.php",
				$pausetime,"Your data is saved");
			else
			 redirect_header("invoice.php?action=edit&invoice_id=$latest_id",
				$pausetime,"Your data is saved");

		}
		else
			 redirect_header("invoice.php?action=edit&invoice_id=$latest_id",
				$pausetime,"Record header is saved, but some problem exist on creating invoice child, please create child record manually after form refresh.");

		}
	else {
		echo "<b style='color:red'>Record cannot save, please reverified data you insert into this record.</b>";

			$token=$s->createToken($tokenlife,"CREATE_NOTE");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');

		include_once "class/Accounts.php";
		$acc= new Accounts();
		$acc->fetchAccounts($o->bpartneraccounts_id);
		if($acc->account_type==2)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'Y',"onchange='changeBPartner(this.value)'","bpartner_id2",
		"and (debtoraccounts_id=$o->bpartneraccounts_id and isdebtor=1)","N","bpartner_id2") ;
		elseif( $acc->account_type==3)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'Y',"onchange='changeBPartner(this.value)'","bpartner_id2",
		"and (creditoraccounts_id=$o->bpartneraccounts_id and iscreditor=1)","N","bpartner_id2") ;

		$o->accountsctrl=$ctrl->getSelectAccounts($o->accounts_id,'Y',"","accounts_id",
		"and (account_type<>2 AND account_type<>3)");
		$o->bpartneraccountsctrl=$ctrl->getSelectAccounts($o->bpartneraccounts_id,'Y',"onchange='reloadBPartnerAccount(this.value)'","bpartneraccounts_id","and ( account_type=2 or account_type=3)");
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N','currency_id',"","onchange='refreshUnitPrice(this.value)'");
		$o->getInputForm("new",-1,$token);
		$o->showInvoiceTable("WHERE invoice_id>0 and organization_id=$defaultorganization_id","ORDER BY invoice_no"); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		echo "<b style='color:red'>Token expired or invalid, please resave this record.</b>";
		$token=$s->createToken($tokenlife,"CREATE_NOTE");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->accountsctrl=$ctrl->getSelectAccounts($o->accounts_id,'Y',"","accounts_id",
		"and (account_type<>2 AND account_type<>3)");
		$o->bpartneraccountsctrl=$ctrl->getSelectAccounts($o->bpartneraccounts_id,'Y',"onchange='reloadBPartnerAccount(this.value)'","bpartneraccounts_id","and ( account_type=2 or account_type=3)");

		include_once "class/Accounts.php";
		$acc= new Accounts();
		$acc->fetchAccounts($o->bpartneraccounts_id);
		if($acc->account_type==2)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'Y',"onchange='changeBPartner(this.value)'","bpartner_id2",
		"and (debtoraccounts_id=$o->bpartneraccounts_id and isdebtor=1)","N","bpartner_id2") ;
		elseif( $acc->account_type==3)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'Y',"onchange='changeBPartner(this.value)'","bpartner_id2",
		"and (creditoraccounts_id=$o->bpartneraccounts_id and iscreditor=1)","N","bpartner_id2") ;

		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N','currency_id',"","onchange='refreshUnitPrice(this.value)'");
		$o->getInputForm("new",-1,$token);
		$o->showInvoiceTable("WHERE invoice_id>0 and organization_id=$defaultorganization_id","ORDER BY invoice_no"); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchInvoice($o->invoice_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_NOTE"); 
		$log->showLog(4,"editing purchase invoice with organization_id=".$o->organization_id);
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');

		$o->accountsctrl=$ctrl->getSelectAccounts($o->accounts_id,'Y',"","accounts_id",
		"and (account_type<>2 AND account_type<>3)");
		$o->bpartneraccountsctrl=$ctrl->getSelectAccounts($o->bpartneraccounts_id,'Y',"onchange='reloadBPartnerAccount(this.value)'","bpartneraccounts_id","and ( account_type=2 or account_type=3)");

		include_once "class/Accounts.php";
		$acc= new Accounts();
		$acc->fetchAccounts($o->bpartneraccounts_id);
		if($acc->account_type==2)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'Y',"onchange='changeBPartner(this.value)'","bpartner_id2",
		"and (debtoraccounts_id=$o->bpartneraccounts_id and isdebtor=1)","N","bpartner_id2") ;
		elseif( $acc->account_type==3)
		$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'Y',"onchange='changeBPartner(this.value)'","bpartner_id2",
		"and (creditoraccounts_id=$o->bpartneraccounts_id and iscreditor=1)","N","bpartner_id2") ;




		$o->invoicelinectrl=$pl->showInvoiceLine($o->invoice_id,'N');
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N','currency_id',"",
			"onchange='refreshUnitPrice(this.value)';calculatesummary()");
		$o->invoicelinectrl=$o->invoicelinectrl.
				"<tr><th></th><th></th><th></th><th></th><th>Total:</th>
				<th><input value='$o->originalamt' name='originalamt' 
					size='12' maxlength='12' style='text-align:right' readonly></th>
				<th></th>
				</tr></tbody></table></th></tr>";
		$o->getInputForm("edit",$o->invoice,$token);
//		$o->showInvoiceTable("WHERE piv.invoice_id>0 and piv.organization_id=$defaultorganization_id","ORDER BY piv.invoice_no, piv.totalpcs LIMIT 0,30");





	}
	else	//if can't find particular organization from database, return error message
		redirect_header("invoice.php",3,"Some error on viewing your invoice data, probably database corrupted");
  
break;

case "reactive":
	if($o->fetchInvoice($o->invoice_id)){ //if data save successfully

		
		$o->iscomplete=0;
		include_once "class/AccountsAPI.php";
		$accapi=new AccountsAPI();
		$result=$accapi->reverseBatch($o->batch_id);

		if($result){

				$o->iscomplete=0;
				$o->batch_id=0;
				$o->updateInvoice();
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"This record is reactivate successfully, redirect to edit this record.");
			}
			else{
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"<b style='color:red'>This record can't reactivated due to internal error.</b>");
			}




		
	}else{
		redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"<b style='color:red'>Warning! Can't reactivate the data.</b>");
	}
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(true,$token,"CREATE_NOTE")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid

		if(!$pl->createInvoiceLine($o->invoice_id,$o->addinvoicelineqty))
			$log->showLog(1,'Fail to add invoiceline, you may try to add more invoice 
				line after form refresh');
		$o->itemqty=$o->getLineCount($o->invoice_id);
		$pl->updateInvoiceLine();
		if($o->updateInvoice()) {//if data save successfully

			if($o->iscomplete==1){
			
			include_once "class/AccountsAPI.php";
			$accapi=new AccountsAPI();

			/*
				if($o->documenttype==1){
					$amt1=$o->amt;
					$amt2=$o->amt*-1;
					$originalamt1=$o->originalamt;
					$originalamt2=$o->originalamt*-1;
					$documentname="sales invoice";

					}
				elseif($o->documenttype==2){
					$amt1=$o->amt*-1;
					$amt2=$o->amt;
					$originalamt1=$o->originalamt*-1;
					$originalamt2=$o->originalamt;
					$documentname="purchase invoice";
					}
				else{
				$o->fetchInvoice($o->invoice_id);
				$o->iscomplete=0;
				$o->updateInvoice();
				 redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,
					"<b style='color:red'>Your data is saved but can't complete due to unknown document type. Reverse this document to draft mode, this record never post to account yet.</b>");

				}
			
	
			$accountsarray=array($o->bpartneraccounts_id,$o->accounts_id);
			$amtarray=array($amt1,$amt2);
			$currencyarray=array($o->currency_id,$o->currency_id);
			$conversionarray=array($o->exchangerate,$o->exchangerate);
			$bpartnerarray=array($o->bpartner_id,0);
			$originalamtarray=array($originalamt1,$originalamt2);
			$transtypearray=array("","");
			$linetypearray=array(0,1);
			$documentnoarray=array($o->document_no,$o->document_no);
			$chequenoarray=array("","");*/

			$arrayValue = $o->getArrayPOST($o->invoice_id);
			
			/*PostBatch($uid,$date,$systemname,$batch_name,$description,$totaltransactionamt,$documentnoarray,
			$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,$transtypearray,$linetypearray,
			$chequenoarray)*/

			if($arrayValue[15] == 0){//if have accounts > 0
			
			$result=$accapi->PostBatch($o->createdby,$arrayValue[0],$arrayValue[1],$arrayValue[2],
				$arrayValue[3],$arrayValue[4],$arrayValue[5],
				$arrayValue[6],$arrayValue[7],$arrayValue[8],$arrayValue[9],$arrayValue[10],$arrayValue[11],
				$arrayValue[12],$arrayValue[13],$arrayValue[14],$arrayValue[16]);
			}

			if($result){

				$o->fetchInvoice($o->invoice_id);
				$o->batch_id=$accapi->resultbatch_id;
				$o->updateInvoice();
			}
			else{
				$o->fetchInvoice($o->invoice_id);
				$o->iscomplete=0;
				$o->updateInvoice();
			 redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,
				"<b style='color:red'>Your data is saved but can't complete due to internal error on posting. Reverse this document to draft mode.</b>");
			}

			$pl->deleteUnuseLine($o->invoice_id);
			}

			if($chkAddNew=='on')
			 redirect_header("invoice.php",
				$pausetime,"Your data is saved, process to add new record.");
			else
			 redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",
				$pausetime,"Your data is saved.");
		}
		else
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,
				"<b style='color:red'>Warning! Can't save the data, please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,
			"<b style='color:red'>Warning! Can't save the data due to token invalid or expired</b>.");
	}
  break;
  case 'refreshunitprice':
	//echo $o->batchdate;
	include_once '../system/class/Currency.php';
	$cur = new Currency();
	$currency_id=$_POST['currency_id'];

	//$unitprice =999;
	$exchangerate = $cur->checkExchangeRate($currency_id,$defaultcurrency_id);
	
	if($exchangerate == 0 && $currency_id>0)
	echo "<script type='text/javascript'>alert('Detect exchange rate =0, please verified your currency table.')
	self.parent.document.frmInvoice.exchangerate.value=1;
	</script>";
	//else
	echo "<script type='text/javascript'>
	//self.parent.document.getElementById('exchangerate').value=$unitprice;
	self.parent.document.frmInvoice.exchangerate.value=$exchangerate;
	</script>";


	//else
	//echo "<script type='text/javascript'>
	//	alert('bpartner =$o->bpartner_id, girth=$girth, controlid=$controlid, species_id=$species_id');</script>";


  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_NOTE")){
		if($o->deleteInvoice($o->invoice_id))
			redirect_header("invoice.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't delete data from database.");
	
case "showSearchForm":
	$o->accountsctrl=$ctrl->getSelectAccounts(0,'Y',"","accounts_id",
		"and (account_type<>2 AND account_type<>3)");
	$o->bpartneraccountsctrl=$ctrl->getSelectAccounts(0,'Y',"onchange='reloadBPartnerAccount(this.value)'","bpartneraccounts_id","and ( account_type=2 or account_type=3)");
	$o->bpartnerctrl=$ctrl->getSelectBPartner(0,'Y',"onchange='changeBPartner(this.value)'","bpartner_id",
		"","N","bpartner_id") ;
	$o->currencyctrl=$ctrl->getSelectCurrency(0,'Y','currency_id',"","onchange='refreshUnitPrice(this.value)'");
	$o->showSearchForm();
break;

  case "search" :
	
	$wherestr = $o->getWhereStr();
	
//	$o->accounts_id=$_POST['accounts_id'];
//	$o->bpartneraccounts_id=$_POST['bpartneraccounts_id'];
	$o->document_no_from=$_POST['document_no_from'];
	$o->document_no_to=$_POST['document_no_to'];

	$o->document_datefrom=$_POST['document_datefrom'];
	$o->document_dateto=$_POST['document_dateto'];

	$o->iscomplete=$_POST['iscomplete'];
	$o->accountsctrl=$ctrl->getSelectAccounts($o->accounts_id,'Y',"","accounts_id",
		"and (account_type<>2 AND account_type<>3)");
	$o->bpartneraccountsctrl=$ctrl->getSelectAccounts($o->bpartneraccounts_id,'Y',"","bpartneraccounts_id","and ( account_type=2 or account_type=3)");
	$o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id,'Y',"","bpartner_id",
		"","N","bpartner_id") ;
	$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'Y','currency_id',"","");

	$o->showSearchForm();
	$o->showInvoiceTable($wherestr,"ORDER BY dcn.document_no");
  break;
  case "refreshbpartneraccounts":
		$bpartneraccounts_id=$_POST['bpartneraccounts_id'];
		include_once "class/Accounts.php";
		$acc= new Accounts();
		$acc->fetchAccounts($bpartneraccounts_id);
		if($acc->account_type==2)
		$bpartnerctrl=$ctrl->getSelectBPartner(0,'Y',"onchange='changeBPartner(this.value)'","bpartner_id2",
		"and (debtoraccounts_id=$bpartneraccounts_id and isdebtor=1)","N","bpartner_id2") ;
		elseif( $acc->account_type==3)
		$bpartnerctrl=$ctrl->getSelectBPartner(0,'Y',"onchange='changeBPartner(this.value)'","bpartner_id2",
		"and (creditoraccounts_id=$bpartneraccounts_id and iscreditor=1)","N","bpartner_id2") ;

echo <<< EOF
	<script type="text/javascript">
			//alert("$o->bpartnerctrl");	
		self.parent.document.getElementById('divbpartner').innerHtml="";
		//alert(self.parent.document.getElementById('divbpartner').innerHTML);
		self.parent.document.getElementById('divbpartner').innerHTML="$bpartnerctrl";

		if($acc->account_type != 2 || $acc->account_type !=3)
			self.parent.document.getElementById('bpartner_id').value=0;
	</script>
EOF;

  break;

  case "getnewdocumentno":
	//echo $o->batchdate;
	$invoice_id=$_POST['invoice_id'];
	$documenttype=$_POST['documenttype'];

	//$unitprice =999;
	$new_no = $o->getNextNo($documenttype,$defaultorganization_id);

        if($documenttype == 1)
        $prefix_doc = $prefix_spi;
        else if($documenttype == 2)
	$prefix_doc = $prefix_spi2;
        else
        $prefix_doc = "";
        
	echo <<< EOF
<script type='text/javascript'>
	self.parent.document.frmInvoice.spinvoice_prefix.value="$prefix_doc";
	self.parent.document.frmInvoice.document_no.value="$new_no";
	</script>
EOF;
  break;
  default :


	$token=$s->createToken($tokenlife,"CREATE_NOTE");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	$o->accountsctrl=$simbizctrl->getSelectAccounts(0,'Y',"","accounts_id",
		"and (account_type<>2 AND account_type<>3)");
	$o->bpartneraccountsctrl=$simbizctrl->getSelectAccounts(0,'Y',"onchange='reloadBPartnerAccount(this.value)'","bpartneraccounts_id","and ( account_type=2 or account_type=3)");
	$o->bpartnerctrl=$bpctrl->getSelectBPartner(0,'Y',"onchange='changeBPartner(this.value)'","bpartner_id2",
		"and bpartner_id=0","N","bpartner_id2") ;
	$o->currencyctrl=$ctrl->getSelectCurrency($defaultcurrency_id,'N','currency_id',"","onchange='refreshUnitPrice(this.value)'");
	$o->exchangerate=1;
	$o->getInputForm("new",0,$token);
//	$o->showInvoiceTable("WHERE piv.invoice_id>0 and piv.organization_id=$defaultorganization_id","ORDER BY piv.invoice_no, piv.totalpcs  LIMIT 0,30");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

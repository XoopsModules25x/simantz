<?php
include "system.php";
include "menu.php";
//include "exporttransaction.php";
include_once 'class/Log.php';
include_once 'class/Accounts.php';
include_once 'class/SelectCtrl.php';
include_once 'class/Transaction.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$o = new Accounts();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
$trans= new Transaction();
$orgctrl="";


$action="";
//createTransaction();

//marhan add here --> ajax
echo "<iframe src='accounts.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">

	function repairAccounts(){

	if(confirm("Repair Account?")){
	var arr_fld=new Array("action");//name for POST
	var arr_val=new Array("repairaccounts");//value for POST
	getRequest(arr_fld,arr_val);
	}


	}

	function showTree(){

	var arr_fld=new Array("action");//name for POST
	var arr_val=new Array("showtree");//value for POST
	getRequest(arr_fld,arr_val);
	}

	function colapseTree(){

	var arr_fld=new Array("action");//name for POST
	var arr_val=new Array("colapsetree");//value for POST
	getRequest(arr_fld,arr_val);
	}



	function getDefaultAccount(){
	//alert('');
	var arr_fld=new Array("action","id");//name for POST
	var arr_val=new Array("insertdefault","Y");//value for POST
	
	getRequest(arr_fld,arr_val);

	}
	
	function autofocus(){
	changeAccountType();
	placeholdercontrol();
	document.forms['frmAccounts'].accounts_name.focus();
	}

	function validateAccounts(){
		
		var name=document.forms['frmAccounts'].accounts_name.value;
		var openingbalance=document.forms['frmAccounts'].openingbalance.value;
		var defaultlevel=document.forms['frmAccounts'].defaultlevel.value;
	
		if(confirm("Save record?")){
		if(name =="" || !IsNumeric(defaultlevel) || defaultlevel=="" || !IsNumeric(openingbalance) || openingbalance==""){
			alert('Please make sure name is filled in, Default Level,Opening Balance is filled with numeric value');
			return false;
		}
		else
			return true;
		}
		else
			return false;
	}

	function changeAccountType(){
		var isplaceholder=document.forms['frmAccounts'].placeholder.checked;
		var accountype=document.forms['frmAccounts'].account_type.value;
		//alert(accountype);
		switch(accountype){
			case "1":
				if(isplaceholder==0)
				document.forms['frmAccounts'].openingbalance.readOnly=false;

			break;
			case "2":
				document.forms['frmAccounts'].openingbalance.readOnly=true;
	//			document.forms['frmAccounts'].openingbalance.value=0;
			break;
			case "3":
				document.forms['frmAccounts'].openingbalance.readOnly=true;
	//			document.forms['frmAccounts'].openingbalance.value=0;
			break;
			case "4":
				if(isplaceholder==0)
				document.forms['frmAccounts'].openingbalance.readOnly=false;

			break;
			case "5":
				if(isplaceholder==0)
				document.forms['frmAccounts'].openingbalance.readOnly=true;

			break;
			case "6":


			break;
			case "7":


			break;
			default:
				alert("You'd choose unknown account type("+accountype+"), please contact software developer.");
			break;
		}

	}

    function placeholdercontrol(){
		var accountype=document.forms['frmAccounts'].account_type.value;
		var isplaceholder=document.forms['frmAccounts'].placeholder.checked;
		if(isplaceholder){
			document.forms['frmAccounts'].openingbalance.value=0;
			document.forms['frmAccounts'].openingbalance.readOnly=true;
			document.forms['frmAccounts'].account_type.selectedIndex=0;
		}
		else
		{
			if(accountype==1)
			document.forms['frmAccounts'].openingbalance.readOnly=false;

		}
		
	}
</script>

EOF;

$o->accounts_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->accounts_id=$_POST["accounts_id"];


}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->accounts_id=$_GET["accounts_id"];

}
else
$action="";

$token=$_POST['token'];

$o->accounts_name=$_POST["accounts_name"];
$o->accounts_code=$_POST["accounts_code"];
$o->accountcode_full=$_POST["accountcode_full"];
$o->accountgroup_id=$_POST["accountgroup_id"];
$o->tax_id=$_POST['tax_id'];
$o->account_type=$_POST["account_type"];
$o->isactive=$_POST['isactive'];
$o->placeholder=$_POST['placeholder'];
$o->organization_id=$_POST['organization_id'];
$o->isAdmin=$xoopsUser->isAdmin();
$o->description=$_POST['description'];
$o->openingbalance=$_POST['openingbalance'];
$o->parentaccounts_id=$_POST["parentaccounts_id"];
$o->ishide=$_POST['ishide'];
$o->previousopeningbalance=$_POST['previousopeningbalance'];
$o->previousparentaccounts_id=$_POST["previousparentaccounts_id"];
$o->defaultlevel=$_POST['defaultlevel'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');



if ($o->placeholder==1 or $o->placeholder=="on")
	$o->placeholder=1;
else
	$o->placeholder=0;

$defaultacc=$_GET['defaultacc'];


if($o->checkAccounts($defaultorganization_id) && $defaultacc == 1)
echo "<script type='text/javascript'>getDefaultAccount();</script>";
	

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with accounts name=$o->accounts_name");

	if ($s->check(true,$token,"CREATE_ACC")){
		$o->treelevel=$o->getLevel($o->parentaccounts_id) +1;	

	//$equity_id = $o->getAccountsID($defaultorganization_id,"Equity");
		
	if($o->insertAccounts()){

		$latest_id=$o->getLatestAccountsID();
//		$o->insertBatch($latest_id);
		$o->updateHierarchy($latest_id);
//		$batch_id = $o->getLatestBatchID();
//		$trans->compileSummary($batch_id);
		
		//$o->repairAccounts($o->getTopParent($o->$latest_id),"N");

		$amtob = $o->openingbalance;
		if($o->openingbalance == "")
			$amtob = 0;
////////
//$o->updateOpeningBalanceAccount($o->openingbalance,$o->previousopeningbalance);
//				$o->updateLastBalance($o->accounts_id,$o->openingbalance,$o->previousopeningbalance,0);
/////////////
		$o->updateOpeningBalanceAccount($amtob,0);
		$o->updateLastBalance($latest_id,$o->openingbalance,$o->previousopeningbalance,0);
		$o->updateHierarchy();
		$o->recalculateAllParentAccounts();
		redirect_header("accounts.php?action=edit&accounts_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
			echo "<b style='color:red'>Record cannot save, please reverified data you insert into this record.</b>";
		echo "<table><tr><td>";
		$o->showAccountsTable("WHERE a.accounts_id>0 and a.organization_id=$defaultorganization_id",
			"ORDER BY a.accounts_code,a.accounts_name");
		echo "</td><td>";
		$token=$s->createToken($tokenlife,"CREATE_ACC");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->accountgroupctrl=$ctrl->getSelectAccountGroup($o->accountgroup_id,'Y');
		$o->parentaccountsctrl=$ctrl->getSelectAccounts($o->accounts_id,'N',"","parentaccounts_id","AND placeholder=1","","Y");
		$o->taxctrl=$ctrl->getSelectTax($o->tax_id,'Y');
		//$o->bpartnergroupctrl=$ctrl->getSelectBPartnerGroup($o->bpartnergroup_id,'Y',"");

		$o->getInputForm("new",-1,$token);
		echo "</td></tr></table>";
	//	$o->showAccountsTable("WHERE accounts_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,accounts_name"); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
			echo "<b style='color:red'>Record cannot save due to token expired, please resave this record.</b>";
		echo "<table><tr><td>";
		$o->showAccountsTable("WHERE a.accounts_id>0 and a.organization_id=$defaultorganization_id",
			"ORDER BY a.accounts_code,a.accounts_name");
		echo "</td><td>";
		$token=$s->createToken($tokenlife,"CREATE_ACC");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->accountgroupctrl=$ctrl->getSelectAccountGroup($o->accountgroup_id,'Y');
		$o->parentaccountsctrl=$ctrl->getSelectAccounts($o->accounts_id,"N","","parentaccounts_id","AND placeholder=1","","Y");
		$o->taxctrl=$ctrl->getSelectTax($o->tax_id,'Y');
		//$o->bpartnergroupctrl=$ctrl->getSelectBPartnerGroup($o->bpartnergroup_id,'Y',"");

		$o->getInputForm("new",-1,$token);
		echo "</td></tr></table>";
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchAccounts($o->accounts_id)){
		//create a new token for editing a form
		echo "<table><tr><td>";
		$o->showAccountsTable("WHERE a.accounts_id>0 and a.organization_id=$defaultorganization_id",
			"ORDER BY a.accounts_code,a.accountcode_full,a.accounts_name");
		echo "</td><td>";
		$token=$s->createToken($tokenlife,"CREATE_ACC"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->accountgroupctrl=$ctrl->getSelectAccountGroup($o->accountgroup_id,'Y');
		$o->parentaccountsctrl=$ctrl->getSelectAccounts($o->parentaccounts_id,'Y',"","parentaccounts_id","AND placeholder=1 AND accounts_id<>$o->accounts_id","","Y");
		$o->taxctrl=$ctrl->getSelectTax($o->tax_id,'Y');
		//$o->bpartnergroupctrl=$ctrl->getSelectBPartnerGroup($o->bpartnergroup_id,'Y',"");

		$o->getInputForm("edit",$o->accounts,$token);
		echo "</td></tr></table>";
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("accounts.php",3,"Some error on viewing your accounts data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACC")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$o->treelevel=$o->getLevel($o->parentaccounts_id) +1;	


		if($o->updateAccounts()){ //if data save successfully
		
			if($o->placeholder == "on"){
			//$o->updateChildTree($o->accounts_id);
			//$o->updateHierarchy();
			}

			if($o->previousopeningbalance != $o->openingbalance){
				$effectiveamt=$o->openingbalance-$o->previousopeningbalance;
				$o->updateOpeningBalanceAccount($o->openingbalance,$o->previousopeningbalance);
				$o->updateLastBalance($o->accounts_id,$o->openingbalance,$o->previousopeningbalance,0);
				//$o->updateOpenBalance($o->accounts_id,$effectiveamt);
				$o->recalculateAllParentAccounts();

			}
//		if($checkbatch == true){
//		$o->insertBatch($o->accounts_id);
//		$batch_id = $o->getLatestBatchID();
//		$trans->compileSummary($batch_id);
//
//		}else{
//		$bacthid = $o->getBatchHideID($o->accounts_id);
//		$o->updateBatch($bacthid);
//		$trans->compileSummaryUpdate($bacthid,$o->previousopeningbalance);
//		}
		
//		if($prevTopParent != $o->getTopParent($o->accounts_id))
		//$o->repairAccounts($prevTopParent,"N");
		if($o->previousparentaccounts_id !=$o->parentaccounts_id){
		$o->updateHierarchy($o->parentaccounts_id);
		$o->recalculateAllParentAccounts();
		}				
		$o->recalculateAllParentAccounts();

		redirect_header("accounts.php?action=edit&accounts_id=$o->accounts_id",$pausetime,"Your data is saved.");
		}else
			redirect_header("accounts.php?action=edit&accounts_id=$o->accounts_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("accounts.php?action=edit&accounts_id=$o->accounts_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACC")){
		
//		$bacthid = $o->getBatchRecord();
//		$trans->reverseSummary($bacthid);
		
		if($o->deleteAccounts($o->accounts_id,$bacthid)){
//		$trans->reverseSummary($bacthid);
		$o->recalculateAllParentAccounts();
		redirect_header("accounts.php",$pausetime,"Data removed successfully.");
		}else
			redirect_header("accounts.php?action=edit&accounts_id=$o->accounts_id",$pausetime,"Warning! Can't delete data from database.");
		
		
	}
	else
		redirect_header("accounts.php?action=edit&accounts_id=$o->accounts_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
 case "hide":

	$o->toggelAccountHide();
	echo "<script type='text/javascript'>
	self.parent.location = 'accounts.php';
	</script>";
	
  break;
 case "colapsetree":

	$o->colapseTree();
	echo "<script type='text/javascript'>
	self.parent.location = 'accounts.php';
	</script>";
	
  break;
 case "showtree":

	$o->displayTree();
	echo "<script type='text/javascript'>
	self.parent.location = 'accounts.php';
	</script>";
	
  break;

 case "addchild" :
	echo "<table><tr><td>";
	$o->showAccountsTable("WHERE a.accounts_id>0 and a.organization_id=$defaultorganization_id",
		"ORDER BY a.accounts_code,a.accounts_name");
	echo "</td><td>";
	$token=$s->createToken($tokenlife,"CREATE_ACC");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	$o->currencyctrl=$ctrl->getSelectCurrency(0,'N');
	$o->taxctrl=$ctrl->getSelectTax(0,'Y');
	$o->accounts_code = $o->getNextChildAccountCode($o->parentaccounts_id);
	if($o->accounts_code=="")
	$o->accounts_code=10;
		//$o->accounts_code=$_POST['parentaccounts_code'] . 10;
	$o->accountgroupctrl=$ctrl->getSelectAccountGroup($o->accountgroup_id,'Y');
	$o->parentaccountsctrl=$ctrl->getSelectAccounts($o->parentaccounts_id,'N',"","parentaccounts_id","AND placeholder=1","","Y");
	//$o->bpartnergroupctrl=$ctrl->getSelectBPartnerGroup($o->bpartnergroup_id,'Y',"");

	$o->getInputForm("new",0,$token);
	echo "</td></tr></table>";
  break;
  
  case "insertdefault" :

  if($o->checkAccounts($defaultorganization_id))
 	 $o->insertDefaultAcc($defaultorganization_id,$o->updatedby);

	redirect_header("accounts.php",$pausetime,"Default accounts generated successfuly.");

  break;

  case "repairaccounts" :


	if($o->repairAccounts()){
	echo "<script type='text/javascript'>
	alert('Repair Successfully.');
	self.parent.location = 'accounts.php';
	</script>";
	}else{
	echo "<script type='text/javascript'>
	alert('Failed To Repair Account');
	self.parent.location = 'accounts.php';
	</script>";
	}
  break;
  
  default :
	
	if($o->checkAccounts($defaultorganization_id)){
	echo "<form action='accounts.php' method='POST'>
			<table>
			<tr>
			<td>New Organization. System attempting to create default account. Please click 'OK' to continue.</td>
			</tr>
			<tr>
			<td><input type='submit' value='OK'><input name='action' value='insertdefault' type='hidden'></td>
			</tr>
			</table>
			</form>";
	}else{
	echo "<table><tr><td>";
	$o->showAccountsTable("WHERE a.accounts_id>0 and a.organization_id=$defaultorganization_id",
			"ORDER BY a.accounts_code,a.accounts_name");
	echo "</td><td>";
	$token=$s->createToken($tokenlife,"CREATE_ACC");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	$o->currencyctrl=$ctrl->getSelectCurrency(0,'N');
	$o->taxctrl=$ctrl->getSelectTax(0,'Y');
	$o->accountgroupctrl=$ctrl->getSelectAccountGroup(0,'Y');
	$o->parentaccountsctrl=$ctrl->getSelectAccounts(0,'Y',"","parentaccounts_id","AND placeholder=1","","Y");
	$o->bpartnergroupctrl=$ctrl->getSelectBPartnerGroup(0,'Y',"");
	
	$o->getInputForm("new",0,$token);
	echo "</td></tr></table>";
	}
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

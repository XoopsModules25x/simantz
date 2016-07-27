<?php
include_once "system.php" ;
include_once ("menu.php");
include_once 'class/Log.php';
include_once 'class/ProductCategory.php';
//include_once 'class/Employee.php';
include_once 'class/CashTransfer.php';


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new CashTransfer($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);
$o->module_id=$module_id;
$orgctrl="";

$action="";

echo <<< EOF
<script type="text/javascript">
	function validateCashTransfer(){
		var amt=document.forms['frmCashTransfer'].amt.value;
		var transport_amt=document.forms['frmCashTransfer'].transport_amt.value;
		var code=document.forms['frmCashTransfer'].cashtransfer_no.value;
		if(confirm('Save this record?')){
		if(!IsNumeric(amt) || code=="" || !IsNumeric(transport_amt) || transport_amt=="" || amt==""){
			alert('Please make sure document no, training fees and transport fees is filled in properly.');
			return false;
		}
		else
			return true;
		}
		else
			return false;
	}

	function autofocus(){}
</script>

EOF;

$o->category_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->cashtransfer_id=$_POST["cashtransfer_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->cashtransfer_id=$_GET["cashtransfer_id"];

}
else
$action="";

$token=$_POST['token'];
$o->cashtransfer_no=$_POST["cashtransfer_no"];
$o->transferdatetime=$_POST["transferdatetime"];
$o->organization_id=$_POST["organization_id"];
$o->uid=$_POST['uid'];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$o->description=$_POST['description'];
$o->defaultamt=$_POST['defaultamt'];
$o->amt=$_POST['amt'];
$o->defaulttransport_amt=$_POST['defaulttransport_amt'];
$o->currentuid=$xoopsUser->getVar('uid');
$o->transport_amt=$_POST['transport_amt'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with cashtransfer_no=$o->cashtransfer_no, uid: $o->uid");

	if ($s->check(false,$token,"CREATE_CSTF")){		
		if($o->insertCashTransfer()){
			 $latest_id=$o->getLatestCashTransferID();
			 redirect_header("cashtransfer.php?action=edit&cashtransfer_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
		$log->showLog(1,"Warning! Cannot save this record, please verified your data.");
		$token=$s->createToken($tokenlife,"CREATE_CSTF");
		$o->orgctrl=$permission->selectionOrg($o->created,$o->organization_id);
		$o->userctrl=$permission->selectAvailableSysUser($o->uid,'N');
		$o->username=$xoopsUser->getUnameFromId($o->uid);
		$o->getInputForm("new",-1,$token);
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"Warning! Cannot save this record due to token expired.");
		$token=$s->createToken($tokenlife,"CREATE_CSTF");
		$o->userctrl=$permission->selectAvailableSysUser($o->uid,'N');
		$o->username=$xoopsUser->getUnameFromId($o->uid);
		$o->orgctrl=$permission->selectionOrg($o->created,$o->organization_id);
		$o->getInputForm("new",-1,$token);

	
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchCashTransfer($o->cashtransfer_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_CSTF"); 
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);

		$o->username=$xoopsUser->getUnameFromId($o->uid);
		$o->getInputForm("edit",$o->cashtransfer_id,$token);
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("category.php",3,"$errorstart Warning! Some error on viewing you this record, probably database corrupted.$errorend");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_CSTF")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateCashTransfer()) //if data save successfully
			redirect_header("cashtransfer.php?action=edit&cashtransfer_id=$o->cashtransfer_id",$pausetime,"Your data is saved.");
		else
			redirect_header("cashtransfer.php?action=edit&cashtransfer_id=$o->cashtransfer_id",$pausetime,"$errorstart Warning! Can't save the data, please make sure all value is insert properly.$errorend");
		}
	else{
		redirect_header("cashtransfer.php?action=edit&cashtransfer_id=$o->cashtransfer_id",$pausetime,"$errorstart Warning! Can't save the data due to token expired.$errorend");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_CSTF")){
		if($o->deleteCashTransfer($o->cashtransfer_id))
			redirect_header("cashtransfer.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("cashtransfer.php?action=edit&cashtransfer_id=$o->cashtransfer_id",$pausetime,"$errorstart Warning! Can't delete data from database due to data dependency error.$errorend");
	}
	else
		redirect_header("cashtransfer.php?action=edit&cashtransfer_id=$o->cashtransfer_id",$pausetime,"$errorstart Warning! Can't delete data from database due to token expired.$errorend");
	
  break;
   case "withdraw" :
		$log->showLog(3,"Start produce cash withdraw activity for userid:".$o->uid);
		$token=$s->createToken($tokenlife,"CREATE_CSTF"); 
		$o->cashtransfer_no=$o->getNextCashTransferNo();
		$o->orgctrl=$permission->selectionOrg($o->createdby,$defaultorganization_id);
		$o->userctrl=$permission->selectAvailableSysUser($o->uid,'N');
		$o->username=$xoopsUser->getUnameFromId($o->uid);
		$o->getInputForm("new",0,$token); 
	
  break;
  default :
	$o->showOnHandCashTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

<?php
include_once "system.php" ;
include_once "menu.php";
//include_once './class/Employee.php';
include_once './class/Transport.php';
include_once './class/Log.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);



$log = new Log();
//$e = new Employee($xoopsDB,$tableprefix,$log,$ad);
$o= new Transport($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity();
$pausetime=1;

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmTransport'].transport_code.focus();
	}

	function validateTransport(){
		var code=document.forms['frmTransport'].transport_code.value;
		var doubletrip_fees=document.forms['frmTransport'].doubletrip_fees.value;
		var singletrip_fees=document.forms['frmTransport'].singletrip_fees.value;

		if(confirm('Save Record?')){
		if(code =="" || !IsNumeric(singletrip_fees) ||singletrip_fees==""
		 || !IsNumeric(doubletrip_fees) || doubletrip_fees==""){
			alert('Cannot save data! Please make sure transport code is filled in, and data in fees column is numeric.');
			return false;
		}
		else
			return true;
		}
		else
			return false;

	}
</script>

EOF;


$action="";
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->transport_id=$_POST["transport_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->transport_id=$_GET["transport_id"];

}
else
$action="";

$token=$_POST['token'];
$o->transport_code=$_POST["transport_code"];
$o->organization_id=$_POST["organization_id"];
$o->area_id=$_POST["area_id"];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$o->doubletrip_fees=$_POST["doubletrip_fees"];
$o->singletrip_fees=$_POST["singletrip_fees"];
$isactive=$_POST['isactive'];
$o->isAdmin=$xoopsUser->isAdmin();
if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	if ($s->check(false,$token,"CREATE_TPT")){
		$o->createdby=$xoopsUser->getVar('uid');
		$o->updatedby=$xoopsUser->getVar('uid');
		//create new address for organization
		
		//if organization saved
		if($o->insertTransport( )){
		 $latest_id=$o->getLatestTransportID();
		 redirect_header("transport.php",$pausetime,"Your data is saved, redirect to create new record.");
		}
		else {
		$log->showLog(1,"Warning! '$o->transport_code' cannot save, please verified your data.");
		$token=$s->createToken($tokenlife,"CREATE_TPT");
		$o->orgctrl=$permission->selectionOrg($xoopsUser->getVar('uid'),$o->organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showTransportTable(); 
		}

	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"Warning! '$o->transport_code' cannot save due to token expired.");
		$token=$s->createToken($tokenlife,"CREATE_TPT");
		$o->orgctrl=$permission->selectionOrg($xoopsUser->getVar('uid'),$o->organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showTransportTable(); 
	}
 
break;
	//when user request to edit particular transport
  case "edit" :
	if($o->fetchTransport($o->transport_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_TPT"); 
		$o->orgctrl=$permission->selectionOrg($xoopsUser->getVar('uid'),$o->organization_id);
		$o->getInputForm("edit",$o->transport_id,$token);
		$o->showTransportTable(); 
	}
	else	//if can't find particular transport from database, return error message
		redirect_header("transport.php",$pausetime,"<b style='color:red'>Some error on viewing your transport service data, probably database corrupted.</b>");
  
break;
//when user press save for change existing transport data
  case "update" :
	if ($s->check(false,$token,"CREATE_TPT")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateTransport()) //if data save successfully
			redirect_header("transport.php?action=edit&transport_id=$o->transport_id",$pausetime,"Your data is saved.");
		else
			redirect_header("transport.php?action=edit&transport_id=$o->transport_id",$pausetime,"<b style='color:red'>Warning! Can't save the data, please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("transport.php?action=edit&transport_id=$o->transport_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->transport_code' due to token expired.</b>");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_TPT")){
		if($o->deleteTransport($o->transport_id))
			redirect_header("transport.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("transport.php?action=edit&transport_id=$o->transport_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to data dependency problem.</b>");
	}
	else
		redirect_header("transport.php?action=edit&transport_id=$o->transport_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to token expired.</b>");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_TPT");
	$o->orgctrl=$permission->selectionOrg($xoopsUser->getVar('uid'),$defaultorganization_id);
	$o->getInputForm("new",0,$token);
	$o->showTransportTable();
  break;

}
require(XOOPS_ROOT_PATH.'/footer.php');
?>

<?php

include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/EPF.php';
//include_once 'class/Employee.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new EPF($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmEPF'].epf_name.focus();
	}
	function validateEPF(){
		var amtfrom=document.forms['frmEPF'].amtfrom.value;
		var amtto=document.forms['frmEPF'].amtto.value;
		var employer_amt=document.forms['frmEPF'].employer_amt.value;
		var employee_amt2=document.forms['frmEPF'].employee_amt2.value;
		var employee_amt=document.forms['frmEPF'].employee_amt.value;
		var totalamt=document.forms['frmEPF'].totalamt.value;

	if(confirm('Save Record?')){	
		if(!IsNumeric(amtfrom) || !IsNumeric(amtto) ||!IsNumeric( employer_amt) || 
			!IsNumeric( employee_amt2) || !IsNumeric( employee_amt) || !IsNumeric(totalamt) ){
			alert('Please make sure all column is filled in with numeric value.');
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

$o->epf_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->epf_id=$_POST["epf_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->epf_id=$_GET["epf_id"];

}
else
$action="";

$token=$_POST['token'];
$o->amtfrom=$_POST["amtfrom"];
$o->amtto=$_POST["amtto"];
$o->employee_amt=$_POST["employee_amt"];
$o->employee_amt2=$_POST["employee_amt2"];
$o->employer_amt=$_POST["employer_amt"];
$o->totalamt=$_POST["totalamt"];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;

$o->isAdmin=$xoopsUser->isAdmin();
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');


$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');


if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with epf name=$o->epf_name");

	if ($s->check(false,$token,"CREATE_STD")){
		
		
		
	if($o->insertEPF()){
		 $latest_id=$o->getLatestEPFID();
			 redirect_header("epf.php?action=edit&epf_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
		$log->showLog(1,"Warning! This record cannot save, please verified your data.");
		$token=$s->createToken($tokenlife,"CREATE_STD");
		$o->orgctrl=$permission->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showEPFTable(); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"Warning! This record cannot save due to token expired.");
		$token=$s->createToken($tokenlife,"CREATE_STD");
		$o->orgctrl=$permission->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showEPFTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchEPF($o->epf_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_STD"); 
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->epf,$token);
		$o->showEPFTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("epf.php",3,"<b style='color:red'>Some error on viewing your epf data, probably database corrupted.</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_STD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateEPF()) //if data save successfully
			redirect_header("epf.php?action=edit&epf_id=$o->epf_id",$pausetime,"Your data is saved.");
		else
			redirect_header("epf.php?action=edit&epf_id=$o->epf_id",$pausetime,"<b style='color:red'>Warning! Can't save the data, please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("epf.php?action=edit&epf_id=$o->epf_id",$pausetime,"<b style='color:red'>Warning! Can't save the data due to token expired.</b>");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_STD")){
		if($o->deleteEPF($o->epf_id))
			redirect_header("epf.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("epf.php?action=edit&epf_id=$o->epf_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to data dependency error.</b>");
	}
	else
		redirect_header("epf.php?action=edit&epf_id=$o->epf_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to token expired</b>.");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_STD");
	$o->orgctrl=$permission->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showEPFTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

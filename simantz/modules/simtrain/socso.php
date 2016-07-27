<?php

include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Socso.php';
//include_once 'class/Employee.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Socso($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmSocso'].socso_name.focus();
	}
	function validateSocso(){
		var amtfrom=document.forms['frmSocso'].amtfrom.value;
		var amtto=document.forms['frmSocso'].amtto.value;
		var employer_amt=document.forms['frmSocso'].employer_amt.value;
		var employer_amt2=document.forms['frmSocso'].employer_amt2.value;
		var employee_amt=document.forms['frmSocso'].employee_amt.value;
		var totalamt=document.forms['frmSocso'].totalamt.value;

	if(confirm('Save Record?')){	
		if(!IsNumeric(amtfrom) || !IsNumeric(amtto) ||!IsNumeric( employer_amt) || 
			!IsNumeric( employer_amt2) || !IsNumeric( employee_amt) || !IsNumeric(totalamt) ){
			alert('Please make sure all column filled with numeric value.');
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

$o->socso_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->socso_id=$_POST["socso_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->socso_id=$_GET["socso_id"];

}
else
$action="";

$token=$_POST['token'];
$o->amtfrom=$_POST["amtfrom"];
$o->amtto=$_POST["amtto"];
$o->employee_amt=$_POST["employee_amt"];
$o->employer_amt2=$_POST["employer_amt2"];
$o->employer_amt=$_POST["employer_amt"];
$o->totalamt=$_POST["totalamt"];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;

$o->isAdmin=$xoopsUser->isAdmin();
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');



 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with socso name=$o->socso_name");

	if ($s->check(false,$token,"CREATE_STD")){
		
		
		
	if($o->insertSocso()){
		 $latest_id=$o->getLatestSocsoID();
			 redirect_header("socso.php?action=edit&socso_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
		$log->showLog(1,"Warning! This record cannot save, please verified your data.");
		$token=$s->createToken($tokenlife,"CREATE_STD");
		$o->orgctrl=$permission->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showSocsoTable(); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"Warning! This record cannot save due to token expired.");
		$token=$s->createToken($tokenlife,"CREATE_STD");
		$o->orgctrl=$permission->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showSocsoTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchSocso($o->socso_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_STD"); 
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->socso,$token);
		$o->showSocsoTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("socso.php",3,"<b style='color:red'>Some error on viewing your socso data, probably database corrupted.</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_STD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateSocso()) //if data save successfully
			redirect_header("socso.php?action=edit&socso_id=$o->socso_id",$pausetime,"Your data is saved.");
		else
			redirect_header("socso.php?action=edit&socso_id=$o->socso_id",$pausetime,"<b style='color:red'>Warning! Can't save this record, please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("socso.php?action=edit&socso_id=$o->socso_id",$pausetime,"<b style='color:red'>Warning! Can't save this record due to token expired.</b>");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_STD")){
		if($o->deleteSocso($o->socso_id))
			redirect_header("socso.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("socso.php?action=edit&socso_id=$o->socso_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to data dependency.</b>");
	}
	else
		redirect_header("socso.php?action=edit&socso_id=$o->socso_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to token expired.</b>");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_STD");
	$o->orgctrl=$permission->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showSocsoTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

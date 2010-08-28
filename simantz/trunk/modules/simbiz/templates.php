<?php
include "system.php";
include "menu.php";
include_once 'class/Log.php';
include_once 'class/AccountGroup.php';
include_once 'class/SelectCtrl.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$o = new AccountGroup();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
function IsNumeric(sText)
{
   var ValidChars = "0123456789.-";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
   }


	function validateAccountGroup(){
		
		var name=document.forms['frmAccountGroup'].accountgroup_name.value;

		var defaultlevel=document.forms['frmAccountGroup'].defaultlevel.value;
	
		if(confirm("Save record?")){
		if(name =="" || !IsNumeric(defaultlevel) || defaultlevel==""){
			alert('Please make sure name is filled in, Default Level is filled with numeric value');
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

$o->accountgroup_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->accountgroup_id=$_POST["accountgroup_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->accountgroup_id=$_GET["accountgroup_id"];

}
else
$action="";

$token=$_POST['token'];

$o->accountgroup_name=$_POST["accountgroup_name"];

$isactive=$_POST['isactive'];
$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->accountclass_id=$_POST['accountclass_id'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

if ($isactive==1 or $isactive=="on")
	$o->isactive=1;
else
	$o->isactive=0;


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with accountgroup name=$o->accountgroup_name");

	if ($s->check(false,$token,"CREATE_ACG")){
		
		
		
	if($o->insertAccountGroup()){
		 $latest_id=$o->getLatestAccountGroupID();
			 redirect_header("accountgroup.php?action=edit&accountgroup_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N');
		$o->accounclassctrl=$ctrl->getAccClass($o->accountclass_id,'N');

		$o->getInputForm("new",-1,$token);
		$o->showAccountGroupTable("WHERE accountgroup_id>0","ORDER BY defaultlevel,accountgroup_name"); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N');
		$o->accounclassctrl=$ctrl->getAccClass($o->accountclass_id,'N');

		$o->getInputForm("new",-1,$token);
		$o->showAccountGroupTable("WHERE accountgroup_id>0","ORDER BY defaultlevel,accountgroup_name"); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchAccountGroup($o->accountgroup_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N');
		$o->accounclassctrl=$ctrl->getAccClass($o->accountclass_id,'N');
		$o->getInputForm("edit",$o->accountgroup,$token);
		$o->showAccountGroupTable("WHERE accountgroup_id>0","ORDER BY defaultlevel,accountgroup_name"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("accountgroup.php",3,"Some error on viewing your accountgroup data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateAccountGroup()) //if data save successfully
			redirect_header("accountgroup.php?action=edit&accountgroup_id=$o->accountgroup_id",$pausetime,"Your data is saved.");
		else
			redirect_header("accountgroup.php?action=edit&accountgroup_id=$o->accountgroup_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("accountgroup.php?action=edit&accountgroup_id=$o->accountgroup_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteAccountGroup($o->accountgroup_id))
			redirect_header("accountgroup.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("accountgroup.php?action=edit&accountgroup_id=$o->accountgroup_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("accountgroup.php?action=edit&accountgroup_id=$o->accountgroup_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,0,'N');
	$o->accounclassctrl=$ctrl->getAccClass(0,'N');

	$o->getInputForm("new",0,$token);
	$o->showAccountGroupTable("WHERE accountgroup_id>0","ORDER BY defaultlevel,accountgroup_name");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

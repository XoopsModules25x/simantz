<?php

include_once "system.php" ;
//include_once 'class/Log.php';
include_once 'class/Religion.php';
//include_once 'class/Employee.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

//$log = new Log();
$o = new Religion($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmReligion'].religion_name.focus();
	}

	function validateReligion(){
		var name=document.forms['frmReligion'].religion_name.value;
		var org_id=document.forms['frmReligion'].organization_id.value;
		if(confirm('Save Record?')){
		if(name =="" ){
			alert("Please make sure 'Religion Name' is filled in.");
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

$o->religion_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->religion_id=$_POST["religion_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->religion_id=$_GET["religion_id"];

}
else
$action="";
$o->isAdmin=$xoopsUser->isAdmin();
$token=$_POST['token'];
$o->religion_description=$_POST["religion_description"];
$o->religion_name=$_POST["religion_name"];
$o->organization_id=$_POST["organization_id"];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	
$isactive=$_POST['isactive'];

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
	$log->showLog(4,"Accessing create record event, with religion name=$o->religion_name");

	if ($s->check(false,$token,"CREATE_STD")){
		
		
		
	if($o->insertReligion()){
		 $latest_id=$o->getLatestReligionID();
			 redirect_header("religion.php",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
		$log->showLog(1,"Warning, '$o->religion_name' cannot be save, please make sure your data is correct");
		$token=$s->createToken($tokenlife,"CREATE_STD");
		$o->orgctrl=$permission->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showReligionTable(); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"Warning, '$o->religion_name' cannot be save due to token expired");
		$token=$s->createToken($tokenlife,"CREATE_STD");
		$o->orgctrl=$permission->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showReligionTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchReligion($o->religion_id)){
		//create a new token for editing a form
		//$orgwhereaccess=$orgwhereaccess
		$token=$s->createToken($tokenlife,"CREATE_STD"); 
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->religion,$token);
		$o->showReligionTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("religion.php",3,"<b style='color:red'>Some error on viewing your religion data, probably database corrupted.</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_STD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateReligion()) //if data save successfully
			redirect_header("religion.php?action=edit&religion_id=$o->religion_id",$pausetime,"Your data is saved.");
		else
			redirect_header("religion.php?action=edit&religion_id=$o->religion_id",$pausetime,"<b style='color:red'>Warning! Can't save the '$o->religion_name', please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("religion.php?action=edit&religion_id=$o->religion_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->religion_name' due to token expired.</b>");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_STD")){
		if($o->deleteReligion($o->religion_id))
			redirect_header("religion.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("religion.php?action=edit&religion_id=$o->religion_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to data dependency.</b>");
	}
	else
		redirect_header("religion.php?action=edit&religion_id=$o->religion_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to token expired.</b>");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_STD");
	$o->orgctrl=$permission->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showReligionTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

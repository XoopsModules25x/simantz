<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/ChangeLog.php';
include_once 'class/Employee.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new ChangeLog($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function validateChangeLog(){
		var name=document.forms['frmChangeLog'].changelog_name.value;
		var org_id=document.forms['frmChangeLog'].organization_id.value;
		
		if(name =="" || org_id==""){
			alert('Please make sure ChangeLog name and organization is filled in.');
			return false;
		}
		else
			return true;
	}
</script>

EOF;

$o->changelog_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->changelog_id=$_POST["changelog_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->changelog_id=$_GET["changelog_id"];

}
else
$action="";

$token=$_POST['token'];
$o->changelog_description=$_POST["changelog_description"];
$o->changelog_name=$_POST["changelog_name"];
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
	$log->showLog(4,"Accessing create record event, with changelog name=$o->changelog_name");

	if ($s->check(false,$token,"CREATE_STD")){
		
		
		
	if($o->insertChangeLog()){
		 $latest_id=$o->getLatestChangeLogID();
			 redirect_header("changelog.php?action=edit&changelog_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create changelog!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_STD");
		$o->orgctrl=$e->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showChangeLogTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchChangeLog($o->changelog_id)){
		//create a new token for editing a form
		$token=$s->createToken(120,"CREATE_STD"); 
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->changelog,$token);
		$o->showChangeLogTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("changelog.php",3,"Some error on viewing your changelog data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_STD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateChangeLog()) //if data save successfully
			redirect_header("changelog.php?action=edit&changelog_id=$o->changelog_id",$pausetime,"Your data is saved.");
		else
			redirect_header("changelog.php?action=edit&changelog_id=$o->changelog_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("changelog.php?action=edit&changelog_id=$o->changelog_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_STD")){
		if($o->deleteChangeLog($o->changelog_id))
			redirect_header("changelog.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("changelog.php?action=edit&changelog_id=$o->changelog_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("changelog.php?action=edit&changelog_id=$o->changelog_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken(120,"CREATE_STD");
//	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showChangeLogTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

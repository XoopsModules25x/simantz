<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Standard.php';
//include_once 'class/Employee.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Standard($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmStandard'].standard_name.focus();
	}
	function validateStandard(){
		var name=document.forms['frmStandard'].standard_name.value;

		
	if(confirm('Save Record?')){	
		if(name =="" ){
			alert('Please make sure Standard name is filled in.');
			return false;
		}
		else
			return true;
	}
	return false;
	}
</script>

EOF;

$o->standard_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->standard_id=$_POST["standard_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->standard_id=$_GET["standard_id"];

}
else
$action="";

$token=$_POST['token'];
$o->standard_description=$_POST["standard_description"];
$o->standard_name=$_POST["standard_name"];
$o->organization_id=$_POST["organization_id"];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$isactive=$_POST['isactive'];
$o->isAdmin=$xoopsUser->isAdmin();
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
	$log->showLog(4,"Accessing create record event, with standard name=$o->standard_name");

	if ($s->check(false,$token,"CREATE_STD")){
		
		
		
	if($o->insertStandard()){
		 $latest_id=$o->getLatestStandardID();
			 redirect_header("standard.php",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
		$log->showLog(1,"Warning! Standard '$o->standard_name' is not saved, please verified your input!");
		$token=$s->createToken($tokenlife,"CREATE_STD");
		$o->orgctrl=$permission->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showStandardTable(); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"Warning! Standard '$o->standard_name' is not saved due to token expired!");
		$token=$s->createToken($tokenlife,"CREATE_STD");
		$o->orgctrl=$permission->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showStandardTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchStandard($o->standard_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_STD"); 
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->standard,$token);
		$o->showStandardTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("standard.php",3,"<b style='color:red'>Some error on viewing your standard data, probably database corrupted.</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_STD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateStandard()) //if data save successfully
			redirect_header("standard.php?action=edit&standard_id=$o->standard_id",$pausetime,"Your data is saved.");
		else
			redirect_header("standard.php?action=edit&standard_id=$o->standard_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->standard_name', please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("standard.php?action=edit&standard_id=$o->standard_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->standard_name' due to token expired</b>");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_STD")){
		if($o->deleteStandard($o->standard_id))
			redirect_header("standard.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("standard.php?action=edit&standard_id=$o->standard_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database.</b>");
	}
	else
		redirect_header("standard.php?action=edit&standard_id=$o->standard_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database.</b>");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_STD");
	$o->orgctrl=$permission->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showStandardTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

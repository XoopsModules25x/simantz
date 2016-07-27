<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/School.php';
//include_once 'class/Employee.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new School($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmSchool'].school_name.focus();
	}
	function validateSchool(){
		var name=document.forms['frmSchool'].school_name.value;
	if(confirm('Save Record?')){	
		if(name =="" ){
			alert('Please make sure School name is filled in.');
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

$o->school_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->school_id=$_POST["school_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->school_id=$_GET["school_id"];

}
else
$action="";

$token=$_POST['token'];
$o->school_description=$_POST["school_description"];
$o->school_name=$_POST["school_name"];
$o->organization_id=$_POST["organization_id"];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$isactive=$_POST['isactive'];

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';

if($o->organization_id == "")
$o->organization_id = $defaultorganization_id;



 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with school name=$o->school_name");

	if ($s->check(false,$token,"CREATE_STD")){
		
		
		
	if($o->insertSchool()){
		 $latest_id=$o->getLatestSchoolID();
			 redirect_header("school.php",$pausetime,"Your data is saved, the new id=$latest_id, redirect to create new school.");
		}
	else {
		$log->showLog(1,"Warning! School '$o->school_name' is not saved, please verified your data!");
		$token=$s->createToken($tokenlife,"CREATE_STD");
		$o->orgctrl=$permission->selectionOrg($o->created,$o->organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showSchoolTable(); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"Warning! School '$o->school_name' is not saved due to token expired!");
		$token=$s->createToken($tokenlife,"CREATE_STD");
		$o->orgctrl=$permission->selectionOrg($o->created,$o->organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showSchoolTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchSchool($o->school_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_STD"); 
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->school,$token);
		$o->showSchoolTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("school.php",3,"<b style='color:red'>Some error on viewing your school data, probably database corrupted.</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_STD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateSchool()) //if data save successfully
			redirect_header("school.php?action=edit&school_id=$o->school_id",$pausetime,"Your data is saved.");
		else
			redirect_header("school.php?action=edit&school_id=$o->school_id",$pausetime,"<b style='color:red'>Warning! Can't save the record '$o->school_name', please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("school.php?action=edit&school_id=$o->school_id",$pausetime,"<b style='color:red'>Warning! Can't save record '$o->school_name' due to token expired</b>.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_STD")){
		if($o->deleteSchool($o->school_id))
			redirect_header("school.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("school.php?action=edit&school_id=$o->school_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("school.php?action=edit&school_id=$o->school_id",$pausetime,"<b style='color:red'>Warning! Can't delete this record from database.</b>");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_STD");
	$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
	$o->getInputForm("new",0,$token);
	$o->showSchoolTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

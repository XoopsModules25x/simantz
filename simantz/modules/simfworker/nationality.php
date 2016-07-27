<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Nationality.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Nationality($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);


$action="";

echo <<< EOF
<script type="text/javascript">
	function validateNationality(){
		var name=document.forms['frmNationality'].nationality_name.value;
		if(confirm('Save Record?')==true){
			if(name =="" ){
				alert('Please make sure Nationality name is filled in.');
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

$o->nationality_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->nationality_id=$_POST["nationality_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->nationality_id=$_GET["nationality_id"];

}
else
$action="";

$token=$_POST['token'];

$o->nationality_description=$_POST["nationality_description"];
$o->nationality_name=$_POST["nationality_name"];
$isdefault=$_POST['isdefault'];
$isactive=$_POST['isactive'];

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');


if ($isactive=="1" or $isactive=="on")
	$o->isactive='1';
else
	$o->isactive='0';

if ($isdefault=="1" or $isdefault=="on")
	$o->isdefault='1';
else
	$o->isdefault='0';

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with nationality name=$o->nationality_name");

	if ($s->check(false,$token,"CREATE_NTN")){
		
		
		
	if($o->insertNationality()){
		 $latest_id=$o->getLatestNationalityID();
			 redirect_header("nationality.php?action=edit&nationality_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create nationality!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_NTN");
	//	$o->orgctrl=$e->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showNationalityTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchNationality($o->nationality_id)){
		//create a new token for editing a form
		$token=$s->createToken(120,"CREATE_NTN"); 
	//	$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->nationality,$token);
		$o->showNationalityTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("nationality.php",3,"Some error on viewing your nationality data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_NTN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateNationality()) //if data save successfully
			redirect_header("nationality.php?action=edit&nationality_id=$o->nationality_id",$pausetime,"Your data is saved.");
		else
			redirect_header("nationality.php?action=edit&nationality_id=$o->nationality_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("nationality.php?action=edit&nationality_id=$o->nationality_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_NTN")){
		if($o->deleteNationality($o->nationality_id))
			redirect_header("nationality.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("nationality.php?action=edit&nationality_id=$o->nationality_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("nationality.php?action=edit&nationality_id=$o->nationality_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken(120,"CREATE_NTN");
	//$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showNationalityTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

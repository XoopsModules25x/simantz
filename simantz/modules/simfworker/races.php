<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Races.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Races($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);


$action="";

echo <<< EOF
<script type="text/javascript">
	function validateRaces(){
		var name=document.forms['frmRaces'].races_name.value;
		if(confirm('Save Record?')==true){
			if(name =="" ){
				alert('Please make sure Races name is filled in.');
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

$o->races_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->races_id=$_POST["races_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->races_id=$_GET["races_id"];

}
else
$action="";

$token=$_POST['token'];

$o->races_description=$_POST["races_description"];
$o->races_name=$_POST["races_name"];
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
	$log->showLog(4,"Accessing create record event, with races name=$o->races_name");

	if ($s->check(false,$token,"CREATE_RCS")){
		
		
		
	if($o->insertRaces()){
		 $latest_id=$o->getLatestRacesID();
			 redirect_header("races.php?action=edit&races_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create races!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_RCS");
	//	$o->orgctrl=$e->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showRacesTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchRaces($o->races_id)){
		//create a new token for editing a form
		$token=$s->createToken(120,"CREATE_RCS"); 
	//	$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->races,$token);
		$o->showRacesTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("races.php",3,"Some error on viewing your races data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_RCS")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateRaces()) //if data save successfully
			redirect_header("races.php?action=edit&races_id=$o->races_id",$pausetime,"Your data is saved.");
		else
			redirect_header("races.php?action=edit&races_id=$o->races_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("races.php?action=edit&races_id=$o->races_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_RCS")){
		if($o->deleteRaces($o->races_id))
			redirect_header("races.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("races.php?action=edit&races_id=$o->races_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("races.php?action=edit&races_id=$o->races_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken(120,"CREATE_RCS");
	//$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showRacesTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

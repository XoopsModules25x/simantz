<?php
include_once "system.php";
include_once ("menu.php");
include_once './class/Area.php';
include_once 'class/Log.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$o = new Area($xoopsDB, $tableprefix, $log);
echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmArea'].area_name.focus();
	}

	function validateArea(){
		var name=document.forms['frmArea'].area_name.value;

		if(confirm('Save Record?')){	
		if(name =="" ){
			alert('Please make sure area name is filled in.');
			return false;
		}
		else
			return true;
		}
		return false;
	}
shortcut.add("Ctrl+1",function() {
	alert("Hi there!");
});

</script>

EOF;

if (isset ($_POST['action']))
{
	$o->area_id=$_POST['area_id'];
	$action=$_POST['action'];
}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->area_id=$_GET['area_id'];
}
else
$action="";

$token=$_POST['token'];
$o->area_name=$_POST["area_name"];
$o->area_description=$_POST['area_description'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	if ($s->check(false,$token,"CREATE_AREA")){
		$o->createdby=$xoopsUser->getVar('uid');
		$o->updatedby=$xoopsUser->getVar('uid');
		$log->showLog(4,"Accessing create record event, with area name=$o->area_name");
		if($o->insertArea()){
			$latest_id=$o->getLatestAreaID();
			redirect_header("area.php?action=edit&area_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
		$log->showLog(1, "Warning! Can't save '$o->area_name', please verified your data!");
		$token=$s->createToken($tokenlife,"CREATE_AREA");
		//$o->orgctrl=$o->selectionOrg($o->createdby,0);
		$o->getInputForm("edit",0,$token);
		$o->showAreaTable(); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1, "Warning! Can't save '$o->area_name' due to token expired!");

		$token=$s->createToken($tokenlife,"CREATE_AREA");
		//$o->orgctrl=$o->selectionOrg($o->createdby,0);
		$o->getInputForm("new",-1,$token);
		$o->showAreaTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchArea($o->area_id)){
		//$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_AREA"); 
		$o->getInputForm("edit",$o->area_id,$token);
		$o->showAreaTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("area.php",3,"<b style='color:red'>Some error on viewing your area data, probably database corrupted.</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_AREA")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateArea()) //if data save successfully
			redirect_header("area.php?action=edit&area_id=$o->area_id",$pausetime,"Your data is saved.");
		else
			redirect_header("area.php?action=edit&area_id=$o->area_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->area_name', please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("area.php?action=edit&area_id=$o->area_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->area_name' due to token expired.</b>");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_AREA")){
		if($o->deleteArea($o->area_id))
			redirect_header("area.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("area.php?action=edit&area_id=$o->area_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to dependency problem.</b>");
	}
	else
		redirect_header("area.php?action=edit&area_id=$o->area_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to token expired.</b>");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_AREA");
	//$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showAreaTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>
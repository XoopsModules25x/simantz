<?php

include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Room.php';
//include_once 'class/Employee.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Room($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmRoom'].room_name.focus();
	}
	function validateRoom(){
		var name=document.forms['frmRoom'].room_name.value;
	if(confirm('Save Record?')){	
		if(name =="" ){
			alert('Please make sure Room name is filled in.');
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

$o->room_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->room_id=$_POST["room_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->room_id=$_GET["room_id"];

}
else
$action="";

$token=$_POST['token'];
$o->room_description=$_POST["room_description"];
$o->room_name=$_POST["room_name"];
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
	$log->showLog(4,"Accessing create record event, with room name=$o->room_name");

	if ($s->check(false,$token,"CREATE_STD")){
		
		
		
	if($o->insertRoom()){
		 $latest_id=$o->getLatestRoomID();
			 redirect_header("room.php",$pausetime,"Your data is saved, the new id=$latest_id. Redirect to create new record.");
		}
	else {
		$log->showLog(1, "Can't create '$o->room_name', please verify your data!");
		$token=$s->createToken($tokenlife,"CREATE_STD");
		$o->orgctrl=$permission->selectionOrg($o->created,$o->organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showRoomTable(); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1, "Can't create '$o->room_name' due to token expired!");
		$token=$s->createToken($tokenlife,"CREATE_STD");
		$o->orgctrl=$permission->selectionOrg($o->created,$o->organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showRoomTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchRoom($o->room_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_STD"); 
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->room,$token);
		$o->showRoomTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("room.php",3,"<b style='color:red'>Some error on viewing your room data, probably database corrupted.</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_STD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateRoom()) //if data save successfully
			redirect_header("room.php?action=edit&room_id=$o->room_id",$pausetime,"Your data is saved.");
		else
			redirect_header("room.php?action=edit&room_id=$o->room_id",$pausetime,"<b style='color:red'>Warning! Can't save the data, please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("room.php?action=edit&room_id=$o->room_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->room_name' due to token expired.</b>");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_STD")){
		if($o->deleteRoom($o->room_id))
			redirect_header("room.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("room.php?action=edit&room_id=$o->room_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to dependency error.</b>");
	}
	else
		redirect_header("room.php?action=edit&room_id=$o->room_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to token expired.</b>");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_STD");
	$o->orgctrl=$permission->selectionOrg($o->createdby,$defaultorganization_id);
	$o->getInputForm("new",0,$token);
	$o->showRoomTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

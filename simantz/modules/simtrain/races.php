<?php
include_once "system.php" ;
//include_once 'class/Log.php';
include_once 'class/Races.php';
//include_once 'class/Employee.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

//$log = new Log();
$o = new Races($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmRaces'].races_name.focus();
	}
	function validateRaces(){
		var name=document.forms['frmRaces'].races_name.value;
		var org_id=document.forms['frmRaces'].organization_id.value;
		if(confirm('Save Record?')){
		if(name =="" ){
			alert("Please make sure 'Races Name' is filled in.");
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
	$log->showLog(4,"Accessing create record event, with races name=$o->races_name");

	if ($s->check(false,$token,"CREATE_RCE")){
		
	if($o->insertRaces()){
		 $latest_id=$o->getLatestRacesID();
			 redirect_header("races.php",$pausetime,"Your data is saved, the new id=$latest_id. Redirect to create new races.");
		}
	else {
		$log->showLog(1, "Can't create races '$o->races_name', please verified your data!");
		$token=$s->createToken($tokenlife,"CREATE_RCE");
		$o->orgctrl=$permission->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showRacesTable(); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1, "Can't create races '$o->races_name' due to token expired!");

		$token=$s->createToken($tokenlife,"CREATE_RCE");
		$o->orgctrl=$permission->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showRacesTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchRaces($o->races_id)){
		//create a new token for editing a form
		//$orgwhereaccess=$orgwhereaccess
		$token=$s->createToken($tokenlife,"CREATE_RCE"); 
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->races,$token);
		$o->showRacesTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("races.php",3,"<b style='color:red'>Some error on viewing your races data, probably database corrupted.</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_RCE")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateRaces()) //if data save successfully
			redirect_header("races.php?action=edit&races_id=$o->races_id",$pausetime,"Your data is saved.");
		else
			redirect_header("races.php?action=edit&races_id=$o->races_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->races_name', please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("races.php?action=edit&races_id=$o->races_id",$pausetime,"<b style='color:red'>Warning! Can't save the data '$o->races_name' due to token expired, please reenter data after form refresh.</b>");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_RCE")){
		if($o->deleteRaces($o->races_id))
			redirect_header("races.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("races.php?action=edit&races_id=$o->races_id",$pausetime,"<b style='color:red'>Warning! Can't delete 
					data from database due to dependency issue.</b>");
	}
	else
		redirect_header("races.php?action=edit&races_id=$o->races_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to token expired.</b>");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_RCE");
	$o->orgctrl=$permission->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showRacesTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

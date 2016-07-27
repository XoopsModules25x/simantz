<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Uom.php';
include_once 'class/Employee.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Uom($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	document.forms['frmUom'].uom_description.focus();
	}

	function validateUom(){
		var code=document.forms['frmUom'].uom_code.value;
		var desc=document.forms['frmUom'].uom_description.value;
		if(confirm("Save Record?")){
		if( code=="" || desc==""){
			alert('Please make sure Code and Description is filled in.');
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

$o->uom_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->uom_id=$_POST["uom_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->uom_id=$_GET["uom_id"];

}
else
$action="";

$token=$_POST['token'];
$o->uom_description=$_POST["uom_description"];
$o->remarks=$_POST["remarks"];
$o->uom_code=$_POST["uom_code"];
$o->organization_id=$_POST["organization_id"];

$isactive=$_POST['isactive'];

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();



if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with uom name=$o->uom_name");

	if ($s->check(false,$token,"CREATE_CAT")){
		
		
		
	if($o->insertUom()){
		 $latest_id=$o->getLatestUomID();
			 redirect_header("uom.php?action=edit&uom_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create uom!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_CAT");
		$o->orgctrl=$e->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showUomTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchUom($o->uom_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_CAT"); 
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->uom_id,$token);
		$o->showUomTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("uom.php",3,"Some error on viewing your uom data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_CAT")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateUom()) //if data save successfully
			redirect_header("uom.php?action=edit&uom_id=$o->uom_id",$pausetime,"Your data is saved.");
		else
			redirect_header("uom.php?action=edit&uom_id=$o->uom_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("uom.php?action=edit&uom_id=$o->uom_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_CAT")){
		if($o->deleteUom($o->uom_id))
			redirect_header("uom.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("uom.php?action=edit&uom_id=$o->uom_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("uom.php?action=edit&uom_id=$o->uom_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_CAT");
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showUomTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

<?php
include_once "admin_header.php" ;
include_once '../class/Address.php';
include_once '../class/Log.php';
include_once '../class/Organization.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

xoops_cp_header();


$log = new Log();
$ad= new Address($xoopsDB,$tableprefix,$log);
$o = new Organization($xoopsDB,$tableprefix,$log,$ad);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);

$pausetime=20;
$action="";

echo <<< EOF
<script type="text/javascript">
	function validateOrganization(){
		var name=document.forms['frmOrganzation'].organization_name.value;
		var code=document.forms['frmOrganzation'].organization_code.value;
		
		//if(name =="" || code==""){
		//	alert('Please make sure organization name and code is filled in');
		//	return false;
		//}
		//else
			return true;
	}
	function showAddressWindow(address_id){
		window.open('../address.php?address_id='+address_id+'&action=edit', "Editing address", "width=600,height=500,scrollbars=yes");
	}
</script>

EOF;


if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->organization_id=$_POST["organization_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->organization_id=$_GET["organization_id"];

}
else
$action="";

$token=$_POST['token'];
$o->organization_name=$_POST["organization_name"];
$o->organization_code=$_POST["organization_code"];
$o->tel_1=$_POST["tel_1"];
$o->tel_2=$_POST["tel_2"];
$o->fax=$_POST["fax"];
$o->groupid=$_POST['groupid'];
$o->rob_no=$_POST['rob_no'];
$isactive=$_POST['isactive'];

$o->website=$_POST["website"];
$o->contactemail=$_POST["contactemail"];
if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	if ($s->check(false,$token,"CREATE_ORG")){
		$o->createdby=$xoopsUser->getVar('uid');
		$o->updatedby=$xoopsUser->getVar('uid');
		$ad->createdby=$xoopsUser->getVar('uid');
		$ad->createdby=$xoopsUser->getVar('uid');
		
		$newaddress_id=$ad->createBlankAddress($ad->createdby);//create new address for organization
		if($newaddress_id>=0){
			$o->address_id=$newaddress_id;
		//if organization saved
			if($o->insertOrganization()){
				 $latest_id=$o->getLatestOrganizationID();
				 redirect_header("organization.php?action=edit&organization_id=$latest_id",$pausetime,"Your data is saved.");
			}
			else {
				echo "Can't create organization!";
			}
		}
		else{
			echo "Can't create organization, suspected error cause from failed to produce new address for organization";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_ORG");
		$o->getInputForm("new",-1,$token);
		$o->showOrganizationTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchOrganization($o->organization_id)){
		//create a new token for editing a form
		$token=$s->createToken(120,"CREATE_ORG"); 
		$o->groupctrl=$o->getAllSystemGroup($o->groupid);
		$o->getInputForm("edit",$o->organization_id,$token);
		$o->showOrganizationTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("organization.php",3,"Some error on viewing your organization data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ORG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateOrganization()) //if data save successfully
			redirect_header("organization.php?action=edit&organization_id=$o->organization_id",$pausetime,"Your data is saved.");
		else
			redirect_header("organization.php?action=edit&organization_id=$o->organization_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("organization.php?action=edit&organization_id=$o->organization_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ORG")){
		if($o->deleteOrganization($o->organization_id))
			redirect_header("organization.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("organization.php?action=edit&organization_id=$o->organization_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("organization.php?action=edit&organization_id=$o->organization_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$o->groupctrl=$o->getAllSystemGroup(0);
	$token=$s->createToken(120,"CREATE_ORG");
	$o->getInputForm("new",0,$token);
	$o->showOrganizationTable();
  break;

}
xoops_cp_footer();

?>

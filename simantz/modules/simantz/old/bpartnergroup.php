<?php
include "system.php";
include "menu.php";
include_once 'class/Log.php';
include_once 'class/BPartnerGroup.php';
include_once 'class/SelectCtrl.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$o = new BPartnerGroup();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
function IsNumeric(sText)
{
   var ValidChars = "0123456789.-";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
   }


	function validateBPartnerGroup(){
		
		var name=document.forms['frmBPartnerGroup'].bpartnergroup_name.value;
		var defaultlevel=document.forms['frmBPartnerGroup'].defaultlevel.value;
	
		if(confirm("Save record?")){
		if(name =="" || !IsNumeric(defaultlevel) || defaultlevel=="" ){
			alert('Please make sure name is filled in, Default Level filled with numeric value');
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

$o->bpartnergroup_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->bpartnergroup_id=$_POST["bpartnergroup_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->bpartnergroup_id=$_GET["bpartnergroup_id"];

}
else
$action="";

$token=$_POST['token'];

$o->bpartnergroup_name=$_POST["bpartnergroup_name"];

$o->isactive=$_POST['isactive'];
$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->debtoraccounts_id=$_POST['debtoraccounts_id'];
$o->creditoraccounts_id=$_POST['creditoraccounts_id'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');


if ($o->isactive==1 or $o->isactive=="on")
	$o->isactive=1;
else
	$o->isactive=0;


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with bpartnergroup name=$o->bpartnergroup_name");

	if ($s->check(false,$token,"CREATE_ACG")){
		
		
		
	if($o->insertBPartnerGroup()){
		 $latest_id=$o->getLatestBPartnerGroupID();
			 redirect_header("bpartnergroup.php",$pausetime,"Your data is saved, redirect to create more business partner group.");
		}
	else {
	$log->showLog(1,"Business partner group '$o->bpartnergroup_name' cannot save, please check your data.");
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->debtoraccountsctrl=$ctrl->getSelectAccounts($o->debtoraccounts_id,'Y',"","debtoraccounts_id","AND placeholder=0 AND account_type =2");
		$o->creditoraccountsctrl=$ctrl->getSelectAccounts($o->creditoraccounts_id,'Y',"","creditoraccounts_id","AND placeholder=0 AND account_type =3");

		$o->getInputForm("new",-1,$token);
		$o->showBPartnerGroupTable("WHERE g.bpartnergroup_id>0 and g.organization_id=$defaultorganization_id","ORDER BY g.defaultlevel,g.bpartnergroup_name"); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"Business partner group '$o->bpartnergroup_name' cannot be save due to token expired.");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->debtoraccountsctrl=$ctrl->getSelectAccounts($o->debtoraccounts_id,'Y',"","debtoraccounts_id","AND placeholder=0 AND account_type =2");
		$o->creditoraccountsctrl=$ctrl->getSelectAccounts($o->creditoraccounts_id,'Y',"","creditoraccounts_id","AND placeholder=0 AND account_type =3");

		$o->getInputForm("new",-1,$token);
		$o->showBPartnerGroupTable("WHERE g.bpartnergroup_id>0 and g.organization_id=$defaultorganization_id","ORDER BY g.defaultlevel,g.bpartnergroup_name"); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchBPartnerGroup($o->bpartnergroup_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->debtoraccountsctrl=$ctrl->getSelectAccounts($o->debtoraccounts_id,'Y',"","debtoraccounts_id","AND placeholder=0 AND account_type =2");
		$o->creditoraccountsctrl=$ctrl->getSelectAccounts($o->creditoraccounts_id,'Y',"","creditoraccounts_id","AND placeholder=0 AND account_type =3");

		$o->getInputForm("edit",$o->bpartnergroup,$token);
		$o->showBPartnerGroupTable("WHERE g.bpartnergroup_id>0 and g.organization_id=$defaultorganization_id","ORDER BY g.defaultlevel,g.bpartnergroup_name"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("bpartnergroup.php",3,"Some error on viewing your bpartnergroup data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateBPartnerGroup()) //if data save successfully
			redirect_header("bpartnergroup.php?action=edit&bpartnergroup_id=$o->bpartnergroup_id",$pausetime,"Your data is saved.");
		else
			redirect_header("bpartnergroup.php?action=edit&bpartnergroup_id=$o->bpartnergroup_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("bpartnergroup.php?action=edit&bpartnergroup_id=$o->bpartnergroup_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteBPartnerGroup($o->bpartnergroup_id))
			redirect_header("bpartnergroup.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("bpartnergroup.php?action=edit&bpartnergroup_id=$o->bpartnergroup_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("bpartnergroup.php?action=edit&bpartnergroup_id=$o->bpartnergroup_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	if($o->creditoraccounts_id == "")
		$o->creditoraccounts_id = 0;
	if($o->debtoraccounts_id == "")
		$o->debtoraccounts_id = 0;

	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
		$o->debtoraccountsctrl=$ctrl->getSelectAccounts($o->debtoraccounts_id,'Y',"","debtoraccounts_id","AND placeholder=0 AND account_type =2");
		$o->creditoraccountsctrl=$ctrl->getSelectAccounts($o->creditoraccounts_id,'Y',"","creditoraccounts_id","AND placeholder=0 AND account_type =3");


	$o->getInputForm("new",0,$token);
	$o->showBPartnerGroupTable("WHERE g.bpartnergroup_id>0 and g.organization_id=$defaultorganization_id","ORDER BY 
			g.defaultlevel,g.bpartnergroup_name");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

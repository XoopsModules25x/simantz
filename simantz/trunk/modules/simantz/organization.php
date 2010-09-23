<?php
//include_once "admin_header.php" ;
//xoops_cp_header();
include 'system.php';
include_once '../simantz/class/Organization.inc.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$s = new XoopsSecurity();
$action="";

echo <<< EOF
<script type="text/javascript">

	
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
  $o->organization_code = $_POST['organization_code'];
  $o->organization_name = $_POST['organization_name'];
  $o->companyname = $_POST['companyname'];
  $o->companyno = $_POST['companyno'];
 
  $o->isactive = $_POST['isactive'];
  $o->street1 = $_POST['street1'];
  $o->street2 = $_POST['street2'];
  $o->street3 = $_POST['street3'];
  $o->city = $_POST['city'];
  $o->state = $_POST['state'];
  $o->country_id = $_POST['country_id'];
  $o->postcode=$_POST['postcode'];
  $o->tel_1 = $_POST['tel_1'];
  $o->tel_2 = $_POST['tel_2'];
  $o->fax = $_POST['fax'];
  $o->seqno = $_POST['seqno'];
  $o->currency_id = $_POST['currency_id'];
  $o->email = $_POST['email'];
  $o->url = $_POST['url'];
  $o->groupid = $_POST['groupid'];
  $o->socso_acc = $_POST['socso_acc'];
  $o->epf_acc = $_POST['epf_acc'];
  $o->salary_acc = $_POST['salary_acc'];
  $o->accrued_acc = $_POST['accrued_acc'];

  $o->createdby=$xoopsUser->getVar('uid');
  $o->updatedby=$xoopsUser->getVar('uid');

  $isactive=$_POST['isactive'];
if ($isactive==1 or $isactive=="on")
	$o->isactive=1;
else
	$o->isactive=0;

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	if ($s->check(false,$token,"CREATE_ORG")){
		
		//if organization saved
			if($o->insertOrganization()){
				 $latest_id=$o->getLatestOrganizationID();
				 redirect_header("organization.php?action=edit&organization_id=$latest_id",$pausetime,"Your data is saved.");
			}
			else {
				$o->groupctrl=$ctrl->getAllSystemGroup(0);
				$token=$s->createToken($tokenlife,"CREATE_ORG");
				if($o->country_id=="")
					$o->country_id=0;
				if($o->currency_id=="")
					$o->currency_id=0;
				$o->countryctrl=$ctrl->getSelectCountry($o->country_id,'Y');
				$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'Y');
				$o->getInputForm("new",-1,$token);
				$o->showOrganizationTable("where organization_id>0","order by seqno,organization_name");
			}
		}
	
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$o->groupctrl=$ctrl->getAllSystemGroup(0);
		$token=$s->createToken($tokenlife,"CREATE_ORG");
				if($o->country_id=="")
					$o->country_id=0;
				if($o->currency_id=="")
					$o->currency_id=0;

		$o->countryctrl=$ctrl->getSelectCountry($o->country_id,'Y');
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'Y');
		$o->getInputForm("new",-1,$token);
		$o->showOrganizationTable("where organization_id>0","order by seqno,organization_name");
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchOrganization($o->organization_id)){
include 'menu.php';
		$token=$s->createToken($tokenlife,"CREATE_ORG");
		$o->countryctrl=$ctrl->getSelectCountry($o->country_id,'Y');
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'Y');
		$o->groupctrl=$ctrl->getAllSystemGroup($o->groupid);
	//	$o->accruedaccctrl=$ctrl->getSelectAccounts($o->accrued_acc,'Y',"","accrued_acc","","","N","","","style='width:150px'");
	//	$o->socsoaccctrl=$ctrl->getSelectAccounts($o->socso_acc,'Y',"","socso_acc","","","N","","","style='width:150px'");
	//	$o->epfaccctrl=$ctrl->getSelectAccounts($o->epf_acc,'Y',"","epf_acc","","","N","","","style='width:150px'");
	//	$o->salaryaccctrl=$ctrl->getSelectAccounts($o->salary_acc,'Y',"","salary_acc","","","N","","","style='width:150px'");

		$o->getInputForm("edit",$o->organization_id,$token);

	$o->showOrganizationTable("where organization_id>0","order by seqno,organization_name");

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
     include 'menu.php';
	$o->groupctrl=$ctrl->getAllSystemGroup(0);
	$token=$s->createToken($tokenlife,"CREATE_ORG");
	$o->countryctrl=$ctrl->getSelectCountry(0,'Y');
	$o->currencyctrl=$ctrl->getSelectCurrency(0,'Y');
   //    	$o->accruedaccctrl=$ctrl->getSelectAccounts(0,'Y',"","accrued_acc","","","N","","","style='width:150px'");
	//$o->socsoaccctrl=$ctrl->getSelectAccounts(0,'Y',"","socso_acc","","","N","","","style='width:150px'");
	//$o->epfaccctrl=$ctrl->getSelectAccounts(0,'Y',"","epf_acc","","","N","","","style='width:150px'");
	//$o->salaryaccctrl=$ctrl->getSelectAccounts(0,'Y',"","salary_acc","","","N","","","style='width:150px'");

	$o->getInputForm("new",0,$token);
	$o->showOrganizationTable("where organization_id>0","order by seqno,organization_name");
  break;

}
  require(XOOPS_ROOT_PATH.'/footer.php');

?>

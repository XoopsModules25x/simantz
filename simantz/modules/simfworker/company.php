<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Company.php';
include_once 'class/Currency.php';
include_once 'class/WorkerCompany.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Company($xoopsDB,$tableprefix,$log);
$wc = new WorkerCompany($xoopsDB,$tableprefix,$log);
$cr = new Currency($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function validateCompany(){
		var name=document.forms['frmCompany'].company_name.value;
		var org_id=document.forms['frmCompany'].organization_id.value;
		
		if(name =="" || org_id==""){
			alert('Please make sure Company name and organization is filled in.');
			return false;
		}
		else
			return true;
	}
</script>

EOF;

$o->company_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->company_id=$_POST["company_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->company_id=$_GET["company_id"];

}
else
$action="";

$token=$_POST['token'];

//================

$o->company_no=$_POST["company_no"];
$o->company_name=$_POST["company_name"];
$o->street1=$_POST["street1"];
$o->street2=$_POST["street2"];
$o->postcode=$_POST["postcode"];
$o->city=$_POST["city"];
$o->state1=$_POST["state1"];
$o->country=$_POST["country"];
$o->contactperson=$_POST["contactperson"];
$o->contactperson_no=$_POST["contactperson_no"];
$o->tel1=$_POST["tel1"];
$o->tel2=$_POST["tel2"];
$o->fax=$_POST["fax"];
$o->description=$_POST["description"];
$o->created=$_POST["created"];
$o->updated=$_POST["updated"];
$o->currency_id=$_POST['currency_id'];
$o->isactive=$_POST["isactive"];
$isdefault=$_POST['isdefault'];

//==================


$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');


if ($o->isactive=="on")
	$o->isactive=1;
elseif($o->isactive=="")
	$o->isactive=0;

if ($isdefault=="1" or $isdefault=="on")
	$o->isdefault=1;
else
	$o->isdefault=0;

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Customer Master Data</span></big></big></big></div><br>
EOF;
$filterstring=$o->searchAToZ();

if($_GET['filterstring'] != "")
	$filterstring=$_GET['filterstring'];
 switch ($action){

	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with company name=$o->company_name");

	if ($s->check(false,$token,"CREATE_CMP")){
		
	if($o->insertCompany()){
		 $latest_id=$o->getLatestCompanyID();
			 redirect_header("company.php?action=edit&company_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create company!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_CMP");
		$o->getInputForm("new",-1,$token);
		$o->showCompanyTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchCompany($o->company_id)){
		//create a new token for editing a form
		$token=$s->createToken(120,"CREATE_CMP");
		$o->currencyctrl=$cr->getSelectCurrency($o->currency_id);
		$o->getInputForm("edit",$o->company_id,$token);
		$wc->showCompanyEmploymentTable("WHERE wc.company_id=$o->company_id","order by wc.joindate ",0,99999); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("company.php",3,"Some error on viewing your company data, probably database corrupted");
  
break;

//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_CMP")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateCompany()) //if data save successfully
			redirect_header("company.php?action=edit&company_id=$o->company_id",$pausetime,"Your data is saved.");
		else
			redirect_header("company.php?action=edit&company_id=$o->company_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("company.php?action=edit&company_id=$o->company_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_CMP")){
		if($o->deleteCompany($o->company_id))
			redirect_header("company.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("company.php?action=edit&company_id=$o->company_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("company.php?action=edit&company_id=$o->company_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "new" :
	$token=$s->createToken(120,"CREATE_CMP");
	$o->currencyctrl=$cr->getSelectCurrency(0);
	$o->getInputForm("new",0,$token);
	
	//$o->showCompanyTable("WHERE c.isactive=1","order by c.company_name",0,99999);
  break;
  case "showSearchForm":
	$o->companyctrl=$o->getSelectCompany(-1);
	$o->showSearchForm();
  break;
  case "search":
	$o->companyctrl=$o->getSelectCompany(-1);
	$wherestring=$o->convertSearchString($o->company_id,$o->company_no,$o->company_name,$o->isactive);
	$log->showLog(4,"Filterstring:$o->company_id,$o->company_no,$o->company_name,$o->isactive");
	$o->showSearchForm();
	$o->showCompanyTable($wherestring,"ORDER BY c.company_name",0,9999);
  break;
  default :
//	$token=$s->createToken(120,"CREATE_CMP");
//	$o->getInputForm("new",0,$token);
//	$o->currencyctrl=$cr->getSelectCurrency(0);
	if ($filterstring=="")
		$filterstring="A";
	$o->showCompanyTable("WHERE c.company_name LIKE '$filterstring%' and c.isactive=1","order by c.company_name",0,99999);
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

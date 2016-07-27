<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Vendor.php';
include_once 'class/Customer.php';
include_once 'class/Product.php';
include_once 'class/Employee.php';
include_once 'class/Terms.php';
include_once 'class/Expensescategory.php';
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Vendor($xoopsDB,$tableprefix,$log);
$c = new Expensescategory($xoopsDB,$tableprefix,$log);
$t = new Customer($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$p = new Product($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);
$m = new Terms($xoopsDB,$tableprefix,$log);

$o->orgctrl="";
$o->termsctrl="";
$o->categoryctrl="";


$action="";

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Vendor List</span></big></big></big></div><br>

<script type="text/javascript">
	function autofocus(){
	document.forms['frmVendor'].vendor_name.focus();
	}

	function validateVendor(){
		var desc=document.forms['frmVendor'].vendor_name.value;
		var code=document.forms['frmVendor'].vendor_no.value;
		
		if(confirm("Save Record?")){
		if(desc =="" || code==""){
			alert('Please make sure Vendor no and name is filled in');
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

$o->category_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->vendor_id=$_POST["vendor_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->vendor_id=$_GET["vendor_id"];

}
else
$action="";
$token=$_POST['token'];

$o->vendor_no=$_POST["vendor_no"];
$o->vendor_name=$_POST["vendor_name"];
$o->vendor_hpno=$_POST["vendor_hpno"];
$o->vendor_telno=$_POST["vendor_telno"];
$o->vendor_faxno=$_POST["vendor_faxno"];
$o->vendor_street1=$_POST["vendor_street1"];
$o->vendor_street2=$_POST["vendor_street2"];
$o->vendor_country=$_POST["vendor_country"];
$o->vendor_state=$_POST["vendor_state"];
$o->vendor_city=$_POST["vendor_city"];
$o->vendor_postcode=$_POST["vendor_postcode"];
$o->vendor_pic=$_POST["vendor_pic"];
$o->terms_id=$_POST["terms_id"];
$o->vendor_remarks=$_POST["vendor_remarks"];

$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	
$o->organization_id=$_POST["organization_id"];
$o->isAdmin=$xoopsUser->isAdmin();
$isactive=$_POST['isactive'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

$o->datectrl=$dp->show("vendor_expiry");


if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';


$filterstring=$o->searchAToZ();
if($_GET['filterstring'] != "")
$filterstring=$_GET['filterstring'];


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired


	if ($s->check(false,$token,"CREATE_VEN")){
		$log->showLog(4,"Accessing create record event, with product name=$o->vendor_name");
		if($o->insertVendor()){
			$latest_id=$o->getLatestVendorID();
//			if($filesize>0 || $filetype=='application/pdf')
	//		$o->savefile($tmpfile);
			redirect_header("vendor.php?action=edit&vendor_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create product!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_VEN");
		$o->customerctrl=$t->getSelectCustomer($o->customer_id);
		$o->productctrl=$p->getSelectProduct($o->product_id);
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->termsctrl=$m->getSelectTerms(0);
		

		$o->getInputForm("new",-1,$token);
		$o->showVendorTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchVendorInfo($o->vendor_id)){
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->customerctrl=$t->getSelectCustomer($o->customer_id);
		$o->productctrl=$p->getSelectProduct($o->product_id);
		$o->termsctrl=$m->getSelectTerms($o->terms_id);

		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_VEN"); 
		$o->getInputForm("edit",$o->vendor_id,$token);
		$o->showVendorTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("vendor.php",3,"Some error on viewing your product data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_VEN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid

		if($o->updateVendor()) {
		
		
			redirect_header("vendor.php?action=edit&vendor_id=$o->vendor_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("vendor.php?action=edit&vendor_id=$o->vendor_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("vendor.php?action=edit&vendor_id=$o->vendor_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_VEN")){
		if($o->deleteVendor($o->vendor_id)){
			redirect_header("vendor.php",$pausetime,"Data removed successfully.");
			$o->deletefile($o->vendor_id);
		}
		else
			redirect_header("vendor.php?action=edit&vendor_id=$o->vendor_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("vendor.php?action=edit&vendor_id=$o->vendor_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
  	
	$token=$s->createToken($tokenlife,"CREATE_VEN");
	$o->customerctrl=$t->getSelectCustomer(1);
	$o->productctrl=$p->getSelectProduct(1);
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
$o->termsctrl=$m->getSelectTerms(0);
	$o->getInputForm("new",0,$token);
	

	if ($filterstring=="")
		$filterstring="A";

	$o->showVendorTable(" and a.vendor_name LIKE '$filterstring%' ");
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

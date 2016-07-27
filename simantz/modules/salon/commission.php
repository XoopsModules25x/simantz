<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Commission.php';
include_once 'class/Customer.php';
include_once 'class/Product.php';
include_once 'class/Employee.php';
include_once 'class/Expensescategory.php';
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Commission($xoopsDB,$tableprefix,$log);
$c = new Expensescategory($xoopsDB,$tableprefix,$log);
$t = new Customer($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$p = new Product($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);

$o->orgctrl="";
$o->categoryctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">

	function autofocus(){
	document.forms['frmCommission'].commission_name.focus();
	}

	function validateCommission(){
		var desc=document.forms['frmCommission'].commission_name.value;
		var code=document.forms['frmCommission'].commission_no.value;
		var amt=document.forms['frmCommission'].commission_amount.value;
		var amtmax=document.forms['frmCommission'].commission_amountmax.value;
		var percent=document.forms['frmCommission'].commission_percent.value;

		
		if(confirm("Save Record?")){
		if(desc =="" || code==""|| !IsNumeric(amt)|| !IsNumeric(amtmax)|| !IsNumeric(percent)){
			alert('Please make sure Commission no and name is filled in, Commission Price filled with number.');
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
	$o->commission_id=$_POST["commission_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->commission_id=$_GET["commission_id"];

}
else
$action="";
$token=$_POST['token'];

$o->commission_no=$_POST["commission_no"];
$o->commission_name=$_POST["commission_name"];
$o->commission_type=$_POST["commission_type"];
$o->commission_amount=$_POST["commission_amount"];
$o->commission_amountmax=$_POST["commission_amountmax"];
$o->commission_percent=$_POST["commission_percent"];
$o->commission_remarks=$_POST["commission_remarks"];

$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	
$o->organization_id=$_POST["organization_id"];
$o->isAdmin=$xoopsUser->isAdmin();
$isactive=$_POST['isactive'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

$o->datectrl=$dp->show("commission_expiry");


if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';



 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired


	if ($s->check(false,$token,"CREATE_EXP")){
		$log->showLog(4,"Accessing create record event, with product name=$o->commission_name");
		if($o->insertCommission()){
			$latest_id=$o->getLatestCommissionID();
			if($filesize>0 || $filetype=='application/pdf')
			$o->savefile($tmpfile);
			redirect_header("commission.php?action=edit&commission_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create product!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_EXP");
		$o->customerctrl=$t->getSelectCustomer($o->customer_id);
		$o->productctrl=$p->getSelectProduct($o->product_id);
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);

		$o->getInputForm("new",-1,$token);
		$o->showCommissionTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchCommissionInfo($o->commission_id)){
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->customerctrl=$t->getSelectCustomer($o->customer_id);
		$o->productctrl=$p->getSelectProduct($o->product_id);

		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_EXP"); 
		$o->getInputForm("edit",$o->commission_id,$token);
		$o->showCommissionTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("commission.php",3,"Some error on viewing your product data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_EXP")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid

		if($o->updateCommission()) {
		
		
			redirect_header("commission.php?action=edit&commission_id=$o->commission_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("commission.php?action=edit&commission_id=$o->commission_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("commission.php?action=edit&commission_id=$o->commission_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_EXP")){
		if($o->deleteCommission($o->commission_id)){
			redirect_header("commission.php",$pausetime,"Data removed successfully.");
			$o->deletefile($o->commission_id);
		}
		else
			redirect_header("commission.php?action=edit&commission_id=$o->commission_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("commission.php?action=edit&commission_id=$o->commission_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_EXP");
	$o->customerctrl=$t->getSelectCustomer(1);
	$o->productctrl=$p->getSelectProduct(1);
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showCommissionTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

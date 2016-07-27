<?php
include "system.php" ;
include_once './class/Customer.php';
include_once './class/Log.php';
include_once "menu.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);



$log = new Log();
$o = new Customer($xoopsDB, $tableprefix, $log);
$s = new XoopsSecurity();
$pausetime=5;

$action="";
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->customer_id=$_POST["customer_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->customer_id=$_GET["customer_id"];

}
else
$action="";

$token=$_POST['token'];
$o->customer_name=$_POST['customer_name'];
$o->personincharge=$_POST['personincharge'];
$o->tel1=$_POST['tel1'];
$o->tel2=$_POST['tel2'];
$o->email=$_POST['email'];
$o->address1=$_POST['address1'];
$o->address2=$_POST['address2'];
$o->postcode=$_POST['postcode'];
$o->city=$_POST['city'];
$o->state_id=$_POST['state_id'];
$o->country=$_POST['country'];
$o->organization_id=$_POST["organization_id"];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

$isactive=$_POST['isactive'];
if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	if ($s->check(false,$token,"CREATE_TPT")){

		if($o->insertCustomer( )){
		 $latest_id=$o->getLatestCustomerID();
		 redirect_header("customer.php?action=edit&customer_id=$latest_id",$pausetime,"Your data is saved.");
		}
		else 
			echo "Can't create customer record!";
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_TPT");
		$o->getInputForm("new",-1,$token);
		$o->showCustomerTable(); 
	}
 
break;
	//when user request to edit particular customer
  case "edit" :
	if($o->fetchCustomer($o->customer_id)){
		//create a new token for editing a form
		$token=$s->createToken(120,"CREATE_TPT"); 
		$o->getInputForm("edit",$o->customer_id,$token);
		$o->showCustomerTable(); 
	}
	else	//if can't find particular transport from database, return error message
		redirect_header("customer.php",$pausetime,"Some error on viewing your customer service data, probably database corrupted");
  
break;
//when user press save for change existing customer data
  case "update" :
	if ($s->check(false,$token,"CREATE_TPT")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateCustomer()) //if data save successfully
			redirect_header("customer.php?action=edit&customer_id=$o->customer_id",$pausetime,"Your data is saved.");
		else
			redirect_header("customer.php?action=edit&customer_id=$o->customer_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("customer.php?action=edit&customer_id=$o->customer_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_TPT")){
		if($o->deleteCustomer($o->customer_id))
			redirect_header("customer.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("customer.php?action=edit&customer_id=$o->customer_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("customer.php?action=edit&customer_id=$o->customer_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken(120,"CREATE_TPT");
	$o->getInputForm("new",0,$token);
	$o->showCustomerTable();
  break;

}
require(XOOPS_ROOT_PATH.'/footer.php');
?>

<?php
include "system.php" ;
include_once "menu.php";
include_once './class/Customer.php';
include_once './class/Customertype.php';
include_once './class/Log.php';
//include_once './class/Address.php';
require ("datepicker/class.datepicker.php");
include './class/Races.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';



$log = new Log();
//$ad = new Address($xoopsDB,$tableprefix,$log);
$o= new Customer($xoopsDB,$tableprefix,$log,$ad);
$t= new Customertype($xoopsDB,$tableprefix,$log,$ad);
$s = new XoopsSecurity();
$r = new Races($xoopsDB,$tableprefix,$log);

$action="";


//marhan add here --> ajax
//echo "<iframe src='customer.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
//echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
/////////////////////

echo <<< EOF
<div style='border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);'><big><big><big><span style='font-weight: bold;'>Customers Record</span></big></big></big></div>

<script type="text/javascript">

	function searchCustomer(){//searching
		document.forms['frmSearch'].action.value = "search";
		document.forms['frmSearch'].fldShow.value = "Y";
		document.forms['frmSearch'].submit();
	}

	function showSearch(){//show search form
		document.forms['frmCustomer'].action.value = "search";
		document.forms['frmCustomer'].submit();
	}

	function autofocus(){
	document.forms['frmCustomer'].customer_name.focus();
	}

	function editRecord(customer_id) {//example of ajax

		var arr_fld=new Array("tbl","action","customer_id");//name for POST
		var arr_val=new Array("Y","edit",customer_id);//value for POST
		
		getRequest(arr_fld,arr_val);
		
	}

	function showSearchForm(){
		var txtSearch = document.getElementById('txtSearch').innerHTML;
		
		if(txtSearch.search("Show")>=0)
		document.getElementById('txtSearch').innerHTML = 'Hide Search Option';
		else
		document.getElementById('txtSearch').innerHTML = 'Show Search Option';

	}

	function validateCustomer(){
		
		var customer_no=document.frmCustomer.customer_no.value;
		var customer_name=document.frmCustomer.customer_name.value;
		var ic_no=document.frmCustomer.ic_no.value;



		if (confirm("Confirm to save record?")){
			if(customer_no !="" && customer_name!="" && ic_no!="" ){
				return true;
			}
			else	{
				alert ("Please make sure Customer No, Customer Name, IC Number is not empty.");
				return false;
				}
		}
		else
			return false;
	}
	

/*	function showAddressWindow(address_id){
		window.open('address.php?address_id='+address_id+'&action=edit', "Editing address", "width=600,height=500,scrollbars=yes");
	}*/
</script>

EOF;
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
$o->customer_no=$_POST["customer_no"];
$o->customer_name=$_POST["customer_name"];
$o->ic_no=$_POST["ic_no"];
$o->gender=$_POST["gender"];
$o->dateofbirth=$_POST["dateofbirth"];
$o->joindate=$_POST["joindate"];
$o->hp_no=$_POST["hp_no"];
$o->street_1=$_POST["street_1"];
$o->street_2=$_POST["street_2"];
$o->tel_1=$_POST["tel_1"];
$o->remarks=$_POST["remarks"];
$o->country=$_POST["country"];
$o->state=$_POST["state"];
$o->city=$_POST["city"];
$o->postcode=$_POST["postcode"];
//$o->address_id=$_POST["address_id"];
$o->uid=$_POST['uid'];
$o->isAdmin=$xoopsUser->isAdmin();
$o->races_id=$_POST['races_id'];
$o->customertype=$_POST["customertype"];
$o->showcalendar=$dp->show("dateofbirth");
$o->showcalendar2=$dp->show("joindate");
$o->organization_id=$_POST["organization_id"];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

$tbl=$_POST['tbl'];
//$ad->createdby=$xoopsUser->getVar('uid');
//$ad->updatedby=$xoopsUser->getVar('uid');
$o->orgWhereString=$o->orgWhereStr($xoopsUser->getVar('uid'));
$isactive=$_POST['isactive'];
$isdefault=$_POST['isdefault'];

if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
elseif($isactive=="X")
	$o->isactive='X';
else
	$o->isactive='N';


if ($isdefault=="Y" or $isdefault=="on")
	$o->isdefault='Y';
elseif($isdefault=="X")
	$o->isdefault='X';
else
	$o->isdefault='N';

/*
if ($isdefault=="Y" or $isdefault=="on")
	$o->isdefault='Y';
else
	$o->isdefault='N';
*/


$filterstring=$o->searchAToZ();
if($_GET['filterstring'] != "")
$filterstring=$_GET['filterstring'];

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	if ($s->check(false,$token,"CREATE_EMP")){
		
		
//		$newaddress_id=$ad->createBlankAddress($ad->createdby);//create new address for customer
//		if($newaddress_id>=0){
//			$o->address_id=$newaddress_id;
		//if organization saved
			if($o->insertcustomer()){
				 $latest_id=$o->getLatestcustomerID();
				 redirect_header("customer.php?action=edit&customer_id=$latest_id",$pausetime,"Your data is saved.");
			}
			else {
				echo "<strong style='color:#ff0000;'>Data can't save, please verified your IC and Customer Number is unique</strong>";
				$token=$s->createToken($tokenlife ,"CREATE_EMP");
				$o->userctrl=$o->selectAvailableSysUser(0);
				$o->orgctrl=$o->selectionOrg($o->createdby,0);
				$o->customertypectrl=$t->getSelectCustomertype(0,"customertype");
				$o->racesctrl=$r->getSelectRaces($o->races_id);
				$o->getInputForm("edit",0,$token);
				//$o->showcustomerTable();
			}
//		}
//		else{
//			echo "Can't create customer, suspected error cause from failed to produce new address for customer";
//		}
	}

	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_EMP");
		$o->userctrl=$o->selectAvailableSysUser(0);
		$o->orgctrl=$t->selectionOrg($o->createdby,0);
		$o->customertypectrl=$o->getSelectCustomertype(0,"customertype");
		$o->racesctrl=$r->getSelectRaces($o->races_id);
		$o->getInputForm("new",-1,$token);
		//$o->showcustomerTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :

	if($o->fetchcustomer($o->customer_id)){
		//create a new token for editing a form

		$token=$s->createToken($tokenlife,"CREATE_EMP"); 
		$o->orgctrl=$o->selectionOrg($o->createdby,$o->organization_id);
		$o->customertypectrl=$t->getSelectCustomertype($o->customertype,"customertype");
		$o->userctrl=$o->selectAvailableSysUser($o->uid);
		$o->racesctrl=$r->getSelectRaces($o->races_id);

		$o->getInputForm("edit",$o->customer_id,$token);
		$o->showTab();

		//$tabselected = $o->customerServiceTable();	
echo <<< EOF
	<script type="text/javascript">
	//self.document.getElementById('idTab').innerHTML = '$tabselected';
	//alert('$tabselected');
	</script>
EOF;
		

	}
	else	//if can't find particular organization from database, return error message
		redirect_header("customer.php",$pausetime,"Some error on viewing your customer data, probably database corrupted");

break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_EMP")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updatecustomer()) //if data save successfully
			redirect_header("customer.php?action=edit&customer_id=$o->customer_id",$pausetime,"Your data is saved.");
		else
			redirect_header("customer.php?action=edit&customer_id=$o->customer_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("customer.php?action=edit&customer_id=$o->customer_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_EMP")){
		if($o->deletecustomer($o->customer_id))
			redirect_header("customer.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("customer.php?action=edit&customer_id=$o->customer_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("customer.php?action=edit&customer_id=$o->customer_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

  case "search" :
	$o->userctrl=$o->selectAvailableSysUser(0);
	$o->racesctrl=$r->getSelectRaces(-1);

	$o->orgctrl=$o->selectionOrg($o->createdby,0);
	$o->customertypectrl=$t->getSelectCustomertype(0,"customertype");
	//$o->orgctrl=$e->selectionOrg($o->createdby,0);
	//$o->getInputForm("new",0,$token);
	$o->showcustomerTable();

  break;

  case "tab" :
	$tabselected = $o->customerServiceTable();	
  break;

  default :
	$token=$s->createToken($tokenlife ,"CREATE_EMP");
	$o->userctrl=$o->selectAvailableSysUser(0);
	$o->racesctrl=$r->getSelectRaces(0);

	$o->orgctrl=$o->selectionOrg($o->createdby,0);
	$o->customertypectrl=$t->getSelectCustomertype(0,"customertype");

	$o->getInputForm("new",0,$token);

	if ($filterstring=="")
		$filterstring="A";

	$o->showcustomerTable(" and a.customer_name LIKE '$filterstring%' ");
  break;

}
require(XOOPS_ROOT_PATH.'/footer.php');
?>

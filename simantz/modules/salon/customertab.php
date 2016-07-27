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


<script type="text/javascript">
	
	function showAll(tab,customer_id){
	self.parent.document.getElementById('idTab').src = "customertab.php?action=tab&tabid="+tab+"&customer_id="+customer_id+"&isshowall=Y";
	}

	function viewNextPrevRecord(tab,customer_id,pageno){
	self.parent.document.getElementById('idTab').src = "customertab.php?action=tab&tabid="+tab+"&customer_id="+customer_id+"&pageno="+pageno;
	}

	function changeTab(tab,customer_id){
	//alert(tab);
	self.parent.document.getElementById('idTab').src = "customertab.php?action=tab&tabid="+tab+"&customer_id="+customer_id;
	
	}

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


$o->pageno = $_GET['pageno'];
$o->isshowall = $_GET['isshowall'];
 switch ($action){
	//When user submit new organization
  
  case "tab" :
	$tabid = $_GET['tabid'];
	
	if($tabid == 2)
	$tabselected = $o->customerPaymentTable();	
	else
	$tabselected = $o->customerServiceTable();	
  break;

  

}
//require(XOOPS_ROOT_PATH.'/footer.php');
?>

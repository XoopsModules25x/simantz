<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Customer.php';
include_once 'class/Terms.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Customer($xoopsDB,$tableprefix,$log);
$t = new Terms($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);

//$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">


	function onOpen(){
	document.forms['frmCustomer'].customer_no.focus();
	}
	
	function validateCustomer(){
		var name=document.forms['frmCustomer'].customer_name.value;
		var cust_no=document.forms['frmCustomer'].customer_no.value;

		if(confirm('Confirm change this data?')==false){
  		return false;
  		}else{
  		
		if(name =="" || cust_no==""){
			alert('Please make sure customer no and customer name is filled in.');
			return false;
		}
		else
			return true;
			
		}
	}
	

	function headerSort(sortFldValue){

		document.frmActionSearch.fldSort.value = sortFldValue;

		//document.frmActionSearch.btnSubmit.click();
		document.frmActionSearch.submit();

	}
</script>

EOF;

$o->customer_id=0;
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

//================

$o->customer_no=$_POST["customer_no"];
$o->customer_name=$_POST["customer_name"];
$o->customer_street1=$_POST["customer_street1"];
$o->customer_street2=$_POST["customer_street2"];
$o->customer_postcode=$_POST["customer_postcode"];
$o->customer_city=$_POST["customer_city"];
$o->customer_state=$_POST["customer_state"];
$o->customer_country=$_POST["customer_country"];
$o->customer_tel1=$_POST["customer_tel1"];
$o->customer_tel2=$_POST["customer_tel2"];
$o->customer_fax=$_POST["customer_fax"];
$o->customer_contactperson=$_POST["customer_contactperson"];
$o->customer_contactno=$_POST["customer_contactno"];
$o->customer_contactnohp=$_POST["customer_contactnohp"];
$o->customer_contactfax=$_POST["customer_contactfax"];
$o->customer_desc=$_POST["customer_desc"];
$o->terms_id=$_POST["terms_id"];
$o->customer_accbank=$_POST["customer_accbank"];
$o->customer_bank=$_POST["customer_bank"];

$o->created=$_POST["created"];
$o->updated=$_POST["updated"];
$o->isactive=$_POST["isactive"];


//==================


$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');


if ($o->isactive=="on")
	$o->isactive=1;
elseif($o->isactive=="")
	$o->isactive=0;

/*
if ($isdefault=="1" or $isdefault=="on")
	$o->isdefault=1;
else
	$o->isdefault=0;
	*/

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
	$log->showLog(4,"Accessing create record event, with customer name=$o->customer_name");

	if ($s->check(false,$token,"CREATE_CUST")){
		
	if($o->insertCustomer()){
		 $latest_id=$o->getLatestCustomerID();
			 redirect_header("customer.php?action=edit&customer_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				//echo "Can't create customer!";
				redirect_header("customer.php?action=new",3,"<b style='color:red'>Can't create customer!</b>");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_CUST");
		$o->getInputForm("new",-1,$token);
		$o->showCustomerTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :

	if($o->fetchCustomer($o->customer_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_CUST");
		$o->termsctrl=$t->getSelectTerms($o->terms_id);
		//$o->currencyctrl=$cr->getSelectCurrency($o->currency_id);
		$o->getInputForm("edit",$o->customer_id,$token);
		
//		$wc->showCustomerEmploymentTable("WHERE wc.customer_id=$o->customer_id","order by wc.customer_name ",0,99999); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("customer.php",3,"Some error on viewing your customer data, probably database corrupted");
  
break;

//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_CUST")){
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
	if ($s->check(false,$token,"CREATE_CUST")){
		if($o->deleteCustomer($o->customer_id))
			redirect_header("customer.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("customer.php?action=edit&customer_id=$o->customer_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("customer.php?action=edit&customer_id=$o->customer_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "new" :
	$token=$s->createToken($tokenlife,"CREATE_CUST");
	//$o->currencyctrl=$cr->getSelectCurrency(0);
	$o->termsctrl=$t->getSelectTerms(0);
	$o->getInputForm("new",0,$token);
	
	//$o->showCustomerTable("WHERE c.isactive=1","order by c.customer_name",0,99999);
  break;
  case "showSearchForm":
	$o->customerctrl=$o->getSelectCustomer(-1);
	$o->termsctrl=$t->getSelectTerms(-1);
	$o->showSearchForm();
  break;
  case "search":
  
  $sortstr = "ORDER BY c.customer_name";
  $wherestr=$o->convertSearchString($o->customer_id,$o->customer_no,$o->customer_name,$o->isactive);
  $fldSort = '';
  
  
	// start sort header
	
	
	if($_POST['fldSort']!=''){
	$fldSort = $_POST['fldSort'];
	$wherestr = str_replace('\\', '',$_POST['wherestr']);
	$orderctrl = $_POST['orderctrl'];
	$sortstr = " order by ".$fldSort." ".$orderctrl;
	}
		
	if($orderctrl ==''){
	$orderctrl = "desc";
	}else{
	
		if($orderctrl =='asc'){
		$orderctrl = "desc";
		}else{
		$orderctrl = "asc";
		}		
	
	}
	
	//end of sort
	
	
	$o->customerctrl=$o->getSelectCustomer(-1);
	$o->termsctrl=$t->getSelectTerms(-1);
	
	$log->showLog(4,"Filterstring:$o->customer_id,$o->customer_no,$o->customer_name,$o->isactive");
	$o->showSearchForm("$wherestr","$orderctrl");
	
	$o->showSearchTable("$wherestr","$sortstr",0,9999,"$orderctrl","$fldSort");
	
	//$o->showSearchTable($wherestring,"ORDER BY c.customer_name",0,9999);
	
  break;
  default :
//	$token=$s->createToken(120,"CREATE_CUST");
//	$o->getInputForm("new",0,$token);
//	$o->currencyctrl=$cr->getSelectCurrency(0);
	if ($filterstring=="")
		$filterstring="A";
	$o->showCustomerTable("WHERE c.customer_name LIKE '$filterstring%' and c.isactive=1","order by c.customer_name",0,99999);
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


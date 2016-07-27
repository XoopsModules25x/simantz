<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Customer.php';
//include_once 'class/Invoice.php';
include_once 'class/Statement.php';
include_once "menu.php";
require "datepicker/class.datepicker.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$c = new Customer($xoopsDB,$tableprefix,$log);
//$i = new Invoice($xoopsDB,$tableprefix,$log);
$o = new Statement($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);


$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">

	function searchForms(){
	var start=document.forms['frmActionSearch'].start_date.value;
	var end=document.forms['frmActionSearch'].end_date.value;
	
	if(start =="" || end==""){
			alert('Please make sure start date and end date is filled in.');
			return dalse
		}
		else
			document.forms['frmActionSearch'].submit();
			return true;
	
	}

	function onOpen(){
	document.forms['frmStatement'].terms_code.focus();
	}

	function validateStatement2(){
		var code=document.forms['frmStatement'].terms_code.value;
		var desc=document.forms['frmStatement'].terms_desc.value;
		
		if(code =="" || desc==""){
			alert('Please make sure terms code and terms description is filled in.');
			return false;
		}
		else
			return true;
	}
	
	function IsNumeric(sText){
	
   var ValidChars = "0123456789.";
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
      
      
      if(sText=="")
	IsNumber = false;


   return IsNumber;
   
   }



	

	function validateStatement(){
 	
 	if(confirm('Confirm change this data?')==false){
  	return false;
  	}else{
  	
  	var code=document.forms['frmStatement'].terms_code.value;
		var desc=document.forms['frmStatement'].terms_desc.value;
		
		if(code =="" || desc==""){
			alert('Please make sure terms code and terms description is filled in.');
			return false;
		}
	
		
  	var i=0;
  	while(i< document.forms['frmStatement'].elements.length){
		var ctlname = document.forms['frmStatement'].elements[i].name; 
		var data = document.forms['frmStatement'].elements[i].value;

		if(ctlname=="terms_days"){
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmStatement'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmStatement'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmStatement'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
		}	
		 	i++;
	 	
 	}		
 	 
		return true;
	}
	
	}
	
	

	function headerSort(sortFldValue){

		document.frmActionSearch.fldSort.value = sortFldValue;

		//document.frmActionSearch.btnSubmit.click();
		document.frmActionSearch.submit();

	}
	
	function clickInvoiceNo(line){
	document.forms["frmInvoiceNo"+line].submit();
	}
</script>

EOF;

$o->terms_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->terms_id=$_POST["terms_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->terms_id=$_GET["terms_id"];

}
else
$action="";

$token=$_POST['token'];

//================

$o->customer_id=$_POST["customer_id"];
$o->invoice_id=$_POST["invoice_id"];
$o->start_date=$_POST["start_date"];
$o->end_date=$_POST["end_date"];

$o->terms_days=$_POST["terms_days"];
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
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Statement</span></big></big></big></div><br>
EOF;
//$filterstring=$o->searchAToZ();

if($_GET['filterstring'] != "")
	$filterstring=$_GET['filterstring'];
 switch ($action){

	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with terms name=$o->terms_desc");

	if ($s->check(false,$token,"CREATE_CAT")){
		
	if($o->insertStatement()){
		 $latest_id=$o->getLatestStatementID();
			 redirect_header("terms.php?action=edit&terms_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create terms!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_CAT");
		$o->getInputForm("new",-1,$token);
		$o->showStatementTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :

	if($o->fetchStatement($o->terms_id)){
		//create a new token for editing a form
		$token=$s->createToken(120,"CREATE_CAT");
		$o->termsctrl=$o->getSelectStatement(-1);
		$o->getInputForm("edit",$o->terms_id,$token);
		
//		$wc->showStatementEmploymentTable("WHERE wc.terms_id=$o->terms_id","order by wc.terms_desc ",0,99999); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("terms.php",3,"Some error on viewing your terms data, probably database corrupted");
  
break;

//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_CAT")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateStatement()) //if data save successfully
			redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Your data is saved.");
		else
			redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_CAT")){
		if($o->deleteStatement($o->terms_id))
			redirect_header("terms.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "new" :
	$token=$s->createToken(120,"CREATE_CAT");
	$o->termsctrl=$o->getSelectStatement(-1);
	$o->getInputForm("new",0,$token);
	
	//$o->showStatementTable("WHERE c.isactive=1","order by c.terms_desc",0,99999);
  break;
  
  
  case "showSearchForm":
	$o->termsctrl=$o->getSelectStatement(-1);
	//$o->termsctrl=$o->getSelectStatement(-1);

	$o->showSearchForm();
  break;
  
  case "search":
  
  $sortstr = "ORDER BY c.terms_desc";
  $wherestr=$o->convertSearchString($o->terms_id,$o->terms_code,$o->terms_desc,$o->isactive);
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
	
	if($o->customer_id=="")
		$o->customer_id = -1;
	if($o->invoice_id=="")
		$o->invoice_id = -1;
		
	$o->showcalendar1 = $dp->show("start_date");
	$o->showcalendar2 = $dp->show("end_date");
	
	$o->customerctrl=$c->getSelectCustomerStatement($o->customer_id);
	//$o->invoicectrl=$i->getSelectInvoiceStatement($o->invoice_id);
	
	$log->showLog(4,"Filterstring:$o->terms_id,$o->terms_code,$o->terms_desc,$o->isactive");
	$o->showSearchForm("$wherestr","$orderctrl");
	
	//$o->showSearchTable("$wherestr","$sortstr",0,9999,"$orderctrl","$fldSort");
	
	$o->showSearchTable("$o->customer_id","$o->invoice_id","$o->start_date","$o->end_date");
	

	
  break;
  default :
  
	/*
	if ($filterstring=="")
		$filterstring="A";
	$o->showStatementTable("WHERE c.terms_desc LIKE '$filterstring%' and c.isactive=1","order by c.terms_desc",0,99999);
	*/
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


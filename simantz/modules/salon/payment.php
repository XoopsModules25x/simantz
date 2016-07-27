<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Payment.php';
include_once 'class/Customer.php';
include_once 'class/Product.php';
include_once 'class/Employee.php';
include_once 'class/Expensescategory.php';
require ("datepicker/class.datepicker.php");


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Sales($xoopsDB,$tableprefix,$log);
$c = new Expensescategory($xoopsDB,$tableprefix,$log);
$t = new Customer($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$p = new Product($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);

$o->orgctrl="";
$o->categoryctrl="";

$url=XOOPS_URL;

$action="";

//marhan add here --> ajax
echo "<iframe src='payment.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
/////////////////////

/*
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Sales List</span></big></big></big></div><br>*/

echo "<body>";

echo <<< EOF



<script type="text/javascript">

	function calculateChange(thisone){
	
	var total_amount = document.forms['frmPayment'].sales_totalamount.value;
	var total_paid = document.forms['frmPayment'].sales_paidamount.value;

	var total_change = parseFloat(total_paid) - parseFloat(total_amount);
	
	document.forms['frmPayment'].sales_change.value = total_change;

	parseelement(document.forms['frmPayment'].sales_change);

	parseelement(thisone);
	}
	function mainPage(){
	url='$url/modules/salon/index.php?payment=1';

	if(confirm("Back to main page?"))
	//document.getElementById('aMain').href="index.php?payment=1" ;
	document.getElementById('aMain').href=url ;
	}
	
	function saveSales(sales_id){
	if(confirm("Save Record?")){
	total_paid = document.forms['frmPayment'].sales_paidamount.value;

		if(!IsNumeric(total_paid)){
		alert("Paid Amount not numeric");
		document.forms['frmPayment'].sales_paidamount.style.backgroundColor = "#FF0000";
		}else{
		document.forms['frmPayment'].sales_id.value = sales_id;
		document.forms['frmPayment'].action.value = "save";
		document.forms['frmPayment'].submit();
		}
	}
	}

	function completeSales(sales_id) {//example of ajax
		
	if(confirm("Complete Record?")){
	total_paid = document.forms['frmPayment'].sales_paidamount.value;
		if(!IsNumeric(total_paid)){
		alert("Paid Amount not numeric");
		document.forms['frmPayment'].sales_paidamount.style.backgroundColor = "#FF0000";
		}else{
		var arr_fld=new Array("action","sales_id");//name for POST
		var arr_val=new Array("completecheck",sales_id);//value for POST
		
		getRequest(arr_fld,arr_val);
		}
	}
		
	}
	
	function completeSalesFinal(sales_id,check){

	if(check > 0){
		if(confirm("Stylist Not Select For Commission (Red Color). Continue?")){
		document.forms['frmPayment'].sales_id.value = sales_id;
		document.forms['frmPayment'].action.value = "complete";
		document.forms['frmPayment'].submit();
		//PopupCenter("receipt.php?sales_id="+sales_id, "Receipt",600,850);
		}
	}else{
	
		document.forms['frmPayment'].sales_id.value = sales_id;
		document.forms['frmPayment'].action.value = "complete";
		document.forms['frmPayment'].submit();
		//PopupCenter("receipt.php?sales_id="+sales_id, "Receipt",600,850);
	}
	
	}
	
	function completeSales2(sales_id){

	if(confirm("Complete Record?")){
	total_paid = document.forms['frmPayment'].sales_paidamount.value;

		if(!IsNumeric(total_paid)){
		alert("Paid Amount not numeric");
		document.forms['frmPayment'].sales_paidamount.style.backgroundColor = "#FF0000";
		}else{
		document.forms['frmPayment'].sales_id.value = sales_id;
		document.forms['frmPayment'].action.value = "complete";
		document.forms['frmPayment'].submit();
		PopupCenter("receipt.php?sales_id="+sales_id, "Receipt",600,850);
		}
	}

	}

	function deleteSales(sales_id){
	if(confirm("Delete Record?")){
	document.forms['frmPayment'].sales_id.value = sales_id;
	document.forms['frmPayment'].action.value = "delete";
	document.forms['frmPayment'].submit();
	}

	}

	function showlist(customer_id){
	addList(customer_id);
	}

	function getListCustomer(sales_id){
	document.forms['frmPayment'].sales_id.value = sales_id;
	document.forms['frmPayment'].action.value = "getlist";
	document.forms['frmPayment'].submit();
	
	}
	
	function addList(customer_id){
	document.getElementById('searchFormID').style.display = "none";
	document.forms['frmPayment'].action.value = "addlist";
	document.forms['frmPayment'].customer_id.value = customer_id;
	document.forms['frmPayment'].submit();
	}

	function searchRecord(){
	document.forms['frmPayment'].action.value = "search";
	document.forms['frmPayment'].submit();
	}

	function showSearchForm(){
	document.getElementById('searchFormID').style.display = "";
	}

	function getPromotion(type){

	}

	function calculateTotal(doc){//calculate total amount
	
	var amount=0;
	var i=0;
	while(i< doc.forms['frmSales'].elements.length){
		var ctl = doc.forms['frmSales'].elements[i].name; 
	
		
		ctlname = ctl.substring(0,ctl.indexOf("["))
		
		if(ctlname=="salesline_qty"){


		var qty = doc.forms['frmSales'].elements[i].value;
		var price = doc.forms['frmSales'].elements[i+1].value;
		
		doc.forms['frmSales'].elements[i+2].value = qty*price;
		parseelement(doc.forms['frmSales'].elements[i+2]);

		amount += qty*price;
		
		}
		
		i++;	
	}

	doc.forms['frmSales'].sales_totalamount.value = amount;
	parseelement(doc.forms['frmSales'].sales_totalamount);//set value at header (total amount)
	
	}


	function updatePrice(line,price){//update field price
		var fldName = "salesline_price["+line+"]";
		self.parent.document.getElementsByName(fldName)[0].value = price;
		calculateTotal(self.parent.document);
	}

	function getPrice(line,id) {//example of ajax
		
		var arr_fld=new Array("action","line","id");//name for POST
		var arr_val=new Array("updateprice",line,id);//value for POST
		
		getRequest(arr_fld,arr_val);
		
	}

	function searchSales(){//searching
		document.forms['frmSearch'].action.value = "search";
		document.forms['frmSearch'].fldShow.value = "Y";
		document.forms['frmSearch'].submit();
	}
	
	function showSearch(){//show search form
		document.forms['frmSales'].action.value = "search";
		document.forms['frmSales'].submit();
	}


	function deleteLine(line){//delete line payment
		
	if(confirm("Delete Record?")){
		if(validateData()){
		document.forms['frmSales'].action.value = "deleteline";
		document.forms['frmSales'].line.value = line;
		document.forms['frmSales'].submit();
		}
	}

	}

	function addPayment(){//add line payment
	var payment=document.forms['frmSales'].fldPayment.value;
	var code=document.forms['frmSales'].sales_no.value;
	

	if(confirm("Add Record?")){
		if(payment=="" || !IsNumeric(payment)){
		alert('Invalid Data. Please Key In Again..');
		}else{
			if(validateData()){
			document.forms['frmSales'].action.value = "addline";
			document.forms['frmSales'].submit();
			}
		}
	}
	
	}

	function validateSales(){
		
		if(confirm("Save Record?")){
			return validateData();	
		}else
			return false;
		
	}

	function validateData(){
	var code=document.forms['frmSales'].sales_no.value;
	var customer=document.forms['frmSales'].customer_id.value;
	
	if(code==""||customer==0){
	alert('Please make sure Sales no and Customer is filled in');
	return false;
	}
	
	var i=0;
	while(i< document.forms['frmSales'].elements.length){
		var ctlname = document.forms['frmSales'].elements[i].name; 
		var data = document.forms['frmSales'].elements[i].value;
	
		
		ctlname = ctlname.substring(0,ctlname.indexOf("["))
		
		if(ctlname=="salesline_no" || ctlname=="salesline_qty" || ctlname=="salesline_price" || ctlname=="salesline_amount"){
		
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmSales'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmSales'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmSales'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
		}
		
		i++;
		
	}
	
	return true;
	}


</script>

EOF;

$o->category_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->sales_id=$_POST["sales_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->sales_id=$_GET["sales_id"];

}
else
$action="";
$token=$_POST['token'];

$o->sales_no=$_POST["sales_no"];
$o->sales_date=$_POST["sales_date"];
$o->sales_totalamount=$_POST["sales_totalamount"];
$o->sales_paidamount=$_POST["sales_paidamount"];
$o->customer_id=$_POST["customer_id"];
$iscomplete=$_POST["iscomplete"];
$o->sales_remarks=$_POST["sales_remarks"];

$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	

$o->isAdmin=$xoopsUser->isAdmin();
$isactive=$_POST['isactive'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

$o->datectrl=$dp->show("sales_date");

//line

$o->salesline_id=$_POST["salesline_id"];
$o->salesline_no=$_POST["salesline_no"];
$o->employee_id=$_POST["employee_id"];
$o->product_id=$_POST["product_id"];
$o->salesline_remarks=$_POST["salesline_remarks"];
$o->salesline_qty=$_POST["salesline_qty"];
$o->salesline_price=$_POST["salesline_price"];
$o->salesline_amount=$_POST["salesline_amount"];


//showTable
$o->fldShow = $_POST["fldShow"];
$o->fldName = $_POST["fldName"];
$o->fldIc = $_POST["fldIc"];
$o->windows_id = $_POST["windows_id"];


//search date
$o->start_date=$_POST["start_date"];
$o->end_date=$_POST["end_date"];
$o->startctrl=$dp->show("start_date");
$o->endctrl=$dp->show("end_date");


if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
elseif($isactive=="X")
	$o->isactive='X';
else
	$o->isactive='N';

if ($iscomplete=="Y" or $iscomplete=="on")
	$o->iscomplete='Y';
elseif($iscomplete=="X")
	$o->$iscomplete='X';
else
	$o->iscomplete='N';


// main function
 switch ($action){
  case "getlist" :
	
	$o->customer_id = $o->getSalesInfo("a.customer_id");
	$o->customerctrl = $t->getSelectCustomer(0,"","showlist(this.value)","cust_id");
	$o->getCustomerForm($action);
	
  break;
  
  case "addlist" :
	
	if($o->windows_id==0)
	$o->windows_id = date("Ymd", time()).$o->updatedby;

	if($o->insertSales()){
		
		$o->sales_id = $o->getLatestSalesID();
		if($o->insertWindowsLine()){
		$o->customerctrl = $t->getSelectCustomer(0,"","showlist(this.value)","cust_id");
		$o->getCustomerForm($action);
		}else{
		}
	}else{
	}
	
  break;

  case "search" :
	$o->customerctrl = $t->getSelectCustomer(0,"","showlist(this.value)","cust_id");
	$o->getCustomerForm($action);
  break;

  case "delete" :

	if($o->deleteSales()){
	$o->customerctrl = $t->getSelectCustomer(0,"","showlist(this.value)","cust_id");
	$o->sales_id = "";
	$o->getCustomerForm($action);
	}else{
	}

	
  break;

  case "complete" :
	if($o->updateSales()){
		if($o->completeSales()){

echo <<< EOF
<script type='text/javascript'>
PopupCenter("receipt.php?sales_id=$o->sales_id", "Receipt2",850,650);
</script>
EOF;

		$o->customerctrl = $t->getSelectCustomer(0,"","showlist(this.value)","cust_id");
		$o->sales_id = "";
		$o->getCustomerForm($action);

		}else{
		}
	}else{
	}

	
  break;

 case "save" :
	
	if($o->updateSales()){
	$o->customerctrl = $t->getSelectCustomer(0,"","showlist(this.value)","cust_id");
	$o->getCustomerForm($action);
	//redirect_header("payment.php?sales_id=$o->sales_id",$pausetime,"Your data is saved");
	}else{
	}

	
  break;

   case "edit" :
	if($o->windows_id==0)
	$o->windows_id = date("Ymd", time()).$o->updatedby;

	if($o->fetchSalesInfo($o->sales_id)){
		if($o->insertWindowsLine()){
		$o->customerctrl = $t->getSelectCustomer(0,"","showlist(this.value)","cust_id");
		$o->getCustomerForm("new");
		}
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("payment.php",3,"Some error on viewing your product data, probably database corrupted");
  
break;

   case "enable" :
	if($o->windows_id==0)
	$o->windows_id = date("Ymd", time()).$o->updatedby;

	if($o->fetchSalesInfo($o->sales_id)){
	if($o->enableSales()) {
		if($o->insertWindowsLine()){
		$o->customerctrl = $t->getSelectCustomer(0,"","showlist(this.value)","cust_id");
		$o->getCustomerForm("new");
		//redirect_header("payment.php?action=edit&sales_id=$o->sales_id",$pausetime,"Your data is enabled.");
		}
	}else{

	}	
	}else
		redirect_header("payment.php",3,"Some error on viewing your product data, probably database corrupted");
  
  break;
  
  case "completecheck" :
  
  $sales_id = $_POST['sales_id'];
  $checkemployee = $o->checkEmployeeLine($sales_id);

 // echo "<script type='text/javascript'>alert('$checkemployee');</script>";  
  
//  if($checkemployee == 0)
  echo "<script type='text/javascript'>self.parent.completeSalesFinal('$sales_id','$checkemployee');</script>";
  
  
  break;
  

  default :
	$token=$s->createToken($tokenlife,"CREATE_VEN");
	$o->customerctrl = $t->getSelectCustomer(0,"","showlist(this.value)","cust_id");
	$o->getCustomerForm("new");

  break;

}
echo "</body>";
//require(XOOPS_ROOT_PATH.'/clear.php');
echo "<title>SimSalon - Payment</title>";
echo '<link rel="stylesheet" type="text/css" media="all" href="'.XOOPS_URL.'/xoops.css" />';
echo '<link rel="stylesheet" type="text/css" media="all" href="'.XOOPS_URL.'/themes/default/style.css" />';

?>

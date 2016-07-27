<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Expenses.php';
include_once 'class/Expenseslist.php';
include_once 'class/Vendor.php';
include_once 'class/Terms.php';
include_once 'class/Product.php';
include_once 'class/Employee.php';
include_once 'class/Expensescategory.php';
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Expenses($xoopsDB,$tableprefix,$log);
$c = new Expensescategory($xoopsDB,$tableprefix,$log);
$t = new Vendor($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$x = new Expenseslist($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);
$m = new Terms($xoopsDB,$tableprefix,$log);

$o->orgctrl="";
$o->categoryctrl="";

$o->cur_symbol = $cur_symbol;
$action="";

//marhan add here --> ajax
echo "<iframe src='expenses.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
/////////////////////

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Expenses Transaction</span></big></big></big></div><br>

<script type="text/javascript">

	function autofocus(){
	document.forms['frmExpenses'].expenses_no.focus();
	}

	function completeExpenses(complete){
		if(complete==true){
		document.forms['frmExpenses'].btnSave.value = "Complete";
		}else{
		document.forms['frmExpenses'].btnSave.value = "Save";
		}
	}

	function calculateTotal(doc){//calculate total amount
	var qty = doc.forms['frmExpenses'].expenses_qty.value;
	var price = doc.forms['frmExpenses'].expenses_price.value;
	
	doc.forms['frmExpenses'].expenses_totalamount.value = qty*price;
	parseelement(doc.forms['frmExpenses'].expenses_totalamount);//set value at header (total amount)
	}
	
	function calculateTotal2(doc){//calculate total amount
	
	var amount=0;
	var lineamount=0;
	var i=0;
	while(i< doc.forms['frmExpenses'].elements.length){
		var ctl = doc.forms['frmExpenses'].elements[i].name; 
	
		
		ctlname = ctl.substring(0,ctl.indexOf("["))
		
		if(ctlname=="expensesline_qty"){


		var qty = doc.forms['frmExpenses'].elements[i].value;
		var price = doc.forms['frmExpenses'].elements[i+1].value;
		
		lineamount = doc.forms['frmExpenses'].elements[i+2].value = qty*price;//set total amount
		parseelement(doc.forms['frmExpenses'].elements[i+2]);

		amount += lineamount;
		
		}
		
		i++;	
	}

	doc.forms['frmExpenses'].expenses_totalamount.value = amount;
	parseelement(doc.forms['frmExpenses'].expenses_totalamount);//set value at header (total amount)
	
	}


	function updatePrice(price,uom){//update field price
		
		var fldName = "expenses_price";
		self.parent.document.forms["frmExpenses"].expenses_price.value = price;
		self.parent.document.getElementById('uomID').innerHTML = uom;
		calculateTotal(self.parent.document);
	}

	function getPrice(id) {//example of ajax
		
		var arr_fld=new Array("action","id");//name for POST
		var arr_val=new Array("updateprice",id);//value for POST
		
		getRequest(arr_fld,arr_val);
		
	}

	function searchExpenses(){//searching
		document.forms['frmSearch'].action.value = "search";
		document.forms['frmSearch'].fldShow.value = "Y";
		document.forms['frmSearch'].submit();
	}
	
	function showSearch(){//show search form
		document.forms['frmExpenses'].action.value = "search";
		document.forms['frmExpenses'].submit();
	}


	function deleteLine(line){//delete line payment
		
	if(confirm("Delete Record?")){
		if(validateData()){
		document.forms['frmExpenses'].action.value = "deleteline";
		document.forms['frmExpenses'].line.value = line;
		document.forms['frmExpenses'].submit();
		}
	}

	}

	function addPayment(){//add line payment
	var payment=document.forms['frmExpenses'].fldPayment.value;
	var code=document.forms['frmExpenses'].expenses_no.value;
	

	if(confirm("Add Record?")){
		if(payment=="" || !IsNumeric(payment)){
		alert('Invalid Data. Please Key In Again..');
		}else{
			if(validateData()){
			document.forms['frmExpenses'].action.value = "addline";
			document.forms['frmExpenses'].submit();
			}
		}
	}
	
	}

	function validateExpenses(){
		
		if(confirm("Save Record?")){
			return validateData();	
		}else
			return false;
		
	}

	function validateData(){
	var code=document.forms['frmExpenses'].expenses_no.value;
	var expenseslist=document.forms['frmExpenses'].expenseslist_id.value;

	
	if(code=="" || expenseslist == 0){
	alert('Please make sure Expenses no is filled in');
	return false;
	}

	if(expenseslist == 0){
	alert('Please make sure select expenses');
	return false;
	}
	
	var i=0;
	while(i< document.forms['frmExpenses'].elements.length){
		var ctlname = document.forms['frmExpenses'].elements[i].name; 
		var data = document.forms['frmExpenses'].elements[i].value;
	
		
		//ctlname = ctlname.substring(0,ctlname.indexOf("["))
		
		if(ctlname=="expenses_qty" || ctlname=="expenses_price" ){
		
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmExpenses'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmExpenses'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmExpenses'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
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
	$o->expenses_id=$_POST["expenses_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->expenses_id=$_GET["expenses_id"];

}
else
$action="";
$token=$_POST['token'];

$o->expenses_no=$_POST["expenses_no"];
$o->expenses_date=$_POST["expenses_date"];
$o->expenses_totalamount=$_POST["expenses_totalamount"];
$o->expenses_qty=$_POST["expenses_qty"];
$o->expenses_price=$_POST["expenses_price"];
$iscomplete=$_POST["iscomplete"];
$o->expenses_remarks=$_POST["expenses_remarks"];


$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	

$o->isAdmin=$xoopsUser->isAdmin();
$isactive=$_POST['isactive'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->receivebyname=$xoopsUser->getVar('uname');

$o->datectrl=$dp->show("expenses_date");

//line

$o->expensesline_id=$_POST["expensesline_id"];
$o->expensesline_no=$_POST["expensesline_no"];
$o->expenseslist_id=$_POST["expenseslist_id"];
$o->expensesline_remarks=$_POST["expensesline_remarks"];
$o->expensesline_qty=$_POST["expensesline_qty"];
$o->expensesline_price=$_POST["expensesline_price"];
$o->expensesline_amount=$_POST["expensesline_amount"];

//showTable
$o->fldShow = $_POST["fldShow"];

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
	$o->iscomplete='X';
else
	$o->iscomplete='N';



 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired


	if ($s->check(false,$token,"CREATE_VEN")){
		$log->showLog(4,"Accessing create record event, with product name=$o->expenses_name");
		if($o->insertExpenses()){
			$latest_id=$o->getLatestExpensesID();
//			if($filesize>0 || $filetype=='application/pdf')
	//		$o->savefile($tmpfile);
			redirect_header("expenses.php?action=edit&expenses_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create product!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_VEN");
//		$o->vendorctrl=$t->getSelectVendor($o->vendor_id);
	//	$o->termsctrl=$m->getSelectTerms($o->terms_id);
		$o->employeectrl=$e->getEmployeeList($o->employee_id,"","employee_id[]");
	//	$o->expensesctrl=$x->getSelectExpenseslist($o->expenseslist_id);
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);

		$o->getInputForm("new",-1,$token);
		//$o->showExpensesTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchExpensesInfo($o->expenses_id)){
		
//		$o->vendorctrl=$t->getSelectVendor($o->vendor_id);
	//	$o->termsctrl=$m->getSelectTerms($o->terms_id);		
		$o->employeectrl=$e->getEmployeeList($o->employee_id,"","employee_id[]");
	//	$o->expensesctrl=$x->getSelectExpenseslist($o->expenseslist_id);

		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_VEN"); 
		$o->getInputForm("edit",$o->expenses_id,$token);
		//$o->showExpensesTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("expenses.php",3,"Some error on viewing your product data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_VEN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid

		if($o->updateExpenses()) {
			if($o->iscomplete=="Y"){		
			$token=$s->createToken($tokenlife,"CREATE_VEN");	
			$o->employeectrl=$e->getEmployeeList(1,"","employee_id[]");
			$o->orgctrl=$e->selectionOrg($o->createdby,0);
			$o->getInputForm("new",0,$token);
			}else{
			redirect_header("expenses.php?action=edit&expenses_id=$o->expenses_id",$pausetime,"Your data is saved.");
			}
		}
		else
			redirect_header("expenses.php?action=edit&expenses_id=$o->expenses_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("expenses.php?action=edit&expenses_id=$o->expenses_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_VEN")){
		if($o->deleteExpenses($o->expenses_id)){
			redirect_header("expenses.php",$pausetime,"Data removed successfully.");
			$o->deletefile($o->expenses_id);
		}
		else
			redirect_header("expenses.php?action=edit&expenses_id=$o->expenses_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("expenses.php?action=edit&expenses_id=$o->expenses_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

  case "addline" :
	if ($s->check(false,$token,"CREATE_VEN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$fldpayment = $_POST['fldPayment'];
		
		if($o->updateExpenses()) {

			if($o->insertLine($fldpayment)) {
			redirect_header("expenses.php?action=edit&expenses_id=$o->expenses_id",$pausetime,"Your data is saved.");
			}else{
			redirect_header("expenses.php?action=edit&expenses_id=$o->expenses_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
			}
		}
		else
			redirect_header("expenses.php?action=edit&expenses_id=$o->expenses_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("expenses.php?action=edit&expenses_id=$o->expenses_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;

  case "deleteline" :
	if ($s->check(false,$token,"CREATE_VEN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$line = $_POST['line'];

		if($o->updateExpenses()) {

			if($o->deleteLine($line)) {
			redirect_header("expenses.php?action=edit&expenses_id=$o->expenses_id",$pausetime,"Your data is saved.");
			}else{
			redirect_header("expenses.php?action=edit&expenses_id=$o->expenses_id",$pausetime,"Warning! Can't delete the data!");
			}
		
		}
		else
			redirect_header("expenses.php?action=edit&expenses_id=$o->expenses_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("expenses.php?action=edit&expenses_id=$o->expenses_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;

  case "search" :
	$o->vendorctrl=$t->getSelectVendor(0);
	$o->termsctrl=$m->getSelectTerms(0);
	$o->employeectrl=$e->getEmployeeList(0,"","employee_id");

	$o->expensesctrl=$x->getSelectExpenseslist(0);
	//$o->orgctrl=$e->selectionOrg($o->createdby,0);
	//$o->getInputForm("new",0,$token);
	$o->showExpensesTable();

  break;

  case "updateprice" :

	$price = $o->getPriceExpenseslist($_POST['id'],"amt");
	$uom = $o->getPriceExpenseslist($_POST['id'],"uom_description");

	echo "<script type='text/javascript'>updatePrice('$price','$uom');</script>";
	//echo "<script type='text/javascript'>self.parent.document.getElementById('uomID').innerHTML = '$uom' ;</script>";

  break;

  default :
	$token=$s->createToken($tokenlife,"CREATE_VEN");	
	$o->employeectrl=$e->getEmployeeList(1,"","employee_id[]");

	//$o->expensesctrl=$x->getSelectExpenseslist(0);
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	//$o->showExpensesTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

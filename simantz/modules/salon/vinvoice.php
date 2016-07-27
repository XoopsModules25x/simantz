<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Vinvoice.php';
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
$o = new Vinvoice($xoopsDB,$tableprefix,$log);
$c = new Expensescategory($xoopsDB,$tableprefix,$log);
$t = new Vendor($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$p = new Product($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);
$m = new Terms($xoopsDB,$tableprefix,$log);

$o->orgctrl="";
$o->categoryctrl="";


$action="";

//marhan add here --> ajax
echo "<iframe src='vinvoice.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
/////////////////////

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Invoice List</span></big></big></big></div><br>

<script type="text/javascript">

	function checkAmount(line){
	document.getElementById("checkedID"+line).checked = true;
	//document.getElementById("customPrice"+i).checked = true; 	
	}

	function autofocus(){
	document.forms['frmVinvoice'].vinvoice_no.focus();
	}


	function completeVinvoice(complete){
		if(complete==true){
		document.forms['frmVinvoice'].btnSave.value = "Complete";
		}else{
		document.forms['frmVinvoice'].btnSave.value = "Save";
		}
	}
	
	function calculateTotalAmount(doc){//calculate total amount
	
	var amount=0;
	var lineamount=0;
	var i=0;
	while(i< doc.forms['frmVinvoice'].elements.length){
		var ctl = doc.forms['frmVinvoice'].elements[i].name; 
	
		
		ctlname = ctl.substring(0,ctl.indexOf("["))
		
		if(ctlname=="vinvoiceline_amount"){
		lineamount = parseFloat(doc.forms['frmVinvoice'].elements[i].value);

		amount += lineamount;
		
		}
		
		i++;	
	}
	
	doc.forms['frmVinvoice'].vinvoice_totalamount.value = amount;
	parseelement(doc.forms['frmVinvoice'].vinvoice_totalamount);//set value at header (total amount)
	
	}

	function calculateTotal(doc){//calculate total amount
	
	var amount=0;
	var lineamount=0;
	var i=0;
	while(i< doc.forms['frmVinvoice'].elements.length){
		var ctl = doc.forms['frmVinvoice'].elements[i].name; 
	
		
		ctlname = ctl.substring(0,ctl.indexOf("["))
		
		if(ctlname=="vinvoiceline_qty"){


		var qty = doc.forms['frmVinvoice'].elements[i].value;
		var price = doc.forms['frmVinvoice'].elements[i+1].value;
		var discount = doc.forms['frmVinvoice'].elements[i+2].value;
		
		if(doc.forms['frmVinvoice'].elements[i+3].value == 1){
			if(doc.forms['frmVinvoice'].elements[i+5].checked == false)
			lineamount = doc.forms['frmVinvoice'].elements[i+4].value = qty*price - (discount/100)*qty*price;
		}else{
			if(doc.forms['frmVinvoice'].elements[i+5].checked == false)
			lineamount = doc.forms['frmVinvoice'].elements[i+4].value = qty*price - discount;
		}

		if(doc.forms['frmVinvoice'].elements[i+5].checked == false){
		doc.forms['frmVinvoice'].elements[i+4].value = lineamount;//set total amount
		parseelement(doc.forms['frmVinvoice'].elements[i+4]);
		}else{
		lineamount = parseFloat(doc.forms['frmVinvoice'].elements[i+4].value);
		}

		amount += lineamount;
		
		}
		
		i++;	
	}

	
	doc.forms['frmVinvoice'].vinvoice_totalamount.value = amount;
	parseelement(doc.forms['frmVinvoice'].vinvoice_totalamount);//set value at header (total amount)
	
	}


	function updatePrice(line,price){//update field price
		var fldName = "vinvoiceline_price["+line+"]";
		self.parent.document.getElementsByName(fldName)[0].value = price;
		calculateTotal(self.parent.document);
	}
	
	function getTerms(vendor_id) {//example of ajax
		//alert(vendor_id);
		var arr_fld=new Array("action","vendor_id");//name for POST
		var arr_val=new Array("getterms",vendor_id);//value for POST
		
		getRequest(arr_fld,arr_val);
		
	}


	function getPrice(line,id) {//example of ajax
		
		var arr_fld=new Array("action","line","id");//name for POST
		var arr_val=new Array("updateprice",line,id);//value for POST
		
		getRequest(arr_fld,arr_val);
		
	}

	function searchVinvoice(){//searching
		document.forms['frmSearch'].action.value = "search";
		document.forms['frmSearch'].fldShow.value = "Y";
		document.forms['frmSearch'].submit();
	}
	
	function showSearch(){//show search form
		document.forms['frmVinvoice'].action.value = "search";
		document.forms['frmVinvoice'].submit();
	}


	function deleteLine(line){//delete line payment
		
	if(confirm("Delete Record?")){
		if(validateData()){
		document.forms['frmVinvoice'].action.value = "deleteline";
		document.forms['frmVinvoice'].line.value = line;
		document.forms['frmVinvoice'].submit();
		}
	}

	}

	function addPayment(){//add line payment
	var payment=document.forms['frmVinvoice'].fldPayment.value;
	var code=document.forms['frmVinvoice'].vinvoice_no.value;
	

	if(confirm("Add Record?")){
		if(payment=="" || !IsNumeric(payment)){
		alert('Invalid Data. Please Key In Again..');
		}else{
			if(validateData()){
			document.forms['frmVinvoice'].action.value = "addline";
			document.forms['frmVinvoice'].submit();
			}
		}
	}
	
	}

	function validateVinvoice(){
		
		if(confirm("Save Record?")){
			return validateData();	
		}else
			return false;
		
	}

	function validateData(){
	var code=document.forms['frmVinvoice'].vinvoice_no.value;
	var vendor=document.forms['frmVinvoice'].vendor_id.value;

	action = document.forms['frmVinvoice'].action.value;
	
	if(code==""||vendor==0){
	alert('Please make sure Vinvoice no and Vendor is filled in');
	return false;
	}
	
	var i=0;
	while(i< document.forms['frmVinvoice'].elements.length){
		var ctlname = document.forms['frmVinvoice'].elements[i].name; 
		var data = document.forms['frmVinvoice'].elements[i].value;
		
		ctlname2 = ctlname;

		
		ctlname = ctlname.substring(0,ctlname.indexOf("["))
		
		if(( ctlname2 == "fldPayment" && data != "") || ctlname=="vinvoiceline_no" || ctlname=="vinvoiceline_qty" || ctlname=="vinvoiceline_price" || ctlname=="vinvoiceline_amount"){
		
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmVinvoice'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmVinvoice'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmVinvoice'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
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
	$o->vinvoice_id=$_POST["vinvoice_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->vinvoice_id=$_GET["vinvoice_id"];

}
else
$action="";
$token=$_POST['token'];

$o->vinvoice_no=$_POST["vinvoice_no"];
$o->vinvoice_date=$_POST["vinvoice_date"];
$o->vinvoice_totalamount=$_POST["vinvoice_totalamount"];
$o->vendor_id=$_POST["vendor_id"];
$o->terms_id=$_POST["terms_id"];
$iscomplete=$_POST["iscomplete"];
$o->vinvoice_remarks=$_POST["vinvoice_remarks"];
$o->vinvoice_receiveby=$_POST["vinvoice_receiveby"];

$o->fldPayment=$_POST["fldPayment"];


$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	

$o->isAdmin=$xoopsUser->isAdmin();
$isactive=$_POST['isactive'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->receivebyname=$xoopsUser->getVar('uname');

$o->datectrl=$dp->show("vinvoice_date");

//line

$o->vinvoiceline_id=$_POST["vinvoiceline_id"];
$o->vinvoiceline_no=$_POST["vinvoiceline_no"];
$o->vinvoiceline_discount=$_POST["vinvoiceline_discount"];
$o->product_id=$_POST["product_id"];
$o->vinvoiceline_remarks=$_POST["vinvoiceline_remarks"];
$o->vinvoiceline_qty=$_POST["vinvoiceline_qty"];
$o->vinvoiceline_price=$_POST["vinvoiceline_price"];
$o->vinvoiceline_amount=$_POST["vinvoiceline_amount"];
$o->vinvoiceline_checkamount=$_POST["vinvoiceline_checkamount"];
$o->vinvoiceline_discounttype=$_POST["vinvoiceline_discounttype"];

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
		$log->showLog(4,"Accessing create record event, with product name=$o->vinvoice_name");
		if($o->insertVinvoice()){
			$latest_id=$o->getLatestVinvoiceID();
//			if($filesize>0 || $filetype=='application/pdf')
	//		$o->savefile($tmpfile);
			redirect_header("vinvoice.php?action=edit&vinvoice_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create product!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_VEN");
		$o->vendorctrl=$t->getSelectVendor($o->vendor_id,"","onchange='getTerms(this.value)'");
		$o->termsctrl=$m->getSelectTerms($o->terms_id);
		$o->employeectrl=$e->getEmployeeList($o->employee_id,"","employee_id[]");
		//$o->productctrl=$p->getSelectProduct($o->product_id);
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);

		$o->getInputForm("new",-1,$token);
		//$o->showVinvoiceTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchVinvoiceInfo($o->vinvoice_id)){
		
		$o->vendorctrl=$t->getSelectVendor($o->vendor_id,"","onchange='getTerms(this.value)'");
		$o->termsctrl=$m->getSelectTerms($o->terms_id);		
		$o->employeectrl=$e->getEmployeeList($o->employee_id,"","employee_id[]");
		//$o->productctrl=$p->getSelectProduct($o->product_id);

		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_VEN"); 
		$o->getInputForm("edit",$o->vinvoice_id,$token);
		//$o->showVinvoiceTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("vinvoice.php",3,"Some error on viewing your product data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_VEN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid

		if($o->updateVinvoice()) {
			if($o->iscomplete=="Y"){
			$token=$s->createToken($tokenlife,"CREATE_VEN");
			$o->vendorctrl=$t->getSelectVendor(0,"","onchange='getTerms(this.value)'");
			$o->termsctrl=$m->getSelectTerms(0);	
			$o->employeectrl=$e->getEmployeeList(1,"","employee_id[]");
		
			$o->productctrl=$p->getSelectProduct(1);
			$o->orgctrl=$e->selectionOrg($o->createdby,0);
			$o->getInputForm("new",0,$token);
			}else{
			redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Your data is saved.");
			}
		}
		else
			redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_VEN")){
		if($o->deleteVinvoice($o->vinvoice_id)){
			redirect_header("vinvoice.php",$pausetime,"Data removed successfully.");
			$o->deletefile($o->vinvoice_id);
		}
		else
			redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

  case "addline" :
	if ($s->check(false,$token,"CREATE_VEN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$fldpayment = $_POST['fldPayment'];
		
		if($o->updateVinvoice()) {

			if($o->insertLine($fldpayment)) {
			redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Your data is saved.");
			}else{
			redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
			}
		}
		else
			redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;

  case "deleteline" :
	if ($s->check(false,$token,"CREATE_VEN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$line = $_POST['line'];

		if($o->updateVinvoice()) {

			if($o->deleteLine($line)) {
			redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Your data is saved.");
			}else{
			redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Warning! Can't delete the data!");
			}
		
		}
		else
			redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;

  case "search" :
	$o->vendorctrl=$t->getSelectVendor(0);
	$o->termsctrl=$m->getSelectTerms(0);
	$o->employeectrl=$e->getEmployeeList(0,"","employee_id");

	$o->productctrl=$p->getSelectProduct(0);
	//$o->orgctrl=$e->selectionOrg($o->createdby,0);
	//$o->getInputForm("new",0,$token);
	$o->showVinvoiceTable();

  break;

  case "updateprice" :
	$line = $_POST['line'];
	$price = $o->getPriceProduct($_POST['id'],"lastpurchasecost");
	$uom = $o->getPriceProduct($_POST['id'],"uom_description");
	$idhtml = "idUom".$line;
	echo "<script type='text/javascript'>updatePrice('$line','$price');</script>";
	echo "<script type='text/javascript'>self.parent.document.getElementById('$idhtml').innerHTML = '$uom' ;</script>";

  break;

   case "enable" :
	
	if($o->enableInvoice()) {
	redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Your data is enabled.");
	}else{
	redirect_header("vinvoice.php?action=edit&vinvoice_id=$o->vinvoice_id",$pausetime,"Warning! Can't enable the data!");
	}	
	
  
  break;

  case "getterms" :
	$vendor_id = $_POST['vendor_id'];
	$terms_id = $o->getTerms($vendor_id);
	echo "<script type='text/javascript'>self.parent.document.forms['frmVinvoice'].terms_id.value = '$terms_id' ;</script>";
  break;

  default :
	$token=$s->createToken($tokenlife,"CREATE_VEN");
	$o->vendorctrl=$t->getSelectVendor(0,"","onchange='getTerms(this.value)'");
	$o->termsctrl=$m->getSelectTerms(0);	
	$o->employeectrl=$e->getEmployeeList(1,"","employee_id[]");

	$o->productctrl=$p->getSelectProduct(1);
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	//$o->showVinvoiceTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

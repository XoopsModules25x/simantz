<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Adjustment.php';
include_once 'class/Customer.php';
include_once 'class/Product.php';
include_once 'class/Employee.php';
include_once 'class/Expensescategory.php';
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Adjustment($xoopsDB,$tableprefix,$log);
$c = new Expensescategory($xoopsDB,$tableprefix,$log);
$t = new Customer($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$p = new Product($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);

$o->orgctrl="";
$o->categoryctrl="";


$action="";

//marhan add here --> ajax
echo "<iframe src='adjustment.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
/////////////////////

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Adjustment</span></big></big></big></div><br>

<script type="text/javascript">
	function autofocus(){
	document.forms['frmAdjustment'].internal_no.focus();
	}


	function completeAdjustment(complete){
		if(complete==true){
		document.forms['frmAdjustment'].btnSave.value = "Complete";
		}else{
		document.forms['frmAdjustment'].btnSave.value = "Save";
		}
	}
	
	function calculateTotal(doc){//calculate total amount
	
	var amount=0;
	var i=0;
	while(i< doc.forms['frmAdjustment'].elements.length){
		var ctl = doc.forms['frmAdjustment'].elements[i].name; 
	
		
		ctlname = ctl.substring(0,ctl.indexOf("["))
		
		if(ctlname=="internalline_qty"){


		var qty = doc.forms['frmAdjustment'].elements[i].value;
		var price = doc.forms['frmAdjustment'].elements[i+1].value;
		
		doc.forms['frmAdjustment'].elements[i+2].value = qty*price;
		parseelement(doc.forms['frmAdjustment'].elements[i+2]);

		amount += qty*price;
		
		}
		
		i++;	
	}

	doc.forms['frmAdjustment'].internal_totalamount.value = amount;
	parseelement(doc.forms['frmAdjustment'].internal_totalamount);//set value at header (total amount)
	
	}


	function updatePrice(line,price){//update field price
		var fldName = "internalline_price["+line+"]";
		self.parent.document.getElementsByName(fldName)[0].value = price;
		calculateTotal(self.parent.document);
	}

	function getPrice(line,id) {//example of ajax
		
		var arr_fld=new Array("action","line","id");//name for POST
		var arr_val=new Array("updateprice",line,id);//value for POST
		
		getRequest(arr_fld,arr_val);
		
	}

	function searchAdjustment(){//searching
		document.forms['frmSearch'].action.value = "search";
		document.forms['frmSearch'].fldShow.value = "Y";
		document.forms['frmSearch'].submit();
	}
	
	function showSearch(){//show search form
		document.forms['frmAdjustment'].action.value = "search";
		document.forms['frmAdjustment'].submit();
	}


	function deleteLine(line){//delete line payment
		
	if(confirm("Delete Record?")){
		if(validateData()){
		document.forms['frmAdjustment'].action.value = "deleteline";
		document.forms['frmAdjustment'].line.value = line;
		document.forms['frmAdjustment'].submit();
		}
	}

	}

	function addPayment(){//add line payment
	var payment=document.forms['frmAdjustment'].fldPayment.value;
	var code=document.forms['frmAdjustment'].internal_no.value;
	

	if(confirm("Add Record?")){
		if(payment=="" || !IsNumeric(payment)){
		alert('Invalid Data. Please Key In Again..');
		}else{
			if(validateData()){
			document.forms['frmAdjustment'].action.value = "addline";
			document.forms['frmAdjustment'].submit();
			}
		}
	}
	
	}

	function validateAdjustment(){
		
		if(confirm("Save Record?")){
			return validateData();	
		}else
			return false;
		
	}

	function validateData(){
	var code=document.forms['frmAdjustment'].internal_no.value;
	var employee=document.forms['frmAdjustment'].employee_id.value;
	
	if(code==""){
	alert('Please make sure Adjustment no and Employee is filled in');
	return false;
	}
	
	var i=0;
	while(i< document.forms['frmAdjustment'].elements.length){
		var ctlname = document.forms['frmAdjustment'].elements[i].name; 
		var data = document.forms['frmAdjustment'].elements[i].value;
	
		
		ctlname = ctlname.substring(0,ctlname.indexOf("["))
		
		if(ctlname=="internalline_no" || ctlname=="internalline_qty" || ctlname=="internalline_price" || ctlname=="internalline_amount"){
		
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmAdjustment'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmAdjustment'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmAdjustment'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
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
	$o->internal_id=$_POST["internal_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->internal_id=$_GET["internal_id"];

}
else
$action="";
$token=$_POST['token'];

$o->internal_no=$_POST["internal_no"];
$o->internal_date=$_POST["internal_date"];
$o->employee_id=$_POST["employee_id"];
$iscomplete=$_POST["iscomplete"];
$o->internal_remarks=$_POST["internal_remarks"];

$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	

$o->isAdmin=$xoopsUser->isAdmin();
$isactive=$_POST['isactive'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

$o->datectrl=$dp->show("internal_date");

//line

$o->internalline_id=$_POST["internalline_id"];
$o->internalline_no=$_POST["internalline_no"];
$o->product_id=$_POST["product_id"];
$o->internalline_remarks=$_POST["internalline_remarks"];
$o->internalline_qty=$_POST["internalline_qty"];
$o->employeeline_id=$_POST["employeeline_id"];

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
		$log->showLog(4,"Accessing create record event, with product name=$o->internal_name");
		if($o->insertAdjustment()){
			$latest_id=$o->getLatestAdjustmentID();
//			if($filesize>0 || $filetype=='application/pdf')
	//		$o->savefile($tmpfile);
			redirect_header("adjustment.php?action=edit&internal_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				redirect_header("adjustment.php",3,"Can't Create Data. Please Try Again.");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_VEN");
		//$o->customerctrl=$t->getSelectCustomer($o->customer_id);
		$o->employeectrl=$e->getEmployeeList($o->employee_id,"","employee_id");
		//$o->productctrl=$p->getSelectProduct($o->product_id);
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);

		$o->getInputForm("new",-1,$token);
		//$o->showAdjustmentTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchAdjustmentInfo($o->internal_id)){
		
		//$o->customerctrl=$t->getSelectCustomer($o->customer_id);
		$o->employeectrl=$e->getEmployeeList($o->employee_id,"","employee_id");
		//$o->productctrl=$p->getSelectProduct($o->product_id);

		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_VEN"); 
		$o->getInputForm("edit",$o->internal_id,$token);
		//$o->showAdjustmentTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("adjustment.php",3,"Some error on viewing your product data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_VEN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid

		if($o->updateAdjustment()) {
			if($o->iscomplete=="Y"){
			$token=$s->createToken($tokenlife,"CREATE_VEN");
			$o->employeectrl=$e->getEmployeeList(0,"","employee_id");
			$o->productctrl=$p->getSelectProduct(1);
			$o->orgctrl=$e->selectionOrg($o->createdby,0);
			$o->getInputForm("new",0,$token);
			}else{
			redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Your data is saved.");
			}
		}
		else
			redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_VEN")){
		if($o->deleteAdjustment($o->internal_id)){
			redirect_header("adjustment.php",$pausetime,"Data removed successfully.");
			$o->deletefile($o->internal_id);
		}
		else
			redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

  case "addline" :
	if ($s->check(false,$token,"CREATE_VEN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$fldpayment = $_POST['fldPayment'];
		
		if($o->updateAdjustment()) {

			if($o->insertLine($fldpayment)) {
			redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Your data is saved.");
			}else{
			redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
			}
		}
		else
			redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;

  case "deleteline" :
	if ($s->check(false,$token,"CREATE_VEN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$line = $_POST['line'];

		if($o->updateAdjustment()) {

			if($o->deleteLine($line)) {
			redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Your data is saved.");
			}else{
			redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Warning! Can't delete the data!");
			}
		
		}
		else
			redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;

  case "search" :
	//$o->customerctrl=$t->getSelectCustomer(0);
	$o->employeectrl=$e->getEmployeeList(0,"","employee_id");

	$o->productctrl=$p->getSelectProduct(0);
	//$o->orgctrl=$e->selectionOrg($o->createdby,0);
	//$o->getInputForm("new",0,$token);
	$o->showAdjustmentTable();

  break;

  case "updateprice" :
	$line = $_POST['line'];
	$price = $o->getPriceProduct($_POST['id']);
	$uom = $o->getPriceProduct($_POST['id'],"uom_description");
	$code = $o->getPriceProduct($_POST['id'],"product_no");

	$idhtml = "idUom".$line;
	$idhtml2 = "idCode".$line;
	//echo "<script type='text/javascript'>updatePrice('$line','$price');</script>";
	echo "<script type='text/javascript'>self.parent.document.getElementById('$idhtml').innerHTML = '$uom' ;</script>";
	echo "<script type='text/javascript'>self.parent.document.getElementById('$idhtml2').innerHTML = '$code' ;</script>";

  break;

  case "enable" :
	
	if($o->enableAdjustment()) {
	redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Your data is enabled.");
	}else{
	redirect_header("adjustment.php?action=edit&internal_id=$o->internal_id",$pausetime,"Warning! Can't enable the data!");
	}	
	
  
  break;

  default :
  	
	$token=$s->createToken($tokenlife,"CREATE_VEN");
	//$o->customerctrl=$t->getSelectCustomer(0);
	$o->employeectrl=$e->getEmployeeList(0,"","employee_id");

	$o->productctrl=$p->getSelectProduct(1);
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	//$o->showAdjustmentTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

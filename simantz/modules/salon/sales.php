<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Sales.php';
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

$o->limitauto = $limitauto;
$action="";

//marhan add here --> ajax
echo "<iframe src='sales.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
/////////////////////

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Sales History </span></big></big></big></div><br>

<script type="text/javascript">

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
		$log->showLog(4,"Accessing create record event, with product name=$o->sales_name");
		if($o->insertSales()){
			$latest_id=$o->getLatestSalesID();
//			if($filesize>0 || $filetype=='application/pdf')
	//		$o->savefile($tmpfile);
			redirect_header("sales.php?action=edit&sales_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create product!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_VEN");
		$o->customerctrl=$t->getSelectCustomer($o->customer_id,"","getPromotion(this.value);");
		$o->employeectrl=$e->getEmployeeList($o->employee_id,"","employee_id[]");
		//$o->productctrl=$p->getSelectProduct($o->product_id);
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);

		//$o->getInputForm("new",-1,$token);
		//$o->showSalesTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchSalesInfo($o->sales_id)){
		
		$o->customerctrl=$t->getSelectCustomer($o->customer_id,"","getPromotion(this.value);");
		$o->employeectrl=$e->getEmployeeList($o->employee_id,"","employee_id[]");
		//$o->productctrl=$p->getSelectProduct($o->product_id);

		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_VEN"); 
		//$o->getInputForm("edit",$o->sales_id,$token);
		//$o->showSalesTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("sales.php",3,"Some error on viewing your product data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_VEN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid

		if($o->updateSales()) {
		
		
			redirect_header("sales.php?action=edit&sales_id=$o->sales_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("sales.php?action=edit&sales_id=$o->sales_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("sales.php?action=edit&sales_id=$o->sales_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_VEN")){
		if($o->deleteSales($o->sales_id)){
			redirect_header("sales.php",$pausetime,"Data removed successfully.");
			$o->deletefile($o->sales_id);
		}
		else
			redirect_header("sales.php?action=edit&sales_id=$o->sales_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("sales.php?action=edit&sales_id=$o->sales_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

  case "addline" :
	if ($s->check(false,$token,"CREATE_VEN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$fldpayment = $_POST['fldPayment'];
		
		if($o->updateSales()) {

			if($o->insertLine($fldpayment)) {
			redirect_header("sales.php?action=edit&sales_id=$o->sales_id",$pausetime,"Your data is saved.");
			}else{
			redirect_header("sales.php?action=edit&sales_id=$o->sales_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
			}
		}
		else
			redirect_header("sales.php?action=edit&sales_id=$o->sales_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("sales.php?action=edit&sales_id=$o->sales_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;

  case "deleteline" :
	if ($s->check(false,$token,"CREATE_VEN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$line = $_POST['line'];

		if($o->updateSales()) {

			if($o->deleteLine($line)) {
			redirect_header("sales.php?action=edit&sales_id=$o->sales_id",$pausetime,"Your data is saved.");
			}else{
			redirect_header("sales.php?action=edit&sales_id=$o->sales_id",$pausetime,"Warning! Can't delete the data!");
			}
		
		}
		else
			redirect_header("sales.php?action=edit&sales_id=$o->sales_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("sales.php?action=edit&sales_id=$o->sales_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;

  case "search" :
	$o->customerctrl=$t->getSelectCustomer(0);
	$o->employeectrl=$e->getEmployeeList(0,"","employee_id");

	$o->productctrl=$p->getSelectProduct(0);
	//$o->orgctrl=$e->selectionOrg($o->createdby,0);
	//$o->getInputForm("new",0,$token);
	$o->showSalesTable();

  break;

  case "updateprice" :
	$line = $_POST['line'];
	$price = $o->getPriceProduct($_POST['id']);
	echo "<script type='text/javascript'>updatePrice('$line','$price');</script>";

  break;

  case "enable" :
	
	if($o->enableSales()) {
	redirect_header("sales.php?action=search",$pausetime,"Your data is enabled.");
	}else{
	redirect_header("sales.php?action=search",$pausetime,"Warning! Can't enable the data!");
	}	
	
  
  break;

  default :
	$token=$s->createToken($tokenlife,"CREATE_VEN");
	/*
	$o->customerctrl=$t->getSelectCustomer(0,"","getPromotion(this.value);");
	$o->employeectrl=$e->getEmployeeList(1,"","employee_id[]");

	$o->productctrl=$p->getSelectProduct(1);
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	*/
	$o->customerctrl=$t->getSelectCustomer(0);
	$o->employeectrl=$e->getEmployeeList(0,"","employee_id");

	$o->productctrl=$p->getSelectProduct(0);

	$o->showSalesTable();
	//$o->getInputForm("new",0,$token);
	//$o->showSalesTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

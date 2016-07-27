<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Invoice.php';
include_once 'class/Customer.php';
include_once 'class/Item.php';
include_once 'class/Terms.php';
include_once "menu.php";
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Invoice($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$c = new Customer($xoopsDB,$tableprefix,$log);
$i = new Item($xoopsDB,$tableprefix,$log);
$t = new Terms($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">

	function tryValidate(){
	document.getElementById('idValidate').src = 'validate_invoice.php?xf_value='+ document.forms['frmInvoice'].customer_id.value;
	//alert(document.forms['frmInvoice'].customer_id.value);
	}


	function printSave(){
	
	if(validateData()==true){
	document.forms['frmInvoice'].printPdf.value = 1;
	document.forms['frmInvoice'].btnSave.click();
	}

	}
	
	function unitPrice(i){
	document.getElementById("customPrice"+i).checked = true; 	
	
	}
	
	function onOpen(){
	document.forms['frmInvoice'].invoice_no.focus();

	}
	
	

	function headerSort(sortFldValue){


		document.frmActionSearch.fldSort.value = sortFldValue;

		//document.frmActionSearch.btnSubmit.click();
		document.frmActionSearch.submit();

	}
	
	function createRow(){
		var data;
		data = document.frmInvoice.fldRow.value;
		dataCust = document.frmInvoice.customer_id.value;
		
		
		if(dataCust==0){
		alert('Please customer id is filled in.');
		document.frmInvoice.customer_id.focus();
		return false;
		}
		
		
		if(data==""){
		alert("Please Key In No. Of Item.");
		document.frmInvoice.fldRow.focus();
		return false;
		}
		else{
		
		
		if(!IsNumeric(data)){
			alert (data + ":is not numeric, please insert appropriate +ve value!");
			document.frmInvoice.fldRow.style.backgroundColor = "#FF0000";
			document.frmInvoice.fldRow.focus();
			return false;
		}	
		else{
			if(validateData()==true){
			document.frmInvoice.action.value = "row";
			document.frmInvoice.submit();
			}
			
			}
		
		}
		
	}
	
	function saveRecord(){
		document.frmInvoice.action.value = "create";
		document.frmInvoice.submit();
	}
	
	function validateAttn(){
	document.frmInvoice.action.value = "attn";
	document.frmInvoice.submit();
	
	}
	
	function completeRecord(){
	
	if(confirm('Complete delete this data?')==false)
  	return false;
  	
	if(validateData()==true){
	document.frmInvoice.action.value = "complete";
	document.frmInvoice.submit();
	}
		
	}
	
	function enableInvoice(id){
	
	if(confirm('Confirm enable this data?')==false)
  	return false;
	document.frmInvoice.action.value = "enable";
	document.frmInvoice.invoice_id.value = id;
	document.frmInvoice.submit();
	}
	
	function deleteInvoiceLine(line_id,invoice_id){
	
	if(confirm('Confirm delete this data?')==false)
  	return false;
	
	if(validateData()==true){
	document.frmInvoice.action.value = "deleteline";
	document.frmInvoice.invoice_id.value = invoice_id;
	document.frmInvoice.invoicelinedelete_id.value = line_id;
	document.frmInvoice.submit();
	}
	
	}
	
	function validateData(){
	var i=0;
	while(i< document.forms['frmInvoice'].elements.length){
		var ctlname = document.forms['frmInvoice'].elements[i].name; 
		var data = document.forms['frmInvoice'].elements[i].value;
	
		if(ctlname=="invoice_seq[]" || ctlname=="invoice_qty[]" || ctlname=="invoice_unitprice[]" || ctlname=="invoice_discount[]"){
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmInvoice'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmInvoice'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmInvoice'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
		}
		
		i++;
		
	}
	
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



	function validateInvoice(){
 	
 	if(confirm('Confirm change this data?')==false){
  	return false;
  	}else{
  	
  	var code=document.forms['frmInvoice'].invoice_no.value;
	var customer_id = document.forms['frmInvoice'].customer_id.value;
		
		
		if(code =="" || customer_id==0){
			alert('Please make sure invoice no and customer id is filled in.');
			return false;
		}
		
		var i=0;
		while(i< document.forms['frmInvoice'].elements.length){
			var ctlname = document.forms['frmInvoice'].elements[i].name; 
			var data = document.forms['frmInvoice'].elements[i].value;
	
			if(ctlname=="invoice_seq[]" || ctlname=="invoice_qty[]" || ctlname=="invoice_unitprice[]" || ctlname=="invoice_discount[]"){
				if(!IsNumeric(data))
					{
						alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
						document.forms['frmInvoice'].elements[i].style.backgroundColor = "#FF0000";
						document.forms['frmInvoice'].elements[i].focus();
						return false;
					}	
					else
					document.forms['frmInvoice'].elements[i].style.backgroundColor = "#FFFFFF";
					
					
			}
			
			i++;
			
		}		
 	 
		return true;
	}
	
	}
	
	function itemSelect(line,name,thisobject){
	var i=0;
	var j=1;
	var k=0;
	var l=0;
	var m=0;
	
	while(i< document.forms['frmInvoice'].elements.length){
	
		if(document.forms['frmInvoice'].elements[i].name == name){
		
		if(k==1)		
		m = i;
		
			if(j==line)
				if(document.forms['frmInvoice'].elements[i].value!=0){
				
				//alert(document.forms['frmInvoice'].elements[i].value);
				document.forms['frmInvoice'].elements[i+1].style.display = 'none';
				//document.forms['frmInvoice'].elements[i+4].readOnly = 'readonly';
				
				
				}else{
				document.forms['frmInvoice'].elements[i+1].style.display = '';
				document.forms['frmInvoice'].elements[i+4].readOnly = '';
				}
	
			j++;
			k++;
			
			}
			
			if(k==1)
			l++;
	
		i++	
		}
		
		//i for element m

//	document.getElementById('idValidate').src = 'validate_invoice.php?xf_line=';
	
	}
	
	function showDescription(id,type,line){
	var id;
	
	
	if(type==1){
	document.getElementById(id).style.display = "none";
	document.getElementById("idHide"+line).style.display = "";
	document.getElementById("idDesc"+line).style.display = "";
	
	}else{
	document.getElementById(id).style.display = "none";
	document.getElementById("idShow"+line).style.display = "";
	document.getElementById("idDesc"+line).style.display = "none";
	}
		
	
	}
	
	function calculateAmount1(line,name){
	var i=0;
	var j=1;
	total_amount=0;
	
	while(i< document.forms['frmInvoice'].elements.length){

		if(document.forms['frmInvoice'].elements[i].name == name){
		
		if(j==line){
			var qty = document.forms['frmInvoice'].elements[i].value;
			var uprice = document.forms['frmInvoice'].elements[i+2].value;
			var discount = document.forms['frmInvoice'].elements[i+4].value;
		
			document.forms['frmInvoice'].elements[i+5].value = qty*uprice - (discount/100*uprice);
		
			}
			
		if(document.forms['frmInvoice'].elements[i].name == 'invoice_amount[]'){
		
		}
	
		j++;
		}
		
		if(document.forms['frmInvoice'].elements[i].name == 'invoice_amount[]'){
		var amount = document.forms['frmInvoice'].elements[i].value;
		total_amount = parseFloat(total_amount) + parseFloat(amount);
		}
	
	i++
	}
	document.forms['frmInvoice'].invoce_total.value = total_amount;
	}


	function calculateAmount2(line,name){
	var i=0;
	var j=1;
	total_amount=0;
	
	while(i< document.forms['frmInvoice'].elements.length){

		if(document.forms['frmInvoice'].elements[i].name == name){
		
		if(j==line){
			var qty = document.forms['frmInvoice'].elements[i-2].value;
			var uprice = document.forms['frmInvoice'].elements[i].value;
			var discount = document.forms['frmInvoice'].elements[i+2].value;
		
			document.forms['frmInvoice'].elements[i+3].value = qty*uprice - (discount/100*uprice);
		
			}
			
		if(document.forms['frmInvoice'].elements[i].name == 'invoice_amount[]'){
		
		}
	
		j++;
		}
		
		if(document.forms['frmInvoice'].elements[i].name == 'invoice_amount[]'){
		var amount = document.forms['frmInvoice'].elements[i].value;
		total_amount = parseFloat(total_amount) + parseFloat(amount);
		}
	
	i++
	
	}
	
	document.forms['frmInvoice'].invoce_total.value = total_amount;
	
	}

	function calculateAmount3(line,name){
	var i=0;
	var j=1;
	total_amount=0;
	
	while(i< document.forms['frmInvoice'].elements.length){

		if(document.forms['frmInvoice'].elements[i].name == name){
		
		if(j==line){
			var qty = document.forms['frmInvoice'].elements[i-4].value;
			var uprice = document.forms['frmInvoice'].elements[i-2].value;
			var discount = document.forms['frmInvoice'].elements[i].value;
		//	alert(qty+','+uprice+','+discount);
		
			document.forms['frmInvoice'].elements[i+1].value = qty*uprice - (discount/100*uprice);
		
			}
			
		if(document.forms['frmInvoice'].elements[i].name == 'invoice_amount[]'){
		
		}
	
		j++;
		}
		
		if(document.forms['frmInvoice'].elements[i].name == 'invoice_amount[]'){
		var amount = document.forms['frmInvoice'].elements[i].value;
		total_amount = parseFloat(total_amount) + parseFloat(amount);
		}
	
	i++
	
	}
	
	document.forms['frmInvoice'].invoce_total.value = total_amount;
	
	}
</script>

EOF;

$o->invoice_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->invoice_id=$_POST["invoice_id"];
	$o->printPdf=$_POST['printPdf'];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->invoice_id=$_GET["invoice_id"];
	$o->printPdf=$_GET['printPdf'];

}
else
$action="";

$token=$_POST['token'];



//================

$o->invoice_no=$_POST["invoice_no"];
$o->customer_id=$_POST["customer_id"];
$o->invoice_date=$_POST["invoice_date"];
$o->invoice_terms=$_POST["invoice_terms"];
$o->iscomplete=$_POST["iscomplete"];
$o->invoice_attn=$_POST["invoice_attn"];



$o->invoice_preparedby=$_POST["invoice_preparedby"];
$o->invoice_attntel=$_POST["invoice_attntel"];
$o->invoice_attntelhp=$_POST["invoice_attntelhp"];
$o->invoice_attnfax=$_POST["invoice_attnfax"];
$o->invoice_remarks=$_POST["invoice_remarks"];
$o->terms_id=$_POST["terms_id"];
$o->created=$_POST["created"];
$o->updated=$_POST["updated"];
//$o->isactive=$_POST["isactive"];

// item line

$o->invoiceline_id=$_POST["invoiceline_id"];
$o->invoice_seq=$_POST["invoice_seq"];
$o->invoice_desc=$_POST["invoice_desc"];
$o->item_id=$_POST["item_id"];
$o->item_name=$_POST["item_name"];
$o->invoice_qty=$_POST["invoice_qty"];
$o->item_uom=$_POST['item_uom'];
$o->invoice_unitprice=$_POST["invoice_unitprice"];
$o->invoice_amount=$_POST["invoice_amount"];
$o->invoice_discount=$_POST["invoice_discount"];
$o->invoicelinedelete_id=$_POST["invoicelinedelete_id"];
$o->iscustomprice=$_POST["iscustomprice"];
//
$o->datectrl=$dp->show("invoice_date");


//==================


$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->preparedby=$xoopsUser->getVar('name');


if ($o->iscomplete=="on")
	$o->iscomplete=1;
elseif($o->iscomplete=="")
	$o->iscomplete=0;
	


echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Invoice Master Data</span></big></big></big></div><br>
EOF;
$filterstring=$o->searchAToZ();

if($_GET['filterstring'] != "")
	$filterstring=$_GET['filterstring'];
 switch ($action){

	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with invoice name=$o->invoice_no");

	


	if ($s->check(false,$token,"CREATE_INV")){
		
	if($o->insertInvoice()){
		 $latest_id=$o->getLatestInvoiceID();
		 
			 redirect_header("invoice.php?action=edit&invoice_id=$latest_id&printPdf=$o->printPdf",$pausetime,"Your data is saved, the new id=$latest_id");
			 
		}
	else {
				redirect_header("invoice.php?action=new",3,"<b style='color:red'>Can't create invoice!</b>");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_INV");
		
		$o->getInputForm("new",-1,$token);
		//$o->showInvoiceTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :

	if($o->getInvoiceDesc($o->invoice_id,"iscomplete")==0){
	
		if($o->fetchInvoice($o->invoice_id)){
	
		
		
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_INV");
		$o->invoicectrl=$o->getSelectInvoice(-1);
		$o->termsctrl=$t->getSelectTerms($o->terms_id);
		$o->customerctrl=$c->getSelectCustomer($o->customer_id,"invoice");
		//$o->itemctrl=$o->getSelectItemArray(0);
		
		$o->getInputForm("edit",$o->invoice_id,$token);
		}else	//if can't find particular organization from database, return error message
		redirect_header("invoice.php",3,"Some error on viewing your invoice data, probably database corrupted");
		
		
	}else{
		
		$token=$s->createToken($tokenlife,"CREATE_INV");
		$o->invoicectrl=$o->getSelectInvoice(-1);
		$o->customerctrl=$c->getSelectCustomer(-1,"invoice");
		$o->termsctrl=$t->getSelectTerms(1);
		//$o->itemctrl=$o->getSelectItemArray(0);
		$o->getInputForm("new",0,$token);
		
	}
		
//		$wc->showInvoiceEmploymentTable("WHERE wc.invoice_id=$o->invoice_id","order by wc.invoice_desc ",0,99999); 
	
  
break;

//when user press save for change existing organization data
  case "update" :
	  
	if ($s->check(false,$token,"CREATE_INV")){
		
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateInvoice()){ //if data save successfully
			
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id&printPdf=$o->printPdf",$pausetime,"Your data is saved.");
			
		}else{
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	}else{
		redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_INV")){
		if($o->deleteInvoice($o->invoice_id))
			redirect_header("invoice.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "new" :

	$token=$s->createToken($tokenlife,"CREATE_INV");
	$o->invoicectrl=$o->getSelectInvoice(-1);
	$o->customerctrl=$c->getSelectCustomer(-1,"invoice");
	$o->termsctrl=$t->getSelectTerms(1);
	//$o->itemctrl=$o->getSelectItemArray(0);
	$o->getInputForm("new",0,$token);
	
	//$o->showInvoiceTable("WHERE c.isactive=1","order by c.invoice_desc",0,99999);
  break;
  case "showSearchForm":
	$o->invoicectrl=$o->getSelectInvoice(-1);
	$o->customerctrl=$c->getSelectCustomer(-1);
	//$o->invoicectrl=$o->getSelectInvoice(-1);

	$o->showSearchForm();
  break;
  case "search":
  
  $sortstr = "ORDER BY c.invoice_no";
  $wherestr=$o->convertSearchString($o->invoice_id,$o->invoice_no,$o->iscomplete,$o->customer_id);
  $fldSort = '';
  
  
	// start sort header
	
	
	if($_POST['fldSort']!=''){
	$fldSort = $_POST['fldSort'];
	$wherestr = str_replace('\\', '',$_POST['wherestr']); 
	$orderctrl = $_POST['orderctrl'];
	$sortstr = " order by ".$fldSort." ".$orderctrl;
	}else{//if have join table add here
	
	if($wherestr!='')
	$wherestr .= " and a.customer_id = c.customer_id ";
	else
	$wherestr .= " where a.customer_id = c.customer_id ";
	
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
	
	
	$o->invoicectrl=$o->getSelectInvoice(-1);
	$o->customerctrl=$c->getSelectCustomer(-1);
	//$o->invoicectrl=$o->getSelectInvoice(-1);
	
	$log->showLog(4,"Filterstring:$o->invoice_id,$o->invoice_no,$o->iscomplete");
	$o->showSearchForm("$wherestr","$orderctrl");
	
	$o->showSearchTable("$wherestr","$sortstr",0,9999,"$orderctrl","$fldSort",$s->createToken($tokenlife,"CREATE_INV"));
	
	//$o->showSearchTable($wherestring,"ORDER BY c.invoice_desc",0,9999);
	
  break;
  
  case "row":
  
  if($o->customer_id==0)
  $o->customer_id = -1;
  
  $o->customerctrl=$c->getSelectCustomer($o->customer_id,"invoice");
  $o->termsctrl=$t->getSelectTerms($o->terms_id);
  
  if ($s->check(false,$token,"CREATE_INV")){
  
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->updateInvoice()){ //if data save successfully
			
			$o->insertLineSave($_POST['fldRow']);
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Your item is created.");
			
		}else{
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
		
	}else{
		redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
	
  //$o->getInputForm("row",-1,$token,$_POST['fldRow']);
  
  break;
  
  case "attn":
 
  if($o->customer_id==0)
  $o->customer_id = -1;
  
  $o->customerctrl=$c->getSelectCustomer($o->customer_id,"invoice");
  $o->termsctrl=$t->getSelectTerms($o->terms_id);
  //$o->itemctrl=$o->getSelectItemArray(0);
  $o->getInputForm("attn",-1,$token);
  
  break;
  
  case "complete":
  
  if ($s->check(false,$token,"CREATE_INV")){
  
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->completeInvoice()) //if data save successfully
			//redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Your data is saved.");
			redirect_header("invoice.php",$pausetime,"Your data is saved.");
			
		else
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  
  break;
  
  case "enable":
  
  	if ($s->check(false,$token,"CREATE_INV")){
  
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->enableInvoice()) //if data save successfully
			//redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Your data is saved.");
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Your data is saved.");
			
		else
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  
  	break;
  	
  	case "deleteline":
  	
  	if ($s->check(false,$token,"CREATE_INV")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->deleteInvoiceLine()) //if data save successfully
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Your data is saved.");
		else
			redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("invoice.php?action=edit&invoice_id=$o->invoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
	
  	//invoicelinedelete_id
  	
  	break;
  
	
  
  default :
//	$token=$s->createToken(120,"CREATE_INV");
//	$o->getInputForm("new",0,$token);
//	$o->currencyctrl=$cr->getSelectCurrency(0);

	if ($filterstring=="")
		$filterstring="A";
		$o->showInvoiceTable("WHERE a.customer_name LIKE '$filterstring%' and a.customer_id = c.customer_id","order by a.customer_name",0,99999,$s->createToken($tokenlife,"CREATE_INV"));
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


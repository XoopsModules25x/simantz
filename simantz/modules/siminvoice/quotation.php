<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Quotation.php';
include_once 'class/Customer.php';
include_once 'class/Item.php';
include_once 'class/Terms.php';
include_once "menu.php";
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Quotation($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$c = new Customer($xoopsDB,$tableprefix,$log);
$i = new Item($xoopsDB,$tableprefix,$log);
$t = new Terms($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">

	function tryValidate(){
	document.getElementById('idValidate').src = 'validate_quotation.php?xf_value='+ document.forms['frmQuotation'].customer_id.value;
	//alert(document.forms['frmQuotation'].customer_id.value);
	}
	
	function convertRecord2(id){
	
	if(confirm('Convert this data to Invoice?')==false)
  	return false;
  	
	document.frmQuotation.action.value = "convert";
	document.frmQuotation.quotation_id.value = id;
	document.frmQuotation.submit();
	
	}
	
	function cloneRecord2(id){
	
	if(confirm('Clone this data?')==false)
  	return false;
  	
	document.frmQuotation.action.value = "clone";
	document.frmQuotation.quotation_id.value = id;
	document.frmQuotation.submit();
	
	}

	function convertRecord(){
	
	if(confirm('Convert this data to Invoice?')==false)
  	return false;
  	
	document.frmQuotation.action.value = "convert";
	document.frmQuotation.submit();
	
	}
	
	
	
	function cloneRecord(){
	
	if(confirm('Clone this data?')==false)
  	return false;
  	
	document.frmQuotation.action.value = "clone";
	document.frmQuotation.submit();
	
	}
	
	function printSave(){
	
	if(validateData()==true){
	document.forms['frmQuotation'].printPdf.value = 1;
	document.forms['frmQuotation'].btnSave.click();
	}

	}
	
	function unitPrice(i){
	document.getElementById("customPrice"+i).checked = true; 	
	
	}
	
	function onOpen(){
	document.forms['frmQuotation'].quotation_no.focus();

	}
	
	

	function headerSort(sortFldValue){


		document.frmActionSearch.fldSort.value = sortFldValue;

		//document.frmActionSearch.btnSubmit.click();
		document.frmActionSearch.submit();

	}
	
	function createRow(){
		var data;
		data = document.frmQuotation.fldRow.value;
		dataCust = document.frmQuotation.customer_id.value;
		
		
		if(dataCust==0){
		alert('Please customer id is filled in.');
		document.frmQuotation.customer_id.focus();
		return false;
		}
		
		
		if(data==""){
		alert("Please Key In No. Of Item.");
		document.frmQuotation.fldRow.focus();
		return false;
		}
		else{
		
		
		if(!IsNumeric(data)){
			alert (data + ":is not numeric, please insert appropriate +ve value!");
			document.frmQuotation.fldRow.style.backgroundColor = "#FF0000";
			document.frmQuotation.fldRow.focus();
			return false;
		}	
		else{
			if(validateData()==true){
			document.frmQuotation.action.value = "row";
			document.frmQuotation.submit();
			}
			
			}
		
		}
		
	}
	
	function saveRecord(){
		document.frmQuotation.action.value = "create";
		document.frmQuotation.submit();
	}
	
	function validateAttn(){
	document.frmQuotation.action.value = "attn";
	document.frmQuotation.submit();
	
	}
	
	function completeRecord(){
	
	if(confirm('Complete delete this data?')==false)
  	return false;
  	
	if(validateData()==true){
	document.frmQuotation.action.value = "complete";
	document.frmQuotation.submit();
	}
		
	}
	
	function enableQuotation(id){
	
	if(confirm('Confirm enable this data?')==false)
  	return false;
	document.frmQuotation.action.value = "enable";
	document.frmQuotation.quotation_id.value = id;
	document.frmQuotation.submit();
	}
	
	function deleteQuotationLine(line_id,quotation_id){
	
	if(confirm('Confirm delete this data?')==false)
  	return false;
	
	if(validateData()==true){
	document.frmQuotation.action.value = "deleteline";
	document.frmQuotation.quotation_id.value = quotation_id;
	document.frmQuotation.quotationlinedelete_id.value = line_id;
	document.frmQuotation.submit();
	}
	
	}
	
	function validateData(){
	var i=0;
	while(i< document.forms['frmQuotation'].elements.length){
		var ctlname = document.forms['frmQuotation'].elements[i].name; 
		var data = document.forms['frmQuotation'].elements[i].value;
	
		if(ctlname=="quotation_seq[]" || ctlname=="quotation_qty[]" || ctlname=="quotation_unitprice[]" || ctlname=="quotation_discount[]"){
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmQuotation'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmQuotation'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmQuotation'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
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



	function validateQuotation(){
 	
 	if(confirm('Confirm change this data?')==false){
  	return false;
  	}else{
  	
  	var code=document.forms['frmQuotation'].quotation_no.value;
	var customer_id = document.forms['frmQuotation'].customer_id.value;
		
		
		if(code =="" || customer_id==0){
			alert('Please make sure quotation no and customer id is filled in.');
			return false;
		}
		
		var i=0;
		while(i< document.forms['frmQuotation'].elements.length){
			var ctlname = document.forms['frmQuotation'].elements[i].name; 
			var data = document.forms['frmQuotation'].elements[i].value;
	
			if(ctlname=="quotation_seq[]" || ctlname=="quotation_qty[]" || ctlname=="quotation_unitprice[]" || ctlname=="quotation_discount[]"){
				if(!IsNumeric(data))
					{
						alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
						document.forms['frmQuotation'].elements[i].style.backgroundColor = "#FF0000";
						document.forms['frmQuotation'].elements[i].focus();
						return false;
					}	
					else
					document.forms['frmQuotation'].elements[i].style.backgroundColor = "#FFFFFF";
					
					
			}
			
			i++;
			
		}		
 	 
		return true;
	}
	
	}
	
	function itemSelect(line,name){
	var i=0;
	var j=1;
	
	while(i< document.forms['frmQuotation'].elements.length){
	
		if(document.forms['frmQuotation'].elements[i].name == name){
		
			if(j==line)
				if(document.forms['frmQuotation'].elements[i].value!=0){
				
				//alert(document.forms['frmQuotation'].elements[i].value);
				document.forms['frmQuotation'].elements[i+1].style.display = 'none';
				//document.forms['frmQuotation'].elements[i+4].readOnly = 'readonly';
				
				
				}else{
				document.forms['frmQuotation'].elements[i+1].style.display = '';
				document.forms['frmQuotation'].elements[i+4].readOnly = '';
				}
	
			j++;
			}
	
		i++	
		}
	
	
	
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
	
	while(i< document.forms['frmQuotation'].elements.length){

		if(document.forms['frmQuotation'].elements[i].name == name){
		
		if(j==line){
			var qty = document.forms['frmQuotation'].elements[i].value;
			var uprice = document.forms['frmQuotation'].elements[i+2].value;
			var discount = document.forms['frmQuotation'].elements[i+4].value;
		
			document.forms['frmQuotation'].elements[i+5].value = qty*uprice - (discount/100*uprice);
		
			}
			
		if(document.forms['frmQuotation'].elements[i].name == 'quotation_amount[]'){
		
		}
	
		j++;
		}
		
		if(document.forms['frmQuotation'].elements[i].name == 'quotation_amount[]'){
		var amount = document.forms['frmQuotation'].elements[i].value;
		total_amount = parseFloat(total_amount) + parseFloat(amount);
		}
	
	i++
	}
	document.forms['frmQuotation'].invoce_total.value = total_amount;
	}


	function calculateAmount2(line,name){
	var i=0;
	var j=1;
	total_amount=0;
	
	while(i< document.forms['frmQuotation'].elements.length){

		if(document.forms['frmQuotation'].elements[i].name == name){
		
		if(j==line){
			var qty = document.forms['frmQuotation'].elements[i-2].value;
			var uprice = document.forms['frmQuotation'].elements[i].value;
			var discount = document.forms['frmQuotation'].elements[i+2].value;
		
			document.forms['frmQuotation'].elements[i+3].value = qty*uprice - (discount/100*uprice);
		
			}
			
		if(document.forms['frmQuotation'].elements[i].name == 'quotation_amount[]'){
		
		}
	
		j++;
		}
		
		if(document.forms['frmQuotation'].elements[i].name == 'quotation_amount[]'){
		var amount = document.forms['frmQuotation'].elements[i].value;
		total_amount = parseFloat(total_amount) + parseFloat(amount);
		}
	
	i++
	
	}
	
	document.forms['frmQuotation'].invoce_total.value = total_amount;
	
	}

	function calculateAmount3(line,name){
	var i=0;
	var j=1;
	total_amount=0;
	
	while(i< document.forms['frmQuotation'].elements.length){

		if(document.forms['frmQuotation'].elements[i].name == name){
		
		if(j==line){
			var qty = document.forms['frmQuotation'].elements[i-4].value;
			var uprice = document.forms['frmQuotation'].elements[i-2].value;
			var discount = document.forms['frmQuotation'].elements[i].value;
		
			document.forms['frmQuotation'].elements[i+1].value = qty*uprice - (discount/100*uprice);
		
			}
			
		if(document.forms['frmQuotation'].elements[i].name == 'quotation_amount[]'){
		
		}
	
		j++;
		}
		
		if(document.forms['frmQuotation'].elements[i].name == 'quotation_amount[]'){
		var amount = document.forms['frmQuotation'].elements[i].value;
		total_amount = parseFloat(total_amount) + parseFloat(amount);
		}
	
	i++
	
	}
	
	document.forms['frmQuotation'].invoce_total.value = total_amount;
	
	}
</script>

EOF;

$o->quotation_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->quotation_id=$_POST["quotation_id"];
	$o->printPdf=$_POST['printPdf'];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->quotation_id=$_GET["quotation_id"];
	$o->printPdf=$_GET['printPdf'];

}
else
$action="";

$token=$_POST['token'];



//================

$o->quotation_no=$_POST["quotation_no"];
$o->customer_id=$_POST["customer_id"];
$o->quotation_date=$_POST["quotation_date"];
$o->quotation_terms=$_POST["quotation_terms"];
$o->iscomplete=$_POST["iscomplete"];
$o->quotation_attn=$_POST["quotation_attn"];



$o->quotation_preparedby=$_POST["quotation_preparedby"];
$o->quotation_attntel=$_POST["quotation_attntel"];
$o->quotation_attntelhp=$_POST["quotation_attntelhp"];
$o->quotation_attnfax=$_POST["quotation_attnfax"];
$o->quotation_remarks=$_POST["quotation_remarks"];
$o->terms_id=$_POST["terms_id"];
$o->created=$_POST["created"];
$o->updated=$_POST["updated"];
//$o->isactive=$_POST["isactive"];

// item line
$o->item_uom=$_POST['item_uom'];
$o->quotationline_id=$_POST["quotationline_id"];
$o->quotation_seq=$_POST["quotation_seq"];
$o->quotation_desc=$_POST["quotation_desc"];
$o->item_id=$_POST["item_id"];
$o->item_name=$_POST["item_name"];
$o->quotation_qty=$_POST["quotation_qty"];
$o->quotation_unitprice=$_POST["quotation_unitprice"];
$o->quotation_amount=$_POST["quotation_amount"];
$o->quotation_discount=$_POST["quotation_discount"];
$o->quotationlinedelete_id=$_POST["quotationlinedelete_id"];
$o->iscustomprice=$_POST["iscustomprice"];
//
$o->datectrl=$dp->show("quotation_date");


//==================


$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->preparedby=$xoopsUser->getVar('name');


if ($o->iscomplete=="on")
	$o->iscomplete=1;
elseif($o->iscomplete=="")
	$o->iscomplete=0;
	


echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Quotation Master Data</span></big></big></big></div><br>
EOF;
$filterstring=$o->searchAToZ();

if($_GET['filterstring'] != "")
	$filterstring=$_GET['filterstring'];
 switch ($action){

	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with quotation name=$o->quotation_no");

	


	if ($s->check(false,$token,"CREATE_QUO")){
		
	if($o->insertQuotation()){
		 $latest_id=$o->getLatestQuotationID();
		 
			 	redirect_header("quotation.php?action=edit&quotation_id=$latest_id&printPdf=$o->printPdf",$pausetime,"Your data is saved, the new id=$latest_id");
			 
		}
	else {
				//echo "Can't create quotation!";
				redirect_header("quotation.php?action=new",3,"<b style='color:red'>Can't create quotation!</b>");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_QUO");
		
		$o->getInputForm("new",-1,$token);
		//$o->showQuotationTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :

	if($o->getQuotationDesc($o->quotation_id,"iscomplete")==0){
	
	
		if($o->fetchQuotation($o->quotation_id)){
		
				
		//create a new token for editing a form

		$token=$s->createToken($tokenlife,"CREATE_QUO");
		$o->quotationctrl=$o->getSelectQuotation(-1);
		$o->termsctrl=$t->getSelectTerms($o->terms_id);
		$o->customerctrl=$c->getSelectCustomer($o->customer_id,"quotation");
		$o->getInputForm("edit",$o->quotation_id,$token);
		}else	//if can't find particular organization from database, return error message
		redirect_header("quotation.php",3,"Some error on viewing your quotation data, probably database corrupted");
		
//		$wc->showQuotationEmploymentTable("WHERE wc.quotation_id=$o->quotation_id","order by wc.quotation_desc ",0,99999); 
	}else{
		$token=$s->createToken($tokenlife,"CREATE_QUO");
		$o->quotationctrl=$o->getSelectQuotation(-1);
		$o->customerctrl=$c->getSelectCustomer(-1,"quotation");
		$o->termsctrl=$t->getSelectTerms(1);
		$o->getInputForm("new",0,$token);
		
	}
	
  
break;

//when user press save for change existing organization data
  case "update" :
	  //echo $token;
	if ($s->check(false,$token,"CREATE_QUO")){
		
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateQuotation()){ //if data save successfully
			
			redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id&printPdf=$o->printPdf",$pausetime,"Your data is saved.");
			
		}else{
			redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	}else{
		redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_QUO")){
		if($o->deleteQuotation($o->quotation_id))
			redirect_header("quotation.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "new" :
	$token=$s->createToken($tokenlife,"CREATE_QUO");
	$o->quotationctrl=$o->getSelectQuotation(-1);
	$o->customerctrl=$c->getSelectCustomer(-1,"quotation");
	$o->termsctrl=$t->getSelectTerms(1);
	//$o->itemctrl=$o->getSelectItemArray(0);
	$o->getInputForm("new",0,$token);
	
	//$o->showQuotationTable("WHERE c.isactive=1","order by c.quotation_desc",0,99999);
  break;
  case "showSearchForm":
	$o->quotationctrl=$o->getSelectQuotation(-1);
	$o->customerctrl=$c->getSelectCustomer(-1);
	//$o->quotationctrl=$o->getSelectQuotation(-1);

	$o->showSearchForm();
  break;
  case "search":
  
  $sortstr = "ORDER BY c.quotation_no";
  $wherestr=$o->convertSearchString($o->quotation_id,$o->quotation_no,$o->iscomplete,$o->customer_id);
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
	
	
	$o->quotationctrl=$o->getSelectQuotation(-1);
	$o->customerctrl=$c->getSelectCustomer(-1);
	//$o->quotationctrl=$o->getSelectQuotation(-1);
	
	$log->showLog(4,"Filterstring:$o->quotation_id,$o->quotation_no,$o->iscomplete");
	$o->showSearchForm("$wherestr","$orderctrl");
	
	$o->showSearchTable("$wherestr","$sortstr",0,9999,"$orderctrl","$fldSort",$s->createToken($tokenlife,"CREATE_QUO"));
	
	//$o->showSearchTable($wherestring,"ORDER BY c.quotation_desc",0,9999);
	
  break;
  
  case "row":
  
  if($o->customer_id==0)
  $o->customer_id = -1;
  
  $o->customerctrl=$c->getSelectCustomer($o->customer_id,"quotation");
  $o->termsctrl=$t->getSelectTerms($o->terms_id);
  
  if ($s->check(false,$token,"CREATE_QUO")){
  
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->updateQuotation()){ //if data save successfully
			
			$o->insertLineSave($_POST['fldRow']);
			redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Your item is created.");
			
		}else{
			redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
		
	}else{
		redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
	
  //$o->getInputForm("row",-1,$token,$_POST['fldRow']);
  
  break;
  
  case "attn":
 
  if($o->customer_id==0)
  $o->customer_id = -1;
  
  $o->customerctrl=$c->getSelectCustomer($o->customer_id,"quotation");
  $o->termsctrl=$t->getSelectTerms($o->terms_id);
  //$o->itemctrl=$o->getSelectItemArray(0);
  $o->getInputForm("attn",-1,$token);
  
  break;
  
  case "complete":
  
  if ($s->check(false,$token,"CREATE_QUO")){
  
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->completeQuotation()) //if data save successfully
			//redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Your data is saved.");
			redirect_header("quotation.php",$pausetime,"Your data is saved.");
			
		else
			redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  
  break;
  
  case "enable":
  
  	if ($s->check(false,$token,"CREATE_QUO")){
  
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->enableQuotation()) //if data save successfully
			//redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Your data is saved.");
			redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Your data is saved.");
			
		else
			redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  
  	break;
  	
  	case "deleteline":
  	
  	if ($s->check(false,$token,"CREATE_QUO")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->deleteQuotationLine()) //if data save successfully
			redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Your data is saved.");
		else
			redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
	
  	//quotationlinedelete_id
  	
  	break;
	
  	case "convert":
  	
  	 if ($s->check(false,$token,"CREATE_QUO")){
  
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->convertQuotation($o->quotation_id)){ //if data save successfully
			$invoice_id = $o->getLatestInvoiceID();
			redirect_header("invoice.php?action=edit&invoice_id=$invoice_id",$pausetime,"Your data is saved.");
			
		}else{
			redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
			}
		}
	else{
		redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
	
  	break;
  	
  	
  	case "clone":
  	
  	 if ($s->check(false,$token,"CREATE_QUO")){
  
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->cloneQuotation($o->quotation_id)){ //if data save successfully
			$quotation_id = $o->getLatestQuotationID();
			redirect_header("quotation.php?action=edit&quotation_id=$quotation_id",$pausetime,"Your data is saved.");
			
		}else{
			redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
			}
		}
	else{
		redirect_header("quotation.php?action=edit&quotation_id=$o->quotation_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
	
  	break;
	
  
  default :
//	$token=$s->createToken(120,"CREATE_QUO");
//	$o->getInputForm("new",0,$token);
//	$o->currencyctrl=$cr->getSelectCurrency(0);
	if ($filterstring=="")
		$filterstring="A";
		$o->showQuotationTable("WHERE a.customer_name LIKE '$filterstring%' and a.customer_id = c.customer_id","order by a.customer_name",0,99999,$s->createToken($tokenlife,"CREATE_QUO"));
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


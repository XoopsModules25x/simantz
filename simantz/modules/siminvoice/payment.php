<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Payment.php';
include_once 'class/Customer.php';
include_once 'class/Item.php';
include_once "menu.php";
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Payment($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$c = new Customer($xoopsDB,$tableprefix,$log);
$i = new Item($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	
	function addPayment(){
	
		/*	
		if(confirm('Confirm Add This Invoice?')==false){
		return false;
		}else{*/
		
		if(validateData()==false){
		return false;
		}else{
		
			var i=0;
			var j=0;
		
  			while(i< document.forms['frmAddPayment'].elements.length){
			var ctlname = document.forms['frmAddPayment'].elements[i].name; 
			var data = document.forms['frmAddPayment'].elements[i].checked;

			
				if(ctlname.substring(0,14)=="invoice_select"){
					
					if(data==true){
					j++;
					}	
			
				}	
		 		i++;
	 	
 			}
 				
 		
 		
 			if(j>0){
 			//document.getElementById('idValidate').src = 'validate_payment.php?xf_value='+ document.forms['frmInvoice'].customer_id.value;
 			document.forms['frmPayment'].btnSave.click();
 			document.forms['frmAddPayment'].submit();
 		
 			}else{
 			alert ("Please Select Invoice.");
 			}
 			
 		}
 		
 		
	}	
	
	function tryValidate(){
	//document.getElementById('idValidate').src = 'validate_payment.php?xf_value='+ document.forms['frmInvoice'].customer_id.value;
	//alert(document.forms['frmInvoice'].customer_id.value);
	}
	
	function listInvoice(){
		var dataCust;
		
		dataCust = document.frmPayment.customer_id.value;
		
		
		if(dataCust==0){
		alert('Please customer id is filled in.');
		document.frmPayment.customer_id.focus();
		return false;
		}else{
		
		document.frmPayment.action.value = "row";
		document.frmPayment.submit();
		
		}
		
	}	
	
	function listInvoice2(){
	document.forms['frmPayment'].action.value = "row";
	document.forms['frmPayment'].submit();
	
	}
	

	function onOpen(){
	document.forms['frmPayment'].payment_no.focus();
	}


	function headerSort(sortFldValue){


		document.frmActionSearch.fldSort.value = sortFldValue;

		//document.frmActionSearch.btnSubmit.click();
		document.frmActionSearch.submit();

	}
	
	function createRow(){
		var data;
		data = document.frmPayment.fldRow.value;
		dataCust = document.frmPayment.customer_id.value;
		
		
		if(dataCust==0){
		alert('Please customer id is filled in.');
		document.frmPayment.customer_id.focus();
		return false;
		}
		
		
		if(data==""){
		alert("Please Key In No. Of Item.");
		document.frmPayment.fldRow.focus();
		return false;
		}
		else{
		
		
		if(!IsNumeric(data)){
			alert (data + ":is not numeric, please insert appropriate +ve value!");
			document.frmPayment.fldRow.style.backgroundColor = "#FF0000";
			document.frmPayment.fldRow.focus();
			return false;
		}	
		else{
			document.forms['frmPayment'].elements[i].style.backgroundColor = "#FFFFFF";
				
			document.frmPayment.action.value = "row";
			document.frmPayment.submit();
			
			}
		
		}
		
	}
	
	function saveRecord(){
		document.frmPayment.action.value = "create";
		document.frmPayment.submit();
	}
	
	function saveAllRecord(){
	if(validatePayment("Confirm change this data?",1)==true)
	document.frmPayment.submit();
	}
	
	function saveAllRecordCreate(){
	
	if(validatePayment("Confirm create invoice?",2)==true){
	createRow();
	}
	
	}
	
	function validateAttn(){
	
	document.frmPayment.action.value = "attn";
	document.frmPayment.submit();
	
	}
	
	function completeRecord(){
	
	if(confirm('Complete delete this data?')==false)
  	return false;
  	
	document.frmPayment.action.value = "complete";
	document.frmPayment.submit();
		
	}
	
	function enablePayment(id){
	
	if(confirm('Confirm enable this data?')==false)
  	return false;
	document.frmPayment.action.value = "enable";
	document.frmPayment.payment_id.value = id;
	document.frmPayment.submit();
	}
	
	function deletePaymentLine(line_id,payment_id){
	
	if(confirm('Confirm delete this line?')==false)
  	return false;
	
	if(validateData()==true){
	document.frmPayment.action.value = "deleteline";
	document.frmPayment.payment_id.value = payment_id;
	document.frmPayment.paymentlinedelete_id.value = line_id;
	document.frmPayment.submit();
	}
	
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
   return IsNumber;
   
   }



	function validatePayment(text,type){
 	
 
 	if(confirm(text)==false){
  		return false;
  	}else{
  	
  	var code=document.forms['frmPayment'].payment_no.value;
	var customer_id = document.forms['frmPayment'].customer_id.value;
		
		
		if(code =="" || customer_id==0){
			alert('Please make sure payment no and customer id is filled in.');
			return false;
		}
		
  	var i=0;
  	while(i< document.forms['frmPayment'].elements.length){
		var ctlname = document.forms['frmPayment'].elements[i].name; 
		var data = document.forms['frmPayment'].elements[i].value;

		if(ctlname=="paymentline_amount[]" || ctlname=="payment_amount"){
					
			if(data==""){
			alert (ctlname + ":" + data + ":is empty, please insert appropriate +ve value!");
			document.forms['frmPayment'].elements[i].style.backgroundColor = "#FF0000";
			document.forms['frmPayment'].elements[i].focus();
			return false;
			}
			
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmPayment'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmPayment'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmPayment'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
		}	
		 	i++;
	 	
 	}		
 	 
		return true;
	}
	
	}
	
	function itemSelect(line,name){
	var i=0;
	var j=1;
	
	while(i< document.forms['frmPayment'].elements.length){
	
		if(document.forms['frmPayment'].elements[i].name == name){
		
			if(j==line)
				if(document.forms['frmPayment'].elements[i].value!=0){
				
				//alert(document.forms['frmPayment'].elements[i].value);
				document.forms['frmPayment'].elements[i+1].style.display = 'none';
				document.forms['frmPayment'].elements[i+4].readOnly = 'readonly';
				
				
				}else{
				document.forms['frmPayment'].elements[i+1].style.display = '';
				document.forms['frmPayment'].elements[i+4].readOnly = '';
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
	
	function validateData(){
	
		var i=0;
  		while(i< document.forms['frmPayment'].elements.length){
			var ctlname = document.forms['frmPayment'].elements[i].name; 
			var data = document.forms['frmPayment'].elements[i].value;

			if(ctlname=="paymentline_amount[]" || ctlname=="payment_amount"){
					
				if(data==""){
				alert (ctlname + ":" + data + ":is empty, please insert appropriate +ve value!");
				document.forms['frmPayment'].elements[i].style.backgroundColor = "#FF0000";
				document.forms['frmPayment'].elements[i].focus();
				return false;
			}
			
			if(!IsNumeric(data)){
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmPayment'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmPayment'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmPayment'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
			}	
		 	i++;
	 	
 		}		
 	 
		return true;
	}
	
	
	function calculateAmount(thisone){
	var i=0;
	total_amount=0;
	
	parseelement(thisone);
	
		while(i< document.forms['frmPayment'].elements.length){

			if(document.forms['frmPayment'].elements[i].name == "paymentline_amount[]"){
		
			var amount = document.forms['frmPayment'].elements[i].value;
			total_amount = parseFloat(total_amount) + parseFloat(amount);
			}
		
		
	
		i++
		}
		
		document.forms['frmPayment'].invoce_total.value = total_amount;
		parseelement(document.forms['frmPayment'].invoce_total);
		
	}
	
	
//Remove the $ sign if you wish the parse number to NOT include it

function parseelement(thisone){

var prefix=""
var wd

	if (thisone.value.charAt(0)=="$")
		return
		
	wd="w"
	var tempnum=thisone.value
	for (i=0;i<tempnum.length;i++){
	
			if (tempnum.charAt(i)=="."){
			wd="d"
			break
			}
	}
	
	if (wd=="w")
		thisone.value=prefix+tempnum+".00"
	else{
		if (tempnum.charAt(tempnum.length-2)=="."){
		thisone.value=prefix+tempnum+"0"
		}else{
		tempnum=Math.round(tempnum*100)/100
		thisone.value=prefix+tempnum
		}
	}
	
}

	
</script>

EOF;

$o->payment_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->payment_id=$_POST["payment_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->payment_id=$_GET["payment_id"];

}
else
$action="";

$token=$_POST['token'];

//================

$o->payment_no=$_POST["payment_no"];
$o->customer_id=$_POST["customer_id"];
$o->payment_type=$_POST["payment_type"];
$o->payment_date=$_POST["payment_date"];
$o->payment_amount=$_POST["payment_amount"];
$o->payment_chequeno=$_POST["payment_chequeno"];
$o->payment_desc=$_POST["payment_desc"];
//$o->payment_person=$_POST["payment_person"];
$o->payment_receivedby=$_POST["payment_receivedby"];
$o->created=$_POST["created"];
$o->updated=$_POST["updated"];

// item line

$o->paymentline_id=$_POST["paymentline_id"];
$o->invoice_id=$_POST["invoice_id"];
$o->paymentline_amount=$_POST["paymentline_amount"];
$o->paymentline_desc=$_POST["paymentline_desc"];
$o->paymentlinedelete_id=$_POST["paymentlinedelete_id"];
$o->invoice_select=$_POST["invoice_select"];

//
$o->datectrl=$dp->show("payment_date");


//==================


$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->preparedby=$xoopsUser->getVar('name');
//$o->payment_person=$xoopsUser->getVar('uid');


/*
if ($o->iscomplete=="on")
	$o->iscomplete=1;
elseif($o->iscomplete=="")
	$o->iscomplete=0;
*/
	


echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Payment Master Data</span></big></big></big></div><br>
EOF;
$filterstring=$o->searchAToZ();

if($_GET['filterstring'] != "")
	$filterstring=$_GET['filterstring'];
 switch ($action){

	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with payment name=$o->payment_no");

	


	if ($s->check(false,$token,"CREATE_PAY")){
		
	if($o->insertPayment()){
		 $latest_id=$o->getLatestPaymentID();
			 redirect_header("payment.php?action=edit&payment_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				//echo "Can't create payment!";
				redirect_header("payment.php?action=new",3,"<b style='color:red'>Can't create payment!</b>");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_PAY");
		
		$o->getInputForm("new",-1,$token);
		//$o->showPaymentTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :

	if($o->fetchPayment($o->payment_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_PAY");
		$o->paymentctrl=$o->getSelectPayment(-1);
		$o->customerctrl=$c->getSelectCustomer($o->customer_id);
		//$o->itemctrl=$o->getSelectItemArray(0);
		
		$o->getInputForm("edit",$o->payment_id,$token);
		
//		$wc->showPaymentEmploymentTable("WHERE wc.payment_id=$o->payment_id","order by wc.payment_desc ",0,99999); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("payment.php",3,"Some error on viewing your payment data, probably database corrupted");
  
break;

//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_PAY")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updatePayment()) //if data save successfully
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Your data is saved.");
		else
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_PAY")){
		if($o->deletePayment($o->payment_id))
			redirect_header("payment.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "new" :
	$token=$s->createToken($tokenlife,"CREATE_PAY");
	$o->paymentctrl=$o->getSelectPayment(-1);
	$o->customerctrl=$c->getSelectCustomer(-1);
	//$o->itemctrl=$o->getSelectItemArray(0);
	$o->getInputForm("new",0,$token);
	
	//$o->showPaymentTable("WHERE c.isactive=1","order by c.payment_desc",0,99999);
  break;
  case "showSearchForm":
	$o->paymentctrl=$o->getSelectPayment(-1);
	$o->customerctrl=$c->getSelectCustomer(-1);
	//$o->paymentctrl=$o->getSelectPayment(-1);

	$o->showSearchForm();
  break;
  case "search":
  
  $sortstr = "ORDER BY c.payment_no";
  $wherestr=$o->convertSearchString($o->payment_id,$o->payment_no,$o->customer_id);
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
	
	
	$o->paymentctrl=$o->getSelectPayment(-1);
	$o->customerctrl=$c->getSelectCustomer(-1);
	//$o->paymentctrl=$o->getSelectPayment(-1);
	
	$log->showLog(4,"Filterstring:$o->payment_id,$o->payment_no,$o->iscomplete");
	$o->showSearchForm("$wherestr","$orderctrl");
	
	$o->showSearchTable("$wherestr","$sortstr",0,9999,"$orderctrl","$fldSort",$s->createToken($tokenlife,"CREATE_PAY"));
	
	//$o->showSearchTable($wherestring,"ORDER BY c.payment_desc",0,9999);
	
  break;
  
  case "row":
  
  if($o->customer_id==0)
  $o->customer_id = -1;
  
  $o->customerctrl=$c->getSelectCustomer($o->customer_id);
  //$o->itemctrl=$o->getSelectItemArray(0);
  $o->getInputForm("row",-1,$token,$o->customer_id);
  
  break;
  
  case "attn":
 
  if($o->customer_id==0)
  $o->customer_id = -1;
  
  $o->customerctrl=$c->getSelectCustomer($o->customer_id);
  //$o->itemctrl=$o->getSelectItemArray(0);
  $o->getInputForm("attn",-1,$token);
  
  break;
  
  case "complete":
  
  if ($s->check(false,$token,"CREATE_PAY")){
  
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->completePayment()) //if data save successfully
			//redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Your data is saved.");
			redirect_header("payment.php",$pausetime,"Your data is saved.");
			
		else
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  
  break;
  
  case "enable":
  
  	if ($s->check(false,$token,"CREATE_PAY")){
  
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->enablePayment()) //if data save successfully
			//redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Your data is saved.");
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Your data is saved.");
			
		else
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  
  	break;
  	
  	case "deleteline":
  	
  	if ($s->check(false,$token,"CREATE_PAY")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->deletePaymentLine()) //if data save successfully
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Your data is saved.");
		else
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
	
  	//paymentlinedelete_id
  	
  	break;
  	
  	case "add_payment":
  	
  	if ($s->check(false,$token,"CREATE_PAY")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		
		if($o->addPaymentLine()) //if data save successfully
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Your data is saved.");
		else
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  	
  	break;
  
	
  
  default :
	$token=$s->createToken($tokenlife,"CREATE_PAY");
	$o->paymentctrl=$o->getSelectPayment(-1);
	$o->customerctrl=$c->getSelectCustomer(-1);
	$o->getInputForm("new",0,$token);
//	$o->getInputForm("new",0,$token);

/*
	if ($filterstring=="")
		$filterstring="A";
		$o->showPaymentTable("WHERE a.customer_name LIKE '$filterstring%' and a.customer_id = c.customer_id","order by a.customer_name",0,99999,$s->createToken(120,"CREATE_PAY"));
		
		*/
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


<?php
include_once "system.php";
include_once "menu.php";
include_once "class/RegClass.php";
include_once "class/Log.php";
//include_once "class/Employee.php";
include_once "class/Student.php";
include_once "class/Area.php";
include_once "class/Payment.php";
include_once "class/PaymentLine.php";
include_once "class/Product.php";
include_once ("datepicker/class.datepicker.php");


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();

$t = new Student($xoopsDB,$tableprefix,$log);
$o = new Payment($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);
$rc=new RegClass($xoopsDB,$tableprefix,$log);
$pl = new PaymentLine($xoopsDB,$tableprefix,$log);
$pd = new Product($xoopsDB,$tableprefix,$log);
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$pl->cur_name=$cur_name;
$pl->cur_symbol=$cur_symbol;


$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmSearchStudent'].student_code.focus();
	}

	function validatePayment(){
	var receipt_no=document.frmpayment.receipt_no.value;
	var action=document.frmpayment.action.value;
	var returnamt= document.frmpayment.returnamt ? document.frmpayment.returnamt.value : 0;
	if (action!="deleteproduct"){
		if(confirm ('Confirm to save data?')){
			if(!IsNumeric(receipt_no) || receipt_no=="" || returnamt <0){
				alert("Please make sure receipt no not empty and 'Change' value >= 0.")
				return false;
			}
			else
				return true;
		}
		else
			return false;
	}
	else
			return true;
	}

	function submitDelete(paymentline_id){
	if(confirm("Confirm delete this record? "))
		{
		document.frmpayment.action.value="deleteproduct";
		document.frmpayment.paymentline_id.value=paymentline_id;
		document.frmpayment.submit.click();
		}
	}

	function calculateBalance(){
		
		var totalrow=document.forms["frmpayment"].elements["rowcount"].value;
		var total=0;	
		for (i=0;i<totalrow;i++)
			total=total+parseFloat(document.forms["frmpayment"].elements["paymentlineamt["+i+"]"].value);

			document.forms["frmpayment"].elements["amt"].value=total;
			document.forms["frmpayment"].elements["returnamt"].value=
			document.forms["frmpayment"].elements["receivedamt"].value-
			document.forms["frmpayment"].elements["amt"].value;
			document.forms["frmpayment"].elements["totaloutstanding"].value=
			document.forms["frmpayment"].elements["classbalanceamt"].value-
			document.forms["frmpayment"].elements["classtotalcharge"].value;
			
	}

	function feesClickPlus(id){
		
		var amt=parseFloat(document.forms["frmpayment"].elements["balancefees["+id+"]"].value);
		var received=parseFloat(document.forms["frmpayment"].elements["receivedamt"].value);
		var total=parseFloat(document.forms["frmpayment"].elements["amt"].value);

			//else
			//	amt=0;		
		document.forms["frmpayment"].elements["linetrainingamt["+id+"]"].value=amt;
		
	//	if(parseFloat(document.forms["frmpayment"].elements["balancefees["+id+"]"].value)!=parseFloat(amt))
	//		document.forms['frmpayment'].elements["linetrainingamt["+id+"]"].style.backgroundColor = "red";
	//		document.forms['frmpayment'].elements["linetrainingamt["+id+"]"].style.backgroundColor = "#FFFFFF";
				onChangeLine(id);
	}

	function feesClickMinus(id) {
		document.forms["frmpayment"].elements["linetrainingamt["+id+"]"].value=0;
		onChangeLine(id);
	}

	function transportClickPlus(id){

		var amt=parseFloat(document.forms["frmpayment"].elements["balancetransportfees["+id+"]"].value);
		var currentamt=parseFloat(document.forms["frmpayment"].elements["linetransportamt["+id+"]"].value);
		var received=parseFloat(document.forms["frmpayment"].elements["receivedamt"].value);
		var total=parseFloat(document.forms["frmpayment"].elements["amt"].value);
			
		document.forms["frmpayment"].elements["linetransportamt["+id+"]"].value=amt;

				onChangeLine(id);
	}
	function transportClickMinus(id){
		
				document.forms["frmpayment"].elements["linetransportamt["+id+"]"].value=0;
				onChangeLine(id);
	
	}
	function onChangeLine(id){
	var no1 =parseFloat(document.forms["frmpayment"].elements["linetrainingamt["+id+"]"].value);
	var no2=parseFloat(document.forms["frmpayment"].elements["linetransportamt["+id+"]"].value);
	document.forms["frmpayment"].elements["paymentlineamt["+id+"]"].value=no1 + no2;
	var classrowcount=document.forms["frmpayment"].elements["classrowcount"].value;
	var subtotal=0;

	for (i=0;i<classrowcount;i++){	
		subtotal=subtotal+ parseFloat(document.forms["frmpayment"].elements["paymentlineamt["+i+"]"].value);
	}
	document.forms["frmpayment"].elements["classtotalcharge"].value=subtotal;
	calculateBalance();

	}
	function fullPay(){
		//alert(document.forms["frmpayment"].elements["amt"].value);
		document.forms["frmpayment"].elements["receivedamt"].value=document.forms["frmpayment"].elements["amt"].value;

		var totalrow=document.forms["frmpayment"].elements["rowcount"].value;
		
		for (id=0;id<totalrow;id++){
			
			feesClickPlus(id);
			transportClickPlus(id);
		}
//		document.forms['frmpayment'].elements["receivedamt"].focus();
//		document.forms['frmpayment'].elements["receivedamt"].style.backgroundColor = "#FF0000";
		
			
	}
	function calculateProductAmt(id){
	
		var unitprice=document.forms["frmpayment"].elements["lineunitprice["+id+"]"].value;
		var qty=document.forms["frmpayment"].elements["lineqty["+id+"]"].value;
		
		amt=parseFloat(unitprice*qty);
		document.forms["frmpayment"].elements["paymentlineamt["+id+"]"].value=amt;
		calculateBalance();
	}
	
	
</script>
EOF;


if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->payment_id=$_POST["payment_id"];
	$o->student_id=$_POST["student_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->payment_id=$_GET["payment_id"];
	$o->student_id=$_GET["student_id"];
}
else
$action="";

//search information
$o->student_code=$_POST['student_code'];
$o->student_name=$_POST['student_name'];
$o->ic_no=$_POST['ic_no'];
$o->amt=$_POST['amt'];
$o->returnamt=$_POST['returnamt'];
$o->payment_datetime=$_POST['payment_datetime'];
$o->receipt_no=$_POST['receipt_no'];
$o->receivedamt=$_POST['receivedamt'];
$o->payment_description=$_POST['payment_description'];
$o->organization_id=$_POST['organization_id'];
$o->updatedby=$xoopsUser->getVar('uid');
$o->deleteAttachment=$_POST['deleteAttachment'];
$pl->linedescription=$_POST['linedescription'];

$o->createdby=$xoopsUser->getVar('uid');
$o->showdatefrom=$dp->show("datefrom");
$o->showdateto=$dp->show("dateto");
$pl->organization_id=$_POST['organization_id'];
$pl->classchecked=$_POST['classchecked'];
$pl->updatedby=$xoopsUser->getVar('uid');
$pl->createdby=$xoopsUser->getVar('uid');
$pl->paymentlineamt = $_POST['paymentlineamt'];
$pl->arraypaymentline_id=$_POST['arraypaymentline_id'];
$pl->lineqty=$_POST['lineqty'];
$pl->linebalance=$_POST['linebalance'];
$pl->lineunitprice=$_POST['lineunitprice'];
$pl->linetransportamt=$_POST['linetransportamt'];
$pl->linetrainingamt=$_POST['linetrainingamt'];
$token=$_POST['token'];
$iscomplete=$_POST['iscomplete'];
$o->outstandingamt=$_POST['outstandingamt'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->orgctrl="";
$o->isAdmin=$xoopsUser->isAdmin();
$tmpfile= $_FILES["upload_file"]["tmp_name"];
$filesize=$_FILES["upload_file"]["size"] / 1024;
$filetype=$_FILES["upload_file"]["type"];


if ($iscomplete=="Y" or $iscomplete=="on")
	$o->iscomplete='Y';
else
	$o->iscomplete='N';


switch ($action){
 case "create":
	$log->showlog(3,"Saving new payment data for Student_id=$o->student_id, datetime=$o->payment_datetime");
	if ($s->check(false,$token,"CREATE_PAY")){
		
		if($o->insertPayment()){
		 $latest_id=$o->getLatestPaymentID();
	
			if($pl->genInitPaymentLine($latest_id))
				 redirect_header("payment.php?action=edit&payment_id=$latest_id",$pausetime,"Your data is saved.");
			else
				redirect_header("payment.php?action=choose&student_id=$o->student_id",$pausetime,"$errorstart Warning! This receipt is created, but 1 or more line is note generated. You can add line below this receipt after form refresh.$errorend");
		}
		else
		redirect_header("payment.php?action=choose&student_id=$o->student_id",$pausetime,"$errorstart Warning! Cannot generate this receipt , please verified your data. $errorend");
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showlog(1,"Warning! Cannot generate this receipt due to token expired!");
		if($t->fetchStudentInfo($o->student_id)){
			$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
			$o->student_code=$t->student_code;
			$o->student_name=$t->student_name;
			$o->ic_no=$t->ic_no;
			$o->showPaymentHeader();

			$token=$s->createToken($tokenlife,"CREATE_PAY");			
			$o->openForm('new',$token);
			$o->showInputForm('edit',0,$token);
			$o->showOutstandingClass($o->student_id);
			//$o->showRegisteredTable('student',"WHERE t.student_id=$o->student_id",'ORDER BY c.tuitionclass_code');
			//$o->classctrl=$c->getSelectTuitionClass(0);
			$o->closeForm('new',$token);
		}
		else
			$log->showlog(1,"Error: can't retrieve student information: $o->student_id");
	}
 break;
 case "choosed":
	//echo '<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Create New Payment</span></big></big></big></div><br>';

	$log->showlog(3,"Choose Student_id=$o->student_id for proceed payment");
	if($t->fetchStudentInfo($o->student_id)){
		$existingpayment_id=$o->checkDraft($o->student_id);
	  if($existingpayment_id==0){
		$o->orgctrl=$permission->selectionOrg($o->createdby,$defaultorganization_id);
		$o->student_code=$t->student_code;
		$o->student_name=$t->student_name;
		$o->ic_no=$t->ic_no;
		
		//$o->showPaymentTable("WHERE p.iscomplete='N' and p.student_id=$o->student_id",  'order by p.receipt_no',0);
		$o->showPaymentHeader();
		
		
	//	$o->classctrl=$c->getSelectTuitionClass(0);
		$token=$s->createToken($tokenlife,"CREATE_PAY");
		$o->openForm('new',$token);
		$o->showInputForm('new',0,$token);
		$o->showOutstandingClass($o->student_id);
		$o->showOutstandingProduct($o->student_id);
		//$rc->showRegisteredTable('student',"WHERE sc.student_id=$o->student_id and (sc.ispaid='N' OR sc.paidamt<>sc.transportfees+sc.trainingfees) ",'ORDER BY c.tuitionclass_code',"payment");
		$o->closeForm('new',$token);
	  }
	  else{
		redirect_header("payment.php?action=edit&payment_id=$existingpayment_id",$pausetime,"Your data is saved.");

	  }
	}
	else
		$log->showlog(1,"Error: can't retrieve student information: $o->student_id");
 break;
 case "update":
	$log->showlog(3,"Saving payment info for Student_id=$o->student_id, and payment_id=$o->payment_id");
	if($o->isCompleted($o->payment_id)=='N'){
	  if ($s->check(false,$token,"CREATE_PAY")){
		$nextaction=$_POST['submit'];
		if($pl->updatePaymentLine()){
			$log->showlog(4,"Outstanding Payment is:$pl->outstandingamt");
			$o->amt=$pl->getPaymentLineTotal($o->payment_id);
			$o->outstandingamt=$pl->outstandingamt;
			if( $o->updatePayment($nextaction) ) {//if data save successfully
				if($o->deleteAttachment=='on')
					$o->deletefile();

				if($filesize>0 || $filetype=='application/pdf')
					$o->savefile($tmpfile);
				
				if($nextaction=="Complete")
					redirect_header("printreceipt.php?payment_id=$o->payment_id&student_id=$o->student_id",$pausetime,"Your data is completed.");
					//redirect_header("listpayment.php",$pausetime,"Your data is completed.");
				else
					redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Your data is saved.");
			}//if save payment successfully
			else{
				redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"$errorstart Warning! Can't save the data, please make sure all value is insert properly.$errorend");
			}//end else update payment

		}//end update payment line
		else{
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"$errorstart Warning! Can't save the data, please make sure all value is insert properly.$errorend");}
		}//end else save payment line
	else{
		redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"$errorstart Warning! Can't save the data, due to form's token expired, please re-enter the data.$errorend");
	  }//end else token check
	}
	else{
		redirect_header("listpayment.php",$pausetime,"$errorstart Warning! This payment'd completed, you need to re-enable it before  editing.$errorend");
	}
 break;
 case "search":
	$log->showlog(3,"Search Student_id=$o->student_id,student_code=$o->student_code,student_name=$o->student_name,ic_no=$o->ic_no");
	$uid=$_POST['uid'];
	$wherestring= cvSearchString($o->student_id,$o->student_code,$o->student_name,$o->ic_no,$uid);
	$wherestring .= " and s.organization_id = $defaultorganization_id ";
	if($o->student_id==0){
		if ($wherestring!="")
			$wherestring="WHERE " . $wherestring;
	$t->showStudentTable($wherestring," ORDER BY student_name",0,'payment');
	}
	else
		redirect_header("payment.php?action=choosed&student_id=$o->student_id",$pausetime,"Opening Student for registration.");
 break;
 case "delete":
	if ($s->check(false,$token,"CREATE_PAY")){
		if($o->deletePayment($o->payment_id)){
			$o->deletefile($o->payment_id);
			redirect_header("listpayment.php?action=choosed&student_id=$o->student_id",$pausetime,"Data removed successfully.");
			}
		else
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"$errorstart Warning! Can't delete payment from database due to dependency error.$errorend");
	}
	else
		redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"$errorstart Warning! Can't delete data from database due to token expired, please re-delete the data.$errorend");
 break;
 case "edit":
	$log->showlog(3,"Editing data payment_id:$o->payment_id");

	if ($o->fetchPaymentInfo($o->payment_id)){
	  if($o->iscomplete=='N'){
		if($t->fetchStudentInfo($o->student_id)){
			$o->student_code=$t->student_code;
			$o->student_name=$t->student_name;
			$o->ic_no=$t->ic_no;
		}
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		echo <<< EOF
			<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Student Info</span></big></big></big></div><br>
EOF;
		$o->showPaymentHeader();
//		$o->showRegisteredTable('student',"WHERE t.student_id=$o->student_id",'ORDER BY c.tuitionclass_code');
		
		$token=$s->createToken($tokenlife,"CREATE_PAY");
		$o->openForm('edit',$token);
		$o->showInputForm('edit',$o->payment_id,$token);
		$pl->getClassPaymentLineTable($o->payment_id);
		$pl->prdctrl=$pd->getSelectProduct(0,"N");
		$pl->classctrl=$pl->getSelectNewClassLine($o->payment_id,$o->student_id);
		$pl->getProductPaymentLineTable($o->payment_id);
		$o->closeForm('edit',$token,'Y');
		$pl->showInsertNewItemForm($o->payment_id,$token);

	  }
	else{
		redirect_header("listpayment.php",$pausetime,"Error! This payment'd completed, you need to re-enable it before  editing.");
	}
	}
 break;
 case "addproduct":

	$pl->product_id=$_POST["product_id"];
	$pl->unitprice=$pd->getProductPrice($pl->product_id);
	$pl->qty=$_POST['qty'];
	if ($s->check(false,$token,"CREATE_PAY")){
		if($o->fetchPaymentInfo($o->payment_id)){
			$pl->payment_id=$o->payment_id;
			$pl->organization_id=$o->organization_id;
			$pl->insertNewProduct($pl->product_id,$pl->qty);
			$log->showlog(3,"Add product id $product_id, Qtr: $qty into payment: $payment_id successfully");

			if($pl->updatePaymentLine()){
			$log->showlog(4,"Outstanding Payment is:$pl->outstandingamt");
			$o->amt=$pl->getPaymentLineTotal($o->payment_id);
			$o->outstandingamt=$pl->outstandingamt;
			$o->updatePayment($nextaction) ; //if data save successfully
			}
		
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Your data is saved.");
		}
	}
	else
		{
		$log->showlog(1,"Error: Can't add product_id: $pl->product_id into payment:$o->payment_id due to token expired.");
		redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"$errorstart Warning! Cannot save this record due to token exporied! your data won't be save. Redirect by to previous form.$errorend");
		}


  break;
case "addclass":

	$pl->studentclass_id=$_POST["studentclass_id"];

	if ($s->check(false,$token,"CREATE_PAY")){
		if($o->fetchPaymentInfo($o->payment_id)){
			$pl->payment_id=$o->payment_id;
			$pl->organization_id=$o->organization_id;
			$pl->insertNewClass($pl->studentclass_id,$pl->payment_id);
			$log->showlog(3,"Add class into payment: $o->payment_id, with studentclass_id: $o->studentclass_id  successfully");
			redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Your data is saved.");
		}
	}
	else
		{
		//$log->showlog(1,"Error: Can't add pinto payment: $o->payment_id, with studentclass_id: $o->studentclass_id due to token expired.");
		redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"$errorstart Warninig! This record cannot save due to token expired! Redirect by to previous form.$errorend");
		}


  break;
  case "enable":
	if($o->enablePayment($o->payment_id))
		redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Payment re-activated, editing this record.");
	else
		redirect_header("listpayment.php",$pausetime,"$errorstart This payment can't reactivate! Probably there is internal error in database.$errorend");
  break;
  case "deleteproduct":

	$paymentline_id=$_POST["paymentline_id"];
	$pl->payment_id=$_POST['payment_id'];
	if ($s->check(false,$token,"CREATE_PAY")){
			$log->showlog(3,"Deleting paymentline_id: $paymentline_id from payment_id:$o->payment_id.");
			if($pl->deletepaymentline($paymentline_id)){
				if($pl->updatePaymentLine()){
					$log->showlog(4,"Outstanding Payment is:$pl->outstandingamt");
					$o->amt=$pl->getPaymentLineTotal($o->payment_id);
					$o->outstandingamt=$pl->outstandingamt;
					$o->updatePayment($nextaction) ; //if data save successfully
					}
					redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"1 record is deleted from your receipt.");
				}
			else
				redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"record cannot delete from db due to internal error.");
		}
	else
		{
		$log->showlog(1,"Error: Can't remove the record due to token expired.");
		redirect_header("payment.php?action=edit&payment_id=$o->payment_id",$pausetime,"Token expored! your data won't be delete. ".
				"Redirect by to previous form..");
		}


  break;
 default:
	
	$o->studentctrl=$t->getStudentSelectBox(-1);
	$o->showSearchForm();
 break;


}


echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

//convert 4 criterial into 1 search string
function cvSearchString($student_id,$student_code,$student_name,$ic_no,$uid){
$filterstring="";
$needand="";
if($student_id > 0 )
	$filterstring=$filterstring . " s.student_id=$student_id AND";

if($student_code!="")
	$filterstring=$filterstring . " s.student_code LIKE '$student_code' AND";

if ($student_name!="")
$filterstring=$filterstring . " s.student_name LIKE '$student_name' AND";

if($ic_no!="")
$filterstring=$filterstring . " s.ic_no LIKE '$ic_no' AND";

//if($uid!="0")
//$filterstring=$filterstring . " updatedby = '$uid' AND";

if ($filterstring=="")
	return "s.student_id > 0";	
else {
	$filterstring =substr_replace($filterstring,"",-3);  

	return "s.student_id > 0 AND $filterstring";
	}
}

?>

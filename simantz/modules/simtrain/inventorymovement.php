<?php
include_once "system.php";
include_once ("menu.php");
include_once "class/Log.php";
//include_once "class/Employee.php";
include_once "class/InventoryMovement.php";
include_once "class/Product.php";
include_once "class/Student.php";
include_once "datepicker/class.datepicker.php";

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new InventoryMovement($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);
$p = new Product($xoopsDB,$tableprefix,$log);
$t = new Student($xoopsDB,$tableprefix,$log);
$showdatefrom=$dp->show("datefrom");
$showdateto=$dp->show("dateto");
$o->showCalender=$dp->show("movementdate");
$action="";
$studentctrl=$t->getStudentSelectBox(0,'Y');
$prdctrl=$p->getSelectProduct(-1,'Y');
echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmInventoryMovement'].documentno.focus();
	}
	function validateMovement(){
		var docno=document.forms['frmInventoryMovement'].documentno.value;
		var movementdate=document.forms['frmInventoryMovement'].movementdate.value;
		var student_id=document.forms['frmInventoryMovement'].student_id.value;
		var qty=document.forms['frmInventoryMovement'].quantity.value;
		
		if(confirm("Save this Record?")){
			if(docno !="" && movementdate!="" && isDate(movementdate) && qty!="" && IsNumeric(qty)){
			if(student_id>0 && qty>=0){
				if(confirm("You'd choose a student here, are you sure this the quantity is +ve?"))
					return true;
				else
					return false;
			}
			else
				return true;
		}
		else{
			alert("Please make sure you fill in document no, and make sure data format for movement date and quantity is correct, type '-' if you don't have any document no.");
			return false;
		}
		}
	else
		return false;

	}
	
</script>
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Search Movement History</span></big></big></big></div><br>-->
<form name="frmSearchMovement" action="inventorymovement.php" method="POST">
<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
  <tbody>
	<tr>
	<th colspan="4" align="center">Search Movement History</th>
	</tr>
    <tr>
      <td class="head">Item</td>
      <td class="odd">$prdctrl</td>
	<td class="head">Student</td>
	<td class="odd">$studentctrl</td>
    </tr>
    <tr>
      <td  class="head">Date From</td>
      <td  class="even"><input type="text" name="datefrom"  id="datefrom"><input type="button" name="btndateto" value='Date'
	 onclick="$showdatefrom"></td>
      <td  class="head">Date To</td>
      <td class="even"><input type="text" name="dateto" id="dateto"><input type="button" name="btndateto" value='Date'
	 onclick="$showdateto"></td>
   </tr>
    <tr>
 <td  class="head">Document No</td>
      <td class="odd"><input type="text" name="documentno"></td>
	<td class="head">Action</td>
	<td class="odd"><input type="submit" value="search" name="action"></td>
    </tr>
  </tbody>	
</table>

</form>
<br>


EOF;


if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->product_id=$_POST['product_id'];
	$o->movement_id=$_POST["movement_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->product_id=$_GET['product_id'];
	$o->movement_id=$_GET["movement_id"];
}
else
$action="";

//search information


$o->documentno=$_POST['documentno'];
$o->movement_description=$_POST['movement_description'];
$o->quantity=$_POST['quantity'];
$o->movementdate=$_POST['movementdate'];
$o->student_id=$_POST['student_id'];
$o->requirepayment=$_POST['requirepayment'];

if($o->requirepayment=='on' || $o->requirepayment=='Y')
 $o->requirepayment='Y';
else
 $o->requirepayment='N';

$o->organization_id=$_POST['organization_id'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

$token=$_POST['token'];


switch ($action){
 case "create":
	if ($s->check(false,$token,"CREATE_MVM")){
		$log->showlog(3,"Saving data for documentno=$o->documentno, and product_id=$o->product_id");
		if($o->insertInventoryMovement()){
		 $latest_id=$o->getLatestInventoryMovementID();
		 redirect_header("inventorymovement.php",$pausetime,"Your data is saved, redirect to create new record.");
		}
		else{
		$log->showLog(1,"Warning! This record cannot save, please verified your data");
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->productctrl=$p->getSelectProduct($o->product_id,"Y");
		
		$o->studentctrl=$t->getStudentSelectBox($o->student_id,'Y');
		$token=$s->createToken($tokenlife,"CREATE_MVM");
		$o->showInputForm('new',0,$token);
		$o->showInventoryMoveTable("WHERE m.movement_id>0 and m.organization_id = $defaultorganization_id ", "order by m.movementdate desc",0,50);

		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"Warning! This record cannot save due to token expired!");
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->productctrl=$p->getSelectProduct($o->product_id,"Y");
		
		$o->studentctrl=$t->getStudentSelectBox($o->student_id,'Y');
		$token=$s->createToken($tokenlife,"CREATE_MVM");
		$o->showInputForm('new',0,$token);
		$o->showInventoryMoveTable("WHERE m.movement_id>0 and m.organization_id = $defaultorganization_id ", "order by m.movementdate desc",0,50);

	}
 break;

 case "update":
	$log->showlog(3,"Saving data for Student_id=$o->student_id, and class_id=$o->studentclass_id");
	if ($s->check(false,$token,"CREATE_MVM")){
		if($o->updateInventoryMovement()) //if data save successfully
			redirect_header("inventorymovement.php?action=edit&movement_id=$o->movement_id",$pausetime,"Your data is saved.");
		else
			redirect_header("inventorymovement.php?action=edit&movement_id=$o->movement_id",$pausetime,"$errorstart Warning! Can't save the data, please make sure all value is insert properly.$errorend");
		}
	else{
		redirect_header("inventorymovement.php?action=edit&movement_id=$o->movement_id",$pausetime,"$errorstart Warning! Can't save the data, due to form's token expired, please re-enter the data.$errorend");
	}
 break;
 case "delete":
	if ($s->check(false,$token,"CREATE_MVM")){
		if($o->deleteInventoryMovement($o->movement_id))
			redirect_header("inventorymovement.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("inventorymovement.php?action=edit&movement_id=$o->movement_id",$pausetime,"$errorstart Warning! Can't delete data from database due to data dependency error.$errorend");
	}
	else
		redirect_header("inventorymovement.php?action=edit&movement_id=$o->movement_id",$pausetime,"$errorstart Warning! Can't delete data from database due to token expired, please re-delete the data.$errorend");
 break;
 case "edit":
	$log->showlog(3,"Editing data movement_id:$o->movement_id");
	if ($o->fetchInventoryMovement($o->movement_id)){
	
		$o->studentctrl=$t->getStudentSelectBox($o->student_id,'Y');
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->productctrl=$p->getSelectProduct($o->product_id,'Y');
		$token=$s->createToken($tokenlife,"CREATE_MVM");
		$o->showInputForm('edit',$o->movement_id,$token);
		$o->showInventoryMoveTable("WHERE m.movement_id>0 and m.organization_id = $defaultorganization_id ", "order by m.movementdate desc",0,50);
	}
	else
		redirect_header("inventorymovement.php?action=edit&movement_id=$o->movement_id",$pausetime,"$errorstart Warning! Can't fetch this data from database, probably database corrupted.$errorend");
 break;
  case "search" :
		$documentno=$_POST['documentno'];
		$datefrom=$_POST['datefrom'];
		$dateto=$_POST['dateto'];
		$product_id=$_POST['product_id'];
		$student_id=$_POST['student_id'];
		$log->showLog(3,"search inventory move with parameter:$datefrom,$dateto,$product_id,$student_id,$documentno");
		$wherestr=genWhereString($datefrom,$dateto,$product_id,$student_id,$documentno);

		$wherestr .= " and m.organization_id = $defaultorganization_id  ";
		
		$o->orgctrl=$permission->selectionOrg($o->createdby,0);
		$o->productctrl=$p->getSelectProduct(0,"Y");
		
		$o->studentctrl=$t->getStudentSelectBox(-1);
		$token=$s->createToken($tokenlife,"CREATE_MVM");
		$o->showInputForm('new',0,$token);
		$o->showInventoryMoveTable($wherestr, "order by m.movementdate desc",0,99999);
 
 break;

 default:
		$o->orgctrl=$permission->selectionOrg($o->createdby,$defaultorganization_id);
		$o->productctrl=$p->getSelectProduct(0,"Y");
		
		$o->studentctrl=$t->getStudentSelectBox(-1);
		$token=$s->createToken($tokenlife,"CREATE_MVM");
		$o->showInputForm('new',0,$token);
		$o->showInventoryMoveTable("WHERE m.movement_id>0 and m.organization_id = $defaultorganization_id ", "order by m.movementdate desc",0,50);
 break;


}


echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');




function genWhereString($datefrom,$dateto,$product_id,$student_id,$documentno){
$filterstring="";
$needand="";
if($student_id > 0 ){
	$filterstring=$filterstring . " m.student_id=$student_id";
	$needand='AND';
}
else
	$needand='';

if($product_id>0){
$filterstring=$filterstring . "  $needand m.product_id = $product_id";
	$needand='AND';
}
else
	$needand='';

if($documentno!=""){
$filterstring=$filterstring . "  $needand m.documentno LIKE '%$documentno%'";
	$needand='AND';
}
else
	$needand='';

if ($datefrom !="" && $dateto!="")
	$filterstring= $filterstring . "  $needand m.movementdate between '$datefrom' and '$dateto'";
if ($filterstring!="")
$filterstring="WHERE m.movement_id>0 AND" . $filterstring;
else
$filterstring="WHERE m.movement_id>0";

return $filterstring;

}
?>

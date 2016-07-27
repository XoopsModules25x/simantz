<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Salesturnover.php';
include_once 'class/Product.php';
include_once 'class/ProductCategory.php';
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Salesturnover($xoopsDB,$tableprefix,$log);
$p = new Product($xoopsDB,$tableprefix,$log);
$c = new ProductCategory($xoopsDB,$tableprefix,$log);
$o->orgctrl="";
$o->categoryctrl="";


$action="";

//marhan add here --> ajax
echo "<iframe src='expenses.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
/////////////////////

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Sales Turn Over Report</span></big></big></big></div><br>

<script type="text/javascript">

	function validateRpt(){
	var start_date = document.forms['frmSearch'].start_date.value;
	var end_date = document.forms['frmSearch'].end_date.value;

	if(start_date=="" || end_date==""){
	alert("Please fill in start date and end date.");
	return false;
	}else
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



 switch ($action){
	//When user submit new organization


  default :
	$o->productctrl=$p->getSelectProduct(0,'N','','Y');
	$o->categoryctrl=$c->getSelectCategory(0,'','Y');
	$o->showSalesturnoverTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

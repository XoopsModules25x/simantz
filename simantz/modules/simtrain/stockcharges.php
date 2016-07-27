<?php
include_once "system.php";
include_once ("menu.php");
include_once './class/Stockcharges.php';
include_once "class/Product.php";
include_once 'class/Log.php';
include_once "datepicker/class.datepicker.php";

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$o = new Stockcharges($xoopsDB, $tableprefix, $log);
$p = new Product($xoopsDB,$tableprefix,$log);
$o->showCalender=$dp->show("movementdate");

echo <<< EOF
<script type="text/javascript">
function getDisplayField(value){
	document.getElementById('idTRStock1').style.display = "none";
	document.getElementById('idTRStock2').style.display = "none";
	document.getElementById('idTRStock3').style.display = "none";
	document.getElementById('idTRCharges').style.display = "none";
	document.forms['frmStockcharges'].amt.value = 0;
	document.forms['frmStockcharges'].movement_description.value = "";
	quantity=document.forms['frmStockcharges'].quantity.value =1;

	if(value == "S"){
	document.getElementById('idTRStock1').style.display = "";
	document.getElementById('idTRStock2').style.display = "";
	document.getElementById('idTRStock3').style.display = "";
	}else
	document.getElementById('idTRCharges').style.display = "";
	
	}

	function autofocus(){
	
		document.forms['frmStockcharges'].amt.focus();
	}

	function validateStockcharges(){
		var amt=document.forms['frmStockcharges'].amt.value;
		var quantity=document.forms['frmStockcharges'].quantity.value;
		var movementdate=document.forms['frmStockcharges'].movementdate.value;

		if(confirm('Save Record?')){	
		if(amt =="" || !IsNumeric(amt) || quantity =="" || !IsNumeric(quantity)){
			alert('Please make sure Charges Amount and Qty is numeric.');
			return false;
		}else{

		if(!isDate(movementdate))
		return false;
		else
		return true;
		}
		}
		return false;
	}
/*
shortcut.add("Ctrl+1",function() {
	alert("Hi there!");
});*/

</script>

EOF;

if (isset ($_POST['action']))
{
	$o->tuitionclass_id=$_POST['tuitionclass_id'];
	$action=$_POST['action'];
}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->tuitionclass_id=$_GET['tuitionclass_id'];
}
else
$action="";

$token=$_POST['token'];
$o->type=$_POST["type"];
$o->amt=$_POST["amt"];
$o->product_id=$_POST['product_id'];
$o->quantity=$_POST['quantity'];
$o->movementdate=$_POST['movementdate'];
$o->movement_description=$_POST['movement_description'];
$o->organization_id=$_POST['organization_id'];

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	if ($s->check(false,$token,"CREATE_AREA")){
		$o->createdby=$xoopsUser->getVar('uid');
		$o->updatedby=$xoopsUser->getVar('uid');
		//$log->showLog(4,"Accessing create record event, with stockcharges name=$o->amt");
		if($o->insertStockcharges()){
		//$latest_id=$o->getLatestStockchargesID();
		redirect_header("tuitionclass.php?action=edit&tuitionclass_id=$o->tuitionclass_id",$pausetime,"Your data is saved. Go to Tuition Class");
		//redirect_header("stockcharges.php?action=edit&tuitionclass_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
		$log->showLog(1, "Warning! Can't save, please verified your data!");
		$token=$s->createToken($tokenlife,"CREATE_AREA");
		$o->productctrl=$p->getSelectProduct(0,"Y");
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",0,$token);
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1, "Warning! Can't save due to token expired!");

		$token=$s->createToken($tokenlife,"CREATE_AREA");
		$o->productctrl=$p->getSelectProduct(0,"Y");
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("new",-1,$token);
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchStockcharges($o->tuitionclass_id)){
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_AREA"); 
		$o->productctrl=$p->getSelectProduct(0,"Y");
		$o->getInputForm("edit",$o->tuitionclass_id,$token);
		//$o->showStockchargesTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("stockcharges.php",3,"<b style='color:red'>Some error on viewing your stockcharges data, probably database corrupted.</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_AREA")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateStockcharges()){ //if data save successfully
		redirect_header("tuitionclass.php?action=edit&tuitionclass_id=$o->tuitionclass_id",$pausetime,"Your data is saved.");	
		//redirect_header("stockcharges.php?action=edit&tuitionclass_id=$o->tuitionclass_id",$pausetime,"Your data is saved.");	
		}else
			redirect_header("stockcharges.php?action=edit&tuitionclass_id=$o->tuitionclass_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->amt', please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("stockcharges.php?action=edit&tuitionclass_id=$o->tuitionclass_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->amt' due to token expired.</b>");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_AREA")){
		if($o->deleteStockcharges($o->tuitionclass_id))
			redirect_header("stockcharges.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("stockcharges.php?action=edit&tuitionclass_id=$o->tuitionclass_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to dependency problem.</b>");
	}
	else
		redirect_header("stockcharges.php?action=edit&tuitionclass_id=$o->tuitionclass_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to token expired.</b>");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_AREA");
	$o->orgctrl=$permission->selectionOrg($o->createdby,$defaultorganization_id);
	$o->productctrl=$p->getSelectProduct(0,"Y");
	$o->getInputForm("new",0,$token);
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>
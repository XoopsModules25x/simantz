<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Promotion.php';
include_once 'class/Customer.php';
include_once 'class/Product.php';
include_once 'class/Employee.php';
include_once 'class/Expensescategory.php';
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Promotion($xoopsDB,$tableprefix,$log);
$c = new Expensescategory($xoopsDB,$tableprefix,$log);
$t = new Customer($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$p = new Product($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);

$o->orgctrl="";
$o->categoryctrl="";


$action="";

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Promotion List</span></big></big></big></div>
<script type="text/javascript">

	function searchPromotion(){//searching
		document.forms['frmSearch'].action.value = "search";
		document.forms['frmSearch'].fldShow.value = "Y";
		document.forms['frmSearch'].submit();
	}

	function showSearch(){//show search form
		document.forms['frmPromotion'].action.value = "search";
		document.forms['frmPromotion'].submit();
	}


	function autofocus(){
	document.forms['frmPromotion'].promotion_desc.focus();
	}

	function showType(type){
		document.getElementById('trCustomer').style.display = "none";
		document.getElementById('trProduct').style.display = "none";
		document.getElementById('idBuyfree').style.display = "none";

		document.forms['frmPromotion'].customer_id.value = 0;
		document.forms['frmPromotion'].product_id.value = 0;
		document.forms['frmPromotion'].promotion_buy.value = 0;
		document.forms['frmPromotion'].promotion_free.value = 0;
		
		if(type=="U")
		document.getElementById('trCustomer').style.display = "";
		if(type=="P")
		document.getElementById('trProduct').style.display = "";
		if(type=="F"){
		document.getElementById('trProduct').style.display = "";
		document.getElementById('idBuyfree').style.display = "";
		}
	}

	function validatePromotion(){
		var desc=document.forms['frmPromotion'].promotion_desc.value;
		var code=document.forms['frmPromotion'].promotion_no.value;
		var amt=document.forms['frmPromotion'].promotion_price.value;
		var buy=document.forms['frmPromotion'].promotion_buy.value;
		var free=document.forms['frmPromotion'].promotion_free.value;
		var effective=document.forms['frmPromotion'].promotion_effective.value;
		var expiry=document.forms['frmPromotion'].promotion_expiry.value;
		
		

		
		if(confirm("Save Record?")){

		if(desc =="" || code==""|| !IsNumeric(amt)|| !IsNumeric(buy)|| !IsNumeric(free)){
			alert('Please make sure Promotion no and name is filled in, Promotion Price, Buy and Free filled with number.');
			return false;
		}else{
			if(!isDate(effective) || !isDate(expiry)){
			//alert('Please make sure Effective Date and Expiry Date filled with date format (YYYY-MM-DD)');
			return false;
			}else
			return true;
		}

		}else
			return false;
	}
</script>

EOF;

$o->category_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->promotion_id=$_POST["promotion_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->promotion_id=$_GET["promotion_id"];

}
else
$action="";
$token=$_POST['token'];

$o->promotion_no=$_POST["promotion_no"];
$o->promotion_desc=$_POST["promotion_desc"];
$o->promotion_type=$_POST["promotion_type"];
$o->customer_id=$_POST["customer_id"];
$o->product_id=$_POST["product_id"];
$o->promotion_price=$_POST["promotion_price"];
$o->promotion_buy=$_POST["promotion_buy"];
$o->promotion_free=$_POST["promotion_free"];
$o->promotion_expiry=$_POST["promotion_expiry"];
$o->promotion_effective=$_POST["promotion_effective"];
$o->promotion_remarks=$_POST["promotion_remarks"];

$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	
$o->organization_id=$_POST["organization_id"];
$o->isAdmin=$xoopsUser->isAdmin();
$isactive=$_POST['isactive'];
$isonepayment=$_POST['isonepayment'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

$o->datectrl=$dp->show("promotion_expiry");
$o->effectivectrl=$dp->show("promotion_effective");

$o->fldShow = $_POST["fldShow"];
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


if ($isonepayment=="Y" or $isonepayment=="on")
	$o->isonepayment='Y';
elseif($isonepayment=="X")
	$o->isonepayment='X';
else
	$o->isonepayment='N';



 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired


	if ($s->check(false,$token,"CREATE_EXP")){
		$log->showLog(4,"Accessing create record event, with product name=$o->promotion_name");
		if($o->insertPromotion()){
			$latest_id=$o->getLatestPromotionID();
			if($filesize>0 || $filetype=='application/pdf')
			$o->savefile($tmpfile);
			redirect_header("promotion.php?action=edit&promotion_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create product!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_EXP");
		$o->customerctrl=$t->getSelectCustomer($o->customer_id);
		$o->productctrl=$p->getSelectProduct($o->product_id);
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);

		$o->getInputForm("new",-1,$token);
		//$o->showPromotionTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchPromotionInfo($o->promotion_id)){
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->customerctrl=$t->getSelectCustomer($o->customer_id);
		$o->productctrl=$p->getSelectProduct($o->product_id);

		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_EXP"); 
		$o->getInputForm("edit",$o->promotion_id,$token);
		//$o->showPromotionTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("promotion.php",3,"Some error on viewing your product data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_EXP")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid

		if($o->updatePromotion()) {
		
		
			redirect_header("promotion.php?action=edit&promotion_id=$o->promotion_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("promotion.php?action=edit&promotion_id=$o->promotion_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("promotion.php?action=edit&promotion_id=$o->promotion_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_EXP")){
		if($o->deletePromotion($o->promotion_id)){
			redirect_header("promotion.php",$pausetime,"Data removed successfully.");
			$o->deletefile($o->promotion_id);
		}
		else
			redirect_header("promotion.php?action=edit&promotion_id=$o->promotion_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("promotion.php?action=edit&promotion_id=$o->promotion_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

  case "search" :

	$o->customerctrl=$t->getSelectCustomer(0);
	$o->productctrl=$p->getSelectProduct(0);
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->showPromotionTable();

  break;

  default :
	$token=$s->createToken($tokenlife,"CREATE_EXP");
	$o->customerctrl=$t->getSelectCustomer(0);
	$o->productctrl=$p->getSelectProduct(0);
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	//$o->showPromotionTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

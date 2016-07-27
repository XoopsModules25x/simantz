<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Product.php';
include_once 'class/Uom.php';

include_once 'class/Employee.php';
include_once 'class/ProductCategory.php';
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Product($xoopsDB,$tableprefix,$log);
$c = new ProductCategory($xoopsDB,$tableprefix,$log);

$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);
$u = new Uom($xoopsDB,$tableprefix,$log);

$o->orgctrl="";
$o->categoryctrl="";


$action="";

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Products List</span></big></big></big></div><br>

<script type="text/javascript">
	
	function searchProduct(){//searching
		document.forms['frmSearch'].action.value = "search";
		document.forms['frmSearch'].fldShow.value = "Y";
		document.forms['frmSearch'].submit();
	}

	function showSearch(){//show search form
		document.forms['frmProduct'].action.value = "search";
		document.forms['frmProduct'].submit();
	}

	function autofocus(){
	document.forms['frmProduct'].product_name.focus();
	}

	function tableFilter(category_id){
	document.forms['frmATZ'].filterstring.value = category_id;
	document.forms['frmATZ'].submit();
	}

	function validateProduct(){
		var name=document.forms['frmProduct'].product_name.value;
		var code=document.forms['frmProduct'].product_no.value;
		var amt=document.forms['frmProduct'].amt.value;
		var last=document.forms['frmProduct'].lastpurchasecost.value;
		var sellingprice=document.forms['frmProduct'].sellingprice.value;
		var safety_level=document.forms['frmProduct'].safety_level.value;

		
		if(confirm("Save Record?")){
		if(name =="" || code==""|| !IsNumeric(amt) || !IsNumeric(sellingprice)|| !IsNumeric(last) || !IsNumeric(safety_level) ){
			alert('Please make sure Product no and name is filled in, Purchase Cost, Selling Price and Safety level filled with number.');
			return false;
		}
		else
			return true;
		}
		else
			return false;
	}
</script>

EOF;


if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->product_id=$_POST["product_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->product_id=$_GET["product_id"];

}
else
$action="";
$token=$_POST['token'];
$o->product_name=$_POST["product_name"];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	

$o->product_no=$_POST["product_no"];
$o->organization_id=$_POST["organization_id"];
$o->sellingprice=$_POST['sellingprice'];
$o->safety_level=$_POST['safety_level'];
$o->amt=$_POST['amt'];
$o->lastpurchasecost=$_POST['lastpurchasecost'];
$o->isAdmin=$xoopsUser->isAdmin();
$o->category_id=$_POST['category_id'];
$o->description=$_POST['description'];
$o->remarks=$_POST['remarks'];
$o->uom_id=$_POST['uom_id'];
$isactive=$_POST['isactive'];
$isdefault=$_POST['isdefault'];
$issales=$_POST['issales'];

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->deleteAttachment=$_POST['deleteAttachment'];
$tmpfile= $_FILES["upload_file"]["tmp_name"];
$filesize=$_FILES["upload_file"]["size"] / 1024;
$filetype=$_FILES["upload_file"]["type"];
$filename=$_FILES["upload_file"]["name"];
if($filename!="")
$withfile='Y';
else
$withfile='N';

$o->fldShow = $_POST["fldShow"];
$o->start_date=$_POST["start_date"];
$o->end_date=$_POST["end_date"];
$o->startctrl=$dp->show("start_date");
$o->endctrl=$dp->show("end_date");

$file_ext = strrchr($filename, '.');
$o->filename=$o->product_id.$file_ext;
$newfilename=$o->product_id.$file_ext;

if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
elseif($isactive=="X")
	$o->isactive='X';
else
	$o->isactive='N';

if ($isdefault=="Y" or $isdefault=="on")
	$o->isdefault='Y';
else
	$o->isdefault='N';

if ($issales=="Y" or $issales=="on")
	$o->issales='Y';
else
	$o->issales='N';


if($o->category_id=="")
$o->category_id=0;


if($_POST['filterstring']!="")
$o->filterstring = $_POST['filterstring'];
else
$o->filterstring = 0;


//$o->filterstring = $o->getFirstCategory();

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired


	if ($s->check(false,$token,"CREATE_PRD")){
		$log->showLog(4,"Accessing create record event, with product name=$o->product_name");
		if($o->insertProduct()){
			$latest_id=$o->getLatestProductID();
			if($filesize>0 || $filetype=='application/pdf')
			$o->savefile($tmpfile);
			redirect_header("product.php?action=edit&product_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create product!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_PRD");
		$o->categoryctrl=$c->getSelectCategory($o->category_id);
		$o->uomctrl=$u->getSelectUom($o->uom_id);
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);

		$o->getInputForm("new",-1,$token);
		$o->showProductTable($o->category_id,$c->getSelectCategory($o->category_id,"onchange='tableFilter(this.value)'")); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchProductInfo($o->product_id)){
		$o->searchAToZ($c->getSelectCategory($o->category_id,"onchange='tableFilter(this.value)'"));
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->categoryctrl=$c->getSelectCategory($o->category_id);
		$o->uomctrl=$u->getSelectUom($o->uom_id);
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_PRD"); 
		$o->getInputForm("edit",$o->product_id,$token);
		$o->showProductTable($o->category_id,$c->getSelectCategory($o->category_id,"onchange='tableFilter(this.value)'")); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("product.php",3,"Some error on viewing your product data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_PRD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateProduct($withfile)) {
			//if data save successfully
			//
			if($o->deleteAttachment=='on')
				$o->deletefile($o->product_id);
			
			if($filesize>0)
				$o->savefile($tmpfile,$newfilename);
		
			redirect_header("product.php?action=edit&product_id=$o->product_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("product.php?action=edit&product_id=$o->product_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("product.php?action=edit&product_id=$o->product_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_PRD")){
		if($o->deleteProduct($o->product_id)){
			redirect_header("product.php",$pausetime,"Data removed successfully.");
			$o->deletefile($o->product_id);
		}
		else
			redirect_header("product.php?action=edit&product_id=$o->product_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("product.php?action=edit&product_id=$o->product_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

  case "search" :
	$o->categoryctrl=$c->getSelectCategory(0);
	$o->uomctrl=$u->getSelectUom(0);
	//$o->showProductTable();
	$o->showProductTable($o->filterstring,$c->getSelectCategory($o->category_id,"onchange='tableFilter(this.value)'"));

  break;

  default :
	//echo $o->category_id;
	$o->searchAToZ($c->getSelectCategory($o->filterstring,"onchange='tableFilter(this.value)'"));
	$token=$s->createToken($tokenlife,"CREATE_PRD");
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->categoryctrl=$c->getSelectCategory(0);
	$o->uomctrl=$u->getSelectUom(0);
	$o->getInputForm("new",0,$token);
	$o->showProductTable($o->filterstring,$c->getSelectCategory($o->category_id,"onchange='tableFilter(this.value)'"));
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

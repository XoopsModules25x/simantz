<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Product.php';
include_once './class/Standard.php';

//include_once 'class/Employee.php';
include_once 'class/ProductCategory.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Product($xoopsDB,$tableprefix,$log);
$c = new ProductCategory($xoopsDB,$tableprefix,$log);
$std= new Standard($xoopsDB,$tableprefix,$log);

$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);

$o->orgctrl="";
$o->categoryctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmProduct'].product_no.focus();
	}

	function validateProduct(){
		var name=document.forms['frmProduct'].product_name.value;
		var code=document.forms['frmProduct'].product_no.value;
		var amt=document.forms['frmProduct'].amt.value;
		var weeklyfees=document.forms['frmProduct'].weeklyfees.value;
		if(confirm("Save Record? \\n\\nWarning! If you change from category to another category may cause data inconsistent at Payment Receiving Report(By Category). You shall not change the category if you'd use this product at any transaction before. However, if you sure item type in both category is same then you can change it without problem.")){
		if(name =="" || code==""|| amt=="" || !IsNumeric(amt) || weeklyfees=="" || !IsNumeric(weeklyfees) ){
			alert('Please make sure Product no and name is filled in, standard and weekly fees feel with number.');
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

$o->category_id=0;
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

$filterstring=$_GET['filterstring'];
$token=$_POST['token'];
$o->product_name=$_POST["product_name"];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	

$o->product_no=$_POST["product_no"];
$o->organization_id=$_POST["organization_id"];
$o->standard_id=$_POST['standard_id'];
$o->weeklyfees=$_POST['weeklyfees'];
$o->amt=$_POST['amt'];
$o->isAdmin=$xoopsUser->isAdmin();
$o->category_id=$_POST['category_id'];
$o->description=$_POST['description'];
$isactive=$_POST['isactive'];
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

$file_ext = strrchr($filename, '.');
$o->filename=$o->product_id.$file_ext;
$newfilename=$o->product_id.$file_ext;


if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';

echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Product Master Record</span></big></big></big></div><br>-->
EOF;
if($filterstring=="")
$filterstring=$o->searchAToZ();
else
$o->searchAToZ();
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
			redirect_header("product.php",$pausetime,"Your data is saved, the new id=$latest_id. Proceed to create another product.");
		}
	else {
		$log->showLog(1,"Warning! '$o->product_name' cannot save, please verified data properly.");
		$token=$s->createToken($tokenlife,"CREATE_PRD");
		$o->categoryctrl=$c->getSelectCategory($o->category_id);
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->standardctrl=$std->getSelectStandard($o->standard_id);

		$o->getInputForm("new",-1,$token);
		$o->showProductTable(); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"Warning! '$o->product_name' cannot save due to token expired.");
		$token=$s->createToken($tokenlife,"CREATE_PRD");
		$o->categoryctrl=$c->getSelectCategory($o->category_id);
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->standardctrl=$std->getSelectStandard($o->standard_id);

		$o->getInputForm("new",-1,$token);
		$o->showProductTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchProductInfo($o->product_id)){
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->categoryctrl=$c->getSelectCategory($o->category_id);
		$o->standardctrl=$std->getSelectStandard($o->standard_id,'Y');

		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_PRD"); 
		$o->getInputForm("edit",$o->product_id,$token);
		$o->showProductTable("WHERE product_name LIKE '$filterstring%' and product_id>0","ORDER BY product_no"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("product.php",3,"<b style='color:red'>Some error on viewing your product data, probably database corrupted</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_PRD")){

		//if($filesize>0 && $filetype!="application/x-php" && $filetype!="text/x-perl" &&
		//			$filetype!="application/x-cgi")
		if($withfile=='Y' && $filetype!="application/x-php" && $filetype!="text/x-perl" &&
					$filetype!="application/x-cgi")
			{
			$o->deletefile($o->product_id);
			$o->savefile($tmpfile,$newfilename);
			}
			else
			$errormsg="<b style='color:red;'> However, your attachment is not save. Please make sure your 
				file extention is not '.php', '.pl', 'cgi'.</b>";
		if($withfile=='N')
			$errormsg="";	
		
			
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateProduct($withfile)) {
			//if data save successfully
			//

			if($o->deleteAttachment=='on')
				$o->deletefile($o->product_id);
				
			redirect_header("product.php?action=edit&product_id=$o->product_id",$pausetime,"Your data is saved.$errormsg");
		}
		else
			redirect_header("product.php?action=edit&product_id=$o->product_id",$pausetime,"<b style='color:red'>Warning! Can't save the data, please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("product.php?action=edit&product_id=$o->product_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->product_name' due to token expired.");
	}
  break;
  case "search" :
	$category_id=$_POST['category_id'];
	$product_name=$_POST['product_name'];
	$isactive=$_POST['isactive'];
	$product_no=$_POST['product_no'];
	$standard_id=$_POST['standard_id'];
	
	$wherestr=generateWhereStr($isactive,$product_no,$product_name,$category_id,$standard_id);
	$o->categoryctrl=$c->getSelectCategory(-1);
	$o->standardctrl=$std->getSelectStandard(-1);
	$o->showSearchForm();
	$o->showProductTable($wherestr,"ORDER BY product_no");

  break;
  case "searchproduct":
	
		$o->categoryctrl=$c->getSelectCategory(-1);
		$o->standardctrl=$std->getSelectStandard(-1);
		$o->showSearchForm();

  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_PRD")){
		if($o->deleteProduct($o->product_id)){
			redirect_header("product.php",$pausetime,"Data removed successfully.");
			$o->deletefile($o->product_id);
		}
		else
			redirect_header("product.php?action=edit&product_id=$o->product_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to data dependency error.");
	}
	else
		redirect_header("product.php?action=edit&product_id=$o->product_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to token expired.</b>");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_PRD");
	$o->orgctrl=$permission->selectionOrg($o->createdby,0);
	$o->standardctrl=$std->getSelectStandard(0,'Y');
	$o->categoryctrl=$c->getSelectCategory(0);
	$o->getInputForm("new",0,$token);
	$o->showProductTable("WHERE product_name LIKE '$filterstring%' and product_id>0","ORDER BY product_no");
  break;

}

function generateWhereStr($isactive,$product_no,$product_name,$category_id,$standard_id){
$filterstring="";

if ($isactive!="-"){
$filterstring=$filterstring . " p.isactive = '$isactive' AND";
}

if ($product_no!="")
$filterstring=$filterstring . " p.product_no LIKE '$product_no' AND";

if ($product_name!="")
$filterstring=$filterstring . " p.product_name LIKE '$product_name' AND";

if ($category_id!=0)
$filterstring=$filterstring . " p.category_id = '$category_id' AND";

if ($standard_id!=0)
$filterstring=$filterstring . " p.standard_id LIKE '$standard_id' AND";


if ($filterstring=="")
	return "WHERE product_id>0";
else {
	$filterstring =substr_replace($filterstring,"",-3);  

	return "WHERE product_id>0 AND $filterstring";
	}
}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

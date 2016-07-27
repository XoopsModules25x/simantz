<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/ProductCategory.php';
include_once 'class/Employee.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new ProductCategory($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function validateCategory(){
		var code=document.forms['frmCategory'].category_code.value;
		if(confirm("Save Record? \\n\\nWarning! If you change record from item type to another item type may cause data inconsistent at Payment Receiving Report(By Category). You shall not change the item type if you'd use any product under this category at any transaction before.")){
		if( code==""){
			alert('Please make sure Category Code is filled in.');
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
	$o->category_id=$_POST["category_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->category_id=$_GET["category_id"];

}
else
$action="";

$token=$_POST['token'];
$o->category_description=$_POST["category_description"];
$o->category_code=$_POST["category_code"];
$o->organization_id=$_POST["organization_id"];

$isactive=$_POST['isactive'];

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

//if ($isitem=="on" || $isitem=="Y")
//	$o->isitem='Y';
//else
//	$o->isitem='N';

$o->isitem=$_POST['isitem'];

if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with category name=$o->category_name");

	if ($s->check(false,$token,"CREATE_CAT")){
		
		
		
	if($o->insertCategory()){
		 $latest_id=$o->getLatestCategoryID();
			 redirect_header("category.php?action=edit&category_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create category!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_CAT");
		$o->orgctrl=$e->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showCategoryTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchCategory($o->category_id)){
		//create a new token for editing a form
		$token=$s->createToken(120,"CREATE_CAT"); 
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->category_id,$token);
		$o->showCategoryTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("category.php",3,"Some error on viewing your category data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_CAT")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateCategory()) //if data save successfully
			redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Your data is saved.");
		else
			redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_CAT")){
		if($o->deleteCategory($o->category_id))
			redirect_header("category.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken(120,"CREATE_CAT");
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showCategoryTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

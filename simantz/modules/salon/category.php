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
	function autofocus(){
	document.forms['frmCategory'].category_description.focus();
	}

	function validateCategory(){
		var code=document.forms['frmCategory'].category_code.value;
		if(confirm("Save Record?")){
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
$o->remarks=$_POST["remarks"];
$o->category_code=$_POST["category_code"];
$o->organization_id=$_POST["organization_id"];

$isactive=$_POST['isactive'];
$isdefault=$_POST['isdefault'];
$issales=$_POST['issales'];

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

$o->deleteAttachment=$_POST['deleteAttachment'];
$tmpfile= $_FILES["upload_file"]["tmp_name"];
$filesize=$_FILES["upload_file"]["size"] / 1024;
$filetype=$_FILES["upload_file"]["type"];
$filename=$_FILES["upload_file"]["name"];
$error=$_FILES["upload_file"]["error"];

if($filename!="")
$withfile='Y';
else
$withfile='N';



$file_ext = strrchr($filename, '.');
$o->filename=$o->category_id.$file_ext;
$newfilename=$o->category_id.$file_ext;


//if ($isitem=="on" || $isitem=="Y")
//	$o->isitem='Y';
//else
//	$o->isitem='N';

$o->isitem=$_POST['isitem'];

if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
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


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with category name=$o->category_name");

	if ($s->check(false,$token,"CREATE_CAT")){
		
		
		
	if($o->insertCategory()){
		 $latest_id=$o->getLatestCategoryID();
			if($filesize>0 || $filetype=='application/pdf')
			$o->savefile($tmpfile);
			 redirect_header("category.php?action=edit&category_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create category!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_CAT");
		$o->orgctrl=$e->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showCategoryTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchCategory($o->category_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_CAT"); 
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
		if($o->updateCategory($withfile)){ //if data save successfully

				if($o->deleteAttachment=='on')
				$o->deletefile($o->category_id);
			
				if($filesize>0)
				$o->savefile($tmpfile,$newfilename);

			redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Your data is saved.");
		}else{
			redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
		}
	else{
		redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_CAT")){
		if($o->deleteCategory($o->category_id)){
			$o->deletefile($o->category_id);
			redirect_header("category.php",$pausetime,"Data removed successfully.");
		}else{
			redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Warning! Can't delete data from database.");
		}
	}
	else
		redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_CAT");
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showCategoryTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

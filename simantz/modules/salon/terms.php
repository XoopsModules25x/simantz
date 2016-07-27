<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Terms.php';
include_once 'class/Employee.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Terms($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	document.forms['frmTerms'].terms_description.focus();
	}

	function validateTerms(){
		var code=document.forms['frmTerms'].terms_code.value;
		var desc=document.forms['frmTerms'].terms_description.value;
		if(confirm("Save Record?")){
		if( code=="" || desc==""){
			alert('Please make sure Code and Description is filled in.');
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

$o->terms_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->terms_id=$_POST["terms_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->terms_id=$_GET["terms_id"];

}
else
$action="";

$token=$_POST['token'];
$o->terms_description=$_POST["terms_description"];
$o->remarks=$_POST["remarks"];
$o->terms_code=$_POST["terms_code"];
$o->organization_id=$_POST["organization_id"];

$isactive=$_POST['isactive'];

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();



if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with terms name=$o->terms_name");

	if ($s->check(false,$token,"CREATE_CAT")){
		
		
		
	if($o->insertTerms()){
		 $latest_id=$o->getLatestTermsID();
			 redirect_header("terms.php?action=edit&terms_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create terms!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_CAT");
		$o->orgctrl=$e->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showTermsTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchTerms($o->terms_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_CAT"); 
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->terms_id,$token);
		$o->showTermsTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("terms.php",3,"Some error on viewing your terms data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_CAT")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateTerms()) //if data save successfully
			redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Your data is saved.");
		else
			redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_CAT")){
		if($o->deleteTerms($o->terms_id))
			redirect_header("terms.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	
	$token=$s->createToken($tokenlife,"CREATE_CAT");
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showTermsTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

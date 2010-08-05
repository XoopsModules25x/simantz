<?php
include "system.php";
include "menu.php";
include_once 'class/Terms.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$o = new Terms();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
function IsNumeric(sText)
{
   var ValidChars = "0123456789.-";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
   }


	function validateTerms(){
		
		var name=document.forms['frmTerms'].terms_name.value;
		var daycount=document.forms['frmTerms'].daycount.value;
		var defaultlevel=document.forms['frmTerms'].defaultlevel.value;
	
		if(confirm("Save record?")){
		if(name =="" || !IsNumeric(defaultlevel) || defaultlevel=="" || !IsNumeric(daycount) || daycount==""){
			alert('Please make sure name is filled in, Default Level,Due Day is filled with numeric value');
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

$o->terms_name=$_POST["terms_name"];

$isactive=$_POST['isactive'];
$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->daycount=$_POST['daycount'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

if ($isactive==1 or $isactive=="on")
	$o->isactive=1;
else
	$o->isactive=0;


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with terms name=$o->terms_name");

	if ($s->check(true,$token,"CREATE_ACG")){
		
		
		
	if($o->insertTerms()){
		 $latest_id=$o->getLatestTermsID();
			 redirect_header("terms.php",$pausetime,"Your data is saved, redirect to create more record.");
		}
	else {
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
                $log->showLog(1, "Cannot create record! Please make sure this record is unique and data is valid.");

                $o->getInputForm("new",-1,$token);
		$o->showTermsTable("WHERE terms_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,terms_name"); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_ACG");
                $log->showLog(1, "Cannot create record due to token expired.");
                $o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->getInputForm("new",-1,$token);
		$o->showTermsTable("WHERE terms_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,terms_name"); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchTerms($o->terms_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->getInputForm("edit",$o->terms,$token);
		$o->showTermsTable("WHERE terms_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,terms_name"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("terms.php",3,"Some error on viewing your terms data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(true,$token,"CREATE_ACG")){
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
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteTerms($o->terms_id))
			redirect_header("terms.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	$o->getInputForm("new",0,$token);
	$o->showTermsTable("WHERE terms_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,terms_name");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

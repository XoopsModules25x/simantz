<?php
include "system.php";
include "menu.php";
include_once 'class/Log.php';
include_once 'class/Tax.php';
include_once 'class/SelectCtrl.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$o = new Tax();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
function autofocus(){
document.forms['frmTax'].tax_name.focus();
}
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


	function validateTax(){
		
		var name=document.forms['frmTax'].tax_name.value;
		var istax=document.forms['frmTax'].istax.value;
		var defaultlevel=document.forms['frmTax'].defaultlevel.value;
	
		if(confirm("Save record?")){
		if(name =="" || !IsNumeric(defaultlevel) || defaultlevel=="" ){
			alert('Please make sure name is filled in, Default Level filled with numeric value');
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

$o->tax_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->tax_id=$_POST["tax_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->tax_id=$_GET["tax_id"];

}
else
$action="";

$token=$_POST['token'];

$o->tax_name=$_POST["tax_name"];

$isactive=$_POST['isactive'];
$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->istax=$_POST['istax'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

if ($isactive==1 or $isactive=="on")
	$o->isactive=1;
else
	$o->isactive=0;

if ($o->istax==1 or $o->istax=="on")
	$o->istax=1;
else
	$o->istax=0;


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with tax name=$o->tax_name");

	if ($s->check(false,$token,"CREATE_ACG")){
		
		
		
	if($o->insertTax()){
		 $latest_id=$o->getLatestTaxID();
			 redirect_header("tax.php?action=edit&tax_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->getInputForm("new",-1,$token);
		$o->showTaxTable("WHERE tax_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,tax_name"); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->getInputForm("new",-1,$token);
		$o->showTaxTable("WHERE tax_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,tax_name"); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchTax($o->tax_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->getInputForm("edit",$o->tax,$token);
		$o->showTaxTable("WHERE tax_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,tax_name"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("tax.php",3,"Some error on viewing your tax data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateTax()) //if data save successfully
			redirect_header("tax.php?action=edit&tax_id=$o->tax_id",$pausetime,"Your data is saved.");
		else
			redirect_header("tax.php?action=edit&tax_id=$o->tax_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("tax.php?action=edit&tax_id=$o->tax_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteTax($o->tax_id))
			redirect_header("tax.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("tax.php?action=edit&tax_id=$o->tax_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("tax.php?action=edit&tax_id=$o->tax_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	$o->getInputForm("new",0,$token);
	$o->showTaxTable("WHERE tax_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,tax_name");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Currency.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Currency($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);


$action="";

echo <<< EOF
<script type="text/javascript">
	function validateCurrency(){
		var name=document.forms['frmCurrency'].currency_symbol.value;
		if(confirm('Save Record?')==true){
			if(name =="" ){
				alert('Please make sure Currency name is filled in.');
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

$o->currency_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->currency_id=$_POST["currency_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->currency_id=$_GET["currency_id"];

}
else
$action="";

$token=$_POST['token'];

$o->currency_description=$_POST["currency_description"];
$o->currency_symbol=$_POST["currency_symbol"];
$isdefault=$_POST['isdefault'];
$isactive=$_POST['isactive'];

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');


if ($isactive=="1" or $isactive=="on")
	$o->isactive='1';
else
	$o->isactive='0';

if ($isdefault=="1" or $isdefault=="on")
	$o->isdefault='1';
else
	$o->isdefault='0';

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with currency name=$o->currency_symbol");

	if ($s->check(false,$token,"CREATE_RCS")){
		
		
		
	if($o->insertCurrency()){
		 $latest_id=$o->getLatestCurrencyID();
			 redirect_header("currency.php?action=edit&currency_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create currency!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_RCS");
	//	$o->orgctrl=$e->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showCurrencyTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchCurrency($o->currency_id)){
		//create a new token for editing a form
		$token=$s->createToken(120,"CREATE_RCS"); 
	//	$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->currency,$token);
		$o->showCurrencyTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("currency.php",3,"Some error on viewing your currency data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_RCS")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateCurrency()) //if data save successfully
			redirect_header("currency.php?action=edit&currency_id=$o->currency_id",$pausetime,"Your data is saved.");
		else
			redirect_header("currency.php?action=edit&currency_id=$o->currency_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("currency.php?action=edit&currency_id=$o->currency_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_RCS")){
		if($o->deleteCurrency($o->currency_id))
			redirect_header("currency.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("currency.php?action=edit&currency_id=$o->currency_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("currency.php?action=edit&currency_id=$o->currency_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken(120,"CREATE_RCS");
	//$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showCurrencyTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

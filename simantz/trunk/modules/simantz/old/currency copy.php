<?php
include "system.php";
include "menu.php";
include_once 'class/Log.php';
include_once 'class/Currency.php';
include_once "class/ConversionRate.php";
include_once 'class/SelectCtrl.php';



$log = new Log();
$o = new Currency();
$cvr = new ConversionRate();
$s = new XoopsSecurity();
$ctrl=new SelectCtrl();
//$orgctrl="";


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


	function validateCurrency(){
		var name=document.forms['frmCurrency'].currency_name.value;
		var currency_code=document.forms['frmCurrency'].currency_code.value;
		var defaultlevel=document.forms['frmCurrency'].defaultlevel.value;		
		if(name =="" || currency_code=="" || !IsNumeric(defaultlevel) || defaultlevel==""){
			alert('Please make sure Currency name, currency_code is filled in, seq no is filled with numeric value');
			return false;
		}
		else
			return true;
	}
</script>

EOF;

$o->currency_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->currency_id=$_POST["currency_id"];
	$cvr->currencyfrom_id=$o->currency_id;


}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->currency_id=$_GET["currency_id"];
	$cvr->currencyfrom_id=$o->currency_id;
}
else
$action="";

$token=$_POST['token'];
$o->country_id=$_POST["country_id"];
$o->currency_name=$_POST["currency_name"];
$o->currency_code=$_POST['currency_code'];
$isactive=$_POST['isactive'];
$cvr->new_currencyto_id=$_POST['new_currencyto_id'];
$cvr->new_multiplyvalue=$_POST['new_multiplyvalue'];
$cvr->new_effectivedate=$_POST['new_effectivedate'];
$cvr->new_description=$_POST['new_description'];
$cvr->new_isactive=$_POST['new_isactive'];

$cvr->lineconversion_id=$_POST['lineconversion_id'];
$cvr->linecurrencyto_id=$_POST['linecurrencyto_id'];
$cvr->linemultiplyvalue=$_POST['linemultiplyvalue'];
$cvr->lineeffectivedate=$_POST['lineeffectivedate'];
$cvr->linedescription=$_POST['linedescription'];
$cvr->lineisactive=$_POST['lineisactive'];


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
	$log->showLog(4,"Accessing create record event, with currency name=$o->currency_name");

	if ($s->check(false,$token,"CREATE_WDW")){
		
		
		
	if($o->insertCurrency()){
		 $latest_id=$o->getLatestCurrencyID();
			 redirect_header("currency.php?action=edit&currency_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {

		$token=$s->createToken($tokenlife,"CREATE_WDW");
		$o->countryctrl=$ctrl->getSelectCountry($o->country_id,'N');
	//	$log->showLog(1,__FILE__ . ",Line:". __LINE__. ",Data cannot be created");

		$o->getInputForm("new",-1,$token);
		$o->showCurrencyTable("WHERE currency_id>0","ORDER BY cur.defaultlevel,cur.currency_name"); 

		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_WDW");
		$o->countryctrl=$ctrl->getSelectCountry($o->country_id,'N');

		$o->getInputForm("new",-1,$token);
		$o->showCurrencyTable("WHERE currency_id>0","ORDER BY cur.defaultlevel,cur.currency_name"); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchCurrency($o->currency_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_WDW"); 
		$o->countryctrl=$ctrl->getSelectCountry($o->country_id,'N');
		$o->conversiontable=$cvr->showConversionTable($o->currency_id);
		$o->getInputForm("edit",$o->currency,$token);

		$o->showCurrencyTable("WHERE currency_id>0","ORDER BY cur.defaultlevel,cur.currency_name"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("currency.php",3,"Some error on viewing your currency data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_WDW")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateCurrency()){ //if data save successfully
			$cvr->save();
			redirect_header("currency.php?action=edit&currency_id=$o->currency_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("currency.php?action=edit&currency_id=$o->currency_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("currency.php?action=edit&currency_id=$o->currency_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_WDW")){
		if($o->deleteCurrency($o->currency_id))
			redirect_header("currency.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("currency.php?action=edit&currency_id=$o->currency_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("currency.php?action=edit&currency_id=$o->currency_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken(120,"CREATE_WDW");
	$o->countryctrl=$ctrl->getSelectCountry(0,'N');
	//$o->orgctrl=$selectionOrg->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showCurrencyTable("WHERE currency_id>0","ORDER BY cur.defaultlevel,cur.currency_name");
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

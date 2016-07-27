<?php
include "system.php";
include "menu.php";
include_once 'class/Log.php';
include_once 'class/Country.php';



$log = new Log();
$o = new Country($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);

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


	function validateCountry(){
		var name=document.forms['frmCountry'].country_name.value;
		var country_code=document.forms['frmCountry'].country_code.value;
		var defaultlevel=document.forms['frmCountry'].defaultlevel.value;		
		if(name =="" || country_code=="" || !IsNumeric(defaultlevel) || defaultlevel==""){
			alert('Please make sure country name, country_code is filled in, default level is filled with numeric value');
			return false;
		}
		else
			return true;
	}
</script>

EOF;

$o->country_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->country_id=$_POST["country_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->country_id=$_GET["country_id"];

}
else
$action="";

$token=$_POST['token'];

$o->country_name=$_POST["country_name"];
$o->country_code=$_POST['country_code'];
$isactive=$_POST['isactive'];

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
	$log->showLog(4,"Accessing create record event, with country name=$o->country_name");

	if ($s->check(false,$token,"CREATE_WDW")){
		
		
		
	if($o->insertCountry()){
		 $latest_id=$o->getLatestCountryID();
			 redirect_header("country.php?action=edit&country_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
			$token=$s->createToken(120,"CREATE_WDW");

		$o->getInputForm("new",-1,$token);
		$o->showCountryTable("WHERE country_id>0","ORDER BY defaultlevel,country_name"); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_WDW");

		$o->getInputForm("new",-1,$token);
		$o->showCountryTable("WHERE country_id>0","ORDER BY defaultlevel,country_name"); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchCountry($o->country_id)){
		//create a new token for editing a form
		$token=$s->createToken(120,"CREATE_WDW"); 

		$o->getInputForm("edit",$o->country,$token);
		$o->showCountryTable("WHERE country_id>0","ORDER BY defaultlevel,country_name"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("country.php",3,"Some error on viewing your country data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_WDW")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateCountry()) //if data save successfully
			redirect_header("country.php?action=edit&country_id=$o->country_id",$pausetime,"Your data is saved.");
		else
			redirect_header("country.php?action=edit&country_id=$o->country_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("country.php?action=edit&country_id=$o->country_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_WDW")){
		if($o->deleteCountry($o->country_id))
			redirect_header("country.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("country.php?action=edit&country_id=$o->country_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("country.php?action=edit&country_id=$o->country_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken(120,"CREATE_WDW");
	//$o->orgctrl=$selectionOrg->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	$o->showCountryTable("WHERE country_id>0","ORDER BY defaultlevel,country_name");
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

<?php
include "system.php";
include "menu.php";

include_once 'class/Address.php.inc';
include_once '../system/class/Log.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


//global $log ;
$o = new Address();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">

	function gotoAction(action){
	document.forms['frmAddress'].action.value = action;
	document.forms['frmAddress'].submit();
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


	function validateAddress(){

		var code=document.forms['frmAddress'].address_code.value;
		var name=document.forms['frmAddress'].address_name.value;
		var defaultlevel=document.forms['frmAddress'].defaultlevel.value;

		if(confirm("Save record?")){
		if(name =="" || !IsNumeric(defaultlevel) || defaultlevel=="" || code==""){
			alert('Please make sure Code and Name is filled in, Default Level is filled with numeric value');
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

$o->address_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->address_id=$_POST["address_id"];
	$o->bpartner_id=$_POST['bpartner_id'];
}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->address_id=$_GET["address_id"];
	$o->bpartner_id=$_GET['bpartner_id'];
}
else
$action="";

$token=$_POST['token'];


	$o->address_name=$_POST['address_name'];
	$o->isactive=$_POST['isactive'];
	$o->isshipment=$_POST['isshipment'];
	$o->isinvoice=$_POST['isinvoice'];

	$o->address_street=$_POST['address_street'];
	$o->address_postcode=$_POST['address_postcode'];
	$o->address_city=$_POST['address_city'];
	$o->region_id=$_POST['region_id'];
	$o->country_id=$_POST['country_id'];
	$o->organization_id=$defaultorganization_id;

	$o->tel_1=$_POST['tel_1'];
	$o->tel_2=$_POST['tel_2'];
	$o->fax=$_POST['fax'];
	$o->description=$_POST['description'];
	$o->defaultlevel=$_POST['defaultlevel'];

    $o->isAdmin=$xoopsUser->isAdmin();
    $o->createdby=$xoopsUser->getVar('uid');
    $o->updatedby=$xoopsUser->getVar('uid');
    $timestamp= date("y/m/d H:i:s", time()) ;
    $o->updated=$timestamp;
    $o->created=$timestamp;
    $o->updatesql="";
    $isactive=$_POST['isactive'];

$o->issearch=$_POST['issearch'];

if ($isactive=="1" || $isactive=="on")
	$o->isactive=1;
else if ($isactive=="null")
	$o->isactive="null";
else
	$o->isactive=0;


if ($o->isshipment=="1" || $o->isshipment=="on")
	$o->isshipment=1;
else if ($o->isshipment=="null")
	$o->isshipment="null";
else
	$o->isshipment=0;


if ($o->isinvoice=="1" || $o->isinvoice=="on")
	$o->isinvoice=1;
else if ($o->isinvoice=="null")
	$o->isinvoice="null";
else
	$o->isinvoice=0;



 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with address name=$o->address_name,$o->bpartner_id");

	if ($s->check(true,$token,"CREATE_ADD")){
 


	if($o->insertAddress()){
		 $latest_id=$o->getLatestAddressID();
         $log->saveLog($latest_id, $tableproductaddress, $o->updatesql, "I", "O");
			 redirect_header("bpartner.php?action=view&bpartner_id=$o->bpartner_id",$pausetime,"Your data is saved, redirect to create more record.");
		}
	else {
        $log->saveLog(0, $tableproductaddress, $o->updatesql, "I", "F");
        redirect_header("bpartner.php?action=view&bpartner_id=$o->bpartner_id",$pausetime,"Warning! Your data cannot saved, redirect to business partner");
    }
    }
    else
    		redirect_header("bpartner.php?action=view&bpartner_id=$o->bpartner_id",3,"Cannot save address due to token expired.");

break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchAddress($o->address_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ADD");
        $o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id, 'N');
        $o->countryctrl=$ctrl->getSelectCountry($o->country_id,'Y');

        $o->regionctrl=$ctrl->getSelectRegion($o->region_id,'Y');
		$o->getInputForm("edit",$o->address_id,$token);
//		$o->showAddressTable("WHERE address_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,address_name");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("address.php",3,"Some error on viewing your address data, probably database corrupted");

break;
	//when user request to edit particular organization
 
  case "update" :
	if ($s->check(true,$token,"CREATE_ADD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateAddress()) {//if data save successfully
           $log->saveLog($o->address_id, $tableproductaddress, $o->updatesql, "U", "O");
			redirect_header("bpartner.php?action=view&bpartner_id=$o->bpartner_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->address_id, $tableproductaddress, $o->updatesql, "U", "F");
			redirect_header("address.php?action=edit&address_id=$o->address_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog($o->address_id, $tableproductaddress, $o->updatesql, "U", "F");
		redirect_header("address.php?action=edit&address_id=$o->address_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(true,$token,"CREATE_ADD")){
		if($o->deleteAddress($o->address_id)){
            $log->saveLog($o->address_id, $tableproductaddress, $o->updatesql, "D", "O");
			redirect_header("bpartner.php?action=view&bpartner_id=$o->bpartner_id",$pausetime,"Data removed successfully.");
        }
		else{
            $log->saveLog($o->address_id, $tableproductaddress, $o->updatesql, "D", "F");
			redirect_header("address.php?action=edit&address_id=$o->address_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else{
        $log->saveLog($o->address_id, $tableproductaddress, $o->updatesql, "D", "F");
		redirect_header("address.php?action=edit&address_id=$o->address_id",$pausetime,"Warning! Can't delete data from database.");
    }



  default :
	

	$token=$s->createToken($tokenlife,"CREATE_ADD");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
		$o->sellaccountsctrl=$ctrl->getSelectAccounts($o->defaultsellaccount_id,'Y',"","defaultsellaccount_id","AND placeholder=0");
   		$o->buyaccountsctrl=$ctrl->getSelectAccounts($o->defaultbuyaccount_id,'Y',"","defaultbuyaccount_id","AND placeholder=0");
        $o->issueaccountsctrl=$ctrl->getSelectAccounts($o->defaultissueaccount_id,'Y',"","defaultissueaccount_id","AND placeholder=0");
        $o->stockadjustaccountsctrl=$ctrl->getSelectAccounts($o->defaultstockadjustaccount_id,'Y',"","defaultstockadjustaccount_id","AND placeholder=0");

	$o->getInputForm("new",0,$token);
	$o->showAddressTable("WHERE address_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,address_name");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

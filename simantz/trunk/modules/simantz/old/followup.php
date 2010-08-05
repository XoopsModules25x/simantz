<?php
include "system.php";
include "menu.php";

include_once 'class/FollowUp.php.inc';
include_once '../system/class/Log.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
include_once "../../class/datepicker/class.datepicker.php";
//include_once "../system/class/Period.php";
$dp=new datepicker($url);

//global $log ;
$o = new FollowUp();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">

	function gotoAction(action){
	document.forms['frmFollowUp'].action.value = action;
	document.forms['frmFollowUp'].submit();
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


	function validateFollowUp(){

		var code=document.forms['frmFollowUp'].followup_code.value;
		var name=document.forms['frmFollowUp'].followup_name.value;
		var defaultlevel=document.forms['frmFollowUp'].defaultlevel.value;

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

$o->followup_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->followup_id=$_POST["followup_id"];
	$o->bpartner_id=$_POST['bpartner_id'];
}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->followup_id=$_GET["followup_id"];
	$o->bpartner_id=$_GET['bpartner_id'];
}
else
$action="";

$token=$_POST['token'];



	$o->followup_name=$_POST['followup_name'];
	$o->alternatename=$_POST['alternatename'];
	$o->issuedate=$_POST['issuedate'];
	$o->email=$_POST['email'];
	$o->contactperson=$_POST['contactperson'];
	$o->nextfollowupdate=$_POST['nextfollowupdate'];
	$o->contactnumber=$_POST['contactnumber'];
	$o->fax=$_POST['fax'];
	$o->followuptype_id=$_POST['followuptype_id'];
	$o->position=$_POST['position'];
	$o->department=$_POST['department'];
	$o->uid=$_POST['uid'];
        $o->employee_id=$_POST['employee_id'];
        $o->religion_id=$_POST['religion_id'];
	$o->description=$_POST['description'];
	$o->organization_id=$defaultorganization_id;

	$o->isactive=$_POST['isactive'];
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




 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with followup name=$o->followup_name,$o->bpartner_id");

	if ($s->check(true,$token,"CREATE_FOLLOWUP")){



	if($o->insertFollowUp()){
		 $latest_id=$o->getLatestFollowUpID();
         $log->saveLog($latest_id, $tablefollowup, $o->updatesql, "I", "O");
			 redirect_header("bpartner.php?action=view&bpartner_id=$o->bpartner_id",$pausetime,"Your data is saved, redirect to create more record.");
		}
	else {
        $log->saveLog(0, $tablefollowup, $o->updatesql, "I", "F");
        redirect_header("bpartner.php?action=view&bpartner_id=$o->bpartner_id",$pausetime,"Warning! Your data cannot saved, redirect to business partner");
    }
    }
    else
    		redirect_header("bpartner.php?action=view&bpartner_id=$o->bpartner_id",3,"Cannot save followup due to token expired.");

break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchFollowUp($o->followup_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_FOLLOWUP");
        $o->bpartnerctrl=$ctrl->getSelectBPartner($o->bpartner_id, 'N');
        $o->countryctrl=$ctrl->getSelectCountry($o->country_id,'Y');
        $o->followuptypectrl=$ctrl->getSelectfollowuptype($o->followuptype_id,'Y');
        $o->userctrl=$ctrl->getSelectUsers($o->uid,'Y');
        $o->regionctrl=$ctrl->getSelectRegion($o->region_id,'Y');
        $o->employeectrl=$ctrl->getSelectemployee($o->employee_id, "Y");
        $o->religionctrl=$ctrl->getSelectReligion($o->religion_id, "Y");

        $o->getInputForm("edit",$o->followup_id,$token);
//		$o->showFollowUpTable("WHERE followup_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,followup_name");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("followup.php",3,"Some error on viewing your followup data, probably database corrupted");

break;
	//when user request to edit particular organization

  case "update" :
	if ($s->check(true,$token,"CREATE_FOLLOWUP")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateFollowUp()) {//if data save successfully
           $log->saveLog($o->followup_id, $tablefollowup, $o->updatesql, "U", "O");
			redirect_header("bpartner.php?action=view&bpartner_id=$o->bpartner_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->followup_id, $tablefollowup, $o->updatesql, "U", "F");
			redirect_header("followup.php?action=edit&followup_id=$o->followup_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog($o->followup_id, $tablefollowup, $o->updatesql, "U", "F");
		redirect_header("followup.php?action=edit&followup_id=$o->followup_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(true,$token,"CREATE_FOLLOWUP")){
		if($o->deleteFollowUp($o->followup_id)){
            $log->saveLog($o->followup_id, $tablefollowup, $o->updatesql, "D", "O");
			redirect_header("bpartner.php?action=view&bpartner_id=$o->bpartner_id",$pausetime,"Data removed successfully.");
        }
		else{
            $log->saveLog($o->followup_id, $tablefollowup, $o->updatesql, "D", "F");
			redirect_header("followup.php?action=edit&followup_id=$o->followup_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else{
        $log->saveLog($o->followup_id, $tablefollowup, $o->updatesql, "D", "F");
		redirect_header("followup.php?action=edit&followup_id=$o->followup_id",$pausetime,"Warning! Can't delete data from database.");
    }



  default :


	$token=$s->createToken($tokenlife,"CREATE_FOLLOWUP");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');

	$o->getInputForm("new",0,$token);
	$o->showFollowUpTable("WHERE followup_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,followup_name");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

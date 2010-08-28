<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once 'class/Reminder.php';
//include_once 'class/SelectCtrl.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


//$log = new Log();
$o = new Reminder();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
function autofocus(){
document.forms['frmReminder'].reminder_title.focus();
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


	function validateReminder(){

		var name=document.forms['frmReminder'].reminder_title.value;
		var defaultlevel=document.forms['frmReminder'].defaultlevel.value;


		if(confirm("Save record?")){
		if(name =="" || !IsNumeric(defaultlevel) || defaultlevel==""){
			alert('Please make sure REminder Title is filled in');
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

$o->reminder_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->reminder_id=$_POST["reminder_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->reminder_id=$_GET["reminder_id"];

}
else
$action="";

$token=$_POST['token'];

$o->reminder_title=$_POST["reminder_title"];
$o->reminder_body=$_POST["reminder_body"];
$o->reminder_footer=$_POST['reminder_footer'];
$o->organization_id=$_POST['organization_id'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();
$isactive=$_POST['isactive'];
if ($isactive==1 or $isactive=="on")
	$o->isactive=1;
else
	$o->isactive=0;


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with reminder title=$o->reminder_title");

	if ($s->check(false,$token,"CREATE_ACG")){



	if($o->insertReminder()){
	$latest_id=$o->getLatestReminderID();
         $log->saveLog($latest_id,$tablereminder,"$o->changesql","I","O");
			 redirect_header("reminder.php",$pausetime,"Your data is saved. Create More Records");
		}
	else {
        $log->saveLog(0,$tablereminder,"$o->changesql","I","F");
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->getInputForm("new",-1,$token);
		$o->showReminderTable("WHERE reminder_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,reminder_title");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
        $log->saveLog(0,$tablereminder,"$o->changesql","I","F");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->getInputForm("new",-1,$token);
		$o->showReminderTable("WHERE reminder_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,reminder_title");
	}

break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchReminder($o->reminder_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->getInputForm("edit",$o->reminder,$token);
		$o->showReminderTable("WHERE reminder_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,reminder_title");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("reminder.php",3,"Some error on viewing your reminder data, probably database corrupted");

break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateReminder()){ //if data save successfully
 $log->saveLog($o->reminder_id,$tablereminder,"$o->changesql","U","O");
			redirect_header("reminder.php?action=edit&reminder_id=$o->reminder_id",$pausetime,"Your data is saved.");
        }else{
             $log->saveLog($o->reminder_id,$tablereminder,"$o->changesql","U","F");
			redirect_header("reminder.php?action=edit&reminder_id=$o->reminder_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
         $log->saveLog($o->reminder_id,$tablereminder,"$o->changesql","U","F");
		redirect_header("reminder.php?action=edit&reminder_id=$o->reminder_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteReminder($o->reminder_id)){
            $log->saveLog($o->reminder_id,$tablereminder,"$o->changesql","D","O");
			redirect_header("reminder.php",$pausetime,"Data removed successfully.");
        }else{
            $log->saveLog($o->reminder_id,$tablereminder,"$o->changesql","D","F");
			redirect_header("reminder.php?action=edit&reminder_id=$o->reminder_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else
		redirect_header("reminder.php?action=edit&reminder_id=$o->reminder_id",$pausetime,"Warning! Can't delete data from database.");

  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	$o->getInputForm("new",0,$token);
	$o->showReminderTable("WHERE reminder_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,reminder_title");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

<?php
include "system.php";
//include_once '../system/class/Log.php';
include_once '../class/Activitysummary.php';
//include_once '../class/Employee.php';
//include_once "../../system/class/SelectCtrl.php";
//include_once "../../../class/datepicker/class.datepicker.php";

//echo  $url;
$ctrl=new SelectCtrl();
xoops_cp_header();
$log = new Log();
$o = new Activitysummary($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);
$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';



$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">

function deleteLog(){
if(document.forms['frmListSearch'].rowcount.value>0){
	if(confirm('Confirm To Delete Log?')){
	document.forms['frmListSearch'].action.value="deletelog";
	document.forms['frmListSearch'].submit();
	}else
	return false;
}else{
alert("No Log To Delete!!.");
return false;
}
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


	function validateActivitysummary(){
		var name=document.forms['frmActivitysummary'].activitysummary_name.value;
		var filename=document.forms['frmActivitysummary'].filename.value;
		var seqno=document.forms['frmActivitysummary'].seqno.value;		
		if(name =="" || filename=="" || !IsNumeric(seqno) || seqno==""){
			alert('Please make sure Activitysummary name, filename is filled in, seq no is filled with numeric value');
			return false;
		}
		else
			return true;
	}
</script>

EOF;

$o->activitysummary_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->activitysummary_id=$_POST["activitysummary_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->activitysummary_id=$_GET["activitysummary_id"];

}
else
$action="";

$token=$_POST['token'];
$o->functiontype=$_POST["functiontype"];
$o->activitysummary_name=$_POST["activitysummary_name"];
$o->filename=$_POST['filename'];
$isactive=$_POST['isactive'];

$o->seqno=$_POST['seqno'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->issearch=$_POST["issearch"];

if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';

$o->showcalendar1=$dp->show("datefrom");
$o->showcalendar2=$dp->show("dateto");

$o->organization_id=$_POST['organization_id'];


$o->table_name=$_POST['table_name'];
$o->uid=$_POST['uid'];
$o->datefrom=$_POST['datefrom'];
$o->dateto=$_POST['dateto'];
$o->activitytype=$_POST['activitytype'];

if($o->organization_id=="")
$o->organization_id=$defaultorganization_id;

if($uid=="")
$uid=0;

$userid=$xoopsUser->getVar('uid');

$o->orgctrl=$ctrl->selectionOrg($userid,$o->organization_id);
$o->userctrl=$permission->selectAvailableSysUser($o->uid,'Y');
$o->windowsctrl=$ctrl->getSelectWindows($o->table_name,"Y");



 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with activitysummary name=$o->activitysummary_name");

	if ($s->check(false,$token,"CREATE_STD")){
		
		
		
	if($o->insertActivitysummary()){
		 $latest_id=$o->getLatestActivitysummaryID();
			 redirect_header("activitysummary.php?action=edit&activitysummary_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create activitysummary!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_STD");

		$o->getInputForm("new",-1,$token);
		$o->showActivitysummaryTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchActivitysummary($o->activitysummary_id)){
		//create a new token for editing a form
		$token=$s->createToken(120,"CREATE_STD"); 

		$o->getInputForm("edit",$o->activitysummary,$token);
		$o->showActivitysummaryTable("WHERE activitysummary_id>0","ORDER BY functiontype,seqno,activitysummary_name"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("activitysummary.php",3,"Some error on viewing your activitysummary data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_STD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateActivitysummary()) //if data save successfully
			redirect_header("activitysummary.php?action=edit&activitysummary_id=$o->activitysummary_id",$pausetime,"Your data is saved.");
		else
			redirect_header("activitysummary.php?action=edit&activitysummary_id=$o->activitysummary_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("activitysummary.php?action=edit&activitysummary_id=$o->activitysummary_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_STD")){
		if($o->deleteActivitysummary($o->activitysummary_id))
			redirect_header("activitysummary.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("activitysummary.php?action=edit&activitysummary_id=$o->activitysummary_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("activitysummary.php?action=edit&activitysummary_id=$o->activitysummary_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

  case "deletelog" :
	$wherestring = str_replace("\'", "'",$_POST['wherestring']);

	$wherestring = str_replace("at.","",$wherestring);
	$o->deleteAllLog("$wherestring");
	$o->showSearchForm();
//	if($o->issearch=="Y")
//	$o->showSearchResult();
  break;

  default :
	//$token=$s->createToken(120,"CREATE_STD");
	//$o->orgctrl=$selectionOrg->selectionOrg($o->createdby,0);
	//$o->getInputForm("new",0,$token);
	//$o->showActivitysummaryTable("WHERE activitysummary_id>0","ORDER BY functiontype,seqno,activitysummary_name");

	$o->showSearchForm();
	if($o->issearch=="Y")
	$o->showSearchResult();
  break;

}
echo '</td>';
xoops_cp_footer();

?>

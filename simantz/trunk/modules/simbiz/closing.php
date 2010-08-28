<?php
include "system.php";
include "menu.php";
include_once 'class/Log.php';
include_once 'class/Closing.php';
include_once 'class/SelectCtrl.php';
include_once "../../class/datepicker/class.datepicker.php";
$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$o = new Closing();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">

	function completeRecord(){
	
		var period=document.forms['frmClosing'].period_id.value;
		var no=document.forms['frmClosing'].closing_no.value;
	
		if(confirm("Complete record?")){
			if(period == 0 || no == ""){
				alert('Please make sure Closing No and Closing Period is Filled');
				return false;
			}else{
				//alert(document.forms['frmClosing'].iscomplete.checked);
				//document.forms['frmClosing'].action.value = "complete";
				document.forms['frmClosing'].iscomplete.checked = true;
				document.forms['frmClosing'].submit();
				return true;
			}
		}
		else
			return false;

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


	function validateClosing(){
		
		//var name=document.forms['frmClosing'].closing_name.value;
		var period=document.forms['frmClosing'].period_id.value;
		var no=document.forms['frmClosing'].closing_no.value;
	
		if(confirm("Save record?")){
		if(period == 0){
			alert('Please make sure Closing No and Closing Period is Filled');
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

$o->closing_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->closing_id=$_POST["closing_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->closing_id=$_GET["closing_id"];

}
else
$action="";

$token=$_POST['token'];

$o->period_id=$_POST["period_id"];
$isactive=$_POST['isactive'];
$iscomplete=$_POST['iscomplete'];
$o->organization_id=$_POST['organization_id'];
$o->closing_description=$_POST['closing_description'];
$o->closing_no=$_POST['closing_no'];


$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

if ($isactive==1 or $isactive=="on")
	$o->isactive=1;
else
	$o->isactive=0;


if ($iscomplete==1 or $iscomplete=="on")
	$o->iscomplete=1;
else
	$o->iscomplete=0;


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with closing name=$o->closing_name");

	if ($s->check(false,$token,"CREATE_ACG")){
		
		
		
	if($o->insertClosing()){
		 $latest_id=$o->getLatestClosingID();
		if($o->iscomplete == 1)
		redirect_header("closing.php",$pausetime,"Your data is completed");
		else
		redirect_header("closing.php?action=edit&closing_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->periodctrl=$ctrl->getSelectPeriod($o->period_id,'Y');
		$o->getInputForm("new",-1,$token);
		$o->showClosingTable("WHERE closing_id>0 and organization_id=$defaultorganization_id","ORDER BY period_name","limit $rowperpage"); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->periodctrl=$ctrl->getSelectPeriod($o->period_id,'Y');
		$o->getInputForm("new",-1,$token);
		$o->showClosingTable("WHERE closing_id>0 and organization_id=$defaultorganization_id","ORDER BY period_name","limit $rowperpage"); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchClosing($o->closing_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->periodctrl=$ctrl->getSelectPeriod($o->period_id,'Y');
		$o->getInputForm("edit",$o->closing,$token);
		$o->showClosingTable("WHERE closing_id>0 and organization_id=$defaultorganization_id","ORDER BY period_name","limit $rowperpage"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("closing.php",3,"Some error on viewing your closing data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateClosing()){ //if data save successfully

			if($o->iscomplete == 1)
			redirect_header("closing.php",$pausetime,"Your data is completed");
			else
			redirect_header("closing.php?action=edit&closing_id=$o->closing_id",$pausetime,"Your data is saved.");
		}else
			redirect_header("closing.php?action=edit&closing_id=$o->closing_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("closing.php?action=edit&closing_id=$o->closing_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteClosing($o->closing_id))
			redirect_header("closing.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("closing.php?action=edit&closing_id=$o->closing_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("closing.php?action=edit&closing_id=$o->closing_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

  case "enable" :
	
	if($o->enableClosing()){
		redirect_header("closing.php?action=edit&closing_id=$o->closing_id",$pausetime,"Your data is enabled.");
	}else
		redirect_header("closing.php?action=edit&closing_id=$o->closing_id",$pausetime,"Warning! Can't delete data from database.");
  break;


  case "showsearchform" :

	$closingdatefrom=$_POST['closingdatefrom'];
	$closingdateto=$_POST['closingdateto'];
	$closing_no=$_POST['closing_no'];
	$iscomplete=$_POST['iscomplete'];
	$period_id=$_POST['period_id'];
	
	$o->showcalendarfrom=$dp->show("closingdatefrom");
	$o->showcalendarto=$dp->show("closingdateto");
	$o->periodctrl=$ctrl->getSelectPeriod(0,'Y');
	$o->showSearchForm();

	$wherestr = "WHERE organization_id=$defaultorganization_id";
	$wherestr .= $o->genWhereString($closingdatefrom,$closingdateto,$closing_no,$iscomplete,$period_id);

	$o->showClosingTable($wherestr,"ORDER BY period_name");

  break;

  default :
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	$o->periodctrl=$ctrl->getSelectPeriod(0,'Y');
	$o->getInputForm("new",0,$token);
	
	$o->showClosingTable("WHERE closing_id>0 and organization_id=$defaultorganization_id","ORDER BY period_name","limit $rowperpage");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

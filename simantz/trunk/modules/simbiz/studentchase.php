<?php
include "system.php";
include "menu.php";

include_once 'class/Studentchase.php.inc';
include_once '../system/class/Log.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


//global $log ;
$o = new Studentchase();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";
$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';


$action="";

echo <<< EOF
<script type="text/javascript">

	function gotoAction(action){
	document.forms['frmstudentchase'].action.value = action;
	document.forms['frmstudentchase'].submit();
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


	function validatestudentchase(){

		var code=document.forms['frmstudentchase'].studentchase_code.value;
		var name=document.forms['frmstudentchase'].studentchase_name.value;
		var nextfollowup_date=document.forms['frmstudentchase'].nextfollowup_date.value;

		if(confirm("Save record?")){
		if(name =="" || !IsNumeric(nextfollowup_date) || nextfollowup_date=="" || code==""){
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

$o->studentchase_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->studentchase_id=$_POST["studentchase_id"];
	$o->studentchaseline_id=$_POST["studentchaseline_id"];
}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->studentchase_id=$_GET["studentchase_id"];
	$o->studentchaseline_id=$_GET["studentchaseline_id"];
}
else
$action="";

$token=$_POST['token'];


		$o->organization_id=$_POST['organization_id'];
		$o->iscomplete=$_POST['iscomplete'];
		$o->studentchase_code=$_POST['studentchase_code'];
		$o->studentchase_name=$_POST['studentchase_name'];
		$o->description=$_POST['description'];
		$o->nextfollowup_date=$_POST['nextfollowup_date'];
		$o->studentchase_datetime=$_POST['studentchase_datetime'];
		$o->lastfollowup_date=$_POST['lastfollowup_date'];
                $o->uid=$_POST['uid'];
                $o->callby=$_POST['callby'];
                $o->tel=$_POST['tel'];
		$o->linedesc=$_POST['linedesc'];
		$o->linetitle=$_POST['linetitle'];
		$o->line_datetime=$_POST['line_datetime'];

$o->isAdmin=$xoopsUser->isAdmin();
$timestamp= date("y/m/d H:i:s", time()) ;
$o->updated=$timestamp;
$o->created=$timestamp;
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->updatesql="";
$o->followUpDate= $dp->show("nextfollowup_date");
$iscomplete=$_POST['iscomplete'];


$o->issearch=$_POST['issearch'];

if ($iscomplete=="1" || $iscomplete=="on")
	$o->iscomplete=1;
else if ($iscomplete=="null")
	$o->iscomplete="null";
else
	$o->iscomplete=0;





 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with studentchase name=$o->studentchase_name");

	if ($s->check(true,$token,"CREATE_WAREHOUSE")){



	if($o->insertstudentchase()){
            $o->uid=$xoopsUser->getVar('uid');
            $latest_id=$o->getLateststudentchaseID();
            $log->saveLog($latest_id, $tablestudentchase, $o->updatesql, "I", "O");
            redirect_header("studentchase.php?action=view&studentchase_id=$latest_id",$pausetime,"Your data is saved, redirect to add transaction history");
        }
	else {
        $log->saveLog(0, $tablestudentchase, $o->updatesql, "I", "F");
		$token=$s->createToken($tokenlife,"CREATE_WAREHOUSE");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
  $o->usersctrl=$ctrl->getSelectUsers(0, "Y", "",  "uid"," AND isstudent=0 ");       $o->getInputForm("new",-1,$token);
		$o->showstudentchaseTable("WHERE studentchase_id>0 and organization_id=$defaultorganization_id","ORDER BY nextfollowup_date,studentchase_name");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
        $log->saveLog(0, $tablestudentchase, $o->updatesql, "I", "F");
        $token=$s->createToken($tokenlife,"CREATE_WAREHOUSE");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
  $o->usersctrl=$ctrl->getSelectUsers(0, "Y", "",  "uid"," AND isstudent=0 ");
		$o->getInputForm("new",-1,$token);
		$o->showstudentchaseTable("WHERE studentchase_id>0 and organization_id=$defaultorganization_id","ORDER BY nextfollowup_date,studentchase_name");
	}

break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchstudentchase($o->studentchase_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_WAREHOUSE");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
  $o->usersctrl=$ctrl->getSelectUsers($o->uid, "Y", "",  "uid"," AND isstudent=0 ");
  $o->getInputForm("edit",$o->studentchase_id,$token);

		//$o->showstudentchaseTable("WHERE studentchase_id>0 and organization_id=$defaultorganization_id","ORDER BY nextfollowup_date,studentchase_name");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("studentchase.php",3,"Some error on viewing your studentchase data, probably database corrupted");

break;
case "editstudentchaseline":
    if($o->fetchstudentchaseLine($o->studentchaseline_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_WAREHOUSE");
                 $o->studentchasectrl="<input type='hidden' value='$o->studentchase_id' name='studentchase_id'>";
		$o->getstudentchaseLineForm("edit",$o->studentchase_id,$token);
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("studentchase.php?action=view&studentchase_id=$o->studentchase_id",3,"Some error on viewing your studentchase data, probably database corrupted");

    break;
	//when user request to edit particular organization
  case "view" :
	if($o->fetchstudentchase($o->studentchase_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_WAREHOUSE");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		//$o->sellaccountsctrl=$ctrl->getSelectAccounts($o->studentchase_datetime,'Y',"","studentchase_datetime","AND placeholder=0");
   		//$o->buyaccountsctrl=$ctrl->getSelectAccounts($o->parentstudentchase_id,'Y',"","parentstudentchase_id","AND placeholder=0");
        //$o->issueaccountsctrl=$ctrl->getSelectAccounts($o->lastfollowup_date,'Y',"","lastfollowup_date","AND placeholder=0");
        //$o->stockadjustaccountsctrl=$ctrl->getSelectAccounts($o->description,'Y',"","description","AND placeholder=0");

	$o->viewstudentchaseData($o->studentchase_id);
        $o->showstudentchaseLineTable($o->studentchase_id,"$token");
		//$o->showstudentchaseTable("WHERE studentchase_id>0 and organization_id=$defaultorganization_id","ORDER BY nextfollowup_date,studentchase_name");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("studentchase.php",3,"Some error on viewing your studentchase data, probably database corrupted");

break;

//when user press save for change existing organization data
  case "update" :
	if ($s->check(true,$token,"CREATE_WAREHOUSE")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updatestudentchase()) {//if data save successfully
           $log->saveLog($o->studentchase_id, $tablestudentchase, $o->updatesql, "U", "O");
			redirect_header("studentchase.php?action=view&studentchase_id=$o->studentchase_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->studentchase_id, $tablestudentchase, $o->updatesql, "U", "F");
			redirect_header("studentchase.php?action=edit&studentchase_id=$o->studentchase_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog($o->studentchase_id, $tablestudentchase, $o->updatesql, "U", "F");
		redirect_header("studentchase.php?action=edit&studentchase_id=$o->studentchase_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "insertline":
	if ($s->check(true,$token,"CREATE_WAREHOUSE")){

        if($o->insertstudentchaseLine()) {//if data save successfully
            $latest_id=$o->getLateststudentchaseLineID();
           $log->saveLog($latest_id, $tablestudentchaseline, $o->updatesql, "I", "O");


			redirect_header("studentchase.php?action=view&studentchase_id=$o->studentchase_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog(0, $tablestudentchaseline, $o->updatesql, "I", "F");
			redirect_header("studentchase.php?action=view&studentchase_id=$o->studentchase_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog(0, $tablestudentchaseline, $o->updatesql, "I", "F");
		redirect_header("studentchase.php?action=view&studentchase_id=$o->studentchase_id",$pausetime,"Warning! Can't save the data due to token expired.");
	}
  break;

  case "delete" :
	if ($s->check(true,$token,"CREATE_WAREHOUSE")){
		if($o->deletestudentchase($o->studentchase_id)){
            $log->saveLog($o->studentchase_id, $tablestudentchase, $o->updatesql, "D", "O");
			redirect_header("studentchase.php",$pausetime,"Data removed successfully.");
        }
		else{
            $log->saveLog($o->studentchase_id, $tablestudentchase, $o->updatesql, "D", "F");
			redirect_header("studentchase.php?action=edit&studentchase_id=$o->studentchase_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else{
        $log->saveLog($o->studentchase_id, $tablestudentchase, $o->updatesql, "D", "F");
		redirect_header("studentchase.php?action=edit&studentchase_id=$o->studentchase_id",$pausetime,"Warning! Can't delete data from database.");
    }
case "deleteline":
    if ($s->check(true,$token,"CREATE_WAREHOUSE")){
        	if($o->deletestudentchaseLine($o->studentchaseline_id)){
            $log->saveLog($o->studentchaseline_id, $tablestudentchaseline, $o->updatesql, "D", "O");
			redirect_header("studentchase.php?action=view&studentchase_id=$o->studentchase_id",$pausetime,"Data removed successfully.");
            }
     else{
            $log->saveLog($o->studentchaseline_id, $tablestudentchaseline, $o->updatesql, "D", "F");
			redirect_header("studentchase.php?action=editstudentchaseline&studentchase_id=$o->studentchase_id&studentchaseline=$o->studentchaseline_id",$pausetime,"Warning! Can't delete data from database.");

     }
    }
    else{
        $log->saveLog($o->studentchaseline_id, $tablestudentchaseline, $o->updatesql, "D", "F");
		redirect_header("studentchase.php?action=editstudentchaseline&studentchase_id=$o->studentchase_id&studentchaseline=$o->studentchaseline_id",$pausetime,"Warning! Can't delete data from database due to token expired.");
    }
    break;
case "updateline";
 
        if ($s->check(true,$token,"CREATE_WAREHOUSE")){
        	if($o->updatestudentchaseLine()){
            $log->saveLog($o->studentchaseline_id, $tablestudentchaseline, $o->updatesql, "U", "O");
			redirect_header("studentchase.php?action=view&studentchase_id=$o->studentchase_id",$pausetime,"Data save successfully.");
            }
     else{
            $log->saveLog($o->studentchaseline_id, $tablestudentchaseline, $o->updatesql, "U", "F");
			redirect_header("studentchase.php?action=editstudentchaseline&studentchase_id=$o->studentchase_id&studentchaseline=$o->studentchaseline_id",$pausetime,"Warning! Data cannot save into database, please verified your input.");

     }
    }
    else{
        $log->saveLog($o->studentchaseline_id, $tablestudentchaseline, $o->updatesql, "U", "F");
		redirect_header("studentchase.php?action=editstudentchaseline&studentchase_id=$o->studentchase_id&studentchaseline=$o->studentchaseline_id",$pausetime,"Warning! Can't save data into database due to token expired.");
    }
    break;
  case "search" :

	$wherestr = " WHERE studentchase_id>0 and organization_id=$defaultorganization_id";
       
	if($o->issearch == "Y")
	$wherestr .= $o->getWhereStr();
	else{
	$o->studentchase_datetime = 0;
	}

	$o->sellaccountsctrl=$ctrl->getSelectAccounts($o->studentchase_datetime,'Y',"","studentchase_datetime","AND placeholder=0");
	$o->showSearchForm();
	$o->showstudentchaseTable($wherestr,"ORDER BY studentchase_name ");
  break;

  default :
	if($o->studentchase_datetime=="")
	$o->studentchase_datetime = 0;
	if($o->lastfollowup_date=="")
	$o->lastfollowup_date = 0;
        $o->uid=$xoopsUser->getVar('uid');

	$token=$s->createToken($tokenlife,"CREATE_WAREHOUSE");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
        $o->usersctrl=$ctrl->getSelectUsers(0, "Y", "",  "uid"," AND isstudent=0 ");

	$o->getInputForm("new",0,$token);
	$o->showstudentchaseTable("WHERE wh.studentchase_id>0 and wh.organization_id=$defaultorganization_id and wh.iscomplete=0 ",
                        "ORDER BY wh.studentchase_datetime");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

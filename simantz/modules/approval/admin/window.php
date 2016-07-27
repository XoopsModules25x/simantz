<?php
include "system.php";
include_once '../simantz/class/Log.inc.php';
include_once '../../simantz/class/SelectCtrl.inc.php';
include_once '../class/Window.php';
include_once '../class/Employee.php';


xoops_cp_header();
$log = new Log();
$o = new Window($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);
$ctrl = new SelectCtrl();

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


	function validateWindow(){
		var name=document.forms['frmWindow'].window_name.value;
		var filename=document.forms['frmWindow'].filename.value;
		var seqno=document.forms['frmWindow'].seqno.value;
		if(name =="" || filename=="" || !IsNumeric(seqno) || seqno==""){
			alert('Please make sure Window name, filename is filled in, seq no is filled with numeric value');
			return false;
		}
		else
			return true;
	}
</script>

EOF;

$o->window_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->window_id=$_POST["window_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->window_id=$_GET["window_id"];

}
else
$action="";

$token=$_POST['token'];
$o->functiontype=$_POST["functiontype"];
$o->window_name=$_POST["window_name"];
$o->table_name=$_POST["table_name"];
$o->mid=$_POST["mid"];
$o->filename=$_POST['filename'];
$isactive=$_POST['isactive'];

$o->seqno=$_POST['seqno'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');


if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with window name=$o->window_name");

	if ($s->check(false,$token,"CREATE_STD")){



	if($o->insertWindow()){
		 $latest_id=$o->getLatestWindowID();
			 redirect_header("window.php?action=edit&window_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create window!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_STD");

		$o->getInputForm("new",-1,$token);
		$o->showWindowTable();
	}

break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchWindow($o->window_id)){
		//create a new token for editing a form
		$token=$s->createToken(120,"CREATE_STD");

        $o->modulesctrl = $ctrl->getSelectModules($o->mid,"Y");
		$o->getInputForm("edit",$o->window,$token);
		$o->showWindowTable("WHERE window_id>0","ORDER BY functiontype,seqno,window_name");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("window.php",3,"Some error on viewing your window data, probably database corrupted");

break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_STD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateWindow()) //if data save successfully
			redirect_header("window.php?action=edit&window_id=$o->window_id",$pausetime,"Your data is saved.");
		else
			redirect_header("window.php?action=edit&window_id=$o->window_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("window.php?action=edit&window_id=$o->window_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_STD")){
		if($o->deleteWindow($o->window_id))
			redirect_header("window.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("window.php?action=edit&window_id=$o->window_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("window.php?action=edit&window_id=$o->window_id",$pausetime,"Warning! Can't delete data from database.");

  break;
  default :
	$token=$s->createToken(120,"CREATE_STD");
	//$o->orgctrl=$selectionOrg->selectionOrg($o->createdby,0);
    $o->modulesctrl = $ctrl->getSelectModules(0,"Y");
	$o->getInputForm("new",0,$token);
	$o->showWindowTable("WHERE window_id>0","ORDER BY functiontype,seqno,window_name");
  break;

}
echo '</td>';
xoops_cp_footer();

?>

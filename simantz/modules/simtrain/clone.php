<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once "menu.php";
include_once 'class/CloneProcess.php';
//include_once 'class/Employee.php';
include_once 'class/Period.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
//$e = new Employee($xoopsDB,$tableprefix,$log);
$o = new CloneProcess($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$period= new Period($xoopsDB,$tableprefix,$log);
$action="";


echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	}

	function validateClone(){
		var fromperiod=document.frmClone.periodfrom_id.value;
		var toperiod=document.frmClone.periodto_id.value;
		if(confirm('Confirm to clone period? Make sure the transaction at last month is done and data is backup.')){
		if(toperiod==fromperiod){
			alert("Error! Period from and period to cannot same.")
			return false;
		}
		else{
			return true;
		}
		}
		else
			return false;
	}

</script>

EOF;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->clone_id=$_POST["clone_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->clone_id=$_GET["clone_id"];

}
else
$action="";

$o->type=$_POST['type'];

$token=$_POST['token'];
$o->periodfrom_id=$_POST["periodfrom_id"];
$o->periodto_id=$_POST["periodto_id"];

$period->fetchPeriod($o->periodto_id);
$o->monthto=$period->month;
$o->yearto=$period->year;
$o->periodto_name=$period->period_name;
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

$timestamp= date("y/m/d H:i:s", time()) ;
$o->created=$timestamp;
$o->updated=$timestamp;

$o->status=$_POST['status'];
$o->organization_id=$_POST['organization_id'];


 switch ($action){
	//When user submit new organization
  case "Clone Class" :
	//$o->type="M";	//for month end='M', year end = 'Y'
	
	if($o->insertClone()){
		$o->clone_id=$o->getLatestCloneID();
			$log->showLog(3,"Generated ID=" . $o->clone_id);
		if ($o->cloneClass($o->clone_id)){
			$log->showLog(3,"Clone class process completed successfully");
			// when user choose to auto complete last month transaction
			
				if($o->completelastmonth($o->clone_id)){
					if($o->updateclonestatus($o->clone_id,"complete")){
						redirect_header("clone.php",$pausetime,
							"all last month tuition class completed successfully");
					}
					else
				 		redirect_header("clone.php",$pausetime,
							"Clone Process failed to update status(The clone may be success)");
					}
				else
					redirect_header("clone.php",$pausetime,
							"Can't complete last month data");	
			
		
	 }//end if ($o->cloneClass($o->clone_id))
	}// end if ($o->insertClone())
break;
	//when user request to edit particular organization
  case "Clone Class and Student Registration" :
	$log->showLog(2,"Start cloning year");
  
break;
//when user press save for change existing organization data
  case "reverse" :
	$log->showLog(2,"Start reverse month");
	if($o->deleteCloneData($o->clone_id))
		if($o->reactivateclass($o->clone_id))//re-activate data at pervious period
			if($o->updateclonestatus($o->clone_id,"reverse")){
				redirect_header("clone.php",$pausetime,
							"Reverse process successfully");}
			else{
				redirect_header("clone.php",$pausetime,
							"Reverse process failed at final stage, but it might success.");}
  break;

  default :
	$o->periodctrl_from=$period->getPeriodList(0,'periodfrom_id');
	$o->periodctrl_to=$period->getPeriodList(0,'periodto_id');
	$o->orgctrl=$permission->selectionOrg($o->createdby,$defaultorganization_id);
	$o->getInputForm("new",0,$token);
	$o->showCloneHistoryTable("where clone_id>0");
 break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

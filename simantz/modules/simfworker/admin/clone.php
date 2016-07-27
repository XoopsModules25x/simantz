<?php
include_once "admin_header.php" ;
include_once '../class/Log.php';
include_once '../class/CloneProcess.php';
include_once '../class/Employee.php';
include_once '../class/Period.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
xoops_cp_header();

$log = new Log();
$e = new Employee($xoopsDB,$tableprefix,$log);
$o = new CloneProcess($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$period= new Period($xoopsDB,$tableprefix,$log);
$action="";


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

if ($_POST['iscompletelastmonth'] == 'Y' || $_POST['iscompletelastmonth'] == 'on')
	$o->iscompletelastmonth="Y";
else
	$o->iscompletelastmonth="N";

$token=$_POST['token'];
$o->periodfrom_id=$_POST["periodfrom_id"];
$o->periodto_id=$_POST["periodto_id"];

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
	$o->type="M";	//for month end='M', year end = 'Y'
	
	if($o->insertClone()){
		$o->clone_id=$o->getLatestCloneID();
			$log->showLog(3,"Generated ID=" . $o->clone_id);
		if ($o->cloneClass($o->clone_id)){
			$log->showLog(3,"Clone class process completed successfully");
			// when user choose to auto complete last month transaction
			if($o->iscompletelastmonth=='Y'){
				if($o->completelastmonth($o->periodfrom_id)){
			 		redirect_header("clone.php",$pausetime,
							"all last month tuition class completed successfully");
					}
				else
					redirect_header("clone.php",$pausetime,
							"Can't complete last month data");	
			}
		else{
			$log->showLog(1,"Clone class process failed");	
	 	}
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
  break;

  default :
	$o->periodctrl_from=$period->getPeriodList(0,'periodfrom_id');
	$o->periodctrl_to=$period->getPeriodList(0,'periodto_id');
	$o->orgctrl=$e->selectionOrg($o->createdby,0);


	$o->getInputForm("new",0,$token);
	$o->showCloneHistoryTable();
 break;

}

xoops_cp_footer();

?>

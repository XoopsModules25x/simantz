<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Period.php';
include_once 'class/Employee.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Period($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;


$o->period=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->period_id=$_POST["period_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->period_id=$_GET["period_id"];

}
else
$action="";

$token=$_POST['token'];
$o->month=$_POST['month'];
$o->year=$_POST['year'];
$o->period_name=$_POST["period_name"];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isactive=$_POST['isactive'];
if($o->isactive=='on' || $o->isactive=='Y')
$o->isactive='Y';
else
$o->isactive='N';
$o->isAdmin=$xoopsUser->isAdmin();


echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmPeriod'].period_name.focus();
	}

	function validatePeriod(){
		var name=document.forms['frmPeriod'].period_name.value;
		var yearctl=document.forms['frmPeriod'].year.value;
		var monthctl=document.forms['frmPeriod'].month.value;

		if(confirm('Save Record?')){
		if(name =="" || !IsNumeric(yearctl) || yearctl==""|| !IsNumeric(monthctl) || monthctl==""){
			alert('Cannot save data! Please make sure you fill in period name and data in year/month in numeric format');
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


 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with period_name=$o->period_name");

	if ($s->check(false,$token,"CREATE_PERIOD")){
		
		
		
	if($o->insertPeriod()){
		// $latest_id=$o->getLatestCategoryID();
			 redirect_header("period.php",$pausetime,"Your data is saved");
		}
	else {
		$log->showLog(1,"Warning! '$o->period_name' cannot save, please verified your data.");
		$token=$s->createToken($tokenlife,"CREATE_PERIOD");
		$o->getInputForm("new",-1,$token);
		$o->showPeriodTable(); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"Warning! '$o->period_name' cannot save due to token expired.");
		$token=$s->createToken($tokenlife,"CREATE_PERIOD");
		$o->getInputForm("new",-1,$token);
		$o->showPeriodTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchPeriod($o->period_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_PERIOD"); 
		//$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->period_id,$token);
		$o->showPeriodTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("period.php",3,"<b style='color:red'>Some error on viewing your period data, probably database corrupted.</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_PERIOD")){
		//$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updatePeriod()) //if data save successfully
			redirect_header("period.php?action=edit&period_id=$o->period_id",$pausetime,"Your data is saved.");
		else
			redirect_header("period.php?action=edit&period_id=$o->period_id",$pausetime,"<b style='color:red'>Warning! Can't save the data, please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("period.php?action=edit&period_id=$o->period_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->period_name' due to token expired.</b>");
	}
  break;
  
  default :
	$token=$s->createToken($tokenlife,"CREATE_PERIOD");
	
	$o->getInputForm("new",0,$token);
	$o->showPeriodTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

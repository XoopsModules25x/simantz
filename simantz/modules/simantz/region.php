<?php

include_once "system.php" ;
//include_once 'class/Log.php';
include_once '../simantz/class/Region.php.inc';
//include_once 'class/Employee.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

//$log = new Log();
$o = new Region($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);




$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){

		document.forms['frmRegion'].region_name.focus();
	}

	function validateRegion(){
		var name=document.forms['frmRegion'].region_name.value;

		if(confirm('Save Record?')){
		if(name =="" ){
			alert("Please make sure 'Region Name' is filled in.");
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

$o->region_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->region_id=$_POST["region_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->region_id=$_GET["region_id"];

}
else
$action="";
$o->isAdmin=$xoopsUser->isAdmin();
$token=$_POST['token'];
$o->defaultlevel=$_POST["defaultlevel"];
$o->region_name=$_POST["region_name"];
$o->country_id=$_POST['country_id'];
$o->organization_id=$_POST['organization_id'];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$isactive=$_POST['isactive'];
 	$timestamp= date("y/m/d H:i:s", time()) ;
    $o->updated=$timestamp;
    $o->created=$timestamp;

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

if($o->country_id=="")
$o->country_id=0;

if ($isactive==1 || $isactive=="on")
	$o->isactive=1;
else
	$o->isactive=0;


 switch ($action){

  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with region name=$o->region_name");

	if ($s->check(true,$token,"CREATE_STD")){



	if($o->insertRegion()){
		 $latest_id=$o->getLatestRegionID();
			 redirect_header("region.php",$pausetime,"Your data is saved, redirect to create more record.");
		}
	else {
		$log->showLog(1,"Warning, '$o->region_name' cannot be save, please make sure your data is correct");
		$token=$s->createToken($tokenlife,"CREATE_STD");
        $o->countryctrl=$ctrl->getSelectCountry($o->country_id,'N');
        $o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
		$o->getInputForm("new",-1,$token);
		$o->showRegionTable();
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"Warning, '$o->region_name' cannot be save due to token expired");
		$token=$s->createToken($tokenlife,"CREATE_STD");
        $o->countryctrl=$ctrl->getSelectCountry($o->country_id,'N');
        $o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
		$o->getInputForm("new",-1,$token);
		$o->showRegionTable();
	}

break;

  case "edit" :
	if($o->fetchRegion($o->region_id)){
		//create a new token for editing a form
		//$orgwhereaccess=$orgwhereaccess
		$token=$s->createToken($tokenlife,"CREATE_STD");
        $o->countryctrl=$ctrl->getSelectCountry($o->country_id,'N');
        $o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
		$o->getInputForm("edit",$o->region_id,$token);
		$o->showRegionTable();
	}
	else	//if can't find particular region from database, return error message
		redirect_header("region.php",3,"<b style='color:red'>Some error on viewing your region data, probably database corrupted.</b>");

break;

  case "update" :
	if ($s->check(true,$token,"CREATE_STD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateRegion()) //if data save successfully
			redirect_header("region.php?action=edit&region_id=$o->region_id",$pausetime,"Your data is saved.");
		else
			redirect_header("region.php?action=edit&region_id=$o->region_id",$pausetime,"<b style='color:red'>Warning! Can't save the '$o->region_name', please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("region.php?action=edit&region_id=$o->region_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->region_name' due to token expired.</b>");
	}
  break;
  case "delete" :
	if ($s->check(true,$token,"CREATE_STD")){
		if($o->deleteRegion($o->region_id))
			redirect_header("region.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("region.php?action=edit&region_id=$o->region_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to data dependency.</b>");
	}
	else
		redirect_header("region.php?action=edit&region_id=$o->region_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to token expired.</b>");

  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_STD");
    $o->countryctrl=$ctrl->getSelectCountry(0,'N');
    $o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	$o->getInputForm("new",0,$token);
	$o->showRegionTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

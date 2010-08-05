<?php
include_once "system.php" ;
//include_once 'class/Log.php';
include_once 'class/Year.php';
//include_once 'class/Employee.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

//$log = new Log();
$o = new Year($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);




$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmYear'].year_name.focus();
	}
	function validateYear(){
		var name=document.forms['frmYear'].year_name.value;

		if(confirm('Save Record?')){
		if(name =="" ){
			alert("Please make sure 'Year Name' is filled in.");
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

$o->year_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->year_id=$_POST["year_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->year_id=$_GET["year_id"];

}
else
$action="";

$token=$_POST['token'];
$o->year_description=$_POST["year_description"];
$o->year_name=$_POST["year_name"];

$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	
$isactive=$_POST['isactive'];
$o->isAdmin=$xoopsUser->isAdmin();
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');


if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';


 switch ($action){

  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with year name=$o->year_name");

	if ($s->check(false,$token,"CREATE_RCE")){
		
	if($o->insertYear()){
		 $latest_id=$o->getLatestYearID();
			 redirect_header("year.php",$pausetime,"Your data is saved, the new id=$latest_id. Redirect to create new year.");
		}
	else {
		$log->showLog(1, "Can't create year '$o->year_name', please verified your data!");
		$token=$s->createToken($tokenlife,"CREATE_RCE");

		$o->getInputForm("new",-1,$token);
		$o->showYearTable();
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1, "Can't create year '$o->year_name' due to token expired!");

		$token=$s->createToken($tokenlife,"CREATE_RCE");

		$o->getInputForm("new",-1,$token);
		$o->showYearTable();
	}
 
break;

  case "edit" :
	if($o->fetchYear($o->year_id)){
		//create a new token for editing a form

		$token=$s->createToken($tokenlife,"CREATE_RCE"); 

		$o->getInputForm("edit",$o->year,$token);
		$o->showYearTable();
	}
	else	//if can't find particular year from database, return error message
		redirect_header("year.php",3,"<b style='color:red'>Some error on viewing your year data, probably database corrupted.</b>");
  
break;

  case "update" :
	if ($s->check(false,$token,"CREATE_RCE")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateYear()) //if data save successfully
			redirect_header("year.php?action=edit&year_id=$o->year_id",$pausetime,"Your data is saved.");
		else
			redirect_header("year.php?action=edit&year_id=$o->year_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->year_name', please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("year.php?action=edit&year_id=$o->year_id",$pausetime,"<b style='color:red'>Warning! Can't save the data '$o->year_name' due to token expired, please reenter data after form refresh.</b>");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_RCE")){
		if($o->deleteYear($o->year_id))
			redirect_header("year.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("year.php?action=edit&year_id=$o->year_id",$pausetime,"<b style='color:red'>Warning! Can't delete
					data from database due to dependency issue.</b>");
	}
	else
		redirect_header("year.php?action=edit&year_id=$o->year_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to token expired.</b>");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_RCE");

	$o->getInputForm("new",0,$token);
	$o->showYearTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

<?php
include_once "system.php" ;
include_once "menu.php";
include_once './class/Employee.php';

include_once './class/Address.php';
include_once ("datepicker/class.datepicker.php");
include_once './class/Races.php';
include_once './class/Religion.php';
include_once 'class/Log.php';

$log = new Log();
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

$ad = new Address($xoopsDB,$tableprefix,$log);
$o= new Employee($xoopsDB,$tableprefix,$log,$ad);
$s = new XoopsSecurity();
$r = new Races($xoopsDB,$tableprefix,$log);
$re = new Religion($xoopsDB,$tableprefix,$log);
$action="";

echo <<< EOF
<script type="text/javascript">

	function autofocus(){
	
		document.forms['frmEmployee'].employee_name.focus();
	}
	

	function validateEmployee(){
		
		var employee_no=document.frmEmployee.employee_no.value;
		var employee_name=document.frmEmployee.employee_name.value;
		var ic_no=document.frmEmployee.ic_no.value;
		var dateofbirth=document.frmEmployee.dateofbirth.value;
		var hourlyamt=document.frmEmployee.hourlyamt.value;
		var commissionrate=document.frmEmployee.commissionrate.value;
		var basicsalary=document.frmEmployee.basicsalary.value;


		if (confirm("Confirm to save record?")){
			if(employee_no !="" && employee_name!="" && ic_no!="" && isDate(dateofbirth) &&
			basicsalary !="" &&  commissionrate !="" && hourlyamt !="" &&
			IsNumeric(basicsalary) &&  IsNumeric(commissionrate) && IsNumeric(hourlyamt) ){
				return true;
			}
			else	{
				alert ("Please make sure you fill in Index No, Employee Name, IC Number, make sure Basic Salary, Hourly Rate, Commission Rate is numeric, and data format for 'Date of Birth' is correct.");
				return false;
				}
		}
		else
			return false;
	}
	

	function showAddressWindow(address_id){
		document.frmEmployee.submit.click();
		var win=window.open('address.php?address_id='+address_id+'&action=edit', "Editing address", "width=700,height=700,scrollbars=yes,resizable=yes");
	}
</script>

EOF;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->employee_id=$_POST["employee_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->employee_id=$_GET["employee_id"];

}
else
$action="";

$token=$_POST['token'];
$o->employee_no=$_POST["employee_no"];
$o->employee_name=$_POST["employee_name"];
$o->ic_no=$_POST["ic_no"];
$o->gender=$_POST["gender"];
$o->dateofbirth=$_POST["dateofbirth"];
$o->epf_no=$_POST["epf_no"];
$o->socso_no=$_POST["socso_no"];
$o->epftype=$_POST['epftype'];
$o->basicsalary=$_POST["basicsalary"];
$o->salarytype=$_POST["salarytype"];
$o->hourlyamt=$_POST["hourlyamt"];
$o->commissionrate=$_POST["commissionrate"];

$o->description=$_POST["description"];

$o->religion_id = $_POST['religion_id'];

$o->account_no=$_POST["account_no"];
$o->hp_no=$_POST["hp_no"];
$o->department=$_POST["department"];
$o->position=$_POST["position"];
$o->tel_1=$_POST["tel_1"];
$o->address_id=$_POST["address_id"];
$o->uid=$_POST['uid'];
$o->isAdmin=$xoopsUser->isAdmin();
$o->races_id=$_POST['races_id'];
$o->employeetype=$_POST["employeetype"];
$o->showcalendar=$dp->show("dateofbirth");
$o->joindate=$_POST["joindate"];
$o->showjoindatectrl=$dp->show("joindate");
$o->highestqualification=$_POST["highestqualification"];
$o->highestteachlvl=$_POST["highestteachlvl"];
$o->subjectsteach=$_POST["subjectsteach"];
$o->cashonhand=$_POST["cashonhand"];
$o->organization_id=$_POST["organization_id"];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

$ad->createdby=$xoopsUser->getVar('uid');
$ad->updatedby=$xoopsUser->getVar('uid');
$o->orgWhereString=$permission->orgWhereStr($xoopsUser->getVar('uid'));
$phototmpfile= $_FILES["employeephoto"]["tmp_name"];
$photofilesize=$_FILES["employeephoto"]["size"] / 1024;
$photofiletype=$_FILES["employeephoto"]["type"];
$o->removepic=$_POST['removepic'];
$isactive=$_POST['isactive'];
$o->cur_symbol=$cur_symbol;
if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	if ($s->check(false,$token,"CREATE_EMP")){
		
		
		$newaddress_id=$ad->createBlankAddress($ad->createdby);//create new address for employee
		if($newaddress_id>=0){
			$o->address_id=$newaddress_id;
		//if organization saved
			if($o->insertEmployee()){
				 $latest_id=$o->getLatestEmployeeID();
				 redirect_header("employee.php?action=edit&employee_id=$latest_id",$pausetime,"Your data is saved.");
			}
			else {
				echo "<strong style='color:#ff0000;'>Data can't save, please verified your IC and Student Number is unique</strong>";
				$token=$s->createToken($tokenlife ,"CREATE_EMP");
		//		$o->userctrl=$o->selectAvailableSysUser(0);
				$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
				$o->racesctrl=$r->getSelectRaces($o->races_id,'Y');
				$o->religionctrl=$re->getSelectReligion($o->religion_id,'Y');

				$o->getInputForm("edit",0,$token);
				$o->showEmployeeTable();
			}
		}
		else{
			$log->showLog(1,"<b style='color:red'>Can't create '$o->employee_name', please verified your data.</b>");
			$token=$s->createToken($tokenlife,"CREATE_EMP");
		//	$o->userctrl=$o->selectAvailableSysUser(0);
			$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
			$o->racesctrl=$r->getSelectRaces($o->races_id,'Y');
			$o->religionctrl=$re->getSelectReligion($o->religion_id,'Y');

			$o->getInputForm("new",-1,$token);
			$o->showEmployeeTable(); 

		}
	}

	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"<b style='color:red'>Can't create '$o->employee_name' due to token expired</b>");
		$token=$s->createToken($tokenlife,"CREATE_EMP");
		//$o->userctrl=$o->selectAvailableSysUser(0);
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->racesctrl=$r->getSelectRaces($o->races_id,'Y');
		$o->religionctrl=$re->getSelectReligion($o->religion_id,'Y');
	
		$o->getInputForm("new",-1,$token);
		$o->showEmployeeTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchEmployee($o->employee_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_EMP"); 
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->userctrl=$permission->selectAvailableSysUser($o->uid);
		$o->racesctrl=$r->getSelectRaces($o->races_id,'Y');
		$o->religionctrl=$re->getSelectReligion($o->religion_id,'Y');
		$o->getInputForm("edit",$o->employee_id,$token);
		$o->showEmployeeTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("employee.php",$pausetime,"<b style='color:red'>Some error on viewing your employee data, probably database corrupted</b>");

break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_EMP")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateEmployee()){ //if data save successfully
			if($o->removepic=='on')
				$o->deletephoto($o->employee_id);


			if($photofilesize>0 && $photofilesize<100 && $photofiletype=='image/jpeg'){
				$o->deletephoto($o->employee_id);
				$o->savephoto($phototmpfile);
			}
			elseif($photofilesize>0){
				$uploaderror="<b style='color: red'> but fail to upload photo file, please make sure you upload jpg file and file size smaller than 100kb</b>";
			$pausetime=3;}

			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Your data is saved $uploaderror.");
		}
		else
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->employee_name', please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"<b style='color:red'>Warning! Can't save '$o->employee_name' due to token expired.</b>");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_EMP")){
		if($o->deleteEmployee($o->employee_id))
			redirect_header("employee.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to dependency error.</b>");
	}
	else
		redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"<b style='color:red'>Warning! Can't delete data from database due to token expired.</b>");
	
  break;
  default :
	$token=$s->createToken($tokenlife ,"CREATE_EMP");
	$o->userctrl=$permission->selectAvailableSysUser(0);
	$o->racesctrl=$r->getSelectRaces(0,'Y');
	$o->religionctrl=$re->getSelectReligion(0,'Y');
	$o->orgctrl=$permission->selectionOrg($o->createdby,$defaultorganization_id);
	$o->getInputForm("new",0,$token);
	$o->showEmployeeTable();
  break;

}
require(XOOPS_ROOT_PATH.'/footer.php');
?>

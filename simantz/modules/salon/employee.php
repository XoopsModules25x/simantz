<?php
include "system.php" ;
include_once "menu.php";
include_once './class/Employee.php';
include_once './class/Stafftype.php';
include_once './class/Log.php';
//include_once './class/Address.php';
require ("datepicker/class.datepicker.php");
include './class/Races.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';



$log = new Log();
//$ad = new Address($xoopsDB,$tableprefix,$log);
$o= new Employee($xoopsDB,$tableprefix,$log,$ad);
$s = new XoopsSecurity();
$r = new Races($xoopsDB,$tableprefix,$log);
$t = new Stafftype($xoopsDB,$tableprefix,$log);

$action="";


//marhan add here --> ajax
echo "<iframe src='employee.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
/////////////////////

echo <<< EOF
<script type="text/javascript" >
	
	function autofocus(){
	document.forms['frmEmployee'].employee_name.focus();
	}

	function deleteLine(line){//delete line payment
		
	if(confirm("Delete Record?")){
		if(validateData()){
		document.forms['frmEmployee'].action.value = "deleteline";
		document.forms['frmEmployee'].line.value = line;
		document.forms['frmEmployee'].submit();
		}
	}

	}
	
	function addPayment(){
	var payment=document.forms['frmEmployee'].fldPayment.value;
	var code=document.forms['frmEmployee'].employee_no.value;

	if(confirm("Add Record?")){
		if(payment=="" || !IsNumeric(payment)){
		alert('Invalid Data. Please Key In Again..');
		}else{
			if(validateData()){
			document.forms['frmEmployee'].action.value = "addline";
			document.forms['frmEmployee'].submit();
			}
		}
	}
	
	}

	
	function sendRequest() {//example of ajax

		var arr_fld=new Array("action","name");//name for POST
		var arr_val=new Array("validate",document.forms['frmAjax'].fldAjax.value);//value for POST
		
		getRequest(arr_fld,arr_val);
		
	}
	
	function validateData(){

	var employee_no=document.frmEmployee.employee_no.value;
	var employee_name=document.frmEmployee.employee_name.value;
	var ic_no=document.frmEmployee.ic_no.value;
	var dateofbirth=document.frmEmployee.dateofbirth.value;
	var basic_salary=document.frmEmployee.basic_salary.value;
	var socso_employee=document.frmEmployee.socso_employee.value;
	var socso_employer=document.frmEmployee.socso_employer.value;
	var epf_employee=document.frmEmployee.epf_employee.value;
	var epf_employer=document.frmEmployee.epf_employer.value;
	var dateofbirth=document.frmEmployee.dateofbirth.value;
	var joindate=document.frmEmployee.joindate.value;
	
	if(employee_no =="" && employee_name=="" && ic_no=="" && dateofbirth==""&& basic_salary==""){
	alert ("Please make sure Employee No, Employee Name, IC Number,\\nBasic Salary and Date of Birth is not empty.");
	return false;
	}

	if(!isDate(dateofbirth) || !isDate(joindate)){
	return false;
	}
	
	if(!IsNumeric(basic_salary)||!IsNumeric(socso_employee)||!IsNumeric(socso_employer)||!IsNumeric(epf_employee)||!IsNumeric(epf_employer)){
	alert("Please make sure basic salary, socso employee, socso employer, epf employee and epf employer is numeric");
	return false;
	}
				
	
	
	var i=0;
	while(i< document.forms['frmEmployee'].elements.length){
		var ctlname = document.forms['frmEmployee'].elements[i].name; 
		var data = document.forms['frmEmployee'].elements[i].value;
	
		
		ctlname = ctlname.substring(0,ctlname.indexOf("["))

		
		
		if(ctlname=="allowanceline_no" || ctlname=="allowanceline_amount"){
		
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmEmployee'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmEmployee'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmEmployee'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
		}
		
		i++;
		
	}

	
	return true;
	}


	function validateEmployee(){
		
		if(confirm("Save Record?")){
			return validateData();	
		}else
			return false;
		
	}
	
	function validateEmployee1(){
		
		var employee_no=document.frmEmployee.employee_no.value;
		var employee_name=document.frmEmployee.employee_name.value;
		var ic_no=document.frmEmployee.ic_no.value;
		var dateofbirth=document.frmEmployee.dateofbirth.value;
		var allowance1=document.frmEmployee.allowance1.value;
		var allowance2=document.frmEmployee.allowance2.value;
		var allowance3=document.frmEmployee.allowance3.value;
		var basic_salary=document.frmEmployee.basic_salary.value;
		var socso_employee=document.frmEmployee.socso_employee.value;
		var socso_employer=document.frmEmployee.socso_employer.value;
		var epf_employee=document.frmEmployee.epf_employee.value;
		var epf_employer=document.frmEmployee.epf_employer.value;


		if (confirm("Confirm to save record?")){
			if(employee_no !="" && employee_name!="" && ic_no!="" && dateofbirth!=""&& allowance1!=""&& allowance2!=""&& allowance3!=""&& basic_salary!=""){

				if(!IsNumeric(basic_salary)||!IsNumeric(socso_employee)||!IsNumeric(socso_employer)||!IsNumeric(epf_employee)||!IsNumeric(epf_employer)){
				alert("Please make sure basic salary, socso employee, socso employer, epf employee and epf employer is numeric");
				return false;
				}else{
				return true;
				}
				
			}
			else	{
				alert ("Please make sure Employee No, Employee Name, IC Number,\\nAllowance,  Basic Salary and Date of Birth is not empty.");
				return false;
				}
		}
		else
			return false;
	}
	

/*	function showAddressWindow(address_id){
		window.open('address.php?address_id='+address_id+'&action=edit', "Editing address", "width=600,height=500,scrollbars=yes");
	}*/
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
$o->joindate=$_POST["joindate"];
$o->epf_no=$_POST["epf_no"];
$o->socso_no=$_POST["socso_no"];
$o->account_no=$_POST["account_no"];
$o->hp_no=$_POST["hp_no"];
$o->remarks=$_POST["remarks"];

$o->street1=$_POST["street1"];
$o->street2=$_POST["street2"];
$o->postcode=$_POST["postcode"];
$o->city=$_POST["city"];
$o->state=$_POST["state"];
$o->country=$_POST["country"];

$o->basic_salary=$_POST["basic_salary"];
$o->socso_employee=$_POST["socso_employee"];
$o->socso_employer=$_POST["socso_employer"];
$o->epf_employee=$_POST["epf_employee"];
$o->epf_employer=$_POST["epf_employer"];
$o->allowance1=$_POST["allowance1"];
$o->allowance2=$_POST["allowance2"];
$o->allowance3=$_POST["allowance3"];
$o->allowance_name1=$_POST["allowance_name1"];
$o->allowance_name2=$_POST["allowance_name2"];
$o->allowance_name3=$_POST["allowance_name3"];

//line
$o->allowanceline_id=$_POST["allowanceline_id"];
$o->allowanceline_no=$_POST["allowanceline_no"];
$o->allowanceline_name=$_POST["allowanceline_name"];
$o->allowanceline_amount=$_POST["allowanceline_amount"];
$o->allowanceline_epf=$_POST["allowanceline_epf"];
$o->allowanceline_socso=$_POST["allowanceline_socso"];
$o->allowanceline_active=$_POST["allowanceline_active"];


$o->tel_1=$_POST["tel_1"];
//$o->address_id=$_POST["address_id"];
$o->uid=$_POST['uid'];
$o->isAdmin=$xoopsUser->isAdmin();
$o->races_id=$_POST['races_id'];
$o->stafftype_id=$_POST["stafftype_id"];
$o->showcalendar=$dp->show("dateofbirth");
$o->showcalendar2=$dp->show("joindate");
$o->cashonhand=$_POST["cashonhand"];
$o->organization_id=$_POST["organization_id"];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

//$ad->createdby=$xoopsUser->getVar('uid');
//$ad->updatedby=$xoopsUser->getVar('uid');
$o->orgWhereString=$o->orgWhereStr($xoopsUser->getVar('uid'));
$isactive=$_POST['isactive'];
$isdefault=$_POST['isdefault'];

$o->cur_symbol = $cur_symbol;

if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';

if ($isdefault=="Y" or $isdefault=="on")
	$o->isdefault='Y';
else
	$o->isdefault='N';


 switch ($action){
	//When user submit new organization


  case "create" :
		// if the token is exist and not yet expired
	if ($s->check(false,$token,"CREATE_EMP")){
		
		
//		$newaddress_id=$ad->createBlankAddress($ad->createdby);//create new address for employee
//		if($newaddress_id>=0){
//			$o->address_id=$newaddress_id;
		//if organization saved
			if($o->insertEmployee()){
				 $latest_id=$o->getLatestEmployeeID();
				 redirect_header("employee.php?action=edit&employee_id=$latest_id",$pausetime,"Your data is saved.");
			}
			else {
				echo "<strong style='color:#ff0000;'>Data can't save, please verified your IC and Employee Number is unique</strong>";
				$token=$s->createToken($tokenlife ,"CREATE_EMP");
				
				$o->stafftypectrl=$t->getSelectStafftype(0);
				$o->userctrl=$o->selectAvailableSysUser(0);
				$o->orgctrl=$o->selectionOrg($o->createdby,0);
				$o->racesctrl=$r->getSelectRaces($o->races_id);
				$o->getInputForm("edit",0,$token);
				//$o->showEmployeeTable();
			}
//		}
//		else{
//			echo "Can't create employee, suspected error cause from failed to produce new address for employee";
//		}
	}

	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_EMP");
		$o->userctrl=$o->selectAvailableSysUser(0);
		$o->orgctrl=$o->selectionOrg($o->createdby,0);
		$o->stafftypectrl=$t->getSelectStafftype($o->stafftype_id);
		$o->racesctrl=$r->getSelectRaces($o->races_id);
		$o->getInputForm("new",-1,$token);
		//$o->showEmployeeTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchEmployee($o->employee_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_EMP"); 
		$o->orgctrl=$o->selectionOrg($o->createdby,$o->organization_id);
		$o->userctrl=$o->selectAvailableSysUser($o->uid);
		$o->racesctrl=$r->getSelectRaces($o->races_id);
		$o->stafftypectrl=$t->getSelectStafftype($o->stafftype_id);
		$o->getInputForm("edit",$o->employee_id,$token);
		//$o->showEmployeeTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("employee.php",$pausetime,"Some error on viewing your employee data, probably database corrupted");

break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_EMP")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateEmployee()) //if data save successfully
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
		else
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_EMP")){
		if($o->deleteEmployee($o->employee_id))
			redirect_header("employee.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

  case "validate" :
	
	$post_fld = $_POST['name'];
	
echo <<< EOF
	<script type="text/javascript" >
	self.parent.document.getElementById('show').innerHTML = "$post_fld";
	</script>

EOF;
  break;


  case "addline" :

	if ($s->check(false,$token,"CREATE_EMP")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$fldpayment = $_POST['fldPayment'];
		
		if($o->updateEmployee()) {

			if($o->insertLine($fldpayment)) {
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
			}else{
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
			}
		}
		else
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;

  case "deleteline" :
	if ($s->check(false,$token,"CREATE_EMP")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		$line = $_POST['line'];

		if($o->updateEmployee()) {

			if($o->deleteLine($line)) {
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Your data is saved.");
			}else{
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't delete the data!");
			}
		
		}
		else
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;


  case "selectemployee" :
	$o->showEmployeeTable();
  break;

  default :
	$token=$s->createToken($tokenlife ,"CREATE_EMP");
	$o->userctrl=$o->selectAvailableSysUser(0);
	$o->racesctrl=$r->getSelectRaces(0);
	$o->stafftypectrl=$t->getSelectStafftype(0);
	$o->orgctrl=$o->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	//$o->showEmployeeTable();
  break;

  

}
require(XOOPS_ROOT_PATH.'/footer.php');
?>

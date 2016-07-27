<?php
include "system.php" ;
require ("menu.php");
include_once './class/Employee.php';
include_once './class/Address.php';
include_once './class/Log.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


echo <<< EOF
<script type="text/javascript">

	function validateAddress(){
	
	
		if (confirm("Confirm to save record?")){
			return true;
		}
		else
			return false;
}
</script>
EOF;


$log = new Log();
$e = new Employee($xoopsDB,$tableprefix,$log,$ad);
$o= new Address($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity();



$action="";
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->address_id=$_POST["address_id"];
$o->student_id=$_POST["student_id"];
$o->employee_id=$_POST["employee_id"];
}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->address_id=$_GET["address_id"];
$o->student_id=$_GET["student_id"];
$o->employee_id=$_GET["employee_id"];
}


else
$action="";

$token=$_POST['token'];
$o->no=$_POST["no"];
$o->address_name=$_POST["address_name"];
$o->street1=$_POST["street1"];
$o->street2=$_POST["street2"];
$o->postcode=$_POST["postcode"];
$o->city=$_POST["city"];
$o->state=$_POST["state"];
$o->country=$_POST["country"];
$isactive=$_POST['isactive'];
$o->area_id=$_POST["area_id"];
$o->organization_id=$_POST["organization_id"];

if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';

 switch ($action){
	//When user submit new address
  case "create" :
		// if the token is exist and not yet expired
	if ($s->check(false,$token,"CREATE_ADD")){
		$o->createdby=$xoopsUser->getVar('uid');
		$o->updatedby=$xoopsUser->getVar('uid');
		//create new address for organization
		//if address saved
		if($o->insertAddress( )){
		 $latest_id=$o->getLatestAddressID();
		$o->fetchStudentInfo($o->student_id);
		 redirect_header("address.php?action=edit&address_id=$latest_id&employee_id=$o->employee_id&student_id=$o->student_id",$pausetime,"Your data is saved.");
		}
		else 
			echo "Can't create address service record!";
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_ADD");
		$o->orgctrl=$e->selectionOrg($xoopsUser->getVar('uid'),$o->orgaization_id);
		 $latest_id=$o->getLatestAddressID();
		if($o->student_id>'0')
		{$o->fetchStudentInfo($o->student_id);
		$o->showAddressTable();}
		$o->getInputForm("new",-1,$token, $o->student_id);

	}
 
break;

	//when user request to edit particular address
  case "edit" :
	if($o->student_id>'0')
		{$o->fetchStudentInfo($o->student_id);	
		}
	if($o->employee_id>'0')
		{$o->fetchEmployeeInfo($o->employee_id);	
		}
	if($o->fetchAddress($o->address_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ADD"); 
		$o->orgctrl=$e->selectionOrg($xoopsUser->getVar('uid'),$o->orgaization_id);
		$o->getInputForm("edit",$o->address_id,$token,$o->student_id);
		if($o->student_id>'0')
		{	
			$o->showAddressTable(); 
		}
	}
	else	//if can't find particular address from database, return error message
		redirect_header("address.php",$pausetime,"Some error on viewing your address service data, probably database corrupted");
  
break;
//when user press save for change existing address data
  case "update" :

	if ($s->check(false,$token,"CREATE_ADD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateAddress()) //if data save successfully
			redirect_header("address.php?action=edit&address_id=$o->address_id&student_id=$o->student_id",$pausetime,"Update: Your data is saved.");
		else
			redirect_header("address.php?action=edit&address_id=$o->address_id&student_id=$o->student_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("address.php?action=edit&address_id=$o->address_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "updateE" :
	if ($s->check(false,$token,"CREATE_ADD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateAddress()) //if data save successfully
			redirect_header("closeme.html",$pausetime,"Update: Your data is saved.");
		/*	redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Update: Your data is saved.");
		else
			redirect_header("employee.php?action=edit&employee_id=$o->employee_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
*/

echo <<< EOF

<html>

<body onLoad="window.opener.location.reload(true); self.close();">
</body>
</html>

EOF;

		}
	else{
		redirect_header("address.php?action=edit&address_id=$o->address_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ADD")){
		if($o->delAddress($o->address_id))
			redirect_header("address.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("address.php?action=edit&address_id=$o->address_id&student_id=$o->student_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("address.php?action=edit&address_id=$o->address_id&student_id=$o->student_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_ADD");
	$o->orgctrl=$e->selectionOrg($xoopsUser->getVar('uid'),0);
	if($o->student_id>'0')
	{$o->fetchStudentInfo($o->student_id);}
	if($o->employee_id>'0')
	{$o->fetchEmployeeInfo($o->employee_id);}
	$o->getInputForm("new",0,$token,$o->student_id);
	if($o->student_id>'0')
	{$o->showAddressTable();}
  break;

}
require(XOOPS_ROOT_PATH.'/footer.php');
?>

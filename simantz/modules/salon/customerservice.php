<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Customerservice.php';
include_once 'class/Uom.php';

include_once 'class/Employee.php';
include_once 'class/Customer.php';
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Customerservice($xoopsDB,$tableprefix,$log);
$c = new Customer($xoopsDB,$tableprefix,$log);

$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);
$u = new Uom($xoopsDB,$tableprefix,$log);

$o->orgctrl="";
$o->customerctrl="";


$action="";

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Customer Services</span></big></big></big></div><br>

<script type="text/javascript">

	function searchCustomer(){//searching
		document.forms['frmSearch'].action.value = "search";
		document.forms['frmSearch'].fldShow.value = "Y";
		document.forms['frmSearch'].submit();
	}

	function showSearch(){//show search form
		document.forms['frmCustomerservice'].action.value = "search";
		document.forms['frmCustomerservice'].submit();
	}

	function autofocus(){
	document.forms['frmCustomerservice'].customerservice_name.focus();
	}

	function tableFilter(customer_id){
	document.forms['frmATZ'].filterstring.value = customer_id;
	document.forms['frmATZ'].submit();
	}

	function validateCustomerservice(){
	
		var code=document.forms['frmCustomerservice'].customerservice_no.value;
		var customer_id=document.forms['frmCustomerservice'].customer_id.value;

		
		if(confirm("Save Record?")){
		if(customer_id == 0 || code==""){
			alert('Please make sure Customer Service no and Customer is filled in');
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


if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->customerservice_id=$_POST["customerservice_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->customerservice_id=$_GET["customerservice_id"];

}
else
$action="";
$token=$_POST['token'];

$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	

$o->customerservice_no=$_POST["customerservice_no"];
$o->customerservice_date=$_POST["customerservice_date"];
$o->organization_id=$_POST["organization_id"];
$o->isAdmin=$xoopsUser->isAdmin();
$o->customer_id=$_POST['customer_id'];
$o->employee_id=$_POST['employee_id'];
$o->remarks=$_POST['remarks'];

$isactive=$_POST['isactive'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->deleteAttachment=$_POST['deleteAttachment'];

$tmpfile= $_FILES["upload_file"]["tmp_name"];
$filesize=$_FILES["upload_file"]["size"] / 1024;
$filetype=$_FILES["upload_file"]["type"];
$filename=$_FILES["upload_file"]["name"];

if($filename!="")
$withfile='Y';
else
$withfile='N';

$file_ext = strrchr($filename, '.');
$o->filename=$o->customerservice_id.$file_ext;
$newfilename=$o->customerservice_id.$file_ext;


if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
elseif($isactive=="X")
	$o->isactive='X';
else
	$o->isactive='N';

if($o->customer_id=="")
$o->customer_id=0;


$o->start_date=$_POST["start_date"];
$o->end_date=$_POST["end_date"];
$o->datectrl=$dp->show("customerservice_date");
$o->startctrl=$dp->show("start_date");
$o->endctrl=$dp->show("end_date");

if($_POST['filterstring']!="")
$o->filterstring = $_POST['filterstring'];
else
$o->filterstring = $o->getFirstCategory();

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired


	if ($s->check(false,$token,"CREATE_PRD")){
		$log->showLog(4,"Accessing create record event, with customerservice name=$o->customerservice_name");


		if($o->insertCustomerservice()){
			$latest_id=$o->getLatestCustomerserviceID();
			$o->customerservice_id=$o->getLatestCustomerserviceID();
			/*
			if($filesize>0 || $filetype=='application/pdf')
			$o->savefile($tmpfile);*/
			$newfilename=$o->customerservice_id.$file_ext;
			$o->filename=$o->customerservice_id.$file_ext;
			
			if($filesize>0)
			$o->savefile($tmpfile,$newfilename);
			

			redirect_header("customerservice.php?action=edit&customerservice_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create customerservice!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_PRD");
		$o->customerctrl=$c->getSelectCustomer($o->customer_id);
		$o->employeectrl=$e->getEmployeeList($o->employee_id);

		$o->uomctrl=$u->getSelectUom($o->uom_id);
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);

		$o->getInputForm("new",-1,$token);
		//$o->showCustomerserviceTable($o->customer_id,$c->getSelectCustomer($o->customer_id,"onchange='tableFilter(this.value)'")); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchCustomerserviceInfo($o->customerservice_id)){
		
		$o->searchAToZ($c->getSelectCustomer($o->customer_id,"onchange='tableFilter(this.value)'"));
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->customerctrl=$c->getSelectCustomer($o->customer_id);
		$o->employeectrl=$e->getEmployeeList($o->employee_id);

		$o->uomctrl=$u->getSelectUom($o->uom_id);
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_PRD"); 
		$o->getInputForm("edit",$o->customerservice_id,$token);
		//$o->showCustomerserviceTable($o->customer_id,$c->getSelectCustomer($o->customer_id,"onchange='tableFilter(this.value)'")); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("customerservice.php",3,"Some error on viewing your customerservice data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_PRD")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateCustomerservice($withfile)) {
			//if data save successfully
			//
			if($o->deleteAttachment=='on')
				$o->deletefile($o->customerservice_id);
			
			if($filesize>0)
				$o->savefile($tmpfile,$newfilename);
		
			redirect_header("customerservice.php?action=edit&customerservice_id=$o->customerservice_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("customerservice.php?action=edit&customerservice_id=$o->customerservice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("customerservice.php?action=edit&customerservice_id=$o->customerservice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_PRD")){
		if($o->deleteCustomerservice($o->customerservice_id)){
			redirect_header("customerservice.php",$pausetime,"Data removed successfully.");
			$o->deletefile($o->customerservice_id);
		}
		else
			redirect_header("customerservice.php?action=edit&customerservice_id=$o->customerservice_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("customerservice.php?action=edit&customerservice_id=$o->customerservice_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

  case "search" :
	$o->searchAToZ($c->getSelectCustomer($o->filterstring,"onchange='tableFilter(this.value)'"));
	$token=$s->createToken($tokenlife,"CREATE_PRD");
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->customerctrl=$c->getSelectCustomer(0);
	$o->employeectrl=$e->getEmployeeList(0);

	$o->uomctrl=$u->getSelectUom(0);
	//$o->getInputForm("new",0,$token);
	$o->showCustomerserviceTable($o->filterstring,$c->getSelectCustomer($o->customer_id,"onchange='tableFilter(this.value)'"),$action);
  break;

  default :
	if($o->customer_id != 0)
	$customer_id = $o->customer_id;
	else
	$customer_id = $o->customer_id;

	$o->searchAToZ($c->getSelectCustomer($o->filterstring,"onchange='tableFilter(this.value)'"));
	$token=$s->createToken($tokenlife,"CREATE_PRD");
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->customerctrl=$c->getSelectCustomer($customer_id);
	$o->employeectrl=$e->getEmployeeList(0);

	$o->uomctrl=$u->getSelectUom(0);
	
	$o->getInputForm("new",$customer_id,$token);
	//$o->showCustomerserviceTable($o->filterstring,$c->getSelectCustomer($o->customer_id,"onchange='tableFilter(this.value)'"));
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/EmpPayslipItem.php';
include_once 'class/Employee.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new EmpPayslipItem($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmEmpPayslipItem'].emppayslipitem_name.focus();
	}
	function validateEmpPayslipItem(){
		var name=document.forms['frmEmpPayslipItem'].emppayslipitem_name.value;
		var amount=document.forms['frmEmpPayslipItem'].amount.value;
		var seqno=document.forms['frmEmpPayslipItem'].seqno.value;
		if(confirm('Save Record?')){
		
		if(name =="" || amount=="" || seqno=="" || !IsNumeric(seqno) || !IsNumeric(amount) ){
			alert("Please make sure 'Item Name, Amount and Sequence No' is filled in with proper value.");
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

$o->emppayslipitem_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->emppayslipitem_id=$_POST["emppayslipitem_id"];
	$o->employee_id=$_POST["employee_id"];
}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->emppayslipitem_id=$_GET["emppayslipitem_id"];
	$o->employee_id=$_GET["employee_id"];

}
else
$action="";

$token=$_POST['token'];
$o->emppayslipitem_description=$_POST["emppayslipitem_description"];
$o->emppayslipitem_name=$_POST["emppayslipitem_name"];
$o->seqno=$_POST['seqno'];

if($_POST['calc_epf']=='on')
$o->calc_epf=1;
else
$o->calc_epf=0;

if($_POST['calc_socso']=='on')
$o->calc_socso=1;
else
$o->calc_socso=0;

$o->linetype=$_POST['linetype'];
$o->amount=$_POST['amount'];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	
$isactive=$_POST['isactive'];

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
	$log->showLog(4,"Accessing create record event, with emppayslipitem name=$o->emppayslipitem_name");

	if ($s->check(false,$token,"CREATE_EMPITEM")){
		
		
		
	if($o->insertEmpPayslipItem()){
		 $latest_id=$o->getLatestEmpPayslipItemID();
			 redirect_header("emppayslipitem.php?action=edit&emppayslipitem_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create emppayslipitem!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken(120,"CREATE_EMPITEM");
		$o->orgctrl=$permission->selectionOrg($o->created,$organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showEmpPayslipItemTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :

	if($o->fetchEmpPayslipItem($o->emppayslipitem_id)){
		//create a new token for editing a form
		//$orgwhereaccess=$orgwhereaccess
		$e->fetchEmployee($o->employee_id);
		$e->showEmployeeHeader();
		$token=$s->createToken(120,"CREATE_EMPITEM"); 

		$o->getInputForm("edit",$o->emppayslipitem_id,$token);
		$o->showEmpPayslipItemTable("WHERE employee_id>0 and employee_id=$o->employee_id","ORDER BY seqno"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("emppayslipitem.php",3,"Some error on viewing your emppayslipitem data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_EMPITEM")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateEmpPayslipItem()) //if data save successfully
			redirect_header("emppayslipitem.php?action=edit&emppayslipitem_id=$o->emppayslipitem_id",$pausetime,"Your data is saved.");
		else
			redirect_header("emppayslipitem.php?action=edit&emppayslipitem_id=$o->emppayslipitem_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("emppayslipitem.php?action=edit&emppayslipitem_id=$o->emppayslipitem_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_EMPITEM")){
		if($o->deleteEmpPayslipItem($o->emppayslipitem_id))
			redirect_header("emppayslipitem.php?action=default&employee_id=$o->employee_id",$pausetime,"Data removed successfully.");
		else
			redirect_header("emppayslipitem.php?action=edit&emppayslipitem_id=$o->emppayslipitem_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("emppayslipitem.php?action=edit&emppayslipitem_id=$o->emppayslipitem_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  default :
	$e->fetchEmployee($o->employee_id);
	$e->showEmployeeHeader();
	$token=$s->createToken(120,"CREATE_EMPITEM");
	$o->getInputForm("new",0,$token);
	$o->showEmpPayslipItemTable("WHERE employee_id>0 and employee_id=$o->employee_id","ORDER BY seqno");
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

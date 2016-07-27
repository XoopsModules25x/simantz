<?php
include_once "system.php";
include_once "menu.php";
include_once "class/RegProduct.php";
include_once "class/Log.php";
include_once "class/Employee.php";
include_once "class/Student.php";
include_once "class/TuitionClass.php";
include_once "class/Area.php";
include_once "datepicker/class.datepicker.php";
include_once 'class/Product.php';
$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$log = new Log();

$t = new Student($xoopsDB,$tableprefix,$log);
$c = new TuitionClass($xoopsDB,$tableprefix,$log);
$o = new RegProduct($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);
$a = new Area($xoopsDB,$tableprefix,$log);
$p = new Product($xoopsDB,$tableprefix,$log);
$action="";
echo <<< EOF

<script type="text/javascript">

	function autofocus(){
	
		document.forms['frmSearchStudent'].student_code.focus();
	}

	function validateRegProduct(){
	
	var movement_id=document.frmRegProduct.movement_id.value;
	var transactiondate=document.frmRegProduct.transactiondate.value;
	if(confirm("Do you want to save this record? ")){
		if(movement_id<1 || !isDate(transactiondate) || transactiondate==''){
			alert('Data cannot save! Please make sure movement id not null and data format in transaction date column is correct');
			return false;
		}
		else
			return true;
	}
	else
		return false;
	 	
	}
		

	function zoomProduct(){

		var id=document.frmRegProduct.movement_id.value;
		if(id!="")
		window.open("inventorymovement.php?action=edit&movement_id="+id);
	}

</script>
EOF;


if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->studentclass_id=$_POST["studentclass_id"];
	$o->student_id=$_POST["student_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->studentclass_id=$_GET["studentclass_id"];
	$o->student_id=$_GET["student_id"];
}
else
$action="";

//search information
$o->student_code=$_POST['student_code'];
$o->student_name=$_POST['student_name'];
$o->ic_no=$_POST['ic_no'];
$o->description=$_POST['description'];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$o->tuitionclass_id=$_POST['tuitionclass_id'];
//$o->backareafrom_id=$_POST['backareafrom_id'];
$o->backareato_id=$_POST['backareato_id'];
$o->comeareafrom_id=$_POST['comeareafrom_id'];
//$o->comeareato_id=$_POST['comeareato_id'];
$o->trainingfees=$_POST['trainingfees'];
$o->includeall=$_POST['includeall'];
$o->transportfees=$_POST['transportfees'];
$o->futuretrainingfees=$_POST['futuretrainingfees'];
$o->futuretransportfees=$_POST['futuretransportfees'];
if($_POST['movement_id']!="")
$o->movement_id=$_POST['movement_id'];
else
$o->movement_id==0;

if($_POST['updatestandard']=='on')
	$o->updatestandard=true;
else
	$o->updatestandard=false;

//$o->transportationmethod=$_POST['transportationmethod'];
$o->transactiondate=$_POST['transactiondate'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->showcalendar=$dp->show("transactiondate");
$o->showdatefrom=$dp->show("datefrom");
$o->showdateto=$dp->show("dateto");
$o->datefrom=$_POST['datefrom'];
$o->dateto=$_POST['dateto'];
$o->isAdmin=$xoopsUser->isAdmin();
$token=$_POST['token'];
$o->organization_id=$_POST['organization_id'];
$o->amt=$_POST['amt'];


$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');

if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';
if ($comeactive=="Y" or $comeactive=="on")
	$o->comeactive='Y';
else
	$o->comeactive='N';
if ($backactive=="Y" or $backactive=="on")
	$o->backactive='Y';
else
	$o->backactive='N';


switch ($action){
 case "create":
	if ($s->check(false,$token,"CREATE_REGC")){
		$log->showlog(3,"Saving data for Student_id=$o->student_id, and class_id=$o->movement_id");
		if($o->insertRegProduct()){
		 $latest_id=$o->getLatestStudentProductID();
		 redirect_header("regproduct.php?action=edit&studentclass_id=$latest_id",$pausetime,"Your data is saved.");
		}
		else{
			$log->showLog(1,"Warning! This record cannot save, please verified your data.");
	
		$o->student_code=$t->student_code;
		$o->student_name=$t->student_name;
		$o->ic_no=$t->ic_no;
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->showRegistrationHeader();
		$o->showRegisteredTable('student',"WHERE sc.student_id=$o->student_id and  i.movement_id>0",
				'ORDER BY sc.transactiondate','regproduct');
		$o->movementctrl=$o->getUnpaidProduct($o->movement_id,$o->student_id);
		$o->productctrl=$p->getSelectProduct($o->product_od,'Y');
		$token=$s->createToken($tokenlife,"CREATE_REGC");
		$o->showInputForm('new',0,$token);
		}

//		redirect_header("regproduct.php?action=choose&student_id=$o->student_id",$pausetime,"You data cannot be save, return to previous page");
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showlog(3,"Choose Student_id=$o->student_id for class registration");
		if($t->fetchStudentInfo($o->student_id)){
		$log->showLog(1,"Warning! This record cannot save due to token expired, please resave this record.");
		$o->student_code=$t->student_code;
		$o->student_name=$t->student_name;
		$o->ic_no=$t->ic_no;
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->showRegistrationHeader();
		$o->showRegisteredTable('student',"WHERE sc.student_id=$o->student_id and  i.movement_id>0",
				'ORDER BY sc.transactiondate','regproduct');
		$o->movementctrl=$o->getUnpaidProduct($o->movement_id,$o->student_id);
		$o->productctrl=$p->getSelectProduct($o->product_od,'Y');
		$token=$s->createToken($tokenlife,"CREATE_REGC");
		$o->showInputForm('new',0,$token);
//			$o->transportFees($o->transportationmethod,$o->orgctrl,$o->areacf_ctrl);

		}
		else
			$log->showlog(1,"Error: can't retrieve student information: $o->student_id");
	}
 break;
 case "choosed":
	$log->showlog(3,"Choose Student_id=$o->student_id for class registration");
	if($t->fetchStudentInfo($o->student_id)){
		
		$o->student_code=$t->student_code;
		$o->student_name=$t->student_name;
		$o->ic_no=$t->ic_no;
		$o->orgctrl=$permission->selectionOrg($o->createdby,$defaultorganization_id);
		$o->showRegistrationHeader();
		$o->showRegisteredTable('student',"WHERE sc.student_id=$o->student_id and  i.movement_id>0",
				'ORDER BY sc.transactiondate','regproduct');
		$o->movementctrl=$o->getUnpaidProduct(0,$o->student_id);
		$o->productctrl=$p->getSelectProduct(0,'Y');
		$token=$s->createToken($tokenlife,"CREATE_REGC");
		$o->showInputForm('new',0,$token);
	}
	else
		$log->showlog(1,"Error: can't retrieve student information: $o->student_id");
 break;
 case "update":
	$log->showlog(3,"Saving data for Student_id=$o->student_id, and class_id=$o->studentclass_id");
	if ($s->check(false,$token,"CREATE_REGC")){
		if($o->updateStudentClass()){ //if data save successfully
			if($o->updatestandard)
				$o->updateStudentStandard();
			redirect_header("regproduct.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("regproduct.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"$errorstart Warning! Can't save the data, please make sure all value is insert properly.$errorend");
		}
	else{
		redirect_header("regproduct.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"$errorstart Warning! Can't save this record due to token expired, please re-enter the data.$errorend");
	}
 break;
 case "search":
	$log->showlog(3,"Search Student_id=$o->student_id,student_code=$o->student_code,student_name=$o->student_name,ic_no=$o->ic_no");
	$wherestring= cvSearchString($o->student_id,$o->student_code,$o->student_name,$o->ic_no);

	$wherestring .= " and s.organization_id = $defaultorganization_id ";
	if($o->student_id==0){
		if ($wherestring!="")
			$wherestring="WHERE " . $wherestring;
			echo '<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big>'.
				'<span style="font-weight: bold;">Choose Student for Product Collection</span></big></big></big></div><br>';
			$t->showStudentTable($wherestring," ORDER BY student_name",0,'regproduct');
	}
	else
		redirect_header("regproduct.php?action=choosed&student_id=$o->student_id",$pausetime,"Opening Student for registration.");
 break;
 case "delete":
	if ($s->check(false,$token,"CREATE_REGC")){
		if($o->deleteStudentClass($o->studentclass_id))
			redirect_header("regproduct.php?action=choosed&student_id=$o->student_id",$pausetime,"Data removed successfully.");
		else
			redirect_header("regproduct.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"$errorstart Warning! Can't delete data from database due to dependency error. $errorend.");
	}
	else
		redirect_header("regproduct.php?action=edit&studentclass_id=$o->studentclass_id",$pausetime,"$errorstart Warning! Can't delete data from database due to token expired, please re-delete the data.$errorend.");
 break;
 case "edit":
	$log->showlog(3,"Editing data studentclass_id:$o->studentclass_id");
	if ($o->fetchRegProductInfo($o->studentclass_id)){
		if($t->fetchStudentInfo($o->student_id)){
			$o->student_code=$t->student_code;
			$o->student_name=$t->student_name;
			$o->ic_no=$t->ic_no;
		}
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->showRegistrationHeader();
		$o->productctrl=$p->getSelectProduct($o->product_id,'Y');
		$o->showRegisteredTable('student',"WHERE sc.student_id=$o->student_id and  i.movement_id>0",'ORDER BY sc.transactiondate');
		$o->movementctrl=$o->getUnpaidProduct($o->movement_id,$o->student_id);
		$token=$s->createToken($tokenlife,"CREATE_REGC");
		$o->showInputForm('edit',$o->studentclass_id,$token);
//		$o->transportFees($o->transportationmethod,$o->orgctrl,$o->areacf_ctrl);
//		$o->fetchRegClassInfo($o->studentclass_id);

	}
 break;
 case "filter":
 	$log->showlog(3,"Choose Student_id=$o->student_id for other sales, but filtering date between: $o->datefrom & $o->dateto");
	if($t->fetchStudentInfo($o->student_id)){
		
		$o->student_code=$t->student_code;
		$o->student_name=$t->student_name;
		$o->ic_no=$t->ic_no;
		$o->orgctrl=$permission->selectionOrg($o->createdby,0);
		$o->showRegistrationHeader();
		if($o->datefrom=="")
			$o->datefrom="0000-00-00";
		if($o->dateto=="")
			$o->dateto="3999-12-31";

		$o->showRegisteredTable('student',"WHERE sc.student_id=$o->student_id and ".
				"sc.transactiondate between '$o->datefrom' and '$o->dateto' and i.movement_id>0" , 'ORDER BY p.product_no','regproduct');
		$token=$s->createToken($tokenlife,"CREATE_REGC");
		$o->movementctrl=$o->getUnpaidProduct($o->movement_id,$o->student_id);
		$o->showInputForm('new',0,$token);
	}
	else
		$log->showlog(1,"Error: can't retrieve student information: $o->student_id");
 break;
 default:
	
	$o->studentctrl=$t->getStudentSelectBox(-1);
	$o->showSearchForm();
 break;


}


echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

//convert 4 criterial into 1 search string
function cvSearchString($student_id,$student_code,$student_name,$ic_no){
$filterstring="";
$needand="";
if($student_id > 0 ){
	$filterstring=$filterstring . " student_id=$student_id";
	$needand='AND';
}
else
	$needand='';

if($student_code!=""){
	$filterstring=$filterstring . " $needand student_code LIKE '$student_code' ";
	$needand='AND';
}
else
$needand='';

if ($student_name!=""){
$filterstring=$filterstring . " $needand student_name LIKE '$student_name'";
	$needand='AND';
}
else
	$needand='';

if($ic_no!="")
$filterstring=$filterstring . "  $needand ic_no LIKE '$ic_no'";
if($filterstring=="")
return "student_id>0";
else	
return "student_id>0 AND ".$filterstring;
}

?>

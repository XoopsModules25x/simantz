<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once '../simbiz/class/Overtime.php';
//include_once '../hr/class/Employee.php';
include_once "../../class/datepicker/class.datepicker.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';


//$log = new Log();
$o = new Overtime();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";

$o->stylewidthstudent = "style='width:200px'";

$action="";

//marhan add here --> ajax
echo "<iframe src='overtime.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">

function viewHours(value){
    if(value == "H")
    document.getElementById('idTimeHours').style.display = "";
    else
    document.getElementById('idTimeHours').style.display = "none";
}

function AddToInvoice(){

    if(validateOvertime()){
    document.forms['frmOvertime'].submit();
    }else{
    selectAll(false);
    }
}

function viewRemaining(){
    stylermng = document.getElementById('tblRemaining').style.display;

    if(stylermng == "none")
    document.getElementById('tblRemaining').style.display = "";
    else
    document.getElementById('tblRemaining').style.display = "none";
}

function viewStudentInvoice(studentinvoice_id){
window.open("viewovertime.php?studentinvoice_id="+studentinvoice_id);
}

function deductTotal(line){

studentinvoice_lineamt = parseFloat(document.getElementById('studentinvoice_lineamt'+line).value);
total_amt = parseFloat(document.forms['frmOvertime'].total_amt.value);

total_amt = total_amt - studentinvoice_lineamt;
document.forms['frmOvertime'].total_amt.value = total_amt.toFixed(2);
}

function updateTotal(){

 var i=0;
 var tot_amt = 0;
    while(i< document.forms['frmOvertime'].elements.length){
        var ctlname = document.forms['frmOvertime'].elements[i].name;
        var data = parseFloat(document.forms['frmOvertime'].elements[i].value);

        ctlname = ctlname.substring(0,ctlname.indexOf("["))
        if(ctlname=="studentinvoice_lineamt"){
        tot_amt += data;
        }

        i++;

    }

document.forms['frmOvertime'].total_amt.value = tot_amt.toFixed(2);

}

function updateAmount(line){
overtime_uprice = parseFloat(document.getElementById('overtime_uprice'+line).value);
overtime_qty = parseFloat(document.getElementById('overtime_qty'+line).value);

total_amt = (overtime_uprice*overtime_qty).toFixed(2);
document.getElementById('studentinvoice_lineamt'+line).value = total_amt;

updateTotal();
}

function viewProduct(){
    styleproduct = document.getElementById('idProductCtrl').style.display;

    if(styleproduct == "none")
    document.getElementById('idProductCtrl').style.display = "";
    else
    document.getElementById('idProductCtrl').style.display = "none";
}

function getProductInfo(product_id){
    var arr_fld=new Array("action","product_id");//name for POST
    var arr_val=new Array("getproductinfo",product_id);//value for POST

    getRequest(arr_fld,arr_val);
}

function viewRemarkLine(line){
    styleline = document.getElementById('idLineDesc'+line).style.display;

    if(styleline == "none")
    document.getElementById('idLineDesc'+line).style.display = "";
    else
    document.getElementById('idLineDesc'+line).style.display = "none";
}

function selectAll(val){

    var i=0;
    while(i< document.forms['frmOvertime'].elements.length){
    var ctlname = document.forms['frmOvertime'].elements[i].name;
    var data = document.forms['frmOvertime'].elements[i].value;

    ctlname = ctlname.substring(0,ctlname.indexOf("["))
    if(ctlname=="isselectremain"){

    document.forms['frmOvertime'].elements[i].checked = val;
    }

    i++;

}


}



function checkAddNote(){

    if(validateOvertime()){
    selectAll(false);
    document.forms['frmOvertime'].addnote_line.value = 1;
    document.forms['frmOvertime'].submit();
    }else
    return false;

}

function deleteSubLine(overtimeline_id,line){

 if(validateOvertime()){
    deductTotal(line);
    document.forms['frmOvertime'].deleteline_id.value = overtimeline_id;
    document.forms['frmOvertime'].submit();
}else{
    document.forms['frmOvertime'].deleteline_id.value = 0;
    return false;
}


/*
var arr_fld=new Array("action","overtimesubline_id","studentinvoice_id");//name for POST
var arr_val=new Array("deletelectline",overtimesubline_id,studentinvoice_id);//value for POST

getRequest(arr_fld,arr_val);
*/

}

function checkAddSelect(){

document.forms['frmOvertime'].addstudentinvoice_id.value = 1;
document.forms['frmOvertime'].submit();
}

function autofocus(){
document.forms['frmOvertime'].overtime_name.focus();
}
    function IsNumeric(sText)
{
   var ValidChars = "0123456789.-";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
   }


	function validateOvertime(){

		var employee_id =document.forms['frmOvertime'].employee_id.value;
        var overtimeline_starttime =document.forms['frmOvertime'].overtimeline_starttime.value;
        var overtimeline_endtime =document.forms['frmOvertime'].overtimeline_endtime.value;
        var overtimeline_totalhour =document.forms['frmOvertime'].overtimeline_totalhour.value;
        var overtimeline_date =document.forms['frmOvertime'].overtimeline_date.value;


			
		if(confirm("Save record?")){
		if(employee_id == 0 || overtimeline_starttime == "" || !IsNumeric(overtimeline_starttime) || overtimeline_endtime == "" || !IsNumeric(overtimeline_endtime) || overtimeline_totalhour == "" || !IsNumeric(overtimeline_totalhour)){
			alert('Please make sure Employee is Selected and Total Hours,Time In,Time Out is Filled In With Numeric Value.');
			return false;
		}
		else{
                if(!isDate(overtimeline_date))
                return false
                else
                return true;
            }
		}
		else
			return false;
	}
function gotoAction(action){
	document.forms['frmOvertime'].action.value = action;
	document.forms['frmOvertime'].submit();
	}

</script>

EOF;

$o->overtimeline_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->overtimeline_id=$_POST["overtimeline_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->overtimeline_id=$_GET["overtimeline_id"];

}
else
$action="";

$token=$_POST['token'];

$o->studentinvoice_date=$_POST["studentinvoice_date"];
$o->overtime_no=$_POST["overtime_no"];
$o->employee_id=$_POST["employee_id"];

$o->session_id=$_POST["session_id"];
$o->year_id=$_POST["year_id"];
$o->total_amt=$_POST["total_amt"];
$o->batch_id=$_POST["batch_id"];
$o->batch_no=$_POST["batch_no"];
$o->generatestudentinvoice_id=$_POST["generatestudentinvoice_id"];
$o->semester_id=$_POST["semester_id"];


$iscomplete=$_POST['iscomplete'];
$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();
$o->mid=$xoopsModule->getVar('mid');
$o->module_name=$xoopsModule->getVar('name');

$o->issearch=$_POST['issearch'];

$o->employee_name=$_POST['employee_name'];
$o->employee_no=$_POST['employee_no'];
$o->course_id=$_POST['course_id'];

$o->start_date=$_POST['start_date'];
$o->end_date=$_POST['end_date'];
$o->startctrl=$dp->show("start_date");
$o->endctrl=$dp->show("end_date");

if ($iscomplete=="1" || $iscomplete=="on")
	$o->iscomplete=1;
else if ($iscomplete=="null")
	$o->iscomplete="null";
else
	$o->iscomplete=0;


//sub list


$o->employee_id=$_POST['employee_id'];
$o->overtimeline_date=$_POST['overtimeline_date'];
$o->overtimeline_starttime=$_POST['overtimeline_starttime'];
$o->overtimeline_endtime=$_POST['overtimeline_endtime'];
$o->overtimeline_totalhour=$_POST['overtimeline_totalhour'];
$o->overtimeline_type=$_POST['overtimeline_type'];
$o->line_desc=$_POST['line_desc'];
$o->overtimeline_totalamt=$_POST['overtimeline_totalamt'];

$o->overtimedatectrl=$dp->show("overtimeline_date");

//check user type
    $o->wherestremp = "";
    if($o->employee_id == "")
    $o->employee_id = 0;

    if($o->isAdmin){
    $searchbtn = "Y";
    $shownull = "Y";
    }else{
    $searchbtn = "N";
    $shownull = "N";

    $employee_id = $o->getEmployeeId($o->updatedby);
    if($employee_id >0){
    $wherestremp = " and employee_id =  $employee_id ";
    $o->wherestremp = " and ol.employee_id = $employee_id ";
    }else
    echo "<font color=red>Please Define User Login At HR Module.</font>";

    }
//end check

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with overtime name=$o->overtime_name");

	if ($s->check(false,$token,"CREATE_ACG")){
		
		
		
	if($o->insertOvertime()){
		 $latest_id=$o->getLatestOvertimeID();
         $log->saveLog($o->overtimeline_id,$tableovertimeline,"$o->changesql","I","O");
			 redirect_header("overtime.php?action=edit&overtimeline_id=$latest_id",$pausetime,"Your data is saved.");
		}
	else {
        $log->saveLog(0,$tableovertimeline,"$o->changesql","I","F");
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"N","","employee_id","$wherestremp","employee_id",$employeewidth,"$searchbtn",0);
        //$o->overtimetypectrl=$ctrl->getSelectOvertimetype($o->overtimetype_id,"Y");
		$o->getInputForm("new",-1,$token);
		//$o->showOvertimeTable("WHERE ol.overtimeline_id >= 0 ","ORDER BY ol.overtimeline_date,ol.employee_id");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
        $log->saveLog(0,$tableovertimeline,"$o->changesql","I","F");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"N","","employee_id","$wherestremp","employee_id",$employeewidth,"$searchbtn",0);
        //$o->overtimetypectrl=$ctrl->getSelectOvertimetype($o->overtimetype_id,"Y");
		$o->getInputForm("new",-1,$token);
		//$o->showOvertimeTable("WHERE ol.overtimeline_id >= 0 ","ORDER BY ol.overtimeline_date,ol.employee_id");
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchOvertime($o->overtimeline_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        //$o->overtimetypectrl=$ctrl->getSelectOvertimetype($o->overtimetype_id,"Y");
        $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"N","","employee_id","$wherestremp","employee_id",$employeewidth,"$searchbtn",0);
		$o->getInputForm("edit",$o->overtime,$token);
		//$o->showOvertimeTable("WHERE ol.overtimeline_id >= 0 ","ORDER BY si.defaultlevel,si.overtime_no");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("overtime.php",3,"Some error on viewing your overtime data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateOvertime()){ //if data save successfully
            $log->saveLog($o->overtimeline_id,$tableovertimeline,"$o->changesql","U","O");
                           
			redirect_header("overtime.php?action=edit&overtimeline_id=$o->overtimeline_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->overtimeline_id,$tableovertimeline,"$o->changesql","U","F");
			redirect_header("overtime.php?action=edit&overtimeline_id=$o->overtimeline_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog($o->overtimeline_id,$tableovertimeline,"$o->changesql","U","F");
		redirect_header("overtime.php?action=edit&overtimeline_id=$o->overtimeline_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteOvertime($o->overtimeline_id)){
            $log->saveLog($o->employee_id,$tableemployee,"$o->changesql","D","O");
			redirect_header("overtime.php",$pausetime,"Data removed successfully.");
        }else{
            $log->saveLog($o->employee_id,$tableemployee,"$o->changesql","D","F");
			redirect_header("overtime.php?action=edit&overtimeline_id=$o->overtimeline_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else
		redirect_header("overtime.php?action=edit&overtimeline_id=$o->overtimeline_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

    case "search" :

	$wherestr =" WHERE ol.overtimeline_id >= 0  ";

    $limitstr = "";
	if($o->issearch == "Y"){
	$wherestr .= $o->getWhereStr();
    }else{
    $limitstr = " limit 50 ";
	$o->overtimetype_id = 0;
    $o->course_id = 0;
    $o->semester_id = 0;
    $o->employee_id = 0;
	}

    $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"$shownull","","employee_id","$wherestremp","employee_id",$employeewidth,"$searchbtn",0);
	$o->showSearchForm();
	if($o->issearch == "Y")
    $o->showOvertimeTable($wherestr,"ORDER BY ol.overtimeline_date,ol.employee_id",$limitstr);
	//$o->showOvertimeTable($wherestr,"ORDER BY ol.overtimeline_date,ol.employee_id",$limitstr);
  break;

   case "getlistdbproduct" :
	$strchar = $_POST["strchar"];
	$idinput = $_POST["idinput"];
	$idlayer = $_POST["idlayer"];
	$ctrlid = $_POST["ctrlid"];
	$ocf = $_POST["ocf"];
	$line = $_POST["line"];
    $wherestr = $_POST["wherestr"];

    $wherestr = str_replace("#"," ",$wherestr);
    $wherestr = str_replace("*'","'",$wherestr);

	$selectionlist = $o->getSelectDBAjaxProduct($strchar,$idinput,$idlayer,$ctrlid,$ocf,$tableproduct,"product_id","product_name"," $wherestr ","$line");

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;

       case "getlistdbstudent" :
	$strchar = $_POST["strchar"];
	$idinput = $_POST["idinput"];
	$idlayer = $_POST["idlayer"];
	$ctrlid = $_POST["ctrlid"];
	$ocf = $_POST["ocf"];
	$line = $_POST["line"];
    $wherestr = $_POST["wherestr"];

    $wherestr = str_replace("#"," ",$wherestr);
    $wherestr = str_replace("*'","'",$wherestr);
    //echo $wherestr;

	$selectionlist = $o->getSelectDBAjaxStudent($strchar,$idinput,$idlayer,$ctrlid,$ocf,$tableemployee,"employee_id","student_name"," and isactive $wherestr ","$line");

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;
      
/*
  case "deletelectline" :

//if($o->updateOvertime()){ //if data save successfully
            //$log->saveLog($o->studentinvoice_id,$tableovertime,"$o->changesql","U","O");

      if($o->deleteLectLine($o->overtimesubline_id)){
       $log->saveLog($o->studentinvoice_id,$tableovertime,"$o->changesql","D","O");
      }else{
       $log->saveLog($o->studentinvoice_id,$tableovertime,"$o->changesql","D","F");
      }

echo <<< EOF
	<script type='text/javascript'>
    self.parent.location = "overtime.php?action=edit&studentinvoice_id=$o->studentinvoice_id";
	</script>
EOF;
 
  break;*/

  case "getproductinfo" :

    $product_id = $_POST['product_id'];

    $product_info = $o->getProductInfo($product_id);

    $product_name = $product_info["product_name"];
    $sellaccount_id = $product_info["sellaccount_id"];
    $invoice_amt = $product_info["invoice_amt"];

echo <<< EOF
    <script type='text/javascript'>
    self.parent.document.forms['frmOvertime'].studentinvoice_item.value = "$product_name";
    self.parent.document.forms['frmOvertime'].studentinvoice_lineamt.value = "$invoice_amt";
    </script>
EOF;

  break;

  case "getlistdbemployee" :
	$strchar = $_POST["strchar"];
	$idinput = $_POST["idinput"];
	$idlayer = $_POST["idlayer"];
	$ctrlid = $_POST["ctrlid"];
	$ocf = $_POST["ocf"];
	$line = $_POST["line"];
    $wherestr = $_POST["wherestr"];
    $wherestr = str_replace("#"," ",$wherestr);
    $wherestr = str_replace("*","'",$wherestr);

	$selectionlist = $o->getSelectDBAjaxEmployee($strchar,$idinput,$idlayer,$ctrlid,$ocf,$o->tableemployee,"employee_id","employee_name","$wherestr",0);

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;

  default :

    $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"N","","employee_id","$wherestremp","employee_id",$employeewidth,"$searchbtn",0);

    
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
    //$o->overtimetypectrl=$ctrl->getSelectOvertimetype($o->overtimetype_id,"Y");
    
    //$o->overtimectrl=$ctrl->getSelectOvertime($o->overtimectrl,"Y");
	$o->getInputForm("new",0,$token);
	//$o->showOvertimeTable("WHERE ol.overtimeline_id >= 0 ","ORDER BY ol.overtimeline_date,ol.employee_id", " limit 50 ");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

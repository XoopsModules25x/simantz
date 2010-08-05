<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once '../simbiz/class/Studentcharges.php';
//include_once 'class/SelectCtrl.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';


//$log = new Log();
$o = new Studentcharges();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";

$o->stylewidthstudent = "style='width:200px'";

$action="";

//marhan add here --> ajax
echo "<iframe src='studentcharges.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">

function AddToInvoice(){

    if(validateStudentcharges()){
    document.forms['frmStudentcharges'].submit();
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
window.open("viewstudentcharges.php?studentinvoice_id="+studentinvoice_id);
}

function deductTotal(line){

studentinvoice_lineamt = parseFloat(document.getElementById('studentinvoice_lineamt'+line).value);
total_amt = parseFloat(document.forms['frmStudentcharges'].total_amt.value);

total_amt = total_amt - studentinvoice_lineamt;
document.forms['frmStudentcharges'].total_amt.value = total_amt.toFixed(2);
}

function updateTotal(){

 var i=0;
 var tot_amt = 0;
    while(i< document.forms['frmStudentcharges'].elements.length){
        var ctlname = document.forms['frmStudentcharges'].elements[i].name;
        var data = parseFloat(document.forms['frmStudentcharges'].elements[i].value);

        ctlname = ctlname.substring(0,ctlname.indexOf("["))
        if(ctlname=="studentinvoice_lineamt"){
        tot_amt += data;
        }

        i++;

    }

document.forms['frmStudentcharges'].total_amt.value = tot_amt.toFixed(2);

}

function updateAmount(line){
studentcharges_uprice = parseFloat(document.getElementById('studentcharges_uprice'+line).value);
studentcharges_qty = parseFloat(document.getElementById('studentcharges_qty'+line).value);

total_amt = (studentcharges_uprice*studentcharges_qty).toFixed(2);
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
    while(i< document.forms['frmStudentcharges'].elements.length){
    var ctlname = document.forms['frmStudentcharges'].elements[i].name;
    var data = document.forms['frmStudentcharges'].elements[i].value;

    ctlname = ctlname.substring(0,ctlname.indexOf("["))
    if(ctlname=="isselectremain"){

    document.forms['frmStudentcharges'].elements[i].checked = val;
    }

    i++;

}


}



function checkAddNote(){

    if(validateStudentcharges()){
    selectAll(false);
    document.forms['frmStudentcharges'].addnote_line.value = 1;
    document.forms['frmStudentcharges'].submit();
    }else
    return false;

}

function deleteSubLine(studentinvoiceline_id,line){

 if(validateStudentcharges()){
    deductTotal(line);
    document.forms['frmStudentcharges'].deleteline_id.value = studentinvoiceline_id;
    document.forms['frmStudentcharges'].submit();
}else{
    document.forms['frmStudentcharges'].deleteline_id.value = 0;
    return false;
}


/*
var arr_fld=new Array("action","studentchargessubline_id","studentinvoice_id");//name for POST
var arr_val=new Array("deletelectline",studentchargessubline_id,studentinvoice_id);//value for POST

getRequest(arr_fld,arr_val);
*/

}

function checkAddSelect(){

document.forms['frmStudentcharges'].addstudentinvoice_id.value = 1;
document.forms['frmStudentcharges'].submit();
}

function autofocus(){
document.forms['frmStudentcharges'].studentcharges_name.focus();
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


	function validateStudentcharges(){

		var student_id =document.forms['frmStudentcharges'].student_id.value;
        var studentinvoice_lineamt =document.forms['frmStudentcharges'].studentinvoice_lineamt.value;
			
		if(confirm("Save record?")){
		if(student_id == 0 || studentinvoice_lineamt == "" || !IsNumeric(studentinvoice_lineamt)){
			alert('Please make sure Student is Selected and Amount is Filled In With Numeric Value.');
			return false;
		}
		else{
            return true;
            }
		}
		else
			return false;
	}
function gotoAction(action){
	document.forms['frmStudentcharges'].action.value = action;
	document.forms['frmStudentcharges'].submit();
	}

</script>

EOF;

$o->studentinvoiceline_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->studentinvoiceline_id=$_POST["studentinvoiceline_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->studentinvoiceline_id=$_GET["studentinvoiceline_id"];

}
else
$action="";

$token=$_POST['token'];

$o->studentinvoice_date=$_POST["studentinvoice_date"];
$o->studentcharges_no=$_POST["studentcharges_no"];
$o->student_id=$_POST["student_id"];

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

$o->student_name=$_POST['student_name'];
$o->student_no=$_POST['student_no'];
$o->course_id=$_POST['course_id'];

if ($iscomplete=="1" || $iscomplete=="on")
	$o->iscomplete=1;
else if ($iscomplete=="null")
	$o->iscomplete="null";
else
	$o->iscomplete=0;


//sub list
//$o->studentinvoiceline_id=$_POST['studentinvoiceline_id'];
$o->studentinvoiceline_no=$_POST['studentinvoiceline_no'];
$o->studentinvoice_item=$_POST['studentinvoice_item'];
$o->product_id=$_POST['product_id'];
$o->accounts_id=$_POST['accounts_id'];
$o->line_desc=$_POST['line_desc'];
$o->studentinvoice_lineamt=$_POST['studentinvoice_lineamt'];

$o->invoicedatectrl=$dp->show("studentinvoice_date");

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with studentcharges name=$o->studentcharges_name");


	if ($s->check(false,$token,"CREATE_ACG")){
		
		
		
	if($o->insertStudentcharges()){
		 $latest_id=$o->getLatestStudentchargesID();
         $log->saveLog($o->student_id,$tablestudent,"$o->changesql","I","O");
			 redirect_header("studentcharges.php?action=edit&studentinvoiceline_id=$latest_id",$pausetime,"Your data is saved.");
		}
	else {
        $log->saveLog(0,$tablestudent,"$o->changesql","I","F");
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
        $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
        $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        $o->productctrl = $ctrl->getSelectProduct($o->product_id,'Y',"onchange=getProductInfo(this.value);","product_id","","product_id","style='width:180px'",'Y',0);
        //$o->studentchargestypectrl=$ctrl->getSelectStudentchargestype($o->studentchargestype_id,"Y");
		$o->getInputForm("new",-1,$token);
		//$o->showStudentchargesTable("WHERE si.studentinvoice_id>=0 ","ORDER BY st.course_id,st.student_no");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
        $log->saveLog(0,$tablestudent,"$o->changesql","I","F");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
        $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
        $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        $o->productctrl = $ctrl->getSelectProduct($o->product_id,'Y',"onchange=getProductInfo(this.value);","product_id","","product_id","style='width:180px'",'Y',0);
        //$o->studentchargestypectrl=$ctrl->getSelectStudentchargestype($o->studentchargestype_id,"Y");
		$o->getInputForm("new",-1,$token);
		//$o->showStudentchargesTable("WHERE si.studentinvoice_id>=0 ","ORDER BY st.course_id,st.student_no");
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchStudentcharges($o->studentinvoiceline_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        //$o->studentchargestypectrl=$ctrl->getSelectStudentchargestype($o->studentchargestype_id,"Y");
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"N");
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
        $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
        $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        $o->productctrl = $ctrl->getSelectProduct($o->product_id,'Y',"onchange=getProductInfo(this.value);","product_id","","product_id","style='width:180px'",'Y',0);
		$o->getInputForm("edit",$o->studentcharges,$token);
		//$o->showStudentchargesTable("WHERE si.studentinvoice_id>=0 ","ORDER BY si.defaultlevel,si.studentcharges_no");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("studentcharges.php",3,"Some error on viewing your studentcharges data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateStudentcharges()){ //if data save successfully
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","U","O");
                           
			redirect_header("studentcharges.php?action=edit&studentinvoiceline_id=$o->studentinvoiceline_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","U","F");
			redirect_header("studentcharges.php?action=edit&studentinvoiceline_id=$o->studentinvoiceline_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog($o->student_id,$tablestudent,"$o->changesql","U","F");
		redirect_header("studentcharges.php?action=edit&studentinvoiceline_id=$o->studentinvoiceline_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteStudentcharges($o->studentinvoiceline_id)){
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","D","O");
			redirect_header("studentcharges.php",$pausetime,"Data removed successfully.");
        }else{
            $log->saveLog($o->student_id,$tablestudent,"$o->changesql","D","F");
			redirect_header("studentcharges.php?action=edit&studentinvoiceline_id=$o->studentinvoiceline_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else
		redirect_header("studentcharges.php?action=edit&studentinvoiceline_id=$o->studentinvoiceline_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

    case "search" :

	$wherestr =" WHERE si.studentinvoiceline_id>0  ";

    $limitstr = "";
	if($o->issearch == "Y"){
	$wherestr .= $o->getWhereStr();
    }else{
    $limitstr = " limit 50 ";
	$o->studentchargestype_id = 0;
    $o->course_id = 0;
    $o->semester_id = 0;
    $o->student_id = 0;
	}

	$o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
	$o->showSearchForm();
	if($o->issearch == "Y")
    $o->showStudentchargesTable($wherestr,"ORDER BY CAST(si.studentinvoiceline_no AS SIGNED)",$limitstr);
	//$o->showStudentchargesTable($wherestr,"ORDER BY st.course_id,st.student_no",$limitstr);
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

	$selectionlist = $o->getSelectDBAjaxStudent($strchar,$idinput,$idlayer,$ctrlid,$ocf,$tablestudent,"student_id","student_name"," and isactive $wherestr ","$line");

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;
      
/*
  case "deletelectline" :

//if($o->updateStudentcharges()){ //if data save successfully
            //$log->saveLog($o->studentinvoice_id,$tablestudentcharges,"$o->changesql","U","O");

      if($o->deleteLectLine($o->studentchargessubline_id)){
       $log->saveLog($o->studentinvoice_id,$tablestudentcharges,"$o->changesql","D","O");
      }else{
       $log->saveLog($o->studentinvoice_id,$tablestudentcharges,"$o->changesql","D","F");
      }

echo <<< EOF
	<script type='text/javascript'>
    self.parent.location = "studentcharges.php?action=edit&studentinvoice_id=$o->studentinvoice_id";
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
    self.parent.document.forms['frmStudentcharges'].studentinvoice_item.value = "$product_name";
    self.parent.document.forms['frmStudentcharges'].studentinvoice_lineamt.value = "$invoice_amt";
    </script>
EOF;

  break;

  default :
    if($o->studentchargestype_id=="")
    $o->studentchargestype_id=0;
    if($o->semester_id=="")
    $o->semester_id=0;
    if($o->year_id=="")
    $o->year_id=0;
    if($o->session_id=="")
    $o->session_id=0;
    if($o->student_id=="")
    $o->student_id=0;
    if($o->product_id=="")
    $o->product_id=0;

    
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
    //$o->studentchargestypectrl=$ctrl->getSelectStudentchargestype($o->studentchargestype_id,"Y");
    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
    
    $o->productctrl = $ctrl->getSelectProduct($o->product_id,'Y',"onchange=getProductInfo(this.value);","product_id","","product_id","style='width:180px'",'Y',0);
    //$o->studentchargesctrl=$ctrl->getSelectStudentcharges($o->studentchargesctrl,"Y");
	$o->getInputForm("new",0,$token);
	$o->showStudentchargesTable("WHERE si.studentinvoice_id>=0 ","ORDER BY st.course_id,st.student_no", " limit 50 ");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

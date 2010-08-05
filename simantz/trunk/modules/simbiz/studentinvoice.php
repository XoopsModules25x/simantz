<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once 'class/Studentinvoice.php';
//include_once 'class/SelectCtrl.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
include_once "../simbiz/class/AccountsAPI.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';


//$log = new Log();
$o = new Studentinvoice();
$s = new XoopsSecurity();
$api = new AccountsAPI();

$orgctrl="";

$o->stylewidthstudent = "style='width:200px'";

$action="";

//marhan add here --> ajax
echo "<iframe src='studentinvoice.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">

function invoiceEnable(){

    if(validateStudentinvoice()){
    selectAll(false);
    document.forms['frmStudentinvoice'].action.value = "reactivate";
    document.forms['frmStudentinvoice'].submit();
    }else{

    }
}

function invoiceComplete(){

    if(validateStudentinvoice()){
    selectAll(false);
    document.forms['frmStudentinvoice'].iscomplete.value = 1;
    document.forms['frmStudentinvoice'].submit();
    }else{
    
    }
}

function AddToInvoice(){

    if(validateStudentinvoice()){
    document.forms['frmStudentinvoice'].submit();
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
window.open("viewstudentinvoice.php?studentinvoice_id="+studentinvoice_id);
}

function deductTotal(line){

studentinvoice_lineamt = parseFloat(document.getElementById('studentinvoice_lineamt'+line).value);
total_amt = parseFloat(document.forms['frmStudentinvoice'].total_amt.value);

total_amt = total_amt - studentinvoice_lineamt;
document.forms['frmStudentinvoice'].total_amt.value = total_amt.toFixed(2);
}

function updateTotal(){

 var i=0;
 var tot_amt = 0;
    while(i< document.forms['frmStudentinvoice'].elements.length){
        var ctlname = document.forms['frmStudentinvoice'].elements[i].name;
        var data = parseFloat(document.forms['frmStudentinvoice'].elements[i].value);

        ctlname = ctlname.substring(0,ctlname.indexOf("["))
        if(ctlname=="studentinvoice_lineamt"){
        tot_amt += data;
        }

        i++;

    }

document.forms['frmStudentinvoice'].total_amt.value = tot_amt.toFixed(2);

}

function updateAmount(line){
studentinvoice_uprice = parseFloat(document.getElementById('studentinvoice_uprice'+line).value);
studentinvoice_qty = parseFloat(document.getElementById('studentinvoice_qty'+line).value);

total_amt = (studentinvoice_uprice*studentinvoice_qty).toFixed(2);
document.getElementById('studentinvoice_lineamt'+line).value = total_amt;

updateTotal();
}

function viewProduct(line){
    styleproduct = document.getElementById('idProductCtrl'+line).style.display;

    if(styleproduct == "none")
    document.getElementById('idProductCtrl'+line).style.display = "";
    else
    document.getElementById('idProductCtrl'+line).style.display = "none";
}

function getProductInfo(product_id,line){
    var arr_fld=new Array("action","product_id","line");//name for POST
    var arr_val=new Array("getproductinfo",product_id,line);//value for POST

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
    while(i< document.forms['frmStudentinvoice'].elements.length){
    var ctlname = document.forms['frmStudentinvoice'].elements[i].name;
    var data = document.forms['frmStudentinvoice'].elements[i].value;

    ctlname = ctlname.substring(0,ctlname.indexOf("["))
    if(ctlname=="isselectremain"){

    document.forms['frmStudentinvoice'].elements[i].checked = val;
    }

    i++;

}


}



function checkAddNote(){

    if(validateStudentinvoice()){
    selectAll(false);
    document.forms['frmStudentinvoice'].addnote_line.value = 1;
    document.forms['frmStudentinvoice'].submit();
    }else
    return false;

}

function deleteSubLine(studentinvoiceline_id,line){

 if(validateStudentinvoice()){
    deductTotal(line);
    document.forms['frmStudentinvoice'].deleteline_id.value = studentinvoiceline_id;
    document.forms['frmStudentinvoice'].submit();
}else{
    document.forms['frmStudentinvoice'].deleteline_id.value = 0;
    return false;
}


/*
var arr_fld=new Array("action","studentinvoicesubline_id","studentinvoice_id");//name for POST
var arr_val=new Array("deletelectline",studentinvoicesubline_id,studentinvoice_id);//value for POST

getRequest(arr_fld,arr_val);
*/

}

function checkAddSelect(){

document.forms['frmStudentinvoice'].addstudentinvoice_id.value = 1;
document.forms['frmStudentinvoice'].submit();
}

function autofocus(){
document.forms['frmStudentinvoice'].studentinvoice_name.focus();
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


	function validateStudentinvoice(){
		
		var name=document.forms['frmStudentinvoice'].studentinvoice_name.value;
		var studentinvoice_no=document.forms['frmStudentinvoice'].studentinvoice_no.value;
		var studentinvoice_date=document.forms['frmStudentinvoice'].studentinvoice_date.value;
		var student_id =document.forms['frmStudentinvoice'].student_id.value;
	
			
		if(confirm("Save record?")){
		if(studentinvoice_no =="" || student_id == 0){
			alert('Please make sure Student is Selected and Invoice No is Filled In.');
			return false;
		}
		else{
            if(!isDate(studentinvoice_date))
            return false
            else{

                //check all line
                var i=0;
                while(i< document.forms['frmStudentinvoice'].elements.length){
                var ctl = document.forms['frmStudentinvoice'].elements[i].name;
                var val = document.forms['frmStudentinvoice'].elements[i].value;

                ctlname = ctl.substring(0,ctl.indexOf("["))

                if(ctlname=="studentinvoice_uprice" || ctlname=="studentinvoice_qty" || ctlname=="studentinvoice_lineamt" ){
                    if(!IsNumeric(val) || val == ""){
                    document.forms['frmStudentinvoice'].elements[i].style.backgroundColor = "#FF0000";
                    alert("Please make sure amount filled with proper value.");
                    return false;
                    }

                }else
                    document.forms['frmStudentinvoice'].elements[i].style.backgroundColor = "#FFFFFF";
                i++;
                }//end of check line
                return true;
            }
            }
		}
		else
			return false;
	}
function gotoAction(action){
	document.forms['frmStudentinvoice'].action.value = action;
	document.forms['frmStudentinvoice'].submit();
	}

function updateSemester(student_id){

    var arr_fld=new Array("action","student_id");//name for POST
    var arr_val=new Array("updatesemester",student_id);//value for POST

    getRequest(arr_fld,arr_val);
}
</script>

EOF;

$o->studentinvoice_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->studentinvoice_id=$_POST["studentinvoice_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->studentinvoice_id=$_GET["studentinvoice_id"];

}
else
$action="";

$token=$_POST['token'];

$o->studentinvoice_date=$_POST["studentinvoice_date"];
$o->studentinvoice_no=$_POST["studentinvoice_no"];

if($_POST["student_id"])
$o->student_id=$_POST["student_id"];
else
$o->student_id=$_GET["student_id"];

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

$o->issearch=$_POST['issearch'];
//$o->bacth_id=$_POST['bacth_id'];

$o->student_name=$_POST['student_name'];
$o->student_no=$_POST['student_no'];
$o->course_id=$_POST['course_id'];

if ($iscomplete=="1" || $iscomplete=="on")
	$o->iscomplete=1;
else if ($iscomplete=="null")
	$o->iscomplete="null";
else
	$o->iscomplete=0;

//alert line
$o->studentinvoiceline_idremain=$_POST['studentinvoiceline_idremain'];
$o->isselectremain=$_POST['isselectremain'];
//end

$o->addstudentinvoice_id=$_POST['addstudentinvoice_id']; // for add line purpose
$o->deleteline_id=$_POST['deleteline_id']; // for delete sub line purpose
$o->addnote_line=$_POST['addnote_line']; // for add line purpose
$o->deletenoteline_id=$_POST['deletenoteline_id']; // for delete note line purpose
$o->isdeleteline=$_POST['isdeleteline']; // for delete note line purpose (by selected)

//sub list
$o->studentinvoiceline_id=$_POST['studentinvoiceline_id'];
$o->studentinvoiceline_no=$_POST['studentinvoiceline_no'];
$o->studentinvoice_item=$_POST['studentinvoice_item'];
$o->product_id=$_POST['product_id'];
$o->accounts_id=$_POST['accounts_id'];
$o->line_desc=$_POST['line_desc'];
$o->studentinvoice_uprice=$_POST['studentinvoice_uprice'];
$o->studentinvoice_qty=$_POST['studentinvoice_qty'];
$o->studentinvoice_lineamt=$_POST['studentinvoice_lineamt'];

$o->invoicedatectrl=$dp->show("studentinvoice_date");

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with studentinvoice name=$o->studentinvoice_name");

	if ($s->check(false,$token,"CREATE_ACG")){
		
		
		
	if($o->insertStudentinvoice()){
		 $latest_id=$o->getLatestStudentinvoiceID();
         $log->saveLog($latest_id,$tablestudentinvoice,"$o->changesql","I","O");
			 redirect_header("studentinvoice.php?action=edit&studentinvoice_id=$latest_id",$pausetime,"Your data is saved.");
		}
	else {
        $log->saveLog(0,$tablestudentinvoice,"$o->changesql","I","F");
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
        $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"onchange='updateSemester(this.value)'","student_id","","student_id","$o->stylewidthstudent","Y",0);
        $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        //$o->studentinvoicetypectrl=$ctrl->getSelectStudentinvoicetype($o->studentinvoicetype_id,"Y");
		$o->getInputForm("new",-1,$token);
		//$o->showStudentinvoiceTable("WHERE si.studentinvoice_id>0 and si.organization_id=$defaultorganization_id","ORDER BY st.course_id,si.semester_id,st.student_no");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
        $log->saveLog(0,$tablestudentinvoice,"$o->changesql","I","F");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
        $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
        $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        //$o->studentinvoicetypectrl=$ctrl->getSelectStudentinvoicetype($o->studentinvoicetype_id,"Y");
		$o->getInputForm("new",-1,$token);
		//$o->showStudentinvoiceTable("WHERE si.studentinvoice_id>0 and si.organization_id=$defaultorganization_id","ORDER BY st.course_id,si.semester_id,st.student_no");
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchStudentinvoice($o->studentinvoice_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        //$o->studentinvoicetypectrl=$ctrl->getSelectStudentinvoicetype($o->studentinvoicetype_id,"Y");
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"N");
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
        $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
		$o->getInputForm("edit",$o->studentinvoice,$token);
		//$o->showStudentinvoiceTable("WHERE si.studentinvoice_id>0 and si.organization_id=$defaultorganization_id","ORDER BY si.defaultlevel,si.studentinvoice_no");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("studentinvoice.php",3,"Some error on viewing your studentinvoice data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateStudentinvoice()){ //if data save successfully
            $log->saveLog($o->studentinvoice_id,$tablestudentinvoice,"$o->changesql","U","O");

            // sub list
            if($o->updateSubLine()){// update existing line
                $log->saveLog($o->studentinvoice_id,$tablestudentinvoice,"$o->changesql","U","O");
            }else{
                $log->saveLog($o->studentinvoice_id,$tablestudentinvoice,"$o->changesql","U","F");
            }
            
            if($o->addstudentinvoice_id > 0){// if add sub if selected
                
                if($o->addSubLine($o->studentinvoice_id,$o->addstudentinvoice_id)){
                $log->saveLog($o->studentinvoice_id,$tablestudentinvoice,"$o->changesql","I","O");
                }else{
                $log->saveLog($o->studentinvoice_id,$tablestudentinvoice,"$o->changesql","I","F");
                }
                
            }

            if($o->deleteline_id >0){ //delete sub

                if($o->deleteSubLine($o->deleteline_id)){
                $log->saveLog($o->studentinvoice_id,$tablestudentinvoice,"$o->changesql","D","O");
                }else{
                $log->saveLog($o->studentinvoice_id,$tablestudentinvoice,"$o->changesql","D","F");
                }
            }
            //end of sub list

            if(count($o->studentinvoiceline_idremain) > 0){//alert line
                if($o->updateAlertLine()){
                    $o->updateTotalAmount($o->studentinvoice_id);

                $log->saveLog($o->studentinvoice_id,$tablestudentinvoice,"$o->changesql","U","O");
                }else{
                $log->saveLog($o->studentinvoice_id,$tablestudentinvoice,"$o->changesql","U","O");
                }
            }

            if($o->iscomplete == 1){
            //$o->deleteUnuseLine($o->salesinvoice_id);

            //start posting to simbiz
            $listAPI = $o->batchAPIInvoice($o->studentinvoice_id);
            $uid = $xoopsUser->getVar('uid');
            //echo $listAPI[15];
            $return_true = false;
            if($listAPI[15] == 0){//if all accounts > 0
            $return_true =
            $api->PostBatch($uid,$listAPI[0],$listAPI[1],$listAPI[2],$listAPI[3],$listAPI[4],$listAPI[5],
            $listAPI[6],$listAPI[7],$listAPI[8],$listAPI[9],$listAPI[10],$listAPI[11],$listAPI[12],$listAPI[13],
            $listAPI[14]);
            }
		
            if($return_true){
            $o->updateBatchInfoInvoice("batch_id",$api->resultbatch_id,$o->studentinvoice_id);
            $o->updateBatchInfoInvoice("batch_no",$api->resultbatch_no,$o->studentinvoice_id);
			redirect_header("studentinvoice.php?action=edit&studentinvoice_id=$o->studentinvoice_id",$pausetime,"Your data is saved and posted to accounting");
            }else{
            $o->updateComplete(0,$o->studentinvoice_id);
			redirect_header("studentinvoice.php?action=edit&studentinvoice_id=$o->studentinvoice_id",$pausetime,"<b style='color:red'>Your data is saved, but cannot post into accounting. Please verified your financial period is open.</b>");
            }
            //end of posting to simbiz

            }
          
			redirect_header("studentinvoice.php?action=edit&studentinvoice_id=$o->studentinvoice_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->studentinvoice_id,$tablestudentinvoice,"$o->changesql","U","F");
			redirect_header("studentinvoice.php?action=edit&studentinvoice_id=$o->studentinvoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog($o->studentinvoice_id,$tablestudentinvoice,"$o->changesql","U","F");
		redirect_header("studentinvoice.php?action=edit&studentinvoice_id=$o->studentinvoice_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteStudentinvoice($o->studentinvoice_id)){
            $log->saveLog($o->studentinvoice_id,$tablestudentinvoice,"$o->changesql","D","O");
			redirect_header("studentinvoice.php",$pausetime,"Data removed successfully.");
        }else{
            $log->saveLog($o->studentinvoice_id,$tablestudentinvoice,"$o->changesql","D","F");
			redirect_header("studentinvoice.php?action=edit&studentinvoice_id=$o->studentinvoice_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else
		redirect_header("studentinvoice.php?action=edit&studentinvoice_id=$o->studentinvoice_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

    case "search" :

	$wherestr =" WHERE si.studentinvoice_id>0 and si.organization_id=$defaultorganization_id ";

    $limitstr = "";
	if($o->issearch == "Y"){
	$wherestr .= $o->getWhereStr();
    }else{
    $limitstr = " limit 50 ";
	$o->studentinvoicetype_id = 0;
    $o->course_id = 0;
    $o->semester_id = 0;
    $o->student_id = 0;
    $o->year_id = 0;
    $o->session_id = 0;


	}
//($id,$showNull='N',$onchangefunction="",$ctrlname="year_id",$wherestr='',$defaultyear=0,$isusedefaultsession=true)
    //$o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y","","year_id","",0,false);
    //$o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y","","session_id","",0,false);
    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
	$o->showSearchForm();
	if($o->issearch == "Y")
    $o->showStudentinvoiceTable($wherestr,"ORDER BY CAST(si.studentinvoice_no AS SIGNED)",$limitstr);
	//$o->showStudentinvoiceTable($wherestr,"ORDER BY st.course_id,si.semester_id,st.student_no",$limitstr);
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
      

  case "getproductinfo" :

    $line = $_POST['line'];
    $product_id = $_POST['product_id'];

    $product_info = $o->getProductInfo($product_id);

    $product_name = $product_info["product_name"];
    $sellaccount_id = $product_info["sellaccount_id"];
    $invoice_amt = $product_info["invoice_amt"];

echo <<< EOF
    <script type='text/javascript'>
    self.parent.document.getElementById("studentinvoice_item$line").value = "$product_name";
    self.parent.document.getElementById("studentinvoice_uprice$line").value = "$invoice_amt";
    self.parent.document.getElementById("accounts_id$line").value = "$sellaccount_id";
    self.parent.updateAmount($line);
    </script>
EOF;

  break;

  case "reactivate":

	if($o->reactivateStudentInvoice($o->studentinvoice_id)){ //if data save successfully

	// simbiz AccountsAPI function here
	$api->reverseBatch($o->batch_id);
	if($o->batch_id > 0){
	$o->updateBatchInfoInvoice("batch_id",0,$o->studentinvoice_id);
	$o->updateBatchInfoInvoice("batch_no","",$o->studentinvoice_id);
	}
	// end of simbiz AccountsAPI function

	redirect_header("studentinvoice.php?action=edit&studentinvoice_id=$o->studentinvoice_id",$pausetime,"This record is reactivate successfully, redirect to edit this record.");
	}else{
		redirect_header("studentinvoice.php?action=edit&studentinvoice_id=$o->studentinvoice_id",$pausetime,"<b style='color:red'>Warning! Can't reactivate the data.</b>");
	}
break;

case "updatesemester";
            /*$total_day = 0;

            if($o->leave_type == "A"){
            $total_day = $o->getAnnualLeave($o->leave_type,$o->employee_id);
            $annualLeft = "<b>$total_day Day(s) Remaining.</b>";
            }else if($o->leave_type == "S"){
            $total_day = $o->getSickLeave($o->leave_type,$o->employee_id);
            $annualLeft = "<b>$total_day Day(s) Remaining.</b>";
            }else{
            $annualLeft = "";
            }*/
include_once '../hes/class/Student.php';

$hes = new Student();


$semester_id = $hes->getStudentSemester($o->student_id);
//$semester_id = 1;
echo <<< EOF
	<script type='text/javascript'>

        //self.parent.document.getElementById("semester_id").value = "$semester_id";
            self.parent.document.forms['frmStudentinvoice'].semester_id.value = "$semester_id";
    

	</script>
EOF;

  break;
  
  default :
    if($o->studentinvoicetype_id=="")
    $o->studentinvoicetype_id=0;
    if($o->semester_id=="")
    $o->semester_id=0;
    if($o->year_id=="")
    $o->year_id=0;
    if($o->session_id=="")
    $o->session_id=0;
    if($o->student_id=="")
    $o->student_id=0;
    
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
    //$o->studentinvoicetypectrl=$ctrl->getSelectStudentinvoicetype($o->studentinvoicetype_id,"Y");
    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"onchange='updateSemester(this.value)'","student_id","","student_id","$o->stylewidthstudent","Y",0);
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
    //$o->studentinvoicectrl=$ctrl->getSelectStudentinvoice($o->studentinvoicectrl,"Y");
	$o->getInputForm("new",0,$token);
	//$o->showStudentinvoiceTable("WHERE si.studentinvoice_id>0 and si.organization_id=$defaultorganization_id","ORDER BY st.course_id,si.semester_id,st.student_no", " limit 50 ");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

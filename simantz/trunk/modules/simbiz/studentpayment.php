<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once 'class/Studentpayment.php';
//include_once 'class/SelectCtrl.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
include_once "../simbiz/class/AccountsAPI.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';


//$log = new Log();
$o = new Studentpayment();
$s = new XoopsSecurity();
$api = new AccountsAPI();

$orgctrl="";

$o->stylewidthstudent = "style='width:200px'";

$action="";

//marhan add here --> ajax
echo "<iframe src='studentpayment.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">
function payAll(){

        var i = 0;
        var j = 0;
        while(i< document.forms['frmStudentpayment'].elements.length){
        var ctlname = document.forms['frmStudentpayment'].elements[i].name;
        var data = parseFloat(document.forms['frmStudentpayment'].elements[i].value);
        line = parseFloat(i + 1);

        ctlname = ctlname.substring(0,ctlname.indexOf("["))
        if(ctlname=="balance_amtarr"){
        j++;
        document.getElementById('studentpayment_lineamt'+j).value = data.toFixed(2);
        }

        i++;

    }

    updateTotal();
}

function paymentEnable(){

    if(validateStudentpayment()){
    selectAll(false);
    document.forms['frmStudentpayment'].action.value = "reactivate";
    document.forms['frmStudentpayment'].submit();
    }else{

    }
}

function paymentComplete(){

    if(validateStudentpayment()){
    selectAll(false);
    document.forms['frmStudentpayment'].iscomplete.value = 1;
    document.forms['frmStudentpayment'].submit();
    }else{

    }
}

function changeMethod(studentpayment_type){

    if(studentpayment_type == "C"){//if cash
    document.forms['frmStudentpayment'].studentpayment_chequeno.style.display = "none";
    }else{
    document.forms['frmStudentpayment'].studentpayment_chequeno.style.display = "";
    }

    var arr_fld=new Array("action","studentpayment_type");//name for POST
    var arr_val=new Array("changemethod",studentpayment_type);//value for POST

    getRequest(arr_fld,arr_val);
}

function AddToPayment(){

    if(validateStudentpayment()){
    document.forms['frmStudentpayment'].submit();
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

function viewStudentInvoice(studentpayment_id){
window.open("viewstudentpayment.php?studentpayment_id="+studentpayment_id);
}

function deductTotal(line){

studentpayment_lineamt = parseFloat(document.getElementById('studentpayment_lineamt'+line).value);
total_amt = parseFloat(document.forms['frmStudentpayment'].total_amt.value);

total_amt = total_amt - studentpayment_lineamt;
document.forms['frmStudentpayment'].total_amt.value = total_amt.toFixed(2);
}

function updateTotal(){

 var i=0;
 var tot_amt = 0;
    while(i< document.forms['frmStudentpayment'].elements.length){
        var ctlname = document.forms['frmStudentpayment'].elements[i].name;
        var data = parseFloat(document.forms['frmStudentpayment'].elements[i].value);

        ctlname = ctlname.substring(0,ctlname.indexOf("["))
        if(ctlname=="studentpayment_lineamt"){
        tot_amt += data;
        }

        i++;

    }

document.forms['frmStudentpayment'].total_amt.value = tot_amt.toFixed(2);

}

function updateAmount(line){
studentpayment_uprice = parseFloat(document.getElementById('studentpayment_uprice'+line).value);
studentpayment_qty = parseFloat(document.getElementById('studentpayment_qty'+line).value);

total_amt = (studentpayment_uprice*studentpayment_qty).toFixed(2);
document.getElementById('studentpayment_lineamt'+line).value = total_amt;

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
    while(i< document.forms['frmStudentpayment'].elements.length){
    var ctlname = document.forms['frmStudentpayment'].elements[i].name;
    var data = document.forms['frmStudentpayment'].elements[i].value;

    ctlname = ctlname.substring(0,ctlname.indexOf("["))
    if(ctlname=="isselectremain"){

    document.forms['frmStudentpayment'].elements[i].checked = val;
    }

    i++;

}


}



function checkAddNote(){

    if(validateStudentpayment()){
    selectAll(false);
    document.forms['frmStudentpayment'].addnote_line.value = 1;
    document.forms['frmStudentpayment'].submit();
    }else
    return false;

}

function deleteSubLine(studentpaymentline_id,line){

 if(validateStudentpayment()){
    deductTotal(line);
    document.forms['frmStudentpayment'].deleteline_id.value = studentpaymentline_id;
    document.forms['frmStudentpayment'].submit();
}else{
    document.forms['frmStudentpayment'].deleteline_id.value = 0;
    return false;
}


/*
var arr_fld=new Array("action","studentpaymentsubline_id","studentpayment_id");//name for POST
var arr_val=new Array("deletelectline",studentpaymentsubline_id,studentpayment_id);//value for POST

getRequest(arr_fld,arr_val);
*/

}

function checkAddSelect(){

document.forms['frmStudentpayment'].addstudentpayment_id.value = 1;
document.forms['frmStudentpayment'].submit();
}

function autofocus(){
document.forms['frmStudentpayment'].studentpayment_name.focus();
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


	function validateStudentpayment(){
		
		var studentpayment_no=document.forms['frmStudentpayment'].studentpayment_no.value;
		var studentpayment_date=document.forms['frmStudentpayment'].studentpayment_date.value;
		var student_id =document.forms['frmStudentpayment'].student_id.value;
	
			
		if(confirm("Save record?")){
		if(studentpayment_no =="" || student_id == 0){
			alert('Please make sure Student is Selected and Payment No is Filled In.');
			return false;
		}
		else{
            if(!isDate(studentpayment_date))
            return false
            else{

                
                //check all line
                var i=0;
                while(i< document.forms['frmStudentpayment'].elements.length){
                var ctl = document.forms['frmStudentpayment'].elements[i].name;
                var val = document.forms['frmStudentpayment'].elements[i].value;

                ctlname = ctl.substring(0,ctl.indexOf("["))

                if(ctlname=="studentpayment_uprice" || ctlname=="studentpayment_qty" || ctlname=="studentpayment_lineamt" ){
                    if(!IsNumeric(val) || val == ""){
                    document.forms['frmStudentpayment'].elements[i].style.backgroundColor = "#FF0000";
                    alert("Please make sure amount filled with proper value.");
                    return false;
                    }

                }else
                    document.forms['frmStudentpayment'].elements[i].style.backgroundColor = "#FFFFFF";
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
	document.forms['frmStudentpayment'].action.value = action;
	document.forms['frmStudentpayment'].submit();
	}

</script>

EOF;

$o->studentpayment_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->studentpayment_id=$_POST["studentpayment_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->studentpayment_id=$_GET["studentpayment_id"];

}
else
$action="";

$token=$_POST['token'];

$o->studentpayment_date=$_POST["studentpayment_date"];
$o->studentpayment_no=$_POST["studentpayment_no"];

if($_POST["student_id"])
$o->student_id=$_POST["student_id"];
else
$o->student_id=$_GET["student_id"];

$o->studentpayment_category=$_POST["studentpayment_category"];
$o->studentpayment_type=$_POST["studentpayment_type"];
$o->studentpayment_chequeno=$_POST["studentpayment_chequeno"];
$o->to_accounts=$_POST["to_accounts"];
$o->from_accounts=$_POST["from_accounts"];

$o->total_amt=$_POST["total_amt"];
$o->batch_id=$_POST["batch_id"];
$o->batch_no=$_POST["batch_no"];



$iscomplete=$_POST['iscomplete'];
$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

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

$o->start_date=$_POST['start_date'];
$o->end_date=$_POST['end_date'];
$o->startctrl=$dp->show("start_date");
$o->endctrl=$dp->show("end_date");

//alert line
$o->studentinvoice_itemremain=$_POST['studentinvoice_itemremain'];
$o->studentinvoiceline_idremain=$_POST['studentinvoiceline_idremain'];
$o->isselectremain=$_POST['isselectremain'];
//end

$o->addstudentpayment_id=$_POST['addstudentpayment_id']; // for add line purpose
$o->deleteline_id=$_POST['deleteline_id']; // for add line purpose

//sub list
$o->studentpaymentline_id=$_POST['studentpaymentline_id'];
$o->studentpayment_item=$_POST['studentpayment_item'];
$o->line_desc=$_POST['line_desc'];
$o->studentpayment_lineamt=$_POST['studentpayment_lineamt'];

$o->invoicedatectrl=$dp->show("studentpayment_date");

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with studentpayment name=$o->studentpayment_name");

	if ($s->check(false,$token,"CREATE_ACG")){
		
		
		
	if($o->insertStudentpayment()){
		 $latest_id=$o->getLatestStudentpaymentID();
         $log->saveLog($latest_id,$tablestudentpayment,"$o->changesql","I","O");
			 redirect_header("studentpayment.php?action=edit&studentpayment_id=$latest_id",$pausetime,"Your data is saved.");
		}
	else {
        $log->saveLog(0,$tablestudentpayment,"$o->changesql","I","F");
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
        $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
        $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        $o->toaccountsctrl=$ctrl->getSelectAccounts($o->to_accounts,"N","","to_accounts"," and account_type in (4,7) ","N","N","N","to_accounts","$o->stylewidthstudent");
        $o->fromaccountsctrl=$ctrl->getSelectAccounts($o->from_accounts,"N","","from_accounts"," and account_type in (4,7) ","N","N","N","from_accounts","$o->stylewidthstudent");
        //$o->studentpaymenttypectrl=$ctrl->getSelectStudentpaymenttype($o->studentpaymenttype_id,"Y");
		$o->getInputForm("new",-1,$token);
		//$o->showStudentpaymentTable("WHERE si.studentpayment_id>0 and si.organization_id=$defaultorganization_id","ORDER BY st.course_id,si.semester_id,st.student_no");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
        $log->saveLog(0,$tablestudentpayment,"$o->changesql","I","F");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
        $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
        $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        $o->toaccountsctrl=$ctrl->getSelectAccounts($o->to_accounts,"N","","to_accounts"," and account_type in (4,7) ","N","N","N","to_accounts","$o->stylewidthstudent");
        $o->fromaccountsctrl=$ctrl->getSelectAccounts($o->from_accounts,"N","","from_accounts"," and account_type in (4,7) ","N","N","N","from_accounts","$o->stylewidthstudent");
        //$o->studentpaymenttypectrl=$ctrl->getSelectStudentpaymenttype($o->studentpaymenttype_id,"Y");
		$o->getInputForm("new",-1,$token);
		//$o->showStudentpaymentTable("WHERE si.studentpayment_id>0 and si.organization_id=$defaultorganization_id","ORDER BY st.course_id,si.semester_id,st.student_no");
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchStudentpayment($o->studentpayment_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        //$o->studentpaymenttypectrl=$ctrl->getSelectStudentpaymenttype($o->studentpaymenttype_id,"Y");
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"N");
        $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
        $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
        $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
        $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        $o->toaccountsctrl=$ctrl->getSelectAccounts($o->to_accounts,"N","","to_accounts"," and account_type in (4,7) ","N","N","N","to_accounts","$o->stylewidthstudent");
        $o->fromaccountsctrl=$ctrl->getSelectAccounts($o->from_accounts,"N","","from_accounts"," and account_type in (4,7) ","N","N","N","from_accounts","$o->stylewidthstudent");
		$o->getInputForm("edit",$o->studentpayment,$token);
		//$o->showStudentpaymentTable("WHERE si.studentpayment_id>0 and si.organization_id=$defaultorganization_id","ORDER BY si.defaultlevel,si.studentpayment_no");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("studentpayment.php",3,"Some error on viewing your studentpayment data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateStudentpayment()){ //if data save successfully
            $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","U","O");

            // sub list
            if($o->updateSubLine()){// update existing line
                $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","U","O");
            }else{
                $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","U","F");
            }
            
            if($o->addstudentpayment_id > 0){// if add sub if selected
                
                if($o->addSubLine($o->studentpayment_id,$o->addstudentpayment_id)){
                $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","I","O");
                }else{
                $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","I","F");
                }
                
            }

            if($o->deleteline_id >0){ //delete sub

                if($o->deleteSubLine($o->deleteline_id)){
                $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","D","O");
                }else{
                $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","D","F");
                }
            }
            //end of sub list

            if(count($o->studentinvoiceline_idremain) > 0){//alert line
                if($o->updateAlertLine()){
                    $o->updateTotalAmount($o->studentpayment_id);

                $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","U","O");
                }else{
                $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","U","O");
                }
            }

            if($o->iscomplete == 1){
            //$o->deleteUnuseLine($o->salespayment_id);

            //start posting to simbiz
            $listAPI = $o->batchAPIPayment($o->studentpayment_id);
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
            $o->updateBatchInfoPayment("batch_id",$api->resultbatch_id,$o->studentpayment_id);
            $o->updateBatchInfoPayment("batch_no",$api->resultbatch_no,$o->studentpayment_id);
            }else{
            $o->updateComplete(0,$o->studentpayment_id);
            }
            //end of posting to simbiz

            }
                 
          
			redirect_header("studentpayment.php?action=edit&studentpayment_id=$o->studentpayment_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","U","F");
			redirect_header("studentpayment.php?action=edit&studentpayment_id=$o->studentpayment_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","U","F");
		redirect_header("studentpayment.php?action=edit&studentpayment_id=$o->studentpayment_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteStudentpayment($o->studentpayment_id)){
            $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","D","O");
			redirect_header("studentpayment.php",$pausetime,"Data removed successfully.");
        }else{
            $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","D","F");
			redirect_header("studentpayment.php?action=edit&studentpayment_id=$o->studentpayment_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else
		redirect_header("studentpayment.php?action=edit&studentpayment_id=$o->studentpayment_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

    case "search" :

	$wherestr =" WHERE si.studentpayment_id>0 and si.organization_id=$defaultorganization_id ";

    $limitstr = "";
	if($o->issearch == "Y"){
	$wherestr .= $o->getWhereStr();
    }else{
    $limitstr = " limit 50 ";
	$o->studentpaymenttype_id = 0;
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
    $o->showStudentpaymentTable($wherestr,"ORDER BY CAST(si.studentpayment_no AS SIGNED)",$limitstr);
	//$o->showStudentpaymentTable($wherestr,"ORDER BY st.course_id,si.semester_id,st.student_no",$limitstr);
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

//if($o->updateStudentpayment()){ //if data save successfully
            //$log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","U","O");

      if($o->deleteLectLine($o->studentpaymentsubline_id)){
       $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","D","O");
      }else{
       $log->saveLog($o->studentpayment_id,$tablestudentpayment,"$o->changesql","D","F");
      }

echo <<< EOF
	<script type='text/javascript'>
    self.parent.location = "studentpayment.php?action=edit&studentpayment_id=$o->studentpayment_id";
	</script>
EOF;
 
  break;*/

  case "getproductinfo" :

    $line = $_POST['line'];
    $product_id = $_POST['product_id'];

    $product_info = $o->getProductInfo($product_id);

    $product_name = $product_info["product_name"];
    $sellaccount_id = $product_info["sellaccount_id"];
    $invoice_amt = $product_info["invoice_amt"];

echo <<< EOF
    <script type='text/javascript'>
    self.parent.document.getElementById("studentpayment_item$line").value = "$product_name";
    self.parent.document.getElementById("studentpayment_uprice$line").value = "$invoice_amt";
    self.parent.document.getElementById("accounts_id$line").value = "$sellaccount_id";
    self.parent.updateAmount($line);
    </script>
EOF;

  break;

  case "changemethod" :
      $studentpayment_type = $_POST['studentpayment_type'];

      if($studentpayment_type=="C")
      $default_acc = $cash_account;
      else
      $default_acc = $cheque_account;
echo <<< EOF
    <script type='text/javascript'>

    self.parent.document.forms["frmStudentpayment"].to_accounts.value = "$default_acc";

    </script>
EOF;
  break;

    case "reactivate":

	if($o->reactivateStudentPayment($o->studentpayment_id)){ //if data save successfully

	// simbiz AccountsAPI function here
	$api->reverseBatch($o->batch_id);
	if($o->batch_id > 0){
	$o->updateBatchInfoPayment("batch_id",0,$o->studentpayment_id);
	$o->updateBatchInfoPayment("batch_no","",$o->studentpayment_id);
	}
	// end of simbiz AccountsAPI function

	redirect_header("studentpayment.php?action=edit&studentpayment_id=$o->studentpayment_id",$pausetime,"This record is reactivate successfully, redirect to edit this record.");
	}else{
		redirect_header("studentpayment.php?action=edit&studentpayment_id=$o->studentpayment_id",$pausetime,"<b style='color:red'>Warning! Can't reactivate the data.</b>");
	}
break;
  
  default :


    if($o->year_id=="")
    $o->year_id=0;
    if($o->session_id=="")
    $o->session_id=0;
    if($o->student_id=="")
    $o->student_id=0;

    if($o->to_accounts=="")
    $o->to_accounts=$cash_account;

    if($o->from_accounts=="")
    $o->from_accounts=$student_account;
    
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
    //$o->studentpaymenttypectrl=$ctrl->getSelectStudentpaymenttype($o->studentpaymenttype_id,"Y");
    $o->yearctrl=$ctrl->getSelectYear($o->year_id,"Y");
    $o->sessionctrl=$ctrl->getSelectSession($o->session_id,"Y");
    $o->studentctrl=$ctrl->getSelectStudent($o->student_id,'Y',"","student_id","","student_id","$o->stylewidthstudent","Y",0);
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
    $o->toaccountsctrl=$ctrl->getSelectAccounts($o->to_accounts,"N","","to_accounts"," and account_type in (4,7) ","N","N","N","to_accounts","$o->stylewidthstudent");
    $o->fromaccountsctrl=$ctrl->getSelectAccounts($o->from_accounts,"N","","from_accounts"," and account_type in (4,7) ","N","N","N","from_accounts","$o->stylewidthstudent");
	$o->getInputForm("new",0,$token);
	//$o->showStudentpaymentTable("WHERE si.studentpayment_id>0 and si.organization_id=$defaultorganization_id","ORDER BY st.course_id,si.semester_id,st.student_no", " limit 50 ");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

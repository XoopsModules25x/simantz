<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once 'class/Otapproval.php';
//include_once 'class/SelectCtrl.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
include_once "../simbiz/class/AccountsAPI.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';


//$log = new Log();
$o = new Otapproval();
$s = new XoopsSecurity();
$api = new AccountsAPI();

$orgctrl="";

$o->stylewidthstudent = "style='width:200px'";

$action="";

//marhan add here --> ajax
echo "<iframe src='otapproval.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">

function viewOvertime(overtime_id){

window.open("viewovertime.php?overtime_id="+overtime_id);
}

function overtimeUpdate(fldname,val){
    document.forms['frmOtapproval'].fldnamebtn.value = fldname;
    document.forms['frmOtapproval'].fldnamebtn_id.value = val;
    document.forms['frmOtapproval'].action.value = "overtimeupdate";

    if(val == 0)
    var txt_alert = "Please Save Data. Continue?";
    else
    var txt_alert = "Re-Activate This Data?";

    if(confirm(txt_alert)){
    document.forms['frmOtapproval'].submit();
    }else{
    return false;
    }
}

function updateRate(overtimeline_type,line,employee_id){
    var arr_fld=new Array("action","overtimeline_type","line","employee_id");//name for POST
    var arr_val=new Array("updaterate",overtimeline_type,line,employee_id);//value for POST

    getRequest(arr_fld,arr_val);
}

function payAll(){

        var i = 0;
        var j = 0;
        while(i< document.forms['frmOtapproval'].elements.length){
        var ctlname = document.forms['frmOtapproval'].elements[i].name;
        var data = parseFloat(document.forms['frmOtapproval'].elements[i].value);
        line = parseFloat(i + 1);

        ctlname = ctlname.substring(0,ctlname.indexOf("["))
        if(ctlname=="balance_amtarr"){
        j++;
        document.getElementById('otapproval_lineamt'+j).value = data.toFixed(2);
        }

        i++;

    }

    updateTotal();
}

function overtimeEnable(){

    if(validateOtapproval()){
    selectAll(false);
    document.forms['frmOtapproval'].action.value = "reactivate";
    document.forms['frmOtapproval'].submit();
    }else{

    }
}

function overtimeComplete(){

    if(validateOtapproval()){
    selectAll(false);
    document.forms['frmOtapproval'].iscomplete.value = 1;
    document.forms['frmOtapproval'].submit();
    }else{

    }
}

function changeMethod(payment_type){

    if(payment_type == "C"){//if cash
    document.forms['frmOtapproval'].payment_chequeno.style.display = "none";
    }else{
    document.forms['frmOtapproval'].payment_chequeno.style.display = "";
    }

    var arr_fld=new Array("action","payment_type");//name for POST
    var arr_val=new Array("changemethod",payment_type);//value for POST

    getRequest(arr_fld,arr_val);
}

function AddToPayment(){

    if(validateOtapproval()){
    document.forms['frmOtapproval'].submit();
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

function viewStudentInvoice(overtime_id){
window.open("viewotapproval.php?overtime_id="+overtime_id);
}

function deductTotal(line){

overtimeline_totalamt = parseFloat(document.getElementById('overtimeline_totalamt'+line).value);
total_amt = parseFloat(document.forms['frmOtapproval'].total_amt.value);

total_amt = total_amt - overtimeline_totalamt;
document.forms['frmOtapproval'].total_amt.value = total_amt.toFixed(2);
}

function updateTotal(){

 var i=0;
 var tot_amt = 0;
    while(i< document.forms['frmOtapproval'].elements.length){
        var ctlname = document.forms['frmOtapproval'].elements[i].name;
        var data = parseFloat(document.forms['frmOtapproval'].elements[i].value);

        ctlname = ctlname.substring(0,ctlname.indexOf("["))
        if(ctlname=="overtimeline_totalamt"){
        tot_amt += data;
        }

        i++;

    }

document.forms['frmOtapproval'].total_amt.value = tot_amt.toFixed(2);

}

function updateAmount(line){
overtimeline_totalhour = parseFloat(document.getElementById('overtimeline_totalhour'+line).value);
overtimeline_rate = parseFloat(document.getElementById('overtimeline_rate'+line).value);

total_amt = (overtimeline_totalhour*overtimeline_rate).toFixed(2);
document.getElementById('overtimeline_totalamt'+line).value = total_amt;

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
    while(i< document.forms['frmOtapproval'].elements.length){
    var ctlname = document.forms['frmOtapproval'].elements[i].name;
    var data = document.forms['frmOtapproval'].elements[i].value;

    ctlname = ctlname.substring(0,ctlname.indexOf("["))
    if(ctlname=="isselectremain"){

    document.forms['frmOtapproval'].elements[i].checked = val;
    }

    i++;

}


}



function checkAddNote(){

    if(validateOtapproval()){
    selectAll(false);
    document.forms['frmOtapproval'].addnote_line.value = 1;
    document.forms['frmOtapproval'].submit();
    }else
    return false;

}

function deleteSubLine(otapprovalline_id,line){

 if(validateOtapproval()){
    deductTotal(line);
    document.forms['frmOtapproval'].deleteline_id.value = otapprovalline_id;
    document.forms['frmOtapproval'].submit();
}else{
    document.forms['frmOtapproval'].deleteline_id.value = 0;
    return false;
}


/*
var arr_fld=new Array("action","otapprovalsubline_id","overtime_id");//name for POST
var arr_val=new Array("deletelectline",otapprovalsubline_id,overtime_id);//value for POST

getRequest(arr_fld,arr_val);
*/

}

function checkAddSelect(){
    if(validateOtapproval()){
    document.forms['frmOtapproval'].addovertime_id.value = 1;
    document.forms['frmOtapproval'].submit();
    }else
    return false;
}

function autofocus(){
document.forms['frmOtapproval'].otapproval_name.focus();
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


	function validateOtapproval(){
		
		//var overtime_no=document.forms['frmOtapproval'].overtime_no.value;
		var overtime_date=document.forms['frmOtapproval'].overtime_date.value;
		var employee_id =document.forms['frmOtapproval'].employee_id.value;
		var period_id =document.forms['frmOtapproval'].period_id.value;
			
		if(confirm("Save record?")){
		if(employee_id == 0 || period_id == 0){
			alert('Please make sure Employee & Period is Selected.');
			return false;
		}
		else{
            if(!isDate(overtime_date))
            return false
            else{

                
                //check all line
                var i=0;
                while(i< document.forms['frmOtapproval'].elements.length){
                var ctl = document.forms['frmOtapproval'].elements[i].name;
                var val = document.forms['frmOtapproval'].elements[i].value;

                ctlname = ctl.substring(0,ctl.indexOf("["))

                if(ctlname=="overtimeline_starttime" || ctlname=="overtimeline_endtime" || ctlname=="overtimeline_basicsalary" || ctlname=="overtimeline_totalhour"  || ctlname=="overtimeline_rate"  || ctlname=="overtimeline_totalamt"  ){
                    if(!IsNumeric(val) || val == ""){
                    document.forms['frmOtapproval'].elements[i].style.backgroundColor = "#FF0000";
                    alert("Please make sure amount filled with proper value.");
                    return false;
                    }

                }else
                    document.forms['frmOtapproval'].elements[i].style.backgroundColor = "#FFFFFF";

                if(ctlname=="overtimeline_date"){
                    if(!isDate(val)){
                    document.forms['frmOtapproval'].elements[i].style.backgroundColor = "#FF0000";
                    return false;
                    }
                }else
                    document.forms['frmOtapproval'].elements[i].style.backgroundColor = "#FFFFFF";

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
	document.forms['frmOtapproval'].action.value = action;
	document.forms['frmOtapproval'].submit();
	}

</script>

EOF;

$o->overtime_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->overtime_id=$_POST["overtime_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->overtime_id=$_GET["overtime_id"];

}
else
$action="";

$token=$_POST['token'];

$o->overtime_date=$_POST["overtime_date"];
$o->overtime_no=$_POST["overtime_no"];
$o->employee_id=$_POST["employee_id"];
$o->verified_by=$_POST["verified_by"];


$o->period_id=$_POST["period_id"];
$o->payment_type=$_POST["payment_type"];
$o->payment_chequeno=$_POST["payment_chequeno"];

$o->verified_by=$_POST["verified_by"];
$o->verified_date=$_POST["verified_date"];
$o->accounts_id=$_POST["accounts_id"];
$o->from_accounts=$_POST["from_accounts"];

$o->total_amt=$_POST["total_amt"];
$o->batch_id=$_POST["batch_id"];
$o->batch_no=$_POST["batch_no"];



if(isset($_POST['iscomplete']))
$iscomplete=$_POST['iscomplete'];
else
$iscomplete=$_GET['iscomplete'];

$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

if(isset($_POST['issearch']))
$o->issearch=$_POST['issearch'];
else
$o->issearch=$_GET['issearch'];

$o->employee_name=$_POST['employee_name'];
$o->employee_no=$_POST['employee_no'];
$o->course_id=$_POST['course_id'];

$o->styledisplaycomplete = "";
if ($iscomplete=="1" || $iscomplete=="on")
$o->styledisplaycomplete = "style='display:none'";

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

$o->addovertime_id=$_POST['addovertime_id']; // for add line purpose
$o->deleteline_id=$_POST['deleteline_id']; // for add line purpose

//sub list
$o->overtimeline_id=$_POST['overtimeline_id'];
$o->overtimeline_date=$_POST['overtimeline_date'];
$o->overtimeline_starttime=$_POST['overtimeline_starttime'];
$o->overtimeline_endtime=$_POST['overtimeline_endtime'];
$o->overtimeline_totalhour=$_POST['overtimeline_totalhour'];
$o->overtimeline_rate=$_POST['overtimeline_rate'];
$o->overtimeline_type=$_POST['overtimeline_type'];
$o->overtimeline_totalamt=$_POST['overtimeline_totalamt'];
$o->line_desc=$_POST['line_desc'];

$o->overtimedatectrl=$dp->show("overtime_date");

$tot_verify = 0;
//check user type
    $employee_id = 0;
    $employee_id = $o->getEmployeeId($o->updatedby);
    $o->wherestremp = "";
    $o->wherestrempapproval = "";
    if($o->employee_id == "")
    $o->employee_id = 0;

    if($o->isAdmin){
    $searchbtn = "Y";
    $shownull = "Y";
    $o->styledisplayadmin = "";
    }else{
    $searchbtn = "N";
    $shownull = "N";
    $o->styledisplayadmin = "style='display:none'";
    

    
    if($employee_id >0){
    $wherestremp = " and employee_id =  $employee_id ";
    $o->wherestremp = " and ot.employee_id = $employee_id ";
    $o->wherestrempapproval = " and ot.verified_by = $employee_id ";
    
    }else
    echo "<font color=red>Please Define User Login At HR Module.</font>";

    }
    $tot_verify = $o->getTotalVerify($employee_id);
    if($employee_id >0){
    $o->wherestrempapproval = " and ot.verified_by = $employee_id ";
    }
//end check

echo <<< EOF
    <table>
    <tr>
    <td align="right" nowrap><a href="otapproval.php?issearch=Y&iscomplete=0&action=searchapproval">$tot_verify <img src="images/new.gif"> New OT Application (Need To Verify) >></a></td>
    </tr>
    </table>
EOF;
 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with otapproval name=$o->otapproval_name");

	if ($s->check(false,$token,"CREATE_ACG")){
		
		
		
	if($o->insertOtapproval()){
		 $latest_id=$o->getLatestOtapprovalID();
         $log->saveLog($latest_id,$tableovertime,"$o->changesql","I","O");
			 redirect_header("otapproval.php?action=edit&overtime_id=$latest_id",$pausetime,"Your data is saved.");
		}
	else {
        $log->saveLog(0,$tableovertime,"$o->changesql","I","F");
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
   
        //$o->fromaccountsctrl=$ctrl->getSelectAccounts($o->from_accounts,"N","","from_accounts"," and account_type in (4,7) ","N","N","N","from_accounts","$o->stylewidthstudent");
        $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"N","","employee_id","$wherestremp","employee_id",$employeewidth,"$searchbtn",0);
        $o->verifyctrl=$ctrl->getSelectEmployee($o->verified_by,"N","","verified_by","","verified_by",$employeewidth,"Y",0);
        $o->periodctrl=$ctrl->getSelectPeriod($o->period_id,"Y","","period_id"," and period_id > 0 ");
		$o->getInputForm("new",-1,$token);
		//$o->showOtapprovalTable("WHERE ot.overtime_id>0 and ot.organization_id=$defaultorganization_id","ORDER BY em.course_id,ot.semester_id,em.employee_no");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
        $log->saveLog(0,$tableovertime,"$o->changesql","I","F");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
  
        //$o->fromaccountsctrl=$ctrl->getSelectAccounts($o->from_accounts,"N","","from_accounts"," and account_type in (4,7) ","N","N","N","from_accounts","$o->stylewidthstudent");
        $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"N","","employee_id","$wherestremp","employee_id",$employeewidth,"$searchbtn",0);
        $o->verifyctrl=$ctrl->getSelectEmployee($o->verified_by,"N","","verified_by","","verified_by",$employeewidth,"Y",0);
        $o->periodctrl=$ctrl->getSelectPeriod($o->period_id,"Y","","period_id"," and period_id > 0 ");
		$o->getInputForm("new",-1,$token);
		//$o->showOtapprovalTable("WHERE ot.overtime_id>0 and ot.organization_id=$defaultorganization_id","ORDER BY em.course_id,ot.semester_id,em.employee_no");
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchOtapproval($o->overtime_id)){
		//create a new token for editing a form
        $whereverify = "";
        $searchverify = "Y";
        if($o->issubmit == 1){
        $whereverify = " and employee_id = $o->verified_by ";
        $wherestremp= " and employee_id = $o->employee_id ";
        $searchverify = "N";
        }

		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');

        $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"N","","employee_id","$wherestremp","employee_id",$employeewidth,"$searchverify",0);
        $o->verifyctrl=$ctrl->getSelectEmployee($o->verified_by,"N","","verified_by","$whereverify","verified_by",$employeewidth,"$searchverify",0);
        $o->periodctrl=$ctrl->getSelectPeriod($o->period_id,"Y","","period_id"," and period_id > 0 ");
        //$o->fromaccountsctrl=$ctrl->getSelectAccounts($o->from_accounts,"N","","from_accounts"," and account_type in (4,7) ","N","N","N","from_accounts","$o->stylewidthstudent");
		$o->getInputForm("edit",$o->otapproval,$token);
		//$o->showOtapprovalTable("WHERE ot.overtime_id>0 and ot.organization_id=$defaultorganization_id","ORDER BY ot.defaultlevel,ot.overtime_no");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("otapproval.php",3,"Some error on viewing your otapproval data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateOtapproval()){ //if data save successfully
            $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","U","O");

            // sub list
            if($o->updateSubLine()){// update existing line
                $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","U","O");
            }else{
                $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","U","F");
            }

            if($o->addovertime_id > 0){// if add sub if selected
                
                if($o->addSubLine($o->overtime_id,$o->addovertime_id)){
                $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","I","O");
                }else{
                $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","I","F");
                }
                
            }

            if($o->deleteline_id >0){ //delete sub

                if($o->deleteSubLine($o->deleteline_id)){
                $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","D","O");
                }else{
                $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","D","F");
                }
            }
            //end of sub list

            if(count($o->studentinvoiceline_idremain) > 0){//alert line
                if($o->updateAlertLine()){
                    $o->updateTotalAmount($o->overtime_id);

                $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","U","O");
                }else{
                $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","U","O");
                }
            }

            /*
            if($o->iscomplete == 1){
            //$o->deleteUnuseLine($o->salespayment_id);

            //start posting to simbiz
            $listAPI = $o->batchAPIPayment($o->overtime_id);
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
            $o->updateBatchInfoPayment("batch_id",$api->resultbatch_id,$o->overtime_id);
            $o->updateBatchInfoPayment("batch_no",$api->resultbatch_no,$o->overtime_id);
            }else{
            $o->updateComplete(0,$o->overtime_id);
            }
            //end of posting to simbiz

            }
             * 
             */
                 
          
			redirect_header("otapproval.php?action=edit&overtime_id=$o->overtime_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","U","F");
			redirect_header("otapproval.php?action=edit&overtime_id=$o->overtime_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","U","F");
		redirect_header("otapproval.php?action=edit&overtime_id=$o->overtime_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteOtapproval($o->overtime_id)){
            $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","D","O");
			redirect_header("otapproval.php",$pausetime,"Data removed successfully.");
        }else{
            $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","D","F");
			redirect_header("otapproval.php?action=edit&overtime_id=$o->overtime_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else
		redirect_header("otapproval.php?action=edit&overtime_id=$o->overtime_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

    case "search" :

	$wherestr =" WHERE ot.overtime_id>0 and ot.organization_id=$defaultorganization_id ";

    $limitstr = "";
	if($o->issearch == "Y"){
	$wherestr .= $o->getWhereStr();
    }else{
    $limitstr = " limit 50 ";
	$o->otapprovaltype_id = 0;
    $o->course_id = 0;
    $o->verified_by = 0;
    $o->employee_id = 0;
    $o->period_id = 0;
	}

    $wherestr .= "$o->wherestremp";
    $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"$searchbtn","","employee_id","$wherestremp","employee_id",$employeewidth,"$searchbtn",0);
    $o->verifyctrl=$ctrl->getSelectEmployee($o->verified_by,"N","","verified_by","","verified_by",$employeewidth,"Y",0);
    $o->periodctrl=$ctrl->getSelectPeriod($o->period_id,"Y","","period_id"," and period_id > 0 ");
	$o->showSearchForm();
	if($o->issearch == "Y")
    $o->showOtapprovalTable($wherestr,"ORDER BY CAST(ot.overtime_no AS SIGNED)",$limitstr);
	//$o->showOtapprovalTable($wherestr,"ORDER BY em.course_id,ot.semester_id,em.employee_no",$limitstr);
  break;

  case "searchapproval" :

	$wherestr =" WHERE ot.overtime_id>0 and ot.organization_id=$defaultorganization_id ";

    $limitstr = "";
	if($o->issearch == "Y"){
	$wherestr .= $o->getWhereStrApproval();
    }else{
    $limitstr = " limit 50 ";
	$o->otapprovaltype_id = 0;
    $o->course_id = 0;
    $o->verified_by = 0;
    $o->employee_id = 0;
    $o->period_id = 0;
	}

    $wherestr .= " $o->wherestrempapproval ";
    
    $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"Y","","employee_id","","employee_id",$employeewidth,"Y",0);
    $o->verifyctrl=$ctrl->getSelectEmployee($o->verified_by,"N","","verified_by","","verified_by",$employeewidth,"Y",0);
    $o->periodctrl=$ctrl->getSelectPeriod($o->period_id,"Y","","period_id"," and period_id > 0 ");
	$o->showSearchApprovalForm();
	if($o->issearch == "Y")
    $o->showOtapprovalTable($wherestr,"ORDER BY CAST(ot.overtime_no AS SIGNED)",$limitstr);
	//$o->showOtapprovalTable($wherestr,"ORDER BY em.course_id,ot.semester_id,em.employee_no",$limitstr);
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

	$selectionlist = $o->getSelectDBAjaxStudent($strchar,$idinput,$idlayer,$ctrlid,$ocf,$tablestudent,"employee_id","employee_name"," and isactive $wherestr ","$line");

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;
      
/*
  case "deletelectline" :

//if($o->updateOtapproval()){ //if data save successfully
            //$log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","U","O");

      if($o->deleteLectLine($o->otapprovalsubline_id)){
       $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","D","O");
      }else{
       $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","D","F");
      }

echo <<< EOF
	<script type='text/javascript'>
    self.parent.location = "otapproval.php?action=edit&overtime_id=$o->overtime_id";
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
    self.parent.document.getElementById("otapproval_item$line").value = "$product_name";
    self.parent.document.getElementById("otapproval_uprice$line").value = "$invoice_amt";
    self.parent.document.getElementById("accounts_id$line").value = "$sellaccount_id";
    self.parent.updateAmount($line);
    </script>
EOF;

  break;

  case "changemethod" :
      $payment_type = $_POST['payment_type'];

      if($payment_type=="C")
      $default_acc = $cash_account;
      else
      $default_acc = $cheque_account;
echo <<< EOF
    <script type='text/javascript'>

    self.parent.document.forms["frmOtapproval"].to_accounts.value = "$default_acc";

    </script>
EOF;
  break;

    case "reactivate":

	if($o->reactivateOvertime($o->overtime_id)){ //if data save successfully
    $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","U","O");
    /*
	// simbiz AccountsAPI function here
	$api->reverseBatch($o->batch_id);
	if($o->batch_id > 0){
	$o->updateBatchInfoPayment("batch_id",0,$o->overtime_id);
	$o->updateBatchInfoPayment("batch_no","",$o->overtime_id);
	}
	// end of simbiz AccountsAPI function
     * 
     */

	redirect_header("otapproval.php?action=edit&overtime_id=$o->overtime_id",$pausetime,"This record is reactivate successfully, redirect to edit this record.");
	}else{
        $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","U","F");
		redirect_header("otapproval.php?action=edit&overtime_id=$o->overtime_id",$pausetime,"<b style='color:red'>Warning! Can't reactivate the data.</b>");
	}
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

  case "updaterate" :
      $overtimeline_type = $_POST['overtimeline_type'];
      $line = $_POST['line'];
      $employee_id = $_POST['employee_id'];

      $overtimeline_rate = $o->updateRate($overtimeline_type,$employee_id);
      
echo <<< EOF
	<script type='text/javascript'>

	self.parent.document.getElementById("overtimeline_rate$line").value = "$overtimeline_rate";
	self.parent.updateAmount($line);
	</script>
EOF;

  break;

  case "overtimeupdate" :
      $fldnamebtn = $_POST['fldnamebtn'];
      $fldnamebtn_id = $_POST['fldnamebtn_id'];
      
   if($o->overtimeUpdate($o->overtime_id,$fldnamebtn,$fldnamebtn_id)){ //if data save successfully
        $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","U","O");

	redirect_header("otapproval.php?action=edit&overtime_id=$o->overtime_id",$pausetime,"This record is update successfully.");
	}else{
        $log->saveLog($o->overtime_id,$tableovertime,"$o->changesql","U","F");
		redirect_header("otapproval.php?action=edit&overtime_id=$o->overtime_id",$pausetime,"<b style='color:red'>Warning! Can't reactivate the data.</b>");
	}
  break;

  default :


    if($o->verified_by=="")
    $o->verified_by=0;
    if($o->period_id=="")
    $o->period_id=0;
    if($o->employee_id=="")
    $o->employee_id=0;

    if($o->to_accounts=="")
    $o->to_accounts=$cash_account;

    if($o->from_accounts=="")
    $o->from_accounts=$student_account;
    
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
    
    //$o->fromaccountsctrl=$ctrl->getSelectAccounts($o->from_accounts,"N","","from_accounts"," and account_type in (4,7) ","N","N","N","from_accounts","$o->stylewidthstudent");
    $o->employeectrl=$ctrl->getSelectEmployee($o->employee_id,"N","","employee_id","$wherestremp","employee_id",$employeewidth,"$searchbtn",0);
    $o->verifyctrl=$ctrl->getSelectEmployee($o->verified_by,"N","","verified_by","","verified_by",$employeewidth,"Y",0);
    $o->periodctrl=$ctrl->getSelectPeriod($o->period_id,"Y","","period_id"," and period_id > 0 ");
	$o->getInputForm("new",0,$token);
	//$o->showOtapprovalTable("WHERE ot.overtime_id>0 and ot.organization_id=$defaultorganization_id","ORDER BY em.course_id,ot.semester_id,em.employee_no", " limit 50 ");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

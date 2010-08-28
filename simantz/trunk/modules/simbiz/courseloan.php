<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
include_once 'class/Courseloan.php';
//include_once 'class/SelectCtrl.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


//$log = new Log();
$o = new Courseloan();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

//marhan add here --> ajax
echo "<iframe src='courseloan.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">
function updateAmount(line){
unit_price = parseFloat(document.getElementById('unit_price'+line).value);
qty = parseFloat(document.getElementById('qty'+line).value);

total_amt = (unit_price*qty).toFixed(2);
document.getElementById('line_amt'+line).value = total_amt;
}

function viewProduct(line){
    styleproduct = document.getElementById('idProductCtrl'+line).style.display;

    if(styleproduct == "none")
    document.getElementById('idProductCtrl'+line).style.display = "";
    else
    document.getElementById('idProductCtrl'+line).style.display = "none";
}

function getProductInfo(semester_id,line){
    var arr_fld=new Array("action","semester_id","line");//name for POST
    var arr_val=new Array("getproductinfo",semester_id,line);//value for POST

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
    while(i< document.forms['frmCourseloan'].elements.length){
    var ctlname = document.forms['frmCourseloan'].elements[i].name;
    var data = document.forms['frmCourseloan'].elements[i].value;

    ctlname = ctlname.substring(0,ctlname.indexOf("["))
    if(ctlname=="isdeleteline"){

    document.forms['frmCourseloan'].elements[i].checked = val;
    }

    i++;

}


}

function deleteNoteLine(courseloannoteline_id,courseloan_id){

 if(validateCourseloan()){
    selectAll(false);
    document.forms['frmCourseloan'].deletenoteline_id.value = courseloannoteline_id;
    document.forms['frmCourseloan'].submit();
}else{
c
    return false;
}

}

function checkAddNote(){

    if(validateCourseloan()){
    selectAll(false);
    document.forms['frmCourseloan'].addnote_line.value = 1;
    document.forms['frmCourseloan'].submit();
    }else
    return false;

}

function deleteSubLine(courseloanline_id){

 if(validateCourseloan()){
    document.forms['frmCourseloan'].deleteline_id.value = courseloanline_id;
    document.forms['frmCourseloan'].submit();
}else{
    document.forms['frmCourseloan'].deleteline_id.value = 0;
    return false;
}


/*
var arr_fld=new Array("action","courseloansubline_id","courseloan_id");//name for POST
var arr_val=new Array("deletelectline",courseloansubline_id,courseloan_id);//value for POST

getRequest(arr_fld,arr_val);
*/

}

function checkAddSelect(){

document.forms['frmCourseloan'].addcourseloan_id.value = 1;
document.forms['frmCourseloan'].submit();
}

function autofocus(){
document.forms['frmCourseloan'].courseloan_name.focus();
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


	function validateCourseloan(){
		
		var name=document.forms['frmCourseloan'].courseloan_name.value;
		var defaultlevel=document.forms['frmCourseloan'].defaultlevel.value;
		var courseloan_no=document.forms['frmCourseloan'].courseloan_no.value;
		var course_id =document.forms['frmCourseloan'].course_id.value;
	
			
		if(confirm("Save record?")){
		if(course_id =="" || course_id == 0){
			alert('Please make sure Course is Selected in.');
			return false;
		}
		else{

                //check all line 
                var i=0;
                while(i< document.forms['frmCourseloan'].elements.length){
                var ctl = document.forms['frmCourseloan'].elements[i].name;
                var val = document.forms['frmCourseloan'].elements[i].value;

                ctlname = ctl.substring(0,ctl.indexOf("["))

                if(ctlname=="unit_price" || ctlname=="qty" || ctlname=="line_amt" ){
                    if(!IsNumeric(val) || val == ""){
                    document.forms['frmCourseloan'].elements[i].style.backgroundColor = "#FF0000";
                    alert("Please make sure amount filled with proper value.");
                    return false;
                    }

                }else
                    document.forms['frmCourseloan'].elements[i].style.backgroundColor = "#FFFFFF";
                i++;
                }//end of check line
            return true;
            }
		}
		else
			return false;
	}
function gotoAction(action){
	document.forms['frmCourseloan'].action.value = action;
	document.forms['frmCourseloan'].submit();
	}

</script>

EOF;

$o->courseloan_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->courseloan_id=$_POST["courseloan_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->courseloan_id=$_GET["courseloan_id"];

}
else
$action="";

$token=$_POST['token'];

$o->courseloan_name=$_POST["courseloan_name"];
$o->courseloan_no=$_POST["courseloan_no"];
$o->courseloan_category=$_POST["courseloan_category"];

$o->course_id=$_POST["course_id"];
$o->semester_id=$_POST["semester_id"];
$o->courseloantype_id=$_POST["courseloantype_id"];
$o->courseloan_crdthrs1=$_POST["courseloan_crdthrs1"];
$o->courseloan_crdthrs2=$_POST["courseloan_crdthrs2"];
$o->exam_hour=$_POST["exam_hour"];

$isactive=$_POST['isactive'];
$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

$o->issearch=$_POST['issearch'];

if ($isactive=="1" || $isactive=="on")
	$o->isactive=1;
else if ($isactive=="null")
	$o->isactive="null";
else
	$o->isactive=0;


$o->addcourseloan_id=$_POST['addcourseloan_id']; // for add line purpose
$o->deleteline_id=$_POST['deleteline_id']; // for delete sub line purpose
$o->addnote_line=$_POST['addnote_line']; // for add line purpose
$o->deletenoteline_id=$_POST['deletenoteline_id']; // for delete note line purpose
$o->isdeleteline=$_POST['isdeleteline']; // for delete note line purpose (by selected)

//sub list
$o->courseloanline_id=$_POST['courseloanline_id'];
$o->courseloanline_item=$_POST['courseloanline_item'];
$o->courseloanline_type=$_POST['courseloanline_type'];
$o->semester_id=$_POST['semester_id'];
$o->accounts_id=$_POST['accounts_id'];
$o->semester_list=$_POST['semester_list'];
$o->line_desc=$_POST['line_desc'];
$o->unit_price=$_POST['unit_price'];
$o->qty=$_POST['qty'];
$o->line_amt=$_POST['line_amt'];

//note list

$o->courseloannoteline_id = $_POST['courseloannoteline_id'];
$o->courseloannote_title = $_POST['courseloannote_title'];
$o->isdownload = $_POST['isdownload'];
$o->courseloannote_description = $_POST['courseloannote_description'];

//filenote -> line
$o->atttmpfile= $_FILES["filenote"]["tmp_name"];
$o->attfilesize=$_FILES["filenote"]["size"];
$o->attfiletype=$_FILES["filenote"]["type"];
$o->attfilename=$_FILES["filenote"]["name"];

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with courseloan name=$o->courseloan_name");

	if ($s->check(false,$token,"CREATE_ACG")){
		
		
		
	if($o->insertCourseloan()){
		 $latest_id=$o->getLatestCourseloanID();
         $log->saveLog($latest_id,$tablecourseloan,"$o->changesql","I","O");
			 redirect_header("courseloan.php?action=edit&courseloan_id=$latest_id",$pausetime,"Your data is saved. Redirect to create loan item.");
		}
	else {
        $log->saveLog(0,$tablecourseloan,"$o->changesql","I","F");
			$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
        //$o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        //$o->courseloantypectrl=$ctrl->getSelectCourseloantype($o->courseloantype_id,"Y");
		$o->getInputForm("new",-1,$token);
		$o->showCourseloanTable("WHERE a.courseloan_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,a.courseloan_no");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
        $log->saveLog(0,$tablecourseloan,"$o->changesql","I","F");
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
        //$o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
        //$o->courseloantypectrl=$ctrl->getSelectCourseloantype($o->courseloantype_id,"Y");
		$o->getInputForm("new",-1,$token);
		$o->showCourseloanTable("WHERE a.courseloan_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,a.courseloan_no");
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchCourseloan($o->courseloan_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG"); 
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
        //$o->courseloantypectrl=$ctrl->getSelectCourseloantype($o->courseloantype_id,"Y");
        $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"N");
        //$o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
		$o->getInputForm("edit",$o->courseloan,$token);
		//$o->showCourseloanTable("WHERE a.courseloan_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,a.courseloan_no");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("courseloan.php",3,"Some error on viewing your courseloan data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateCourseloan()){ //if data save successfully
            $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","U","O");

            // sub list
            if($o->updateSubLine()){// update existing line
                $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","U","O");
            }else{
                $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","U","F");
            }
            
            if($o->addcourseloan_id > 0){// if add sub if selected
                
                if($o->addSubLine($o->courseloan_id,$o->addcourseloan_id)){
                $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","I","O");
                }else{
                $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","I","F");
                }
                
            }

            if($o->deleteline_id >0){ //delete sub

                if($o->deleteSubLine($o->deleteline_id)){
                $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","D","O");
                }else{
                $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","D","F");
                }
            }
            //end of sub list

                /*
            // note list
            if($o->updateNoteLine()){// update existing line
                $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","U","O");
            }else{
                $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","U","F");
            }

            if($o->addnote_line > 0){// if add note if selected

                if($o->addNoteLine($o->courseloan_id)){
                $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","I","O");
                }else{
                $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","I","F");
                }

            }

            if($o->deletenoteline_id >0){ //delete note

                if($o->deleteNoteLine($o->deletenoteline_id)){
                $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","D","O");
                }else{
                $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","D","F");
                }
            }
            //end of note list
                 * */
          
			redirect_header("courseloan.php?action=edit&courseloan_id=$o->courseloan_id",$pausetime,"Your data is saved.");
        }else{
            $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","U","F");
			redirect_header("courseloan.php?action=edit&courseloan_id=$o->courseloan_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","U","F");
		redirect_header("courseloan.php?action=edit&courseloan_id=$o->courseloan_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		if($o->deleteCourseloan($o->courseloan_id)){
            $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","D","O");
			redirect_header("courseloan.php",$pausetime,"Data removed successfully.");
        }else{
            $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","D","F");
			redirect_header("courseloan.php?action=edit&courseloan_id=$o->courseloan_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else
		redirect_header("courseloan.php?action=edit&courseloan_id=$o->courseloan_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

    case "search" :

	$wherestr =" WHERE a.courseloan_id>0 and a.organization_id=$defaultorganization_id ";

    $limitstr = "";
	if($o->issearch == "Y"){
	$wherestr .= $o->getWhereStr();
    }else{
    $limitstr = " limit 50 ";
	$o->courseloantype_id = 0;
    $o->course_id = 0;
    $o->semester_id = 0;
	}

	//$o->courseloantypectrl=$ctrl->getSelectCourseloantype($o->courseloantype_id,"Y");
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    //$o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
	$o->showSearchForm();
	if($o->issearch == "Y")
	$o->showCourseloanTable($wherestr,"ORDER BY a.defaultlevel,a.courseloan_no",$limitstr);
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

	$selectionlist = $o->getSelectDBAjaxProduct($strchar,$idinput,$idlayer,$ctrlid,$ocf,$tableproduct,"semester_id","product_name"," $wherestr ","$line");

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;
/*
  case "deletelectline" :

//if($o->updateCourseloan()){ //if data save successfully
            //$log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","U","O");

      if($o->deleteLectLine($o->courseloansubline_id)){
       $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","D","O");
      }else{
       $log->saveLog($o->courseloan_id,$tablecourseloan,"$o->changesql","D","F");
      }

echo <<< EOF
	<script type='text/javascript'>
    self.parent.location = "courseloan.php?action=edit&courseloan_id=$o->courseloan_id";
	</script>
EOF;
 
  break;*/

  case "getproductinfo" :

    $line = $_POST['line'];
    $semester_id = $_POST['semester_id'];

    $product_info = $o->getProductInfo($semester_id);

    $product_name = $product_info["product_name"];
    $sellaccount_id = $product_info["sellaccount_id"];
    $invoice_amt = $product_info["invoice_amt"];

echo <<< EOF
    <script type='text/javascript'>
    self.parent.document.getElementById("courseloanline_item$line").value = "$product_name";
    self.parent.document.getElementById("unit_price$line").value = "$invoice_amt";
    self.parent.document.getElementById("accounts_id$line").value = "$sellaccount_id";
    self.parent.updateAmount($line);
    </script>
EOF;

  break;

  default :
    if($o->courseloantype_id=="")
    $o->courseloantype_id=0;
    if($o->course_id=="")
    $o->course_id=0;
    if($o->semester_id=="")
    $o->semester_id=0;
    
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
    //$o->courseloantypectrl=$ctrl->getSelectCourseloantype($o->courseloantype_id,"Y");
    $o->coursectrl=$ctrl->getSelectCourse($o->course_id,"Y");
    $o->semesterctrl=$ctrl->getSelectSemester($o->semester_id,"Y");
    //$o->courseloanctrl=$ctrl->getSelectCourseloan($o->courseloanctrl,"Y");
	$o->getInputForm("new",0,$token);
	//$o->showCourseloanTable("WHERE a.courseloan_id>0 and a.organization_id=$defaultorganization_id","ORDER BY a.defaultlevel,a.courseloan_no", " limit 50 ");
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

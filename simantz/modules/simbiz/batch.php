<?php
include "system.php";
//include_once "../simantz/class/Permission.php";
include_once 'class/Batch.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
include_once "../simantz/class/WorkflowAPI.inc.php";
include_once "../simantz/class/SelectCtrl.inc.php";
include_once "../simantz/class/Save_Data.inc.php";
$save = new Save_Data();
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';
$isadmin=$xoopsUser->isAdmin();

//$log = new Log();
$o = new Batch();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();

$o->rcode = date("YmdHis", time()) ;
$_SESSION['sql_txt_'.$o->rcode] = "";

$orgctrl="";

$action="";

if (isset($_POST['action'])){
$action=$_POST['action'];
}
elseif(isset($_GET['action'])){
$action=$_GET['action'];

}
else
$action="";


$token=$_POST['token'];

$reuse=$_REQUEST["reuse"];
$o->tax_type=$_REQUEST["tax_type"];
$o->iscomplete=$_REQUEST["iscomplete"];
$o->batchno=$_REQUEST["batchno"];
$o->batch_name=$_REQUEST["batch_name"];
$o->description=$_REQUEST["description"];
$o->totaldebit=$_REQUEST["totaldebit"];
$o->totalcredit=$_REQUEST["totalcredit"];
$o->fromsys=$_REQUEST["fromsys"];
$o->isreadonly=$_REQUEST["isreadonly"];
$o->batchdate=$_REQUEST["batchdate"];
$o->batch_id=$_REQUEST["batch_id"];
$o->period_id=$_REQUEST["period_id"];
$o->period_name=$_REQUEST["period_name"];
$o->isposted=$_REQUEST["isposted"];
$o->track1_name=$_REQUEST["track1_name"];
$o->track2_name=$_REQUEST["track2_name"];
$o->track3_name=$_REQUEST["track3_name"];


if ($reuse==1 or $reuse=="on")
	$o->reuse=1;
else
	$o->reuse=0;


/* end */

//if(isset($_POST['iscomplete']))
//$iscomplete=$_POST['iscomplete'];
//else
//$iscomplete=$_GET['iscomplete'];

$o->organization_id=$_POST['organization_id'];
$o->seqno=$_POST['seqno'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->updated=date("y/m/d H:i:s", time()) ;
$o->created=date("y/m/d H:i:s", time()) ;
$o->isAdmin=$xoopsUser->isAdmin();
$o->currentdate=date("Y-m-d", time()) ;




$o->batchdatectrl=$dp->show("batchdate");

$o->failfeedback = "";

$o->showcalendarfrom=$dp->show("batchdatefrom");
$o->showcalendarto=$dp->show("batchdateto");

/* define workflow API */
//$workflowapi = new WorkflowAPI();
//$o->parameter_array = $o->defineWorkflowParameter();
//$o->window_workflow = "GENERCLAIM";
/* end */

$o->defineHeaderButton();

 switch ($action){

    case "searchgrid": //return xml table to grid
    $wherestring=" WHERE bt.batch_id>0";
      $wherestring.=" AND bt.organization_id=$defaultorganization_id ";
    $o->showBatchGrid($wherestring);
    exit; //after return xml shall not run more code.
    break;

    case "getbatchline": //return xml table to grid
            echo '<html  xmlns:ntb="http://www.nitobi.com">';
    $o->includeGeneralFile();
    $o->allowedit=$_REQUEST["allowedit"];
    $o->getBatchlineform();
            echo '</html>';
    exit; //after return xml shall not run more code.
    break;
    case "searchbatchline": //return xml table to grid
    $wherestring=" WHERE batch_id=$o->batch_id";
    $o->showBatchline($wherestring);
    exit; //after return xml shall not run more code.
    break;

    case "saveBatchline": //process submited xml data from grid
    $o->saveBatchline();
    break;

    case "delete" :


        if($o->deleteBatchAjax($o->batch_id)){//success
        $msg = "<div class='statusmsg'>Record deleted successfully.</div>";
        $arr = array("msg"=>$msg,"status"=>1);
        echo json_encode($arr);
        }else{//failed
        $msg = "<div class='statusmsg'>Failed to delete Record. Please try again.</div>";
        $arr = array("msg"=>$msg,"status"=>2);
        echo json_encode($arr);
        }
    break;

    case "activatebatch" :

        if($o->activateBatchAjax()){//success
        $msg = "";
        $workflowbtn = $o->getListButton($o->batch_id);//show submit button
        $arr = array("msg"=>$msg,"status"=>1,"batch_id"=>$o->batch_id,"workflowbtn"=>"$workflowbtn");
        echo json_encode($arr);
        }else{//failed
        $msg = "<div class='statusmsg'>Failed to activate record. Please try again.</div>";
        $arr = array("msg"=>$msg,"status"=>2,"batch_id"=>$o->batch_id,"workflowbtn"=>"none");
        echo json_encode($arr);
        }
    break;

    case "update" :

	$batchdate=$_POST['batchdate'];

        include_once "class/FinancialYearLine.php";
        $fyl = new FinancialYearLine();
        $allowtrans=$fyl->allowAccountTransactionInDate($defaultorganization_id,$batchdate);
        $o->period_id=$fyl->period_id;

	//$o->period_id = $o->checkPeriodID($batchdate);

        if($o->period_id > 0 && $allowtrans == true){//check period id


            $saveparent = $o->updateBatchAjax();
            $nothingchange = strpos($o->failfeedback,"nothing");

            if($saveparent || $nothingchange !== false){//success
            $msg = "";
            $workflowbtn = $o->getListButton($o->batch_id);//show submit button
            $arr = array("msg"=>$msg,"status"=>1,"batch_id"=>$o->batch_id,"workflowbtn"=>"$workflowbtn");
            echo json_encode($arr);
            }else{//failed
            $msg = "<div class='statusmsg'>Failed to update record. Please try again.</div>";
            $arr = array("msg"=>$msg,"status"=>2,"batch_id"=>$o->batch_id,"workflowbtn"=>"none");
            echo json_encode($arr);
            }

        }else{
            //$msg = "<div class='statusmsg'>Period ID for $batchdate not found.<br/>Please Add New Period for this date. </div>";
            $msg = "<div class='statusmsg'>Failed to saved Record. Please check your financial year for $batchdate.</div>";
            $arr = array("msg"=>$msg,"status"=>2,"batch_id"=>$o->batch_id);
            echo json_encode($arr);
        }
    break;

    case "create" :

	$batchdate=$_POST['batchdate'];

        include_once "class/FinancialYearLine.php";
        $fyl = new FinancialYearLine();
        $allowtrans=$fyl->allowAccountTransactionInDate($defaultorganization_id,$batchdate);
        $o->period_id=$fyl->period_id;

	//$o->period_id = $o->checkPeriodID($batchdate);
        $log->showLog(3,"Allow Trans: $allowtrans");
        if($o->period_id > 0 && $allowtrans ){//check period id

            if($o->saveBatchAjax()){//success
            $batch_id = $o->getBatchID();
            $o->batch_id = $batch_id;
            $workflowbtn = $o->getListButton($batch_id);//show submit button
            $msg = "";
            $arr = array("msg"=>$msg,"status"=>1,"batch_id"=>$batch_id,"workflowbtn"=>"$workflowbtn");

            echo json_encode($arr);
            }else{//failed
            $msg = "<div class='statusmsg'>Failed to saved Record. Please try again.!</div>";
            $arr = array("msg"=>$msg,"status"=>2,"batch_id"=>"0");
            echo json_encode($arr);
            }

        }else{
            //$msg = "<div class='statusmsg'>Period ID for $batchdate not found.<br/>Please Add New Period for this date. </div>";
            $msg = "<div class='statusmsg'>Failed to saved Record. Please check your financial year for $batchdate.</div>";
            $arr = array("msg"=>$msg,"status"=>2,"batch_id"=>"0");
            echo json_encode($arr);
        }
    break;

    case "reuse" :

	$batchdate=$_POST['batchdate'];

        include_once "class/FinancialYearLine.php";
        $fyl = new FinancialYearLine();
        $allowtrans=$fyl->allowAccountTransactionInDate($defaultorganization_id,$batchdate);
        $o->period_id=$fyl->period_id;

        if($o->period_id > 0 && $allowtrans == true){//check period id


            if($o->reUse()){//success

            $o->batch_id = $o->getBatchID();
            $msg = "<div>Re-use record successfully.Please wait while page will redirect to your new record.</div>";
            $arr = array("msg"=>$msg,"status"=>1,"batch_id"=>$o->batch_id);
            echo json_encode($arr);
            }else{//failed
            $msg = "<div class='statusmsg'>Failed to Re-use record. Please try again.</div>";
            $arr = array("msg"=>$msg,"status"=>2,"batch_id"=>$o->batch_id);
            echo json_encode($arr);
            }

        }else{
            $msg = "<div class='statusmsg'>Failed to saved Record. Please check your financial year for $batchdate.</div>";
            $arr = array("msg"=>$msg,"status"=>2,"batch_id"=>$o->batch_id);
            echo json_encode($arr);
        }
    break;
/*
    case "getaccountlist": //return xml table to grid
    include_once "../simantz/class/EBAGetHandler.php";
    header('Content-type: text/xml');
    $lookupdelay=300;
    $pagesize=&$_GET["pagesize"];
    $ordinalStart=&$_GET["startrecordindex"];
    $sortcolumn=&$_GET["sortcolumn"];
    $sortdirection=&$_GET["sortdirection"];
    $searchstring=&$_GET["SearchString"];
    $getHandler = new EBAGetHandler();
    $getHandler->ProcessRecords();
    $getHandler->DefineField("accounts_cell");
    $wherestring=" WHERE (accounts_id>0 and placeholder=0) or accounts_id=0 ";
    $o->getSelectAccount($wherestring);
    $getHandler->completeGet();
    break;

    case "getbpartnerlist": //return xml table to grid
    include_once "../simantz/class/EBAGetHandler.php";
    header('Content-type: text/xml');
    $lookupdelay=1000;
    $pagesize=&$_GET["pagesize"];
    $ordinalStart=&$_GET["startrecordindex"];
    $sortcolumn=&$_GET["sortcolumn"];
    $sortdirection=&$_GET["sortdirection"];
    $getHandler = new EBAGetHandler();
    $getHandler->ProcessRecords();
    $getHandler->DefineField("bpartner_cell");
    $wherestring=" WHERE bpartner_id>=0 ";
    $o->getSelectBpartner($wherestring);
    $getHandler->completeGet();
    break;*/

  case "edit" :
    include "menu.php";
//    include_once 'class/Employee.php';
//    $empclass = new Employee();
//    $empclass->fetchEmployee( $employee_id);

    if($o->fetchBatch($o->batch_id)){//success fetch data
     $save->checkCurrentVersionRecord("updated","sim_hr_batch",
     $o->updated,"batch_id",$o->batch_id);
        if($o->period_id=="")
        $o->period_id=0;

        $o->periodctrl=$ctrl->getSelectPeriod($o->period_id,'N');
        $o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
        $o->getInputForm("edit",0,$token);
        //$o->getBatchlineform();
    }else{//failed fetch data

    }

  require(XOOPS_ROOT_PATH.'/footer.php');
  break;

  case "search" :
    include "menu.php";
    $o->getIncludeFileMenu();
    $o->showSearchForm();

    require(XOOPS_ROOT_PATH.'/footer.php');

  break;

  case "getdeparment" :

  $employee_id=$_POST['employee_id'];
  echo $o->getselectDepartment($employee_id);

  break;

  case "getTotalamount" :

    $tax_id=$_POST['tax_id'];
    $val_debitchild=$_POST['val_debitchild'];
    $val_creditchild=$_POST['val_creditchild'];

    $value_array = $o->getTotalamount($tax_id,$val_debitchild,$val_creditchild);

    $debit_amt = $value_array['debit_amt'];
    $credit_amt = $value_array['credit_amt'];

    if($debit_amt == "")
    $debit_amt = $val_debitchild;
    if($credit_amt == "")
    $debit_amt = $val_creditchild;

    $arr = array("debit_amt"=>$debit_amt,"credit_amt"=>$credit_amt);

    echo json_encode($arr);

  break;

  case "getTotalTax" :

    $tax_id=$_POST['tax_id'];

    $total_tax = $o->getTotalTax($tax_id);

    $arr = array("total_tax"=>$total_tax);

    echo json_encode($arr);

  break;

    default :
    include "menu.php";

    if($o->period_id=="")
        $o->period_id=0;
    $o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
    $o->isreadonly=0;
    $o->getInputForm("new",0,$token);
    //$o->getBatchlineform();

  require(XOOPS_ROOT_PATH.'/footer.php');
  break;

}


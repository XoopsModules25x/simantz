<?php
include "system.php";
include_once 'class/Approvallist.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
include_once "../simantz/class/WorkflowAPI.inc.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';


//$log = new Log();
$o = new Approvallist();
$s = new XoopsSecurity();


$o->getIncludeFileMenu();

$orgctrl="";

$action="";

$o->primarykey_value=0;
if (isset($_POST['action'])){
$action=$_POST['action'];
$o->primarykey_value=$_POST["primarykey_value"];

}
elseif(isset($_GET['action'])){
$action=$_GET['action'];
$o->primarykey_value=$_GET["primarykey_value"];
}
else
$action="";


$token=$_POST['token'];

$o->primarykey_name=$_REQUEST["primarykey_name"];
$o->tablename=$_REQUEST["tablename"];
$o->workflowtransaction_id=$_REQUEST["workflowtransaction_id"];
$o->person_id=$_REQUEST["person_id"];

$o->leave_date=$_POST["leave_date"];
$o->leave_no=$_POST["leave_no"];
$o->employee_id=$_REQUEST["employee_id"];
$o->leave_fromdate=$_REQUEST["leave_fromdate"];
$o->leave_todate=$_REQUEST["leave_todate"];
$o->leave_date=$_REQUEST["leave_date"];
$o->time_from=$_REQUEST["time_from"];
$o->time_to=$_REQUEST["time_to"];
$o->total_hours=$_REQUEST["total_hours"];
$o->leave_day=$_REQUEST["leave_day"];
$o->leave_address=$_REQUEST["leave_address"];
$o->leave_telno=$_REQUEST["leave_telno"];
$o->leavetype_id=$_REQUEST["leavetype_id"];
$o->lecturer_remarks=$_REQUEST["lecturer_remarks"];
$o->description=$_REQUEST["description"];
$o->window_workflow=$_REQUEST["window_workflow"];


if(isset($_POST['iscomplete']))
$iscomplete=$_POST['iscomplete'];
else
$iscomplete=$_GET['iscomplete'];

$o->organization_id=$_POST['organization_id'];
$o->defaultlevel=$_POST['defaultlevel'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->updated=date("y/m/d H:i:s", time()) ;
$o->created=date("y/m/d H:i:s", time()) ;
$o->isAdmin=$xoopsUser->isAdmin();
$o->currentdate=date("Y-m-d", time()) ;
$uid=$xoopsUser->getVar('uid');
$o->start_date=$_POST['start_date'];
$o->end_date=$_POST['end_date'];
$o->startctrl=$dp->show("start_date");
$o->endctrl=$dp->show("end_date");

$o->leavedatectrl=$dp->show("leave_date");
$o->leavefromdatectrl=$dp->show("leave_fromdate", "", "", "", "","validateTotalApprovallist()");
$o->leavetodatectrl=$dp->show("leave_todate", "", "", "", "","validateTotalApprovallist()");

/* define nitobi default value */
$o->employee_id=$_REQUEST["employee_id"];
$o->leavetype_id=$_REQUEST["leavetype_id"];
/* end */

$o->failfeedback = "";

/* define workflow API */
$workflowapi = new WorkflowAPI();
$o->parameter_array = $o->defineWorkflowParameter();
/* end */

$o->defineHeaderButton();

 switch ($action){

    //compulsory action for Workflow API
    case "next_node":

        if($o->primarykey_value > 0){

            $workflowstatus_id = $_REQUEST['status_node'];
            $person_id = $_REQUEST['person_id'];
            $workflowtransaction_feedback = $_REQUEST['workflowtransaction_feedback'];
            $nextstatus_name = $workflowapi->getStatusName($workflowstatus_id);

            $workflowReturn = $workflowapi->insertWorkflowTransaction(
                                            $o->window_workflow,
                                            "$nextstatus_name",
                                            $o->tablename,
                                            $o->primarykey_name,
                                            $o->primarykey_value,
                                            $o->parameter_array,
                                            $person_id,
                                            "",
                                            $workflowtransaction_feedback
                                            );

            if(!$workflowReturn){
                $msg = "<font style='color:red;font-weight:bold'>Operation aborted. Please check workflow API's settings.</font>";
                //redirect_header("leave.php?action=edit&leave_id=$o->leave_id",$pausetime,"$msg");
                $arr = array("msg"=>$msg,"status"=>2);
                echo json_encode($arr);
            }else{
                $msg = "<font style='color:black;font-weight:bold'>Record $nextstatus_name successfully.</font>";
                //redirect_header("leave.php?action=edit&leave_id=$o->leave_id",$pausetime,"$msg");
                $arr = array("msg"=>$msg,"status"=>1);
                echo json_encode($arr);

            }

        }

    break;
    //end

    case "searchgrid": //return xml table to grid
    $wherestring=" WHERE wt.workflowtransaction_id>0";
    $o->showApprovallistGrid($wherestring);
    exit; //after return xml shall not run more code.
    break;

    case "approvalwindows":

        $o->approvalwindows($o->primarykey_value,$o->primarykey_name,$o->tablename,$o->window_workflow,$o->workflowtransaction_id);
        exit;
    break;

    default :
       include "menu.php";

    $o->showSearchForm();

    require(XOOPS_ROOT_PATH.'/footer.php');
  break;

}




?>

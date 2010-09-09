<?php

/**
 * class ProductWorkflow
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class Approvallist
{


  private $xoopsDB;
  private $log;

//constructor
   public function Approvallist(){
	global $path,$tableprefix,$tableworkflow,$tablemodules,$log,$xoopsDB;

        $this->tablename="sim_workflownode";
	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
   }

   /*
    * return html of approval list
    */
   public function getApprovalList($id){
        global $xoopsDB,$xoopsUser,$workflowapi;
        $uid = $xoopsUser->getVar('uid');

        $wherestring .= " AND (wt.target_uid = $uid OR wt.targetparameter_name LIKE concat('%[',$uid,']%')
                        OR $uid IN (SELECT uid FROM sim_groups_users_link WHERE groupid = wt.target_groupid)
                        ) ";

        $wherestring .= " AND wt.iscomplete = 0 ";

        $sql = "SELECT
                wt.*, emp.employee_name, emp.employee_no,
                wf.workflow_name,wf.workflow_code
                FROM sim_workflowtransaction wt
                INNER JOIN sim_hr_employee emp ON wt.person_id = emp.employee_id
                INNER JOIN sim_workflow wf ON wt.workflow_id = wf.workflow_id
                $wherestring

                ORDER BY wt.created DESC";

        //$log->showLog(4,"showApprovallistGrid SQL: $sql");
        $query = $xoopsDB->query($sql);

        $i=0;
        while ($row=$this->xoopsDB->fetchArray($query))
        {
            $issubmit = $row['issubmit'];
            if($issubmit == 1){
        $i++;
        $workflowtransaction_id =$row['workflowtransaction_id'];
        $employee_name = $row['employee_name'];
        $person_id = $row['person_id'];
        $employee_no = $row['employee_no'];
        $primarykey_value = $row['primarykey_value'];
        $workflow_name = $row['workflow_name'];
        $window_workflow = $row['workflow_code'];
        $primarykey_value = $row['primarykey_value'];
        $primarykey_name = $row['primarykey_name'];
        $tablename = $row['tablename'];
        $apply_date = $row['created'];
        $approval_details = $row['workflowtransaction_description'];

        $idForm = "idApprovalForm".$window_workflow.$primarykey_value;
        $nameForm = "frmApprovalForm".$window_workflow.$primarykey_value;

        $workflowbtn = $workflowapi->getWorkflowButton($window_workflow,$primarykey_value,"$idForm","action",$this->parameter_array,"mobile",$person_id);

        $url = 'basicmobile.php?action=view&id='.$workflowtransaction_id."#details";

echo <<< EOF

    <li class="withArrow"><a href="$url">$i) $employee_name <br/><div class="txtApprovalDesc">$workflow_name - $apply_date</div></a></li>
EOF;

            }
     }

     return true;

   }


public function getInputForm($id){
	  global $xoopsDB,$xoopsUser,$url,$workflowapi;
        $uid = $xoopsUser->getVar('uid');
        $wherestring .= " AND (wt.target_uid = $uid OR wt.targetparameter_name LIKE concat('%[',$uid,']%')
                        OR $uid IN (SELECT uid FROM sim_groups_users_link WHERE groupid = wt.target_groupid)
                        ) ";


        $wherestring .= " AND wt.iscomplete = 0 and wt.workflowtransaction_id =$id ";

        $sql = "SELECT
                wt.*, emp.employee_name, emp.employee_no,
                wf.workflow_name,wf.workflow_code
                FROM sim_workflowtransaction wt
                INNER JOIN sim_hr_employee emp ON wt.person_id = emp.employee_id
                INNER JOIN sim_workflow wf ON wt.workflow_id = wf.workflow_id
                $wherestring
                ORDER BY wt.created DESC";
        $this->log->showLog(4,"getInputForm SQL: $sql");
        //$log->showLog(4,"showApprovallistGrid SQL: $sql");
        $query = $xoopsDB->query($sql);

        $i=0;
        while ($row=$xoopsDB->fetchArray($query))
        {
            $issubmit = $row['issubmit'];
      //      if($issubmit == 1){
        $i++;
        $employee_name = $row['employee_name'];
        $person_id = $row['person_id'];
        $employee_no = $row['employee_no'];
        $primarykey_value = $row['primarykey_value'];
        $workflow_name = $row['workflow_name'];
        $window_workflow = $row['workflow_code'];
        $primarykey_value = $row['primarykey_value'];
        $primarykey_name = $row['primarykey_name'];
        $tablename = $row['tablename'];
        $apply_date = $row['created'];
        $workflowtransaction_id = $row['workflowtransaction_id'];
        $approval_details = $row['workflowtransaction_description'];
            $approval_details = str_replace("\n","<br>",$approval_details);
        $idForm = "idApprovalForm".$window_workflow.$primarykey_value;
        $nameForm = "frmApprovalForm".$window_workflow.$primarykey_value;
   $this->log->showLog(3,"test getWorkflowButton , window_workflow:$window_workflow, primarykey_value: $primarykey_value, idForm:$idForm, person_id:$person_id, $this->parameter_array");
        $workflowbtn = $workflowapi->getWorkflowButton($window_workflow,$primarykey_value,"$idForm","action",$this->parameter_array,"mobile",$person_id);

        $html .= '<div id="details" class="jPintPage HasTitle EdgedList EditModeOff Notes">';
        $html .= '<form name="'.$nameForm.'" id="'.$idForm.'" method="POST" action="basicmobile.php">';
        $html .= '
                <input type="hidden" id="action" name="action" value="next_node">
                <input type="hidden" id="primarykey_value" name="primarykey_value" value="'.$primarykey_value.'">
                <input type="hidden" id="primarykey_name" name="primarykey_name" value="'.$primarykey_name.'">
                <input type="hidden" id="tablename" name="tablename" value="'.$tablename.'">
                <input type="hidden" id="window_workflow" name="window_workflow" value="'.$window_workflow.'">
                <input type="hidden" id="$workflowtransaction_id" name="$workflowtransaction_id" value="'.$workflowtransaction_id.'">
                ';

       $html .= '<h1>Approval
                    <a class="BackButton">Back</a>
                    </h1>

                    <table>
                        <tr>
                            <th align="left">Type:</th>
                        </tr>
                        <tr>
                            <td>'.$workflow_name.'</td>
                        </tr>
                        <tr>
                            <th align="left">Staff:</th>
                        </tr>
                        <tr>
                            <td>'.$employee_name.' ('.$employee_no.')</td>
                        </tr>
                        <tr>
                            <th align="left">Date Applied:</th>
                        </tr>
                        <tr>
                            <td>'.$apply_date.'</td>
                        </tr>
                        <tr>
                            <th align="left">Details:</th>
                        </tr>
                        <tr>
                            <td>'.$approval_details.'</td>
                        </tr>

                        <tr>
                            <td>'.$workflowbtn.'</td>
                        </tr>
                    </table>
                ';
         $html .= '</form></div>';


      //  $url = 'basicmobile.php?action=view&id='.$primarykey_value;

     //   }
	}
	echo $html;
}
/*
    * return html of history list
    */
   public function getHistoryList(){
        global $xoopsDB,$xoopsUser,$url;
        $uid = $xoopsUser->getVar('uid');

echo <<< EOF

        <form id='idHistory1' method='GET' action='basicmobile.php'>
        <input type='hidden' name='day' value='1'>
        <input type='hidden' name='action' value='history'>
        </form>
        <form id='idHistory7' method='GET' action='basicmobile.php'>
        <input type='hidden' name='day' value='7'>
        <input type='hidden' name='action' value='history'>
        </form>
        <form id='idHistory30' method='GET' action='basicmobile.php'>
        <input type='hidden' name='day' value='30'>
        <input type='hidden' name='action' value='history'>
        </form>
        
        <li class="withArrow"><a onclick="showHistory(1)" >1) Today</a></li>
        <li class="withArrow"><a onclick="showHistory(7)">2) Latest 7 days</a></li>
        <li class="withArrow"><a onclick="showHistory(30)">3) Latest 30 days</a></li>
EOF;


   }

  /*
   * define parameter for workflow in array
   */

  public function defineWorkflowParameter(){
        global $xoopsUser;

    switch ($this->window_workflow){

     CASE  "LEAVE":
        include_once "../hr/class/Leave.php";
        $lev = new Leave();
               $lev->leave_id=$this->primarykey_value;
               $lev->person_id=$this->person_id;
               $lev->window_workflow= $this->window_workflow;
        return $lev->defineWorkflowParameter();
     break;

     CASE  "GENERCLAIM":

        include_once "../hr/class/Generalclaim.php";
        $gen = new Generalclaim();
               $gen->generalclaim_id=$this->primarykey_value;
               $gen->person_id=$this->person_id;
               $gen->window_workflow= $this->window_workflow;
        return $gen->defineWorkflowParameter();
     break;

     CASE  "MEDICCLAIM":

        include_once "../hr/class/Medicalclaim.php";
        $me = new Medicalclaim();
               $me->medicalclaim_id=$this->primarykey_value;
               $me->person_id=$this->person_id;
               $me->window_workflow= $this->window_workflow;
        return $me->defineWorkflowParameter();
     break;

      CASE  "OVERCLAIM":

        include_once "../hr/class/Overtimeclaim.php";
        $ov = new Overtimeclaim_id();
               $ov->overtimeclaim_id=$this->primarykey_value;
               $ov->person_id=$this->person_id;
               $ov->window_workflow= $this->window_workflow;
        return $ov->defineWorkflowParameter();
     break;

      CASE  "TRAVECLAIM":

        include_once "../hr/class/Travellingclaim.php";
        $tr = new Travellingclaim();
               $tr->travellingclaim_id=$this->primarykey_value;
               $tr->person_id=$this->person_id;
               $tr->window_workflow= $this->window_workflow;
        return $tr->defineWorkflowParameter();
     break;

      CASE  "LEAVEADJ":

        include_once "../hr/class/Leaveadjustment.php";
        $led = new Leaveadjustment();
               $led->leaveadjustment_id=$this->primarykey_value;
               $led->person_id=$this->person_id;
               $led->window_workflow= $this->window_workflow;
        return $led->defineWorkflowParameter();
     break;

     default:
         break;
    }
//        $uid = $xoopsUser->getVar('uid');
//        /* start define hod */
//        include_once "../hr/class/Employee.php";
//        $emp = new Employee();
//
//        $hod_uid = $emp->getHODDepartmentID($uid);
//        /* end */
//      return $parameter_array = array(
//                                '{own_uid}'=>$uid,
//                                '{hod_uid}'=>$hod_uid,
//                                '{email_list}'=>'',
//                                '{sms_list}'=>'',
//                                '{bypassapprove}'=>false
//                                    );

  }

  /*
   * history leave detail
   */

  public function getHistory($day=0){
        global $xoopsUser;

        $uid = $xoopsUser->getVar('uid');

        $wherestring .= " AND (wt.target_uid = $uid OR wt.targetparameter_name LIKE concat('%[',$uid,']%')
                        OR $uid IN (SELECT uid FROM sim_groups_users_link WHERE groupid = wt.target_groupid)
                        ) ";


        $wherestring .= " AND SUBSTRING(wt.created,1,10) BETWEEN SUBSTRING(DATE_SUB(NOW(),INTERVAL $day DAY),1,10) AND SUBSTRING(NOW(),1,10) ";
        
        $sql = "SELECT
                wt.*, emp.employee_name, emp.employee_no,
                wf.workflow_name,wf.workflow_code,ws.workflowstatus_name
                FROM sim_workflowtransaction wt
                INNER JOIN sim_hr_employee emp ON wt.person_id = emp.employee_id
                INNER JOIN sim_workflow wf ON wt.workflow_id = wf.workflow_id
                INNER JOIN sim_workflowstatus ws ON wt.workflowstatus_id = ws.workflowstatus_id
                $wherestring

                ORDER BY wt.created DESC";

        $query = $this->xoopsDB->query($sql);

        $list_transaction = "";
        
        $i=0;
        while ($row=$this->xoopsDB->fetchArray($query))
        {
            $workflow_name = $row['workflow_name'];
            $employee_name = $row['employee_name'];
            $workflowstatus_name = $row['workflowstatus_name'];
            $created = $row['created'];
            $list_transaction .= '<li class="withArrow">'.$employee_name.'<br/>'.$workflow_name.' - '.$workflowstatus_name.'<br/> Approval Date : '.$created.'</li>';
        }
echo <<< EOF

    <div id="history" class="jPintPage HasTitle EdgedList EditModeOff Notes enterRow">
        <h1>History Details
                    <div class="">
				<a class="BackButton">Back</a>

			</div>
        </h1>

        <ul>
        $list_transaction
        </ul>
    </div>
EOF;

  }

  public function fetchWorkflowtransaction($id){

	$this->log->showLog(3,"Fetching Workflowtransaction detail into class ApprovalBasicMobile.php.<br>");

	$sql= sprintf("SELECT wt.* , w.workflow_code
                       from sim_workflowtransaction wt
                       left join sim_workflow w on w.workflow_id = wt.workflow_id
                       where workflowtransaction_id='%d'",$id);

	$this->log->showLog(4,"ProductApprovallist->fetchWorkflowtransaction, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
        $this->window_workflow=$row["workflow_code"];
        $this->primarykey_value=$row["primarykey_value"];
        $this->person_id=$row['person_id'];
      
   	$this->log->showLog(4,"Approvallist->fetchWorkflowtransaction,database fetch into class successfully");
	return true;
	}
	else{
	return false;
	$this->log->showLog(4,"Approvallist->fetchWorkflowtransaction,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}


  }

} // end of ClassWorkflow
?>

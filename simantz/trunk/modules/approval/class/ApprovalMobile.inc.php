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
   public function getApprovalList(){
        global $xoopsDB,$xoopsUser,$workflowapi;
        $uid = $xoopsUser->getVar('uid');

        /*
        $wherestring = "WHERE 1 ";
        $wherestring .= " AND lv.iscomplete = '0' ";

        $wherestring .= " AND (wt.target_uid = $uid OR $uid IN (wt.targetparameter_name)
                        OR $uid IN (SELECT uid FROM sim_groups_users_link WHERE groupid = wt.target_groupid)
                        ) ";

        $sqlleave = "SELECT wt.*, 'LEAVE' as window_workflow,lv.leave_date as apply_date,lv.leave_no as doc_no,
                wf.workflow_name,em.employee_name,em.employee_no,
                CONCAT('<b>Leave Date :</b> ',lv.leave_fromdate,' - ',lv.leave_todate,'<br/>','<b>Reasons :</b><br/>',lv.description) as approval_details
                FROM sim_workflowtransaction wt
                INNER JOIN sim_workflow wf ON wt.workflow_id = wf.workflow_id
                INNER JOIN sim_workflowstatus ws ON wt.workflowstatus_id = ws.workflowstatus_id
                INNER JOIN sim_workflownode wn ON wt.workflowstatus_id = wn.workflowstatus_id AND wt.workflow_id = wn.workflow_id
                INNER JOIN sim_workflownode wnp ON wn.workflownode_id = wnp.parentnode_id
                INNER JOIN sim_hr_leave lv ON lv.leave_id = wt.primarykey_value AND wt.primarykey_name = 'leave_id'
                INNER JOIN sim_hr_employee em ON lv.employee_id = em.employee_id
                AND wt.tablename = 'sim_hr_leave'

                $wherestring AND lv.issubmit = 1
                GROUP BY wt.tablename, wt.primarykey_name, wt.primarykey_value
                ORDER BY lv.leave_date ";

        $sql = "SELECT * FROM (
                ($sqlleave)
                ) a
                ORDER BY a.apply_date ASC
                ";
         * 
         */

        $wherestring .= " AND (wt.target_uid = $uid OR $uid IN (wt.targetparameter_name)
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



        $html .= '<div id="details'.$primarykey_value.'" class="jPintPage HasTitle EdgedList EditModeOff Notes">';

        $html .= '<form name="'.$nameForm.'" id="'.$idForm.'" method="POST" action="index.php#approvalList">';

        $html .= '
                <input type="hidden" id="action" name="action" value="next_node">
                <input type="hidden" id="primarykey_value" name="primarykey_value" value="'.$primarykey_value.'">
                <input type="hidden" id="primarykey_name" name="primarykey_name" value="'.$primarykey_name.'">
                <input type="hidden" id="tablename" name="tablename" value="'.$tablename.'">
                <input type="hidden" id="window_workflow" name="window_workflow" value="'.$window_workflow.'">
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


        $url = '#details'.$primarykey_value;

echo <<< EOF

    <li class="withArrow"><a href="$url">$i) $employee_name <br/><div class="txtApprovalDesc">$workflow_name - $apply_date</div></a></li>
EOF;

            }
     }

     return $html;

   }

/*
    * return html of history list
    */
   public function getHistoryList(){
        global $xoopsDB,$xoopsUser,$url;
        $uid = $xoopsUser->getVar('uid');

echo <<< EOF

        <form id='idHistory1' method='post' action='index.php#historyLeaveDetail'>
        <input type='hidden' name='day' value='1'>
        <input type='hidden' name='action' value='history'>
        </form>
        <form id='idHistory7' method='post' action='index.php#historyLeaveDetail'>
        <input type='hidden' name='day' value='7'>
        <input type='hidden' name='action' value='history'>
        </form>
        <form id='idHistory30' method='post' action='index.php#historyLeaveDetail'>
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

        $uid = $xoopsUser->getVar('uid');
        /* start define hod */
        include_once "../hr/class/Employee.php";
        $emp = new Employee();

        $hod_uid = $emp->getHODDepartmentID($uid);
        /* end */
      return $parameter_array = array(
                                '{own_uid}'=>$uid,
                                '{hod_uid}'=>$hod_uid,
                                '{email_list}'=>'',
                                '{sms_list}'=>'',
                                '{bypassapprove}'=>false
                                    );

  }

  /*
   * history leave detail
   */

  public function getHistoryLeave($day=0){
        global $xoopsUser;

        $uid = $xoopsUser->getVar('uid');

        /*
        $wherestring = "WHERE 1 ";
        
        $wherestring .= " AND lv.iscomplete = '1' ";

        $wherestring .= " AND (wt.target_uid = $uid OR $uid IN (wt.targetparameter_name)
                        OR $uid IN (SELECT uid FROM sim_groups_users_link WHERE groupid = wt.target_groupid)
                        ) ";

        $wherestring .= " AND SUBSTRING(wt.created,1,10) BETWEEN SUBSTRING(DATE_SUB(NOW(),INTERVAL $day DAY),1,10) AND SUBSTRING(NOW(),1,10) ";

        $sqlleave = "SELECT wt.*, 'LEAVE' as window_workflow,lv.leave_date as apply_date,lv.leave_no as doc_no,
                wf.workflow_name,em.employee_name,em.employee_no,ws.workflowstatus_name,
                CONCAT('<b>Leave Date :</b> ',lv.leave_fromdate,' - ',lv.leave_todate,'<br/>','<b>Reasons :</b><br/>',lv.description) as approval_details
                FROM sim_workflowtransaction wt
                INNER JOIN sim_workflow wf ON wt.workflow_id = wf.workflow_id
                INNER JOIN sim_workflowstatus ws ON wt.workflowstatus_id = ws.workflowstatus_id
                INNER JOIN sim_workflownode wn ON wt.workflowstatus_id = wn.workflowstatus_id AND wt.workflow_id = wn.workflow_id
                INNER JOIN sim_workflownode wnp ON wn.workflownode_id = wnp.parentnode_id
                INNER JOIN sim_hr_leave lv ON lv.leave_id = wt.primarykey_value AND wt.primarykey_name = 'leave_id'
                INNER JOIN sim_hr_employee em ON lv.employee_id = em.employee_id
                AND wt.tablename = 'sim_hr_leave'

                $wherestring AND lv.issubmit = 1
                GROUP BY wt.tablename, wt.primarykey_name, wt.primarykey_value
                ORDER BY lv.leave_date ";

        $sql = "SELECT * FROM (
                ($sqlleave)
                ) a
                ORDER BY a.apply_date ASC
                ";
         *
         */

        $wherestring .= " AND (wt.target_uid = $uid OR $uid IN (wt.targetparameter_name)
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

    <div id="historyLeaveDetail" class="jPintPage HasTitle EdgedList EditModeOff Notes enterRow">
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



} // end of ClassWorkflow
?>

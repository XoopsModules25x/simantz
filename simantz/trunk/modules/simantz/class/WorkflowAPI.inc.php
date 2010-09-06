<?php


/**
 * This class is for workflow purpose
 */
class WorkflowAPI
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $window_id;

//constructor
   public function WorkflowAPI(){
	global $path,$log,$xoopsDB;


	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
   }

   /*
    * retrun html button
    */

   public function getWorkflowButton($workflow_code,$key_value,$frmName,$fieldName,$parameter_array,$typebtn="form",$person_id=0){

        $html = "<input type='hidden' name='status_node' id='status_node' value='0'>";

        $getLatestStatusArr = $this->getLatestStatus($workflow_code,$key_value);
        $workflowstatus_id = $getLatestStatusArr['workflowstatus_id'];
        $workflowtransaction_id = $getLatestStatusArr['workflowtransaction_id'];
        $html .= "<input type='hidden' name='workflowtransaction_id' id='workflowtransaction_id' value='$workflowtransaction_id'>";
        //echo " $targetparameter_name : $target_uid : $target_groupid";


        $sql = sprintf("SELECT wn.* FROM sim_workflownode wn
                INNER JOIN sim_workflow wf ON wn.workflow_id = wf.workflow_id
                WHERE wf.workflow_code = '%s'
                AND wn.workflowstatus_id = '%d' "
                ,$workflow_code,$workflowstatus_id);

        $this->log->showLog(4," getWorkflowButton1 SQL: $sql");

        $query = $this->xoopsDB->query($sql);

        $workflowuserchoice_id = 0;
        while ($row=$this->xoopsDB->fetchArray($query))
        {
                $workflownode_id = $row['workflownode_id'];

                //echo "$workflownode_id<br>";

                $htmlBypass = $this->checkByPassWorkflow($workflownode_id,$parameter_array,$frmName,$fieldName,$typebtn,$person_id);

                $html .= $htmlBypass;
        }

        //end

        //$html = "";

        //$html = "<input type='button' value='Workflow : $workflow_code, Status : $workflowstatus_id'>";//testing purpose

        return $html;
   }

   /*
    * looping for node (check for bypass)
    */
   public function checkByPassWorkflow($workflownode_id,$parameter_array,$frmName,$fieldName,$typebtn="form",$person_id=0){

        $html = '';
   echo     $sqluserchoice = sprintf("SELECT wn.*,wl.workflowuserchoiceline_name,wl.workflowstatus_id
                            FROM sim_workflownode wn
                            INNER JOIN sim_workflowuserchoice wc ON wn.workflowuserchoice_id = wc.workflowuserchoice_id
                            INNER JOIN sim_workflowuserchoiceline wl ON wc.workflowuserchoice_id = wl.workflowuserchoice_id
                            WHERE wn.parentnode_id = '%d'
                            GROUP BY wl.workflowuserchoiceline_id"
                            ,$workflownode_id);//get child node

        $this->log->showLog(4," getWorkflowButtonUserChoice user choice SQL: $sqluserchoice");

        $queryuserchoice = $this->xoopsDB->query($sqluserchoice);

        $html .= "<input type='hidden' id='person_id' name='person_id' value='$person_id'>";

        if($typebtn == "mobile"){
            $html .= "<table aborder=1 style='width:50px'>";
            $html .= "<tr>";
            $html .= "<td class='searchTitle' style='width:10px'> Approval Feedback<br/><textarea name='workflowtransaction_feedback' id='workflowtransaction_feedback' cols='20' rows='2' astyle='display:none'></textarea></td>";
            $html .= "</tr>";
            $html .= "<tr><td acolspan='2'>";

        }else{
            $html .= "<table aborder=1 astyle='width:50%'>";
            $html .= "<tr>";
            $html .= "<td class='searchTitle' style='vertical-align:top;width:10px' >Approval Feedback</td><td aclass='even' style='width:10px'> <textarea name='workflowtransaction_feedback' id='workflowtransaction_feedback' cols='30' rows='2' astyle='display:none'></textarea></td>";
            $html .= "<td aclass='head' align='left'>";
        }

        $isbutton = 0;
        $workflowuserchoice_id = 0;
        while ($rowuserchoice=$this->xoopsDB->fetchArray($queryuserchoice)){

            //$workflowstatus_name = $rowuserchoice['workflowstatus_name'];
            $workflowuserchoiceline_name = $rowuserchoice['workflowuserchoiceline_name'];
            $workflowstatus_id = $rowuserchoice['workflowstatus_id'];
            $workflownode_button = $rowuserchoice['workflownode_id'];
            $workflow_bypass = $rowuserchoice['workflow_bypass'];

            $isbypass = $this->replaceWorkflowByPassParameter($workflow_bypass,$parameter_array);

            if($isbypass){
            $checkBypass = $this->checkByPassWorkflow($workflownode_button,$parameter_array,$frmName,$fieldName);
            $html .= $checkBypass;
            }else{

            if($this->checkButtonAllowed($workflownode_button,$parameter_array)){
                $isbutton++;
                if($typebtn == "form"){
                $html .= "<input type='button' value='$workflowuserchoiceline_name' onclick='nextNode($workflowstatus_id,\"$frmName\",\"$fieldName\",\"$workflowuserchoiceline_name\")'>";
                }else if($typebtn == "ajax"){
                $html .= "<input type='button' value='$workflowuserchoiceline_name' onclick='nextNodeAjax($workflowstatus_id,\"$frmName\",\"$fieldName\",\"$workflowuserchoiceline_name\")'>";
                }else if($typebtn == "mobile"){
                $html .= "<input type='button' value='$workflowuserchoiceline_name' onclick='nextNode($workflowstatus_id,\"$frmName\",\"$fieldName\",\"$workflowuserchoiceline_name\")'>";
                }
            $html .= "&nbsp;&nbsp;";
            }

            }
        }

        if($typebtn == "mobile"){
            $html .= "</td></tr>";

            $html .= "</table>";
        }else{
            $html .= "</td></tr>";

            $html .= "</table>";
        }

        if($isbutton == 0)
            $html = "";
        return $html;
   }
   /*
    * get latest workflowstatus
    */

   public function getLatestStatus($workflow_code,$key_value){
        $retval = "";

        $sql = sprintf("SELECT wt.* FROM sim_workflowtransaction wt
                        INNER JOIN sim_workflow wf ON wt.workflow_id = wf.workflow_id
                        WHERE wf.workflow_code = '%s'
                        AND wt.primarykey_value = '%s'
                        ORDER BY wt.created DESC LIMIT 1",
                        $workflow_code, $key_value);

        $this->log->showLog(4," getLatestStatus with SQL: $sql");

        $query = $this->xoopsDB->query($sql);

        $retval = "";
        while ($row=$this->xoopsDB->fetchArray($query))
        {
        $retval['workflowstatus_id'] = $row['workflowstatus_id'];
        $retval['workflowtransaction_id'] = $row['workflowtransaction_id'];
        $retval['target_groupid'] = $row['target_groupid'];
        $retval['target_uid'] = $row['target_uid'];
        $retval['targetparameter_name'] = $row['targetparameter_name'];

        }

        return $retval;
   }

   /*
    * excute insert SQl for sim_workflowtransaction
    */

   public function insertWorkflowTransaction($workflow_code,$workflowstatus_name,$tablename,$primarykey_name,$primarykey_value,$parameter_array=array(),
           $workflowtransaction_person="",$others="",$workflowtransaction_feedback=""){

        global $xoopsUser;
        $uid = $xoopsUser->getVar('uid');

        include_once "../simantz/class/Save_Data.inc.php";
        $save = new Save_Data();


        $this->fetchWorkflowNode($workflow_code,$workflowstatus_name);

        $this->replaceWorkflowParameter($parameter_array);

        $timestamp = date("y/m/d H:i:s", time());

        //for transaction
        $arrInsertField = array(
                                'workflowtransaction_datetime',
                                'target_groupid',
                                'target_uid',
                                'targetparameter_name',
                                'workflowstatus_id',
                                'workflow_id',
                                'tablename',
                                'primarykey_name',
                                'primarykey_value',
                                'hyperlink',
                                'title_description',
                                'created',
                                'list_parameter',
                                'workflowtransaction_description',
                                'workflowtransaction_feedback',
                                'iscomplete',
                                'createdby',
                                'email_list',
                                'sms_list',
                                'email_body',
                                'sms_body',
                                'person_id',
                                'issubmit',
                                );
        $arrInsertFieldType = array(
                                '%s',
                                '%d',
                                '%d',
                                '%s',
                                '%d',
                                '%d',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%d',
                                '%d',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%d',
                                '%d'
                                );

        $arrvalue = array(
                                $timestamp,
                                $this->target_groupid,
                                $this->target_uid,
                                $this->targetparameter_name,
                                $this->workflowstatus_id,
                                $this->workflow_id,
                                $tablename,
                                $primarykey_name,
                                $primarykey_value,
                                $this->hyperlink,
                                '',
                                date("y/m/d H:i:s", time()),
                                $this->parameter_used,
                                $this->workflow_description,
                                $workflowtransaction_feedback,
                                $this->iscomplete_node,
                                $uid,
                                $this->email_list,
                                $this->sms_list,
                                $this->email_body,
                                $this->sms_body,
                                $workflowtransaction_person,
                                $this->issubmit_node
                        );
        //end


        $saveTransaction = $save->InsertRecord('sim_workflowtransaction',
                                    $arrInsertField,
                                    $arrvalue,
                                    $arrInsertFieldType,
                                    $tablename,
                                    "workflowtransaction_id");

        if($saveTransaction){


             if($this->insertWorkflowHistory()){
                 $sqlupdate = sprintf("UPDATE sim_workflowtransaction SET issubmit = 0
                                    WHERE created < '%s'
                                    AND tablename = '%s'
                                    AND primarykey_name = '%s'
                                    AND primarykey_value = '%s' ",$timestamp,$tablename,$primarykey_name,$primarykey_value);

                 $queryupdate = $this->xoopsDB->query($sqlupdate);
                 
             }

             if($this->workflow_sql != "")//if node define sql update
             $this->runWorkflowSql($tablename,$primarykey_name,$primarykey_value);

  
//            if($this->workflow_procedure != "")//if node define procedure
//             $this->runWorkflowProcedure();

             $this->updateLatestStatus($tablename,$primarykey_name,$primarykey_value,$this->workflowstatus_id);//update latest status id


             $this->sendWorkflowSMS();//send sms

             $this->sendWorkflowMail();//send email
        }

        return $saveTransaction;
   }
   
   public function updateWorkflowTransaction($workflowtransaction_id,$workflow_code,$workflowstatus_name,$tablename,$primarykey_name,$primarykey_value,$parameter_array=array(),
           $workflowtransaction_person="",$others="",$workflowtransaction_feedback=""){

        global $xoopsUser;
        $uid = $xoopsUser->getVar('uid');

        include_once "../simantz/class/Save_Data.inc.php";
        $save = new Save_Data();


        $this->fetchWorkflowNode($workflow_code,$workflowstatus_name);

        $this->replaceWorkflowParameter($parameter_array);

        $timestamp = date("y/m/d H:i:s", time());

        //for transaction
        $arrUpdateField = array(
                                'workflowtransaction_datetime',
                                'target_groupid',
                                'target_uid',
                                'targetparameter_name',
                                'workflowstatus_id',
                                'workflow_id',
                                'tablename',
                                'primarykey_name',
                                'primarykey_value',
                                'hyperlink',
                                'title_description',
                                'updated',
                                'list_parameter',
                                'workflowtransaction_description',
                                'workflowtransaction_feedback',
                                'iscomplete',
                                'updatedby',
                                'email_list',
                                'sms_list',
                                'email_body',
                                'sms_body',
                                'person_id',
                                'issubmit',
                                );
        $arrUpdateFieldType = array(
                                '%s',
                                '%d',
                                '%d',
                                '%s',
                                '%d',
                                '%d',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%d',
                                '%d',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%d',
                                '%d'
                                );

        $arrvalue = array(
                                $timestamp,
                                $this->target_groupid,
                                $this->target_uid,
                                $this->targetparameter_name,
                                $this->workflowstatus_id,
                                $this->workflow_id,
                                $tablename,
                                $primarykey_name,
                                $primarykey_value,
                                $this->hyperlink,
                                '',
                                date("y/m/d H:i:s", time()),
                                $this->parameter_used,
                                $this->workflow_description,
                                $workflowtransaction_feedback,
                                $this->iscomplete_node,
                                $uid,
                                $this->email_list,
                                $this->sms_list,
                                $this->email_body,
                                $this->sms_body,
                                $workflowtransaction_person,
                                $this->issubmit_node
                        );
        //end


        $saveTransaction = $save->UpdateRecord('sim_workflowtransaction','workflowtransaction_id',
                                    $workflowtransaction_id,$arrUpdateField,$arrvalue,$arrUpdateFieldType,
                                    $tablename);
   

        if($saveTransaction){


             if($this->insertWorkflowHistory($workflowtransaction_feedback)){
                 $sqlupdate = sprintf("UPDATE sim_workflowtransaction SET issubmit = 0
                                    WHERE created < '%s'
                                    AND tablename = '%s'
                                    AND primarykey_name = '%s'
                                    AND primarykey_value = '%s' ",$timestamp,$tablename,$primarykey_name,$primarykey_value);

                 $queryupdate = $this->xoopsDB->query($sqlupdate);

             }

             if($this->workflow_sql != "")//if node define sql update
             $this->runWorkflowSql($tablename,$primarykey_name,$primarykey_value);

       $this->log->showLog(4,"Start run ValidateTransaction $this->workflow_procedurefile");
             if(file_exists("$this->workflow_procedurefile"))
               include "$this->workflow_procedurefile";
             if($this->workflow_procedure != "")//if node define procedure
               eval($this->workflow_procedure.";");
                     //$this->runWorkflowProcedure();

             $this->updateLatestStatus($tablename,$primarykey_name,$primarykey_value,$this->workflowstatus_id);//update latest status id



           
             $this->sendWorkflowSMS();//send sms
               $this->sendWorkflowMail();//send email
        }

        return $saveTransaction;
   }
   /*
    * run procedure
    */

   public function runWorkflowProcedure(){

        $sqlprocedure = sprintf("call $this->workflow_procedure;");

        $queryprocedure = $this->xoopsDB->query($sqlprocedure);

        $this->log->showLog(4," runWorkflowProcedure with SQL: $sqlprocedure");
   }
   /*
    * update latest status
    */

   public function updateLatestStatus($tablename,$primarykey_name,$primarykey_value,$workflowstatus_id){

        $sqlupdate = sprintf("UPDATE %s SET workflowlatest_id = %d WHERE %s = %s ",$tablename,$workflowstatus_id,$primarykey_name,$primarykey_value);

        $queryupdate = $this->xoopsDB->query($sqlupdate);

        $this->log->showLog(4," updateLatestStatus with SQL: $sqlupdate");

        if ($rowupdate=$this->xoopsDB->fetchArray($queryupdate)){
        }
   }
   /*
    * save into history
    */

   public function insertWorkflowHistory($workflowtransaction_feedback=""){
        global $xoopsUser;
        $uid = $xoopsUser->getVar('uid');

        include_once "../simantz/class/Save_Data.inc.php";
        $save = new Save_Data();

        $workflowtransaction_id = $this->getLatestWorkflowTransactionID();

       //for history
        $arrInsertField = array(
                                'workflowtransaction_id',
                                'workflowstatus_id',
                                'workflowtransaction_datetime',
                                'uid',
                                'workflowtransactionhistory_description'
                                );
        $arrInsertFieldType = array(
                                '%d',
                                '%d',
                                '%s',
                                '%d',
                                '%s'
                                );

        $arrvalue = array(
                                $workflowtransaction_id,
                                $this->workflowstatus_id,
                                date("y/m/d H:i:s", time()),
                                $uid,
                                $workflowtransaction_feedback
                        );

       return $save->InsertRecord('sim_workflowtransactionhistory',
                            $arrInsertField,
                            $arrvalue,
                            $arrInsertFieldType,
                            $tablename,
                            "workflowtransactionhistory_id");
   }

   /*
    * get workflownode info
    */

   public function fetchWorkflowNode($workflow_code,$workflowstatus_name){

        $parentnode_id = $this->getLatestParentNode($workflow_code,$workflowstatus_name);

        $wherestr = "";
        if($parentnode_id > 0)
        $wherestr = " AND wn.parentnode_id = '%d' ";

        $sql = sprintf("SELECT wn.* FROM sim_workflownode wn
                        INNER JOIN sim_workflowstatus ws ON wn.workflowstatus_id = ws.workflowstatus_id
                        INNER JOIN sim_workflow wf ON wn.workflow_id = wf.workflow_id
                        WHERE ws.workflowstatus_name = '%s'
                        AND wf.workflow_code = '%s'
                        $wherestr ",
                        $workflowstatus_name,$workflow_code,$parentnode_id);

        $this->log->showLog(4," fetchWorkflowNode with SQL: $sql");

        $query = $this->xoopsDB->query($sql);

        $retval = "";
        while ($row=$this->xoopsDB->fetchArray($query))
        {

            $this->workflow_id=$row['workflow_id'];
            $this->workflowstatus_id=$row['workflowstatus_id'];
            $this->workflowuserchoice_id=$row['workflowuserchoice_id'];
            $this->target_groupid=$row['target_groupid'];
            $this->target_uid=$row['target_uid'];
            $this->targetparameter_name=$row['targetparameter_name'];
            $this->email_list=$row['email_list'];
            $this->sms_list=$row['sms_list'];
            $this->email_subject=$row['email_subject'];
            $this->email_body=$row['email_body'];
            $this->sms_body=$row['sms_body'];
            $this->isemail=$row['isemail'];
            $this->issms=$row['issms'];
            $this->parentnode_id=$row['parentnode_id'];
            $this->workflow_procedurefile=$row['workflow_procedurefile'];
            $this->workflow_procedure=$row['workflow_procedure'];
            $this->parameter_used=$row['parameter_used'];
            $this->isactive=$row['isactive'];
            $this->workflow_description=$row['workflow_description'];
            $this->workflow_sql=$row['workflow_sql'];
            $this->hyperlink=$row['hyperlink'];
            $this->issubmit_node=$row['issubmit_node'];
            $this->iscomplete_node=$row['iscomplete_node'];

        }


   }

   /*
    * get latest
    */

   public function getLatestParentNode($workflow_code,$workflowstatus_name){

       if($workflowstatus_name != "NEW" ){

                $sql = sprintf("SELECT wn.workflownode_id
                FROM sim_workflowtransaction wt
                INNER JOIN sim_workflow wf ON wt.workflow_id = wf.workflow_id
                INNER JOIN sim_workflownode wn ON wt.workflowstatus_id = wn.workflowstatus_id AND wn.workflow_id = wt.workflow_id
                WHERE wf.workflow_code = '%s'
                ORDER BY wt.created DESC LIMIT 1 ",$workflow_code);

                $this->log->showLog(4,"getLatestParentNode SQL: $sql");
                $query=$this->xoopsDB->query($sql);
                if($row=$this->xoopsDB->fetchArray($query)){
                $this->log->showLog(4,"NODE GET : ".$row['workflownode_id']);
                return $row['workflownode_id'];
                }else{
                return 0;
                }


       }else{
                return 0;
       }

   }
   /*
    * run this function if have error during submit
    */

   public function rollbackSubmitOperation($table_name,$field_name,$field_val,$field_update="issubmit"){

        include_once "../simantz/class/Save_Data.inc.php";
        $save = new Save_Data();

        $arrUpdateField = array($field_update);
        $arrUpdateFieldType = array("%d");
        $arrvalue=array("0");

        $this->log->showLog(4," rollbackSubmitOperation with SQL: $field_update");

        return $save->UpdateRecord($table_name,$field_name,$field_val,$arrUpdateField,$arrvalue,$arrUpdateFieldType,$field_val);


   }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestWorkflowTransactionID() {
        global $xoopsUser;
        $uid = $xoopsUser->getVar('uid');

        $sql=sprintf("SELECT workflowtransaction_id as max_id from sim_workflowtransaction WHERE createdby = '%d' ORDER BY created DESC LIMIT 1;",$uid);


	$this->log->showLog(3,'getLatestWorkflowTransactionID');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){

		return $row['max_id'];
	}
	else
	return -1;

  } // end

  /*
   * get status name from workflowstatus_id
   */

  public function getStatusName($workflowstatus_id){

    $sql=sprintf("SELECT workflowstatus_name FROM sim_workflowstatus
                WHERE workflowstatus_id = '%d';",$workflowstatus_id);


    $this->log->showLog(3,'getStatusName');
    $this->log->showLog(4,"SQL: $sql");
    $query=$this->xoopsDB->query($sql);
    if($row=$this->xoopsDB->fetchArray($query)){

        return $row['workflowstatus_name'];
    }else{
        return '';
    }

  }

  /*
   * show workflow history
   * @return in HTML
   */

  public function showWorkflowHistory($workflow_code,$field_value){

        $sql = sprintf("SELECT wh.workflowtransaction_datetime,ws.workflowstatus_name,usr.name,wh.workflowtransactionhistory_description
                        FROM sim_workflowtransaction wt
                        INNER JOIN sim_workflow wf ON wt.workflow_id = wf.workflow_id
                        INNER JOIN sim_workflowtransactionhistory wh ON wt.workflowtransaction_id = wh.workflowtransaction_id
                        INNER JOIN sim_workflowstatus ws ON wh.workflowstatus_id = ws.workflowstatus_id
                        INNER JOIN sim_users usr ON wh.uid = usr.uid
                        WHERE wf.workflow_code = '%s'
                        AND wt.primarykey_value = '%d'
                        ORDER BY wh.workflowtransaction_datetime DESC
                        ",$workflow_code,$field_value);

        $this->log->showLog(3,'showWorkflowHistory');
        $this->log->showLog(4,"SQL: $sql");

        $html = "";

   

        $i=0;
        $query=$this->xoopsDB->query($sql);
        while($row=$this->xoopsDB->fetchArray($query)){
        $i++;

        if($i==1){
         $html .= "<div class='historyScroll'><table class='workflowTable'>";

         $html .= "
                <tr><td class='wflowHeaderTitle'>History</td></tr>
                <tr class='wflowHeader'>
                    <td>No</td>
                    <td align='center'>User</td>
                    <td align='center'>Date / Time</td>
                    <td align='center'>Status</td>
                    <td align='center'>Feedback</td>
                </tr>";

        }
            if($trstyle == "even")
            $trstyle = "odd";
            else
            $trstyle = "even";

            $workflowtransaction_datetime = $row['workflowtransaction_datetime'];
            $workflowstatus_name = $row['workflowstatus_name'];
            $name = $row['name'];
            $workflowtransaction_feedback = $row['workflowtransactionhistory_description'];
            $html .= "
                <tr class='$trstyle'>
                    <td>$i</td>
                    <td align='center'>$name</td>
                    <td align='center'>$workflowtransaction_datetime</td>
                    <td align='center'>$workflowstatus_name</td>
                    <td align='center'>$workflowtransaction_feedback</td>
                </tr>";

        }
        if($i>0)
        $html .= "</table></div>";

        return $html;
  }

  /*
   * return final value after replace parameter array
   */

   public function replaceWorkflowParameter($parameter_array){

        /* start replace parameter */

        foreach($parameter_array as $para_name=>$para_value){

        
        $this->targetparameter_name = str_replace($para_name,$para_value,$this->targetparameter_name);
        $this->workflow_description = str_replace($para_name,$para_value,$this->workflow_description);
        $this->email_list = str_replace($para_name,$para_value,$this->email_list);
        $this->sms_list = str_replace($para_name,$para_value,$this->sms_list);
        $this->email_subject = str_replace($para_name,$para_value,$this->email_subject);
        $this->email_body = str_replace($para_name,$para_value,$this->email_body);
        $this->sms_body = str_replace($para_name,$para_value,$this->sms_body);
        }
        /* end */
   }

  /*
   * return final value after replace parameter bypass array
   */

   public function replaceWorkflowByPassParameter($workflow_bypass,$parameter_array){


        /* start replace parameter */
        $retval = false;
        foreach($parameter_array as $para_name=>$para_value){
            if($workflow_bypass == $para_name)
            $retval = str_replace($para_name,$para_value,$workflow_bypass);

        }

        return $retval;
        /* end */
   }

  /*
   * check allowed button
   * @return boolean false or true
   */

   public function checkButtonAllowed($workflownode_id,$parameter_array){
        global $xoopsUser;
        $uid = $xoopsUser->getVar('uid');
 
        $retval = false;

        $sql = sprintf("SELECT * FROM sim_workflownode WHERE workflownode_id = '%d' ",$workflownode_id);

        $this->log->showLog(3,'checkButtonAllowed');
        $this->log->showLog(4,"SQL: $sql");

        $query=$this->xoopsDB->query($sql);
        if($row=$this->xoopsDB->fetchArray($query)){
            $this->targetparameter_name = $row['targetparameter_name'];
            $this->target_uid = $row['target_uid'];
            $this->target_groupid = $row['target_groupid'];
            $this->email_list = $row['email_list'];
            $this->sms_list = $row['sms_list'];
            $this->email_body = $row['email_body'];
            $this->sms_body = $row['sms_body'];

            $this->replaceWorkflowParameter($parameter_array);
    //   echo "????  $uid $this->targetparameter_name"; die;
       
            if($uid == $this->target_uid)//check for target_uid
            $retval = true;

            $target_arr = explode(",",$this->targetparameter_name);

            foreach($target_arr as $value){//check for targetparameter_name

                if($uid == $value)
                $retval = true;
            }

            if($this->target_groupid != ""){//check for targetgroup

                $sqlgroup = sprintf("SELECT COUNT(*) as cnt FROM sim_groups_users_link
                                    WHERE uid = '%d'
                                    AND groupid = '%d' ",$uid,$this->target_groupid);

                $this->log->showLog(3,'check for targetgroup');
                $this->log->showLog(4,"SQL: $sqlgroup");

                $querygroup=$this->xoopsDB->query($sqlgroup);
                if($rowgroup=$this->xoopsDB->fetchArray($querygroup)){

                    $cnt = $rowgroup['cnt'];

                    if($cnt > 0)
                    $retval = true;
                }


            }

        }
        return $retval;
   }

   /*
    * run sql update for node
    */

    public function runWorkflowSql($tablename,$primarykey_name,$primarykey_value){
        global $xoopsUser;
        $uid = $xoopsUser->getVar('uid');

        $sql = sprintf("UPDATE %s SET updated = NOW(), updatedby = '%d'
                        %s
                        WHERE %s = '%s' ",
                        $tablename,$uid,$this->workflow_sql,$primarykey_name,$primarykey_value);

        $this->log->showLog(3,'runWorkflowSql');
        $this->log->showLog(4,"SQL: $sql");

        return $query=$this->xoopsDB->query($sql);

    }

    /*
     * send email
     */

    public function sendWorkflowMail(){
global $smtpuser,$smtpserver,$smtppassword,$senderuser;

        $this->log->showLog(4,"run sendWorkflowMail with isemail : $this->isemail");

      if($this->isemail == 1 or 1){
      $arrcontent=explode("\n",$this->email_body);
      $subject=$arrcontent[0];
    $body=str_replace("\n", "<br/>", $this->email_body);
    include('../simantz/class/class.phpmailer.php');

    $mail             = new PHPMailer();
    $mail->IsSMTP(); // telling the class to use SMTP

    $mail->Host       = $smtpserver; // SMTP server
    $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->Username   = $smtpuser; // SMTP account username
    $mail->Password   = $smtppassword;        // SMTP account password
    $mail->SetFrom($smtpuser, $senderuser);
    $mail->AddReplyTo($smtpuser,$senderuser);
    $mail->Subject    =$subject;
    $mail->MsgHTML($body);

echo $address = $this->email_list;
$mail->AddAddress($address);


if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
        }

    }

    /*
     * send sms
     */

    public function sendWorkflowSMS(){
        global $sendsmsgroup,$smsid,$smspassword;

        $this->log->showLog(4,"run sendWorkflowSMS with isemail : $this->issms");
        if($this->issms == 1){
        if($smsid!="" && $smspassword!=""){
        include_once "../simantz/class/SendMessage.php.inc";
        $m=new SendMessage();
        $m->message=$this->sms_body;
        $m->textlength=strlen($this->sms_body);
        $m->arraynumber=explode(",",$this->sms_list);
               $m->convertArrayToNumber();
        
        $m->sendsms();
    }


        }

    }

    /*
     * check group
     */
    public function isGroup($group_name){
    global $uid;

     $sql = "select u.name, g.name as g_name from sim_users u, sim_groups g, sim_groups_users_link ug where u.uid=ug.uid and g.groupid=ug.groupid and u.uid=$uid";
     $rs = $this->xoopsDB->query($sql);
     $allow = false;
     $this->log->showLog(4,"Start run check smsgroup : $sql");

     while ($row=$this->xoopsDB->fetchArray($rs)){

         if($row['g_name']==$group_name){
             $allow = true;
         }
          $this->log->showLog(4,"run check smsgroup : ".$row['g_name']);
     }

     return $allow;
    }

} // end of ClassWorkflowAPI
?>
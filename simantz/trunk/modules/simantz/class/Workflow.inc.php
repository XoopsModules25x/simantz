<?php

/**
 * class ProductWorkflow
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class Workflow
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $workflow_id;
  public $workflow_name;
  public $table_name;
  public $parentworkflows_id;
  public $filename;
  public $isactive;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $workflowsetting;
  public $description;
  public $modulectrl;
  public $mid;
  private $xoopsDB;
  private $log;
  private $arrUpdateField;
  private $arrInsertField;
  private $tablename;
//constructor
   public function Workflow(){
	global $path,$tableprefix,$tableworkflow,$tablemodules,$log,$xoopsDB;
        $this->arrUpdateField=array(
            "workflow_id",
            "sequence_no",
            "parentnode_id",
            "workflowstatus_id",
            "workflowuserchoice_id",
            "target_groupid",
            "target_uid",
            "targetparameter_name",
            "email_list",
            "sms_list",
            "workflow_procedure",
            "email_body",
            "sms_body",
            "isemail",
            "issms",
            "workflow_description",
            "parameter_used",
            "updated",
            "updatedby",
            "isactive",
            "workflow_sql",
            "workflow_bypass",
            "hyperlink",
            "issubmit_node",
            "iscomplete_node"
        );

        $this->arrInsertField=array(
            "workflownode_id",
            "workflow_id",
            "sequence_no",
            "parentnode_id",
            "workflowstatus_id",
            "workflowuserchoice_id",
            "target_groupid",
            "target_uid",
            "targetparameter_name",
            "email_list",
            "sms_list",
            "workflow_procedure",
            "email_body",
            "sms_body",
            "isemail",
            "issms",
            "workflow_description",
            "parameter_used",
            "created",
            "createdby",
            "updated",
            "updatedby",
            "isactive",
            "organization_id",
            "workflow_sql",
            "workflow_bypass",
            "hyperlink",
            "issubmit_node",
            "iscomplete_node"
        );
        $this->arrInsertFieldType=array(
                    "%d","%d","%d","%d","%d","%s","%d","%d",
                    "%s","%s","%s","%s","%s","%s","%s","%s","%s","%s",
                    "%s","%d","%s","%d","%d","%d",
                    "%s","%s","%s","%d","%d"
        );
        $this->arrUpdateFieldType=array(
                    "%d","%d","%d","%d","%s","%d","%d",
                    "%s","%s","%s","%s","%s","%s","%s","%s","%s","%s",
                    "%s","%d","%d",
                    "%s","%s","%s","%d","%d"
        );
        $this->tablename="sim_workflownode";
	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
   }
 
  public function fetchWorkflow( $workflownode_id) {

	$this->log->showLog(3,"Fetching workflow detail into class Workflow.php.<br>");

	$sql="SELECT * from $this->tablename where workflownode_id=$workflownode_id ";

	$this->log->showLog(4,"ProductWorkflow->fetchWorkflow, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){            

        $this->workflownode_id=$row['workflownode_id'];
        $this->workflow_id=$row['workflow_id'];
        $this->sequence_no=$row['sequence_no'];
        $this->parentnode_id=$row['parentnode_id'];
        $this->workflowstatus_id=$row['workflowstatus_id'];
        $this->workflowuserchoice_id=$row['workflowuserchoice_id'];
        $this->target_groupid=$row['target_groupid'];
        $this->target_uid=$row['target_uid'];
        $this->targetparameter_name=$row['targetparameter_name'];
        $this->email_list=$row['email_list'];
        $this->sms_list=$row['sms_list'];
        $this->workflow_procedure=$row['workflow_procedure'];
        $this->email_body=$row['email_body'];
        $this->sms_body=$row['sms_body'];
        $this->isemail=$row['isemail'];
        $this->issms=$row['issms'];
        $this->workflow_description=$row['workflow_description'];
        $this->parameter_used=$row['parameter_used'];
        $this->isactive=$row['isactive'];

        $this->workflow_sql=$row['workflow_sql'];
        $this->workflow_bypass=$row['workflow_bypass'];
        $this->hyperlink=$row['hyperlink'];
        $this->issubmit_node=$row['issubmit_node'];
        $this->iscomplete_node=$row['iscomplete_node'];

   	$this->log->showLog(4,"Workflow->fetchWorkflow,database fetch into class successfully");


		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Workflow->fetchWorkflow,failed to fetch data into databases.");
	}
  } // end of member function fetchWorkflow


   public function allowDelete($id){
       $this->log->showLog(2,"Call function allowDelete($id)");
       $this->log->showLog(3,"return true");

       return true;
   }


   public function showParentWorkflowsTree($module_id){
       return $this->showChildWorkflowsTree($module_id,0,0,"");

   }
   public function showChildWorkflowsTree($workflow_id,$parent_id=0,$level=0){
       $result="";

       //$wherestr = " and parentnode_id=%d ";
       if($workflow_id==0)
           return $result;
       $sql = sprintf("SELECT wn.*,ws.workflowstatus_name
                        FROM sim_workflownode wn
                        INNER JOIN sim_workflowstatus ws on ws.workflowstatus_id = wn.workflowstatus_id
                        WHERE wn.workflow_id = %d
                        and wn.parentnode_id=%d
                        order by wn.sequence_no
                        ", $workflow_id,$parent_id);

   $query = $this->xoopsDB->query($sql);
    while ($row =$this->xoopsDB->fetchArray($query)) {

   		$children++;
                $workflownode_id=$row['workflownode_id'];

                $sequence_no=$row['sequence_no'];
                $workflowstatus_name=$row['workflowstatus_name'];
                $parentnode_id=$row['parentnode_id'];
                
                $workflow_name=$row['workflow_name'];
                if($row['isactive']==1)
                     $inactivetext="";
                else
                     $inactivetext="[Hidden]";
    $hyperlink="&nbsp;&nbsp;&nbsp;".
                "<a href='javascript:showWorkflowsForm($workflownode_id)' title='View Workflow' >$sequence_no - $workflowstatus_name</a>&nbsp;<b style='color:red'>$inactivetext</b> <a href=javascript:addChildren($workflow_id,$workflownode_id)><u  style='color:black'>[Add]</u></a>";
    $result.= "<li id='$list_id' style='list-style: none;'>";
	for($j=0;$j<$level;$j++)
            $result.= "&nbsp;&nbsp;&nbsp;&nbsp;";

    $result.=$hyperlink;
       // call this function again to display this child's children
       $result.=$this->showChildWorkflowsTree($workflow_id,$workflownode_id, $level+1,$result);
   }


   return $result;

   }

   public function showSearchForm(){
   global $permctrl,$windowsetting,$nitobigridthemes,$isadmin;


  echo <<< EOF
    <form name="frmWorkflow">
    <br/>
    <a href="index.php">Back to this module index</a>
   
    <table>
        <tr><th>Workflow</th></tr>

        <tr><td>
EOF;
  
   if($isadmin==1)
  $showdeleted="<input type=\"checkbox\" name=\"searchisdeleted\" id=\"searchisdeleted\">".
        "<a onclick=document.getElementById(\"searchisdeleted\").click() title=\"Show deleted records.\">Show Deleted Only</a>";

  echo <<< EOF
    <form name="frmWorkflow">
    <table>
        <tr>
            <td class="fieldtitle">Workflow Code</td>
            <td class="field"><input name="searchworkflow_code" id="searchworkflow_code"></td>
            <td class="fieldtitle">Workflow Name</td>
            <td class="field"><input name="searchworkflow_name" id="searchworkflow_name"></td>
        </tr>
        <tr>
            <td class="fieldtitle">Active</td>
            <td class="field">
                <select name="searchisactive" id="searchisactive">
                    <option value="-">Null</option>
                    <option value="1" SELECTED="SELECTED">Yes</option>
                    <option value="0">No</option>
                </select>
                </td>
            <td class="fieldtitle"></td>
            <td class="field"></td>
        </tr>
        <tr><td><input name="submit" value="Search" type="button" onclick="search()">$showdeleted </td></tr>
    </table>
   </form>

        </td></tr>
        <tr><td colspan="4">

<!-- Start : This is for nitobi -->

<table><tr><td align='center'>
    <ntb:grid id="DataboundGrid"
    mode="livescrolling"
    width="1150"
    height="170"
    $permctrl $windowsetting
    ondatareadyevent="dataready();"
    rowhighlightenabled="false"
    oncellclickevent="clickrecord(eventArgs)"
    keygenerator="GetNewRecordID();"
    onhandlererrorevent="showError()"
    gethandler="../load_data.php?action=workflow&searchisactive=1"
    savehandler="../save_data.php?action=workflow"
    onbeforesaveevent="validateSave()"
    onaftersaveevent="savedone(eventArgs)"
    theme="$nitobigridthemes"
    rowsperpage="1">
    
    <ntb:columns>
    
    <ntb:textcolumn maxlength="10"  label="Code"  xdatafld="workflow_code" width="100" ></ntb:textcolumn>
    <ntb:textcolumn maxlength="100"  label="Name"  xdatafld="workflow_name" width="200"></ntb:textcolumn>
    <ntb:textcolumn maxlength="255"  label="Description"   xdatafld="workflow_description" width="200"></ntb:textcolumn>    
    <ntb:textcolumn maxlength="100"   width="140" label="Owner Group"  xdatafld="workflow_ownergroup" >
    <ntb:lookupeditor  delay="1000" gethandler="../lookup.php?action=usergroup" displayfields="name" valuefield="groupid" >
    </ntb:lookupeditor>
    </ntb:textcolumn>
    <ntb:textcolumn maxlength="100"   width="140" label="Owner User"  xdatafld="workflow_owneruid" >
    <ntb:lookupeditor  delay="1000" gethandler="../lookup.php?action=employee" displayfields="employee_name" valuefield="employee_id" >
    </ntb:lookupeditor>
    </ntb:textcolumn>   
    <ntb:textcolumn maxlength="255"  label="Email"   xdatafld="workflow_email" width="200"></ntb:textcolumn>
    <ntb:textcolumn      label="Active"   width="45"  xdatafld="isactive"   sortenabled="false">
    <ntb:checkboxeditor datasource="[{value:'1',display:'Yes'},{value:'0',display:'No'}]"
    checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value">
    </ntb:checkboxeditor>
    </ntb:textcolumn>
    <ntb:numbercolumn   label="ID"  width="0" xdatafld="workflow_id"></ntb:numbercolumn>
EOF;
  //<ntb:datecolumn  label="Date" xdatafld="FLDATE" editable="true" mask="dd-MM-yyyy"></ntb:datecolumn>
//only admin user will see record info and isdeleted column
if($isadmin==1)
{
echo<<< EOF
    <ntb:textcolumn  label="Log"   xdatafld="info"    width="50"  sortenabled="false" >
    <ntb:linkeditor></ntb:linkeditor openwindow="true" >
    </ntb:textcolumn>
    <ntb:textcolumn      label="Deleted"   width="50"  xdatafld="isdeleted">
    <ntb:checkboxeditor datasource="[{valuedd:'1',displaydd:'Yes'},{valuedd:'0',displaydd:'No'}]"
    checkedvalue="1" uncheckedvalue="0" displayfields="displaydd" valuefield="valuedd">
    </ntb:checkboxeditor>
    </ntb:textcolumn>
EOF;
}

 echo <<< EOF
 </ntb:grid>

</td></tr>

<tr><td align='center'>
<div id="cellvalue"></div><div id="msgbox" class="blockContent"></div>

</td></tr>
</table>

<!-- End : This is for nitobi -->

</td></td>

        <!--<tr>
            <td class="fieldtitle">Module</td>
            <td class="field">$this->modulectrl <input name="submit" value="Search" type="submit" onclick="search()"></td>
        </tr>-->
      
</table>
</form>
EOF;
}

public function getInputForm($module_id){
    $optionlist=$this->getSelectWorkflow(0);
    $optionlistnode=$this->getSelectParentnode(0);
    $optionliststatus=$this->getSelectStatus(0);
    $optionlistchoice=$this->getSelectUserchoice(0);
    $optionlistgroup=$this->getSelectUsergroup(0);
    $optionlistuser=$this->getSelectUser(0);
    return "
        <A href=javascript:addNew()>[Add New]</a><br/>
    <form onsubmit='return false' id='idWorkflowForm'>
        <table>
            
            <tr><td class='head'>Sequence No</td>
                    <td class='even'><input id='sequence_no' name='sequence_no' value='10' size='5'></td></tr>
            <tr><td class='head'>Workflow</td>
                            <td class='even'>
                                <select id='workflow_id' name='workflow_id' onfocus=refreshworkflowlist(this.value)>
                                        $optionlist
                                </select>
                            </td></tr>
            <tr><td class='head'>Parent Node</td>
                            <td class='even'>
                                <select id='parentnode_id' name='parentnode_id' onfocus=refreshparentnodelist(this.value)>
                                        $optionlistnode
                                </select>
                            </td></tr>
            <tr><td class='head'>Status</td>
                            <td class='even'>
                                <select id='workflowstatus_id' name='workflowstatus_id' onfocus=refreshstatuslist(this.value)>
                                        $optionliststatus
                                </select>
                            </td></tr>
            <tr><td class='head'>User Choice</td>
                            <td class='even'>
                                <select id='workflowuserchoice_id' name='workflowuserchoice_id' onfocus=refreshuserchoicelist(this.value)>
                                        $optionlistchoice
                                </select>
                            </td></tr>
            <tr><td class='head'>Target Group</td>
                            <td class='even'>
                                <select id='target_groupid' name='target_groupid' onfocus=refreshusergrouplist(this.value)>
                                        $optionlistgroup
                                </select>
                            </td></tr>
            <tr><td class='head'>Target User</td>
                            <td class='even'>
                                <select id='target_uid' name='target_uid' onfocus=refreshuserlist(this.value)>
                                        $optionlistuser
                                </select>
                            </td></tr>
<tr><td class='head'>Target Parameter</td>
                    <td class='even'><textarea id='targetparameter_name' name='targetparameter_name' rows='2' cols='50' name='targetparameter_name'></textarea></td></tr>
            <tr><td class='head'>Email List</td>
                    <td class='even'><textarea id='email_list' name='email_list' rows='2' cols='50' name='email_list'></textarea></td></tr>
            <tr><td class='head'>SMS List</td>
                    <td class='even'><textarea id='sms_list' name='sms_list' rows='2' cols='50' name='sms_list'></textarea></td></tr>
            <tr><td class='head'>Procedure Name (From database)</td>
                    <td class='even'><input id='workflow_procedure' name='workflow_procedure' size='20'></td></tr>

            <tr><td class='head'>SQL Update</td>
                            <td class='even'><textarea id='workflow_sql' name='workflow_sql' rows='3' cols='50'></textarea></td></tr>

            <tr><td class='head'>Bypass Parameter</td>
                            <td class='even'><textarea id='workflow_bypass' name='workflow_bypass' rows='3' cols='50'></textarea></td></tr>

            <tr><td class='head'>Hyperlink</td>
                            <td class='even'><input id='hyperlink' name='hyperlink' size='30'></td></tr>

            <tr><td class='head'>Email Body</td>
                    <td class='even'><textarea id='email_body' rows='3' cols='50' name='email_body'></textarea></td></tr>
            <tr><td class='head'>SMS Body</td>
                    <td class='even'><textarea id='sms_body' rows='3' cols='50' name='sms_body'></textarea></td></tr>

            <tr><td class='head'>Is Email?</td>
                            <td class='even'><input type='checkbox' id='isemail' name='isemail' checked></td></tr>
            <tr><td class='head'>Is SMS?</td>
                            <td class='even'><input type='checkbox' id='issms' name='issms' checked></td></tr>
            <tr><td class='head'>Description</td>

                            <td class='even'><textarea id='workflow_description' name='workflow_description' rows='3' cols='50'></textarea></td></tr>
            <tr><td class='head'>Parameter Used</td>
                            <td class='even'><textarea id='parameter_used' name='parameter_used' rows='3' cols='50'></textarea></td></tr>

            <tr><td class='head'>Is Submit?</td>
                            <td class='even'><input type='checkbox' id='issubmit_node' name='issubmit_node' checked></td></tr>
            <tr><td class='head'>Is Complete?</td>
                            <td class='even'><input type='checkbox' id='iscomplete_node' name='iscomplete_node' checked></td></tr>

            <tr><td class='head'>Active</td>
                            <td class='even'><input type='checkbox' id='isactive' name='isactive' checked></td></tr>
             <tr><td>
                        <input id='workflownode_id' name='workflownode_id' title='workflownode_id'  type='hidden' value='0' readonly>
                        <input id='action' name='action' title='action'  type='hidden' value='ajaxsave' readonly>
                        </td>
             </tr>
        </table>
        <input name='save' onclick='saverecord()' type='submit' value='Save'>
        <input name='save' onclick='deleterecord()' type='button' value='Delete'>
        </form>
";
}

public function returnWorkflowXML(){
header("Content-Type: text/xml");
    echo <<< EOF
<?xml version="1.0" encoding="utf-8" ?>
<Result>   
<Workflow id="w_$this->workflownode_id">
    <workflow_id >$this->workflow_id</workflow_id>
    <workflownode_id >$this->workflownode_id</workflownode_id>
    <sequence_no>$this->sequence_no</sequence_no>
    <parentnode_id>$this->parentnode_id</parentnode_id>
    <workflowstatus_id>$this->workflowstatus_id</workflowstatus_id>
    <workflowuserchoice_id>$this->workflowuserchoice_id</workflowuserchoice_id>
    <target_groupid>$this->target_groupid</target_groupid>
    <target_uid>$this->target_uid</target_uid>
    <targetparameter_name>$this->targetparameter_name</targetparameter_name>
    <email_list>$this->email_list</email_list>
    <sms_list>$this->sms_list</sms_list>
    <workflow_procedure>$this->workflow_procedure</workflow_procedure>
    <email_body>$this->email_body</email_body>
    <sms_body>$this->sms_body</sms_body>
    <isemail>$this->isemail</isemail>
    <issms>$this->issms</issms>
    <workflow_description>$this->workflow_description</workflow_description>
    <parameter_used>$this->parameter_used</parameter_used>
    <isactive>$this->isactive</isactive>
    <workflow_sql>$this->workflow_sql</workflow_sql>
    <workflow_bypass>$this->workflow_bypass</workflow_bypass>
    <hyperlink>$this->hyperlink</hyperlink>
    <issubmit_node>$this->issubmit_node</issubmit_node>
    <iscomplete_node>$this->iscomplete_node</iscomplete_node>
</Workflow>
</Result>
EOF;
}

public function insertWorkflow(){
        global $defaultorganization_id;
        include "../class/Save_Data.inc.php";

    $save = new Save_Data();
    $arrvalue=array(
        $this->workflownode_id,
        $this->workflow_id,
        $this->sequence_no,
        $this->parentnode_id,
        $this->workflowstatus_id,
        $this->workflowuserchoice_id,
        $this->target_groupid,
        $this->target_uid,
        $this->targetparameter_name,
        $this->email_list,
        $this->sms_list,
        $this->workflow_procedure,
        $this->email_body,
        $this->sms_body,
        $this->isemail,
        $this->issms,
        $this->workflow_description,
        $this->parameter_used,
        $this->updated,$this->updatedby,
        $this->updated,$this->updatedby,
        $this->isactive,
        $defaultorganization_id,
        $this->workflow_sql,
        $this->workflow_bypass,
        $this->hyperlink,
        $this->issubmit_node,
        $this->iscomplete_node
    );
    $save->InsertRecord($this->tablename,   $this->arrInsertField,
            $arrvalue,$this->arrInsertFieldType,$this->sequence_no,"workflownode_id");

  }

  public function updateWorkflow(){
    include "../class/Save_Data.inc.php";
    $save = new Save_Data();
    $arrvalue=array(
        
        
        $this->workflow_id,
        $this->sequence_no,
        $this->parentnode_id,
        $this->workflowstatus_id,
        $this->workflowuserchoice_id,
        $this->target_groupid,
        $this->target_uid,
        $this->targetparameter_name,
        $this->email_list,
        $this->sms_list,
        $this->workflow_procedure,
        $this->email_body,
        $this->sms_body,
        $this->isemail,
        $this->issms,
        $this->workflow_description,
        $this->parameter_used,
        $this->updated,$this->updatedby,
        $this->isactive,
        $this->workflow_sql,
        $this->workflow_bypass,
        $this->hyperlink,
        $this->issubmit_node,
        $this->iscomplete_node
    );
    return $save->UpdateRecord($this->tablename, "workflownode_id",
                    $this->workflownode_id,
                    $this->arrUpdateField, $arrvalue,  $this->arrUpdateFieldType,$this->sequence_no);
                    

}

public function deleteWorkflow($workflownode_id){
    include "../class/Save_Data.inc.php";
    $save = new Save_Data();
    $this->fetchWorkflow($workflownode_id);
    return $save->DeleteRecord($this->tablename,"workflownode_id",$workflownode_id,$this->workflowstatus_id,1);

}

public function getSelectWorkflow($id,$wherestr=""){
    $sql="SELECT * FROM sim_workflow w where (isactive=1 or workflow_id=$id or workflow_id=0)
            $wherestr
            and isdeleted = 0 
            order by workflow_name";
    $query=$this->xoopsDB->query($sql);
    $result="";
    while($row=$this->xoopsDB->fetchArray($query)){

    $workflow_id=$row['workflow_id'];
    $workflow_name=$row['workflow_name'];
    $selected="";
    if($id==$workflow_id)
        $selected="SELECTED='SELECTED'";
    $result.="<option value='$workflow_id' $selected>$workflow_name</option>";
        
    }
    return $result;
}

public function getSelectParentnode($id,$workflow_id=0,$wherestr=""){

    if($workflow_id > 0)
    $wherestr .= " and workflow_id = $workflow_id ";

    //if($id > 0)
    //$wherestr .= " and workflownode_id  <> $id ";

    $sql="SELECT w.*,ws.workflowstatus_name
            FROM sim_workflownode w
            INNER JOIN sim_workflowstatus ws on w.workflowstatus_id = ws.workflowstatus_id
            where (w.isactive=1 or w.workflownode_id=$id or w.workflownode_id=0)
            $wherestr
            order by w.workflownode_id";
    $query=$this->xoopsDB->query($sql);
    $result="";
    $i=0;
    while($row=$this->xoopsDB->fetchArray($query)){
    $i++;
    $workflownode_id=$row['workflownode_id'];
    $sequence_no=$row['sequence_no'];
    $workflowstatus_name=$row['workflowstatus_name'];
    $selected="";

    if($id==$workflownode_id)
        $selected="SELECTED='SELECTED'";

    $result.="<option value='$workflownode_id' $selected>$sequence_no - $workflowstatus_name</option>";

    }

    //if($i == 0)
    $result.="<option value='0' SELECTED='SELECTED'>Null</option>";

    return $result;
}

public function getSelectStatus($id,$wherestr=""){
    $sql="SELECT * FROM sim_workflowstatus w where (isactive=1 or workflowstatus_id=$id or workflowstatus_id=0)
            $wherestr
            order by workflowstatus_name";
    $query=$this->xoopsDB->query($sql);
    $result="";
    while($row=$this->xoopsDB->fetchArray($query)){

    $workflowstatus_id=$row['workflowstatus_id'];
    $workflowstatus_name=$row['workflowstatus_name'];
    $selected="";
    if($id==$workflowstatus_id)
        $selected="SELECTED='SELECTED'";
    $result.="<option value='$workflowstatus_id' $selected>$workflowstatus_name</option>";

    }
    return $result;
}

public function getSelectUserchoice($id,$wherestr=""){
    $sql="SELECT * FROM sim_workflowuserchoice w where (isactive=1 or workflowuserchoice_id=$id or workflowuserchoice_id=0)
            $wherestr
            order by workflowuserchoice_name";
    $query=$this->xoopsDB->query($sql);
    $result="";
    while($row=$this->xoopsDB->fetchArray($query)){

    $workflowuserchoice_id=$row['workflowuserchoice_id'];
    $workflowuserchoice_name=$row['workflowuserchoice_name'];
    $selected="";
    if($id==$workflowuserchoice_id)
        $selected="SELECTED='SELECTED'";
    $result.="<option value='$workflowuserchoice_id' $selected>$workflowuserchoice_name</option>";

    }
    return $result;
}

public function getSelectUsergroup($id,$wherestr=""){
    
    if($id >0)
    $wherestr .= "";
    
    $sql="SELECT * FROM sim_groups w where 1
            $wherestr
            order by name";
    $query=$this->xoopsDB->query($sql);
    $result="";
    while($row=$this->xoopsDB->fetchArray($query)){

    $groupid=$row['groupid'];
    $name=$row['name'];
    $selected="";
    if($id==$groupid)
        $selected="SELECTED='SELECTED'";
    $result.="<option value='$groupid' $selected>$name</option>";

    }

    $result.="<option value='0' $selected></option>";

    return $result;
}

public function getSelectUser($id,$wherestr=""){
    $sql="SELECT * FROM sim_simedu_employee w where (isactive=1 or employee_id=$id or employee_id=0)
            $wherestr
            order by employee_name";
    $query=$this->xoopsDB->query($sql);
    $result="";
    while($row=$this->xoopsDB->fetchArray($query)){

    $employee_id=$row['employee_id'];
    $employee_name=$row['employee_name'];
    $selected="";
    if($id==$employee_id)
        $selected="SELECTED='SELECTED'";
    $result.="<option value='$employee_id' $selected>$employee_name</option>";

    }
    return $result;
}

} // end of ClassWorkflow
?>

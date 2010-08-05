<?php

include_once "system.php";
include_once '../class/Workflow.inc.php';
include_once "../class/nitobi.xml.php";
$workflow = new Workflow();
$action=$_REQUEST['action'];
$workflow->updated=date("Y-m-d H:i:s",time());
$workflow->updatedby=$xoopsUser->getVar("uid");
$xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');

switch($action){
case "ajaxfetch":
    if($workflow->fetchWorkflow($_REQUEST['workflownode_id'] ) ){
        $workflow->returnWorkflowXML();
    }
    else
        echo "<xml><errortext>Cannot retrieve workflow_id:".$_REQUEST['workflow_id']."</errortext></xml>";

break;
case "ajaxgetmoduleworkflows":
    $workflow->workflow_id=$_REQUEST['workflow_id'];
  
    echo $workflow->showParentWorkflowsTree($workflow->workflow_id);
    break;
case "ajaxdelete":
    $workflow->workflownode_id=$_REQUEST['workflownode_id'];
    if(!$workflow->deleteWorkflow($workflow->workflownode_id))
            echo "Warning! Cannot delete this workflow due to unknown reason.";
    break;
case "ajaxsave":

    $workflow->workflownode_id=$_POST['workflownode_id'];
    $workflow->workflow_id=$_POST['workflow_id'];
    $workflow->sequence_no=$_POST['sequence_no'];
    $workflow->parentnode_id=$_POST['parentnode_id'];
    $workflow->workflowstatus_id=$_POST['workflowstatus_id'];
    $workflow->workflowuserchoice_id=$_POST['workflowuserchoice_id'];
    $workflow->target_groupid=$_POST['target_groupid'];
    $workflow->target_uid=$_POST['target_uid'];
    $workflow->targetparameter_name=$_POST['targetparameter_name'];
    $workflow->email_list=$_POST['email_list'];
    $workflow->sms_list=$_POST['sms_list'];
    $workflow->workflow_procedure=$_POST['workflow_procedure'];
    $workflow->email_body=$_POST['email_body'];
    $workflow->sms_body=$_POST['sms_body'];
    $workflow->workflow_description=$_POST['workflow_description'];
    $workflow->parameter_used=$_POST['parameter_used'];

    $workflow->workflow_sql=$_POST['workflow_sql'];
    $workflow->workflow_bypass=$_POST['workflow_bypass'];
    $workflow->hyperlink=$_POST['hyperlink'];
                           
    $workflow->workflow_sql=$_POST['workflow_sql'];
    $workflow->workflow_bypass=$_POST['workflow_bypass'];
    $workflow->hyperlink=$_POST['hyperlink'];
    $workflow->issubmit_node=$_POST['issubmit_node'];
    $workflow->iscomplete_node=$_POST['iscomplete_node'];

    if($_POST['isemail'] == "on")
    $workflow->isemail=1;
    else
    $workflow->isemail=0;

    if($_POST['issms'] == "on")
    $workflow->issms=1;
    else
    $workflow->issms=0;

    if($_POST['isactive'] == "on")
    $workflow->isactive=1;
    else
    $workflow->isactive=0;

    if($_POST['iscomplete_node'] == "on")
    $workflow->iscomplete_node=1;
    else
    $workflow->iscomplete_node=0;

    if($_POST['issubmit_node'] == "on")
    $workflow->issubmit_node=1;
    else
    $workflow->issubmit_node=0;

    if( $workflow->workflownode_id>0)
            $workflow->updateWorkflow();
    else
            $workflow->insertWorkflow();
break;

case "ajaxselectworkflow":
        //$workflow->mid=$_GET['mid'];
        $workflow->workflow_id=$_GET['workflow_id'];
        if($workflow->workflow_id=="")$workflow->workflow_id=0;
        echo $workflow->getSelectWorkflow($workflow->workflow_id);
    break;
case "ajaxselectparentnode":
        $workflow->workflow_id=$_GET['workflow_id'];
        $workflow->parentnode_id=$_GET['parentnode_id'];
        if($workflow->parentnode_id=="")$workflow->parentnode_id=0;
        echo $workflow->getSelectParentnode($workflow->parentnode_id,$workflow->workflow_id);
    break;
case "ajaxselectworkflowstatus":
        //$workflowstatus->mid=$_GET['mid'];
        $workflow->workflowstatus_id=$_GET['workflowstatus_id'];
        if($workflow->workflowstatus_id=="")$workflow->workflowstatus_id=0;
        echo $workflow->getSelectStatus($workflow->workflowstatus_id);
    break;
case "ajaxselectworkflowuserchoice":
        //$workflowuserchoice->mid=$_GET['mid'];
        $workflow->workflowuserchoice_id=$_GET['workflowuserchoice_id'];
        if($workflow->workflowuserchoice_id=="")$workflow->workflowuserchoice_id=0;
        echo $workflow->getSelectUserchoice($workflow->workflowuserchoice_id);
    break;
case "ajaxselectworkflowusergroup":
        //$workflowuserchoice->mid=$_GET['mid'];
        $workflow->groupid=$_GET['groupid'];
        if($workflow->groupid=="")$workflow->groupid=0;
        echo $workflow->getSelectUsergroup($workflow->groupid);
    break;
case "ajaxselectworkflowuser":
        //$workflowuserchoice->mid=$_GET['mid'];
        $workflow->employee_id=$_GET['employee_id'];
        if($workflow->employee_id=="")$workflow->employee_id=0;
        echo $workflow->getSelectUser($workflow->employee_id);
    break;
default:
    include "../class/SelectCtrl.inc.php";
    $ctrl  = new SelectCtrl();
    $xoTheme->addStylesheet("$url/modules/simantz/include/workflow.css");
        $xoTheme->addStylesheet("$url/modules/simantz/include/popup.css");
        $xoTheme->addScript("$url/modules/simantz/include/popup.js");

    


    if($_GET['findworkflow_id']>=1)
        $findworkflow_id=$_GET['findworkflow_id'];
    else
        $findworkflow_id=0;

    //$workflow->modulectrl=$ctrl->getSelectModule($findmodule_id, "Y","findmodule_id","findmodule_id");
    $workflow->showSearchForm();
    $workflowlist=$workflow->showParentWorkflowsTree($findworkflow_id);
    $formname=$workflow->getInputForm($findworkflow_id);

    if($havewriteperm==1)
    $permctrl=" rowinsertenabled=\"true\"      rowdeleteenabled=\"true\"      toolbarenabled=\"true\"      ";
    else
    $permctrl=" rowinsertenabled=\"false\"   autosaveenabled=\"false\"   rowdeleteenabled=\"false\"      toolbarenabled=\"false\"      ";


    echo <<< EOF

 <!-- Start : This is for nitobi -->

<link rel="stylesheet" href="../include/nitobi/nitobi.grid/nitobi.grid.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="../include/nitobi/nitobi.calendar/nitobi.calendar.css" />
<script type="text/javascript" src="../include/nitobi/nitobi.toolkit.js"></script>
<script type="text/javascript" src="../include/nitobi/nitobi.grid/nitobi.grid.js"></script>
<script type="text/javascript" src="../include/nitobi/nitobi.calendar/nitobi.calendar.js"></script>
<script type="text/javascript" src="../include/firefox3_6fix.js"></script>
  <script language="javascript" type="text/javascript">
    jQuery(document).ready((function (){nitobi.loadComponent('DataboundGrid');}));

     function init(){}

     function checkDate(eventArgs){

        row=eventArgs.getCell().getRow();
        col=eventArgs.getCell().getColumn();
        var value = grid.getCellObject(row,col).getValue();

     }
     function search(){

        var grid = nitobi.getGrid("DataboundGrid");
        var searchworkflow_code=document.getElementById("searchworkflow_code").value;
        var searchworkflow_name=document.getElementById("searchworkflow_name").value;
        var searchisactive=document.getElementById("searchisactive").value;

        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */
        if(document.getElementById("searchisdeleted"))
        var searchisdeleted=document.getElementById("searchisdeleted").checked;

        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('searchworkflow_code',searchworkflow_code);
	grid.getDataSource().setGetHandlerParameter('searchworkflow_name',searchworkflow_name);
	grid.getDataSource().setGetHandlerParameter('searchisactive',searchisactive);
	grid.getDataSource().setGetHandlerParameter('searchisdeleted',searchisdeleted);

        //reload grid data
	grid.dataBind();
    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
        //      var myAjaxRequest = new nitobi.ajax.HttpRequest();
        //      myAjaxRequest.handler = 'getMaxID.php?idname=workflow_id&tablename=sim_workflow';
        //      myAjaxRequest.async = false;
        //      myAjaxRequest.get();
        //      myResultKey = myAjaxRequest.httpObj.responseText;
        //      myResultKey.replace(/s/g, '');
        //      myResultKey = parseInt(myResultKey) + 1;
        //      return myResultKey.toString();
        return 0;
    }

    //input validation
    function validateSave(){
        jQuery('#msgbox').fadeTo('veryfast', 0, function() {});
        if(confirm("Save record?"))
            return true;
        else
            return false;
    }

    //Call event after save complete
    function savedone(eventArgs){
        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();
        if (!errorMessage) {
           document.getElementById('msgbox').innerHTML="Record save successfully<br/>"+
           document.getElementById('msgbox').innerHTML;
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
           return true;
        }
    }

    //if save_data have error, trigger this function
    function showError(){
        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();
        if (errorMessage) {
             document.getElementById('msgbox').innerHTML="<b style=\"color:red\">"+errorMessage+"</b><br/>"+
             document.getElementById('msgbox').innerHTML;;
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
       jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }

    //if table load completely trigger this function
    function dataready(){
    }

    //if user click particular column trigger this function
    function clickrecord(eventArgs){

                    addNew();
                    jQuery('#cellvalue').fadeTo('veryfast', 0, function() {
                    var grid = eventArgs.getSource();
                    row=eventArgs.getCell().getRow();
                    col=eventArgs.getCell().getColumn();
                    var value = grid.getCellObject(row,col).getValue();

                    var workflow_id = grid.getCellObject(row,7).getValue();

                    refreshworkflowlist(workflow_id);
                    
                    document.getElementById('workflow_id').value=workflow_id;
                    refreshparentnodelist(0);
                    reloadWorkflows();
                    document.getElementById('cellvalue').innerHTML="Value: "+value;

                });
                    jQuery('#cellvalue').fadeTo('fast', 1, function() {});
    }

</script>

<!-- Start : This is for nitobi -->
    
<div id='blanket' style='display:none;'></div>
<div id='popUpDiv' style='display:none;verticle-align:center'>
      
     <div id='popupmessage' style='text-align:center'></div>
     <div id='progressimage' style='text-align:center'><img src='../images/ajax_indicator_01.gif'></div>
</div>
    

    <script>
        function reloadWorkflows(){
            
            var workflow_id = document.getElementById("workflow_id").value;
    
            var data="action=ajaxgetmoduleworkflows&workflow_id="+workflow_id;
            $.ajax({
                 url: "workflow.php",type: "GET",data: data,cache: false,
                     success: function (xml) {
                  //alert(xml)
                         document.getElementById("treeModuleWorkflows").innerHTML=xml;
                         }
                    });
            
    
        }
        function addChildren(workflow_id,workflownode_id){
            document.getElementById("workflownode_id").value = 0;
            document.getElementById("workflow_id").value = workflow_id;
            document.getElementById("sequence_no").value = 10;
            document.getElementById("parentnode_id").value = workflownode_id;
            document.getElementById("workflowstatus_id").value = 0;
            document.getElementById("workflowuserchoice_id").value = 0;
            document.getElementById("target_groupid").value = 0;
            document.getElementById("target_uid").value = 0;
            document.getElementById("targetparameter_name").value = "";
            document.getElementById("email_list").value = "";
            document.getElementById("sms_list").value = "";
            document.getElementById("workflow_procedure").value = "";
            document.getElementById("email_body").value = "";
            document.getElementById("sms_body").value = "";
            document.getElementById("isemail").checked = true;
            document.getElementById("issms").checked = true;
            document.getElementById("workflow_description").value = "";
            document.getElementById("parameter_used").value = "";
            document.getElementById("isactive").checked=true;
            document.getElementById("issubmit_node").checked=true;
            document.getElementById("iscomplete_node").checked=true;
            document.getElementById("workflow_sql").value = "";
            document.getElementById("workflow_bypass").value = "";
            document.getElementById("hyperlink").value = "";

        }
    
        function saverecord(){
                document.getElementById("popupmessage").innerHTML="Saving data...";
                popup('popUpDiv');
                var workflownode_id=document.getElementById("workflownode_id").value;
                var workflow_id=document.getElementById("workflow_id").value;
                var sequence_no=document.getElementById("sequence_no").value;                
                var parentnode_id=document.getElementById("parentnode_id").value;
                var workflowstatus_id=document.getElementById("workflowstatus_id").value;
                var workflowuserchoice_id=document.getElementById("workflowuserchoice_id").value;
                var target_groupid=document.getElementById("target_groupid").value;
                var target_uid=document.getElementById("target_uid").value;
                var targetparameter_name=document.getElementById("targetparameter_name").value;
                var email_list=document.getElementById("email_list").value;
                var sms_list=document.getElementById("sms_list").value;
                var workflow_procedure=document.getElementById("workflow_procedure").value;
                var email_body=document.getElementById("email_body").value;
                var sms_body=document.getElementById("sms_body").value;
                //var isemail=document.getElementById("isemail").value;
                //var issms=document.getElementById("issms").value;
                var workflow_description=document.getElementById("workflow_description").value;
                var parameter_used=document.getElementById("parameter_used").value;
//                    var workflow_sql=document.getElementById("workflow_sql").value;
//                    var workflow_bypass=document.getElementById("workflow_bypass").value;
//                    var hyperlink=document.getElementById("hyperlink").value;




                var isemail=0;
                if(document.getElementById("isemail").checked==true)
                isemail=1;
                var issms=0;
                if(document.getElementById("issms").checked==true)
                issms=1;
                var isactive=0;
                if(document.getElementById("isactive").checked==true)
                isactive=1;

            var data="action="+"ajaxsave"+
                    "&workflownode_id="+workflownode_id+
                    "&workflow_id="+workflow_id+
                    "&sequence_no="+sequence_no+
                    "&parentnode_id="+parentnode_id+
                    "&workflowstatus_id="+workflowstatus_id+
                    "&workflowuserchoice_id="+workflowuserchoice_id+
                    "&target_groupid="+target_groupid+
                    "&target_uid="+target_uid+
                    "&targetparameter_name="+targetparameter_name+
                    "&email_list="+email_list+
                    "&sms_list="+sms_list+
                    "&email_list="+email_list+
                    "&workflow_procedure="+workflow_procedure+
                    "&email_body="+email_body+
                    "&sms_body="+sms_body+
                    "&isemail="+isemail+
                    "&sms_body="+sms_body+
                    "&issms="+issms+
                    "&workflow_description="+workflow_description+
                    "&parameter_used="+parameter_used+

                    "&isactive="+isactive;

            var data = $("#idWorkflowForm").serialize();
    
                    
            $.ajax({
                 url: "workflow.php",type: "POST",data: data,cache: false,
                     success: function (xml) {
                    //alert(xml)
                     document.getElementById("popupmessage").innerHTML="Saving data successfully, reload workflow...";

                    showWorkflowsForm(workflownode_id);reloadWorkflows();
                    document.getElementById("popupmessage").innerHTML="Completed!";
                    popup('popUpDiv');
                }});
            
               
      

        }

        function refreshparentworkflowslist(mid,workflow_id){

           // $("#parentworkflows_id").html("");
            var data="action=ajaxselectworkflows&mid="+mid+"&workflow_id="+workflow_id;
            $.ajax({
                 url: "workflow.php",type: "GET",data: data,cache: false,
                     success: function (xml) {
                    
                      $("#parentworkflows_id").html(xml);
                    }
            });

    }

        function refreshworkflowlist(workflow_id){

           // $("#workflow_id").html("");
            var data="action=ajaxselectworkflow&workflow_id="+workflow_id;
            $.ajax({
                 url: "workflow.php",type: "GET",data: data,cache: false,
                     success: function (xml) {
                      $("#workflow_id").html(xml);
                    }
            });

        }

        function refreshparentnodelist(parentnode_id){

        var workflow_id = document.getElementById('workflow_id').value;
       // $("#parentnode_id").html("");
        var data="action=ajaxselectparentnode&parentnode_id="+parentnode_id+"&workflow_id="+workflow_id;
        $.ajax({
             url: "workflow.php",type: "GET",data: data,cache: false,
                 success: function (xml) {

                  $("#parentnode_id").html(xml);
                }
        });

        }

        function refreshstatuslist(workflowstatus_id){

           // $("#workflowstatus_id").html("");
            var data="action=ajaxselectworkflowstatus&workflowstatus_id="+workflowstatus_id;
            $.ajax({
                 url: "workflow.php",type: "GET",data: data,cache: false,
                     success: function (xml) {

                      $("#workflowstatus_id").html(xml);
                    }
            });

        }

        function refreshuserchoicelist(workflowuserchoice_id){

           // $("#workflowuserchoice_id").html("");
            var data="action=ajaxselectworkflowuserchoice&workflowuserchoice_id="+workflowuserchoice_id;
            $.ajax({
                 url: "workflow.php",type: "GET",data: data,cache: false,
                     success: function (xml) {

                      $("#workflowuserchoice_id").html(xml);
                    }
            });

        }

        function refreshusergrouplist(groupid){

           // $("#target_groupid").html("");
            var data="action=ajaxselectworkflowusergroup&groupid="+groupid;
            $.ajax({
                 url: "workflow.php",type: "GET",data: data,cache: false,
                     success: function (xml) {

                      $("#target_groupid").html(xml);
                    }
            });

        }

        function refreshuserlist(employee_id){

           // $("#target_uid").html("");
            var data="action=ajaxselectworkflowuser&employee_id="+employee_id;
            $.ajax({
                 url: "workflow.php",type: "GET",data: data,cache: false,
                     success: function (xml) {

                      $("#target_uid").html(xml);
                    }
            });

        }


        function showWorkflowsForm(workflownode_id){
            var data="action=ajaxfetch&workflownode_id="+workflownode_id;
            $.ajax({
                 url: "workflow.php",type: "GET",data: data,cache: false,
                     success: function (xml) {
                             $(xml).find("Workflow").each(function()
                                {
                            
                                    //var currentwid = $(this).attr("id");

                                    var workflownode_id=$(this).find("workflownode_id").text();
                                    var workflow_id=$(this).find("workflow_id").text();
                                    var sequence_no=$(this).find("sequence_no").text();
                                    var parentnode_id=$(this).find("parentnode_id").text();
                                    var workflowstatus_id=$(this).find("workflowstatus_id").text();
                                    var workflowuserchoice_id=$(this).find("workflowuserchoice_id").text();
                                    var target_groupid=$(this).find("target_groupid").text();
                                    var target_uid=$(this).find("target_uid").text();
                                    var targetparameter_name=$(this).find("targetparameter_name").text();
                                    var email_list=$(this).find("email_list").text();
                                    var sms_list=$(this).find("sms_list").text();
                                    var workflow_procedure=$(this).find("workflow_procedure").text();
                                    var email_body=$(this).find("email_body").text();
                                    var sms_body=$(this).find("sms_body").text();
                                    var isemail=$(this).find("isemail").text();
                                    var issms=$(this).find("issms").text();
                                    var workflow_description=$(this).find("workflow_description").text();
                                    var parameter_used=$(this).find("parameter_used").text();
                                    var isactive=$(this).find("isactive").text();
                                    var workflow_sql=$(this).find("workflow_sql").text();
                                    var workflow_bypass=$(this).find("workflow_bypass").text();
                                    var hyperlink=$(this).find("hyperlink").text();
                                    var issubmit_node=$(this).find("issubmit_node").text();
                                    var iscomplete_node=$(this).find("iscomplete_node").text();


    
                                    document.getElementById("workflownode_id").value = workflownode_id;
                                    document.getElementById("workflow_id").value = workflow_id;
                                    document.getElementById("sequence_no").value = sequence_no;
                                    document.getElementById("parentnode_id").value = parentnode_id;
                                    document.getElementById("workflowstatus_id").value = workflowstatus_id;
                                    document.getElementById("workflowuserchoice_id").value = workflowuserchoice_id;
                                    document.getElementById("target_groupid").value = target_groupid;
                                    document.getElementById("target_uid").value = target_uid;
                                    document.getElementById("targetparameter_name").value = targetparameter_name;
                                    document.getElementById("email_list").value = email_list;
                                    document.getElementById("sms_list").value = sms_list;
                                    document.getElementById("workflow_procedure").value = workflow_procedure;
                                    document.getElementById("email_body").value = email_body;
                                    document.getElementById("sms_body").value = sms_body;
                                    //document.getElementById("isemail").value = isemail;
                                    //document.getElementById("issms").value = issms;
                                    document.getElementById("workflow_description").value = workflow_description;
                                    document.getElementById("parameter_used").value = parameter_used;
                                        document.getElementById("workflow_sql").value = workflow_sql;
                                        document.getElementById("workflow_bypass").value = workflow_bypass;
                                        document.getElementById("hyperlink").value = hyperlink;

//alert(isactive);
                                    if(isactive==1)
                                        document.getElementById("isactive").checked=true;
                                    else
                                        document.getElementById("isactive").checked=false;

                                    if(isemail==1)
                                        document.getElementById("isemail").checked=true;
                                    else
                                        document.getElementById("isemail").checked=false;
    
                                    if(issms==1)
                                        document.getElementById("issms").checked=true;
                                    else
                                        document.getElementById("issms").checked=false;

                                    if(issubmit_node==1)
                                        document.getElementById("issubmit_node").checked=true;
                                    else
                                        document.getElementById("issms").checked=false;

                                    if(iscomplete_node==1)
                                        document.getElementById("iscomplete_node").checked=true;
                                    else
                                        document.getElementById("iscomplete_node").checked=false;

                                });//close each
                              }//close success
                }); //close $.ajax
        }
        function deleterecord(){
          if(confirm('Delete this workflow?')){
           var wid=document.getElementById("workflownode_id").value;
            var data="action=ajaxdelete&workflownode_id="+wid;
            $.ajax({
                 url: "workflow.php",type: "POST",data: data,cache: false,
                     success: function (xml) {
                        alert("Record Delete.");
                        reloadWorkflows();
                    }});
          }
        }

        function addNew(){

                    document.getElementById("workflownode_id").value = 0;
                    document.getElementById("workflow_id").value = 0;
                    document.getElementById("sequence_no").value = 10;
                    document.getElementById("parentnode_id").value = 0;
                    document.getElementById("workflowstatus_id").value = 0;
                    document.getElementById("workflowuserchoice_id").value = 0;
                    document.getElementById("target_groupid").value = 0;
                    document.getElementById("target_uid").value = 0;
                    document.getElementById("targetparameter_name").value = "";
                    document.getElementById("email_list").value = "";
                    document.getElementById("sms_list").value = "";
                    document.getElementById("workflow_procedure").value = "";
                    document.getElementById("email_body").value = "";
                    document.getElementById("sms_body").value = "";
                    document.getElementById("isemail").checked = true;
                    document.getElementById("issms").checked = true;
                    document.getElementById("workflow_description").value = "";
                    document.getElementById("parameter_used").value = "";
                    document.getElementById("isactive").checked=true;
                    
                    document.getElementById("issubmit_node").checked=true;
                    document.getElementById("iscomplete_node").checked=true;
                    document.getElementById("workflow_sql").value = "";
                    document.getElementById("workflow_bypass").value = "";
                    document.getElementById("hyperlink").value = "";



    }
     </script>

    <table border=1px>
    <tr><TH colspan='2'>Add/Edit Workflow Node</TH></tr>
    <tr>
    <td width="50%" style='vertical-align:top'><div id="treeModuleWorkflows">$workflowlist</div></td>
    <td width="50%" style='vertical-align:top'><div id="formModuleWorkflows">$formname</div></td>
    </tr></table>


EOF;

    xoops_cp_footer();
break;
}

?>

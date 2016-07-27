<?php
include_once "system.php";
//include_once ('../../mainfile.php');
//include_once '../simantz/class/Organization.inc.php';
//include_once '../simantz/class/Log.inc.php';
include_once 'class/ApprovalNewMobile.inc.php';
include_once "../simantz/class/WorkflowAPI.inc.php";

$userbasicmobileweb="false";
if(strpos( $_SERVER['HTTP_USER_AGENT'], "BlackBerry")>=0)
 $userbasicmobileweb="true";

 
echo <<< EOF
    <script type="text/javascript">

        var init_height = screen.height;
        var init_width = screen.width;

        if(init_height > 500 && init_width > 500)
        self.location = "approvallist.php";
        else if($userbasicmobileweb)
        self.location = "basicmobile.php";
        
    </script>
EOF;

$approvallist = new Approvallist();
$workflowapi = new WorkflowAPI();

$action = $_REQUEST['action'];
$day = $_REQUEST['day'];
//$app_para = date("YmdHis", time()) ;
switch ($action){

    //compulsory action for Workflow API
    case "next_node":

        $workflowstatus_id = $_REQUEST['status_node'];
        $workflowtransaction_id = $_POST['workflowtransaction_id'];
        $workflowtransaction_feedback = $_REQUEST['workflowtransaction_feedback'];
        $approvallist->window_workflow = $_REQUEST['window_workflow'];
        $tablename = $_REQUEST['tablename'];
        $primarykey_name = $_REQUEST['primarykey_name'];
        $approvallist->primarykey_value = $_REQUEST['primarykey_value'];
        $approvallist->person_id = $_REQUEST['person_id'];
        $approvallist->parameter_array = $approvallist->defineWorkflowParameter();
        if($approvallist->primarykey_value > 0){

            $nextstatus_name = $workflowapi->getStatusName($workflowstatus_id);

            $workflowReturn = $workflowapi->updateWorkflowTransaction(
                                           "$workflowtransaction_id",
                                            $approvallist->window_workflow,
                                            "$nextstatus_name",
                                            $tablename,
                                            $primarykey_name,
                                            $approvallist->primarykey_value,
                                            $approvallist->parameter_array,
                                            $approvallist->person_id,
                                            "",
                                            $workflowtransaction_feedback
                                            );

            if(!$workflowReturn){
                $msg = "<font style='color:red;font-weight:bold'>Operation aborted. Please check workflow API's settings.</font>";
                //redirect_header("leave.php?action=edit&leave_id=$o->leave_id",$pausetime,"$msg");
                ///$arr = array("msg"=>$msg,"status"=>2);
                //echo json_encode($arr);
            }else{
                $msg = "<font style='color:black;font-weight:bold'>Record $nextstatus_name successfully.</font>";
                //redirect_header("leave.php?action=edit&leave_id=$o->leave_id",$pausetime,"$msg");
                //$arr = array("msg"=>$msg,"status"=>1);
                //echo json_encode($arr);

            }

        }

    break;
    //end


}
$approvallist->parameter_array = $approvallist->defineWorkflowParameter();
if(!empty($xoopsUser )){
    $approvallist->createdby=$xoopsUser->getVar('uid');

    if($approvallist->createdby == 0){

        $url = XOOPS_URL ."/approval/newmobile.php#checkPage";
echo <<< EOF
       <script type="text/javascript">
       self.location = "$url";
       </script>
EOF;

    }else{
        $approvalList = "";
    }

}else{
$url = XOOPS_URL ."/approval/newmobile.php#checkPage";
echo <<< EOF
   <script type="text/javascript">
   self.location = "$url";
   </script>
EOF;
}

?>
<!--
   Copyright (c) 2008 Journyx, Inc.

   Permission is hereby granted, free of charge, to any person obtaining
   a copy of this software and associated documentation files (the
   "Software"), to deal in the Software without restriction, including
   without limitation the rights to use, copy, modify, merge, publish,
   distribute, sublicense, and/or sell copies of the Software, and to
   permit persons to whom the Software is furnished to do so, subject to
   the following conditions:

   The above copyright notice and this permission notice shall be
   included in all copies or substantial portions of the Software.

   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
   EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
   MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
   NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
   LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
   OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
   WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

   The software may not be used to develop, enable or integrate with
   time, expense, or mileage tracking software of any kind,  except when
   such software is provided by Journyx or its designated licensees.
-->

<html>
<head>
	<title>HIUMEN Approval</title>

	<meta name="viewport" content="user-scalable=no, width=device-width">

	<link rel="stylesheet" type="text/css" charset="utf-8" href="../simantz/mobile/css/jPint.css">
	<link rel="stylesheet" type="text/css" charset="utf-8" href="../simantz/mobile/css/scal.css">

	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/prototype/prototype.js"></script>
	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/jPint.js"></script>
	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/scal/scal.js"></script>
        <script src="../simantz/include/validatetext.js" type="text/javascript"></script>


        <script type="text/javascript">
            function showHistory(total_day){
            document.getElementById('idHistory'+total_day).submit();
            }
            function enterPage(){
            document.getElementById('idEnterPage').submit();
            }
        </script>
</head>

<body id="jPint">
    
<div class="jPintPageSet">

	<div id="mainMenuPage" class="jPintPage IconMenu">
                <div class="txtWelcome">Welcome to HIUMEN Mobile</div>
                
		<ul><li><a onclick="enterPage()" style="cursor:pointer"><img src="../simantz/mobile/images/NavEnter.png"></a></li></ul>
                <form id='idEnterPage' method='post' action='newmobile.php#approvalList'></form>
                <div class="imgLogout"><a href="logout.php" title="Logout"><img src="../simantz/mobile/images/NavLogout.png"></a></div>
	</div>

	<div id="checkPage" class="jPintPage IconMenu" >
               <h1>Welcome To HIUMEN System
			<div class="EditModeInvisible">
				<a class="BackButton">Back</a>
			</div>
		</h1>
                <br/><br/>
                <div class="txtLogin">Please Login</div><br/>
                <div class="frmLoginMobile">
                    <form action="../user.php" method="post">
                    Username:
                    <input type="text" name="uname" maxlength="25" size="21" value=""/>
                    <br/>
                    <br/>
                    Password:
                    <input type="password" name="pass" maxlength="32" size="21"/>
                    <!--<br/>
                    <br/>
                    <input type="checkbox" name="rememberme" value="On" checked=""/>
                    Remember me-->
                    <br/>
                    <br/>
                    <input type="hidden" name="op" value="login"/>
                    <input type="hidden" name="login_type" value="mobile"/>
                    <input type="hidden" name="xoops_redirect" value="/approval/newmobile.php#approvalList"/>
                    <input type="submit" value="User Login"/>
                    </form>
                </div>

	</div>



	<!--The WebNotes sample seen here was written by Matt East 29 Jan. 2008 -->

	<div id="approvalList" class="jPintPage HasTitle EdgedList EditModeOff Notes" >
		<!-- Home Level Begin -->
		<h1>Approval List
			<div class="">
				<a class="BackButton">Back</a>
				<a href="#historyLeave" class="RightButton">History</a>
			</div>

			</h1>
			<ul class="">
                                <?php $listDetails = $approvallist->getApprovalList();?>
			</ul>
		<!-- Home Level End -->
	</div>

        <?php echo $listDetails;?>

        <!-- for history leave -->
        <?php
            if($day > 0){
            $approvallist->getHistoryLeave($day);
            }
        ?>

	<!--The WebNotes sample seen here was written by Matt East 29 Jan. 2008 -->

	<div id="historyLeave" class="jPintPage HasTitle EdgedList EditModeOff Notes" >
		<!-- Home Level Begin -->
		<h1>History List
			<div class="">
				<a class="BackButton">Back</a>

			</div>

			</h1>
			<ul class="">
                                <?php $approvallist->getHistoryList();?>
			</ul>
		<!-- Home Level End -->
	</div>



	<div id="enter" class="jPintPage HasTitle EdgedList Notes">
		<!-- Enter WebNotes Page Begin -->
			<h1>Enter
			<a class="BackButton">Cancel</a>
			<a class="RightButton ">Save</a>
			</h1>
			<ul>
				<textarea name="wnBody" cols="45" rows="30"></textarea>
			</ul>
		<!-- Enter WebNotes Page End -->
	</div>



</div>
</body>

</html>

<?php

//    switch ($action){
//    case "history":
//            $day = $_REQUEST['day'];
//        $url = XOOPS_URL ."/mobile/newmobile.php#historyLeaveDetail";
//echo <<< EOF
//       <script type="text/javascript">
//       self.location = "$url";
//       </script>
//EOF;
//    break;
//    }
?>

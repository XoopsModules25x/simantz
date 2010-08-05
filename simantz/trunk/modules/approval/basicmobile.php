<?php
include_once "system.php";
//include_once ('../../mainfile.php');
//include_once '../simantz/class/Organization.inc.php';
//include_once '../simantz/class/Log.inc.php';
include_once 'class/ApprovalBasicMobile.inc.php';
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
        
        //if($userbasicmobileweb)
        //self.location = "basicmobile.php";
        //else
        //self.location = "newmobile.php";        
    </script>
EOF;

$approvallist = new Approvallist();
$workflowapi = new WorkflowAPI();
$approvallist->parameter_array = $approvallist->defineWorkflowParameter();

$action = $_REQUEST['action'];
$day = $_REQUEST['day'];

if(!$xoopsUser){
echo <<< EOF
	<div id="checkPage" class="jPintPage IconMenu" >
               <h1>Welcome To SimEDU System
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
                    <input type="hidden" name="xoops_redirect" value="/approval/basicmobile.php#approvalList"/>
                    <input type="submit" value="User Login"/>
                    </form>
                </div>

	</div>
EOF;
die;
}
else
switch ($action){

    //compulsory action for Workflow API
    case "next_node":

        $workflowstatus_id = $_REQUEST['status_node'];
        $workflowtransaction_feedback = $_REQUEST['workflowtransaction_feedback'];
        $window_workflow = $_REQUEST['window_workflow'];
        $tablename = $_REQUEST['tablename'];
        $primarykey_name = $_REQUEST['primarykey_name'];
        $primarykey_value = $_REQUEST['primarykey_value'];
        $person_id = $_REQUEST['person_id'];
        
        if($primarykey_value > 0){




            $nextstatus_name = $workflowapi->getStatusName($workflowstatus_id);

            $workflowReturn = $workflowapi->insertWorkflowTransaction(
                                            $window_workflow,
                                            "$nextstatus_name",
                                            $tablename,
                                            $primarykey_name,
                                            $primarykey_value,
                                            $approvallist->parameter_array,
                                            $person_id,
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
echo <<< EOF
<title>SimEDU Approval</title>

	<meta name="viewport" content="user-scalable=no, width=device-width">

	<link rel="stylesheet" type="text/css" charset="utf-8" href="../simantz/mobile/css/jPint.css">
	<link rel="stylesheet" type="text/css" charset="utf-8" href="../simantz/mobile/css/scal.css">

	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/prototype/prototype.js"></script>
	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/jPint.js"></script>
	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/scal/scal.js"></script>
        <script src="../simantz/include/validatetext.js" type="text/javascript"></script>

	<div id="approvalList" class="jPintPage HasTitle EdgedList EditModeOff Notes" >
		<!-- Home Level Begin -->
		<h1>Approval List
			<div class="">
							<a href="basicmobile.php?action=showhistorypage" class="RightButton">History</a>
			</div>

			</h1>
			<ul class="">
EOF;

echo $listDetails = $approvallist->getApprovalList();
echo <<< EOF
			</ul>
		<!-- Home Level End -->
	</div>
EOF;

    break;
case "history":

 $approvallist->getHistory($_GET['day']);
 echo <<< EOF

<title>SimEDU Approval</title>

	<meta name="viewport" content="user-scalable=no, width=device-width">

	<link rel="stylesheet" type="text/css" charset="utf-8" href="../simantz/mobile/css/jPint.css">
	<link rel="stylesheet" type="text/css" charset="utf-8" href="../simantz/mobile/css/scal.css">
	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/prototype/prototype.js"></script>
	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/jPint.js"></script>
	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/scal/scal.js"></script>
        <script src="../simantz/include/validatetext.js" type="text/javascript"></script>
          
<div id="history" class="jPintPage HasTitle EdgedList EditModeOff Notes" >
		<!-- Home Level Begin -->
		<h1>History List
			<div class="">
				<a class="BackButton">Back</a>

			</div>

			</h1>
			<ul class="">
EOF;


echo <<< EOF
			</ul>
		<!-- Home Level End -->
	</div>
EOF;
break;
case "showhistorypage":

echo <<< EOF
<title>SimEDU Approval</title>

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


<div id="historyLeave" class="jPintPage HasTitle EdgedList EditModeOff Notes" >
		<!-- Home Level Begin -->
		<h1>History List
			<div class="">
				<a class="BackButton">Back</a>

			</div>

			</h1>
			<ul class="">
EOF;
$approvallist->getHistoryList();
echo <<< EOF
			</ul>
		<!-- Home Level End -->
	</div>
EOF;

break;

case "view":
echo <<< EOF
<title>SimEDU Approval</title>

	<meta name="viewport" content="user-scalable=no, width=device-width">

	<link rel="stylesheet" type="text/css" charset="utf-8" href="../simantz/mobile/css/jPint.css">
	<link rel="stylesheet" type="text/css" charset="utf-8" href="../simantz/mobile/css/scal.css">

	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/prototype/prototype.js"></script>
	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/jPint.js"></script>
	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/scal/scal.js"></script>
        <script src="../simantz/include/validatetext.js" type="text/javascript"></script>


EOF;
$approvallist->getInputForm($_GET['id']);

break;
default:
//$listDetails = $approvallist->getApprovalList();
echo <<< EOF
<title>SimEDU Approval</title>

	<meta name="viewport" content="user-scalable=no, width=device-width">

	<link rel="stylesheet" type="text/css" charset="utf-8" href="../simantz/mobile/css/jPint.css">
	<link rel="stylesheet" type="text/css" charset="utf-8" href="../simantz/mobile/css/scal.css">

	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/prototype/prototype.js"></script>
	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/jPint.js"></script>
	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/scal/scal.js"></script>
        <script src="../simantz/include/validatetext.js" type="text/javascript"></script>

	<div id="approvalList" class="jPintPage HasTitle EdgedList EditModeOff Notes" >
		<!-- Home Level Begin -->
		<h1>Approval List
			<div class="">
								<a href="basicmobile.php?action=showhistorypage" class="RightButton">History</a>
			</div>

			</h1>
			<ul class="">
EOF;
$listDetails = $approvallist->getApprovalList();
echo <<< EOF
			</ul>
		<!-- Home Level End -->
	</div>
EOF;
      
            
break;

}
?>

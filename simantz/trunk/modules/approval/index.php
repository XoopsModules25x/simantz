<?php
include_once "system.php";
//include_once ('../../mainfile.php');
//include_once '../simantz/class/Organization.inc.php';
//include_once '../simantz/class/Log.inc.php';
//include_once 'class/ApprovalBasicMobile.inc.php';
include_once "../simantz/class/WorkflowAPI.inc.php";

//$log = new Log();
$userbasicmobileweb="false";
if(strpos( $_SERVER['HTTP_USER_AGENT'], "BlackBerry")>=0)
 $userbasicmobileweb="true";

if($userid>0){
echo <<< EOF
    <script type="text/javascript">

        var init_height = screen.height;
        var init_width = screen.width;

        if(init_height > 500 && init_width > 500)
        self.location = "approvallist.php";
        else if($userbasicmobileweb)
        self.location = "basicmobile.php";
        else
        self.location = "newmobile.php";
    </script>
EOF;
}
else
redirect_header("../../user.php",3,"Redirect to login page");
?>

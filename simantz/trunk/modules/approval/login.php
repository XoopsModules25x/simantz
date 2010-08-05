<?php
//include_once "system.php";
include_once ('../../mainfile.php');
//include_once '../simantz/class/Organization.inc.php';
//include_once '../simantz/class/Log.inc.php';
include_once 'class/ApprovalMobile.inc.php';
include_once "../simantz/class/WorkflowAPI.inc.php";

//$log = new Log();

$error = $_REQUEST['error'];
if(!empty($xoopsUser )){


        $url = XOOPS_URL ."/modules/approval/index.php";
echo <<< EOF
       <script type="text/javascript">
       self.location = "$url";
       </script>
EOF;

    }

    $msg_error = "";
    if($error == 1)
    $msg_error = "Failed to login. Please Try again.";
    
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
	<title>SimEDU Approval</title>

	<meta name="viewport" content="user-scalable=no, width=device-width">

	<link rel="stylesheet" type="text/css" charset="utf-8" href="../simantz/mobile/css/jPint.css">
	<link rel="stylesheet" type="text/css" charset="utf-8" href="../simantz/mobile/css/scal.css">

	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/prototype/prototype.js"></script>
	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/jPint.js"></script>
	<script type="text/javascript" language="javascript" src="../simantz/mobile/js/scal/scal.js"></script>
        <script src="../simantz/include/validatetext.js" type="text/javascript"></script>

</head>

<body id="jPint">


    
<div class="jPintPageSet">

	<div id="mainMenuPage" class="jPintPage IconMenu" >
               <h1>Welcome To SimEDU System

		</h1>
                <br/><br/>
                <div class="txtLogin">Please Login</div><br/>
                <div class="frmLoginMobile">
                    <form action="../../user.php" method="post">
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
                    <input type="hidden" name="xoops_redirect" value="/approval/index.php#approvalList"/>
                    <input type="submit" value="User Login"/>
                    </form>
                </div>

                <div class="txtError"><?echo $msg_error;?></div>

	</div>



</div>
</body>

</html>

<?php

//    switch ($action){
//    case "history":
//            $day = $_REQUEST['day'];
//        $url = XOOPS_URL ."/mobile/index.php#historyLeaveDetail";
//echo <<< EOF
//       <script type="text/javascript">
//       self.location = "$url";
//       </script>
//EOF;
//    break;
//    }
?>

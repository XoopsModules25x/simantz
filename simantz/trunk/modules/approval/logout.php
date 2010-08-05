<?php
//include_once "system.php";
include_once ('../../mainfile.php');


    $message = '';
    $_SESSION = array();

	// add for login history : 2010-03-21
    if ( $xoopsUser ){
	        include_once XOOPS_ROOT_PATH . "/modules/simantz/class/LoginHistory.php";
	        $lh = new LoginHistory();
	        $lh->insertEventRecord($xoopsUser->getVar('uid'),"O");

	    }
	//end

    session_destroy();
    setcookie($xoopsConfig['usercookie'], 0, - 1, '/', XOOPS_COOKIE_DOMAIN, 0);
    setcookie($xoopsConfig['usercookie'], 0, - 1, '/');
    // clear entry from online users table
    if (is_object($xoopsUser)) {
        $online_handler =& xoops_gethandler('online');
        $online_handler->destroy($xoopsUser->getVar('uid'));
    }
    $message = _US_LOGGEDOUT . '<br /> You are now logout.';

    //redirect_header('index.php', 1, $message);
        $url = XOOPS_URL ."/modules/approval/login.php";
echo <<< EOF
       <script type="text/javascript">
       self.location = "$url";
       </script>
EOF;

    exit();

?>

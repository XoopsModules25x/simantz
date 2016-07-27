<?php
include_once ("system.php");
include_once ("menu.php");
$pay = $url."/modules/salon//payment.php";

$tablegroups_users_link=$tableprefix . "groups_users_link";
$uid = $xoopsUser->getVar('uid');
$startpageuser = $url."/modules/salon//payment.php";

$payment = $_GET['payment'];

 	$sql =	"SELECT * from $tablegroups_users_link b 
			WHERE b.uid = $uid
			AND b.groupid = 4 ";
	
	$query=$xoopsDB->query($sql);
	$return = 0;
	if($row=$xoopsDB->fetchArray($query)){
	$return = 1;
	}

if($return == 1 && $payment == "")
header('Location: '.$startpageuser);

echo <<< EFO
<table
 style="width: 100%; height: 100%; text-align: left; margin-left: auto; margin-right: auto; background-repeat: no-repeat; background-image: url(./images/salon-background.jpg);background-position: center top;"
 border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td style="vertical-align:middle; text-align: center;height:150px;"><img
 src="./images/mainpagesalon.png"
 style="width: 600px; height: 59px;" alt=""></td>
    </tr>
    <tr>
      <td>
      <table
 style="width: 900px; height: 500px; text-align: left; margin-left: auto; margin-right: auto;"
 border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td style="text-align: center;"><a
 href=".//payment.php"><img
 src="./images/paymentsalon.png"
 style="width: 300px; height: 300px;" alt=""></a></td>
            <td style="text-align: center;"><a
 href="internal.php"><img
 src="./images/inventorysalon.png"
 style="width: 300px; height: 300px;" alt=""></a></td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
  </tbody>
</table>


EFO;
require(XOOPS_ROOT_PATH.'/footer.php');
?>

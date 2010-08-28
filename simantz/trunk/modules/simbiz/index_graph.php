<?php
include_once "system.php";
include_once ("menu.php");
include_once 'class/Accounts.php';

$acc=new Accounts();
$period_id=10;
$result1=$acc->getSalesInPeriod($period_id);
$result2=$acc->getCOGSAndExpensesInPeriod($period_id);
if($acc->checkAccounts($defaultorganization_id))
redirect_header("accounts.php?defaultacc=1",$pausetime,"New Organization..Generate New Accounts");
	
echo <<< EFO
<table
 style="width: 650px; height: 500px; text-align: left;margin-left: auto; margin-right: auto;"
 border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
       <td style="text-align:center;">
	<img src="chartsalesexpenses_6month.php">
	<img src="chartretainearning_6month.php"></td>
     </tr>
  </tbody>
</table>

EFO;
require(XOOPS_ROOT_PATH.'/footer.php');
?>

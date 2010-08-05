<?php
include "system.php";
include_once ("menu.php");
include_once 'class/Accounts.php';

$acc=new Accounts();

if($acc->checkAccounts($defaultorganization_id))
redirect_header("accounts.php?defaultacc=1",$pausetime,"New Organization..Generate New Accounts");
	
echo <<< EFO
<table
 style="width: 650px; height: 500px; text-align: left;margin-left: auto; margin-right: auto;"
 border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
       <td style="text-align:center;">Sales Expenses<img src="chartsalesexpenses_6month.php"></td>

     </tr>
         <tr>
       <td style="text-align:center;">Profit And Lost<img src="chartretainearning_6month.php"></td>

     </tr>
  </tbody>
</table>

EFO;
require(XOOPS_ROOT_PATH.'/footer.php');
?>

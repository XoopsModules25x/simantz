<?php
	include_once "system.php";
	include_once "menu.php";
	include_once "../system/class/Log.php";
	include_once "class/Accounts.php";
	include_once "class/AccountsAPI.php";
	include_once "../system/class/SelectCtrl.php";
	include_once "class/FinancialYear.php";

//$ctrl= new SelectCtrl();

$ctrl = new SelectCtrl();
$accapi=new AccountsAPI();
$acc = new Accounts();
$period_id=6;
$accounts_id=74;
$result= $acc->getAccountLastBalanceOnPeriod($period_id,$accounts_id);
echo <<< EOF
Result: $result<br>
<form name='sa' method='POST'><input type='submit' method='post'>
<input type='submit' >
</form>
EOF;
	
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');
?>
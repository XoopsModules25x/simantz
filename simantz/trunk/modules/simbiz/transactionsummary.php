<?php
include "system.php";
include "menu.php";
//include "exporttransaction.php";
//include_once 'class/Log.php';
include_once 'class/Accounts.php';
//include_once 'class/SelectCtrl.php';
include_once 'class/Transaction.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


//$log = new Log();
$o = new Accounts();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
$trans= new Transaction();

if(isset($_POST['accounts_id']) || isset($_GET['accounts_id'])){
    if(isset($_POST['accounts_id']))
        $accounts_id=$_POST['accounts_id'];
     else
            $accounts_id=$_GET['accounts_id'];
$sqlgetopeningbalance="SELECT openingbalance FROM $tableaccounts where accounts_id=$accounts_id";
$queryopeningbalance=$xoopsDB->query($sqlgetopeningbalance);

if($rowopeningbalance=$xoopsDB->fetchArray($queryopeningbalance))
$openingbalance=$rowopeningbalance['openingbalance'];
else
$openingbalance=0;

$openingbalance=number_format($openingbalance,2);


echo <<< EOF
<table border='1' >
<tbody>
<tr><th colspan='5'  style='text-align:center'>Transaction Summary</th></tr>
<tr><th style='text-align:center'>Accounts</th><th style='text-align:center'>Period</th><th style='text-align:center'>Business Partner</th><th style='text-align:center'>Transaction Balance</th><th style='text-align:center'>Last Balance</th></tr>

	<tr><td>Opening Balance</td>
		<td></td>
		<td></td>
		<td style='text-align:right'>$openingbalance</td>
		<td style='text-align:right'>$openingbalance</td></tr>
EOF;

$sql="SELECT a.openingbalance, ts.transum_id,bp.bpartner_name,bp.bpartner_no,a.accountcode_full,a.accounts_name,p.period_name,ts.lastbalance,
	ts.transactionamt
	FROM $tabletranssummary ts 
	INNER JOIN $tableaccounts a on ts.accounts_id=a.accounts_id
	INNER JOIN $tableperiod p on ts.period_id=p.period_id
	INNER JOIN $tablebpartner bp on ts.bpartner_id=bp.bpartner_id
	where ts.organization_id=$defaultorganization_id and ts.accounts_id=$accounts_id
	order by p.period_name,bp.bpartner_no";

$query=$xoopsDB->query($sql);

$log->showLog(4,"Get Table with SQL: $sql");

$i=0;
while($row=$xoopsDB->fetchArray($query)){
	$bpartner_name=$row['bpartner_name'];
	$bpartner_no=$row['bpartner_no'];
	$accountcode_full=$row['accountcode_full'];
	$accounts_name=$row['accounts_name'];
	$transactionamt=number_format($row['transactionamt'],2);
	$lastbalance=$row['lastbalance'];
	$period_name=$row['period_name'];
	$transum_id=$row['transum_id'];
	$openingbalance=number_format($row['openingbalance'],2);


echo <<< EOF
<tr><td>$accountcode_full-$accounts_name</td>
	<td>$period_name</td>
	<td>$bpartner_name</td>
	<td style='text-align:right'>$transactionamt</td>
	<td style='text-align:right'>$lastbalance</td></tr>
EOF;
$i++;

}//end while
echo <<< EOF
</tbody></table>
EOF;
}
else
{
echo "There is some internal error on this page, please make sure you come to this page from chart of account.";}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');
?>
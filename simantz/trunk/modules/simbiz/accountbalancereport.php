<?php
/*
 *Developed by kstan@simit.com.my 2008-12-25
*/
include_once "system.php";
include_once "menu.php";
include_once '../system/class/Log.php';
//include_once 'class/Accounts.php';
//include_once 'class/SelectCtrl.php';
//include_once "../../class/datepicker/class.datepicker.php";
include_once('../../class/fpdf/fpdf.php');

//$dp=new datepicker("$url");
//$dp->dateFormat='Y-m-d';
//$showDateFrom=$dp->show('datefrom');
//$showDateTo=$dp->show('dateto');
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$s = new XoopsSecurity();
//$acc= new Accounts();

//$bpartnerfrom
//$accounts_id=$_POST['accounts_id'];
//$period_id=$_POST['periodfrom_id'];
//	$acc->fetchAccounts($accounts_id);
//	$balanceamt=$acc->accBalanceBFAmount($period_id,$accounts_id);
echo <<< EOF

<table border='1'>
	<tbody>
		<tr><th style="text-align:center;" colspan='4'>Account Balance Report</th></tr>
		<form name='frmaccountbalancereport' method='POST' target="_blank" action='viewaccountbalancereport.php' >

		<tr><th style="text-align:center;" colspan='2'>Report Type</th>
		<th style="text-align:center;" colspan='2'>
			<SELECT name='reporttype' onchange='changereport()'>
				<option value='1' selected='selected'>General Account Balance</option>
				<option value='2'>Debtor Account Balance</option>
				<option value='3'>Creditor Account Balance</option>
			</SELECT></td></th></tr>

		<tr  id='tda'>
			<td class='head'>Account From</td><td class='even'><input name='accounts_from'></td>
			<td class='head'>Account To</td><td class='even'><input name='accounts_to'></td>
		</tr>
		<tr  id='tdbp'>
				<td id='tdc1' class='head'>Creditor From</td>
				<td class='head' id='tdd1'>Debtor From</td>
				<td class='even'><input name='bpartner_from'></td>
				<td id='tdc2' class='head'>Creditor To</td>
				<td class='head' id='tdd2'>Debtor To</td>
				<td class='even'><input name='bpartner_to'></td>
		</tr>
		<tr><td><input type='submit' value='Preview' name='submit'></td></tr>
		</blank>
	</tbody>
</table>

<script type='text/javascript'>
changereport();

function autofocus(){
changereport();
}
function changereport(){
//alert(value);
value=document.frmaccountbalancereport.reporttype.value;

	switch(value){
		case "1":

			document.getElementById("tda").style.display='';
			document.getElementById("tdbp").style.display='none';

			document.frmaccountbalancereport.action='viewaccountbalancereport.php';
		break;
		case "2":

			document.getElementById("tda").style.display='none';
			document.getElementById("tdbp").style.display='';
			document.getElementById("tdd1").style.display='';
			document.getElementById("tdc1").style.display='none';
			document.getElementById("tdd2").style.display='';
			document.getElementById("tdc2").style.display='none';

			document.frmaccountbalancereport.action='viewbpartnerbalancereport.php';
		break;
		case "3":

			document.getElementById("tda").style.display='none';
			document.getElementById("tdbp").style.display='';
			document.getElementById("tdd1").style.display='none';
			document.getElementById("tdc1").style.display='';
			document.getElementById("tdd2").style.display='none';
			document.getElementById("tdc2").style.display='';

			document.frmaccountbalancereport.action='viewbpartnerbalancereport.php';
		break;
		default:
			alert("You'd select unknown option.");
		break;


	}
		//document.frmledgerreport.targetaction.value=document.frmledgerreport.action;
}
</script>

EOF;
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


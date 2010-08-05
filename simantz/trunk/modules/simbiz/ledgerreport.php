<?php
/*
 *Developed by kstan@simit.com.my 2008-12-25
*/
include_once "system.php";
include_once "menu.php";
include_once '../simantz/class/Log.php';
//include_once 'class/Accounts.php';
//include_once 'class/SelectCtrl.php';
//include_once "../../class/datepicker/class.datepicker.php";
include_once('../simantz/class/fpdf/fpdf.php');

//$dp=new datepicker("$url");
//$dp->dateFormat='Y-m-d';
//$showDateFrom=$dp->show('datefrom');
//$showDateTo=$dp->show('dateto');
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
//$acc= new Accounts();
$accountctrl=$simbizctrl->getSelectAccounts(0,'N','','accounts_id',"AND account_type<> 2 AND account_type<> 3");
$periodfromctrl=$simbizctrl->getSelectPeriod(0,'N',"","periodfrom_id");
$periodtoctrl=$simbizctrl->getSelectPeriod(0,'N',"","periodto_id");
//$bpartnerfrom
//$accounts_id=$_POST['accounts_id'];
//$period_id=$_POST['periodfrom_id'];
//	$acc->fetchAccounts($accounts_id);
//	$balanceamt=$acc->accBalanceBFAmount($period_id,$accounts_id);

//if()
echo <<< EOF

<table border='1'>
	<tbody>
		<tr><th style="text-align:center;" colspan='4'>Ledger Report</th></tr>
		<form name='frmledgerreport' method='POST' target="_blank" action='viewsingleledger.php' >
		<tr><th style="text-align:center;" colspan='2'>Report Type</th>
		<th style="text-align:center;" colspan='2'>
			<SELECT name='reporttype' onchange='changereport()'>
				<option value='s' selected='selected'>Single Account</option>
				<option value='a'>General Ledger(Multi Account)</option>
				<option value='d'>Debtor Ledger</option>
				<option value='c'>Creditor Ledger</option>
			</SELECT>
                &nbsp;&nbsp;Show Batch No&nbsp;<input type="checkbox" name="showbatchno" checked>
                </td></th></tr>
		<tr><td class='head'>Period From</td><td class='odd'>$periodfromctrl</td>
			<td class='head'>Period To</td><td class='odd'>$periodtoctrl</td>
		</tr>
		<tr  id='tds'>
			<td class='head'>Account</td><td class='even'  colspan='3'>$accountctrl</td>
		</tr>
		<tr  id='tda' $styletda>
			<td class='head'>Account No From</td><td class='even'><input name='accounts_from'></td>
			<td class='head'>Account No To</td><td class='even'><input name='accounts_to'></td>
		</tr>
		<tr  id='tdbp' $styletdbp>
				<td id='tdc1' class='head'>Creditor From</td>
				<td class='head' id='tdd1'>Debtor From</td>
				<td class='even'><input name='bpartner_from'></td>
				<td id='tdc2' class='head'>Creditor To</td>
				<td class='head' id='tdd2'>Debtor To</td>
				<td class='even'><input name='bpartner_to'></td>
		</tr>

		<tr><td>
			<input type='submit' value='Preview' name='submit'>
		</tr>
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
value=document.frmledgerreport.reporttype.value;
	switch(value){
		case "a":
			document.getElementById("tds").style.display='none';
			document.getElementById("tda").style.display='';
			document.getElementById("tdbp").style.display='none';
			document.frmledgerreport.action='viewmultiledger.php';
		break;
		case "d":
			document.getElementById("tds").style.display='none';
			document.getElementById("tda").style.display='none';
			document.getElementById("tdbp").style.display='';
			document.getElementById("tdd1").style.display='';
			document.getElementById("tdc1").style.display='none';
			document.getElementById("tdd2").style.display='';
			document.getElementById("tdc2").style.display='none';
			document.frmledgerreport.action='viewdebtorledger.php';
		break;
		case "c":
			document.getElementById("tds").style.display='none';
			document.getElementById("tda").style.display='none';
			document.getElementById("tdbp").style.display='';
			document.getElementById("tdd1").style.display='none';
			document.getElementById("tdc1").style.display='';
			document.getElementById("tdd2").style.display='none';
			document.getElementById("tdc2").style.display='';
			document.frmledgerreport.action='viewcreditorledger.php';
		break;
		case "s":
			document.getElementById("tds").style.display='';
			document.getElementById("tda").style.display='none';
			document.getElementById("tdbp").style.display='none';
			document.frmledgerreport.action='viewsingleledger.php';
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


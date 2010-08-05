<?php
/*
 *Developed by kstan@simit.com.my 2008-12-25
*/
include_once "system.php";
include_once "menu.php";
//include_once '../system/class/Log.php';
//include_once 'class/Accounts.php';
//include_once 'class/SelectCtrl.php';
//include_once "../../class/datepicker/class.datepicker.php";
include_once('../simantz/class/fpdf/fpdf.php');
include_once "../simantz/class/datepicker/class.datepicker.php";

$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';
$datefrom = getMonth(date("Ymd", time()),0) ;
$dateto = getMonth(date("Ymd", time()),1) ;

$showDateFrom=$dp->show('datefrom');
$showDateTo=$dp->show('dateto');
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();

echo <<< EOF
<script type='text/javascript'>

function autofocus(){
changereport();
}
function changereport(){
//alert(value);
value=document.frmtrialbalancereport.reporttype.value;

	switch(value){

		case "s":
			document.frmtrialbalancereport.action='viewtrialbalancesummary.php';
		break;

		case "a":
			document.frmtrialbalancereport.action='viewtrialbalancedetail.php';
		break;

		default:
			alert("You'd select unknown option.");
		break;

		
	}
		//document.frmledgerreport.targetaction.value=document.frmledgerreport.action;
}
</script>
<table border='1'>
<tbody>
<tr><TH colspan='4' style='text-align: center'>Criterial</TH></tr>
	<TR><Th colspan='2'>Report Type</TH><Th colspan='2'>
	<FORM name='frmtrialbalancereport' method='POST' target="_blank" action="viewtrialbalancesummary.php">
			<SELECT name='reporttype' onchange='changereport()'>
				<option value='s' selected='selected'>Trial Balance Summary</option>
				<option value='a'>Trial Balance Detail</option>
			</SELECT></TH></TR>

	<tr>
		<Td class='head'>Account From</Td>
			<Td  class='odd'><input name='accounts_from' value="$accounts_codefrom"></Td>
		<Td class='head'>Account To</Td>
		<Td class='odd'><input name='accounts_to' value="$accounts_codeto"></Td>

	</tr>
	<tr>
		<Td class='head'>Date From</Td>
		<Td  class='odd'><input id='datefrom' name='datefrom' value="$datefrom">
				<input type='button' value='Date' onclick="$showDateFrom">
		</Td>
		<Td class='head'>Date To</Td>
		<Td class='odd'>
			<input id='dateto' name='dateto' value="$dateto" >
			<input type='button' value='Date' onclick="$showDateTo">
		</Td>
		
	</tr>

</tbody>
</table>
<INPUT type='reset' name='reset' value='Reset'><INPUT type='submit' name='submit' value='View'>

</FORM>

EOF;
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


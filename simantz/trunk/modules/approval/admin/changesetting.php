<?php
include "system.php";
//include "menu.php";
//xoops_cp_header();

if($purchaseinvoiceaccount_id == "")
$purchaseinvoiceaccount_id = 0;

if(isset($_POST['savesetting'])){

$smtpserver=$_POST['smtpserver'];
$smtpuser=$_POST['smtpuser'];
$smtppassword=$_POST['smtppassword'];
$senderuser=$_POST['senderuser'];
$cur_name=$_POST['cur_name'];
$cur_symbol=$_POST['cur_symbol'];
$tokenlife=$_POST['tokenlife'];
$pausetime=$_POST['pausetime'];
$loglevel=$_POST['loglevel'];
$enddiscountpercent=$_POST['enddiscountpercent'];
$statementpapersource=$_POST['statementpapersource'];
$att_showcontact=$_POST['att_showcontact'];
$invoiceprefix=$_POST['invoiceprefix'];
$quotationprefix=$_POST['quotationprefix'];

system("echo '<?php' > ../setting.php");
system("echo '\$smtpserver=\"$smtpserver\";'>> ../setting.php");
system("echo '\$smtpuser=\"$smtpuser\";'>> ../setting.php");
system("echo '\$smtppassword=\"$smtppassword\";'>>  ../setting.php");
system("echo '\$senderuser=\"$senderuser\";'>>  ../setting.php");
system("echo '\$tokenlife=\"$tokenlife\";'>>  ../setting.php");
system("echo '\$pausetime=\"$pausetime\";'>>  ../setting.php");
system("echo '\$loglevel=\"$loglevel\";'>>  ../setting.php");
system("echo '\$enddiscountpercent=\"$enddiscountpercent\";'>>  ../setting.php");
system("echo '\$statementpapersource=\"$statementpapersource\";'>>  ../setting.php");
system("echo '\$invoiceprefix=\"$invoiceprefix\";'>>  ../setting.php");
system("echo '\$quotationprefix=\"$quotationprefix\";'>>  ../setting.php");

system("echo '?>'>> ../setting.php");
//echo "/****************<br>This is writing event <br>*********/";
}

//global $ctrl;
//$purchaseaccount = $ctrl->getSelectAccountsExtra($purchaseinvoiceaccount_id,'Y',"","purchaseinvoiceaccount_id",'','N',"N");

echo <<< EOF
	<A href='index.php'>Back To This Module Administration Menu</A>
<table border='1'>
<form method="POST" onsubmit="return confirm('Change setting? It will effect the refresh time and email services in SIMEDU.')">
<tr><th style='text-align:center'>Parameter</th><th style='text-align:center'>Value</th></tr>
<tr><td class='head'  style='text-align:center'>SMTP Host:Port</td>
	<td class='odd'  style='text-align:center'><input name="smtpserver" value="$smtpserver"></td></tr>
<tr><td class='head'  style='text-align:center'>SMTP User</td><td class='even'  style='text-align:center'>
		<input name="smtpuser" value="$smtpuser"></td></tr>
<tr><td class='head'  style='text-align:center'>SMTP Password</td><td class='odd'  style='text-align:center'>
		<input name="smtppassword" value="$smtppassword" type='password'></td></tr>
<tr><td class='head'  style='text-align:center'>Sender Display Name</td><td class='even'  style='text-align:center'>
		<input name="senderuser" value="$senderuser"></td></tr>
<tr><td class='head'  style='text-align:center'>Token Life (Second)</td><td class='odd'  style='text-align:center'>
		<input name="tokenlife" value="$tokenlife"></td></tr>
<tr><td class='head'  style='text-align:center'>Redirect Pause Time (Second)</td>
		<td class='odd'  style='text-align:center'><input name="pausetime" value="$pausetime"></td></tr>
<tr><td class='head'  style='text-align:center'>Log Level(0:no log, 1: warning, 2: error, 3/4 for programming purpose)</td>
		<td class='odd'  style='text-align:center'><input name="loglevel" value="$loglevel"></td></tr>
<tr><td class='head'  style='text-align:center'>Discount % for Wood Type = 'E' (End)</td>
		<td class='odd'  style='text-align:center'><input name="enddiscountpercent" value="$enddiscountpercent"></td>

<tr><td class='head'  style='text-align:center'>Paper Source</td>
		<td class='odd'  style='text-align:center'><input name="statementpapersource" value="$statementpapersource"></td></tr>

<tr><td class='head'  style='text-align:center'>Invoice No Prefix</td>
		<td class='odd'  style='text-align:center'><input name="invoiceprefix" value="$invoiceprefix"></td></tr>

<tr><td class='head'  style='text-align:center'>Quotation No Prefix</td>
		<td class='odd'  style='text-align:center'><input name="quotationprefix" value="$quotationprefix"></td></tr>

<tr><td><input type="reset" name="reset" value="reset"></td>
<td><input type="submit" name="savesetting" value="Save">
</td></tr>
</form>
</table>
EOF;
xoops_cp_footer();
?>


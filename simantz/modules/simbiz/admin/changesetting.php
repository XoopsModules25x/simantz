<?php
include "system.php";

//xoops_cp_header();

if($student_account == "")
$student_account = 0;
if($cash_account == "")
$cash_account = 0;
if($cheque_account == "")
$cheque_account = 0;
if($student_bpartner == "")
$student_bpartner = 0;
if($charges_account == "")
$charges_account = 0;
if($payroll_account == "")
$payroll_account = 0;
if($employee_account == "")
$employee_account = 0;
if($socso_account == "")
$socso_account = 0;
if($epf_account == "")
$epf_account = 0;


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
$statementpapersource=$_POST['statementpapersource'];
$att_showcontact=$_POST['att_showcontact'];

$prefix_je=$_POST['prefix_je'];
$prefix_dcnote=$_POST['prefix_dcnote'];
$prefix_drnote=$_POST['prefix_drnote'];
$prefix_rcpt=$_POST['prefix_rcpt'];
$prefix_pv=$_POST['prefix_pv'];
$prefix_pvcash=$_POST['prefix_pvcash'];
$prefix_spi=$_POST['prefix_spi'];
$prefix_spi2=$_POST['prefix_spi2'];

$student_account=$_POST['student_account'];
$cash_account=$_POST['cash_account'];
$cheque_account=$_POST['cheque_account'];
$student_bpartner=$_POST['student_bpartner'];
$charges_account=$_POST['charges_account'];
$payroll_account=$_POST['payroll_account'];
$employee_account=$_POST['employee_account'];
$socso_account=$_POST['socso_account'];
$epf_account=$_POST['epf_account'];
$totalworkingday=$_POST['totalworkingday'];
$totalworkinghour=$_POST['totalworkinghour'];
$sendsmsgroup=$_POST['sendsmsgroup'];
$orgreportheader=$_POST['orgreportheader'];

if(PHP_OS=='WINNT'){


system("echo ^<?php > ../setting.php");
system("echo \$smtpserver=\"$smtpserver\";>> ../setting.php");
system("echo \$smtpuser=\"$smtpuser\";>> ../setting.php");
system("echo \$smtppassword=\"$smtppassword\";>>  ../setting.php");
system("echo \$senderuser=\"$senderuser\";>>  ../setting.php");
system("echo \$tokenlife=\"$tokenlife\";>>  ../setting.php");
system("echo \$pausetime=\"$pausetime\";>>  ../setting.php");
system("echo \$loglevel=\"$loglevel\";>>  ../setting.php");
system("echo \$statementpapersource=\"$statementpapersource\";>>  ../setting.php");
system("echo \$prefix_je=\"$prefix_je\";>>  ../setting.php");
system("echo \$prefix_dcnote=\"$prefix_dcnote\";>>  ../setting.php");
system("echo \$prefix_drnote=\"$prefix_drnote\";>>  ../setting.php");
system("echo \$prefix_rcpt=\"$prefix_rcpt\";>>  ../setting.php");
system("echo \$prefix_pv=\"$prefix_pv\";>>  ../setting.php");
system("echo \$prefix_pvcash=\"$prefix_pvcash\";>>  ../setting.php");
system("echo \$prefix_spi=\"$prefix_spi\";>>  ../setting.php");
system("echo \$prefix_spi2=\"$prefix_spi2\";>>  ../setting.php");
system("echo \$student_account=\"$student_account\";>>  ../setting.php");
system("echo \$cash_account=\"$cash_account\";>>  ../setting.php");
system("echo \$cheque_account=\"$cheque_account\";>>  ../setting.php");
system("echo \$student_bpartner=\"$student_bpartner\";>>  ../setting.php");
system("echo \$charges_account=\"$charges_account\";>>  ../setting.php");
system("echo \$payroll_account=\"$payroll_account\";>>  ../setting.php");
system("echo \$employee_account=\"$employee_account\";>>  ../setting.php");
system("echo \$socso_account=\"$socso_account\";>>  ../setting.php");
system("echo \$epf_account=\"$epf_account\";>>  ../setting.php");
system("echo \$totalworkingday=\"$totalworkingday\";>>  ../setting.php");
system("echo '\$sendsmsgroup=\"$sendsmsgroup\";'>>  ../setting.php");
system("echo '\$orgreportheader=\"$orgreportheader\";'>>  ../setting.php");

system("echo  ?^> >> ../setting.php");
}else{
system("echo '<?php' > ../setting.php");
system("echo '\$smtpserver=\"$smtpserver\";'>> ../setting.php");
system("echo '\$smtpuser=\"$smtpuser\";'>> ../setting.php");
system("echo '\$smtppassword=\"$smtppassword\";'>>  ../setting.php");
system("echo '\$senderuser=\"$senderuser\";'>>  ../setting.php");
system("echo '\$tokenlife=\"$tokenlife\";'>>  ../setting.php");
system("echo '\$pausetime=\"$pausetime\";'>>  ../setting.php");
system("echo '\$loglevel=\"$loglevel\";'>>  ../setting.php");
system("echo '\$statementpapersource=\"$statementpapersource\";'>>  ../setting.php");
system("echo '\$prefix_je=\"$prefix_je\";'>>  ../setting.php");
system("echo '\$prefix_dcnote=\"$prefix_dcnote\";'>>  ../setting.php");
system("echo '\$prefix_drnote=\"$prefix_drnote\";'>>  ../setting.php");
system("echo '\$prefix_rcpt=\"$prefix_rcpt\";'>>  ../setting.php");
system("echo '\$prefix_pv=\"$prefix_pv\";'>>  ../setting.php");
system("echo '\$prefix_pvcash=\"$prefix_pvcash\";'>>  ../setting.php");
system("echo '\$prefix_spi=\"$prefix_spi\";'>>  ../setting.php");
system("echo '\$prefix_spi2=\"$prefix_spi2\";'>>  ../setting.php");
system("echo '\$student_account=\"$student_account\";'>>  ../setting.php");
system("echo '\$cash_account=\"$cash_account\";'>>  ../setting.php");
system("echo '\$cheque_account=\"$cheque_account\";'>>  ../setting.php");
system("echo '\$student_bpartner=\"$student_bpartner\";'>>  ../setting.php");
system("echo '\$charges_account=\"$charges_account\";'>>  ../setting.php");
system("echo '\$payroll_account=\"$payroll_account\";'>>  ../setting.php");
system("echo '\$employee_account=\"$employee_account\";'>>  ../setting.php");
system("echo '\$socso_account=\"$socso_account\";'>>  ../setting.php");
system("echo '\$epf_account=\"$epf_account\";'>>  ../setting.php");
system("echo '\$totalworkingday=\"$totalworkingday\";'>>  ../setting.php");
system("echo '\$totalworkinghour=\"$totalworkinghour\";'>>  ../setting.php");
system("echo '\$sendsmsgroup=\"$sendsmsgroup\";'>>  ../setting.php");
system("echo '\$orgreportheader=\"$orgreportheader\";'>>  ../setting.php");

system("echo '?>'>> ../setting.php");
}
//echo "/****************<br>This is writing event <br>*********/";
}

/*
 *
 * $account_typectrl="<select name='account_type' onchange='changeAccountType()'>
			<option value='1' $selectedgeneral>General Account</option>
			<option value='2' $selecteddebtor>Trade Debtor</option>
			<option value='3' $selectedcreditor>Trade Creditor</option>
			<option value='4' $selectedbank>Bank</option>
			<option value='7' $selectedbank>Cash</option></select>";
 */
$student_accctrl = $ctrl->getSelectAccountsExtra($student_account,'Y',"","student_account"," and account_type in (2,3) ",'N',"N");
$student_bpartnerctrl = $ctrl->getSelectBPartnerExtra($student_bpartner,'Y',"","student_bpartner","",'N',"student_bpartner","","N",0);
$cash_accctrl = $ctrl->getSelectAccountsExtra($cash_account,'Y',"","cash_account"," and account_type in (4,7) ",'N',"N");
$cheque_accctrl = $ctrl->getSelectAccountsExtra($cheque_account,'Y',"","cheque_account"," and account_type in (4,7) ",'N',"N");
$charges_accctrl = $ctrl->getSelectAccountsExtra($charges_account,'Y',"","charges_account"," ",'N',"N");
$payroll_accctrl = $ctrl->getSelectAccountsExtra($payroll_account,'Y',"","payroll_account",'','N',"N");
$employee_accctrl = $ctrl->getSelectAccountsExtra($employee_account,'Y',"","employee_account",'','N',"N");
$socso_accctrl = $ctrl->getSelectAccountsExtra($socso_account,'Y',"","socso_account",'','N',"N");
$epf_accctrl = $ctrl->getSelectAccountsExtra($epf_account,'Y',"","epf_account",'','N',"N");


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
<tr><td class='head'  style='text-align:center'>Business Partner Statement Paper Source(0:A4, 1: Letter)</td>
		<td class='odd'  style='text-align:center'><input name="statementpapersource" value="$statementpapersource"></td></tr>

<tr><td class='head'  style='text-align:center'>Prefix For Journal Entry (Doc. No)</td>
		<td class='odd'  style='text-align:center'><input name="prefix_je" value="$prefix_je"></td></tr>
<tr><td class='head'  style='text-align:center'>Prefix For Debit Note (Doc. No)</td>
		<td class='odd'  style='text-align:center'><input name="prefix_dcnote" value="$prefix_dcnote"></td></tr>
<tr><td class='head'  style='text-align:center'>Prefix For Credit Note (Doc. No)</td>
		<td class='odd'  style='text-align:center'><input name="prefix_drnote" value="$prefix_drnote"></td></tr>
<tr><td class='head'  style='text-align:center'>Prefix For Receipt (Doc. No)</td>
		<td class='odd'  style='text-align:center'><input name="prefix_rcpt" value="$prefix_rcpt"></td></tr>
<tr><td class='head'  style='text-align:center'>Prefix For Payment Voucher - Bank(Doc. No)</td>
		<td class='odd'  style='text-align:center'><input name="prefix_pv" value="$prefix_pv"></td></tr>
<tr><td class='head'  style='text-align:center'>Prefix For Payment Voucher - Cash(Doc. No)</td>
		<td class='odd'  style='text-align:center'><input name="prefix_pvcash" value="$prefix_pvcash"></td></tr>
<tr><td class='head'  style='text-align:center'>Prefix For Sales Invoice (Doc. No)</td>
		<td class='odd'  style='text-align:center'><input name="prefix_spi" value="$prefix_spi"></td></tr>
<tr><td class='head'  style='text-align:center'>Prefix For Purchase Invoice (Doc. No)</td>
		<td class='odd'  style='text-align:center'><input name="prefix_spi2" value="$prefix_spi2"></td></tr>


<tr><td class='head'  style='text-align:center'>Default Student Account</td>
		<td class='odd'  style='text-align:center'>$student_accctrl<br>$student_bpartnerctrl</td></tr>
<tr><td class='head'  style='text-align:center'>Default Cash Account (Student Payment)</td>
		<td class='odd'  style='text-align:center'>$cash_accctrl</td></tr>
<tr><td class='head'  style='text-align:center'>Default Cheque Account (Student Payment)</td>
		<td class='odd'  style='text-align:center'>$cheque_accctrl</td></tr>
<tr><td class='head'  style='text-align:center'>Default Charges Account (Student)</td>
		<td class='odd'  style='text-align:center'>$charges_accctrl</td></tr>
<tr><td class='head'  style='text-align:center'>Salary Account (Payroll Purpose)</td>
		<td class='odd'  style='text-align:center'>$payroll_accctrl</td></tr>

<tr><td class='head'  style='text-align:center'>Accrued Expenses Account (Payroll Purpose)</td>
		<td class='odd'  style='text-align:center'>$employee_accctrl</td></tr>

<tr><td class='head'  style='text-align:center'>Socso Account (Payroll Purpose)</td>
		<td class='odd'  style='text-align:center'>$socso_accctrl</td></tr>

<tr><td class='head'  style='text-align:center'>EPF Account (Payroll Purpose)</td>
		<td class='odd'  style='text-align:center'>$epf_accctrl</td></tr>

<tr><td class='head'  style='text-align:center'>Total Working Days</td>
		<td class='odd'  style='text-align:center'><input name="totalworkingday" value="$totalworkingday"></td></tr>

<tr><td class='head'  style='text-align:center'>Total Working Hours Per Day</td>
		<td class='odd'  style='text-align:center'><input name="totalworkinghour" value="$totalworkinghour"></td></tr>
<tr><td class='head'  style='text-align:center'>Send SMS Group</td>
		<td class='odd'  style='text-align:center'><input name="sendsmsgroup" value="$sendsmsgroup"></td></tr>
<tr><td class='head'  style='text-align:center'>Organization Name for Report Header</td>
		<td class='odd'  style='text-align:center'><input name="orgreportheader" value="$orgreportheader"></td></tr>

<tr><td><input type="reset" name="reset" value="reset"></td>
<td><input type="submit" name="savesetting" value="Save">
</td></tr>
</form>
</table>
EOF;
xoops_cp_footer();
?>


<?php
include "system.php";
xoops_cp_header();
if(isset($_POST['savesetting'])){

$smtpserver=$_POST['smtpserver'];
$smtpuser=$_POST['smtpuser'];
$smtppassword=$_POST['smtppassword'];
$senderuser=$_POST['senderuser'];
$cur_name=$_POST['cur_name'];
$cur_symbol=$_POST['cur_symbol'];
$tokenlife=$_POST['tokenlife'];
$pausetime=$_POST['pausetime'];
$senderuser=$_POST['senderuser'];
$smsurl=$_POST['smsurl'];
$smsid=$_POST['smsid'];
$smspassword=$_POST['smspassword'];
$smssender_name=$_POST['smssender_name'];
$att_showcontact=$_POST['att_showcontact'];
$loglevel=$_POST['loglevel'];
system("echo '<?php' > ../setting.php");
system("echo '\$smtpserver=\"$smtpserver\";'>> ../setting.php");
system("echo '\$smtpuser=\"$smtpuser\";'>> ../setting.php");
system("echo '\$smtppassword=\"$smtppassword\";'>>  ../setting.php");
system("echo '\$senderuser=\"$senderuser\";'>>  ../setting.php");
system("echo '\$cur_name=\"$cur_name\";'>>  ../setting.php");
system("echo '\$cur_symbol=\"$cur_symbol\";'>>  ../setting.php");
system("echo '\$tokenlife=\"$tokenlife\";'>>  ../setting.php");
system("echo '\$pausetime=\"$pausetime\";'>>  ../setting.php");
system("echo '\$smsurl=\"$smsurl\";'>>  ../setting.php");
system("echo '\$smsid=\"$smsid\";'>>  ../setting.php");
system("echo '\$smspassword=\"$smspassword\";'>>  ../setting.php");
system("echo '\$smssender_name=\"$smssender_name\";'>>  ../setting.php");
system("echo '\$att_showcontact=\"$att_showcontact\";'>>  ../setting.php");
system("echo '\$loglevel=\"$loglevel\";'>>  ../setting.php");
system("echo '?>'>> ../setting.php");
//echo "/****************<br>This is writing event <br>*********/";
}

echo <<< EOF
<table border='1'>
<form method="POST" onsubmit="return confirm('Change setting? It will effect the refresh time and email services in SimTrain.')">
<tr><th style='text-align:center'>Parameter</th><th style='text-align:center'>Value</th></tr>
<tr><td class='head'  style='text-align:center'>SMTP Host:Port</td>
	<td class='odd'  style='text-align:center'><input name="smtpserver" value="$smtpserver"></td></tr>
<tr><td class='head'  style='text-align:center'>SMTP User</td><td class='even'  style='text-align:center'>
		<input name="smtpuser" value="$smtpuser"></td></tr>
<tr><td class='head'  style='text-align:center'>SMTP Password</td><td class='odd'  style='text-align:center'>
		<input name="smtppassword" value="$smtppassword" type='password'></td></tr>
<tr><td class='head'  style='text-align:center'>Sender Display Name</td><td class='even'  style='text-align:center'>
		<input name="senderuser" value="$senderuser"></td></tr>
<tr><td class='head'  style='text-align:center'>Currency Name</td><td class='odd'  style='text-align:center'>
		<input name="cur_name" value="$cur_name"></td></tr>
<tr><td class='head'  style='text-align:center'>Currency Symbol</td><td class='odd'  style='text-align:center'>
		<input name="cur_symbol" value="$cur_symbol"></td></tr>
<tr><td class='head'  style='text-align:center'>Token Life (Second)</td><td class='odd'  style='text-align:center'>
		<input name="tokenlife" value="$tokenlife"></td></tr>
<tr><td class='head'  style='text-align:center'>Redirect Pause Time (Second)</td>
		<td class='odd'  style='text-align:center'><input name="pausetime" value="$pausetime"></td></tr>
<tr><td class='head'  style='text-align:center'>SMS Provider URL</td>
		<td class='odd'  style='text-align:center'><input name="smsurl" value="$smsurl"></td></tr>
<tr><td class='head'  style='text-align:center'>SMS User ID</td>
		<td class='odd'  style='text-align:center'><input name="smsid" value="$smsid"></td></tr>
<tr><td class='head'  style='text-align:center'>SMS Password</td>
		<td class='odd'  style='text-align:center'><input name="smspassword" value="$smspassword"></td></tr>
<tr><td class='head'  style='text-align:center'>SMS Display Name</td>
		<td class='odd'  style='text-align:center'><input name="smssender_name" value="$smssender_name"></td></tr>
<tr><td class='head'  style='text-align:center'>Show Contact In Attendance (Y/N)</td>
		<td class='odd'  style='text-align:center'><input name="att_showcontact" value="$att_showcontact"></td></tr>
<tr><td class='head'  style='text-align:center'>Log Level(0-5)</td>
		<td class='odd'  style='text-align:center'><input name="loglevel" value="$loglevel"></td></tr>
<tr><td><input type="reset" name="reset" value="reset"></td>
<td><input type="submit" name="savesetting" value="Save">
</td></tr>
</form>
</table>
EOF;
xoops_cp_footer();
?>


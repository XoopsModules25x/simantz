<?php
include "system.php";
include_once '../../simantz/class/SelectCtrl.inc.php';
//xoops_cp_header();
$ctrl=new SelectCtrl();
if(isset($_POST['savesetting'])){

$report_organizationname=$_POST['report_organizationname'];
$report_organizationaddress=$_POST['report_organizationaddress'];
$report_organizationcontacts=$_POST['report_organizationcontacts'];
$smtpserver=$_POST['smtpserver'];
$smtpuser=$_POST['smtpuser'];
$smsurl=$_POST['smsurl'];
$smsid=$_POST['smsid'];
$smspassword=$_POST['smspassword'];
$smssender_name=$_POST['smssender_name'];
$urlchecksmsbalance=$_POST['urlchecksmsbalance'];
$smtppassword=$_POST['smtppassword'];
$senderuser=$_POST['senderuser'];
$tokenlife=$_POST['tokenlife'];
$pausetime=$_POST['pausetime'];
$loglevel=$_POST['loglevel'];
$logfile=$_POST['logfile'];
$windowsettingautosave=$_POST['windowsettingautosave'];
$nitobigridthemes=$_POST['nitobigridthemes'];
$nitobicombothemes=$_POST['nitobicombothemes'];
$selectspliter=$_POST['selectspliter'];
$allowbrowser=$_POST['allowbrowser'];
$sendsmsgroup=$_POST['sendsmsgroup'];
$uploadpath=$_POST['uploadpath'];
$supportbrowserurl="http://www.simit.com.my/?q=supportbrowser";
$approve_id=$_POST['approve_id'];
/*
if(PHP_OS=='WINNT'){


system("echo ^<?php > ../setting.php");
system("echo \$report_organizationname=\"$report_organizationname\";>> ../setting.php");
system("echo \$report_organizationaddress=\"$report_organizationaddress\";>> ../setting.php");
system("echo \$report_organizationcontacts=\"$report_organizationcontacts\";>> ../setting.php");
system("echo \$smtpserver=\"$smtpserver\";>> ../setting.php");
system("echo \$smtpuser=\"$smtpuser\";>> ../setting.php");
system("echo \$smsurl=\"$smsurl\";>> ../setting.php");
system("echo \$smsid=\"$smsid\";>> ../setting.php");
system("echo \$smspassword=\"$smspassword\";>> ../setting.php");
system("echo \$smssender_name=\"$smssender_name\";>> ../setting.php");
system("echo \$urlchecksmsbalance=\"$urlchecksmsbalance\";>> ../setting.php");
system("echo \$smtppassword=\"$smtppassword\";>> ../setting.php");
system("echo \$senderuser=\"$senderuser\";>> ../setting.php");
system("echo \$tokenlife=\"$tokenlife\";>> ../setting.php");
system("echo \$pausetime=\"$pausetime\";>> ../setting.php");
system("echo \$loglevel=\"$loglevel\";>> ../setting.php");
system("echo \$logfile=\"$logfile\";>> ../setting.php");
system("echo \$windowsettingautosave=\"$windowsettingautosave\";>> ../setting.php");
system("echo \$nitobigridthemes=\"$nitobigridthemes\";>> ../setting.php");
system("echo \$nitobicombothemes=\"$nitobicombothemes\";>> ../setting.php");
system("echo \$logfile=\"$logfile\";>> ../setting.php");
system("echo  ?^> >> ../setting.php");
}else{*/
system("echo '<?php' > ../setting.php");
system("echo '\$report_organizationname=\"$report_organizationname\";'>> ../setting.php");
system("echo '\$report_organizationaddress=\"$report_organizationaddress\";'>> ../setting.php");
system("echo '\$report_organizationcontacts=\"$report_organizationcontacts\";'>> ../setting.php");
system("echo '\$smtpserver=\"$smtpserver\";'>> ../setting.php");
system("echo '\$smtpuser=\"$smtpuser\";'>> ../setting.php");
system("echo '\$smsurl=\"$smsurl\";'>> ../setting.php");
system("echo '\$smsid=\"$smsid\";'>> ../setting.php");
system("echo '\$smspassword=\"$smspassword\";'>> ../setting.php");
system("echo '\$smssender_name=\"$smssender_name\";'>> ../setting.php");
system("echo '\$urlchecksmsbalance=\"$urlchecksmsbalance\";'>> ../setting.php");
system("echo '\$smtppassword=\"$smtppassword\";'>> ../setting.php");
system("echo '\$senderuser=\"$senderuser\";'>> ../setting.php");
system("echo '\$tokenlife=\"$tokenlife\";'>> ../setting.php");
system("echo '\$pausetime=\"$pausetime\";'>> ../setting.php");
system("echo '\$loglevel=\"$loglevel\";'>> ../setting.php");
system("echo '\$logfile=\"$logfile\";'>> ../setting.php");
system("echo '\$windowsettingautosave=\"$windowsettingautosave\";'>> ../setting.php");
system("echo '\$nitobigridthemes=\"$nitobigridthemes\";'>> ../setting.php");
system("echo '\$nitobicombothemes=\"$nitobicombothemes\";'>> ../setting.php");
system("echo '\$selectspliter=\"$selectspliter\";'>> ../setting.php");

if(get_magic_quotes_gpc()){
$allowbrowser=str_replace("\"","",$allowbrowser);
}

if($allowbrowser!="")
system("echo '\$allowbrowser={$allowbrowser};'>> ../setting.php");
else
system("echo '\$allowbrowser=array();'>> ../setting.php");

system("echo '\$sendsmsgroup=\"$sendsmsgroup\";'>> ../setting.php");
system("echo '\$uploadpath=\"$uploadpath\";'>> ../setting.php");

system("echo '?>'>> ../setting.php");
//}
//echo "/****************<br>This is writing event <br>*********/";
}

include "../setting.php";
$aligncenter=" style='text-align:center' ";

$allowbrowsertext="array(";
$i=0;
foreach($allowbrowser as $ab){
    $allowbrowsertext.='"'.$ab.'",';
    $i++;
}

if($i>0)
$allowbrowsertext=substr($allowbrowsertext,0 ,-1);

$approve_ctrl = $ctrl->getSelectWorkflowStatus($approve_id,'Y');
$allowbrowsertext.=")";
$b=$_SERVER['HTTP_USER_AGENT'];
echo <<< EOF
	<A href='index.php'>Back To This Module Administration Menu</A>
<table border='1'>
<form method="POST" onsubmit="return confirm('Change setting? It will effect the refresh time and email services in SIMEDU.')">
<tr><th style='text-align:center'>Parameter</th><th style='text-align:center'>Value</th></tr>
<tr><td class='head' $aligncenter>Report Organization Name</td>
	<td class='odd' $aligncenter><input name="report_organizationname" value="$report_organizationname" size="70"></td></tr>
<tr><td class='head' $aligncenter>Report Organization Address</td>
	<td class='odd' $aligncenter><input name="report_organizationaddress" value="$report_organizationaddress" size="70"></td></tr>
<tr><td class='head' $aligncenter>Report Organization Contacts</td>
	<td class='odd' $aligncenter><input name="report_organizationcontacts" value="$report_organizationcontacts" size="70"></td></tr>
<tr><td class='head' $aligncenter>SMTP Server:Port</td>
	<td class='odd' $aligncenter><input name="smtpserver" value="$smtpserver" size="70"></td></tr>
<tr><td class='head' $aligncenter>SMTP User</td>
	<td class='odd' $aligncenter><input name="smtpuser" value="$smtpuser" size="70"></td></tr>
<tr><td class='head' $aligncenter>SMS Url</td>
	<td class='odd' $aligncenter><input name="smsurl" value="$smsurl" size="70"></td></tr>
<tr><td class='head' $aligncenter>SMS ID</td>
	<td class='odd' $aligncenter><input name="smsid" value="$smsid"></td></tr>
<tr><td class='head' $aligncenter>SMS Password</td>
	<td class='odd' $aligncenter><input name="smspassword" value="$smspassword"></td></tr>
<tr><td class='head' $aligncenter>SMS Sender Name</td>
	<td class='odd' $aligncenter><input name="smssender_name" value="$smssender_name" size="70"></td></tr>
<tr><td class='head' $aligncenter>URL Check SMS Balance</td>
	<td class='odd' $aligncenter><input name="urlchecksmsbalance" value="$urlchecksmsbalance" size="70"></td></tr>
<tr><td class='head' $aligncenter>SMTP Password</td>
	<td class='odd' $aligncenter><input name="smtppassword" value="$smtppassword"></td></tr>
<tr><td class='head' $aligncenter>SMTP Sender User</td>
	<td class='odd' $aligncenter><input name="senderuser" value="$senderuser"></td></tr>
<tr><td class='head' $aligncenter>Token Life</td>
	<td class='odd' $aligncenter><input name="tokenlife" value="$tokenlife"></td></tr>
<tr><td class='head' $aligncenter>Pause Time</td>
	<td class='odd' $aligncenter><input name="pausetime" value="$pausetime"></td></tr>
<tr><td class='head' $aligncenter>Log Level</td>
	<td class='odd' $aligncenter><input name="loglevel" value="$loglevel"></td></tr>
<tr><td class='head' $aligncenter>Log File</td>
	<td class='odd' $aligncenter><input name="logfile" value="$logfile" size="70"></td></tr>
<tr><td class='head' $aligncenter>Window Setting Auto Save</td>
	<td class='odd' $aligncenter><input name="windowsettingautosave" value="$windowsettingautosave"></td></tr>
<tr><td class='head' $aligncenter>Nitobi Grid Themes</td>
	<td class='odd' $aligncenter><input name="nitobigridthemes" value="$nitobigridthemes"></td></tr>
<tr><td class='head' $aligncenter>Nitobi Combo Themes</td>
	<td class='odd' $aligncenter><input name="nitobicombothemes" value="$nitobicombothemes"></td></tr>
<tr><td class='head' $aligncenter>Selection Spliter (Developer only)</td>
	<td class='odd' $aligncenter><input name="selectspliter" value="$selectspliter"></td></tr>
<tr><td class='head' $aligncenter>Allow Browser (Developer only)</td>
	<td class='odd' $aligncenter><textarea name="allowbrowser" cols="40" rows="3">$allowbrowsertext</textarea><br/>
		* array() for support all browser, define array("Firefox/3.6") will support all firefox 3.6</td></tr>

<tr><td class='head' $aligncenter>Send SMS Group Name</td>
	<td class='odd' $aligncenter><input name="sendsmsgroup" value="$sendsmsgroup"></td></tr>
<tr><td class='head' $aligncenter>Upload Path</td>
	<td class='odd' $aligncenter><input name="uploadpath" value="$uploadpath"></td></tr>

<tr><td class='head'  style='text-align:center'>Approve Complete Status</td>
		<td class='odd'  style='text-align:center'><select name="approve_id">$approve_ctrl</select></td></tr>
<tr><td><input type="reset" name="reset" value="reset"></td>
<td><input type="submit" name="savesetting" value="Save">
</td></tr>
</form>
</table>
EOF;
xoops_cp_footer();
?>


<?php
include_once "system.php";
include_once "menu.php";
$tablestudent=$tableprefix."simtrain_student";
$tableparents=$tableprefix."simtrain_parents";
$smtpuser='kstan@simit.com.my';
$smtppassword='tks521';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

if($_POST['emailtext']){

	include_once "Mail.php";
	$msg=$_POST['emailtext'];
//	if($_POST['studentemlist']<>"" && $_POST['studentemlist']<>" ")

		$studentemlist=$_POST['studentemlist'];
		$parentsemlist=$_POST['parentsemlist'];
		$parentsemlist2=$_POST['parentsemlist2'];

	//remove unwanted string
	while(substr($studentemlist,-1)==" " || substr($studentemlist,-1)=="," ||  substr($studentemlist,-1)=="\n"){
		if( substr($studentemlist,-1)==",")
		$studentemlist=substr_replace( $studentemlist,"",-1);
		else
		$studentemlist=chop($studentemlist);
	}

		$receipient=$studentemlist;


	//remove unwanted string
		while(substr($parentsemlist,-1)==" " || substr($parentsemlist,-1)=="," ||  substr($parentsemlist,-1)=="\n"){
		if( substr($parentsemlist,-1)==",")
		$parentsemlist=substr_replace( $parentsemlist,"",-1);
		else
		$parentsemlist=chop($parentsemlist);
		}
		if(strlen($receipient)>0 && strlen($parentsemlist)>0)
			$receipient=$receipient.",".$parentsemlist;

	//remove unwanted string
		while(substr($parentsemlist2,-1)==" " || substr($parentsemlist2,-1)=="," ||  substr($parentsemlist2,-1)=="\n"){
		if( substr($parentsemlist2,-1)==",")
		$parentsemlist2=substr_replace( $parentsemlist2,"",-1);
		else
		$parentsemlist2=chop($parentsemlist2);
	}
	if(strlen($receipient)>0 && strlen($parentsemlist2)>0)
			$receipient=$receipient.",".$parentsemlist2;

	$j=0;


	$subject = $_POST['subject'];
		//$subject="asdkjashdkj";
		
		$headers = array ('Subject' => $subject,'From' => $senderuser,
		'To' => $receipient);
		$smtp = Mail::factory('smtp',
		array ('host' => "$smtpserver",
		'auth' => true,
		'username' => $smtpuser,
		'password' => $smtppassword));
		
		$mail = $smtp->send($receipient, $headers, $msg);
		
		if (PEAR::isError($mail)) {
		echo("<p>" . $mail->getMessage() . "</p>");
		} else {
		echo("<p>Message sent! click <a href='index.php'>here</a> for back to home.</p> The receipient as below:<br>$receipient");
		}

	//echo "email is send.";
}
elseif(isset($_POST['isselect'])){

$isselect = $_POST['isselect'];
$arr_studentid = $_POST['studentid_address'];
$i=1;
$studentlist_id="";
//echo "input=$isselect,$arr_studentid<br>";
echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">
	HP No List</span></big></big></big></div><br>

EOF;

foreach ($arr_studentid as $id){
	if($isselect[$i]=="on")
		$studentlist_id=$studentlist_id."$id,";

$i++;
}
$studentlist_id=substr_replace($studentlist_id,"",-1);
$sqlstudent="SELECT student_name,email FROM $tablestudent where student_id in ($studentlist_id)
		AND email <> '-' AND email <>' ' AND email <> ''";
$sqlparents="SELECT a.parents_id,p.parents_name,parents_name2,p.parents_email,p.parents_email2 FROM
		(SELECT distinct(p.parents_id) as parents_id FROM $tablestudent s 
		inner join  $tableparents p on s.parents_id=p.parents_id
		where s.student_id in ($studentlist_id)) a
		INNER JOIN $tableparents p on a.parents_id=p.parents_id
		WHERE p.parents_email <>'' AND p.parents_email <>'-' AND p.parents_email <> ' '";

//echo $sqlstudent."<br>";
//echo $sqlparents."<br>";
$qrystudent=$xoopsDB->query($sqlstudent);
$qryparents=$xoopsDB->query($sqlparents);
$textareastudent="<textarea name='studentemlist' cols='30' rows='15'>";
$studentcount=0;
while($row=$xoopsDB->fetchArray($qrystudent)){
$email=$row['email'];

if( strlen($email) >= 3 && substr_count($email,'.') >=1 && substr_count($email,'@') ==1)
$textareastudent=$textareastudent.$email.",\n";

$studentcount++;
}
//$textareastudent=substr_replace($textareastudent,"",-2);
$textareastudent=$textareastudent."</textarea>";


$textareaparents="<textarea name='parentsemlist' cols='30' rows='15'>";
$textareaparents2="<textarea name='parentsemlist2' cols='30' rows='15'>";

$parentscount=0;
while($row=$xoopsDB->fetchArray($qryparents)){
$parents_name=$row['parents_name'];
$parents_name2=$row['parents_name2'];
$parents_email=$row['parents_email'];
$parents_email2=$row['parents_email2'];

if( strlen($parents_email) >= 3 && substr_count($parents_email,'.') >=1 && substr_count($parents_email,'@') ==1)
$textareaparents=$textareaparents."$parents_email,\n";

if( strlen($parents_email2) >= 3 && substr_count($parents_email2,'.') >=1 && substr_count($parents_email2,'@') ==1)
	$textareaparents2=$textareaparents2."$parents_email2,\n";

$parentscount++;
}
//$textareaparents=substr_replace($textareaparents,"",-2);
//$textareaparents2=substr_replace($textareaparents2,"",-2);
$textareaparents=$textareaparents."</textarea>";
$textareaparents2=$textareaparents2."</textarea>";

echo <<< EOF
<script type='text/javascript'>
function cleartext(type){
switch(type){
	case 1:
		document.frmEmail.studentemlist.value="";
	break;
	case 2:
		document.frmEmail.parentsemlist.value="";
	break;
	case 3:
		document.frmEmail.parentsemlist2.value="";
	break;
	}
}

//function checktext(){
//document.frmEmail.textlength.value=document.frmEmail.smstext.value.length + "/160";
//}
</script>

<table width='10%'> <tr><form name='frmEmail' onsubmit='return confirm("Send this email?");' method="POST">
	<td><input type='button' name='clearsemail' value='[clear]' onclick='cleartext(1)'><br>Student Email($studentcount)<br>$textareastudent </td>
	<td><input type='button' name='cpemail' value='[clear]' onclick='cleartext(2)'><br>Parents Email($parentscount)<br>$textareaparents</td>
	<td><input type='button' name='cpemail2' value='[clear]' onclick='cleartext(3)'><br>Parents Email 2<br>$textareaparents2</td>
	</tr>
	<tr><td colspan='3'>Subject: <input name='subject' size='50' maxlength='50'></td></tr>
	<tr><td colspan='3'><textarea name='emailtext' cols='100' rows='10' ></textarea></td></tr>
	</table>
	<input type='reset' name='reset' value='reset'>
	<input type='submit' name='submit' value='submit'>

	</form>
</td>
EOF;
}
else{
$log->showLog(1,"Warning! Does not receive any parameter from previous POST, please close this window and perform previous process again.");}

require(XOOPS_ROOT_PATH.'/footer.php');


?>

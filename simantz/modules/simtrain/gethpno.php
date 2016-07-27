<?php
include_once "system.php";
include_once "menu.php";
$tablestudent=$tableprefix."simtrain_student";
$tableparents=$tableprefix."simtrain_parents";

$isselect = $_POST['isselect'];
$arr_studentid = $_POST['studentid_address'];
$i=1;
$studentlist_id="";
//echo "input=$isselect,$arr_studentid<br>";
echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">
	HP No List</span></big></big></big></div><br>
<b>* Every number seperated by ','.</b><br>
<b>* Do not remove ',' behind last number in each text area.</b><br>
<b>* Overlaped number will be removed.</b><br>
EOF;

foreach ($arr_studentid as $id){
	if($isselect[$i]=="on")
		$studentlist_id=$studentlist_id."$id,";

$i++;
}
$studentlist_id=substr_replace($studentlist_id,"",-1);
$sqlstudent="SELECT student_name,hp_no FROM $tablestudent where student_id in ($studentlist_id)
		AND hp_no <> '-' AND hp_no <>' ' AND hp_no <> ''";
$sqlparents="SELECT a.parents_id,p.parents_name,p.parents_contact,p.parents_contact2 FROM
		(SELECT distinct(p.parents_id) as parents_id FROM $tablestudent s 
		inner join  $tableparents p on s.parents_id=p.parents_id
		where s.student_id in ($studentlist_id)) a
		INNER JOIN $tableparents p on a.parents_id=p.parents_id
		WHERE p.parents_contact <>'' AND p.parents_contact <>'-' AND p.parents_contact <> ' '";

//echo $sqlstudent."<br>";
//echo $sqlparents."<br>";
$qrystudent=$xoopsDB->query($sqlstudent);
$qryparents=$xoopsDB->query($sqlparents);
$textareastudent="<textarea name='studenthplist' cols='15' rows='15'>";
$studentcount=0;
while($row=$xoopsDB->fetchArray($qrystudent)){
$hp_no=$row['hp_no'];

$removestring=array("(", ")", "-", " ",",");
$hp_no=str_replace($removestring,  "",$hp_no);

if(strlen($hp_no)==10 && substr($hp_no,0,1 )=="0")
$hp_no="6".$hp_no ;
elseif(strlen($hp_no)==9 && substr($hp_no,0,1)=="1")
$hp_no="60".$hp_no;
elseif(strlen($hp_no)!=12)
$hp_no="";

//if($hp_no!="-" && $hp_no!=" " && $hp_no!= "-"&& $hp_no!= "\0" && strlen($hp_no)==11)
$textareastudent=$textareastudent.$hp_no.",\n";
$studentcount++;
}
$textareastudent=$textareastudent."</textarea>";
$textareaparents="<textarea name='parentshplist' cols='15' rows='15'>";
$textareaparents2="<textarea name='parentshplist2' cols='15' rows='15'>";

$parentscount=0;
while($row=$xoopsDB->fetchArray($qryparents)){
$parents_contact=$row['parents_contact'];
$parents_contact2=$row['parents_contact2'];

$removestring=array("(", ")", "-", " ", ",");
$parents_contact=str_replace($removestring,  "",$parents_contact);
$parents_contact2=str_replace($removestring,  "",$parents_contact2);

if(strlen($parents_contact)==10 && substr($parents_contact,0,1 )=="0")
$parents_contact="6".$parents_contact ;
elseif(strlen($parents_contact)==9 && substr($parents_contact,0,1)=="1")
$parents_contact="60".$parents_contact;
elseif(strlen($parents_contact)!=12)
$parents_contact="";


if(strlen($parents_contact2)==10 && substr($parents_contact2,0,1 )=="0")
$parents_contact2="6".$parents_contact2 ;
elseif(strlen($parents_contact2)==9 && substr($parents_contact2,0,1)=="1")
$parents_contact2="60".$parents_contact2;
elseif(strlen($parents_contact2)!=12)
$parents_contact2="";

if($parents_contact!="-" && $parents_contact!=" " && $parents_contact!= "-"&& $parents_contact2!= "\0" && strlen($parents_contact)==11)
$textareaparents=$textareaparents.$parents_contact.",\n";

if($parents_contact2!="-" && $parents_contact2!=" " && $parents_contact2!= "" && $parents_contact2!= "\0" && strlen($parents_contact2)==11)
$textareaparents2=$textareaparents2.$parents_contact2.",\n";

$parentscount++;
}

$textareaparents=$textareaparents."</textarea>";
$textareaparents2=$textareaparents2."</textarea>";

echo <<< EOF
<script type='text/javascript'>
function cleartext(type){
switch(type){
	case 1:
		document.frmHP.studenthplist.value="";
	break;
	case 2:
		document.frmHP.parentshplist.value="";
	break;
	case 3:
		document.frmHP.parentshplist2.value="";
	break;
	}
}

function checktext(){
var lang=document.frmHP.lang_type.value;
if(lang=='E')
document.frmHP.textlength.value=document.frmHP.msg.value.length + "/160";
else
document.frmHP.textlength.value=document.frmHP.msg.value.length * 2 + "/160";

}
</script>
<table width='10%'> <tr><form name='frmHP' onsubmit='return confirm("Send SMS?");' action='sendsms.php' method='POST'>
	<td><input type='button' name='clearshp' value='[clear]' onclick='cleartext(1)'><br>Student HP($studentcount)<br>$textareastudent </td>
	<td><input type='button' name='cphp' value='[clear]' onclick='cleartext(2)'><br>Parents Contact($parentscount)<br>$textareaparents</td>
	<td><input type='button' name='cphp2' value='[clear]' onclick='cleartext(3)'><br>Parents Contact2<br>$textareaparents2</td>
	</tr>
	<tr><td colspan='3'><textarea name='msg' cols='70' row='4' 
		lostfocus='checktext()' onchange='checktext()' onkeypress='checktext()'></textarea><br>
	Word count<input readonly='readonly' name='textlength' value='0/160'>
	<select name='lang_type'>
		<option value='E'>English(Standard)</option>
		<option value='C'>Chinese(Unicode->Double space)</option>
	</select><br>
	<b>* If text more than 160 character, it will continue at 2nd sms.</b><br>
	</td></tr></table>
	<input type='reset' name='reset' value='reset'>
	<input type='submit' name='submit' value='submit'>

	</form>
</td>
EOF;

require(XOOPS_ROOT_PATH.'/footer.php');


?>
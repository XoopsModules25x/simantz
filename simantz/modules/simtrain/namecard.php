<?php
include_once "system.php";
include_once "menu.php";

include_once "class/Student.php";
include_once "class/RegClass.php";
include_once "class/Log.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$s = new Student($xoopsDB,$tableprefix,$log);
$c = new RegClass($xoopsDB,$tableprefix,$log);
$student_id=$_POST['student_id'];
$tablestudent=$s->tablestudent;
$tablestandard=$tableprefix."simtrain_standard";
$tablestudentclass=$c->tablestudentclass;

$sql="SELECT s.student_code, s.student_name,std.standard_name as standard from $tablestudent s inner join $tablestandard std on std.standard_id=s.standard_id WHERE student_id=$student_id";
$query=$s->xoopsDB->query($sql);
if ($row=$s->xoopsDB->fetchArray($query))
$student_code=$row['student_code'];
$student_name=$row['student_name'];
$std_form=$row['standard'];

$sql="SELECT std_form from $tablestudentclass WHERE student_id=$student_id";
$query=$s->xoopsDB->query($sql);
while ($row=$s->xoopsDB->fetchArray($query)){
$std_form=$row['std_form'];}

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Print Student Name Card</span></big></big></big></div><br>
<table style="text-align: left; width: 577px; height: 400px;"
 border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td style="height: 165px;"><img
 style="height: 157px; width: 577px;" alt=""
 src="./images/namecard.jpg"></td>
    </tr>
    <tr style="color: rgb(0, 0, 102);" align="center">
      <td style="font-size: 20px; height: 32px;"><span
 style="font-family: Helvetica,Arial,sans-serif;">Pusat
&nbsp;Tuisyen&nbsp; Visi&nbsp; Kota &nbsp;07-8835754,
&nbsp;8836754</span></td>
    </tr>
    <tr style="color: rgb(0, 0, 102);" align="center">
      <td style="font-size: 20px; height: 32px;"><span
 style="font-family: Helvetica,Arial,sans-serif;">Pusat
&nbsp;Tuisyen&nbsp; Visi&nbsp; Jaya&nbsp; 07-8824754,
&nbsp;8838754</span></td>
    </tr>
    <tr align="center">
      <td style="height: 70px;"><big><big><big><span
 style="font-family: Helvetica,Arial,sans-serif;"></span></big></big></big>
      <table
 style="border: 1px solid rgb(0, 0, 153); color: white; width: 338px; height: 56px; text-align: center; margin-left: auto; margin-right: auto;"
 border="1" cellpadding="2" cellspacing="5">
        <tbody>
          <tr>
            <td
 style="text-align: center; vertical-align: middle; background-color: rgb(0, 0, 153);"><big><big><big><span
 style="font-family: Helvetica,Arial,sans-serif; font-weight: bold;">Kad&nbsp;
Pelajar &nbsp;<span
 style="font-family: serif; font-weight: bold; vertical-align: middle;">学
生卡</span></span></big></big></big></td>
          </tr>
        </tbody>
      </table>
      <big><big><big><span
 style="font-family: Helvetica,Arial,sans-serif;"><span
 style="font-family: serif; font-weight: bold;"></span></span></big></big></big></td>
    </tr>
    <tr>
      <td>
      <table
 style="width: 100%; text-align: left; margin-left: auto; margin-right: auto;"
 border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr style="color: rgb(0, 0, 102);">
            <td style="width: 200px; height: 25px;"><span
 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px;">Nama&nbsp;
Pelajar</span></td>
            <td colspan="1" rowspan="2"
 style="text-align: center; vertical-align:middle; font-weight: bold; font-size: 24px; border-bottom: 1px solid rgb(0, 0, 153); width: 400px; height: 50px;">$student_name</td>
          </tr>
          <tr style="color: rgb(0, 0, 102); font-size: 18px;">
            <td style="width: 200px; height: 25px;">学生姓名 ：</td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
    <tr>
      <td>
      <table
 style="width: 100%; height: 50px; text-align: left; margin-left: auto; margin-right: auto;"
 border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr style="color: rgb(0, 0, 102);">
            <td style="height: 25px; width: 120px;"><span
 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px;">Drj/Tkt</span></td>
            <td
 style="text-align: center; vertical-align:middle; font-weight: bold; font-size: 24px; border-bottom: 1px solid rgb(0, 0, 153); width: 180px;"
 colspan="1" rowspan="2">$std_form</td>
            <td style="height: 25px; width: 120px;"><span
 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px;">No.
Ruj</span></td>
            <td
 style="text-align: center; vertical-align:middle; font-weight: bold; font-size: 24px; border-bottom: 1px solid rgb(0, 0, 153); width: 180px;"
 colspan="1" rowspan="2">$student_code</td>
          </tr>
          <tr style="font-family: UTF-8; color: rgb(0, 0, 102);font-size: 18px;">
            <td style="height: 25px; width: 120px;">年级 /
学年 :</td>
            <td>学生编号 :</td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
  </tbody>
</table><br>
<table style="width:180px;">
	<tbody>
	<tr>
	<td><form action="student.php" method="post"><input style="height:40px;" type='submit' value='Back to Record' name='submit'><input type='hidden' value='$student_id' name='student_id'><input type='hidden' value='edit' name='action'></form></td>
	<td><form action="printnamecard.php" method="post" target="_blank"><input style="height:40px;" type='submit' value='Print (Use Pre-printed Paper)' name='submit'><input type='hidden' value='$student_id' name='student_id'></td>
	</tr>
	</tbody>
</form>


EOF;
require(XOOPS_ROOT_PATH.'/footer.php');
?>

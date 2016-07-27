<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
class RegAttendance{
  public $regattendance_id;
  public $studentclass_id;
  public $tuitionclass_code;
  public $description;
  public $student_id; 
  public $student_code; 
  public $starttime;
  public $showcalendar;
  public $schedule_id;
  public $day_no;
  public $created;
  public $createdby;
  public $updated; 
  public $updatedby;
  public $attendance_date;
  public $attendance_time;
  public $orgctrl;
  public $organization_id;

  public $log;
  public $xoopsDB;
  public $tableprefix;
  public $tablestudent;
  public $tableorganization;
  public $tabletuitionclass;
  public $tableregattendance;
  public $tableclassschedule;
  public $tablestudentclass;
  public $tableperiod;

 public function RegAttendance($xoopsDB, $tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tableperiod=$tableprefix . "simtrain_period";
	$this->tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
	$this->tablestudentclass=$tableprefix . "simtrain_studentclass";
	$this->tablestudent=$tableprefix."simtrain_student";
	$this->tableregattendance=$tableprefix . "simtrain_regattendance";
	$this->tableclassschedule=$tableprefix."simtrain_classschedule";
	$this->tableattendance=$tableprefix."simtrain_attendance";
	$this->log=$log;
   }


 public function getInputForm() {

    	$header=""; // parameter to display form header
	$action="";
	$orgctrl="";
	$this->created=0;
	
    echo <<< EOF
<script language="Javascript">
setInterval("settime()", 1000);

function settime () {
  var curtime = new Date();
  var curhour = curtime.getHours();
  var curmin = curtime.getMinutes();
  var cursec = curtime.getSeconds();
  var time = "";

  time = (curhour < 10 ? "0" : "") + curhour + ":" +
         (curmin < 10 ? "0" : "") + curmin + ":" +
         (cursec < 10 ? "0" : "") + cursec;
if(document.regattendance.statictime.checked==false)
  document.regattendance.attendance_time.value = time;
}

function validateform(){
var id=document.regattendance.student_id.value;
var code=document.regattendance.student_code.value;

if(id==0 && code==""){
alert('You must type a student code or choose a student.');
return false;

}
else
return true;
}
</script>

<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Student Attendance Registration</span></big></big></big></div><br>-->
<form name='regattendance' method='POST' onsubmit='return validateform()'>
<table>
  <tbody>
    <tr>
      <th colspan='4'>Registration Form</th>
    </tr>
    <tr>

      <td class='head'>Organization</td>
      <td class='odd'>$this->orgctrl</td>
      <td class='head'>Date</td>
      <td class='odd'>
	<input name='attendance_date' id='attendance_date' value='$this->attendance_date' readonly='readonly'>
	<input type='button' name='btnDate' value='Date' onclick="$this->showcalendar">
	<input name='attendance_time' value='$this->attendance_time' >Time Stop
	<input name='statictime' type='checkbox' >

</td>
    </tr>
    <tr>
     <td class='head'>Student Code</td>
      <td class='even'><input name='student_code' value='$this->student_code'></td>
      <td class='head'>Student Name</td>
      <td class='even'>$this->studentctrl</td>
    </tr>
    <tr>
      <td class='foot' colspan='4'>
	<input type='hidden' name='action' value='create'>
	<input type='submit' name='submit' value='submit'></td>
    </tr>

  </tbody>
</table>

</form>

EOF;
  }


public function getSQLString($wherestring,$orderbystring){
$this->log->showLog(3,"Call getSQLString in RegAttendance");
$sql="SELECT att.regattendance_id, s.student_id,s.student_code, s.student_name, s.alternate_name, att.attendance_date, att.attendance_time, 		t.tuitionclass_code, t.description FROM $this->tableregattendance att
	INNER JOIN $this->tablestudentclass x on x.studentclass_id=att.studentclass_id
	INNER JOIN $this->tabletuitionclass t on x.tuitionclass_id=t.tuitionclass_id
	INNER JOIN $this->tablestudent s on s.student_id=att.student_id $wherestring $orderbystring";
$this->log->showLog(4,"With SQL: ".$sql);
return $sql;
	
}

public function insertAttendance(){
	$this->log->showLog(3,"Saving attendance.");
		$timestamp= date("y/m/d H:i:s", time()) ;
	$sqlattendance="INSERT INTO $this->tableregattendance (studentclass_id, student_id, schedule_id, 
			created, createdby, updated, updatedby, attendance_date, 
			attendance_time, organization_id) VALUES('$this->studentclass_id', 
			'$this->student_id', '$this->schedule_id', '$timestamp', '$this->createdby', 
			'$timestamp', '$this->updatedby', '$this->attendance_date', '$this->attendance_time', 
			'$this->organization_id')";
	$timectrl="time" . $this->day_no;

	$sqldeltime="DELETE FROM $this->tableattendance where student_id=$this->student_id and 
			schedule_id=$this->schedule_id";
	$sqlinserttime="INSERT INTO $this->tableattendance (student_id,schedule_id,attendance_time,
		created,updated,createdby,updatedby) value 
		($this->student_id,$this->schedule_id, '$this->attendance_time',
		'$timestamp','$timestamp', '$this->updatedby', '$this->updatedby')";

	$this->log->showLog(4,"With SQL1: $sqlattendance.");
	$this->log->showLog(4,"With SQL2: $sqldeltime.");
	$this->log->showLog(4,"With SQL3: $sqlinserttime.");
	$query1=$this->xoopsDB->query($sqlattendance);
	$query2=$this->xoopsDB->query($sqldeltime);
	$query3=$this->xoopsDB->query($sqlinserttime);

	
	return true;

 }

public function emptyAttendance(){
$this->log->showLog(2,"Warning: Performing empty attendance!");
$sql="DELETE FROM  $this->tableregattendance";
$this->log->showLog(4,"With SQL $sql");
$query=$this->xoopsDB->query($sql);
if($query)
 return true;
else
  return false;

}

public function deleteAttendance($regattendance_id){
	$this->log->showLog(2,"Warning: Performing delete attendance id : $regattendance_id!");


	$sql="SELECT student_id,schedule_id from $this->tableregattendance WHERE regattendance_id=$regattendance_id";
	$this->log->showLog(3,"With SQL0: $sql");
	$query=$this->xoopsDB->query($sql);
	$timectrl="time";
	$studentclass_id=0;
	if($row=$this->xoopsDB->fetchArray($query)){
		$timectrl=$timectrl;
		$schedule_id=$row['schedule_id'];
		$student_id=$row['student_id'];
	}
	$sqldeltime="DELETE FROM $this->tableattendance where student_id=$student_id and 
			schedule_id=$schedule_id";	
	$sqldelete="DELETE FROM $this->tableregattendance where regattendance_id=$regattendance_id";
	$this->log->showLog(3,"With SQL1: $sqldeltime");
	$this->log->showLog(3,"With SQL2: $sqldelete");
	$rsemptytime=$this->xoopsDB->query($sqldeltime);
	$rsdeleteattendance=$this->xoopsDB->query($sqldelete);
	if($rsemptytime && $rsdeleteattendance)
		return true;
	else
		return false;
	
}


  public function showAttendanceTable($wherestring,$orderbystring){

	$sql=$this->getSQLString($wherestring,$orderbystring);

echo <<< EOF
<table border='1'>
  <tbody>
  <tr>
      <th colspan="8">Active Attendance</th>
    </tr>
    <tr>
      <th>No</td>
      <th>Student Index</th>
      <th>Student Name</th>
      <th>Date</th>
      <th>Time</th>
      <th>Class</th>
      <th>Zoom</th>
    </tr>
EOF;
$query=$this->xoopsDB->query($sql);
$i=0;
while($row=$this->xoopsDB->fetchArray($query)){
	$student_id=$row['student_id'];
	$student_code=$row['student_code'];
	$student_name=$row['student_name'];
	$alternate_name=$row['alternate_name'];
	$attendance_date=$row['attendance_date'];
	$attendance_time=$row['attendance_time'];
	$tuitionclass_code=$row['tuitionclass_code'];
	$regattendance_id=$row['regattendance_id'];
	$description=$row['description'];
	$i++;
 	$delctrl="<form method='POST' action='regattendance.php' onsubmit='return confirm(\"Delete this attendance? The attendance report no longer show this student attend the class at this day, even though previous attendance record exist.\")'>
		<input type='submit' value='Delete' name='submit'>
		<input type='hidden' name='action' value='delete'>
		<input type='hidden' name='regattendance_id' value='$regattendance_id'>
			</form>";
	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";
	echo <<< EOF
	<tr>
		<td class="$rowtype" style="text-align:center">$i</td>
		<td class="$rowtype" style="text-align:center"><a href=student.php?student_id=$student_id&action=edit>$student_code</a></td>
		<td class="$rowtype" style="text-align:center">$student_name / $alternate_name</td>
		<td class="$rowtype" style="text-align:center">$attendance_date</td>
		<td class="$rowtype" style="text-align:center">$attendance_time</td>
		<td class="$rowtype" style="text-align:center">$tuitionclass_code / $description</td>
		<td class="$rowtype" style="text-align:center">$delctrl</td>
	</tr>
	
	
EOF;
   }
echo <<<EOF
<tr>
<td>
<form method="POST" action="regattendance.php" onsubmit="return confirm('Confirm to empty the history? The existing attendance will not effected by this activity');">
<input type="submit" value="Empty History" name="submit">
<input type="hidden" name="action" value="empty">
</form>
</td>
</tr>
</tbody>
	</table>
EOF;
  }

  public function prepareData($student_code,$student_id,$attendance_date,$attendance_time,$organization_id){
	//return 1=autoconfigure, 0= student or time not match, 2=conflic found, user shall choose class manually
	
	$attendance_day=substr($attendance_date, 8, 2);
		
	if($attendance_day <=7 && $attendance_day>=1)
		$this->day_no=1;
	elseif($attendance_day <= 14)
		$this->day_no=2;
	elseif($attendance_day <= 21)
		$this->day_no=3;
	elseif($attendance_day <= 28)
		$this->day_no=4;
	else
		$this->day_no=5;
	
	$this->log->showLog(3,"preparing data with attendance_date: $attendance_day for insert into attendance");

	$studenctrl="";
	if($student_code!=""){
		$sql="SELECT student_id FROM $this->tablestudent WHERE student_code='$student_code'";
		$this->log->showLog(4,"Search Student Id with SQL:$sql");
		$query=$this->xoopsDB->query($sql);
	
		if($row=$this->xoopsDB->fetchArray($query)){
			$studenctrl="sc.student_id=".$row['student_id']."";
			$this->student_id=$row['student_id'];
		}
		else
			return 0;

	}
	elseif($student_id!="" || $student_id!=0){
		$studenctrl="sc.student_id=$student_id";
		$o->student_id=$student_id;
	}
	else
		return false;

	//$weekday= strtoupper(date("D", strtotime($attendance_date)));
	$attendance_datetime=$attendance_date . ' ' .$attendance_time;
//	$attendance_time_end=$attendance_date . ' ' .$attendance_time;

/*	$sql="SELECT sc.studentclass_id, tc.tuitionclass_code, tc.description, 
		tc.starttime,tc.day$this->day_no FROM 
		$this->tablestudentclass sc
		inner join $this->tabletuitionclass tc on tc.tuitionclass_id=sc.tuitionclass_id
		WHERE $studenctrl and tc.organization_id=$organization_id and
		tc.day$this->day_no='$attendance_day' and $studenctrl and tc.starttime between '$attendance_time_start' and '$attendance_time_end'";
*/
	$sql="SELECT sc.studentclass_id, tc.tuitionclass_code, tc.description, 
		csc.class_datetime as starttime,csc.schedule_id FROM
		$this->tablestudentclass sc
		inner join $this->tabletuitionclass tc on tc.tuitionclass_id=sc.tuitionclass_id
		inner join $this->tableclassschedule csc on csc.tuitionclass_id=tc.tuitionclass_id
		inner join $this->tableorganization o on o.organization_id=tc.organization_id
		WHERE tc.organization_id=$organization_id and $studenctrl and csc.class_datetime between 
			DATE_SUB(STR_TO_DATE('$attendance_datetime','%Y-%m-%d %H:%i:%S'),INTERVAL 30 MINUTE)
			 and DATE_ADD(STR_TO_DATE('$attendance_datetime','%Y-%m-%d %H:%i:%S'),INTERVAL  30 MINUTE) ";

	$i=0;
	$this->log->showLog(4,"Verified class with SQL:$sql");

	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query))
	{
		$this->studentclass_id=$row['studentclass_id'];
		$this->tuitionclass_code=$row['tuitionclass_code'];
		$this->description=$row['description'];
		$this->starttime=$row['starttime'];
		$this->schedule_id=$row['schedule_id'];
		$i++;
	}
	if ($i==0){
	$this->log->showLog(4,"No class suitable for this attendance, record not save.");
	return 0;
	}
	elseif($i==1){
		$this->log->showLog(4,"1 class suitable for this attendance, configure attendance automatically.");
		return 1;
	}
	else{
		$this->log->showLog(4,"More than 1 record suitable for this attendance, user shall choose suitable class manually");
		return 2;

	}

	
	
	$this->log->showLog(4,"analyze with SQL: $sql");
	return false;
	}
  public function showConflicForm(){
	$this->log->showLog(3,"Show form to resolve conflic on attendance");
	$attendance_day=substr($this->attendance_date, 8, 2);
		
	if($attendance_day <=7 && $attendance_day>=1)
		$this->day_no=1;
	elseif($attendance_day <= 14)
		$this->day_no=2;
	elseif($attendance_day <= 21)
		$this->day_no=3;
	elseif($attendance_day <= 28)
		$this->day_no=4;
	else
		$this->day_no=5;

	$weekday= strtoupper(date("D", strtotime($this->attendance_date)));
	$attendance_time_start=substr($this->attendance_time, 0, 2) .substr($this->attendance_time, 3, 2) -100;
	$attendance_time_end=substr($this->attendance_time, 0, 2) .substr($this->attendance_time, 3, 2)+100;

	$sql="SELECT sc.studentclass_id, tc.tuitionclass_code, tc.description, 
		tc.starttime,tc.day$this->day_no FROM 
		$this->tablestudentclass sc
		inner join $this->tabletuitionclass tc on tc.tuitionclass_id=sc.tuitionclass_id
		WHERE sc.student_id=$this->student_id and tc.organization_id=$this->organization_id and
		tc.day$this->day_no='$attendance_day' and sc.student_id=$this->student_id and tc.starttime between '$attendance_time_start' and '$attendance_time_end'";
	$i=0;
	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
<table border='1'>
  <tbody>
  <tr>
      <th colspan="8">Choose Any Record Below</th>
    </tr>
    <tr>
      <th>No</td>
      <th>Class Code</th>
      <th>Class Name</th>
      <th>Time</th>
      <th>Choose</th>
    </tr>

EOF;
	while($row=$this->xoopsDB->fetchArray($query))
	{
		$studentclass_id=$row['studentclass_id'];
		$tuitionclass_code=$row['tuitionclass_code'];
		$description=$row['description'];
		$starttime=$row['starttime'];
		$i++;

echo <<< EOF
 <tr>
      <td>$i</td>
      <td>$tuitionclass_code</td>
      <td>$description</td>
      <td>$starttime</td>
      <td><form method='POST' action="regattendance.php" ><input name='action' value='choose' type='hidden' >
		<input type='hidden' name='attendance_date' value="$this->attendance_date">
		<input type='hidden' name='organization_id' value="$this->organization_id">
		<input type='hidden' name='attendance_time' value="$this->attendance_time">
		<input type='hidden' name='day_no' value="$this->day_no">
		<input type='hidden' name='studentclass_id' value="$studentclass_id">
		<input type='hidden' name='student_id' value="$this->student_id">
		<input type='submit' name='submit' value='Choose'>
	</form></td>
    </tr>
EOF;

	}

	}
}


?>
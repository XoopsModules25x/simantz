<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
/**
 * class Attendance
 */
class Attendance
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $student_id;
  public $student_code;
  public $student_name; 
  public $school; 
  public $s_hp_no; 
  public $s_tel_1; 
  public $s_isactive;
  public $tuitionclass_id;
  public $period_id;
  public $tuitionclass_code; 
  public $employee_id; 
  public $description; 
  public $classtype;
  public $cur_name;
  public $cur_symbol;
  public $starttime;
  public $c_isactive; 
  public $endtime; 
  public $employee_name; 
  public $e_hp_no;
  public $e_isactive;
  public $studentclass_id;
  public $r_isactive;
  public $amt;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $classctrl;
  public $periodctrl;
  public $studentctrl;
  public $token;
  public $time1;
  public $time2;
  public $time3;
  public $time4;
  public $time5;
  public $arraystudentclass_id;
  private $xoopsDB;
  private $tableprefix;
  private $tablestudent;
  private $tableemployee;
  private $tabletuitionclass;
  private $tableclassschedule;
  private $tableorganization;
  private $productlist;  
  private $tableproductlist;
  private $tablestudentclass;
  private $tablestandard;
  private $tableattendance;
  private $tableschool;
  private $tableperiod;
  private $log;

  /**
   * @access public, constructor
   */
  public function Attendance($xoopsDB, $tableprefix, $log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablestudent=$tableprefix . "simtrain_student";
	$this->tableemployee=$tableprefix . "simtrain_employee";
	$this->tableproductlist=$tableprefix . "simtrain_productlist";
	$this->tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
	$this->tablestudentclass=$tableprefix . "simtrain_studentclass";
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tableclassschedule=$tableprefix."simtrain_classschedule";
	$this->tableperiod=$tableprefix . "simtrain_period";
	$this->tableattendance=$tableprefix."simtrain_attendance";
	$this->tablestandard=$tableprefix."simtrain_standard";
	$this->tableschool=$tableprefix."simtrain_school";
	$this->log=$log;
   }

  public function getInputForm($tuitionclass_id,$period_id) {
	
	if($tuitionclass_id=="")
	$tuitionclass_id = -1;

	$searchctrl= "<input style='height: 40px;' name='submit' value='Generate' type='submit'>";
	$classctrl=$this->getTuitionClassList($tuitionclass_id);

	echo <<< EOF

	<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Registration Summary - By Class</span></big></big></big></div><br>-->
	<form method="post" action="attendance.php" name="frmAttendance">

	<table style="text-align: left; width: 100%;" border="1" cellpadding="0" >
	<tbody>
	<tr>
        <th colspan="2" rowspan="1">Generate Class List</th>
      </tr>
	<tr>
		<td class="head">Class Code</td>
		<td class="odd">$classctrl <A href='#' onclick="zoom()">zoom</A></td>
	</tr>
	</tbody>
	</table>

	<table style="width:150px;"><tbody><td>$searchctrl</td>
	<input name="action" value="-1" type="hidden">
	</tbody></table></form>
EOF;

  } // end of member function getInputForm

public function getTuitionClassList($id){
	global $defaultorganization_id;
	$this->log->showLog(3,"Retrieve available tuition class from database");

	$sql="SELECT c.tuitionclass_id, c.tuitionclass_code, pr.period_name,c.day, o.organization_code
		from $this->tabletuitionclass c 
		inner join $this->tableproductlist p on c.product_id=p.product_id 
		inner join $this->tableperiod pr on c.period_id=pr.period_id 
		inner join $this->tableorganization o on o.organization_id=c.organization_id
		where p.isactive='Y' and pr.isactive='Y'  and c.organization_id = $defaultorganization_id 
		order by c.tuitionclass_code,pr.period_name ";
	$this->log->showLog(4,"With SQL:$sql");
	$classctrl="<SELECT name='tuitionclass_id' onchange='loadattendance()'>";
	if ($id==-1)
		$classctrl=$classctrl . '<OPTION value="0" SELECTED="SELECTED">-- Please Select --</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$tuitionclass_id=$row['tuitionclass_id'];
		$tuitionclass_code=$row['tuitionclass_code'] . "-" .
			 $row['period_name']."-".$row['organization_code'] ;
		if($id==$tuitionclass_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		
		$classctrl=$classctrl  . "<OPTION value='$tuitionclass_id' $selected>$tuitionclass_code</OPTION>";
		$this->log->showLog(4,"Retrieving tuitionclass_id:$tuitionclass_id area_name:$tuitionclass_code");
	}
	$classctrl=$classctrl . "</SELECT>";
	return $classctrl;
}//end of getTuitionClassList

  public function fetchTuitionClassDetail( $tuitionclass_id, $period_id ) {
	$this->log->showLog(3,"Fetching attendance detail into class Attendance.php.<br>");

	$sql="SELECT c.tuitionclass_id, c.classtype, c.tuitionclass_code, c.description, c.day, c.starttime,
		 c.endtime, e.employee_id, e.employee_name, e.hp_no, d.period_name 
		from $this->tabletuitionclass c 
		inner join $this->tableemployee e on c.employee_id=e.employee_id
		inner join $this->tableperiod d on c.period_id=d.period_id 
		inner join $this->tableproductlist p on c.product_id=p.product_id
		where c.tuitionclass_id=$tuitionclass_id";
	$this->log->showLog(4,"With SQL:$sql");
	
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$tuitionclass_code=$row["tuitionclass_code"];
		$period_name=$row["period_name"];
		$description=$row["description"];
		$amt=$row["amt"];
		$day=$row["day"];
		$this->classtype=$row['classtype'];
		$this->day=$day;
		$starttime=$row["starttime"];
		$endtime=$row["endtime"];
		$employee_name=$row["employee_name"];
		$e_hp_no=$row["hp_no"];

	$this->log->showLog(4,"Attendance->fetchTuitionClassDetail, database fetch into class successfully");
	$this->log->showLog(3,"Showing Attendance Header");
echo <<< EOF
<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
<tbody>
	<tr>
		<th colspan="4"><big><big><big><span style="font-weight: bold;">Class Code: 
			<A href="tuitionclass.php?action=edit&tuitionclass_id=$tuitionclass_id" target="_blank">
			$tuitionclass_code
			</A>
		</span></big></big></big></td>
		<th colspan="4"><big><big><big><span style="font-weight: bold;">Month: $period_name</span></big></big></big></td>
	</tr>
	<tr>
		<td class="head">Class Description :</td>
		<td class="odd">$description</td>
		<td class="head">Fees :</td>
		<td class="odd">RM $amt</td>
		<td class="head">Day :</td>
		<td class="odd">$day</td>
		<td class="head">Time :</td>
		<td class="odd">$starttime ~ $endtime</td>
	</tr>
	<tr>
		<td class="head" colspan="1">Tutor :</td>
		<td class="even" colspan="3">$employee_name</td>
		<td class="head" colspan="2">Tutor Contact :</td>
		<td class="even" colspan="2">$e_hp_no</td>
	</tr>
	
</tbody>
</table>
EOF;
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Attendance->fetchTuitionClassDetail, failed to fetch data into databases.");
	}
  } // end of member function fetchAttendance

public function showStudentClassTable($tuitionclass_id, $period_id){
	
	$scheduleheader=array();
	$scheduleheadertext=array();
	$schedulecount=0;
	$this->log->showLog(3,"Showing Attendance Table");

	$sql="SELECT s.student_id,s.student_code, s.student_name,s.alternate_name, s.hp_no, s.tel_1, sch.school_name, x.amt, x.isactive, x.studentclass_id ".
		",x.comeactive, x.backactive from $this->tabletuitionclass c ".
		" inner join $this->tablestudentclass x inner join $this->tableperiod d ".
		" inner join $this->tablestudent s on s.student_id=x.student_id ".
		" inner join $this->tableschool  sch on s.school_id=sch.school_id ".
		" where x.tuitionclass_id=$tuitionclass_id and x.tuitionclass_id=c.tuitionclass_id and ".
		" c.period_id=d.period_id  order by s.student_name";
	
	$this->log->showLog(4,"Attendance->showStudentClassTable, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);
	if($tuitionclass_id>0){
	$sqlschedule="SELECT s.schedule_id,concat(day(s.class_datetime),'/',month(s.class_datetime)) as class_datetime
		FROM $this->tableclassschedule s where s.tuitionclass_id=$tuitionclass_id order by s.schedule_id";

	$this->log->showLog(4,"Get schedule with SQL: $sqlschedule");
	
	$queryschedule=$this->xoopsDB->query($sqlschedule) or die(mysql_error());
	$thschedule="";
	$k=0;

	while($rowschedule=$this->xoopsDB->fetchArray($queryschedule)){
		$schedule_id=$rowschedule['schedule_id'];
		$class_datetime=$rowschedule['class_datetime'];
		$thschedule=$thschedule . "<th style='text-align:center;'>
				<input size='3' type='hidden' value='$schedule_id' name='lineschedule[$k]'>
				$class_datetime
				</th>\n";
		array_push($scheduleheader,$schedule_id);
		array_push($scheduleheadertext,$class_datetime);
		$k++;
	}
	$schedulecount=$k;
	}
	echo <<< EOF

	<input type='hidden' value='$tuitionclass_id' name="tuitionclass_id">
	<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Index No</th>
				<th style="text-align:center;">Student Name</th>
				<th style="text-align:center;">Contact No.</th>
				<th style="text-align:center;">School</th>
				<th style="text-align:center;">Trans.</th>
				<th style="text-align:center;">Fees  ($this->cur_symbol)</th>
				<th style="text-align:center;">Cont. Next Mth?</th>
				$thschedule
   			</tr>

EOF;
//				<th style="text-align:center;">Not Registered<br>This Month</th>
	//$sql="SELECT schedule_id, class_datetime,  FROM $this->table";

	$rowtype="odd";
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$student_id=$row['student_id'];
		$student_code=$row['student_code'];
		$student_name=$row['student_name'];
		$alternate_name=$row['alternate_name'];
		$hp_no=$row['hp_no'];
		$tel_1=$row['tel_1'];

		$school=$row['school_name'];
		$standard=$row['standard_name'];
		$amt=$row['amt'];
		$isactive=$row['isactive'];
		$studentclass_id=$row['studentclass_id'];
		$backactive=$row['backactive'];
		$comeactive=$row['comeactive'];
		$transport="";
		if($backactive=='Y' && $comeactive=='Y')
			$transport="D";
		elseif($backactive=="Y")
			$transport="R";		
		elseif($comeactive=='Y')
			$transport="C";
		else
			$transport="";
			
		if($rowtype=="odd"){
			$rowtype="even";}
		else{
			$rowtype="odd";}



	if ($tuitionclass_id=='')
	{
	$printctrl="";}
	else
	{

	$reportname="viewattendance.php";

	switch($this->classtype){
	case "M":
		$reportname="viewmonthattendance.php";
	break;
	case "W":
		$reportname="viewattendance.php";
	break;
	case "V":
		$reportname="viewspecialattendance10.php";
	break;
	case "S":
		if($schedulecount<=5)
			$reportname="viewspecialattendance5.php";
		elseif($schedulecount<=10) //10 days class
			$reportname="viewspecialattendance10.php";
		elseif($schedulecount<=20) //15 days class
			$reportname="viewspecialattendance20.php";
		else
			$reportname='';
	break;
	default:
		$reportname="viewattendance.php";
	break;
	}


	$printctrl="<form action='$reportname' method='POST' target='_blank'>
		<input type='submit' value='Preview' title='View PDF' 
		name='submit' style='font-size:22px;' >
		<input type='hidden' name='tuitionclass_id' value='$tuitionclass_id'>
		<input type='hidden' name='period_id' value='$period_id'></form>";
	}


	
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">
				$student_code 
			</td>
			<td class="$rowtype" style="text-align:center;"><a href="student.php?action=edit&student_id=$student_id"
				target="_blank">$alternate_name/$student_name</a></td>
			<td class="$rowtype" style="text-align:center;">$hp_no / $tel_1</td>
			<td class="$rowtype" style="text-align:center;">$school</td>
			<td class="$rowtype" style="text-align:center;">$transport</td>
			<td class="$rowtype" style="text-align:center;">$amt</td>
			<td class="$rowtype" style="text-align:center;">$isactive <A href="regclass.php?action=edit&studentclass_id=$studentclass_id">[Zoom]</a></td>
			
		
EOF;
	$i=0;
	foreach($scheduleheader as $id){
		$sqlscheduleschild="SELECT attendance_id, student_id,attendance_time,schedule_id 
			FROM $this->tableattendance WHERE schedule_id=$id and student_id=$student_id";
		$this->log->showLog(4,"Check this student/schedule exist with SQL: $sqlscheduleschild");

		$queryDetail=$this->xoopsDB->query($sqlscheduleschild);
		$attendance_id=0;
		$attendance_time="";
		$updateurl="";
		if($rowscheduleschild =$this->xoopsDB->fetchArray($queryDetail)){
				$attendance_id=$rowscheduleschild['attendance_id'];
				$attendance_time=$rowscheduleschild['attendance_time'];
				$this->log->showLog(3,"Attd id/time: $attendance_id/$attendance_time");
				$attendance_month=substr($attendance_time,5,2)+0;
				$attendance_day=substr($attendance_time,8,2)+0;
				$attendance_datetext = $attendance_day ."/".$attendance_month;
				$htext=$scheduleheadertext[$i];
				if($attendance_id>0){
					if($scheduleheadertext[$i]==$attendance_datetext)
					$updateurl="<input type='button' name='s' value='X' 
					onClick=removeAttendance($attendance_id); title='$attendance_time'>";
					else
					$updateurl="<input type='button' name='s' value='X' style='background-color:blue'			onClick=removeAttendance($attendance_id); title='$attendance_time'>";
				}

//					$updateurl="<input type='button' name='s' value='[X]' onClick=removeAttendance($attendance_id); title='$attendance_time'>";
				
		}
		else
		 $updateurl="<input type='button' name='s' value='' title='-' onClick=addAttendance($id,$student_id);>";
	
		echo "<td class='$rowtype' style='text-align:center;'>$updateurl</td>\n";
		$i++;
		}
		echo "</tr>";
//			<td class="$rowtype" style="text-align:center;">$removectrl</td>
	}//end of while

$columncount=8+$schedulecount;
$transactiondate= date("Y-m-d", time()) ;

echo  <<< EOF
	<tr>
	<td  colspan='3' style='text-align:right'>$printctrl </td>

	<form name='frmAddStudent' action='regclass.php' method='POST' 
		onsubmit='if(document.frmAttendance.tuitionclass_id.value < 1){alert("Please Select Class Code");return false;}else return confirm("Add this student? Transport service information you need to enter manualy");'>
	<td >
		$this->studentctrl
		<input name='token' value="$this->token" type='hidden');
		<input name='tuitionclass_id' value="$this->tuitionclass_id" type='hidden'>
		<input name='transactiondate' value="$transactiondate" type='hidden'>
		<input name='classjoindate' value="$transactiondate" type='hidden'>
		<input name='comeareafrom_id' value="0" type='hidden'>
		<input name='backareato_id' value="0" type='hidden'>
		<input name='isactive' value="on" type='hidden'>
		<input name='organization_id' value="0" type='hidden'>
	</td>
	<td>
		<input type='submit' value='Register This Student' name='submit'>
		<input name='action' value='create' type='hidden'>
	</td>
	</form>
	</td></tr>
	</tbody></table>
EOF;
 }//end of showTransportTable

 public function addAttendance($schedule_id,$student_id,$attendance_time,$userid){	
	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Add attendance with schedule:$schedule_id, student:$student_id,time:$attendance_time");
	$sql="INSERT INTO $this->tableattendance (schedule_id,student_id,attendance_time,created,createdby, 
		updated,updatedby) VALUES 
		($schedule_id,$student_id,'$attendance_time','$timestamp',$userid, 
		'$timestamp',$userid)";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql) or die(mysql_error());
	if($query){

		$this->log->showLog(4,"Add successfully");
		return true;
	}
	else{
	
		$this->log->showLog(4,"Add failed");
	return false;
	}
	}

 public function deleteAttendance($attendance_id){
	$this->log->showLog(3,"Delete attendance with attendance_id=$attendance_id");
	$sql="DELETE FROM $this->tableattendance WHERE attendance_id=$attendance_id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql) or die(mysql_error());
	if($query){
		$this->log->showLog(4,"Delete successfully");
		return true;

	}
	else{
		$this->log->showLog(4,"Delete failed");
		return false;

	}
	
}

} // end of Attendance
?>

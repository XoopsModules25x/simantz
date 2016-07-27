<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


/**
 * class Address
 * The class for address
 */
class Schedule
{

  public $schedule_id;
  public $class_datetime;
  public $employee_id;
  public $tuitionclass_id;
  public $lineschedule_id;
  public $lineemployee_id;
  public $lineclass_datetime;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $cur_name;
  public $cur_symbol;
  private $xoopsDB;
  private $tableprefix;
  private $tableschedule;
  private $tabletuitionclass;
  private $tableemployee;
  private $log;

 public function Schedule($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->log=$log;
	$this->tableschedule=$tableprefix."simtrain_classschedule";
	$this->tabletuitionclass=$tableprefix."simtrain_tuitionclass";
	$this->tableemployee=$tableprefix."simtrain_employee";

	}

  public function showInputForm( $tuitionclass_id,$token,$e ) {

	echo <<< EOF
		<br>
		<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Edit Schedule</span></big></big></big></div><br>
		
		<table style="text-align:left width: 100%" border="1" cellpadding="0" cellspacing="3">
		<tbody>
		<tr><th colspan="3" rowspan="1" style='text-align:center'>Schedule Detail</th></tr>
			<tr>
			<th>No</th>
			<th>Date/Time (YYYY-MM-DD HH:MM:SS)</th>
			<th>Tutor
			<form action='schedule.php' method='POST'>
			<input type='hidden' name='action' value='update'>
			<input type='hidden' value="$token" name='token'>
			<input type='hidden' value="$tuitionclass_id" name='tuitionclass_id'>
			</th></tr>
			

EOF;
	$this->log->showLog(3,"Show schedule for class $tuitionclass_id");
	$sql="SELECT schedule_id,employee_id,class_datetime from $this->tableschedule where
		tuitionclass_id=$tuitionclass_id  order by schedule_id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
		
		$schedule_id=$row['schedule_id'];
		$employee_id=$row['employee_id'];
		$class_datetime=$row['class_datetime'];
		$employeectrl=$e->getEmployeeList($employee_id,'M','lineemployee_id[]');
		$j=$i+1;
		echo <<< EOF
			<tr>
				<td>$j<input type='hidden' name='lineschedule_id[]' value="$schedule_id"></td>
				<td><input value="$class_datetime" name='lineclass_datetime[]'></td>
				<td>$employeectrl</td>
			</tr>
EOF;
$i++;
	}

echo <<< EOF
</tbody>
</table>
<table><tbody><tr>
	<TD >
		<input type='submit' value='save' name='submit' style='height:40px;' title='Save record'>&nbsp;&nbsp;
		<input type='reset' value='reset' name='reset' title='Reset form to previous state'>
	</FORM>
	</TD>
	<td>
		<form action='tuitionclass.php' method='POST'>
		<input name='submit' value='Back' type='submit' title='Back to '>
		<input name="action" value="edit" type="hidden">
		<input name='tuitionclass_id' value="$tuitionclass_id" type='hidden'>
	</td>
	</form></tr></tbody></table>
EOF;

  } // end of member function getInputForm

  /**
   * Save address info into database
   *
   * @return bool
   * @access public
   */
  public function updateSchedule() {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3, "Update schedule_id: $this->schedule_id");

	$i=0;
	foreach($this->lineschedule_id as $id )
	{
			$schedule_id=$id;
			$employee_id=$this->lineemployee_id[$i];
			$class_datetime=$this->lineclass_datetime[$i];
			

	$sql="UPDATE $this->tableschedule SET employee_id='$employee_id',
		class_datetime='$class_datetime', updated='$timestamp',updatedby=$this->updatedby WHERE schedule_id='$schedule_id'";
	

	$this->log->showLog(4, "With SQL:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update schedule failed");
	return false;
	}
	else
		$this->log->showLog(3, "Update schedule successfully.");
	$i++;	
  }
	return true;
  } // end of member function updateAddress

}
?>

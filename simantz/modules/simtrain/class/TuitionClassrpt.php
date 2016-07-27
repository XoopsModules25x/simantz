<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

/**
 * class TuitionTransaction
 * Monthly student registration class/books/enrollment information, it link to
 * Product Master
 */
class TuitionClassrpt
{

  public $tuitionclass_id;
  public $product_id;
  public $category_id;
  public $standard_id;
  public $period_id;
  public $employee_id;
  public $description;
  public $cur_name;
  public $cur_symbol;
  public $day;
  public $day2;
  public $starttime;
  public $starttime2;
  public $attachmenturl;
  public $isactive;
  public $endtime;
  public $endtime2;
  public $organization_id;
  public $createdby;
  public $created;
  public $classcount;
  public $oldclasscount;
  public $hours;
  public $updated;
  public $updatedby;
  public $classtype;
  public $oldclasstype;
  public $clone_id;
  public $tuitionclass_code;
  public $seachempctrl;
  public $seachorgctrl;
  public $seachperiodctrl;
  public $employeectrl;
  public $periodctrl;
  public $orgctrl;
  public $testctrl;
  public $productctrl;
  public $schedulectrl;
  public $standardctrl;
  public $categoryctrl;
  public $deleteAttachment;
  public $isAdmin;
  private $xoopsDB;
  private $tableprefix;
  private $tabletuitionclass;
  private $tablestudentclass;
  private $tablestudent;
  private $tableperiod;
  private $tableemployee;
  private $tableschool;
  private $tableproductlist;
  private $tableclassschedule;
  private $tablepaymentline;
  private $tableorganization;
  private $tabletest;
  private $log;

  public function TuitionClassrpt($xoopsDB, $tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
	$this->tableproductlist=$tableprefix . "simtrain_productlist";
	$this->tableperiod=$tableprefix . "simtrain_period";
	$this->tableemployee=$tableprefix."simtrain_employee";
	$this->tableschool=$tableprefix."simtrain_school";
	$this->tablestudentclass=$tableprefix."simtrain_studentclass";
	$this->tablestudent=$tableprefix."simtrain_student";
	$this->tableclassschedule=$tableprefix."simtrain_classschedule";
	$this->tableorganization=$tableprefix."simtrain_organization";
	$this->tablepaymentline=$tableprefix."simtrain_paymentline";
	$this->tabletest=$tableprefix."simtrain_test";
	$this->log=$log;
  }
  /**
   * get sql statement for select range of data from existing tuition class table
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return 
   * @access public
   */
  public function getSQLStr_AllTuitionClassrpt( $wherestring,  $orderbystring,  $startlimitno ) {

$sql="SELECT o.organization_code,t.classtype,t.classcount,t.tuitionclass_id,t.hours,t.product_id,
	t.period_id, t.employee_id,t.description, t.day,t.day2, t.classtype,t.classcount,
	t.starttime,t.starttime2,t.attachmenturl, t.isactive, t.endtime,t.endtime2, t.organization_id,
	t.createdby, t.created, t.updatedby, 
	t.updated, t.clone_id, t.tuitionclass_code,p.product_name,e.employee_name,t.description,p.amt,
	pr.period_name ,
	(SELECT count(studentclass_id) FROM sim_simtrain_studentclass 
		WHERE tuitionclass_id=t.tuitionclass_id ) as headcount,
	(SELECT sum(amt) FROM sim_simtrain_studentclass WHERE tuitionclass_id=t.tuitionclass_id) totalfees,
	(SELECT sum(pl.trainingamt) FROM sim_simtrain_studentclass sc 
		INNER JOIN sim_simtrain_paymentline pl on sc.studentclass_id=pl.studentclass_id
		INNER JOIN sim_simtrain_payment py on py.payment_id=pl.payment_id
		WHERE sc.tuitionclass_id=t.tuitionclass_id and py.iscomplete='Y') AS receivedamt
	from sim_simtrain_tuitionclass t 
	inner join sim_simtrain_period pr on pr.period_id=t.period_id 
	inner join sim_simtrain_productlist p on p.product_id=t.product_id 
	inner join sim_simtrain_employee e on e.employee_id=t.employee_id 
	inner join $this->tableorganization o on o.organization_id=t.organization_id 
	$wherestring 
	Group by o.organization_code,t.classtype,t.tuitionclass_id,t.hours,t.product_id,
			t.period_id, t.employee_id, t.description, t.day, t.classtype,t.classcount,
			 t.starttime,t.attachmenturl, 
			t.isactive, t.endtime, t.organization_id,t.createdby, t.created, t.updatedby, t.updated, 
			t.clone_id,
			t.tuitionclass_code,p.product_name,e.employee_name,t.description,p.amt,pr.period_name 
	ORDER BY tuitionclass_code";
	$this->log->showLog(3,"TuitionClassrpt->getSQLStr_AllTuitionClas sRetrieve class list with filter string $wherestring");
	$this->log->showLog(4,"with SQL:$sql");
  

 return $sql;

  } // end of member function getSQLStr_AllTuitionClassrpt

  /**
   * delete class from database.
   *
   * @param int tuitionclass_id 
   * @return bool
   * @access public
   */
  public function deleteTuitionClassrpt( $tuitionclass_id ) {
   	$this->log->showLog(2,"Warning: Performing delete tuition class id : $tuitionclass_id !");
	$sql="DELETE FROM $this->tabletuitionclass where tuitionclass_id=$tuitionclass_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: tuitionclass_id ($tuitionclass_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"tuitionclass_id ($tuitionclass_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function delTransaction

  /**
   *
   * @param varchar type Either "new" or "edit", if new all default value ="", else it will fill in
default value from dabase.

   * @param int tuitionclass_id The information under tuitionclass_id will display inside the forms.

   * @return 
   * @access public
   */
  public function getInputForm( $type,  $tuitionclass_id,$token ) {
	$mandatorysign="<b style='color:red'>*</b>";
   $header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$recordctrl="";
	$selectday=$this->selectDay($this->day);
	$selectday2=$this->selectDay($this->day2,'day2');
	$attendancectrl="";
	$filectrl="";
	switch($this->classtype){
	case "W":
		$SELECTSPECIAL="";
		$SELECTMONTH="";
		$SELECTWEEK="SELECTED='SELECTED'";
		$SELECTWEEK2="";
	break;
	case "S":
		$SELECTSPECIAL="SELECTED='SELECTED'";
		$SELECTMONTH="";
		$SELECTWEEK="";
		$SELECTWEEK2="";

	break;
	case "M":
		$SELECTSPECIAL="";
		$SELECTMONTH="SELECTED='SELECTED'";
		$SELECTWEEK="";
		$SELECTWEEK2="";
	break;
	case "V":
		$SELECTSPECIAL="";
		$SELECTMONTH="";
		$SELECTWEEK="";
		$SELECTWEEK2="SELECTED='SELECTED'";

	break;
	default:
		$SELECTSPECIAL="";
		$SELECTMONTH="";
		$SELECTWEEK="SELECTED='SELECTED'";
		$SELECTWEEK2="";

	break;

	}
	$classtypectrl="<SELECT name='classtype' onchange='triggerclasstype();'>
			<option value='W' $SELECTWEEK>Weekly</option>
			<option value='V' $SELECTWEEK2>Weekly x 2</option>
			<option value='M' $SELECTMONTH>Whole Month</option>
			<option value='S' $SELECTSPECIAL>Special Schedule</option>
			</SELECT><input type='hidden' name='oldclasstype' value='$this->classtype'>";

	if ($type=="new"){
		$header="New Tuition Class";
		$action="create";
		if($product_id==0){
		$this->tuitionclas_code="";
		$this->product_id=0;
		$this->period_id=0;
		$this->employee_id=0;
		$this->description="";

		$this->classcount=0;
		$this->hours=0;
		$this->day="";
		$this->starttime="";
		$this->endtime="";
		$this->day2="";
		$this->starttime2="";
		$this->endtime2="";
		}
		
		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		
	}
	else
	{
		$action="update";
		$savectrl="<input name='tuitionclass_id' value='$this->tuitionclass_id' type='hidden'>".
		"<input style='height:40px;' name='submit' value='Save' type='submit'>";
	
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tabletuitionclass' type='hidden'>".
		"<input name='id' value='$this->tuitionclass_id' type='hidden'>".
		"<input name='idname' value='tuitionclass_id' type='hidden'>".
		"<input name='title' value='Tuition Class' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";


		if($this->isAdmin)		
		$reschedulectrl="<form onsubmit='return confirm(" .  '" Confirm to reschedule? Warning! All attendance under the schedule will be remove permanently."'. ");' action='tuitionclassrpt.php' method='POST'>
		<input name='tuitionclass_id' value='$this->tuitionclass_id' type='hidden'>
		<input name='submit' value='Reschedule' type='submit'>
		<input name='action' value='reschedule' type='hidden'>
		</form>";
		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		$header="Edit Tution Class";
		if($this->allowDelete($tuitionclass_id) && $tuitionclass_id>0)
		$deletectrl="<FORM action='tuitionclassrpt.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this class?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->tuitionclass_id' name='tuitionclass_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		//"<Form action='tuitionclassrpt.php' method='POST'><input name='submit' value='New' type='submit'></form>";
		 $addnewctrl="<form action='tuitionclassrpt.php' method='post'><input type='submit' value='New' value='New'></form>";
	
		$filename="upload/tuitionclass/".$this->tuitionclass_id.".pdf";
		if(file_exists($filename))
			$filectrl="<a href='$filename' target='_blank' title='Scanned attendance hardcopy.'>Download</a>";
		else
			$filectrl="<b style='color:red;'>No Attachment</b>";
		$attendancectrl="<FORM action='attendance.php' method='POST' target='_blank'>".
				"<input type='submit' value='Attendance' name='submit' title='Print attendance check list'>".
				"<input type='hidden' value='active' name='action'>".
				"<input type='hidden' value='$this->tuitionclass_id' name='tuitionclass_id'></form>";
		$clonectrl="<FORM action='tuitionclassrpt.php' method='POST'
				onsubmit='return confirm(".'"Any unsave data will lost, confirm to clone this class?\nWarning! This function shall use for special purpose which is cannot full fill via month/year end cloning. please consult person in charge if you not sure."'.")'>".
				"<input type='submit' value='Clone Class' name='submit' title='Clone this class exactly, cloned class has exactly same period, class code, registered student and registered amount with current record.'>".
				"<input type='hidden' value='cloneclass' name='action'>".
				"<input type='hidden' value='$this->tuitionclass_id' name='tuitionclass_id'></form>";
	
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Active Tuition Class List</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateClass()" method="post"
 action="tuitionclassrpt.php" name="frmTutionClass"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>



<table cellspacing='3' border='1'>
  <thead>
    <tr>
      <th colspan='4' style='text-align:center'>Tuition Class Detail</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="head">Class Code $mandatorysign</td>
      <td class="odd"><input name="tuitionclass_code" value="$this->tuitionclass_code" maxlength="10" size="10" ></td>
      <td class="head">Product</td>
      <td class="odd">$this->productctrl <a onClick="zoomProduct()" title="Open new window to see this product">zoom</a></td>
    </tr>
    <tr>
      <td class="head">Place Of Tuition</td>
      <td class="even">$this->orgctrl</td>
      <td class="head">Period $mandatorysign</td>
      <td class="even">$this->periodctrl</td>
    </tr>
    <tr>

      <td class="head">Tutor $mandatorysign</td>
      <td class="odd">$this->employeectrl <a href='#' onclick='zoomTutor()'>zoom</a></td>
      <td class="head">Active</td>
      <td class="even"><input type="checkbox" name="isactive" $checked></td>

    </tr>
    <tr >
      <td class="head">Class Type</td>
      <td class="even">$classtypectrl</td>
	
          <td class="head" >Hours $mandatorysign</td>
          <td class="even" >
		<input name='hours' value='$this->hours' maxlength='5' size='5'>
	  </td>
  <tr>
      <td class="head">Description $mandatorysign</td>
      <td class="even" colspan="3"><input name="description" value="$this->description" maxlength="60" size="60"></td>
    </tr>
    <tr id='weeklyview' name='weeklyview'>
	 <td  class="head">Day</td><td class="odd">$selectday</td>
	 <td class="head">Start Time(HHMM)  $mandatorysign / End Time(HHMM) $mandatorysign</td>
	 <td class="odd">
		<input name="starttime" value="$this->starttime"  maxlength="4" size="4">/
		<input name="endtime" value="$this->endtime"  maxlength="4" size="4">
	 </td>

	</tr>
    <tr id='weekly2view' name='weekly2view'>

	 <td  class="head">Day 2</td><td class="odd">$selectday2</td>
	 <td class="head">Start Time(HHMM)  $mandatorysign/ End Time(HHMM) $mandatorysign</td>
	 <td class="odd">
		<input name="starttime2" value="$this->starttime2"  maxlength="4" size="4">/
		<input name="endtime2" value="$this->endtime2"  maxlength="4" size="4">
	 </td>
	</tr>

	<tr id='monthlyview' name='monthlyview'>
	 <td class="odd" colspan='4'><b style='color:red;'>Warning! Using this class type will only enable you generate a 31 days attendance check list from this system. You will not be able using student attendance and transport services function for this class. You shall only use this class type when your student attendance is uncontrollable.</b></td>
	</tr>

	<tr id='specialview' name='specialview'>
	 <td class="head">Class Count $mandatorysign</td>
	 <td class="odd" colspan='3'>
		<input name="classcount" value="$this->classcount"  maxlength="2" size="2">
	<input type='hidden' name="oldclasscount" value="$this->classcount">
	
	 </td>
	</tr>
	<tr  colspan='3' id='scheduleview'>
	 <td  class="head">Schedule</td><td class="odd" colspan='3'>
	<div id='specialwarning'><b style='color:red;'>Warning! The schedule under this class type will not auto generate after month/year end clone process.</b></div>
	$this->schedulectrl
	</td>
	</tr>
	<tr> <td  class="head">Test</td><td class="even" colspan='3'>
		$this->testctrl
	</tr>
	<tr>
      <td class="head">Attendance $filectrl</td>
      <td class="odd" colspan="3">Remove File <input type="checkbox" name="deleteAttachment" title="Choose it if you want to remove this attachment"> <input type='file' name="upload_file" size="50" title="Upload attendance hardcopy here. Format in PDF"></td>
</tr>  
</tbody>
</table>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td><td>$attendancectrl</td><td>$clonectrl</td><td>$reschedulectrl</td></tr></tbody></table><br>
</form>
	$recordctrl
EOF;
  } // end of member function getInputForm

  /**
   * update existing data in tuition class.
   *
   * @return bool
   * @access public
   */
  public function updateTuitionClassrpt( ) {
      $timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tabletuitionclass SET
	product_id=$this->product_id,period_id=$this->period_id,employee_id=$this->employee_id,
	tuitionclass_code='$this->tuitionclass_code',description='$this->description',
	day='$this->day', starttime='$this->starttime',endtime='$this->endtime',
	day2='$this->day2', starttime2='$this->starttime2',endtime2='$this->endtime2',
	updated='$timestamp',updatedby=$this->updatedby,
	isactive='$this->isactive',organization_id=$this->organization_id,hours=$this->hours,
	classtype='$this->classtype',classcount='$this->classcount' 
	WHERE tuitionclass_id='$this->tuitionclass_id'";
	
	$this->log->showLog(3, "Update tuitionclass_id: $this->tuitionclass_id, '$this->tuitionclass_code'");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update tuitionclass failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update tuitionclass successfully.");
		return true;
	}
  } // end of member function updateTuitionClassrpt

  /**
   * Insert new record in tuition class
   *
   * @return bool
   * @access public
   */
  public function insertTuitionClassrpt( ) {
	$this->log->showLog(3,"Creating TuitionClassrpt :$o->tuitionclass_code");
	
	//$defaultdayinsertstr=$this->genDefaultDate($this->day,$this->period_id);
     	$timestamp= date("y/m/d H:i:s", time()) ;
	
 	$sql="INSERT INTO $this->tabletuitionclass ( tuitionclass_code, product_id, period_id,employee_id,
		 description, 
		day, starttime, endtime,day2, starttime2, endtime2, isactive,  created,
		createdby, updated, updatedby, 
		organization_id,hours, classtype,classcount) values( 
		'$this->tuitionclass_code',$this->product_id,$this->period_id,$this->employee_id,
		'$this->description',
		'$this->day','$this->starttime','$this->endtime',
		'$this->day2','$this->starttime2','$this->endtime2',
		'$this->isactive',
		'$timestamp',$this->createdby,'$timestamp',	$this->updatedby,$this->organization_id,
		$this->hours,'$this->classtype','$this->classcount')";
	$this->log->showLog(4,"Before insert class SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert class code '$this->tuitionclass_code'");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new class code '$this->tuitionclass_code' successfully"); 
		return true;
	}
  } // end of member function insertTuitionClassrpt

  /**
   * Fetch data from database and upate the class information
   *
   * @param int tuitionclas_id 
   * @return 
   * @access public
   */
  public function fetchTuitionClassrptInfo( $tuitionclass_id ) {
	$this->log->showLog(3,"Fetching tuition class detail into class TuitionClassrpt.php.<br>");
		
	$sql="SELECT t.tuitionclass_id,t.product_id,t.period_id, t.employee_id, t.description, 
		t.day, t.starttime,t.endtime,t.day2, t.starttime2,t.endtime2, 
		 t.attachmenturl, t.isactive,  t.organization_id,t.createdby, t.created, t.updatedby,
		 t.updated, t.clone_id, t.tuitionclass_code,t.hours,t.classtype,t.classcount
		FROM $this->tabletuitionclass t 
		where tuitionclass_id=$tuitionclass_id";
	
	$this->log->showLog(4,"Product->fetchProductInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->tuitionclass_id=$row["tuitionclass_id"];
		$this->product_id=$row['product_id'];
		$this->hours=$row['hours'];
		$this->period_id=$row['period_id'];
		$this->employee_id=$row['employee_id'];
		$this->description=$row['description'];

		$this->classtype=$row['classtype'];
		$this->classcount=$row['classcount'];
		$this->day=$row['day'];
		$this->starttime=$row['starttime'];
		$this->endtime=$row['endtime'];
		$this->day2=$row['day2'];
		$this->starttime2=$row['starttime2'];
		$this->endtime2=$row['endtime2'];

		$this->clone_id=$row['clone_id'];
		$this->tuitionclass_code=$row['tuitionclass_code'];
		$this->organization_id=$row['organization_id'];
		$this->isactive=$row['isactive'];
	   	$this->log->showLog(4,"TuitionClassrpt->fetchTuitionClassrptInfo,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"TuitionClassrpt->fetchTuitionClassrptInfo,failed to fetch data into databases.");	
	}
    
  } // end of member function fetchTuitionClassrptInfo

 /**
   * Display tuition class table
   *
   * @param 
   * @return 
   * @access public
   */
public function showTuitionClassrptTable($wherestring="WHERE t.isactive='Y'",$orderbystring="order by pr.period_name,t.tuitionclass_code,t.day,t.starttime",$callfrom="s"){
	
	$this->log->showLog(3,"Showing Tuition Class Table");
	$sql=$this->getSQLStr_AllTuitionClassrpt($wherestring,$orderbystring,0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border="1" cellspacing="1">
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Period</th>
				<th style="text-align:center;">Class Code</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Student Qty</th>
				<th style="text-align:center;">Class Type</th>
				<th style="text-align:center;">Class Count</th>
				<th style="text-align:center;">Day</th>
				<th style="text-align:center;">Time</th>
				<th style="text-align:center;">Hours</th>
				<th style="text-align:center;">Tutor</th>
				<th style="text-align:center;">Fees ($this->cur_symbol)</th>
				<th style="text-align:center;">Total Tuition Fees($this->cur_symbol)</th>
				<th style="text-align:center;">Received ($this->cur_symbol)</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;" colspan="2">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	$frmTarget="";
	$totalreceivedamt=0;
	$totalallfees=0;
	$totalheadcount=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$tuitionclass_id=$row['tuitionclass_id'];
		$tuitionclass_code=$row['tuitionclass_code'];
		$description=$row['description'];
		

		$organization_code=$row['organization_code'];
		$period_name=$row['period_name'];
		$tutor = $row['employee_name'];
		$classcount = $row['classcount'];
		$classtype="";

		$headcount = $row['headcount'];
		$hours=number_format($row['hours'],1);
		$totalhours=number_format($totalhours+$hours,1);
		$amt = $row['amt'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];
		$totalfees=$row['totalfees'];
		$receivedamt=$row['receivedamt'];
		$totalreceivedamt=$receivedamt+$totalreceivedamt;
		$totalallfees=$totalfees+$totalallfees;
		$classtype="";
		$totalheadcount=$headcount+$totalheadcount;
//		$classcount=$row['classtype'];
		$tuitionclass_day2='';
		$tuitiontime2='';
		switch($row['classtype']){
			case "W":
				$classtype = "Weekly";
				$tuitionclass_day=$row['day'];
				$tuitiontime=$row['starttime'];
				$tuitionclass_day2="-";
				$tuitiontime2="-";

			break;
			case "V":
				$classtype = "Weekly x 2";
				$tuitionclass_day=$row['day'];
				$tuitiontime=$row['starttime'];
				$tuitionclass_day2=$row['day2'];
				$tuitiontime2=$row['starttime2'];
			break;
			case "S":
				$classtype = "Special";
				$tuitionclass_day="-";
				$tuitiontime="-";
				$tuitionclass_day2="-";
				$tuitiontime2="-";
			break;
			case "M":
				$classtype = "Monthly";
				$tuitionclass_day="-";
				$tuitiontime="-";
				$tuitionclass_day2="-";
				$tuitiontime2="-";

			break;


		}


		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		switch($callfrom){
		case "listtuitionclassrpt.php":
			$frmAction="<form action='viewclassincome.php' method='POST' target='_blank'>".
					"<input type='image' src='images/list.gif' name='submit' title='View Payment Report'>".
					"<input type='hidden' value='$tuitionclass_id' name='tuitionclass_id'>".
					"<input type='hidden' name='action' value='edit'></FORM></td>".
					"<td class='$rowtype' style='text-align:center;'></td>";
	
		break;
		default :
			$frmAction="<form action='tuitionclassrpt.php' method='POST'>".
			"<input type='image' src='images/edit.gif' name='submit' title='Edit this record'>".
			"<input type='hidden' value='$tuitionclass_id' name='tuitionclass_id'>".
			"<input type='hidden' name='action' value='edit'></FORM></td>".
			"<td class='$rowtype' style='text-align:center;'>".
			"<form action='attendance.php' method='post'>".
			"<input type='hidden' value='$tuitionclass_id' name='tuitionclass_id'>".
			"<input type='hidden' name='action' value='attendance' >".
			"<input type='image' src='images/list.gif' name='submit' title='View this class attendance'></form>";

		break;
		}

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$organization_code</td>
			<td class="$rowtype" style="text-align:center;">$period_name</td>
			<td class="$rowtype" style="text-align:center;">
			  <a href="tuitionclassrpt.php?action=edit&tuitionclass_id=$tuitionclass_id">
				$tuitionclass_code</A>
			</td>
			<td class="$rowtype" style="text-align:center;">$description</td>
			<td class="$rowtype" style="text-align:center;">$headcount</td>
			<td class="$rowtype" style="text-align:center;">$classtype</td>
			<td class="$rowtype" style="text-align:center;">$classcount</td>
			<td class="$rowtype" style="text-align:center;">$tuitionclass_day<br>$tuitionclass_day2</td>
			<td class="$rowtype" style="text-align:center;">$tuitiontime<br>$tuitiontime2</td>
			<td class="$rowtype" style="text-align:center;">$hours</td>
			<td class="$rowtype" style="text-align:center;">$tutor</td>
			<td class="$rowtype" style="text-align:center;">$amt</td>
			<td class="$rowtype" style="text-align:center;">$totalfees</td>
			<td class="$rowtype" style="text-align:center;">$receivedamt</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
			$frmAction
			</td>

		</tr>
EOF;
	}
$totalreceivedamt=number_format($totalreceivedamt,2);
$totalallfees=number_format($totalallfees,2);
echo <<< EOF
<tr>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;">Total ($this->cur_symbol):</td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;">$totalheadcount</td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;">$totalallfees</td>
			<td class="head" style="text-align:center;">$totalreceivedamt</td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
		</tr>
EOF;
	echo  "</tr></tbody></table>";
 }//showTuitionClassrptTable

public function showMiniTuitionClassrptTable($wherestring="WHERE t.isactive='Y'",$orderbystring="order by pr.period_name,t.tuitionclass_code,t.day,t.starttime",$callfrom="s"){
	
	$this->log->showLog(3,"Showing Tuition Class Table");
	$sql=$this->getSQLStr_AllTuitionClassrpt($wherestring,$orderbystring,0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border="1" cellspacing="1">
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Period</th>
				<th style="text-align:center;">Class Code</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Student Qty</th>
				<th style="text-align:center;">Class Type</th>
				<th style="text-align:center;">Class Count</th>
				<th style="text-align:center;">Day</th>
				<th style="text-align:center;">Time</th>
				<th style="text-align:center;">Hours</th>
				<th style="text-align:center;">Tutor</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;" colspan="2">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	$frmTarget="";
	$totalreceivedamt=0;
	$totalallfees=0;
	$totalheadcount=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$tuitionclass_id=$row['tuitionclass_id'];
		$tuitionclass_code=$row['tuitionclass_code'];
		$description=$row['description'];
		

		$organization_code=$row['organization_code'];
		$period_name=$row['period_name'];
		$tutor = $row['employee_name'];
		$classcount = $row['classcount'];
		$classtype="";

		$headcount = $row['headcount'];
		$hours=number_format($row['hours'],1);
		$totalhours=number_format($totalhours+$hours,1);
		$amt = $row['amt'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];
		$totalfees=$row['totalfees'];
		$receivedamt=$row['receivedamt'];
		$totalreceivedamt=$receivedamt+$totalreceivedamt;
		$totalallfees=$totalfees+$totalallfees;
		$classtype="";
		$totalheadcount=$headcount+$totalheadcount;
//		$classcount=$row['classtype'];
		$tuitionclass_day2='';
		$tuitiontime2='';
		switch($row['classtype']){
			case "W":
				$classtype = "Weekly";
				$tuitionclass_day=$row['day'];
				$tuitiontime=$row['starttime'];
				$tuitionclass_day2="-";
				$tuitiontime2="-";

			break;
			case "V":
				$classtype = "Weekly x 2";
				$tuitionclass_day=$row['day'];
				$tuitiontime=$row['starttime'];
				$tuitionclass_day2=$row['day2'];
				$tuitiontime2=$row['starttime2'];
			break;
			case "S":
				$classtype = "Special";
				$tuitionclass_day="-";
				$tuitiontime="-";
				$tuitionclass_day2="-";
				$tuitiontime2="-";
			break;
			case "M":
				$classtype = "Monthly";
				$tuitionclass_day="-";
				$tuitiontime="-";
				$tuitionclass_day2="-";
				$tuitiontime2="-";

			break;


		}


		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		switch($callfrom){
		case "listtuitionclassrpt.php":
			$frmAction="<form action='viewclassincome.php' method='POST' target='_blank'>".
					"<input type='image' src='images/list.gif' name='submit' title='View Payment Report'>".
					"<input type='hidden' value='$tuitionclass_id' name='tuitionclass_id'>".
					"<input type='hidden' name='action' value='edit'></FORM></td>".
					"<td class='$rowtype' style='text-align:center;'></td>";
	
		break;
		default :
			$frmAction="<form action='tuitionclassrpt.php' method='POST'>".
			"<input type='image' src='images/edit.gif' name='submit' title='Edit this record'>".
			"<input type='hidden' value='$tuitionclass_id' name='tuitionclass_id'>".
			"<input type='hidden' name='action' value='edit'></FORM></td>".
			"<td class='$rowtype' style='text-align:center;'>".
			"<form action='attendance.php' method='post'>".
			"<input type='hidden' value='$tuitionclass_id' name='tuitionclass_id'>".
			"<input type='hidden' name='action' value='attendance' >".
			"<input type='image' src='images/list.gif' name='submit' title='View this class attendance'></form>";

		break;
		}

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$organization_code</td>
			<td class="$rowtype" style="text-align:center;">$period_name</td>
			<td class="$rowtype" style="text-align:center;">
			  <a href="tuitionclassrpt.php?action=edit&tuitionclass_id=$tuitionclass_id">
				$tuitionclass_code</A>
			</td>
			<td class="$rowtype" style="text-align:center;">$description</td>
			<td class="$rowtype" style="text-align:center;">$headcount</td>
			<td class="$rowtype" style="text-align:center;">$classtype</td>
			<td class="$rowtype" style="text-align:center;">$classcount</td>
			<td class="$rowtype" style="text-align:center;">$tuitionclass_day<br>$tuitionclass_day2</td>
			<td class="$rowtype" style="text-align:center;">$tuitiontime<br>$tuitiontime2</td>
			<td class="$rowtype" style="text-align:center;">$hours</td>
			<td class="$rowtype" style="text-align:center;">$tutor</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
			$frmAction
			</td>

		</tr>
EOF;
	}
$totalreceivedamt=number_format($totalreceivedamt,2);
$totalallfees=number_format($totalallfees,2);
echo <<< EOF
<tr>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;">Total ($this->cur_symbol):</td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;">$totalheadcount</td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
		</tr>
EOF;
	echo  "</tr></tbody></table>";
 }
 /**
   * Return a selection box for day, if day'd assign it will auto select the day
   *
   * @param string $day
   * @return string a selection box
   * @access public
   */
public function selectDay($day,$ctrlname='day'){
switch ($day){
case "MON":
$SELECTMON="SELECTED='SELECTED'";
break;
case "TUE":
$SELECTTUE="SELECTED='SELECTED'";
break;
case "WED":
$SELECTWED="SELECTED='SELECTED'";
break;
case "THU":
$SELECTTHU="SELECTED='SELECTED'";
break;
case "FRI":
$SELECTFRI="SELECTED='SELECTED'";
break;
case "SAT":
$SELECTSAT="SELECTED='SELECTED'";
break;
case "SUN":
$SELECTSUN="SELECTED='SELECTED'";
break;

}
$selectday="<SELECT name='$ctrlname' onchange='triggerday()'>
		<option value='MON' $SELECTMON>MON</option>
		<option value='TUE' $SELECTTUE>TUE</option>
		<option value='WED' $SELECTWED>WED</option>
		<option value='THU' $SELECTTHU>THU</option>
		<option value='FRI' $SELECTFRI>FRI</option>
		<option value='SAT' $SELECTSAT>SAT</option>
		<option value='SUN' $SELECTSUN>SUN</option>

	</select>";
return $selectday;
}//selectDay

 /**
   * return new created class id, if can't find return -1
   *
   * @param 
   * @return int tuitionclass_id
   * @access public
   */
  public function getLatestClassID(){
	$sql="SELECT MAX(tuitionclass_id) as tuitionclass_id from $this->tabletuitionclass;";
	$this->log->showLog(3, "Retrieveing last tuitionclass id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['tuitionclass_id'];
	else
	return -1; 
  }//getLatestClassID

 /**
   * Display tuition class table
   *
   * @param 
   * @return 
   * @access public
   */
  public function getSelectTuitionClassrpt($id,$showactive='Y'){
	$wherestring="";
	if($showactive=='Y'){
		$wherestring="where c.tuitionclass_id>0 AND (c.isactive='Y' or c.tuitionclass_id=$id) ";
	}
	$this->log->showLog(3,"Access Tuitionclass selection with id: $id");
	$sql="SELECT c.tuitionclass_id,c.tuitionclass_code,pr.period_name,o.organization_code
		from $this->tabletuitionclass c 
		inner join $this->tableproductlist p on c.product_id=p.product_id 
		inner join $this->tableperiod pr on c.period_id=pr.period_id 
		inner join $this->tableorganization o on o.organization_id=c.organization_id
		$wherestring order by tuitionclass_code, pr.period_name  ;";
	$this->log->showLog(4,"With SQL: $sql");
	$selectctl="<SELECT name='tuitionclass_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"> </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$tuitionclass_id=$row['tuitionclass_id'];
		$tuitionclass_code=$row['tuitionclass_code'] . "-" .
			 $row['period_name']."-".$row['organization_code'];
	
		if($id==$tuitionclass_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$tuitionclass_id' $selected>$tuitionclass_code</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;

  }//getSelectTuitionClassrpt


  public function savefile($tmpfile){
	move_uploaded_file($tmpfile, "upload/tuitionclass/$this->tuitionclass_id".".pdf");
  }

  public function deletefile(){
	$filename="upload/tuitionclass/$this->tuitionclass_id".".pdf";
	unlink("$filename");
  }
  

  public function allowDelete($tuitionclass_id){
	$this->log->showLog(3,"Verified whether tuitionclass_id: $tuitionclass_id is deletable");
	$sql="SELECT count(studentclass_id) as countid from $this->tablestudentclass where tuitionclass_id=$tuitionclass_id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	$recordcount=0;
	if($row=$this->xoopsDB->fetchArray($query))
		$recordcount=$row['countid'];
	
	if($recordcount=="" || $recordcount==0){
		return true;
		$this->log->showLog(4,"Record deletable, count: $recordcount");
	
	}
	else{
		$this->log->showLog(4,"Record not deletable, count: $recordcount");
		return false;
	}
  }

  public function cloneclass($tuitionclass_id){
	$this->log->showLog(3,"Cloning tuitionclass_id:$tuitionclass_id, code: $tuitionclass_code");
	$sql = "SELECT tuitionclass_id,product_id,employee_id,description,day,period_id,organization_id,
			starttime,endtime,tuitionclass_code, hours,classtype,classcount,isactive
			FROM $this->tabletuitionclass 
			WHERE tuitionclass_id=$tuitionclass_id";
	$this->log->showLog(4,"With SQL1: $sql");
	$timestamp= date("y/m/d H:i:s", time()) ;
	
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$tuitionclass_id=$row['tuitionclass_id'];
		$product_id=$row['product_id'];
		$organization_id=$row['organization_id'];
		$period_id=$row['period_id'];
		$employee_id=$row['employee_id'];
		$description=$row['description'];
		$day=$row['day'];
		$hours=$row['hours'];
		$isactive=$row['isactive'];
		$starttime=$row['starttime'];
		$endtime=$row['endtime'];
		$tuitionclass_code=$row['tuitionclass_code'];
		$classcount=$row['classcount'];
		$classtype=$row['classtype'];
		if(strlen($starttime)==3)
			$starttime="0" . $starttime;
		elseif(strlen($starttime)==2)
			$starttime="00" . $starttime;
		elseif(strlen($starttime)==1)
			$starttime="000" . $starttime;
		elseif(strlen($starttime)==0)
			$starttime="0000";

		$endtime=$row['endtime'];
		if(strlen($endtime)==3)
			$endtime="0" . $endtime;
		elseif(strlen($endtime)==2)
			$endtime="00" . $endtime;
		elseif(strlen($endtime)==1)
			$endtime="000" . $endtime;
		elseif(strlen($endtime)==0)
			$endtime="0000";


	$sqlInsertClass="INSERT INTO $this->tabletuitionclass (product_id, period_id, employee_id, description,
			 day, starttime, isactive, endtime, organization_id, createdby, created, updatedby, updated, 
			 clone_id, tuitionclass_code,hours,classtype,classcount) VALUES (
			 $product_id,$period_id, $employee_id, '$description', '$day', '$starttime', '$isactive', 
			'$endtime', $organization_id, $this->createdby, '$timestamp', $this->updatedby,
			 '$timestamp',0 , '$tuitionclass_code',$hours,'$classtype',$classcount);";

	$this->log->showLog(4,"With SQL2: $sqlInsertClass");
	if($this->xoopsDB->query($sqlInsertClass)){

		$this->log->showLog(3,"Class $tuitionclass_code cloned successfully, prepare to clone student.");
		$latest_id=$this->getLatestClassID();

		$sqlActiveRegistration = "SELECT studentclass_id, student_id, tuitionclass_id,
				isactive, futuretrainingfees,
				futuretransportfees, comeareafrom_id, transactiondate,
				backareato_id, comeactive,backactive, organization_id,
				createdby, created, updatedby, updated FROM $this->tablestudentclass WHERE
				tuitionclass_id=$tuitionclass_id and isactive='Y'";

	$this->log->showLog(4,"with $sqlActiveRegistration");
	$query=$this->xoopsDB->query($sqlActiveRegistration);
	while($row=$this->xoopsDB->fetchArray($query)){

		$studentclass_id=$row['studentclass_id'];
		$student_id=$row['student_id'];
		$tuitionclass_id=$row['tuitionclass_id'];
		$isactive=$row['isactive'];
		$trainingfees=$row['futuretrainingfees'];
	
		$transportfees=$row['futuretransportfees'];
		$comeareafrom_id=$row['comeareafrom_id'];

		$transactiondate=$row['transactiondate'];
		$backareato_id=$row['backareato_id'];

		$organization_id=$row['organization_id'];
		$createdby=$row['createdby'];
		$created=$row['created'];
		$comeactive=$row['comeactive'];
		$backactive=$row['backactive'];
		$updatedby=$row['updatedby'];
		$updated=$row['updated'];


		$sqlInsertClass="INSERT INTO $this->tablestudentclass (student_id, tuitionclass_id, isactive, 
				amt, transportfees, comeareafrom_id,   transactiondate, 
				backareato_id, organization_id, createdby, created, updatedby,
				updated,clone_id, futuretrainingfees,futuretransportfees,comeactive, backactive) 
				VALUES (
				$student_id,$latest_id, 'Y',$trainingfees,
				$transportfees,$comeareafrom_id,'$transactiondate',$backareato_id,
				$organization_id, $this->createdby,'$timestamp',
				$this->updatedby,'$timestamp',0, $trainingfees,$transportfees,
				'$comeactive','$backactive')";

		$this->log->showLog(3,"Cloning studentclass: $studentclass_id, student_id: $student_id");
		$this->log->showLog(4,"With SQL: $sqlInsertClass");

		$result=$this->xoopsDB->query($sqlInsertClass);
		if(!$result){
			$this->log->showLog(1,"Error while Cloning studentclass: $studentclass_id, stdent: $student_id");
		}
		else{
			$this->log->showLog(1,"Success Cloning studentclass: $studentclass_id, student: $student_id");
		}
		
	

	}
	$sqlgetschedule="SELECT schedule_id,employee_id,class_datetime FROM $this->tableclassschedule
			WHERE tuitionclass_id=$tuitionclass_id";
	$this->log->showLog(4,"Cloning schedule with SQL1:$sqlgetschedule");

	$qryschedule=$this->xoopsDB->query($sqlgetschedule);
	while($rowschedule=$this->xoopsDB->fetchArray($qryschedule)){
	$employee_id =$rowschedule['employee_id'];
	$class_datetime =$rowschedule['class_datetime'];
	$sqlinsertschedule="INSERT INTO $this->tableclassschedule (employee_id,class_datetime,
			created,createdby,updated,updatedby,tuitionclass_id) VALUES ($employee_id,'$class_datetime',
			'$this->created',$this->createdby,'$this->updated','$this->updatedby','$latest_id')";
	$this->log->showLog(4,"Cloning schedule with SQL2:$sqlinsertschedule");
	$scheduleresult=$this->xoopsDB->query($sqlinsertschedule);
	if(!$scheduleresult)
		$this->log->showLog(1,"Error while schedule_id $schedule_id");	
	else
		$this->log->showLog(1,"Success Cloning schedule: $schedule_id");
		
		}	
	return true;

	}
	else{
		$this->log->showLog(3,"Class $tuitionclass_code cloned failed.");
		return false;
	}
  }

}

  public function genDefaultDate($day,$period_id){

	$i=0;
	$daycount=0;
	$insertstr="";
	$sql="SELECT concat(year,'-',month) as period_name from $this->tableperiod where period_id=$period_id";
	$query=$this->xoopsDB->query($sql);
	$period_name="";
	if($row=$this->xoopsDB->fetchArray($query))
		$period_name=$row['period_name'];
	$this->log->showLog(4,"Gen period_name: $period_name  via SQL: $sql");

	while($i<31){
		$i++;
		$loopdate=strtotime($period_name . "-$i");
		$weekday= strtoupper(date("D", $loopdate));
		$date1=date("Y-m-d",$loopdate);

		//$this->log->showLog(4,"Looping Date: $loopdate | $date1 | $weekday ");
		if($day==$weekday){
		$class_datetime=$date1 . " " . substr($this->starttime,0,2) . ":".
				strrev(substr(strrev($this->starttime),0,2))  . ":00";
		$sqlinsert="INSERT INTO $this->tableclassschedule (employee_id, class_datetime, tuitionclass_id, 
			created,createdby,updated,updatedby) 
			VALUES
			($this->employee_id, '$class_datetime', $this->tuitionclass_id,
			'$this->created','$this->createdby','$this->updated','$this->updatedby')";
		if($this->xoopsDB->query($sqlinsert))
		$this->log->showLog(4,"Sqlinsert success: $sqlinsert");
		else
		$this->log->showLog(4,"<b style='color:red;'>Sqlinsert failed: $sqlinsert</b>");
		$daycount++;
		}
	}

	if($daycount==4)
		$this->genEmptyDate(1);
	
	//$insertstr=substr_replace($insertstr,"",-1);


	$this->log->showLog(4,"Last insertstr: $insertstr  for day:$daycount");
	return $insertstr;
	}

  public function genDefaultDate2($period_id){

	$i=0;
	$daycount=0;
	$day=$this->day;
	$day2=$this->day2;
	$insertstr="";
	$sql="SELECT concat(year,'-',month) as period_name from $this->tableperiod where period_id=$period_id";
	$query=$this->xoopsDB->query($sql);
	$period_name="";
	if($row=$this->xoopsDB->fetchArray($query))
		$period_name=$row['period_name'];
	$this->log->showLog(4,"Gen period_name: $period_name  via SQL: $sql");

	while($i<31){
		$i++;
		$loopdate=strtotime($period_name . "-$i");
		$weekday= strtoupper(date("D", $loopdate));
		$date1=date("Y-m-d",$loopdate);

		//$this->log->showLog(4,"Looping Date: $loopdate | $date1 | $weekday ");
		if($day==$weekday || $day2==$weekday){

		if($day==$weekday)
		$class_datetime=$date1 . " " . substr($this->starttime,0,2) . ":".
				strrev(substr(strrev($this->starttime),0,2))  . ":00";
		else
		$class_datetime=$date1 . " " . substr($this->starttime2,0,2) . ":".
				strrev(substr(strrev($this->starttime2),0,2))  . ":00";


		$sqlinsert="INSERT INTO $this->tableclassschedule (employee_id, class_datetime, tuitionclass_id, 
			created,createdby,updated,updatedby) 
			VALUES
			($this->employee_id, '$class_datetime', $this->tuitionclass_id,
			'$this->created','$this->createdby','$this->updated','$this->updatedby')";
		if($this->xoopsDB->query($sqlinsert))
		$this->log->showLog(4,"Sqlinsert success: $sqlinsert");
		else
		$this->log->showLog(4,"<b style='color:red;'>Sqlinsert failed: $sqlinsert</b>");
		$daycount++;
		}
	}

	if($daycount==8){
		$this->genEmptyDate();
		$this->genEmptyDate();
	}
	if($daycount==9)
		$this->genEmptyDate();
	
	//$insertstr=substr_replace($insertstr,"",-1);


	$this->log->showLog(4,"Last insertstr: $insertstr  for day:$daycount");
	return $insertstr;
	}

  public function showSearchForm(){
	echo <<< EOF
	<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span 
		style="font-weight: bold;">Search Tuition Class</span></big></big></big></div><br>
	<div><A href='tuitionclassrpt.php?action=searchgroup' astyle='color: gray'> [SHOW STUDENT (SEARCH BY CLASS)]</A></div>
	<form name="frmSearchClass" action="tuitionclassrpt.php" method="POST">
	<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
	      <td class="head">Class Code</td>
	      <td class="even"><input name="tuitionclass_code" > (BM%, %/P1/%, BI/%/01)</td>
		  <td  class="head">Period</td>
	      <td  class="odd">$this->seachperiodctrl</td>
	    </tr>
	    <tr>	
	      <td  class="head">Status</td>
	      <td  class="even"><SELECT name="active"><option value="">NULL</option><option 
			value='Y'>Yes</option><option value='N'>No</option></select></td>
		<td  class="head">Organization</td>
	      <td  class="even">$this->seachorgctrl</td></tr>
	
		<tr>
	      <td  class="head">Tutor</td>
	      <td  class="even">$this->seachempctrl</td>
	      <td  class="head">Operation</td>
	      <td class="odd"><input type="reset" value="reset" name="reset">     <input type="submit" value="search" 
		name="action"></td>
	    </tr>
	  </tbody>	
	</table>

	</form>
	<br>
EOF;
}

  public function showSearchFormGroup(){
	
	echo <<< EOF
	
	
	<form name="frmSearchClassGroup" action="tuitionclassrpt.php" method="POST">
	
	<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	<tr>
		<input type="hidden" name="action" value="showform">
		<td class="head">Class Code</td>
		<td class="even"><input name="tuitionclass_code" value="$this->tuitionclass_code"> (BM%, %/P1/%, BI/%/01)</td>
		<td  class="head">Tutor</td>
		<td  class="even">$this->employeectrl</td>
		
	</tr>

	<tr>
		<td class="head">Class Name</td>
		<td class="even"><input name="description" value="$this->description"> (A%, %A%, A%B)</td>
		<td  class="head">Category</td>
		<td  class="even">$this->categoryctrl</td>
		
	</tr>

	<tr>
		<td class="head">Standard</td>
		<td class="even">$this->standardctrl</td>
		<td  class="head">Product</td>
		<td  class="even">$this->productctrl</td>
		
	</tr>
	
	<tr>
		<td  class="head">Period</td>
		<td  class="even">$this->periodctrl</td>
		<td  class="head">Operation</td>
		<td class="even">
		<input type="reset" value="reset" name="reset">     
		<input type="submit" value="search" name="btnSubmit">
		</td>
	</tr>

	<tr style="display:none">	
		<td  class="head">Status</td>
		<td  class="even">
		<SELECT name="active">
			<option value="">NULL</option>
			<option value='Y'>Yes</option><option value='N'>No</option>
		</select>
		</td>
		<td  class="head">Organization</td>
		<td  class="even">$this->seachorgctrl</td>
	</tr>

	  </tbody>	
	</table>

	</form>
	<br>
EOF;
  }

  public function showSearchGroupTable2(){
	$wherestring = "";
	$wherestring .= $this->getWhereStringGroup();
	$sql = "select *,d.hp_no as  hpno_student, d.tel_1 as tel_student, d.dateofbirth as dob_student, c.classjoindate as jd_student 
				from 	$this->tabletuitionclass a, $this->tableproductlist b, $this->tablestudentclass c, 
				$this->tablestudent d, $this->tableemployee e, $this->tableschool f 
				WHERE a.product_id = b.product_id 
				and a.tuitionclass_id = c.tuitionclass_id 
				and c.student_id = d.student_id 
				and a.employee_id = e.employee_id 
				and d.school_id = f.school_id 
				and a.isactive = 'Y' 
				$wherestring 
				order by a.tuitionclass_code, d.student_name asc";

	$this->log->showLog(4,"Grouping Class with SQL:$sql");

echo <<< EOF
	<table>
	<tbody>
		
		<tr>
		<th style='text-align:center' width="8%">No</th>
		
		<th style='text-align:center' width="92%">Class Info </th>
		</tr>
  		
EOF;
	$i = 0;
	$j = 0;
	$k = 0;

	$initclass = "";
	$rowtype = "";
	$query=$this->xoopsDB->query($sql);
	
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	
	$tuitionclass_code = $row['tuitionclass_code'];
	$student_name = $row['student_name'];
	$alternate_name = $row['alternate_name'];
	$employee_name = $row['employee_name'];
	$joindate = $row['jd_student'];
	$dateofbirth = $row['dob_student'];
	$hp_no = $row['hpno_student'];
	$tel_1 = $row['tel_student'];
	$classtype = $row['classtype'];
	$day = $row['day'];
	$starttime = $row['starttime'];
	$endtime = $row['endtime'];
	$starttime2 = $row['starttime2'];
	$endtime2 = $row['endtime2'];
	$school_name = $row['school_name'];
	$mth = (int)substr($joindate,5,2);
	$currentmonth=(int)date("m",time());
	$mth=$currentmonth-$mth+12;

	if($mth>=12){
	$duration = $this->getDuration($joindate);
	$mth=($mth-12) . "/12";
	}
	else{
	$duration = $this->getDuration($joindate)-1;
	$mth=$mth . "/12";

	}

	$age = $this->getDuration($dateofbirth);

	if($duration <= 0)
	$duration = "";

	$duration = $duration." ".$mth;

	$contact_no = "";

	if($hp_no != ""){
	$contact_no .= $hp_no;
		if($tel_1 != "")
		$contact_no .= "/".$tel_1;
	}else{
		if($tel_1 != "")
		$contact_no .= $tel_1;
	}
	
	
	if($initclass != $tuitionclass_code){
	$initclass = $tuitionclass_code;
	$k = 0;
	$k++;

	if($rowtype=="odd")
	$rowtype="even";
	else
	$rowtype="odd";

	}else{
	$k++;
	}


	$texttype = "";
	$texttype2 = "";
	$classtypename = "";
	if($classtype == "W"){
	$classtypename = "Weekly";
	$texttype = $day." ".$starttime."-".$endtime;
	}else if($classtype == "V"){
	$classtypename = "Weekly x 2";
	$texttype = $day." ".$starttime."-".$endtime;
	$texttype2 = " / ".$day." ".$starttime2."-".$endtime2;
	}else if($classtype == "M"){
	$classtypename = "Whole Month";
	}else if($classtype == "S"){
	$classtypename = "Special Schedule";
	}


	if($k == 1){
	$j++;

echo <<< EOF
	<tr style="vertical-align:top">
	<td class="$rowtype" align=right><font size="5px">$j</font></td>
	
	<td class="$rowtype">
	
	<table border=0>
	<tr>
	<td></td>
	<td></td>
	<td width="15%"><font size="2px"><b><u>$tuitionclass_code</u></b></font></td>
	<td width="35%"><font size="2px"><b><u>$employee_name</u></b></font></td>
	<td width="15%"><font size="2px"><b><u>$classtypename</u></b></font></td>
	<td width="35%"><font size="2px"><b><u>$texttype $texttype2</u></b></font></td>
	</tr>
	</table>
	
	<table border=0>
	
	
EOF;
	}

	if($rowtype=="odd")
	$rowtype2="even";
	else
	$rowtype2="odd";

echo <<< EOF
	
	<tr>
	<td></td>
	<td width="2%" class="$rowtype2" nowrap>$k</td>
	<td width="48%" class="$rowtype2">$alternate_name</td>
	<td width="20%" class="$rowtype2">$school_name</td>
	<td width="10%" class="$rowtype2">$duration</td>
	<td width="10%" class="$rowtype2">$age</td>
	<td width="10%" class="$rowtype2">$contact_no</td>
	</tr>
	
EOF;

	$countline = $this->getLastNo($tuitionclass_code);

	if($k == $countline){
echo <<< EOF
	</table>
	</td></tr>
EOF;
	}
	
	}

echo <<< EOF
	</tbody>
	</table>
EOF;
  }

  public function showSearchGroupTable(){

	$wherestring = "";
	$wherestring .= $this->getWhereStringGroup();
	$sql = "select *  
				from 	$this->tabletuitionclass a, $this->tableproductlist b, $this->tablestudentclass c, 
				$this->tablestudent d, $this->tableemployee e, $this->tableschool f 
				WHERE a.product_id = b.product_id 
				and a.tuitionclass_id = c.tuitionclass_id 
				and c.student_id = d.student_id 
				and a.employee_id = e.employee_id 
				and d.school_id = f.school_id 
				and a.isactive = 'Y' 
				$wherestring 
				group by a.tuitionclass_code 
				order by a.tuitionclass_code, d.student_name asc";

	$this->log->showLog(4,"Grouping Class with SQL:$sql");

	$query=$this->xoopsDB->query($sql);

echo <<< EOF
	<table border=1>
	
	<tr>
	<th align="center">No</th>
	<th colspan="6" align="center">Class Info</th>
	</tr>
EOF;
	$i = 0;
	$rowtype = "";
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;

	$tuitionclass_id = $row['tuitionclass_id'];
	$tuitionclass_code = $row['tuitionclass_code'];
	$employee_name = $row['employee_name'];
	$classtype = $row['classtype'];
	$day = $row['day'];
	$starttime = $row['starttime'];
	$endtime = $row['endtime'];
	$starttime2 = $row['starttime2'];
	$endtime2 = $row['endtime2'];

	$sqlsub = "select *,d.hp_no as  hpno_student, d.tel_1 as tel_student, d.dateofbirth as dob_student, c.classjoindate as jd_student 
				from 	$this->tabletuitionclass a, $this->tableproductlist b, $this->tablestudentclass c, 
				$this->tablestudent d, $this->tableemployee e, $this->tableschool f 
				WHERE a.product_id = b.product_id 
				and a.tuitionclass_id = c.tuitionclass_id 
				and c.student_id = d.student_id 
				and a.employee_id = e.employee_id 
				and d.school_id = f.school_id 
				and a.isactive = 'Y' 
				and a.tuitionclass_id = $tuitionclass_id 
				order by a.tuitionclass_code, d.student_name asc";


	$texttype = "";
	$texttype2 = "";
	$classtypename = "";
	if($classtype == "W"){
	$classtypename = "Weekly";
	$texttype = $day." ".$starttime."-".$endtime;
	}else if($classtype == "V"){
	$classtypename = "Weekly x 2";
	$texttype = $day." ".$starttime."-".$endtime;
	$texttype2 = " / ".$day." ".$starttime2."-".$endtime2;
	}else if($classtype == "M"){
	$classtypename = "Whole Month";
	}else if($classtype == "S"){
	$classtypename = "Special Schedule";
	}


	if($rowtype=="odd")
	$rowtype="even";
	else
	$rowtype="odd";

	$this->log->showLog(4,"Sub table with SQL:$sqlsub");

	$querysub=$this->xoopsDB->query($sqlsub);


echo <<< EOF
	
	<tr>
	<td rowspan="2" width="5%" class="$rowtype" align="right"><font size="5px">$i</font></td>
	<td awidth="1%" aclass="$rowtype"></td>
	<td awidth="1%" aclass="$rowtype"></td>
	<td width="10%" nowrap class="$rowtype"><font size="2px"><b><u>$tuitionclass_code</u></b></font></td>
	<td width="28%" class="$rowtype"><font size="2px"><b><u>$employee_name</u></b></font></td>
	<td width="28%" class="$rowtype"><font size="2px"><b><u>$classtypename</u></b></font></td>
	<td width="29%" class="$rowtype"><font size="2px"><b><u>$texttype $texttype2</u></b></font></td>
	</tr>

	<tr>
	<td colspan="6" class="$rowtype">
	<table>
EOF;
	$k = 0;
	while($rowsub=$this->xoopsDB->fetchArray($querysub)){
	$k++;
	
	$student_name = $rowsub['student_name'];
	$alternate_name = $rowsub['alternate_name'];
	$joindate = $rowsub['jd_student'];
	$dateofbirth = $rowsub['dob_student'];
	$hp_no = $rowsub['hpno_student'];
	$tel_1 = $rowsub['tel_student'];
	$school_name = $rowsub['school_name'];
	$mth = (int)substr($joindate,5,2);
	$currentmonth=(int)date("m",time());
	$mth=$currentmonth-$mth+12;
	echo "$dateofbirth,";
	if($mth>=12){
	$duration = $this->getDuration($joindate);
	$mth=($mth-12) . "/12";
	}
	else{
	$duration = $this->getDuration($joindate)-1;
	$mth=$mth . "/12";

	}

	$age = $this->getDuration($dateofbirth);

	

	if($duration <= 0)
	$duration = "";

	$duration = $duration." ".$mth;

	$contact_no = "";

	if($hp_no != ""){
	$contact_no .= $hp_no;
		if($tel_1 != "")
		$contact_no .= "/".$tel_1;
	}else{
		if($tel_1 != "")
		$contact_no .= $tel_1;
	}
	

echo <<< EOF
	<tr>
	<td></td>
	<td width="2%" aclass="$rowtype2" nowrap>$k</td>
	<td width="48%" aclass="$rowtype2">$alternate_name</td>
	<td width="20%" aclass="$rowtype2">$school_name</td>
	<td width="10%" aclass="$rowtype2">$duration</td>
	<td width="10%" aclass="$rowtype2">$age</td>
	<td width="10%" aclass="$rowtype2">$contact_no</td>
	</tr>

EOF;

	}

echo <<< EOF
	</table>
	</td>
	</tr>

EOF;

	}

echo <<< EOF
	</table>
EOF;

  }

  public function getLastNo($tuitionclass_code){
	$retval = 0;
	$wherestring = "";
	$wherestring .= $this->getWhereStringGroup();
	$sql = "select count(*) as tot 
				from 	$this->tabletuitionclass a, $this->tableproductlist b, $this->tablestudentclass c, 
				$this->tablestudent d, $this->tableemployee e, $this->tableschool f 
				WHERE a.product_id = b.product_id 
				and a.tuitionclass_id = c.tuitionclass_id 
				and c.student_id = d.student_id 
				and a.employee_id = e.employee_id 
				and d.school_id = f.school_id 
				and a.isactive = 'Y' 
				and a.tuitionclass_code = '$tuitionclass_code' 
				$wherestring 
				group by a.tuitionclass_code 
				order by a.tuitionclass_code, d.student_name asc";

	$this->log->showLog(4,"Grouping Class with SQL:$sql");

	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['tot'];
	}

	return $retval;

  }

  public function getWhereStringGroup(){
	$wherestr = "";
	
	if($this->tuitionclass_code != "")
	$wherestr .= " and a.tuitionclass_code like '$this->tuitionclass_code' ";
	if($this->description != "")
	$wherestr .= " and a.description like '$this->description' ";
	if($this->employee_id > 0)
	$wherestr .= " and a.employee_id like '$this->employee_id' ";
	if($this->period_id > 0)
	$wherestr .= " and a.period_id like '$this->period_id' ";
	if($this->category_id > 0)
	$wherestr .= " and b.category_id like '$this->category_id' ";
	if($this->standard_id > 0)
	$wherestr .= " and b.standard_id like '$this->standard_id' ";
	if($this->product_id > 0)
	$wherestr .= " and b.product_id like '$this->product_id' ";

	return $wherestr;

  }

  public function getDuration($date){
         list($year,$month,$day) = explode("-",$date);
         $year_diff  = date("Y") - $year;
       //  $month_diff = date("m") - $month;
       //  $day_diff   = date("d") - $day;
       // if ($month_diff < 0)
        //  $year_diff--;
	
	//if($month_diff == 0)
	//	if($day_diff < 0)
	//	$year_diff--;

        return $year_diff;
  }


  public function removeschedule($tuitionclass_id,$count=0){
	$this->log->showLog(3,"Remove class schedule for tuition class id: $tuitionclass_id");
	if($count==0){
	$sql="DELETE FROM $this->tableclassschedule WHERE tuitionclass_id=$tuitionclass_id";
	if($this->xoopsDB->query($sql))
	$this->log->showLog(3,"Remove success:$sql");
	else
	$this->log->showLog(3,"Remove failed:$sql");

	}
	else{
	$i=0;
	while($i<$count){
	$sql="DELETE FROM $this->tableclassschedule WHERE 
		schedule_id=(SELECT b.id from (SELECT MAX(a.schedule_id) as id FROM $this->tableclassschedule a
			WHERE a.tuitionclass_id=$tuitionclass_id) b)";
	$this->log->showLog(3,"With SQL :$sql");
	$result=$this->xoopsDB->query($sql) or die(mysql_error());
	if( $result )
	$this->log->showLog(3,"Remove successfully");
	else
	$this->log->showLog(3,"<b style='color:red;'>Remove failed!</b>");

	$i++;
	}
   }
 }

  public function getScheduleCount($tuitionclass_id){
	$this->log->showLog(3,"Calculate schedule under class: $this->tuitionclass_id");
	$sql="SELECT count(tuitionclass_id) as count from $this->tableclassschedule WHERE 
		tuitionclass_id=$tuitionclass_id";
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$result=$row['count'];
	if($result>0)
	return $result;
	else
	return 0;
	}		
  }
  public function genEmptyDate($tuitionclass_id,$count=1){
	$this->log->showLog(3,"Add $count empty schedule for tuition class id: $this->tuitionclass_id");
	$i=0;
	while($i<$count){
	$sqlinsert="INSERT INTO $this->tableclassschedule (employee_id, class_datetime, tuitionclass_id, 
			created,createdby,updated,updatedby) 
			VALUES
			($this->employee_id, '0000-00-00 00:00:00', $this->tuitionclass_id,
			'$this->created','$this->createdby','$this->updated','$this->updatedby')";
	$this->log->showLog(4,"With SQL: $sqlinsert");

	if($this->xoopsDB->query($sqlinsert))
	$this->log->showLog(3,"Create empty schedule successfully");
	else
	$this->log->showLog(3,"<b style='color:red;'>Create empty schedule failed</b>");
	
	$i++;
	}

  }

  public function showschedule($tuitionclass_id){
	$this->log->showLog(3,"show schedule for tuition class id: $this->tuitionclass_id");
	$sql="SELECT s.schedule_id,s.class_datetime,s.employee_id,e.employee_name 
		FROM $this->tableclassschedule s inner join $this->tableemployee e on e.employee_id=s.employee_id
		where s.tuitionclass_id=$tuitionclass_id  order by s.schedule_id";
	$this->log->showLog(4,"With SQL: $sql");


	$query=$this->xoopsDB->query($sql);
	$result="<Table border='0'><tr><td style='text-align:center'><B>No</B></td>
		<td style='text-align:center'><B>Date/Time</B></td>
		<td style='text-align:center'><B>Tutor</B></td></tr><tbody>";
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
		$schedule_id=$row['schedule_id'];
		$class_datetime=$row['class_datetime'];
		$employee_id=$row['employee_id'];
		$employee_name=$row['employee_name'];
		$result=$result . "<tr><td style='text-align:center'>$i</td>
			<td style='text-align:center'>$class_datetime</td>
			<td style='text-align:center'>$employee_name</td></tr>";
	}
	$result=$result."</tbody></table>
			<A href='schedule.php?action=edit&tuitionclass_id=$this->tuitionclass_id'>
				Change Schedule/Tutor</A>";
	return $result;
	}

  public function showTest($tuitionclass_id){
	$this->log->showLog(3,"show Test for tuition class id: $this->tuitionclass_id");
	$sql="SELECT t.test_id,t.test_name,t.test_description,t.averagemark, t.highestmark, t.lowestmark,t.testdate
		FROM $this->tabletest t 
		inner join $this->tabletuitionclass tc on tc.tuitionclass_id=t.tuitionclass_id
		where t.tuitionclass_id=$tuitionclass_id  order by t.test_id";
	$this->log->showLog(4,"With SQL: $sql");


	$query=$this->xoopsDB->query($sql);
	$result="<Table border='0' width='60'><tr>
		<td style='text-align:center'><B>No</B></td>
		<td style='text-align:center'><B>Date</B></td>
		<td style='text-align:center'><B>Test Title</B></td>
		<td style='text-align:center'><B>MIN</B></td>
		<td style='text-align:center'><B>MAX</B></td>
		<td style='text-align:center'><B>AVG</B></td>
		<td style='text-align:center'><B>Operation</B></td></tr><tbody>";
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
		$test_id=$row['test_id'];
		$test_name=$row['test_name'];
		$averagemark=$row['averagemark'];
		$highestmark=$row['highestmark'];
		$lowestmark=$row['lowestmark'];
		$testdate=$row['testdate'];
		$result=$result . "<tr>
				<td style='text-align:center'>$i</td>
				<td style='text-align:center'>$testdate</td>
				<td style='text-align:center'>$test_name</td>
				<td style='text-align:center'>$lowestmark</td>
				<td style='text-align:center'>$highestmark</td>
				<td style='text-align:center'>$averagemark</td>
			<td style='text-align:center'>
			<A href='test.php?action=edit&tuitionclass_id=$this->tuitionclass_id&test_id=$test_id'>
				Edit
			</A></td></tr>";
	}
	$result=$result."</tbody></table><br>
		  <A href='test.php?action=add&tuitionclass_id=$this->tuitionclass_id&employee_id=$this->employee_id'>
				Add Test</A>";
	return $result;
	}
  public function showClassHeader($tuitionclass_id){
	$this->log->showLog(3,"Fetching class detail");

	$sql="SELECT c.tuitionclass_id, c.tuitionclass_code, c.description, c.day, c.starttime, c.endtime,
		 e.employee_id, e.employee_name, e.hp_no, d.period_name, o.organization_code,c.classtype,p.amt
		from $this->tabletuitionclass c 
		inner join $this->tableemployee e 
		inner join $this->tableperiod d 
		inner join $this->tableproductlist p 
		inner join $this->tableorganization o 
		where c.tuitionclass_id=$tuitionclass_id and c.employee_id=e.employee_id 
		and c.period_id=d.period_id and c.product_id=p.product_id";
	$this->log->showLog(4,"With SQL:$sql");
	
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$tuitionclass_code=$row["tuitionclass_code"];
		$period_name=$row["period_name"];
		$organization_code=$row['organization_code'];
		$description=$row["description"];
		$amt=$row["amt"];
		$day=$row["day"];
		$classtype="";
		switch($row['classtype']){
		case "W":
		$classtype="Weekly";
		break;
		case "M":
		$classtype="Monthy";
		break;
		case "S":
		$classtype="Special";
		break;
		default:
		$classtype="Weekly";
		break;
		}

		$this->day=$day;
		$starttime=$row["starttime"];
		$endtime=$row["endtime"];
		$employee_name=$row["employee_name"];
		$e_hp_no=$row["hp_no"];

	$this->log->showLog(4,"Tuition class->fetchTuitionClassrptDetail, database fetch into class successfully");
	$this->log->showLog(3,"Showing Class Header");
echo <<< EOF
<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
<tbody>
	<tr>
		<th colspan="3"><big><big><big><span style="font-weight: bold;">Class Code: 
			<A href="tuitionclassrpt.php?action=edit&tuitionclass_id=$tuitionclass_id" >
			$tuitionclass_code
			</A>
		</span></big></big></big></td>
		<th colspan="3"><big><big><big><span style="font-weight: bold;">Month: $period_name</span></big></big></big></td>
	</tr>
	<tr>
		<td class="head">Class Description :</td>
		<td class="odd">$description</td>
		<td class="head">Fees :</td>
		<td class="odd">RM $amt</td>

	</tr>
	<tr>
		<td class="head" >Organization</td>
		<td class="even" >$organization_code</td>
		<td class="head" >Class Type</td>
		<td class="even" >$classtype</td>
	</tr>
	<tr>
		<td class="head" >Tutor :</td>
		<td class="even" >$employee_name</td>
		<td class="head" >Tutor Contact :</td>
		<td class="even" >$e_hp_no</td>
	</tr>
	
	
</tbody>
</table>
EOF;
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Attendance->fetchTuitionClassrptDetail, failed to fetch data into databases.");
	} 
 }
} // end of TuitionTransaction
?>

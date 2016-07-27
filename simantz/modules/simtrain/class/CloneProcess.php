<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);



/**
 * class Organization
 * Difference branches, training/tuition center
 */
class CloneProcess
{

  /** Aggregations: */

  /** Compositions: */

   
  public $organization_id;
  public $clone_id;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $type;
  public $status;
  public $orgctrl;
  public $iscompletelastmonth;
  public $periodctrl_from;
  public $cur_name;
  public $cur_symbol;
  public $periodctrl_to;
  public $periodfrom_id;
  public $periodto_id;
  public $monthto=0;
  public $yearto=0;

  public $periodto_name;
  public $clonedclass_id="";

  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $tableperiod;
  private $tablecloneprocess;
  private $log;
  private $tableclassschedule;
  private $tabletuitionclass;
  private $tablestudentclass;

  /**
   *
   * @param xoopsDB 
   * @param tableprefix 
   * @access public, constructor
   */
  public function CloneProcess($xoopsDB, $tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tableperiod=$tableprefix . "simtrain_period";
	$this->tablecloneprocess=$tableprefix . "simtrain_cloneprocess";
	$this->tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
	$this->tablestudentclass=$tableprefix . "simtrain_studentclass";
	$this->tableclassschedule=$tableprefix."simtrain_classschedule";
	$this->log=$log;
   }

  /**
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
  */
  public function getSQLStr_AllClone( $wherestring,  $orderbystring,  $startlimitno ) {
    $sql= "SELECT c.periodfrom_id,c.periodto_id,c.organization_id,c.created,c.updated,c.type,c.clone_id,c.status,o.organization_name,".
	" p1.period_name as period1, p2.period_name as period2,c.created,c.updated  FROM $this->tablecloneprocess c ".
	" inner join $this->tableorganization o on c.organization_id=o.organization_id ".
	" inner join $this->tableperiod p1 on c.periodfrom_id=p1.period_id ".
	" inner join $this->tableperiod p2 on c.periodto_id=p2.period_id $wherestring $orderbystring limit 0,50";
	$this->log->showLog(4,"Calling getSQLStr_AllOrganization:" .$sql);
   return $sql;
   } // end of member function getSQLStr_AllOrganization

 
  /**
   *
   * @param string type 'new' or 'edit'

   * @param int organization_id 
   * @return bool
   * @access public
  */
  public function getInputForm( $type,  $organization_id,$token ) {
	$this->log->showLog(3,"Displaying form for user perform clone/reverse process.");
    echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Clone Process</span></big></big></big></div><br>-->
<form onsubmit="return validateClone()" method="post"
 action="clone.php" name="frmClone">
  <table style="text-align: left; width: 100%;" border="1"
 cellpadding="2" >
    <tbody>
      <tr>
        <th colspan="2" rowspan="1" style="text-align:center;">Clone Process</th>
      </tr>
      <tr>
	<td class="head">Organization</td>
	<td  class="even">$this->orgctrl</td>
      </tr>
      <tr>
	<td  class="head">From Period</td>
	<td  class="odd">$this->periodctrl_from</td>
      </tr>
 	<tr>
	<td  class="head">Target Period (Ignore this field when you perform Reverse Clone Process)</td>
	<td  class="even">$this->periodctrl_to</td>
      </tr>
      <tr>
	<td  class="head"><b>Type</b> <br>
		Month End: Clone Active Tuition Class and Active Student Registration <br>
		Year End: Only clone Active Tuition Class to next year</td>
	<td  class="odd"><SELECT name="type"><OPTION value="M">Month End</OPTION><OPTION value="Y">Year End</OPTION></SELECT></td>
	</tr>
	<tr>
		<td  class="head">Clone Class <br>
		Clone only all active class to next period. User need to manually join student into each class. <br>
		Normally it use for year end.</td>
	<td  class="even"><input type="submit" name="action" value="Clone Class"></td>
      </tr>
     </tbody>
  </table>
  <br>



EOF;
  } // end of member function getInputForm
 
 
/**
   *
   * @return int
   * @access public
  */
  public function getLatestCloneID() {
	$sql="SELECT MAX(clone_id) as clone_id from $this->tablecloneprocess;";
	$this->log->showLog(3,"Retriving latest clone id with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['clone_id'];
	else
	return -1;
	
  } // end of member function getLatestOrganizationID

 /**
   *
   * @return int
   * @access public
  */
  public function getLatestClassID() {
	$sql="SELECT MAX(tuitionclass_id) as tuitionclass_id from $this->tabletuitionclass;";
	$this->log->showLog(3,"Retriving latest tuitionclass id with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['tuitionclass_id'];
	else
	return -1;
	
  } // end of member function getLatestOrganizationID

  /**
   *insert clone process into database
   * @return bool
   * @access public
  */
  public function insertClone( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new clone process into database");
 	$sql="INSERT INTO $this->tablecloneprocess (organization_id, periodfrom_id,periodto_id,type,status,created,createdby,".
		" updated,updatedby) VALUES ($this->organization_id, $this->periodfrom_id,$this->periodto_id, '$this->type',".
		" 'Initial','$timestamp',$this->createdby,'$timestamp',$this->updatedby)";

	$this->log->showLog(4,"Before insert Clone Process SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert clone process");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new clone successfully"); 
		return true;
	}
} // end of member function insertOrganization

 
  /**
   *
   * @param int periodfrom_id 
   * @return bool
   * @access public
  */
  public function completelastmonth( $clone_id ) {
    	$this->log->showLog(2,"Warning:Updateting all tuitionclass under period $periodfrom_id to complete state");
	$sql="UPDATE $this->tabletuitionclass SET isactive='N',nextclone_id=$this->clone_id where tuitionclass_id in ($this->clonedclass_id)";
	$this->log->showLog(4,"With SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: can't update all lastmonth tuition class to complete state");
		return false;
	}
	else{
		$this->log->showLog(3,"All last month tuition class update to completed state successfully!");
		return true;
		
	}
	
  } // end of member function deleteOrganization


 /** Clone active class at periodfrom_id
   *
   * @param int clone_id 
   * @return bool
   * @access public
  */
  public function cloneClass($clone_id){
	$this->log->showLog(3,"Under Clone Class Process, period: $this->periodfrom_id - $this->periodto_id. ".
				" organization: $this->organization_id");	
	
	//get last month active class
	$sqlActiveClass = "SELECT tuitionclass_id,product_id,employee_id,description,day, day2,room_id,room_id2,
			starttime,starttime2,endtime,endtime2,tuitionclass_code,hours,classtype,classcount
			  FROM $this->tabletuitionclass WHERE period_id=$this->periodfrom_id AND isactive='Y' 
			 and organization_id=$this->organization_id";

	$this->log->showLog(4,"with $sqlActiveClass");	
	$query=$this->xoopsDB->query($sqlActiveClass);
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)) {
		$i++;
		$tuitionclass_id=$row['tuitionclass_id'];
		$product_id=$row['product_id'];
		$employee_id=$row['employee_id'];
		$description=$row['description'];
		$classtype=$row['classtype'];
		$classcount=$row['classcount'];
		$day=$row['day'];
		$room_id=$row['room_id'];
		$room_id2=$row['room_id2'];

		$day2=$row['day2'];
		$hours=$row['hours'];
		$starttime=$row['starttime'];
		if(strlen($starttime)==3)
			$starttime="0" . $starttime;
		elseif(strlen($starttime)==2)
			$starttime="00" . $starttime;
		elseif(strlen($starttime)==1)
			$starttime="000" . $starttime;
		elseif(strlen($starttime)==0)
			$starttime="0000";

		$starttime2=$row['starttime2'];
		if(strlen($starttime2)==3)
			$starttime2="0" . $starttime2;
		elseif(strlen($starttime2)==2)
			$starttime2="00" . $starttime2;
		elseif(strlen($starttime2)==1)
			$starttime2="000" . $starttime2;
		elseif(strlen($starttime2)==0)
			$starttime2="0000";

		$classtime1=substr($starttime,0,2) . ":".
				strrev(substr(strrev($starttime),0,2))  . ":00";
		$classtime2=substr($starttime2,0,2) . ":".
				strrev(substr(strrev($starttime2),0,2))  . ":00";
		$endtime=$row['endtime'];

		if(strlen($endtime)==3)
			$endtime="0" . $endtime;
		elseif(strlen($endtime)==2)
			$endtime="00" . $endtime;
		elseif(strlen($endtime)==1)
			$endtime="000" . $endtime;
		elseif(strlen($endtime)==0)
			$endtime="0000";

		$endtime2=$row['endtime2'];
		if(strlen($endtime2)==3)
			$endtime2="0" . $endtime2;
		elseif(strlen($endtime2)==2)
			$endtime2="00" . $endtime2;
		elseif(strlen($endtime2)==1)
			$endtime2="000" . $endtime2;
		elseif(strlen($endtime2)==0)
			$endtime2="0000";

		$tuitionclass_code=$row['tuitionclass_code'];

		//keep which data cloned from database.
		if($i>1)
		$this->clonedclass_id=$this->clonedclass_id . "," . $tuitionclass_id;
		else
		$this->clonedclass_id=$tuitionclass_id;

		//echo "Currentclassid:$tuitionclass_id ??????????????????";


		$sqlInsertClass="INSERT INTO $this->tabletuitionclass (product_id, period_id, employee_id, 
				description, day,day2, starttime,starttime2, isactive, endtime,endtime2, 
				organization_id, createdby,
				created, updatedby, updated, clone_id, tuitionclass_code,hours,classtype,classcount,
				room_id,room_id2) VALUES (
				$product_id,$this->periodto_id, $employee_id, '$description', '$day','$day2', 
				'$starttime','$starttime2', 'Y', '$endtime','$endtime2', 
				$this->organization_id, $this->createdby, '$this->created',
				 $this->updatedby,'$this->updated',$clone_id , '$tuitionclass_code',$hours,
				'$classtype',$classcount,$room_id,$room_id2);";

		$this->log->showLog(3,"Cloning class: $tuitionclass_code, description: $description");
		$this->log->showLog(4,"With SQL: $sqlInsertClass");

		
		//start check class clone
		$checkTCRecord = $this->checkExistTCRecord($tuitionclass_code,$this->periodto_id,$this->organization_id);
		$checkExistTC = false;
		$checkExistTC = $checkTCRecord[0];
		$existTCID = $checkTCRecord[1];
		if(!$checkExistTC)//end check class clone
		$result=$this->xoopsDB->query($sqlInsertClass);

		if(!$result && !$checkExistTC){//check class clone
		//if(!$result){
			$this->log->showLog(1,"Error while Cloning class: $tuitionclass_code, description: $description");
			return false;
		}
		else{
			//$this->log->showLog(1,"Success Cloning class: $tuitionclass_code, description: $description");
			
			//echo $existTCID;
			//start check clone
			if($existTCID > 0)
			$newtuitionclass_id = $existTCID;
			else//end check clone
			$newtuitionclass_id=$this->getLatestClassID();
//start clone schedule
			if($this->type=='M'){
			if($this->cloneStudentRegistration($clone_id,$tuitionclass_id,$newtuitionclass_id)){
					$this->log->showLog(3,"Clone 1 tuitionclass successfully.");
				}
				else{
				$this->log->showLog(1,"Failed to 1 clone student class: $tuitionclass_code, description: $description");
			}
			}


		if(!$checkExistTC){//end check class clone
		
		if($classtype=='W'){
		//$sqlgetschedule="SELECT schedule_id,employee_id,
		//	time_format(class_datetime,'%H:%i:%S') as classtime FROM $this->tableclassschedule
		//	WHERE tuitionclass_id=$tuitionclass_id ";
			$this->log->showLog(4,"Cloning schedule weekly");
		//	$qryschedule=$this->xoopsDB->query($sqlgetschedule);
			$s=0;
			 while($s<5){
			//$rowschedule=$this->xoopsDB->fetchArray($qryschedule)){
			//	$employee_id =$rowschedule['employee_id'];
			//	$classtime =$rowschedule['classtime'];
				$classdate=$this->genDefaultDate($day,$this->periodto_id,$s);
				$class_datetime =$classdate . ' ' .$classtime1;
				$sqlinsertschedule="INSERT INTO $this->tableclassschedule (employee_id,class_datetime,
					created,createdby,updated,updatedby,tuitionclass_id) VALUES
					 ($employee_id,'$class_datetime','$this->created',$this->createdby,
					'$this->updated','$this->updatedby','$newtuitionclass_id')";
				$this->log->showLog(4,"Cloning schedule with SQL2:$sqlinsertschedule");
				$scheduleresult=$this->xoopsDB->query($sqlinsertschedule);
				if(!$scheduleresult)
					$this->log->showLog(1,"Error while schedule_id $schedule_id");	
				/*else
					$this->log->showLog(1,"Success Cloning schedule: $schedule_id");*/
				$s++;		
			 }
			}		
		elseif($classtype=='V'){
		//$sqlgetschedule="SELECT schedule_id,employee_id,
		//	time_format(class_datetime,'%H:%i:%S') as classtime FROM $this->tableclassschedule
		//	WHERE tuitionclass_id=$tuitionclass_id ";
			$this->log->showLog(4,"Cloning schedule weeklyx2");
			//$qryschedule=$this->xoopsDB->query($sqlgetschedule);
			$s=0;
			 while($s<10){
				//$employee_id =$rowschedule['employee_id'];
				//$classtime =$rowschedule['classtime'];
				$classdate=$this->genDefaultDate2($day,$day2,$this->periodto_id,$s);
				if($s % 2 ==0)
				$class_datetime =$classdate . ' ' .$classtime1;
				else
				$class_datetime =$classdate . ' ' .$classtime2;

				$sqlinsertschedule="INSERT INTO $this->tableclassschedule (employee_id,class_datetime,
					created,createdby,updated,updatedby,tuitionclass_id) VALUES
					 ($employee_id,'$class_datetime','$this->created',$this->createdby,
					'$this->updated','$this->updatedby','$newtuitionclass_id')";
				$this->log->showLog(4,"Cloning schedule with SQL2:$sqlinsertschedule");
				$scheduleresult=$this->xoopsDB->query($sqlinsertschedule);
				if(!$scheduleresult)
					$this->log->showLog(1,"Error while schedule_id $schedule_id");	
				/*else
					$this->log->showLog(1,"Success Cloning schedule: $schedule_id");*/
				$s++;		
			 }

			}
			elseif($classtype=='S'){
//------
			$this->log->showLog(3,"Add $count empty schedule for 
				tuition class id: $this->tuitionclass_id");
			$i=0;
			while($i<$classcount){
				$sqlinsert="INSERT INTO $this->tableclassschedule (employee_id,
				   class_datetime, tuitionclass_id, 
				  created,createdby,updated,updatedby) 
				  VALUES
				  ($employee_id, '0000-00-00 00:00:00', $newtuitionclass_id,
			  	  '$this->created','$this->createdby','$this->updated','$this->updatedby')";
				  $this->log->showLog(4,"With SQL: $sqlinsert");

				if($this->xoopsDB->query($sqlinsert))
					$this->log->showLog(3,"Create empty schedule successfully");
				else
					$this->log->showLog(3,"<b style='color:red;'>Create empty schedule 
							failed</b>");
	
				$i++;
				}
//---
			}

		}

		}	

		}

	
	return true;
  } // end function cloneClass

/** check existing record for clone
   *
   * @param int tuitionclass_code 
   * @param int period_id 
   * @access public
  */

  public function checkExistTCRecord($tuitionclass_code,$period_id,$organization_id){
	$retval1 = false;
	$retval2 = 0;

	$sql = "select tuitionclass_id from $this->tabletuitionclass 
		where tuitionclass_code = '$tuitionclass_code' and period_id = $period_id 
		and organization_id = $organization_id ";

	$this->log->showLog(4,"check existing tuition class with $sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval1 = true;
	$retval2 = $row['tuitionclass_id'];
	}

	return array($retval1,$retval2);

  }

  public function checkExistSCRecord($student_id,$tuitionclass_id,$organization_id){
	$retval = false;

	$sql = "select student_id from $this->tablestudentclass 
		where student_id = $student_id and tuitionclass_id = $tuitionclass_id 
		and organization_id = $organization_id ";

	$this->log->showLog(4,"check existing student class with $sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = true;
	}

	return $retval;

  }

 /** clone active student registration at periodfrom_id
   *
   * @param int clone_id 
   * @return bool
   * @access public
  */
  public function cloneStudentRegistration($clone_id,$tuitionclass_id,$newtuitionclass_id){

	$this->log->showLog(3,"Under cloning student registration for tuitionclass_id:$tuitionclass_id, clone_id: $clone_id");	
	
	//get last month active class
	$sqlActiveRegistration = "SELECT studentclass_id, student_id, tuitionclass_id, isactive, futuretrainingfees,
				futuretransportfees, comeareafrom_id, transactiondate,classjoindate,
				backareato_id, comeactive,backactive,  organization_id, 
				createdby, created, updatedby, updated FROM $this->tablestudentclass WHERE
				tuitionclass_id=$tuitionclass_id AND isactive='Y'";
	$this->log->showLog(4,"with $sqlActiveRegistration");
	$query=$this->xoopsDB->query($sqlActiveRegistration);

	while($row=$this->xoopsDB->fetchArray($query)){

		$studentclass_id=$row['studentclass_id'];
		$student_id=$row['student_id'];
		$tuitionclass_id=$row['tuitionclass_id'];
		$isactive=$row['isactive'];
		$trainingfees=$row['futuretrainingfees'];
		$classjoindate=$row['classjoindate'];

		$transportfees=$row['futuretransportfees'];
		$comeareafrom_id=$row['comeareafrom_id'];
//		$comeareato_id=$row['comeareato_id'];

		$transactiondate=$this->yearto.'-'.$this->monthto."-01";

//		$transactiondate=$this->periodto_name."-01";
//		$backareafrom_id=$row['backareafrom_id'];
		$backareato_id=$row['backareato_id'];

		$organization_id=$row['organization_id'];
		$createdby=$row['createdby'];
		$created=$row['created'];
		$comeactive=$row['comeactive'];
		$backactive=$row['backactive'];
		$updatedby=$row['updatedby'];
		$updated=$row['updated'];

		//$transport="";
		//if($backactive=='Y' && $comeactive=='Y')
		//	$transport="D";
		//elseif($backactive=="Y")
		//	$transport="R";		
		//elseif($comeactive=='Y')
		//	$transport="C";
		//else
		//	$transport="";

		$sqlInsertClass="INSERT INTO $this->tablestudentclass (student_id, tuitionclass_id, isactive, amt,
				 transportfees, comeareafrom_id,  transactiondate, backareato_id,
				 organization_id, createdby, created, updatedby, updated,clone_id, 
				futuretrainingfees,futuretransportfees,comeactive,backactive,classjoindate) 
				VALUES(
				$student_id,$newtuitionclass_id,'Y',$trainingfees,$transportfees,$comeareafrom_id,
				'$transactiondate',$backareato_id,$organization_id,$this->createdby,'$this->created',
				 $this->updatedby,'$this->updated',$clone_id,$trainingfees,$transportfees,'$comeactive'
				,'$backactive','$classjoindate')";

		$this->log->showLog(3,"Cloning studentclass: $studentclass_id, student_id: $student_id");
		$this->log->showLog(4,"With SQL: $sqlInsertClass");

		
		//start student clone
		$checkSCRecord = $this->checkExistSCRecord($student_id,$newtuitionclass_id,$this->organization_id);
		$checkExistSC = false;
		$checkExistSC = $checkSCRecord;
		if(!$checkExistSC){//end student clone
		//echo $newtuitionclass_id;
		$result=$this->xoopsDB->query($sqlInsertClass);
		}

		if(!$result && !$checkExistSC){//check student clone
		//if(!$result){
			$this->log->showLog(1,"Error while Cloning studentclass: $studentclass_id, student: $student_id. This record may exist it current class");
		}
		else{
			//$this->log->showLog(1,"Success Cloning studentclass: $studentclass_id, student: $student_id");
		}
		
	

	}
	return true;
	
  }

/** Delete all transaction related to clone_id
   *
   * @param int clone_id 
   * @return bool
   * @access public
*/
  public function deleteCloneData( $clone_id ) {
	
	$this->log->showLog(3,"Warning! Remove data under clone_id: $clone_id");

	$sql1="DELETE FROM $this->tablestudentclass where clone_id=$clone_id";	
	$sql2="DELETE FROM $this->tabletuitionclass where clone_id=$clone_id";

	$this->log->showLog(4,"With SQL : $sql1 <br> & $sql2");
	
	$rs1=$this->xoopsDB->query($sql1);
	$rs2=$this->xoopsDB->query($sql2);

	if($rs1 && $rs2){
	$this->log->showLog(3,"Data related to clone id: $clone_id removed successfully");
		return true;
	}
	else{

	$this->log->showLog(1,"Error! Data cannot remove from database.");	
		return false;
	}
  } // end of member function fetchOrganization
 
 

/**
   * Display a table for all organization
   *
   * @access public
  */
 public function showCloneHistoryTable(){
	
	$this->log->showLog(3,"Showing Clone History Table");
	$sql=$this->getSQLStr_AllClone("where clone_id>0","ORDER BY c.clone_id DESC ",0);

	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table>
  		<tbody>
    			<tr><th style="text-align:center;" colspan="10">Clone History (Top 50 Records only)</th></tr><tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Process ID</th>
				<th style="text-align:center;">Period From</th>
				<th style="text-align:center;">Period To</th>
				<th style="text-align:center;">Clone Type</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Status</th>
				<th style="text-align:center;">Created</th>
				<th style="text-align:center;">Updated</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$period1=$row['period1'];
		$organization_name=$row['organization_name'];
		$period2=$row['period2'];
		$type=$row['type'];
		$status=$row['status'];
		$updated=$row['updated'];
		$clone_id=$row['clone_id'];
		$created=$row['created'];
		$updated=$row['updated'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		$frmctrl="";
		if($status!="Reversed")
			$frmctrl="<form action='clone.php' method='POST'>".
				"<input type='submit' value='reverse' name='action'>".
				"<input type='hidden' value='$clone_id' name='clone_id'></form>";
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$clone_id</td>
			<td class="$rowtype" style="text-align:center;">$period1</td>
			<td class="$rowtype" style="text-align:center;">$period2</td>
			<td class="$rowtype" style="text-align:center;">$type</td>
			<td class="$rowtype" style="text-align:center;">$organization_name</td>
			<td class="$rowtype" style="text-align:center;">$status</td>
			<td class="$rowtype" style="text-align:center;">$created</td>
			<td class="$rowtype" style="text-align:center;">$updated</td>
			<td class="$rowtype" style="text-align:center;">$frmctrl</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }


  public function updateclonestatus($clone_id,$processname){
	$timestamp= date("y/m/d H:i:s", time()) ;
	$sql="";
	$this->log->showLog(3,"Change clone process infor for $clone_id, with processtype:$processname");
	if($processname=="reverse")
		$sql="UPDATE $this->tablecloneprocess set status='Reversed',updated='$timestamp',updatedby=$this->updatedby where clone_id=$clone_id";
	else
		$sql="UPDATE $this->tablecloneprocess set status='Complete', clonedclass_id='$this->clonedclass_id' where clone_id=$clone_id";

	$this->log->showLog(4,"SQL: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	
	if($rs){
	$this->log->showLog(3,"Update Clone status ID: $clone_id successfully");
	return true;
	}
	else{
	$this->log->showLog(2,"Warning! Can't update clone status id: $clone_id");
	return false;	
	}

  } //updateclonestatus

 public function reactivateclass($clone_id){
	$this->log->showLog(3,"Re-Activate data related to clone_id: $clone_id:");
	$sql="UPDATE $this->tabletuitionclass set isactive='Y' where nextclone_id=$clone_id";
	$this->log->showLog(4,"SQL: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	
	if($rs){
	$this->log->showLog(3,"Re-Activate data relate to $clone_id successfully");
	return true;
	}
	else{
	$this->log->showLog(1,"Error! Can't reactivate data related to clone_id: $clone_id");
	return false;	
	}

  } //updateclonestatus

 public function genDefaultDate($day,$period_id,$s){

	$i=0;
	$daycount=0;
	$insertstr="";
		$sql="SELECT concat(year,'-',case when length(month)=1 then concat('0',month) else month end ) as period_name from $this->tableperiod where period_id=$period_id";
	$query=$this->xoopsDB->query($sql);
	$period_name="";
	if($row=$this->xoopsDB->fetchArray($query))
		$period_name=$row['period_name'];
	$this->log->showLog(4,"Gen day:$day for period_name: $period_name  via SQL: $sql");
	while($i<31){
		$i++;
		$loopdate=strtotime($period_name . "-$i");
		$weekday= strtoupper(date("D", $loopdate));
		$date1=date("Y-m-d",$loopdate);

		$this->log->showLog(4,"Looping Date: $loopdate | $date1 | $weekday ");

	if(substr_replace($date1,"",-3) != $period_name)
			break;

		if($day==$weekday){
		
		$this->log->showLog(4,"Gen insertstr: $insertstr with for day:$daycount");
		if($daycount==$s)
		return $period_name."-".$i;
		$daycount++;

		}
	}

	//if($daycount==4)
	//	$insertstr=$insertstr.",0";
	
	//$insertstr=substr_replace($insertstr,"",-1);

	
//$this->log->showLog(4,"Last insertstr: $insertstr  for day:$daycount");
	return "0000-00-00";
	

	}

public function genDefaultDate2($day,$day2,$period_id,$s){

	$i=0;
	$daycount=0;
	$insertstr="";
	$sql="SELECT concat(year,'-',case when length(month)=1 then concat('0',month) else month end ) as period_name from $this->tableperiod where period_id=$period_id";
	$query=$this->xoopsDB->query($sql);
	$period_name="";
	if($row=$this->xoopsDB->fetchArray($query))
		$period_name=$row['period_name'];
	$this->log->showLog(4,"Gen day:$day for period_name: $period_name  via SQL: $sql");
	while($i<31){
		$i++;
		$loopdate=strtotime($period_name . "-$i");
		$weekday= strtoupper(date("D", $loopdate));
		$date1=date("Y-m-d",$loopdate);

		$this->log->showLog(4,"Looping Date: $loopdate | $date1 | $weekday ");
		if(substr_replace($date1,"",-3) != $period_name)
			break;
		if($day==$weekday || $day2==$weekday){
		
		$this->log->showLog(4,"Gen insertstr: $insertstr with for day:$daycount");
		if($daycount==$s)
		return $period_name."-".$i;
		$daycount++;

		}
	}

//	if($daycount==4)
	//	$insertstr=$insertstr.",0";
	
	//$insertstr=substr_replace($insertstr,"",-1);

	
//$this->log->showLog(4,"Last insertstr: $insertstr  for day:$daycount");
	//if($daycount==)
	return "0000-00-00";
	

	}


} // end of CloneProcess
?>

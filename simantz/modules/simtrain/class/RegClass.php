<?php
class RegClass{

  public $studentclass_id=0;
  public $orgctrl;
  public $studentctrl;
  public $classctrl;
  public $areacf_ctrl;
  public $areact_ctrl;
  public $areabf_ctrl;
  public $areabt_ctrl;
  public $period;
  public $student_id;
  public $student_name;
  public $ic_no;
  public $description;
  public $student_code;
  public $createdby;
  public $updatedby;
  public $tuitionclass_id;
  public $isactive;
  public $comeactive;
  public $backactive;
  public $updatestandard;
  public $amt;
  public $paidamt;
  public $transportfees;
  public $comeareafrom_id;
  public $comeareato_id;
  public $showcalendar;
  public $ispaid;
  public $transactiondate; //it will keep the date of registration, if this record is generated via 'Clone',the date will keep as 0000-00-00
  public $backareafrom_id;
  public $backareato_id;
  public $transportationmethod;
  public $organization_id;
  public $clone_id;
  public $classjoindate;
  public $datefrom;
   public $isAdmin;
  public $dateto;
  public $cur_name;
  public $cur_symbol;
  public $datefromctrl;
  public $datetoctrl;
  public $futuretrainingfees;
  public $futuretransportfees;
  public $advance_mode;

  public $xoopsDB;
  private $log;
  public $tableprefix;
  public $tablestudentclass;
  public $tabletransport;
  public $tablestudent;
  public $tableaddress;
  public $tableproductlist;
  public $tabletuitionclass;
  public $tablepaymentline;
  public $tableemployee;
  public $tableperiod;
  public $tableorganization;
   /**
   *
   * @param xoopsDB $xoopsDB
   * @param string $tableprefix
   * @param log $log
   * Constructor for class RegClass
   * @access public
   */
  public function RegClass ($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
	$this->tableprefix=$tableprefix;
	$this->tablestudentclass=$tableprefix."simtrain_studentclass";
	$this->tablestudent=$tableprefix."simtrain_student";
	$this->tableproductlist=$tableprefix."simtrain_productlist";
	$this->tabletuitionclass=$tableprefix."simtrain_tuitionclass";
	$this->tablestandard=$tableprefix."simtrain_standard";
	$this->tableemployee=$tableprefix."simtrain_employee";
	$this->tabletransport=$tableprefix."simtrain_transport";
	$this->tablearea=$tableprefix."simtrain_area";
	$this->tableaddress=$tableprefix."simtrain_address";
	$this->tableperiod=$tableprefix."simtrain_period";
	$this->tablepaymentline=$tableprefix."simtrain_paymentline";
	$this->tableorganization=$tableprefix."simtrain_organization";
	
  } //end RegClass

   /**
   *
   * @param int $student_id
   * A simple header to tell end user what is current student
   * @access public
   */
   public function showRegistrationHeader(){
	echo <<< EOF
	<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">$this->student_name Registered Class Details</span></big></big></big></div><br>-->
	<table border='1' cellspacing='3'>
		<tbody>
			<tr>
				<th colspan="4">Student Info</th>
			</tr>
			<tr>
				<td class="head">Student Code</td>
				<td class="odd">$this->student_code</td>
				<td class="head">Student Name</td>
				<td class="odd"><A href="student.php?action=edit&student_id=$this->student_id" 
						target="_blank">$this->student_name</A></td>
			</tr>
		</tbody>
	</table>
EOF;

   }//showRegistrationHeader

   /**
   *
   * A search form for user to find a student
   * @access public
   */
  public function showSearchForm(){
   echo <<< EOF
	<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Class Registration - Search Student</span></big></big></big></div><br>-->
	<FORM id='frmSearchStudent' name='frmSearchStudent' action="regclass.php" method="POST">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criterial</th>
	    </tr>
	    <tr>
	      <td class='head'>Student Code</td>
	      <td class='even'><input name='student_code' value=''> (%, AB%,%AB,%A%B%)</td>
	      <td class='head'>Student Name</td>
	      <td class='even'><input name='student_name' value=''>%ali, %ali%, ali%, %ali%bin%</td>
	    </tr>
	    <tr>
	      <td class='head'>Quick Search</td>
	      <td class='odd'>$this->studentctrl</td>
	      <td class='head'	>IC Number</td>
	      <td class='odd'><input name='ic_no' value=''></td>
	    </tr>
	  </tbody>
	</table>
	<table style="width:150px;">
	  <tbody>
	    <tr>
	      <td><input style="height:40px;" type='submit' value='Search' name='submit'><input type='hidden' name='action' value='search'></td>
	      <td><input type='reset' value='Reset' name='reset'></td>
	    </tr>
	  </tbody>
	</table>
	</FORM>
EOF;
  }//showSearchForm

/**
   *Retrieve class registration info from database into class
   * @param int $studentclass_id 
   * 
   * @access public
   */
  public function fetchRegClassInfo($studentclass_id){
	$this->log->showLog(3,"Fetch Class Registration info for record: $studentclass_id.");
		
	$sql="SELECT studentclass_id, student_id,tuitionclass_id, isactive,classjoindate, comeactive, backactive,amt,transportfees,comeareafrom_id, transactiondate,backareato_id,organization_id,createdby,created,updatedby, updated,clone_id,futuretrainingfees,futuretransportfees,description FROM $this->tablestudentclass where studentclass_id=$studentclass_id";
	
	$this->log->showLog(4,"RegClass->fetchRegClassInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->studentclass_id=$row['studentclass_id'];
		$this->student_id	=$row['student_id'];
		$this->tuitionclass_id=$row['tuitionclass_id'];
		$this->isactive=$row['isactive'];
		$this->classjoindate=$row['classjoindate'];
 		$this->comeactive=$row['comeactive'];
 		$this->description=$row['description'];
		$this->backactive=$row['backactive'];
		$this->amt=$row['amt'];		
		$this->transportfees=$row['transportfees'];
		$this->comeareafrom_id=$row['comeareafrom_id'];
		//$this->comeareato_id	=$row['comeareato_id'];
		$this->transactiondate=$row['transactiondate'];
		//$this->backareafrom_id=$row['backareafrom_id'];
		$this->backareato_id=$row['backareato_id'];
		$this->transportationmethod=$row['transportationmethod'];
		$this->organization_id=$row['organization_id'];
		$this->createdby=$row['createdby'];
		$this->created=$row['created'];
		$this->updatedby=$row['updatedby'];
		$this->updated=$row['updated'];
		$this->futuretrainingfees=$row['futuretrainingfees'];		
		$this->futuretransportfees=$row['futuretransportfees'];

		$this->clone_id=$row['clone_id'];

	$this->log->showLog(4,"RegClass->fetchRegClassInfo, database fetch into class successfully, with studentclass_id=$this->studentclass_id");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"RegClass->fetchRegClassInfo,failed to fetch data into databases.");	
	}
  }//fetchRegClassInfo

 /**
   *
   * @param int $student_id oor $class_id
   * @param string $type can be 'student' or 'class'
   * @param string $wherestring filter string
   * @param string $orderbystring used for sort record purpose
   * Display registered class in this student or class, depends on $type
   * @access public
   */
  public function showRegisteredTable($type,$wherestring,$orderbystring,$callfrom="regclass"){
	
	//$wherestring="";
	$this->log->showLog(3,"Showing Product Table");
	$sql="";
	$operationctrl="";
	
	
	$title="";
	switch ($callfrom){
	case "regclass":
			$title="Registered Course (Active Course)";
			$sql=$this->getSQLStr_RegisteredClass($type,$wherestring,$orderbystring);
		
	break;
	case "payment":
			$title="Outstanding Payment";
			$sql=$this->getSQLStr_RegisteredClass($type,$wherestring,$orderbystring);
		
	break;
	case "default":
			$title="Registered Course (Active Course)";
			$sql=$this->getSQLStr_RegisteredClass($type,$wherestring,$orderbystring);
			
	break;
	}
	
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr><th style="text-align:center;" colspan="9">
				$title 
				<FORM name="filterClassDate" method="POST" action="regclass.php">
					Date From : <input name="datefrom" id="datefrom"><input type="button" onclick="$this->showdatefrom" value="date">
					Date To : <input name="dateto" id="dateto"><input type="button" onclick="$this->showdateto" value="date">
					<input type="hidden" name="action" value="filter">
					<input type="hidden" name="student_id" value="$this->student_id">
					<input type="submit" value="search" name="submit">
				</FORM></th></tr><tr>
				
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Class Code</th>
				<th style="text-align:center;">Class Name</th>
				<th style="text-align:center;">Period</th>
				<th style="text-align:center;">Fees ($this->cur_symbol)</th>
				<th style="text-align:center;">Transport ($this->cur_symbol)</th>
				<th style="text-align:center;">Tutor</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	$this->log->showLog(4,"Show Table with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	$totalamt;
	$totaltransportfees;
	while ($row=$this->xoopsDB->fetchArray($query) ){
		$i++;
		$studentclass_id=$row['studentclass_id'];
		$tuitionclass_code=$row['tuitionclass_code'];
		$tuitionclass_id=$row['tuitionclass_id'];
		$product_name=$row['product_name'];
		$period_name=$row['period_name'];
		$amt=$row['amt'];
		$transportfees=$row['transportfees'];
		$totalamt=$totalamt+$amt;
		$totaltransportfees=$totaltransportfees+$transportfees;

//		$transportationmethod=$row['transportationmethod'];
		$employee_name=$row['employee_name'];
		$isactive=$row['isactive'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		switch ($callfrom){
		case "regclass":
			$operationctrl="<form action='regclass.php' method='POST'>".
					"<input type='image' src='images/edit.gif' name='submit'  title='Edit this record'>".
					"<input type='hidden' value='$studentclass_id' name='studentclass_id'>".
					"<input type='hidden' name='action' value='edit'>".
					"</form>";
		break;
		case "payment":
			$operationctrl="<input type='checkbox'  value='$studentclass_id' name='classchecked[]' >" ;
		break;
		case "default":
			$operationctrl="<form action='regclass.php' method='POST'><input type='submit' value='Edit' name='submit'>".
					"<input type='hidden' value='$studentclass_id' name='studentclass_id'>".
					"<input type='hidden' name='action' value='edit'>".
					"</form>";
		break;
		}


		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">
			 <A href="tuitionclass.php?tuitionclass_id=$tuitionclass_id&action=edit">$tuitionclass_code</A>
			</td>
			<td class="$rowtype" style="text-align:center;">$product_name</td>
			<td class="$rowtype" style="text-align:center;">$period_name</td>
			<td class="$rowtype" style="text-align:center;">$amt</td>
			<td class="$rowtype" style="text-align:center;">$transportfees</td>
			<td class="$rowtype" style="text-align:center;">$employee_name</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$operationctrl</td>

		</tr>
EOF;
	}
		$totalamt=number_format($totalamt,2);
		$totaltransportfees=number_format($totaltransportfees,2);

		echo <<< EOF

		<tr>
			<td class="foot" style="text-align:center;"></td>
			<td class="foot" style="text-align:center;"></td>
			<td class="foot" style="text-align:center;"></td>
			<td class="foot" style="text-align:center;"></td>
			<td class="foot" style="text-align:center;">$totalamt</td>
			<td class="foot" style="text-align:center;">$totaltransportfees</td>
			<td class="foot" style="text-align:center;"></td>
			<td class="foot" style="text-align:center;"></td>
			<td class="foot" style="text-align:center;"></td>

		</tr></tbody></table><br>
EOF;
  }

/**
   *
   * @param string $type can be 'student' or 'class'
   * @param string $wherestring filter string
   * @param string $orderbystring used for sort record purpose
   * return sql statement to caller
   * @access public
   */
  public function getSQLStr_RegisteredClass($type,$wherestring,$orderbystring){
	$sql=""; 
	$this->log->showLog(3,"RegClass-getSQLStr_RegisteredClass($type,$wherestring,$orderbystring");
	if($type=='student'){
		$sql="SELECT sc.studentclass_id, sc.tuitionclass_id, c.isactive,sc.classjoindate, sc.comeactive, sc.backactive,
			 sc.amt, sc.transportfees,sc.comeareafrom_id, sc.transactiondate,
			 sc.backareato_id,sc.organization_id,c.tuitionclass_code,p.product_name,e.employee_name,
			 period.period_id,period.period_name 
			from $this->tablestudentclass  sc 
			inner join $this->tabletuitionclass c on sc.tuitionclass_id=c.tuitionclass_id 
			inner join $this->tableemployee e on e.employee_id=c.employee_id 
			inner join $this->tableproductlist p on p.product_id=c.product_id
			inner join $this->tableperiod period on period.period_id=c.period_id 
			$wherestring $orderbystring";
	$this->log->showLog(3,"Retrieve register class $wherestring");
	}
	elseif($type=='class'){
		$sql="SELECT sc.studentclass_id, t.student_id, t.student_code, t.student_name, t.gender, t.ic_no, t.tel_1,t.hp_no, sc.isactive,sc.classjoindate, sc.comeactive, sc.backactive, sc.amt,  sc.transportfees, sc.comeareafrom_id, sc.transactiondate , sc.backareato_id, sc.organization_id FROM $this->tablestudent t inner join $this->tablestudentclass sc on sc.student_id=t.student_id $wherestring $orderbystring";
	$this->log->showLog(3,'Retrieve register student $wherestring');
	}
	$this->log->showLog(4,"return sql: $sql");
	return $sql;
  }//end showRegisteredClass

/**
   *
   * @param string $type can be 'edit' or 'new'
   * @param int $studentclass_id
   * @param string $token for security purpose
   * Display forms for user to create/edit existing student-class registration
   * @access public
   */
  public function showInputForm($type,$studentclass_id,$token){
	$mandatorysign="<b style='color:red'>*</b>";
	$this->log->showLog(3,"Accessing RegClass->showInputForm($type,$studentclass_id,$token)");
	$checked="";
	$paidchecked="";
	$transportType="";
	$feesctrl="";
	$jumptotopayment="";
	$advancectrl = "";
     if($type=="new"){
		$this->transactiondate=date("Y-m-d", time()) ;

		if($this->classjoindate=="")
		$this->classjoindate=date("Y-m-d", time()) ;

		$header="New Class Registration";
		$action="create";
		if($studentclass_id==0){
		$this->tuitionclass_id=0;
		}

 		$advancectrl = "<form action='regclass.php' method='POST'>
				<input name='classjoindate' value='' type='hidden'>
				<input name='advance_mode' value='Y' type='hidden'>
				<input name='action' value='choosed' type='hidden'>
				<input name='student_id' value='$this->student_id' type='hidden'>
				<input type='submit' value='Advance Mode' onclick='classjoindate.value = document.frmRegClass.classjoindate.value;'>
				</form>";

		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$checked2="CHECKED";
		$deletectrl="";
		$addnewctrl="";
//	$transportType=$this->transportType("BOTH");
	}
     else{
		$action="update";
		$savectrl="<input name='studentclass_id' value='$this->studentclass_id' type='hidden'>
			<input name='oldtuitionclass_id' value='$this->tuitionclass_id' type='hidden'>
			 <input style='height:40px;' name='submit' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";
		/*
		if ($this->classjoindate=='Y')
			$checked2="CHECKED";
		else
			$checked2="";
		*/

		if ($this->comeactive=='Y')
			$comechecked="CHECKED";
		else
			$comechecked="";
		if ($this->backactive=='Y')
			$backchecked="CHECKED";
		else
			$backchecked="";
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablestudentclass' type='hidden'>".
		"<input name='id' value='$this->studentclass_id' type='hidden'>".
		"<input name='idname' value='studentclass_id' type='hidden'>".
		"<input name='title' value='Class Registration' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'  style='height: 40px;'>".
		"</form>";

		$header="Edit Registered Class Details";
		if($this->allowDelete($this->studentclass_id))
		$deletectrl="<FORM action='regclass.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this registration?"'.")'><input type='submit' value='Delete' name='submit'  style='height: 40px;'>".
		"<input type='hidden' value='$this->studentclass_id' name='studentclass_id'>".
		"<input type='hidden' value='$this->student_id' name='student_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		"<Form action='regclass.php' method='POST'><input name='submit' value='New' type='submit'></form>";
		$addnewctrl="<form action='regclass.php?action=choosed&student_id=$this->student_id' method='post'><input type='submit' value='New' name='new'></form>";
		$freesctrl="<tr><td class='head'>Training Fees ($this->cur_symbol) $mandatorysign</td><td class='even'>".
				"<input name='amt' value='$this->amt'></td>".
				"<td class='head'>Next Month Training Fees ($this->cur_symbol) $mandatorysign</td><td class='even'>".
				"<input name='futuretrainingfees' value='$this->futuretrainingfees'></td></tr>".
				"<tr><td class='head'>Transport Fees ($this->cur_symbol) $mandatorysign</td><td class='even'>".
				"<input name='transportfees' value='$this->transportfees'></td>".
				"<td class='head'>Next Month Transport Fees ($this->cur_symbol) $mandatorysign</td><td class='even'>".
				"<input name='futuretransportfees' value='$this->futuretransportfees'></td></tr>";
		$jumptotopayment="<Form action='payment.php' method='POST'>".
				"<input name='submit' value='Go To Payment' style='height: 40px;' type='submit'>".
				"<input name='action' value='choosed' type='hidden'>".
				"<input name='student_id' value='$this->student_id' type='hidden'>".
				"</form>";
		$jumptoattendance="<Form action='attendance.php' method='POST'>".
				"<input name='submit' value='Go To Attendance' style='height: 40px;' type='submit'>".
				"<input name='action' value='edit' type='hidden'>".
				"<input name='tuitionclass_id' value='$this->tuitionclass_id' type='hidden'>".
				"</form>";
//	$transportType=$this->transportType($this->transportationmethod);
//	$this->transportfees=$this->transportFees($this->transportationmethod,$this->orgctrl,$this->comeareafrom_id);
	}
	echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">$header</span></big></big></big></div><br>-->
<table style="width:140px;"><tbody><td>$addnewctrl</td>
<td>$advancectrl</td>
<td><form onSubmit="return validateRegClass()" method="post"
 action="regclass.php" name="frmRegClass"><input name="reset" value="Reset" type="reset"></td></tbody></table>
	<table border='1' cellspacing='3'>
	<tbody>
	<tr><th colspan='4'>Registration Information<input type='hidden' name="student_id" value="$this->student_id"></th></tr>
	<tr>
	<td class="head">Tuition Class </td>
	<td class="odd">$this->classctrl <a onClick="zoomClass()">zoom</a></td>
	<td class="head">Join Date</td>
	<td class="odd">
	<input name="classjoindate" id="classjoindate" value="$this->classjoindate">
	<input type='button' value='Date' onClick="$this->classjoindatectrl">
	<input type='hidden' value='1' name='organization_id'></td>

	</tr>	
	<tr>
	<td class="head">Active / Continue?</td>
	<td class="even"><input name="isactive" type="checkbox" $checked></td>
	<td class="head">Transaction Date $mandatorysign</td>
	<td class="even"><input name="transactiondate" id="transactiondate" value="$this->transactiondate">
	<input type='button' value='Date' onClick="$this->showcalendar"></td>
	</tr>
	<tr>
	<td class="head">Transport Needed? Come From <input name="comeactive" type="checkbox" $comechecked></td>
	<td class="odd">$this->areacf_ctrl</td>
	<td class="head">Transport Needed? Back To <input name="backactive" type="checkbox" $backchecked></td>
	<td class="odd">$this->areabt_ctrl</td>
	</tr>
	<tr>
	<td class="head">Update Class Standard to Student</td>
	<td class="even"><input type="checkbox" name="updatestandard"></td>
	<td class="head"></td>
	<td class="even"></td>
	</tr>
	<tr>
		<td class="head">Description</td>
		<td class="even" colspan='3'><input name="description" value="$this->description" maxlength='100' size='100'></td>

	</tr>
	$freesctrl
	</tbody>
	</table>
	<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td><td>$jumptotopayment</td><td>$jumptoattendance</td> <td>$recordctrl</td></tbody></table>

EOF;
  } //showInputForm


 public function showInputFormAdvance($type,$studentclass_id,$token){
	global $defaultorganization_id;

	$mandatorysign="<b style='color:red'>*</b>";
	$this->log->showLog(3,"Accessing RegClass->showInputForm($type,$studentclass_id,$token)");
	$checked="";
	$paidchecked="";
	$transportType="";
	$feesctrl="";
	$jumptotopayment="";
	$advancectrl = "";
     if($type=="new"){
		$this->transactiondate=date("Y-m-d", time()) ;

		if($this->classjoindate=="")
		$this->classjoindate=date("Y-m-d", time()) ;

		$header="New Class Registration";
		$action="createadvance";
		if($studentclass_id==0){
		$this->tuitionclass_id=0;
		}
		
		$advancectrl = "<form action='regclass.php' method='POST'>
				<input name='classjoindate' value='' type='hidden'>
				<input name='advance_mode' value='N' type='hidden'>
				<input name='action' value='choosed' type='hidden'>
				<input name='student_id' value='$this->student_id' type='hidden'>
				<input type='submit' value='Basic Mode' onclick='classjoindate.value = document.frmRegClass.classjoindate.value;'>
				</form>";
		/*
 		$advancectrl = "<form action='regclass.php' method='POST'>
				<input name='advance_mode' value='N' type='hidden'>
				<input name='action' value='choosed' type='hidden'>
				<input name='student_id' value='$this->student_id' type='hidden'>
				<input type='submit' value='Basic Mode'>
				</form>";*/

		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$checked2="CHECKED";
		$deletectrl="";
		$addnewctrl="";
//	$transportType=$this->transportType("BOTH");
	}
     else{
		$action="update";
		$savectrl="<input name='studentclass_id' value='$this->studentclass_id' type='hidden'>
			<input name='oldtuitionclass_id' value='$this->tuitionclass_id' type='hidden'>
			 <input style='height:40px;' name='submit' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";
		/*
		if ($this->classjoindate=='Y')
			$checked2="CHECKED";
		else
			$checked2="";
		*/

		if ($this->comeactive=='Y')
			$comechecked="CHECKED";
		else
			$comechecked="";
		if ($this->backactive=='Y')
			$backchecked="CHECKED";
		else
			$backchecked="";
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablestudentclass' type='hidden'>".
		"<input name='id' value='$this->studentclass_id' type='hidden'>".
		"<input name='idname' value='studentclass_id' type='hidden'>".
		"<input name='title' value='Class Registration' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'  style='height: 40px;'>".
		"</form>";

		$header="Edit Registered Class Details";
		if($this->allowDelete($this->studentclass_id))
		$deletectrl="<FORM action='regclass.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this registration?"'.")'><input type='submit' value='Delete' name='submit'  style='height: 40px;'>".
		"<input type='hidden' value='$this->studentclass_id' name='studentclass_id'>".
		"<input type='hidden' value='$this->student_id' name='student_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		"<Form action='regclass.php' method='POST'><input name='submit' value='New' type='submit'></form>";
		$addnewctrl="<form action='regclass.php?action=choosed&student_id=$this->student_id' method='post'><input type='submit' value='New' name='new'></form>";
		$freesctrl="<tr><td class='head'>Training Fees ($this->cur_symbol) $mandatorysign</td><td class='even'>".
				"<input name='amt' value='$this->amt'></td>".
				"<td class='head'>Next Month Training Fees ($this->cur_symbol) $mandatorysign</td><td class='even'>".
				"<input name='futuretrainingfees' value='$this->futuretrainingfees'></td></tr>".
				"<tr><td class='head'>Transport Fees ($this->cur_symbol) $mandatorysign</td><td class='even'>".
				"<input name='transportfees' value='$this->transportfees'></td>".
				"<td class='head'>Next Month Transport Fees ($this->cur_symbol) $mandatorysign</td><td class='even'>".
				"<input name='futuretransportfees' value='$this->futuretransportfees'></td></tr>";
		$jumptotopayment="<Form action='payment.php' method='POST'>".
				"<input name='submit' value='Go To Payment' style='height: 40px;' type='submit'>".
				"<input name='action' value='choosed' type='hidden'>".
				"<input name='student_id' value='$this->student_id' type='hidden'>".
				"</form>";
		$jumptoattendance="<Form action='attendance.php' method='POST'>".
				"<input name='submit' value='Go To Attendance' style='height: 40px;' type='submit'>".
				"<input name='action' value='edit' type='hidden'>".
				"<input name='tuitionclass_id' value='$this->tuitionclass_id' type='hidden'>".
				"</form>";
//	$transportType=$this->transportType($this->transportationmethod);
//	$this->transportfees=$this->transportFees($this->transportationmethod,$this->orgctrl,$this->comeareafrom_id);
	}
	echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">$header</span></big></big></big></div><br>-->
<table><tr><td>
<table style="width:140px;"><tbody><td>$addnewctrl</td>
<td>$advancectrl</td>
<td><form onSubmit="return validateRegClassAdvance()" method="post"
 action="regclass.php" name="frmRegClass"><input name="reset" value="Reset" type="reset"></td></tbody></table>
	<table border='1' cellspacing='3'>
	<tbody>
	<tr><th colspan='5'>Registration Information<input type='hidden' name="student_id" value="$this->student_id"></th></tr>
	<tr>
	<!--<td class="head">Tuition Class </td>
	<td class="odd">$this->classctrl <a onClick="zoomClass()">zoom</a></td>-->
	<td class="head">Join Date</td>
	<td class="odd" colspan="3">
	<input name="classjoindate" id="classjoindate" value="$this->classjoindate">
	<input type='button' value='Date' onClick="$this->classjoindatectrl">
	<input type='hidden' value='1' name='organization_id'></td>

	</tr>	
	<tr>
	<td class="head">Active / Continue?</td>
	<td class="even"><input name="isactive" type="checkbox" $checked></td>
	<td class="head">Transaction Date $mandatorysign</td>
	<td class="even" acolspan="1"><input name="transactiondate" id="transactiondate" value="$this->transactiondate" size="10">
	<input type='button' value='Date' onClick="$this->showcalendar"></td>
	</tr>
	<tr>
	<td class="head">Transport Needed? Come From <input name="comeactive" type="checkbox" $comechecked></td>
	<td class="odd">$this->areacf_ctrl</td>
	<td class="head">Transport Needed? Back To <input name="backactive" type="checkbox" $backchecked></td>
	<td class="odd" acolspan="1">$this->areabt_ctrl</td>
	</tr>
	<tr>
	<td class="head">Update Class Standard to Student</td>
	<td class="even"><input type="checkbox" name="updatestandard"></td>
	<td class="head"></td>
	<td class="even" acolspan="1"></td>
	</tr>
	<tr>
		<td class="head">Description</td>
		<td class="even" colspan='3'><input name="description" value="$this->description" maxlength='100' size='60'></td>

	</tr>
	$freesctrl
	</tbody>
	</table>
	<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</tbody></table>
	</td>

	<td>
	<table border=0>
	<tr>
	<td align="right"><input type="button" value="Deselect All" onclick="selectAll('2')">
	<input type="button" value="Select All" onclick="selectAll('1')"></td>
	</tr>
	</table>
	<table border=1>
	<tr>
	<th colspan="3">Tuition Class</th>
	</tr>
EOF;

	$sql="SELECT c.tuitionclass_id,c.tuitionclass_code,pr.period_name,o.organization_code, std.standard_name,c.description
		from $this->tabletuitionclass c 
		inner join $this->tableproductlist p on c.product_id=p.product_id 
		inner join $this->tablestandard std on p.standard_id=std.standard_id
		inner join $this->tableperiod pr on c.period_id=pr.period_id 
		inner join $this->tableorganization o on o.organization_id=c.organization_id 
		where c.tuitionclass_id>0 AND (c.isactive='Y' or c.tuitionclass_id=$studentclass_id) 
		order by o.organization_code,std.standard_name,tuitionclass_code";

	$rowtype="";
	$this->log->showLog(4,"Get Tuition Class with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$tuitionclass_code=$row['organization_code']."/".$row['tuitionclass_code'] . "/" .$row['period_name']."/".$row["description"];
	$tuitionclass_id = $row['tuitionclass_id'];

	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";
echo <<< EOF
	<tr>
	<input type="hidden" name="tuitionclassid_arr[$i]" value="$tuitionclass_id">
	<td class="$rowtype">$i</td>
	<td class="$rowtype"><a href="tuitionclass.php?action=edit&tuitionclass_id=$tuitionclass_id" target="_blank">$tuitionclass_code</a></td>
	<td class="$rowtype"><input type="checkbox" name="isselect_arr[$i]"></td>
	</tr>
EOF;
	}
echo <<< EOF
	</table>
	</form>
	</td>
	</tr>
	</table>

EOF;
  } //showInputForm

/**
   * display a selection box, if value assign it will autoselect the particular transport type
   * @param string transport method, can be come/back/both
   * return string selection box
   * @access public
   */
  public function transportType($transporttype){
	$selectedboth="";
	$selectedcome="";
	$selectedback="";

	switch ($transporttype){
		case "BOTH":
			$selectedboth="selected='selected'";	
		break;
		case "COME":
			$selectedcome="selected='selected'";
		break;
		case "BACK":
			$selectedback="selected='selected'";
		break;

	}
	$selectctrl="<SELECT name='transportationmethod'>".
			 "<OPTION value='BOTH' $selectedboth>BOTH</option>".
			 "<OPTION value='BACK' $selectedback>BACK</option>".
			 "<OPTION value='COME' $selectedcome>COME</option>".
			 "</SELECT>";
	
	return $selectctrl;
  }

/**
   * get default tuition fees from database
   * @param int tuitionclass
   * return decimal tuition price
   * @access public
   */
  public function defaultTrainingFees($tuitionclass_id){
	$this->log->showLog(3,"Retrieve default tuitionfees from tuitionclass_id: $tuitionclass_id");
	$sql="SELECT p.amt from $this->tabletuitionclass tc inner join $this->tableproductlist p on p.product_id=tc.product_id where ".
		" tc.tuitionclass_id=$tuitionclass_id";
	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql) ;
	if ($row=$this->xoopsDB->fetchArray($query)){
		$result=$row['amt'];
		$this->log->showLog(3,"return result: $result");
		return $result;
	}
	else{
		$this->log->showLog(2,"Can't find the default training fees, return:0"); 
		return 0;
	}
  } // end defaultTrainingFees()


/**
   * get default transport fees from database
   * @param int tuitionclass
   * return decimal tuition price
   * @access public
   */
  public function defaultTransportFees($comeactive,$backactive,$organization_id, $comeareafrom_id, $backareato_id){
	$this->log->showLog(3,"Retrieve default tuitionfees from tuitionclass_id: $tuitionclass_id");
	$result=0;
	$sqlclasstype="SELECT classtype FROM $this->tabletuitionclass where tuitionclass_id=$this->tuitionclass_id";
	$queryclasstype=$this->xoopsDB->query($sqlclasstype);
	$rowclasstype=$this->xoopsDB->fetchArray($queryclasstype);
	$classtype=$rowclasstype['classtype'];
	$multiplyamt=0;
	if($classtype=="W")
		$multiplyamt=1;
	elseif($classtype=="V")
		$multiplyamt=2;

	if($comeactive=="Y" && $backactive=="Y"){
		if ($comeareafrom_id== $backareato_id)
		$sql="SELECT t.doubletrip_fees as amt FROM $this->tabletransport t ".
				" inner join $this->tableaddress d on d.area_id=t.area_id ".
				" where t.organization_id=$organization_id and d.address_id=$comeareafrom_id";
		
		else{//special calculation
			$sql1="SELECT t.singletrip_fees as amt FROM $this->tabletransport t ".
				" inner join $this->tableaddress d on d.area_id=t.area_id ".
				" where t.organization_id=$organization_id and d.address_id=$comeareafrom_id";
			$sql2="SELECT t.singletrip_fees as amt FROM $this->tabletransport t ".
				" inner join $this->tableaddress d on d.area_id=t.area_id ".
				" where t.organization_id=$organization_id and d.address_id=$backareato_id";

			$this->log->showLog(4,"Special calculation with SQL:$sql1 <br> $sql2");
			$query1=$this->xoopsDB->query($sql1);
			$query2=$this->xoopsDB->query($sql2);
			$result1=0;
			$result2=0;
			if ($row1=$this->xoopsDB->fetchArray($query1)){
				$result1=$row1['amt'];
				$this->log->showLog(3,"return result: $result1");
			}
			if ($row2=$this->xoopsDB->fetchArray($query2)){
				$result2=$row2['amt'];
				$this->log->showLog(3,"return result: $result2");
			}
			$result=$result1+$result2;
			$this->log->showLog(3,"return result: $result");
		
			return $multiplyamt*$result;
	
		}
	}
	elseif($comeactive=="Y"){
		$sql="SELECT t.singletrip_fees as amt FROM $this->tabletransport t ".
				" inner join $this->tableaddress d on d.area_id=t.area_id ".
				" where t.organization_id=$organization_id and d.address_id=$comeareafrom_id";
	}
	elseif($backactive=="Y"){
		$sql="SELECT t.singletrip_fees as amt FROM $this->tabletransport t ".
				" inner join $this->tableaddress d on d.area_id=t.area_id ".
				" where t.organization_id=$organization_id and d.address_id=$backareato_id";
	}
	else{
		$this->log->showLog(3,"No transportation service require, return transport fees:0");
		return 0;
	}
	$this->log->showLog(4,"SQL:$sql");

	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	if ($row=$this->xoopsDB->fetchArray($query)){
		$result=$row['amt'];
		$this->log->showLog(3,"return result: $result");
		return $result*$multiplyamt;
	}
	else{
		$this->log->showLog(2,"Can't find the default transport fees, return:0"); 
		return 0;
	}

  } // end defaultTrainingFees()



  public function notAllowJoinClass(){
	$this->log->showLog(3,"Make sure student: $this->student_id never exist in class $this->tuitionclass_id");
	$sql="SELECT studentclass_id from $this->tablestudentclass where student_id=$this->student_id and
		tuitionclass_id=$this->tuitionclass_id";
	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		if($row[studentclass_id]>0)
		return true;
	}
	else
		return false;
  }

  public function insertRegClass() {
	//	sleep (10);

     	$timestamp= date("y/m/d H:i:s", time()) ;
	//calculate transport price
	$this->log->showLog(4,"Creating record with SQL:$sql");

	$this->amt=$this->defaultTrainingFees($this->tuitionclass_id);
	$this->futuretrainingfees=$this->amt;

	$this->organization_id=$this->getClassOrgID($this->tuitionclass_id);

	$this->transportfees=$this->defaultTransportFees($this->comeactive,$this->backactive,
		$this->organization_id, $this->comeareafrom_id, $this->backareato_id);
	$this->futuretransportfees=$this->transportfees;

	

	$sql="INSERT INTO $this->tablestudentclass 
		(student_id,tuitionclass_id,amt,transportfees,comeareafrom_id,backareato_id,transactiondate, isactive, classjoindate,
		comeactive,backactive,created,createdby,updated,updatedby,organization_id,futuretrainingfees,
		futuretransportfees,".
	" description) values($this->student_id,$this->tuitionclass_id,$this->amt,$this->transportfees,".
	"$this->comeareafrom_id,$this->backareato_id,'$this->transactiondate','$this->isactive','$this->classjoindate','$this->comeactive',".
	"'$this->backactive','$timestamp',$this->createdby,'$timestamp',$this->updatedby,$this->organization_id,".
	"$this->futuretrainingfees,$this->futuretransportfees,'$this->description')";
	
	$this->log->showLog(4,"Before insert product SQL:$sql");
	$rs=$this->xoopsDB->query($sql);

	if (!$rs){
		$this->log->showLog(1,"Failed to save registration");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new registration successfully"); 
		return true;
	}
	
  }//insertRegClass

/**
   * Get latest studentclass_id
   * @param 
   * return int student_id
   * @access public
   */
  public function getLatestStudentClassID(){
	$sql="SELECT MAX(studentclass_id) as studentclass_id from $this->tablestudentclass;";
	$this->log->showLog(4,"Get latest studentclass_id with SQL: $sql");
	$query=$this->xoopsDB->query($sql) ;
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['studentclass_id'];
	else
	return -1;
  }//getLatestStudentClassID

  public function getClassOrgID($tuitionclass_id){
	$sql="SELECT organization_id  from $this->tabletuitionclass where tuitionclass_id=$tuitionclass_id;";
	$this->log->showLog(4,"Get organization_id from tuitionclass with SQL: $sql");

	$query=$this->xoopsDB->query($sql) ;
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['organization_id'];
	else
		return 1;
  }//


 /**
   * Update student class registration information
   *
   * @return bool
   * @access public
   */
  public function updateStudentClass( ) {
    $timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablestudentclass SET ".
		"amt=$this->amt,".
		"tuitionclass_id=$this->tuitionclass_id,".
		"isactive='$this->isactive',".
		"classjoindate='$this->classjoindate',".
		"comeactive='$this->comeactive',".
		"backactive='$this->backactive',".
		"transportfees=$this->transportfees,".
		"comeareafrom_id=$this->comeareafrom_id,".
		"transactiondate	='$this->transactiondate',".
		"backareato_id=$this->backareato_id,".
		"organization_id=$this->organization_id,".
		"updatedby='$this->updatedby',".
		"updated	='$timestamp', ".
		"futuretrainingfees=$this->futuretrainingfees,".
		"futuretransportfees=$this->futuretransportfees, ".
		"description='$this->description' ".
		"WHERE studentclass_id=$this->studentclass_id";
	
	$this->log->showLog(3, "Update studentclass_id: $this->studentclass_id");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update studentclass failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update studentclass successfully.");
		return true;
	}
  } // end of member function updateStudentClass

 /**
   * Delte student class registration information
   * @param int $studentclass_id 
   * @return bool
   * @access public
   */
   public function deleteStudentClass($studentclass_id){
	$this->log->showLog(2,"Warning: Performing delete StudentClass id : $studentclass_id !");
	$sql="DELETE FROM $this->tablestudentclass where studentclass_id=$studentclass_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: StudentClass ($studentclass_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"StudentClass ($studentclass_id) removed from database successfully!");
		return true;
		
	}
   }
/*   public function transportFees($transportationmethod,$organization_id,$areacf_ctrl){
	if($transportationmethod=="0")
	{
		$sql="SELECT doubletrip_fees from $this->tabletransport where organization_id=$organization_id and area_id=$areacf_ctrl";
		$transportfees=doubletrip_fees;
	}
	else{
		$sql="SELECT singletrip_fees from $this->tabletransport where organization_id=$organization_id and area_id=$areacf_ctrl";
		$transportfees=single_fees;
	}
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
	{$this->transportfees=$row["$transportfees"];
	}
return $this->transportfees;
}*/

public function getcomeAddressList($id){
	$this->log->showLog(3,"Retrieve available period from database");

	$sql="SELECT address_id, address_name from $this->tableaddress where student_id=$this->student_id order by address_name";
	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='comeareafrom_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"> </OPTION>';
		
	$query=$this->xoopsDB->query($sql) ;
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$address_id=$row['address_id'];
		$address_name=$row['address_name'];
	
		if($id==$address_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$address_id' $selected>$address_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

/** when student register in new class, the standard of class with transfer to student record
  * @param
  * @return bool
*/
public function updateStudentStandard(){
	$this->log->showLog(3,"Update Student's Standard, with tuitionclass_id: $this->tuitionclass_id, student_id: $this->student_id");
	$sqlstandard="SELECT p.standard_id from $this->tableproductlist p ".
		" inner join $this->tabletuitionclass t on p.product_id=t.product_id where t.tuitionclass_id=$this->tuitionclass_id";
	$this->log->showLog(4,"With SQL get standard: $sqlstandard");
	$query=$this->xoopsDB->query($sqlstandard);
	$standard_id=0;
	if($row=$this->xoopsDB->fetchArray($query) )
		$standard_id=$row['standard_id'];

	$sqlupdate="UPDATE $this->tablestudent set standard_id=$standard_id where student_id=$this->student_id";
	$this->log->showLog(4,"With SQL update standard: $sqlupdate");
	$rs=$this->xoopsDB->query($sqlupdate);
	if($rs)
		$this->log->showLog(3,"Update Standard Successfully");
	else
		$this->log->showLog(1,"Update standard failed");

}


public function getbackAddressList($id){
	$this->log->showLog(3,"Retrieve available period from database");

	$sql="SELECT address_id, address_name from $this->tableaddress where student_id=$this->student_id order by address_name";
	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='backareato_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"> </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$address_id=$row['address_id'];
		$address_name=$row['address_name'];
	
		if($address_id==$id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$address_id' $selected>$address_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

public function allowDelete($studentclass_id){
	$this->log->showLog(3,"Verified whether studentclass_id: $studentclass_id is deletable");
	$sql="SELECT count(studentclass_id) as countid from $this->tablepaymentline where 
		studentclass_id=$studentclass_id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql) ;
	$recordcount=0;
	if($row=$this->xoopsDB->fetchArray($query))
		$recordcount=$row['countid'];
	
	if($recordcount=="" || $recordcount==0){
		return true;
		$this->log->showLog(4,"Record deletable, count: $recordcountl");
	
	}
	else{
		$this->log->showLog(4,"Record not deletable, count: $recordcountl");
		return false;
	}
  }
}
?>
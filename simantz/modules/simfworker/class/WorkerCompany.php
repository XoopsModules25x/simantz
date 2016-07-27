<?php
class WorkerCompany{

  public $workercompany_id;
  public $worker_id;
  public $company_id;
  public $department;
  public $salary;
  public $joindate;
  public $resigndate;
  public $street1;
  public $street2;
  public $postcode;
  public $city;
  public $state1;
  public $country;
  public $payfrequency;
  public $position;
  public $currency_id;
  public $supervisor;
  public $supervisor_contact;
  public $usecompany_address;
  public $workerstatus;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $worker_no;
  public $workerctrl;
  public $currencyctrl;
  public $companyctrl;
  public $showcalendar1;
  public $showcalendar2;
  public $xoopsDB;
  private $log;
  public $tableprefix;
  public $tableworkercompany;
  public $tablecurrency;
  public $tablenationality;
  public $tableraces;
  public $tablecompany;
  public $tableworker;
  public $workerstatusctrl;
   /**
   *
   * @param xoopsDB $xoopsDB
   * @param string $tableprefix
   * @param log $log
   * Constructor for class WorkerCompany
   * @access public
   */
  public function WorkerCompany ($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
	$this->tableprefix=$tableprefix;
	$this->tableworkercompany=$tableprefix."simfworker_workercompany";
	$this->tableworker=$tableprefix."simfworker_worker";
	$this->tablenationality=$tableprefix."simfworker_nationality";
	$this->tableraces=$tableprefix."simfworker_races";
	$this->tablecompany=$tableprefix."simfworker_company";
	$this->tablecurrency=$tableprefix."simfworker_currency";
  } //end WorkerCompany

/**
   *Retrieve class registration info from database into class
   * @param int $workercompany_id 
   * 
   * @access publicgetSelectCurrency
   */
  public function fetchWorkerCompanyInfo($workercompany_id){
	$this->log->showLog(3,"Fetch Class Registration info for record: $workercompany_id.");
		
	$sql="SELECT worker_id, company_id, department, salary, joindate, resigndate, street1, street2, postcode, city, ".
		"state1, country, payfrequency, position, currency_id, supervisor, supervisor_contact, usecompany_address, ". 
		"workerstatus, created, createdby, updated, updatedby, worker_no ".
		"FROM $this->tableworkercompany where workercompany_id=$workercompany_id";
	
	$this->log->showLog(4,"WorkerCompany->fetchWorkerCompanyInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->worker_id=$row['worker_id'];
		$this->company_id=$row['company_id'];
		$this->department=$row['department'];
		$this->salary	=$row['salary'];
		$this->joindate=$row['joindate'];
		$this->resigndate=$row['resigndate'];
		$this->street1=$row['street1'];
		$this->street2=$row['street2'];
		$this->postcode=$row['postcode'];
		$this->city=$row['city'];
		$this->state1=$row['state1'];
		$this->country=$row['country'];
		$this->payfrequency=$row['payfrequency'];
		$this->position=$row['position'];
		$this->currency_id=$row['currency_id'];
		$this->supervisor=$row['supervisor'];
		$this->supervisor_contact=$row['supervisor_contact'];
		$this->usecompany_address=$row['usecompany_address'];
		$this->workerstatus=$row['workerstatus'];
		$this->created=$row['created'];
		$this->createdby=$row['createdby'];
		$this->updated=$row['updated'];
		$this->updatedby=$row['updatedby'];
		$this->worker_no=$row['worker_no'];


	$this->log->showLog(4,"WorkerCompany->fetchWorkerCompanyInfo, database fetch into class successfully, with workercompany_id=$this->workercompany_id");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"WorkerCompany->fetchWorkerCompanyInfo,failed to fetch data into databases.");	
	}
  }//fetchWorkerCompanyInfo

 /**
   *
   * @param int $student_id oor $class_id
   * @param string $type can be 'student' or 'class'
   * @param string $wherestring filter string
   * @param string $orderbystring used for sort record purpose
   * Display registered class in this student or class, depends on $type
   * @access public
   */
  public function showWorkerEmploymentTable($wherestring,$orderbystring,$startno,$recordcount){
	
	//$wherestring="";
	$this->log->showLog(3,"Showing WorkerEmployment History Table");
	$sql="";
	$operationctrl="";
	$sql=$this->getSQLStr_WorkerCompany('worker',$wherestring,$orderbystring,$startno,$recordcount);
	

	echo <<< EOF
	<table border='1' >
  		<tbody>
    			<tr><th style="text-align:center;" colspan="11">
				Employment History 
				</th></tr><tr>
				
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Company Name</th>
				<th style="text-align:center;">Department</th>
				<th style="text-align:center;">Position</th>
				<th style="text-align:center;">Worker No</th>
				<th style="text-align:center;">Join Date</th>
				<th style="text-align:center;">Resign Date</th>
				<th style="text-align:center;">Currency</th>
				<th style="text-align:center;">Salary</th>
				<th style="text-align:center;">Status</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
//	$this->log->showLog(4,"<tr><td>Start listing data</td></tr>");
	$query=$this->xoopsDB->query($sql);
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$company_id=$row['company_id'];
		$workercompany_id=$row['workercompany_id'];
		$company_name=$row['company_name'];
		$company_url="<A href='company.php?action=edit&company_id=$company_id'>$company_name</A>";
		$department=$row['department'];
		$position=$row['position'];
		$worker_no=$row['worker_no'];
		$joindate=$row['joindate'];
//		$transportationmethod=$row['transportationmethod'];
		$resigndate=$row['resigndate'];
		$currency_symbol=$row['currency_symbol'];
		$salary=$row['salary'];
		$workerstatus=$row['workerstatus'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		$operationctrl="<form method='POST' action='workercompany.php'><input type='image' src='images/edit.gif' name='submit'  title='Edit this record'>".
				"<input type='hidden' value='$workercompany_id' name='workercompany_id'>".
				"<input type='hidden' name='action' value='editworker'>".
				"</form>";
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$company_url</td>
			<td class="$rowtype" style="text-align:center;">$department</td>
			<td class="$rowtype" style="text-align:center;">$position</td>
			<td class="$rowtype" style="text-align:center;">$worker_no</td>
			<td class="$rowtype" style="text-align:center;">$joindate</td>
			<td class="$rowtype" style="text-align:center;">$resigndate</td>
			<td class="$rowtype" style="text-align:center;">$currency_symbol</td>
			<td class="$rowtype" style="text-align:center;">$salary</td>
			<td class="$rowtype" style="text-align:center;">$workerstatus</td>
			<td class="$rowtype" style="text-align:center;">$operationctrl</td>

		</tr>
EOF;
	}
echo<<< EOF
<tr><td colspan='10' style="text-align: left">
	<FORM name='rptemploymenthistory' action="rptemploymenthistory.php" method='POST' target="_blank">
			<input type='submit' name='submit' value='Print Preview'>
			<input type='hidden' value="$o->worker_id" name='worker_id'>
			<input type='hidden' value="$wherestring" name='wherestring'>
			<input type='hidden' value="$orderbystring" name='orderbystring'>

		</FORM>
</td>
<td style='text-align: center'>
	<FORM action='workercompany.php' method='POST'>
	<input type='hidden' value='$this->worker_id' name='worker_id'>
	<input type='submit' value='Add New' name='submit' >
	<input type='hidden' name='action' value='view'>
	</FORM>
</td>
</tr>
	 </tbody></table><br>
EOF;
  }

public function showCompanyEmploymentTable($wherestring,$orderbystring,$startno,$recordcount){
	//$wherestring="";
	$this->log->showLog(3,"Showing WorkerEmployment History Table");
	$sql="";
	$operationctrl="";
	$sql=$this->getSQLStr_WorkerCompany('company',$wherestring,$orderbystring,$startno,$recordcount);
	

	echo <<< EOF
	<table border='1' >
  		<tbody>
    			<tr><th style="text-align:center;" colspan="12">
				Employment History 
				</th></tr><tr>
				
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Worker No</th>
				<th style="text-align:center;">Worker Name</th>
				<th style="text-align:center;">Worker Code</th>
				<th style="text-align:center;">Department</th>
				<th style="text-align:center;">Position</th>
				<th style="text-align:center;">Join Date</th>
				<th style="text-align:center;">Resign Date</th>
				<th style="text-align:center;">Currency</th>
				<th style="text-align:center;">Salary</th>
				<th style="text-align:center;">Status</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
//	$this->log->showLog(4,"<tr><td>Start listing data</td></tr>");
	$query=$this->xoopsDB->query($sql);
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$workercompany_id=$row['workercompany_id'];
		$worker_no=$row['worker_no'];
		$worker_id=$row['worker_id'];
		$worker_code=$row['worker_code'];

		$worker_name=$row['worker_name'];
		$worker_url="<A href='worker.php?worker_id=$worker_id&action=edit'>$worker_name</A>";
		$department=$row['department'];
		$position=$row['position'];
		$currency_symbol=$row['currency_symbol'];
		$joindate=$row['joindate'];
//		$transportationmethod=$row['transportationmethod'];
		$resigndate=$row['resigndate'];
		$salary=$row['salary'];
		$workerstatus=$row['workerstatus'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		$operationctrl="<form method='POST' action='workercompany.php'><input type='image' src='images/edit.gif' name='submit'  title='Edit this record'>".
				"<input type='hidden' value='$workercompany_id' name='workercompany_id'>".
				"<input type='hidden' name='action' value='editworker'>".
				"</form>";
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$worker_no</td>
			<td class="$rowtype" style="text-align:center;">$worker_url</td>
			<td class="$rowtype" style="text-align:center;">$worker_code</td>

			<td class="$rowtype" style="text-align:center;">$department</td>
			<td class="$rowtype" style="text-align:center;">$position</td>
			<td class="$rowtype" style="text-align:center;">$joindate</td>
			<td class="$rowtype" style="text-align:center;">$resigndate</td>
			<td class="$rowtype" style="text-align:center;">$currency_symbol</td>
			<td class="$rowtype" style="text-align:center;">$salary</td>
			<td class="$rowtype" style="text-align:center;">$workerstatus</td>
			<td class="$rowtype" style="text-align:center;">$operationctrl</td>

		</tr>
EOF;
	}
	echo  <<< EOF
<tr><td colspan='12' style="text-align: left">
	<FORM name='rptcompanyworker' action="rptcompanyworker.php" method='POST' target="_blank">
			<input type='submit' name='submit' value='Print Preview'>
			<input type='hidden' value="$wherestring" name='wherestring'>
			<input type='hidden' value="$orderbystring" name='orderbystring'>
			<input type='hidden' value="$o->company_id" name='company_id'>
		</FORM>
</tr></td>
</tbody></table><br>
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
  public function getSQLStr_WorkerCompany($type,$wherestring,$orderbystring,$startno,$recordcount){
	$sql=""; 
	$this->log->showLog(3,"WorkerCompany-getSQLStr_WorkerCompany($type,$wherestring,$orderbystring");
	if($type=='worker'){
		$sql="SELECT wc.workercompany_id,c.company_id,c.company_name,wc.department, wc.supervisor, wc.workerstatus,".
		" wc.worker_no,wc.joindate,wc.resigndate,wc.position,wc.salary,cr.currency_symbol ".
		"FROM $this->tableworkercompany wc ".
		"INNER JOIN $this->tableworker w on w.worker_id=wc.worker_id ".
		"INNER JOIN $this->tablecompany c on c.company_id=wc.company_id ".
		"INNER JOIN $this->tablecurrency cr on cr.currency_id=wc.currency_id ".
		" $wherestring $orderbystring  LIMIT $startno, $recordcount";
	$this->log->showLog(3,"Retrieve worker $wherestring");
	}
	elseif($type=='company'){
		$sql="SELECT wc.workercompany_id, w.worker_id,w.worker_code,wc.worker_no,w.worker_name,w.gender,r.races_name,n.nationality_name, w.passport_no, ".
		"w.workerstatus,w.handphone,wc.department,wc.joindate,wc.resigndate,wc.position,wc.salary,cr.currency_symbol ".
		"FROM $this->tableworkercompany wc ".
		"INNER JOIN $this->tableworker w on w.worker_id=wc.worker_id ".
		"INNER JOIN $this->tablenationality n on n.nationality_id=w.nationality_id ".
		"INNER JOIN $this->tableraces r on r.races_id=w.races_id ".
		"INNER JOIN $this->tablecompany c on c.company_id=wc.company_id ".
		"INNER JOIN $this->tablecurrency cr on cr.currency_id=wc.currency_id ".
		" $wherestring $orderbystring  LIMIT $startno, $recordcount";
	$this->log->showLog(3,'Retrieve register student $wherestring');
	}
	$this->log->showLog(4,"return sql: $sql");
	return $sql;
  }//end showRegisteredClass

/**
   *
   * @param string $type can be 'edit' or 'new'
   * @param int $workercompany_id
   * @param string $token for security purpose
   * Display forms for user to create/edit existing student-class registration
   * @access public
   */
  public function showInputForm($type,$workercompany_id,$token){
	$this->log->showLog(3,"Accessing WorkerCompany->showInputForm($type,$workercompany_id,$token)");
	$checked="";
	$paidchecked="";
	$transportType="";
	$feesctrl="";
	$jumptotopayment="";
     if($type=="new"){
		$this->joindate=date("Y-m-d", time()) ;;
		$this->resigndate='0000-00-00';
		
		$header="New Employment Registration";
		$action="create";

		if($this->company_id==0){
		$this->workercompany_id=0;
		$this->salary=0;

		}

		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
//	$transportType=$this->transportType("BOTH");
	}
     else{
		$action="update";
		$savectrl="<input name='workercompany_id' value='$this->workercompany_id' type='hidden'>".
			 "<input style='height:40px;' name='submit' value='Save' type='submit'>";

		if ($this->usecompany_address=='0' || $this->usecompany_address=='no' )
			$checked="";
		else
			$checked="CHECKED";
		
		//force isactive checkbox been checked if the value in db is 'Y'
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableworkercompany' type='hidden'>".
		"<input name='id' value='$this->workercompany_id' type='hidden'>".
		"<input name='idname' value='workercompany_id' type='hidden'>".
		"<input name='title' value='Class Registration' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'  style='height: 40px;'>".
		"</form>";

		$header="Edit Registered Details";
		if($this->allowDelete($this->workercompany_id))
		$deletectrl="<FORM action='workercompany.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this registration?"'.")'><input type='submit' value='Delete' name='submit'  style='height: 40px;'>".
		"<input type='hidden' value='$this->workercompany_id' name='workercompany_id'>".
		"<input type='hidden' value='$this->student_id' name='student_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		"<Form action='workercompany.php' method='POST'><input name='submit' value='New' type='submit'></form>";
		$addnewctrl="<form action='workercompany.php' method='post'><input type='hidden' name='worker_id' value='$this->worker_id'><input type='hidden' name='action' value='default'><input type='submit' value='New' name='new'></form>";
		
//	$transportType=$this->transportType($this->transportationmethod);
//	$this->transportfees=$this->transportFees($this->transportationmethod,$this->orgctrl,$this->comeareafrom_id);
	}
	echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">$header</span></big></big></big></div><br>
<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onSubmit="return validateWorkerCompany()" method="post"
 action="workercompany.php" name="frmWorkerCompany"><input name="reset" value="Reset" type="reset"></td></tbody></table>
	<table border='1' cellspacing='3'>
	<tbody>
	<tr><th colspan='4'>Add New Employment Record<input type='hidden' name="worker_id" value="$this->worker_id"></th></tr>
	<tr>
	<td class="head">Company</td>
	<td class="odd">$this->companyctrl</td>
	<td class="head">Worker No</td>
	<td class="odd"><input value='$this->worker_no' name='worker_no' size='20' maxlength='20'></td>
	</tr>	
	<tr>
	<td class="head">Join Date</td>
	<td class="even"><input name="joindate" id="joindate" value="$this->joindate"  size='10' maxlength='10'>
		<input type='button' value='Date' onClick="$this->showcalendar1"></td>
	<td class="head">Resign Date</td>
	<td class="even"><input name="resigndate" id="resigndate" value="$this->resigndate"  size='10' maxlength='10'>
		<input type='button' value='Date' onClick="$this->showcalendar2">
		<input type='button' value='Clear' onClick="resigndate.value='0000-00-00'">
	</td>
	</tr>
	<tr>
	<td class="head">Department</td>
	<td class="odd"><input name='department' value='$this->department'  size='20' maxlength='20'></td>
	<td class="head">Position</td>
	<td class="odd"><input value='$this->position' name='position'  size='20' maxlength='20'></td>
	</tr>
	<tr>
	<td class="head">Currency</td>
	<td class="odd">$this->currencyctrl</td>
	<td class="head">Salary</td>
	<td class="odd"><input value='$this->salary' name='salary' size='10' maxlength='10'></td>
	</tr>
	<tr>
	<td class="head">Supervisor</td>
	<td class="odd"><input name='supervisor' value='$this->supervisor' size='20' maxlength='20'></td>
	<td class="head">Supervisor Contact No</td>
	<td class="odd"><input name='supervisor_contact' value='$this->supervisor_contact' size='20' maxlength='20'></td>
	</tr>
	<tr>
	<td class="head">Payment Frequency</td>
	<td class="odd"><input name='payfrequency' value='$this->payfrequency' size='10' maxlength='10'></td>
	<td class="head">Worker Status</td>
	<td class="odd">$this->workerstatusctrl</td>
	</tr>
	<tr>
	<td class="head">Use Company Address</td>
	<td class="odd"><input type="checkbox" name='usecompany_address' $checked></td>
	<td class="head"></td>
	<td class="odd"></td>
	</tr>
	<tr>
	<td class="head">Street 1</td>
	<td class="odd"><input name='street1' value='$this->street1' size='50' maxlength='50'></td>
	<td class="head">Street 2</td>
	<td class="odd"><input name='street2' value='$this->street2' size='50' maxlength='50'></td>
	</tr>
	<tr>
	<td class="head">Postcode</td>
	<td class="odd"><input name='postcode' value='$this->postcode' size='5' maxlength='5'></td>
	<td class="head">City</td>
	<td class="odd"><input name='city' value='$this->city' size='20' maxlength='20'></td>
	</tr>
	<tr>
	<td class="head">State</td>
	<td class="odd"><input name='state1' value='$this->state1' size='20' maxlength='20'></td>
	<td class="head">Country</td>
	<td class="odd"><input name='country' value='$this->country' size='20' maxlength='20'></td>
	</tr>
	<tr>
		<td class="head">Others Info(255 max)</td>
		<td class="even" colspan='3'>
			<textarea name='othersinfo' cols='70' rows='5'>$this->othersinfo</textarea>
		</td>

	</tr>
	</tbody>
	</table>
	<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td><td>$recordctrl</td></tbody></table>

EOF;
  } //showInputForm

  public function insertWorkerCompany() {
	//	sleep (10);
     	$timestamp= date("y/m/d H:i:s", time()) ;
	//calculate transport price
	$this->log->showLog(4,"Creating record with SQL:$sql");

	
	$sql="INSERT INTO $this->tableworkercompany (".
		"worker_id, company_id, department, salary, joindate, resigndate, street1, street2, postcode, city, ".
		"state1, country, payfrequency, position, currency_id, supervisor, supervisor_contact, usecompany_address, ". 
		"workerstatus, created, createdby, updated, updatedby, worker_no) VALUES (".
		"'$this->worker_id', '$this->company_id', '$this->department', '$this->salary', '$this->joindate', '$this->resigndate', '$this->street1', '$this->street2', '$this->postcode', '$this->city', ".
		"'$this->state1', '$this->country', '$this->payfrequency', '$this->position', '$this->currency_id', '$this->supervisor', '$this->supervisor_contact', '$this->usecompany_address', ". 
		"'$this->workerstatus', '$this->created', '$this->createdby', '$this->updated', '$this->updatedby', '$this->worker_no')";
	
	$this->log->showLog(4,"Before insert product SQL:$sql");
	$rs=$this->xoopsDB->query($sql);

	if (!rs){
		$this->log->showLog(1,"Failed to save registration");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new registration successfully"); 
		return true;
	}
	
  }//insertWorkerCompany

/**
   * Get latest workercompany_id
   * @param 
   * return int student_id
   * @access public
   */
  public function getLatestWorkerCompanyID(){
	$sql="SELECT MAX(workercompany_id) as workercompany_id from $this->tableworkercompany;";
	$this->log->showLog(4,"Get latest workercompany_id with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['workercompany_id'];
	else
	return -1;
  }//getLatestWorkerCompanyID



 /**
   * Update student class registration information
   *
   * @return bool
   * @access public
   */
  public function updateWorkerCompany( ) {
    $timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableworkercompany SET ".
		"worker_id=$this->worker_id, company_id=$this->company_id, department='$this->department', salary=$this->salary, joindate='$this->joindate', resigndate='$this->resigndate', street1='$this->street1', street2='$this->street2', postcode='$this->postcode', city='$this->city', ".
		"state1='$this->state1', country='$this->country', payfrequency='$this->payfrequency', position='$this->position', currency_id='$this->currency_id', supervisor='$this->supervisor', supervisor_contact='$this->supervisor_contact', usecompany_address='$this->usecompany_address', ". 
		"workerstatus='$this->workerstatus', created='$this->created', createdby='$this->createdby', updated='$this->updated', updatedby='$this->updatedby', worker_no='$this->worker_no' ".
		"WHERE workercompany_id=$this->workercompany_id";
	
	$this->log->showLog(3, "Update workercompany_id: $this->workercompany_id");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update workercompany failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update workercompany successfully.");
		return true;
	}
  } // end of member function updateWorkerCompany

 /**
   * Delte student class registration information
   * @param int $workercompany_id 
   * @return bool
   * @access public
   */
   public function deleteWorkerCompany($workercompany_id){
	$this->log->showLog(2,"Warning: Performing delete WorkerCompany id : $workercompany_id !");
	$sql="DELETE FROM $this->tableworkercompany where workercompany_id=$workercompany_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: WorkerCompany ($workercompany_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"WorkerCompany ($workercompany_id) removed from database successfully!");
		return true;
		
	}
   }

  public function updateCompanyAddress($workercompany_id,$company_id){

	$this->fetchWorkerCompanyInfo($workercompany_id);
	$this->log->showLog(3,"Update company address :$company_id to workercompany_id: $workercompany_id");

	$sqlCompany="SELECT street1, street2, postcode, city, state1, country ".
			"FROM $this->tablecompany where company_id=$company_id";
	$this->log->showLog(4,"With SQL: $sqlCompany");
	$query=$this->xoopsDB->query($sqlCompany);
	while($row=$this->xoopsDB->fetchArray($query)){
		$street1=$row['street1'];
		$street2=$row['street2'];
		$postcode=$row['postcode'];
		$city=$row['city'];
		$state1=$row['state1'];
		$country=$row['country'];
	}
	$sql="UPDATE $this->tableworkercompany SET ".
		" street1='$street1', street2='$street2', postcode='$postcode', city='$city', ".
		"state1='$state1', country='$country' WHERE workercompany_id=$workercompany_id";
	$this->log->showLog(4,"New SQL: $sql");

	$rs=$this->xoopsDB->query($sql);

	if(!$rs){
		$this->log->showLog(2, "Warning! Update workercompany failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update workercompany successfully.");
		return true;
	}
//	$this->updateWorkerCompany();
  }

  public function allowDelete($workercompany_id){
	$this->log->showLog(3,"Verified whether workercompany_id: $workercompany_id is deletable");
	$sql="SELECT count(workercompany_id) as countid from $this->tablepaymentline where workercompany_id=$workercompany_id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
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
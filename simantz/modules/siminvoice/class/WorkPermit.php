<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


class WorkPermit{

  public $workpermit_id;
  public $worker_id;
  public $company_id;
  
  public $document_no;
  public $register_date;
  public $expired_date;

  public $register_dateto;
  public $expired_dateto;
  public $permitstatus;
  public $description;
  public $permitstatusctrl;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $workerctrl;
  public $companyctrl;
  public $showcalendar1;
  public $showcalendar2;

  public $othersinfo;
  public $xoopsDB;
  private $log;
  public $tableprefix;
  public $tableworkpermit;
  public $tablenationality;
  public $tablecompany;
  public $tableworker;

  public $tableraces;
   /**
   *
   * @param xoopsDB $xoopsDB
   * @param string $tableprefix
   * @param log $log
   * Constructor for class WorkPermit
   * @access public
   */
  public function WorkPermit ($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
	$this->tableprefix=$tableprefix;
	$this->tableworkpermit=$tableprefix."simfworker_workpermit";
	$this->tableworker=$tableprefix."simfworker_worker";
	$this->tableraces=$tableprefix."simfworker_races";
	$this->tablenationality=$tableprefix."simfworker_nationality";
	$this->tablecompany=$tableprefix."simfworker_company";

  } //end Medical

/**
   *Retrieve class registration info from database into class
   * @param int $workpermit_id 
   * 
   * @access publicgetSelectCurrency
   */
  public function fetchWorkPermitInfo($workpermit_id){
	$this->log->showLog(3,"Fetch Class Registration info for record: $workpermit_id.");
		
	$sql="SELECT company_id, worker_id, register_date, expired_date, ".
		"document_no,permitstatus,description,othersinfo, ". 
		" created, createdby, updated, updatedby ".
		"FROM $this->tableworkpermit where workpermit_id=$workpermit_id";
	
	$this->log->showLog(4,"WorkPermit->fetchWorkPermitInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->worker_id=$row['worker_id'];
		$this->company_id=$row['company_id'];
		$this->register_date=$row['register_date'];
		$this->expired_date=$row['expired_date'];
		$this->document_no=$row['document_no'];

		$this->permitstatus=$row['permitstatus'];
		$this->description=$row['description'];
		$this->othersinfo=$row['othersinfo'];
		$this->created=$row['created'];
		$this->createdby=$row['createdby'];
		$this->updated=$row['updated'];
		$this->updatedby=$row['updatedby'];

	$this->log->showLog(4,"WorkPermit->fetchWorkPermitInfo, database fetch into class successfully, with workpermit_id=$this->workpermit_id, permitstatus=$this->permitstatus");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"WorkPermit->fetchWorkPermitInfo,failed to fetch data into databases.");	
	}
  }//fetchMedicalInfo

 /**
   *
   * @param int $worker_id oor $class_id
   * @param string $type can be 'worker' or 'class'
   * @param string $wherestring filter string
   * @param string $orderbystring used for sort record purpose
   * Display registered class in this worker or class, depends on $type
   * @access public
   */
  public function showWorkPermitTable($wherestring,$orderbystring,$startno,$recordcount){
	
	//$wherestring="";
	$this->log->showLog(3,"Showing WorkerEmployment History Table($wherestring,$orderbystring,$startno,$recordcount)");
	$sql="";
	$operationctrl="";
	$sql=$this->getSQLStr_WorkPermit($wherestring,$orderbystring,$startno,$recordcount);
	

	echo <<< EOF
	<table border='1' >
  		<tbody>
    			<tr><th style="text-align:center;" colspan="12">
				Work Permit History (PLKS Record $startno to $recordcount)
				</th></tr><tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Company No</th>
				<th style="text-align:center;">Company Name</th>
				<th style="text-align:center;">Worker Code</th>
				<th style="text-align:center;">Worker Name/No</th>
				<th style="text-align:center;">Register Date</th>
				<th style="text-align:center;">Expired Date</th>
				<th style="text-align:center;">Document No</th>

				<th style="text-align:center;">Result</th>
				<th style="text-align:center;">Operation</th>
</tr>
EOF;
	$rowtype="";
	$i=0;
//	$this->log->showLog(4,"<tr><td>Start listing data</td></tr>");
	$query=$this->xoopsDB->query($sql);
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$workpermit_id=$row['workpermit_id'];
		$worker_id=$row['worker_id'];
		$worker_code=$row['worker_code'];
		$worker_name=$row['worker_name'];
		$worker_no=$row['worker_no'];
		$company_id=$row['company_id'];
		$company_no=$row['company_no'];
		$company_name=$row['company_name'];
		$register_date=$row['register_date'];
		$expired_date=$row['expired_date'];
		$document_no=$row['document_no'];
		$worker_url="<A href='worker.php?worker_id=$worker_id&action=edit'>$worker_name</A>";
		$company_url="<A href='company.php?action=edit&company_id=$company_id'>$company_name</A>";

		$permitstatus=$row['permitstatus'];
		$description=$row['description'];
		$othersinfo=$row['othersinfo'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		switch($permitstatus){
			case "P":
				$permitstatus="Passed";
			break;
			case "F":
				$permitstatus="Failed";
			break;
			case "I":
				$permitstatus="In Progress";
			break;
			case "E":
				$permitstatus="Expired";
			break;
			
		}

		
		$operationctrl="<form method='POST' action='workpermit.php'><input type='image' src='images/edit.gif' name='submit'  title='Edit this record'>".
				"<input type='hidden' value='$workpermit_id' name='workpermit_id'>".
				"<input type='hidden' name='action' value='edit'>".
				"</form>";
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$company_no</td>
			<td class="$rowtype" style="text-align:center;">$company_url</td>
			<td class="$rowtype" style="text-align:center;">$worker_code</td>
			<td class="$rowtype" style="text-align:center;">$worker_url</td>
			<td class="$rowtype" style="text-align:center;">$register_date</td>
			<td class="$rowtype" style="text-align:center;">$expired_date</td>
			<td class="$rowtype" style="text-align:center;">$document_no</td>

			<td class="$rowtype" style="text-align:center;">$permitstatus</td>
			<td class="$rowtype" style="text-align:center;">$operationctrl</td>

		</tr>
EOF;
	}
	echo <<< EOF
	<td colspan='12' class='head' style='text-align: right'>
	<FORM method="POST"  target='blank'  action="rptpermit.php">
	<input name="orderbystring" value="$orderbystring" type='hidden'>
	<input name="action" value="normal" type='hidden'>

	<input name="wherestring" value="$wherestring" type='hidden'>
	<input type="submit" name='submit' value='Print Preview'>
	</FORM></td>
	</tbody></table><br>
	
EOF;
  }

 public function showExpiredTable($wherestring,$orderbystring,$startno,$recordcount){
	
	//$wherestring="";
	$this->log->showLog(3,"Showing Worker Permit History Table($wherestring,$orderbystring,$startno,$recordcount)");
	$sql="";
	$operationctrl="";
	$sql=$this->getSQLStr_WorkPermit($wherestring,$orderbystring,$startno,$recordcount);
	

	echo <<< EOF
	<table border='1' >
  		<tbody>
    			<tr><th style="text-align:center;" colspan="12">
				Expired Permit (Within 30 days)
				</th></tr><tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Worker No</th>
				<th style="text-align:center;">Worker Name</th>
				<th style="text-align:center;">Company</th>
				<th style="text-align:center;">Nationality</th>
				<th style="text-align:center;">Expired Date</th>
				<th style="text-align:center;">Register Date</th>
				<th style="text-align:center;">Tel</th>
				<th style="text-align:center;">View Record</th>
				<th style="text-align:center;">Status</th>
</tr>
EOF;
	$rowtype="";
	$i=0;
//	$this->log->showLog(4,"<tr><td>Start listing data</td></tr>");
	$query=$this->xoopsDB->query($sql);
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$workpermit_id=$row['workpermit_id'];
		$worker_id=$row['worker_id'];
		$worker_code=$row['worker_code'];
		$worker_name=$row['worker_name'];
		$worker_no=$row['worker_no'];
		$company_id=$row['company_id'];
		$company_no=$row['company_no'];
		$company_name=$row['company_name'];
		$nationality=$row['nationality_name'];
		$register_date=$row['register_date'];
		$expired_date=$row['expired_date'];
		$tel1=$row['tel1'];
		$document_no=$row['document_no'];
		$worker_url="<A href='worker.php?worker_id=$worker_id&action=edit'>$worker_name</A>";
		$company_url="<A href='company.php?action=edit&company_id=$company_id'>$company_name</A>";

		$permitstatus=$row['permitstatus'];
		switch($permitstatus){
			case "P":
				$permitstatus="Passed";
			break;
			case "F":
				$permitstatus="Failed";
			break;
			case "I":
				$permitstatus="In Progress";
			break;
			case "E":
				$permitstatus="Expired";
			break;			
		}
		$description=$row['description'];
		$othersinfo=$row['othersinfo'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		$applicationformctrl="<form method='POST' action='rptrenewpermit.php'>".
					"<input type='hidden' name='workpermit_id' value='$workpermit_id'>".
					"<input type='submit' value='Print Form'>".
					"</form>";
		$operationctrl="<form method='POST' action='workpermit.php'><input type='submit'  name='submit'  value='Zoom'>".
				"<input type='hidden' value='$workpermit_id' name='workpermit_id'>".
				"<input type='hidden' name='action' value='edit'>".
				"</form>";
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$worker_code</td>
			<td class="$rowtype" style="text-align:center;">$worker_url</td>
			<td class="$rowtype" style="text-align:center;">$company_url</td>
			<td class="$rowtype" style="text-align:center;">$nationality</td>
			<td class="$rowtype" style="text-align:center;">$expired_date</td>
			<td class="$rowtype" style="text-align:center;">$register_date</td>
			<td class="$rowtype" style="text-align:center;">$tel1</td>
			<td class="$rowtype" style="text-align:center;">$operationctrl</td>
			<td class="$rowtype" style="text-align:center;">$permitstatus</td>

		</tr>
EOF;
	}

/*
<td colspan='12' class='head' style='text-align: right'><FORM method="POST" action="rptmedicalhistory.php">
	<input name="orderbystring" value="$orderbystring" type='hidden'>
	<input name="wherestring" value="$wherestring" type='hidden'>
	<input type="submit" name='submit' value='Print Preview'>
*/
	echo <<< EOF
	

	<tr><td colspan='10'><form method='POST' target='blank' action='rptpermit.php'>
			<input type='submit' name='submit' value='Print Preview'>
			<input type='hidden' name="action" value='expired'>

			<input type='hidden' name="wherestring" value="$wherestring">
			<input type='hidden' name="orderbystring" value="$orderbystring">

		</form></td></tr></td>
	</tbody></table><br>
	
EOF;
  }
/**
   *
   * @param string $type can be 'worker' or 'class'
   * @param string $wherestring filter string
   * @param string $orderbystring used for sort record purpose
   * return sql statement to caller
   * @access public
   */
  public function getSQLStr_WorkPermit($wherestring,$orderbystring,$startno,$recordcount){
	$sql=""; 
	$this->log->showLog(3,"WorkPermit-getSQLStr_WorkPermit($type,$wherestring,$orderbystring");
		$sql="SELECT m.workpermit_id,m.company_id, m.worker_id, m.register_date, m.expired_date, ".
		"m.document_no,m.permitstatus,m.description,m.othersinfo, n.nationality_name, ".
		" w.worker_name,w.worker_no,w.worker_code,c.company_no,c.company_name,c.tel1 ".
		"FROM $this->tableworkpermit m ".
		"INNER JOIN $this->tableworker w on w.worker_id=m.worker_id ".
		"INNER JOIN $this->tablecompany c on c.company_id=m.company_id ".
		"INNER JOIN $this->tablenationality n on n.nationality_id=w.nationality_id ".
		" $wherestring $orderbystring  LIMIT $startno, $recordcount";
	$this->log->showLog(4,"With sql: $sql");

	return $sql;
  }//end showRegisteredClass

/**
   *
   * @param string $type can be 'edit' or 'new'
   * @param int $workpermit_id
   * @param string $token for security purpose
   * Display forms for user to create/edit existing worker-class registration
   * @access public
   */
  public function showInputForm($type,$workpermit_id,$token){
	$this->log->showLog(3,"Accessing WorkPermit->showInputForm($type,$workpermit_id,$token)");
	$checked="";
	$paidchecked="";
	$transportType="";
	$feesctrl="";
	$permitstatusctrl=$this->selectWorkPermitResult($this->permitstatus);
	$jumptotopayment="";
     if($type=="new"){
		$this->register_date=date("Y-m-d", time()) ;;
		$this->expired_date='0000-00-00';
		
		$header="New Work Permit (PLKS)";
		$action="create";

		if($this->company_id==0){
		$this->workpermit_id=0;
		}

		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
//	$transportType=$this->transportType("BOTH");
	}
     else{
		$action="update";
		$savectrl="<input name='workpermit_id' value='$this->workpermit_id' type='hidden'>".
			 "<input style='height:40px;' name='submit' value='Save' type='submit'>";

		if ($this->usecompany_address=='0' || $this->usecompany_address=='no' )
			$checked="";
		else
			$checked="CHECKED";
		
		//force isactive checkbox been checked if the value in db is 'Y'
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableworkpermit' type='hidden'>".
		"<input name='id' value='$this->workpermit_id' type='hidden'>".
		"<input name='idname' value='workpermit_id' type='hidden'>".
		"<input name='title' value='Class Registration' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'  style='height: 40px;'>".
		"</form>";

		$header="Edit Work Permit Details(PLKS)";
		$deletectrl="<FORM action='workpermit.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this registration?"'.")'><input type='submit' value='Delete' name='submit'  style='height: 40px;'>".
		"<input type='hidden' value='$this->workpermit_id' name='workpermit_id'>".
		"<input type='hidden' value='$this->worker_id' name='worker_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		"<Form action='workpermit.php' method='POST'><input name='submit' value='New' type='submit'></form>";
		$addnewctrl="<form action='workpermit.php' method='post'><input type='hidden' name='worker_id' value='$this->worker_id'><input type='hidden' name='action' value='default'><input type='submit' value='New' name='new'></form>";
		
//	$transportType=$this->transportType($this->transportationmethod);
//	$this->transportfees=$this->transportFees($this->transportationmethod,$this->orgctrl,$this->comeareafrom_id);
	}
	echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">$header</span></big></big></big></div><br>
<table style="width:140px;"><tbody><td>$addnewctrl</td>
	<td><FORM method='POST' action='workpermit.php'><input name='action' value='searchform' type="hidden"><input type='submit' value="Search Form" type='submit'></FORM></td>
	<td><form onSubmit="return validateWorkPermit()" method="post"
 action="workpermit.php" name="frmWorkPermit"><input name="reset" value="Reset" type="reset"></td></tbody></table>
	<table border='1' cellspacing='3'>
	<tbody>
	<tr><th colspan='4'>WorkPermit Form</th></tr>
	<tr>
	<td class="head">Document No</td>
	<td class="odd"><input name='document_no' value="$this->document_no"></td>
	<td class="head">Registration Date</td>
	<td class="odd"><input id="register_date" name="register_date" value="$this->register_date" size='10' maxlength='10'>
		<input type='button' value='Date' onClick="$this->showcalendar1">
	</td>
	</tr>	
	<tr>
	<td class="head">Worker</td>
	<td class="even">$this->workerctrl</td>
	<td class="head">Expired Date</td>
	<td class="even"><input name="expired_date" id="expired_date" value="$this->expired_date"  size='10' maxlength='10'>
		<input type='button' value='Date' onClick="$this->showcalendar2">
		</td>
	</tr>
	<tr>
	<td class="head">Company</td>
	<td class="odd">$this->companyctrl</td>

	<td class="head">Result</td>
	<td class="even">$permitstatusctrl</td>
	</tr>
	<tr>
	<td class="head">Description (Max 255)</td>
	<td class="odd" colspan='3'><input name='description' value="$this->description" maxlength='255' size='100'></td>
	</tr>
	</tr>
	<tr>
	<td class="head">Others Info</td>
	<td class="even" colspan='3'><textarea name='othersinfo' cols='100' rows='6'>$this->othersinfo</textarea></td>
	</tr>
	</tbody>
	</table>
	<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td><td>$recordctrl</td></tbody></table>

EOF;
  } //showInputForm

  public function insertWorkPermit() {
	//	sleep (10);
     	$timestamp= date("y/m/d H:i:s", time()) ;
	//calculate transport price
	$this->log->showLog(4,"Creating record with SQL:$sql");

	
	$sql="INSERT INTO $this->tableworkpermit (".
		"company_id, worker_id, register_date, expired_date, ".
		"document_no,permitstatus,description,othersinfo, ". 
		" created, createdby, updated, updatedby) VALUES (".
		" '$this->company_id','$this->worker_id', '$this->register_date', '$this->expired_date'".
		", '$this->document_no', '$this->permitstatus', '$this->description', ".
		"'$this->othersinfo', '$this->created', '$this->createdby', '$this->updated', '$this->updatedby')";
	
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
	
  }//insertMedical

/**
   * Get latest workpermit_id
   * @param 
   * return int worker_id
   * @access public
   */
  public function getLatestWorkPermitID(){
	$sql="SELECT MAX(workpermit_id) as workpermit_id from $this->tableworkpermit;";
	$this->log->showLog(4,"Get latest workpermit_id with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['workpermit_id'];
	else
	return -1;
  }//getLatestMedicalID



 /**
   * Update worker class registration information
   *
   * @return bool
   * @access public
   */
  public function updateWorkPermit( ) {
    $timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableworkpermit SET ".
		"company_id='$this->company_id', worker_id='$this->worker_id', register_date='$this->register_date',".
		" expired_date='$this->expired_date',document_no='$this->document_no', ". 
		" permitstatus='$this->permitstatus',description='$this->description',".
		" othersinfo='$this->othersinfo', ". 
		" created='$timestamp', createdby='$this->createdby', updated='$timestamp', updatedby='$this->updatedby' ".
		" WHERE workpermit_id=$this->workpermit_id";
	
	$this->log->showLog(3, "Update workpermit_id: $this->workpermit_id");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update checkup failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update checkup successfully.");
		return true;
	}
  } // end of member function updateMedical

 /**
   * Delte worker class registration information
   * @param int $workpermit_id 
   * @return bool
   * @access public
   */
   public function deleteWorkPermit($workpermit_id){
	$this->log->showLog(2,"Warning: Performing delete WorkPermit id : $workpermit_id !");
	$sql="DELETE FROM $this->tableworkpermit where workpermit_id=$workpermit_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: WorkPermit ($workpermit_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"WorkPermit ($workpermit_id) removed from database successfully!");
		return true;
		
	}
   }


  public function selectWorkPermitResult($permitstatus,$shownull='N'){
	
	$ispassed="";
	$notpassed="";
	$inprogress="";
	$includenull="";
	$isexpired="";
	switch($permitstatus){
		case "P": //passed
			$ispassed='SELECTED="SELECTED"';
		break;
		case "F"://failed
			$notpassed='SELECTED="SELECTED"';
		break;
		case "I"://inprogress
			$inprogress='SELECTED="SELECTED"';
		break;
		case "E"://inprogress
			$isexpired='SELECTED="SELECTED"';
		break;

		//default: //inprogress
		//	$inprogress='SELECTED="SELECTED"';
		//break;
	}
	if($shownull=='Y')
	$includenull="<option value='-' SELECTED='SELECTED'>Null</option>";
	$permitstatus="<SELECT name='permitstatus'>".
			"<option value='P' $ispassed>Passed</option>".
			"<option value='F' $notpassed>Failed</option>".
			"<option value='I' $inprogress>In Progress</option>".
			"<option value='E' $isexpired>Expired</option>".
		"$includenull</select>";
	return $permitstatus;
	}

  public function showSearchForm(){
	$permitstatusctrl=$this->selectWorkPermitResult("-",'Y');
	echo <<< EOF

<FORM method="POST" action="workpermit.php">
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Search Medical Info</span></big></big></big></div><br>
	<table border='1'>
	<tbody>
	<tr><th colspan='4'>Search Form <input name='action' type='hidden' value='search'></th></tr>
	<tr>
	<td class="head">Document No</td>
	<td class="odd"><input name='document_no' value="$this->document_no"></td>
	<td class="head">WorkPermit Date</td>
	<td class="odd">From
		<input id="register_date" name="register_date" value="$this->register_date" size='10' maxlength='10'>
		<input type='button' value='Date' onClick="$this->showcalendar1"> To
		<input id="register_dateto" name="register_dateto" value="$this->register_dateto" size='10' maxlength='10'>
		<input type='button' value='Date' onClick="$this->showcalendar1to">

	</td>
	</tr>	
	<tr>
	<td class="head">Worker</td>
	<td class="even">$this->workerctrl</td>
	<td class="head">Expired Date</td>
	<td class="even">From
		<input name="expired_date" id="expired_date" value="$this->expired_date"  size='10' maxlength='10'>
		<input type='button' value='Date' onClick="$this->showcalendar2"> To
		<input name="expired_dateto" id="expired_dateto" value="$this->expired_dateto"  size='10' maxlength='10'>
		<input type='button' value='Date' onClick="$this->showcalendar2to">

		</td>
	</tr>
	<tr>
	<td class="head">Company</td>
	<td class="odd">$this->companyctrl</td>
	<td class="head">Result</td>
	<td class="odd">$permitstatusctrl</td>
	</tr>
	<tr><td class="foot" colspan='4'>
				<input type='submit' value='Search' Name='submit'>
				<input type='reset' value='Reset' Name='reset'>
				<input type='hidden' value='search' Name='action'>
	</tr>
	</tbody>
	</table>
</form>

EOF;
	}

}
?>
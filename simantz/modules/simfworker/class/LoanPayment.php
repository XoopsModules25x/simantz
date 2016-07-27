<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


class LoanPayment{

  public $loanpayment_id;
  public $worker_id;
  public $loanpayment_date;
  public $document_no;
  public $nextpayment_date;
  public $loanpayment_status;
  public $description;
  public $loanpayment_statusctrl;
  public $amount;
  public $reference_id;
  public $installment_amt;
  public $monthcount;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $workerctrl;
  public $showcalendar1;
  public $showcalendar2;
  public $isAdmin;

  public $type;
  public $xoopsDB;
  private $log;
  public $tableprefix;
  public $tableloanpayment;

  public $tableworker;
  public $tablenationality;
  public $tableraces;
   /**
   *
   * @param xoopsDB $xoopsDB
   * @param string $tableprefix
   * @param log $log
   * Constructor for class LoanPayment
   * @access public
   */
  public function LoanPayment ($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
	$this->tableprefix=$tableprefix;
	$this->tableloanpayment=$tableprefix."simfworker_loanpayment";
	$this->tableworker=$tableprefix."simfworker_worker";
	$this->tableraces=$tableprefix."simfworker_races";
	$this->tablenationality=$tableprefix."simfworker_nationality";
	$this->tablecompany=$tableprefix."simfworker_company";

  } //end Medical

/**
   *Retrieve class registration info from database into class
   * @param int $loanpayment_id 
   * 
   * @access publicgetSelectCurrency
   */
  public function fetchLoanPaymentInfo($loanpayment_id){
	$this->log->showLog(3,"Fetch Class Registration info for record: $loanpayment_id.");
		
	$sql="SELECT worker_id, loanpayment_date, nextpayment_date,amount,monthcount,installment_amt, ".
		"document_no,loanpayment_status,description,type,reference_id ". 
		" created, createdby, updated, updatedby ".
		"FROM $this->tableloanpayment where loanpayment_id=$loanpayment_id";
	
	$this->log->showLog(4,"LoanPayment->fetchLoanPaymentInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->worker_id=$row['worker_id'];

		$this->loanpayment_date=$row['loanpayment_date'];
		$this->nextpayment_date=$row['nextpayment_date'];
		$this->document_no=$row['document_no'];
		$this->monthcount=$row['monthcount'];
		$this->amount=$row['amount'];
		$this->installment_amt=$row['installment_amt'];
		$this->loanpayment_status=$row['loanpayment_status'];
		$this->description=$row['description'];
		$this->reference_id=$row['reference_id'];
		$this->type=$row['type'];
		$this->created=$row['created'];
		$this->createdby=$row['createdby'];
		$this->updated=$row['updated'];
		$this->updatedby=$row['updatedby'];

	$this->log->showLog(4,"LoanPayment->fetchLoanPaymentInfo, database fetch into class successfully, with loanpayment_id=$this->loanpayment_id, loanpayment_status=$this->loanpayment_status");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"LoanPayment->fetchLoanPaymentInfo,failed to fetch data into databases.");	
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
  public function showLoanPaymentTable($wherestring,$orderbystring,$startno,$recordcount){
	
	//$wherestring="";
	$this->log->showLog(3,"Showing Worker Loan & Payment History Table($wherestring,$orderbystring,$startno,$recordcount)");
	$sql="";
	$operationctrl="";
	$sql=$this->getSQLStr_LoanPayment($wherestring,$orderbystring,$startno,$recordcount);
	

	echo <<< EOF
	<table border='1' >
  		<tbody>
    			<tr><th style="text-align:center;" colspan="12">
				Worker Loan/Payment History (Record $startno to $recordcount)
				</th></tr><tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Document No</th>
				<th style="text-align:center;">Amount</th>
				<th style="text-align:center;">Installment</th>
				<th style="text-align:center;">Installment Duration (Month)</th>
				<th style="text-align:center;">Next Payment Date</th>
				<th style="text-align:center;">Edit</th>
				<th style="text-align:center;">Add Payment</th>
</tr>
EOF;
	$rowtype="";
	$sumamt=0;
	$i=0;
//	$this->log->showLog(4,"<tr><td>Start listing data</td></tr>");
	$query=$this->xoopsDB->query($sql);
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$loanpayment_id=$row['loanpayment_id'];
		$worker_id=$row['worker_id'];
		$worker_code=$row['worker_code'];
		$worker_name=$row['worker_name'];
		$worker_no=$row['worker_no'];

		$type=$row['type'];
		$amount=$row['amount'] * $type;
		$sumamt=$sumamt+$amount;
		$installment_amt=$row['installment_amt'];
		$monthcount=$row['monthcount'];
		$loanpayment_date=$row['loanpayment_date'];
		$nextpayment_date=$row['nextpayment_date'];
		$document_no=$row['document_no'];
		$loanpayment_status=$row['loanpayment_status'];
		$description=$row['description'];
		$type=$row['type'];
		$addpaymentctrl="";
		$editname="";
		if($type=="1"){
			$rowtype="even";
			$newnextpaymentdate=$this->newNextPayment_date($nextpayment_date,$loanpayment_id);
			$addpaymentctrl="<form method='POST' action='loanpayment.php'>".
				"<input type='submit' name='submit'  value='Add Payment'>".
				"<input type='hidden' value='$loanpayment_id' name='reference_id'>".
				"<input type='hidden' name='action' value='new'>".
				"<input type='hidden' name='amount' value='$installment_amt'>".
				"<input type='hidden' name='nextpayment_date' value='$newnextpaymentdate'>".
				"<input type='hidden' name='worker_id' value='$worker_id'>".
				"</form>";
			$editname="Edit Loan";
		}
		else{
			$rowtype="odd";
			$editname="Edit Payment";
			$monthcount="";
			$installment_amt="";
		}
		
		$editctrl="<form method='POST' action='loanpayment.php'>".
				"<input type='submit' name='submit'  value='$editname'>".
				"<input type='hidden' value='$loanpayment_id' name='loanpayment_id'>".
				"<input type='hidden' name='action' value='edit'>".
				"<input type='hidden' name='type' value='-1'>".
				"</form>";
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$loanpayment_date</td>

			<td class="$rowtype" style="text-align:center;">$document_no</td>
			<td class="$rowtype" style="text-align:center;">$amount</td>
			<td class="$rowtype" style="text-align:center;">$installment_amt</td>
			<td class="$rowtype" style="text-align:center;">$monthcount</td>
			<td class="$rowtype" style="text-align:center;">$nextpayment_date</td>
			<td class="$rowtype" style="text-align:center;">$editctrl</td>
			<td class="$rowtype" style="text-align:center;">$addpaymentctrl</td>

		</tr>
EOF;
	}
	echo <<< EOF
	<tr>
			<td class="foot" style="text-align:center;"></td>
			<td class="foot" style="text-align:center;"></td>

			<td class="foot" style="text-align:center;"></td>
			<td class="foot" style="text-align:center;">$sumamt</td>
			<td class="foot" style="text-align:center;"></td>
			<td class="foot" style="text-align:center;"></td>
			<td class="foot" style="text-align:center;"></td>
			<td class="foot" style="text-align:center;"></td>
			<td class="foot" style="text-align:center;"></td>

		</tr>

	<td style='text-align: left' colspan='6'>
		<FORM method="POST" action="rptmedicalhistory.php">
		<input name="orderbystring" value="$orderbystring" type='hidden'>
		<input name="wherestring" value="$wherestring" type='hidden'>
		<input type="submit" name='submit' value='Print Preview'>
		</FORm>
	</td>
	<td  style='text-align: center'>
		<form action='loanpayment.php' method='post'>
		<input type='hidden' name='worker_id' value='$this->worker_id'>
		<input type='hidden' name='action' value='default'>
		<input type='hidden' name='type' value='1'>
		<input type='submit' value='Add New Loan' name='new'></form>
	</td>
	</tr>
	</tbody></table><br>
	
EOF;
  }

public function showExpiredTable($wherestring,$orderbystring,$startno,$recordcount){
	
	
	//$wherestring="";
	$this->log->showLog(3,"Showing Worker Loan & Payment History Table($wherestring,$orderbystring,$startno,$recordcount)");
	$sql="";
	$operationctrl="";
	$sql="SELECT lp.loanpayment_id,w.worker_name,w.worker_code, w.worker_id, w.worker_no, ".
		"lp.amount as total, lp.installment_amt,".
		"(SELECT sum(tlp1.amount*tlp1.type) FROM $this->tableloanpayment tlp1 ".
		  "WHERE tlp1.loanpayment_id = lp.loanpayment_id or tlp1.reference_id=lp.loanpayment_id) AS balance, ".
		"(SELECT max(tlp2.nextpayment_date) FROM $this->tableloanpayment tlp2 ".
		  "WHERE tlp2.loanpayment_id = lp.loanpayment_id or tlp2.reference_id=lp.loanpayment_id) AS nextpayment_date,".
		"(SELECT count(tlp3.loanpayment_id) as paidcount from $this->tableloanpayment tlp3 ".
		  "WHERE tlp3.reference_id=lp.loanpayment_id) as paidcount, ".
		"lp.monthcount as monthcount ".
		"FROM $this->tableloanpayment lp ".
		"INNER JOIN $this->tableworker w on lp.worker_id=w.worker_id ".
		"$wherestring $orderbystring LIMIT $startno,$recordcount";

	//$sql=$this->getSQLStr_LoanPayment($wherestring,$orderbystring,$startno,$recordcount);
	$this->log->showLog(4,"With SQL: $sql");

	echo <<< EOF
	<table border='1' >
  		<tbody>
    			<tr><th style="text-align:center;" colspan="12">
				Worker Loan/Payment History (Record $startno to $recordcount)
				</th></tr><tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Worker Code</th>
				<th style="text-align:center;">Worker Name</th>
				<th style="text-align:center;">Next Payment Date</th>
				<th style="text-align:center;">Total</th>
				<th style="text-align:center;">Installment Amount</th>
				<th style="text-align:center;">Paid Count</th>
				<th style="text-align:center;">Balance</th>
				<th style="text-align:center;">Operation</th>
</tr>
EOF;
	$rowtype="";
	$sumamt=0;
	$i=0;
//	$this->log->showLog(4,"<tr><td>Start listing data</td></tr>");
	$query=$this->xoopsDB->query($sql);
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$loanpayment_id=$row['loanpayment_id'];
		$worker_id=$row['worker_id'];
		$worker_code=$row['worker_code'];
		$worker_name=$row['worker_name'];
		$worker_no=$row['worker_no'];
		$total=$row['$total'];
		$type=$row['type'];
		$balance=$row['balance'] ;
		$sumamt=$sumamt+$balance;
		$installment_amt=$row['installment_amt'];
		$paidcount=$row['paidcount'];
		$nextpayment_date=$row['nextpayment_date'];
		$loanpayment_status=$row['loanpayment_status'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		$newnextpaymentdate=$this->newNextPayment_date($nextpayment_date);
		$workerurl="<A href='worker.php?action=edit&worker_id=$worker_id'>$worker_name</A>";
		$operationctrl="<form method='POST' action='loanpayment.php'>".
				"<input type='hidden'  name='reference_id'  value='$loanpayment_id'>".
				"<input type='submit'  name='submit'  value='Add New'>".
				"<input type='hidden' name='amount' value='$installment_amt'>".
				"<input type='hidden'  name='nextpayment_date'  value='$newnextpaymentdate'>".
				"<input type='hidden'  name='amount'  value='$installment_amt'>".
				"<input type='hidden' value='$worker_id' name='worker_id'>".
				"<input type='hidden' name='action' value='new'>".
				"</form>";
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$worker_code</td>
			<td class="$rowtype" style="text-align:center;">$workerurl</td>
			<td class="$rowtype" style="text-align:center;">$nextpayment_date</td>
			<td class="$rowtype" style="text-align:right;">$total</td>
			<td class="$rowtype" style="text-align:right;">$installment_amt</td>
			<td class="$rowtype" style="text-align:right;">$paidcount</td>
			<td class="$rowtype" style="text-align:right;">$balance</td>
			<td class="$rowtype" style="text-align:center;">$operationctrl</td>

		</tr>
EOF;
	}
	echo <<< EOF
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
  public function getSQLStr_LoanPayment($wherestring,$orderbystring,$startno,$recordcount){
	$sql=""; 
	$this->log->showLog(3,"LoanPayment-getSQLStr_LoanPayment($type,$wherestring,$orderbystring");
		$sql="SELECT m.loanpayment_id, m.worker_id, m.loanpayment_date, m.nextpayment_date, ".
		"m.document_no,m.loanpayment_status,m.reference_id,reference_id,m.description,m.type, ". 
		" w.worker_name,w.worker_no,w.worker_code,m.installment_amt,m.amount,m.monthcount ".
		"FROM $this->tableloanpayment m ".
		"INNER JOIN $this->tableworker w on w.worker_id=m.worker_id ".
		" $wherestring $orderbystring  LIMIT $startno, $recordcount";
	$this->log->showLog(4,"With sql: $sql");

	return $sql;
  }//end showRegisteredClass

/**
   *
   * @param string $type can be 'edit' or 'new'
   * @param int $loanpayment_id
   * @param string $token for security purpose
   * Display forms for user to create/edit existing worker-class registration
   * @access public
   */
  public function showInputForm($type,$loanpayment_id,$token){
	$this->log->showLog(3,"Accessing LoanPayment->showInputForm($type,$loanpayment_id,$token)");
	$checked="";
	$paidchecked="";
	$transportType="";
	$feesctrl="";
//	$loanpayment_statusctrl=$this->selectLoanPaymentStatus($this->loanpayment_status);
	$jumptotopayment="";
	$isloan="";
	$ispayment="";
		if($this->type==1)
			$isloan="SELECTED='SELECTED'";
		else
			$ispayment="SELECTED='SELECTED'";
	$ischecked="";

	if($this->loanpayment_status=="1")
		$ischecked="CHECKED";
	else
		$ischecked="";
	

		$typectrl="<SELECT name='type' onChange='onOpen()'>".
				"<OPTION value='1' $isloan>Loan</OPTION>".
				"<OPTION value='-1' $ispayment>Payment</OPTION>".
			"</SELECT>";
	

     if($type=="new"){
		if($this->loanpayment_date=="")
			$this->loanpayment_date=date("Y-m-d", time()) ;;

		if($this->nextpayment_date=="")
			$this->nextpayment_date='0000-00-00';

		if($this->amount=="")
			$this->amount=0.00;

		$this->installment_amt=0;
		$this->monthcount=0;
		$header="New Loan/Payment";
		$action="create";
		$ischecked="CHECKED";
		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
//	$transportType=$this->transportType("BOTH");
	}
     else{
		$action="update";
		$savectrl="<input name='loanpayment_id' value='$this->loanpayment_id' type='hidden'>".
			 "<input style='height:40px;' name='submit' value='Save' type='submit'>";

		
		//force isactive checkbox been checked if the value in db is 'Y'
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableloanpayment' type='hidden'>".
		"<input name='id' value='$this->loanpayment_id' type='hidden'>".
		"<input name='idname' value='loanpayment_id' type='hidden'>".
		"<input name='title' value='Class Registration' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'  style='height: 40px;'>".
		"</form>";

		$header="Edit LoanPayment Details";
		$deletectrl="<FORM action='loanpayment.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this registration?"'.")'><input type='submit' value='Delete' name='submit'  style='height: 40px;'>".
		"<input type='hidden' value='$this->loanpayment_id' name='loanpayment_id'>".
		"<input type='hidden' value='$this->worker_id' name='worker_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		"<Form action='loanpayment.php' method='POST'><input name='submit' value='New' type='submit'></form>";
		
		
//	$transportType=$this->transportType($this->transportationmethod);
//	$this->transportfees=$this->transportFees($this->transportationmethod,$this->orgctrl,$this->comeareafrom_id);
	}
	echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">$header</span></big></big></big></div><br>
<table style="width:140px;"><tbody><td>$addnewctrl</td>
	<td><FORM method='POST' action='loanpayment.php'><input name='action' value='searchform' type="hidden"><input type='submit' value="Search Form" type='submit'></FORM></td>
	<td><form onSubmit="return validateLoanPayment()" method="post"
 action="loanpayment.php" name="frmLoanPayment"><input name="reset" value="Reset" type="reset"></td></tbody></table>
	<table border='1' cellspacing='3'>
	<tbody>
	<tr><th colspan='4'>LoanPayment Form</th></tr>
	<tr>
	<td class="head">Document No</td>
	<td class="odd"><input name='document_no' value="$this->document_no"></td>
	<td class="head">LoanPayment Date</td>
	<td class="odd"><input id="loanpayment_date" name="loanpayment_date" value="$this->loanpayment_date" size='10' maxlength='10'>
		<input type='button' value='Date' onClick="$this->showcalendar1">
		<input type='hidden' name='worker_id' value="$this->worker_id">
	</td>
	</tr>	
	<tr>
	<td class="head">Amount</td>
	<td class="even"><input name="amount"  value="$this->amount"  size='12' maxlength='12'></td>
	<td class="head">Type</td>
	<td class="even">$typectrl <input type='hidden' name='reference_id' value='$this->reference_id'></td>
	</tr>
	<tr>
	<td class="head">Monthly Payment Amount</td>
	<td class="even"><input name='installment_amt' value="$this->installment_amt"></td>
	<td class="head">Installment Duration (Month)</td>
	<td class="even"><input name='monthcount' value="$this->monthcount"></td>
	</tr>
	<tr>
	<td class="head">Status</td>
	<td class="odd"><input type='checkbox' name='loanpayment_status' $ischecked></td>
	<td class="head">Next Payment Date</td>
	<td class="odd">
		<input name='nextpayment_date' id='nextpayment_date' value="$this->nextpayment_date">
		<input type='button' value='Date' onClick="$this->showcalendar2">
	</td>

	</tr>
	<tr>
	<td class="head">Description (Max 255)</td>
	<td class="odd" colspan='3'><input name='description' value="$this->description" maxlength='255' size='100'></td>
	</tr>
	</tr>
	</tbody>
	</table>
	<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td><td>$recordctrl</td></tbody></table>

EOF;
  } //showInputForm

  public function insertLoanPayment() {
	//	sleep (10);
     	$timestamp= date("y/m/d H:i:s", time()) ;
	//calculate transport price
	$this->log->showLog(4,"Creating record with SQL:$sql");

	
	$sql="INSERT INTO $this->tableloanpayment (".
		" worker_id, loanpayment_date, nextpayment_date,installment_amt, ".
		"document_no,loanpayment_status,description,type, amount,". 
		" monthcount, created, createdby, updated, updatedby,reference_id) VALUES (".
		" '$this->worker_id', '$this->loanpayment_date', '$this->nextpayment_date','$this->installment_amt',".
		" '$this->document_no',  '$this->loanpayment_status', '$this->description','$this->type', '$this->amount',".
		" $this->monthcount, '$this->created', '$this->createdby', '$this->updated', '$this->updatedby','$this->reference_id')";
	
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
   * Get latest loanpayment_id
   * @param 
   * return int worker_id
   * @access public
   */
  public function getLatestLoanPaymentID(){
	$sql="SELECT MAX(loanpayment_id) as loanpayment_id from $this->tableloanpayment;";
	$this->log->showLog(4,"Get latest loanpayment_id with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['loanpayment_id'];
	else
	return -1;
  }//getLatestMedicalID



 /**
   * Update worker class registration information
   *
   * @return bool
   * @access public
   */
  public function updateLoanPayment( ) {
    $timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableloanpayment SET ".
		" worker_id='$this->worker_id', loanpayment_date='$this->loanpayment_date',".
		" nextpayment_date='$this->nextpayment_date',document_no='$this->document_no', ".
		"  loanpayment_status='$this->loanpayment_status',description='$this->description',".
		"type='$this->type', installment_amt='$this->installment_amt', amount='$this->amount',". 
		" created='$timestamp', createdby='$this->createdby', updated='$timestamp', updatedby='$this->updatedby' ".
		" , monthcount='$this->monthcount' WHERE loanpayment_id=$this->loanpayment_id";
	
	$this->log->showLog(3, "Update loanpayment_id: $this->loanpayment_id");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update loanpayment failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update loanpayment successfully.");
		return true;
	}
  } // end of member function updateMedical

 /**
   * Delte worker class registration information
   * @param int $loanpayment_id 
   * @return bool
   * @access public
   */
   public function deleteLoanPayment($loanpayment_id){
	$this->log->showLog(2,"Warning: Performing delete LoanPayment id : $loanpayment_id !");
	$sql="DELETE FROM $this->tableloanpayment where loanpayment_id=$loanpayment_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: LoanPayment ($loanpayment_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"LoanPayment ($loanpayment_id) removed from database successfully!");
		return true;
		
	}
   }

/*
  public function selectLoanPaymentStatus($loanpayment_status,$shownull='N'){
	
	$isnormal="";
	$isignore="";
	$inprogress="";
	$isexpired="";
	$includenull="";
	switch($loanpayment_status){
		case "A": //passed
			$isActive='SELECTED="SELECTED"';
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
	$loanpayment_status="<SELECT name='loanpayment_status'>".
			"<option value='P' $ispassed>Passed</option>".
			"<option value='F' $notpassed>Failed</option>".
			"<option value='I' $inprogress>In Progress</option>".
			"<option value='E' $isexpired>Expired</option>".
		"$includenull</select>";
	return $loanpayment_status;
	}*/

  public function showSearchForm(){
	$loanpayment_statusctrl=$this->selectLoanPaymentStatus("-",'Y');
	echo <<< EOF

<FORM method="POST" action="loanpayment.php">
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Search Medical Info</span></big></big></big></div><br>
	<table border='1'>
	<tbody>
	<tr><th colspan='4'>Search Form <input name='action' type='hidden' value='search'></th></tr>
	<tr>
	<td class="head">Document No</td>
	<td class="odd"><input name='document_no' value="$this->document_no"></td>
	<td class="head">LoanPayment Date</td>
	<td class="odd"><input id="loanpayment_date" name="loanpayment_date" value="$this->loanpayment_date" size='10' maxlength='10'>
		<input type='button' value='Date' onClick="$this->showcalendar1">
	</td>
	</tr>	
	<tr>
	<td class="head">Worker</td>
	<td class="even">$this->workerctrl</td>
	<td class="head">Status</td>
	<td class="odd">$loanpayment_statusctrl</td>
	</tr>
	</tbody>
	</table>
</form>

EOF;
	}

  public function newNextPayment_date($nextpayment_date,$loanpayment_id=0){
	
	
	if($loanpayment_id==0){
			$this->log->showLog(4,"Return next date:". date("Y-m-d",strtotime("+1 month",strtotime($nextpayment_date))));
	
		return date("Y-m-d",strtotime("+1 month",strtotime($nextpayment_date)));
		}
	else{
		$sql="SELECT max(nextpayment_date) as latestnextpayment_date from $this->tableloanpayment where reference_id=$loanpayment_id";
		$this->log->showLog(4,"GetNextPaymentDate with SQL: $sql");

		$query=$this->xoopsDB->query($sql);
		
		$newnextpayment_date="";
		$i=0;
		while($row=$this->xoopsDB->fetchArray($query)){
				$newnextpayment_date=$row['latestnextpayment_date'];
				$i++;
		}
		
		if($newnextpayment_date==""){
				$sql="SELECT nextpayment_date FROM $this->tableloanpayment ".
					" WHERE loanpayment_id=$loanpayment_id";
				$this->log->showLog(4,"No existing payment, GetNextPaymentDate with SQL: $sql");
				$query=$this->xoopsDB->query($sql);
				if($row=$this->xoopsDB->fetchArray($query))
				{
					$newnextpayment_date=$row['nextpayment_date'];
					$i++;
				}
			}

		$this->log->showLog(4,"Return next date:". date("Y-m-d",strtotime("+1 month",strtotime($newnextpayment_date))));
		return  date("Y-m-d",strtotime("+1 month",strtotime($newnextpayment_date)));;
  	}
  }

}
?>
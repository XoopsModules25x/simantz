<?php


class PaymentVoucher
{

  public $paymentvoucher_id;
  public $paidto;
  public $organization_id;
  
  public $iscomplete;
  public $description;
  public $exchangerate;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tablepaymentvoucher;
  private $tablebpartner;

  private $log;


//constructor
   public function PaymentVoucher(){
	global $xoopsDB,$log,$tablepaymentvoucher,$tablebpartner,$tablebpartnergroup,$tablecurrency,$tableorganization,$tableaccounts,$tableaccounts;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tableaccounts=$tableaccounts;
	$this->tablecurrency=$tablecurrency;
	$this->tablepaymentvoucher=$tablepaymentvoucher;
	$this->tableaccounts=$tableaccounts;
	$this->tablebpartner=$tablebpartner;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int paymentvoucher_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $paymentvoucher_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Payment Voucher";
		$action="create";
	 	
		if($paymentvoucher_id==0){
			$this->paidto="";
			$this->iscomplete="";
			$this->exchangerate=1;
			$this->amt=0;
			$this->displaychequenostyle="style='display:none'";
			$this->originalamt=0;
			$this->iscomplete=0;
			$this->paymentvoucher_no=getNewCode($this->xoopsDB,"paymentvoucher_no",$this->tablepaymentvoucher);
			//$this->paymentvoucher_date=date('Y-m-d',time());
			$this->paymentvoucher_date= getDateSession();
			$this->batch_id=0;
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'  onclick='iscomplete.value=0'>";
		$completectrl= "<input style='height: 40px;' name='submit' value='Complete' type='submit' onclick='iscomplete.value=1'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";
		$closectrl="";
	
	}
	else
	{
		
		$action="update";
		
		

		if($this->isAdmin){
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablepaymentvoucher' type='hidden'>".
		"<input name='id' value='$this->paymentvoucher_id' type='hidden'>".
		"<input name='idname' value='paymentvoucher_id' type='hidden'>".
		"<input name='title' value='Financial Year' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		}

		$previewctrl="<form target='_blank' action='viewpaymentvoucher.php' method='POST'>".
		"<input name='paymentvoucher_id' value='$this->paymentvoucher_id' type='hidden'>".
		"<input name='submit' value='Print Preview' type='submit'>".
		"</form>";
		
		$princhequectrl="<form target='_blank' action='viewprintcheque.php' method='POST' name='frmPrintCheque'>".
		"<input name='paymentvoucher_id' value='$this->paymentvoucher_id' type='hidden'>".
		"<input name='submit' value='Print Cheque' type='submit' id='btnPrintCheque' $this->displaychequenostyle>".
		"</form>";	

		$header="Edit Payment Voucher";
		
		if($this->iscomplete==0){
		$deletectrl="<FORM action='paymentvoucher.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this paymentvoucher?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->paymentvoucher_id' name='paymentvoucher_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		$savectrl="<input name='paymentvoucher_id' value='$this->paymentvoucher_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit' onclick='iscomplete.value=0'>";
		$completectrl= "<input style='height: 40px;' name='submit' value='Complete' type='submit' onclick='iscomplete.value=1'>";
		}
		else{
		$deletectrl="";
		$savectrl="";
		$completectrl= "";
		if($this->isAdmin)
		$activatectrl="<FORM action='paymentvoucher.php' method='POST' onSubmit='return confirm(".
		'"confirm to reactivate this paymentvoucher?"'.")'><input type='submit' value='Reactivate' name='submit'>".
		"<input type='hidden' value='$this->paymentvoucher_id' name='paymentvoucher_id'>".
		"<input type='hidden' value='reactivate' name='action'><input name='token' value='$token' type='hidden'></form>";
		}
		if($this->batch_id>0)
		$viewbatch="<a href='batch.php?batch_id=$this->batch_id&action=edit'>View Journal</a>";
		else
		$viewbatch="";
		
	}

if($this->bpartner_id == 0)
$bpartner_fld = "<input type='hidden' name='bpartner_id' value='0'>";	

    echo <<< EOF
<A href='paymentvoucher.php'>[Add New]</A>&nbsp;<A href='paymentvoucher.php?action=showSearchForm'>[Search]</A>

<form onsubmit="return validatePaymentVoucher()" method="post" action="paymentvoucher.php" name="frmPaymentVoucher">
<table style="width:140px;"><tbody><td><input name="reset" value="Reset" type="reset"></td></tbody></table>
<div id="bpartnerID">$bpartner_fld</div>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" colspan='3'>$this->orgctrl $viewbatch</td>
	</tr><tr>
   	<td class="head">Date </td>
        <td class="even" ><input name="paymentvoucher_date" value="$this->paymentvoucher_date" id='paymentvoucher_date' size='10' maxlength='10'>
		<input name="btnDate" value="Date" id='btnDate'  onclick="$this->showCalendar" type='button'></td>

   	<td class="head">Payment Voucher No </td>
        <td class="even" ><input name="paymentvoucher_no" value="$this->paymentvoucher_no">
		<input name="iscomplete" value="$this->iscomplete" type='hidden'></td>
      </tr>
      <tr>
     
        <td class="head">To Accounts</td>
        <td class="even">$this->accountstoctrl <div id='divbpartner'> $this->bpartnerctrl</div> 
			<input name='bpartner_id_bc' id='bpartner_id_bc' type='hidden' value="$this->bpartner_id_bc"></td>
        <td class="head">Paid To</td>
        <td class="even"><input name='paidto' value="$this->paidto"></td>
      </tr>
      <tr>
        <td class="head">Currency</td>
        <td class="even">$this->currencyctrl</td>
        <td class="head">Exchange Rate</td>
        <td class="even"><input name='exchangerate' value="$this->exchangerate" onchange='amt.value=parseFloat(this.value*originalamt.value).toFixed(2)'></td>
      </tr>
      <tr>
        <td class="head">Amount</td>
        <td class="even"><input name='originalamt' value="$this->originalamt" onchange='amt.value=parseFloat(exchangerate.value*this.value).toFixed(2)'></td>
        <td class="head">Coverted Amount</td>
        <td class="even"><input name='amt' value="$this->amt" readonly='readonly'></td>
      </tr>

      <tr>
   <td class="head">From Accounts</td>
        <td class="even">$this->accountsfromctrl <input value="$this->chequeno" name='chequeno' $this->displaychequenostyle>
		</td>
        <td class="head">Received By</td>
        <td class="even"><input name='receivedby' value="$this->receivedby">
	<input name='batch_id' value="$this->batch_id" type='hidden'></td>
      </tr>
      <tr>
        <td class="head">Description</td>
        <td class="even" colspan='3'><textarea cols='70' name='description' >$this->description</textarea></td>
      </tr>
 <tr>
        <td class="head">Add New Record</td>
        <td class="even" colspan='3'><input type='checkbox' name='chkAddNew'> Add new record immediately after save or complete.</td>
      </tr>
    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$savectrl </td><td>$completectrl</td>
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</tbody>
	<table></form>

	<table style="width:150px;">
	<td>$deletectrl $activatectrl</td><td>$recordctrl</td><td>$previewctrl</td><td>$princhequectrl</td></table>
  <br>



EOF;
  } // end of member function getInputForm

  /**
   * Update existing paymentvoucher record
   *
   * @return bool
   * @access public
   */
  public function updatePaymentVoucher( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablepaymentvoucher SET 
	paidto='$this->paidto',description='$this->description',originalamt=$this->originalamt,amt=$this->amt,
	updated='$timestamp',updatedby=$this->updatedby,iscomplete='$this->iscomplete',exchangerate=$this->exchangerate,
	organization_id=$this->organization_id,accountsfrom_id=$this->accountsfrom_id,accountsto_id=$this->accountsto_id,
	currency_id=$this->currency_id,paymentvoucher_no='$this->paymentvoucher_no',bpartner_id=$this->bpartner_id,
	paymentvoucher_date='$this->paymentvoucher_date',receivedby='$this->receivedby',chequeno='$this->chequeno',
	batch_id=$this->batch_id WHERE paymentvoucher_id='$this->paymentvoucher_id'";
	
	$this->log->showLog(3, "Update paymentvoucher_id: $this->paymentvoucher_id, $this->paidto");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update paymentvoucher failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update paymentvoucher successfully.");
		return true;
	}
  } // end of member function updatePaymentVoucher

  /**
   * Save new paymentvoucher into database
   *
   * @return bool
   * @access public
   */
  public function insertPaymentVoucher( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new paymentvoucher $this->paidto");
 	$sql="INSERT INTO $this->tablepaymentvoucher (paidto,iscomplete, created,createdby,
	updated,updatedby,exchangerate,organization_id,description,accountsfrom_id,accountsto_id,currency_id,
		paymentvoucher_no,amt,originalamt,bpartner_id,paymentvoucher_date,receivedby,chequeno,batch_id) values(
	'$this->paidto','$this->iscomplete','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->exchangerate,$this->organization_id,'$this->description',
	$this->accountsfrom_id,$this->accountsto_id,$this->currency_id,'$this->paymentvoucher_no',$this->amt,$this->originalamt,$this->bpartner_id,
	'$this->paymentvoucher_date','$this->receivedby','$this->chequeno',$this->batch_id)";

	$this->log->showLog(4,"Before insert paymentvoucher SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert paymentvoucher code $paidto:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new paymentvoucher $paidto successfully"); 
		return true;
	}
  } // end of member function insertPaymentVoucher

  /**
   * Pull data from paymentvoucher table into class
   *
   * @return bool
   * @access public
   */
  public function fetchPaymentVoucher( $paymentvoucher_id) {


	$this->log->showLog(3,"Fetching paymentvoucher detail into class PaymentVoucher.php.<br>");
		
	$sql="SELECT paymentvoucher_id,paidto,iscomplete,exchangerate,organization_id,description,accountsfrom_id,accountsto_id,
		currency_id,amt,originalamt,paymentvoucher_no,batch_id,paymentvoucher_date,receivedby,paidto,bpartner_id,chequeno
		 from $this->tablepaymentvoucher where paymentvoucher_id=$paymentvoucher_id";
	
	$this->log->showLog(4,"ProductPaymentVoucher->fetchPaymentVoucher, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->paymentvoucher_no=$row["paymentvoucher_no"];
		$this->batch_id=$row["batch_id"];
		$this->organization_id=$row['organization_id'];
		$this->exchangerate= $row['exchangerate'];
		$this->paidto=$row['paidto'];
		$this->iscomplete=$row['iscomplete'];
		$this->accountsto_id=$row['accountsto_id'];
		$this->accountsfrom_id=$row['accountsfrom_id'];
		$this->currency_id=$row['currency_id'];
		$this->paymentvoucher_date=$row['paymentvoucher_date'];
		$this->receivedby=$row['receivedby'];
		$this->chequeno=$row['chequeno'];
		$this->amt=$row['amt'];
		$this->originalamt=$row['originalamt'];
		$this->paymentvoucher_no=$row['paymentvoucher_no'];
		$this->description=$row['description'];
		$this->bpartner_id=$row['bpartner_id'];
   	$this->log->showLog(4,"PaymentVoucher->fetchPaymentVoucher,database fetch into class successfully");
	$this->log->showLog(4,"paymentvoucher_no:$this->paymentvoucher_no");

	$this->log->showLog(4,"iscomplete:$this->iscomplete");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"PaymentVoucher->fetchPaymentVoucher,failed to fetch data into databases:" . mysql_error(). ":$sql");	
	}
  } // end of member function fetchPaymentVoucher

  /**
   * Delete particular paymentvoucher id
   *
   * @param int paymentvoucher_id 
   * @return bool
   * @access public
   */
  public function deletePaymentVoucher( $paymentvoucher_id ) {
    	$this->log->showLog(2,"Warning: Performing delete paymentvoucher id : $paymentvoucher_id !");
	$sql="DELETE FROM $this->tablepaymentvoucher where paymentvoucher_id=$paymentvoucher_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: paymentvoucher ($paymentvoucher_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"paymentvoucher ($paymentvoucher_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deletePaymentVoucher

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllPaymentVoucher( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductPaymentVoucher->getSQLStr_AllPaymentVoucher: $sql");

    $sql="SELECT f.paymentvoucher_no,f.paymentvoucher_id,f.iscomplete,f.organization_id,f.exchangerate,f.paidto,
		f.currency_id,p.accounts_name as accountsfrom,p2.accounts_name as accountsto,
		f.amt,f.originalamt,cr.currency_code,f.paymentvoucher_date,f.receivedby,f.chequeno
		 FROM $this->tablepaymentvoucher  f
		INNER JOIN $this->tableaccounts p on p.accounts_id=f.accountsfrom_id
		INNER JOIN $this->tableaccounts p2 on p2.accounts_id=f.accountsto_id
		INNER JOIN $this->tablecurrency cr on cr.currency_id=f.currency_id
		 $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showpaymentvouchertable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllPaymentVoucher

 public function showPaymentVoucherTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing PaymentVoucher Table");
	$sql=$this->getSQLStr_AllPaymentVoucher($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Payment Voucher No</th>
				<th style="text-align:center;">Paid From</th>
				<th style="text-align:center;">Account From</th>
				<th style="text-align:center;">Account To</th>
				<th style="text-align:center;">Currency</th>
				<th style="text-align:center;">Amount</th>
				<th style="text-align:center;">Cheque No</th>
				<th style="text-align:center;">Complete</th>
				<th style="text-align:center;">Preview</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$paymentvoucher_id=$row['paymentvoucher_id'];
		$paymentvoucher_no=$row['paymentvoucher_no'];
		$paymentvoucher_date=$row['paymentvoucher_date'];
		$paidto=$row['paidto'];
		$accountsfrom=$row['accountsfrom'];
		$accountsto=$row['accountsto'];
		$currency_id=$row['currency_id'];
		$currency_code=$row['currency_code'];
		$amt=$row['amt'];
		$originalamt=$row['originalamt'];
		$exchangerate=$row['exchangerate'];
		$iscomplete=$row['iscomplete'];
		$bpartner_id=$row['bpartner_id'];
		$chequeno=$row['chequeno'];
		if($iscomplete==0)
		{$iscomplete='N';
		$iscomplete="<b style='color:red;'>$iscomplete</b>";
		}
		else
		$iscomplete='Y';
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$paymentvoucher_date</td>
			<td class="$rowtype" style="text-align:center;">
				<a href='paymentvoucher.php?action=edit&paymentvoucher_id=$paymentvoucher_id'>$paymentvoucher_no</a></td>
			<td class="$rowtype" style="text-align:center;">$paidto</td>
			<td class="$rowtype" style="text-align:center;">$accountsfrom</td>
			<td class="$rowtype" style="text-align:center;">$accountsto</td>
			<td class="$rowtype" style="text-align:center;">$currency_code</td>
			<td class="$rowtype" style="text-align:center;">$originalamt</td>
			<td class="$rowtype" style="text-align:center;">$chequeno</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
			<table><tr>
			<td>
				<form action="viewpaymentvoucher.php" method="POST">
				<input type="image" src="images/list.gif" name="submit" title='Preview'>
				<input type="hidden" value="$paymentvoucher_id" name="paymentvoucher_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>
			<td>
				<form action="paymentvoucher.php" method="POST">
				<input type="image" src="images/edit.gif" name="btnEdit" title='Edit this record'>
				<input type="hidden" value="$paymentvoucher_id" name="paymentvoucher_id">
				<input type="hidden" name="action" value="edit">
				</form>
				</td>
			</tr>
			</table>
				
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestPaymentVoucherID() {
	$sql="SELECT MAX(paymentvoucher_id) as paymentvoucher_id from $this->tablepaymentvoucher;";
	$this->log->showLog(3,'Checking latest created paymentvoucher_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created paymentvoucher_id:' . $row['paymentvoucher_id']);
		return $row['paymentvoucher_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(exchangerate) + 10 as exchangerate from $this->tablepaymentvoucher;";
	$this->log->showLog(3,'Checking next exchangerate');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found next exchangerate:' . $row['exchangerate']);
		return  $row['exchangerate'];
	}
	else
	return 10;
	
  } // end

 public function allowDelete($paymentvoucher_id){
	$sql="SELECT count(account_id) as rowcount from $this->tableaccounts where paymentvoucher_id=$paymentvoucher_id";
	$this->log->showLog(3,"Accessing ProductCurrency->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this currency, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this currency, record deletable.");
		return true;
		}
	}


public function showSearchForm(){
if($this->iscomplete==1)
{$selectiscompletey="SELECTED='SELECTED'";
$selectiscompleten="";
$selectiscompletenull="";
}
elseif($this->iscomplete==0)
{
$selectiscompletey="";
$selectiscompleten="SELECTED='SELECTED'";
$selectiscompletenull="";
}
else
{
$selectiscompletey="";
$selectiscompleten="";
$selectiscompletenull="SELECTED='SELECTED'";
}

echo <<< EOF

<A href='paymentvoucher.php'>[Add New]</A>&nbsp;<A href='paymentvoucher.php?action=showSearchForm'>[Search]</A>
<FORM name='frmSearchPaymentVoucher' method='POST' action='paymentvoucher.php'>
<table border='1'>
  <tbody>
    <tr>
      <th colspan="4">Search Criterial</th>
    </tr>
    <tr>
      <td class='head'>Date From (YYYY-MM-DD)</td>
      <td class='even'><input name='datefrom' value="$this->datefrom" id='datefrom' size='10' maxlength='10' value="$this->datefrom">
		<input name='btndatefrom' type='button' value='Date' onclick="$this->showDateFrom"></td>
      <td class='head'>Date To (YYYY-MM-DD)</td>
      <td class='even'><input name='dateto' value="$this->dateto" id='dateto' size='10' maxlength='10' value="$this->datefrom">
		<input name='btndateto' type='button' value='Date' onclick="$this->showDateTo"></td>
    </tr>
    <tr>
      <td class='head'>Payment Voucher No From</td>
      <td class='even'><input name='paymentvoucherfrom_no' value="$this->paymentvoucherfrom_no" size='11' maxlength='11'></td>
      <td class='head'>Payment Voucher No To</td>
      <td class='even'><input name='paymentvoucherto_no' value="$this->paymentvoucherto_no" size='11' maxlength='11'></td>
    </tr>
    <tr>
      <td class='head'>From Account</td>
      <td class='even'>$this->accountsfromctrl</td>
      <td class='head'>To Account</td>
      <td class='even'>$this->accountstoctrl</td>
    </tr>
    <tr>
      <td class='head'>Paid To(Ali%, %Ahmad%, Ali%Ahmad)</td>
      <td class='even'><input name='paidto' value="$this->paidto"></td>
      <td class='head'>Company</td>
      <td class='even'>$this->bpartnerctrl</td>
    </tr>
    <tr>
      <td class='head'>Currency</td>
      <td class='even'>$this->currencyctrl</td>
      <td class='head'>Received By (Ali%, %Ahmad%, Ali%Ahmad)</td>
      <td class='even'><input name='receivedby' value="$this->receivedby"></td>
    </tr>
    <tr>
      <td class='head'>Is Complete</td>
      <td class='even'><SELECT name='iscomplete'>
	<option value='-1' $selectiscompletenull>Null</option>
	<option value='1' $selectiscompletey>Y</option>
	<option value='0'$selectiscompleten>N</option></SELECT></td>
      <td class='head'>Cheque No</td>
      <td class='even'><input name='chequeno' value="$this->chequeno"></td>
    </tr>
  </tbody>
</table>
<INPUT type='submit' NAME='submit' value='Search'>
<input type='reset' name='reset' value='Reset'>
<input type='hidden' name='action' value='search'>
</form>
EOF;
	}

public function genWhereString(){
	if($this->datefrom=="")
		$this->datefrom="0000-00-00";
	if($this->dateto=="")
		$this->dateto="9999-12-31";

	$wherestring=" and f.paymentvoucher_date between '$this->datefrom' and '$this->dateto' AND";

	if($this->paymentvoucherfrom_no!="")
		$wherestring=$wherestring. " f.paymentvoucher_no >= '$this->paymentvoucherfrom_no' AND";

	if($this->paymentvoucherto_no!="")
		$wherestring=$wherestring. " f.paymentvoucher_no <= '$this->paymentvoucherto_no' AND";

	if($this->iscomplete !="-1")
		$wherestring=$wherestring. " f.iscomplete = $this->iscomplete AND";
	
	if($this->accountsfrom_id!=0)
		$wherestring=$wherestring. " f.accountsfrom_id = $this->accountsfrom_id AND";

	if($this->accountsto_id!=0)
		$wherestring=$wherestring. " f.accountsto_id = $this->accountsto_id AND";

	if($this->currency_id!=0)
		$wherestring=$wherestring. " f.currency_id = $this->currency_id AND";


	if($this->bpartner_id!=0)
		$wherestring=$wherestring. " f.bpartner_id = $this->bpartner_id AND";

	if($this->paidto!="")
		$wherestring=$wherestring. " f.paidto LIKE '$this->paidto' AND";

	if($this->receivedby!="")
		$wherestring=$wherestring. " f.receivedby LIKE '$this->receivedby' AND";

	if($this->chequeno!="")
		$wherestring=$wherestring. " f.chequeno =$this->chequeno AND";


	$wherestring=substr_replace($wherestring,"",-3);
	$this->log->showLog(3,"generate wherestring: $wherestring");
	return $wherestring;

}

} // end of ClassPaymentVoucher
?>

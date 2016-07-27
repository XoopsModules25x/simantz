<?php


class Receipt
{

  public $receipt_id;
  public $paidfrom;
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
  private $tablereceipt;
  private $tablebpartner;

  private $log;


//constructor
   public function Receipt(){
	global $xoopsDB,$log,$tablereceipt,$tablebpartner,$tablebpartnergroup,$tablecurrency,$tableorganization,$tableaccounts,$tableaccounts;
	global $tablereceiptline;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tableaccounts=$tableaccounts;
	$this->tablecurrency=$tablecurrency;
	$this->tablereceipt=$tablereceipt;
	$this->tablereceiptline=$tablereceiptline;
	$this->tableaccounts=$tableaccounts;
	$this->tablebpartner=$tablebpartner;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type
   * @param int receipt_id
   * @return
   * @access public
   */
  public function getInputForm( $type,  $receipt_id,$token  ) {
      global $prefix_rcpt,$mandatorysign;


    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	$originalamtctrl="";

	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Receipt";
		$action="create";

		if($receipt_id==0){
			$this->paidfrom="";
			$this->iscomplete="";
			$this->exchangerate=1;
			$this->amt=0;
			$this->displaychequenostyle="style='display:none'";
			//$this->receipt_date=date('Y-m-d',time());
			$this->receipt_date= getDateSession();
			$this->batch_id=0;
			$this->receipt_no=getNewCode($this->xoopsDB,"receipt_no",$this->tablereceipt);
			$this->originalamt=0;
			$this->iscomplete=0;
                        $this->receipt_prefix=$prefix_rcpt;


		}
		$savectrl="<input style='height: 40px;' name='btnSave' value='Save' type='button'  onclick='iscomplete.value=0;saveRecord();'>";
		$completectrl= "";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";
		$closectrl="";

		$originalamtctrl = "<input name='originalamt' type='hidden' value='0'>";

	}
	else
	{

		$action="update";



		if($this->isAdmin){
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablereceipt' type='hidden'>".
		"<input name='id' value='$this->receipt_id' type='hidden'>".
		"<input name='idname' value='receipt_id' type='hidden'>".
		"<input name='title' value='Financial Year' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		}

		$previewctrl="<form target='_blank' action='viewreceipt.php' method='POST'>".
		"<input name='receipt_id' value='$this->receipt_id' type='hidden'>".
		"<input name='btnPreview' value='Print Preview' type='submit'>".
		"</form>";


		$header="Edit Receipt";

		if($this->iscomplete==0){
		$deletectrl="<FORM action='receipt.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this receipt?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->receipt_id' name='receipt_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		$savectrl="<input name='receipt_id' value='$this->receipt_id' type='hidden'>".
			 "<input style='height: 40px;' name='btnSave' value='Save' type='button' onclick='iscomplete.value=0;saveRecord();'>";
		$completectrl= "<input style='height: 40px;' name='btnComplete' value='Complete' type='button' onclick='iscomplete.value=1;saveRecord();'>";
		}
		else{
		$deletectrl="";
		$savectrl="";
		$completectrl= "";
		if($this->isAdmin)
		$activatectrl="<FORM action='receipt.php' method='POST' onSubmit='return confirm(".
		'"confirm to reactivate this receipt?"'.")'><input type='submit' value='Reactivate' name='btnActivate'>".
		"<input type='hidden' value='$this->receipt_id' name='receipt_id'>".
		"<input type='hidden' value='reactivate' name='action'><input name='token' value='$token' type='hidden'></form>";
		}

		if($this->batch_id>0)
		$viewbatch="<a href='batch.php?batch_id=$this->batch_id&action=edit'>View Journal</a>";
		else
		$viewbatch="";
	}



    echo <<< EOF
<A href='receipt.php'>[Add New]</A>&nbsp;<A href='receipt.php?action=showSearchForm'>[Search]</A>
<form onsubmit="return validateReceipt()" method="post"
 action="receipt.php" name="frmReceipt">
<table style="width:140px;"><tbody><td><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
$originalamtctrl
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
<tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" colspan='3'>$this->orgctrl $viewbatch </td>
      </tr>
      <tr>
   	<td class="head">Receipt No $mandatorysign</td>
        <td class="even" >
        <input name="receipt_prefix" value="$this->receipt_prefix" size='3' maxlength='10'>
        <input name="receipt_no" value="$this->receipt_no" size='10' maxlength='10'>
			<input name="iscomplete" value="$this->iscomplete" type='hidden'></td>
        <td class="head">Date $mandatorysign</td>
        <td class="even" ><input name='receipt_date' value="$this->receipt_date" id='receipt_date'  size='10' maxlength='10'>
				<input name='btnDate' type='button' value='Date' onclick="$this->showCalendar"></td>

      </tr>
      <tr>
        <td class="head">From Accounts</td>
        <td class="even">$this->accountsfromctrl <select name="bpartner_id" id="bpartner_id" onchange=changePaidFrom(this)> $this->bpartnerctrl</select></div>
			<input name='bpartner_id_bc' id='bpartner_id_bc' type='hidden' value="$this->bpartner_id"></td>
        <td class="head">Paid From $mandatorysign</td>
        <td class="even"><input name='paidfrom' value="$this->paidfrom" id='paidfrom'></td>
      </tr>
      <tr>
        <td class="head">Currency $mandatorysign</td>
        <td class="even"><select name="currency_id">$this->currencyctrl</select></td>
        <td class="head">Exchange Rate $mandatorysign</td>
        <td class="even"><input name='exchangerate' value="$this->exchangerate" onchange='amt.value=parseFloat(this.value*originalamt.value).toFixed(2)' size="10">
	Local Amount :
	<input name='amt' value="$this->amt" readonly='readonly'></td>
      </tr>

      <tr>
        <!--<td class="head">To Accounts /Cheque No $mandatorysign</td>
        <td class="even">$this->accountstoctral <input value="$this->chequeno" name='chequenoa' $this->displaychequenostyle></td>-->
        <td class="head">Received By </td>
        <td class="even" colspan="3"><input name='receivedby' value="$this->receivedby">
		<input name='batch_id' value="$this->batch_id" type='hidden'></td>
      </tr>

    <tr>
        <td class="head">Add Line</td>
	<td class="even" colspan="3">
		<SELECT name='addreceiptlineqty' >
			<OPTION value='0'>0 Line</OPTION>
			<OPTION value='1'>1 Line</OPTION>
			<OPTION value='2'>2 Line</OPTION>
			<OPTION value='3'>3 Line</OPTION>
			<OPTION value='5'>5 Line</OPTION>
			<OPTION value='10'>10 Line</OPTION>
			<OPTION value='15'>15 Line</OPTION>
		</SELECT>
	</td>
      </tr>
	$this->receiptlinectrl

      <tr>
        <td class="head">Description</td>
        <td class="even" colspan='3'><textarea cols='70' name='description' >$this->description</textarea></td>
      </tr>
  <tr>
        <td class="head">Add New Record</td>
        <td class="even" colspan='3'><input type='checkbox' name='chkAddNew'> Add new record immediately after save or complete.</td>
      </tr>
	     <!-- <tr>
        <td class="head">Amount $mandatorysign </td>
        <td class="even" colspan="3">
	<input name='originalamta' value="$this->originalamta" onchange='amt.value=parseFloat(exchangerate.value*this.value).toFixed(2)' >
	</td>
      </tr>-->
    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$savectrl </td><td>$completectrl</td>
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td></tbody>
	</table></form>
	<table style="width:150px;">
	<td>$deletectrl $activatectrl</td><td>$recordctrl</td><td>$previewctrl</td></table>
  <br>



EOF;
  } // end of member function getInputForm

  /**
   * Update existing receipt record
   *
   * @return bool
   * @access public
   */
  public function updateReceipt( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablereceipt SET
	paidfrom='$this->paidfrom',description='$this->description',originalamt=$this->originalamt,amt=$this->amt,
	updated='$timestamp',updatedby=$this->updatedby,iscomplete='$this->iscomplete',exchangerate=$this->exchangerate,
	organization_id=$this->organization_id,accountsfrom_id=$this->accountsfrom_id,
	currency_id=$this->currency_id,receipt_prefix='$this->receipt_prefix',receipt_no='$this->receipt_no',bpartner_id=$this->bpartner_id,
	receipt_date='$this->receipt_date',receivedby='$this->receivedby',
	batch_id=$this->batch_id WHERE receipt_id='$this->receipt_id'";

	$this->log->showLog(3, "Update receipt_id: $this->receipt_id, $this->paidfrom");
	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update receipt failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update receipt successfully.");
		return true;
	}
  } // end of member function updateReceipt

  /**
   * Save new receipt into database
   *
   * @return bool
   * @access public
   */
  public function insertReceipt( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new receipt $this->paidfrom");
 	$sql="INSERT INTO $this->tablereceipt (paidfrom,iscomplete, created,createdby,
	updated,updatedby,exchangerate,organization_id,description,accountsfrom_id,currency_id,
		receipt_no,receipt_prefix,amt,originalamt,bpartner_id,receipt_date,receivedby,batch_id) values(
	'$this->paidfrom','$this->iscomplete','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->exchangerate,$this->organization_id,'$this->description',
	$this->accountsfrom_id,$this->currency_id,'$this->receipt_no','$this->receipt_prefix',$this->amt,$this->originalamt,$this->bpartner_id,
	'$this->receipt_date','$this->receivedby',$this->batch_id)";

	$this->log->showLog(4,"Before insert receipt SQL:$sql");
	$rs=$this->xoopsDB->query($sql);

	if (!$rs){
		$this->log->showLog(1,"Failed to insert receipt code $paidfrom:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new receipt $paidfrom successfully");
		return true;
	}
  } // end of member function insertReceipt

  /**
   * Pull data from receipt table into class
   *
   * @return bool
   * @access public
   */
  public function fetchReceipt( $receipt_id) {


	$this->log->showLog(3,"Fetching receipt detail into class Receipt.php.<br>");

	$sql="SELECT receipt_id,paidfrom,iscomplete,exchangerate,organization_id,description,accountsfrom_id,
		currency_id,amt,originalamt,receipt_no,receipt_prefix,batch_id,receipt_date,receivedby,paidfrom,bpartner_id
		 from $this->tablereceipt where receipt_id=$receipt_id";

	$this->log->showLog(4,"ProductReceipt->fetchReceipt, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->receipt_no=$row["receipt_no"];
		$this->receipt_prefix=$row["receipt_prefix"];
		$this->batch_id=$row["batch_id"];
		$this->organization_id=$row['organization_id'];
		$this->exchangerate= $row['exchangerate'];
		$this->paidfrom=$row['paidfrom'];
		$this->iscomplete=$row['iscomplete'];
		$this->accountsfrom_id=$row['accountsfrom_id'];
		$this->currency_id=$row['currency_id'];
		$this->receipt_date=$row['receipt_date'];
		$this->receivedby=$row['receivedby'];
		$this->amt=$row['amt'];
		$this->originalamt=$row['originalamt'];
		//$this->receipt_no=$row['receipt_no'];
		$this->description=$row['description'];
		$this->bpartner_id=$row['bpartner_id'];
   	$this->log->showLog(4,"Receipt->fetchReceipt,database fetch into class successfully");
	$this->log->showLog(4,"receipt_no:$this->receipt_no");

	$this->log->showLog(4,"iscomplete:$this->iscomplete");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Receipt->fetchReceipt,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchReceipt

  /**
   * Delete particular receipt id
   *
   * @param int receipt_id
   * @return bool
   * @access public
   */
  public function deleteReceipt( $receipt_id ) {
    	$this->log->showLog(2,"Warning: Performing delete receipt id : $receipt_id !");
	$sql="DELETE FROM $this->tablereceipt where receipt_id=$receipt_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");

	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: receipt ($receipt_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"receipt ($receipt_id) removed from database successfully!");
		return true;

	}
  } // end of member function deleteReceipt

  /**
   * Return select sql statement.
   *
   * @param string wherestring
   * @param string orderbystring
   * @param int startlimitno
   * @return string
   * @access public
   */
  public function getSQLStr_AllReceipt( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductReceipt->getSQLStr_AllReceipt: $sql");

    $sql="SELECT f.receipt_prefix,f.receipt_no,f.receipt_id,f.iscomplete,f.organization_id,f.exchangerate,f.paidfrom,
		f.currency_id,p.accounts_name as accountsfrom,
		f.amt,f.originalamt,cr.currency_code,f.receipt_date,f.receivedby
		 FROM $this->tablereceipt  f
		INNER JOIN $this->tableaccounts p on p.accounts_id=f.accountsfrom_id
		INNER JOIN $this->tablecurrency cr on cr.currency_id=f.currency_id
		 $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showreceipttable with sql:$sql");

  return $sql;
  } // end of member function getSQLStr_AllReceipt

 public function showReceiptTable($wherestring,$orderbystring){

	$this->log->showLog(3,"Showing Receipt Table");
	$sql=$this->getSQLStr_AllReceipt($wherestring,$orderbystring);

	$query=$this->xoopsDB->query($sql);
	echo <<< EOF

	<form action="viewreceipt.php" method="POST" name="frmSearchList" target="_blank" >
	<table border='1' cellspacing='3'>
	<input type="hidden" name="action" value="" >
	<input type="hidden" name="receipt_id" value="" >
  		<tbody>
	<tr>
		<th style="text-align:center;">No</th>
		<th style="text-align:center;">Date</th>
		<th style="text-align:center;">Receipt No</th>
		<th style="text-align:center;">Paid From</th>
		<th style="text-align:center;">Account From</th>
		<th style="text-align:center;">Account To</th>
		<th style="text-align:center;">Currency</th>
		<th style="text-align:center;">Amount</th>
		<th style="text-align:center;">Complete</th>
		<th style="text-align:center;">Preview</th>
		<th style="text-align:center;">
		<input type="checkbox" name="checkall" onclick="selectAll(this.checked)">
		</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$receipt_id=$row['receipt_id'];
		$receipt_prefix=$row['receipt_prefix'];
		$receipt_no=$receipt_prefix.$row['receipt_no'];
		$receipt_date=$row['receipt_date'];
		$paidfrom=$row['paidfrom'];
		$accountsfrom=$row['accountsfrom'];
		$accountsto=$row['accountsto'];
		$currency_id=$row['currency_id'];
		$currency_code=$row['currency_code'];
		$amt=$row['amt'];
		$originalamt=$row['originalamt'];
		$exchangerate=$row['exchangerate'];
		$iscomplete=$row['iscomplete'];

		$bpartner_id=$row['bpartner_id'];
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
			<td class="$rowtype" style="text-align:center;">$receipt_date</td>
			<td class="$rowtype" style="text-align:center;">
				<a href='receipt.php?action=edit&receipt_id=$receipt_id'>$receipt_no</a></td>
			<td class="$rowtype" style="text-align:center;">$paidfrom</td>
			<td class="$rowtype" style="text-align:center;">$accountsfrom</td>
			<td class="$rowtype" style="text-align:center;">$accountsto</td>
			<td class="$rowtype" style="text-align:center;">$currency_code</td>
			<td class="$rowtype" style="text-align:center;">$originalamt</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
			<table><tr>
			<td>
			<a href="viewreceipt.php?receipt_id=$receipt_id" target="blank">
			<img src="images/list.gif" title='Preview'>
			</a>
			</td>
			<td>
			<a href="receipt.php?action=edit&receipt_id=$receipt_id">
			<img src="images/edit.gif" name="btnEdit" title='Edit this record'>
			</a>
			</td>
			</tr>
			</table>
			</td>
			<td class="$rowtype" style="text-align:center;">
			<input type="checkbox" name="isselect[$i]">
			<input type="hidden" name="receipt_idarr[$i]" value="$receipt_id">
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";

	if($i > 0){
	echo "<table><tr><td colspan='13' align='right'>
		<input type='button' name='btnPrintAll' value='Print PDF' onclick='printPDF()'>
		</td></tr></table>";
	}

	echo "</form>";
 }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestReceiptID() {
	$sql="SELECT MAX(receipt_id) as receipt_id from $this->tablereceipt;";
	$this->log->showLog(3,'Checking latest created receipt_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created receipt_id:' . $row['receipt_id']);
		return $row['receipt_id'];
	}
	else
	return -1;

  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(exchangerate) + 10 as exchangerate from $this->tablereceipt;";
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

 public function allowDelete($receipt_id){
	$sql="SELECT count(account_id) as rowcount from $this->tableaccounts where receipt_id=$receipt_id";
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
//echo $this->action;
//if($this->action == "search")
//echo $this->iscomplete;

if($this->iscomplete==1)
{$selectiscompletey="SELECTED='SELECTED'";
$selectiscompleten="";
$selectiscompletenull="";
}
elseif($this->iscomplete=="")
{
$selectiscompletey="";
$selectiscompleten="";
$selectiscompletenull="SELECTED='SELECTED'";
}
else
{
$selectiscompletey="";
$selectiscompleten="SELECTED='SELECTED'";
$selectiscompletenull="";
}

echo <<< EOF

<A href='receipt.php'>[Add New]</A>&nbsp;<A href='receipt.php?action=showSearchForm'>[Search]</A>
<FORM name='frmSearchReceipt' method='POST' action='receipt.php'>
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
      <td class='head'>Receipt No From</td>
      <td class='even'><input name='receiptfrom_no' value="$this->receiptfrom_no" size='11' maxlength='11'></td>
      <td class='head'>Receipt No To</td>
      <td class='even'><input name='receiptto_no' value="$this->receiptto_no" size='11' maxlength='11'></td>
    </tr>
    <tr>
      <td class='head'>From Account</td>
      <td class='even' colspan="3">$this->accountsfromctrl</td>
      <!--<td class='head'>To Account</td>
      <td class='even'>$this->accountstoctrl</td>-->
    </tr>
    <tr>
      <td class='head'>Paid From(Ali%, %Ahmad%, Ali%Ahmad)</td>
      <td class='even'><input name='paidfrom' value="$this->paidfrom"></td>
      <td class='head'>Company</td>
      <td class='even'><select name='bpartner_id' id='bpartner_id'>$this->bpartnerctrl</select></td>
    </tr>
    <tr>
      <td class='head'>Currency</td>
      <td class='even'><select id="currency_id" name="currency_id">$this->currencyctrl</select></td>
      <td class='head'>Received By (Ali%, %Ahmad%, Ali%Ahmad)</td>
      <td class='even'><input name='receivedby' value="$this->receivedby"></td>
    </tr>
    <tr>
      <td class='head'>Is Complete</td>
      <td class='even' colspan="3"><SELECT name='iscomplete'>
	<option value='' $selectiscompletenull>Null</option>
	<option value='1' $selectiscompletey>Y</option>
	<option value='0'$selectiscompleten>N</option></SELECT></td>
      <!--<td class='head'>Cheque No</td>
      <td class='even'><input name='chequeno' value="$this->chequeno"></td>-->
    </tr>
  </tbody>
</table>
<INPUT type='submit' NAME='btnSearch' value='Search'>
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

	$wherestring=" and f.receipt_date between '$this->datefrom' and '$this->dateto' AND";

	if($this->receiptfrom_no!="")
		$wherestring=$wherestring. " f.receipt_no >= '$this->receiptfrom_no' AND";

	if($this->receiptto_no!="")
		$wherestring=$wherestring. " f.receipt_no <= '$this->receiptto_no' AND";

	if($this->iscomplete !="-1" && $this->iscomplete !="")
		$wherestring=$wherestring. " f.iscomplete = $this->iscomplete AND";

	if($this->accountsfrom_id!=0)
		$wherestring=$wherestring. " f.accountsfrom_id = $this->accountsfrom_id AND";

	/*
	if($this->accountsto_id!=0)
		$wherestring=$wherestring. " f.accountsto_id = $this->accountsto_id AND";
	*/

	if($this->currency_id!=0)
		$wherestring=$wherestring. " f.currency_id = $this->currency_id AND";


	if($this->bpartner_id!=0)
		$wherestring=$wherestring. " f.bpartner_id = $this->bpartner_id AND";

	if($this->paidfrom!="")
		$wherestring=$wherestring. " f.paidfrom LIKE '$this->paidfrom' AND";

	if($this->receivedby!="")
		$wherestring=$wherestring. " f.receivedby LIKE '$this->receivedby' AND";

	if($this->chequeno!="")
		$wherestring=$wherestring. " f.chequeno =$this->chequeno AND";


	$wherestring=substr_replace($wherestring,"",-3);
	$this->log->showLog(3,"generate wherestring: $wherestring");
	return $wherestring;

}

	public function getArrayPOST($receipt_id){
	global $prefix_rcpt;

	$sql = "select *
		from $this->tablereceipt a, $this->tablereceiptline b
		where a.receipt_id = b.receipt_id
		and a.receipt_id = $receipt_id
		and b.amt > 0 ";

	$this->log->showLog(4,"Get Array Post Value: $sql");

	$query=$this->xoopsDB->query($sql);
	$return_false = 0;
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){

	if($row['receipt_prefix']!="")
	$row['receipt_no'] = $row['receipt_prefix']."".$row['receipt_no'];

	$documentno = $row['receipt_no'];
	$date = $row['receipt_date'];
	$systemname = 'Simbiz';
	$totaltransactionamt = $row['originalamt'];
	$batch_name = "Post from Simbiz Official Receipt ".$row['receipt_no'];

	$description = $row['description'];


	if($i==0){//header

		$documentnoarray[$i] = $documentno;
		$amtarray[$i] = $row['originalamt']*-1;

		$accountsarray[$i] = $row['accountsfrom_id'];
		$currencyarray[$i] = $row["currency_id"];
		$conversionarray[$i] = $row["exchangerate"];
		$originalamtarray[$i] = $row['originalamt'];
		$bpartnerarray[$i] = $row["bpartner_id"];
		$transtypearray[$i] = "";
		$linetypearray[$i] = 0;
		$chequenoarray[$i] = "";

		if($row['accountsfrom_id'] == 0)//return false if account id = 0
		$return_false = 1;
	$i++;
	}

	// line

		$documentnoarray[$i] = $documentno;
		$accountsarray[$i] = $row['accounts_id'];
		$originalamtarray[$i] = $row['originalamt'];
		$currencyarray[$i] = $row["currency_id"];
		$conversionarray[$i] = $row["exchangerate"];
		$amtarray[$i] = $row['amt'];
		$bpartnerarray[$i] = 0;
		$transtypearray[$i] = "";
		$linetypearray[$i] = 1;
		$chequenoarray[$i] = $row["chequeno"];
		$linedescarray[$i] = $row["subject"];

		if($row['accounts_id'] == 0)//return false if account id = 0
		$return_false = 1;
	$i++;

	}

	return array($date,$systemname,$batch_name,$description,$totaltransactionamt,$documentnoarray,
	$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,$transtypearray,$linetypearray,
	$chequenoarray,$return_false,$linedescarray);

	}


public function showJavascript(){

    echo <<< EOF
<script type="text/javascript">

	function printPDF(){
		var i = 0;
		var checkedbtn = 0;
		while(i< document.forms['frmSearchList'].elements.length){
		var ctlname = document.forms['frmSearchList'].elements[i].name;
		var data = document.forms['frmSearchList'].elements[i].checked;



		if(ctlname.substring(0,8)=="isselect"){

			if(data == true){
			//var salesinvoice_id = document.forms['frmSearchList'].elements[i+1].value;
			//window.open("viewsalesinvoice.php?salesinvoice_id="+salesinvoice_id);
			checkedbtn = 1;
			}

		}
		i++;
		}

		if(checkedbtn == 0){
		alert("Please Select Invoice.");
		return false;
		}else{
		document.forms['frmSearchList'].submit();
		}
	}

	function selectAll(val){

		var i = 0;
		while(i< document.forms['frmSearchList'].elements.length){
		var ctlname = document.forms['frmSearchList'].elements[i].name;

		if(ctlname.substring(0,8)=="isselect"){

		document.forms['frmSearchList'].elements[i].checked = val;

		}
		i++;
		}
	}

	function saveRecord(){

	if(validateReceipt())
	document.forms['frmReceipt'].submit();

	}

	function calculateSummary(){
	var exchangerate = document.forms['frmReceipt'].exchangerate.value;

	var i=0;
	var total_amt = 0;
	while(i< document.forms['frmReceipt'].elements.length){
		var ctlname = document.forms['frmReceipt'].elements[i].name;
		var data = document.forms['frmReceipt'].elements[i].value;

		if(ctlname.substring(0,7)=="lineamt"){
		total_amt = parseFloat(total_amt) + parseFloat(data);

		}

		i++;

	}

	document.forms['frmReceipt'].originalamt.value = parseFloat(total_amt).toFixed(2);
	document.forms['frmReceipt'].amt.value = parseFloat(parseFloat(exchangerate)*parseFloat(total_amt)).toFixed(2);
	}

	function validateAmount(){

	var i=0;
	while(i< document.forms['frmReceipt'].elements.length){
		var ctlname = document.forms['frmReceipt'].elements[i].name;
		var data = document.forms['frmReceipt'].elements[i].value;

		if(ctlname.substring(0,7)=="lineamt"){

			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmReceipt'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmReceipt'].elements[i].focus();
					return false;
				}
				else
				document.forms['frmReceipt'].elements[i].style.backgroundColor = "#FFFFFF";


		}

		i++;

	}
	return true;
	}

	function showHideDesc(i){
	var descctrl=document.getElementById("linedescription"+i);
	if(descctrl.style.display=="none")
		descctrl.style.display="";
	else
		descctrl.style.display="none";

	}
	function autofocus(){
	document.frmReceipt.receipt_date.focus();
	document.frmReceipt.receipt_date.select();
	}


	function validateReceipt(){

	/*	var documentno=document.forms['frmReceipt'].receipt_no.value;
		var paidfrom=document.forms['frmReceipt'].paidfrom.value;
		var exchangerate=document.forms['frmReceipt'].exchangerate.value;
		var divbpartner =document.getElementById("divbpartner");
		var bpartnerctrl = document.getElementById("bpartner_id2") ? document.getElementById("bpartner_id2") : false;

		if(bpartnerctrl==false)
			alert('no bpartner');
		else
			alert('have bpartner');
*/
		var documentno=document.forms['frmReceipt'].receipt_no.value;
		var paidfrom=document.forms['frmReceipt'].paidfrom.value;
		var exchangerate=document.forms['frmReceipt'].exchangerate.value;
		var accountsfrom=document.forms['frmReceipt'].accountsfrom_id.value;
		//var bpartner_id2=document.forms['frmReceipt'].bpartner_id2.value;
		//var accountsto=document.forms['frmReceipt'].accountsto_id.value;
		var originalamt=document.forms['frmReceipt'].originalamt.value;

		if(confirm("Save record?")){

		if(documentno=="" || accountsfrom==0){
		alert("Please make sure Receipt No, From Accounts is filled in.");
		return false;
		}else{

			if(!IsNumeric(exchangerate) || !IsNumeric(originalamt)){
			alert("Please make sure Exchange Rate and Amount filled in with numeric.");
			return false;
			}else{
			var receipt_date=document.forms['frmReceipt'].receipt_date.value;
			if(!isDate(receipt_date)){
			return false;
			}else{

			if(validateAmount())
			return true;
			else
			return false;
			}
			}
		}

		}else
			return false;
	}

function reloadAccountFrom(accounts_id){

	 var data="action="+"getaccountinfo"+
                    "&accounts_id="+accounts_id;

            $.ajax({
                 url:"receipt.php",type: "POST",data: data,cache: false,
                     success: function (xml)
                     {
                        $("#bpartner_id").html(xml);
                     }
                   });



	}

	function reloadAccountTo(accounts_id,line){
	 var data="action="+"checkisbank"+
                    "&accounts_id="+accounts_id;

            $.ajax({
                 url:"receipt.php",type: "POST",data: data,cache: false,
                     success: function (xml)
                     {
                      if(xml==1)
                     document.getElementById("linechequeno"+line).style.display="";
                      else
                     document.getElementById("linechequeno"+line).style.display="none";
                     }
                   });

	}




	function refreshCurrency(currency_id){

	var arr_fld=new Array("action","currency_id");//name for POST
	var arr_val=new Array("refreshcurrency",currency_id);//value for POST

	getRequest(arr_fld,arr_val);


	}

	function changePaidFrom(ctrl){

		try {
		var selected_text =ctrl.options[ctrl.selectedIndex].text;
		document.forms['frmReceipt'].paidfrom.value=selected_text;
		document.forms['frmReceipt'].bpartner_id.value=ctrl.value;
		}catch (error) {
		document.forms['frmReceipt'].paidfrom.value="";
		}

	}
</script>

EOF;
}
} // end of ClassReceipt

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
	global $tablepaymentvoucherline;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tableaccounts=$tableaccounts;
	$this->tablecurrency=$tablecurrency;
	$this->tablepaymentvoucher=$tablepaymentvoucher;
	$this->tablepaymentvoucherline=$tablepaymentvoucherline;
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
      global $prefix_pv;
      
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	$originalamtctrl="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New PaymentVoucher";
		$action="create";
	 	
		if($paymentvoucher_id==0){
			$this->paidto="";
			$this->iscomplete="";
			$this->exchangerate=1;
			$this->amt=0;
			$this->displaychequenostyle="style='display:none'";
			//$this->paymentvoucher_date=date('Y-m-d',time());
			$this->paymentvoucher_date= getDateSession();
			$this->paymentvoucher_type= "B";
			$this->batch_id=0;
			$this->paymentvoucher_no=getNewCode($this->xoopsDB,"paymentvoucher_no",$this->tablepaymentvoucher," and paymentvoucher_type = '$this->paymentvoucher_type' ");
			$this->originalamt=0;
			$this->iscomplete=0;
                        $this->paymentvoucher_prefix=$prefix_pv;


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
		"<input name='tablename' value='$this->tablepaymentvoucher' type='hidden'>".
		"<input name='id' value='$this->paymentvoucher_id' type='hidden'>".
		"<input name='idname' value='paymentvoucher_id' type='hidden'>".
		"<input name='title' value='Financial Year' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		}

		$previewctrl="<form target='_blank' action='viewpaymentvoucher.php' method='GET'>".
		"<input name='paymentvoucher_id' value='$this->paymentvoucher_id' type='hidden'>".
		"<input name='btnPreview' value='Print Preview' type='submit'>".
		"</form>";
		
	
		$header="Edit PaymentVoucher";
		
		if($this->iscomplete==0){
		$deletectrl="<FORM action='paymentvoucher.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this paymentvoucher?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->paymentvoucher_id' name='paymentvoucher_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		$savectrl="<input name='paymentvoucher_id' value='$this->paymentvoucher_id' type='hidden'>".
			 "<input style='height: 40px;' name='btnSave' value='Save' type='button' onclick='iscomplete.value=0;saveRecord();'>";
		$completectrl= "<input style='height: 40px;' name='btnComplete' value='Complete' type='button' onclick='iscomplete.value=1;saveRecord();'>";
		}
		else{
		$deletectrl="";
		$savectrl="";
		$completectrl= "";
		if($this->isAdmin)
		$activatectrl="<FORM action='paymentvoucher.php' method='POST' onSubmit='return confirm(".
		'"confirm to reactivate this paymentvoucher?"'.")'><input type='submit' value='Reactivate' name='btnActivate'>".
		"<input type='hidden' value='$this->paymentvoucher_id' name='paymentvoucher_id'>".
		"<input type='hidden' value='reactivate' name='action'><input name='token' value='$token' type='hidden'></form>";
		}
               $navigationctrl= $this->navigationRecord($this->paymentvoucher_id,$this->paymentvoucher_date,$this->paymentvoucher_no);
		if($this->batch_id>0)
		$viewbatch="<a href='batch.php?batch_id=$this->batch_id&action=edit'>View Journal</a>";
		else
		$viewbatch="";
	}

	$selectedCash="";
	$selectedbank="";
	if($this->paymentvoucher_type=="B")
	$selectedBank = "SELECTED";
	else
	$selectedCash = "SELECTED";

	
/*if($this->bpartner_id == 0)
$bpartner_fld = "<input type='hidden' name='bpartner_id' value='0'>";
*/

    echo <<< EOF
<A href='paymentvoucher.php'>[Add New]</A>&nbsp;<A href='paymentvoucher.php?action=showSearchForm'>[Search]</A>
<form onsubmit="return validatePaymentVoucher()" method="post"
 action="paymentvoucher.php" name="frmPaymentVoucher">
<table style="width:140px;"><tbody><td><input name="reset" value="Reset" type="reset"></td></tbody></table>
<div id="bpartnerID">$bpartner_fld</div>
  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">

$originalamtctrl
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
<tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" acolspan='3'>$this->orgctrl $viewbatch </td>
	<td class="head">PaymentVoucher No $mandatorysign</td>
        <td class="even" >
<input name="paymentvoucher_prefix" value="$this->paymentvoucher_prefix" size='3' maxlength='10'>
<input name="paymentvoucher_no" value="$this->paymentvoucher_no" size='10' maxlength='10'>
			<input name="iscomplete" value="$this->iscomplete" type='hidden'></td>

      </tr>
      <tr>
   	<td class="head">PaymentVoucher Type</td>
        <td class="even" >
		<select name="paymentvoucher_type" onchange="getTypeNo(this.value)">
		<option value="B" $selectedBank>Bank</option>
		<option value="C" $selectedCash>Cash</option>
		</select>
		</td>
        <td class="head">Date $mandatorysign</td>
        <td class="even" ><input name='paymentvoucher_date' value="$this->paymentvoucher_date" id='paymentvoucher_date'  size='10' maxlength='10'>
				<input name='btnDate' type='button' value='Date' onclick="$this->showCalendar"></td>

      </tr>
      <tr>
        <!--<td class="head">From Accounts</td>
        <td class="even">$this->accountsfromctrl <div id='divbpartnera'> $this->bpartnerctrl</div> 
			<input name='bpartner_id_bca' id='bpartner_id_bca' type='hidden' value="$this->bpartner_id"></td>-->
        <td class="head">Paid To $mandatorysign</td>
        <td class="even" colspan="3"><input name='paidto' value="$this->paidto" id='paidto'></td>
      </tr>
      <tr>
        <td class="head">Currency $mandatorysign</td>
        <td class="even"><select name='currency_id' id='currency_id'>$this->currencyctrl</select></td>
        <td class="head">Exchange Rate $mandatorysign</td>
        <td class="even"><input name='exchangerate' value="$this->exchangerate" onchange='amt.value=parseFloat(this.value*originalamt.value).toFixed(2)' size="10">
	Local Amount : 
	<input name='amt' value="$this->amt" readonly='readonly'></td>
      </tr>

      <tr>
   <td class="head">From Accounts</td>
        <td class="even">$this->accountsfromctrl <input value="$this->chequeno" name='chequeno' $this->displaychequenostyle>
		</td>
        <td class="head">Prepared By</td>
        <td class="even"><input name='preparedby' value="$this->preparedby">
	<input name='batch_id' value="$this->batch_id" type='hidden'></td>
      </tr>

    <tr>
        <td class="head">Add Line</td>
	<td class="even" colspan="3">
		<SELECT name='addpaymentvoucherlineqty' >
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
	$this->paymentvoucherlinectrl

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
$navigationctrl


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
	organization_id=$this->organization_id,accountsfrom_id=$this->accountsfrom_id,
	currency_id=$this->currency_id,paymentvoucher_prefix='$this->paymentvoucher_prefix',paymentvoucher_no='$this->paymentvoucher_no',chequeno='$this->chequeno',
	paymentvoucher_date='$this->paymentvoucher_date',paymentvoucher_type='$this->paymentvoucher_type',preparedby='$this->preparedby',
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
	updated,updatedby,exchangerate,organization_id,description,accountsfrom_id,currency_id,
		paymentvoucher_no,paymentvoucher_prefix,chequeno,amt,originalamt,paymentvoucher_date,paymentvoucher_type,preparedby,batch_id) values(
	'$this->paidto','$this->iscomplete','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->exchangerate,$this->organization_id,'$this->description',
	$this->accountsfrom_id,$this->currency_id,'$this->paymentvoucher_no','$this->paymentvoucher_prefix','$this->chequeno',$this->amt,$this->originalamt,
	'$this->paymentvoucher_date','$this->paymentvoucher_type','$this->preparedby',$this->batch_id)";

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
		
	$sql="SELECT paymentvoucher_id,paidto,iscomplete,exchangerate,organization_id,description,accountsfrom_id,
		currency_id,amt,originalamt,paymentvoucher_no,paymentvoucher_prefix,chequeno,batch_id,paymentvoucher_date,paymentvoucher_type,preparedby,paidto
		 from $this->tablepaymentvoucher where paymentvoucher_id=$paymentvoucher_id";
	
	$this->log->showLog(4,"ProductPaymentVoucher->fetchPaymentVoucher, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->paymentvoucher_no=$row["paymentvoucher_no"];
                $this->paymentvoucher_prefix=$row["paymentvoucher_prefix"];
		$this->chequeno=$row["chequeno"];
		$this->batch_id=$row["batch_id"];
		$this->organization_id=$row['organization_id'];
		$this->exchangerate= $row['exchangerate'];
		$this->paidto=$row['paidto'];
		$this->iscomplete=$row['iscomplete'];
		$this->accountsfrom_id=$row['accountsfrom_id'];
		$this->currency_id=$row['currency_id'];
		$this->paymentvoucher_date=$row['paymentvoucher_date'];
		$this->paymentvoucher_type=$row['paymentvoucher_type'];
		$this->preparedby=$row['preparedby'];
		$this->amt=$row['amt'];
		$this->originalamt=$row['originalamt'];
		$this->description=$row['description'];

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

    $sql="SELECT f.paymentvoucher_prefix,f.paymentvoucher_no,f.chequeno,f.paymentvoucher_id,f.iscomplete,f.organization_id,f.exchangerate,f.paidto,
		f.currency_id,p.accounts_name as accountsfrom,
		f.amt,f.originalamt,cr.currency_code,f.paymentvoucher_date,f.paymentvoucher_type,f.preparedby
		 FROM $this->tablepaymentvoucher  f
		INNER JOIN $this->tableaccounts p on p.accounts_id=f.accountsfrom_id
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
				<th style="text-align:center;">Type</th>
				<th style="text-align:center;">PaymentVoucher No</th>
				<th style="text-align:center;">Paid To</th>
				<th style="text-align:center;">Account From</th>
				
				<th style="text-align:center;">Currency</th>
				<th style="text-align:center;">Amount</th>
				<th style="text-align:center;">IsComplete</th>
				<th style="text-align:center;">Preview</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$paymentvoucher_id=$row['paymentvoucher_id'];
		$paymentvoucher_prefix=$row['paymentvoucher_prefix'];
		$paymentvoucher_no=$paymentvoucher_prefix.$row['paymentvoucher_no'];
		$chequeno=$row['chequeno'];
		$paymentvoucher_date=$row['paymentvoucher_date'];
		$paymentvoucher_type=$row['paymentvoucher_type'];
		$paidto=$row['paidto'];
		$accountsfrom=$row['accountsfrom'];
		$accountsto=$row['accountsto'];
		$currency_id=$row['currency_id'];
		$currency_code=$row['currency_code'];
		$amt=$row['amt'];
		$originalamt=$row['originalamt'];
		$exchangerate=$row['exchangerate'];
		$iscomplete=$row['iscomplete'];


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

		if($paymentvoucher_type=="B")
		$paymentvoucher_type="Bank";
		else
		$paymentvoucher_type="Cash";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$paymentvoucher_date</td>
			<td class="$rowtype" style="text-align:center;">$paymentvoucher_type</td>
			<td class="$rowtype" style="text-align:center;">
				<a href='paymentvoucher.php?action=edit&paymentvoucher_id=$paymentvoucher_id'>$paymentvoucher_no</a></td>
			<td class="$rowtype" style="text-align:center;">$paidto</td>
			<td class="$rowtype" style="text-align:center;">$accountsfrom</td>

			<td class="$rowtype" style="text-align:center;">$currency_code</td>
			<td class="$rowtype" style="text-align:center;">$originalamt</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
			<table><tr>
			<td>
				<A href='viewpaymentvoucher.php?paymentvoucher_id=$paymentvoucher_id'  target="_blank">
				<img src="images/list.gif" title='Preview'></a>
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
elseif($this->iscomplete=="0")
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

$selectedtypeNull="";
$selectedtypeBank="";
$selectedtypeCash="";
if($this->paymentvoucher_type=="B"){
$selectedtypeNull="";
$selectedtypeBank="selected";
$selectedtypeCash="";
}else if($this->paymentvoucher_type=="C"){
$selectedtypeNull="";
$selectedtypeBank="";
$selectedtypeCash="selected";
}else{
$selectedtypeNull="selected";
$selectedtypeBank="";
$selectedtypeCash="";
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
      <td class='head'>PaymentVoucher No From</td>
      <td class='even'><input name='paymentvoucherfrom_no' value="$this->paymentvoucherfrom_no" size='11' maxlength='11'></td>
      <td class='head'>PaymentVoucher No To</td>
      <td class='even'><input name='paymentvoucherto_no' value="$this->paymentvoucherto_no" size='11' maxlength='11'></td>
    </tr>
    <tr>
      <td class='head'>From Account</td>
      <td class='even'>$this->accountsfromctrl</td>

      <td class='head'>Paid To(Ali%, %Ahmad%, Ali%Ahmad)</td>
      <td class='even'><input name='paidto' value="$this->paidto"></td>
    </tr>
    <tr>
      <td class='head'>Currency</td>
      <td class='even'><select name="currency_id">$this->currencyctrl</select></td>
      <td class='head'>Prepared By (Ali%, %Ahmad%, Ali%Ahmad)</td>
      <td class='even'><input name='preparedby' value="$this->preparedby"></td>
    </tr>
    <tr>
      <td class='head'>Payment Type</td>
      <td class='even'><SELECT name='paymentvoucher_type'>
	<option value='' $selectedtypeNull>Null</option>
	<option value='B' $selectedtypeBank>Bank</option>
	<option value='C' $selectedtypeCash>Cash</option></SELECT></td>
      <td class='head'>Cheque No</td>
      <td class='even'><input name='chequeno' value="$this->chequeno"></td>
    </tr>
    <tr>
      <td class='head'>Is Complete</td>
      <td class='even' colspan="3"><SELECT name='iscomplete'>
	<option value='-1' $selectiscompletenull>Null</option>
	<option value='1' $selectiscompletey>Y</option>
	<option value='0'$selectiscompleten>N</option></SELECT></td>
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

	$wherestring=" and f.paymentvoucher_date between '$this->datefrom' and '$this->dateto' AND";

	if($this->paymentvoucherfrom_no!="")
		$wherestring=$wherestring. " f.paymentvoucher_no >= '$this->paymentvoucherfrom_no' AND";

	if($this->paymentvoucher_type!="")
		$wherestring=$wherestring. " f.paymentvoucher_type >= '$this->paymentvoucher_type' AND";

	if($this->paymentvoucherto_no!="")
		$wherestring=$wherestring. " f.paymentvoucher_no <= '$this->paymentvoucherto_no' AND";

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


	if($this->paidto!="")
		$wherestring=$wherestring. " f.paidto LIKE '$this->paidto' AND";

	if($this->preparedby!="")
		$wherestring=$wherestring. " f.preparedby LIKE '$this->preparedby' AND";

	if($this->chequeno!="")
		$wherestring=$wherestring. " f.chequeno =$this->chequeno AND";


	$wherestring=substr_replace($wherestring,"",-3);
	$this->log->showLog(3,"generate wherestring: $wherestring");
	return $wherestring;

}

	public function getArrayPOST($paymentvoucher_id){
	global $prefix_pv;

	$sql = "select * 
		from $this->tablepaymentvoucher a, $this->tablepaymentvoucherline b 
		where a.paymentvoucher_id = b.paymentvoucher_id 
		and a.paymentvoucher_id = $paymentvoucher_id 
		and b.amt > 0 ";

	$this->log->showLog(4,"Get Array Post Value: $sql");
	
	$query=$this->xoopsDB->query($sql);
	$return_false = 0;
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	
	if($row['paymentvoucher_prefix']!="")
	$row['paymentvoucher_no'] = $row['paymentvoucher_prefix']."".$row['paymentvoucher_no'];

	$documentnoarray[$i] = $row['paymentvoucher_no'];
	$date = $row['paymentvoucher_date'];
	$systemname = 'Simbiz';
        $paidto=$row['paidto'];
	$totaltransactionamt = $row['originalamt'];
	$batch_name = $row['paymentvoucher_no']." ($paidto)";
	$description = $row['description'];
        
	if($i==0){//header

		$amtarray[$i] = $row['originalamt']*-1;

		$accountsarray[$i] = $row['accountsfrom_id'];
		$currencyarray[$i] = $row["currency_id"];
		$conversionarray[$i] = $row["exchangerate"];
		$originalamtarray[$i] = $row['originalamt'];
		$bpartnerarray[$i] = 0;
		$transtypearray[$i] = "";
		$linetypearray[$i] = 0;
		$chequenoarray[$i] = $row['chequeno'];
                $linedescarray[$i]=$paidto;
		if($row['accountsfrom_id'] == 0)//return false if account id = 0
		$return_false = 1;
	$i++;
	}

	// line
		$documentnoarray[$i] = $row['paymentvoucher_no'];
		$accountsarray[$i] = $row['accounts_id'];
		$originalamtarray[$i] = $row['originalamt'];
		$currencyarray[$i] = $row["currency_id"];
		$conversionarray[$i] = $row["exchangerate"];
		$amtarray[$i] = $row['amt'];
		$bpartnerarray[$i] = $row['bpartner_id'];
		$transtypearray[$i] = "";
		$linetypearray[$i] = 1;
		$chequenoarray[$i] = "";
		$linedescarray[$i] = $row["subject"];

		if($row['accounts_id'] == 0)//return false if account id = 0
		$return_false = 1;
	$i++;

	}

	return array($date,$systemname,$batch_name,$description,$totaltransactionamt,$documentnoarray,
	$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,$transtypearray,$linetypearray,
	$chequenoarray,$return_false,$linedescarray);
	
	}

	public function getTypeNo($paymentvoucher_type){

 	$retval = getNewCode($this->xoopsDB,"paymentvoucher_no",$this->tablepaymentvoucher," and paymentvoucher_type = '$paymentvoucher_type' ");
	return $retval;
	}


public function navigationRecord($paymentvoucher_id,$paymentvoucher_date,$paymentvoucher_no){

global $defaultorganization_id;
 $sqlfirst="SELECT paymentvoucher_id FROM 
            $this->tablepaymentvoucher p
            where organization_id=$defaultorganization_id
            ORDER BY paymentvoucher_date ASC, paymentvoucher_no ASC LIMIT 0,1";
 $sqlprev="SELECT paymentvoucher_id FROM
            $this->tablepaymentvoucher p
            where organization_id=$defaultorganization_id
            AND paymentvoucher_date<='$paymentvoucher_date' 
            AND  paymentvoucher_no <= (case when paymentvoucher_date = '$paymentvoucher_date' then '$paymentvoucher_no' else 'ZZZZZZZZZZ' end) 
            and paymentvoucher_id <>$paymentvoucher_id
            ORDER BY paymentvoucher_date DESC, paymentvoucher_no DESC LIMIT 0,1";
$sqlnext="SELECT paymentvoucher_id FROM
            $this->tablepaymentvoucher p
            where organization_id=$defaultorganization_id
            AND paymentvoucher_date>='$paymentvoucher_date' AND paymentvoucher_no >=(case when paymentvoucher_date = '$paymentvoucher_date' then '$paymentvoucher_no' else '000000000' end)  and paymentvoucher_id <>$paymentvoucher_id
            ORDER BY paymentvoucher_date ASC, paymentvoucher_no ASC LIMIT 0,1";
$sqllast="SELECT paymentvoucher_id FROM
            $this->tablepaymentvoucher p
            where organization_id=$defaultorganization_id
            ORDER BY paymentvoucher_date DESC, paymentvoucher_no DESC LIMIT 0,1";
  $sqlall="SELECT ($sqlfirst) as firstid,($sqlprev) as previd,($sqlnext) as nextid,($sqllast) as lastid FROM DUAL";
$this->log->showLog(4,"show navigationRecord($paymentvoucher_id,$paymentvoucher_date,$paymentvoucher_no) with sql: $sqlall");
$queryall=$this->xoopsDB->query($sqlall);
$row=$this->xoopsDB->fetchArray($queryall);
$firstid=$row['firstid'];
$previd=$row['previd'];
$nextid=$row['nextid'];
$lastid=$row['lastid'];

if($firstid!=$paymentvoucher_id)
$firstrecord="<a href='paymentvoucher.php?action=edit&paymentvoucher_id=$firstid'> &#60;&#60;First </a>";
else
$firstrecord="&#60;&#60;First ";

if($previd!="")
$prevrecord="<a href='paymentvoucher.php?action=edit&paymentvoucher_id=$previd'> &#60;Prev </a>";
else
$prevrecord=" &#60;Prev ";

if($nextid!="")
$nextrecord="<a href='paymentvoucher.php?action=edit&paymentvoucher_id=$nextid'> Next&#62; </a>";
else
$nextrecord=" Next&#62; ";

if($lastid!=$batch_id)
$lastrecord="<a href='paymentvoucher.php?action=edit&paymentvoucher_id=$lastid'> Last&#62;&#62; </a>";
else
$lastrecord=" Last&#62;&#62; ";

return "$firstrecord &nbsp;&nbsp;&nbsp; $prevrecord &nbsp;&nbsp;&nbsp;
        $nextrecord &nbsp;&nbsp;&nbsp; $lastrecord";
}


public function showJavascript(){

    echo <<< EOF
<script type="text/javascript">

	function getTypeNo(paymentvoucher_type){

	var arr_fld=new Array("action","paymentvoucher_type");//name for POST
	var arr_val=new Array("gettypeno",paymentvoucher_type);//value for POST

	getRequest(arr_fld,arr_val);
	}

	function saveRecord(){

	if(validatePaymentVoucher())
	document.forms['frmPaymentVoucher'].submit();

	}

	function calculateSummary(){
	var exchangerate = document.forms['frmPaymentVoucher'].exchangerate.value;

	var i=0;
	var total_amt = 0;
	while(i< document.forms['frmPaymentVoucher'].elements.length){
		var ctlname = document.forms['frmPaymentVoucher'].elements[i].name;
		var data = document.forms['frmPaymentVoucher'].elements[i].value;

		if(ctlname.substring(0,7)=="lineamt"){
		total_amt = parseFloat(total_amt) + parseFloat(data);

		}

		i++;

	}

	document.forms['frmPaymentVoucher'].originalamt.value = parseFloat(total_amt).toFixed(2);
	document.forms['frmPaymentVoucher'].amt.value = parseFloat(parseFloat(exchangerate)*parseFloat(total_amt)).toFixed(2);
	}

	function validateAmount(){

	var i=0;
	while(i< document.forms['frmPaymentVoucher'].elements.length){
		var ctlname = document.forms['frmPaymentVoucher'].elements[i].name;
		var data = document.forms['frmPaymentVoucher'].elements[i].value;

		if(ctlname.substring(0,7)=="lineamt"){

			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmPaymentVoucher'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmPaymentVoucher'].elements[i].focus();
					return false;
				}
				else
				document.forms['frmPaymentVoucher'].elements[i].style.backgroundColor = "#FFFFFF";


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
	document.frmPaymentVoucher.paymentvoucher_date.focus();
	document.frmPaymentVoucher.paymentvoucher_date.select();
	}


	function validatePaymentVoucher(){

	/*	var documentno=document.forms['frmPaymentVoucher'].paymentvoucher_no.value;
		var paidto=document.forms['frmPaymentVoucher'].paidto.value;
		var exchangerate=document.forms['frmPaymentVoucher'].exchangerate.value;
		var divbpartner =document.getElementById("divbpartner");
		var bpartnerctrl = document.getElementById("bpartner_id2") ? document.getElementById("bpartner_id2") : false;

		if(bpartnerctrl==false)
			alert('no bpartner');
		else
			alert('have bpartner');
*/
		var documentno=document.forms['frmPaymentVoucher'].paymentvoucher_no.value;
		var paidto=document.forms['frmPaymentVoucher'].paidto.value;
		var exchangerate=document.forms['frmPaymentVoucher'].exchangerate.value;
		var accountsfrom=document.forms['frmPaymentVoucher'].accountsfrom_id.value;
		//var bpartner_id2=document.forms['frmPaymentVoucher'].bpartner_id2.value;
		//var accountsto=document.forms['frmPaymentVoucher'].accountsto_id.value;
		var originalamt=document.forms['frmPaymentVoucher'].originalamt.value;

		if(confirm("Save record?")){

		if(documentno=="" || accountsfrom==0){
		alert("Please make sure PaymentVoucher No, From Accounts is filled in.");
		return false;
		}else{

			if(!IsNumeric(exchangerate) || !IsNumeric(originalamt)){
			alert("Please make sure Exchange Rate and Amount filled in with numeric.");
			return false;
			}else{
			var paymentvoucher_date=document.forms['frmPaymentVoucher'].paymentvoucher_date.value;
			if(!isDate(paymentvoucher_date)){
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

	var arr_fld=new Array("action","accounts_id");//name for POST
	var arr_val=new Array("refreshaccountsfrom",accounts_id);//value for POST

	getRequest(arr_fld,arr_val);

	}
	function reloadAccountTo(accounts_id,line){

	 var data="action="+"getaccountinfo"+
                    "&accounts_id="+accounts_id;

            $.ajax({
                 url:"paymentvoucher.php",type: "POST",data: data,cache: false,
                     success: function (xml)
                     {
                        $("#linebpartner_id"+line).html(xml);
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
		document.forms['frmPaymentVoucher'].paidto.value=selected_text;
		document.forms['frmPaymentVoucher'].bpartner_id.value=ctrl.value;
		}catch (error) {
		document.forms['frmPaymentVoucher'].paidto.value="";
		}

	}

	function changePaidTo(ctrl){
		try {
		var selected_text =ctrl.options[ctrl.selectedIndex].text;
		document.forms['frmPaymentVoucher'].paidto.value=selected_text;
		//document.forms['frmPaymentVoucher'].bpartner_id.value=ctrl.value;
		}catch (error) {
		document.forms['frmPaymentVoucher'].paidto.value="";
		}


	}
</script>

EOF;
}
} // end of ClassPaymentVoucher
?>

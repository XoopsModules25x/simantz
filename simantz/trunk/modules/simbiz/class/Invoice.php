<?php


class Invoice
{

  public $invoice_id;
  public $invoice_no;
  public $document_date;

  public $totalpcs;
  public $organization_id;
  public $daycount;
  public $machine_id;


  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $machinectrl;

  public $invoicelinectrl;
  private $xoopsDB;
  private $tableprefix;
  private $tableinvoice;
  private $tableproduct;
  private $defaultorganization_id;
  private $tablesawmillmachine;
  private $log;


//constructor
   public function Invoice(){
	global $xoopsDB,$log,$tableinvoice,$tableproduct,$defaultorganization_id,$tableaccounts,$tablecurrency,
			$tablebpartner,$tableinvoiceline;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tableinvoice=$tableinvoice;
	$this->tableproduct=$tableproduct;
	$this->tablebpartner=$tablebpartner;
	$this->tablecurrency=$tablecurrency;
	$this->tableaccounts=$tableaccounts;
	$this->tableinvoiceline=$tableinvoiceline;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int invoice_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $invoice_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Sales/Purchase Invoice";
		$action="create";
	 	
		if($invoice_id==0 || $invoice_id==""){
			//$this->document_no = getNewCode($this->xoopsDB,"invoice_no",$this->tableinvoice);
			$this->document_date=date('Y-m-d',time());
			//$this->document_date= getDateSession();
			$this->documenttype="0";
			$this->bpartner_id=0;
			$this->amt=0;
			$this->batch_id=0;
			$this->originalamt=0;

		}
		$savectrl="<input style='height: 40px;' name='btnSave' value='Save' type='button' onclick='iscomplete.value=0;saveRecord()'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";
		$statustext='This purchase invoice not yet exist in database. You will lose this record if you not save it.';

	
	}
	else
	{
		
		$action="update";


		$printctrl="<form target='_blank' name='frmPrintInvoice' method='POST' action='viewinvoice.php'>
			<INPUT TYPE='hidden' value='$this->invoice_id'
				name='invoice_id'>
			<INPUT TYPE='submit' value='Preview'
				name='btnPreview'></form>";
		if($this->iscomplete==0){
		$savectrl="<input name='invoice_id' value='$this->invoice_id' type='hidden'>".
			 "<input style='height: 40px;' name='btnSave' value='Save' type='button' onclick='iscomplete.value=0;saveRecord()'>";
		$completectrl=" <input style='height: 40px;' name='btnComplete' value='Complete' type='button'
				onclick='iscomplete.value=1;saveRecord();'>";
		$activatectrl='';
		$deletectrl="<FORM action='invoice.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this invoice?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->invoice_id' name='invoice_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		$statustext='This purchase invoice under draft mode, you need to complete it in order to effect accounts.';

		}
		else{
		$savectrl="";
		$completectrl="";
		$activatectrl="<form method='POST' name='frmActivateInvoice' 
			onsubmit='return confirm(\"Reactivate this invoice record?\");'>
			<input type='hidden' name='action' value='reactive'>
			<input type='hidden' name='invoice_id' value='$this->invoice_id'>
			<input type='submit' name='btnReactive' value='Reactive'>
			</form>";
		$deletectrl="";
		$statustext='This purchase invoice is completed and it effect to accounts. You cannot change this purchase invoice before reactivate it.';

		}
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$tableinvoice' type='hidden'>".
		"<input name='id' value='$this->invoice_id' type='hidden'>".
		"<input name='idname' value='invoice_id' type='hidden'>".
		"<input name='title' value='Invoice' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";
		


	
		$header="Edit Sales/Purchase Invoice";
		
		//if($this->allowDelete($this->invoice_id))
		//else
		//$deletectrl="";
		$addnewctrl="<Form action='invoice.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";
		
	if($this->batch_id>0)
		$viewbatch="<a href='batch.php?batch_id=$this->batch_id&action=edit'>View Journal</a>";
		else
		$viewbatch="";
	}
if( $this->documenttype==1){
 $selectnulldoctype="";
 $selectdebitdoctype="selected='selected'";
 $selectcreditdoctype="";

}
elseif( $this->documenttype==2){
 $selectnulldoctype="";
 $selectdebitdoctype="";
 $selectcreditdoctype="selected='selected'";
}
else{
 $selectnulldoctype="selected='selected'";
 $selectdebitdoctype="";
 $selectcreditdoctype="";
}
global $defcurrencycode;
    echo <<< EOF
<a href='invoice.php'>[Add New]</a>&nbsp;<a href='invoice.php?action=showSearchForm'>[Search]</a>
<table style="width:140px;"><tbody><td nowrap><form onsubmit="return validateInvoice()" method="post"
 action="invoice.php" name="frmInvoice">
<input name="reset" value="Reset" type="reset">
</td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign </td>
        <td class="even" >$this->orgctrl $viewbatch<input type='hidden' value='$this->iscomplete' name='iscomplete'>
					<input type='hidden' value="$this->batch_id" name='batch_id'></td>
        <td class="head">Document Type</td>
        <td class="even" ><SELECT name='documenttype' onchange="reloadDocumentNo($this->invoice_id,this.value)">
				<option $selectnulldoctype value="0">Null</option>
				<option $selectdebitdoctype value="1">Sales Invoice</option>
				<option $selectcreditdoctype value="2">Purchase Invoice</option>
			</SELECT></td>

      </tr>

      <tr>
	<td class="head">Date $mandatorysign</td>
	<td class="even" ><input maxlength="10" size="10" id='document_date' 
			name='document_date' value="$this->document_date">
			<input type='button' name='btndocument_date' onclick="$this->showcalendar" value='Date'></td>
	<td class="head">Document No $mandatorysign</td>
	<td class="even" >
    <input maxlength="10" size="3" name="spinvoice_prefix" value="$this->spinvoice_prefix">
	<input maxlength="20" size="15" name="document_no" value="$this->document_no"></td>
      </tr>
      <tr>
	<td class="head">Business Partner Account</td>
	<td class="even" acolspan="3">$this->bpartneraccountsctrl</td>
	<td class="head">Business Partner $mandatorysign</td>
        <td class="even" ><div id='divbpartner'> $this->bpartnerctrl</div> 
			<input name='bpartner_id' id='bpartner_id' type='hidden' value="$this->bpartner_id"></td>
	<!--<td class="head">Effected Account</td>
	<td class="even" >$this->accountsctrla</td>-->
      </tr>
    <tr>
	<td class="head">Reference No</td>
	<td class="even" colspan="3"><input maxlength="30" size="20" name='ref_no' value="$this->ref_no"></td>

	</td>
      </tr>
  <tr>
	<td class="head">Currency $mandatorysign</td>
        <td class="even" ><select name='currency_id'>$this->currencyctrl</select> <input type='button' name='btnRecalculate' onclick='calculatesummary()' value='Recalculate Total'>
	<td class="head">Exchange Rate</td>
	<td class="even" ><input maxlength="30" size="20" name='exchangerate' value="$this->exchangerate">
		Local Amount: $defcurrencycode<input maxlength="30" size="20" name='amt' value="$this->amt" readonly='readonly'></td>

	</td>
      </tr>
    <tr>
        <td class="head">Add Line</td>
	<td class="even" colspan="3">
		<SELECT name='addinvoicelineqty' >
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
	$this->invoicelinectrl
      <tr>
        <td class="head">Description</td>
	<td class="even" colspan="3"><textarea name='description' cols='80'>$this->description</textarea>
	</td>
      </tr>

      <tr>
        <td class="head">Add After Save</td>
	<td class="even" colspan="3"><input type='checkbox' name='chkAddNew'>Add new record immediately after save or complete.
	</td>
      </tr>
 	
    </tbody>
  </table><input type='hidden' id='itemqty' name='itemqty' value="$this->itemqty">
<table style="width:150px;"><tbody><td>$savectrl</td><td> $completectrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td><td>$activatectrl</td><td>$printctrl</td></tbody></table>
  <br>

$recordctrl

EOF;


  } // end of member function getInputForm

  /**
   * Update existing invoice record
   *
   * @return bool
   * @access public
   */
  public function updateInvoice( ) {

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql=	"UPDATE $this->tableinvoice SET 
		document_no='$this->document_no',
		spinvoice_prefix='$this->spinvoice_prefix',
		document_date='$this->document_date',
		documenttype=$this->documenttype,
		currency_id=$this->currency_id,
		bpartner_id=$this->bpartner_id,
		bpartneraccounts_id=$this->bpartneraccounts_id,
		ref_no='$this->ref_no',
		exchangerate=$this->exchangerate,
		batch_id=$this->batch_id,
		amt=$this->amt,
		originalamt=$this->originalamt,
		description='$this->description',
		updated='$timestamp',
		iscomplete=$this->iscomplete,
		updatedby=$this->updatedby,itemqty=$this->itemqty
		WHERE invoice_id=$this->invoice_id";

	$this->log->showLog(3, "Update invoice_id: $this->invoice_id, $this->invoice_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update invoice failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update invoice successfully.");
		return true;
	}
  } // end of member function updateInvoice

  /**
   * Save new invoice into database
   *
   * @return bool
   * @access public
   */
  public function insertInvoice( ) {


   	$timestamp= date("y/m/d H:i:s", time()) ;

	$this->log->showLog(3,"Inserting new invoice $this->invoice_no");

 	$sql="INSERT INTO $this->tableinvoice 
			(document_no,spinvoice_prefix,
			document_date,
			currency_id,
			bpartner_id, 
			documenttype,
			created,
			createdby,
			updated,
			updatedby,
			organization_id,ref_no,exchangerate,itemqty,
			description,bpartneraccounts_id
			)	
			values(
			'$this->document_no','$this->spinvoice_prefix',
			'$this->document_date',
			$this->currency_id,
			$this->bpartner_id,
			$this->documenttype,
			'$timestamp',
			$this->createdby,
			'$timestamp',
			$this->updatedby,
			$this->organization_id,'$this->ref_no',$this->exchangerate,$this->addinvoicelineqty,
			'$this->description',$this->bpartneraccounts_id)";

	$this->log->showLog(4,"Before insert invoice SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert invoice code $invoice_no:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new invoice $invoice_no successfully"); 
		return true;
	}
  } // end of member function insertInvoice

  /**
   * Pull data from invoice table into class
   *
   * @return bool
   * @access public
   */
  public function fetchInvoice( $invoice_id) {


	$this->log->showLog(3,"Fetching invoice detail into class Invoice.php.<br>");
		
	$sql="SELECT invoice_id,document_date, document_no,spinvoice_prefix,
	currency_id,bpartner_id,ref_no,documenttype,batch_id,amt,
	itemqty,iscomplete,description,organization_id,originalamt,exchangerate,bpartneraccounts_id 
	from $this->tableinvoice where invoice_id=$invoice_id";
	
	$this->log->showLog(4,"ProductInvoice->fetchInvoice, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
/*piv.invoice_id,piv.document_date, piv.invoice_no, 
	piv.lorry_no,piv.bpartner_id,piv.ref_no,piv.totaltonnage,piv.subtotal,piv.netamt,
	piv.lineqty,piv.iscomplete,piv.batch_id,piv.deliverychargesamt,piv.loadingcharges,
	piv.sundry_othersexpenses,piv.description,piv.remarks,bp.bpartner_no,bp.bpartner_name,
	bp.organization_id*/

	$this->invoice_id=$row["invoice_id"];
	$this->document_no=$row["document_no"];
	$this->spinvoice_prefix=$row["spinvoice_prefix"];
	$this->document_date=$row["document_date"];
	$this->currency_id=$row["currency_id"];
	$this->iscomplete=$row['iscomplete'];
	$this->batch_id=$row['batch_id'];
	$this->bpartner_id=$row["bpartner_id"];
	$this->organization_id=$row["organization_id"];
	$this->ref_no=$row['ref_no'];
	$this->documenttype=$row['documenttype'];
	$this->originalamt=$row['originalamt'];
	$this->amt=$row['amt'];
	$this->itemqty=$row['itemqty'];
	$this->exchangerate=$row['exchangerate'];
	$this->bpartneraccounts_id=$row['bpartneraccounts_id'];
	$this->originalamt=$row['originalamt'];
	$this->sundry_othersexpenses=$row['sundry_othersexpenses'];
	$this->description=$row['description'];

   	$this->log->showLog(4,"Invoice->fetchInvoice,database fetch into class successfully");
	$this->log->showLog(4,"invoice_no:$this->invoice_no");

	$this->log->showLog(4,"machine_id:$this->machine_id");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Invoice->fetchInvoice,failed to fetch data into databases:" . mysql_error(). ":$sql");	
	}
  } // end of member function fetchInvoice

  /**
   * Delete particular invoice id
   *
   * @param int invoice_id 
   * @return bool
   * @access public
   */
  public function deleteInvoice( $invoice_id ) {
    	$this->log->showLog(2,"Warning: Performing delete invoice id : $invoice_id !");
	$sql="DELETE FROM $this->tableinvoice where invoice_id=$invoice_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: invoice ($invoice_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"invoice ($invoice_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteInvoice


  public function reactivateInvoice($invoice_id){

	$sql="UPDATE $this->tableinvoice set iscomplete=0 where invoice_id=$invoice_id";
	$this->log->showLog(4,"Update Invoice with SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: invoice ($invoice_id) cannot reactive" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"invoice ($invoice_id) reactivated successfully!");
		return true;
		
	}

	}
  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllInvoice( $wherestring,  $orderbystring) {

    $sql="SELECT dcn.invoice_id,dcn.document_no,dcn.spinvoice_prefix,dcn.document_date,dcn.documenttype,dcn.amt,dcn.originalamt,
	bp.bpartner_no,bp.bpartner_name,bpacc.accounts_name as bpartneraccounts_name,
	cur.currency_code,bp.organization_id,dcn.iscomplete,dcn.ref_no
	FROM $this->tableinvoice dcn 
	INNER JOIN $this->tableaccounts bpacc on dcn.bpartneraccounts_id=bpacc.accounts_id
	INNER JOIN $this->tablebpartner bp  on bp.bpartner_id=dcn.bpartner_id
	INNER JOIN $this->tablecurrency cur on cur.currency_id=dcn.currency_id
	 $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showinvoicetable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllInvoice

 public function showInvoiceTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing Invoice Table");
	$sql=$this->getSQLStr_AllInvoice($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Document No</th>
				<th style="text-align:center;">Type</th>
				<th style="text-align:center;">Business Partner</th>
				<th style="text-align:center;">Accounts</th>
				<th style="text-align:center;">Currency</th>
				<th style="text-align:center;">Amount</th>
				<th style="text-align:center;">Preview</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$invoice_id=$row['invoice_id'];
		$document_date=$row['document_date'];
		$spinvoice_prefix=$row['spinvoice_prefix'];
		$document_no=$spinvoice_prefix.$row['document_no'];
		$documenttype=$row['documenttype'];
		$bpartner_name=$row['bpartner_name'];
		$iscomplete=$row['iscomplete'];
		$accounts_name=$row['accounts_name'];
		$currenct_code=$row['currency_code'];
		if($iscomplete==1)
			$iscomplete='Y';
		else
			$iscomplete='N';
		if($documenttype==1)
			$documenttype="D.Note";
		elseif($documenttype==2)
			$documenttype="C.Note";
		else
			$documenttype="Unknown";
		
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$document_date</td>
			<td class="$rowtype" style="text-align:center;">
				<a href="invoice.php?action=edit&invoice_id=$invoice_id">$document_no</a>
			</td>
			<td class="$rowtype" style="text-align:center;">$documenttype</td>
			<td class="$rowtype" style="text-align:center;">$bpartner_name</td>
			<td class="$rowtype" style="text-align:center;">$accounts_name</td>
			<td class="$rowtype" style="text-align:center;">$currenct_code</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
			<table><tr>
				<td>
				<form action="viewinvoice.php" method="POST" target='_blank'>
				<input type="submit" name="submit" id="submit" value='PDF'>
				<input type="hidden" value="$invoice_id" name="invoice_id">
				</form>
				</td>
				<td>
				<form action="invoice.php" method="POST">
				<input type="image" src="images/edit.gif" name="btnEdit" title='Edit this record'>
				<input type="hidden" value="$invoice_id" name="invoice_id">
				<input type="hidden" name="action" value="edit">
				</form>
				</td>
			</table></tr>
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
  public function getLatestInvoiceID() {
	$sql="SELECT MAX(invoice_id) as invoice_id from $this->tableinvoice;";
	$this->log->showLog(3,'Checking latest created invoice_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created invoice_id:' . $row['invoice_id']);
		return $row['invoice_id'];
	}
	else
	return -1;
	
  } // end

 public function getLineCount($invoice_id){
	$sql="SELECT count(invoice_id) as lineqty from $this->tableinvoiceline where 
		invoice_id=$invoice_id;";
	$this->log->showLog(4,"Checking lineqty with SQL: $sql");

	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found lineqty:' . $row['lineqty']);
		return  $row['lineqty'];
	}
	else
	return 0;

	}



  public function getNextNo($documenttype,$organization_id) {

	$sql="SELECT MAX(document_no ) + 1 as newno from $this->tableinvoice where 
		organization_id=$organization_id and documenttype=$documenttype;";
	$this->log->showLog(3,"Checking next no: $sql");
	
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$newno=$row['newno'];
		$this->log->showLog(3,"Found next newno:$newno");
		if($newno=="")
		return 1;
		else
		return  $newno;
	}
	else
	return 1;
	
  } // end

/* public function allowDelete($invoice_id){
	$sql="SELECT count(invoice_id) as rowcount from $this->tableproduct where invoice_id=$invoice_id";
	$this->log->showLog(3,"Accessing ProductInvoice->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this product, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this product, record deletable.");
		return true;
		}
	}

*/
  public function showSearchForm($wherestr){


	if($this->issearch != "Y"){
	$this->document_date = "";
	$this->invoice_no = "";
	$this->invoice_type = "";
	$this->machine_id = 0;
	$this->defaultaccount_id = 0;
	}

	


echo <<< EOF
<a href='invoice.php'>[Add New]</a>&nbsp;<a href='invoice.php?action=showSearchForm'>[Search]</a>
	<form name="frmInvoice" action="invoice.php" method="POST">
	</form>

	<form name="frmSearch" action="invoice.php" method="POST">

	<table>
	<tr>
	<td nowrap><input value="Reset" type="reset"></td>
	</tr>
	</table>

	<table border="1">
	<input name="issearch" value="Y" type="hidden">
	<input name="action" value="search" type="hidden">
	<tr><th colspan="4">Criterial</th></tr>

      <tr>
	<td class="head">Date From</td>
	<td class="even" ><input maxlength="10" size="10" id='document_datefrom' 
		name='document_datefrom' value="$this->document_datefrom">
		<input type='button' name='btndocument_datefrom' onclick="$this->showcalendarfrom" value='Date'></td>
	<td class="head">Date To</td>
	<td class="even" ><input maxlength="10" size="10" id='document_dateto' 
		name='document_dateto' value="$this->document_dateto">
		<input type='button' name='btndocument_dateto' onclick="$this->showcalendarto" value='Date'></td>
      </tr>
    <tr>
	<td class="head">Document No From</td>
	<td class="even" ><input maxlength="30" size="30" name="document_no_from" value="$this->document_no_from"></td>
	<td class="head">Document No To</td>
	<td class="even" ><input maxlength="30" size="30" name="document_no_to" value="$this->document_no_to"></td>

      </tr>
    <tr>
	<td class="head">Ref No</td>
	<td class="even" ><input maxlength="30" size="30" name="ref_no" value="$this->ref_no"></td>
	<td class="head">Is Complete</td>
	<td class="even" ><SELECT name='iscomplete'><option value='-1'>Null</option>
				<option value='0'>No</option><option value='1'>Yes</option></td>

      </tr>

    <tr>
	<td class="head">Document Type</td>
        <td class="even" ><SELECT name='documenttype'><option value='0'>Null</option>
				<option value='1'>Debit Note</option><option value='2'>Credit Note</option></SELECT>
        <td class="head">Currency</td>
	<td class="even">$this->currencyctrl</td>

	</td>
      </tr> 
    <tr>
	<td class="head">Business Partner Account</td>
        <td class="even">$this->bpartneraccountsctrl</td>
	<td class="head">Business Partner</td>
        <td class="even">$this->bpartnerctrl</td>
        <!--<td class="head">Effected Account</td>
	<td class="even">$this->accountsctrla</td>-->
	</td>
      </tr> 
    <!--<tr>
	
        <td class="head"></td>
	<td class="even"></td>
	</td>
      </tr> -->

	<tr>
	<th colspan="4"><input type="submit" aonclick="gotoAction('search');" value="Search" ></th>
	</tr>

	</table>
	</form>
	<br>
EOF;
  }

	public function getWhereStr(){
	global $defaultorganization_id;
	$wherestr = "";
	
	if($this->document_date_from == "")
		$this->document_date_from="0000-00-00";
	if($this->document_date_to == "")
		$this->document_date_to="9999-12-31";


	$wherestr .= " and dcn.document_date between '$this->document_date_from' and '$this->document_date_to' 
			and dcn.organization_id=$defaultorganization_id and dcn.invoice_id>0 and";

	if($this->document_no_from == "")
		$this->document_no_from=0;
	if($this->document_no_to == "")
		$this->document_no_to=99999999999;

	$wherestr .= " dcn.document_no between $this->document_no_from and $this->document_no_to and";

	if($this->documenttype!=0)
		$wherestr .= " dcn.documenttype=$this->documenttype and";

	if($this->ref_no!="")
		$wherestr .= " dcn.ref_no='$this->ref_no' and";

	if($this->bpartner_id!=0)
		$wherestr .= " dcn.bpartner_id=$this->bpartner_id and";

	if($this->bpartneraccounts_id!=0)
		$wherestr .= " dcn.bpartneraccounts_id=$this->bpartneraccounts_id and";

	/*if($this->accounts_id!=0)
		$wherestr .= " dcn.accounts_id=$this->accounts_id and";
	*/

	if($this->currency_id!=0)
		$wherestr .= " dcn.currency_id=$this->currency_id and";

	if($this->iscomplete!=-1)
		$wherestr .= " dcn.iscomplete=$this->iscomplete and";

	$wherestr=substr_replace($wherestr,"",-3);

	return $wherestr;

	}

	public function getArrayPOST($invoice_id){
	global $prefix_spi;

	$sql = "select *,a.description as descriptions 
		from $this->tableinvoice a, $this->tableinvoiceline b, $this->tablebpartner c 
		where a.invoice_id = b.invoice_id 
		and a.bpartner_id = c.bpartner_id 
		and a.invoice_id = $invoice_id 
		and b.amt > 0 ";

	$this->log->showLog(4,"Get Array Post Value: $sql");
	
	$query=$this->xoopsDB->query($sql);
	$return_false = 0;
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){

	if($row['spinvoice_prefix']!="")
	$row['document_no'] = $row['spinvoice_prefix']."".$row['document_no'];

	$documenttype = $row['documenttype'];
	$documentnoarray[$i] = $row['document_no'];
	$date = $row['document_date'];
	$systemname = 'Simbiz';
	if($documenttype==1){
	$documentname = "sales invoice";
	}else{
	$documentname = "purchase invoice";
	}
	$totaltransactionamt = $row['originalamt'];
	$batch_name = "Post from $documentname ".$row['document_no'];
	$description = $row['descriptions'];

	if($i==0){//header

	
		if($documenttype==1){
		$amtarray[$i] = $row['originalamt'];
		}else{
		$amtarray[$i] = $row['originalamt']*-1;
		}

		$accountsarray[$i] = $row['bpartneraccounts_id'];
		$currencyarray[$i] = $row["currency_id"];
		$conversionarray[$i] = $row["exchangerate"];
		$originalamtarray[$i] = $row['originalamt'];
		$bpartnerarray[$i] = $row["bpartner_id"];
		$transtypearray[$i] = "";
		$linetypearray[$i] = 0;
		$chequenoarray[$i] = "";

		if($row['bpartneraccounts_id'] == 0)//return false if account id = 0
		$return_false = 1;
	$i++;
	}

	// line
		$documentnoarray[$i] = $row['document_no'];
		$accountsarray[$i] = $row['accounts_id'];
		$originalamtarray[$i] = $row['originalamt'];
		$currencyarray[$i] = $row["currency_id"];
		$conversionarray[$i] = $row["exchangerate"];
		if($documenttype==1){
		$amtarray[$i] = $row['amt']*-1;
		}else{
		$amtarray[$i] = $row['amt'];
		}
		$bpartnerarray[$i] = 0;
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



/*  public function getZommCtrl($controlname,$filename){

  }
*/
} // end of ClassInvoice
?>

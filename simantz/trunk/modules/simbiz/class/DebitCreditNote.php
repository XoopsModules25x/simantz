<?php


class DebitCreditNote
{

  public $debitcreditnote_id;
  public $debitcreditnote_no;
  public $debitcreditnote_prefix;
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

  public $debitcreditnotelinectrl;
  private $xoopsDB;
  private $tableprefix;
  private $tabledebitcreditnote;
  private $tableproduct;
  private $defaultorganization_id;
  private $tablesawmillmachine;
  private $log;


//constructor
   public function DebitCreditNote(){
	global $xoopsDB,$log,$tabledebitcreditnote,$tableproduct,$defaultorganization_id,$tableaccounts,$tablecurrency,
			$tablebpartner,$tabledebitcreditnoteline;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tabledebitcreditnote=$tabledebitcreditnote;
	$this->tableproduct=$tableproduct;
	$this->tablebpartner=$tablebpartner;
	$this->tablecurrency=$tablecurrency;
	$this->tableaccounts=$tableaccounts;
	$this->tabledebitcreditnoteline=$tabledebitcreditnoteline;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int debitcreditnote_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $debitcreditnote_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Debit/Credit Note";
		$action="create";
	 	
		if($debitcreditnote_id==0 || $debitcreditnote_id==""){
			//$this->document_no = getNewCode($this->xoopsDB,"debitcreditnote_no",$this->tabledebitcreditnote);
			//$this->document_date=date('Y-m-d',time());
			$this->document_date= getDateSession();
			$this->documenttype="0";
			$this->bpartner_id=0;
			$this->amt=0;
			$this->batch_id=0;
			$this->originalamt=0;
			//$this->debitcreditnote_prefix=0;

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


		$printctrl="<form target='_blank' name='frmPrintInvoice' method='POST' action='viewdebitcreditnote.php'>
			<INPUT TYPE='hidden' value='$this->debitcreditnote_id'
				name='debitcreditnote_id'>
			<INPUT TYPE='submit' value='Preview'
				name='btnPreview'></form>";
		if($this->iscomplete==0){
		$savectrl="<input name='debitcreditnote_id' value='$this->debitcreditnote_id' type='hidden'>".
			 "<input style='height: 40px;' name='btnSave' value='Save' type='button' onclick='iscomplete.value=0;saveRecord();'>";
		$completectrl=" <input style='height: 40px;' name='btnComplete' value='Complete' type='button'
				onclick='iscomplete.value=1;saveRecord();'>";
		$activatectrl='';
		$deletectrl="<FORM action='debitcreditnote.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this debitcreditnote?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->debitcreditnote_id' name='debitcreditnote_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		$statustext='This purchase invoice under draft mode, you need to complete it in order to effect accounts.';

		}
		else{
		$savectrl="";
		$completectrl="";
		$activatectrl="<form method='POST' name='frmActivateDebitCreditNote' 
			onsubmit='return confirm(\"Reactivate this debitcreditnote record?\");'>
			<input type='hidden' name='action' value='reactive'>
			<input type='hidden' name='debitcreditnote_id' value='$this->debitcreditnote_id'>
			<input type='submit' name='btnReactive' value='Reactive'>
			</form>";
		$deletectrl="";
		$statustext='This purchase invoice is completed and it effect to accounts. You cannot change this purchase invoice before reactivate it.';

		}
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$tabledebitcreditnote' type='hidden'>".
		"<input name='id' value='$this->debitcreditnote_id' type='hidden'>".
		"<input name='idname' value='debitcreditnote_id' type='hidden'>".
		"<input name='title' value='DebitCreditNote' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";
		


	
		$header="Edit Debit/Credit Note";
		
		//if($this->allowDelete($this->debitcreditnote_id))
		//else
		//$deletectrl="";
		$addnewctrl="<Form action='debitcreditnote.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";
		
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
<a href='debitcreditnote.php'>[Add New]</a>&nbsp;<a href='debitcreditnote.php?action=showSearchForm'>[Search]</a>
<table style="width:140px;"><tbody><td nowrap><form onsubmit="return validateDebitCreditNote()" method="post"
 action="debitcreditnote.php" name="frmDebitCreditNote">
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
        <td class="even" ><SELECT name='documenttype' onchange="reloadDocumentNo($this->debitcreditnote_id,this.value)">
				<option $selectnulldoctype value="0">Null</option>
				<option $selectdebitdoctype value="1">Debit Note</option>
				<option $selectcreditdoctype value="2">Credit Note</option>
			</SELECT></td>

      </tr>

      <tr>
	<td class="head">Date $mandatorysign</td>
	<td class="even" ><input maxlength="10" size="10" id='document_date' 
			name='document_date' value="$this->document_date">
			<input type='button' name='btndocument_date' onclick="$this->showcalendar" value='Date'></td>
	<td class="head">Document No $mandatorysign</td>
	<td class="even" >
        <input maxlength="10" size="3" name="debitcreditnote_prefix" value="$this->debitcreditnote_prefix">
	<input maxlength="20" size="15" name="document_no" value="$this->document_no">
</td>
      </tr>
      <tr>
	<td class="head">Business Partner Account</td>
	<td class="even" >$this->bpartneraccountsctrl</td>
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
        <td class="even" >$this->currencyctrl <input type='button' name='btnRecalculate' onclick='calculatesummary()' value='Recalculate Total'>
	<td class="head">Exchange Rate</td>
	<td class="even" ><input maxlength="30" size="20" name='exchangerate' value="$this->exchangerate">
		Local Amount: $defcurrencycode<input maxlength="30" size="20" name='amt' value="$this->amt" readonly='readonly'></td>

	</td>
      </tr>
    <tr>
        <td class="head">Add Line</td>
	<td class="even" colspan="3">
		<SELECT name='adddebitcreditnotelineqty' >
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
	$this->debitcreditnotelinectrl
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
   * Update existing debitcreditnote record
   *
   * @return bool
   * @access public
   */
  public function updateDebitCreditNote( ) {

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql=	"UPDATE $this->tabledebitcreditnote SET 
		document_no='$this->document_no',
		debitcreditnote_prefix='$this->debitcreditnote_prefix',
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
		WHERE debitcreditnote_id=$this->debitcreditnote_id";

	$this->log->showLog(3, "Update debitcreditnote_id: $this->debitcreditnote_id, $this->debitcreditnote_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update debitcreditnote failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update debitcreditnote successfully.");
		return true;
	}
  } // end of member function updateDebitCreditNote

  /**
   * Save new debitcreditnote into database
   *
   * @return bool
   * @access public
   */
  public function insertDebitCreditNote( ) {


   	$timestamp= date("y/m/d H:i:s", time()) ;

	$this->log->showLog(3,"Inserting new debitcreditnote $this->debitcreditnote_no");

 	$sql="INSERT INTO $this->tabledebitcreditnote 
			(document_no,debitcreditnote_prefix,
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
			'$this->document_no','$this->debitcreditnote_prefix',
			'$this->document_date',
			$this->currency_id,
			$this->bpartner_id,
			$this->documenttype,
			'$timestamp',
			$this->createdby,
			'$timestamp',
			$this->updatedby,
			$this->organization_id,'$this->ref_no',$this->exchangerate,$this->adddebitcreditnotelineqty,
			'$this->description',$this->bpartneraccounts_id)";

	$this->log->showLog(4,"Before insert debitcreditnote SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert debitcreditnote code $debitcreditnote_no:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new debitcreditnote $debitcreditnote_no successfully"); 
		return true;
	}
  } // end of member function insertDebitCreditNote

  /**
   * Pull data from debitcreditnote table into class
   *
   * @return bool
   * @access public
   */
  public function fetchDebitCreditNote( $debitcreditnote_id) {


	$this->log->showLog(3,"Fetching debitcreditnote detail into class DebitCreditNote.php.<br>");
		
	$sql="SELECT debitcreditnote_id,document_date, document_no, debitcreditnote_prefix,
	currency_id,bpartner_id,ref_no,documenttype,batch_id,amt,
	itemqty,iscomplete,description,organization_id,originalamt,exchangerate,bpartneraccounts_id 
	from $this->tabledebitcreditnote where debitcreditnote_id=$debitcreditnote_id";
	
	$this->log->showLog(4,"ProductDebitCreditNote->fetchDebitCreditNote, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
/*piv.debitcreditnote_id,piv.document_date, piv.debitcreditnote_no, 
	piv.lorry_no,piv.bpartner_id,piv.ref_no,piv.totaltonnage,piv.subtotal,piv.netamt,
	piv.lineqty,piv.iscomplete,piv.batch_id,piv.deliverychargesamt,piv.loadingcharges,
	piv.sundry_othersexpenses,piv.description,piv.remarks,bp.bpartner_no,bp.bpartner_name,
	bp.organization_id*/

	$this->debitcreditnote_id=$row["debitcreditnote_id"];
	$this->document_no=$row["document_no"];
	$this->debitcreditnote_prefix=$row["debitcreditnote_prefix"];
        
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

   	$this->log->showLog(4,"DebitCreditNote->fetchDebitCreditNote,database fetch into class successfully");
	$this->log->showLog(4,"debitcreditnote_no:$this->debitcreditnote_no");

	$this->log->showLog(4,"machine_id:$this->machine_id");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"DebitCreditNote->fetchDebitCreditNote,failed to fetch data into databases:" . mysql_error(). ":$sql");	
	}
  } // end of member function fetchDebitCreditNote

  /**
   * Delete particular debitcreditnote id
   *
   * @param int debitcreditnote_id 
   * @return bool
   * @access public
   */
  public function deleteDebitCreditNote( $debitcreditnote_id ) {
    	$this->log->showLog(2,"Warning: Performing delete debitcreditnote id : $debitcreditnote_id !");
	$sql="DELETE FROM $this->tabledebitcreditnote where debitcreditnote_id=$debitcreditnote_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: debitcreditnote ($debitcreditnote_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"debitcreditnote ($debitcreditnote_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteDebitCreditNote


  public function reactivateDebitCreditNote($debitcreditnote_id){

	$sql="UPDATE $this->tabledebitcreditnote set iscomplete=0 where debitcreditnote_id=$debitcreditnote_id";
	$this->log->showLog(4,"Update DebitCreditNote with SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: debitcreditnote ($debitcreditnote_id) cannot reactive" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"debitcreditnote ($debitcreditnote_id) reactivated successfully!");
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
  public function getSQLStr_AllDebitCreditNote( $wherestring,  $orderbystring) {

    $sql="SELECT dcn.debitcreditnote_id,dcn.document_no,dcn.debitcreditnote_prefix,dcn.document_date,dcn.documenttype,dcn.amt,dcn.originalamt,
	bp.bpartner_no,bp.bpartner_name,bpacc.accounts_name as bpartneraccounts_name,
	cur.currency_code,bp.organization_id,dcn.iscomplete,dcn.ref_no
	FROM $this->tabledebitcreditnote dcn
	INNER JOIN $this->tableaccounts bpacc on dcn.bpartneraccounts_id=bpacc.accounts_id
	INNER JOIN $this->tablebpartner bp  on bp.bpartner_id=dcn.bpartner_id
	INNER JOIN $this->tablecurrency cur on cur.currency_id=dcn.currency_id
	 $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showdebitcreditnotetable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllDebitCreditNote

 public function showDebitCreditNoteTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing DebitCreditNote Table");
	$sql=$this->getSQLStr_AllDebitCreditNote($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Document No</th>
				<th style="text-align:center;">Type</th>
				<th style="text-align:center;">B/Partner</th>
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
		$debitcreditnote_id=$row['debitcreditnote_id'];
		$document_date=$row['document_date'];

                
		$debitcreditnote_prefix=$row['debitcreditnote_prefix'];
		$document_no=$debitcreditnote_prefix.$row['document_no'];
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
				<a href="debitcreditnote.php?action=edit&debitcreditnote_id=$debitcreditnote_id">$document_no</a>
			</td>
			<td class="$rowtype" style="text-align:center;">$documenttype</td>
			<td class="$rowtype" style="text-align:center;">$bpartner_name</td>
			<td class="$rowtype" style="text-align:center;">$accounts_name</td>
			<td class="$rowtype" style="text-align:center;">$currenct_code</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
			<table><tr>
			<td>
				<form action="viewdebitcreditnote.php" method="POST" target='_blank'>
				<input type="submit" name="submit" id="submit" value='PDF'>
				<input type="hidden" value="$debitcreditnote_id" name="debitcreditnote_id">
				</form>
			</td>
			<td>
				<form action="debitcreditnote.php" method="POST">
				<input type="image" src="images/edit.gif" name="btnEdit" title='Edit this record'>
				<input type="hidden" value="$debitcreditnote_id" name="debitcreditnote_id">
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
  public function getLatestDebitCreditNoteID() {
	$sql="SELECT MAX(debitcreditnote_id) as debitcreditnote_id from $this->tabledebitcreditnote;";
	$this->log->showLog(3,'Checking latest created debitcreditnote_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created debitcreditnote_id:' . $row['debitcreditnote_id']);
		return $row['debitcreditnote_id'];
	}
	else
	return -1;
	
  } // end

 public function getLineCount($debitcreditnote_id){
	$sql="SELECT count(debitcreditnote_id) as lineqty from $this->tabledebitcreditnoteline where 
		debitcreditnote_id=$debitcreditnote_id;";
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

	$sql="SELECT MAX(document_no ) + 1 as newno from $this->tabledebitcreditnote where 
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

/* public function allowDelete($debitcreditnote_id){
	$sql="SELECT count(debitcreditnote_id) as rowcount from $this->tableproduct where debitcreditnote_id=$debitcreditnote_id";
	$this->log->showLog(3,"Accessing ProductDebitCreditNote->allowDelete to verified id:$id is deletable.");
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
	$this->debitcreditnote_no = "";
	$this->debitcreditnote_type = "";
	$this->machine_id = 0;
	$this->defaultaccount_id = 0;
	}

	


echo <<< EOF
<a href='debitcreditnote.php'>[Add New]</a>&nbsp;<a href='debitcreditnote.php?action=showSearchForm'>[Search]</a>
	<form name="frmDebitCreditNote" action="debitcreditnote.php" method="POST">
	</form>

	<form name="frmSearch" action="debitcreditnote.php" method="POST">

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
			and dcn.organization_id=$defaultorganization_id and dcn.debitcreditnote_id>0 and";

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

	/*
	if($this->accounts_id!=0)
		$wherestr .= " dcn.accounts_id=$this->accounts_id and";
	*/

	if($this->currency_id!=0)
		$wherestr .= " dcn.currency_id=$this->currency_id and";

	if($this->iscomplete!=-1)
		$wherestr .= " dcn.iscomplete=$this->iscomplete and";

	$wherestr=substr_replace($wherestr,"",-3);

	return $wherestr;

	}

	public function getArrayPOST($debitcreditnote_id){
	global $prefix_dcnote;

	$sql = "select *,a.description as descriptions 
		from $this->tabledebitcreditnote a, $this->tabledebitcreditnoteline b, $this->tablebpartner c 
		where a.debitcreditnote_id = b.debitcreditnote_id 
		and a.bpartner_id = c.bpartner_id 
		and a.debitcreditnote_id = $debitcreditnote_id 
		and b.amt > 0 ";

	$this->log->showLog(4,"Get Array Post Value: $sql");
	
	$query=$this->xoopsDB->query($sql);
	$return_false = 0;
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){

	if($row['debitcreditnote_prefix']!="")
	$row['document_no'] = $row['debitcreditnote_prefix']."".$row['document_no'];

	$documenttype = $row['documenttype'];
	$documentnoarray[$i] = $row['document_no'];
	$date = $row['document_date'];
	$systemname = 'Simbiz';
	if($documenttype==1){
	$documentname = "debit note";
	}else{
	$documentname = "credit note";
	}
	$totaltransactionamt = $row['originalamt'];
	$batch_name = "Post from Simbiz $documentname ".$row['document_no'];
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
} // end of ClassDebitCreditNote
?>

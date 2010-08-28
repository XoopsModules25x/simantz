<?php


class Batch
{

  public $batch_id;
  public $batch_name;
  public $organization_id;
  public $batchno;
  public $reuse;
  public $description;
  public $period_id;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $currencyctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  public $tablebatch;
  public $tablebpartner;
  public $tabletransaction;
  private $tableclosing;
  public $tableperiod;
  public $tableaccounts;
  private $defaultorganization_id;
  private $log;


//constructor
   public function Batch(){
	global $xoopsDB,$log,$tablebatch,$tableusers,$tablebpartner,$tablebpartnergroup,$tableaccounts;
	global $tableorganization,$defaultorganization_id,$tabletransaction,$tableclosing,$tableperiod;

  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablebatch=$tablebatch;
	$this->tableusers=$tableusers;
	$this->tabletransaction=$tabletransaction;
	$this->tableclosing=$tableclosing;
	$this->tableperiod=$tableperiod;
	$this->tableaccounts=$tableaccounts;
	$this->defaultorganization_id = $defaultorganization_id;

	$this->tablebpartner=$tablebpartner;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int batch_id 
   * @return 
   * @access public
   */

   public function viewBatch($batch_id){
       $addnewctrl="<a href='batch.php'>[ Add New ]</a><a href='batch.php?action=showsearchform'>[ Search ]</a>";
   
   $transactionctrl="<tr><td class='head'>Transaction</td><td class='even' colspan='3'>$this->transactiontable</td></tr>";
    if($this->isAdmin)
	$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablebatch' type='hidden'>".
		"<input name='id' value='$this->batch_id' type='hidden'>".
		"<input name='idname' value='batch_id' type='hidden'>".
		"<input name='title' value='Batch' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";
  echo <<< EOF
$addnewctrl


<table style="width:140px;"><tbody><td><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">View Batch (Read Only)</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl  $this->isreadonly</td>
   	<td class="head">Batch No $mandatorysign</td>
        <td class="even" >$this->batchno</td>
      </tr>
      <tr>
	<td class="head">Date</td>
	<td class="even" >$this->batchdate</td>
        <td class="head">Batch Name</td>
        <td class="even" >$this->batch_name
		&nbsp;Re-Use <input type="checkbox" $checked name="reuse" $readonlyctrl  </td>
      </tr>


   <tr>
        <td class="head">Total Debit </td>
        <td class="even" >$this->totaldebit</TD>
	<td class="head">Total Credit</td>
	<td class="even" >$this->totalcredit</td>
      </tr>
      <tr>
        <td class="head">Description</td>
        <td class="even" colspan='3'>$this->description</td>
      </tr>



$transactionctrl

    </tbody>
  </table>

$recordctrl

EOF;
       
   }
  public function getInputForm( $type,  $batch_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";
	global $defcurrencycode;

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	$reusectrl="";
	$styledate="";
	$stylecalendar="";
	$styleclosing="";

	$orgctrl="";
	//$this->created=0;
	 	$nextid=0;
		$previousid=0;
	$addnewctrl="<a href='batch.php'>[ Add New ]</a><a href='batch.php?action=showsearchform'>[ Search ]</a>";
	if ($type=="new"){
		$header="New Batch";
		$action="create";

		if($batch_id==0){
			$this->batch_name="";
			$this->reuse="";
			$this->period_id=0;
			//$this->batchno=0;
			$this->batchno = getNewCode($this->xoopsDB,"batchno",$this->tablebatch);
			$this->totaldebit="0.00";
			$this->totalcredit="0.00";
			//$this->batchdate= date("Y-m-d", time()) ;
			$this->batchdate= getDateSession();

		}
		
		//$savectrl="";
		//$savectrl="<input style='height: 40px;' name='btnSave' value='Save' type='button' onclick='validateBatchSave();'>";
/*
		$savectrl="<input name='batch_id' value='$this->batch_id' type='hidden'>
			 <input style='height: 40px;' name='btnSave' value='Save' type='button' onclick='iscomplete.value=0;validatePeriodDate();'>
			 <input style='height: 40px;display:none' name='btncomplete' value='Complete' type='button' onclick='iscomplete.value=1;validatePeriodDate();'>";
*/
		$savectrl="<input name='batch_id' value='$this->batch_id' type='hidden'>
			 <input style='height: 40px;' name='btnSave' value='Save' type='button' onclick='iscomplete.value=0;saveBatch();'>";
		$completectrl=" <input style='height: 40px;display:none' name='btncomplete' value='Complete' type='button' onclick='iscomplete.value=1;saveBatch();'>";

		$checked="";
		$deletectrl="";

		$selectStock="";
		$selectClass="";
		$selectCharge="";

		$defaultsetting="
				<table border='1' >
				<tr>
				<td class='head' rowspan='3' style='display:none'>Transaction</td>
				<th>Accounts</th><th>Cheque.No</th><th>Debit</th><th>Credit</th><th>Doc.No</th><th>Add Line</th><tr>
				<td class='head' rowspan='2' style='display:none'>Transaction</td>
				<td nowrap width='1' class='odd'>
				<table>
				<tr>
				<td>$this->defaultaccountsctrl</td>
				</tr>
				<tr>
				<td><div id='ctrlBP' width='1' style='display:none;float: left'>
					<input type='hidden' value='0' name='defaultbpartner_id'></div></td>
				</tr>
				<tr>
				<td><input  size='17' name='linedescdef' id='linedescdef'  aonKeyDown='return changearrayfieldEnter(event,\"linedescdef\",$nextid,$previousid,\"linedescdef\",this)'></td>
				</tr>
				</table>
				
		    		
				</td>
				<td nowrap width='1' class='odd'>
				<input name='defaultchequeno' id='defaultchequeno' size='10' maxlength='10'
					 style='display:none' onfocus='this.select()' 
				aonKeyDown='return changearrayfieldEnter(event,\"defaultchequeno\",$nextid,$previousid,\"defaultchequeno\",this)'>
				</td>
				<td nowrap width='1' class='odd'>
				<input name='defaultdebit' onchange='checkFldDefault(this.name)' value='0.00' size='10' maxlength='10'
					onfocus='this.select()' id='defaultdebit'  aonKeyDown='return changearrayfieldEnter(event,\"defaultdebit\",$nextid,$previousid,\"defaultdebit\",this)'> 
				</td><td nowrap width='1' class='odd'>
				<input name='defaultcredit' onchange='checkFldDefault(this.name)' value='0.00' size='10' maxlength='10'
					onfocus='this.select()' id='defaultcredit' aonKeyDown='return changearrayfieldEnter(event,\"defaultcredit\",$nextid,$previousid,\"defaultcredit\",this)'>
				</td><td nowrap width='1' class='odd'>
				<input name='defaultdocno1' id='defaultdocno1' size='10' maxlength='10' onfocus='this.select()' aonKeyDown='return changearrayfieldEnter(event,\"defaultdocno1\",$nextid,$previousid,\"defaultdocno1\",this)'>
				</td>
				<td nowrap awidth='1' class='odd'>
				<SELECT name='defaultline'  onchange='showRef(this.value)'  id='defaultline' aonKeyDown='return changearrayfieldEnter(event,\"defaultline\",$nextid,$previousid,\"defaultline\",this)'>
					<option value='0' selected='SELECTED'></option>
					<option value='1' > 1 </option>
					<option value='2' > 2 </option>
					<option value='3' > 3 </option>
					<option value='4' > 4 </option>
					<option value='6' > 6 </option>
				</SELECT></td>
				</tr>
				<tr id='refID'>
				<td class='head' style='display:none' class='even'>Reference Account</td>
				<td nowrap width='1' class='even'>
				<table>
				<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;$this->defaultaccountsctrlref</td>
				</tr>
				<tr>
				<td><div id='ctrlBPRef' width='1' style='display:none;float: left'>
						<input type='hidden' value='0' name='defaultbpartnerref_id'>
					</div></td>
				</tr>
				<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;<input size='17' name='linedescref' id='linedescref' aonKeyDown='return changearrayfieldEnter(event,\"linedescref\",$nextid,$previousid,\"linedescref\",this)'></td>
				</tr>
				</table>
					
				</td>
				<td nowrap width='1' class='even'>&nbsp;&nbsp;&nbsp;&nbsp;
					<input name='refchequeno' id='refchequeno' size='10' maxlength='10'
						 style='display:none' onfocus='this.select()'  aonKeyDown='return changearrayfieldEnter(event,\"refchequeno\",$nextid,$previousid,\"refchequeno\",this)'>
				</td>
				<td nowrap class='even'> &nbsp;&nbsp;&nbsp;&nbsp;
					<input name='refamtvaluedebit' size='10' maxlength='10' value='0.00' onchange='checkRefValue(this.name);'
					onfocus='this.select()'  id='refamtvaluedebit' aonKeyDown='return changearrayfieldEnter(event,\"refamtvaluedebit\",$nextid,$previousid,\"refamtvaluedebit\",this)'>
				</td>

				<td nowrap width='1' class='even'>&nbsp;&nbsp;&nbsp;&nbsp;
					<input name='refamtvaluecredit' size='10' maxlength='10' value='0.00' onchange='checkRefValue(this.name);'
					onfocus='this.select()'  id='refamtvaluecredit' aonKeyDown='return changearrayfieldEnter(event,\"refamtvaluecredit\",$nextid,$previousid,\"refamtvaluedebit\",this)'>
				</td>
				<td nowrap width='1' class='even'>&nbsp;&nbsp;&nbsp;&nbsp;
					<input name='refdocno1' id='refdocno1' size='10' maxlength='10' onfocus='this.select()'  aonKeyDown='return changearrayfieldEnter(event,\"refdocno1\",$nextid,$previousid,\"refdocno1\",this)'>
				</td>
				<td nowrap awidth='1' class='even'>
				</td>
				</tr>
				</table>
				";
			$transactionctrl="<tr><td class='head'>Transaction</td>	<td colspan='3'>$defaultsetting</td></tr>";
		$selectadd1line="SELECTED='SELECTED'";
		$selectadd0line="";
/*			$defaultcurrencysetting="<tr><td class='head'>Currency</td>
				<td class='even' >$this->currencyctrl Organization Currency: $defcurrencycode</TD>
				<td class='head'>Conversion Rate</td>
				<td class='even'><input value='$this->conversionrate' name='conversionrate'></td>
			</tr>";*/
	}
	else
	{
		$selectadd0line="SELECTED='SELECTED'";
		$selectadd1line="";
		//$styledate="readonly";
		//$stylecalendar="style='display:none'";
	//	$defaultcurrencysetting="";
		$action="update";
                //check whether this batch is system controlled batch
                if( $this->isreadonly==0){
		if($this->iscomplete==0){
		$savectrl="<input name='batch_id' value='$this->batch_id' type='hidden'>
			 <input style='height: 40px;' name='btnSave' value='Save' type='button' onclick='iscomplete.value=0;validateBatchSave2();'>";
		$completectrl="<input style='height: 40px;' name='btncomplete' value='Complete' type='button' onclick='iscomplete.value=1;validateBatchSave2();'>";
			$readonlyctrl="";

		}
		else{
			$readonlyctrl="readonly='readonly'";
			$savectrl=" <input name='btncomplete' type='hidden'>";
		}
                }
                else{
                $readonlyctrl="readonly='readonly'";
                $statusmsg="<b style='color:red'>System controlled record, you have readonly permission.</b>";
                }//end else from check isreadonly field
		$defaultsetting="";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='../simantz/recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablebatch' type='hidden'>".
		"<input name='id' value='$this->batch_id' type='hidden'>".
		"<input name='idname' value='batch_id' type='hidden'>".
		"<input name='title' value='Batch' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";
		

		//force reuse checkbox been checked if the value in db is 'Y'
		if ($this->reuse==1)
			$checked="CHECKED";
		else
			$checked="";
		if($this->iscomplete==0)
			$docstatus="Draft";
		else
			$docstatus="Completed";


		$header="Edit Batch";
		
		if($this->allowDelete($this->batch_id) && $this->isreadonly==0)
		$deletectrl="<FORM action='batch.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this batch?"'.")'><input type='submit' value='Delete' name='btnDelete' style='height: 40px;'>".
		"<input type='hidden' value='$this->batch_id' name='batch_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
	
		if($this->iscomplete==1 && $this->isreadonly==0)
		$reactivatectrl="<FORM action='batch.php' method='POST' onSubmit='return confirm(".
		'"confirm to re-activate this batch?"'.")'><input style='height: 40px;' type='submit' value='Activate' name='btnActivate'>".
		"<input type='hidden' value='$this->batch_id' name='batch_id'>".
		"<input type='hidden' value='reactivate' name='action'>
		<input name='token' value='$token' type='hidden'>
		</form>";
		elseif($this->iscomplete==-1){
		$reactivatectrl="<b style='color: red'>Reversed By $this->fromsys</b>";
		}

		$transactionctrl="<tr><td class='head'>Transaction</td><td class='even' colspan='3'>$this->transactiontable</td></tr>";
		
		if ($this->reuse==1)
		$reusectrl="<FORM action='batch.php' method='POST' onSubmit='return confirm(".
		'"confirm to re-use this batch?"'.")'><input style='height: 40px;' type='submit' value='Re-Use' name='btnReuse'>".
		"<input type='hidden' value='$this->batch_id' name='batch_id'>".
		"<input type='hidden' value='reuseid' name='action'>
		<input name='token' value='$token' type='hidden'>
		</form>";

		if($this->checkClosing() == 1 || $this->iscomplete == 1){
		$styledelete = "style='display:none'";
		}
	}
	

    echo <<< EOF
$addnewctrl

<form onsubmit="return validateBatch()" method="post"
 action="batch.php" name="frmBatch">
<table style="width:140px;"><tbody><td><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl </td>
   	<td class="head">Batch No $mandatorysign</td>
        <td class="even" ><input name='batchno' value=$this->batchno $readonlyctrl 
			aonKeyDown="return changearrayfieldEnter(event,this.id,$nextid,$previousid,this.id,this)"></td>
      </tr>
      <tr>
	<td class="head">Date</td>
	<td class="even" >
		<input id='batchdate' name='batchdate' value="$this->batchdate" $styledate $readonlyctrl  aonKeyDown="return changearrayfieldEnter(event,'batchdate',$nextid,$previousid,'batchdate',this)">
		<input type='button' onclick="$this->showcalendar" value='Date' $stylecalendar $readonlyctrl>
		<input type='hidden' id='period_id' name='period_id' value="$this->period_id">
	</td>
        <td class="head">Batch Name $mandatorysign</td>
        <td class="even" ><input maxlength="40" size="30" name="batch_name" value="$this->batch_name" $readonlyctrl  aonKeyDown="return changearrayfieldEnter(event,'batch_name',$nextid,$previousid,'batch_name',this)"  id="batch_name">
		&nbsp;Re-Use <input type="checkbox" $checked name="reuse" $readonlyctrl  aonKeyDown="return changearrayfieldEnter(event,'reuse',$nextid,$previousid,'reuse',this)"  id="reuse"></td>
      </tr>

  
   <tr>
        <td class="head">Total Debit </td>
        <td class="even" ><input name='totaldebit' value="$this->totaldebit" readonly="readonly" size='12' $readonlyctrl 
		style='text-align:right'  aonKeyDown="return changearrayfieldEnter(event,this.id,$nextid,$previousid,this.id,this)" ></TD>
	<td class="head">Total Credit</td>
	<td class="even" ><input name='totalcredit' value="$this->totalcredit" readonly="readonly" size='12' $readonlyctrl 
		style='text-align:right' aonKeyDown="return changearrayfieldEnter(event,this.id,$nextid,$previousid,this.id,this)" > 	
			<input type='hidden' name='iscomplete' value='0'></td>
      </tr>
      <tr>
        <td class="head">Description</td>
        <td class="even" colspan='3'><input maxlength="100" size="90" name="description" value="$this->description" $readonlyctrl
		aonKeyDown="return changearrayfieldEnter(event,this.id,$nextid,$previousid,this.id,this)" ></td>
      </tr>

	
   
$transactionctrl
 	<tr>
        <td class="head">Add New Record</td>
        <td class="even" colspan='3'><input type='checkbox' name='chkAddNew' 
		aonKeyDown="return changearrayfieldEnter(event,this.id,$nextid,$previousid,this.id,this);"> 
			Add new record immediately after save or complete.<br/>$statusmsg</td>
      	</tr>
    </tbody>
  </table>
<table style="width:150px;"><tbody><tr><td $styleclosing>$savectrl  
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td><td>$completectrl</td>
	</form><td $styledelete>$deletectrl</td><td $styleclosing>$reactivatectrl</td><td>$reusectrl</td></tr></tbody></table>
  <br>

$recordctrl
<div id='iddivstatus'>Please wait for download your record completely.</div>
EOF;
  } // end of member function getInputForm

  /**
   * Update existing batch record
   *
   * @return bool
   * @access public
   */
  public function updateBatch( ) {
 global $selectspliter;
     include include "../simantz/class/Save_Data.inc.php";;
    $save = new Save_Data();
    $this->tablename=$this->tablebatch;
    $primarykeyfieldname="batch_id";
    $primarykeyvalue=$this->batch_id;
    $controlvalue=$this->batchno;
    
    $this->updated=date("y/m/d H:i:s", time()) ;
      $arrUpdateField=array("batch_name","reuse","period_id","organization_id","description","batchno","batchdate","iscomplete","totaldebit","totalcredit","updated","updatedby");



        $arrUpdateFieldType=array("%s","%d","%d","%d","%s","%d","%s","%d","%d","%d","%s","%d");

    $arrvalue=array($this->batch_name,$this->reuse,$this->period_id,$this->organization_id,$this->description,$this->batchno,$this->batchdate,$this->iscomplete,$this->totaldebit,$this->totalcredit,$this->updated,$this->updatedby);

    if( $save->UpdateRecord($this->tablename, $primarykeyfieldname,
                $primarykeyvalue,
                    $arrUpdateField, $arrvalue,  $arrUpdateFieldType,$accounts_name))
            return true;
    else
            return false;


  } // end of member function updateBatch

  /**
   * Save new batch into database
   *
   * @return bool
   * @access public
   */
  public function insertBatch( ) {

 global $selectspliter;
     include include "../simantz/class/Save_Data.inc.php";

    $save = new Save_Data();
        $this->tablename=$this->tablebatch;
    $primarykeyfieldname="batch_id";
    $primarykeyvalue=$this->batch_id;
    $controlvalue=$this->batchno;
    $this->created=date("y/m/d H:i:s", time()) ;
    $this->updated=date("y/m/d H:i:s", time()) ;
          $arrInsertField=array("batch_name","reuse","created","createdby","updated","updatedby","totaldebit","totalcredit","period_id","organization_id","description","batchno","batchdate","iscomplete");

        $arrInsertFieldType=array("%s","%d","%s","%d","%s","%d","%d","%d","%d","%d","%s","%d","%s","%d");

    $arrvalue=array($this->batch_name,$this->reuse,$this->created,$this->createdby,$this->updated,$this->updatedby,$this->totaldebit,$this->totalcredit,$this->period_id,$this->organization_id,$this->description,$this->batchno,$this->batchdate,$this->iscomplete);

    if($save->InsertRecord($this->tablename,   $arrInsertField,
            $arrvalue,$arrInsertFieldType,$this->accounts_name,$primarykeyfieldname)){
            $this->accounts_id=$save->latestid;
            return true;
            }
    else
            return false;


  } // end of member function insertBatch




  /**
   * Pull data from batch table into class
   *
   * @return bool
   * @access public
   */
  public function fetchBatch( $batch_id) {


	$this->log->showLog(3,"Fetching batch detail into class Batch.php.<br>");
		
	$sql="SELECT batch_id,batch_name,reuse,period_id,organization_id,description,
        batchno,batchdate,iscomplete,
		totaldebit,totalcredit,fromsys,isreadonly
		 from $this->tablebatch where batch_id=$batch_id";
	
	$this->log->showLog(4,"ProductBatch->fetchBatch, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->batch_name=htmlspecialchars($row["batch_name"]);
		$this->organization_id=$row['organization_id'];
		$this->period_id= $row['period_id'];
		$this->reuse=$row['reuse'];
		$this->fromsys=$row['fromsys'];
		$this->totaldebit=$row['totaldebit'];
		$this->totalcredit=$row['totalcredit'];
		$this->iscomplete=$row['iscomplete'];
		$this->batchdate=$row['batchdate'];
                $this->isreadonly=$row['isreadonly'];
		$this->batchno=$row['batchno'];
		$this->description=htmlspecialchars($row['description']);
   	$this->log->showLog(4,"Batch->fetchBatch,database fetch into class successfully");
	$this->log->showLog(4,"batch_name:$this->batch_name");

	$this->log->showLog(4,"reuse:$this->reuse");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Batch->fetchBatch,failed to fetch data into databases:" . mysql_error(). ":$sql");	
	}
  } // end of member function fetchBatch

  /**
   * Delete particular batch id
   *
   * @param int batch_id 
   * @return bool
   * @access public
   */
  public function deleteBatch( $batch_id ) {

include "../simantz/class/Save_Data.inc.php";
$save = new Save_Data();
$this->tablename=$this->tableaccounts;
$primarykeyvalue=$batch_id;
$primarykeyname="batch_id";
   $rs=$this->fetchBatch($batch_id);
   $controlvalue=$this->batchno;
   
if($rs){
    return $save->DeleteRecord($this->tablename,$primarykeyname,$primarykeyvalue,$this->$controlvalue,1);
   }
   else
       return false;




    	$this->log->showLog(2,"Warning: Performing delete batch id : $batch_id !");
	$sql="DELETE FROM $this->tablebatch where batch_id=$batch_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: batch ($batch_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"batch ($batch_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteBatch

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllBatch( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductBatch->getSQLStr_AllBatch: $sql");

    $sql="SELECT batch_name,batch_id,reuse,organization_id,period_id,batchno,batchdate FROM $this->tablebatch " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showbatchtable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllBatch

 public function showBatchTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing Batch Table");
	$sql=$this->getSQLStr_AllBatch($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
			<U><B>Draft</B></U><br>

EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$batch_id=$row['batch_id'];
		$batchdate=$row['batchdate'];

		$batch_name=$row['batch_name'];
		$batchdate=$row['batchdate'];
		$period_id=$row['period_id'];
		$batchno=$row['batchno'];

		$reuse=$row['reuse'];
		
		if($reuse==0)
		{$reuse='N';
		$reuse="<b style='color:red;'>$reuse</b>";
		}
		else
		$reuse='Y';
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		
				<A href="batch.php?action=edit&batch_id=$batch_id" title="$batchdate / $batch_name">
					$i-$batchno
				</A><br>
EOF;
	}
//	echo  "</tr></tbody></table>";
 }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestBatchID() {
	$sql="SELECT MAX(batch_id) as batch_id from $this->tablebatch";
	$this->log->showLog(3,'Checking latest created batch_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created batch_id:' . $row['batch_id']);
		return $row['batch_id'];
	}
	else
	return -1;
	
  } // end

  public function getNextBatchID() {
	$sql="SELECT MAX(batch_id) as batch_id from $this->tablebatch;";
	$this->log->showLog(3,'Checking latest created batch_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created batch_id:' . $row['batch_id']);
		return $row['batch_id']+1;
	}
	else
	return 1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(period_id) + 10 as period_id from $this->tablebatch;";
	$this->log->showLog(3,'Checking next period_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found next period_id:' . $row['period_id']);
		return  $row['period_id'];
	}
	else
	return 10;
	
  } // end

 public function allowDelete($batch_id){
	/*$sql="SELECT count(bpartner_id) as rowcount from $this->tablebpartner where bpartner_batch_id=$batch_id";
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
	*/
	return true;
	}

  public function showSearchForm(){
$addnewctrl="<a href='batch.php'>[ Add New ]</a>";
	echo <<< EOF
<table>
<tbody>
<tr>
<td>$addnewctrl</td>
</tr>
<tr>

</tr>
</table>


<table border='1'>
  <tbody>
    <tr>
      <th colspan="4">Search Batch</th>
    </tr>
    <tr>
      <td class='head'>Date From</td><form method='POST'>
      <td class='odd'><input id='batchdatefrom' name='batchdatefrom' value="$this->batchdatefrom">
		<input type='button' onclick="$this->showcalendarfrom" value='Date'></td>
      <td class='head'>Date To</td>
      <td class='odd'><input id='batchdateto' name='batchdateto' value="$this->batchdateto">
		<input type='button' onclick="$this->showcalendarto" value='Date'></td>
    </tr>
    <tr>
      <td class='head'>Batch No (100%, %10,%1001%)</td>
      <td class='even'><input name='batchno' value='$this->batchno'></td>
      <td class='head'>Batch Name</td>
      <td class='even'><input name='batch_name' value='$this->batch_name'></td>
    </tr>
    <tr>
      <td class='head'>Re-Use</td>
      <td class='even'>
	<select name="reusesearch">
	<option value=""></option>
	<option value="1">Yes</option>
	<option value="0">No</option>
	</select>
      </td>
      <td class='head'>Is Complete</td>
      <td class='even'>
	<select name="iscompletesearch">
	<option value="-">Null</option>
	<option value="1">Yes</option>
	<option value="0">No</option>
	</select>
      </td>

    </tr>

    <tr>
      <td><input type='reset' name='reset' value='Reset'></td>
      <td colspan="3"><input type='submit' name='btnSearch' value='Search'><input type='hidden' name='action' value='showhistory'></td>
    </tr>
	

  </tbody>
</table>

EOF;
  }

  public function showhistory(){
//genWhereString()
  }

  public function genWhereString($datefrom,$dateto,$batchno,$batch_name,$reuse,$iscomplete){
//	$this->log->showLog(3,"generate wherestring $datefrom,$dateto,$batchno,$batch_name");
	if($datefrom=="")
		$datefrom="0000-00-00";
	if($dateto=="")
		$dateto="9999-12-31";

	$wherestring=" and b.batchdate between '$datefrom' and '$dateto' AND";

	if($batchno<>"")
		$wherestring=$wherestring. " batchno LIKE '$batchno' AND";

	if($reuse !="")
		$wherestring=$wherestring. " reuse = $reuse AND";
        if($iscomplete !="-")
		$wherestring=$wherestring. " iscomplete = $iscomplete AND";
	if($batch_name<>"")
		$wherestring=$wherestring. " batch_name LIKE '$batch_name' AND";

	$wherestring=substr_replace($wherestring,"",-3);
	$this->log->showLog(3,"generate wherestring: $wherestring");
	return $wherestring;

  }

  public function showHistoryTable($wherestring,$orderbystring,$startno=0,$limitno=50){
	
	$sql="SELECT b.batch_id, b.batchdate, b.batchno, b.batch_name,b.iscomplete,u.uname,u.uid,b.totaldebit,b.totalcredit,b.reuse
		FROM $this->tablebatch b , $this->tableusers u 
		$wherestring 
		and b.updatedby = u.uid  
		$orderbystring ";
	//LIMIT $startno,$limitno



echo <<< EOF
<table border='1'>
<tbody>
	<tr>
	<th colspan="10">Journal History</th>
	</tr>

	<tr>
	<td class='head'>No</td>
	<td class='head'>Batch No</td>
	<td class='head'>Date</td>
	<td class='head'>Batch Name</td>
	<td class='head'>Completed</td>
	<td class='head'>Re-Use</td>
	<td class='head'>User</td>
	<td class='head'>Debit</td>
	<td class='head'>Credit</td>
	<td class='head'>Edit</td>
	
	</tr>
EOF;
	$this->log->showLog(3,"Show Journal Table with SQL:$sql");
	$query=$this->xoopsDB->query($sql) or die(mysql_error());
	
	$i=0;
	$refid = "";
  while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$uname=$row['uname'];
	$uid=$row['uid'];
	$batch_id=$row['batch_id'];
	$batch_name=$row['batch_name'];
	$batchdate=$row['batchdate'];

	$batchno=$row['batchno'];
	$iscomplete=$row['iscomplete'];
	$reuse=$row['reuse'];
	$batchdate=$row['batchdate'];
	$totaldebit=$row['totaldebit'];
	$totalcredit=$row['totalcredit'];
	if($rowtype=='odd')
		$rowtype="even";
	else
		$rowtype="odd";

	if($iscomplete==1)
	$iscomplete = "Yes";
	elseif($iscomplete==0)
	$iscomplete = "No";
	else
	$iscomplete = "Reversed";
	
	if($reuse==1)
	$reuse = "Y";
	else
	$reuse = "N";
	/*
	if($reuse==1)
	$reuselink = "<A href='batch.php?action=reuseid&batch_id=$batch_id'>[Re-Use]</A>";
	else
	$reuselink = "";
	*/
	echo <<< EOF
	
	<tr>
		<td class='$rowtype'>$i</td>
		<td class='$rowtype'>$batchno</td>
	<td class='$rowtype'>$batchdate</td>

	<td class='$rowtype'>$batch_name</td>
	<td class='$rowtype' style="text-align: center">$iscomplete</td>
	<td class='$rowtype' style="text-align: center">$reuse</td>
	<td class='$rowtype'>$uname</td>
	<td class='$rowtype' style="text-align: right">$totaldebit</td>
	<td class='$rowtype' style="text-align: right">$totalcredit</td>
	<td class='$rowtype'><A href='batch.php?action=edit&batch_id=$batch_id'>[Edit]</A></td>
  	  </tr>
EOF;
 }
echo <<< EOF
    <!--<tr>
      <td ><input type='submit' name='btnSearch' value='Search'><input type='hidden' name='action' value='showhistory'></td>
    </tr>-->
  </tbody>
</table>
EOF;
  }

	public function reUse(){
	//global $o;

	$batchno = getNewCode($this->xoopsDB,"batchno",$this->tablebatch);

	$timestamp= date("y/m/d H:i:s", time()) ;

	$sqlheader = "select * from $this->tablebatch where batch_id = $this->batch_id ";

	$this->log->showLog(3,"Reuse header with SQL:$sqlheader");
	$query=$this->xoopsDB->query($sqlheader);
	
	if($row=$this->xoopsDB->fetchArray($query)){

	$organization_id=$row['organization_id'];
	$period_id=$row['period_id'];
	$iscomplete=0;
	$batch_name=$row['batch_name'];
	$description=$row['description'];
	$created=$timestamp;
	$createdby=$this->updatedby;
	$updated=$timestamp;
	$updatedby=$this->updatedby;
	$reuse=$row['reuse'];
	$totaldebit=$row['totaldebit'];
	$totalcredit=$row['totalcredit'];
	$fromsys=$row['fromsys'];
	$batchdate=$row['batchdate'];
	//$batchdate=substr($timestamp,)

	
	$sqlinsert = 	"INSERT INTO $this->tablebatch 
			(organization_id,
			period_id,
			iscomplete,
			batchno,
			batch_name,
			description,
			created,
			createdby,
			updated,
			updatedby,
			reuse,
			totaldebit,
			totalcredit,
			fromsys,
			batchdate) 

			values 

			($organization_id,
			$period_id,
			0,
			\"$batchno\",
			\"$batch_name\",
			\"$description\",
			'$created',
			$createdby,
			'$updated',
			$updatedby,
			$reuse,
			$totaldebit,
			$totalcredit,
			\"$fromsys\",
			'$batchdate')";

	
	$this->log->showLog(4,"Before insert reuse SQL:$sqlinsert");
	
	$rs=$this->xoopsDB->query($sqlinsert);

	if (!$rs){
		$this->log->showLog(1,"Failed to insert reuse code $batch_name:" . mysql_error() . ":$sqlinsert");
		return false;
	}	

	}

	
	
	$nextbatchid = $this->getLatestBatchID();

	$sqltransaction = "select * from $this->tabletransaction where batch_id = $this->batch_id ";

	$this->log->showLog(3,"Reuse transaction with SQL:$sqltransaction");
	$query=$this->xoopsDB->query($sqltransaction);

	$i = 0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	
	$document_no=$row['document_no'];
	$amt=$row['amt'];
	$originalamt=$row['originalamt'];
	$tax_id=$row['tax_id'];
	
	$currency_id=$row['currency_id'];
	$document_no2=$row['document_no2'];
	$transtype=$row['transtype'];
	$accounts_id=$row['accounts_id'];
	$multiplyconversion=$row['multiplyconversion'];
	$seqno=$row['seqno'];
	$reference_id=$row['reference_id'];
	$bpartner_id=$row['bpartner_id'];
	$bankreconcilation_id=$row['bankreconcilation_id'];
	$linedesc=$row['linedesc'];
	
	if($reference_id > 0)
	$reference_id = $refid;
	
	$sqlinsert =	"INSERT INTO $this->tabletransaction 
			(document_no,
			batch_id,
			amt,
			originalamt,
			tax_id,
			currency_id,
			document_no2,
			transtype,
			accounts_id,
			multiplyconversion,
			seqno,
			reference_id,
			bpartner_id,bankreconcilation_id,linedesc) 

			values 

			('$document_no',
			$nextbatchid,
			$amt,
			$originalamt,
			$tax_id,
			$currency_id,
			'$document_no2',
			'$transtype',
			$accounts_id,
			$multiplyconversion,
			$seqno,
			$reference_id,
			$bpartner_id,0,'$linedesc')";

	$this->log->showLog(4,"Before insert reuse SQL:$sqlinsert");
	
	$rs=$this->xoopsDB->query($sqlinsert);

	if (!$rs){
		$this->log->showLog(1,"Failed to insert reuse code $batch_name:" . mysql_error() . ":$sqlinsert");
		return false;
	}
	
	if($reference_id == 0)
	$refid = $this->getLatestTransID();
	

	}

	return true;
	
	}
	
	public function checkClosing(){
	$retval = 0;
	$periodname = substr($this->batchdate,0,7);

	$sql = "select * from $this->tableclosing a, $this->tableperiod b
		where a.period_id = b.period_id 
		and b.period_name = '$periodname' 
		and a.iscomplete = 1 and a.isactive = 1 
		and a.organization_id = $this->defaultorganization_id
		and a.closing_id > 0 ";

	$this->log->showLog(3,"Checking closing with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = 1;
	}

	return $retval;
	}
	
	
	public function getLatestTransID(){

	$retval = "";
	$sql = "select * from $this->tabletransaction a, $this->tablebatch b 
			where a.reference_id = 0 
			and a.batch_id = b.batch_id 
			and b.organization_id = $this->defaultorganization_id 
			order by a.trans_id desc limit 1";
	
	$this->log->showLog(3,"Checking closing with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['trans_id'];
	}
	
	return $retval;
	}


	public function checkPeriodID($date){
	$retval = 0;
	$year = substr($date,0,4);
	$month = (int)substr($date,5,2);
	$sql = "select * from $this->tableperiod 
		where period_year = $year and period_month = $month ";

	$this->log->showLog(4,"Checking period date with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['period_id'];
	}
	
	return $retval;

  	}

	public function checkListAccounts($accounts_id){
	$retval = 0;

	$sql = "select count(*) as cnt from $this->tableaccounts a,
		 $this->tablebpartner b 
		where (a.accounts_id = b.debtoraccounts_id OR a.accounts_id = b.creditoraccounts_id  )
		and a.accounts_id > 0 
		and a.accounts_id = $accounts_id ";

	$this->log->showLog(4,"Checking list accounts with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['cnt'];
	}
	
	return $retval;
	}
	


} // end of ClassBatch
?>

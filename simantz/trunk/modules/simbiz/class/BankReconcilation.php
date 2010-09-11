<?php


class BankReconcilation
{

  public $bankreconcilation_id;
  public $bankreconcilation_name;
  public $organization_id;
  public $bankreconcilationno;
  public $reuse;
  public $laststatementdate;
  public $period_id;
  public $accounts_id;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $currencyctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tablebankreconcilation;
  private $tablebpartner;
  private $tabletransaction;
  private $tableclosing;
  private $tableperiod;
  private $tableaccounts;
  private $defaultorganization_id;
  private $log;


//constructor
   public function BankReconcilation(){
	global $xoopsDB,$log,$tablebankreconcilation,$tableusers,$tablebpartner,$tablebpartnergroup,$tableaccounts,$tablebatch;
	global $tableorganization,$defaultorganization_id,$tabletransaction,$tableclosing,$tableperiod;

  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablebankreconcilation=$tablebankreconcilation;
	$this->tableusers=$tableusers;
	$this->tabletransaction=$tabletransaction;
	$this->tableclosing=$tableclosing;
	$this->tableperiod=$tableperiod;
	$this->tableaccounts=$tableaccounts;
	$this->defaultorganization_id = $defaultorganization_id;
	$this->tablebpartner=$tablebpartner;
	$this->tablebatch=$tablebatch;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int bankreconcilation_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $bankreconcilation_id,$token  ) {
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
	$addnewctrl="<a href='bankreconcilation.php'>[ Add New ]</a><a href='bankreconcilation.php?action=showsearchform'>[ Search ]</a>";
	if ($type=="new"){
		$header="New Bank Reconcilation";
		$action="create";
	 	$this->iscomplete=0;
		if($bankreconcilation_id==0){
			$this->bankreconcilationno=getNewCode($this->xoopsDB,"bankreconcilationno",$this->tablebankreconcilation);
			$this->statementbalance="0.00";
			//$this->bankreconcilationdate= date("Y-m-d", time()) ;
			$this->bankreconcilationdate= getDateSession();

		}
		
		//$savectrl="";
		//$savectrl="<input style='height: 40px;' name='btnSave' value='Save' type='button' onclick='validateBankReconcilationSave();'>";
		$savectrl="<input name='bankreconcilation_id' value='$this->bankreconcilation_id' type='hidden'>
			 <input style='height: 40px;' name='btnSave' value='Save' type='submit' onclick='iscomplete.value=0;'>";
		$completectrl="<input style='height: 40px;display:none' name='btncomplete' value='Complete' type='submit' 	
				onclick='iscomplete.value=1;'>";
		$checked="";
		$deletectrl="";

		$selectStock="";
		$selectClass="";
		$selectCharge="";
		$transactionctrl="";
	
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
		if($this->iscomplete==0){
		$savectrl="<input name='bankreconcilation_id' value='$this->bankreconcilation_id' type='hidden'>
			 <input style='height: 40px;' name='btnSave' value='Save' type='submit' onclick='iscomplete.value=0;'>";

		$stylecomplete = "display:none";
		if($this->differenceamt == 0)
		$stylecomplete = "";
		
		$completectrl="<input style='height: 40px;$stylecomplete' name='btncomplete' value='Complete' type='submit' onclick='iscomplete.value=1;'>";
		
			$readonlyctrl="";

		}
		else{
			$readonlyctrl="readonly='readonly'";
			$savectrl=" <input name='btncomplete' type='hidden'>";
		}
		$defaultsetting="";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$tablebankreconcilation' type='hidden'>".
		"<input name='id' value='$this->bankreconcilation_id' type='hidden'>".
		"<input name='idname' value='bankreconcilation_id' type='hidden'>".
		"<input name='title' value='BankReconcilation' type='hidden'>".
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

	
		$header="Edit Bank Reconcilation";
		
		if($this->allowDelete($this->bankreconcilation_id) && $this->iscomplete==0){
		$deletectrl="<FORM action='bankreconcilation.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this bankreconcilation?"'.")'><input type='submit' value='Delete' name='btnDelete' style='height: 40px;'>".
		"<input type='hidden' value='$this->bankreconcilation_id' name='bankreconcilation_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		}
		else
		$deletectrl="";
	
		if($this->iscomplete==1)
		$reactivatectrl="<FORM action='bankreconcilation.php' method='POST' onSubmit='return confirm(".
		'"confirm to re-activate this bankreconcilation?"'.")'><input style='height: 40px;' type='submit' value='Activate' name='btnActivate'>".
		"<input type='hidden' value='$this->bankreconcilation_id' name='bankreconcilation_id'>".
		"<input type='hidden' value='reactivate' name='action'>
		<input name='token' value='$token' type='hidden'>
		</form>";
		elseif($this->iscomplete==-1){
		$reactivatectrl="<b style='color: red'>Reversed By $this->fromsys</b>";
		}

		$printctrl="<Form method='GET' target='_blank' action='viewbankreconcilationreport.php'>
				<input name='submit' value='Print Preview' type='submit'>
				<input name='bankreconcilation_id' value='$this->bankreconcilation_id' type='hidden'></Form>";



		
	}
	
if($this->reconcilamt == "")
$this->reconcilamt = 0;
if($this->unreconcilamt == "")
$this->unreconcilamt = 0;

    echo <<< EOF
$addnewctrl

<form onsubmit="return validateBankReconcilation()" method="post"
 action="bankreconcilation.php" name="frmBankReconcilation">
<table style="width:140px;"><tbody><td><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl</td>
	<td class="head">Bank Accounts</td>
	<td class="even" >$this->accountsctrl<input name='account_balance' value="$this->account_balance" readonly='readonly'></td>

  
      </tr>
      <tr>
        <td class="head">New Statement Balance</td>
        <td class="even" ><input name='statementbalance' value="$this->statementbalance" size='15'style='text-align:right' onchange='calculateBalance()'>
		</TD>

	<td class="head">Last Statement Balance</td>
	<td class="even" ><input name='laststatementbalance' value="$this->laststatementbalance" readonly="readonly"  size='15'style='text-align:right'></td>

      </tr>

  
   <tr>
 	   	<td class="head">Bank Reconcilation No $mandatorysign</td>
        <td class="even" ><input name='bankreconcilationno' value=$this->bankreconcilationno $readonlyctrl> </td>

	<td class="head">Difference Amount</td>
	<td class="even" ><input name='differenceamt' value="$this->differenceamt" readonly="readonly" size='15' $readonlyctrl 
		style='text-align:right'> 	
			<input type='hidden' name='iscomplete' value="$this->iscomplete">
			<input type='hidden' name='reconcilamt' value="$this->reconcilamt">
			<input type='hidden' name='unreconcilamt' value="$this->unreconcilamt"></td>
      </tr>

   <tr>
 	<td class="head">Bank Statement Date</td>
	<td class="even" >
	<input id='bankreconcilationdate' name='bankreconcilationdate' value="$this->bankreconcilationdate" size="8">
	<input type='button' onclick="$this->showcalendar" value='Date' $stylecalendar $readonlyctrl>
	<br>Period&nbsp;$this->periodctrl
	</td>

	<td class="head">Last Statement Date</td>
	<td class="even" ><input name='laststatementdate' id='laststatementdate' value="$this->laststatementdate"  readonly="readonly"></td>
      </tr>
		<td class="head">Transaction</td><td  class="even" colspan='3'><div id='childtable'>$this->transctrl</div></td>
    </tbody>
  </table>
<table style="width:150px;"><tbody><tr><td $styleclosing>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td><td>$completectrl</td>
	</form><td $styledelete>$deletectrl</td><td $styleclosing>$reactivatectrl</td><td>$printctrl</td></tr></tbody></table>
  <br>

$recordctrl

EOF;
  } // end of member function getInputForm

  /**
   * Update existing bankreconcilation record
   *
   * @return bool
   * @access public
   */
  public function updateBankReconcilation( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablebankreconcilation SET 
		organization_id=$this->organization_id,
		laststatementdate='$this->laststatementdate',bankreconcilationno='$this->bankreconcilationno',
		bankreconcilationdate='$this->bankreconcilationdate',
		iscomplete=$this->iscomplete,account_balance=$this->account_balance,
		statementbalance=$this->statementbalance,period_id=$this->period_id,
		differenceamt=$this->differenceamt,laststatementbalance=$this->laststatementbalance,
		updated='$timestamp',updatedby=$this->updatedby,
		reconcilamt=$this->reconcilamt,unreconcilamt=$this->unreconcilamt 
		WHERE bankreconcilation_id='$this->bankreconcilation_id'";
	
	$this->log->showLog(3, "Update bankreconcilation_id: $this->bankreconcilation_id, $this->bankreconcilation_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update bankreconcilation failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update bankreconcilation successfully.");
		return true;
	}
  } // end of member function updateBankReconcilation

  /**
   * Save new bankreconcilation into database
   *
   * @return bool
   * @access public
   */
  public function insertBankReconcilation( ) {

 global $selectspliter;
     include include "../simantz/class/Save_Data.inc.php";

    $save = new Save_Data();
        $this->tablename=$this->tablebankreconcilation;
    $primarykeyfieldname="bankreconcilation_id";
    $primarykeyvalue=$this->bankreconcilation_id;
    $controlvalue=$this->bankreconcilationno;
    $this->created=date("y/m/d H:i:s", time()) ;
    $this->updated=date("y/m/d H:i:s", time()) ;
          $arrInsertField=array("created","createdby","updated","updatedby","statementbalance","differenceamt","accounts_id","organization_id","laststatementdate","bankreconcilationno","bankreconcilationdate","iscomplete","account_balance","laststatementbalance","period_id","reconcilamt","unreconcilamt");

        $arrInsertFieldType=array("%s","%d","%s","%d","%d","%d","%d","%d","%s","%s","%s","%d","%d","%d","%d","%d","%d");

    $arrvalue=array($this->created,createdby,$this->updated,$this->updatedby,$this->statementbalance,$this->differenceamt,$this->accounts_id,$this->organization_id,$this->laststatementdate,$this->bankreconcilationno,$this->bankreconcilationdate,$this->iscomplete,$this->account_balance,$this->laststatementbalance,$this->period_id,$this->reconcilamt,$this->unreconcilamt);

    if($save->InsertRecord($this->tablename,   $arrInsertField,
            $arrvalue,$arrInsertFieldType,$this->accounts_name,$primarykeyfieldname)){
            $this->accounts_id=$save->latestid;
            return true;
            }
    else
            return false;


  } // end of member function insertBankReconcilation




  /**
   * Pull data from bankreconcilation table into class
   *
   * @return bool
   * @access public
   */
  public function fetchBankReconcilation( $bankreconcilation_id) {


	$this->log->showLog(3,"Fetching bankreconcilation detail into class BankReconcilation.php.<br>");
		
	$sql="SELECT statementbalance,differenceamt,accounts_id,organization_id,laststatementdate,bankreconcilationno,bankreconcilationdate,
		iscomplete,account_balance,laststatementbalance,period_id,reconcilamt,unreconcilamt
		 from $this->tablebankreconcilation where bankreconcilation_id=$bankreconcilation_id";
	
	$this->log->showLog(4,"ProductBankReconcilation->fetchBankReconcilation, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->account_balance=$row["account_balance"];
		$this->organization_id=$row['organization_id'];
		$this->accounts_id= $row['accounts_id'];
		$this->laststatementdate=$row['laststatementdate'];
		$this->period_id=$row['period_id'];
		$this->statementbalance=$row['statementbalance'];
		$this->differenceamt=$row['differenceamt'];
		$this->iscomplete=$row['iscomplete'];
		$this->reconcilamt=$row['reconcilamt'];
		$this->unreconcilamt=$row['unreconcilamt'];
		$this->bankreconcilationdate=$row['bankreconcilationdate'];
		$this->bankreconcilationno=$row['bankreconcilationno'];
		$this->laststatementbalance=$row['laststatementbalance'];
		$this->laststatementdate=$row['laststatementdate'];
   	$this->log->showLog(4,"BankReconcilation->fetchBankReconcilation,database fetch into class successfully");
	$this->log->showLog(4,"bankreconcilation_name:$this->bankreconcilation_name");

	$this->log->showLog(4,"reuse:$this->reuse");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"BankReconcilation->fetchBankReconcilation,failed to fetch data into databases:" . mysql_error(). ":$sql");	
	}
  } // end of member function fetchBankReconcilation

  /**
   * Delete particular bankreconcilation id
   *
   * @param int bankreconcilation_id 
   * @return bool
   * @access public
   */
  public function deleteBankReconcilation( $bankreconcilation_id ) {
    	$this->log->showLog(2,"Warning: Performing delete bankreconcilation id : $bankreconcilation_id !");
	$sql="DELETE FROM $this->tablebankreconcilation where bankreconcilation_id=$bankreconcilation_id";
	$sql2="UPDATE $this->tabletransaction set bankreconcilation_id=0 where bankreconcilation_id=$bankreconcilation_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql * SQL2: $sql2");
	
	$rs=$this->xoopsDB->query($sql);
	$rs2=$this->xoopsDB->query($sql2);
	if (!$rs2 && !$rs){
		$this->log->showLog(1,"Error: bankreconcilation ($bankreconcilation_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"bankreconcilation ($bankreconcilation_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteBankReconcilationts

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllBankReconcilation( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductBankReconcilation->getSQLStr_AllBankReconcilation: $sql");
	global $defaultorganization_id;
    $sql="SELECT br.bankreconcilation_id,br.organization_id,br.accounts_id,br.bankreconcilationno,br.bankreconcilationdate,br.iscomplete,
		br.statementbalance,br.laststatementbalance,p.period_name,a.accounts_name,br.reconcilamt,br.unreconcilamt
	FROM $this->tablebankreconcilation br
	INNER JOIN $this->tableperiod p on p.period_id=br.period_id
	INNER JOIN $this->tableaccounts a on a.accounts_id=br.accounts_id
	WHERE 1 $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showbankreconcilationtable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllBankReconcilation

 public function showBankReconcilationTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing BankReconcilation Table");
	$sql=$this->getSQLStr_AllBankReconcilation($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<TABLE border=1><TBODY><TR><TH>Reconcilation No</TH>
		<TH>Statement Date</TH><TH>Account</TH><TH>Period</TH>
		<th>Unreconciled</th><th>Reconciled</th><th>Statement Balance</th><TH>Complete</TH><TH>Preview</TH></TR>

EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$bankreconcilation_id=$row['bankreconcilation_id'];
		$bankreconcilationdate=$row['bankreconcilationdate'];
		$iscomplete=$row['iscomplete'];
		$reconcilamt=$row['reconcilamt'];
		$accounts_name=$row['accounts_name'];
		$period_name=$row['period_name'];

		$unreconcilamt=$row['unreconcilamt'];
		$statementbalance=$row['statementbalance'];
		$bankreconcilationdate=$row['bankreconcilationdate'];
		$accounts_id=$row['accounts_id'];
		$bankreconcilationno=$row['bankreconcilationno'];


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

		if($iscomplete == 1)
		$iscomplete = "Y";
		else
		$iscomplete = "N";
		echo <<< EOF
			<TR>
				<TD class="$rowtype"><A href="bankreconcilation.php?action=edit&bankreconcilation_id=$bankreconcilation_id" >
					$bankreconcilationno
				</A></TD>
				<TD class="$rowtype">$bankreconcilationdate</TD>
				<td class="$rowtype">$accounts_name</td>
				<td class="$rowtype">$period_name</td>
				<td class="$rowtype">$unreconcilamt</td>
				<td class="$rowtype">$reconcilamt</td>
				<td class="$rowtype">$statementbalance</td>
				<td class="$rowtype">$iscomplete</td>
				<td class="$rowtype" style="text-align:center">
                                    <a href="viewbankreconcilationreport.php?submit=1&bankreconcilation_id=$bankreconcilation_id" target="_blank">
                                        <img src='images/list.gif'></a></td>
			</TR>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestBankReconcilationID() {
	$sql="SELECT MAX(bankreconcilation_id) as bankreconcilation_id from $this->tablebankreconcilation;";
	$this->log->showLog(3,'Checking latest created bankreconcilation_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created bankreconcilation_id:' . $row['bankreconcilation_id']);
		return $row['bankreconcilation_id'];
	}
	else
	return -1;
	
  } // end

  public function getNextBankReconcilationID() {
	$sql="SELECT MAX(bankreconcilation_id) as bankreconcilation_id from $this->tablebankreconcilation;";
	$this->log->showLog(3,'Checking latest created bankreconcilation_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created bankreconcilation_id:' . $row['bankreconcilation_id']);
		return $row['bankreconcilation_id']+1;
	}
	else
	return 1;
	
  } // end


 public function allowDelete($bankreconcilation_id){
	/*$sql="SELECT count(bpartner_id) as rowcount from $this->tablebpartner where bpartner_bankreconcilation_id=$bankreconcilation_id";
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
$addnewctrl="<a href='bankreconcilation.php'>[ Add New ]</a>";

$isselectedNull = "";
$isselectedYes = "";
$isselectedNo = "";
if($this->iscomplete == "1")
$isselectedYes = "selected";
else if($this->iscomplete == "0")
$isselectedNo = "selected";
else
$isselectedNull = "selected";

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
      <th colspan="4">Search Bank Reconcilation</th>
    </tr>
    <tr>
      <td class='head'>Date From</td><form method='POST'>
      <td class='even'><input id='bankreconcilationdatefrom' name='bankreconcilationdatefrom' value="$this->bankreconcilationdatefrom" size="10">
		<input type='button' onclick="$this->showcalendarfrom" value='Date'></td>
      <td class='head'>Date To</td>
      <td class='even'><input id='bankreconcilationdateto' name='bankreconcilationdateto' value="$this->bankreconcilationdateto" size="10">
		<input type='button' onclick="$this->showcalendarto" value='Date'></td>
    </tr>
    <tr>
      <td class='head'>Bank Reconcilation No (100%, %10,%1001%)</td>
      <td class='even'><input name='bankreconcilationno' value='$this->bankreconcilationno'></td>
      <td class='head'>Account</td>
	<td class='even' >$this->accountsctrl</td>
    </tr>

<tr>
	
	<td class='head'>Period</td>
	<td class='even' >$this->periodctrl</td>
	<td class='head'>Complete</td>
	<td class='even' acolspan="3">
	<select name="iscomplete">
	<option value="" $isselectedNull>Null</option>
	<option value="1" $isselectedYes>Yes</option>
	<option value="0" $isselectedNo>No</option>
	</select>
	</td>
</tr>


    <tr>
      <td><input type='reset' name='reset' value='Reset'></td>
      <td colspan="3"><input type='submit' name='btnSearch' value='Search'><input type='hidden' name='action' value='search'></td>
    </tr>
	

  </tbody>
</table>

EOF;
  }



  public function genWhereString($datefrom,$dateto,$bankreconcilationno,$accounts_id,$period_id,$iscomplete){
//	$this->log->showLog(3,"generate wherestring $datefrom,$dateto,$bankreconcilationno,$bankreconcilation_name");
	if($datefrom=="")
		$datefrom="0000-00-00";
	if($dateto=="")
		$dateto="9999-12-31";

	$wherestring=" and br.bankreconcilationdate between '$datefrom' and '$dateto' AND";

	if($bankreconcilationno<>"")
		$wherestring=$wherestring. " br.bankreconcilationno LIKE '$bankreconcilationno' AND";

	if($accounts_id > 0)
		$wherestring=$wherestring. " br.accounts_id = $accounts_id AND";

	if($period_id > 0)
		$wherestring=$wherestring. " br.period_id = $period_id AND";

	if($iscomplete !="")
		$wherestring=$wherestring. " br.iscomplete = $iscomplete AND";
	

	$wherestring=substr_replace($wherestring,"",-3);
	$this->log->showLog(3,"generate wherestring: $wherestring");
	return $wherestring;

  }

  public function genChildList($accounts_id,$bankreconcilation_id,$iscomplete=0){
	global $defaultorganization_id;
	$result='<table><tbody><tr><TH>No</th><TH>Cheque No</th><TH>Batch No</TH><TH>Batch Date</TH><TH>Debit</th><TH>Credit</TH><TH>Confirm</TH></tr>';

	if($bankreconcilation_id==0)
		$wherestr="";
	else
		$wherestr=" OR t.bankreconcilation_id=$bankreconcilation_id";

	if($iscomplete==1)
		$wherestr="t.bankreconcilation_id=$bankreconcilation_id";
	else
		$wherestr="t.bankreconcilation_id=$bankreconcilation_id or t.bankreconcilation_id=0";

	//while
        /*
	$sql="SELECT t.trans_id,t.document_no2, t.batch_id, t.amt, t.bankreconcilation_id,
		b.batchno,b.batchdate
	FROM $this->tabletransaction t
	INNER JOIN $this->tablebatch b on t.batch_id=b.batch_id 
	where b.organization_id=$defaultorganization_id and ($wherestr)
		 AND t.accounts_id=$accounts_id and b.iscomplete=1 order by b.batchdate,b.batchno";
         *
         */

        $sql="SELECT t.trans_id,t.document_no2, t.batch_id, t.amt, t.bankreconcilation_id,
		b.batchno,b.batchdate
	FROM $this->tabletransaction t
	INNER JOIN $this->tablebatch b on t.batch_id=b.batch_id
	where 1 and ($wherestr)
		 AND t.accounts_id=$accounts_id and b.iscomplete=1 order by b.batchdate,b.batchno";

	$this->log->showLog(4,"genChildList with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$document_no=$row['document_no2'];
	$batch_id=$row['batch_id'];
	$trans_id=$row['trans_id'];
	$amt=$row['amt'];
	$batchno=$row['batchno'];
	$batchdate=$row['batchdate'];
	$transtype=$row['transtype'];
	$bankreconcilation_id=$row['bankreconcilation_id'];
	if($bankreconcilation_id>0)
		$checked='CHECKED';
	else
		$checked='';

	if($amt>=0){
		$debitamt=$amt;
		$creditamt="";
	}
	else{
		$debitamt="";
		$creditamt=$amt * -1;

	}

	$j=$i+1;
	
		$result=$result."<TR><td>$j <input name='linetrans_id[$i]' value='$trans_id' type='hidden'></td><td>$document_no</td><td><A href='batch.php?action=edit&batch_id=$batch_id'>$batchno</A> </td><td>$batchdate</td><td>$debitamt</td><td>$creditamt</td><td><input name='linechecked[$i]' id='linecheck$i' $checked type='checkbox' onchange='calculateBalance();'><input atype='hidden' name='lineamt[$i]' value='$amt' id='lineamt$i'></td></TR>";
		$i++;
	}
	$result=$result."</tbody></table><input id='linecount' name='linecount' value='$i' type='hidden'>";
	return $result;
	}

  public function getLastStatementInfo($accounts_id){
	
	$sql="SELECT bankreconcilationdate,statementbalance FROM $this->tablebankreconcilation where accounts_id=$accounts_id and iscomplete=1 
		order by bankreconcilationdate DESC,bankreconcilation_id desc";
	$this->log->showLog(4,"getLastStatementInfo with SQL: $sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	
	$this->laststatementdate=$row['bankreconcilationdate'];
	$this->laststatementbalance=$row['statementbalance'];
	return true;
	 }
	return false;
	}

} // end of ClassBankReconcilation

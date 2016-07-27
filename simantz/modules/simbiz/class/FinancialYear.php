<?php


class FinancialYear
{

  public $financialyear_id;
  public $financialyear_name;
  public $organization_id;
  
  public $periodqty;
  public $description;
  public $defaultlevel;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tablefinancialyear;
  private $tablebpartner;

  private $log;


//constructor
   public function FinancialYear(){
	global $xoopsDB,$log,$tablefinancialyear,$tablefinancialyearline,$tablebpartner,$tablebpartnergroup,$tableorganization,
		$tableaccounts,$tableperiod;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tableperiod=$tableperiod;

	$this->tablefinancialyear=$tablefinancialyear;
	$this->tablefinancialyearline=$tablefinancialyearline;
	$this->tableaccounts=$tableaccounts;
	$this->tablebpartner=$tablebpartner;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int financialyear_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $financialyear_id,$token  ) {
		global $mandatorysign;

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Financial Year";
		$action="create";
	 	
		if($financialyear_id==0){
			$this->financialyear_name="";
			$this->periodqty=0;
			$this->defaultlevel=10;
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
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
		"<input name='tablename' value='$this->tablefinancialyear' type='hidden'>".
		"<input name='id' value='$this->financialyear_id' type='hidden'>".
		"<input name='idname' value='financialyear_id' type='hidden'>".
		"<input name='title' value='Financial Year' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		}
				//force periodqty checkbox been checked if the value in db is 'Y'
		
	
		$header="Edit Financial Year";
		
		
		
		
		$addnewctrl="<Form action='financialyear.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	//	if($this->isclosed==1){
	//		$status="This financial year is <strong>closed</strong> <b style='color:red'>If you want to reopen this financial year, you shall reactivate the batch you'd posted(credit 320-Retain Earning and debit 810-Retain Earning(Reverse Entry)).</b> ";
			$savectrl="";
		//if($this->isAdmin)

		//$closectrl="<input type='submit' onclick='isclosed.value=-1;' name='btnClose' value='Re-activate This Financial Year'>
		//	<input name='financialyear_id' value='$this->financialyear_id' type='hidden'>";
	//	$deletectrl="";
	//	}
	//	else{
		//$status="This financial year is <strong>open</strong>.  <b style='color:red'>Before complete this financial year create a batch to post retain earning(credit 320-Retain Earning and debit 810-Retain Earning(Reverse Entry)). Otherwise the balance sheet will not balance.</b>";
		if($this->isAdmin)
		$savectrl="<input name='financialyear_id' value='$this->financialyear_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		//
		//$closectrl="<input type='submit' onclick='isclosed.value=1;' name='btnClose' value='Close This Financial Year'>";
		//$deletectrl="<FORM action='financialyear.php' method='POST' onSubmit='return confirm(".
		//'"confirm to remove this financialyear?"'.")'><input type='submit' value='Delete' name='submit'>".
		//"<input type='hidden' value='$this->financialyear_id' name='financialyear_id'>".
		//"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		//}

	}

    echo <<< EOF
<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateFinancialYear()" method="post"
 action="financialyear.php" name="frmFinancialYear"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl</td>
   	<td class="head">Name (YYYY)</td>
        <td class="even" ><input maxlength="4" size="4" name="financialyear_name" value="$this->financialyear_name"></td>
      </tr>
      <tr>
        <td class="head">Period Qty</td>
       <td class="odd" ><input name="periodqty" id='periodqty' value="$this->periodqty" readonly='readonly' size='2' maxlength='2'> Max 18 months
   	<td class="head">Default Level $mandatorysign</td>
	        <td class="odd" ><input maxlength="3" size="3" name='defaultlevel' value="$this->defaultlevel">
	</td>
      </tr>
 <tr>
        <td class="head">Add Period Range</td>
        <td class="even">$this->periodfromctrl to $this->periodtoctrl</td>
        <td class="head">Description</td>
        <td class="even"><input maxlength="70" size="50" name="description" value="$this->description"></td>
      </tr>
	$this->periodtable
    
       <tr style="display:none">
        <td class="head">Status</td>
        <td class="odd" colspan='3'>$status <input type='hidden' name='isclosed' value="$this->isclosed"></td>
      </tr>
    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$savectrl </td><td>$closectrl</td>
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td><td>$recordctrl</td></tbody></table>
  <br>



EOF;
  } // end of member function getInputForm

  /**
   * Update existing financialyear record
   *
   * @return bool
   * @access public
   */
  public function updateFinancialYear( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablefinancialyear SET 
	financialyear_name=$this->financialyear_name,description='$this->description',
	updated='$timestamp',updatedby=$this->updatedby,periodqty=$this->periodqty,defaultlevel=$this->defaultlevel,
	organization_id=$this->organization_id,
	isclosed=$this->isclosed WHERE financialyear_id='$this->financialyear_id'";
	
	$this->log->showLog(3, "Update financialyear_id: $this->financialyear_id, $this->financialyear_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update financialyear failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update financialyear successfully.");
		return true;
	}
  } // end of member function updateFinancialYear

  /**
   * Save new financialyear into database
   *
   * @return bool
   * @access public
   */
  public function insertFinancialYear( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new financialyear $this->financialyear_name");
 	$sql="INSERT INTO $this->tablefinancialyear (financialyear_name,periodqty, created,createdby,
	updated,updatedby,defaultlevel,organization_id,description,isclosed) values(
	$this->financialyear_name,'$this->periodqty','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->defaultlevel,$this->organization_id,'$this->description',0)";

	$this->log->showLog(4,"Before insert financialyear SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert financialyear code $financialyear_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new financialyear $financialyear_name successfully");

		return true;
	}
  } // end of member function insertFinancialYear

  /**
   * Pull data from financialyear table into class
   *
   * @return bool
   * @access public
   */
  public function fetchFinancialYear( $financialyear_id) {


	$this->log->showLog(3,"Fetching financialyear detail into class FinancialYear.php.<br>");
		
	$sql="SELECT financialyear_id,financialyear_name,periodqty,defaultlevel,organization_id,description,
		isclosed from $this->tablefinancialyear where financialyear_id=$financialyear_id";
	
	$this->log->showLog(4,"ProductFinancialYear->fetchFinancialYear, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->financialyear_name=$row["financialyear_name"];
		$this->organization_id=$row['organization_id'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->periodqty=$row['periodqty'];
		$this->isclosed=$row['isclosed'];

		$this->description=$row['description'];
   	$this->log->showLog(4,"FinancialYear->fetchFinancialYear,database fetch into class successfully");
	$this->log->showLog(4,"financialyear_name:$this->financialyear_name");

	$this->log->showLog(4,"periodqty:$this->periodqty");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"FinancialYear->fetchFinancialYear,failed to fetch data into databases:" . mysql_error(). ":$sql");	
	}
  } // end of member function fetchFinancialYear

  /**
   * Delete particular financialyear id
   *
   * @param int financialyear_id 
   * @return bool
   * @access public
   */
  public function deleteFinancialYear( $financialyear_id ) {
    	$this->log->showLog(2,"Warning: Performing delete financialyear id : $financialyear_id !");
	$sql="DELETE FROM $this->tablefinancialyear where financialyear_id=$financialyear_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: financialyear ($financialyear_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"financialyear ($financialyear_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteFinancialYear

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllFinancialYear( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductFinancialYear->getSQLStr_AllFinancialYear: $sql");

    $sql="SELECT f.financialyear_name,f.financialyear_id,f.periodqty,f.organization_id,f.defaultlevel,
		f.isclosed,f.description
		 FROM $this->tablefinancialyear  f
		 $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showfinancialyeartable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllFinancialYear

 public function showFinancialYearTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing FinancialYear Table");
	$sql=$this->getSQLStr_AllFinancialYear($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Financial Year Name</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Default Level</th>

				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$financialyear_id=$row['financialyear_id'];
		$financialyear_name=$row['financialyear_name'];
		$periodfrom=$row['periodfrom'];
		$periodto=$row['periodto'];
		$isclosed=$row['isclosed'];
                $description=$row['description'];
		$defaultlevel=$row['defaultlevel'];
		$periodqty=$row['periodqty'];
		
		/*if($periodqty==0)
		{$periodqty='N';
		$periodqty="<b style='color:red;'>$periodqty</b>";
		}
		else
		$periodqty='Y';
                 * 
                 */
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
	if($isclosed==1)
		$status="<strong>closed</strong>";
	else
		$status="<strong>open</strong>";

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$financialyear_name</td>
			<td class="$rowtype" style="text-align:center;">$description</td>
			<td class="$rowtype" style="text-align:center;">$defaultlevel</td>

			<td class="$rowtype" style="text-align:center;">
				<form action="financialyear.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this financialyear'>
				<input type="hidden" value="$financialyear_id" name="financialyear_id">
				<input type="hidden" name="action" value="edit">
				</form>
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
  public function getLatestFinancialYearID() {
	$sql="SELECT MAX(financialyear_id) as financialyear_id from $this->tablefinancialyear;";
	$this->log->showLog(3,'Checking latest created financialyear_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created financialyear_id:' . $row['financialyear_id']);
		return $row['financialyear_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablefinancialyear;";
	$this->log->showLog(3,'Checking next defaultlevel');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found next defaultlevel:' . $row['defaultlevel']);
		return  $row['defaultlevel'];
	}
	else
	return 10;
	
  } // end

 public function allowDelete($financialyear_id){
		return true;	
	}

  public function closeYear(){

	}

  public function reOpenYear(){

	}

  public function isValid($periodfrom_id,$periodto_id){
//
	return true;
	}

  public function insertPeriodInYear($periodfrom_id,$periodto_id){

	}



  public function getPeriodRange($financialyear_id){


	$sql="SELECT period_id FROM $this->tablefinancialyearline where financialyear_id=$financialyear_id";

	$this->log->showLog(3,"getPeriodRange with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	$result="";
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	if($i==0)
	 $result=$row['period_id'];
	else
	 $result=$result.",".$row['period_id'];

	$i++;
	}
	//$result=substr_replace($result,'',-1);
	return $result;
  }
} // end of ClassFinancialYear
?>

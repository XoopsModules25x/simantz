<?php


/**
 * class ProductSocso
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class Socso
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $socso_id;
  public $amtfrom;
  public $amtto;

  public $employee_amt;
  public $employer_amt;
  public $employer_amt2;

  public $totalamt;
  public $created;
  public $createdby;
  public $updated;
  public $orgctrl;
  public $updatedby;
  private $xoopsDB;
  public $cur_name;
  public $cur_symbol;
  private $tableprefix;
  private $tableorganization;
  private $tablesocso;
  private $tablestudent;
  private $log;


//constructor
   public function Socso($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tablestudent=$tableprefix . "simtrain_student";
	$this->tablesocso=$tableprefix."simtrain_socsotable";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int socso_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $socso_id,$token  ) {
	
	$mandatorysign="<b style='color:red'>*</b>";
    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Socso";
		$action="create";
	 	
		if($socso_id==0){
			$this->amtfrom="0.00";
			$this->amtto="0.00";
			$this->employee_amt="0.00";
			$this->employer_amt="0.00";
			$this->employer_amt2="0.00";
			$this->totalamt="0.00";
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";


	}
	else
	{
		
		$action="update";
		$savectrl="<input name='socso_id' value='$this->socso_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablesocso' type='hidden'>".
		"<input name='id' value='$this->socso_id' type='hidden'>".
		"<input name='idname' value='socso_id' type='hidden'>".
		"<input name='title' value='Socso' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		$header="Edit Socso";
		
		if( $this->socso_id>0)
		$deletectrl="<FORM action='socso.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this socso?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->socso_id' name='socso_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='socso.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Socso Master Table</span></big></big></big></div><br>-->

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateSocso()" method="post"
 action="socso.php" name="frmSocso"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
        <tr>
        <td class="head">Amount From ($this->cur_symbol) $mandatorysign</td>
        <td class="odd"><input maxlength="12" size="12" name="amtfrom" value="$this->amtfrom"></td>
        <td class="head">Amount To ($this->cur_symbol) $mandatorysign</td>
        <td class="odd"><input maxlength="12" size="12" name="amtto" value="$this->amtto"></td></td>
      </tr>
      <tr>
        <td class="head">Employer Amount 1 ($this->cur_symbol) $mandatorysign</td>
        <td class="even"><input maxlength="12" size="12" name="employer_amt" value="$this->employer_amt"></td>
        <td class="head">Employer Amount 2 ($this->cur_symbol) $mandatorysign</td>
        <td class="even"><input maxlength="12" size="12" name="employer_amt2" value="$this->employer_amt2"></td>
      </tr>
     <tr>
        <td class="head">Employee Amount ($this->cur_symbol) $mandatorysign</td>
        <td class="odd"><input maxlength="12" size="12" name="employee_amt" value="$this->employee_amt"></td>
        <td class="head">Total Amount ($this->cur_symbol) $mandatorysign</td>
        <td class="odd"><input maxlength="12" size="12" name="totalamt" value="$this->totalamt"></td>
      </tr>
    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td></tbody></table>
  <br>

$recordctrl

EOF;
  } // end of member function getInputForm

  /**
   * Update existing socso record
   *
   * @return bool
   * @access public
   */
  public function updateSocso( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablesocso SET amtto=$this->amtto,amtfrom=$this->amtfrom,
	updated='$timestamp',updatedby=$this->updatedby,employee_amt=$this->employee_amt,
	employer_amt=$this->employer_amt,employer_amt2=$this->employer_amt2,totalamt=$this->totalamt
	WHERE socso_id='$this->socso_id'";
	
	$this->log->showLog(3, "Update socso_id: $this->socso_id, $this->amtfrom");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update socso failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update socso successfully.");
		return true;
	}
  } // end of member function updateSocso

  /**
   * Save new socso into database
   *
   * @return bool
   * @access public
   */
  public function insertSocso( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new socso $this->amtfrom");
 	$sql="INSERT INTO $this->tablesocso (amtto,amtfrom
	,employee_amt, created,createdby,updated,updatedby,employer_amt,employer_amt2,totalamt) values(
	'$this->amtto','$this->amtfrom','$this->employee_amt','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->employer_amt,$this->employer_amt2,$this->totalamt)";
	$this->log->showLog(4,"Before insert socso SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert socso code $amtfrom");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new socso $amtfrom successfully"); 
		return true;
	}
  } // end of member function insertSocso

  /**
   * Pull data from socso table into class
   *
   * @return bool
   * @access public
   */
  public function fetchSocso( $socso_id) {
    
	$this->log->showLog(3,"Fetching socso detail into class Socso.php.<br>");
		
	$sql="SELECT socso_id,amtfrom,amtto,employee_amt,employer_amt,employer_amt2,totalamt from $this->tablesocso
			where socso_id=$socso_id";
	
	$this->log->showLog(4,"ProductSocso->fetchSocso, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->employer_amt=$row["employer_amt"];
		$this->amtfrom=$row["amtfrom"];
		$this->amtto= $row['amtto'];
		$this->employee_amt=$row['employee_amt'];
		$this->employer_amt2=$row['employer_amt2'];
		$this->totalamt=$row['totalamt'];
		$this->socso_id=$row['socso_id'];

   	$this->log->showLog(4,"Socso->fetchSocso,database fetch into class successfully");
	$this->log->showLog(4,"employer_amt:$this->employer_amt");
	$this->log->showLog(4,"amtfrom:$this->amtfrom");
	$this->log->showLog(4,"amtto:$this->amtto");
	$this->log->showLog(4,"employee_amt:$this->employee_amt");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Socso->fetchSocso,failed to fetch data into databases.");	
	}
  } // end of member function fetchSocso

  /**
   * Delete particular socso id
   *
   * @param int socso_id 
   * @return bool
   * @access public
   */
  public function deleteSocso( $socso_id ) {
    	$this->log->showLog(2,"Warning: Performing delete socso id : $socso_id !");
	$sql="DELETE FROM $this->tablesocso where socso_id=$socso_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: socso ($socso_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"socso ($socso_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteSocso

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllSocso( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running ProductSocso->getSQLStr_AllSocso: $sql");
    $sql="SELECT amtfrom,amtto,socso_id,employee_amt,employer_amt,employer_amt2,totalamt FROM $this->tablesocso " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showSocsoTable with sql:$sql");

  return $sql;
  } // end of member function getSQLStr_AllSocso

 public function showSocsoTable(){
	
	$this->log->showLog(3,"Showing Socso Table");
	$sql=$this->getSQLStr_AllSocso("WHERE socso_id>0","ORDER BY amtfrom",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">From</th>
				<th style="text-align:center;">To</th>
				<th style="text-align:center;">Employer 1 ($this->cur_symbol)</th>
				<th style="text-align:center;">Employer 2 ($this->cur_symbol)</th>
				<th style="text-align:center;">Employee ($this->cur_symbol)</th>
				<th style="text-align:center;">Total ($this->cur_symbol)</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$socso_id=$row['socso_id'];
		$amtfrom=$row['amtfrom'];
		$amtto=$row['amtto'];
		$employer_amt=$row['employer_amt'];
		$employee_amt=$row['employee_amt'];
		$employer_amt2=$row['employer_amt2'];
		$totalamt=$row['totalamt'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$amtfrom</td>
			<td class="$rowtype" style="text-align:center;">$amtto</td>
			<td class="$rowtype" style="text-align:center;">$employer_amt</td>
			<td class="$rowtype" style="text-align:center;">$employer_amt2</td>
			<td class="$rowtype" style="text-align:center;">$employee_amt</td>
			<td class="$rowtype" style="text-align:center;">$totalamt</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="socso.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this socso'>
				<input type="hidden" value="$socso_id" name="socso_id">
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
  public function getLatestSocsoID() {
	$sql="SELECT MAX(socso_id) as socso_id from $this->tablesocso;";
	$this->log->showLog(3,'Checking latest created socso_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created socso_id:' . $row['socso_id']);
		return $row['socso_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectSocso($id,$showNull='N',$ctrlname="socso_id") {
	$this->log->showLog(4,"getSelectSocso with id= $id");
	$sql="SELECT socso_id,amtfrom from $this->tablesocso where (employee_amt='Y' or socso_id=$id) and socso_id>0 order by amtfrom ;";
	$selectctl="<SELECT name='$ctrlname' >";
	if ( $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"> Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$socso_id=$row['socso_id'];
		$amtfrom=$row['amtfrom'];
	
		if($id==$socso_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$socso_id' $selected>$amtfrom</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

} // end of ClassSocso
?>

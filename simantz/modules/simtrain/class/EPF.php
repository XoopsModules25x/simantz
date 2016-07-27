<?php


/**
 * class ProductEPF
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class EPF
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $epf_id;
  public $amtfrom;
  public $amtto;

  public $employee_amt;
  public $employer_amt;
  public $employee_amt2;

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
  private $tableepf;
  private $tablestudent;
  private $log;


//constructor
   public function EPF($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tablestudent=$tableprefix . "simtrain_student";
	$this->tableepf=$tableprefix."simtrain_epftable";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int epf_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $epf_id,$token  ) {
	
	$mandatorysign="<b style='color:red'>*</b>";
    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New EPF";
		$action="create";
	 	
		if($epf_id==0){
			$this->amtfrom="0.00";
			$this->amtto="0.00";
			$this->employee_amt="0.00";
			$this->employer_amt="0.00";
			$this->employee_amt2="0.00";
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
		$savectrl="<input name='epf_id' value='$this->epf_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableepf' type='hidden'>".
		"<input name='id' value='$this->epf_id' type='hidden'>".
		"<input name='idname' value='epf_id' type='hidden'>".
		"<input name='title' value='EPF' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		$header="Edit EPF";
		
		if( $this->epf_id>0)
		$deletectrl="<FORM action='epf.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this epf?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->epf_id' name='epf_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='epf.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">EPF Master Table</span></big></big></big></div><br>-->

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateEPF()" method="post"
 action="epf.php" name="frmEPF"><input name="reset" value="Reset" type="reset"></td></tbody></table>

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
        <td class="head">Employee 8% ($this->cur_symbol) $mandatorysign</td>
        <td class="even"><input maxlength="12" size="12" name="employee_amt" value="$this->employee_amt"></td>
        <td class="head">Employee 11% ($this->cur_symbol) $mandatorysign</td>
        <td class="even"><input maxlength="12" size="12" name="employee_amt2" value="$this->employee_amt2"></td>
      </tr>
     <tr>
        <td class="head">Employer Amount ($this->cur_symbol) $mandatorysign</td>
        <td class="odd"><input maxlength="12" size="12" name="employer_amt" value="$this->employer_amt"></td>
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
   * Update existing epf record
   *
   * @return bool
   * @access public
   */
  public function updateEPF( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableepf SET amtto=$this->amtto,amtfrom=$this->amtfrom,
	updated='$timestamp',updatedby=$this->updatedby,employee_amt=$this->employee_amt,
	employer_amt=$this->employer_amt,employee_amt2=$this->employee_amt2,totalamt=$this->totalamt
	WHERE epf_id='$this->epf_id'";
	
	$this->log->showLog(3, "Update epf_id: $this->epf_id, $this->amtfrom");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update epf failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update epf successfully.");
		return true;
	}
  } // end of member function updateEPF

  /**
   * Save new epf into database
   *
   * @return bool
   * @access public
   */
  public function insertEPF( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new epf $this->amtfrom");
 	$sql="INSERT INTO $this->tableepf (amtto,amtfrom
	,employee_amt, created,createdby,updated,updatedby,employer_amt,employee_amt2,totalamt) values(
	'$this->amtto','$this->amtfrom','$this->employee_amt','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->employer_amt,$this->employee_amt2,$this->totalamt)";
	$this->log->showLog(4,"Before insert epf SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert epf code $amtfrom");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new epf $amtfrom successfully"); 
		return true;
	}
  } // end of member function insertEPF

  /**
   * Pull data from epf table into class
   *
   * @return bool
   * @access public
   */
  public function fetchEPF( $epf_id) {
    
	$this->log->showLog(3,"Fetching epf detail into class EPF.php.<br>");
		
	$sql="SELECT epf_id,amtfrom,amtto,employee_amt,employer_amt,employee_amt2,totalamt from $this->tableepf
			where epf_id=$epf_id";
	
	$this->log->showLog(4,"ProductEPF->fetchEPF, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->employer_amt=$row["employer_amt"];
		$this->amtfrom=$row["amtfrom"];
		$this->amtto= $row['amtto'];
		$this->employee_amt=$row['employee_amt'];
		$this->employee_amt2=$row['employee_amt2'];
		$this->totalamt=$row['totalamt'];
		$this->epf_id=$row['epf_id'];

   	$this->log->showLog(4,"EPF->fetchEPF,database fetch into class successfully");
	$this->log->showLog(4,"employer_amt:$this->employer_amt");
	$this->log->showLog(4,"amtfrom:$this->amtfrom");
	$this->log->showLog(4,"amtto:$this->amtto");
	$this->log->showLog(4,"employee_amt:$this->employee_amt");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"EPF->fetchEPF,failed to fetch data into databases.");	
	}
  } // end of member function fetchEPF

  /**
   * Delete particular epf id
   *
   * @param int epf_id 
   * @return bool
   * @access public
   */
  public function deleteEPF( $epf_id ) {
    	$this->log->showLog(2,"Warning: Performing delete epf id : $epf_id !");
	$sql="DELETE FROM $this->tableepf where epf_id=$epf_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: epf ($epf_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"epf ($epf_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteEPF

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllEPF( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running ProductEPF->getSQLStr_AllEPF: $sql");
    $sql="SELECT amtfrom,amtto,epf_id,employee_amt,employer_amt,employee_amt2,totalamt FROM $this->tableepf " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showEPFTable with sql:$sql");

  return $sql;
  } // end of member function getSQLStr_AllEPF

 public function showEPFTable(){
	
	$this->log->showLog(3,"Showing EPF Table");
	$sql=$this->getSQLStr_AllEPF("WHERE epf_id>0","ORDER BY amtfrom",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">From</th>
				<th style="text-align:center;">To</th>
				<th style="text-align:center;">Employee 8% ($this->cur_symbol)</th>
				<th style="text-align:center;">Employee 11% ($this->cur_symbol)</th>
				<th style="text-align:center;">Employer ($this->cur_symbol)</th>
				<th style="text-align:center;">Total ($this->cur_symbol)</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$epf_id=$row['epf_id'];
		$amtfrom=$row['amtfrom'];
		$amtto=$row['amtto'];
		$employer_amt=$row['employer_amt'];
		$employee_amt=$row['employee_amt'];
		$employee_amt2=$row['employee_amt2'];
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
			<td class="$rowtype" style="text-align:center;">$employee_amt</td>
			<td class="$rowtype" style="text-align:center;">$employee_amt2</td>
			<td class="$rowtype" style="text-align:center;">$employer_amt</td>
			<td class="$rowtype" style="text-align:center;">$totalamt</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="epf.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this epf'>
				<input type="hidden" value="$epf_id" name="epf_id">
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
  public function getLatestEPFID() {
	$sql="SELECT MAX(epf_id) as epf_id from $this->tableepf;";
	$this->log->showLog(3,'Checking latest created epf_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created epf_id:' . $row['epf_id']);
		return $row['epf_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectEPF($id,$showNull='N',$ctrlname="epf_id") {
	$this->log->showLog(4,"getSelectEPF with id= $id");
	$sql="SELECT epf_id,amtfrom from $this->tableepf where (employee_amt='Y' or epf_id=$id) and epf_id>0 order by amtfrom ;";
	$selectctl="<SELECT name='$ctrlname' >";
	if ( $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"> Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$epf_id=$row['epf_id'];
		$amtfrom=$row['amtfrom'];
	
		if($id==$epf_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$epf_id' $selected>$amtfrom</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

 
} // end of ClassEPF
?>

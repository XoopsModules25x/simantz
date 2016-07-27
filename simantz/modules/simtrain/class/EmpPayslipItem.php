<?php

/**
 * class ProductEmpPayslipItem
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class EmpPayslipItem
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $emppayslipitem_id;
  public $emppayslipitem_name;

  public $emppayslipitem_description;
  public $isactive;
  public $amount;
  public $employee_id;
  public $linetype;
  public $calc_epf;
  public $calc_socso;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $cur_name;
  public $cur_symbol;
  public $updatedby;
  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $tableemppayslipitem;
  private $tableemployee;
  private $tablestudent;
  private $log;


//constructor
   public function EmpPayslipItem($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tablestudent=$tableprefix . "simtrain_student";
	$this->tableemployee=$tableprefix . "simtrain_employee";

	$this->tableemppayslipitem=$tableprefix."simtrain_emppayslipitem";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int emppayslipitem_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $emppayslipitem_id,$token  ) {
	
	$mandatorysign="<b style='color:red'>*</b>";
    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	$select_i="";
	$select_d="";
	$select_o="";
	$checkedepf="";
	$checkedsocso="";

	if($this->calc_epf==1)
		$checkedepf='checked';
	else
		$checkedepf='';

	if($this->calc_socso==1)
		$checkedsocso='checked';
	else
		$checkedsocso='';

	if($this->linetype=='0'){
		$select_i="";
		$select_d="";
		$select_o="SELECTED='SELECTED'";

	}
	elseif($this->linetype=='-1'){
		$select_i="";
		$select_d="SELECTED='SELECTED'";
		$select_o="";
	}
	else{
		$select_i="SELECTED='SELECTED'";
		$select_d="";
		$select_o="";
	}

	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Payroll Item";
		$action="create";
	 	
		if($emppayslipitem_id==0){
			$this->emppayslipitem_name="";
			$this->emppayslipitem_description="";
			$this->isactive="";
			$this->amount=0;
		//	$this->organization_id;
			$this->seqno=$this->getNextSeqNo();
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";

		
	}
	else
	{
		
		$action="update";
		$savectrl="<input name='emppayslipitem_id' value='$this->emppayslipitem_id' type='hidden'>
			<input type='hidden' value='$this->employee_id' name='employee_id'>
			 <input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableemppayslipitem' type='hidden'>".
		"<input name='id' value='$this->emppayslipitem_id' type='hidden'>".
		"<input name='idname' value='emppayslipitem_id' type='hidden'>".
		"<input name='title' value='EmpPayslipItem' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

	
		$header="Edit Payroll Item";
		
		//if($this->allowDelete($this->emppayslipitem_id) && $this->emppayslipitem_id>0)
		$deletectrl="<FORM action='emppayslipitem.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this emppayslipitem?"'.")'><input type='submit' value='Delete' name='submit'>
		<input type='hidden' value='$this->emppayslipitem_id' name='emppayslipitem_id'>
		<input type='hidden' value='delete' name='action'>
		<input name='token' value='$token' type='hidden'>
		<input type='hidden' value='$this->employee_id' name='employee_id'>
		</form>";
		//else
		//$deletectrl="";
		$addnewctrl="<Form action='emppayslipitem.php' method='POST'>
			<input type='hidden' value='$this->employee_id' name='employee_id'>
			<input type='hidden' value='new' name='action'>
			<input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Employee Payroll Item</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td>
		<td><form action='employee.php' method='POST'>
			<input type='submit' value='Back To Employee Master'>
			<input type='hidden' value="$this->employee_id" name="employee_id">
			<input type='hidden' value="edit" name="action">

		</form>
		</td>
<td><form onsubmit="return validateEmpPayslipItem()" method="post"
 action="emppayslipitem.php" name="frmEmpPayslipItem"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
       <tr>
        <td class="head">Item Name $mandatorysign<input type='hidden' value='$this->employee_id' name='employee_id'></td>
        <td class="even" >
		<input maxlength="30" size="30" name="emppayslipitem_name" value="$this->emppayslipitem_name">
		Active <input type="checkbox" $checked name="isactive">
	<td class="head">Amount ($this->cur_symbol) $mandatorysign</td>
	<td class="even"><input value="$this->amount" name="amount"></td>
	</td>
      </tr>
     <tr>
	<td class="head">Calculate For EPF/Socso</td>
	<td class="odd"><input type="checkbox" $checkedepf name="calc_epf"> / 
			<input type="checkbox" $checkedsocso name="calc_socso"></td>
	<td class="head">Sequence No  $mandatorysign</td>
	<td class="odd"><input value="$this->seqno" name="seqno" size='3' maxlength='3'></td>
	</tr>
      <tr>
        <td class="head">Item Description</td>
        <td class="even"><textarea cols='60' rows='3'
		 name="emppayslipitem_description">$this->emppayslipitem_description</textarea>
	</td>
	<td class="head">Item Type</td>
	<td class="even">
		<select name='linetype'>
			<option value='1' $select_i>Income</option>
			<option value='-1' $select_d>Deduction</option>
			<option value='0' $select_o>Non Effect</option>

		</select>
		</td>
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
   * Update existing emppayslipitem record
   *
   * @return bool
   * @access public
   */
  public function updateEmpPayslipItem( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableemppayslipitem SET ".
	"emppayslipitem_description='$this->emppayslipitem_description',
	emppayslipitem_name='$this->emppayslipitem_name',
	amount=$this->amount,linetype=$this->linetype,calc_epf=$this->calc_epf,
	calc_socso=$this->calc_socso,seqno=$this->seqno,
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive'
	WHERE emppayslipitem_id='$this->emppayslipitem_id'";
	
	$this->log->showLog(3, "Update emppayslipitem_id: $this->emppayslipitem_id, $this->emppayslipitem_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update emppayslipitem failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update emppayslipitem successfully.");
		return true;
	}
  } // end of member function updateEmpPayslipItem

  /**
   * Save new emppayslipitem into database
   *
   * @return bool
   * @access public
   */
  public function insertEmpPayslipItem( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
 
 
	$this->log->showLog(3,"Inserting new emppayslipitem $this->emppayslipitem_name");
 	$sql="INSERT INTO $this->tableemppayslipitem (emppayslipitem_description,emppayslipitem_name
	,isactive, created,createdby,updated,updatedby,amount,employee_id,linetype,calc_epf,calc_socso,seqno)
	 values(
	'$this->emppayslipitem_description','$this->emppayslipitem_name',
	'$this->isactive','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->amount,$this->employee_id,$this->linetype,$this->calc_epf,	
	$this->calc_socso,$this->seqno)";
	$this->log->showLog(4,"Before insert emppayslipitem SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert emppayslipitem code $emppayslipitem_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new emppayslipitem $emppayslipitem_name successfully"); 
		return true;
	}
  } // end of member function insertEmpPayslipItem

  /**
   * Pull data from emppayslipitem table into class
   *
   * @return bool
   * @access public
   */
  public function fetchEmpPayslipItem( $emppayslipitem_id) {
    
	$this->log->showLog(3,"Fetching emppayslipitem detail into class EmpPayslipItem.php.<br>");
		
	$sql="SELECT emppayslipitem_id,emppayslipitem_name,emppayslipitem_description,isactive,
		amount,employee_id,linetype,calc_epf,calc_socso,seqno
		 from $this->tableemppayslipitem where emppayslipitem_id=$emppayslipitem_id";
	
	$this->log->showLog(4,"ProductEmpPayslipItem->fetchEmpPayslipItem, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->emppayslipitem_name=$row["emppayslipitem_name"];
		$this->emppayslipitem_description= $row['emppayslipitem_description'];
		$this->isactive=$row['isactive'];
		$this->amount=$row['amount'];
		$this->employee_id=$row['employee_id'];
		$this->linetype=$row['linetype'];
		$this->calc_epf=$row['calc_epf'];
		$this->calc_socso=$row['calc_socso'];
		$this->seqno=$row['seqno'];
   	$this->log->showLog(4,"EmpPayslipItem->fetchEmpPayslipItem,database fetch into class successfully");
	$this->log->showLog(4,"organization_id:$this->organization_id");
	$this->log->showLog(4,"emppayslipitem_name:$this->emppayslipitem_name");
	$this->log->showLog(4,"emppayslipitem_description:$this->emppayslipitem_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"epf/socso:$this->calc_epf $this->calc_socso");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"EmpPayslipItem->fetchEmpPayslipItem,failed to fetch data into databases.");	
	}
  } // end of member function fetchEmpPayslipItem

  /**
   * Delete particular emppayslipitem id
   *
   * @param int emppayslipitem_id 
   * @return bool
   * @access public
   */
  public function deleteEmpPayslipItem( $emppayslipitem_id ) {
    	$this->log->showLog(2,"Warning: Performing delete emppayslipitem id : $emppayslipitem_id !");
	$sql="DELETE FROM $this->tableemppayslipitem where emppayslipitem_id=$emppayslipitem_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: emppayslipitem ($emppayslipitem_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"emppayslipitem ($emppayslipitem_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteEmpPayslipItem

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllEmpPayslipItem( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running ProductEmpPayslipItem->getSQLStr_AllEmpPayslipItem: $sql");
    $sql="SELECT emppayslipitem_name,emppayslipitem_description,emppayslipitem_id,isactive,
	amount,employee_id,linetype,calc_epf,calc_socso,seqno 
	FROM $this->tableemppayslipitem " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showemppayslipitemtable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllEmpPayslipItem

 public function showEmpPayslipItemTable($wherestring,  $orderbystring){
	
	$this->log->showLog(3,"Showing EmpPayslipItem Table");
	$sql=$this->getSQLStr_AllEmpPayslipItem($wherestring,$orderbystring,0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Name</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Seq No</th>
				<th style="text-align:center;">Amount</th>
				<th style="text-align:center;">Socso</th>
				<th style="text-align:center;">EPF</th>

				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$emppayslipitem_id=$row['emppayslipitem_id'];
		$emppayslipitem_name=$row['emppayslipitem_name'];
		$emppayslipitem_description=$row['emppayslipitem_description'];
		$amount=$row['amount'];
		$seqno=$row['seqno'];
		if($row['calc_epf']==1)
			$calc_epf='Y';
		else
			$calc_epf='N';
		if($row['calc_socso']==1)
			$calc_socso='Y';
		else
			$calc_socso='N';

		$isactive=$row['isactive'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$emppayslipitem_name</td>
			<td class="$rowtype" style="text-align:center;">$emppayslipitem_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$seqno</td>
			<td class="$rowtype" style="text-align:center;">$amount</td>
			<td class="$rowtype" style="text-align:center;">$calc_socso</td>
			<td class="$rowtype" style="text-align:center;">$calc_epf</td>


			<td class="$rowtype" style="text-align:center;">
				<form action="emppayslipitem.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this emppayslipitem'>
				<input type="hidden" value="$emppayslipitem_id" name="emppayslipitem_id">
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
  public function getLatestEmpPayslipItemID() {
	$sql="SELECT MAX(emppayslipitem_id) as emppayslipitem_id from $this->tableemppayslipitem;";
	$this->log->showLog(3,'Checking latest created emppayslipitem_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created emppayslipitem_id:' . $row['emppayslipitem_id']);
		return $row['emppayslipitem_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectEmpPayslipItem($id,$showNull='N') {
	
	$sql="SELECT emppayslipitem_id,emppayslipitem_name from $this->tableemppayslipitem where (isactive='Y' or emppayslipitem_id=$id) and emppayslipitem_id>0 order by emppayslipitem_name ;";
	$selectctl="<SELECT name='emppayslipitem_id' >";
	if ($id==-1 || $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$emppayslipitem_id=$row['emppayslipitem_id'];
		$emppayslipitem_name=$row['emppayslipitem_name'];
	
		if($id==$emppayslipitem_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$emppayslipitem_id' $selected>$emppayslipitem_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

 public function getNextSeqNo() {
	$sql="SELECT MAX(seqno) + 10 as seqno from $this->tableemppayslipitem where employee_id=$this->employee_id;";
	$this->log->showLog(3,'Checking next seqno');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found next seqno:' . $row['seqno']);
		if ($row['seqno']=="")
		return 10;
		else
		return  $row['seqno'];
	}
	else
	return 10;
	
  } // end
 /* public function allowDelete($id){
	$sql="SELECT count(emppayslipitem_id) as rowcount from $this->tablestudent where emppayslipitem_id=$id";
	$this->log->showLog(3,"Accessing ProductEmpPayslipItem->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this emppayslipitem, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this emppayslipitem, record deletable");
		return true;
		}
	}
*/
} // end of ClassEmpPayslipItem
?>

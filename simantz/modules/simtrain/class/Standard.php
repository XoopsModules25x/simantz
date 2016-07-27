<?php


/**
 * class ProductStandard
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class Standard
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $standard_id;
  public $standard_name;
  public $standard_description;

  /**
   * if isactive="N", product master no longer can choose this standard. Print
   * reports by standard won't list this item as well. If this standard use by
   * productmaster, you can disable this record, but cannot delete this record.
   * @access public
   */
  public $isactive;
  public $organization_id;
  public $created;
  public $createdby;
  public $updated;
  public $orgctrl;
  public $updatedby;
  public $cur_name;
  public $cur_symbol;
  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $tablestandard;
  private $tablestudent;
  private $log;


//constructor
   public function Standard($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tablestudent=$tableprefix . "simtrain_student";
	$this->tablestandard=$tableprefix."simtrain_standard";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int standard_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $standard_id,$token  ) {
	
	$mandatorysign="<b style='color:red'>*</b>";
    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Standard";
		$action="create";
	 	
		if($standard_id==0){
			$this->standard_name="";
			$this->standard_description="";
			$this->isactive="";
			$this->organization_id;
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

		switch($this->isitem){
			case "Y":
				$selectStock="SELECTED='SELECTED'";
				$selectClass="";
				$selectCharge="";
			break;
			case "N":
				$selectClass="";
				$selectStock="";
				$selectCharge="SELECTED='SELECTED'";
			break;
			default:
				$selectCharge="";
				$selectStock="";
				$selectClass="SELECTED='SELECTED'";

			break;
		}
		$itemselect="<SELECT name='isitem'><OPTION value='Y' $selectStock>Control Stock</OPTION>".
				"<option value='N' $selectCharge>Charge</option><option value='C' ".
				" $selectClass>Class</option></SELECT>";
	}
	else
	{
		
		$action="update";
		$savectrl="<input name='standard_id' value='$this->standard_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablestandard' type='hidden'>".
		"<input name='id' value='$this->standard_id' type='hidden'>".
		"<input name='idname' value='standard_id' type='hidden'>".
		"<input name='title' value='Standard' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

	
		$header="Edit Standard";
		
		if($this->allowDelete($this->standard_id) && $this->standard_id>0)
		$deletectrl="<FORM action='standard.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this standard?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->standard_id' name='standard_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='standard.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Student Standard Master</span></big></big></big></div><br>-->

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateStandard()" method="post"
 action="standard.php" name="frmStandard"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="3" rowspan="1">$header</th>
      </tr>

      <tr>
        <td class="head">Standard Name $mandatorysign<input type='hidden' value='0' name='organization_id'></td>
        <td class="even" colspan="2"><input maxlength="10" size="10"
 name="standard_name" value="$this->standard_name"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Standard Description</td>
        <td class="odd" colspan="2"><input maxlength="40" size="40"
 name="standard_description" value="$this->standard_description"></td>
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
   * Update existing standard record
   *
   * @return bool
   * @access public
   */
  public function updateStandard( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablestandard SET ".
	"standard_description='$this->standard_description',standard_name='$this->standard_name',".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id ".
	"WHERE standard_id='$this->standard_id'";
	
	$this->log->showLog(3, "Update standard_id: $this->standard_id, $this->standard_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update standard failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update standard successfully.");
		return true;
	}
  } // end of member function updateStandard

  /**
   * Save new standard into database
   *
   * @return bool
   * @access public
   */
  public function insertStandard( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new standard $this->standard_name");
 	$sql="INSERT INTO $this->tablestandard (standard_description,standard_name".
	",isactive, created,createdby,updated,updatedby,organization_id) values(".
	"'$this->standard_description','$this->standard_name','$this->isactive','$timestamp',$this->createdby,'$timestamp',".
	"$this->updatedby,$this->organization_id)";
	$this->log->showLog(4,"Before insert standard SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert standard code $standard_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new standard $standard_name successfully"); 
		return true;
	}
  } // end of member function insertStandard

  /**
   * Pull data from standard table into class
   *
   * @return bool
   * @access public
   */
  public function fetchStandard( $standard_id) {
    
	$this->log->showLog(3,"Fetching standard detail into class Standard.php.<br>");
		
	$sql="SELECT standard_id,standard_name,standard_description,isactive,organization_id from $this->tablestandard ". 
			"where standard_id=$standard_id";
	
	$this->log->showLog(4,"ProductStandard->fetchStandard, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->organization_id=$row["organization_id"];
		$this->standard_name=$row["standard_name"];
		$this->standard_description= $row['standard_description'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"Standard->fetchStandard,database fetch into class successfully");
	$this->log->showLog(4,"organization_id:$this->organization_id");
	$this->log->showLog(4,"standard_name:$this->standard_name");
	$this->log->showLog(4,"standard_description:$this->standard_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Standard->fetchStandard,failed to fetch data into databases.");	
	}
  } // end of member function fetchStandard

  /**
   * Delete particular standard id
   *
   * @param int standard_id 
   * @return bool
   * @access public
   */
  public function deleteStandard( $standard_id ) {
    	$this->log->showLog(2,"Warning: Performing delete standard id : $standard_id !");
	$sql="DELETE FROM $this->tablestandard where standard_id=$standard_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: standard ($standard_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"standard ($standard_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteStandard

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllStandard( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running ProductStandard->getSQLStr_AllStandard: $sql");
    $sql="SELECT standard_name,standard_description,standard_id,isactive,organization_id FROM $this->tablestandard " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showStandardTable with sql:$sql");

  return $sql;
  } // end of member function getSQLStr_AllStandard

 public function showStandardTable(){
	
	$this->log->showLog(3,"Showing Standard Table");
	$sql=$this->getSQLStr_AllStandard("WHERE standard_id>0","ORDER BY standard_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Standard Name</th>
				<th style="text-align:center;">Standard Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$standard_id=$row['standard_id'];
		$standard_name=$row['standard_name'];
		$standard_description=$row['standard_description'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$standard_name</td>
			<td class="$rowtype" style="text-align:center;">$standard_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="standard.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this standard'>
				<input type="hidden" value="$standard_id" name="standard_id">
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
  public function getLatestStandardID() {
	$sql="SELECT MAX(standard_id) as standard_id from $this->tablestandard;";
	$this->log->showLog(3,'Checking latest created standard_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created standard_id:' . $row['standard_id']);
		return $row['standard_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectStandard($id,$showNull='N') {
	
	$sql="SELECT standard_id,standard_name from $this->tablestandard where (isactive='Y' or standard_id=$id) and standard_id>0 order by standard_description ;";
	$selectctl="<SELECT name='standard_id' >";
	if ($id==-1 || $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$standard_id=$row['standard_id'];
		$standard_name=$row['standard_name'];
	
		if($id==$standard_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$standard_id' $selected>$standard_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	$sql="SELECT count(standard_id) as rowcount from $this->tablestudent where standard_id=$id";
	$this->log->showLog(3,"Accessing ProductStandard->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this standard, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this standard, record deletable");
		return true;
		}
	}
} // end of ClassStandard
?>

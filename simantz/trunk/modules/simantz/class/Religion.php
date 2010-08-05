<?php

/**
 * class ProductReligion
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class Religion
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $religion_id;
  public $religion_name;
  public $religion_description;

  /**
   * if isactive="N", product master no longer can choose this religion. Print
   * reports by religion won't list this item as well. If this religion use by
   * productmaster, you can disable this record, but cannot delete this record.
   * @access public
   */
  public $isactive;

  public $created;
  public $createdby;
  public $updated;
  public $orgctrl;
  public $cur_name;
  public $cur_symbol;
  public $updatedby;
  private $xoopsDB;
  private $tableprefix;

  private $tablereligion;

  private $log;


//constructor
   public function Religion($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;

	
	$this->tablereligion=$tableprefix."religion";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int religion_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $religion_id,$token  ) {
	
	$mandatorysign="<b style='color:red'>*</b>";
    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Religion";
		$action="create";
	 	
		if($religion_id==0){
			$this->religion_name="";
			$this->religion_description="";
			$this->isactive="";

		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";


	}
	else
	{
		
		$action="update";
		$savectrl="<input name='religion_id' value='$this->religion_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablereligion' type='hidden'>".
		"<input name='id' value='$this->religion_id' type='hidden'>".
		"<input name='idname' value='religion_id' type='hidden'>".
		"<input name='title' value='Religion' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

	
		$header="Edit Religion";
		
		if($this->allowDelete($this->religion_id) && $this->religion_id>0)
		$deletectrl="<FORM action='religion.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this religion?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->religion_id' name='religion_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='religion.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateReligion()" method="post"
 action="religion.php" name="frmReligion"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="3" rowspan="1">$header</th>
      </tr>
       <tr>
        <td class="head">Religion Name $mandatorysign</td>
        <td class="even" colspan="2"><input maxlength="10" size="10"
 name="religion_name" value="$this->religion_name"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Religion Description</td>
        <td class="odd" colspan="2"><input maxlength="40" size="40"
 name="religion_description" value="$this->religion_description"></td>
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
   * Update existing religion record
   *
   * @return bool
   * @access public
   */
  public function updateReligion( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablereligion SET ".
	"religion_description='$this->religion_description',religion_name='$this->religion_name',".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive' ".
	"WHERE religion_id='$this->religion_id'";
	
	$this->log->showLog(3, "Update religion_id: $this->religion_id, $this->religion_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update religion failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update religion successfully.");
		return true;
	}
  } // end of member function updateReligion

  /**
   * Save new religion into database
   *
   * @return bool
   * @access public
   */
  public function insertReligion( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new religion $this->religion_name");
 	$sql="INSERT INTO $this->tablereligion (religion_description,religion_name
	,isactive, created,createdby,updated,updatedby) values(
	'$this->religion_description','$this->religion_name','$this->isactive','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby)";
	$this->log->showLog(4,"Before insert religion SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert religion code $religion_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new religion $religion_name successfully"); 
		return true;
	}
  } // end of member function insertReligion

  /**
   * Pull data from religion table into class
   *
   * @return bool
   * @access public
   */
  public function fetchReligion( $religion_id) {
    
	$this->log->showLog(3,"Fetching religion detail into class Religion.php.<br>");
		
	$sql="SELECT religion_id,religion_name,religion_description,isactive from $this->tablereligion ". 
			"where religion_id=$religion_id";
	
	$this->log->showLog(4,"ProductReligion->fetchReligion, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){

		$this->religion_name=$row["religion_name"];
		$this->religion_description= $row['religion_description'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"Religion->fetchReligion,database fetch into class successfully");

	$this->log->showLog(4,"religion_name:$this->religion_name");
	$this->log->showLog(4,"religion_description:$this->religion_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Religion->fetchReligion,failed to fetch data into databases.");	
	}
  } // end of member function fetchReligion

  /**
   * Delete particular religion id
   *
   * @param int religion_id 
   * @return bool
   * @access public
   */
  public function deleteReligion( $religion_id ) {
    	$this->log->showLog(2,"Warning: Performing delete religion id : $religion_id !");
	$sql="DELETE FROM $this->tablereligion where religion_id=$religion_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: religion ($religion_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"religion ($religion_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteReligion

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllReligion( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running ProductReligion->getSQLStr_AllReligion: $sql");
    $sql="SELECT religion_name,religion_description,religion_id,isactive FROM $this->tablereligion " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showreligiontable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllReligion

 public function showReligionTable(){
	
	$this->log->showLog(3,"Showing Religion Table");
	$sql=$this->getSQLStr_AllReligion("WHERE religion_id>0","ORDER BY religion_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Religion Name</th>
				<th style="text-align:center;">Religion Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$religion_id=$row['religion_id'];
		$religion_name=$row['religion_name'];
		$religion_description=$row['religion_description'];

		$isactive=$row['isactive'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$religion_name</td>
			<td class="$rowtype" style="text-align:center;">$religion_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="religion.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this religion'>
				<input type="hidden" value="$religion_id" name="religion_id">
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
  public function getLatestReligionID() {
	$sql="SELECT MAX(religion_id) as religion_id from $this->tablereligion;";
	$this->log->showLog(3,'Checking latest created religion_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created religion_id:' . $row['religion_id']);
		return $row['religion_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectReligion($id,$showNull='N') {
	
	$sql="SELECT religion_id,religion_name from $this->tablereligion where (isactive='Y' or religion_id=$id) and religion_id>0 order by religion_name ;";
	$this->log->showLog(3,"Generate Religion list with id=:$id and shownull=$showNull");
	$selectctl="<SELECT name='religion_id' >";
	if ($id==-1 || $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$religion_id=$row['religion_id'];
		$religion_name=$row['religion_name'];
	
		if($id==$religion_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$religion_id' $selected>$religion_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	$sql="SELECT count(religion_id) as rowcount from $this->tablestudent where religion_id=$id";
	$this->log->showLog(3,"Accessing ProductReligion->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this religion, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this religion, record deletable");
		return true;
		}
	}
} // end of ClassReligion
?>

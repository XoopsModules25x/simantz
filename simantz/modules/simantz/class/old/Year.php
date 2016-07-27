<?php

/**
 * class ProductYear
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class Year
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $year_id;
  public $year_name;
  public $year_description;

  /**
   * if isactive="N", product master no longer can choose this year. Print
   * reports by year won't list this item as well. If this year use by
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

  private $tableyear;
  private $tablestudent;
  private $log;


//constructor
   public function Year($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	
	$this->tableyear=$tableprefix."year";
	$this->log=$log;

    $this->arrInsertField=array("year_description","year_name","isactive","created","createdby","updated","updatedby");

    $this->arrInsertFieldType=array("%s","%s","%d","%s","%d","%s","%d");

    $this->arrUpdateField=array("year_description","year_name","isactive","updated","updatedby");

    $this->arrUpdateFieldType=array("%s","%s","%d","%s","%d");

    $this->tablename="sim_year";
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int year_id
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $year_id,$token  ) {
	 $mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Year";
		$action="create";
	 	
		if($year_id==0){
			$this->year_name="";
			$this->year_description="";
			$this->isactive="";
			
		}
		$savectrl="<input astyle='height: 40px;' name='submit' value='Save' type='submit'>";
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
		$savectrl="<input name='year_id' value='$this->year_id' type='hidden'>".
			 "<input astyle='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableyear' type='hidden'>".
		"<input name='id' value='$this->year_id' type='hidden'>".
		"<input name='idname' value='year_id' type='hidden'>".
		"<input name='title' value='Year' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

	
		$header="Edit Year";
		
		if($this->allowDelete($this->year_id) && $this->year_id>0)
		$deletectrl="<FORM action='year.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this year?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->year_id' name='year_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='year.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF


<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateYear()" method="post"
 action="year.php" name="frmYear"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" acellspacing="3">
    <tbody>
      <tr>
        <th colspan="3" rowspan="1">$header</th>
      </tr>
       <tr>
        <td class="head">Year Name $mandatorysign</td>
        <td class="even" colspan="2"><input maxlength="10" size="10"
 name="year_name" value="$this->year_name"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Year Description</td>
        <td class="odd" colspan="2"><input maxlength="40" size="40"
 name="year_description" value="$this->year_description"></td>
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
   * Update existing year record
   *
   * @return bool
   * @access public
   */
  public function updateYear( ) {

    include "../simantz/class/Save_Data.inc.php";
    $timestamp= date("y/m/d H:i:s", time()) ;
    $save = new Save_Data();
    $arrvalue=array($this->year_description,$this->year_name,$this->isactive,$timestamp,$this->updatedby);

    return $save->UpdateRecord($this->tablename, "year_id", $this->year_id, $this->arrUpdateField, $arrvalue,  $this->arrUpdateFieldType,$this->year_name);

  } // end of member function updateYear

  /**
   * Save new year into database
   *
   * @return bool
   * @access public
   */
  public function insertYear( ) {

    include "../simantz/class/Save_Data.inc.php";
    $timestamp= date("y/m/d H:i:s", time()) ;
    $save = new Save_Data();
    $arrvalue=array($this->year_description,$this->year_name,$this->isactive,$timestamp,$this->createdby,$timestamp,$this->updatedby);

    return $save->InsertRecord($this->tablename, $this->arrInsertField, $arrvalue, $this->arrInsertFieldType, $this->year_name,"year_id");

  } // end of member function insertYear

  /**
   * Pull data from year table into class
   *
   * @return bool
   * @access public
   */
  public function fetchYear( $year_id) {
    
	$this->log->showLog(3,"Fetching year detail into class Year.php.<br>");
		
	$sql="SELECT year_id,year_name,year_description,isactive from $this->tableyear ".
			"where year_id=$year_id";
	
	$this->log->showLog(4,"ProductYear->fetchYear, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		
		$this->year_name=$row["year_name"];
		$this->year_description= $row['year_description'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"Year->fetchYear,database fetch into class successfully");
	
	$this->log->showLog(4,"year_name:$this->year_name");
	$this->log->showLog(4,"year_description:$this->year_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Year->fetchYear,failed to fetch data into databases.");
	}
  } // end of member function fetchYear

  /**
   * Delete particular year id
   *
   * @param int year_id
   * @return bool
   * @access public
   */
  public function deleteYear( $year_id ) {
    
    include "../simantz/class/Save_Data.inc.php";
    $save = new Save_Data();
   
    return $save->DeleteRecord($this->tablename,"year_id",$year_id,$this->year_name,1);

  } // end of member function deleteYear

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllYear( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running ProductYear->getSQLStr_AllYear: $sql");
    $sql="SELECT year_name,year_description,year_id,isactive FROM $this->tableyear " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showyeartable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllYear

 public function showYearTable(){
	
	$this->log->showLog(3,"Showing Year Table");
	$sql=$this->getSQLStr_AllYear("WHERE year_id>0","ORDER BY year_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='0' acellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Year Name</th>
				<th style="text-align:center;">Year Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$year_id=$row['year_id'];
		$year_name=$row['year_name'];
		$year_description=$row['year_description'];

		$isactive=$row['isactive'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$year_name</td>
			<td class="$rowtype" style="text-align:center;">$year_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="year.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this year'>
				<input type="hidden" value="$year_id" name="year_id">
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
  public function getLatestYearID() {
	$sql="SELECT MAX(year_id) as year_id from $this->tableyear;";
	$this->log->showLog(3,'Checking latest created year_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created year_id:' . $row['year_id']);
		return $row['year_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectYear($id,$showNull='N') {
	
	$sql="SELECT year_id,year_name from $this->tableyear where (isactive='Y' or year_id=$id) and year_id>0 order by year_name ;";
	$selectctl="<SELECT name='year_id' >";
	if ($id==-1 || $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$year_id=$row['year_id'];
		$year_name=$row['year_name'];
	
		if($id==$year_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$year_id' $selected>$year_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
/*	$sql="SELECT count(year_id) as rowcount from $this->tablestudent where year_id=$id";
	$this->log->showLog(3,"Accessing ProductYear->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this year, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this year, record deletable");
		return true;
		}*/
	return true;
	}
} // end of ClassYear
?>

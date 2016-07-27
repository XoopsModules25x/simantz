<?php

/**
 * class ProductRaces
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class Races
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $races_id;
  public $races_name;
  public $races_description;

  /**
   * if isactive="N", product master no longer can choose this races. Print
   * reports by races won't list this item as well. If this races use by
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

  private $tableraces;
  private $tablestudent;
  private $log;


//constructor
   public function Races($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	
	$this->tableraces=$tableprefix."races";
	$this->log=$log;

    $this->arrInsertField=array("races_description","races_name","isactive","created","createdby","updated","updatedby");

    $this->arrInsertFieldType=array("%s","%s","%d","%s","%d","%s","%d");

    $this->arrUpdateField=array("races_description","races_name","isactive","updated","updatedby");

    $this->arrUpdateFieldType=array("%s","%s","%d","%s","%d");

    $this->tablename="sim_races";
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int races_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $races_id,$token  ) {
	 $mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Races";
		$action="create";
	 	
		if($races_id==0){
			$this->races_name="";
			$this->races_description="";
			$this->isactive="";
			
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
		$savectrl="<input name='races_id' value='$this->races_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableraces' type='hidden'>".
		"<input name='id' value='$this->races_id' type='hidden'>".
		"<input name='idname' value='races_id' type='hidden'>".
		"<input name='title' value='Races' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

	
		$header="Edit Races";
		
		if($this->allowDelete($this->races_id) && $this->races_id>0)
		$deletectrl="<FORM action='races.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this races?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->races_id' name='races_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='races.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF


<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateRaces()" method="post"
 action="races.php" name="frmRaces"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="3" rowspan="1">$header</th>
      </tr>
       <tr>
        <td class="head">Races Name $mandatorysign</td>
        <td class="even" colspan="2"><input maxlength="10" size="10"
 name="races_name" value="$this->races_name"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Races Description</td>
        <td class="odd" colspan="2"><input maxlength="40" size="40"
 name="races_description" value="$this->races_description"></td>
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
   * Update existing races record
   *
   * @return bool
   * @access public
   */
  public function updateRaces( ) {

    include "../simantz/class/Save_Data.inc.php";
    $timestamp= date("y/m/d H:i:s", time()) ;
    $save = new Save_Data();
    $arrvalue=array($this->races_description,$this->races_name,$this->isactive,$timestamp,$this->updatedby);

    return $save->UpdateRecord($this->tablename, "races_id", $this->races_id, $this->arrUpdateField, $arrvalue,  $this->arrUpdateFieldType,$this->races_name);

  } // end of member function updateRaces

  /**
   * Save new races into database
   *
   * @return bool
   * @access public
   */
  public function insertRaces( ) {

    include "../simantz/class/Save_Data.inc.php";
    $timestamp= date("y/m/d H:i:s", time()) ;
    $save = new Save_Data();
    $arrvalue=array($this->races_description,$this->races_name,$this->isactive,$timestamp,$this->createdby,$timestamp,$this->updatedby);

    return $save->InsertRecord($this->tablename, $this->arrInsertField, $arrvalue, $this->arrInsertFieldType, $this->races_name,"races_id");

  } // end of member function insertRaces

  /**
   * Pull data from races table into class
   *
   * @return bool
   * @access public
   */
  public function fetchRaces( $races_id) {
    
	$this->log->showLog(3,"Fetching races detail into class Races.php.<br>");
		
	$sql="SELECT races_id,races_name,races_description,isactive from $this->tableraces ". 
			"where races_id=$races_id";
	
	$this->log->showLog(4,"ProductRaces->fetchRaces, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		
		$this->races_name=$row["races_name"];
		$this->races_description= $row['races_description'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"Races->fetchRaces,database fetch into class successfully");
	
	$this->log->showLog(4,"races_name:$this->races_name");
	$this->log->showLog(4,"races_description:$this->races_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Races->fetchRaces,failed to fetch data into databases.");	
	}
  } // end of member function fetchRaces

  /**
   * Delete particular races id
   *
   * @param int races_id 
   * @return bool
   * @access public
   */
  public function deleteRaces( $races_id ) {
    
    include "../simantz/class/Save_Data.inc.php";
    $save = new Save_Data();
   
    return $save->DeleteRecord($this->tablename,"races_id",$races_id,$this->races_name,1);

  } // end of member function deleteRaces

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllRaces( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running ProductRaces->getSQLStr_AllRaces: $sql");
    $sql="SELECT races_name,races_description,races_id,isactive FROM $this->tableraces " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showracestable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllRaces

 public function showRacesTable(){
	
	$this->log->showLog(3,"Showing Races Table");
	$sql=$this->getSQLStr_AllRaces("WHERE races_id>0","ORDER BY races_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Races Name</th>
				<th style="text-align:center;">Races Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$races_id=$row['races_id'];
		$races_name=$row['races_name'];
		$races_description=$row['races_description'];

		$isactive=$row['isactive'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$races_name</td>
			<td class="$rowtype" style="text-align:center;">$races_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="races.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this races'>
				<input type="hidden" value="$races_id" name="races_id">
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
  public function getLatestRacesID() {
	$sql="SELECT MAX(races_id) as races_id from $this->tableraces;";
	$this->log->showLog(3,'Checking latest created races_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created races_id:' . $row['races_id']);
		return $row['races_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectRaces($id,$showNull='N') {
	
	$sql="SELECT races_id,races_name from $this->tableraces where (isactive='Y' or races_id=$id) and races_id>0 order by races_name ;";
	$selectctl="<SELECT name='races_id' >";
	if ($id==-1 || $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$races_id=$row['races_id'];
		$races_name=$row['races_name'];
	
		if($id==$races_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$races_id' $selected>$races_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
/*	$sql="SELECT count(races_id) as rowcount from $this->tablestudent where races_id=$id";
	$this->log->showLog(3,"Accessing ProductRaces->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this races, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this races, record deletable");
		return true;
		}*/
	return true;
	}
} // end of ClassRaces
?>

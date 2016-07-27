<?php
/************************************************************************
  			ClassRaces.php - Copyright kstan

Here you can write a license for your code, some comments or any other
information you want to have in your generated code. To to this simply
configure the "headings" directory in uml to point to a directory
where you have your heading files.

or you can just replace the contents of this file with your own.
If you want to do this, this file is located at

/usr/share/apps/umbrello/headings/heading.php

-->Code Generators searches for heading files based on the file extension
   i.e. it will look for a file name ending in ".h" to include in C++ header
   files, and for a file name ending in ".java" to include in all generated
   java code.
   If you name the file "heading.<extension>", Code Generator will always
   choose this file even if there are other files with the same extension in the
   directory. If you name the file something else, it must be the only one with that
   extension in the directory to guarantee that Code Generator will choose it.

you can use variables in your heading files which are replaced at generation
time. possible variables are : author, date, time, filename and filepath.
just write %variable_name%

This file was generated on Tue Mar 25 2008 at 01:10:25
The original location of this file is /home/kstan/Desktop/ClassRaces.php
**************************************************************************/

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
  public $isactive=0;
  public $isdefault=0;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  private $xoopsDB;
  private $tableprefix;
  private $tableraces;
  private $tableworker;
  private $log;


//constructor
   public function Races($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableworker=$tableprefix . "simfworker_worker";
	$this->tableraces=$tableprefix."simfworker_races";
	$this->log=$log;
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
	

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";


	$this->created=0;
	if ($type=="new"){
		$header="New Races";
		$action="create";
	 	
		if($races_id==0){
			$this->races_name="";
			$this->races_description="";
			$this->isactive="1";
			$this->isdefault="0";
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$defaultchecked="";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

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
		if ($this->isactive=='1')
			$checked="CHECKED";
		else
			$checked="";

		if ($this->isdefault=='1')
			$defaultchecked="CHECKED";
		else
			$defaultchecked="";

		$header="Edit Races";
		
		if($this->allowDelete($this->races_id))
		$deletectrl="<FORM action='races.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this races?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->races_id' name='races_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='races.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Races Master Data</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateRaces()" method="post"
 action="races.php" name="frmRaces"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
    
      <tr>
        <td class="head">Races Name</td>
        <td class="even" ><input maxlength="20" size="20"
 name="races_name" value="$this->races_name">
	<td class="head">Active </td><td class="even"><input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Races Description</td>
        <td class="odd"><input maxlength="40" size="40"
 name="races_description" value="$this->races_description">
	<td class="head"> Default	</td>
	<td class="odd"><input type="checkbox" $defaultchecked name="isdefault"></td>
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
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableraces SET ".
	"races_description='$this->races_description',races_name='$this->races_name',".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',isdefault=$this->isdefault ".
	"WHERE races_id='$this->races_id'";
	
	$this->log->showLog(3, "Update races_id: $this->races_id, $this->races_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update races failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update races successfully.");
		return true;
	}
  } // end of member function updateRaces

  /**
   * Save new races into database
   *
   * @return bool
   * @access public
   */
  public function insertRaces( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new races $this->races_name");
 	$sql="INSERT INTO $this->tableraces (races_description,races_name".
	",isactive, created,createdby,updated,updatedby,isdefault) values(".
	"'$this->races_description','$this->races_name','$this->isactive','$timestamp',$this->createdby,'$timestamp',".
	"$this->updatedby,$this->isdefault)";
	$this->log->showLog(4,"Before insert races SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert races code $races_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new races $races_name successfully"); 
		return true;
	}
  } // end of member function insertRaces

  /**
   * Pull data from races table into class
   *
   * @return bool
   * @access public
   */
  public function fetchRaces( $races_id) {
    
	$this->log->showLog(3,"Fetching races detail into class Races.php.<br>");
		
	$sql="SELECT races_id,races_name,races_description,isactive,isdefault from $this->tableraces ". 
			"where races_id=$races_id";
	
	$this->log->showLog(4,"ProductRaces->fetchRaces, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->races_name=$row["races_name"];
		$this->races_description= $row['races_description'];
		$this->isactive=$row['isactive'];
		$this->isdefault=$row['isdefault'];

	$this->log->showLog(4,"Races->fetchRaces,database fetch into class successfully");
	$this->log->showLog(4,"races_name:$this->races_name");
	$this->log->showLog(4,"races_description:$this->races_description");
	$this->log->showLog(4,"isactive:$this->isactive");


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
    	$this->log->showLog(2,"Warning: Performing delete races id : $races_id !");
	$sql="DELETE FROM $this->tableraces where races_id=$races_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: races ($races_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"races ($races_id) removed from database successfully!");
		return true;
		
	}
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
    $sql="SELECT races_name,races_description,races_id,isactive,isdefault FROM $this->tableraces " .
	" $wherestring $orderbystring";
  return $sql;
  } // end of member function getSQLStr_AllRaces

 public function showRacesTable(){
	
	$this->log->showLog(3,"Showing Races Table");
	$sql=$this->getSQLStr_AllRaces($wherestring,"ORDER BY races_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Races Name</th>
				<th style="text-align:center;">Races Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Default</th>
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
		$isdefault=$row['isdefault'];
		$isactive=$row['isactive'];

		if($isactive=='1')
			$isactive='Y';
		else
			$isactive='N';
		if($isdefault=='1')
			$isdefault='Y';
		else
			$isdefault='N';

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
			<td class="$rowtype" style="text-align:center;">$isdefault</td>
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

  public function getSelectRaces($id) {

	$sql="SELECT races_id,races_name from $this->tableraces where isactive='1' or  races_id=$id order by isdefault desc,races_name ;";
	$this->log->showLog(4,"Showing races selection: $sql");
	$selectctl="<SELECT name='races_id' >";
	if ($id==-1)
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
	$sql="SELECT count(races_id) as rowcount from $this->tableworker where races_id=$id";
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
		}
	}
} // end of ClassRaces
?>

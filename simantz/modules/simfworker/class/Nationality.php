<?php
/************************************************************************
  			ClassNationality.php - Copyright kstan

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
The original location of this file is /home/kstan/Desktop/ClassNationality.php
**************************************************************************/

/**
 * class ProductNationality
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class Nationality
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $nationality_id;
  public $nationality_name;
  public $nationality_description;
  public $isactive;
  public $isdefault;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  private $xoopsDB;
  private $tableprefix;
  private $tablenationality;
  private $tableworker;
  private $log;


//constructor
   public function Nationality($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableworker=$tableprefix . "simfworker_worker";
	$this->tablenationality=$tableprefix."simfworker_nationality";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int nationality_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $nationality_id,$token  ) {
	

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Nationality";
		$action="create";
	 	
		if($nationality_id==0){
			$this->nationality_name="";
			$this->nationality_description="";
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
	}
	else
	{
		
		$action="update";
		$savectrl="<input name='nationality_id' value='$this->nationality_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablenationality' type='hidden'>".
		"<input name='id' value='$this->nationality_id' type='hidden'>".
		"<input name='idname' value='nationality_id' type='hidden'>".
		"<input name='title' value='Nationality' type='hidden'>".
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
		$header="Edit Nationality";
		
		if($this->allowDelete($this->nationality_id))
		$deletectrl="<FORM action='nationality.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this nationality?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->nationality_id' name='nationality_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='nationality.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Nationality Master Data</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateNationality()" method="post"
 action="nationality.php" name="frmNationality"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
    
      <tr>
        <td class="head">Nationality Name</td>
        <td class="even" ><input maxlength="20" size="20"
 name="nationality_name" value="$this->nationality_name">
	<td class="head">Active </td><td class="even"><input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Nationality Description</td>
        <td class="odd"><input maxlength="40" size="40"
 name="nationality_description" value="$this->nationality_description">
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
   * Update existing nationality record
   *
   * @return bool
   * @access public
   */
  public function updateNationality( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablenationality SET ".
	"nationality_description='$this->nationality_description',nationality_name='$this->nationality_name',".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',isdefault=$this->isdefault ".
	"WHERE nationality_id='$this->nationality_id'";
	
	$this->log->showLog(3, "Update nationality_id: $this->nationality_id, $this->nationality_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update nationality failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update nationality successfully.");
		return true;
	}
  } // end of member function updateNationality

  /**
   * Save new nationality into database
   *
   * @return bool
   * @access public
   */
  public function insertNationality( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new nationality $this->nationality_name");
 	$sql="INSERT INTO $this->tablenationality (nationality_description,nationality_name".
	",isactive, created,createdby,updated,updatedby,isdefault) values(".
	"'$this->nationality_description','$this->nationality_name','$this->isactive','$timestamp',$this->createdby,'$timestamp',".
	"$this->updatedby,$this->isdefault)";
	$this->log->showLog(4,"Before insert nationality SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert nationality code $nationality_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new nationality $nationality_name successfully"); 
		return true;
	}
  } // end of member function insertNationality

  /**
   * Pull data from nationality table into class
   *
   * @return bool
   * @access public
   */
  public function fetchNationality( $nationality_id) {
    
	$this->log->showLog(3,"Fetching nationality detail into class Nationality.php.<br>");
		
	$sql="SELECT nationality_id,nationality_name,nationality_description,isactive,isdefault from $this->tablenationality ". 
			"where nationality_id=$nationality_id";
	
	$this->log->showLog(4,"ProductNationality->fetchNationality, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->nationality_name=$row["nationality_name"];
		$this->nationality_description= $row['nationality_description'];
		$this->isactive=$row['isactive'];
		$this->isdefault=$row['isdefault'];

	$this->log->showLog(4,"Nationality->fetchNationality,database fetch into class successfully");
	$this->log->showLog(4,"nationality_name:$this->nationality_name");
	$this->log->showLog(4,"nationality_description:$this->nationality_description");
	$this->log->showLog(4,"isactive:$this->isactive");


		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Nationality->fetchNationality,failed to fetch data into databases.");	
	}
  } // end of member function fetchNationality

  /**
   * Delete particular nationality id
   *
   * @param int nationality_id 
   * @return bool
   * @access public
   */
  public function deleteNationality( $nationality_id ) {
    	$this->log->showLog(2,"Warning: Performing delete nationality id : $nationality_id !");
	$sql="DELETE FROM $this->tablenationality where nationality_id=$nationality_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: nationality ($nationality_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"nationality ($nationality_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteNationality

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllNationality( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running ProductNationality->getSQLStr_AllNationality: $sql");
    $sql="SELECT nationality_name,nationality_description,nationality_id,isactive,isdefault FROM $this->tablenationality " .
	" $wherestring $orderbystring";
  return $sql;
  } // end of member function getSQLStr_AllNationality

 public function showNationalityTable(){
	
	$this->log->showLog(3,"Showing Nationality Table");
	$sql=$this->getSQLStr_AllNationality($wherestring,"ORDER BY nationality_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Nationality Name</th>
				<th style="text-align:center;">Nationality Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Default</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$nationality_id=$row['nationality_id'];
		$nationality_name=$row['nationality_name'];
		$nationality_description=$row['nationality_description'];
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
			<td class="$rowtype" style="text-align:center;">$nationality_name</td>
			<td class="$rowtype" style="text-align:center;">$nationality_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$isdefault</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="nationality.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this nationality'>
				<input type="hidden" value="$nationality_id" name="nationality_id">
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
  public function getLatestNationalityID() {
	$sql="SELECT MAX(nationality_id) as nationality_id from $this->tablenationality;";
	$this->log->showLog(3,'Checking latest created nationality_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created nationality_id:' . $row['nationality_id']);
		return $row['nationality_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectNationality($id) {
	
	$sql="SELECT nationality_id,nationality_name from $this->tablenationality where isactive='1' or nationality_id=$id order by isdefault desc, nationality_name ;";
	$selectctl="<SELECT name='nationality_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$nationality_id=$row['nationality_id'];
		$nationality_name=$row['nationality_name'];
	
		if($id==$nationality_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$nationality_id' $selected>$nationality_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	$sql="SELECT count(nationality_id) as rowcount from $this->tableworker where nationality_id=$id";
	$this->log->showLog(3,"Accessing ProductNationality->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this nationality, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this nationality, record deletable");
		return true;
		}
	}
} // end of ClassNationality
?>

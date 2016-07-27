<?php
/************************************************************************
  			ClassChangeLog.php - Copyright kstan

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
The original location of this file is /home/kstan/Desktop/ClassChangeLog.php
**************************************************************************/

/**
 * class ProductChangeLog
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class ChangeLog
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $changelog_id;
  public $changelog_name;
  public $changelog_description;

  /**
   * if isactive="N", product master no longer can choose this changelog. Print
   * reports by changelog won't list this item as well. If this changelog use by
   * productmaster, you can disable this record, but cannot delete this record.
   * @access public
   */
  public $isactive;
  public $organization_id;
  public $created;
  public $createdby;
  public $updated;
  public $orgctrl;
  public $cur_name;
  public $cur_symbol;
  public $updatedby;
  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $tablechangelog;
  private $tablestudent;
  private $log;


//constructor
   public function ChangeLog($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tablestudent=$tableprefix . "simtrain_student";
	$this->tablechangelog=$tableprefix."simtrain_changelog";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int changelog_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $changelog_id,$token  ) {
	

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New ChangeLog";
		$action="create";
	 	
		if($changelog_id==0){
			$this->changelog_name="";
			$this->changelog_description="";
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

		
	}
	else
	{
		
		$action="update";
		$savectrl="<input name='changelog_id' value='$this->changelog_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablechangelog' type='hidden'>".
		"<input name='id' value='$this->changelog_id' type='hidden'>".
		"<input name='idname' value='changelog_id' type='hidden'>".
		"<input name='title' value='ChangeLog' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

	
		$header="Edit ChangeLog";
		
		if($this->allowDelete($this->changelog_id))
		$deletectrl="<FORM action='changelog.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this changelog?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->changelog_id' name='changelog_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='changelog.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">ChangeLog Master</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateChangeLog()" method="post"
 action="changelog.php" name="frmChangeLog"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="3" rowspan="1">$header</th>
      </tr>
        <tr>
        <td class="head">Organization</td>
        <td class="odd" colspan="2">$this->orgctrl</td>
      </tr>
      <tr>
        <td class="head">ChangeLog Name</td>
        <td class="even" colspan="2"><input maxlength="40" size="40"
 name="changelog_name" value="$this->changelog_name"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">ChangeLog Description (Max 255)</td>
        <td class="odd" colspan="2"><textarea name="changelog_description" cols='100', rows='5'>$this->changelog_description</textarea></td>
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
   * Update existing changelog record
   *
   * @return bool
   * @access public
   */
  public function updateChangeLog( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablechangelog SET ".
	"changelog_description='$this->changelog_description',changelog_name='$this->changelog_name',".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id ".
	"WHERE changelog_id='$this->changelog_id'";
	
	$this->log->showLog(3, "Update changelog_id: $this->changelog_id, $this->changelog_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update changelog failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update changelog successfully.");
		return true;
	}
  } // end of member function updateChangeLog

  /**
   * Save new changelog into database
   *
   * @return bool
   * @access public
   */
  public function insertChangeLog( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new changelog $this->changelog_name");
 	$sql="INSERT INTO $this->tablechangelog (changelog_description,changelog_name".
	",isactive, created,createdby,updated,updatedby,organization_id) values(".
	"'$this->changelog_description','$this->changelog_name','$this->isactive','$timestamp',$this->createdby,'$timestamp',".
	"$this->updatedby,$this->organization_id)";
	$this->log->showLog(4,"Before insert changelog SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert changelog code $changelog_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new changelog $changelog_name successfully"); 
		return true;
	}
  } // end of member function insertChangeLog

  /**
   * Pull data from changelog table into class
   *
   * @return bool
   * @access public
   */
  public function fetchChangeLog( $changelog_id) {
    
	$this->log->showLog(3,"Fetching changelog detail into class ChangeLog.php.<br>");
		
	$sql="SELECT changelog_id,changelog_name,changelog_description,isactive,organization_id from $this->tablechangelog ". 
			"where changelog_id=$changelog_id";
	
	$this->log->showLog(4,"ProductChangeLog->fetchChangeLog, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->organization_id=$row["organization_id"];
		$this->changelog_name=$row["changelog_name"];
		$this->changelog_description= $row['changelog_description'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"ChangeLog->fetchChangeLog,database fetch into class successfully");
	$this->log->showLog(4,"organization_id:$this->organization_id");
	$this->log->showLog(4,"changelog_name:$this->changelog_name");
	$this->log->showLog(4,"changelog_description:$this->changelog_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"ChangeLog->fetchChangeLog,failed to fetch data into databases.");	
	}
  } // end of member function fetchChangeLog

  /**
   * Delete particular changelog id
   *
   * @param int changelog_id 
   * @return bool
   * @access public
   */
  public function deleteChangeLog( $changelog_id ) {
    	$this->log->showLog(2,"Warning: Performing delete changelog id : $changelog_id !");
	$sql="DELETE FROM $this->tablechangelog where changelog_id=$changelog_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: changelog ($changelog_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"changelog ($changelog_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteChangeLog

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllChangeLog( $wherestring,  $orderbystring,  $startlimitno ) {
     $sql="SELECT changelog_name,changelog_description,changelog_id,isactive,organization_id,created FROM $this->tablechangelog " .
	" $wherestring $orderbystring";
$this->log->showLog(4,"Running ProductChangeLog->getSQLStr_AllChangeLog: $sql");
  
 return $sql;
  } // end of member function getSQLStr_AllChangeLog

 public function showChangeLogTable(){
	
	$this->log->showLog(3,"Showing ChangeLog Table");
	$sql=$this->getSQLStr_AllChangeLog($wherestring,"ORDER BY created desc",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' >
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Created</th>
				<th style="text-align:center;">ChangeLog Name</th>
				<th style="text-align:center;">ChangeLog Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$changelog_id=$row['changelog_id'];
		$changelog_name=$row['changelog_name'];
		$changelog_description=$row['changelog_description'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];
		$created=$row['created'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$created</td>
			<td class="$rowtype" style="text-align:center;">$changelog_name</td>
			<td class="$rowtype" style="text-align:center;">$changelog_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="changelog.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this changelog'>
				<input type="hidden" value="$changelog_id" name="changelog_id">
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
  public function getLatestChangeLogID() {
	$sql="SELECT MAX(changelog_id) as changelog_id from $this->tablechangelog;";
	$this->log->showLog(3,'Checking latest created changelog_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created changelog_id:' . $row['changelog_id']);
		return $row['changelog_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectChangeLog($id) {
	
	$sql="SELECT changelog_id,changelog_name from $this->tablechangelog where isactive='Y' or changelog_id=$id order by changelog_name ;";
	$selectctl="<SELECT name='changelog_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$changelog_id=$row['changelog_id'];
		$changelog_name=$row['changelog_name'];
	
		if($id==$changelog_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$changelog_id' $selected>$changelog_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	return true;
	}
} // end of ClassChangeLog
?>

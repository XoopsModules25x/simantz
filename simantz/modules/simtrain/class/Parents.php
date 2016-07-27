<?php


class Parents
{


  public $parents_id;
  public $parents_name;
  public $parents_contact;
  public $parents_name2;
  public $parents_contact2;
  public $description;
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
  private $tableparents;
  private $tablestudent;
  private $log;


//constructor
   public function Parents($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tablestudent=$tableprefix . "simtrain_student";
	$this->tableparents=$tableprefix."simtrain_parents";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int parents_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $parents_id,$token  ) {
	
	$mandatorysign="<b style='color:red'>*</b>";
    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Parents";
		$action="create";
	 	
		if($parents_id==0){
			$this->parents_name="";
			$this->parents_contact="";
			$this->isactive="";
			$this->organization_id;
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";


		$itemselect="<SELECT name='isitem'><OPTION value='Y' $selectStock>Control Stock</OPTION>".
				"<option value='N' $selectCharge>Charge</option><option value='C' ".
				" $selectClass>Class</option></SELECT>";
	}
	else
	{
		
		$action="update";
		$savectrl="<input name='parents_id' value='$this->parents_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableparents' type='hidden'>".
		"<input name='id' value='$this->parents_id' type='hidden'>".
		"<input name='idname' value='parents_id' type='hidden'>".
		"<input name='title' value='Parents' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

	
		$header="Edit Parents";
		
		if($this->allowDelete($this->parents_id) && $this->parents_id>0)
		$deletectrl="<FORM action='parents.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this parents?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->parents_id' name='parents_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

	}

    echo <<< EOF
<table style="width:140px;"><tbody><td><form onsubmit="return validateParents()" method="post"
 action="parents.php" name="frmParents"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
        <tr>
        <td class="head">Organization</td>
        <td class="odd">$this->orgctrl</td>
	<td class="head">Active</td>
	<td class="odd"> <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Parents Name $mandatorysign </td>
        <td class="even"><input maxlength="40" size="40"
 name="parents_name" value="$this->parents_name"><A>&nbsp;</A></td>
        <td class="head">Parents HP</td>
        <td class="even"><input maxlength="15" size="15"
 name="parents_contact" value="$this->parents_contact"></td>
      </tr>
        <tr>
        <td class="head">Parent Occupation</td>
        <td class="odd"><input name='parents_occupation'  value="$this->parents_occupation"></td>
	<td class="head">Parent Email</td>
	<td class="odd"><input maxlength="60" size="30" name="parents_email" value="$this->parents_email"></td>
      </tr>
      <tr>
        <td class="head">Parents 2 Name</td>
        <td class="odd"><input maxlength="40" size="40"
 name="parents_name2" value="$this->parents_name2"><A>&nbsp;</A></td>
        <td class="head">Parents 2 HP</td>
        <td class="odd"><input maxlength="15" size="15"
 name="parents_contact2" value="$this->parents_contact2"></td>
      </tr>
        <tr>
        <td class="head">Parent 2 Occupation</td>
        <td class="odd"><input name='parents_occupation2'  value="$this->parents_occupation2"></td>
	<td class="head">Parent 2 Email</td>
	<td class="odd"><input maxlength="60" size="30" name="parents_email2" value="$this->parents_email2"></td>
      </tr>


  <tr>
        <td class="head">Description</td>
        <td class="even" colspan='3'>
 	<textarea rows='10' cols='90' name="description">$this->description</textarea>
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
   * Update existing parents record
   *
   * @return bool
   * @access public
   */
  public function updateParents( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableparents SET description='$this->description',
	parents_contact='$this->parents_contact',parents_name='$this->parents_name',
	parents_contact2='$this->parents_contact2',parents_name2='$this->parents_name2',
	parents_email='$this->parents_email',
	parents_email2='$this->parents_email2',
	parents_occupation='$this->parents_occupation',
	parents_occupation2='$this->parents_occupation2',
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id 
	WHERE parents_id='$this->parents_id'";
	
	$this->log->showLog(3, "Update parents_id: $this->parents_id, $this->parents_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update parents failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update parents successfully.");
		return true;
	}
  } // end of member function updateParents

  /**
   * Save new parents into database
   *
   * @return bool
   * @access public
   */
  public function insertParents( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new parents $this->parents_name");
 	$sql="INSERT INTO $this->tableparents (parents_contact,parents_name, parents_contact2 ,parents_name2
	,isactive, created,createdby,updated,updatedby,organization_id,description,parents_email,parents_email2,
	parents_occupation,parents_occupation2) values(
	'$this->parents_contact','$this->parents_name','$this->parents_contact2','$this->parents_name2',
	'$this->isactive','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->organization_id,'$this->description','$this->parents_email','$this->parents_email2',
	'$this->parents_occupation','$this->parents_occupation2')";
	$this->log->showLog(4,"Before insert parents SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert parents code $parents_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new parents $parents_name successfully"); 
		return true;
	}
  } // end of member function insertParents

  /**
   * Pull data from parents table into class
   *
   * @return bool
   * @access public
   */
  public function fetchParents( $parents_id) {
    
	$this->log->showLog(3,"Fetching parents detail into class Parents.php.<br>");
		
	$sql="SELECT parents_id,parents_name,parents_contact,parents_name2,parents_contact2,parents_occupation,parents_occupation2,
		isactive,organization_id,description,parents_email,parents_email2 from $this->tableparents where parents_id=$parents_id";
	
	$this->log->showLog(4,"ProductParents->fetchParents, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->organization_id=$row["organization_id"];
		$this->parents_name=$row["parents_name"];
		$this->parents_contact= $row['parents_contact'];
		$this->parents_name2=$row["parents_name2"];
		$this->parents_contact2= $row['parents_contact2'];
		$this->parents_email= $row['parents_email'];
		$this->parents_email2= $row['parents_email2'];
		$this->parents_occupation= $row['parents_occupation'];
		$this->parents_occupation2= $row['parents_occupation2'];
		$this->description= $row['description'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"Parents->fetchParents,database fetch into class successfully");
	$this->log->showLog(4,"organization_id:$this->organization_id");
	$this->log->showLog(4,"parents_name:$this->parents_name");
	$this->log->showLog(4,"parents_contact:$this->parents_contact");
	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Parents->fetchParents,failed to fetch data into databases.");	
	}
  } // end of member function fetchParents

  /**
   * Delete particular parents id
   *
   * @param int parents_id 
   * @return bool
   * @access public
   */
  public function deleteParents( $parents_id ) {
    	$this->log->showLog(2,"Warning: Performing delete parents id : $parents_id !");
	$sql="DELETE FROM $this->tableparents where parents_id=$parents_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: parents ($parents_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"parents ($parents_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteParents

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllParents( $wherestring,  $orderbystring ) {
  $this->log->showLog(4,"Running ProductParents->getSQLStr_AllParents: $sql");
    $sql="SELECT p.parents_name, p.parents_contact, p.parents_name2, p.parents_contact2, p.description,
		p.parents_id,p.isactive, o.organization_code,p.parents_email,p.parents_email2
		FROM $this->tableparents p
		inner join $this->tableorganization o on o.organization_id=p.organization_id
	 $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showParentsTable with sql:$sql");

  return $sql;
  } // end of member function getSQLStr_AllParents

 public function showParentsTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing Parents Table");
	$sql=$this->getSQLStr_AllParents($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Organization Code</th>
				<th style="text-align:center;">Parents Name</th>
				<th style="text-align:center;">Parents Contact</th>
				<th style="text-align:center;">Parents Name 2</th>
				<th style="text-align:center;">Parents Contact 2</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$parents_id=$row['parents_id'];
		$parents_name=$row['parents_name'];
		$parents_contact=$row['parents_contact'];
		$parents_name2=$row['parents_name2'];
		$parents_contact2=$row['parents_contact2'];
		$organization_id=$row['organization_id'];
		$description=$row['description'];
		$organization_code=$row['organization_code'];
		$isactive=$row['isactive'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$organization_code</td>
			<td class="$rowtype" style="text-align:center;"><A href="parents.php?action=edit&parents_id=$parents_id" target="_blank">
					$parents_name</A></td>
			<td class="$rowtype" style="text-align:center;">$parents_contact</td>
			<td class="$rowtype" style="text-align:center;">$parents_name2</td>
			<td class="$rowtype" style="text-align:center;">$parents_contact2</td>
			<td class="$rowtype" style="text-align:center;">$description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="parents.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this parents'>
				<input type="hidden" value="$parents_id" name="parents_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

  public function showChildTable($parents_id){

	$sql = "select * from $this->tablestudent where parents_id = $parents_id";

	$query=$this->xoopsDB->query($sql);
echo <<< EOF
	
	<table border='1' cellspacing='3'>
	<tbody>
	<tr>
		<th colspan="8" align="center">List Of Children</th>
	</tr>
    	<tr>
		<th style="text-align:center;">No</th>
		<th style="text-align:center;">Student Code</th>
		<th style="text-align:center;">Student Name</th>
		<th style="text-align:center;">I/C No</th>
		<th style="text-align:center;">Date Of Birth</th>
		<th style="text-align:center;">Join Date</th>
		<th style="text-align:center;">Gender</th>
		<th style="text-align:center;">Active</th>
   	</tr>
EOF;
	
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$student_code=$row['student_code'];
		$student_name=$row['student_name'];
		$school_name=$row['school_name'];
		$standard_name=$row['standard_name'];
		$hp_no=$row['hp_no'];
		$student_id=$row['student_id'];
		$gender=$row['gender'];
		$isactive=$row['isactive'];
		$ic_no=$row['ic_no'];
		$parents_name=$row['parents_name'];
		$dateofbirth=$row["dateofbirth"];
		$joindate=$row["joindate"];
		$tel_1=$row['tel_1'];
		if($isactive=='N')
			$isactive="<b style='color:red'>$isactive</b>";
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$student_code</td>
			<td class="$rowtype" style="text-align:left;">
			<a href='student.php?action=edit&student_id=$student_id' atarget="_blank">$student_name</a></td>
			<td class="$rowtype" style="text-align:center;">$ic_no</td>
			<td class="$rowtype" style="text-align:center;">$dateofbirth</td>
			<td class="$rowtype" style="text-align:center;">$joindate</td>
			<td class="$rowtype" style="text-align:center;">$gender</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<!--<td class="$rowtype" style="text-align:center;"><form action='student.php' method='POST'>
			<input type='image' src='images/edit.gif' name='submit' title='Edit this record'>
			<input type='hidden' value='$student_id' name='student_id'><input type='hidden' name='action' value='edit'></form></td>-->

		</tr>
EOF;
	}

echo <<< EOF
	</tbody>
	</table>
	<br>
EOF;

  }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestParentsID() {
	$sql="SELECT MAX(parents_id) as parents_id from $this->tableparents;";
	$this->log->showLog(3,'Checking latest created parents_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created parents_id:' . $row['parents_id']);
		return $row['parents_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectParents($id,$showNull='N') {
	
	$sql="SELECT parents_id,parents_name from $this->tableparents where (isactive='Y' or parents_id=$id ) and parents_id>0 order by parents_name ;";
	$this->log->showLog(4,"Show parents list with sql:$sql");

	$selectctl="<SELECT name='parents_id' >";
	if ($id==-1 || $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
	
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$parents_id=$row['parents_id'];
		$parents_name=$row['parents_name'];
	
		if($id==$parents_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$parents_id' $selected>$parents_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	$sql="SELECT count(parents_id) as rowcount from $this->tablestudent where parents_id=$id";
	$this->log->showLog(3,"Accessing ProductParents->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this parents, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this parents, record deletable");
		return true;
		}
	}

 public function searchAToZ(){
	global $defaultorganization_id;
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search parent easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(parents_name,1)) as shortname FROM $this->tableparents where isactive='Y' and parents_id>0 and organization_id = $defaultorganization_id order by parents_name";
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
echo "<b>Parents Grouping By Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if customer never do filter yet, if will choose 1st customer listing
		
		echo "<A href='parents.php?filterstring=$shortname'> $shortname </A> ";
	}
		echo <<<EOF
<BR>
<A href='parents.php' style='color: GRAY'> [ADD NEW PARENT]</A>
<A href='parents.php?action=search' style='color: gray'> [SEARCH PARENTS]</A>

EOF;
return $filterstring;

	$this->log->showLog(3,"Complete generate list of short cut");
  }

  public function showSearchForm(){
	$this->log->showLog(3,"Show Search Form");
echo <<< EOF

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">Search Parents<FORM action='parents.php' method='POST'></th>
      </tr>
        <tr>
        <td class="head">Parents Name</td>
        <td class="odd">
		<input maxlength="50" size="50"
		 	name="parents_name" value="$this->parents_name">%ali, %ali%, ali%, %ali%bin%
	</td>
  <td class="head">Active</td>
 <td class="odd">
		<select name="isactive">
			<option value="-" >Null</option>
			<option value="Y" >Y</option>
			<option value="N" >N</option>
		</select>
</tr>
<tr>
   <td class="head">Parents Name 2</td>
        <td class="even">
		<input maxlength="50" size="50"
		 	name="parents_name2" value="$this->parents_name2">%ali, %ali%, ali%, %ali%bin%
	</td>
<td class='head'>Organization</td><td class='even' >$this->orgctrl</td>
</tr>
<tr>
 <td class="head">Description (poor, %poor%old%)</td>
	<td class='odd'><input name="description" value="$this->description"></td>
	<td class='head' colspan='2'><input type="submit" value="Search" name='submit'>
		<input type="hidden" value="searchparents" name='action'></form>
</td>

      </tr>
    </tbody>
  </table>
EOF;

  }

} // end of ClassParents
?>

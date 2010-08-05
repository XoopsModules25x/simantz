<?php


class Studentchase
{

  public $studentchase_id;
  public $reminder_id;
  public $student_id;
  public $semester_id;
  public $studentchase_date;
  public $createdby;
  public $updated;
  public $updatedby;
  public $organization_id;
  public $isactive;
  public $defaultlevel;
  public $remarks;
  private $xoopsDB;
  private $tableprefix;
  private $tablestudentchase;

  private $log;


//constructor
   public function Studentchase(){
	global $xoopsDB,$log,$tablestudentchase,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport;
        global $tablestudent,$tablesemester;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablereminder="sim_simedu_reminder";
	$this->tablestudentchase= "sim_simedu_studentchase";
        $this->tablesemester = $tablesemester;
        $this->tablestudent = $tablestudent;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type
   * @param int studentchase_id
   * @return
   * @access public
   */
  public function getInputForm( $type,  $studentchase_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

                $previewbtn = '';
    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";

	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New History";
		$action="create";

		if($studentchase_id==0){
                        $this->studentchase_date=getDateSession();
			$this->isactive="";
			$this->defaultlevel=10;
			$this->studentchase_id = getNewCode($this->xoopsDB,"studentchase_id",$this->tablestudentchase,"");

		}
		$savectrl="<input astyle='height: 40px;' name='submit' value='Save' type='submit'>";
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
		$savectrl="<input name='studentchase_id' value='$this->studentchase_id' type='hidden'>".
			 "<input astyle='height: 40px;' name='submit' value='Save' type='submit'>";



		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablestudentchase' type='hidden'>".
		"<input name='id' value='$this->studentchase_id' type='hidden'>".
		"<input name='idname' value='studentchase_id' type='hidden'>".
		"<input name='title' value='Student Reminder' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";


		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";


		$header="Edit History";

		if($this->allowDelete($this->studentchase_id))
		$deletectrl="<FORM action='studentchase.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this student reminder?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->studentchase_id' name='studentchase_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='studentchase.php' method='POST'><input name='submit' value='New' type='submit'></form>";

                $previewbtn = '<a href="student_reminder.php?reminder_id='.$this->studentchase_id.'" target="blank"><input type="hidden" value="Preview Letter" name="preButton"></a>';
	}

    echo <<< EOF


<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateStudentchase()" method="post"
 action="studentchase.php" name="frmStudentchase"><input name="reset" value="Reset" type="reset"></td>
<td><a href="studentchase.php?action=search"><input type="button" value="Search History" name="searchbutton"></a></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" colspan="3">$this->orgctrl&nbsp;Active <input type="checkbox" $checked name="isactive"></td>
			<td class="head" style="display:none">Default Level $mandatorysign</td>
	        <td class="even"  style="display:none"><input maxlength="3" size="3" name='defaultlevel' value='$this->defaultlevel'>

      </tr>
      <tr>
	<td class="head">Student </td>
        <td class="even" >$this->studentctrl</td>
        <td class="head">Semester</td>
        <td class="even">$this->semesterctrl</td>
      </tr>
      <tr>
        <td class="head">Date</td>
        <td class="even" colspan="3"><input name='studentchase_date' id='studentchase_date' value="$this->studentchase_date" maxlength='10' size='10'>
    <input name='btnDate' value="Date" type="button" onclick="$this->reminderdatectrl"> <font color=red>YYYY-MM-DD (Ex: 2009-12-30)</font></td>
      </tr>
      <tr>
        <td class="head">Remarks</td>
        <td class="even"  colspan="3"><textarea name="remarks" cols="40" rows="4">$this->remarks</textarea></td>
        
      </tr>

    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$savectrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden">
        </td>
	</form>
        
        <td>$deletectrl</td><td>$previewbtn</td></tbody></table>

  <br>

$recordctrl

EOF;
  } // end of member function getInputForm

  /**
   * Update existing semester record
   *
   * @return bool
   * @access public
   */
  public function updateStudentchase( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablestudentchase SET
	student_id='$this->student_id',semester_id='$this->semester_id',studentchase_date='$this->studentchase_date',
        updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',defaultlevel=$this->defaultlevel,
	organization_id=$this->organization_id,remarks='$this->remarks' WHERE studentchase_id='$this->studentchase_id'";
	$this->changesql = $sql;
	$this->log->showLog(3, "Update studentchase_id: $this->studentchase_id");
	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update Student Reminder failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update Student Reminder successfully.");
		return true;
	}
  } // end of member function updateStudentchase

  /**
   * Save new studentchase into database
   *
   * @return bool
   * @access public
   */
  public function insertStudentchase( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new studentchase");
 	$sql="INSERT INTO $this->tablestudentchase (student_id,semester_id,studentchase_date,
        isactive,created,createdby,updated,updatedby,defaultlevel,organization_id,remarks) values(
	'$this->student_id','$this->semester_id','$this->studentchase_date','$this->isactive','$timestamp','$this->createdby',
        '$timestamp','$this->updatedby','$this->defaultlevel','$this->organization_id','$this->remarks')";
//$this->changesql = $sql;

	$this->log->showLog(4,"Before insert studnetreminder SQL:$sql");
	$rs=$this->xoopsDB->query($sql);

	if (!$rs){
		$this->log->showLog(1,"Failed to insert studentchase :" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new student reminder successfully");
		return true;
	}
  } // end of member function insertStudentchase

  /**
   * Pull data from student table into class
   *
   * @return bool
   * @access public
   */
  public function fetchStudentchase( $studentchase_id) {


	$this->log->showLog(3,"Fetching studentchase detail into class Studentchase.php.<br>");

	$sql="SELECT studentchase_id,student_id,semester_id,studentchase_date,isactive,defaultlevel,organization_id,remarks
		 from $this->tablestudentchase where studentchase_id=$studentchase_id";

	$this->log->showLog(4,"ProductStudentchase->fetchStudentchase, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
            $this->studentchase_id=$row["studentchase_id"];
            $this->student_id=$row['student_id'];
            $this->semester_id= $row['semester_id'];
            $this->studentchase_date=$row['studentchase_date'];
            $this->organization_id=$row['organization_id'];
            $this->isactive = $row['isactive'];
            $this->defaultlevel = $row['defaultlevel'];
            $this->remarks = $row['remarks'];
        
        $this->log->showLog(4,"Studentchase->fetchStudentchase,database fetch into class successfully");
	$this->log->showLog(4,"studentchase:$this->studentchase_id");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Studentchase->fetchStudentchase,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchStudentchase

  /**
   * Delete particular studentchase id
   *
   * @param int studentchase_id
   * @return bool
   * @access public
   */
  public function deleteStudentchase( $studentchase_id ) {
    	$this->log->showLog(2,"Warning: Performing delete studentchase id : $studentchase_id !");
	$sql="DELETE FROM $this->tablestudentchase where studentchase_id=$studentchase_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->changesql = $sql;
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: student reminder ($studentchasereminder_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"studentchase ($studentchase_id) removed from database successfully!");
		return true;

	}
  } // end of member function deleteStudentchase

  /**
   * Return select sql statement.
   *
   * @param string wherestring
   * @param string orderbystring
   * @param int startlimitno
   * @return string
   * @access public
   */
  public function getSQLStr_AllStudentchase( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductStudentchase->getSQLStr_AllStudentchase: $sql");

   $sql="SELECT a.studentchase_id,b.reminder_id,b.reminder_title,d.student_name,".
        " c.semester_name,a.student_id,a.semester_id,a.studentchase_date,a.organization_id,".
        " a.isactive,a.defaultlevel,a.remarks,a.studentchase_date FROM $this->tablestudentchase a " .
	" INNER JOIN $this->tablereminder b ON a.reminder_id=b.reminder_id".
        " INNER JOIN $this->tablesemester c ON a.semester_id = c.semester_id".
        " INNER JOIN $this->tablestudent d ON a.student_id = d.student_id".
        " $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showstudentchasetable with sql:$sql");

  return $sql;
  } // end of member function getSQLStr_AllStudentchase

 public function showStudentchaseTable($wherestring,$orderbystring){


        $this->log->showLog(3,"Showing Student Reminder Table");
	$sql=$this->getSQLStr_AllStudentchase($wherestring,$orderbystring);

	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='0' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Reminder Title</th>
				<th style="text-align:center;">Student</th>
                                <th style="text-align:center;">Semester</th>
                                <th style="text-align:center;">Date</th>
				<th style="text-align:center;display:none">Default Level</th>
                                <th style="text-align:center;">Isactive</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
                $studentchase_id=$row['studentchase_id'];
		$reminder_id=$row['reminder_id'];
                $reminder_title=$row['reminder_title'];
		$student_id=$row['student_id'];
                $student_name=$row['student_name'];
		$semester_id=$row['semester_id'];
                $semester_name=$row['semester_name'];
                $studentchase_date=$row['studentchase_date'];
		$defaultlevel=$row['defaultlevel'];
                $organization_id = $row['organization_id'];
		$isactive=$row['isactive'];
                $remarks = $row['remarks'];

		if($isactive==0)
		{$isactive='N';
		$isactive="<b style='color:red;'>N</b>";
		}
		else
		$isactive='Y';


		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
                        <td class="$rowtype" style="text-align:center;">$reminder_title</td>
			<td class="$rowtype" style="text-align:center;">$student_name</td>
                        <td class="$rowtype" style="text-align:center;">$semester_name</td>
                        <td class="$rowtype" style="text-align:center;">$studentchase_date</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;display:none">$defaultlevel</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="studentchase.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this student reminder'>
				<input type="hidden" value="$studentchase_id" name="studentchase_id">
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
  public function getLatestStudentchaseID() {
	$sql="SELECT MAX(studentchase_id) as studentchase_id from $this->tablestudentchase;";
	$this->log->showLog(3,'Checking latest created studentchase_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created studentchase_id:' . $row['studentchase_id']);
		return $row['studentchase_id'];
	}
	else
	return -1;

  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablestudentchase;";
	$this->log->showLog(3,'Checking next defaultlevel');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found next defaultlevel:' . $row['defaultlevel']);
		return  $row['defaultlevel'];
	}
	else
	return 10;

  } // end

 public function allowDelete($studentchase_id){

	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where studentchase_id = $studentchase_id or last_reminder = $reminder_id or next_reminder = $reminder_id ";
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$rowcount = $row['rowcount'];
	}

	if($rowcount > 0)
	return false;
	else
	return true;
//	return $checkistrue;
	}

public function showSearchform(){
    $wherestring = "";
    echo <<< EOF
    <form action ='' method ='get'>
    <input type="hidden" name="issearch" value="Y">
    <input type="hidden" name="action" value="search">
    <table border ='0' align = 'center'>
    <tr>
    <td colspan="4"><a href="studentchase.php"><input type="button" value="New" name="newbutton"></a></td>
    </tr>
    <tr>
        <th align='center' colspan='4'>Search Form</th>
    </tr>
    <tr>
        <td class='head'>Student Name</td>
        <td class= 'even'>$this->studentctrl</td>
        <td class='head'>Semester</td>
        <td class='even'>$this->semesterctrl</td>
    </tr>

</table>
<br>
EOF;


    echo <<< EOF

<input type='submit' name='submit' value='Search'>

</form>
EOF;


if($this->issearch == "Y"){

echo "<br><br><table><th align='center'>No</th>
	<th align='center'>Student</th>
	<th align='center'>Semester</th>
	<th align='center'>Date</th>
        <th align='center' style='display:none'>Default Level</th>
        <th align='center'>Isactive</th>
        <th align='center'>Operation</th>";
   
//echo $this->student_id;

if($this->student_id > 0){
    $wherestring .= " AND a.student_id = $this->student_id";

}if($this->semester_id > 0) {
    $wherestring  .= " AND a.semester_id = $this->semester_id";
}

 $sql="SELECT a.studentchase_id,d.student_name,
        c.semester_name,a.student_id,a.semester_id,a.studentchase_date,a.organization_id,
        a.isactive,a.defaultlevel,a.remarks,a.studentchase_date FROM $this->tablestudentchase a
        INNER JOIN $this->tablesemester c ON a.semester_id = c.semester_id
        INNER JOIN $this->tablestudent d ON a.student_id = d.student_id
        WHERE a.studentchase_id >0 $wherestring ";

    $i=0;
    $rowtype="";
    $query = $this->xoopsDB -> query($sql);
    while ($row=$this->xoopsDB->fetchArray($query)){
        $i++;
        $studentchase_id=$row['studentchase_id'];
        $student_id=$row['student_id'];
        $student_name=$row['student_name'];
        $semester_id=$row['semester_id'];
        $semester_name=$row['semester_name'];
        $studentchase_date=$row['studentchase_date'];
        $defaultlevel=$row['defaultlevel'];
        $organization_id = $row['organization_id'];
        $isactive=$row['isactive'];
        $remarks = $row['remarks'];

        if($isactive==0) {$isactive='N';
            $isactive="<b style='color:red;'>N</b>";
        }
        else
            $isactive='Y';


        if($rowtype=="odd")
            $rowtype="even";
        else
            $rowtype="odd";

echo "
	<tr>
	  <td class= '$rowtype' align='center'>$i</td>
          <td class= '$rowtype'><a href='student.php?action=edit&student_id=$student_id'>$student_name<a></td>
          <td class= '$rowtype' align='center'>$semester_name</td>
          <td class= '$rowtype' align='center'>$studentchase_date</td>
          <td class= '$rowtype' align='center' style='display:none'>$defaultlevel</td>
          <td class= '$rowtype' align='center'>$isactive</td>
          <td class= '$rowtype' align='center'>

          <table>
          <tr>
          <td align='center'>
        <form action='studentchase.php' method='POST'>
        <input type='image' src='images/edit.gif' name='submit' title='Edit this student reminder'>
        <input type='hidden' value='$studentchase_id' name='studentchase_id'>
        <input type='hidden' name='action' value='edit'>
        </form>
        </td>
        <td align='center' style='display:none'>
        <form action='student_reminder.php' method='GET' target='_blank'>
        <input type='image' src='images/list.gif' name='submit' title='Preview Reminder'>
        <input type='hidden' value='$studentchase_id' name='reminder_id'>
        </form>
        </td>
        </tr>
        </table>
          
        </td>
      </tr>";
 }//end of while

}


}


public function getSelectDBAjaxStudent($strchar,$idinput,$idlayer,$ctrlid,$ocf,$table,$primary_key,$primary_name,$wherestr,$line=0){
	$retval = "";

	$limit = "";
	if($strchar == "")
	$limit = "limit 0";

	$sql = "select $primary_key as fld_id,$primary_name as fld_name,student_no from $table
		where ($primary_name like '%$strchar%' or student_no like '%$strchar%' ) and $primary_key > 0 $wherestr
		$limit";

	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	$rowtypes="";
	$i=0;
	$retval .= "<table style='width:400px'><tr><th>List</th></tr>";
	while ($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$fld_name = $row['fld_name'];
	$fld_id = $row['fld_id'];
    $student_no = $row['student_no'];

	if($rowtypes=="even")
	$rowtypes = "odd";
	else
	$rowtypes = "even";

	$idtr = $idinput.$i;

	$onchangefunction = "";
    /*
	if($ocf==1){
		if($primary_key == "bpartner_id")
		$onchangefunction = "getBPInfo($fld_id)";
		else if($primary_key == "product_id")
		$onchangefunction = "getProductInfo($fld_id,$line)";
	}*/

	$retval .= "<tr  class='$rowtypes' onmouseover=onmover('idTRLine$idtr') onmouseout=onmout('idTRLine$idtr','$rowtypes') id='idTRLine$idtr' onclick=selectList('$fld_id','$idinput','$idlayer','$ctrlid','$onchangefunction');  style='cursor:pointer'>";
	$retval .= "<td>$fld_name ($student_no)</td>";
	$retval .= "</tr>";
	}


	$retval .= "</table>";

	return $retval;
 	}

} // end of ClassStudentchase
?>

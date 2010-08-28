<?php


class Courseloan
{

  public $courseloan_id;
  public $courseloan_name;
  public $courseloan_no;
  public $courseloan_category;
  
  public $course_id;
  public $semester_id;
  public $courseloantype_id;
  public $courseloan_crdthrs1;
  public $courseloan_crdthrs2;
  public $exam_hour;

  public $organization_id;
  public $isactive;
  public $description;
  public $defaultlevel;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tablecourseloan;
  private $tablebpartner;

  private $log;


//constructor
   public function Courseloan(){
	global $xoopsDB,$log,$tablecourseloan,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport;
    global $tablecourseloantype,$tablesemester,$tablecourse,$tableemployee,$tablecourseloanlecturer,$tablecourseloannote;
    global $tablecourseloanline,$tableproduct;
    
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablecourseloan=$tablecourseloan;
    $this->tablecourseloantype=$tablecourseloantype;
    $this->tablesemester=$tablesemester;
    $this->tablecourse=$tablecourse;
	$this->tablebpartner=$tablebpartner;
    $this->tableemployee=$tableemployee;
    $this->tablecourseloanlecturer=$tablecourseloanlecturer;
    $this->tablecourseloannote=$tablecourseloannote;
    $this->tablecourseloanline=$tablecourseloanline;
    $this->tableproduct=$tableproduct;
	
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int courseloan_id
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $courseloan_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    $header=""; // parameter to display form header
	$action="";
	$savectrl="";
    $searchctrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New";
		$action="create";
	 	
		if($courseloan_id==0){
			$this->courseloan_name="";
			$this->isactive="";
			$this->defaultlevel=10;
			$courseloanchecked="CHECKED";
			$this->courseloan_no = getNewCode($this->xoopsDB,"courseloan_no",$this->tablecourseloan,"");

		}
		$savectrl="<input astyle='height: 40px;' name='btnSave' value='Save' type='submit'>";
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
		$savectrl="<input name='courseloan_id' value='$this->courseloan_id' type='hidden'>".
			 "<input astyle='height: 40px;' name='btnSave' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablecourseloan' type='hidden'>".
		"<input name='id' value='$this->courseloan_id' type='hidden'>".
		"<input name='idname' value='courseloan_id' type='hidden'>".
		"<input name='title' value='Courseloan' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";


		$header="Edit";
		
		if($this->allowDelete($this->courseloan_id))
		$deletectrl="<FORM action='courseloan.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this courseloan?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->courseloan_id' name='courseloan_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='courseloan.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";
	}

    $searchctrl="<Form action='courseloan.php' method='POST'>
                            <input name='btnSearch' value='Search' type='submit'>
                            <input name='action' value='search' type='hidden'>
                            </form>";

    $selectS="";
    $selectQ="";
    $selectP="";
    $selectL="";
    if($this->courseloan_category=="S")
    $selectS = "SELECTED";
    else if($this->courseloan_category=="Q")
    $selectQ = "SELECTED";
    else if($this->courseloan_category=="P")
    $selectP = "SELECTED";
    else if($this->courseloan_category=="L")
    $selectL = "SELECTED";
  

    echo <<< EOF


<table style="width:140px;">
<tbody>
<td>$addnewctrl</td>
<td>$searchctrl</td>
<td><form onsubmit="return validateCourseloan()" method="post"
 action="courseloan.php" name="frmCourseloan"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>

<input type="hidden" name="deletesubline_id" value="0">
<input type="hidden" name="deletenoteline_idss" value="0">

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

        <tr style="display:none">
        <td class="head" style="display:none">Courseloan Code $mandatorysign</td>
        <td class="even" style="display:none"><input maxlength="30" size="15" name="courseloan_no" value="$this->courseloan_no"></td>
        <td class="head">Courseloan Name $mandatorysign</td>
        <td class="even" ><input maxlength="100" size="50" name="courseloan_name" value="$this->courseloan_name"></td>
        </tr>

        <tr>
        <td class="head">Course</td>
        <td class="even" colspan="3">$this->coursectrl</td>
        </tr>

        <tr>
        <td class="head">Description</td>
        <td class="even" colspan='3'><textarea name="description" cols="60" rows="10">$this->description</textarea></td>
        </tr>
 
    </tbody>
  </table>
EOF;
      if ($type!="new"){
    $this->getSubTable($this->courseloan_id);
    }

echo <<< EOF

<br>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td></tbody></table>
  <br>

$recordctrl

EOF;
  } // end of member function getInputForm

   public function getSubTable($courseloan_id){
        global $ctrl;
        $widthsubcourseloan = "style = 'width:200px' ";

        $sql = "select * from $this->tablecourseloanline
                    where courseloan_id = $courseloan_id ";

        $this->log->showLog(4,"getLecturerTable :" . $sql . "<br>");

        $query=$this->xoopsDB->query($sql);

        //$productctrl = $ctrl->getSelectProduct(0,'Y',"","addsubcourseloan_id","",'addsubcourseloan_id',$widthsubcourseloan,'Y',0);

echo <<< EOF


        <br>
        <table id="tblSub" astyle="background-color:yellow">

        <tr>
        <td colspan="9" align="left">
        <table>
        <tr>
        <td width="1px" nowrap><input type="button" name="addSub" value="Add Item" onclick="checkAddSelect()"></td>
        <td nowrap> $courseloanctrl</td>
        <!--<td align="right"><a>Hide Lecturer >></a></td>-->
        </tr>
        </table>
        </td>
        </tr>

        <tr>
        <th align="left" colspan="9">List Of Item</th>
        </tr>
        </tr>
        <tr>
        <th align="center">No</th>
        <th align="center">Semester</th>
        <th align="center">Amount (RM)</th>
        <th align="center">Delete</th>
        </tr>
        <input type="hidden" name="addcourseloan_id" value="0">
        <input type="hidden" name="deleteline_id" value="0">

EOF;

        $rowtype="";
        $i=0;
        while($row=$this->xoopsDB->fetchArray($query)){
        $i++;
        if($rowtype=="odd")
        $rowtype="even";
        else
        $rowtype="odd";

        $courseloanline_id = $row['courseloanline_id'];
        $semester_id = $row['semester_id'];
        $line_amt = $row['line_amt'];
        $line_desc = $row['line_desc'];

        $semesterctrlline = $ctrl->getSelectSemester($semester_id,'Y',"","semester_id[$i]");
        //$accountstctrlline = $ctrl->getSelectAccounts($accounts_id,'Y',"","accounts_id[$i]","","N","N","N","accounts_id$i","style='width:180px'");

        $styleremarks = "style='display:none'";
        if($line_desc != "")
        $styleremarks= "";

echo <<< EOF
        <tr height="3">
        <td></td>
        </tr>
        <tr>
        <input type="hidden" name="courseloanline_id[$i]" value="$courseloanline_id">
        <td class="$rowtype" align="center">$i</td>
        <td class="$rowtype" align="left" nowrap>$semesterctrlline</td>
        </td>
        <td class="$rowtype" align="center"><input id = "line_amt$i" name="line_amt[$i]" value="$line_amt" size="8" maxlength="12" onfocus="select()"></td>
        <td class="$rowtype" align="center"><input type="button" name="btnDeleteLect" value="x" onclick="deleteSubLine($courseloanline_id)"></td>
        </tr>

        <tr>
        <td colspan="8" class="$rowtype">
        <a style="cursor:pointer" onclick="viewRemarkLine($i)">View/Hide Remarks</a>
        <br><input name="line_desc[$i]" value="$line_desc" size="40" maxlength="255" id="idLineDesc$i" $styleremarks></td>
        </tr>

EOF;
        }

        if($i==0)
        echo "<tr><td colspan='9' class='odd'><font color='red'>Please Define Item For This Course.</red></td></tr>";
echo <<< EOF
        </table>
EOF;

  }

  /**
   * Update existing courseloan record
   *
   * @return bool
   * @access public
   */
  public function updateCourseloan( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablecourseloan SET
	courseloan_name='$this->courseloan_name',description='$this->description',courseloan_no='$this->courseloan_no',
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',
    course_id=$this->course_id,
	organization_id=$this->organization_id WHERE courseloan_id='$this->courseloan_id'";
	$this->changesql = $sql;
	$this->log->showLog(3, "Update courseloan_id: $this->courseloan_id, $this->courseloan_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update courseloan failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update courseloan successfully.");
		return true;
	}
  } // end of member function updateCourseloan

  /**
   * Save new courseloan into database
   *
   * @return bool
   * @access public
   */
  public function insertCourseloan( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new courseloan $this->courseloan_name");
 	$sql="INSERT INTO $this->tablecourseloan (courseloan_name,courseloan_no,isactive, created,createdby,
	updated,updatedby,defaultlevel,organization_id,description,course_id)
    values(
	'$this->courseloan_name','$this->courseloan_no','$this->isactive','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->defaultlevel,$this->organization_id,'$this->description',$this->course_id)";
$this->changesql = $sql;
	$this->log->showLog(4,"Before insert courseloan SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert courseloan code $courseloan_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new courseloan $courseloan_name successfully");
		return true;
	}
  } // end of member function insertCourseloan

  /**
   * Pull data from courseloan table into class
   *
   * @return bool
   * @access public
   */
  public function fetchCourseloan( $courseloan_id) {


	$this->log->showLog(3,"Fetching courseloan detail into class Courseloan.php.<br>");
		
	$sql="SELECT * 
		 from $this->tablecourseloan where courseloan_id=$courseloan_id";
	
	$this->log->showLog(4,"ProductCourseloan->fetchCourseloan, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->courseloan_name=$row["courseloan_name"];
		$this->courseloan_no=$row["courseloan_no"];
		$this->organization_id=$row['organization_id'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->isactive=$row['isactive'];
		$this->description=$row['description'];
        $this->course_id=$row['course_id'];


   	$this->log->showLog(4,"Courseloan->fetchCourseloan,database fetch into class successfully");
	$this->log->showLog(4,"courseloan_name:$this->courseloan_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Courseloan->fetchCourseloan,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchCourseloan

  /**
   * Delete particular courseloan id
   *
   * @param int courseloan_id
   * @return bool
   * @access public
   */
  public function deleteCourseloan( $courseloan_id ) {
    	$this->log->showLog(2,"Warning: Performing delete courseloan id : $courseloan_id !");
	$sql="DELETE FROM $this->tablecourseloan where courseloan_id=$courseloan_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->changesql = $sql;
    $this->deleteAllLine($courseloan_id);
    
    
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: courseloan ($courseloan_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"courseloan ($courseloan_id) removed from database successfully!");

		return true;
		
	}
  } // end of member function deleteCourseloan

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllCourseloan( $wherestring,  $orderbystring,$limitstr="") {
  $this->log->showLog(4,"Running ProductCourseloan->getSQLStr_AllCourseloan: $sql");

    $wherestring .= " and a.course_id = b.course_id ";
    $sql="SELECT a.*,b.course_name,b.course_no
                FROM $this->tablecourseloan a,  $this->tablecourse b  " .
	" $wherestring $orderbystring $limitstr";
    $this->log->showLog(4,"Generate showcourseloantable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllCourseloan

 public function showCourseloanTable($wherestring,$orderbystring,$limitstr=""){
	
	$this->log->showLog(3,"Showing Courseloan Table");
	$sql=$this->getSQLStr_AllCourseloan($wherestring,$orderbystring,$limitstr);
	
	$query=$this->xoopsDB->query($sql);

    if($limitstr!=""){
    $records = str_replace("limit","",$limitstr);
    $limitdisplay=" Show Only $records Record(s)";
    }
	echo <<< EOF
	<table border='0' cellspacing='3'>
  		<tbody>
<b>$limitdisplay</b>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Course</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;display:none">Default Level</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$courseloan_id=$row['courseloan_id'];
		$courseloan_name=$row['courseloan_name'];
		$courseloan_no=$row['courseloan_no'];
		$course_id=$row['course_id'];
        $course_name=$row['course_name'];
        $course_no=$row['course_no'];
        
        $credit_hrs = "$courseloan_crdthrs1 + $courseloan_crdthrs2";

		$defaultlevel=$row['defaultlevel'];

		$isactive=$row['isactive'];
		
		if($isactive==0)
		{$isactive='N';
		$isactive="<b style='color:red;'>N</b>";
		}
		else
		$isactive='Y';

       
   if($courseloan_category=="S")
   $courseloan_category = "Courseloan";
   else
    $courseloan_category = "Co Curriculum";


		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

            
		echo <<< EOF
        
		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:left;">$course_name ($course_no)</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;display:none">$defaultlevel</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="courseloan.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this courseloan'>
				<input type="hidden" value="$courseloan_id" name="courseloan_id">
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
  public function getLatestCourseloanID() {
	$sql="SELECT MAX(courseloan_id) as courseloan_id from $this->tablecourseloan;";
	$this->log->showLog(3,'Checking latest created courseloan_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created courseloan_id:' . $row['courseloan_id']);
		return $row['courseloan_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablecourseloan;";
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

 public function allowDelete($courseloan_id){
	
	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where courseloan_id = $courseloan_id or last_courseloan = $courseloan_id or next_courseloan = $courseloan_id ";
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$rowcount = $row['rowcount'];
	}

	if($rowcount > 0)
	return false;
	else{
	return true;
    }
//	return $checkistrue;
	}

     public function showSearchForm($wherestr){


	if($this->issearch != "Y"){
	$this->quotation_no = "";
	$this->isactive = "null";
	$this->courseloan_category = "";
	}

	//iscomplete
    
	if($this->isactive == "1")
	$selectactiveY = "selected = 'selected'";
	else if($this->isactive == "0")
	$selectactiveN = "selected = 'selected'";
	else
	$selectactiveL = "selected = 'selected'";

    $selectS="";
    $selectQ="";
    $selectP="";
    $selectL="";
    $selectN="";
   if($this->courseloan_category=="S")
   $selectS = "SELECTED";
   else if($this->courseloan_category=="Q")
   $selectQ = "SELECTED";
   else if($this->courseloan_category=="P")
   $selectP = "SELECTED";
   else if($this->courseloan_category=="L")
   $selectL = "SELECTED";
   else
	$selectN = "SELECTED";

	//echo $this->iscomplete;

echo <<< EOF
<form name="frmCourseloan" action="courseloan.php" method="POST">
	</form>
	<form name="frmSearch" action="courseloan.php" method="POST">

	<table>
	<tr>
	<td nowrap><input value="Reset" type="reset">
	<input value="New" type="button" onclick="gotoAction('');"></td>
	</tr>
	</table>

	<table border="0">
	<input name="issearch" value="Y" type="hidden">
	<input name="action" value="search" type="hidden">
	<tr><th colspan="4">Criterial</th></tr>

	<tr style="display:none">
	<td class="head">Courseloan Code</td>
	<td class="even"><input name="courseloan_no" value="$this->courseloan_no"></td>
	<td class="head">Courseloan Name</td>
	<td class="even"><input name="courseloan_name" value="$this->courseloan_name"></td>
	</tr>

    <tr>
    <td class="head" style="display:none">Courseloan Type</td>
    <td class="even" style="display:none">$this->courseloantypectrl</td>
    <td class="head">Course</td>
    <td class="even" colspan="3">$this->coursectrl</td>
    </tr>


	<tr>
	
	<td class="head" style="display:none">Courseloan Category</td>
	<td class="even" acolspan="3" style="display:none">
    <select name="courseloan_category">
    <option value="" $selectQ>Null</option>
    <option value="S" $selectS>Courseloan</option>
    <option value="Q" $selectQ>Co Curriculum</option>
    <option value="L" $selectL>Practical</option>
    <option value="P" $selectP>Project</option>
    </select>
    </td>
<td class="head">Is Active</td>
	<td class="even" colspan="3">
	<select name="isactive">
	<option value="null" $selectactiveL>Null</option>
	<option value=1 $selectactiveY>Yes</option>
	<option value=0 $selectactiveN>No</option>
	</select>
	</td>
	</tr>


	<tr>
	<th colspan="4"><input type="submit" aonclick="gotoAction('search');" value="Search" ></th>
	</tr>

	</table>
	</form>
	<br>
EOF;
  }

	public function getWhereStr(){

	$wherestr = "";

    if($this->courseloan_category != "")
	$wherestr .= " and a.courseloan_category like '$this->courseloan_category' ";
	if($this->courseloan_no != "")
	$wherestr .= " and a.courseloan_no like '$this->courseloan_no' ";
    if($this->courseloan_name != "")
	$wherestr .= " and a.courseloan_name like '$this->courseloan_name' ";
    if($this->courseloantype_id > 0)
	$wherestr .= " and a.courseloantype_id = $this->courseloantype_id ";
	if($this->course_id > 0)
	$wherestr .= " and a.course_id = $this->course_id ";
	if($this->isactive == "0" || $this->isactive == "1")
	$wherestr .= " and a.isactive = $this->isactive ";

	return $wherestr;

	}

    public function getSelectDBAjaxProduct($strchar,$idinput,$idlayer,$ctrlid,$ocf,$table,$primary_key,$primary_name,$wherestr,$line=0){
	$retval = "";

	$limit = "";
	if($strchar == "")
	$limit = "limit 0";

	$sql = "select $primary_key as fld_id,$primary_name as fld_name from $table a 
		where ($primary_name like '%$strchar%' ) and $primary_key > 0 $wherestr
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
		else if($primary_key == "semester_id")
		$onchangefunction = "getProductInfo($fld_id,$line)";
	}*/

    $onchangefunction = "getProductInfo($fld_id,$line)";

	$retval .= "<tr  class='$rowtypes' onmouseover=onmover('idTRLine$idtr') onmouseout=onmout('idTRLine$idtr','$rowtypes') id='idTRLine$idtr' onclick=selectList('$fld_id','$idinput','$idlayer','$ctrlid','$onchangefunction');  style='cursor:pointer'>";
	$retval .= "<td>$fld_name</td>";
	$retval .= "</tr>";
	}


	$retval .= "</table>";

	return $retval;
 	}

    public function addSubLine($courseloan_id){
        $timestamp= date("y/m/d H:i:s", time()) ;
        $sql = " insert into $this->tablecourseloanline (courseloan_id,created,createdby,updated,updatedby)
        values ($courseloan_id,'$timestamp',$this->updatedby,'$timestamp',$this->updatedby) ";
        $this->changesql = $sql;
        
        $this->log->showLog(4,"Before insert courseloan addSubLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        return true;
    }

    public function updateSubLine(){
        $timestamp= date("y/m/d H:i:s", time()) ;
        $i=0;
        foreach($this->courseloanline_id as $id){
        $i++;

        $courseloanline_item=$this->courseloanline_item[$i];
        $semester_id=$this->semester_id[$i];       
        $line_desc=$this->line_desc[$i];
        $line_amt=$this->line_amt[$i];


        $sql = "update $this->tablecourseloanline set 
        semester_id = $semester_id,
        line_amt = $line_amt,
        line_desc = '$line_desc'
        where courseloanline_id = $id ";

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert courseloan updateLecturerLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        }

        return true;
    }

    public function deleteSubLine($courseloanline_id){

        $sql = "delete from $this->tablecourseloanline where courseloanline_id = $courseloanline_id";

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert courseloan deleteSubLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }else
        return true;
        
    }

    public function addNoteLine($courseloan_id){

        $sql = " insert into $this->tablecourseloannote (courseloan_id) values ($courseloan_id) ";
        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert courseloan addNoteLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        return true;
    }

    public function updateNoteLine(){

        $i=0;
        foreach($this->courseloannoteline_id as $id){
        $i++;

        $courseloannote_title = $this->courseloannote_title[$i];
        $courseloannote_description = $this->courseloannote_description[$i];
        $isdownload = $this->isdownload[$i];
        $isdeleteline = $this->isdeleteline[$i];

        if($isdownload == "on")
        $isdownload = 1;
        else
        $isdownload = 0;

        if($isdeleteline == "on"){
        $this->deleteNoteLine($id);
        }else{
        $sql = "update $this->tablecourseloannote
                    set courseloannote_title = '$courseloannote_title',
                    courseloannote_description = '$courseloannote_description',
                    isdownload = '$isdownload' 
                    where courseloannoteline_id = $id ";
        

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert courseloan updateNoteLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }
        
        $this->saveAtt($this->atttmpfile[$i],$this->attfilesize[$i],$this->attfiletype[$i],$this->attfilename[$i],$id);
        }

        }

        return true;
    }

    public function deleteNoteLine($courseloannoteline_id){

        $sql = "delete from $this->tablecourseloannote where courseloannoteline_id = $courseloannoteline_id";

        $this->changesql = $sql;
        $this->deletefile($courseloannoteline_id);
        
        $this->log->showLog(4,"Before insert courseloan deleteNoteLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }else{
            
            return true;
        }

    }

    public function saveAtt($atttmpfile,$attfilesize,$attfiletype,$attfilename,$courseloannoteline_id){
	//$file_ext = "jpg";


	$file_ext = strrchr($attfilename, '.');

	$attfilesize = $attfilesize / 1024;
	//&& $attfilesize<300
	if($attfilesize>0 ){
	$newfilename = $courseloannoteline_id."$file_ext";
	$this->savefile($atttmpfile,$newfilename,$courseloannoteline_id);
	}


	}

    public function savefile($tmpfile,$newfilename,$courseloannoteline_id){

        if(move_uploaded_file($tmpfile, "upload/courseloan/$newfilename")){
        $sqlupdate="UPDATE $this->tablecourseloannote set filenote='$newfilename' where courseloannoteline_id=$courseloannoteline_id";
        $qryUpdate=$this->xoopsDB->query($sqlupdate);
        }else{
        echo "Cannot Upload File";
        }
    }

	public function deletefile($courseloannoteline_id){
		$sql="SELECT filenote from $this->tablecourseloannote where courseloannoteline_id=$courseloannoteline_id";
		$query=$this->xoopsDB->query($sql);
		$myfilename="";
		if($row=$this->xoopsDB->fetchArray($query)){
			$myfilename=$row['filenote'];
		}
		$myfilename="upload/courseloan/$myfilename";
		$this->log->showLog(3,"This file name: $myfilename");
		unlink("$myfilename");
		$sqlupdate="UPDATE $this->tablecourseloannote set filenote='' where courseloannoteline_id=$courseloannoteline_id";
		$qryDelete=$this->xoopsDB->query($sqlupdate);
	}

    public function deleteAllLine($courseloan_id){

	$sqlselect = "select * from $this->tablecourseloannote where courseloan_id = $courseloan_id and filenote <> '' ";

	$queryselect=$this->xoopsDB->query($sqlselect);

	while($rowselect=$this->xoopsDB->fetchArray($queryselect)){

	$courseloannoteline_id = $rowselect['courseloannoteline_id'];
	$myfilename = $rowselect['filenote'];

	$myfilename = "upload/courseloan/$myfilename";
	unlink("$myfilename");

	//$this->deletefile($courseloanline_id);
	}
  }

  public function getProductInfo($semester_id){

    echo $sql = "select * from $this->tableproduct pr where semester_id = $semester_id";

    $query=$this->xoopsDB->query($sql);
    $product_name = "";
    $sellaccount_id = 0;
    $invoice_amt = "0.00";
    if($row=$this->xoopsDB->fetchArray($query)){
    $product_name=$row['product_name'];
    $sellaccount_id=$row['sellaccount_id'];
    $invoice_amt=$row['invoice_amt'];
    }

    return array("product_name"=>$product_name,"sellaccount_id"=>$sellaccount_id,"invoice_amt"=>$invoice_amt);
    
  }


} // end of ClassCourseloan
?>

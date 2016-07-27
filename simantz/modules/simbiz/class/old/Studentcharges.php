<?php


class Studentcharges
{

  public $studentinvoice_id;
  public $studentcharges_name;
  public $studentinvoice_no;
  public $studentcharges_category;
  
  public $course_id;
  public $semester_id;
  public $studentchargestype_id;
  public $studentcharges_crdthrs1;
  public $studentcharges_crdthrs2;
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
  private $tablestudentinvoice;
  private $tablebpartner;

  private $log;


//constructor
   public function Studentcharges(){
	global $xoopsDB,$log,$tablestudentinvoice,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport;
    global $tablestudentinvoicetype,$tablesemester,$tablecourse,$tableemployee,$tablestudentinvoicelecturer,$tablestudentinvoicenote;
    global $tablestudentinvoiceline,$tableproduct,$tablestudent,$tablesession,$tableyear,$tableemployee;
    global $tabledepartment;


  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablestudentinvoice=$tablestudentinvoice;
    $this->tablestudentinvoicetype=$tablestudentinvoicetype;
    $this->tablesemester=$tablesemester;
    $this->tablecourse=$tablecourse;
	$this->tablebpartner=$tablebpartner;
    $this->tableemployee=$tableemployee;
    $this->tablestudentinvoicelecturer=$tablestudentinvoicelecturer;
    $this->tablestudentinvoicenote=$tablestudentinvoicenote;
    $this->tablestudentinvoiceline=$tablestudentinvoiceline;
    $this->tableproduct=$tableproduct;
    $this->tablestudent=$tablestudent;
    $this->tablesession=$tablesession;
    $this->tableyear=$tableyear;
    $this->tableemployee=$tableemployee;
    $this->tabledepartment=$tabledepartment;

	
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int studentinvoice_id
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $studentinvoice_id,$token  ) {
      global $isreadonlywindows;
		$mandatorysign="<b style='color:red'>*</b>";

    $header=""; // parameter to display form header
	$action="";
	$savectrl="";
    $searchctrl="";
	$deletectrl="";
	$itemselect="";
	$previewctrl="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New";
		$action="create";
	 	
		if($studentinvoice_id==0){
			$this->studentcharges_name="";
			$this->isactive="";
			$this->defaultlevel=10;
			$studentchargeschecked="CHECKED";
			$this->studentinvoice_no = getNewCode($this->xoopsDB,"studentinvoice_no",$this->tablestudentinvoice,"");
            $this->studentcharges_date= getDateSession();
            $this->studentinvoice_lineamt=0;

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
		$savectrl="<input name='studentinvoiceline_id' value='$this->studentinvoiceline_id' type='hidden'>".
			 "<input astyle='height: 40px;' name='btnSave' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablestudentinvoice' type='hidden'>".
		"<input name='id' value='$this->studentinvoice_id' type='hidden'>".
		"<input name='idname' value='studentinvoice_id' type='hidden'>".
		"<input name='title' value='Studentcharges' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";


		$header="Edit";
		
		if($this->allowDelete($this->studentinvoice_id))
		$deletectrl="<FORM action='studentcharges.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this studentcharges?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->studentinvoiceline_id' name='studentinvoiceline_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='studentcharges.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";

        $previewctrl="<FORM target='_blank' action='viewstudentcharges.php' method='POST' aonSubmit='return confirm(".
		'"confirm to remove this studentcharges?"'.")'><input type='submit' value='Preview' name='btnPreview'>".
		"<input type='hidden' value='$this->studentinvoice_id' name='studentinvoice_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
	}

    $searchctrl="<Form action='studentcharges.php' method='POST'>
                            <input name='btnSearch' value='Search' type='submit'>
                            <input name='action' value='search' type='hidden'>
                            </form>";


      $stylesave = "";
      if($this->studentinvoice_id >0)
      $stylesave = "style='display:none'";


          $actionform = 'action="studentcharges.php"';
    $this->styleviewwindows = "";
    if($isreadonlywindows==1){
    $addnewctrl = "";
    $deletectrl = "";
    $savectrl = "";
    $actionform = 'onsubmit="return false"';
    $this->styleviewwindows = "style='display:none'";
    }

    echo <<< EOF


<table style="width:140px;">
<tbody>
<td>$addnewctrl</td>
<td>$searchctrl</td>
<td><form onsubmit="return validateStudentcharges()" method="post"
 action="studentcharges.php" name="frmStudentcharges"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>


  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
        <tr>
        <th colspan="4" rowspan="1">$header</th>
        </tr>

        <tr>
        <td class="head">Student</td>
        <td class="even" colspan="3">$this->studentctrl</td>
        </tr>

        <tr>
        <td class="head">Item</td>
        <td class="even">
        <input maxlength="100" size="30" name="studentinvoice_item" value="$this->studentinvoice_item">
        <a title="Add By Product" style="cursor:pointer" onclick="viewProduct()"> >> </a><br>
        <div id="idProductCtrl" style="display:none">$this->productctrl</div>
        </td>
        <td class="head">Amount (RM)</td>
        <td class="even"><input maxlength="11" size="11" name="studentinvoice_lineamt" value="$this->studentinvoice_lineamt"></td>
        </tr>

        <tr>
        <td class="head">Description</td>
        <td class="even" colspan='3'><textarea name="line_desc" cols="40" rows="4">$this->line_desc</textarea></td>
        </tr>
 
    </tbody>
  </table>
EOF;


echo <<< EOF

<br>
<table astyle="width:150px;"><tbody><td width=1 $stylesave>$savectrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form>
    <td align="right" $stylesave>$deletectrl</td>
    </tbody></table>
  <br>

$recordctrl

EOF;
  } // end of member function getInputForm

  /**
   * Update existing studentcharges record
   *
   * @return bool
   * @access public
   */
  public function updateStudentcharges( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablestudentinvoiceline SET
    product_id=$this->product_id ,student_id=$this->student_id ,
    studentinvoice_item='$this->studentinvoice_item' ,line_desc='$this->line_desc' ,
    studentinvoice_lineamt=$this->studentinvoice_lineamt ,studentinvoice_uprice=$this->studentinvoice_lineamt,
    studentinvoice_qty = 1,
	updated='$timestamp',updatedby=$this->updatedby 
    WHERE studentinvoice_id='$this->studentinvoice_id'";
	$this->changesql = $sql;
	$this->log->showLog(3, "Update studentinvoice_id: $this->studentinvoice_id, $this->studentcharges_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update studentcharges failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update studentcharges successfully.");
		return true;
	}
  } // end of member function updateStudentcharges

  /**
   * Save new studentcharges into database
   *
   * @return bool
   * @access public
   */
  public function insertStudentcharges( ) {
  global $charges_account;

  if($charges_account == "")
  $charges_account = 0;
  
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new studentcharges $this->studentcharges_name");
 	$sql="INSERT INTO $this->tablestudentinvoiceline
    (product_id,student_id,studentinvoice_item,studentinvoice_uprice,studentinvoice_qty,
    studentinvoice_lineamt,line_desc,
    created,createdby,updated,updatedby,mid,accounts_id)
    values(
    $this->product_id,$this->student_id,'$this->studentinvoice_item',$this->studentinvoice_lineamt,1,
    $this->studentinvoice_lineamt,'$this->line_desc',
    '$timestamp',$this->createdby,'$timestamp',$this->updatedby,$this->mid,$charges_account)";
$this->changesql = $sql;
	$this->log->showLog(4,"Before insert studentcharges SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert studentcharges code $studentcharges_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new studentcharges $studentcharges_name successfully");
		return true;
	}
  } // end of member function insertStudentcharges

  /**
   * Pull data from studentcharges table into class
   *
   * @return bool
   * @access public
   */
  public function fetchStudentcharges( $studentinvoiceline_id) {


	$this->log->showLog(3,"Fetching studentcharges detail into class Studentcharges.php.<br>");
		
	$sql="SELECT *
		 from $this->tablestudentinvoiceline where studentinvoiceline_id=$studentinvoiceline_id";
	
	$this->log->showLog(4,"ProductStudentcharges->fetchStudentcharges, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){

        $this->studentinvoice_id= $row['studentinvoice_id'];
        $this->studentinvoiceline_id= $row['studentinvoiceline_id'];
        $this->product_id=$row['product_id'];
        $this->student_id= $row['student_id'];
        $this->studentinvoice_item= $row['studentinvoice_item'];
        $this->studentinvoice_lineamt= $row['studentinvoice_lineamt'];
        $this->line_desc=$row['line_desc'];


   	$this->log->showLog(4,"Studentcharges->fetchStudentcharges,database fetch into class successfully");
	$this->log->showLog(4,"studentcharges_name:$this->studentcharges_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Studentcharges->fetchStudentcharges,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchStudentcharges

  /**
   * Delete particular studentcharges id
   *
   * @param int studentinvoice_id
   * @return bool
   * @access public
   */
  public function deleteStudentcharges( $studentinvoiceline_id ) {
    	$this->log->showLog(2,"Warning: Performing delete studentcharges id : $studentinvoice_id !");
	$sql="DELETE FROM $this->tablestudentinvoiceline where studentinvoiceline_id=$studentinvoiceline_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->changesql = $sql;
    //$this->deleteAllLine($studentinvoice_id);
    
    
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: studentcharges ($studentinvoice_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"studentcharges ($studentinvoice_id) removed from database successfully!");

		return true;
		
	}
  } // end of member function deleteStudentcharges

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllStudentcharges( $wherestring,  $orderbystring,$limitstr="") {
  $this->log->showLog(4,"Running ProductStudentcharges->getSQLStr_AllStudentcharges: $sql");

    $wherestring .= " and st.student_id > 0 and si.mid = $this->mid ";
    $sql="select si.*,st.student_name,st.student_no,cr.course_name,cr.course_no,
    yr.year_name,ss.session_name
    from $this->tablestudentinvoiceline si
    inner join $this->tablestudent st on st.student_id = si.student_id
    inner join $this->tablesession ss on ss.session_id = st.session_id
    inner join $this->tableyear yr on yr.year_id = st.year_id
    inner join $this->tablecourse cr on cr.course_id = st.course_id
    $wherestring $orderbystring $limitstr";
    $this->log->showLog(4,"Generate showstudentchargestable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllStudentcharges

 public function showStudentchargesTable($wherestring,$orderbystring,$limitstr=""){
	
	$this->log->showLog(3,"Showing Studentcharges Table");
	 $sql=$this->getSQLStr_AllStudentcharges($wherestring,$orderbystring,$limitstr);
	
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
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Department</th>
				<th style="text-align:center;">Student</th>
				<th style="text-align:center;">Course</th>
				<th style="text-align:center;">Item</th>
				<th style="text-align:center;">Amount (RM)</th>
				<th style="text-align:center;">Complete</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;

        $studentinvoice_id=$row['studentinvoice_id'];
        $student_id=$row['student_id'];
        $studentinvoiceline_id=$row['studentinvoiceline_id'];
        $student_name=$row['student_name'];
        $student_no=$row['student_no'];
        $course_name=$row['course_name'];
        $course_no=$row['course_no'];
        $semester_name=$row['semester_name'];
        $year_name=$row['year_name'];
        $session_name=$row['session_name'];
        $studentinvoice_lineamt=$row['studentinvoice_lineamt'];
        $studentinvoice_item=$row['studentinvoice_item'];
        $department_name=$row['department_name'];
        $created=substr($row['created'],0,10);

        
        $credit_hrs = "$studentcharges_crdthrs1 + $studentcharges_crdthrs2";

		$isactive=$row['isactive'];


		if($studentinvoice_id==0)
		{$iscomplete='N';
		$iscomplete="<b style='color:red;'>N</b>";
        $styleedit = "";
		}
		else{
		$iscomplete='Y';
        $styleedit = "style='display:none'";
        }



		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

            
            
		echo <<< EOF
        
		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$created</td>
			<td class="$rowtype" style="text-align:center;">$this->module_name</td>
			<td class="$rowtype" style="text-align:left;"><a target="blank" href="../hes/student.php?action=edit&student_id=$student_id">$student_name ($student_no)</a></td>

			<td class="$rowtype" style="text-align:center;">$course_no</td>
			<td class="$rowtype" style="text-align:left;" nowrap>$studentinvoice_item</td>
			<td class="$rowtype" style="text-align:center;">$studentinvoice_lineamt</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
                <table><tr><td>
				<form action="studentcharges.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this Student Charges' $styleedit>
				<input type="hidden" value="$studentinvoiceline_id" name="studentinvoiceline_id">
				<input type="hidden" name="action" value="edit">
				</form>
                </td>
                </tr></table>
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
  public function getLatestStudentchargesID() {
	$sql="SELECT MAX(studentinvoiceline_id) as studentinvoiceline_id from $this->tablestudentinvoiceline ;";
	$this->log->showLog(3,'Checking latest created studentinvoice_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created studentinvoice_id:' . $row['studentinvoice_id']);
		return $row['studentinvoiceline_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablestudentinvoice;";
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

 public function allowDelete($studentinvoice_id){
	
	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where studentinvoice_id = $studentinvoice_id or last_studentcharges = $studentinvoice_id or next_studentcharges = $studentinvoice_id ";
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
	$this->studentcharges_category = "";
	}

	

	//echo $this->iscomplete;

echo <<< EOF
<form name="frmStudentcharges" action="studentcharges.php" method="POST">
	</form>
	<form name="frmSearch" action="studentcharges.php" method="POST">

	<table>
	<tr>
	<td nowrap><input value="Reset" type="reset">
	<input value="New" type="button" onclick="gotoAction('');"></td>
	</tr>
	</table>

	<table border="0">
	<input name="issearch" value="Y" type="hidden">
	<input name="action" value="search" type="hidden">
	<tr><th colspan="4">Search Criterial</th></tr>

	<tr>
	<td class="head">Student</td>
	<td class="even"colspan="3" >$this->studentctrl</td>
	</tr>

	<tr>
	<td class="head">Student Name</td>
	<td class="even"><input name="student_name" value="$this->student_name"></td>
	<td class="head">Matrix No</td>
	<td class="even"><input name="student_no" value="$this->student_no"></td>
	</tr>

	
    <tr>
    <td class="head">Course</td>
    <td class="even" colspan="3">$this->coursectrl</td>
    </tr>


	<tr style="display:none">
	
    <td class="head">Is Active</td>
	<td class="even" acolspan="3">
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



    if($this->student_id > 0)
	$wherestr .= " and st.student_id = $this->student_id ";
    if($this->student_name != "")
	$wherestr .= " and st.student_name like '$this->student_name' ";
    if($this->student_no != "")
	$wherestr .= " and st.student_no like '$this->student_no' ";
    if($this->course_id > 0)
	$wherestr .= " and st.course_id = $this->course_id ";
    /*
	if($this->year_id > 0)
	$wherestr .= " and st.year_id = $this->year_id ";
	if($this->session_id > 0)
	$wherestr .= " and st.session_id = $this->session_id ";
     * 
     */
	if($this->semester_id > 0)
	$wherestr .= " and st.semester_id = $this->semester_id ";
    /*
	if($this->isactive == "0" || $this->isactive == "1")
	$wherestr .= " and a.isactive = $this->isactive ";
     * 
     */

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
		else if($primary_key == "product_id")
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

    public function addSubLine($studentinvoice_id){
        $timestamp= date("y/m/d H:i:s", time()) ;
        $sql = " insert into $this->tablestudentinvoiceline (studentinvoice_id,studentcharges_qty,created,createdby,updated,updatedby)
        values ($studentinvoice_id,1,'$timestamp',$this->updatedby,'$timestamp',$this->updatedby) ";
        $this->changesql = $sql;
        
        $this->log->showLog(4,"Before insert studentcharges addSubLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        return true;
    }

    public function updateSubLine(){
        $timestamp= date("y/m/d H:i:s", time()) ;
        $i=0;
        foreach($this->studentchargesline_id as $id){
        $i++;

        $studentcharges_item=$this->studentcharges_item[$i];
        $product_id=$this->product_id[$i];
        $accounts_id=$this->accounts_id[$i];
        $studentchargesline_no=$this->studentchargesline_no[$i];
        $line_desc=$this->line_desc[$i];
        $studentcharges_uprice=$this->studentcharges_uprice[$i];
        $studentcharges_qty=$this->studentcharges_qty[$i];
        $studentcharges_lineamt=$this->studentcharges_lineamt[$i];


        $sql = "update $this->tablestudentinvoiceline
        set studentcharges_item = '$studentcharges_item',
        product_id = $product_id,
        accounts_id = $accounts_id,
        studentchargesline_no = '$studentchargesline_no',
        line_desc = '$line_desc',
        studentcharges_uprice = $studentcharges_uprice,
        studentcharges_qty = $studentcharges_qty,
        studentcharges_lineamt = $studentcharges_lineamt
        where studentchargesline_id = $id ";

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert studentcharges updateLecturerLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        }

        return true;
    }

    

  public function getProductInfo($product_id){

    $sql = "select * from $this->tableproduct pr where product_id = $product_id";

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

    public function updateAlertLine(){
       $timestamp= date("y/m/d H:i:s", time()) ;
       $this->changesql = "";
       $i=0;
       foreach($this->studentchargesline_idremain as $studentchargesline_id){
       $i++;

            if($this->isselectremain[$i] == "on"){
                $sql = "update $this->tablestudentinvoiceline set studentinvoice_id = $this->studentinvoice_id
                where studentchargesline_id = $studentchargesline_id ;";

                    $this->changesql .= $sql;
                    $query=$this->xoopsDB->query($sql);
                    if(!$query){
                    return false;
                    }
            }

       }

       return true;
    }

    public function updateTotalAmount($studentinvoice_id){

        $sql = "update $this->tablestudentinvoice set
                    total_amt = (select sum(studentcharges_lineamt) from $this->tablestudentinvoiceline
                    where studentinvoice_id = $studentinvoice_id )
                    where studentinvoice_id = $studentinvoice_id ";
        
        $query=$this->xoopsDB->query($sql);
        if(!$query){
        return false;
        }else{
        return false;
        }
    }

} // end of ClassStudentcharges
?>

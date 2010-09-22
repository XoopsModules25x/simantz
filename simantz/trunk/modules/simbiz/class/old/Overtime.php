<?php


class Overtime
{

  public $overtime_id;
  public $overtime_name;
  public $overtime_no;
  public $overtime_category;
  
  public $course_id;
  public $semester_id;
  public $overtimetype_id;
  public $overtime_crdthrs1;
  public $overtime_crdthrs2;
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
  private $tableovertime;
  private $tablebpartner;

  private $log;


//constructor
   public function Overtime(){
	global $xoopsDB,$log,$tableovertime,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport;
    global $tableovertimetype,$tablesemester,$tablecourse,$tableemployee,$tableovertimelecturer,$tableovertimenote;
    global $tableovertimeline,$tableproduct,$tablestudent,$tablesession,$tableyear,$tableemployee;
    global $tabledepartment;


  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tableovertime=$tableovertime;
    $this->tableovertimetype=$tableovertimetype;
    $this->tablesemester=$tablesemester;
    $this->tablecourse=$tablecourse;
	$this->tablebpartner=$tablebpartner;
    $this->tableemployee=$tableemployee;
    $this->tableovertimelecturer=$tableovertimelecturer;
    $this->tableovertimenote=$tableovertimenote;
    $this->tableovertimeline=$tableovertimeline;
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
   * @param int overtime_id
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $overtime_id,$token  ) {
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
	 	
		if($overtime_id==0){
			$this->overtime_name="";
			$this->isactive="";
			$this->defaultlevel=10;
			$overtimechecked="CHECKED";
			$this->overtime_no = getNewCode($this->xoopsDB,"overtime_no",$this->tableovertime,"");
            $this->overtimeline_date= getDateSession();

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
		$savectrl="<input name='overtimeline_id' value='$this->overtimeline_id' type='hidden'>".
			 "<input astyle='height: 40px;' name='btnSave' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableovertimeline' type='hidden'>".
		"<input name='id' value='$this->overtimeline_id' type='hidden'>".
		"<input name='idname' value='overtimeline_id' type='hidden'>".
		"<input name='title' value='Overtime' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";


		$header="Edit";
		
		if($this->allowDelete($this->overtime_id))
		$deletectrl="<FORM action='overtime.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this overtime?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->overtimeline_id' name='overtimeline_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='overtime.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";

        $previewctrl="<FORM target='_blank' action='../system/class/XMLParameter.php' method='POST' aonSubmit='return confirm(".
		'"confirm to remove this overtime?"'.")'><input type='submit' value='Preview' name='btnPreview'>".
		"<input type='hidden' value='$this->overtime_id' name='fld_value'>".
                "<input type='hidden' value='overtime_id' name='fld_name'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
	}

    $searchctrl="<Form action='overtime.php' method='POST'>
                            <input name='btnSearch' value='Search' type='submit'>
                            <input name='action' value='search' type='hidden'>
                            </form>";


      $stylesave = "";
      if($this->overtime_id >0)
      $stylesave = "style='display:none'";

      $styletimehours = "";
      if($this->overtimeline_type == "T")
      $styletimehours = "style='display:none'";

    echo <<< EOF


<table style="width:140px;">
<tbody>
<td>$addnewctrl</td>
<td>$searchctrl</td>
<td><form onsubmit="return validateOvertime()" method="post"
 action="overtime.php" name="frmOvertime"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>


  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
        <tr>
        <th colspan="4" rowspan="1">$header</th>
        </tr>

        <tr>
        <td class="head">Employee</td>
        <td class="even" colspan="3">$this->employeectrl</td>
        </tr>

        <tr>
        <td class="head">Date</td>
        <td class="even">
        <input name='overtimeline_date' id='overtimeline_date' value="$this->overtimeline_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->overtimedatectrl"> <font color=red>YYYY-MM-DD (Ex: 2009-01-30)</font>
        </td>
        <td class="head">Type</td>
        <td class="even">
        <select name="overtimeline_type" onchange="viewHours(this.value)">
        <option value="H" $selectTypeH>By Hours</option>
        <option value="T" $selectTypeT>By Trip</option>
        </select>
        </td>
        </tr>


        <tr id="idTimeHours" $styletimehours>
        <td class="head">Time In</td>
        <td class="even"><input maxlength="4" size="4" name="overtimeline_starttime" value="$this->overtimeline_starttime"> (HHMM) 24 Hours Format</td>
        <td class="head">Time Out</td>
        <td class="even"><input maxlength="4" size="4" name="overtimeline_endtime" value="$this->overtimeline_endtime"> (HHMM) 24 Hours Format</td>
        </tr>


        <tr>
        <td class="head">Total Hours/Trip</td>
        <td class="even"><input maxlength="10" size="4" name="overtimeline_totalhour" value="$this->overtimeline_totalhour"></td>
        <td class="head">Description</td>
        <td class="even"><textarea name="line_desc" cols="40" rows="4">$this->line_desc</textarea></td>
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
   * Update existing overtime record
   *
   * @return bool
   * @access public
   */
  public function updateOvertime( ) {
    include_once '../hr/class/Employee.php';
    $emp = new Employee();

    $emp->fetchEmployee($this->employee_id);

    if($this->overtimeline_type == "H")
    $total_trip = $emp->employee_othour;
    else
    $total_trip = $emp->employee_ottrip;

    $total_amt = $total_trip*$this->overtimeline_totalhour;

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableovertimeline SET
    employee_id=$this->employee_id ,overtimeline_date='$this->overtimeline_date' ,
    overtimeline_starttime='$this->overtimeline_starttime' ,overtimeline_endtime='$this->overtimeline_endtime' ,
    overtimeline_basicsalary=$emp->employee_salary ,overtimeline_totalhour=$this->overtimeline_totalhour,
    overtimeline_rate = $total_trip,overtimeline_type='$this->overtimeline_type',
    overtimeline_totalamt = $total_amt,line_desc = '$this->line_desc',
	updated='$timestamp',updatedby=$this->updatedby 
    WHERE overtimeline_id='$this->overtimeline_id'";
	$this->changesql = $sql;
	$this->log->showLog(3, "Update overtime_id: $this->overtime_id, $this->overtime_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update overtime failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update overtime successfully.");
		return true;
	}
  } // end of member function updateOvertime

  /**
   * Save new overtime into database
   *
   * @return bool
   * @access public
   */
  public function insertOvertime( ) {
  global $charges_account;
    include_once '../hr/class/Employee.php';
    $emp = new Employee();

    $emp->fetchEmployee($this->employee_id);

    if($this->overtimeline_type == "H")
    $total_trip = $emp->employee_othour;
    else
    $total_trip = $emp->employee_ottrip;

    $total_amt = $total_trip*$this->overtimeline_totalhour;
    
    $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new overtime $this->overtime_name");
 	$sql="INSERT INTO $this->tableovertimeline
    (employee_id,overtimeline_date,overtimeline_starttime,overtimeline_endtime,
    overtimeline_totalhour,line_desc,overtimeline_type,overtimeline_rate,overtimeline_basicsalary,
    overtimeline_totalamt,
    created,createdby,updated,updatedby)
    values(
    $this->employee_id,'$this->overtimeline_date','$this->overtimeline_starttime','$this->overtimeline_endtime',
    $this->overtimeline_totalhour,'$this->line_desc','$this->overtimeline_type',$total_trip,$emp->employee_salary,
    $total_amt,
    '$timestamp',$this->createdby,'$timestamp',$this->updatedby)";
$this->changesql = $sql;
	$this->log->showLog(4,"Before insert overtime SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert overtime code $overtime_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new overtime $overtime_name successfully");
		return true;
	}
  } // end of member function insertOvertime

  /**
   * Pull data from overtime table into class
   *
   * @return bool
   * @access public
   */
  public function fetchOvertime( $overtimeline_id) {


	$this->log->showLog(3,"Fetching overtime detail into class Overtime.php.<br>");
		
	$sql="SELECT *
		 from $this->tableovertimeline where overtimeline_id=$overtimeline_id";
	
	$this->log->showLog(4,"ProductOvertime->fetchOvertime, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){

        $this->overtime_id= $row['overtime_id'];
        $this->overtimeline_id= $row['overtimeline_id'];
        $this->employee_id=$row['employee_id'];
        $this->overtimeline_date= $row['overtimeline_date'];
        $this->overtimeline_starttime= $row['overtimeline_starttime'];
        $this->overtimeline_endtime= $row['overtimeline_endtime'];
        $this->overtimeline_basicsalary= $row['overtimeline_basicsalary'];
        $this->overtimeline_totalhour= $row['overtimeline_totalhour'];
        $this->overtimeline_rate= $row['overtimeline_rate'];
        $this->overtimeline_type= $row['overtimeline_type'];
        $this->overtimeline_totalamt= $row['overtimeline_totalamt'];
        $this->line_desc=$row['line_desc'];


   	$this->log->showLog(4,"Overtime->fetchOvertime,database fetch into class successfully");
	$this->log->showLog(4,"overtime_name:$this->overtime_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Overtime->fetchOvertime,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchOvertime

  /**
   * Delete particular overtime id
   *
   * @param int overtime_id
   * @return bool
   * @access public
   */
  public function deleteOvertime( $overtimeline_id ) {
    	$this->log->showLog(2,"Warning: Performing delete overtime id : $overtime_id !");
	$sql="DELETE FROM $this->tableovertimeline where overtimeline_id=$overtimeline_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->changesql = $sql;
    //$this->deleteAllLine($overtime_id);
    
    
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: overtime ($overtime_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"overtime ($overtime_id) removed from database successfully!");

		return true;
		
	}
  } // end of member function deleteOvertime

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllOvertime( $wherestring,  $orderbystring,$limitstr="") {
  $this->log->showLog(4,"Running ProductOvertime->getSQLStr_AllOvertime: $sql");

    $wherestring .= $this->wherestremp;
    $sql="select ol.*,ot.iscomplete,em.employee_name,em.employee_id,em.employee_no
    from $this->tableovertimeline ol
    left join $this->tableovertime ot on ot.overtime_id = ol.overtime_id
    inner join $this->tableemployee em on em.employee_id = ol.employee_id
    $wherestring $orderbystring $limitstr";
    $this->log->showLog(4,"Generate showovertimetable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllOvertime

 public function showOvertimeTable($wherestring,$orderbystring,$limitstr=""){
	
	$this->log->showLog(3,"Showing Overtime Table");
	$sql=$this->getSQLStr_AllOvertime($wherestring,$orderbystring,$limitstr);
	
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
				<th style="text-align:center;">Employee</th>
				<th style="text-align:center;">Type</th>
				<th style="text-align:center;">Time In</th>
				<th style="text-align:center;">Time Out</th>
				<th style="text-align:center;">Total Hours</th>
				<th style="text-align:center;">Rate</th>
				<th style="text-align:center;">Amount (RM)</th>
				<th style="text-align:center;">Complete</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;

        $overtime_id=$row['overtime_id'];
        $overtimeline_id=$row['overtimeline_id'];
        $overtimeline_date=$row['overtimeline_date'];
        $employee_id=$row['employee_id'];
        $employee_name=$row['employee_name'];
        $overtimeline_starttime=$row['overtimeline_starttime'];
        $overtimeline_endtime=$row['overtimeline_endtime'];
        $overtimeline_totalhour=$row['overtimeline_totalhour'];
        $overtimeline_type=$row['overtimeline_type'];
        $overtimeline_totalamt=$row['overtimeline_totalamt'];
        $overtimeline_rate=$row['overtimeline_rate'];
        $iscomplete=$row['iscomplete'];





		if($overtime_id==0)
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
			<td class="$rowtype" style="text-align:center;">$overtimeline_date</td>
			<td class="$rowtype" style="text-align:left;"><a target="blank" href="../hr/employee.php?action=view&employee_id=$employee_id">$employee_name</td>
			<td class="$rowtype" style="text-align:left;">$overtimeline_starttime</a></td>
			<td class="$rowtype" style="text-align:center;">$overtimeline_type</td>
			<td class="$rowtype" style="text-align:center;">$overtimeline_endtime</td>
			<td class="$rowtype" style="text-align:center;" nowrap>$overtimeline_totalhour</td>
			<td class="$rowtype" style="text-align:center;">$overtimeline_rate</td>
			<td class="$rowtype" style="text-align:center;">$overtimeline_totalamt</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
                <table><tr><td>
				<form action="overtime.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this Overtime' $styleedit>
				<input type="hidden" value="$overtimeline_id" name="overtimeline_id">
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
  public function getLatestOvertimeID() {
	$sql="SELECT MAX(overtimeline_id) as overtimeline_id from $this->tableovertimeline ;";
	$this->log->showLog(3,'Checking latest created overtime_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created overtime_id:' . $row['overtime_id']);
		return $row['overtimeline_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tableovertime;";
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

 public function allowDelete($overtime_id){
	
	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where overtime_id = $overtime_id or last_overtime = $overtime_id or next_overtime = $overtime_id ";
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
	$this->iscomplete = "null";
	$this->overtime_category = "";
	}

	
	if($this->iscomplete == "1")
	$selectactiveY = "selected = 'selected'";
	else if($this->iscomplete == "0")
	$selectactiveN = "selected = 'selected'";
	else
	$selectactiveL = "selected = 'selected'";
	//echo $this->iscomplete;

echo <<< EOF
<form name="frmOvertime" action="overtime.php" method="POST">
	</form>
	<form name="frmSearch" action="overtime.php" method="POST">

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

	<tr>
	<td class="head">Employee</td>
	<td class="even"colspan="3" >$this->employeectrl</td>
	</tr>

<tr>
    <td class="head">Date From (YYYY-MM-DD)</td>
    <td class="even">
    <input name='start_date' id='start_date' value="$this->start_date" maxlength='10' size='10'>
    <input name='btnDate' value="Date" type="button" onclick="$this->startctrl">
    </td>
    <td class="head">Date To (YYYY-MM-DD)</td>
    <td class="even">
    <input name='end_date' id='end_date' value="$this->end_date" maxlength='10' size='10'>
    <input name='btnDate' value="Date" type="button" onclick="$this->endctrl">
    </td>
    </tr>

	<tr>
	<td class="head">Employee Name</td>
	<td class="even"><input name="employee_name" value="$this->employee_name"></td>
	<td class="head">Employee No</td>
	<td class="even"><input name="employee_no" value="$this->employee_no"></td>
	</tr>

	<tr>
	
    <td class="head">Is Complete</td>
	<td class="even" colspan="3">
	<select name="iscomplete">
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



    if($this->employee_id > 0)
	$wherestr .= " and ol.employee_id = $this->employee_id ";
    if($this->employee_name != "")
	$wherestr .= " and em.employee_name like '$this->employee_name' ";
    if($this->employee_no != "")
	$wherestr .= " and em.employee_no like '$this->employee_no' ";

    /*
	if($this->year_id > 0)
	$wherestr .= " and st.year_id = $this->year_id ";
	if($this->session_id > 0)
	$wherestr .= " and st.session_id = $this->session_id ";

	if($this->semester_id > 0)
	$wherestr .= " and st.semester_id = $this->semester_id ";
     *
     */
    if($this->iscomplete == "0")
    $wherestr .= " and ol.overtime_id = 0 ";
    if($this->iscomplete == "1")
    $wherestr .= "and ol.overtime_id > 0 ";

    if($this->start_date != "" && $this->end_date != "")
	$wherestr .= " and ( ol.overtimeline_date between '$this->start_date' and '$this->end_date' ) ";


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
       foreach($this->overtimeline_idremain as $overtimeline_id){
       $i++;

            if($this->isselectremain[$i] == "on"){
                $sql = "update $this->tableovertimeline set overtime_id = $this->overtime_id
                where overtimeline_id = $overtimeline_id ;";

                    $this->changesql .= $sql;
                    $query=$this->xoopsDB->query($sql);
                    if(!$query){
                    return false;
                    }
            }

       }

       return true;
    }

    public function updateTotalAmount($overtime_id){

        $sql = "update $this->tableovertime set
                    total_amt = (select sum(overtime_lineamt) from $this->tableovertimeline
                    where overtime_id = $overtime_id )
                    where overtime_id = $overtime_id ";
        
        $query=$this->xoopsDB->query($sql);
        if(!$query){
        return false;
        }else{
        return false;
        }
    }

     public function getEmployeeId($uid){
     $retval = 0;

     $sql = "select employee_id from $this->tableemployee where uid = $uid ";

     $rs=$this->xoopsDB->query($sql);

      if($row=$this->xoopsDB->fetchArray($rs)){
          $retval = $row['employee_id'];
      }

     return $retval;
 }

 public function getSelectDBAjaxEmployee($strchar,$idinput,$idlayer,$ctrlid,$ocf,$table,$primary_key,$primary_name,$wherestr,$line=0){
	$retval = "";

	$limit = "";
	if($strchar == "")
	$limit = "limit 0";

	$sql = "select $primary_key as fld_id,$primary_name as fld_name from $table
		where $primary_name like '%$strchar%' and $primary_key > 0 $wherestr
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

	$retval .= "<tr  class='$rowtypes' onmouseover=onmover('idTRLine$idtr') onmouseout=onmout('idTRLine$idtr','$rowtypes') id='idTRLine$idtr' onclick=selectList('$fld_id','$idinput','$idlayer','$ctrlid','$onchangefunction');  style='cursor:pointer'>";
	$retval .= "<td>$fld_name</td>";
	$retval .= "</tr>";
	}


	$retval .= "</table>";

	return $retval;
 	}

} // end of ClassOvertime
?>

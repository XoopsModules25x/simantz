<?php


class Generateinvoice
{

  public $generateinvoice_id;
  public $generateinvoice_name;
  public $generateinvoice_no;

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
  private $tablegenerateinvoice;
  private $tablebpartner;

  private $log;


//constructor
   public function Generateinvoice(){
	global $xoopsDB,$log,$tablegenerateinvoice,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport;
    global $tableyear,$tablesession,$tablesubject,$tablesubjectclass,$tablesubjectregister,$tablecourse,$tableemployee;
    global $tablelecturerroom,$tableblockday,$tableacademiccalendar,$tableclosesession,$tablesubjectlecturer;
    global $tablestudent,$tablesubjectclassline,$tablesubjectexam,$tablestudentcgpa,$tablestudentgrade,$tablestudentexam;
    global $tablerangegrade,$tablerangecgpa,$tablesemester,$tablesubjectexception;
    global $tablegeneratestudentinvoice,$tablestudentinvoice,$tablestudentinvoiceline,$tablecourseinvoice,$tablecourseinvoiceline;
    global $defaultorganization_id,$tableusers;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablegenerateinvoice=$tablegenerateinvoice;
    $this->tablesession=$tablesession;
    $this->tableyear=$tableyear;
    $this->tablecourse=$tablecourse;
	$this->tablebpartner=$tablebpartner;
	$this->tableusers=$tableusers;

    $this->tablesubject=$tablesubject;
    $this->tablesubjectclass=$tablesubjectclass;
    $this->tablesubjectregister=$tablesubjectregister;
    $this->tablelecturerroom=$tablelecturerroom;
    $this->tableblockday=$tableblockday;
    $this->tableacademiccalendar=$tableacademiccalendar;
    $this->tableclosesession= $tableclosesession;
    $this->tablesubjectlecturer= $tablesubjectlecturer;
    $this->tableemployee= $tableemployee;
    $this->tablestudent= $tablestudent;
    $this->tablesubjectclassline= $tablesubjectclassline;
    $this->tablesubjectexam=$tablesubjectexam;
    $this->tablestudentcgpa=$tablestudentcgpa;
    $this->tablestudentgrade=$tablestudentgrade;
    $this->tablestudentexam=$tablestudentexam;
    $this->tablerangegrade=$tablerangegrade;
    $this->tablerangecgpa=$tablerangecgpa;
    $this->tablesubjectexception=$tablesubjectexception;

    $this->tablegeneratestudentinvoice=$tablegeneratestudentinvoice;
    $this->tablestudentinvoice=$tablestudentinvoice;
    $this->tablestudentinvoiceline=$tablestudentinvoiceline;
    $this->tablecourseinvoice=$tablecourseinvoice;
    $this->tablecourseinvoiceline=$tablecourseinvoiceline;
    
    $this->tablesemester=$tablesemester;
            
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int generateinvoice_id
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $generateinvoice_id,$token  ) {
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
		$header="Generate Student Invoice";
		$action="create";
	 	
		if($generateinvoice_id==0){
			$this->generateinvoice_name="";
            $this->total_credit=0;
			$this->isactive="";
			$this->defaultlevel=10;
			$generateinvoicechecked="";
			$this->generateinvoice_no = getNewCode($this->xoopsDB,"generateinvoice_no",$this->tablegenerateinvoice,"");

		}
		$savectrl="<input astyle='height: 40px;' name='submit' value='Generate Student Invoice' type='submit'>";
		$checked="";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

	
	}
	else
	{
		
		$action="update";
		$savectrl="<input name='generateinvoice_id' value='$this->generateinvoice_id' type='hidden'>".
			 "<input astyle='height: 40px;' name='submit' value='Generate Time Table' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablegenerateinvoice' type='hidden'>".
		"<input name='id' value='$this->generateinvoice_id' type='hidden'>".
		"<input name='idname' value='generateinvoice_id' type='hidden'>".
		"<input name='title' value='Generateinvoice' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

        if ($this->isbumiputera==1)
			$checked2="CHECKED";
		else
			$checked2="";

        if ($this->isinterview==1)
			$checked3="CHECKED";
		else
			$checked3="";


		$header="Edit Closing   ";
		
		if($this->allowDelete($this->generateinvoice_id))
		$deletectrl="<FORM action='generateinvoice.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this generateinvoice?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->generateinvoice_id' name='generateinvoice_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='generateinvoice.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    $searchctrl="<Form action='generateinvoice.php' method='POST'>
                            <input name='submit' value='Search' type='submit'>
                            <input name='action' value='search' type='hidden'>
                            </form>";

    echo <<< EOF


<table style="width:140px;">
<tbody>
<td>$addnewctrl</td>
<td>$searchctrl</td>
<td><form onsubmit="return validateGenerateinvoice()" method="post"
 action="generateinvoice.php" name="frmGenerateinvoice"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" colspan="3">$this->orgctrl&nbsp;</td>
			
   	
      </tr

        <tr>
        <td class="head">Year</td>
        <td class="even" aacolspan="3">$this->yearctrl</td>
        <td class="head" astyle="display:none">Session</td>
        <td class="even" astyle="display:none">$this->sessionctrl</td>
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
   * Update existing generateinvoice record
   *
   * @return bool
   * @access public
   */
  public function updateGenerateinvoice( ) {
    $this->generateinvoice_starttime = (int)$this->generateinvoice_starttime;
    $this->generateinvoice_endtime = (int)$this->generateinvoice_endtime;

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablegenerateinvoice SET
	updated='$timestamp',updatedby=$this->updatedby,
    generateinvoice_date= '$this->generateinvoice_date',generateinvoice_starttime=$this->generateinvoice_starttime,
    generateinvoice_endtime=$this->generateinvoice_endtime,subjectclass_id=$this->subjectclass_id,
    lecturerroom_id=$this->lecturerroom_id,employee_id=$this->employee_id 
	WHERE generateinvoice_id='$this->generateinvoice_id'";
	$this->changesql = $sql;
	$this->log->showLog(3, "Update generateinvoice_id: $this->generateinvoice_id, $this->generateinvoice_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update generateinvoice failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update generateinvoice successfully.");
		return true;
	}
  } // end of member function updateGenerateinvoice

  /**
   * Save new generateinvoice into database
   *
   * @return bool
   * @access public
   */
  public function insertGenerateinvoice( ) {
    global $defaultorganization_id;
    

    $timestamp= date("y/m/d H:i:s", time()) ;
    $this->log->showLog(3,"Inserting new generateinvoice $this->generateinvoice_name");
    $sql="INSERT INTO $this->tablegenerateinvoice (created,createdby,
    updated,updatedby,year_id,session_id,generateinvoice_date,generateinvoice_starttime,generateinvoice_endtime,subjectclass_id,
    lecturerroom_id,employee_id)
    values('$timestamp',$this->createdby,'$timestamp',
    $this->updatedby,$this->year_id,$this->session_id,'$this->generateinvoice_date',$this->generateinvoice_starttime,$this->generateinvoice_endtime,
    $this->subjectclass_id,$this->lecturerroom_id,$this->employee_id)";
    $this->changesql = $sql;
    $this->log->showLog(4,"Before insert generateinvoice SQL:$sql");
    $rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert generateinvoice code $generateinvoice_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new generateinvoice $generateinvoice_name successfully");
		return true;
	}
  } // end of member function insertGenerateinvoice

  /**
   * Pull data from generateinvoice table into class
   *
   * @return bool
   * @access public
   */
  public function fetchGenerateinvoice( $generateinvoice_id) {


	$this->log->showLog(3,"Fetching generateinvoice detail into class Generateinvoice.php.<br>");
		
	$sql="SELECT * 
		 from $this->tablegenerateinvoice where generateinvoice_id=$generateinvoice_id";
	
	$this->log->showLog(4,"ProductGenerateinvoice->fetchGenerateinvoice, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		
		$this->generateinvoice_id=$row['generateinvoice_id'];
		$this->generateinvoice_date= $row['generateinvoice_date'];
		$this->generateinvoice_starttime=$row['generateinvoice_starttime'];
        $this->generateinvoice_endtime=$row['generateinvoice_endtime'];
        $this->subjectclass_id=$row['subjectclass_id'];
        $this->lecturerroom_id=$row['lecturerroom_id'];
        $this->employee_id=$row['employee_id'];

		$this->year_id=$row['year_id'];
		$this->session_id=$row['session_id'];


   	$this->log->showLog(4,"Generateinvoice->fetchGenerateinvoice,database fetch into class successfully");
	$this->log->showLog(4,"generateinvoice_name:$this->generateinvoice_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Generateinvoice->fetchGenerateinvoice,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchGenerateinvoice

  /**
   * Delete particular generateinvoice id
   *
   * @param int generateinvoice_id
   * @return bool
   * @access public
   */
  public function deleteGenerateinvoice( $generateinvoice_id ) {
    	$this->log->showLog(2,"Warning: Performing delete generateinvoice id : $generateinvoice_id !");
	$sql="DELETE FROM $this->tablegenerateinvoice where generateinvoice_id=$generateinvoice_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->changesql = $sql;
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: generateinvoice ($generateinvoice_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"generateinvoice ($generateinvoice_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteGenerateinvoice

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllGenerateinvoice( $wherestring,  $orderbystring,$groupby="") {
  $this->log->showLog(4,"Running ProductGenerateinvoice->getSQLStr_AllGenerateinvoice: $sql");

    $wherestring .= " and a.year_id = b.year_id and a.session_id = c.session_id
                                and a.subjectclass_id = d.subjectclass_id
                                and d.subject_id = f.subject_id
                                and a.lecturerroom_id = i.lecturerroom_id
                                and a.year_id = j.year_id
                                and a.session_id = j.session_id
                                and e.course_id = k.course_id
                                and d.subjectclass_id = k.subjectclass_id 
                                and j.isactive = 0";

    //$group_by = " group by d.course_id ";
    
            $sql="SELECT a.generateinvoice_id,d.subjectclass_id,k.course_id as course_id,e.course_name,e.course_no,b.year_name,c.session_name,
                            a.year_id,a.session_id,f.subject_name,f.subject_no,a.lecturerroom_id,i.lecturerroom_name,
                            i.lecturerroom_no 
                FROM $this->tablegenerateinvoice a, $this->tableyear b,$this->tablesession c,
                            $this->tablesubjectclass  d, $this->tablecourse e, $this->tablesubject f,
                            $this->tablelecturerroom i, $this->tableclosesession j, $this->tablesubjectclassline k
                            $wherestring
                            $groupby
                            $orderbystring";
    $this->log->showLog(4,"Generate showgenerateinvoicetable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllGenerateinvoice

 public function showGenerateinvoiceTable($wherestring,$orderbystring,$groupby="",$token=""){
    global $defaultorganization_id;
    $styledisplaylist = "";
    if($this->showtt == "Y")
    $styledisplaylist = "display:none";
    

	$this->log->showLog(3,"Showing Generateinvoice Table");
	$sql=$this->getSQLStr_AllGenerateinvoice($wherestring,$orderbystring,$groupby);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='0' acellspacing='' style="width:18px;$styledisplaylist" >
  		<tbody>
    			<tr>
				<th style="text-align:center;" width=1 nowrap>No</th>
				<th style="text-align:center;">Time Table</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$generateinvoice_id=$row['generateinvoice_id'];

        $subject_no=$row['subject_no'];
        $subject_name=$row['subject_name'];
		$year_name=$row['year_name'];
        $session_name=$row['session_name'];
        $course_name=$row['course_name'];
        $course_id=$row['course_id'];
        $course_no=$row['course_no'];
        $year_id=$row['year_id'];
        $session_id=$row['session_id'];
        $subjectclass_id=$row['subjectclass_id'];
        $lecturerroom_id=$row['lecturerroom_id'];
        $lecturerroom_no=$row['lecturerroom_no'];
        $lecturerroom_name=$row['lecturerroom_name'];
        $course_link=$row['course_id'];

		$isactive=$row['isactive'];
	

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

        

        if($this->search_type != "2"){

        if($this->search_category == "R"){
		echo <<< EOF
        <tr height="30">
        <td class="$rowtype" style="text-align:center;">$i</td>
        <td class="$rowtype" style="text-align:left;" nowrap>
        <a href="generateinvoice.php?showtt=Y&issearch=Y&search_type=1&action=search&course_id=$course_id&year_id=$year_id&session_id=$session_id&lecturerroom_id=$lecturerroom_id&search_category=$this->search_category">$lecturerroom_name ($lecturerroom_no)</a>
        </td>
        </tr>

EOF;
        }else{
		echo <<< EOF

        <tr height="30">
        <td class="$rowtype" style="text-align:center;">$i</td>
        <td class="$rowtype" style="text-align:left;" nowrap>
        <a href="generateinvoice.php?issearch=Y&search_type=2&action=search&course_id=$course_link&year_id=$year_id&session_id=$session_id&search_category=$this->search_category">$course_name ($course_no)</a>
        </td>
        </tr>
		
EOF;
            }

        }else if($this->search_type == "2"){

        if(true){
		echo <<< EOF

		<tr height="30">
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:left;" nowrap>
            <a href="generateinvoice.php?showtt=Y&issearch=Y&search_type=2&action=search&course_id=$course_id&year_id=$year_id&session_id=$session_id&subjectclass_id=$subjectclass_id&search_category=$this->search_category">$subject_name ($subject_no)</a>
            </td>
		</tr>
EOF;
                
            }
        }
	}

    if($i > 0 && $this->search_type == "2")
    echo "<tr><td colspan='2' align='right'><a href='generateinvoice.php?showtt=Y&issearch=Y&search_type=2&action=search&course_id=$course_link&year_id=$year_id&session_id=$session_id&subjectclass_id=0&search_category=$this->search_category'>View All Subject >></a></td></tr>";

    if($i == 0)
    echo "<tr><td colspan='2' align='right' nowrap>No Record(s) Found.</td></tr>";
    
	echo  "</tr></tbody></table>";

    if($i > 0 && $this->search_type != "2"&&$this->year_id>0&$this->session_id>0&&$this->course_id==0&&$this->search_category=="C"){
    echo "<form action='generateinvoice.php' method='POST' onsubmit ='return confirm(".'"Confirm To Reschedule Time Table For This Session?"'.")' >
    <table><tr><td colspan='3' align='left'>
    <br><br><br>
    <input type='hidden' name='organization_id' value='$defaultorganization_id'>
    <input type='hidden' name='isempty' value='1'>
    <input type='hidden' name='action' value='create'>
    <input type='hidden' name='year_id' value='$this->year_id'>
    <input type='hidden' name='session_id' value='$this->session_id'>
    <input type='submit' value='Reschedule Time Table'>
    <input name='token' value='$token' type='hidden'>
    </td></tr></table></form>";
    }
    
 }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestGenerateinvoiceID() {
	$sql="SELECT MAX(generateinvoice_id) as generateinvoice_id from $this->tablegenerateinvoice;";
	$this->log->showLog(3,'Checking latest created generateinvoice_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created generateinvoice_id:' . $row['generateinvoice_id']);
		return $row['generateinvoice_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablegenerateinvoice;";
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

 public function allowDelete($generateinvoice_id){
	/*
	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where generateinvoice_id = $generateinvoice_id or last_generateinvoice = $generateinvoice_id or next_generateinvoice = $generateinvoice_id ";
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$rowcount = $row['rowcount'];
	}

	if($rowcount > 0)
	return false;
	else*/
	return true;
//	return $checkistrue;
	}

     public function showSearchForm($wherestr){


	
	//echo $this->iscomplete;

echo <<< EOF
<form name="frmGenerateinvoice" action="generateinvoice.php" method="POST">
	</form>
	<form name="frmSearch" action="generateinvoice.php" method="POST">
    <input type="hidden" value="typecourse" name="search_type">
	<table >
	<tr>
	<td nowrap><input value="Reset" type="reset">
	<input value="New" type="button" onclick="gotoAction('');"></td>
	</tr>
	</table>

	<table border="0"  style="width:800px">
	<input name="issearch" value="Y" type="hidden">
	<input name="action" value="search" type="hidden">
	<tr><th colspan="4">Criterial</th></tr>

    <tr style="display:none">

	<td class="head">Search By</td>
	<td class="even" colspan="3">
	<select name="search_category" onchange="changeCategory(this.value)">
	<option value='C' $selectC>Course</option>
	<option value='R' $selectR>Room</option>
	</select>
	</td>
	</tr>

    <tr>
    <td class="head">Year</td>
    <td class="even">$this->yearctrl</td>
    <td class="head">Session</td>
    <td class="even">$this->sessionctrl</td>
    </tr>

    <tr id="idCourse" $stylecourse>
    <td class="head">Course</td>
    <td class="even" colspan="3">$this->coursectrl</td>
    </tr>

    <tr id="idSubject" style="display:none">
    <td class="head">Subject</td>
    <td class="even" colspan="3">$this->subjectctrl</td>
    </tr>

    <tr id="idSemester" >
    <td class="head">Semester</td>
    <td class="even" colspan="3">$this->semesterctrl</td>
    </tr>

    <tr id="idStudent" >
    <td class="head">Student</td>
    <td class="even" colspan="3">$this->studentctrl</td>
    </tr>

    <tr id="idRoom" $styleroom style="display:none">
    <td class="head">Room</td>
    <td class="even" colspan="3">$this->lecturerroomctrl</td>
    </tr>


	<tr style="display:none">
	
	<td class="head">Is Closed</td>
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

  public function boxTimeTable($wherestr){
    global $startlecturer_time,$endlecturer_time;

    $startlecturer_time = (int)$startlecturer_time;
    $endlecturer_time = (int)$endlecturer_time;
    
    if($this->week_no == "")
    $this->week_no = 1;

    $weekarray = $this->getWeekSelectCtrl($this->week_no,"week_no",$this->year_id,$this->session_id,"onchange='getWeekNo(this.value)'");

    $weekctrl = $weekarray['html'];
    $startweek_date = $weekarray['startweek_date'];
    $endweek_date = $weekarray['endweek_date'];

    // looping by day (MONDAY to FRIDAY)
    $weekday = array(0=>"",1=>"MONDAY",2=>"TUESDAY",3=>"WEDNESDAY",4=>"THURSDAY",5=>"FRIDAY");

     $wherestr .= " and tt.subjectclass_id = sc.subjectclass_id
                            and tt.employee_id = em.employee_id
                            and sc.subject_id = sb.subject_id
                            and tt.lecturerroom_id = lr.lecturerroom_id
                            and tt.year_id = cs.year_id
                            and tt.session_id = cs.session_id
                            and sc.subjectclass_id = cl.subjectclass_id 
                            and cs.isactive = 0 ";

      if($this->subjectclass_id > 0)
      $wherestr .= " and tt.subjectclass_id = $this->subjectclass_id";

      if($this->lecturerroom_id > 0)
      $wherestr .= " and tt.lecturerroom_id = $this->lecturerroom_id";
//echo $this->subjectclass_id." ".$this->course_id;
        //&& $this->subjectclass_id > 0
      if($this->course_id > 0 )
      $wherestr .= " and ( cl.course_id = $this->course_id)";

      //$wherestr .= " and tt.generateinvoice_date between '$startweek_date' and '$endweek_date' ";
      
echo <<< EOF
    <form name="frmGenerateinvoiceBox" method="POST">
    <input type="hidden" name="search_category" value="$this->search_category">
    <input type="hidden" name="search_type" value="$this->search_type">
    <input type="hidden" name="year_id" value="$this->year_id">
    <input type="hidden" name="session_id" value="$this->session_id">
    <input type="hidden" name="course_id" value="$this->course_id">
    <input type="hidden" name="showtt" value="$this->showtt">
    <input type="hidden" name="issearch" value="$this->issearch">
    <input type="hidden" name="subjectclass_id" value="$this->subjectclass_id">
    <input type="hidden" name="lecturerroom_id" value="$this->lecturerroom_id">
    <input type="hidden" name="action" value="search">

    <table>
    <tr>
    <td acolspan="12" align="left">$weekctrl</td>
    </tr>
    </table>

    <table>
EOF;
      $i= 0;
      foreach($weekday as $day_name){//looping monday to friday


        //$date_name = getNameDay($trans_date);
        
echo <<< EOF

        <tr>
        <td class="even"><b>$day_name</b><br>$trans_date</td>
EOF;
          $trans_time = $startlecturer_time;
          $j=0;
          while($trans_time < $endlecturer_time){//looping start_time to end_time
          $j++;
          $whereloop = "";
          
          $rowtype = "odd";
          $transstart_time = $trans_time;
          $transend_time = $trans_time + 100;

          $time_description = "";
          if($i==0){//header only
          $time_description = "$transstart_time - $transend_time";
          $rowtype = "head";
          }else{

           //start SQL
          $whereloop .= $wherestr." and tt.generateinvoice_starttime <= $transstart_time and tt.generateinvoice_endtime >= $transend_time ";
          $whereloop .= " and tt.generateinvoice_date = '$trans_date' ";

          $sql = "select tt.generateinvoice_id,tt.generateinvoice_date,tt.generateinvoice_starttime,tt.generateinvoice_endtime,
                    tt.employee_id,tt.lecturerroom_id,tt.year_id,tt.session_id,tt.subjectclass_id,
                    em.employee_name,sb.subject_name,sb.subject_no,lr.lecturerroom_name,
                    lr.lecturerroom_no,sc.course_id,sc.group_no
                    from
                    $this->tablegenerateinvoice tt, $this->tablesubjectclass sc, $this->tableemployee em,
                    $this->tablesubject sb, $this->tablelecturerroom lr, $this->tableclosesession cs,
                    $this->tablesubjectclassline cl 
                    $whereloop
                    group by sc.subjectclass_id
                     order by tt.generateinvoice_date";

          //echo "<br>";
          //end SQL

          $rs=$this->xoopsDB->query($sql);

          $check = 0;
          $time_description = "";
           while ($row=$this->xoopsDB->fetchArray($rs)){
               $check++;
               //echo "sa $check <br>";

               $course_id = $row['course_id'];
               $generateinvoice_id = $row['generateinvoice_id'];
               $subjectclass_id = $row['subjectclass_id'];
               $subject_name = $row['subject_name'];
               $subject_no = $row['subject_no'];
               $lecturerroom_no = $row['lecturerroom_no'];
               $employee_name = $row['employee_name'];
               $group_no = $row['group_no'];
               
               $time_description .= "<a title='Edit This Record' target='blank' href='generateinvoice.php?action=edit&generateinvoice_id=$generateinvoice_id'>$subject_name($subject_no)<br>Room : ($lecturerroom_no) <br>Group : $group_no<br>Lecturer : $employee_name</a><br><br>";
               //$time_description .= $time_description;
           }

           $time_description .= "<br><a title='Add New Class' target='blank' href='generateinvoice.php?action=addnew&generateinvoice_date=$trans_date&generateinvoice_starttime=$transstart_time&generateinvoice_endtime=$transend_time&year_id=$this->year_id&session_id=$this->session_id'><font color=red>Add New >></font></a>";
                //if($check >0)
                //$time_description = "$subject_name($subject_no)<br>Room : ($lecturerroom_no)<br>Lecturer : $employee_name";

          }

           
echo <<< EOF
        <td class="$rowtype" align="left" nowrap>$time_description</td>
EOF;
              $trans_time = $trans_time + 100;// add 1 hour
          }
echo <<< EOF
        </tr>
EOF;
          $trans_date = AddDate($startweek_date,$i);
          $i++;
      }
echo <<< EOF

    </table>
    </form>

EOF;
  }

	public function getWhereStr(){

	$wherestr = "";

    if($this->session_id > 0)
	$wherestr .= " and gi.session_id = $this->session_id ";
	if($this->year_id > 0)
	$wherestr .= " and gi.year_id = $this->year_id ";
    if($this->student_id > 0)
	$wherestr .= " and si.student_id = $this->student_id ";
    if($this->semester_id > 0)
    $wherestr .= " and si.semester_id = $this->semester_id ";

   //if($this->lecturerroom_id > 0)
	//$wherestr .= " and a.lecturerroom_id = $this->lecturerroom_id ";

    if($this->course_id > 0)
    $wherestr .= " and st.course_id = $this->course_id";

	return $wherestr;

	}

    public function generateStudentInvoice($yearp_id=0,$sessionp_id=0,$isemptytrue=false,$studentp_id=0,$ischeckexist=1){
        global $defaultorganization_id;
        global $startlecturer_time,$endlecturer_time,$morning_examtime,$evening_examtime;
        
        $timestamp= date("y/m/d H:i:s", time()) ;
        $wherestr = "";


        
        if($this->checkClosing($yearp_id,$sessionp_id)){//check closing session
        $this->txtwarning= "Please Open Academic Session.";
        return false;
        }

        /*
        if($start_date == "" || $start_date == "" || $end_date == "0000-00-00" || $end_date == "0000-00-00"){//check academic calendar
        $this->txtwarning= "Please Define Exam Event At Academic Calendar (From Date - To Date)";
        return false;
        }
         * 
         */

        if($isemptytrue==true){
           
            if(!$this->emptyStudentExam($yearp_id,$sessionp_id,$studentp_id)){
                $this->txtwarning = "Cannot Empty Student Exam Info..";
                return false;
            }
        }

        if(!$this->checkCurrentSetInvoice($yearp_id,$sessionp_id)){//check closing session
        $this->txtwarning= "Student Invoice Generated For This Academic Session.  <a href='generateinvoice.php?action=search&issearch=Y&search_type=typecourse&year_id=$this->year_id&session_id=$this->session_id'><u>Click Here To View Student Invoice</u></a> ";
        return false;
        }
       


        $wherestr = " where st.isactive = 1 and st.organization_id = $defaultorganization_id ";
        
        
        $sql = "select *
                    from $this->tablestudent st 
                    $wherestr ";
        
        $rs=$this->xoopsDB->query($sql);

        if($this->createSetGenerateInvoice($yearp_id,$sessionp_id)){//create set of invoice

        $i=0;
        while ($row=$this->xoopsDB->fetchArray($rs)){//fetch student_id
            $i++;

            $year_id = $row['year_id'];
            $session_id = $row['session_id'];
            $student_id = $row['student_id'];
            $course_id = $row['course_id'];
            $semester_id = $row['semester_id'];

            if($this->createInvoice($yearp_id,$sessionp_id,$student_id,$semester_id)){//create individual invoice
                
                $sqlinvoice = "update $this->tablestudentinvoiceline
                set studentinvoice_id = $this->studentinvoice_id
                where studentinvoice_id = 0 ";//update invoice line => studentinvoice_id = 0

                $query=$this->xoopsDB->query($sqlinvoice);

                if(!$query){
                    $this->txtwarning = "Failed To Update Invoice Line.";
                    return false;
                }else{//if success => continue check course invoice

                    $sqlcourse = "select
                    $this->studentinvoice_id as studentinvoice_id,
                    cl.product_id as product_id,
                    cl.courseinvoiceline_item as studentinvoice_item,
                    cl.qty as studentinvoice_qty,
                    cl.unit_price as studentinvoice_uprice,
                    cl.line_amt as studentinvoice_lineamt,
                    cl.line_desc as line_desc,
                    cl.accounts_id as accounts_id,
                    '$timestamp' as created,
                    $this->updatedby as createdby,
                    '$timestamp' as updated,
                    $this->updatedby as updatedby,
                    $student_id as student_id
                    from $this->tablecourseinvoice ci, $this->tablecourseinvoiceline cl
                    where ci.courseinvoice_id = cl.courseinvoice_id
                    and ci.organization_id = $defaultorganization_id
                    and ci.course_id = $course_id
                    and cl.semester_list like '%$semester_id%' ";

                    $sqlinsertline = "insert into $this->tablestudentinvoiceline
                    (studentinvoice_id,product_id,studentinvoice_item,studentinvoice_qty,studentinvoice_uprice,
                    studentinvoice_lineamt,line_desc,accounts_id,created,createdby,updated,updatedby,student_id)
                    $sqlcourse ";

                    $queryinsertline=$this->xoopsDB->query($sqlinsertline);

                    if(!$queryinsertline){
                        $this->txtwarning = "Failed To Insert Invoice Line.";
                        return false;
                    }

                    $sqlhostel="SELECT h.charges
                    FROM sim_simedu_hostel h, sim_simedu_hostelblock b, sim_simedu_hostelroom r, sim_simedu_hostelbed bed
                    WHERE h.hostel_id=b.hostel_id AND b.hostelblock_id=r.hostelblock_id AND r.room_id=bed.room_id AND
                    student_id=$student_id";

                    $query=$this->xoopsDB->query($sqlhostel);
                    if($row=$this->xoopsDB->fetchArray($query)){

                        $charge = $row['charges'];
//echo "<br>";
                        $sqlinsertlinehostel = "insert into $this->tablestudentinvoiceline
                    (studentinvoice_id,product_id,studentinvoice_item,studentinvoice_qty,studentinvoice_uprice,
                    studentinvoice_lineamt,accounts_id,created,createdby,student_id) VALUES(
                        $this->studentinvoice_id, 0, 'Yuran Asrama', 1.00, $charge, $charge, 42, '$timestamp', $this->updatedby, $student_id)";

                        $query=$this->xoopsDB->query($sqlinsertlinehostel);

                        if(!$query){
                            $this->txtwarning = "Failed To Insert Invoice Line (HOSTEL).";
                            return false;
                        }
                    }
                }

            }//end of create individual invoice

            
            
        }//end of fetch subject

        }//end of create set of invoice

        return true;
    }

    public function createInvoice($year_id,$session_id,$student_id,$semester_id){
        global $defaultorganization_id;
        $timestamp= date("y/m/d H:i:s", time()) ;

        $studentinvoice_no = getNewCode($this->xoopsDB,"studentinvoice_no",$this->tablestudentinvoice,"");

        $sql = "insert into $this->tablestudentinvoice
                    (studentinvoice_no,studentinvoice_date,student_id,
                    semester_id,generatestudentinvoice_id,
                    year_id,session_id,created,createdby,updated,updatedby,organization_id)
                    values
                    ('$studentinvoice_no','$timestamp',$student_id,
                    $semester_id,$this->generatestudentinvoice_id,$year_id,$session_id,'$timestamp',$this->updatedby,'$timestamp',$this->updatedby,$defaultorganization_id)";

        $query=$this->xoopsDB->query($sql);

        if(!$query){
            $this->txtwarning = "Cannot Create Invoice";
            return false;
        }else{
            $this->studentinvoice_id = getLatestPrimaryID("$this->tablestudentinvoice","studentinvoice_id",true);
            return true;
        }

    }

    
    public function createSetGenerateInvoice($year_id,$session_id){
        global $defaultorganization_id;
        $timestamp= date("y/m/d H:i:s", time()) ;

        $sql = "insert into $this->tablegeneratestudentinvoice
                    (year_id,session_id,created,createdby,organization_id)
                    values
                    ($year_id,$session_id,'$timestamp',$this->updatedby,$defaultorganization_id)";

        $query=$this->xoopsDB->query($sql);

        if(!$query){
            $this->txtwarning = "Cannot Create Set Of Invoice";
            return false;
        }else{
            $this->generatestudentinvoice_id = getLatestPrimaryID("$this->tablegeneratestudentinvoice","generatestudentinvoice_id",true);
            return true;
        }

    }

    public function updateGenerateSuccess($type,$generatestudentinvoice_id){

        $sql = "update $this->tablegeneratestudentinvoice
        set generatestudentinvoice_status = '$type' 
        where generatestudentinvoice_id = $generatestudentinvoice_id";
        
        $this->changesql = $sql;
        $query=$this->xoopsDB->query($sql);
        if(!$query){
        $this->txtwarning = "Cannot Update Status Invoice";
        return false;
        }else{

             if($type=="V"){
                    $sqldelete = "delete from $this->tablestudentinvoice where generatestudentinvoice_id = $generatestudentinvoice_id";
                    $querydelete=$this->xoopsDB->query($sqldelete);
                    if(!$querydelete){
                    $this->txtwarning = "Failed To Delete Invoice Line";
                    return false;
                    }
            }else{
                    $sqlamt = "update $this->tablestudentinvoice si set
                    total_amt = (select sum(studentinvoice_lineamt) from $this->tablestudentinvoiceline
                                where studentinvoice_id = si.studentinvoice_id)
                    where si.generatestudentinvoice_id = $generatestudentinvoice_id ";
                
                    $queryamt=$this->xoopsDB->query($sqlamt);
                    if(!$queryamt){
                    $this->txtwarning = "Failed To Update Total Invoice";
                    return false;
                    }else{

                        $sqlremarks = "update $this->tablestudentinvoice si set
                        description = (select ci.description from $this->tablecourseinvoice ci, $this->tablestudent st
                        where ci.course_id = st.course_id and st.student_id = si.student_id limit 1 )
                        where si.generatestudentinvoice_id = $generatestudentinvoice_id";

                        $queryrem=$this->xoopsDB->query($sqlremarks);
                        if(!$queryrem){
                        $this->txtwarning = "Failed To Update Remarks Invoice";
                        return false;
                        }else{
                        return true;
                        }
                        
                    }
                }
            
        }
    }


    public function checkExistExam($trans_date){

      global $defaultorganization_id;

       // check generateinvoice
        $sqlcheck = "select count(*) as rowcnt from $this->tablegenerateinvoice
                                where year_id = $this->year_id and session_id = $this->session_id
                                and generateinvoice_date = '$trans_date' ";

        $rscheck=$this->xoopsDB->query($sqlcheck);

        $checkrow=0;
		if($row=$this->xoopsDB->fetchArray($rscheck)){
        $checkrow = $row['rowcnt'];
        }

        if(strtoupper(getNameDay($trans_date)) == "WEDNESDAY"){//meeting wednesday
        $checkrow = $checkrow + 1;
        }
        
        if($checkrow > 1){
            $retval = false;
            $session_exam = "0";
        }else{

            if($checkrow == 0)
            $session_exam = "1";
            else
            $session_exam = "2";
            $retval = true;
        }

        return array("retval"=>$retval,"session_exam"=>$session_exam);
        // end
  }


   public function checkClosing($yearclone_id,$sessionclone_id){

      global $defaultorganization_id;

       // check closing session
        $sqlcheck = "select count(*) as rowcnt from $this->tableclosesession where year_id = $yearclone_id and session_id = $sessionclone_id and organization_id = $defaultorganization_id and isactive = 0";

        $rscheck=$this->xoopsDB->query($sqlcheck);

        $checkrow=0;
		if($row=$this->xoopsDB->fetchArray($rscheck)){
        $checkrow = $row['rowcnt'];
        }

        if($checkrow > 0){
            return false;
        }else{
            return true;
        }
        // end
  }

  public function checkCurrentSetInvoice($year_id,$session_id){

      global $defaultorganization_id;

       // check generateinvoice
        $sqlcheck = "select count(*) as rowcnt from $this->tablegeneratestudentinvoice
        where year_id = $year_id and session_id = $session_id
        and generatestudentinvoice_status = 'C'
        and organization_id = $defaultorganization_id ";

        $rscheck=$this->xoopsDB->query($sqlcheck);

        $checkrow=0;
		if($row=$this->xoopsDB->fetchArray($rscheck)){
        $checkrow = $row['rowcnt'];
        }

        if($checkrow > 0){
            return false;
        }else{
            return true;
        }
        // end
  }


  public function getSelectDBAjaxSubject($strchar,$idinput,$idlayer,$ctrlid,$ocf,$table,$primary_key,$primary_name,$wherestr,$line=0){
	$retval = "";

	$limit = "";
	if($strchar == "")
	$limit = "limit 0";

	$sql = "select $primary_key as fld_id,$primary_name as fld_name,subject_no from $table
		where ($primary_name like '%$strchar%' or subject_no like '%$strchar%' ) and $primary_key > 0 $wherestr
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
    $subject_no = $row['subject_no'];

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
	$retval .= "<td>$fld_name ($subject_no)</td>";
	$retval .= "</tr>";
	}


	$retval .= "</table>";

	return $retval;
 	}

public function getSelectDBAjaxEmployee($strchar,$idinput,$idlayer,$ctrlid,$ocf,$table,$primary_key,$primary_name,$wherestr,$line=0){
	$retval = "";

	$limit = "";
	if($strchar == "")
	$limit = "limit 0";

	$sql = "select $primary_key as fld_id,$primary_name as fld_name from $table
		where ($primary_name like '%$strchar%' or employee_no like '%$strchar%' ) and $primary_key > 0 $wherestr
		$limit";

	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	$rowtypes="";
	$i=0;
	$retval .= "<table style='width:1px'><tr><th>List</th></tr>";
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
	$retval .= "<td nowrap>$fld_name</td>";
	$retval .= "</tr>";
	}


	$retval .= "</table>";

	return $retval;
 	}
    
  public function getSelectDBAjax($strchar,$idinput,$idlayer,$ctrlid,$ocf,$table,$primary_key,$primary_name,$wherestr,$line=0){
	$retval = "";

	$limit = "";
	if($strchar == "")
	$limit = "limit 0";

	$sql = "select $primary_key as fld_id,$primary_name as fld_name,sb.subject_no,cr.course_no,sc.group_no
            from $table sc, $this->tablesubject sb, $this->tablecourse cr, $this->tableclosesession cs 
		where ($primary_name like '%$strchar%' or sb.subject_no like '%$strchar%' ) and $primary_key > 0 $wherestr
		group by sc.subjectclass_id $limit";

	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	$rowtypes="";
	$i=0;
	$retval .= "<table style='width:400px'><tr><th>List</th></tr>";
	while ($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$fld_name = $row['fld_name'];
	$fld_id = $row['fld_id'];
    $course_no = $row['course_no'];
    $subject_no = $row['subject_no'];
    $group_no = $row['group_no'];


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
	$retval .= "<td>$fld_name ($subject_no) $course_no - $group_no</td>";
	$retval .= "</tr>";
	}


	$retval .= "</table>";

	return $retval;
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

    public function showListSet($wherestr,$token,$dp){
        global $ctrl,$defaultorganization_id;
        
        $wherestr .= " and gi.year_id = yr.year_id
        and gi.session_id= ss.session_id
        and gi.createdby = us.uid ";

        $sql = "select gi.generatestudentinvoice_id,gi.created,yr.year_name,ss.session_name,
                    us.name,gi.generatestudentinvoice_status,gi.updated,us2.name as update_name,
                    gi.ispublish,
                    (select count(*) from $this->tablestudentinvoice
                    where generatestudentinvoice_id = si.generatestudentinvoice_id
                    and iscomplete = 0 ) as tot_new,
                    (select count(*) from $this->tablestudentinvoice
                    where generatestudentinvoice_id = si.generatestudentinvoice_id
                    and iscomplete = 1 ) as tot_complete
                    from $this->tablegeneratestudentinvoice gi
                    left join $this->tablestudentinvoice si on si.generatestudentinvoice_id = gi.generatestudentinvoice_id 
                    inner join $this->tableyear yr on yr.year_id = gi.year_id
                    left join $this->tablestudent st on st.student_id = si.student_id
                    inner join $this->tablesession ss on ss.session_id= gi.session_id
                    left join $this->tableusers us on us.uid = gi.createdby
                    left join $this->tableusers us2 on us2.uid = gi.updatedby
                    $wherestr
                    group by gi. generatestudentinvoice_id ";

                    /*
        $sql = "select gi.generatestudentinvoice_id,gi.created,yr.year_name,ss.session_name,
                    us.name,gi.generatestudentinvoice_status,gi.updated,
                    (select name from $this->tableusers where uid = gi.updatedby) as update_name
                    from $this->tablegeneratestudentinvoice gi, $this->tableyear yr, $this->tablesession ss,
                    $this->tableusers us
                    $wherestr ";
                     * 
                     */

        $this->log->showLog(4,"With Show List SQL:$sql");
        $query=$this->xoopsDB->query($sql);
        
echo <<< EOF
        <br>

<form name="frmListAll" action="generateinvoice.php" method="POST" target="">

<input type="hidden" name="issearch" value="Y">
<input type="hidden" name="action" value="">
<input type="hidden" name="year_id" value="$this->year_id">
<input type="hidden" name="session_id" value="$this->session_id">
<input type="hidden" name="course_id" value="$this->course_id">
<input type="hidden" name="student_id" value="$this->student_id">
<input type="hidden" name="semester_id" value="$this->semester_id">
<input type="hidden" name="token" value="$token">
<input type="hidden" name="generatestudentinvoice_id" value="">

        <table>

        <tr>
        <th>No</th>
        <th align="center">Academic Session</th>
        <th align="center">Generated</th>
       <th align="center">Updated</th>
        <th align="center">Status</th>
        <th align="center">View</th>
        <th align="center">Void</th>
        <th align="center"></th>
        </tr>

EOF;

        $rowtype="";
        $i=0;
        while ($row=$this->xoopsDB->fetchArray($query)){
        $i++;

        $generatestudentinvoice_id = $row['generatestudentinvoice_id'];
        $year_name = $row['year_name'];
        $session_name = $row['session_name'];
        $generatestudentinvoice_status = $row['generatestudentinvoice_status'];
        $created = substr($row['created'],0,10);
        $updated = substr($row['updated'],0,10);
        $name = $row['name'];
        $update_name = $row['update_name'];
        $ispublish = $row['ispublish'];
        $tot_new = $row['tot_new'];
        $tot_complete = $row['tot_complete'];
        
        $completeinfo = "<b>Not Complete :</b> $tot_new";
        $completeinfo2 = "<b>Complete :</b> $tot_complete";
        $stylepublish = "style='display:none'";
        if($generatestudentinvoice_status == "C"){
        $status_name = "Completed";
        $styleview = "";
        $stylevoid = "";
        $stylepublish = "";

        
        }else if($generatestudentinvoice_status =="V"){
        $status_name = "Void";
        $styleview = "style='display:none'";
        $stylevoid = "style='display:none'";
        $stylepublish = "style='display:none'";
        $completeinfo = "";
        $completeinfo2 = "";
        }else
        $status_name = "-";

        if($ispublish == 1){
        $checkedpublish = "CHECKED";
        //$stylevoid = "style='display:none'";
        }else
        $checkedpublish = "";
        
        if($rowtype=="even")
        $rowtype = "odd";
        else
        $rowtype = "even";

        if($created == "0000-00-00")
        $created = "";
        if($updated == "0000-00-00")
        $updated = "";

        if($tot_complete > 0)
        $stylevoid = "style='display:none'";
 echo <<< EOF

        <tr>
        <td class="$rowtype">$i</td>
        <td class="$rowtype" align="center">$year_name / $session_name</td>
        <td class="$rowtype" align="center">$created <br>$name</td>
        <td class="$rowtype" align="center">$updated <br>$update_name</td>
        <td class="$rowtype" align="center">$status_name</td>
        <td class="$rowtype" align="center"><input $styleview type="button" value="View Details" onclick="viewSetInvoice($generatestudentinvoice_id)"></td>
        <td class="$rowtype" align="center"><input id="btnVoid$i" $stylevoid type="button" value="Void" onclick="voidInvoice($generatestudentinvoice_id)"></td>
        <td class="$rowtype" align="center">
        <table>
        <tr>
        <td>$completeinfo</td>
        <td><input type="button" value="Publish" onclick="updatePublish($generatestudentinvoice_id,$i)"></td>
        </tr>
        
        <tr>
        <td>$completeinfo2</td>
        <td><input type="button" value="Re-Activate" onclick="updateReactivate($generatestudentinvoice_id,$i)"></td>
        </tr>
        </table>        
        <input style="display:none" id="ispublish$i" $stylepublish type="checkbox" name="ispublish[$i]" onclick="publishSetInvoice($generatestudentinvoice_id,this.checked,$i)" $checkedpublish>
        </td>
        </tr>
EOF;
        }
echo <<< EOF

    </table></form>

    <br><br>
    <form action="generateinvoice.php" method="POST" onsubmit="return confirm('Confirm Re-generate Student Result?')">
    <input type="hidden" name="action" value="create">
    <input type="hidden" name="token" value="$token">
    <input type="hidden" name="ischeckexist" value="0">
    <input type="hidden" name="year_id" value="$this->year_id">
    <input type="hidden" name="session_id" value="$this->session_id">

    <table $stylegenerate style="display:none">
    <tr>
    <td width="1" nowrap>
    <select name="isempty">
    <option value="0">Update Result</option>
    <option value="1">Full Generate</option>
    </select>
    </td>
    <td>&nbsp;&nbsp;<input type="submit" value="Re-Generate Student Invoice"></td>
    </tr>
    </table>
    </form>
EOF;

    }


    public function saveUpdate($studentgrade_id,$subject_result){

        $this->changesql = "";
        $i=0;
        foreach($studentgrade_id as $id){
            $i++;

            $total_result = $subject_result[$i];
            $getRangeGred = $this->getRangeGred($total_result);
            $grade_value = $getRangeGred['grade_value'];
            $rangegrade_name = $getRangeGred['rangegrade_name'];
            
            $sql = "update $this->tablestudentgrade set
            subject_result = $total_result,
            grade_value = $grade_value,
            grade_name = '$rangegrade_name'
            where studentgrade_id = $id; ";

            $this->changesql .= $sql;

            $rs=$this->xoopsDB->query($sql);

            if(!$rs){
                $this->txtwarning = "Fail To Save Update";
                return false;
            }
        }

        return true;
    }

    

    public function deleteResultLine($deleteline_result){

        $sql = "delete from $this->tablestudentgrade where studentgrade_id = $deleteline_result ";

        $this->changesql = $sql;
        $query=$this->xoopsDB->query($sql);

        if(!$query){
            $this->txtwarning = "Failed To Delete Line.";
            return false;
        }else{
            return true;
        }
    }

    public function voidInvoice($generatestudentinvoice_id){
        global $defaultorganization_id;
        $timestamp= date("y/m/d H:i:s", time()) ;

        $sql = "update $this->tablegeneratestudentinvoice
        set generatestudentinvoice_status = 'V', updated='$timestamp', updatedby = $this->updatedby
        where generatestudentinvoice_id = $generatestudentinvoice_id" ;


        
        $sqlcheck = "select *
        from $this->tablegeneratestudentinvoice gi, $this->tableclosesession cs
        where gi.year_id = cs.year_id and gi.session_id = cs.session_id
	and cs.year_id = $this->year_id and cs.session_id = $this->session_id
        and cs.organization_id = $defaultorganization_id
        and cs.isactive = 1 ";

       $this->changesql = $sqlcheck;
        $rscheck=$this->xoopsDB->query($sqlcheck);

        if ($rowcheck=$this->xoopsDB->fetchArray($rscheck)){//check closing
        $this->txtwarning = "Acadamic Session Already Closed. ";
        return false;
        }else{

            $this->changesql = $sql;
            $query=$this->xoopsDB->query($sql);

            if(!$query){
                $this->txtwarning = "Failed To Void Line.";
                return false;
            }else{

                $sqldelete = "delete from $this->tablestudentinvoice where generatestudentinvoice_id = $generatestudentinvoice_id";
                $querydelete=$this->xoopsDB->query($sqldelete);
                if(!$querydelete){
                $this->txtwarning = "Failed To Delete Invoice Line";
                return false;
                }else
                return true;
            }

        }
    }

    public function showListCourse($generatestudentinvoice_id){
        $wherestr = "";

        if($this->course_id > 0)
        $wherestr .= " and st.course_id = $this->course_id";
        if($this->year_id > 0)
        $wherestr .= " and si.year_id = $this->year_id";
        if($this->session_id > 0)
        $wherestr .= " and si.session_id = $this->session_id";
        if($this->student_id > 0)
        $wherestr .= " and si.student_id = $this->student_id";
        if($this->semester_id > 0)
        $wherestr .= " and si.semester_id = $this->semester_id";
        
       $sql = "select cr.course_id,cr.course_name,cr.course_no
                    from $this->tablestudentinvoice si, $this->tablestudent st,$this->tablecourse cr
                    where si.student_id = st.student_id
                    and st.course_id = cr.course_id
                    and si.generatestudentinvoice_id = $generatestudentinvoice_id
                    $wherestr
                    group by st.course_id
                    order by cr.course_no ";
        
        $rs=$this->xoopsDB->query($sql);
        $this->log->showLog(4,"With showListCourse SQL:$sql");

echo <<< EOF
        <form action="generateinvoice.php" method="POST" atarget="_blank" name="frmCourseList">
        <input type="hidden" name="action" value="viewstudentinvoice">
        <input type="hidden" name="year_id" value="$this->year_id">
        <input type="hidden" name="session_id" value="$this->session_id">
        <input type="hidden" name="course_id" value="$this->course_id">
        <input type="hidden" name="student_id" value="$this->student_id">
        <input type="hidden" name="semester_id" value="$this->semester_id">
        <input type="hidden" name="generatestudentinvoice_id" value="$generatestudentinvoice_id">

        <table>
        <tr>
        <th align="center">No</th>
        <th align="center">Course</th>
        <th align="center">Code</th>
        <th align="center">View</th>
        </tr>
EOF;

        $rowtype="";
        $i=0;
        while($row=$this->xoopsDB->fetchArray($rs)){//check closing
        $i++;

        $course_id = $row['course_id'];
        $course_name = $row['course_name'];
        $course_no = $row['course_no'];
        
        if($rowtype == "even")
        $rowtype = "odd";
        else
        $rowtype = "even";
echo <<< EOF
        <tr>
        <td align="center" class="$rowtype">$i</td>
        <td align="left" class="$rowtype">$course_name</td>
        <td align="center" class="$rowtype">$course_no</td>
        <td align="center" class="$rowtype"><input type="submit" value="View Student List" onclick="course_id.value = $course_id"></td>
        </tr>
EOF;
        }

echo <<< EOF
        <tr>
        <td colspan="4"><a style="cursor:pointer" onclick="viewAllStudent()">View All Student >></a></td>
        </tr>
        </table>
        </form>
EOF;
    }

    public function showListStudent($generatestudentinvoice_id,$course_id){

        $wherestr = " where si.generatestudentinvoice_id = $generatestudentinvoice_id ";

        if($course_id > 0)
        $wherestr .= " and st.course_id = $course_id";
        if($this->year_id > 0)
        $wherestr .= " and si.year_id = $this->year_id";
        if($this->session_id > 0)
        $wherestr .= " and si.session_id = $this->session_id";
        if($this->student_id > 0)
        $wherestr .= " and si.student_id = $this->student_id";
        if($this->semester_id > 0)
        $wherestr .= " and si.semester_id = $this->semester_id";
        
        $sql = "select si.studentinvoice_id,st.student_id,st.student_name,st.student_no,
        cr.course_name,cr.course_no,sm.semester_name,si.total_amt
        from $this->tablestudentinvoice si
        left join $this->tablestudentinvoiceline sl on sl.studentinvoice_id = si.studentinvoice_id
        left join $this->tablestudent st on st.student_id = si.student_id
        inner join $this->tablecourse cr on cr.course_id = st.course_id
        inner join $this->tablesemester sm on sm.semester_id = st.semester_id
        $wherestr
        group by st.student_id
        order by st.course_id,st.semester_id,st.student_no ";

        $rs=$this->xoopsDB->query($sql);
        $this->log->showLog(4,"With showListCourse SQL:$sql");

echo <<< EOF
        <form action="viewstudentinvoice.php" method="POST" target="_blank" name="frmStudentList">
        <input type="hidden" name="action" value="viewstudentinvoicedetail">
        <input type="hidden" name="year_id" value="$this->year_id">
        <input type="hidden" name="session_id" value="$this->session_id">
        <input type="hidden" name="course_id" value="$this->course_id">
        <input type="hidden" name="student_id" value="$this->student_id">
        <input type="hidden" name="semester_id" value="$this->semester_id">
        <input type="hidden" name="generatestudentinvoice_id" value="$generatestudentinvoice_id">

        <table>
        <tr>
        <th align="center">Print</th>
        <th align="center">No</th>
        <th align="center">Name</th>
        <th align="center">Matrix No</th>
        <th align="center">Semester</th>
        <th align="center">Course</th>
        <th align="center">Amount (RM)</th>
        <th align="center">View</th>

        </tr>
EOF;

        $rowtype="";
        $i=0;
        while($row=$this->xoopsDB->fetchArray($rs)){//check closing
        $i++;

        $studentinvoice_id = $row['studentinvoice_id'];
        $student_id = $row['student_id'];
        $student_name = $row['student_name'];
        $student_no = $row['student_no'];
        $course_name = $row['course_name'];
        $course_no = $row['course_no'];
        $semester_name = $row['semester_name'];
        $total_amt = $row['total_amt'];


        if($rowtype == "even")
        $rowtype = "odd";
        else
        $rowtype = "even";
echo <<< EOF
        <input type="hidden" name="studentinvoice_id[$i]" value="$studentinvoice_id">
        <tr>
        <td align="center" class="$rowtype"><input type="checkbox" name="isselect[$i]"></td>
        <td align="center" class="$rowtype">$i</td>
        <td align="left" class="$rowtype"><a target="blank" href="../simbiz/student.php?action=edit&student_id=$student_id">$student_name</a></td>
        <td align="center" class="$rowtype">$student_no</td>
        <td align="center" class="$rowtype">$semester_name</td>
        <td align="center" class="$rowtype">$course_no</td>
        <td align="center" class="$rowtype">$total_amt</td>
        <td align="center" class="$rowtype">
        <input type="button" value="Edit Invoice" title="Edit Student Invoice" onclick="editStudentInvoice($studentinvoice_id)">
        <img src="images/list.gif" title="Preview Invoice" style="cursor:pointer" onclick="viewStudentInvoice($studentinvoice_id)">
        </td>
        </tr>
EOF;
        }
        
    if($i > 0){
echo <<< EOF
    <tr height="40">
    <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/arrowsel.png">
    <a style="cursor:pointer" onclick="selectAll(true);">Check All</a> /
    <a style="cursor:pointer" onclick="selectAll(false);">Uncheck All</a>

    <i>(Print selected line)</i></td>
    <td colspan="4" align="right">&nbsp;&nbsp;<b><font color=red>Total Student : $i</font><b></td>
    </tr>

    <tr height="40">
    <td colspan="8" align="left"><input type="submit" value="Print Selected"></td>
    </tr>

EOF;
    }
    
echo <<< EOF

        </table>
        </form>
EOF;
    }

    public function publishSetInvoice($generatestudentinvoice_id,$ispublish){

        if($ispublish=="true")
        $ispublish = 1;
        else
        $ispublish = 0;
        
        $sql = "update $this->tablegeneratestudentinvoice set ispublish = $ispublish where generatestudentinvoice_id = $generatestudentinvoice_id";
        $this->changesql;
        
        $query=$this->xoopsDB->query($sql);

        if(!$query)
        return false;
        else
        return true;

    }

} // end of ClassGenerateinvoice
?>

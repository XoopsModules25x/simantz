<?php


class Studentonline
{

  public $studentonline_id;
  public $studentonline_name;
  public $studentonline_no;
  public $studentonline_category;
  
  public $course_id;
  public $coursetype_id;
  public $studentonlinetype_id;
  public $studentonline_crdthrs1;
  public $studentonline_crdthrs2;

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
  private $tablestudentonline;
  private $tablebpartner;

  private $log;


//constructor
   public function Studentonline(){
	global $xoopsDB,$log,$tablestudentonline,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport;
    global $tablesubjecttype,$tablesemester,$tablecourse,$tableemployee,$tablestudentonlinelecturer,$tablestudentonlinenote;
    global $tablesubjectregister,$tablestudent,$tablesubject,$tableyear,$tablesession,$tablesubjectclass,$tableclosesession;
    global $tablelecturerroom,$tablesubjectclassline,$tableindustrialcompany,$tablestudentonline,$tablecoursetype,$tablestudentinvoice;
    global $tablestudentspm,$tablestudentspmonline,$tablesubjectspm;
    
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablestudentonline=$tablestudentonline;
    $this->tablestudentonlinetype=$tablestudentonlinetype;
    $this->tableyear=$tablesession;
    $this->tablesession=$tablesession;
    $this->tablesemester=$tablesemester;
    $this->tablecourse=$tablecourse;
	$this->tablestudent=$tablestudent;
    $this->tablesubject=$tablesubject;
    $this->tablesubjecttype=$tablesubjecttype;
    $this->tablesubjectregister=$tablesubjectregister;
    $this->tableemployee=$tableemployee;
    $this->tablestudentonlinelecturer=$tablestudentonlinelecturer;
    $this->tablestudentonlinenote=$tablestudentonlinenote;
    $this->tableyear=$tableyear;
    $this->tablesession=$tablesession;
    $this->tablesubjectclass=$tablesubjectclass;
    $this->tablesubjectclassline=$tablesubjectclassline;
    $this->tableclosesession=$tableclosesession;
    $this->tablelecturerroom=$tablelecturerroom;
    $this->tableindustrialcompany=$tableindustrialcompany;
    $this->tablestudentonline=$tablestudentonline;
    $this->tablecoursetype=$tablecoursetype;
    $this->tablestudentinvoice=$tablestudentinvoice;
    $this->tablestudentspmonline=$tablestudentspmonline;
    $this->tablestudentspm=$tablestudentspm;
    $this->tablesubjectspm=$tablesubjectspm;

	$this->log=$log;


   }
  
  /**
   * Update existing studentonline record
   *
   * @return bool
   * @access public
   */
  public function updateStudentonline( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablestudentonline SET
	studentonline_name='$this->studentonline_name',description='$this->description',studentonline_no='$this->studentonline_no',studentonline_category='$this->studentonline_category',
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',defaultlevel=$this->defaultlevel,
    course_id=$this->course_id,
    coursetype_id=$this->coursetype_id,
    studentonlinetype_id=$this->studentonlinetype_id,
    studentonline_crdthrs1=$this->studentonline_crdthrs1,
    studentonline_crdthrs2=$this->studentonline_crdthrs2,
	organization_id=$this->organization_id WHERE studentonline_id='$this->studentonline_id'";
	$this->changesql = $sql;
	$this->log->showLog(3, "Update studentonline_id: $this->studentonline_id, $this->studentonline_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update studentonline failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update studentonline successfully.");
		return true;
	}
  } // end of member function updateStudentonline


  /**
   * Pull data from studentonline table into class
   *
   * @return bool
   * @access public
   */
  public function fetchStudentonline( $studentonline_id) {


	$this->log->showLog(3,"Fetching studentonline detail into class Studentonline.php.<br>");
		
	$sql="SELECT * 
		 from $this->tablestudentonline where studentonline_id=$studentonline_id";
	
	$this->log->showLog(4,"ProductStudentonline->fetchStudentonline, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->studentonline_name=$row["studentonline_name"];
		$this->studentonline_no=$row["studentonline_no"];
        $this->studentonline_category=$row["studentonline_category"];
		$this->organization_id=$row['organization_id'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->isactive=$row['isactive'];
		$this->description=$row['description'];
		$this->course_id=$row['course_id'];
		$this->coursetype_id=$row['coursetype_id'];
		$this->studentonlinetype_id=$row['studentonlinetype_id'];
		$this->studentonline_crdthrs1=$row['studentonline_crdthrs1'];
		$this->studentonline_crdthrs2=$row['studentonline_crdthrs2'];


   	$this->log->showLog(4,"Studentonline->fetchStudentonline,database fetch into class successfully");
	$this->log->showLog(4,"studentonline_name:$this->studentonline_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Studentonline->fetchStudentonline,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchStudentonline
  
  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */

 public function showStudentonlineTable($wherestring,$orderbystring,$limitstr=""){
    global $ctrl;
    
    $wherestring = " where se.isactive = 1 and se.studentonline_status = 'A' ";

    $wherestring .= $this->getWhereStr();

    $limit_no = 20;
    $page_no = $this->page_no;

    $limit_start = $limit_no*$page_no;
    if($limit_start <= 0)
    $limit_start = 1;

    $limit_start = $limit_start - $limit_no;

    $limit_str = "LIMIT $limit_start,$limit_no";
    
    $sql = "select se.*,cr.course_no as course_no1,cr.course_name as course_name1,
    (select count(*) from $this->tablestudent where applicant_id = se.student_id) as cntcreate
    from $this->tablestudentonline se
    inner join $this->tablecourse cr on cr.course_id = se.course_id

    $wherestring
    group by se.student_id
    order by se.course_id,se.student_name ";

//    left join $this->tablestudentinvoice si on si.applicant_id = se.student_id

    $select_page = $this->selectPageNumber($sql,$limit_no);
    //echo "$sql $limit_str";
    $query=$this->xoopsDB->query("$sql $limit_str");
    
    $this->log->showLog(4,"showStudentonlineTable:" . $sql . "<br>");

echo <<< EOF

        <form name="frmApproval" action="studentonline.php" method="POST" onsubmit='return validate()'>
        <input type="hidden" name="action" value="">
        <input type="hidden" name="issearch" value="Y">
        <input type="hidden" name="coursetype_id" value="$this->coursetype_id">
        <input type="hidden" name="course_id" value="$this->course_id">
        <input type="hidden" name="created" value="$this->created">
        <input type="hidden" name="student_newicno" value="$this->student_newicno">
        <input type="hidden" name="studentonline_status" value="$this->studentonline_status">

        <table>
        <tr>
        <td class="vfocus" width=12px></td>
        <td>(Background Color) Not Yet Create To Student</td>
        </tr>
        </table>

        <table>

        <tr>
        <th align="center"></th>
        <th align="center">No</th>
        <th align="center">Student</th>
        <th align="center">IC No</th>
        <th align="center">Offered Course</th>
        <th align="center">Invoice Amount (RM)</th>
        <th align="center">Paid Amount (RM)</th>
        <th align="center">Payment Method</th>
        <th align="center">Doc No</th>
        <th align="center">Remarks</th>
        <th align="center">Invoice</th>
        <th align="center">Create</th>
        </tr>

EOF;

     $i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
    $i++;

    //$studentonlineline_id = $row['studentonlineline_id'];
    $student_id = $row['student_id'];
    $student_name = $row['student_name'];
    $student_newicno = $row['student_newicno'];
    $isoffered_course = $row['isoffered_course'];
    $invoice_amt = $row['invoice_amt'];
    $paid_amt = $row['paid_amt'];
    $payment_method = $row['payment_method'];
    $doc_no = $row['doc_no'];
    $isstudentcreate = $row['isstudentcreate'];
    $studentinvoice_id = $row['studentinvoice_id'];
    $cntcreate = $row['cntcreate'];
    
    $description = $row['description'];


    $styleinvoice = "style='display:none'";
    if($studentinvoice_id > 0)
    $styleinvoice = "";

    $courseofferedctrl=$ctrl->getSelectCourse($isoffered_course,"N","","isoffered_course[$i]"," and course_id = $isoffered_course ","style='width:100px'");
    

    $selectMethodN = "";
    $selectMethodB = "";
    $selectMethodC = "";
    $selectMethodQ = "";
    if($payment_method == "B")
    $selectMethodB = "selected";
    else if($payment_method == "C")
    $selectMethodC = "selected";
    else if($payment_method == "Q")
    $selectMethodQ = "selected";
    else
    $selectMethodN = "selected";

    $styletxtarea = "style='display:none'";
    if($description != "")
    $styletxtarea = "";

    if($cntcreate > 0)
    $isstudentcreate = "Yes";
    else
    $isstudentcreate = "";
    
    if($rowtype == "even")
    $rowtype = "odd";
    else
    $rowtype = "even";

    if($cntcreate == 0){
        $rowtype = "vfocus";
    }
echo <<< EOF
        <input type="hidden" name="student_id[$i]" value="$student_id">
        <tr>
        <td class="$rowtype" align="center"><input type="checkbox" name="isselected[$i]" id="isselected$i"></td>
        <td class="$rowtype" align="center">$i</td>
        <td class="$rowtype" align="left"><a target="blank" href="../simbiz/studentonline.php?action=viewdetail&student_id=$student_id">$student_name</td>
        <td class="$rowtype" align="center">$student_newicno</td>
        <td class="$rowtype" align="center">$courseofferedctrl</td>
        <td class="$rowtype" align="center"><input name="invoice_amt[$i]" value="$invoice_amt" size="10" maxlength="10" onfocus="select();"></td>
        <td class="$rowtype" align="center"><input name="paid_amt[$i]" value="$paid_amt" size="10" maxlength="10" onfocus="select();"></td>
        <td class="$rowtype" align="center">
        <select name="payment_method[$i]">
        <option value="" $selectMethodN></option>
        <option value="B" $selectMethodB>Bank</option>
        <option value="C" $selectMethodC>Cash</option>
        <option value="Q" $selectMethodQ>Cheque</option>
        </select>
        </td>
        <td class="$rowtype" align="center"><input name="doc_no[$i]" value="$doc_no" size="10" maxlength="20"></td>
        <td class="$rowtype" align="center"><a onclick="showTextArea($i)" style="cursor:pointer">View Remarks >></a><textarea $styletxtarea id="idTextArea$i" name="description[$i]" rows="5" cols="40">$description</textarea></td>
        <td class="$rowtype" align="center"><a href="studentinvoice.php?applicant_id=$student_id" $styleinvoice>View Invoice</a></td>
        <td class="$rowtype" align="center">$isstudentcreate</td>
        </tr>


EOF;
    }

        if($i > 0){
echo <<< EOF
    <tr height="40">
    <td colspan="10"><img src="images/arrowsel.png">
    <a style="cursor:pointer" onclick="selectAll(true);">Check All</a> /
    <a style="cursor:pointer" onclick="selectAll(false);">Uncheck All</a>
    </td>
    <td colspan="3" align="right"><input type="button" value="Save Record" onclick="checkRecord()"></td>
    </tr>

    <tr>
    <td colspan='13'>Page : $select_page</td>
    </tr>

    <tr>
    <td colspan='13'><br/></td>
    </tr>

    <tr>
    <td colspan="14">

    <table style="width:1%">
    <tr>
    <td colspan="2"><i>Update Field With Selected Line :</i></td>
    </tr>

    <tr style="display:none">
    <td class="even" nowrap>Approve / Rejected</td>
    <td class="odd" nowrap>
    <input type="button" value="Approve" onclick="updateField('studentonline_status','A')">
    <input type="button" value="Rejected" onclick="updateField('studentonline_status','R')">
    </td>
    </tr>



    <tr style="display:none">
    <td class="even" nowrap>Qualify Status</td>
    <td class="odd" nowrap>
    <select name="issuccessupdate">
    <option value="">Null</option>
    <option value=1>Yes</option>
    <option value=0>No</option>
    </select>
    <input type="button" value="Update Status" onclick="updateSelected('rejectline')">
    </td>
    </tr>

    <tr>
    <td class="even" nowrap style="display:none">Generate Invoice</td>
    <td class="odd" nowrap style="display:none">
    <input type="button" value="Generate" onclick="approveSelected('approveline') style="display:none"">
    </td>
    </tr>

    <tr>
    <td class="even" nowrap style="display:none">Print Invoice</td>
    <td class="odd" nowrap style="display:none">
    <input type="button" value="Print" onclick="approveSelected('approveline')" style="display:none">
    </td>
    </tr>

    <tr>
    <td class="even" nowrap>Invoice Amount(RM)</td>
    <td class="odd" nowrap>
    <input name='invoice_amtupdate' value="" maxlength='10' size='10'>
    <input type="button" value="Update Invoice Amount" onclick="updateField('invoice_amt',invoice_amtupdate.value);">
    </td>
    </tr>

    <tr>
    <td class="even" nowrap>Paid Amount(RM)</td>
    <td class="odd" nowrap>
    <input name='paid_amtupdate' value="" maxlength='10' size='10'>
    <input type="button" value="Update Paid Amount" onclick="updateField('paid_amt',paid_amtupdate.value);">
    </td>
    </tr>

    <tr>
    <td class="even" nowrap>Generate Student</td>
    <td class="odd" nowrap>
    <input type="button" value="Generate" onclick="generateStudent()">
    </td>
    </tr>


    <tr>
    <td class="even" nowrap>Email / SMS</td>
    <td class="odd" nowrap>
    <table>
        <tr>
        <td align="left">
        Title (Email Only) <br/><Input name='emailtitle' value='' size='30'/><br/>
        Body <br/><textarea cols='70' rows='4' name='msg' onkeyup="textlength.value=this.value.length"></textarea>
        <input name="textlength" value="0" size='4'>(1 SMS 160 character)
        </td>
        </tr>
        <tr><td>
        <input type="submit" value="Send SMS" onclick="action.value='sendsms'">
        <input type="submit" value="Send Email" onclick="action.value='sendemail'">
        </form>
        </td>
        </tr>
    </table>
    </td>
    </tr>

    </table>
    </td>
    </tr>

EOF;
    }

    echo "</table></form>";
 }

 public function selectPageNumber($sql,$limit_no){

        $html = "";
        $query=$this->xoopsDB->query($sql);

        $html .= "<select onchange='getPageDetails(this.value)'>";
        $i=0;
        while($row=$this->xoopsDB->fetchArray($query)){
        $i++;

        }

        $balance = $i%$limit_no;

        $j = 0;
        while($j < (int)($i/$limit_no)){
            $j++;

            $selected = "";
            if($j == $this->page_no)
            $selected = "SELECTED=SELECTED";

            $html .= "<option value='$j' $selected>$j</option>";
        }

        if($balance > 0){

        $j++;
        $selected = "";
        if($j == $this->page_no)
        $selected = "SELECTED=SELECTED";

        $html .= "<option value='$j' $selected>$j</option>";
        }

        $html .= "</select>";

        return $html;

    }
    
     public function showSearchForm($wherestr){


	if($this->issearch != "Y"){
	$this->issuccess = "";
	$this->studentonline_status = "";
        $this->iscreatetostudent = "";
	}

	//iscomplete

        $selectCreateY = "";
        $selectCreateN = "";
        $selectCreateNull = "";
	if($this->iscreatetostudent == "Y")
	$selectCreateY = "selected = 'selected'";
	else if($this->iscreatetostudent == "N")
	$selectCreateN = "selected = 'selected'";
	else
	$selectQNull = "selected = 'selected'";
        
        $selectQY = "";
        $selectQN = "";
        $selectQNull = "";
	if($this->issuccess == "1")
	$selectQY = "selected = 'selected'";
	else if($this->issuccess == "0")
	$selectQN = "selected = 'selected'";
	else
	$selectQNull = "selected = 'selected'";

        $selectStatusNull="";
        $selectStatusN="";
        $selectStatusA="";
        $selectStatusR="";
        $selectStatusI="";
        $selectStatusP="";
        if($this->studentonline_status=="N")
        $selectStatusN = "SELECTED";
        else if($this->studentonline_status=="A")
        $selectStatusA = "SELECTED";
        else if($this->studentonline_status=="R")
        $selectStatusR = "SELECTED";
        else if($this->studentonline_status=="I")
        $selectStatusI = "SELECTED";
        else if($this->studentonline_status=="P")
        $selectStatusP = "SELECTED";
        else
        $selectStatusNull = "SELECTED";

	//echo $this->iscomplete;

echo <<< EOF
<form name="frmStudentonline" action="studentonline.php" method="POST">
	</form>
	<form name="frmSearch" action="studentonline.php" method="POST">

	<table>
	<tr>
	<td nowrap><input value="Reset" type="reset"></td>
	</tr>
	</table>

	<table border="0">
	<input name="issearch" value="Y" type="hidden">
	<input name="action" value="search" type="hidden">
        <input name="page_no" value="$this->page_no" type="hidden">
	<tr><th colspan="4">Criterial</th></tr>

    <tr>
    <td class="head">IC No</td>
    <td class="even" acolspan="3"><input name="student_newicno" value="$this->student_newicno"></td>
    <td class="head">Applied Date</td>
    <td class="even" acolspan="3">
    <input name='created' id='created' value="$this->created" maxlength='10' size='10'>
    <input name='btnDate' value="Date" type="button" onclick="$this->createddatectrl">
    </td>
    </tr>

    <tr>
    <td class="head">Course</td>
    <td class="even"">$this->coursectrl</td>
    <td class="head">Course Type</td>
    <td class="even"">$this->coursetypectrl</td>
    </tr>

    <tr style="display:none">
    <td class="head">Progress Status</td>
    <td class="even"  colspan="3">
    <select name="studentonline_status">
    <option value="" $selectStatusNull>Null</option>
    <option value="N" $selectStatusN>New</option>
    <option value="P" $selectStatusP>In Progress</option>
    <option value="I" $selectStatusI>Interview</option>
    <option value="R" $selectStatusR>Reject</option>
    <option value="A" $selectStatusA>Approve</option>
    </select>
    </td>
    <td class="head" style="display:none">Qualify Type</td>
    <td class="even"  acolspan="3" style="display:none">
    <select name="issuccess">
    <option value="" $selectQNull>Null</option>
    <option value=1 $selectQY>Yes</option>
    <option value=0 $selectQN>No</option>
    </select>
    </td>
    </tr>


    <tr>
    <td class="head">Is Create?</td>
    <td class="even" colspan="3">
    <select name="iscreatetostudent">
    <option value="" $selectCreateNull>Null</option>
    <option value="Y" $selectCreateY>Yes</option>
    <option value="N" $selectCreateN>No</option>
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



        if($this->coursetype_id > 0)
        $wherestr .= " and ( ct.coursetype_id = $this->coursetype_id or ct2.coursetype_id = $this->coursetype_id ) ";
        if($this->course_id > 0)
        $wherestr .= " and ( se.course_id = $this->course_id or se.course_id2 = $this->course_id ) ";
        if($this->studentonline_status != "")
        $wherestr .= " and se.studentonline_status like '$this->studentonline_status' ";
        if($this->isscuccess != "")
        $wherestr .= " and se.isscuccess = $this->isscuccess ";
        if($this->student_newicno != "")
        $wherestr .= " and se.student_newicno like '$this->student_newicno' ";

        if($this->iscreatetostudent == "Y")
        $wherestr .= " and (select count(*) from $this->tablestudent where applicant_id = se.student_id) > 0 ";
        if($this->iscreatetostudent == "N")
        $wherestr .= " and (select count(*) from $this->tablestudent where applicant_id = se.student_id) = 0 ";


        /*
        if($this->created != "")
        $wherestr .= " and substring(se.created,1,10) = '$this->created' ";
         * 
         */
        

	return $wherestr;

	}


    public function addLecturerLine($studentonline_id,$addemployee_id){

        $sql = " insert into $this->tablestudentonlinelecturer (studentonline_id,employee_id) values ($studentonline_id,$addemployee_id) ";
        $this->changesql = $sql;
        
        $this->log->showLog(4,"Before insert studentonline addLecturerLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        return true;
    }

    public function updateLecturerLine(){

        $i=0;
        foreach($this->studentonlinelecturerline_id as $id){
        $i++;

        $employee_id = $this->employee_id[$i];
        $studentonlinelecturer_description = $this->studentonlinelecturer_description[$i];

        $sql = "update $this->tablestudentonlinelecturer set employee_id = $employee_id, studentonlinelecturer_description = '$studentonlinelecturer_description'
                    where studentonlinelecturerline_id = $id ";

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert studentonline updateLecturerLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        }

        return true;
    }

    public function deleteLectLine($studentonlinelecturerline_id){

        $sql = "delete from $this->tablestudentonlinelecturer where studentonlinelecturerline_id = $studentonlinelecturerline_id";

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert studentonline deleteLectLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }else
        return true;
        
    }

    public function addNoteLine($studentonline_id){

        $sql = " insert into $this->tablestudentonlinenote (studentonline_id) values ($studentonline_id) ";
        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert studentonline addNoteLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        return true;
    }

    public function updateNoteLine(){

        $i=0;
        foreach($this->studentonlinenoteline_id as $id){
        $i++;

        $studentonlinenote_title = $this->studentonlinenote_title[$i];
        $studentonlinenote_description = $this->studentonlinenote_description[$i];
        $isdownload = $this->isdownload[$i];
        $isdeleteline = $this->isdeleteline[$i];

        if($isdownload == "on")
        $isdownload = 1;
        else
        $isdownload = 0;

        if($isdeleteline == "on"){
        $this->deleteNoteLine($id);
        }else{
        $sql = "update $this->tablestudentonlinenote
                    set studentonlinenote_title = '$studentonlinenote_title',
                    studentonlinenote_description = '$studentonlinenote_description',
                    isdownload = '$isdownload' 
                    where studentonlinenoteline_id = $id ";
        

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert studentonline updateNoteLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }
        
        $this->saveAtt($this->atttmpfile[$i],$this->attfilesize[$i],$this->attfiletype[$i],$this->attfilename[$i],$id);
        }

        }

        return true;
    }

    public function deleteNoteLine($studentonlinenoteline_id){

        $sql = "delete from $this->tablestudentonlinenote where studentonlinenoteline_id = $studentonlinenoteline_id";

        $this->changesql = $sql;
        $this->deletefile($studentonlinenoteline_id);
        
        $this->log->showLog(4,"Before insert studentonline deleteNoteLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }else{
            
            return true;
        }

    }

    public function saveAtt($atttmpfile,$attfilesize,$attfiletype,$attfilename,$studentonlinenoteline_id){
	//$file_ext = "jpg";


	$file_ext = strrchr($attfilename, '.');

	$attfilesize = $attfilesize / 1024;
	//&& $attfilesize<300
	if($attfilesize>0 ){
	$newfilename = $studentonlinenoteline_id."$file_ext";
	$this->savefile($atttmpfile,$newfilename,$studentonlinenoteline_id);
	}


	}

    public function savefile($tmpfile,$newfilename,$studentonlinenoteline_id){

        if(move_uploaded_file($tmpfile, "upload/studentonline/$newfilename")){
        $sqlupdate="UPDATE $this->tablestudentonlinenote set filenote='$newfilename' where studentonlinenoteline_id=$studentonlinenoteline_id";
        $qryUpdate=$this->xoopsDB->query($sqlupdate);
        }else{
        echo "Cannot Upload File";
        }
    }

	public function deletefile($studentonlinenoteline_id){
		$sql="SELECT filenote from $this->tablestudentonlinenote where studentonlinenoteline_id=$studentonlinenoteline_id";
		$query=$this->xoopsDB->query($sql);
		$myfilename="";
		if($row=$this->xoopsDB->fetchArray($query)){
			$myfilename=$row['filenote'];
		}
		$myfilename="upload/studentonline/$myfilename";
		$this->log->showLog(3,"This file name: $myfilename");
		unlink("$myfilename");
		$sqlupdate="UPDATE $this->tablestudentonlinenote set filenote='' where studentonlinenoteline_id=$studentonlinenoteline_id";
		$qryDelete=$this->xoopsDB->query($sqlupdate);
	}

    public function deleteAllLine($studentonline_id){

	$sqlselect = "select * from $this->tablestudentonlinenote where studentonline_id = $studentonline_id and filenote <> '' ";

	$queryselect=$this->xoopsDB->query($sqlselect);

	while($rowselect=$this->xoopsDB->fetchArray($queryselect)){

	$studentonlinenoteline_id = $rowselect['studentonlinenoteline_id'];
	$myfilename = $rowselect['filenote'];

	$myfilename = "upload/studentonline/$myfilename";
	unlink("$myfilename");

	//$this->deletefile($studentonlineline_id);
	}
  }

      public function showDetailsList($subjectclass_id,$course_id,$coursetype_id,$group_no){
        global $ctrl;
        
        $stylewidthstudent = "style = 'width:200px' ";

        $wherestr = "";
        if($course_id > 0)
        $wherestr .= " and st.course_id = $course_id  ";
        if($coursetype_id > 0){
        $wherestr .= " and sr.coursetype_id = $coursetype_id  ";
        $wheresemester = " and coursetype_id = $coursetype_id ";
        }

        $sql = "select *,
                    (select sum(sb.subject_crdthrs1 + sb.subject_crdthrs2) from $this->tablesubjectregister sr2, $this->tablesubjectclass sc2, $this->tablesubject sb
                      where sr2.student_id = sr.student_id
                      and sr2.subjectclass_id = sc2.subjectclass_id
                      and sc2.subject_id = sb.subject_id 
                    ) as total_crdthrs,sr.isactive as isactive_line
                    from $this->tablesubjectclass sc, $this->tablestudent st, $this->tablesubjectregister sr, $this->tablecourse cr, $this->tablesemester sm 
                    where sr.student_id = st.student_id
                    and sr.subjectclass_id = sc.subjectclass_id
                    and st.course_id = cr.course_id
                    and sr.coursetype_id = sm.coursetype_id
                    and sc.subjectclass_id = $subjectclass_id
                    $wherestr
                    order by sr.subjectregister_status desc,sr.subjectregister_type,st.student_no ";

    $query=$this->xoopsDB->query($sql);

    $yearctrl=$ctrl->getSelectYear($this->year_id,"N","",""," and year_id = $this->year_id ");
    $sessionctrl=$ctrl->getSelectSession($this->session_id,"N","",""," and session_id = $this->session_id ");
    $subjectctrl=$ctrl->getSelectSubject($this->subject_id,"N","",""," and subject_id = $this->subject_id ");


    $wheresem = "";
   // if($this->semesterline_id >0)
    //$wheresem .= " and coursetype_id = $this->semesterline_id";

    $semesterctrl=$ctrl->getSelectSemester($coursetype_id,"Y","","semester_addline"," $wheresem ");


    $wherestudent = "";
    //if($this->courseline_id >0)
    //$wherestudent .= " and course_id = $this->courseline_id";

    $studentctrl=$ctrl->getSelectStudent(0,'Y',"",$ctrlname="student_addline","$wherestudent","student_addline","$stylewidthstudent","Y",0);
    
echo <<< EOF
    <form name="frmApproval" action="studentonline.php" method="POST">
    <input type="hidden" name="approval_type" value="">
    <input type="hidden" name="action" value="viewdetails">
    <input type="hidden" name="subject_id" value="$this->subject_id">
    <input type="hidden" name="year_id" value="$this->year_id">
    <input type="hidden" name="session_id" value="$this->session_id">
    <input type="hidden" name="semesterline_id" value="$this->semesterline_id">
    <input type="hidden" name="courseline_id" value="$this->courseline_id">
    <input type="hidden" name="course_id" value="$course_id">
    <input type="hidden" name="coursetype_id" value="$coursetype_id">
    <input type="hidden" name="subjectclass_id" value="$subjectclass_id">
    <input type="hidden" name="group_no" value="$group_no">


    <table>
    
    <tr>
    <td align="left" nowrap width=1> Add Student : </td>
    <td align="left" nowrap width=1>$semesterctrl</td>
    <td align="left" nowrap width=1>$studentctrl</td>
    <td align="left" nowrap >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" value="Add Student" onclick="addStudent()"></td>
    </tr>
    
    </table>

    <table>
    <tr>
    <th colspan="4">Details Subject</th>
    </tr>

    <tr>
    <td class="head">Academic Session</td>
    <td class="even">$yearctrl / $sessionctrl</td>
    <td class="head">Subject</td>
    <td class="even">$subjectctrl Group : $group_no</td>
    </tr>
    </table>

    <br>

    <table>
    <tr>
    <td class="vfocus" width=12px></td>
    <td>(Background Color) Not Fullfill Requirement</td>
    </tr>
    </table>

    <table>

    <tr>
    <th align="center" width=1 rowspan=2></th>
    <th align="center" rowspan=2>No.</th>
    <th align="center" rowspan=2>Student Name</th>
    <th align="center" rowspan=2>Matrix No</th>
    <th align="center" rowspan=2>Course</th>
    <th align="center" rowspan=2>Semester</th>
    <th align="center" colspan=3>Credit Hours</th>
    <th align="center" rowspan=2>Status</th>
    <th align="center" rowspan=2>Type</th>
    </tr>
    <tr>
    <th align="center">Total</th>
    <th align="center">Maximum</th>
    <th align="center">Minimum</th>
    </tr>
EOF;

    $i=0;
    $rowtype = "";
    while($row=$this->xoopsDB->fetchArray($query)){
    $i++;

    $total_crdthrs = 0;
    $subjectregisterline_id = $row['subjectregisterline_id'];

    $subjectclass_id = $row['subjectclass_id'];
    $coursetype_id = $row['coursetype_id'];
    $semester_name = $row['semester_name'];
    //$course_id = $row['course_id'];
    $year_id = $row['year_id'];
    $session_id = $row['session_id'];
    $subject_id = $row['subject_id'];
    $student_id = $row['student_id'];
    $student_name = $row['student_name'];
    $student_no = $row['student_no'];
    $total_crdthrs = $row['total_crdthrs'];
    $subjectregister_status = $row['subjectregister_status'];
    $subjectregister_type = $row['subjectregister_type'];
    $course_name = $row['course_name'];
    $isactive_line = $row['isactive_line'];
    $course_no = $row['course_no'];
    $group_no = $row['group_no'];
   

    if($subjectregister_status == "N")
    $subjectregister_statusname = "New";
    else if($subjectregister_status == "A")
    $subjectregister_statusname = "Approved";
    else if($subjectregister_status == "R")
    $subjectregister_statusname = "Rejected";
    else
    $subjectregister_statusname = "";

    if($subjectregister_type == "R")
    $subjectregister_typename = "Registration";
    else if($subjectregister_type == "P" && $subjectregister_status == "N")
    $subjectregister_typename = "Subject Add Application";
    else if($subjectregister_type == "P" && $subjectregister_status == "P"){
    $subjectregister_statusname = "New";
    $subjectregister_typename = "Re- Apply Subject";
    }else if($subjectregister_type == "P" && $subjectregister_status == "R"){
    $subjectregister_statusname = "Rejected";
    $subjectregister_typename = "Apply Add Subject";
    }else if($subjectregister_type == "P" && $subjectregister_status == "A"){
    $subjectregister_statusname = "Approved";
    $subjectregister_typename = "Apply Add Subject";
    }else if($subjectregister_type == "D"){

        if($isactive_line == 1){
        $subjectregister_statusname = "New";
        $styledrop = "";
        }else{
        $subjectregister_statusname = "Approved<br>(Inactive)";
        $styledrop = "style='display:none'";
        }
        
    $subjectregister_typename = "Drop";
    }else
    $subjectregister_typename = "";

    if($isactive_line == 0){
       
        $subjectregister_statusname = "(Inactive)";
        $styledrop = "style='display:none'";
        $subjectregister_typename = "Drop";
   }


    $studentCreditHrs = $this->getInfoCreditHrs($student_id,$total_crdthrs);
    $max_crdt = $studentCreditHrs['max_credit'];
    $min_crdt = $studentCreditHrs['min_credit'];

    if(is_int($i/2))
    $rowtype = "odd";
    else
    $rowtype = "even";

    if($total_crdthrs > $max_crdt || $total_crdthrs < $min_crdt){
        $rowtype = "vfocus";
    }

    
    
    if($i == 1){
echo <<< EOF

 
EOF;
    }
    
echo <<< EOF

    <input type="hidden" name="subjectregisterline_id[$i]" value="$subjectregisterline_id">
    <input type="hidden" name="subjectregister_type[$i]" value="$subjectregister_type">
    <tr>
    <td class="$rowtype" align="center"><input type="checkbox" name="isapproval_line[$i]"></td>
    <td class="$rowtype" align="center">$i</td>
    <td class="$rowtype" align="left"><a href="../hes/student.php?action=edit&student_id=$student_id" target="blank">$student_name</a></td>
    <td class="$rowtype" align="center">$student_no</td>
    <td class="$rowtype" align="center">$course_no</td>
    <td class="$rowtype" align="center">$semester_name</td>
    <td class="$rowtype" align="center">$total_crdthrs</td>
    <td class="$rowtype" align="center">$max_crdt</td>
    <td class="$rowtype" align="center">$min_crdt</td>
    <td class="$rowtype" align="center">$subjectregister_statusname</td>
    <td class="$rowtype" align="center">$subjectregister_typename</td>
    </tr>
EOF;
          
    }

    if($i > 0){
echo <<< EOF
    <tr height="40">
    <td colspan="6"><img src="images/arrowsel.png">
    <a style="cursor:pointer" onclick="selectAll(true);">Check All</a> /
    <a style="cursor:pointer" onclick="selectAll(false);">Uncheck All</a>

    <i>(Approve/Reject/Delete/Change selected line)</i></td>
    <td colspan="5" align="right">&nbsp;&nbsp;<b><font color=red>Total Student : $i</font><b></td>
    </tr>

EOF;
    }
    
echo <<< EOF
    </table>

    <table width="100%">
    <tr height="40">
    <td width=1 nowrap>
    <input type="button" value="Approve Selected" onclick="approveSelected('A')">
    <input type="button" value="Reject Selected" onclick="approveSelected('R')">
    <input type="button" value="Delete Selected" onclick="approveSelected('D')">    
    </td>
    <td align="right">
    <input type="button" value="Print List"  onclick="printStudentList($subjectclass_id)">
    </td>

    </tr>
    </table>

    <table width="100%">
    <tr>
    <td width=1 nowrap>
    <input type="button" value="Change Selected" onclick="changeClass()">
    </td>
    <td class="even" id="idChangeClass" style="display:none">
    Select New Class : <br>$this->subjectclassctrl
    <br><input type="button" value="Confirm Change" onclick="confirmChangeClass()">
    </td>
    </tr>
    </table>

    </form>
    <!--<font color=red>* Approve Drop Type Application Will Remove Selected Line </font>-->
EOF;
    
  }


  public function deleteSelectedLine($subjectregisterline_id,$isapproval_line,$approval_type,$subjectregister_type){
        global $log;
        $i=0;
        foreach($subjectregisterline_id as $id){
            $i++;
            
            if($isapproval_line[$i] == "on"){

                if($approval_type == "D"){
                $sqlupdate = "delete from $this->tablesubjectregister where subjectregisterline_id = $id ";
                $logtype="D";
                }else{

                if($subjectregister_type[$i] != "D")
                $sqlupdate = "update $this->tablesubjectregister set subjectregister_status = '$approval_type' where subjectregisterline_id = $id ";
                else{
                    
                    if($approval_type == "A")
                    $sqlupdate = "update $this->tablesubjectregister set subjectregister_status = '$approval_type', isactive=0  where subjectregisterline_id = $id ";
                    else{
                    $sqlupdate = "update $this->tablesubjectregister set subjectregister_type = 'R'  where subjectregisterline_id = $id ";
                    }
                }
                
                $logtype="U";
                }

                $qryUpdate=$this->xoopsDB->query($sqlupdate);

                if(!$qryUpdate){
                $log->saveLog($id,$tablesubjectregister,"$sqlupdate","$logtype","O");
                }else{
                $log->saveLog($id,$tablesubjectregister,"$sqlupdate","$logtype","F");
                }
            
            }
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

    public function getSelectDBAjaxSubjectclass($strchar,$idinput,$idlayer,$ctrlid,$ocf,$table,$primary_key,$primary_name,$wherestr,$line=0){
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

    public function addStudent($subjectclass_id,$student_addline,$semester_addline){
        $timestamp= date("y/m/d H:i:s", time()) ;


        $sql = "insert into $this->tablesubjectregister (student_id,subjectclass_id,coursetype_id,subjectregister_type,subjectregister_status,created,createdby,updated,updatedby)
                    values ($student_addline,$subjectclass_id,$semester_addline,'R','N','$timestamp',$this->updatedby,'$timestamp',$this->updatedby)  ";

        $o->changesql = $sql;
        
        $qryinsert=$this->xoopsDB->query($sql);

                if(!$qryinsert){
                $this->subjectregister_id = $this->getLatestSubjectRegister();
                return true;
                }else{
                return false;
                }
        
    }

        public function checkAddSubject($subjectclass_id,$student_id,$coursetype_id){
        

        $sql = "select count(*) as rowcount from $this->tablesubjectregister
                    where subjectclass_id = $subjectclass_id and student_id = $student_id
                    and isactive = 1 
                    and coursetype_id = $coursetype_id ";

        $query=$this->xoopsDB->query($sql);

        $rowcount = 0;
        if ($row=$this->xoopsDB->fetchArray($query)){
        $rowcount = $row['rowcount'];
        }

        // check current semester subject
        if($rowcount == 0)
        return true;
        else{
        $this->warningtxt = "Subject Already Registered For This Semester. Please Select Others Subject or Semester.";
        return false;
        }



    }

   public function getLatestSubjectRegister(){
      $sql= "select max(subjectregister_id) as max_id from $this->tablesubjectregister ";

      $rs=$this->xoopsDB->query($sql);

        $retval=0;
		if($row=$this->xoopsDB->fetchArray($rs)){
        $retval = $row['max_id'];
        }

        return $retval;
  }

      public function getInfoCreditHrs($student_id,$total_crdt){

        $retval = "";

        $sql = "select * from $this->tablestudentcgpa where student_id = $student_id order by studentcgpa_id desc limit 1 ";

        $rs=$this->xoopsDB->fetchArray($sql);
        $cgpa = 0;
        if ($row=$this->xoopsDB->fetchArray($query)){
        $cgpa = $row['cgpa'];
        }

            $max_credit = 0;
            $max2_credit = 0;
            $min_credit = 0;

        if($cgpa < 2 && $cgpa > 1.7){//kedudukan bersyarat => KS
            $max_credit = 13;
            $max2_credit = 13;
            $min_credit = 9;

            $balance_crdt = $max_credit - $total_crdt;

            if($balance_crdt > 0)
            $retval .= "$balance_crdt Credit Hours Remaining<br>";

            $retval .= "Maximum Total Credit Hours : $max_credit <br>Minimum Total Credit Hours : $min_credit";

        }else if($cgpa == 0 || $cgpa >= 2){//kedudukan baik => KB
            $max_credit = 18;
            $max2_credit = 22;
            $min_credit = 12;

            $balance_crdt = $max2_credit - $total_crdt;

            if($balance_crdt > 0)
            $retval .= "$balance_crdt Credit Hours Remaining<br>";

            $retval .= "Maximum Total Credit Hours : $max_credit<br>Minimum Total Credit Hours : $min_credit<br>Maximum Total Credit Hours (With Approval) : $max2_credit";
        }else{
            $retval = "";
        }



        return array("info"=>$retval,"max_credit"=>$max_credit,"max2_credit"=>$max2_credit,"min_credit"=>$min_credit);

    }

    public function changeClass($subjectclasschange_id,$subjectregisterline_id,$isapproval_line){

        $this->changesql = "";
        $this->liststudent="";
        $i=0;
        $j=0;
        foreach($subjectregisterline_id as $id){
            $i++;

            if($isapproval_line[$i] == "on"){
            
            
                $sqlcheck = "select st.student_name,st.student_no
                                    from $this->tablesubjectregister sr, $this->tablestudent st
                                    where sr.student_id = st.student_id
                                    and sr.subjectclass_id = $subjectclasschange_id
                                    and sr.student_id = (select student_id from $this->tablesubjectregister
                                                                    where subjectregisterline_id = $id) ";

                $rscheck=$this->xoopsDB->query($sqlcheck);

                $student_name="";
                $student_no="";
                if($rowcheck=$this->xoopsDB->fetchArray($rscheck)){
                $student_name = $rowcheck['student_name'];
                $student_no = $rowcheck['student_no'];
                }

                if($student_name == ""){
                    $sqlupdate = "update $this->tablesubjectregister set subjectclass_id = $subjectclasschange_id
                                            where subjectregisterline_id = $id";

                    $queryupdate=$this->xoopsDB->query($sqlupdate);

                    if($queryupdate){
                        $this->changesql .= $sqlupdate;
                    }else{
                        $this->changesql .= $sqlupdate;
                        return false;
                    }

                }else{
                $j++;
                
                $this->liststudent .= "$j) $student_name ($student_no) <br>";
                }
                
            }
            
        }
        return true;
    }


    public function graduateApproval($approval_type){
        $timestamp= date("y/m/d H:i:s", time()) ;

        $this->changesql = "";
        $i=0;
        foreach($this->studentonlineline_id as $id){
            $i++;
            
            if($this->isselected[$i] == "on"){

                $sqlupdate = "update $this->tablestudentonline set
                            studentonline_status = '$approval_type',
                            updated = '$timestamp',
                            updatedby = $this->updatedby,
                            approval_by = $this->updatedby
                            where studentonlineline_id = $id ;";

                    $queryupdate=$this->xoopsDB->query($sqlupdate);

                    if($queryupdate){
                    $this->changesql .= $sqlupdate;
                    }else{
                    $this->changesql .= $sqlupdate;
                    $this->warningtxt = "Failed To Update Status";
                    return false;
                    }

            }
        }

        return true;
        
    }

    public function getEmail(){
        $i=0;
        $j=0;
        $result="";
        $this->log->showLog(3,"call GetEmail");
        foreach($this->studentarr_id as $student_id){
        $i++;

            if($this->isselected[$i] == "on"){
            $j++;
            $sql = "select st.student_name,st.student_no,st.student_email as email
                        from $this->tablestudent st
                        where st.student_id = $student_id ";

            $query=$this->xoopsDB->query($sql);

            if ($row=$this->xoopsDB->fetchArray($query)){
            $student_name = $row['student_name'];
            $student_no = $row['student_no'];
             $email = $row['email'];
                if($email!="")
                    $result.=$email.",";
            }
        }
        }
        $result=substr_replace($result,"",-1);
        return $result;
    }
    public function getNumber(){
          $i=0;
        $j=0;
        $result="";
        $this->log->showLog(3,"call getNumber");
        foreach($this->studentarr_id as $student_id){
        $i++;

            if($this->isselected[$i] == "on"){
            $j++;
            $sql = "select student_hpno
                        from $this->tablestudent where student_id = $student_id ";

            $query=$this->xoopsDB->query($sql);

            if ($row=$this->xoopsDB->fetchArray($query)){
            $student_name = $row['student_name'];
            $student_no = $row['student_no'];
             $student_hpno = $row['student_hpno'];
                if($student_hpno!="")
                    $result.=$student_hpno."@";
            }
        }
        }
        $result=substr_replace($result,"",-1);
        return $result;
    }


    public function updateList(){
        $timestamp= date("y/m/d H:i:s", time()) ;

        $this->changesql = "";
        $i=0;
        foreach($this->student_id as $id){
        $i++;
        
        $invoice_amt = $this->invoice_amt[$i];
        $paid_amt = $this->paid_amt[$i];
        $payment_method = $this->payment_method[$i];
        $doc_no = $this->doc_no[$i];
        $description = $this->description[$i];

        $sql = "update $this->tablestudentonline set
        invoice_amt = $invoice_amt,
        paid_amt = $paid_amt,
        payment_method = '$payment_method',
        doc_no = '$doc_no',
        description = '$description'
        where student_id = $id ";
        
        $this->changesql .= $sql;

        $query=$this->xoopsDB->query($sql);

        if(!$query){

        $this->warningtxt = "Failed To Update Record List";
        return false;
        }

        }

        return true;

    }


    public function generateStudent(){
        global $defaultorganization_id;

        include "../marketing/setting.php";

        $timestamp= date("y/m/d H:i:s", time()) ;

        $this->changesql = "";
        $i=0;
        foreach($this->student_id as $id){
        $i++;

        $isselected = $this->isselected[$i];

        if($isselected == "on"){


        $matrix_no = getNewCode($this->xoopsDB,"student_no","$this->tablestudent","");
        $temp_password = rand(1000000,9999999);
        

        //$yearsession = getYearSession();

        //$year_id = $yearsession['year_id'];
        //$session_id = $yearsession['session_id'];
        $year_id = $marketingyear_id;
        $session_id = $marketingsession_id;

        //echo "$year_id $session_id";

        $sqlapplicant =
        "select '$timestamp' as created,$this->updatedby as createdby,'$timestamp' as updated,$this->updatedby as updatedby,
        ucase(student_name),'$matrix_no' as student_no,student_newicno,student_address,gender,student_postcode,student_state,student_city,
        country_id,student_telno,student_hpno,religion_id,races_id,marital_status,filephoto,fileic,filespm,course_id,student_dob,
        '$temp_password' as temp_password,$year_id as year_id,$session_id as session_id,$defaultorganization_id as organization_id,$id as applicant_id
        from $this->tablestudentonline
        where student_id = $id 
        and (select count(*) from $this->tablestudent where applicant_id = $id) = 0 ";

        $sqlstudent = "insert into $this->tablestudent
        (created,createdby,updated,updatedby,student_name,student_no,student_newicno,student_address,gender,student_postcode,student_state,student_city,
        country_id,student_telno,student_hpno,religion_id,races_id,marital_status,filephoto,fileic,filespm,course_id,student_dob,
        temp_password,year_id,session_id,organization_id,applicant_id)
        $sqlapplicant";

        $querystudent=$this->xoopsDB->query($sqlstudent);

        if(!$querystudent){
        $this->warningtxt = "Failed To Generate Student (Insert Student Record)";
        return false;
        }else{

            //if success move file
            $filephoto = $this->getFileName($id,"filephoto");
            $fileic = $this->getFileName($id,"fileic");
            $filespm = $this->getFileName($id,"filespm");
            copy("$imageonlinepath/$filephoto", "../hes/upload/student/$filephoto");
            copy("$imageonlinepath/$fileic", "../hes/upload/student/$fileic");
            copy("$imageonlinepath/$filespm", "../hes/upload/student/$filespm");
            copy("$imageonlinepath/$fileothers", "../hes/upload/student/$fileothers");
            //end of copy file
            
            $student_newid = $this->getLatestStudentID();

            $sqlspmonline = "select '$timestamp' as created,$this->updatedby as createdby,'$timestamp' as updated,$this->updatedby as updatedby,
            $student_newid as student_id,subjectspm_id,gradelevel_id
            from $this->tablestudentspmonline where student_id = $id ";

            $sqlspm = "insert into $this->tablestudentspm (created,createdby,updated,updatedby,student_id,subjectspm_id,gradelevel_id)
            $sqlspmonline ";

            $queryspm=$this->xoopsDB->query($sqlspm);

            if(!$queryspm){
            $this->warningtxt = "Failed To Generate Student (Insert SPM Record)";
            return false;
            }

            $sql = "update $this->tablestudentonline set
            isstudentcreate = 1,
            matrix_no = '$matrix_no',
            temp_password = '$temp_password'
            where student_id = $id ";

            $this->changesql .= $sql;

            $query=$this->xoopsDB->query($sql);

            if(!$query){

            $this->warningtxt = "Failed To Generate Student (Update Status Applicant)";
            return false;
            }else{

            }

        }

            

        }

        }

        

        
        $this->warningtxt = "Successfully Generated Student";
        return true;

    }

    public function getLatestStudentID(){

        $retval = 1;
        $sql = "select max(student_id) as max_id from $this->tablestudent";

        $query=$this->xoopsDB->query($sql);

        if ($row=$this->xoopsDB->fetchArray($query)){

        $retval = $row['max_id'];
        }

        return $retval;
    }


        public function getViewDetails($student_id){
        global $ctrl;

        include_once '../marketing/setting.php';

        $sql = "select * from $this->tablestudentonline where student_id = $student_id ";

        $query=$this->xoopsDB->query($sql);

        if ($row=$this->xoopsDB->fetchArray($query)){

        $student_name = $row['student_name'];
        $student_newicno = $row['student_newicno'];
        $student_telno = $row['student_telno'];
        $student_hpno = $row['student_hpno'];
        $student_email = $row['student_email'];
        $student_dob = $row['student_dob'];
        $races_id = $row['races_id'];
        $religion_id = $row['religion_id'];
        $gender = $row['gender'];
        $marital_status = $row['marital_status'];
        $student_address = $row['student_address'];
        $student_postcode = $row['student_postcode'];
        $student_city = $row['student_city'];
        $student_state = $row['student_state'];
        $country_id = $row['country_id'];

        $filephoto = $row['filephoto'];
        $fileic = $row['fileic'];
        $filespm = $row['filespm'];
        $fileothers = $row['fileothers'];

        $othersresult_name1 = $row['othersresult_name1'];
        $othersresult_name2 = $row['othersresult_name2'];
        $othersresult_name3 = $row['othersresult_name3'];

        $othersresult_grade1 = $row['othersresult_grade1'];
        $othersresult_grade2 = $row['othersresult_grade2'];
        $othersresult_grade3 = $row['othersresult_grade3'];

        }

        $selectMaritalM = "";
        $selectMaritalS = "";
        if($marital_status=="M")
        $selectMaritalM = "selected";
        else
        $selectMaritalS = "selected";

        $selectGenderF = "";
        $selectGenderM = "";
        if($gender=="F")
        $selectGenderF = "selected";
        else
        $selectGenderM = "selected";

        $countryctrl = $ctrl->getSelectCountry($country_id,"N","country_id","disabled");
        $racesctrl = $ctrl->getSelectRaces($races_id,"N","","races_id"," and races_id = $races_id ");
        $religionctrl = $ctrl->getSelectReligion($religion_id,"N","religion_id",""," and religion_id = $religion_id");


        //$imageonlinepath = "../../../instedtonline/upload/applicantfile";
        $photourl="";
        $icurl="";
        $spmurl="";
        $othersurl="";
        if($filephoto != "")
        $photourl = "$imageonlinepath/$filephoto";
        if($fileic != "")
        $icurl = "$imageonlinepath/$fileic";
        if($filespm != "")
        $spmurl = "$imageonlinepath/$filespm";
        if($fileothers != "")
        $othersurl = "$imageonlinepath/$fileothers";


        if(file_exists($photourl) && $photourl != "")
        $viewphoto="<a href='$photourl' target='blank' id='aa'>View Photo</a>";
        else
        $viewphoto = "<b><font color='red'>No Attachment.</font></b>";

        if(file_exists($icurl) && $icurl != "")
        $viewic="<a href='$icurl' target='blank'>View IC</a>";
        else
        $viewic = "<b><font color='red'>No Attachment.</font></b>";

        if(file_exists($spmurl) && $spmurl != "")
        $viewspm="<a href='$spmurl' target='blank'>View SPM</a>";
        else
        $viewspm = "<b><font color='red'>No Attachment.</font></b>";

        if(file_exists($othersurl) && $othersurl != "")
        $viewothers="<a href='$othersurl' target='blank'>Download</a>";
        else
        $viewothers = "<b><font color='red'>No Attachment.</font></b>";


echo <<< EOF
    <table astyle="width:90%;">

    <tr>
    <th colspan="4">Basic Profile</th>
    </tr>

    <tr>
    <td class="head">Full Name</td>
    <td class="even"><input name="student_name" size="50" maxlength="100" value="$student_name" readonly></td>
    <td class="head">New IC No</td>
    <td class="even">
    <input maxlength="20" size="15" name="student_newicno" value="$student_newicno" readonly>
    </td>


    </tr>

    <tr>
    <td class="head">Tel No</td>
    <td class="even"><input name="student_telno" size="15" maxlength="15" value="$student_telno" readonly></td>
    <td class="head">HP No</td>
    <td class="even"><input name="student_hpno" size="15" maxlength="15" value="$student_hpno" readonly></td>
    </tr>



    <tr>
    <td class="head">Email</td>
    <td class="even"><input name="student_email" size="20" maxlength="50" value="$student_email" readonly></td>
    <td class="head">Date Of Birth</td>
    <td class="even">
    <input name='student_dob' id='student_dob' maxlength='10' size='10' value="$student_dob" readonly>

    </td>
    </tr>

    <tr>
    <td class="head">Races / Religion / Gender</td>
    <td class="even">
    $racesctrl /
    $religionctrl /
    <select name="gender" disabled>
    <option value="M" $selectGenderM>Male</option>
    <option value="F"$selectGenderF>Female</option>
    </select>
    </td>
    <td class="head">Marital Status</td>
    <td class="even">
    <select name="marital_status" disabled>
    <option value="S" $selectMaritalS>Single</option>
    <option value="M" $selectMaritalM>Married</option>
    </select>
    </td>
    </tr>

    <tr>
    <td class="head">Address</td>
    <td class="even" colspan="3"><textarea name="student_address" cols="50" rows="5"  readonly>$student_address</textarea></td>
    </tr>

    <tr>
    <td class="head">Postcode</td>
    <td class="even"><input name="student_postcode" size="10" maxlength="10" value="$student_postcode" readonly></td>
    <td class="head">City</td>
    <td class="even"><input name="student_city" size="20" maxlength="30" value="$student_city" readonly></td>
    </tr>

    <tr>
    <td class="head">State</td>
    <td class="even"><input name="student_state" size="15" maxlength="20" value="$student_state" readonly></td>
    <td class="head">Country</td>
    <td class="even">$countryctrl</td>
    </tr>

    <tr>
    <th colspan="4">Attachment</th>
    </tr>

    <tr>
    <td class="head">Photo</td>
    <td class="even" colspan="3">$viewphoto</td>
    </tr>

    <tr>
    <td class="head">IC</td>
    <td class="even" colspan="3">$viewic</td>
    </tr>

    <tr>
    <td class="head">SPM</td>
    <td class="even" colspan="3">$viewspm</td>
    </tr>

    <tr>
    <td class="head">Others</td>
    <td class="even" colspan="3">$viewothers</td>
    </tr>

    <tr>
    <th colspan="4">SPM Result</th>
    </tr>

    </table>

    <table astyle="width:50%;">


    <tr>
    <th>Subject SPM</th>
    <th>Grade</th>
    </tr>

EOF;

        $sqlspm = "select so.*,sp.subjectspm_name,sl.othersresult_name1,sl.othersresult_name2,sl.othersresult_name3,
        sl.othersresult_grade1,sl.othersresult_grade2,sl.othersresult_grade3
        from $this->tablestudentspmonline so,$this->tablestudentonline sl,
        $this->tablesubjectspm sp
        where so.student_id = $student_id
        and so.student_id = sl.student_id
        and so.subjectspm_id = sp.subjectspm_id ";


        $queryspm=$this->xoopsDB->query($sqlspm);

        $rowtype = "";
        $i=0;
        while ($rowspm=$this->xoopsDB->fetchArray($queryspm)){
        $i++;

        $subjectspm_name = $rowspm['subjectspm_name'];
        $gradelevel_id = $rowspm['gradelevel_id'];
        $studentspm_id = $rowspm['studentspm_id'];


        $gradelevelctrl = $ctrl->getSelectGradelevel($gradelevel_id,'N',"","gradelevel_id[$i]"," and gradelevel_id = $gradelevel_id");

        if($rowtype=="even")
        $rowtype = "odd";
        else
        $rowtype = "even";

echo <<< EOF

        <tr>
        <td class="$rowtype" nowrap>$subjectspm_name</td>
        <td class="$rowtype" align="center">$gradelevelctrl</td>
        </tr>
EOF;
        }

        $gradelevelctrl1 = $ctrl->getSelectGradelevel($othersresult_grade1,'N',"","othersresult_grade1"," and gradelevel_id = $othersresult_grade1");
        $gradelevelctrl2 = $ctrl->getSelectGradelevel($othersresult_grade1,'N',"","othersresult_grade2"," and gradelevel_id = $othersresult_grade1");
        $gradelevelctrl3 = $ctrl->getSelectGradelevel($othersresult_grade1,'N',"","othersresult_grade3"," and gradelevel_id = $othersresult_grade1");
echo <<< EOF
        <tr>
        <td class="$rowtype" nowrap>Others 1 <input name="othersresult_name1" value="$othersresult_name1" readonly></td>
        <td class="$rowtype" align="center">$gradelevelctrl1</td>
        </tr>
        <tr>
        <td class="$rowtype" nowrap>Others 2 <input name="othersresult_name2" value="$othersresult_name2" readonly></td>
        <td class="$rowtype" align="center">$gradelevelctrl2</td>
        </tr>
        <tr>
        <td class="$rowtype" nowrap>Others 3 <input name="othersresult_name3" value="$othersresult_name3" readonly></td>
        <td class="$rowtype" align="center">$gradelevelctrl3</td>
        </tr>



    </table>

EOF;

    }


    public function getFileName($id,$fldname){

        $retval = "";
        $sql = "select $fldname as fldname from $this->tablestudentonline where student_id = $id";

        $query=$this->xoopsDB->query($sql);

        $rowtype = "";
        $i=0;
        while ($row=$this->xoopsDB->fetchArray($query)){
        $retval = $row['fldname'];
        }

        return $retval;
    }

    public function isGroup($group_name){
         $sql = "select u.name, g.name as g_name from sim_users u, sim_groups g, sim_groups_users_link ug where u.uid=ug.uid and g.groupid=ug.groupid and u.uid=$this->createdby;";
         $rs = $this->xoopsDB->query($sql);
         $allow = FALSE;
         //echo "xxx".$allow."XXX";
         while ($row=$this->xoopsDB->fetchArray($rs)){
             //echo $row['g_name']." ".$group_name." ".$allow."|> ";

             if($row['g_name']==$group_name){
                 $allow = TRUE;
             }
         }
         return $allow;
    }

} // end of ClassStudentonline
?>

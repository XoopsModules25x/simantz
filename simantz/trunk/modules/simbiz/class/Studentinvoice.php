<?php


class Studentinvoice
{

  public $studentinvoice_id;
  public $studentinvoice_name;
  public $studentinvoice_no;
  public $studentinvoice_category;
  
  public $course_id;
  public $semester_id;
  public $studentinvoicetype_id;
  public $studentinvoice_crdthrs1;
  public $studentinvoice_crdthrs2;
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
   public function Studentinvoice(){
	global $xoopsDB,$log,$tablestudentinvoice,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport;
    global $tablestudentinvoicetype,$tablesemester,$tablecourse,$tableemployee,$tablestudentinvoicelecturer,$tablestudentinvoicenote;
    global $tablestudentinvoiceline,$tableproduct,$tablestudent,$tablesession,$tableyear;


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
			$this->studentinvoice_name="";
			$this->iscomplete=0;
			$this->defaultlevel=10;
			$studentinvoicechecked="CHECKED";
			$this->studentinvoice_no = getNewCode($this->xoopsDB,"studentinvoice_no",$this->tablestudentinvoice,"");
            $this->studentinvoice_date= getDateSession();

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
		$savectrl="<input name='studentinvoice_id' value='$this->studentinvoice_id' type='hidden'>".
			 "<input astyle='height: 40px;' name='btnSave' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablestudentinvoice' type='hidden'>".
		"<input name='id' value='$this->studentinvoice_id' type='hidden'>".
		"<input name='idname' value='studentinvoice_id' type='hidden'>".
		"<input name='title' value='Studentinvoice' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";


		$header="Edit";
		
		if($this->allowDelete($this->studentinvoice_id))
		$deletectrl="<FORM action='studentinvoice.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this studentinvoice?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->studentinvoice_id' name='studentinvoice_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='studentinvoice.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";

        $previewctrl="<FORM target='_blank' action='viewstudentinvoice.php' method='POST' aonSubmit='return confirm(".
		'"confirm to remove this studentinvoice?"'.")'><input type='submit' value='Preview' name='btnPreview'>".
		"<input type='hidden' value='$this->studentinvoice_id' name='studentinvoice_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
	}

    $searchctrl="<Form action='studentinvoice.php' method='POST'>
                            <input name='btnSearch' value='Search' type='submit'>
                            <input name='action' value='search' type='hidden'>
                            </form>";



  $this->stylecomplete = "style='display:none'";
  $this->styleenable = "style='display:none'";
  $this->stylesave = "style='display:none'";
  $submitform = "onsubmit='return validateStudentinvoice()'";
  if($type == "edit"){
      if($this->iscomplete == 0){
      $this->stylecomplete = "";
      $this->stylesave = "";
      }else{
      $this->styleenable = "";
      $submitform = "onsubmit='return false'";
      }
  }else{
      $this->stylesave = "";
  }

    echo <<< EOF

<table style="width:140px;">
<tbody>
<td>$addnewctrl</td>
<td>$searchctrl</td>
<td><form $submitform method="post"
 action="studentinvoice.php" name="frmStudentinvoice"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>

<input type="hidden" name="deletesubline_id" value="0">
<input type="hidden" name="deletenoteline_idss" value="0">
<input type="hidden" name="iscomplete" value="$this->iscomplete">
<input type="hidden" name="batch_id" value="$this->batch_id">

  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
        <tr>
        <th colspan="4" rowspan="1">$header</th>
        </tr>
        <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even">$this->orgctrl</td>
        <td class="head">Date $mandatorysign</td>
        <td class="even">
        <input name='studentinvoice_date' id='studentinvoice_date' value="$this->studentinvoice_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->invoicedatectrl"> <font color=red>YYYY-MM-DD (Ex: 2009-01-30)</font>
        </td>

        </tr>

        <tr style="display:none">
        <td class="head" style="display:none">Studentinvoice Code $mandatorysign</td>
        <td class="even" style="display:none"></td>
        <td class="head">Studentinvoice Name $mandatorysign</td>
        <td class="even" ><input maxlength="100" size="50" name="studentinvoice_name" value="$this->studentinvoice_name"></td>
        </tr>

        <tr>
        <td class="head">Student</td>
        <td class="even">$this->studentctrl</td>
        <td class="head">Invoice No</td>
        <td class="even"><input maxlength="30" size="15" name="studentinvoice_no" value="$this->studentinvoice_no"></td>
        </tr>

        <tr>
        <td class="head">Session</td>
        <td class="even">$this->yearctrl / $this->sessionctrl</td>
        <td class="head">Semester</td>
        <td class="even">$this->semesterctrl</td>
        </tr>

        <tr>
        <td class="head">Description</td>
        <td class="even" colspan='3'><textarea name="description" cols="60" rows="10">$this->description</textarea></td>
        </tr>
 
    </tbody>
  </table>
EOF;
    if ($type!="new"){
    $this->getAlertTable($this->student_id);
    $this->getSubTable($this->studentinvoice_id);
    }else{
     
    }

echo <<< EOF

<br>
<table astyle="width:150px;"><tbody><td width=1 $this->stylesave>$savectrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form>
    <td width=1>
    <input type="button" value="Complete" onclick="invoiceComplete()" $this->stylecomplete>
    <input type="button" value="Re-Enable" onclick="invoiceEnable()" $this->styleenable>
    </td>
    <td >$previewctrl</td>
    <td align="right" $this->stylesave>$deletectrl</td>
    </tbody></table>
  <br>

$recordctrl

EOF;
  } // end of member function getInputForm

  public function getAlertTable($student_id){

    $sql = "select *
    from $this->tablestudentinvoiceline sl
    where student_id=$student_id and studentinvoice_id = 0 ";

    $sqlnt = "select count(*) as tot_row
    from $this->tablestudentinvoiceline sl
    where student_id=$student_id and studentinvoice_id = 0 ";

    $this->log->showLog(4,"getAlertTable :" . $sql . "<br>");

    $query=$this->xoopsDB->query($sql);
    $querycnt=$this->xoopsDB->query($sqlnt);

    $tot_row = 0;
    if($rowcnt=$this->xoopsDB->fetchArray($querycnt)){
    $tot_row = $rowcnt['tot_row'];
    }

    $stylenew = "style='display:none'";
    if($tot_row >0){
    $stylenew = "";
    }else{
    $tot_row = "";
    }

echo <<< EOF
    <table>
    <tr>
    <td align="right">
    <font color=red $this->stylesave><b>$tot_row</b></font>
    <img src="images/new.gif" $stylenew $this->stylesave>
    <a $stylenew $this->stylesave title="Click Here View Remaining Item For This Student" style="cursor:pointer" onclick="viewRemaining()">View Remaining Item >></a>
    </td>
    </tr>
    </table>

    <table id="tblRemaining" style="display:none">
    <tr>
    <th colspan="5">Remaining Item (Not Yet Add To Invoice)</th>
    </tr>
    <tr>
    <th align="center" width=1></th>
    <th align="center">No</th>
    <th align="center">Item</th>
    <th align="center">Remarks</th>
    <th align="center">Amount (RM)</th>
    </tr>

EOF;

        $totalamt = 0;
        $rowtype="";
        $i=0;
        while($row=$this->xoopsDB->fetchArray($query)){
            $i++;
            $studentinvoiceline_id = $row['studentinvoiceline_id'];
            $studentinvoice_item = $row['studentinvoice_item'];
            $studentinvoice_lineamt = $row['studentinvoice_lineamt'];
            $line_desc = $row['line_desc'];

            $totalamt += $studentinvoice_lineamt;
            $line_desc = str_replace( array("\r\n", "\n","\r"), "<br/>", $line_desc );
            $line_desc = str_replace( " ", "&nbsp;", $line_desc );

            if($rowtype=="even")
            $rowtype = "odd";
            else
            $rowtype = "even";


echo <<< EOF
        <input type="hidden" name="studentinvoiceline_idremain[$i]" value="$studentinvoiceline_id">
        <tr>
        <td class="$rowtype" align="center"><input type="checkbox" name="isselectremain[$i]"></td>
        <td class="$rowtype" align="center">$i</td>
        <td class="$rowtype" align="left">$studentinvoice_item</td>
        <td class="$rowtype" align="left">$line_desc</td>
        <td class="$rowtype" align="right">$studentinvoice_lineamt</td>
        </tr>
EOF;
            
        }

        $totalamt = number_format($totalamt,2);
    if($i > 0){
echo <<< EOF
        <tr>
        <td class="head" align="right" colspan="4">Total (RM)</td>
        <td class="head" align="right">$totalamt</td>
        </tr>

    <tr height="40">
    <td colspan="3">&nbsp;&nbsp;<img src="images/arrowsel.png">
    <a style="cursor:pointer" onclick="selectAll(true);">Check All</a> /
    <a style="cursor:pointer" onclick="selectAll(false);">Uncheck All</a>

    <i>(Add To Invoice With Selected Line)</i></td>
    <td colspan="2" align="right">&nbsp;&nbsp;<b><font color=red>Total Item : $i</font><b></td>
    </tr>

    <tr height="40">
    <td colspan="5" align="left"><input type="button" value="Add To Invoice" onclick="AddToInvoice()"></td>
    </tr>

EOF;
    }
echo <<<EOF
    </table>
EOF;
  }

   public function getSubTable($studentinvoice_id){
        global $ctrl;
        $widthsubstudentinvoice = "style = 'width:200px' ";

        $sql = "select * from $this->tablestudentinvoiceline
                    where studentinvoice_id = $studentinvoice_id ";

        $this->log->showLog(4,"getLecturerTable :" . $sql . "<br>");

        $query=$this->xoopsDB->query($sql);

        //$productctrl = $ctrl->getSelectProduct(0,'Y',"","addsubstudentinvoice_id","",'addsubstudentinvoice_id',$widthsubstudentinvoice,'Y',0);

echo <<< EOF


        <br>
        <table id="tblSub" astyle="background-color:yellow">

        <tr>
        <td colspan="8" align="left">
        <table>
        <tr>
        <td width="1px" nowrap></td>
        <td nowrap> $studentinvoicectrl</td>
        <!--<td align="right"><a>Hide Lecturer >></a></td>-->
        </tr>
        </table>
        </td>
        </tr>

        <tr>
        <th align="left" colspan="4">List Of Item</th>
        <th align="right" colspan="4"><input $this->stylesave type="button" name="addSub" value="Add Item" onclick="checkAddSelect()"></th>

        </tr>
        </tr>
        <tr>
        <th align="center">No</th>
        <th align="center">Item</th>
        <th align="center">Account</th>
        <th align="center">Unit Price</th>
        <th align="center">Qty</th>
        <th align="center">Amount (RM)</th>
        <th align="center">Delete</th>
        </tr>
        <input type="hidden" name="addstudentinvoice_id" value="0">
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

        $studentinvoiceline_id = $row['studentinvoiceline_id'];
        $product_id = $row['product_id'];
        $studentinvoice_item = $row['studentinvoice_item'];
        $studentinvoice_qty= $row['studentinvoice_qty'];
        $studentinvoice_uprice= $row['studentinvoice_uprice'];
        $studentinvoice_lineamt = $row['studentinvoice_lineamt'];
        $accounts_id = $row['accounts_id'];
        $line_desc = $row['line_desc'];

        $productctrlline = $ctrl->getSelectProduct($product_id,'Y',"onchange=getProductInfo(this.value,$i);","product_id[$i]","","product_id$i","style='width:180px'",'Y',$i);
        $accountstctrlline = $ctrl->getSelectAccounts($accounts_id,'Y',"","accounts_id[$i]","","N","N","N","accounts_id$i","style='width:180px'");

        $styleremarks = "style='display:none'";
        if($line_desc != "")
        $styleremarks= "";

echo <<< EOF
        <tr height="3">
        <td></td>
        </tr>
        <tr>
        <input type="hidden" name="studentinvoiceline_id[$i]" value="$studentinvoiceline_id">
        <td class="$rowtype" align="center">$i</td>
        <td class="$rowtype" align="left" nowrap>
        <input id = "studentinvoice_item$i" name="studentinvoice_item[$i]" value="$studentinvoice_item" size="24" maxlength="100"> <a title="Add By Product" style="cursor:pointer" onclick="viewProduct($i)"> >> </a><br>
        <div id="idProductCtrl$i" style="display:none">$productctrlline</div></td>
        <td class="$rowtype" align="center" style="display:none">
        <select name="studentinvoiceline_type[$i]">
        <option value="" $selecttypeN></option>
        <option value="I" $selecttypeI>Yuran Awal</option>
        <option value="R" $selecttypeR>Yuran Berulang</option>
        <option value="S" $selecttypeS>Yuran Bermusim</option>
        </select>
        <td class="$rowtype" align="left" nowrap>$accountstctrlline</td>
        </td>
        <td class="$rowtype" align="center"><input  id = "studentinvoice_uprice$i" style="text-align:right" name="studentinvoice_uprice[$i]" value="$studentinvoice_uprice" size="8" maxlength="12" onfocus="select()" onblur="updateAmount($i)"></td>
        <td class="$rowtype" align="center"><input id = "studentinvoice_qty$i" name="studentinvoice_qty[$i]" value="$studentinvoice_qty" size="3" maxlength="10" onfocus="select()" onblur="updateAmount($i)"></td>
        <td class="$rowtype" align="center"><input id = "studentinvoice_lineamt$i" style="text-align:right" name="studentinvoice_lineamt[$i]" value="$studentinvoice_lineamt" size="8" maxlength="12" onfocus="select()"></td>
        <td class="$rowtype" align="center"><input $this->stylesave type="button" name="btnDeleteLect" value="x" onclick="deleteSubLine($studentinvoiceline_id,$i)"></td>
        </tr>

        <tr>
        <td colspan="8" class="$rowtype">
        <a style="cursor:pointer" onclick="viewRemarkLine($i)">View/Hide Remarks</a>
        <br><textarea name="line_desc[$i]" size="40" maxlength="255" id="idLineDesc$i" $styleremarks>$line_desc</textarea></td>
        </tr>

EOF;
        }

        if($i==0)
        echo "<tr><td colspan='9' class='odd'><font color='red'>Please Define Item Invoice.</red></td></tr>";
        
        echo "<tr><td colspan='5' class='head' align='right'>Total</td>";
        echo "<td colspan='1' class='head' align='center'><input readonly name='total_amt' style='text-align:right' value='$this->total_amt' size='10' maxlength='11'></td>";
        echo "<td colspan='1' class='head' align='right'></td></tr>";
        
echo <<< EOF
        </table>
EOF;

  }

  /**
   * Update existing studentinvoice record
   *
   * @return bool
   * @access public
   */
  public function updateStudentinvoice( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablestudentinvoice SET
	studentinvoice_date='$this->studentinvoice_date',description='$this->description',studentinvoice_no='$this->studentinvoice_no',
	updated='$timestamp',updatedby=$this->updatedby,iscomplete='$this->iscomplete',
    student_id=$this->student_id,session_id=$this->session_id,year_id=$this->year_id,semester_id=$this->semester_id,
    total_amt=$this->total_amt,
	organization_id=$this->organization_id WHERE studentinvoice_id='$this->studentinvoice_id'";
	$this->changesql = $sql;
	$this->log->showLog(3, "Update studentinvoice_id: $this->studentinvoice_id, $this->studentinvoice_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update studentinvoice failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update studentinvoice successfully.");
		return true;
	}
  } // end of member function updateStudentinvoice

  /**
   * Save new studentinvoice into database
   *
   * @return bool
   * @access public
   */
  public function insertStudentinvoice( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new studentinvoice $this->studentinvoice_name");
 	$sql="INSERT INTO $this->tablestudentinvoice
    (studentinvoice_date,studentinvoice_no,
    iscomplete, created,createdby,updated,updatedby,
    student_id,session_id,year_id,semester_id,
    organization_id,description)
    values(
	'$this->studentinvoice_date','$this->studentinvoice_no','$this->iscomplete',
    '$timestamp',$this->createdby,'$timestamp',$this->updatedby,
    $this->student_id,$this->session_id,$this->year_id,$this->semester_id,
    $this->organization_id,'$this->description')";
$this->changesql = $sql;
	$this->log->showLog(4,"Before insert studentinvoice SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert studentinvoice code $studentinvoice_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new studentinvoice $studentinvoice_name successfully");
		return true;
	}
  } // end of member function insertStudentinvoice

  /**
   * Pull data from studentinvoice table into class
   *
   * @return bool
   * @access public
   */
  public function fetchStudentinvoice( $studentinvoice_id) {


	$this->log->showLog(3,"Fetching studentinvoice detail into class Studentinvoice.php.<br>");
		
	$sql="SELECT *
		 from $this->tablestudentinvoice where studentinvoice_id=$studentinvoice_id";
	
	$this->log->showLog(4,"ProductStudentinvoice->fetchStudentinvoice, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
        $this->studentinvoice_date=$row["studentinvoice_date"];
        $this->studentinvoice_no=$row["studentinvoice_no"];
        $this->organization_id=$row['organization_id'];
        $this->student_id= $row['student_id'];
        $this->session_id= $row['session_id'];
        $this->year_id= $row['year_id'];
        $this->iscomplete=$row['iscomplete'];
        $this->description=$row['description'];
        $this->semester_id=$row['semester_id'];
        $this->total_amt=$row['total_amt'];
        $this->batch_id=$row['batch_id'];
        $this->batch_no=$row['batch_no'];
        $this->generatestudentinvoice_id=$row['generatestudentinvoice_id'];


   	$this->log->showLog(4,"Studentinvoice->fetchStudentinvoice,database fetch into class successfully");
	$this->log->showLog(4,"studentinvoice_name:$this->studentinvoice_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Studentinvoice->fetchStudentinvoice,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchStudentinvoice

  /**
   * Delete particular studentinvoice id
   *
   * @param int studentinvoice_id
   * @return bool
   * @access public
   */
  public function deleteStudentinvoice( $studentinvoice_id ) {
    	$this->log->showLog(2,"Warning: Performing delete studentinvoice id : $studentinvoice_id !");
	$sql="DELETE FROM $this->tablestudentinvoice where studentinvoice_id=$studentinvoice_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->changesql = $sql;
    $this->deleteAllLine($studentinvoice_id);
    
    
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: studentinvoice ($studentinvoice_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"studentinvoice ($studentinvoice_id) removed from database successfully!");

		return true;
		
	}
  } // end of member function deleteStudentinvoice

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllStudentinvoice( $wherestring,  $orderbystring,$limitstr="") {
  $this->log->showLog(4,"Running ProductStudentinvoice->getSQLStr_AllStudentinvoice: $sql");

    //$wherestring .= " and si.applicant_id = 0 ";
    
    $sql="select si.*,st.student_name,st.student_no,cr.course_name,cr.course_no,
    sm.semester_name,yr.year_name,ss.session_name
    from $this->tablestudentinvoice si
    inner join $this->tablestudent st on st.student_id = si.student_id
    inner join $this->tablesemester sm on sm.semester_id = si.semester_id
    inner join $this->tablesession ss on ss.session_id = si.session_id
    inner join $this->tableyear yr on yr.year_id = si.year_id
    inner join $this->tablecourse cr on cr.course_id = st.course_id 
    $wherestring $orderbystring $limitstr";
    $this->log->showLog(4,"Generate showstudentinvoicetable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllStudentinvoice

 public function showStudentinvoiceTable($wherestring,$orderbystring,$limitstr=""){
	
	$this->log->showLog(3,"Showing Studentinvoice Table");
	$sql=$this->getSQLStr_AllStudentinvoice($wherestring,$orderbystring,$limitstr);
	
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
				<th style="text-align:center;">Invoice No</th>
				<th style="text-align:center;">Student</th>
				<th style="text-align:center;">Matrix No</th>
				<th style="text-align:center;">Course</th>
				<th style="text-align:center;">Semester</th>
				<th style="text-align:center;">Session</th>
				<th style="text-align:center;">Amount (RM)</th>
				<th style="text-align:center;">Complete</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;

        $student_id=$row['student_id'];
        $studentinvoice_id=$row['studentinvoice_id'];
        $studentinvoice_no=$row['studentinvoice_no'];
        $student_name=$row['student_name'];
        $student_no=$row['student_no'];
        $course_name=$row['course_name'];
        $course_no=$row['course_no'];
        $semester_name=$row['semester_name'];
        $year_name=$row['year_name'];
        $session_name=$row['session_name'];
        $total_amt=$row['total_amt'];
        
        $credit_hrs = "$studentinvoice_crdthrs1 + $studentinvoice_crdthrs2";

		$iscomplete=$row['iscomplete'];
		
		if($iscomplete==0)
		{$iscomplete='N';
		$iscomplete="<b style='color:red;'>N</b>";
		}
		else
		$iscomplete='Y';

       
   if($studentinvoice_category=="S")
   $studentinvoice_category = "Studentinvoice";
   else
    $studentinvoice_category = "Co Curriculum";


		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

            
		echo <<< EOF
        
		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$studentinvoice_no</td>
			<td class="$rowtype" style="text-align:left;"><a target="blank" href="../hes/student.php?action=edit&student_id=$student_id">$student_name</a></td>
			<td class="$rowtype" style="text-align:center;">$student_no</td>
			<td class="$rowtype" style="text-align:center;">$course_no</td>
			<td class="$rowtype" style="text-align:center;" nowrap>$semester_name</td>
			<td class="$rowtype" style="text-align:center;" nowrap>$year_name / $session_name</td>
			<td class="$rowtype" style="text-align:center;">$total_amt</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
                <table><tr><td>
				<form action="studentinvoice.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this studentinvoice'>
				<input type="hidden" value="$studentinvoice_id" name="studentinvoice_id">
				<input type="hidden" name="action" value="edit">
				</form>
                </td>
                <td>
                <img src="images/list.gif" title="Preview Invoice" style="cursor:pointer" onclick="viewStudentInvoice($studentinvoice_id)">
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
  public function getLatestStudentinvoiceID() {
	$sql="SELECT MAX(studentinvoice_id) as studentinvoice_id from $this->tablestudentinvoice;";
	$this->log->showLog(3,'Checking latest created studentinvoice_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created studentinvoice_id:' . $row['studentinvoice_id']);
		return $row['studentinvoice_id'];
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
	$sql = "select count(*) as rowcount from $this->tabledailyreport where studentinvoice_id = $studentinvoice_id or last_studentinvoice = $studentinvoice_id or next_studentinvoice = $studentinvoice_id ";
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
	$this->studentinvoice_category = "";
	}

	//iscomplete
    
	if($this->iscomplete == "1")
	$selectactiveY = "selected = 'selected'";
	else if($this->iscomplete == "0")
	$selectactiveN = "selected = 'selected'";
	else
	$selectactiveL = "selected = 'selected'";

    $selectS="";
    $selectQ="";
    $selectP="";
    $selectL="";
    $selectN="";
   if($this->studentinvoice_category=="S")
   $selectS = "SELECTED";
   else if($this->studentinvoice_category=="Q")
   $selectQ = "SELECTED";
   else if($this->studentinvoice_category=="P")
   $selectP = "SELECTED";
   else if($this->studentinvoice_category=="L")
   $selectL = "SELECTED";
   else
	$selectN = "SELECTED";

	//echo $this->iscomplete;

echo <<< EOF
<form name="frmStudentinvoice" action="studentinvoice.php" method="POST">
	</form>
	<form name="frmSearch" action="studentinvoice.php" method="POST">

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
	<td class="head">Invoice No</td>
	<td class="even" acolspan="3"><input name="studentinvoice_no" value="$this->studentinvoice_no"></td>
	<td class="head">Student</td>
	<td class="even">$this->studentctrl</td>
	</tr>

	<tr>
	<td class="head">Student Name</td>
	<td class="even"><input name="student_name" value="$this->student_name"></td>
	<td class="head">Matrix No</td>
	<td class="even"><input name="student_no" value="$this->student_no"></td>
	</tr>

	<tr>
	<td class="head">Session</td>
	<td class="even">$this->yearctrl / $this->sessionctrl</td>
	<td class="head">Semester</td>
	<td class="even">$this->semesterctrl</td>
	</tr>

    <tr>
    <td class="head">Course</td>
    <td class="even" colspan="3">$this->coursectrl</td>
    </tr>


	<tr astyle="display:none">
	
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


	if($this->studentinvoice_no != "")
	$wherestr .= " and si.studentinvoice_no like '$this->studentinvoice_no' ";
    if($this->student_id > 0)
	$wherestr .= " and st.student_id = $this->student_id ";
    if($this->student_name != "")
	$wherestr .= " and st.student_name like '$this->student_name' ";
    if($this->student_no != "")
	$wherestr .= " and st.student_no like '$this->student_no' ";
    if($this->course_id > 0)
	$wherestr .= " and st.course_id = $this->course_id ";
	if($this->year_id > 0)
	$wherestr .= " and si.year_id = $this->year_id ";
	if($this->session_id > 0)
	$wherestr .= " and si.session_id = $this->session_id ";
	if($this->semester_id > 0)
	$wherestr .= " and si.semester_id = $this->semester_id ";
    
	if($this->iscomplete == "0" || $this->iscomplete == "1")
	$wherestr .= " and si.iscomplete = $this->iscomplete ";


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
        $sql = " insert into $this->tablestudentinvoiceline (studentinvoice_id,studentinvoice_qty,created,createdby,updated,updatedby)
        values ($studentinvoice_id,1,'$timestamp',$this->updatedby,'$timestamp',$this->updatedby) ";
        $this->changesql = $sql;
        
        $this->log->showLog(4,"Before insert studentinvoice addSubLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        return true;
    }

    public function updateSubLine(){
        $timestamp= date("y/m/d H:i:s", time()) ;
        $i=0;
        foreach($this->studentinvoiceline_id as $id){
        $i++;

        $studentinvoice_item=$this->studentinvoice_item[$i];
        $product_id=$this->product_id[$i];
        $accounts_id=$this->accounts_id[$i];
        $studentinvoiceline_no=$this->studentinvoiceline_no[$i];
        $line_desc=$this->line_desc[$i];
        $studentinvoice_uprice=$this->studentinvoice_uprice[$i];
        $studentinvoice_qty=$this->studentinvoice_qty[$i];
        $studentinvoice_lineamt=$this->studentinvoice_lineamt[$i];


        $sql = "update $this->tablestudentinvoiceline
        set studentinvoice_item = '$studentinvoice_item',
        product_id = $product_id,
        accounts_id = $accounts_id,
        studentinvoiceline_no = '$studentinvoiceline_no',
        line_desc = '$line_desc',
        studentinvoice_uprice = $studentinvoice_uprice,
        studentinvoice_qty = $studentinvoice_qty,
        studentinvoice_lineamt = $studentinvoice_lineamt
        where studentinvoiceline_id = $id ";

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert studentinvoice updateLecturerLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        }

        return true;
    }

    public function deleteSubLine($studentinvoiceline_id){

        $sql = "delete from $this->tablestudentinvoiceline where studentinvoiceline_id = $studentinvoiceline_id";

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert studentinvoice deleteSubLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }else
        return true;
        
    }

    public function addNoteLine($studentinvoice_id){

        $sql = " insert into $this->tablestudentinvoicenote (studentinvoice_id) values ($studentinvoice_id) ";
        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert studentinvoice addNoteLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        return true;
    }

    public function updateNoteLine(){

        $i=0;
        foreach($this->studentinvoicenoteline_id as $id){
        $i++;

        $studentinvoicenote_title = $this->studentinvoicenote_title[$i];
        $studentinvoicenote_description = $this->studentinvoicenote_description[$i];
        $isdownload = $this->isdownload[$i];
        $isdeleteline = $this->isdeleteline[$i];

        if($isdownload == "on")
        $isdownload = 1;
        else
        $isdownload = 0;

        if($isdeleteline == "on"){
        $this->deleteNoteLine($id);
        }else{
        $sql = "update $this->tablestudentinvoicenote
                    set studentinvoicenote_title = '$studentinvoicenote_title',
                    studentinvoicenote_description = '$studentinvoicenote_description',
                    isdownload = '$isdownload' 
                    where studentinvoicenoteline_id = $id ";
        

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert studentinvoice updateNoteLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }
        
        $this->saveAtt($this->atttmpfile[$i],$this->attfilesize[$i],$this->attfiletype[$i],$this->attfilename[$i],$id);
        }

        }

        return true;
    }

    public function deleteNoteLine($studentinvoicenoteline_id){

        $sql = "delete from $this->tablestudentinvoicenote where studentinvoicenoteline_id = $studentinvoicenoteline_id";

        $this->changesql = $sql;
        $this->deletefile($studentinvoicenoteline_id);
        
        $this->log->showLog(4,"Before insert studentinvoice deleteNoteLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }else{
            
            return true;
        }

    }

    public function saveAtt($atttmpfile,$attfilesize,$attfiletype,$attfilename,$studentinvoicenoteline_id){
	//$file_ext = "jpg";


	$file_ext = strrchr($attfilename, '.');

	$attfilesize = $attfilesize / 1024;
	//&& $attfilesize<300
	if($attfilesize>0 ){
	$newfilename = $studentinvoicenoteline_id."$file_ext";
	$this->savefile($atttmpfile,$newfilename,$studentinvoicenoteline_id);
	}


	}

    public function savefile($tmpfile,$newfilename,$studentinvoicenoteline_id){

        if(move_uploaded_file($tmpfile, "upload/studentinvoice/$newfilename")){
        $sqlupdate="UPDATE $this->tablestudentinvoicenote set filenote='$newfilename' where studentinvoicenoteline_id=$studentinvoicenoteline_id";
        $qryUpdate=$this->xoopsDB->query($sqlupdate);
        }else{
        echo "Cannot Upload File";
        }
    }

	public function deletefile($studentinvoicenoteline_id){
		$sql="SELECT filenote from $this->tablestudentinvoicenote where studentinvoicenoteline_id=$studentinvoicenoteline_id";
		$query=$this->xoopsDB->query($sql);
		$myfilename="";
		if($row=$this->xoopsDB->fetchArray($query)){
			$myfilename=$row['filenote'];
		}
		$myfilename="upload/studentinvoice/$myfilename";
		$this->log->showLog(3,"This file name: $myfilename");
		unlink("$myfilename");
		$sqlupdate="UPDATE $this->tablestudentinvoicenote set filenote='' where studentinvoicenoteline_id=$studentinvoicenoteline_id";
		$qryDelete=$this->xoopsDB->query($sqlupdate);
	}

    public function deleteAllLine($studentinvoice_id){

	$sqlselect = "select * from $this->tablestudentinvoicenote where studentinvoice_id = $studentinvoice_id and filenote <> '' ";

	$queryselect=$this->xoopsDB->query($sqlselect);

	while($rowselect=$this->xoopsDB->fetchArray($queryselect)){

	$studentinvoicenoteline_id = $rowselect['studentinvoicenoteline_id'];
	$myfilename = $rowselect['filenote'];

	$myfilename = "upload/studentinvoice/$myfilename";
	unlink("$myfilename");

	//$this->deletefile($studentinvoiceline_id);
	}
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
       foreach($this->studentinvoiceline_idremain as $studentinvoiceline_id){
       $i++;

            if($this->isselectremain[$i] == "on"){
                $sql = "update $this->tablestudentinvoiceline set studentinvoice_id = $this->studentinvoice_id
                where studentinvoiceline_id = $studentinvoiceline_id ;";

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
                    total_amt = (select sum(studentinvoice_lineamt) from $this->tablestudentinvoiceline
                    where studentinvoice_id = $studentinvoice_id )
                    where studentinvoice_id = $studentinvoice_id ";
        
        $query=$this->xoopsDB->query($sql);
        if(!$query){
        return false;
        }else{
        return false;
        }
    }

    public function batchAPIInvoice($studentinvoice_id){
	global $defaultcurrency_id,$student_account,$student_bpartner;
	/*$api->PostBatch($uid,$date,$systemname,$batch_name,$description,$totaltransactionamt,$documentnoarray,
	$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,$transtypearray,$linetypearray,
	$chequenoarray);*/

	 $sql = "select si.*,sl.accounts_id,sum(studentinvoice_lineamt) as sum_accounts,
                sl.line_desc,st.student_name,st.student_no
                from $this->tablestudentinvoice si
                inner join $this->tablestudentinvoiceline sl on sl.studentinvoice_id = si.studentinvoice_id
                inner join $this->tablestudent st on st.student_id = si.student_id
                where si.studentinvoice_id = $studentinvoice_id
                group by sl.accounts_id 
                order by sl.accounts_id ";

	$this->log->showLog(4,"SQL API: $sql");
	$query=$this->xoopsDB->query($sql);
	$return_false = 0;
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){

	//header list
	$date = $row["studentinvoice_date"];
	$systemname = "Finance";
	$batch_name = "Student Invoice Batch"." (".$row["student_no"].")";
	//$description = $row["descriptions"];
    $description = $row["student_name"]." (".$row["student_no"].")";
	$totaltransactionamt = $row["total_amt"];

	if($i == 0){//line type = 0
	$documentnoarray[$i]  = $row["studentinvoice_no"];
	$accountsarray[$i] = $student_account;
	$amtarray[$i] = $row["total_amt"];
	//$currencyarray[$i] = $row["currency_id"];
	//$conversionarray[$i] = $row["exchangerate"];
    $currencyarray[$i] = 0;
    $conversionarray[$i] = 1;
	$originalamtarray[$i] = $row["total_amt"];
	$bpartnerarray[$i] = $student_bpartner;
	$transtypearray[$i] = "IV";//IV = invoice, CQ = Cheque, CN = Credit Note, DN = Debit Note, GN = General
	$linetypearray[$i] = 0;
	$chequenoarray[$i]="";
	$i++;

	if($row["accounts_id"] == 0)//if '0' return false
	$return_false = 1;
	}

	//line type = 1
	$documentnoarray[$i]  = $row["studentinvoice_no"];
	$accountsarray[$i] = $row["accounts_id"];
	$amtarray[$i] = $row["sum_accounts"]*-1;
	//$currencyarray[$i] = $row["currency_id"];
	//$conversionarray[$i] = $row["exchangerate"];
    $currencyarray[$i] = 0;
    $conversionarray[$i] = 1;
	$originalamtarray[$i] = $row["sum_accounts"]*-1;
	$bpartnerarray[$i] = 0;
	$transtypearray[$i] = "IV";//IV = invoice, CQ = Cheque, CN = Credit Note, DN = Debit Note, GN = General
	$linetypearray[$i] = 1;
	$chequenoarray[$i]="";
	$i++;

	if($student_account == 0)//if '0' return false
	$return_false = 1;
	}

	return array($date,$systemname,$batch_name,$description,$totaltransactionamt,$documentnoarray,
	$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,$transtypearray,$linetypearray,
	$chequenoarray,$return_false);

	}

	public function updateBatchInfoInvoice($fld,$batch_info,$studentinvoice_id){

	if($batch_info != ""){
	$sql = "update $this->tablestudentinvoice set $fld = $batch_info
		where studentinvoice_id = $studentinvoice_id";
	}else{
	$sql = "update $this->tablestudentinvoice set batch_id = 0, batch_no = ''
		where studentinvoice_id = $studentinvoice_id";
	}

	$this->log->showLog(4, "SQL get View More");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
	$this->log->showLog(2, "Warning! update batch info failed ($fld):".mysql_error(). ":$sql");
	return false;
	}

	}

    public function updateComplete($iscomplete,$studentinvoice_id){
        $sql = "update $this->tablestudentinvoice set iscomplete = $iscomplete where studentinvoice_id = $studentinvoice_id ";

        $this->log->showLog(4, "SQL updateComplete");

        $rs=$this->xoopsDB->query($sql);
        if(!$rs){
        $this->log->showLog(2, "Warning! update complete status ($fld):".mysql_error(). ":$sql");
        return false;
        }
    }

   public function reactivateStudentInvoice($studentinvoice_id){

	$sql="UPDATE $this->tablestudentinvoice set iscomplete=0 where studentinvoice_id=$studentinvoice_id";
	$this->log->showLog(4,"Update reactivateStudentInvoice with SQL Statement: $sql");

	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: salesinvoice ($salesinvoice_id) cannot reactive" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"salesinvoice ($salesinvoice_id) reactivated successfully!");
		return true;

	}

	}

    public function completeSetInvoice($generatestudentinvoice_id,$iscomplete,$api,$xoopsUser){

            if($iscomplete == "true")
            $completeval = 0;
            else
            $completeval = 1;

            echo $sql = "select * from $this->tablestudentinvoice
            where generatestudentinvoice_id = $generatestudentinvoice_id
            and iscomplete = $completeval ";

            $this->log->showLog(4,"SQL publishSetInvoice: $sql");
            $query=$this->xoopsDB->query($sql);
            $return_false = 0;
            $linefalse = 0;
            
            $i=0;
            while($row=$this->xoopsDB->fetchArray($query)){

           $studentinvoice_id = $row['studentinvoice_id'];
           $batch_id = $row['batch_id'];
           
            if($iscomplete == "true"){

        
                    //start posting to simbiz
                    $listAPI = $this->batchAPIInvoice($studentinvoice_id);
                    $uid = $xoopsUser->getVar('uid');

                    $return_true = false;
                    if($listAPI[15] == 0){//if all accounts > 0
                    $return_true =
                    $api->PostBatch($uid,$listAPI[0],$listAPI[1],$listAPI[2],$listAPI[3],$listAPI[4],$listAPI[5],
                    $listAPI[6],$listAPI[7],$listAPI[8],$listAPI[9],$listAPI[10],$listAPI[11],$listAPI[12],$listAPI[13],
                    $listAPI[14]);
                    $linefalse = 1;
                    }

                    if($return_true){

                    $this->updateComplete(1,$studentinvoice_id);
                    $this->updateBatchInfoInvoice("batch_id",$api->resultbatch_id,$studentinvoice_id);
                    $this->updateBatchInfoInvoice("batch_no",$api->resultbatch_no,$studentinvoice_id);
                    //return true;
                    }else{
                    $this->updateComplete(0,$studentinvoice_id);
                    $this->txtwarning = "Please Check All Account.";
                    //return false;
                    }
                    //end of posting to simbiz
                    
            }else{

                	// simbiz AccountsAPI function here
                    $api->reverseBatch($batch_id);
                    if($batch_id > 0){
                    $this->updateBatchInfoInvoice("batch_id",0,$studentinvoice_id);
                    $this->updateBatchInfoInvoice("batch_no","",$studentinvoice_id);
                    }
                    $this->updateComplete(0,$studentinvoice_id);
                    // end of simbiz AccountsAPI function
            }

            }

            

    }


} // end of ClassStudentinvoice
?>

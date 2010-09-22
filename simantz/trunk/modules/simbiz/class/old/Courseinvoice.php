<?php


class Courseinvoice
{

  public $courseinvoice_id;
  public $courseinvoice_name;
  public $courseinvoice_no;
  public $courseinvoice_category;
  
  public $course_id;
  public $semester_id;
  public $courseinvoicetype_id;
  public $courseinvoice_crdthrs1;
  public $courseinvoice_crdthrs2;
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
  private $tablecourseinvoice;
  private $tablebpartner;

  private $log;


//constructor
   public function Courseinvoice(){
	global $xoopsDB,$log,$tablecourseinvoice,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport;
    global $tablecourseinvoicetype,$tablesemester,$tablecourse,$tableemployee,$tablecourseinvoicelecturer,$tablecourseinvoicenote;
    global $tablecourseinvoiceline,$tableproduct;
    
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablecourseinvoice=$tablecourseinvoice;
    $this->tablecourseinvoicetype=$tablecourseinvoicetype;
    $this->tablesemester=$tablesemester;
    $this->tablecourse=$tablecourse;
	$this->tablebpartner=$tablebpartner;
    $this->tableemployee=$tableemployee;
    $this->tablecourseinvoicelecturer=$tablecourseinvoicelecturer;
    $this->tablecourseinvoicenote=$tablecourseinvoicenote;
    $this->tablecourseinvoiceline=$tablecourseinvoiceline;
    $this->tableproduct=$tableproduct;
	
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int courseinvoice_id
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $courseinvoice_id,$token  ) {
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
	 	
		if($courseinvoice_id==0){
			$this->courseinvoice_name="";
			$this->isactive="";
			$this->defaultlevel=10;
			$courseinvoicechecked="CHECKED";
			$this->courseinvoice_no = getNewCode($this->xoopsDB,"courseinvoice_no",$this->tablecourseinvoice,"");

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
		$savectrl="<input name='courseinvoice_id' value='$this->courseinvoice_id' type='hidden'>".
			 "<input astyle='height: 40px;' name='btnSave' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablecourseinvoice' type='hidden'>".
		"<input name='id' value='$this->courseinvoice_id' type='hidden'>".
		"<input name='idname' value='courseinvoice_id' type='hidden'>".
		"<input name='title' value='Courseinvoice' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";


		$header="Edit";
		
		if($this->allowDelete($this->courseinvoice_id))
		$deletectrl="<FORM action='courseinvoice.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this courseinvoice?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->courseinvoice_id' name='courseinvoice_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='courseinvoice.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";
	}

    $searchctrl="<Form action='courseinvoice.php' method='POST'>
                            <input name='btnSearch' value='Search' type='submit'>
                            <input name='action' value='search' type='hidden'>
                            </form>";

    $selectS="";
    $selectQ="";
    $selectP="";
    $selectL="";
    if($this->courseinvoice_category=="S")
    $selectS = "SELECTED";
    else if($this->courseinvoice_category=="Q")
    $selectQ = "SELECTED";
    else if($this->courseinvoice_category=="P")
    $selectP = "SELECTED";
    else if($this->courseinvoice_category=="L")
    $selectL = "SELECTED";
  

    echo <<< EOF


<table style="width:140px;">
<tbody>
<td>$addnewctrl</td>
<td>$searchctrl</td>
<td><form onsubmit="return validateCourseinvoice()" method="post"
 action="courseinvoice.php" name="frmCourseinvoice"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>

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
        <td class="head" style="display:none">Courseinvoice Code $mandatorysign</td>
        <td class="even" style="display:none"><input maxlength="30" size="15" name="courseinvoice_no" value="$this->courseinvoice_no"></td>
        <td class="head">Courseinvoice Name $mandatorysign</td>
        <td class="even" ><input maxlength="100" size="50" name="courseinvoice_name" value="$this->courseinvoice_name"></td>
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
    $this->getSubTable($this->courseinvoice_id);
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

   public function getSubTable($courseinvoice_id){
        global $ctrl;
        $widthsubcourseinvoice = "style = 'width:200px' ";

        $sql = "select * from $this->tablecourseinvoiceline
                    where courseinvoice_id = $courseinvoice_id ";

        $this->log->showLog(4,"getLecturerTable :" . $sql . "<br>");

        $query=$this->xoopsDB->query($sql);

        //$productctrl = $ctrl->getSelectProduct(0,'Y',"","addsubcourseinvoice_id","",'addsubcourseinvoice_id',$widthsubcourseinvoice,'Y',0);

echo <<< EOF


        <br>
        <table id="tblSub" astyle="background-color:yellow">

        <tr>
        <td colspan="9" align="left">
        <table>
        <tr>
        <td width="1px" nowrap><input type="button" name="addSub" value="Add Item" onclick="checkAddSelect()"></td>
        <td nowrap> $courseinvoicectrl</td>
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
        <th align="center">Item</th>
        <th align="center">Account</th>
        <th align="center">Semester</th>
        <th align="center">Unit Price</th>
        <th align="center">Qty</th>
        <th align="center">Amount (RM)</th>
        <th align="center">Delete</th>
        </tr>
        <input type="hidden" name="addcourseinvoice_id" value="0">
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

        $courseinvoiceline_id = $row['courseinvoiceline_id'];
        $product_id = $row['product_id'];
        $courseinvoiceline_item = $row['courseinvoiceline_item'];
        $qty = $row['qty'];
        $unit_price= $row['unit_price'];
        $courseinvoiceline_type = $row['courseinvoiceline_type'];
        $semester_list = $row['semester_list'];
        $line_amt = $row['line_amt'];
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
        <input type="hidden" name="courseinvoiceline_id[$i]" value="$courseinvoiceline_id">
        <td class="$rowtype" align="center">$i</td>
        <td class="$rowtype" align="left" nowrap>
        <input id = "courseinvoiceline_item$i" name="courseinvoiceline_item[$i]" value="$courseinvoiceline_item" size="24" maxlength="100"> <a title="Add By Product" style="cursor:pointer" onclick="viewProduct($i)"> >> </a><br>
        <div id="idProductCtrl$i" style="display:none">$productctrlline</div></td>
        <td class="$rowtype" align="center" style="display:none">
        <select name="courseinvoiceline_type[$i]">
        <option value="" $selecttypeN></option>
        <option value="I" $selecttypeI>Yuran Awal</option>
        <option value="R" $selecttypeR>Yuran Berulang</option>
        <option value="S" $selecttypeS>Yuran Bermusim</option>
        </select>
        <td class="$rowtype" align="left" nowrap>$accountstctrlline</td>
        </td>
        <td class="$rowtype" align="left" nowrap>
        <input name="semester_list[$i]" value="$semester_list" size="12" maxlength="20"><br>        
        </td>
        <td class="$rowtype" align="center"><input  id = "unit_price$i" style="text-align:right" name="unit_price[$i]" value="$unit_price" size="8" maxlength="12" onfocus="select()" onblur="updateAmount($i)"></td>
        <td class="$rowtype" align="center"><input id = "qty$i" name="qty[$i]" value="$qty" size="3" maxlength="10" onfocus="select()" onblur="updateAmount($i)"></td>
        <td class="$rowtype" align="center"><input id = "line_amt$i" name="line_amt[$i]" value="$line_amt" size="8" maxlength="12" onfocus="select()"></td>
        <td class="$rowtype" align="center"><input type="button" name="btnDeleteLect" value="x" onclick="deleteSubLine($courseinvoiceline_id)"></td>
        </tr>

        <tr>
        <td colspan="8" class="$rowtype">
        <a style="cursor:pointer" onclick="viewRemarkLine($i)">View/Hide Remarks</a>
        <br><textarea name="line_desc[$i]"  col="100" rows="5" id="idLineDesc$i" $styleremarks>$line_desc</textarea></td>
        </tr>

EOF;
        }

        if($i==0)
        echo "<tr><td colspan='9' class='odd'><font color='red'>Please Define Item Invoice For This Course.</red></td></tr>";
echo <<< EOF
        </table>
EOF;

  }

  /**
   * Update existing courseinvoice record
   *
   * @return bool
   * @access public
   */
  public function updateCourseinvoice( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablecourseinvoice SET
	courseinvoice_name='$this->courseinvoice_name',description='$this->description',courseinvoice_no='$this->courseinvoice_no',
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',
    course_id=$this->course_id,
	organization_id=$this->organization_id WHERE courseinvoice_id='$this->courseinvoice_id'";
	$this->changesql = $sql;
	$this->log->showLog(3, "Update courseinvoice_id: $this->courseinvoice_id, $this->courseinvoice_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update courseinvoice failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update courseinvoice successfully.");
		return true;
	}
  } // end of member function updateCourseinvoice

  /**
   * Save new courseinvoice into database
   *
   * @return bool
   * @access public
   */
  public function insertCourseinvoice( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new courseinvoice $this->courseinvoice_name");
 	$sql="INSERT INTO $this->tablecourseinvoice (courseinvoice_name,courseinvoice_no,isactive, created,createdby,
	updated,updatedby,defaultlevel,organization_id,description,course_id)
    values(
	'$this->courseinvoice_name','$this->courseinvoice_no','$this->isactive','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->defaultlevel,$this->organization_id,'$this->description',$this->course_id)";
$this->changesql = $sql;
	$this->log->showLog(4,"Before insert courseinvoice SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert courseinvoice code $courseinvoice_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new courseinvoice $courseinvoice_name successfully");
		return true;
	}
  } // end of member function insertCourseinvoice

  /**
   * Pull data from courseinvoice table into class
   *
   * @return bool
   * @access public
   */
  public function fetchCourseinvoice( $courseinvoice_id) {


	$this->log->showLog(3,"Fetching courseinvoice detail into class Courseinvoice.php.<br>");
		
	$sql="SELECT * 
		 from $this->tablecourseinvoice where courseinvoice_id=$courseinvoice_id";
	
	$this->log->showLog(4,"ProductCourseinvoice->fetchCourseinvoice, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->courseinvoice_name=$row["courseinvoice_name"];
		$this->courseinvoice_no=$row["courseinvoice_no"];
		$this->organization_id=$row['organization_id'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->isactive=$row['isactive'];
		$this->description=$row['description'];
        $this->course_id=$row['course_id'];


   	$this->log->showLog(4,"Courseinvoice->fetchCourseinvoice,database fetch into class successfully");
	$this->log->showLog(4,"courseinvoice_name:$this->courseinvoice_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Courseinvoice->fetchCourseinvoice,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchCourseinvoice

  /**
   * Delete particular courseinvoice id
   *
   * @param int courseinvoice_id
   * @return bool
   * @access public
   */
  public function deleteCourseinvoice( $courseinvoice_id ) {
    	$this->log->showLog(2,"Warning: Performing delete courseinvoice id : $courseinvoice_id !");
	$sql="DELETE FROM $this->tablecourseinvoice where courseinvoice_id=$courseinvoice_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->changesql = $sql;
    $this->deleteAllLine($courseinvoice_id);
    
    
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: courseinvoice ($courseinvoice_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"courseinvoice ($courseinvoice_id) removed from database successfully!");

		return true;
		
	}
  } // end of member function deleteCourseinvoice

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllCourseinvoice( $wherestring,  $orderbystring,$limitstr="") {
  $this->log->showLog(4,"Running ProductCourseinvoice->getSQLStr_AllCourseinvoice: $sql");

    $wherestring .= " and a.course_id = b.course_id ";
    $sql="SELECT a.*,b.course_name,b.course_no
                FROM $this->tablecourseinvoice a,  $this->tablecourse b  " .
	" $wherestring $orderbystring $limitstr";
    $this->log->showLog(4,"Generate showcourseinvoicetable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllCourseinvoice

 public function showCourseinvoiceTable($wherestring,$orderbystring,$limitstr=""){
	
	$this->log->showLog(3,"Showing Courseinvoice Table");
	$sql=$this->getSQLStr_AllCourseinvoice($wherestring,$orderbystring,$limitstr);
	
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
		$courseinvoice_id=$row['courseinvoice_id'];
		$courseinvoice_name=$row['courseinvoice_name'];
		$courseinvoice_no=$row['courseinvoice_no'];
		$course_id=$row['course_id'];
        $course_name=$row['course_name'];
        $course_no=$row['course_no'];
        
        $credit_hrs = "$courseinvoice_crdthrs1 + $courseinvoice_crdthrs2";

		$defaultlevel=$row['defaultlevel'];

		$isactive=$row['isactive'];
		
		if($isactive==0)
		{$isactive='N';
		$isactive="<b style='color:red;'>N</b>";
		}
		else
		$isactive='Y';

       
   if($courseinvoice_category=="S")
   $courseinvoice_category = "Courseinvoice";
   else
    $courseinvoice_category = "Co Curriculum";


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
				<form action="courseinvoice.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this courseinvoice'>
				<input type="hidden" value="$courseinvoice_id" name="courseinvoice_id">
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
  public function getLatestCourseinvoiceID() {
	$sql="SELECT MAX(courseinvoice_id) as courseinvoice_id from $this->tablecourseinvoice;";
	$this->log->showLog(3,'Checking latest created courseinvoice_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created courseinvoice_id:' . $row['courseinvoice_id']);
		return $row['courseinvoice_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablecourseinvoice;";
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

 public function allowDelete($courseinvoice_id){
	
	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where courseinvoice_id = $courseinvoice_id or last_courseinvoice = $courseinvoice_id or next_courseinvoice = $courseinvoice_id ";
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
	$this->courseinvoice_category = "";
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
   if($this->courseinvoice_category=="S")
   $selectS = "SELECTED";
   else if($this->courseinvoice_category=="Q")
   $selectQ = "SELECTED";
   else if($this->courseinvoice_category=="P")
   $selectP = "SELECTED";
   else if($this->courseinvoice_category=="L")
   $selectL = "SELECTED";
   else
	$selectN = "SELECTED";

	//echo $this->iscomplete;

echo <<< EOF
<form name="frmCourseinvoice" action="courseinvoice.php" method="POST">
	</form>
	<form name="frmSearch" action="courseinvoice.php" method="POST">

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
	<td class="head">Courseinvoice Code</td>
	<td class="even"><input name="courseinvoice_no" value="$this->courseinvoice_no"></td>
	<td class="head">Courseinvoice Name</td>
	<td class="even"><input name="courseinvoice_name" value="$this->courseinvoice_name"></td>
	</tr>

    <tr>
    <td class="head" style="display:none">Courseinvoice Type</td>
    <td class="even" style="display:none">$this->courseinvoicetypectrl</td>
    <td class="head">Course</td>
    <td class="even" colspan="3">$this->coursectrl</td>
    </tr>


	<tr>
	
	<td class="head" style="display:none">Courseinvoice Category</td>
	<td class="even" acolspan="3" style="display:none">
    <select name="courseinvoice_category">
    <option value="" $selectQ>Null</option>
    <option value="S" $selectS>Courseinvoice</option>
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

    if($this->courseinvoice_category != "")
	$wherestr .= " and a.courseinvoice_category like '$this->courseinvoice_category' ";
	if($this->courseinvoice_no != "")
	$wherestr .= " and a.courseinvoice_no like '$this->courseinvoice_no' ";
    if($this->courseinvoice_name != "")
	$wherestr .= " and a.courseinvoice_name like '$this->courseinvoice_name' ";
    if($this->courseinvoicetype_id > 0)
	$wherestr .= " and a.courseinvoicetype_id = $this->courseinvoicetype_id ";
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

    public function addSubLine($courseinvoice_id){
        $timestamp= date("y/m/d H:i:s", time()) ;
        $sql = " insert into $this->tablecourseinvoiceline (courseinvoice_id,qty,created,createdby,updated,updatedby)
        values ($courseinvoice_id,1,'$timestamp',$this->updatedby,'$timestamp',$this->updatedby) ";
        $this->changesql = $sql;
        
        $this->log->showLog(4,"Before insert courseinvoice addSubLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        return true;
    }

    public function updateSubLine(){
        $timestamp= date("y/m/d H:i:s", time()) ;
        $i=0;
        foreach($this->courseinvoiceline_id as $id){
        $i++;

        $courseinvoiceline_item=$this->courseinvoiceline_item[$i];
        $courseinvoiceline_type=$this->courseinvoiceline_type[$i];
        $product_id=$this->product_id[$i];
        $accounts_id=$this->accounts_id[$i];
        $semester_list=$this->semester_list[$i];
        $line_desc=$this->line_desc[$i];
        $unit_price=$this->unit_price[$i];
        $qty=$this->qty[$i];
        $line_amt=$this->line_amt[$i];


        $sql = "update $this->tablecourseinvoiceline
        set courseinvoiceline_item = '$courseinvoiceline_item',
        courseinvoiceline_type = '$courseinvoiceline_type',
        product_id = $product_id,
        accounts_id = $accounts_id,
        semester_list = '$semester_list',
        line_desc = '$line_desc',
        unit_price = $unit_price,
        qty = $qty,
        line_amt = $line_amt
        where courseinvoiceline_id = $id ";

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert courseinvoice updateLecturerLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        }

        return true;
    }

    public function deleteSubLine($courseinvoiceline_id){

        $sql = "delete from $this->tablecourseinvoiceline where courseinvoiceline_id = $courseinvoiceline_id";

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert courseinvoice deleteSubLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }else
        return true;
        
    }

    public function addNoteLine($courseinvoice_id){

        $sql = " insert into $this->tablecourseinvoicenote (courseinvoice_id) values ($courseinvoice_id) ";
        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert courseinvoice addNoteLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        return true;
    }

    public function updateNoteLine(){

        $i=0;
        foreach($this->courseinvoicenoteline_id as $id){
        $i++;

        $courseinvoicenote_title = $this->courseinvoicenote_title[$i];
        $courseinvoicenote_description = $this->courseinvoicenote_description[$i];
        $isdownload = $this->isdownload[$i];
        $isdeleteline = $this->isdeleteline[$i];

        if($isdownload == "on")
        $isdownload = 1;
        else
        $isdownload = 0;

        if($isdeleteline == "on"){
        $this->deleteNoteLine($id);
        }else{
        $sql = "update $this->tablecourseinvoicenote
                    set courseinvoicenote_title = '$courseinvoicenote_title',
                    courseinvoicenote_description = '$courseinvoicenote_description',
                    isdownload = '$isdownload' 
                    where courseinvoicenoteline_id = $id ";
        

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert courseinvoice updateNoteLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }
        
        $this->saveAtt($this->atttmpfile[$i],$this->attfilesize[$i],$this->attfiletype[$i],$this->attfilename[$i],$id);
        }

        }

        return true;
    }

    public function deleteNoteLine($courseinvoicenoteline_id){

        $sql = "delete from $this->tablecourseinvoicenote where courseinvoicenoteline_id = $courseinvoicenoteline_id";

        $this->changesql = $sql;
        $this->deletefile($courseinvoicenoteline_id);
        
        $this->log->showLog(4,"Before insert courseinvoice deleteNoteLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }else{
            
            return true;
        }

    }

    public function saveAtt($atttmpfile,$attfilesize,$attfiletype,$attfilename,$courseinvoicenoteline_id){
	//$file_ext = "jpg";


	$file_ext = strrchr($attfilename, '.');

	$attfilesize = $attfilesize / 1024;
	//&& $attfilesize<300
	if($attfilesize>0 ){
	$newfilename = $courseinvoicenoteline_id."$file_ext";
	$this->savefile($atttmpfile,$newfilename,$courseinvoicenoteline_id);
	}


	}

    public function savefile($tmpfile,$newfilename,$courseinvoicenoteline_id){

        if(move_uploaded_file($tmpfile, "upload/courseinvoice/$newfilename")){
        $sqlupdate="UPDATE $this->tablecourseinvoicenote set filenote='$newfilename' where courseinvoicenoteline_id=$courseinvoicenoteline_id";
        $qryUpdate=$this->xoopsDB->query($sqlupdate);
        }else{
        echo "Cannot Upload File";
        }
    }

	public function deletefile($courseinvoicenoteline_id){
		$sql="SELECT filenote from $this->tablecourseinvoicenote where courseinvoicenoteline_id=$courseinvoicenoteline_id";
		$query=$this->xoopsDB->query($sql);
		$myfilename="";
		if($row=$this->xoopsDB->fetchArray($query)){
			$myfilename=$row['filenote'];
		}
		$myfilename="upload/courseinvoice/$myfilename";
		$this->log->showLog(3,"This file name: $myfilename");
		unlink("$myfilename");
		$sqlupdate="UPDATE $this->tablecourseinvoicenote set filenote='' where courseinvoicenoteline_id=$courseinvoicenoteline_id";
		$qryDelete=$this->xoopsDB->query($sqlupdate);
	}

    public function deleteAllLine($courseinvoice_id){

	$sqlselect = "select * from $this->tablecourseinvoicenote where courseinvoice_id = $courseinvoice_id and filenote <> '' ";

	$queryselect=$this->xoopsDB->query($sqlselect);

	while($rowselect=$this->xoopsDB->fetchArray($queryselect)){

	$courseinvoicenoteline_id = $rowselect['courseinvoicenoteline_id'];
	$myfilename = $rowselect['filenote'];

	$myfilename = "upload/courseinvoice/$myfilename";
	unlink("$myfilename");

	//$this->deletefile($courseinvoiceline_id);
	}
  }

  public function getProductInfo($product_id){

    echo $sql = "select * from $this->tableproduct pr where product_id = $product_id";

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


} // end of ClassCourseinvoice
?>

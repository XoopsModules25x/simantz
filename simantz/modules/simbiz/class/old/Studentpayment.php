<?php


class Studentpayment
{

  public $studentpayment_id;
  public $studentpayment_name;
  public $studentpayment_no;
  public $studentpayment_category;
  
  public $course_id;
  public $semester_id;
  public $studentpaymenttype_id;
  public $studentpayment_crdthrs1;
  public $studentpayment_crdthrs2;
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
  private $tablestudentpayment;
  private $tablebpartner;

  private $log;


//constructor
   public function Studentpayment(){
	global $xoopsDB,$log,$tablestudentpayment,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport;
    global $tablestudentpaymenttype,$tablesemester,$tablecourse,$tableemployee,$tablestudentpaymentlecturer,$tablestudentpaymentnote;
    global $tablestudentpaymentline,$tableproduct,$tablestudent,$tablesession,$tableyear;
    global $tableaccounts,$tablestudentinvoice,$tablestudentinvoiceline;


  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablestudentpayment=$tablestudentpayment;
    $this->tablestudentpaymenttype=$tablestudentpaymenttype;
    $this->tablesemester=$tablesemester;
    $this->tablecourse=$tablecourse;
	$this->tablebpartner=$tablebpartner;
    $this->tableemployee=$tableemployee;
    $this->tablestudentpaymentlecturer=$tablestudentpaymentlecturer;
    $this->tablestudentpaymentnote=$tablestudentpaymentnote;
    $this->tablestudentpaymentline=$tablestudentpaymentline;
    $this->tableproduct=$tableproduct;
    $this->tablestudent=$tablestudent;
    $this->tablesession=$tablesession;
    $this->tableyear=$tableyear;
    $this->tableaccounts=$tableaccounts;
    $this->tablestudentinvoice=$tablestudentinvoice;
    $this->tablestudentinvoiceline=$tablestudentinvoiceline;

	
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int studentpayment_id
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $studentpayment_id,$token  ) {
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
	 	
		if($studentpayment_id==0){
			$this->studentpayment_name="";
			$this->isactive="";
			$this->defaultlevel=10;
			$studentpaymentchecked="CHECKED";
			$this->studentpayment_no = getNewCode($this->xoopsDB,"studentpayment_no",$this->tablestudentpayment,"");
            $this->studentpayment_date= getDateSession();
            $this->studentpayment_type = "C";
            $this->iscomplete=0;

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
		$savectrl="<input name='studentpayment_id' value='$this->studentpayment_id' type='hidden'>".
			 "<input astyle='height: 40px;' name='btnSave' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablestudentpayment' type='hidden'>".
		"<input name='id' value='$this->studentpayment_id' type='hidden'>".
		"<input name='idname' value='studentpayment_id' type='hidden'>".
		"<input name='title' value='Studentpayment' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";


		$header="Edit";
		
		if($this->allowDelete($this->studentpayment_id))
		$deletectrl="<FORM action='studentpayment.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this studentpayment?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->studentpayment_id' name='studentpayment_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='studentpayment.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";

        $previewctrl="<FORM target='_blank' action='viewstudentpayment.php' method='POST' aonSubmit='return confirm(".
		'"confirm to remove this studentpayment?"'.")'><input type='submit' value='Preview' name='btnPreview'>".
		"<input type='hidden' value='$this->studentpayment_id' name='studentpayment_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
	}

    $searchctrl="<Form action='studentpayment.php' method='POST'>
                            <input name='btnSearch' value='Search' type='submit'>
                            <input name='action' value='search' type='hidden'>
                            </form>";


    $selectInvoice="";
    $selectOthers="";
    $styleInvoice = "";
    $styleOthers = "";
    if($this->studentpayment_category=="O"){
    $selectOthers = "SELECTED";
            if ($type!="new"){
            $styleInvoice = "style='display:none'";
            }
    }else{
    $selectInvoice = "SELECTED";
            if ($type!="new"){
            $styleOthers = "style='display:none'";
            }
    }
    
    $selectCash="";
    $selectCheque="";
    if($this->studentpayment_type=="Q")
    $selectCheque = "SELECTED";
    else
    $selectCash = "SELECTED";

    if($this->studentpayment_type == "C")
    $stylecno = "style='display:none'";
    else
    $stylecno = "";



    $this->stylecomplete = "style='display:none'";
    $this->styleenable = "style='display:none'";
    $this->stylesave = "style='display:none'";
    $submitform = "onsubmit='return validateStudentpayment()'";
    
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
 action="studentpayment.php" name="frmStudentpayment"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>

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
        <input name='studentpayment_date' id='studentpayment_date' value="$this->studentpayment_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->invoicedatectrl"> <font color=red>YYYY-MM-DD (Ex: 2009-01-30)</font>
        </td>

        </tr>

        <tr style="display:none">
        <td class="head" style="display:none">Studentpayment Code $mandatorysign</td>
        <td class="even" style="display:none"></td>
        <td class="head">Studentpayment Name $mandatorysign</td>
        <td class="even" ><input maxlength="100" size="50" name="studentpayment_name" value="$this->studentpayment_name"></td>
        </tr>

        <tr>
        <td class="head">Payment Type</td>
        <td class="even" colspan="3">
        <select name="studentpayment_category">
        <option value="I" $selectInvoice $styleInvoice>By Invoice</option>
        <option value="O" $selectOthers $styleOthers>Others</option>
        </select>
        </td>
        </tr>

        <tr>
        <td class="head">Student</td>
        <td class="even">$this->studentctrl</td>
        <td class="head">Payment No</td>
        <td class="even"><input maxlength="30" size="15" name="studentpayment_no" value="$this->studentpayment_no"></td>
        </tr>

        <tr>
        <td class="head">Payment Method</td>
        <td class="even">
        <select name="studentpayment_type" onchange="changeMethod(this.value)">
        <option value="C" $selectCash>Cash</option>
        <option value="Q" $selectCheque>Cheque</option>
        </select>
        </td>
        <td class="head">Cheque No</td>
        <td class="even"><input $stylecno maxlength="10" size="10" name="studentpayment_chequeno" value="$this->studentpayment_chequeno"></td>
        </tr>

        <tr>
        <td class="head" style="display:none">From Account</td>
        <td class="even" style="display:none">$this->fromaccountsctrl</td>
        <td class="head">To Account</td>
        <td class="even" colspan="3">$this->toaccountsctrl</td>
        </tr>

        <tr>
        <td class="head">Description</td>
        <td class="even" colspan='3'><textarea name="description" cols="40" rows="3">$this->description</textarea></td>
        </tr>
 
    </tbody>
  </table>
EOF;
    if ($type!="new"){
    $this->getAlertTable($this->student_id);
    $this->getSubTable($this->studentpayment_id);
    }else{
     
    }

echo <<< EOF

<br>
<table astyle="width:150px;"><tbody><td width=1 $this->stylesave>$savectrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form>
    <td width=1>
    <input type="button" value="Complete" onclick="paymentComplete()" $this->stylecomplete>
    <input type="button" value="Re-Enable" onclick="paymentEnable()" $this->styleenable>
    </td>
    <td >$previewctrl</td>
    <td align="right" $this->stylesave>$deletectrl</td>
    </tbody></table>
  <br>

$recordctrl

EOF;
  } // end of member function getInputForm

  public function getAlertTable($student_id){

    $sqlpaymentline = "coalesce((select sum(d.studentpayment_lineamt) as total_2 from $this->tablestudentpayment c, $this->tablestudentpaymentline d
    where c.studentpayment_id = d.studentpayment_id
    and d.studentinvoiceline_id = sl.studentinvoiceline_id),0) ";

    $sql = "select a.studentinvoice_id,a.studentinvoice_date,a.studentinvoice_no,sl.studentinvoice_lineamt,
    sl.studentinvoiceline_id,sl.studentinvoice_item,
    (sl.studentinvoice_lineamt - coalesce(($sqlpaymentline),0)) as balance_amt from $this->tablestudentinvoice a, $this->tablestudentinvoiceline sl
    where a.student_id = $student_id
    and a.studentinvoice_id = sl.studentinvoice_id
    and a.iscomplete = 1
    and (
    (coalesce(($sqlpaymentline),0) ) < sl.studentinvoice_lineamt
    )";

    $sqlcnt = "select count(*) as tot_row
    from $this->tablestudentinvoice a, $this->tablestudentinvoiceline sl
    where a.student_id = $student_id
    and a.studentinvoice_id = sl.studentinvoice_id
    and a.iscomplete = 1
    and (
    (coalesce(($sqlpaymentline),0) ) < sl.studentinvoice_lineamt
    )";
      
    /*
    $sqlpaymentline = "coalesce((select sum(d.studentpayment_lineamt) as total_2 from $this->tablestudentpayment c, $this->tablestudentpaymentline d
    where c.studentpayment_id = d.studentpayment_id
    and d.studentinvoice_id = a.studentinvoice_id),0) ";

    $sql = "select a.studentinvoice_id,a.studentinvoice_date,a.studentinvoice_no,a.total_amt,
    (a.total_amt - coalesce(($sqlpaymentline),0)) as balance_amt from $this->tablestudentinvoice a
    where a.student_id = $student_id
    and a.iscomplete = 0
    and (
    (coalesce(($sqlpaymentline),0) ) < a.total_amt
    )";

    $sqlcnt = "select count(*) tot_row
    from $this->tablestudentinvoice a
    where a.student_id = $student_id
    and a.iscomplete = 0
    and (
    (coalesce(($sqlpaymentline),0) ) < a.total_amt
    )";
     * 
     */

    $this->log->showLog(4,"getAlertTable :" . $sql . "<br>");

    $query=$this->xoopsDB->query($sql);
    $querycnt=$this->xoopsDB->query($sqlcnt);

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

    if($this->studentpayment_category == "O")
    $stylenew = "style='display:none'";

echo <<< EOF
    <table>
    <tr>
    <td align="right">
    <font color=red $this->stylesave><b>$tot_row</b></font>
    <img src="images/new.gif" $stylenew $this->stylesave>
    <a $stylenew $this->stylesave title="Click Here View Remaining Invoice For This Student" style="cursor:pointer" onclick="viewRemaining()">View Remaining Invoice >></a>
    </td>
    </tr>
    </table>

    <table id="tblRemaining" style="display:none">
    <tr>
    <th colspan="7">List Of Invoice (Outstanding Payment)</th>
    </tr>
    <tr>
    <th align="center" width=1></th>
    <th align="center">No</th>
    <th align="center">Invoice No</th>
    <th align="center">Item Description</th>
    <th align="center">Invoice Date</th>
    <th align="center">Total Amount (RM)</th>
    <th align="center">Total Balance (RM)</th>
    </tr>

EOF;

        $totalamt = 0;
        $baltotalamt = 0;
        $rowtype="";
        $i=0;
        while($row=$this->xoopsDB->fetchArray($query)){
            $i++;

            $studentinvoiceline_id = $row['studentinvoiceline_id'];
            $studentinvoice_id = $row['studentinvoice_id'];
            $studentinvoice_date = $row['studentinvoice_date'];
            $studentinvoice_no = $row['studentinvoice_no'];
            $balance_amt = $row['balance_amt'];
            $studentinvoice_lineamt = $row['studentinvoice_lineamt'];
            $studentinvoice_item = $row['studentinvoice_item'];


            $totalamt += $studentinvoice_lineamt;
            $baltotalamt += $balance_amt;

            if($rowtype=="even")
            $rowtype = "odd";
            else
            $rowtype = "even";


echo <<< EOF
        <input type="hidden" name="studentinvoiceline_idremain[$i]" value="$studentinvoiceline_id">
        <input type="hidden" name="studentinvoice_itemremain[$i]" value="$studentinvoice_item">
        <tr>
        <td class="$rowtype" align="center"><input type="checkbox" name="isselectremain[$i]"></td>
        <td class="$rowtype" align="center">$i</td>
        <td class="$rowtype" align="center"><a title="View This Invoice" target="blank" href="studentinvoice.php?action=edit&studentinvoice_id=$studentinvoice_id">$studentinvoice_no</a></td>
        <td class="$rowtype" align="center">$studentinvoice_item</td>
        <td class="$rowtype" align="center">$studentinvoice_date</td>
        <td class="$rowtype" align="right">$studentinvoice_lineamt</td>
        <td class="$rowtype" align="right">$balance_amt</td>
        </tr>
EOF;
            
        }

        $totalamt = number_format($totalamt,2);
        $baltotalamt = number_format($baltotalamt,2);
    if($i > 0){
echo <<< EOF
        <tr>
        <td class="head" align="right" colspan="5">Total (RM)</td>
        <td class="head" align="right">$totalamt</td>
        <td class="head" align="right">$baltotalamt</td>
        </tr>

    <tr height="40">
    <td colspan="4">&nbsp;&nbsp;<img src="images/arrowsel.png">
    <a style="cursor:pointer" onclick="selectAll(true);">Check All</a> /
    <a style="cursor:pointer" onclick="selectAll(false);">Uncheck All</a>

    <i>(Add To Payment With Selected Line)</i></td>
    <td colspan="3" align="right">&nbsp;&nbsp;<b><font color=red>Total Item : $i</font><b></td>
    </tr>

    <tr height="40">
    <td colspan="7" align="left"><input type="button" value="Add To Payment" onclick="AddToPayment()"></td>
    </tr>

EOF;
    }
echo <<<EOF
    </table>
EOF;
  }

   public function getSubTable($studentpayment_id){
        global $ctrl;
        $widthsubstudentpayment = "style = 'width:200px' ";

        $sqlpaymentline = "coalesce((select sum(d.studentpayment_lineamt) as total_2 from $this->tablestudentpayment c, $this->tablestudentpaymentline d
        where c.studentpayment_id = d.studentpayment_id
        and d.studentinvoiceline_id = si.studentinvoiceline_id),0) ";

        /*
        $sql = "select a.studentinvoice_id,a.studentinvoice_date,a.studentinvoice_no,a.total_amt,
        (a.total_amt - coalesce(($sqlpaymentline),0)) as balance_amt from $this->tablestudentinvoice a
        where a.student_id = $student_id
        and a.iscomplete = 0
        and (
        (coalesce(($sqlpaymentline),0) ) < a.total_amt
        )";
         * 
         */

       $sql = "select pl.*,sv.studentinvoice_no,sv.studentinvoice_date,si.studentinvoice_lineamt,sv.studentinvoice_id,
                    (si.studentinvoice_lineamt - coalesce(($sqlpaymentline),0)) as balance_amt
                    from $this->tablestudentpaymentline pl
                    left join $this->tablestudentinvoiceline si on si.studentinvoiceline_id = pl.studentinvoiceline_id
                    inner join $this->tablestudentinvoice sv on sv.studentinvoice_id = si.studentinvoice_id 
                    where pl.studentpayment_id = $studentpayment_id ";

        $this->log->showLog(4,"getLecturerTable :" . $sql . "<br>");

        $query=$this->xoopsDB->query($sql);

        //$productctrl = $ctrl->getSelectProduct(0,'Y',"","addsubstudentpayment_id","",'addsubstudentpayment_id',$widthsubstudentpayment,'Y',0);
        $styleadditem = "";
        $styleinvoice = "";
        if($this->studentpayment_category == "I"){
        $styleadditem = "style='display:none'";
        }else{
        $styleinvoice = "style='display:none'";
        }
        
echo <<< EOF


        <br>
        <table id="tblSub" astyle="background-color:yellow">

        <tr>
        <td colspan="8" align="left">
        <table>
        <tr>
        <td width="1px" nowrap></td>
        <td nowrap> $studentpaymentctrl</td>
        <!--<td align="right"><a>Hide Lecturer >></a></td>-->
        </tr>
        </table>
        </td>
        </tr>

        <tr>
        <th align="left" colspan="4">List Of Payment Item</th>
        <th align="right" colspan="4"><input $styleadditem $this->stylesave type="button" name="addSub" value="Add Item" onclick="checkAddSelect()"></th>

        </tr>
        </tr>
        <tr>
        <th align="center">No</th>
        <th align="center">Invoice / Item</th>
        <th align="center">Invoice Date</th>
        <th align="center">Invoice Amount</th>
        <th align="center">Invoice Balance</th>
        <th align="center">Paid (RM)</th>
        <th align="center">Delete</th>
        </tr>
        <input type="hidden" name="addstudentpayment_id" value="0">
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


        $studentpaymentline_id = $row['studentpaymentline_id'];
        $studentinvoice_id = $row['studentinvoice_id'];
        $studentpayment_item = $row['studentpayment_item'];
        $studentpayment_lineamt = $row['studentpayment_lineamt'];
        $line_desc = $row['line_desc'];
        $studentinvoice_no = $row['studentinvoice_no'];
        $studentinvoice_date = $row['studentinvoice_date'];
        $studentinvoice_lineamt = $row['studentinvoice_lineamt'];
        $balance_amt = $row['balance_amt'];

        if($styleinvoice != "")
        $balance_amt = "";
        
        if($studentinvoice_date == "0000-00-00")
        $studentinvoice_date = "";
        if($studentinvoice_lineamt == "0.00")
        $studentinvoice_lineamt = "";
        
        //$productctrlline = $ctrl->getSelectProduct($product_id,'Y',"onchange=getProductInfo(this.value,$i);","product_id[$i]","","product_id$i","style='width:180px'",'Y',$i);
        //$accountstctrlline = $ctrl->getSelectAccounts($accounts_id,'Y',"","accounts_id[$i]","","N","N","N","accounts_id$i","style='width:180px'");

        $styleremarks = "style='display:none'";
        if($line_desc != "")
        $styleremarks= "";

echo <<< EOF
        <input type="hidden" id="balance_amt$i"  name="balance_amtarr[$i]" value="$balance_amt" >
        <tr height="3">
        <td></td>
        </tr>
        <tr>
        <input type="hidden" name="studentpaymentline_id[$i]" value="$studentpaymentline_id">
        <td class="$rowtype" align="center">$i</td>
        <td class="$rowtype" align="left" nowrap>
        <input id = "studentpayment_item$i" name="studentpayment_item[$i]" value="$studentpayment_item" size="35" maxlength="100">
        <div $styleinvoice>Invoice No : <a title="View This Invoice" target="blank" href="studentinvoice.php?action=edit&studentinvoice_id=$studentinvoice_id">$studentinvoice_no</a></div>
        </td>
        <td class="$rowtype" align="center">$studentinvoice_date</td>
        <td class="$rowtype" align="center" nowrap>$studentinvoice_lineamt</td>
        </td>
        <td class="$rowtype" align="center">$balance_amt</td>
        <td class="$rowtype" align="center"><input id = "studentpayment_lineamt$i" style="text-align:right" name="studentpayment_lineamt[$i]" value="$studentpayment_lineamt" size="8" maxlength="12" onfocus="select()" onblur="updateTotal();"></td>
        <td class="$rowtype" align="center"><input $this->stylesave type="button" name="btnDeleteLect" value="x" onclick="deleteSubLine($studentpaymentline_id,$i)"></td>
        </tr>

        <tr>
        <td colspan="8" class="$rowtype">
        <a style="cursor:pointer" onclick="viewRemarkLine($i)">View/Hide Remarks</a>
        <br><input name="line_desc[$i]" value="$line_desc" size="40" maxlength="255" id="idLineDesc$i" $styleremarks></td>
        </tr>

EOF;
        }

        if($i==0)
        echo "<tr><td colspan='9' class='odd'><font color='red'>Please Define Item Payment.</red></td></tr>";

        echo "<tr><td colspan='2' class='head' align='left'><input $this->stylesave type='button' value='Pay All' onclick='payAll()'></td>";
        echo "<td colspan='3' class='head' align='right'>Total</td>";
        echo "<td colspan='1' class='head' align='center'><input readonly name='total_amt' style='text-align:right' value='$this->total_amt' size='10' maxlength='11'></td>";
        echo "<td colspan='1' class='head' align='right'></td></tr>";
        
echo <<< EOF
        </table>
EOF;

  }

  /**
   * Update existing studentpayment record
   *
   * @return bool
   * @access public
   */
  public function updateStudentpayment( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablestudentpayment SET
	studentpayment_date='$this->studentpayment_date',description='$this->description',studentpayment_no='$this->studentpayment_no',
	updated='$timestamp',updatedby=$this->updatedby,studentpayment_category='$this->studentpayment_category',
    student_id=$this->student_id,studentpayment_type='$this->studentpayment_type',
    studentpayment_chequeno='$this->studentpayment_chequeno',to_accounts=$this->to_accounts,
    from_accounts=$this->from_accounts,
    total_amt=$this->total_amt,iscomplete=$this->iscomplete,
	organization_id=$this->organization_id WHERE studentpayment_id='$this->studentpayment_id'";
	$this->changesql = $sql;
	$this->log->showLog(3, "Update studentpayment_id: $this->studentpayment_id, $this->studentpayment_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update studentpayment failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update studentpayment successfully.");
		return true;
	}
  } // end of member function updateStudentpayment

  /**
   * Save new studentpayment into database
   *
   * @return bool
   * @access public
   */
  public function insertStudentpayment( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new studentpayment $this->studentpayment_name");
 	$sql="INSERT INTO $this->tablestudentpayment
    (studentpayment_date,studentpayment_no,
    created,createdby,updated,updatedby,
    student_id,studentpayment_category,studentpayment_type,
    studentpayment_chequeno,to_accounts,from_accounts,
    organization_id,description)
    values(
	'$this->studentpayment_date','$this->studentpayment_no',
    '$timestamp',$this->createdby,'$timestamp',$this->updatedby,
    $this->student_id,'$this->studentpayment_category','$this->studentpayment_type',
    '$this->studentpayment_chequeno',$this->to_accounts,$this->from_accounts,
    $this->organization_id,'$this->description')";
$this->changesql = $sql;
	$this->log->showLog(4,"Before insert studentpayment SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert studentpayment code $studentpayment_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new studentpayment $studentpayment_name successfully");
		return true;
	}
  } // end of member function insertStudentpayment

  /**
   * Pull data from studentpayment table into class
   *
   * @return bool
   * @access public
   */
  public function fetchStudentpayment( $studentpayment_id) {


	$this->log->showLog(3,"Fetching studentpayment detail into class Studentpayment.php.<br>");
		
	$sql="SELECT *
		 from $this->tablestudentpayment where studentpayment_id=$studentpayment_id";
	
	$this->log->showLog(4,"ProductStudentpayment->fetchStudentpayment, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
        $this->studentpayment_date=$row["studentpayment_date"];
        $this->studentpayment_no=$row["studentpayment_no"];
        $this->organization_id=$row['organization_id'];
        $this->student_id= $row['student_id'];
        $this->studentpayment_category= $row['studentpayment_category'];
        $this->studentpayment_type= $row['studentpayment_type'];
        $this->iscomplete=$row['iscomplete'];
        $this->description=$row['description'];
        $this->studentpayment_chequeno=$row['studentpayment_chequeno'];
        $this->to_accounts=$row['to_accounts'];
        $this->from_accounts=$row['from_accounts'];
        $this->total_amt=$row['total_amt'];
        $this->batch_id=$row['batch_id'];
        $this->batch_no=$row['batch_no'];
        $this->generatestudentpayment_id=$row['generatestudentpayment_id'];


   	$this->log->showLog(4,"Studentpayment->fetchStudentpayment,database fetch into class successfully");
	$this->log->showLog(4,"studentpayment_name:$this->studentpayment_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Studentpayment->fetchStudentpayment,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchStudentpayment

  /**
   * Delete particular studentpayment id
   *
   * @param int studentpayment_id
   * @return bool
   * @access public
   */
  public function deleteStudentpayment( $studentpayment_id ) {
    	$this->log->showLog(2,"Warning: Performing delete studentpayment id : $studentpayment_id !");
	$sql="DELETE FROM $this->tablestudentpayment where studentpayment_id=$studentpayment_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->changesql = $sql;

    
    
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: studentpayment ($studentpayment_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"studentpayment ($studentpayment_id) removed from database successfully!");

		return true;
		
	}
  } // end of member function deleteStudentpayment

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllStudentpayment( $wherestring,  $orderbystring,$limitstr="") {
  $this->log->showLog(4,"Running ProductStudentpayment->getSQLStr_AllStudentpayment: $sql");

    $sql="select si.*,st.student_name,st.student_no,cr.course_name,cr.course_no 
    from $this->tablestudentpayment si
    inner join $this->tablestudent st on st.student_id = si.student_id
    inner join $this->tablecourse cr on cr.course_id = st.course_id 
    $wherestring $orderbystring $limitstr";
    $this->log->showLog(4,"Generate showstudentpaymenttable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllStudentpayment

 public function showStudentpaymentTable($wherestring,$orderbystring,$limitstr=""){
	
	$this->log->showLog(3,"Showing Studentpayment Table");
	$sql=$this->getSQLStr_AllStudentpayment($wherestring,$orderbystring,$limitstr);
	
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
				<th style="text-align:center;">Payment No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Type/Method</th>
				<th style="text-align:center;">Student</th>
				<th style="text-align:center;">Matrix No</th>
				<th style="text-align:center;">Course</th>
				<th style="text-align:center;">Amount (RM)</th>
				<th style="text-align:center;">Complete</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;

    $sum_total = 0;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;

        $student_id=$row['student_id'];
        $studentpayment_id=$row['studentpayment_id'];
        $studentpayment_no=$row['studentpayment_no'];
        $student_name=$row['student_name'];
        $student_no=$row['student_no'];
        $course_name=$row['course_name'];
        $course_no=$row['course_no'];
        $semester_name=$row['semester_name'];
        $year_name=$row['year_name'];
        $session_name=$row['session_name'];
        $total_amt=$row['total_amt'];
        $studentpayment_date=$row['studentpayment_date'];
        $studentpayment_category=$row['studentpayment_category'];
        $studentpayment_type=$row['studentpayment_type'];
        
        $credit_hrs = "$studentpayment_crdthrs1 + $studentpayment_crdthrs2";

        $sum_total += $total_amt;
        
		$iscomplete=$row['iscomplete'];
		
		if($iscomplete==0)
		{$iscomplete='N';
		$iscomplete="<b style='color:red;'>N</b>";
		}
		else
		$iscomplete='Y';

       
        if($studentpayment_category=="I")
        $studentpayment_category = "By Invoice";
        else
        $studentpayment_category = "Others";

        if($studentpayment_type=="C")
        $studentpayment_type = "Cash";
        else
        $studentpayment_type = "Cheque";


		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

            
		echo <<< EOF
        
		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$studentpayment_no</td>
			<td class="$rowtype" style="text-align:center;">$studentpayment_date</td>
			<td class="$rowtype" style="text-align:center;" nowrap>$studentpayment_category - $studentpayment_type</td>
			<td class="$rowtype" style="text-align:left;"><a target="blank" href="../hes/student.php?action=edit&student_id=$student_id">$student_name</a></td>
			<td class="$rowtype" style="text-align:center;">$student_no</td>
			<td class="$rowtype" style="text-align:center;">$course_no</td>
			<td class="$rowtype" style="text-align:center;">$total_amt</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
                <table><tr><td>
				<form action="studentpayment.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this studentpayment'>
				<input type="hidden" value="$studentpayment_id" name="studentpayment_id">
				<input type="hidden" name="action" value="edit">
				</form>
                </td>
                <td>
                <img src="images/list.gif" title="Preview Invoice" style="cursor:pointer" onclick="viewStudentInvoice($studentpayment_id)">
                </td>
                </tr></table>
			</td>

		</tr>
EOF;
	}
    $sum_total = number_format($sum_total,2);

    $sql = str_replace("'","#",$sql);
    if($i > 0 ){
    echo "<tr><th colspan='7' align='right'>Total (RM)</th><th align='center'>$sum_total</th><th colspan='2'></th></tr>";

echo <<< EOF
        <form action="viewdailyreceipt.php" method="POST" target="_blank">

        <input type="hidden" name='start_date' value="$this->start_date">
        <input type="hidden" name='end_date' value="$this->end_date">
        <input type="hidden" name='studentpayment_category' value="$this->studentpayment_category">
        <input type="hidden" name='studentpayment_type' value="$this->studentpayment_type">

        <textarea name="sqlpost" style="display:none">$sql</textarea>
        <input type="hidden" name="action" value="printpreview">
        <td colspan='10' align="right"><input type="submit" value="Preview"></td>
        </form>
EOF;
    }

	echo  "</tbody></table>";
 }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestStudentpaymentID() {
	$sql="SELECT MAX(studentpayment_id) as studentpayment_id from $this->tablestudentpayment;";
	$this->log->showLog(3,'Checking latest created studentpayment_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created studentpayment_id:' . $row['studentpayment_id']);
		return $row['studentpayment_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablestudentpayment;";
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

 public function allowDelete($studentpayment_id){
	
	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where studentpayment_id = $studentpayment_id or last_studentpayment = $studentpayment_id or next_studentpayment = $studentpayment_id ";
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
	$this->studentpayment_type = "";
    $this->studentpayment_category = "";

    if($this->start_date=="")
    $this->start_date = getMonth(date("Ymd", time()),0) ;

    if($this->end_date=="")
    $this->end_date = getMonth(date("Ymd", time()),1) ;
    }


	//iscomplete
    
	if($this->iscomplete == "1")
	$selectactiveY = "selected = 'selected'";
	else if($this->iscomplete == "0")
	$selectactiveN = "selected = 'selected'";
	else
	$selectactiveL = "selected = 'selected'";

    $selectCash="";
    $selectCheque="";
    $selectNull="";
    if($this->studentpayment_type=="C")
    $selectCash = "SELECTED";
    else if($this->studentpayment_type=="Q")
    $selectCheque = "SELECTED";
    else
    $selectNull = "SELECTED";

    $selectTypeNull="";
    $selectTypeI="";
    $selectTypeO="";
    if($this->studentpayment_category=="I")
    $selectTypeI = "SELECTED";
    else if($this->studentpayment_category=="O")
    $selectTypeO = "SELECTED";
    else
    $selectTypeNull = "SELECTED";

	//echo $this->iscomplete;

echo <<< EOF
<form name="frmStudentpayment" action="studentpayment.php" method="POST">
	</form>
	<form name="frmSearch" action="studentpayment.php" method="POST">

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
	<td class="head">Payment No</td>
	<td class="even" acolspan="3"><input name="studentpayment_no" value="$this->studentpayment_no"></td>
	<td class="head">Student</td>
	<td class="even">$this->studentctrl</td>
	</tr>

	<tr>
	<td class="head">Student Name</td>
	<td class="even"><input name="student_name" value="$this->student_name"></td>
	<td class="head">Matrix No</td>
	<td class="even"><input name="student_no" value="$this->student_no"></td>
	</tr>

	<tr style="display:none">
	<td class="head">Session</td>
	<td class="even">$this->yearctrl / $this->sessionctrl</td>
	<td class="head">Semester</td>
	<td class="even">$this->semesterctrl</td>
	</tr>

    <tr>
    <td class="head">Course</td>
    <td class="even" colspan="3">$this->coursectrl</td>
    </tr>


	<tr>
    <td class="head">Payment Type</td>
    <td class="even" acolspan="3">
    <select name="studentpayment_category">
    <option value="" $selectTypeNull>Null</option>
    <option value="I" $selectTypeI>By Invoice</option>
    <option value="O" $selectTypeO>Others</option>
    </select>
    </td>
    <td class="head">Payment Method</td>
    <td class="even" acolspan="3">
    <select name="studentpayment_type">
    <option value="" $selectNull>Null</option>
    <option value="C" $selectCash>Cash</option>
    <option value="Q" $selectCheque>Cheque</option>
    </select>
    </td>
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


	if($this->studentpayment_no != "")
	$wherestr .= " and si.studentpayment_no like '$this->studentpayment_no' ";
    if($this->student_id > 0)
	$wherestr .= " and st.student_id = $this->student_id ";
    if($this->student_name != "")
	$wherestr .= " and st.student_name like '$this->student_name' ";
    if($this->student_no != "")
	$wherestr .= " and st.student_no like '$this->student_no' ";
    if($this->course_id > 0)
	$wherestr .= " and st.course_id = $this->course_id ";
	if($this->year_id > 0)
	$wherestr .= " and st.year_id = $this->year_id ";
	if($this->session_id > 0)
	$wherestr .= " and st.session_id = $this->session_id ";
	if($this->semester_id > 0)
	$wherestr .= " and st.semester_id = $this->semester_id ";    
	if($this->iscomplete == "0" || $this->iscomplete == "1")
	$wherestr .= " and si.iscomplete = $this->iscomplete ";

	if($this->start_date != "" && $this->end_date != "")
	$wherestr .= " and ( si.studentpayment_date between '$this->start_date' and '$this->end_date' ) ";

    if($this->studentpayment_type != "")
	$wherestr .= " and si.studentpayment_type like '$this->studentpayment_type' ";
    if($this->studentpayment_category != "")
	$wherestr .= " and si.studentpayment_category like '$this->studentpayment_category' ";

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

    public function addSubLine($studentpayment_id){
        $timestamp= date("y/m/d H:i:s", time()) ;
        $sql = " insert into $this->tablestudentpaymentline (studentpayment_id,created,createdby,updated,updatedby)
        values ($studentpayment_id,'$timestamp',$this->updatedby,'$timestamp',$this->updatedby) ";
        $this->changesql = $sql;
        
        $this->log->showLog(4,"Before insert studentpayment addSubLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        return true;
    }

    public function updateSubLine(){
        $timestamp= date("y/m/d H:i:s", time()) ;
        $i=0;
        foreach($this->studentpaymentline_id as $id){
        $i++;

        $studentpayment_item=$this->studentpayment_item[$i];
        $line_desc=$this->line_desc[$i];
        $studentpayment_lineamt=$this->studentpayment_lineamt[$i];


        $sql = "update $this->tablestudentpaymentline
        set studentpayment_item = '$studentpayment_item',
        line_desc = '$line_desc',
        studentpayment_lineamt = $studentpayment_lineamt
        where studentpaymentline_id = $id ";

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert studentpayment updateLecturerLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        }

        return true;
    }

    public function deleteSubLine($studentpaymentline_id){

        $sql = "delete from $this->tablestudentpaymentline where studentpaymentline_id = $studentpaymentline_id";

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert studentpayment deleteSubLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }else
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
       foreach($this->studentinvoiceline_idremain as $studentinvoiceline_id){
       $i++;

       $item_line = $this->studentinvoice_itemremain[$i];

            if($this->isselectremain[$i] == "on"){
               $sql = "insert into $this->tablestudentpaymentline
                            (studentinvoiceline_id,studentpayment_id,studentpayment_item) values
                            ($studentinvoiceline_id,$this->studentpayment_id,'$item_line');";

                    $this->changesql .= $sql;
                    $query=$this->xoopsDB->query($sql);
                    if(!$query){
                    return false;
                    }
            }

       }

       return true;
    }

    public function updateTotalAmount($studentpayment_id){

        $sql = "update $this->tablestudentpayment set
                    total_amt = (select sum(studentpayment_lineamt) from $this->tablestudentpaymentline
                    where studentpayment_id = $studentpayment_id )
                    where studentpayment_id = $studentpayment_id ";
        
        $query=$this->xoopsDB->query($sql);
        if(!$query){
        return false;
        }else{
        return false;
        }
    }

    public function batchAPIPayment($studentpayment_id){
	global $defaultcurrency_id,$student_account,$student_bpartner;
	/*$api->PostBatch($uid,$date,$systemname,$batch_name,$description,$totaltransactionamt,$documentnoarray,
	$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,$transtypearray,$linetypearray,
	$chequenoarray);*/

	$sql = "select si.*,sum(studentpayment_lineamt) as sum_accounts,
                sl.line_desc,st.student_name,st.student_no
                from $this->tablestudentpayment si
                inner join $this->tablestudentpaymentline sl on sl.studentpayment_id = si.studentpayment_id
                inner join $this->tablestudent st on st.student_id = si.student_id
                where si.studentpayment_id = $studentpayment_id
                group by si.studentpayment_id
                order by si.studentpayment_id ";

	$this->log->showLog(4,"SQL API: $sql");
	$query=$this->xoopsDB->query($sql);
	$return_false = 0;
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){

	//header list
	$date = $row["studentpayment_date"];
	$systemname = "Finance";
	$batch_name = "Student Payment Batch"." (".$row["student_no"].")";;
	//$description = $row["descriptions"];
    $description = $row["student_name"]." (".$row["student_no"].")";
	$totaltransactionamt = $row["total_amt"];

	if($i == 0){//line type = 0
	$documentnoarray[$i]  = $row["studentpayment_no"];
	$accountsarray[$i] = $student_account;
	$amtarray[$i] = $row["total_amt"]*-1;
	//$currencyarray[$i] = $row["currency_id"];
	//$conversionarray[$i] = $row["exchangerate"];
    $currencyarray[$i] = 0;
    $conversionarray[$i] = 1;
	$originalamtarray[$i] = $row["total_amt"]*-1;
	$bpartnerarray[$i] =  $student_bpartner;
	$transtypearray[$i] = "IV";//IV = payment, CQ = Cheque, CN = Credit Note, DN = Debit Note, GN = General
	$linetypearray[$i] = 0;
	$chequenoarray[$i]="";
	$i++;

	if($student_account == 0 || $student_bpartner == 0)//if '0' return false
	$return_false = 1;
	}

	//line type = 1
	$documentnoarray[$i]  = $row["studentpayment_no"];
	$accountsarray[$i] = $row["to_accounts"];
	$amtarray[$i] = $row["total_amt"];
	//$currencyarray[$i] = $row["currency_id"];
	//$conversionarray[$i] = $row["exchangerate"];
    $currencyarray[$i] = 0;
    $conversionarray[$i] = 1;
	$originalamtarray[$i] = $row["total_amt"];
	$bpartnerarray[$i] = 0;
	$transtypearray[$i] = "IV";//IV = payment, CQ = Cheque, CN = Credit Note, DN = Debit Note, GN = General
	$linetypearray[$i] = 1;
	$chequenoarray[$i]=$row["studentpayment_chequeno"];
	$i++;

	if($row["to_accounts"] == 0)//if '0' return false
	$return_false = 1;
	}

	return array($date,$systemname,$batch_name,$description,$totaltransactionamt,$documentnoarray,
	$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,$transtypearray,$linetypearray,
	$chequenoarray,$return_false);

	}

	public function updateBatchInfoPayment($fld,$batch_info,$studentpayment_id){

	if($batch_info != ""){
	$sql = "update $this->tablestudentpayment set $fld = $batch_info
		where studentpayment_id = $studentpayment_id";
	}else{
	$sql = "update $this->tablestudentpayment set batch_id = 0, batch_no = ''
		where studentpayment_id = $studentpayment_id";
	}

	$this->log->showLog(4, "SQL get View More");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
	$this->log->showLog(2, "Warning! update batch info failed ($fld):".mysql_error(). ":$sql");
	return false;
	}

	}

    public function updateComplete($iscomplete,$studentpayment_id){
        $sql = "update $this->tablestudentpayment set iscomplete = $iscomplete where studentpayment_id = $studentpayment_id ";

        $this->log->showLog(4, "SQL updateComplete");

        $rs=$this->xoopsDB->query($sql);
        if(!$rs){
        $this->log->showLog(2, "Warning! update complete status ($fld):".mysql_error(). ":$sql");
        return false;
        }
    }

   public function reactivateStudentPayment($studentpayment_id){

	$sql="UPDATE $this->tablestudentpayment set iscomplete=0 where studentpayment_id=$studentpayment_id";
	$this->log->showLog(4,"Update reactivateStudentPayment with SQL Statement: $sql");

	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: salespayment ($salespayment_id) cannot reactive" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"salespayment ($salespayment_id) reactivated successfully!");
		return true;

	}

	}

} // end of ClassStudentpayment
?>

<?php


class Otapproval
{

  public $overtime_id;
  public $otapproval_name;
  public $overtime_no;
  public $otapproval_category;
  
  public $department_id;
  public $semester_id;
  public $otapprovaltype_id;
  public $otapproval_crdthrs1;
  public $otapproval_crdthrs2;
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
   public function Otapproval(){
	global $xoopsDB,$log,$tableovertime,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport;
    global $tableovertimetype,$tablesemester,$tablecourse,$tableemployee,$tableovertimelecturer,$tableovertimenote;
    global $tableovertimeline,$tableproduct,$tablestudent,$tablesession,$tableyear,$tabledepartment;
    global $tableaccounts,$tableovertime,$tableovertimeline,$tableperiod;


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
    $this->tableaccounts=$tableaccounts;
    $this->tableovertime=$tableovertime;
    $this->tableovertimeline=$tableovertimeline;
    $this->tabledepartment=$tabledepartment;
    $this->tableperiod=$tableperiod;

	
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
			$this->otapproval_name="";
			$this->isactive="";
			$this->defaultlevel=10;
			$otapprovalchecked="CHECKED";
			//$this->overtime_no = getNewCode($this->xoopsDB,"overtime_no",$this->tableovertime,"");
            $this->overtime_date= getDateSession();
            $this->payment_type = "C";
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
		$savectrl="<input name='overtime_id' value='$this->overtime_id' type='hidden'>".
			 "<input astyle='height: 40px;' name='btnSave' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableovertime' type='hidden'>".
		"<input name='id' value='$this->overtime_id' type='hidden'>".
		"<input name='idname' value='overtime_id' type='hidden'>".
		"<input name='title' value='Otapproval' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";


		$header="Edit";
		
		if($this->allowDelete($this->overtime_id))
		$deletectrl="<FORM action='otapproval.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this otapproval?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->overtime_id' name='overtime_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='otapproval.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";


        $previewctrl="<FORM target='_blank' action='viewovertime.php' method='POST' aonSubmit='return confirm(".
		'"confirm to remove this overtime?"'.")'><input type='submit' value='Preview' name='btnPreview'>".
		"<input type='hidden' value='$this->overtime_id' name='overtime_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
	}

    $searchctrl="<Form action='otapproval.php' method='POST'>
                            <input name='btnSearch' value='Search' type='submit'>
                            <input name='action' value='search' type='hidden'>
                            </form>";
    
    $selectCash="";
    $selectCheque="";
    if($this->payment_type=="Q")
    $selectCheque = "SELECTED";
    else
    $selectCash = "SELECTED";

    if($this->payment_type == "C")
    $stylecno = "style='display:none'";
    else
    $stylecno = "";



    $this->stylecomplete = "style='display:none'";
    $this->styleenable = "style='display:none'";
    $this->stylesave = "style='display:none'";
    $this->styleverify = "style='display:none'";
    $this->stylepublish = "style='display:none'";

    if($type == "edit"){

        if($this->iscomplete == 0){
        $this->stylecomplete = "";
        $this->stylesave = "";
        $formsubmit = "onsubmit='return validateOtapproval()'";
        }else{
        $this->styleenable = "";
        $formsubmit = "onsubmit='return false'";
        }

        if($this->issubmit == 1){
        $publishbtn = "Re-Activate (Employee)";
        $this->styleverify = "";
        $this->stylesave = "style='display:none'";
        $this->stylepublish = "";
        $formsubmit = "onsubmit='return false'";
        }else{
        $publishbtn = "Submit Form";
        $this->stylepublish = "";
        }

        if($this->isverify == 1){
        $this->stylecomplete = "";
        $this->stylepublish = "style='display:none'";
        $this->styleverify = "";
        $verifybtn = "Re-Activate (HOD)";
        }else{
        $this->stylecomplete = "style='display:none'";
        $verifybtn = "Verify";
        }

        if($this->iscomplete == 1){
         $this->stylecomplete = "style='display:none'";
         $this->styleverify = "style='display:none'";
        }
        
    }else{
    $this->stylesave = "";
    $formsubmit = "onsubmit='return validateOtapproval()'";
    }

    // setting for verified_by
    $login_user = $this->getEmployeeId($this->updatedby);

    if($login_user != $this->verified_by)
    $this->styleverify = "style='display:none'";
    //end

    
    echo <<< EOF


<table style="width:140px;">
<tbody>
<td>$addnewctrl</td>
<td>$searchctrl</td>
<td><form $formsubmit method="post"
 action="otapproval.php" name="frmOtapproval"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>

<input type="hidden" name="deletesubline_id" value="0">
<input type="hidden" name="deletenoteline_idss" value="0">
<input type="hidden" name="iscomplete" value="$this->iscomplete">
<input type="hidden" name="fldnamebtn" value="">
<input type="hidden" name="fldnamebtn_id" value="0">
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
        <input name='overtime_date' id='overtime_date' value="$this->overtime_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->overtimedatectrl"> <font color=red>YYYY-MM-DD (Ex: 2009-01-30)</font>
        </td>

        </tr>

        <tr>
        <td class="head">Period</td>
        <td class="even">$this->periodctrl</td>
        <td class="head">Doc No</td>
        <td class="even">$this->overtime_no</td>
        </tr>

        <tr>
        <td class="head">Employee</td>
        <td class="even" colspan="3">$this->employeectrl</td>
        </tr>

        <tr style="display:none">
        <td class="head">Payment Method</td>
        <td class="even">
        <select name="payment_type" onchange="changeMethod(this.value)">
        <option value="C" $selectCash>Cash</option>
        <option value="Q" $selectCheque>Cheque</option>
        </select>
        </td>
        <td class="head">Cheque No</td>
        <td class="even"><input $stylecno maxlength="10" size="10" name="overtime_chequeno" value="$this->overtime_chequeno"></td>
        </tr>

        <tr style="display:none">

        <td class="head">To Account</td>
        <td class="even" colspan="3">$this->toaccountsctrl</td>
        </tr>

        <tr>
        <td class="head">Description</td>
        <td class="even" colspan='3'><textarea name="description" cols="40" rows="3">$this->description</textarea></td>
        </tr>

        <tr>
        <td class="head">Verify By</td>
        <td class="even" colspan='3'>$this->verifyctrl</td>
        </tr>
    </tbody>
  </table>
EOF;
    if ($type!="new"){
    $this->getAlertTable($this->employee_id);
    $this->getSubTable($this->overtime_id);
    }else{
     
    }

echo <<< EOF

<br>
<table astyle="width:150px;"><tbody><td width=1 $this->stylesave>$savectrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form>
    <td width=1 nowrap>

    <input type="button" value="$publishbtn" onclick="overtimeUpdate('issubmit',$this->issubmit)" $this->stylepublish>
    <input type="button" value="$verifybtn" onclick="overtimeUpdate('isverify',$this->isverify)" $this->styleverify>
    <input type="button" value="Complete" onclick="overtimeComplete()" $this->stylecomplete $this->styledisplayadmin>
    <input type="button" value="Re-Enable" onclick="overtimeEnable()" $this->styleenable $this->styledisplayadmin>
    </td>
    <td >$previewctrl</td>
    <td align="right" $this->stylesave>$deletectrl</td>
    </tbody></table>
  <br>

$recordctrl

EOF;
  } // end of member function getInputForm

  public function getAlertTable($employee_id){

    $sqlpaymentline = "coalesce((select sum(d.otapproval_lineamt) as total_2 from $this->tableovertime c, $this->tableovertimeline d
    where c.overtime_id = d.overtime_id
    and d.overtimeline_id = sl.overtimeline_id),0) ";

    $sql = "select a.overtime_id,a.overtime_date,a.overtime_no,sl.overtimeline_totalamt,
    sl.overtimeline_id,sl.overtime_item,
    (sl.overtimeline_totalamt - coalesce(($sqlpaymentline),0)) as balance_amt from $this->tableovertime a, $this->tableovertimeline sl
    where a.employee_id = $employee_id
    and a.overtime_id = sl.overtime_id
    and a.iscomplete = 1
    and (
    (coalesce(($sqlpaymentline),0) ) < sl.overtimeline_totalamt
    )";

    $sqlcnt = "select count(*) as tot_row
    from $this->tableovertime a, $this->tableovertimeline sl
    where a.employee_id = $employee_id
    and a.overtime_id = sl.overtime_id
    and a.iscomplete = 1
    and (
    (coalesce(($sqlpaymentline),0) ) < sl.overtimeline_totalamt
    )";
      
    /*
    $sqlpaymentline = "coalesce((select sum(d.otapproval_lineamt) as total_2 from $this->tableovertime c, $this->tableovertimeline d
    where c.overtime_id = d.overtime_id
    and d.overtime_id = a.overtime_id),0) ";

    $sql = "select a.overtime_id,a.overtime_date,a.overtime_no,a.total_amt,
    (a.total_amt - coalesce(($sqlpaymentline),0)) as balance_amt from $this->tableovertime a
    where a.employee_id = $employee_id
    and a.iscomplete = 0
    and (
    (coalesce(($sqlpaymentline),0) ) < a.total_amt
    )";

    $sqlcnt = "select count(*) tot_row
    from $this->tableovertime a
    where a.employee_id = $employee_id
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

    if($this->otapproval_category == "O")
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

            $overtimeline_id = $row['overtimeline_id'];
            $overtime_id = $row['overtime_id'];
            $overtime_date = $row['overtime_date'];
            $overtime_no = $row['overtime_no'];
            $balance_amt = $row['balance_amt'];
            $overtimeline_totalamt = $row['overtimeline_totalamt'];
            $overtime_item = $row['overtime_item'];


            $totalamt += $overtimeline_totalamt;
            $baltotalamt += $balance_amt;

            if($rowtype=="even")
            $rowtype = "odd";
            else
            $rowtype = "even";


echo <<< EOF
        <input type="hidden" name="overtimeline_idremain[$i]" value="$overtimeline_id">
        <input type="hidden" name="overtime_itemremain[$i]" value="$overtime_item">
        <tr>
        <td class="$rowtype" align="center"><input type="checkbox" name="isselectremain[$i]"></td>
        <td class="$rowtype" align="center">$i</td>
        <td class="$rowtype" align="center"><a title="View This Invoice" target="blank" href="overtime.php?action=edit&overtime_id=$overtime_id">$overtime_no</a></td>
        <td class="$rowtype" align="center">$overtime_item</td>
        <td class="$rowtype" align="center">$overtime_date</td>
        <td class="$rowtype" align="right">$overtimeline_totalamt</td>
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

   public function getSubTable($overtime_id){
        global $ctrl,$dp;
        $widthsubotapproval = "style = 'width:200px' ";

        $sql = "select *
        from $this->tableovertime ot
        inner join $this->tableovertimeline ol on ol.overtime_id = ot.overtime_id
        where ot.overtime_id = $overtime_id ";

        $this->log->showLog(4,"getLecturerTable :" . $sql . "<br>");

        $query=$this->xoopsDB->query($sql);

        //$productctrl = $ctrl->getSelectProduct(0,'Y',"","addsubovertime_id","",'addsubovertime_id',$widthsubotapproval,'Y',0);
        $styleadditem = "";
        $styleinvoice = "";
        if($this->otapproval_category == "I"){
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
        <td nowrap> $otapprovalctrl</td>
        <!--<td align="right"><a>Hide Lecturer >></a></td>-->
        </tr>
        </table>
        </td>
        </tr>

        <tr>
        <th align="left" colspan="4">List Of Overtime Claim</th>
        <th align="right" colspan="5"><input $this->stylesave $styleadditem type="button" name="addSub" value="Add Claim" onclick="checkAddSelect()"></th>

        </tr>
        </tr>
        <tr>
        <th align="center">No</th>
        <th align="center">Date</th>
        <th align="center">Type</th>
        <th align="center">Time In</th>
        <th align="center">Time Out</th>
        <th align="center">Total Hours</th>
        <th align="center" $this->styledisplayadmin>Rate</th>
        <th align="center" $this->styledisplayadmin>Amount (RM)</th>
        <th align="center">Delete</th>
        </tr>
        <input type="hidden" name="addovertime_id" value="0">
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


        $employee_id = $row['employee_id'];
        $overtimeline_id = $row['overtimeline_id'];
        $overtimeline_date = $row['overtimeline_date'];
        $overtime_id = $row['overtime_id'];
        $overtimeline_starttime= $row['overtimeline_starttime'];
        $overtimeline_endtime= $row['overtimeline_endtime'];
        $overtimeline_basicsalary= $row['overtimeline_basicsalary'];
        $overtimeline_totalhour= $row['overtimeline_totalhour'];
        $overtimeline_rate= $row['overtimeline_rate'];
        $overtimeline_type= $row['overtimeline_type'];
        $line_desc = $row['line_desc'];
        $overtime_no = $row['overtime_no'];
        $overtime_date = $row['overtime_date'];
        $overtimeline_totalamt = $row['overtimeline_totalamt'];


        if($styleinvoice != "")
        $balance_amt = "";

        /*
        if($overtime_date == "0000-00-00")
        $overtime_date = "";
        if($overtimeline_totalamt == "0.00")
        $overtimeline_totalamt = "";
         * 
         */
        
        $styleremarks = "style='display:none'";
        if($line_desc != "")
        $styleremarks= "";

        $selectTypeH = "";
        $selectTypeT = "";
        if($overtimeline_type == "T")
        $selectTypeT = "selected";
        else
        $selectTypeH = "selected";

        $datelinectrl=$dp->show("overtimeline_date$i");
echo <<< EOF

        <tr height="3">
        <td></td>
        </tr>
        <tr>
        <input type="hidden" name="overtimeline_id[$i]" value="$overtimeline_id">
        <td class="$rowtype" align="center">$i</td>
        <td class="$rowtype" align="center">
        <input name='overtimeline_date[$i]' id='overtimeline_date$i' value="$overtimeline_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$datelinectrl">
        </td>
        <td class="$rowtype" align="center">
        <select name="overtimeline_type[$i]" id="overtimeline_type$i" onchange="updateRate(this.value,$i,$employee_id)">
        <option value="H" $selectTypeH>By Hours</option>
        <option value="T" $selectTypeT>By Trip</option>
        </select>
        </td>
        <td class="$rowtype" align="center" nowrap><input id = "overtimeline_starttime$i" name="overtimeline_starttime[$i]" value="$overtimeline_starttime" size="5" maxlength="4" onfocus="select()"></td>
        <td class="$rowtype" align="center" nowrap><input id = "overtimeline_endtime$i" name="overtimeline_endtime[$i]" value="$overtimeline_endtime" size="5" maxlength="4" onfocus="select()"></td>
        <td class="$rowtype" align="center" nowrap><input id = "overtimeline_totalhour$i" name="overtimeline_totalhour[$i]" value="$overtimeline_totalhour" size="5" maxlength="10" onfocus="select()" onblur="updateAmount($i)"></td>
        <td class="$rowtype" align="center" $this->styledisplayadmin><input id = "overtimeline_rate$i" name="overtimeline_rate[$i]" value="$overtimeline_rate" size="5" maxlength="10" onfocus="select()" onblur="updateAmount($i)"></td>
        <td class="$rowtype" align="center" $this->styledisplayadmin><input id = "overtimeline_totalamt$i" name="overtimeline_totalamt[$i]" value="$overtimeline_totalamt" size="10" maxlength="11" onfocus="select()" style='text-align:right' onblur="updateTotal()"></td>
        <td class="$rowtype" align="center"><input $this->stylesave type="button" name="btnDeleteLect" value="x" onclick="deleteSubLine($overtimeline_id,$i)"></td>
        </tr>

        <tr>
        <td colspan="9" class="$rowtype">
        <a style="cursor:pointer" onclick="viewRemarkLine($i)">View/Hide Remarks</a>
        <br><textarea name="line_desc[$i]" id="idLineDesc$i" $styleremarks cols="40" rows="4">$line_desc</textarea></td>
        </tr>

EOF;
        }

        if($i==0)
        echo "<tr><td colspan='9' class='odd'><font color='red'>Please Add Overtime Claim.</red></td></tr>";

        
        if($this->styledisplayadmin==""){
        echo "<tr><td colspan='7' class='head' align='right'>Total</td>";
        echo "<td colspan='1' class='head' align='center'><input readonly name='total_amt' style='text-align:right' value='$this->total_amt' size='10' maxlength='11'></td>";
        echo "<td colspan='1' class='head' align='right'></td></tr>";
        }else{
        echo "<input type='hidden' name='total_amt' style='text-align:right' value='$this->total_amt' size='10' maxlength='11'>";
        }
     
        
echo <<< EOF
        </table>
EOF;

  }

  /**
   * Update existing otapproval record
   *
   * @return bool
   * @access public
   */
  public function updateOtapproval( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableovertime SET
	overtime_date='$this->overtime_date',description='$this->description',
	updated='$timestamp',updatedby=$this->updatedby,
    employee_id=$this->employee_id,payment_type='$this->payment_type',
    overtime_chequeno='$this->overtime_chequeno',
    total_amt=$this->total_amt,iscomplete=$this->iscomplete,
    verified_by=$this->verified_by,
	organization_id=$this->organization_id WHERE overtime_id='$this->overtime_id'";
	$this->changesql = $sql;
	$this->log->showLog(3, "Update overtime_id: $this->overtime_id, $this->otapproval_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update otapproval failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update otapproval successfully.");
		return true;
	}
  } // end of member function updateOtapproval

  /**
   * Save new otapproval into database
   *
   * @return bool
   * @access public
   */
  public function insertOtapproval( ) {

    $this->overtime_no = getNewCode($this->xoopsDB,"overtime_no",$this->tableovertime,"");
    $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new otapproval $this->otapproval_name");
 	$sql="INSERT INTO $this->tableovertime
    (overtime_date,overtime_no,
    created,createdby,updated,updatedby,
    employee_id,payment_type,
    overtime_chequeno,period_id,
    organization_id,description,verified_by)
    values(
	'$this->overtime_date','$this->overtime_no',
    '$timestamp',$this->createdby,'$timestamp',$this->updatedby,
    $this->employee_id,'$this->payment_type',
    '$this->overtime_chequeno',$this->period_id,
    $this->organization_id,'$this->description',$this->verified_by)";
    $this->changesql = $sql;
    
	$this->log->showLog(4,"Before insert otapproval SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
        $this->overtime_no ="";
		$this->log->showLog(1,"Failed to insert otapproval code $otapproval_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new otapproval $otapproval_name successfully");
		return true;
	}
  } // end of member function insertOtapproval

  /**
   * Pull data from otapproval table into class
   *
   * @return bool
   * @access public
   */
  public function fetchOtapproval( $overtime_id) {


	$this->log->showLog(3,"Fetching otapproval detail into class Otapproval.php.<br>");
		
	$sql="SELECT *
		 from $this->tableovertime where overtime_id=$overtime_id";
	
	$this->log->showLog(4,"ProductOtapproval->fetchOtapproval, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
        $this->overtime_date=$row["overtime_date"];
        $this->overtime_no=$row["overtime_no"];
        $this->organization_id=$row['organization_id'];
        $this->employee_id= $row['employee_id'];
        $this->period_id= $row['period_id'];
        $this->payment_type= $row['payment_type'];
        $this->iscomplete=$row['iscomplete'];
        $this->description=$row['description'];
        $this->overtime_chequeno=$row['overtime_chequeno'];
        $this->to_accounts=$row['to_accounts'];
        $this->accounts_id=$row['accounts_id'];
        $this->total_amt=$row['total_amt'];
        $this->verified_by=$row['verified_by'];
        $this->verified_date=$row['verified_date'];
        $this->issubmit=$row['issubmit'];
        $this->isverify=$row['isverify'];
        
        $this->batch_id=$row['batch_id'];
        $this->batch_no=$row['batch_no'];
        
        
        //$this->generateovertime_id=$row['generateovertime_id'];


   	$this->log->showLog(4,"Otapproval->fetchOtapproval,database fetch into class successfully");
	$this->log->showLog(4,"otapproval_name:$this->otapproval_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Otapproval->fetchOtapproval,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchOtapproval

  /**
   * Delete particular otapproval id
   *
   * @param int overtime_id
   * @return bool
   * @access public
   */
  public function deleteOtapproval( $overtime_id ) {
    	$this->log->showLog(2,"Warning: Performing delete otapproval id : $overtime_id !");
	$sql="DELETE FROM $this->tableovertime where overtime_id=$overtime_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->changesql = $sql;

    
    
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: otapproval ($overtime_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"otapproval ($overtime_id) removed from database successfully!");

		return true;
		
	}
  } // end of member function deleteOtapproval

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllOtapproval( $wherestring,  $orderbystring,$limitstr="") {
  $this->log->showLog(4,"Running ProductOtapproval->getSQLStr_AllOtapproval: $sql");

    //$wherestring .= $this->wherestremp;
    $sql="select ot.*,em.employee_name,em.employee_no,dp.department_name,dp.department_no,
    pr.period_name
    from $this->tableovertime ot
    inner join $this->tableemployee em on em.employee_id = ot.employee_id
    inner join $this->tabledepartment dp on dp.department_id = em.department_id
    inner join $this->tableperiod pr on pr.period_id = ot.period_id
    $wherestring $orderbystring $limitstr";
    $this->log->showLog(4,"Generate showotapprovaltable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllOtapproval

 public function showOtapprovalTable($wherestring,$orderbystring,$limitstr=""){
	
	$this->log->showLog(3,"Showing Otapproval Table");
	$sql=$this->getSQLStr_AllOtapproval($wherestring,$orderbystring,$limitstr);
	
	$query=$this->xoopsDB->query($sql);

    if($limitstr!=""){
    $records = str_replace("limit","",$limitstr);
    $limitdisplay=" Show Only $records Record(s)";
    }
	echo <<< EOF
    <table>
    <tr>
    <td class="vfocus" width="30px"></td>
    <td>Not Yet Complete (Finance)</td>
    </tr>
    <tr>
    <td class="valert"></td>
    <td>Not Yet Verified (HOD)</td>
    </tr>
    </table>

	<table border='0' cellspacing='3'>
  		<tbody>
<b>$limitdisplay</b>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Doc No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Employee</th>
				<th style="text-align:center;">Employee No</th>
				<th style="text-align:center;">Period</th>
				<th style="text-align:center;">Department</th>
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

        $employee_id=$row['employee_id'];
        $overtime_id=$row['overtime_id'];
        $overtime_no=$row['overtime_no'];
        $employee_name=$row['employee_name'];
        $employee_no=$row['employee_no'];
        $department_name=$row['department_name'];
        $department_no=$row['department_no'];
        $semester_name=$row['semester_name'];
        $year_name=$row['year_name'];
        $session_name=$row['session_name'];
        $total_amt=$row['total_amt'];
        $overtime_date=$row['overtime_date'];
        $isverify=$row['isverify'];
        
        $period_name=$row['period_name'];
        

        $sum_total += $total_amt;
        
		$iscomplete=$row['iscomplete'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

        if($iscomplete == "0")
        $rowtype = "vfocus";
        if($isverify == "0")
        $rowtype = "valert";

        if($iscomplete==0)
        {$iscomplete='N';
        $iscomplete="<b style='color:red;'>N</b>";
        }
        else
        $iscomplete='Y';
        
		echo <<< EOF
        
		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$overtime_no</td>
			<td class="$rowtype" style="text-align:center;">$overtime_date</td>
			<td class="$rowtype" style="text-align:left;"><a target="blank" href="../hr/employee.php?action=view&employee_id=$employee_id">$employee_name</a></td>
			<td class="$rowtype" style="text-align:center;">$employee_no</td>
			<td class="$rowtype" style="text-align:center;" nowrap>$period_name</td>
			<td class="$rowtype" style="text-align:center;">$department_name</td>
			<td class="$rowtype" style="text-align:center;">$total_amt</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
                <table><tr><td>
				<form action="otapproval.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this Overtime'>
				<input type="hidden" value="$overtime_id" name="overtime_id">
				<input type="hidden" name="action" value="edit">
				</form>
                </td>
                <td>
                <img src="images/list.gif" title="Preview Overtime" style="cursor:pointer" onclick="viewOvertime($overtime_id)">
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
        <input type="hidden" name='otapproval_category' value="$this->otapproval_category">
        <input type="hidden" name='payment_type' value="$this->payment_type">

        <textarea name="sqlpost" style="display:none">$sql</textarea>
        <input type="hidden" name="action" value="printpreview">
        <td colspan='10' align="right"><input type="submit" value="Preview" style="display:none"></td>
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
  public function getLatestOtapprovalID() {
	$sql="SELECT MAX(overtime_id) as overtime_id from $this->tableovertime;";
	$this->log->showLog(3,'Checking latest created overtime_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created overtime_id:' . $row['overtime_id']);
		return $row['overtime_id'];
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
	$sql = "select count(*) as rowcount from $this->tabledailyreport where overtime_id = $overtime_id or last_otapproval = $overtime_id or next_otapproval = $overtime_id ";
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
	$this->payment_type = "";
    $this->otapproval_category = "";

    //if($this->start_date=="")
    //$this->start_date = getMonth(date("Ymd", time()),0) ;

   // if($this->end_date=="")
    //$this->end_date = getMonth(date("Ymd", time()),1) ;
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
    if($this->payment_type=="C")
    $selectCash = "SELECTED";
    else if($this->payment_type=="Q")
    $selectCheque = "SELECTED";
    else
    $selectNull = "SELECTED";

    $selectTypeNull="";
    $selectTypeI="";
    $selectTypeO="";
    if($this->otapproval_category=="I")
    $selectTypeI = "SELECTED";
    else if($this->otapproval_category=="O")
    $selectTypeO = "SELECTED";
    else
    $selectTypeNull = "SELECTED";

	//echo $this->iscomplete;

echo <<< EOF
    <form name="frmOtapproval" action="otapproval.php" method="POST">
	</form>
	<form name="frmSearch" action="otapproval.php" method="POST">

	<table>
	<tr>
	<td nowrap><input value="Reset" type="reset">
	<input value="New" type="button" onclick="gotoAction('');"></td>
	</tr>
	</table>

	<table border="0">
	<input name="issearch" value="Y" type="hidden">
	<input name="action" value="search" type="hidden">
	<tr><th colspan="4">Search Personal Overtime Claim Application</th></tr>

    <tr style="display:none">
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
	<td class="head">Doc No</td>
	<td class="even" acolspan="3"><input name="overtime_no" value="$this->overtime_no"></td>
	<td class="head">Employee</td>
	<td class="even">$this->employeectrl</td>
	</tr>

	<tr>
	<td class="head">Employee Name</td>
	<td class="even"><input name="employee_name" value="$this->employee_name"></td>
	<td class="head">Employee No</td>
	<td class="even"><input name="employee_no" value="$this->employee_no"></td>
	</tr>


    <tr>
    <td class="head">Period</td>
    <td class="even" colspan="3">$this->periodctrl</td>
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

  public function showSearchApprovalForm($wherestr){


	if($this->issearch != "Y"){
	$this->quotation_no = "";
	$this->iscomplete = "null";
	$this->payment_type = "";
    $this->otapproval_category = "";

    //if($this->start_date=="")
    //$this->start_date = getMonth(date("Ymd", time()),0) ;

   // if($this->end_date=="")
    //$this->end_date = getMonth(date("Ymd", time()),1) ;
    }


	//iscomplete

	if($this->iscomplete == "1")
	$selectactiveY = "selected = 'selected'";
	else if($this->iscomplete == "0")
	$selectactiveN = "selected = 'selected'";
	else
	$selectactiveL = "selected = 'selected'";


	//echo $this->iscomplete;

echo <<< EOF
    <form name="frmOtapproval" action="otapproval.php" method="POST">
	</form>
	<form name="frmSearchApproval" action="otapproval.php" method="POST">

	<table>
	<tr>
	<td nowrap><input value="Reset" type="reset">
	<input value="Back" type="button" onclick="gotoAction('');"></td>
	</tr>
	</table>

	<table border="0">
	<input name="issearch" value="Y" type="hidden">
	<input name="action" value="searchapproval" type="hidden">
	<tr><th colspan="4">Search Overtime Claim Application (Verify)</th></tr>

    <tr style="display:none">
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
	<td class="head">Doc No</td>
	<td class="even" acolspan="3"><input name="overtime_no" value="$this->overtime_no"></td>
	<td class="head">Employee</td>
	<td class="even">$this->employeectrl</td>
	</tr>

	<tr>
	<td class="head">Employee Name</td>
	<td class="even"><input name="employee_name" value="$this->employee_name"></td>
	<td class="head">Employee No</td>
	<td class="even"><input name="employee_no" value="$this->employee_no"></td>
	</tr>


    <tr>
    <td class="head">Period</td>
    <td class="even" colspan="3">$this->periodctrl</td>
    </tr>

	<tr>
    <td class="head">Is Verified</td>
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

    
	if($this->overtime_no != "")
	$wherestr .= " and ot.overtime_no like '$this->overtime_no' ";
    if($this->employee_id > 0)
	$wherestr .= " and em.employee_id = $this->employee_id ";
    if($this->employee_name != "")
	$wherestr .= " and em.employee_name like '$this->employee_name' ";
    if($this->employee_no != "")
	$wherestr .= " and em.employee_no like '$this->employee_no' ";
    if($this->period_id > 0)
	$wherestr .= " and ot.period_id = $this->period_id ";

	if($this->iscomplete == "0" || $this->iscomplete == "1")
	$wherestr .= " and ot.iscomplete = $this->iscomplete ";

    /*
	if($this->start_date != "" && $this->end_date != "")
	$wherestr .= " and ( ot.overtime_date between '$this->start_date' and '$this->end_date' ) ";
     * 
     */
 

	return $wherestr;

	}

    public function getWhereStrApproval(){

	$wherestr = "";


	if($this->overtime_no != "")
	$wherestr .= " and ot.overtime_no like '$this->overtime_no' ";
    if($this->employee_id > 0)
	$wherestr .= " and em.employee_id = $this->employee_id ";
    if($this->employee_name != "")
	$wherestr .= " and em.employee_name like '$this->employee_name' ";
    if($this->employee_no != "")
	$wherestr .= " and em.employee_no like '$this->employee_no' ";
    if($this->period_id > 0)
	$wherestr .= " and ot.period_id = $this->period_id ";

	if($this->iscomplete == "0" || $this->iscomplete == "1")
	$wherestr .= " and ot.isverify = $this->iscomplete ";

    /*
	if($this->start_date != "" && $this->end_date != "")
	$wherestr .= " and ( ot.overtime_date between '$this->start_date' and '$this->end_date' ) ";
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

    public function addSubLine($overtime_id){
        include_once '../hr/class/Employee.php';
        $emp = new Employee();

        $emp->fetchEmployee($this->employee_id);

        $timestamp= date("y/m/d H:i:s", time()) ;
        $sql = " insert into $this->tableovertimeline
        (employee_id,overtimeline_date,overtime_id,
        overtimeline_rate,overtimeline_basicsalary,
        created,createdby,updated,updatedby)
        values ($this->employee_id,'$timestamp',$overtime_id,
        $emp->employee_othour,$emp->employee_salary,
        '$timestamp',$this->updatedby,'$timestamp',$this->updatedby) ";
        $this->changesql = $sql;
        
        $this->log->showLog(4,"Before insert otapproval addSubLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        return true;
    }

    public function updateSubLine(){
        $timestamp= date("y/m/d H:i:s", time()) ;
        $i=0;
        foreach($this->overtimeline_id as $id){
        $i++;

        $overtimeline_date=$this->overtimeline_date[$i];
        $overtimeline_starttime=$this->overtimeline_starttime[$i];
        $overtimeline_endtime=$this->overtimeline_endtime[$i];
        $overtimeline_totalhour=$this->overtimeline_totalhour[$i];
        $overtimeline_rate=$this->overtimeline_rate[$i];
        $overtimeline_type=$this->overtimeline_type[$i];
        $overtimeline_totalamt=$this->overtimeline_totalamt[$i];                
        $line_desc=$this->line_desc[$i];
        


        $sql = "update $this->tableovertimeline
        set overtimeline_date = '$overtimeline_date',
        overtimeline_starttime = '$overtimeline_starttime',
        overtimeline_endtime = '$overtimeline_endtime',
        overtimeline_totalhour = $overtimeline_totalhour,
        overtimeline_rate = $overtimeline_rate,
        overtimeline_type = '$overtimeline_type',
        overtimeline_totalamt = $overtimeline_totalamt,
        line_desc = '$line_desc'
        where overtimeline_id = $id ";

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert otapproval updateLecturerLine:$sql<br>");
        $rs=$this->xoopsDB->query($sql);

        if (!$rs){
        return false;
        }

        }

        return true;
    }

    public function deleteSubLine($overtimeline_id){

        $sql = "delete from $this->tableovertimeline where overtimeline_id = $overtimeline_id";

        $this->changesql = $sql;

        $this->log->showLog(4,"Before insert otapproval deleteSubLine:$sql<br>");
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

	$sql = "select $primary_key as fld_id,$primary_name as fld_name,employee_no from $table
		where ($primary_name like '%$strchar%' or employee_no like '%$strchar%' ) and $primary_key > 0 $wherestr
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
    $employee_no = $row['employee_no'];

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
	$retval .= "<td>$fld_name ($employee_no)</td>";
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

       $item_line = $this->overtime_itemremain[$i];

            if($this->isselectremain[$i] == "on"){
               $sql = "insert into $this->tableovertimeline
                            (overtimeline_id,overtime_id,otapproval_item) values
                            ($overtimeline_id,$this->overtime_id,'$item_line');";

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
                    total_amt = (select sum(otapproval_lineamt) from $this->tableovertimeline
                    where overtime_id = $overtime_id )
                    where overtime_id = $overtime_id ";
        
        $query=$this->xoopsDB->query($sql);
        if(!$query){
        return false;
        }else{
        return false;
        }
    }

    public function batchAPIPayment($overtime_id){
	global $defaultcurrency_id,$student_account,$student_bpartner;
	/*$api->PostBatch($uid,$date,$systemname,$batch_name,$description,$totaltransactionamt,$documentnoarray,
	$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,$transtypearray,$linetypearray,
	$chequenoarray);*/

	$sql = "select ot.*,sum(otapproval_lineamt) as sum_accounts,
                sl.line_desc,em.employee_name,em.employee_no
                from $this->tableovertime si
                inner join $this->tableovertimeline sl on sl.overtime_id = ot.overtime_id
                inner join $this->tablestudent st on em.employee_id = ot.employee_id
                where ot.overtime_id = $overtime_id
                group by ot.overtime_id
                order by ot.overtime_id ";

	$this->log->showLog(4,"SQL API: $sql");
	$query=$this->xoopsDB->query($sql);
	$return_false = 0;
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){

	//header list
	$date = $row["overtime_date"];
	$systemname = "Finance";
	$batch_name = "Student Payment Batch"." (".$row["employee_no"].")";;
	//$description = $row["descriptions"];
    $description = $row["employee_name"]." (".$row["employee_no"].")";
	$totaltransactionamt = $row["total_amt"];

	if($i == 0){//line type = 0
	$documentnoarray[$i]  = $row["overtime_no"];
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
	$documentnoarray[$i]  = $row["overtime_no"];
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
	$chequenoarray[$i]=$row["overtime_chequeno"];
	$i++;

	if($row["to_accounts"] == 0)//if '0' return false
	$return_false = 1;
	}

	return array($date,$systemname,$batch_name,$description,$totaltransactionamt,$documentnoarray,
	$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,$transtypearray,$linetypearray,
	$chequenoarray,$return_false);

	}

	public function updateBatchInfoPayment($fld,$batch_info,$overtime_id){

	if($batch_info != ""){
	$sql = "update $this->tableovertime set $fld = $batch_info
		where overtime_id = $overtime_id";
	}else{
	$sql = "update $this->tableovertime set batch_id = 0, batch_no = ''
		where overtime_id = $overtime_id";
	}

	$this->log->showLog(4, "SQL get View More");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
	$this->log->showLog(2, "Warning! update batch info failed ($fld):".mysql_error(). ":$sql");
	return false;
	}

	}

    public function updateComplete($iscomplete,$overtime_id){
        $sql = "update $this->tableovertime set iscomplete = $iscomplete where overtime_id = $overtime_id ";
        $this->changesql = $sql;
        $this->log->showLog(4, "SQL updateComplete");

        $rs=$this->xoopsDB->query($sql);
        if(!$rs){
        $this->log->showLog(2, "Warning! update complete status ($fld):".mysql_error(). ":$sql");
        return false;
        }
    }

   public function reactivateOvertime($overtime_id){

	$sql="UPDATE $this->tableovertime set iscomplete=0 where overtime_id=$overtime_id";
	$this->log->showLog(4,"Update reactivateStudentPayment with SQL Statement: $sql");
    $this->changesql = $sql;
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

    public function updateRate($overtimeline_type,$employee_id){

        include_once '../hr/class/Employee.php';
        $emp = new Employee();

        $emp->fetchEmployee($employee_id);

        if($overtimeline_type == "T")
        $overtimeline_rate = $emp->employee_ottrip;
        else
        $overtimeline_rate = $emp->employee_othour;

        return $overtimeline_rate;
    }

    public function overtimeUpdate($overtime_id,$fldnamebtn,$fldnamebtn_id){
         $timestamp= date("y/m/d H:i:s", time()) ;

        if($fldnamebtn_id == 0)
        $fldnamebtn_id = 1;
        else{
        $fldnamebtn_id = 0;
        $timestamp = "0000-00-00";
        }

        if($fldnamebtn == "isverify"){
        $sql = "update $this->tableovertime set $fldnamebtn = $fldnamebtn_id, verified_date = '$timestamp'
        where overtime_id = $overtime_id ";
        }else{
        $sql = "update $this->tableovertime set $fldnamebtn = $fldnamebtn_id
        where overtime_id = $overtime_id ";
        }

        $this->changesql = $sql;
        $query=$this->xoopsDB->query($sql);

        if(!$query){
        return false;
        }else{
        return true;
        }
    }

    public function getTotalVerify($employee_id){

        if($employee_id > 0)
        $wherestr = " and verified_by = $employee_id ";
        
        $sql = "select count(*) as rowcount from $this->tableovertime
        where issubmit = 1 and isverify = 0
        $wherestr";

        $query=$this->xoopsDB->query($sql);

        $rowcnt = 0;
        if ($row=$this->xoopsDB->fetchArray($query)){
            $rowcnt = $row['rowcount'];
        }

        return $rowcnt;
    }

} // end of ClassOtapproval
?>

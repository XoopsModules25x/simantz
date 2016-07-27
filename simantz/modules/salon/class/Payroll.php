<?php
/************************************************************************
 Class Payroll.php - Copyright kfhoo
**************************************************************************/

class Payroll
{

  public $payroll_id;

  public $payroll_no;
  public $employee_id;
  public $payroll_date;
  public $payroll_monthof;
  public $payroll_yearof;
  public $payroll_value_ot1;
  public $payroll_value_ot2;
  public $payroll_value_ot3;
  public $payroll_value_ot4;
  public $payroll_qty_ot1;
  public $payroll_qty_ot2;
  public $payroll_qty_ot3;
  public $payroll_qty_ot4;
  public $payroll_amt_ot1;
  public $payroll_amt_ot2;
  public $payroll_amt_ot3;
  public $payroll_amt_ot4;
  public $payroll_qty_ul;
  public $payroll_qty_sl;
  public $payroll_qty_al;
  public $payroll_qty_el;
  public $payroll_amt_ul;
  public $payroll_amt_sl;
  public $payroll_amt_al;
  public $payroll_amt_el;
  public $payroll_amt_comm;
  public $payroll_amt_allowance1;
  public $payroll_amt_allowance2;
  public $payroll_amt_allowance3;
  public $payroll_socsoemployee;
  public $payroll_socsoemployer;
  public $payroll_epfemployee;
  public $payroll_epfemployer;
  public $payroll_totalamount;
  public $payroll_epfbase;
  public $payroll_socsobase;
  public $payroll_basicsalary;
  public $start_date;
  public $end_date;
  public $employeename;

  public $leaveline_id;
  public $leaveline_qty;
  public $leaveline_amount;

  public $allowanceline_id;
  public $allowancepayroll_id;
  public $allowancepayroll_amount;

  
  public $remarks;
  public $payroll_remarks2;
  public $isactive;
  public $issocsoot;
  public $isepfot;
  public $iscomplete;
  public $organization_id;
  public $created;
  public $cur_name;
  public $cur_symbol;
  public $createdby;
  public $updated;
  public $isAdmin;
  public $orgctrl;
  public $employeectrl;
  public $updatedby;
  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $tablepayroll;
  private $tableproduct;
  private $tableproductcategory;
  private $tablecustomer;
  private $tableemployee;
  private $tablecommission;
  private $tablesales;
  private $tablesalesline;
  private $tablesalesemployeeline;
  private $tableleaveline;
  private $tablelesocso;
  private $tableepf;
  private $tableleave;
  private $tableallowancepayroll;
  private $tableallowanceline;

  private $log;

  public $fldShow;


//constructor
   public function Payroll($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simsalon_organization";
	$this->tablepayroll=$tableprefix . "simsalon_payroll";
	$this->tableproduct=$tableprefix . "simsalon_productlist";
	$this->tableproductcategory=$tableprefix . "simsalon_productcategory";
	$this->tablecustomer=$tableprefix . "simsalon_customer";
	$this->tableemployee=$tableprefix . "simsalon_employee";
	$this->tablesales=$tableprefix . "simsalon_sales";
	$this->tablesalesline=$tableprefix . "simsalon_salesline";
	$this->tablesalesemployeeline=$tableprefix . "simsalon_salesemployeeline";
	$this->tablecommission=$tableprefix . "simsalon_commission";
	$this->tableepf=$tableprefix . "simsalon_epftable";
	$this->tablesocso=$tableprefix . "simsalon_socsotable";
	$this->tableleaveline=$tableprefix . "simsalon_leaveline";
	$this->tableleave=$tableprefix . "simsalon_leave";
	$this->tableallowancepayroll=$tableprefix . "simsalon_allowancepayroll";
	$this->tableallowanceline=$tableprefix . "simsalon_allowanceline";


	$this->log=$log;
   }


  public function getInputForm( $type,  $payroll_id,$token  ) {
	

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$completectrl="";
	$deletectrl="";
	$itemselect="";
	$stylenone = "";
	$orgctrl="";
	$this->created=0;
	$timestamp= date("Y-m-d", time()) ;
		


	if ($type=="new"){
		$header="New Payroll";
		$action="create";
		$btnsave = "Next";
		$this->payroll_date = $timestamp;
		$this->payroll_yearof = substr($timestamp,0,4);
		$this->payroll_monthof = substr($this->payroll_date,5,2);
		$styleamount = "style='display:none'";
		$this->payroll_remarks2 = "If you have any queries for the above payroll, please clarify with HR within 7 days after received this payslip";

		$this->payroll_value_ot1='1.0';
		$this->payroll_value_ot2='1.5';
		$this->payroll_value_ot3='2.0';
		$this->payroll_value_ot4='3.0';
		$this->payroll_qty_ot1='0';
		$this->payroll_qty_ot2='0';
		$this->payroll_qty_ot3='0';
		$this->payroll_qty_ot4='0';
		$this->payroll_amt_ot1='0';
		$this->payroll_amt_ot2='0';
		$this->payroll_amt_ot3='0';
		$this->payroll_amt_ot4='0';
		$this->payroll_qty_ul='0';
		$this->payroll_qty_sl='0';
		$this->payroll_qty_al='0';
		$this->payroll_qty_el='0';
		$this->payroll_amt_ul='0';
		$this->payroll_amt_sl='0';
		$this->payroll_amt_al='0';
		$this->payroll_amt_el='0';
		$this->payroll_amt_comm='0';
		$this->payroll_amt_allowance1='0';
		$this->payroll_amt_allowance2='0';
		$this->payroll_amt_allowance3='0';
		$this->payroll_socsoemployee='0';
		$this->payroll_socsoemployer='0';
		$this->payroll_epfemployee='0';
		$this->payroll_epfemployer='0';
		$this->payroll_totalamount='0';
		$this->payroll_epfbase='0';
		$this->payroll_socsobase='0';
		$this->payroll_basicsalary='0';
	 	
		if($payroll_id==0){
			$this->payroll_no="";
			$this->payroll_description="";
			$this->remarks="";
			$this->isactive="";
		}
		$savectrl="<input style='height: 40px;' name='btnSave' value='$btnsave' type='submit'>";
		
		$savectrl2="<input style='height: 40px;' name='btnSave2' value='$btnsave' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectService="";
		$selectProduct="";
		
		$this->payroll_no = getNewCode($this->xoopsDB,"payroll_no",$this->tablepayroll);
		
		
	}
	else
	{
		$selectStock="";
		$selectService="";
		$selectProduct="";
		$styleamount = "";
		$stylenone = "style='display:none'";
		
		
		if ($this->iscomplete=='Y'){
			$checked2="CHECKED";
			$btnsave = "Complete";
		}else{
			$checked2="";
			$btnsave = "Save";
		}

		$action="update";
		$savectrl="<input name='payroll_id' value='$this->payroll_id' type='hidden'>".
			 "<input style='height: 40px;' name='btnSave' value='$btnsave' type='submit'>";
		$savectrl2="<input name='payroll_id' value='$this->payroll_id' type='hidden'>".
			 "<input style='height: 40px;' name='btnSave2' value='$btnsave' type='submit'>";
		$completetrl="<input name='payroll_id' value='$this->payroll_id' type='hidden'>".
			 "<input style='height: 40px;' name='btnComplete' value='Complete' type='submit' onclick='document.frmPayroll.iscomplete.checked = true;'>";
		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablepayroll' type='hidden'>".
		"<input name='id' value='$this->payroll_id' type='hidden'>".
		"<input name='idname' value='payroll_id' type='hidden'>".
		"<input name='title' value='Payroll' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		

		$header="Edit Payroll";
		
		if($this->allowDelete($this->payroll_id) && $this->payroll_id>0)
		$deletectrl="<FO$this->cur_symbol action='payroll.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this payroll?"'.")'><input type='submit' value='Delete' name='btnDelete' style='height:40px;'>".
		"<input type='hidden' value='$this->payroll_id' name='payroll_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='payroll.php' method='POST'><input name='btnAdd' value='New' type='submit' style='height:40px;'></form>";
	}

	$monthvalue = array(1=>"01",2=>"02",3=>"03",4=>"04",5=>"05",6=>"06",7=>"07",8=>"08",9=>"09",10=>"10",11=>"11",12=>"12");
	$monthname = array(1=>"January",2=>"February",3=>"March",4=>"April",5=>"May",6=>"June",7=>"July",8=>"August",9=>"September",10=>"October",11=>"November",12=>"December");

	$mth = (int)$this->payroll_monthof;
    echo <<< EOF

<table border=0 style="width:10px;"><tbody>$recordctrl<tbody><tr><td nowrap>$addnewctrl</td><td nowrap>$deletectrl</td>

<form name="frmDumm" method="POST" action="payroll.php">
<input type="hidden" name="payroll_id" value="$this->payroll_id">
<input type="hidden" name="action" value="">
</form>


<td nowrap>
	<form onsubmit="return validatePayroll()" method="post" action="payroll.php" name="frmPayroll">
	<input name="reset" value="Reset" type="reset" style='height:40px;'>
	<input type="hidden" name="payroll_idx" value="$this->payroll_id">
	<input name="btnSearch" value="Search" type="button" onclick="showSearch();" style='height:40px;'></td></tr></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="6" rowspan="1">$header</th>
      </tr>
       
      	<tr>
        	<td class="head">Payroll No</td>
        	<td class="even" colspan="2"><input maxlength="10" size="10" name="payroll_no" value="$this->payroll_no">
		<A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
		<td class="head">Employee</td>
        	<td class="even" colspan="2"><div $stylenone>$this->employeectrl</div>$this->employeename</td>
      	</tr>


	<tr>
		<td class="head">Date</td>
		<td class="odd" colspan="2">
		<input name='payroll_date' id='payroll_date' value="$this->payroll_date" maxlength='10' size='10'>
        	<input name='btnDate' value="Date" type="button" onclick="$this->datectrl">
		</td>

		<td class="head">Payroll Statement</td>
		<td class="odd" colspan="2">
		Month :
		<div $stylenone><select name="payroll_monthof" onchange="getAllowance(document.frmPayroll.employee_id.value)">
EOF;
		$i = 0;
		foreach($monthvalue as $val) {
		$i++;
		$month = $monthname[$i];
		$monthval = $monthvalue[$i];
		
		if($type=="new"){
		$monthname2 = "";
		$payroll_yearof1 = "";
		}else{
		$monthname2 = $month;
		$payroll_yearof1 = $this->payroll_yearof;
		}
		
		if($this->payroll_monthof==$monthval)
		$selected='SELECTED="SELECTED"';
		else
		$selected = "";

		if($type!="new"){
		$monthval = $this->payroll_monthof;
		$monthname2 = $monthname[$mth];
		}
		
		
echo <<< EOF
		<option value="$monthval" $selected>$month</option>
EOF;
		
		}

		
echo <<< EOF
		</select></div><b>$monthname2</b>

		Year : <div $stylenone><input name='payroll_yearof' value="$this->payroll_yearof" maxlength='4' size='4' onblur="getAllowance(document.frmPayroll.employee_id.value)"></div><b>$payroll_yearof1</b>
		</td>
	</tr>

	<tr>
		<td class="head">Remarks</td>
		<td class="even" colspan="5"><textarea name="remarks" cols="80" rows="1">$this->remarks</textarea></td>
	</tr>
	<tr style="display:none">
		<td class="head">Complete</td>
		<td class="odd" colspan="5">
		<A>     </A> Complete<input type="checkbox" $checked2 name="iscomplete" aonclick="completePayroll(this.checked)"></td>
	</tr>

    </tbody>
  </table>
<br>
$savectrl $completetrl
<br>
<br>
EOF;



$this->showDetailsForm($type,$styleamount);

if ($type=="new")
$savectrl2 = "";

echo <<< EOF
<table astyle="width:300px;" border=1 $styleamount>
	<tr >
		<td class="head" width="10%" nowrap>Total Amount ($this->cur_symbol)</td>
		<td class="odd" width="90%" align=left><input maxlength="10" size="10" name="payroll_totalamount" value="$this->payroll_totalamount"> 
		</td>
	</tr>
	<tr>
		<td class="odd" width="100%" align=left colspan="2"><input maxlength="255" size="140" name="payroll_remarks2" value="$this->payroll_remarks2"> 
		</td>
	</tr>
</table>
<table style="width:150px;"><tbody><td>$savectrl2  $completetrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</tbody></table></form>
EOF;

	if ($type != "new")
	$this->getCommissionDetails();

  } // end of member function getInputForm


  public function showDetailsForm($type,$styleamount){
	
	$onblur =  "onblur='getAmount(this.name);'";

	$basic_salary = $this->getEmployeeDetail($this->employee_id,"basic_salary");

	$stylerm = "style='text-align:right'";

	$totalot = $this->payroll_amt_ot1 + $this->payroll_amt_ot2 + $this->payroll_amt_ot3 + $this->payroll_amt_ot4;

	$totalot = number_format($totalot, 2, '.','');

	
	$checkedot1 = "";
	$checkedot2 = "";

	if($this->issocsoot == "Y")
	$checkedot1 = "checked";
	if($this->isepfot == "Y")
	$checkedot2 = "checked";

echo <<< EOF
	<table  border=1 abgcolor="#b2d9ac" cellpadding="0" cellspacing="3" $styleamount>
	<tr>
		<th width="38%">INCOME</th>
		<th width="38%">DEDUCTION</th>
		<th width="24%">OTHERS</th>
	</tr>
		
	<tr>
		<td><!--INCOME-->
			<table border=1>
			<tr>
			<td class="odd">Basic Pay</td>
			<td align="right" class="odd">
			<input name="payroll_basicsalary" value="$this->payroll_basicsalary" size="10" maxlength="10" readonly $stylerm>
			</td>
			</tr>
			<tr>
			<td class="even">Commission</td>
			<td align="right" class="even"><input name="payroll_amt_comm" value="$this->payroll_amt_comm" size="10" maxlength="10" $onblur $stylerm></td>
			</tr>
			<tr>
			<td class="head" colspan="2">
				<table border='0' cellspacing='3'>
				<tbody>	
				
				<tr><!--Over Time-->
					<td style="text-align:left;" colspan="4" class="head" >Over Time</td>
				</tr>
				<tr>
					<th style="text-align:center;" width="5%">No</th>
					<th style="text-align:left;" width="55%">Type</th>
					<th style="text-align:center;" width="20%">Hours</th>
					<th style="text-align:center;" width="20%">Amount</th>
				</tr>
				<tr>
					<td align=center class="odd">1</td>
					<td align=left class="odd"><input name="payroll_value_ot1" value="$this->payroll_value_ot1" maxlength="4" size="3" $onblur></td>
					<td align=center class="odd"><input name="payroll_qty_ot1" value="$this->payroll_qty_ot1" maxlength="5" size="3" $onblur></td>
					<td align=center class="odd"><input name="payroll_amt_ot1" value="$this->payroll_amt_ot1" size="10" $onblur $stylerm></td>
				</tr>
				<tr>
					<td align=center class="even">2</td>
					<td align=left class="even"><input name="payroll_value_ot2" value="$this->payroll_value_ot2" maxlength="4" size="3" $onblur></td>
					<td align=center class="even"><input name="payroll_qty_ot2" value="$this->payroll_qty_ot2" maxlength="5" size="3" $onblur></td>
					<td align=center class="even"><input name="payroll_amt_ot2" value="$this->payroll_amt_ot2" size="10" $onblur $stylerm></td>
				</tr>
				<tr>
					<td align=center class="odd">3</td>
					<td align=left class="odd"><input name="payroll_value_ot3" value="$this->payroll_value_ot3" maxlength="4" size="3" $onblur></td>
					<td align=center class="odd"><input name="payroll_qty_ot3" value="$this->payroll_qty_ot3" maxlength="5" size="3" $onblur></td>
					<td align=center class="odd"><input name="payroll_amt_ot3" value="$this->payroll_amt_ot3" size="10" $onblur $stylerm></td>
				</tr>
				<tr>
					<td align=center class="even">4</td>
					<td align=left class="even"><input name="payroll_value_ot4" value="$this->payroll_value_ot4" maxlength="4" size="3" $onblur></td>
					<td align=center class="even"><input name="payroll_qty_ot4" value="$this->payroll_qty_ot4" maxlength="5" size="3" $onblur></td>
					<td align=center class="even"><input name="payroll_amt_ot4" value="$this->payroll_amt_ot4" size="10" $onblur $stylerm></td>
				</tr>

				<tr>
					<td align=right class="odd" colspan="4">
					SOCSO <input type="checkbox" name="issocsoot" $checkedot1 onclick="updateBase(document);">
					EPF <input type="checkbox" name="isepfot" $checkedot2 onclick="updateBase(document);">
					<input name="payroll_amt_totalot" value="$totalot" size="10" $stylerm readonly >
					</td>
				</tr>
				<tr style="display:none">
				<td><input type="checkbox" name="checkboxDUMM" checked onclick="updateBase(document);"></td>
				</tr>
				</tbody>
				</table>
			</td>
			</tr>
			<tr>
			<td class="head" colspan="2"><iframe src="../allowancefrm.php?payroll_id=$this->payroll_id" height="170" width="100%" frameborder=0></iframe></td>
			</tr>
			</table>
		</td>
	
		<td><!--DEDUCTION-->
			<table border=1>
			<tr>
			<td class="odd">EPF for Employee</td>
			<td align="right" class="odd"><input name="payroll_epfemployee" size="10" maxlength="10" value="$this->payroll_epfemployee" $onblur $stylerm></td>
			</tr>
			<tr>
			<td class="even">SOCSO for Employee</td>
			<td align="right" class="even"><input name="payroll_socsoemployee" size="10" maxlength="10" value="$this->payroll_socsoemployee" $onblur $stylerm></td>
			</tr>
			<tr>
			<td class="head" colspan="2"><iframe src="../leavefrm.php?payroll_id=$this->payroll_id" height="250" width="100%" frameborder=0></iframe></td>
			</tr>
			</table>
		</td>

		<td><!--OTHERS-->
			<table border=1>
			<tr>
			<td class="odd">EPF for Employer</td>
			<td align="right" class="odd"><input name="payroll_epfemployer" size="6" maxlength="10" value="$this->payroll_epfemployer" $onblur $stylerm></td>
			</tr>
			<tr>
			<td class="even">SOCSO for Employer</td>
			<td align="right" class="even"><input name="payroll_socsoemployer" size="6" maxlength="10" value="$this->payroll_socsoemployer" $onblur $stylerm></td>
			</tr>
			<tr>
			<td class="odd">EPF (BASE)</td>
			<td align="right" class="odd"><input name="payroll_epfbase" size="6" maxlength="10" value="$this->payroll_epfbase" $onblur $stylerm readonly></td>
			</tr>
			<tr>
			<td class="even">SOCSO (BASE)</td>
			<td align="right" class="even"><input name="payroll_socsobase" size="6" maxlength="10" value="$this->payroll_socsobase" $stylerm readonly></td>
			</tr>
			</table>
		</td>
	</tr>

	</table>
EOF;

  }
  
    public function getCommissionDetails(){
	
	$YMD = $this->payroll_yearof.$this->payroll_monthof."01";

	$totalamount = 0;
	$totalamountfinal = 0;
	
	$start_date = getMonth($YMD,0) ;
	$end_date = getMonth($YMD,1) ;
	
	//Y = others, N = product, C = service
  	$retval = "0.00";
 	$sql = "select *  
		from $this->tablesales a, $this->tablesalesline b, $this->tablesalesemployeeline c, 
		$this->tableproduct d, $this->tableproductcategory e
		where a.sales_id = b.sales_id and b.salesline_id = c.salesline_id and a.iscomplete = 'Y' and a.isactive = 'Y' 
		and b.product_id = d.product_id and d.category_id = e.category_id  
		and a.sales_date between '$start_date' and '$end_date' 
		and c.employee_id = $this->employee_id 
		order by sales_date ";//sum total amount

	$this->log->showLog(4,"SQL:$sql");
	
	$i = 0;

	$query=$this->xoopsDB->query($sql);
	
	
echo <<< EOF
	<br>
	<table border="1">
		<tr>
			<td class="head" colspan="7">Commission</td>
		</tr>
		<tr align="center">
			<th>No</th>
			<th>Date</th>
			<th>Type</th>
			<th>Description</th>
			<th>Sales Amount ($this->cur_symbol)</th>
			<th>Commission (%)</th>
			<th>Amount ($this->cur_symbol)</th>
		</tr>
EOF;
	
	$tot_service = 0;
	$tot_product = 0;
	$tot_others = 0;

	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$sales_date = $row['sales_date'];
	$salesline_amount = $row['salesline_amount'];
	$percent = $row['percent'];
	$product_name = $row['product_name'];
	$isitem = $row['isitem'];
	
	$totamount = ($percent/100)*$salesline_amount;


	if($isitem=="C"){
	$type = "S";
	$type_name = "Service";
	$tot_service += $totamount;
	}else if($isitem=="N"){
	$type = "P";
	$tot_product += $totamount;
	$type_name = "Product";
	}else{
	$type = "O";
	$tot_others += $totamount;
	$type_name = "Others";
	}
	
	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";
		
	$totamount = number_format($totamount, 2, '.','');
	
echo <<< EOF
	
		<tr align=center>
			<td class=$rowtype>$i</td>
			<td class=$rowtype>$sales_date</td>
			<td class=$rowtype>$type_name</td>			
			<td class=$rowtype>$product_name</td>						
			<td class=$rowtype>$salesline_amount</td>						
			<td class=$rowtype>$percent</td>									
			<td class=$rowtype>$totamount</td>									
		</tr>
EOF;
	}
		
		
		$totcommission_service = $this->calculateCommissionType($tot_service,"S");	
		$totcommission_product = $this->calculateCommissionType($tot_product,"P");	
		$totcommission_others = $this->calculateCommissionType($tot_others,"O");	
		
		$totcommission = $totcommission_service + $totcommission_product + $totcommission_others;
		
		$totcommission = number_format($totcommission, 2, '.','');
				
		$tot_service = number_format($tot_service, 2, '.','');
		$tot_product = number_format($tot_product, 2, '.','');
		$tot_others = number_format($tot_others, 2, '.','');	
		
		
echo <<< EOF

	<tr>
			<td class="head" colspan="7">
			<table style="width:150px">
			<tr>
			<td nowrap>Total Service</td>
			<td nowrap>: $this->cur_symbol $tot_service &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td nowrap>Commission</td>
			<td nowrap>: $this->cur_symbol $totcommission_service</td>
			</tr>
			<tr>
			<td nowrap>Total Product</td>
			<td nowrap>: $this->cur_symbol $tot_product</td>
			<td nowrap>Commission</td>
			<td nowrap>: $this->cur_symbol $totcommission_product</td>
			</tr>
			<tr>
			<td nowrap>Total Others</td>
			<td nowrap>: $this->cur_symbol $tot_others</td>
			<td nowrap>Commission</td>
			<td nowrap>: $this->cur_symbol $totcommission_others</td>
			</tr>
			<tr height="5">
			</td><td>
			</tr>
			<tr>
			<td nowrap colspan="3" align="right">Total Commission</td>
			<td nowrap>: $this->cur_symbol $totcommission</td>
			</tr>
			</table>
			
			</td>
	</tr>
	</table>
EOF;
	
	}
	
	public function calculateCommissionType($total,$type){
	
	$totalamount = 0;
	// get commission percent
	$sql = "select (commission_percent/100*$total) as total from $this->tablecommission a 
	where ($total between a.commission_amount and a.commission_amountmax) 
	and a.commission_type = '$type' ";//compare with commission table

	$this->log->showLog(4,"SQL:$sql");
	
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$totalamount = $row['total'];
	
	if($totalamount=="")
	$totalamount = 0;
	
	}
	
	$totalamount = number_format($totalamount, 2, '.','');
			
	return	$totalamount;
	}

  public function showDetailsForm2($type,$styleamount){
	$styletr1 = "";
	$styletr2 = "";
	$styletr3 = "";
	$basic_salary = "0.00";

	if($type=="new"){
	$styletr1 = "'style=display:none'";
	$styletr2 = "'style=display:none'";
	$styletr3 = "'style=display:none'";

	}else{
	
	

	if($allowance_name1=="")
	$styletr1 = "'style=display:none'";
	if($allowance_name2=="")
	$styletr2 = "'style=display:none'";
	if($allowance_name3=="")
	$styletr3 = "'style=display:none'";

	$basic_salary = $this->getEmployeeDetail($this->employee_id,"basic_salary");
		
	}

	$onblur =  "onblur='getAmount(this.name);'";

echo <<< EOF

	<table $styleamount>
	<tr>
	<td>

	<table border='0' cellspacing='3'>
	<tbody>	
	<br>
	<tr><!--Basic Salary-->
		<td style="text-align:left;" class="head" colspan="4"><div id=basicSalary>Basic Salary : $this->cur_symbol $basic_salary</div></td>
	</tr>

	<tr>
	<th colspan="4">EPF/SOCSO</th>
	</tr>

	<tr><!--Socso employee-->
		<td class="head" rowspan="2">1</td>
		<td class="head" rowspan="2">Employee</td>
		<td style="text-align:left;" class="head">Socso ($this->cur_symbol)</td>
		<td style="text-align:center;" class="odd"><input name="payroll_socsoemployee" size="10" maxlength="10" value="$this->payroll_socsoemployee" $onblur></td>
		
	</tr>

	<tr><!--EPF employee-->
		<td style="text-align:left;" class="head">EPF ($this->cur_symbol)</td>
		<td style="text-align:center;" class="even"><input name="payroll_epfemployee" size="10" maxlength="10" value="$this->payroll_epfemployee" $onblur></td>
		
	</tr>

	<tr><!--Socso employerr-->
		<td class="head" rowspan="2">2</td>
		<td class="head" rowspan="2">Employer</td>
		<td style="text-align:left;" class="head">Socso ($this->cur_symbol)</td>
		<td style="text-align:center;" class="odd"><input name="payroll_socsoemployer" size="10" maxlength="10" value="$this->payroll_socsoemployer" $onblur></td>
		
	</tr>

	<tr><!--EPF employerr-->
		<td style="text-align:left;" class="head">EPF ($this->cur_symbol)</td>
		<td style="text-align:center;" class="even"><input name="payroll_epfemployer" size="10" maxlength="10" value="$this->payroll_epfemployer" $onblur></td>
		
	</tr>
	</tbody>
	</table>
	</td>

	<td>
	<table border='0' cellspacing='3'>
	<tbody>	
	<tr height="15"></tr>
	<tr><!--Over Time-->
		<td style="text-align:left;" colspan="4" class="head" >Over Time</td>
	</tr>
	<tr>
		<th style="text-align:center;" width="5%">No</th>
		<th style="text-align:left;" width="55%">Type</th>
		<th style="text-align:center;" width="20%">Hours</th>
		<th style="text-align:center;" width="20%">Amount ($this->cur_symbol)</th>
	</tr>
	<tr>
		<td align=center class="odd">1</td>
		<td align=left class="odd"><input name="payroll_value_ot1" value="$this->payroll_value_ot1" maxlength="4" size="3" $onblur></td>
		<td align=center class="odd"><input name="payroll_qty_ot1" value="$this->payroll_qty_ot1" maxlength="5" size="3" $onblur></td>
		<td align=center class="odd"><input name="payroll_amt_ot1" value="$this->payroll_amt_ot1" size="10" $onblur></td>
	</tr>
	<tr>
		<td align=center class="even">2</td>
		<td align=left class="even"><input name="payroll_value_ot2" value="$this->payroll_value_ot2" maxlength="4" size="3" $onblur></td>
		<td align=center class="even"><input name="payroll_qty_ot2" value="$this->payroll_qty_ot2" maxlength="5" size="3" $onblur></td>
		<td align=center class="even"><input name="payroll_amt_ot2" value="$this->payroll_amt_ot2" size="10" $onblur></td>
	</tr>
	<tr>
		<td align=center class="odd">3</td>
		<td align=left class="odd"><input name="payroll_value_ot3" value="$this->payroll_value_ot3" maxlength="4" size="3" $onblur></td>
		<td align=center class="odd"><input name="payroll_qty_ot3" value="$this->payroll_qty_ot3" maxlength="5" size="3" $onblur></td>
		<td align=center class="odd"><input name="payroll_amt_ot3" value="$this->payroll_amt_ot3" size="10" $onblur></td>
	</tr>
	<tr>
		<td align=center class="even">4</td>
		<td align=left class="even"><input name="payroll_value_ot4" value="$this->payroll_value_ot4" maxlength="4" size="3" $onblur></td>
		<td align=center class="even"><input name="payroll_qty_ot4" value="$this->payroll_qty_ot4" maxlength="5" size="3" $onblur></td>
		<td align=center class="even"><input name="payroll_amt_ot4" value="$this->payroll_amt_ot4" size="10" $onblur></td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>


	<tr>
	<td>
EOF;
	$this->getTableLeave();

	$total_allowance = $this->getTotalAllowance();

echo <<< EOF
	
	</td>
	
	<td>
	<input type="hidden" name="total_allowance" value="$total_allowance">
EOF;
	echo "<div id='allowanceTblID'>";
	$this->getTableAllowance();
	echo "</div>";

echo <<< EOF
	</td>
	</tr>


	<tr>
	<td acolspan="2">
	<table border='0' cellspacing='3'>
	<tbody>	
	
	<tr height="15"></tr>
	<tr><!--Commission-->
		<td style="text-align:left;" colspan="4" class="head">Commission ($this->cur_symbol)</td>
	</tr>
	<tr style="display:none">
		<th style="text-align:left;"></th>
	</tr>
	<tr>
		
		<td align=left class="odd"><input name="payroll_amt_comm" value="$this->payroll_amt_comm" size="10" maxlength="10" $onblur></td>
	</tr>

	</tbody>
	</table>
	</td>
	</tr>

	</table>
	
EOF;

  }


  public function updatePayroll( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql = 	"UPDATE $this->tablepayroll SET
		payroll_no='$this->payroll_no',
		employee_id=$this->employee_id,
		payroll_date='$this->payroll_date',
		payroll_remarks2='$this->payroll_remarks2',
		payroll_monthof='$this->payroll_monthof',
		payroll_yearof=$this->payroll_yearof,
		payroll_value_ot1=$this->payroll_value_ot1,
		payroll_value_ot2=$this->payroll_value_ot2,
		payroll_value_ot3=$this->payroll_value_ot3,
		payroll_value_ot4=$this->payroll_value_ot4,
		payroll_qty_ot1=$this->payroll_qty_ot1,
		payroll_qty_ot2=$this->payroll_qty_ot2,
		payroll_qty_ot3=$this->payroll_qty_ot3,
		payroll_qty_ot4=$this->payroll_qty_ot4,
		payroll_amt_ot1=$this->payroll_amt_ot1,
		payroll_amt_ot2=$this->payroll_amt_ot2,
		payroll_amt_ot3=$this->payroll_amt_ot3,
		payroll_amt_ot4=$this->payroll_amt_ot4,
		payroll_amt_comm=$this->payroll_amt_comm,
		payroll_socsoemployee=$this->payroll_socsoemployee,
		payroll_socsoemployer=$this->payroll_socsoemployer,
		payroll_epfemployee=$this->payroll_epfemployee,
		payroll_epfemployer=$this->payroll_epfemployer,
		payroll_totalamount=$this->payroll_totalamount,
		payroll_epfbase=$this->payroll_epfbase,
		payroll_socsobase=$this->payroll_socsobase,
		payroll_basicsalary=$this->payroll_basicsalary,
		remarks='$this->remarks',

		updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',issocsoot='$this->issocsoot',
		isepfot='$this->isepfot', iscomplete='$this->iscomplete'
		WHERE payroll_id='$this->payroll_id'";
	
	$this->log->showLog(3, "Update payroll_id: $this->payroll_id, $this->payroll_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update payroll failed");
		return false;
	}
	else{
		//$this->updateLeave();
		//$this->updateAllowance();
		$this->log->showLog(3, "Update payroll successfully.");
		return true;
	}
  } // end of member function updatePayroll


  public function insertPayroll( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new payroll $this->payroll_no");
 	$sql = "INSERT INTO $this->tablepayroll (
					payroll_no,
					employee_id,
					payroll_date,
					payroll_monthof,
					payroll_yearof,
					payroll_value_ot1,
					payroll_value_ot2,
					payroll_value_ot3,
					payroll_value_ot4,
					payroll_qty_ot1,
					payroll_qty_ot2,
					payroll_qty_ot3,
					payroll_qty_ot4,
					payroll_amt_ot1,
					payroll_amt_ot2,
					payroll_amt_ot3,
					payroll_amt_ot4,
					payroll_amt_comm,
					payroll_socsoemployee,
					payroll_socsoemployer,
					payroll_epfemployee,
					payroll_epfemployer,
					payroll_totalamount,
					payroll_epfbase,
					payroll_socsobase,
					payroll_basicsalary,
					remarks,
					payroll_remarks2,
					iscomplete,isactive,issocsoot,isepfot, created,createdby,updated,updatedby) values(
					'$this->payroll_no',
					$this->employee_id,
					'$this->payroll_date',
					'$this->payroll_monthof',
					$this->payroll_yearof,
					$this->payroll_value_ot1,
					$this->payroll_value_ot2,
					$this->payroll_value_ot3,
					$this->payroll_value_ot4,
					$this->payroll_qty_ot1,
					$this->payroll_qty_ot2,
					$this->payroll_qty_ot3,
					$this->payroll_qty_ot4,
					$this->payroll_amt_ot1,
					$this->payroll_amt_ot2,
					$this->payroll_amt_ot3,
					$this->payroll_amt_ot4,
					$this->payroll_amt_comm,
					$this->payroll_socsoemployee,
					$this->payroll_socsoemployer,
					$this->payroll_epfemployee,
					$this->payroll_epfemployer,
					$this->payroll_totalamount,
					$this->payroll_epfbase,
					$this->payroll_socsobase,
					$this->payroll_basicsalary,
					'$this->remarks',
					'$this->payroll_remarks2',
					'$this->iscomplete','$this->isactive','$this->issocsoot','$this->isepfot',
					'$timestamp',$this->createdby,'$timestamp',$this->updatedby)";
	$this->log->showLog(4,"Before insert payroll SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert payroll code $payroll_no");
		return false;
	}
	else{
		$this->insertLeave();
		$this->insertAllowance();
		$this->updateBase("epf");
		$this->updateBase("socso");
		$this->updateEPFSOCSO();
		$this->updateTotalAmount();
		$this->log->showLog(3,"Inserting new payroll $payroll_no successfully"); 
		return true;
	}
  } // end of member function insertPayroll

  public function insertLeave() {


	$payroll_id = $this->getLatestPayrollID();
	$sql = "select * from $this->tableleave";

	$this->log->showLog(4,"SQL query leave insert before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query)){
		$leave_description = $row['leave_description'];

		$sqlinsert = 	"insert into $this->tableleaveline (leaveline_name,payroll_id,leaveline_qty,leaveline_amount) 
				values ('$leave_description',$payroll_id,0,0) ";
	
		$this->log->showLog(4,"SQL insert before execute:" . $sqlinsert . "<br>");
		
		$rs=$this->xoopsDB->query($sqlinsert);
		
		if (!$rs){
			$this->log->showLog(1,"Failed to insert line code $payroll_no");
			return false;
		}	

	}
  }


  public function insertAllowance() {


	$payroll_id = $this->getLatestPayrollID();
	$sql = "select * from $this->tableallowanceline where employee_id = $this->employee_id and allowanceline_active = 'Y' ";

	$this->log->showLog(4,"SQL query allowance insert before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query)){
	
		$allowanceline_amount = $row['allowanceline_amount'];
		$allowanceline_epf = $row['allowanceline_epf'];
		$allowanceline_socso = $row['allowanceline_socso'];
		$allowanceline_name = $row['allowanceline_name'];

		$sqlinsert = 	"insert into $this->tableallowancepayroll (payroll_id,allowancepayroll_amount,allowancepayroll_epf,allowancepayroll_socso,allowancepayroll_name) 
				values ($payroll_id,$allowanceline_amount,'$allowanceline_epf','$allowanceline_socso','$allowanceline_name') ";
	
		$this->log->showLog(4,"SQL insert before execute:" . $sqlinsert . "<br>");
		
		$rs=$this->xoopsDB->query($sqlinsert);
		
		if (!$rs){
			$this->log->showLog(1,"Failed to insert line code $payroll_no");
			return false;
		}	

	}
  }

  public function updateLeave(){
	$row = count($this->leaveline_id);
	
	$i=0;
	while($i<$row){
	$i++;
	
	$leaveline_id = $this->leaveline_id[$i];
	$leaveline_qty = $this->leaveline_qty[$i];
	$leaveline_amount = $this->leaveline_amount[$i] ;
	

	$sql = "UPDATE $this->tableleaveline SET
		leaveline_id = $leaveline_id,
		leaveline_qty = $leaveline_qty,
		leaveline_amount = $leaveline_amount
		WHERE leaveline_id = $leaveline_id";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update sales failed");
		return false;
	}

	}

	return true;

  }


    public function updateAllowance(){

	$row = count($this->allowanceline_id);

	if($row==0){

	$sql = "select * from $this->tableallowanceline where employee_id = $this->employee_id";

	$this->log->showLog(4,"SQL query allowance insert before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);
	
	$sqldelete ="delete from $this->tableallowancepayroll where payroll_id = $this->payroll_id";	

	$rs=$this->xoopsDB->query($sqldelete);

	while($row=$this->xoopsDB->fetchArray($query)){
		$allowanceline_id = $row['allowanceline_id'];
		$allowanceline_amount = $row['allowanceline_amount'];
		$sqlinsert = 	"insert into $this->tableallowancepayroll (allowanceline_id,payroll_id,allowancepayroll_amount) 
				values ($allowanceline_id,$this->payroll_id,$allowanceline_amount) ";
	
		$this->log->showLog(4,"SQL insert before execute:" . $sqlinsert . "<br>");
		
		$rs=$this->xoopsDB->query($sqlinsert);
		
		if (!$rs){
			$this->log->showLog(1,"Failed to insert line code $payroll_no");
			return false;
		}	

	}

	}
  }


  public function fetchPayroll( $payroll_id) {
    
	$this->log->showLog(3,"Fetching payroll detail into class Payroll.php.<br>");
		
	$sql="SELECT *,a.remarks as remarks1 from $this->tablepayroll a, $this->tableemployee b ". 
			"where a.payroll_id=$payroll_id and a.employee_id = b.employee_id ";
	
	$this->log->showLog(4,"Payroll->fetchPayroll, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$this->payroll_no=$row['payroll_no'];
	$this->employee_id=$row['employee_id'];
	$this->employeename=$row['employee_name'];
	$this->payroll_date=$row['payroll_date'];
	$this->payroll_monthof=$row['payroll_monthof'];
	$this->payroll_yearof=$row['payroll_yearof'];
	$this->payroll_value_ot1=$row['payroll_value_ot1'];
	$this->payroll_value_ot2=$row['payroll_value_ot2'];
	$this->payroll_value_ot3=$row['payroll_value_ot3'];
	$this->payroll_value_ot4=$row['payroll_value_ot4'];
	$this->payroll_qty_ot1=$row['payroll_qty_ot1'];
	$this->payroll_qty_ot2=$row['payroll_qty_ot2'];
	$this->payroll_qty_ot3=$row['payroll_qty_ot3'];
	$this->payroll_qty_ot4=$row['payroll_qty_ot4'];
	$this->payroll_amt_ot1=$row['payroll_amt_ot1'];
	$this->payroll_amt_ot2=$row['payroll_amt_ot2'];
	$this->payroll_amt_ot3=$row['payroll_amt_ot3'];
	$this->payroll_amt_ot4=$row['payroll_amt_ot4'];
	$this->payroll_amt_comm=$row['payroll_amt_comm'];
	$this->payroll_socsoemployee=$row['payroll_socsoemployee'];
	$this->payroll_socsoemployer=$row['payroll_socsoemployer'];
	$this->payroll_epfemployee=$row['payroll_epfemployee'];
	$this->payroll_epfemployer=$row['payroll_epfemployer'];
	$this->payroll_totalamount=$row['payroll_totalamount'];
	$this->payroll_epfbase=$row['payroll_epfbase'];
	$this->payroll_socsobase=$row['payroll_socsobase'];
	$this->payroll_basicsalary=$row['payroll_basicsalary'];
	$this->remarks=$row['remarks1'];
	$this->payroll_remarks2=$row['payroll_remarks2'];
	$this->iscomplete=$row['iscomplete'];
	$this->isactive=$row['isactive'];
	$this->issocsoot=$row['issocsoot'];
	$this->isepfot=$row['isepfot'];
		
   	$this->log->showLog(4,"Payroll->fetchPayroll,database fetch into class successfully");
	$this->log->showLog(4,"organization_id:$this->organization_id");
	$this->log->showLog(4,"payroll_no:$this->payroll_no");
	$this->log->showLog(4,"payroll_description:$this->payroll_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Payroll->fetchPayroll,failed to fetch data into databases.");	
	}
  } // end of member function fetchPayroll


  public function deletePayroll( $payroll_id ) {
    	$this->log->showLog(2,"Warning: Performing delete payroll id : $payroll_id !");
	$sql="DELETE FROM $this->tablepayroll where payroll_id=$payroll_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: payroll ($payroll_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"payroll ($payroll_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deletePayroll


  public function getSQLStr_AllPayroll( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running Payroll->getSQLStr_AllPayroll: $sql");
    $sql="SELECT *,a.isactive as isactive_m FROM $this->tablepayroll a, $this->tableemployee b " .
	" $wherestring $orderbystring";
  return $sql;
  } // end of member function getSQLStr_AllPayroll

 public function showPayrollTable(){
	if($this->start_date=="")
	$this->start_date = getMonth(date("Ymd", time()),0) ;
   	
	if($this->end_date=="")
	$this->end_date = getMonth(date("Ymd", time()),1) ;

	$wherestring = " where a.payroll_id>0 and a.employee_id = b.employee_id ";

	if($this->payroll_id > 0)
	$wherestring .= " and a.payroll_id = $this->payroll_id ";
	else
	$wherestring .= $this->getWhereString();

	$this->log->showLog(3,"Showing Payroll Table");
	$sql=$this->getSQLStr_AllPayroll($wherestring," GROUP BY a.payroll_id ORDER BY payroll_date desc ",0);
	
	$query=$this->xoopsDB->query($sql);

	echo <<< EOF
	<form name="frmNew" action="payroll.php" method="POST">
	<table>
	<tr>
	<td><input type="submit" value="New" style='height:40px;'></td>
	</tr>
	</table>
	</form>

	<form action="payroll.php" method="POST" name="frmSearch">
	<input type="hidden" name="fldShow" value="">
	<input type="hidden" name="action" value="">
	<input type="hidden" value="" name="payroll_id">
	<table border='1' cellspacing='3'>
	<tr>
	<td class="head">Payroll No</td>
	<td class="even"><input type="text" name="payroll_no" value=""></td>
	<td class="head">Employee</td>
	<td class="even">$this->employeectrl</td>
	</tr>

	<tr>
	<td class="head">Date</td>
	<td class="even" colspan="3">
	<input name='start_date' id='start_date' value="$this->start_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->startctrl"> to  
	<input name='end_date' id='end_date' value="$this->end_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->endctrl">
	</td>
	</tr>

	<tr>
	<td class="head">Active</td>
	<td class="even">
	<select name="isactive">
	<option value="X"></option>
	<option value="Y">Yes</option>
	<option value="N">No</option>
	</select>
	</td>
	<td class="head">Complete</td>
	<td class="even">
	<select name="iscomplete">
	<option value="X"></option>
	<option value="Y">Yes</option>
	<option value="N">No</option>
	</select>
	</tr>
	
	<tr>
	<td class="head" colspan="4"><input type="button" value="Search" onclick="searchPayroll();" style='height:40px;'></td>
	</tr>

	</table></form>
	<br>
EOF;
	

if($this->fldShow=="Y" || $this->payroll_id > 0){
echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Payroll No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Month</th>
				<th style="text-align:center;">Year</th>
				<th style="text-align:center;">Employee</th>
				<th style="text-align:center;">Total Amount($this->cur_symbol)</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Complete</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	$payroll_totalamountfinal = "";
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$payroll_id=$row['payroll_id'];

		$payroll_no=$row['payroll_no'];
		$employee_id=$row['employee_id'];
		$employee_name=$row['employee_name'];
		$payroll_date=$row['payroll_date'];
		$payroll_monthof=$row['payroll_monthof'];
		$payroll_yearof=$row['payroll_yearof'];
		$payroll_value_ot1=$row['payroll_value_ot1'];
		$payroll_value_ot2=$row['payroll_value_ot2'];
		$payroll_value_ot3=$row['payroll_value_ot3'];
		$payroll_value_ot4=$row['payroll_value_ot4'];
		$payroll_qty_ot1=$row['payroll_qty_ot1'];
		$payroll_qty_ot2=$row['payroll_qty_ot2'];
		$payroll_qty_ot3=$row['payroll_qty_ot3'];
		$payroll_qty_ot4=$row['payroll_qty_ot4'];
		$payroll_amt_ot1=$row['payroll_amt_ot1'];
		$payroll_amt_ot2=$row['payroll_amt_ot2'];
		$payroll_amt_ot3=$row['payroll_amt_ot3'];
		$payroll_amt_ot4=$row['payroll_amt_ot4'];
		$payroll_qty_ul=$row['payroll_qty_ul'];
		$payroll_qty_sl=$row['payroll_qty_sl'];
		$payroll_qty_al=$row['payroll_qty_al'];
		$payroll_qty_el=$row['payroll_qty_el'];
		$payroll_amt_ul=$row['payroll_amt_ul'];
		$payroll_amt_sl=$row['payroll_amt_sl'];
		$payroll_amt_al=$row['payroll_amt_al'];
		$payroll_amt_el=$row['payroll_amt_el'];
		$payroll_amt_comm=$row['payroll_amt_comm'];
		$payroll_amt_allowance1=$row['payroll_amt_allowance1'];
		$payroll_amt_allowance2=$row['payroll_amt_allowance2'];
		$payroll_amt_allowance3=$row['payroll_amt_allowance3'];
		$payroll_totalamount=$row['payroll_totalamount'];
		$payroll_epfbase=$row['payroll_epfbase'];
		$payroll_socsobase=$row['payroll_socsobase'];
		$payroll_basicsalary=$row['payroll_basicsalary'];

		$payroll_totalamountfinal += $payroll_totalamount;

		$isactive=$row['isactive_m'];
		$iscomplete=$row['iscomplete'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		if($isactive=="Y")
			$isactive="Yes";
		else
			$isactive="No";

		
		if($iscomplete=="Y"){
			$iscomplete="Yes";
			$styleenable = "";
			$styleedit = "style='display:none'";
		}else{
			$iscomplete="No";
			$styleenable = "style='display:none'";
			$styleedit = "";
		}

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$payroll_no</td>
			<td class="$rowtype" style="text-align:center;">$payroll_date</td>
			<td class="$rowtype" style="text-align:center;">$payroll_monthof</td>
			<td class="$rowtype" style="text-align:center;">$payroll_yearof</td>
			<td class="$rowtype" style="text-align:center;">$employee_name</td>
			<td class="$rowtype" style="text-align:center;">$payroll_totalamount</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:right;">
				<table>
				<tr>
				<td $styleedit>
				<form action="payroll.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this payroll'>
				<input type="hidden" value="$payroll_id" name="payroll_id">
				<input type="hidden" name="action" value="edit">
				</form>
				</td>
		
				<td $styleenable>
				<form action="payroll.php" method="POST" onsubmit="return confirm('Enable This Record?')">
				<input type="submit"  name="btnEnable" title='Enable this record' value="Enable" >
				<input type="hidden" name="payroll_id" value="$payroll_id">
				<input type="hidden" name="action" value="enable">
				</form>
				</td>
				<td $styleenable>
				<form action="payslip.php" method="POST" target="BLANK">
				<input type="image" src="images/list.gif" style="height:20px" name="submit" title='Print this payroll' >
				<input type="hidden" value="$payroll_id" name="payroll_id">
				</form>
				</td>

				</tr>
				</table>
			</td>

		</tr>
EOF;
	}
	echo  "</tr>";
	
	if($payroll_totalamountfinal != "")
	$payroll_totalamountfinal = number_format($payroll_totalamountfinal, 2, '.','');

	echo  "<tr>
		<td class='head' colspan='6'></td>
		<td class='head' align=center>$payroll_totalamountfinal</td>
		<td class='head' colspan='3'></td>
		<tr>";
	echo "</tbody></table>";
	
	}
 }


  public function getWhereString(){
	$retval = "";
	//echo $this->isactive;

	if($this->payroll_no != "")
	$retval .= " and a.payroll_no LIKE '$this->payroll_no' ";
	if($this->employee_id > 0)
	$retval .= " and a.employee_id = '$this->employee_id' ";
	if($this->isactive != "X" && $this->isactive != "")
	$retval .= " and a.isactive = '$this->isactive' ";
	if($this->iscomplete != "X" && $this->iscomplete != "")
	$retval .= " and a.iscomplete = '$this->iscomplete' ";
	if($this->start_date != "" && $this->end_date != "")
	$retval .= " and ( a.payroll_date between '$this->start_date' and '$this->end_date' ) ";

	return $retval;
	
  }


  public function getLatestPayrollID() {
	$sql="SELECT MAX(payroll_id) as payroll_id from $this->tablepayroll;";
	$this->log->showLog(3,'Checking latest created payroll_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created payroll_id:' . $row['payroll_id']);
		return $row['payroll_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectPayroll($id,$fld='payroll_id') {
	
	$sql="SELECT payroll_id,payroll_description from $this->tablepayroll where (isactive='Y' or payroll_id=$id )  order by payroll_description ;";
	$selectctl="<SELECT name=$fld >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$payroll_id=$row['payroll_id'];
		$payroll_description=$row['payroll_description'];
	
		if($id==$payroll_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$payroll_id' $selected>$payroll_description</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){

/*
	$sql="SELECT count(payroll) as rowcount from $this->tablecustomer where payroll=$id";
	$this->log->showLog(3,"Accessing Payroll->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this payroll, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this payroll, record deletable");
		return true;
		}*/
	return true;
	}

  public function getEmployeeDetail($employee_id,$fld){
	$retval = "";
	$sql="SELECT $fld as fld from $this->tableemployee where employee_id = $employee_id ";
	$this->log->showLog(3,"Find Allowance name.");
	$this->log->showLog(4,"SQL:$sql");
	
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['fld'];
	}

	return $retval;
  }

  public function getCommission($employee_id){//get commission
	
	$YMD = $this->payroll_yearof.$this->payroll_monthof."01";

	$totalamount = 0;
	$totalamountfinal = 0;
	
	$start_date = getMonth($YMD,0) ;
	$end_date = getMonth($YMD,1) ;
	
	//Y = others, N = product, C = service
  	$retval = "0.00";
	$sql = "select sum(percent/100*salesline_amount) as totamount,e.isitem  
		from $this->tablesales a, $this->tablesalesline b, $this->tablesalesemployeeline c, 
		$this->tableproduct d, $this->tableproductcategory e
		where a.sales_id = b.sales_id and b.salesline_id = c.salesline_id and a.iscomplete = 'Y' and a.isactive = 'Y' 
		and b.product_id = d.product_id and d.category_id = e.category_id  
		and a.sales_date between '$start_date' and '$end_date' 
		and c.employee_id = $employee_id
		group by e.category_id ";//sum total amount

	$this->log->showLog(4,"SQL:$sql");
	$i = 0;

	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
	
	$totalamount = $row['totamount'];
	$isitem = $row['isitem'];

	if($isitem=="C")
	$type = "S";
	else if($isitem=="N")
	$type = "P";
	else
	$type = "O";
	

	if($retval=="")
	$totalamount = 0;

		// get commission percent
		$sql2 = "select (commission_percent/100*$totalamount) as total from $this->tablecommission a 
		where ($totalamount between a.commission_amount and a.commission_amountmax) 
		and a.commission_type = '$type' ";//compare with commission table
	
		$this->log->showLog(4,"SQL:$sql");
		
		$query2=$this->xoopsDB->query($sql2);
		if($row2=$this->xoopsDB->fetchArray($query2)){
		$total = $row2['total'];
		
		if($total=="")
		$total = 0;
		
		$totalamountfinal += $total;
		}
		// end of get commission percent
	
	}
	
	

	$retval = number_format($totalamountfinal, 2, '.','');

	return $retval;
  }

/*
  public function getSocsoEPF($employee_id,$fld){//get Socso n EPF
	$retval = "0.00";
	
	$sql = "select ($fld/100*basic_salary) as total from $this->tableemployee where employee_id = $employee_id ";

	$this->log->showLog(4,"SQL:$sql");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['total'];

	if($retval=="")
	$retval = 0;
	}
	
	$retval = number_format($retval, 2, '.','');

	return $retval;

  }*/


   public function getSocsoEPF($basic_salary,$fld){//get Socso n EPF
	$retval = "0.00";
	
	if($fld=="socso_employee" || $fld=="socso_employer")
	$table = $this->tablesocso;
	else
	$table = $this->tableepf;
	
	$fld = substr($fld,strlen($fld)-8,8)."_amt";

	$sql = "select $fld as total from $table where $basic_salary between amtfrom and amtto ";

	$this->log->showLog(4,"SQL:$sql");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['total'];

	if($retval=="")
	$retval = 0;
	}
	
	$retval = number_format($retval, 2, '.','');

	return $retval;

  }


   public function enablePayroll(){

	$sql = "update $this->tablepayroll set iscomplete = 'N' where payroll_id = $this->payroll_id ";

	$this->log->showLog(4,"With SQL: $sql");

	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: ($payroll_id) cannot enable from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Internal ($payroll_id) enabled successfully!");
		return true;
		
	}
  }

  public function getTableLeave(){

	$sql = "select * from $this->tableleaveline a, $this->tableleave b 
		where a.payroll_id = $this->payroll_id 
		and a.leave_id = b.leave_id ";
	
	$this->log->showLog(4,"SQL table leave: $sql");
	
	$query=$this->xoopsDB->query($sql);

	$onblur =  "onblur='getAmount2(this);parseelement(this);'";
	
echo <<< EOF
	<table border='0' cellspacing='3'>
	<tbody>	
	
	<tr height="15"></tr>
	<tr><!--Leave-->
		<td style="text-align:left;" colspan="4" class="head">Leave</td>
	</tr>

	<tr>
		<th style="text-align:center;" width="10%">No</th>
		<th style="text-align:center;" width="40%">Type</th>
		<th style="text-align:center;" width="25%">Qty</th>
		<th style="text-align:center;" width="25%">Amount ($this->cur_symbol)</th>
	</tr>
	
	</tbody>
EOF;
	$i = 0;
	$rowtype = "";
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	
	$leaveline_id = $row['leaveline_id'];
	$leave_description = $row['leave_description'];
	$leaveline_qty = $row['leaveline_qty'];
	$leaveline_amount = $row['leaveline_amount'];
	
	if($rowtype=="class='odd'")
		$rowtype="class='even'";
	else
		$rowtype="class='odd'";
	
echo <<< EOF
	<tr>
		<input type="hidden" name="leaveline_id[$i]" value="$leaveline_id">
		<td style="text-align:center;" $rowtype>$i</td>
		<td style="text-align:left;" $rowtype>$leave_description</td>
		<td style="text-align:center;" $rowtype><input name="leaveline_qty[$i]" value="$leaveline_qty" maxlength="10" size="5"></td>
		<td style="text-align:center;" $rowtype><input name="leaveline_amount[$i]" value="$leaveline_amount" maxlength="10" size="10" $onblur></td>
	</tr>
EOF;
	}

echo <<< EOF
	</table>
EOF;
  }


  public function getTableAllowance($type=""){

	$sql = "select b.allowanceline_name as type, a.allowancepayroll_amount as amount , a.allowanceline_id as allowanceline_id, 
		a.allowancepayroll_id as allowancepayroll_id 
		from $this->tableallowancepayroll a,  $this->tableallowanceline b 
		where payroll_id = $this->payroll_id 
		and a.allowanceline_id = b.allowanceline_id ";

	
	
	$this->log->showLog(4,"SQL table allowance: $sql");
	
	$query=$this->xoopsDB->query($sql);

echo <<< EOF
	<table border='0' cellspacing='3'><!--Allowance-->
	<tbody>	

	<tr height="15"></tr>
	<tr>
		<td style="text-align:left;" colspan="4" class="head">Allowance</td>
	</tr>
	<tr>
		<th style="text-align:center;" width="5%">No</th>
		<th style="text-align:left;" colspan="2" width="60%">Type</th>
		<th style="text-align:center;" width="35%">Amount ($this->cur_symbol)</th>
	</tr>
	
	</tbody>
EOF;
	
	$i = 0;
	$rowtype = "";
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;

	$type = $row['type'];
	$amount = $row['amount'];
	$allowanceline_id = $row['allowanceline_id'];
	$allowancepayroll_id = $row['allowancepayroll_id'];

	if($rowtype=="class='odd'")
		$rowtype="class='even'";
	else
		$rowtype="class='odd'";
	
echo <<< EOF
	
	<tr>
		<input type="hidden" name="allowanceline_id[$i]" value="$allowanceline_id">
		<!--<input type="hidden" name="allowancepayroll_id[$i]" value="$allowancepayroll_id" >-->
		<td style="text-align:center;" $rowtype>$i</td>
		<td style="text-align:left;" $rowtype colspan="2">$type</td>
		<!--<td style="text-align:center;" $rowtype><input name="allowancepayroll_amount[$i]" value="$amount" maxlength="10" size="10"></td>-->
		<td style="text-align:center;" $rowtype>$amount</td>
	</tr>

EOF;
	}
	
echo <<< EOF
	</table>
EOF;
  }


  public function getHTMLAllowance(){

	
	$sql = "select a.allowanceline_name as type, a.allowanceline_amount as amount, a.allowanceline_id as allowanceline_id 
		from $this->tableallowanceline a 
		where employee_id = $this->employee_id ";
	
	
	$this->log->showLog(4,"SQL table allowance: $sql");
	
	$query=$this->xoopsDB->query($sql);


	$html = 
	"<table border='0' cellspacing='3'>
	<tbody>	

	<tr height='15'></tr>
	<tr>
		<td style='text-align:left;' colspan='4' class='head'>Allowance</td>
	</tr>
	<tr>
		<th style='text-align:center;' width='5%'>No</th>
		<th style='text-align:left;' colspan='2' width='60%'>Type</th>
		<th style='text-align:center;' width='35%'>Amount ($this->cur_symbol)</th>
	</tr>";

	
	$i = 0;
	$rowtype = "";
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;

	$type = $row['type'];
	$amount = $row['amount'];
	$allowanceline_id = $row['allowanceline_id'];

	if($rowtype=="class=odd")
		$rowtype="class='even'";
	else
		$rowtype="class='odd'";

	$html2 .= "<tr>
			<td style='text-align:center;' $rowtype>$i</td>
			<td style='text-align:left;' $rowtype colspan='2'>$type</td>
			<td style='text-align:center;' $rowtype>$amount</td>
		 </tr>";

	/*
	$html2 .= "<tr>
			<input type='hidden' name='allowanceline_id[$i]' value='$allowanceline_id' />
			<td style='text-align:center;' $rowtype>$i</td>
			<td style='text-align:left;' $rowtype colspan='2'>$type</td>
			<td style='text-align:center;color:gainsboro' $rowtype><input name='allowancepayroll_amount[$i]' value='$amount' maxlength='10' size='10' /></td>
		 </tr>";
	*/


	}
	

	$html3 = "</tbody></table>";

	return $html.$html2.$html3;

  }


  public function getTotalAllowance(){
	$retval = "0.00";
	$sql = "select sum(allowanceline_amount) as total from $this->tableallowanceline where employee_id = $this->employee_id";

	$this->log->showLog(4,"SQL table allowance: $sql");
	
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['total'];
	}

	return $retval;

	
  }

   public function getTotalAllowancePayroll($payroll_id=""){
	
	$retval = "0.00";
	$sql = "select sum(allowancepayroll_amount) as total from $this->tableallowancepayroll where payroll_id = $payroll_id";

	$this->log->showLog(4,"SQL table allowance: $sql");
	
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['total'];
	}

	return $retval;

	
  }

  public function getTotalAllowanceBase($fld,$payroll_id){
	
	$retval = "0.00";
	$sql = "select sum(allowancepayroll_amount) as total from $this->tableallowancepayroll 
		where payroll_id = $this->payroll_id
		and $fld = 'Y' ";

	$this->log->showLog(4,"SQL table allowance: $sql");
	
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	if($row['total']>0)
	$retval = $row['total'];
	}

	return $retval;

	
  }

  public function getTotalLeavePayroll($payroll_id=""){
	//$payroll_id = $this->getLatestPayrollID();
	$retval = "0.00";
	$sql = "select sum(leaveline_amount) as total from $this->tableleaveline where payroll_id = $payroll_id";

	$this->log->showLog(4,"SQL table allowance: $sql");
	
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['total'];
	}

	return $retval;

	
  }


  public function updateBase($type){

	$payroll_id = $this->getLatestPayrollID();
	$basic_salary = $this->getEmployeeDetail($this->employee_id,"basic_salary");
	$commission = $this->getCommission($this->employee_id);

	$fld = "allowancepayroll_".$type;

	$sql = "select sum(allowancepayroll_amount) as total from $this->tableallowancepayroll 
		where payroll_id = $payroll_id 
		and $fld = 'Y' ";

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$total = $row['total'] + $basic_salary + $commission;
	
		$basefld = "payroll_".$type."base";
		$sqlinsert = 	"update $this->tablepayroll set $basefld = $total where payroll_id = $payroll_id ";
	
		$this->log->showLog(4,"SQL insert before execute:" . $sqlinsert . "<br>");
		
		$rs=$this->xoopsDB->query($sqlinsert);
		
		if (!$rs){
			$this->log->showLog(1,"Failed to insert line code $payroll_no");
			return false;
		}	

	}
  }


  public function getBase($type){
	$baseamount = "0.00";
	$total = 0;
	$payroll_id = $this->getLatestPayrollID();
	$basic_salary = $this->getEmployeeDetail($this->employee_id,"basic_salary");
	$commission = $this->getCommission($this->employee_id);

	$fld = "allowancepayroll_".$type;

	$sql = "select sum(allowancepayroll_amount) as total from $this->tableallowancepayroll 
		where payroll_id = $payroll_id 
		and $fld = 'Y' ";

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$total = $row['total'];

	}

	$baseamount = $total + $basic_salary + $commission;

	return $baseamount;
  }

  public function updateEPFSOCSO(){
	$payroll_id = $this->getLatestPayrollID();

	$socsoemployee = $this->getSocsoEPF($this->getBase("socso"),"socso_employee");
	$socsoemployer = $this->getSocsoEPF($this->getBase("socso"),"socso_employer");
	$epfemployee = $this->getSocsoEPF($this->getBase("epf"),"epf_employee");
	$epfemployer = $this->getSocsoEPF($this->getBase("epf"),"epf_employer");

	$sql = "update $this->tablepayroll set 	payroll_socsoemployee = $socsoemployee, 
						payroll_socsoemployer = $socsoemployer,
						payroll_epfemployee = $epfemployee,
						payroll_epfemployer = $epfemployer 
		where payroll_id = $payroll_id";

	$this->log->showLog(4,"SQL insert before execute:" . $sql . "<br>");
		
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert line code $payroll_no");
		return false;
	}	

  }


  public function updateTotalAmount(){
	$payroll_id = $this->getLatestPayrollID();

	$totalallowance = $this->getTotalAllowancePayroll($payroll_id);
	$basic_salary = $this->getEmployeeDetail($this->employee_id,"basic_salary");
	$commission = $this->getCommission($this->employee_id);

	$socsoemployee = $this->getSocsoEPF($this->getBase("socso"),"socso_employee");
	$socsoemployer = $this->getSocsoEPF($this->getBase("socso"),"socso_employer");
	$epfemployee = $this->getSocsoEPF($this->getBase("epf"),"epf_employee");
	$epfemployer = $this->getSocsoEPF($this->getBase("epf"),"epf_employer");

	$total =  $socsoemployer - $epfemployee + $epfemployer + $basic_salary + $totalallowance + $commission - $socsoemployee;

	$sql = "update $this->tablepayroll set 	payroll_totalamount = ($total)
		where payroll_id = $payroll_id";

	$this->log->showLog(4,"SQL insert before execute:" . $sql . "<br>");
		
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert line code $payroll_no");
		return false;
	}
  }


  public function checkEmployee($employee_id,$monthof,$yearof){
	$cnt = 0;
	$sql = "select count(payroll_id) as cnt,payroll_id from $this->tablepayroll 
		where employee_id =  $employee_id 
		and payroll_monthof = '$monthof' 
		and payroll_yearof = $yearof 
		group by payroll_id";

	$query=$this->xoopsDB->query($sql);

	$this->log->showLog(4,"SQL query before execute:" . $sql . "<br>");

	if($row=$this->xoopsDB->fetchArray($query)){
	$cnt = $row['cnt'];
	$payroll_id = $row['payroll_id'];

	}

	return array("count" => $cnt,"payroll_id" => $payroll_id);
  }


} // end of ClassPayroll
?>


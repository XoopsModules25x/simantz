<?php


class Payslip
{
public $payslip_id;
public $employee_id;
public $period_id;
public $period_name;
public $datefrom;
public $dateto;
public $position;
public $department;
public $basicsalary;
public $commissionamt;
public $hourlycommisionamt;

public $employee_epfamt;
public $employee_socsoamt;
public $employee_pcbamt;
public $employer_epfamt;
public $employer_socsoamt;
public $totalincomeamt;
public $totaldeductamt;
public $needrecalculate;
public $incomesubtable;
public $deductsubtable;
public $othersubtable;
public $isAdmin=false;
public $netpayamt;
public $epf_no;
public $socso_no;

public $epfbaseamt;
public $socsobaseamt;
public $iscomplete;
public $description;
public $remarks;
public $createdby;
public $created;
public $updated;
public $updatedby;
public $payslipdate;
public $linecount;
public $periodctrl;
public $employeectrl;
public $xoopsDB;
public $tableprefix;
public $log;
public $tablepayslip;
public $tablepayslipline;
public $tableemployee;
public $tableemppayslipitem;
public $tableepf;
public $tablesocso;
public $tableorganization;
public $tableperiod;
public $tablestudentclass;
public $tabletuitionclass;
public $tablepaymentline;
public $tablepayment;
public $tableclassschedule;

public function Payslip($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix."simtrain_organization";
	$this->tableperiod=$tableprefix."simtrain_period";
	$this->tablepayslip=$tableprefix."simtrain_payslip";
	$this->tablepayslipline=$tableprefix."simtrain_payslipline";
	$this->tableemployee=$tableprefix."simtrain_employee";
	$this->tableepf=$tableprefix."simtrain_epftable";
	$this->tablesocso=$tableprefix."simtrain_socsotable";
	$this->tableemppayslipitem=$tableprefix."simtrain_emppayslipitem";

	$this->tablestudentclass=$tableprefix."simtrain_studentclass";
	$this->tabletuitionclass=$tableprefix."simtrain_tuitionclass";
	$this->tablepaymentline=$tableprefix."simtrain_paymentline";
	$this->tablepayment=$tableprefix."simtrain_payment";
	$this->tableclassschedule =$tableprefix."simtrain_classschedule";
	$this->log=$log;
}

public function showSearchForm(){
echo <<< EOF
<table border='1'>
  <tbody>
    <tr>
      <th colspan='4'>Search</th>
    </tr>
    <tr><form name='frmSearchPayslip' action='listpayslip.php' method='POST'>
      <td>Employee</td>
      <td>$this->employeectrl</td>
      <td>Period</td>
      <td>$this->periodctrl</td>
    </tr>
    <tr>
      <td>Document No</td>
      <td><input name='documentno' value="$this->documentno"></td>
      <td>Is Complete</td>
      <td><SELECT name="iscomplete"><option value="">NULL</option>
			<option value='Y'>Yes</option>
			<option value='N'>No</option></select>
	</td>
	</tr>
    <tr>
   	<td><Input type='submit' value='Search'></td>
      <td><Input type='reset' value='reset'></td>

	</form>
    </tr>
  </tbody>
</table>

EOF;
}

public function showInputForm($token){
	$mandatorysign="<b style='color:red'>*</b>";
$aligncenter=" style='text-align:center'";
$alignleft=" style='text-align:left'";
$alignright=" style='text-align:right'";
$onchange="onchange='recalculate()'";
echo <<< EOF


<tr><Form action='payslip.php' method='POST' name='frmPayslip' onsubmit="return validatePayslip();">
	<input type='hidden' name='employee_id' value='$this->employee_id'>
	<td class='head'>Department <input type='hidden' name='epftype' value="$this->epftype"></td>
	<td class='odd'><input name="department" value="$this->department" size="20" maxlength="20"></td>
	<td class='head'>Position</td>
	<td class='odd'><input name="position" value="$this->position" size="20" maxlength="20">
			<input name="needrecalculate" value="$this->needrecalculate" type='hidden'></td>

</tr>
<tr>
	<td class='head'>Date From (YYYY-MM-DD)</td>
	<td class='even'><input name="datefrom" id="datefrom" value="$this->datefrom" size="10" maxlength="10">
			<input type='button' value='Date' onclick="$this->showdatefrom"></td>
	<td class='head'>Date To (YYYY-MM-DD)</td>
	<td class='even'><input name="dateto" id="dateto" value="$this->dateto" size="10" maxlength="10">	
		<input type='button' value='Date' onclick="$this->showdateto"></td>

</tr>
<tr>
	<td class='head'>Period</td>
	<td class='odd'>$this->period_name <input type='hidden' name='period_id' value='$this->period_id'></td>
	<td class='head'>Paid Date (YYYY-MM-DD)</td>
	<td class='odd'><input name="payslipdate" id="payslipdate" value="$this->payslipdate" size="10" maxlength="10">
				<input type='button' value='Date' onclick="$this->showpayslipdate"></td>

</tr>

</tbody></table>
<br>
<table border='1'>
  <tbody>
    <tr>
      <th colspan="3" style='text-align:center;'>Payroll Info</th>
    </tr>
    <tr>
      <th class='head' style='text-align:center;'>Income</th>
      <th class='head' style='text-align:center;'>Deduction</th>
      <th class='head' style='text-align:center;'>Others</th>
    </tr>
    <tr>
        <td class='odd'>
		<table border='1'>
			<tbody>
			<tr>
			<th $aligncenter>No</th>
			<th $aligncenter>Description</th>
			<th $aligncenter>EPF</th>
			<th $aligncenter>Socso</th>
			<th $aligncenter>Amount($this->cur_symbol)</th>
			</tr>
			<tr>
			<td></td>
			<td>Basic Salary </td>
			<td $aligncenter>Y</td>
			<td $aligncenter>Y</td>
			<td $alignright><input name="basicsalary" value="$this->basicsalary" size="6" maxlength="8"
				style='text-align: right' $onchange></td>
			</tr>
			<tr>
			<td></td>
			<td>Commission Amount</td>
			<td $aligncenter>Y</td>
			<td $aligncenter>Y</td>
			<td $alignright><input name="commissionamt" value="$this->commissionamt" size="6" maxlength="8"
				 style='text-align: right' $onchange></td>
			</tr>
			<tr>
			<td></td>
			<td>Hourly Commission</td>
			<td $aligncenter>Y</td>
			<td $aligncenter>Y</td>
			<td $alignright><input name="hourlycommisionamt" value="$this->hourlycommisionamt" size="6" maxlength="8"
				 style='text-align: right' $onchange></td>
			</tr>
			$this->incomesubtable
			<tr>
			<td class='foot'></td>
			<td class='foot'>Total Income</td>
			<td class='foot'></td>
			<td class='foot'></td>
			<td class='foot' $alignright><input name="totalincomeamt" value="$this->totalincomeamt" size="8" maxlength="10" readonly="readonly"
					style='text-align: right' $onchange></td>
			</tr>
			</tbody>
			</table>
	</td>
        <td class='even'>
		<table border='1'>
			<tbody>
			<tr>
			<th $aligncenter>No</th>
			<th $aligncenter>Description</th>
			<th $aligncenter>EPF</th>
			<th $aligncenter>Socso</th>
			<th $aligncenter>Amount($this->cur_symbol)</th>
			</tr>
			$this->deductsubtable
			<tr>
				<td $aligncenter colspan='5'>
				<input type='submit' value='Re-calculate & Save' 
					name='save' onclick="recalculate();iscomplete.value='N'">	
	
				</td>	
			</tr>
			<tr>			
			<td></td>
			<td>EPF For Employee </td>
			<td></td>
			<td></td>
			<td $alignright><input name="employee_epfamt" value="$this->employee_epfamt" size="6" 
				maxlength="8" style='text-align: right' $onchange></td>
			</tr>
			<tr>
			<td></td>
			<td>Socso For Employee</td>
			<td></td>
			<td></td>
			<td $alignright><input name="employee_socsoamt" value="$this->employee_socsoamt" size="6"
				maxlength="8" style='text-align: right' $onchange></td>
			</tr>
			<tr>
			<td></td>
			<td>PCB For Employee</td>
			<td></td>
			<td></td>
			<td $alignright><input name="employee_pcbamt" value="$this->employee_pcbamt" size="6"
				 maxlength="8" style='text-align: right'  $onchange></td>
			</tr>

			<td class='foot'></td>
			<td class='foot'>Total Deduction</td>
			<td class='foot'></td>
			<td class='foot'></td>
			<td class='foot' $alignright><input name="totaldeductamt" value="$this->totaldeductamt" size="8" maxlength="10" style='text-align: right'  $onchange  readonly="readonly"></td>
			</tr>
		</tbody>
		</table>

	</td>
        <td class='odd'>
		<table border='1'>
			<tbody>
			<tr>
			<th>No</th>
			<th>Description</th>
			<th>EPF</th>
			<th>Socso</th>
			<th>Amount($this->cur_symbol)</th>
			</tr>
			$this->othersubtable
			<tr>
			<td colspan='4'>Employer Contribute EPF</td>
			<td style="text-align:right"><input name="employer_epfamt" value="$this->employer_epfamt"
				size='6' maxlength='8'  style="text-align:right"></td>
			</tr>
			<tr>
			<td colspan='4'>Employer Contribute Socso</td>
			<td style="text-align:right"><input name="employer_socsoamt" value="$this->employer_socsoamt"
				size='6' maxlength='8' style="text-align:right"></td>
			</tr>
			<tr>
			<td colspan='4'>EPF Base</td>
			<td style="text-align:right"><input name="epfbaseamt" value="$this->epfbaseamt"
				size='6' maxlength='8' style="text-align:right"></td>
			</tr>
			<tr>
			<td colspan='4'>Socso Base</td>
			<td style="text-align:right"><input name="socsobaseamt" value="$this->socsobaseamt"
				size='6' maxlength='8' style="text-align:right"></td>
			</tr>
			
		</tbody>
		</table>

	</td>
    </tr>
  <tr>
	<td class='even' colspan='3'>
	Net Pay<input name="netpayamt" value="$this->netpayamt">
	</td>

 </tr>

  <tr>
	<td class='even' colspan='3'>
		<table ><tbody><tr><td>
		<strong>Description In Payslip(Max 255 character, 3 line)</strong><br>
		<textarea name='description' cols='60'>$this->description</textarea>
		</td><td>
		<strong>Remarks(Max 255 character, this text for reference purpose only)</strong><br>
		<textarea name='remarks' cols='60'>$this->remarks</textarea>
		</td></tr</tbody></table>
	</td>

 </tr>

    <tr>
      <td><Input type='submit' value='Complete Payslip' name='submit' onclick="recalculate();iscomplete.value='Y';removepayslipitem_id.value='0'">&nbsp;
	<input type='hidden' name='payslip_id' value="$this->payslip_id">
	<input type='hidden' name='token' value="$token">
</td>
      <td><input type='reset' value='Reset' name='reset'>&nbsp;
	
		<input type='hidden' name='iscomplete' value="N">
		<input type='hidden' name='action' value='update'>
		<input type='hidden' name='removepayslipitem_id' value='0'>
		
	</form>
	</td>
      <td><form method='POST' action='payslip.php' name='frmDeletePayslip' 
				onsubmit="return confirm('Confirm to delete this payslip?');">
		<input type='hidden' value='delete' name='action'>
		<input type='submit' value='Delete' name='submit'>
		<input type='hidden' name='token' value="$token">
		<input type='hidden' name='payslip_id' value="$this->payslip_id">

		</form></td>
    </tr>
  </tbody>
</table>
<br>

<script type='text/javascript'>
//script must but below frmPayslip

	function complete(){
	recalculate();
	document.forms['frmPayslip'].removepayslipitem_id.value='0';
	
	if(confirm("Complete this record? After complete you need permission to re-activate this record before proceed any furthe modification.")){
		document.forms['frmPayslip'].iscomplete.value='Y';
	
	}
	else{
	document.forms['frmPayslip'].iscomplete.value='N';
	
	}
	}

	function removeitem(itemid){
	if(confirm("Delete this item? You need to calcullate and save 1 more time after this delete process.")){
	document.forms['frmPayslip'].removepayslipitem_id.value = itemid;
	document.frmPayslip.save.click();

	}
	else
	document.forms['frmPayslip'].removepayslipitem_id.value = 0;
	}

	function validatePayslip(){
		var datefrom=document.forms['frmPayslip'].datefrom.value;
		var dateto=document.forms['frmPayslip'].dateto.value;
		var payslipdate=document.forms['frmPayslip'].payslipdate.value;
		var netpayamt=document.forms['frmPayslip'].netpayamt.value;
		var totalincomeamt=document.forms['frmPayslip'].totalincomeamt.value;

		if(confirm("Confirm to save this record?")){
		  if(!isDate(datefrom) || datefrom=="" || !isDate(dateto) || dateto=="" ||
			!isDate(payslipdate) || payslipdate=="" || !IsNumeric(netpayamt) || netpayamt=="" ||
			!IsNumeric(totalincomeamt) || totalincomeamt==""){
			alert("Make sure all date is fill in correctly and make sure Net/Total Income is numeric");
			return false;
			}
			return true;
		}
		else{

		return false;
		}
	}
	
	function recalculate(){
		var basicsalary=document.forms['frmPayslip'].basicsalary.value;
		var commissionamt=document.forms['frmPayslip'].commissionamt.value;
		var hourlycommisionamt=document.forms['frmPayslip'].hourlycommisionamt.value;
		var employee_epfamt=document.forms['frmPayslip'].employee_epfamt.value;
		var employee_socsoamt=document.forms['frmPayslip'].employee_socsoamt.value;
		var employee_pcbamt=document.forms['frmPayslip'].employee_pcbamt.value;

		//var totalincomeamt=document.forms['frmPayslip'].totalincomeamt.value;
		var totalbasicincomeamt=parseFloat(basicsalary) + parseFloat(commissionamt) +
			 parseFloat(hourlycommisionamt);
		
		totalincomeamt=totalbasicincomeamt + calculateincomeline();
		document.forms['frmPayslip'].totalincomeamt.value=totalincomeamt;
		//if(document.forms['frmPayslip'].totalincomeamt.value=="NaN")
		//	alert("Income value can't process");


		//alert("$this->linecount");	
//		var totaldeductamt=document.forms['frmPayslip'].totaldeductamt.value;
		//var totaldeductamt=parseFloat(employee_epfamt) + parseFloat(employee_socsoamt) +
		//		 parseFloat(employee_pcbamt);
		var totaldeductamt =  calculatedeductline();
		document.forms['frmPayslip'].totaldeductamt.value = totaldeductamt;

//		var netpayamt=document.forms['frmPayslip'].netpayamt.value;
		//document.forms['frmPayslip'].netpayamt.value = parseFloat(totalincomeamt) - 
		//					parseFloat(totaldeductamt);

//		var epfbaseamt=document.forms['frmPayslip'].epfbaseamt.value;
//		var socsobaseamt=document.forms['frmPayslip'].socsobaseamt.value;
	
		var employer_epfamt=document.forms['frmPayslip'].employer_epfamt.value;
		var employer_socsoamt=document.forms['frmPayslip'].employer_socsoamt.value;

		document.forms['frmPayslip'].epfbaseamt.value=calculateepfbase() + totalbasicincomeamt;
		document.forms['frmPayslip'].socsobaseamt.value=calculatesocsobase() + totalbasicincomeamt;
		//alert ("Calculating");
	}


	function calculateincomeline(){
		var count=$this->linecount;
//		var i=0;
		var total=0;
		//alert ("Start calculateincomeline");
		for(i=0;i<count;i++){

			if(document.getElementById("linelinetype" + i).value==1)
				total=total + parseFloat(document.getElementById("lineamount" + i).value);
		}
		return total;
	}

	function calculatedeductline(){
		var count=$this->linecount;
//		var i=0;
		var total=0;
		//alert ("Start calculateincomeline");
		for(i=0;i<count;i++){

			if(document.getElementById("linelinetype" + i).value==-1)
				total=total + parseFloat(document.getElementById("lineamount" + i).value);
		}
		return total;
	}

	function calculateepfbase(){
		var count=$this->linecount;
//		var i=0;
		var total=0;
		//alert ("Start calculateincomeline");
		for(i=0;i<count;i++){

			if(document.getElementById("lineiscalc_epf" + i).checked)
			total=total + parseFloat(document.getElementById("linelinetype" + i).value) *
				parseFloat(document.getElementById("lineamount" + i).value);
		}
		return total;
	}

	function calculatesocsobase(){
		var count=$this->linecount;
//		var i=0;
		var total=0;
		//alert ("Start calculateincomeline");
		for(i=0;i<count;i++){

			if(document.getElementById("lineiscalc_socso" + i).checked)
			total=total + parseFloat(document.getElementById("linelinetype" + i).value) *
				parseFloat(document.getElementById("lineamount" + i).value);
		}
		return total;
	}


</script>


EOF;

}
public function showProcessHeader(){
	$mandatorysign="<b style='color:red'>*</b>";
echo <<< EOF
<script type='text/javascript'>
function validateGeneratePayslip(){
	var employee_id=document.forms['frmGeneratePayslip'].employee_id.value;
	var period_id=document.forms['frmGeneratePayslip'].period_id.value;
	if(confirm('Confirm to generate new payslip?')){
		if(employee_id ==0 || period_id==0){
			alert("Please make sure you'd choose proper employee and period!");
			return false;	
		}
		else
			return true;
	}
	else
		return false;

}
</script>
<table border='1'>
  <tbody>
    <tr>
      <th colspan='4'>Generate New Payslip</th>
    </tr>
    <tr><form name='frmGeneratePayslip' action='payslip.php' method='POST' onsubmit="return validateGeneratePayslip()">
      <td class='head'>Employee $mandatorysign</td>
      <td class='odd'>$this->employeectrl</td>
      <td class='head'>Period $mandatorysign</td>
      <td class='odd'>$this->periodctrl</td>
    </tr>
   	<td class='even'><Input type='submit' value='Process'>
	<Input type='hidden' value='create' name='action'></td>
      <td class='even' colspan='3'><Input type='reset' value='reset'></td>

	</form>
    </tr>
  </tbody>
</table>

EOF;
}


  public function updatePayslip($requestnewupdate='N'){
	$timestamp= date("y/m/d H:i:s", time()) ;
	$sql="UPDATE $this->tablepayslip SET employee_id=$this->employee_id, period_id=$this->period_id, 
		datefrom='$this->datefrom', dateto='$this->dateto', position='$this->position', 
		department='$this->department', basicsalary=$this->basicsalary, commissionamt=$this->commissionamt,
 		hourlycommisionamt=$this->hourlycommisionamt,employee_epfamt=$this->employee_epfamt, 
		employee_socsoamt=$this->employee_socsoamt,employee_pcbamt=$this->employee_pcbamt, 
		employer_socsoamt=$this->employer_socsoamt,employer_epfamt=$this->employer_epfamt, 
		totalincomeamt=$this->totalincomeamt, totaldeductamt=$this->totaldeductamt, 
		netpayamt=$this->netpayamt, epfbaseamt=$this->epfbaseamt, socsobaseamt=$this->socsobaseamt,
		iscomplete='$this->iscomplete', description='$this->description', created='$timestamp', 
		createdby=$this->createdby, updated='$timestamp', updatedby=$this->updatedby, 
		payslipdate='$this->payslipdate', remarks='$this->remarks',needrecalculate='$requestnewupdate'
		where payslip_id=$this->payslip_id";
	$this->log->showLog(4,"Update Payslip With SQL $sql");
	$rs=$this->xoopsDB->query($sql);
	if($rs)
	return true;
	else
	return false;

  }
  public function fetchPayslip(){
	$sql="SELECT employee_id, period_id, datefrom, dateto, position, department, basicsalary, commissionamt,
 		hourlycommisionamt, employee_epfamt, employee_socsoamt, 
		employee_pcbamt,employer_epfamt,employer_socsoamt, totalincomeamt, totaldeductamt, netpayamt, epfbaseamt, socsobaseamt, needrecalculate,
		iscomplete, description, created, createdby, updated, updatedby, payslipdate, remarks,epftype
		from $this->tablepayslip where payslip_id=$this->payslip_id";
	$this->log->showLog(4,"Fetch Payslip Info With SQL $sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){

		$this->employee_id =$row['employee_id'];	
		$this->period_id =$row['period_id'];	
		$this->datefrom	 =$row['datefrom'];	
		$this->dateto	 =$row['dateto'];	
		$this->position	 =$row['position'];	
		$this->department =$row['department'];	
		$this->basicsalary =$row['basicsalary'];	
		$this->commissionamt =$row['commissionamt'];	
		$this->hourlycommisionamt =$row['hourlycommisionamt'];	
		$this->needrecalculate =$row['needrecalculate'];	
		$this->employee_epfamt	=$row['employee_epfamt'];	
		$this->employee_socsoamt =$row['employee_socsoamt'];	
		$this->employee_pcbamt =$row['employee_pcbamt'];	
		$this->employer_epfamt =$row['employer_epfamt'];	
		$this->employer_socsoamt =$row['employer_socsoamt'];	
		$this->totalincomeamt =$row['totalincomeamt'];	
		$this->totaldeductamt =$row['totaldeductamt'];	
		$this->payslipdate =$row['payslipdate'];	
		$this->epftype=$row['epftype'];
		$this->netpayamt	 =$row['netpayamt'];	
		$this->epfbaseamt	 =$row['epfbaseamt'];	
		$this->socsobaseamt	 =$row['socsobaseamt'];	
		$this->iscomplete	 =$row['iscomplete'];	
		$this->description	 =$row['description'];	
		$this->remarks	 =$row['remarks'];
		return true;	
	}
	return false;
  }

  public function autogenerate(){
	$allowcreatepayslip=true;
	$year=0;
	$month=0;
	$sqldate="SELECT year,month from $this->tableperiod where period_id=$this->period_id";
	$querydate=$this->xoopsDB->query($sqldate);
	if($rowdate=$this->xoopsDB->fetchArray($querydate))
	$year=$rowdate['year'];
	$month=$rowdate['month'];

	$this->datefrom="$year-$month-01";
	$this->dateto=date('Y-m-d',
		strtotime('-1 second',
			strtotime('+1 month',strtotime($year.'-'.$month.'-01 00:00:00'))));

	$this->log->showLog(3,"Start autogenerate payslip for employee_id: 
			$this->employee_id,period_id:$this->period_id");
	$timestamp= date("y/m/d H:i:s", time());
	$this->payslipdate= date("y-m-d", time());
	$sql1="SELECT payslip_id from $this->tablepayslip 
		WHERE employee_id=$this->employee_id and period_id=$this->period_id";
	$this->log->showLog(4,"With SQL1 $sql1");
	$query1=$this->xoopsDB->query($sql1);
	$row=$this->xoopsDB->fetchArray($query1);
	if($row['payslip_id'] >0 ){
		$this->payslip_id=$row['payslip_id'];
		$allowcreatepayslip=false;
	}
	if($allowcreatepayslip){
	$sql2="INSERT INTO $this->tablepayslip (employee_id,period_id,basicsalary,department,position,
		createdby,created,updatedby,updated,datefrom,dateto,hourlycommisionamt,commissionamt,
		payslipdate,needrecalculate,epftype) values (
		$this->employee_id,$this->period_id,$this->basicsalary,'$this->department','$this->position',
		$this->createdby,'$timestamp',$this->updatedby,'$timestamp',
		'$this->datefrom','$this->dateto',$this->hourlycommisionamt,$this->commissionamt,
		'$this->payslipdate','N',$this->epftype)";
	$this->log->showLog(4,"With SQL2 $sql2");
	$query=$this->xoopsDB->query($sql2);
	if($query){
		$this->payslip_id=$this->getMaxPayslip_ID();
		return true;
	}
	else
		return false;
	}
	else
	return false;
  }

  public function calculation() {
	$this->log->showLog(3,"Perform calculation for payslip_id $this->payslip_id");

	$this->employer_epfamt=0;
	$this->employer_socsoamt=0;
	$this->employee_socsoamt=0;
	$this->employee_epfamt=0;
	//$this->epfbaseamt;
	//$this->socsobaseamt;

	$sqlsocso="SELECT socso_id, amtfrom, amtto, employer_amt, employee_amt, totalamt, employer_amt2 FROM
		 $this->tablesocso WHERE amtfrom<=$this->socsobaseamt and amtto>=$this->socsobaseamt";

	$sqlepf="SELECT epf_id, amtfrom, amtto, employer_amt, employee_amt,employee_amt2, totalamt FROM
		 $this->tableepf WHERE amtfrom<=$this->epfbaseamt and amtto>=$this->epfbaseamt";
	$this->log->showLog(4,"With sqlsocso: $sqlsocso");
	$this->log->showLog(4,"EPF for this employee: $this->epftype. Get SQL With sqlepf: $sqlepf");

	$querysocso=$this->xoopsDB->query($sqlsocso);
	$queryepf=$this->xoopsDB->query($sqlepf);

	if($rowsocso=$this->xoopsDB->fetchArray($querysocso)){
		$this->employer_socsoamt=$rowsocso['employer_amt'];
		$this->employee_socsoamt=$rowsocso['employee_amt'];
	}
	if($rowepf=$this->xoopsDB->fetchArray($queryepf)){
		if($this->epftype==1)
		$this->employee_epfamt=$rowepf['employee_amt'];
		else
		$this->employee_epfamt=$rowepf['employee_amt2'];

		$this->employer_epfamt=$rowepf['employer_amt'];
	}
//employee_pcbamt=$this->employee_pcbamt,
	$sqlupdate="UPDATE $this->tablepayslip SET 
		employee_epfamt=$this->employee_epfamt, 
		employee_socsoamt=$this->employee_socsoamt, 
		employer_socsoamt=$this->employer_socsoamt,
		employer_epfamt=$this->employer_epfamt, 
		totalincomeamt=$this->totalincomeamt,
		netpayamt=totalincomeamt - totaldeductamt -$this->employee_socsoamt - $this->employee_epfamt,
		totaldeductamt=totaldeductamt + $this->employee_socsoamt + $this->employee_epfamt
		where payslip_id=$this->payslip_id";
	$this->log->showLog(4,"Update payslip info with sqlupdate: $sqlupdate");
	$queryupdate=$this->xoopsDB->query($sqlupdate);
	if($sqlupdate)
	return true;
	else
	return false;
  }

  public function deletePayslip($payslip_id){
	$sqldel="DELETE FROM $this->tablepayslip where payslip_id=$this->payslip_id";
	$this->log->showLog(4,"Delete payslip with sqldel: $sqldel");
	$querydel=$this->xoopsDB->query($sqldel);
	if($querydel)
	return true;
	else
	return false;
  }

 public function getMaxPayslip_ID(){
	$sql="SELECT MAX(payslip_id) as payslip_id FROM $this->tablepayslip";
	$this->log->showLog(4,"Get latest payslip_id with sql: $sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)) {
		$this->log->showLog(4,"Return latest id" .  $row['payslip_id']);
	return $row['payslip_id'];
	}

	return 0;
  }


public function getSQLString ($wherestring,$orderbystring){
	$sql="SELECT o.organization_code,period.period_name, e.employee_id,e.employee_name,
		e.employee_no, p.iscomplete, p.payslip_id,e.epf_no,e.socso_no,
		p.basicsalary, p.netpayamt,p.position, p.department,p.totalincomeamt
		FROM $this->tablepayslip p 
		INNER JOIN $this->tableemployee e on e.employee_id=p.employee_id 
		INNER JOIN $this->tableperiod period on period.period_id=p.period_id
		INNER JOIN $this->tableorganization o on e.organization_id=o.organization_id
		$wherestring $orderbystring";
	return $sql;

} 

  public function showPayslipTable($wherestring,$orderbystring){
	

	$sql=$this->getSQLString($wherestring,$orderbystring);
	$this->log->showLog(3,"Showing Payslip Table with sql :$sql");
	$query=$this->xoopsDB->query($sql);

	echo <<< EOF
	<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Period</th>
				<th style="text-align:center;">Employee No.</th>
				<th style="text-align:center;">Employee Name</th>

				<th style="text-align:center;">Basic Salary</th>
				<th style="text-align:center;">Total Income</th>
				<th style="text-align:center;">Net Pay</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;

		$employee_no=$row['employee_no'];
		$employee_name=$row['employee_name'];
		$organization_code=$row['organization_code'];
		$department=$row['department'];
		$payslip_id=$row['payslip_id'];
		$period_name=$row['period_name'];
		$position=$row['position'];
		$iscomplete=$row['iscomplete'];
		$employee_id=$row['employee_id'];
		$basicsalary=$row['basicsalary'];
		$totalincomeamt=$row['totalincomeamt'];
		$netpayamt=$row['netpayamt'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		if($iscomplete=='N'){
			$actionperform="<form action='payslip.php' method='POST'>".
				"<input type='image' src='images/edit.gif' name='submit' title='Edit this payslip'>".
					"<input type='hidden' value='$payslip_id' name='payslip_id'>".
					"<input type='hidden' name='action' value='edit'></form>";
			$activatectrl="";
			}
		else
			{
			$actionperform="<form action='printpayslip.php' method='POST' target='_blank'>".
				"<input type='image' src='images/list.gif' name='submit' title='Payslipt completed, you only can view this receipt'>".
				"<input type='hidden' value='$payslip_id' name='payslip_id'>
				<input type='hidden' name='action' value='pdf'></form>";
			 if($this->isAdmin == true)
				$activatectrl="<form action='payslip.php' method='POST' onsubmit='return confirm(\"Reactivate this payslip?\")'>".
							"<input type='submit' value='enable' name='submit' title='Reactivate this payslip.'>".
							"<input type='hidden' value='$payslip_id' name='payslip_id'>".
							"<input type='hidden' name='action' value='enable'></form>";
				
			}

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$organization_code</td>
			<td class="$rowtype" style="text-align:center;">$period_name</td>
			<td class="$rowtype" style="text-align:center;">$employee_no</td>
			<td class="$rowtype" style="text-align:center;">$employee_name</td>

			<td class="$rowtype" style="text-align:center;">$basicsalary</td>
			<td class="$rowtype" style="text-align:center;">$totalincomeamt</td>
			<td class="$rowtype" style="text-align:center;">$netpayamt</td>
			<td class="$rowtype" style="text-align:center;">
				$actionperform $activatectrl
			</td>

		</tr>
EOF;
	}//end of while
echo  "</tr></tbody></table>";
  }

   public function enablePayslip($payslip_id){
	$this->log->showLog(2,"Re-enable this payslip: $payslip_id");
	$sql="update $this->tablepayslip set iscomplete='N' where payslip_id=$payslip_id ";
	$this->log->showLog(4,"With SQL:$sql");
	$result=$this->xoopsDB->query($sql);
	if($result){
		$this->log->showLog(3,"Re-activate successfully");
		return true;
	}
	else{
		$this->log->showLog(1,"Re-failed");
		return false;
	}	


  }

  public function getCommssionPercentAmt(){

//calculate total teach amount, deduction due to absent for this month, exclude monthlyclass
//calculate total additional income for class not incharge by employee

	$this->log->showLog(3,"Get commissionamount for employee_id:$this->employee_id, period_id=$this->period_id");
	$this->log->showLog(4,"with SQL: $sql");
	$sql="";
	$this->log->showLog(3,"result=$result");
	return 0;

  }

  public function getAdditionalHourlyAmt(){
	return 0;
  }

  public function getHourlyAmt(){

	$this->log->showLog(3,"Get HourlyAmt for employee_id:$this->employee_id, period_id=$this->period_id");

//calculate total teach amount, deduction due to absent for this month, exclude monthlyclass
//calculate total additional income for class not incharge by employee


	$receivedsql="(coalesce((SELECT sum(pyl.amt) as amount FROM $this->tablepayment py 
			INNER JOIN $this->tablepaymentline pyl on py.payment_id=pyl.payment_id
			INNER JOIN $this->tablestudentclass sc on pyl.studentclass_id=sc.studentclass_id
			where sc.tuitionclass_id=tc.tuitionclass_id and py.iscomplete='Y'),0))";


	$sql="SELECT e.salarytype,tc.tuitionclass_id, tc.classtype, tc.tuitionclass_code, tc.hours,csc.class_datetime,
		tc.employee_id as tc_eid, csc.employee_id as csc_eid, $receivedsql as receivedamt FROM 
		$this->tabletuitionclass tc 
		inner join $this->tableclassschedule csc on tc.tuitionclass_id=csc.tuitionclass_id
		inner join $this->tableemployee e on csc.tuitionclass_id=csc.tuitionclass_id
		where tc.period_id=$this->period_id AND 
		(csc.employee_id=$this->employee_id or tc.employee_id =$this->employee_id) AND
		csc.class_datetime<>'0000-00-00 00:00:00' limit 0,99999";
	$this->log->showLog(4,"with SQL: $sql");
	$this->log->showLog(3,"result=$result");

	return 0;
  }


  public function showTutorCommissionTable($period_id,$employee_id){
	$hourlyamt=0;
	$commissionrate=0;
	$salarytype="";
	echo <<< EOF
<br><br>
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Reference Table</span></big></big></big></div><br>
	<table border='1'>
	  <tbody>
	    <tr>
	      <th colspan="12">Tutor Commission Report (In Charge Class)</th>
	    </tr>
	    <tr>
	      <th style="text-align:center;">No</th>
	      <th style="text-align:center;">Class Code</th>
		<th style="text-align:center;">Class Type</th>
		<th style="text-align:center;">Hours</th>
		<th style="text-align:center;">Head Count</th>
		<th style="text-align:center;">Total Hours</th>
		<th style="text-align:center;">Teach Hours</th>
		<th style="text-align:center;">Total Fees ($this->cur_symbol)</th>
		<th style="text-align:center;">Received Fees ($this->cur_symbol)</th>
		<th style="text-align:center;">Commission ($this->cur_symbol)</th>
	    </tr>
  
EOF;


$sqlteachqty="coalesce((SELECT count(schedule_id) as countschedule FROM $this->tableclassschedule 
	WHERE tc.tuitionclass_id=tuitionclass_id and employee_id=tc.employee_id 
	AND class_datetime<>'0000-00-00 00:00:00'),0)";
$sqlclassqty="coalesce((SELECT count(schedule_id) as countschedule FROM $this->tableclassschedule 
	WHERE tc.tuitionclass_id=tuitionclass_id 
	AND class_datetime<>'0000-00-00 00:00:00'),0)";

$sqlstudentclasscount="coalesce((SELECT count(sc.studentclass_id) as studentcount 
	FROM $this->tablestudentclass sc where sc.tuitionclass_id = tc.tuitionclass_id),0)";

$sqltotalsales="coalesce((SELECT sum(sc.amt) as amt 
	FROM $this->tablestudentclass sc where sc.tuitionclass_id = tc.tuitionclass_id),0)";

$sqltotalpayment= "coalesce((SELECT sum(pyl.trainingamt)  as trainingamt
		FROM $this->tablepayment py 
		INNER JOIN $this->tablepaymentline pyl on py.payment_id=pyl.payment_id
		INNER JOIN $this->tablestudentclass sc on pyl.studentclass_id=sc.studentclass_id
		WHERE sc.tuitionclass_id = tc.tuitionclass_id and sc.studentclass_id>0
		and py.iscomplete='Y'),0)";

$sql="SELECT tc.tuitionclass_id,tc.tuitionclass_code,tc.description, tc.hours, tc.classtype, 
	tc.hours * $sqlclassqty as totalhours, $sqlteachqty * tc.hours as teachhours, $sqltotalsales as salesamt,
	$sqlstudentclasscount as studentcount, $sqltotalpayment as receivedamt,
	e.commissionrate,e.hourlyamt,e.salarytype,e.employee_name
	FROM $this->tabletuitionclass tc
	INNER JOIN $this->tableemployee e on tc.employee_id = e.employee_id 
	WHERE tc.employee_id=$employee_id and tc.period_id=$period_id ";

	$this->log->showLog(3,"Producing center performance reports");
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	$headcount=0;
	$tuitionclass_code=0;
	$classcount=0;
	$inactivecount=0;
	$rowtype="";
	$i=0;
	$totalhours=0;
	$totalsales=0;
	$totalclass=0;
	$totalheadcount=0;
	$totalinactive=0;
	$totalincrease=0;
	$differenceqty=0;

	while($row=$this->xoopsDB->fetchArray($query)){
		$i++;


	switch($classtype)
	{
	case "W":
		$classtype="Weekly";
	break;
	case "V":
		$classtype="Weeklyx2";

	break;
	case "S":
		$classtype="Special";

	break;
	case "M":
		$classtype="Monthly";

	break;

	

	}
	$period_name=$row['period_name'];
	$teachhours=$row['teachhours'];

//	$commissionrate=$row['commissionrate'];

	$employee_name=$row['employee_name'];
	$studentcount=$row['studentcount'];
	$classcount=$row['classcount'];
	$classtype=$row['classtype'];
	$classtypetext="";
	switch($classtype){
		case "W":
			$classtypetext="Weekly";
		break;
		case "V":
			$classtypetext="Weeklyx2";

		break;
		case "M":
			$classtypetext="Monthly";

		break;
		case "S":
			$classtypetext="Special";

		break;

	}
	$hours=$row['hours'];
	$salesamt=$row['salesamt'];
	$totalhours=$row['totalhours'];
	$receivedamt=$row['receivedamt'];
	$tuitionclass_code=$row['tuitionclass_code'];
	$tuitionclass_id=$row['tuitionclass_id'];
	$commissionamt=0;

	$salarytype=$row['salarytype'];
	$hourlyamt=$row['hourlyamt'];
	$commissionrate=$row['commissionrate'];
	$salarytypetext="";
	switch($salarytype){
		case "B":
			$commissionamt=0;
			$salarytypetext="Basic Only";
		break;
		case "H":
			$commissionamt=$teachhours*$hourlyamt;
			$salarytypetext="Hourly Commission";

		break;
		case "C":
			$commissionamt = $salesamt * $commissionrate / 100;
			$salarytypetext="Basic + Sales & Replacement Commission";
		break;
		case "A":
			$commissionamt = $receivedamt * $commissionrate / 100;
			$salarytypetext="Basic + Receipt & Replacement Commission";
		break;
		default:
			$commissionamt=0;
		break;
	}



//	$totalabsent=$absentqty + $totalabsent;
//	$totalclass=$totalclass+$classcount;
	$totalfees=$totalfees+$salesamt;
	$totalreceived=$totalreceived+$receivedamt;

	$totalteachhours=$teachhours+$totalteachhours;
	$totalheadcount=$totalheadcount+$studentcount;
	$totalinactive=$totalinactive+$inactivecount;
	$totalincrease=$totalincrease+$differenceqty;
	$accumulatehours=$totalhours+$accumulatehours;
	$totalcommissionamt=$commissionamt+$totalcommissionamt;

	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

	if($teachhours!=$totalhours)
	$teachhourstext="<b style='color:red;'>$teachhours<b>";
	else
	$teachhourstext=$teachhours;

	$totalfeestext=number_format($totalfees,2);
	$totalreceivedtext=number_format($totalreceived,2);
	$commissionamttext=number_format($commissionamt,2);
	$totalcommissionamttext=number_format($totalcommissionamt,2);
	echo <<< EOF
		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">
				<A href='tuitionclass.php?action=edit&tuitionclass_id=$tuitionclass_id'>
					$tuitionclass_code </A></td>
			<td class="$rowtype" style="text-align:center;">$classtypetext</td>
			<td class="$rowtype" style="text-align:center;">$hours</td>
			<td class="$rowtype" style="text-align:center;">$studentcount</td>
			<td class="$rowtype" style="text-align:center;">$totalhours</td>
			<td class="$rowtype" style="text-align:center;">$teachhourstext</td>

			<td class="$rowtype" style="text-align:right;">$salesamt</td>
			<td class="$rowtype" style="text-align:right;">$receivedamt</td>
			<td class="$rowtype" style="text-align:right;">$commissionamttext</td>
		</tr>
EOF;
	}	

echo <<< EOF
		<tr>
			<td class="foot" style="text-align:center;">Sub Total</td>
			<td class="foot" style="text-align:left;"></td>
			<td class="foot" style="text-align:left;"></td>
			<td class="foot" style="text-align:left;"></td>
			<td class="foot" style="text-align:center;">$totalheadcount</td>
			<td class="foot" style="text-align:center;">$accumulatehours</td>
			<td class="foot" style="text-align:center;">$totalteachhours</td>
			<td class="foot" style="text-align:right;">$totalfeestext</td>
			<td class="foot" style="text-align:right;">$totalreceivedtext</td>
			<td class="foot" style="text-align:right;">$totalcommissionamttext</td>
		</tr>
    <tr>
      <th colspan="12">Tutor Commission Report (Class Replacement)</th>
    </tr>
EOF;
$sqlclassqty="coalesce((SELECT count(schedule_id) as countschedule FROM $this->tableclassschedule 
	WHERE tc.tuitionclass_id=tuitionclass_id 
	AND class_datetime<>'0000-00-00 00:00:00'),0)";

$sqlstudentclasscount="coalesce((SELECT count(sc.studentclass_id) as studentcount 
	FROM $this->tablestudentclass sc where sc.tuitionclass_id = tc.tuitionclass_id),0)";

$sqltotalsales="coalesce((SELECT sum(sc.amt) as amt 
	FROM $this->tablestudentclass sc where sc.tuitionclass_id = tc.tuitionclass_id),0)";

$sqltotalpayment= "coalesce((SELECT sum(pyl.trainingamt)  as trainingamt
		FROM $this->tablepayment py 
		INNER JOIN $this->tablepaymentline pyl on py.payment_id=pyl.payment_id
		INNER JOIN $this->tablestudentclass sc on pyl.studentclass_id=sc.studentclass_id
		WHERE sc.tuitionclass_id = tc.tuitionclass_id and sc.studentclass_id>0
		and py.iscomplete='Y'),0)";


$sqlreplacement="SELECT count(cs.schedule_id) * tc.hours as teachhours, cs.tuitionclass_id, tc.tuitionclass_code,
	tc.classtype,tc.hours, tc.hours * $sqlclassqty as totalhours, $sqltotalsales as salesamt,
	$sqlstudentclasscount as studentcount, $sqltotalpayment as receivedamt
	FROM $this->tableclassschedule  cs
	INNER JOIN $this->tabletuitionclass tc on tc.tuitionclass_id= cs.tuitionclass_id
	WHERE cs.employee_id<> tc.employee_id 
	AND class_datetime<>'0000-00-00 00:00:00'
	AND cs.employee_id=$employee_id
	GROUP BY cs.tuitionclass_id,tc.tuitionclass_code,
	tc.classtype,tc.hours";

$this->log->showLog(4,"Show replacement commission table with SQL: $sqlreplacement");
$queryreplacement=$this->xoopsDB->query($sqlreplacement);
while($rowreplacement=$this->xoopsDB->fetchArray($queryreplacement)){

$i++;

$salesamt=$rowreplacement['salesamt'];
$studentcount=$rowreplacement['studentcount'];
$receivedamt=$rowreplacement['receivedamt'];
$teachhours=$rowreplacement['teachhours'];
$hours=$rowreplacement['hours'];
$totalhours=$rowreplacement['totalhours'];
$classtype=$rowreplacement['classtype'];
$commissionamt=0;

	if($teachhours!=$totalhours)
	$teachhourstext="<b style='color:red;'>$teachhours<b>";
	else
	$teachhourstext=$teachhours;

if($classtype=="M"){
	$commissionamt=0;
}
else{

if($salarytype=="B"){
	$commissionamt=0;
}
else{
	$commissionamt=$teachhours*$hourlyamt;
}

}

$tuitionclass_code=$rowreplacement['tuitionclass_code'];
$tuitionclass_id=$rowreplacement['tuitionclass_id'];

	$classtypetext="";
	switch($classtype){
		case "W":
			$classtypetext="Weekly";
		break;
		case "V":
			$classtypetext="Weeklyx2";

		break;
		case "M":
			$classtypetext="Monthly";

		break;
		case "S":
			$classtypetext="Special";

		break;

	}

	$totalfees=$totalfees+$salesamt;
	$totalreceived=$totalreceived+$receivedamt;
	$totalteachhours=$teachhours+$totalteachhours;
	$totalheadcount=$totalheadcount+$studentcount;
	$totalinactive=$totalinactive+$inactivecount;
	$totalincrease=$totalincrease+$differenceqty;
	$accumulatehours=$totalhours+$accumulatehours;
	$totalcommissionamt=$commissionamt+$totalcommissionamt;
	$commissionamttext=number_format($commissionamt,2);

	echo <<< EOF
		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">
				<A href='tuitionclass.php?action=edit&tuitionclass_id=$tuitionclass_id'>
					$tuitionclass_code </A></td>
			<td class="$rowtype" style="text-align:center;">$classtypetext</td>
			<td class="$rowtype" style="text-align:center;">$hours</td>
			<td class="$rowtype" style="text-align:center;">$studentcount</td>
			<td class="$rowtype" style="text-align:center;">$totalhours</td>
			<td class="$rowtype" style="text-align:center;">$teachhourstext</td>

			<td class="$rowtype" style="text-align:right;">$salesamt</td>
			<td class="$rowtype" style="text-align:right;">$receivedamt</td>
			<td class="$rowtype" style="text-align:right;">$commissionamttext</td>
		</tr>
EOF;
}
		$totalhours=number_format($totalhours,1);
		$totalfees=number_format($totalfees,2);
		//$totalabsent=number_format($totalfees,2);
		$totalreceived=number_format($totalreceived,2);
		$commissionrate = number_format($commissionrate,2);
		$totalcommissionamttext=number_format($totalcommissionamt,2);
	echo <<< EOF
		<tr>
			<th class="$rowtype" style="text-align:center;">Grant Total</th>
			<th class="$rowtype" style="text-align:left;"></th>
			<th class="$rowtype" style="text-align:left;"></th>
			<th class="$rowtype" style="text-align:left;"></th>
			<th class="$rowtype" style="text-align:center;">$totalheadcount</th>
			<th class="$rowtype" style="text-align:center;">$accumulatehours</th>
			<th class="$rowtype" style="text-align:center;">$totalteachhours</th>
			<th class="$rowtype" style="text-align:right;">$totalfees</th>
			<th class="$rowtype" style="text-align:right;">$totalreceived</th>
			<th class="$rowtype" style="text-align:right;">$totalcommissionamttext</th>
		</tr>
		</tbody></table>
	
EOF;

	}

} // end of ClassParents
?>

<?php


class PayslipLine
{
public $payslip_id;
public $payslipline_id;
public $amount;
public $seqno;
public $linetype;
public $iscalc_epf;
public $iscalc_socso;
public $description;

public $employee_id;
public $linepayslipline_id;
public $linedescription;
public $lineseqno;
public $lineiscalc_epf;
public $lineiscalc_socso;
public $lineamount;
public $currentlineno=0;
public $xoopsDB;
public $tableprefix;
public $log;
public $tablepayslip;
public $tablepayslipline;
public $tableemployee;
public $tableemppayslipitem;

public function PayslipLine($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
	$this->tableprefix=$tableprefix;
	$this->tablepayslip=$tableprefix."simtrain_payslip";
	$this->tablepayslipline=$tableprefix."simtrain_payslipline";
	$this->tableemployee=$tableprefix."simtrain_employee";
	$this->tableemppayslipitem=$tableprefix."simtrain_emppayslipitem";
	$this->log=$log;
}

public function showInputForm(){
echo <<< EOF

<script type='text/javascript'>

function validateAddItem(){
	

	if(confirm('Confirm add this item?')){
		var seqno=document.forms['frmAddPayslipItem'].addseqno.value;
		var description=document.forms['frmAddPayslipItem'].adddescription.value;
		var amount=document.forms['frmAddPayslipItem'].addamount.value;
		if(seqno=="" || description =="" || amount =="" || !IsNumeric(seqno) || !IsNumeric(amount)){
		alert("Input error, please make sure Seq No, Amount is numeric and description column not blank.")
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
      <th colspan='7' style='text-align:center'>Add New Item</th>
    </tr>
    <tr><form name='frmAddPayslipItem' onSubmit="return validateAddItem();" method='POST' action='payslip.php'>
      <td class='head' style='text-align:center'>Seq No</td>
      <td class='head' style='text-align:center'>Description</td>
      <td class='head' style='text-align:center'>EPF</td>
      <td class='head' style='text-align:center'>Socso</td>
      <td class='head' style='text-align:center'>Type</td>
      <td class='head' style='text-align:center'>Amount($this->cur_symbol)</td>
      <td class='head' style='text-align:center'>Operation</td>
    </tr>
    <tr>
      <td class='odd' style='text-align:center'><input name='addseqno' size='2' maxlength='2'></td>
      <td class='odd' style='text-align:center'><input name='adddescription' size='30' maxlength='30'></td>
      <td class='odd' style='text-align:center'><input type='checkbox' name='addiscalc_epf'></td>
      <td class='odd' style='text-align:center'><input type='checkbox' name='addiscalc_socso'></td>
      <td class='odd' style='text-align:center'><select name='addlinetype'>
							<option value='1'>Income</option>
							<option value='-1'>Deduct</option>
							<option value='0'>Other</option>
						</select></td>
      <td class='odd' style='text-align:center'>
		<input name='addamount' size='6' maxlength='8' value='0' style='text-align: right' >
	</td>
      <td class='odd' style='text-align:center'><input type='submit' value='Add' name='submit'>
	<input type='hidden' value="$this->payslip_id" name='payslip_id'>
	<input type='hidden' value='addnewitem' name='action'>

	</form></td>
    </tr>
  </tbody>
</table>
EOF;

}

public function updatePayslipLine(){
	$this->log->showLog(3,"Update payslipline");


	$i=0;
	foreach($this->linepayslipline_id as $id )
		{	
			
			$description=$this->linedescription[$i];
			$seqno =$this->lineseqno[$i];
			$iscalc_epf =$this->lineiscalc_epf[$i];
			if($iscalc_epf=='on')
				$iscalc_epf=1;
			else
				$iscalc_epf=0;

			$iscalc_socso =$this->lineiscalc_socso[$i];
			if($iscalc_socso=='on')
				$iscalc_socso=1;
			else
				$iscalc_socso=0;

			$amount =$this->lineamount[$i];

			$sql="UPDATE $this->tablepayslipline SET description='$description',
				seqno=$seqno, iscalc_epf=$iscalc_epf, iscalc_socso=$iscalc_socso,
				amount=$amount WHERE payslipline_id=$id";

			$this->log->showLog(4,"Update payslipline with SQL: $sql");
			$rs=$this->xoopsDB->query($sql);
			if(!$rs){
				$this->log->showLog(4,"<br><b style='color: red'>Failed to update payslipline_id: $id </b>");
				return false;
			}
			else
				$this->log->showLog(4,"Update payslipline_id: $id successfully");
			$i=$i+1;
		}
	  return true;
}

public function showPayslipLine($payslip_id,$type=1){
	$tablestring="";
	$onchange="onchange='recalculate()'";
	$sql="SELECT payslipline_id, seqno, description, amount, linetype, iscalc_epf, 
		iscalc_socso FROM $this->tablepayslipline where payslip_id=$payslip_id AND linetype=$type order by seqno";
	$this->log->showLog(3,"Show income line with SQL: $sql");

	$query=$this->xoopsDB->query($sql);
	
	while($row=$this->xoopsDB->fetchArray($query)){
	$payslipline_id=$row['payslipline_id'];
	$seqno = $row['seqno'];
	$description = $row['description'];
	$amount = $row['amount'];
	$linetype=$row['linetype'];

	if( $row['iscalc_epf']==1)
		$iscalc_epf='checked';
	else
		$iscalc_epf='';

	if( $row['iscalc_socso']==1)
		$iscalc_socso='checked';
	else
		$iscalc_socso='';
	


	$tablestring=$tablestring . "\n" . "<tr>
		<td>
			<input name='lineseqno[$this->currentlineno]' size='1' maxlength='3' value='$seqno'
				 id='lineseqno$this->currentlineno'>
			<input type='hidden' name='linepayslipline_id[$this->currentlineno]'
				 id='linepayslipline_id$this->currentlineno' value='$payslipline_id'>
		</td>
		<td>
			<input name='linedescription[$this->currentlineno]' id='linedescription$this->currentlineno'
				value='$description' size='15'>
		</td>
		<td style='text-align: center;'>
			<input type='checkbox' name='lineiscalc_epf[$this->currentlineno]' 
				id='lineiscalc_epf$this->currentlineno' $iscalc_epf $onchange>
		</td>
		<td style='text-align: center;'>
			<input type='checkbox' name='lineiscalc_socso[$this->currentlineno]' 
				id='lineiscalc_socso$this->currentlineno'  $iscalc_socso $onchange>

		</td>
		<td style='text-align: right;'>
			<input type='hidden' name='linelinetype[$this->currentlineno]' value='$linetype'
				id='linelinetype$this->currentlineno'>

			<input type='button' name='btnRemoveItem' value='X'
				onclick='removeitem($payslipline_id)'>
			<input name='lineamount[$this->currentlineno]' value='$amount' $onchange
				id='lineamount$this->currentlineno' size='6' maxlength='8' style='text-align: right'>
		</td>
		</tr>";
$this->currentlineno++;
	}
	if($type==0)
	$tablestring=$tablestring."<input type='hidden' name='linecount' value='$this->currentlineno'>";
return $tablestring;

}



public function insertPaslipLine(){
	$sql="INSERT INTO  $this->tablepayslipline (payslip_id, seqno, description, amount, linetype, iscalc_epf, 
		iscalc_socso) VALUES (
		$this->payslip_id, $this->seqno, '$this->description', 
		$this->amount, $this->linetype, $this->iscalc_epf, 
		$this->iscalc_socso)";
	$this->log->showLog(3,"Show income line with SQL: $sql");

	$rs=$this->xoopsDB->query($sql);
	if($rs){
	$sqlupdate="UPDATE $this->tablepayslip SET needrecalculate='Y' WHERE
		payslip_id=$this->payslip_id";
	$this->log->showLog(3,"Update tablepayslip with SQL: $sqlupdate");

	$rsupdate=$this->xoopsDB->query($sqlupdate);
	if($rsupdate)
		return true;
	else
		return false;
	}
	else
		return false;
}

 public function createEmployeeItem(){
	$sql="SELECT amount, emppayslipitem_name, seqno, calc_epf, calc_socso, linetype
		FROM $this->tableemppayslipitem 
		WHERE employee_id=$this->employee_id and isactive='Y' 
		order by seqno";
	$this->log->showLog(4,"Generate default payslip_id item with sql: $sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)) {
		$payslip_id= $this->payslip_id;
		$seqno=$row['seqno'];
		$description=$row['emppayslipitem_name'];
		$amount =$row['amount'];
		$linetype =$row['linetype'];
		$iscalc_epf =$row['calc_epf'];
		$iscalc_socso =$row['calc_socso'];
		$sqlinsert="INSERT INTO  $this->tablepayslipline (payslip_id, seqno, description, amount, linetype, 
			iscalc_epf,iscalc_socso) VALUES ($payslip_id, $seqno, '$description', 
			$amount, $linetype, $iscalc_epf, $iscalc_socso)";
		$rs=$this->xoopsDB->query($sqlinsert);
		$this->log->showLog(4,"With SQL Insert: $sqlinsert");
		if(!$rs)
			return false;

	}
	return true;
  }

  public function deleteItem($removeitem_id){
	$sqldel="DELETE FROM $this->tablepayslipline where payslipline_id=$removeitem_id";
	$this->log->showLog(4,"Delete payslipline with sqldel: $sqldel");
	$querydel=$this->xoopsDB->query($sqldel);
	if($querydel){

		$sqlupdate="UPDATE $this->tablepayslip SET needrecalculate='Y' WHERE
			payslip_id=$this->payslip_id";
		$this->log->showLog(3,"Update tablepayslip with SQL: $sqlupdate");

		$queryupdate=$this->xoopsDB->query($sqlupdate);
		if($queryupdate)
			return true;
		else
			return false;
	}
	else
	return false;
  }
} // end of ClassParents
?>

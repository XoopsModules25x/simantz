<?php

class receiptline{

private $tablereceipt;
private $tablereceiptline;
private $xoopsDB;
private $log;

public function receiptline(){
global $tablereceipt,$tablereceiptline,$xoopsDB,$log,$tableaccounts;

$this->tablereceipt=$tablereceipt;
$this->tablereceiptline=$tablereceiptline;
$this->tableaccounts=$tableaccounts;
$this->xoopsDB=$xoopsDB;
$this->log=$log;

}

  public function showreceiptline($receipt_id,$readonly='N'){
	global $ctrl;
	$result="<tr><td class='head'>Detail <br>Use F8/F9 to jump row,<br>Tab/Shift Tab to <br>navigate column</td>
		<td colspan='3' aclass='head'>
		<table  cellspacing=0 border=0 cellpadding=0><tbody>
			<tr align='center'>
			<th>No</th>
			<th>Item</th>
			<th>Account</th>
			<th>Cheque No</th>
			<th>Amount</th>
			<th>Del</th>
			</tr>
			";
	$sql="SELECT pivl.receiptline_id,pivl.subject,pivl.amt,pivl.description,pivl.accounts_id,pivl.chequeno,acc.account_type 
		FROM $this->tablereceiptline pivl, $this->tableaccounts acc 
		where pivl.accounts_id = acc.accounts_id 
		and pivl.receipt_id=$receipt_id order by pivl.receiptline_id";
	$this->log->showLog(4,"Call purchase invoice line with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	$i=0;
	$rowtype="";
	while($row=$this->xoopsDB->fetchArray($query)) {

		$account_type=$row['account_type'];
		$subject=$row['subject'];
		$description=$row['description'];
		$amt=$row['amt'];
		$accounts_id=$row['accounts_id'];
		$chequeno=$row['chequeno'];
		$receiptline_id=$row['receiptline_id'];
		$nextid=$i+1;
		if($i>0)
		$previousid=$i-1;
		else
		$previousid=0;

		$alignR="style='text-align:right'";
		if($description!="")
		$displaydescstyle="";
		else
		$displaydescstyle="style='display:none'";

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		if($account_type==4)
		$displaychequenostyle="";
		else
		$displaychequenostyle="style='display:none'";

		$accountsctrl=$ctrl->getSelectAccounts($accounts_id,'Y',"onchange='reloadAccountTo(this.value,$i)' onKeyDown='return  changearrayfieldEnter(event,\"lineaccounts_id\",$nextid,$previousid,\"lineaccounts_id\",this);'","lineaccounts_id[]"," and (account_type=4 or account_type=7) ","lineaccounts_id$i");

		$result=$result."

		<tr>
		<td class='$rowtype'><font color=black>".($i+1)." </font><input type='hidden' name='linereceiptline_id[$i]' value='$receiptline_id'></td>
		<td class='$rowtype'>
		<input name='linesubject[$i]' value='$subject' size='40' maxlength='65' id='linesubject$i'
		onKeyDown='return changearrayfieldEnter(event,\"linesubject\",$nextid,$previousid,\"linesubject\",this);'
		onfocus='this.select();'><a href='javascript:;' onclick='showHideDesc($i)'>V</a><br>
		<textarea name='linedescription[$i]' id='linedescription$i' cols=45 rows=5 $displaydescstyle
		onKeyDown='return changearrayfieldEnter(event,\"linesubject\",$nextid,$previousid,\"linesubject\",this);'
		onfocus='this.select();'>$description</textarea>
		</td>
		<td class='$rowtype'>$accountsctrl</td>
		<td class='$rowtype'>
		
		<input name='linechequeno[$i]' value='$chequeno' size='12' maxlength='20' id='linechequeno$i'
		onKeyDown='return changearrayfieldEnter(event,\"linechequeno\",$nextid,$previousid,\"linechequeno\",this);'
		onfocus='this.select();' $displaychequenostyle>
		
		</td>
		<td class='$rowtype'>
		<input $alignR name='lineamt[$i]' value='$amt' size='12' maxlength='12' id='lineamt$i'
		onKeyDown='return changearrayfieldEnter(event,\"lineamt\",$nextid,$previousid,\"lineamt\",this);'
		onfocus='this.select();' onblur='calculateSummary();'>
		</td>
		<td class='$rowtype'>
		<input type='checkbox' name='linedel[$i]' id='linedel$i'
		onKeyDown='return changearrayfieldEnter(event,\"linedel\",$nextid,$previousid,\"linedel\",this);'>
		</td>
		</tr>
		";
		
	$i++;
	}

	return $result;
	}

  public function createReceiptLine($receipt_id,$addqty){
	if($addqty==0){
		$this->log->showLog(4,"function createreceiptline add 0 line, return true");
		return true;
	}
	elseif($receipt_id >0 && $addqty >0){
		global $enddiscountpercent;
		$sql="INSERT INTO $this->tablereceiptline (receipt_id) VALUES ";
		$i=0;
	
		while($i<$addqty){
			$i++;
			$sql=$sql."($receipt_id),";
		}
		$sql=substr_replace($sql,"",-1,1);
		$this->log->showLog(4,"createreceiptline add $addqty line, with receipt_id: $receipt_id
		with SQL: $sql");
		$rs=$this->xoopsDB->query($sql);

		if($rs){
			$this->log->showLog(4,"create $addqty receiptline successfully");
			return true;
		}
		else{
				$this->log->showLog(1,'create receiptline failed');
				return false;
			}
			
	}
	else{
		$this->log->showLog(1,"function createreceiptline add line qty: $addqty, but receipt_id<=0");
		return false;
	}
  }

 public function updateReceiptLine(){
	$this->log->showLog(4,"call Updatereceiptline.");
	$i=0;
	foreach ($this->linereceiptline_id as $receiptline_id){
		$subject=$this->linesubject[$i];
		$description=$this->linedescription[$i];
		$chequeno=$this->linechequeno[$i];
		$amt=$this->lineamt[$i];
		$accounts_id=$this->lineaccounts_id[$i];
		$isdel=$this->linedel[$i];
		//$receiptline_id
		//
		if($isdel=='on'){
		$this->log->showLog(3,"Delete receiptline:$receiptline_id");
		$this->deletereceiptline($receiptline_id);
		}
		else{
		$sql="UPDATE $this->tablereceiptline SET subject='$subject',description='$description',
			chequeno='$chequeno',amt=$amt,accounts_id=$accounts_id
			where receiptline_id=$receiptline_id";
		
		$rs=$this->xoopsDB->query($sql);
		if($rs)
		$this->log->showLog(4,"Updatereceiptline successfully with SQL: $sql");
		else
		$this->log->showLog(1,"Updatereceiptline failed with SQL: $sql");
		}
	$i++;
	}
	
 }

public function deleteUnuseLine($receipt_id){
	$this->log->showLog(4,"call Delete Unuse line.");
	
		
	$sql = "DELETE from $this->tablereceiptline 
		where receipt_id=$receipt_id 
		and amt = 0 ";
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs)
	$this->log->showLog(1,"Updatereceiptline failed with SQL: $sql");
	
	
 }

  public function deletereceiptline($receiptline_id){
	$this->log->showLog(2,"Warning: Performing delete receipt id : $receipt_id !");
	$sql="DELETE FROM $this->tablereceiptline where receiptline_id=$receiptline_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: receiptline ($receiptline_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"receiptline ($receiptline_id) removed from database successfully!");
		return true;
		
	}
 }

  public function updateTotalAmt($receipt_id,$cur,$currency_id){
	global $defaultcurrency_id;

	$sql = "select sum(amt) as tot_amt from $this->tablereceiptline where receipt_id = $receipt_id";

//	$exchangerate = $cur->checkExchangeRate($currency_id,$defaultcurrency_id);
	$exchangerate = $this->getExchangerateReceipt($receipt_id);

	
	$sqlupdate = "update $this->tablereceipt set originalamt = ($sql), amt = $exchangerate*($sql) 
			where receipt_id = $receipt_id";

	$this->log->showLog(4,"update SQL Statement: $sqlupdate");

	$rs=$this->xoopsDB->query($sqlupdate);
	if (!$rs){
		$this->log->showLog(1,"Error: update total amount:" . mysql_error(). ":$sqlupdate");
		return false;
	}
  }

  public function getExchangerateReceipt($receipt_id){
	$retval=1;
	$sql = "select exchangerate from $this->tablereceipt where receipt_id = $receipt_id ";

	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['exchangerate'];
	}

	return $retval;
  }

}
?>
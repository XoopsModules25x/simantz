<?php

class debitcreditnoteLine{

private $tabledebitcreditnote;
private $tabledebitcreditnoteline;
private $xoopsDB;
private $log;

public function debitcreditnoteLine(){
global $tabledebitcreditnote,$tabledebitcreditnoteline,$xoopsDB,$log;

$this->tabledebitcreditnote=$tabledebitcreditnote;
$this->tabledebitcreditnoteline=$tabledebitcreditnoteline;
$this->xoopsDB=$xoopsDB;
$this->log=$log;

}

  public function showdebitcreditnoteLine($debitcreditnote_id,$readonly='N'){
	global $ctrl;
	$result="<tr><td class='head'>Detail <br>Use F8/F9 to jump row,<br>Tab/Shift Tab to <br>navigate column</td>
		<td colspan='3' aclass='head'>
		<table  cellspacing=0 border=0 cellpadding=0><tbody>
			<tr align='center'>
			<th>No</th>
			<th>Item</th>
			<th>Account</th>
			<th>Unit Price</th>
			<th>Qty/UOM</th>
			<th>Amount</th>
			<th>Del</th>
			</tr>
			";
	$sql="SELECT pivl.debitcreditnoteline_id,pivl.subject, pivl.amt, pivl.qty, pivl.description, 
		pivl.uom,pivl.unitprice,pivl.accounts_id FROM $this->tabledebitcreditnoteline pivl
		where pivl.debitcreditnote_id=$debitcreditnote_id order by pivl.debitcreditnoteline_id";
	$this->log->showLog(4,"Call purchase invoice line with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	$i=0;
	$rowtype="";
	while($row=$this->xoopsDB->fetchArray($query)) {
		$subject=$row['subject'];
		$description=$row['description'];
		$amt=$row['amt'];
		$qty=$row['qty'];
		$uom=$row['uom'];
		$unitprice=$row['unitprice'];
		$accounts_id=$row['accounts_id'];
		$debitcreditnoteline_id=$row['debitcreditnoteline_id'];
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

		$accountsctrl=$ctrl->getSelectAccounts($accounts_id,'Y',"onKeyDown='return  changearrayfieldEnter(event,\"lineaccounts_id\",$nextid,$previousid,\"lineaccounts_id\",this);'","lineaccounts_id[]"," and (account_type<>2 AND account_type<>3) ","lineaccounts_id$i");

		$result=$result."

		<tr>
		<td class='$rowtype'><font color=black>".($i+1)." </font><input type='hidden' name='linedebitcreditnoteline_id[$i]' value='$debitcreditnoteline_id'></td>
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
		<input $alignR name='lineunitprice[$i]' value='$unitprice' size='12' maxlength='12' id='lineunitprice$i'
		onKeyDown='return changearrayfieldEnter(event,\"lineunitprice\",$nextid,$previousid,\"lineunitprice\",this);'
		onfocus='this.select();' onchange='calculateLine($i);calculatesummary()'>
		</td>
		<td class='$rowtype'>
		<input $alignR name='lineqty[$i]' value='$qty' size='12' maxlength='12' id='lineqty$i'
		onKeyDown='return changearrayfieldEnter(event,\"lineqty\",$nextid,$previousid,\"lineqty\",this);'
		onfocus='this.select();' onchange='calculateLine($i);calculatesummary()'>
		
		<input name='lineuom[$i]' value='$uom' size='10' maxlength='10' id='lineuom$i'
		onKeyDown='return changearrayfieldEnter(event,\"lineuom\",$nextid,$previousid,\"lineuom\",this);'
		onfocus='this.select();'>
		</td>
		<td class='$rowtype'>
		<input $alignR name='lineamt[$i]' value='$amt' size='12' maxlength='12' id='lineamt$i'
		onKeyDown='return changearrayfieldEnter(event,\"lineamt\",$nextid,$previousid,\"lineamt\",this);'
		onfocus='this.select();' readonly='readonly'>
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

  public function createdebitcreditnoteLine($debitcreditnote_id,$addqty){
	if($addqty==0){
		$this->log->showLog(4,"function createdebitcreditnoteLine add 0 line, return true");
		return true;
	}
	elseif($debitcreditnote_id >0 && $addqty >0){
		global $enddiscountpercent;
		$sql="INSERT INTO $this->tabledebitcreditnoteline (debitcreditnote_id) VALUES ";
		$i=0;
	
		while($i<$addqty){
			$i++;
			$sql=$sql."($debitcreditnote_id),";
		}
		$sql=substr_replace($sql,"",-1,1);
		$this->log->showLog(4,"createdebitcreditnoteLine add $addqty line, with debitcreditnote_id: $debitcreditnote_id
		with SQL: $sql");
		$rs=$this->xoopsDB->query($sql);

		if($rs){
			$this->log->showLog(4,"create $addqty debitcreditnoteline successfully");
			return true;
		}
		else{
				$this->log->showLog(1,'create debitcreditnoteline failed');
				return false;
			}
			
	}
	else{
		$this->log->showLog(1,"function createdebitcreditnoteLine add line qty: $addqty, but debitcreditnote_id<=0");
		return false;
	}
  }

 public function updatedebitcreditnoteLine(){
	$this->log->showLog(4,"call UpdatedebitcreditnoteLine.");
	$i=0;
	foreach ($this->linedebitcreditnoteline_id as $debitcreditnoteline_id){
		$subject=$this->linesubject[$i];
		$description=$this->linedescription[$i];
		$qty=$this->lineqty[$i];
		//$amt=$this->lineamt[$i];
		$amt=getCentSalesPoint($this->lineamt[$i]);
		$uom=$this->lineuom[$i];
		$unitprice=$this->lineunitprice[$i];
		$accounts_id=$this->lineaccounts_id[$i];
		$isdel=$this->linedel[$i];
		//$debitcreditnoteline_id
		//
		if($isdel=='on'){
		$this->log->showLog(3,"Delete debitcreditnoteline:$debitcreditnoteline_id");
		$this->deletedebitcreditnoteLine($debitcreditnoteline_id);
		}
		else{
		$sql="UPDATE $this->tabledebitcreditnoteline SET subject='$subject',description='$description',
			uom='$uom',amt=$amt,qty=$qty,unitprice=$unitprice,accounts_id=$accounts_id
			where debitcreditnoteline_id=$debitcreditnoteline_id";
		
		$rs=$this->xoopsDB->query($sql);
		if($rs)
		$this->log->showLog(4,"UpdatedebitcreditnoteLine successfully with SQL: $sql");
		else
		$this->log->showLog(1,"UpdatedebitcreditnoteLine failed with SQL: $sql");
		}
	$i++;
	}
	
 }

public function deleteUnuseLine($debitcreditnote_id){
	$this->log->showLog(4,"call Delete Unuse line.");
	
		
	$sql = "DELETE from $this->tabledebitcreditnoteline 
		where debitcreditnote_id=$debitcreditnote_id 
		and amt = 0 ";
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs)
	$this->log->showLog(1,"UpdatedebitcreditnoteLine failed with SQL: $sql");
	
	
 }

  public function deletedebitcreditnoteLine($debitcreditnoteline_id){
	$this->log->showLog(2,"Warning: Performing delete debitcreditnote id : $debitcreditnote_id !");
	$sql="DELETE FROM $this->tabledebitcreditnoteline where debitcreditnoteline_id=$debitcreditnoteline_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: debitcreditnoteline ($debitcreditnoteline_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"debitcreditnoteline ($debitcreditnoteline_id) removed from database successfully!");
		return true;
		
	}
 }

  public function updateTotalAmt($debitcreditnote_id,$cur,$currency_id,$itemqty){
	global $defaultcurrency_id;

	$sql = "select sum(amt) as tot_amt from $this->tabledebitcreditnoteline where debitcreditnote_id = $debitcreditnote_id";

//	$exchangerate = $cur->checkExchangeRate($currency_id,$defaultcurrency_id);
	$exchangerate = $this->getExchangerateDC($debitcreditnote_id);
	
	$sqlupdate = "update $this->tabledebitcreditnote set originalamt = ($sql), amt = $exchangerate*($sql), itemqty = $itemqty  
			where debitcreditnote_id = $debitcreditnote_id";

	$this->log->showLog(4,"update SQL Statement: $sqlupdate");

	$rs=$this->xoopsDB->query($sqlupdate);
	if (!$rs){
		$this->log->showLog(1,"Error: update total amount:" . mysql_error(). ":$sqlupdate");
		return false;
	}
  }

  public function getExchangerateDC($debitcreditnote_id){
	$retval=1;
	$sql = "select exchangerate from $this->tabledebitcreditnote where debitcreditnote_id = $debitcreditnote_id ";

	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['exchangerate'];
	}

	return $retval;
  }

}
?>
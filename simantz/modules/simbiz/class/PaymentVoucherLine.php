<?php

class paymentvoucherline{

private $tablepaymentvoucher;
private $tablepaymentvoucherline;
private $xoopsDB;
private $log;

public function paymentvoucherline(){
global $tablepaymentvoucher,$tablepaymentvoucherline,$xoopsDB,$log,$tableaccounts;

$this->tablepaymentvoucher=$tablepaymentvoucher;
$this->tablepaymentvoucherline=$tablepaymentvoucherline;
$this->tableaccounts=$tableaccounts;
$this->xoopsDB=$xoopsDB;
$this->log=$log;

}

  public function showpaymentvoucherline($paymentvoucher_id,$readonly='N'){
	global $simbizctrl;
	$result="<tr><td class='head'>Detail <br>Use F8/F9 to jump row,<br>Tab/Shift Tab to <br>navigate column</td>
		<td colspan='3' aclass='head'>
		<table  cellspacing=0 border=0 cellpadding=0><tbody>
			<tr align='center'>
			<th>No</th>
			<th>Item</th>
			<th>Account</th>
			<th>Amount</th>
			<th>Del</th>
			</tr>
			";
	$sql="SELECT pivl.paymentvoucherline_id,pivl.subject,pivl.amt,pivl.description,pivl.accounts_id,pivl.bpartner_id,acc.account_type
		FROM $this->tablepaymentvoucherline pivl, $this->tableaccounts acc
		where pivl.accounts_id = acc.accounts_id
		and pivl.paymentvoucher_id=$paymentvoucher_id order by pivl.paymentvoucherline_id";
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
		$bpartner_id=$row['bpartner_id'];
		$paymentvoucherline_id=$row['paymentvoucherline_id'];
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
		$displaybpartner_idstyle="";
		else
		$displaybpartner_idstyle="style='display:none'";

		/*
		$accountsctrl=$ctrl->getSelectAccounts($accounts_id,'Y',"onchange='reloadAccountTo(this.value,$i)' onKeyDown='return  changearrayfieldEnter(event,\"lineaccounts_id\",$nextid,$previousid,\"lineaccounts_id\",this);'","lineaccounts_id[]"," and (account_type=4 or account_type=7) ","lineaccounts_id$i");*/

//		$accountsctrl=$ctrl->getSelectAccounts($accounts_id,'Y',"onchange='reloadAccountTo(this.value,$i)' onKeyDown='return  changearrayfieldEnter(event,\"lineaccounts_id\",$nextid,$previousid,\"lineaccounts_id\",this);'","lineaccounts_id[]"," and (account_type=1 or account_type=2 or account_type=3)","lineaccounts_id$i");

		$accountsctrl=$simbizctrl->getSelectAccounts($accounts_id,'Y',"onchange='reloadAccountTo(this.value,$i)' ","lineaccounts_id[]"," ","lineaccounts_id$i");

		if($bpartner_id > 0 ){
			if($account_type==2){
			$bpartnerctrl=$simbizctrl->getSelectBPartner($bpartner_id,'N',"onchange='changePaidTo(this)' ","linebpartner_id[$i]",
					" and (debtoraccounts_id = $accounts_id and isdebtor=1) ",'N',"linebpartner_id$i");
			}elseif($account_type==3){
			$bpartnerctrl=$simbizctrl->getSelectBPartner($bpartner_id,'N'," ","linebpartner_id[$i]",
					" and (creditoraccounts_id = $accounts_id and iscreditor=1) ",'N',"linebpartner_id$i");
			}
		}else{
			$bpartnerctrl = "<option value='0'>Null</option>";
		}


		$result=$result."

		<tr>
		<td class='$rowtype'><font color=black>".($i+1)." </font><input type='hidden' name='linepaymentvoucherline_id[$i]' value='$paymentvoucherline_id'></td>
		<td class='$rowtype'>
		<input name='linesubject[$i]' value='$subject' size='40' maxlength='65' id='linesubject$i'
		onfocus='this.select();'><a href='javascript:;' onclick='showHideDesc($i)'>V</a><br>
		<textarea name='linedescription[$i]' id='linedescription$i' cols=45 rows=5 $displaydescstyle

		onfocus='this.select();'>$description</textarea>
		</td>
		<td class='$rowtype'>$accountsctrl <select name='linebpartner_id[$i]' id='linebpartner_id$i' onchange='changePaidTo(this)'>$bpartnerctrl</select></td>

		<td class='$rowtype'>
		<input $alignR name='lineamt[$i]' value='$amt' size='12' maxlength='12' id='lineamt$i'
		onfocus='this.select();' onblur='this.value=parseFloat(this.value).toFixed(2);calculateSummary();'>
		</td>
		<td class='$rowtype'>
		<input type='checkbox' name='linedel[$i]' id='linedel$i'>
		</td>
		</tr>
		";

	$i++;
	}

	return $result;
	}

  public function createPaymentVoucherLine($paymentvoucher_id,$addqty){
	if($addqty==0){
		$this->log->showLog(4,"function createpaymentvoucherline add 0 line, return true");
		return true;
	}
	elseif($paymentvoucher_id >0 && $addqty >0){
		global $enddiscountpercent;
		$sql="INSERT INTO $this->tablepaymentvoucherline (paymentvoucher_id) VALUES ";
		$i=0;

		while($i<$addqty){
			$i++;
			$sql=$sql."($paymentvoucher_id),";
		}
		$sql=substr_replace($sql,"",-1,1);
		$this->log->showLog(4,"createpaymentvoucherline add $addqty line, with paymentvoucher_id: $paymentvoucher_id
		with SQL: $sql");
		$rs=$this->xoopsDB->query($sql);

		if($rs){
			$this->log->showLog(4,"create $addqty paymentvoucherline successfully");
			return true;
		}
		else{
				$this->log->showLog(1,'create paymentvoucherline failed');
				return false;
			}

	}
	else{
		$this->log->showLog(1,"function createpaymentvoucherline add line qty: $addqty, but paymentvoucher_id<=0");
		return false;
	}
  }

 public function updatePaymentVoucherLine(){
	$this->log->showLog(4,"call Updatepaymentvoucherline.");
	$i=0;
	foreach ($this->linepaymentvoucherline_id as $paymentvoucherline_id){
		$subject=$this->linesubject[$i];
		$description=$this->linedescription[$i];
		$bpartner_id=$this->linebpartner_id[$i];
		$amt=$this->lineamt[$i];
		$accounts_id=$this->lineaccounts_id[$i];
		$isdel=$this->linedel[$i];
		//$paymentvoucherline_id
		//
		if($isdel=='on'){
		$this->log->showLog(3,"Delete paymentvoucherline:$paymentvoucherline_id");
		$this->deletepaymentvoucherline($paymentvoucherline_id);
		}
		else{
		$sql="UPDATE $this->tablepaymentvoucherline SET subject='$subject',description='$description',
			bpartner_id=$bpartner_id,amt=$amt,accounts_id=$accounts_id
			where paymentvoucherline_id=$paymentvoucherline_id";

		$rs=$this->xoopsDB->query($sql);
		if($rs)
		$this->log->showLog(4,"Updatepaymentvoucherline successfully with SQL: $sql");
		else
		$this->log->showLog(1,"Updatepaymentvoucherline failed with SQL: $sql");
		}
	$i++;
	}

 }

public function deleteUnuseLine($paymentvoucher_id){
	$this->log->showLog(4,"call Delete Unuse line.");


	$sql = "DELETE from $this->tablepaymentvoucherline
		where paymentvoucher_id=$paymentvoucher_id
		and amt = 0 ";

	$rs=$this->xoopsDB->query($sql);
	if(!$rs)
	$this->log->showLog(1,"Updatepaymentvoucherline failed with SQL: $sql");


 }

  public function deletepaymentvoucherline($paymentvoucherline_id){
	$this->log->showLog(2,"Warning: Performing delete paymentvoucher id : $paymentvoucher_id !");
	$sql="DELETE FROM $this->tablepaymentvoucherline where paymentvoucherline_id=$paymentvoucherline_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");

	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: paymentvoucherline ($paymentvoucherline_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"paymentvoucherline ($paymentvoucherline_id) removed from database successfully!");
		return true;

	}
 }

  public function updateTotalAmt($paymentvoucher_id,$cur,$currency_id){
	global $defaultcurrency_id;

	$sql = "select sum(amt) as tot_amt from $this->tablepaymentvoucherline where paymentvoucher_id = $paymentvoucher_id";

	//$exchangerate = $cur->checkExchangeRate($currency_id,$defaultcurrency_id);
	$exchangerate = $this->getExchangeratePV($paymentvoucher_id);

	$sqlupdate = "update $this->tablepaymentvoucher set originalamt = ($sql), amt = $exchangerate*($sql)
			where paymentvoucher_id = $paymentvoucher_id";

	$this->log->showLog(4,"update SQL Statement: $sqlupdate");

	$rs=$this->xoopsDB->query($sqlupdate);
	if (!$rs){
		$this->log->showLog(1,"Error: update total amount:" . mysql_error(). ":$sqlupdate");
		return false;
	}
  }

  public function getExchangeratePV($paymentvoucher_id){
	$retval=1;
	$sql = "select exchangerate from $this->tablepaymentvoucher where paymentvoucher_id = $paymentvoucher_id ";

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['exchangerate'];
	}

	return $retval;
  }

}

<?php
class Transaction {

	public $trans_id;
	public $document_no;
	public $document_no2;
	public $batch_id;
	public $amt;
	public $originalamt;
	public $created;
	public $createdby;
	public $updated;
	public $updatedby;
	public $tax_id;
	public $currency_id;
	public $transtype;
	public $accounts_id;
	public $maxlineno;
	public $multiplyconversion;
	public $newtrans_accounts_id;
	public $addnewcounterline;

  public function Transaction(){
	global $xoopsDB,$log,$tablebatch,$tablebpartner,$tablebpartnergroup,$tableorganization,$defaultorganization_id,$tabletransaction,
		$tableaccounts,$tabletranssummary,$tableperiod;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablebatch=$tablebatch;
	$this->tablebpartner=$tablebpartner;
	$this->tableaccounts=$tableaccounts;
	$this->tabletransaction=$tabletransaction;
	$this->tabletranssummary=$tabletranssummary;
	$this->defaultorganization_id=$defaultorganization_id;
	$this->tableperiod=$tableperiod;
	$this->log=$log;
}

  public function insertBlankLine($batch_id,$lineqty=1,$reference_id,$bpartner_id,$accounts_id=0,$amt=0,$docno="",$docno2=""){
 	 $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting $lineqty line into batch $batch_if");
 	$sql="INSERT INTO $this->tabletransaction (seqno,batch_id,accounts_id,reference_id,bpartner_id,amt,document_no,document_no2)
		VALUES ";
	for($i=0;$i<$lineqty;$i++){

		//if($startseqno>0)
			$this->maxlineno++;

		$sql=$sql . "($this->maxlineno,$batch_id,$accounts_id,$reference_id,$bpartner_id,$amt,'$docno','$docno2'),";
	}
	//$this->maxlineno++;

	$sql=substr_replace($sql,"",-1);
	$this->log->showLog(3,"Before insert trans SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert batch code $batch_name:" . mysql_error() . ":$sql". "at line" . __LINE__);
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new batch $batch_name successfully"); 
		return true;
	}
  
}

 public function insertDefaultLine($batch_id,$accounts_id,$amt,$bpartner_id,$docno="",$docno2=""){
 	 $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting $lineqty line into batch $batch_if");
	//$this->maxlineno++;
 	$sql="INSERT INTO $this->tabletransaction (seqno,batch_id,accounts_id,amt,bpartner_id,document_no,document_no2)
		VALUES ($this->maxlineno,$batch_id,$accounts_id,$amt,$bpartner_id,'$docno','$docno2')";

	if($accountsref_id > 0)
	$sqlref="INSERT INTO $this->tabletransaction (seqno,batch_id,accounts_id,amt,bpartner_id,document_no,document_no2)
		VALUES ($this->maxlineno,$batch_id,$accountsref_id,$amt,$bpartnerref_id,'$docno','$docno2')";

	$this->maxlineno++;
	$this->log->showLog(3,"Before insert trans SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert batch line:" . mysql_error() . ":$sql" . "at line" . __LINE__);
		return 0;
	}
	else{
		$this->log->showLog(3,"Inserting new batch line successfully"); 
		$sqllatest="SELECT MAX(trans_id) as trans_id from $this->tabletransaction;";
		$this->log->showLog(4,"Checking latest created trans_id with SQL:$sql");

		$querylatest=$this->xoopsDB->query($sqllatest);
		if($rowlatest=$this->xoopsDB->fetchArray($querylatest)){
			$this->log->showLog(3,'Found latest created trans_id:' . $rowlatest['trans_id']);
			return $rowlatest['trans_id'];
		}
		$this->log->showLog(1,'Cannot find new id with SQL due to:'.mysql_error(). " with SQL: $sql");
		return 0;
	}
  
}
   public function showTransTable($batch_id,$is_complete=0){
	global $ctrl, $defcurrencycode;;
	$sql="SELECT t.trans_id,t.accounts_id,t.document_no,t.document_no2,t.originalamt,t.amt,t.currency_id,
		t.seqno,t.reference_id,t.bpartner_id,acc.account_type
		FROM $this->tabletransaction t
		INNER JOIN $this->tableaccounts acc on t.accounts_id=acc.accounts_id
		where t.batch_id=$batch_id order by t.trans_id,t.seqno,t.reference_id desc";
	$this->log->showLog(3,"Showing showTransTable with SQL:$sql");
	$readonlyctrl="";
	if($is_complete==1)
		$readonlyctrl="readonly='readonly'";

	$query=$this->xoopsDB->query($sql);
	$table="
		<table border='1' cellspacing='1'>
  		<tbody>
    			<tr>
				<th style='text-align:center;'>No</th>
				<th style='text-align:center;'>Account</th>
				<th style='text-align:center;'>Debit($defcurrencycode)</th>
				<th style='text-align:center;'>Credit($defcurrencycode)</th>
				<th style='text-align:center;'>Doc No</th>
				<th style='text-align:center;'>Cheque No</th>
				<th style='text-align:center;'>Del</th>
				<th style='text-align:center;'>Add Line</th>

   	</tr>
";

	
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$transtype=$row['transtype'];
		$trans_id=$row['trans_id'];
		$accounts_id=$row['accounts_id'];
		$bpartner_id=$row['bpartner_id'];
		$seqno=$row["seqno"];
		$amt=$row['amt'];
		$document_no=$row['document_no'];
		$document_no2=$row['document_no2'];
		$reference_id=$row['reference_id'];
		$account_type=$row['account_type'];
			
		if($amt>0){
		$debitamt=$amt;
		$creditamt=0.00;
		}
		elseif($amt<0){
		$debitamt=0.00;
		$creditamt=$amt*-1;
		}
		else{
		$debitamt=0.00;
		$creditamt=0.00;

		}
//		$text="lineaccounts_id[$i]";
		$no=$i+1;
		
		if($reference_id==0){
			//$accountsctrl=$ctrl->getSelectAccounts($accounts_id,'Y',"onchange='calculation()'","lineaccounts_id[$i]",'','Y');
			$accountsctrl=$ctrl->getSelectAccounts($accounts_id,'Y',
				"onchange='refreshAccountsLine(this.value,$i)' 
					onKeyDown='return changearrayfield(event,\"lineaccounts_id\",$nextid,$previousid,\"lineaccounts_id\");'",
				"lineaccounts_id[$i]",'','Y',"N","","lineaccounts_id$i");
			
			$referencectrl="<input type='hidden' name='reference_id[]' value='$trans_id'>";
			$spacectrl="";
			$addlinectrl="<SELECT name='addline[$i]' onchange='addLine()' >
						<option value='0' selected='SELECTED'>0</option>
						<option value='1' > 1 </option>
						<option value='2' > 2 </option>
						<option value='3' > 3 </option>
						<option value='4' > 4 </option>
						<option value='6' > 6 </option>
					</SELECT>";
			
		}	
		else{
			if($is_complete)
				$acc_readonly='Y';
			else
				$acc_readonly='N';

			$addlinectrl="";
			//$accountsctrl=$ctrl->getSelectAccounts($accounts_id,'Y',"onchange='calculation()'","lineaccounts_id[$i]");
			$accountsctrl=$ctrl->getSelectAccounts($accounts_id,'Y',"onchange='refreshAccountsLine(this.value,$i)' 
					onKeyDown='return changearrayfield(event,\"lineaccounts_id\",$nextid,$previousid,\"lineaccounts_id\");'",
					"lineaccounts_id[$i]",'',"$acc_readonly","N","","lineaccounts_id$i");
			//$bpartnerctrl=$ctrl->getSelectBPartner($bpartner_id,'N',"","linebpartner_id[$i]");
			$referencectrl="";//"<input type='hidden' name='reference_id' value='$reference_id'>";
			$spacectrl="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";	
		}
		if($account_type==2)
		$bpartnerctrl=$ctrl->getSelectBPartner($bpartner_id,'Y',"","linebpartner_id[$i]", " and (debtoraccounts_id = $accounts_id and isdebtor=1) ","Y");
		elseif($account_type==3)
		$bpartnerctrl=$ctrl->getSelectBPartner($bpartner_id,'Y',"","linebpartner_id[$i]", " and (creditoraccounts_id=$accounts_id and iscreditor=1) ","Y");
		else			
		$bpartnerctrl="<input type='1hidden' value='0' name='linebpartner_id[$i]'>";

		if($reference_id==0){
		$table=$table."<tr><td>&nbsp;</td></tr>";
		$stylefldamt = "style='background-color:#e7ffaf'";
		}else
		$stylefldamt = "";

		$styletdamt = "style='text-align:left'";
		
		$styledelete = "";
		if($is_complete == 1){
		$styledelete = "style = 'display:none' ";
		$addlinectrl = "";
		}

		$checkListAccounts = $this->checkListAccountsTrans($accounts_id);
	
		if($checkListAccounts > 0)
		$styledisplay = "";
		else
		$styledisplay = "style='display:none'";
		
		$nextid=$i+1;
		if($i>0)
		$previousid=$i-1;
		else
		$previousid=0;

		$table=$table."
			
		<tr id='tr$i' >
		  <td border=1 style='text-align:left;'>$no<input type='hidden' name='linetrans_id[$i]' id='trans_id_$i'
						value='$trans_id'><input type='hidden' name='lineseqno[$i]' value='$seqno'></td>
		<td border=1 style='text-align:left;' nowrap>
		<table>
		<tr>
		<td nowrap width='1'>$spacectrl$accountsctrl </td>
		<td nowrap width='1' id='ctrlBP$i' $styledisplay>$bpartnerctrl</td>
		</td> $referencectrl</td>
		</tr>
		</table>
		</td>
		  <td border=1  $styletdamt nowrap>$spacectrl
		    <input $stylefldamt size='8' name='linedebitamt[$i]' id=debitamt$i 
						value='$debitamt' 
			onchange='creditamt$i.value=0.00; calculation()'
			onKeyDown='return changearrayfield(event,\"debitamt\",$nextid,$previousid,\"debitamt\");'
			onfocus='this.select();'
			$readonlyctrl>
		  </td>
		  <td border=1 $styletdamt nowrap>$spacectrl
		    <input $stylefldamt size='8' name='linecreditamt[$i]' id=creditamt$i
						value='$creditamt' onchange='debitamt$i.value=0.00; calculation()'
			onKeyDown='return changearrayfield(event,\"creditamt\",$nextid,$previousid,\"creditamt\");'
			onfocus='this.select();' $readonlyctrl>
		  </td>
		  <td border=1 $styletdamt nowrap>$spacectrl
		  	<input $stylefldamt size='10' name='linedocument_no[$i]' id=document_no_$i
						value='$document_no'
 			onKeyDown='return changearrayfield(event,\"document_no_\",$nextid,$previousid,\"document_no_\");'
			onfocus='this.select();' 
$readonlyctrl>
		  </td>
		  <td border=1 $styletdamt nowrap>$spacectrl
					<input $stylefldamt size='10' name='linedocument_no2[$i]' id=document_no2_$i
						value='$document_no2' 
 			onKeyDown='return changearrayfield(event,\"document_no2_\",$nextid,$previousid,\"document_no2_\");'
			onfocus='this.select();' $readonlyctrl>
		  </td>
		  <td border=1 style='text-align:right;' nowrap >
					<input type='checkbox' name='linedel[$i]' id=del_$i onclick='deleteLine(this.checked)' 
 			onKeyDown='return changearrayfield(event,\"del_\",$nextid,$previousid,\"del_\");'
			onfocus='this.select();' $styledelete>
		  </td>
		  <td border=1 style='text-align:center;' nowrap>
					<A title='Add Line'>$addlinectrl</A>
		  </td>
		</tr>";
	$i++;
	}

	$table=$table."<tr><td>&nbsp;</td></tr>";

	$defaultaccountsctrl=$ctrl->getSelectAccounts(0,'Y',"onchange='addCounter(this.value);'","newtrans_accounts_id");
	//$defaultaccountsctrl=$ctrl->getSelectAccounts(0,'Y',"onchange='refreshBPartner(this.value)'","newtrans_accounts_id");

//	$this->maxlineno=$i;
	$addlinectrl="<SELECT name='addnewcounterline' onchange='addCounter(document.frmBatch.newtrans_accounts_id.value);'>
						<option value='1' selected='SELECTED'>1</option>
						<option value='2' >2</option>
						<option value='3' >3</option>
						<option value='4' >4</option>
						<option value='6' >6</option>
					</SELECT>";
	$table=$table. "<tr $styledelete>
		  <td border=1 style='text-align:center;' class='foot'>Add Trans</td>
		  <td border=1 style='text-align:center;' class='foot'>$defaultaccountsctrl</td>
		  <td border=1 style='text-align:center;' class='foot'>
		    <input style='text-align:right' size='12' name='defaultdebit' id='defaultdebit' 
						value='$this->defaultdebit' onchange='defaultcredit.value=0.00;' $readonlyctrl>
		  </td>
		  <td border=1 style='text-align:center;' class='foot'>  
			<input style='text-align:right' size='12' name='defaultcredit' id='defaultcredit' 
						value='$this->defaultcredit' onchange='defaultdebit.value=0.00;' $readonlyctrl>
		  </td>
		  <td border=1 style='text-align:center;' class='foot'>
		  	<input size='14' name='document_no' id=document_no
						value='$document_no' $readonlyctrl>
		  </td>
		  <td border=1 style='text-align:center;' class='foot'>
					<input size='14' name='document_no2' id=document_no2
						value='$document_no2' $readonlyctrl>
		  </td>
		  <td border=1 style='text-align:center;' class='foot'>
		  </td>
	  <td border=1 style='text-align:center;' class='foot'>
					<A title='Add Transaction'>$addlinectrl</A>
		  </td>
		  
		</tr>".
		"<input type='hidden' name='maxlineno' value='$seqno'></tr></tbody></table>";
	return $table;
  }

  public function updateLine($batch_id){
//trans_id,accounts_id,document_no,document_no2,originalamt,amt,currency_id
//		FROM $this->tabletransaction where batch_id=$batch_id order by seqno
	$i=0;
	$this->maxlineno=1;
	$this->log->showLog(4,"Updateting transaction lines.$this->newtrans_accounts_id?$this->addnewcounterline?");
	//$lasttrans_id=0;
	//$lastaddqty=0;
	foreach ($this->linetrans_id as $id){
		$amt = 0;
		$debitamt=$this->linedebitamt[$i];
		$creditamt=$this->linecreditamt[$i];
		$document_no=$this->linedocument_no[$i];
		$document_no2=$this->linedocument_no2[$i];
		$accounts_id=$this->lineaccounts_id[$i];
		$bpartner_id=$this->linebpartner_id[$i];
		$isdel=$this->linedel[$i];	
		$addlineqty=$this->addline[$i];
		//$transtype=$this->linetranstype[$i];
		if($debitamt>0)
			$amt=$debitamt;
		elseif($creditamt>0)
			$amt=$creditamt*-1;

		if($bpartner_id == "")
		$bpartner_id = 0;
	

		//$o->batch_id,$o->addline,$reference_id
		if($isdel!='on')
		$sql="UPDATE $this->tabletransaction SET accounts_id=$accounts_id,bpartner_id=$bpartner_id,document_no='$document_no',
			document_no2='$document_no2',amt=$amt,seqno=$this->maxlineno WHERE trans_id=$id";
		else
		$sql="DELETE FROM $this->tabletransaction WHERE trans_id=$id";


		$this->log->showLog(4,"Update Line With SQL:$sql.");
		$rs=$this->xoopsDB->query($sql);
	
		if (!$rs)
			$this->log->showLog(1,"Failed to update record document_no:'$document_no' " . mysql_error() . ":$sql");
			//return false;
		else
			$amt=0;

		$this->maxlineno++;
		
		if($addlineqty>0){
			$this->log->showLog(3,"Adding $addlineqty lines under trans_id: $id.");
			$this->insertBlankLine($batch_id,$addlineqty,$id,$bpartner_id);
				

		}
		$i++;

	
	}
		
	if($this->newtrans_accounts_id>0){
		if($i == 0)
		$bpartner_id = $this->getTopBPartner();

		$this->log->showLog(3,"new trans accounts_id:$this->newtrans_accounts_id,
				amt:$defaultamt,batch_id:$batch_id,linecount:$this->addnewcounterline, seqno:$this->maxlineno++");
		
			$defaultamt=0;	
			if($this->defaultdebit>0)
				$defaultamt=$this->defaultdebit;
			elseif($this->defaultcredit>0)
				$defaultamt=$this->defaultcredit*-1;

			$reference_id=$this->insertDefaultLine($batch_id,$this->newtrans_accounts_id,$defaultamt,$bpartner_id);
			$this->insertBlankLine($batch_id,$this->addnewcounterline,$reference_id,$bpartner_id);
			

		
		}

	return true;
  }


  public function compileSummary($batch_id){
	$i=0;
	//$this->log->showLog(4,"Compile Summary for batch_id: $batch_id");
	$sql="SELECT t.accounts_id,sum(t.amt) as amt,a.parentaccounts_id
		FROM $this->tabletransaction t
		inner join $this->tableaccounts a on t.accounts_id=a.accounts_id where t.batch_id=$batch_id 
		group by t.accounts_id,a.parentaccounts_id order by t.accounts_id";
	$this->log->showLog(3,"Compile Summary for batch_id: $batch_id with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$accounts_id=$row['accounts_id'];
		$amt=$row['amt'];
		$parentaccounts_id=$row['parentaccounts_id'];
		$sqlupdateaccount="Update $this->tableaccounts SET 
					lastbalance=lastbalance+($amt) where accounts_id=$accounts_id";
		$rs=$this->xoopsDB->query($sqlupdateaccount);
		if(!$rs)
		  $this->log->showLog(1,"Can't update table account with".mysql_error().": $sqlupdateaccount");
		//start looping back to top parentaccounts_id=0
		while($parentaccounts_id>0){
			//update parent accountamt
			$sqlparent="SELECT accounts_id,parentaccounts_id
				FROM $this->tableaccounts where accounts_id=$parentaccounts_id";
			$queryparent=$this->xoopsDB->query($sqlparent);
			if($rowparents=$this->xoopsDB->fetchArray($queryparent)){
				$newaccounts_id=$rowparents['accounts_id'];
				$parentaccounts_id=$rowparents['parentaccounts_id'];
				$sqlupdateparrentaccount="Update $this->tableaccounts SET 
							lastbalance=lastbalance+($amt) 
							where accounts_id=$newaccounts_id";
						$rsparent=$this->xoopsDB->query($sqlupdateparrentaccount);
						if(!$rsparent)
						$this->log->showLog(1,"Can't update table parentaccount with".mysql_error().
							": $sqlupdateparrentaccount");
			}
		}
	
	}
	}

  public function reverseSummary($batch_id){
	$i=0;
	//$this->log->showLog(4,"Compile Summary for batch_id: $batch_id");
	$sql="SELECT t.accounts_id,sum(t.amt) as amt,a.parentaccounts_id
		FROM $this->tabletransaction t
		inner join $this->tableaccounts a on t.accounts_id=a.accounts_id where t.batch_id=$batch_id 
		group by t.accounts_id,a.parentaccounts_id order by t.accounts_id";
	$this->log->showLog(3,"Compile Summary for batch_id: $batch_id with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$accounts_id=$row['accounts_id'];
		$amt=$row['amt'];
		$parentaccounts_id=$row['parentaccounts_id'];
		$sqlupdateaccount="Update $this->tableaccounts SET 
					lastbalance=lastbalance-($amt) where accounts_id=$accounts_id";
		$rs=$this->xoopsDB->query($sqlupdateaccount);
		if(!$rs)
		  $this->log->showLog(1,"Can't update table account with".mysql_error().": $sqlupdateaccount");
		//start looping back to top parentaccounts_id=0
		while($parentaccounts_id>0){
			//update parent accountamt
			$sqlparent="SELECT accounts_id,parentaccounts_id
				FROM $this->tableaccounts where accounts_id=$parentaccounts_id";
			$queryparent=$this->xoopsDB->query($sqlparent);
			if($rowparents=$this->xoopsDB->fetchArray($queryparent)){
				$newaccounts_id=$rowparents['accounts_id'];
				$parentaccounts_id=$rowparents['parentaccounts_id'];
				$sqlupdateparrentaccount="Update $this->tableaccounts SET 
									lastbalance=lastbalance-($amt) where accounts_id=$newaccounts_id";
						$rsparent=$this->xoopsDB->query($sqlupdateparrentaccount);
						if(!$rsparent)
						$this->log->showLog(1,"Can't update table parentaccount with".mysql_error().
							": $sqlupdateparrentaccount");
			}
		}
	}
  }

  public function removeUnusedLine($batch_id){
	$this->log->showLog(2,"Performing delete unused transaction in batch id : $batch_id !");
	$sql="DELETE FROM $this->tabletransaction where batch_id=$batch_id and (accounts_id=0 OR amt=0) ";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: trans line ($batch_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"unused transaction for batch_id $batch_id removed from database successfully!");
		return true;
		
	}
  }

  public function getTopBPartner(){
	global $defaultorganization_id;
	$retval = 0;
 	$sql = "select * from $this->tablebpartner 
			and $defaultorganization_id = $defaultorganization_id 
			order by bpartner_id limit 1";

	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['bpartner_id'];
	}

	return $retval;
	
  }

 public function compileSummaryUpdate($batch_id,$openingbalance){
	$i=0;
	//$this->log->showLog(4,"Compile Summary for batch_id: $batch_id");
	$sql="SELECT t.accounts_id,sum(t.amt) as amt,a.parentaccounts_id
		FROM $this->tabletransaction t
		inner join $this->tableaccounts a on t.accounts_id=a.accounts_id where t.batch_id=$batch_id 
		group by t.accounts_id,a.parentaccounts_id order by t.accounts_id";
	$this->log->showLog(3,"Compile Summary for batch_id: $batch_id with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$accounts_id=$row['accounts_id'];
		$amt=$row['amt'];
		$parentaccounts_id=$row['parentaccounts_id'];
		$sqlupdateaccount="Update $this->tableaccounts SET 
					lastbalance=lastbalance+($amt)-($openingbalance) where accounts_id=$accounts_id";
		$rs=$this->xoopsDB->query($sqlupdateaccount);
		if(!$rs)
		  $this->log->showLog(1,"Can't update table account with".mysql_error().": $sqlupdateaccount");
		//start looping back to top parentaccounts_id=0
		while($parentaccounts_id>0){
			//update parent accountamt
			$sqlparent="SELECT accounts_id,parentaccounts_id
				FROM $this->tableaccounts where accounts_id=$parentaccounts_id";
			$queryparent=$this->xoopsDB->query($sqlparent);
			if($rowparents=$this->xoopsDB->fetchArray($queryparent)){
				$newaccounts_id=$rowparents['accounts_id'];
				$parentaccounts_id=$rowparents['parentaccounts_id'];
				$sqlupdateparrentaccount="Update $this->tableaccounts SET 
							lastbalance=lastbalance+($amt)-($openingbalance) 
							where accounts_id=$newaccounts_id";
						$rsparent=$this->xoopsDB->query($sqlupdateparrentaccount);
						if(!$rsparent)
						$this->log->showLog(1,"Can't update table parentaccount with".mysql_error().
							": $sqlupdateparrentaccount");
			}
		}
	
	}
	}

  public function insertTransactionSummary($batch_id,$organization_id,$iscomplete){
	
	$sql = "select * from $this->tablebatch a
		INNER JOIN $this->tabletransaction b on a.batch_id = b.batch_id 
		where a.batch_id = $batch_id ";
	
	$this->log->showLog(3,"Transaction Summary for batch_id: $batch_id with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
	$debitamt = 0;
	$creditamt = 0;
	$accounts_id = $row['accounts_id'];
	$period_id = $row['period_id'];
	$amt = $row['amt'];
	$bpartner_id=$row['bpartner_id'];

//	if($amt < 0)
//	$creditamt = $amt*-1;
//	else if($amt > 0)
//	$debitamt = $amt;

	$checkExist=$this->checkExistSummary($period_id,$accounts_id,$organization_id,$bpartner_id);

	if($checkExist == false){
	
	if($iscomplete == 0)
	$amt=$amt*-1;

	$sqlinsert = "update $this->tabletranssummary set 
			lastbalance= lastbalance + $amt, 
			transactionamt = transactionamt + $amt 
			where period_id = $period_id and accounts_id = $accounts_id and bpartner_id=$bpartner_id";


	}else{

	$lastbalance=0;	
	$sqltranslastbalance="
		SELECT ts.lastbalance FROM $this->tabletranssummary ts
			INNER JOIN $this->tableperiod pr on ts.period_id=pr.period_id
			 where ts.accounts_id=$accounts_id 
			AND  ts.bpartner_id=$bpartner_id  and 
			 concat(pr.period_year,'-',case when length(pr.period_month)=1 then concat('0',pr.period_month) else pr.period_month end)
			 < (SELECT  concat(period_year,'-',case when length(period_month)=1 then concat('0',period_month) else 
				period_month end) as period FROM $this->tableperiod where period_id=$period_id )
			order by transum_id DESC";
		


	$qrytranslastbalance=$this->xoopsDB->query($sqltranslastbalance);
	if($row=$this->xoopsDB->fetchArray($qrytranslastbalance))
		$lastbalance=$row['lastbalance'];
	else{
		$sqltranslastbalance2="SELECT (case when account_type =2 or account_type=3 then 0 else 
				  	(SELECT a.openingbalance FROM $this->tableaccounts a where a.accounts_id=$accounts_id) end )
					 as openingbalance FROM $this->tableaccounts
					WHERE accounts_id=$accounts_id"; 
			//get latest lastbalance for selected record, if never exist then will use opening balance
		$qrytranslastbalance2=$this->xoopsDB->query($sqltranslastbalance2);
		if($row=$this->xoopsDB->fetchArray($qrytranslastbalance2))
			$lastbalance=$row['openingbalance'];
		else
			$lastbalance=0;
	}
	$this->log->showLog(4,"Get Last Balance amt [$lastbalance] with SQL: $sqltranslastbalance");
	$sqlinsert = 	"insert into $this->tabletranssummary 
			(period_id,accounts_id,lastbalance,transactionamt,organization_id,bpartner_id) 
			values 
			($period_id,$accounts_id,$amt+$lastbalance,$amt,$organization_id,$bpartner_id)";
	}

	
	
	$this->log->showLog(3,"Insert line with SQL:$sqlinsert");
	$rs=$this->xoopsDB->query($sqlinsert);
	if (!$rs){
		$this->log->showLog(1,"Error: insert line transaction summary " . mysql_error(). ":$sql");
		return false;
	}
	if($bpartner_id!=0)
	$this->updateBPartnerBalance($bpartner_id,$amt);

	/*
	 * Update following month transsummary lastbalance amt
	 */

	$sqlupdatefollowingmonth = "update $this->tabletranssummary ts 
			INNER JOIN $this->tableperiod pr on ts.period_id=pr.period_id
			set ts.lastbalance= ts.lastbalance + $amt
			where  ts.accounts_id = $accounts_id and ts.bpartner_id=$bpartner_id and
			 concat(pr.period_year,'-',case when length(pr.period_month)=1 then concat('0',pr.period_month) else pr.period_month end)
			 > (SELECT  concat(period_year,'-',case when length(period_month)=1 then concat('0',period_month) else period_month end) as period FROM $this->tableperiod where period_id=$period_id)";
	$rsupdatefollowingmonth=$this->xoopsDB->query($sqlupdatefollowingmonth);
	if (!$rsupdatefollowingmonth){
		$this->log->showLog(1,__LINE__. "Failed to update following month transaction summary balance with SQL: $sqlupdatefollowingmonth." . mysql_error());
	}
	else
		$this->log->showLog(4,"Successfully update following month transaction summary balance with SQL: $sqlupdatefollowingmonth");

	}



  }


  public function checkExistSummary($period_id,$accounts_id,$organization_id,$bpartner_id){
	$retval = true;
	$sql = "select * from $this->tabletranssummary 
		where period_id = $period_id and accounts_id = $accounts_id 
		and organization_id = $organization_id and bpartner_id=$bpartner_id";


	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
	$this->log->showLog(3,"Found Existing Summary for accounts_id: $accounts_id with SQL:$sql");
	$retval = false;
	}
	$this->log->showLog(3,"Unfound Existing Summary for accounts_id: $accounts_id with SQL:$sql");
	return $retval;
  }

  

	public function checkListAccountsTrans($accounts_id){
	$retval = 0;

	$sql = "select count(*) as cnt from $this->tableaccounts a, $this->tablebpartner b 
		where (a.accounts_id = b.debtoraccounts_id OR a.accounts_id = b.creditoraccounts_id)
		and a.accounts_id > 0 
		and a.accounts_id = $accounts_id ";

	$this->log->showLog(4,"Checking list accounts with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['cnt'];
	}
	
	return $retval;
	}
  

     public function changeTransSummaryAmtTo($period_id,$accounts_id,$organization_id,$bpartner_id,$transamt,$balanceamt){
	$sql="UPDATE $this->tabletranssummary set transactionamt=$transamt,lastbalance=$balanceamt where period_id=$period_id and
		accounts_id=$accounts_id and bpartner_id=$bpartner_id and organization_id=$organization_id";
	$rs=$this->xoopsDB->query($sql);
	
	if($rs){
	$this->log->showLog(3,"changeTransSummaryAmtTo run successfully with Sql:$sql");

	return true;

	}
	else{
	$this->log->showLog(1,"changeTransSummaryAmtTo run FAILED with Sql:$sql");
	return false;
	
	}
	}

	public function updateBPartnerBalance($bpartner_id,$amt){
	$retval = 0;

	$sql = "UPDATE $this->tablebpartner b set currentbalance=currentbalance+$amt
		where bpartner_id=$bpartner_id";


	$rs=$this->xoopsDB->query($sql);
	
	if($rs){
	$this->log->showLog(3,__LINE__."updateBPartnerBalance successfully with SQL:$sql");	
	return true;
	}
	$this->log->showLog(1,__LINE__."updateBPartnerBalance failed with SQL:$sql");	
	return false;
	}


   public function updateBankReconcilationInfo($bankreconcilatioin_id){
	$i=0;
	foreach($this->linetrans_id as $trans_id){
		if($this->linechecked[$i]=='on'){
			$sql="UPDATE $this->tabletransaction set bankreconcilation_id=$bankreconcilatioin_id where trans_id=$trans_id";
			$rs=$this->xoopsDB->query($sql);
			if($rs)
			$this->log->showLog(4,"Update trans_id: $trans_id to use bankrecon_id: $bankreconcilatioin_id successfully with SQL: $sql.");
			else
			$this->log->showLog(1,"Update trans_id: $trans_id to use bankrecon_id: $bankreconcilatioin_id failed with SQL: $sql.");

		}
		else{
					$sql="UPDATE $this->tabletransaction set bankreconcilation_id=0 where trans_id=$trans_id";
			$rs=$this->xoopsDB->query($sql);
			if($rs)
			$this->log->showLog(4,"remove bankconcilation id from trans_id: $trans_id successfully with SQL: $sql.");
			else
			$this->log->showLog(1,"remove bankconcilation id from trans_id: $trans_id failed with SQL: $sql.");

		}

	$i++;
	}

	}
}
?>
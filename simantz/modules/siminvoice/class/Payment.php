<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


class Payment
{

public	$payment_id;
public	$payment_no;
public	$customer_id;
public	$payment_type;
public	$payment_date;
public	$payment_amount;
public	$payment_chequeno;
public	$payment_desc;
//public	$payment_person;
public	$payment_receivedby;
public	$created;
public	$createdby;
public	$updated;
public	$updatedby;
public  $preparedby;

// payment line

public	$paymentline_id;
public	$invoice_id;
public	$paymentline_amount;
public	$paymentline_desc;
public	$paymentlinedelete_id;
public	$datectrl;
public	$invoice_select;


//

public 	$isAdmin;
public	$paymentctrl;
public	$customerctrl;
public  $rowctrl;
public	$itemctrl;
public  $invoicectrl;

public  $xoopsDB;
public  $tableprefix;
public  $tablepayment;
public  $tablepaymentline;
public  $tablecategory;
public  $tableitem;
public  $tablecustomer;
public  $tableinvoice;
public  $tablequotation;
public  $tableinvoiceline;

public  $log;



//constructor
   public function Payment($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablepayment=$tableprefix."tblpayment";
	$this->tablequotation=$tableprefix."tblquotation";
	$this->tablepaymentline=$tableprefix."tblpaymentline";
	$this->tablecategory=$tableprefix."tblcategory";
	$this->tableitem=$tableprefix."tblitem";
	$this->tablecustomer=$tableprefix."tblcustomer";
	$this->tableinvoice=$tableprefix."tblinvoice";
	$this->tableinvoiceline=$tableprefix."tblinvoiceline";
	$this->log=$log;
   }
   
   
   
   
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int payment_id 
   * @return 
   * @access public
   */
   
   
   
  public function getInputForm( $type,  $payment_id, $token ,$customer_id) {

   $header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$completectrl="";
	$deletectrl="";
	$itemselect="";
	$itemline="";
	$norecord="";
	$rowtype="";
	$totalcolumn = "";
	
	// declare payment_amount = 0
	
	if($this->payment_amount=="")
	$this->payment_amount = 0;

		
	$this->created=0;
	
	if ($type=="new"){
		$header="New Payment";
		$action="create";
	 	
		if($payment_no==0){
			$this->payment_no=$this->getNewPayment();
			$this->iscomplete=0;
			

		}
		
		$norecord .= "<tr><td colspan='5'>Please Create Invoice.</td></tr>";
		$savectrl="<input style='height: 40px;' name='btnSave' value='Next' type='button' onclick='return saveAllRecord();' >";
//		$checked="CHECKED";
		$checked="";
		$defaultchecked="";
		$deletectrl="";


	}
	else
	{
	
		$header="Edit Payment";
		
		if($type=="row"&& $this->payment_id==""){//if create row
		$action="create";
		$header="New Payment";
		}else
		$action="update";
		
		$savectrl=	"<input name='payment_id' value='$this->payment_id' type='hidden'>".
			 			"<input style='height: 40px;' name='btnSave' value='Save' type='button' onclick='return saveAllRecord();'>";
		
		if($action!="create"){
		//$action="create";
		$completectrl=	"<input name='completectrl' value='1' type='hidden'>".
							"<input name='payment_id' value='$this->payment_id' type='hidden'>".
			 				"<input style='height: 40px;' name='btnComplete' value='Complete' type='button' onclick ='completeRecord();' >";
		}

		if($this->isAdmin)
		$recordctrl="";
		
	
		
		
		if($this->allowDelete($this->payment_id))
		$deletectrl="<FORM action='payment.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this payment?"'.")'><input style='height: 40px;' type='submit' value='Delete Payment' name='btnDelete'>".
		"<input type='hidden' value='$this->payment_id' name='payment_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
	
		
		// show row payment line
		
		}
			
			
	
		$selectfld = "";
		$selectfld2 = "";
		if($this->payment_type=="2")
			$selectfld2 = "SELECTED";
		else
			$selectfld = "SELECTED";
	
		if($this->payment_date=="")
		$this->payment_date = date("Y-m-d", time()) ;
		
		$zoomctrl = "<image style = 'cursor:pointer' src='images/zoom.png' title='View This Customer'	onclick = 'if(document.frmPayment.customer_id.value!=0){document.frmZoom.customer_id.value = document.frmPayment.customer_id.value ;document.frmZoom.submit();}' >";
	
    echo <<< EOF


<table style="width:140px;"><tbody><td><form aonsubmit="return validatePayment('Confirm change this data?',1)" method="post"
 action="payment.php" name="frmPayment"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      
      
      <tr>
        	<td class="head">Customer *</td>
        	<td class="odd">$this->customerctrl&nbsp;$zoomctrl</td>
        	<td class="head">Payment No *</td>
        	<td class="odd" ><input name='payment_no' value="$this->payment_no" maxlength='10' size='15'> </td>
     </tr>
     
      <tr>
      	<td class="head">Payment Type</td>
      	<td  class="odd">
			<select name='payment_type'>
			<option value='1' $selectfld>Cash</option>
			<option value='2' $selectfld2>Cheque</option>
			</select>
			</td>
        	<td class="head">Payment Date *</td>
        	<td class="odd" >
        	<input name='payment_date' id='payment_date' value="$this->payment_date" maxlength='10' size='10'>
        	<input name='btnDate' value="Date" type="button" onclick="$this->datectrl"> 
        	</td>
 		</tr>
      
      <tr>
			<td class="head">Amount (RM)</td>
			<td  class="odd"><input name='payment_amount' value="$this->payment_amount" maxlength='15' size='13' onblur="parseelement(this);"  onfocus='this.select();' onclick='this.select();' autocomplete='off'></td>
			<td class="head">Cheque No.</td>
			<td  class="odd"><input name='payment_chequeno' value="$this->payment_chequeno" maxlength='30' size='30'></td>
      </tr>
      
		<tr>
			<td class="head">Received By</td>
			<td  class="odd"><input name='payment_receivedby' value="$this->payment_receivedby" maxlength='30' size='30'></td>
			<td class="head"></td>
			<td  class="odd"></td>
      </tr>
	
		<tr>
			<td class="head">Description</td>
			<td  class="odd" colspan='3' ><textarea  name="payment_desc" cols='70' maxlength='200' rows='4'>$this->payment_desc</textarea></td>
		</tr>
	
	

    </tbody>
  </table>
EOF;

	if($type=="edit")
		$this->getChildInput("edit",  $payment_id, $token ,$this->customer_id);
	
echo <<< EOF
  <p>
	<table style="width:150px;"><tbody><td>$savectrl&nbsp; 
	<input name="action" value="$action" type="hidden">
	<input name="paymentlinedelete_id" value="$this->paymentlinedelete_id" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td></tbody></table>
  <br>

			
$recordctrl

EOF;


echo  "<form name='frmZoom' action='customer.php' method='POST' target='_BLANK'>
		<input type='hidden' name='action' value='edit'>
		<input type='hidden' name='customer_id' value=''>
		</form>";
		

echo  "<form name='frmZoomInvoice' action='viewinvoice.php' method='POST' target='_BLANK'>
		<input type='hidden' name='action' value='edit'>
		<input type='hidden' name='invoice_id' value=''>
		</form>";

	if($type=="edit")
		$this->getChildInput("row",  $payment_id, $token ,$this->customer_id);
		
echo "<iframe src='validate_payment.php?xf_action=$action' id='idValidate' style='display:none' >aa</iframe>";

  } // end of member function getInputForm
  
  
	
  public function deletePaymentLine( ) {

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	
 	$sql="delete from $this->tablepaymentline WHERE payment_id=$this->payment_id and paymentline_id = $this->paymentlinedelete_id ";
	
	$this->log->showLog(3, "Enable payment_id: $this->payment_id, $this->payment_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Delete payment failed");
		return false;
	}
	else{
		$this->updatePayment();
		$this->log->showLog(3, "Delete payment successfully.");
		return true;
	}
	
  } // end of member function deletePaymentLine
  
  
 
  public function getChildInput($type,  $payment_id, $token ,$customer_id){
  
  		if($type=="row"){
  	
  		$wherestr = " WHERE i.customer_id = $customer_id and i.iscomplete = 1 ";
			
			
		$sql = "SELECT
					'' as paymentline_id,
					'' as payment_id,  
					'' as paymentline_amount,
					'' as paymentline_desc,
					i.invoice_id as invoice_id,
					i.invoice_no as invoice_no,
					i.invoice_date as invoice_date,
					i.customer_id as customer_id,
					i.iscomplete as iscomplete,
					i.invoice_totalamount as invoice_totalamount,
					(i.invoice_totalamount - coalesce((select sum(paymentline_amount) as payment_amount from $this->tablepaymentline where  invoice_id = i.invoice_id ),NULL,0) ) as invoice_balance	
					from $this->tableinvoice i    
					$wherestr 
					GROUP BY i.invoice_id 
					order by invoice_date desc ";
		
		$childheader = "List Of Invoice";
		$style_display = "style = 'text-align:center;display:none';";
		
		$addInvoice = "<tr>
   						<td colspan='6'><input name = 'btnAddPayment' style='height: 40px;' type='button' onclick='return addPayment();' value='Add Payment' ></td>
   						</tr>";
   	$addForms1 = "<form method='post' action='payment.php' name='frmAddPayment'>
   					  <input type='hidden' name='payment_id' value='$payment_id'>
   					  <input type='hidden' name='token' value='$token'>
						  <input type='hidden' name='action' value='add_payment'>";
		$addForms2 = "</form>";
   	 
  		}else{
  	
	  	$wherestr = " WHERE p.payment_id = $this->payment_id AND i.invoice_id = p.invoice_id and i.iscomplete = 1 ";
			
		$sql = "SELECT
					p.paymentline_id as paymentline_id,
					p.payment_id as payment_id,  
					p.paymentline_amount as paymentline_amount,
					p.paymentline_desc as paymentline_desc,
					i.invoice_id as invoice_id,
					i.invoice_no as invoice_no,
					i.invoice_date as invoice_date,
					i.customer_id as customer_id,
					i.iscomplete as iscomplete,
					i.invoice_totalamount as invoice_totalamount,
					(i.invoice_totalamount - coalesce((select sum(paymentline_amount) as payment_amount from $this->tablepaymentline where  invoice_id = i.invoice_id ),NULL,0) ) as invoice_balance	
					from $this->tableinvoice i, $this->tablepaymentline p   
					$wherestr 
					GROUP BY p.paymentline_id 
					order by p.paymentline_id desc ";
		
		$childheader = "List Of Payment";
		$style_display = "style = 'text-align:center;' ";
		$addInvoice = "";		
		$addForms1 = "";
		$addForms2 = "";
		}
  
  	
				 				
			
				$query=$this->xoopsDB->query($sql);
				
				$i = 0;
				$j = 0;
				$line_i = 0;
				$tot_amount = 0;
	
				while($row=$this->xoopsDB->fetchArray($query)){
				$i++;
				
				if($rowtype=="odd")
					$rowtype="even";
				else
					$rowtype="odd";
				
				$paymentline_id = $row['paymentline_id'];
				$paymentline_amount = $row['paymentline_amount'];
				$paymentline_desc = $row['paymentline_desc'];
				$invoice_id = $row['invoice_id'];
				$invoice_no = $row['invoice_no'];
				$invoice_date = $row['invoice_date'];
				$invoice_totalamount = $row['invoice_totalamount'];
				$invoice_balance = $row['invoice_balance'];
				
				
				
				$zoomctrl = "<image style = 'cursor:pointer' src='images/zoom.png' title='View This Invoice'	onclick = 'document.frmZoomInvoice.invoice_id.value = $invoice_id ;document.frmZoomInvoice.submit();}' >";
				
				if($paymentline_amount=="")
				$paymentline_amount = 0;
 				
 				if($type=="row"){
 					$tot_amount += $invoice_balance;
					$linectrl = "<input type='checkbox' name='invoice_select[$i]'>";
				}else{
					$tot_amount += $paymentline_amount;
					$linectrl = "<input type='button' value='Delete' onclick='return deletePaymentLine($paymentline_id,$this->payment_id);'>";
				}			
 				
				if($invoice_balance > 0 || $type=="edit")   			
   			
   			$invoiceline .= "<tr>
   						<input type='hidden' name='paymentline_id[]' value=$paymentline_id>
   						<input type='hidden' name='invoice_id[]' value='$invoice_id'>
   						
							<td class=$rowtype>$i</td>
							
							<td class=$rowtype align=center>
							$invoice_no&nbsp;$zoomctrl
							</td>
							
							<td class=$rowtype align=center>
							$invoice_date
							</td>
							
							<td class=$rowtype align=center>
							$invoice_totalamount
							</td>
							
							<td class=$rowtype align=center>
							$invoice_balance
							</td>
							
							<td class=$rowtype align=center $style_display>
							<input onblur='return calculateAmount(this);' style='text-align:right' type='input' name='paymentline_amount[]' value='$paymentline_amount' max=10 size=10 onfocus='this.select();' onclick='this.select();' autocomplete='off'>
							</td>
							
							<td class=$rowtype align=center $style_display>
							<textarea  name='paymentline_desc[]' cols='50' maxlength='200' rows='3'>$paymentline_desc</textarea>
							</td>
							
							<td class=$rowtype align=center>
							$linectrl							
							</td>
							
   						</tr>";
			
				$j++;
				}
				
				
				
		if($i==0){
			if($type=="row")
			$norecord .= "<tr><td colspan='5'>No Invoice List</td></tr>";
			else
			$norecord .= "<tr><td colspan='5'>No Payment List</td></tr>";
		}
		
		$tot_amount = number_format($tot_amount, 2, '.','');
		
		if($i>0&&$type=="edit"){
		$totalcolumn .= "<tr astyle='display:none'>
								<td class='head' colspan='4'></td>
								<td class='head' style='font-weight : bold;' align=center>Total Paid (RM)</td>
								<td class='head' align=center><input readonly style = 'background-color : silver;color:black;text-align:right;' type='input' name='invoce_total' max=10 size=10 value='$tot_amount'></td>
								<td class='head' colspan='2'></td>
								
								</tr>";
		}else{
		$totalcolumn .= "<tr >
								<td class='head' colspan='3'></td>
								<td class='head' style='font-weight : bold;' align=center>Total Balance (RM)</td>
								<td class='head' align=center>$tot_amount</td>
								<td class='head' colspan='2'></td>
								
								</tr>";
		}	
		
echo <<< EOF
	
		<table align=center border=1>
  		<tr height=30 valign=bottom>
  	  		<td class="odd">
  	  		<b>
  	  		$childheader
  	  		</b>
  	  		<input style=' display:none'style='height: 35px;' type="button" name="btnCreate" value="List Invoice" onclick = " return listInvoice();">
  	  		</td>
  		</tr>
  		</table>
  
  		<table border='1' width="100%">
  		<tbody>
    	<tr astyle="display:none">
				<th style="text-align:center;" awidth="5%">No</th>
				<th style="text-align:center;" awidth="10%">Invoice No</th>
				<th style="text-align:center;" awidth="10%">Invoice Date</th>
				<th style="text-align:center;" awidth="12%">Invoice Amount (RM)</th>
				<th style="text-align:center;" awidth="13%">Invoice Balance (RM)</th>
				<th $style_display awidth="10%">Paid (RM)</th>
				<th $style_display awidth="35%">Description</th>
				<th style="text-align:center;" awidth="5%">&nbsp;</th>
   	</tr>
   	
   	$norecord
   	$addForms1
   	$invoiceline
   	$totalcolumn
   	$addInvoice
   	$addForms2
   	
    	</tbody>
  		</table>
				
EOF;
				
  }
 
  public function updatePayment( ) {

 	
 	$timestamp= date("y/m/d H:i:s", time()) ;   
   
   if($this->payment_date=="")
   $this->payment_date = $timestamp;
   
 	$sql="UPDATE $this->tablepayment SET
	payment_no='$this->payment_no',
	customer_id=$this->customer_id,
	payment_type=$this->payment_type,
	payment_amount='$this->payment_amount',
	payment_chequeno='$this->payment_chequeno',
	payment_desc='$this->payment_desc',
	payment_date='$this->payment_date',
	payment_receivedby='$this->payment_receivedby',
	updated='$timestamp',
	updatedby=$this->updatedby
	WHERE payment_id=$this->payment_id";
	
	$this->log->showLog(3, "Update payment_id: $this->payment_id, $this->payment_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update payment failed");
		return false;
	}
	else{
		$this->updatePaymentLine( );
		$this->log->showLog(3, "Update payment successfully.");
		return true;
	}
  } // end of member function updatePayment

	
  public function insertPayment( ) {
  
	$timestamp= date("y/m/d H:i:s", time()) ;   
   
   if($this->payment_date=="")
   $this->payment_date = $timestamp;
   
	$this->log->showLog(3,"Inserting new payment $this->payment_no");
 	$sql="INSERT INTO $this->tablepayment 
 			(payment_no,customer_id,payment_type,payment_date,payment_amount,payment_chequeno,payment_desc,payment_receivedby,createdby,created,updatedby,updated) 
 			values 	('$this->payment_no',
 						$this->customer_id,
 						$this->payment_type,
 						'$this->payment_date',
						$this->payment_amount,
						'$this->payment_chequeno',
						'$this->payment_desc',
						'$this->payment_receivedby',
						 $this->createdby,
						'$timestamp',
						 $this->updatedby,
						'$timestamp')";
	$this->log->showLog(4,"Before insert payment SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert payment code $payment_desc");
		return false;
	}
	else{
		$this->insertPaymentLine( );
		$this->log->showLog(3,"Inserting new payment $payment_desc successfully"); 
		return true;
	}	
	
	
  } // end of member function insertPayment
  
  
  public function insertPaymentLine($inv_id="") {
  
	$i = 0;
	$totamount = 0;
	foreach($this->paymentline_id as $id ){
	
	$line_id = $this->paymentline_id[$i];
	$desc = $this->paymentline_desc[$i];
	$invoice_id = $this->invoice_id[$i];
	$amount = $this->paymentline_amount[$i];
	
	if($invoice_id == "")
		$invoice_id = 0;
	
	if($inv_id=="")
	$latest_id=$this->getLatestPaymentID();
	else
	$latest_id=$this->payment_id;	
	
	$totamount += $amount;
	
	
	$sql="INSERT INTO $this->tablepaymentline 
 			(payment_id,invoice_id,paymentline_amount,paymentline_desc) 
 			values 	($latest_id,
				 $invoice_id,
				 $amount,
				 '$desc')";
						
	$this->log->showLog(4,"Before insert payment SQL:$sql");
	
	//if($amount>0)
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert payment line $line_id");
		return false;
	}
	
	$i++;
	}
	
	
	  
  
  } // end of insert item line
  
  
  public function updatePaymentLine( ) {
 	
	//$sql = " delete from $this->tablepaymentline where payment_id = $this->payment_id ";
	
	
	$i=0;
	foreach($this->paymentline_id as $id ){
	
	$paymentline_id = $this->paymentline_id[$i];
	$paymentline_amount = $this->paymentline_amount[$i];
	$paymentline_desc = $this->paymentline_desc[$i];
	
	$sql = "UPDATE $this->tablepaymentline SET
				paymentline_amount = $paymentline_amount,
				paymentline_desc = '$paymentline_desc' 
				WHERE paymentline_id = $paymentline_id and payment_id = $this->payment_id ";
	
	$this->log->showLog(4,"Update Payment Line, before execute:" . $sql . "<br>");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update payment failed");
		return false;
	}
	
	$i++;
	}
 	
	return true;
	
	
  }
  

  public function addPaymentLine(){
  
  	$i = 0;
	$totamount = 0;
	foreach($this->paymentline_id as $id ){
	
	$line_id = $this->paymentline_id[$i];
	$desc = $this->paymentline_desc[$i];
	$invoice_id = $this->invoice_id[$i];
	$amount = $this->paymentline_amount[$i];
	$invoice_select = $this->invoice_select[$i+1];
	
	$sql="INSERT INTO $this->tablepaymentline 
 			(payment_id,invoice_id,paymentline_amount,paymentline_desc) 
 			values 	($this->payment_id,$invoice_id,$amount,'$desc')";
						
	$this->log->showLog(4,"Before insert payment SQL:$sql");
	
	if($invoice_select=="on"){
		$rs=$this->xoopsDB->query($sql);
	
		if (!$rs){
			$this->log->showLog(1,"Failed to insert payment line $line_id");
			return false;
		}
	}
	
	$i++;
	}
	return true;
	
  }
  

  public function fetchPayment( $payment_id) {
    
    //echo $payment_id;
	$this->log->showLog(3,"Fetching payment detail into class Payment.php.<br>");
		
	$sql="SELECT payment_id,payment_no,customer_id,payment_date,payment_type,payment_amount,payment_chequeno,payment_desc,payment_receivedby,created,createdby,updated,updatedby 
			from $this->tablepayment 
			where payment_id=$payment_id";
	
	$this->log->showLog(4,"ProductPayment->fetchPayment, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$this->payment_no=$row['payment_no'];
	$this->customer_id=$row['customer_id'];
	$this->payment_date=$row['payment_date'];
	$this->payment_type=$row['payment_type'];
	$this->payment_amount=$row['payment_amount'];
	$this->payment_chequeno=$row['payment_chequeno'];
	$this->payment_desc=$row['payment_desc'];

	$this->payment_receivedby=$row['payment_receivedby'];
	
   $this->log->showLog(4,"Payment->fetchPayment,database fetch into class successfully");	
	$this->log->showLog(4,"payment_no:$this->payment_no");
	$this->log->showLog(4,"iscomplete:$this->iscomplete");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Payment->fetchPayment,failed to fetch data into databases.");	
	}
  } // end of member function fetchPayment

  public function deletePayment( $payment_id ) {
    	$this->log->showLog(2,"Warning: Performing delete payment id : $payment_id !");
	$sql="DELETE FROM $this->tablepayment where payment_id=$payment_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: payment ($payment_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"payment ($payment_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deletePayment

  
  public function getSQLStr_AllPayment( $wherestring,  $orderbystring,  $startlimitno,$recordcount ) {

	
	$sql = "SELECT * from ( SELECT c.payment_id,c.payment_no,c.customer_id,a.customer_name,c.payment_date,c.payment_type,c.payment_amount,c.payment_chequeno,c.payment_desc,c.payment_receivedby,c.created,c.createdby,c.updated,c.updatedby,
				(select sum(paymentline_amount) as tot_amount from $this->tablepaymentline where c.payment_id = payment_id ) as total_amount,
				(c.payment_amount - (select sum(paymentline_amount) as tot_amount from $this->tablepaymentline where c.payment_id = payment_id) ) as difference_amount
				FROM $this->tablepayment c ,$this->tablecustomer a
				$wherestring $orderbystring LIMIT $startlimitno,$recordcount ) m ";
				
  $this->log->showLog(4,"Running ProductPayment->getSQLStr_AllPayment: $sql"); 
 return $sql;
  } // end of member function getSQLStr_AllPayment

 public function showPaymentTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0, $token=""){
	$this->log->showLog(3,"Showing Payment Table");
	$sql=$this->getSQLStr_AllPayment($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    	<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Payment No</th>
				<th style="text-align:center;">Customer</th>
				<th style="text-align:center;">Complete</th>
				<th style="text-align:center;">Edit</th>
				<th style="text-align:center;">View</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$payment_id=$row['payment_id'];
		$payment_no=$row['payment_no'];
		$customer_id=$row['customer_id'];
		$customer_name=$row['customer_name'];
		$payment_date=$row['payment_date'];
		$payment_type=$row['payment_type'];
		$payment_amount=$row['payment_amount'];
		$payment_chequeno=$row['payment_chequeno'];
		$payment_desc=$row['payment_desc'];
		$payment_receivedby=$row['payment_receivedby'];
		
		$total_amount=$row['payment_amount'];
		$difference_amount=$row['payment_amount'];
		
		if($payment_type==1)
		$payment_type = "Cash";
		else
		$payment_type = "Cheque";
		
		
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$payment_no</td>
			<td class="$rowtype" style="text-align:center;">$customer_name</td>
			
			<td class="$rowtype" style="text-align:center;">
				<form action="payment.php" method="POST">
				<input type="image" src="images/list.gif" name="submit" title='View this payment'>
				<input type="hidden" value="$payment_id" name="payment_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr>
			<form action='payment.php' name='frmPayment' method='POST'>
			<input type='hidden' value='' name='payment_id'>
			<input type='hidden' name='action' value=''>
			<input type='hidden' name='token' value='$token'></form>	
	</tbody></table>";
 }

  
  
  // start serach table
  
  public function showSearchTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0, $orderctrl="", $fldSort ="", $token=""){
	$this->log->showLog(3,"Showing Payment Table");
	
	$sql=$this->getSQLStr_AllPayment($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	
	if($orderctrl=='asc'){
	
	if($fldSort=='payment_no')
	$sortimage1 = 'images/sortdown.gif';
	else
	$sortimage1 = 'images/sortup.gif';
	if($fldSort=='customer_id')
	$sortimage2 = 'images/sortdown.gif';
	else
	$sortimage2 = 'images/sortup.gif';
	if($fldSort=='iscomplete')
	$sortimage3 = 'images/sortdown.gif';
	else
	$sortimage3 = 'images/sortup.gif';
	if($fldSort=='total_amount')
	$sortimage4 = 'images/sortdown.gif';
	else
	$sortimage4 = 'images/sortup.gif';
	if($fldSort=='payment_type')
	$sortimage5 = 'images/sortdown.gif';
	else
	$sortimage5 = 'images/sortup.gif';
	if($fldSort=='payment_amount')
	$sortimage6 = 'images/sortdown.gif';
	else
	$sortimage6 = 'images/sortup.gif';
	if($fldSort=='difference_amount')
	$sortimage7 = 'images/sortdown.gif';
	else
	$sortimage7 = 'images/sortup.gif';
	
	
	}else{
	$sortimage1 = 'images/sortup.gif';
	$sortimage2 = 'images/sortup.gif';
	$sortimage3 = 'images/sortup.gif';
	$sortimage4 = 'images/sortup.gif';
	$sortimage5 = 'images/sortup.gif';
	$sortimage6 = 'images/sortup.gif';
	$sortimage7 = 'images/sortup.gif';
	
	}


	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Payment No <br><input type='image' src="$sortimage1" name='submit'  title='Sort this record' onclick = " headerSort('payment_no');"></th>
				<th style="text-align:center;">Customer <br><input type='image' src="$sortimage2" name='submit'  title='Sort this record' onclick = " headerSort('customer_id');"></th>
				<th style="text-align:center;">Date <br><input type='image' src="$sortimage3" name='submit'  title='Sort this record' onclick = " headerSort('payment_date');"></th>
				<th style="text-align:center;">Amount (RM) <br><input type='image' src="$sortimage4" name='submit'  title='Sort this record' onclick = " headerSort('payment_amount');"></th>
				<th style="text-align:center;">Payment Type<br><input type='image' src="$sortimage5" name='submit'  title='Sort this record' onclick = " headerSort('payment_type');"></th>
				<th style="text-align:center;">Invoice Paid (RM)<br><input type='image' src="$sortimage6" name='submit'  title='Sort this record' onclick = " headerSort('total_amount');"></th>
				<th style="text-align:center;">Difference Amount (RM) <br><input type='image' src="$sortimage7" name='submit'  title='Sort this record' onclick = " headerSort('difference_amount');"></th>
				<th style="text-align:center;">Edit</th>
				
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$payment_id=$row['payment_id'];
		$payment_no=$row['payment_no'];
		$customer_id=$row['customer_id'];
		$customer_name=$row['customer_name'];
		$invoice_id=$row['invoice_id'];
		$payment_date=$row['payment_date'];
		$payment_type=$row['payment_type'];
		$payment_amount=$row['total_amount'];
		$payment_chequeno=$row['payment_chequeno'];
		$payment_desc=$row['payment_desc'];
		$payment_receivedby=$row['payment_receivedby'];
		
		$total_amount=$row['payment_amount'];
		$difference_amount=$row['difference_amount'];
		
		if($payment_type==1)
		$payment_type = "Cash";
		else
		$payment_type = "Cheque";
		
		
			
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		$editimage = "<input type='image' src='images/edit.gif' name='imgSubmit' title='Edit this invoice'>
							<input type='hidden' value='$payment_id' name='payment_id'>
							<input type='hidden' name='action' value='edit'>";
		
		$zoomctrl_tbl = "<image style = 'cursor:pointer' src='images/zoom.png' title='View This Customer'	onclick = 'document.frmZoom.customer_id.value = $customer_id ;document.frmZoom.submit();' >";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$payment_no</td>
			<td class="$rowtype" style="text-align:center;">$customer_name&nbsp;$zoomctrl_tbl</td>
			<td class="$rowtype" style="text-align:center;">$payment_date</td>
			<td class="$rowtype" style="text-align:center;">$total_amount</td>
			<td class="$rowtype" style="text-align:center;">$payment_type</td>
			<td class="$rowtype" style="text-align:center;">$payment_amount</td>
			<td class="$rowtype" style="text-align:center;">$difference_amount</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="payment.php" method="POST">
				$editimage
				</form>
			</td>
			

		</tr>
EOF;
	}
	
		
	$printctrl="<tr><td colspan='11' align=right><form action='viewpayment_report.php' method='POST' target='_blank' name='frmPdf'>
					<input type='image' src='images/reportbutton.jpg'>
					<input type='hidden' name='wherestr' value=\"$wherestring\">
					<input type='hidden' name='orderstr' value='$orderbystring'>
					</form></td></tr>";
					
	echo $printctrl;
	
	echo  "<form name='frmZoom' action='customer.php' method='POST' target='_BLANK'>
		<input type='hidden' name='action' value='edit'>
		<input type='hidden' name='customer_id' value=''>
		</form>";

	echo  "</tr>
			<form action='payment.php' name='frmPayment' method='POST'>
			<input type='hidden' value='' name='payment_id'>
			<input type='hidden' name='action' value=''>
			<input type='hidden' name='token' value='$token'></form>
				
	</tbody></table>";
	
	
 }



   
   
 public function searchAToZ(){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search payment easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(b.customer_name,1)) as shortname 
					FROM $this->tablepayment a, $this->tablecustomer b
					where a.customer_id = b.customer_id order by a.customer_id";
	$this->log->showLog(4,"With SQL:$sqlfilter");
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	$firstname="";
	/*
	echo "<b>Payment Grouping By Customer Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if payment never do filter yet, if will choose 1st payment listing
		
		echo "<A style='font-size:12;' href='payment.php?filterstring=$shortname'>  $shortname  </A> ";
	}
	*/
	$this->log->showLog(3,"Complete generate list of short cut");
		echo <<<EOF
<BR>
<A href='payment.php?action=new' style='color: GRAY'><img src="images/addnew.jpg"</A>
<A href='payment.php?action=showSearchForm' style='color: gray'><img src="images/search.jpg"</A>

EOF;
return $filterstring;
  }
  
  
  
  


  public function getLatestPaymentID() {
	$sql="SELECT MAX(payment_id) as payment_id from $this->tablepayment;";
	$this->log->showLog(3,'Checking latest created payment_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created payment_id:' . $row['payment_id']);
		return $row['payment_id'];
	}
	else
	return -1;
	
  } // end
  
  



	public function getNewPayment() {
		
		$sql="SELECT CAST(payment_no AS SIGNED) as payment_no, payment_no as ori_data from $this->tablepayment WHERE CAST(payment_no AS SIGNED) > 0 order by CAST(payment_no AS SIGNED) DESC limit 1 ";
	
		$this->log->showLog(3,'Checking latest created payment_no');
		$this->log->showLog(4,"SQL: $sql");
		$query=$this->xoopsDB->query($sql);
	
		if($row=$this->xoopsDB->fetchArray($query)){
			$this->log->showLog(3,'Found latest created payment_no:' . $row['payment_no']);
			$payment_no=$row['payment_no']+1;
	
			if(strlen($row['payment_no']) != strlen($row['ori_data']))
			return str_replace($row['payment_no'], '', $row['ori_data'])."".$payment_no;
			else
			return $payment_no;
			
		}
		else
		return 1;
		
	}
  
  

  public function getSelectPayment($id) {
	
	$sql="SELECT payment_id,payment_no,payment_date from $this->tablepayment where 1 " .
		" order by payment_no";
	$selectctl="<SELECT name='payment_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$payment_id=$row['payment_id'];
		$payment_no=$row['payment_no'];
		$payment_date=$row['payment_date'];
	
		if($id==$payment_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$payment_id' $selected>$payment_no / $payment_date</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end
  
  
	public function getSelectInvoiceArray($id,$line="",$payment_id=0) {
	
	if($id=="")
	$id = 0;

	 	$sql="SELECT invoice_id,invoice_no,invoice_date,customer_id from $this->tableinvoice 
		where iscomplete=1 and customer_id = $this->customer_id 
		and invoice_id not in (select Distinct(invoice_id) from $this->tablepaymentline where payment_id = $payment_id )  
		or invoice_id=$id 
		order by invoice_no";
	
	$selectctl="<SELECT style = 'vertical-align : top;' name='invoice_id[]'  >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"></OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$invoice_id=$row['invoice_id'];
		$invoice_no=$row['invoice_no'];
		$invoice_date=$row['invoice_date'];
		
	
		if($id==$invoice_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
			
			
		$selectctl=$selectctl  . "<OPTION value='$invoice_id' $selected>$invoice_no / $invoice_date</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end



  public function allowDelete($id){
  /*
	$sql="SELECT count(payment_id) as rowcount from $this->tablepayment where payment_id=$id";
	
	$this->log->showLog(3,"Accessing ProductPayment->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this payment, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this payment, record deletable");
		return true;
		}
		*/
		
		return true;
	}


 public function showPaymentHeader($payment_id){
	if($this->fetchPayment($payment_id)){
		$this->log->showLog(4,"Showing payment header successfully.");
	echo <<< EOF
	<table border='1' cellspacing='3'>
		<tbody>
			<tr>
				<th colspan="4">Payment Info</th>
			</tr>
			<tr>
				<td class="head">Payment No</td>
				<td class="odd">$this->payment_no</td>
				<td class="head">Payment Description</td>
				<td class="odd"><A href="payment.php?action=edit&payment_id=$payment_id" 
						target="_blank">$this->payment_desc</A></td>
			</tr>
		</tbody>
	</table>
EOF;
	}
	else{
		$this->log->showLog(1,"<b style='color:red;'>Showing payment header failed.</b>");
	}

   }//showRegistrationHeader
   
   
  
  
 public function showSearchForm($wherestring="",$orderctrl=""){

   echo <<< EOF

	<FORM action="payment.php" method="POST" name="frmActionSearch" id="frmActionSearch">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criteria</th>
	    </tr>
	    <tr>
	      <td class='head' width="20%">Payment No</td>
	      <td class='even' width="40%"><input name='payment_no' value='$this->payment_no'> (%, AB%,%AB,%A%B%)</td>
	      <td class='head' width="15%">Customer</td>
	      <td class='even' width="25%">$this->customerctrl</td>
	    </tr>
	    
	    <tr>
	      <td class='head'>Quick Search <br>(Payment No)</td>
	      <td class='odd'>$this->paymentctrl</td>
	      <td class='head'></td>
	      <td class='odd'></td>
	    </tr>
	   
	    
	  </tbody>
	</table>
	<table style="width:150px;">
	  <tbody>
	    <tr>
	      <td><input style="height:40px;" type='submit' value='Search' name='btnSubmit'>
	      <input type='hidden' name='action' value='search'>
			<input type='hidden' name='fldSort' value=''>
			<input type='hidden' name='wherestr' value="$wherestring">
			<input type='hidden' name='orderctrl' value='$orderctrl'>  
	      </td>
	      <td><input type='reset' value='Reset' name='reset'></td>
	    </tr>
	  </tbody>
	</table>
	</FORM>
EOF;
  }

  public function convertSearchString($payment_id,$payment_no,$customer_id){
		$filterstring="";

		if($payment_id > 0 ){
			$filterstring=$filterstring . " c.payment_id=$payment_id AND";
		}

		if($payment_no!=""){
			$filterstring=$filterstring . " c.payment_no LIKE '$payment_no' AND";
		}

		if($customer_id!="0"){
			$filterstring=$filterstring . " c.customer_id LIKE '$customer_id' AND";
		}

		

		if ($filterstring=="")
			return "";
		else {
			$filterstring =substr_replace($filterstring,"",-3);  

		return "WHERE $filterstring";
		}
	
	}
	
	public function getAttnDesc($cust_id,$fld){
	
	$sql = "select $fld from $this->tablecustomer where customer_id = $cust_id limit 1 ";
	
		
	$query=$this->xoopsDB->query($sql);
	
	while($row=$this->xoopsDB->fetchArray($query)){
	return $row[$fld];
	}
	
	}
	
  public function getUnitPrice($id){
  $item_amount = 0;
  
  $sql = "select item_amount from $this->tableitem where item_id = $id limit 1 ";
  
  $query=$this->xoopsDB->query($sql);
  
  if($row=$this->xoopsDB->fetchArray($query)){
  $item_amount = $row['item_amount'];
  }
  
  return $item_amount;
  
  }
	
	public function getItemDesc($item_id,$fld){
	
	$sql = "select $fld from $this->tableitem where item_id = $item_id limit 1 ";
	
		
	$query=$this->xoopsDB->query($sql);
	
	while($row=$this->xoopsDB->fetchArray($query)){
	return $row[$fld];
	}
	
	}
  

} // end of ClassPayment
?>

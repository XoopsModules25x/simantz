<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


class Invoice
{

public	$invoice_id;
public	$invoice_no;
public	$customer_id;
public	$invoice_date;
public	$invoice_terms;
public	$iscomplete;
public	$invoice_attn;
public	$invoice_preparedby;
public	$invoice_attntel;
public	$invoice_attntelhp;
public	$invoice_attnfax;
public	$invoice_remarks;
public	$terms_id;
public	$created;
public	$createdby;
public	$updated;
public	$updatedby;
public   $preparedby;

// invoice line

public	$invoiceline_id;
public	$invoice_seq;
public	$invoice_desc;
public	$item_id;
public	$item_name;
public	$invoice_qty;
public	$invoice_unitprice;
public	$item_uom;

public	$invoice_discount;
public	$invoice_amount;
public	$invoicelinedelete_id;
public	$iscustomprice;


//

public 	$isAdmin;
public	$invoicectrl;
public	$customerctrl;
public   $rowctrl;
public	$itemctrl;
public	$termsctrl;

public  $xoopsDB;
public  $tableprefix;
public  $tableinvoice;
public  $tableinvoiceline;
public  $tablecategory;
public  $tableitem;
public  $tablecustomer;
public  $tablequotation;
public  $tablepayment;
public  $tablepaymentline;
public  $log;
public  $printPdf;
public 	$tableterms;



//constructor
   public function Invoice($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableinvoice=$tableprefix."tblinvoice";
	$this->tableinvoiceline=$tableprefix."tblinvoiceline";
	$this->tablecategory=$tableprefix."tblcategory";
	$this->tableitem=$tableprefix."tblitem";
	$this->tablecustomer=$tableprefix."tblcustomer";
	$this->tablequotation=$tableprefix."tblquotation";
	$this->tablepayment=$tableprefix."tblpayment";
	$this->tablepaymentline=$tableprefix."tblpaymentline";
	$this->tableterms=$tableprefix."tblterms";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int invoice_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $invoice_id, $token ,$row_item = "") {

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
	
	// declare prepared by
	if($this->invoice_preparedby == ""){
	$this->invoice_preparedby = $this->preparedby;
	}	
	//
	

	//declare attn
	if($type=="attn"){	
	$this->invoice_attn = $this->getAttnDesc($this->customer_id,"customer_contactperson");
	$this->invoice_attntel = $this->getAttnDesc($this->customer_id,"customer_contactno");
	$this->invoice_attntelhp = $this->getAttnDesc($this->customer_id,"customer_contactnohp");
	$this->invoice_attnfax = $this->getAttnDesc($this->customer_id,"customer_contactfax");
	}
	//
	
		
	$this->created=0;
	
	if ($type=="new"){
		$header="New Invoice";
		$action="create";
	 	
		if($invoice_no==0){
			$this->invoice_no=$this->getNewInvoice();
			$this->iscomplete=0;
			

		}
		
		$norecord .= "<tr><td colspan='8'>Please Create Item.</td></tr>";
		$savectrl="<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";
//		$checked="CHECKED";
		$checked="";
		$defaultchecked="";
		$deletectrl="";


	}
	else
	{
	
		$header="Edit Invoice";
		
		if(($type=="row"&& $this->invoice_id=="")||($type=="attn"&& $this->invoice_id=="")||($type=="sortseq"&& $this->invoice_id=="")){//if create row
		$action="create";
		$header="New Invoice";
		}else
		$action="update";
		
		$savectrl=	"<input name='invoice_id' value='$this->invoice_id' type='hidden'>".
			 			"<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";


		if($action!="create"){
		//$action="create";
		$completectrl=	"<input name='completectrl' value='1' type='hidden'>".
							"<input name='invoice_id' value='$this->invoice_id' type='hidden'>".
			 				"<input style='height: 40px;' name='btnComplete' value='Complete' type='button' onclick ='completeRecord();' >";
		$printctrl="<form name='frmPrint' method='post' action='viewinvoice.php' atarget='_BLANK'>
		<input type='hidden' name='invoice_id' value=$this->invoice_id >
		<input type='button' name='printdocument' style='height: 40px;' value='Print' onclick = 'return printSave();'></form>";

		}
		
		}
		

		if($this->isAdmin)
		$recordctrl="";
		

		//force iscomplete checkbox been checked if the value in db is 'Y'
		if ($this->iscomplete=='1')
			$checked="CHECKED";
		else
			$checked="";
		if ($this->isdefault=='1')
			$defaultchecked="CHECKED";
		else
			$defaultchecked="";
	
		
		
		if($this->allowDelete($this->invoice_id))
		$deletectrl="<FORM action='invoice.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this invoice?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->invoice_id' name='invoice_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		
		
		if($this->invoice_date=="")
		$this->invoice_date = date("Y-m-d") ;
		
		/*
		$zoomctrl = "<form name='frmZoom' action='customer.php' method='POST' target='_BLANK'>
		<input type='image' src='images/zoom.png' title='View This Customer' name='imgZoom'>
		<input type='hidden' name='action' value='edit'>
		<input type='hidden' name='customer_id' value=document.forms['frmInvoice'].customer_id.value>
		</form>";*/
		
		$zoomctrl = "<image style = 'cursor:pointer' src='images/zoom.png' title='View This Customer'	onclick = 'if(document.frmInvoice.customer_id.value!=0){document.frmZoom.customer_id.value = document.frmInvoice.customer_id.value ;document.frmZoom.submit();}' >";
		
    echo <<< EOF


<table style="width:140px;"><tbody><td><form onsubmit="return validateInvoice()" method="post"
 action="invoice.php" name="frmInvoice"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      
      <tr>
        	<td class="head">Customer *</td>
        	<td class="odd">$this->customerctrl&nbsp$zoomctrl</td>
  
        	<td class="head">Invoice No *</td>
        	<td class="odd" ><input name='invoice_no' value="$this->invoice_no" maxlength='10' size='15'> </td>
 
     </tr>
           
      <tr>
 
		   <td class="head">Payment Date *</td>
        	<td class="odd" >
        	<input name='invoice_date' id='invoice_date' value="$this->invoice_date" maxlength='10' size='10'>
        	<input name='btnDate' value="Date" type="button" onclick="$this->datectrl">     	 
        	</td>
			<td class="head">Terms</td>
			<td  class="odd" style='display:none'>$this->termsctrl</td>
			<td  class="odd"><input name='invoice_terms' value="$this->invoice_terms" maxlength='35' size='35'></td>
		</tr>
		
		
		<tr>
			<td class="head">Attn</td>
			<td  class="odd"><input name='invoice_attn' value="$this->invoice_attn" maxlength='35' size='35'></td>
			<td class="head">Attn Tel</td>
			<td  class="odd"><input name='invoice_attntel' value="$this->invoice_attntel" maxlength='20' size='20'></td>			
		</tr>
		
		<tr>
			<td class="head">Attn Tel (HP)</td>
			<td  class="odd"><input name='invoice_attntelhp' value="$this->invoice_attntelhp" maxlength='20' size='20'></td>
			<td class="head">Attn Fax</td>
			<td  class="odd"><input name='invoice_attnfax' value="$this->invoice_attnfax" maxlength='20' size='20'></td>
		</tr>
		<tr>
			<td class="head">Prepared By</td>
			<td  class="odd"><input name='invoice_preparedby' value="$this->invoice_preparedby" maxlength='35' size='35'></td>
		<td class="head"></td>
			<td  class="odd"></td>
	
			</tr>
		<tr>
			<td class="head">Remarks</td>
			<td  class="odd" colspan='3'>
				<textarea  name="invoice_remarks" cols='70' maxlength='200' rows='5'>$this->invoice_remarks</textarea></td>

		
		</tr>
	
	

    </tbody>
  </table>
  <p>
EOF;
//if($type=="edit")


if($invoice_id!="")
$this->getChildForm( $type,  $invoice_id, $token ,$row_item);


echo <<< EOF

  <p>
	<table style="width:150px;"><tbody><td>$savectrl&nbsp;</td><td>$completectrl&nbsp;</td><td>
	<input name="action" value="$action" type="hidden">
	<input name="invoicelinedelete_id" value="$this->invoicelinedelete_id" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	<input name="printPdf" value=0 type="hidden"></td>
	</form><td>$printctrl</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$deletectrl</td></tbody></table>
  <br>

$recordctrl

EOF;

echo  "<form name='frmZoom' action='customer.php' method='POST' target='_BLANK'>
		<input type='hidden' name='action' value='edit'>
		<input type='hidden' name='customer_id' value=''>
		</form>";

echo "<iframe src='validate_invoice.php?xf_action=$action' id='idValidate' style='display:none' >aa</iframe>";


	if($this->printPdf==1)
	echo "<script language=javascript>document.forms['frmPrint'].submit();</script>";
} // end of member function getInputForm
  
  
  
  
  public function getChildForm( $type,  $invoice_id, $token ,$row_item = ""){
  
  // show row invoice line
			$c = 0;
			$i = 0;
			$j = 0;
			$line_i = 0;
			$tot_amount = 0;
		
			/*
			$sql = "SELECT il.invoiceline_id, il.invoice_seq, il.invoice_id, il.invoice_desc, il.item_id, il.item_name, il.invoice_qty,
					il.invoice_unitprice, il.invoice_amount, il.invoice_discount, il.iscustomprice,p.item_uom 
					from $this->tableinvoiceline il 
					inner join $this->tableitem p on il.item_id=p.item_id where invoice_id = $this->invoice_id order by invoice_seq asc ";
					*/
			$sql = "SELECT il.invoiceline_id, il.invoice_seq, il.invoice_id, il.invoice_desc, il.item_id, il.item_name, il.invoice_qty,
					il.invoice_unitprice, il.invoice_amount, il.invoice_discount, il.iscustomprice,il.item_uom 
					from $this->tableinvoiceline il where invoice_id = $this->invoice_id order by invoice_seq asc ";
					
			$this->log->showLog(4,"With SQL: $sql");
		
			$query=$this->xoopsDB->query($sql);
	

			echo <<< EOF
		
			<table style="width:300px;" align=center border=1>
				<tr height=30 valign=bottom>
				<td class="head"  width="150px" align=center>No. Of Item :</td>
				<td class="odd" width="100px"><input type="input" name="fldRow" value="$row_item" max=10 size=10></td>
				<td class="odd" width="50px"><input style="height: 35px;" type="button" name="btnCreate" value="Create" onclick = " return createRow();"></td>
				</tr>
			</table>
		
			<table border='1'>
				<tbody>
			<tr astyle="display:none">
						<th style="text-align:center;">No</th>
						<th style="text-align:center;">Seq</th>
						<th style="text-align:center;">Item</th>
						<th style="text-align:center;">Qty / UOM</th>
						<th style="text-align:center;">Unit Price (RM)</th>
						<th style="text-align:center;">Discount (%)</th>
						<th style="text-align:center;">Amount (RM)</th>
						<th style="text-align:center;">&nbsp;</th>
			</tr>
			<div id="idItemLine">&nbsp;</div>


EOF;

			while($row=$this->xoopsDB->fetchArray($query)){
				$i++;
				
				if($rowtype=="odd")
					$rowtype="even";
				else
					$rowtype="odd";
   	
				$line_id = $row['invoiceline_id'];
				$seq = $row['invoice_seq'];
				$desc = $row['invoice_desc'];
				$item_id = $row['item_id'];
				$item_name = $row['item_name'];
				$qty = $row['invoice_qty'];
				$unitprice = $row['invoice_unitprice'];
				$discount = $row['invoice_discount'];
				$amount = $row['invoice_amount'];
				$tot_amount += $row['invoice_amount'];
				$iscustomprice = $row['iscustomprice'];
				$item_uom=$row['item_uom'];
				
				if($row['iscustomprice']=="1")
					$iscustomprice='checked';
				else
					$iscustomprice="";
				
				

				// display item descs				
				if($item_id==0)
					$styledisplay = " ";
				else
					$styledisplay = " style = 'display:none' ";
			
				
				$styledesc = "";
				$styledescshow = "style='font-weight : bold; cursor : pointer;'";
				$styledeschide = "style='font-weight : bold; cursor : pointer;'";
			
				if($desc==""){
				$styledesc = "style = 'display:none'";
				$styledeschide = "style='font-weight : bold; cursor : pointer; display :none;'";
				}else{
				$styledescshow = "style='font-weight : bold; cursor : pointer; display :none;'";
				}
		
   			$itemctrl = $this->getSelectItemArray($item_id,$i);
   			

echo <<< EOF
			<tr>
   						<input type="hidden" name="invoiceline_id[]" value=$line_id>
							<td class=$rowtype>$i</td>
							<td class=$rowtype align="center"><input type="input" name="invoice_seq[]" max=5 size=5 value =$seq></td>
							<td class=$rowtype>											
							Item Name: $itemctrl &nbsp;<br>
							<input $styledisplay type="input" name="item_name[]" value="$item_name" size="50" maxlength="50">
							<a  id="idShow$i" $styledescshow  onclick = "return showDescription(this.id,1,$i)" ><br>
							<u>Show Description</u></a>
							<a  id="idHide$i" $styledeschide  onclick = "return showDescription(this.id,2,$i)"><br>
							<u>Hide Description</u><a><br>	
							<div $styledesc id="idDesc$i">
							<textarea  name="invoice_desc[]" cols="50" maxlength="200" rows="3">$desc</textarea></div>
							</td>
							<td class=$rowtype align="center"><input style = "text-align:center;" type="input" name="invoice_qty[]" max=5 size=5 value="$qty"  onBlur = "return calculateAmount1($i,this.name)" onfocus="this.select();" onclick="this.select();" autocomplete="off" >&nbsp;/&nbsp;
							<input size="5"  maxlength="10" name="item_uom[]" value="$item_uom"></td>
							<td class=$rowtype align=center><input $styledisabled style = "text-align:right;" type="input" name="invoice_unitprice[]" max=10 size=10 value="$unitprice" onchange = "unitPrice($c);"  onBlur = "return calculateAmount2($i,this.name)" onfocus="this.select();" onclick="this.select();" autocomplete="off"><br>
							<input id="customPrice$c" type="checkbox" name="iscustomprice[$c]" $iscustomprice >Force This Price</td>
							<td class=$rowtype align="center"><input style = "text-align:center;" type="input" name="invoice_discount[]" max=5 size=5 value="$discount"  onBlur = "return calculateAmount3($i,this.name)" onfocus="this.select();" onclick="this.select();" autocomplete="off"></td>
							<td class=$rowtype align=center><input readonly style = "background-color : silver;color:black;text-align:right;" type="input" name="invoice_amount[]" maxlength=12 size=11 value="$amount"></td>
							<td class=$rowtype align=center>
							<input style="cursor: pointer;color: black;background-color : white;" type="button" value="Delete" onclick = "return deleteInvoiceLine($line_id,$this->invoice_id)" ></td>
   					</tr>

EOF;

			$c++;
			
			}
			
		
			
			
		
		if($i==0){
		$norecord .= "<tr><td colspan='8'>Please Create Item.</td></tr>";
		}
		
		$tot_amount = number_format($tot_amount, 2, '.','');
		
		if($i>0){
		$totalcolumn .= "<tr>
								<td colspan='5'></td>
								<td class='head' style='font-weight : bold;' align=center>Total</td>
								<td class='head' align=center><input readonly style = 'background-color : silver;color:black;text-align:right;' type='input' name='invoce_total' max=12 size=11 value='$tot_amount'></td>
								<td class='head'></td>
								</tr>";
		}		

echo <<< EOF
   	
   	$norecord
   	$totalcolumn
   	
    </tbody>
  </table>  
EOF;
	
  }


	
	
  public function completeInvoice( ) {

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	
 	$sql=$sql="UPDATE $this->tableinvoice SET
	invoice_no='$this->invoice_no',
	customer_id=$this->customer_id,
	invoice_terms='$this->invoice_terms',
	iscomplete='1',
	invoice_attn='$this->invoice_attn',
	invoice_preparedby='$this->invoice_preparedby',
	invoice_date='$this->invoice_date',
	invoice_attntel='$this->invoice_attntel',
	invoice_attntelhp='$this->invoice_attntelhp',
	invoice_attnfax='$this->invoice_attnfax',
	invoice_remarks='$this->invoice_remarks',
	terms_id=$this->terms_id,
	updated='$timestamp',
	updatedby=$this->updatedby
	WHERE invoice_id=$this->invoice_id";
	
	$this->log->showLog(3, "Complete invoice_id: $this->invoice_id, $this->invoice_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Complete invoice failed");
		return false;
	}
	else{
		$this->updateInvoiceLine("complete");
		$this->log->showLog(3, "Complete invoice successfully.");
		return true;
	}
  } // end of member function completeInvoice
  
	
  public function enableInvoice( ) {

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	
 	$sql="UPDATE $this->tableinvoice SET
	iscomplete=0,
	updated='$timestamp',
	updatedby=$this->updatedby
	WHERE invoice_id=$this->invoice_id";
	
	$this->log->showLog(3, "Enable invoice_id: $this->invoice_id, $this->invoice_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Enable invoice failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Enable invoice successfully.");
		return true;
	}
  } // end of member function enabledInvoice
  
  
  
	
  public function deleteInvoiceLine( ) {

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	
 	$sql="delete from $this->tableinvoiceline WHERE invoice_id=$this->invoice_id and invoiceline_id = $this->invoicelinedelete_id ";
	
	$this->log->showLog(3, "Enable invoice_id: $this->invoice_id, $this->invoice_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Delete invoice failed");
		return false;
	}
	else{
		$this->updateInvoice();
		$this->calculateTotal($this->invoice_id);
		$this->log->showLog(3, "Delete invoice successfully.");
		return true;
	}
	
  } // end of member function deleteInvoiceLine
  
  
 
  
 
  public function updateInvoice( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableinvoice SET
	invoice_no='$this->invoice_no',
	customer_id=$this->customer_id,
	invoice_terms='$this->invoice_terms',
	invoice_attn='$this->invoice_attn',
	invoice_preparedby='$this->invoice_preparedby',
	invoice_attntel='$this->invoice_attntel',
	invoice_date='$this->invoice_date',
	invoice_attntelhp='$this->invoice_attntelhp',
	invoice_attnfax='$this->invoice_attnfax',
	invoice_remarks='$this->invoice_remarks',
	terms_id=$this->terms_id,
	updated='$timestamp',
	updatedby=$this->updatedby
	WHERE invoice_id=$this->invoice_id";
	
	$this->log->showLog(3, "Update invoice_id: $this->invoice_id, $this->invoice_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update invoice failed");
		return false;
	}
	else{
		$this->updateInvoiceLine( );
		$this->log->showLog(3, "Update invoice successfully.");
		return true;
	}
  } // end of member function updateInvoice

	
  public function insertInvoice( ) {

   $timestamp= date("y/m/d H:i:s", time()) ;   
   
   if($this->payment_date=="")
   $this->invoice_date = $timestamp;
   
	$this->log->showLog(3,"Inserting new invoice $this->invoice_no");
 	$sql="INSERT INTO $this->tableinvoice 
 			(invoice_no,customer_id,invoice_date,invoice_terms,iscomplete,invoice_attn,invoice_preparedby,invoice_attntel,invoice_attntelhp,invoice_attnfax,invoice_remarks,terms_id,createdby,created,updatedby,updated) 
 			values 	('$this->invoice_no',
 						$this->customer_id,
 						'$this->invoice_date',
 						'$this->invoice_terms',
 						$this->iscomplete,
						'$this->invoice_attn',
						'$this->invoice_preparedby',
						'$this->invoice_attntel',
						'$this->invoice_attntelhp',
						'$this->invoice_attnfax',
						'$this->invoice_remarks',
						$this->terms_id,
						 $this->createdby,
						'$timestamp',
						 $this->updatedby,
						'$timestamp')";
	$this->log->showLog(4,"Before insert invoice SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert invoice code $invoice_desc");
		return false;
	}
	else{
		
		$this->log->showLog(3,"Inserting new invoice $invoice_desc successfully"); 
		return true;
	}	
	
	
  } // end of member function insertInvoice
  
  
  public function insertLineSave($row){
  
  $i = 0;
  
  while($i<$row){
  
 	 	$i++;
		$seq = $this->getInvoiceSeqMax(); 	 	
 	 	
  		$sql="INSERT INTO $this->tableinvoiceline 
 			(invoice_seq,invoice_id,invoice_desc,item_id,item_name, invoice_qty,invoice_unitprice,invoice_discount,invoice_amount,iscustomprice ) 
 			values 	($seq,
					$this->invoice_id,
					'',
					0,
					'',
					0,
					0,
					0,
					0,
					0)";
						
		$this->log->showLog(4,"Before insert invoice SQL I=$i, customprice_id:$sql");
		$rs=$this->xoopsDB->query($sql);
	
		if (!$rs){
			$this->log->showLog(1,"Failed to insert invoice line  $line_id");
			return false;
		}
	
	}
	
	$this->calculateTotal($this->invoice_id);
	return true;
	
  }
  
  public function getInvoiceSeqMax() {
  	$invoice_seq = 10;
  	
	$sql="SELECT MAX(invoice_seq) as invoice_seq from $this->tableinvoiceline where invoice_id = $this->invoice_id;";
	$this->log->showLog(3,'Checking latest created invoice_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found max:' . $row['invoice_seq']);
		$invoice_seq=$row['invoice_seq']+10;
		return $invoice_seq;
	}
	else
	return 10;
	
  } // end
  
  /*
  public function insertInvoiceLine($inv_id="",$others="") {
  
	$i = 0;
	$totamount = 0;
	foreach($this->invoiceline_id as $id ){
	
		
	$line_id = $this->invoiceline_id[$i];
	$seq = $this->invoice_seq[$i];
	$desc = $this->invoice_desc[$i];
	$item_id = $this->item_id[$i];
	$item_name = $this->item_name[$i];
	$qty = $this->invoice_qty[$i];
	$unitprice = $this->invoice_unitprice[$i];
	$discount = $this->invoice_discount[$i];
	$amount = $this->invoice_amount[$i];

	$iscustomprice = $this->iscustomprice[$i];
		$this->log->showLog(1,"get " . $this->iscustomprice);
	
//echo 	$iscustomprice."<br>" ;
	
	$line_iscustomprice=0;
	
	if($iscustomprice=="on"||$others=="complete")
		$line_iscustomprice=1;
	else
		$line_iscustomprice=0;
		
		//echo $line_iscustomprice;


	if($item_id == "")
		$item_id = 0;
	
	if($inv_id=="")
	$latest_id=$this->getLatestInvoiceID();
	else
	$latest_id=$this->invoice_id;
	
	
	//get unit price 
	//if($item_id != 0)
	
	if($item_id != 0)
		$unitprice = $this->getUnitPrice($item_id);
	
	//echo $iscustomprice."".$i;
	if($iscustomprice=="on")
	$unitprice = $this->invoice_unitprice[$i];
	
	$amount = $qty * $unitprice - ($discount/100)*($qty * $unitprice);	
	
	$totamount += $amount;
	
	//get item name
	if($item_id != 0)
	$item_name = $this->getItemDesc($item_id,'item_desc');
	
	$sql="INSERT INTO $this->tableinvoiceline 
 			(invoice_seq,invoice_id,invoice_desc,item_id,item_name, invoice_qty,invoice_unitprice,invoice_discount,invoice_amount,iscustomprice ) 
 			values 	($seq,
				 		$latest_id,
				 		'$desc',
				 		$item_id,
				 		'$item_name',
						$qty,
						$unitprice,
						$discount,
						$amount,
						$line_iscustomprice)";
						
	$this->log->showLog(4,"Before insert invoice SQL I=$i, customprice_id: ".$this->iscustomprice[$i].":$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert invoice line  $line_id");
		return false;
	}
	
	$i++;
	}
	
	if($latest_id!=""){
	
		$sql = " update $this->tableinvoice SET invoice_totalamount = '$totamount' WHERE invoice_id = '$latest_id' ";
	
		$rs=$this->xoopsDB->query($sql);
	
		if (!$rs){
			$this->log->showLog(1,"Failed to update invoice $latest_id");
			return false;
		}
	}
	  
  
  } // end of insert item line
  
  */
  
  
  
  public function updateInvoiceLine($others="") {
 	
 	
	$i=0;
	$totamount = 0;
	foreach($this->invoiceline_id as $id ){
	
	$line_id = $this->invoiceline_id[$i];
	$seq = $this->invoice_seq[$i];
	$desc = $this->invoice_desc[$i];
	$item_id = $this->item_id[$i];
	$item_name = $this->item_name[$i];
	$item_uom = $this->item_uom[$i];

	$qty = $this->invoice_qty[$i];
	$unitprice = $this->invoice_unitprice[$i];
	$amount = $this->invoice_amount[$i];
	$discount = $this->invoice_discount[$i];
	$iscustomprice = $this->iscustomprice[$i];
		
	if($iscustomprice=="on"){
	$iscustomprice = 1;
	}else{
	$unitprice = $this->getUnitPrice($item_id);
	$iscustomprice = 0;
	}
	
	if($others=="complete")
	$iscustomprice = 1;


	//get item name
	if($item_id != 0){
	$item_name = $this->getItemDesc($item_id,'item_desc');
	$item_uom = $this->getItemDesc($item_id,'item_uom');
	}
	
	$totamount += $amount;
	
	$sql = "UPDATE $this->tableinvoiceline SET
		invoice_seq = $seq,
		invoice_desc = '$desc',
		item_id = $item_id,
		item_name = '$item_name',
		invoice_qty = $qty,
		item_uom = '$item_uom',
		invoice_unitprice = $unitprice,
		invoice_amount = $amount,
		invoice_discount = $discount,
		iscustomprice = $iscustomprice
	 	where invoice_id = $this->invoice_id and invoiceline_id = $line_id ";
		
		
		$this->log->showLog(4,"Before insert invoice SQL I=$i, customprice_id:$sql");
	
		$rs=$this->xoopsDB->query($sql);
		if(!$rs){
			$this->log->showLog(2, "Warning! Update invoice failed");
			return false;
		}
		
		
		
	$i++;
	}
	
	$this->calculateTotal($this->invoice_id);	
	return true;
 	
	
  }
  
  public function calculateTotal($invoice_id){
	  
	  $sql = "SELECT * from $this->tableinvoiceline where invoice_id = $invoice_id ";
	  
	  $this->log->showLog(4,"With SQL: $sql");
			
	  $query=$this->xoopsDB->query($sql);
	  
	  $i = 0;
	  $totalamount = 0;
	  
	  while($row=$this->xoopsDB->fetchArray($query)){
	  $i++;
	  
	  $invoiceline_id = $row['invoiceline_id'];
	  
	  $amount = $row['invoice_unitprice']*$row['invoice_qty'] - ($row['invoice_discount']/100)*($row['invoice_unitprice']*$row['invoice_qty']);
	  
	  $sqlupdate = "UPDATE $this->tableinvoiceline SET invoice_amount = $amount where invoice_id = $invoice_id and invoiceline_id = $invoiceline_id ";
	  
	  $this->log->showLog(4,"Before Execute SQL: $sqlupdate");
	  
	  $rs=$this->xoopsDB->query($sqlupdate);
	  if(!$rs){
		  $this->log->showLog(2, "Warning! Update invoice line failed");
		  return false;
	  }
	  
	  $totalamount += $amount;
	  
	  }
	  
	  $sqlupdate = "UPDATE $this->tableinvoice SET invoice_totalamount = $totalamount where invoice_id = $invoice_id";
	  
	  $this->log->showLog(4,"Before Execute SQL: $sqlupdate");
	  
	  $rs=$this->xoopsDB->query($sqlupdate);
	  if(!$rs){
		  $this->log->showLog(2, "Warning! Update invoice failed");
		  return false;
	  }
	  
	  return true;
  
  }
  
  



  public function fetchInvoice( $invoice_id) {
    
    //echo $invoice_id;
	$this->log->showLog(3,"Fetching invoice detail into class Invoice.php.<br>");
		
	$sql="SELECT invoice_id,invoice_no,customer_id,invoice_date,invoice_terms,iscomplete,invoice_attn,invoice_preparedby,invoice_attntel,invoice_attntelhp,invoice_attnfax,invoice_remarks,terms_id,created,createdby,updated,updatedby 
			from $this->tableinvoice 
			where invoice_id=$invoice_id";
	
	$this->log->showLog(4,"ProductInvoice->fetchInvoice, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$this->invoice_no=$row['invoice_no'];
	$this->customer_id=$row['customer_id'];
	$this->invoice_date=$row['invoice_date'];
	$this->invoice_terms=$row['invoice_terms'];
	$this->iscomplete=$row['iscomplete'];
	$this->invoice_attn=$row['invoice_attn'];
	$this->invoice_preparedby=$row['invoice_preparedby'];
	$this->invoice_attntel=$row['invoice_attntel'];
	$this->invoice_attntelhp=$row['invoice_attntelhp'];
	$this->invoice_attnfax=$row['invoice_attnfax'];
	$this->invoice_remarks=$row['invoice_remarks'];
	$this->terms_id=$row['terms_id'];
	
   $this->log->showLog(4,"Invoice->fetchInvoice,database fetch into class successfully");	
	$this->log->showLog(4,"invoice_no:$this->invoice_no");
	$this->log->showLog(4,"iscomplete:$this->iscomplete");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Invoice->fetchInvoice,failed to fetch data into databases.");	
	}
  } // end of member function fetchInvoice

  public function deleteInvoice( $invoice_id ) {
    	$this->log->showLog(2,"Warning: Performing delete invoice id : $invoice_id !");
	$sql="DELETE FROM $this->tableinvoice where invoice_id=$invoice_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: invoice ($invoice_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"invoice ($invoice_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteInvoice

  
  public function getSQLStr_AllInvoice( $wherestring,  $orderbystring,  $startlimitno,$recordcount ) {

/*
    $sql="SELECT c.invoice_id,c.invoice_no,c.invoice_desc,c.street1,c.street2,".
		"c.postcode,c.city,c.state1,c.country,".
		"c.contactperson,c.contactperson_no,c.tel1,c.tel2,c.fax,c.description,".
		"c.created,c.createdby,c.updated, c.updatedby, c.iscomplete, c.isdefault,c.currency_id, ".
		"cr.currency_symbol FROM $this->tableinvoice c " .
		"left join $this->tablecurrency cr on c.currency_id = cr.currency_id ".
	" $wherestring $orderbystring LIMIT $startlimitno,$recordcount";
	*/
	
	$sql = "SELECT * from ( SELECT c.invoice_id,c.invoice_no,c.customer_id,a.customer_name,c.invoice_date,c.invoice_terms,c.iscomplete,c.invoice_attn,c.invoice_preparedby,c.invoice_attntel,c.invoice_attntelhp,c.invoice_attnfax,c.invoice_remarks,c.invoice_totalamount,c.terms_id,c.created,c.createdby,c.updated,c.updatedby,
				(c.invoice_totalamount - coalesce((select sum(paymentline_amount) as payment_amount from $this->tablepaymentline where  invoice_id = c.invoice_id ),NULL,0) ) as invoice_balance,
				(select count(invoiceline_id) as tot_item from $this->tableinvoiceline where  invoice_id = c.invoice_id ) as total_item
				FROM $this->tableinvoice c ,$this->tablecustomer a
				$wherestring $orderbystring LIMIT $startlimitno,$recordcount ) m ";
				
  $this->log->showLog(4,"Running ProductInvoice->getSQLStr_AllInvoice: $sql"); 
 return $sql;
  } // end of member function getSQLStr_AllInvoice

 public function showInvoiceTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0, $token=""){
	$this->log->showLog(3,"Showing Invoice Table");
	$sql=$this->getSQLStr_AllInvoice($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    	<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Invoice No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Customer</th>
				<th style="text-align:center;">Total Amount (RM)</th>
				<th style="text-align:center;">Total Balance (RM)</th>
				<th style="text-align:center;">Total Item</th>
				<th style="text-align:center;">Complete</th>
				<th style="text-align:center;">Edit</th>
				<th style="text-align:center;">View</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$invoice_id=$row['invoice_id'];
		$invoice_no=$row['invoice_no'];
		$customer_id=$row['customer_id'];
		$customer_name=$row['customer_name'];
		$invoice_date=$row['invoice_date'];
		$invoice_terms=$row['invoice_terms'];
		$iscomplete=$row['iscomplete'];
		$invoice_attn=$row['invoice_attn'];
		$invoice_preparedby=$row['invoice_preparedby'];
		$invoice_attntel=$row['invoice_attntel'];
		$invoice_attntelhp=$row['invoice_attntelhp'];
		$invoice_attnfax=$row['invoice_attnfax'];
		$invoice_remarks=$row['invoice_remarks'];
		$invoice_totalamount=$row['invoice_totalamount'];
		$total_item=$row['total_item'];
		$invoice_balance=$row['invoice_balance'];
		$terms_id=$row['terms_id'];
		
		
		if($iscomplete==1){
			$iscomplete = "Yes";
			
			//if($this->isAdmin){
			//$editimage = "<u><a style = 'cursor:pointer; font-size : 11px' onclick = 'return enableInvoice($invoice_id); '>Enable</a></u>";
			//}
		$editimage = "<input type='button' value='Enable' onclick = 'return enableInvoice($invoice_id); '>";	
		}else{
			$iscomplete = "No";
			$editimage = "<input type='image' src='images/edit.gif' name='imgSubmit' title='Edit this invoice'>
							<input type='hidden' value='$invoice_id' name='invoice_id'>
							<input type='hidden' name='action' value='edit'>";
		}

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
			
		$zoomctrl_tbl = "<image style = 'cursor:pointer' src='images/zoom.png' title='View This Customer'	onclick = 'document.frmZoom.customer_id.value = $customer_id ;document.frmZoom.submit();' >";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$invoice_no</td>
			<td class="$rowtype" style="text-align:center;">$invoice_date</td>
			<td class="$rowtype" style="text-align:center;">$customer_name&nbsp;$zoomctrl_tbl</td>
			<td class="$rowtype" style="text-align:center;">$invoice_totalamount</td>
			<td class="$rowtype" style="text-align:center;">$invoice_balance</td>
			<td class="$rowtype" style="text-align:center;">$total_item</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="invoice.php" method="POST">
				$editimage
				</form>
			</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="viewinvoice.php" method="POST" target = "_BLANK">
				<input type="image" src="images/list.gif" name="submit" title='View this invoice'>
				<input type="hidden" value="$invoice_id" name="invoice_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	
echo  "<form name='frmZoom' action='customer.php' method='POST' target='_BLANK'>
		<input type='hidden' name='action' value='edit'>
		<input type='hidden' name='customer_id' value=''>
		</form>";
		
echo  "</tr>
		<form action='invoice.php' name='frmInvoice' method='POST'>
		<input type='hidden' value='' name='invoice_id'>
		<input type='hidden' name='action' value=''>
		<input type='hidden' name='token' value='$token'></form>	
	</tbody></table>";
 }

  
  
  // start serach table
  
  public function showSearchTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0, $orderctrl="", $fldSort ="", $token=""){
	$this->log->showLog(3,"Showing Invoice Table");
	
	$sql=$this->getSQLStr_AllInvoice($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	
	if($orderctrl=='asc'){
	
	if($fldSort=='invoice_no')
	$sortimage1 = 'images/sortdown.gif';
	else
	$sortimage1 = 'images/sortup.gif';
	if($fldSort=='customer_id')
	$sortimage2 = 'images/sortdown.gif';
	else
	$sortimage2 = 'images/sortup.gif';
	if($fldSort=='invoice_totalamount')
	$sortimage3 = 'images/sortdown.gif';
	else
	$sortimage3 = 'images/sortup.gif';
	if($fldSort=='iscomplete')
	$sortimage4 = 'images/sortdown.gif';
	else
	$sortimage4 = 'images/sortup.gif';
	if($fldSort=='invoice_date')
	$sortimage5 = 'images/sortdown.gif';
	else
	$sortimage5 = 'images/sortup.gif';
	if($fldSort=='invoice_balance')
	$sortimage6 = 'images/sortdown.gif';
	else
	$sortimage6 = 'images/sortup.gif';
	if($fldSort=='total_item')
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
				<th style="text-align:center;">Invoice No <br><input type='image' src="$sortimage1" name='submit'  title='Sort this record' onclick = " headerSort('invoice_no');"></th>
				<th style="text-align:center;">Date<br><input type='image' src="$sortimage5" name='submit'  title='Sort this record' onclick = " headerSort('invoice_date');"></th>
				<th style="text-align:center;">Customer <br><input type='image' src="$sortimage2" name='submit'  title='Sort this record' onclick = " headerSort('customer_id');"></th>
				<th style="text-align:center;">Total Amount (RM) <br><input type='image' src="$sortimage3" name='submit'  title='Sort this record' onclick = " headerSort('invoice_totalamount');"></th>
				<th style="text-align:center;">Total Balance (RM) <br><input type='image' src="$sortimage6" name='submit'  title='Sort this record' onclick = " headerSort('invoice_balance');"></th>
				<th style="text-align:center;">Total Item <br><input type='image' src="$sortimage7" name='submit'  title='Sort this record' onclick = " headerSort('total_item');"></th>
				<th style="text-align:center;">Complete <br><input type='image' src="$sortimage4" name='submit'  title='Sort this record' onclick = " headerSort('iscomplete');"></th>
				<th style="text-align:center;">Edit</th>
				<th style="text-align:center;">View</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$invoice_id=$row['invoice_id'];
		$invoice_no=$row['invoice_no'];
		$customer_id=$row['customer_id'];
		$customer_name=$row['customer_name'];
		$invoice_date=$row['invoice_date'];
		$invoice_terms=$row['invoice_terms'];
		$iscomplete=$row['iscomplete'];
		$invoice_attn=$row['invoice_attn'];
		$invoice_preparedby=$row['invoice_preparedby'];
		$invoice_attntel=$row['invoice_attntel'];
		$invoice_attntelhp=$row['invoice_attntelhp'];
		$invoice_attnfax=$row['invoice_attnfax'];
		$invoice_remarks=$row['invoice_remarks'];
		$invoice_totalamount=$row['invoice_totalamount'];
		$invoice_balance=$row['invoice_balance'];
		$total_item=$row['total_item'];
		$terms_id=$row['terms_id'];
		
		$editimage = "";
		
		if($iscomplete==1){
			$iscomplete = "Yes";
			
			//if($this->isAdmin){
			//$editimage = "<u><a style = 'cursor:pointer; font-size : 11px' onclick = 'return enableInvoice($invoice_id); '>Enable</a></u>";
			//}
				$editimage = "<input type='button' value='Enable' onclick = 'return enableInvoice($invoice_id); '>";			
		}else{
			$iscomplete = "No";
			$editimage = "<input type='image' src='images/edit.gif' name='imgSubmit' title='Edit this invoice'>
							<input type='hidden' value='$invoice_id' name='invoice_id'>
							<input type='hidden' name='action' value='edit'>";
		}

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		$zoomctrl_tbl = "<image style = 'cursor:pointer' src='images/zoom.png' title='View This Customer'	onclick = 'document.frmZoom.customer_id.value = $customer_id ;document.frmZoom.submit();' >";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$invoice_no</td>
			<td class="$rowtype" style="text-align:center;">$invoice_date</td>
			<td class="$rowtype" style="text-align:center;">$customer_name&nbsp;$zoomctrl_tbl</td>
			<td class="$rowtype" style="text-align:center;">$invoice_totalamount</td>
			<td class="$rowtype" style="text-align:center;">$invoice_balance</td>
			<td class="$rowtype" style="text-align:center;">$total_item</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="invoice.php" method="POST">
				$editimage
				</form>
			</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="viewinvoice.php" method="POST" target = "_BLANK">
				<input type="image" src="images/list.gif" name="submit" title='View this invoice'>
				<input type="hidden" value="$invoice_id" name="invoice_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	
		
	$printctrl="<tr><td colspan='11' align=right><form action='viewinvoice_report.php' method='POST' target='_blank' name='frmPdf'>
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
			<form action='invoice.php' name='frmInvoice' method='POST'>
			<input type='hidden' value='' name='invoice_id'>
			<input type='hidden' name='action' value=''>
			<input type='hidden' name='token' value='$token'></form>
				
	</tbody></table>";
	
	
 }



   
   
 public function searchAToZ(){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search invoice easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(b.customer_name,1)) as shortname 
					FROM $this->tableinvoice a, $this->tablecustomer b
					where a.customer_id = b.customer_id order by a.customer_id";
	$this->log->showLog(4,"With SQL:$sqlfilter");
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	$firstname="";
	echo "<b>Invoice Grouping By Customer Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if invoice never do filter yet, if will choose 1st invoice listing
		
		echo "<A style='font-size:12;' href='invoice.php?filterstring=$shortname'>  $shortname  </A> ";
	}
	
	$this->log->showLog(3,"Complete generate list of short cut");
		echo <<<EOF
<BR>
<A href='invoice.php?action=new' style='color: GRAY'> <img src="images/addnew.jpg"></A>
<A href='invoice.php?action=showSearchForm' style='color: gray'><img src="images/search.jpg"></A>

EOF;
return $filterstring;
  }
  
  
  
  


  public function getLatestInvoiceID() {
	$sql="SELECT MAX(invoice_id) as invoice_id from $this->tableinvoice;";
	$this->log->showLog(3,'Checking latest created invoice_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created invoice_id:' . $row['invoice_id']);
		return $row['invoice_id'];
	}
	else
	return -1;
	
  } // end
  
  
 

	public function getNewInvoice() {
	
	$sql="SELECT CAST(invoice_no AS SIGNED) as invoice_no, invoice_no as ori_data from $this->tableinvoice WHERE CAST(invoice_no AS SIGNED) > 0  order by CAST(invoice_no AS SIGNED) DESC limit 1 ";

	$this->log->showLog(3,'Checking latest created invoice_no');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created invoice_no:' . $row['invoice_no']);
		$invoice_no=$row['invoice_no']+1;

		if(strlen($row['invoice_no']) != strlen($row['ori_data']))
		return str_replace($row['invoice_no'], '', $row['ori_data'])."".$invoice_no;
		else
		return $invoice_no;
		
	}
	else
	return 1;
	
  }
  
  

  public function getSelectInvoice($id) {
	
	$sql="SELECT a.invoice_id,a.invoice_no,b.customer_name from $this->tableinvoice a,$this->tablecustomer b 
			where a.customer_id = b.customer_id
			order by invoice_no";
	$selectctl="<SELECT name='invoice_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$invoice_id=$row['invoice_id'];
		$invoice_no=$row['invoice_no'];
		$customer_name=$row['customer_name'];
	
		if($id==$invoice_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$invoice_id' $selected>$invoice_no / $customer_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end
  
  public function getSelectInvoiceStatement($id) {
	
	$sql="SELECT invoice_id,invoice_no,invoice_date from $this->tableinvoice where 1 " .
		" order by invoice_no";
	$selectctl="<SELECT name='invoice_id' >";
	
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
  
  
	public function getSelectItemArray($id,$line="") {
	
	$sql="SELECT item_id,item_desc,item_code from $this->tableitem where isactive=1 or item_id=$id or item_id = 0 " .
		" order by item_desc";
	
	$selectctl="<SELECT style = 'vertical-align : top;' name='item_id[]' onchange = 'return itemSelect($line,this.name,this)' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"></OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$item_id=$row['item_id'];
		$item_desc=$row['item_desc'];
		$item_code=$row['item_code'];
	
		if($id==$item_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
			
		if($item_code=="0")
			$item_id=0;
			
		$selectctl=$selectctl  . "<OPTION value='$item_id' $selected>$item_desc</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end



  public function allowDelete($id){
	$sql="SELECT count(invoice_id) as rowcount from $this->tablepaymentline where invoice_id=$id";
	
	$this->log->showLog(3,"Accessing ProductInvoice->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this invoice, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this invoice, record deletable");
		return true;
		}
	}


 public function showInvoiceHeader($invoice_id){
	if($this->fetchInvoice($invoice_id)){
		$this->log->showLog(4,"Showing invoice header successfully.");
	echo <<< EOF
	<table border='1' cellspacing='3'>
		<tbody>
			<tr>
				<th colspan="4">Invoice Info</th>
			</tr>
			<tr>
				<td class="head">Invoice No</td>
				<td class="odd">$this->invoice_no</td>
				<td class="head">Invoice Description</td>
				<td class="odd"><A href="invoice.php?action=edit&invoice_id=$invoice_id" 
						target="_blank">$this->invoice_desc</A></td>
			</tr>
		</tbody>
	</table>
EOF;
	}
	else{
		$this->log->showLog(1,"<b style='color:red;'>Showing invoice header failed.</b>");
	}

   }//showRegistrationHeader
   
   
  
  
 public function showSearchForm($wherestring="",$orderctrl=""){

   echo <<< EOF

	<FORM action="invoice.php" method="POST" name="frmActionSearch" id="frmActionSearch">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criteria</th>
	    </tr>
	    <tr>
	      <td class='head' width="20%">Invoice No</td>
	      <td class='even' width="40%"><input name='invoice_no' value='$this->invoice_no'> (%, AB%,%AB,%A%B%)</td>
	      <td class='head' width="15%">Customer</td>
	      <td class='even' width="25%">$this->customerctrl</td>
	    </tr>
	    <tr>
	      <td class='head'>Quick Search <br>(Invoice No)</td>
	      <td class='odd'>$this->invoicectrl</td>
	      <td class='head'>Is Complete</td>
	      <td class='odd'>
		<select name="iscomplete">
			<option value="-1">Null</option>
			<option value="1" >Y</option>
			<option value="0" >N</option>
		</select>
		</td>
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

  public function convertSearchString($invoice_id,$invoice_no,$iscomplete,$customer_id){
		$filterstring="";

		if($invoice_id > 0 ){
			$filterstring=$filterstring . " c.invoice_id=$invoice_id AND";
		}

		if($invoice_no!=""){
			$filterstring=$filterstring . " c.invoice_no LIKE '$invoice_no' AND";
		}

		if($customer_id!="0"){
			$filterstring=$filterstring . " c.customer_id LIKE '$customer_id' AND";
		}

		if ($iscomplete!="-1")
			$filterstring=$filterstring . " c.iscomplete =$iscomplete AND";

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
	
	public function getInvoiceDesc($invoice_id,$fld){
	
	$sql = "select $fld from $this->tableinvoice where invoice_id = $invoice_id limit 1 ";
	
		
	$query=$this->xoopsDB->query($sql);
	
	while($row=$this->xoopsDB->fetchArray($query)){
	return $row[$fld];
	}
	
	}


	public function getTermsDesc($terms_id,$fld){
	
	$sql = "select $fld from $this->tableterms where terms_id = $terms_id limit 1 ";
	
		
	$query=$this->xoopsDB->query($sql);
	
	while($row=$this->xoopsDB->fetchArray($query)){
	return $row[$fld];
	}
	
	}
  

} // end of ClassInvoice
?>



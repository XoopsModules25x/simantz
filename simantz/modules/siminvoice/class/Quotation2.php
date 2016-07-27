<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


class Quotation
{

public	$quotation_id;
public	$quotation_no;
public	$customer_id;
public	$quotation_date;
public	$quotation_terms;
public	$iscomplete;
public	$quotation_attn;
public	$quotation_preparedby;
public	$quotation_attntel;
public	$quotation_attntelhp;
public	$quotation_attnfax;
public	$quotation_remarks;
public	$terms_id;
public	$created;
public	$createdby;
public	$updated;
public	$updatedby;
public   $preparedby;

// quotation line

public	$quotationline_id;
public	$quotation_seq;
public	$quotation_desc;
public	$item_id;
public	$item_name;
public	$quotation_qty;
public	$quotation_unitprice;
public	$quotation_discount;
public	$quotation_amount;
public	$quotationlinedelete_id;
public	$iscustomprice;


//

public 	$isAdmin;
public	$quotationctrl;
public	$customerctrl;
public   $rowctrl;
public	$itemctrl;
public	$termsctrl;

public  $xoopsDB;
public  $tableprefix;
public  $tablequotation;
public  $tablequotationline;
public  $tablecategory;
public  $tableitem;
public  $tablecustomer;
public  $tableinvoice;
public  $tablepayment;
public  $tablepaymentline;
public  $tableinvoiceline;
public  $log;
public  $printPdf;



//constructor
   public function Quotation($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablequotation=$tableprefix."tblquotation";
	$this->tablequotationline=$tableprefix."tblquotationline";
	$this->tablecategory=$tableprefix."tblcategory";
	$this->tableitem=$tableprefix."tblitem";
	$this->tablecustomer=$tableprefix."tblcustomer";
	$this->tableinvoice=$tableprefix."tblinvoice";
	$this->tableinvoiceline=$tableprefix."tblinvoiceline";
	$this->tablepayment=$tableprefix."tblpayment";
	$this->tablepaymentline=$tableprefix."tblpaymentline";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int quotation_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $quotation_id, $token ,$row_item = "") {

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
	if($this->quotation_preparedby == ""){
	$this->quotation_preparedby = $this->preparedby;
	}	
	//
	

	//declare attn
	if($type=="attn"){	
	$this->quotation_attn = $this->getAttnDesc($this->customer_id,"customer_contactperson");
	$this->quotation_attntel = $this->getAttnDesc($this->customer_id,"customer_contactno");
	$this->quotation_attntelhp = $this->getAttnDesc($this->customer_id,"customer_contactnohp");
	$this->quotation_attnfax = $this->getAttnDesc($this->customer_id,"customer_contactfax");
	}
	//
	
		
	$this->created=0;
	
	if ($type=="new"){
		$header="New Quotation";
		$action="create";
	 	
		if($quotation_no==0){
			$this->quotation_no=$this->getNewQuotation();
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
	
		$header="Edit Quotation";
		
		if(($type=="row"&& $this->quotation_id=="")||($type=="attn"&& $this->quotation_id=="")||($type=="sortseq"&& $this->quotation_id=="")){//if create row
		$action="create";
		$header="New Quotation";
		}else
		$action="update";
		
		$savectrl=	"<input name='quotation_id' value='$this->quotation_id' type='hidden'>".
			 			"<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";


		if($action!="create"){
		//$action="create";
		$completectrl=	"<input name='completectrl' value='1' type='hidden'>".
							"<input name='quotation_id' value='$this->quotation_id' type='hidden'>".
			 				"<input style='height: 40px;' name='btnComplete' value='Complete' type='button' onclick ='completeRecord();' >";
		$printctrl="<form name='frmPrint' method='post' action='viewquotation.php' target='_BLANK'>
		<input type='hidden' name='quotation_id' value=$this->quotation_id >
		<input type='button' name='printdocument' style='height: 40px;' value='Print' onclick = 'return printSave();'></form>";
		
		$convertctrl=	"<input name='completectrl' value='1' type='hidden'>".
							"<input name='quotation_id' value='$this->quotation_id' type='hidden'>".
			 				"<input style='height: 40px;' name='btnConvert' value='Convert' type='button' onclick ='convertRecord();' >";

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
	
		
		
		if($this->allowDelete($this->quotation_id))
		$deletectrl="<FORM action='quotation.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this quotation?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->quotation_id' name='quotation_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		
		// show row quotation line
			$c = 0;
			$i = 0;
			$j = 0;
			$line_i = 0;
			$tot_amount = 0;
		
			if($type!="row"){
			
			/*
			$sql = "SELECT il.quotationline_id, il.quotation_seq, il.quotation_id, il.quotation_desc, il.item_id, il.item_name, il.quotation_qty,
					il.quotation_unitprice, il.quotation_amount, il.quotation_discount, il.iscustomprice,p.item_uom 
					from $this->tablequotationline il 
					inner join $this->tableitem p on il.item_id=p.item_id where quotation_id = $this->quotation_id order by quotation_seq asc ";
					*/
			$sql = "SELECT il.quotationline_id, il.quotation_seq, il.quotation_id, il.quotation_desc, il.item_id, il.item_name, il.quotation_qty,
					il.quotation_unitprice, il.quotation_amount, il.quotation_discount, il.iscustomprice,
					(select item_uom from $this->tableitem where item_id =  il.item_id) as item_uom 
					from $this->tablequotationline il where quotation_id = $this->quotation_id order by quotation_seq asc ";
					
			$this->log->showLog(4,"With SQL: $sql");
		
			$query=$this->xoopsDB->query($sql);
	
			while($row=$this->xoopsDB->fetchArray($query)){
				$i++;
				
				if($rowtype=="odd")
					$rowtype="even";
				else
					$rowtype="odd";
   	
				$line_id = $row['quotationline_id'];
				$seq = $row['quotation_seq'];
				$desc = $row['quotation_desc'];
				$item_id = $row['item_id'];
				$item_name = $row['item_name'];
				$qty = $row['quotation_qty'];
				$unitprice = $row['quotation_unitprice'];
				$discount = $row['quotation_discount'];
				$amount = $row['quotation_amount'];
				$tot_amount += $row['quotation_amount'];
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
					
				// disabled unitprice				
				//if($item_id==0)
				//	$styledisabled = " ";
				//else
				//	$styledisabled = " readonly ";
				
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
   			$itemline .= "<tr>
   						<input type='hidden' name='quotationline_id[]' value=$line_id>
							<td class=$rowtype>$i</td>
							<td class=$rowtype align='center'><input type='input' name='quotation_seq[]' max=5 size=5 value =$seq></td>
							<td class=$rowtype>											
							Item Name: $itemctrl &nbsp;<br>
							<input $styledisplay type='input' name='item_name[]' value='$item_name' size='50' maxlength='50'>
							<a  id='idShow$i' $styledescshow  onclick = 'return showDescription(this.id,1,$i)' ><br>
							<u>Show Description</u></a>
							<a  id='idHide$i' $styledeschide  onclick = 'return showDescription(this.id,2,$i)'><br>
							<u>Hide Description</u><a><br>	
							<div $styledesc id='idDesc$i'>
							<textarea  name='quotation_desc[]' cols='50' maxlength='200' rows='3'>$desc</textarea></div>
							</td>
							<td class=$rowtype align='center'><input style = 'text-align:center;' type='input' name='quotation_qty[]' max=5 size=5 value='$qty'  onBlur = 'return calculateAmount1($i,this.name)'><br>$item_uom</td>
							<td class=$rowtype align=center><input $styledisabled style = 'text-align:right;' type='input' name='quotation_unitprice[]' max=10 size=10 value='$unitprice' onchange = 'unitPrice($c);'  onBlur = 'return calculateAmount2($i,this.name)'><br>
							<input id='customPrice$c' type='checkbox' name='iscustomprice[$c]' $iscustomprice >Force This Price</td>
							<td class=$rowtype align='center'><input style = 'text-align:center;' type='input' name='quotation_discount[]' max=5 size=5 value='$discount'  onBlur = 'return calculateAmount3($i,this.name)'></td>
							<td class=$rowtype align=center><input readonly style = 'background-color : silver;color:black;text-align:right;' type='input' name='quotation_amount[]' maxlength=12 size=11 value='$amount'></td>
							<td class=$rowtype align=center>
							<input style='cursor: pointer;color: black;background-color : white;' type='button' value='Delete' onclick = 'return deleteQuotationLine($line_id,$this->quotation_id)' ></td>
   					</tr>";
			
			$c++;
			
			}
			
			
			}else{
		
		$ij = 0;
		foreach($this->quotationline_id as $id ){
   		$line_i++;
   		$ij++;
		
		$line_id = $this->quotationline_id[$i];
		$seq = $this->quotation_seq[$i];
		$desc = $this->quotation_desc[$i];
		$item_id = $this->item_id[$i];
		$item_name = $this->item_name[$i];
		$qty = $this->quotation_qty[$i];
		$unitprice = $this->quotation_unitprice[$i];
		$discount = $this->quotation_discount[$i];
		$amount = $this->quotation_amount[$i];
		$iscustomprice = $this->iscustomprice[$i];
		
		
		// display item descs				
				if($item_id==0)
					$styledisplay = " ";
				else
					$styledisplay = " style = 'display:none' ";
					
  		if($iscustomprice=="on")
				$iscustomprice='checked';
		else
				$iscustomprice="";
					
					
			if($rowtype=="odd")
				$rowtype="even";
			else
				$rowtype="odd";
		//echo $i;
  			
  				$styledesc = "";
				$styledescshow = "style='font-weight : bold; cursor : pointer;'";
				$styledeschide = "style='font-weight : bold; cursor : pointer;'";
			
				if($desc==""){
				$styledesc = "style = 'display:none'";
				$styledeschide = "style='font-weight : bold; cursor : pointer; display :none;'";
				}else{
				$styledescshow = "style='font-weight : bold; cursor : pointer; display :none;'";
				}
				
   		$this->itemctrl=$this->getSelectItemArray($item_id,$ij);
   		$itemline .= "<tr>
   						<input type='hidden' name='quotationline_id[]' value=$line_i>
							<td class=$rowtype>$line_i</td>
							<td class=$rowtype align='center'><input  type='input' name='quotation_seq[]' max=5 size=5 value =$seq></td>
							<td class=$rowtype>						
							Item Name:&nbsp;$this->itemctrl &nbsp;
							<input $styledisplay type='input' name='item_name[]' value='$item_name' size='50' maxlength='50' >
							<br>
							<a  id='idShow$i'  $styledescshow onclick = 'return showDescription(this.id,1,$i)' ><u>Show Description</u></a>
							<a  id='idHide$i'  $styledeschide onclick = 'return showDescription(this.id,2,$i)'><u>Hide Description</u></a><br>
							<div $styledesc id='idDesc$i'>Description:<br>
							<textarea   name='quotation_desc[]' cols='50' maxlength='200' rows='3'>$desc</textarea>
							</div>
							</td>
							<td class=$rowtype align='center'><input style = 'text-align:center;' type='input' name='quotation_qty[]' max=5 size=5 value=$qty  onBlur = 'return calculateAmount1($i,this.name)'></td>
							<td class=$rowtype align=center><input style = 'text-align:right;' type='input' name='quotation_unitprice[]' max=10 size=9 value=$unitprice onchange = 'unitPrice($c);'  onBlur = 'return calculateAmount2($i,this.name)'><br>
							<input id='customPrice$c' type='checkbox' name='iscustomprice[$c]' $iscustomprice>Force This Price</td>
							<td class=$rowtype align='center'><input style = 'text-align:center;' type='input' name='quotation_discount[]' max=5 size=5 value=$discount  onBlur = 'return calculateAmount3($i,this.name)'></td>
							<td class=$rowtype align=center><input readonly style = 'background-color : silver;color:black;text-align:right;' type='input' name='quotation_amount[]' max=12 size=11 value=$amount></td>
							<td class=$rowtype align=center></td>
   					</tr>";
					
					$i++;
					$c++;
   					
		}
		
		while($j < $row_item){
		$i++;
		$j++;
		$ij++;
   		$seq = $i."0";
		
   	
			if($rowtype=="odd")
				$rowtype="even";
			else
				$rowtype="odd";
		//echo $i;
  
   		$this->itemctrl=$this->getSelectItemArray(0,$ij);
   		$itemline .= "<tr>
   						<input type='hidden' name='quotationline_id[]' value=$i>
							<td class=$rowtype>$i</td>
							<td class=$rowtype align='center'><input  type='input' name='quotation_seq[]' max=5 size=5 value =$seq></td>
							<td class=$rowtype>
							Item Name:&nbsp;$this->itemctrl &nbsp;<br>
							<input type='input' name='item_name[]' value='' size='50' maxlength='50' >
							<br>
							<a  id='idShow$i' style='font-weight : bold; cursor : pointer' onclick = 'return showDescription(this.id,1,$i)' >
							<u>Show Description</u></a>
							<a  id='idHide$i' style='font-weight : bold; cursor : pointer; display:none;' onclick = 'return showDescription(this.id,2,$i)'><u><br>
							Hide Description</u></a><br>
							<div style = 'display:none' id='idDesc$i'>Description:<br>
							<textarea   name='quotation_desc[]' cols='50' maxlength='200' rows='3'></textarea>
							</div>
							</td>
							<td class=$rowtype align='center'><input style = 'text-align:center;' type='input' name='quotation_qty[]' max=5 size=5 value=0  onBlur = 'return calculateAmount1($i,this.name)'></td>
							<td class=$rowtype align=center><input style = 'text-align:right;' type='input' name='quotation_unitprice[]' max=10 size=10 value=0 onchange = 'unitPrice($c);'  onBlur = 'return calculateAmount2($i,this.name)'><br>
							<input id='customPrice$c' type='checkbox' name='iscustomprice[$c]' >Force This Price</td></td>
							<td class=$rowtype align='center'><input style = 'text-align:center;' type='input' name='quotation_discount[]' max=5 size=5 value=0  onBlur = 'return calculateAmount3($i,this.name)'></td>
							<td class=$rowtype align=center><input readonly style = 'background-color : silver;color:black;text-align:right;' type='input' name='quotation_amount[]' max=10 size=10 value=0></td>
							<td class=$rowtype align=center></td>
   					</tr>";
					
					$c++;
					
   					
		}
		
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
		
	
	}

    echo <<< EOF


<table style="width:140px;"><tbody><td><form onsubmit="return validateQuotation()" method="post"
 action="quotation.php" name="frmQuotation"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        	<td class="head">Customer *</td>
        	<td class="odd">$this->customerctrl</td>
  
        	<td class="head">Quotation No *</td>
        	<td class="odd" ><input name='quotation_no' value="$this->quotation_no" maxlength='10' size='15'> </td>
 
     </tr>      
      <tr>
 
		   	 	<td class="head">Payment Date *</td>
        	<td class="odd" >
        		<input name='quotation_date' id='quotation_date' value="$this->quotation_date" maxlength='10' size='10'>
        		<input name='btnDate' value="Date" type="button" onclick="$this->datectrl">     	 
        	</td>
	<td class="head">Terms</td>
			<td  class="odd">$this->termsctrl</td>
		</tr>
		
		
		<tr>
			<td class="head">Attn</td>
			<td  class="odd"><input name='quotation_attn' value="$this->quotation_attn" maxlength='35' size='35'></td>
			<td class="head">Attn Tel</td>
			<td  class="odd"><input name='quotation_attntel' value="$this->quotation_attntel" maxlength='20' size='20'></td>			
		</tr>
		
		<tr>
			<td class="head">Attn Tel (HP)</td>
			<td  class="odd"><input name='quotation_attntelhp' value="$this->quotation_attntelhp" maxlength='20' size='20'></td>
			<td class="head">Attn Fax</td>
			<td  class="odd"><input name='quotation_attnfax' value="$this->quotation_attnfax" maxlength='20' size='20'></td>
		</tr>
		<tr>
			<td class="head">Prepared By</td>
			<td  class="odd"><input name='quotation_preparedby' value="$this->quotation_preparedby" maxlength='35' size='35'></td>
		<td class="head"></td>
			<td  class="odd"></td>
	
			</tr>
		<tr>
			<td class="head">Remarks</td>
			<td  class="odd" colspan='3'>
				<textarea  name="quotation_remarks" cols='70' maxlength='200' rows='5'>$this->quotation_remarks</textarea></td>

		
		</tr>
	
	

    </tbody>
  </table>
  <p>
EOF;
//if($type=="edit")
echo "<table style='width:300px;' align=center border=1>
  <tr height=30 valign=bottom>
  	<td class='head'  width='150px' align=center>No. Of Item :</td>
  	<td class='odd' width='100px'><input type='input' name='fldRow' value='$row_item' max=10 size=10></td>
  	<td class='odd' width='50px'><input style='height: 35px;' type='button' name='btnCreate' value='Create' onclick = ' return createRow();'></td>
  </tr>
  </table>";


echo <<< EOF

  <p>
  <table border='1'>
  		<tbody>
    	<tr astyle="display:none">
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Seq</th>
				<th style="text-align:center;">Item</th>
				<th style="text-align:center;">Qty</th>
				<th style="text-align:center;">Unit Price (RM)</th>
				<th style="text-align:center;">Discount (%)</th>
				<th style="text-align:center;">Amount (RM)</th>
				<th style="text-align:center;">&nbsp;</th>
   	</tr>
   	
   	$norecord
   	$itemline
   	$totalcolumn
   	
    </tbody>
  </table>
  
  <p>
	<table style="width:150px;"><tbody><td>$savectrl&nbsp;</td><td>$completectrl&nbsp;</td>
	<td>$convertctrl&nbsp;</td>	
	<td>
	<input name="action" value="$action" type="hidden">
	<input name="quotationlinedelete_id" value="$this->quotationlinedelete_id" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	<input name="printPdf" value=0 type="hidden"></td>
	</form><td>$printctrl</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$deletectrl</td></tbody></table>
  <br>

$recordctrl

EOF;

	if($this->printPdf==1)
	echo "<script language=javascript>document.forms['frmPrint'].submit();</script>";

  } // end of member function getInputForm


	
	
  public function completeQuotation( ) {

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	
 	$sql=$sql="UPDATE $this->tablequotation SET
	quotation_no='$this->quotation_no',
	customer_id=$this->customer_id,
	quotation_terms='$this->quotation_terms',
	iscomplete='1',
	quotation_attn='$this->quotation_attn',
	quotation_preparedby='$this->quotation_preparedby',
	quotation_date='$this->quotation_date',
	quotation_attntel='$this->quotation_attntel',
	quotation_attntelhp='$this->quotation_attntelhp',
	quotation_attnfax='$this->quotation_attnfax',
	quotation_remarks='$this->quotation_remarks',
	terms_id=$this->terms_id,
	updated='$timestamp',
	updatedby=$this->updatedby
	WHERE quotation_id=$this->quotation_id";
	
	$this->log->showLog(3, "Complete quotation_id: $this->quotation_id, $this->quotation_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Complete quotation failed");
		return false;
	}
	else{
		$this->updateQuotationLine("complete");
		$this->log->showLog(3, "Complete quotation successfully.");
		return true;
	}
  } // end of member function completeQuotation
  
	
  public function enableQuotation( ) {

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	
 	$sql="UPDATE $this->tablequotation SET
	iscomplete=0,
	updated='$timestamp',
	updatedby=$this->updatedby
	WHERE quotation_id=$this->quotation_id";
	
	$this->log->showLog(3, "Enable quotation_id: $this->quotation_id, $this->quotation_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Enable quotation failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Enable quotation successfully.");
		return true;
	}
  } // end of member function enabledQuotation
  
  
  
	
  public function deleteQuotationLine( ) {

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	
 	$sql="delete from $this->tablequotationline WHERE quotation_id=$this->quotation_id and quotationline_id = $this->quotationlinedelete_id ";
	
	$this->log->showLog(3, "Enable quotation_id: $this->quotation_id, $this->quotation_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Delete quotation failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Delete quotation successfully.");
		return true;
	}
	
  } // end of member function deleteQuotationLine
  
  
 
  
 
  public function updateQuotation( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablequotation SET
	quotation_no='$this->quotation_no',
	customer_id=$this->customer_id,
	quotation_terms='$this->quotation_terms',
	quotation_attn='$this->quotation_attn',
	quotation_preparedby='$this->quotation_preparedby',
	quotation_attntel='$this->quotation_attntel',
	quotation_date='$this->quotation_date',
	quotation_attntelhp='$this->quotation_attntelhp',
	quotation_attnfax='$this->quotation_attnfax',
	quotation_remarks='$this->quotation_remarks',
	terms_id=$this->terms_id,
	updated='$timestamp',
	updatedby=$this->updatedby
	WHERE quotation_id=$this->quotation_id";
	
	$this->log->showLog(3, "Update quotation_id: $this->quotation_id, $this->quotation_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update quotation failed");
		return false;
	}
	else{
		$this->updateQuotationLine( );
		$this->log->showLog(3, "Update quotation successfully.");
		return true;
	}
  } // end of member function updateQuotation

	
  public function insertQuotation( ) {
  
   $timestamp= date("y/m/d H:i:s", time()) ;   
   
   if($this->payment_date=="")
   $this->quotation_date = $timestamp;
   
	$this->log->showLog(3,"Inserting new quotation $this->quotation_no");
 	$sql="INSERT INTO $this->tablequotation 
 			(quotation_no,customer_id,quotation_date,quotation_terms,iscomplete,quotation_attn,quotation_preparedby,quotation_attntel,quotation_attntelhp,quotation_attnfax,quotation_remarks,terms_id,createdby,created,updatedby,updated) 
 			values 	('$this->quotation_no',
 						$this->customer_id,
 						'$this->quotation_date',
 						'$this->quotation_terms',
 						$this->iscomplete,
						'$this->quotation_attn',
						'$this->quotation_preparedby',
						'$this->quotation_attntel',
						'$this->quotation_attntelhp',
						'$this->quotation_attnfax',
						'$this->quotation_remarks',
						$this->terms_id,
						 $this->createdby,
						'$timestamp',
						 $this->updatedby,
						'$timestamp')";
	$this->log->showLog(4,"Before insert quotation SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert quotation code $quotation_desc");
		return false;
	}
	else{
		$this->insertQuotationLine( );
		$this->log->showLog(3,"Inserting new quotation $quotation_desc successfully"); 
		return true;
	}	
	
	
  } // end of member function insertQuotation
  
  
  public function insertQuotationLine($inv_id="",$others="") {
  
	$i = 0;
	$totamount = 0;
	foreach($this->quotationline_id as $id ){
	
		
	$line_id = $this->quotationline_id[$i];
	$seq = $this->quotation_seq[$i];
	$desc = $this->quotation_desc[$i];
	$item_id = $this->item_id[$i];
	$item_name = $this->item_name[$i];
	$qty = $this->quotation_qty[$i];
	$unitprice = $this->quotation_unitprice[$i];
	$discount = $this->quotation_discount[$i];
	$amount = $this->quotation_amount[$i];

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
	$latest_id=$this->getLatestQuotationID();
	else
	$latest_id=$this->quotation_id;
	
	
	//get unit price 
	//if($item_id != 0)
	
	if($item_id != 0)
		$unitprice = $this->getUnitPrice($item_id);
	
	//echo $iscustomprice."".$i;
	if($iscustomprice=="on")
	$unitprice = $this->quotation_unitprice[$i];
	
	$amount = $qty * $unitprice - ($discount/100)*($qty * $unitprice);	
	
	$totamount += $amount;
	
	//get item name
	if($item_id != 0)
	$item_name = $this->getItemDesc($item_id,'item_desc');
	
	$sql="INSERT INTO $this->tablequotationline 
 			(quotation_seq,quotation_id,quotation_desc,item_id,item_name, quotation_qty,quotation_unitprice,quotation_discount,quotation_amount,iscustomprice ) 
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
						
	$this->log->showLog(4,"Before insert quotation SQL I=$i, customprice_id: ".$this->iscustomprice[$i].":$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert quotation line  $line_id");
		return false;
	}
	
	$i++;
	}
	
	if($latest_id!=""){
	
		$sql = " update $this->tablequotation SET quotation_totalamount = '$totamount' WHERE quotation_id = '$latest_id' ";
	
		$rs=$this->xoopsDB->query($sql);
	
		if (!rs){
			$this->log->showLog(1,"Failed to update quotation $latest_id");
			return false;
		}
	}
	  
  
  } // end of insert item line
  
  
  public function updateQuotationLine($others="") {
 	
 	/*
	$i=0;
	foreach($this->quotationline_id as $id ){
	
	$line_id = $this->quotationline_id[$i];
	$seq = $this->quotation_seq[$i];
	$desc = $this->quotation_desc[$i];
	$item_id = $this->item_id[$i];
	$qty = $this->quotation_qty[$i];
	$unitprice = $this->quotation_unitprice[$i];
	$amount = $this->quotation_amount[$i];
	
	
	$sql = " UPDATE $this->tablequotationline SET
	 			where quotation_id = $this->quotation_id ";

	}
	
	*/
	$sql = " delete from $this->tablequotationline where quotation_id = $this->quotation_id ";
 	
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update quotation failed");
		return false;
	}
	else{
		$this->	insertQuotationLine($this->quotation_id,$others);
		$this->log->showLog(3, "Update quotation successfully.");
		return true;
	}
	
	
  }
  



  public function fetchQuotation( $quotation_id) {
    
    //echo $quotation_id;
	$this->log->showLog(3,"Fetching quotation detail into class Quotation.php.<br>");
		
	$sql="SELECT quotation_id,quotation_no,customer_id,quotation_date,quotation_terms,iscomplete,quotation_attn,quotation_preparedby,quotation_attntel,quotation_attntelhp,quotation_attnfax,quotation_remarks,terms_id,created,createdby,updated,updatedby 
			from $this->tablequotation 
			where quotation_id=$quotation_id";
	
	$this->log->showLog(4,"ProductQuotation->fetchQuotation, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$this->quotation_no=$row['quotation_no'];
	$this->customer_id=$row['customer_id'];
	$this->quotation_date=$row['quotation_date'];
	$this->quotation_terms=$row['quotation_terms'];
	$this->iscomplete=$row['iscomplete'];
	$this->quotation_attn=$row['quotation_attn'];
	$this->quotation_preparedby=$row['quotation_preparedby'];
	$this->quotation_attntel=$row['quotation_attntel'];
	$this->quotation_attntelhp=$row['quotation_attntelhp'];
	$this->quotation_attnfax=$row['quotation_attnfax'];
	$this->quotation_remarks=$row['quotation_remarks'];
	$this->terms_id=$row['terms_id'];
	
   $this->log->showLog(4,"Quotation->fetchQuotation,database fetch into class successfully");	
	$this->log->showLog(4,"quotation_no:$this->quotation_no");
	$this->log->showLog(4,"iscomplete:$this->iscomplete");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Quotation->fetchQuotation,failed to fetch data into databases.");	
	}
  } // end of member function fetchQuotation

  public function deleteQuotation( $quotation_id ) {
    	$this->log->showLog(2,"Warning: Performing delete quotation id : $quotation_id !");
	$sql="DELETE FROM $this->tablequotation where quotation_id=$quotation_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: quotation ($quotation_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"quotation ($quotation_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteQuotation

  
  public function getSQLStr_AllQuotation( $wherestring,  $orderbystring,  $startlimitno,$recordcount ) {

/*
    $sql="SELECT c.quotation_id,c.quotation_no,c.quotation_desc,c.street1,c.street2,".
		"c.postcode,c.city,c.state1,c.country,".
		"c.contactperson,c.contactperson_no,c.tel1,c.tel2,c.fax,c.description,".
		"c.created,c.createdby,c.updated, c.updatedby, c.iscomplete, c.isdefault,c.currency_id, ".
		"cr.currency_symbol FROM $this->tablequotation c " .
		"left join $this->tablecurrency cr on c.currency_id = cr.currency_id ".
	" $wherestring $orderbystring LIMIT $startlimitno,$recordcount";
	*/
	
	$sql = "SELECT c.quotation_id,c.quotation_no,c.customer_id,a.customer_name,c.quotation_date,c.quotation_terms,c.iscomplete,c.quotation_attn,c.quotation_preparedby,c.quotation_attntel,c.quotation_attntelhp,c.quotation_attnfax,c.quotation_remarks,c.terms_id,c.created,c.createdby,c.updated,c.updatedby
				FROM $this->tablequotation c ,$this->tablecustomer a
				$wherestring $orderbystring LIMIT $startlimitno,$recordcount ";
				
  $this->log->showLog(4,"Running ProductQuotation->getSQLStr_AllQuotation: $sql"); 
 return $sql;
  } // end of member function getSQLStr_AllQuotation

 public function showQuotationTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0, $token=""){
	$this->log->showLog(3,"Showing Quotation Table");
	$sql=$this->getSQLStr_AllQuotation($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    	<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Quotation No</th>
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
		$quotation_id=$row['quotation_id'];
		$quotation_no=$row['quotation_no'];
		$customer_id=$row['customer_id'];
		$customer_name=$row['customer_name'];
		$quotation_date=$row['quotation_date'];
		$quotation_terms=$row['quotation_terms'];
		$iscomplete=$row['iscomplete'];
		$quotation_attn=$row['quotation_attn'];
		$quotation_preparedby=$row['quotation_preparedby'];
		$quotation_attntel=$row['quotation_attntel'];
		$quotation_attntelhp=$row['quotation_attntelhp'];
		$quotation_attnfax=$row['quotation_attnfax'];
		$quotation_remarks=$row['quotation_remarks'];
		$terms_id=$row['terms_id'];
		
		
		if($iscomplete==1){
			$iscomplete = "Yes";
			
			//if($this->isAdmin){
			$editimage = "<u><a style = 'cursor:pointer; font-size : 11px' onclick = 'return enableQuotation($quotation_id); '>Enable</a></u>";
			//}
							
		}else{
			$iscomplete = "No";
			$editimage = "<input type='image' src='images/edit.gif' name='imgSubmit' title='Edit this quotation'>
							<input type='hidden' value='$quotation_id' name='quotation_id'>
							<input type='hidden' name='action' value='edit'>";
		}

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$quotation_no</td>
			<td class="$rowtype" style="text-align:center;">$customer_name</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="quotation.php" method="POST">
				$editimage
				</form>
			</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="viewquotation.php" method="POST">
				<input type="image" src="images/list.gif" name="submit" title='View this quotation'>
				<input type="hidden" value="$quotation_id" name="quotation_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr>
			<form action='quotation.php' name='frmQuotation' method='POST'>
			<input type='hidden' value='' name='quotation_id'>
			<input type='hidden' name='action' value=''>
			<input type='hidden' name='token' value='$token'></form>	
	</tbody></table>";
 }

  
  
  // start serach table
  
  public function showSearchTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0, $orderctrl="", $fldSort ="", $token=""){
	$this->log->showLog(3,"Showing Quotation Table");
	
	$sql=$this->getSQLStr_AllQuotation($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	
	if($orderctrl=='asc'){
	
	if($fldSort=='quotation_no')
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
	
	
	}else{
	$sortimage1 = 'images/sortup.gif';
	$sortimage2 = 'images/sortup.gif';
	$sortimage3 = 'images/sortup.gif';
	
	}


	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Quotation No <input type='image' src="$sortimage1" name='submit'  title='Sort this record' onclick = " headerSort('quotation_no');"></th>
				<th style="text-align:center;">Customer <input type='image' src="$sortimage2" name='submit'  title='Sort this record' onclick = " headerSort('customer_id');"></th>
				<th style="text-align:center;">Complete <input type='image' src="$sortimage3" name='submit'  title='Sort this record' onclick = " headerSort('iscomplete');"></th>
				<th style="text-align:center;">Edit</th>
				<th style="text-align:center;">View</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$quotation_id=$row['quotation_id'];
		$quotation_no=$row['quotation_no'];
		$customer_id=$row['customer_id'];
		$customer_name=$row['customer_name'];
		$quotation_date=$row['quotation_date'];
		$quotation_terms=$row['quotation_terms'];
		$iscomplete=$row['iscomplete'];
		$quotation_attn=$row['quotation_attn'];
		$quotation_preparedby=$row['quotation_preparedby'];
		$quotation_attntel=$row['quotation_attntel'];
		$quotation_attntelhp=$row['quotation_attntelhp'];
		$quotation_attnfax=$row['quotation_attnfax'];
		$quotation_remarks=$row['quotation_remarks'];
		$terms_id=$row['terms_id'];
		
		$editimage = "";
		
		if($iscomplete==1){
			$iscomplete = "Yes";
			
			//if($this->isAdmin){
			$editimage = "<u><a style = 'cursor:pointer; font-size : 11px' onclick = 'return enableQuotation($quotation_id); '>Enable</a></u>";
			//}
							
		}else{
			$iscomplete = "No";
			$editimage = "<input type='image' src='images/edit.gif' name='imgSubmit' title='Edit this quotation'>
							<input type='hidden' value='$quotation_id' name='quotation_id'>
							<input type='hidden' name='action' value='edit'>";
		}

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$quotation_no</td>
			<td class="$rowtype" style="text-align:center;">$customer_name</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="quotation.php" method="POST">
				$editimage
				</form>
			</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="viewquotation.php" method="POST">
				<input type="image" src="images/list.gif" name="submit" title='View this quotation'>
				<input type="hidden" value="$quotation_id" name="quotation_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	
		
	$printctrl="<tr style='display:none'><td colspan='11' align=right>
					<form action='viewquotation.php' method='POST' target='_blank' name='frmPdf'>
					<input type='submit' value='Print Report' name='btnPrint'>
					<input type='hidden' name='quotation_id' value='$quotation_id'>
					</form></td></tr>";
					
	echo $printctrl;

	echo  "</tr>
			<form action='quotation.php' name='frmQuotation' method='POST'>
			<input type='hidden' value='' name='quotation_id'>
			<input type='hidden' name='action' value=''>
			<input type='hidden' name='token' value='$token'></form>
				
	</tbody></table>";
	
	
 }



   
   
 public function searchAToZ(){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search quotation easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(b.customer_name,1)) as shortname 
					FROM $this->tablequotation a, $this->tablecustomer b
					where a.customer_id = b.customer_id order by a.customer_id";
	$this->log->showLog(4,"With SQL:$sqlfilter");
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	$firstname="";
	echo "<b>Quotation Grouping By Customer Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if quotation never do filter yet, if will choose 1st quotation listing
		
		echo "<A style='font-size:12;' href='quotation.php?filterstring=$shortname'>  $shortname  </A> ";
	}
	
	$this->log->showLog(3,"Complete generate list of short cut");
		echo <<<EOF
<BR>
<A href='quotation.php?action=new' style='color: GRAY'> <img src="images/addnew.jpg"></A>
<A href='quotation.php?action=showSearchForm' style='color: gray'><img src="images/search.jpg"</A>

EOF;
return $filterstring;
  }
  
  
  
  


  public function getLatestQuotationID() {
	$sql="SELECT MAX(quotation_id) as quotation_id from $this->tablequotation;";
	$this->log->showLog(3,'Checking latest created quotation_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created quotation_id:' . $row['quotation_id']);
		return $row['quotation_id'];
	}
	else
	return -1;
	
  } // end
  
  
  public function getNewQuotation() {
	$sql="SELECT MAX(CAST(quotation_no AS SIGNED)) as quotation_no from $this->tablequotation;";
	$this->log->showLog(3,'Checking latest created quotation_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created quotation_no:' . $row['quotation_no']);
		$quotation_no=$row['quotation_no']+1;
		return $quotation_no;
	}
	else
	return 0;
	
  } // end
  
  

  public function getSelectQuotation($id) {
	
	$sql="SELECT quotation_id,quotation_no from $this->tablequotation where 1 " .
		" order by quotation_no";
	$selectctl="<SELECT name='quotation_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$quotation_id=$row['quotation_id'];
		$quotation_no=$row['quotation_no'];
	
		if($id==$quotation_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$quotation_id' $selected>$quotation_no</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end
  
  public function getSelectQuotationStatement($id) {
	
	$sql="SELECT quotation_id,quotation_no,quotation_date from $this->tablequotation where 1 " .
		" order by quotation_no";
	$selectctl="<SELECT name='quotation_id' >";
	
	$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"></OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$quotation_id=$row['quotation_id'];
		$quotation_no=$row['quotation_no'];
		$quotation_date=$row['quotation_date'];
	
		if($id==$quotation_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$quotation_id' $selected>$quotation_no / $quotation_date</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end
  
  
	public function getSelectItemArray($id,$line="") {
	
	$sql="SELECT item_id,item_desc,item_code from $this->tableitem where isactive=1 or item_id=$id or item_id = 0 " .
		" order by item_desc";
	
	$selectctl="<SELECT style = 'vertical-align : top;' name='item_id[]' onchange = 'return itemSelect($line,this.name)' >";
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
/*	
	$sql="SELECT count(quotation_id) as rowcount from $this->tablepaymentline where quotation_id=$id";
	
	$this->log->showLog(3,"Accessing ProductQuotation->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this quotation, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this quotation, record deletable");
		return true;
		}
		*/
		
return true;
	}


 public function showQuotationHeader($quotation_id){
	if($this->fetchQuotation($quotation_id)){
		$this->log->showLog(4,"Showing quotation header successfully.");
	echo <<< EOF
	<table border='1' cellspacing='3'>
		<tbody>
			<tr>
				<th colspan="4">Quotation Info</th>
			</tr>
			<tr>
				<td class="head">Quotation No</td>
				<td class="odd">$this->quotation_no</td>
				<td class="head">Quotation Description</td>
				<td class="odd"><A href="quotation.php?action=edit&quotation_id=$quotation_id" 
						target="_blank">$this->quotation_desc</A></td>
			</tr>
		</tbody>
	</table>
EOF;
	}
	else{
		$this->log->showLog(1,"<b style='color:red;'>Showing quotation header failed.</b>");
	}

   }//showRegistrationHeader
   
   
  
  
 public function showSearchForm($wherestring="",$orderctrl=""){

   echo <<< EOF

	<FORM action="quotation.php" method="POST" name="frmActionSearch" id="frmActionSearch">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criteria</th>
	    </tr>
	    <tr>
	      <td class='head' width="20%">Quotation No</td>
	      <td class='even' width="40%"><input name='quotation_no' value='$this->quotation_no'> (%, AB%,%AB,%A%B%)</td>
	      <td class='head' width="15%">Customer</td>
	      <td class='even' width="25%">$this->customerctrl</td>
	    </tr>
	    <tr>
	      <td class='head'>Quick Search <br>(Quotation No)</td>
	      <td class='odd'>$this->quotationctrl</td>
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

  public function convertSearchString($quotation_id,$quotation_no,$iscomplete,$customer_id){
		$filterstring="";

		if($quotation_id > 0 ){
			$filterstring=$filterstring . " c.quotation_id=$quotation_id AND";
		}

		if($quotation_no!=""){
			$filterstring=$filterstring . " c.quotation_no LIKE '$quotation_no' AND";
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
	
	
	public function convertQuotation($quotation_id){

	$timestamp= date("y/m/d H:i:s", time()) ;
	$invoice_no=$this->getNewInvoice();
	
	$sql = "select * from $this->tablequotation where quotation_id = $quotation_id ";	
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		
		
		$customer_id = $row['customer_id'];
		$invoice_date = $row['quotation_date'];
		$invoice_terms = $row['quotation_terms'];
		$iscomplete = $row['iscomplete'];
		$invoice_attn = $row['quotation_attn'];
		$invoice_preparedby = $row['quotation_preparedby'];
		$invoice_attntel = $row['quotation_attntel'];
		$invoice_attntelhp = $row['quotation_attntelhp'];
		$invoice_fax = $row['quotation_fax'];
		$invoice_remarks = $row['quotation_remarks'];
		$terms_id = $row['terms_id'];
		
		$sqlinsert = "INSERT INTO $this->tableinvoice 
 							(invoice_no,customer_id,invoice_date,invoice_terms,iscomplete,invoice_attn,invoice_preparedby,invoice_attntel,invoice_attntelhp,invoice_attnfax,invoice_remarks,terms_id,createdby,created,updatedby,updated) 
 							values 	('$invoice_no',
 							$customer_id,
 							'$invoice_date',
 							'$invoice_terms',
 							$iscomplete,
							'$invoice_attn',
							'$invoice_preparedby',
							'$invoice_attntel',
							'$invoice_attntelhp',
							'$invoice_attnfax',
							'$invoice_remarks',
							$terms_id,
						 	$this->createdby,
							'$timestamp',
						 	$this->updatedby,
							'$timestamp')";
		
		$rs=$this->xoopsDB->query($sqlinsert);
		
	
		if (!rs){
			$this->log->showLog(1,"Failed to convert quotation code $quotation_id");
			return false;
		}
		else{
		
		
				$sql = "select * from $this->tablequotationline where quotation_id = $quotation_id ";
				$latest_id=$this->getLatestInvoiceID();
				
				$query=$this->xoopsDB->query($sql);
	
				$i=0;
				while ($row=$this->xoopsDB->fetchArray($query)){
				$i++;
		
		
				$seq = $row['quotation_seq'];
				$desc = $row['quotation_desc'];
				$item_id = $row['item_id'];
				$item_name = $row['item_name'];
				$qty = $row['quotation_qty'];
				$unitprice = $row['quotation_unitprice'];
				$discount = $row['quotation_discount'];
				$amount = $row['quotation_amount'];
		
				$sqlinsert="INSERT INTO $this->tableinvoiceline 
 						(invoice_seq,invoice_id,invoice_desc,item_id,item_name, invoice_qty,invoice_unitprice,invoice_discount,invoice_amount,iscustomprice ) 
 						values 	(
 						$seq,
				 		$latest_id,
				 		'$desc',
				 		$item_id,
				 		'$item_name',
						$qty,
						$unitprice,
						$discount,
						$amount,
						0)";
				
				$rs=$this->xoopsDB->query($sqlinsert);
	
				if (!rs){
					$this->log->showLog(1,"Failed to convert quotation line code $quotation_id");
					return false;
				}
				
	
	
			}	
				
			
			$this->log->showLog(3,"Converting quotation $quotation_id successfully"); 
			return true;
		}
	
	}
	
	
	
		
	}
	
	
	
	
	public function getNewInvoice() {
	$sql="SELECT MAX(CAST(invoice_no AS SIGNED)) as invoice_no from $this->tableinvoice;";
	$this->log->showLog(3,'Checking latest created invoice_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created invoice_no:' . $row['invoice_no']);
		$invoice_no=$row['invoice_no']+1;
		return $invoice_no;
	}
	else
	return 0;
	
  } // end
  
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
  
  
  

  

} // end of ClassQuotation
?>



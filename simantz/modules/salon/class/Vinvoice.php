<?php
/************************************************************************
Class Vinvoice.php - Copyright kfhoo
**************************************************************************/

class Vinvoice
{
  public $vinvoice_id;
  public $vinvoice_no;
  public $vinvoice_date;
  public $vinvoice_totalamount;
  public $vendor_id;
  public $terms_id;
  public $vinvoice_remarks;
  public $vinvoice_receiveby;
  public $receivebyname;
  public $start_date;
  public $end_date;

  public $vinvoiceline_id;
  public $vinvoiceline_no;
  public $vinvoiceline_discount;
  public $product_id;
  public $vinvoiceline_remarks;
  public $vinvoiceline_qty;
  public $vinvoiceline_price;
  public $vinvoiceline_amount;
  public $vinvoiceline_checkamount;
  public $vinvoiceline_discounttype;

  public $fldPayment;

  public $organization_id;
  public $created;
  public $updated;
  public $createdby;
  public $updatedby;
  public $isactive;
  public $iscomplete;
  public $cur_name;
  public $cur_symbol;
  
  public $isAdmin;
  public $orgctrl;
  public $employeectrl;
  public $vendorctrl;
  public $termsctrl;
  public $productctrl;

  public $tablevinvoice;
  public $tablevinvoiceline;
  public $tableemployee;
  public $tablevendor;
  public $tableterms;
  public $tableproduct;
  public $tablecategory;
  public $tableproductlist;
  public $tableuom;

  public $tableprefix;
  public $filename;

  public $fldShow;

  public function Vinvoice($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablevinvoice=$tableprefix."simsalon_vinvoice";
	$this->tablevinvoiceline=$tableprefix."simsalon_vinvoiceline";
	$this->tableemployee=$tableprefix."simsalon_employee";
	$this->tablevendor=$tableprefix."simsalon_vendor";
	$this->tableproduct=$tableprefix."simsalon_productlist";
	$this->tablecategory=$tableprefix."simsalon_productcategory";
	$this->tableproductlist=$tableprefix."simsalon_productlist";
	$this->tableterms=$tableprefix."simsalon_terms";
	$this->tableuom=$tableprefix."simsalon_uom";
	$this->log=$log;
  }


  public function insertVinvoice( ) {
	$this->log->showLog(3,"Creating product SQL:$sql");

	if($this->fldPayment > 0)
	$line =  $this->fldPayment;
	else
	$line =  0;

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new product $this->vinvoice_no");
	$sql =	"INSERT INTO $this->tablevinvoice 	(vinvoice_no,vinvoice_date,vinvoice_totalamount,vendor_id,terms_id,iscomplete,vinvoice_remarks,
							vinvoice_receiveby,isactive,created,createdby,updated,updatedby) 
							values('$this->vinvoice_no',
								'$this->vinvoice_date',
								$this->vinvoice_totalamount,
								$this->vendor_id,
								$this->terms_id,
								'$this->iscomplete',
								'$this->vinvoice_remarks',
								'$this->vinvoice_receiveby',								
		'$this->isactive','$timestamp',$this->createdby,'$timestamp',$this->updatedby)";

	$this->log->showLog(4,"Before insert product SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert vinvoice name '$vinvoice_no'");
		return false;
	}
	else{
		$this->insertLine($line);
		$this->log->showLog(3,"Inserting new vinvoice name '$vinvoice_no' successfully"); 
		return true;
	}
  } // end of member function insertClassMaster




  public function insertLine($row){

	$i = $this->getLatestLine("vinvoiceline_no");

	if($this->vinvoice_id == "")	
	$this->vinvoice_id = $this->getLatestVinvoiceID();

	$row += $i;

	while($i<$row){
	$i++;

	$sql = "INSERT INTO $this->tablevinvoiceline (vinvoiceline_no,vinvoice_id,vinvoiceline_qty,vinvoiceline_price,vinvoiceline_amount,vinvoiceline_discounttype) values
		($i,$this->vinvoice_id,0,0,0,1)";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update vinvoice failed");
		return false;
	}

	}

	return true;

  }

  public function updateLine(){
	$row = count($this->vinvoiceline_id);
	
	$i=0;
	while($i<$row){
	$i++;
	
	$vinvoiceline_id = $this->vinvoiceline_id[$i] ;
	$vinvoiceline_no = $this->vinvoiceline_no[$i] ;
	$vinvoiceline_remarks = $this->vinvoiceline_remarks[$i];
	$vinvoiceline_discount = $this->vinvoiceline_discount[$i];
	$product_id = $this->product_id[$i];
	$vinvoiceline_qty = $this->vinvoiceline_qty[$i];
	$vinvoiceline_price = $this->vinvoiceline_price[$i];
	$vinvoiceline_amount = $this->vinvoiceline_amount[$i];
	$vinvoiceline_checkamount = $this->vinvoiceline_checkamount[$i];
	$vinvoiceline_discounttype = $this->vinvoiceline_discounttype[$i];
	
	if($vinvoiceline_checkamount == "on")
	$vinvoiceline_checkamount = "Y";
	else
	$vinvoiceline_checkamount = "N";

	if($product_id>0 && $vinvoiceline_price > 0 && $this->iscomplete == "Y"){//update last purchase cost
		$sql = "UPDATE $this->tableproductlist SET lastpurchasecost = $vinvoiceline_price WHERE product_id = $product_id ";
		
		$this->log->showLog(4, "Before execute SQL update last purchase cost statement:$sql");
	
		$rs=$this->xoopsDB->query($sql);
		if(!$rs){
			$this->log->showLog(2, "Warning! Update product failed");
			return false;
		}

		// update average cost
		// (newqty*purchaseunitprice + stock(vinvoiceline)*(current average cost))/newqty+stock
		$newqty = $vinvoiceline_qty;
		$purchaseunitprice = $vinvoiceline_price;
		$stock = $this->getStockProduct($product_id);
		$currentaveragecost = $this->getPriceProduct($product_id,"amt");
		$newaveragecost = (($newqty*$purchaseunitprice) + ($stock*$currentaveragecost))/($newqty+$stock);

		if($newaveragecost=="")
		$newaveragecost = 0;

// 		if($currentaveragecost==""||$currentaveragecost==0)
// 		$newaveragecost = 

		$sql = "UPDATE $this->tableproductlist SET amt = $newaveragecost WHERE product_id = $product_id ";

		$rs=$this->xoopsDB->query($sql);
		if(!$rs){
			$this->log->showLog(2, "Warning! Update product failed");
			return false;
		}

		
	}

	

	$sql = "UPDATE $this->tablevinvoiceline SET
		vinvoiceline_no = $vinvoiceline_no,
		vinvoiceline_remarks = '$vinvoiceline_remarks',
		vinvoiceline_discount = $vinvoiceline_discount,
		product_id = $product_id,
		vinvoiceline_qty = $vinvoiceline_qty,
		vinvoiceline_price = $vinvoiceline_price,
		vinvoiceline_amount = $vinvoiceline_amount,
		vinvoiceline_checkamount = '$vinvoiceline_checkamount',
		vinvoiceline_discounttype = $vinvoiceline_discounttype
		WHERE vinvoice_id = $this->vinvoice_id and vinvoiceline_id = $vinvoiceline_id";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update vinvoice failed");
		return false;
	}
	
	

	

	}

	

	return true;

  }


  public function deleteLine($line){
	$sql = "DELETE FROM $this->tablevinvoiceline WHERE vinvoiceline_id = $line and vinvoice_id = $this->vinvoice_id ";


	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update vinvoice failed");
		return false;
	}else{
		$this->updateTotalAmount();
		$this->log->showLog(2, "Update vinvoice Successfully");
		return true;
	}

  }

  public function updateTotalAmount(){

	$sql = "UPDATE $this->tablevinvoice SET vinvoice_totalamount = COALESCE((SELECT sum(vinvoiceline_amount) as total FROM $this->tablevinvoiceline 
								 WHERE vinvoice_id = $this->vinvoice_id),0) 
		WHERE vinvoice_id = $this->vinvoice_id";
	
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update vinvoice failed");
		return false;
	}else{
		$this->log->showLog(2, "Update vinvoice Successfully");
		return true;
	}
  }

  /**
   * Update class information
   *
   * @return bool
   * @access public
   */
  public function updateVinvoice() {
    $timestamp= date("y/m/d H:i:s", time()) ;

	if($this->fldPayment > 0)
	$line =  $this->fldPayment;
	else
	$line =  0;

	$sql="";
	
 	$sql=	"UPDATE $this->tablevinvoice SET
		vinvoice_no='$this->vinvoice_no',
		vinvoice_date='$this->vinvoice_date',
		vinvoice_totalamount=$this->vinvoice_totalamount,
		vendor_id=$this->vendor_id,
		terms_id=$this->terms_id,
		iscomplete='$this->iscomplete',
		vinvoice_remarks='$this->vinvoice_remarks',
		vinvoice_receiveby='$this->vinvoice_receiveby',
		updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive'

		WHERE vinvoice_id='$this->vinvoice_id'";

	$this->log->showLog(3, "Update vinvoice_id: $this->vinvoice_id, '$this->vinvoice_name'");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update vinvoice failed");
		return false;
	}
	else{
		$this->updateLine();
		$this->insertLine($line);
		$this->log->showLog(3, "Update vinvoice successfully.");
		return true;
	}
  } // end of member function updateClass

  public function getLatestLine($fld){
	$retval = 0;
	$sql = "SELECT $fld from $this->tablevinvoiceline where vinvoice_id = $this->vinvoice_id ORDER BY vinvoiceline_no DESC";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row[$fld];
	}
	
	return $retval;
  }

  /**
   * Return sql select statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return 
   * @access public
   */
  public function getSqlStr_AllVinvoice( $wherestring,  $orderbystring,  $startlimitno ) {
  
	$wherestring .= " and a.vendor_id = c.vendor_id and a.terms_id = d.terms_id";

 	$sql= 	"SELECT *,a.isactive as isactive_m FROM $this->tablevinvoice a, $this->tablevendor c, $this->tableterms d
		$wherestring $orderbystring";

   $this->log->showLog(4,"Running Vinvoice->getSQLStr_AllVinvoice: $sql");
  return $sql;
  } // end of member function getSqlStr_AllClass

  /**
   * pull data from database into class.
   *
   * @param int masterclass_id 
   * @return bool
   * @access public
   */
  public function fetchVinvoiceInfo( $vinvoice_id ) {
    
	$this->log->showLog(3,"Fetching product detail into class Vinvoice.php.<br>");
		
	$sql="SELECT * FROM $this->tablevinvoice
	where vinvoice_id=$vinvoice_id";
	
	$this->log->showLog(4,"Vinvoice->fetchVinvoiceInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->vinvoice_id=$row["vinvoice_id"];
		$this->vinvoice_no=$row["vinvoice_no"];
		$this->vinvoice_date=$row["vinvoice_date"];
		$this->vinvoice_totalamount= $row['vinvoice_totalamount'];
		$this->vendor_id= $row['vendor_id'];
		$this->terms_id= $row['terms_id'];
		$this->vinvoice_remarks=$row['vinvoice_remarks'];
		$this->vinvoice_receiveby=$row['vinvoice_receiveby'];
		$this->iscomplete=$row['iscomplete'];
		$this->isactive=$row['isactive'];
	
	   	$this->log->showLog(4,"Vinvoice->fetchVinvoiceInfo,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Vinvoice->fetchVinvoiceInfo,failed to fetch data into databases.");	
	}
  } // end of member function fetchVinvoiceInfo


  public function getInputForm( $type,  $vinvoice_id,$token ) {
	$filectrl="";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$uploadctrl="";
	$displayadd="";
	$completectrl="";
	

	$timestamp= date("Y-m-d", time()) ;

	if ($type=="new"){
		$header="New Organization";
		$action="create";
		$btnsave = "Next";
		$stylecomplete = "style='display:none'";
		$this->vinvoice_remarks = "";

		if($vinvoice_id==0){
		$this->vinvoice_no="";
		}
		$this->vinvoice_date = $timestamp;

		$savectrl="<input style='height:40px;' name='btnSave' value='$btnsave' type='submit'>";
		$checked="CHECKED";
		$checked2="";
		$deletectrl="";
		$addnewctrl="";
		$this->vinvoice_totalamount=0;
		$displayadd="style='display:none'";

		$this->vinvoice_no = getNewCode($this->xoopsDB,"vinvoice_no",$this->tablevinvoice);
		$this->vinvoice_receiveby = $this->receivebyname;
		
	}
	else
	{
		$action="update";

		if ($this->iscomplete=='Y'){
			$checked2="CHECKED";
			$btnsave = "Complete";
		}else{
			$checked2="";
			$btnsave = "Save";
		}

		$savectrl="<input name='vinvoice_id' value='$this->vinvoice_id' type='hidden'>".
			 "<input style='height:40px;' name='btnSave' value='$btnsave' type='submit'>";
		$completectrl="<input name='vinvoice_id' value='$this->vinvoice_id' type='hidden'>".
			 "<input style='height:40px;' name='btnComplete' value='Complete' type='submit' onclick='document.frmVinvoice.iscomplete.checked = true;'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablevinvoice' type='hidden'>".
		"<input name='id' value='$this->vinvoice_id' type='hidden'>".
		"<input name='idname' value='vinvoice_id' type='hidden'>".
		"<input name='title' value='Vinvoice' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		


		$header="Edit Vinvoice";
		if($this->allowDelete($this->vinvoice_id) && $this->vinvoice_id>0)
		$deletectrl="<FORM action='vinvoice.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this product?"'.")'><input style='height:40px;' type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->vinvoice_id' name='vinvoice_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

		$addnewctrl="<form action='vinvoice.php' method='post'><input type='submit' value='New' value='New' style='height:40px;'></form>";
			

	}

echo <<< EOF

<table style="width:300px;">$recordctrl<tbody><td>$addnewctrl</td><td>$deletectrl</td><td><form onsubmit="return validateVinvoice()" method="post"
 	action="vinvoice.php" name="frmVinvoice"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset" style='height:40px;'>
	<input name="btnSearch" value="Search" type="button" onclick="showSearch();" style='height:40px;'>
	</td></tbody></table>

 <table cellspacing='3' border='1'>

    <tr>
      <th>Description</th>
      <th>Data</th>
      <th>Description</th>
      <th>Data</th>
    </tr>
    <tr>
      <td class="head">Invoice No</td>
      <td class="odd"><input name="vinvoice_no" value="$this->vinvoice_no" maxlength='10' size='10'></td>
      <td class="head">Active</td>
      <td class="odd"><input type="checkbox" $checked name="isactive" ></td>
    </tr>
  <tbody>

    <tr>
      	<td class="head">Vendor</td>
      	<td class="even">$this->vendorctrl</td>
	<td class="head">Date</td>
	<td class="even">
	<input name='vinvoice_date' id='vinvoice_date' value="$this->vinvoice_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->datectrl">
	</td>
    </tr>
	
    <tr>
		<td class="head">Terms</td>
      	<td class="odd">$this->termsctrl</td>
		<td class="head">Remarks</td>
      	<td class="odd" ><textarea name="vinvoice_remarks" cols="60" rows="1">$this->vinvoice_remarks</textarea></td>
    </tr>
	
	
    <tr>
		<td class="head">Receive By</td>
      	<td class="even"><input name="vinvoice_receiveby" value="$this->vinvoice_receiveby" maxlength='50' size='30'></td>
		<td class="head">Total Amount ($this->cur_symbol)</td>
      	<td class="even"  colspan="3"><input name="vinvoice_totalamount" value="$this->vinvoice_totalamount" maxlength='10' size='10' readonly></td>
		
		<td class="head" style="display:none"><div $stylecomplete>Complete</div></td>
      	<td class="even" style="display:none"><input type="checkbox" $checked2 name="iscomplete" $stylecomplete onclick="completeVinvoice(this.checked)"></td>
    </tr>

	<tr>
		
		
    </tr>
	
  </tbody>
</table>
<table style="width:150px;"><tbody><td>$savectrl $completectrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden">
	<input name="line" value="" type="hidden">
	</td>
	</tbody></table>

<br>
<table style="width:300px">
<tr>
	<td class="head">List Item :</td>
	<td class="odd">
	<input type="text" name="fldPayment" size="5" maxlength="5">
	<input type="button" value="Add" onclick="addPayment();" $displayadd>
	
	</td>
</tr>
</table>

<br>

EOF;

if($displayadd=="")
$this->getTableLine();

echo "</form>";

  } // end of member function getInputForm

  
  public function getTableLine(){
	$rowtype="";

	$sql = "SELECT * FROM $this->tablevinvoiceline WHERE vinvoice_id = $this->vinvoice_id ORDER BY vinvoiceline_no ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);

echo <<< EOF
	<table border=1>
	<tr align="center">
		<th>No</th>
		<th>Seq</th>
		<th>Product</th>
		<th>Remarks</th>
		<th>Qty</th>
		<th>Price</th>
		<th>Discount</th>
		<th>Amount ($this->cur_symbol)</th>
		<th></th>
	</tr>
	
EOF;

	$i=0;
	$vinvoiceline_amountfinal = "";
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	
	$vinvoiceline_id = $row['vinvoiceline_id'];
	$vinvoiceline_no = $row['vinvoiceline_no'];
	$vinvoiceline_discount = $row['vinvoiceline_discount'];
	$product_id = $row['product_id'];
	$vinvoiceline_remarks = $row['vinvoiceline_remarks'];
	$vinvoiceline_qty = $row['vinvoiceline_qty'];
	$vinvoiceline_price = $row['vinvoiceline_price'];
	$vinvoiceline_amount = $row['vinvoiceline_amount'];
	$vinvoiceline_discounttype = $row['vinvoiceline_discounttype'];
	$vinvoiceline_checkamount = $row['vinvoiceline_checkamount'];

	$vinvoiceline_amountfinal += $vinvoiceline_amount;

	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

//	$employeectrl = $this->getEmployeeListArray($vinvoiceline_discount,$i);
	$productctrl = $this->getSelectProduct($product_id,$i);
	$uom = $this->getPriceProduct($product_id,"uom_description");


	$checked1 = "";
	$checked2 = "";

	if($vinvoiceline_discounttype=="1")
	$checked1 = "SELECTED";
	else
	$checked2 = "SELECTED";

	if($vinvoiceline_checkamount == "Y")
	$checkamount = "CHECKED";
	else
	$checkamount = "";

echo <<< EOF
	<input type="hidden" name="vinvoiceline_id[$i]" value="$vinvoiceline_id">
	<tr align="center">
		<td class="$rowtype">$i</td>
		<td class="$rowtype"><input type="text" size="3" maxlength="5" name="vinvoiceline_no[$i]" value="$vinvoiceline_no"></td>
		<td class="$rowtype">$productctrl</td>
		<td class="$rowtype"><textarea cols="25" rows="1" name="vinvoiceline_remarks[$i]">$vinvoiceline_remarks</textarea></td>
		<td class="$rowtype"><input type="text" size="3" maxlength="10" name="vinvoiceline_qty[$i]" value="$vinvoiceline_qty" onblur="calculateTotal(document);"> <div id=idUom$i>$uom</div></td>
		<td class="$rowtype"><input type="text" size="5" maxlength="10" name="vinvoiceline_price[$i]" value="$vinvoiceline_price" onblur="calculateTotal(document);parseelement(this);"></td>
		<td class="$rowtype"><input type="text" size="5" maxlength="10" name="vinvoiceline_discount[$i]" value="$vinvoiceline_discount" onblur="calculateTotal(document);parseelement(this);"> 
		<select name="vinvoiceline_discounttype[$i]" onchange="calculateTotal(document)">		
		<option value="1" $checked1>%</option>
		<option value="2" $checked2>$this->cur_symbol</option>
		</select>

		</td>
		<td class="$rowtype" align="left"><input type="text" size="7" maxlength="10" name="vinvoiceline_amount[$i]" value="$vinvoiceline_amount" onblur="calculateTotalAmount(document);parseelement(this);checkAmount($i);">
		<br>
		<input id="checkedID$i" type="checkbox" name="vinvoiceline_checkamount[$i]" $checkamount>Use This Amount
		</td>
		<td class="$rowtype"><input type="button" value="Delete" onclick="deleteLine($vinvoiceline_id);"></td>

	</tr>
EOF;
	}
	if($i == 0){
	echo "<tr><td colspan='8'>Please Add Invoice Line.</td></tr>";
	}

	

echo <<< EOF
</table>
EOF;

	
  }

  /**
   *
   * @param int productmaster_id 
   * @return bool
   * @access public
   */
  public function deleteVinvoice( $productmaster_id ) {
   	$this->log->showLog(2,"Warning: Performing delete product id : $this->vinvoice_id !");
	$sql="DELETE FROM $this->tablevinvoice where vinvoice_id=$this->vinvoice_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: product ($vinvoice_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Vinvoice ($vinvoice_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteVinvoiceMaster


/**
   * Display a product list table
   *
   * 
   * @access public
   */
public function showVinvoiceTable(){
	if($this->start_date=="")
	$this->start_date = getMonth(date("Ymd", time()),0) ;
   	
	if($this->end_date=="")
	$this->end_date = getMonth(date("Ymd", time()),1) ;

	$wherestring = " where a.vinvoice_id>0 ";
	
	$wherestring .= $this->getWhereString();

	$this->log->showLog(3,"Showing Vinvoice Table");
	$sql=$this->getSQLStr_AllVinvoice($wherestring," GROUP BY a.vinvoice_id ORDER BY vinvoice_date desc ",0);
	
	$query=$this->xoopsDB->query($sql);

	echo <<< EOF
	<form name="frmNew" action="vinvoice.php" method="POST">
	<table>
	<tr>
	<td><input type="submit" value="New" style='height:40px;'></td>
	</tr>
	</table>
	</form>

	<form action="vinvoice.php" method="POST" name="frmSearch">
	<input type="hidden" name="fldShow" value="">
	<input type="hidden" name="action" value="">
	<input type="hidden" value="" name="vinvoice_id">
	<table border='1' cellspacing='3'>
	<tr>
	<td class="head">Invoice Code</td>
	<td class="even"><input type="text" name="vinvoice_no" value=""></td>
	<td class="head">Vendor</td>
	<td class="even">$this->vendorctrl</td>
	</tr>

	<tr>
	<td class="head">Product</td>
	<td class="even">$this->productctrl</td>
	<td class="head">Terms</td>
	<td class="even">$this->termsctrl</td>
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
	<td class="head" colspan="4"><input type="button" value="Search" onclick="searchVinvoice();" style='height:40px;'></td>
	</tr>

	</table></form>
	<br>
	
EOF;
	if($this->fldShow=="Y"){
echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;" width="5%">No</th>

				<th style="text-align:center;" width="5%">Code</th>
				<th style="text-align:center;" width="15%">Date</th>
				<th style="text-align:center;" width="30%">Vendor</th>
				<th style="text-align:center;" width="10%">Complete</th>
				<th style="text-align:center;" width="15%">Amount ($this->cur_symbol)</th>
				<th style="text-align:center;" width="10%">Active</th>
				<th style="text-align:center;" width="10%" colspan="3">Operation</th>
				
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	$vinvoice_totalamountfinal = "";
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$vinvoice_id=$row['vinvoice_id'];
		$vinvoice_no=$row['vinvoice_no'];
		$vinvoice_date=$row['vinvoice_date'];
		$vinvoice_totalamount=$row['vinvoice_totalamount'];
		$vendor_id=$row['vendor_name'];	
		$terms_id=$row['terms_name'];	
		$iscomplete=$row['iscomplete'];
		$isactive=$row['isactive_m'];

		$vinvoice_totalamountfinal += $vinvoice_totalamount;

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
			<td class="$rowtype" style="text-align:center;">$vinvoice_no</td>
			<td class="$rowtype" style="text-align:center;">$vinvoice_date</td>
			<td class="$rowtype" style="text-align:center;">$vendor_id</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">$vinvoice_totalamount</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
			<form action="vinvoice.php" method="POST">
			<input type="image" src="images/edit.gif" name="imgSubmit" title='Edit this record' $styleedit>
			<input type="hidden" name="vinvoice_id" value="$vinvoice_id">
			<input type="hidden" name="action" value="edit">
			</form>
		
			
			<form action="vinvoice.php" method="POST" onsubmit="return confirm('Enable This Record?')">
			<input type="submit"  name="btnEnable" title='Enable this record' value="Enable" $styleenable>
			<input type="hidden" name="vinvoice_id" value="$vinvoice_id">
			<input type="hidden" name="action" value="enable">
			</form>
			</td>

		</tr>
EOF;
	}

	if($i==0)
	echo "<tr><td colspan=8>No record(s) found.</td></tr>";

	
	if($vinvoice_totalamountfinal != "")
	$vinvoice_totalamountfinal = number_format($vinvoice_totalamountfinal, 2, '.','');

	echo  "<tr>
		<td class='head' colspan='5'></td>
		<td class='head' align=center>$vinvoice_totalamountfinal</td>
		<td class='head' colspan='2'></td>
		<tr>";

	echo  "</tbody></table>";

	}
 }



  public function getWhereString(){
	$retval = "";
	//echo $this->isactive;

	if($this->vinvoice_no != "")
	$retval .= " and a.vinvoice_no LIKE '$this->vinvoice_no' ";
	if($this->vendor_id > 0)
	$retval .= " and a.vendor_id = '$this->vendor_id' ";
	if($this->terms_id > 0)
	$retval .= " and a.terms_id = '$this->terms_id' ";
 	if($this->product_id > 0)
 	$retval .= " and a.vinvoice_id IN (select vinvoice_id from $this->tablevinvoiceline where product_id = $this->product_id ) ";

	if($this->isactive != "X" && $this->isactive != "")
	$retval .= " and a.isactive = '$this->isactive' ";
	if($this->iscomplete != "X" && $this->iscomplete != "")
	$retval .= " and a.iscomplete = '$this->iscomplete' ";
		if($this->start_date != "" && $this->end_date != "")
	$retval .= " and ( a.vinvoice_date between '$this->start_date' and '$this->end_date' ) ";

	return $retval;
	
  }

/**
   * get latest generated product
   * 
   * return int  vinvoice_id (latest)
   * @access public
   */
  public function getLatestVinvoiceID(){
  	$sql="SELECT MAX(vinvoice_id) as vinvoice_id from $this->tablevinvoice;";
	$this->log->showLog(3, "Retrieveing last product id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['vinvoice_id'];
	else
	return -1;
	

  }


public function getSelectVinvoice($id,$isitem='NY',$calledfunction="") {

	$wherestring="";
	$tablecategory=$this->tableprefix ."simtrain_vinvoicecategory";
	if ($isitem=='YN')
		$wherestring=" WHERE ((p.isactive='Y' and c.isitem <> 'C')";
	elseif($isitem=="Y")
		$wherestring=" WHERE ((p.isactive='Y' and c.isitem = 'Y')";
	elseif($isitem=="N")
		$wherestring=" WHERE ((p.isactive='Y' and c.isitem = 'N')";
	elseif($isitem=="A")
		$wherestring=" WHERE ((p.isactive='Y' )";

	else
		$wherestring=" WHERE ((p.isactive='Y' and c.isitem = 'C' )";

	$sql="SELECT p.vinvoice_id,p.vinvoice_name from $this->tablevinvoice p ".
		"inner join $tablecategory c on c.category_id=p.category_id ".
		"$wherestring or (p.vinvoice_id=$id)) and p.vinvoice_id>0 order by vinvoice_name ;";

	$this->log->showLog(4,"Excute SQL for generate product list: $sql;");
	$selectctl="<SELECT name='vinvoice_id' $calledfunction>";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$vinvoice_id=$row['vinvoice_id'];
		$vinvoice_name=$row['vinvoice_name'];
	
		if($id==$vinvoice_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$vinvoice_id' $selected>$vinvoice_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getVinvoicePrice($id){
	$this->log->showLog(3,"Retrieving default price for product $id");
	$sql="SELECT vinvoice_name,amt from $this->tablevinvoice where vinvoice_id=$id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$price=$row['amt'];
		$vinvoice_name=$row['vinvoice_name'];
		$this->log->showLog(3,"vinvoice_id: have productname: $vinvoice_name with vinvoice_id: $id");
		return $price;
	
	}
	else
	{
		$this->log->showLog(1,"Error, can't find vinvoice_id: $id");
		return 0;
	}
	


  }
  public function savefile($tmpfile,$newfilename){
	move_uploaded_file($tmpfile, "upload/products/$newfilename");
	$sqlupdate="UPDATE $this->tablevinvoice set filename='$newfilename' where vinvoice_id=$vinvoice_id";
	$qryUpdate=$this->xoopsDB->query($sqlupdate);
  }

  public function deletefile($vinvoice_id){
	$sql="SELECT filename from $this->tablevinvoice where vinvoice_id=$vinvoice_id";
	$query=$this->xoopsDB->query($sql);
	$myfilename="";
	if($row=$this->xoopsDB->fetchArray($query)){
		$myfilename=$row['filename'];
	}
	$myfilename="upload/products/$myfilename";
	$this->log->showLog(3,"This file name: $myfilename");
	unlink("$myfilename ");
	$sqlupdate="UPDATE $this->tablevinvoice set filename='-' where vinvoice_id=$vinvoice_id";
	$qryDelete=$this->xoopsDB->query($sqlupdate);
  }

  public function allowDelete($vinvoice_id){
/*
	$tabletuitionclass = $this->tableprefix."simtrain_tuitionclass";
	$tablepaymentline = $this->tableprefix."simtrain_paymentline";
	$tableinventorymovement = $this->tableprefix."simtrain_inventorymovement";

	$sql="select sum(recordcount) as recordcount from (
		SELECT count(vinvoice_id) as recordcount FROM $tabletuitionclass where vinvoice_id=$vinvoice_id
		UNION 
		SELECT count(vinvoice_id) as recordcount FROM $tablepaymentline where vinvoice_id=$vinvoice_id
		UNION 
		SELECT count(vinvoice_id) as recordcount FROM $tableinventorymovement where vinvoice_id=$vinvoice_id
		) as b1";
	
	$this->log->showLog(3,"Verified allowDelete for vinvoice_id:$vinvoice_id");
	$this->log->showLog(4,"With SQL: $sql");

	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$recordcount=$row['recordcount'];
		$this->log->showLog(3,"Found child record: $recordcount");

		if($recordcount==0 || $recordcount=="")
			return true;
		else
			return false;
	}*/
	return true;
  
}

  public function getEmployeeListArray($id,$i){
	$this->log->showLog(3,"Retrieve available employee from database, with id: $id");
	$filterstr="";
	
	$sql="SELECT vinvoiceline_discount,employee_name from $this->tableemployee where (isactive='Y' or vinvoiceline_discount=$id)  order by employee_name ";
	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='vinvoiceline_discount[$i]' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$vinvoiceline_discount=$row['vinvoiceline_discount'];
		$employee_name=$row['employee_name'];
	
		if($id==$vinvoiceline_discount)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$vinvoiceline_discount' $selected>$employee_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getSelectProduct($id,$i) {

	$wherestring="";
	
	$wherestring.=" WHERE p.isactive='Y' ";
	$wherestring .="and c.isitem='N'";

	$sql="SELECT p.product_id,p.product_name from $this->tableproduct p ".
		"inner join $this->tablecategory c on c.category_id=p.category_id ".
		"$wherestring or (p.product_id=$id) order by p.isdefault desc,p.product_name asc ";

	$this->log->showLog(4,"Excute SQL for generate product list: $sql;");
	$selectctl="<SELECT name='product_id[$i]' id=name='product_id[$i]' onchange='getPrice($i,this.value);'>";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$product_id=$row['product_id'];
		$product_name=$row['product_name'];
	
		if($id==$product_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$product_id' $selected>$product_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end


  public function getPriceProduct($id,$fld){
	if($fld=="uom_description")
	$price = "";
	else
	$price = "0.00";

	$sql = "SELECT $fld as fld FROM $this->tableproductlist a, $this->tableuom b 
	WHERE a.product_id = $id
	and  a.uom_id = b.uom_id ";
	
	$query=$this->xoopsDB->query($sql);	
	$this->log->showLog(4,"With SQL: $sql");

	if($row=$this->xoopsDB->fetchArray($query)){
	$price = $row['fld'];
	}
	
	return $price;
  }

  public function getStockProduct($product_id){
	$retval = 0;

	$sql = "SELECT COALESCE(sum(vinvoiceline_qty),0) as stock FROM $this->tablevinvoiceline a, $this->tablevinvoice b 
		WHERE product_id =  $product_id 
		and a.vinvoice_id = b.vinvoice_id
		and b.iscomplete = 'Y' ";

	$query=$this->xoopsDB->query($sql);	
	$this->log->showLog(4,"With SQL: $sql");

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['stock'];
	}
	
	return $retval;
  }

  public function enableInvoice(){

	$sql = "update $this->tablevinvoice set iscomplete = 'N' where vinvoice_id = $this->vinvoice_id ";

	$this->log->showLog(4,"With SQL: $sql");

	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: ($vinvoice_id) cannot enable from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Vinvoice ($vinvoice_id) enabled successfully!");
		return true;
		
	}
  }

  public function getTerms($vendor_id){
	$retval = 0;

	echo $sql = "select * from $this->tablevendor where vendor_id = $vendor_id ";

	$query=$this->xoopsDB->query($sql);	
	$this->log->showLog(4,"With SQL: $sql");

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['terms_id'];
	}
	
	return $retval;
  }




} // end of VinvoiceMaster
?>

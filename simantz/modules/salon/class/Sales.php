<?php
/************************************************************************
Class Sales.php - Copyright kfhoo
**************************************************************************/

class Sales
{
  public $sales_id;
  public $sales_no;
  public $sales_date;
  public $sales_totalamount;
  public $customer_id;
  public $sales_remarks;
  public $start_date;
  public $end_date;

  public $salesline_id;
  public $salesline_no;
  public $employee_id;
  public $product_id;
  public $salesline_remarks;
  public $salesline_qty;
  public $salesline_price;
  public $salesline_amount;

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
  public $customerctrl;
  public $productctrl;

  public $tablesales;
  public $tablesalesline;
  public $tableemployee;
  public $tablecustomer;
  public $tableproduct;
  public $tablecategory;
  public $tableproductlist;
  public $tablepromotion;

  public $tableprefix;
  public $filename;
  public $limitauto;

  public $fldShow;

  public function Sales($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablesales=$tableprefix."simsalon_sales";
	$this->tablesalesline=$tableprefix."simsalon_salesline";
	$this->tableemployee=$tableprefix."simsalon_employee";
	$this->tablecustomer=$tableprefix."simsalon_customer";
	$this->tableproduct=$tableprefix."simsalon_productlist";
	$this->tablecategory=$tableprefix."simsalon_productcategory";
	$this->tableproductlist=$tableprefix."simsalon_productlist";
	$this->tablepromotion=$tableprefix."simsalon_promotion";
	$this->log=$log;
  }


  public function insertSales( ) {
	$this->log->showLog(3,"Creating product SQL:$sql");

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new product $this->sales_no");
	$sql =	"INSERT INTO $this->tablesales 	(sales_no,sales_date,sales_totalamount,customer_id,iscomplete,sales_remarks,
							isactive,created,createdby,updated,updatedby) 
							values('$this->sales_no',
								'$this->sales_date',
								$this->sales_totalamount,
								$this->customer_id,
								'$this->iscomplete',
								'$this->sales_remarks',
		'$this->isactive','$timestamp',$this->createdby,'$timestamp',$this->updatedby)";

	$this->log->showLog(4,"Before insert product SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert sales name '$sales_no'");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new sales name '$sales_no' successfully"); 
		return true;
	}
  } // end of member function insertClassMaster


  public function insertLine($row){
	$i = $this->getLatestLine("salesline_no");
	
	$row += $i;

	while($i<$row){
	$i++;

	$sql = "INSERT INTO $this->tablesalesline (salesline_no,sales_id,salesline_qty,salesline_price,salesline_amount) values
		($i,$this->sales_id,0,0,0)";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update sales failed");
		return false;
	}

	}

	return true;

  }

  public function updateLine(){
	$row = count($this->salesline_id);
	
	$i=0;
	while($i<$row){
	$i++;
	
	$salesline_id = $this->salesline_id[$i] ;
	$salesline_no = $this->salesline_no[$i] ;
	$salesline_remarks = $this->salesline_remarks[$i];
	$employee_id = $this->employee_id[$i];
	$product_id = $this->product_id[$i];
	$salesline_qty = $this->salesline_qty[$i];
	$salesline_price = $this->salesline_price[$i];
	$salesline_amount = $this->salesline_amount[$i];

	$sql = "UPDATE $this->tablesalesline SET
		salesline_no = $salesline_no,
		salesline_remarks = '$salesline_remarks',
		employee_id = $employee_id,
		product_id = $product_id,
		salesline_qty = $salesline_qty,
		salesline_price = $salesline_price,
		salesline_amount = $salesline_amount
		WHERE sales_id = $this->sales_id and salesline_id = $salesline_id";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update sales failed");
		return false;
	}

	}

	return true;

  }


  public function deleteLine($line){
	$sql = "DELETE FROM $this->tablesalesline WHERE salesline_id = $line and sales_id = $this->sales_id ";


	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update sales failed");
		return false;
	}else{
		$this->updateTotalAmount();
		$this->log->showLog(2, "Update sales Successfully");
		return true;
	}

  }

  public function updateTotalAmount(){

	$sql = "UPDATE $this->tablesales SET sales_totalamount = COALESCE((SELECT sum(salesline_amount) as total FROM $this->tablesalesline 
								 WHERE sales_id = $this->sales_id),0) 
		WHERE sales_id = $this->sales_id";
	
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update sales failed");
		return false;
	}else{
		$this->log->showLog(2, "Update sales Successfully");
		return true;
	}
  }

  /**
   * Update class information
   *
   * @return bool
   * @access public
   */
  public function updateSales() {
    $timestamp= date("y/m/d H:i:s", time()) ;
	$sql="";
	
 	$sql=	"UPDATE $this->tablesales SET
		sales_no='$this->sales_no',
		sales_date='$this->sales_date',
		sales_totalamount=$this->sales_totalamount,
		customer_id=$this->customer_id,
		iscomplete='$this->iscomplete',
		sales_remarks='$this->sales_remarks',
		updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive'

		WHERE sales_id='$this->sales_id'";

	$this->log->showLog(3, "Update sales_id: $this->sales_id, '$this->sales_name'");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update sales failed");
		return false;
	}
	else{
		$this->updateLine();
		$this->log->showLog(3, "Update sales successfully.");
		return true;
	}
  } // end of member function updateClass

  public function getLatestLine($fld){
	$retval = 0;
	$sql = "SELECT $fld from $this->tablesalesline where sales_id = $this->sales_id ORDER BY salesline_no DESC";

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
  public function getSqlStr_AllSales( $wherestring,  $orderbystring,  $startlimitno ) {
  
	$wherestring .= " and a.customer_id = c.customer_id ";

 	$sql= 	"SELECT * FROM $this->tablesales a, $this->tablecustomer c
		$wherestring $orderbystring $startlimitno";

   $this->log->showLog(4,"Running Sales->getSQLStr_AllSales: $sql");
  return $sql;
  } // end of member function getSqlStr_AllClass

  /**
   * pull data from database into class.
   *
   * @param int masterclass_id 
   * @return bool
   * @access public
   */
  public function fetchSalesInfo( $sales_id ) {
    
	$this->log->showLog(3,"Fetching product detail into class Sales.php.<br>");
		
	$sql="SELECT * FROM $this->tablesales
	where sales_id=$sales_id";
	
	$this->log->showLog(4,"Sales->fetchSalesInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->sales_id=$row["sales_id"];
		$this->sales_no=$row["sales_no"];
		$this->sales_date=$row["sales_date"];
		$this->sales_totalamount= $row['sales_totalamount'];
		$this->customer_id= $row['customer_id'];
		$this->sales_remarks=$row['sales_remarks'];
		$this->iscomplete=$row['iscomplete'];
		$this->isactive=$row['isactive'];
	
	   	$this->log->showLog(4,"Sales->fetchSalesInfo,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Sales->fetchSalesInfo,failed to fetch data into databases.");	
	}
  } // end of member function fetchSalesInfo


  public function getInputForm( $type,  $sales_id,$token ) {
	$filectrl="";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$uploadctrl="";
	$displayadd="";
	

	$timestamp= date("Y-m-d", time()) ;

	if ($type=="new"){
		$header="New Organization";
		$action="create";
		if($sales_id==0){
		$this->sales_no="";
		}
		$this->sales_date = $timestamp;

		$savectrl="<input style='height:40px;' name='btnSave' value='Next' type='submit'>";
		$checked="CHECKED";
		$checked2="";
		$deletectrl="";
		$addnewctrl="";
		$this->sales_totalamount=0;
		$displayadd="style='display:none'";

		$this->sales_no = getNewCode($this->xoopsDB,"sales_no",$this->tablesales);
		
	}
	else
	{
		$action="update";
		$savectrl="<input name='sales_id' value='$this->sales_id' type='hidden'>".
			 "<input style='height:40px;' name='btnSave' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		//force iscomplete checkbox been checked if the value in db is 'Y'
		if ($this->iscomplete=='Y')
			$checked2="CHECKED";
		else
			$checked2="";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablesales' type='hidden'>".
		"<input name='id' value='$this->sales_id' type='hidden'>".
		"<input name='idname' value='sales_id' type='hidden'>".
		"<input name='title' value='Sales' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		


		$header="Edit Sales";
		if($this->allowDelete($this->sales_id) && $this->sales_id>0)
		$deletectrl="<FORM action='sales.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this product?"'.")'><input style='height:40px;' type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->sales_id' name='sales_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

		$addnewctrl="<form action='sales.php' method='post'><input type='submit' value='New' value='New' style='height:40px;'></form>";
		

	}

echo <<< EOF

<table style="width:300px;">$recordctrl<tbody><td>$deletectrl</td><td><form onsubmit="return validateSales()" method="post"
 	action="sales.php" name="frmSales"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset" style='height:40px;'>
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
      <td class="head">Sales No</td>
      <td class="odd"><input name="sales_no" value="$this->sales_no" maxlength='10' size='10'></td>
      <td class="head">Active</td>
      <td class="even"><input type="checkbox" $checked name="isactive" ></td>
    </tr>
  <tbody>

    <tr>
      	<td class="head">Customer</td>
      	<td class="odd">$this->customerctrl</td>
	<td class="head">Date</td>
	<td class="odd">
	<input name='sales_date' id='sales_date' value="$this->sales_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->datectrl">
	</td>
    </tr>
    <tr>
	<td class="head">Remarks</td>
      	<td class="even" ><textarea name="sales_remarks" cols="40" rows="4">$this->sales_remarks</textarea></td>
	<td class="head">Complete</td>
      	<td class="even"><input type="checkbox" $checked2 name="iscomplete" ></td>
    </tr>
	
	
    <tr>
	<td class="head">Total Amount (RM)</td>
      	<td class="odd" colspan="3"><input name="sales_totalamount" value="$this->sales_totalamount" maxlength='10' size='10' readonly></td>
    </tr>
  </tbody>
</table>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden">
	<input name="line" value="" type="hidden">
	</td>
	</tbody></table>

<br>
<table style="width:250px">
<tr $displayadd>
	<td class="head">List Payment :</td>
	<td class="odd">
	<input type="text" name="fldPayment" size="5" maxlength="5">
	<input type="button" value="Add" onclick="addPayment();">
	
	</td>
</tr>
</table>

<br>
EOF;



if($displayadd==""){
$this->getPromotionList();
$this->getTableLine();
}

echo "</form>";

  } // end of member function getInputForm

  
  public function getPromotionList(){
	
	$wherestring = $this->getPromotionSQL();
	$wherestring .= " and a.product_id = b.product_id ";
	$sql = "SELECT * FROM $this->tablepromotion a, $this->tableproductlist b WHERE 1 $wherestring ";
	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);

echo <<< EOF

	<table style="width:900px">
		<tr>
		<th colspan="5"><marquee>List Of Promotion!!!</marquee></th>
		</tr>
		
		<tr>
		<td class="head" align="center" width="50px">No</td>
		<td class="head" align="center" width="650px">Description</td>
		<td class="head" align="center" width="100px">Type</td>
		<td class="head" align="center" width="100px">Price (RM)</td>
		<td class="head" align="center" width="100px">Expiry Date</td>
		</tr>
EOF;

		$i=0;
		while($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$promotion_desc = $row['promotion_desc'];
		$promotion_type = $row['promotion_type'];
		$promotion_price= $row['promotion_price'];
		$promotion_expiry= $row['promotion_expiry'];
		$product_name = $row['product_name'];
		
		if($promotion_type=="P")
		$promotion_desc .= " (".$product_name.")";

		if($promotion_type=="S")
		$promotion_type = "Special";
		else if($promotion_type=="U")
		$promotion_type = "Customer";
		else
		$promotion_type = "Product";
echo <<< EOF
		
		<tr>
		<td class="even">$i</td>
		<td class="even">$promotion_desc</td>
		<td class="even" align="center">$promotion_type</td>
		<td class="even" align="right">$promotion_price</td>
		<td class="even" align="center">$promotion_expiry</td>
		</tr>
EOF;
		}
echo <<< EOF
	</table>
	<br>

EOF;
	
  }

  public function getTableLine(){
	$rowtype="";

	$sql = "SELECT * FROM $this->tablesalesline WHERE sales_id = $this->sales_id ORDER BY salesline_no ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);

echo <<< EOF
	<table border=1>
	<tr align="center">
		<th>No</th>
		<th>Seq</th>
		<th>Employee</th>
		<th>Product</th>
		<th>Remarks</th>
		<th>Qty</th>
		<th>Price</th>
		<th>Amount (RM)</th>
		<th></th>
	</tr>
	
EOF;

	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	
	$salesline_id = $row['salesline_id'];
	$salesline_no = $row['salesline_no'];
	$employee_id = $row['employee_id'];
	$product_id = $row['product_id'];
	$salesline_remarks = $row['salesline_remarks'];
	$salesline_qty = $row['salesline_qty'];
	$salesline_price = $row['salesline_price'];
	$salesline_amount = $row['salesline_amount'];

	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

	$employeectrl = $this->getEmployeeListArray($employee_id,$i);
	$productctrl = $this->getSelectProduct($product_id,$i);


echo <<< EOF
	<input type="hidden" name="salesline_id[$i]" value="$salesline_id">
	<tr align="center">
		<td class="$rowtype">$i</td>
		<td class="$rowtype"><input type="text" size="3" maxlength="5" name="salesline_no[$i]" value="$salesline_no"></td>
		<td class="$rowtype">$employeectrl</td>
		<td class="$rowtype">$productctrl</td>
		<td class="$rowtype"><textarea cols="25" rows="4" name="salesline_remarks[$i]">$salesline_remarks</textarea></td>
		<td class="$rowtype"><input type="text" size="3" maxlength="10" name="salesline_qty[$i]" value="$salesline_qty" onblur="calculateTotal(document);"></td>
		<td class="$rowtype"><input type="text" size="5" maxlength="10" name="salesline_price[$i]" value="$salesline_price" onblur="calculateTotal(document);parseelement(this);"></td>
		<td class="$rowtype"><input type="text" size="7" maxlength="10" name="salesline_amount[$i]" value="$salesline_amount" readonly></td>
		<td class="$rowtype"><input type="button" value="Delete" onclick="deleteLine($salesline_id);"></td>

	</tr>
EOF;
	}
	if($i == 0){
	echo "<tr><td colspan='8'>Please Add Payment Line.</td></tr>";
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
  public function deleteSales( $productmaster_id ) {
   	$this->log->showLog(2,"Warning: Performing delete product id : $this->sales_id !");
	$sql="DELETE FROM $this->tablesales where sales_id=$this->sales_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: product ($sales_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Sales ($sales_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteSalesMaster


/**
   * Display a product list table
   *
   * 
   * @access public
   */
public function showSalesTable(){
	
	if($this->start_date=="")
	$this->start_date = getMonth(date("Ymd", time()),0) ;
   	
	if($this->end_date=="")
	$this->end_date = getMonth(date("Ymd", time()),1) ;

	$wherestring = " where a.sales_id>0 ";
	
	if($this->fldShow == "Y"){
	$wherestring .= $this->getWhereString();
	$limitno = "";
	}else{
	$limitno = "limit $this->limitauto";
	}

	$this->log->showLog(3,"Showing Sales Table");
	$sql=$this->getSQLStr_AllSales($wherestring," GROUP BY a.sales_id ORDER BY sales_date desc ",$limitno);
	
	$query=$this->xoopsDB->query($sql);

	echo <<< EOF
	<!--<form name="frmNew" action="sales.php" method="POST">
	<table>
	<tr>
	<td><input type="submit" value="New" style='height:40px;'></td>
	</tr>
	</table>
	</form>-->

	<form action="sales.php" method="POST" name="frmSearch">
	<input type="hidden" name="fldShow" value="">
	<input type="hidden" name="action" value="">
	<input type="hidden" value="" name="sales_id">
	<table border='1' cellspacing='3'>
	<tr>
	<td class="head">Payment No</td>
	<td class="even"><input type="text" name="sales_no" value=""></td>
	<td class="head">Customer</td>
	<td class="even">$this->customerctrl</td>
	</tr>

	<tr>
	<td class="head">Product</td>
	<td class="even">$this->productctrl</td>
	<td class="head">Employee</td>
	<td class="even">$this->employeectrl</td>
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
	<td class="head" colspan="4"><input type="button" value="Search" onclick="searchSales();" style='height:40px;'></td>
	</tr>

	</table></form>
	<br>
	
EOF;
	//if($this->fldShow=="Y"){
echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Payment No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Customer</th>
				<th style="text-align:center;">Complete</th>
				<th style="text-align:center;">Amount (RM)</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$sales_id=$row['sales_id'];
		$sales_no=$row['sales_no'];
		$sales_date=$row['sales_date'];
		$sales_totalamount=$row['sales_totalamount'];
		$customer_id=$row['customer_name'];	
		$iscomplete=$row['iscomplete'];
		$isactive=$row['isactive'];

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
			$styleenable2 = "style='display:none'";
		}else{
			$iscomplete="No";
			$styleenable = "style='display:none'";
			$styleenable2 = "";
		}

		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$sales_no</td>
			<td class="$rowtype" style="text-align:center;">$sales_date</td>
			<td class="$rowtype" style="text-align:center;">$customer_id</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">$sales_totalamount</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
			<table>
			<tr>
			<td align="right">
			<form action="payment.php" method="POST" target="_BLANK">
			<input type="image" src="images/edit.gif" name="imgSubmit" title='Edit this record' $styleenable2>
			<input type="hidden" name="sales_id" value="$sales_id">
			<input type="hidden" name="action" value="edit">
			</form>
			</td>
						
			<td $styleenable align="right">
			<form action="payment.php" method="POST" target="_BLANK" onsubmit="return confirm('Enable This Record?')">
			<input type="submit"  name="btnEnable" title='Enable this record' value="Enable" $styleenable>
			<input type="hidden" name="sales_id" value="$sales_id">
			<input type="hidden" name="action" value="enable">
			</form>
			</td>
			<td $styleenable align="right">
			<form action="receipt.php" method="POST" target="BLANK">
			<input type="image" src="images/list.gif" style="height:20px" name="submit" title='View this payment' >
			<input type="hidden" value="$sales_id" name="sales_id">
			</form>
			</td>
			
			<tr>
			</table>
			</td>

		</tr>
EOF;
	}

	if($i==0)
	echo "<tr><td>No record(s) found.</td></tr>";

	echo  "</tbody></table>";

	//}
 }



  public function getWhereString(){
	$retval = "";
	//echo $this->isactive;

	if($this->sales_no != "")
	$retval .= " and a.sales_no LIKE '$this->sales_no' ";
	if($this->customer_id > 0)
	$retval .= " and a.customer_id = '$this->customer_id' ";
 	if($this->product_id > 0)
 	$retval .= " and a.sales_id IN (select sales_id from $this->tablesalesline where product_id = $this->product_id ) ";
 	if($this->employee_id > 0)
 	$retval .= " and a.sales_id IN (select sales_id from $this->tablesalesline where employee_id = $this->employee_id ) ";
	if($this->isactive != "X" && $this->isactive != "")
	$retval .= " and a.isactive = '$this->isactive' ";
	if($this->iscomplete != "X" && $this->iscomplete != "")
	$retval .= " and a.iscomplete = '$this->iscomplete' ";
	if($this->start_date != "" && $this->end_date != "")
	$retval .= " and ( a.sales_date between '$this->start_date' and '$this->end_date' ) ";

	return $retval;
	
  }

/**
   * get latest generated product
   * 
   * return int  sales_id (latest)
   * @access public
   */
  public function getLatestSalesID(){
  	$sql="SELECT MAX(sales_id) as sales_id from $this->tablesales;";
	$this->log->showLog(3, "Retrieveing last product id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['sales_id'];
	else
	return -1;
	

  }


public function getSelectSales($id,$isitem='NY',$calledfunction="") {

	$wherestring="";
	$tablecategory=$this->tableprefix ."simtrain_salescategory";
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

	$sql="SELECT p.sales_id,p.sales_name from $this->tablesales p ".
		"inner join $tablecategory c on c.category_id=p.category_id ".
		"$wherestring or (p.sales_id=$id)) and p.sales_id>0 order by sales_name ;";

	$this->log->showLog(4,"Excute SQL for generate product list: $sql;");
	$selectctl="<SELECT name='sales_id' $calledfunction>";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$sales_id=$row['sales_id'];
		$sales_name=$row['sales_name'];
	
		if($id==$sales_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$sales_id' $selected>$sales_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getSalesPrice($id){
	$this->log->showLog(3,"Retrieving default price for product $id");
	$sql="SELECT sales_name,amt from $this->tablesales where sales_id=$id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$price=$row['amt'];
		$sales_name=$row['sales_name'];
		$this->log->showLog(3,"sales_id: have productname: $sales_name with sales_id: $id");
		return $price;
	
	}
	else
	{
		$this->log->showLog(1,"Error, can't find sales_id: $id");
		return 0;
	}
	


  }
  public function savefile($tmpfile,$newfilename){
	move_uploaded_file($tmpfile, "upload/products/$newfilename");
	$sqlupdate="UPDATE $this->tablesales set filename='$newfilename' where sales_id=$sales_id";
	$qryUpdate=$this->xoopsDB->query($sqlupdate);
  }

  public function deletefile($sales_id){
	$sql="SELECT filename from $this->tablesales where sales_id=$sales_id";
	$query=$this->xoopsDB->query($sql);
	$myfilename="";
	if($row=$this->xoopsDB->fetchArray($query)){
		$myfilename=$row['filename'];
	}
	$myfilename="upload/products/$myfilename";
	$this->log->showLog(3,"This file name: $myfilename");
	unlink("$myfilename ");
	$sqlupdate="UPDATE $this->tablesales set filename='-' where sales_id=$sales_id";
	$qryDelete=$this->xoopsDB->query($sqlupdate);
  }

  public function allowDelete($sales_id){
/*
	$tabletuitionclass = $this->tableprefix."simtrain_tuitionclass";
	$tablepaymentline = $this->tableprefix."simtrain_paymentline";
	$tableinventorymovement = $this->tableprefix."simtrain_inventorymovement";

	$sql="select sum(recordcount) as recordcount from (
		SELECT count(sales_id) as recordcount FROM $tabletuitionclass where sales_id=$sales_id
		UNION 
		SELECT count(sales_id) as recordcount FROM $tablepaymentline where sales_id=$sales_id
		UNION 
		SELECT count(sales_id) as recordcount FROM $tableinventorymovement where sales_id=$sales_id
		) as b1";
	
	$this->log->showLog(3,"Verified allowDelete for sales_id:$sales_id");
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
	
	$sql="SELECT employee_id,employee_name from $this->tableemployee where (isactive='Y' or employee_id=$id)  order by employee_name ";
	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='employee_id[$i]' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$employee_id=$row['employee_id'];
		$employee_name=$row['employee_name'];
	
		if($id==$employee_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$employee_id' $selected>$employee_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getSelectProduct($id,$i) {

	$wherestring="";
	
	$wherestring.=" WHERE p.isactive='Y' ";

	$sql="SELECT p.product_id,p.product_name from $this->tableproduct p ".
		"inner join $this->tablecategory c on c.category_id=p.category_id ".
		"$wherestring or (p.product_id=$id) order by product_name ;";

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


  public function getPriceProduct($id){
	$price = "0.00";
	$sql = "SELECT sellingprice FROM $this->tableproductlist WHERE product_id = $id ";
	
	$query=$this->xoopsDB->query($sql);	
	$this->log->showLog(4,"With SQL: $sql");

	if($row=$this->xoopsDB->fetchArray($query)){
	$price = $row['sellingprice'];
	}
	
	return $price;
  }

  public function getPromotionSQL(){

	$date= date("Y-m-d", time()) ;

	$wherestring = " and ( ";

	if($this->customer_id>0)
	$wherestring .= " a.customer_id = $this->customer_id ";
	

	$sql = "SELECT * FROM $this->tablesalesline WHERE sales_id = $this->sales_id ORDER BY salesline_no ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);

	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$product_id = $row['product_id'];	

	if($product_id>0)
	$wherestring .= " or a.product_id = $product_id ";

	}

	$wherestring .= " or a.promotion_type = 'S' ";
	
	$wherestring .= " ) ";

	$wherestring .= " and a.promotion_expiry >= '$date' ";

	return $wherestring;
  }

  public function enableSales(){

	$sql = "update $this->tablesales set iscomplete = 'N' where sales_id = $this->sales_id ";

	$this->log->showLog(4,"With SQL: $sql");

	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: ($sales_id) cannot enable from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Vinvoice ($sales_id) enabled successfully!");
		return true;
		
	}
  }




} // end of SalesMaster
?>

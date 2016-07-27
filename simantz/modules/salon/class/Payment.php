<?php
/************************************************************************
Class Payment.php - Copyright kfhoo
**************************************************************************/

class Sales
{
  public $sales_id;
  public $sales_no;
  public $sales_date;
  public $sales_totalamount;
  public $sales_paidamount;
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
  public $fldName;
  public $fldIc;
  
  public $isAdmin;
  public $orgctrl;
  public $employeectrl;
  public $customerctrl;
  public $productctrl;

  public $tablesales;
  public $tablesalesline;
  public $tablesalesemployeeline;
  public $tableemployee;
  public $tablecustomer;
  public $tableproduct;
  public $tablecategory;
  public $tableproductlist;
  public $tablepromotion;
  public $tablesaleslist;
 
  public $tableprefix;
  public $filename;

  public $fldShow;
  public $windows_id;

  public function Sales($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablesales=$tableprefix."simsalon_sales";
	$this->tablesalesline=$tableprefix."simsalon_salesline";
	$this->tablesalesemployeeline=$tableprefix."simsalon_salesemployeeline";
	$this->tableemployee=$tableprefix."simsalon_employee";
	$this->tablecustomer=$tableprefix."simsalon_customer";
	$this->tableproduct=$tableprefix."simsalon_productlist";
	$this->tablecategory=$tableprefix."simsalon_productcategory";
	$this->tableproductlist=$tableprefix."simsalon_productlist";
	$this->tablepromotion=$tableprefix."simsalon_promotion";
	$this->tablesaleslist=$tableprefix."simsalon_saleslist";
	$this->log=$log;
  }


  public function insertSales() {
	$this->log->showLog(3,"Creating product SQL:$sql");

	$this->sales_no = getNewCode($this->xoopsDB,"sales_no",$this->tablesales);

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new product $this->sales_no");
	$sql =	"INSERT INTO $this->tablesales 	(sales_no,sales_date,sales_totalamount,sales_paidamount,customer_id,iscomplete,sales_remarks,
							isactive,created,createdby,updated,updatedby) 
							values('$this->sales_no',
								'$timestamp',
								0,
								0,
								$this->customer_id,
								'N',
								'',
		'Y','$timestamp',$this->createdby,'$timestamp',$this->updatedby)";

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

	$sql = "INSERT INTO $this->tablesalesline (salesline_no,sales_id,salesline_qty,salesline_price,salesline_amount,salesline_oprice) values
		($i,$this->sales_id,0,0,0,0)";

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
	$product_id = $this->product_id[$i];
	$salesline_qty = $this->salesline_qty[$i];
	$salesline_price = $this->salesline_price[$i];
	$salesline_amount = $this->salesline_amount[$i];

	$sql = "UPDATE $this->tablesalesline SET
		salesline_no = $salesline_no,
		salesline_remarks = '$salesline_remarks',
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
		sales_paidamount=$this->sales_paidamount,
		customer_id=$this->customer_id,
		iscomplete='$this->iscomplete',
		sales_remarks='$this->sales_remarks',
		updated='$timestamp',updatedby=$this->updatedby,isactive='Y'

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
		$wherestring $orderbystring";

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
    
	$this->log->showLog(3,"Fetching product detail into class Payment.php.<br>");
		
	$sql="SELECT * FROM $this->tablesales
	where sales_id=$sales_id";
	
	$this->log->showLog(4,"Sales->fetchSalesInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->sales_id=$row["sales_id"];
		$this->sales_no=$row["sales_no"];
		$this->sales_date=$row["sales_date"];
		$this->sales_totalamount= $row['sales_totalamount'];
		$this->sales_paidamount= $row['sales_paidamount'];
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


  public function getCustomerForm($action) {
	
	/*
	$styleth = "style='background-color: #be1515; color: #FFFFFF; padding : 2px; vertical-align : middle; font-family: Verdana, Arial, Helvetica, sans-serif;font-weight :bold'";*/

	$stylesearch = "";
	$limit = "";

	if($action!="search"){
	$stylesearch = "style='display:none'";
	$limit = "limit 0";
	}

	$sql = "SELECT * from $this->tablecustomer 
		WHERE customer_name like '%$this->fldName%' 
		and ic_no like '%$this->fldIc%' 
		and customer_id > 0 $limit ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);


echo <<< EOF
	<form name="frmPayment" action="payment.php" method="POST">
	<input type="hidden" name="action">
	<input type="hidden" name="windows_id" value="$this->windows_id">
	<input type="hidden" name="sales_id" value="$this->sales_id">
	<input type="hidden" name="sales_no" value="$this->sales_no">
	<input type="hidden" name="customer_id" value="$this->customer_id">

	<div id="searchFormID" $stylesearch>
	<table border=0 style="width:600px"><!--write search form-->
			
		<tr>
			<th colspan="2" $styleth><font size="4pt">Search Customer</font></th>
		</tr>
		<tr>
			<td class="head" width="150px"><font size="4pt">Name</font></td>
			<td class="even" width="450px"><input name="fldName" size="45" value="$this->fldName"></td>
			<td class="even" rowspan="2"><input type="button" value="Search" style="height:40px" onclick="searchRecord()"></td>
		</tr>
		<tr>
			<td class="head"><font size="4pt">I/C</font></td>
			<td class="even"><input name="fldIc" size="45" value="$this->fldIc"></td>
		</tr>
		<tr>
			<td class="head"><font size="4pt">Customer</font></td>
			<td class="even">$this->customerctrl</td>
		</tr>
		
	</table>
	
	<table border=0><!--write search list-->
		<tr>
			<th width="5%" $styleth><font size="4pt">No</font></th>
			<th width="45%" $styleth><font size="4pt">Customer</font></th>
			<th width="30%" $styleth><font size="4pt">IC No</font></th>
			<th width="10%" $styleth><font size="4pt">Add</font></th>
		</tr>
EOF;
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$customer_name = $row['customer_name'];
	$ic_no = $row['ic_no'];
	$customer_id = $row['customer_id'];
echo <<< EOF
		
		<tr>
		<td class="even"><font size="4pt">$i</font></td>
		<td class="even"><font size="4pt"><a href="customer.php?action=edit&customer_id=$customer_id" target="blank">$customer_name</a></font></td>
		<td class="even" align="center"><font size="4pt">$ic_no</font></td>
		<td class="even" align="center"><input type="button" value="Add" onclick="addList($customer_id)"></td>
		</tr>

EOF;
	}

	if($i==0)
	echo "<tr><td colspan=4 class='even'>Customer Not Found!!.Please Search Again</td></tr>";

echo <<< EOF
		<tr height="40">
			<td colspan="4"><font color=blue onclick="document.getElementById('searchFormID').style.display = 'none'" style="cursor:pointer">
			<u><b>Close Search Form</font></font></u></b></td>
		</tr>
	</table>
	</div><!--end of show search form-->
EOF;

	if($this->windows_id=="")	
	$this->windows_id = date("Ymd", time()).$this->updatedby;
	
	if($this->sales_id=="")	
	$this->sales_id = 0;
	
	$sql = "SELECT * FROM $this->tablesaleslist a, $this->tablesales b, $this->tablecustomer c
	WHERE a.sales_id = b.sales_id
	and b.customer_id = c.customer_id
	and b.customer_id > 0 
	order by a.line";

	/*
 	$sql = "SELECT * FROM $this->tablesaleslist a, $this->tablesales b, $this->tablecustomer c
	WHERE a.windows_id = $this->windows_id
	and a.sales_id = b.sales_id
	and b.customer_id = c.customer_id
	and b.customer_id > 0 
	order by a.line";*/

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);

echo <<< EOF
	<table border=0><!--write customer list-->
	
		<tr>
		<td>	
			<table style="width:10px;background-color:gray"><tr height="30">
EOF;
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$customer_name = $row['customer_name'];
	$windows_id = $row['windows_id'];
	$sales_id = $row['sales_id'];
	$customer_id = $row['customer_id'];

	if($sales_id==$this->sales_id)
	$rowtype = "class='head'";
	else
	$rowtype = "class='even'";

echo <<< EOF
			<td  $rowtype nowrap onclick="getListCustomer($sales_id);" style="cursor:pointer">
			<font size="2pt" color="blue">$customer_name</font></td>
EOF;
	}

	if($i==0)
	echo "<td class='odd' nowrap><font size='2pt' color=red>Please Add New Payment</font></td>";

echo <<< EOF
			</tr></table>
		</td>
		</tr>
	</table>
EOF;

	$customer_name = "";
	$sales_no = "";
	$sales_date = "";
	$sales_totalamount = "0.00";
	$sales_paidamount = "0.00";
	$customer_id = "";
	$sales_remarks = "";

	$sql = "SELECT * FROM $this->tablesales a, $this->tablecustomer b
	WHERE a.customer_id = b.customer_id
	and a.sales_id = $this->sales_id  
	and b.customer_id > 0 ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$customer_name = $row['customer_name'];
	$customer_id = $row['customer_id'];
	$sales_no = $row['sales_no'];
	$sales_date = $row['sales_date'];
	$sales_totalamount = $row['sales_totalamount'];
	$sales_paidamount = $row['sales_paidamount'];
	$sales_remarks = $row['sales_remarks'];
	}

	$sales_change = $sales_paidamount - $sales_totalamount;

	$sales_change = number_format($sales_change, 2, '.','');
	
	$stylefld = "style='border-style:none;font-size:16px;color:blue;font-weight: bold;'";
	$styleamount = "style='border-style:none;font-size:30px;color:black;text-align:right'";
	$styleamount2 = "style='font-size:30px;color:black;text-align:right'";
		
	$stylebtn = "style='height:35px'";
	if($this->sales_id == 0)
	$stylebtn = "style='display:none;'";

echo <<< EOF

	<table border=0><!--write customer name, date and total-->
		<tr>
			<td class="odd" id="idName" width="35%">
			<font size="5pt"><b><a href="customer.php?action=edit&customer_id=$customer_id" target="blank" title="View Customer">$customer_name</a></b></font><br>
			<font size="4pt" color="blue" id="idDate" width="40%">Payment No : <input value="$sales_no" name="sales_no" maxlength='10' size='10' $stylefld class="odd" readonly></font>
			<font size="4pt" color="blue" id="idDate" width="40%"><br>
			Date : </font><input value="$sales_date" name="sales_date" id="sales_date" maxlength='10' size='10' $stylefld class="odd">
			<input name='btnDate' value="Date" type="button" onclick="$this->datectrl">
			</td>
			
			<td class="odd" width="30%" align="center">
			<input type="button" value="New" style="height:35px" onclick="showSearchForm()">
			<input type="button" value="Save" onclick="saveSales($this->sales_id)" $stylebtn>
			<input type="button" value="Delete" onclick="deleteSales($this->sales_id);" $stylebtn>
			<input type="button" value="Complete" onclick="completeSales($this->sales_id)" $stylebtn><br><br><br>
			<a onclick="mainPage();" id=aMain style="cursor:pointer"><< <u>Main Page</u> >></a>
			</td>

			<td class="odd" width="35%" align="right">
			<table border=0>
			<tr align="right">
			<td><font size="5pt" id="idTotal">Total ($this->cur_symbol)</font></td>
			<td><input value="$sales_totalamount" name="sales_totalamount" maxlength='10' size='6' $styleamount class="odd" readonly></td>
			</tr>
			<tr align="right">
			<td><font size="5pt">Paid ($this->cur_symbol)</font></td>
			<td><input value="$sales_paidamount" name="sales_paidamount" maxlength='10' size='6' $styleamount2 class="odd" autocomplete=off onclick="this.select();" onblur="calculateChange(this)"></td>
			</tr>
			<tr align="right">
			<td><font size="5pt">Change ($this->cur_symbol)</font></td>
			<td><input value="$sales_change" name="sales_change" maxlength='10' size='6' $styleamount class="odd" readonly></td>
			</tr>
			
			</table>
			
			</td>
		</tr>

		
	</table>
	<br>

	<table border=1 style="height:460px"><!--write body-->
		<tr height="30">
			<th width="35%" $styleth><font size="4pt">Item</font></th>
			<th width="25%" $styleth><font size="4pt">Info</font></th>
			<th width="40%" $styleth><font size="4pt">Selection</font></th>
		</tr>
		<tr>
			<td class="odd" id="idItem"><iframe id="listitem" src="../listitem.php?sales_id=$this->sales_id" width="100%" height="100%"></iframe></td>
			<td class="odd" id="idInfo"><iframe id="infoitem" src="../infoitem.php?sales_id=$this->sales_id" width="100%" height="100%"></iframe></td>
			<td class="odd" id="idSelection"><iframe id="selectionitem" src="../selectionitem.php?sales_id=$this->sales_id" width="100%" height="100%"></iframe></td>
		</tr>
	</table>

	<table>
	<tr>
		<td width="40%">
			<table border=1><!--write remarks-->
				<tr height="30">
					<th align="left" $styleth><font size="4pt">Remarks</font></th>
				</tr>
				<tr>
					<td class="head" align="left"><textarea name="sales_remarks" cols="80" rows="2">$sales_remarks</textarea></td>
				</tr>
			</table>

		</td>

		<td width="60%">
EOF;
		$this->getPromotionList($action);
echo <<< EOF
		</td>
	</tr>
	</table>
	
	<br>
	</form>
EOF;
	
	
		
  } // end of member function getCustomerForm

  public function insertWindowsLine(){
	$timestamp= date("YmdHis", time()) ;

	$return = 0;
	//$sql = "select * from $this->tablesaleslist where sales_id = $this->sales_id and windows_id = '".$timestamp."1' ";
	$sql = "select * from $this->tablesaleslist where sales_id = $this->sales_id  ";
	
	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$return = 1;
	}
	
	if($return == 0){
	
	if($this->windows_id==0)
	$this->windows_id = $timestamp;

	$sql = "insert into $this->tablesaleslist (windows_id,sales_id) values ($this->windows_id,$this->sales_id) ";
	
	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	}
	
	return true;

  }




  public function getSalesInfo($fld){
	$retval =0;
	
	$sql = "SELECT $fld as fld FROM $this->tablesales a, $this->tablecustomer b
	WHERE a.sales_id = $this->sales_id
	and a.customer_id = b.customer_id ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['fld'];
	}
	
	return $retval;
	
  }

  public function getItemList($type){

	$sql = "SELECT * FROM $this->tablesalesline a, $this->tableemployee b, $this->tableproductlist c
	WHERE a.sales_id = $this->sales_id
	and a.employee_id = b.employee_id 
	and a.product_id = c.product_id ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	

  }
  

  public function getPromotionList(){
	
	$wherestring = $this->getPromotionSQL();
	$wherestring .= " and a.product_id = b.product_id ";
	$sql = "SELECT a.promotion_desc,a.promotion_type,a.promotion_price,a.promotion_expiry,b.product_name   
		FROM $this->tablepromotion a, $this->tableproductlist b, $this->tablesales c, $this->tablesalesline d 
		WHERE a.product_id = d.product_id and c.sales_id = d.sales_id and b.product_id = a.product_id 
		$wherestring 
		GROUP BY a.product_id ";
	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	/*
	$styleth = "style='background-color: #be1515; color: #FFFFFF; padding : 2px; vertical-align : middle; font-family: Verdana, Arial, Helvetica, sans-serif;font-weight :bold'";
	*/


echo <<< EOF

	<table border=1>
		<tr height="30" align="center">
		<th colspan="5"><font size="4pt">List Of Promotion!!!</font></th>
		</tr>
		
		<tr>
		<td class="head" align="center" width="10%">No</td>
		<td class="head" align="center" width="45%">Description</td>
		<td class="head" align="center" width="15%">Type</td>
		<td class="head" align="center" width="15%">Price (RM)</td>
		<td class="head" align="center" width="15%">Expiry Date</td>
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
		else if($promotion_type=="P")
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
		<th $styleth>No</th>
		<th $styleth>Seq</th>
		<th $styleth>Employee</th>
		<th $styleth>Product</th>
		<th $styleth>Remarks</th>
		<th $styleth>Qty</th>
		<th $styleth>Price</th>
		<th $styleth>Amount (RM)</th>
		<th $styleth></th>
	</tr>
	
EOF;

	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	
	$salesline_id = $row['salesline_id'];
	$salesline_no = $row['salesline_no'];
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
  public function deleteSales() {
   	$this->log->showLog(2,"Warning: Performing delete product id : $this->sales_id !");
	
	$sqlline="DELETE FROM $this->tablesalesline where sales_id=$this->sales_id";
	$sqlsales="DELETE FROM $this->tablesales where sales_id=$this->sales_id";
	$sqllist="DELETE FROM $this->tablesaleslist where sales_id=$this->sales_id";

	$this->log->showLog(4,"Delete SQL Statement: $sql");

	
	$rs=$this->xoopsDB->query($sqlline);
	if (!rs){
		$this->log->showLog(1,"Error: product ($sales_id) cannot remove from database!");
		return false;
	}
	else{
		$rs=$this->xoopsDB->query($sqlsales);
		if (!rs){
		$this->log->showLog(1,"Error: product ($sales_id) cannot remove from database!");
		return false;
		}else{
			$rs=$this->xoopsDB->query($sqllist);
			if (!rs){
			$this->log->showLog(1,"Error: product ($sales_id) cannot remove from database!");
			}else{
			$this->log->showLog(3,"Sales ($sales_id) removed from database successfully!");
			return true;
			}

		}
		
	}
  } // end of member function deleteSalesMaster

  public function completeSales() {
   	$this->log->showLog(2,"Warning: Performing compete sales id : $this->sales_id !");
	
	$sqlcomplete="UPDATE $this->tablesales SET iscomplete = 'Y' where sales_id=$this->sales_id";
	$sqllist="DELETE FROM $this->tablesaleslist where sales_id=$this->sales_id";

	$this->log->showLog(4,"Delete SQL Statement: $sql");

	
	$rs=$this->xoopsDB->query($sqlcomplete);
	if (!rs){
		$this->log->showLog(1,"Error: product ($sales_id) cannot update from database!");
		return false;
	}
	else{
		$rs=$this->xoopsDB->query($sqllist);
		if (!rs){
		$this->log->showLog(1,"Error: product ($sales_id) cannot remove from database!");
		return false;
		}else{
		$this->log->showLog(3,"Sales ($sales_id) removed from database successfully!");
		return true;
		}
		
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
	
	$wherestring .= $this->getWhereString();

	$this->log->showLog(3,"Showing Sales Table");
	$sql=$this->getSQLStr_AllSales($wherestring," GROUP BY a.sales_id ORDER BY sales_date desc ",0);
	
	$query=$this->xoopsDB->query($sql);

	echo <<< EOF
	<form name="frmNew" action="payment.php" method="POST">
	<table>
	<tr>
	<td><input type="submit" value="New" style='height:40px;'></td>
	</tr>
	</table>
	</form>

	<form action="payment.php" method="POST" name="frmSearch">
	<input type="hidden" name="fldShow" value="">
	<input type="hidden" name="action" value="">
	<input type="hidden" value="" name="sales_id">
	<table border='1' cellspacing='3'>
	<tr>
	<td class="head">Sales Code</td>
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
	if($this->fldShow=="Y"){
echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Code</th>
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

		if($iscomplete=="Y")
			$iscomplete="Yes";
		else
			$iscomplete="No";

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
			
			<form action="payment.php" method="POST">
			<input type="image" src="images/edit.gif" name="imgSubmit" title='Edit this record'>
			<input type="hidden" name="sales_id" value="$sales_id">
			<input type="hidden" name="action" value="edit">
			</form>
			</td>

		</tr>
EOF;
	}

	if($i==0)
	echo "<tr><td>No record(s) found.</td></tr>";

	echo  "</tbody></table>";

	}
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
	

	$sql = "SELECT b.product_id FROM $this->tablesales a ,$this->tablesalesline b, $this->tablepromotion c  
		WHERE a.sales_id = b.sales_id 
		and b.product_id = c.product_id 
		and a.sales_date >= c.promotion_effective
		and a.sales_id = $this->sales_id 
		and b.product_id > 0 
		GROUP BY b.product_id 
		ORDER BY b.salesline_no ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);

	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$product_id = $row['product_id'];	

	if($product_id>0)
	$wherestring .= " or a.product_id = $product_id ";

	}

	//$wherestring .= " or a.promotion_type = 'S' ";
	
	$wherestring .= " ) ";

	//$wherestring .= " and a.promotion_expiry >= '$date' ";
	//$wherestring .= " and c.sales_date >= a.promotion_effective ";
	$wherestring .= " and a.promotion_expiry >= c.sales_date ";
	$wherestring .= " and a.promotion_type <> 'F' ";
	$wherestring .= " or ( a.promotion_type = 'S' and c.sales_date >= a.promotion_effective and promotion_expiry >= c.sales_date) ";

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
  
  public function checkEmployeeLine($sales_id){
  
  $cnt = 0;
   $sql = 	"select count(*) as cnt from $this->tablesales a, $this->tablesalesline b, $this->tablesalesemployeeline c 
  			where a.sales_id = b.sales_id 
			and b.salesline_id = c.salesline_id 
			and a.sales_id = $sales_id 
			and c.employee_id = 0 ";
			
	$query=$this->xoopsDB->query($sql);	
	$this->log->showLog(4,"With SQL: $sql");

	if($row=$this->xoopsDB->fetchArray($query)){
	$cnt = $row['cnt'];
	}
	
	return $cnt;
	
  }




} // end of SalesMaster
?>


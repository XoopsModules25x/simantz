<?php
/************************************************************************
Class Purchasestock.php - Copyright kfhoo
**************************************************************************/

class Purchasestock
{
  public $expenses_id;
  public $expenses_no;
  public $expenses_date;
  public $expenses_totalamount;
  public $expenses_remarks;
  public $receivebyname;
  public $start_date;
  public $end_date;
  public $productctrl;
  public $categoryctrl;
  public $expensesline_id;
  public $expensesline_no;
  public $expenseslist_id;
  public $expensesline_remarks;
  public $expensesline_qty;
  public $expensesline_price;
  public $expensesline_amount;

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
  public $expensesctrl;

  public $tableexpenses;
  public $tableexpensesline;
  public $tableemployee;
  public $tablevendor;
  public $tableterms;
  public $tableexpenseslist;
  public $tableexpensescategory;


  public $tableprefix;
  public $filename;

  public $fldShow;

  public function Purchasestock($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableexpenses=$tableprefix."simsalon_expenses";
	$this->tableexpensesline=$tableprefix."simsalon_expensesline";
	$this->tableemployee=$tableprefix."simsalon_employee";
	$this->tablevendor=$tableprefix."simsalon_vendor";
	$this->tableexpenseslist=$tableprefix."simsalon_expenseslist";
	$this->tableexpensescategory=$tableprefix."simsalon_expensescategory";
	$this->tableterms=$tableprefix."simsalon_terms";
	$this->log=$log;
  }


  public function insertPurchasestock( ) {
	$this->log->showLog(3,"Creating expenseslist SQL:$sql");

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new expenseslist $this->expenses_no");
	$sql =	"INSERT INTO $this->tableexpenses 	(expenses_no,expenses_date,expenses_totalamount,iscomplete,expenses_remarks,
								isactive,created,createdby,updated,updatedby) 
							values('$this->expenses_no',
								'$this->expenses_date',
								$this->expenses_totalamount,
								'$this->iscomplete',
								'$this->expenses_remarks',
		'$this->isactive','$timestamp',$this->createdby,'$timestamp',$this->updatedby)";

	$this->log->showLog(4,"Before insert expenseslist SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert expenses name '$expenses_no'");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new expenses name '$expenses_no' successfully"); 
		return true;
	}
  } // end of member function insertClassMaster


  public function insertLine($row){
	$i = $this->getLatestLine("expensesline_no");
	
	$row += $i;

	while($i<$row){
	$i++;

	$sql = "INSERT INTO $this->tableexpensesline (expensesline_no,expenses_id,expensesline_qty,expensesline_price,expensesline_amount) values
		($i,$this->expenses_id,0,0,0)";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update expenses failed");
		return false;
	}

	}

	return true;

  }

  public function updateLine(){
	$row = count($this->expensesline_id);
	
	$i=0;
	while($i<$row){
	$i++;
	
	$expensesline_id = $this->expensesline_id[$i] ;
	$expensesline_no = $this->expensesline_no[$i] ;
	$expensesline_remarks = $this->expensesline_remarks[$i];
	$expenseslist_id = $this->expenseslist_id[$i];
	$expensesline_qty = $this->expensesline_qty[$i];
	$expensesline_price = $this->expensesline_price[$i];
	$expensesline_amount = $this->expensesline_amount[$i];

	$sql = "UPDATE $this->tableexpensesline SET
		expensesline_no = $expensesline_no,
		expensesline_remarks = '$expensesline_remarks',
		expenseslist_id = $expenseslist_id,
		expensesline_qty = $expensesline_qty,
		expensesline_price = $expensesline_price,
		expensesline_amount = $expensesline_amount
		WHERE expenses_id = $this->expenses_id and expensesline_id = $expensesline_id";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update expenses failed");
		return false;
	}

	}

	return true;

  }


  public function deleteLine($line){
	$sql = "DELETE FROM $this->tableexpensesline WHERE expensesline_id = $line and expenses_id = $this->expenses_id ";


	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update expenses failed");
		return false;
	}else{
		$this->updateTotalAmount();
		$this->log->showLog(2, "Update expenses Successfully");
		return true;
	}

  }

  public function updateTotalAmount(){

	$sql = "UPDATE $this->tableexpenses SET expenses_totalamount = COALESCE((SELECT sum(expensesline_amount) as total FROM $this->tableexpensesline 
								 WHERE expenses_id = $this->expenses_id),0) 
		WHERE expenses_id = $this->expenses_id";
	
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update expenses failed");
		return false;
	}else{
		$this->log->showLog(2, "Update expenses Successfully");
		return true;
	}
  }

  /**
   * Update class information
   *
   * @return bool
   * @access public
   */
  public function updatePurchasestock() {
    $timestamp= date("y/m/d H:i:s", time()) ;
	$sql="";
	
 	$sql=	"UPDATE $this->tableexpenses SET
		expenses_no='$this->expenses_no',
		expenses_date='$this->expenses_date',
		expenses_totalamount=$this->expenses_totalamount,
		iscomplete='$this->iscomplete',
		expenses_remarks='$this->expenses_remarks',
		updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive'

		WHERE expenses_id='$this->expenses_id'";

	$this->log->showLog(3, "Update expenses_id: $this->expenses_id, '$this->expenses_name'");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update expenses failed");
		return false;
	}
	else{
		$this->updateLine();
		$this->log->showLog(3, "Update expenses successfully.");
		return true;
	}
  } // end of member function updateClass

  public function getLatestLine($fld){
	$retval = 0;
	$sql = "SELECT $fld from $this->tableexpensesline where expenses_id = $this->expenses_id ORDER BY expensesline_no DESC";

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
  public function getSqlStr_AllPurchasestock( $wherestring,  $orderbystring,  $startlimitno ) {
  
	$wherestring .= " ";

 	$sql= 	"SELECT * FROM $this->tableexpenses a 
		$wherestring $orderbystring";

   $this->log->showLog(4,"Running Purchasestock->getSQLStr_AllPurchasestock: $sql");
  return $sql;
  } // end of member function getSqlStr_AllClass

  /**
   * pull data from database into class.
   *
   * @param int masterclass_id 
   * @return bool
   * @access public
   */
  public function fetchPurchasestockInfo( $expenses_id ) {
    
	$this->log->showLog(3,"Fetching expenseslist detail into class Purchasestock.php.<br>");
		
	$sql="SELECT * FROM $this->tableexpenses
	where expenses_id=$expenses_id";
	
	$this->log->showLog(4,"Purchasestock->fetchPurchasestockInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->expenses_id=$row["expenses_id"];
		$this->expenses_no=$row["expenses_no"];
		$this->expenses_date=$row["expenses_date"];
		$this->expenses_totalamount= $row['expenses_totalamount'];
		$this->expenses_remarks=$row['expenses_remarks'];
		$this->iscomplete=$row['iscomplete'];
		$this->isactive=$row['isactive'];
	
	   	$this->log->showLog(4,"Purchasestock->fetchPurchasestockInfo,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Purchasestock->fetchPurchasestockInfo,failed to fetch data into databases.");	
	}
  } // end of member function fetchPurchasestockInfo


  public function getInputForm( $type,  $expenses_id,$token ) {
	$filectrl="";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$uploadctrl="";
	$displayadd="";
	$stylecomplete = "";

	$timestamp= date("Y-m-d", time()) ;

	if ($type=="new"){
		$header="New Organization";
		$action="create";
		$btnsave = "Next";
		$stylecomplete = "style='display:none'";
		if($expenses_id==0){
		$this->expenses_no="";
		}
		$this->expenses_date = $timestamp;

		$savectrl="<input style='height:40px;' name='btnSave' value='$btnsave' type='submit'>";
		$checked="CHECKED";
		$checked2="";
		$deletectrl="";
		$addnewctrl="";
		$this->expenses_totalamount=0;
		$displayadd="style='display:none'";

		$this->expenses_no = getNewCode($this->xoopsDB,"expenses_no",$this->tableexpenses);

		
	}
	else
	{
		$action="update";

		//force iscomplete checkbox been checked if the value in db is 'Y'
		if ($this->iscomplete=='Y'){
			$checked2="CHECKED";
			$btnsave = "Complete";
		}else{
			$checked2="";
			$btnsave = "Save";
		}

		$savectrl="<input name='expenses_id' value='$this->expenses_id' type='hidden'>".
			 "<input style='height:40px;' name='btnSave' value='$btnsave' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableexpenses' type='hidden'>".
		"<input name='id' value='$this->expenses_id' type='hidden'>".
		"<input name='idname' value='expenses_id' type='hidden'>".
		"<input name='title' value='Purchasestock' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		


		$header="Edit Purchasestock";
		if($this->allowDelete($this->expenses_id) && $this->expenses_id>0)
		$deletectrl="<FORM action='expenses.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this expenseslist?"'.")'><input style='height:40px;' type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->expenses_id' name='expenses_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

		$addnewctrl="<form action='expenses.php' method='post'><input type='submit' value='New' value='New' style='height:40px;'></form>";
			

	}

echo <<< EOF

<table style="width:300px;"><td><form onsubmit="return validatePurchasestock()" method="post"
 	action="expenses.php" name="frmPurchasestock"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset" style='height:40px;'>
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
      <td class="odd"><input name="expenses_no" value="$this->expenses_no" maxlength='10' size='10'></td>
      <td class="head">Active</td>
      <td class="even"><input type="checkbox" $checked name="isactive" ></td>
    </tr>
  <tbody>

    <tr>
		<td class="head">Date</td>
		<td class="odd">
		<input name='expenses_date' id='expenses_date' value="$this->expenses_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->datectrl">
		</td>
		<td class="head">Remarks</td>
      	<td class="even" ><textarea name="expenses_remarks" cols="40" rows="4">$this->expenses_remarks</textarea></td>
    </tr>
	
	
    <tr>
		<td class="head">Total Amount (RM)</td>
      	<td class="odd"><input name="expenses_totalamount" value="$this->expenses_totalamount" maxlength='10' size='10' readonly></td>
		<td class="head"><div $stylecomplete>Complete</div></td>
      	<td class="even"><input type="checkbox" $checked2 name="iscomplete" onclick="completePurchasestock(this.checked)" $stylecomplete></td>
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
<table style="width:300px">
<tr $displayadd>
	<td class="head">List Purchasestock :</td>
	<td class="odd">
	<input type="text" name="fldPayment" size="5" maxlength="5">
	<input type="button" value="Add" onclick="addPayment();">
	
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

	$sql = "SELECT * FROM $this->tableexpensesline WHERE expenses_id = $this->expenses_id ORDER BY expensesline_no ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);

echo <<< EOF
	<table border=1>
	<tr align="center">
		<th>No</th>
		<th>Seq</th>
		<th>Purchasestock</th>
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
	
	$expensesline_id = $row['expensesline_id'];
	$expensesline_no = $row['expensesline_no'];
	$expenseslist_id = $row['expenseslist_id'];
	
	$expensesline_remarks = $row['expensesline_remarks'];
	$expensesline_qty = $row['expensesline_qty'];
	$expensesline_price = $row['expensesline_price'];
	$expensesline_amount = $row['expensesline_amount'];

	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

//	$employeectrl = $this->getEmployeeListArray($expensesline_discount,$i);
	$expensesctrl = $this->getSelectPurchasestocklist($expenseslist_id,$i);


echo <<< EOF
	<input type="hidden" name="expensesline_id[$i]" value="$expensesline_id">
	<tr align="center">
		<td class="$rowtype">$i</td>
		<td class="$rowtype"><input type="text" size="3" maxlength="5" name="expensesline_no[$i]" value="$expensesline_no"></td>
		<td class="$rowtype">$expensesctrl</td>
		<td class="$rowtype"><textarea cols="25" rows="4" name="expensesline_remarks[$i]">$expensesline_remarks</textarea></td>
		<td class="$rowtype"><input type="text" size="3" maxlength="10" name="expensesline_qty[$i]" value="$expensesline_qty" onblur="calculateTotal(document);"></td>
		<td class="$rowtype"><input type="text" size="5" maxlength="100" name="expensesline_price[$i]" value="$expensesline_price" onblur="calculateTotal(document);parseelement(this);"></td>
		<td class="$rowtype"><input type="text" size="7" maxlength="10" name="expensesline_amount[$i]" value="$expensesline_amount" readonly></td>
		<td class="$rowtype"><input type="button" value="Delete" onclick="deleteLine($expensesline_id);"></td>

	</tr>
EOF;
	}
	if($i == 0){
	echo "<tr><td colspan='8'>Please Add Purchasestock Line.</td></tr>";
	}

echo <<< EOF
</table>
EOF;

	
  }

  /**
   *
   * @param int expenseslistmaster_id 
   * @return bool
   * @access public
   */
  public function deletePurchasestock( $expenseslistmaster_id ) {
   	$this->log->showLog(2,"Warning: Performing delete expenseslist id : $this->expenses_id !");
	$sql="DELETE FROM $this->tableexpenses where expenses_id=$this->expenses_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: expenseslist ($expenses_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Purchasestock ($expenses_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deletePurchasestockMaster


/**
   * Display a expenseslist list table
   *
   * 
   * @access public
   */
public function showPurchasestockTable(){
	if($this->start_date=="")
	$this->start_date = getMonth(date("Ymd", time()),0) ;
   	
	if($this->end_date=="")
	$this->end_date = getMonth(date("Ymd", time()),1) ;

	$wherestring = " where a.expenses_id>0 ";
	
	$wherestring .= $this->getWhereString();

	$this->log->showLog(3,"Showing Purchasestock Table");
	$sql=$this->getSQLStr_AllPurchasestock($wherestring," GROUP BY a.expenses_id ORDER BY expenses_date desc ",0);
	
	$query=$this->xoopsDB->query($sql);
	$prdctrl="";
	$catctrl="";
	echo <<< EOF
	

	<form action="purchasestockrpt.php" method="POST" name="frmSearch" onsubmit="return validateRpt();" target="_BLANK">
	<input type="hidden" name="fldShow" value="">
	<input type="hidden" name="action" value="">
	<input type="hidden" value="" name="expenses_id">
	<table border='1' cellspacing='3'>
	
	
	<tr style="display:none">
	<td class="head">Date From (YYYY-MM-DD)</td>
	<td class="even">
	<input name='start_date' id='start_date' value="$this->start_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->startctrl"> 
	</td><td class="head">Date To (YYYY-MM-DD) </td><td class="even"> 
	<input name='end_date' id='end_date' value="$this->end_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->endctrl">
	</td>
	</tr>
	
	<tr>
	<td class="head">Product Code</td>
	<td class="even" colspan="3"><input name="product_no" ></td>
	</tr>

	<tr>
	<td class="head">Product</td>
	<td class="even">$this->productctrl</td>
	<td class="head">Product Category</td>
	<td class="even">$this->categoryctrl</td>
	</tr>
	
	<tr style="display:none">
	<td class="head">Type</td>
	<td class="even" colspan="3">
		<SELECT name='isitem'>
			<option value='' ></option>
			<option value='N' >Products</option>
			<option value='C' >Services</option>
			<option value='Y' >Others</option>
		</SELECT>
	</td>
	</tr>
	
	<tr>
	<td class="head" colspan="4"><input type="submit" value="View"  style='height:40px;'></td>
	</tr>

	</table></form>
	<br>
	
EOF;

 }



  public function getWhereString(){
	$retval = "";
	//echo $this->isactive;

	if($this->expenses_no != "")
	$retval .= " and a.expenses_no LIKE '$this->expenses_no' ";
 	if($this->expenseslist_id > 0)
 	$retval .= " and a.expenses_id IN (select expenses_id from $this->tableexpensesline where expenseslist_id = $this->expenseslist_id ) ";

	if($this->isactive != "X" && $this->isactive != "")
	$retval .= " and a.isactive = '$this->isactive' ";
	if($this->iscomplete != "X" && $this->iscomplete != "")
	$retval .= " and a.iscomplete = '$this->iscomplete' ";
	if($this->start_date != "" && $this->end_date != "")
	$retval .= " and ( a.expenses_date between '$this->start_date' and '$this->end_date' ) ";

	return $retval;
	
  }

/**
   * get latest generated expenseslist
   * 
   * return int  expenses_id (latest)
   * @access public
   */
  public function getLatestPurchasestockID(){
  	$sql="SELECT MAX(expenses_id) as expenses_id from $this->tableexpenses;";
	$this->log->showLog(3, "Retrieveing last expenseslist id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['expenses_id'];
	else
	return -1;
	

  }


public function getSelectPurchasestock($id,$isitem='NY',$calledfunction="") {

	$wherestring="";
	$tableexpensescategory=$this->tableprefix ."simtrain_expensescategory";
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

	$sql="SELECT p.expenses_id,p.expenses_name from $this->tableexpenses p ".
		"inner join $tableexpensescategory c on c.category_id=p.category_id ".
		"$wherestring or (p.expenses_id=$id)) and p.expenses_id>0 order by expenses_name ;";

	$this->log->showLog(4,"Excute SQL for generate expenseslist list: $sql;");
	$selectctl="<SELECT name='expenses_id' $calledfunction>";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$expenses_id=$row['expenses_id'];
		$expenses_name=$row['expenses_name'];
	
		if($id==$expenses_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$expenses_id' $selected>$expenses_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getPurchasestockPrice($id){
	$this->log->showLog(3,"Retrieving default price for expenseslist $id");
	$sql="SELECT expenses_name,amt from $this->tableexpenses where expenses_id=$id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$price=$row['amt'];
		$expenses_name=$row['expenses_name'];
		$this->log->showLog(3,"expenses_id: have expenseslistname: $expenses_name with expenses_id: $id");
		return $price;
	
	}
	else
	{
		$this->log->showLog(1,"Error, can't find expenses_id: $id");
		return 0;
	}
	


  }
  public function savefile($tmpfile,$newfilename){
	move_uploaded_file($tmpfile, "upload/expenseslists/$newfilename");
	$sqlupdate="UPDATE $this->tableexpenses set filename='$newfilename' where expenses_id=$expenses_id";
	$qryUpdate=$this->xoopsDB->query($sqlupdate);
  }

  public function deletefile($expenses_id){
	$sql="SELECT filename from $this->tableexpenses where expenses_id=$expenses_id";
	$query=$this->xoopsDB->query($sql);
	$myfilename="";
	if($row=$this->xoopsDB->fetchArray($query)){
		$myfilename=$row['filename'];
	}
	$myfilename="upload/expenseslists/$myfilename";
	$this->log->showLog(3,"This file name: $myfilename");
	unlink("$myfilename ");
	$sqlupdate="UPDATE $this->tableexpenses set filename='-' where expenses_id=$expenses_id";
	$qryDelete=$this->xoopsDB->query($sqlupdate);
  }

  public function allowDelete($expenses_id){
/*
	$tabletuitionclass = $this->tableprefix."simtrain_tuitionclass";
	$tablepaymentline = $this->tableprefix."simtrain_paymentline";
	$tableinventorymovement = $this->tableprefix."simtrain_inventorymovement";

	$sql="select sum(recordcount) as recordcount from (
		SELECT count(expenses_id) as recordcount FROM $tabletuitionclass where expenses_id=$expenses_id
		UNION 
		SELECT count(expenses_id) as recordcount FROM $tablepaymentline where expenses_id=$expenses_id
		UNION 
		SELECT count(expenses_id) as recordcount FROM $tableinventorymovement where expenses_id=$expenses_id
		) as b1";
	
	$this->log->showLog(3,"Verified allowDelete for expenses_id:$expenses_id");
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
	
	$sql="SELECT expensesline_discount,employee_name from $this->tableemployee where (isactive='Y' or expensesline_discount=$id)  order by employee_name ";
	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='expensesline_discount[$i]' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$expensesline_discount=$row['expensesline_discount'];
		$employee_name=$row['employee_name'];
	
		if($id==$expensesline_discount)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$expensesline_discount' $selected>$employee_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getSelectPurchasestocklist($id,$i) {

	$wherestring="";
	
	$wherestring.=" WHERE p.isactive='Y' ";

	$sql="SELECT p.expenseslist_id,p.expenseslist_name from $this->tableexpenseslist p ".
		"inner join $this->tableexpensescategory c on c.category_id=p.category_id ".
		"$wherestring or (p.expenseslist_id=$id) order by expenseslist_name ;";

	$this->log->showLog(4,"Excute SQL for generate expenseslist list: $sql;");
	$selectctl="<SELECT name='expenseslist_id[$i]' id=name='expenseslist_id[$i]' onchange='getPrice($i,this.value);'>";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$expenseslist_id=$row['expenseslist_id'];
		$expenseslist_name=$row['expenseslist_name'];
	
		if($id==$expenseslist_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$expenseslist_id' $selected>$expenseslist_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end


  public function getPricePurchasestocklist($id){
	$price = "0.00";
	$sql = "SELECT amt FROM $this->tableexpenseslist WHERE expenseslist_id = $id ";
	
	$query=$this->xoopsDB->query($sql);	
	$this->log->showLog(4,"With SQL: $sql");

	if($row=$this->xoopsDB->fetchArray($query)){
	$price = $row['amt'];
	}
	
	return $price;
  }




} // end of PurchasestockMaster
?>

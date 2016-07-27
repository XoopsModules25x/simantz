<?php
/************************************************************************
Class Expenses.php - Copyright kfhoo
**************************************************************************/

class Expenses
{
  public $expenses_id;
  public $expenses_no;
  public $expenses_date;
  public $expenses_totalamount;
  public $expenses_remarks;
  public $expenses_qty;
  public $expenses_price;
  public $receivebyname;
  public $start_date;
  public $end_date;

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
  public $tableuom;


  public $tableprefix;
  public $filename;

  public $fldShow;

  public function Expenses($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableexpenses=$tableprefix."simsalon_expenses";
	$this->tableexpensesline=$tableprefix."simsalon_expensesline";
	$this->tableemployee=$tableprefix."simsalon_employee";
	$this->tablevendor=$tableprefix."simsalon_vendor";
	$this->tableexpenseslist=$tableprefix."simsalon_expenseslist";
	$this->tableexpensescategory=$tableprefix."simsalon_expensescategory";
	$this->tableterms=$tableprefix."simsalon_terms";
	$this->tableuom=$tableprefix."simsalon_uom";
	$this->log=$log;
  }


  public function insertExpenses( ) {
	$this->log->showLog(3,"Creating expenseslist SQL:$sql");

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new expenseslist $this->expenses_no");
	$sql =	"INSERT INTO $this->tableexpenses 	(expenses_no,expenses_date,expenses_totalamount,expenseslist_id,
							expenses_qty,expenses_price,
							iscomplete,expenses_remarks,
								isactive,created,createdby,updated,updatedby) 
							values('$this->expenses_no',
								'$this->expenses_date',
								$this->expenses_totalamount,
								$this->expenseslist_id,
								$this->expenses_qty,
								$this->expenses_price,
								'Y',
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
  public function updateExpenses() {
    $timestamp= date("y/m/d H:i:s", time()) ;
	$sql="";
	
 	$sql=	"UPDATE $this->tableexpenses SET
		expenses_no='$this->expenses_no',
		expenses_date='$this->expenses_date',
		expenses_totalamount=$this->expenses_totalamount,
		expenseslist_id=$this->expenseslist_id,
		expenses_qty=$this->expenses_qty,
		expenses_price=$this->expenses_price,
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
		//$this->updateLine();
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
  public function getSqlStr_AllExpenses( $wherestring,  $orderbystring,  $startlimitno ) {
  
	$wherestring .= " and a.expenseslist_id = b.expenseslist_id ";

 	$sql= 	"SELECT *,a.isactive as isactive_m FROM $this->tableexpenses a, $this->tableexpenseslist b  
		$wherestring $orderbystring";

   $this->log->showLog(4,"Running Expenses->getSQLStr_AllExpenses: $sql");
  return $sql;
  } // end of member function getSqlStr_AllClass

  /**
   * pull data from database into class.
   *
   * @param int masterclass_id 
   * @return bool
   * @access public
   */
  public function fetchExpensesInfo( $expenses_id ) {
    
	$this->log->showLog(3,"Fetching expenseslist detail into class Expenses.php.<br>");
		
	$sql="SELECT * FROM $this->tableexpenses
	where expenses_id=$expenses_id";
	
	$this->log->showLog(4,"Expenses->fetchExpensesInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->expenses_id=$row["expenses_id"];
		$this->expenses_no=$row["expenses_no"];
		$this->expenses_date=$row["expenses_date"];
		$this->expenses_totalamount= $row['expenses_totalamount'];
		$this->expenseslist_id= $row['expenseslist_id'];
		$this->expenses_price= $row['expenses_price'];
		$this->expenses_qty= $row['expenses_qty'];
		$this->expenses_remarks=$row['expenses_remarks'];
		$this->iscomplete=$row['iscomplete'];
		$this->isactive=$row['isactive'];
	
	   	$this->log->showLog(4,"Expenses->fetchExpensesInfo,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Expenses->fetchExpensesInfo,failed to fetch data into databases.");	
	}
  } // end of member function fetchExpensesInfo


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
		$btnsave = "Save";
		$stylecomplete = "style='display:none'";
		$this->expenses_remarks = "";
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
		$this->expenses_qty=1;
		$this->expenses_price=0;
		$this->expenseslist_id=0;
		$displayadd="style='display:none'";

		$this->expenses_no = getNewCode($this->xoopsDB,"expenses_no",$this->tableexpenses);

		
	}
	else
	{
		$action="update";

		//force iscomplete checkbox been checked if the value in db is 'Y'
		if ($this->iscomplete=='Y'){
			$checked2="CHECKED";
			$btnsave = "Save";
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
		"<input name='title' value='Expenses' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		


		$header="Edit Expenses";
		if($this->allowDelete($this->expenses_id) && $this->expenses_id>0)
		$deletectrl="<FORM action='expenses.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this expenseslist?"'.")'><input style='height:40px;' type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->expenses_id' name='expenses_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

		$addnewctrl="<form action='expenses.php' method='post'><input type='submit' value='New' value='New' style='height:40px;'></form>";
			

	}


	$expensesctrl = $this->getSelectExpenseslist($this->expenseslist_id);
	$uom = $this->getPriceExpenseslist($this->expenseslist_id,"uom_description");

echo <<< EOF

<table style="width:300px;">$recordctrl<tbody><td>$addnewctrl</td><td>$deletectrl</td><td><form onsubmit="return validateExpenses()" method="post"
 	action="expenses.php" name="frmExpenses"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset" style='height:40px;'>
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
	<td class="head">Expenses No</td>
	<td class="odd"><input name="expenses_no" value="$this->expenses_no" maxlength='10' size='10'>
	&nbsp;&nbsp;Active&nbsp;&nbsp;<input type="checkbox" $checked name="isactive" >
	</td>
	<td class="head">Date</td>
	<td class="odd">
	<input name='expenses_date' id='expenses_date' value="$this->expenses_date" maxlength='10' size='10'>
	<input name='btnDate' value="Date" type="button" onclick="$this->datectrl">
	</td>
    </tr>
  <tbody>

	
	<tr>
	<td class="head">Expenses</td>
	<td class="even">$expensesctrl</td>
	<td class="head">Quantity</td>
	<td class="even"><input name="expenses_qty" value="$this->expenses_qty" maxlength='10' size='5' onblur="calculateTotal(document)"><div id='uomID'>$uom</div></td>
	</tr>

	<tr>
	<td class="head">Price ($this->cur_symbol)</td>
	<td class="odd"><input name="expenses_price" value="$this->expenses_price" maxlength='10' size='5' onblur="calculateTotal(document);parseelement(this);"></td>
	<td class="head">Total Amount ($this->cur_symbol)</td>
	<td class="odd"><input name="expenses_totalamount" value="$this->expenses_totalamount" maxlength='10' size='10' readonly></td>
	</tr>
	
	<tr>
	<td class="head">Remarks</td>
	<td class="even" colspan="3"><textarea name="expenses_remarks" cols="80" rows="1">$this->expenses_remarks</textarea></td>
	
	</tr>

	

	<tr style="display:none">
	<td class="head"><div >Complete</div></td>
	<td class="even"><input type="checkbox" $checked2 name="iscomplete" onclick="completeExpenses(this.checked)" $stylecomplete></td>
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
<tr style="display:none">
	<td class="head">List Expenses :</td>
	<td class="odd">
	<input type="text" name="fldPayment" size="5" maxlength="5">
	<input type="button" value="Add" onclick="addPayment();">
	
	</td>
</tr>
</table>

<br>

EOF;

// if($displayadd=="")
// $this->getTableLine();

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
		<th>Expenses</th>
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
	$expensesctrl = $this->getSelectExpenseslist($expenseslist_id,$i);
	$uom = $this->getPriceExpenseslist($expenseslist_id,"uom_description");


echo <<< EOF
	<input type="hidden" name="expensesline_id[$i]" value="$expensesline_id">
	<tr align="center">
		<td class="$rowtype">$i</td>
		<td class="$rowtype"><input type="text" size="3" maxlength="5" name="expensesline_no[$i]" value="$expensesline_no"></td>
		<td class="$rowtype">$expensesctrl</td>
		<td class="$rowtype"><textarea cols="25" rows="4" name="expensesline_remarks[$i]">$expensesline_remarks</textarea></td>
		<td class="$rowtype"><input type="text" size="3" maxlength="10" name="expensesline_qty[$i]" value="$expensesline_qty" onblur="calculateTotal(document);">
		<div id=idUom$i>$uom</div></td>
		<td class="$rowtype"><input type="text" size="5" maxlength="100" name="expensesline_price[$i]" value="$expensesline_price" onblur="calculateTotal(document);parseelement(this);"></td>
		<td class="$rowtype"><input type="text" size="7" maxlength="10" name="expensesline_amount[$i]" value="$expensesline_amount" readonly></td>
		<td class="$rowtype"><input type="button" value="Delete" onclick="deleteLine($expensesline_id);"></td>

	</tr>
EOF;
	}
	if($i == 0){
	echo "<tr><td colspan='8'>Please Add Expenses Line.</td></tr>";
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
  public function deleteExpenses( $expenseslistmaster_id ) {
   	$this->log->showLog(2,"Warning: Performing delete expenseslist id : $this->expenses_id !");
	$sql="DELETE FROM $this->tableexpenses where expenses_id=$this->expenses_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: expenseslist ($expenses_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Expenses ($expenses_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteExpensesMaster


/**
   * Display a expenseslist list table
   *
   * 
   * @access public
   */
public function showExpensesTable(){
	if($this->start_date=="")
	$this->start_date = getMonth(date("Ymd", time()),0) ;
   	
	if($this->end_date=="")
	$this->end_date = getMonth(date("Ymd", time()),1) ;

	$wherestring = " where a.expenses_id>0 ";
	
	$wherestring .= $this->getWhereString();

	$this->log->showLog(3,"Showing Expenses Table");
	$sql=$this->getSQLStr_AllExpenses($wherestring," GROUP BY a.expenses_id ORDER BY expenses_date desc ",0);
	
	$query=$this->xoopsDB->query($sql);

	echo <<< EOF
	<form name="frmNew" action="expenses.php" method="POST">
	<table>
	<tr>
	<td><input type="submit" value="New" style='height:40px;'></td>
	</tr>
	</table>
	</form>

	<form action="expenses.php" method="POST" name="frmSearch">
	<input type="hidden" name="fldShow" value="">
	<input type="hidden" name="action" value="">
	<input type="hidden" value="" name="expenses_id">
	<table border='1' cellspacing='3'>
	<tr>
	<td class="head">Expenses No</td>
	<td class="even"><input type="text" name="expenses_no" value=""></td>
	<td class="head">Expenses list</td>
	<td class="even">$this->expensesctrl</td>
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
	<td class="even" colspan="3">
	<select name="isactive">
	<option value="X"></option>
	<option value="Y">Yes</option>
	<option value="N">No</option>
	</select>
	</td>
	<td class="head" style="display:none">Complete</td>
	<td class="even" style="display:none">
	<select name="iscomplete">
	<option value="X"></option>
	<option value="Y">Yes</option>
	<option value="N">No</option>
	</select>
	</tr>
	
	<tr>
	<td class="head" colspan="4"><input type="button" value="Search" onclick="searchExpenses();" style='height:40px;'></td>
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
				<th style="text-align:center;">Expenses</th>
				<th style="text-align:center;">Qty</th>
				<th style="text-align:center;">Price</th>
				<th style="text-align:center;">Amount ($this->cur_symbol)</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$expenses_totalamountfinal = "";
	$expenses_pricefinal = "";
	$expenses_qtyfinal = "";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$expenses_id=$row['expenses_id'];
		$expenses_no=$row['expenses_no'];
		$expenses_date=$row['expenses_date'];
		$expenses_totalamount=$row['expenses_totalamount'];
		$expenses_qty=$row['expenses_qty'];
		$expenses_price=$row['expenses_price'];
		$expenses_name=$row['expenseslist_name'];
		$iscomplete=$row['iscomplete'];
		$isactive=$row['isactive_m'];

		$expenses_totalamountfinal += $expenses_totalamount;
		$expenses_pricefinal += $expenses_price;
		$expenses_qtyfinal += $expenses_qty;

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
			<td class="$rowtype" style="text-align:center;">$expenses_no</td>
			<td class="$rowtype" style="text-align:center;">$expenses_date</td>
			<td class="$rowtype" style="text-align:center;">$expenses_name</td>
			<td class="$rowtype" style="text-align:center;">$expenses_qty</td>
			<td class="$rowtype" style="text-align:center;">$expenses_price</td>
			<td class="$rowtype" style="text-align:center;">$expenses_totalamount</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
			
			<form action="expenses.php" method="POST">
			<input type="image" src="images/edit.gif" name="imgSubmit" title='Edit this record'>
			<input type="hidden" name="expenses_id" value="$expenses_id">
			<input type="hidden" name="action" value="edit">
			</form>
			</td>

		</tr>
EOF;
	}

	if($i==0)
	echo "<tr><td>No record(s) found.</td></tr>";

	if($expenses_pricefinal != "")
	$expenses_pricefinal = number_format($expenses_pricefinal, 2, '.','');

	if($expenses_totalamountfinal != "")
	$expenses_totalamountfinal = number_format($expenses_totalamountfinal, 2, '.','');

	echo  "<tr>
		<td class='head' colspan='4'></td>
		<td class='head' align=center>$expenses_qtyfinal</td>
		<td class='head' align=center>$expenses_pricefinal</td>
		<td class='head' align=center>$expenses_totalamountfinal</td>
		<td class='head' colspan='2'></td>
		<tr>";
	echo "</tbody></table>";

	echo  "</tbody></table>";

	}
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
  public function getLatestExpensesID(){
  	$sql="SELECT MAX(expenses_id) as expenses_id from $this->tableexpenses;";
	$this->log->showLog(3, "Retrieveing last expenseslist id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['expenses_id'];
	else
	return -1;
	

  }


public function getSelectExpenses($id,$isitem='NY',$calledfunction="") {

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

  public function getExpensesPrice($id){
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

  public function getSelectExpenseslist2($id,$i) {

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


    public function getSelectExpenseslist($id) {

	$wherestring="";
	
	$wherestring.=" WHERE p.isactive='Y' ";

	$sql="SELECT p.expenseslist_id,p.expenseslist_name from $this->tableexpenseslist p ".
		"inner join $this->tableexpensescategory c on c.category_id=p.category_id ".
		"$wherestring or (p.expenseslist_id=$id) order by expenseslist_name ;";

	$this->log->showLog(4,"Excute SQL for generate expenseslist list: $sql;");
	$selectctl="<SELECT name='expenseslist_id' id=name='expenseslist_id' onchange='getPrice(this.value);'>";
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


  public function getPriceExpenseslist($id,$fld){
	$price = "0.00";
	$sql = "SELECT $fld as fld FROM $this->tableexpenseslist a, $this->tableuom b 
	 	WHERE a.expenseslist_id = $id 
		and  a.uom_id = b.uom_id";
	
	$query=$this->xoopsDB->query($sql);	
	$this->log->showLog(4,"With SQL: $sql");

	if($row=$this->xoopsDB->fetchArray($query)){
	$price = $row['fld'];
	}
	
	return $price;
  }






} // end of ExpensesMaster
?>

<?php
/************************************************************************
Class Internal.php - Copyright kfhoo
**************************************************************************/

class Internal
{
  public $internal_id;
  public $internal_no;
  public $internal_date;
  public $internal_type;
  public $employee_id;
  public $internal_remarks;
  public $start_date;
  public $end_date;

  public $internalline_id;
  public $internalline_no;
  public $product_id;
  public $internalline_remarks;
  public $internalline_qty;

  public $organization_id;
  public $created;
  public $updated;
  public $createdby;
  public $updatedby;
  public $isactive;
  public $iscomplete;
  public $cur_name;
  public $cur_symbol;
  
  public $fldPayment;
  
  public $isAdmin;
  public $orgctrl;
  public $employeectrl;
  public $customerctrl;
  public $productctrl;

  public $tableinternal;
  public $tableinternalline;
  public $tableemployee;
  public $tablecustomer;
  public $tableproduct;
  public $tablecategory;
  public $tableproductlist;
  public $tableuom;

  public $tableprefix;
  public $filename;

  public $fldShow;

  public function Internal($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableinternal=$tableprefix."simsalon_internal";
	$this->tableinternalline=$tableprefix."simsalon_internalline";
	$this->tableemployee=$tableprefix."simsalon_employee";
	$this->tablecustomer=$tableprefix."simsalon_customer";
	$this->tableproduct=$tableprefix."simsalon_productlist";
	$this->tablecategory=$tableprefix."simsalon_productcategory";
	$this->tableproductlist=$tableprefix."simsalon_productlist";
	$this->tableuom=$tableprefix."simsalon_uom";
	$this->log=$log;
  }

  public function checkCode(){
  
  	$retval = 0;
	
	$sql = "SELECT count(*) as count from $this->tableinternal where internal_no = '$this->internal_no' and internal_type = 'I' ";  
  	$this->log->showLog(4,"Before insert product SQL:$sql");
	
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['count'];
	}
	
	return $retval;
  }
  
  
  public function insertInternal( ) {
	//$this->log->showLog(3,"Creating product SQL:$sql");

	if($this->fldPayment > 0)
	$line =  $this->fldPayment;
	else
	$line =  0;

	if($this->checkCode()==0){
	
		$timestamp= date("y/m/d H:i:s", time()) ;
		$this->log->showLog(3,"Inserting new product $this->internal_no");
		$sql =	"INSERT INTO $this->tableinternal 	(internal_no,internal_date,internal_type,employee_id,iscomplete,internal_remarks,
								isactive,created,createdby,updated,updatedby) 
								values('$this->internal_no',
									'$this->internal_date',
									'I',
									0,
									'$this->iscomplete',
									'$this->internal_remarks',
			'$this->isactive','$timestamp',$this->createdby,'$timestamp',$this->updatedby)";
	
		$this->log->showLog(4,"Before insert product SQL:$sql");
		$rs=$this->xoopsDB->query($sql);
		
		if (!rs){
			$this->log->showLog(1,"Failed to insert internal name '$internal_no'");
			return false;
		}
		else{
			$this->insertLine($line);
			$this->log->showLog(3,"Inserting new internal name '$internal_no' successfully"); 
			return true;
		}
		
	}else{
		$this->log->showLog(1,"Failed to insert internal name '$internal_no'");
		return false;
	}
  } // end of member function insertClassMaster


  public function insertLine($row){
	$i = $this->getLatestLine("internalline_no");

	if($this->internal_id == "")	
	$this->internal_id = $this->getLatestInternalID();
	
	$row += $i;

	while($i<$row){
	$i++;

	$sql = "INSERT INTO $this->tableinternalline (internalline_no,internal_id,internalline_qty) values
		($i,$this->internal_id,0)";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update internal failed");
		return false;
	}

	}

	return true;

  }

  public function updateLine(){
	$row = count($this->internalline_id);
	
	$i=0;
	while($i<$row){
	$i++;
	
	$internalline_id = $this->internalline_id[$i] ;
	$internalline_no = $this->internalline_no[$i] ;
	$internalline_remarks = $this->internalline_remarks[$i];
	$product_id = $this->product_id[$i];
	$employee_id = $this->employee_id[$i];
	$internalline_qty = $this->internalline_qty[$i];

	$sql = "UPDATE $this->tableinternalline SET
		internalline_no = $internalline_no,
		internalline_remarks = '$internalline_remarks',
		product_id = $product_id,
		employee_id = $employee_id,
		internalline_qty = $internalline_qty
		WHERE internal_id = $this->internal_id and internalline_id = $internalline_id";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update internal failed");
		return false;
	}

	}

	return true;

  }


  public function deleteLine($line){
	$sql = "DELETE FROM $this->tableinternalline WHERE internalline_id = $line and internal_id = $this->internal_id ";


	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update internal failed");
		return false;
	}else{
		$this->log->showLog(2, "Update internal Successfully");
		return true;
	}

  }

  public function updateTotalAmount(){

	$sql = "UPDATE $this->tableinternal SET internal_totalamount = COALESCE((SELECT sum(internalline_amount) as total FROM $this->tableinternalline 
								 WHERE internal_id = $this->internal_id),0) 
		WHERE internal_id = $this->internal_id";
	
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update internal failed");
		return false;
	}else{
		$this->log->showLog(2, "Update internal Successfully");
		return true;
	}
  }

  /**
   * Update class information
   *
   * @return bool
   * @access public
   */
  public function updateInternal() {
    $timestamp= date("y/m/d H:i:s", time()) ;

	if($this->fldPayment > 0)
	$line =  $this->fldPayment;
	else
	$line =  0;

	$sql="";
	
	$sql=	"UPDATE $this->tableinternal SET
		internal_no='$this->internal_no',
		internal_date='$this->internal_date',
		employee_id=0,
		iscomplete='$this->iscomplete',
		internal_remarks='$this->internal_remarks',
		updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive'

		WHERE internal_id='$this->internal_id'";

	$this->log->showLog(3, "Update internal_id: $this->internal_id, '$this->internal_name'");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update internal failed");
		return false;
	}
	else{
		$this->updateLine();
		$this->insertLine($line);
		$this->log->showLog(3, "Update internal successfully.");
		return true;
	}
  } // end of member function updateClass

  public function getLatestLine($fld){
	$retval = 0;
	$sql = "SELECT $fld from $this->tableinternalline where internal_id = $this->internal_id ORDER BY internalline_no DESC";

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
  public function getSqlStr_AllInternal( $wherestring,  $orderbystring,  $startlimitno ) {
  
	$wherestring .= " and a.internal_type = 'I' and a.employee_id = b.employee_id ";

 	$sql= 	"SELECT *,a.isactive as isactive_m FROM $this->tableinternal a, $this->tableemployee b
		$wherestring $orderbystring";

   $this->log->showLog(4,"Running Internal->getSQLStr_AllInternal: $sql");
  return $sql;
  } // end of member function getSqlStr_AllClass

  /**
   * pull data from database into class.
   *
   * @param int masterclass_id 
   * @return bool
   * @access public
   */
  public function fetchInternalInfo( $internal_id ) {
    
	$this->log->showLog(3,"Fetching product detail into class Internal.php.<br>");
		
	$sql="SELECT * FROM $this->tableinternal
	where internal_id=$internal_id";
	
	$this->log->showLog(4,"Internal->fetchInternalInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->internal_id=$row["internal_id"];
		$this->internal_no=$row["internal_no"];
		$this->internal_date=$row["internal_date"];
		$this->employee_id=$row["employee_id"];		
		$this->customer_id= $row['customer_id'];
		$this->internal_remarks=$row['internal_remarks'];
		$this->iscomplete=$row['iscomplete'];
		$this->isactive=$row['isactive'];
	
	   	$this->log->showLog(4,"Internal->fetchInternalInfo,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Internal->fetchInternalInfo,failed to fetch data into databases.");	
	}
  } // end of member function fetchInternalInfo


  public function getInputForm( $type,  $internal_id,$token ) {
	$filectrl="";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$completectrl="";	
	$deletectrl="";
	$uploadctrl="";
	$displayadd="";
	

	$timestamp= date("Y-m-d", time()) ;

	if ($type=="new"){
		$header="New Organization";
		$action="create";
		$btnsave = "Next";
		$stylecomplete = "style='display:none'";
		if($internal_id==0){
		$this->internal_no="";
		}
		$this->internal_date = $timestamp;

		$savectrl="<input style='height:40px;' name='btnSave' value='$btnsave' type='submit'>";
		$checked="CHECKED";
		$checked2="";
		$deletectrl="";
		$addnewctrl="";
		$displayadd="style='display:none'";

		$this->internal_no = getNewCode($this->xoopsDB,"internal_no",$this->tableinternal," and internal_type = 'I' ");
		
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

		$savectrl="<input name='internal_id' value='$this->internal_id' type='hidden'>".
			 "<input style='height:40px;' name='btnSave' value='$btnsave' type='submit'>";
		$completectrl="<input name='internal_id' value='$this->internal_id' type='hidden'>".
			 "<input style='height:40px;' name='btnComplete' value='Complete' type='submit' onclick='document.frmInternal.iscomplete.checked = true;'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

	

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableinternal' type='hidden'>".
		"<input name='id' value='$this->internal_id' type='hidden'>".
		"<input name='idname' value='internal_id' type='hidden'>".
		"<input name='title' value='Internal' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";
		


		$header="Edit Internal";
		if($this->allowDelete($this->internal_id) && $this->internal_id>0)
		$deletectrl="<FORM action='internal.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this product?"'.")'><input style='height:40px;' type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->internal_id' name='internal_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

		$addnewctrl="<form action='internal.php' method='post'><input type='submit' value='New' value='New' style='height:40px;'></form>";
			

	}

echo <<< EOF

<table style="width:300px;">$recordctrl<tbody><td>$addnewctrl</td><td>$deletectrl</td><td><form onsubmit="return validateInternal()" method="post"
 	action="internal.php" name="frmInternal"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset" style='height:40px;'>
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
	<td class="head">Internal Use No</td>
	<td class="odd"><input name="internal_no" value="$this->internal_no" maxlength='10' size='10'>
	&nbsp;&nbsp;Active&nbsp;&nbsp;<input type="checkbox" $checked name="isactive" >
	</td>
 	<td class="head">Date</td>
	<td class="odd">
	<input name='internal_date' id='internal_date' value="$this->internal_date" maxlength='10' size='10'>
	<input name='btnDate' value="Date" type="button" onclick="$this->datectrl">
	</td>
    </tr>
  <tbody>
	
    <tr style="display:none">
		
		<td class="head"><div $stylecomplete>Complete</div></td>
      		<td class="even"><input type="checkbox" $checked2 name="iscomplete" $stylecomplete onclick="completeInternal(this.checked)"></td>
		
    </tr>

    <tr>  	
		<td class="head">Remarks</td>
      		<td class="odd" colspan="3"><textarea name="internal_remarks" cols="80" rows="1">$this->internal_remarks</textarea></td>

		<td class="head" style="display:none">Employee</td>
		<td class="odd" style="display:none">$this->employeectrl</td>
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
<tr >
	<td class="head">List Internal Use :</td>
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

	$sql = "SELECT * FROM $this->tableinternalline WHERE internal_id = $this->internal_id ORDER BY internalline_no ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);

echo <<< EOF
	<table border=1>
	<tr align="center">
		<th>No</th>
		<th>Seq</th>
		<th>Employee</th>
		<th>Product</th>
		<th>Qty</th>
		<th></th>
	</tr>
	
EOF;

	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	
	$internalline_id = $row['internalline_id'];
	$internalline_no = $row['internalline_no'];
	$product_id = $row['product_id'];
	$employee_id = $row['employee_id'];
	$internalline_remarks = $row['internalline_remarks'];
	$internalline_qty = $row['internalline_qty'];


	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";


	$productctrl = $this->getSelectProduct($product_id,$i);
	$uom = $this->getPriceProduct($product_id,"uom_description");
	$employeectrl = $this->getEmployeeListArray($employee_id,$i);


echo <<< EOF
	<input type="hidden" name="internalline_id[$i]" value="$internalline_id">
	<tr align="center">
		<td class="$rowtype">$i</td>
		<td class="$rowtype"><input type="text" size="3" maxlength="5" name="internalline_no[$i]" value="$internalline_no"></td>
		<td class="$rowtype">$employeectrl</td>
		<td class="$rowtype">$productctrl</td>
		<td class="$rowtype"><input type="text" size="3" maxlength="10" name="internalline_qty[$i]" value="$internalline_qty" >
		<div id=idUom$i>$uom</div></td>
		<td class="$rowtype" style="display:none"><textarea cols="25" rows="2" name="internalline_remarks[$i]">$internalline_remarks</textarea></td>
		<td class="$rowtype"><input type="button" value="Delete" onclick="deleteLine($internalline_id);"></td>

	</tr>
EOF;
	}
	if($i == 0){
	echo "<tr><td colspan='8'>Please Add Internal Use Line.</td></tr>";
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
  public function deleteInternal( $productmaster_id ) {
   	$this->log->showLog(2,"Warning: Performing delete product id : $this->internal_id !");
	$sql="DELETE FROM $this->tableinternal where internal_id=$this->internal_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: product ($internal_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Internal ($internal_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteInternalMaster


/**
   * Display a product list table
   *
   * 
   * @access public
   */
public function showInternalTable(){
	if($this->start_date=="")
	$this->start_date = getMonth(date("Ymd", time()),0) ;
   	
	if($this->end_date=="")
	$this->end_date = getMonth(date("Ymd", time()),1) ;

	$wherestring = " where a.internal_id>0 ";
	
	$wherestring .= $this->getWhereString();

	$this->log->showLog(3,"Showing Internal Table");
 	$sql=$this->getSQLStr_AllInternal($wherestring," GROUP BY a.internal_id ORDER BY internal_date desc ",0);
	
	$query=$this->xoopsDB->query($sql);

	echo <<< EOF
	<form name="frmNew" action="internal.php" method="POST">
	<table>
	<tr>
	<td><input type="submit" value="New" style='height:40px;'></td>
	</tr>
	</table>
	</form>

	<form action="internal.php" method="POST" name="frmSearch">
	<input type="hidden" name="fldShow" value="">
	<input type="hidden" name="action" value="">
	<input type="hidden" value="" name="internal_id">
	<table border='1' cellspacing='3'>
	<tr>
	<td class="head">Internal Code</td>
	<td class="even"><input type="text" name="internal_no" value=""></td>
	<td class="head">Product</td>
	<td class="even">$this->productctrl</td>
	</tr>


	<tr>
	<td class="head">Employee</td>
	<td class="even">$this->employeectrl</td>
	<td class="head">Complete</td>
	<td class="even">
	<select name="iscomplete">
	<option value="X"></option>
	<option value="Y">Yes</option>
	<option value="N">No</option>
	</select>
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
	
	</tr>
	
	<tr>
	<td class="head" colspan="4"><input type="button" value="Search" onclick="searchInternal();" style='height:40px;'></td>
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
				<th style="text-align:center;">Complete</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$internal_id=$row['internal_id'];
		$internal_no=$row['internal_no'];
		$internal_date=$row['internal_date'];
		$employee_name=$row['employee_name'];
		$iscomplete=$row['iscomplete'];
		$isactive=$row['isactive_m'];

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
			<td class="$rowtype" style="text-align:center;">$internal_no</td>
			<td class="$rowtype" style="text-align:center;">$internal_date</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
			
			<form action="internal.php" method="POST">
			<input type="image" src="images/edit.gif" name="imgSubmit" title='Edit this record' $styleedit>
			<input type="hidden" name="internal_id" value="$internal_id">
			<input type="hidden" name="action" value="edit">
			</form>

			<form action="internal.php" method="POST" onsubmit="return confirm('Enable This Record?')">
			<input type="submit"  name="btnEnable" title='Enable this record' value="Enable" $styleenable>
			<input type="hidden" name="internal_id" value="$internal_id">
			<input type="hidden" name="action" value="enable">
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

	if($this->internal_no != "")
	$retval .= " and a.internal_no LIKE '$this->internal_no' ";
 	if($this->product_id > 0)
 	$retval .= " and a.internal_id IN (select internal_id from $this->tableinternalline where product_id = $this->product_id ) ";
	if($this->employee_id > 0)
 	$retval .= " and a.internal_id IN (select internal_id from $this->tableinternalline where employee_id = $this->employee_id ) ";
	if($this->isactive != "X" && $this->isactive != "")
	$retval .= " and a.isactive = '$this->isactive' ";
	if($this->iscomplete != "X" && $this->iscomplete != "")
	$retval .= " and a.iscomplete = '$this->iscomplete' ";
	if($this->start_date != "" && $this->end_date != "")
	$retval .= " and ( a.internal_date between '$this->start_date' and '$this->end_date' ) ";

	return $retval;
	
  }

/**
   * get latest generated product
   * 
   * return int  internal_id (latest)
   * @access public
   */
  public function getLatestInternalID(){
  	$sql="SELECT MAX(internal_id) as internal_id from $this->tableinternal;";
	$this->log->showLog(3, "Retrieveing last product id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['internal_id'];
	else
	return -1;
	

  }


public function getSelectInternal($id,$isitem='NY',$calledfunction="") {

	$wherestring="";
	$tablecategory=$this->tableprefix ."simtrain_internalcategory";
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

	$sql="SELECT p.internal_id,p.internal_name from $this->tableinternal p ".
		"inner join $tablecategory c on c.category_id=p.category_id ".
		"$wherestring or (p.internal_id=$id)) and p.internal_id>0 order by internal_name ;";

	$this->log->showLog(4,"Excute SQL for generate product list: $sql;");
	$selectctl="<SELECT name='internal_id' $calledfunction>";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$internal_id=$row['internal_id'];
		$internal_name=$row['internal_name'];
	
		if($id==$internal_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$internal_id' $selected>$internal_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getInternalPrice($id){
	$this->log->showLog(3,"Retrieving default price for product $id");
	$sql="SELECT internal_name,amt from $this->tableinternal where internal_id=$id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$price=$row['amt'];
		$internal_name=$row['internal_name'];
		$this->log->showLog(3,"internal_id: have productname: $internal_name with internal_id: $id");
		return $price;
	
	}
	else
	{
		$this->log->showLog(1,"Error, can't find internal_id: $id");
		return 0;
	}
	


  }
  public function savefile($tmpfile,$newfilename){
	move_uploaded_file($tmpfile, "upload/products/$newfilename");
	$sqlupdate="UPDATE $this->tableinternal set filename='$newfilename' where internal_id=$internal_id";
	$qryUpdate=$this->xoopsDB->query($sqlupdate);
  }

  public function deletefile($internal_id){
	$sql="SELECT filename from $this->tableinternal where internal_id=$internal_id";
	$query=$this->xoopsDB->query($sql);
	$myfilename="";
	if($row=$this->xoopsDB->fetchArray($query)){
		$myfilename=$row['filename'];
	}
	$myfilename="upload/products/$myfilename";
	$this->log->showLog(3,"This file name: $myfilename");
	unlink("$myfilename ");
	$sqlupdate="UPDATE $this->tableinternal set filename='-' where internal_id=$internal_id";
	$qryDelete=$this->xoopsDB->query($sqlupdate);
  }

  public function allowDelete($internal_id){
/*
	$tabletuitionclass = $this->tableprefix."simtrain_tuitionclass";
	$tablepaymentline = $this->tableprefix."simtrain_paymentline";
	$tableinventorymovement = $this->tableprefix."simtrain_inventorymovement";

	$sql="select sum(recordcount) as recordcount from (
		SELECT count(internal_id) as recordcount FROM $tabletuitionclass where internal_id=$internal_id
		UNION 
		SELECT count(internal_id) as recordcount FROM $tablepaymentline where internal_id=$internal_id
		UNION 
		SELECT count(internal_id) as recordcount FROM $tableinventorymovement where internal_id=$internal_id
		) as b1";
	
	$this->log->showLog(3,"Verified allowDelete for internal_id:$internal_id");
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
	
	$sql="SELECT employee_id,employee_name from $this->tableemployee where (isactive='Y' or employee_id=$id)  order by isdefault desc,employee_name asc ";
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

	$wherestring .="and c.isitem='N'";

	$sql="SELECT p.product_id,p.product_name from $this->tableproduct p ".
		"inner join $this->tablecategory c on c.category_id=p.category_id ".
		"$wherestring or (p.product_id=$id)  order by p.isdefault desc,p.product_name asc ";

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
	$price = "";
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


  public function enableInternal(){

	$sql = "update $this->tableinternal set iscomplete = 'N' where internal_id = $this->internal_id ";

	$this->log->showLog(4,"With SQL: $sql");

	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: ($internal_id) cannot enable from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Internal ($internal_id) enabled successfully!");
		return true;
		
	}
  }




} // end of InternalMaster
?>


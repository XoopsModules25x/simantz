<?php


/**
 * class InventoryMovement
 */
class InventoryMovement
{

  public $organization_id;
  public $createdby;
  public $created;
  public $updated;
  public $updatedby;
  public $product_id;
  public $quantity;
  public $movementdate;
  public $movement_description;
  public $documentno;
  public $movement_id;
  public $studentctrl;
  public $isAdmin;
  public $showCalender;
  public $productctrl;
  public $cur_name;
  public $cur_symbol;
  public $student_id;
  public $requirepayment;
  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $tableinventorymove;
  private $tablestudent;
  private $tableproduct;
  private $log;
  public $tablestudentclass;

/** Constructor
   *@param xoopsDB 
   * @param string 
   * @param log
   * @return 
   * @access public
   */
  
  public function InventoryMovement($xoopsDB,$tableprefix,$log) {
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tableinventorymove=$tableprefix . "simtrain_inventorymovement";
	$this->tableproduct=$tableprefix."simtrain_productlist";
	$this->tablestudent=$tableprefix."simtrain_student";
	$this->tablestudentclass=$tableprefix."simtrain_studentclass";
	$this->log=$log;

  }//InvInventoryMovemententoryMovement
  
  /** @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllInventoryMovement( $wherestring,  $orderbystring,  $startlimitno,$recordcount ) {
     $this->log->showLog(3,"Running InventoryMovement->showInventoryMoveTable");
    $sql="SELECT movement_id,m.documentno,m.movementdate,m.movement_description, m.quantity,p.product_name, o.organization_code, ".
	"s.student_name, m.requirepayment FROM $this->tableinventorymove m  inner join $this->tableproduct p on p.product_id=m.product_id ".
	" inner join $this->tableorganization o on o.organization_id=m.organization_id ".
	" left join $this->tablestudent s on m.student_id =s.student_id $wherestring $orderbystring LIMIT $startlimitno, $recordcount";
  $this->log->showLog(4,"Running InventoryMovement->showInventoryMoveTable: $sql");
  return $sql;
  } // end of member function getSQLStr_AllInventoryMovement

  /**
   *
   * @param int inventorymovement_id 
   * @return bool
   * @access public
   */
  public function deleteInventoryMovement( $movement_id ) {
    $this->log->showLog(2,"Warning: Performing delete movement_id  : $movement_id !");
	$sql="DELETE FROM $this->tableinventorymove where movement_id=$movement_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: movement_id ($movement_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"movement_id ($movement_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteInventoryMovement

  /**
   *
   * @return bool
   * @access public
   */
  public function insertInventoryMovement( ) {
    $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new documentno $this->documentno");
 	$sql="INSERT INTO $this->tableinventorymove (documentno,movement_description".
	",createdby, created,updatedby,updated,product_id,quantity,movementdate,organization_id,student_id,requirepayment) values(".
	"'$this->documentno','$this->movement_description',$this->createdby,'$timestamp',$this->updatedby,'$timestamp',".
	"$this->product_id,$this->quantity,'$this->movementdate',$this->organization_id,$this->student_id,'$this->requirepayment')";
	$this->log->showLog(4,"Before insert category SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert movement  $this->documentno");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new movement $this->documentno successfully"); 
		return true;
	}
  } // end of member function insertInventoryMovement

  /**
   *
   * @return bool
   * @access public
   */
  public function updateInventoryMovement( ) {
    $timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableinventorymove SET ".
	"documentno='$this->documentno',movement_description='$this->movement_description',updatedby=$this->updatedby,".
	"updated='$timestamp',product_id=$this->product_id,quantity=$this->quantity,organization_id=$this->organization_id, ".
	" student_id=$this->student_id, requirepayment='$this->requirepayment' ".
	"WHERE movement_id='$this->movement_id'";
	
	$this->log->showLog(3, "Update movement_id: $this->movement_id, document no: $this->documentno");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update inventory movement failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update inventory movement successfully.");
		return true;
	}
  } // end of member function updateInventoryMovement

  /**
   *
   * @param int inventorymovement_id 
   * @return bool
   * @access public
   */
  public function fetchInventoryMovement( $movement_id ) {
    
	$this->log->showLog(3,"Fetching movement detail into class InventoryMovement.php.<br>");
		
	$sql="SELECT movement_id, movement_description, product_id, quantity, movementdate, organization_id, documentno".
		",student_id, requirepayment from $this->tableinventorymove where movement_id=$movement_id";
	
	$this->log->showLog(4,"InventoryMovement->fetchInventoryMovement, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->organization_id=$row["organization_id"];
		$this->movement_id=$row["movement_id"];
		$this->movement_description= $row['movement_description'];
		$this->product_id=$row['product_id'];
		$this->quantity=$row['quantity'];
		$this->movementdate=$row['movementdate'];
		$this->documentno=$row['documentno'];
		$this->student_id=$row['student_id'];
		$this->requirepayment=$row['requirepayment'];

   		$this->log->showLog(4,"InventoryMovement->fetchInventoryMovement,database fetch into class successfully");

		return true;
	}
	else{
		$this->log->showLog(1,"Error! Can't fetch data from database for movement_id=$this->movement_id");
		return false;
	
	}
  } // end of member function fetchInventoryMovement

  /**
   *
   * @param string type 
   * @param int inventorymovement_id 
   * @return bool
   * @access public
   */
  public function showInputForm( $type,  $inventorymovement_id,$token ) {
    $mandatorysign="<b style='color:red'>*</b>";
    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$jumptoregproduct="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Movement";
		$action="create";
	 	
		if($this->product_id==0){
			$this->documentno="";
			$this->organization_id=0;
			$this->movementdate= date("Y-m-d", time()) ;;
			$this->quantity=1;
			$this->movementdescription="";
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="";
		$deletectrl="";
		$addnewctrl="";
	}
	else
	{
		$action="update";
		$savectrl="<input name='movement_id' value='$this->movement_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
	
		$header="Edit Movement";
		
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableinventorymove' type='hidden'>".
		"<input name='id' value='$this->movement_id' type='hidden'>".
		"<input name='idname' value='movement_id' type='hidden'>".
		"<input name='title' value='Inventory Movement' type='hidden'>".
		"<input name='submit' value='View Record Info' style='height: 40px;' type='submit'>".
		"</form>";
		if($this->requirepayment=='Y')
		$checked="CHECKED";
		if($this->allowDelete($this->movement_id) && $this->movement_id>0)
		$deletectrl="<FORM action='inventorymovement.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this movement?"'.")'><input type='submit' value='Delete' name='submit' style='height: 40px;'>".
		"<input type='hidden' value='$this->movement_id' name='movement_id'>".
		"<input type='hidden' value='delete' name='action' ><input name='token' value='$token' type='hidden'></form>";
		
		$addnewctrl="<Form action='inventorymovement.php' method='POST'><input name='submit' value='New' type='submit'></form>";
		$jumptoregproduct="<Form action='regproduct.php' method='POST'>".
				"<input name='submit' value='Go To Other Sales' style='height: 40px;' type='submit'>".
				"<input name='action' value='choosed' type='hidden'>".
				"<input name='student_id' value='$this->student_id' type='hidden'>".
				"</form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Products Movement</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateMovement()" method="post"
 action="inventorymovement.php" name="frmInventoryMovement"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
        <tr>
        <td class="head">Movement Place</td>
        <td class="odd" >$this->orgctrl</td>
        <td class="head">Student</td>
        <td class="odd" >$this->studentctrl  <input type="checkbox" name="requirepayment" $checked>Control Payment</td>

      </tr>
 
      <tr>
        <td class="head">Document No $mandatorysign</td>
        <td class="even"><input maxlength="10" size="10"
 name="documentno" value="$this->documentno"></td>
        <td class="head">Movement Date (YYYY-MM-DD)  $mandatorysign</td>
        <td class="even" colspan="2"><input maxlength="10" size="10" id='movementdate'
 name="movementdate" value="$this->movementdate"><input type='button' value='Date' onclick="$this->showCalender"></td>
      </tr>
 <tr>
        <td class="head">Product</td>
        <td class="odd">$this->productctrl</td>
 	<td class="head">Qty $mandatorysign</td>
        <td class="odd"> <input name="quantity" value="$this->quantity" > 
		<input type='button' value="+" onClick='document.frmInventoryMovement.quantity.value=parseFloat(document.frmInventoryMovement.quantity.value) + 1'>
		(Stock out use -ve value)
		<input type='button' value="-" onClick='document.frmInventoryMovement.quantity.value=parseFloat(document.frmInventoryMovement.quantity.value)-1'>
	</td>

</tr>
<tr>
        <td class="head">Description</td>
        <td class="even" colspan="3"><input maxlength="80" size="80"
 name="movement_description" value="$this->movement_description"></td>
 

</tr>
    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td><td>$jumptoregproduct</td></tbody></table>
  <br>
$recordctrl


EOF;
  } // end of member function getInputForm

  /**
   *
   * @param int product_id 
   * @return 
   * @access public
   */
  public function showInventoryMoveTable($wherestring , $orderbystring, $startlimitno,$recordcount) {
   
	$this->log->showLog(3,"Showing InventoryMove Table");
	 $sql=$this->getSQLStr_AllInventoryMovement($wherestring , $orderbystring, 0,$recordcount);
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='2'>
  		<tbody>
    			<tr><th colspan="10">Last 50 Records</th></tr><tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Document No</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Product</th>
				<th style="text-align:center;">Student</th>
				<th style="text-align:center;">Require<br>Payment</th>
				<th style="text-align:center;">Qty</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Action</th>
</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$movement_id=$row['movement_id'];
		$movementdate=$row['movementdate'];
		$movement_description=$row['movement_description'];
		$organization_code=$row['organization_code'];
		$quantity=$row['quantity'];
		$documentno=$row['documentno'];
		$product_name=$row['product_name'];
		$requirepayment=$row['requirepayment'];
		$student_name=$row['student_name'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$documentno</td>
			<td class="$rowtype" style="text-align:center;">$organization_code</td>
			<td class="$rowtype" style="text-align:center;">$movementdate</td>
			<td class="$rowtype" style="text-align:center;">$product_name</td>
			<td class="$rowtype" style="text-align:center;">$student_name</td>
			<td class="$rowtype" style="text-align:center;">$requirepayment</td>
			<td class="$rowtype" style="text-align:center;">$quantity</td>
			<td class="$rowtype" style="text-align:center;">$movement_description</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="inventorymovement.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit">
				<input type="hidden" value="$movement_id" name="movement_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
  } // end of member function showInventoryMoveTable

 /**
   * Get Latest movement id 
   * @param 
   * @return int latest_id 
   * @access public
   */
  public function getLatestInventoryMovementID(){
	$sql="SELECT MAX(movement_id) as movement_id from $this->tableinventorymove";
	
	$this->log->showLog(3,'Checking latest created movement_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created movement_id:' . $row['movement_id']);
		return $row['movement_id'];
	}
	else
	{
		$this->log->showLog(3,"Can't find any movement_id, return -1");
		return -1;
	}
  }

public function showOnHandStockTable($wherestring,$orderbystring,$startlimitno,$filename='inventorymovement.php'){
	$sql="SELECT p.product_id, p.product_no, p.product_name, p.isactive,".
		" coalesce((select sum(pl.qty) as qty from visi_simtrain_payment py inner join visi_simtrain_paymentline pl on ".
		" py.payment_id=pl.payment_id where p.product_id=pl.product_id and py.iscomplete='Y'),0) as stockout, ".
		" coalesce((select sum(m.quantity) as qty from visi_simtrain_inventorymovement m where m.product_id=p.product_id),0) ".
		" as stockin, coalesce((select sum(m.quantity) as qty from visi_simtrain_inventorymovement m ".
		" where m.product_id=p.product_id),0) - coalesce((select sum(pl.qty) as qty from visi_simtrain_payment py inner join ".
		" visi_simtrain_paymentline pl on py.payment_id=pl.payment_id where p.product_id=pl.product_id and ".
		" py.iscomplete='Y'),0) as balancestock, o.organization_name FROM visi_simtrain_productlist p ".
		" inner join visi_simtrain_organization o on o.organization_id=p.organization_id ".
		" inner join visi_simtrain_productcategory c on c.category_id=p.category_id $wherestring $oderbystring ";
	
	$this->log->showLog(3,"Showing onhand stock table");
	
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table>
  		<tbody>
    			<tr><th colspan="9" style="text-align:center;">On Hand Stock</th></tr><tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Product No</th>
				<th style="text-align:center;">Product Name</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Stock In</th>
				<th style="text-align:center;">Stock Out</th>
				<th style="text-align:center;">On Hand Stock</th>
				<th style="text-align:center;">Action</th>
</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$product_id=$row['product_id'];
		$product_no=$row['product_no'];
		$product_name=$row['product_name'];
		$isactive=$row['isactive'];
		$organization_name=$row['organization_name'];
		$stockin=$row['stockin'];
		$stockout=$row['stockout'];
		$balancestock=$row['balancestock'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
	$butonaction="";
	
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$organization_name</td>
			<td class="$rowtype" style="text-align:center;">$product_no</td>
			<td class="$rowtype" style="text-align:center;">$product_name</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$stockin</td>
			<td class="$rowtype" style="text-align:center;">$stockout</td>
			<td class="$rowtype" style="text-align:center;">$balancestock</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="$filename" method="POST">
				<input type="submit" value="View This Product Movement" name="submit">
				<input type="hidden" value="$product_id" name="product_id">
				<input type="hidden" name="action" value="viewmovement">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
}


  public function allowDelete($movement_id){
	$this->log->showLog(3,"Verified whether studentclass_id: $studentclass_id is deletable");
	$sql="SELECT count(studentclass_id) as countid from $this->tablestudentclass where movement_id=$movement_id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	$recordcount=0;
	if($row=$this->xoopsDB->fetchArray($query))
		$recordcount=$row['countid'];
	
	if($recordcount=="" || $recordcount==0){
		return true;
		$this->log->showLog(4,"Record deletable, count: $recordcountl");
	
	}
	else{
		$this->log->showLog(4,"Record not deletable, count: $recordcountl");
		return false;
	}
  }
} // end of InventoryMovement
?>

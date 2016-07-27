<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
/**
 * class Stockcharges
 */
class Stockcharges{

  public $type;
  public $tuitionclass_id;
  public $amt;
  public $product_id;
  public $quantity;
  public $movement_description;
  public $movementdate;
  public $organization_id;
  public $isactive;
  public $created;
  public $createdby;
  public $isAdmin;
  public $updated;
  public $updatedby;
  public $cur_name;
  public $cur_symbol;
  private $xoopsDB;
  private $tableprefix;
  private $tableperiod;
  private $tableorganization;
  private $tablestudent;
  private $tablestudentclass;
  private $tabletuitionclass;
  private $tableinventorymove;
  private $log;

  /**
   * @access public, constructor
   */
  public function Stockcharges($xoopsDB, $tableprefix, $log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableperiod=$tableprefix . "simtrain_period";
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tablestudent=$tableprefix . "simtrain_student";
	$this->tablestudentclass=$tableprefix . "simtrain_studentclass";
	$this->tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
	$this->tableinventorymove=$tableprefix . "simtrain_inventorymovement";
	
	$this->log=$log;
   }

  public function getSqlStr_AllStockcharges( $wherestring,  $orderbystring,  $startlimitno ) {
  
    $sql="SELECT tuitionclass_id,amt,product_id FROM $this->tablestockcharges $wherestring $orderbystring";
   $this->log->showLog(4,"Running Stockcharges->getSQLStr_AllStockcharges: $sql");
  return $sql;
  } // end of member function getSqlStr_AllClass

  public function getInputForm( $type,  $tuitionclass_id,$token ) {
	$mandatorysign="<b style='color:red'>*</b>";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$this->quantity = -1;
	$this->amt = 0;

	$tuitionclass_code = $this->getTuitionClassCode($this->tuitionclass_id);
	$this->movementdate= date("Y-m-d", time());

	$tuitionclassctrl =
	"<form action='tuitionclass.php' method='POST'>
	<input type='submit' value='Go To Tuition Class ($tuitionclass_code)' name='btnTC'>
	<input type='hidden' value='$this->tuitionclass_id' name='tuitionclass_id'>
	<input type='hidden' value='edit' name='action'></form>"; 

	if ($type=="new"){
		$header="New Stock/Charges";
		$action="create";
		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>
			   <input name='tuitionclass_id' value='$this->tuitionclass_id' type='hidden'>";
		$deletectrl="";
		$addnewctrl="";
	}
	else
	{
		$action="update";
		$savectrl="<input name='tuitionclass_id' value='$this->tuitionclass_id' type='hidden'>".
			 "<input style='height:40px;' name='submit' value='Save' type='submit'>";

		$header="Edit Stock/Charges";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablestockcharges' type='hidden'>".
		"<input name='id' value='$this->tuitionclass_id' type='hidden'>".
		"<input name='idname' value='tuitionclass_id' type='hidden'>".
		"<input name='title' value='Stockcharges' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		
		if($this->tuitionclass_id>1)
		$deletectrl="<FORM action='stockcharges.php' method='POST' onSubmit='return confirm(".
		'"Confirm to remove this stockcharges?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->tuitionclass_id' name='tuitionclass_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		 $addnewctrl="<form action='stockcharges.php' method='post'><input type='submit' value='New' value='New'></form>";
	}


    echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Stock/Charges</span></big></big></big></div><br>-->
<table style="width:140px;"><tbody>
<!--<td>$addnewctrl</td>-->
<td>$tuitionclassctrl</td>
<td><form method="post" action="stockcharges.php" name="frmStockcharges" onSubmit="return validateStockcharges()"><input name="reset" value="Reset" type="reset"></td></tbody></table>

 <table cellspacing='3' border='1'>
  <tbody>
	<tr>
	<th  colspan="4">$header</th>
	</tr>

	<tr>
	<td class="head" width="1%" nowrap>Type $mandatorysign</td>
	<td class="even" width="99%" colspan="3">
	<select name="type" onchange="getDisplayField(this.value)">
	<option value="S">Stock</option>
	<option value="C">Change Fees</option>
	</select>
	$this->orgctrl
	</td>
	</tr>

	<tr id="idTRCharges" style="display:none">
	<td class="head"  width="1%" nowrap>Charges Amount $mandatorysign</td>
	<td class="even" width="99%" colspan="3"><input name="amt" size="10" maxlength="10" value="$this->amt"></td>
	</tr>

	<tr id="idTRStock1">
	<td class="head"  width="1%" nowrap>Product $mandatorysign</td>
	<td class="even" width="1%">$this->productctrl</td>
	<td class="head"  width="1%" nowrap>Qty $mandatorysign</td>
	<td class="even" width="97%">
	<input name="quantity" value="$this->quantity" size="5" maxlength="10"> 
	<input type='button' value="+" onClick='document.frmStockcharges.quantity.value=parseFloat(document.frmStockcharges.quantity.value) + 1'>
	(Stock out use -ve value)
	<input type='button' value="-" onClick='document.frmStockcharges.quantity.value=parseFloat(document.frmStockcharges.quantity.value)-1'>
	</td>
	</tr>
	
	<tr id="idTRStock2">
        <td class="head">Description</td>
        <td class="even" colspan="3"><input maxlength="80" size="80"name="movement_description" value="$this->movement_description"></td>
	</tr>

	<tr id="idTRStock3">
	<td class="head"  width="1%" nowrap>Movement Date (YYYY-MM-DD)  $mandatorysign</td>
        <td class="even" colspan="3" width="99%">
	<input maxlength="10" size="10" id='movementdate'name="movementdate" value="$this->movementdate">
	<input type='button' value='Date' onclick="$this->showCalender">
	</td>
	</tr>

  </tbody>
</table>

<table style="width:150px;"><tbody><td>$savectrl<input name='action' value="$action" type='hidden'>
	<input name='token' value="$token" type='hidden'></td>
	</form><td>$deletectrl</td></tbody></table>
$recordctrl
EOF;

  } // end of member function getInputForm

  public function insertStockcharges() {
	$this->log->showLog(3,"Creating stock/charges SQL:$sql");

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new stockcharges $this->tuitionclass_id");

	if($this->type == "S"){

	$sqlstudent = "select student_id from $this->tablestudentclass where tuitionclass_id = $this->tuitionclass_id group by student_id ";

	$querystudent=$this->xoopsDB->query($sqlstudent);
	
	while($row=$this->xoopsDB->fetchArray($querystudent)){
		$student_id = $row['student_id'];

		$sql = "INSERT INTO $this->tableinventorymove 
		(documentno,
		movement_description,
		createdby,
		created,
		updatedby,
		updated,
		product_id,
		quantity,
		movementdate,
		organization_id,
		student_id,
		requirepayment) 

		values(

		'-',
		'$this->movement_description',
		$this->createdby,
		'$timestamp',
		$this->updatedby,
		'$timestamp',
		$this->product_id,
		$this->quantity,
		'$this->movementdate',
		$this->organization_id,
		$student_id,
		'Y')";
		
		$this->log->showLog(4,"Before insert stock SQL:$sql");
		$rs=$this->xoopsDB->query($sql);
	
		if (!$rs){
		$this->log->showLog(1,"Failed to insert stock");
		return false;
		}else{//insert into tablestudentclass
			$latest_id = $this->getLatestStockchargesID();
			$amt = $this->defaultAmt($latest_id);
	
			$sqlpreg="INSERT INTO $this->tablestudentclass (student_id,movement_id,amt,transactiondate,
				isactive,created,createdby,updated,updatedby,organization_id) values
				($student_id, $latest_id, $amt, '$this->movementdate', 'N' ,'$timestamp', $this->createdby,
				'$timestamp',$this->updatedby,$this->organization_id)";

			$this->log->showLog(4,"Before insert movement SQL:$sqlpreg");
			$rspreg=$this->xoopsDB->query($sqlpreg);
		
			if (!$rspreg){
			$this->log->showLog(1,"Failed to insert movement");
			return false;
			}

		}

	}


	}else{

	$sql = "update $this->tablestudentclass set amt = (amt + $this->amt) where tuitionclass_id = $this->tuitionclass_id ";
	//$sql = "insert $this->tablestudentclass set amt = (amt + $this->amt) where tuitionclass_id = $this->tuitionclass_id ";
		
	$this->log->showLog(4,"Before update charges SQL:$sql");
	$rs=$this->xoopsDB->query($sql);

	if (!$rs){
	$this->log->showLog(1,"Failed to insert charges");
	return false;
	}
	

	}

	return true;

  } // end of member function insertClassMaster

  /**
   * Update class information
   *
   * @return bool
   * @access public
   */
  public function updateStockcharges( ) {
    $timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablestockcharges SET ".
	"amt='$this->amt',updated='$timestamp',updatedby=$this->updatedby,product_id='$this->product_id' ".
	"WHERE tuitionclass_id='$this->tuitionclass_id'";
	
	$this->log->showLog(3, "Update tuitionclass_id: $this->tuitionclass_id, '$this->amt'");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update stockcharges failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update stockcharges successfully.");
		return true;
	}
  } // end of member function updateClass

  public function deleteStockcharges( $tuitionclass_id ) {
   	$this->log->showLog(2,"Warning: Performing delete stockcharges id : $tuitionclass_id !");
	$sql="DELETE FROM $this->tablestockcharges where tuitionclass_id=$tuitionclass_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: Stockcharges ($tuitionclass_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Stockcharges ($tuitionclass_id) removed from database successfully!");
		return true;
	}
  } // end of member function deleteStockcharges

  public function fetchStockcharges( $tuitionclass_id ) {
    
	$this->log->showLog(3,"Fetching stockcharges detail into class Stockcharges.php.<br>");
		
	$sql="SELECT tuitionclass_id,amt,product_id FROM $this->tablestockcharges ". 
			"where tuitionclass_id=$tuitionclass_id";
	
	$this->log->showLog(4,"Stockcharges->fetchStockcharges, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->tuitionclass_id=$row['tuitionclass_id'];
		$this->amt= $row['amt'];
		$this->product_id=$row['product_id'];
	   	$this->log->showLog(4,"Stockcharges->fetch Stockcharges, database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Stockcharges->fetchStockcharges, failed to fetch data into databases.");	
	}
  } // end of member function fetchStockcharges

  public function getLatestStockchargesID(){
  	$sql="SELECT MAX(movement_id) as movement_id from $this->tableinventorymove;";
	$this->log->showLog(3, "Retrieveing last movement_id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['movement_id'];
	else
	return -1;
  }

  public function getTuitionClassCode($tuitionclass_id){
	$retval = "";
	$sql = "select * from $this->tabletuitionclass a, $this->tableperiod b, $this->tableorganization c 
		where a.period_id = b.period_id and a.organization_id = c.organization_id 
		and tuitionclass_id = $tuitionclass_id";

	$this->log->showLog(4, "Get tuition class code With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['tuitionclass_code'] . "-" .$row['period_name']."-".$row['organization_code'];
	}
	return $retval;
  }

/**
   * get default tuition fees from database
   * @param int tuitionclass
   * return decimal tuition price
   * @access public
   */
  public function defaultAmt($movement_id){
	$this->log->showLog(3,"Retrieve default product amt from movement_id: $mvoement_id");
	$sql="select -1*p.amt * i.quantity as amt from sim_simtrain_inventorymovement i inner join sim_simtrain_productlist p on i.product_id=p.product_id ".
		" where i.movement_id=$movement_id";
	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	if ($row=$this->xoopsDB->fetchArray($query)){
		$result=$row['amt'];
		$this->log->showLog(3,"return result: $result");
		return $result;
	}
	else{
		$this->log->showLog(2,"Can't find the default amt, return:0"); 
		return 0;
	}
  } // end defaultTrainingFees()


}
?>

<?php
/************************************************************************
Class Customer.php - Copyright kfhoo
**************************************************************************/
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
/**
 * class Customer
 */
class Customer
{

  public $customer_id;
  public $customer_name;
  public $ic_no;
  public $tel1;
  public $email;
  public $tel2;
  public $isactive;
  public $address1;
  public $address2;
  public $postcode;
  public $city;
  public $state_id;
  public $country;
  public $organization_id;
  public $created;
  public $createdby;
  public $updated;
  public $orgWhereString;
  public $uid;
  public $updatedby;

  private $tableprefix;
  private $tablecustomer;
  private $tablearea;
  private $log;

  /**
   * @access public, constructor
   */
  public function Customer($xoopsDB, $tableprefix, $log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablecustomer=$tableprefix . "simsalon_customer";
	$this->tablearea=$tableprefix . "simsalon_area";
	$this->log=$log;
   }

  /**
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllCustomer( $wherestring,  $orderbystring,  $startlimitno ) {
    $sql= "SELECT customer_id, customer_name, tel1, email, ic_no, tel2, address1, address2, postcode, city, state_id, country,isactive FROM $this->tablecustomer $wherestring $orderbystring";
	$this->log->showLog(4,"Calling getSQLStr_AllCustomer:" .$sql);
   return $sql;
  } // end of member function getSQLStr_AllTransport

  /**
   *
   * @param string type 'new' or 'edit'
   * @param int customer_id 
   * @return bool
   * @access public
   */
  public function getInputForm( $type,  $customer_id, $token ) {
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	if ($type=="new"){
		$header="New Customer";
		$action="create";
		if($customer_id==0){
		$this->customer_id="";
		$this->customer_name="";
		$this->ic_no="";
		$this->tel1="";
		$this->tel2="";
		$this->email="";
		$this->address1="";
		$this->address2="";
		$this->postcode="";
		$this->city="";
		$this->state="";
		$this->state_id="";
		$this->country="";
		}

		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
	}
	else
	{
		
		$action="update";
		$savectrl="<input name='customer_id' value='$this->customer_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		$header="Edit Customer";
		$deletectrl="<FORM action='customer.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this customer?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->customer_id' name='customer_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		$addnewctrl="<Form action='customer.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}
$areactrl=$this->getAreaList($this->state_id);
$report="<Form action='customerreport.php' method='POST'><input name='submit' value='Customer Summary' type='submit'></form>";
echo <<< EOF

<div style="border: 1px solid rgb(0, 162, 0); color: rgb(0, 77, 0);"><big><big><big><span style="font-weight: bold;">Customer Record</span></big></big></big></div><br>
<table style="width:140px;"><tbody><td>$addnewctrl</td><td>$report</td><td><form method="post" action="customer.php" name="frmCustomer"><input name="reset" value="Reset" type="reset"></td></tbody></table>
<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
<tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
	<tr>
		<td class="head">Customer Name</td>
		<td colspan='3' class="even"><input style="width:300px;" name="customer_name" value="$this->customer_name">&nbsp;&nbsp;&nbsp;Active <input type="checkbox" $checked name="isactive"></td>
	</tr>
	<tr>
		<td class="head">Tel</td>
		<td class="odd"><input name="tel1" value="$this->tel1"></td>
		<td class="head">H/P</td>
		<td class="odd"><input name="tel2" value="$this->tel2"></td>
	</tr>
	<tr>
		<td class="head">IC No.</td>
		<td class="odd"><input style="width:250px;" name="ic_no" value="$this->ic_no"></td>
		<td class="head">Email</td>
		<td class="odd"><input style="width:200px;" name="email" value="$this->email"></td>
	</tr>
	<tr>
		<td class="head">Address1</td>
		<td class="even"><input style="width:250px;" name="address1" value="$this->address1"></td>
		<td class="head">Address2</td>
		<td class="even"><input style="width:250px;" name="address2" value="$this->address2"></td>
	</tr>
	<tr>
		<td class="head">Postcode</td>
		<td class="odd"><input style="width:100px;" name="postcode" value="$this->postcode"></td>
		<td class="head">City</td>
		<td class="odd"><input name="city" value="$this->city"></td>
	</tr>
	<tr>
		<td class="head">State</td>
		<td class="even">$areactrl</td>
		<td class="head">Country</td>
		<td class="even"><input name="country" value="$this->country"></td>
	</tr>

</tbody>
</table>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td></tbody></table><br>

EOF;
  } // end of member function getInputForm

public function getAreaList($id){
	$this->log->showLog(3,"Retrieve available area from database");

	$sql="SELECT area_id, area_name from $this->tablearea order by area_name ";
	$areactrl="<SELECT name='state_id' >";
	if ($id==-1)
		$areactrl=$areactrl . '<OPTION value="0" SELECTED="SELECTED"> </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$area_id=$row['area_id'];
		$area_name=$row['area_name'];
		if($id==$area_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		
		$areactrl=$areactrl  . "<OPTION value='$area_id' $selected>$area_name</OPTION>";
		$this->log->showLog(4,"Retrieving area_name:$area_name");
	}
	$areactrl=$areactrl . "</SELECT>";
	return $areactrl;
}//end of getAreaList


  public function deleteCustomer( $customer_id ) {
    	$this->log->showLog(2,"Warning: Performing delete customer id : $customer_id !");
	$sql="DELETE FROM $this->tablecustomer where customer_id=$customer_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: customer ($customer_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Customer ($customer_id) removed from database successfully!");
		return true;
		
	}
	

  } // end of member function deleteEmployee

  /**
   *
   * @return bool
   * @access public
   */
  public function updateCustomer( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$sql="UPDATE $this->tablecustomer SET customer_id='$this->customer_id', customer_name='$this->customer_name', tel1='$this->tel1', email='$this->email', ic_no='$this->ic_no', tel2='$this->tel2', address1='$this->address1', address2='$this->address2', postcode='$this->postcode', city='$this->city', state_id='$this->state_id', country='$this->country', isactive='$this->isactive' WHERE customer_id='$this->customer_id'";
	
	$this->log->showLog(3, "Update customer_id: $this->customer_id");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update customer failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update customer successfully.");
		return true;
	}

  } // end of member function updateCustomer

  public function getLatestCustomerID() {
	$sql="SELECT MAX(customer_id) as customer_id from $this->tablecustomer;";
	echo $sql;
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['customer_id'];
	else
	return -1;
	
  } // end of member function getLatestCustomerID

  /**
   *
   * @return bool
   * @access public
   */
  public function insertCustomer( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new customer $this->customer_name");
 	$sql="INSERT INTO $this->tablecustomer (customer_name, tel1, email, ic_no, tel2, address1, address2, postcode, city, state_id, country, isactive) values('$this->customer_name', '$this->tel1', '$this->email', '$this->ic_no', '$this->tel2', '$this->address1', '$this->address2', '$this->postcode', '$this->city', '$this->state_id', '$this->country', '$this->isactive')";
	$this->log->showLog(4,"Before insert customer SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	$this->log->showLog(4,"Customer->insertCustomer, before execute:" . $sql . "<br>");
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert customer $customer_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new customer $customer_name successfully"); 
		return true;
	}
} // end of member function insertCustomer


  public function fetchCustomer( $customer_id ) {
	$this->log->showLog(3,"Fetching customer detail into class Customer.php.<br>");
		
	$sql="SELECT customer_name, tel1, email, ic_no, tel2, address1, address2, postcode, city, state_id, country, isactive from $this->tablecustomer where customer_id=$customer_id";
	
	$this->log->showLog(4,"Customer->fetchCustomer, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->customer_name=$row['customer_name'];
		$this->ic_no=$row['ic_no'];
		$this->tel1=$row['tel1'];
		$this->tel2=$row['tel2'];
		$this->email=$row['email'];
		$this->address1=$row['address1'];
		$this->address2=$row['address2'];
		$this->postcode=$row['postcode'];
		$this->city=$row['city'];
		$this->state_id=$row['state_id'];
		$this->country=$row['country'];
		$this->isactive=$row['isactive'];
	$this->log->showLog(4,"Customer->fetchCustomer, database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Customer->fetchCustomer,failed to fetch data into databases.");	
	}
  } // end of member function fetchCustomer

 public function showCustomerTable(){
	
	$this->log->showLog(3,"Showing Customer Table");
	$sql=$this->getSQLStr_AllCustomer("","ORDER BY customer_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Customer Name</th>
				<th style="text-align:center;">IC No.</th>
				<th style="text-align:center;">Tel</th>
				<th style="text-align:center;">H/P</th>
				<th style="text-align:center;">Email</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="odd";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$customer_id=$row['customer_id'];
		$customer_name=$row['customer_name'];
		$ic_no=$row['ic_no'];
		$tel1=$row['tel1'];
		$tel2=$row['tel2'];
		$email=$row['email'];
		$isactive=$row['isactive'];	

		if($rowtype=="odd"){
			$rowtype="even";}
		else{
			$rowtype="odd";}
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$customer_name</td>
			<td class="$rowtype" style="text-align:center;">$ic_no</td>
			<td class="$rowtype" style="text-align:center;">$tel1</td>
			<td class="$rowtype" style="text-align:center;">$tel2</td>
			<td class="$rowtype" style="text-align:center;">$email</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="customer.php" method="POST">
				<input type="submit" value="Edit" name="submit">
				<input type="hidden" value="$customer_id" name="customer_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}//end of while
echo  "</tr></tbody></table>";
 } //end of showCustomerTable


} // end of Customer
?>

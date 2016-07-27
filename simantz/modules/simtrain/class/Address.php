<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


/**
 * class Address
 * The class for address
 */
class Address
{

  public $address_id;
  public $student_id;
  public $employee_id;
  public $employee_no;
  public $student_code;
  public $student_name;
  public $employee_name;
  public $street1;
  public $street2;
  public $postcode;
  public $city;
  public $state;
  public $country;
  public $isactive;
  public $seqno;
  public $area_id;
  public $organization_id;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $address_name;
  public $cur_name;
  public $cur_symbol;
  private $xoopsDB;
  private $tableprefix;
  private $tableaddress;
  private $tablearea;
  private $tablestudent;
  private $tablestudentclass;
  private $tableemployee;
  private $log;

 public function Address($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->log=$log;
	$this->tableaddress=$tableprefix."simtrain_address";
	$this->tablestudent=$tableprefix."simtrain_student";
	$this->tableemployee=$tableprefix."simtrain_employee";
	$this->tablestudentclass=$tableprefix."simtrain_studentclass";
	$this->tablearea=$tableprefix."simtrain_area";

	}
  /**
   * Get select sql statement database.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param string startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllAddress( $wherestring,  $orderbystring,  $startlimitno ) {
    $sql= "SELECT address_id, address_name, student_id, no, street1, street2, ,area_id, postcode, city, state, country, isactive, seqno, area_id, created, createdby, updated, updatedby FROM $this->tableaddress $wherestring $orderbystring";
	$this->log->showLog(4,"Calling getSQLStr_AllAddress:" .$sql);
   return $sql;

  } // end of member function getSQLStr_AllAddress

  /**
   * display input forms, if type="new" all field is empty, if it is "edit", all
   * field's data will fetch from database, with address_id as reference.
   *
   * @param varchar(10) type 
   * @param int address_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $address_id, $token, $student_id ) {
	$mandatorysign="<b style='color:red'>*</b>";	
	$this->log->showLog(3,"Entering show address inputform, with area_id=$this->area_id, address_id=$address_id");
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	if ($type=="new"){
		$header="New Address";
		$action="create";
		if($address_id==0){
		$this->address_id="";
		$this->address_name="";
		$this->student_id="$student_id";
		$this->no="";
		$this->street1="";
		$this->area_id=-1;
		$this->street2="";
		$this->postcode="";
		$this->city="";
		$this->state="";
		$this->country="";
		$this->seqno="";
		$this->area_id="";
		$this->organization_id="";
		}

		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'><input name='student_id' value='$student_id' type='hidden'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$areactrl=$this->getAreaList($this->area_id);
	}
	else
	{
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		$header="Edit Address";
		
		if($this->student_id>'0')
		{
		$action="update";
		$savectrl="<input name='address_id' value='$this->address_id' type='hidden'>".
				"<input name='student_id' value='$student_id' type='hidden'>".
				"<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$addnewctrl="<Form action='address.php' method='POST'>".
				"<input name='student_id' value='$student_id' type='hidden'>".
				"<input name='submit' value='New' type='submit'>".
				"<input name='action' value='' type='hidden'></form>";
		if($this->allowDelAddress($this->address_id) || $this->student_i > 0)
			$deletectrl="<FORM action='address.php' method='POST' ".
					" onSubmit='return confirm(".'"Confirm to remove this address service?"'.")'>".
					" <input type='submit' value='Delete' name='submit'>".
					" <input type='hidden' value='$this->address_id' name='address_id'>".
					" <input type='hidden' value='delete' name='action'>".
					" <input name='token' value='$token' type='hidden'></form>";
		$areactrl=$this->getAreaList($this->area_id);
		}
		else
		{
		$action="updateE";
		$savectrl="<input name='address_id' value='$this->address_id' type='hidden'><input name='employee_id' value='$this->employee_id' type='hidden'><input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$addnewctrl="";
		$deletectrl="";
		$areactrl=$this->getAreaList($this->area_id);
		}
	}
      //$orgctrl=$this->selectionOrg(0,0);


echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Contact Address</span></big></big></big></div><br>
<table style="width:140px;"><tbody><td>$addnewctrl</td><td>
<form method="post" action="address.php" name="frmAddress" onSubmit="return validateAddress()"><input name="reset" value="Reset" type="reset"></td></tbody></table>
<table style="text-align:left width: 100%" border="1" cellpadding="0" cellspacing="3">
<tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
	<tr>
			<td class="head">Address Name $mandatorysign</td>
			<td colspan='3' class="odd"><input size="30" name="address_name" value="$this->address_name">&nbsp;&nbsp;Active <input type="checkbox" $checked name="isactive"></td>
	</tr>
	<tr>
			<td class="head">No.</td>
			<td class="even"><input size="15" name="no" value="$this->no"></td>
			<td class="head">Street Name</td>
			<td class="even"><input size="40" name="street1" value="$this->street1"></td>
	</tr>
	<tr>
		<td class="head">Taman / Garden</td>
		<td  class="odd"><input size="40" name="street2" value="$this->street2"></td>
		<td class="head">Area Group</td>
		<td  class="odd">$areactrl * Compulsory Field</td>
	</tr>
	<tr>
		<td class="head">Postcode</td>
		<td  class="even" colspan="3"><input size="15" name="postcode" value="$this->postcode"></td>
	</tr>
	<tr>
		<td class="head">Town</td>
		<td class="odd" colspan="3"><input size="60" name="city" value="$this->city"></td>
	</tr>
	<tr>
		<td class="head">State</td>
		<td class="even" colspan="3"><input size="60" name="state" value="$this->state"></td>
	</tr>
	<tr>
		<td class="head">Country</td>
		<td class="odd" colspan="3"><input size="60" name="country" value="$this->country">
		</td>
	</tr>
</tbody>
</table>
<table style="width:150px;"><tbody><td>$savectrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td></tbody></table>
EOF;
  } // end of member function getInputForm

  /**
   * Save address info into database
   *
   * @return bool
   * @access public
   */
  public function updateAddress( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$sql="UPDATE $this->tableaddress SET ".
	"address_name='$this->address_name', no='$this->no',street1='$this->street1',street2='$this->street2',area_id=$this->area_id, postcode='$this->postcode', city='$this->city', state='$this->state', country='$this->country', isactive='$this->isactive',updated='$timestamp',updatedby=$this->updatedby WHERE address_id='$this->address_id'";
	
	$this->log->showLog(3, "Update address_id: $this->address_id, $this->address_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update address failed");
		return false;
	}
	
	else{
		$this->log->showLog(3, "Update address successfully.");
		return true;
	}
  } // end of member function updateAddress


  /**
   * Save address info into database as new record.
   * @return bool
   * @access public
   */
  public function insertAddress( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
//	echo "The inserting is $o->student_id";
	$this->log->showLog(3,"Inserting new address $address_name");
	$sql="INSERT INTO $this->tableaddress (student_id,address_name,no,street1,street2,postcode, city,state,country,isactive,organization_id,created,createdby,updated,updatedby,area_id) values('$this->student_id','$this->address_name','$this->no', '$this->street1', '$this->street2', '$this->postcode', '$this->city','$this->state', '$this->country', '$this->isactive', '$this->organization_id','$timestamp',$this->createdby,'$timestamp',$this->updatedby,$this->area_id)";
	$this->log->showLog(4,"Before insert address SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert address $address_id");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new address $address_id successfully"); 
		return true;
}
  } // end of member function insertAddress

  /**
   * delete address from database.
   *
   * @param int address_id 
   * @return bool
   * @access public
   */
  public function delAddress( $address_id ) {
    	$this->log->showLog(2,"Warning: Performing delete student id : $address_id !");
	$sql="DELETE FROM $this->tableaddress where address_id=$address_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: Address ($address_id) unable remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Address ($address_id) removed from database successfully!");
		return true;	
	}
  } // end of member function delAddress

/**
   * Create new blank address, special for employee and organization.
   * @param string $sql
   * @return int $address_id
   * @access public
   */
  public function createBlankAddress( $uid) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Creating blank address, either for employee or organization, from uid: $uid");
   	$sql="INSERT INTO $this->tableaddress (updatedby,student_id,isactive,".
		"organization_id,created,createdby,updated,area_id,address_name) values ($uid,0,'Y',0,'$timestamp',$uid,'$timestamp',0,'Permanent Address');";
	$this->log->showLog(4,"sql statement: $sql");
	$rs=$this->xoopsDB->query($sql);
	
	if(!$rs){
		$this->log->showLog(1,"Failed to created address, return created address_id:0");
		return 0;
	}
	else{
		$sqlnew_id="SELECT max(address_id) as newaddress_id from $this->tableaddress";
		$this->log->showLog(4,"Address created, run sql to get new address_id: $sql");
		$query_new_id=$this->xoopsDB->query($sqlnew_id);
		if ($row=$this->xoopsDB->fetchArray($query_new_id)){
		$this->log->showLog(3,"Address created, with address_id:" . $row['address_id']);
		return $row['newaddress_id'];
		}
		else {
		$this->log->showLog(1,"Failed to ceated address, return created address_id:0");
		return 0;
		}		
	}
	return 0;
  } // end of member function insertAddress

  /**
   * Fetch Address information from database into class
   *
   * @return bool
   * @access public
   */
  public function fetchAddress($address_id) {
	$this->log->showLog(3,"Fetching address($address_id) information.");
	$sql="SELECT a.address_name,a.no,a.street1,a.street2,a.postcode,a.city,a.state,a.country,a.isactive,t.area_id,t.area_name from $this->tableaddress a inner join $this->tablearea t on  a.area_id=t.area_id where a.address_id=$address_id";
	$this->log->showLog(4,"SQL command to get the address:$sql.");
	
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->address_name=$row['address_name'];
		$this->no=$row['no'];
		$this->street1=$row['street1'];
		$this->street2=$row['street2'];
		$this->area_id=$row['area_id'];
		$this->area_name=$row['area_name'];
		$this->postcode=$row['postcode'];
		$this->city=$row['city'];
		$this->state=$row['state'];
		$this->country=$row['country'];
		$this->isactive=$row['isactive'];
		$this->log->showLog(3,"Address($address_id) retrieve from database successfully.");
		return true;
	}
	else
	{
		$this->log->showLog(1,"Error: Can't fetch address($address_id) from database.");
		return false;
	}
  } // end of member function fetchAddressInfo
 
 public function showAddress($address_id)
	{
	$this->fetchAddress( $address_id);
	$str_address=	"<b>$this->address_name </b><br> $this->no, $this->street1,<br> $this->street2, <br>".
			"$this->postcode, $this->city, <br> $this->state, $this->country";
	return $str_address;
}

 public function showAddressTable()
	{
	$sql="SELECT a.address_name,a.address_id,a.student_id,a.no,a.street1,a.street2,a.postcode,a.city,a.state,a.country,a.isactive,t.area_id,t.area_name from $this->tableaddress a inner join $this->tablearea t where a.student_id='$this->student_id' and a.area_id=t.area_id order by address_id";
	$this->log->showLog(4,"SQL command to get the address:$sql.");
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
	<tbody>
	<tr><th class='head' colspan='11'>Contact Address</th></tr>
	<tr>
		<th class='head'>Seq No.</th>
		<th class='head'>Address<br>Name</th>
		<th class='head'>No.</th>
		<th class='head'>Street</th>
		<th class='head'>Taman</th>
		<th class='head'>Postcode</th>
		<th class='head'>City</th>
		<th class='head'>State</th>
		<th class='head'>Country</th>
		<th class='head'>Active</th>
		<th class='head'>Operation</th>
	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$address_id=$row['address_id'];
		$student_id=$row['student_id'];
		$address_name=$row['address_name'];
		$no=$row['no'];
		$street1=$row['street1'];
		$street2=$row['street2'];
		$postcode=$row['postcode'];
		$city=$row['city'];
		$state=$row['state'];
		$country=$row['country'];
		$isactive=$row['isactive'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$address_name</td>
			<td class="$rowtype" style="text-align:center;">$no</td>
			<td class="$rowtype">$street1</td>
			<td class="$rowtype">$street2</td>
			<td class="$rowtype">$postcode</td>
			<td class="$rowtype">$city</td>
			<td class="$rowtype">$state</td>
			<td class="$rowtype">$country</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;"><form action="address.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this record'>
				<input type="hidden" value="$address_id" name="address_id">
				<input type="hidden" value="$student_id" name="student_id">
				<input type="hidden" name="action" value="edit">
				</form></td>
		</tr>
EOF;
	}//end of while
echo  "</tr></tbody></table>";

}

  public function getLatestAddressID() {
	$sql="SELECT MAX(address_id) as address_id from $this->tableaddress;";
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['address_id'];
	else
	return -1;
  } // end of member function getLatestOrganizationID

  public function fetchStudentInfo($student_id)
	{
	$this->log->showLog(3,"Fetching student($student_id) information.");
	$sql="SELECT student_code, student_name from $this->tablestudent where student_id=$student_id";
	$this->log->showLog(4,"SQL command to get the student:$sql.");

	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->student_code=$row['student_code'];
		$this->student_name=$row['student_name'];
	$backsturecord="<input name='submit' value='Back to Personal Data' type='submit'>".
			"<input name='student_id' value='$student_id' type='hidden'>".
			"<input name='action' value='edit' type='hidden'></form>";
	$jumptotopayment="<Form action='regclass.php' method='POST'>".
				"<input name='submit' value='Jump To Class Registration' type='submit'>".
				"<input name='action' value='choosed' type='hidden'>".
				"<input name='student_id' value='$student_id' type='hidden'>".
				"</form>";
	
echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Address Info</span></big></big></big></div><br>
<table style="text-align:left width: 100%" border="1" cellpadding="0" cellspacing="3">
<tbody>
      <tr>
        <th colspan="4" rowspan="1">
		<table border='0' style='width:40%'>
			<tbody>
				<tr>
					<td>
						<Form action='student.php' method='POST'>Student Info  $backsturecord
					</td>
					<td>$jumptotopayment
					</td>
				</tr>
			</tbody>
		</table>
	</th>
      </tr>
	<tr>
		<td class='head'>Student Code</td>
		<td class='odd'>$this->student_code</td>
		<td class='head'>Student Name</td>
		<td class='odd'><a href="student.php?action=edit&student_id=$this->student_id" target="_blank">$this->student_name</a></td>
	</tr>
</tbody>
</table>
EOF;
return $student_id;
		}
	else
	{
		$this->log->showLog(1,"Error: Can't fetch student($student_id) from database.");
		return false;
	}
	

} // end of fetchStudentInfo

  public function fetchEmployeeInfo($employee_id)
	{
	$this->log->showLog(3,"Fetching employee ($employee_id) information.");
	$sql="SELECT employee_no, employee_name from $this->tableemployee where employee_id=$employee_id";
	$this->log->showLog(4,"SQL command to get the employee:$sql.");

	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->employee_no=$row['employee_no'];
		$this->employee_name=$row['employee_name'];
	$backsturecord="<input name='submit' value='Back to Personal Data' type='submit'><input name='employee_id' value='$employee_id' type='hidden'><input name='action' value='edit' type='hidden'></form>";	
echo <<< EOF
<table style="text-align:left width: 100%" border="1" cellpadding="0" cellspacing="3">
<tbody>
      <tr>
        <th colspan="4" rowspan="1"><Form action='employee.php' method='POST'>Employee Info  $backsturecord</th>
      </tr>
	<tr>
		<td class='head'>Employee Code</td>
		<td class='odd'>$this->employee_no</td>
		<td class='head'>Employee Name</td>
		<td class='odd'>$this->employee_name</td>
	</tr>
</tbody>
</table>
EOF;
return $employee_id;
		}
	else
	{
		$this->log->showLog(1,"Error: Can't fetch employee ($employee_id) from database.");
		return false;
	}
} // end of fetchEmployeeInfo

public function getAreaList($id){
	$this->log->showLog(3,"Retrieve available area from database");

	$sql="SELECT area_id, area_name from $this->tablearea order by area_name ";
	$areactrl="<SELECT name='area_id' >";
	$selected="";
	if ($id==-1)
		$areactrl=$areactrl . '<OPTION value="-1" SELECTED="SELECTED">Unknown</OPTION>';

	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query)){
		$area_id=$row['area_id'];
		$area_name=$row['area_name'];
		if($id==$area_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		
		$areactrl=$areactrl  . "<OPTION value='$area_id' $selected>$area_name</OPTION>";
		$this->log->showLog(4,"Retrieving area_id:$area_id area_name:$area_name");
	}
	$areactrl=$areactrl . "</SELECT>";
	return $areactrl;
}//end of getAreaList

 public function allowDelAddress( $address_id ) {
    	$this->log->showLog(2,"Verify whether address_id : $address_id can be remove from database");
	$sql="SELECT count(studentclass_id) as qty from $this->tablestudentclass where comeareafrom_id=$address_id or backareato_id=$address_id";
	$this->log->showLog(4,"With SQL: $sql");

	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$qty=$row['qty'];
		if($qty>0){
		$this->log->showLog(3,"Found $qty record under table studentclass, this student undeletable!");
		return false;
		}
		else{
		$this->log->showLog(3,"This address is deletable after verification!");
		return true;
		}
	}
  } 
}
?>

<?php
/************************************************************************
Class Customer.php - Copyright kfhoo
**************************************************************************/
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class Customer
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/


  public $customer_id;
  public $customer_no;
  public $customer_name;
  public $isactive;
  public $isdefault;
  public $ic_no;
  public $gender = "M";
  public $cur_name;
  public $cur_symbol;
  public $dateofbirth;
  public $joindate;
  public $showcalendar;
  public $hp_no;
  public $street_1;
  public $street_2;
  public $tel_1;
  public $remarks;
  public $country;
  public $state;
  public $city;
  public $postcode;
  public $racesctrl;
  public $address_id;
  public $customertype;
  public $organization_id;
  public $created;
  public $createdby;
  public $updated;
  public $orgWhereString;
  public $uid;
  public $updatedby;
  public $races_id;
  public $isAdmin;
  public $orgctrl;
  public $customertypectrl;
  public $pageno;
  public $isshowall;
  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $tablecustomer;
  private $tablecustomertype;
  private $tableraces;
  private $tablesales;
  private $tablepromotion;
  private $tablecustomerservice;
  private $tableemployee;
//  private $tableaddress;
  private $tabletuitionclass;
  private $log;
  private $ad;

  
  /**
   * @access public, constructor
   */
  public function customer($xoopsDB, $tableprefix, $log, $ad){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablecustomer=$tableprefix . "simsalon_customer";
	$this->tablecustomertype=$tableprefix . "simsalon_customertype";
//	$this->tableaddress=$tableprefix . "simsalon_address";
	$this->tableorganization=$tableprefix."simsalon_organization";
	$this->tabletuitionclass=$tableprefix."simsalon_tuitionclass";
	$this->tableraces=$tableprefix."simsalon_races";
	$this->tablesales=$tableprefix."simsalon_sales";
	$this->tablepromotion=$tableprefix."simsalon_promotion";
	$this->tablecustomerservice=$tableprefix."simsalon_customerservice";
	$this->tableemployee=$tableprefix."simsalon_employee";
	$this->log=$log;
	$this->ad=$ad;
   }


  public function getSQLStr_Allcustomer( $wherestring,  $orderbystring,  $startlimitno ) {
	if($wherestring=="")
	$wherestring .= " where a.customertype = b.customertype_id ";
	else
	$wherestring .= " and a.customertype = b.customertype_id ";

    	$sql= "SELECT * FROM $this->tablecustomer a, $this->tablecustomertype b $wherestring $orderbystring";
	$this->log->showLog(4,"Calling getSQLStr_Allcustomer:" .$sql);
   return $sql;
  } // end of member function getSQLStr_Allcustomer

  /**
   *
   * @param string type 'new'or 'edit'
   * @param int customer_id 
   * @return bool
   * @access public
   */
  public function getInputForm( $type,  $customer_id, $token) {
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	if ($type=="new"){
		$header="New Customer";
		$action="create";
		if($customer_id==0){

		$this->customer_id="";
		$this->customer_no=$this->getNextIndex();
		$this->customer_name="";
		$this->ic_no="";
		$this->gender="";
		$this->dateofbirth="";
		$this->joindate=date("Y-m-d", time());
		$this->hp_no="";
		$this->street_1="";
		$this->street_2="";
		$this->tel_1="";
		$this->remarks="";
		$this->races_id=0;
		$this->organization_id="";
		$this->uid=0;
		$this->customertype="";
		}
		$this->address_id="0";
		//$address="Null(Save organization before edit address.)";
		$addressctl="";
		$savectrl="<input style='height:40px;' name='btnSave' value='Save' type='submit'>";
		$checked='CHECKED';
		$deletectrl='';
		$addnewctrl='';
	}
	else
	{
		if($this->customer_id>0){
		$action='update';
		//$address=$this->ad->showAddress($this->address_id);
		//$addressctl='<input type="submit" value="Address" name="submit"><input type="hidden" value="$this->customer_id" 
		//	name="customer_id"><input type="hidden" value="$this->address_id" name="address_id">'.
		//	'<input name="student_id" value="0"  type="hidden"><input type="hidden" value="edit" name="action">';
		//$addressctl='<input type="button" value="Change" name="btnAddress" onClick="showAddressWindow($this->address_id)">';
		if($this->allowDeletecustomer($this->customer_id) && $this->customer_id>0){
			$deletectrl="<FORM action='customer.php' method='POST' onSubmit='return confirm(".'"confirm to remove this customer?"'.")'><input style='height:40px;' type='submit' value='Delete' name='btnDelete'><input type='hidden' value='".$this->customer_id."' name='customer_id'><input type='hidden' value='delete' name='action'><input name='token' value='".$token."' type='hidden'></form>";
		}
		$addnewctrl="<form action='customer.php' method='POST'><input name='btnNew' value='New' type='submit' style='height:40px;'></form>";
		$header='Edit customer';
		} 
		else{
		$action='create';
		$header='New customer';
		}
		
//		$addressctl='<input type="button" value="Update Address" name="btnAddress" onClick="showAddressWindow($this->address_id);">';
		
		$savectrl="<input name='customer_id' value='".$this->customer_id."' type=hidden>".
			 "<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is "Y"
		if ($this->isactive=="Y")
			$checked='CHECKED';
		else
			$checked='';

		//force isdefault checkbox been checked if the value in db is "Y"
		if ($this->isdefault=="Y")
			$checked2='CHECKED';
		else
			$checked2='';

		$select_m='';
		$select_f='';
		
		if ($this->gender=='M')
			$select_m='SELECTED=SELECTED';
		else
			$select_f='SELECTED=SELECTED';
		$select_g='';
		$select_t='';
		
		if ($this->customertype=='G')
			$select_g='SELECTED=SELECTED';
		elseif($this->customertype=='F')
			$select_t='SELECTED=SELECTED';
		else
			$select_p='SELECTED=SELECTED';
		
		$selectracemalay='';
		$selectracechina='';
		$selectraceindia='';
		$selectraceother='';

			


		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='".$this->tablecustomer."' type='hidden'>".
		"<input name='id' value='".$this->customer_id."' type='hidden'>".
		"<input name='idname' value='customer_id' type='hidden'>".
		"<input name='title' value='customer' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";
		
	}
     //echo $this->joindate;
echo <<< EOF
<br><table style='width:250px;'><tbody><td>$addnewctrl</td><td><form method='post' action='customer.php' name='frmCustomer' onSubmit='return validateCustomer()'><input name='reset' value='Reset' type='reset' style='height:40px;'>
<input name="btnSearch" value="Search" type="button" onclick="showSearch();" style='height:40px;'>
</td></tbody></table>
<div id='getInputFormId'>
<table style='text-align: left; width: 100%;' border='1' cellpadding='0' cellspacing='3'>
<tbody>
      <tr>
        <th colspan='4' rowspan='1'>$header</th> 
      </tr>
	<tr>
		<td class='head'>Index No (Number Only)</td>
		<td class='odd' acolspan="3"><input name='customer_no' value="$this->customer_no"><A>     </A>Active <input type='checkbox' "$checked" name='isactive'><A>     </A>Default <input type='checkbox' "$checked2" name='isdefault'></td>
		
		<td class='head'>Join Date</td>
		<td class='odd'><input name='joindate' id='joindate' value="$this->joindate">&nbsp;<button style='width: 50px;' name='date' type='button' onclick="$this->showcalendar2">Date</button></td>

		<td class='head' style="display:none">Organization</td>
		<td class='odd' style="display:none">$this->orgctrl</td>
	</tr>
	<tr>
		<td class='head'>Name</td>
		<td class='even'><input size='40' name='customer_name' value="$this->customer_name"></td>
		<td class='head'>IC No.</td>
		<td class='even'>
			<input size='12' name='ic_no' value="$this->ic_no">&nbsp;<small><small><span style='color: rgb(51, 51, 255);'>exp: 840115015598</span> </small></small>
		</td>
		
	</tr>
	<tr>
		<td class='head'>Gender / Races</td>
		<td class='odd'>
			<select name='gender'>
				<option value='F' "$select_f">Female</option>
				<option value='M' "$select_m">Male</option>
			</select>
			$this->racesctrl		
		</td>

		<td class='head'>Date of Birth</td>
		<td class='odd'><input name='dateofbirth' id='dateofbirth' value="$this->dateofbirth">&nbsp;<button style='width: 50px;' name='date' type='button' onclick="$this->showcalendar">Date</button></td>
	</tr>
	<tr>
		<td class='head'>H/P Contact</td>
		<td class='even'><input name='hp_no' value="$this->hp_no"></td>
		<td class='head'>House Contact</td>
		<td class='even'><input name='tel_1' value="$this->tel_1"></td>
	</tr>

	<tr>
		<td class='head'>Street 1</td>
		<td class='odd'><input name='street_1' value="$this->street_1" maxlength='100' size='30'></td>
		<td class='head'>Street 2</td>
		<td class='odd'><input name='street_2' value="$this->street_2" maxlength='100' size='30'></td>
	</tr>

	<tr>
		<td class="head">Postcode</td>
		<td class="even"><input name='postcode' value="$this->postcode" maxlength='10' size='10'></td>
		<td class='head'>City</td>
		<td class='even'><input name='city' value="$this->city" maxlength='30' size='20'></td>
	</tr>

	<tr>
		<td class='head'>State</td>
		<td class='odd'><input name='state' value="$this->state" maxlength='30' size='20'></td>
		<td class='head'>Country</td>
		<td class='odd'><input name='country' value="$this->country" maxlength='20' size='20'></td>
		
	</tr>

	<tr>
		<td class='head'>Customer Type</td>
		<td class='even'>$this->customertypectrl</td>
		<td class="head">Remarks</td>
		<td class="even" acolspan="3"><textarea name="remarks" cols="50" rows="1">$this->remarks</textarea></td>
	</tr>
</tbody>
</table>
</div>
<table style='width:240px;'><tbody><td>$savectrl
	<input name='action' value="$action" type='hidden'>
	<input name='token' value="$token" type='hidden'></td>
	</form><td></td><td>$deletectrl</td></tbody></table><br>
$recordctrl
<br>
<table astyle='width:100px;' style="display:none"><tr>
<td nowrap><a style='cursor:pointer' onclick=' showSearchForm();'><div id='txtSearch'>Show Search Option</div></a></td>
</tr></table>

EOF;

  } // end of member function getInputForm

  /**
   *
   * @param int customer_id 
   * @return bool
   * @access public
   */
  public function deletecustomer( $customer_id ) {
    	$this->log->showLog(2,"Warning: Performing delete customer id : $customer_id !");
	$sql="DELETE FROM $this->tablecustomer where customer_id=$customer_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: customer ($customer_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"customer ($customer_id) removed from database successfully!");
		return true;
		
	}
	

  } // end of member function deletecustomer

 /** Verify database to check whether this customer can be delete or not
   * 
   * @param int customer_id
   * @return bool
   * @access public
   */
  public function allowDeletecustomer( $customer_id ) {
	
	$val = true;
	$tablelink = array($this->tablesales,$this->tablepromotion);
	
	$count = count($tablelink);
	$i = 0;
	while($i<$count){
	

	$sql = "SELECT count(*) as rowcount from $tablelink[$i] where customer_id = $customer_id ";
	$this->log->showLog(4,"SQL:$sql");

	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query))	
		if($row['rowcount']>0){
		$i = $count;
		$this->log->showLog(3,"record found, record not deletable");
		$val = false;
		}

	$i++;
	}


	return $val;

    	/*$this->log->showLog(2,"Verify whether customer_id : $customer_id can be remove from database");
	$sql="SELECT count(tuitionclass_id) classcount from $this->tabletuitionclass where customer_id=$customer_id";
	

	
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$classcount=$row['classcount'];
		if($classcount>0){
		$this->log->showLog(3,"Found $classcount record under table tuitionclass, this customer undeletable!");
		return false;
		}
		else{
		$this->log->showLog(3,"This customer is deletable after verification!");
		return true;
		}
	}*/
	//return true;
  } // end of member function allowDeletecustomer


  /**
   *
   * @return bool
   * @access public
   */
  public function updatecustomer( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$sql="UPDATE $this->tablecustomer SET customer_no='$this->customer_no', customer_name='$this->customer_name', ic_no='$this->ic_no', gender='$this->gender', dateofbirth='$this->dateofbirth', joindate='$this->joindate', hp_no='$this->hp_no', street_1='$this->street_1', street_2='$this->street_2', tel_1='$this->tel_1', remarks='$this->remarks', country='$this->country',state='$this->state',city='$this->city',postcode='$this->postcode',
	customertype='$this->customertype', organization_id='$this->organization_id', isactive='$this->isactive', isdefault='$this->isdefault',
	updated='$timestamp', updatedby='$this->updatedby', uid='$this->uid',races_id=$this->races_id WHERE customer_id='$this->customer_id'";
	
	$this->log->showLog(3, "Update customer_id: $this->customer_id, $this->customer_name");
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

  } // end of member function updatecustomer

  public function getLatestcustomerID() {
	$sql="SELECT MAX(customer_id) as customer_id from $this->tablecustomer;";
	$this->log->showLog(4,"Get latest customer_id with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['customer_id'];
	else
	return -1;
	
  } // end of member function getLatestOrganizationID


  public function insertcustomer( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new customer $this->customer_name");
 	$sql="INSERT INTO $this->tablecustomer (customer_no, customer_name, ic_no, gender, dateofbirth, joindate, hp_no, street_1, street_2, tel_1,remarks,
	country,state,city,postcode, customertype, organization_id, isactive,isdefault, created, createdby, updated, updatedby,races_id) values('$this->customer_no', '$this->customer_name', '$this->ic_no', '$this->gender', '$this->dateofbirth', '$this->joindate', '$this->hp_no', '$this->street_1', '$this->street_2', '$this->tel_1', '$this->remarks', '$this->country', '$this->state', '$this->city', '$this->postcode',
	'$this->customertype','$this->organization_id', '$this->isactive','$this->isdefault', '$timestamp', '$this->createdby', '$timestamp', '$this->updatedby',$this->races_id)";
	$this->log->showLog(4,"Before insert customer SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert customer $customer_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new customer $customer_name successfully"); 
		return true;
	}
} // end of member function insertcustomer

  /**
   * Fetch customer info from database into class
   *
   * @param int customer_id 
   * @return bool
   * @access public
   */
  public function fetchcustomer( $customer_id ) {
	$this->log->showLog(3,"Fetching customer detail into class customer.php.<br>");
		
	$sql="SELECT * from $this->tablecustomer where customer_id=$customer_id ";
	
	$this->log->showLog(4,"customer->fetchcustomer, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->customer_no=$row["customer_no"];
		$this->customer_name=$row["customer_name"];
		$this->ic_no=$row["ic_no"];
		$this->gender=$row["gender"];
		$this->dateofbirth=$row["dateofbirth"];
		$this->joindate=$row["joindate"];
		$this->hp_no=$row["hp_no"];
		$this->street_1=$row["street_1"];
		$this->street_2=$row["street_2"];
		$this->tel_1=$row["tel_1"];
		$this->remarks=$row["remarks"];
		$this->country=$row["country"];
		$this->state=$row["state"];
		$this->city=$row["city"];		
		$this->postcode=$row["postcode"];
		//$this->address_id=$row["address_id"];
		$this->customertype=$row["customertype"];
		$this->races_id=$row["races_id"];
		$this->organization_id=$row["organization_id"];
		$this->isactive=$row['isactive'];
		$this->isdefault=$row['isdefault'];
	$this->log->showLog(4,"customer->fetchcustomer, database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"customer->fetchcustomer,failed to fetch data into databases.");	
	}
  } // end of member function fetchcustomer

 public function selectionOrg($uid,$id){
	$this->log->showLog(3,"Retrieve available organization (select organization_id: $id) to customer_id : $uid");
	$tableusersgroups=$this->tableprefix ."groups_users_link";
	$sql="SELECT distinct(organization_id) as organization_id,organization_name from $this->tableorganization o ".
		"INNER JOIN $tableusersgroups ug on o.groupid=ug.groupid where (ug.uid=$uid and o.isactive='Y') or organization_id=$id";

	
	$this->log->showLog(3,"Wtih SQL: $sql");
	$selectctl="<SELECT name='organization_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"> </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$organization_id=$row['organization_id'];
		$organization_name=$row['organization_name'];
	
		if($id==$organization_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$organization_id' $selected>$organization_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;



  }// end of  selectionOrg($uid)


 public function orgWhereStr($uid){
	$this->log->showLog(3,"Generate sqlstring for user to see available organization data for uid : $uid");
	
	$tableusersgroups=$this->tableprefix ."groups_users_link";
	$sql="SELECT organization_id from $this->tableorganization o ".
		"INNER JOIN $tableusersgroups ug on o.groupid=ug.groupid where ug.uid=$uid and o.isactive='Y'";

	
	$this->log->showLog(3,"Wtih SQL: $sql");
	$wherestr="organization_id in(";
			
	$query=$this->xoopsDB->query($sql);
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
		
		$organization_id=$row['organization_id'];
		if ($i==0)
			$wherestr=$wherestr . $organization_id;
		else
			$wherestr=$wherestr  . ",$organization_id";
		$i++;
	}

	$wherestr=$wherestr . ")";
	$this->log->showLog(4,"Return orgWhereStr='$wherestr'");
	return $wherestr;
 } // end of orgWhereStr($uid)

 public function showcustomerTable($wherestr="",$orderstr=""){
	

	//$wherestring = " where a.expenses_id>0 ";
	
	$wherestring .= $this->getWhereString();

	if($wherestr != "")
	
	$wherestring = $wherestr;

	$this->log->showLog(3,"Showing customer Table");
	$sql=$this->getSQLStr_Allcustomer("WHERE customer_id>0 $wherestring ","ORDER BY customer_name",0);
	
	$query=$this->xoopsDB->query($sql);

	if($wherestr == ""){
	echo <<< EOF
	<form name="frmNew" action="customer.php" method="POST">
	<table>
	<tr>
	<td><input type="submit" value="New" style='height:40px;'></td>
	</tr>
	</table>
	</form>

	<form action="customer.php" method="POST" name="frmSearch">
	<input type="hidden" name="fldShow" value="">
	<input type="hidden" name="action" value="">
	<input type="hidden" value="" name="customer_id">
	<table border='1' cellspacing='3'>
	<tr>
	<td class="head">Index No</td>
	<td class="odd"><input type="text" name="customer_no" value=""></td>
	<td class="head">Customer Name</td>
	<td class="odd"><input type="text" name="customer_name" value="" size="50"></td>
	</tr>

	<tr>
	<td class="head">IC No</td>
	<td class="even"><input type="text" name="ic_no" value=""></td>
	<td class="head">Gender</td>
	<td class="even">
	<select name='gender'>
		<option value='' >Null</option>
		<option value='F' >Female</option>
		<option value='M' >Male</option>
	</select>
	</td>
	</tr>

	<tr>
	<td class="head">Customer Type</td>
	<td class="odd">$this->customertypectrl</td>
	<td class="head">Race</td>
	<td class="odd">$this->racesctrl</td>
	</tr>


	<tr>
	<td class="head">Active</td>
	<td class="even" acolspan="3">
	<select name="isactive">
	<option value="X"></option>
	<option value="Y">Yes</option>
	<option value="N">No</option>
	</select>
	</td>
	<td class="head">Default</td>
	<td class="even">
	<select name="isdefault">
	<option value="X"></option>
	<option value="Y">Yes</option>
	<option value="N">No</option>
	</select>
	</tr>
	
	<tr>
	<td class="head" colspan="4"><input type="button" value="Search" onclick="searchCustomer();" style='height:40px;'></td>
	</tr>

	</table></form>
	<br>
EOF;
	}

if($this->fldShow == "" || $wherestr != ""){
echo <<< EOF
	<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Customer No.</th>
				<th style="text-align:center;">Customer Name</th>
				<th style="text-align:center;">Customer Type</th>
				<th style="text-align:center;">H/P No.</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Default</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		
		$i++;
		$customer_no=$row['customer_no'];
		$customer_name=$row['customer_name'];
		$customertype=$row['customertype_description'];
		$hp_no=$row['hp_no'];

		/*
		if($customertype=="G")
			$customertype="Genaral";
		elseif($customertype=="F")
			$customertype="Full Time Tutor";
		else
			$customertype="Part Time Tutor";
		*/

		$customer_id=$row['customer_id'];
		$isactive=$row['isactive'];
		$isdefault=$row['isdefault'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$customer_no</td>
			<td class="$rowtype" style="text-align:center;">$customer_name</td>
			<td class="$rowtype" style="text-align:center;">$customertype</td>
			<td class="$rowtype" style="text-align:center;">$hp_no</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$isdefault</td>
			<!--<td class="$rowtype" style="text-align:center;">
				<div title="Edit this record" style="cursor:pointer" onclick= "editRecord($customer_id);">
				<img src="images/edit.gif">
				</div>
				</form>
			</td>-->

			<td class="$rowtype" style="text-align:center;">
				<form action="customer.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit"  title='Edit this record'>
				<input type="hidden" value="$customer_id" name="customer_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}//end of while
echo  "</tr></tbody></table>";
	}
 } //end of showcustomerTable


public function getSelectCustomer($id,$type='M',$function="",$fld="customer_id"){
	$this->log->showLog(3,"Retrieve available customer from database, with id: $id");
	$filterstr="";
	
	$sql="SELECT customer_id,customer_name from $this->tablecustomer where (isactive='Y' or customer_id=$id)  order by isdefault desc,customer_name asc ";
	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='$fld' onchange='$function'>";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$customer_id=$row['customer_id'];
		$customer_name=$row['customer_name'];
	
		if($id==$customer_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$customer_id' $selected>$customer_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end
 

  public function selectAvailableSysUser($id,$includenull='Y'){
	$this->log->showLog(3,"Retrieve available system users from database, with id: $id");
	$tableusers=$this->tableprefix."users";
	$sql="SELECT uid,uname from $tableusers ";
	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='uid' >";

	if($includenull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$uid=$row['uid'];
		$uname=$row['uname'];
	
		if($id==$uid)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$uid' $selected>$uname</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
   }

  public function getNextIndex(){
	$this->log->showLog(3,"Search next available customer_no");
	$sqlstudent="SELECT MAX(CAST(customer_no as SIGNED)) as customer_no FROM $this->tablecustomer";
	$query=$this->xoopsDB->query($sqlstudent);

	$nextcode=0;
	if ($row=$this->xoopsDB->fetchArray($query)) {
		$nextcode=$row['customer_no'];

		if($nextcode=="" || $nextcode==0)
			$nextcode=1;
		else
			$nextcode=$nextcode+1;
	
	}
	$this->log->showLog(3,"Get next customer no: $nextcode");
	return $nextcode;
  }

  public function searchAToZ(){
	
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search customer easily. With function searchAToZ()");

	
	$sqlfilter="SELECT DISTINCT(LEFT(customer_name,1)) as shortname FROM $this->tablecustomer b $wherestring order by b.customer_name";

	$this->log->showLog(4,"With SQL:$sqlfilter");
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	$firstname="";
	
	
	echo "<b>Customer Grouping By Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if secretarial never do filter yet, if will choose 1st secretarial listing
		
		echo "<A style='font-size:12;' href='customer.php?filterstring=$shortname'>  $shortname  </A> ";
	}
	
	$this->log->showLog(3,"Complete generate list of short cut");
		echo <<<EOF
<BR>


EOF;
return $filterstring;
	
  }

    public function getWhereString(){
	$retval = "";
	//echo $this->isactive;
	
	if($this->races_id > 0)
	$retval .= " and a.races_id LIKE '$this->races_id' ";
	if($this->customertype > 0)
	$retval .= " and a.customertype LIKE '$this->customertype' ";
	if($this->gender != "")
	$retval .= " and a.ic_no LIKE '$this->ic_no' ";
	if($this->ic_no != "")
	$retval .= " and a.ic_no LIKE '$this->ic_no' ";
	if($this->customer_name!= "")
	$retval .= " and a.customer_name LIKE '$this->customer_name' ";
	if($this->customer_no != "")
	$retval .= " and a.customer_no LIKE '$this->customer_no' ";
	if($this->isactive != "X" && $this->isactive != "")
	$retval .= " and a.isactive = '$this->isactive' ";
	if($this->isdefault != "X" && $this->isdefault != "")
	$retval .= " and a.isdefault = '$this->isdefault' ";
	//if($this->start_date != "" && $this->end_date != "")
	//$retval .= " and ( a.customer_date between '$this->start_date' and '$this->end_date' ) ";

	return $retval;
	
  }

	public function showTab(){
	
echo <<< EOF
	<iframe src="customertab.php?action=tab&customer_id=$this->customer_id" name="nameTab" id="idTab" width="100%" height="500" frameborder=0>
	
	</iframe>
EOF;
	}

 	public function customerServiceTable(){

	if($this->isshowall != "Y")
	$limit = $this->getLimitSql();
	else
	$limit = "";
	
	$sql=	"SELECT *,p.remarks as remarks1 FROM $this->tablecustomerservice p,  $this->tableemployee e, $this->tablecustomer c
	 	where c.customer_id = p.customer_id and p.employee_id = e.employee_id 
		and c.customer_id = $this->customer_id $limit ";
	
	$query=$this->xoopsDB->query($sql);

echo <<< EOF
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../../xoops.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../../themes/default/style.css">
EOF;

echo <<< EOF
<table border=0>
	<tr height="30">
	<td nowrap  width="1%" astyle="cursor:pointer" class="head"><a href="#" onclick="changeTab(1,$this->customer_id)">Customer Service</a></td>
	<td nowrap  width="1%" astyle="cursor:pointer" class="even"><a href="#" onclick="changeTab(2,$this->customer_id)">Payment History</a></td>
	<td acolspan="5" align="right">
	<form action="customerservice.php" method="POST" target="_blank">
	<input type="submit" value="New Customer Service">
	<input type="hidden" value="$this->customer_id" name="customer_id">
	</form>
	</td>
	</tr>
	<tr>
	<td colspan="3" id="idTab"></td>
	</tr>
</table>

<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Customer Service No</th>
				<th style="text-align:center;">Customer Service Date</th>
				<th style="text-align:center;">Customer</th>
				<th style="text-align:center;">Remarks</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">View</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$customerservice_id=$row['customerservice_id'];
		$customerservice_no=$row['customerservice_no'];
		$customerservice_date=$row['customerservice_date'];
		$customer_name=$row['customer_name'];
		$employee_name=$row['employee_name'];
		$remarks=$row['remarks1'];
		$filename=$row['filename'];
		
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];
		
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		$path="upload/customerservices/".$filename;
		
echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$customerservice_no</td>
			<td class="$rowtype" style="text-align:center;">$customerservice_date</td>
			<td class="$rowtype" style="text-align:center;">$customer_name</td>
			<td class="$rowtype" style="text-align:center;">$remarks</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>

			<td class="$rowtype" style="text-align:center;">
				<form action="$path" method="POST" target="_blank">
				<input type="image" src="images/list.gif" name="submit" title='View this image'>
				<input type="hidden" value="$customerservice_id" name="customerservice_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

			<td class="$rowtype" style="text-align:center;">
				<form action="customerservice.php" method="POST" target="_blank">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this record'>
				<input type="hidden" value="$customerservice_id" name="customerservice_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	if($i==0)
	echo "</tr><tr><td>No record(s) found.</td></tr>";

	if($this->pageno == "")
	$pageno = 0;
	else
	$pageno = $this->pageno;

	$prev_record = $this->getLinkRecord(1,$this->customer_id,"p",$pageno);
	$next_record = $this->getLinkRecord(1,$this->customer_id,"n",$pageno);
	
	global $limitrecord;
	$pagename = $pageno + 1;
	$floatval = ($this->getRowCountData(1,$this->customer_id)/$limitrecord);
	$intval = (int)($this->getRowCountData(1,$this->customer_id)/$limitrecord);	
	$isover = $floatval - $intval;	

	if($isover > 0)
	$pageall = (int)($this->getRowCountData(1,$this->customer_id)/$limitrecord) + 1;
	else
	$pageall = (int)($this->getRowCountData(1,$this->customer_id)/$limitrecord);

	if($this->isshowall == "Y")
	$pageall = "1";
echo <<< EOF
	</tbody></table>
	<table>
	<tr>
	<td width="87%" align="left" nowrap>Page $pagename of $pageall</td>
	<td width="10%" align="right" nowrap><a href="#" onclick="showAll(1,$this->customer_id);">Show All</a>&nbsp;&nbsp;&nbsp;</td>
	<td width="1%" align="right" nowrap>$prev_record</td>
	<td width="1%" align="right" nowrap>||</td>
	<td width="1%" align="right" nowrap>$next_record</td>
	</tr>
	</table>
EOF;

	}


	public function customerPaymentTable(){
	
	if($this->isshowall != "Y")
	$limit = $this->getLimitSql();
	else
	$limit = "";

	$sql = "SELECT *,a.isactive as isactive FROM $this->tablesales a, $this->tablecustomer b 
		where a.customer_id = b.customer_id 
		and b.customer_id = $this->customer_id $limit ";
	
	$query=$this->xoopsDB->query($sql);
echo <<< EOF
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../../xoops.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../../themes/default/style.css">
EOF;

echo <<< EOF
<table border=0>

	<tr height="30">
	<td nowrap  width="1%" astyle="cursor:pointer" class="even"><a href="#" onclick="changeTab(1,$this->customer_id)">Customer Service</a></td>
	<td nowrap  width="1%" astyle="cursor:pointer" class="head"><a href="#" onclick="changeTab(2,$this->customer_id)">Payment History</a></td>
	<td acolspan="5" align="right">
	<form action="payment.php" method="POST" target="_blank">
	<input type="submit" value="New Payment">
	<input type="hidden" value="addlist" name="action">
	<input type="hidden" value="$this->customer_id" name="customer_id">
	</form>
	</td>
	</tr>
	<tr>
	<td colspan="3" id="idTab"></td>
	</tr>
</table>

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

	if($this->pageno == "")
	$pageno = 0;
	else
	$pageno = $this->pageno;

	$prev_record = $this->getLinkRecord(2,$this->customer_id,"p",$pageno);
	$next_record = $this->getLinkRecord(2,$this->customer_id,"n",$pageno);

	global $limitrecord;
	$pagename = $pageno + 1;
	$floatval = ($this->getRowCountData(2,$this->customer_id)/$limitrecord);
	$intval = (int)($this->getRowCountData(2,$this->customer_id)/$limitrecord);	
	$isover = $floatval - $intval;

	if($isover > 0)
	$pageall = (int)($this->getRowCountData(2,$this->customer_id)/$limitrecord) + 1;
	else
	$pageall = (int)($this->getRowCountData(2,$this->customer_id)/$limitrecord);

	if($this->isshowall == "Y")
	$pageall = "1";
echo <<< EOF
	</tbody></table>

	<table>
	<tr>
	<td width="87%" align="left" nowrap>Page $pagename of $pageall</td>
	<td width="10%" align="right" nowrap><a href="#" onclick="showAll(2,$this->customer_id);">Show All</a>&nbsp;&nbsp;&nbsp;</td>
	<td width="1%" align="right" nowrap>$prev_record</td>
	<td width="1%" align="right" nowrap>||</td>
	<td width="1%" align="right" nowrap>$next_record</td>
	</tr>
	</table>
EOF;

	}

	public function getLinkRecord($tab,$customer_id,$type,$pageno){
	global $limitrecord;
	$link = "";

	if($this->isshowall == "Y"){

		if($type == "p")
		$link = "Previous";
		else
		$link = "Next";
		
	}else{

		if($type == "p"){
		$pageno--;

			if($pageno < 0)
			$link = "Previous";
			else
			$link = "<a href='#' onclick='viewNextPrevRecord($tab,$customer_id,$pageno)'>Previous</a>";

		}else{
		$pageno++;
		//echo $pageno*$limitrecord." = ".$this->getRowCountData($tab,$customer_id);
			if($pageno*$limitrecord >= $this->getRowCountData($tab,$customer_id))
			$link = "Next";
			else
			$link = "<a href='#' onclick='viewNextPrevRecord($tab,$customer_id,$pageno)'>Next</a>";

		}

	}

	return $link;
	}

	public function getLimitSql(){
	global $limitrecord;

	if($this->pageno == "")
	$pageno = 0;
	else
	$pageno = $this->pageno;
	
	$limitstart = $pageno*$limitrecord;

	return  " limit $limitstart, $limitrecord ";
	}

	public function getRowCountData($tab,$customer_id){
	$retval = 0;

	if($tab == 1)
	$sql = "select count(*) as rowcount from $this->tablecustomerservice where customer_id = $customer_id ";
	else
	$sql = "select count(*) as rowcount from $this->tablesales where customer_id = $customer_id ";
	
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval=$row['rowcount'];
	}
	return $retval;
	}


} // end of customer
?>

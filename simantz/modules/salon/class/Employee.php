<?php
/************************************************************************
Class Employee.php - Copyright kfhoo
**************************************************************************/
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
/**
 * class Employee
 * each employee handle separate drawer
 */
class Employee
{

  public $employee_id;
  public $employee_no;
  public $employee_name;
  public $isactive;
  public $isdefault;
  public $ic_no;
  public $gender = "M";
  public $cur_name;
  public $cur_symbol;
  public $dateofbirth;
  public $joindate;
  public $showcalendar;
  public $showcalendar2;
  public $epf_no;
  public $socso_no;
  public $account_no;
  public $hp_no;
  public $remarks;
  public $street1;
  public $street2;
  public $postcode;
  public $city;
  public $state;
  public $country;
  public $basic_salary;
  public $socso_employee;
  public $socso_employer;
  public $epf_employee;
  public $epf_employer;
  public $allowance1;
  public $allowance2;
  public $allowance3;
  public $allowance_name1;
  public $allowance_name2;
  public $allowance_name3;

  public $allowanceline_id;
  public $allowanceline_name;
  public $allowanceline_no;
  public $allowanceline_amount;
  public $allowanceline_epf;
  public $allowanceline_socso;
  public $allowanceline_active;
  
  
  public $tel_1;
  public $racesctrl;
  public $stafftypectrl;
  
  public $stafftype_id;
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
  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $tableemployee;
  private $tableraces;
  private $tablestafftype;
  private $tableallowanceline;
  private $tablepromotion;
  private $tablesales;
  private $tablesalesline;
  private $tablesalesemployeeline;
  private $tablepayroll;
  private $tableinternal;
  private $log;
  private $ad;
  
  /**
   * @access public, constructor
   */
  public function Employee($xoopsDB, $tableprefix, $log, $ad){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableemployee=$tableprefix . "simsalon_employee";
	//$this->tableaddress=$tableprefix . "simsalon_address";
	$this->tableorganization=$tableprefix."simsalon_organization";
	$this->tabletuitionclass=$tableprefix."simsalon_tuitionclass";
	$this->tableraces=$tableprefix."simsalon_races";
	$this->tablestafftype=$tableprefix."simsalon_stafftype";
	$this->tableallowanceline=$tableprefix."simsalon_allowanceline";
	$this->tablepromotion=$tableprefix."simsalon_promotion";
	$this->tablesales=$tableprefix."simsalon_sale";
	$this->tablesalesline=$tableprefix."simsalon_salesline";
	$this->tablesalesemployeeline=$tableprefix."simsalon_salesemployeeline";
	$this->tablepayroll=$tableprefix."simsalon_payroll";
	$this->tableinternal=$tableprefix."simsalon_internal";
	$this->log=$log;
	$this->ad=$ad;

	
   }

  /**
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllEmployee( $wherestring,  $orderbystring,  $startlimitno ) {
	$wherestring .= " and a.stafftype_id = b. stafftype_id ";
    $sql= "SELECT * FROM $this->tableemployee a, $this->tablestafftype b $wherestring $orderbystring";
	$this->log->showLog(4,"Calling getSQLStr_AllEmployee:" .$sql);
   return $sql;
  } // end of member function getSQLStr_AllEmployee

  /**
   *
   * @param string type 'new'or 'edit'
   * @param int employee_id 
   * @return bool
   * @access public
   */
  public function getInputForm( $type,  $employee_id, $token ) {

echo <<< EOF
<!--example ajax-->
<!--<form name='frmAjax'>
<input type='button' name='btnAjax' value='try' onClick="return sendRequest();">
<input type='input' name='fldAjax'>
</form>
<div id="show"></div>-->

EOF;
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$displayadd="";

	if ($type=="new"){
		$header="New Employee";
		$action="create";
		if($employee_id==0){
		$this->employee_id="";
		$this->employee_no=$this->getNextIndex();
		$this->employee_name="";
		$this->ic_no="";
		$this->gender="";
		$this->dateofbirth="";
		$this->joindate="";
		$this->epf_no="";
		$this->socso_no="";
		$this->account_no="";
		$this->hp_no="";
		$this->remarks="";
		$this->tel_1="";
		$this->races_id=0;
		$this->organization_id="";
		$this->cashonhand="";
		$this->uid=0;
		$this->stafftype_id="";
		$this->allowance1=0;
		$this->allowance2=0;
		$this->allowance3=0;
		$this->basic_salary=0;
		$this->socso_employee=0;
		$this->socso_employer=0;
		$this->epf_employee=0;
		$this->epf_employer=0;
		$displayadd="style='display:none'";

		}
		$this->address_id="0";
		$address="Null(Save organization before edit address.)";
		$addressctl="";
		$savectrl="<input style='height:40px;' name='btnSave' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
	}
	else
	{
		if($this->employee_id>0){
		$action="update";
		//$address=$this->ad->showAddress($this->address_id);
		//$addressctl="<input type='submit' value='Address' name='submit'><input type='hidden' value='$this->employee_id' 
		//	name='employee_id'><input type='hidden' value='$this->address_id' name='address_id'>".
		//	"<input name='student_id' value='0'  type='hidden'><input type='hidden' value='edit' name='action'>";
		//$addressctl="<input type='button' value='Change' name='btnAddress' onClick='showAddressWindow($this->address_id)'>";
		if($this->allowDeleteEmployee($this->employee_id) && $this->employee_id>0){
			$deletectrl="<FORM action='employee.php' method='POST' onSubmit='return confirm(".
			'"confirm to remove this employee?"'.")'><input style='height:40px;' type='submit' value='Delete' name='btnDelete'>".
			"<input type='hidden' value='$this->employee_id' name='employee_id'>".
			"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		}
		$addnewctrl="<Form action='employee.php' method='POST'><input style='height: 40px;' name='btnSave' value='New' type='submit'></form>";
		$header="Edit Employee";
		} 
		else{
		$action="create";
		$header="New Employee";
		}
		
//		$addressctl="<input type='button' value='Update Address' name='btnAddress' onClick='showAddressWindow($this->address_id);'>";
		
		$savectrl="<input name='employee_id' value='$this->employee_id' type='hidden'>".
			 "<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		if ($this->isdefault=='Y')
			$checked2="CHECKED";
		else
			$checked2="";
		
		$select_m="";
		$select_f="";
		
		if ($this->gender=="M")
			$select_m="SELECTED='SELECTED'";
		else
			$select_f="SELECTED='SELECTED'";
		$select_g="";
		$select_t="";
		
		if ($this->stafftype_id=="G")
			$select_g="SELECTED='SELECTED'";
		elseif($this->stafftype_id=="F")
			$select_t="SELECTED='SELECTED'";
		else
			$select_p="SELECTED='SELECTED'";
		
		$selectracemalay="";
		$selectracechina="";
		$selectraceindia="";
		$selectraceother="";

			


		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableemployee' type='hidden'>".
		"<input name='id' value='$this->employee_id' type='hidden'>".
		"<input name='idname' value='employee_id' type='hidden'>".
		"<input name='title' value='Employee' type='hidden'>".
		"<input name='btnRcord' value='View Record Info' type='submit'>".
		"</form>";
		
	}

	$selectemployee = 	"<Form action='employee.php' method='POST'>
				<input style='height: 40px;' name='btnSelect' value='Search' type='submit'>
				<input type='hidden' name='action' value='selectemployee'>
				</form>";
     
echo <<< EOF

<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Employees Record</span></big></big></big></div><br>
<table style="width:140px;">$recordctrl<tbody><td>$addnewctrl</td><td>$deletectrl</td><td>$selectemployee</td>
<td>
<form method="post" action="employee.php" name="frmEmployee"  onSubmit='return validateEmployee()'><input name="reset" value="Reset" type="reset" style='height: 40px;'></td></tbody></table>
<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
<tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th> 
      </tr>
	<tr>
		<td class="head">Index No (Number Only)</td>
		<td class="odd" colspan="3"><input name="employee_no" value="$this->employee_no"><A>     </A>Active <input type="checkbox" $checked name="isactive">&nbsp;&nbsp;Default <input type="checkbox" $checked2 name="isdefault"></td>
		<td class="head" style="display:none">Organization</td>
		<td class="odd" style="display:none">$this->orgctrl</td>
	</tr>
	<tr>
		<td class="head">Name</td>
		<td class="even"><input size="40" name="employee_name" value="$this->employee_name"></td>
		<td class="head">IC No.</td>
		<td class="even">
			<input size="12" name="ic_no" value="$this->ic_no">&nbsp;<small><small><span style="color: rgb(51, 51, 255);">exp: 840115015598</span> </small></small>
		</td>
		
	</tr>
	<tr>
		<td class="head">Gender / Races</td>
		<td class="odd">
			<select name="gender">
				<option value="F" $select_f>Female</option>
				<option value="M" $select_m>Male</option>
			</select>
			$this->racesctrl		
		</td>

		<td class="head">Date of Birth</td>
		<td class="odd"><input name="dateofbirth" id='dateofbirth' value="$this->dateofbirth">&nbsp;<button style="width: 50px;" name="date" type="button" onclick="$this->showcalendar">Date</button></td>
	</tr>
	<tr>
		<td class="head">EPF No.</td>
		<td class="even"><input name="epf_no" value="$this->epf_no"></td>
		<td class="head">Bank Acc. No.</td>
		<td class="even"><input name="account_no" value="$this->account_no"></td>
		
	</tr>
	<tr>
		<td class="head">House Contact</td>
		<td class="odd"><input name="tel_1" value="$this->tel_1"></td>
		<td class="head">H/P Contact</td>
		<td class="odd"><input name="hp_no" value="$this->hp_no"></td>
	</tr>
	
	<tr style="display:none">
		<td class="head">Allowance 1 Name</td>
		<td class="even"><input name="allowance_name1" value="$this->allowance_name1" maxlength="50" size="35"></td>
		<td class="head">Allowance 1($this->cur_symbol)</td>
		<td class="odd"><input name="allowance1" value="$this->allowance1" maxlength="10" size="10"></td>
	</tr>

	<tr style="display:none">
		<td class="head">Allowance 2 Name</td>
		<td class="even"><input name="allowance_name2" value="$this->allowance_name2" maxlength="50" size="35"></td>
		<td class="head">Allowance 2($this->cur_symbol)</td>
		<td class="odd"><input name="allowance2" value="$this->allowance2" maxlength="10" size="10"></td>
	</tr>

	<tr style="display:none">
		<td class="head">Allowance 3 Name</td>
		<td class="even"><input name="allowance_name3" value="$this->allowance_name3" maxlength="50" size="35"></td>
		<td class="head">Allowance 3($this->cur_symbol)</td>
		<td class="odd"><input name="allowance3" value="$this->allowance3" maxlength="10" size="10"></td>
	</tr>

	<tr style="display:none">
		<td class="head">Socso Employee (%)</td>
		<td class="odd"><input name="socso_employee" value="$this->socso_employee" maxlength="10" size="10"></td>
		<td class="head">Socso Employer (%)</td>
		<td class="odd"><input name="socso_employer" value="$this->socso_employer" maxlength="10" size="10"></td>
	</tr>

	<tr style="display:none">
		<td class="head">EPF Employee (%)</td>
		<td class="odd"><input name="epf_employee" value="$this->epf_employee" maxlength="10" size="10"></td>
		<td class="head">EPF Employer (%)</td>
		<td class="odd"><input name="epf_employer" value="$this->epf_employer" maxlength="10" size="10"></td>
	</tr>


	<tr>
		<td class="head">Basic Salary ($this->cur_symbol)</td>
		<td class="even" acolspan="3"><input name="basic_salary" value="$this->basic_salary" maxlength="10" size="10"></td>
		<td class="head">Staff Group</td>
		<td class="even">$this->stafftypectrl</td>
	</tr>

	<tr>
		<td class='head'>Street 1</td>
		<td class='odd'><input name='street1' value="$this->street1" maxlength='100' size='30'></td>
		<td class='head'>Street 2</td>
		<td class='odd'><input name='street2' value="$this->street2" maxlength='100' size='30'></td>
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
		<td class="head">Remarks</td>
		<td class="odd" acolspan="3"><textarea name="remarks" cols="60" rows="1">$this->remarks</textarea></td>
		<td class="head">Join Date</td>
		<td class="odd"><input name="joindate" id='joindate' value="$this->joindate">&nbsp;<button style="width: 50px;" name="date" type="button" onclick="$this->showcalendar2">Date</button></td>
	</tr>

</tbody>
</table>
<table style="width:240px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden">
	<input name="line" value="" type="hidden">
	</td>
	</tbody></table>
<br>

<table style="width:300px">
<tr $displayadd>
	<td class="head">List Allowance :</td>
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

	$sql = "SELECT * FROM $this->tableallowanceline WHERE employee_id = $this->employee_id ORDER BY allowanceline_no ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);

echo <<< EOF
	<table border=1>
	<tr align="center">
		<th>No</th>
		<th>Seq</th>
		<th>Allowance Name</th>
		<th>EPF</th>
		<th>SOCSO</th>
		<th>Active</th>
		<th>Amount (RM)</th>
		<th></th>
	</tr>
	
EOF;

	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$checked = "";
	$checked2 = "";
	$checked3 = "";

	$allowanceline_id = $row['allowanceline_id'];
	$allowanceline_no = $row['allowanceline_no'];
	$allowanceline_name = $row['allowanceline_name'];
	$allowanceline_amount = $row['allowanceline_amount'];
	$allowanceline_epf = $row['allowanceline_epf'];
	$allowanceline_socso = $row['allowanceline_socso'];
	$allowanceline_active = $row['allowanceline_active'];

	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

	if ($allowanceline_epf=='Y')
	$checked = "CHECKED";
	if ($allowanceline_socso=='Y')
	$checked2 = "CHECKED";
	if ($allowanceline_active=='Y')
	$checked3 = "CHECKED";

echo <<< EOF
	<input type="hidden" name="allowanceline_id[$i]" value="$allowanceline_id">
	<tr align="center">
		<td class="$rowtype">$i</td>
		<td class="$rowtype"><input type="text" size="3" maxlength="5" name="allowanceline_no[$i]" value="$allowanceline_no"></td>
		
		
		<td class="$rowtype"><input type="text" size="35" maxlength="50" name="allowanceline_name[$i]" value="$allowanceline_name"></td>
		<td class="$rowtype"><input type="checkbox" $checked name="allowanceline_epf[$i]" ></td>
		<td class="$rowtype"><input type="checkbox" $checked2 name="allowanceline_socso[$i]" ></td>
		<td class="$rowtype"><input type="checkbox" $checked3 name="allowanceline_active[$i]" ></td>
		<td class="$rowtype"><input type="text" size="7" maxlength="10" name="allowanceline_amount[$i]" value="$allowanceline_amount"></td>
		<td class="$rowtype"><input type="button" value="Delete" onclick="deleteLine($allowanceline_id);"></td>

	</tr>
EOF;
	}
	if($i == 0){
	echo "<tr><td colspan='8'>Please Add Allowance Line.</td></tr>";
	}

echo <<< EOF
</table>
<br>
EOF;

	
  }

  /**
   *
   * @param int employee_id 
   * @return bool
   * @access public
   */
  public function deleteEmployee( $employee_id ) {
    	$this->log->showLog(2,"Warning: Performing delete employee id : $employee_id !");
	$sql="DELETE FROM $this->tableemployee where employee_id=$employee_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: employee ($employee_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Employee ($employee_id) removed from database successfully!");
		return true;
		
	}
	

  } // end of member function deleteEmployee


  public function allowDeleteEmployee( $employee_id ) {

	$val = true;
	$tablelink = array($this->tablesalesemployeeline,$this->tablepayroll,$this->tableinternal);
	
	$count = count($tablelink);
	$i = 0;
	while($i<$count){
	

	$sql = "SELECT count(*) as rowcount from $tablelink[$i] where employee_id = $employee_id ";
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
	/*
    	$this->log->showLog(2,"Verify whether employee_id : $employee_id can be remove from database");
	$sql="SELECT count(tuitionclass_id) classcount from $this->tabletuitionclass where employee_id=$employee_id";
	

	
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$classcount=$row['classcount'];
		if($classcount>0){
		$this->log->showLog(3,"Found $classcount record under table tuitionclass, this employee undeletable!");
		return false;
		}
		else{
		$this->log->showLog(3,"This employee is deletable after verification!");
		return true;
		}
	}
	return true;
	*/

  } // end of member function allowDeleteEmployee


  public function updateEmployee( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$sql="UPDATE $this->tableemployee SET employee_no='$this->employee_no', employee_name='$this->employee_name', ic_no='$this->ic_no', gender='$this->gender', dateofbirth='$this->dateofbirth', joindate='$this->joindate', epf_no='$this->epf_no', socso_no='$this->socso_no', account_no='$this->account_no', hp_no='$this->hp_no', remarks='$this->remarks', basic_salary=$this->basic_salary,
	street1='$this->street1', street2='$this->street2', postcode='$this->postcode', city='$this->city', state='$this->state', country='$this->country' ,
	socso_employee=$this->socso_employee,socso_employer=$this->socso_employer,epf_employee=$this->epf_employee,
	epf_employer=$this->epf_employer,
	allowance1=$this->allowance1,
	allowance2=$this->allowance2, allowance3=$this->allowance3, allowance_name1='$this->allowance_name1',
	allowance_name2='$this->allowance_name2',  allowance_name3='$this->allowance_name3',
	tel_1='$this->tel_1', stafftype_id=$this->stafftype_id, cashonhand='$this->cashonhand', organization_id='$this->organization_id',isactive='$this->isactive',isdefault='$this->isdefault',updated='$timestamp', updatedby='$this->updatedby', uid='$this->uid',races_id=$this->races_id WHERE employee_id='$this->employee_id'";
	
	$this->log->showLog(3, "Update employee_id: $this->employee_id, $this->employee_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update employee failed");
		return false;
	}
	else{
		$this->updateLine();
		$this->log->showLog(3, "Update employee successfully.");
		return true;
	}

  } // end of member function updateEmployee

    public function updateLine(){
	$row = count($this->allowanceline_id);
	
	$i=0;
	while($i<$row){
	$i++;
	
	$allowanceline_id = $this->allowanceline_id[$i] ;
	$allowanceline_no = $this->allowanceline_no[$i] ;
	$allowanceline_name = $this->allowanceline_name[$i];
	$allowanceline_amount = $this->allowanceline_amount[$i];
	$allowanceline_epf = $this->allowanceline_epf[$i];
	$allowanceline_socso = $this->allowanceline_socso[$i];
	$allowanceline_active = $this->allowanceline_active[$i];


	if($allowanceline_epf=="on")
	$allowanceline_epf = 'Y';
	else
	$allowanceline_epf = 'N';

	if($allowanceline_socso=="on")
	$allowanceline_socso = 'Y';
	else
	$allowanceline_socso = 'N';

	if($allowanceline_active=="on")
	$allowanceline_active = 'Y';
	else
	$allowanceline_active = 'N';

	
	$sql = "UPDATE $this->tableallowanceline SET
		allowanceline_no = $allowanceline_no,
		allowanceline_name = '$allowanceline_name',
		allowanceline_amount = $allowanceline_amount,
		allowanceline_epf = '$allowanceline_epf',
		allowanceline_socso = '$allowanceline_socso',
		allowanceline_active = '$allowanceline_active'
		WHERE employee_id = $this->employee_id and allowanceline_id = $allowanceline_id";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update allowance failed");
		return false;
	}

	}

	return true;

  }

  public function getLatestEmployeeID() {
	$sql="SELECT MAX(employee_id) as employee_id from $this->tableemployee;";
	$this->log->showLog(4,"Get latest employee_id with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['employee_id'];
	else
	return -1;
	
  } // end of member function getLatestOrganizationID

  /**
   *
   * @return bool
   * @access public
   */
  public function insertEmployee( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new employee $this->employee_name");
 	$sql="INSERT INTO $this->tableemployee (employee_no, employee_name, ic_no, gender, dateofbirth, joindate, epf_no, socso_no, account_no, 
	 hp_no, remarks, street1, street2, postcode, city, state, country, 
	basic_salary,socso_employee,socso_employer,epf_employee,epf_employer,allowance1, allowance2, allowance3, allowance_name1, 
	allowance_name2, allowance_name3,
	 tel_1, stafftype_id, cashonhand, organization_id, isactive, isdefault, created, createdby, updated, updatedby,races_id) values('$this->employee_no', '$this->employee_name', '$this->ic_no', '$this->gender', '$this->dateofbirth', '$this->joindate', '$this->epf_no', '$this->socso_no', '$this->account_no', '$this->hp_no','$this->remarks', '$this->street1', '$this->street2', '$this->postcode', '$this->city', '$this->state', '$this->country', 
	$this->basic_salary, $this->socso_employee,$this->socso_employer,$this->epf_employee,$this->epf_employer,
	$this->allowance1, $this->allowance2, $this->allowance3, '$this->allowance_name1', '$this->allowance_name2', '$this->allowance_name3',
	'$this->tel_1', $this->stafftype_id,'$this->cashonhand', '$this->organization_id', '$this->isactive', '$this->isdefault', '$timestamp', '$this->createdby', '$timestamp', '$this->updatedby',$this->races_id)";
	$this->log->showLog(4,"Before insert employee SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert employee $employee_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new employee $employee_name successfully"); 
		return true;
	}
} // end of member function insertEmployee


  public function fetchEmployee( $employee_id ) {
	$this->log->showLog(3,"Fetching employee detail into class Employee.php.<br>");
		
	$sql="SELECT * from $this->tableemployee where employee_id=$employee_id";
	
	$this->log->showLog(4,"Employee->fetchEmployee, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->employee_no=$row["employee_no"];
		$this->employee_name=$row["employee_name"];
		$this->ic_no=$row["ic_no"];
		$this->gender=$row["gender"];
		$this->dateofbirth=$row["dateofbirth"];
		$this->joindate=$row["joindate"];
		$this->epf_no=$row["epf_no"];
		$this->socso_no=$row["socso_no"];
		$this->account_no=$row["account_no"];
		$this->hp_no=$row["hp_no"];
		$this->remarks=$row["remarks"];
		$this->street1=$row["street1"];
		$this->street2=$row["street2"];
		$this->postcode=$row["postcode"];
		$this->city=$row["city"];
		$this->state=$row["state"];
		$this->country=$row["country"];
		$this->basic_salary=$row["basic_salary"];
		$this->socso_employee=$row["socso_employee"];
		$this->socso_employer=$row["socso_employer"];
		$this->epf_employee=$row["epf_employee"];
		$this->epf_employer=$row["epf_employer"];
		$this->allowance1=$row["allowance1"];
		$this->allowance2=$row["allowance2"];
		$this->allowance3=$row["allowance3"];
		$this->allowance_name1=$row["allowance_name1"];
		$this->allowance_name2=$row["allowance_name2"];
		$this->allowance_name3=$row["allowance_name3"];

		$this->tel_1=$row["tel_1"];
		//$this->address_id=$row["address_id"];
		$this->stafftype_id=$row["stafftype_id"];
		$this->cashonhand=$row["cashonhand"];
		$this->races_id=$row["races_id"];
		$this->organization_id=$row["organization_id"];
		$this->isactive=$row['isactive'];
		$this->isdefault=$row['isdefault'];
	$this->log->showLog(4,"Employee->fetchEmployee, database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Employee->fetchEmployee,failed to fetch data into databases.");	
	}
  } // end of member function fetchEmployee

 public function selectionOrg($uid,$id){
	$this->log->showLog(3,"Retrieve available organization (select organization_id: $id) to employee_id : $uid");
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

 public function showEmployeeTable(){
	
	$this->log->showLog(3,"Showing Employee Table");
	$sql=$this->getSQLStr_AllEmployee("WHERE employee_id>0","ORDER BY employee_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
  		<tbody>
			<tr>
			<td>
			<form action="employee.php" method="POST">
			<input style='height: 40px;' type="submit" value="New">
			<input type="hidden" name="action" value="new">
			</form>
			</td>
			</tr>

    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Employee No.</th>
				<th style="text-align:center;">Employee Name</th>
				<th style="text-align:center;">Job Title</th>
				<th style="text-align:center;">H/P No.</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$employee_no=$row['employee_no'];
		$employee_name=$row['employee_name'];
		$stafftype_id=$row['stafftype_id'];
		$stafftype_description=$row['stafftype_description'];
		$hp_no=$row['hp_no'];
		$remarks=$row['remarks'];

		

		$employee_id=$row['employee_id'];
		$isactive=$row['isactive'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$employee_no</td>
			<td class="$rowtype" style="text-align:center;">$employee_name</td>
			<td class="$rowtype" style="text-align:center;">$stafftype_description</td>
			<td class="$rowtype" style="text-align:center;">$hp_no</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="employee.php" method="POST">
				<input type="image" src="images/edit.gif" name="imgEdit"  title='Edit this record'>
				<input type="hidden" value="$employee_id" name="employee_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}//end of while
echo  "</tr></tbody></table>";
 } //end of showEmployeeTable


public function getEmployeeList($id,$type='M',$fld='employee_id',$function=""){
	$this->log->showLog(3,"Retrieve available employee from database, with id: $id");
	$filterstr="";
	//if($type='M')
	//	$filterstr="AND stafftype_id='M'";
	$sql="SELECT employee_id,employee_name from $this->tableemployee where (isactive='Y' or employee_id=$id)  order by isdefault desc,employee_name asc ";
	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name=$fld onchange = '$function' >";
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
	$this->log->showLog(3,"Search next available employee_no");
	$sqlstudent="SELECT MAX(CAST(employee_no as SIGNED)) as employee_no FROM $this->tableemployee";
	$query=$this->xoopsDB->query($sqlstudent);

	$nextcode=0;
	if ($row=$this->xoopsDB->fetchArray($query)) {
		$nextcode=$row['employee_no'];

		if($nextcode=="" || $nextcode==0)
			$nextcode=1;
		else
			$nextcode=$nextcode+1;
	
	}
	$this->log->showLog(3,"Get next employee no: $nextcode");
	return $nextcode;
  }

    public function insertLine($row){
	$i = $this->getLatestLine("allowanceline_no");
	
	$row += $i;

	while($i<$row){
	$i++;

	$sql = "INSERT INTO $this->tableallowanceline (allowanceline_no,employee_id,allowanceline_name,allowanceline_amount) values
		($i,$this->employee_id,'',0)";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update allowance failed");
		return false;
	}

	}

	return true;

  }

   public function getLatestLine($fld){
	$retval = 0;
	$sql = "SELECT $fld from $this->tableallowanceline where employee_id = $this->employee_id ORDER BY allowanceline_no DESC";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row[$fld];
	}
	
	return $retval;
  }

    public function deleteLine($line){
	$sql = "DELETE FROM $this->tableallowanceline WHERE allowanceline_id = $line and employee_id = $this->employee_id ";


	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update allowance failed");
		return false;
	}else{
		$this->log->showLog(2, "Update allowance Successfully");
		return true;
	}

  }

} // end of Employee
?>


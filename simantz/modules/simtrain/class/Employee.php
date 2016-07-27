<?php

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
  public $ic_no;
  public $gender = "M";
  public $cur_name;
  public $cur_symbol;
  public $dateofbirth;
  public $showjoindatectrl;
  public $showcalendar;
  public $epf_no;
  public $socso_no;
  public $account_no;
  public $position;
  public $department;
  public $description;
  public $basicsalary;
  public $salarytype;
  public $hourlyamt;
  public $commissionrate;
  public $religion_id ;
  public $hp_no;
  public $tel_1;
  public $racesctrl;
  public $religionctrl;
  public $address_id;
  public $employeetype;
  public $highestqualification;
  public $highestteachlvl;
  public $subjectsteach;
  public $organization_id;
  public $joindate;
  public $created;
  public $createdby;
  public $updated;
  public $orgWhereString;
  public $uid;
  public $updatedby;
  public $races_id;
  public $isAdmin;
  public $epftype;
  public $removepic;
  public $orgctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $tableemployee;
  private $tableraces;
  private $tableaddress;
  private $tabletuitionclass;
  private $log;
  private $ad;
  
  /**
   * @access public, constructor
   */
  public function Employee($xoopsDB, $tableprefix, $log, $ad){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableemployee=$tableprefix . "simtrain_employee";
	$this->tableaddress=$tableprefix . "simtrain_address";
	$this->tableorganization=$tableprefix."simtrain_organization";
	$this->tabletuitionclass=$tableprefix."simtrain_tuitionclass";
	$this->tableraces=$tableprefix."simtrain_races";
	$this->tablereligion=$tableprefix."simtrain_religion";
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
    $sql= "SELECT e.employee_id, e.employee_no, e.employee_name, e.ic_no, e.gender, e.dateofbirth, 
		e.epf_no, e.socso_no, e.account_no, e.hp_no, e.tel_1, e.address_id, e.employeetype,e.religion_id,
		 e.highestqualification, e.highestteachlvl, e.subjectsteach, e.uid,e.cashonhand, e.organization_id, 
		e.isactive, e.created, e.createdby, e.updated, e.updatedby,e.races_id,o.organization_code,
		e.position,e.department,e.basicsalary,e.commissionrate,e.salarytype, e.joindate,e.hourlyamt,e.epftype
		FROM $this->tableemployee e 
		inner join $this->tableorganization o on o.organization_id=e.organization_id 
		$wherestring $orderbystring";
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
	$mandatorysign="<b style='color:red'>*</b>";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	switch($this->salarytype){
	case "B":
	$select_st_b="SELECTED='SELECTED'";
	$select_st_h="";
	$select_st_a="";
	$select_st_c="";
	break;
	case "H":
	$select_st_b="";
	$select_st_h="SELECTED='SELECTED'";
	$select_st_a="";
	$select_st_c="";
	break;
	case "C":
	$select_st_b="";
	$select_st_h="";
	$select_st_a="";
	$select_st_c="SELECTED='SELECTED'";
	break;
	case "A":
	$select_st_b="";
	$select_st_h="";
	$select_st_a="SELECTED='SELECTED'";
	$select_st_c="";
	break;
	default:
	$select_st_b="SELECTED='SELECTED'";
	$select_st_h="";
	$select_st_a="";
	$select_st_c="";
	break;

	}

	if($this->epftype==1){
		$epftype_8="selected='selected'";
		$epftype_11="";
	}
	elseif($epftype==2){
		$epftype_11="selected='selected'";
		$epftype_8="";
	}
	else{
		$epftype_11="selected='selected'";
		$epftype_8="";
	}

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
		$this->epf_no="";
		$this->socso_no="";
		$this->account_no="";
		$this->hp_no="";
		$this->tel_1="";
		$this->races_id=0;
		$this->organization_id="";
		$this->cashonhand="";
		$this->uid=0;
		$this->hourlyamt=0;
		$this->commissionrate=0;
		$this->basicsalary=0;
		$this->joindate= date("Y-m-d", time()) ;
		$this->employeetype="";
		}
		$this->address_id="0";
		$address="Null(Save organization before edit address.)";
		$addressctl="";
		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
	}
	else
	{
		if($this->employee_id>0){
		$action="update";
		$address=$this->ad->showAddress($this->address_id);
		//$addressctl="<input type='submit' value='Address' name='submit'><input type='hidden' value='$this->employee_id' 
		//	name='employee_id'><input type='hidden' value='$this->address_id' name='address_id'>".
		//	"<input name='student_id' value='0'  type='hidden'><input type='hidden' value='edit' name='action'>";

//		$addressctl="<input type='button' value='Change' name='btnAddress' onClick='showAddressWindow($this->address_id)'>";
		$addressctl="<A href='address.php?address_id=$this->address_id&action=edit'  onclick='javascript:document.frmEmployee.submit.click()' target='_blank'>Change</A>";

		if($this->allowDeleteEmployee($this->employee_id) && $this->employee_id>0){
			$deletectrl="<FORM action='employee.php' method='POST' onSubmit='return confirm(".
			'"confirm to remove this employee?"'.")'><input type='submit' value='Delete' name='submit'>".
			"<input type='hidden' value='$this->employee_id' name='employee_id'>".
			"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		}
		$addnewctrl="<Form action='employee.php' method='POST'><input name='submit' value='New' type='submit'></form>";
		$header="Edit Employee";
		} 
		else{
		$action="create";
		$header="New Employee";
		}
		
//		$addressctl="<input type='button' value='Update Address' name='btnAddress' onClick='showAddressWindow($this->address_id);'>";
		
		$savectrl="<input name='employee_id' value='$this->employee_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$salaryctrl="<form action='emppayslipitem.php' method='Post'>
				<input name='employee_id' value='$this->employee_id' type='hidden'>
				<input name='action' value='default' type='hidden'>
				<input style='height: 40px;' name='submit' value='Edit Payroll Info' type='submit'>
				</form>";
		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";
		$select_m="";
		$select_f="";
		
		if ($this->gender=="M")
			$select_m="SELECTED='SELECTED'";
		else
			$select_f="SELECTED='SELECTED'";
		$select_g="";
		$select_t="";
		
		if ($this->employeetype=="G")
			$select_g="SELECTED='SELECTED'";
		elseif($this->employeetype=="F")
			$select_t="SELECTED='SELECTED'";
		else
			$select_p="SELECTED='SELECTED'";


			
		$photoctrl="<input type='checkbox' name='removepic'>Remove <br>".
				"<input type='file' name='employeephoto' title='Upload employee photo(jpg), max file size=100k, size 250x300.'>";

		$photoname="upload/employees/$this->employee_id.jpg";

		if(file_exists($photoname) )
			$photofile="<img src='$photoname' width='250' height='300'>";
		else
			$photofile="<img src='upload/employees/0.jpg' width='250' height='300'>";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableemployee' type='hidden'>".
		"<input name='id' value='$this->employee_id' type='hidden'>".
		"<input name='idname' value='employee_id' type='hidden'>".
		"<input name='title' value='Employee' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		
	}
     
echo <<< EOF

<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Employees Record</span></big></big></big></div><br>-->
<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form method="post" action="employee.php" name="frmEmployee" onSubmit='return validateEmployee()'  enctype="multipart/form-data">
<input name="reset" value="Reset" type="reset"></td></tbody></table>
<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
<tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th> 
      </tr>
	<tr>
		<td class="head">Organization / Join Date(YYYY-MM-DD)</td>
		<td class="odd">$this->orgctrl
			 <input size="10" maxlength="10" name='joindate' id='joindate' value="$this->joindate">
			<input type='button' value='Date' onclick="$this->showjoindatectrl"></td>
		<td class="even" colspan='2' rowspan='11' style='text-align:center'>
			250x300 Photo(Below 100K)<br> 
			$photofile<br>
			$photoctrl<br>

		</td>

	<tr>
		<td class="head">Index No (Number Only) $mandatorysign</td>
		<td class="even"><input name="employee_no" value="$this->employee_no"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>

	</tr>
	<tr>
		<td class="head">Name $mandatorysign</td>
		<td class="odd"><input size="40" name="employee_name" value="$this->employee_name"></td>
		
	</tr>
<tr>
		<td class="head">IC No. $mandatorysign</td>
		<td class="even">
			<input size="12" name="ic_no" value="$this->ic_no">&nbsp;<small><small><span style="color: rgb(51, 51, 255);">exp: 840115015598</span> </small></small>
		</td>

</tr>
	<tr>
		<td class="head">Gender / Races / Religion</td>
		<td class="odd">
			<select name="gender">
				<option value="F" $select_f>Female</option>
				<option value="M" $select_m>Male</option>
			</select>
			$this->racesctrl
			$this->religionctrl	
		</td>

	</tr>
	<tr>		<td class="head">Date of Birth(YYYY-MM-DD) $mandatorysign</td>
		<td class="even"><input name="dateofbirth" id='dateofbirth' value="$this->dateofbirth">&nbsp;<button style="width: 50px;" name="date" type="button" onclick="$this->showcalendar">Date</button></td>

</tr>
	<tr>
		<td class="head">EPF No.</td>
		<td class="odd"><input name="epf_no" value="$this->epf_no"></td>

	</tr>
<tr>
		<td class="head">SOCSO No.</td>
		<td class="even"><input name="socso_no" value="$this->socso_no"></td>
</tr>
	<tr>
		<td class="head">Bank Acc. No.</td>
		<td class="odd"><input name="account_no" value="$this->account_no"></td>
	</tr>
<tr>
		<td class="head">HP No/ Tel</td>
		<td class="even"><input name="hp_no" value="$this->hp_no" maxlength='13' size='13'> / 
		<input name="tel_1" value="$this->tel_1" maxlength='13' size='13'></td>

</tr>
<tr>
		<td class="head">Staff Group</td>
		<td class="odd">
		 <select name="employeetype" onChange="checkEmployee()">
			<option value="G" $select_g>General Staff</option>
			<option value="F" $select_t>Full Time Tutor</option>
			<option value="P" $select_p>Part Time Tutor</option>
		 </select>
</tr>
<tr>
	<td class='head'>Department</td>
	<td class='even'><input name='department' value="$this->department"></td>
	<td class='head'>Position</td>
	<td class='even'><input name='position' value="$this->position"></td>
</tr>
<tr>
	<td class='head'>Basic Salary ($this->cur_symbol) $mandatorysign</td>
	<td class='odd'><input name='basicsalary' value="$this->basicsalary"></td>
	<td class='head'>Salary Type</td>
	<td class='odd'>
		<SELECT name='salarytype'>
			<option value="B" $select_st_b>Basic</option>
			<option value="H" $select_st_h>Basic + Hourly Commission</option>
			<option value="C" $select_st_c>Basic + Sales Commission + Replacement Hourly Commission</option>
			<option value="A" $select_st_a>Basic + Receipt Commission + Replacement Hourly Commission</option>

		</SELECT>
	</td>
</tr>
<tr>
	<td class='head'>Commission Rate(%) $mandatorysign</td>
	<td class='even'><input name='commissionrate' value="$this->commissionrate"></td>
	<td class='head'>Hourly Rate ($this->cur_symbol) $mandatorysign</td>
	<td class='even'><input name='hourlyamt' value="$this->hourlyamt"></td>
</tr>
<tr>
	<td class='head'>EPF Type</td>
	<td class='odd'><SELECT name='epftype'>
			<option value="1" $epftype_8>8%</option>
			<option value="2" $epftype_11>11%</option>
		</SELECT>
	</td>
	<td class='head'></td>
	<td class='odd'></td>
</tr>

	<tr>
		<td class="head">Address</td>
		<td colspan="3" class="even">$address $addressctl</td>

	</tr>
	<tr>
		<td class="head">Highest Qualification</td>
		<td class="odd"><textarea rows="5" cols="40" name="highestqualification">$this->highestqualification</textarea></td>
		<td class="head">Highest Teaching Level</td>
		<td class="odd"><textarea rows="5" cols="40" name="highestteachlvl" >$this->highestteachlvl</textarea></td>
	</tr>
	<tr>
		<td class="head">Subjects Teached</td>
		<td colspan="3" class="even"><textarea rows="5" cols="80" name="subjectsteach" >$this->subjectsteach</textarea></td>
	</tr>
	<tr>
		<td class="head">Description</td>
		<td colspan="3" class="odd"><textarea rows="5" cols="80" name="description" >$this->description</textarea></td>
	</tr>
</tbody>
</table>
<table style="width:240px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$salaryctrl</td><td>$deletectrl</td></tbody></table><br>
$recordctrl
EOF;
  } // end of member function getInputForm

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
	if (!$rs){
		$this->log->showLog(1,"Error: employee ($employee_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Employee ($employee_id) removed from database successfully!");
		return true;
		
	}
	

  } // end of member function deleteEmployee

 /** Verify database to check whether this employee can be delete or not
   * 
   * @param int employee_id
   * @return bool
   * @access public
   */
  public function allowDeleteEmployee( $employee_id ) {
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
  } // end of member function allowDeleteEmployee


  /**
   *
   * @return bool
   * @access public
   */
  public function updateEmployee( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$sql="UPDATE $this->tableemployee 
		SET employee_no='$this->employee_no', employee_name='$this->employee_name', 
		ic_no='$this->ic_no', gender='$this->gender', dateofbirth='$this->dateofbirth', 
		epf_no='$this->epf_no', socso_no='$this->socso_no', account_no='$this->account_no', 
		hp_no='$this->hp_no', tel_1='$this->tel_1', employeetype='$this->employeetype', 
		highestqualification='$this->highestqualification', highestteachlvl='$this->highestteachlvl', 
		subjectsteach='$this->subjectsteach', cashonhand='$this->cashonhand', 
		organization_id='$this->organization_id',isactive='$this->isactive',updated='$timestamp',
		updatedby='$this->updatedby', uid='$this->uid',races_id=$this->races_id,
		basicsalary=$this->basicsalary,salarytype='$this->salarytype',
		commissionrate=$this->commissionrate,hourlyamt=$this->hourlyamt,
		position='$this->position',department='$this->department',
		religion_id=$this->religion_id,description='$this->description',
		joindate='$this->joindate',epftype=$this->epftype
		WHERE employee_id='$this->employee_id'";
	
	$this->log->showLog(3, "Update employee_id: $this->employee_id, $this->employee_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update employee failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update employee successfully.");
		return true;
	}

  } // end of member function updateEmployee

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
 	$sql="INSERT INTO $this->tableemployee (employee_no, employee_name, ic_no, gender, dateofbirth, epf_no, 
		socso_no, account_no, hp_no, tel_1, address_id, employeetype, highestqualification, highestteachlvl, 
		subjectsteach, cashonhand, organization_id, isactive, created, createdby, updated, updatedby,races_id,
		religion_id,basicsalary,salarytype,commissionrate,hourlyamt,department,position,joindate,epftype) values
		('$this->employee_no', '$this->employee_name', '$this->ic_no', '$this->gender', 
		'$this->dateofbirth', '$this->epf_no', '$this->socso_no', '$this->account_no', '$this->hp_no', 
		'$this->tel_1', '$this->address_id', '$this->employeetype', '$this->highestqualification', 
		'$this->highestteachlvl', '$this->subjectsteach', '$this->cashonhand', '$this->organization_id', 
		'$this->isactive', '$timestamp', '$this->createdby', '$timestamp', '$this->updatedby',$this->races_id, 
		$this->religion_id,$this->basicsalary,'$this->salarytype',$this->commissionrate,$this->hourlyamt,
		'$this->department','$this->position','$this->joindate',$this->epftype)";
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

  /**
   * Fetch Employee info from database into class
   *
   * @param int employee_id 
   * @return bool
   * @access public
   */
  public function fetchEmployee( $employee_id ) {
	$this->log->showLog(3,"Fetching employee detail into class Employee.php.<br>");
		
	$sql="SELECT employee_no, employee_name, ic_no, gender, dateofbirth, epf_no, socso_no, account_no, hp_no, 
		tel_1,races_id, address_id, employeetype, highestqualification, highestteachlvl, subjectsteach, 
		cashonhand, organization_id, isactive,religion_id,description, 
		basicsalary,salarytype,commissionrate,hourlyamt,department,position,joindate,epftype
		 from $this->tableemployee where employee_id=$employee_id";
	
	$this->log->showLog(4,"Employee->fetchEmployee, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->employee_no=$row["employee_no"];
		$this->employee_name=$row["employee_name"];
		$this->ic_no=$row["ic_no"];
		$this->gender=$row["gender"];
		$this->dateofbirth=$row["dateofbirth"];
		$this->epf_no=$row["epf_no"];
		$this->epftype=$row['epftype'];
		$this->socso_no=$row["socso_no"];
		$this->account_no=$row["account_no"];
		$this->hp_no=$row["hp_no"];
		$this->department=$row["department"];
		$this->joindate=$row["joindate"];
		$this->position=$row["position"];
		$this->tel_1=$row["tel_1"];
		$this->description=$row["description"];
		$this->address_id=$row["address_id"];
		$this->employeetype=$row["employeetype"];
		$this->hourlyamt=$row["hourlyamt"];
		$this->basicsalary=$row["basicsalary"];
		$this->commissionrate=$row["commissionrate"];
		$this->salarytype=$row["salarytype"];
		$this->epftype=$row['epftype'];
		$this->highestqualification=$row["highestqualification"];
		$this->highestteachlvl=$row["highestteachlvl"];
		$this->subjectsteach=$row["subjectsteach"];
		$this->cashonhand=$row["cashonhand"];
		$this->races_id=$row["races_id"];

		$this->religion_id=$row["religion_id"];
		$this->organization_id=$row["organization_id"];
		$this->isactive=$row['isactive'];
	$this->log->showLog(4,"Employee->fetchEmployee, database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Employee->fetchEmployee,failed to fetch data into databases.");	
	}
  } // end of member function fetchEmployee

 public function showEmployeeTable(){
	global $defaultorganization_id;

	$this->log->showLog(3,"Showing Employee Table");
	$sql=$this->getSQLStr_AllEmployee("WHERE employee_id>0 and e.organization_id = $defaultorganization_id ","ORDER BY o.organization_code, e.employee_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Employee No.</th>
				<th style="text-align:center;">Employee Name</th>
				<th style="text-align:center;">Job Title</th>
				<th style="text-align:center;">Department</th>
				<th style="text-align:center;">Position</th>

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
		$organization_code=$row['organization_code'];
		$employeetype=$row['employeetype'];
		$department=$row['department'];
		$position=$row['position'];
		$hp_no=$row['hp_no'];

		if($employeetype=="G")
			$employeetype="Genaral";
		elseif($employeetype=="F")
			$employeetype="Full Time Tutor";
		else
			$employeetype="Part Time Tutor";

		$employee_id=$row['employee_id'];
		$isactive=$row['isactive'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$organization_code</td>
			<td class="$rowtype" style="text-align:center;">$employee_no</td>
			<td class="$rowtype" style="text-align:center;"><a href="employee.php?action=edit&employee_id=$employee_id">$employee_name </a></td>
			<td class="$rowtype" style="text-align:center;">$employeetype</td>
			<td class="$rowtype" style="text-align:center;">$department</td>
			<td class="$rowtype" style="text-align:center;">$position</td>
			<td class="$rowtype" style="text-align:center;">$hp_no</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="employee.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit"  title='Edit this record'>
				<input type="hidden" value="$employee_id" name="employee_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}//end of while
echo  "</tr></tbody></table>";
 } //end of showEmployeeTable

public function showEmployeeHeader($closetable='Y'){
switch($this->salarytype){
case "B":
$salarytypetext="Basic";
break;
case "H":
$salarytypetext="Basic + Hourly Commission";
break;
case "C":
$salarytypetext="Basic + Sales Commission + Replacement Hourly Commission";
break;
case "A":
$salarytypetext="Basic + Receipt Commission + Replacement Commission";
break;

}
$epfname="";
if ($this->epftype==1)
$epfname="8%";
else
$epfname="11%";
echo <<< EOF
<table border='1'>
  <tbody>
    <tr>
      <th style='text-align: center;' colspan='4'>Employee Info</th>
    </tr>
    <tr>
      <td class='head'>Employee ID</td>
      <td class='odd'>$this->employee_no</td>
      <td class='head'>Employee Name</td>
      <td class='odd'><A href="employee.php?action=edit&employee_id=$this->employee_id">$this->employee_name</a></td>
    </tr>
    <tr>
      <td class='head'>IC Number</td>
      <td class='even'>$this->ic_no</td>
      <td class='head'>HP No/ Tel</td>
      <td class='even'>$this->hp_no / $this->tel_1</td>
    </tr>
  <tr>
      <td class='head'>EPF No($epfname)</td>
      <td class='even'>$this->epf_no</td>
      <td class='head'>Socso No</td>
      <td class='even'>$this->socso_no</td>
    </tr>
  <tr>
      <td class='head'>Hourly Amount ($this->cur_symbol)</td>
      <td class='even'>$this->hourlyamt</td>
      <td class='head'>Commission Rate (%)</td>
      <td class='even'>$this->commissionrate</td>
    </tr>
  <tr>
      <td class='head'>Salary Type</td>
      <td class='even'>$salarytypetext</td>
      <td class='head'>Bank Acc</td>
      <td class='even'>$this->account_no</td>
    </tr>
EOF;
if($closetable=='Y')
echo "</tbody></table>";

}
public function getEmployeeList($id,$type='M',$controlname='employee_id',$showNull="N"){
//	global $defaultorganization_id;
//	$org_where = " and e.organization_id = $defaultorganization_id ";

	$this->log->showLog(3,"Retrieve available employee from database, with id: $id");
	$filterstr="";
	$minimumno=1;

	$sql="SELECT e.employee_id,concat(e.employee_name,'/',e.employee_no,'/',o.organization_code) as employee_name
		from $this->tableemployee e
		inner join $this->tableorganization o on o.organization_id=e.organization_id
		where (e.isactive='Y' or e.employee_id=$id) and e.employee_id>0  $org_where order by
		 concat(e.employee_name,'/',e.employee_no,'/',o.organization_code) ";
	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='$controlname' >";
	if ($showNull=='Y' || $id==-1)
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
  public function savephoto($phototmpfile){
	
	move_uploaded_file($phototmpfile, "upload/employees/$this->employee_id".".jpg");
	$this->log->showLog(4,"Saving employee's photo $phototmpfile to upload/employees/$this->employee_id".".jpg");
  }
 
  public function deletephoto($employee_id){
	$filename="upload/employees/$employee_id".".jpg";
	unlink("$filename");
	$this->log->showLog(4,"Removing upload/employees/$employee_id".".jpg");
  }

} // end of Employee
?>

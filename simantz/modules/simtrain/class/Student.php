<?php



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

/**
 * class Student
 */
class Student
{
   /*** Attributes: ***/

  public $student_id;
  public $student_code;
  public $student_name;
  public $alternate_name;
  public $isactive;
  public $dateofbirth;
  public $showcalendar="";
  public $gender = 'M';
  public $ic_no;
  public $school_id;
  public $hp_no;
  public $tel_1;
  public $tel_2;
  public $email;
  public $web;
  public $parents_id;
  public $joindate;
  public $showjoindatectrl;
  public $cur_name;
  public $cur_symbol;
  public $isAdmin;
  public $organization_id;
  public $races_id;
  public $removepic;
  public $updated;
  public $updatedby;
  public $description;
  public $standard_id;
  public $created;
  public $createdby;
  public $orgctrl;
  public $religion_id;
  public $religionctrl;
  public $racesctrl;
  public $schoolctrl;
  public $standardctrl;
  public $studentctrl;
  public $parentsctrl;
  public $xoopsDB;
  public $tableprefix;
  public $tablestudent;
  public $tableaddress;
  private $tablestudentclass;
  private $tableraces;
  private $tablestandard;
  private $tableparents;
  private $tableschool;
  private $tablereligion;
  private $log;

  /**
   * @access public, constructor
   */
  public function Student($xoopsDB, $tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablestudent=$tableprefix . "simtrain_student";
	$this->tableaddress=$tableprefix . "simtrain_address";
	$this->tablearea=$tableprefix . "simtrain_area";
	$this->tableparents=$tableprefix . "simtrain_parents";
	$this->tablestudentclass=$tableprefix."simtrain_studentclass";
	$this->tablestandard=$tableprefix."simtrain_standard";
	$this->tableorganization=$tableprefix."simtrain_organization";
	$this->tableraces=$tableprefix."simtrain_races";
	$this->tablereligion=$tableprefix."simtrain_religion";
	$this->tableschool=$tableprefix."simtrain_school";

	$this->log=$log;
   }

  /**
   * Return an SQL Statement to list all student information.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param string startlimitno 
   * @return string
   * @access public
   */
  public function getSqlStrStudentList( $wherestring,  $orderbystring,  $startlimitno ) {
    $sql= "SELECT s.student_id, s.student_code,s.alternate_name, s.student_name, s.isactive, s.dateofbirth,std.standard_name, s.gender, s.ic_no, 
	 sch.school_name, s.hp_no, s.tel_1, s.tel_2, s.parents_id,p.parents_name, p.parents_contact, s.organization_id, s.joindate, 
	 p.parents_email,ad.no,ad.street1,ad.street2,ad.postcode,ad.city,ad.state,ad.country,area.area_name,
	 r.races_name,s.description,s.email,s.web,s.levela,s.levelb,s.levelc,s.religion_id, re.religion_name,o.organization_code
	 FROM $this->tablestudent s 
	 inner join $this->tableraces r on r.races_id=s.races_id 
	 inner join $this->tableaddress ad on ad.student_id=s.student_id
	 inner join $this->tablestandard std on std.standard_id=s.standard_id 
	 inner join $this->tableschool sch on sch.school_id=s.school_id 
	 inner join $this->tablearea area on area.area_id=ad.area_id 
	 inner join $this->tableorganization o on o.organization_id=s.organization_id 
	 inner join $this->tableparents p on p.parents_id=s.parents_id 
	 inner join $this->tablereligion re on s.religion_id=re.religion_id
	 $wherestring $orderbystring";
	$this->log->showLog(4,"Calling getSqlStrStudentList:" .$sql);
   return $sql;
  } // end of member function getSqlStrStudentList

  /**
   *
   * @param string type 
   * @param int student_id 
   * @return bool
   * @access public
   */
  public function getInputForm( $type,  $student_id, $token) {
  	$mandatorysign="<b style='color:red'>*</b>";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$jumptotoregclass="";
	$photofile="<img src='upload/students/0.jpg' width='250' height='300'>";
	if ($type=="new"){
		$header="New Student";
		$action="create";
		if($student_id==0){
		$this->student_id="";
		$this->student_code=$this->getNextIndex();
		$this->student_name="";
		$this->dateofbirth="";
		$this->gender ="";
		$this->ic_no="";
		$this->joindate= date("Y-m-d", time()) ;

		$this->hp_no="";
		$this->tel_1="";
		$this->tel_2="";
//		$this->parents_id="";
//		$this->parent_tel="";
		$this->organization_id="";
		}
		$savectrl="<input style='height:40px;' name='btnSave' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
	}
	else
	{
		/*
		* creating address for student not yet complete.
		*/
		if($this->student_id>0){
			$action="update";
			$addressctl="<input type='submit' value='Address' name='btnAddress'  style='height: 40px;'>".
				"<input type='hidden' value='$this->student_id' name='student_id'>".
				"<input type='hidden' value='create' name='action'>";
			
			if($this->allowDelStudent($this->student_id))
			  $deletectrl="<FORM action='student.php' method='POST' onSubmit='return confirm(" . 
					'"Confirm to delete this record?"'.")'>".
					"<input type='submit' value='Delete' name='btnDelete'  style='height: 40px;'>".
					"<input type='hidden' value='$this->student_id' name='student_id'>".
					"<input type='hidden' value='delete' name='action'>".
					"<input name='token' value='$token' type='hidden'></form>";
		
		$addnewctrl="<Form action='student.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";
		$namecardctrl="<Form action='viewnamecard.php' method='POST' target='_blank'>".
				"<input type='submit' value='Name Card' name='btnNamecard'  style='height: 40px;'>".
				"<input type='hidden' value='$student_id' name='student_id'></form>";
		$header="Edit Student";
		}
		else{
		$action="create";
		$header="New Student";
		}
//		$address=$this->ad->showAddress($this->address_id); //$ad->showAddress($this->address_id);
		
		$savectrl="<input name='student_id' value='$this->student_id' type='hidden'>".
			 "<input name='btnSave' value='Save' type='submit'  style='height: 40px;'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";
		$select_m="";
		$select_f="";
		
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST' name='frmRecordInfo'>".
			"<input name='tablename' value='$this->tablestudent' type='hidden'>".
			"<input name='id' value='$this->student_id' type='hidden'>".
			"<input name='idname' value='student_id' type='hidden'>".
			"<input name='title' value='Student' type='hidden'>".
			"<input name='btnRecord' value='View Record Info' type='submit'  style='height: 40px;'>".
			"</form>";

		if ($this->gender=="M")
			$select_m="SELECTED='SELECTED'";
		else
			$select_f="SELECTED='SELECTED'";

		$header="Edit Student";

		$photoctrl="<input type='checkbox' name='removepic'>Remove <br>".
				"<input type='file' name='studentphoto' title='Upload student photo(jpg), max file size=100k, size 250x300.'>";

		$photoname="upload/students/$this->student_id.jpg";

		if(file_exists($photoname) )
			$photofile="<img src='$photoname' width='250' height='300'>";
		else
			$photofile="<img src='upload/students/0.jpg' width='250' height='300'>";
		
		$jumptotoregclass="<Form action='regclass.php' method='POST'>".
				"<input name='btnClass' value='Go To Class Registration' style='height: 40px;' type='submit'>".
				"<input name='action' value='choosed' type='hidden'>".
				"<input name='student_id' value='$this->student_id' type='hidden'>".
				"</form>";

	}
	echo <<< EOF

<table style="width: 140px;"><tbody><td>
<form action="student.php" method="post" id="frmStudent" name='frmStudent' onSubmit='return validateStudent()' 
	 enctype="multipart/form-data">
	<input name="reset" value="Reset" type="reset"></td>
	<td nowrap> <div id="sameNameId"></div></td></tbody></table>
<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
<tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
	<tr>
		<td class="head">Index No  (Number) $mandatorysign</th>
		<td class="odd"><input name="student_code" value="$this->student_code" maxlength="8">&nbsp;&nbsp;Active <input type="checkbox" $checked name="isactive"></td>
		<td class="even" colspan='2' rowspan='10' style='text-align:center'>
			250x300 Photo(Below 100K)<br> 
			$photofile<br>
			$photoctrl<br>

		</td>
	</tr>
	<tr>
	<td class="head">Registered Place $mandatorysign / Join Date (YYYY-MM-DD)</td>
		<td class="even">$this->orgctrl $this->orgaization_id 	
		 <input size="10" maxlength="10" name='joindate' id='joindate' value="$this->joindate">
			<input type='button' value='Date' onclick="$this->showjoindatectrl"></td>
	</tr>
	<tr>
		<td class="head">Name $mandatorysign/Alternate Name</td>
		<td class="odd"><input size="40" name="student_name" value="$this->student_name">
				<input size="10" name="alternate_name" value="$this->alternate_name"></td>
	</tr>
	<tr>
		<td class="head">IC No. $mandatorysign</td>
		<td class="even"><input size="12" name="ic_no" value="$this->ic_no";>&nbsp;<small><small><span style="color: rgb(51, 51, 255);">exp: 840115015598</span></small></small></td>
	</tr>
	<tr>
		<td class="head">Gender / Races / Religion</td>
		<td class="odd"><select name="gender"><option value="F" $select_f>Female</option><option value="M" $select_m>Male</option></select> $this->racesctrl 
					$this->religionctrl</td>	
	</tr>
	<tr>
		<td class="head">Date of Birth(YYYY-MM-DD)$mandatorysign</td>
		<td class="even"><input name="dateofbirth" id='dateofbirth' value="$this->dateofbirth">&nbsp;<button style="width: 50px;" name="date" type="button"
			 onClick="$this->showcalendar">Date</button></td>

	</tr>
	<tr>
		<td class="head">School</td>
		<td class="odd">$this->schoolctrl</td>

		</tr>
	<tr>
		<td class="head">Standard/ Level A/B/C</td>
		<td class="even">$this->standardctrl 
			<input name='levela' value='$this->levela' size='4' maxlength='4' title='Define other student level here'>
			<input name='levelb' value='$this->levelb' size='4' maxlength='4' title='Define other student level here'>
			<input name='levelc' value='$this->levelc' size='4' maxlength='4' title='Define other student level here'></td>		
	</tr>
	<tr>
		<td class="head">H/P Contact</td>
		<td class="odd"><input maxlength="30" name="hp_no" value="$this->hp_no" size="30"></td>
	</tr>
	<tr>
	
		<td class="head">House Contact</td>
		<td class="even"><input maxlength="30" name="tel_1" value="$this->tel_1" size="30"></td>
	<tr>
		<td class="head">Parent Name</td>
		<td class="odd">$this->parentsctrl <a href="#" onclick='zoomParents();'>Zoom</a></td>
		<td class="head">Others Contact</td>
		<td class="odd"><input maxlength="16" name="tel_2" value="$this->tel_2"></td>
	</tr>
	<tr>
		<td class="head">Email</td>
		<td class="even"><input name="email" value="$this->email"></td>
		<td class="head">Web</td>
		<td class="even"><input name="web" value="$this->web"></td>
	</tr>
	<tr>
		<td class="head">Description</td>
		<td class="odd" colspan='3'><textarea name="description" cols='90' rows='10'>$this->description</textarea></td>
	</tr>
	</tbody>
</table>
<table style="width: 330px;"><tbody><tr><td>
$savectrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden">
	</form></td><td>$namecardctrl</td><td><form action="address.php" method="post" name="frmViewAddress">
		$addressctl</form></td>
		<td>$deletectrl</td><td>$jumptotoregclass</td>
		<td>$recordctrl</td></tr></tbody></table><br>
EOF;
//<form action="student.php" method="post" name="frmShowAllStudent"><input type='submit' value='Show All Students' //name='submit'><input type='hidden' value='showall' name='action'></form>

  } // end of member function getInputForm

  /**
   *
   * @return bool
   * @access public
   */
  public function updateStudent( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$sql="UPDATE $this->tablestudent SET ".
	"student_code='$this->student_code',alternate_name='$this->alternate_name',student_name='$this->student_name',isactive='$this->isactive',".
	"dateofbirth='$this->dateofbirth', gender='$this->gender', ic_no='$this->ic_no', school_id=$this->school_id, hp_no='$this->hp_no',tel_1='$this->tel_1',tel_2='$this->tel_2', parents_id='$this->parents_id',  organization_id=$this->organization_id ".
	",updated='$timestamp',updatedby=$this->updatedby,standard_id=$this->standard_id,races_id=$this->races_id, religion_id=$this->religion_id, 
	web='$this->web', email='$this->email', description='$this->description',levela='$this->levela',levelb='$this->levelb',levelc='$this->levelc',
	joindate='$this->joindate' WHERE student_id='$this->student_id'";
	
	$this->log->showLog(3, "Update student_id: $this->student_id, $this->student_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update student failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update student successfully.");
		return true;
	}

  } // end of member function updateStudent

  /**
   *
   * @return bool
   * @access public
   */
  public function insertStudent( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new student $student_name");
	$sql="INSERT INTO $this->tablestudent (student_code,student_name,isactive,
	dateofbirth, gender, ic_no, school_id, hp_no, tel_1, tel_2, parents_id,  organization_id,created,createdby,updated,updatedby,standard_id,races_id,email,
	description,web,alternate_name,levela,levelb,levelc, religion_id,joindate) values('$this->student_code','$this->student_name','$this->isactive',
	'$this->dateofbirth', '$this->gender', '$this->ic_no', $this->school_id, '$this->hp_no', '$this->tel_1','$this->tel_2', '$this->parents_id',
	'$this->organization_id','$timestamp',$this->createdby,'$timestamp',$this->updatedby,$this->standard_id,$this->races_id,
	'$this->email','$this->description','$this->web','$this->alternate_name','$this->levela','$this->levelb','$this->levelc', '$this->religion_id','$this->joindate')";
	$this->log->showLog(4,"Before insert student SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert student $student_name");
		return false;
	}
	else{
	$newid=$this->getLatestStudentID();
	$this->log->showLog(3,"Inserting new student $student_name successfully, try auto create default address."); 
	$sqlinsert="INSERT INTO $this->tableaddress (student_id,address_name,no,street1,street2,postcode, 		city,state,country,isactive,organization_id,created,createdby,updated,updatedby,area_id) 		values($newid,'Home','-', '-', '-', '-', '-','-', '-', '$this->isactive', 				'$this->organization_id','$timestamp',$this->createdby,'$timestamp',$this->updatedby,1)";
		$this->log->showLog(4,"With SQL: $sqlinsert");
	$rsinsert=$this->xoopsDB->query($sqlinsert);
	return true;
}
  } // end of member function insertStudent

  /** Verified db whether this student allow to delete
   *
   * @param int student_id 
   * @return bool
   * @access public
   */
  public function allowDelStudent( $student_id ) {
    	$this->log->showLog(2,"Verify whether student_id : $student_id can be remove from database");
	$sql="SELECT count(studentclass_id) as qty from $this->tablestudentclass where student_id=$student_id";
	

	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$qty=$row['qty'];
		if($qty>0){
		$this->log->showLog(3,"Found $qty record under table studentclass, this student undeletable!");
		return false;
		}
		else{
		$this->log->showLog(3,"This student is deletable after verification!");
		return true;
		}
	}
  } // end of member function allowDelStudent

  /**
   *
   * @param int student_id 
   * @return bool
   * @access public
   */
  public function delStudent( $student_id ) {
    	$this->log->showLog(2,"Warning: Performing delete student id : $student_id !");
	$sql="DELETE FROM $this->tablestudent where student_id=$student_id";

	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);

	$sqlad="DELETE FROM $this->tableaddress where student_id=$student_id";

	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rsad=$this->xoopsDB->query($sqlad);
	if (!$rsad){
		$this->log->showLog(1,"Error: Student's address ($student_id) unable remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Student's address ($student_id) removed from database successfully!");
		return true;	
	}

  } // end of member function delStudent

  /**
   *
   * @param int student_id 
   * @return bool
   * @access public
   */
  public function fetchStudentInfo( $student_id ) {
	$this->log->showLog(3,"Fetching student detail into class Student.php.<br>");
		
	$sql="SELECT student_code, alternate_name,student_name, isactive, dateofbirth, gender, ic_no, school_id, hp_no, tel_1, tel_2, parents_id,  organization_id,standard_id,races_id,email,web,description,levela,levelb,levelc,religion_id,joindate FROM $this->tablestudent where student_id=$student_id";
	
	$this->log->showLog(4,"Student->fetchStudentInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->student_name=$row["student_name"];
		$this->student_code=$row["student_code"];
		$this->dateofbirth=$row["dateofbirth"];
		$this->joindate=$row["joindate"];

		$this->gender =$row["gender"];
		$this->ic_no=$row["ic_no"];
		$this->alternate_name=$row['alternate_name'];
		$this->school_id=$row["school_id"];
		$this->hp_no=$row["hp_no"];
		$this->standard_id=$row["standard_id"];
		$this->tel_1=$row["tel_1"];
		$this->races_id=$row["races_id"];
		$this->email=$row["email"];
		$this->religion_id=$row["religion_id"];
		$this->web=$row["web"];
		$this->levela=$row["levela"];
		$this->levelb=$row["levelb"];
		$this->levelc=$row["levelc"];
		$this->description=$row["description"];

		$this->tel_2=$row["tel_2"];
		$this->parents_id=$row["parents_id"];
		$this->organization_id=$row["organization_id"];
		$this->isactive=$row['isactive'];
	$this->log->showLog(4,"Student->fetchStudent,database fetch into class successfully, organization_id=$this->organization_id");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Student->fetchStudent,failed to fetch data into databases.");	
	}
} // end of member function fetchStudentInfo

  public function showStudentTable( $wherestring="",$orderbystring="",$startlimitno=0,$tabletype='student' ) {
	$this->log->showLog(3,"Showing Student Table");
	$sql=$this->getSqlStrStudentList($wherestring,$orderbystring,0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table style="text-align:left width: 100%" border="1" cellpadding="0" cellspacing="3">
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Index No</th>
				<th style="text-align:center;">Student Name</th>
				<th style="text-align:center;">IC No</th>
				<th style="text-align:center;">Parents Name</th>
				<th style="text-align:center;">Races</th>
				<th style="text-align:center;">Religion</th>
				<th style="text-align:center;">School</th>
				<th style="text-align:center;">Standard</th>
				<th style="text-align:center;">L.A</th>
				<th style="text-align:center;">L.B</th>
				<th style="text-align:center;">L.C</th>
				<th style="text-align:center;">Tel</th>
				<th style="text-align:center;">H/P No.</th>
				<th style="text-align:center;">Gender</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$student_code=$row['student_code'];
		$student_name=$row['student_name'];
		$alternate_name=$row['alternate_name'];
		$school_name=$row['school_name'];
		$organization_code=$row['organization_code'];
		$hp_no=$row['hp_no'];
		$standard_name=$row['standard_name'];
		$levela=$row['levela'];
		$levelb=$row['levelb'];
		$levelc=$row['levelc'];
		$religion_name=$row['religion_name'];
		$student_id=$row['student_id'];
		$isactive=$row['isactive'];
		$ic_no=$row['ic_no'];
		$parents_id=$row['parents_id'];
		$parents_name=$row['parents_name'];
		$races_name=$row['races_name'];
		$tel_1=$row['tel_1'];
		$email=$row["email"];
		$web=$row["web"];
		$description=$row["description"];
		$gender=$row['gender'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

	$actionperform="";
	switch($tabletype){
	case "student":
		$actionperform="<form action='student.php' method='POST'>".
			"<input type='image' src='images/edit.gif' name='btnEdit'  title='Edit this record'>".
				"<input type='hidden' value='$student_id' name='student_id'>".
				"<input type='hidden' name='action' value='edit'></form>";
	break;
	case "regclass":
		$actionperform="<form name='frmchoosestudent' action='regclass.php' method='POST'>
				<input type='submit' value='choose' name='btnChoose'>
				<input type='hidden' value='$student_id' name='student_id'>
				<input type='hidden' name='action' value='choosed'></form>";
	break;
	case "regproduct":
		$actionperform="<form name='frmchoosestudent' action='regproduct.php' method='POST'>
				<input type='submit' value='choose' name='btnChoose'>
				<input type='hidden' value='$student_id' name='student_id'>
				<input type='hidden' name='action' value='choosed'></form>";
	break;

	case "payment":
		$actionperform="<form name='frmchoosestudent' action='payment.php' method='POST'>
				<input type='submit' value='choose' name='btnChoose'>
				<input type='hidden' value='$student_id' name='student_id'>
				<input type='hidden' name='action' value='choosed'></form>";
	break;
	default:
		$actionperform="";
	break;
	}
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$organization_code</td>
			<td class="$rowtype" style="text-align:center;">$student_code</td>
			<td class="$rowtype" style="text-align:center;"><a href='student.php?action=edit&student_id=$student_id' target="_blank"
					 >$student_name/$alternate_name</a></td>
			<td class="$rowtype" style="text-align:center;">$ic_no</td>
			<td class="$rowtype" style="text-align:center;">
				<A href='parents.php?action=edit&parents_id=$parents_id'>$parents_name</A>
			</td>


			<td class="$rowtype" style="text-align:center;">$races_name</td>
			<td class="$rowtype" style="text-align:center;">$religion_name</td>
			<td class="$rowtype" style="text-align:center;">$school_name</td>
			<td class="$rowtype" style="text-align:center;">$standard_name</td>
			<td class="$rowtype" style="text-align:center;">$levela</td>
			<td class="$rowtype" style="text-align:center;">$levelb</td>
			<td class="$rowtype" style="text-align:center;">$levelc</td>
			<td class="$rowtype" style="text-align:center;">$tel_1</td>
			<td class="$rowtype" style="text-align:center;">$hp_no</td>
			<td class="$rowtype" style="text-align:center;">$gender</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$actionperform</td>

		</tr>
EOF;
	}//end of while

echo  "</tr></tbody></table>";
if($i==1)
echo <<< EOF
<script type="text/javascript">
document.frmchoosestudent.btnChoose.click();
</script>
EOF;
 } //end of showStudentTable









  public function showAllStudentTable() {
	$this->log->showLog(3,"Showing All Student Table");
	$sql=$this->getSqlStrStudentList("","ORDER BY student_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Student List</span></big></big></big></div><br>

	<table style="text-align:left width: 100%" border="1" cellpadding="0" cellspacing="3" id="tblStudent">
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Index No</th>
				<th style="text-align:center;">Student Name</th>
				<th style="text-align:center;">IC No</th>
				<th style="text-align:center;">Parents Name</th>
				<th style="text-align:center;">Races</th>
				<th style="text-align:center;">School</th>
				<th style="text-align:center;">Standard</th>
				<th style="text-align:center;">Tel</th>
				<th style="text-align:center;">H/P No.</th>
				<th style="text-align:center;">Gender</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$student_code=$row['student_code'];
		$student_name=$row['student_name'];
		$school_name=$row['school_name'];
		$standard_name=$row['standard_name'];
		$hp_no=$row['hp_no'];
		$student_id=$row['student_id'];
		$gender=$row['gender'];
		$isactive=$row['isactive'];
		$ic_no=$row['ic_no'];
		$parents_id=$row['parents_id'];
		$parents_name=$row['parents_name'];
		$email=$row["email"];
		$web=$row["web"];
		$description=$row["description"];
		$races_name=$row['races_name'];
		$tel_1=$row['tel_1'];
		if($isactive=='N')
			$isactive="<b style='color:red'>$isactive</b>";
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$student_code</td>
			<td class="$rowtype" style="text-align:left;"><a href='student.php?action=edit&student_id=$student_id' 
						target="_blank">$student_name</a></td>
			<td class="$rowtype" style="text-align:center;">$ic_no</td>
			<td class="$rowtype" style="text-align:center;">
				<A href='parents.php?action=edit&parents_id=$parents_id'>$parents_name</A>
			</td>
			<td class="$rowtype" style="text-align:center;">$races_name</td>
			<td class="$rowtype" style="text-align:center;">$school_name</td>
			<td class="$rowtype" style="text-align:center;">$standard_name</td>
			<td class="$rowtype" style="text-align:center;">$tel_1</td>
			<td class="$rowtype" style="text-align:center;">$hp_no</td>
			<td class="$rowtype" style="text-align:center;">$gender</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;"><form action='student.php' method='POST'>
			<input type='image' src='images/edit.gif' name='submit' title='Edit this record'>
			<input type='hidden' value='$student_id' name='student_id'><input type='hidden' name='action' value='edit'></form></td>

		</tr>
EOF;
	}//end of while
echo  "</tr></tbody></table>";
 } //end of showAllStudentTable

  /**
   *
   * @param int student_id 
   * @return 
   * @access public
   */

  public function getStudentSelectBox($id,$showEmpty='N'){
	global $defaultorganization_id;
  	$sql="SELECT student_id,student_name,student_code from $this->tablestudent where (isactive='Y' or student_id=$id) and student_id>0 and organization_id = $defaultorganization_id order by student_name ;";
	$selectctl="<SELECT name='student_id' >";
	if(($id==0 || $id==-1) && $showEmpty='Y')
		$selected='SELECTED="SELECTED"';

	if ($id==-1 || $showEmpty=='Y')
		$selectctl=$selectctl . '<OPTION value="0" $selected>Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$student_id=$row['student_id'];
		$student_name=$row['student_name'];
	$student_code=$row['student_code'];
		if($id==$student_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$student_id' $selected>$student_name ($student_code)</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  }

  /** retrieve new created student id
   *
   * @param 
   * @return int last student id 
   * @access public
   */
  public function getLatestStudentID() {
	$sql="SELECT MAX(student_id) as student_id from $this->tablestudent;";
	//echo $sql;
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['student_id'];
	else
	return -1;
  } // end of member function getLatestOrganizationID

 /**Return a long hyperlink string which contrain a 1st letter of all student name
   *@param 
   *@return string a hyper link name list
   *@access public
   */ 
  public function searchAToZ(){
	global $defaultorganization_id;
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search student easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(student_name,1)) as shortname FROM $this->tablestudent where isactive='Y' and student_id>0 and organization_id = $defaultorganization_id order by student_name";
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
echo "<b>Student Grouping By Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if customer never do filter yet, if will choose 1st customer listing
		
		echo "<A href='student.php?filterstring=$shortname'> $shortname </A> ";
	}
		echo <<<EOF
<BR>
<A href='student.php' style='color: GRAY'> [ADD NEW STUDENT]</A>
<A href='student.php?action=search' style='color: gray'> [SEARCH STUDENT]</A>

EOF;
return $filterstring;

	$this->log->showLog(3,"Complete generate list of short cut");
  }

  public function getNextIndex(){
/*
$sql="SELECT CAST(invoice_no AS SIGNED) as invoice_no, invoice_no as ori_data from $this->tableinvoice WHERE CAST(invoice_no AS SIGNED) > 0  order by CAST(invoice_no AS SIGNED) DESC limit 1 ";

	$this->log->showLog(3,'Checking latest created invoice_no');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created invoice_no:' . $row['invoice_no']);
		$invoice_no=$row['invoice_no']+1;

		if(strlen($row['invoice_no']) != strlen($row['ori_data']))
		return str_replace($row['invoice_no'], '', $row['ori_data'])."".$invoice_no;
		else
		return $invoice_no;

*/
	$this->log->showLog(3,"Search next available student_code");
	$sqlstudent="SELECT CAST(student_code as SIGNED) as student_code, student_code as student_code_ori FROM $this->tablestudent WHERE CAST(student_code AS SIGNED) > 0  order by CAST(student_code AS SIGNED) DESC limit 1";
	$this->log->showLog(4,"With SQL: $sqlstudent");

	$query=$this->xoopsDB->query($sqlstudent);

	//$nextcode=0;
	//$oricode=0;
	if ($row=$this->xoopsDB->fetchArray($query)) {
		$nextcode=$row['student_code']+1;
		$oricode=$row['student_code_ori'];

		if(strlen($row['student_code']) != strlen($row['student_code_ori']))
			return str_replace($row['student_code'], '', $oricode)."".$nextcode;
		else
			return $nextcode;


	}

  }

 public function showSearchForm(){
	if($_POST['isactive']=='Y'){
		$selectnull="";
		$selecty='selected="selected"';
		$selectn="";
	}
	elseif($_POST['isactive']=='N'){
		$selectnull="";
		$selecty="";
		$selectn='selected="selected"';
	}	
	else{
		$selectnull='selected="selected"';
		$selecty="";
		$selectn="";

	}
   echo <<< EOF
	
	<FORM action="student.php" method="POST">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Search Student</th>
	    </tr>
	    <tr>
	      <td class='head'>Student Code</td>
	      <td class='even'><input name='student_code' value="$this->student_code"> (%, AB%,%AB,%A%B%)</td>
	      <td class='head'>Student Name</td>
	      <td class='even'><input name='student_name' value='$this->student_name'>%ali, %ali%, ali%, %ali%bin%</td>
	    </tr>
	    <tr>
	      <td class='head'>Quick Search</td>
	      <td class='odd'>$this->studentctrl</td>
	      <td class='head'	>IC Number</td>
	      <td class='odd'><input name='ic_no' value="$this->ic_no"></td>
	    </tr>
	    <tr>
	      <td class='head'>School</td>
	      <td class='odd'>$this->schoolctrl</td>
	      <td class='head'>Standard/ Level A/B/C</td>
	      <td class='odd'>$this->standardctrl
			<input name='levela' value='$this->levela' size='4' maxlength='4' title='Define other student level here'>
			<input name='levelb' value='$this->levelb' size='4' maxlength='4' title='Define other student level here'>
			<input name='levelc' value='$this->levelc' size='4' maxlength='4' title='Define other student level here'></td>
	    </tr>
	    <tr>
	      <td class='head'>Races / Religion</td>
	      <td class='odd'>$this->racesctrl / $this->religionctrl</td>
	      <td class='head'	>Gender</td>
	      <td class='odd'>
		<select name="gender">
			<option value="-" >Null</option>
			<option value="F" >Female</option>
			<option value="M" >Male</option>
		</select>
	      </td>
	    </tr>
    	<tr>
	      <td class='head'>Date Of Birth (2008%, %-01-%)</td>
	      <td class='odd'><input name="dateofbirth" value="$this->dateofbirth"></td>
	      <td class='head'>Is Active</td>
	      <td class='odd'>
		<select name="isactive">
			<option value="-" $selectnull>Null</option>
			<option value="Y" $selecty>Y</option>
			<option value="N" $selectn>N</option>
		</select>
		</td>
		</tr>
	<tr>
	      <td class='head'>Parents Name</td>
	      <td class='odd'>$this->parentsctrl</td>
	      <td class='head'>Alternate Name</td>
	      <td class='odd'><input name='alternate_name' value="$this->alternate_name">%黄%</td>
	    </tr>
	<tr>
	      <td class='head'>Join Date (2008%, %-01-%)</td>
	      <td class='odd'><input name='joindate' value="$this->joindate"></td>
	      <td class='head'>Organization</td>
	      <td class='odd'>$this->orgctrl</td>
	    </tr>
	  </tbody>
	</table>
	<table style="width:150px;">
	  <tbody>
	    <tr>
	      <td>
			<input style="height:40px;" type='submit' value='Search' name='btnSearch'>
			
		<input type='hidden' name='action' value='searchstudent'></td>
	      <td><input type='reset' value='Reset' name='reset'></td>
	    </tr>
	  </tbody>
	</table>
	</FORM>
EOF;
  }//showSearchForm

  public function savephoto($phototmpfile){
	
	move_uploaded_file($phototmpfile, "upload/students/$this->student_id".".jpg");
	$this->log->showLog(4,"Saving worker photo $phototmpfile to upload/students/$this->student_id".".jpg");
  }
 
  public function deletephoto($student_id){
	$filename="upload/students/$student_id".".jpg";
	unlink("$filename");
	$this->log->showLog(4,"Removing upload/students/$student_id".".jpg");
  }

  public function checkName($student_name){

	$student_name = strtoupper($student_name);
	$sql = "select student_id,student_name,student_code from $this->tablestudent where UPPER(student_name) = '$student_name' ";
	
	$query=$this->xoopsDB->query($sql);

	$student_id=0;
	if ($row=$this->xoopsDB->fetchArray($query)) {
		$student_id=$row['student_id'];
		$student_name=$row['student_name'];
		$student_code=$row['student_code'];
	}

	return array($student_id,$student_name,$student_code);
  }

} // end of Student
?>

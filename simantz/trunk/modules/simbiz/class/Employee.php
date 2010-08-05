<?php


class Employee
{

  public $employee_id;
  public $employee_name;
  public $employee_no;

  public $employee_altname;
  public $ic_placeissue;
  public $ic_color;

  public $permanent_telno;
  public $contact_address;
  public $employee_jobdescription;
  public $contact_postcode;
  public $contact_city;
  public $contact_state;
  public $contact_telno;
  public $place_dob;
  public $department_id;
  public $supervisor_1;
  public $supervisor_2;


  public $employeegroup_id;
  public $employee_joindate;
  public $employee_confirmdate;
  public $employee_socsono;
  public $employee_epfno;
  public $employee_taxno;
  public $employee_pencenno;
  public $islecturer;
  public $isovertime;
  public $isfulltime;
  public $issalesrepresentative;

  public $employee_salary;
  public $employee_ottrip;
  public $employee_othour;
  public $annual_leave;

  public $employee_newicno;
  public $jobposition_id;
  public $employee_salarymethod;
  public $employee_oldicno;
  public $permanent_address;
  public $gender;
  public $permanent_postcode;
  public $permanent_state;
  public $permanent_city;
  public $permanent_country;
  public $contact_country;
  public $religion_id;
  public $races_id;
  public $uid;
  public $marital_status;
  public $filephoto;
  public $employee_dob;
  public $employee_cardno;
  public $organization_id;
  public $isactive;
  public $description;
  public $defaultlevel;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tableemployee;
  private $tablebpartner;


  private $log;


//constructor
   public function Employee(){
	global $xoopsDB,$log,$tableemployee,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport;
    global $tablesemester,$tablecourse,$tablesession,$tableyear,$tableraces,$tablereligion,$tableloantype,$tablecountry;
    global $tableemployeegroup,$tabledepartment,$tableusers,$tableallowanceline,$tabledisciplineline;
    global $tableactivityline,$tableattachmentline,$tableportfolioline,$tableappraisalline,$tablejobposition;
    
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tableemployee=$tableemployee;
    $this->tableemployeetype=$tableemployeetype;
    $this->tablesemester=$tablesemester;
    $this->tablecourse=$tablecourse;
	$this->tablebpartner=$tablebpartner;
    $this->tablesession=$tablesession;
    $this->tableyear=$tableyear;
    $this->tableraces=$tableraces;
    $this->tablereligion=$tablereligion;
    $this->tablecountry=$tablecountry;
    $this->tableemployeegroup=$tableemployeegroup;
    $this->tabledepartment=$tabledepartment;
	$this->tableusers=$tableusers;
	$this->tableallowanceline=$tableallowanceline;
	$this->tabledisciplineline=$tabledisciplineline;
	$this->tableactivityline=$tableactivityline;
	$this->tableattachmentline=$tableattachmentline;
    $this->tableportfolioline=$tableportfolioline;
    $this->tableappraisalline=$tableappraisalline;
    $this->tablejobposition=$tablejobposition;


	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int employee_id
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $employee_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
    $searchctrl="";
	$deletectrl="";
	$itemselect="";
    $styleviewdetails="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Employee";
		$action="create";
	 	$styleviewdetails="display:none";

		if($employee_id==0){
            //$checkedF = "CHECKED";
			$this->employee_name="";
            $this->gender="M";
            $this->marital_status="S";
			$this->isactive="";
            $this->islecturer="";
            $this->isovertime="";
            $this->isfulltime="";
            $this->issalesrepresentative="";
            $this->employee_salarymethod="B";

			$this->defaultlevel=10;
            $this->annual_leave=0;
            $this->employee_salary=0;
            $this->employee_ottrip=0;
            $this->employee_othour=0;
			$employeechecked="CHECKED";
			$this->employee_no = getNewCode($this->xoopsDB,"employee_no",$this->tableemployee,"");
            $this->employee_rate = 1;

		}
		$savectrl="<input astyle='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

	
	}
	else if($type == "edit")
	{
		
		$action="update";
		$savectrl="<input name='employee_id' value='$this->employee_id' type='hidden'>".
			 "<input astyle='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableemployee' type='hidden'>".
		"<input name='id' value='$this->employee_id' type='hidden'>".
		"<input name='idname' value='employee_id' type='hidden'>".
		"<input name='title' value='Employee' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
	

		$header="Edit Basic Employee Profile";
		
		if($this->allowDelete($this->employee_id))
		$deletectrl="<FORM action='employee.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this employee?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->employee_id' name='employee_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='employee.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}else{

        $action="view";
        $header="View Basic Employee Profile";

        if($this->isAdmin)
        $recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
        "<input name='tablename' value='$this->tableemployee' type='hidden'>".
        "<input name='id' value='$this->employee_id' type='hidden'>".
        "<input name='idname' value='employee_id' type='hidden'>".
        "<input name='title' value='Employee' type='hidden'>".
        "<input name='submit' value='View Record Info' type='submit'>".
        "</form>";
       $addnewctrl="<Form action='employee.php' method='POST'><input name='submit' value='New' type='submit'></form>";
    }

    // start set display input
    $formdisabled = "";
    $formdisplay = "";
    $formreadonly = "";
    $formchecked = "";
    $formsubmit = "onsubmit='return validateEmployee()' ";
    $editctrl = "";
    if($action=="create"){
    }else if($action=="update"){
        $editctrl="<Form action='employee.php' method='POST'>
        <input name='submit' value='Back To View Mode' type='submit'>
        <input name='employee_id' type='hidden' value='$this->employee_id'>
        <input name='action' value='view' type='hidden'>
        </form>";
    }else{
        $formdisabled = "disabled";
        $formdisplay = "style = 'display:none' ";
        $formreadonly = "readonly";
        $formsubmit = "onsubmit = 'return false' ";
        $formchecked=' onclick="javascript:if(this.checked==true){this.checked=false;}else{this.checked=true}" ';
        $editctrl="<Form action='employee.php' method='POST'>
        <input name='submit' value='Edit Basic Profile' type='submit'>
        <input name='employee_id' type='hidden' value='$this->employee_id'>
        <input name='action' value='edit' type='hidden'>
        </form>";
    
    }

    $this->admindisplay = "style='display:none'";
    if($this->isAdmin){
    $this->admindisplay = "";
    }
    //end of set display input


        $searchctrl="<Form action='employee.php' method='POST'>
                            <input name='submit' value='Search' type='submit'>
                            <input name='action' value='search' type='hidden'>
                            </form>";

        $selectICB="";
        $selectICR="";
        if($this->ic_color=="B")
        $selectICB = "SELECTED";
        else
        $selectICR = "SELECTED";
        
        $selectGenderM="";
        $selectGenderF="";
        if($this->gender=="M")
        $selectGenderM = "SELECTED";
        else
        $selectGenderF = "SELECTED";

        $selectMaritalS="";
        $selectMaritalM="";
        if($this->marital_status=="S")
        $selectMaritalS = "SELECTED";
        else
        $selectMaritalM = "SELECTED";

   
//force isactive checkbox been checked if the value in db is 'Y'
        if ($this->isactive==1)
        $checked="CHECKED";
        else
        $checked="";

        if ($this->islecturer==1)
        $checkedL="CHECKED";
        else
        $checkedL="";

        if ($this->isovertime==1){
        $checkedO="CHECKED";
        $stylerateot = "";
        }else{
        $checkedO="";
        $stylerateot = "display:none";
        }

        if ($this->isfulltime==1)
        $checkedF="CHECKED";
        else
        $checkedF="";

        if ($this->issalesrepresentative==1)
        $checkedS="CHECKED";
        else
        $checkedS="";


        if($this->employee_salarymethod == "Q")
        $selectCheque = "selected";
        else if($this->employee_salarymethod == "C")
        $selectCash = "selected";
        else
        if($this->employee_salarymethod == "B")
        $selectBank = "selected";

        
        $photourl="";
        $icurl="";
        $spmurl="";
        if($this->filephoto != "")
        $photourl = "upload/employee/photo/$this->filephoto";

        $photoalert="";
        if(!file_exists($photourl) || $photourl == ""){
        $photourl="";
        $photoalert = "<font color='red'><b><u>Photo Not Available.</u></b></font>";
        }

        $select_epf1="";
        $select_epf2="";
        $select_epf3="";
        if ($this->employee_epfrate==1)
        $select_epf1="SELECTED='SELECTED'";
        elseif($this->employee_epfrate==2)
        $select_epf2="SELECTED='SELECTED'";
        else $select_epf3="SELECTED='SELECTED'";

	 $stylefinance = "style='display:none'";
    echo <<< EOF


<table style="width:140px;">
<tbody>
<td $stylefinance>$addnewctrl</td>
<td>$searchctrl</td>
<td><form $formsubmit method="post"
 action="employee.php" name="frmEmployee" enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr $stylefinance>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" acolspan="3">$this->orgctrl&nbsp;Active <input $formchecked type="checkbox" $checked name="isactive"></td>
			<td class="head" astyle="display:none">Default Level $mandatorysign</td>
	        <td class="even"  astyle="display:none"><input $formreadonly maxlength="3" size="3" name='defaultlevel' value='$this->defaultlevel'>
   	
      </tr>

      <tr>
	  	<td class="head" astyle="display:none">Employee No $mandatorysign
        <br><br>Name $mandatorysign
        <br><br>Other Name

        </td>
        <td class="even" astyle="display:none">
        <input $formreadonly maxlength="10" size="10" name="employee_no" value="$this->employee_no" readonly><br><br>
        <input $formreadonly maxlength="100" size="50" name="employee_name" value="$this->employee_name" readonly><br><br>
        <input $formreadonly maxlength="100" size="50" name="employee_altname" value="$this->employee_altname" readonly><br><br>
        <div $formdisplay  $stylefinance>$this->uidctrl</div>
        </td>
        <td class="head" colspan="2" arowspan="2" >

        <table>
        <tr height="100">
        <td style="background-color:gainsboro" align="center">
        <a href="$photourl" target="blank"><img src="$photourl" width="200" height="200"></a>$photoalert</td>
        </tr>
        <tr $stylefinance>
        <td><input $formdisplay type="file" name="filephoto">&nbsp;&nbsp;Remove Photo <input $formdisplay type="checkbox" name="deleteAttachmentPhoto" title="Choose it if you want to remove this Photo">
        <br>(200 x 200 : JPG Format only)
        </td>
        </tr>
        </table>
        
        </td>
      </tr>

      <tr $stylefinance>
        <td class="head">Job Position</td>
        <td class="even" colspan="3">
        $this->jobpositionctrl
        <br>
        <a onclick="showJobDescription()" style="cursor:pointer">Show Job Description >></a>
        <div>
        <textarea $formreadonly style="display:none" name="employee_jobdescription" cols="80" rows="15">$this->employee_jobdescription</textarea>
        </div>
        </td>
      </tr>

      <tr $stylefinance>
        <td class="head">Group</td>
        <td class="even">$this->employeegroupctrl</td>
        <td class="head">Department</td>
        <td class="even">$this->departmentctrl</td>
      </tr>

        <tr>
        <td class="head">Employee OT Rate</td>
        <td class="even" colspan="3">
        <table style="width:1%;$stylerateot" id="idOTRate">
        <tr>
        <td nowrap><b>Rate Hours (OT)</b></td>
        <td nowrap>: <input $formreadonly maxlength="12" size="10" name="employee_ottrip" value="$this->employee_ottrip"></td>
        <td nowrap><b>Rate Trip (OT)</b></td>
        <td nowrap>: <input $formreadonly maxlength="12" size="10" name="employee_othour" value="$this->employee_othour"></td>
        </tr>
        </table>
        </td>
        </tr>

      <tr $stylefinance>
	  	<td class="head">New IC No<br><br>Date Of Birth<br><br>Place Of Birth</td>
        <td class="even">
        <input $formreadonly maxlength="20" size="15" name="employee_newicno" value="$this->employee_newicno"> <font color=red>(Ex: 800130-01-5577)</font><br><br>
        <input $formreadonly name='employee_dob' id='employee_dob' value="$this->employee_dob" maxlength='10' size='10'>
    	<input $formdisplay name='btnDate' value="Date" type="button" onclick="$this->dobdatectrl"> <font color=red>YYYY-MM-DD (Ex: 1980-01-30)</font><br><br>
        <input $formreadonly maxlength="100" size="50" name="place_dob" value="$this->place_dob">
        </td>
        <td class="head">Old IC No</td>
        <td class="even" ><input $formreadonly maxlength="20" size="15" name="employee_oldicno" value="$this->employee_oldicno"></td>
      </tr>

      <tr $stylefinance>
        <td class="head">IC Color</td>
        <td class="even" >
        <select name="ic_color" $formdisabled>
        <option value="B" $selectICB>Blue</option>
        <option value="R" $selectICR>Red</option>
        </select>
        </td>
	  	<td class="head">IC Issue Place</td>
        <td class="even"><input $formreadonly maxlength="50" size="30" name="ic_placeissue" value="$this->ic_placeissue"></td>
      </tr>

     <tr $stylefinance>
        <td class="head">Races / Religion / Gender</td>
        <td class="even">
            $this->racesctrl
            $this->religionctrl
            <select name="gender" $formdisabled>
            <option value="M" $selectGenderM>Male</option>
            <option value="F" $selectGenderF>Female</option>
            </select>
        </td>
	  	<td class="head">Marital Status</td>
        <td class="even">
            <select name="marital_status" $formdisabled>
            <option value="S" $selectMaritalS>Single</option>
            <option value="M" $selectMaritalM>Married</option>
            </select>
        </td>
      </tr>

      <tr  $stylefinance>
	  	<td class="head">Permanent Address</td>
        <td class="even" colspan="3" valign="top">
        <textarea $formreadonly name="permanent_address" cols="40" rows="4">$this->permanent_address</textarea><br><br>
        Postcode <input $formreadonly maxlength="10" size="8" name="permanent_postcode" value="$this->permanent_postcode">
        City <input $formreadonly maxlength="30" size="20" name="permanent_city" value="$this->permanent_city">
        State <input $formreadonly maxlength="20" size="20" name="permanent_state" value="$this->permanent_state">
        Country $this->permanentcountryctrl <br><br>
        Tel No &nbsp;&nbsp;&nbsp;&nbsp;<input $formreadonly maxlength="15" size="12" name="permanent_telno" value="$this->permanent_telno">
        </td>
      </tr>

      <tr  $stylefinance>
	  	<td class="head">Contact Address</td>
        <td class="even" colspan="3" valign="top">
        <textarea $formreadonly name="contact_address" cols="40" rows="4">$this->contact_address</textarea><br><br>
        Postcode <input $formreadonly maxlength="10" size="8" name="contact_postcode" value="$this->contact_postcode">
        City <input $formreadonly maxlength="30" size="20" name="contact_city" value="$this->contact_city">
        State <input $formreadonly maxlength="20" size="20" name="contact_state" value="$this->contact_state">
        Country $this->contactcountryctrl<br><br>
        Tel No &nbsp;&nbsp;&nbsp;&nbsp;<input $formreadonly maxlength="15" size="12" name="contact_telno" value="$this->contact_telno">
        </td>
      </tr>

        <tr $stylefinance>
        <td class="head">Supervisor 1</td>
        <td class="even" colspan="3">$this->supervisor1ctrl</td>
        <td class="head" style="display:none">Supervisor 2</td>
        <td class="even" style="display:none">$this->supervisor2ctrl</td>
        </tr>

      <tr $stylefinance>
        <td class="head">HP No $mandatorysign</td>
        <td class="even"><input $formreadonly maxlength="15" size="12" name="employee_hpno" value="$this->employee_hpno"></td>
        <td class="head">Annual Leave</td>
        <td class="even" ><input $formreadonly maxlength="11" size="3" name="annual_leave" value="$this->annual_leave"></td>
      </tr>


      <tr $stylefinance>
        <td class="head">EPF No</td>
        <td class="even"><input $formreadonly maxlength="20" size="10" name="employee_epfno" value="$this->employee_epfno"></td>
        <td class="head">Socso No</td>
        <td class="even"><input $formreadonly maxlength="20" size="10" name="employee_socsono" value="$this->employee_socsono"></td>
      </tr>

      <tr $stylefinance>
        <td class="head">Tax No</td>
        <td class="even"><input $formreadonly maxlength="20" size="10" name="employee_taxno" value="$this->employee_taxno"></td>
        <td class="head">No Pencen</td>
        <td class="even"><input $formreadonly maxlength="20" size="10" name="employee_pencenno" value="$this->employee_pencenno"></td>
      </tr>

      <tr $stylefinance>
        <td class="head">Join Date</td>
        <td class="even">
        <input $formreadonly name='employee_joindate' id='employee_joindate' value="$this->employee_joindate" maxlength='10' size='10'>
    	<input $formdisplay name='btnDate' value="Date" type="button" onclick="$this->joindatectrl">
        </td>
        <td class="head">Conformation Date</td>
        <td class="even">
        <input $formreadonly name='employee_confirmdate' id='employee_confirmdate' value="$this->employee_confirmdate" maxlength='10' size='10'>
    	<input $formdisplay name='btnDate' value="Date" type="button" onclick="$this->confirmdatectrl">
        </td>
      </tr>


      <tr $stylefinance>
        <td class="head">Remarks</td>
        <td class="even" ><textarea $formreadonly name="description" cols="40" rows="3">$this->description</textarea></td>
        <td class="head">Access Card No</td>
        <td class="even" ><input $formreadonly name="employee_cardno" value="$this->employee_cardno" ></td>
      </tr>
 

        <tr>
        <th colspan="4">Payroll Information</th>
        </tr>

      <tr>
	  	<td class="head">Basic Salary (RM)</td>
        <td class="even">
        <input $formreadonly maxlength="12" size="10" name="employee_salary" value="$this->employee_salary">
        &nbsp;&nbsp;EPF (%)
		<select name="employee_epfrate">
                <option value=3 $select_epf3>0%</option>
		<option value=2 $select_epf2>11%</option>
		<option value=1 $select_epf1>8%</option>
		</select>
        </td>
        <td class="head">Payment Method</td>
        <td class="even">
            <select name="employee_salarymethod" $formdisabled>
            <option value="B" $selectBank>Bank</option>
            <option value="C" $selectCash>Cash</option>
            <option value="Q" $selectCheque>Cheque</option>
            </select>
        </td>
      </tr>

      <tr>
        <td class="head">Bank Account No</td>
        <td class="even"><input $formreadonly maxlength="20" size="20" name="employee_accno" value="$this->employee_accno"></td>
        <td class="head">Bank Name</td>
        <td class="even"><input $formreadonly maxlength="50" size="20" name="employee_bankname" value="$this->employee_bankname"></td>
      </tr>

       <tr $formdisplay>
        <th class="head" colspan="4"><input type="checkbox" name="createnewrecord"> Redirect To New Record?</th>
        </tr>

    </tbody>
  </table>
<br>

<table style="width:150px;"><tbody><td $formdisplay>$savectrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td $this->admindisplay>$editctrl</td><td $formdisplay $this->admindisplay>$deletectrl</td></tbody></table>

  <br>

$recordctrl
EOF;

if($action=="view"){
//$this->getTablePortfolioLine($token);
//$this->getTableActivityLine($token);
$this->getTableAllowanceLine($token);
//$this->getTableAppraisalLine($token);
//$this->getTableAttachmentLine($token);
//$this->getTableDisciplineLine($token);
}

  } // end of member function getInputForm


public function getTableAppraisalLine($token){
	$rowtype="";
    $timestamp= date("Y-m-d", time()) ;

	$sql = "SELECT * FROM $this->tableappraisalline
    WHERE employee_id = $this->employee_id ORDER BY appraisalline_date ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

         if($this->isAdmin){
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableappraisalline' type='hidden'>".
		"<input name='id' value='$this->appraisalline_id' type='hidden' id='idViewRecordAppraisal'>".
		"<input name='idname' value='appraisalline_id' type='hidden'>".
		"<input name='title' value='AppraisalLine' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit' id='idBtnViewRecordAppraisal' style='display:none'>".
		"</form>";
        $deletectrl = "<input type='button' value='Delete' onclick='deleteAppraisal()' id='idBtnDeleteAppraisal' style='display:none'>";
         }

echo <<< EOF
    <br>
    <form action="employee.php" method="POST" name="frmAppraisal" onsubmit="return validateAppraisal()">
    <input type="hidden" name="action" value="newappraisal">
    <input type="hidden" name="employee_id" value="$this->employee_id">
    <input type="hidden" name="appraisalline_id" value="0">
    <input type="hidden" name="token" value="$token">

	<table border=0>

    <tr>
    <th colspan="4">Appraisal</th>
    <th colspan="3" align="right"><input $this->admindisplay type="button" value="Show Form"  name="btnShowForm" onclick="showHideAppraisal()"></th>
    </tr>

    <tr>
    <td colspan="7">
    <table id="tableAppraisal" style="display:none"><!--New Appraisal Form-->
    <tr>
    <th align="left" colspan="4"><input type="button" value="New Appraisal" onclick="newAppraisal()"></th>
    </tr>

    <tr>
    <td class="head">Date</td>
    <td class="even">
    <input name='appraisalline_date' id='appraisalline_date' value="$timestamp" maxlength='10' size='10'>
    <input name='btnDate' value="Date" type="button" onclick="$this->appraisaldatectrl"> <font color=red>YYYY-MM-DD (Ex: 2009-12-30)</font>
    </td>
    <td class="head">Appraisal</td>
    <td class="even"><input name="appraisalline_name" value="$appraisalline_name" size="30" maxlength="100"></td>
    </tr>

    <tr>
    <td class="head">Increment (RM)</td>
    <td class="even"><input name="appraisalline_increment" value="0" size="10" maxlength="11"></td>
    <td class="head">Result</td>
    <td class="even">
    <select name="appraisalline_result">
    <option value="P">-</option>
    <option value="Y">Yes</option>
    <option value="N">No</option>
    </select>
    </td>
    </tr>

    <tr>
    <td class="head">Remarks</td>
    <td class="even" colspan="3"><textarea name="appraisalline_remarks" cols="40" rows="4">$appraisalline_remarks</textarea></td>
    </tr>

    <td aclass="head" align="left"><input type="submit" value="Save"></td>
    <td aclass="head" align="right" colspan="3">$deletectrl</td>
    </tr>
    </form>

    <tr>
    <td aclass="head" align="center" colspan="4">$recordctrl</td>
    </tr>

    </tr>
    </table>
    </td>
    </tr>

    <tr align="center">
    <th>No</th>
    <th>Date</th>
    <th>Appraisal</th>
    <th>Remarks</th>
    <th>Increment (RM)</th>
    <th>Result</th>
    <th></th>
    </tr>

EOF;

	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;

	$appraisalline_id = $row['appraisalline_id'];
	$appraisalline_date = $row['appraisalline_date'];
	$appraisalline_name = $row['appraisalline_name'];
	$appraisalline_remarks = $row['appraisalline_remarks'];
    $appraisalline_result = $row['appraisalline_result'];
    $appraisalline_increment = $row['appraisalline_increment'];

	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

	$appraisalline_remarks = str_replace( array("\r\n", "\n","\r"), "<br/>", $appraisalline_remarks );
	$appraisalline_remarks = str_replace( " ", "&nbsp;", $appraisalline_remarks );

    if($appraisalline_result == "P")
    $appraisalline_result = "Next Appraisal";

echo <<< EOF
	<input type="hidden" name="appraisalline_idarr[$i]" value="$appraisalline_id">
	<tr >
		<td class="$rowtype" align="center">$i</td>
		<td class="$rowtype" align="center">$appraisalline_date</td>
		<td class="$rowtype" align="center">$appraisalline_name</td>
		<td class="$rowtype"><a onclick="viewRemarks('appraisal$i')" style="cursor:pointer">View Remarks >></a><div id="appraisal$i" style="display:none">$appraisalline_remarks</div></td>
		<td class="$rowtype" align="center">$appraisalline_increment</td>
		<td class="$rowtype" align="center">$appraisalline_result</td>

		<td class="$rowtype" align="center"><image $this->admindisplay src='images/edit.gif' title='Edit' onclick="editAppraisal($appraisalline_id)" style="cursor:pointer"></td>

	</tr>
EOF;
	}
	if($i == 0){
	echo "<tr><td colspan='7'>No Record(s) Found.</td></tr>";
	}

echo <<< EOF
</table>
<br>
EOF;


  }

public function getTablePortfolioLine($token){
	$rowtype="";
    $timestamp= date("Y-m-d", time()) ;

	$sql = "SELECT * FROM $this->tableportfolioline
    WHERE employee_id = $this->employee_id ORDER BY portfolioline_datefrom ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

         if($this->isAdmin){
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableportfolioline' type='hidden'>".
		"<input name='id' value='$this->portfolioline_id' type='hidden' id='idViewRecordPortfolio'>".
		"<input name='idname' value='portfolioline_id' type='hidden'>".
		"<input name='title' value='PortfolioLine' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit' id='idBtnViewRecordPortfolio' style='display:none'>".
		"</form>";
        $deletectrl = "<input type='button' value='Delete' onclick='deletePortfolio()' id='idBtnDeletePortfolio' style='display:none'>";
         }

echo <<< EOF
    <br>
    <form action="employee.php" method="POST" name="frmPortfolio" onsubmit="return validatePortfolio()">
    <input type="hidden" name="action" value="newportfolio">
    <input type="hidden" name="employee_id" value="$this->employee_id">
    <input type="hidden" name="portfolioline_id" value="0">
    <input type="hidden" name="token" value="$token">

	<table border=0>

    <tr>
    <th colspan="3">Portfolio</th>
    <th colspan="3" align="right"><input $this->admindisplay type="button" value="Show Form"  name="btnShowForm" onclick="showHidePortfolio()"></th>
    </tr>

    <tr>
    <td colspan="6">
    <table id="tablePortfolio" style="display:none"><!--New Portfolio Form-->
    <tr>
    <th align="left" colspan="4"><input type="button" value="New Portfolio" onclick="newPortfolio()"></th>
    </tr>

    <tr>
    <td class="head">Date From</td>
    <td class="even">
    <input name='portfolioline_datefrom' id='portfolioline_datefrom' value="$timestamp" maxlength='10' size='10'>
    <input name='btnDate' value="Date" type="button" onclick="$this->portfoliodatefromctrl">
    </td>
        <td class="head">Date To</td>
    <td class="even">
    <input name='portfolioline_dateto' id='portfolioline_dateto' value="$timestamp" maxlength='10' size='10'>
    <input name='btnDate' value="Date" type="button" onclick="$this->portfoliodatetoctrl">
    </td>
    </tr>

    <tr>
    <td class="head">Portfolio</td>
    <td class="even" colspan="3"><input name="portfolioline_name" value="$portfolioline_name" size="30" maxlength="100"></td>
    <!--<td class="head">Type</td>
    <td class="even">
    <select name="portfolioline_type">
    <option value="A" $selectA>College Portfolio</option>
    <option value="C" $selectC>Course</option>
    <option value="O" $selectO>Others</option>
    </select>
    </td>-->
    </tr>

    <tr>
    <td class="head">Remarks</td>
    <td class="even" colspan="3"><textarea name="portfolioline_remarks" cols="40" rows="4">$portfolioline_remarks</textarea></td>
    </tr>

    <td aclass="head" align="left"><input type="submit" value="Save"></td>
    <td aclass="head" align="right" colspan="3">$deletectrl</td>
    </tr>
    </form>

    <tr>
    <td aclass="head" align="center" colspan="4">$recordctrl</td>
    </tr>

    </tr>
    </table>
    </td>
    </tr>

    <tr align="center">
    <th>No</th>
    <th>Date From</th>
    <th>Date To</th>
    <!--<th>Type</th>-->
    <th>Portfolio</th>
    <th>Remarks</th>
    <th></th>
    </tr>

EOF;

	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;

	$portfolioline_id = $row['portfolioline_id'];
	$portfolioline_datefrom = $row['portfolioline_datefrom'];
    $portfolioline_dateto = $row['portfolioline_dateto'];
    //$portfolioline_type = $row['portfolioline_type'];
	$portfolioline_name = $row['portfolioline_name'];
	$portfolioline_remarks = $row['portfolioline_remarks'];

	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

	$portfolioline_remarks = str_replace( array("\r\n", "\n","\r"), "<br/>", $portfolioline_remarks );
	$portfolioline_remarks = str_replace( " ", "&nbsp;", $portfolioline_remarks );

    if($portfolioline_type == "A")
    $portfolioline_type = "College Portfolio";
    else if($portfolioline_type == "C")
    $portfolioline_type = "Course";
    else if($portfolioline_type == "O")
    $portfolioline_type = "Others";

echo <<< EOF
	<input type="hidden" name="portfolioline_idarr[$i]" value="$portfolioline_id">
	<tr >
		<td class="$rowtype" align="center">$i</td>
		<td class="$rowtype" align="center">$portfolioline_datefrom</td>
		<td class="$rowtype" align="center">$portfolioline_dateto</td>
		<td class="$rowtype" align="center">$portfolioline_name</td>
		<!--<td class="$rowtype" align="center">$portfolioline_type</td>-->
		<td class="$rowtype"><a onclick="viewRemarks('portfolio$i')" style="cursor:pointer">View Remarks >></a><div id="portfolio$i" style="display:none">$portfolioline_remarks</div></td>
		<td class="$rowtype" align="center"><image $this->admindisplay src='images/edit.gif' title='Edit' onclick="editPortfolio($portfolioline_id)" style="cursor:pointer"></td>

	</tr>
EOF;
	}
	if($i == 0){
	echo "<tr><td colspan='6'>No Record(s) Found.</td></tr>";
	}

echo <<< EOF
</table>
<br>
EOF;


  }

public function getTableAttachmentLine($token){
	$rowtype="";
    $timestamp= date("Y-m-d", time()) ;

	$sql = "SELECT * FROM $this->tableattachmentline
    WHERE employee_id = $this->employee_id ORDER BY attachmentline_id ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

         if($this->isAdmin){
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableattachmentline' type='hidden'>".
		"<input name='id' value='$this->attachmentline_id' type='hidden' id='idViewRecordAttachment'>".
		"<input name='idname' value='attachmentline_id' type='hidden'>".
		"<input name='title' value='AttachmentLine' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit' id='idBtnViewRecordAttachment' style='display:none'>".
		"</form>";
        $deletectrl = "<input type='button' value='Delete' onclick='deleteAttachment()' id='idBtnDeleteAttachment' style='display:none'>";
         }

echo <<< EOF
    <br>
    <form action="employee.php" method="POST" name="frmAttachment"
    enctype="multipart/form-data"
    onsubmit="return validateAttachment()">
    <input type="hidden" name="action" value="newattachment">
    <input type="hidden" name="employee_id" value="$this->employee_id">
    <input type="hidden" name="attachmentline_id" value="0">
    <input type="hidden" name="token" value="$token">

	<table border=0>

    <tr>
    <th colspan="3">Attachment</th>
    <th colspan="2" align="right"><input $this->admindisplay type="button" value="Show Form"  name="btnShowForm" onclick="showHideAttachment()"></th>
    </tr>

    <tr>
    <td colspan="5">
    <table id="tableAttachment" style="display:none"><!--New Attachment Form-->
    <tr>
    <th align="left" colspan="4"><input type="button" value="New Attachment" onclick="newAttachment()"></th>
    </tr>

    <tr>
    <td class="head">Title</td>
    <td class="even"><input name="attachmentline_name" value="$attachmentline_name" size="30" maxlength="100"></td>
    <td class="head">Attachment</td>
    <td class="even">
    <input type="file" name="attachmentline_file" title="Remove This Attachment">
    <input type="checkbox" name="isremove">Remove
    <br>
    <div id="idAttachment"></div>
    </td>
    </tr>
    <tr>
    <td class="head">Remarks</td>
    <td class="even" colspan="3"><textarea name="attachmentline_remarks" cols="40" rows="4">$attachmentline_remarks</textarea></td>
    </tr>

    <td aclass="head" align="left"><input type="submit" value="Save"></td>
    <td aclass="head" align="right" colspan="3">$deletectrl</td>
    </tr>
    </form>

    <tr>
    <td aclass="head" align="center" colspan="4">$recordctrl</td>
    </tr>

    </tr>
    </table>
    </td>
    </tr>

    <tr align="center">
    <th>No</th>
    <th>File</th>
    <th>View</th>
    <th>Remarks</th>
    <th></th>
    </tr>

EOF;

	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;

	$attachmentline_id = $row['attachmentline_id'];
	$attachmentline_file = $row['attachmentline_file'];
	$attachmentline_name = $row['attachmentline_name'];
	$attachmentline_remarks = $row['attachmentline_remarks'];

	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

	$attachmentline_remarks = str_replace( array("\r\n", "\n","\r"), "<br/>", $attachmentline_remarks );
	$attachmentline_remarks = str_replace( " ", "&nbsp;", $attachmentline_remarks );

    $pathfile = "upload/employee/attachment/$attachmentline_file";

    if(!file_exists($pathfile) || $attachmentline_file == ""){
    $viewfile = "<font color=red>No Attachment<font>";
    }else
    $viewfile = "<a href='$pathfile' target='blank'>View File</a>";

echo <<< EOF
	<input type="hidden" name="attachmentline_idarr[$i]" value="$attachmentline_id">
	<tr >
		<td class="$rowtype" align="center">$i</td>
		<td class="$rowtype" align="center">$attachmentline_name</td>
		<td class="$rowtype" align="center">$viewfile</td>
		<td class="$rowtype"><a onclick="viewRemarks('attachment$i')" style="cursor:pointer">View Remarks >></a><div id="attachment$i" style="display:none">$attachmentline_remarks</div></td>
		<td class="$rowtype" align="center"><image $this->admindisplay src='images/edit.gif' title='Edit' onclick="editAttachment($attachmentline_id)" style="cursor:pointer"></td>

	</tr>
EOF;
	}
	if($i == 0){
	echo "<tr><td colspan='5'>No Record(s) Found.</td></tr>";
	}

echo <<< EOF
</table>
<br>
EOF;


  }

public function getTableActivityLine($token){
	$rowtype="";
    $timestamp= date("Y-m-d", time()) ;

	$sql = "SELECT * FROM $this->tableactivityline
    WHERE employee_id = $this->employee_id ORDER BY activityline_datefrom ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

         if($this->isAdmin){
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableactivityline' type='hidden'>".
		"<input name='id' value='$this->activityline_id' type='hidden' id='idViewRecordActivity'>".
		"<input name='idname' value='activityline_id' type='hidden'>".
		"<input name='title' value='ActivityLine' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit' id='idBtnViewRecordActivity' style='display:none'>".
		"</form>";
        $deletectrl = "<input type='button' value='Delete' onclick='deleteActivity()' id='idBtnDeleteActivity' style='display:none'>";
         }

echo <<< EOF
    <br>
    <form action="employee.php" method="POST" name="frmActivity" onsubmit="return validateActivity()">
    <input type="hidden" name="action" value="newactivity">
    <input type="hidden" name="employee_id" value="$this->employee_id">
    <input type="hidden" name="activityline_id" value="0">
    <input type="hidden" name="token" value="$token">

	<table border=0>

    <tr>
    <th colspan="4">Activity</th>
    <th colspan="3" align="right"><input $this->admindisplay type="button" value="Show Form"  name="btnShowForm" onclick="showHideActivity()"></th>
    </tr>

    <tr>
    <td colspan="7">
    <table id="tableActivity" style="display:none"><!--New Activity Form-->
    <tr>
    <th align="left" colspan="4"><input type="button" value="New Activity" onclick="newActivity()"></th>
    </tr>

    <tr>
    <td class="head">Date From</td>
    <td class="even">
    <input name='activityline_datefrom' id='activityline_datefrom' value="$timestamp" maxlength='10' size='10'>
    <input name='btnDate' value="Date" type="button" onclick="$this->activitydatefromctrl"> 
    </td>
        <td class="head">Date To</td>
    <td class="even">
    <input name='activityline_dateto' id='activityline_dateto' value="$timestamp" maxlength='10' size='10'>
    <input name='btnDate' value="Date" type="button" onclick="$this->activitydatetoctrl">
    </td>
    </tr>

    <tr>
    <td class="head">Activity</td>
    <td class="even"><input name="activityline_name" value="$activityline_name" size="30" maxlength="100"></td>
    <td class="head">Type</td>
    <td class="even">
    <select name="activityline_type">
    <option value="A" $selectA>College Activity</option>
    <option value="C" $selectC>Course</option>
    <option value="O" $selectO>Others</option>
    </select>
    </td>
    </tr>

    <tr>
    <td class="head">Remarks</td>
    <td class="even" colspan="3"><textarea name="activityline_remarks" cols="40" rows="4">$activityline_remarks</textarea></td>
    </tr>

    <td aclass="head" align="left"><input type="submit" value="Save"></td>
    <td aclass="head" align="right" colspan="3">$deletectrl</td>
    </tr>
    </form>

    <tr>
    <td aclass="head" align="center" colspan="4">$recordctrl</td>
    </tr>

    </tr>
    </table>
    </td>
    </tr>

    <tr align="center">
    <th>No</th>
    <th>Date From</th>
    <th>Date To</th>
    <th>Type</th>
    <th>Activity</th>
    <th>Remarks</th>
    <th></th>
    </tr>

EOF;

	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;

	$activityline_id = $row['activityline_id'];
	$activityline_datefrom = $row['activityline_datefrom'];
    $activityline_dateto = $row['activityline_dateto'];
    $activityline_type = $row['activityline_type'];
	$activityline_name = $row['activityline_name'];
	$activityline_remarks = $row['activityline_remarks'];

	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

	$activityline_remarks = str_replace( array("\r\n", "\n","\r"), "<br/>", $activityline_remarks );
	$activityline_remarks = str_replace( " ", "&nbsp;", $activityline_remarks );

    if($activityline_type == "A")
    $activityline_type = "College Activity";
    else if($activityline_type == "C")
    $activityline_type = "Course";
    else if($activityline_type == "O")
    $activityline_type = "Others";

echo <<< EOF
	<input type="hidden" name="activityline_idarr[$i]" value="$activityline_id">
	<tr >
		<td class="$rowtype" align="center">$i</td>
		<td class="$rowtype" align="center">$activityline_datefrom</td>
		<td class="$rowtype" align="center">$activityline_dateto</td>
		<td class="$rowtype" align="center">$activityline_name</td>
		<td class="$rowtype" align="center">$activityline_type</td>
		<td class="$rowtype"><a onclick="viewRemarks('activity$i')" style="cursor:pointer">View Remarks >></a><div id="activity$i" style="display:none">$activityline_remarks</div></td>
		<td class="$rowtype" align="center"><image $this->admindisplay src='images/edit.gif' title='Edit' onclick="editActivity($activityline_id)" style="cursor:pointer"></td>

	</tr>
EOF;
	}
	if($i == 0){
	echo "<tr><td colspan='7'>No Record(s) Found.</td></tr>";
	}

echo <<< EOF
</table>
<br>
EOF;


  }
  
  public function getTableDisciplineLine($token){
	$rowtype="";
    $timestamp= date("Y-m-d", time()) ;

	$sql = "SELECT * FROM $this->tabledisciplineline
    WHERE employee_id = $this->employee_id ORDER BY disciplineline_date ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

         if($this->isAdmin){
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tabledisciplineline' type='hidden'>".
		"<input name='id' value='$this->disciplineline_id' type='hidden' id='idViewRecordDiscipline'>".
		"<input name='idname' value='disciplineline_id' type='hidden'>".
		"<input name='title' value='DisciplineLine' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit' id='idBtnViewRecordDiscipline' style='display:none'>".
		"</form>";
        $deletectrl = "<input type='button' value='Delete' onclick='deleteDiscipline()' id='idBtnDeleteDiscipline' style='display:none'>";
         }

echo <<< EOF
    <br>
    <form action="employee.php" method="POST" name="frmDiscipline" onsubmit="return validateDiscipline()">
    <input type="hidden" name="action" value="newdiscipline">
    <input type="hidden" name="employee_id" value="$this->employee_id">
    <input type="hidden" name="disciplineline_id" value="0">
    <input type="hidden" name="token" value="$token">

	<table border=0>

    <tr>
    <th colspan="3">Discipline</th>
    <th colspan="2" align="right"><input $this->admindisplay type="button" value="Show Form"  name="btnShowForm" onclick="showHideDiscipline()"></th>
    </tr>

    <tr>
    <td colspan="5">
    <table id="tableDiscipline" style="display:none"><!--New Discipline Form-->
    <tr>
    <th align="left" colspan="4"><input type="button" value="New Discipline" onclick="newDiscipline()"></th>
    </tr>

    <tr>
    <td class="head">Date</td>
    <td class="even">
    <input name='disciplineline_date' id='disciplineline_date' value="$timestamp" maxlength='10' size='10'>
    <input name='btnDate' value="Date" type="button" onclick="$this->disciplinedatectrl"> <font color=red>YYYY-MM-DD (Ex: 2009-12-30)</font>
    </td>
    <td class="head">Discipline</td>
    <td class="even"><input name="disciplineline_name" value="$disciplineline_name" size="30" maxlength="100"></td>
    </tr>
    <tr>
    <td class="head">Remarks</td>
    <td class="even" colspan="3"><textarea name="disciplineline_remarks" cols="40" rows="4">$disciplineline_remarks</textarea></td>
    </tr>

    <td aclass="head" align="left"><input type="submit" value="Save"></td>
    <td aclass="head" align="right" colspan="3">$deletectrl</td>
    </tr>
    </form>

    <tr>
    <td aclass="head" align="center" colspan="4">$recordctrl</td>
    </tr>

    </tr>
    </table>
    </td>
    </tr>

    <tr align="center">
    <th>No</th>
    <th>Date</th>
    <th>Discipline</th>
    <th>Remarks</th>
    <th></th>
    </tr>

EOF;

	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;

	$disciplineline_id = $row['disciplineline_id'];
	$disciplineline_date = $row['disciplineline_date'];
	$disciplineline_name = $row['disciplineline_name'];
	$disciplineline_remarks = $row['disciplineline_remarks'];

	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

	$disciplineline_remarks = str_replace( array("\r\n", "\n","\r"), "<br/>", $disciplineline_remarks );
	$disciplineline_remarks = str_replace( " ", "&nbsp;", $disciplineline_remarks );

echo <<< EOF
	<input type="hidden" name="disciplineline_idarr[$i]" value="$disciplineline_id">
	<tr >
		<td class="$rowtype" align="center">$i</td>
		<td class="$rowtype" align="center">$disciplineline_date</td>
		<td class="$rowtype" align="center">$disciplineline_name</td>
		<td class="$rowtype"><a onclick="viewRemarks('discipline$i')" style="cursor:pointer">View Remarks >></a><div id="discipline$i" style="display:none">$disciplineline_remarks</div></td>
		<td class="$rowtype" align="center"><image $this->admindisplay src='images/edit.gif' title='Edit' onclick="editDiscipline($disciplineline_id)" style="cursor:pointer"></td>

	</tr>
EOF;
	}
	if($i == 0){
	echo "<tr><td colspan='5'>No Record(s) Found.</td></tr>";
	}

echo <<< EOF
</table>
<br>
EOF;


  }
  
  public function getTableAllowanceLine($token){
	$rowtype="";

    if($allowance_no == "")
    $allowanceline_no = $this->getLatestLine("allowanceline_no")+10;
    if($checkedActive=="")
    $checkedActive = "CHECKED";

    if($allowanceline_amount=="")
    $allowanceline_amount = 0;
    
	$sql = "SELECT * FROM $this->tableallowanceline
    WHERE employee_id = $this->employee_id ORDER BY allowanceline_no ";

	$this->log->showLog(4,"SQL before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

         if($this->isAdmin){
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableallowanceline' type='hidden'>".
		"<input name='id' value='$this->allowanceline_id' type='hidden' id='idViewRecord'>".
		"<input name='idname' value='allowanceline_id' type='hidden'>".
		"<input name='title' value='AllowanceLine' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit' id='idBtnViewRecord' style='display:none'>".
		"</form>";
        $deletectrl = "<input type='button' value='Delete' onclick='deleteAllowance()' id='idBtnDelete' style='display:none'>";
         }

echo <<< EOF
    <br>
    <form action="employee.php" method="POST" name="frmAllowance" onsubmit="return validateAllowance()">
    <input type="hidden" name="action" value="newallowance">
    <input type="hidden" name="employee_id" value="$this->employee_id">
    <input type="hidden" name="allowanceline_id" value="0">
    <input type="hidden" name="token" value="$token">

	<table border=0>

    <tr>
    <th colspan="6">Allowance</th>
    <th colspan="3" align="right"><input $this->admindisplay type="button" value="Show Form"  name="btnShowForm" onclick="showHideAllowance()"></th>
    </tr>

    <tr>
    <td colspan="9">
    <table id="tableAllowance" style="display:none"><!--New Allowance Form-->
    <tr>
    <th align="left" colspan="4"><input type="button" value="New Allowance" onclick="newAllowance()"></th>
    </tr>

    <tr>
    <td class="head">Allowance Name</td>
    <td class="even"><input name="allowanceline_name" value="$allowanceline_name" size="30" maxlength="100"></td>
    <td class="head">Active</td>
    <td class="even"><input type="checkbox" name="allowanceline_active" $checkedActive></td>
    </tr>
    <tr>
    <td class="head">Seq</td>
    <td class="even"><input name="allowanceline_no" value="$allowanceline_no" size="5" maxlength="10"></td>
    <td class="head">Amount (RM)</td>
    <td class="even"><input name="allowanceline_amount" value="$allowanceline_amount" size="10" maxlength="11"></td>
    </tr>
    <tr>
    <td class="head">EPF?</td>
    <td class="even"><input type="checkbox" name="allowanceline_epf" $checkedEPF></td>
    <td class="head">SOCSO?</td>
    <td class="even"><input type="checkbox" name="allowanceline_socso" $checkedSOCSO></td>
    </tr>

    <tr>
    <td class="head">Item Type</td>
    <td class="even" colspan="3">
    <select name="allowanceline_type">
    <option value="1">Income</option>
    <option value="-1">Deduction</option>
    <option value="0">Non Effect</option>
    </select>
    </td>
    </tr>

    <tr>
    <td aclass="head" align="left"><input type="submit" value="Save"></td>
    <td aclass="head" align="right" colspan="3">$deletectrl</td>
    </tr>
    </form>

    <tr>
    <td aclass="head" align="center" colspan="4">$recordctrl</td>
    </tr>

    </tr>
    </table>
    </td>
    </tr>

    <tr align="center">
    <th>No</th>
    <th>Seq</th>
    <th>Allowance Name</th>
    <th>EPF</th>
    <th>SOCSO</th>
    <th>Active</th>
    <th>Item Type</th>
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
	$allowanceline_type = $row['allowanceline_type'];
    
	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

	if ($allowanceline_epf=='1')
	$checked = "Y";
	if ($allowanceline_socso=='1')
	$checked2 = "Y";
	if ($allowanceline_active=='1')
	$checked3 = "Y";

    if($allowanceline_type == 1)
    $allowanceline_type = "Income";
    else if($allowanceline_type == 0)
    $allowanceline_type = "Non Effect";
    else
    $allowanceline_type = "Deduction";

echo <<< EOF
	<input type="hidden" name="allowanceline_idarr[$i]" value="$allowanceline_id">
	<tr align="center">
		<td class="$rowtype">$i</td>
		<td class="$rowtype">$allowanceline_no</td>


		<td class="$rowtype">$allowanceline_name</td>
		<td class="$rowtype">$checked</td>
		<td class="$rowtype">$checked2</td>
		<td class="$rowtype">$checked3</td>
		<td class="$rowtype">$allowanceline_type</td>
		<td class="$rowtype">$allowanceline_amount</td>
		<td class="$rowtype"><image $this->admindisplay src='images/edit.gif' title='Edit' onclick="editAllowance($allowanceline_id)" style="cursor:pointer"></td>

	</tr>
EOF;
	}
	if($i == 0){
	echo "<tr><td colspan='8'>No Record(s) Found.</td></tr>";
	}

echo <<< EOF
</table>
<br>
EOF;


  }

  /**
   * Update existing employee record
   *
   * @return bool
   * @access public
   */
  public function updateEmployee( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableemployee SET
	
        updated='$timestamp',updatedby=$this->updatedby,
        employee_salarymethod='$this->employee_salarymethod',



        employee_salary='$this->employee_salary',
        employee_ottrip='$this->employee_ottrip',
        employee_othour='$this->employee_othour',

        employee_epfrate=$this->employee_epfrate,
        employee_accno='$this->employee_accno',
        employee_bankname='$this->employee_bankname'
        WHERE employee_id='$this->employee_id'";
	$this->changesql = $sql;
	$this->log->showLog(3, "Update employee_id: $this->employee_id, $this->employee_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");

        /*
         *         employee_epfno='$this->employee_epfno',
        employee_socsono='$this->employee_socsono',
        employee_taxno='$this->employee_taxno',
        employee_pencenno='$this->employee_pencenno',
         */
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update employee failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update employee successfully.");
		return true;
	}
  } // end of member function updateEmployee

  /**
   * Save new employee into database
   *
   * @return bool
   * @access public
   */
  public function insertEmployee( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new employee $this->employee_name");
 	$sql="INSERT INTO $this->tableemployee (employee_name,employee_no,isactive, created,createdby,
	updated,updatedby,defaultlevel,organization_id,description,

    employee_altname,
    ic_placeissue,
    ic_color,
    contact_address,
    employee_jobdescription,
    contact_postcode,
    contact_city,
    contact_state,
    contact_telno,
    place_dob,
    department_id,
    supervisor_1,
    supervisor_2,
    employeegroup_id,
    employee_joindate,
    employee_confirmdate,
    employee_socsono,
    employee_epfno,
    employee_taxno,
    employee_pencenno,
    isfulltime,
    issalesrepresentative,
    employee_salary,
    employee_ottrip,
    employee_othour,
    annual_leave,

    employee_newicno,
    jobposition_id,
    employee_salarymethod,
    employee_oldicno,
    permanent_address,
    gender,
    permanent_postcode,
    permanent_state,
    permanent_city,
    permanent_country,
    contact_country,
    permanent_telno,
    employee_hpno,
    religion_id,
    races_id,
    uid,
    marital_status,
    isovertime,
    islecturer,
    employee_dob,
    employee_epfrate,
    employee_accno,
    employee_bankname,
    employee_cardno)
    values(
	'$this->employee_name','$this->employee_no','$this->isactive','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->defaultlevel,$this->organization_id,'$this->description',

    '$this->employee_altname',
    '$this->ic_placeissue',
    '$this->ic_color',
    '$this->contact_address',
    '$this->employee_jobdescription',
    '$this->contact_postcode',
    '$this->contact_city',
    '$this->contact_state',
    '$this->contact_telno',
    '$this->place_dob',
    '$this->department_id',
    '$this->supervisor_1',
    '$this->supervisor_2',
    '$this->employeegroup_id',
    '$this->employee_joindate',
    '$this->employee_confirmdate',
    '$this->employee_socsono',
    '$this->employee_epfno',
    '$this->employee_taxno',
    '$this->employee_pencenno',
    '$this->isfulltime',
    '$this->issalesrepresentative',
    '$this->employee_salary',
    '$this->employee_ottrip',
    '$this->employee_othour',
    '$this->annual_leave',

    '$this->employee_newicno',
    '$this->jobposition_id',
    '$this->employee_salarymethod',
    '$this->employee_oldicno',
    '$this->permanent_address',
    '$this->gender',
    '$this->permanent_postcode',
    '$this->permanent_state',
    '$this->permanent_city',
    $this->permanent_country,
    $this->contact_country,
    '$this->permanent_telno',
    '$this->employee_hpno',
    $this->religion_id,
    $this->races_id,
    $this->uid,
    '$this->marital_status',
    $this->isovertime,
    $this->islecturer,
    '$this->employee_dob',
    $this->employee_epfrate,
    '$this->employee_accno',
    '$this->employee_bankname',
	'$this->employee_cardno')";
$this->changesql = $sql;
	$this->log->showLog(4,"Before insert employee SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert employee code $employee_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new employee $employee_name successfully");
		return true;
	}
  } // end of member function insertEmployee

  /**
   * Pull data from employee table into class
   *
   * @return bool
   * @access public
   */
  public function fetchEmployee( $employee_id) {


	$this->log->showLog(3,"Fetching employee detail into class Employee.php.<br>");
		
    $sql="SELECT *,
    (select jobposition_name from $this->tablejobposition jp, $this->tableemployee em
    where jp.jobposition_id = em.jobposition_id and em.employee_id = $employee_id) as jobposition_name,
    (select department_name from $this->tabledepartment dp, $this->tableemployee em
    where dp.department_id = em.department_id and em.employee_id = $employee_id) as department_name
    from $this->tableemployee where employee_id=$employee_id";
	
	$this->log->showLog(4,"ProductEmployee->fetchEmployee, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->employee_name=$row["employee_name"];
		$this->employee_no=$row["employee_no"];
		$this->organization_id=$row['organization_id'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->isactive=$row['isactive'];
		$this->description=$row['description'];


        $this->department_name=$row['department_name'];
        $this->employee_altname=$row['employee_altname'];
		$this->ic_placeissue=$row['ic_placeissue'];
		$this->ic_color=$row['ic_color'];
		$this->contact_address=$row['contact_address'];
        $this->employee_jobdescription=$row['employee_jobdescription'];
        $this->employee_accno=$row['employee_accno'];
        $this->employee_bankname=$row['employee_bankname'];
        $this->employee_epfrate=$row['employee_epfrate'];
        
		$this->contact_postcode=$row['contact_postcode'];
		$this->contact_city=$row['contact_city'];
		$this->contact_state=$row['contact_state'];
		$this->contact_telno=$row['contact_telno'];
		$this->place_dob=$row['place_dob'];
		$this->department_id=$row['department_id'];
		$this->supervisor_1=$row['supervisor_1'];
		$this->supervisor_2=$row['supervisor_2'];
		$this->employeegroup_id=$row['employeegroup_id'];
		$this->employee_joindate=$row['employee_joindate'];
		$this->employee_confirmdate=$row['employee_confirmdate'];
		$this->contact_country=$row['contact_country'];
		$this->employee_socsono=$row['employee_socsono'];
        $this->employee_epfno=$row['employee_epfno'];
        $this->employee_taxno=$row['employee_taxno'];
        $this->employee_pencenno=$row['employee_pencenno'];
		$this->isfulltime=$row['isfulltime'];
		$this->issalesrepresentative=$row['issalesrepresentative'];

		$this->employee_salary=$row['employee_salary'];
        $this->employee_ottrip=$row['employee_ottrip'];
        $this->employee_othour=$row['employee_othour'];
		$this->annual_leave=$row['annual_leave'];
		$this->jobposition_name=$row['jobposition_name'];


		$this->employee_newicno=$row['employee_newicno'];
		$this->jobposition_id=$row['jobposition_id'];
		$this->employee_salarymethod=$row['employee_salarymethod'];
		$this->employee_oldicno=$row['employee_oldicno'];
		$this->permanent_address=$row['permanent_address'];
		$this->gender=$row['gender'];
		$this->permanent_postcode=$row['permanent_postcode'];
		$this->permanent_state=$row['permanent_state'];
		$this->permanent_city=$row['permanent_city'];
		$this->permanent_country=$row['permanent_country'];
		$this->permanent_telno=$row['permanent_telno'];
		$this->employee_hpno=$row['employee_hpno'];
		$this->religion_id=$row['religion_id'];
		$this->races_id=$row['races_id'];
        $this->uid=$row['uid'];
		$this->marital_status=$row['marital_status'];
		$this->filephoto=$row['filephoto'];
		$this->isovertime=$row['isovertime'];
		$this->islecturer=$row['islecturer'];
		$this->employee_dob=$row['employee_dob'];
		$this->employee_cardno=$row['employee_cardno'];

   	$this->log->showLog(4,"Employee->fetchEmployee,database fetch into class successfully");
	$this->log->showLog(4,"employee_name:$this->employee_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Employee->fetchEmployee,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchEmployee

  /**
   * Delete particular employee id
   *
   * @param int employee_id
   * @return bool
   * @access public
   */
  public function deleteEmployee( $employee_id ) {
    	$this->log->showLog(2,"Warning: Performing delete employee id : $employee_id !");
	$sql="DELETE FROM $this->tableemployee where employee_id=$employee_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->changesql = $sql;
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: employee ($employee_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"employee ($employee_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteEmployee

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllEmployee( $wherestring,  $orderbystring,$limitstr="") {
  $this->log->showLog(4,"Running ProductEmployee->getSQLStr_AllEmployee: $sql");

  /*
    $wherestring .= " and a.department_id = b.department_id and a.employeegroup_id = c.employeegroup_id and a.races_id = e.races_id and a.religion_id = f.religion_id ";
    $sql="SELECT a.*,b.department_name,c.employeegroup_name,e.races_name,f.religion_name
                FROM $this->tableemployee a, $this->tabledepartment b, $this->tableemployeegroup c, $this->tableraces e, $this->tablereligion f " .
	" $wherestring $orderbystring $limitstr";
   * 
   */

    $sql = "select a.*,b.department_name,c.employeegroup_name,e.races_name,f.religion_name
    from $this->tableemployee a
    inner join $this->tabledepartment b on b.department_id = a.department_id
    inner join $this->tableemployeegroup c on a.employeegroup_id = c.employeegroup_id
    inner join $this->tableraces e on a.races_id = e.races_id
    inner join $this->tablereligion f on a.religion_id = f.religion_id
    left join $this->tableappraisalline s on s.employee_id = a.employee_id
    $wherestring
    group by a.employee_id
    $orderbystring $limitstr";
   
    $this->log->showLog(4,"Generate showemployeetable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllEmployee

 public function showEmployeeTable($wherestring,$orderbystring,$limitstr=""){
	
	$this->log->showLog(3,"Showing Employee Table");
	$sql=$this->getSQLStr_AllEmployee($wherestring,$orderbystring,$limitstr);
	
	$query=$this->xoopsDB->query($sql);

    if($limitstr!=""){
    $records = str_replace("limit","",$limitstr);
    $limitdisplay=" Show Only $records Record(s)";
    }
	echo <<< EOF
	<table border='0' cellspacing='3'>
  		<tbody>
<b>$limitdisplay</b>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Employee no</th>
				<th style="text-align:center;">Name</th>
				<th style="text-align:center;">Department</th>
                <th style="text-align:center;">Group</th>
                <th style="text-align:center;">IC No</th>
                <th style="text-align:center;">Races</th>
                <th style="text-align:center;">Gender</th>
                <th style="text-align:center;">HP No</th>
                <th style="text-align:center;">Lecturer</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;display:none">Default Level</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$employee_id=$row['employee_id'];
		$employee_name=$row['employee_name'];
		$employee_no=$row['employee_no'];
        $employee_altname=$row['employee_altname'];
        $ic_placeissue=$row['ic_placeissue'];
        $ic_color=$row['ic_color'];
        $contact_address=$row['contact_address'];
        $employee_jobdescription=$row['employee_jobdescription'];
        
        $contact_postcode=$row['contact_postcode'];
        $contact_city=$row['contact_city'];
        $contact_state=$row['contact_state'];
        $contact_telno=$row['contact_telno'];
        $place_dob=$row['place_dob'];
        $department_name=$row['department_name'];
        $employeegroup_name=$row['employeegroup_name'];
        $employee_joindate=$row['employee_joindate'];
        $employee_confirmdate=$row['employee_confirmdate'];
        $employee_socsono=$row['employee_socsono'];
        $employee_epfno=$row['employee_epfno'];
        $employee_taxno=$row['employee_taxno'];
        $employee_pencenno=$row['employee_pencenno'];
        $isfulltime=$row['isfulltime'];
        $issalesrepresentative=$row['issalesrepresentative'];

        $employee_salary=$row['employee_salary'];
        $employee_ottrip=$row['employee_ottrip'];
        $employee_othours=$row['employee_othours'];
        $annual_leave=$row['annual_leave'];
        $employee_newicno=$row['employee_newicno'];
        $jobposition_id=$row['jobposition_id'];
        $employee_salarymethod=$row['employee_salarymethod'];
		$employee_oldicno=$row['employee_oldicno'];
		$permanent_address=$row['permanent_address'];
		$gender=$row['gender'];
		$permanent_postcode=$row['permanent_postcode'];
		$permanent_state=$row['permanent_state'];
		$permanent_city=$row['permanent_city'];
		$permanent_country=$row['permanent_country'];
		$contact_country=$row['contact_country'];
		$permanent_telno=$row['permanent_telno'];
		$employee_hpno=$row['employee_hpno'];
		$religion_id=$row['religion_id'];
		$races_name=$row['races_name'];
		$marital_status=$row['marital_status'];
		$filephoto=$row['filephoto'];
		$isovertime=$row['isovertime'];
		$islecturer=$row['islecturer'];
		$employee_dob=$row['employee_dob'];

		$defaultlevel=$row['defaultlevel'];

		$isactive=$row['isactive'];

        if($islecturer==1)
        $islecturer = "Y";
        else
        $islecturer = "N";
		
		if($isactive==0)
		{$isactive='N';
		$isactive="<b style='color:red;'>N</b>";
		}
		else
		$isactive='Y';

       
   if($employee_category=="S")
   $employee_category = "Employee";
   else
    $employee_category = "Co Curriculum";


		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

            
		echo <<< EOF
        
		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$employee_no</td>
			<td class="$rowtype" style="text-align:left;"><a href="../simbiz/employee.php?action=view&employee_id=$employee_id">$employee_name</a></td>
			<td class="$rowtype" style="text-align:center;">$department_name</td>
            <td class="$rowtype" style="text-align:center;">$employeegroup_name</td>
            <td class="$rowtype" style="text-align:center;">$employee_newicno</td>
            <td class="$rowtype" style="text-align:center;">$races_name</td>
            <td class="$rowtype" style="text-align:center;">$gender</td>
            <td class="$rowtype" style="text-align:center;">$employee_hpno</td>
            <td class="$rowtype" style="text-align:center;">$islecturer</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;display:none">$defaultlevel</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="employee.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this employee'>
				<input type="hidden" value="$employee_id" name="employee_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
 if($this->issearch=="Y"){
            $wherestring .= " and a.department_id = b.department_id and a.employeegroup_id = c.employeegroup_id and a.races_id = e.races_id and 		a.religion_id = f.religion_id ";
        $printctrl="<form action='htmlemployeelist.php' target='_blank' method='POST'>
                <input type='Submit' name='submit' value='Print Preview'>
                <textarea name='wherestring' style='display:none'>$wherestring</textarea>
        </form>";
        }
        else
        $printctrl="";

	echo  "</tr></tbody></table>$printctrl";
 }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestEmployeeID() {
	$sql="SELECT MAX(employee_id) as employee_id from $this->tableemployee;";
	$this->log->showLog(3,'Checking latest created employee_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created employee_id:' . $row['employee_id']);
		return $row['employee_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tableemployee;";
	$this->log->showLog(3,'Checking next defaultlevel');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found next defaultlevel:' . $row['defaultlevel']);
		return  $row['defaultlevel'];
	}
	else
	return 10;
	
  } // end

 public function allowDelete($employee_id){
	
	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where employee_id = $employee_id or last_employee = $employee_id or next_employee = $employee_id ";
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$rowcount = $row['rowcount'];
	}

	if($rowcount > 0)
	return false;
	else
	return true;
//	return $checkistrue;
	}

     public function showSearchForm($wherestr){


	if($this->issearch != "Y"){
	$this->employee_no = "";
	$this->isactive = "null";
	$this->gender = "";
    $this->marital_status = "";
    $this->isapparaisal_alert=="";
	}

	//iscomplete
    
	if($this->isactive == "1")
	$selectactiveY = "selected = 'selected'";
	else if($this->isactive == "0")
	$selectactiveN = "selected = 'selected'";
	else
	$selectactiveL = "selected = 'selected'";

    $selectGenderN="";
    $selectGenderM="";
    $selectGenderF="";
    if($this->gender=="M")
    $selectGenderM = "SELECTED";
    else if($this->gender=="F")
    $selectGenderF = "SELECTED";
    else
    $selectGenderN = "SELECTED";

    $selectMaritalN="";
    $selectMaritalS="";
    $selectMaritalM="";
    if($this->marital_status=="S")
    $selectMaritalS = "SELECTED";
    else if($this->marital_status=="M")
    $selectMaritalM = "SELECTED";
    else
    $selectMaritalN = "SELECTED";


    $selectAppNull="";
    $selectAppY="";
    if($this->isappraisal_alert=="Y")
    $selectAppY = "SELECTED";
    else
    $selectAppNull = "SELECTED";

	//echo $this->iscomplete;

echo <<< EOF
<form name="frmEmployee" action="employee.php" method="POST">
	</form>
	<form name="frmSearch" action="employee.php" method="POST">

	<table>
	<tr>
	<td nowrap><input value="Reset" type="reset">
	<input value="New" type="hidden" onclick="gotoAction('');"></td>
	</tr>
	</table>

	<table border="0">
	<input name="issearch" value="Y" type="hidden">
	<input name="action" value="search" type="hidden">
	<tr><th colspan="4">Criterial</th></tr>

	<tr>
	<td class="head">Employee No</td>
	<td class="even" colspan="3"><input name="employee_no" value="$this->employee_no"></td>
	</tr>

    <tr>
	<td class="head">New IC No</td>
	<td class="even" acolspan="3"><input name="employee_newicno" value="$this->employee_newicno"></td>
    <td class="head">Employee Name</td>
	<td class="even"><input name="employee_name" value="$this->employee_name"></td>
	</tr>

    <tr>
	<td class="head">Department</td>
	<td class="even">$this->departmentctrl</td>
    <td class="head">Group</td>
	<td class="even">$this->employeegroupctrl</td>
	</tr>

    <tr>
	<td class="head">Races</td>
	<td class="even">$this->racesctrl</td>
    <td class="head">Religion</td>
	<td class="even">$this->religionctrl</td>
	</tr>

    <tr>
	<td class="head">Gender</td>
	<td class="even">
    <select name="gender">
    <option value="" $selectGenderN>Null</option>
    <option value="M" $selectGenderM>Male</option>
    <option value="F" $selectGenderF>Female</option>
    </select>
    </td>
    <td class="head">Marital Status</td>
	<td class="even">
    <select name="marital_status">
    <option value="" $selectMaritalN>Null</option>
    <option value="S" $selectMaritalS>Single</option>
    <option value="M" $selectMaritalM>Married</option>
    </select>
    </td>
	</tr>


	<tr>
	<td class="head">Is Active</td>
	<td class="even" colspan="3">
	<select name="isactive">
	<option value="null" $selectactiveL>Null</option>
	<option value=1 $selectactiveY>Yes</option>
	<option value=0 $selectactiveN>No</option>
	</select>
	</td>

	</tr>

	<tr>
	<th colspan="4"><input type="submit" aonclick="gotoAction('search');" value="Search" ></th>
	</tr>

	</table>
	</form>
	<br>
EOF;
  }

	public function getWhereStr(){
        $current_date = date("Y-m-d", time());
        
	$wherestr = "";

	if($this->employee_no != "")
	$wherestr .= " and a.employee_no like '$this->employee_no' ";
    if($this->employee_name != "")
	$wherestr .= " and a.employee_name like '$this->employee_name' ";
    if($this->employee_newicno != "")
	$wherestr .= " and a.employee_newicno like '$this->employee_newicno' ";
    if($this->department_id > 0)
	$wherestr .= " and a.department_id = $this->department_id ";
	if($this->employeegroup_id > 0)
	$wherestr .= " and a.employeegroup_id = $this->employeegroup_id ";
	if($this->year_id > 0)
	$wherestr .= " and a.year_id = $this->year_id ";
    if($this->session_id > 0)
	$wherestr .= " and a.session_id = $this->session_id ";
    if($this->races_id > 0)
	$wherestr .= " and a.races_id = $this->races_id ";
    if($this->religion_id > 0)
	$wherestr .= " and a.religion_id = $this->religion_id ";
    if($this->gender != "")
	$wherestr .= " and a.gender like '$this->gender' ";
    if($this->marital_status != "")
	$wherestr .= " and a.marital_status like '$this->marital_status' ";
    
        if($this->isappraisal_alert != ""){
	$wherestr .= " and (datediff(s.appraisalline_date,'$current_date')) between 0 and 7 ";
        }


	if($this->isactive == "0" || $this->isactive == "1")
	$wherestr .= " and a.isactive = $this->isactive ";

	return $wherestr;

	}

    public function savefile($tmpfile,$newfilename,$employee_id,$fieldname){

		if(move_uploaded_file($tmpfile, "upload/employee/photo/$newfilename")){
		$sqlupdate="UPDATE $this->tableemployee set $fieldname='$newfilename' where employee_id=$employee_id";
		$qryUpdate=$this->xoopsDB->query($sqlupdate);
		}else{
		echo "Cannot Upload File";
		}
	}

	public function deletefile($employee_id,$fieldname){
		$sql="SELECT $fieldname as fldname from $this->tableemployee where employee_id=$employee_id";
		$query=$this->xoopsDB->query($sql);
		$myfilename="";
		if($row=$this->xoopsDB->fetchArray($query)){
			$myfilename=$row['fldname'];
		}
		$myfilename="upload/employee/photo/$myfilename";
		$this->log->showLog(3,"This file name: $myfilename");
		unlink("$myfilename");
		$sqlupdate="UPDATE $this->tableemployee set $fieldname='' where employee_id=$employee_id";
		$qryDelete=$this->xoopsDB->query($sqlupdate);
	}

    public function deletefile2($filename){
		unlink("upload/employee/$filename");
	}

    public function updateEmpInfo($employeegroup_id){

    $sql = "select * from $this->tableemployeegroup where employeegroup_id = $employeegroup_id";

        $query=$this->xoopsDB->query($sql);

        $islecturer = 0;
        $isovertime = 0;
        $isfulltime = 0;
        $issalesrepresentative = 0;
		if($row=$this->xoopsDB->fetchArray($query)){
        $islecturer = $row['islecturer'];
        $isovertime = $row['isovertime'];
        $isfulltime = $row['isfulltime'];
        $issalesrepresentative = $row['issalesrepresentative'];

        }

        return array('islecturer'=>$islecturer,'isovertime'=>$isovertime,'isfulltime'=>$isfulltime,'issalesrepresentative'=>$issalesrepresentative);
    }

    public function getSelectDBAjax($strchar,$idinput,$idlayer,$ctrlid,$ocf,$table,$primary_key,$primary_name,$wherestr,$line=0){
	$retval = "";

	$limit = "";
	if($strchar == "")
	$limit = "limit 0";

	$sql = "select $primary_key as fld_id,$primary_name as fld_name from $table
		where $primary_name like '%$strchar%' and $primary_key > 0 $wherestr
		$limit";

	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	$rowtypes="";
	$i=0;
	$retval .= "<table style='width:400px'><tr><th>List</th></tr>";
	while ($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$fld_name = $row['fld_name'];
	$fld_id = $row['fld_id'];

	if($rowtypes=="even")
	$rowtypes = "odd";
	else
	$rowtypes = "even";

	$idtr = $idinput.$i;

	$onchangefunction = "";
    /*
	if($ocf==1){
		if($primary_key == "bpartner_id")
		$onchangefunction = "getBPInfo($fld_id)";
		else if($primary_key == "product_id")
		$onchangefunction = "getProductInfo($fld_id,$line)";
	}*/

	$retval .= "<tr  class='$rowtypes' onmouseover=onmover('idTRLine$idtr') onmouseout=onmout('idTRLine$idtr','$rowtypes') id='idTRLine$idtr' onclick=selectList('$fld_id','$idinput','$idlayer','$ctrlid','$onchangefunction');  style='cursor:pointer'>";
	$retval .= "<td>$fld_name</td>";
	$retval .= "</tr>";
	}


	$retval .= "</table>";

	return $retval;
 	}

    public function getSelectDBAjaxEmployee($strchar,$idinput,$idlayer,$ctrlid,$ocf,$table,$primary_key,$primary_name,$wherestr,$line=0){
	$retval = "";

	$limit = "";
	if($strchar == "")
	$limit = "limit 0";

	$sql = "select $primary_key as fld_id,$primary_name as fld_name from $table
		where $primary_name like '%$strchar%' and $primary_key > 0 $wherestr
		$limit";

	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	$rowtypes="";
	$i=0;
	$retval .= "<table style='width:400px'><tr><th>List</th></tr>";
	while ($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$fld_name = $row['fld_name'];
	$fld_id = $row['fld_id'];

	if($rowtypes=="even")
	$rowtypes = "odd";
	else
	$rowtypes = "even";

	$idtr = $idinput.$i;

	$onchangefunction = "";
    /*
	if($ocf==1){
		if($primary_key == "bpartner_id")
		$onchangefunction = "getBPInfo($fld_id)";
		else if($primary_key == "product_id")
		$onchangefunction = "getProductInfo($fld_id,$line)";
	}*/

	$retval .= "<tr  class='$rowtypes' onmouseover=onmover('idTRLine$idtr') onmouseout=onmout('idTRLine$idtr','$rowtypes') id='idTRLine$idtr' onclick=selectList('$fld_id','$idinput','$idlayer','$ctrlid','$onchangefunction');  style='cursor:pointer'>";
	$retval .= "<td>$fld_name</td>";
	$retval .= "</tr>";
	}


	$retval .= "</table>";

	return $retval;
 	}

    public function getSelectDBAjaxJobposition($strchar,$idinput,$idlayer,$ctrlid,$ocf,$table,$primary_key,$primary_name,$wherestr,$line=0){
	$retval = "";

	$limit = "";
	if($strchar == "")
	$limit = "limit 0";

	$sql = "select $primary_key as fld_id,$primary_name as fld_name from $table
		where $primary_name like '%$strchar%' and $primary_key > 0 $wherestr
		$limit";

	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	$rowtypes="";
	$i=0;
	$retval .= "<table style='width:400px'><tr><th>List</th></tr>";
	while ($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$fld_name = $row['fld_name'];
	$fld_id = $row['fld_id'];

	if($rowtypes=="even")
	$rowtypes = "odd";
	else
	$rowtypes = "even";

	$idtr = $idinput.$i;

	$onchangefunction = "";
    /*
	if($ocf==1){
		if($primary_key == "bpartner_id")
		$onchangefunction = "getBPInfo($fld_id)";
		else if($primary_key == "product_id")
		$onchangefunction = "getProductInfo($fld_id,$line)";
	}*/

	$retval .= "<tr  class='$rowtypes' onmouseover=onmover('idTRLine$idtr') onmouseout=onmout('idTRLine$idtr','$rowtypes') id='idTRLine$idtr' onclick=selectList('$fld_id','$idinput','$idlayer','$ctrlid','$onchangefunction');  style='cursor:pointer'>";
	$retval .= "<td>$fld_name</td>";
	$retval .= "</tr>";
	}


	$retval .= "</table>";

	return $retval;
 	}

    public function getLatestMaxID($tablename,$fld){
        $sql="SELECT MAX($fld) as max_id from $tablename;";

        $this->log->showLog(4,"SQL: $sql");
        $query=$this->xoopsDB->query($sql);
        if($row=$this->xoopsDB->fetchArray($query)){
        $this->log->showLog(3,'Found latest created employee_id:' . $row['employee_id']);
        return $row['max_id'];
        }
        else
        return -1;
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
  
    public function insertAllowance(){
	//$i = $this->getLatestLine("allowanceline_no");
    $timestamp= date("y/m/d H:i:s", time()) ;
        
    $checkEPF=0;
    $checkSOCSO=0;
    $checkActive=0;
    if($this->allowanceline_epf == "on")
    $checkEPF = 1;
    if($this->allowanceline_socso == "on")
    $checkSOCSO = 1;
    if($this->allowanceline_active == "on")
    $checkActive = 1;
    
	$sql = "INSERT INTO $this->tableallowanceline
    (allowanceline_no,employee_id,allowanceline_name,allowanceline_amount,
    allowanceline_epf,allowanceline_socso,allowanceline_active,allowanceline_type,
    created,createdby,updated,updatedby)
    values
    ($this->allowanceline_no,$this->employee_id,'$this->allowanceline_name',$this->allowanceline_amount,
    $checkEPF,$checkSOCSO,$checkActive,
    $this->allowanceline_type,
    '$timestamp',$this->updatedby,'$timestamp',$this->updatedby)";

    $this->changesql = $sql;

	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update allowance failed");
		return false;
	}else
    return true;

  }

      public function updateAllowance(){
	//$i = $this->getLatestLine("allowanceline_no");

 	$timestamp= date("y/m/d H:i:s", time()) ;
    $checkEPF=0;
    $checkSOCSO=0;
    $checkActive=0;
    if($this->allowanceline_epf == "on")
    $checkEPF = 1;
    if($this->allowanceline_socso == "on")
    $checkSOCSO = 1;
    if($this->allowanceline_active == "on")
    $checkActive = 1;

	$sql = "UPDATE $this->tableallowanceline SET
		allowanceline_no = $this->allowanceline_no,
		allowanceline_name = '$this->allowanceline_name',
		allowanceline_amount = $this->allowanceline_amount,
		allowanceline_type = $this->allowanceline_type,
		allowanceline_epf = '$checkEPF',
		allowanceline_socso = '$checkSOCSO',
		allowanceline_active = '$checkActive',
        updated='$timestamp',
        updatedby=$this->updatedby         
		WHERE allowanceline_id = $this->allowanceline_id";


    $this->changesql = $sql;

	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update allowance failed");
		return false;
	}else
    return true;

  }


  public function fetchAllowance($allowanceline_id){

    $sql = "select * from $this->tableallowanceline where allowanceline_id = $allowanceline_id";

    $query=$this->xoopsDB->query($sql);

    if($row=$this->xoopsDB->fetchArray($query)){
    $this->allowanceline_no = $row['allowanceline_no'];
    $this->allowanceline_name = $row['allowanceline_name'];
    $this->allowanceline_amount = $row['allowanceline_amount'];
    $this->allowanceline_epf = $row['allowanceline_epf'];
    $this->allowanceline_socso = $row['allowanceline_socso'];
    $this->allowanceline_active = $row['allowanceline_active'];
     $this->allowanceline_type= $row['allowanceline_type'];
    }
    
  }

   public function deleteAllowance($line){
	$sql = "DELETE FROM $this->tableallowanceline WHERE allowanceline_id = $line ";


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

  public function insertDiscipline(){
	//$i = $this->getLatestLine("disciplineline_no");
    $timestamp= date("y/m/d H:i:s", time()) ;


	$sql = "INSERT INTO $this->tabledisciplineline
    (disciplineline_date,employee_id,disciplineline_name,
    disciplineline_remarks,
    created,createdby,updated,updatedby)
    values
    ('$this->disciplineline_date',$this->employee_id,'$this->disciplineline_name',
    '$this->disciplineline_remarks',
    '$timestamp',$this->updatedby,'$timestamp',$this->updatedby)";

    $this->changesql = $sql;

	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update discipline failed");
		return false;
	}else
    return true;

  }

  public function fetchDiscipline($disciplineline_id){

    $sql = "select * from $this->tabledisciplineline where disciplineline_id = $disciplineline_id";

    $query=$this->xoopsDB->query($sql);

    if($row=$this->xoopsDB->fetchArray($query)){
    $this->disciplineline_date = $row['disciplineline_date'];
    $this->disciplineline_name = $row['disciplineline_name'];
    $this->disciplineline_remarks = $row['disciplineline_remarks'];

    }

  }

  public function updateDiscipline(){
	//$i = $this->getLatestLine("disciplineline_no");

 	$timestamp= date("y/m/d H:i:s", time()) ;


	$sql = "UPDATE $this->tabledisciplineline SET
		disciplineline_date = '$this->disciplineline_date',
		disciplineline_name = '$this->disciplineline_name',
		disciplineline_remarks = '$this->disciplineline_remarks',
        updated='$timestamp',
        updatedby=$this->updatedby
		WHERE disciplineline_id = $this->disciplineline_id";


    $this->changesql = $sql;

	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update discipline failed");
		return false;
	}else
    return true;

  }

     public function deleteDiscipline($line){
	$sql = "DELETE FROM $this->tabledisciplineline WHERE disciplineline_id = $line ";


	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update discipline failed");
		return false;
	}else{
		$this->log->showLog(2, "Update discipline Successfully");
		return true;
	}

  }
  
  public function insertActivity(){
	//$i = $this->getLatestLine("activityline_no");
    $timestamp= date("y/m/d H:i:s", time()) ;


	$sql = "INSERT INTO $this->tableactivityline
    (activityline_datefrom,activityline_dateto,employee_id,
    activityline_name,activityline_remarks,activityline_type,
    created,createdby,updated,updatedby)
    values
    ('$this->activityline_datefrom','$this->activityline_dateto',$this->employee_id,
    '$this->activityline_name','$this->activityline_remarks','$this->activityline_type',
    '$timestamp',$this->updatedby,'$timestamp',$this->updatedby)";

    $this->changesql = $sql;

	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update activity failed");
		return false;
	}else
    return true;

  }

  public function fetchActivity($activityline_id){

    $sql = "select * from $this->tableactivityline where activityline_id = $activityline_id";

    $query=$this->xoopsDB->query($sql);

    if($row=$this->xoopsDB->fetchArray($query)){
    $this->activityline_datefrom = $row['activityline_datefrom'];
    $this->activityline_dateto = $row['activityline_dateto'];
    $this->activityline_type = $row['activityline_type'];
    $this->activityline_name = $row['activityline_name'];
    $this->activityline_remarks = $row['activityline_remarks'];

    }

  }

  public function updateActivity(){
	//$i = $this->getLatestLine("activityline_no");

 	$timestamp= date("y/m/d H:i:s", time()) ;


	$sql = "UPDATE $this->tableactivityline SET
		activityline_datefrom = '$this->activityline_datefrom',
		activityline_dateto = '$this->activityline_dateto',
		activityline_type = '$this->activityline_type',
		activityline_name = '$this->activityline_name',
		activityline_remarks = '$this->activityline_remarks',
        updated='$timestamp',
        updatedby=$this->updatedby
		WHERE activityline_id = $this->activityline_id";


    $this->changesql = $sql;

	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update activity failed");
		return false;
	}else
    return true;

  }

     public function deleteActivity($line){
	$sql = "DELETE FROM $this->tableactivityline WHERE activityline_id = $line ";


	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update activity failed");
		return false;
	}else{
		$this->log->showLog(2, "Update activity Successfully");
		return true;
	}

  }
  
    public function insertAttachment(){
	//$i = $this->getLatestLine("attachmentline_no");
    $timestamp= date("y/m/d H:i:s", time()) ;


	$sql = "INSERT INTO $this->tableattachmentline
    (employee_id,attachmentline_name,
    attachmentline_remarks,
    created,createdby,updated,updatedby)
    values
    ($this->employee_id,'$this->attachmentline_name',
    '$this->attachmentline_remarks',
    '$timestamp',$this->updatedby,'$timestamp',$this->updatedby)";

    $this->changesql = $sql;

	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update attachment failed");
		return false;
	}else
    return true;

  }

  public function fetchAttachment($attachmentline_id){

    $sql = "select * from $this->tableattachmentline where attachmentline_id = $attachmentline_id";

    $query=$this->xoopsDB->query($sql);

    if($row=$this->xoopsDB->fetchArray($query)){
    $this->attachmentline_file = $row['attachmentline_file'];
    $this->attachmentline_name = $row['attachmentline_name'];
    $this->attachmentline_remarks = $row['attachmentline_remarks'];

    }

  }

  public function updateAttachment(){
	//$i = $this->getLatestLine("attachmentline_no");

 	$timestamp= date("y/m/d H:i:s", time()) ;


	$sql = "UPDATE $this->tableattachmentline SET

		attachmentline_name = '$this->attachmentline_name',
		attachmentline_remarks = '$this->attachmentline_remarks',
        updated='$timestamp',
        updatedby=$this->updatedby
		WHERE attachmentline_id = $this->attachmentline_id";


    $this->changesql = $sql;

	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update attachment failed");
		return false;
	}else
    return true;

  }

     public function deleteAttachment($line){
	$sql = "DELETE FROM $this->tableattachmentline WHERE attachmentline_id = $line ";


    $this->deletefileAttachment($line);

	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update attachment failed");
		return false;
	}else{
		$this->log->showLog(2, "Update attachment Successfully");
		return true;
	}

  }

  public function savefileAttachment($tmpfile,$newfilename,$attachmentline_id){

		if(move_uploaded_file($tmpfile, "upload/employee/attachment/$newfilename")){
		$sqlupdate="UPDATE $this->tableattachmentline set attachmentline_file='$newfilename' where attachmentline_id=$attachmentline_id";
		$qryUpdate=$this->xoopsDB->query($sqlupdate);
		}else{
		echo "Cannot Upload File";
		}
	}

	public function deletefileAttachment($attachmentline_id){
		$sql="SELECT attachmentline_file as fldname from $this->tableattachmentline where attachmentline_id=$attachmentline_id";
		$query=$this->xoopsDB->query($sql);
		$myfilename="";
		if($row=$this->xoopsDB->fetchArray($query)){
			$myfilename=$row['fldname'];
		}
		$myfilename="upload/employee/attachment/$myfilename";
		$this->log->showLog(3,"This file name: $myfilename");
		unlink("$myfilename");
		$sqlupdate="UPDATE $this->tableattachmentline set attachmentline_file='' where attachmentline_id=$attachmentline_id";
		$qryDelete=$this->xoopsDB->query($sqlupdate);
	}

    public function insertPortfolio(){
	//$i = $this->getLatestLine("portfolioline_no");
    $timestamp= date("y/m/d H:i:s", time()) ;


	$sql = "INSERT INTO $this->tableportfolioline
    (portfolioline_datefrom,portfolioline_dateto,employee_id,
    portfolioline_name,portfolioline_remarks,
    created,createdby,updated,updatedby)
    values
    ('$this->portfolioline_datefrom','$this->portfolioline_dateto',$this->employee_id,
    '$this->portfolioline_name','$this->portfolioline_remarks',
    '$timestamp',$this->updatedby,'$timestamp',$this->updatedby)";

    $this->changesql = $sql;

	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update portfolio failed");
		return false;
	}else
    return true;

  }

  public function fetchPortfolio($portfolioline_id){

    $sql = "select * from $this->tableportfolioline where portfolioline_id = $portfolioline_id";

    $query=$this->xoopsDB->query($sql);

    if($row=$this->xoopsDB->fetchArray($query)){
    $this->portfolioline_datefrom = $row['portfolioline_datefrom'];
    $this->portfolioline_dateto = $row['portfolioline_dateto'];
    //$this->portfolioline_type = $row['portfolioline_type'];
    $this->portfolioline_name = $row['portfolioline_name'];
    $this->portfolioline_remarks = $row['portfolioline_remarks'];

    }

  }

  public function updatePortfolio(){
	//$i = $this->getLatestLine("portfolioline_no");

 	$timestamp= date("y/m/d H:i:s", time()) ;


	$sql = "UPDATE $this->tableportfolioline SET
		portfolioline_datefrom = '$this->portfolioline_datefrom',
		portfolioline_dateto = '$this->portfolioline_dateto',
		
		portfolioline_name = '$this->portfolioline_name',
		portfolioline_remarks = '$this->portfolioline_remarks',
        updated='$timestamp',
        updatedby=$this->updatedby
		WHERE portfolioline_id = $this->portfolioline_id";


    $this->changesql = $sql;

	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update portfolio failed");
		return false;
	}else
    return true;

  }

     public function deletePortfolio($line){
	$sql = "DELETE FROM $this->tableportfolioline WHERE portfolioline_id = $line ";


	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update portfolio failed");
		return false;
	}else{
		$this->log->showLog(2, "Update portfolio Successfully");
		return true;
	}

  }

  public function insertAppraisal(){
	//$i = $this->getLatestLine("appraisalline_no");
    $timestamp= date("y/m/d H:i:s", time()) ;


	$sql = "INSERT INTO $this->tableappraisalline
    (appraisalline_date,employee_id,appraisalline_name,
    appraisalline_remarks,appraisalline_result,appraisalline_increment,
    created,createdby,updated,updatedby)
    values
    ('$this->appraisalline_date',$this->employee_id,'$this->appraisalline_name',
    '$this->appraisalline_remarks','$this->appraisalline_result',$this->appraisalline_increment,
    '$timestamp',$this->updatedby,'$timestamp',$this->updatedby)";

    $this->changesql = $sql;

	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update appraisal failed");
		return false;
	}else
    return true;

  }

  public function fetchAppraisal($appraisalline_id){

    $sql = "select * from $this->tableappraisalline where appraisalline_id = $appraisalline_id";

    $query=$this->xoopsDB->query($sql);

    if($row=$this->xoopsDB->fetchArray($query)){
    $this->appraisalline_date = $row['appraisalline_date'];
    $this->appraisalline_name = $row['appraisalline_name'];
    $this->appraisalline_remarks = $row['appraisalline_remarks'];
    $this->appraisalline_result = $row['appraisalline_result'];
    $this->appraisalline_increment = $row['appraisalline_increment'];


    }

  }

  public function updateAppraisal(){
	//$i = $this->getLatestLine("appraisalline_no");

 	$timestamp= date("y/m/d H:i:s", time()) ;


	$sql = "UPDATE $this->tableappraisalline SET
		appraisalline_date = '$this->appraisalline_date',
		appraisalline_name = '$this->appraisalline_name',
		appraisalline_remarks = '$this->appraisalline_remarks',
		appraisalline_result = '$this->appraisalline_result',
		appraisalline_increment = $this->appraisalline_increment,

        updated='$timestamp',
        updatedby=$this->updatedby
		WHERE appraisalline_id = $this->appraisalline_id";


    $this->changesql = $sql;

	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update appraisal failed");
		return false;
	}else
    return true;

  }

     public function deleteAppraisal($line){
	$sql = "DELETE FROM $this->tableappraisalline WHERE appraisalline_id = $line ";


	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update appraisal failed");
		return false;
	}else{
		$this->log->showLog(2, "Update appraisal Successfully");
		return true;
	}

  }

  public function showEmployeeHeader($closetable='Y'){

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
      <td class='odd'><A href="../simbiz/employee.php?action=view&employee_id=$this->employee_id">$this->employee_name</a></td>
    </tr>
    <tr>
      <td class='head'>IC Number</td>
      <td class='even'>$this->employee_newicno</td>
      <td class='head'>HP No/ Tel</td>
      <td class='even'>$this->employee_hpno / $this->employee_telno</td>
    </tr>
  <tr>
      <td class='head'>EPF No</td>
      <td class='even'>$this->employee_epfno</td>
      <td class='head'>Socso No</td>
      <td class='even'>$this->employee_socsono</td>
    </tr>

  <tr>
      <td class='head'>Bank Acc</td>
      <td class='even' colspan="3">$this->employee_accno</td>
    </tr>
EOF;
if($closetable=='Y')
echo "</tbody></table>";

}


} // end of ClassEmployee
?>

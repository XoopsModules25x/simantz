<?php


class Student
{

  public $student_id;
  public $student_name;
  public $student_no;


  public $student_newicno;
  public $student_oldicno;
  public $student_address;
  public $gender;
  public $student_postcode;
  public $student_state;
  public $student_city;
  public $country_id;
  public $student_telno;
  public $student_hpno;
  public $religion_id;
  public $races_id;
  public $uid;
  public $marital_status;
  public $loantype_id;
  public $total_loan;
  public $student_postpone;
  public $filephoto;
  public $fileic;
  public $filespm;
  public $isbumiputerastudent;
  public $spm_year;
  public $spm_school;
  public $year_id;
  public $session_id;
  public $course_id;
  public $isuitmstudent;
  public $student_dob;
  
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
  private $tablestudent;
  private $tablebpartner;

  public $studentfather_name;
  public $studentfather_newic;
  public $studentfather_oldic;
  public $studentfather_address;
  public $studentfather_postcode;
  public $studentfather_state;
  public $studentfather_city;
  public $studentfather_country;
  public $studentfather_telno;
  public $studentfather_hpno;
  public $studentfather_salary;
  public $studentfather_description;
  public $studentmother_name;
  public $studentmother_newic;
  public $studentmother_oldic;
  public $studentmother_address;
  public $studentmother_postcode;
  public $studentmother_state;
  public $studentmother_city;
  public $studentmother_country;
  public $studentmother_telno;
  public $studentmother_hpno;
  public $studentmother_salary;
  public $studentmother_description;
  public $studenthier_name;
  public $studenthier_newic;
  public $studenthier_oldic;
  public $studenthier_address;
  public $studenthier_postcode;
  public $studenthier_state;
  public $studenthier_city;
  public $studenthier_country;
  public $studenthier_telno;
  public $studenthier_hpno;
  public $studenthier_salary;
  public $studenthier_description;


  private $log;


//constructor
   public function Student(){
	global $xoopsDB,$log,$tablestudent,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport;
    global $tablesemester,$tablecourse,$tablesession,$tableyear,$tableraces,$tablereligion,$tableloantype,$tablecountry;
    global $tableusers,$tablestudentspm,$tablestudentloan,$tablestudentdiscipline,$tableclosesession,$tablestudenttype,$tablesubjectspm;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablestudent=$tablestudent;
    $this->tablestudenttype=$tablestudenttype;
    $this->tablesemester=$tablesemester;
    $this->tablecourse=$tablecourse;
	$this->tablebpartner=$tablebpartner;
    $this->tablesession=$tablesession;
    $this->tableyear=$tableyear;
    $this->tableraces=$tableraces;
    $this->tablereligion=$tablereligion;
    $this->tableloantype=$tableloantype;
    $this->tablecountry=$tablecountry;
    $this->tableusers=$tableusers;
    $this->tablestudentspm=$tablestudentspm;
    $this->tablestudentloan=$tablestudentloan;
    $this->tablestudentdiscipline=$tablestudentdiscipline;
    $this->tableclosesession=$tableclosesession;
    $this->tablesubjectspm=$tablesubjectspm;

    
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int student_id
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $student_id,$token  ) {
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
	if ($type=="new") {
            $header="New Student";
            $action="create";
            $styleviewdetails="display:none";

            if($student_id==0) {
                $checkedBumi = "CHECKED";
                $this->ishostel = 1;
                $this->student_name="";
                $this->gender="M";
                $this->marital_status="S";
                $this->isactive="";
                $this->defaultlevel=10;
                $this->total_loan=0;
                $this->student_postpone=0;
                $this->studentfather_salary=0;
                $this->studentmother_salary=0;
                $this->studenthier_salary=0;
                $studentchecked="CHECKED";
                $this->student_no = getNewCode($this->xoopsDB,"student_no",$this->tablestudent,"");

            }
		$savectrl="<input astyle='height: 40px;' name='btnSave' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

	
	}
	else
	{
		
		$action="update";
		$savectrl="<input name='student_id' value='$this->student_id' type='hidden'>".
			 "<input astyle='height: 40px;' name='btnSave' value='Save' type='submit'>";

		$userfieldctrl=" Email: <input name='email' value='$this->email'>
        <Input name='btnResetPassword' value='Reset Password' type='button'
         onclick='resetpassword($this->student_id)'>";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablestudent' type='hidden'>".
		"<input name='id' value='$this->student_id' type='hidden'>".
		"<input name='idname' value='student_id' type='hidden'>".
		"<input name='title' value='Student' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";
		
                //Not work in IE:
                //$ostctrl = "<a href='studentreminder.php?action=showReminder&student_id=$this->student_id'><input type='button' name='Outstandingbtn' value='OutStanding'></a>";
                $ostctrl = "<a href='studentreminder.php?action=showReminder&student_id=$this->student_id'>Outstanding</a>";
		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

                    if ($this->isuitmstudent==1)
                        $checkedUitm="CHECKED";
                    else
                        $checkedUitm="";

                    if ($this->isbumiputerastudent==1)
                        $checkedBumi="CHECKED";
                    else
                        $checkedBumi="";


		$header="Edit Student   ";
		
		if($this->allowDelete($this->student_id))
		$deletectrl="<FORM action='student.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this student?"'.")'><input type='submit' value='Delete Student' name='btnDelete'>".
		"<input type='hidden' value='$this->student_id' name='student_id'>".
                "<input type='hidden' value='$this->student_no' name='student_no'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

        $addnewctrl="<input name='btnNew' value='New' type='button' onclick='gotoNew()'>";
		//$addnewctrl="<Form action='student.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";
	}

/*
    $searchctrl="<Form action='student.php' method='POST'>
                            <input name='btnSearch' value='Search' type='submit'>
                            <input name='action' value='search' type='hidden'>
                            </form>";
 *
 */
    $searchctrl="<input name='btnSearch' value='Search' type='button' onclick='gotoSearch()'>";

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

   

   $photourl="";
   $icurl="";
   $spmurl="";
   if($this->filephoto != "")
   $photourl = "upload/student/$this->filephoto";
   if($this->fileic != "")
   $icurl = "upload/student/$this->fileic";
   if($this->filespm != "")
   $spmurl = "upload/student/$this->filespm";

    $photoalert="";
   if(!file_exists($photourl) || $photourl == ""){
		$photourl="";
        $photoalert = "<font color='red'><b><u>Photo Not Available.</u></b></font>";
   }
        
   if(file_exists($icurl) && $icurl != "")
		$viewic="<a href='$icurl' target='blank'>View IC ($icurl)</a>";
	else
		$viewic = "<b><font color='red'>No Attachment.</font></b>";

    if(file_exists($spmurl) && $spmurl != "")
		$viewspm="<a href='$spmurl' target='blank'>View SPM ($spmurl)</a>";
	else
		$viewspm = "<b><font color='red'>No Attachment.</font></b>";

        if($this->tab_id == "")
        $this->tab_id = 0;
        
        $styletab1 = "style='display:none'";
        $styletab2 = "style='display:none'";
        $styletab3 = "style='display:none'";
        $styletab4 = "style='display:none'";
        $styletblheader = "";
        $view_detailstxt = "View Details >>";
        $student_title = "$this->student_name ($this->student_no) - $this->course_no";
        
        if($this->tab_id == 1){
            $styletab1 = "";
            $styletblheader = "style='display:none'";
            $view_detailstxt = "View Header >>";
        }else if($this->tab_id == 2){
            $styletab2 = "";
            $styletblheader = "style='display:none'";
            $view_detailstxt = "View Header >>";
        }else if($this->tab_id == 3){
            $styletab3 = "";
            $styletblheader = "style='display:none'";
            $view_detailstxt = "View Header >>";
        }else if($this->tab_id == 4){
            $styletab4 = "";
            $styletblheader = "style='display:none'";
            $view_detailstxt = "View Header >>";
        }
         //echo   $styletblheader = "style='display:none'";
         

        $selecthostelY = "";
        $selecthostelN = "";
        if($this->ishostel == 0){
        $styletempaddress = "";
        $selecthostelN = "selected";
        }else{
        $styletempaddress = "style='display:none'";
        $selecthostelY = "selected";
        }

$styleviewdetails = "display:none";
    echo <<< EOF


<form onsubmit="return validateStudent()" method="post"
 action="student.php" name="frmStudent" enctype="multipart/form-data">

<table style="width:100%;">
<tr><td align="left" width="1" nowrap>
<div id="txtViewID">Student Info >> </div>
</td>
<td align="left" nowrap id="idTDStudent">&nbsp;&nbsp;<font style="background-color: #c4d2f1"><a href="../hes/student.php?action=edit&student_id=$this->student_id" target="_blank">$student_title</a></font></td>
</tr>
</table>
<br>

<div  id="idTab1" style="display:none">
EOF;
      $this->viewParentsTable();
echo <<< EOF
</div>

<div  id="idTab2" style="display:none">
EOF;
      $this->viewSPMTable();
echo <<< EOF
</div>

<div  id="idTab3">
EOF;
      $this->viewLoanTable();
echo <<< EOF
</div>

<div  id="idTab4" style="display:none">
EOF;
      $this->viewDisciplineTable();
echo <<< EOF
</div>

<div id="idTblHeader" $styletblheader>
<table style="width:140px;">
<tbody>
<td style="display:none"></td>
<td></td>

<td>


<input type="hidden" name="tab_id" value="$this->tab_id">

<input name="reset" value="Reset" type="reset" style="display:none"></td></tbody></tr></table>

    <input type="hidden" value="Update Semester Student" onclick="action.value='updatestudentsemester'" style="display:none">
  <table style="text-align: left; width: 100%;display:none" border="0" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" acolspan="3">$this->orgctrl&nbsp;Active <input type="checkbox" $checked name="isactive"></td>
			<td class="head" astyle="display:none">Default Level $mandatorysign</td>
	        <td class="even"  astyle="display:none"><input maxlength="3" size="3" name='defaultlevel' value='$this->defaultlevel'>
   	
      </tr>

      <tr>
	  	<td class="head" astyle="display:none">Matrix No $mandatorysign<br><br>
        Student Name $mandatorysign<br><br>
        User Login</td>
        <td class="even" astyle="display:none">
        <input maxlength="10" size="10" name="student_no" value="$this->student_no"><br><br>
        <input maxlength="100" size="50" name="student_name" value="$this->student_name"><br><br>
        $this->uidctrl
       $userfieldctrl
        </td>
        <td class="head" colspan="2" arowspan="2" >

        <table>
        <tr height="100">
        <td style="background-color:gainsboro" align="center">
        <a href="$photourl" target="blank"><img src="$photourl" width="200" height="200"></a>$photoalert</td>
        </tr>
        <tr>
        <td><input type="file" name="filephoto">&nbsp;&nbsp;Remove Photo <input type="checkbox" name="deleteAttachmentPhoto" title="Choose it if you want to remove this Photo">
        <br>(200 x 200 : JPG Format only)
        </td>
        </tr>
        </table>
        
        </td>
      </tr>

      <tr>
        <td class="head">Course</td>
        <td class="even" >$this->coursectrl</td>
	  	<td class="head">Year / Session</td>
        <td class="even">$this->yearctrl $this->sessionctrl</td>
      </tr>

      <tr>
	  	<td class="head">Uitm Student</td>
        <td class="even"><input type="checkbox" $checkedUitm name="isuitmstudent"></td>
        <td class="head">Bumiputera</td>
        <td class="even" ><input type="checkbox" $checkedBumi name="isbumiputerastudent"></td>
      </tr>

      <tr>
	  	<td class="head">New IC No<br><br>Date Of Birth</td>
        <td class="even">
        <input maxlength="20" size="15" name="student_newicno" value="$this->student_newicno"> <font color=red>(Ex: 800130-01-5577)</font><br><br>
        <input name='student_dob' id='student_dob' value="$this->student_dob" maxlength='10' size='10'>
    	<input name='btnDate' value="Date" type="button" onclick="$this->dobdatectrl"> <font color=red>YYYY-MM-DD (Ex: 1980-01-30)</font>
        </td>
        <td class="head">Old IC No</td>
        <td class="even" ><input maxlength="20" size="15" name="student_oldicno" value="$this->student_oldicno"></td>
      </tr>

     <tr>
        <td class="head">Races / Religion / Gender</td>
        <td class="even">
            $this->racesctrl
            $this->religionctrl
            <select name="gender">
            <option value="M" $selectGenderM>Male</option>
            <option value="F" $selectGenderF>Female</option>
            </select>
        </td>
	  	<td class="head">Marital Status</td>
        <td class="even">
            <select name="marital_status">
            <option value="S" $selectMaritalS>Single</option>
            <option value="M" $selectMaritalM>Married</option>
            </select>
        </td>
      </tr>


      <tr >
	  	<td class="head">Stay In Hostel?</td>
        <td class="even" colspan="3" valign="top">
        <select name="ishostel" onchange="viewTempAddress(this.value)">
        <option value=1 $selecthostelY>Hostel</option>
        <option value=0 $selecthostelN>Non Hostel</option>
        </select>
        </td>
      </tr>

      <tr id="idTempAddress" $styletempaddress>
	  	<td class="head">Temporary Address</td>
        <td class="even" colspan="3" valign="top">
        <textarea name="student_tempaddress" cols="40" rows="4">$this->student_tempaddress</textarea>
        </td>
      </tr>

      <tr >
	  	<td class="head">Address</td>
        <td class="even" colspan="3" valign="top">
        <textarea name="student_address" cols="40" rows="4">$this->student_address</textarea>
        </td>
      </tr>

      <tr>
	  	<td class="head">Postcode</td>
        <td class="even"><input maxlength="10" size="8" name="student_postcode" value="$this->student_postcode"></td>
        <td class="head">City</td>
        <td class="even" ><input maxlength="30" size="20" name="student_city" value="$this->student_city"></td>
      </tr>

      <tr>
	  	<td class="head">State</td>
        <td class="even"><input maxlength="20" size="20" name="student_state" value="$this->student_state"></td>
        <td class="head">Country</td>
        <td class="even" >$this->countryctrl</td>
      </tr>

      <tr>
	  	<td class="head">Home Tel No</td>
        <td class="even"><input maxlength="15" size="12" name="student_telno" value="$this->student_telno"></td>
        <td class="head">HP No $mandatorysign</td>
        <td class="even" ><input maxlength="15" size="12" name="student_hpno" value="$this->student_hpno"></td>
      </tr>

      <tr>
	  	<td class="head"><br>IC Attachment<br>( JPG Format only)<br><br>SPM Result Attachment<br>( JPG Format only)</td>
        <td class="even" acolspan="3">
        $viewic<br><input type="file" name="fileic">&nbsp;&nbsp;Remove IC <input type="checkbox" name="deleteAttachmentIc" title="Choose it if you want to remove this IC"><br><br>
         $viewspm<br><input type="file" name="filespm">&nbsp;&nbsp;Remove SPM <input type="checkbox" name="deleteAttachmentSpm" title="Choose it if you want to remove this SPM">
        </td>
        <td class="head">Year Of SPM<br><br>School</td>
        <td class="even" acolspan="3"><input maxlength="4" size="4" name="spm_year" value="$this->spm_year"><br><br>
        <input maxlength="50" size="30" name="spm_school" value="$this->spm_school">
        </td>
      </tr>

      <tr>
        <td class="head">Loan</td>
        <td class="even" >$this->loantypectrl</td>
	  	<td class="head">Total Loan (RM)</td>
        <td class="even"><input maxlength="12" size="10" name="total_loan" value="$this->total_loan"></td>
      </tr>

      <!--<tr>
	  	<td class="head">Year Of SPM<br><br>School</td>
        <td class="even" colspan="3"><input maxlength="4" size="4" name="spm_year" value="$this->spm_year"><br><br>
        <input maxlength="50" size="30" name="spm_school" value="$this->spm_school">
        </td>
      </tr>-->


      <tr>
        <td class="head">Remarks</td>
        <td class="even" colspan='3'><textarea name="description" cols="40" rows="3">$this->description</textarea></td>
      </tr>

      <tr>
        <td class="head">Postpone</td>
        <td class="even" colspan="3">
        <input maxlength="5" size="5" name="student_postpone" value="$this->student_postpone"><br>
        <textarea name="studentpostpone_remarks" cols="40" rows="5">$this->studentpostpone_remarks</textarea>
        </td>
      </tr>

        <tr>
        <th class="head" colspan="4"><input type="checkbox" name="createnewrecord"> Redirect To New Record?</th>
        </tr>


        </tbody>
        </table>
        <br>
        </div>



<table astyle="width:150px;" ><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	<td align="center">$searchctrl</td>
        <td align="center">$ostctrl</td>
	</tbody></table>
  <br>


</form>

<br>
<table style="width:100%;" ><tbody><tr><td align="left">$recordctrl</td><td style="display:none" align="right" id="tdDelete">$deletectrl</td></tr></tbody></table>
<br>


EOF;
  } // end of member function getInputForm

  public function viewParentsTable(){

echo <<< EOF

<!-- Parents Information -->
 <table  border="0" cellpadding="0" cellspacing="1">
        <tr height="35">
        <td colspan="4"><font style="background-color: yellow"><b>Parent Information</b></font>&nbsp;&nbsp;
        <u><a style="cursor:pointer" onclick="viewTabDetails(2)"><b>SPM Result</b></a></u>&nbsp;&nbsp;
        <u><a style="cursor:pointer" onclick="viewTabDetails(3)"><b>Loan Information</b></a></u>&nbsp;&nbsp;
        <u><a style="cursor:pointer" onclick="viewTabDetails(4)"><b>Discipline Information</b></a></u>&nbsp;&nbsp;
        </td>
        </tr>

        <tr>
        <th></th>
        <th align="center">Father's Information</th>
        <th align="center">Mother's Information</th>
        <th align="center">Heir's Information</th>
        </tr>

        <tr>
        <td class="head">Full Name</td>
        <td class="even"><input maxlength="100" size="30" name="studentfather_name" value="$this->studentfather_name"></td>
        <td class="even"><input maxlength="100" size="30" name="studentmother_name" value="$this->studentmother_name"></td>
        <td class="even"><input maxlength="100" size="30" name="studenthier_name" value="$this->studenthier_name"></td>
        </tr>

        <tr>
        <td class="head">New IC No</td>
        <td class="even"><input maxlength="20" size="15" name="studentfather_newic" value="$this->studentfather_newic"></td>
        <td class="even"><input maxlength="20" size="15" name="studentmother_newic" value="$this->studentmother_newic"></td>
        <td class="even"><input maxlength="20" size="15" name="studenthier_newic" value="$this->studenthier_newic"></td>
        </tr>

        <tr>
        <td class="head">Old IC No</td>
        <td class="even"><input maxlength="20" size="15" name="studentfather_oldic" value="$this->studentfather_oldic"></td>
        <td class="even"><input maxlength="20" size="15" name="studentmother_oldic" value="$this->studentmother_oldic"></td>
        <td class="even"><input maxlength="20" size="15" name="studenthier_oldic" value="$this->studenthier_oldic"></td>
        </tr>

        <tr>
        <td class="head">Address</td>
        <td class="even"><textarea name="studentfather_address" rows="3" cols="30">$this->studentfather_address</textarea></td>
        <td class="even"><textarea name="studentmother_address" rows="3" cols="30">$this->studentmother_address</textarea></td>
        <td class="even"><textarea name="studenthier_address" rows="3" cols="30">$this->studenthier_address</textarea></td>
        </tr>

        <tr>
        <td class="head">Postcode</td>
        <td class="even"><input maxlength="10" size="10" name="studentfather_postcode" value="$this->studentfather_postcode"></td>
        <td class="even"><input maxlength="10" size="10" name="studentmother_postcode" value="$this->studentmother_postcode"></td>
        <td class="even"><input maxlength="10" size="10" name="studenthier_postcode" value="$this->studenthier_postcode"></td>
        </tr>

        <tr>
        <td class="head">State</td>
        <td class="even"><input maxlength="20" size="15" name="studentfather_state" value="$this->studentfather_state"></td>
        <td class="even"><input maxlength="20" size="15" name="studentmother_state" value="$this->studentmother_state"></td>
        <td class="even"><input maxlength="20" size="15" name="studenthier_state" value="$this->studenthier_state"></td>
        </tr>

        <tr>
        <td class="head">City</td>
        <td class="even"><input maxlength="30" size="25" name="studentfather_city" value="$this->studentfather_city"></td>
        <td class="even"><input maxlength="30" size="25" name="studentmother_city" value="$this->studentmother_city"></td>
        <td class="even"><input maxlength="30" size="25" name="studenthier_city" value="$this->studenthier_city"></td>
        </tr>

        <tr>
        <td class="head">Country</td>
        <td class="even">$this->countryfatherctrl</td>
        <td class="even">$this->countrymotherctrl</td>
        <td class="even">$this->countryhierctrl</td>
        </tr>

        <tr>
        <td class="head">Tel No</td>
        <td class="even"><input maxlength="15" size="15" name="studentfather_telno" value="$this->studentfather_telno"></td>
        <td class="even"><input maxlength="15" size="15" name="studentmother_telno" value="$this->studentmother_telno"></td>
        <td class="even"><input maxlength="15" size="15" name="studenthier_telno" value="$this->studenthier_telno"></td>
        </tr>

        <tr>
        <td class="head">HP No</td>
        <td class="even"><input maxlength="15" size="15" name="studentfather_hpno" value="$this->studentfather_hpno"></td>
        <td class="even"><input maxlength="15" size="15" name="studentmother_hpno" value="$this->studentmother_hpno"></td>
        <td class="even"><input maxlength="15" size="15" name="studenthier_hpno" value="$this->studenthier_hpno"></td>
        </tr>

        <tr>
        <td class="head">Salary (RM)</td>
        <td class="even"><input maxlength="12" size="12" name="studentfather_salary" value="$this->studentfather_salary"></td>
        <td class="even"><input maxlength="12" size="12" name="studentmother_salary" value="$this->studentmother_salary"></td>
        <td class="even"><input maxlength="12" size="12" name="studenthier_salary" value="$this->studenthier_salary"></td>
        </tr>

        <tr>
        <td class="head">Remarks</td>
        <td class="even"><textarea name="studentfather_description" rows="3" cols="30">$this->studentfather_description</textarea></td>
        <td class="even"><textarea name="studentmother_description" rows="3" cols="30">$this->studentmother_description</textarea></td>
        <td class="even"><textarea name="studenthier_description" rows="3" cols="30">$this->studenthier_description</textarea></td>
        </tr>

        </table>

EOF;
  }

    public function viewSPMTable(){
    global $ctrl;

       $sqlspm = "select sp.*,sv.subjectspm_type from $this->tablestudentspm sp, $this->tablesubjectspm sv
                    where sp.student_id = $this->student_id
                    and sp.subjectspm_id = sv.subjectspm_id
                    order by sv.subjectspm_type,sp.studentspm_id desc";

echo <<< EOF

<!-- SPM Information -->
        <table  border="0" cellpadding="0" cellspacing="1">

        <input type="hidden" name="deletespmline_id" value="0">
        <tr height="35">
        <td colspan="4">
        <u><a style="cursor:pointer" onclick="viewTabDetails(1)"><b>Parent Information</b></a></u>&nbsp;&nbsp;
        <font style="background-color: yellow"><b>SPM Result</b></font>&nbsp;&nbsp;
        <u><a style="cursor:pointer" onclick="viewTabDetails(3)"><b>Loan Information</b></a></u>&nbsp;&nbsp;
        <u><a style="cursor:pointer" onclick="viewTabDetails(4)"><b>Discipline Information</b></a></u>&nbsp;&nbsp;
        </td>
        </tr>

        <tr>
        <td align=left colspan="2">
            <table><tr>
            <td class="vfocus" width="15px"></td>
            <td align=left>(Background Color) Subject or Grade Not Define</td>
            <tr></table>
        </td>
 
        <td colspan="2" align="right">
        Add Line :
        <select name="addLine">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        <input type="button" value="Add" onclick="addSPMLine()">
        </td>
        </tr>

        <tr>
        <td colspan="4">

        <table>
        <tr>
        <th align="center">No</th>
        <th align="center">Type</th>
        <th align="center">Subject</th>
        <th align="center">Grade</th>
        <th align="center">Delete</th>
        </tr>
EOF;

        $this->log->showLog(4,"viewSPMTable With SQL:$sql");
        $queryspm=$this->xoopsDB->query($sqlspm);

        $rowtype="";
        $i=0;
        $line_type = "";
        while ($rowspm=$this->xoopsDB->fetchArray($queryspm)){
        $i++;

        $studentspm_id = $rowspm['studentspm_id'];
        $subjectspm_id = $rowspm['subjectspm_id'];
        $result_name = $rowspm['result_name'];
        $result_type = $rowspm['result_type'];
        $subjectspm_type = $rowspm['subjectspm_type'];
        $gradelevel_id = $rowspm['gradelevel_id'];
        
        $subjectspmctrl=$ctrl->getSelectSubjectspm($subjectspm_id,'Y',"","subjectspm_id[$i]");

        $gradelevelctrl=$ctrl->getSelectGradelevel($gradelevel_id,'Y',"","gradelevel_id[$i]");

        $subjectspm_typename="";
        $selectSPMV = "";
        $selectSPMP = "";
        $selectSPMT = "";
        if($subjectspm_type == "V"){
        $selectSPMV = "selected";
        $subjectspm_typename="SPM/SPMV";
        }else if($subjectspm_type == "P"){
        $selectSPMP = "selected";
        $subjectspm_typename="STPM";
        }else if($subjectspm_type == "T"){
        $selectSPMT = "selected";
        $subjectspm_typename="Diploma";
        }

        


        if($line_type != $subjectspm_type){
        $line_type = $subjectspm_type;

                    if($i>1){
                    echo "<tr><td colspan='5' class='head'></td></tr>";
                    }
        }
       

        if($rowtype == "even")
        $rowtype = "odd";
        else
        $rowtype = "even";

        if($gradelevel_id == 0 || $subjectspm_id == 0)
        $rowtype = "vfocus";
echo <<< EOF

        <input type="hidden" name="studentspm_id[$i]" value="$studentspm_id">
        <tr>
        <td align="center" class="$rowtype">$i</td>
        <td align="center" class="$rowtype">$subjectspm_typename
        <select name="result_type[$i]" style="display:none">
        <option value="V" $selectSPMV>SPM / SPMV</option>
        <option value="P" $selectSPMP>PMR / SRP</option>
        <option value="T" $selectSPMT>STPM</option>
        </select>
        </td>
        <td align="center" class="$rowtype">$subjectspmctrl</td>
        <td align="center" class="$rowtype">$gradelevelctrl<input type="hidden" name="result_name[$i]" value="$result_name" size="4" maxlength="10"></td>
        <td align="center" class="$rowtype"><input type="button" value="Delete" onclick="deleteSPMSubject($studentspm_id)"></td>
        </tr>
EOF;
        }
echo <<< EOF
        </table>

        </td>
        </tr>

        </table>
        

EOF;
  }


      public function viewLoanTable(){
    global $ctrl;

       $styleloan = "";
       $readonlyloan = "";
       
       $sqlloan = "select * from $this->tablestudentloan
                    where student_id = $this->student_id
                    order by semester_id";

          $totalloan_student = number_format($this->total_loan,2);

        $semesterctrl=$ctrl->getSelectSemester(0,"Y","","semester_addline");
echo <<< EOF

<!-- Loan Information -->
        <table  border="0" cellpadding="0" cellspacing="1">

        <input type="hidden" name="deleteloanline_id" value="0">
        <tr height="35">
        <td colspan="4">
        <font style="background-color: yellow"><b>Loan Information</b></font>&nbsp;&nbsp;
        </td>
        </tr>

        <tr>
        <td align=left colspan="2">
            <table><tr>
            <td class="vfocus" width="15px"></td>
            <td align=left>(Background Color) Amount Not Define (Total Loan (RM) : <b>$totalloan_student</b>)</td>
            <tr></table>
        </td>

        <td colspan="2" align="right" $styleloan>
        Semester : $semesterctrl Amount(RM) : <input name="amount_addline" size="10" maxlength="11" value="0.00" onfocus="select();">
        <input type="button" value="Add" onclick="addLoanLine()">
        </td>
        </tr>

        <tr>
        <td colspan="4">

        <table>
        <tr>
        <th align="center">No</th>
        <th align="center">Semester</th>
        <th align="center">Amount</th>
        <th align="center">Remarks</th>
        <th align="center">Delete</th>
        </tr>
EOF;

        $this->log->showLog(4,"viewLoanTable With SQL:$sql");
        $queryloan=$this->xoopsDB->query($sqlloan);

        $total_amt = 0;
        $rowtype="";
        $i=0;
        while ($rowloan=$this->xoopsDB->fetchArray($queryloan)){
        $i++;

        $studentloanline_id = $rowloan['studentloanline_id'];
        $semester_id = $rowloan['semester_id'];
        $line_amt = $rowloan['line_amt'];
        $descriptionline = $rowloan['descriptionline'];

        $total_amt += $line_amt;
        $semesterctrlline=$ctrl->getSelectSemester($semester_id,"N","","semester_id[$i]");

        if($rowtype == "even")
        $rowtype = "odd";
        else
        $rowtype = "even";

        if($line_amt == 0)
        $rowtype = "vfocus";
echo <<< EOF

        <input type="hidden" name="studentloanline_id[$i]" value="$studentloanline_id">
        <tr>
        <td align="center" class="$rowtype">$i</td>
        <td align="center" class="$rowtype">$semesterctrlline</td>
        <td align="center" class="$rowtype"><input $readonlyloan name="line_amt[$i]" value="$line_amt" size="10" maxlength="11" onfocus="select();"></td>
        <td align="center" class="$rowtype"><input $readonlyloan name="descriptionline[$i]" value="$descriptionline" size="20" maxlength="100""></td>
        <td align="center" class="$rowtype"><input $styleloan type="button" value="Delete" onclick="deleteLoanLine($studentloanline_id)"></td>
        </tr>
EOF;
        }

        if($i > 0){
        echo "<tr class='head'><td colspan='2'></td>
        <td align='center'>".number_format($total_amt,2)."</td>
        <td colspan='2'></td>
        </tr>";
        }
echo <<< EOF
        </table>

        </td>
        </tr>

        </table>


EOF;
  }

      public function viewDisciplineTable(){
    global $ctrl;

       $sqldis = "select * from $this->tablestudentdiscipline
                    where student_id = $this->student_id
                    order by studentdiscipline_keydate desc";

echo <<< EOF

<!-- Discipline Information -->
        <table  border="0" cellpadding="0" cellspacing="1">

        <input type="hidden" name="deletedisciplineline_id" value="0">
        <tr height="35">
        <td colspan="4">
        <u><a style="cursor:pointer" onclick="viewTabDetails(1)"><b>Parent Information</b></a></u>&nbsp;&nbsp;
        <u><a style="cursor:pointer" onclick="viewTabDetails(2)"><b>SPM Result</b></a></u></font>&nbsp;&nbsp;
        <u><a style="cursor:pointer" onclick="viewTabDetails(3)"><b>Loan Information</b></a></u>&nbsp;&nbsp;
        <font style="background-color: yellow"><b>Discipline Information</b></font>&nbsp;&nbsp;
        </td>
        </tr>

        <tr>
        <td align=left colspan="2">
            <table><tr>
            <td class="vfocus" width="15px"></td>
            <td align=left>(Background Color) Date Not Define</td>
            <tr></table>
        </td>

        <td colspan="2" align="right">
        Add Line :
        <!--<select name="addLine">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>-->
        <input type="button" value="Add" onclick="addDisciplineLine($this->student_id)">
        </td>
        </tr>

        <tr>
        <td colspan="4">

        <table>
        <tr>
        <th align="center">No</th>
        <th align="center">Date</th>
        <th align="center">Description</th>
        <th align="center">Date (Discipline)</th>
        <th align="center">Place</th>
        <th align="center">Edit</th>
        <th align="center">Preview</th>
        <th align="center">Delete</th>
        </tr>
EOF;

        $this->log->showLog(4,"viewDisciplineTable With SQL:$sqldis");
        $querydis=$this->xoopsDB->query($sqldis);

        $rowtype="";
        $i=0;
        while ($rowdis=$this->xoopsDB->fetchArray($querydis)){
        $i++;

        $studentdisciplineline_id=$rowdis['studentdisciplineline_id'];
        $studentdiscipline_date=substr($rowdis['studentdiscipline_date'],0,10);
        $studentdiscipline_place=$rowdis['studentdiscipline_place'];
        $studentdiscipline_keydate=substr($rowdis['studentdiscipline_keydate'],0,10);
        $witness_name=$rowdis['witness_name'];
        $witness_icno=$rowdis['witness_icno'];
        $descriptionline=$rowdis['descriptionline'];

        $descriptionline = str_replace("\n","<br>",$descriptionline);

        if($rowtype == "even")
        $rowtype = "odd";
        else
        $rowtype = "even";

        if($studentdiscipline_date == "0000-00-00" || $studentdiscipline_keydate == "000-00-00")
        $rowtype = "vfocus";
        
echo <<< EOF

        <input type="hidden" name="studentdisciplineline_id[$i]" value="$studentspm_id">
        <tr>
        <td align="center" class="$rowtype">$i</td>
        <td align="center" class="$rowtype">$studentdiscipline_keydate</td>
        <td align="left" class="$rowtype">
        <a onclick="viewDisciplineDesc($i)" style="cursor:pointer"><div id="txtDiscTxt$i">View Description</div></a>
        <div id="idDisciplineDesc$i" style="display:none">$descriptionline</div></td>
        <td align="center" class="$rowtype">$studentdiscipline_date</td>
        <td align="center" class="$rowtype">$studentdiscipline_place</td>
        <td align="center" class="$rowtype"><input type="button" value="Edit" onclick="editDisciplineLine($studentdisciplineline_id,$this->student_id)"></td>
        <td align="center" class="$rowtype"><input type="button" value="Preview" onclick="previewDisciplineLine($studentdisciplineline_id)"></td>
        <td align="center" class="$rowtype"><input type="button" value="Delete" onclick="deleteDisciplineLine($studentdisciplineline_id)"></td>
        </tr>
EOF;
        }
echo <<< EOF
        </table>

        </td>
        </tr>

        </table>


EOF;
  }

  /**
   * Update existing student record
   *
   * @return bool
   * @access public
   */
  public function updateStudent( ) {
 
	/*
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablestudent SET
	student_name='$this->student_name',
    description='$this->description',
    student_no='$this->student_no',
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',defaultlevel=$this->defaultlevel,
	student_newicno='$this->student_newicno',
	student_oldicno='$this->student_oldicno',
	student_tempaddress='$this->student_tempaddress',
	ishostel=$this->ishostel,
	student_address='$this->student_address',
	gender='$this->gender',
	student_postcode='$this->student_postcode',
	student_state='$this->student_state',
	student_city='$this->student_city',
	country_id=$this->country_id,
	student_telno='$this->student_telno',
	student_hpno='$this->student_hpno',
	religion_id=$this->religion_id,
	races_id=$this->races_id,
	uid=$this->uid,
	marital_status='$this->marital_status',
	loantype_id=$this->loantype_id,
	total_loan=$this->total_loan,
	student_postpone=$this->student_postpone,
    studentpostpone_remarks='$this->studentpostpone_remarks',
	isbumiputerastudent=$this->isbumiputerastudent,
	spm_year='$this->spm_year',
	spm_school='$this->spm_school',
	year_id=$this->year_id,
	session_id=$this->session_id,
	course_id=$this->course_id,
	isuitmstudent=$this->isuitmstudent,
	student_dob='$this->student_dob',
	studentfather_name='$this->studentfather_name',
	studentfather_newic='$this->studentfather_newic',
	studentfather_oldic='$this->studentfather_oldic',
	studentfather_address='$this->studentfather_address',
	studentfather_postcode='$this->studentfather_postcode',
	studentfather_state='$this->studentfather_state',
	studentfather_city='$this->studentfather_city',
	studentfather_country=$this->studentfather_country,
	studentfather_telno='$this->studentfather_telno',
	studentfather_hpno='$this->studentfather_hpno',
	studentfather_salary=$this->studentfather_salary,
	studentfather_description='$this->studentfather_description',
    studentmother_name='$this->studentmother_name',
    studentmother_newic='$this->studentmother_newic',
    studentmother_oldic='$this->studentmother_oldic',
    studentmother_address='$this->studentmother_address',
    studentmother_postcode='$this->studentmother_postcode',
    studentmother_state='$this->studentmother_state',
    studentmother_city='$this->studentmother_city',
    studentmother_country=$this->studentmother_country,
    studentmother_telno='$this->studentmother_telno',
    studentmother_hpno='$this->studentmother_hpno',
    studentmother_salary=$this->studentmother_salary,
    studentmother_description='$this->studentmother_description',
    studenthier_name='$this->studenthier_name',
    studenthier_newic='$this->studenthier_newic',
    studenthier_oldic='$this->studenthier_oldic',
    studenthier_address='$this->studenthier_address',
    studenthier_postcode='$this->studenthier_postcode',
    studenthier_state='$this->studenthier_state',
    studenthier_city='$this->studenthier_city',
    studenthier_country=$this->studenthier_country,
    studenthier_telno='$this->studenthier_telno',
    studenthier_hpno='$this->studenthier_hpno',
    studenthier_salary=$this->studenthier_salary,
    studenthier_description='$this->studenthier_description',

	organization_id=$this->organization_id WHERE student_id='$this->student_id'";
	$this->changesql = $sql;
	$this->log->showLog(3, "Update student_id: $this->student_id, $this->student_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update student failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update student successfully.");
		return true;
	}
*/
	return true;
  } // end of member function updateStudent

  /**
   * Save new student into database
   *
   * @return bool
   * @access public
   */
  public function insertStudent( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new student $this->student_name");
 	$sql="INSERT INTO $this->tablestudent (student_name,student_no,isactive, created,createdby,
	updated,updatedby,defaultlevel,organization_id,description,
    student_newicno,
    student_oldicno,
    ishostel,
    student_tempaddress,
    student_address,
    gender,
    student_postcode,
    student_state,
    student_city,
    country_id,
    student_telno,
    student_hpno,
    religion_id,
    races_id,
    uid,
    marital_status,
    loantype_id,
    total_loan,
    student_postpone,
    isbumiputerastudent,
    spm_year,
    spm_school,
    year_id,
    session_id,
    course_id,
    isuitmstudent,
    student_dob,
    studentfather_name,
    studentfather_newic,
    studentfather_oldic,
    studentfather_address,
    studentfather_postcode,
    studentfather_state,
    studentfather_city,
    studentfather_country,
    studentfather_telno,
    studentfather_hpno,
    studentfather_salary,
    studentfather_description,
studentmother_name,
studentmother_newic,
studentmother_oldic,
studentmother_address,
studentmother_postcode,
studentmother_state,
studentmother_city,
studentmother_country,
studentmother_telno,
studentmother_hpno,
studentmother_salary,
studentmother_description,
studenthier_name,
studenthier_newic,
studenthier_oldic,
studenthier_address,
studenthier_postcode,
studenthier_state,
studenthier_city,
studenthier_country,
studenthier_telno,
studenthier_hpno,
studenthier_salary,
studenthier_description,
studentpostpone_remarks)
    values(
	'$this->student_name','$this->student_no','$this->isactive','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->defaultlevel,$this->organization_id,'$this->description',
    '$this->student_newicno',
    '$this->student_oldicno',
    $this->ishostel,
    '$this->student_tempaddress',
    '$this->student_address',
    '$this->gender',
    '$this->student_postcode',
    '$this->student_state',
    '$this->student_city',
    $this->country_id,
    '$this->student_telno',
    '$this->student_hpno',
    $this->religion_id,
    $this->races_id,
    $this->uid,
    '$this->marital_status',
    $this->loantype_id,
    $this->total_loan,
    $this->student_postpone,
    $this->isbumiputerastudent,
    '$this->spm_year',
    '$this->spm_school',
    $this->year_id,
    $this->session_id,
    $this->course_id,
    $this->isuitmstudent,
    '$this->student_dob',
    '$this->studentfather_name',
    '$this->studentfather_newic',
    '$this->studentfather_oldic',
    '$this->studentfather_address',
    '$this->studentfather_postcode',
    '$this->studentfather_state',
    '$this->studentfather_city',
    $this->studentfather_country,
    '$this->studentfather_telno',
    '$this->studentfather_hpno',
    $this->studentfather_salary,
    '$this->studentfather_description',
    '$this->studentmother_name',
    '$this->studentmother_newic',
    '$this->studentmother_oldic',
    '$this->studentmother_address',
    '$this->studentmother_postcode',
    '$this->studentmother_state',
    '$this->studentmother_city',
    $this->studentmother_country,
    '$this->studentmother_telno',
    '$this->studentmother_hpno',
    $this->studentmother_salary,
    '$this->studentmother_description',
    '$this->studenthier_name',
    '$this->studenthier_newic',
    '$this->studenthier_oldic',
    '$this->studenthier_address',
    '$this->studenthier_postcode',
    '$this->studenthier_state',
    '$this->studenthier_city',
    $this->studenthier_country,
    '$this->studenthier_telno',
    '$this->studenthier_hpno',
    $this->studenthier_salary,
    '$this->studenthier_description',
    '$this->studentpostpone_remarks')";
$this->changesql = $sql;
	$this->log->showLog(4,"Before insert student SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert student code $student_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new student $student_name successfully");
		return true;
	}
  } // end of member function insertStudent

  /**
   * Pull data from student table into class
   *
   * @return bool
   * @access public
   */
  public function fetchStudent( $student_id) {


	$this->log->showLog(3,"Fetching student detail into class Student.php.<br>");
		
	$sql="SELECT s.*,u.email,cr.course_name,cr.course_no
		 from $this->tablestudent s 
        left join $this->tableusers u on s.uid=u.uid
	inner join $this->tablecourse cr on cr.course_id = s.course_id
        where s.student_id=$student_id";
	
	$this->log->showLog(4,"ProductStudent->fetchStudent, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->student_name=$row["student_name"];
		$this->student_no=$row["student_no"];
		$this->organization_id=$row['organization_id'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->isactive=$row['isactive'];
        $this->email=$row['email'];
		$this->description=$row['description'];
		$this->student_newicno=$row['student_newicno'];
		$this->student_oldicno=$row['student_oldicno'];
        $this->ishostel=$row['ishostel'];
        $this->student_tempaddress=$row['student_tempaddress'];
		$this->student_address=$row['student_address'];
		$this->gender=$row['gender'];
		$this->student_postcode=$row['student_postcode'];
		$this->student_state=$row['student_state'];
		$this->student_city=$row['student_city'];
		$this->country_id=$row['country_id'];
		$this->student_telno=$row['student_telno'];
		$this->student_hpno=$row['student_hpno'];
		$this->religion_id=$row['religion_id'];
		$this->races_id=$row['races_id'];
		$this->uid=$row['uid'];
		$this->marital_status=$row['marital_status'];
		$this->loantype_id=$row['loantype_id'];
		$this->total_loan=$row['total_loan'];
		$this->student_postpone=$row['student_postpone'];
        $this->studentpostpone_remarks=$row['studentpostpone_remarks'];
        
		$this->filephoto=$row['filephoto'];
		$this->fileic=$row['fileic'];
		$this->filespm=$row['filespm'];
		$this->isbumiputerastudent=$row['isbumiputerastudent'];
		$this->spm_year=$row['spm_year'];
		$this->spm_school=$row['spm_school'];
		$this->year_id=$row['year_id'];
		$this->session_id=$row['session_id'];
		$this->course_id=$row['course_id'];
		$this->isuitmstudent=$row['isuitmstudent'];
		$this->student_dob=$row['student_dob'];

		$this->studentfather_name=$row['studentfather_name'];
		$this->studentfather_newic=$row['studentfather_newic'];
		$this->studentfather_oldic=$row['studentfather_oldic'];
		$this->studentfather_address=$row['studentfather_address'];
		$this->studentfather_postcode=$row['studentfather_postcode'];
		$this->studentfather_state=$row['studentfather_state'];
		$this->studentfather_city=$row['studentfather_city'];
		$this->studentfather_country=$row['studentfather_country'];
		$this->studentfather_telno=$row['studentfather_telno'];
		$this->studentfather_hpno=$row['studentfather_hpno'];
		$this->studentfather_salary=$row['studentfather_salary'];
		$this->studentfather_description=$row['studentfather_description'];
		$this->studentmother_name=$row['studentmother_name'];
		$this->studentmother_newic=$row['studentmother_newic'];
		$this->studentmother_oldic=$row['studentmother_oldic'];
		$this->studentmother_address=$row['studentmother_address'];
		$this->studentmother_postcode=$row['studentmother_postcode'];
		$this->studentmother_state=$row['studentmother_state'];
		$this->studentmother_city=$row['studentmother_city'];
		$this->studentmother_country=$row['studentmother_country'];
		$this->studentmother_telno=$row['studentmother_telno'];
		$this->studentmother_hpno=$row['studentmother_hpno'];
		$this->studentmother_salary=$row['studentmother_salary'];
		$this->studentmother_description=$row['studentmother_description'];
		$this->studenthier_name=$row['studenthier_name'];
		$this->studenthier_newic=$row['studenthier_newic'];
		$this->studenthier_oldic=$row['studenthier_oldic'];
		$this->studenthier_address=$row['studenthier_address'];
		$this->studenthier_postcode=$row['studenthier_postcode'];
		$this->studenthier_state=$row['studenthier_state'];
		$this->studenthier_city=$row['studenthier_city'];
		$this->studenthier_country=$row['studenthier_country'];
		$this->studenthier_telno=$row['studenthier_telno'];
		$this->studenthier_hpno=$row['studenthier_hpno'];
		$this->studenthier_salary=$row['studenthier_salary'];
		$this->studenthier_description=$row['studenthier_description'];

		$this->course_name=$row['course_name'];
		$this->course_no=$row['course_no'];


   	$this->log->showLog(4,"Student->fetchStudent,database fetch into class successfully");
	$this->log->showLog(4,"student_name:$this->student_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Student->fetchStudent,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchStudent

  /**
   * Delete particular student id
   *
   * @param int student_id
   * @return bool
   * @access public
   */
  public function deleteStudent($student_id,$student_no) {
    	$this->log->showLog(2,"Warning: Performing delete student id : $student_id !");
	$sql="DELETE FROM $this->tablestudent where student_id=$student_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->changesql = $sql;
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: student ($student_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{

                $sqluserlogin = "delete from $this->tableusers where uname = '$student_no' ";

                $rsuserlogin=$this->xoopsDB->query($sqluserlogin);

                if (!$rsuserlogin){
                $this->log->showLog(1,"Error: student ($student_no) cannot remove table_user from database:" . mysql_error(). ":$sql");
                }
                
		$this->log->showLog(3,"student ($student_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteStudent

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllStudent( $wherestring,  $orderbystring,$limitstr="") {
  $this->log->showLog(4,"Running ProductStudent->getSQLStr_AllStudent: $sql");

    $wherestring .= " and a.course_id = b.course_id and a.year_id = c.year_id and a.session_id = d.session_id and a.races_id = e.races_id and a.religion_id = f.religion_id and a.country_id = g.country_id and a.loantype_id = h.loantype_id ";
    $sql="SELECT a.*,b.course_no,b.course_name,c.year_name,d.session_name,e.races_name,f.religion_name,g.country_name,h.loantype_name
                FROM $this->tablestudent a, $this->tablecourse b, $this->tableyear c, 
                $this->tablesession d, $this->tableraces e, $this->tablereligion f, $this->tablecountry g,
                $this->tableloantype h " .
	" $wherestring $orderbystring $limitstr";
    $this->log->showLog(4,"Generate showstudenttable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllStudent

 public function showStudentTable($wherestring,$orderbystring,$limitstr=""){
	
	$this->log->showLog(3,"Showing Student Table");
	$sql=$this->getSQLStr_AllStudent($wherestring,$orderbystring,$limitstr);
	
	$query=$this->xoopsDB->query($sql);

   
    if($limitstr!=""){
    $records = str_replace("limit","",$limitstr);
    $limitdisplay=" Show Only $records Record(s)";
    }

    $stylepassword = "style='display:none'";
    if($this->showtempcoloumn == "on")
    $stylepassword = "";
    
	echo <<< EOF
    <script type='text/javascript'>
        function validate(){
            var action=document.frmListTable.action.value;
            var confirmtext="";
            if(action=='sendsms')
                confirmtext=prompt("Confirm send SMS? It will charge RM0.15 per message","No");
            else if(action=='sendemail')
                confirmtext=prompt("Confirm send out this email?","No");
             if(confirmtext=='Yes')
                return true;
             else
                return false;
        }
    </script>
    <form name="frmListTable" action="student.php" method="POST" atarget="_blank" onsubmit='return validate()'>
    <input type="hidden" name="action" value="generateletter">
	<table border='0' cellspacing='3'>
  		<tbody>
<b>$limitdisplay</b>
                <tr>
                <th style="text-align:center;"></th>
                <th style="text-align:center;">No</th>
                <th style="text-align:center;">Matrix no</th>
                <th style="text-align:center;">Name</th>
                <th style="text-align:center;">Course</th>
                <th style="text-align:center;">Year/Session</th>
                <th style="text-align:center;">IC No</th>
                <th style="text-align:center;">Races</th>
                <th style="text-align:center;">Gender</th>
                <th style="text-align:center;">HP No</th>
                <th style="text-align:center;">Loan</th>
                <th style="text-align:center;">Active</th>
                <th $stylepassword align="center">Temp Password</th>
                <th style="text-align:center;display:none">Default Level</th>
                <th style="text-align:center;">Operation</th>
                </tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$student_id=$row['student_id'];
		$student_name=$row['student_name'];
		$student_no=$row['student_no'];
        $student_newicno=$row['student_newicno'];
		$student_oldicno=$row['student_oldicno'];
		$student_address=$row['student_address'];
		$gender=$row['gender'];
		$student_postcode=$row['student_postcode'];
		$student_state=$row['student_state'];
		$student_city=$row['student_city'];
		$country_id=$row['country_id'];
		$student_telno=$row['student_telno'];
		$student_hpno=$row['student_hpno'];
		$religion_id=$row['religion_id'];
		$races_name=$row['races_name'];
		$marital_status=$row['marital_status'];
		$loantype_name=$row['loantype_name'];
		$total_loan=$row['total_loan'];
        $student_postpone=$row['student_postpone'];
		$filephoto=$row['filephoto'];
		$fileic=$row['fileic'];
		$filespm=$row['filespm'];
		$isbumiputerastudent=$row['isbumiputerastudent'];
		$spm_year=$row['spm_year'];
		$spm_school=$row['spm_school'];
		$year_name=$row['year_name'];
		$session_name=$row['session_name'];
		$course_no=$row['course_no'];
		$isuitmstudent=$row['isuitmstudent'];
		$student_dob=$row['student_dob'];

		$defaultlevel=$row['defaultlevel'];
                $temp_password=$row['temp_password'];

		$isactive=$row['isactive'];
		
		if($isactive==0)
		{$isactive='N';
		$isactive="<b style='color:red;'>N</b>";
		}
		else
		$isactive='Y';

       
   if($student_category=="S")
   $student_category = "Student";
   else
    $student_category = "Co Curriculum";


		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

            
		echo <<< EOF

            <input type="hidden" name="studentarr_id[$i]" value="$student_id">
		<tr>
            <td class="$rowtype" align="center"><input type="checkbox" name="isselected[$i]"></td>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$student_no</td>
			<td class="$rowtype" style="text-align:left;"><a href="student.php?action=edit&student_id=$student_id">$student_name</a></td>
			<td class="$rowtype" style="text-align:center;">$course_no</td>
            <td class="$rowtype" style="text-align:center;">$year_name / $session_name</td>
            <td class="$rowtype" style="text-align:center;">$student_newicno</td>
            <td class="$rowtype" style="text-align:center;">$races_name</td>
            <td class="$rowtype" style="text-align:center;">$gender</td>
            <td class="$rowtype" style="text-align:center;">$student_hpno</td>
            <td class="$rowtype" style="text-align:center;">$loantype_name</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" $stylepassword>$temp_password</td>

			<td class="$rowtype" style="text-align:center;display:none">$defaultlevel</td>
			<td class="$rowtype" style="text-align:center;">
				<a href="student.php?action=edit&student_id=$student_id">
				<img  src="images/edit.gif" title='Edit this student'>
				</a>
			</td>

		</tr>
EOF;
	}

    $sql = str_replace("'","#",$sql);
    //$sql = str_replace("\","$",$sql);


        if($i > 0){
echo <<< EOF
    <tr height="40">
    <td colspan="13"><img src="images/arrowsel.png">
    <a style="cursor:pointer" onclick="selectAll(true);">Check All</a> /
    <a style="cursor:pointer" onclick="selectAll(false);">Uncheck All</a>

    <i>(Generate Letter for selected line)</i></td>
    </tr>

    <tr height="40">
    <td colspan="13">
    <input type="button" value="Generate Letter" onclick="action.value='generateletter';generateLetter('generateletter')">
    </td>

    </tr><tr>
     <td colspan="13" align="left">
           Title (Email Only) <br/><Input name='emailtitle' value='' size='30'/><br/>
           Body <br/><textarea cols='70' rows='4' name='msg' onkeyup="textlength.value=this.value.length"></textarea>
            <input name="textlength" value="0" size='4'>(1 SMS 160 character)
        </td>
        </tr>
        <tr><td colspan='5'>
            <input type="submit" value="Send SMS" onclick="action.value='sendsms'">
            <input type="submit" value="Send Email" onclick="action.value='sendemail'">
        </form>
        </td>
    </tr>

EOF;
    }

echo <<< EOF
   <tr>
    <td colspan="13" align="right">
    <form action="studentsummaryreport.php" method="POST" target="blank">
    <textarea name="sqlpost" style="display:none">$sql</textarea>
    <input type="submit" value="View List">
    </form>
    </td>
     <td>
    
     </td></tr>
    
	</tbody></table>
EOF;
 }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestStudentID() {
	$sql="SELECT MAX(student_id) as student_id from $this->tablestudent;";
	$this->log->showLog(3,'Checking latest created student_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created student_id:' . $row['student_id']);
		return $row['student_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablestudent;";
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

 public function allowDelete($student_id){
	
	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where student_id = $student_id or last_student = $student_id or next_student = $student_id ";
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
	$this->student_no = "";
	$this->isactive = "null";
	$this->gender = "";
    $this->marital_status = "";
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

	//echo $this->iscomplete;

echo <<< EOF
<form name="frmStudent" action="student.php" method="POST">
	</form>
	<form name="frmSearch" action="student.php" method="POST">

	<table>
	<tr>
	<td nowrap><input value="Reset" type="reset">
	<input value="New" type="button" onclick="gotoAction('');" style="display:none"></td>
	</tr>
	</table>

	<table border="0">
	<input name="issearch" value="Y" type="hidden">
	<input name="action" value="search" type="hidden">
	<tr><th colspan="4">Criterial</th></tr>

	<tr>
	<td class="head">Matrix No</td>
	<td class="even"><input name="student_no" value="$this->student_no"></td>
	<td class="head">Student Name</td>
	<td class="even"><input name="student_name" value="$this->student_name"></td>
	</tr>

    <tr>
	<td class="head">New IC No</td>
	<td class="even"><input name="student_newicno" value="$this->student_newicno"></td>
    <td class="head">Loan</td>
	<td class="even">$this->loantypectrl</td>
	</tr>

    <tr>
	<td class="head">Course</td>
	<td class="even">$this->coursectrl</td>
    <td class="head">Year / Session</td>
	<td class="even">$this->yearctrl $this->sessionctrl</td>
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
EOF;
        if($this->isAdmin){
echo <<< EOF
        <tr style="display:none">
	<td class="head">Show Temporary Password</td>
	<td class="even" colspan="3"><input type="checkbox" name="showtempcoloumn"></td>
        </tr>
EOF;
     }
echo <<< EOF
	<tr>
	<th colspan="4"><input type="submit" aonclick="gotoAction('search');" value="Search" ></th>
	</tr>

	</table>
	</form>
	<br>
EOF;
  }

	public function getWhereStr(){

	$wherestr = "";

	if($this->student_no != "")
	$wherestr .= " and a.student_no like '$this->student_no' ";
    if($this->student_name != "")
	$wherestr .= " and a.student_name like '$this->student_name' ";
    if($this->student_newicno != "")
	$wherestr .= " and a.student_newicno like '$this->student_newicno' ";
    if($this->loantype_id > 0)
	$wherestr .= " and a.loantype_id = $this->loantype_id ";
	if($this->course_id > 0)
	$wherestr .= " and a.course_id = $this->course_id ";
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
    
	if($this->isactive == "0" || $this->isactive == "1")
	$wherestr .= " and a.isactive = $this->isactive ";

	return $wherestr;

	}

    public function savefile($tmpfile,$newfilename,$student_id,$fieldname){

		if(move_uploaded_file($tmpfile, "upload/student/$newfilename")){
		$sqlupdate="UPDATE $this->tablestudent set $fieldname='$newfilename' where student_id=$student_id";
		$qryUpdate=$this->xoopsDB->query($sqlupdate);
		}else{
		echo "Cannot Upload File";
		}
	}

	public function deletefile($student_id,$fieldname){
		$sql="SELECT $fieldname as fldname from $this->tablestudent where student_id=$student_id";
		$query=$this->xoopsDB->query($sql);
		$myfilename="";
		if($row=$this->xoopsDB->fetchArray($query)){
			$myfilename=$row['fldname'];
		}
		$myfilename="upload/student/$myfilename";
		$this->log->showLog(3,"This file name: $myfilename");
		unlink("$myfilename");
		$sqlupdate="UPDATE $this->tablestudent set $fieldname='' where student_id=$student_id";
		$qryDelete=$this->xoopsDB->query($sqlupdate);
	}

    public function deletefile2($filename){
		unlink("upload/student/$filename");
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

    public function addSPMLine($add_line){
        $timestamp= date("y/m/d H:i:s", time()) ;

        $this->changesql = "";
        $i=0;
        while($i < $add_line){
        $i++;

        $sql = "insert into $this->tablestudentspm
                    (student_id,created,createdby,updated,updatedby)
                    values
                    ($this->student_id,'$timestamp',$this->updatedby,'$timestamp',$this->updatedby);";

        $this->changesql .= $sql;
        $this->log->showLog(4,"addSPMLine With SQL:$sql");
        $query=$this->xoopsDB->query($sql);

        if(!$query){
            return false;
        }

        }

        return true;
    }

        public function addLoanLine(){
        $timestamp= date("y/m/d H:i:s", time()) ;


        $sql = "insert into $this->tablestudentloan
                    (student_id,semester_id,line_amt,created,createdby,updated,updatedby)
                    values
                    ($this->student_id,$this->semester_addline,$this->amount_addline,'$timestamp',$this->updatedby,'$timestamp',$this->updatedby);";

        $this->changesql = $sql;
        $this->log->showLog(4,"addLoanLine With SQL:$sql");
        $query=$this->xoopsDB->query($sql);

        if(!$query){
            return false;
        }else
            return true;
    }

    public function updateSPMResult(){
        $timestamp= date("y/m/d H:i:s", time()) ;

        $this->changesql = "";
        $i=0;
        foreach($this->studentspm_id as $id){
        $i++;

            $subjectspmid = $this->subjectspm_id[$i];
            $resultname = $this->result_name[$i];
            $resulttype = $this->result_type[$i];
            $gradelevel_id = $this->gradelevel_id[$i];
            
            $sql = "update $this->tablestudentspm set
                        subjectspm_id = $subjectspmid,
                        result_name = '$resultname',
                        result_type = '$resulttype',
                        gradelevel_id = $gradelevel_id,
                        updated ='$timestamp',
                        updatedby = $this->updatedby
                        where studentspm_id = $id; ";
            
            $this->changesql .= $sql;
            $this->log->showLog(4,"updateSPMResult With SQL:$sql");
            
            $query=$this->xoopsDB->query($sql);

            if(!$query){
            return false;
            }

            }

            return true;

    }

        public function deleteSPMLine($studentspm_id){
        $timestamp= date("y/m/d H:i:s", time()) ;

   

        $sql = "delete from $this->tablestudentspm
                    where studentspm_id = $studentspm_id ";

        $this->changesql = $sql;
        $this->log->showLog(4,"deleteSPMLine With SQL:$sql");
        $query=$this->xoopsDB->query($sql);

        if(!$query){
            return false;
        }else
            return true;
    }

        public function updateLoan(){
        $timestamp= date("y/m/d H:i:s", time()) ;

        $this->changesql = "";
        $i=0;
        foreach($this->studentloanline_id as $id){
        $i++;

        $semesterid=$this->semester_id[$i];
        $lineamt=$this->line_amt[$i];
        $descriptionlines=$this->descriptionline[$i];

            $sql = "update $this->tablestudentloan set
                        semester_id = $semesterid,
                        line_amt = $lineamt,
                        descriptionline = '$descriptionlines',
                        updated ='$timestamp',
                        updatedby = $this->updatedby
                        where studentloanline_id = $id; ";

            $this->changesql .= $sql;
            $this->log->showLog(4,"updateLoan With SQL:$sql");

            $query=$this->xoopsDB->query($sql);

            if(!$query){
            return false;
            }

            }

            return true;

    }

    public function showDisciplineLine($token,$action){
        $timestamp= date("Y-m-d", time()) ;

        $studentdiscipline_date=$timestamp;
        $studentdiscipline_place="";
        $studentdiscipline_keydate=$timestamp;
        $witness_name="";
        $witness_icno="";
        $descriptionline="";
        $updateaction = "creatediscipline";
        
        if($action == "editdiscipline"){
            $updateaction = "updatediscipline";
            $sql = "select * from $this->tablestudentdiscipline
                        where studentdisciplineline_id = $this->studentdisciplineline_id";

            $query=$this->xoopsDB->query($sql);

            while ($row=$this->xoopsDB->fetchArray($query)){

                $studentdiscipline_date=substr($row['studentdiscipline_date'],0,10);
                $studentdiscipline_place=$row['studentdiscipline_place'];
                $studentdiscipline_keydate=substr($row['studentdiscipline_keydate'],0,10);
                $witness_name=$row['witness_name'];
                $witness_icno=$row['witness_icno'];
                $descriptionline=$row['descriptionline'];

            }

        }

echo <<< EOF
        <form action="student.php" method="POST" name="frmDiscipline" onsubmit="return checkFormDiscipline()">
        <input type="hidden" name="studentdisciplineline_id" value="$this->studentdisciplineline_id">
        <input type="hidden" name="action" value="$updateaction">
        <input type="hidden" name="token" value="$token">
        <input type="hidden" name="student_id" value="$this->student_id">

        <table>

        <tr>
        <td><input type="button" value="Back To Student Profile" onclick="backToStudentProfile($this->student_id)"></td>
        </tr>

        <tr>
        <th colspan="4">New Discipline</th>
        </tr>

        <tr>
        <td class="head">Date</td>
        <td class="even" colspan="3">
        <input name='studentdiscipline_keydate' id='studentdiscipline_keydate' value="$studentdiscipline_keydate" maxlength='10' size='10'>
    	<input name='btnDate' value="Date" type="button" onclick="$this->studentdiscipline_keydatectrl"> <font color=red>YYYY-MM-DD </font>
        </td>
        </tr>

        <tr>
        <td class="head">Description</td>
        <td class="even" colspan="3"><textarea name="descriptionline" cols="60" rows="8">$descriptionline</textarea></td>
        </tr>

        <tr>
        <td class="head">On</td>
        <td class="even">
        <input name='studentdiscipline_date' id='studentdiscipline_date' value="$studentdiscipline_date" maxlength='10' size='10'>
    	<input name='btnDate' value="Date" type="button" onclick="$this->studentdiscipline_datectrl"> <font color=red>YYYY-MM-DD </font>
        </td>
        <td class="head">At</td>
        <td class="even"><input name='studentdiscipline_place' value="$studentdiscipline_place" maxlength='100' size='35'>
        </td>
        </tr>

        <tr>
        <td class="head">Witness Name</td>
        <td class="even"><input name='witness_name' value="$witness_name" maxlength='100' size='35'></td>
        <td class="head">Witness IC No</td>
        <td class="even"><input name='witness_icno' value="$witness_icno" maxlength='20' size='15'>
        </td>
        </tr>

        <tr>
        <td colspan="4"><input type="submit" value="Save"><td>
        </tr>

        </table>
        </form>
EOF;

    }

public function addDisciplineLine(){
        $timestamp= date("y/m/d H:i:s", time()) ;


        $sql = "insert into $this->tablestudentdiscipline
                    (student_id,studentdiscipline_date,studentdiscipline_place,
                    studentdiscipline_keydate,witness_name,witness_icno,descriptionline,
                    created,createdby,updated,updatedby)
                    values
                    ($this->student_id,'$this->studentdiscipline_date','$this->studentdiscipline_place',
                    '$this->studentdiscipline_keydate','$this->witness_name','$this->witness_icno','$this->descriptionline',
                    '$timestamp',$this->updatedby,'$timestamp',$this->updatedby);";

        $this->changesql = $sql;
        $this->log->showLog(4,"addDisciplineLine With SQL:$sql");
        $query=$this->xoopsDB->query($sql);

        if(!$query){
            return false;
        }else
            return true;
    }

    public function deleteLoanLine($deleteloanline_id){
        $timestamp= date("y/m/d H:i:s", time()) ;



        $sql = "delete from $this->tablestudentloan
                    where studentloanline_id = $deleteloanline_id ";

        $this->changesql = $sql;
        $this->log->showLog(4,"deleteLoanLine With SQL:$sql");
        $query=$this->xoopsDB->query($sql);

        if(!$query){
            return false;
        }else
            return true;
    }

public function deleteDisciplineLine($deletedisciplineline_id){
        $timestamp= date("y/m/d H:i:s", time()) ;



        $sql = "delete from $this->tablestudentdiscipline
                    where studentdisciplineline_id = $deletedisciplineline_id ";

        $this->changesql = $sql;
        $this->log->showLog(4,"deleteDisciplineLine With SQL:$sql");
        $query=$this->xoopsDB->query($sql);

        if(!$query){
            return false;
        }else
            return true;
    }


    public function updateDisciplineLine($studentdisciplineline_id){
        $timestamp= date("y/m/d H:i:s", time()) ;


            $sql = "update $this->tablestudentdiscipline set

                    studentdiscipline_date='$this->studentdiscipline_date',
                    studentdiscipline_place='$this->studentdiscipline_place',
                    studentdiscipline_keydate='$this->studentdiscipline_keydate',
                    witness_name='$this->witness_name',
                    witness_icno='$this->witness_icno',
                    descriptionline='$this->descriptionline',
                    updated ='$timestamp',
                    updatedby = $this->updatedby
                    where studentdisciplineline_id = $studentdisciplineline_id ";

            $this->changesql = $sql;
            $this->log->showLog(4,"updateSPMResult With SQL:$sql");

            $query=$this->xoopsDB->query($sql);

            if(!$query){
            return false;
            }else
            return true;

    }

    public function generateLetter(){


echo <<< EOF
        <form name="frmShowLetter" action="viewstudentletter.php" target="_blank" method="POST" onsubmit="return checkSelectedTemplate()">
        <input type="hidden" name="action" value="printpreview">
        <table>

        <tr>
        <th align="center">No</th>
        <th align="center">Matrix No.</th>
        <th align="center">Name</th>
        <th align="center">Session</th>
        <th align="center">Course</th>
        </tr>
EOF;

        $i=0;
        $j=0;
        $rowtype = "";
        foreach($this->studentarr_id as $student_id){
        $i++;

            if($this->isselected[$i] == "on"){
            $j++;
            $sql = "select st.student_name,st.student_no,cr.course_name,cr.course_no,
                        ss.session_name,yr.year_name
                        from $this->tablestudent st, $this->tablecourse cr, $this->tablesession ss,
                        $this->tableyear yr 
                        where st.course_id = cr.course_id
                        and st.session_id = ss.session_id
                        and st.year_id = yr.year_id
                        and st.student_id = $student_id ";

            $query=$this->xoopsDB->query($sql);

            if ($row=$this->xoopsDB->fetchArray($query)){
            $student_name = $row['student_name'];
            $student_no = $row['student_no'];
            $course_name = $row['course_name'];
            $course_no = $row['course_no'];
            $session_name = $row['session_name'];
            $year_name = $row['year_name'];

            if($rowtype == "even")
            $rowtype = "odd";
            else
            $rowtype = "even";
echo <<< EOF
            <input type="hidden" name="studentarr_id[$j]" value="$student_id">
            <tr>
            <td align="center" class="$rowtype">$j</td>
            <td align="center" class="$rowtype">$student_no</td>
            <td align="left" class="$rowtype">$student_name</td>
            <td align="left" class="$rowtype">$course_name ($course_no)</td>
            <td align="center" class="$rowtype">$year_name / $session_name</td>
            </tr>
EOF;
                
            }
        }
        }

        if($j > 0){
echo <<< EOF

        <tr height="35">
        <td colspan="5"></td>
        </tr>

        <tr>
        <td colspan="5"><b>Please Select Template</b> : $this->studentletterctrl &nbsp;&nbsp;<input type="submit" value="Print Preview"></td>
        </tr>

        <tr height="35">
        <td colspan="5"></td>
        </tr>

        </table></form>
EOF;
        }
        
    }

    public function  lastSemesterBalance($student_id){
        $retval = "0.00";

        $sql = "select lastsemesterbalance from $this->tablestudent where student_id = $student_id ";
        
        $query=$this->xoopsDB->query($sql);

        if ($row=$this->xoopsDB->fetchArray($query)){

            if($row['lastsemesterbalance'] >0)
            $retval = $row['lastsemesterbalance'];
        }
        return $retval;
    }

    public function currentSemesterBalance($student_id){
        $retval = "0.00";

        $sql = "select currentsemesterbalance from $this->tablestudent where student_id = $student_id ";

        $query=$this->xoopsDB->query($sql);

        if ($row=$this->xoopsDB->fetchArray($query)){

        if($row['currentsemesterbalance'] >0)
        $retval = $row['currentsemesterbalance'];
        }
        return $retval;
    }


    public function getEmail(){
        $i=0;
        $j=0;
        $result="";
        $this->log->showLog(3,"call GetEmail");
        foreach($this->studentarr_id as $student_id){
        $i++;
          
            if($this->isselected[$i] == "on"){
            $j++;
            $sql = "select st.student_name,st.student_no,u.email
                        from $this->tablestudent st, $this->tableusers u
                        where st.uid = u.uid AND st.student_id = $student_id ";

            $query=$this->xoopsDB->query($sql);

            if ($row=$this->xoopsDB->fetchArray($query)){
            $student_name = $row['student_name'];
            $student_no = $row['student_no'];
             $email = $row['email'];
                if($email!="")
                    $result.=$email.",";
            }
        }
        }
        $result=substr_replace($result,"",-1);
        return $result;
    }
    public function getNumber(){
          $i=0;
        $j=0;
        $result="";
        $this->log->showLog(3,"call getNumber");
        foreach($this->studentarr_id as $student_id){
        $i++;
          
            if($this->isselected[$i] == "on"){
            $j++;
            $sql = "select student_hpno
                        from $this->tablestudent where student_id = $student_id ";

            $query=$this->xoopsDB->query($sql);

            if ($row=$this->xoopsDB->fetchArray($query)){
            $student_name = $row['student_name'];
            $student_no = $row['student_no'];
             $student_hpno = $row['student_hpno'];
                if($student_hpno!="")
                    $result.=$student_hpno."@";
            }
        }
        }
        $result=substr_replace($result,"",-1);
        return $result;
    }

    public function updateEmail(){
        $this->log->showLog(3,"Update Email");

        $sql="UPDATE $this->tableusers SET email='$this->email' WHERE uid=$this->uid";
        
        $this->log->showLog(4,"With SQL: $sql");
        if($this->xoopsDB->query($sql))
            $this->log->showLog(3,"Successfully");
        else
            $this->log->showLog(1,"Failed.");
    }

        public function resetPassword(){
        $this->log->showLog(3,"Reset Password");
        
        $sql="UPDATE $this->tableusers SET pass=md5(uname) WHERE uid=
            (SELECT uid from $this->tablestudent WHERE student_id=$this->student_id)";

        $this->log->showLog(1,"With SQL: $sql");
        if($this->xoopsDB->query($sql)){
            $this->log->showLog(3,"Successfully");
            return true;
        }
        else{
            return false;
            $this->log->showLog(1,"Failed.");
        }
    }

    public function updateStudentSemester(){
        global $defaultorganization_id;
        $sql = "select * from $this->tablestudent where isactive = 1 and organization_id = $defaultorganization_id";

        $query=$this->xoopsDB->query($sql);

        $j=0;
        while ($row=$this->xoopsDB->fetchArray($query)){

            $student_id = $row['student_id'];
            $semester_id = $this->getStudentSemester($student_id);

            if($semester_id> 0){
                $sqlupdate = "update $this->tablestudent set semester_id = $semester_id where student_id = $student_id";
                $queryupdate=$this->xoopsDB->query($sqlupdate);
            }
        }
    }
    public function getStudentSemester($student_id){

        $retval = 1;
        $semester = 0;
        $year_name = "";
        $session_id = 0;
        $student_postpone = 0;

        $sql = "select yr.year_name,st.session_id,st.student_postpone from
        $this->tablestudent st, $this->tableyear yr
        where st.year_id = yr.year_id
        and st.student_id = $student_id ";

        $query=$this->xoopsDB->query($sql);


        if ($row=$this->xoopsDB->fetchArray($query)){
        $year_name = $row['year_name'];
        $session_id = $row['session_id'];
        $student_postpone = $row['student_postpone'];

        }

        //get session array
        $sql = "select ss.session_id from $this->tablesession ss
        where ss.session_id > 0 order by ss.session_id ";

        $query=$this->xoopsDB->query($sql);

        $j=0;
        while ($row=$this->xoopsDB->fetchArray($query)){
        $j++;
        $sessionarr_id[$j] = $row['session_id'];
        }
        //end

        if($session_id > 0 && $year_name != ""){

            $sqlys = "select  yr.year_name,cs.session_id
            from $this->tableclosesession cs, $this->tableyear yr
            where cs.year_id = yr.year_id and cs.isactive = 0 limit 1";

            $querysys = $this->xoopsDB->query($sqlys);


            if ($rowsys=$this->xoopsDB->fetchArray($querysys)){
            $yearsys_name = $rowsys['year_name'];
            $sessionsys_id = $rowsys['session_id'];

                //check year n session

                $diffdate = $yearsys_name - $year_name + 1;

                $start_session = $year_name + $session_id + 1;
                $end_session = $yearsys_name + $sessionsys_id + $diffdate;

                $retval = $end_session - $start_session + 1 - $student_postpone;

                //end of check

            }

        }

        return $retval;
    }

    
} // end of ClassStudent
?>

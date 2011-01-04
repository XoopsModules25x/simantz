<?php
class Report{
    public $xoopsDB;
    
    public function Report(){
        global $xoopsDB,$log;
        $this->xoopsDB=$xoopsDB;
        $this->log=$log;
    }

    public function showBpartnerListForm(){

    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">


      function checkcourse(){
//         var semester =document.getElementById('semester_id').value;
//         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;
//         var type =document.getElementById('type').checked;
//         if(course==""){
//            alert("Please Select Course");
//            return false;
//         }
//
//         if(type==false){
//           if(semester=="" || semester=="0"){
//             alert("Semester Cannot be null in CGP Type.");
//             return false;
//            }
//         }
        
         return true;
       }
</script>


<form name="frmSearch" action="viewbpartnerlist.php" method="POST" target="_blank"" Onsubmit="return checkcourse()">
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Business Partner Listing</td></tr>

            <tr>
               <td class="head">Business Partner No</td><td><input type="text" $width id="searchbpartner_no" name="searchbpartner_no" value="$this->searchbpartner_no"/></td>
               <td class="head">Business Partner Group</td><td><select name="searchbpartnergroup_id" $width id="searchbpartnergroup_id">$this->searchbpartnergroupctrl</select></td>
            </tr>

            <tr>
               <td class="head">Company No</td><td><input type="text" $width id="companyno" name="companyno" value="$this->companyno"/></td>
               <td class="head">Business Partner Name</td><td><input type="text" $width id="bpartner_name" name="bpartner_name" value="$this->bpartner_name"/></select></td>
            </tr>

            <tr>
               <td class="head">Industry</td><td><select name="searchindustry_id" $width id="searchindustry_id">$this->searchindustryctrl</select></td>
               <td class="head">Terms</td><td><select name="searchterms_id" $width id="searchterms_id">$this->searchtermsctrl</select></td>
            </tr>
            <tr>
               <td class="head">Business Partner Type</td><td><select name="searchtype" $width id="searchtype">
                                                  <option value="-1">All</option>
                                                  <option value="C">Customer</option>
                                                  <option value="S">Supplier</option>
                                              </select></td>
               <td class="head">Ative</td><td><select name="searchisactive" $width id="searchisactive">
                                                  <option value="-1">Null</option>
                                                  <option value="1">Yes</option>
                                                  <option value="0">No</option>
                                              </select></td>
            </tr>

            <tr>
               <td class="head"><br></td>
               <td colspan="3"></td>
            </tr>

            <tr class="searchformheader"><td colspan="6" align="left"><input type="submit" name="pubReport" value="Publish" ></td></tr>
            </table>
</div>
</form>

	<br>
EOF;
  }


  //for combox nitobi
    public function initFormProcess(){
//var_dump($_REQUEST);die;
    /* start process combo value */
    //Student
    $this->cmbStudent = "cmbStudent";//define id for combobox nitobi
    $this->student_id = isset($this->student_id) ? $this->student_id : $_REQUEST[$this->cmbStudent.'SelectedValue0'];
    $this->student_name = $this->getFieldNameValue("sim_simedu_student","student_id","student_name",$this->student_id,"%d");
    $this->student_newicno = $this->getFieldNameValue("sim_simedu_student","student_id","student_newicno",$this->student_id,"%d");

    $this->cmbStudentintake = "cmbStudentintake";//define id for combobox nitobi
    $this->studentintake_id = isset($this->studentintake_id) ? $this->studentintake_id : $_REQUEST[$this->cmbStudentintake.'SelectedValue0'];
    $student_id=$this->getStuidByintake($this->studentintake_id);
    $this->student_name = $this->getFieldNameValue("sim_simedu_student","student_id","student_name",$student_id,"%d");
    $this->registeredno = $this->getFieldNameValue("sim_simedu_studentintake","studentintake_id","registeredno",$this->studentintake_id,"%d");
    //Course
    $this->cmbCourse = "cmbCourse";//define id for combobox nitobi
    $this->course_id = isset($this->course_id) ? $this->course_id : $_REQUEST[$this->cmbCourse.'SelectedValue0'];
    $this->course_name = $this->getFieldNameValue("sim_simedu_course","course_id","course_name",$this->course_id,"%d");
    
    //Course
    $this->cmbSubject = "cmbSubject";//define id for combobox nitobi
    $this->subject_id = isset($this->subject_id) ? $this->subject_id : $_REQUEST[$this->cmbSubject.'SelectedValue0'];
    $this->subject_name = $this->getFieldNameValue("sim_simedu_subject","subject_id","subject_name",$this->subject_id,"%d");

     //lecturer
    $this->cmbEmployee = "cmbEmployee";//define id for combobox nitobi
    $this->employee_id = isset($this->employee_id) ? $this->employee_id : $_REQUEST[$this->cmbEmployee.'SelectedValue0'];
    $this->employee_name = $this->getFieldNameValue("sim_hr_employee","employee_id","employee_name",$this->employee_id,"%d");
    $this->employee_no = $this->getFieldNameValue("sim_hr_employee","employee_id","employee_no",$this->employee_id,"%d");
    /* end process */
  }

    public function getFieldNameValue($tablename,$primaykey,$field_name,$field_value,$field_type){

    $sql = sprintf("SELECT $field_name as fld_name FROM $tablename WHERE $primaykey = '$field_type' ",$field_value);
    $query = $this->xoopsDB->query($sql);
    $retval = "";
    while ($row=$this->xoopsDB->fetchArray($query))
    {
    $retval = $row['fld_name'];
    }
    return $retval;
  }
 //end

    public function getStuidByintake($stuintake_id){
        
    $sql = "SELECT student_id as fld_name FROM sim_simedu_studentintake WHERE studentintake_id = '$stuintake_id'";
    $query = $this->xoopsDB->query($sql);
    $retval = "";
    while ($row=$this->xoopsDB->fetchArray($query))
    {
    $retval = $row['fld_name'];
    }
    return $retval;

        
    }

    public function getLastedIntakeByStuID($student_id){

    $sql = "SELECT MAX(studentintake_id) as fld_name FROM sim_simedu_studentintake WHERE student_id = '$student_id'";
    $query = $this->xoopsDB->query($sql);
    $retval = "";
    while ($row=$this->xoopsDB->fetchArray($query))
    {
    $retval = $row['fld_name'];
    }
    return $retval;


    }


    public function includeGeneralFile(){
      global $url;

echo <<< EOF
<script src="$url/modules/simantz/include/validatetext.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/popup.js" type="text/javascript"></script>
<script src="$url/browse.php?Frameworks/jquery/jquery.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/nitobi/nitobi.toolkit.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/nitobi/nitobi.combo/nitobi.combo.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/nitobi/nitobi.grid/paginator.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/firefox3_6fix.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/nitobi/nitobi.grid/paginator.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/popup.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/xoops.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/nitobi/nitobi.combo/nitobi.combo.css">
EOF;

  }
}


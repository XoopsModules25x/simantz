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
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">CGPA Reports</td></tr>

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

    public function showHallTicketForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
        nitobi.loadComponent('$this->cmbStudent');
        var list = nitobi.getComponent('$this->cmbStudent');
        document.getElementById('$this->cmbStudent'+''+'SelectedValue0').value = '$this->student_id';
        list.SetTextValue("$this->student_name");

        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

      function checkcourse(){
         var semester =document.getElementById('semester_id').value;
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;
         if(course=="" || course=="0"){
            alert("Please Select Course");
            return false;
         }
         return true;
       }
</script>


<form name="frmSearch" action="viewhallticket.php" method="POST" target="_blank"" Onsubmit="return checkcourse()">
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Hall Ticket</td></tr>

            <tr>
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Intake</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr>
               <td class="head">Semester</td><td><select name="semester_id" $width id="semester_id">$this->semesterctrl</select></td>
               <td class="head">Status</td><td><select name="studentstatus_id" $width id="studentstatus_id">$this->studentstatusectrl</select></td>
            </tr>

            <tr>
               <td class="head">Academic Year</td><td><select name="academicyear_id" $width id="academicyear_id">$this->acadmicyearctrl</select></td>
               <td class="head">Term</td><td><input type="text" $width id="cgpa" name="term" value="$this->term"/></td>
            </tr>

            <tr>
               <td class="head">Student IC</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbStudent" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="430px" Height="200px" DatasourceUrl="reportcombo.php?action=student_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="50px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="130px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>

            <tr>
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
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

    public function showLeacturerForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
        nitobi.loadComponent('$this->cmbEmployee');
        var list = nitobi.getComponent('$this->cmbEmployee');
        document.getElementById('$this->cmbEmployee'+''+'SelectedValue0').value = '$this->employee_id';
        list.SetTextValue("$this->employee_name");

    }));

</script>


<form name="frmSearch" action="viewlecturerdetail.php" method="POST" target="_blank"" >
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Lecturer Details</td></tr>

            <tr>
               <td class="head">Lecturer</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbEmployee" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="430px" Height="200px" DatasourceUrl="reportcombo.php?action=employee_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="50px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="130px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
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

    public function showMarketingForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
        nitobi.loadComponent('$this->cmbStudent');
        var list = nitobi.getComponent('$this->cmbStudent');
        document.getElementById('$this->cmbStudent'+''+'SelectedValue0').value = '$this->student_id';
        list.SetTextValue("$this->student_name");

        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

</script>


<form name="frmSearch" action="viewmarketingstatistic.php" method="POST" target="_blank"" >
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Marketing Statistic</td></tr>

            <tr>
               <td class="head">Races</td><td><select name="races_id" $width id="races_id">$this->racesctrl</select></td>
               <td class="head">Recommendation</td><td><select name="recomd_id" $width id="recomd_id">$this->recomdctrl</select></td>
            </tr>

            <tr>
               <td class="head">State</td><td><select name="state_id" $width id="state_id">$this->statectrl</select></td>
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
  
    public function showSubjectEnrolledForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

      function validate(){
         var semester =document.getElementById('semester_id').value;
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;

         if(course==""){
            alert("Please Select Course");
            return false;
         }

         return true;
       }
</script>


<form name="frmSearch" action="viewsubjectenrollment.php" method="POST" target="_blank"" Onsubmit="return validate()">
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Subject Enrollment Report</td></tr>

            <tr>
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Intake</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr>
               <td class="head">Semester</td><td><select name="semester_id" $width id="semester_id">$this->semesterctrl</select></td>
            </tr>

            <tr>
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
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

    public function showCourseEnrolledForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

      function validate(){
         var semester =document.getElementById('semester_id').value;
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;
//
//         if(course==""){
//            alert("Please Select Course");
//            return false;
//         }

         return true;
       }
</script>


<form name="frmSearch" action="viewcourseenrollment.php" method="POST" target="_blank"" Onsubmit="return validate()">
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Course Enrollment Report</td></tr>

            <tr>
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Intake</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr>
               <td class="head">Semester</td><td><select name="semester_id" $width id="semester_id">$this->semesterctrl</select></td>
               <td class="head">Status</td><td><select name="status_id" $width id="status_id">$this->statusctrl</select></td>
            </tr>

            <tr>
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
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

    public function showStudentlistForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
        nitobi.loadComponent('$this->cmbStudent');
        var list = nitobi.getComponent('$this->cmbStudent');
        document.getElementById('$this->cmbStudent'+''+'SelectedValue0').value = '$this->student_id';
        list.SetTextValue("$this->student_name");

        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

      function checkcourse(){
         var semester =document.getElementById('semester_id').value;
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;
         var type =document.getElementById('type').checked;
         if(course==""){
            alert("Please Select Course");
            return false;
         }

         if(type==false){
           if(semester=="" || semester=="0"){
             alert("Semester Cannot be null in CGP Type.");
             return false;
            }
         }

         return true;
       }
</script>


<form name="frmSearch" action="viewstudentlist.php" method="POST" target="_blank"" Onsubmit="return checkcourse()">
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Student List Reports</td></tr>

            <tr>
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Intake</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr>
               <td class="head">Status</td><td><select name="studentstatus_id" $width id="studentstatus_id">$this->studentstatusectrl</select></td>
            </tr>

            <tr>
               <td class="head">Student IC</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbStudent" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="430px" Height="200px" DatasourceUrl="reportcombo.php?action=student_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="50px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="130px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>

            <tr>
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>
            
            <tr>
               <td class="head" colspan="2"><br></td>
            </tr>

            <tr>
               <td class="head" colspan="2"><Input type = 'Radio' checked id ='type' Name ='type' value='1'>
                                Name, IC Number and Race</td>
            </tr>
            
            <tr>
               <td class="head" colspan="2"><Input type = 'Radio' checked id ='type' Name ='type' value='2'>
                                Name, Admission no and Duration</td>
            </tr>

            <tr>
               <td class="head" colspan="2"><Input type = 'Radio' checked id ='type' Name ='type' value='3'>
                                Name, Course and Intake</td>
            </tr>

            <tr>
               <td class="head" colspan="2"><Input type = 'Radio' checked id ='type' Name ='type' value='4'>
                                Name and Address</td>
            </tr>
            
            <tr>
               <td class="head" colspan="2"><Input type = 'Radio' checked id ='type' Name ='type' value='5'>
                                Name and Contact Person</td>
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

    public function showGraduateListForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){

        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

      function checkcourse(){
   
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;
         if(course==""){
            alert("Please Select Course");
            return false;
         }

         return true;
       }
</script>


<form name="frmSearch" action="viewgraduatelistreport.php" method="POST" target="_blank">
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Graduation List</td></tr>

            <tr>
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Intake</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr>
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>

            <tr>
               <td class="head" colspan="4"><Input type = 'Radio' checked id ='type' Name ='type' value='1'> Graduation</td>
            </tr>

            <tr>
               <td class="head" colspan="4"><Input type = 'Radio' id ='type'  Name ='type' value='2'> Non Graduation</td>
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

    public function showExamAttendanceForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
        nitobi.loadComponent('$this->cmbSubject');
        var list = nitobi.getComponent('$this->cmbSubject');
        document.getElementById('$this->cmbSubject'+''+'SelectedValue0').value = '$this->subject_id';
        list.SetTextValue("$this->subject_name");

        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

      function checkcourse(){
         var semester =document.getElementById('semester_id').value;
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;

         if(course==""){
            alert("Please Select Course");
            return false;
         }

         return true;
       }
</script>


<form name="frmSearch" action="viewexamattendlist.php" method="POST" target="_blank"" >
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Examination Attendance Listing</td></tr>

            <tr>
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Intake</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr>
               <td class="head">Semester</td><td><select name="semester_id" $width id="semester_id">$this->semesterctrl</select></td>
               <td class="head">Term</td><td><input type="text" $width id="term" name="term" value="$this->term"/></td>
            </tr>

            <tr>
               <td class="head">Academic Year</td><td><select name="academicyear_id" $width id="academicyear_id">$this->acadmicyearctrl</select></td>
               <td class="head">Status</td><td><select name="studentstatus_id" $width id="studentstatus_id">$this->studentstatusectrl</select></td>
            </tr>

            <tr>
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>

            <tr>
               <td class="head">Subject</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbSubject" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="430px" Height="200px" DatasourceUrl="reportcombo.php?action=subject_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="50px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="130px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>
            
            <tr style="display:none">
               <td class="head">With Mark </td>
               <td class="even"><Input type='checkbox'  id ='showmark' Name ='showmark' value='1'></td>
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

    public function showStudentBiodataForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
        nitobi.loadComponent('$this->cmbStudent');
        var list = nitobi.getComponent('$this->cmbStudent');
        document.getElementById('$this->cmbStudent'+''+'SelectedValue0').value = '$this->student_id';
        list.SetTextValue("$this->student_name");

        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

      function checkcourse(){
         var semester =document.getElementById('semester_id').value;
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;

         if(course==""){
            alert("Please Select Course");
            return false;
         }

         return true;
       }
</script>


<form name="frmSearch" action="viewstudentbiodata.php" method="POST" target="_blank"" >
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Student Biodata</td></tr>

            <tr>
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Intake</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr>     
               <td class="head">Status</td><td><select name="studentstatus_id" $width id="studentstatus_id">$this->studentstatusectrl</select></td>
            </tr>

            <tr>
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>

            <tr>
               <td class="head">Student IC</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbStudent" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="430px" Height="200px" DatasourceUrl="reportcombo.php?action=student_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="50px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="130px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
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

    public function showStudentRequimentForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
        nitobi.loadComponent('$this->cmbStudent');
        var list = nitobi.getComponent('$this->cmbStudent');
        document.getElementById('$this->cmbStudent'+''+'SelectedValue0').value = '$this->student_id';
        list.SetTextValue("$this->student_name");

        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

      function checkcourse(){
         var semester =document.getElementById('semester_id').value;
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;

         if(course==""){
            alert("Please Select Course");
            return false;
         }

         return true;
       }
</script>


<form name="frmSearch" action="viewstudentbiodata.php" method="POST" target="_blank"" >
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Student Biodata</td></tr>

            <tr>
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Intake</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr>
               <td class="head">Status</td><td><select name="studentstatus_id" $width id="studentstatus_id">$this->studentstatusectrl</select></td>
            </tr>

            <tr>
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>

            <tr>
               <td class="head">Student IC</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbStudent" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="430px" Height="200px" DatasourceUrl="reportcombo.php?action=student_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="50px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="130px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
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

    public function showExamsubjectEnrolledForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
        nitobi.loadComponent('$this->cmbStudent');
        var list = nitobi.getComponent('$this->cmbStudent');
        document.getElementById('$this->cmbStudent'+''+'SelectedValue0').value = '$this->student_id';
        list.SetTextValue("$this->student_name");

        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

      function checkcourse(){
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;

         if(course==""){
            alert("Please Select Course");
            return false;
         }

         return true;
       }
</script>


<form name="frmSearch" action="viewexamsubject.php" method="POST" target="_blank"" >
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Examination Subject Enrollment Details</td></tr>

            <tr>
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Intake</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr>
               <td class="head">Status</td><td><select name="studentstatus_id" $width id="studentstatus_id">$this->studentstatusectrl</select></td>
            </tr>

            <tr>
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>
        
            <tr>
               <td class="head">Student IC</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbStudent" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="430px" Height="200px" DatasourceUrl="reportcombo.php?action=student_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="50px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="130px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
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

    public function showResultSlipForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
        nitobi.loadComponent('$this->cmbStudent');
        var list = nitobi.getComponent('$this->cmbStudent');
        document.getElementById('$this->cmbStudent'+''+'SelectedValue0').value = '$this->student_id';
        list.SetTextValue("$this->student_name");

        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

      function checkcourse(){
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;
         if(course==""){
            alert("Please Select Course");
            return false;
         }

         return true;
       }

     function reset(){}
     function resetcombox()
     {
        document.getElementById('$this->cmbStudent'+''+'SelectedValue0').value = "";
        document.getElementById('$this->cmbStudent'+''+'SelectedValue1').value = "";

        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = "";
        document.getElementById('$this->cmbCourse'+''+'SelectedValue1').value = "";

     }
</script>


<form name="frmSearch" action="viewresultslip.php" method="POST" target="_blank"" Onsubmit="return checkcourse()">
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Result Slip</td></tr>

            <tr>
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Intake</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr>
               <td class="head">Semester</td><td><select name="semester_id" $width id="semester_id">$this->semesterctrl</select></td>
               <td class="head">Status</td><td><select name="studentstatus_id" $width id="studentstatus_id">$this->studentstatusectrl</select></td>
            </tr>

            <tr>
               <td class="head">Academic Year</td>
               <td><select name="academicyearfrom_id" $width id="academicyearfrom_id">$this->acadmicyearfromctrl</select>
                   To
                   <select name="academicyearto_id" $width id="academicyearto_id">$this->acadmicyeartoctrl</select></td>
               <td class="head">Term</td><td><input type="text" $width id="term" name="term" value="$this->term"/></td>
            </tr>

            <tr>
               <td class="head">Student IC</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbStudent" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="430px" Height="200px" DatasourceUrl="reportcombo.php?action=student_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="50px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="130px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>

            <tr>
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>

            <tr>
               <td class="head" colspan="2"><Input type = 'Radio' checked id ='type' Name ='type' value='1'>
                                Result With Mark</td>
            </tr>

            <tr>
               <td class="head" colspan="2"><Input type = 'Radio' checked id ='type' Name ='type' value='2'>
                                Result With CGPA</td>
            </tr>

            <tr>
               <td class="head" colspan="2"><Input type = 'Radio' checked id ='type' Name ='type' value='3'>
                                Result With Pass Mark</td>
            </tr>

            <tr>
               <td class="head"><br></td>
               <td colspan="3"></td>
            </tr>

            <tr class="searchformheader">
                <td colspan="6" align="left">
                    <input type="submit" name="pubReport" value="Publish" >
                    <input type="button" value="Reset" onclick="resetcombox();reset();"/>
                </td></tr>
            </table>
</div>
</form>

	<br>
EOF;
  }

    public function showStudentMasterForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
        nitobi.loadComponent('$this->cmbStudent');
        var list = nitobi.getComponent('$this->cmbStudent');
        document.getElementById('$this->cmbStudent'+''+'SelectedValue0').value = '$this->student_id';
        list.SetTextValue("$this->student_name");

        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

      function checkcourse(){
         var semester =document.getElementById('semester_id').value;
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;

         if(course==""){
            alert("Please Select Course");
            return false;
         }

         return true;
       }
</script>


<form name="frmSearch" action="viewstudentmaster.php" method="POST" target="_blank"" >
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Student Master Details</td></tr>

            <tr>
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Intake</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr>
               <td class="head">Status</td><td><select name="studentstatus_id" $width id="studentstatus_id">$this->studentstatusectrl</select></td>
            </tr>

            <tr>
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>

            <tr>
               <td class="head">Student IC</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbStudent" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="430px" Height="200px" DatasourceUrl="reportcombo.php?action=student_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="50px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="130px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
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

    public function showStudentStatusForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){

    }));

      function checkcourse(){
         return true;
       }
</script>


<form name="frmSearch" action="viewstudentstatus.php" method="POST" target="_blank"" >
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Student Status Report</td></tr>

            <tr>
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Status</td><td><select name="studentstatus_id" $width id="studentstatus_id">$this->studentstatusectrl</select></td>
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

    public function showSubjectDetailsForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){

        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

      function checkcourse(){
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;

         if(course==""){
            alert("Please Select Course");
            return false;
         }

         return true;
       }
</script>


<form name="frmSearch" action="viewsubjectdetail.php" method="POST" target="_blank"" >
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Subject Details</td></tr>

            <tr>
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Intake</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr>
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
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

    public function showStuGraduaChecklistForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
        nitobi.loadComponent('$this->cmbStudentintake');
        var list = nitobi.getComponent('$this->cmbStudentintake');
        document.getElementById('$this->cmbStudentintake'+''+'SelectedValue0').value = '$this->studentintake_id';
        list.SetTextValue("$this->student_name");

        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

        changesearch();
    }));

      function checkcourse(){
         var semester =document.getElementById('semester_id').value;
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;
         var type =document.getElementById('type').checked;
         if(course==""){
            alert("Please Select Course");
            return false;
         }

         return true;
       }

      function changesearch(){
         var registered =document.getElementById('registered').checked;
         var course =document.getElementById('course').checked;

         if(registered){
           document.getElementById('registeredform').style.display="";
           document.getElementById('courseform').style.display="none";
           document.getElementById('courseform2').style.display="none";
         }
         else if(course){
           document.getElementById('registeredform').style.display="none";
           document.getElementById('courseform').style.display="";
           document.getElementById('courseform2').style.display="";
         }
       }
</script>


<form name="frmSearch" action="viewstudentgradchecklist.php" method="POST" target="_blank"" Onsubmit="return checkcourse()">
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Student Graduation Report</td></tr>

            <tr>
               <td class="head" colspan="4"><Input type = 'Radio'  id ='registered' Name ='type' value='1' onchange="changesearch()">Registration No</td>
            </tr>

            <tr>
               <td class="head" colspan="4"><Input type = 'Radio' CHECKED id='course'  Name ='type' value='2' onchange="changesearch()">Course, Intake Year & Session </td>
            </tr>

            <tr>
               <td class="head"><br></td>
               <td colspan="3"></td>
            </tr>

            <tr id="registeredform" style="display:none">
               <td class="head">Registration No</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbStudentintake" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="430px" Height="200px" DatasourceUrl="reportcombo.php?action=studentintake_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="50px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="130px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>

            <tr id="courseform">
               <td class="head">Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Intake</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr id="courseform2">
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
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

    public function showResultStaisticsForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){

        nitobi.loadComponent('$this->cmbCourse');
        var list = nitobi.getComponent('$this->cmbCourse');
        document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value = '$this->course_id';
        list.SetTextValue("$this->course_name");

    }));

      function checkcourse(){
         var semester =document.getElementById('semester_id').value;
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;
         var type =document.getElementById('type').checked;
         if(course==""){
            alert("Please Select Course");
            return false;
         }

         if(type==false){
           if(semester=="" || semester=="0"){
             alert("Semester Cannot be null in CGP Type.");
             return false;
            }
         }

         return true;
       }
</script>


<form name="frmSearch" action="viewresultstatistics.php" method="POST" target="_blank"" Onsubmit="return checkcourse()">
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Result Statistics</td></tr>

            <tr>
               <td class="head">Academic Year</td><td><select name="year_id" $width id="year_id">$this->yearctrl</select></td>
               <td class="head">Session</td><td><select name="session_id" $width id="session_id">$this->sessionctrl</select></td>
            </tr>

            <tr>
               <td class="head">Course</td>
               <td colspan="3">
                  <ntb:Combo id="$this->cmbCourse" Mode="classic" theme="flex" InitialSearch="" >
                     <ntb:ComboTextBox $inputstyle DataFieldIndex=1 ></ntb:ComboTextBox>
                     <!-- A list which allows paging and search. The datasource is a separate file. -->
                     <ntb:ComboList Width="450px" Height="200px" DatasourceUrl="reportcombo.php?action=course_list" PageSize="25" >
                     <ntb:ComboColumnDefinition Width="25px" DataFieldIndex=2 ></ntb:ComboColumnDefinition>
                     <ntb:ComboColumnDefinition Width="150px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
                     </ntb:ComboList>
                  </ntb:Combo>
               </td>
            </tr>

            <tr>
               <td class="head" colspan="2"><br></td>
            </tr>

            <tr>
               <td class="head" colspan="2"><Input type = 'Radio' checked id ='type' Name ='type' value='1'>KAT</td>
            </tr>

            <tr>
               <td class="head" colspan="2"><Input type = 'Radio' checked id ='type' Name ='type' value='2'>KTS</td>
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

    public function showStuStatiscticForm(){
    $this->initFormProcess();
    $this->includeGeneralFile();

    $width='style="width:100px"';
    $inputstyle="width=350px";
echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){

        changesearch();
    }));

      function checkcourse(){
         var semester =document.getElementById('semester_id').value;
         var course =document.getElementById('$this->cmbCourse'+''+'SelectedValue0').value;
         var type =document.getElementById('type').checked;
         if(course==""){
            alert("Please Select Course");
            return false;
         }

         return true;
       }

      function changesearch(){
         var registered =document.getElementById('registered').checked;
         var course =document.getElementById('course').checked;

         if(registered){
           document.getElementById('courseform').style.display="none";
         }
         else if(course){
           document.getElementById('courseform').style.display="";
         }
       }
</script>


<form name="frmSearch" action="viewstatistics.php" method="POST" target="_blank"" Onsubmit="return checkcourse()">
<div align="center">
    <table class="searchformblock" style="width:900px" style="text-align: left">
            <tr class="tdListRightTitle" style="text-align: center;height:20px; "><td colspan="6">Student Graduation Report</td></tr>

            <tr>
               <td class="head" colspan="4"><Input type = 'Radio' CHECKED id ='registered' Name ='type' value='1' onchange="changesearch()">By Active Student</td>
            </tr>

            <tr>
               <td class="head" colspan="4"><Input type = 'Radio'  id='course'  Name ='type' value='2' onchange="changesearch()">By Intake Year</td>
            </tr>

            <tr>
               <td class="head"><br></td>
               <td colspan="3"></td>
            </tr>

            <tr id="courseform">
               <td class="head">Year From</td><td><select name="fromyear_id" $width id="fromyear_id">$this->yearctrl</select></td>
               <td class="head">Year To</td><td><select name="toyear_id" $width id="toyear_id">$this->yearctrl</select></td>
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

  

    public function getComboCourse($wherestring){

        $this->log->showLog(2,"Run lookup getComboCourse()");
        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;

        $pageSize = 0;
	if (isset($_GET['PageSize'])) {
		$pageSize = $_GET['PageSize'];
	}

	if ($pageSize < 1) {
		$pageSize=15;
	}

	$startingRecordIndex = 0;
	if (isset($_GET['StartingRecordIndex'])) {
		$startingRecordIndex = $_GET['StartingRecordIndex'];
	}

	if ($startingRecordIndex < 1) {
		$startingRecordIndex=0;
	}

	$searchSubString = "";
	if (isset($_GET['SearchSubstring']) && $_GET['SearchSubstring'] != "Please Select") {
		$searchSubString = $_GET['SearchSubstring'];
	}

	$lastString = "";
	if (isset($_GET['LastString'])) {
		$lastString = $_GET['LastString'];
	}

        $orderstring = " ORDER BY seqno ASC, course_name ASC ";

       $sql = "SELECT * FROM sim_simedu_course ";
       $sql .= " WHERE ( course_name LIKE '%s' OR course_no LIKE '%s' ) ";
       $sql .= " $wherestring ";
       $sql .= " $orderstring ";
       $sql .= " LIMIT $startingRecordIndex , $pageSize ";

       $sql = sprintf($sql,"%".$searchSubString."%","%".$searchSubString."%");


       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

        $currentRecord = 0; // This will assist us finding the ordinalStart position
        while ($row=$this->xoopsDB->fetchArray($query))
        {

            $getHandler->CreateNewRecord($row["course_id"]);
            $getHandler->DefineRecordFieldValue("course_id", $row["course_id"]);
            $getHandler->DefineRecordFieldValue("course_name", $row["course_name"]);
            $getHandler->DefineRecordFieldValue("course_no", $row["course_no"]);
            $getHandler->SaveRecord();

        }
  }

    public function getComboSubject($wherestring){

        $this->log->showLog(2,"Run lookup getComboSubject()");
        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;

        $pageSize = 0;
	if (isset($_GET['PageSize'])) {
		$pageSize = $_GET['PageSize'];
	}

	if ($pageSize < 1) {
		$pageSize=15;
	}

	$startingRecordIndex = 0;
	if (isset($_GET['StartingRecordIndex'])) {
		$startingRecordIndex = $_GET['StartingRecordIndex'];
	}

	if ($startingRecordIndex < 1) {
		$startingRecordIndex=0;
	}

	$searchSubString = "";
	if (isset($_GET['SearchSubstring']) && $_GET['SearchSubstring'] != "Please Select") {
		$searchSubString = $_GET['SearchSubstring'];
	}

	$lastString = "";
	if (isset($_GET['LastString'])) {
		$lastString = $_GET['LastString'];
	}

        $orderstring = " ORDER BY seqno ASC, subject_name ASC ";

       $sql = "SELECT * FROM sim_simedu_subject ";
       $sql .= " WHERE ( subject_name LIKE '%s' OR subject_no LIKE '%s' ) ";
       $sql .= " $wherestring ";
       $sql .= " $orderstring ";
       $sql .= " LIMIT $startingRecordIndex , $pageSize ";

       $sql = sprintf($sql,"%".$searchSubString."%","%".$searchSubString."%");


       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

        $currentRecord = 0; // This will assist us finding the ordinalStart position
        while ($row=$this->xoopsDB->fetchArray($query))
        {

            $getHandler->CreateNewRecord($row["subject_id"]);
            $getHandler->DefineRecordFieldValue("subject_id", $row["subject_id"]);
            $getHandler->DefineRecordFieldValue("subject_name", $row["subject_name"]);
            $getHandler->DefineRecordFieldValue("subject_no", $row["subject_no"]);
            $getHandler->SaveRecord();

        }
  }

    public function getComboStudent($wherestring){

        $this->log->showLog(2,"Run lookup getComboStudent()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;


        $pageSize = 0;
	if (isset($_GET['PageSize'])) {
		$pageSize = $_GET['PageSize'];
	}

	if ($pageSize < 1) {
		$pageSize=15;
	}

	$startingRecordIndex = 0;
	if (isset($_GET['StartingRecordIndex'])) {
		$startingRecordIndex = $_GET['StartingRecordIndex'];
	}

	if ($startingRecordIndex < 1) {
		$startingRecordIndex=0;
	}

	$searchSubString = "";
	if (isset($_GET['SearchSubstring']) && $_GET['SearchSubstring'] != "Please Select") {
		$searchSubString = $_GET['SearchSubstring'];
	}

	$lastString = "";
	if (isset($_GET['LastString'])) {
		$lastString = $_GET['LastString'];
	}

        $orderstring = " ORDER BY seqno ASC, student_name ASC ";

       $sql = "SELECT * FROM sim_simedu_student";
       $sql .= " WHERE ( student_name LIKE '%s' OR student_newicno LIKE '%s' OR student_passport LIKE '%s' ) ";
       $sql .= " $wherestring ";
       $sql .= " $orderstring ";
       $sql .= " LIMIT $startingRecordIndex , $pageSize ";

       $sql = sprintf($sql,"%".$searchSubString."%","%".$searchSubString."%","%".$searchSubString."%");


       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

        $currentRecord = 0; // This will assist us finding the ordinalStart position
        while ($row=$this->xoopsDB->fetchArray($query))
        {

            $getHandler->CreateNewRecord($row["student_id"]);
            $getHandler->DefineRecordFieldValue("student_id", $row["student_id"]);
            $getHandler->DefineRecordFieldValue("student_name", $row["student_name"]);
            $getHandler->DefineRecordFieldValue("student_newicno", ($row["student_newicno"]!="" ? $row["student_newicno"] : $row["student_passport"]));
            $getHandler->SaveRecord();

        }
  }

    public function getComboStudentIntake($wherestring){

        $this->log->showLog(2,"Run lookup getComboStudentIntake()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;


        $pageSize = 0;
	if (isset($_GET['PageSize'])) {
		$pageSize = $_GET['PageSize'];
	}

	if ($pageSize < 1) {
		$pageSize=15;
	}

	$startingRecordIndex = 0;
	if (isset($_GET['StartingRecordIndex'])) {
		$startingRecordIndex = $_GET['StartingRecordIndex'];
	}

	if ($startingRecordIndex < 1) {
		$startingRecordIndex=0;
	}

	$searchSubString = "";
	if (isset($_GET['SearchSubstring']) && $_GET['SearchSubstring'] != "Please Select") {
		$searchSubString = $_GET['SearchSubstring'];
	}

	$lastString = "";
	if (isset($_GET['LastString'])) {
		$lastString = $_GET['LastString'];
	}

        $orderstring = " ORDER BY s.seqno ASC, s.student_name ASC ";

       $sql = "SELECT si.studentintake_id,si.registeredno, s.student_name FROM sim_simedu_studentintake si inner join sim_simedu_student s on s.student_id=si.student_id";
       $sql .= " WHERE ( s.student_name LIKE '%s' OR si.registeredno LIKE '%s') ";
       $sql .= " $wherestring ";
       $sql .= " $orderstring ";
       $sql .= " LIMIT $startingRecordIndex , $pageSize ";

       $sql = sprintf($sql,"%".$searchSubString."%","%".$searchSubString."%");


       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

        $currentRecord = 0; // This will assist us finding the ordinalStart position
        while ($row=$this->xoopsDB->fetchArray($query))
        {

            $getHandler->CreateNewRecord($row["studentintake_id"]);
            $getHandler->DefineRecordFieldValue("studentintake_id", $row["studentintake_id"]);
            $getHandler->DefineRecordFieldValue("student_name", $row["student_name"]);
            $getHandler->DefineRecordFieldValue("registeredno", $row["registeredno"]);
            $getHandler->SaveRecord();

        }
  }

    public function getComboLecturer($wherestring){

        $this->log->showLog(2,"Run lookup getComboLecturer()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;


        $pageSize = 0;
	if (isset($_GET['PageSize'])) {
		$pageSize = $_GET['PageSize'];
	}

	if ($pageSize < 1) {
		$pageSize=15;
	}

	$startingRecordIndex = 0;
	if (isset($_GET['StartingRecordIndex'])) {
		$startingRecordIndex = $_GET['StartingRecordIndex'];
	}

	if ($startingRecordIndex < 1) {
		$startingRecordIndex=0;
	}

	$searchSubString = "";
	if (isset($_GET['SearchSubstring']) && $_GET['SearchSubstring'] != "Please Select") {
		$searchSubString = $_GET['SearchSubstring'];
	}

	$lastString = "";
	if (isset($_GET['LastString'])) {
		$lastString = $_GET['LastString'];
	}

        $orderstring = " ORDER BY emp.seqno ASC, emp.employee_name ASC ";

       $sql = "SELECT emp.* FROM sim_hr_employee emp ";
       $sql .= " LEFT JOIN sim_hr_employeegroup eg on eg.employeegroup_id=emp.employeegroup_id ";
       $sql .= " WHERE ( emp.employee_name LIKE '%s' OR emp.employee_no LIKE '%s') ";
       $sql .= " $wherestring ";
       $sql .= " $orderstring ";
       $sql .= " LIMIT $startingRecordIndex , $pageSize ";

       $sql = sprintf($sql,"%".$searchSubString."%","%".$searchSubString."%");

       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

        $currentRecord = 0; // This will assist us finding the ordinalStart position
        while ($row=$this->xoopsDB->fetchArray($query))
        {
            $getHandler->CreateNewRecord($row["employee_id"]);
            $getHandler->DefineRecordFieldValue("employee_id", $row["employee_id"]);
            $getHandler->DefineRecordFieldValue("employee_name", $row["employee_name"]);
            $getHandler->DefineRecordFieldValue("employee_no", $row["employee_no"]);
            $getHandler->SaveRecord();
        }
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
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/themes/default/style.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/nitobi/nitobi.combo/nitobi.combo.css">
EOF;

  }
}


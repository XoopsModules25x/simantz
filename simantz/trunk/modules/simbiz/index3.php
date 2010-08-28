<?php

include_once "system.php";

include_once "menu.php";

include_once '../hr/class/Leave.php';
$leave = new Leave();

    $uid = $xoopsUser->getVar('uid');
    $login_user = $leave->getEmployeeId($uid);

    $year_session = getYearSession();

    $department_id = getDepartmentID($uid);

    $year_id = $year_session['year_id'];
    $session_id = $year_session['session_id'];

    $wherestring = "";



    $sqlonline =
    "select 'New Online Application' as alert_name,'studentonline.php' as alert_windows,count(*) as total_cnt from $tablestudentonline so
    where so.studentonline_status = 'A' and so.isactive = 1
    and (select count(*) from $tablestudent where applicant_id = so.student_id) = 0
    and so.organization_id = $defaultorganization_id";


    $sqlot =
    "select 'Overtime Claim Approval' as alert_name,'otapprovalapp.php' as alert_windows,count(*) as total_cnt from $tableovertime ot
    where ot.issubmit = 1
    and ot.isverify = 0 and ot.verified_by = $login_user 
    and ot.organization_id = $defaultorganization_id";

    $sqlotcomplete =
    "select 'Incomplete Overtime Claim' as alert_name,'otapproval.php' as alert_windows,count(*) as total_cnt from $tableovertime ot
    where ot.iscomplete = 0
    and ot.organization_id = $defaultorganization_id";

    $sqlquit =
    "select 'Transcript/Hostel Application' as alert_name,'studentapplication.php' as alert_windows,count(*) as total_cnt from $tablemainapplication ma, $tablestudent st
    where ma.finance_approval = 'N'
    and ma.student_id =st.student_id and st.organization_id = $defaultorganization_id
    and ma.year_id = $year_id and ma.session_id = $session_id ";

    $sqlfeedback =
    "select 'New Student Feedback' as alert_name,'studentfeedback.php' as alert_windows,count(*) as total_cnt from $tablestudentfeedback fb
    where fb.feedback_status = 'N' and fb.feedback_progress = 'P' and fb.department_id = $department_id
    and fb.organization_id = $defaultorganization_id
    and fb.year_id = $year_id and fb.session_id = $session_id ";

    $sql = "select * from (($sqlonline) union all ($sqlot) union all ($sqlotcomplete) union all ($sqlquit) union all ($sqlfeedback) ) as t";

    $query=$xoopsDB->query($sql);

echo <<< EOF
<table style="width: 100%; text-align: left;">
  <tbody>
    <tr>
	<td style="width: 30%; text-align: left;">

	<table style="width: 80%; text-align: left;">
	<tr>
    <td align="center"><a href="studentonline.php" title="Click Here To Create Student Profile"><img src="images/onlineapplication.jpg" width="60"><br><br>Check Online Application</a></td></tr>
    <tr><td align="center"><a href="studentfeedback.php" title="Click Here To View Student Feedback"><img src="images/feedback.jpg" width="60"><br><br>Student Feedback</a></td></tr>
    <tr><td align="center"><a href="otapproval.php" title="Click Here Claim / Approve Overtime"><img src="images/overtime.jpg"  width="60"><br><br>Overtime</a></td></tr>
    <tr><td align="center"><a href="studentinvoice.php" title="Click Here To Create / View Student Invoice"><img src="images/studentinvoice.jpg"  width="60"><br><br>Student Invoice</a></td></tr>
    <tr><td align="center"><a href="payslip.php" title="Click Here To Create / View Employee Payslip"><img src="images/payroll.jpg"  width="60" ><br><br>Payslip</a></td></tr>
    <tr><td align="center"><a href="viewoutstandingpayment.php" title="Click Here To View Outstanding Payment"><img src="images/outstanding.jpg"  width="60"><br><br>Outstanding Summary</a></td>
    </tr>
	</tbody>
	</table>

	</td>

    <td style="text-align: left;">
    <table style="text-align: left; width: 80%;" border="1">
	<tbody>
	<tr>
	<th colspan="4" align="center">Summary</th>
	</tr>

	<tr class="head">
	<td align="center" width="10%">No</td>
	<td align="center" width="50%">Description</td>
	<td align="center" width="20%">Status</td>
	<td align="center" width="20%">Total New</td>
	</tr>
EOF;

    $rowtype="";
    $i=0;
    while ($row=$xoopsDB->fetchArray($query)){
    $i++;
    $alert_name=$row['alert_name'];
    $total_cnt=$row['total_cnt'];
    $alert_windows=$row['alert_windows'];

    $imagenew = "";
    if($total_cnt >0)
    $imagenew = "<img src='images/new.gif' width='35' height='15'>";

    if($rowtype=="odd")
    $rowtype="even";
    else
    $rowtype="odd";


echo <<< EOF

		<tr onclick="viewApplication('$alert_windows',$year_id,$session_id)" class="$rowtype" onmouseover="omover('idTR$i')" onmouseout="omout('idTR$i','$rowtype')" id="idTR$i" style="cursor:pointer">

			<td align="center">$i</td>
			<td style="text-align:left;background-color:$alert_color">$alert_name</td>
			<td  style="text-align:center;">$imagenew</td>
			<td style="text-align:center;">$total_cnt</td>

		</tr>

EOF;
	}

	if($i==0)
	echo "<tr><td colspan='4' align='left'>No New Application(s) Found.<td></tr>";
echo <<< EOF
    </tbody>
    </table>

    </td>
    </tr>
  </tbody>
</table>


<script type='text/javascript'>
function omover(id){
document.getElementById(id).className="vfocus";
}
function omout(id,classtr){
document.getElementById(id).className=classtr;
}

function viewApplication(alert_windows,year_id,session_id){

    if(alert_windows == "registeredsubject.php")
    self.location = alert_windows+"?action=search&shownewonly=1";
    else if(alert_windows == "subjectexception.php")
    self.location = alert_windows+"?action=search&issearch=Y&subjectexception_status=N&year_id="+year_id+"&session_id="+session_id;
    else if(alert_windows == "industrialtraining.php")
    self.location = alert_windows+"?action=search&issearch=Y&practical_status=N&year_id="+year_id+"&session_id="+session_id;
    else if(alert_windows == "studentgraduate.php")
    self.location = alert_windows+"?action=search&issearch=Y&studentgraduate_status=N&year_id="+year_id+"&session_id="+session_id;
    else if(alert_windows == "studentapplication.php")
    self.location = alert_windows+"?action=search&issearch=Y&mainapplication_status=N&year_id="+year_id+"&session_id="+session_id;
    else if(alert_windows == "coursechange.php")
    self.location = alert_windows+"?action=search&issearch=Y&year_id="+year_id+"&session_id="+session_id;
    else if(alert_windows == "studentleave.php")
    self.location = alert_windows+"?shownew=1&action=search&issearch=Y&approval_status=P&year_id="+year_id+"&session_id="+session_id;
    else if(alert_windows == "studentfeedback.php")
    self.location = alert_windows+"?action=search&issearch=Y&feedback_status=N&year_id="+year_id+"&session_id="+session_id;
    else if(alert_windows == "studentonline.php")
    self.location = alert_windows+"?action=search&issearch=Y&iscreatetostudent=N";
    else if(alert_windows == "otapproval.php")
    self.location = alert_windows+"?action=search&issearch=Y&iscomplete=0";
    else if(alert_windows == "otapprovalapp.php")
    self.location = "otapproval.php?action=searchapproval&issearch=Y&iscomplete=0";


}
</script>

EOF;
require(XOOPS_ROOT_PATH.'/footer.php');
?>



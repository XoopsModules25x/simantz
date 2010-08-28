<?php
include "system.php";


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


//$log = new Log();
//$o = new Subjectclass();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";

echo <<< EOF
    <HEAD>


	<STYLE>
		<!--
		BODY,DIV,TABLE,THEAD,TBODY,TFOOT,TR,TD,P { font-family:"Arial"; font-size:14px }
        TH {  font-size:16px }
		 -->
	</STYLE>

</HEAD>

EOF;
$action="";

echo <<< EOF
<script type="text/javascript">

function updateSubjectType(subject_id,maxcapacity){
var arr_fld=new Array("action","subject_id","maxcapacityajax");//name for POST
var arr_val=new Array("updatesubjecttype",subject_id,maxcapacity);//value for POST

getRequest(arr_fld,arr_val);
}

</script>

EOF;
$widthsubject = "style = 'width:300px' ";

$subjectclass_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$subjectclass_id=$_POST["subjectclass_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$subjectclass_id=$_GET["subjectclass_id"];

}
else
$action="";

if($action != "printpreview")
include "menu.php";

if (isset($_POST['year_id']))
$year_id=$_POST["year_id"];
else
$year_id=$_GET["year_id"];

$createdby=$xoopsUser->getVar('uid');
$updatedby=$xoopsUser->getVar('uid');
$isAdmin=$xoopsUser->isAdmin();

if(isset($_POST['issearch']))
$issearch=$_POST['issearch'];
else
$issearch=$_GET['issearch'];

if(isset($_POST['subjectexceptionline_id']))
$subjectexceptionline_id=$_POST['subjectexceptionline_id'];
else
$subjectexceptionline_id=$_GET['subjectexceptionline_id'];

if(isset($_POST['studentfeedback_id']))
$studentfeedback_id=$_POST['studentfeedback_id'];
else
$studentfeedback_id=$_GET['studentfeedback_id'];

if(isset($_POST['year_id']))
$year_id=$_POST['year_id'];
else
$year_id=$_GET['year_id'];

if(isset($_POST['session_id']))
$session_id=$_POST['session_id'];
else
$session_id=$_GET['session_id'];

if(isset($_POST['issave']))
$issave=$_POST['issave'];
else
$issave=$_GET['issave'];

$studentleaveapproval_id=$_POST['studentleaveapproval_id'];
$approval_status=$_POST['approval_status'];
$approval_remarks=$_POST['approval_remarks'];
$leave_status=$_POST['leave_status'];

if ($isactive=="1" || $isactive=="on")
	$isactive=1;
else if ($isactive=="null")
	$isactive="null";
else
	$isactive=0;

$timestamp= date("Y-m-d", time()) ;

echo "<title>$menuname</title>";

$styleleft = "style='text-align:left;border: 1px solid;'";
$stylecenter = "style='text-align:center;border: 1px solid;'";
$stylebottom = "style='align:center;border-bottom: 1px solid;'";
$borderside = "border-left: 1px solid;border-right: 1px solid;";
$bordertopbottom = "border-top: 1px solid;border-bottom: 1px solid;";

 switch ($action){
    case "printpreview" :



    $wherestr = " where sf.student_id = st.student_id
                                and st.course_id = cr.course_id
                                and sf.year_id = yr.year_id
                                and sf.session_id = ss.session_id
                                and sf.department_id = dp.department_id
                                and sf.feedback_id = fb.feedback_id
                                and sf.organization_id = $defaultorganization_id ";

        $sql = "select *,
                        (CASE sf.approval_by
                            WHEN 0 THEN
                            ''
                            ELSE
                            (select employee_name from $tableemployee where uid = sf.approval_by  limit 1)
                        END)
                     as approval_name
                    from $tablestudentfeedback sf, $tablestudent st, $tablecourse cr,
                    $tableyear yr, $tablesession ss, $tabledepartment dp, $tablefeedback fb
                    $wherestr
                    and sf.studentfeedback_id = $studentfeedback_id ";

    $rs=$xoopsDB->query($sql);


echo <<< EOF

        <form action="viewsubjectexception.php" method="POST" onsubmit="return confirm('Confirm?')">
        <input type="hidden" name="year_id" value="$year_id">
        <input type="hidden" name="session_id" value="$session_id">
        <input type="hidden" name="action" value="printpreview">
        <input type="hidden" name="issave" value="Y">

        <table style="width:100%;border-collapse:collapse;">

        <tr>
        <td colspan="5">
        <table>
        <tr>
        <th align="left" width="50%" nowrap><tt>FEEDBACK</tt></th>
        <td align="right" width="49%" ><img src="../../images/logo.jpg" width="90" height="63"></td>
        <th align="left" width="1%" nowrap><u><tt>INSTITUT SAINS DAN TEKNOLOGI DARUL TAKZIM</tt></u></th>
        </tr>
        </table>
        
        </td>
        </tr>

        <tr height="50">
        
        </tr>
EOF;

            if($row=$xoopsDB->fetchArray($rs)){

                $student_newicno=$row['student_newicno'];
                $student_name=$row['student_name'];
                $student_no=$row['student_no'];
                $course_no=$row['course_no'];
                $course_name=$row['course_name'];
                $year_name=$row['year_name'];
                $session_name=$row['session_name'];
                $feedback_name=$row['feedback_name'];
                $feedback_date=$row['feedback_date'];
                $department_name=$row['department_name'];
                $feedback_progress=$row['feedback_progress'];
                $feedback_status=$row['feedback_status'];
                $studentfeedback_description=$row['studentfeedback_description'];
                $pic_description=$row['pic_description'];
                $approval_name=$row['approval_name'];
                $approval_date=$row['approval_date'];
                                
               if($approval_date != "0000-00-00")
               $approval_datedesc = $approval_date;
                               
                $selectProgressName = "";
                if($feedback_progress == "H"){
                $selectProgressName = "Hold";
                }else if($feedback_progress == "C"){
                $selectProgressName = "Completed";
                }else{
                $selectProgressName = "In Progress";
                }


                $selectStatusName = "";
                if($feedback_status == "A"){
                $selectStatusName = "Approved";
                }else if($feedback_status == "R"){
                $selectStatusName = "Rejected";
                }else{
                $selectStatusName = "New";
                }


                $studentfeedback_description = str_replace( array("\r\n", "\n","\r"), "<br/>", $studentfeedback_description );
                $studentfeedback_description = str_replace( " ", "&nbsp;", $studentfeedback_description );

                $pic_description = str_replace( array("\r\n", "\n","\r"), "<br/>", $pic_description );
                $pic_description = str_replace( " ", "&nbsp;", $pic_description );

echo <<< EOF
                <tr>
                <td align="center" colspan="2"><tt>SESI <b>$year_name / $session_name</b></tt></td>
                </tr>

                <tr height="50">
                <td align="left" colspan="2"><tt><b>STUDENT DETAILS</b></tt></td>
                </tr>

                <tr height="30">
                <td align="left"><tt><b>NAME : </b>$student_name</tt></td>
                <td align="left"><tt><b>DATE : </b>$feedback_date</tt></td>

                </tr>

                <tr height="30">
                <td align="left" colspan="2"><tt><b>COURSE : </b>$course_name ($course_no)</tt></td>
                </tr>

                <tr height="30">
                <td align="left"><tt><b>IC NO : </b>$student_newicno</tt></td>
                <td align="left"><tt><b>MATRIX NO : </b>$student_no</tt></td>
                </tr>

                <tr>
                <td align="left" $stylebottom colspan="2"></td>
                </tr>

                <tr height="20">
                <td align="left" colspan="2"></td>
                </tr>

                <tr height="30">
                <td align="left"><tt><b>TO DEPARTMENT : </b>$department_name</tt></td>
                <td align="left"><tt><b>TYPE : </b>$feedback_name</tt></td>
                </tr>

                <tr height="20">
                <td align="left" colspan="2"></td>
                </tr>

                <tr height="30">
                <td align="left" colspan="2"><tt><b>FEEDBACK : </b><br>
                $studentfeedback_description
                </tt></td>
                </tr>

                <tr height="30">
                <td align="left" colspan="2"></td>
                </tr>

                <tr>
                <td align="left" $stylebottom colspan="2"></td>
                </tr>

                <tr height="20">
                <td align="left" colspan="2"></td>
                </tr>

                <tr height="30">
                <td align="left" colspan="2"><tt><b>REMARKS (PIC) : </b><br>
                $pic_description
                </tt></td>
                </tr>

                <tr height="30">
                <td align="left" colspan="2"></td>
                </tr>

                <tr>
                <td align="left" $stylebottom colspan="2"></td>
                </tr>

                <tr height="20">
                <td align="left" colspan="2"></td>
                </tr>

                <tr height="30">
                <td align="left" colspan="2"><tt><b>Approval/Review By : </b><br><br>
                $approval_name<br>
                $approval_datedesc<br><br>
                <b>Progress / Status :</b><br>
                $selectProgressName - $selectStatusName
                </tt></td>
                </tr>



        </table></form>

EOF;
                }
    break;
    
  default :

  break;

}

//if($action != "printpreview")
//require(XOOPS_ROOT_PATH.'/footer.php');

?>

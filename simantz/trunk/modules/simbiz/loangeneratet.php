<?php
include "system.php";
include "menu.php";
//include_once 'class/Log.php';
//include_once 'class/Student.php';
//include_once 'class/SelectCtrl.php';
include_once "../../class/datepicker/class.datepicker.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);




//$log = new Log();
//$o = new Student();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$orgctrl="";


$sqlist = "select cr.course_no,cr.course_name,
(select count(*) from $tablestudent st
where st.student_id not in (select student_id from $tablestudentloan)
and st.course_id = cn.course_id and st.organization_id = $defaultorganization_id) as total_student
from $tablecourseloan cn
inner join $tablecourse cr on cr.course_id = cn.course_id
where cn.courseloan_id > 0 and cn.course_id > 0 and cn.isactive = 1
and cn.organization_id = $defaultorganization_id
";


$sqllist2 = "select * from $tablecourse cr
inner join $tablecoursline cl on cl.course_id = cr.course_id
inner join $tablesemester sm on sm.semester_id = cl.semester_id
inner join $tableyear yr on yr.year_id = cl.year_id
inner join $tablesession ss on ss.session_id = cl.session_id
inner join $tablestudent st on st.student_id = cl.student_id
inner join $tablecoursetype ct on ct.coursetype_id = cl.coursetype_id
inner join $tablesubjectclass sc on sc.subjectclass_id = cl.subjectclass_id
inner join $tablesubject sb on sb.subject_id = sc.subject_id
inner join $tableacademicsession as on as.academic_session = sb.academic_session
where cl.employee_id > 0
and cl.isactive = 1
and st.student_id > 0
and ct.isactive = 1 
and ss.session_id > 0
and sb.subject_id > 0 
";

$querylist=$xoopsDB->query($sqlist);

echo <<< EOF
    <table style="width:60%">
    <tr>
    <th colspan="4">Summary Student</th>
    </tr>
    <tr>
    <th align="center">No</th>
    <th align="center">Course</th>
    <th align="center">Remaining Total Student</th>
    </tr>

EOF;

$rowtype = "";
$jk=0;
while($rowlist=$xoopsDB->fetchArray($querylist)){
    $jk++;

    $course_no = $rowlist['course_no'];
    $course_name = $rowlist['course_name'];
    $total_student = $rowlist['total_student'];

    if($rowtype == "even")
    $rowtype = "odd";
    else
    $rowtype = "even";
echo <<< EOF
    <tr>
    <td class="$rowtype" align="center">$jk</td>
    <td class="$rowtype" align="left">$course_name ($course_no)</td>
    <td class="$rowtype" align="center">$total_student</td>
    </tr>
EOF;
}

    if($jk == 0)
    echo "<tr><td colspan='4'>No Remaining Student.</td></tr>";
    //else
    //echo "<tr><td colspan='4' align='right'><font color=red><b>$jk Total Student</b></font></td></tr>";
    
echo <<< EOF
    </table>
    <br>
EOF;
$timestamp= date("y/m/d H:i:s", time()) ;

$createdby=$xoopsUser->getVar('uid');
$updatedby=$xoopsUser->getVar('uid');

if($_POST['isgenerate']=="Y"){

    $sql = "select cn.*,cl.semester_id,cl.line_amt from $tablecourseloan cn
    inner join $tablecourseloanline cl on cl.courseloan_id = cn.courseloan_id
    where cn.isactive = 1 and cn.organization_id = $defaultorganization_id ";

    $query=$xoopsDB->query($sql);
    
    $error = 0;
    $i = 0;
	while($row=$xoopsDB->fetchArray($query)){
    $i++;

    $course_id = $row['course_id'];
    $courseloan_id = $row['courseloan_id'];
    $semester_id = $row['semester_id'];
    $line_amt = $row['line_amt'];
    
        //insert user

        $sqlselectstudent =
        "select student_id,
        $semester_id as semester_id,
        $line_amt as line_amt,
        '$timestamp' as created,
        $updatedby as createdby,
        '$timestamp' as updated,
        $updatedby as updatedby
        from $tablestudent stu
        where stu.course_id = $course_id and stu.isactive = 1
        and (select count(*) from $tablestudentloan
        where student_id = stu.student_id and semester_id = $semester_id) = 0
        order by stu.student_id ";
        
        $sqlinsertuser = "INSERT INTO $tablestudentloan (student_id,semester_id,line_amt,created,createdby,updated,updatedby)
                          $sqlselectstudent;";

        $queryinsertuser=$xoopsDB->query($sqlinsertuser);

        if($queryinsertuser){
            
        }else{
                $error++;
                echo "Failed Create student : $student_no <br>";
        }
        
        //echo "<br>";
    }

    if($error ==0)
    echo "Successfully Generate Student Loan";
}
//above function is to generate timetable with time format (same like format in student module)

echo <<< EOF
    <form action="loangenerate.php" method="POST">
    <input type="hidden" name="isgenerate" value="Y">
    <input type="submit" value="Generate Student Loan">
    </form>
EOF;

function getLatestID(){
    global $xoopsDB,$tableusers;
    
    $retval =0;
    $sql = "select max(uid) as max_id from $tableusers ";

    $query=$xoopsDB->query($sql);

	if($row=$xoopsDB->fetchArray($query)){
        $retval = $row['max_id'];
    }

    return $retval;
}


require(XOOPS_ROOT_PATH.'/footer.php');

?>

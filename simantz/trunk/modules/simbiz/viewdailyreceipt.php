<?php
include "system.php";
//include_once '../system/class/Organization.php';
include_once "../simantz/class/datepicker/class.datepicker.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';

$record_page = "20";
//$log = new Log();
//$o = new Subjectclass();
$s = new XoopsSecurity();
$org = new Organization();
//$ctrl= new SelectCtrl();
$orgctrl="";

echo <<< EOF
    <HEAD>


	<STYLE>
		<!--
	
        
		 -->
	</STYLE>

</HEAD>

EOF;
$action="";

//marhan add here --> ajax
echo "<iframe src='viewsubjectresult.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<script type="text/javascript">

    function checkPrint(){
        checktrue = false;

        var i=0;
        while(i< document.forms['frmList'].elements.length){
        var ctlname = document.forms['frmList'].elements[i].name;
        var data = document.forms['frmList'].elements[i].value;

        ctlname = ctlname.substring(0,ctlname.indexOf("["))
        if(ctlname=="isprintline"){

        if(document.forms['frmList'].elements[i].checked == true)
        checktrue = true;
        }

        i++;

        }

        return checktrue;
    }

    function selectAll(val){

        var i=0;
        while(i< document.forms['frmList'].elements.length){
        var ctlname = document.forms['frmList'].elements[i].name;
        var data = document.forms['frmList'].elements[i].value;

        ctlname = ctlname.substring(0,ctlname.indexOf("["))
        if(ctlname=="isprintline"){

        document.forms['frmList'].elements[i].checked = val;
        }

        i++;

    }
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

if (isset($_POST['session_id']))
$session_id=$_POST["session_id"];
else
$session_id=$_GET["session_id"];

if (isset($_POST['course_id']))
$course_id=$_POST["course_id"];
else
$course_id=$_GET["course_id"];

if (isset($_POST['semester_id']))
$semester_id=$_POST["semester_id"];
else
$semester_id=$_GET["semester_id"];

if (isset($_POST['student_no']))
$student_no=$_POST["student_no"];
else
$student_no=$_GET["student_no"];

if (isset($_POST['student_name']))
$student_name=$_POST["student_name"];
else
$student_name=$_GET["student_name"];

$subject_id=$_POST['subject_id'];

$organization_id=$_POST['organization_id'];
$description=$_POST['description'];
$defaultlevel=$_POST['defaultlevel'];
$createdby=$xoopsUser->getVar('uid');
$updatedby=$xoopsUser->getVar('uid');
$isAdmin=$xoopsUser->isAdmin();

if(isset($_POST['issearch']))
$issearch=$_POST['issearch'];
else
$issearch=$_GET['issearch'];

if ($isactive=="1" || $isactive=="on")
$isactive=1;
else if ($isactive=="null")
$isactive="null";
else
$isactive=0;

$sessionpost_name=$_POST['sessionpost_name'];
$yearpost_name=$_POST['yearpost_name'];
$coursepost_name=$_POST['coursepost_name'];
//$semesterpost_name=$_POST['semesterpost_name'];
$subjectpost_name=$_POST['subjectpost_name'];

$start_date=$_POST['start_date'];
$end_date=$_POST['end_date'];
$startctrl=$dp->show("start_date");
$endctrl=$dp->show("end_date");

$studentpayment_categorypost=$_POST['studentpayment_category'];
$studentpayment_typepost=$_POST['studentpayment_type'];

if($studentpayment_categorypost=="I")
$studentpayment_categoryname = "By Invoice";
else if($studentpayment_categorypost=="O")
$studentpayment_categoryname = "Others";

if($studentpayment_typepost=="C")
$studentpayment_typename = "Cash";
else if($studentpayment_typepost=="Q")
$studentpayment_typename = "Cheque";

 switch ($action){

    case "printpreview" :

    $stylecenter = "style='text-align:center;border: 1px solid;'";
    $styleleft = "style='text-align:left;border: 1px solid;'";
    $styleright = "style='text-align:right;border: 1px solid;'";
    $borderside = "border-left: 1px solid;border-right: 1px solid;";
    $bordertopbottom = "border-top: 1px solid;border-bottom: 1px solid;";
    $borderbottom = "style='border-bottom: 1px solid;'";
    $stylebottom = "style='align:center;border-bottom: 1px solid;'";


    $org->fetchOrganization($defaultorganization_id);

    $organization_name=$org->organization_name;
    $organization_code=$org->organization_code;
    $tel_1= $org->tel_1;
    $tel_2=$org->tel_2;
    $street2=$org->street2;
    $street3=$org->street3;
    $postcode=$org->postcode;
    $city=$org->city;
    $state=$org->state;
    $street1=$org->street1;
    $fax=$org->fax;
    $groupid=$org->groupid;
    $defaultlevel=$org->defaultlevel;
    $url=$org->url;
    $email=$org->email;
    $country_id=$org->country_id;
    $country_name=$org->country_name;
    $currency_name=$org->currency_name;
    $companyno=$org->companyno;

    $sql = "";
    if($_POST){
    $sql= $_POST['sqlpost'];
    $sql = str_replace("#","'",$sql);
    }else{
    echo "Error While Fetch Record.";die;
    }

//$sql = "select si.*,st.student_name,st.student_no,cr.course_name,cr.course_no, sm.semester_name,yr.year_name,ss.session_name from sim_simedu_studentinvoice si inner join sim_simedu_student st on st.student_id = si.student_id inner join sim_simedu_semester sm on sm.semester_id = si.semester_id inner join sim_simedu_session ss on ss.session_id = si.session_id inner join sim_year yr on yr.year_id = si.year_id inner join sim_simedu_course cr on cr.course_id = st.course_id WHERE si.studentinvoice_id>0 and si.organization_id=1 and st.course_id = 4 and si.year_id = 2 and si.session_id = 2 ORDER BY CAST(si.studentinvoice_no AS SIGNED)";
echo <<< EOF

        <HEAD>


        <STYLE>
        <!--
        TD {  font-size:12px }
        h1{
        page-break-before: always;
        }
        -->
        </STYLE>

        </HEAD>

        <title>$menuname</title>

EOF;

        $sum_total = 0;
        $page_number = 1;
        $count_break=0;
        $i=0;
        $query=$xoopsDB->query($sql);
        while ($row=$xoopsDB->fetchArray($query)){
            $i++;
            $count_break++;

            $student_id=$row['student_id'];
            $studentpayment_id=$row['studentpayment_id'];
            $studentpayment_no=$row['studentpayment_no'];
            $student_name=$row['student_name'];
            $student_no=$row['student_no'];
            $course_name=$row['course_name'];
            $course_no=$row['course_no'];
            $semester_name=$row['semester_name'];
            $year_name=$row['year_name'];
            $session_name=$row['session_name'];
            $total_amt=$row['total_amt'];
            $studentpayment_date=$row['studentpayment_date'];
            $studentpayment_category=$row['studentpayment_category'];
            $studentpayment_type=$row['studentpayment_type'];

            $credit_hrs = "$studentpayment_crdthrs1 + $studentpayment_crdthrs2";

            $sum_total += $total_amt;

            $iscomplete=$row['iscomplete'];

            if($studentpayment_category=="I")
            $studentpayment_category = "By Invoice";
            else
            $studentpayment_category = "Others";

            if($studentpayment_type=="C")
            $studentpayment_type = "Cash";
            else
            $studentpayment_type = "Cheque";

            if($iscomplete==0)
            {$iscomplete='N';
            $iscomplete="<b style='color:red;'>N</b>";
            }
            else
            $iscomplete='Y';

             if($count_break == 1){


                if($i>1){
                echo "<h1>";
                $page_number++;
                }

                $stylecategory = "style='display:none'";
                if($studentpayment_categoryname != "")
                $stylecategory = "";

                $styletype = "style='display:none'";
                if($studentpayment_typename != "")
                $styletype = "";


echo <<< EOF

        <table style="width:100%;border-collapse:collapse;">


        <tr>
        <td rowspan="2" width=50% nowrap align="left"><img src="../../images/logo.jpg" width="90" height="63"></td>
        <td align="center" nowrap width=50%><tt><b><font size=3px>$organization_name</font></b></tt></td>
        </tr>

        <tr>
        <td align="center" nowrap><tt><font size=3px>
        $street $street2 $street3 $postcode $city $state<br>
        Tel : $tel_1 / $tel_2 Faks : $fax
        </font></tt></td>
        </tr>

        <tr>
        <td align="left" $stylebottom colspan="2"></td>
        </tr>

        <tr height="20">
        <td align="left" colspan="2"></td>
        </tr>

        <tr>
        <td colspan="2" align="center"><tt><b><u>Cash Receipt Daily Report</u></b></tt></td>
        </tr>

        <tr>
        <td align="left" colspan="2">
        <table border=0 astyle="width:100%">

        <tr>
        <td awidth="25%"><tt><b>Date From </b></tt></td>
        <td awidth="25%"><tt>: $start_date</tt></td>
        <td><tt><b>Date To </b></tt></td>
        <td><tt>: $end_date</tt></td>
        </tr>

        <tr>
        <td awidth="25%" $stylecategory nowrap><tt><b>Payment Type </b></tt></td>
        <td awidth="25%" $stylecategory nowrap><tt>: $studentpayment_category</tt></td>
        <td awidth="25%" $styletype nowrap><tt><b>Payment Method </b></tt></td>
        <td awidth="25%" $styletype nowrap><tt>: $studentpayment_type</tt></td>
        </tr>



        </table>
        </td>
        </tr>

        <tr height="20">
        <td align="left" colspan="2"></td>
        </tr>

        <tr>
        <td colspan="2">
        <table style="width:100%;border-collapse:collapse;">

        <tr>
        <td $stylecenter><tt>No</tt></td>
        <td $stylecenter><tt>Doc No</tt></td>
        <td $stylecenter><tt>Date</tt></td>
        <td $stylecenter><tt>Type/Method</tt></td>
        <td $stylecenter><tt>Student</tt></td>
        <td $stylecenter><tt>Matrix No</tt></td>
        <td $stylecenter><tt>Course</tt></td>
        <td $stylecenter><tt>Amount (RM)</tt></td>
        </tr>
EOF;

        }
echo <<< EOF
        <tr>
        <td  $stylecenter><tt>$i</tt></td>
        <td  $stylecenter><tt>$studentpayment_no</tt></td>
        <td  $stylecenter><tt>$studentpayment_date</tt></td>
        <td  $styleleft nowrap><tt>$studentpayment_category - $studentpayment_type</tt></td>
        <td  $styleleft><tt>$student_name</tt></td>
        <td  $stylecenter><tt>$student_no</tt></td>
        <td  $stylecenter><tt>$course_no</tt></td>
        <td  $stylecenter><tt>$total_amt</tt></td>
        </tr>
EOF;

            if($count_break == $record_page){
            $count_break = 0;
echo <<< EOF
        <tr height="30">
        <td align="left" $stylebottom colspan="9"></td>
        </tr>

        </table>
        </td>
        </tr>

        <tr aheight="30">
        <td align="center" colspan="2"><tt><div id="pageID$page_number"></div></tt></td>
        </tr>

        </table>
EOF;
            }

        }

         $sum_total = number_format($sum_total,2);
         if($i > 0 ){
            echo "<tr><td colspan='7' align='right' $styleright><b>Total (RM)</b></td><th align='center' $stylecenter><tt><b>$sum_total</b></tt></td></tr>";
         }
echo <<< EOF
        <table style="width:100%;border-collapse:collapse;">
        <tr height="30">
        <td align="left" $stylebottom colspan="2"></td>
        </tr>

        <tr aheight="30">
        <td align="center" colspan="2"><tt>== Last Page ==<br>Page Number $page_number / $page_number</tt></td>
        </tr>
        </table>


EOF;
        $updatePage = $page_number - 1;

echo <<< EOF
        <script type='text/javascript'>

           var i=0;

            while(i<$updatePage){
            i++;
            document.getElementById("pageID"+i).innerHTML= "== Continue Next Page ==<br>Page Number "+i+" / "+"$page_number";

            }

        </script>

EOF;
    break;

  case "getlistdbsubject" :
	$strchar = $_POST["strchar"];
	$idinput = $_POST["idinput"];
	$idlayer = $_POST["idlayer"];
	$ctrlid = $_POST["ctrlid"];
	$ocf = $_POST["ocf"];
	$line = $_POST["line"];
    $wherestr = $_POST["wherestr"];

    $wherestr = str_replace("#"," ",$wherestr);
    $wherestr = str_replace("*'","'",$wherestr);
    //echo $wherestr;

	$selectionlist = getSelectDBAjaxSubject($strchar,$idinput,$idlayer,$ctrlid,$ocf,$tablesubject,"subject_id","subject_name"," and isactive =1 $wherestr ","$line");

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
	</script>
EOF;

  break;

    
  default :

    if($course_id=="")
    $course_id = 0;
    if($semester_id=="")
    $semester_id = 0;
    if($year_id=="")
    $year_id = 0;
    if($session_id=="")
    $session_id = 0;
    if($subject_id=="")
    $subject_id = 0;




    //$subjectctrl=$ctrl->getSelectSubject($subject_id,"Y","onchange=updateSubjectType(this.value,$maxcapacity);","subject_id","","subject_id","$widthsubject","Y",0);
    //$lecturerroomctrl=$ctrl->getSelectLecturerroom($lecturerroom_id,"Y");
    $yearctrl=$ctrl->getSelectYear($year_id,"N");
    $sessionctrl=$ctrl->getSelectSession($session_id,"N");
    $coursectrl=$ctrl->getSelectCourse($course_id,"Y");
    $semesterctrl=$ctrl->getSelectSemester($semester_id,"Y");
    $subjectctrl=$ctrl->getSelectSubject($subject_id,"N", "", "subject_id", "", "subject_id","style='width:200px'", "Y", 0);

echo <<< EOF
    <form name="frmSearch" action="viewsubjectresult.php" method="POST" atarget="_blank">
    <input type="hidden" name="issearch" value="Y">
    <table>
    <tr>
    <th colspan="4">Search Criterial</th>
    </tr>

    <tr>
    <td class="head">Session</td>
    <td class="even" colspan="3">$yearctrl $sessionctrl</td>
    </tr>

    <tr>
    <td class="head">Matrix No</td>
    <td class="even"><input name="student_no" value="$student_no"></td>
    <td class="head">Name</td>
    <td class="even"><input name="student_name" value="$student_name">(%MOHD%, SITI%)</td>
    </tr>

    <tr>
    <td class="head">Course</td>
    <td class="even" colspan="3">$coursectrl</td>
    </tr>

    <tr>
    <td class="head">Subject</td>
    <td class="even" colspan="3">$subjectctrl</td>
    </tr>

    <tr style="display:none">
    <td class="head">Semester</td>
    <td class="even" colspan="3">$semesterctrl</td>
    </tr>

    <tr>
    <td colspan="2" colspan="3"><input type="submit" value="Search"></td>
    </tr>

    </table>
    </form>
EOF;

    if($issearch == "Y"){

        $wherestr = " where sg.subject_id = sb.subject_id
                            and sg.student_id = st.student_id
                            and st.course_id = cr.course_id
                            and sg.year_id = yr.year_id
                            and sg.session_id = ss.session_id ";

    if($subject_id >0)
    $wherestr .= " and sg.subject_id = $subject_id ";
    
    if($course_id >0)
    $wherestr .= " and st.course_id = $course_id ";

    if($student_no != "")
    $wherestr .= " and st.student_no like '$student_no' ";
    if($student_name != "")
    $wherestr .= " and st.student_name like '$student_name' ";


    $sql = "select st.student_id,st.student_name,st.student_no,cr.course_name,cr.course_no,
                ss.session_name,sg.subject_result,sg.grade_name,ss.session_name,yr.year_name,sb.subject_name,sb.subject_no,
                st.course_id
                from $tablestudentgrade sg, $tablesubject sb, $tablestudent st,
                        $tablecourse cr, $tableyear yr, $tablesession ss
                        $wherestr
                        and st.organization_id = $defaultorganization_id
                        and sg.year_id = $year_id and sg.session_id = $session_id
                        group by st.student_id
                        order by st.student_no ";
            
        $rs=$xoopsDB->query($sql);

echo <<< EOF
        <form name="frmList" action="viewsubjectresult.php" method="POST" target="_blank">
        <table>
        <input type="hidden" name="action" value="printpreview">
        <input type="hidden" name="year_id" value="$year_id">
        <input type="hidden" name="session_id" value="$session_id">
        <tr>
        <th align="center">No</th>
        <th align="center">Name</th>
        <th align="center">Matrix No</th>
        <th align="center">Course</th>
        <th align="center">Score (100%)</th>
        <th align="center">Grade</th>
        </tr>
EOF;
        $i = 0;
        while($row=$xoopsDB->fetchArray($rs)){
            $i++;

            $student_id = $row['student_id'];
            $student_name = $row['student_name'];
            $student_no = $row['student_no'];
            $course_name = $row['course_name'];
            $course_no = $row['course_no'];
            $subject_result = $row['subject_result'];
            $grade_name = $row['grade_name'];
            
            if($session_id >0)
            $sessionpost_name = $row['session_name'];
            if($year_id >0)
            $yearpost_name = $row['year_name'];
            if($course_id >0)
            $coursepost_name = $row['course_name']." (".$row['course_no'].")";
            if($subject_id >0)
            $subjectpost_name = $row['subject_name']." (".$row['subject_no'].")";
            
            if($rowtype=="even"){
                $rowtype = "odd";
             }else{
                $rowtype = "even";
             }
echo <<< EOF
        <tr>
        <input type="hidden" name="studentline_id[$i]" value="$student_id">
        <td class="$rowtype" align="center">$i</td>
        <td class="$rowtype" align="left">$student_name</td>
        <td class="$rowtype" align="center">$student_no</td>
        <td class="$rowtype" align="center">$course_no</td>
        <td class="$rowtype" align="center">$subject_result</td>
        <td class="$rowtype" align="center">$grade_name</td>

        </tr>
EOF;
        }
        
    
        if($i>0){

                $sql = str_replace("'","#",$sql);
echo <<< EOF
        <input type="hidden" name="sessionpost_name" value="$sessionpost_name">
        <input type="hidden" name="yearpost_name" value="$yearpost_name">
        <input type="hidden" name="coursepost_name" value="$coursepost_name">
        <input type="hidden" name="subjectpost_name" value="$subjectpost_name">
        <textarea name="sqlpost" style="display:none">$sql</textarea>
        <tr>
        <td colspan="6" align="right"><input value="Print Preview" type="submit" ></td>
        </tr>

        <tr height="40" style="display:none">

        <td colspan="5" align="right">
        <input value="Print Transcript" type="submit" aonclick="printForm()">
        <i>(Print selected line)</i>
        <a style="cursor:pointer" onclick="selectAll(true);">Check All</a> /
        <a style="cursor:pointer" onclick="selectAll(false);">Uncheck All</a>
        <img src="images/arrowselright.png">&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
        </tr>
EOF;
        }
        echo "</table></form>";
        }
  break;

}


function getSelectDBAjaxSubject($strchar,$idinput,$idlayer,$ctrlid,$ocf,$table,$primary_key,$primary_name,$wherestr,$line=0){
global $xoopsDB;
	$retval = "";

	$limit = "";
	if($strchar == "")
	$limit = "limit 0";

	$sql = "select $primary_key as fld_id,$primary_name as fld_name,subject_no from $table
		where ($primary_name like '%$strchar%' or subject_no like '%$strchar%' ) and $primary_key > 0 $wherestr
		$limit";

	//$this->log->showLog(4,"With SQL:$sql");
	$query=$xoopsDB->query($sql);

	$rowtypes="";
	$i=0;
	$retval .= "<table style='width:400px'><tr><th>List</th></tr>";
	while ($row=$xoopsDB->fetchArray($query)){
	$i++;
	$fld_name = $row['fld_name'];
	$fld_id = $row['fld_id'];
    $subject_no = $row['subject_no'];

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
	$retval .= "<td>$fld_name ($subject_no)</td>";
	$retval .= "</tr>";
	}


	$retval .= "</table>";

	return $retval;
 	}

if($action != "printpreview")
require(XOOPS_ROOT_PATH.'/footer.php');

?>

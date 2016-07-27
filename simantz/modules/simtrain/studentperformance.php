<?php
include_once 'fpdf/fpdf.php';
include_once 'system.php';
include_once "menu.php";
include_once 'class/TuitionClass.php';
include_once 'class/Period.php';
include_once 'class/Log.php';
include_once './class/Student.php';
include_once './class/Product.php';
include_once './class/ProductCategory.php';

include_once ("datepicker/class.datepicker.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';


 $log=new Log();
 //$o=new TuitionClass($xoopsDB,$tableprefix,$log);
 $pr=new Period($xoopsDB,$tableprefix,$log);
$s= new Student($xoopsDB,$tableprefix,$log);
$category= new ProductCategory($xoopsDB,$tableprefix,$log);
$product= new Product($xoopsDB,$tableprefix,$log);
$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tableemployee=$tableprefix . "simtrain_employee";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tablestudentclass=$tableprefix . "simtrain_studentclass";
$tableperiod=$tableprefix . "simtrain_period";
$tablestandard=$tableprefix . "simtrain_standard";
$tableschool=$tableprefix . "simtrain_school";
$tableorganization=$tableprefix."simtrain_organization";
$tableattendance=$tableprefix."simtrain_attendance";
$tableclassschedule=$tableprefix."simtrain_classschedule";
$tabletest=$tableprefix."simtrain_test";
$tabletestline=$tableprefix."simtrain_testline";
$case="";
$showcalendar1=$dp->show("datefrom");
$showcalendar2=$dp->show("dateto");
$organization_id=$_POST['organization_id'];

if($organization_id=="")
$organization_id=0;


$category_id=$_POST['category_id'];
if($category_id=="")
$category_id=0;
$categoryctrl=$category->getSelectCategory($category_id,'Y');

$product_id=$_POST['product_id'];
if($product_id=="")
$product_id=0;
$productctrl=$product->getSelectProduct($product_id,'C','','Y');

$orgctrl=$permission->selectionOrg($userid,$organization_id);
$student_id=$_POST['student_id'];
if($student_id=="")
$student_id=0;
$studentctrl=$s->getStudentSelectBox($student_id,'Y');
	$datefrom=$_POST['datefrom'];
	$dateto=$_POST['dateto'];
	$test_name=$_POST['test_name'];
	$tuitionclass_code=$_POST['tuitionclass_code'];

//require(XOOPS_ROOT_PATH.'/header.php');
echo <<< EOF

<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Student Performance Report</span></big></big></big></div><br>-->
<FORM action="studentperformance.php" method="POST" >
	<table border='1'>
	<tbody>
	  <tr>
		<th colspan="7">Criterial Performance Report</th>
	  </tr>
	  <tr>
		<td class="head">Student</td>
		<td class="odd">$studentctrl</td>
		<td class="head">Product</td>
		<td class="odd">$productctrl</td>
	</tr>
<tr>
		<td class="head">Date From</td>
		<td class="odd"><input name="datefrom" id="datefrom" value='$datefrom'><input type="button" value='Date' onclick="$showcalendar1"></td>

		<td class="head">Date To</td>
		<td class="odd"><input id="dateto" name="dateto" value='$dateto'><input type="button" value='Date' onclick="$showcalendar2"></td>

			</tr>
	  <tr>
		<td class="head">Test Name</td>
		<td class="odd"><Input name='test_name' value="$test_name"></td>
		<td class="head">Class Code</td>
		<td class="odd"><Input name='tuitionclass_code' value="$tuitionclass_code"></td>
	</tr>

		<tr>
		<td class="head" colspan='4'><input type="submit" value="Search" name="submit">
				<input type="reset" value="reset" name="reset"></td>
	<tr>
	
	  </tbody>
	</table>
	</FORM>
EOF;
if (isset($_POST['submit'])) {

	//processing parameter
	$wherestring="";

	if($_POST['datefrom']!="")
		$datefrom=$_POST['datefrom'];
	else
		$datefrom="0000-00-00";

	if($_POST['dateto']!="")
		$dateto=$_POST['dateto'];
	else
		$dateto='9999-12-31';

	//generating table header
	echo <<< EOF
<table border='1'>
  <tbody>
    <tr>
      <th colspan="15">Test History</th>
    </tr>
    <tr>
      <th style="text-align:center;">No</th>
      <th style="text-align:center;">Date</th>
      <th style="text-align:center;">Organization</th>
      <th style="text-align:center;">Student</th>
      <th style="text-align:center;">Class Code</th>
      <th style="text-align:center;">Class Description</th>
      <th style="text-align:center;">Test Name</th>
      <th style="text-align:center;">Result</th>
      <th style="text-align:center;">Test Description</th>
      <th style="text-align:center;">Product</th>
    </tr>

EOF;

	$wherestring="(date(t.testdate) between '$datefrom' and '$dateto')";
	if($student_id>0)
		$wherestring =$wherestring . " AND s.student_id=$student_id";
	if($product_id>0)
		$wherestring=$wherestring ." AND pd.product_id = $product_id";

	if($test_name !="")
		$wherestring=$wherestring ." AND t.test_name LIKE '$test_name'";


	if($tuitionclass_code !="")
		$wherestring=$wherestring ." AND tc.tuitionclass_code LIKE '$tuitionclass_code'";

	$wherestring="WHERE $wherestring";
	$orderbystring="order by t.testdate,tc.tuitionclass_code";
	//$viewname=$tableprefix."simtrain_qryfeestransaction";
	//$sql="SELECT uid,uname,student_name, payment_datetime,fees,transportamt,returnamt,docno,type FROM $viewname $wherestring ".
	//	" order by payment_datetime ";

	$sql=" SELECT  s.student_id,concat(s.alternate_name,'/',s.student_name) as student_name, 
		tc.tuitionclass_id,o.organization_code, tc.tuitionclass_code, 
		t.testdate, tc.description as tcdescription, pd.product_name,
		tl.description as tldescription,tl.result,t.test_name, t.test_id
		FROM $tabletestline tl
		inner join $tabletest t on t.test_id=tl.test_id
		inner join $tablestudent s on s.student_id=tl.student_id
		INNER join $tabletuitionclass tc on t.tuitionclass_id = tc.tuitionclass_id
		INNER join $tableproductlist pd on tc.product_id=pd.product_id
		inner join $tableorganization o on tc.organization_id=o.organization_id
		$wherestring and s.organization_id = $defaultorganization_id $orderbystring ";


	$log->showLog(3,"Producing Outstanding Payment Report for Registration $datefrom ~ $dateto");
	$log->showLog(4,"With SQL: $sql");
	$query=$xoopsDB->query($sql);
	$total=0;
	$rowtype="";
	$i=0;


	while($row=$xoopsDB->fetchArray($query)){
		$i++;
		$student_id=$row['student_id'];
		$student_name=$row['student_name'];

		$tuitionclass_id=$row['tuitionclass_id'];
		$organization_code=$row['organization_code'];
		$tuitionclass_code=$row['tuitionclass_code'];
		$test_id=$row['test_id'];
		$product_name=$row['product_name'];
		$testdate=$row['testdate'];
		$tcdescription=$row['tcdescription'];
		$tldescription=$row['tldescription'];
		$test_name=$row['test_name'];
		$result=$row['result'];
		$zoomctrl="";

	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";


	echo <<< EOF
		<tr>
			<td class="$rowtype" style="text-align:left;">$i</td>
			<td class="$rowtype" style="text-align:right;">$testdate</td>
			<td class="$rowtype" style="text-align:left;">$organization_code</td>
			<td class="$rowtype" style="text-align:left;">
				<A href="student.php?student_id=$student_id&action=edit">$student_name</a></td>
			<td class="$rowtype" style="text-align:left;">
				<A href='tuitionclass.php?action=edit&tuitionclass_id=$tuitionclass_id'>
					$tuitionclass_code
				</a>
			</td>
			<td class="$rowtype" style="text-align:left;">$tcdescription</td>
			<td class="$rowtype" style="text-align:left;">
				<A href='test.php?action=edit&test_id=$test_id'>
					$test_name
				</a>
			</td>
			<td class="$rowtype" style="text-align:left;">$result</td>


			<td class="$rowtype" style="text-align:center;">$tldescription</td>
			<td class="$rowtype" style="text-align:center;">$product_name</td>


		</tr>
EOF;
	}
	
	echo <<< EOF
	
		</tbody></table>
		<form action="viewoutstandingpayment.php" method="POST">
			<input type="hidden" name="datefrom" value="$datefrom">
			<input type="hidden" name="dateto" value="$dateto">
			<input type="hidden" name="wherestring" value="$wherestring">
			<input type="hidden" name="orderbystring" value="$orderbystring">
			</form>
EOF;

}
	echo "</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');

?>
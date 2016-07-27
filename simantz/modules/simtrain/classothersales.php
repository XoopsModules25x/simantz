<?php
include_once 'fpdf/fpdf.php';
include_once 'system.php';
include_once "menu.php";
include_once 'class/TuitionClass.php';
include_once 'class/Period.php';
include_once 'class/Log.php';
//include_once 'class/Employee.php';
include_once './class/Student.php';
include_once ("datepicker/class.datepicker.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';


 $log=new Log();
 //$o=new TuitionClass($xoopsDB,$tableprefix,$log);
 $pr=new Period($xoopsDB,$tableprefix,$log);
$s= new Student($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);

$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tableemployee=$tableprefix . "simtrain_employee";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tablestudentclass=$tableprefix . "simtrain_studentclass";
$tableperiod=$tableprefix . "simtrain_period";
$tablepaymentline=$tableprefix."simtrain_paymentline";
$tablepayment=$tableprefix."simtrain_payment";
$tableinventorymove=$tableprefix . "simtrain_inventorymovement";
$tableorganization=$tableprefix . "simtrain_organization";


$tableusers=$tableprefix."users";
$case="";
$showcalendar1=$dp->show("datefrom");
$showcalendar2=$dp->show("dateto");
$studentctrl=$s->getStudentSelectBox(-1);
$userctrl=$permission->selectAvailableSysUser(0,'Y');
$organization_id=$_POST['organization_id'];

if($organization_id=="")
$organization_id=$defaultorganization_id;

$orgctrl=$permission->selectionOrg($userid,$organization_id);

//require(XOOPS_ROOT_PATH.'/header.php');
echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Registration and Other Sales Report</span></big></big></big></div><br>-->
<FORM action="classothersales.php" method="POST">
	<table border='1'>
	<tbody>
	  <tr>
		<th colspan="7">Registration & In/Out Sales History</th>
	  </tr>
<tr>
<td class="head">Organization</td><td class="odd">$orgctrl</td>
		<td class="head">Transaction Type</td>
		<td class="odd"><SELECT name='transactiontype'>
					<OPTION value='-'>Null</OPTION>
					<OPTION value='class'>Classes</OPTION>
					<OPTION value='item'>Items</OPTION>
				</SELECT></td>
	</tr>	 
	  <tr>
		<td class="head">Student</td>
		<td class="odd">$studentctrl</td>
		<td class="head">User</td>
		<td class="odd">$userctrl</td>

	  </tr>
	  <tr>
		<td class="head">Date From</td>
		<td class="odd"><input name="datefrom" id="datefrom"><input type="button" value='Date' onclick="$showcalendar1"></td>
		<td class="head">Date To</td>
		<td class="odd"><input id="dateto" name="dateto"><input type="button" value='Date' onclick="$showcalendar2"></td>
	</tr>
 <tr>
<td class="head" colspan='4'><input type="submit" value="Search" name="submit">
				<input type="reset" value="reset" name="reset"></td>
	  </tr>


	
	  </tbody>
	</table>
	</FORM>
EOF;
if (isset($_POST['submit'])){

	//processing parameter
	$wherestring="";


	$student_id=$_POST['student_id'];

	$uid=$_POST['uid'];

	$transactiontype=$_POST['transactiontype'];



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
      <th colspan="11">Transaction History</th>
    </tr>
    <tr>
      <th style="text-align:center;">No</th>
      <th style="text-align:center;">Organization</th>
      <th style="text-align:center;">User</th>
      <th style="text-align:center;">Student Code</th>
      <th style="text-align:center;">Student Name</th>
      <th style="text-align:center;">Type</th>
      <th style="text-align:center;">Code</th>
      <th style="text-align:center;">Description</th>
      <th style="text-align:center;">Date</th>
      <th style="text-align:center;">Fees($cur_symbol)</th>
      <th style="text-align:center;">Transport($cur_symbol)</th>

    </tr>
  
EOF;

	$wherestring="(date(sc.transactiondate) between '$datefrom' and '$dateto') AND";
	if($student_id>0)
		$wherestring =$wherestring . " (s.student_id=$student_id) AND";

	if($uid>0)
		$wherestring =$wherestring . " (sc.createdby=$uid) AND";

	if ($transactiontype=='class')
		$wherestring =$wherestring . " (sc.movement_id=0) AND";
	elseif($transactiontype=='item')
		$wherestring = $wherestring . " (sc.tuitionclass_id=0) AND";
	
	$wherestring="WHERE" . substr_replace($wherestring,"",-3); 
	//$viewname=$tableprefix."simtrain_qryfeestransaction";
	//$sql="SELECT uid,uname,student_name, payment_datetime,fees,transportamt,returnamt,docno,type FROM $viewname $wherestring ".
	//	" order by payment_datetime ";

	$sql=" SELECT s.student_id,s.student_code,s.alternate_name, s.student_name, sc.tuitionclass_id,sc.movement_id,
		 (CASE WHEN tc.tuitionclass_id >0 
				THEN tc.tuitionclass_code ELSE pd.product_no END ) as code, sc.transactiondate,  
		   (CASE WHEN tc.tuitionclass_id >0 THEN tc.description
				ELSE concat(pd.product_name,'x',i.quantity) END ) as name, sc.amt,sc.transportfees, 
		   (CASE WHEN tc.tuitionclass_id >0 THEN o1.organization_code
				ELSE o2.organization_code END) as organization_code ,u.uname 
		 FROM $tablestudentclass sc 
		 inner join $tablestudent s on s.student_id=sc.student_id 
		 left join $tabletuitionclass tc on sc.tuitionclass_id = tc.tuitionclass_id 
		 left join $tableinventorymove i on sc.movement_id = i.movement_id 
		 left join $tableproductlist pd on i.product_id=pd.product_id 
		 left join $tableorganization o1 on o1.organization_id=tc.organization_id 
		 left join $tableorganization o2 on o2.organization_id=i.organization_id 
		 left join $tableusers u on sc.createdby=u.uid
		 $wherestring and sc.studentclass_id > 0 AND
		 (CASE WHEN tc.tuitionclass_id >0 
				THEN o1.organization_id ELSE o2.organization_id END ) =$organization_id
		 order by sc.transactiondate desc, s.student_name  , sc.created";

	
	$log->showLog(3,"Producing transaction Report for Registration $datefrom ~ $dateto");
	$log->showLog(4,"With SQL: $sql");
	$query=$xoopsDB->query($sql);
	$total=0;
	$rowtype="";
	$i=0;
	$totalfees=0;
	$totaltransport=0;
	$totalpaid=0;
	$totaldue=0;

	while($row=$xoopsDB->fetchArray($query)){
		$i++;
		$student_id=$row['student_id'];
		$student_name=$row['student_name'];
		$organization_code=$row['organization_code'];
		$alternate_name=$row['alternate_name'];
		$tuitionclass_id=$row['tuitionclass_id'];
		$code=$row['code'];
		$organization_code=$row['organization_code'];
		$name=$row['name'];
		$uname=$row['uname'];
		$student_code=$row['student_code'];
		$period_name=$row['period_name'];
		$transactiondate=$row['transactiondate'];
		$amt=$row['amt'];
		$transportfees=$row['transportfees'];
		$paid=$row['paid'];
		$paiddate=$row['paiddate'];
		$paidto=$row['paidto'];
		$due=$row['due'];
		$totalfees=$totalfees+$amt;
		$totaltransport=$totaltransport+$transportfees;
		$totalpaid=$totalpaid+$paid;
		$totaldue=$totaldue+$due;
		$movement_id=$row['movement_id'];
	if($movement_id>0)
		$type='Item';
	else
		$type='Class';

	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";
	echo <<< EOF
		<tr>
			<td class="$rowtype" style="text-align:left;">$i</td>
			<td class="$rowtype" style="text-align:left;">$organization_code</td>
			<td class="$rowtype" style="text-align:left;">$uname</td>
			<td class="$rowtype" style="text-align:left;">$student_code</td>
			<td class="$rowtype" style="text-align:left;">
				<a href="student.php?action=edit&student_id=$student_id" target="_blank">
				$alternate_name/$student_name</a>
			</td>
			<td class="$rowtype" style="text-align:left;">$type</td>
			<td class="$rowtype" style="text-align:left;">$code</td>
			<td class="$rowtype" style="text-align:left;">$name</td>
			<td class="$rowtype" style="text-align:right;">$transactiondate</td>

			<td class="$rowtype" style="text-align:right;">$amt</td>
			<td class="$rowtype" style="text-align:right;">$transportfees</td>
		</tr>
EOF;
	}
		$totalfees=number_format($totalfees,2);
		$totaltransport=number_format($totaltransport,2);
		$totalpaid=number_format($totalpaid,2);
		$totaldue=number_format($totaldue,2);
	echo <<< EOF
	<tr>
		<th style="text-align:center;"></th>
		<th style="text-align:center;"></th>
		<th style="text-align:center;"></th>
		<th style="text-align:center;"></th>
		<th style="text-align:center;"></th>
		<th style="text-align:center;">Total($cur_symbol)</th>
		<th style="text-align:center;"></th>
		<th style="text-align:center;"></th>
		<th style="text-align:center;"></th>
		<th style="text-align:right;">$totalfees</th>
		<th style="text-align:right;">$totaltransport</th>

	</tr>
		</tbody></table>
		<form action="viewclassothersales.php" method="POST">
			<input type="hidden" name="datefrom" value="$datefrom">
			<input type="hidden" name="dateto" value="$dateto">
			<input type="hidden" name="wherestring" value="$wherestring">
			<input type="submit" value="pdf" name="submit" style="height:40px; font-size:25">
			</form>
EOF;

}
	echo "</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');

?>
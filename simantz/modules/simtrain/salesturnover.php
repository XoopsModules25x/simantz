<?php
include_once 'system.php';
include_once "menu.php";
include_once 'class/TuitionClass.php';
include_once 'class/Period.php';
include_once 'class/ProductCategory.php';
include_once 'class/Log.php';
//include_once 'class/Permission.php';
include_once './class/Student.php';
include_once './class/Standard.php';


include_once ("datepicker/class.datepicker.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

 $log=new Log();

 //$o=new TuitionClass($xoopsDB,$tableprefix,$log);
$pr=new Period($xoopsDB,$tableprefix,$log);
$s= new Student($xoopsDB,$tableprefix,$log);
$std= new Standard($xoopsDB,$tableprefix,$log);
$category= new ProductCategory($xoopsDB,$tableprefix,$log);
//$e=new Permission($xoopsDB,$tableprefix,$log);

$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tableemployee=$tableprefix . "simtrain_employee";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tablestudentclass=$tableprefix . "simtrain_studentclass";
$tableperiod=$tableprefix . "simtrain_period";
$tablepaymentline=$tableprefix."simtrain_paymentline";
$tablepayment=$tableprefix."simtrain_payment";
$tableusers=$tableprefix."users";
$case="";
$showcalendar1=$dp->show("datefrom");
$showcalendar2=$dp->show("dateto");

	//processing parameter
$wherestring="";

$student_id=$_POST['student_id'];
$standard_id=$_POST['standard_id'];
	
if($standard_id=="")
$standard_id=0;


if($_POST['datefrom']!="")
	$datefrom=$_POST['datefrom'];


if($_POST['dateto']!="")
	$dateto=$_POST['dateto'];


$category_id=$_POST['category_id'];
if($category_id=="")
$category_id=0;

$categoryctrl=$category->getSelectCategory($category_id,Y);
$studentctrl=$s->getStudentSelectBox(-1);
$standardctrl=$std->getSelectStandard($standard_id,'Y');

$organization_id=$_POST['organization_id'];

if($organization_id =="")
$organization_id=$defaultorganization_id;

$orgctrl=$permission->selectionOrg($userid,$organization_id);

//require(XOOPS_ROOT_PATH.'/header.php');
echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Sales Turn Over Report</span></big></big></big></div><br>-->
<FORM action="salesturnover.php" method="POST">
	<table border='1'>
	<tbody>
	  <tr>
		<th colspan="4">Filter Criterial</th>
	  </tr>
	  <tr>
		<td class="head">Organization</td>
		<td class="odd">$orgctrl</td>
		<td class="head">Student</td>
		<td class="odd">$studentctrl</td>

	
  </tr>
		</tr><tr>
		<td class="head">Date From</td>
		<td class="odd"><input name="datefrom" id="datefrom" value="$datefrom"><input type="button" value='Date' onclick="$showcalendar1"></td>

		<td class="head">Date To</td>
		<td class="odd"><input id="dateto" name="dateto"  value="$dateto"><input type="button" value='Date' onclick="$showcalendar2"></td>
	</tr>
	<tr>


		<td class="head">Category</td>
		<td class='even'>$categoryctrl</td>
		<td class="head">Standard</td>
		<td class="even">$standardctrl</td>

	  </tr>
	
		<tr>
		<td class="even" colspan="4"><input type="submit" value="Search" name="submit">
				<input type="reset" value="reset" name="reset"></td>

	  </tr>
	

	  </tbody>
	</table>
	</FORM>
EOF;


if (isset($_POST['submit'])){

	//generating table header
	echo <<< EOF
<table>
  <tbody>
    <tr>
      <th colspan="15">Sales Turn Over<form action="viewsalesturnover.php" method="POST" name='frmViewSalesTurnOver'></th>
    </tr>
    <tr>
      <th style="text-align:center;">No</th>
	<th style="text-align:center;">Student No</th>
      <th style="text-align:center;">Name</th>
      <th style="text-align:center;">Standard</th>
      <th style="text-align:center;">Type</th>
      <th style="text-align:center;">Code</th>
      <th style="text-align:center;">Description</th>
      <th style="text-align:center;">Category</th>
      <th style="text-align:center;">Date</th>
      <th style="text-align:center;">Fees($cur_symbol)</th>
      <th style="text-align:center;">Transport($cur_symbol)</th>
      <th style="text-align:center;">Paid($cur_symbol)</th>
      <th style="text-align:center;">Paid Due($cur_symbol)</th>
      <th style="text-align:center;">Paid Date</th>
      <th style="text-align:center;">Paid To</th>
    </tr>
  
EOF;

if($_POST['datefrom']!="")
	$datefrom=$_POST['datefrom'];
else
	$datefrom="0000-00-00";

if($_POST['dateto']!="")
	$dateto=$_POST['dateto'];
else
	$dateto='9999-12-31';

	$organization_code=$_POST['organization_code'];
	$wherestring="(date(sc.transactiondate) between '$datefrom' and '$dateto' and
			(CASE WHEN tc.tuitionclass_id >0 
				THEN tc.organization_id ELSE i.organization_id END) = $organization_id)";
	if($student_id>0)
		$wherestring =$wherestring . " AND s.student_id=$student_id";
	else
		$wherestring =$wherestring . " AND s.student_id>$student_id";

	if($category_id>0)
		$wherestring=$wherestring." AND  (CASE WHEN tc.tuitionclass_id >0 THEN c2.category_id
				ELSE c1.category_id END ) =$category_id";
	else
		$wherestring=$wherestring." AND (CASE WHEN tc.tuitionclass_id >0 THEN c2.category_id
				ELSE c1.category_id END ) >0";

	if($standard_id > 0)
	$wherestring .= " and st.standard_id = $standard_id ";
	
	$orderbystring="order by sc.transactiondate, (CASE WHEN tc.tuitionclass_id >0 THEN tc.tuitionclass_code ELSE pd.product_no END )";
	//$viewname=$tableprefix."simtrain_qryfeestransaction";
	//$sql="SELECT uid,uname,student_name, payment_datetime,fees,transportamt,returnamt,docno,type FROM $viewname $wherestring ".
	//	" order by payment_datetime ";

	$sql=" SELECT sc.studentclass_id, s.student_id, concat(s.alternate_name, '/',  s.student_name) as student_name, sc.tuitionclass_id,sc.movement_id,student_code,standard_name,
		(CASE WHEN tc.tuitionclass_id >0 
				THEN tc.tuitionclass_code ELSE pd.product_no END ) as code, sc.transactiondate,
		(CASE WHEN tc.tuitionclass_id >0 THEN  tc.description
				ELSE concat(pd.product_name,' x ', -1*i.quantity) END ) as name, 
		(CASE WHEN tc.tuitionclass_id >0 THEN c2.category_code
				ELSE c1.category_code END ) as category_code,
		sc.amt,sc.transportfees,
		coalesce((select sum(pl.amt) from sim_simtrain_paymentline pl
		inner join sim_simtrain_payment p on p.payment_id=pl.payment_id where
		pl.studentclass_id=sc.studentclass_id and p.iscomplete='Y'),0) as paid,
		(select DATE(max(p.payment_datetime)) from sim_simtrain_paymentline pl
			inner join sim_simtrain_payment p on p.payment_id=pl.payment_id
			where pl.studentclass_id=sc.studentclass_id and p.iscomplete='Y') as paiddate,
		(select uname from sim_users where uid=(select max(p.createdby) from sim_simtrain_paymentline pl
			inner join sim_simtrain_payment p on p.payment_id=pl.payment_id 
			where pl.studentclass_id=sc.studentclass_id and p.iscomplete='Y')) as paidto,
		sc.amt+sc.transportfees-coalesce((select sum(pl.amt) from sim_simtrain_paymentline pl
			inner join sim_simtrain_payment p on p.payment_id=pl.payment_id
			where pl.studentclass_id=sc.studentclass_id and p.iscomplete='Y'),0) as due
		FROM sim_simtrain_studentclass sc
		inner join sim_simtrain_student s on s.student_id=sc.student_id
		left join sim_simtrain_tuitionclass tc on sc.tuitionclass_id = tc.tuitionclass_id
		left join sim_simtrain_inventorymovement i on sc.movement_id = i.movement_id
		inner join sim_simtrain_productlist pd on i.product_id=pd.product_id
		inner join sim_simtrain_productlist tpd on tpd.product_id=tc.product_id	
		inner join sim_simtrain_productcategory c1 on c1.category_id=pd.category_id
		inner join sim_simtrain_productcategory c2 on c2.category_id=tpd.category_id
		inner join sim_simtrain_standard st on st.standard_id=s.standard_id 
		WHERE $wherestring $orderbystring";


	$log->showLog(3,"Producing Outstanding Payment Report for Registration $datefrom ~ $dateto");
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
		$student_code=$row['student_code'];
		$student_name=$row['student_name'];
		$standard_name=$row['standard_name'];
		$tuitionclass_id=$row['tuitionclass_id'];
		$code=$row['code'];
		$name=$row['name'];
		$studentclass_id=$row['studentclass_id'];
		$period_name=$row['period_name'];
		$transactiondate=$row['transactiondate'];
		$amt=$row['amt'];
		$transportfees=$row['transportfees'];
		$paid=$row['paid'];
		$paiddate=$row['paiddate'];
		$category_code=$row['category_code'];
		$paidto=$row['paidto'];
		$due=$row['due'];
		$totalfees=$totalfees+$amt;
		$totaltransport=$totaltransport+$transportfees;
		$totalpaid=$totalpaid+$paid;
		$totaldue=$totaldue+$due;
		$movement_id=$row['movement_id'];
		$zoomctrl="";

	if($movement_id>0){
		$type='Item';
		$zoomctrl="<a href='regproduct.php?action=edit&studentclass_id=$studentclass_id' target='_blank'>$code</a>";

	}
	else{
		$type='Class';
		$zoomctrl="<a href='regclass.php?action=edit&studentclass_id=$studentclass_id' target='_blank'>$code</a>";

	}
	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";
	
	echo <<< EOF
		<tr>
			<td class="$rowtype" style="text-align:left;">$i</td>
			<td class="$rowtype" style="text-align:left;">$student_code</td>
			<td class="$rowtype" style="text-align:left;">
				<a href="student.php?action=edit&student_id=$student_id" target="_blank">
				$student_name</a>
			</td>
			<td class="$rowtype" style="text-align:left;">$standard_name</td>
			<td class="$rowtype" style="text-align:left;">$type</td>
			<td class="$rowtype" style="text-align:left;">$zoomctrl</td>
			<td class="$rowtype" style="text-align:left;">$name</td>
			<td class="$rowtype" style="text-align:left;">$category_code</td>
			<td class="$rowtype" style="text-align:right;">$transactiondate</td>

			<td class="$rowtype" style="text-align:right;">$amt</td>
			<td class="$rowtype" style="text-align:right;">$transportfees</td>
			<td class="$rowtype" style="text-align:right;">$paid</td>
			<td class="$rowtype" style="text-align:right;">$due</td>
			<td class="$rowtype" style="text-align:right;">$paiddate</td>
			<td class="$rowtype" style="text-align:right;">$paidto</td>
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
		<th style="text-align:center;">Total($cur_symbol)</th>
		<th style="text-align:center;"></th>
		<th style="text-align:center;"></th>
		<th style="text-align:center;"></th>
		<th style="text-align:center;"></th>
		<th style="text-align:center;"></th>
		<th style="text-align:center;"></th>
		<th style="text-align:right;">$totalfees</th>
		<th style="text-align:right;">$totaltransport</th>
		<th style="text-align:right;">$totalpaid</th>
		<th style="text-align:right;">$totaldue</th>
		<th style="text-align:center;"></th>
		<th style="text-align:center;"></th>

	</tr>
		</tbody></table>
		
			<input type="hidden" name="datefrom" value="$datefrom">
			<input type="hidden" name="dateto" value="$dateto">
			<input type="hidden" name="student_id" value="$student_id">
			<input type="hidden" name="organization_code" value="$organization_code">
			<input type="hidden" name="organization_id" value="$organization_id">
			<input type="hidden" name="wherestring" value="$wherestring">
			<input type="hidden" name="orderbystring" value="$orderbystring">
			<input type="submit" value="PDF" name="submit" style="height:40px; font-size:25">
			</form>
EOF;

}
	echo "</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');

?>
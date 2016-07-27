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
include_once 'class/Product.php';

include_once ("datepicker/class.datepicker.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

 $log=new Log();

 //$o=new TuitionClass($xoopsDB,$tableprefix,$log);
$p=new Product($xoopsDB,$tableprefix,$log);
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
$showcalendar3=$dp->show("classjoindate");

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

$student_name  = $_POST['student_name'];
$alternate_name = $_POST['alternate_name'];
$student_code = $_POST['student_code'];
$tuitionclass_code = $_POST['tuitionclass_code'];
$classjoindate = $_POST['classjoindate'];
//$product_id = $_POST['product_id'];
//$period_id = $_POST['period_id'];

$category_id=$_POST['category_id'];
if($category_id=="")
$category_id=0;

$product_id=$_POST['product_id'];
if($product_id=="")
$product_id=0;

$period_id=$_POST['period_id'];

$isactive=$_POST['isactive'];
if($period_id=="")
$period_id=0;

$categoryctrl=$category->getSelectCategory($category_id,Y);
$studentctrl=$s->getStudentSelectBox($student_id,"Y");
$standardctrl=$std->getSelectStandard($standard_id,'Y');
$productctrl=$p->getSelectProduct($product_id,'','','Y');
$periodctrl=$pr->getPeriodList($period_id,'period_id','Y');

$organization_id=$_POST['organization_id'];

if($organization_id =="")
$organization_id=$defaultorganization_id;

$orgctrl=$permission->selectionOrg($userid,$organization_id);

//require(XOOPS_ROOT_PATH.'/header.php');
echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Sales Turn Over Report</span></big></big></big></div><br>-->
<FORM action="viewregsummaryreport.php" method="POST">
	<table border='1'>
	<tbody>
	  <tr>
		<th colspan="4">Filter Criterial</th>
	  </tr>
	  <tr>
		<td class="head">Organization</td>
		<td class="even" colspan="3">$orgctrl</td>
  	</tr>

	<tr>
	<td class="head">Student</td>
	<td class="even">$studentctrl</td>
	<td class="head">Student Name</td>
	<td class="even"><input name="student_name" value="$student_name"></td>
	</tr>

	<tr>
	<td class="head">Alternate Name</td>
	<td class="even"><input name="alternate_name" value="$alternate_name"></td>
	<td class="head">Student Code</td>
	<td class="even"><input name="student_code" value="$student_code"></td>
	</tr>

	<tr>	
	<td class="head">Class Code</td>
	<td class="even"><input name="tuitionclass_code" value="$tuitionclass_code"></td>
	<td class="head">Class Join Date</td>
	<td class="even">
	<input name="classjoindate" value="$classjoindate" id="classjoindate">
	<input type="button" value='Date' onclick="$showcalendar3">
	</td>
	</tr>

	<tr>
		<td class="head">Date From</td>
		<td class="even"><input name="datefrom" id="datefrom" value="$datefrom"><input type="button" value='Date' onclick="$showcalendar1"></td>

		<td class="head">Date To</td>
		<td class="even"><input id="dateto" name="dateto"  value="$dateto"><input type="button" value='Date' onclick="$showcalendar2"></td>
	</tr>

	<tr>
	<td class="head">Category</td>
	<td class='even'>$categoryctrl</td>
	<td class="head">Standard</td>
	<td class="even">$standardctrl</td>
	</tr>

	<tr>
	<td class="head">Product</td>
	<td class='even'>$productctrl</td>
	<td class="head">Period</td>
	<td class="even">$periodctrl</td>
	</tr>
		<tr>
	<td class="head">Active/Continue Class Next Month</td>
	<td class='even'><select name='isactive'>
				<option value="">Null</option><option value='Y'>Yes</option><option value="N">No</option>
			</select></td>
	<td class="head"></td>
	<td class="even"></td>
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
      <th colspan="17">Registration Summary<form action="viewsalesturnover.php" method="POST" name='frmViewSalesTurnOver'></th>
    </tr>

	<tr>
	<th style="text-align:center;">No</th>
	<th style="text-align:center;">Period</th>
	<th style="text-align:center;">Student No</th>
	<th style="text-align:center;">Name</th>
	<th style="text-align:center;">Code</th>
	<th style="text-align:center;">Product</th>
	<th style="text-align:center;">Category</th>
	<th style="text-align:center;">Class Name</th>
	<th style="text-align:center;">Transport Come</th>
	<th style="text-align:center;">Transport Back</th>
	<th style="text-align:center;">Fees($cur_symbol)</th>
	<th style="text-align:center;">Transport($cur_symbol)</th>
	<th style="text-align:center;">Description</th>
	<th style="text-align:center;">Class Join Date</th>
	<th style="text-align:center;">Transaction Date</th>
	<th style="text-align:center;">Total Month</th>
	<th style="text-align:center;">Continue</th>
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
				THEN tc.organization_id ELSE i.organization_id END) = $organization_id) and pr.period_id>0";
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


	
	
	// where list
	if($student_name != "")
	$wherestring .= " and s.student_name like '$student_name' ";
	if($alternate_name != "")
	$wherestring .= " and s.alternate_name like '$alternate_name' ";
	if($student_code != "")
	$wherestring .= " and s.student_code like '$student_code' ";
	if($tuitionclass_code != "")
	$wherestring .= " and tc.tuitionclass_code like '$tuitionclass_code' ";
	if($classjoindate != "")
	$wherestring .= " and sc.classjoindate like '$classjoindate' ";
	if($product_id > 0)
	$wherestring .= " and tpd.product_id = $product_id ";
	if($period_id > 0)
	$wherestring .= " and pr.period_id = $period_id ";
	if($isactive !="")
	$wherestring .= " and sc.isactive = '$isactive' ";
	//
	
	$orderbystring="order by sc.transactiondate, (CASE WHEN tc.tuitionclass_id >0 THEN tc.tuitionclass_code ELSE pd.product_no END )";
	//$viewname=$tableprefix."simtrain_qryfeestransaction";
	//$sql="SELECT uid,uname,student_name, payment_datetime,fees,transportamt,returnamt,docno,type FROM $viewname $wherestring ".
	//	" order by payment_datetime ";

	$sql=" SELECT sc.studentclass_id, s.student_id, concat(s.alternate_name, '/',  s.student_name) as student_name,
		sc.tuitionclass_id,sc.movement_id,student_code,standard_name,org.organization_code,
		sc.description as description,sc.comeactive,sc.backactive,sc.classjoindate,
		pr.period_name,sc.isactive,
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
 		inner join sim_simtrain_organization org on org.organization_id=tc.organization_id
 		inner join sim_simtrain_period pr on pr.period_id=tc.period_id
		WHERE $wherestring $orderbystring ";


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

	//echo monthDiff("2009-01-01",date("Y-m-d", time()));
	while($row=$xoopsDB->fetchArray($query)){
		$i++;
		$organization_code=$row['organization_code'];
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
		$isactive=$row['isactive'];
		$paiddate=$row['paiddate'];
		$category_code=$row['category_code'];
		$paidto=$row['paidto'];
		$due=$row['due'];
		$totalfees=$totalfees+$amt;
		$totaltransport=$totaltransport+$transportfees;
		$totalpaid=$totalpaid+$paid;
		$totaldue=$totaldue+$due;
		$movement_id=$row['movement_id'];
		$comeactive=$row['comeactive'];
		$backactive=$row['backactive'];
		$description=$row['description'];
		$classjoindate=$row['classjoindate'];
		$zoomctrl="";

	/*
	if($comeareafrom_id > 0)
	$comeareafrom_id = "Y";
	else
	$comeareafrom_id = "N";

	if($backareato_id > 0)
	$backareato_id = "Y";
	else
	$backareato_id = "N";*/

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

	$curr_date= date("Y-m-d", time()) ;
	$month_qty = monthDiff($classjoindate,$curr_date);

	
	echo <<< EOF
		<tr>
			<td class="$rowtype" style="text-align:left;">$i</td>
			<td class="$rowtype" style="text-align:left;">$period_name</td>
			<td class="$rowtype" style="text-align:left;">$student_code</td>
			<td class="$rowtype" style="text-align:left;">
				<a href="student.php?action=edit&student_id=$student_id" target="_blank">
				$student_name</a>
			</td>
			<td class="$rowtype" style="text-align:left;">$zoomctrl</td>
			<td class="$rowtype" style="text-align:left;">$name</td>
			<td class="$rowtype" style="text-align:left;">$category_code</td>
			<td class="$rowtype" style="text-align:left;"><a href="tuitionclass.php?tuitionclass_id=$tuitionclass_id&action=edit">$name</a></td>
			<td class="$rowtype" style="text-align:left;">$comeactive</td>
			<td class="$rowtype" style="text-align:right;">$backactive</td>
			<td class="$rowtype" style="text-align:right;">$amt</td>
			<td class="$rowtype" style="text-align:right;">$transportfees</td>
			<td class="$rowtype" style="text-align:right;">$description</td>
			<td class="$rowtype" style="text-align:right;">$classjoindate</td>
			<td class="$rowtype" style="text-align:right;">$transactiondate</td>
			<td class="$rowtype" style="text-align:right;">$month_qty</td>
			<td class="$rowtype" style="text-align:right;">$isactive</td>
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
		<th style="text-align:center;"></th>
		<th style="text-align:right;">$totalfees</th>
		<th style="text-align:right;">$totaltransport</th>
		<th style="text-align:right;"></th>
		<th style="text-align:right;"></th>
		<th style="text-align:center;"></th>
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
			<!--<input type="submit" value="PDF" name="submit" style="height:40px; font-size:25">-->
			</form>
EOF;

}
	echo "</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');

	function monthDiff($beginDate,$endDate){
	$diff_year = 0;

	$year_start = substr($beginDate,0,4);
	$year_end = substr($endDate,0,4);

	$month_start = substr($beginDate,5,2);
	$month_end = substr($endDate,5,2);

	$diff_year = $year_end - $year_start;

	if($diff_year != 0)
	$month_end = $month_end + (12*$diff_year);
	
	$diff_month = $month_end - $month_start + 1;
	
	if($beginDate == "0000-00-00")
	$diff_month = 0;

	return $diff_month;
	
	}
?>

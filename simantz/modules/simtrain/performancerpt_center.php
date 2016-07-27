<?php
include_once 'fpdf/fpdf.php';
include_once 'system.php';
include_once "menu.php";
include_once 'class/TuitionClass.php';
include_once 'class/Period.php';
include_once 'class/Log.php';
include_once './class/Student.php';
include_once ("datepicker/class.datepicker.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';


 $log=new Log();
 //$o=new TuitionClass($xoopsDB,$tableprefix,$log);
 $pr=new Period($xoopsDB,$tableprefix,$log);
$s= new Student($xoopsDB,$tableprefix,$log);

$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tableorganization=$tableprefix . "simtrain_organization";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tablestudentclass=$tableprefix . "simtrain_studentclass";
$tableperiod=$tableprefix . "simtrain_period";
$tablepaymentline=$tableprefix."simtrain_paymentline";
$tablepayment=$tableprefix."simtrain_payment";
$tableusers=$tableprefix."users";
$case="";

$organization_id=$_POST['organization_id'];

if($organization_id=="")
$organization_id=$defaultorganization_id;


$organizationctrl=$permission->selectionOrg($userid,$organization_id);
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
//require(XOOPS_ROOT_PATH.'/header.php');

echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Center Performance Report</span></big></big></big></div><br>-->
<FORM action="performancerpt_center.php" method="POST" >
	<table border='1'>
	<tbody>
	  <tr>
		<th colspan="7">Center Performance Report</th>
	  </tr>
	  <tr>

		<td class="head">Organization</td>
		<td class="odd">$organizationctrl</td>
	
		<td class="head"><input type="submit" value="Search" name="submit">
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
      <th colspan="12">Center Performance Report</th>
    </tr>
    <tr>
      <th style="text-align:center;">No</th>
      <th style="text-align:center;">Period</th>
      <th style="text-align:center;">Head Count</th>
      <th style="text-align:center;">Class Count</th>
      <th style="text-align:center;">Fees (RM)</th>
      <th style="text-align:center;">Received (RM)</th>
      <th style="text-align:center;">Inactive Qty(RM)</th>
      <th style="text-align:center;">Difference Qty</th>
      <th style="text-align:center;">New Student Qty</th>
    </tr>
  
EOF;

	$wherestring="(date(sc.transactiondate) between '$datefrom' and '$dateto')";
	if($student_id>0)
		$wherestring =$wherestring . " AND (s.student_id=$student_id)";
	//$viewname=$tableprefix."simtrain_qryfeestransaction";
	//$sql="SELECT uid,uname,student_name, payment_datetime,fees,transportamt,returnamt,docno,type FROM $viewname $wherestring ".
	//	" order by payment_datetime ";
	$sql="SELECT period_name, 
		 (SELECT count(*) FROM sim_simtrain_studentclass sc 
		 inner join sim_simtrain_tuitionclass tc on tc.tuitionclass_id=sc.tuitionclass_id 
		 where tc.period_id=pr.period_id and tc.organization_id=$organization_id) as headcount, 
		 (SELECT count(*) FROM sim_simtrain_tuitionclass tc where tc.period_id=pr.period_id and 
			tc.organization_id=$organization_id) as classcount, 
		 coalesce((SELECT sum(sc.amt) FROM sim_simtrain_studentclass sc 
			inner join sim_simtrain_tuitionclass tc on  tc.tuitionclass_id=sc.tuitionclass_id 
			where tc.period_id=pr.period_id and tc.organization_id=$organization_id),0.00) as trainingamt, 
		 coalesce((SELECT sum(py.amt) FROM sim_simtrain_payment py 
		 where (date(py.payment_datetime) between concat(pr.period_name,'-01') and 
		 concat(pr.period_name,'-31') and py.iscomplete='Y') and py.organization_id= $organization_id),
		 0.00) as receivedamt, 
 		 (SELECT count(*) FROM sim_simtrain_studentclass sc 
 		 inner join sim_simtrain_tuitionclass tc on tc.tuitionclass_id=sc.tuitionclass_id 
 		 where tc.period_id=pr.period_id and sc.isactive='N' and 
		 tc.organization_id=$organization_id) as inactivecount, 
		 (select count(*) from sim_simtrain_student st where date(created) between 
		 concat(pr.period_name,'-01')
		 and concat(pr.period_name,'-31') and st.organization_id=$organization_id and st.student_id>0) as newstudentqty 
 		 from sim_simtrain_period pr  WHERE pr.isactive='Y' order by period_name ASC";

	
	$log->showLog(3,"Producing center performance reports");
	$log->showLog(4,"With SQL: $sql");
	$query=$xoopsDB->query($sql);
	$headcount=0;
	$increaseqty=0;
	$trainingamt=0;
	$receivedamt=0;
	$classcount=0;
	$inactivecount=0;
	$newstudentqty=0;
	$rowtype="";
	$i=0;
	$totalfees=0;
	$totalreceived=0;
	$totalclass=0;
	$totalheadcount=0;
	$totalinactive=0;
	$totalincrease=0;
	$differenceqty=0;
	$totalnewstudent=0;

	while($row=$xoopsDB->fetchArray($query)){
		$i++;
	$period_name=$row['period_name'];
	$differenceqty=$row['headcount']-$headcount;
	$headcount=$row['headcount'];
	$trainingamt=$row['trainingamt'];
	$receivedamt=$row['receivedamt'];
	$classcount=$row['classcount'];
	$inactivecount=$row['inactivecount'];
	$newstudentqty=$row['newstudentqty'];
	$totalfees=$totalfees+$trainingamt;
	$totalreceived=$totalreceived+$receivedamt;
	$totalclass=$totalclass+$classcount;
	$totalheadcount=$totalheadcount+$headcount;
	$totalinactive=$totalinactive+$inactivecount;
	$totalincrease=$totalincrease+$differenceqty;
	$totalnewstudent=$totalnewstudent+$newstudentqty;
	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";
	echo <<< EOF
		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$period_name</td>
			<td class="$rowtype" style="text-align:center;">$headcount</td>
			<td class="$rowtype" style="text-align:center;">$classcount</td>
			<td class="$rowtype" style="text-align:right;">$trainingamt</td>
			<td class="$rowtype" style="text-align:right;">$receivedamt</td>

			<td class="$rowtype" style="text-align:center;">$inactivecount</td>
			<td class="$rowtype" style="text-align:center;">$differenceqty</td>
			<td class="$rowtype" style="text-align:center;">$newstudentqty</td>
		</tr>
EOF;
	}
		$totalfees=number_format($totalfees,2);
		$totalreceived=number_format($totalreceived,2);
	echo <<< EOF
		<tr>
			<th class="$rowtype" style="text-align:center;">Total</th>
			<th class="$rowtype" style="text-align:left;"></th>
			<th class="$rowtype" style="text-align:center;">$totalheadcount</th>
			<th class="$rowtype" style="text-align:center;">$totalclass</th>
			<th class="$rowtype" style="text-align:right;">$totalfees</th>
			<th class="$rowtype" style="text-align:right;">$totalreceived</th>
			<th class="$rowtype" style="text-align:center;">$totalinactive</th>
			<th class="$rowtype" style="text-align:center;">$totalincrease</th>
			<th class="$rowtype" style="text-align:center;">$totalnewstudent</th>
		</tr>
		</tbody></table>
	
EOF;
}

	echo "</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');

?>
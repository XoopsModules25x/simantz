<?php
include_once 'fpdf/fpdf.php';
include_once 'system.php';
include_once "menu.php";
include_once 'class/TuitionClass.php';
include_once 'class/Period.php';
include_once 'class/Log.php';
include_once './class/Employee.php';
include_once ("datepicker/class.datepicker.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';


 $log=new Log();
 //$o=new TuitionClass($xoopsDB,$tableprefix,$log);
 $pr=new Period($xoopsDB,$tableprefix,$log);
 $e = new Employee($xoopsDB,$tableprefix,$log);

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
if($_POST['employee_id']>0)
$employee_id=$_POST['employee_id'];
else 
$employee_id=0;
$employeectrl=$e->getEmployeeList($employee_id);

//require(XOOPS_ROOT_PATH.'/header.php');

echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Tutor Performance Report</span></big></big></big></div><br>-->
<FORM action="performancerpt_tutor.php" method="POST" target="_blank">
	<table border='1'>
	<tbody>
	  <tr>
		<th colspan="7">Tutor Performance Report</th>
	  </tr>
	  <tr>

		<td class="head">Tutor</td>
		<td class="odd">$employeectrl</td>
	
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
      <th colspan="12">Tutor Performance Report</th>
    </tr>
    <tr>
      <th style="text-align:center;">No</th>
      <th style="text-align:center;">Period</th>
      <th style="text-align:center;">Head Count</th>
      <th style="text-align:center;">Class Count</th>

      <th style="text-align:center;">Fees ($cur_symbol)</th>
      <th style="text-align:center;">Inactive Qty($cur_symbol)</th>
      <th style="text-align:center;">Difference Qty</th>
    </tr>
  
EOF;

	$wherestring="(date(sc.transactiondate) between '$datefrom' and '$dateto')";
	if($student_id>0)
		$wherestring =$wherestring . " AND (s.student_id=$student_id)";
	//$viewname=$tableprefix."simtrain_qryfeestransaction";
	//$sql="SELECT uid,uname,student_name, payment_datetime,fees,transportamt,returnamt,docno,type FROM $viewname $wherestring ".
	//	" order by payment_datetime ";
	$sql="SELECT period_name, (SELECT count(*) FROM sim_simtrain_studentclass sc ".
		" inner join sim_simtrain_tuitionclass tc on tc.tuitionclass_id=sc.tuitionclass_id ".
		" where tc.period_id=pr.period_id and tc.employee_id=$employee_id) as headcount, ".
		" (SELECT count(*) FROM sim_simtrain_tuitionclass tc where tc.period_id=pr.period_id and ".
		" tc.employee_id=$employee_id) as classcount, ".
		" coalesce((SELECT sum(sc.amt) ".
		" FROM sim_simtrain_studentclass sc inner join sim_simtrain_tuitionclass tc on ". 
		" tc.tuitionclass_id=sc.tuitionclass_id where tc.period_id=pr.period_id and tc.employee_id=$employee_id),0.00) ".
		" as trainingamt,".
 		" (SELECT count(*) FROM sim_simtrain_studentclass sc ".
 		" inner join sim_simtrain_tuitionclass tc on tc.tuitionclass_id=sc.tuitionclass_id ".
 		" where tc.period_id=pr.period_id and sc.isactive='N' and tc.employee_id=$employee_id) as inactivecount, ".
		" (SELECT sum(hours) FROM sim_simtrain_tuitionclass tc where tc.period_id=pr.period_id and ".
		" tc.employee_id=$employee_id) as hours ".
 		" from sim_simtrain_period pr WHERE pr.isactive='Y' order by period_name ASC  ";

	
	$log->showLog(3,"Producing center performance reports");
	$log->showLog(4,"With SQL: $sql");
	$query=$xoopsDB->query($sql);
	$headcount=0;
	$increaseqty=0;
	$trainingamt=0;
	$receivedamt=0;
	$hours=0;
	$classcount=0;
	$inactivecount=0;
	$rowtype="";
	$i=0;
	$totalhours=0;
	$totalfees=0;
	$totalclass=0;
	$totalheadcount=0;
	$totalinactive=0;
	$totalincrease=0;
	$differenceqty=0;

	while($row=$xoopsDB->fetchArray($query)){
		$i++;
	$period_name=$row['period_name'];
	$differenceqty=$row['headcount']-$headcount;
	$headcount=$row['headcount'];
	$trainingamt=$row['trainingamt'];
	$hours=number_format($row['hours'],1);
	$classcount=$row['classcount'];
	$inactivecount=$row['inactivecount'];

	$totalfees=$totalfees+$trainingamt;
	$totalclass=$totalclass+$classcount;
	$totalheadcount=$totalheadcount+$headcount;
	$totalinactive=$totalinactive+$inactivecount;
	$totalincrease=$totalincrease+$differenceqty;
	$totalhours=$totalhours+$hours;
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
			<td class="$rowtype" style="text-align:center;">$inactivecount</td>
			<td class="$rowtype" style="text-align:center;">$differenceqty</td>
		</tr>
EOF;
	}	$totalhours=number_format($totalhours,1);
		$totalfees=number_format($totalfees,2);
		$totalreceived=number_format($totalreceived,2);
	echo <<< EOF
		<tr>
			<th class="$rowtype" style="text-align:center;">Total</th>
			<th class="$rowtype" style="text-align:left;"></th>
			<th class="$rowtype" style="text-align:center;">$totalheadcount</th>
			<th class="$rowtype" style="text-align:center;">$totalclass</th>

			<th class="$rowtype" style="text-align:right;">$totalfees</th>
			<th class="$rowtype" style="text-align:center;">$totalinactive</th>
			<th class="$rowtype" style="text-align:center;">$totalincrease</th>
		</tr>
		</tbody></table>
	
EOF;

}
	echo "</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');

?>
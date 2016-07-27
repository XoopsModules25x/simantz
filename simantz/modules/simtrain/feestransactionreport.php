<?php
include_once 'fpdf/fpdf.php';
include_once 'system.php';
include_once ("menu.php");
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
$studentctrl=$s->getStudentSelectBox(-1);
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
require(XOOPS_ROOT_PATH.'/header.php');
echo <<< EOF
<td>
<FORM action="feestransactionreport.php" method="POST">
	<table>
	<tbody>
	  <tr>
		<th colspan="6">Fees Collection History</th>
	  </tr>
	  <tr>

		<td class="head">Date From</td>
		<td class="odd"><input name="datefrom" id="datefrom"><input type="button" onclick="$showcalendar1"></td>

		<td class="head">Date To</td>
		<td class="odd"><input id="dateto" name="dateto"><input type="button" onclick="$showcalendar2"></td>

		
		<td class="head"><input type="submit" value="Search" name="submit"></td>
		<td class="odd"><input type="reset" value="reset" name="reset"></td>
	  </tr>
	
	  </tbody>
	</table>
	</FORM>
EOF;
if (isset($_POST['submit'])){

	//processing parameter
	$wherestring="";

	$student_id=$_POST['student_id'];

	if($_POST['datefrom']!="")
		$datefrom=$_POST['datefrom'] . " 00:00:00";
	else
		$datefrom="0000-00-00";

	if($_POST['dateto']!="")
		$dateto=$_POST['dateto'] . " 23:59:59";
	else
		$dateto='9999-12-31';





	//generating table header
	echo <<< EOF
<table>
  <tbody>
    <tr>
      <th colspan="9">Fees Transaction Report</th>
    </tr>
    <tr>
      <th style="text-align:center;">No</th>
      <th style="text-align:center;">User</th>
      <th style="text-align:center;">Student</th>
      <th style="text-align:center;">Date/Time</th>
      <th style="text-align:center;">Fees (RM)</th>
      <th style="text-align:center;">Transport Amt(RM)</th>
      <th style="text-align:center;">Return Amt (RM)</th>
      <th style="text-align:center;">Document No</th>
      <th style="text-align:center;">Amount To <br>Date (RM)</th>
    </tr>
  
EOF;

	$wherestring="payment_datetime between '$datefrom' and '$dateto'";
	//$viewname=$tableprefix."simtrain_qryfeestransaction";
	//$sql="SELECT uid,uname,student_name, payment_datetime,fees,transportamt,returnamt,docno,type FROM $viewname $wherestring ".
	//	" order by payment_datetime ";
	$sql="select u.uid,u.uname,s.student_name AS student_name,p.payment_datetime AS payment_datetime,".
		" sum(pl.amt - pl.transportamt) AS fees,sum(pl.transportamt) AS transportamt,".
		" p.returnamt AS returnamt,p.receipt_no AS docno from $tablepayment p ".
		" join $tablepaymentline pl on pl.payment_id = p.payment_id ".
		" join $tablestudent s on p.student_id = s.student_id ".
		" join $tableusers u on p.createdby = u.uid ".
		" where p.iscomplete = 'Y' and $wherestring ".
		" group by u.uid,u.uname,s.student_name,p.receipt_no,p.payment_datetime,p.returnamt ";
	
	$log->showLog(3,"Producing Fees Transaction Report for $datefrom ~ $dateto");
	$log->showLog(4,"With SQL: $sql");
	$query=$xoopsDB->query($sql);
	$total=0;
	$rowtype="";
	$i=0;
	while($row=$xoopsDB->fetchArray($query)){
		$i++;
		$uid=$row['uid'];
		$uname=$row['uname'];
		$student_name=$row['student_name'];
		$payment_datetime=$row['payment_datetime'];
		$fees=$row['fees'];
		$transportamt=$row['transportamt'];
		$returnamt=$row['returnamt'];
		$docno=$row['docno'];
		$total=$total+$fees+$transportamt;
	
	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";
	echo <<< EOF
		<tr>
			<td class="$rowtype" style="text-align:left;">$i</td>
			<td class="$rowtype" style="text-align:left;">$uname</td>
			<td class="$rowtype" style="text-align:left;">$student_name</td>
			<td class="$rowtype" style="text-align:left;">$payment_datetime</td>
			<td class="$rowtype" style="text-align:right;">$fees</td>
			<td class="$rowtype" style="text-align:right;">$transportamt</td>
			<td class="$rowtype" style="text-align:right;">$returnamt</td>
			<td class="$rowtype" style="text-align:center;">$docno</td>
			<td class="$rowtype" style="text-align:right;">$total</td>
		</tr>
EOF;
	}
	echo <<< EOF
		</tbody></table>
		<form action="viewdayincome.php" method="POST">
			<input type="hidden" name="datefrom" value="$datefrom">
			<input type="hidden" name="dateto" value="$dateto">
			<input type="submit" value="pdf" name="submit">
			</form>
EOF;

}
	echo "</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');

?>
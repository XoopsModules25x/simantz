 <?php
include_once 'fpdf/fpdf.php';
include_once 'system.php';
include_once "menu.php";
include_once 'class/TuitionClass.php';
include_once 'class/Period.php';
include_once 'class/Log.php';
include_once './class/Payslip.php';
include_once './class/Employee.php';
include_once ("datepicker/class.datepicker.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';


 $log=new Log();
 //$o=new TuitionClass($xoopsDB,$tableprefix,$log);
 $pr=new Period($xoopsDB,$tableprefix,$log);
 $e = new Employee($xoopsDB,$tableprefix,$log);
  $p = new Payslip($xoopsDB,$tableprefix,$log);

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
$tableclassschedule=$tableprefix."simtrain_classschedule";
$case="";


if($_POST['employee_id']>0)
$employee_id=$_POST['employee_id'];
else 
$employee_id=0;

if($_POST['period_id']>0)
$period_id=$_POST['period_id'];
else 
$period_id=0;

$employeectrl=$e->getEmployeeList($employee_id);
$periodctrl=$pr->getPeriodList($period_id);

//require(XOOPS_ROOT_PATH.'/header.php');

echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Tutor Commission Summary</span></big></big></big></div><br>-->
<FORM action="viewtutorcommission.php" method="POST" >
	<table border='1'>
	<tbody>
	  <tr>
		<th colspan="7">Tutor Commission Summary</th>
	  </tr>
	  <tr>

		<td class="head">Tutor</td>
		<td class="odd">$employeectrl</td>
			<td class="head">Period</td>
		<td class="odd">$periodctrl</td>
		<td class="head">
				<input type="submit" value="Search" name="submit">
				<input type="reset" value="reset" name="reset">
		</td>
	  </tr>
	
	  </tbody>
	</table>
	</FORM>
EOF;
if (isset($_POST['submit'])) {
	//generating table header
showEmployeeHeader($employee_id,$tableprefix,$log,$xoopsDB,$cur_symbol);
$p->showTutorCommissionTable($period_id,$employee_id);

}

function showEmployeeHeader($employee_id,$tableprefix,$log,$xoopsDB,$cur_symbol){
$tableemployee = $tableprefix . "simtrain_employee";
$tablepayslip = $tableprefix . "simtrain_payslip";
$sql="SELECT e.employee_id,e.employee_name, e.employee_no,e.basicsalary,e.ic_no, e.salarytype, 
	p.totalincomeamt, e.tel_1, e.hp_no, e.hourlyamt,e.commissionrate
	FROM  $tableemployee e 
	left outer join $tablepayslip p on e.employee_id=p.employee_id
	where e.employee_id=$employee_id";

$log->showLog(4,"Show Employee Header for payslip with SQL: $sql");

$query=$xoopsDB->query($sql);
while($row=$xoopsDB->fetchArray($query)){
$employee_name=$row['employee_name'];
$employee_no=$row['employee_no'];
$basicsalary=$row['basicsalary'];
$ic_no = $row['ic_no'];
$contact  = $row['tel_1'] . "/" . $row['hp_no'];
$salarytype = $row['salarytype'];
$totalincome = $row['totalincomeamt'];
$commissionrate=$row['commissionrate'];
$hourlyamt=$row['hourlyamt'];

	switch($salarytype){
		case "B":
			$commissionamt=0;
			$salarytype="Basic Only";
		break;
		case "H":
			$commissionamt=$teachhours*$hourlyamt;
			$salarytype="Basic + Hourly Commission";

		break;
		case "C":
			$commissionamt = $salesamt * $commissionrate / 100;
			$salarytype="Basic + Sales & Replacement Commission";
		break;
		case "A":
			$commissionamt = $salesamt * $commissionrate / 100;
			$salarytype="Basic + Receipt & Replacement Commission";
		break;
		default:
			$commissionamt=0;
		break;
	}

}

echo <<< EOF
<table border='1'>
  <tbody>
    <tr>
      <th colspan='4' style='text-align: center;'>Employee Info</th>
    </tr>
    <tr>
      <td class='head'>Employee No</td>
      <td class='odd'>$employee_no</td>
      <td class='head'>Employee Name</td>
      <td class='odd'><A href='employee.php?action=edit&employee_id=$employee_id'>$employee_name</a></td>
    </tr>
    <tr>
      <td class='head'>Basic Salary($cur_symbol)</td>
      <td class='even'>$basicsalary</td>
      <td class='head'>Paid Amount($cur_symbol)</td>
      <td class='even'>$totalincome</td>
    </tr>
    <tr>
      <td class='head'>Salary Type</td>
      <td class='odd'>$salarytype</td>
      <td class='head'>IC No</td>
      <td class='odd'>$ic_no</td>
    </tr>
    <tr>
      <td class='head'>Hourly Rate($cur_symbol)</td>
      <td class='odd'>$hourlyamt</td>
      <td class='head'>Commission Amount ($cur_symbol)</td>
      <td class='odd'>$commissionrate</td>
    </tr>
  </tbody>
</table>

EOF;
}

	echo "</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');

?>
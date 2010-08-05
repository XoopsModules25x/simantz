<?php
include_once "system.php";
include_once ("menu.php");

include_once "class/Log.php";
include_once "../hr/class/Employee.php";
include_once "class/Payslip.php";
include_once "../simantz/class/datepicker/class.datepicker.php";
include_once 'class/Period.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

//$dp=new datepicker("$tableprefix");
//$dp->dateFormat='Y-m-d';


$dp=new datepicker($url);
$dp->dateFormat='Y-m-d';

$log = new Log();

$o = new Payslip($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);
//$period = new Period($xoopsDB,$tableprefix,$log);
$o->showdatefrom=$dp->show("datefrom");
$o->showdateto=$dp->show("dateto");

$action=$_POST['action'];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;

$periodctrl=$ctrl->getSelectPeriod(0,'Y',"","period_id",'');
$employeectrl=$ctrl->getSelectEmployee(0,'Y',"","employee_id",'');

//$periodctrl=$period->getPeriodList(0,'period_id','Y');
//$employeectrl=$e->getEmployeeList(0,'M','employee_id',"Y");
echo <<< EOF

<script type="text/javascript">
	function viewPayslip(payslip_id,count_itinerary){
	
	window.open('printpayslip.php?payslip_id='+payslip_id);
	if(count_itinerary>0)
	window.open('itinerarypayslip.php?payslip_id='+payslip_id);
	}
</script>


<table>
<tr>
<form action="payslip.php" method="POST">
<td acolspan='4'><input type="submit" value="Back To Main Page"></td>
</form>
</tr>
</table>

<form name="frmSearchPayslip" action="listpayslip.php" method="POST">
<table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="3">
  <tbody>

    <tr>
    <th colspan="4">Search Payslip</th>
    </tr>
    <tr>
      <td class="head">Date From</td>
      <td class="even"><input name='datefrom' id='datefrom'><input type='button' onclick="$o->showdatefrom" value='Date'></td>
     <td class="head">Date To</td>
	 <td class="even"> <input name='dateto' id='dateto'><input type='button' onclick="$o->showdateto"  value='Date'></td>
    </tr>
    <tr>
      <td class="head">Completed</td>
      <td class="even"><SELECT name="iscomplete"><option value="">NULL</option><option value='Y'>Yes</option><option value='N'>No</option></select></td>
      <td class="head">Period</td>
	<td class="even"> $periodctrl</td>
    </tr>
     <td class="head">Employee</td>
      <td class="even">$employeectrl</td>
      <td class="head"></td>
	<td class="even"> </td>
    </tr>
    <tr>
      <td><input type="reset" value="reset" name="reset"></td>
      <td colspan="3"><input type="submit" value="search" name="action"></td>
    </tr>
  </tbody>	
</table>

</form>
EOF;

if (isset($action)){
$datefrom=$_POST['datefrom'];
$dateto=$_POST['dateto'];
$period_id=$_POST['period_id'];
$employee_id=$_POST['employee_id'];
$iscomplete=$_POST['iscomplete'];
$o->isAdmin=$xoopsUser->isAdmin();

$wherestr=genWhereString($employee_id,$iscomplete,$datefrom,$dateto,$period_id);

$log->showLog(3,"Generated Wherestring=$wherestr");


if ($wherestr!="")
	$wherestr="WHERE ". $wherestr;

$o->showPayslipTable( $wherestr,  "order by p.payslipdate,e.employee_name" ); 

}

require(XOOPS_ROOT_PATH.'/footer.php');

function genWhereString($employee_id,$iscomplete,$datefrom,$dateto,$period_id){
$filterstring="";
$needand="";
if($employee_id > 0 ){
	$filterstring=$filterstring . " p.employee_id=$employee_id AND";

}
if($period_id > 0 ){
	$filterstring=$filterstring . " p.period_id=$period_id AND";

}

if($iscomplete!=""){
$filterstring=$filterstring . "  $needand p.iscomplete = '$iscomplete'  AND";
}

if ($datefrom !="" && $dateto!="")
	$filterstring= $filterstring . "  $needand p.payslipdate between '$datefrom 00:00:00' and '$dateto 23:59:59' AND";

if ($filterstring=="")
	return "";
else {
	$filterstring =substr_replace($filterstring,"",-3);  

	return " $filterstring";
	}
}


?>

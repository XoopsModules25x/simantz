<?php
include_once "system.php";
include_once ("menu.php");

include_once "class/Log.php";
include_once "class/Employee.php";
include_once "class/Student.php";
include_once "class/Payment.php";
include_once ("datepicker/class.datepicker.php");


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

$log = new Log();
$t = new Student($xoopsDB,$tableprefix,$log);
$o = new Payment($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);

$o->showdatefrom=$dp->show("datefrom");
$o->showdateto=$dp->show("dateto");

$action=$_POST['search'];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$studentctrl=$t->getStudentSelectBox(-1);

echo <<< EOF
<script type='text/javascript'>
	function autofocus(){
	
		document.forms['frmSearchPayment'].student_code.focus();
	}

</script>
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Search Payment</span></big></big></big></div><br>
<form name="frmSearchPayment" action="listpayment.php" method="POST">
<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
  <tbody>
    <tr>
      <td class="head">Student</td>
      <td class="even">$studentctrl</td>
	  <td class="head">Name</td>
      <td class="even"><input name='student_name'> %=all, Ali%, %Ali%, %ali%bin%</td>
    </tr>
    <tr>
      <td class="head">Student Index</td>
      <td class="odd"><input name='student_code'> %=all, 8001%, %11%, %8%11%</td>
     <td class="head"></td>
	 <td class="odd"> </td>
    </tr>
    <tr>
      <td class="head">Date From</td>
      <td class="odd"><input name='datefrom' id='datefrom'><input type='button' onclick="$o->showdatefrom" value='Date'></td>
     <td class="head">Date To</td>
	 <td class="odd"> <input name='dateto' id='dateto'><input type='button' onclick="$o->showdateto"  value='Date'></td>
    </tr>
    <tr>
      <td class="head">Completed</td>
      <td class="even"><SELECT name="iscomplete"><option value="">NULL</option><option value='Y'>Yes</option><option value='N'>No</option></select></td>
      <td class="head">Receipt No</td>
<td class="even"> <input name='receipt_no'></td>
    </tr>
    <tr>
      <td><input type="reset" value="reset" name="reset"></td>
      <td colspan="3"><input type="submit" value="search" name="action"></td>
    </tr>
  </tbody>	
</table>

</form>
EOF;

if (!isset($action)){
$datefrom=$_POST['datefrom'];
$dateto=$_POST['dateto'];
$student_id=$_POST['student_id'];
$student_name=$_POST['student_name'];
$student_code=$_POST['student_code'];
$receipt_no=$_POST['receipt_no'];
$iscomplete=$_POST['iscomplete'];
$wherestr=genWhereString($student_id,$student_code,$student_name,$iscomplete,$datefrom,$dateto,$receipt_no);

if($wherestr=="")
$wherestr .= " t.organization_id = $defaultorganization_id ";
else
$wherestr .= " and t.organization_id = $defaultorganization_id ";

$log->showLog(3,"Generated Wherestring=$wherestr");
$o->isAdmin=$xoopsUser->isAdmin();

if ($wherestr!="")
	$wherestr="WHERE ". $wherestr;
$o->showPaymentTable( $wherestr,  "order by p.receipt_no DESC",  0,'N' ); 

}

require(XOOPS_ROOT_PATH.'/footer.php');

function genWhereString($student_id,$student_code,$student_name,$iscomplete,$datefrom,$dateto,$receipt_no){
$filterstring="";
$needand="";
if($student_id > 0 ){
	$filterstring=$filterstring . " p.student_id=$student_id AND";

}


if ($student_name!=""){
$filterstring=$filterstring . " $needand t.student_name LIKE '$student_name' AND";
}

if ($student_code!=""){
$filterstring=$filterstring . " $needand t.student_code LIKE '$student_code' AND";
}

if($iscomplete!=""){
$filterstring=$filterstring . "  $needand p.iscomplete = '$iscomplete'  AND";
}

if($receipt_no!=""){
$filterstring=$filterstring . "  $needand p.receipt_no = '$receipt_no'  AND";
}

if ($datefrom !="" && $dateto!="")
	$filterstring= $filterstring . "  $needand p.payment_datetime between '$datefrom 00:00:00' and '$dateto 23:59:59' AND";

if ($filterstring=="")
	return "";
else {
	$filterstring =substr_replace($filterstring,"",-3);  

	return " $filterstring";
	}
}


?>

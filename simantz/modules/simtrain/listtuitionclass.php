<?php
include_once 'fpdf/fpdf.php';
include_once 'system.php';
include_once 'menu.php';

include_once 'class/TuitionClass.php';
include_once 'class/Period.php';
include_once 'class/Log.php';
include_once 'class/Employee.php';
include_once 'class/Address.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 $log=new Log();
 $o=new TuitionClass($xoopsDB,$tableprefix,$log);
 $pr=new Period($xoopsDB,$tableprefix,$log);
 $ad=new Address($xoopsDB,$tableprefix,$log);
 $e = new Employee($xoopsDB,$tableprefix,$log,$ad);

$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tablestudentclass=$tableprefix . "simtrain_studentclass";
$tableperiod=$tableprefix . "simtrain_period";
$tableaddress=$tableprefix . "simtrain_address";
$tablearea=$tableprefix . "simtrain_area";
$tableorganization=$tableprefix . "simtrain_organization";
$tableemployee=$tableprefix."simtrain_employee";
$case="";
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
if (isset($_POST['submit'])){



	//$employee_id=$_POST['employee_id'];
	$organization_id=$_POST['organization_id'];
	$organization_code=$_POST['organization_code'];
	$tuitionclass_code=$_POST[ "tuitionclass_code"];
	$period_id=$_POST['period_id'];
	$period_name=$_POST['period_name'];
	$employee_id=$_POST['employee_id'];
}
else
{



	//$employee_id=$_POST['employee_id'];
	$organization_id=$defaultorganization_id;
	$organization_code="";
	$tuitionclass_code="";
	$period_id=0;
	$period_name="";
	$employee_id=0;

}

$employeectrl=$e->getEmployeeList($employee_id,"M","employee_id","Y");
$periodctrl=$pr->getPeriodList($period_id);
$orgctrl=$permission->selectionOrg($userid,$organization_id);

//require(XOOPS_ROOT_PATH.'/header.php');

	echo <<< EOF
	<script  type="text/javascript">
		function setPeriodName(){
	
			var w = document.frmList.period_id.selectedIndex;
			var selected_text =document.frmList.period_id.options[w].text;
			document.frmList.period_name.value=selected_text;
		}
	</script>



<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Fees Collection Reports (By Class)</span></big></big></big></div><br>-->

	<FORM name="frmList" action="listtuitionclass.php" method="POST" onSubmit="setPeriodName()" >
	<table border='1'>
	<tbody>
	  <tr>
		<td class="head">Organization</td>
		<td class="odd">$orgctrl </td>
		<td class="head">Period</td>
		<td class="odd">$periodctrl <input type="hidden" name="period_name"></td>
	 </tr>
	  <tr>
		<td class="head">Tutor</td>
		<td class="even">$employeectrl</td>
	 
		<td class='head' colspan='2'><input type="submit" value="view" name="submit" style="height:40px;"></td>
	  </tr>
	  </tbody>
	</table>
	</FORM>
EOF;

if (isset($_POST['submit'])){



	//$employee_id=$_POST['employee_id'];

	echo <<< EOF
		<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">
			Fees Collection Report (By Class) For $organization_code ($period_name)
		</span></big></big></big></div><br>
EOF;

	
	$log->showLog(3,"Generating tuitionclass list under period_id: $period_id");
	$wherestr="";
	if($employee_id==0)	
		$wherestr="WHERE t.period_id=$period_id and o.organization_id=$organization_id";
	else
		$wherestr="WHERE t.period_id=$period_id and t.employee_id=$employee_id AND
				o.organization_id=$organization_id";

	showTuitionClassTable($wherestr,"ORDER BY tuitionclass_code",$xoopsDB,$log,$tableprefix,$cur_symbol);

	echo <<< EOF
			<form action='viewclasssummary.php' method='post' target="_blank">
			<input type='hidden' name='wherestr' value="$wherestr" >
			<input type='hidden' name='period_name' value="$period_name">
			<input type='hidden' name='organization_code' value="$organization_code">
			<input type='submit'  name='submit' value='Print This Summary' style='height:40px; font-size=20'>
			</form>

</td>
EOF;

}

require(XOOPS_ROOT_PATH.'/footer.php');
function showTuitionClassTable($wherestring,$orderbystring,$xoopsDB,$log,$tableprefix,$cur_symbol){
	$tablestudent=$tableprefix . "simtrain_student";
	$tableproductlist=$tableprefix . "simtrain_productlist";
	$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
	$tablestudentclass=$tableprefix . "simtrain_studentclass";
	$tableperiod=$tableprefix . "simtrain_period";
	$tableaddress=$tableprefix . "simtrain_address";
	$tablearea=$tableprefix . "simtrain_area";
	$tableorganization=$tableprefix . "simtrain_organization";
	$tableemployee=$tableprefix."simtrain_employee";

	//$log->showLog(3,"Showing Tuition Class Table");
	$sql="SELECT o.organization_code,t.classtype,t.classcount,t.tuitionclass_id,t.hours,t.product_id,
	t.period_id, t.employee_id,t.description, t.day, 
	t.starttime,t.attachmenturl, t.isactive, t.endtime, t.organization_id,t.createdby, t.created, t.updatedby, 
	t.updated, t.clone_id, t.tuitionclass_code,p.product_name,e.employee_name,t.description,p.amt,
	pr.period_name ,
	(SELECT count(studentclass_id) FROM sim_simtrain_studentclass 
		WHERE tuitionclass_id=t.tuitionclass_id ) as headcount,
	(SELECT sum(amt) FROM sim_simtrain_studentclass WHERE tuitionclass_id=t.tuitionclass_id) totalfees,
	(SELECT sum(pl.trainingamt) FROM sim_simtrain_studentclass sc 
		INNER JOIN sim_simtrain_paymentline pl on sc.studentclass_id=pl.studentclass_id
		INNER JOIN sim_simtrain_payment py on py.payment_id=pl.payment_id
		WHERE sc.tuitionclass_id=t.tuitionclass_id and py.iscomplete='Y') AS receivedamt
	from sim_simtrain_tuitionclass t 
	inner join $tableperiod pr on pr.period_id=t.period_id 
	inner join $tableproductlist p on p.product_id=t.product_id 
	inner join $tableemployee e on e.employee_id=t.employee_id 
	inner join $tableorganization o on o.organization_id=t.organization_id 
	$wherestring 
	Group by o.organization_code,t.classtype,t.tuitionclass_id,t.hours,t.product_id,
			t.period_id, t.employee_id, t.description, t.day, t.starttime,t.attachmenturl, 
			t.isactive, t.endtime, t.organization_id,t.createdby, t.created, t.updatedby, t.updated, t.clone_id,
			t.tuitionclass_code,p.product_name,e.employee_name,t.description,p.amt,pr.period_name 
	$orderbystring";
	$log->showLog(4,"List table with SQL: $sql");
	$query=$xoopsDB->query($sql);
	echo <<< EOF
	<table border="1" cellspacing="1">
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Period</th>
				<th style="text-align:center;">Class Code</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Student Qty</th>
				<th style="text-align:center;">Class Type</th>
				<th style="text-align:center;">Day</th>
				<th style="text-align:center;">Time</th>
				<th style="text-align:center;">Hours</th>
				<th style="text-align:center;">Tutor</th>
				<th style="text-align:center;">Fees ($cur_symbol)</th>
				<th style="text-align:center;">Total Tuition Fees($cur_symbol)</th>
				<th style="text-align:center;">Received ($cur_symbol)</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;" colspan="2">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	$frmTarget="";
	$totalreceivedamt=0;
	$totalallfees=0;
	$totalheadcount=0;
	while ($row=$xoopsDB->fetchArray($query)){
		$i++;
		$tuitionclass_id=$row['tuitionclass_id'];
		$tuitionclass_code=$row['tuitionclass_code'];
		$description=$row['description'];

		$classtype=$row['classtype'];
		$tuitiontime=$row['starttime'];
		switch($classtype){
		case "S":
			$classtype="Special";
			$tuitionclass_day='-';
			$tuitiontime="-";
		break;
		case "M":
			$classtype="Monthly";
			$tuitionclass_day='-';
			$tuitiontime="-";

		break;
		case "W":
			$classtype="Weekly";
			$tuitionclass_day=$row['day'];

		break;
		default :
			$classtype="Weekly";
		$tuitionclass_day=$row['day'];

		break;
		}
		

		$organization_code=$row['organization_code'];
		$period_name=$row['period_name'];
		$tutor = $row['employee_name'];
		$headcount = $row['headcount'];
		$hours=number_format($row['hours'],1);
		$totalhours=number_format($totalhours+$hours,1);
		$amt = $row['amt'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];
		$totalfees=$row['totalfees'];
		$receivedamt=$row['receivedamt'];
		$totalreceivedamt=$receivedamt+$totalreceivedamt;
		$totalallfees=$totalfees+$totalallfees;
		$totalheadcount=$headcount+$totalheadcount;
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		
			$frmAction="<form action='viewclassincome.php' method='POST' target='_blank'>".
					"<input type='image' src='images/list.gif' name='submit' title='View Payment Report'>".
					"<input type='hidden' value='$tuitionclass_id' name='tuitionclass_id'>".
					"<input type='hidden' name='action' value='edit'></FORM></td>".
					"<td class='$rowtype' style='text-align:center;'></td>";
	
	

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$organization_code</td>
			<td class="$rowtype" style="text-align:center;">$period_name</td>
			<td class="$rowtype" style="text-align:center;">
			  <a href="tuitionclass.php?action=edit&tuitionclass_id=$tuitionclass_id">
				$tuitionclass_code</A>
			</td>
			<td class="$rowtype" style="text-align:center;">$description</td>
			<td class="$rowtype" style="text-align:center;">$headcount</td>
			<td class="$rowtype" style="text-align:center;">$classtype</td>
			<td class="$rowtype" style="text-align:center;">$tuitionclass_day</td>
			<td class="$rowtype" style="text-align:center;">$tuitiontime</td>
			<td class="$rowtype" style="text-align:center;">$hours</td>
			<td class="$rowtype" style="text-align:center;">$tutor</td>
			<td class="$rowtype" style="text-align:center;">$amt</td>
			<td class="$rowtype" style="text-align:center;">$totalfees</td>
			<td class="$rowtype" style="text-align:center;">$receivedamt</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
			$frmAction
			</td>

		</tr>
EOF;
	}
$totalreceivedamt=number_format($totalreceivedamt,2);
$totalallfees=number_format($totalallfees,2);
echo <<< EOF
<tr>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;">Total ($cur_symbol):</td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;">$totalheadcount</td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>

			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;">$totalallfees</td>
			<td class="head" style="text-align:center;">$totalreceivedamt</td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>

			<td class="head" style="text-align:center;"></td>
		</tr>
EOF;
	echo  "</tr></tbody></table>";
 }//showTuitionClassTable
?>


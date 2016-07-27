<?php

include_once "system.php";
include_once ("menu.php");
include_once "class/Log.php";
include_once "class/Product.php";
include_once "class/InventoryMovement.php";
include_once "class/Employee.php";
include_once ("datepicker/class.datepicker.php");
//require(XOOPS_ROOT_PATH.'/header.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new InventoryMovement($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);
$p = new Product($xoopsDB,$tableprefix,$log);
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$showcalendar1=$dp->show("tuitiondate");
//$productctrl=$p->getSelectProduct(-1,'Y');

if($_POST['organization_id']=="")
$organization_id = $defaultorganization_id;
else
$organization_id=$_POST['organization_id'];

$organization_code=$_POST['organization_code'];
if($organization_id=="")
$organization_id==0;

$organizationctrl=$permission->selectionOrg($userid,$organization_id);
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$tuitiondate=$_POST['tuitiondate'];


echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Student Vs Date Report</span></big></big></big></div><br>-->
<script type="text/javascript">
function validateform(){
	if(!isDate(document.form1.tuitiondate.value))
		return false;
}

	function autofocus(){
	
		document.forms['form1'].btnDate.focus();
	}
</script>
<FORM action="liststudentdate.php" method="POST" name='form1' onsubmit='return validateform();' >
	<table border='1'>
	<tbody>
	  <tr>
		<th colspan="7">Criterial</th>
	  </tr>
	  <tr>

		<td class="head">Organization</td>
		<td class="odd">$organizationctrl</td>
		<td class="head">Date(YYYY-MM-DD)</td>
		<td class="odd"><input id='tuitiondate' name='tuitiondate' value="$tuitiondate">
			<input type='button' name='btnDate' value="Date" onclick="$showcalendar1"></td>
	</tr><tr>
		<td class="head" colspan='4'><input type="submit" value="Search" name="submit">
				<input type="reset" value="reset" name="reset"></td>
	  </tr>
	
	  </tbody>
	</table>
	</FORM>
EOF;


if(isset($_POST['submit']))
{

showStudent($organization_id,$xoopsDB,$log,$tableprefix,$tuitiondate,$organization_code);

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');


  function showStudent($organization_id,$xoopsDB,$log,$tableprefix,$tuitiondate,$organization_code){
	$tablestk=$tableprefix."simtrain_qryinventorymovement";
	$tableproduct=$tableprefix."simtrain_productlist";
	$tablecategory=$tableprefix."simtrain_productcategory";
	$tableorganization=$tableprefix."simtrain_organization";
	$tableinventorymovement=$tableprefix."simtrain_inventorymovement";
	$sql="SELECT DISTINCT (s.student_id) as student_id, s.student_code, s.student_name,
		s.alternate_name, s.tel_1, s.hp_no,pr.parents_name,pr.parents_contact,o.organization_code,
		min( date_format( scc.class_datetime, '%H:%i:%S' ) ) AS class_datetime
		FROM sim_simtrain_student s
		INNER JOIN sim_simtrain_studentclass sc ON sc.student_id = s.student_id
		INNER JOIN sim_simtrain_tuitionclass t ON sc.tuitionclass_id = t.tuitionclass_id
		INNER JOIN sim_simtrain_parents pr ON pr.parents_id = s.parents_id
		INNER JOIN sim_simtrain_classschedule scc ON scc.tuitionclass_id = t.tuitionclass_id
		INNER JOIN sim_simtrain_organization o ON o.organization_id = t.organization_id
		WHERE s.student_id >0
		AND date_format( scc.class_datetime, '%Y-%m-%d' ) = '$tuitiondate'
		AND t.organization_id=$organization_id
		GROUP BY s.student_code, s.student_name, s.alternate_name, s.tel_1,
		s.hp_no,pr.parents_name,pr.parents_contact";

	$log->showLog(3,"Showing to student for organization_id: $organization_id with SQL: $sql");

	$query=$xoopsDB->query($sql);
	echo <<< EOF

	<table border='1' >
  		<tbody><FORM method='POST' action='viewliststudentdate.php' target="_blank">
		<input type='hidden' name='organization_id' value='$organization_id'>
		<input type='hidden' name='organization_code' value='$organization_code'>

		<input type='hidden' name='tuitiondate' value="$tuitiondate">
    			<tr><th colspan="9" style='text-align: center;'>Student List</th></tr><tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Index</th>
				<th style="text-align:center;">Student Name</th>
				<th style="text-align:center;">Parent Name</th>
				<th style="text-align:center;">Parent Contact</th>
				<th style="text-align:center;">Tel</th>
				<th style="text-align:center;">HP No</th>
				<th style="text-align:center;">Time</th>

</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$xoopsDB->fetchArray($query)){
		$i++;
		$student_code=$row['student_code'];
		$student_name=$row['student_name'];
		$alternate_name=$row['alternate_name'];
		$student_id=$row['student_id'];

		$organization_code=$row['organization_code'];
		$tel_1=$row['tel_1'];
		$hp_no=$row['hp_no'];
		$class_datetime=$row['class_datetime'];
		$parents_contact=$row['parents_contact'];
		$parents_name=$row['parents_name'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$organization_code</td>
			<td class="$rowtype" style="text-align:center;">
				<a href='student.php?action=edit&student_id=$student_id'>$student_code</a>
			</td>
			<td class="$rowtype" style="text-align:center;">$alternate_name/$student_name</td>
			<td class="$rowtype" style="text-align:center;">$parents_name</td>
			<td class="$rowtype" style="text-align:center;">$parents_contact</td>
			<td class="$rowtype" style="text-align:center;">$tel_1</td>
			<td class="$rowtype" style="text-align:center;">$hp_no</td>

			<td class="$rowtype" style="text-align:center;">$class_datetime</td>
			
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table><input type='submit' value='Print' name='submit' style='height: 40px'></form>";
	}




?>

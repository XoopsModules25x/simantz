<?php

include_once "system.php";
include_once ("menu.php");
include_once "class/Log.php";
include_once "class/Product.php";
include_once "class/ProductCategory.php";
include_once "class/Employee.php";
include_once "class/Period.php";
include_once "class/Standard.php";
include_once "class/School.php";
include_once ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();

$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$p = new Product($xoopsDB,$tableprefix,$log);
$standard = new Standard($xoopsDB,$tableprefix,$log);
$period = new Period ($xoopsDB,$tableprefix,$log);
$category = new ProductCategory($xoopsDB,$tableprefix,$log);
$school = new School($xoopsDB,$tableprefix,$log);
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$showcalendar1=$dp->show("tuitiondate");
//$productctrl=$p->getSelectProduct(-1,'Y');

if($_POST['organization_id']=="")
$organization_id=$defaultorganization_id;
else
$organization_id=$_POST['organization_id'];

$organization_code=$_POST['organization_code'];
if($organization_id=="")
$organization_id==0;

$category_id=$_POST['category_id'];
if($category_id=="")
$category_id=0;
$categoryctrl=$category->getSelectCategory($category_id,'Y');

/*$product_id=$_POST['product_id'];
if($product_id=="")
$product_id=0;
$productctrl=$p->getSelectProduct($product_id,'NY',"",'Y');
*/

$period_id=$_POST['period_id'];
if($period_id=="")
$period_id=0;
$periodctrl=$period->getPeriodList($period_id);


$standard_id=$_POST['standard_id'];
if($standard_id=="")
$standard_id=0;
$standardctrl=$standard->getSelectStandard($standard_id,'Y');

$school_id=$_POST['school_id'];
if($school_id=="")
$school_id=0;
$schoolctrl=$school->getSelectSchool($school_id,'Y');


$organizationctrl=$permission->selectionOrg($userid,$organization_id);

$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$tuitiondate=$_POST['tuitiondate'];

//require(XOOPS_ROOT_PATH.'/header.php');

echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Student Vs Category/Product Report</span></big></big></big></div><br>-->
<script type="text/javascript">
function validateform(){
	if(!isDate(document.form1.tuitiondate.value))
		return false;
}
</script>
<FORM action="liststudentcategory.php" method="POST" name='form1' onsubmit='return validateform();' >
	<table border='1'>
	<tbody>
	  <tr>
		<th colspan="7">Criterial</th>
	  </tr>
	  <tr>

		<td class="head">Organization</td>
		<td class="odd">$organizationctrl</td>
		<td class="head">Period</td>
		<td class="odd">$periodctrl</td>
	</tr>
	  <tr>

		<td class="head">Category</td>
		<td class="odd">$categoryctrl</td>
		<td class="head"></td>
		<td class="odd"></td>
	</tr>
	  <tr>

		<td class="head">Standard</td>
		<td class="odd">$standardctrl</td>
		<td class="head">School</td>
		<td class="odd">$schoolctrl</td>
	</tr>
<tr>
		<td class="head" colspan='4'><input type="submit" value="Search" name="submit">
				<input type="reset" value="reset" name="reset"></td>
	  </tr>
	
	  </tbody>
	</table>
	</FORM>
EOF;


if(isset($_POST['submit']))
{

showStudent($organization_id, $xoopsDB, $log, $tableprefix, $organization_code, $school_id,
		$standard_id, $period_id, $category_id);

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');


  function showStudent($organization_id,$xoopsDB,$log,$tableprefix,
			$organization_code,$school_id,$standard_id,$period_id,$category_id){
	$log->showLog(4,"Show student list with parameter $organization_id,$xoopsDB,$log,$tableprefix,
			$organization_code,$school_id,$standard_id,$period_id,$category_id");
	$tablestk=$tableprefix."simtrain_qryinventorymovement";
	$tableproduct=$tableprefix."simtrain_productlist";
	$tablecategory=$tableprefix."simtrain_productcategory";
	$tableschool=$tableprefix."simtrain_school";
	$tablestandard=$tableprefix."simtrain_standard";
	$tableorganization=$tableprefix."simtrain_organization";
	$tableparents=$tableprefix."simtrain_parents";
	$tableperiod=$tableprefix."simtrain_period";
	$tablestudentclass=$tableprefix."simtrain_studentclass";
	$tablestudent=$tableprefix."simtrain_student";
	$tabletuitionclass=$tableprefix."simtrain_tuitionclass";

	$wherestring = "where tc.period_id=$period_id AND tc.organization_id=$organization_id AND";

	if($school_id>0)
		$wherestring=$wherestring . " st.school_id=$school_id AND";
	if($category_id>0)
		$wherestring=$wherestring . " p.category_id=$category_id AND";
	if($standard_id>0)
		$wherestring=$wherestring . " st.standard_id=$standard_id AND";


	if ($wherestring!="")
	$wherestring = substr_replace($wherestring,"",-3);  

	$orderbystring="ORDER BY st.student_name";

	$sql="SELECT DISTINCT (a.student_id), a.student_code, a.student_name, a.tuitionclass_code,a.tel_1,
		 a.category_code,a.organization_code,a.school_name,a.standard_name, a.period_name, a.parents_name FROM (
		SELECT st.student_id, st.student_code, concat(st.alternate_name,'/',st.student_name) as student_name,
		 tc.tuitionclass_code, coalesce(st.tel_1,st.hp_no) as tel_1, period.period_name, parents.parents_name,
		pc.category_code,o.organization_code,school.school_name,standard.standard_name
		FROM $tabletuitionclass tc
		INNER JOIN $tableorganization o on o.organization_id=tc.organization_id 
		INNER JOIN $tableperiod period on period.period_id=tc.period_id 
		INNER JOIN $tablestudentclass sc ON tc.tuitionclass_id = sc.tuitionclass_id
		INNER JOIN $tablestudent st ON st.student_id = sc.student_id
		INNER JOIN $tableparents parents ON parents.parents_id = st.parents_id
		INNER JOIN $tablestandard standard ON st.standard_id = standard.standard_id
		INNER JOIN $tableschool school ON st.school_id = school.school_id
		INNER JOIN $tableproduct p ON tc.product_id = p.product_id
		INNER JOIN $tablecategory pc ON pc.category_id = p.category_id
		$wherestring $orderbystring) a ";
	$log->showLog(3,"Showing to student for organization_id: $organization_id with SQL: $sql");

	$query=$xoopsDB->query($sql);
	echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Student List</span></big></big></big></div><br>
	<table border='1' >
  		<tbody><FORM method='POST' action='viewliststudentcategory.php' target="_blank">
		<input type='hidden' name='organization_id' value='$organization_id'>
		<input type='hidden' name='organization_code' value='$organization_code'>

		<input type='hidden' name='tuitiondate' value="$tuitiondate">
    			<tr><th colspan="9" style='text-align: center;'>Student List</th></tr><tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Index</th>
				<th style="text-align:center;">Student Name</th>
				<th style="text-align:center;">Category</th>

				<th style="text-align:center;">Standard</th>
				<th style="text-align:center;">School</th>
				<th style="text-align:center;">Parent</th>
				<th style="text-align:center;">Contact</th>

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
		$category_code=$row['category_code'];
		$product_no=$row['product_no'];
		$standard_name=$row['standard_name'];
		$parents_name=$row['parents_name'];
		$school_name=$row['school_name'];
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
			<td class="$rowtype" style="text-align:center;">$student_name</td>
			<td class="$rowtype" style="text-align:center;">$category_code</td>
			<td class="$rowtype" style="text-align:center;">$standard_name</td>
			<td class="$rowtype" style="text-align:center;">$school_name</td>
			<td class="$rowtype" style="text-align:center;">$parents_name</td>
			<td class="$rowtype" style="text-align:center;">$tel_1</td>
			
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table><input type='submit' value='Print' name='submit' style='height: 40px'>
		<input type='hidden' name='wherestring' value='$wherestring'>
		<input type='hidden' name='orderbystring' value='$orderbystring'></form>";
	}




?>

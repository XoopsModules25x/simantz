<?php

include_once "system.php";
include_once ("menu.php");
include_once "class/Log.php";
include_once "class/Product.php";
include_once "class/InventoryMovement.php";
include_once "class/Employee.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$log = new Log();
$o = new InventoryMovement($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);
$p = new Product($xoopsDB,$tableprefix,$log);
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
//$productctrl=$p->getSelectProduct(-1,'Y');

$organization_id=$_POST['organization_id'];

if($organization_id=="")
$organization_id=$defaultorganization_id;

$organizationctrl=$permission->selectionOrg($userid,$organization_id);
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
//require(XOOPS_ROOT_PATH.'/header.php');

echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">On Hand Stock</span></big></big></big></div><br>-->
<FORM action="liststock.php" method="POST" >
	<table border='1'>
	<tbody>
	  <tr>
		<th colspan="7">Stock Report</th>
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


if(isset($_POST['submit']))
{

showProductTransaction($organization_id,$xoopsDB,$log,$tableprefix);

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');


  function showProductTransaction($organization_id,$xoopsDB,$log,$tableprefix){
	$tablestk=$tableprefix."simtrain_qryinventorymovement";
	$tableproduct=$tableprefix."simtrain_productlist";
	$tablecategory=$tableprefix."simtrain_productcategory";
	$tableorganization=$tableprefix."simtrain_organization";
	$tableinventorymovement=$tableprefix."simtrain_inventorymovement";
	$sql="SELECT pd.product_name,sum(m.quantity) as qty,o.organization_name, (select sum(quantity) from $tableinventorymovement where product_id=pd.product_id and quantity>0 and organization_id=$organization_id) as totalin,(select sum(quantity)*-1 from $tableinventorymovement where product_id=pd.product_id and quantity<0  and organization_id=$organization_id) as totalout FROM $tableinventorymovement m ".
		" inner join $tableproduct pd on m.product_id=pd.product_id ".
		" inner join $tableorganization o on o.organization_id=m.organization_id ".
		" inner join $tablecategory c on pd.category_id=c.category_id ".
		" where pd.isactive='Y' and c.isitem='Y' and o.organization_id=$organization_id ".
		" group by product_name,o.organization_name";
	$log->showLog(3,"Showing product movement for organization_id: $organization_id with SQL: $sql");

	$query=$xoopsDB->query($sql);
	echo <<< EOF

	<table border='1' >
  		<tbody>
    			<tr>	<th style="text-align:center;">No</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Product Name</th>
				<th style="text-align:center;">Quantity</th>
				<th style="text-align:center;">Total In</th>
				<th style="text-align:center;">Total Out</th>

</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$xoopsDB->fetchArray($query)){
		$i++;
		$product_name=$row['product_name'];
		$qty=$row['qty'];
		$totalin=$row['totalin'];
		$totalout=$row['totalout'];
		$organization_name=$row['organization_name'];


		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$organization_name</td>
			<td class="$rowtype" style="text-align:center;">$product_name</td>
			<td class="$rowtype" style="text-align:center;">$qty</td>
			<td class="$rowtype" style="text-align:center;">$totalin</td>
			<td class="$rowtype" style="text-align:center;">$totalout</td>

			
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";	
	}




?>

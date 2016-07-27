<?php
require ("system.php");
require ("menu.php");
$pay = $url."/modules/salon//payment.php";

$tablegroups_users_link=$tableprefix . "groups_users_link";
$uid = $xoopsUser->getVar('uid');
$startpageuser = $url."/modules/salon//payment.php";

$payment = $_GET['payment'];

 	$sql =	"SELECT * from $tablegroups_users_link b 
			WHERE b.uid = $uid
			AND b.groupid = 4 ";
	
	$query=$xoopsDB->query($sql);
	$return = 0;
	if($row=$xoopsDB->fetchArray($query)){
	$return = 1;
	}

if($return == 1 && $payment == "")
header('Location: '.$startpageuser);
	
echo <<< EFO
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">SimSalon Management System Main Page</span></big></big></big></div>
<br>
<table style="width:550px; text-align: left;" border="0" cellpadding="1" cellspacing="1">
<tbody>

<!--
<tr>
<th><b>Master data</b></th>
<th><b>Transanction</b></th>
<th><b>Reports</b></th>
<tr>
<td class="odd"><a href="stafftype.php">Employee Type</a></td>
<td class="even"><a href="$pay">Payment</a></td>
<td class="odd"><a href="profitnloss.php">Profit & Loss Statement</a></td>
</tr>
<tr>
<td class="odd"><a href="employee.php">Employee</a></td>
<td class="even"><a href="payroll.php">Payroll</a></td>
<td class="odd"><a href="liststockrpt.php">On Hand Stock Report</a></td>
</tr>
<tr>
<td class="odd"><a href="customertype.php">Customer Type</a></td>
<td class="even"><a href="expenses.php">Expenses</a></td>
<td class="odd"><a href="salary.php">Performance Summary Report</a></td>
</tr>
<tr>
<td class="odd"><a href="customer.php">Customer</a></td>
<td class="even"><a href="vinvoice.php">Vendor Invoice</a></td>
<td class="odd"></td>
</tr>
<tr>
<td class="odd"><a href="terms.php">Terms</a></td>
<td class="even"><a href="internal.php">Internal Use</a></td>
<td class="odd"></td>
</tr>
<tr>
<td class="odd"><a href="uom.php">Unit Of Measurement</a></td>
<td class="even"><a href="adjustment.php">Adjustment</a></td>
<td class="odd"></td>
</tr>

<tr>
<td class="odd"><a href="category.php">Product Category</a></td>
<td class="even"></td>
<td class="odd"></td>
</tr>
<tr>
<td class="odd"><a href="product.php">Product List</a></td>
<td class="even"></td>
<td class="odd"></td>
</tr>
<tr>
<td class="odd"><a href="expensescategory.php">Expenses Category</a></td>
<td class="even"></td>
<td class="odd"></td>
</tr>
<tr>
<td class="odd"><a href="expenseslist.php">Expenses List</a></td>
<td class="even"></td>
<td class="odd"></td>
</tr>
<tr>
<td class="odd"><a href="promotion.php">Promotion</a></td>
<td class="even"></td>
<td class="odd"></td>
</tr>
<tr>
<td class="odd"><a href="commission.php">Commission</a></td>
<td class="even"></td>
<td class="odd"></td>
</tr>
<tr>
<td class="odd"><a href="vendor.php">Vendor</a></td>
<td class="even"></td>
<td class="odd"></td>
</tr>
<tr>
<td class="odd"><a href="leave.php">Leave</a></td>
<td class="even"></td>
<td class="odd"></td>
</tr>-->

</table>

EFO;
require(XOOPS_ROOT_PATH.'/footer.php');
?>

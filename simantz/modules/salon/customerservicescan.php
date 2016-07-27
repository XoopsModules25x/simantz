<?php
require ("system.php");
require ("menu.php");
$pay = $url."/modules/salon//payment.php";

if (isset($_POST['customer_id'])){
	$customer_id=$_POST['customer_id'];

}
elseif(isset($_GET['customer_id'])){
	$customer_id=$_GET['customer_id'];
}

$tablecustomerservice=$tableprefix."simsalon_customerservice";
$tablecustomer=$tableprefix."simsalon_customer";



$sql = "select * from $tablecustomerservice a, $tablecustomer b 
	where a.customer_id = $customer_id 
	and a.customer_id = b.customer_id 
	order by a.customerservice_id desc limit 1";


$query=$xoopsDB->query($sql);
	
if($row=$xoopsDB->fetchArray($query)){
$customer_name = $row['customer_name'];
$filename = $row['filename'];

$filename = "upload/customerservices/".$filename;
echo <<< EFO

<br>
<table border="0" cellpadding="1" cellspacing="1">
<tbody>

<tr>
<td class="odd">Customer</td>
<td class="odd">: $customer_name</td>
</tr>

<tr height="15">
<td></td>
</tr>

<tr>
<td class="odd" colspan="3"><img src="$filename" ></td>
</tr>

</tr>

</table>

EFO;
}
//require(XOOPS_ROOT_PATH.'/footer.php');
?>

<?php
include_once "system.php" ;
include_once "class/WorkPermit.php";
include_once "class/LoanPayment.php";
include_once "class/Checkup.php";
include_once "class/Log.php";

$log = new Log();

include_once "menu.php";

$aligncenter= 'style="text-align: center"';
//$newdate=date("Y-m-d",(strtotime("2008-07-11")+60*60*24*($OFFSET))) . "??".strtotime("2008-07-11");
//$newdate=date("Y-m-d",strtotime("2008-1-31")).'//'.date("Y-m-d",strtotime("+1 month",strtotime("2008-1-31")));
echo <<< EFO
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">SimBill Management System Main Page</span></big></big></big></div>
<table
 style="width: 650px; height: 500px; text-align: left;margin-left: auto; margin-right: auto;"
 border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td style="text-align: left; width: 200px;"><a
 href="quotation.php"><img
 style="border: 0px solid ; width: 150px; height: 150px;"
 alt="Quotation" src="./images/quotation.jpg"></a><br>
      </a></td>
       <td style="text-align: left; width: 200px; height: 220px;"><a
 href="invoice.php"><img
 style="border: 0px solid ; width: 150px; height: 150px;"
 alt="Invoice" src="./images/invoice.jpg"></a><br>
      </a></td>
</tr>
<tr>
      <td style="text-align: left; width: 200px;"><a
 href="payment.php"><img
 style="width: 150px;" alt="Payment"
 src="./images/payment.jpg"></a></td>
      <td style="text-align: left; width: 200px;"><a
 href="statement.php?action=search"><img
 style="width: 150px;" alt="Statement"
 src="./images/statement.jpg"></a></td>

	</tr>
  </tbody>
</table>
EFO;
require(XOOPS_ROOT_PATH.'/footer.php');

?>


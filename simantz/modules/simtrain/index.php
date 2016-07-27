<?php
include_once ("system.php");
include_once ("menu.php");

echo <<< EFO
<table
 style="width: 650px; height: 500px; text-align: center;margin-left: auto; margin-right: auto;"
 border="0" cellpadding="0" cellspacing="0">
  <tbody>
<tr><td colspan="3" style="text-align:center;"><img src="./images/maintitle.jpg"></td></tr>
    <tr>
       <td style="text-align: center; width: 200px; height: 220px;"><a
 href="student.php"><img
 style="border: 0px solid ; width: 150px; height: 150px;"
 alt="Students Records" src="./images/studentrecords.jpg"></a><br>
      </a></td>

      <td style="text-align: center; width: 200px;"><a
 href="employee.php"><img
 style="border: 0px solid ; width: 150px; height: 150px;"
 alt="Staff / Tutor Records" src="./images/staffrecords.jpg"></a><br>
      </a></td>
      <td style="text-align: center; width: 200px;"><a
 href="regclass.php"><img
 style="width: 150px;" alt="Class Registration"
 src="./images/classregistration.jpg"></a></td>
<tr>
<td style="text-align: center;"><a href="inventorymovement.php"><img
 style="width: 150px; height: 150px;" alt="Inventory Control"
 src="./images/inventorycontrol.jpg"></a></td>
     <td style="text-align: center;"><a href="pickup.php"><img alt="Transport Services"
 src="./images/transportservices.jpg"></a></td>
    <td style="text-align: center;"><a href="payment.php"><img alt="Sales and Payment"
 src="./images/salespayment.jpg"></a></td>
    </tr>
  </tbody>
</table>

EFO;
require(XOOPS_ROOT_PATH.'/footer.php');
?>

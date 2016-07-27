<?php
if( $_GET['action']=="validation"){

  $value=$_GET['value'];
  $validationtype=$_GET['validationtype'];
  $pattern=$_GET['pattern'];
  include "../simantz/class/Validation.inc.php";
  $v = new Validation();
  echo $v->returnXMLResult($value,$validationtype,$pattern);
}
?>

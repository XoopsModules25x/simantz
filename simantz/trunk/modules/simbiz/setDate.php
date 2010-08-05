<?php

$defaultDateSession = $_POST['defaultDateSession'];
session_start(); 
$_SESSION['defaultDateSession2']=$defaultDateSession;

//echo "<script type='text/javascript'>alert('$defaultDateSession');</script>";
?>

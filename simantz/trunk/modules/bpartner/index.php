<?php



include "system.php";
include "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
echo <<< EFO
<strong>[Initial Setup]</strong><br>
1. Create Business Partner Group  &nbsp;&nbsp;<a href='bpartnergroup.php' target="_blank">[Go]</a><br> 
2. Create Business Partner  &nbsp;&nbsp;<a href='bpartner.php' target="_blank">[Go]</a><br> 
3. Create Industry  &nbsp;&nbsp;<a href='industry.php' target="_blank">[Go]</a><br> 
EFO;

require(XOOPS_ROOT_PATH.'/footer.php');

?>

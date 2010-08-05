<?php

include "system.php";
include "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
echo <<< EFO

<strong>[Initial Setup]</strong><br>
1. Create Country &nbsp;&nbsp;<a href='country.php' target="_blank">[Go]</a><br>
2. Create Period (optional) &nbsp;&nbsp;<a href='period.php' target="_blank">[Go]</a><br> 
3. Create Currency &nbsp;&nbsp; <a href='currency.php' target="_blank">[Go]</a><br>
4. Create Organization &nbsp;&nbsp; <a href='admin/organization.php' target="_blank">[Go]</a><br>
5. Create Races (option) &nbsp;&nbsp;<a href='races.php' target="_blank">[Go]</a><br>
6. Create Religion (option) &nbsp;&nbsp;<a href='religion.php' target="_blank">[Go]</a><br>
EFO;
//4. Create Group(optional) &nbsp;&nbsp; <a href='../system/admin.php?fct=groups' target="_blank">[Go]</a><br>
//5. Create User(option) &nbsp;&nbsp; <a href='../system/admin.php?fct=users' target="_blank">[Go]</a><br>
require(XOOPS_ROOT_PATH.'/footer.php');

?>

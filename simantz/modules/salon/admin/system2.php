<?php
	include_once (XOOPS_ROOT_PATH.'/mainfile.php');
	include_once (XOOPS_ROOT_PATH.'/header.php');
	
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$tablecustomer=$tableprefix . "simsalon_customer";
	$tableuser= $tableprefix . "users";
	$rowperpage=50;
	$thstyle="style='text-align: center;' " ;
	$tdstyle[0]="class='even' style='text-align:center;' ";
	$tdstyle[1]="class='odd' style='text-align:center;'"	
	

	?>

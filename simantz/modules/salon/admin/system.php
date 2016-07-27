<?php
	include_once "../../../mainfile.php" ;
	include_once (XOOPS_ROOT_PATH.'/mainfile.php');
//	include_once (XOOPS_ROOT_PATH.'/header.php');
	include_once( "admin_header.php" );
	
	$tableprefix= XOOPS_DB_PREFIX . "_";

	$tableuser= $tableprefix . "users";
	//$rowperpage=50;
	//$thstyle="style='text-align: center;' " ;
	//$tdstyle[0]="class='even' style='text-align:center;' ";
	//$tdstyle[1]="class='odd' style='text-align:center;'"	
	
	$rowperpage=50;
	$pausetime=0;
	$tokenlife=86400;
	

	?>

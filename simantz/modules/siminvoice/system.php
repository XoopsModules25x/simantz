<?php
include_once ('../../mainfile.php');
include_once (XOOPS_ROOT_PATH.'/header.php');
$url=XOOPS_URL;
$tableprefix= XOOPS_DB_PREFIX . "_";

$tableuser= $tableprefix . "users";
$rowperpage=50;
$pausetime=0;
$tokenlife=86400;

	?>

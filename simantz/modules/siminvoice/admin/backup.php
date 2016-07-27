<?php
include_once "admin_header.php" ;

include 'config.php';
include 'opendb.php';
$dbname=XOOPS_DB_NAME;
$dbpass=XOOPS_DB_PASS;
$dbuser=XOOPS_DB_USER;
$dbhost=XOOPS_DB_HOST;
$backupFile = "../upload/simtrain-backup.sql";
$command = "mysqldump -h $dbhost -u $dbuser -p$dbpass --databases $dbname > $backupFile";

system($command);
header("Content-disposition: attachment; filename=$backupFile");
header('Content-type: text/x-vhdl');
readfile($backupFile);


include 'closedb.php'
?>
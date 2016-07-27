<?php
include_once "admin_header.php" ;
//include 'system.php';
#include 'config.php';
#include 'opendb.php';
$dbname=XOOPS_DB_NAME;
$dbpass=XOOPS_DB_PASS;
$dbuser=XOOPS_DB_USER;
$dbhost=XOOPS_DB_HOST;


srand(time());
$random = (rand()%999);

if(PHP_OS=='WINNT'){
$backupFile = "..\\upload\\tmp\\backup$random.sql";
$mysqlaction="d:\\wamp\\bin\\mysql\\mysql5.0.51a\\bin\\mysqldump.exe";
system("del ..\\upload\\tmp\backup*.sql;");

system("echo SET FOREIGN_KEY_CHECKS=0; > $backupFile");
system("$mysqlaction --no-create-db -h $dbhost -u $dbuser -p$dbpass $dbname >> $backupFile");

header("Content-disposition: attachment; filename=$backupFile");
header('Content-type: file/x-vhdl');
readfile($backupFile);

}
else{
$backupFile = "../upload/tmp/backup$random.sql";
$mysqlaction="/usr/bin/mysqldump";
system("rm -rf ../upload/tmp/backup*.sql");
system("echo 'SET FOREIGN_KEY_CHECKS=0;' > $backupFile");
system("$mysqlaction --no-create-db -h $dbhost -u $dbuser -p$dbpass $dbname >> $backupFile");
header("Content-disposition: attachment; filename=$backupFile;");
header('Content-type: file/x-vhdl');
readfile($backupFile);

}


?>

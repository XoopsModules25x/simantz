<?php
include_once "admin_header.php" ;
include "../setting.php";
#include 'config.php';
#include 'opendb.php';
$dbname=XOOPS_DB_NAME;
$dbpass=XOOPS_DB_PASS;
$dbuser=XOOPS_DB_USER;
$dbhost=XOOPS_DB_HOST;


//srand(time());
//$random = (rand()%999);

if(PHP_OS=='WINNT'){
$backupFile = "..\\".$uploadpath."\\backup.sql";
$mysqlaction="d:\wamp\bin\mysql\mysql5.0.51a\bin\mysqldump.exe";
system("del backup\\backup*;");
system("echo SET FOREIGN_KEY_CHECKS=0; > $backupFile");
system("echo SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO'; >> $backupFile");
system("$mysqlaction --routines --no-create-db -h $dbhost -u $dbuser -p'$dbpass' --add-drop-table --routines  $dbname >> $backupFile");
system("zip -q -P '$dbpass' $backupFile.zip $backupFile > backup\\log.log");
}
else{
$backupFile = "../$uploadpath/backup.sql";

//$mysqlaction="/usr/bin/mysqldump";
$mysqlaction="mysqldump";
system("rm -rf ../$uploadpath/*.sql;");

system("echo 'SET FOREIGN_KEY_CHECKS=0;' > $backupFile");
system("echo 'SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";' >> $backupFile");
system("$mysqlaction --routines --no-create-db -h $dbhost -u $dbuser -p'$dbpass' --add-drop-table --routines  $dbname >> $backupFile");
system("zip -q -P  '$dbpass' $backupFile.zip $backupFile");
die;
}
//echo  "???".filesize("$backupFile.zip");
//die;
header('Content-Type: application/force-download');
header('Content-Type: application/zip');
header('Content-Type: application/download');
header('Content-Description: File Transfer');
header('Content-Length: ' . filesize("$backupFile.zip"));
header("Content-disposition: attachment; filename=$backupFile".".zip");


$fp = fopen("$backupFile.zip", "r");
while (!feof($fp))
{
    echo fread($fp, 65536);
    flush(); // this is essential for large downloads
} 
fclose($fp); 


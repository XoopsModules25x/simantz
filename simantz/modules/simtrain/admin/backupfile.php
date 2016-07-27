<?php
//include_once "admin_header.php" ;
include 'system.php';
include 'config.php';
include 'opendb.php';
$dbname=XOOPS_DB_NAME;
$dbpass=XOOPS_DB_PASS;
$dbuser=XOOPS_DB_USER;
$dbhost=XOOPS_DB_HOST;
/*
$destinatefolder=XOOPS_ROOT_PATH."/../backup";
$backupFile = "$destinatefolder/simtrain.tar.gz";
unlink("$destinatefolder/simtrain.tar.gz");
$command = "tar cvzf $destinatefolder/simtrain.tar.gz " . XOOPS_ROOT_PATH . " >/dev/null " ;

system($command);
*/
$uploadfolder="../upload/";

$backupFile = "$uploadfolder/tmp/simtrainattachment.tar.gz";
unlink($backupFile);
$command = "tar cvzf $backupFile $uploadfolder/products $uploadfolder/receipt $uploadfolder/students $uploadfolder/tuitionclass >/dev/null " ;
system($command);

//header("Content-disposition: attachment; filename=$backupFile");
//header('Content-type: gzip/x-vhdl');
//readfile($backupFile);
 //redirect_header( "$backupFile",3,"Your data is compressed, download  within 3 second.");
header("Content-disposition: attachment; filename=$backupFile");
header('Content-type: text/x-vhdl');
readfile($backupFile);
include 'closedb.php'
?>

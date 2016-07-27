<?php
include_once "admin_header.php" ;

include 'config.php';
include 'opendb.php';
$dbname=XOOPS_DB_NAME;
$dbpass=XOOPS_DB_PASS;
$dbuser=XOOPS_DB_USER;
$dbhost=XOOPS_DB_HOST;
$destinatefolder=XOOPS_ROOT_PATH."/../backup";
$backupFile = "$destinatefolder/salon.tar.gz";
unlink("$destinatefolder/salon.tar.gz");
$command = "tar cvzf $destinatefolder/salon.tar.gz " . XOOPS_ROOT_PATH . " >/dev/null " ;

system($command);
//header("Content-disposition: attachment; filename=$backupFile");
//header('Content-type: gzip/x-vhdl');
//readfile($backupFile);
 redirect_header(XOOPS_URL . "/../backup/salon.tar.gz",3,"Your data is compressed, download  within 3 second.");

include 'closedb.php'
?>

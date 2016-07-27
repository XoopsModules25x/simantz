<?php
include_once "admin_header.php" ;
xoops_cp_header();

include 'config.php';
include 'opendb.php';
$dbname=XOOPS_DB_NAME;
$dbpass=XOOPS_DB_PASS;
$dbuser=XOOPS_DB_USER;
$dbhost=XOOPS_DB_HOST;
//$backupFile = "../upload/simsalon-backup.sql";

if (isset($_POST['submit'])){
$tmpfile= $_FILES["upload_file"]["tmp_name"];
$filesize=$_FILES["upload_file"]["size"] / 1024;
$filetype=$_FILES["upload_file"]["type"];
$filename=$_FILES["upload_file"]["name"];
//echo "$tmpfile, $filesize, $filetype, $filename";

move_uploaded_file($tmpfile, "restorefile/restore.sql");
$restoreFile="restorefile/restore.sql";
$command = "mysql -h $dbhost -u $dbuser -p$dbpass -D$dbname < $restoreFile ; echo $?";

//system($command);
if(system("$command") == 1)
 redirect_header("index.php",3,"<b style='color: red;'>Restoration Failed! Please check your source file.</b>");

else
 redirect_header("index.php",3,"<b>Restoration successfully.</b>");



}
else{
echo <<< EOF


<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Restore Database</span></big></big></big></div><br>

<form name="frmRestore"  enctype="multipart/form-data" method="POST" action='restore.php' onsubmit="return confirm('Confirm to restore this file? Invalid file can cause database corruption! Backup current database before perform system restore!! Click OK if you had backup current database.');">
File Name 
<input type='file'  size="50" name='upload_file' title="Ensure you upload correct data file, invalid file can cause database corruption! Backup current database before perform system restore!!"><br>
<input type='submit' value='submit' name='submit'><input type='reset' value='reset' name='reset'>

</form>

EOF;

}

//header("Content-disposition: attachment; filename=$backupFile");
//header('Content-type: text/x-vhdl');
//readfile($backupFile);


include 'closedb.php';
xoops_cp_footer();
?>

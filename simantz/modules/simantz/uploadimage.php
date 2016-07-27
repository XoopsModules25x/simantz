<?php
//include_once "admin_header.php" ;

include 'system.php';
	include 'menu.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

//xoops_cp_header();
if (isset($_POST['submit'])){
//echo "type:" .$_POST['submit'] . "/".$_GET['submit'] ."<br>";

$tmpfile1= $_FILES["logobk"]["tmp_name"];
$filesize1=$_FILES["logobk"]["size"] / 1024;
$filetype1=$_FILES["logobk"]["type"];
$filename1=$_FILES["logobk"]["name"];

$tmpfile2= $_FILES["attlistlogo"]["tmp_name"];
$filesize2=$_FILES["attlistlogo"]["size"] / 1024;
$filetype2=$_FILES["attlistlogo"]["type"];
$filename2=$_FILES["attlistlogo"]["name"];

$tmpfile3= $_FILES["namecardbg"]["tmp_name"];
$filesize3=$_FILES["namecardbg"]["size"] / 1024;
$filetype3=$_FILES["namecardbg"]["type"];
$filename3=$_FILES["namecardbg"]["name"];

$tmpfile4= $_FILES["namecardbgback"]["tmp_name"];
$filesize4=$_FILES["namecardbgback"]["size"] / 1024;
$filetype4=$_FILES["namecardbgback"]["type"];
$filename4=$_FILES["namecardbgback"]["name"];

if($filesize1 == 0 || $filesize1 > 1000)
echo "Image 1  $tmpfile1,$filesize1 error!<br>";
else{
move_uploaded_file($tmpfile1, "$uploadpath/images/logobk.jpg");
echo "Image 1 $tmpfile1, $filesize1 ok! $a<br>";

}

if($filesize2 ==0 || $filesize2>1000)
echo "Image 2  $tmpfile2,$filesize2 error!<br>";
else{
echo "Image 2 $tmpfile2,$filesize2 ok!<br>";
move_uploaded_file($tmpfile2, "$uploadpath/images/attlistlogo.jpg");
}
if($filesize3== 0 || $filesize3>1000)
echo "Image 3 $tmpfile3,$filesize3 error!<br>";
else{
echo "Image 3 $tmpfile3, $filesize3 ok!<br>";
move_uploaded_file($tmpfile3, "$uploadpath/images/namecardbg.jpg");
}
if($filesize4== 0 || $filesize4>1000)
echo "Image 4  $tmpfile4,$filesize4 error!<br>";
else{
echo "Image 4  $tmpfile4,$filesize4 ok!<br>";

move_uploaded_file($tmpfile4, "$uploadpath/images/namecardbgback.jpg");
}


}


$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);

//$pausetime=20;
$action="";

echo <<< EOF
<table border='1'><tbody><tr><td colspan='2' class='head'>Image Detail</td></tr>
<form action="uploadimage.php" method="POST" id="frmUpload" name='frmUpload' onSubmit="return confirm('Overwrite existing image?')" 
	 enctype="multipart/form-data">
<tr><td class='head'>
		<img src='$uploadviewpath/images/logobk.jpg'><br>
		Receipt and Payslip Logo<br>
		81 Pixel x 60 Pixel</td>
	<td class='odd'><input type='File' name='logobk'></td></tr>
<tr><td class='head'>
		<img src='$uploadviewpath/images/attlistlogo.jpg'>
		<br>General Report Logo<br>400 Pixel x 106 Pixel</td>
	<td class='odd'><input type='File' name='attlistlogo'></td></tr>
<tr><td class='head'>
		<img src='$uploadviewpath/images/namecardbg.jpg'><br>
		Student Card (Front)<br>353 Pixel x 219 Pixel</td>
		<td class='odd'><input type='File' name='namecardbg'></td></tr>
<tr><td class='head'>
		<img src='$uploadviewpath/images/namecardbgback.jpg'><br>
		Student Card (Back)<br>353 Pixel x 219 Pixel</td>
		<td class='odd'><input type='File' name='namecardbgback'></td></tr>
<tr>
	<td colspan='2'><input type='reset' name'reset' value='reset'><input type='submit' name='submit' value='save'></td>
</tr>
</form>

</tbody>
</table>
EOF;

require(XOOPS_ROOT_PATH.'/footer.php');

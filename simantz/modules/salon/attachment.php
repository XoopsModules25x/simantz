<?php
include "system.php";

echo <<< EOF
<form method="post" action="attachment.php" enctype="multipart/form-data">
File Name <input type='file' name="upload_file" size="70">
	<input name="submit" value="submit" type="submit">
</form>

EOF;


if(isset($_POST['submit'])){

$uploaddir = '/var/www/simsalon/modules/salon/upload/';
$uploadfile = $uploaddir . basename($_FILES['upload_file']['name']);

echo "<table border=\"1\">";
echo "<tr><td>Client Filename: </td>
   <td>" . $_FILES["upload_file"]["name"] . "</td></tr>";
echo "<tr><td>File Type: </td>
   <td>" . $_FILES["upload_file"]["type"] . "</td></tr>";
echo "<tr><td>File Size: </td>
   <td>" . ($_FILES["upload_file"]["size"] / 1024) . " Kb</td></tr>";
echo "<tr><td>Name of Temporary File: </td>
   <td>" . $_FILES["upload_file"]["tmp_name"] . "</td></tr>";
echo "</table>";

if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadfile)) {

    echo "File is valid, and was successfully uploaded.<br>";


} else {
    echo "Possible file upload attack!<br>";
}

echo 'Here is some more debugging info:';
print_r($_FILES);
echo "<a href='upload/".basename($_FILES['upload_file']['name'])."'>".basename($_FILES['upload_file']['name'])."</A>";

  
// Where the file is going to be placed 
}
?>

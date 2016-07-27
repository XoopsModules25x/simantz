<?php

include ("../class/upload_class.php");
include_once "../class/Simit_File.inc.php";
error_reporting(E_ALL);

$max_size = 1024*1024; // the max. size for uploading (~1MB)
define("MAX_SIZE", $max_size);
$foto_upload = new muli_files();

$foto_upload->upload_dir = "new/"; // "files" is the folder for the uploaded files (you have to create these folder)
$foto_upload->foto_folder = "new/photo/";
$foto_upload->thumb_folder = "new/thumb/";
$foto_upload->extensions = array(".jpg",".png"); // specify the allowed extension(s) here
$foto_upload->language = "en";
$foto_upload->x_max_size = 300;
$foto_upload->y_max_size = 200;
$foto_upload->x_max_thumb_size = 120;
$foto_upload->y_max_thumb_size = 150;

if (isset($_POST['Submit']) && $_POST['Submit'] == "Upload") {
	$foto_upload->the_temp_file = $_FILES['upload']['tmp_name'];
	$foto_upload->the_file = $_FILES['upload']['name'];
	$foto_upload->http_error = $_FILES['upload']['error'];
	$foto_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : "n"; // because only a checked checkboxes is true
	$foto_upload->do_filename_check = "n";
	if ($foto_upload->upload()) {
		$foto_upload->process_image(false, true, 80);
		$foto_upload->message[] = "Processed foto: ".$foto_upload->file_copy."!"; // "file_copy is the name of the foto"
	}
}
$error = $foto_upload->show_error_string();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Photo-upload form</title>

<style type="text/css">
<!--
body {
	text-align:center;
}
label {
	margin:0;
	float:left;
	display:block;
	width:120px;
}
#main {
	width:350px;
	margin:0 auto;
	padding:20px 0;
	text-align:left;
}
-->
</style>
</head>
<body>
<div id="main">
  <h1>Photo-upload form</h1>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_size; ?>"><br>
	<div>
	  <label for="upload">Select a foto</label>
	<input type="file" name="upload" id="upload" size="35"></div>
    <div>
      <label for="replace">Replace an old foto?</label>
    <input type="checkbox" name="replace" value="y"></div>
	<p style="margin-top:25px;text-align:center;"><input type="submit" name="Submit" id="Submit" value="Upload">
	</p>
  </form>
  <p><?php echo $error; ?></p>
</div>
</body>
</html>
<?php
        header('Content-type: image/png');
	$photofile=$_GET['file'];
	if(!file_exists($photofile)){
	$photofile="chartcache/chart0.png";
	$image=ImageCreateFromPNG($photofile);
	imagepng($image);
	imagedestroy($image);
	}
	else{
	//$photofile="chartcache/chart0.png>";
	$image=ImageCreateFromPNG($photofile);
	imagepng($image);
	imagedestroy($image);
	unlink($photofile);
	}
?>
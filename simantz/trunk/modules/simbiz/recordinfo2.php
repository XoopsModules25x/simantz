<?php
include_once "system.php";
include_once "class/Log.php";
$tableuser=$tableprefix."users";
$tablename=$_POST['tablename'];
$recordid=$_POST['id'];
$idname=$_POST['idname'];
$title=$_POST["title"];
$isadmin=$xoopsUser->isAdmin();
$log=new Log();

$sql="SELECT created,u1.uname as createdby,updated,u2.uname as updatedby from $tablename t left outer join $tableuser u1 on t.createdby=u1.uid ".
	" left outer join $tableuser u2 on t.updatedby=u2.uid where $idname=$recordid";
$log->showLog(3,"With SQL: $sql");
$query=$xoopsDB->query($sql);
if( $isadmin){
if($row=$xoopsDB->fetchArray($query)){
	$created=$row['created'];
	$updated=$row['updated'];
	$createdby=$row['createdby'];
	$updatedby=$row['updatedby'];

	echo <<< EOF
	<html>
	<title>Record Information for $title</title>
	<body>
	<h1>$title record info</h1>
	Record ID: $recordid <br>
	Created By: $createdby <br>
	Created On: $created <br>
	Updated By: $updatedby <br>
	Updated On: $updated <br>
	
	</body>
	</html>
EOF;

}
else
echo <<< EOF
<html>
<title>Record Information for $title</title>
<body>
<h1>$title record info</h1>
<b style="color:red">Error! Cannot find further information, this record may not have further information</b>

</body>
</html>
EOF;
}
else
echo <<< EOF
<html>
<title>Record Information for $title</title>
<body>
<h1>$title record info</h1>
<b style="color:red">Access denied! You can't access to this info.</b>

</body>
</html>
EOF;
?>

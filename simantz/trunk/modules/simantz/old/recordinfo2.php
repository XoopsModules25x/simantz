<?php
include_once "system.php";
include_once "menu.php";
zinclude_once "../system/class/Log.php";
$tableuser=$tableprefix."users";
$tablename=$_GET['tablename'];
$recordid=$_GET['id'];
$idname=$_GET['idname'];
$title=$_GET["title"];
$isadmin=$xoopsUser->isAdmin();
$log=new Log();

if($recordid > 0){
$whereid = " $idname=$recordid ";
$whereid2 = "and record_id=$recordid";
}else{
$whereid = "1";
$whereid2 = "and record_id>0";
}
 $sql="SELECT created,u1.uname as createdby,updated,u2.uname as updatedby
    from $tablename t left outer join $tableuser u1 on t.createdby=u1.uid 
	 left outer join $tableuser u2 on t.updatedby=u2.uid where $whereid";

 $sql2="SELECT at.updated,at.uname,at.eventype,at.category,at.changedesc ,at.ip from sim_audit at
		where tablename='$tablename' $whereid2 order by at.updated";

$log->showLog(3,"With SQL: $sql<br>$sql2");
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
	Last Updated By: $updatedby <br>
	Last Updated On: $updated <br>
	

	<table border='1'><tbody>
		<tr>
		<th style="text-align:center;" >No</th>
		<th style="text-align:center;">Date/Time</th>
		<th style="text-align:center;">User</th>
		<th style="text-align:center;">Category</th>
		<th style="text-align:center;">Event Type</th>
		<th style="text-align:center;">IP</th>
		<th  style="text-align:center;">Activity</th></tr>

EOF;
$query2=$xoopsDB->query($sql2);
$i=0;
while ($rowdetail=$xoopsDB->fetchArray($query2)){
$updated=$rowdetail['updated'];
$uname=$rowdetail['uname'];
$ip=$rowdetail['ip'];
switch($rowdetail['category']){
case "I":
$category="Insert";
break;
case "U":
$category="Update";
break;
case "D":
$category="Delete";
break;
case "E":
$category="Purge";
break;

}
if($rowdetail['eventype']=='S')
$eventype='Success';
else
$eventype='<b style="color:red">Failed</b>';


$sqlstr=$rowdetail['changedesc'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
$i++;
echo <<< EOF

		<tr>
		<td class="$rowtype">$i</td>
		<td class="$rowtype">$updated</td>
		<td class="$rowtype">$uname</td>
		<td class="$rowtype">$category</td>
		<td class="$rowtype">$eventype</td>
		<td class="$rowtype">$ip</td>
		<td class="$rowtype">$sqlstr</td></tr>

EOF;
}


echo <<< EOF
</tr></tbody></table>
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
require(XOOPS_ROOT_PATH.'/footer.php');
?>

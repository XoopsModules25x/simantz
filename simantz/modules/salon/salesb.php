<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once "menu.php";
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

echo <<< EOF
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../xoops.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../themes/default/style.css">

<body style=" background: gainsboro;">
EOF;
echo "<table><tr align='center'><td><b>Add Customer List</b></td></tr></table>";

$log = new Log();
$uid = $xoopsUser->getVar('uid');
$uname = $xoopsUser->getVar('uname');
$tableremarks=$tableprefix."tblremarks";
$tablecustomer=$tableprefix."tblcustomer";
$tablejobcontrol=$tableprefix."tbljobcontrol";
$tablehistory = $tableprefix."tblhistory";

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

$datectrl=$dp->show("jobcontrol_date");

$timestamp= date("Y-m-d H:i:s", time()) ;

$issave = $_POST['issave'];



if($issave=="save"){//save record
	
	$strlen = strlen($timestamp);
	$jobcontrol_date .=  substr($timestamp,10,$strlen);

	$sql = "INSERT INTO $tableremarks (remarks_desc,jobcontrol_id,created,createdby,uname) values ('$remarks_desc',$jobcontrol_id,'$jobcontrol_date',$uid,'$uname')";
	
	$sqlupdate = "UPDATE $tablejobcontrol set jobcontrol_remarks = '$remarks_desc' WHERE jobcontrol_id = $jobcontrol_id ";

	$sqlhistory = 	"INSERT INTO $tablehistory (history_action,history_date,history_uid,history_windows,history_windowsid) 
			values ('edit','$timestamp',$uid,3,$jobcontrol_id) ";
	
	$log->showLog(4,"Before insert jobcontrol SQL:$sql");
	$rs=$xoopsDB->query($sql);
	
	if (!$rs){
		$log->showLog(1,"Failed to insert remarks");
	}
	else{
		$log->showLog(3,"Inserting new successfully"); 
	}
	
	$rs=$xoopsDB->query($sqlupdate);
	
	if (!$rs){
		$log->showLog(1,"Failed to update remarks");
	}
	else{
		$log->showLog(3,"Update remarks successfully"); 
	}

	$rs=$xoopsDB->query($sqlhistory);//insert history
	
	if (!$rs){
		$log->showLog(1,"Failed to update history");
	}
	else{
		$log->showLog(3,"Update history successfully"); 
	}


}



$sql = "SELECT * from $tableremarks where jobcontrol_id = $jobcontrol_id order by created DESC";
$query=$xoopsDB->query($sql);

echo <<< EOF


<br>

<table border=1>
<form name="frmRemarks" method="POST" onsubmit="return saveRemarks();">

</form>
</table>
<br>


</body>
EOF;



	function getClientName($tableprefix,$xoopsDB,$jobcontrol_id,$fld){
	$tableremarks=$tableprefix."tblremarks";
	$tablecustomer=$tableprefix."tblcustomer";
	$tablejobcontrol=$tableprefix."tbljobcontrol";
	$tablebranch=$tableprefix."tblbranch";
	$tabledept=$tableprefix."tbldept";
	
	$retval = "";
	$sql = "SELECT $fld as fld from $tablecustomer a, $tablejobcontrol b, $tablebranch c, $tabledept d 
		where b.jobcontrol_id = $jobcontrol_id 
		and c.branch_id = b.jobcontrol_outletid
		and d.dept_id = b.jobcontrol_dept
		and a.customer_id = b.jobcontrol_clientid";
	
	$query=$xoopsDB->query($sql);
	
	if($row=$xoopsDB->fetchArray($query)){
	$retval = $row['fld'];
	}
	
	return $retval;
	}


?>

<script type="text/javascript">

function saveRemarks(){
var remarks = document.forms['frmRemarks'].remarks_desc.value

if(confirm("Confirm save this data?")==true){
	if(remarks==""){
	alert('Please make sure Remarks is filled in.');
	return false;
	}else{	
	document.forms['frmRemarks'].issave.value = "save";
	return true;
	}
}else{
return false;
}

}

</script>


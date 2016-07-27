<?php
include_once ('../../mainfile.php');
include_once (XOOPS_ROOT_PATH.'/header.php');
$url=XOOPS_URL;
$tableprefix= XOOPS_DB_PREFIX . "_";
$tableworker=$tableprefix . "simfworker_worker";
$tablecompany=$tableprefix . "simfworker_company";
$tableloanpayment=$tableprefix."simfworker_loanpayment";
$tableuser= $tableprefix . "users";
$rowperpage=50;
$pausetime=2;
$tokenlife=600;

function workerstatusctrl($workerstatus){
$selectactive="";
$selectresigned="";
$selectabsconded="";
$selectterminated="";
switch ($workerstatus){
case "active":
$selectactive="SELECTED='SELECTED'";

break;
case "resigned":
$selectresigned="SELECTED='SELECTED'";

break;
case "absconded":
$selectabsconded="SELECTED='SELECTED'";

break;
case "terminated":
$selectterminated="SELECTED='SELECTED'";

break;
default;

}

$result="<SELECT name='workerstatus'>".
		"<option value='active' $selectactive>Active</option>".
		"<option value='resigned' $selectresigned>Resigned</option>".
		"<option value='absconded' $selectabsconded>Absconded</option>".
		"<option value='terminated' $selectterminated>Terminated</option>".
	"</SELECT>";
return $result;
}


	?>

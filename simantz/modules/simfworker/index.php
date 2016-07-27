<?php
include_once "system.php" ;
include_once "class/WorkPermit.php";
include_once "class/LoanPayment.php";
include_once "class/Checkup.php";
include_once "class/Log.php";

$log = new Log();
$wp = new WorkPermit($xoopsDB,$tableprefix,$log);
$m = new Checkup($xoopsDB,$tableprefix,$log);
$lp = new LoanPayment($xoopsDB,$tableprefix,$log);

include_once "menu.php";

$aligncenter= 'style="text-align: center"';
//$newdate=date("Y-m-d",(strtotime("2008-07-11")+60*60*24*($OFFSET))) . "??".strtotime("2008-07-11");
//$newdate=date("Y-m-d",strtotime("2008-1-31")).'//'.date("Y-m-d",strtotime("+1 month",strtotime("2008-1-31")));
echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Expiry Reminder $newdate</span></big></big></big></div><br>

EOF;
$today=date("Y-m-d");
$wp->showExpiredTable("WHERE to_days(m.expired_date)<=to_days(now())+60 AND m.permitstatus in ('I','P')","ORDER BY c.company_name",0,9999);
echo "<BR>";
$m->showExpiredTable("WHERE to_days(m.expired_date)<=to_days(now())+60 AND m.result in ('I','P')","ORDER BY c.company_name",0,9999);
echo "<br>";

$lp->showExpiredTable("WHERE lp.loanpayment_status=1 AND lp.type=1 AND ".
	"(SELECT max(tlp2.nextpayment_date) FROM $tableloanpayment tlp2 ".
		  "WHERE tlp2.loanpayment_id = lp.loanpayment_id or tlp2.reference_id=lp.loanpayment_id) < '$today' AND".
	"(SELECT sum(tlp1.amount*tlp1.type) FROM $tableloanpayment tlp1 ".
		  "WHERE tlp1.loanpayment_id = lp.loanpayment_id or tlp1.reference_id=lp.loanpayment_id) <>0",
			"ORDER BY w.worker_name",0,9999);

require(XOOPS_ROOT_PATH.'/footer.php');

?>


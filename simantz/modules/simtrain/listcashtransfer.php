<?php
 
include_once "system.php";
include_once ("menu.php");

include_once "class/Log.php";
include_once "class/Employee.php";
include_once "class/CashTransfer.php";
include_once ("datepicker/class.datepicker.php");


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$o = new CashTransfer($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);
$o->currentuid=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$showcalendar1=$dp->show("datefrom");
$showcalendar2=$dp->show("dateto");
$userctrl=$permission->selectAvailableSysUser(-1);

$action=$_POST['search'];


echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Search Cash Transfer Activity</span></big></big></big></div>-->

<form name="frmSearchCashTransfer" action="listcashtransfer.php" method="POST">
<table border='1'>
  <tbody>
    <tr>
      <td class="head">User</td>
      <td class="even">$userctrl</td>
      <td class="even"></td>
    </tr>
    <tr>
      <td class="head">Cash Transfer Date</td>
      <td class="odd"><input id='datefrom' name='datefrom'><input type='button' value='Date' onClick="$showcalendar1"></td>
      <td class="odd"><input id='dateto' name='dateto'><input type='button' value='Date' onClick="$showcalendar2"></td>
    </tr>

    <tr>
      <td class="head"><input type="reset" value="reset" name="reset"></td>
      <td class="head"><input type="submit" value="search" name="action"></td>
      <td class="head"></td>
    </tr>
  </tbody>	
</table>

</form>
EOF;

if (!isset($action)){
$datefrom=$_POST['datefrom'];
$dateto=$_POST['dateto'];

$uid=$_POST['uid'];
$wherestr=genWhereString($uid,$datefrom,$dateto);

if ($wherestr!="")
$wherestr .= " and cf.organization_id = $defaultorganization_id ";
else
$wherestr .= " cf.organization_id = $defaultorganization_id ";

if ($wherestr!="")
$wherestr="WHERE ". $wherestr;

$log->showLog(3,"Generated Wherestring=$wherestr");

$o->showCashTransferTable( $wherestr,  "order by cashtransfer_no desc",  0 ); 
}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

function genWhereString($uid,$datefrom,$dateto){
$filterstring="";
$needand="";
if($uid > 0 ){
	$filterstring=$filterstring . " u.uid=$uid";
	$needand='AND';
}
else
	$needand='';

if ($datefrom !="" && $dateto!="")
	$filterstring= $filterstring . "  $needand date_format( cf.transferdatetime, '%Y-%m-%d' )  between '$datefrom' and '$dateto'";

return $filterstring;
}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');
?>

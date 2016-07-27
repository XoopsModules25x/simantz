<?php
//require('../../mainfile.php');
//require(XOOPS_ROOT_PATH.'/header.php');
include "system.php";
//header('Content-type: text/xml');
include "class/nitobi.xml.php";
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
//$log->cleanLog();
$log->showLog(2, "Show parent note with sql");

$treeId='tree1';

if (isset($_GET['treeId'])) {
  $treeId = $_GET['treeId'];
 }
 $nodeId='0';

if (isset($_GET['id'])) {
  $nodeId = $_GET['id'];
 }

//$log->showLog(2, "Show parent note with sql : $myQuery");
/*
 * SELECT distinct(w.window_id) as window_id,w.window_name, w.filename, m.name as modulename,m.dirname
                from sim_groups g
		inner join sim_groups_users_link gul on g.groupid=gul.groupid
		inner join sim_users u on gul.uid=u.uid
		inner join sim_group_permission gp on gp.gperm_groupid=g.groupid
		inner join sim_modules m on gp.gperm_itemid=m.mid
		inner join sim_permission gsp on gsp.groupid=g.groupid
		inner join sim_window w on gsp.window_id=w.window_id
		where m.mid=$module_id and gp.gperm_name='module_read'
                    and w.parentwindows_id=$parentwindows_id and u.uid=$uid and
                    w.isactive=1 and w.window_id>0
                  and ( gsp.validuntil = '0000-00-00' OR gsp.validuntil >= '$currentdate')
 */
$currentdate=date("Y-m-d",time());
 $myQuery = "SELECT distinct(w.window_id) as window_id,w.window_name, w.filename, m.name as modulename,m.dirname
                from sim_groups g
		inner join sim_groups_users_link gul on g.groupid=gul.groupid
		inner join sim_users u on gul.uid=u.uid
		inner join sim_group_permission gp on gp.gperm_groupid=g.groupid
		inner join sim_modules m on gp.gperm_itemid=m.mid
		inner join sim_permission gsp on gsp.groupid=g.groupid
		inner join sim_window w on gsp.window_id=w.window_id
		where gp.gperm_name='module_read'
                    and w.parentwindows_id=$nodeId and u.uid=$userid and
                    w.isactive=1 and w.window_id>0
                  and ( gsp.validuntil = '0000-00-00' OR gsp.validuntil >= '$currentdate')";
$log->showLog(2, "Show parent note with sql : $myQuery");
 $result = $xoopsDB->query($myQuery) or die(mysql_error());
 //system("echo $myQuery >>log.txt");
$getHandler = new EBAGetHandler();

$getHandler->DefineField("window_id");
$getHandler->DefineField("window_name");
$getHandler->DefineField("nodetype");
$getHandler->DefineField("haschildren");
while ($row = $xoopsDB->fetchArray($result))
{

  $record = new EBARecord($row["window_id"]);

  $record->add("id",  $row["window_id"]);
  $record->add("label", $row["window_name"]);

   $myQuery = 'SELECT COUNT(1) AS NumChildren FROM sim_window WHERE parentwindows_id = '.$row['window_id'].';';

  $countChildren = $xoopsDB->fetchArray($xoopsDB->query($myQuery)) or die(mysql_error());
  $numChildren = $countChildren["NumChildren"];

  if ($numChildren > 0) {
   $record->add("nodetype",  "node");
   $record->add("haschildren", "true");
  } else {
   $record->add("nodetype", "leaf");
   $record->add("haschildren", "false");
  }

  $getHandler->add($record);
}
$getHandler->CompleteGet();
?>

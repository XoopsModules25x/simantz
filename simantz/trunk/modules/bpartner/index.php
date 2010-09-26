<?php

include "system.php";
include "menu.php";
include_once 'class/BPartnerList.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$o = new BPartnerList();
$s = new XoopsSecurity();
$action=$_REQUEST['action'];
$isadmin=$xoopsUser->isAdmin();
$uid = $xoopsUser->getVar('uid');

$sqlbpartnerlist="SELECT bp.bpartner_id,bp.bpartner_no,bp.bpartner_name, bp.created,g.bpartnergroup_name from sim_bpartner bp
    inner join sim_bpartnergroup g on bp.bpartnergroup_id=g.bpartnergroup_id
    where  DATE_SUB(CURDATE(),INTERVAL 10 DAY)<= bp.created ";

$newbpartnerlist=<<< EOF
  <table class="tblListRight">
    <tr>
    <td class="tdListRightTitle" colspan="3">New B.Partner</td>
    </tr>
    <tr>
    <td class="tdListRightHeader">No.</td>
    <td class="tdListRightHeader">Name</td>
    <td class="tdListRightHeader">Type</td>
    </tr>

EOF;
$querybpartnerlist=$xoopsDB->query($sqlbpartnerlist);
$rowtype='odd';
while($row=$xoopsDB->fetchArray($querybpartnerlist)){
    $bpartner_no=$row['bpartner_no'];
    $bpartner_id=$row['bpartner_id'];
    $bpartner_name=$row['bpartner_name'];
    $bpartnergroup_name=$row['bpartnergroup_name'];
    $created=$row['created'];
    if($rowtype=='odd')
        $rowtype='even';
    else
        $rowtype='odd';
  $newbpartnerlist.="<tr>
    <td class='$rowtype'>$bpartner_no</td>
    <td class='$rowtype'><a href='bpartner.php?action=viewsummary&bpartner_id=$bpartner_id'>$bpartner_name</a></td>
    <td class='$rowtype'>$bpartnergroup_name</td>
    </tr>";

}
$newbpartnerlist.="</table>";



 $sqlfollowuplist="SELECT bp.bpartner_id,bp.bpartner_no,bp.bpartner_name, f.followup_name,f.followup_name,f.description,f.nextfollowupdate
    from sim_bpartner bp
    inner join sim_followup f on bp.bpartner_id=f.bpartner_id
    where DATE_ADD(CURDATE(),INTERVAL $homepagefollowupday DAY)>= f.nextfollowupdate and f.isactive=1";

$followuplist=<<< EOF
  <table class="tblListRight">
    <tr>
    <td class="tdListRightTitle" colspan="4">Follow Issue</td>
    </tr>
    <tr>
    <td class="tdListRightHeader">No.</td>
    <td class="tdListRightHeader">Name</td>
    <td class="tdListRightHeader">Date</td>
    <td class="tdListRightHeader">Issue</td>
    </tr>

EOF;
$queryfollowuplist=$xoopsDB->query($sqlfollowuplist);
$rowtype='odd';
while($rowfu=$xoopsDB->fetchArray($queryfollowuplist)){
    $bpartner_no=$rowfu['bpartner_no'];
    $bpartner_id=$rowfu['bpartner_id'];
    $bpartner_name=$rowfu['bpartner_name'];
    $followup_name=$rowfu['followup_name'];
    $nextfollowupdate=$rowfu['nextfollowupdate'];
    $description=$rowfu['description'];
    $created=$rowfu['created'];
    if($rowtype=='odd')
        $rowtype='even';
    else
        $rowtype='odd';
  $followuplist.="<tr>
    <td class='$rowtype'>$bpartner_no</td>
    <td class='$rowtype'><a href='bpartner.php?action=viewsummary&bpartner_id=$bpartner_id'>$bpartner_name</a></td>
    <td class='$rowtype'>$nextfollowupdate</td>
    <td class='$rowtype' title='$description'>$followup_name</td>
    </tr>";

}
$followuplist.="</table>";
echo <<< EOF

<table class="tblMainHR">
<tr>
<td  style=" text-align:center">
 <input name='btnSearchBpartner' style='height:30px; width=400px' type='button' value='Search Business Partner' onclick=javascript:window.location='bpartner.php?action=search'>

$newbpartnerlist

</td>

<td >

 <input name='btnSearchBpartner' style='height:30px; width=400px'  type='button' value='Add Business Partner' onclick=javascript:window.location='bpartner.php'>

    $followuplist
</td>
</tr>
</table>
EOF;

require(XOOPS_ROOT_PATH.'/footer.php');


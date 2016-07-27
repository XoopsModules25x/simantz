<?php
include "system.php";
include "menu.php";

include_once 'class/FollowUp.php.inc';
include_once '../system/class/Log.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
include_once "../../class/datepicker/class.datepicker.php";
//include_once "../system/class/Period.php";

$dp=new datepicker($url);
$dp->dateFormat='Y-m-d';
if(isset($_GET['bpartner_id']))
$bpartner_id=$_GET['bpartner_id'];
else
$bpartner_id=0;
if(isset($_GET['employee_id']))
$employee_id=$_GET['employee_id'];
else
$employee_id=0;

if(isset($_GET['followuptype_id']))
$followuptype_id=$_GET['followuptype_id'];
else
$followuptype_id=0;

$bpartnerctrl=$ctrl->getSelectBPartner($bpartner_id,"Y");
$employeectrl=$ctrl->getSelectEmployee($employee_id,"Y");
$followuptypectrl=$ctrl->getSelectFollowUpType($followuptype_id, 'Y');
//global $log ;

$nextfollowupdatefrom=$_GET['nextfollowupdatefrom'];
$nextfollowupdateto=$_GET['nextfollowupdateto'];
$issuedatefrom=$_GET['issuedatefrom'];
$issuedateto=$_GET['issuedateto'];
$isactive=$_GET['isactive'];
eval("\$select$isactive=\"Selected='selected'\";");

$o = new FollowUp();
$s = new XoopsSecurity();
$showNextFollowUpDateFrom=$dp->show('nextfollowupdatefrom');
$showNextFollowUpDateTo=$dp->show('nextfollowupdateto');
$showIssueDateFrom=$dp->show('issuedatefrom');
$showIssueDateTo=$dp->show('issuedateto');

$wherestring="WHERE bp.organization_id=$defaultorganization_id AND";

if($employee_id>0)
$wherestring.=" fl.employee_id=$employee_id AND";
if($bpartner_id>0)
$wherestring.=" bp.bpartner_id=$bpartner_id AND";
if($followuptype_id>0)
$wherestring.=" fl.followuptype_id=$followuptype_id AND";
if($isactive!='n')
$wherestring.=" fl.isactive=$isactive AND";

if($issuedatefrom!="")
$startissuedate=$issuedatefrom;
else
$startissuedate="0000-00-00";

if($issuedateto!="")
$endissuedate=$issuedateto;
else
$endissuedate="2999-12-31";

if($nextfollowupdatefrom!="")
$startfollowuodate=$nextfollowupdatefrom;
else
$startfollowuodate="0000-00-00";

if($nextfollowupdateto!="")
$endfollowuodate=$nextfollowupdateto;
else
$endfollowuodate="2999-12-31";

$wherestring.=" (fl.issuedate BETWEEN '$startissuedate' AND '$endissuedate')
            AND  (fl.nextfollowupdate BETWEEN '$startfollowuodate' AND '$endfollowuodate')
  ";
echo <<< EOF

<form><table>
  <th colspan='4'>Criterial</th>
  <tr>
    <td class='head'>Business Partner</td>
    <td class='even'>$bpartnerctrl</td>
    <td class='head'>P.I.C</td>
    <td class='even'>$employeectrl</td>
  </tr>
  <tr>

    <td class='head'>From Follow Up Date</td>
    <td class='even'><input name='nextfollowupdatefrom' id='nextfollowupdatefrom' value='$nextfollowupdatefrom'><input type='button' name='btndate1' value='Date' onclick="$showNextFollowUpDateFrom"></td>

    <td class='head'>To Follow Up Date</td>
    <td class='even'><input name='nextfollowupdateto' id='nextfollowupdateto' value='$nextfollowupdateto'><input type='button' name='btndate1' value='Date' onclick="$showNextFollowUpDateTo"></td>
  </tr>
  <tr>

    <td class='head'>From Issue Date</td>
    <td class='even'><input name='issuedatefrom' id='issuedatefrom' value='$issuedatefrom' ><input type='button' name='btndate1' value='Date' onclick="$showIssueDateFrom"></td>

    <td class='head'>To Issue Date</td>
    <td class='even'><input name='issuedateto' id='issuedateto' value='$issuedateto'><input type='button' name='btndate1' value='Date' onclick="$showIssueDateTo"></td>
  </tr>
  <tr>

    <td class='head'>Type</td>
    <td class='even'>$followuptypectrl</td>

    <td class='head'>Active</td>
    <td class='even'>
            <SELECT name='isactive' >
                <option $selectn value='n'>Null</option>
                <option $select1 value='1'>Yes</option>
                <option $select0 value='0'>No</option>
            </select>
        </td>
  </tr>
<tr><td><input name='submit' type='submit' value='Search'></td></tr>
</table>
</form>
EOF;

if(isset($_GET['submit'])){
    

$sql="SELECT bp.bpartner_id,bp.bpartner_name,flt.followuptype_name,fl.description,fl.contactperson,
   fl.isactive,fl.nextfollowupdate,fl.issuedate,fl.followup_id
  FROM sim_followup fl
    INNER JOIN sim_followuptype flt on flt.followuptype_id=fl.followuptype_id
    INNER JOIN sim_bpartner bp on bp.bpartner_id=fl.bpartner_id
    INNER JOIN sim_simiterp_employee e on e.employee_id=fl.employee_id
    $wherestring order by fl.issuedate,bp.bpartner_name,flt.followuptype_name";


    echo <<< EOF
    <table>
        <tr><th colspan='8'>Follow Up Issue</th></tr>
        <tr>
            <th style='text-align:center'>No</th>
            <th style='text-align:center'>Issue Date</th>
            <th style='text-align:center'>Bpartner</th>
            <th style='text-align:center'>Type</th>
            <th style='text-align:center'>Follow Date</th>
            <th style='text-align:center'>Person</th>
            <th style='text-align:center'>Isactive</th>
            <th style='text-align:center'>Operation</th>
        </tr>
EOF;
    $query=$xoopsDB->query($sql);
    $i=0;
    while($row=$xoopsDB->fetchArray($query)){
        $i++;
        $bpartner_id=$row['bpartner_id'];
        $bpartner_name=$row['bpartner_name'];
        $followuptype_name=$row['followuptype_name'];
        $description=$row['description'];
        $contactperson=$row['contactperson'];
        $isactive=$row['isactive'];
        $followup_id=$row['followup_id'];
        $nextfollowupdate=$row['nextfollowupdate'];
        $issuedate=$row['issuedate'];
        if($isactive==0)
		{
                  $isactive='N';

		}
		else
		$isactive='Y';

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

                if($nextfollowupdate <= date("Y-m-d",time()))
                    $nextfollowupdate="<b style='color:red'>$nextfollowupdate</b>";
        echo <<< EOF
        <tr>
            <td class='$rowtype'>$i</td>
            <td  class='$rowtype'>$issuedate</td>
            <td  class='$rowtype'><a href='bpartner.php?action=view&bpartner_id=$bpartner_id'>$bpartner_name</a></td>
            <td class='$rowtype'>$followuptype_name</td>
            <td  class='$rowtype'>$nextfollowupdate</td>
            <td class='$rowtype'>$contactperson</td>
            <td  class='$rowtype'>$isactive</td>
            <td  class='$rowtype'><a href='followup.php?action=edit&followup_id=$followup_id'>[View]</a></td>

    </tr>
EOF;

    }
}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');


?>

<?php

include "system.php";
include_once 'class/BPartnerList.php';
if($_REQUEST['action']=="refreshfollowup"){
$o = new BPartnerList();
$s = new XoopsSecurity();
$action=$_REQUEST['action'];
$isadmin=$xoopsUser->isAdmin();
$uid = $xoopsUser->getVar('uid');
//
echo refreshFollowUp();
    die;
}


include "menu.php";


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$o = new BPartnerList();
$s = new XoopsSecurity();
$action=$_REQUEST['action'];
$isadmin=$xoopsUser->isAdmin();
$uid = $xoopsUser->getVar('uid');
//
$xoTheme->addStylesheet("$url/modules/simantz/include/popup.css");
$xoTheme->addScript("$url/modules/simantz/include/popup.js");
$xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');


$sqllastquote="SELECT bp.bpartner_id,bp.bpartner_no,bp.bpartner_name,q.subtotal,q.quotation_id,
        q.document_date,concat(spquotation_prefix,q.document_no) as quotation_no,
        quotation_status,iscomplete,c.currency_code
            from sim_bpartner bp
    inner join sim_bpartner_quotation q on bp.bpartner_id=q.bpartner_id
    inner join sim_currency c on c.currency_id=q.currency_id
    where  DATE_SUB(CURDATE(),INTERVAL 10 DAY)<= q.document_date ";

$lastquotelist=<<< EOF

  <table class="tblListRight">
    <tr>
    <td class="tdListRightTitle" colspan="6">Previous Quotation ($showpreviousquoteinday days)</td>
    </tr>
    <tr>
    <td class="tdListRightHeader">No.</td>
    <td class="tdListRightHeader">Date</td>
    <td class="tdListRightHeader">B.Partner</td>
    <td class="tdListRightHeader">Amount</td>
    <td class="tdListRightHeader">Complete</td>
    <td class="tdListRightHeader">Status</td>

    </tr>

EOF;
$querlastquote=$xoopsDB->query($sqllastquote);
$rowtype='odd';
while($row=$xoopsDB->fetchArray($querlastquote)){
    $bpartner_no=$row['bpartner_no'];
   $bpartner_id=$row['bpartner_id'];
    $bpartner_name=$row['bpartner_name'];
    $quotation_no=$row['quotation_no'];
    $subtotal=$row['subtotal'];
    $document_date=$row['document_date'];
    $iscomplete=$row['iscomplete'];
    $quotation_id=$row['quotation_id'];
    $currency_code=$row['currency_code'];
    if($iscomplete==1){
        $iscomplete="Y";
        $viewmethod="view";
    }
    else{
        $iscomplete="N";
        $viewmethod="edit";
    }

    if($rowtype=='odd')
        $rowtype='even';
    else
        $rowtype='odd';

    $quotation_status=$row['quotation_status'];
  $lastquotelist.="<tr>
    <td class='$rowtype'><a href='salesquotation.php?action=$viewmethod&quotation_id=$quotation_id'>$quotation_no</a></td>
    <td class='$rowtype'>$document_date</td>
    <td class='$rowtype'><a href='bpartner.php?action=viewsummary&bpartner_id=$bpartner_id'>$bpartner_name</a></td>
    <td class='$rowtype'>$currency_code $subtotal</td>
        <td class='$rowtype'>$iscomplete</td>
        <td class='$rowtype'>$quotation_status</td>
        
    </tr>";

}
$lastquotelist.="</table>";






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

$followuplist=refreshFollowUp();

echo <<< EOF
<div id="idApprovalWindows" style="display:none"></div>
<div id='blanket' style='display:none;'></div>
<div id='popUpDiv' style='display:none;verticle-align:center'>
  <div id='popupmessage' style='text-align:center'></div>
  <div id='progressimage' style='text-align:center'><img src='../simantz/images/ajax_indicator_01.gif'></div>
</div>

<table class="tblMainHR">
<tr>
<td  style=" text-align:center;width=40%">
<input name='btnSearchBpartner' style='height:20px; width=100px' type='button' value='Search B/Partner' onclick=javascript:window.location='bpartner.php?action=search'>
<input name='btnSearchBpartner' style='height:20px; width=100px'  type='button' value='Add B/Partner' onclick=javascript:window.location='bpartner.php'>
<input name='btnSearchBpartner' style='height:20px; width=100px'  type='button' value='New Quotation' onclick=javascript:window.location='salesquotation.php'>
<input name='btnSearchBpartner' style='height:20px; width=100px'  type='button' value='Search Quotation' onclick=javascript:window.location='salesquotation.php?action=search'>
<br/>
<img src="chartsalequoteqty_6month.php"><br/>
<img src="chartsalequoteamt_6month.php">
</td>

<td style="width=60%">
$lastquotelist<br/>
$newbpartnerlist<br/>
<div id="followuptable">
    $followuplist
        </div>
</td>
</tr>
</table>




<script type="text/javascript">

function save(){
    if(confirm("Save record?")){
            var data = $("#getFWformid").serialize();
            
            $.ajax({

                 url: "bpartner.php",type: "POST",data: data,cache: false,
                     success: function (xml) {
                     
                        jsonObj = eval( '(' + xml + ')');
                        var status = jsonObj.status;
                        var msg = jsonObj.msg;
                        

                        if(status == 1){
                        closeWindow();
                         followuptable();
                        }
                        else{
                        alert("Cannot update follow up status, please double check your input.");
                        }

                }});

   }
                return false;

}


function followuptable(){
document.getElementById('popupmessage').innerHTML="Please Wait.....";

           
           
             var data="action=refreshfollowup";
                $.ajax({
                url: "index.php",type: "POST",data: data,cache: false,
                success: function (xml) {

                            document.getElementById('followuptable').innerHTML = xml;

           

           

                        
                }});
}

function editFollowUp(followup_id){
document.getElementById('popupmessage').innerHTML="Please Wait.....";

                document.getElementById('idApprovalWindows').style.display = "none";
                popup('popUpDiv');
             var data="action=editfollowuplayer&followup_id="+followup_id;
                $.ajax({
                url: "bpartner.php",type: "POST",data: data,cache: false,
                success: function (xml) {
                
                            document.getElementById('idApprovalWindows').innerHTML = xml;
                            
                            document.getElementById('idApprovalWindows').style.display = "";
              
                            popup('popUpDiv');
                            
                            self.parent.scrollTo(0,0);
                           
                           
                        
                }});
        }

   function closeWindow(){
     document.getElementById('idApprovalWindows').style.display = "none";
   }
</script>
EOF;

require(XOOPS_ROOT_PATH.'/footer.php');




function refreshFollowUp(){

global $xoopsDB,$homepagefollowupday;
 $sqlfollowuplist="SELECT bp.bpartner_id,bp.bpartner_no,bp.bpartner_name, f.followup_name,f.followup_name,f.description,
    f.followup_id,f.nextfollowupdate
    from sim_bpartner bp
    inner join sim_followup f on bp.bpartner_id=f.bpartner_id
    where DATE_ADD(CURDATE(),INTERVAL $homepagefollowupday DAY)>= f.nextfollowupdate and f.isactive=1 order by f.nextfollowupdate desc,bp.bpartner_name ASC";

$followuplist=<<< EOF
   
  <table class="tblListRight">
    <tr>
    <td class="tdListRightTitle" colspan="4">Follow Up Issue (<a href="javascript:followuptable()">Refresh</a>)
    &nbsp;<a href="javascript:editFollowUp(0)">Add</a>
        </td>
    </tr>
    <tr>
    <td class="tdListRightHeader">No.</td>
    <td class="tdListRightHeader">Name</td>
    <td class="tdListRightHeader">Date</td>
    <td class="tdListRightHeader">Issue </td>
    </tr>

EOF;
$queryfollowuplist=$xoopsDB->query($sqlfollowuplist);
$rowtype='odd';
$date=date("Y-m-d H:i:s");
while($rowfu=$xoopsDB->fetchArray($queryfollowuplist)){
    $bpartner_no=$rowfu['bpartner_no'];
    $bpartner_id=$rowfu['bpartner_id'];
    $bpartner_name=$rowfu['bpartner_name'];
    $followup_name=$rowfu['followup_name'];
      $followup_id=$rowfu['followup_id'];
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
    <td class='$rowtype' title='$description'><a href='javascript:editFollowUp($followup_id)'>$followup_name</a></td>
    </tr>";

}
return $followuplist.="</table>";
    
}
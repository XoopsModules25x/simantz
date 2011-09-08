<?php


include_once "system.php";
//include_once('../simbiz/class/SearchLayer.inc.php');
include_once '../simantz/class/ReportElement.inc.php';

//$sl=new SearchLayer();//this variable name must fix
$re = new ReportElement();

include_once "../simantz/class/SelectCtrl.inc.php";
if(!$ctrl)
$ctrl = new SelectCtrl();
//include_once "../simbiz/class/SimbizSelectCtrl.inc.php";
//$simbizctrl=new SimbizSelectCtrl();
//include_once '../simbiz/class/SimbizReportElement.inc.php';
//include_once '../simbiz/class/Track.inc.php';
//$track = new Trackclass();
//$simbizre= new SimbizReportElement();

if( $_REQUEST['loadwindow'] == 1){

	
	
	   $window_id=$_REQUEST['window_id'];
        $sql="SELECT *	 FROM sim_window where window_id = $window_id and mid=$module_id and isactive=1";
        $query=$xoopsDB->query($sql);
        $row=$xoopsDB->fetchArray($query);

        $windowsetting = $row['windowsetting'];
echo "<table>";
eval($windowsetting);
//  $arrfield=explode("\n",$windowsetting); 
  //foreach($arrfield as $a){
	//	eval($a);
	  //} 

echo "</table>";
    die;
}
elseif($_REQUEST['loadwindowsetting'] == 1){
	
	 $window_id=$_REQUEST['window_id'];
        $sql="SELECT *	 FROM sim_window where window_id = $window_id and mid=$module_id and isactive=1";
        $query=$xoopsDB->query($sql);
        $row=$xoopsDB->fetchArray($query);

        $windowsetting = $row['windowsetting'];
		echo "$windowsetting";
    die;
    }
elseif($_REQUEST['loadwindowjrxml'] == 1){
	
	 $window_id=$_REQUEST['window_id'];
        $sql="SELECT *	 FROM sim_window where window_id = $window_id and mid=$module_id and isactive=1";
        $query=$xoopsDB->query($sql);
        $row=$xoopsDB->fetchArray($query);

        $jrxml = $row['jrxml'];
		echo "$jrxml";
    die;
    }  
elseif($_REQUEST['customcode']==1){
	
//jrxmlfile
	 $window_id=$_REQUEST['window_id'];
	 $window_name=$_REQUEST['window_name'];
	 $txt=$_REQUEST['txtsetting'];
	 $jrxml=$_REQUEST['jrxml'];

	 if($_REQUEST['isactive']=='on')
	 $isactive=1;
	 else
	 $isactive=0;
	 
	$save=$_REQUEST['save'];
	if($save==1){
		include "../simantz/class/Save_Data.inc.php";
        $save = new Save_Data();
		$arrUpdateField = array('windowsetting', 'isactive','updated', 'updatedby','jrxml');

        $arrUpdateFieldType = array("%s", "%d","%s", "%d",'%s');

        $arrvalue = array($txt, $isactive,date("Y-m-d H:i:s",time()), $xoopsUser->getVar('uid'),$jrxml);

        $save->UpdateRecord('sim_window', "window_id", $window_id, $arrUpdateField, $arrvalue, $arrUpdateFieldType,$window_name);
        //    return true;
        //else
          //  return false;

            
		}
	echo "<table>";
	eval($txt);
	echo "</table>";
	die;
	}
	
include_once "menu.php";

$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/base/jquery.ui.all.css"); 
$xoTheme->addScript("$url/modules/simantz/include/jqueryui/jquery.min.js"); 
$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.core.js"); 
$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.widget.js"); 
$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.datepicker.js");
$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/demos.css"); 
			

/*
 * <script src="../../jquery-1.6.2.js"></script> 
	<script src="../../ui/jquery.ui.core.js"></script> 
	<script src="../../ui/jquery.ui.widget.js"></script> 
	<script src="../../ui/jquery.ui.datepicker.js"></script> 
	<link rel="stylesheet" href="../demos.css"> 
	*/
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$date=date("Y-m-d",time());

$pm=new Permission();
//get report root
 $sql="SELECT window_id FROM sim_window where window_name = 'Reports' and mid='$module_id'";
$query=$xoopsDB->query($sql);
$row=$xoopsDB->fetchArray($query);
$reportroot_id = $row['window_id'];
$showhiden=$_REQUEST['showhiden'];

if($showhiden=='') 
$showhiden='N';
$list=$pm->showReportList($reportroot_id,0,$userid,$module_id,$showhiden);

/*
$date=$simbizre->rptctrl_date('Date','d1',date("Y-m-d",time()),'');
$daterange=$simbizre->rptctrl_daterage('Date','date1','date2',date("Y-m-d",time()),date("Y-m-d",time()),'onchange=alert(this.value)','onchange=alert(this.value)');
$bpartner=$simbizre->rptctrl_bpartner('Customer','bpartner','','','d');
$bpartnerrange=$simbizre->rptctrl_bpartnerrange('Supplier','bpartnerfrom','0','','bpartnerto','9','','c');
$chkbox=$simbizre->rptctrl_checkbox('Show Null','shownull','Y','checked','');
$account=$simbizre->rptctrl_account('Account','account','1','','');
$accountrange=$simbizre->rptctrl_accountrange('Account Range','accountfrom','1','','accountto','9','','');
$select=$simbizre->rptctrl_staticselect('Report Type','reporttype',array('Debtor','Creditor'),array('d','c'),1,'');
*/

if($showhiden=='Y')
$showhidelink="<a href='report.php'>Hide Hidden Report</a>";
else
$showhidelink="<a href='report.php?showhiden=Y'>Show Hidden Report</a>";
echo <<< EOF
<STYLE TYPE="text/css">
    .level1 {
		margin: 0em;
		list-style: none;
			font-weight: bold;

	}
	
    .level2 {
			margin: 0em;
			font-weight: normal;}
    .level3 {
		margin: 5px;
			font-weight: normal;
			
			}
	  .level3 a {color:black;}
	  
	 .level4 {
		margin: 5px;
			font-weight: normal;			
			}
			  .level4 a {color:red;}

  </STYLE>
<script>



    function loadWindow(wid){
        
        var data1="loadwindow=1&window_id="+wid;
		var data2="loadwindowsetting=1&window_id="+wid;
       	var data3="loadwindowjrxml=1&window_id="+wid;


         $.ajax({
             url: "report.php",type: "POST",data: data1,cache: false,
                 success: function (xml) {
					 
					document.getElementById('filtersetting').innerHTML=xml;
			
			$(".datepick").datepicker({
				dateFormat: 'yy-mm-dd',
                  numberOfMonths: 2
				});
                     }});
                      
               $.ajax({
				url: "report.php",type: "POST",data: data2,cache: false,
                 success: function (xml) {
	
               document.getElementById("txtsetting").value=xml;

                   

                     }});
                     
               $.ajax({
				url: "report.php",type: "POST",data: data3,cache: false,
                 success: function (xml) {
	
               document.getElementById("jrxml").value=xml;

                   

                     }});

    }



function closeWindow(){
     document.getElementById('idApprovalWindows').style.display = "none";
     document.getElementById('idApprovalWindows').innerHTML="";
     
          

}

function getParam(wid,filename,wname,isactive){
    var r=document.getElementsByName('rr[]');//.length;
    l=r.length;
    for(var i=0;i<l;i++)
        r[i].style.backgroundColor='fff';

   
    document.getElementById('searchform').action=filename;
    document.getElementById('targetname').innerHTML=wname;
    document.getElementById('window_id').value=wid;
    document.getElementById('window_name').value=wname;
   
    if(isactive==1)
    document.getElementById('isactive').checked=true;
    else
    document.getElementById('isactive').checked=false;
    
    loadWindow(wid);
  
}

function changeCode(value){
	
    var data=$('#frmcustomcode').serialize()+"&save="+value;
	
         $.ajax({
             url: "report.php",type: "POST",data: data,cache: false,
                 success: function (xml) {
					document.getElementById('filtersetting').innerHTML=xml;

                     }});

	
	}
</script>
<div id="idApprovalWindows" style="display:none"></div>

<div align=center>
<table  style='width: 1000px;'><tr><td width='300px'>
<div class='searchformblock' style='overflow:auto; height:500px;width=100px' >
$list

</div>
</td><td>
<form method="_GET"  style='width: 700px;' id='searchform' target='_blank'>

<table class='searchformblock'>
<tr><td class='tdListRightTitle' style='text-align:center' colspan='2'>Search Criterial</th></tr>

<tr>
    <td class='head'>Report</td>
    <td ><div id='targetname'>Null</div></td>
</tr>
<tr><td colspan='2'><div id='filtersetting'></div></td></tr>

</table>
</form>
<br/>
<div style='$reportsettingcss'> 
<form id='frmcustomcode' name='frmcustomcode' onsubmit='return false' method='post'  enctype="multipart/form-data">
<input type='submit' value='Change View' name='submit' onclick='changeCode(0)'>
<input type='submit' value='Commit' name='submit' onclick='changeCode(1)'>
<label>Active<input type='checkbox'  id='isactive' name='isactive'></label>
$showhidelink <a href='../simantz/admin/window.php' target='_blank'>Manage Window</a>
<textarea style='font-size:12px' id='txtsetting' name='txtsetting' rows=10 cols=80 ></textarea>
<input type='hidden' value='1' name='customcode'>
<input type='hidden' value='0' id='window_id' name='window_id'>
<input type='hidden' value='' id='window_name' name='window_name'>
JRXML (Put custom jrxml content to ignore server side .jrxml file):<br/><textarea name='jrxml' id='jrxml' style='font-size:12px' rows=5 cols=80 ></textarea>
<br/>
   Sample:<br/>
<textarea cols=80 style='font-size:12px' rows=5>echo \$simbizre->rptctrl_blankline('Organization',\$ctrl->selectionOrg(\$xoopsUser->getVar('uid'),0,'Y'));
echo \$re->rptctrl_daterage('Date','datefrom','dateto',date("Y-m-d",time()),date("Y-m-d",time()),'onchange=document.getElementById("dateto").value=this.value','');
echo \$re->rptctrl_checkbox('Show Batch','showbatchno','on','checked','');
echo \$simbizre->rptctrl_accountrange('Account Range','accountfrom','1','','accountto','9','','');
echo \$simbizre->rptctrl_blankline(\$trackarray['track1_name'],"<SELECT name='track_id1'>".\$simbizctrl->getSelectTrack(0,'Y',' and trackheader_id=1')."</select>");
echo \$re->rptctrl_period('Period','period_id',0,'','Y','');
echo \$simbizre->rptctrl_blankline();
echo \$simbizre->rptctrl_submit();
</textarea><br/>
</form>
</div>
   </td></tr></table>
</div>
EOF;
require(XOOPS_ROOT_PATH.'/footer.php');
//Skudai

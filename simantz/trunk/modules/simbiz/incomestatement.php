<?php
/*
 *Developed by kstan@simit.com.my 2008-12-25
*/

include_once "system.php";
include_once "menu.php";
//include_once '../system/class/Log.php';
//include_once 'class/Accounts.php';
//include_once 'class/SelectCtrl.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
include_once('../simantz/class/fpdf/fpdf.php');

$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';
$showDateFrom1=$dp->show('datefrom1');
$showDateTo1=$dp->show('dateto1');
$showDateFrom2=$dp->show('datefrom2');
$showDateTo2=$dp->show('dateto2');

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


//$log = new Log();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$periodfromctrl=$simbizctrl->getSelectPeriod(0,'N',"onchange=updatePeriodTo(reporttype.value)","periodfrom_id");
$periodtoctrl=$simbizctrl->getSelectPeriod(0,'N',"","periodto_id");
//$yearfromctrl=$simbizctrl->getSelectFinancialYear(0,'N',"","financialyearfrom_id");
//$yeartoctrl=$simbizctrl->getSelectFinancialYear(0,'N',"","financialyearto_id");
if($defaultDateSession=="")
$defaultDateSession=date("Y-m-d",time());
$datefrom1=left($defaultDateSession,7)."-01";
$dateto1=getLastDayByMonth(left($defaultDateSession,7));

$uid = $xoopsUser->getVar('uid');
$orgctrl=$ctrl->selectionOrg($uid,$defaultorganization_id,'N',"",'N');

echo <<< EOF
<script type='text/javascript'>
function validateForm(){

    var datefrom1 = document.forms['frmincomestatementreport'].datefrom1.value;
    var datefrom2= document.forms['frmincomestatementreport'].datefrom2.value;
    var dateto1= document.forms['frmincomestatementreport'].dateto2.value;
    var dateto2= document.forms['frmincomestatementreport'].dateto2.value;
    var periodfrom_id= document.forms['frmincomestatementreport'].periodfrom_id.value;
    var periodto_id= document.forms['frmincomestatementreport'].periodto_id.value;

    var reporttype = document.forms['frmincomestatementreport'].reporttype.value;

    if(reporttype == 'CM' || reporttype == 'CG'){
        if(periodto_id == 0 || periodfrom_id == 0){
            alert('Please select period from & period to');
         return false;
        }else
        return true;
        }
    else{
    if(reporttype == 'DC'){
        if(datefrom1 == "" || datefrom2 == "" || dateto1=="" || dateto2=="" ||
        !isDate(datefrom1) || !isDate(datefrom2 ) || !isDate(dateto1) || !isDate(dateto2)){
            alert('This report required valid date from/to in both column, please choose insert proper date from/to.');
         return false;
        }else
        return true;
        }
    else
    return true;
    }
}

function updatePeriodTo(reporttype){
    var periodto_id = document.forms['frmincomestatementreport'].periodto_id.value;
    var periodfrom_id = document.forms['frmincomestatementreport'].periodfrom_id.value;

    if(reporttype == 'SP' && periodto_id == 0){
    document.forms['frmincomestatementreport'].periodto_id.value = periodfrom_id;
    }
}


function changereport(){
//alert(value);
value=document.frmincomestatementreport.reporttype.value;
	switch(value){
		case "SC":
		document.getElementById('trCM').style.display="none";
			document.getElementById('trDC').style.display="none";
			document.getElementById('trSC').style.display="";
			document.frmincomestatementreport.action='viewincomestatement_singlecol.php';
		break;
		case "DC":
		document.getElementById('trCM').style.display="none";
			document.getElementById('trDC').style.display="";
			document.getElementById('trSC').style.display="";
			document.frmincomestatementreport.action='viewincomestatement_duocol.php';
		break;
		case "CM":
			document.getElementById('trCM').style.display="";
			document.getElementById('trDC').style.display="none";
			document.getElementById('trSC').style.display="none";
			document.frmincomestatementreport.action='htmlincomestatement_multipleperiod.php';
		break;
		case "CG":
			document.getElementById('trCM').style.display="";
			document.getElementById('trDC').style.display="none";
			document.getElementById('trSC').style.display="none";
			document.frmincomestatementreport.action='htmlincomestatement_chartgenerator.php';
		break;
		
	}

		//document.frmledgerreport.targetaction.value=document.frmledgerreport.action;
}
</script>
<table border='1'>
	<tbody>
		<tr><th style="text-align:center;" colspan='4'>Income Statement Report</th></tr>
		<form name='frmincomestatementreport' method='POST' target="_blank" action='viewincomestatement_singleperiod.php' onsubmit="return validateForm()">
		<tr><th style="text-align:center;" colspan='2'>Report Type</th>
		<th style="text-align:center;" colspan='2'>
			<SELECT name='reporttype' onchange='changereport()'>
				<option value='SC' selected='selected'>Single Column</option>
				<option value='DC'>Compare two Column</option>
				<option value='CM'>Compare Multiple Period (HTML)</option>
				<option value='CG'>Compare Multiple Period (Chart Generator)</option>
				</SELECT>
			<SELECT name='reportlevel'>
				<option value='2' selected='selected'>2 Level</option>
				<option value='3'>3 Level</option>
				<option value='4'>4 Level</option>
			</SELECT> 
			
		</th>
		</tr>
		
		<tr id='trSC'>
                    <td class='head'>Col 1 Date From(YYYY-MM-DD) </td>
                    <td class='odd'>
                            <input name='datefrom1' id='datefrom1' value='$datefrom1'>
                            <input type='button' value='Date' onclick="$showDateFrom1"></td>
                    <td class='head'>Col 1 Date To(YYYY-MM-DD)</td>
                    <td class='odd' >
                            <input name='dateto1' id='dateto1' value='$dateto1'>
                            <input type='button' value='Date' onclick="$showDateTo1"></td>

                    </td>
		</tr>
                <tr  id='trDC'>
                    <td class='head'>Col 2 Date From(YYYY-MM-DD)</td>
                    <td class='odd'>
                            <input name='datefrom2' id='datefrom2'>
                            <input type='button' value='Date' onclick="$showDateFrom2"></td>
                    <td class='head'>Col 2 Date To(YYYY-MM-DD)</td>
                    <td class='odd' >
                            <input name='dateto2' id='dateto2'>
                            <input type='button' value='Date' onclick="$showDateTo2"></td>

                    </td>
		</tr>


                <tr  id='trCM'><td class='head'>Period From</td><td class='odd'>$periodfromctrl</td>
			<td class='head'>Period To</td><td class='odd'>$periodtoctrl</td>
                            </tr>
                <tr>
			<td class='head'>Organization</td><td class='odd'  colspan='3'>$orgctrl</td>
		</tr>

		<tr><td>Show Account Code <input type="checkbox" name="showaccountcode" >
		Show Zero Value<input type="checkbox" name="showzero" ></td>
                    <td><input type='submit' value='Preview' name='submit'></td></tr>


		
	</tbody>
</table>
<script>changereport();</script>
EOF;
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


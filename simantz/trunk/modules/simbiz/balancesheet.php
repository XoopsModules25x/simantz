<?php
/*
 *Developed by kstan@simit.com.my 2009-01-04
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
$showDate1=$dp->show('date1');
$showDate2=$dp->show('date2');
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


//$log = new Log();
$s = new XoopsSecurity();
//$ctrl= new SelectCtrl();
$periodfromctrl=$simbizctrl->getSelectPeriod(0,'N',"","periodfrom_id");
$periodtoctrl=$simbizctrl->getSelectPeriod(0,'N',"","periodto_id");



echo <<< EOF
<script type='text/javascript'>

function autofocus(){

}
function changereport(){
//alert(value);
value=document.frmbalancesheetreport.reporttype.value;

	switch(value){
		case "SP":
                        document.getElementById("trCM").style.display="none";
			document.getElementById("trSP").style.display="";
			document.getElementById("trPP").style.display="none";
			document.frmbalancesheetreport.action='viewbalancesheet_singlecol.php';
		break;
		case "PP":
                        document.getElementById("trCM").style.display="none";
			document.getElementById("trSP").style.display="";
			document.getElementById("trPP").style.display="";
			document.frmbalancesheetreport.action='viewbalancesheet_duocol.php';
			
		break;
		case "CM":
			document.getElementById("trCM").style.display="";
			document.getElementById("trSP").style.display="none";
			document.getElementById("trPP").style.display="none";
			document.frmbalancesheetreport.action='htmlbalancesheet_multipleperiod.php';

		break;
                case "CG":
			document.getElementById("trCM").style.display="";
			document.getElementById("trSP").style.display="none";
			document.getElementById("trPP").style.display="none";
			document.frmbalancesheetreport.action='htmlbalancesheet_chartgenerator.php';

		break;
	}

		//document.frmledgerreport.targetaction.value=document.frmledgerreport.action;
}


function validateForm(){

    var date1 = document.forms['frmbalancesheetreport'].date1.value;
    var date2= document.forms['frmbalancesheetreport'].date2.value;
    var periodfrom_id= document.forms['frmbalancesheetreport'].periodfrom_id.value;
    var periodto_id= document.forms['frmbalancesheetreport'].periodto_id.value;

    var reporttype = document.forms['frmbalancesheetreport'].reporttype.value;

    if(reporttype == 'CM' || reporttype == 'CG'){
        if(periodto_id == 0 || periodfrom_id == 0){
            alert('Please select period from & period to');
         return false;
        }else
        return true;
        }
    else{
    if(reporttype == 'PP'){
        if(date1 == "" || date2 == "" || !isDate(date1) || !isDate(date2 ) ){
            alert('This report required valid date from/to in both column, please choose insert proper date from/to.');
         return false;
        }else
        return true;
        }
    else
    return true;
    }
}


</script>
<table border='1'>
	<tbody>
		<tr><th style="text-align:center;" colspan='4'>Balance Sheet Report</th></tr>
		<form name='frmbalancesheetreport' method='POST' target="_blank" 
                    action='viewbalancesheet_singleperiod.php' onsubmit='return validateForm()' >
		<tr><th style="text-align:center;">Report Type</th>

		<th style="text-align:center;" colspan='3'>
			<SELECT name='reporttype' onchange='changereport()'>
				<option value='SP' selected='selected'>Single Column</option>
				<option value='PP'>Compare 2 Column</option>
				<option value='CM'>Multiple Balance Sheet As At Difference Period (HTML)</option>
				<option value='CG'>Multiple Balance Sheet As At Difference Period (Chart Generator)</option>

			</SELECT>
			<SELECT name='reportlevel'>
				<option value='2' selected='selected'>2 Level</option>
				<option value='3'>3 Level</option>
				<option value='4'>4 Level</option>
			</SELECT>		
		</th>
		
		</tr>
                 <tr  id='trSP'>
                    <td class='head'>Till Date (YYYY-MM-DD)</td>
                    <td class='odd' colspan='3'>
                            <input name='date1' id='date1'>
                            <input type='button' value='Date' onclick="$showDate1"></td>
                    </tr>
                    <tr id='trPP'>
                    <td class='head'>Col 2 Till Date (YYYY-MM-DD)</td>
                    <td class='odd' colspan='3'>
                            <input name='date2' id='date2'>
                            <input type='button' value='Date' onclick="$showDate2"></td>

                    </td></tr>
		<tr id='trCM'>
                    <td class='head'>Period From</td>
                    <td class='odd'>$periodfromctrl</td>
		     <td class='head'>Period To</td>
                    <td class='odd' id='tdperiod3' >$periodtoctrl</td>
		</tr>

		<tr><td>
                    Show Account Code <input type="checkbox" name="showaccountcode" >
                    Show Zero Value<input type="checkbox" name="showzero" >
                </td>
                    <td><input type='submit' value='Preview' name='submit'></td></tr>
		</blank>
	</tbody>
</table>
<script>changereport();</script>
EOF;
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


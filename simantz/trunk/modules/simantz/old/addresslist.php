<?php
/*
 *Developed by kstan@simit.com.my 2008-12-25
*/
include_once "system.php";
include_once "menu.php";
include_once '../system/class/Log.php';
include_once('../../class/fpdf/fpdf.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$s = new XoopsSecurity();
if($_POST['periodfrom_id']=="")
	$periodfrom_id=0;
else
	$periodfrom_id=$_POST['periodfrom_id'];

if($_POST['periodto_id']=="")
	$periodto_id=0;
else
	$periodto_id=$_POST['periodto_id'];


if($_POST['bpartner_id']=="")
	$bpartner_id=0;
else
	$bpartner_id=$_POST['bpartner_id'];


$bpartner_from=$_POST['bpartner_from'];
$bpartner_to=$_POST['bpartner_to'];
$bpartner_name=$_POST['bpartner_name'];
$bpartner_city=$_POST['bpartner_city'];
$contactperson1=$_POST['contactperson1'];
$bpartner_hp_no1=$_POST['bpartner_hp_no1'];
$bpartnergroup_id=$_POST['bpartnergroup_id'];
//$periodfromctrl=$ctrl->getSelectPeriod($periodfrom_id,'N',"","periodfrom_id");
//$periodtoctrl=$ctrl->getSelectPeriod($periodto_id,'N',"","periodto_id");
//$bpartnerctrl=$ctrl->getSelectBPartner($bpartner_id,'N',"","bpartner_array[0]","");

if($_POST['reporttype']=="a")
	$selecta="selected='selected'";
elseif($_POST['reporttype']=="ac")
	$selectac="selected='selected'";
else
	$selecta="selected='selected'";

if($_POST['bpartnertype']=="1")
	$selectdc="selected='selected'";
elseif($_POST['bpartnertype']=="2")
	$selectd="selected='selected'";
else
	$selectc="selected='selected'";

if($_POST['activebpartneronly']=='on')
 $activebpartnerchecked="checked";
else
 $activebpartnerchecked="";

if($bpartnergroup_id == "")
$bpartnergroup_id = 0;
$bpartnergroupctrl=$ctrl->getSelectBPartnerGroup($bpartnergroup_id,'Y',"");

echo <<< EOF
<script type='text/javascript'>

function autofocus(){
changereport();
}
function changereport(){
value=document.frmbpartnerstatement.reporttype.value;

	switch(value){
		case "d":
			document.getElementById("tdd1").style.display='';
			document.getElementById("tdd2").style.display='';
			document.getElementById("tds").style.display='none';
			document.getElementById("tdc1").style.display='none';
			document.getElementById("tdc2").style.display='none';
			document.getElementById("tdbp").style.display='';
			document.frmbpartnerstatement.action="bpartnerstatement.php";
			document.frmbpartnerstatement.target="";
			document.frmbpartnerstatement.submit.value="Search";
		break;
		case "c":

			document.getElementById("tdd1").style.display='none';
			document.getElementById("tdd2").style.display='none';
			document.getElementById("tds").style.display='none';
			document.getElementById("tdbp").style.display='';
			document.getElementById("tdc1").style.display='';
			document.getElementById("tdc2").style.display='';
			document.frmbpartnerstatement.action="bpartnerstatement.php";
			document.frmbpartnerstatement.target="";
			document.frmbpartnerstatement.submit.value="Search";

			break;
		case "s":

			document.getElementById("tds").style.display='';
			document.getElementById("tdbp").style.display='none';
			document.frmbpartnerstatement.action="viewbpartnerstatement.php";
			document.frmbpartnerstatement.target="_blank";
			document.frmbpartnerstatement.submit.value="Preview";
		break;
		default:
			alert("You'd select unknown option.");
		break;

		
	}
		//document.frmledgerreport.targetaction.value=document.frmledgerreport.action;
}
</script>
<table border='1'>
	<tbody>
		<tr><th style="text-align:center;" colspan='4'>Business Partner Statement Report</th></tr>
		<form name='frmAddressList' method='POST' action='addresslist.php' >

		<tr><th style="text-align:center;" colspan='2'>Report Type</th>
		<th style="text-align:center;" colspan='2'>
			<SELECT name='reporttype' onchange='changereport()'>
				<option value='ac' $selectac>Address Label With Contact</option>
				<option value='a' $selecta>Address Label Only</option>
			</SELECT>BPartner Type
			<SELECT name='bpartnertype' >
				<option value='1' $selectdc>Debtor OR Creditor</option>
				<option value='2' $selectd>Debtor Only</option>
				<option value='3' $selectc>Creditor Only</option>
			</SELECT> Only Active Bpartner <input type='checkbox' name='activebpartneronly' $activebpartnerchecked>
		</td>
		</th></tr>

		<tr >
				<td class='head'>Business Partner No From</td>
				<td class='even'><input name='bpartner_from' value="$bpartner_from"></td>
				<td  class='head'>Business Partner No To</td>
				<td class='even'><input name='bpartner_to' value="$bpartner_to"></td>
		</tr>

		<tr>
		<td class="head">Business Partner Name</td>
		<td class="even"><input name="bpartner_name" value="$bpartner_name" size="35"></td>
		<td class="head">Business Partner Group</td>
		<td class="even">$bpartnergroupctrl</td>
		</tr>
		
		<tr>
		<td class="head">City</td>
		<td class="even"><input name="bpartner_city" value="$bpartner_city"></td>
		<td class="head">Contact Person</td>
		<td class="even"><input name="contactperson1" value="$contactperson1" size="35"></td>
		</tr>
		
		<tr>
		<td class="head">HP No</td>
		<td class="even" colspan="3"><input name="bpartner_hp_no1" value="$bpartner_hp_no1"></td>
		</tr>

		<tr><td><input type='submit' value='Search' name='submit'></td></tr>
		</form>
	</tbody>
</table>

EOF;

if(isset($_POST['submit'])){
  $accountclass=0;
  $reporttype=$_POST['reporttype'];
  $bpartnertype=$_POST['bpartnertype'];

$bpartner_name=$_POST['bpartner_name'];
$bpartner_city=$_POST['bpartner_city'];
$contactperson1=$_POST['contactperson1'];
$bpartner_hp_no1=$_POST['bpartner_hp_no1'];
$bpartnergroup_id=$_POST['bpartnergroup_id'];

if($_POST['activebpartneronly']=='on')
 $whereactivebpartnerchecked="and bp.isactive=1";
else
 $whereactivebpartnerchecked="";


  if($bpartnertype=='1'){
	$wherestr="and (isdebtor=1 OR iscreditor=1)";
	}
  elseif($bpartnertype=='2'){
	$wherestr="and isdebtor=1 and iscreditor=0";
	}
  else{
	$wherestr="and isdebtor=0 and iscreditor=1";
	}


	if($bpartner_name != "")
	$wherestr .= " and bpartner_name like '$bpartner_name' ";

	if($bpartner_city != "")
	$wherestr .= " and bpartner_city like '$bpartner_city' ";

	if($contactperson1 != "")
	$wherestr .= " and (contactperson1 like '$contactperson1' or contactperson2 like '$contactperson1') ";


	if($bpartner_hp_no1 != 0)
	$wherestr .= " and (bpartner_hp_no1 like '$bpartner_hp_no1' or bpartner_hp_no2 like '$bpartner_hp_no1') ";

	if($bpartnergroup_id > 0)
	$wherestr .= " and bp.bpartnergroup_id = $bpartnergroup_id ";
 
 $sql="SELECT bp.bpartner_no,bp.bpartner_name,bp.bpartner_id,g.bpartnergroup_name,
	bp.bpartner_city,bp.bpartner_tel_1,bp.contactperson1,
	bp.isactive,bp.bpartner_street1,bp.bpartner_street2 
	FROM $tablebpartner bp 
	INNER JOIN $tablebpartnergroup g on bp.bpartnergroup_id=g.bpartnergroup_id
	WHERE  (bp.bpartner_no LIKE '$bpartner_to%' OR bp.bpartner_no between '$bpartner_from%' AND '$bpartner_to%')
	$wherestr $whereactivebpartnerchecked
	ORDER BY bp.bpartner_no";

  $query=$xoopsDB->query($sql);
  $i=0;
  echo <<< EOF
  <script type='text/javascript'>
	function includeall(value){
	var rowcount=document.frmbpsummary.bpartnercount.value;
	for(i=0;i<rowcount;i++)
		document.getElementById("checkbox"+i).checked=value;
	}
  </script>
	<table border='1'><tbody>
	<tr>
		<th style="text-align:center" colspan='9'>Business Partner</th>
		</tr>
	<tr><form name='frmbpsummary' action ='viewbpartneraddresslable.php' target='_blank' method="POST">
		<th style="text-align:center">B/P No</th>
		<th style="text-align:center">B/P Name</th>
		<th style="text-align:center">Group</th>
		<th style="text-align:center">Address</th>
		<th style="text-align:center">City</th>
		<th style="text-align:center">Tel</th>
		<th style="text-align:center">Person</th>
		<th style="text-align:center">Active</th>
		<th style="text-align:center">Select All <input type='checkbox' onchange='includeall(this.checked);' name='chkIncludeAll'></th>
	</tr>
EOF;

  while($row=$xoopsDB->fetchArray($query)){
	$bpartner_no=$row['bpartner_no'];
	$bpartner_name=$row['bpartner_name'];
	$bpartner_id=$row['bpartner_id'];
	$bpartnergroup_name=$row['bpartnergroup_name'];
	$bpartner_street1=$row['bpartner_street1'];
	$bpartner_street2=$row['bpartner_street2'];
	$bpartner_city=$row['bpartner_city'];
	$bpartner_tel_1=$row['bpartner_tel_1'];
	$contactperson1=$row['contactperson1'];
	$isactive=$row['isactive'];
	if($isactive==1)
		$isactive='Y';
	else
		$isactive="<b style='color:red;'>N</b>";
	if($rowtype=="odd")
	$rowtype='odd';
	else
	$rowtype="even";

	echo <<< EOF
	<tr>
		<td class="$rowtype" style='text-align:center;'>$bpartner_no</td>
		<td class="$rowtype"><a href="bpartner.php?action=edit&bpartner_id=$bpartner_id">$bpartner_name</a></td>
		<td class="$rowtype">$bpartnergroup_name</td>
		<td class="$rowtype">$bpartner_street1, $bpartner_street2</td>
		<td class="$rowtype">$bpartner_city</td>
		<td class="$rowtype">$bpartner_tel_1</td>
		<td class="$rowtype">$contactperson1</td>
		<td class="$rowtype" style='text-align:center;'>$isactive</td>
		<td class="$rowtype" style="text-align:center"><input type='hidden' id="bpartner$i" name="bpartner_array[$i]" value="$bpartner_id">
				<input type='checkbox' id="checkbox$i" name="checkbox_array[$i]"></td>

	</tr>
EOF;
$i++;
  }
  echo <<< EOF
</tbody></table>
<br>
<input type="hidden" name='bpartnercount' value="$i">
<input type='hidden' name='reporttype' value="$reporttype">
<input type='submit' value='Preview Label' name='submit' onclick="document.frmbpsummary.action='viewbpartneraddresslable.php';">
<input type='submit' value='Preview List' name='submit' onclick="document.frmbpsummary.action='viewbpartnerlist.php';">
</form>
EOF;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


<?php
/*
 *Developed by kstan@simit.com.my 2008-12-25
*/
include_once "system.php";
include_once "menu.php";
//include_once '../system/class/Log.php';
include_once('../simantz/class/fpdf/fpdf.php');

include_once "../simantz/class/datepicker/class.datepicker.php";
//include_once "../system/class/Period.php";
$dp=new datepicker($url);
$dp->dateFormat='Y-m-d';
$showStatementDate=$dp->show("statementdate");
$showStartDate=$dp->show("startdate");
$showEndDate=$dp->show("enddate");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
/*
include_once "class/Accounts.php";
$acc = new Accounts();
$aging_type = 6;
$periodto_id = 18; //18 = june 
$bpartner_id = 118; //bahan2->36 : 118 -> golden
for($j=0;$j<($aging_type);$j++){
$amtaging = $acc->bPartnerAging($periodto_id,($aging_type-1)-$j,$bpartner_id);
echo $amtdebit = $amtaging[0];
echo $amtcredit = $amtaging[1];

}*/


$s = new XoopsSecurity();


$aging_type=$_GET['aging_type'];


$showbalanceno = $_GET['showbalanceno'];

$checkedb = "";
if($showbalanceno == "on" )
$checkedb = "CHECKED";

$selected1 = "";
$selected2 = "";
if($aging_type=="6")
$selected1 = "selected";
else
$selected2 = "selected";

$bpartner_from=$_GET['bpartner_from'];
$bpartner_to=$_GET['bpartner_to'];

if($bpartner_from=="")$bpartner_from="000";
if($bpartner_to=="")$bpartner_to="ZZZ";
$statementdate=$_GET['statementdate'];
if($statementdate=="")
$statementdate=date("Y-m-d",time());
if($startdate=="")
$startdate=date("Y-m-01",time());
if($enddate=="")
$enddate=date("Y-m-d",time());
if($_GET['reporttype']=="d")
	$selectd="selected='selected'";
elseif($_GET['reporttype']=="c")
	$selectc="selected='selected'";
if($_GET['showbalanceno']!="")
    $checked="checked";
else
    $checked="";
echo <<< EOF
<script type='text/javascript'>



function autofocus(){
changereport();
}
function changereport(){
value=document.getElementById("reporttype").value;

	switch(value){
		case "d":
			document.frmbpartnerstatement.action="bpartnerstatement.php";
		break;
		case "c":
			document.frmbpartnerstatement.action="bpartnerstatement.php";
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
		<form name='frmbpartnerstatement' method='GET'  action='viewbpartnerstatement.php' >

		<tr><th style="text-align:center;" colspan='2'>Report Type</th>
		<th style="text-align:center;" colspan='2'>
			<SELECT name='reporttype' onchange='changereport()' id="reporttype">
				<option value='d' $selectd>Multiple Debtor</option>
				<option value='c' $selectc>Multiple Creditor</option>
			</SELECT>

                <b id="idShowBalance">&nbsp;&nbsp;Show Only Have Balance&nbsp;<input type="checkbox" name="showbalanceno" $checked></b>
                </td></th></tr>
		<tr>
				<td class='head' id='tdd1'>BPartnerFrom</td>
				<td class='even'><input name='bpartner_from' value="$bpartner_from"></td>
				<td class='head' id='tdd2'>BPartner To</td>
				<td class='even'><input name='bpartner_to' value="$bpartner_to"></td>
		</tr>
		<tr>
		<td class="head">Report Aging (Footer)</td>
		<td class="even">
		<select name="aging_type">
		<option value=6 $selected1>6 Month</option>
		<option value=12 $selected2>12 Month</option>
		</select>
		</td>
                <td class="head">Statement Date</td>
		<td class="even">
                    <input name="statementdate" value="$statementdate" id="statementdate">
                    <input type="button" name='btnstatementdate' value="Date" onclick="$showStatementDate">
		</td>
		</tr>
		<tr>
		<td class="head">Start Date</td>
		<td class="even">
                    <input name="startdate" value="$startdate" id="startdate">
                    <input type="button" name='btnstartdate' value="Date" onclick="$showStartDate">

		</td>
                <td class="head">End Date</td>
		<td class="even">
                    <input name="enddate" value="$enddate" id="enddate">
                    <input type="button" name='btnenddate' value="Date" onclick="$showEndDate">
		</td>
		</tr>
		<tr>
                <td>
		<input type='submit' value='Search' name='btnSearch'>
		</td></tr>
		</form>
	</tbody>
</table>
<script>changereport();
</script>
EOF;

$aging_type=$_GET['aging_type'];

if($_GET){
  $accountclass=0;
  $reporttype=$_GET['reporttype'];
  if($reporttype=='d'){
	$accounttype=2;//debtor
	$columnprefix="debtor";
}  else{
	$accounttype=3;//creditor
	$columnprefix="creditor";
}



/*
 $sql="SELECT bp.bpartner_no,bp.bpartner_name,bp.bpartner_id,bp.currentbalance,g.bpartnergroup_name,
	acc.accountcode_full,acc.accounts_name,ts.lastbalance 	
	 FROM $tablebpartner bp 
	INNER JOIN $tablebpartnergroup g on bp.bpartnergroup_id=g.bpartnergroup_id
	INNER JOIN $tableaccounts acc on acc.accounts_id=bp.$columnprefix"."accounts_id
        LEFT JOIN $tabletranssummary ts on ts.bpartner_id = bp.bpartner_id
	WHERE  acc.account_type=$accounttype AND 
		(bp.bpartner_no LIKE '$bpartner_to%' OR bp.bpartner_no between '$bpartner_from%' AND '$bpartner_to%')
		and is$columnprefix=1
        $wherezero
	ORDER BY bp.bpartner_no";
*/
$subsql="select sum(t.amt) from $tabletransaction t
            inner join $tablebatch b on b.batch_id=t.batch_id
            where t.bpartner_id = bp.bpartner_id and b.iscomplete=1 and
            bp.$columnprefix"."accounts_id and b.batchdate<='$statementdate'";
    $wherezero = "";
if($showbalanceno == "on"){
 $sql="SELECT bp.bpartner_no,bp.bpartner_name,bp.bpartner_id,bp.currentbalance,g.bpartnergroup_name,
	acc.accountcode_full,acc.accounts_name,
	coalesce(($subsql),0) as lastbalance
	 FROM $tablebpartner bp
	INNER JOIN $tablebpartnergroup g on bp.bpartnergroup_id=g.bpartnergroup_id
	INNER JOIN $tableaccounts acc on acc.accounts_id=bp.$columnprefix"."accounts_id
	WHERE  acc.account_type=$accounttype AND
		(bp.bpartner_no LIKE '$bpartner_to%' OR bp.bpartner_no between '$bpartner_from%' AND '$bpartner_to%')
		and is$columnprefix=1 and coalesce(($subsql),0) <>0 ORDER BY bp.bpartner_no";

}
else
 $sql="SELECT bp.bpartner_no,bp.bpartner_name,bp.bpartner_id,bp.currentbalance,g.bpartnergroup_name,
	acc.accountcode_full,acc.accounts_name, 
	coalesce(($subsql),0) as lastbalance
	 FROM $tablebpartner bp 
	INNER JOIN $tablebpartnergroup g on bp.bpartnergroup_id=g.bpartnergroup_id
	INNER JOIN $tableaccounts acc on acc.accounts_id=bp.$columnprefix"."accounts_id
	WHERE  acc.account_type=$accounttype AND 
		(bp.bpartner_no LIKE '$bpartner_to%' OR bp.bpartner_no between '$bpartner_from%' AND '$bpartner_to%')
		and is$columnprefix=1
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
		<th style="text-align:center" colspan='6'>Business Partner</th>
		</tr>
	<tr><form name='frmbpsummary' action ='viewbpartnerstatement.php' target='_blank' method="GET">
		<th style="text-align:center">B/P No</th>
		<th style="text-align:center">B/P Name</th>
		<th style="text-align:center">B/P Group</th>
		<th style="text-align:center">B/P Account</th>
		<th style="text-align:center">Balance</th>
		<th style="text-align:center">Select All <input type='checkbox' onchange='includeall(this.checked);' name='chkIncludeAll'></th>
	</tr>
EOF;

  while($row=$xoopsDB->fetchArray($query)){
	$bpartner_no=$row['bpartner_no'];
	$bpartner_name=$row['bpartner_name'];
	$bpartner_id=$row['bpartner_id'];
	$bpartnergroup_name=$row['bpartnergroup_name'];
	$accountcode_full=$row['accountcode_full'];
	$accounts_name=$row['accounts_name'];
        $lastbalance=$row['lastbalance'];

	if($rowtype=="odd")
	$rowtype='odd';
	else
	$rowtype="even";

	echo <<< EOF
	<tr>
		<td class="$rowtype">$bpartner_no</td>
		<td class="$rowtype"><a href="../system/bpartner.php?action=edit&bpartner_id=$bpartner_id">$bpartner_name</a></td>
		<td class="$rowtype">$bpartnergroup_name</td>
		<td class="$rowtype">$accountcode_full-$accounts_name</td>
		<td class="$rowtype" align="center">$lastbalance</td>
		<td class="$rowtype" style="text-align:center"><input type='hidden' id="bpartner$i" name="bpartner_array[$i]" value="$bpartner_id">
				<input type='checkbox' id="checkbox$i" name="checkbox_array[$i]"></td>

	</tr>
EOF;
$i++;
  }
  $reporttype=$_GET['reporttype'];
  echo <<< EOF
</tbody></table>
<br>
<input type="1hidden" name='startdate' value="$startdate">
<input type="1hidden" name='enddate' value="$enddate">
<input type="hidden" name='statementdate' value="$statementdate">
<input type="hidden" name='bpartnercount' value="$i">
<input type="hidden" name='aging_type' value="$aging_type">
<input type='hidden' name='reporttype' value="$reporttype">
<input type='submit' value='View Statement Report' name='submit' onclick="document.frmbpsummary.action='viewbpartnerstatement.php'">
<input type='submit' value='View Aging Report' name='submit' onclick="document.frmbpsummary.action='viewagingstatement.php'">
</form>
EOF;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


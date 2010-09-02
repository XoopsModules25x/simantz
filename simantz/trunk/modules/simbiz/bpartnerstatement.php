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


$log = new Log();
$s = new XoopsSecurity();
if($_GET['periodfrom_id']=="")
	$periodfrom_id=0;
else
	$periodfrom_id=$_GET['periodfrom_id'];

if($_GET['periodto_id']=="")
	$periodto_id=0;
else
	$periodto_id=$_GET['periodto_id'];


if($_GET['bpartner_id']=="")
	$bpartner_id=0;
else
	$bpartner_id=$_GET['bpartner_id'];

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
$statementdate=$_GET['statementdate'];
if($statementdate=="")
$statementdate=date("Y-m-d",time());
$periodfromctrl=$ctrl->getSelectPeriod($periodfrom_id,'N',"","periodfrom_id");
$periodtoctrl=$ctrl->getSelectPeriod($periodto_id,'N',"","periodto_id");
$bpartnerctrl=$simbizctrl->getSelectBPartner($bpartner_id,'N',"","bpartner_array[0]","");
if($_GET['reporttype']=="s")
	$selects="selected='selected'";
elseif($_GET['reporttype']=="d")
	$selectd="selected='selected'";
elseif($_GET['reporttype']=="c")
	$selectc="selected='selected'";
else
	$selects="selected='selected'";
echo <<< EOF
<script type='text/javascript'>



function autofocus(){
changereport();
}
function changereport(){
value=document.getElementById("reporttype2").value;

	switch(value){
		case "d":
			document.getElementById("tdd1").style.display='';
			document.getElementById("tdd2").style.display='';
			document.getElementById("tds").style.display='none';
			document.getElementById("tdc1").style.display='none';
			document.getElementById("tdc2").style.display='none';
			document.getElementById("tdbp").style.display='';
			document.getElementById("idShowBalance").style.display='';

			document.frmbpartnerstatement.action="bpartnerstatement.php";
			document.frmbpartnerstatement.target="";
			document.frmbpartnerstatement.btnSearch.style.display="";
			//document.frmbpartnerstatement.submit.value="Search";
			document.frmbpartnerstatement.submit2.style.display="none";
			document.frmbpartnerstatement.submit1.style.display="none";
idShowBalance
		break;
		case "c":

			document.getElementById("tdd1").style.display='none';
			document.getElementById("tdd2").style.display='none';
			document.getElementById("tds").style.display='none';
			document.getElementById("tdbp").style.display='';
			document.getElementById("tdc1").style.display='';
			document.getElementById("tdc2").style.display='';
			document.getElementById("idShowBalance").style.display='';

			document.frmbpartnerstatement.action="bpartnerstatement.php";
			document.frmbpartnerstatement.target="";
			document.frmbpartnerstatement.btnSearch.style.display="";
			//document.frmbpartnerstatement.submit.value="Search";
			document.frmbpartnerstatement.submit2.style.display="none";
			document.frmbpartnerstatement.submit1.style.display="none";

			break;
		case "s":
		
			document.getElementById("tds").style.display='';
			document.getElementById("tdbp").style.display='none';
			document.frmbpartnerstatement.action="viewbpartnerstatement.php";
			document.frmbpartnerstatement.target="_blank";
			document.frmbpartnerstatement.submit1.value="View Statement Report";
			document.frmbpartnerstatement.submit2.style.display="";
			document.frmbpartnerstatement.submit1.style.display="";
			document.frmbpartnerstatement.btnSearch.style.display="none";
			document.getElementById("idShowBalance").style.display='none';

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
		<form name='frmbpartnerstatement' method='GET' target="_blank" action='viewbpartnerstatement.php' >

		<tr><th style="text-align:center;" colspan='2'>Report Type</th>
		<th style="text-align:center;" colspan='2'>
			<SELECT name='reporttype2' onchange='changereport()' id="reporttype2">
				<option value='s' $selects>Single Business Partner</option>
				<option value='d' $selectd>Multiple Debtor</option>
				<option value='c' $selectc>Multiple Creditor</option>
			</SELECT>

                <b id="idShowBalance" style="display:none">&nbsp;&nbsp;Show Only Have Balance&nbsp;<input type="checkbox" name="showbalanceno" $checkedb></b>
                </td></th></tr>

		<tr >
			<td class='head'>Period From</td><td class='even'><select name="periodfrom_id">$periodfromctrl</select></td>
			<td class='head'>Period To</td><td class='even'><select name="periodto_id">$periodtoctrl</select></td>
		</tr>
		<tr  id='tds'>
			<td class='head'>Business Partner</td><td class='even'  colspan='3'><select id='bpartner_id'name='bpartner_id'>$bpartnerctrl</select>
			 <input type='hidden' name="checkbox_array[0]" value='on'>
</td>
		</tr>
		<tr  id='tdbp'>
				<td id='tdc1' class='head'>Creditor From</td>
				<td class='head' id='tdd1'>Debtor From</td>
				<td class='even'><input name='bpartner_from' value="$bpartner_from"></td>
				<td id='tdc2' class='head'>Creditor To</td>
				<td class='head' id='tdd2'>Debtor To</td>
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
		<tr><td>
		<input type='submit' value='Search' name='btnSearch'>
		<input type='submit' value='View Statement Report' name='submit1' onclick="document.frmbpartnerstatement.action='viewbpartnerstatement.php'">

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
    $wherezero = "";
if($showbalanceno == "on"){
 $sql="SELECT bp.bpartner_no,bp.bpartner_name,bp.bpartner_id,bp.currentbalance,g.bpartnergroup_name,
	acc.accountcode_full,acc.accounts_name,
	(select sum(t.amt) from $tabletransaction t
            inner join $tablebatch b on b.batch_id=t.batch_id
            where t.bpartner_id = bp.bpartner_id and b.iscomplete=1) as lastbalance
	 FROM $tablebpartner bp
	INNER JOIN $tablebpartnergroup g on bp.bpartnergroup_id=g.bpartnergroup_id
	INNER JOIN $tableaccounts acc on acc.accounts_id=bp.$columnprefix"."accounts_id
	WHERE  acc.account_type=$accounttype AND
		(bp.bpartner_no LIKE '$bpartner_to%' OR bp.bpartner_no between '$bpartner_from%' AND '$bpartner_to%')
		and is$columnprefix=1
        and (select sum(t.amt) from $tabletransaction t
            inner join $tablebatch b on b.batch_id=t.batch_id
            where t.bpartner_id = bp.bpartner_id and b.iscomplete=1) <>0

	ORDER BY bp.bpartner_no";

}
else
 $sql="SELECT bp.bpartner_no,bp.bpartner_name,bp.bpartner_id,bp.currentbalance,g.bpartnergroup_name,
	acc.accountcode_full,acc.accounts_name, 
	(select sum(t.amt) from $tabletransaction t
            inner join $tablebatch b on b.batch_id=t.batch_id
            where t.bpartner_id = bp.bpartner_id and b.iscomplete=1) as lastbalance
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
  echo <<< EOF
</tbody></table>
<br>
<input type="hidden" name='periodfrom_id' value="$periodfrom_id">
<input type="hidden" name='periodto_id' value="$periodto_id">
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


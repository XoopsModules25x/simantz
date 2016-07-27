<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once "menu.php";
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

echo <<< EOF
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../xoops.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../themes/default/style.css">
EOF;
?>

<script type="text/javascript">

function saveRemarks(){
var remarks = document.forms['frmRemarks'].remarks_desc.value

if(confirm("Confirm save this data?")==true){
	if(remarks==""){
	alert('Please make sure Remarks is filled in.');
	return false;
	}else{	
	document.forms['frmRemarks'].issave.value = "save";
	return true;
	}
}else{
return false;
}

}

function getLineInfo(line,salesline_id){
self.parent.document.getElementById("infoitem").src = "../infoitem.php?salesline_id=" + salesline_id + "&line=" + line;
}

function calculateTotal(thisname,thisvalue){
document.forms['frmAllowance'].action.value = "save";
document.forms['frmAllowance'].submit();

updateParent();
}


function deleteLine(line){

if(confirm("Confirm delete this allowance?")==true){
document.forms['frmAllowance'].line.value = line;
document.forms['frmAllowance'].action.value = "delete";
document.forms['frmAllowance'].submit();
}

updateParent();

}
/*
function updateParent(thisname,thisvalue){

self.parent.getAmountFrm('');
alert('EPF & SOCSO (BASE) Updated.');
self.parent.updateBase(self.parent.document);
}
*/

function updateParent(){

self.parent.updateBase(self.parent.document);
//alert('EPF & SOCSO (Contribution) Updated.');
self.parent.getAmountFrm('');
}

</script>


<?php
echo <<< EOF
<body class="head">
EOF;
echo "<table><tr align='center' height=20><td align='left'><b>Allowance</b></td></tr></table>";

$log = new Log();
$uid = $xoopsUser->getVar('uid');
$uname = $xoopsUser->getVar('uname');
$tablesales=$tableprefix."simsalon_sales";
$tablesalesline=$tableprefix."simsalon_salesline";
$tableproductlist=$tableprefix."simsalon_productlist";
$tableproductcategory = $tableprefix."simsalon_productcategory";
$tableallowancepayroll = $tableprefix."simsalon_allowancepayroll";

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

$datectrl=$dp->show("jobcontrol_date");

$timestamp= date("Y-m-d H:i:s", time()) ;


if (isset($_POST['payroll_id']))
	$payroll_id=$_POST['payroll_id'];
elseif(isset($_GET['payroll_id']))
	$payroll_id=$_GET['payroll_id'];

if (isset($_POST['action']))
	$action=$_POST['action'];
elseif(isset($_GET['action']))
	$action=$_GET['action'];

$line = $_POST['line'];
$allowancepayroll_id = $_POST['allowancepayroll_id'];
$allowancepayroll_amount= $_POST['allowancepayroll_amount'];
$allowancepayroll_socso= $_POST['allowancepayroll_socso'];
$allowancepayroll_epf= $_POST['allowancepayroll_epf'];


if($_POST && $action == "delete"){
	$sql = "delete from $tableallowancepayroll where allowancepayroll_id = $line";

	$log->showLog(4,"Before insert allowancepayroll_id SQL:$sql");


		$rs=$xoopsDB->query($sql);

		if (!$rs){
			$log->showLog(1,"Failed to delete item");
		}
		else{
			$log->showLog(3,"deleting new successfully"); 
			$totalamt = updateTotalAmount($log,$xoopsDB,$tablesales,$tablesalesline,$sales_id);
			
			
		}
}

if($_POST && $action == "save"){

			// update amount list
			$row = count($allowancepayroll_id);
	
			$i=0;
			while($i<$row){
			$i++;

			$allowancepayroll_idi = $allowancepayroll_id[$i];
			$allowancepayroll_amounti = $allowancepayroll_amount[$i];
			$allowancepayroll_epfi = $allowancepayroll_epf[$i];
			$allowancepayroll_socsoi = $allowancepayroll_socso[$i];
		
			
			
			if($allowancepayroll_epfi=="on")
			$allowancepayroll_epfi = "Y";
			else
			$allowancepayroll_epfi = "N";

			if($allowancepayroll_socsoi=="on")
			$allowancepayroll_socsoi = "Y";
			else
			$allowancepayroll_socsoi = "N";

			$sql = "update $tableallowancepayroll set 
				allowancepayroll_amount = $allowancepayroll_amounti,
				allowancepayroll_epf = '$allowancepayroll_epfi',
				allowancepayroll_socso = '$allowancepayroll_socsoi' 
				where allowancepayroll_id = $allowancepayroll_idi ";

			$log->showLog(4,"Before insert allowancepayroll_amount SQL:$sql");
			$rs=$xoopsDB->query($sql);

			if (!$rs){
			$log->showLog(1,"Failed to update item");
			}else{

			
			echo "<script language=javascript>
				
			</script>";
			}

			
			}


}

	$sql = "select * 
		from $tableallowancepayroll a 
		where payroll_id = $payroll_id ";

	$query=$xoopsDB->query($sql);
	
	/*
	$styleth = "style='background-color: #be1515; color: #FFFFFF; padding : 2px; vertical-align : middle; font-family: Verdana, Arial, Helvetica, sans-serif;font-weight :bold'";*/
	
	$styleth = "";
echo <<< EOF


<table border=0 >
<form name="frmAllowance" action="allowancefrm.php" method="POST">
<input type="hidden" value="$payroll_id" name="payroll_id">
<input type="hidden" value="" name="line">
<input type="hidden" value="save" name="action">

<tr>
	<th width="10%" $styleth>No</th>
	<th width="40%" $styleth>Type</th>
	<th width="10%" $styleth>SOCSO</th>
	<th width="10%" $styleth>EPF</th>
	<th width="20%" $styleth>Amount</th>
	<th width="10%" $styleth></th>
</tr>

EOF;
		$stylerm = "style='text-align:right'";

		$rowtype="";
		$i=0;
		while($row=$xoopsDB->fetchArray($query)){
		$i++;
		$checked = "";
		$checked2 = "";

		$allowancepayroll_id = $row['allowancepayroll_id'];
		$allowancepayroll_name = $row['allowancepayroll_name'];
		$allowancepayroll_socso = $row['allowancepayroll_socso'];
		$allowancepayroll_epf = $row['allowancepayroll_epf'];
		$allowancepayroll_amount = $row['allowancepayroll_amount'];
		
		if($rowtype=="odd")
		$rowtype="even";
		else
		$rowtype="odd";

		if($allowancepayroll_socso=="Y")
		$checked = "CHECKED";
		if($allowancepayroll_epf=="Y")
		$checked2 = "CHECKED";

echo <<< EOF


<input type="hidden" value="$allowancepayroll_id" name="allowancepayroll_id[$i]">

<tr height="30">
	<td class="$rowtype">$i</td>
	<td class="$rowtype">$allowancepayroll_name</td>
	<td class="$rowtype" align="center"><input type="checkbox" name="allowancepayroll_socso[$i]" $checked onclick="calculateTotal(this.name,this.value)"></td>
	<td class="$rowtype" align="center"><input type="checkbox" name="allowancepayroll_epf[$i]" $checked2 onclick="calculateTotal(this.name,this.value)"></td>
	<td class="$rowtype"><input name="allowancepayroll_amount[$i]" value="$allowancepayroll_amount" size="6" maxlength="10" onblur="calculateTotal(this.name,this.value)" $stylerm></td>

	<td class="$rowtype" align="center">
	<image src="images/del.gif" style="cursor:pointer" title="Delete this item" onclick="deleteLine($allowancepayroll_id)">
	</td>
	
</tr>

EOF;
		}

echo <<< EOF
</form>
</table>
<br>


</body>


EOF;

if($_POST && $action == "delete" && false){
echo "<script language=javascript>
				updateParent();
			</script>";
}			


	function updateTotalAmount($log,$xoopsDB,$tablesales,$tablesalesline,$sales_id){
	$retval = 0;

	$sql = "UPDATE $tablesales SET sales_totalamount = COALESCE((SELECT sum(salesline_amount) as total FROM $tablesalesline 
								 WHERE sales_id = $sales_id),0) 
		WHERE sales_id = $sales_id";
	
	$sqltotal = "SELECT COALESCE((SELECT sum(salesline_amount) as total FROM $tablesalesline WHERE sales_id = $sales_id),0) as total";
	
	$log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$xoopsDB->query($sql);
	if(!$rs){
		$log->showLog(2, "Warning! Update sales failed");
		return false;
	}else{
		$log->showLog(2, "Update sales Successfully");
		$query=$xoopsDB->query($sqltotal);

		if($row=$xoopsDB->fetchArray($query)){
		$retval = $row['total'];
		}
		return $retval;
	}

  	}


?>



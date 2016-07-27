<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once "menu.php";
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

echo <<< EOF
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../xoops.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../themes/default/style.css">

<body astyle=" background: #ffb711;" class="head">
EOF;
echo "<table><tr align='center' height=20><td align='left'><b>Leave</b></td></tr></table>";

$log = new Log();
$uid = $xoopsUser->getVar('uid');
$uname = $xoopsUser->getVar('uname');
$tablesales=$tableprefix."simsalon_sales";
$tablesalesline=$tableprefix."simsalon_salesline";
$tableproductlist=$tableprefix."simsalon_productlist";
$tableproductcategory = $tableprefix."simsalon_productcategory";
$tableleaveline = $tableprefix."simsalon_leaveline";

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
$leaveline_id = $_POST['leaveline_id'];
$leaveline_amount= $_POST['leaveline_amount'];
$leaveline_qty= $_POST['leaveline_qty'];

if($_POST && $action == "delete"){
	$sql = "delete from $tableleaveline where leaveline_id = $line";

	$log->showLog(4,"Before insert leaveline_id SQL:$sql");


		$rs=$xoopsDB->query($sql);

		if (!$rs){
			$log->showLog(1,"Failed to delete item");
		}
		else{
			$log->showLog(3,"deleting new successfully"); 
			$totalamt = updateTotalAmount($log,$xoopsDB,$tablesales,$tablesalesline,$sales_id);
			echo "<script language=javascript>
				parent.getAmountFrm('');
			</script>";
		}
}

if($_POST && $action == "save"){

			// update amount list
			$row = count($leaveline_id);
	
			$i=0;
			while($i<$row){
			$i++;

			$leaveline_idi = $leaveline_id[$i];
			$leaveline_amounti = $leaveline_amount[$i];
			$leaveline_qtyi = $leaveline_qty[$i];

			$sql = "update $tableleaveline set leaveline_amount = $leaveline_amounti, leaveline_qty  = $leaveline_qtyi 
				where leaveline_id = $leaveline_idi ";

			$log->showLog(4,"Before insert leaveline_amount SQL:$sql");
			$rs=$xoopsDB->query($sql);

			if (!$rs){
			$log->showLog(1,"Failed to update item");
			}else{
				echo "<script language=javascript>
				parent.getAmountFrm('');
				</script>";
			}

			
			}

}

	$sql = "select * 
		from $tableleaveline a 
		where payroll_id = $payroll_id ";

	$query=$xoopsDB->query($sql);
	
	/*
	$styleth = "style='background-color: #be1515; color: #FFFFFF; padding : 2px; vertical-align : middle; font-family: Verdana, Arial, Helvetica, sans-serif;font-weight :bold'";*/

	$styleth = "";

echo <<< EOF


<table border=0 >
<form name="frmAllowance" action="leavefrm.php" method="POST">
<input type="hidden" value="save" name="action">
<input type="hidden" value="$payroll_id" name="payroll_id">
<input type="hidden" value="" name="line">

<tr>
	<th width="10%" $styleth>No</th>
	<th width="50%" $styleth>Type</th>
	<th width="10%" $styleth>Qty</th>
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

		$leaveline_id = $row['leaveline_id'];
		$leaveline_name = $row['leaveline_name'];
		$leaveline_qty = $row['leaveline_qty'];
		$leaveline_amount = $row['leaveline_amount'];
		
		if($rowtype=="odd")
		$rowtype="even";
		else
		$rowtype="odd";

		if($leaveline_socso="Y")
		$checked = "CHECKED";
		if($leaveline_epf=="Y")
		$checked2 = "CHECKED";


echo <<< EOF

<input type="hidden" value="$leaveline_id" name="leaveline_id[$i]">

<tr height="30">
	<td class="$rowtype">$i</td>
	<td class="$rowtype">$leaveline_name</td>
	<td class="$rowtype"><input name="leaveline_qty[$i]" value="$leaveline_qty" size="3" maxlength="10" onblur="calculateTotal()" $stylerm></td>
	<td class="$rowtype"><input name="leaveline_amount[$i]" value="$leaveline_amount" size="6" maxlength="10" onblur="calculateTotal()" $stylerm></td>

	<td class="$rowtype" align="center">
	<image src="images/del.gif" style="cursor:pointer" title="Delete this item" onclick="deleteLine($leaveline_id)">
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

function calculateTotal(){
document.forms['frmAllowance'].action.value = "save";
document.forms['frmAllowance'].submit();
}

function deleteLine(line){

if(confirm("Confirm delete this leave?")==true){
document.forms['frmAllowance'].line.value = line;
document.forms['frmAllowance'].action.value = "delete";
document.forms['frmAllowance'].submit();
}

}

</script>


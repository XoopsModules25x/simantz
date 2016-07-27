<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once "menu.php";
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

echo <<< EOF
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../xoops.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../themes/default/style.css">

<body style=" background: gainsboro;">
EOF;
echo "<table><tr align='center' height=20><td align='left'><b>List Of Item</b></td></tr></table>";

$log = new Log();
$uid = $xoopsUser->getVar('uid');
$uname = $xoopsUser->getVar('uname');
$tablesales=$tableprefix."simsalon_sales";
$tablesalesline=$tableprefix."simsalon_salesline";
$tablesalesemployeeline=$tableprefix."simsalon_salesemployeeline";
$tableproductlist=$tableprefix."simsalon_productlist";
$tableproductcategory = $tableprefix."simsalon_productcategory";
$tablepromotion = $tableprefix."simsalon_promotion";

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

$datectrl=$dp->show("jobcontrol_date");

$timestamp= date("Y-m-d H:i:s", time()) ;


if (isset($_POST['sales_id']))
	$sales_id=$_POST['sales_id'];
elseif(isset($_GET['sales_id']))
	$sales_id=$_GET['sales_id'];

$salesline_id = $_POST['salesline_id'];

if($_POST && $salesline_id > 0){
	$sql = "delete from $tablesalesline where salesline_id = $salesline_id";

	$log->showLog(4,"Before insert salesline SQL:$sql");


		$rs=$xoopsDB->query($sql);

		if (!$rs){
			$log->showLog(1,"Failed to delete item");
		}
		else{
			$log->showLog(3,"deleting new successfully"); 
			$totalamt = updateTotalAmount($log,$xoopsDB,$tablesales,$tablesalesline,$sales_id);
			echo "<script language=javascript>
				self.parent.document.forms['frmPayment'].sales_totalamount.value =  $totalamt;
				parseelement(self.parent.document.forms['frmPayment'].sales_totalamount);
				total_amount = self.parent.document.forms['frmPayment'].sales_totalamount.value;
				total_paid = self.parent.document.forms['frmPayment'].sales_paidamount.value;
				total_change = parseFloat(total_paid) - parseFloat(total_amount);
				self.parent.document.forms['frmPayment'].sales_change.value = total_change;
				parseelement(self.parent.document.forms['frmPayment'].sales_change);
				self.parent.document.getElementById('infoitem').src = '../infoitem.php?salesline_id=0&line=';

			</script>";
		}
}

	$sql = "SELECT * from $tablesalesline a, $tablesales b, $tableproductlist c
		where a.sales_id = b.sales_id 
		and a.product_id = c.product_id 
		and a.sales_id = $sales_id
		order by salesline_no desc";
	$query=$xoopsDB->query($sql);

/*
$styleth = "style='background-color: #be1515; color: #FFFFFF; padding : 2px; vertical-align : middle; font-family: Verdana, Arial, Helvetica, sans-serif;font-weight :bold'";	
*/
$styleth = "";
	

echo <<< EOF


<table border=0 >


<tr>
	<th width="10%" $styleth>No</th>
	<th width="80%" $styleth>Product</th>
	<th width="10%" $styleth></th>
</tr>

EOF;
		$rowtype="";
		$i=0;
		while($row=$xoopsDB->fetchArray($query)){
		$i++;
		$employee_empty = 0;

		$sales_id = $row['sales_id'];
		$product_id = $row['product_id'];
		$product_name1 = $row['product_name'];
		$product_name = $row['product_name'];
		$product_name .= "<br><b>Qty : </b>".$row['salesline_qty']." ~ <b>Amount (RM):</b> ".$row['salesline_amount'];
		$salesline_id = $row['salesline_id'];

		$sqlcheck = 	"select count(*) as cnt from $tablesalesemployeeline 
				where salesline_id = $salesline_id 
				and employee_id = 0 ";
		
		$querycheck=$xoopsDB->query($sqlcheck);
		
		if($rowcheck=$xoopsDB->fetchArray($querycheck)){
			if($rowcheck['cnt'] > 0)
			$employee_empty = 1;
		}

	

		if($employee_empty == 1)
		$styleline = "style='color:red'";
		else
		$styleline = "";

		if($rowtype=="odd"){
		$rowtype="even";
		$tdcolor = $even_color;
		}else{
		$rowtype="odd";
		$tdcolor = $odd_color;
		}
	
//		$isbuyfree = checkPromotion($tablepromotion,$tablesales,$tablesalesline,$product_id,$sales_id);

		

echo <<< EOF

<tr height="30" $styleline>
	<td class="$rowtype" >$i</td>
	<td id=testID class="$rowtype"  onclick="getLineInfo($i,$salesline_id)" style="cursor:pointer" title="$product_name1" onmouseover="do_over(this,'$head_color','N');" onmouseout="do_out(this,'$tdcolor','N');">$product_name</td>
	<td class="$rowtype" align="center">
	<form method="POST" action="listitem.php" onsubmit=" return confirm('Delete this item?')">
	<input type="hidden" value="$salesline_id" name="salesline_id" >
	<input type="hidden" value="$sales_id" name="sales_id" >
	<input type="image" src="images/del.gif" astyle="height:30px" title="Delete this item">
	</form>
	</td>
	
</tr>

EOF;
		}

		$isbuyfree = checkPromotion($tablepromotion,$tablesales,$tablesalesline,$tableproductlist,$sales_id);

echo <<< EOF
	<tr>
	<td colspan="3" align="center"><font color="blue">$isbuyfree</font></td>
	</tr>

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

	function checkPromotion($tablepromotion,$tablesales,$tablesalesline,$tableproductlist,$sales_id){
	global $xoopsDB;
	$retval = "";
	$curdate = date("Y-m-d", time()) ;
	$text = "";

	$sql = "select b.product_id,a.customer_id from $tablesales a, $tablesalesline b  
		where a.sales_id = b.sales_id 
		and a.sales_id = $sales_id 
		group by b.product_id ";
	
	$query=$xoopsDB->query($sql);
	while($row=$xoopsDB->fetchArray($query)){
	$product_id_line = $row['product_id'];
	$customer_id = $row['customer_id'];

	$sqlpromo = 	"select count(*) as rowcount, a.promotion_buy, a.promotion_free, d.product_name, 
			
			(select count(*) as rowcount 
			from $tablepromotion a, $tablesales b, $tablesalesline c, $tableproductlist d   
			where b.sales_id = c.sales_id 
			and a.product_id = c.product_id 
			and c.product_id = d.product_id 
			and a.product_id = $product_id_line 
			and a.promotion_expiry > b.sales_id 
			and b.customer_id =  $customer_id 
			and c.isfree = 'Y' 
			and IF(a.isonepayment = 'Y', b.sales_id = $sales_id ,1) 
			and IF(b.sales_id = $sales_id, 1 , b.iscomplete = 'Y' ) 
			and b.sales_date >= a.promotion_effective 
			group by a.product_id ) as countfree 
			
			from $tablepromotion a, $tablesales b, $tablesalesline c, $tableproductlist d   
			where b.sales_id = c.sales_id 
			and a.product_id = c.product_id 
			and c.product_id = d.product_id 
			and a.product_id = $product_id_line 
			and a.promotion_expiry > b.sales_id 
			and b.customer_id =  $customer_id 
			and c.isfree = 'N' 
			and IF(a.isonepayment = 'Y', b.sales_id = $sales_id ,1) 
			and IF(b.sales_id = $sales_id, 1 , b.iscomplete = 'Y' ) 
			and b.sales_date >= a.promotion_effective 
			group by a.product_id ";

	$querypromo=$xoopsDB->query($sqlpromo);
	if($row=$xoopsDB->fetchArray($querypromo)){
	$rowcount = $row['rowcount'];	
	$promotion_buy = $row['promotion_buy'];
	$promotion_free = $row['promotion_free'];
	$product_name = $row['product_name'];
	$countfree = $row['countfree'];
					
	
	$totalreward = (int)(($rowcount- $countfree*($promotion_buy-1))/$promotion_buy);
	
	if($totalreward > 0)
	$text .= "* Get $totalreward free for [ $product_name ]<br>";
	}
	$retval = $text;
	}

	return $retval;
	}


?>

<script type="text/javascript">

function saveRemarks(){
var remarks = document.forms['frmRemarks'].remarks_desc.value;

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

</script>


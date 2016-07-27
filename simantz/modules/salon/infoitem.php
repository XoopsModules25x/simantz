<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Employee.php';
include_once "menu.php";
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

echo <<< EOF
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../xoops.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../themes/default/style.css">

<body style=" background: gainsboro;">
EOF;

$product_name = "";
$salesline_qty = 0;
$salesline_price = "0.00";
$salesline_amount = "0.00";
$employee_id = 0;
$product_id = 0;
$uom = "";

$log = new Log();
$e = new Employee($xoopsDB,$tableprefix,$log);

$uid = $xoopsUser->getVar('uid');
$uname = $xoopsUser->getVar('uname');
$tablesales=$tableprefix."simsalon_sales";
$tablesalesline=$tableprefix."simsalon_salesline";
$tableproductlist=$tableprefix."simsalon_productlist";
$tableproductcategory = $tableprefix."simsalon_productcategory";
$tablesalesemployeeline = $tableprefix."simsalon_salesemployeeline";
$tableuom = $tableprefix."simsalon_uom";

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

$datectrl=$dp->show("jobcontrol_date");

$timestamp= date("Y-m-d H:i:s", time()) ;
$action=$_POST['action'];

if (isset($_POST['salesline_id']))
	$salesline_id=$_POST['salesline_id'];
elseif(isset($_GET['salesline_id']))
	$salesline_id=$_GET['salesline_id'];

$line = $_GET['line'];

if($line=="")
$line = "No Item Selected";


if($salesline_id=="")
$salesline_id = 0;

echo "<table border=0><tr align='center' height=20><td align='left'><b>Info Of Item No : </b>$line</td></tr></table>";

if($action=="save"){

		$salesline_qty =$_POST['salesline_qty'];
		$salesline_price = $_POST['salesline_price'];
		$salesline_oprice = $_POST['salesline_oprice'];
		$salesline_amount = $_POST['salesline_amount'];
		$employee_id = $_POST['employee_id'];
		$percent_line = $_POST['percent_line'];
		$isfree = $_POST['isfree'];
		$salesemployeeline_id = $_POST['salesemployeeline_id']; 

		if($isfree == "on")
		$isfree = "Y";
		else
		$isfree = "N";

		//echo count($employee_id);

 		$sql = "update $tablesalesline 
				set salesline_qty = $salesline_qty, salesline_price = $salesline_price, salesline_oprice = $salesline_oprice, salesline_amount = $salesline_amount, 
				isfree = '$isfree' 
				where salesline_id = $salesline_id";
		
		$log->showLog(4,"Before insert salesline SQL:$sql");


		$rs=$xoopsDB->query($sql);

		if (!$rs){
			$log->showLog(1,"Failed to update item");
		}
		else{

			$sales_id = getSalesID($log,$xoopsDB,$salesline_id,$tablesalesline);
			$log->showLog(3,"updating successfully"); 
			
			if($sales_id > 0){
			$totalamt = updateTotalAmount($log,$xoopsDB,$tablesales,$tablesalesline,$sales_id);
			echo "<script language=javascript>
				self.parent.document.forms['frmPayment'].sales_totalamount.value =  $totalamt;
				change = self.parent.document.forms['frmPayment'].sales_paidamount.value - $totalamt;
				self.parent.document.forms['frmPayment'].sales_change.value =  change;
				parseelement(self.parent.document.forms['frmPayment'].sales_change);
				parseelement(self.parent.document.forms['frmPayment'].sales_totalamount);
				self.parent.document.getElementById('listitem').src = '../listitem.php?sales_id=$sales_id';

			</script>";

			// update employee list
			$row = count($employee_id);
	
			$i=0;
			while($i<$row){
			
			
			$employee_idi = $employee_id[$i] ;
			$percenti = $percent_line[$i] ;
			$salesemployeeline_idi = $salesemployeeline_id[$i];

			$sql = "update $tablesalesemployeeline set employee_id = $employee_idi, percent = $percenti 
				where salesemployeeline_id = $salesemployeeline_idi ";

			$log->showLog(4,"Before insert salesline SQL:$sql");
			$rs=$xoopsDB->query($sql);

			if (!$rs){
			$log->showLog(1,"Failed to update item");
			}

			$i++;
			}

			}
		}
		
}

if($action=="add"){
	//insert 1 row default (employee list)
	$sql = "insert into $tablesalesemployeeline (salesline_id,employee_id,percent) 
		values ($salesline_id,0,0) ";

	$log->showLog(4,"Before insert salesline SQL:$sql");

	if($salesline_id>0)
	$rs=$xoopsDB->query($sql);

	
	if (!$rs){
	$log->showLog(1,"Failed to insert employee");
	}else{
	$sales_id = getSalesID($log,$xoopsDB,$salesline_id,$tablesalesline);
	echo "<script language=javascript>
			self.parent.document.getElementById('listitem').src = '../listitem.php?sales_id=$sales_id';
		</script>";

	}

}

if($action=="delete"){
	$salesemployeeline_value=$_POST['salesemployeeline_value'];

	$sql = "delete from $tablesalesemployeeline where salesemployeeline_id = $salesemployeeline_value";
	$log->showLog(4,"Before insert salesline SQL:$sql");

	$rs=$xoopsDB->query($sql);

	
	if (!$rs){
	$log->showLog(1,"Failed to remove employee");
	}else{
	$sales_id = getSalesID($log,$xoopsDB,$salesline_id,$tablesalesline);
	echo "<script language=javascript>
			self.parent.document.getElementById('listitem').src = '../listitem.php?sales_id=$sales_id';
		</script>";
	}
}


$sql = "SELECT * from $tablesalesline a, $tableproductlist b, $tableuom c 
		where salesline_id = $salesline_id
		and a.product_id = b.product_id  and b.uom_id = c.uom_id ";
		
$query=$xoopsDB->query($sql);

$log->showLog(4, "With SQL: $sql");
$query=$xoopsDB->query($sql);
$isfree = "N";
if($row=$xoopsDB->fetchArray($query)){

$product_name = $row['product_name'];
$salesline_qty = $row['salesline_qty'];
$salesline_price = $row['salesline_price'];
$salesline_oprice = $row['salesline_oprice'];
$salesline_amount = $row['salesline_amount'];
$product_id = $row['product_id'];
$uom = $row['uom_description'];
$isfree = $row['isfree'];

if($salesline_oprice <= 0)
$salesline_oprice = $salesline_price;
}

if($isfree == "Y")
$isfreechecked = "CHECKED";
else
$isfreechecked = "";

//$employeectrl=$e->getEmployeeList($employee_id,"","employee_id","calculateTotal(document)");
//$employeectrl = $e->getEmployeeListArray($employee_id,$i);

if($salesline_id==0)
$stylebtn = "style='display:none'";

echo <<< EOF


<table border=1 >
<form name="frmInfo" method="POST" onsubmit="return validateData();">
<input type="hidden" value="$salesline_id" name="salesline_id">
<input type="hidden" value="" name="salesemployeeline_value">
<input type="hidden" value="save" name="action">
<tr height="30">
	<td class="head" width="40%">Product Name</td>
	<td class="even" width="60%">$product_name</td>
</tr>
<tr height="30">
	<td class="head">Quantity</td>
	<td class="even"><input name="salesline_qty" value="$salesline_qty" maxlength="10" size="3" onblur="calculateTotal(document)" $stylebtn autocomplete='off' onclick="this.select();">&nbsp;$uom</td>
</tr>
<tr height="30">
	<td class="head">Unit Price (RM)</td>
	<td class="even"><input name="salesline_oprice" value="$salesline_oprice" $stylebtn readonly maxlength="10" size="10"></td>
</tr>
<tr height="30">
	<td class="head">Sell Price (RM)</td>
	<td class="even"><input name="salesline_price" value="$salesline_price" maxlength="10" size="10" onblur="calculateTotal(document)" $stylebtn autocomplete='off' onclick="this.select();"></td>
</tr>
<tr height="30">
	<td class="head">Amount (RM)</td>
	<td class="even"><input name="salesline_amount" value="$salesline_amount" maxlength="10" size="10" aonblur="calculateTotal(document)" readonly $stylebtn autocomplete='off'></td>
</tr>
<tr height="30">
	<td class="head">Free</td>
	<td class="even"><input type="checkbox" name="isfree" $isfreechecked onclick="salesline_price.value = '0';calculateTotal(document)"></td>
</tr>
<tr height="30">
	<td class="head" colspan="2">Stylist : <input type="button" $stylebtn name= "btnAdd" value="+" style="font-size:10pt;font-weight:bold;height:23px;width:25px"  onclick="addEmployeeLine();"><br><br>

	<div $stylebtn><!--write employee list-->
		<table border=0>

EOF;
		$sql = "select * from $tablesalesemployeeline where salesline_id = $salesline_id ";
		$log->showLog(4,"SQL before execute:" . $sql . "<br>");
	
		$query=$xoopsDB->query($sql);

		$i = 0;
		$i=0;
		while($row=$xoopsDB->fetchArray($query)){
		$i++;
		$salesemployeeline_id = $row['salesemployeeline_id'];
		$e_id = $row['employee_id'];
		$percent = $row['percent'];

		$employeectrl=$e->getEmployeeList($e_id,"","employee_id[]","updateEmployee(document,this)");

echo <<< EOF
		<tr class="odd">
			<input name="salesemployeeline_id[]" value="$salesemployeeline_id" type="hidden">
			<td>$employeectrl</td>
			<td align="center"><input name="percent_line[]" size="4" maxlength="6" value="$percent" onblur="updatePercent(document)" autocomplete='off' onclick="this.select();">%</td>
			<td align="center"><image   src="images/del.gif" onclick="deleteLine($salesemployeeline_id)" style="cursor:pointer" title="Delete this record"></td>
		</tr>
EOF;
		}

echo <<< EOF
	
		</table>
	</div>

	</td>
	
</tr>
<tr height="30" style="display:none">
	<td class="head" colspan="2" align=right><input type="submit" value = "Update Item" style="width:100px;height:40px"></td>
</tr>

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

	function getSalesID($log,$xoopsDB,$salesline_id,$tablesalesline){
	$retval = 0;

	$sql = "SELECT sales_id FROM $tablesalesline WHERE salesline_id = $salesline_id";
	
	$log->showLog(4, "With SQL: $sql");
	$query=$xoopsDB->query($sql);
	
	if($row=$xoopsDB->fetchArray($query)){
	$retval = $row['sales_id'];
	}

	return $retval;
	}

$asdsa = 0;
?>

<script type="text/javascript">
	
	//alert(document.forms['frmInfo'].btnAdd.default);
	

	function saveInfo(){


		if(confirm("Update This Item?")){
			return validateData();	
		}else
			return false;
	
	}

	function validateData(){
	
	
	var i=0;
	var amount = 0;
	while(i< document.forms['frmInfo'].elements.length){
		var ctlname = document.forms['frmInfo'].elements[i].name; 
		var data = document.forms['frmInfo'].elements[i].value;
		
		if(ctlname=="salesline_qty" || ctlname=="salesline_price" || ctlname=="salesline_amount" || ctlname=="percent_line[]"){
		
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmInfo'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmInfo'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmInfo'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
		}

		if(ctlname=="percent_line[]"){
		amount += parseFloat(data);
		}

		
		
		i++;
		
	}

	if(amount>100){
	alert("Percent more than 100%. Please Key In Again");
	return false;
	}

	return true;
	}

	function calculateTotal(doc){//calculate total amount
	
	var amount=0;

	var qty = parseFloat(doc.forms['frmInfo'].salesline_qty.value);
	var price = parseFloat(doc.forms['frmInfo'].salesline_price.value);
	var totalamount = parseFloat(self.parent.document.forms['frmPayment'].sales_totalamount.value);

	doc.forms['frmInfo'].salesline_amount.value = qty*price;

	parseelement(doc.forms['frmInfo'].salesline_price);
	parseelement(doc.forms['frmInfo'].salesline_amount);

	if(validateData())
	doc.forms['frmInfo'].submit();

	/*
	amount += qty*price;

	self.parent.document.forms['frmPayment'].sales_totalamount.value = amount + totalamount;
	parseelement(self.parent.document.forms['frmPayment'].sales_totalamount);//set value at header (total amount)
	*/
	
	}

	function updateEmployee(doc,thisone){
	
	if(validateData()){
		
		if(checkEmployee(thisone)){
		doc.forms['frmInfo'].submit();
		}else{
		alert("Stylist already in the list.");
		thisone.value = 0;
		}
	}

	}

	function updatePercent(doc){

	if(checkPercent())
	doc.forms['frmInfo'].submit();
	else
	alert("Percent more than 100%. Please Key In Again");
	

	}

	function addEmployeeLine(){// add employee line
	document.forms['frmInfo'].action.value = "add";

	if(validateData())
	document.forms['frmInfo'].submit();
	}

	function deleteLine(line){// delete line

	if(confirm("Confirm delete this stylist?")==true){
	document.forms['frmInfo'].action.value = "delete";
	document.forms['frmInfo'].salesemployeeline_value.value = line;
	document.forms['frmInfo'].submit();
	}
	}

	function checkPercent(){
	
	var i=0;
	var amount = 0;
	while(i< document.forms['frmInfo'].elements.length){
		var ctlname = document.forms['frmInfo'].elements[i].name; 
		var data = document.forms['frmInfo'].elements[i].value;
		

		if(ctlname=="percent_line[]"){
		amount += parseFloat(data);
		}

		i++;
		
	}

	if(amount>100){
	return false;
	}

	return true;
	}

	function checkEmployee(thisone){
	
	var i=0;
	var isemployee = 0;
	while(i< document.forms['frmInfo'].elements.length){
		var ctlname = document.forms['frmInfo'].elements[i].name;
		var elementname = document.forms['frmInfo'].elements[i];  
		var data = document.forms['frmInfo'].elements[i].value;
		

		if(ctlname=="employee_id[]" && thisone != elementname){
		
		if(data==thisone.value)
		return false;
				
		}

		i++;
		
	}


	return true;
	}


	
	function stopRKey(evt) {
	var evt = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	if ((evt.keyCode == 13) && (node.type=="text"))  {
		document.forms['frmInfo'].salesline_id.focus();
		return false;
		
	}
	}
	
	document.onkeypress = stopRKey; 
</script>


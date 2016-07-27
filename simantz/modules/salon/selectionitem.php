<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once "menu.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

echo <<< EOF
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../xoops.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="../../themes/default/style.css">

<body style=" background: gainsboro;">
EOF;


$log = new Log();
$uid = $xoopsUser->getVar('uid');
$uname = $xoopsUser->getVar('uname');
$tableproductcategory=$tableprefix."simsalon_productcategory";
$tableproductlist=$tableprefix."simsalon_productlist";
$tablesalesline=$tableprefix."simsalon_salesline";
$tablesales=$tableprefix."simsalon_sales";
$tablesalesemployeeline = $tableprefix."simsalon_salesemployeeline";

$timestamp= date("Y-m-d H:i:s", time()) ;
$styleback = "";


if (isset($_POST['sales_id']))
	$sales_id=$_POST['sales_id'];
elseif(isset($_GET['sales_id']))
	$sales_id=$_GET['sales_id'];

$issave = $_POST['issave'];
$fldCategory = $_POST['fldCategory'];
$fldProduct = $_POST['fldProduct'];


if($fldCategory==""){
$listname = "Category";
$styleback = "style = 'display:none' ";
}else{
//$listname = "List Of Product";
$listname = "";
}



if($fldCategory>0)
$category_name = getInfoCategory("category_description",$fldCategory,$xoopsDB,$tableproductcategory);

echo 	"<form action='selectionitem.php' method='POST'><table><tr align='Left' height=20><td><b>$listname  $category_name</b></td>
		<td align='Right' $styleback><input type='hidden' name='sales_id' value='$sales_id'><input type='submit' value='<< Back'></td>
		</tr></table></form>";

/*
$styleth = "style='background-color: #be1515; color: #FFFFFF; padding : 2px; vertical-align : middle; font-family: Verdana, Arial, Helvetica, sans-serif;font-weight :bold'";	
*/

$styleth = "";


		
if($_POST && $fldProduct > 0){

		$line = getLatestLine("salesline_no",$xoopsDB,$tablesalesline,$sales_id) + 1;
		$price = getPriceProduct($fldProduct,$xoopsDB,$tableproductlist);
		
		$sql = "insert into $tablesalesline (salesline_no,sales_id,employee_id,product_id,salesline_qty,salesline_price,salesline_amount) values 
				($line,$sales_id,0,$fldProduct,1,$price,$price)";

		$log->showLog(4,"Before insert salesline SQL:$sql");

		$rs=$xoopsDB->query($sql);

		$totalamount = 0;

		if (!$rs){
			$log->showLog(1,"Failed to insert item");
		}
		else{
			$log->showLog(3,"Inserting new successfully"); 
			$latesline_id = getLatestLineid("salesline_id",$xoopsDB,$tablesalesline,$sales_id);
			$totalamt = updateTotalAmount($log,$xoopsDB,$tablesales,$tablesalesline,$sales_id);

			//insert 1 row default (employee list)
			$sql = "insert into $tablesalesemployeeline (salesline_id,employee_id,percent) 
				values ($latesline_id,0,100) ";

			$log->showLog(4,"Before insert salesline SQL:$sql");

			$rs=$xoopsDB->query($sql);

			
			if (!$rs){
			$log->showLog(1,"Failed to insert employee");
			}else{
			}

			echo "<script language=javascript>
				self.parent.document.forms['frmPayment'].sales_totalamount.value =  $totalamt;
				self.parent.document.getElementById('listitem').src = '../listitem.php?sales_id=$sales_id';
				self.parent.document.getElementById('infoitem').src = '../infoitem.php?salesline_id=$latesline_id&line=1';
				parseelement(self.parent.document.forms['frmPayment'].sales_totalamount);
				total_amount = self.parent.document.forms['frmPayment'].sales_totalamount.value;
				total_paid = self.parent.document.forms['frmPayment'].sales_paidamount.value;
				total_change = parseFloat(total_paid) - parseFloat(total_amount);
				self.parent.document.forms['frmPayment'].sales_change.value = total_change;
				parseelement(self.parent.document.forms['frmPayment'].sales_change);

			</script>";
		}
}




	if($fldCategory=="")
	$sql = 	"SELECT category_id as id, category_description as description, filename as filename, 'category' as type
		 from $tableproductcategory 
			where category_id > 0 and issales = 'Y' 
			order by isdefault desc,category_description asc ";
	else
	$sql = 	"SELECT product_id as id, product_name as description, filename as filename, 'product' as type 
		from $tableproductlist 
			where category_id = $fldCategory  and issales = 'Y' 
			order by isdefault desc,product_name asc ";
			


	$query=$xoopsDB->query($sql);

echo <<< EOF


<table border=0>
	
EOF;
		$i=0;
		$j=0;
		$rowtype = "";
		while($row=$xoopsDB->fetchArray($query)){
		$i++;
		$j++;
		
		$description = $row['description'];
		
		if($_POST['fldCategory']=="")
		$fldCategory = $row['id'];
		else
		$fldproduct = $row['id'];
	
		if($j==1)
		echo "<tr>";

		$type = $row['type'];
		$filename = $row['filename'];

		if($type == "category")
		$path = "upload/category/";
		else
		$path = "upload/products/";

		
		/*
		if($filename != "" && $filename != "-")
		$pathimage = $path.$filename;
		else
		$pathimage = "images/modulepic.jpg";
		*/

		$fn = $path.$filename;

		if(file_exists($fn) && $filename != "" && $filename != "-")
		$pathimage = $path.$filename;
		else
		$pathimage = "images/iconselection.png";
		//echo $pathimage;

		if($rowtype=="odd"){
		$rowtype="even";
		$tdcolor = $even_color;
		}else{
		$rowtype="odd";
		$tdcolor = $odd_color;
		}

		
		
echo <<< EOF
		<form name="frmSelection" method="POST" action="selectionitem.php" onsubmit="return checkSelect($sales_id);">
		<input type="hidden" name="fldCategory" value="$fldCategory">
		<input type="hidden" name="fldProduct" value="$fldproduct">
		<input type="hidden" name="sales_id" value="$sales_id">
		<td align=center width="33%" class="$rowtype" onmouseover="do_over(this,'$head_color','Y');" onmouseout="do_out(this,'$tdcolor','Y');">
		<input type="image" avalue="$i" style="height:50px;width:55px" src=$pathimage>
		<br><font size="2pt"><b>$description</b></font>
		</td>
		</form>
EOF;
		if($j==3){
		echo "<tr>";
		$j=0;
		}
		
		}
		
echo <<< EOF

</table>
<br>


</body>
EOF;

	function getInfoCategory($fld,$id,$xoopsDB,$tableproductcategory){
	$retval = "";
	$sql = "SELECT $fld as fld FROM $tableproductcategory WHERE category_id = $id ";
	
	
	$query=$xoopsDB->query($sql);	
	//showLog(4,"With SQL: $sql");

	if($row=$xoopsDB->fetchArray($query)){
	$retval = $row['fld'];
	}
	
	return $retval;
   	}

	function getPriceProduct($id,$xoopsDB,$tableproductlist){
	$price = "0.00";
	$sql = "SELECT sellingprice FROM $tableproductlist WHERE product_id = $id ";
	
	
	$query=$xoopsDB->query($sql);	
	//showLog(4,"With SQL: $sql");

	if($row=$xoopsDB->fetchArray($query)){
	$price = $row['sellingprice'];
	}
	
	return $price;
   	}
  
	function getLatestLine($fld,$xoopsDB,$tablesalesline,$sales_id){
	$retval = 0;
	$sql = "SELECT $fld from $tablesalesline where sales_id = $sales_id ORDER BY salesline_no DESC";

	//showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$xoopsDB->query($sql);

	if($row=$xoopsDB->fetchArray($query)){
	$retval = $row[$fld];
	}
	
	return $retval;
  	}

	function getLatestLineid($fld,$xoopsDB,$tablesalesline,$sales_id){
	$retval = 0;
	$sql = "SELECT $fld from $tablesalesline ORDER BY salesline_id DESC";

	//showLog(4,"SQL before execute:" . $sql . "<br>");
	
	$query=$xoopsDB->query($sql);

	if($row=$xoopsDB->fetchArray($query)){
	$retval = $row[$fld];
	}
	
	return $retval;
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

function checkSelect(id){
//alert(id);
	if(id > 0)
	return true;
	else{
	alert('Please Select Customer.');
	return false;
	}
}

</script>


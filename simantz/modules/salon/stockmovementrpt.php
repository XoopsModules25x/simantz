<?php
require('fpdf/fpdf.php');
include_once "system.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  
  public $wherestr="Unknown";
  public $orderstr="Unknown";
  public $dataType=0;
  public $start_date="";
  public $end_date="";
  public $org_info="";
  

function Header()
{
	$timestamp= date("Y-m-d", time());
	$date = date("Y-m-d", time());
	$time = date("H:i:s", time());
	
	$this->SetFont('Times','',6);
	$this->SetXY(105,5);
	$this->Multicell(45,4,"$this->org_info",0,'L');

	$this->SetXY(80,5);
	$this->Image('./images/attlistlogo.jpg', 140 , 5 , 60 , '' , 'JPG' , '');
	$this->Ln(12);
	$this->SetFont('Arial','B',13);

	//-------------------------
	
	$this->Cell(0,4,"Stock Movement Summary Report",0,1,'L');
	$this->SetFont('Arial','',6);
	$this->Cell(0,4,"Date : $date Time : $time  Page ".$this->PageNo()." / {nb} ",0,1,'R');
	//$this->Ln();
	$this->Cell(191,0,"",1,1,'L');
	$this->SetX(90);
	
	$this->Ln(4);
	
	/*
	$timestamp= date("Y-m-d", time());
	$this->Image('./images/attlistlogo.jpg', 145 , 5 , 50 , '' , 'JPG' , '');
	$this->Ln();
	$this->SetFont('Times','BU',14);

	//-------------------------
	$this->SetXY(7,10);
	$this->Cell(195,10,"Stock Movement Summary Report",0,1,'L');
	*/
		
	$i=0;

	$header =array("No","Date","Employee","Type","Item","Stock","Qty","Balance");
	$w=array(10,18,40,25,53,15,20,15); // total width = 285

	$this->SetDrawColor(0,0,0);

	$this->SetFont('Arial','B',9); 

	$this->SetFont('Arial','B',9); 
	$this->Cell(20,7,"Start Date",0,0,'L');
	$this->Cell(5,7,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(40,7,$this->start_date,0,0,'L');

	$this->SetFont('Arial','B',9); 
	$this->Cell(20,7,"End Date",0,0,'L');
	$this->Cell(5,7,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(40,7,$this->end_date,0,1,'L');

	/*
	$this->SetFont('Arial','B',9); 
	$this->Cell(20,7,"Date",0,0,'L');
	$this->Cell(5,7,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(40,7,$timestamp,0,1,'L');
	*/
	$this->Ln(); 
	
	foreach($header as $col){
	
	$this->SetFont('Arial','B',9); 

	$this->Cell($w[$i],6,$col,1,0,'C');
	$i=$i+1;		
	}
	$this->Ln(); 	
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());

	
	
	//Position at 1.5 cm from bottom
	$this->SetY(-24);
	//Arial italic 8
	$this->SetFont('courier','I',8);
	//Page number
	$this->Ln();
	$this->Cell(0,10,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');

	/*
	//----------------fix table
	$this->SetXY(8,10);
	$this->SetDrawColor(0,0,0);
	if($this->height_tbl =="")
	$this->height_tbl = 138;
	else
	$this->height_tbl = $this->height_tbl;
	$this->Cell(190,$this->height_tbl,"",1,0,'C');*/
}

function BasicTable($header,$data,$printheader)
{

	//$this->SetDrawColor(210,210,210);
	//Column widths
	$i=0;
	
	//$w=array(10,20,70,18,10,28,34,1); // total width = 285
	$w=array(10,18,40,25,53,15,8,12,15); // total width = 285
	
    //Header
    
	$this->SetFont('Arial','',7);

	foreach($data as $row){ 
		$i=0;
		foreach($row as $col) {
			while($this->GetStringWidth($col)> $w[$i]-1)
				$col=substr_replace($col,"",-1);	
	
		
		$this->Cell($w[$i],6,$col,1,0,'C');
		
		$i=$i+1;
		}	
		$this->Ln();
		
	}
	$this->height_tbl = $this->y -55;
	
}
	function getCurrentStock($product_id,$date){
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$tablevinvoice=$tableprefix . "simsalon_vinvoice";
	$tablevinvoiceline=$tableprefix . "simsalon_vinvoiceline";
	$tablesales=$tableprefix . "simsalon_sales";
	$tablesalesline=$tableprefix . "simsalon_salesline";
	$tableinternal=$tableprefix . "simsalon_internal";
	$tableinternalline=$tableprefix . "simsalon_internalline";
	$tableproductlist=$tableprefix . "simsalon_productlist";
	$tableproductcategory=$tableprefix . "simsalon_productcategory";
	
	$sqlvinvoice = 
	"SELECT sum(b.vinvoiceline_qty) as total_qty 
	from $tablevinvoice a, $tablevinvoiceline b 
	where a.vinvoice_id = b.vinvoice_id and a.iscomplete = 'Y' and a.isactive = 'Y' 
	and b.product_id = $product_id 
	and a.vinvoice_date < '$date' ";

	$sqlsales = 
	"SELECT sum(b.salesline_qty) as total_qty 
	from $tablesales a, $tablesalesline b 
	where a.sales_id = b.sales_id and a.iscomplete = 'Y' and a.isactive = 'Y'  
	and b.product_id = $product_id 
	and a.sales_date < '$date' ";

	$sqlinternal = 
	"SELECT sum(b.internalline_qty) as total_qty 
	from $tableinternal a, $tableinternalline b 
	where a.internal_id = b.internal_id and a.iscomplete = 'Y' and a.isactive = 'Y'  
	and a.internal_type = 'I' 
	and b.product_id = $product_id 
	and a.internal_date < '$date' ";

	$sqladjustment = 
	"SELECT sum(b.internalline_qty) as total_qty 
	from $tableinternal a, $tableinternalline b 
	where a.internal_id = b.internal_id and a.iscomplete = 'Y' and a.isactive = 'Y'  
	and a.internal_type = 'A' 
	and b.product_id = $product_id 
	and a.internal_date < '$date' ";

// 	$sql = "select 	(coalesce(($sqlvinvoice),0) - coalesce(($sqlsales),0) - coalesce(($sqlinternal),0) + coalesce(($sqladjustment),0) ) as total_qty ";

	$sql = "select 	(coalesce(($sqlvinvoice),0) - coalesce(($sqlsales),0) - coalesce(($sqlinternal),0) + coalesce(($sqladjustment),0) ) 
			as total_qty 
		from $tableproductlist pl, $tableproductcategory pd 
		where pl.product_id > 0 
		and pl.category_id = pd.category_id 
		and pl.product_id = $product_id 
		and pd.isitem = 'N' ";

	$query=$this->xoopsDB2->query($sql);
	$total_qty = 0;

	if($row=$this->xoopsDB2->fetchArray($query)){
		if($row['total_qty'] != "")
		$total_qty = $row['total_qty'];
	}

	return $total_qty;

	
	}

	function checkList($product_id,$product_list){
	$i = 0;
	$retval = true;
	foreach($product_list as $col){ 
	$i++;
	
	if($product_id == $product_list[$i])
	$retval = false;
	}
	
	return $retval;

	}

	function getTypeOfGroup($txt,$type){
	$val = $txt;
	$tableprefix= XOOPS_DB_PREFIX . "_";
	

	$sql = "SELECT b.accesstype FROM $tablegroups_users_link a,$tablegroups b
		WHERE a.groupid = b.groupid
		AND a.uid = $this->uid";
	
	$query=$this->xoopsDB2->query($sql);
	
	while($row=$this->xoopsDB2->fetchArray($query)){
	if($row['accesstype']!=$type)//if not department
	$val = "";
	}

	return $val;
	}


}

$tableprefix= XOOPS_DB_PREFIX . "_";
$tablevinvoice=$tableprefix . "simsalon_vinvoice";
$tablevinvoiceline=$tableprefix . "simsalon_vinvoiceline";
$tablesales=$tableprefix . "simsalon_sales";
$tablesalesline=$tableprefix . "simsalon_salesline";
$tablesalesemployeeline=$tableprefix . "simsalon_salesemployeeline";
$tableemployee=$tableprefix . "simsalon_employee";
$tableinternal=$tableprefix . "simsalon_internal";
$tableinternalline=$tableprefix . "simsalon_internalline";
$tableproductlist=$tableprefix . "simsalon_productlist";
$tableproductcategory=$tableprefix . "simsalon_productcategory";
$tableuom=$tableprefix . "simsalon_uom";



if ($_POST){

	
	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(8);
	$pdf->SetAutoPageBreak(true ,15);

	
	$pdf->uid = $xoopsUser->getVar('uid');
	$pdf->xoopsDB2 = $xoopsDB;
	$pdf->org_info = getOrganizationInfo($xoopsDB,$tableprefix);

	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$product_id=$_POST['product_id'];
	$category_id=$_POST['category_id'];
	if($product_id>0)
		$wherestring="AND a.product_id=$product_id";
	if($category_id>0)
		$wherestring=$wherestring." AND c.category_id=$category_id";
	
	/*
	$sqlvinvoice = 
	"SELECT sum(b.vinvoiceline_qty) as total_qty 
	from $tablevinvoice a, $tablevinvoiceline b 
	where a.vinvoice_id = b.vinvoice_id and a.iscomplete = 'Y' 
	and b.product_id = pl.product_id ";

	$sqlsales = 
	"SELECT sum(b.salesline_qty) as total_qty 
	from $tablesales a, $tablesalesline b 
	where a.sales_id = b.sales_id and a.iscomplete = 'Y' 
	and b.product_id = pl.product_id";

	$sqlinternal = 
	"SELECT sum(b.internalline_qty) as total_qty 
	from $tableinternal a, $tableinternalline b 
	where a.internal_id = b.internal_id and a.iscomplete = 'Y' 
	and a.internal_type = 'I' 
	and b.product_id = pl.product_id";

	$sqladjustment = 
	"SELECT sum(b.internalline_qty) as total_qty 
	from $tableinternal a, $tableinternalline b 
	where a.internal_id = b.internal_id and a.iscomplete = 'Y' 
	and a.internal_type = 'A' 
	and b.product_id = pl.product_id";


	

	$sql = "select 	pl.product_name as product_name,
			pl.product_no as product_no,
			pl.product_id as product_id,
			u.uom_description as uom,
			(coalesce(($sqlvinvoice),0) - coalesce(($sqlsales),0) - coalesce(($sqlinternal),0) + coalesce(($sqladjustment),0) ) 
			as total_qty 
		from $tableproductlist pl, $tableproductcategory pd, $tableuom u 
		where pl.product_id > 0 
		and pl.category_id = pd.category_id 
		and pd.isitem = 'N'  
		and pl.uom_id = u.uom_id 
		group by pl.product_id ";
	*/

	$sqlvinvoice	 = 	"select '0' as employee_id, b.product_id as product_id, b.vinvoiceline_qty as movement_qty, 
				a.vinvoice_date  as movement_date, 'Vendor' as type 
				from $tablevinvoice a, $tablevinvoiceline b 
				where a.vinvoice_date between '$start_date' and '$end_date' 
				and a.vinvoice_id = b.vinvoice_id  and a.iscomplete = 'Y' and a.isactive = 'Y' ";

	/*	
	$sqlsales	 = 	"select '0' as employee_id, b.product_id as product_id, b.salesline_qty as movement_qty, 
				a.sales_date  as movement_date, 'Sales' as type 
				from $tablesales a, $tablesalesline b 
				where a.sales_date between '$start_date' and '$end_date' 
				and a.sales_id = b.sales_id and a.iscomplete = 'Y' and a.isactive = 'Y' ";
	*/

	
	$sqlsales	 = 	"select (select employee_id from $tablesalesemployeeline where salesline_id = b.salesline_id limit 1) as employee_id, 
				b.product_id as product_id,sum(b.salesline_qty) as movement_qty, 
				a.sales_date  as movement_date, 'Sales' as type 
				from $tablesales a, $tablesalesline b 
				where a.sales_date between '$start_date' and '$end_date' 
				and a.sales_id = b.sales_id and a.iscomplete = 'Y' and a.isactive = 'Y' group by sales_date,employee_id,product_id ";
	


	$sqlinternal	 = 	"select b.employee_id as employee_id, b.product_id as product_id, b.internalline_qty as movement_qty, 
				a.internal_date  as movement_date, 'Internal Use' as type 
				from $tableinternal a, $tableinternalline b 
				where a.internal_date between '$start_date' and '$end_date' 
				and a.internal_id = b.internal_id and a.iscomplete = 'Y' and a.isactive = 'Y'  
				and a.internal_type = 'I' ";

	$sqladjustment	 = 	"select b.employee_id as employee_id, b.product_id as product_id, b.internalline_qty as movement_qty, 
				a.internal_date  as movement_date, 'Adjustment' as type 
				from $tableinternal a, $tableinternalline b 
				where a.internal_date between '$start_date' and '$end_date' 
				and a.internal_id = b.internal_id and a.iscomplete = 'Y' and a.isactive = 'Y'  
				and a.internal_type = 'A' ";

	
	$sql = "select * from (
		$sqlvinvoice
		union
		$sqlsales
		union
		$sqlinternal
		union
		$sqladjustment
		) a, $tableemployee b , $tableproductlist c , $tableproductcategory d , $tableuom e 
		where a.employee_id = b.employee_id 
		and a.product_id = c.product_id 
		and c.category_id = d.category_id 
		and d.isitem = 'N' $wherestring
		and c.uom_id = e.uom_id 
		order by a.movement_date, a.product_id ";

	

	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	
	//get data detail
	$product_list=array("");
	$j=0;
	$date1 = 0;
	$date2 = 0;
	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;
	$list = "N";
	$date1 = $row['movement_date'];	

	if($date1 != $date2){
	$product_list=array("");
	$date2 = $row['movement_date'];	
	$j = 0;
	}

	if($pdf->checkList($row['product_id'],$product_list)){
	$j++;
	$current_stock = $pdf->getCurrentStock($row['product_id'],$row['movement_date']);
	$product_list[$j] = $row['product_id'];
	$list = "Y";
	}else{
	//$j = 0;
	//$product_list=array();
	$current_stock = $balance;
	}


	if($row['type'] == "Internal Use" || $row['type'] == "Sales")
	$m_qty = $row['movement_qty']*(-1);
	else
	$m_qty = $row['movement_qty'];

	$balance = $current_stock + $m_qty;
	
	
	$movement_date = $row['movement_date'];
	$employee_name = $row['employee_name'];
	$typename = $row['type'];
	$product_name = $row['product_name'];
	$qty = $row['movement_qty'];
	$uom = $row['uom_description'];

	if($i == 1){
	$sqlstock = "";
	}
	
 	$data[]=array($i,$movement_date,$employee_name,$typename,$product_name,$current_stock,$qty,$uom,$balance);
 	
   	}
  	
	
   	$pdf->start_date = $start_date;
	$pdf->end_date = $end_date;

	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();

	$pdf->BasicTable($header,$data,1);
 
	//$pdf->MultiCell(175,7,$sqlsales,1,'C');
	//display pdf
	$pdf->Output();
	exit (1);


}
else {
	require(XOOPS_ROOT_PATH.'/header.php');
	echo "<td>Error during retrieving Invoice ID on viewinvoice.php(~line 206)," . 
		" please contact software developer kstan@simit.com.my</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');
}

?>


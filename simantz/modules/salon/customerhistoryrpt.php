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
  public $cur_symbol="";
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
	
	$this->Cell(0,4,"Customer History Report",0,1,'L');
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
	$this->Cell(195,10,"Customer History Report",0,1,'L');
	*/
		
	$i=0;

	$header =array("No","Customer","Date","Payment No","Item","Qty","Amount ($this->cur_symbol)");
	$w=array(10,40,20,23,45,30,23); // total width = 285

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
	
	$w=array(10,40,20,23,45,12,18,23); // total width = 285
	//$w=array(10,50,20,56,12,18,25); // total width = 285
	
    //Header
    
	$this->SetFont('Arial','',7);

	foreach($data as $row){ 
		$i=0;
		foreach($row as $col) {
			while($this->GetStringWidth($col)> $w[$i]-1)
				$col=substr_replace($col,"",-1);	
		if($i == 6)
		$total_amount += $col;
		
		$this->Cell($w[$i],6,$col,1,0,'C');
		
		$i=$i+1;
		}	
		$this->Ln();
		
	}

	$total_amount = number_format($total_amount, 2, '.','');

	$this->Cell(166,6,"Total ($this->cur_symbol) ",1,0,'R');
	$this->Cell(25,6,$total_amount,1,0,'C');

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
$tablecustomer=$tableprefix . "simsalon_customer";
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
	$customer_id = $_POST['customer_id'];

	$wherestr = "";

	if($customer_id > 0)
	$wherestr = " and a.customer_id = $customer_id ";

	if($start_date != "" && $end_date != "")
	$wherestr .= " and a.sales_date between '$start_date' and '$end_date' ";

	$sql = "select * 
		from $tablesales a, $tablesalesline b, $tablecustomer c, $tableproductlist d, $tableproductcategory e , $tableuom f 
		where a.sales_id = b.sales_id
		and a.customer_id = c.customer_id 
		and b.product_id = d.product_id 
		and d.category_id = e.category_id 
		and d.uom_id = f.uom_id 
		and a.iscomplete = 'Y' and a.isactive = 'Y' 
		and c.isactive = 'Y' 
		$wherestr ";
	
	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	
	//get data detail
	$i = 0;
	while ($row=$xoopsDB->fetchArray($query)){
	$i++;
	$customer_name = $row['customer_name'];
	$date = $row['sales_date'];
	$product_name = $row['product_name'];
	$qty = $row['salesline_qty'];
	$uom = $row['uom_description'];
	$amount = $row['salesline_amount'];
	$sales_no = $row['sales_no'];
	
 	$data[]=array($i,$customer_name,$date,$sales_no,$product_name,$qty,$uom,$amount);
 	
   	}
  	
	
   	$pdf->start_date = $start_date;
	$pdf->end_date = $end_date;
	$pdf->cur_symbol = $cur_symbol;
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();

	$pdf->BasicTable($header,$data,1);
 
	//$pdf->MultiCell(175,7,$sql,1,'C');
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


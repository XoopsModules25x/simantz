<?php
require('fpdf/fpdf.php');
include "chart/classes/libchart.php";
include_once "system.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  
  public $wherestr="Unknown";
  public $orderstr="Unknown";
  public $filter_type="";
  public $start_date="";
  public $end_date="";
  public $employee_id="";
  public $employee_name="";
  public $org_info="";

function Header()
{


	$timestamp= date("Y-m-d", time());
	$date = date("Y-m-d", time());
	$time = date("H:i:s", time());
	
	$this->SetFont('Times','',6);
	$this->SetXY(200,5);
	$this->Multicell(45,4,"$this->org_info",0,'L');


	$this->SetXY(80,5);
	$this->Image('./images/attlistlogo.jpg', 230 , 5 , 50 , '' , 'JPG' , '');
	$this->Ln(12);
	$this->SetFont('Arial','B',13);

	//-------------------------
	
	$this->Cell(0,4,"Sales Analysis Report (Chart)",0,1,'L');
	$this->SetFont('Arial','',6);
	$this->Cell(0,4,"Date : $date Time : $time  Page ".$this->PageNo()." / {nb} ",0,1,'R');
	//$this->Ln();
	$this->Cell(275,0,"",1,1,'L');
	$this->SetX(10);
	
	
	$this->SetFont('Arial','B',8); 
	$this->Cell(20,6,"Range Date",0,0,'L');
	$this->SetFont('Arial','',8); 
	$this->Cell(20,6,": ".$this->start_date." - ".$this->end_date,0,1,'L');

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

	function calculateCommissionType($total,$type){
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$tablecommission=$tableprefix . "simsalon_commission";

	$totalamount = 0;
	// get commission percent
	$sql = "select (commission_percent/100*$total) as total from $tablecommission a 
	where ($total between a.commission_amount and a.commission_amountmax) 
	and a.commission_type = '$type' ";//compare with commission table
	
	$query=$this->xoopsDB2->query($sql);
	if($row=$this->xoopsDB2->fetchArray($query)){
	$totalamount = $row['total'];
	
	if($totalamount=="")
	$totalamount = 0;
	
	}
	
	$totalamount = number_format($totalamount, 2, '.','');
			
	return	$totalamount;
	}

	function generateChart(){
	
	

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
	
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$category_id = $_POST['category_id'];

	/*
	$yearofstart = substr($start_date,0,4);
	$yearofend = substr($end_date,0,4);
	$monthofstart = substr($start_date,5,2);
	$monthofend = substr($end_date,5,2);*/
	
	$pdf=new PDF('L','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(8);
	$pdf->SetAutoPageBreak(true ,15);

	
	$pdf->start_date = $start_date;
	$pdf->end_date = $end_date;
	$pdf->cur_symbol = $cur_symbol;
	
	$pdf->uid = $xoopsUser->getVar('uid');
	$pdf->xoopsDB2 = $xoopsDB;
	$pdf->org_info = getOrganizationInfo($xoopsDB,$tableprefix);
	$wherestr = "";

	if($category_id > 0)
	$wherestr = " and d.category_id = $category_id ";

	if($start_date != "" && $end_date != "")
	$wherestr .= " and a.sales_date between '$start_date' and '$end_date' ";

	$sql = "select *,sum(b.salesline_amount) as tot_amount 
		from $tablesales a, $tablesalesline b, $tablecustomer c, $tableproductlist d, $tableproductcategory e , $tableuom f 
		where a.sales_id = b.sales_id
		and a.customer_id = c.customer_id 
		and b.product_id = d.product_id 
		and d.category_id = e.category_id 
		and d.uom_id = f.uom_id 
		and a.iscomplete = 'Y' and a.isactive = 'Y' 
		$wherestr 
		group by d.category_id 
		order by a.sales_date";

	

	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	//get data detail

	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;
	$category_description = $row['category_description'];
	$tot_amount = $row['tot_amount'];
	
	$tot_amount = number_format($tot_amount, 2, '.','');

	$data[]=array($category_description,$tot_amount);
	
   	}
  
	// generate chart

	

	$chart = new VerticalBarChart();
	$dataSet = new XYDataSet();

	$widthchart = 0;
	foreach($data as $row){ 
	$i = 0;
		foreach($row as $col) {
	
		}	
	$dataSet->addPoint(new Point($row[0], $row[1]));
	$widthchart = $widthchart + 20;
	$i++;
	}

	
	if($widthchart > 275)
	$widthchart = 275;
	else if($widthchart < 150)
	$widthchart = 150;
	
	

	$timestamp= date("YmdHis", time()) ;
	$chart->setDataSet($dataSet);
	$chart->setTitle("Sales Analysis Report Group By Category ($pdf->cur_symbol)");
	$chart->render("chart/chartimage/".$timestamp.".png"); 

	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();

	$pdf->SetXY(10,20);
	$pdf->Image("chart/chartimage/".$timestamp.".png", 10 , 45 , $widthchart , '' , 'PNG' , '');
	//$pdf->BasicTable($header,$data,1);
 
	//$pdf->MultiCell(175,7,$sql,1,'C');
	//display pdf
	$pdf->Output();
	unlink("chart/chartimage/".$timestamp.".png");
	exit (1);


}
else {
	require(XOOPS_ROOT_PATH.'/header.php');
	echo "<td>Error during retrieving Invoice ID on viewinvoice.php(~line 206)," . 
		" please contact software developer kstan@simit.com.my</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');
}

?>

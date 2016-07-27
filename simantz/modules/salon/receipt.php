<?php
require('fpdf/fpdf.php');
include_once "system.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  
  public $wherestr="Unknown";
  public $orderstr="Unknown";
  public $dataType=0;
  public $customer_name="";
  public $sales_no="";
  public $sales_date="";
  public $sales_totalamount="0.00";
  public $cur_symbol="";
  public $prepared_name;
  public $org_info;

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
	
	$this->Cell(0,4,"Receipt Payment",0,1,'L');
	$this->SetFont('Arial','',6);
	$this->Cell(0,4,"Date : $date Time : $time  Page ".$this->PageNo()." / {nb} ",0,1,'R');
	//$this->Ln();
	$this->Cell(191,0,"",1,1,'L');
	$this->SetX(90);
	
	$this->Ln(4);
	
	/*
	$this->Image('./images/attlistlogo.jpg', 115 , 10 , 60 , '' , 'JPG' , '');
	$this->Ln();
	$this->SetFont('Times','BU',10);

	//-------------------------
	$this->SetXY(60,5);
	$this->Cell(0,17,"Receipt Payment",0,0,'L');
	$this->SetX(90);
	
	$this->Ln(18);
	*/		
	$i=0;


	$this->SetDrawColor(0,0,0);
	
	$this->SetFont('Arial','B',9); 
	$this->Cell(30,4,"Payment No",0,0,'L','B');
	$this->Cell(5,4,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(50,4,$this->sales_no,0,1,'L');
	
	$this->SetFont('Arial','B',9); 
	$this->Cell(30,4,"Customer",0,0,'L','B');
	$this->Cell(5,4,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(50,4,$this->customer_name,0,1,'L');
	
	$this->SetFont('Arial','B',9); 
	$this->Cell(30,4,"Date",0,0,'L');
	$this->Cell(5,4,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(50,4,$this->sales_date,0,1,'L');

	$this->SetFont('Arial','B',9); 
	$this->Cell(30,4,"Total Amount ($this->cur_symbol)",0,0,'L');
	$this->Cell(5,4,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(50,4,$this->sales_totalamount,0,1,'L');

	$this->Ln(); 	
	
	$this->SetFont('Arial','B',9);

	$header =array("No","Item Description","Qty","Price ($this->cur_symbol)","Discount ($this->cur_symbol)","Amount ($this->cur_symbol)");
	$w=array(10,70,30,25,25,30); // total width = 285
	
	foreach($header as $col) {
	
	if ($i==1)
	$this->Cell($w[$i],5,$col,1,0,'L');
	else
	$this->Cell($w[$i],5,$col,1,0,'C');
	
	$i=$i+1;
	}	
	$this->Ln();
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());

	
	
	//Position at 1.5 cm from bottom
	$this->SetY(-34);
	//Arial italic 8
	//signature
	//$this->Ln();
	$this->SetFont('Arial','',8);
	$this->Cell(50,5,"Received By",0,0,'L');
	$this->Cell(15,5,"",0,0,'L');
	$this->Cell(50,5,"Prepared By",0,1,'L');
	$this->Cell(50,12,"",0,0,'L');
	$this->Cell(15,5,"",0,0,'L');
	$this->Cell(50,12,"",0,1,'L');
	$this->Cell(50,0,"",1,0,'L');
	$this->Cell(15,0,"",0,0,'L');
	$this->Cell(50,0,"",1,1,'L');
	$this->Cell(50,5,$this->customer_name,0,0,'L');
	$this->Cell(15,5,"",0,0,'L');
	$this->Cell(50,5,$this->prepared_name,0,1,'L');
}

function BasicTable($header,$data,$printheader)
{

	//$this->SetDrawColor(210,210,210);
	//Column widths
	$i=0;
	
	$w=array(10,70,13,17,25,25,30); // total width = 285
	
	
    	//Header
    
	$this->SetFont('Arial','',9);

	foreach($data as $row)
	{ $i=0;
		foreach($row as $col) {
		
			while($this->GetStringWidth($col)> $w[$i]-1)
				$col=substr_replace($col,"",-1);	
		
		if ($i==1 || $i==3)
		$this->Cell($w[$i],5,$col,0,0,'L');
		else if ($i==2 || $i==6)
		$this->Cell($w[$i],5,$col,0,0,'R');
		else
		$this->Cell($w[$i],5,$col,0,0,'C');
		
		$i=$i+1;
		}	
		$this->Ln();
		
	}
	$this->height_tbl = $this->y -55;
	
}

	function getTypeOfGroup($txt,$type){
	$val = $txt;
	$tableprefix= XOOPS_DB_PREFIX . "_";
	

	$tablegroups_users_link=$tableprefix . "groups_users_link";
	$tablegroups=$tableprefix . "groups";

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

	function getNameUser($id){
	$val = "";
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$tableusers=$tableprefix . "users";
	
	$sql = "select * from $tableusers where uid = $id ";

	$query=$this->xoopsDB2->query($sql);
	
	if($row=$this->xoopsDB2->fetchArray($query)){
	$val = $row['uname'];

	}

	return $val;
	
	
	}


}

$tableprefix= XOOPS_DB_PREFIX . "_";
$tablesales=$tableprefix . "simsalon_sales";
$tablesalesline=$tableprefix . "simsalon_salesline";
$tablecustomer=$tableprefix . "simsalon_customer";
$tableemployee=$tableprefix . "simsalon_employee";
$tableproductlist=$tableprefix . "simsalon_productlist";
$tableproductcategory=$tableprefix . "simsalon_productcategory";
$tableuom=$tableprefix . "simsalon_uom";


if (true){

	if (isset($_POST['sales_id'])){
		$sales_id=$_POST["sales_id"];

	}else if(isset($_GET['sales_id'])){
		$sales_id=$_GET["sales_id"];
	
	}else{
		$sales_id = "";
	}
	
	$pdf=new PDF('L','mm','A5'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(8);
	$pdf->SetAutoPageBreak(true ,35);

	
	$pdf->uid = $xoopsUser->getVar('uid');
	$pdf->xoopsDB2 = $xoopsDB;
	$pdf->cur_symbol = $cur_symbol;
	$sales_paidamount = "0.00";
	$pdf->prepared_name = $pdf->getNameUser($pdf->uid);
	$pdf->org_info = getOrganizationInfo($xoopsDB,$tableprefix);

	$sql = "select * from $tablesales a, $tablesalesline b, $tablecustomer c, $tableproductlist d, $tableproductcategory e, $tableuom f
		where a.sales_id = b.sales_id and a.customer_id = c.customer_id 
		and b.product_id = d.product_id and d.category_id = e.category_id 
		and d.uom_id = f.uom_id 
		and a.sales_id = $sales_id ";


	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){
	$i++;
	$discount_amt = "0.00";
	$pdf->sales_no = $row['sales_no'];
	$pdf->customer_name = $row['customer_name'];
	$pdf->sales_date = $row['sales_date'];
	$pdf->sales_totalamount = $row['sales_totalamount'];
	$sales_paidamount = $row['sales_paidamount'];
	$product_name = $row['product_name'];
	$uom = $row['uom_description'];
	$salesline_qty = $row['salesline_qty'];
	$salesline_price = $row['salesline_price'];
	$salesline_oprice = $row['salesline_oprice'];
	$salesline_amount = $row['salesline_amount'];

	if($salesline_oprice > $salesline_price)
	$discount_amt = $salesline_oprice - $salesline_price;

	$discount_amt = number_format($discount_amt, 2, '.','');
	
	$data[]=array($i."-",$product_name,$salesline_qty,$uom,$salesline_price,$discount_amt,$salesline_amount);
		
   	}
  	
	
   	

	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();

	$pdf->BasicTable($header,$data,1);

	//footer
	$pdf->Ln();
	//$pdf->Cell(160,5,"",0,0,'R');
	$pdf->Cell(190,0,"",1,1,'C');
	$pdf->Cell(160,5,"Total",0,0,'R');
	$pdf->Cell(30,5,$pdf->sales_totalamount,0,1,'R');
	$pdf->Cell(160,5,"(-) Paid",0,0,'R');
	$pdf->Cell(30,5,$sales_paidamount,0,1,'R');
	$pdf->Cell(160,5,"",0,0,'R');
	$pdf->Cell(30,0,"",1,1,'C');
 	$pdf->Cell(160,5,"Change",0,0,'R');
	$pdf->Cell(30,5,number_format(($sales_paidamount - $pdf->sales_totalamount), 2, '.',''),0,1,'R');
	$pdf->Cell(160,5,"",0,0,'R');
	$pdf->Cell(30,0,"",1,1,'C');



	//$pdf->MultiCell(175,7,$org_info,1,'C');
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


<?php
require('fpdf/fpdf.php');
include_once "system.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  
  public $wherestr="Unknown";
  public $orderstr="Unknown";
  public $dataType=0;
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
	
	$this->Cell(0,4,"On Hand Stock Report",0,1,'L');
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
	$this->Cell(195,10,"On Hand Stock Report",0,1,'L');
	*/
		
	$i=0;

	$header =array("No","Code","Product","Safety Qty","Qty","Actual Qty","Variance","Remarks");
	$w=array(10,18,53,17,28,20,15,30); // total width = 285

	$this->SetDrawColor(0,0,0);

	$this->SetFont('Arial','B',9); 

	$this->SetFont('Arial','B',9); 
	$this->Cell(25,7,"Date",0,0,'L');
	$this->Cell(5,7,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(50,7,$timestamp,0,1,'L');
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
	
	$w=array(10,18,53,17,18,10,20,15,30); // total width = 285

	//$w=array(10,20,55,18,10,28,15,35); // total width = 285
	
    //Header
    
	$this->SetFont('Arial','',7);
	$j = 0;
	foreach($data as $row){ 
		$i = 0;
		foreach($row as $col) {
		$k = 0;
		$this->SetTextColor(0,0,0);
		
			while($this->GetStringWidth($col)> $w[$i]-1)
				$col=substr_replace($col,"",-1);	
		
		if($i == 3){
			if($col > $data[$j][$i+1])
			$this->SetTextColor(255,0,0);
		}
		
		
		$this->Cell($w[$i],6,$col,1,0,'C');
		
		
		$i++;
		$k++;
		}	
		$this->Ln();
	$j++;
	}
	$this->height_tbl = $this->y -55;
	
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
$tableinternal=$tableprefix . "simsalon_internal";
$tableinternalline=$tableprefix . "simsalon_internalline";
$tableproductlist=$tableprefix . "simsalon_productlist";
$tableproductcategory=$tableprefix . "simsalon_productcategory";
$tableuom=$tableprefix . "simsalon_uom";



if ($_POST){

	$product_id = $_POST['product_id'];
	$category_id = $_POST['category_id'];
	$product_no = $_POST['product_no'];
	
	$wherestr =  "";
	if($product_id > 0)
	$wherestr .= " and pl.product_id = $product_id ";
	if($category_id > 0)
	$wherestr .= " and pl.category_id = $category_id ";

	if($product_no != "")
	$wherestr .= " and pl.product_no like '$product_no' ";
	
	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(8);
	$pdf->SetAutoPageBreak(true ,15);

	
	$pdf->uid = $xoopsUser->getVar('uid');
	$pdf->xoopsDB2 = $xoopsDB;
	$pdf->org_info = getOrganizationInfo($xoopsDB,$tableprefix);
	
	$sqlvinvoice = 
	"SELECT sum(b.vinvoiceline_qty) as total_qty 
	from $tablevinvoice a, $tablevinvoiceline b 
	where a.vinvoice_id = b.vinvoice_id and a.iscomplete = 'Y' and a.isactive = 'Y' 
	and b.product_id = pl.product_id";

	$sqlsales = 
	"SELECT sum(b.salesline_qty) as total_qty 
	from $tablesales a, $tablesalesline b 
	where a.sales_id = b.sales_id and a.iscomplete = 'Y' and a.isactive = 'Y' 
	and b.product_id = pl.product_id";

	$sqlinternal = 
	"SELECT sum(b.internalline_qty) as total_qty 
	from $tableinternal a, $tableinternalline b 
	where a.internal_id = b.internal_id and a.iscomplete = 'Y' and a.isactive = 'Y'  
	and a.internal_type = 'I' 
	and b.product_id = pl.product_id";

	$sqladjustment = 
	"SELECT sum(b.internalline_qty) as total_qty 
	from $tableinternal a, $tableinternalline b 
	where a.internal_id = b.internal_id and a.iscomplete = 'Y' and a.isactive = 'Y'  
	and a.internal_type = 'A' 
	and b.product_id = pl.product_id";


	

	$sql = "select 	pl.product_name as product_name,
			pl.product_no as product_no,
			pl.product_id as product_id,
			u.uom_description as uom,
			pl.safety_level as safety_level,
			(coalesce(($sqlvinvoice),0) - coalesce(($sqlsales),0) - coalesce(($sqlinternal),0) - coalesce(($sqladjustment),0) ) 
			as total_qty 
		from $tableproductlist pl, $tableproductcategory pd, $tableuom u 
		where pl.product_id > 0 
		and pl.category_id = pd.category_id 
		and pd.isitem = 'N'  
		and pl.uom_id = u.uom_id 
		$wherestr 
		group by pl.product_id ";

	

	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	//get data detail

	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;
  	
 	$data[]=array($i,$row['product_no'],$row['product_name'],$row['safety_level'],$row['total_qty'],$row['uom'],"","","");
 	
   	}
  	
	
   	

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


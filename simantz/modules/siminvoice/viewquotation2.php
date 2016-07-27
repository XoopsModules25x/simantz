<?php
require('fpdf/fpdf.php');
include_once "system.php";



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  
  public $wherestr="Unknown";
  public $orderstr="Unknown";
  
  
  
function Header($cust_desc="",$txtStatement="",$headerP=0)
{
  /*  $this->Image('./images/attlistlogo.jpg', 10 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Arial','B',18);
    $this->Cell(0,17,"Attendance Sheet",1,0,'R');
    $this->Ln(20);
    $this->SetFont('Arial','B',12);
    $this->Cell(26,8,"Class Code",1,0,'L');
    $this->Cell(80,8,$this->tuitionclass_code,1,0,'C');
    $this->Cell(26,8,"Month",1,0,'C');
    $this->Cell(58,8,$this->period_name,1,0,'C');
*/
    $this->Image('./images/attlistlogo.jpg', 15 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Times','B',30);
//-------------------------
  //  $this->SetXY(15,10);
   // $this->Cell(175,17,"$this->period_name",1,0,'R');
    //$this->SetX(90);
    
    //$this->Cell(110,17,"$this->tuitionclass_code",1,0,'R');
	 //$this->SetXY(95,10);
//----------------

	$this->SetXY(15,10);
	$this->Cell(175,17,"",1,0,'L');
	//$this->SetX(10);
	
	/*
    	$this->SetFont('Times','',10);
	
	if($this->PageNo()==1){
	
	}else{
	$this->SetXY(67,4);
	}*/
	$this->SetXY(67,4);
    
    	$this->Ln(10);
	
	$this->Ln();
	/*
	
	if($cust_desc!=""){
	$this->SetFont('Arial','',7);
	
	foreach($cust_desc as $col_data)
	{	
		foreach($col_data as $col) {
		$i=0;
		$this->Cell(175,6,$col,0,0,'L');
		$this->Ln();
		}
	}
	
	$this->Ln();
	
	}
	*/
	if($this->PageNo()==1)
	$this->Ln(33);

	
	$i=0;
	
	$header=array('Item Description','Qty', 'Unit Price (RM)','Amount (RM)');
        $w=array(100,15,30,30); //6 data
	
	if($headerP==0){
   	foreach($header as $col){
	$this->SetFont('Arial','B',9); 
       	$this->Cell($w[$i],7,$col,1,0,'C');
	$i=$i+1;		
	}	
	$this->Ln();
	}
	
	/*
	if($this->AcceptPageBreak()){
	//$this->y = 200;
	$this->Cell(175,0,"",1,0,'L');
	}
	*/
	
	}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());
    //Position at 1.5 cm from bottom
    $this->SetY(-50);
    //Arial italic 8
    $this->SetFont('courier','I',8);
    //Page number
    //$this->Cell(0,5,"For Administration Use",LTR,0,'L');
	//$this->Ln();
    //$this->Cell(0,25,"",LBR,0,'L');
	$this->Ln();
    $this->Cell(0,10,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

 
function HeaderAddress($cust_desc="",$txtStatement="")
{
 	$this->SetXY(15,10);
	$this->Cell(175,17,"",1,0,'L');
	
	$this->SetXY(67,4);
    
    	$this->Ln(10);
	
	$this->Ln();
	
	
	
	if($cust_desc!=""){
	$this->SetFont('Arial','',7);
	
	foreach($cust_desc as $col_data)
	{	
		foreach($col_data as $col) {
		$i=0;
		$this->Cell(175,4,$col,0,0,'L');
		$this->Ln();
		}
	}
	
	$this->Ln();
	
	$this->SetFont('Arial','B',9); 
	$this->Cell(175,6,"QUOTATION",0,0,'C');
	}
	
	$this->Ln();
	$this->Ln(10);
	
	}
	
function BasicTable($header,$data,$printheader)
{
//Column widths
    
    
    $w=array(100,15,30,30); //9 data
    $i=0;
  

    //Data
   $this->SetFont('Arial','',9);
 
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {
	if ($i==4 || $i==2 || $i==3)
		
		/*
		if ($i!=1){
		while($this->GetStringWidth($col)> $w[$i])
			$col=substr_replace($col,"",-1);
		}*/
		
		$height = $this->GetStringWidth($col) / $w[1];
		
		if ($i==0){
		$this->SetFont('Arial','',7);
		
		$tot_height = $this->MultiCell2($w[$i],4,$col,1,'L',0,"count");
		
		//if($this->initH > 1)
		//if($this->y+$this->initH>$this->PageBreakTrigger)
		//if($tot_height==16)
		
		if($this->y+$tot_height>$this->PageBreakTrigger && !$this->InFooter && $this->AcceptPageBreak())
		$this->AddPage($this->CurOrientation);
		
		$this->MultiCell($w[$i],4,$col,1,'L');
		//$this->Cell($w[$i],6,$this->totHeight." - ".$tot_height,1,0,'C');
		}else{
		$this->SetFont('Arial','',8);
		
		$this->Cell($w[$i],$this->totHeight,$col,1,0,'C');
		}
	     
	
            $i=$i+1;
            }
        $this->Ln();
    }

}
}


  
$tableprefix= XOOPS_DB_PREFIX . "_";
$tablecustomer=$tableprefix . "tblcustomer";
$tablequotation=$tableprefix . "tblquotation";
$tablequotationline=$tableprefix . "tblquotationline";
$tableterms=$tableprefix . "tblterms";

//if (isset($_POST['submit'])){
if ($_POST){
	
	$quotation_id=$_POST['quotation_id'];
	$wherestr=str_replace("\'","'",$quotation_id);
	//$wherestr=str_replace(substr($wherestr, 0, 2),"",$wherestr);
	
	
	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(15);
	$pdf->SetAutoPageBreak(true ,40);

	$sql = "SELECT  b.quotation_id as quotation_id,
			b.quotation_seq as quotation_seq,
			b.item_name as item_name,
			b.quotation_desc as description,
			b.quotation_qty as qty,
			b.quotation_unitprice as unitprice,
			b.quotation_discount as discount,
			b.quotation_amount as amount,
			a.quotation_totalamount as totalamount,
			a.customer_id as customer_id,
			a.quotation_preparedby as quotation_preparedby
			FROM $tablequotation a, $tablequotationline b
			WHERE b.quotation_id = $quotation_id 
			AND a.quotation_id = b.quotation_id 
			ORDER BY b.quotation_seq";
	
		
		

	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	//get data detail
	$tot_amount = 0;
	$cust_id = 0;
	$item_desc = "";
	$quotation_preparedby = "";
	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;
	$cust_id = $row['customer_id'];
	$tot_amount += $row['amount'];
	
	$item_desc = "Item : ".$row['item_name']."\n"."Description : ".$row['description']."\n"."Discount : ".$row['discount']."%"."\n ";
	
	$data[]=array($item_desc,$row['qty'],$row['unitprice'],$row['amount']);
	
	$quotation_preparedby = $row['quotation_preparedby'];
  	}
   	
	
	/*
	while ($i<'10'){
	$i=$i+1;
   	$data[]=array('','','','');
	}
	
	
	if ($i>'5'){
		while ($i<'10'){
		$i=$i+1;
		$data[]=array('','','','');
		}
	}
	*/
   
   	// get cust info
   	$sql2 = "select * from $tablecustomer where customer_id = $cust_id ";
  
	$query=$xoopsDB->query($sql2);
	$cust_desc = "";
	if ($row=$xoopsDB->fetchArray($query)){
	
		$cust_desc[] = array($row['customer_name'],$row['customer_street1'],$row['customer_street2'],"Tel No. : ".$row['customer_tel1'],"Fax No. :".$row['customer_fax']);
	
	}
	
	// get Attn
   	$sql2 = "select * from $tablequotation where customer_id = $cust_id ";
  
	$query=$xoopsDB->query($sql2);
	$attn_desc = "";
	if ($row=$xoopsDB->fetchArray($query)){
		$attn_desc[] = array($row['quotation_attn'],"Tel No : ".$row['quotation_attntel'].", Tel Hp : ".$row['quotation_attntelhp'].", Fax No : ".$row['quotation_attnfax']);
	
	}
	
	// get PIC
	$sql2 = "select * from $tablecustomer where customer_id = $cust_id ";
  
	$query=$xoopsDB->query($sql2);
	$pic_desc = "";
	$received_by = "";
	if ($row=$xoopsDB->fetchArray($query)){
	//$pic_desc[] = array($row['customer_contactperson'],$row['customer_contactno'],$row['customer_contactnohp'],$row['customer_contactfax']);
	$received_by = $row['customer_contactperson'];
	}
	
	
	
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	
	// print attn
	
	
	if($attn_desc!=""){
	$pdf->SetFont('Arial','',6);
	$pdf->SetXY(15,55);
	foreach($attn_desc as $col_data)
	{	
		foreach($col_data as $col) {
		$i=0;
		$pdf->Cell(175,4,$col,0,0,'L');
		$pdf->Ln();
		}
	}
	
	}
	//
	
	$pdf->HeaderAddress($cust_desc);
	
	$pdf->BasicTable($header,$data,1);
	
	if($pdf->y+6>$pdf->PageBreakTrigger && !$pdf->InFooter && $pdf->AcceptPageBreak()){
	$pdf->AddPage($pdf->CurOrientation);
	}
	
	$pdf->MultiCell(145,6,"Total Amount",1,'R');
	$pdf->MultiCell(30,6,$tot_amount = number_format($tot_amount, 2, '.',''),1,'C');
	
	
	
	// print siganature
	if($pdf->y+27>$pdf->PageBreakTrigger && !$pdf->InFooter && $pdf->AcceptPageBreak())
	$pdf->AddPage($pdf->CurOrientation,1);
	
	// height = 27
	$pdf->SetXY(15,220);
	$pdf->Cell(100,6,"Issued By :",0,0,'L');
	$pdf->Cell(75,6,"Recieved By :",0,0,'L');
	$pdf->SetXY(15,240);
	$pdf->Cell(70,0,"",1,0,'L');
	$pdf->SetXY(115,240);
	$pdf->Cell(70,0,"",1,0,'L');
	$pdf->SetXY(15,241);
	$pdf->Cell(100,6,$quotation_preparedby,0,0,'L');
	$pdf->Cell(75,6,$received_by,0,0,'L');
	
	//$pdf->ln();
 	//$pdf->MultiCell(35,7,"asdadadasd\nsdadddd4545\naaadsas",1,'C');
	//$pdf->MultiCell(35,7,"aaa",1,'C');
	//$pdf->MultiCell(35,7,$pdf->totHeight,1,'C');
	
	
	//display pdf
	$pdf->Output();
	exit (1);

}
else {
	require(XOOPS_ROOT_PATH.'/header.php');
	echo "<td>Error during retrieving Invoice ID on viewquotation.php(~line 206)," . 
		" please contact software developer kstan@simit.com.my</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');
}
?>


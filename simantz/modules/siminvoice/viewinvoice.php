<?php
require('fpdf/fpdf.php');
include_once "system.php";



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  
  public $wherestr="Unknown";
  public $orderstr="Unknown";
  public $cust_desc ="";
  public $attn_desc ="";
  public $invoice_preparedby="";
  public $received_by="";
  public $tot_amount = "";
  public $last_page = 0;
  public $invoice_remarks = "";
  public $invoice_terms = "";
  public $invoice_no = "";
  
  
  
function Header($txtStatement="",$headerP=0)
{
 
    $this->Image('./images/attlistlogo.jpg', 73 , 10 , 65 , '' , 'JPG' , 'invoice.php?action=edit&invoice_id='.$this->invoice_id);
    $this->Ln();
    $this->SetFont('Times','B',30);


	$this->SetXY(15,10);
	$this->Cell(185,17,"",0,0,'L');
	//$this->SetX(10);
	
	
	// prrint fix table
	$this->SetXY(15,72);
	$this->Cell(185,160,"",1,0,'L');
	//end of fix table
	
	// print address
	$this->SetXY(15,10);
	$this->Ln(30);
	$this->SetFont('Arial','',8);
	
	foreach($this->cust_desc as $col_data)
	{	
		$ij = 0;
		foreach($col_data as $col) {
		$i=0;
		$this->SetFont('Arial','',8);
		$this->Cell(145,4,$col,0,0,'L');

		if($ij==0){
		$this->SetFont('Arial','B',8);
		$this->Cell(40,4,"INVOICE",0,0,'L');
		}else{
		$this->SetFont('Arial','',8);
		}
		if($ij==1)
		$this->Cell(40,4,"No.     : ".$this->invoice_no,0,0,'L');
		if($ij==2)
		$this->Cell(40,4,"Date   : ".date("d/m/Y", time()),0,0,'L');
		if($ij==3)
		$this->Cell(40,4,"Terms : ".$this->invoice_terms,0,0,'L');
		if($ij==4)
		$this->Cell(40,4,"Page   : ".$this->PageNo(),0,0,'L');
		
		$this->Ln();
		$ij++;
		}
		//$ij++;
	}
	
	//$this->SetXY(125,10);
	//$this->Cell(65,4,"aa",1,0,'L');

	// end of print address
	
	
	// print attn
	
	
	$this->SetFont('Arial','',7);
	$this->Ln();
	foreach($this->attn_desc as $col_data)
	{	
		foreach($col_data as $col) {
		$i=0;
		$this->Cell(185,4,$col,0,0,'L');
		$this->Ln();
		}
	}
	
	//end of print attn	
	
	
   //$this->Ln();
	
	$i=0;
	
	$header=array('No','Item Description','Qty', 'U.Price (RM)','Discount (RM)','Amount (RM)');
   	$w=array(10,75,30,25,20,25); //6 data
	
	if($headerP==0){
	$this->SetXY(15,72);
   	foreach($header as $col){
	$this->SetFont('Arial','B',8); 
       	$this->Cell($w[$i],7,$col,1,0,'C');
	$i=$i+1;		
	}	
	$this->Ln();
	}
	
	
	// height = 27 --> print issue n prepared by
	$this->SetFont('Arial','',9);
	$this->SetXY(15,250);
	$this->Cell(100,6,"Issued By :",0,0,'L');
	$this->Cell(85,6,"Recieved By :",0,0,'L');
	$this->SetXY(15,269);
	$this->Cell(70,0,"",1,0,'L');
	$this->SetXY(115,269);
	$this->Cell(70,0,"",1,0,'L');
	$this->SetXY(15,270);
	$this->Cell(100,6,$this->invoice_preparedby,0,0,'L');
	$this->Cell(85,6,$this->received_by,0,0,'L');
	
	
	//print amount & remarks
	/*
	if($this->last_page == 1){
	
	$this->SetXY(15,67+135);
	$this->MultiCell(145,6,"Total Amount",1,'R');
	$this->MultiCell(30,6,$this->tot_amount = number_format($this->tot_amount, 2, '.',''),1,'C');
	//$this->SetXY(15,67+135+1);
	$this->Ln();
	$this->MultiCell(145,6,$this->invoice_remarks,0,'L');
	
	
	}
	
	*/
	//	
	
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
    $this->SetY(-30);
    //Arial italic 8
    $this->SetFont('courier','I',8);
    //Page number
    //$this->Cell(0,5,"For Administration Use",LTR,0,'L');
	//$this->Ln();
    //$this->Cell(0,25,"",LBR,0,'L');
	 $this->Ln();
    $this->Cell(0,10,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

 
	
function BasicTable($header,$data,$printheader)
{
//Column widths
    
    
    $w=array(10,75,15,15,25,20,25); //9 data
    $i=0;
  	
  	 $this->SetXY(15,79);
	  $this->max_y = 79;
    //Data
   $this->SetFont('Times','',9);
 
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {
		//if ($i==4 || $i==2 || $i==3)
		if ($i==4 || $i==5 || $i==6||$i==2)
		$align = "R";
		elseif($i==1||$i==3)
		$align = "L";
		else
		$align = "C";
		
		$height = $this->GetStringWidth($col) / $w[1];
		
		if ($i==1){
		$this->SetFont('Times','',9);
		
		$tot_height = $this->MultiCell2($w[$i],4,$col,1,'L',0,"count") + 45;
		
		$this->y = $this->max_y;
		$this->MultiCell($w[$i],4,$col,0,$align);
		$this->max_y = $this->y + $this->totHeight;
		
		}else{
		$this->SetFont('Times','',9);
//		$this->Cell($w[$i],$this->totHeight,$col,1,0,'C');
		if($i==0)
		$this->y = $this->max_y;
		
		if($this->y+$tot_height>$this->PageBreakTrigger && !$this->InFooter && $this->AcceptPageBreak()){
		$this->AddPage($this->CurOrientation);
		$this->SetXY(15,79);
		$this->MultiCell($w[$i],4,$col,0,$align);
		$this->max_y = $this->y; 
		}else{
		$this->MultiCell($w[$i],4,$col,0,$align);
		}
		
		}
	     
	
            $i=$i+1;
            }
        $this->Ln();
        $this->last_page = 1;
    }
    
	

}
    
}


  
$tableprefix= XOOPS_DB_PREFIX . "_";
$tablecustomer=$tableprefix . "tblcustomer";
$tableinvoice=$tableprefix . "tblinvoice";
$tableinvoiceline=$tableprefix . "tblinvoiceline";
$tableterms=$tableprefix . "tblterms";

//if (isset($_POST['submit'])){
if ($_POST){
	
	$invoice_id=$_POST['invoice_id'];
	$wherestr=str_replace("\'","'",$invoice_id);
	//$wherestr=str_replace(substr($wherestr, 0, 2),"",$wherestr);
	
	
	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(15);
	$pdf->SetAutoPageBreak(true ,20);

	$sql = "SELECT  b.invoice_id as invoice_id,
			b.invoice_seq as invoice_seq,
			b.item_name as item_name,
			b.invoice_desc as description,
			b.invoice_qty as qty,
			b.item_uom as item_uom,
			b.invoice_unitprice as unitprice,
			b.invoice_discount as discount,
			b.invoice_amount as amount,
			a.invoice_totalamount as totalamount,
			a.customer_id as customer_id,
			a.invoice_preparedby as invoice_preparedby,
			a.invoice_remarks as remarks,
			a.invoice_no as invoice_no,
			a.iscomplete as iscomplete,
			a.invoice_terms as terms2,
			c.terms_desc as terms
			FROM $tableinvoice a, $tableinvoiceline b, $tableterms c
			WHERE b.invoice_id = $invoice_id 
			AND a.invoice_id = b.invoice_id
			AND a.terms_id = c.terms_id  
			ORDER BY b.invoice_seq";
	
		
		

	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	//get data detail
	$tot_amount = 0;
	$cust_id = 0;
	$item_desc = "";
	$invoice_preparedby = "";
	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;
	$cust_id = $row['customer_id'];
	$tot_amount += $row['amount'];
	
	$line_d = "";
	if($row['description']!="")
	$line_d = "\n";
	
	$line_in = "";
	if($row['item_name']=="")
	$line_in = "\n";
	
	if($row['item_name']==""&&$row['description']!=""){
	$line_in = "";
	$line_d = "";
	}
	
	
	$item_desc = $line_in.$row['item_name'].$line_d.$row['description']."\n\n";
	
	$data[]=array($i,$item_desc,$row['qty'],$row['item_uom'],$row['unitprice'],number_format($row['discount']/100*$row['unitprice'], 2, '.',''),$row['amount']);
	
	$invoice_preparedby = $row['invoice_preparedby'];
	$invoice_remarks = $row['remarks'];
	$invoice_no = $row['invoice_no'];
	$invoice_terms = $row['terms2'];
  	}
   	
   	$pdf->invoice_id = $invoice_id;
	$pdf->invoice_preparedby = $invoice_preparedby;
	$pdf->invoice_remarks = $invoice_remarks;
	$pdf->invoice_no = $invoice_no;
	$pdf->invoice_terms = $invoice_terms;
	$pdf->iscomplete = $iscomplete;
	
	$pdf->tot_amount = $tot_amount;
	
   
	// get cust info
   	$sql2 = "select * from $tablecustomer where customer_id = $cust_id ";
  
	$query=$xoopsDB->query($sql2);
	$cust_desc = "";
	if ($row=$xoopsDB->fetchArray($query)){
	
		$cust_desc[] = array($row['customer_name'],$row['customer_street1']." ".$row['customer_street2'],$row['customer_postcode']." ".$row['customer_city'].$row['customer_state'].$row['customer_country'],"Tel No. : ".$row['customer_tel1'],"Fax No. :".$row['customer_contactfax']);
	
	}
	
	$pdf->cust_desc = $cust_desc;
	
	// get Attn
	$sql2 = "select * from $tableinvoice where customer_id = $cust_id ";
  
	$query=$xoopsDB->query($sql2);
	$attn_desc = "";
	if ($row=$xoopsDB->fetchArray($query)){
		if($row['invoice_attntel']!="")
		$tel_no = "Tel No : ".$row['invoice_attntel'];
		else
		$tel_no = "";

		$attn_desc[] = array($row['invoice_attn'],$tel_no." Hp No: ".$row['invoice_attntelhp']);
	
	}
	
	$pdf->attn_desc = $attn_desc;
	
	// get PIC
	$sql2 = "select * from $tablecustomer where customer_id = $cust_id ";
  
	$query=$xoopsDB->query($sql2);
	$pic_desc = "";
	$received_by = "";
	if ($row=$xoopsDB->fetchArray($query)){
	//$pic_desc[] = array($row['customer_contactperson'],$row['customer_contactno'],$row['customer_contactnohp'],$row['customer_contactfax']);
	$received_by = $row['customer_contactperson'];
	}
	
	$pdf->received_by = $received_by;
	
	
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	
	//$pdf->HeaderAddress($cust_desc);	

	
	
	$pdf->BasicTable($header,$data,1);
	
	$pdf->SetXY(15,67+160+5);
	$pdf->MultiCell(160,6,"Total Amount",1,'R');
	$pdf->MultiCell(25,6,$pdf->tot_amount = number_format($pdf->tot_amount, 2, '.',''),1,'R');
	//$this->SetXY(15,67+135+1);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->MultiCell(150,6,$pdf->invoice_remarks,0,'L');
	
	/*
	
	if($pdf->y+6>$pdf->PageBreakTrigger && !$pdf->InFooter && $pdf->AcceptPageBreak()){
	$pdf->AddPage($pdf->CurOrientation);
	}
	
	$pdf->SetXY(15,55);
	$pdf->MultiCell(145,6,"Total Amount",1,'R');
	$pdf->MultiCell(30,6,$tot_amount = number_format($tot_amount, 2, '.',''),1,'C');
	*/
	
	
	
	// print siganature
	//if($pdf->y+27>$pdf->PageBreakTrigger && !$pdf->InFooter && $pdf->AcceptPageBreak())
	//$pdf->AddPage($pdf->CurOrientation);
	
	
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
	echo "<td>Error during retrieving Invoice ID on viewinvoice.php(~line 206)," . 
		" please contact software developer kstan@simit.com.my</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');
}
?>


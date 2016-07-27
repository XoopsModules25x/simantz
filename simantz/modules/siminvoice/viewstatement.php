<?php
require('fpdf/fpdf.php');
include_once "system.php";



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  
  public $wherestr="Unknown";
  public $orderstr="Unknown";
  public $cust_desc="";
  public $txtStatement="";
  public $term_cust = "";
  
  
  
function Header()
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
    $this->Image('./images/attlistlogo.jpg', 73 , 10 , 65 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Times','B',30);
//-------------------------
    $this->SetXY(15,10);
    $this->Cell(185,17,"$this->period_name",0,0,'R');
    $this->SetX(90);
    
    //$this->Cell(110,17,"$this->tuitionclass_code",1,0,'R');
	 //$this->SetXY(95,10);
//----------------

   $this->SetFont('Times','',10);
	
	if($this->PageNo()==1){
	$this->SetXY(67,4);
	}else{
	$this->SetXY(67,4);
	}
    
   
   $this->Ln(13);
	
	
	
	$this->SetFont('Arial','',8);
	$this->Ln(20);
	foreach($this->cust_desc as $col_data)
	{	
		$ij=0;
		foreach($col_data as $col) {
		$this->SetFont('Arial','',8);
		$i=0;
		$this->Cell(140,6,$col,0,0,'L');
		
		if($ij==0){
		$this->SetFont('Arial','B',8);
		$this->Cell(35,6,"ACCOUNT STATEMENT",0,0,'L');
		}
		
		if($ij==1){
		$this->SetFont('Arial','',8);
		$this->Cell(35,6,"Page : ".$this->PageNo()."/{nb}",0,0,'L');
		}
		
		if($ij==2){
		$this->SetFont('Arial','',8);
		$this->Cell(35,6,"Terms : ".$this->term_cust,0,0,'L');
		}
		
		$this->Ln();
		$ij++;
		}
	}
	
	$this->Ln();
	
	
	
	$i=0;
	
	$header=array('Date','Due Date', 'Reference No', 'Description','Debit (RM)','Credit (RM)','Balance (RM)');
   $w=array(25,25,30,45,20,20,20); //6 data
	
	$this->SetFont('Arial','',8);
   $this->Cell(185,6,$this->txtStatement,0,0,'L');
	$this->Ln();
   foreach($header as $col){
	$this->SetFont('Arial','B',9); 
       	$this->Cell($w[$i],7,$col,1,0,'C');
	$i=$i+1;		
	}	
	$this->Ln();
	
	
	
	$this->SetFont('Arial','',7);
	$this->SetXY(15,250);
   $this->Cell(185,4,"WE SHALL BE GRATEFUL IF YOU WILL LET US HAVE PAYMENT AS SOON AS POSSIBLE.",0,1,'L');
   $this->Cell(185,4,"ANY DISCREPANCY IN THIS STATEMENT PLEASE INFORM US IN WRITING WITHIN 7 DAYS",0,0,'L');
	
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
	 $this->Ln();
	 $this->Ln();
    $this->Cell(0,10,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

function BasicTable($header,$data,$printheader)
{
//Column widths
    
    //$w=array(6,14,49,39,16,6,6,6,6,6,6,25); //12 data
    $w=array(25,25,30,45,20,20,20); //9 data
	$i=0;
    //Header

    //Data
   $this->SetFont('Arial','',9);
 	$this->SetXY(15,86);
   foreach($data as $row){ $i=0;
    	foreach($row as $col) {
			if ($i==3 || $i==1 || $i==2)
				while($this->GetStringWidth($col)> $w[$i])
				$col=substr_replace($col,"",-1);	

				if ($i==4 || $i==5 || $i==6)
	     			$this->Cell($w[$i],6,$col,0,0,'R');
				else
	     			$this->Cell($w[$i],6,$col,0,0,'C');	

            $i=$i+1;
            }
        $this->Ln();
    }

$this->Ln();
$this->Ln();
$this->Ln();
}

}


  
$tableprefix= XOOPS_DB_PREFIX . "_";
$tablecustomer=$tableprefix . "tblcustomer";
$tableinvoice=$tableprefix . "tblinvoice";
$tableterms=$tableprefix . "tblterms";
$tablepaymentline=$tableprefix . "tblpaymentline";
$tablepayment=$tableprefix . "tblpayment";

//if (isset($_POST['submit'])){
if ($_POST){
	
	
	$start_date = $_POST['start_date'];
	
	/*
	if($_POST['start_date']!="")
		$txtStatement="Date Range: ".$_POST['start_date']." to ".$_POST['end_date'];
	else
		$txtStatement="";
		*/
		
	$pdf->txtStatement="Date Range: ".$_POST['start_date']." to ".$_POST['end_date'];
		
	
	$wherestr=$_POST['wherestr'];
	$wherestr=str_replace("\'","'",$_POST['wherestr']);
	//$wherestr=str_replace(substr($wherestr, 0, 2),"",$wherestr);
	
	
	$orderstr=str_replace('\\','',$_POST["orderstr"]);
	
	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(15);
	$pdf->SetAutoPageBreak(true ,30);

	$customer_id=$_POST['customer_id'];

	$sql="SELECT SUM(t.AMOUNT) as balance FROM (
		SELECT SUM(invoice_totalamount) as amount FROM $tableinvoice 
			WHERE customer_id=$customer_id AND invoice_date< '$start_date' AND iscomplete='1'
		UNION ALL
		SELECT -1*sum(paymentline_amount) as amount FROM $tablepaymentline a 
			inner join $tablepayment b on a.payment_id = b.payment_id
			WHERE customer_id=$customer_id AND payment_date< '$start_date' 
		) as t";
	$bfamount=0;
	$querybf=$xoopsDB->query($sql);
	if($row=$xoopsDB->fetchArray($querybf))
		$bfamount=$row['balance'];

	$balancedr=0;
	$balancecr=0;

	if($bfamount > 0){
		$balancedr=$bfamount;
		$balancecr=0;
	}
	else{
		$balancedr=0;
		$balancecr=$bfamount * -1;
	}


	$sql2 = "SELECT $customer_id as customer_id,0 as invoice_id,0 as terms_id,'' as invoice_no,''  as date,'' as due_date,'Balance B/F' as type,$balancedr as amountdebit,$balancecr as amountcredit,'' as iscomplete Union ALL

		SELECT * FROM
		(
			
			SELECT
			a.customer_id as customer_id,
			a.invoice_id as invoice_id,
			a.terms_id as terms_id,
			a.invoice_no as invoice_no,
			a.invoice_date as date,
			ADDDATE(a.invoice_date, INTERVAL b.terms_days DAY) as due_date,
			'Sales' as type,
			invoice_totalamount as amountdebit ,0 as amountcredit,
			a.iscomplete as complete
			FROM $tableinvoice a, $tableterms b 
			WHERE a.iscomplete = 1
			AND a.terms_id = b.terms_id

			UNION ALL

			
			
			SELECT 
			b.customer_id as customer_id,
			a.invoice_id as invoice_id,
			'' as terms_id,
			c.invoice_no as invoice_no,
			b.payment_date as date,
			'' as due_date,
			'Payment' as type,0 as amountdebit,
			paymentline_amount as amountcredit ,
			'' as complete
			FROM $tablepaymentline a, $tablepayment b, $tableinvoice c
			WHERE a.payment_id = b.payment_id
			AND a.invoice_id = c.invoice_id

			) a 
			$wherestr 
			ORDER BY date ASC ";
			

	$query=$xoopsDB->query($sql2);
	$i=0;
	$data=array();
	//get data detail
	$tot_amount = 0;
	$cust_id = 0;
	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;
	$cust_id = $row['customer_id'];
	/*
	if($row['type']=="payment"){
	$row['amount'] = $row['amount'];
	$credit = $row['amount'];
	$row['amount'] = "-".$row['amount'];
	$debit = "";
	}else{
	$debit = $row['amount'];
	$credit = "";
	}
	*/
	$debit=$row['amountdebit'];
	$credit=$row['amountcredit'];

	$tot_amount += $debit-$credit;
	if ($debit==0)
		$debit="";
	if($credit==0)
		$credit="";
	
	$data[]=array($row['date'],$row['due_date'],$row['invoice_no'],$row['type'],$debit,$credit,number_format($tot_amount, 2, '.',''));
   
  	}
   	
	while ($i<'23'){
	$i=$i+1;
   	$data[]=array('','','','','','','');
   }
   
	if ($i>'23'){
	
	while ($i<'46'){
	$i=$i+1;
   	$data[]=array('','','','','','','');
   }
   }
   
   	// get cust info
   $sql = "select * from $tablecustomer a, $tableterms b where customer_id = $cust_id and a.terms_id = b.terms_id ";
  
	$query=$xoopsDB->query($sql);
	$cust_desc = "";
	if ($row=$xoopsDB->fetchArray($query)){
	
		$cust_desc[] = array($row['customer_name'],$row['customer_street1']." ".$row['customer_street2'],$row['customer_postcode']." ".$row['customer_city'].$row['customer_state'].$row['customer_country'],"Tel No. : ".$row['customer_tel1'],"Fax No. : ".$row['customer_contactfax']);
		
		$pdf->term_cust = $row['terms_desc'];
	
	}
	
	
	$pdf->cust_desc = $cust_desc;
	$pdf->txtStatement="Date Range: ".$_POST['start_date']." to ".$_POST['end_date'];
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	
	//$pdf->Header($txtStatement);
	
	
	
	$pdf->BasicTable($header,$data,1);
	$pdf->Cell(165,6,"Total Balance (RM)",1,0,'R');
	$pdf->Cell(20,6,$tot_amount = number_format($tot_amount, 2, '.',''),1,0,'C');
	//$pdf->ln();
	//$pdf->SetXY(10,40);
 	//$pdf->MultiCell(185,4,$sql,1,'C');
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


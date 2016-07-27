<?php
include_once('../../class/fpdf/fpdf.php');
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

	$this->SetXY(8,25);

	$this->Image('./images/logo.jpg', 100 , 5 , 90 , '' , 'JPG' , '');
	//$this->Ln(15);
	$this->SetFont('Arial','BU',13);

	//-------------------------
	
	$this->Cell(0,4,"Business Partner List",0,1,'L');
	
	/*
	$this->SetFont('Arial','',6);
	$this->Cell(0,4,"Date : $date Time : $time  Page ".$this->PageNo()." / {nb} ",0,1,'R');
	//$this->Ln();
	$this->Cell(191,0,"",1,1,'L');
	$this->SetX(90);*/
	
	$this->Ln();
	
	/*
	$timestamp= date("Y-m-d", time());
	$this->Image('./images/attlistlogo.jpg', 145 , 5 , 50 , '' , 'JPG' , '');
	$this->Ln();
	$this->SetFont('Times','BU',14);

	//-------------------------
	$this->SetXY(7,10);
	$this->Cell(195,10,"Stock Movement Summary Report",0,1,'L');
	*/
		
	/*
	


	$this->SetDrawColor(0,0,0);

	$this->SetFont('Arial','B',9); 

	$this->SetFont('Arial','B',9); 
	$this->Cell(20,7,"Package",0,0,'L');
	$this->Cell(5,7,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(100,7,$this->package_title,0,0,'L');

	$this->SetFont('Arial','B',9); 
	$this->Cell(20,7,"Bus No",0,0,'L');
	$this->Cell(5,7,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(40,7,$this->bus_no,0,1,'L');

	$this->SetFont('Arial','B',9); 
	$this->Cell(20,7,"Date",0,0,'L');
	$this->Cell(5,7,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(100,7,$this->startdatetime." - ".$this->enddatetime ,0,0,'L');

	$this->SetFont('Arial','B',9); 
	$this->Cell(20,7,"Price",0,0,'L');
	$this->Cell(5,7,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(40,7,$this->standardprice,0,1,'L');
	*/
	/*
	$this->SetFont('Arial','B',9); 
	$this->Cell(20,7,"Date",0,0,'L');
	$this->Cell(5,7,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(40,7,$timestamp,0,1,'L');
	*/

	$header =array("No","Name","Credit Limit","Group","Terms","City","Tel 1","Contact Person 1","Email","Website");
	$w=array(10,50,20,30,30,25,20,30,30,35); // total width = 285
	$i=0;
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
	
	
	$w=array(10,50,20,30,30,25,20,30,30,35); // total width = 285
	
    //Header
    
	$this->SetFont('Arial','',7);

	foreach($data as $row){ 
		$i=0;
		foreach($row as $col) {
			while($this->GetStringWidth($col)> $w[$i]-1)
				$col=substr_replace($col,"",-1);	
	
		if($i>1)
		$this->Cell($w[$i],6,$col,1,0,'C');
		else
		$this->Cell($w[$i],6,$col,1,0,'L');	
		
		
		$i=$i+1;
		}	
		$this->Ln();
		
	}
	//$this->height_tbl = $this->y -55;
	
}
	


}



if ($_POST || $_GET){

	
	$pdf=new PDF('L','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(8);
	$pdf->SetAutoPageBreak(true ,20);

	
	$pdf->uid = $xoopsUser->getVar('uid');

	if(isset($_POST['bpartner_array'])){
	$bpartner_array=$_POST['bpartner_array'];
	$checkbox_array=$_POST['checkbox_array'];
	$reporttype=$_POST['reporttype'];
	}
	
	if(isset($_GET['bpartner_array']) )  {
	$bpartner_array=$_GET['bpartner_array'];
	$checkbox_array=$_GET['checkbox_array'];
	$reporttype=$_GET['reporttype'];
	}

	$data=array();
	
	$i=0;
	$j=0;
	foreach($bpartner_array as $bpartner_id){
	
	if($checkbox_array[$i] == "on"){
	$j++;
	$sql=	"SELECT 
		a.bpartner_name,
		a.bpartner_id,
		a.isactive,
		a.organization_id,
		a.defaultlevel,
		a.bpartnergroup_id ,
		a.creditlimit,
		b.terms_name,
		a.bpartner_city,
		a.bpartner_tel_1,
		a.contactperson1,
		a.bpartner_email1,
		a.bpartner_url,
		c.bpartnergroup_name 
		FROM $tablebpartner a, $tableterms b, $tablebpartnergroup c
	 	where a.bpartner_id = $bpartner_id 
		and a.terms_id = b.terms_id 
		and a.bpartnergroup_id = c.bpartnergroup_id ";
	

	$query=$xoopsDB->query($sql);
	
	if ($row=$xoopsDB->fetchArray($query)){

	$bpartner_id=$row['bpartner_id'];
	$bpartner_name=$row['bpartner_name'];
	
	$creditlimit=$row['creditlimit'];
	$terms_name=$row['terms_name'];
	$bpartner_city=$row['bpartner_city'];
	$bpartner_tel_1=$row['bpartner_tel_1'];
	$contactperson1=$row['contactperson1'];
	$bpartner_email1=$row['bpartner_email1'];
	$bpartner_url=$row['bpartner_url'];
	$bpartnergroup_name=$row['bpartnergroup_name'];

//	$k=0;
//	while($k < 10){
//	$k++;
 	$data[]=array($j,$bpartner_name,$creditlimit,$bpartnergroup_name,$terms_name,$bpartner_city,$bpartner_tel_1,$contactperson1,$bpartner_email1,$bpartner_url);
//	}
 		
   	}

	}

	$i++;
	}
 
//	if($i > 0)
//	$data[]=array("","","","","","","Total",number_format($all_total,2));

	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();

	$pdf->BasicTable($header,$data,1);
 
	//$pdf->MultiCell(175,7,$checkbox_array[2],1,'C');
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


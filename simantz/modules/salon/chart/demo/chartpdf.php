<?php
require('../../fpdf/fpdf.php');
include "../classes/libchart.php";




error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  
  public $wherestr="Unknown";
  public $orderstr="Unknown";
  

function Header()
{


	
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());
    //Position at 1.5 cm from bottom
    $this->SetY(-20);
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


}
}


if (true){
  
	
	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(15);
	$pdf->SetAutoPageBreak(true ,20);

		
	header("Content-type: image/png");

	$chart = new PieChart(500, 300);

	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();

	//function Image($file,$x,$y,$w=0,$h=0,$type='',$link='')
	
	$dataSet = new XYDataSet();
	$dataSet->addPoint(new Point("Bleu d'Auvergne", 50));
	$dataSet->addPoint(new Point("Tomme de Savoie", 75));
	$dataSet->addPoint(new Point("Crottin de Chavignol", 30));
	$chart->setDataSet($dataSet);

	$chart->setTitle("Preferred Cheese");
	$chart->render();
 
	//$pdf->MultiCell(175,7,$i,1,'C');
	//display pdf
	$pdf->Output();
	exit (1);

}

?>


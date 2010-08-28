<?php
include_once('../simantz/class/fpdf/fpdf.php');
include_once "system.php";
	$header=array("No","A/C No","A/C Name","A/C Group","Debit","Credit");
   	$w=array(15,20,75,30,25,25);


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  public $headeraccounts_code="Unknown";
  public $headeraccounts_name="Unknown";
  public $ledgertitlefontname="Times";
  public $ledgertitlefontsize="9";
  public $ledgertitleheight="5";
  public $ledgertitlecolwidth="80";


  public $tableheaderfont="Arial";
  public $tableheaderfontsize="8";
  public $tableheaderfontstyle="B";
  public $tableheaderheight="5";
  public $tableheadertype="TB"; //0=no border,1 = with bolder, T=top,B=bottom,L=left,R=right

  public $tabletextfont="Times";
  public $tabletextfontsize="8";
  public $tabletextfontstyle="";
  public $tabletextheight="4";

  public $date="Unknown";
//  public $dateto="Unknown";
  public $marginx=10;
  public $marginy=10;
//  public $pageheaderheight=50;
  public $pagefooterheight=15;

  public $headertitlex=80;
//  public $headertitley=10;
  public $headertitlewitdth=75;
  public $headertitleheight=14;
  public $headerrectwith=190;
  public $headerrectheight=16;
  public $datelabelwidth=20;
  public $datetextwidth=25;
  public $datelabelheight=8;
  public $headerseparator=2;
  public $imagepath="./images/logo.jpg";
  public $imagetype="JPG";
  public $imagewidth=60;

function Header()
{	global $header,$w;
	$this->Image($this->imagepath, $this->marginx ,$this->marginx , $this->imagewidth , '' , $this->imagetype , '');
	$this->Ln();
	$this->SetFont('Times','B',20);
	$this->Rect($this->marginx,$this->marginy,$this->headerrectwith,$this->headerrectheight);
	$this->SetXY($this->headertitlex,$this->marginy);
	$this->Cell($this->headertitlewitdth,$this->headertitleheight,"Account Balance Report",0,0,'L');
	$this->SetFont('Times','B',10);
//	$this->SetXY($this->headertitlex,$this->headertitley);
//	$this->Ln(20);

//	$this->SetFont('Times','',10);   

	$this->SetFont('Times','',10);
	$this->Cell($this->datelabelwidth,$this->datelabelheight,"Printed Date",1,0,'C');
	$this->SetFont('Times','B',10);
	$this->Cell($this->datetextwidth,$this->datelabelheight,"$this->date",1,0,'C');
	//$this->SetFont('Times','',10);
	//$this->SetXY($this->headertitlex+$this->headertitlewitdth,$this->marginy+$this->datelabelheight);
	//$this->Cell($this->datelabelwidth,$this->datelabelheight,"Date To",1,0,'C');
	//$this->SetFont('Times','B',10);
	//$this->Cell($this->datetextwidth,$this->datelabelheight,"$this->dateto" ,1,0,'C');
	$this->SetXY($this->marginx,$this->marginy+$this->headerseparator+$this->headerrectheight);
	$i=0;

	//$this->Ln();


foreach($header as $col)
     	{
	$this->SetFont($this->tableheaderfont,$this->tableheaderfontstyle,$this->tableheaderfontsize); 
	
	if($i >= 0)
   	 $this->Cell($w[$i],$this->tableheaderheight,$col,$this->tableheadertype,0,'L');
	$i=$i+1;		
	}	
    $this->Ln();
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());
    //Position at 1.5 cm from bottom
    $this->SetY($this->pagefooterheight * -1);
    //Arial italic 8
    $this->SetFont('courier','I',8);
	
    $this->Cell(0,5,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

}

if (isset($_POST["submit"])){

$wherestr="";



	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true ,$pdf->pagefooterheight +1 );

//	$pdf->datefrom=$_POST['datefrom'];
//	$pdf->dateto=$_POST['dateto'];
//	$pdf->accounts_codefrom=getAccountsID($_POST['accounts_codefrom']);
//	$pdf->accounts_codeto=getAccountsID($_POST['accounts_codeto']);

	/*if($pdf->datefrom=="")
		$pdf->datefrom="0000-00-00";
	if($pdf->dateto=="")
		$pdf->dateto="9999-12-31";*/
	$pdf->date=date("Y-m-d",time());

	$pdf->AddPage();

	if($pdf->accounts_codefrom=="")
	$pdf->accounts_codefrom="0000000";
	if($pdf->accounts_codeto=="")
		$pdf->accounts_codeto="9999999";


	$wherestr=" ( a.accountcode_full LIKE '$pdf->accounts_codeto%' OR
				a.accountcode_full between '$pdf->accounts_codefrom%' AND '$pdf->accounts_codeto%' )
			and a.accounts_id>0 AND a.organization_id=$defaultorganization_id and a.placeholder=0";
	
	//if($pdf->bpartner_id > 0)
	//$wherestr .= " and t.bpartner_id = $pdf->bpartner_id ";

	$pdf->SetFont('Arial','',10);

	$sql="SELECT a.accounts_id, a.accountcode_full,a.accounts_name,g.accountgroup_name,a.lastbalance 
		FROM $tableaccounts a 
		INNER JOIN $tableaccountgroup g on a.accountgroup_id=g.accountgroup_id 
		WHERE $wherestr
		order by a.accountcode_full,a.accounts_name,g.accountgroup_name";


	$query=$xoopsDB->query($sql);
	$totaldebit = 0;
	$totalcredit =0;

	while($row=$xoopsDB->fetchArray($query)){
		$i++;
		$accountcode_full=$row['accountcode_full'];
		$accounts_id=$row['accounts_id'];
		$accounts_name=$row['accounts_name'];
		$accountgroup_name=$row['accountgroup_name'];
		$lastbalance=$row['lastbalance'];
		if($lastbalance>=0){
			$debitamt=$lastbalance;
			$creditamt=0;
			$totaldebit=$totaldebit+$debitamt;
			$creditamt=number_format($creditamt,2);
		}
		else{
			$debitamt=0;
			$creditamt=$lastbalance* -1;
			$totalcredit=$totalcredit+$creditamt;
			$debitamt=number_format($debitamt,2);
		}
		//$pdf->AddPage();
		$pdf->SetX($pdf->marginx);
		$pdf->SetFont("$pdf->tabletextfont",$pdf->tabletextfontstyle,$pdf->tabletextfontsize);
		$pdf->Cell($w[0],$pdf->tabletextheight,$i,0,0,'L');
		$pdf->Cell($w[1],$pdf->tabletextheight,$accountcode_full,0,0,'L');
		$pdf->Cell($w[2],$pdf->tabletextheight,"$accounts_name",0,0,'L');
		$pdf->Cell($w[3],$pdf->tabletextheight,$accountgroup_name,0,0,'L');
		$pdf->Cell($w[4],$pdf->tabletextheight,$debitamt,0,0,'R');
		$pdf->Cell($w[5],$pdf->tabletextheight,$creditamt,0,0,'R');


//		$log->showLog(5,"$accountcode_full");
		$pdf->Ln();

	}
		$pdf->SetX($pdf->marginx);
		$pdf->Cell($w[0],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[1],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[2],$pdf->tabletextheight,"Total :","TB",0,'L');
		$pdf->Cell($w[3],$pdf->tabletextheight,"","TB",0,'L');
		$pdf->Cell($w[4],$pdf->tabletextheight,number_format($totaldebit,2),"TB",0,'R');
		$pdf->Cell($w[5],$pdf->tabletextheight,number_format($totalcredit,2),"TB",0,'R');
	//$pdf->AddPage();
	//$pdf->BasicTable($data);
	//	$pdf->Ln();
	//	$pdf->SetX($pdf->marginx);
	//$pdf->MultiCell(0,5,$sql,1,'C');
	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output("trialbalancesummary.pdf","I");
	//exit (1);

}

?>


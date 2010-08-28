<?php
include_once('../simantz/class/fpdf/fpdf.php');
include_once "system.php";
	$header=array("No","B/P No","Business Partner Name","Group Name","Debit","Credit");
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
  public $reportname="Unknown";

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

  public $headertitlex=78;
//  public $headertitley=10;
  public $headertitlewitdth=77;
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
	$this->Cell($this->headertitlewitdth,$this->headertitleheight,$this->reportname,0,0,'L');
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

	$bpartner_from=$_POST['bpartner_from'];
	$bpartner_to=$_POST['bpartner_to'];
	$reporttype=$_POST['reporttype'];

	if($reporttype==2)
	$pdf->reportname="Debtor Balance Report";
	else
	$pdf->reportname="Creditor Balance Report";

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


	$wherestr=" ( bp.bpartner_no LIKE '$bpartner_to%' OR
				bp.bpartner_no between '$bpartner_from%' AND '$bpartner_to%' )
			and bp.bpartner_id>0 AND bp.organization_id=$defaultorganization_id and a.placeholder=0 and a.account_type=$reporttype";
	
	//if($pdf->bpartner_id > 0)
	//$wherestr .= " and t.bpartner_id = $pdf->bpartner_id ";

	$pdf->SetFont('Arial','',10);

	$sql="SELECT bp.bpartner_id, bp.bpartner_no,bp.bpartner_name,g.bpartnergroup_name,bp.currentbalance 
		FROM $tableaccounts a 
		INNER JOIN $tablebpartner bp on bp.accounts_id=a.accounts_id
		INNER JOIN $tablebpartnergroup g on bp.bpartnergroup_id=g.bpartnergroup_id 
		WHERE $wherestr
		order by bp.bpartner_no,bp.bpartner_name,g.bpartnergroup_name";


	$query=$xoopsDB->query($sql);
	$totaldebit = 0;
	$totalcredit =0;

	while($row=$xoopsDB->fetchArray($query)){
		$i++;
		$bpartner_no=$row['bpartner_no'];
		$bpartner_id=$row['bpartner_id'];
		$bpartner_name=$row['bpartner_name'];
		$bpartnergroup_name=$row['bpartnergroup_name'];
		$currentbalance=$row['currentbalance'];
		if($currentbalance>=0){
			$debitamt=$currentbalance;
			$creditamt=0;
			$totaldebit=$totaldebit+$debitamt;
			$creditamt=number_format($creditamt,2);
		}
		else{
			$debitamt=0;
			$creditamt=$currentbalance* -1;
			$totalcredit=$totalcredit+$creditamt;
			$debitamt=number_format($debitamt,2);
		}
		//$pdf->AddPage();
		$pdf->SetX($pdf->marginx);
		$pdf->SetFont("$pdf->tabletextfont",$pdf->tabletextfontstyle,$pdf->tabletextfontsize);
		$pdf->Cell($w[0],$pdf->tabletextheight,$i,0,0,'L');
		$pdf->Cell($w[1],$pdf->tabletextheight,$bpartner_no,0,0,'L');
		$pdf->Cell($w[2],$pdf->tabletextheight,"$bpartner_name",0,0,'L');
		$pdf->Cell($w[3],$pdf->tabletextheight,$bpartnergroup_name,0,0,'L');
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


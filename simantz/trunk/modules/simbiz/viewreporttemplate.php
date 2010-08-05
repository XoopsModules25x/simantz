<?php
include_once('../simantz/class/fpdf/fpdf.php');
include_once "system.php";



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


  public $datefrom="Unknown";
  public $dateto="Unknown";
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
{
	$this->Image($this->imagepath, $this->marginx ,$this->marginx , $this->imagewidth , '' , $this->imagetype , '');
	$this->Ln();
	$this->SetFont('Times','B',20);
	$this->Rect($this->marginx,$this->marginy,$this->headerrectwith,$this->headerrectheight);
	$this->SetXY($this->headertitlex,$this->marginy);
	$this->Cell($this->headertitlewitdth,$this->headertitleheight,"General Leedger",0,0,'L');
	$this->SetFont('Times','B',10);
//	$this->SetXY($this->headertitlex,$this->headertitley);
//	$this->Ln(20);

//	$this->SetFont('Times','',10);   

	$this->SetFont('Times','',10);
	$this->Cell($this->datelabelwidth,$this->datelabelheight,"Date From",1,0,'C');
	$this->SetFont('Times','B',10);
	$this->Cell($this->datetextwidth,$this->datelabelheight,"$this->datefrom",1,0,'C');
	$this->SetFont('Times','',10);
	$this->SetXY($this->headertitlex+$this->headertitlewitdth,$this->marginy+$this->datelabelheight);
	$this->Cell($this->datelabelwidth,$this->datelabelheight,"Date To",1,0,'C');
	$this->SetFont('Times','B',10);
	$this->Cell($this->datetextwidth,$this->datelabelheight,"$this->dateto" ,1,0,'C');
	$this->SetXY($this->marginx,$this->marginy+$this->headerseparator+$this->headerrectheight);
	$i=0;

	$this->SetFont($this->ledgertitlefontname,'B',$this->ledgertitlefontsize);
	$this->Cell($this->ledgertitlecolwidth,$this->ledgertitleheight,
		"Account No: $this->headeraccounts_code $this->headeraccounts_name",0,0,'L');
	$this->Ln();
	$header=array("No","Date","Batch","Doc No","Account Name","Debit","Credit","Balance");
   	$w=array(10,20,20,20,70,20,20,20);

foreach($header as $col)
     	{
	$this->SetFont($this->tableheaderfont,$this->tableheaderfontstyle,$this->tableheaderfontsize); 
	
	if($i > 0)
    $this->Cell($w[$i],$this->tableheaderheight,$col,$this->tableheadertype,0,'C');
	$i=$i+1;		
	}	
    $this->Ln(10);
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
/*	$pdf->datefrom=$_POST['period_from'];
	$pdf->dateto=$_POST['period_to'];
	$pdf->accounts_codefrom=getAccountsID($_POST['accounts_codefrom']);
	$pdf->accounts_codeto=getAccountsID($_POST['accounts_codeto']);

	
	$pdf->datefrom = str_replace("-", "", getPeriodDate($pdf->datefrom));
	$pdf->dateto = str_replace("-", "", getPeriodDate($pdf->dateto));
	
	
	if($pdf->datefrom != "")
	$pdf->datefrom = 	getMonth($pdf->datefrom."01",0);
	if($pdf->dateto != "")
	$pdf->dateto = 	getMonth($pdf->dateto."01",1);
	
	if($pdf->datefrom=="")
		$pdf->datefrom="0000-00-00";
	if($pdf->dateto=="")
		$pdf->dateto="9999-12-31";

	$whereacc = "";
	if($pdf->accounts_codefrom != "")
	$whereacc = " AND (a.accountcode_full between '$pdf->accounts_codefrom' AND '$pdf->accounts_codefrom') ";
	*/
	/*
	if($pdf->accounts_codefrom=="")
	$pdf->accounts_codefrom="0000000";
	if($pdf->accounts_codeto=="")
		$pdf->accounts_codeto="9999999";
	*/

	
/*
	$wherestr=" ((b.batchdate between '$pdf->datefrom' AND '$pdf->dateto') or b.batchdate = '0000-00-00' ) 
		$whereacc 
		and b.batch_id>0 and a.accounts_id>0 and b.iscomplete=1  
		and t.amt <> 0 and b.organization_id=$defaultorganization_id and a.treelevel > 1 ";
	
	$innerjoinbpartner = "";

	if($pdf->bpartner_id == "")
	$pdf->bpartner_id = 0;


	if($pdf->bpartner_id > 0){
	$wherestr .= " and t.bpartner_id = $pdf->bpartner_id ";
	//$innerjoinbpartner = " INNER JOIN $tablebpartner p on p.bpartner_id=t.bpartner_id ";
	}
	

	$pdf->SetFont('Arial','',10);
	

	$sql="SELECT * FROM $tablebatch b 
		INNER JOIN $tabletransaction t on b.batch_id=t.batch_id 
		INNER JOIN $tableaccounts a on a.accounts_id=t.accounts_id 
		INNER JOIN $tableaccountgroup g on a.accountgroup_id=g.accountgroup_id 
		INNER JOIN $tablebpartner p on p.bpartner_id=t.bpartner_id 
		WHERE $wherestr 
		order by a.accountcode_full,b.batchdate,b.batchno,t.seqno,t.reference_id desc  ";

	$query=$xoopsDB->query($sql);
	$data=array();
	$i=0;
	$j=0;
	$totaldebit=0;
	$totalcredit=0;
	$totaldebitline=0;
	$totalcreditline=0;
	$balanceamt=0;
	$acc_id = "";
	*/
	/*
	$debitamtbf = getAmountTrans($pdf->datefrom,"debitamt");
	$creditamtbf = getAmountTrans($pdf->datefrom,"creditamt");
	$data[]=array("","","","Balance B/F","",number_format($debitamtbf,2),number_format($creditamtbf,2),
			number_format($debitamtbf - $creditamtbf,2),"","");//Balance B/F
	*/
	/*
	while($row=$xoopsDB->fetchArray($query)){
		$accountcode_full=$row['accountcode_full'];
		$accounts_id=$row['accounts_id'];
		$bpartnerid=$row['bpartner_id'];

		//if($bpartnerid == "")
		//$bpartner_id = $pdf->bpartner_id;

		if($i==0){
		$debitamtbf = getBF($pdf->datefrom,"debitamt",$accounts_id,$pdf->bpartner_id);
		$creditamtbf = getBF($pdf->datefrom,"creditamt",$accounts_id,$pdf->bpartner_id);
		$data[]=array("","","","Balance B/F","",number_format($debitamtbf,2),number_format($creditamtbf,2),
				number_format($debitamtbf - $creditamtbf,2),"","");//Balance B/F

		$totaldebit = $totaldebit + $debitamtbf;
		$totalcredit = $totalcredit + $creditamtbf;
		}
			
		if($acc_id != $accountcode_full){//total every each accounts
			if($i > 0){
			$data[]=array("","","","Total","",number_format($totaldebitline,2),number_format($totalcreditline,2),"","","");
			$totaldebitline=0;
			$totalcreditline=0;
			}
		}
			
		$bpartner_name=$row['bpartner_name'];
		$bpartner_id=$row['bpartner_id'];
		$accounts_name=$row['accounts_name'];
		$accountgroup_name=$row['accountgroup_name'];
		$batchdate=$row['batchdate'];
		$batchno=$row['batchno'];
		$document_no=$row['document_no'];
		$amt=$row['amt'];
		$batchdate=$row['batchdate'];
		$debitamt="";
		$creditamt="";
		if($amt>0){
		$debitamt=$amt;
		$totaldebit=$totaldebit+$amt;
		$totaldebitline=$totaldebitline+$amt;		
		}
		else{
		$creditamt=$amt*-1;
		$totalcredit=$totalcredit + $amt*-1; 
		$totalcreditline=$totalcreditline + $amt*-1; 		
		}
		$balanceamt=number_format($totaldebit-$totalcredit,2);
		$i++;
			
		if($acc_id != $accountcode_full){// group by account
		$j++;
		$accountcode_full1 = $accountcode_full;
		$cnt = $j;
		$accountcode_full2 = $accountcode_full;
				
		}else{
		$accountcode_full1 = "";
		$cnt = "";
		$accountcode_full2 = "";
		$accounts_name = "";
		}
		$acc_id = $accountcode_full;

		if($batchdate == '0000-00-00')
		$batchdate="";

		if($bpartner_id > 0)
		$accounts_name = $bpartner_name;

		$data[]=array($accountcode_full1,$cnt,$accountcode_full2,$accounts_name,
				$batchdate,number_format($debitamt,2),number_format($creditamt,2),
				$balanceamt,$batchno,$document_no);
	if($pdf->bpartner_id > 0)
	$pdf->bpartner_name=$bpartner_name;
	else
	$pdf->bpartner_name="";
	}
		//last account total
		$data[]=array("","","","Total","",number_format($totaldebitline,2),number_format($totalcreditline,2),"","",""); 
		
		//total all  amount
		$data[]=array("","","","","Total Amount :",number_format($totaldebit,2),number_format($totalcredit,2),
				number_format($totaldebit-$totalcredit,2),"","");
				*/
	$pdf->AddPage();
	//$pdf->BasicTable($data);
	
	//$pdf->MultiCell(0,5,$sql,1,'C');
	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output("report.pdf","I");
	exit (1);

}

?>


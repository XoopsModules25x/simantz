<?php
/*code developed by kstan on 2008-12-26
*/
include_once('../simantz/class/fpdf/fpdf.php');

//declare global array, shall by class and main program
$header=array("Date","Batch","Cheque No","Account","Debit","Credit");
$w=array(25,20,25,70,25,25);



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


  public $datefrom="Unknown";
  public $dateto="Unknown";
  public $marginx=10;
  public $marginy=10;
//  public $pageheaderheight=50;
  public $pagefooterheight=15;

  public $headertitlex=70;
//  public $headertitley=10;
  public $headertitlewitdth=85;
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
  //public $w=array(10,20,20,20,70,20,20,20);

function Header()
{
	
	global $header,$w;
	$this->Image($this->imagepath, $this->marginx ,$this->marginx , $this->imagewidth , '' , $this->imagetype , '');
	$this->Ln();
	$this->SetFont('Times','B',18);
	$this->Rect($this->marginx,$this->marginy,$this->headerrectwith,$this->headerrectheight);
	$this->SetXY($this->headertitlex,$this->marginy);
	$this->Cell($this->headertitlewitdth,$this->headertitleheight,"Bank Reconcilation Report",0,0,'L');
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
	global $isgroup2;
	if($isgroup2==false)
	$displaycategory="Outstanding Transaction";
	else
	$displaycategory="Processed Transaction";

	$this->SetFont($this->ledgertitlefontname,'B',$this->ledgertitlefontsize);
	$this->Cell($this->ledgertitlecolwidth,$this->ledgertitleheight,
		"Account No: $this->headeraccounts_code-$this->headeraccounts_name ($displaycategory)",0,0,'L');
	$this->Ln();

$headeralign=array("L","L","L","L","R","R");
foreach($header as $col)
     	{
	$this->SetFont($this->tableheaderfont,$this->tableheaderfontstyle,$this->tableheaderfontsize); 
	
	//if($i > 0)
    $this->Cell($w[$i],$this->tableheaderheight,$col,$this->tableheadertype,0,$headeralign[$i]);
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

if (isset($_GET["submit"])){
	include_once "system.php";
	include_once "../simantz/class/Period.inc.php";
	include_once "class/Accounts.php";
	include_once "class/BankReconcilation.php";
	$period=new Period();
	$pdf=new PDF('P','mm','A4'); 
	$acc = new Accounts();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true ,$pdf->pagefooterheight +1 );

	$currentbankreconcilation_id=$_GET['bankreconcilation_id'];
	$r= new BankReconcilation();
	$r->fetchBankReconcilation($currentbankreconcilation_id);
	$accounts_id=$r->accounts_id;
	$period_id=$r->period_id;
	//$periodfrom_id=1;
	//$periodto_id=2;

	//getdatefrom
	$period->fetchPeriod($period_id);
	if(strlen($period->period_month)==1)
		$period->period_month='0'.$period->period_month;
	$datefrom="$period->period_year-$period->period_month-01" ;
	//getdateto

	$dateto="$period->period_year-$period->period_month-31" ;
 

	$pdf->datefrom=$datefrom;
 	$pdf->dateto=$dateto;

	$acc->fetchAccounts($accounts_id);
	$pdf->headeraccounts_code=$acc->accountcode_full;
	$pdf->headeraccounts_name=$acc->accounts_name;
//		order by a.accountcode_full,b.batchdate,b.batchno,t.seqno,t.reference_id desc
	//get required data
//
	  $sql="SELECT a.batchdate,a.batchno,a.accountcode_full,a.accounts_id,a.accounts_name,a.document_no2,a.amt,
		a.refamt,a.refaccounts_name,a.refaccounts_code,a.batch_id,a.bpartner_name,a.refbpartner_name,a.bpartner_id,
		a.refbpartner_id,a.refaccounts_id,a.bankreconcilation_id
		FROM (
		SELECT b.batchdate,b.batchno,a.accountcode_full,a.accounts_id,a.accounts_name,concat(t.document_no2,t2.document_no2) as document_no2,t2.amt *-1 as amt,
		t.amt  as refamt,a2.accounts_name as refaccounts_name,a2.accounts_code as refaccounts_code,b.batch_id,
		bp.bpartner_name,bp2.bpartner_name as refbpartner_name,bp.bpartner_id,bp2.bpartner_id as refbpartner_id,
		a2.accounts_id as refaccounts_id,t.bankreconcilation_id,t.reconciledate
		FROM $tablebatch b
		INNER JOIN $tabletransaction t on b.batch_id=t.batch_id
		INNER JOIN $tablebpartner bp on t.bpartner_id=bp.bpartner_id
		INNER JOIN $tableaccounts a on a.accounts_id=t.accounts_id
		INNER JOIN $tabletransaction t2 on t.reference_id=t2.trans_id
		INNER JOIN $tablebpartner bp2 on t2.bpartner_id=bp2.bpartner_id
		INNER JOIN $tableaccounts a2 on a2.accounts_id=t2.accounts_id
		WHERE (b.batchdate < '$dateto' OR b.batchdate = '$dateto')
		 and t.accounts_id=$accounts_id and b.iscomplete=1
		and t.reference_id>0 and
                (t.bankreconcilation_id=$currentbankreconcilation_id
                 or t.bankreconcilation_id=0
                 or (t.bankreconcilation_id>0 and t.reconciledate  > '$r->bankreconcilationdate')  )
		UNION
		SELECT b.batchdate,b.batchno,a2.accountcode_full,a2.accounts_id,a2.accounts_name,concat(t.document_no2,t2.document_no2) as document_no2,t.amt * -1,
		t2.amt as refamt,a.accounts_name as refaccounts_name,a.accounts_code as refaccounts_code,b.batch_id,
		bp2.bpartner_name,bp.bpartner_name as refbpartner_name,bp2.bpartner_id,bp.bpartner_id as refbpartner_id,
		a.accounts_id as refaccounts_id,t2.bankreconcilation_id,t2.reconciledate
		FROM $tablebatch b
		INNER JOIN $tabletransaction t on b.batch_id=t.batch_id
		INNER JOIN $tablebpartner bp on t.bpartner_id=bp.bpartner_id
		INNER JOIN $tableaccounts a on a.accounts_id=t.accounts_id
		INNER JOIN $tabletransaction t2 on t.reference_id=t2.trans_id
		INNER JOIN $tablebpartner bp2 on t2.bpartner_id=bp2.bpartner_id
		INNER JOIN $tableaccounts a2 on a2.accounts_id=t2.accounts_id
		WHERE  (b.batchdate < '$dateto' OR b.batchdate = '$dateto')
		and t2.accounts_id=$accounts_id and b.iscomplete=1
		and t.reference_id>0 and  (t2.bankreconcilation_id=$currentbankreconcilation_id
                or t2.bankreconcilation_id=0
                  or (t2.bankreconcilation_id>0 and t2.reconciledate  > '$r->bankreconcilationdate') )
		) a where a.accounts_id > 0 and a.batch_id>0 ORDER BY
		 case when (a.bankreconcilation_id <> $currentbankreconcilation_id and a.reconciledate  >'$r->bankreconcilationdate')
                        or a.bankreconcilation_id=0
                        then  0 else 1 end, a.batchdate,a.batchno";
	$query=$xoopsDB->query($sql);
	$i=0;

			
		$totaldebit=0;
		$totalcredit=0;
		$isgroup2=false;
	$pdf->AddPage();
	while ($row=$xoopsDB->fetchArray($query)){
		
		
		$batchno=$row['batchno'];
		$document_no=$row['document_no2'];
		$refaccounts_name=$row['refaccounts_name'];
		$refaccounts_code=$row['refaccounts_code'];
		$refbpartner_id=$row['refbpartner_id'];
		$bpartner_id=$row['bpartner_id'];
		$batchdate=$row['batchdate'];
		$refaccounts_id=$row['refaccounts_id'];
		$refbpartner_name=$row['refbpartner_name'];
		$bpartner_name=$row['bpartner_name'];
		$bankreconcilation_id=$row['bankreconcilation_id'];
		$amt=$row['amt'];	
		$refamt=$row['refamt'];
		$batch_id=$row['batch_id'];

		if($bankreconcilation_id==$currentbankreconcilation_id && $isgroup2==false){
			$isgroup2=true;
			$pdf->SetX($pdf->marginx);
			$pdf->SetFont("$pdf->tabletextfont",$pdf->tabletextfontstyle,$pdf->tabletextfontsize);
			$pdf->Cell($w[0],$pdf->tabletextheight,"",0,0,'L');
			$pdf->Cell($w[1],$pdf->tabletextheight,"",0,0,'L');
			$pdf->Cell($w[2],$pdf->tabletextheight,"",0,0,'L');
			$pdf->Cell($w[3],$pdf->tabletextheight,"Total Outstanding Transaction:","TB",0,'L');
			$pdf->Cell($w[4],$pdf->tabletextheight,number_format($totaldebit,2),"TB",0,'R');
			$pdf->Cell($w[5],$pdf->tabletextheight,number_format($totalcredit,2),"TB",0,'R');

			$total_outstandingdebit = $totaldebit;
			$total_outstandingcredit = $totalcredit;
	
			$totaldebit=0;
			$totalcredit=0;
			$pdf->Ln();
			$pdf->Ln();
			$pdf->SetFont($pdf->ledgertitlefontname,'B',$pdf->ledgertitlefontsize);
			$pdf->Cell($pdf->ledgertitlecolwidth,$pdf->ledgertitleheight,
				"Account No: $pdf->headeraccounts_code-$pdf->headeraccounts_name (Processed Transaction)",0,0,'L');
			$pdf->Ln();
		
$headeralign=array("L","L","L","L","R","R");
			$j=0;
			foreach($header as $col)
				{
				$pdf->SetFont($pdf->tableheaderfont,$pdf->tableheaderfontstyle,$pdf->tableheaderfontsize); 
				
				//if($i > 0)
			$pdf->Cell($w[$j],$pdf->tableheaderheight,$col,$pdf->tableheadertype,0,$headeralign[$j]);
				$j=$j+1;		
				}	
			$pdf->Ln();
			

			
		}


		//declare 1st account at header
		$transamt=0;
		$debitamt=0;
		$creditamt=0;

		if(abs($amt)<abs($refamt))
			$transamt=$amt;
		else
			$transamt=$refamt;

		$balanceamt=$transamt+$balanceamt;

		if($transamt>=0){
			$debitamt=number_format($transamt,2);
			$creditamt="";
			$totaldebit=abs($transamt)+$totaldebit;
		}
		else{
			$debitamt="";
			$creditamt=number_format($transamt * -1,2);
			$totalcredit=abs($transamt)+$totalcredit;

		}

		$pdf->SetX($pdf->marginx);
		$pdf->SetFont("$pdf->tabletextfont",$pdf->tabletextfontstyle,$pdf->tabletextfontsize);
		$pdf->Cell($w[0],$pdf->tabletextheight,$batchdate,0,0,'L');
//		$pdf->Cell($w[1],$pdf->tabletextheight,"$batchno/$accounts_id/$refaccounts_id/$account_type",0,0,'L',"",
		$pdf->Cell($w[1],$pdf->tabletextheight,"$batchno",0,0,'L',"",
				$url."/modules/simbiz/batch.php?action=edit&batch_id=$batch_id");
		$pdf->Cell($w[2],$pdf->tabletextheight,$document_no,0,0,'L');

		if($bpartner_id>0 && $acc->account_type != 2 && $acc->account_type != 3 )
		$displayname=$bpartner_name;
		elseif($refbpartner_id && $acc->account_type != 2 && $acc->account_type != 3)
		$displayname=$refbpartner_name;
		else
		$displayname=$refaccounts_name;
		
		$pdf->Cell($w[3],$pdf->tabletextheight,"$displayname",0,0,'L');
		$pdf->Cell($w[4],$pdf->tabletextheight,$debitamt,0,0,'R');
		$pdf->Cell($w[5],$pdf->tabletextheight,$creditamt,0,0,'R');

		$pdf->Ln();
		$i++;
	}
		$pdf->SetX($pdf->marginx);
		$pdf->SetFont("$pdf->tabletextfont",$pdf->tabletextfontstyle,$pdf->tabletextfontsize);
		$pdf->Cell($w[0],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[1],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[2],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[3],$pdf->tabletextheight,"Total Processed Transaction:","TB",0,'L');
		$pdf->Cell($w[4],$pdf->tabletextheight,number_format($totaldebit,2),"TB",0,'R');
		$pdf->Cell($w[5],$pdf->tabletextheight,number_format($totalcredit,2),"TB",0,'R');
//		$total_outstandingdebit = $totaldebit;
//		$total_outstandingcredit = $totalcredit;

		$pdf->Ln();
		$pdf->Ln();
		$i++;
		//print last statement amt
		$pdf->SetX($pdf->marginx);
		$pdf->SetFont("$pdf->tabletextfont",$pdf->tabletextfontstyle,$pdf->tabletextfontsize);
		$pdf->Cell($w[0],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[1],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[2],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[3],$pdf->tabletextheight,"Last Month Statement Balance:","",0,'L');
		$pdf->Cell($w[4],$pdf->tabletextheight,"","",0,'R');
		$pdf->Cell($w[5],$pdf->tabletextheight,$r->laststatementbalance,"",0,'R');
		$pdf->Ln();

		//print process reconcilation amt
		$pdf->SetX($pdf->marginx);
		$pdf->SetFont("$pdf->tabletextfont",$pdf->tabletextfontstyle,$pdf->tabletextfontsize);
		$pdf->Cell($w[0],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[1],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[2],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[3],$pdf->tabletextheight,"Reconciliation Amount:","",0,'L');
		$pdf->Cell($w[4],$pdf->tabletextheight,"","",0,'R');
		$pdf->Cell($w[5],$pdf->tabletextheight,$r->reconcilamt,"",0,'R');
		$pdf->Ln();

		//print process reconcilation amt
		$pdf->SetX($pdf->marginx);
		$pdf->SetFont("$pdf->tabletextfont",$pdf->tabletextfontstyle,$pdf->tabletextfontsize);
		$pdf->Cell($w[0],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[1],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[2],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[3],$pdf->tabletextheight,"New Statement Balance:","TB",0,'L');
		$pdf->Cell($w[4],$pdf->tabletextheight,"","",0,'R');
		$pdf->Cell($w[5],$pdf->tabletextheight,$r->statementbalance,"TB",0,'R');
		$pdf->Ln();
		$pdf->Ln();
		//print process reconcilation amt : $r->unreconcilamt
		$pdf->SetX($pdf->marginx);
		$pdf->SetFont("$pdf->tabletextfont",$pdf->tabletextfontstyle,$pdf->tabletextfontsize);
		$pdf->Cell($w[0],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[1],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[2],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[3],$pdf->tabletextheight,"Outstanding Amount:","",0,'L');
		$pdf->Cell($w[4],$pdf->tabletextheight,"","",0,'R');
		$pdf->Cell($w[5],$pdf->tabletextheight,number_format(($total_outstandingdebit - $total_outstandingcredit),2),"",0,'R');
		$pdf->Ln();


	$pdf->addPage();
	$pdf->MultiCell(0,5,$sql,1,'L');
	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output("generalledger.pdf","I");
	exit (1);

}
else{
include "system.php";
include "menu.php";
//include "exporttransaction.php";
//include_once 'class/Log.php';
include_once 'class/Accounts.php';
//include_once 'class/SelectCtrl.php';
include_once 'class/Transaction.php';


$accountsctrl=$simbizctrl->getSelectAccounts(0,'N',"onchange='refreshAccounts(this.value)'",
		"accounts_id",'and account_type=4');
$periodctrl=$simbizctrl->getSelectPeriod(0);
echo <<<EOF
<table>
  <tbody>
    <tr>
      <th colspan='4'>Criterial</th>
    </tr>
    <tr><form target='_blank' method='POST'>
      <td class='head'>Account</td>
      <td class='odd'>$accountsctrl</td>
      <td class='head'>Period</td>
      <td class='odd'>$periodctrl</td>
    </tr>
    <tr>
      <td class='footer' colspan='4'><input type='submit' name='submit' value='Print Preview'></td>
	</form>
    </tr>
  </tbody>
</table>
</td>
EOF;
require(XOOPS_ROOT_PATH.'/footer.php');
}
?>


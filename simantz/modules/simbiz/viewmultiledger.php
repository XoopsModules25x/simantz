<?php
/*code developed by kstan on 2008-12-26
*/
include_once('../simantz/class/fpdf/fpdf.php');
include_once "system.php";
$org = new Organization();

$showbatchno = $_POST['showbatchno'];

if($showbatchno=="on"){
$header=array("Date","Batch","Cheque No","Doc No","Account Name","Debit","Credit","Balance");
$w=array(14,14,21,20,70,17,17,17);
}else{
$header=array("Date","","Cheque No","Doc No","Account Name","Debit","Credit","Balance");
$w=array(15,1,20,20,80,18,19,18);

}
/*
//declare global array, shall by class and main program 
$header=array("Date","Batch","Doc No","Account Name","Debit","Credit","Balance");
//$w=array(20,20,20,70,20,20,20);
$w=array(15,15,18,88,18,18,18);
 * 
 */



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
  public $pageheaderheight=38;
  public $pagenearfooterposition=268;
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
  //public $w=array(10,20,20,20,70,20,20,20);

function Header()
{
	
	global $header,$w,$organization_code;
	$this->Image($this->imagepath, $this->marginx ,$this->marginx , $this->imagewidth , '' , $this->imagetype , '');
	$this->Ln();

        /* set organization text */
        $this->SetFont('Times','',8);
        $this->SetXY(10,10);
	$this->Cell(100,6,"Organization : $organization_code",0,0,'L');
        /* end */
        
	$this->SetFont('Times','B',20);
	$this->Rect($this->marginx,$this->marginy,$this->headerrectwith,$this->headerrectheight);
	$this->SetXY($this->headertitlex,$this->marginy);
	$this->Cell($this->headertitlewitdth,$this->headertitleheight,"General Ledger",0,0,'L');
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
		"$this->headeraccounts_code-$this->accountgroup_name:$this->headeraccounts_name",0,0,'L');
	$this->Ln();

        if($showbatchno=="on"){
	$headeralign = array("L","L","L","L","L","R","R","R");
        }else{
        $headeralign = array("L","L","L","L","L","R","R","R");
        }
        
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

function getBatchInfo($type=0){
    global $xoopsDB,$tablebatch;
    $retval = "";

    if($type == 0)
    $sql = "select min(batchdate) as select_date from $tablebatch where batch_id > 0 limit 1";
    else
    $sql = "select max(batchdate) as select_date from $tablebatch where batch_id > 0  limit 1";

    $query=$xoopsDB->query($sql);

    while ($row=$xoopsDB->fetchArray($query)){
    $retval = $row['select_date'];
    }
    return $retval;
}

}

if (isset($_POST["submit"])){
	include_once "system.php";
	include_once "../simantz/class/Period.inc.php";
	include_once "class/Accounts.php";
	$period=new Period();
	$pdf=new PDF('P','mm','A4'); 
	$acc = new Accounts();
	$aftercreate1stpage=false;
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true ,$pdf->pagefooterheight +1 );
	$hidewhennull=$_POST['hidewhennull'];
	$accounts_from=$_POST['accounts_from'];
	//if($accounts_from=="")
	$accounts_to=$_POST['accounts_to'];

        $organization_id=$_REQUEST['organization_id'];

	$org->fetchOrganization($organization_id);
	$companyno=$org->companyno;
	$orgname=$org->organization_name;
        $organization_code=$org->organization_code;

	$periodfrom_id=$_POST['periodfrom_id'];
	$periodto_id=$_POST['periodto_id'];
	//$periodfrom_id=1;
	//$periodto_id=2;

	
	//getdatefrom
	$period->fetchPeriod($periodfrom_id);
	if(strlen($period->period_month)==1)
		$period->period_month='0'.$period->period_month;
	$datefrom="$period->period_year-$period->period_month-01" ;
	//getdateto
	$period->fetchPeriod($periodto_id);
	if(strlen($period->period_month)==1)
		$period->period_month='0'.$period->period_month;


	$dateto="$period->period_year-$period->period_month-31" ;


	if($periodfrom_id == 0){
	$datefrom = "0000-01-01";
	$pdf->datefrom = "";
	}else{
	$pdf->datefrom = getMonth(str_replace("-","",$datefrom),0) ;
	}

	if($periodto_id == 0){
	$dateto = "9999-01-31";
	$pdf->dateto = "";
	}else{
	$pdf->dateto = getMonth(str_replace("-","",$dateto),1) ;
	}

 	//$pdf->datefrom=$datefrom;
 	//$pdf->dateto=$dateto;

        if($pdf->datefrom == "")
        $pdf->datefrom = $pdf->getBatchInfo(0);

        if($pdf->dateto == "")
        $pdf->dateto = $pdf->getBatchInfo(1);


	 $sqlgetaccountlist="SELECT a.accounts_id,a.accountcode_full, ac.classtype
		FROM $tableaccounts a
		inner join $tableaccountgroup ag on ag.accountgroup_id=a.accountgroup_id
		inner join $tableaccountclass ac on ac.accountclass_id=ag.accountclass_id
		WHERE a.accountcode_full = '$accounts_from' OR a.accountcode_full = '$accounts_to' OR
                ( a.accountcode_full >= '$accounts_from%' and a.accountcode_full <= '$accounts_to%')
		and a.placeholder=0 and a.account_type<>2 and a.account_type<>3 order by a.accountcode_full";	$queryaccountlist=$xoopsDB->query($sqlgetaccountlist);
	$j=0;
	while($rowaccounts=$xoopsDB->fetchArray($queryaccountlist)) {
	
	$accounts_id=$rowaccounts['accounts_id'];

$classtype=$rowaccounts['classtype'];


		//$pdf->headeraccounts_code=$accountcode_full;
  		//$pdf->headeraccounts_name=$accounts_name;
		//$balancebf=number_format($balanceamt,2);

		

	$sql="SELECT a.batchdate,a.batchno,a.accountcode_full,a.accounts_id,a.accounts_name,a.document_no,a.amt,
		a.refamt,a.refaccounts_name,a.refaccounts_code,a.batch_id,a.bpartner_name,a.refbpartner_name,a.bpartner_id,
		a.refbpartner_id,a.linedesc,a.refaccounts_id,a.document_no2,a.refdocument_no2,a.accountgroup_name
		FROM (
		SELECT b.batchdate,b.batchno,a.accountcode_full,a.accounts_id,a.accounts_name,t.document_no,t2.amt *-1 as amt,
		t.amt  as refamt,a2.accounts_name as refaccounts_name,a2.accounts_code as refaccounts_code,b.batch_id,
		bp.bpartner_name,bp2.bpartner_name as refbpartner_name,bp.bpartner_id,bp2.bpartner_id as refbpartner_id,t.linedesc,
		a2.accounts_id as refaccounts_id,t.document_no2,t2.document_no2 as refdocument_no2,ag2.accountgroup_name
		FROM $tablebatch b  
		INNER JOIN $tabletransaction t on b.batch_id=t.batch_id  and t.branch_id = $organization_id
		INNER JOIN $tablebpartner bp on t.bpartner_id=bp.bpartner_id  
		INNER JOIN $tableaccounts a on a.accounts_id=t.accounts_id 
		INNER JOIN $tabletransaction t2 on t.reference_id=t2.trans_id and t2.branch_id = $organization_id
		INNER JOIN $tablebpartner bp2 on t2.bpartner_id=bp2.bpartner_id  
		INNER JOIN $tableaccounts a2 on a2.accounts_id=t2.accounts_id
		INNER JOIN $tableaccountgroup ag2 on ag2.accountgroup_id=a.accountgroup_id
		WHERE (b.batchdate between '$datefrom' and '$dateto' OR b.batchdate = '$dateto')
		 and t.accounts_id=$accounts_id and b.iscomplete=1
		and t.reference_id>0
                and substring(ucase(a.accounts_name),1,11) <> 'RETAIN EARN'
		UNION ALL
		SELECT b.batchdate,b.batchno,a2.accountcode_full,a2.accounts_id,a2.accounts_name,t.document_no,t.amt * -1,
		t.amt * -1 as refamt,a.accounts_name as refaccounts_name,a.accounts_code as refaccounts_code,b.batch_id,
		bp2.bpartner_name,bp.bpartner_name as refbpartner_name,bp2.bpartner_id,bp.bpartner_id as refbpartner_id,t.linedesc,
		a.accounts_id as refaccounts_id,t2.document_no2,t.document_no2 as refdocument_no2,ag2.accountgroup_name
		FROM $tablebatch b  
		INNER JOIN $tabletransaction t on b.batch_id=t.batch_id and t.branch_id = $organization_id
		INNER JOIN $tablebpartner bp on t.bpartner_id=bp.bpartner_id  
		INNER JOIN $tableaccounts a on a.accounts_id=t.accounts_id 
		INNER JOIN $tabletransaction t2 on t.reference_id=t2.trans_id and t2.branch_id = $organization_id
		INNER JOIN $tablebpartner bp2 on t2.bpartner_id=bp2.bpartner_id  
		INNER JOIN $tableaccounts a2 on a2.accounts_id=t2.accounts_id
		INNER JOIN $tableaccountgroup ag2 on ag2.accountgroup_id=a2.accountgroup_id
		WHERE  (b.batchdate between '$datefrom' and '$dateto' OR b.batchdate = '$dateto')
                and substring(ucase(a2.accounts_name),1,11) <> 'RETAIN EARN'
		and t2.accounts_id=$accounts_id and b.iscomplete=1
		and t.reference_id>0) a where a.accounts_id > 0 and a.batch_id>0 ORDER BY a.batchdate,a.batchno";
	$query=$xoopsDB->query($sql);
	$i=0;


		$pdf->SetX($pdf->marginx);
		$totaldebit=0;
		$totalcredit=0;
	
		
	while ($row=$xoopsDB->fetchArray($query)){
	$batchdate=$row['batchdate'];
		
		$linedesc=$row['linedesc'];
		$batchno=$row['batchno'];
		$document_no=$row['document_no'];
		$refaccounts_name=$row['refaccounts_name'];
		$refaccounts_code=$row['refaccounts_code'];
		$refbpartner_id=$row['refbpartner_id'];
		$bpartner_id=$row['bpartner_id'];
		$refaccounts_id=$row['refaccounts_id'];
		$refbpartner_name=$row['refbpartner_name'];
		$bpartner_name=$row['bpartner_name'];
		$amt=$row['amt'];	
		$refamt=$row['refamt'];
		$batch_id=$row['batch_id'];
		$document_no2=$row['document_no2'];
		$refdocument_no2=$row['refdocument_no2'];
		$pdf->accountgroup_name=$row['accountgroup_name'];

	if($document_no2!=$refdocument_no2)
		$chequeno="$document_no2 $refdocument_no2";
		else
		$chequeno="$refdocument_no2";

		if($chequeno=='()' || $chequeno=='( )')
		$chequeno="";
		//create initial line after header, it is balance b/f
	

		if($linedesc != "")
		$linedesc = " -$linedesc";
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

	if($i == 0){
	$acc->fetchAccounts($accounts_id);
	if($classtype=="5A"|| $classtype=="6L" || $classtype=="7E")
	$balanceamt=$acc->accBalanceBFAmount($periodfrom_id,$accounts_id);
	else
	$balanceamt=0;
	
	$pdf->headeraccounts_code=$acc->accountcode_full;
  	$pdf->headeraccounts_name=$acc->accounts_name;
	//create 1st page.
	if($aftercreate1stpage==false)
	$pdf->AddPage();

	$aftercreate1stpage=true;
	//display header when is not on top
	$YPOST=$pdf->GetY();
	if($YPOST>=$pdf->pagenearfooterposition)
		$pdf->AddPage();
	if($pdf->GetY()>$pdf->pageheaderheight){
	$pdf->SetFont($pdf->ledgertitlefontname,'B',$pdf->ledgertitlefontsize);
	$pdf->Cell($pdf->ledgertitlecolwidth,$pdf->ledgertitleheight,
		"$pdf->headeraccounts_code-$pdf->accountgroup_name:$pdf->headeraccounts_name",0,0,'L');
	$pdf->Ln();

		//create table header

$headeralign = array("L","L","L","L","L","R","R","R");
	$k=0;
	foreach($header as $col)
	     	{
		$pdf->SetFont($pdf->tableheaderfont,$pdf->tableheaderfontstyle,$pdf->tableheaderfontsize); 
		//if($i > 0)
	    	$pdf->Cell($w[$k],$pdf->tableheaderheight,$col,$pdf->tableheadertype,0,$headeralign[$k]);
		$k=$k+1;		
		}	
	$pdf->Ln();


	}
	//$i=0;
	//only create header on page no 1
        if((int)($balanceamt) == 0)
        $balanceamt = 0;
        
	$balancebf=number_format($balanceamt,2);
        if($classtype=="5A"|| $classtype=="6L"||$classtype=="7E"){
	$pdf->SetX($pdf->marginx);
	$pdf->SetFont("$pdf->tabletextfont",$pdf->tabletextfontstyle,$pdf->tabletextfontsize);
	$pdf->Cell($w[0],$pdf->tabletextheight,"",0,0,'L');
	$pdf->Cell($w[1],$pdf->tabletextheight,"",0,0,'L');
	$pdf->Cell($w[2],$pdf->tabletextheight,"",0,0,'L');
        $pdf->Cell($w[3],$pdf->tabletextheight,"",0,0,'L');
	$pdf->Cell($w[4],$pdf->tabletextheight,"Balance B/F",0,0,'L');
	$pdf->Cell($w[5],$pdf->tabletextheight,"",0,0,'R');
	$pdf->Cell($w[6],$pdf->tabletextheight,"",0,0,'R');
	$pdf->Cell($w[7],$pdf->tabletextheight,$balancebf,0,0,'R');
	$pdf->Ln();
	$balanceamt=$transamt+$balanceamt;
}else{
$balancebf=0;
$balanceamt=$transamt+$balanceamt;
//$pdf->Ln();
}
//	echo "$transamt + $balancebf = $balanceamt <br>";
	}


		$pdf->SetX($pdf->marginx);
		$pdf->SetFont("$pdf->tabletextfont",$pdf->tabletextfontstyle,$pdf->tabletextfontsize);
		$pdf->Cell($w[0],$pdf->tabletextheight,$batchdate,0,0,'L');

                if($showbatchno=="on"){
		$pdf->Cell($w[1],$pdf->tabletextheight,"$batchno",0,0,'L',"",
				$url."/modules/simbiz/batch.php?action=edit&batch_id=$batch_id");

                }else{
                $pdf->Cell($w[1],$pdf->tabletextheight,"",0,0,'L');
                }

                $pdf->Cell($w[2],$pdf->tabletextheight,$chequeno,0,0,'L');
                
		$pdf->Cell($w[3],$pdf->tabletextheight,$document_no,0,0,'L');

		if($bpartner_id>0 && $acc->account_type != 2 && $acc->account_type != 3 )
		$displayname=$bpartner_name;
		elseif($refbpartner_id && $acc->account_type != 2 && $acc->account_type != 3)
		$displayname=$refbpartner_name;
		else
		$displayname=$refaccounts_name;

		if(strpos($displayname,"Cash At") !== false){
		$displayname = "";
		//$chequeno="";
		$linedesc = $row['linedesc'];
		}

		$dn = $displayname.$linedesc;
		while($pdf->GetStringWidth($dn)> $w[4])
				$dn=substr_replace($dn,"",-1);

		$pdf->Cell($w[4],$pdf->tabletextheight,$dn,0,0,'L');
		$pdf->Cell($w[5],$pdf->tabletextheight,$debitamt,0,0,'R');
		$pdf->Cell($w[6],$pdf->tabletextheight,$creditamt,0,0,'R');

                if((int)($balanceamt) == 0)
                $balanceamt = 0;


		$pdf->Cell($w[7],$pdf->tabletextheight,number_format($balanceamt,2),0,0,'R');
		$pdf->Ln();
		$i++;
	} //finish content, writing summary

		if($i > 0){

                if((int)($balanceamt) == 0)
                $balanceamt = 0;

		$pdf->SetX($pdf->marginx);
		$pdf->SetFont("$pdf->tabletextfont",$pdf->tabletextfontstyle,$pdf->tabletextfontsize);
		$pdf->Cell($w[0],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[1],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[2],$pdf->tabletextheight,"",0,0,'L');
                $pdf->Cell($w[3],$pdf->tabletextheight,"",0,0,'L');
		$pdf->Cell($w[4],$pdf->tabletextheight,"Total: $i","TB",0,'L');
		$pdf->Cell($w[5],$pdf->tabletextheight,number_format($totaldebit,2),"TB",0,'R');
		$pdf->Cell($w[6],$pdf->tabletextheight,number_format($totalcredit,2),"TB",0,'R');
		$pdf->Cell($w[7],$pdf->tabletextheight,number_format($balanceamt,2),"TB",0,'R');
		$pdf->Ln();
		$pdf->Ln();
		}
		$i++;

//	$pdf->MultiCell(0,5,$sql ,1,'L');




	}
//	$pdf->MultiCell(0,5,$sqlgetbf ,1,'L');
	//$pdf->AddPage();
	//$pdf->MultiCell(0,5,$sql,1,'L');
	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output("generalledger.pdf","I");
	exit (1);

}

?>


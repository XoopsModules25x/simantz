<?php
	include_once('../simantz/class/fpdf/fpdf.php');
	include_once "system.php";
	//include_once "../system/class/Organization.php";
	include_once "../simantz/class/Period.inc.php";
	include_once "../simantz/class/BPartner.php";
	$org = new Organization();
	$bp = new BPartner();

   $header=array("Date","Doc. No","Description","Debit","Credit","Balance");
   $w0=array(20,30,0,20,20,20);
   $w1=array(20,30,0,20,20,20);
   $papertype=array("A4","Letter");


   $datefrom="Unknown";
   $dateto="Unknown";
   $marginx=array(10,10);
   $marginy=array(10,10);
   $pageheaderheight=array(80,80);
   $pagefooterheight=array(53,53);
   $reversepagefooterheight=array(245,245);
   $agingboxwidth=array(31,31);
   $agingboxheight=array(10,10);

   $pagewidth=array(180,190);

   $tableheadertype="TB";
//   $orginfo_startx=array(60,60);
//   $orginfo_starty=array(10,10);


   $defaultfont="Times";
   $defaultfontsize="8";
   $defaultfontheight="4";
   $defaultfontstyle=0;

   $orgnamefont="Times";
   $orgnamefontsize="12";
   $orgnamefontheight="6";
   $orgnamefontstyle="B";
   $orgcontactfont="Times";
   $orgcontactfontsize="10";
   $orgcontactfontheight=4;
   $orgcontactfontstyle="";

   $tableheaderfont="Times";
   $tableheaderfontsize="10";
   $tableheaderfontstyle="B";
   $tableheaderheight="5";
   $tableheadertype="TB";

   $headerorgseparator=2; //Space below organization info


   $reporttitle = "Account Statement";
   $reporttitlefont="Times";
   $reporttitlefontsize="10";
   $reporttitlefontheight="5";
   $reporttitlefontstyle="UB";



   $imagepath="./images/logo.jpg";
   $imagetype="JPG";
   $imagewidth=60;

   $month_term_date_posx=array(150,160);


   $orgname="Unknown";
   $orgstreet1="Unknown";
   $orgstreet2="Unknown";
   $orgstreet3="Unknown";
   $orgcity="Unknown";
   $orgstate="Unknown";
   $orgcountry_name="Unknown";
   $orgemail="Unknown";
   $orgurl="Unknown";
   $orgtel1="Unknown";
   $orgtel2="Unknown";
   $orgfax="Unknown";

   $statementdescription="The outstanding amount state as above, it is greatly appreciated if you can proceed the payment as soon as possible. \nIf there is any discrepancy please inform us within 1 week.\n";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{

  public $printotal=false;
  public $totalbalance=0;
function Header()
{

	global  $datefrom,$dateto, $w0,$w1, $header, $headeraccounts_code, $headeraccounts_name,  $ledgertitlefontname,  $ledgertitlefontsize,
		$ledgertitleheight,  $ledgertitlecolwidth,  $tableheaderfont,  $tableheaderfontsize, $tableheaderfontstyle,
		$tableheaderheight,  $tableheadertype,  $datefrom,   $dateto,  $marginx,  $marginy,$pageheaderheight, $pagefooterheight,
		$headertitlex,  $headertitlewitdth,  $headertitleheight,   $headerrectwith,  $headerrectheight,   $datelabelwidth,
		$datetextwidth,   $datelabelheight,  $headerseparator, $imagepath,   $imagetype,   $imagewidth,$reporttitle, 
		$statementpapersource, $companyno, $defaultfont,$defaultfontsize,$defaultfontheight,$defaultfontstyle,
		$orgname, $orgnamefont,   $orgnamefontsize,   $orgnamefontheight,
		$orgnamefontstyle,  $orgcontactfont,
		$orgcontactfontsize,  $orgcontactfontheight,   $orgcontactfontstyle,   $headerorgseparator,   $reporttitle,
		$reporttitlefont,  $reporttitlefontsize,  $reporttitlefontheight,   $reporttitlefontstyle,
		$orgstreet1,$orgstreet2,$orgstreet3,$orgcity,$orgstate,$orgcountry_name,$orgemail,$orgurl,$orgtel1,$orgtel2,$orgfax,$bp;


	//$this->Image($imagepath, $marginx[$statementpapersource] ,$marginx[$statementpapersource] , $imagewidth , '' , $imagetype , '');
	//organization name
	$this->Ln();
	$this->SetFont($orgnamefont,$orgnamefontstyle,$orgnamefontsize);
	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]);
	$this->Cell(0,$orgnamefontheight,"$orgname $companyno",0,0,'C');
	$this->SetFont($orgcontactfont,$orgcontactfontstyle,$orgcontactfontsize);
	$this->Ln();

	//organization contact info
	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgnamefontheight);
	$orgadd1=$orgstreet1 . ", ";
	if($orgstreet2!="" && $orgstreet2!="-" && $orgstreet2!=" ")
		$orgstreet2= $orgstreet2;
	else
		$orgstreet2="";

	$orgadd1=$orgadd1 .$orgstreet2;

	if($orgstreet3!="" && $orgstreet3!="-" && $orgstreet3!=" ")
		$orgadd1=$orgadd1 . ", " . $orgstreet3;

	$this->SetFont($orgcontactfont,$orgcontactfontstyle,$orgcontactfontsize);
	$this->Cell(0,$orgcontactfontheight,$orgadd1,0,0,'C');
	$this->Ln();
//	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgcontactfontheight * 2);
	$this->Cell(0,$orgcontactfontheight,"$orgpostcode $orgcity, $orgstate, $orgcountry_name",0,0,'C');
	$this->Ln();
//	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgcontactfontheight * 3);
	$this->Cell(0,$orgcontactfontheight,"Tel: $orgtel1,$orgtel2 Fax: $orgfax",0,0,'C');
	$this->Ln();
//	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgcontactfontheight * 4);
	$this->Cell(0,$orgcontactfontheight,"web:$orgurl Email:$orgemail",0,0,'C');


	$this->SetFont($defaultfont,"BU",$defaultfontsize+2);
	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgcontactfontheight * 5 +$headerorgseparator);
	$this->Cell(0,$defaultfontheight,$reporttitle,0,0,'R');

	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgcontactfontheight * 5 +$headerorgseparator);
	$this->Cell(0,$defaultfontheight,$bp->bpartner_name ,0,0,'L');

	$this->SetFont($defaultfont,"",$defaultfontstyle);
	$this->Ln();

	if($bp->bpartner_street2!="" && $bp->bpartner_street2!="-" && $bp->bpartner_street2!=" ")
		$bp->bpartner_street2= ", ".$bp->bpartner_street2;
	else
		$bp->bpartner_street2="";

	if($bp->bpartner_street3!="" && $bp->bpartner_street3!="-" && $bp->bpartner_street3!=" ")
		$bp->bpartner_street3= "," . $bp->bpartner_street3;
	else
		$bp->bpartner_street3="";
	$bpartneradd=$bp->bpartner_street1 . $bp->bpartner_street2 . $bp->bpartner_street3;

	$this->Cell(0,$defaultfontheight,$bpartneradd,0,0,'L');
	$this->Ln();
	$this->Cell(0,$defaultfontheight,"$bp->bpartner_postcode $bp->bpartner_city, $bp->bpartner_state, $bp->bpartner_country_name" ,0,0,'L');
	$this->Ln();

	if($bp->bpartner_tel_2!="" && $bp->bpartner_tel_2!="-" || $bp->bpartner_tel_2==" ")
	$bp->bpartner_tel_1="$bp->bpartner_tel_1/$bp->bpartner_tel_2";

	$this->Cell(0,$defaultfontheight,"Tel: $bp->bpartner_tel_1 Fax: $bp->bpartner_fax",0,0,'L');
	$this->Ln();
	$this->Cell(0,$defaultfontheight,"Business Partner No: $bp->bpartner_no",0,0,'L');
	$this->Ln();
	$this->Ln();
$i=0;
foreach($header as $col)
     	{
	$this->SetFont($tableheaderfont,$tableheaderfontstyle,$tableheaderfontsize); 
	
	if($i >= 0)
		if($statementpapersource==0)
	 	  	 $this->Cell($w0[$i],$tableheaderheight,$col,$tableheadertype,0,'L');
		else
   			 $this->Cell($w1[$i],$tableheaderheight,$col,$tableheadertype,0,'L');

	$i=$i+1;		
	}	
    $this->Ln(10);

}


function Footer()
{
global $pagefooterheight,$statementpapersource,$pagewidth,$marginx,$agingboxwidth,$agingboxheight,
	$reversepagefooterheight,$defaultfontheight,$statementdescription;
$timestamp= date("d/m/y H:i:s", time());
    //Position at 1.5 cm from bottom
  // $this->SetY(-1 * $pagefooterheight[$statementpapersource]);
   // $this->SetY($pagefooterheight[$statementpapersource] * -1);
    $this->Line($marginx[$statementpapersource],$reversepagefooterheight[$statementpapersource],
			$pagewidth[$statementpapersource]+$marginx[$statementpapersource],$reversepagefooterheight[$statementpapersource]);

    $boxwidth=$agingboxwidth[$statementpapersource];
    $boxheight=$agingboxheight[$statementpapersource];

    $this->SetXY($marginx[$statementpapersource],$reversepagefooterheight[$statementpapersource]+1 );

    if($this->printotal==true)
	$this->Cell(0,$defaultfontheight,"+".number_format($this->totalbalance,2),0,0,"R");
    else
	$this->Cell(0,$defaultfontheight,"-".number_format($this->totalbalance,2),0,0,"R");

    $this->SetFont($defaultfont,"B",$defaultfontsize);
    $periodname=array("5 Months+","4 Month","3 Month","2 Month","1 Month","Current");
    $periodamt=array(0.00,0.00,0.00,0.00,0.00,0.00);
    for($j=0;$j<6;$j++){
		$xpos=$marginx[$statementpapersource] + $boxwidth * $j;
   	    $this->Rect($xpos,
		$reversepagefooterheight[$statementpapersource] +$defaultfontheight*2,$boxwidth,$boxheight);
	    $this->SetXY($xpos,$reversepagefooterheight[$statementpapersource] + $defaultfontheight*2 );
	    $this->Cell($boxwidth, $defaultfontheight,$periodname[$j],0,0,"L");
	    $this->SetXY($xpos,$reversepagefooterheight[$statementpapersource] + $defaultfontheight*3);
	    $this->Cell($boxwidth, $defaultfontheight,number_format($periodamt[$j],2),0,0,"R");

}
	$this->Ln();

	$this->SetY($reversepagefooterheight[$statementpapersource] +$boxheight + $defaultfontheight*2 +  2);
	$this->MultiCell(0,$defaultfontheight,"$statementdescription",0,"L");
    $this->Ln();
    //Arial italic 8
    $this->SetFont('courier','I',8);
	
    $this->Cell(0,5,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp ,0,0,'C');
}

}

if (isset($_POST["submit"])){


	if($statementpapersource==0)
	$w0[2]=75;
	else
	$w1[2]=80;
	
//	$pdf=new PDF('P','mm',$papertype[$statementpapersource]);  //0=A4,1=Letter
	$pdf=new PDF('P','mm',"A4");  //0=A4,1=Letter
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,40 + 1 );

	$org->fetchOrganization($defaultorganization_id);
	$companyno=$org->companyno;
	$orgname=$org->organization_name;
	$orgstreet1=$org->street1;
	$orgstreet2=$org->street2;
	$orgstreet3=$org->street3;
	$orgcity=$org->city;
	$orgstate=$org->state;
	$orgcountry_name=$org->country_name;
	$orgemail=$org->email;
	$orgurl=$org->url;
	$orgtel1=$org->tel_1;
	$orgtel2=$org->tel_2;
	$orgfax=$org->fax;

	$periodfrom_id=$_POST['periodfrom_id'];
	$periodto_id=$_POST['periodto_id'];

	$periodfrom_id=1;
	$periodto_id=2;	
	$period = new Period();
	$period->fetchPeriod($periodfrom_id);
	if(strlen($period->period_month)==1)
		$period->period_month="0".$period->period_month;
	$datefrom=$period->period_year."-".$period->period_month."-01";

	$period->fetchPeriod($periodto_id);
	if(strlen($period->period_month)==1)
		$period->period_month="0".$period->period_month;
	$dateto=$period->period_year."-".$period->period_month."-01";

//	$bpartner_array=$_POST['bpartner_array'];
	$bpartner_array=array(1,2,3,4,5,6,7,8,9,10);
	$bpartnercount=0;
	foreach ($bpartner_array as $bpartner_id ){
	
	  $bp->fetchBPartner($bpartner_id);
	  $pdf->printotal=false;
	  $pdf->AddPage();
		//echo " $bpartner_id ; $bp->bpartner_name<br>";
	  $sql="SELECT a.batchdate,a.batchno,a.accountcode_full,a.accounts_id,a.accounts_name,a.document_no,a.amt,
		a.refamt,a.refaccounts_name,a.refaccounts_code,a.batch_id
		FROM (
		SELECT b.batchdate,b.batchno,a.accountcode_full,a.accounts_id,a.accounts_name,t.document_no,t2.amt *-1 as amt,
		t.amt  as refamt,a2.accounts_name as refaccounts_name,a2.accounts_code as refaccounts_code,b.batch_id
		FROM $tablebatch b  
		INNER JOIN $tabletransaction t on b.batch_id=t.batch_id 
		INNER JOIN $tableaccounts a on a.accounts_id=t.accounts_id 
		INNER JOIN $tabletransaction t2 on t.reference_id=t2.trans_id 
		INNER JOIN $tableaccounts a2 on a2.accounts_id=t2.accounts_id 
		WHERE b.batchdate between '$datefrom' and '$dateto' and t.bpartner_id=$bpartner_id and b.iscomplete=1
		and t.reference_id>0
		UNION
		SELECT b.batchdate,b.batchno,a2.accountcode_full,a2.accounts_id,a2.accounts_name,t.document_no,t.amt * -1,
		t2.amt as refamt,a.accounts_name as refaccounts_name,a.accounts_code as refaccounts_code,b.batch_id
		FROM $tablebatch b  
		INNER JOIN $tabletransaction t on b.batch_id=t.batch_id 
		INNER JOIN $tableaccounts a on a.accounts_id=t.accounts_id 
		INNER JOIN $tabletransaction t2 on t.reference_id=t2.trans_id 
		INNER JOIN $tableaccounts a2 on a2.accounts_id=t2.accounts_id 
		WHERE b.batchdate between '$datefrom' and '$dateto' and t2.bpartner_id=$bpartner_id and b.iscomplete=1
		and t.reference_id>0) a where a.accounts_id > 0 and a.batch_id>0 ORDER BY a.batchdate,a.batchno";
	  $query=$xoopsDB->query($sql);
	  $i=0;

			
	  $totaldebit=0;
	  $totalcredit=0;
	  $balanceamt=0;
		
	while ($row=$xoopsDB->fetchArray($query)){
		$batchdate=$row['batchdate'];

		$batchno=$row['batchno'];
		$document_no=$row['document_no'];
		$refaccounts_name=$row['refaccounts_name'];
		$refaccounts_code=$row['refaccounts_code'];
		$amt=$row['amt'];	
		$refamt=$row['refamt'];
		$batch_id=$row['batch_id'];

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

		$pdf->SetX($marginx[$statementpapersource]);
		$pdf->SetFont("$pdf->tabletextfont",$pdf->tabletextfontstyle,$pdf->tabletextfontsize);
		$rowdata=array($batchdate,$document_no,$refaccounts_name,$debitamt,$creditamt,number_format($balanceamt,2));
		$align=array("L","L","L","R","R","R");
		$k=0;
		foreach ($rowdata as $c){
		if($statementpapersource==0)
			$pdf->Cell($w0[$k],$defaultfontheight,$c,1,0,$align[$k]); //Print for a4
		else
			$pdf->Cell($w1[$k],$defaultfontheight,$c,1,0,$align[$k]); // print for letter
		$k++;
		}
		$pdf->Ln();
		$i++;
	  } 
	
	  $pdf->printotal=true;
	  $pdf->totalbalance=$balanceamt;
	$bpartnercount++;
		//$pdf->MultiCell(0,5,$sql,1,'C');
	}


	$pdf->Output("bpartnerstatement.pdf","I");
	exit (1);

}

?>


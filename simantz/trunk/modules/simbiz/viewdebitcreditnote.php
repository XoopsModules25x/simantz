<?php
	include_once('../simantz/class/fpdf/fpdf.php');
	include_once "system.php";
	//include_once "../system/class/Organization.php";
	include_once "../simantz/class/Period.inc.php";
	include_once "../simantz/class/BPartner.php";
	//include_once "class/Accounts.php";

	$org = new Organization();
	$bp = new BPartner();
	//$acc = new Accounts();
   $header=array("No","Item","Unit Price","Qty","Amount");
   $w0header=array(7,70,30,50,40);
   $w1header=array(7,70,30,50,40);
   $w0=array(7,70,30,35,15,40);
   $w1=array(7,70,30,35,15,40);

   $papertype=array("A4","Letter");


   $datefrom="Unknown";
   $dateto="Unknown";
   $marginx=array(10,10);
   $marginy=array(10,10);
   $pageheaderheight=array(80,80);
   $pagefooterheight=array(53,53);
   $reversepagefooterheight=array(-45,-45);
   $agingboxwidth=array(31,31);
   $agingboxheight=array(10,10);

   $pagewidth=array(180,190);

   $tableheadertype="TB";
//   $orginfo_startx=array(60,60);
//   $orginfo_starty=array(10,10);


   $defaultfont="Times";
   $defaultfontsize="10";
   $defaultfontheight="4";
   $defaultfontstyle="12";

   $orgnamefont="Times";
   $orgnamefontsize="16";
   $orgnamefontheight="6";
   $orgnamefontstyle="B";
   $orgcontactfont="Times";
   $orgcontactfontsize="12";
   $orgcontactfontheight=4;
   $orgcontactfontstyle="";

   $tableheaderfont="Times";
   $tableheaderfontsize="10";
   $tableheaderfontstyle="B";
   $tableheaderheight="5";
   $tableheadertype="TB";

   $headerorgseparator=2; //Space below organization info
$footersummarystartx=80;

   $reporttitle = array("Unknown","DEBIT NOTE","CREDIT NOTE");
   $reporttitlefont="Times";
   $reporttitlefontsize="14";
   $reporttitlefontheight="5";
   $reporttitlefontstyle="B";

   $currentx=0;
   $currenty=0;

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

	$document_no="Unknown";
        $debitcreditnote_prefix="";
	$document_date="Unknown";
	$lorry_no="Unknown";
	$ref_no="Unknown";
	$totaltonnage="Unknown";
	$subtotal="Unknown";
	$bpartner_id="Unknown";
	$netamt="Unknown";
	$lineqty="Unknown";
	$iscomplete="Unknown";
	$deliverychargesamt="Unknown";
	$loadingcharges="Unknown";
	$sundry_othersexpenses="Unknown";
	$description="Unknown";
	$totaloritonnage="Unknown";
$document_date="";



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{

  public $printotal=0;

function Header()
{

	global   $w0header,$w1header, $header, $headeraccounts_code, $headeraccounts_name,  $ledgertitlefontname,  
		$ledgertitlefontsize,$document_no,$debitcreditnote_prefix,$document_date,$ref_no,$documenttype,
		$ledgertitleheight,  $ledgertitlecolwidth,  $tableheaderfont,  $tableheaderfontsize, $tableheaderfontstyle,
		$tableheaderheight,  $tableheadertype,  $datefrom,   $dateto,  $marginx,  $marginy,$pageheaderheight, $pagefooterheight,
		$headertitlex,  $headertitlewitdth,  $headertitleheight,   $headerrectwith,  $headerrectheight,   $datelabelwidth,
		$datetextwidth,   $datelabelheight,  $headerseparator, $imagepath,   $imagetype,   $imagewidth,$reporttitle, 
		$statementpapersource, $companyno, $defaultfont,$defaultfontsize,$defaultfontheight,$defaultfontstyle,
		$orgname, $orgnamefont,   $orgnamefontsize,   $orgnamefontheight,
		$orgnamefontstyle,  $orgcontactfont,$document_date,
		$orgcontactfontsize,  $orgcontactfontheight,   $orgcontactfontstyle,   $headerorgseparator,
		$reporttitlefont,  $reporttitlefontsize,  $reporttitlefontheight,   $reporttitlefontstyle,
		$orgstreet1,$orgstreet2,$orgstreet3,$orgcity,$orgstate,$orgcountry_name,$orgemail,$orgurl,$orgtel1,$orgtel2,$orgfax,$bp;


	//$this->Image($imagepath, $marginx[$statementpapersource] ,$marginx[$statementpapersource] , $imagewidth , '' , $imagetype , '');
	//organization name
	$randomtext=time();
	$this->Ln();
	$this->SetFont($orgnamefont,$orgnamefontstyle,$orgnamefontsize);
	$this->SetXY($marginx[$statementpapersource]+30,$marginy[$statementpapersource]);
	$this->Cell(120,$orgnamefontheight,"$orgname",0,0,'C');
	$this->SetFont("Times","",10);
	$this->Cell(0,$orgnamefontheight,"($companyno)",0,0,'L');
	$this->SetTextColor(255,255,255);
	$this->Cell(0,$orgnamefontheight,"$randomtext",0,0,'C');
	$this->SetTextColor(0,0,0);
//	$this->Cell(0,$orgnamefontheight,"$orgname $companyno ",0,0,'C');
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
	$this->Cell(0,$orgcontactfontheight,"$orgadd1, $orgpostcode $orgcity, $orgstate, $orgcountry_name",0,0,'C');
//	$this->Ln();
//	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgcontactfontheight * 2);
//	$this->Cell(0,$orgcontactfontheight,"",0,0,'C');
	$this->Ln();
//	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgcontactfontheight * 3);
	$this->Cell(0,$orgcontactfontheight,"Tel: $orgtel1,$orgtel2 Fax: $orgfax",0,0,'C');
	$this->Ln();
//	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgcontactfontheight * 4);
	$this->Cell(0,$orgcontactfontheight,"web:$orgurl Email:$orgemail",0,0,'C');

	//display report name, and company name
	$this->SetFont($defaultfont,"B",$defaultfontsize+2);
	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgcontactfontheight * 6 +$headerorgseparator);
	$this->Cell(0,$defaultfontheight,$bp->bpartner_name ,0,0,'L');
	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgcontactfontheight * 4 +$headerorgseparator);

	$this->Cell(0,$defaultfontheight,$reporttitle[$documenttype],0,0,'C');

	//switch back to standard font
	$this->SetFont($defaultfont,"",$defaultfontstyle);
	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgcontactfontheight * 6 +$headerorgseparator+$defaultfontheight);

	if($bp->bpartner_street2!="" && $bp->bpartner_street2!="-" && $bp->bpartner_street2!=" ")
		$bp->bpartner_street2= ", ".$bp->bpartner_street2;
	else
		$bp->bpartner_street2="";

	if($bp->bpartner_street3!="" && $bp->bpartner_street3!="-" && $bp->bpartner_street3!=" ")
		$bp->bpartner_street3= "," . $bp->bpartner_street3;
	else
		$bp->bpartner_street3="";
	$bpartneradd=$bp->bpartner_street1 . $bp->bpartner_street2 . $bp->bpartner_street3;
	//showadd
	$currenty=$this->GetY();

	$this->Cell(0,$defaultfontheight,$bpartneradd,0,0,'L');
	$this->SetXY($marginx[$statementpapersource]+150, $currenty-10);

	//show Terms
	$this->SetFont($defaultfont,"B",$orgcontactfontsize);
	$this->Cell(25,$defaultfontheight,"Document No ",0,0,'L');
	$this->Cell(0,$defaultfontheight," : $debitcreditnote_prefix$document_no",0,0,'L');
	$this->SetXY($marginx[$statementpapersource]+156, $currenty);
	$this->Ln();
	$this->SetFont($defaultfont,"", $defaultfontsize);
	$currenty=$this->GetY();
	$this->Cell(0,$defaultfontheight,"$bp->bpartner_postcode $bp->bpartner_city, $bp->bpartner_state, $bp->bpartner_country_name" ,0,0,'L');
	$this->SetXY($marginx[$statementpapersource]+160, $currenty);

	//show Month

	$this->Cell(13,$defaultfontheight,"Date ",0,0,'L');
	//$this->Cell(0,$defaultfontheight,": ".date('Y',time()) . "-" .date('M',time()) . "-".date('d',time()),0,0,'L');

	$this->Cell(0,$defaultfontheight,": $document_date",0,0,'L');

	$this->Ln();

	if($bp->bpartner_tel_2!="" && $bp->bpartner_tel_2!="-" || $bp->bpartner_tel_2==" ")
	$bp->bpartner_tel_1="$bp->bpartner_tel_1/$bp->bpartner_tel_2";

	$currenty=$this->GetY();
	$this->Cell(0,$defaultfontheight,"Tel: $bp->bpartner_tel_1 Fax: $bp->bpartner_fax",0,0,'L');
	$this->SetXY($marginx[$statementpapersource]+160, $currenty);
	$this->Cell(13,$defaultfontheight,"Ref.No",0,0,'L');
	$this->Cell(0,$defaultfontheight,": ".$ref_no,0,0,'L');



	$this->Ln();
	$this->Cell(0,$defaultfontheight,"Business Partner No: $bp->bpartner_no",0,0,'L');
//	$this->Ln();
	$currenty=$this->GetY();
	$this->SetXY($marginx[$statementpapersource]+160, $currenty);


	$this->Cell(13,$defaultfontheight,"Page",0,0,'L');
	$this->Cell(0,$defaultfontheight, ": ".$this->PageNo() . ' / {nb}',0,0,'L');
	$this->Ln();


$i=0;
foreach($header as $col)
     	{
	$this->SetFont($tableheaderfont,$tableheaderfontstyle,$tableheaderfontsize); 

	if($i==1  )
		$align="L";
	elseif($i==3)
		$align="C";
	else
		$align="R";
	if($i >= 0)
		if($statementpapersource==0)
	 	  	 $this->Cell($w0header[$i],$tableheaderheight,$col,$tableheadertype,0,$align);
		else
   			 $this->Cell($w1header[$i],$tableheaderheight,$col,$tableheadertype,0,$align);

	$i=$i+1;		
	}	
    $this->Ln(6);

}


function Footer()
{
global $pagefooterheight,$statementpapersource,$pagewidth,$marginx,$agingboxwidth,$agingboxheight,$tableheaderheight,
	$tableheadertype,$footersummarystartx,$description,
	$reversepagefooterheight,$defaultfontheight,$description,$totalpcs,$totaltonnage,$originalamt,$w0header,$w1header;
$timestamp= date("d/m/y H:i:s", time());

$this->SetFont("Times","","10");
    $this->Line($marginx[$statementpapersource],$reversepagefooterheight[$statementpapersource],
			$marginx[$statementpapersource]+$pagewidth[$statementpapersource],$reversepagefooterheight[$statementpapersource]);
    $this->SetXY($marginx[$statementpapersource],$reversepagefooterheight[$statementpapersource]);
    $this->MultiCell(0,5,$this->numberintext,0,'L');


  //$header=array("Item","Unit Price","Qty","Amount");
   //$w0=array(50,40,30,10,20,20,20);

    //$this->SetFont("Times","B","14");
$footer=array("","","","",$originalamt);
$i=0;
$this->Line($marginx[$statementpapersource],$this->GetY(),$marginx[$statementpapersource]+$pagewidth[$statementpapersource],$this->GetY());
	$this->SetFont("Times","B","12");
if($this->printotal==true)
foreach($footer as $col)
     	{
	//$this->SetFont($tableheaderfont,$tableheaderfontstyle,$tableheaderfontsize); 

	if($i==0 || $i==1 || $i==9)
		$align="L";
	else
		$align="R";
	if($i >= 0)
		if($statementpapersource==0)
	 	  	 $this->Cell($w0header[$i],$tableheaderheight,$col,$tableheadertype,0,$align);
		else
   			 $this->Cell($w1header[$i],$tableheaderheight,$col,$tableheadertype,0,$align);

	$i=$i+1;		
	}	

    $this->SetX($marginx[$statementpapersource]);
	
    $currenty=$this->GetY();
 
  //  $currentx=$marginx[$statementpapersource]+$footersummarystartx;
if($this->printotal==true){
   
    $this->Ln();
    $this->SetFont("Times","B","10");
    $this->MultiCell($footersummarystartx,$defaultfontheight,'Description:',0,"L");

    $this->SetFont("Times","","10");
    $this->MultiCell(140,$defaultfontheight,$description,0,"L");

    $this->SetXY(155,-40);
    //$this->MultiCell(0,$defaultfontheight,"Prepared By",0,"L");
    $this->SetXY(155,-20);
    $this->Cell(0,$defaultfontheight,"_____________________",0,0,"L");
    $this->SetXY(155,-15);
    $this->Cell(0,$defaultfontheight,"Prepared By:",0,0,"L");
  }
else{

	
    

//    $this->SetXY($currentx,$currenty);
    $this->Cell(0,$defaultfontheight,"Continue next page ->",0,0,"C");

}
    //Arial italic 8
   // $this->SetFont('courier','I',8);
	
    //$this->Cell(0,5,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp ,0,0,'C');
}

}

if ($_POST){


	
	$pdf=new PDF('P','mm',$papertype[$statementpapersource]);  //0=A4,1=Letter
//	$pdf=new PDF('P','mm',"A4");  //0=A4,1=Letter
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,48 );

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

	$debitcreditnote_id=$_POST['debitcreditnote_id'];
//	$periodfrom_id=2;
//	$periodto_id=2;	
	$sqlheader="SELECT dcn.*,cur.currency_name FROM $tabledebitcreditnote dcn
		INNER JOIN $tablecurrency cur on cur.currency_id=dcn.currency_id
		WHERE dcn.debitcreditnote_id=$debitcreditnote_id";
	$query=$xoopsDB->query($sqlheader);
	if ($row=$xoopsDB->fetchArray($query)){

	$debitcreditnote_id=$row["debitcreditnote_id"];
	$debitcreditnote_prefix=$row["debitcreditnote_prefix"];
	$document_no=$row["document_no"];
	$document_date=$row["document_date"];
	$organization_id=$row["organization_id"];
	$bpartner_id=$row["bpartner_id"];
	$ref_no=$row['ref_no'];
	$itemqty=$row['itemqty'];
	$iscomplete=$row['iscomplete'];
	$batch_id=$row['batch_id'];

	$description=$row['description'];
	$documenttype=$row['documenttype'];
	$currency_name=$row['currency_name'];
	$amt=$row['amt'];
	$exchangerate=$row['exchangerate'];
	$currency_id=$row['currency_id'];
	$exchangerate=$row['exchangerate'];
	$originalamt=$row['originalamt'];
	

	  $bp->fetchBPartner($bpartner_id);
	  $pdf->AddPage();
	  $pdf->printotal=false;

		//echo " $bpartner_id ; $bp->bpartner_name<br>";
	  $sql="SELECT dcnl.debitcreditnoteline_id,dcnl.subject, dcnl.amt,dcnl.qty,dcnl.uom, dcnl.description,dcnl.unitprice  
		FROM $tabledebitcreditnoteline dcnl
		where dcnl.debitcreditnote_id=$debitcreditnote_id order by dcnl.debitcreditnoteline_id";

	  $query=$xoopsDB->query($sql);
	  $i=0;


	$currenty=$pdf->GetY();
	$nextrowy=$currenty;
	while ($rowline=$xoopsDB->fetchArray($query)){
		$debitcreditnoteline_id=$rowline['debitcreditnoteline_id'];

		$linedescription=$rowline['description'];
		$qty=$rowline['qty'];
		$unitprice=$rowline['unitprice'];
		$uom=$rowline['uom'];
		$subject=$rowline['subject'];
		$lineamt=$rowline['amt'];




		$pdf->SetXY($marginx[$statementpapersource],$nextrowy);

		if($linedescription!="")
		$linedescription=$linedescription.chr(10);
		$rowdata=array($i+1,$subject.chr(10).$linedescription.chr(10),$unitprice,$qty,$uom,$lineamt);
		$align=array("L","L","R","R","C","R");
		$k=0;
		$pdf->SetFont($defaultfont,"",$defaultfontstyle);
		$currenty=$nextrowy;
		$currentx=$marginx[$statementpapersource];
		foreach ($rowdata as $c){
		if($currenty>222){
			$pdf->AddPage();
			$currenty=62;
			$nextrowy=0;
		}
		
		$pdf->SetXY($currentx,$currenty);

		if($statementpapersource==0){
			$pdf->MultiCell($w0[$k],$defaultfontheight,$c,0,$align[$k]); //Print for a4
			$currentx=$currentx+$w0[$k];
		}
		else{
			$pdf->MultiCell($w1[$k],$defaultfontheight,$c,0,$align[$k]); // print for letter
			$currentx=$currentx+$w1[$k];

		}
		$k++;
		if($nextrowy<$pdf->GetY())
		$nextrowy=$pdf->GetY();

		}
		$pdf->Ln();
		$i++;
	  } 
	  
	  $pdf->printotal=true;
	 
	  $pdf->numberintext=strtoupper($currency_name .": ". convertNumber($originalamt));
	 $pdf->SetXY($marginx[$statementpapersource] + 8,$nextrowy);
	$pdf->Ln();
//	 $pdf->MultiCell(0,5,$numberintext,0,'L');
	// $pdf->MultiCell(0,5,$sql,0,'L');
	$pdf->Ln();

	}


	$pdf->Output("bpartnerstatement.pdf","I");
	//exit (1);

}
else
{
echo $_POST['debitcreditnote_id'] . $_POST['submit'];
}
?>


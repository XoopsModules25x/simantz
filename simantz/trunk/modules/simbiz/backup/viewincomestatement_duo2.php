<?php
	include_once('../../class/fpdf/fpdf.php');
	include_once "system.php";
	include_once "../system/class/Organization.php";
	include_once "../system/class/Period.php";
	include_once "../system/class/BPartner.php";
	include_once "class/Accounts.php";

	$org = new Organization();
	$bp = new BPartner();
	$acc = new Accounts();
   $header=array("Accounts","","");
   $w=array(130,30,30);
   $papertype="A4";


   $datefrom="Unknown";
   $dateto="Unknown";
   $marginx= 10 ;
   $marginy= 10 ;
   $pageheaderheight= 80 ;
   $pagefooterheight= 15 ;
 //  $reversepagefooterheight= 245 ;

   $pagewidth=180;

   $tableheadertype="TB";
//   $orginfo_startx=array(60,60);
//   $orginfo_starty=array(10,10);

   $showaccountcode=0;
   $showplacefolderindicator=1;
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


   $reporttitle = "Income Statement";
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

  public $totalbalance=0;

function Header()
{

	global  $datefrom,$dateto, $w, $header, $headeraccounts_code, $headeraccounts_name,  $ledgertitlefontname,  $ledgertitlefontsize,
		$ledgertitleheight,  $ledgertitlecolwidth,  $tableheaderfont,  $tableheaderfontsize, $tableheaderfontstyle,
		$tableheaderheight,  $tableheadertype,  $datefrom,   $dateto,  $marginx,  $marginy,$pageheaderheight, $pagefooterheight,
		$headertitlex,  $headertitlewitdth,  $headertitleheight,   $headerrectwith,  $headerrectheight,   $datelabelwidth,
		$datetextwidth,   $datelabelheight,  $headerseparator, $imagepath,   $imagetype,   $imagewidth,$reporttitle, 
		$companyno, $defaultfont,$defaultfontsize,$defaultfontheight,$defaultfontstyle,
		$orgname, $orgnamefont,   $orgnamefontsize,   $orgnamefontheight,
		$orgnamefontstyle,  $orgcontactfont,
		$orgcontactfontsize,  $orgcontactfontheight,   $orgcontactfontstyle,   $headerorgseparator,   $reporttitle,
		$reporttitlefont,  $reporttitlefontsize,  $reporttitlefontheight,   $reporttitlefontstyle,
		$orgstreet1,$orgstreet2,$orgstreet3,$orgcity,$orgstate,$orgcountry_name,$orgemail,$orgurl,$orgtel1,$orgtel2,$orgfax,$bp;


	$this->Ln();
	$this->SetFont($orgnamefont,$orgnamefontstyle,$orgnamefontsize);
	$this->SetXY($marginx,$marginy);
	$this->Cell(0,$orgnamefontheight,"$orgname $companyno",0,0,'C');
	$this->SetFont($orgcontactfont,$orgcontactfontstyle,$orgcontactfontsize);
	$this->Ln();

	//organization contact info
	$this->SetXY($marginx,$marginy+$orgnamefontheight);
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

	$this->Cell(0,$orgcontactfontheight,"$orgpostcode $orgcity, $orgstate, $orgcountry_name",0,0,'C');
	$this->Ln();

	$this->Cell(0,$orgcontactfontheight,"Tel: $orgtel1,$orgtel2 Fax: $orgfax",0,0,'C');
	$this->Ln();

	$this->Cell(0,$orgcontactfontheight,"web:$orgurl Email:$orgemail",0,0,'C');

	//display report name, and company name
	$this->SetFont($defaultfont,"BU",$defaultfontsize+2);
	$this->SetXY($marginx,$marginy+$orgcontactfontheight * 5 +$headerorgseparator);
	$this->Cell(0,$defaultfontheight,$bp->bpartner_name ,0,0,'L');
	$this->SetXY($marginx,$marginy+$orgcontactfontheight * 5 +$headerorgseparator);
	$this->Cell(0,$defaultfontheight,$reporttitle,0,0,'C');
	$this->Ln();
	$this->Ln();

	//switch back to standard font
	$this->SetFont($defaultfont,"",$defaultfontstyle);

$i=0;
foreach($header as $col)
     	{
	$this->SetFont($tableheaderfont,$tableheaderfontstyle,$tableheaderfontsize); 
	
	if($i >= 0)
	 	  	 $this->Cell($w[$i],$tableheaderheight,$col,$tableheadertype,0,'L');

	$i=$i+1;		
	}	
    $this->Ln(6);

}


function Footer()
{	global $pagefooterheight;
	$this->SetY($pagefooterheight * -1);
    //Arial italic 8
    $this->SetFont('courier','I',8);
	
    $this->Cell(0,5,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp ,0,0,'C');
}

}

if (isset($_POST["submit"])){


	
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
	$reportlevel=$_POST['reportlevel'];
	$showzero=$_POST['showzero'];
	$period=new Period();
	if($period->fetchPeriod($periodfrom_id))
		$header[1]=$period->period_name;
	else
		$header[1]="Unknown";

	$sql="SELECT a.accountcode_full,a.accounts_id,a.accounts_name,ac.classtype, a.treelevel,a.placeholder,a.parentaccounts_id,
		case when (SELECT transactionamt FROM $tabletranssummary where accounts_id=a.accounts_id and period_id=$periodfrom_id) is null 
		then 0 else  (SELECT transactionamt FROM $tabletranssummary where accounts_id=a.accounts_id and period_id=$periodfrom_id) end
		 as transactionamt
		FROM $tableaccounts a 
		INNER JOIN $tableaccountgroup ag on ag.accountgroup_id=a.accountgroup_id
		INNER JOIN $tableaccountclass ac on ag.accountclass_id=ac.accountclass_id
		WHERE ac.classtype in ('1S','2C','3O','4X') and a.treelevel<=$reportlevel
		ORDER BY ac.classtype,a.accountcode_full";

	$query=$xoopsDB->query($sql);
	$pdf->AddPage();
	$prefix="";
	$currentcategory="1S";
	$grossprofit=0;
	$totalsales=0;
	$totalcost=0;
	$totalexpenses=0;
	$totalotherincome=0;
	$netprofit=0;
	while($row=$xoopsDB->fetchArray($query)){
		$accountcode_full=$row['accountcode_full'] ;
		$accounts_name=$row['accounts_name'];
		$placeholder=$row['placeholder'];
		$accounts_id=$row['accounts_id'];
		$classtype=$row['classtype'];
		$treelevel=$row['treelevel'];
		$transactionamt=$row['transactionamt'];



		switch($classtype){
		  case "1S":
			$totalsales=$totalsales+abs($transactionamt);
		  break;	
		  case "2C":
			$totalcost=$totalcost+abs($transactionamt);
		  break;	
		  case "3O":
			$totalotherincome=$totalotherincome+abs($transactionamt);
		  break;	
		  case "4X":
			$totalexpenses=$totalexpenses+abs($transactionamt);
		  break;	

		}
		

	  if($currentcategory !=$classtype){
		$ypos=$pdf->GetY();		
		$pdf->Line($w[0],$ypos,$marginx+$w[0]+$w[1],$ypos);
		$pdf->SetFont($defaultfont,'',$defaultfontsize); 
		$pdf->Cell($w[0],$defaultfontheight,"",0,0,"L");
		$summaryamt="";
		switch($currentcategory){
		  case "1S":
			$summaryamt=number_format($totalsales,2);
			$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");
		  break;	
		  case "2C":
			$summaryamt=number_format($totalcost,2);
			$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");

			$pdf->Ln();
			$pdf->SetFont($defaultfont,'B',$defaultfontsize+1);
			$grossprofit=$totalsales-$totalcost;

			if($grossprofit < 0){
			 $pdf->Cell($w[0],$defaultfontheight,"Gross Loss\t",0,0,"L");
			 $pdf->Cell($w[1],$defaultfontheight,"(".number_format($grossprofit,2).")",0,0,"R");

			}
			else{
			 $pdf->Cell($w[0],$defaultfontheight,"Gross Profit",0,0,"L");
			 $pdf->Cell($w[1],$defaultfontheight,number_format($grossprofit,2),0,0,"R");
			}
		  break;	
		  case "3O":
			$summaryamt=number_format($totalotherincome,2);
			$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");

		  break;	


	  }

		$currentcategory =$classtype;
		$pdf->Ln(10);
	  }	


	  if($showaccountcode==1)
		$accounts_name=$accountcode_full . '-'.$accounts_name;
	

	  if($placeholder==0 )
		$displayamt=number_format(abs($transactionamt),2);
	  elseif($placeholder==1  && $treelevel<$reportlevel)
		$displayamt="";
	  else
		$displayamt=$acc->getAccountsPeriodBalance($periodfrom_id,$accounts_id,0);

	  if($treelevel==1)
		$prefix="";
	  elseif($treelevel==2)
		$prefix="  ";
	  elseif($treelevel==3)
		$prefix="    ";

	  if($showplacefolderindicator==1 && $placeholder==1)
		$displaytext=$prefix."[".$accounts_name."]";
	  else
	  	$displaytext=$prefix.$accounts_name;
	  $data=array($prefix.$displaytext,$displayamt);
	  $pdf->SetX($marginx);
	
	  $i=0;
	  foreach($data as $col)
     	  {
	    if($i==0)
		$align='L';
	    else
		$align='R';
	    $pdf->SetFont($defaultfont,'',$defaultfontsize); 
	    $pdf->Cell($w[$i],$defaultfontheight,$col,'',0,$align);

	    $i++;		
	  }	
	
	  $pdf->Ln();

	}
		//display summary for last row
			$ypos=$pdf->GetY();		
			$pdf->Line($w[0],$ypos,$marginx+$w[0]+$w[1],$ypos);
			$summaryamt=number_format($totalexpenses,2);
			$pdf->Cell($w[0],$defaultfontheight,"",0,0,"R");
			$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");
			$pdf->Ln();
			$pdf->Ln();
			$pdf->SetFont($defaultfont,'B',$defaultfontsize+1);
			$netprofit=$grossprofit+$totalotherincome-$totalexpenses;

			if($netprofit < 0){
			 $pdf->Cell($w[0],$defaultfontheight,"Net Loss",0,0,"L");
			 $pdf->Cell($w[1],$defaultfontheight,"(".number_format($netprofit,2).")",0,0,"R");
			}
			else{
			 $pdf->Cell($w[0],$defaultfontheight,"Net Profit",0,0,"L");
			 $pdf->Cell($w[1],$defaultfontheight,number_format($netprofit,2),0,0,"R");
			}

	//$pdf->MultiCell(0,5,"$sql",1,"C");

	$pdf->Output("viewincomestatement_single.pdf","I");
	exit (1);

}

?>


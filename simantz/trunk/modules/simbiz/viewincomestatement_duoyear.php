<?php
	include_once('../simantz/class/fpdf/fpdf.php');
	include_once "system.php";
	//include_once "../system/class/Organization.php";

	include_once "class/FinancialYear.php";
	include_once "class/Accounts.php";

	$org = new Organization();
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
   $defaultfontsize="10";
   $defaultfontheight="5";
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
		$orgnamefontstyle,  $orgcontactfont,$org,
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
$orgadd1=$orgstreet1;
	

	$orgadd1=$orgadd1 ." ".$orgstreet2 ." " . $orgstreet3;

	$this->SetFont($orgcontactfont,$orgcontactfontstyle,$orgcontactfontsize);
	$this->Cell(0,$orgcontactfontheight,$orgadd1,0,0,'C');
	$this->Ln();

	$this->Cell(0,$orgcontactfontheight,"$org->postcode $orgcity $orgstate $orgcountry_name",0,0,'C');
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
	
	if($i > 0)
		$align='R';
	else
		$align='L';
	 	  	 $this->Cell($w[$i],$tableheaderheight,$col,$tableheadertype,0,$align);

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
	
	$financialyearfrom_id=$_POST['financialyearfrom_id'];
	$financialyearto_id=$_POST['financialyearto_id'];

	$reportlevel=$_POST['reportlevel'];
	$showzero=$_POST['showzero'];
	$showaccountcode=$_POST['showaccountcode'];

	$financialyear=new FinancialYear();

	if($financialyear->fetchFinancialYear($financialyearfrom_id))
		$header[1]=$financialyear->financialyear_name;
	else
		$header[1]="Unknown";

	$periodrange1=$financialyear->getPeriodRange($financialyearfrom_id);


	if($financialyear->fetchFinancialYear($financialyearto_id))
		$header[2]=$financialyear->financialyear_name;
	else
		$header[2]="Unknown";

	$periodrange2=$financialyear->getPeriodRange($financialyearto_id);

	if($showaccountcode=="on")
	$orderby = "ORDER BY ac.classtype,a.accountcode_full";
	else
	$orderby = "ORDER BY ac.classtype,a.accountcode_full,a.placeholder desc,a.accounts_name";


	$sql="SELECT a.accountcode_full,a.accounts_id,a.accounts_name,ac.classtype, a.treelevel,a.placeholder,a.parentaccounts_id,
		case when (SELECT sum(transactionamt) FROM $tabletranssummary where accounts_id=a.accounts_id and period_id in ($periodrange1)) is null 
		then 0 else  (SELECT sum(transactionamt) FROM $tabletranssummary where accounts_id=a.accounts_id and period_id in ($periodrange1)) end
		 as transactionamt1,
		case when (SELECT sum(transactionamt) FROM $tabletranssummary where accounts_id=a.accounts_id and period_id in ($periodrange2)) is null 
		then 0 else  (SELECT sum(transactionamt) FROM $tabletranssummary where accounts_id=a.accounts_id and period_id in ($periodrange2)) end
		 as transactionamt2
		FROM $tableaccounts a 
		INNER JOIN $tableaccountgroup ag on ag.accountgroup_id=a.accountgroup_id
		INNER JOIN $tableaccountclass ac on ag.accountclass_id=ac.accountclass_id
		WHERE ac.classtype in ('1S','2C','3O','4X') and a.treelevel<=$reportlevel
		$orderby ";

	$query=$xoopsDB->query($sql);
	$pdf->AddPage();
	$prefix="";
	$currentcategory="1S";
	$grossprofit1=0;
	$grossprofit2=0;
	$totalsales1=0;
	$totalsales2=0;

	$totalcost1=0;
	$totalcost2=0;
	$totalexpenses1=0;
	$totalexpenses2=0;
	$totalotherincome1=0;
	$totalotherincome2=0;
	$netprofit1=0;
	$netprofit2=0;
	while($row=$xoopsDB->fetchArray($query)){
		$accountcode_full=$row['accountcode_full'] ;
		$accounts_name=$row['accounts_name'];
		$placeholder=$row['placeholder'];
		$accounts_id=$row['accounts_id'];
		$classtype=$row['classtype'];
		$treelevel=$row['treelevel'];
		$transactionamt1=$row['transactionamt1'];
		$transactionamt2=$row['transactionamt2'];

	  if($showaccountcode=="on")
		$accounts_name=$accountcode_full . '-'.$accounts_name;
	

	  if($placeholder==0 ){
		$displayamt1=number_format(abs($transactionamt1),2);
		$displayamt2=number_format(abs($transactionamt2),2);
		}
	  elseif($placeholder==1  && $treelevel<$reportlevel){
		$displayamt1="";
		$displayamt2="";
		}
	  else{
		$transactionamt1=$acc->getAccountsPeriodBalance($periodfrom_id,$accounts_id,0);
		$transactionamt2=$acc->getAccountsPeriodBalance($periodto_id,$accounts_id,0);

		$displayamt1=number_format($transactionamt1,2);
		$displayamt2=number_format($transactionamt2,2);
		}

		switch($classtype){
		  case "1S":
			$totalsales1=$totalsales1+abs($transactionamt1);
			$totalsales2=$totalsales2+abs($transactionamt2);

		  break;	
		  case "2C":
			$totalcost1=$totalcost1+abs($transactionamt1);
			$totalcost2=$totalcost2+abs($transactionamt2);
		  break;	
		  case "3O":
			$totalotherincome1=$totalotherincome1+abs($transactionamt1);
			$totalotherincome2=$totalotherincome2+abs($transactionamt2);
		  break;	
		  case "4X":
			$totalexpenses1=$totalexpenses1+abs($transactionamt1);
			$totalexpenses2=$totalexpenses2+abs($transactionamt2);
		  break;	

		}
		
	//when reach new category, print the summary
	  if($currentcategory !=$classtype){
		$ypos=$pdf->GetY();		
		$pdf->Line($w[0],$ypos,$marginx+$w[0]+$w[1]+$w[2],$ypos);
		$pdf->SetFont($defaultfont,'',$defaultfontsize); 
		$pdf->Cell($w[0],$defaultfontheight,"",0,0,"L");
		$summaryamt="";
		switch($currentcategory){
		  case "1S":
			$summaryamt=number_format($totalsales1,2);
			$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");
			$summaryamt=number_format($totalsales2,2);
			$pdf->Cell($w[2],$defaultfontheight,$summaryamt,0,0,"R");
		  break;	
		  case "2C":
			$summaryamt=number_format($totalcost1,2);
			$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");
			$summaryamt=number_format($totalcost2,2);
			$pdf->Cell($w[2],$defaultfontheight,$summaryamt,0,0,"R");

			$pdf->Ln();
			$pdf->SetFont($defaultfont,'B',$defaultfontsize+1);
			$grossprofit1=$totalsales1-$totalcost1;
			$grossprofit2=$totalsales2-$totalcost2;


			if($grossprofit1<0)
				$gpdisplay1="".number_format($grossprofit1,2)."";
			else
				$gpdisplay1=number_format($grossprofit1,2);

			if($grossprofit2<0)
				$gpdisplay2="".number_format($grossprofit2,2)."";
			else
				$gpdisplay2=number_format($grossprofit2,2);

			 $pdf->Cell($w[0],$defaultfontheight,"Gross Profit(Loss)",0,0,"L");
			
			 $pdf->Cell($w[1],$defaultfontheight,$gpdisplay1,0,0,"R");
			 $pdf->Cell($w[1],$defaultfontheight,$gpdisplay2,0,0,"R");
		  break;	
		  case "3O":
			$summaryamt=number_format($totalotherincome1,2);
			$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");
			$summaryamt=number_format($totalotherincome2,2);
			$pdf->Cell($w[2],$defaultfontheight,$summaryamt,0,0,"R");
		  break;	


	  }

		$currentcategory =$classtype;
		$pdf->Ln(10);
	  }	



	//put prefix at parent account 
	  if($treelevel==1)
		$prefix="";
	  elseif($treelevel==2)
		$prefix="  ";
	  elseif($treelevel==3)
		$prefix="    ";
	  elseif($treelevel==4)
		$prefix="       ";

	//if display folder indicator = 1, account with placeholder=1 will display as [account]
	  if($showplacefolderindicator==1 && $placeholder==1)
		$displaytext=$prefix."[".$accounts_name."]";
	  else
	  	$displaytext=$prefix.$accounts_name;

	  $data=array($prefix.$displaytext,$displayamt1,$displayamt2);
	  $pdf->SetX($marginx);

	if($showzero == "on")
	$checkzero = 1;
	else{
	$checkzero = $displayamt1;
		if($checkzero == 0 )
		$checkzero = $displayamt2;
	}
	
	//if(substr($displaytext,0,1) == "[" || $checkzero <> 0){
        if(($showplacefolderindicator==1 && $placeholder==1) || $checkzero <> 0){
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

	}
		//display summary for last row
			$ypos=$pdf->GetY();		
			$pdf->Line($w[0],$ypos,$marginx+$w[0]+$w[1]+$w[2],$ypos);

			$pdf->Cell($w[0],$defaultfontheight,"",0,0,"R");
			$summaryamt=number_format($totalexpenses1,2);
			$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");
			$summaryamt=number_format($totalexpenses2,2);
			$pdf->Cell($w[2],$defaultfontheight,$summaryamt,0,0,"R");

			$pdf->Ln();
			$pdf->Ln();
			$pdf->SetFont($defaultfont,'B',$defaultfontsize+1);

			$netprofit1=$grossprofit1+$totalotherincome1-$totalexpenses1;
			$netprofit2=$grossprofit2+$totalotherincome2-$totalexpenses2;


			if($netprofit1>=0)
				$displaynp1=number_format($netprofit1,2);
			else
				$displaynp1="".number_format($netprofit1,2)."";
			if($netprofit2>=0)
				$displaynp2=number_format($netprofit2,2);
			else
				$displaynp2="".number_format($netprofit2,2)."";

			 $pdf->Cell($w[0],$defaultfontheight,"Net Profit (Loss)",0,0,"L");
			 $pdf->Cell($w[1],$defaultfontheight,$displaynp1,"TB",0,"R");
			 $pdf->Cell($w[2],$defaultfontheight,$displaynp2,"TB",0,"R");
			$pdf->Ln();
			 $pdf->Line($marginx+$w[0],$pdf->GetY()+1,$marginx+$w[0]+$w[1]+$w[2],$pdf->GetY()+1);
	//$pdf->MultiCell(0,5,"$sql / $financialyearto_id",1,"C");

	$pdf->Output("viewincomestatement_single.pdf","I");
	exit (1);

}

?>


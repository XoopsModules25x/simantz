<?php
	include_once('../simantz/class/fpdf/fpdf.php');
	include_once "system.php";
	//include_once "../system/class/Organization.php";
	include_once "class/FinancialYear.php";
	include_once "class/Accounts.php";

	$org = new Organization();
	$acc = new Accounts();
        $header=array("Accounts","");
        $w=array(160,30);
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
		$orgstreet1,$orgstreet2,$orgstreet3,$orgcity,$orgstate,$orgcountry_name,$orgemail,$orgurl,$orgtel1,$orgtel2,$orgfax,$bp, $orgreportheader;


	$this->Ln();
	$this->SetFont($orgnamefont,$orgnamefontstyle,$orgnamefontsize);
	$this->SetXY($marginx,$marginy);
	$this->Cell(0,$orgnamefontheight,"$orgreportheader",0,0,'C');
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
		$align="R";
	else
		$align="L";

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

	//$financialyearfrom_id=$_POST['financialyearfrom_id'];
	$reportlevel=$_POST['reportlevel'];
	$showzero=$_POST['showzero'];
	$showaccountcode=$_POST['showaccountcode'];

	///$financialyear=new FinancialYear();
//
	//if($financialyear->fetchFinancialYear($financialyearfrom_id))
	//	$header[1]=$financialyear->financialyear_name;
	//else
	//	$header[1]="Unknown";

	//$periodrange=$financialyear->getPeriodRange($financialyearfrom_id);

        $datefrom="0000-00-00";
        $dateto=$_POST['date1'];
        if($dateto=="")
        $dateto=getMinMaxBatchDate(1);
        $header[1]=$dateto;

       $allsubsql.="case when (SELECT sum(t.amt) FROM $tabletransaction t
                     inner join $tablebatch b on t.batch_id=b.batch_id
                     where b.iscomplete=1 and t.accounts_id=a.accounts_id and
                     batchdate BETWEEN '$datefrom' and '$dateto') is null
                    then 0 else
                        (SELECT sum(t.amt) FROM $tabletransaction t
                        inner join $tablebatch b on t.batch_id=b.batch_id
                        where b.iscomplete=1 and t.accounts_id=a.accounts_id and
                        batchdate BETWEEN '$datefrom' and '$dateto') end";

//	if($showaccountcode=="on")
//	$orderby = "ORDER BY ac.classtype,a.accountcode_full";
//	else
	$orderby = "ORDER BY ac.classtype,a.accountcode_full,a.placeholder desc,a.accounts_name";


	$sql="SELECT a.accountcode_full,a.accounts_id,a.accounts_name,ac.classtype, a.treelevel,
                a.placeholder,a.parentaccounts_id,a.hierarchy, $allsubsql as transactionamt
		FROM $tableaccounts a
		INNER JOIN $tableaccountgroup ag on ag.accountgroup_id=a.accountgroup_id
		INNER JOIN $tableaccountclass ac on ag.accountclass_id=ac.accountclass_id
		WHERE ac.classtype in ('5A','6L','7E') and a.account_type <>6
		$orderby ";

	$query=$xoopsDB->query($sql);
	$pdf->AddPage();
	$prefix="";
	$currentcategory="5A";

	$totalasset=0;
	$totalliability=0;
	$totalequity=0;

	while($row=$xoopsDB->fetchArray($query)){
		$accountcode_full=$row['accountcode_full'] ;
		$accounts_name=$row['accounts_name'];
		$placeholder=$row['placeholder'];
		$accounts_id=$row['accounts_id'];
		$classtype=$row['classtype'];
		//$treelevel=$row['treelevel'];

                $hierarchy=explode(']',$row['hierarchy']);
                $treelevel=sizeof($hierarchy)-1;
                //skip to next record if found current record is not under this level
                if($treelevel>$reportlevel)
                    continue;

                if($treelevel==1)
                        $prefix="";
                  elseif($treelevel==2)
                        $prefix="  ";
                  elseif($treelevel==3)
                        $prefix="    ";
                  elseif($treelevel==4)
                        $prefix="       ";

                  if($showplacefolderindicator==1 && $placeholder==1)
                        $displaytext=$prefix."[".$accounts_name."]";
                  else
                        $displaytext=$prefix.$accounts_name;



                $accounts_name=$row['accounts_name'];
		$transactionamt=$row['transactionamt'];
                if($showaccountcode=="on")
                    $accounts_name=$accountcode_full . "-".$accounts_name;

                if($transactionamt==0 && $placeholder==1 && $treelevel==$reportlevel)
                $transactionamt=$acc->getAccountDateRangeValue($datefrom,$dateto,$accounts_id,0);
                elseif($placeholder==1)
                $transactionamt=0;


		switch($classtype){
		  case "5A":
			$totalasset=$totalasset+$transactionamt;
                        
                        if($placeholder==0 )
                            $displayamt=changeNegativeNumberFormat(($transactionamt),2);
                        elseif($placeholder==1  && $treelevel<$reportlevel)
                            $displayamt="";
                        elseif($placeholder==1 && $treelevel==$reportlevel)
                            $displayamt=changeNegativeNumberFormat(($transactionamt),2);

		  break;
		  case "6L":
			$totalliability=$totalliability+$transactionamt;
                        if($placeholder==0 )
                            $displayamt=changeNegativeNumberFormat($transactionamt*-1,2);
                        elseif($placeholder==1  && $treelevel<$reportlevel)
                            $displayamt="";
                        elseif($placeholder==1 && $treelevel==$reportlevel)
                            $displayamt=changeNegativeNumberFormat($transactionamt*-1,2);
		  break;
		  case "7E":
			$totalequity=$totalequity+$transactionamt;
                        if($placeholder==0 )
                            $displayamt=changeNegativeNumberFormat(($transactionamt*-1),2);
                        elseif($placeholder==1  && $treelevel<$reportlevel)
                            $displayamt="";
                        elseif($placeholder==1 && $treelevel==$reportlevel)
                            $displayamt=changeNegativeNumberFormat(($transactionamt*-1),2);
		  break;
		

		}


	  if($currentcategory !=$classtype){
		$ypos=$pdf->GetY();
		$pdf->Line($w[0],$ypos,$marginx+$w[0]+$w[1],$ypos);
		$pdf->SetFont($defaultfont,'',$defaultfontsize);
		$pdf->Cell($w[0],$defaultfontheight,"",0,0,"L");
		$summaryamt="";
		switch($currentcategory){
		  case "5A":

			$summaryamt=changeNegativeNumberFormat($totalasset,2);
                        
			//$pdf->Ln();
                        $pdf->SetX($marginx);
			$pdf->SetFont($defaultfont,'B',$defaultfontsize+1);
                        $pdf->Cell($w[0],$defaultfontheight,"Total",0,0,"L");
			$pdf->Cell($w[1],$defaultfontheight,$summaryamt,"B",0,"R");
                         $pdf->Line($marginx+$w[0],$pdf->GetY()+6,$marginx+$w[0]+$w[1]+$w[2],$pdf->GetY()+6);
		  break;
		  case "6L":
			$summaryamt=changeNegativeNumberFormat($totalliability*-1,2);
			$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");


		  break;



	  }

		$currentcategory =$classtype;
		$pdf->Ln(10);
	  }



	if($showzero == "on")
	$checkzero = 1;
	else
	$checkzero = $displayamt;


//	if(substr($displaytext,0,1) == "[" || $checkzero <> 0){
        if(($showplacefolderindicator==1 && $placeholder==1) || $checkzero <> 0){

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

	}

		//display summary for last row
                        $retainearning=$totalasset+$totalliability+$totalequity;
			$summaryamt=changeNegativeNumberFormat($retainearning,2);
			$pdf->Cell($w[0],$defaultfontheight,"  "."Retain Earning/(Loss)",0,0,"L");
			$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");
			//$pdf->Ln();
			$pdf->Ln();
			$pdf->SetFont($defaultfont,'B',$defaultfontsize+1);
			//$total=($totalliability+$totalequity)*-1;

//($totalequity)*(-1) -
			$pdf->SetX($marginx);
			 $pdf->Cell($w[0],$defaultfontheight,"Total",0,0,"L");
			 $pdf->Cell($w[1],$defaultfontheight,"".changeNegativeNumberFormat($totalasset,2)."","TB",0,"R");
		
			 $pdf->Line($marginx+$w[0],$pdf->GetY()+6,$marginx+$w[0]+$w[1]+$w[2],$pdf->GetY()+6);
                         $pdf->Ln();
	//$pdf->MultiCell(0,5,"$sql",1,"C");

	$pdf->Output("viewbalancesheet_singlecol.pdf","I");
	exit (1);

}

?>


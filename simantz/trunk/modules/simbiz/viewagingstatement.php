<?php
	include_once('../simantz/class/fpdf/fpdf.php');
	include_once "system.php";
	//include_once "../system/class/Organization.php";
	include_once "../simantz/class/Period.inc.php";
	include_once "../simantz/class/BPartner.php";
	include_once "class/Accounts.php";

	$org = new Organization();
	$bp = new BPartner();
	$acc = new Accounts();

   $header=array("CODE","NAME","5 MTHS","4 MTHS","3 MTHS","2 MTHS","1 MTHS","CURRENT","BALANCE","TELEPHONE");
   $header2=array("","","11 MTHS","10 MTHS","9 MTHS","8 MTHS","7 MTHS","6 MTHS","","");
   $w1=array(10,55,15,15,15,15,15,15,20,20);
   $w0=array(10,55,15,15,15,15,15,15,20,20);
   $periodamt=array(0,0,0,0,0,0);
   $papertype=array("A4","Letter");
   $aging_type=6;

   $datefrom="Unknown";
   $dateto="Unknown";
   $marginx=array(10,10);
   $marginy=array(10,10);
   $pageheaderheight=array(80,80);
   $pagefooterheight=array(53,53);
   $reversepagefooterheight=array(245,220);
   $agingboxwidth=array(31,31);
   $agingboxheight=array(12,12);

   $pagewidth=array(180,190);

   $tableheadertype="TB";
//   $orginfo_startx=array(60,60);
//   $orginfo_starty=array(10,10);
 

   $defaultfont="Times";
   $defaultfontsize="9";
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
   $tableheaderfontsize="8";
   $tableheaderfontstyle="B";
   $tableheaderheight="5";
   $tableheadertype="TLR";
   $tableheadertype2="BLR";
   $headeralign=array("L","L","C","C","C","C","C","C","R","C");

   $headerorgseparator=2; //Space below organization info


   $reporttitle = "Aging Report";
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

	global  $datefrom,$dateto, $w0,$w1, $header, $header2, $headeraccounts_code, $headeraccounts_name,  $ledgertitlefontname,  $ledgertitlefontsize,$headeralign,
		$ledgertitleheight,  $ledgertitlecolwidth,  $tableheaderfont,  $tableheaderfontsize, $tableheaderfontstyle,
		$tableheaderheight,  $tableheadertype,  $tableheadertype2, $datefrom,   $dateto,  $marginx,  $marginy,$pageheaderheight, $pagefooterheight,$aging_type,
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

	//display report name, and company name
	$this->SetFont($defaultfont,"BU",$defaultfontsize+2);
	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgcontactfontheight * 5 +$headerorgseparator);

	$this->SetXY($marginx[$statementpapersource],$marginy[$statementpapersource]+$orgcontactfontheight * 5 +$headerorgseparator);
	$this->Cell(0,$defaultfontheight,$reporttitle,0,1,'C');
	
	$this->SetFont($defaultfont,"",$defaultfontstyle);
	$this->Cell(170,$defaultfontheight,"Month: ",0,0,'R');
	$this->Cell(0,$defaultfontheight,$this->periodto,0,1,'L');
	$this->Cell(170,$defaultfontheight,"Statement Date:",0,0,'R');
	$this->Cell(0,$defaultfontheight,$this->dateto,0,1,'L');
//	$this->Cell(0,$defaultfontheight,date('Y',time()) . "-" .date('M',time()) . "-".date('d',time()),0,1,'R');
	$this->Cell(170,$defaultfontheight,"Page:",0,0,'R');
	$lastpage='/{nb}';
	$this->Cell(0,$defaultfontheight,"".$this->PageNo()."$lastpage",0,0,'L');
	$this->Ln(10);
	 

/*
	//switch back to standard font

	$this->Ln();
	$this->Cell(0,$defaultfontheight,$bp->bpartner_name ,0,0,'L');
	$this->Ln();
	$this->SetFont($defaultfont,"",$defaultfontstyle);
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
	$this->SetXY($marginx[$statementpapersource]+140, $currenty);
	//show Terms
	$this->Cell(0,$defaultfontheight,"Terms: $bp->terms_name",0,0,'L');
	$this->Ln();

	$currenty=$this->GetY();
	$this->Cell(0,$defaultfontheight,"$bp->bpartner_postcode $bp->bpartner_city, $bp->bpartner_state, $bp->bpartner_country_name" ,0,0,'L');
	$this->SetXY($marginx[$statementpapersource]+140, $currenty);
	//show Month

	$this->Cell(25,$defaultfontheight,"Month: ",0,0,'L');
	$this->Cell(0,$defaultfontheight,$this->periodto,0,0,'L');
	

	$this->Ln();

	if($bp->bpartner_tel_2!="" && $bp->bpartner_tel_2!="-" || $bp->bpartner_tel_2==" ")
	$bp->bpartner_tel_1="$bp->bpartner_tel_1/$bp->bpartner_tel_2";

	$currenty=$this->GetY();
	$this->Cell(0,$defaultfontheight,"Tel: $bp->bpartner_tel_1 Fax: $bp->bpartner_fax",0,0,'L');
	$this->SetXY($marginx[$statementpapersource]+140, $currenty);
	//show Month
	$this->Cell(25,$defaultfontheight,"Statement Date:",0,0,'L');
//	$this->Cell(0,$defaultfontheight,date('Y',time()) . "-" .date('M',time()) . "-".date('d',time()),0,0,'L');
	$this->Cell(0,$defaultfontheight,$this->dateto,0,0,'L');
	$this->Ln();
	$this->Cell(0,$defaultfontheight,"Business Partner No: $bp->bpartner_no",0,0,'L');
	$this->Ln();

*/




$i=0;
foreach($header as $col)
     	{
	$this->SetFont($tableheaderfont,$tableheaderfontstyle,$tableheaderfontsize); 
	
	if($i >= 0)
		if($statementpapersource==0)
	 	  	 $this->Cell($w0[$i],$tableheaderheight,$col,$tableheadertype,0,$headeralign[$i]);
		else
   			 $this->Cell($w1[$i],$tableheaderheight,$col,$tableheadertype,0,$headeralign[$i]);

	$i=$i+1;		
	}
	
	if($aging_type > 6){
	$this->Ln();
	$i=0;
foreach($header2 as $col)
     	{
	$this->SetFont($tableheaderfont,$tableheaderfontstyle,$tableheaderfontsize); 
	
	if($i >= 0)
		if($statementpapersource==0)
	 	  	 $this->Cell($w0[$i],$tableheaderheight,$col,$tableheadertype2,0,$headeralign[$i]);
		else
   			 $this->Cell($w1[$i],$tableheaderheight,$col,$tableheadertype2,0,$headeralign[$i]);

	$i=$i+1;		
	}
	}
	
    $this->Ln(5);
	

}


function Footer()
{
global $pagefooterheight,$statementpapersource,$pagewidth,$marginx,$agingboxwidth,$agingboxheight,
	$reversepagefooterheight,$defaultfontheight,$statementdescription,$periodamt,$aging_type;
global $tableheaderfont,  $tableheaderfontsize, $tableheaderfontstyle,
		$tableheaderheight,  $tableheadertype;
$timestamp= date("d/m/y H:i:s", time());
    //Position at 1.5 cm from bottom
  // $this->SetY(-1 * $pagefooterheight[$statementpapersource]);
   // $this->SetY($pagefooterheight[$statementpapersource] * -1);

	/*

    $this->Line($marginx[$statementpapersource],$reversepagefooterheight[$statementpapersource]-1,
			$pagewidth[$statementpapersource]+$marginx[$statementpapersource],$reversepagefooterheight[$statementpapersource]-1);


    $boxwidth=$agingboxwidth[$statementpapersource];
    $boxheight=$agingboxheight[$statementpapersource];

   	$this->SetXY($marginx[$statementpapersource],$reversepagefooterheight[$statementpapersource]-6 );


	if($this->printotal==true){
	$this->SetFont($tableheaderfont,$tableheaderfontstyle,$tableheaderfontsize);
	$this->Cell(140,$defaultfontheight,"TOTAL BALANCE ","T",0,"L");
	$this->Cell(50,$defaultfontheight,number_format($this->total_balance,2),"T",1,"R");
	}

    	$this->Cell(0,$defaultfontheight,"Outstanding Payment By Month",0,1,"L");

    $this->SetFont($defaultfont,"B",$defaultfontsize);

	if($aging_type == 6)
    $periodname=array("5 Months+","4 Month","3 Month","2 Month","1 Month","Current");
	else
    $periodname=array("11 Months+","10 Months","9 Month","8 Month","7 Month","6 Month","5 Months","4 Month","3 Month","2 Month","1 Month","Current");

//header aging
	$adjustParameter = 0;
	$height = 0;
    for($j=0;$j<$aging_type;$j++){

	if($j == 6){
	$adjustParameter = 1;
	$height = $boxheight-2;
	}else{
	$adjustParameter++;
	
	}

	$xpos=$marginx[$statementpapersource] + $boxwidth * ($adjustParameter-1);
	
	
   	    //$this->Rect($xpos,
		//$reversepagefooterheight[$statementpapersource] +$defaultfontheight*2-$adjustParameter,$boxwidth,$boxheight);
	    $this->SetXY($xpos,$reversepagefooterheight[$statementpapersource] + $defaultfontheight*2-3+$height-2);
	    $this->Cell($boxwidth, $defaultfontheight,$periodname[$j],"LRT",1,"L");
	    $this->SetXY($xpos,$reversepagefooterheight[$statementpapersource] + $defaultfontheight*3-3+$height-2);
	    $this->Cell($boxwidth, $defaultfontheight,number_format($periodamt[$j],2),"LRB",0,"R");
	

	}
	$this->Ln();

	$this->SetY($reversepagefooterheight[$statementpapersource] +$boxheight + $defaultfontheight*2 + 5-3);
	$this->MultiCell(0,$defaultfontheight,"$statementdescription",0,"L");
	*/
    
}

}

if ($_POST){


	
//	$pdf=new PDF('P','mm',$papertype[$statementpapersource]);  //0=A4,1=Letter
	$pdf=new PDF('P','mm',"Letter");  //0=A4,1=Letter
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,20 );

	
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
	$reporttype=$_POST['reporttype'];
	$aging_type=$_POST['aging_type'];
	//$aging_type=6;

	if($reporttype=='d'){
		$reporttitle = "DEBTORS AGING REPORT";
	}  else if($reporttype=='c'){

		$reporttitle = "CREDITORS AGING REPORT";
	}else{
		$reporttitle = "AGING REPORT";
	}
	
  	if($reporttype=='d'){
		$accounttype=2;//debtor
		$columnprefix="debtor";
	}  else{
		$accounttype=3;//creditor
		$columnprefix="creditor";
	} 
//	$periodfrom_id=2;
//	$periodto_id=2;	
	$period = new Period();

    
	
	$period->fetchPeriod($periodfrom_id);
	if(strlen($period->period_month)==1)
		$period->period_month="0".$period->period_month;
	$datefrom=$period->period_year."-".$period->period_month."-01";

	$period->fetchPeriod($periodto_id);
	if(strlen($period->period_month)==1)
		$period->period_month="0".$period->period_month;
	$dateto=$period->period_year."-".$period->period_month."-31";

	if($periodfrom_id == 0)
	$datefrom = "1000-01-01";

	if($periodto_id == 0)
	$dateto = "9999-12-31";

	$pdf->dateto=$dateto;

	if($periodto_id>0)
	$pdf->periodto=$period->period_year."-".$period->period_month;
	else
	$pdf->periodto="9999-12";
	

	$datecount=32;



	//$pdf->dateto = getMonth($pdf->periodto ."-01",1) ;
	$pdf->dateto = getMonth($period->period_year."".$period->period_month."01",1) ;
	$pdf->AddPage();

	$bpartner_array=$_POST['bpartner_array'];
	$checkbox_array=$_POST['checkbox_array'];
//	$bpartner_array=array(1,2,3,4,5,6,7,8,9,10);
	$bpartnercount=0;
	foreach ($bpartner_array as $bpartner_id ){
	
	  $bpartnercount++;
	  if($checkbox_array[$bpartnercount-1]=='on'){
	  $bp->fetchBPartner($bpartner_id);
	  $pdf->printotal=false;


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
	//get b/f balance
	$balanceamt=$acc->bPartnerBalanceBFAmount($periodfrom_id,$bpartner_id);

        $aging_type_ori = $_POST['aging_type'];

        $aging_type = 12;
        
	//start aging
	$amtcredit = 0;
	$totdebit = 0;
	for($j=0;$j<($aging_type);$j++){
	$amtaging = $acc->bPartnerAging($periodto_id,($aging_type-1)-$j,$bpartner_id);
	$amtdebit[$j] = $amtaging[0];
	$amtcreditrm[$j] = $amtaging[1];
	$amtcredit += $amtaging[1];
	$totdebit += $amtaging[0];
        
        //echo "credit :".$amtcreditrm[$j]." debit :".$amtdebit[$j]."<br>";
	}

	$amtcredit_f = $amtcredit;
	$totdebit_f = $totdebit;

	$balance_amt=0;
	$init_stat=0;
	for($j=0;$j<($aging_type);$j++){
	//$periodamt[$j]=$acc->bPartnerHistoryBalance($periodto_id,($aging_type-1)-$j,$bpartner_id);

	if($bp->isdebtor == 1){//start debtor
	if($amtcredit > 0){
	$diffaging=$amtcredit-$amtdebit[$j];

	//echo "$amtcredit-$amtdebit[$j] <br>";

		if($diffaging>=0){

			if($amtdebit[$j]>0){
				//if($amtcredit >= $amtdebit[$j])
				$periodamt[$j]=0;
				//else
				//$periodamt[$j]=$amtcredit-$amtdebit[$j];
				
			$init_stat=1;
			}else{
			
				if($totdebit>0){
					//if($init_stat==1)
					//$periodamt[$j]=-1*($amtcredit-$amtdebit[$j]);
					//else
					$periodamt[$j]=0;
				}else{
					$periodamt[$j]=$amtcreditrm[$j];
				}
			}

			$amtcredit= $amtcredit-$amtdebit[$j];


		}else{
			$periodamt[$j]=$amtdebit[$j]-$amtcredit;
			$amtcredit= 0;
		}

	}else{
		$periodamt[$j]=$amtdebit[$j];
		
	}

	

	}else{//end of debtor --> start creditor

	if($totdebit > 0){
	$diffaging=$totdebit-$amtcreditrm[$j];

	

		if($diffaging>=0){

			if($amtcreditrm[$j]>0){
				//if($totdebit >= $amtcreditrm[$j])
				$periodamt[$j]=0;
				//else
				//$periodamt[$j]=$totdebit-$amtcreditrm[$j];
				
			$init_stat=1;
			}else{
			
				if($amtcredit>0){
					//if($init_stat==1)
					//$periodamt[$j]=-1*($totdebit-$amtcreditrm[$j]);
					//else
					$periodamt[$j]=0;
				}else{
					$periodamt[$j]=$amtdebit[$j];
				}
			}

			$totdebit= $totdebit-$amtcreditrm[$j];


		}else{
			$periodamt[$j]=$amtcreditrm[$j]-$totdebit;
			$totdebit= 0;
		}

	}else{
		$periodamt[$j]=$amtcreditrm[$j];
		
	}

	


	}

	
	
	$balance_amt += $periodamt[$j];
	}
	//end aging

        //echo $aging_type;
	$lastperiodamt = $periodamt[$aging_type-1];
	if($bp->isdebtor == 1){//start debtor

            if(($init_stat==1 && $amtcredit_f>$totdebit_f))
            $periodamt[$aging_type-1]=-1*$amtcredit;
            $balance_amt += $periodamt[$aging_type-1]-$lastperiodamt;
            
	}else{

            if(($init_stat==1 && $amtcredit_f<$totdebit_f))
            $periodamt[$aging_type-1]=-1*$totdebit;
            $balance_amt += $periodamt[$aging_type-1]-$lastperiodamt;
	}
	
	$pdf->SetFont('Times','','9');
	
	//$balanceamt = $periodamt[0]+$periodamt[1]+$periodamt[2]+$periodamt[3]+$periodamt[4]+$periodamt[5]+$periodamt[6]+$periodamt[7]+$periodamt[8]+$periodamt[9]+$periodamt[10]+$periodamt[11];
	//$periodamt[0] = "128120.00";

        //echo $balance_amt;
	if($aging_type_ori == 6){

        /*
	$periodamt11 = "";
	$periodamt10 = "";
	$periodamt9 = "";
	$periodamt8 = "";
	$periodamt7 = "";
	$periodamt6 = "";
	$periodamt5 = number_format($periodamt[0],2);
	$periodamt4 = number_format($periodamt[1],2);
	$periodamt3 = number_format($periodamt[2],2);
	$periodamt2 = number_format($periodamt[3],2);
	$periodamt1 = number_format($periodamt[4],2);
	$periodamt0 = number_format($periodamt[5],2);
         * 
         */

        $last_total = $balance_amt - ($periodamt[7]+$periodamt[8]+$periodamt[9]+$periodamt[10]+$periodamt[11]);
        $periodamt11 = "";
        $periodamt10 = "";
        $periodamt9 = "";
        $periodamt8 = "";
        $periodamt7 = "";
        $periodamt6 = "";
        $periodamt5 = number_format($last_total,2);
        $periodamt4 = number_format($periodamt[7],2);
        $periodamt3 = number_format($periodamt[8],2);
        $periodamt2 = number_format($periodamt[9],2);
        $periodamt1 = number_format($periodamt[10],2);
        $periodamt0 = number_format($periodamt[11],2);
	}else{

        $last_total = $balance_amt - ($periodamt[1]+$periodamt[2]+$periodamt[3]+$periodamt[4]+$periodamt[5]+$periodamt[6]+$periodamt[7]+$periodamt[8]+$periodamt[9]+$periodamt[10]+$periodamt[11]);
	$periodamt11 = number_format($last_total,2);
	$periodamt10 = number_format($periodamt[1],2);
	$periodamt9 = number_format($periodamt[2],2);
	$periodamt8 = number_format($periodamt[3],2);
	$periodamt7 = number_format($periodamt[4],2);
	$periodamt6 = number_format($periodamt[5],2);
	$periodamt5 = number_format($periodamt[6],2);
	$periodamt4 = number_format($periodamt[7],2);
	$periodamt3 = number_format($periodamt[8],2);
	$periodamt2 = number_format($periodamt[9],2);
	$periodamt1 = number_format($periodamt[10],2);
	$periodamt0 = number_format($periodamt[11],2);
	}
	
	$pdf->total_balance += $balance_amt;
	$rowdata = array($bp->bpartner_no,$bp->bpartner_name,$periodamt5,$periodamt4,$periodamt3,$periodamt2,$periodamt1,$periodamt0,number_format($balance_amt,2),$bp->bpartner_tel_1);
	$rowdata2 = array("","",$periodamt11,$periodamt10,$periodamt9,$periodamt8,$periodamt7,$periodamt6,"","");
		
	if($pdf->y+10>$pdf->PageBreakTrigger && !$pdf->InFooter && $pdf->AcceptPageBreak())
	$pdf->AddPage($pdf->CurOrientation);
	
	$k=0;
	foreach ($rowdata as $c){
	
	if($c=="0.00" && $k < 8)
	$c = "-";
	while($pdf->GetStringWidth($c)> $w1[$k])
				$c=substr_replace($c,"",-1);
				
	if($statementpapersource==0)
		$pdf->Cell($w0[$k],$defaultfontheight,$c,$tableheadertype,0,$headeralign[$k]); //Print for a4
	else
		$pdf->Cell($w1[$k],$defaultfontheight,$c,$tableheadertype,0,$headeralign[$k]); // print for letter
	$k++;
	}
	$pdf->Ln();
	$k=0;
	foreach ($rowdata2 as $c){
	
	if($c=="0.00" && $k < 8)
	$c = "-";
	while($pdf->GetStringWidth($c)> $w1[$k])
				$c=substr_replace($c,"",-1);
				
	if($statementpapersource==0)
		$pdf->Cell($w0[$k],$defaultfontheight,$c,$tableheadertype2,0,$headeralign[$k]); //Print for a4
	else
		$pdf->Cell($w1[$k],$defaultfontheight,$c,$tableheadertype2,0,$headeralign[$k]); // print for letter
	$k++;
	}
	
	$pdf->Ln();
	

//	$pdf->MultiCell(0,5,$sql,1,'C');

	$pdf->printotal=true;
	

		
		}
	}


 	//total balance
	$pdf->SetFont('Times','B','8');
	$totalbal = array("","","","","","","","TOTAL",number_format($pdf->total_balance,2),"");
	$k=0;
	foreach ($totalbal as $c){
	
	if($c=="0.00" && $k < 8)
	$c = "-";
	while($pdf->GetStringWidth($c)> $w1[$k])
				$c=substr_replace($c,"",-1);
				
	if($statementpapersource==0)
		$pdf->Cell($w0[$k],$defaultfontheight,$c,$tableheadertype2,0,$headeralign[$k]); //Print for a4
	else
		$pdf->Cell($w1[$k],$defaultfontheight,$c,$tableheadertype2,0,$headeralign[$k]); // print for letter
	$k++;
	}
	//
		
	$pdf->Output("bpartnerstatement.pdf","I");
	exit (1);

}

?>


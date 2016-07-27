<?php
	include_once('../simantz/class/fpdf/fpdf.php');
	include_once "system.php";
        
	//include_once "../system/class/Organization.php";
	include_once "../simantz/class/Period.inc.php";
	include_once "../bpartner/class/BPartner.php";
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	$org = new Organization();
	$bp = new BPartner();
	$org->fetchOrganization($defaultorganization_id);
	$xmargin=15;
	if($_GET){
	$pdf=new FPDF('L','mm',"A5");  //0=A4,1=Letter
	$pdf->SetAutoPageBreak(true,5 );
	$paymentvoucher_id=$_REQUEST['paymentvoucher_id'];
	$sql="SELECT r.paymentvoucher_prefix,r.paymentvoucher_no,r.paymentvoucher_date,r.paidto,r.originalamt, r.description, r.chequeno, 			cur.currency_code,a2.account_type,rl.subject,rl.amt,  rl.description as linedesc,r.paidto,r.preparedby
	FROM $tablepaymentvoucher r 
	INNER JOIN $tablepaymentvoucherline rl on rl.paymentvoucher_id=r.paymentvoucher_id 
	INNER JOIN $tablecurrency cur on r.currency_id=cur.currency_id 
	INNER JOIN $tableaccounts a2 on a2.accounts_id=r.accountsfrom_id  
	where r.paymentvoucher_id=$paymentvoucher_id";

	$query=$xoopsDB->query($sql);
		if($row=$xoopsDB->fetchArray($query)){
			$paymentvoucher_no=$row['paymentvoucher_no'];
			$paymentvoucher_prefix=$row['paymentvoucher_prefix'];
			$paymentvoucher_date=$row['paymentvoucher_date'];
			$paidto=$row['paidto'];
			$originalamt=$row['originalamt'];
			$description=$row['description'];
			$chequeno=$row['chequeno'];
			$currency_code=$row['currency_code'];
			$account_type=$row['account_type'];
			$preparedby=$row['preparedby'];
			$paidto=$row['paidto'];
			//$=$row[''];
			//$=$row[''];

		
		}
	
		$pdf->AddPage();

	$timetext=time();
	
	$lastword=substr($timetext,-1,1);
	$j=0;
	$randomtext=rand(1,10);
	while($j<rand(1,10)){
	$lastword=$lastword.$randomtext;
	$j++;	
	}
	$pdf->Ln();
	$pdf->SetFont("Times","B",12);
	$pdf->SetXY($xmargin,10);
	//print transparent random text
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(0,10,"$timetext - $lastword",0,0,'C');

	//company name block (1)
	$pdf->SetXY($xmargin,10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(0,10,"$org->organization_name ($org->companyno)",0,0,'L');
	//$pdf->SetFont("Times","",10);
	//$pdf->Cell(0,12,"($org->companyno)",0,0,'L');
	$pdf->SetXY($xmargin,18);


	//organization contact info block (2)
	$orgadd1="$org->street1 $org->street2 $org->street3";
	
	$pdf->SetFont("Times","",8);
	$pdf->Cell(0,4,"$orgadd1 $org->postcode $org->city $org->state $org->country_name.",0,0,'L');
	
	$pdf->Ln();
	$pdf->SetX($xmargin);
	$pdf->Cell(0,4,"Tel: $org->tel_1 $org->tel2 Fax: $org->fax  Website: $org->url Email: $org->email",0,0,'L');

	//official paymentvoucher label block (3)
	$pdf->SetXY(160,8);
	$pdf->SetFont("Times","BU",14);
	$pdf->Cell(0,12,"Payment Voucher","",0,'L');


	//paymentvoucher no label block (4)
	$pdf->SetXY($xmargin+145,13);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(10,12,"No. :","",0,'L');
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(0,12,"$paymentvoucher_prefix$paymentvoucher_no","",0,'R');


	//paymentvoucher Date label block (5)
	$pdf->SetXY($xmargin+145,18);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(10,12,"Date :","",0,'L');
	$pdf->SetFont("times","B",10);
	$pdf->Cell(0,12,"$paymentvoucher_date","",0,'R');


	//paymentvoucher From label block (6)
	$pdf->SetXY($xmargin,30);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(30,12,"PAID TO :","",0,'L');
	$pdf->SetFont("Times","B",12);
	$pdf->Line($pdf->GetX(),$pdf->GetY()+9,$pdf->GetX()+155,$pdf->GetY()+9);
	$pdf->Cell(0,12,"$paidto","",0,'L');

	//paymentvoucher AMT in Text label block (7)
	$pdf->SetXY($xmargin,38);
	$pdf->SetFont("Times","",10);
	$pdf->Cell($xmargin+15,12,"THE SUM OF :","",0,'L');
	$pdf->Line($pdf->GetX(),$pdf->GetY()+9,$pdf->GetX()+155,$pdf->GetY()+9);
	//$pdf->Line($pdf->GetX(),86,$pdf->GetX()+150,86);
	$pdf->MultiCell(0,12,"$currency_code ".convertNumber($originalamt),"",'L');

	//paymentvoucher AMT in Text label block (8)
	$pdf->SetXY($xmargin,45);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(30,12,"DESCRIPTION :","",0,'L');
	$pdf->SetFont("Arial","",10);
	$pdf->Line($pdf->GetX(),$pdf->GetY()+9,$pdf->GetX()+155,$pdf->GetY()+9);
	$pdf->Line($pdf->GetX(),$pdf->GetY()+16,$pdf->GetX()+155,$pdf->GetY()+16);
	$pdf->MultiCell(0,10,"$description","",'L');

	//detail table
	$pdf->SetXY($xmargin,65);
	$pdf->SetFont("Times","B",8);
	$pdf->Cell(10,5,"No","TB",0,'C');
	$pdf->Cell(120,5,"Item","TB",0,'L');
	//$pdf->Cell(40,5,"Payment Method","TB",0,'C');
	$pdf->Cell(0,5,"Amount ($currency_code)","TB",1,'R');

	$query2=$xoopsDB->query($sql);
	$pdf->SetFont("Times","",9);
	$i=0;
	$m=0;
	//$maxy=0;
	$maxy=70;
	while($row=$xoopsDB->fetchArray($query2)){
	$i++;
	$m++;
	//$chequeno=$row['chequeno'];
	$pdf->SetY($maxy+2);
	$subject=$row['subject'];
	$amt=$row['amt'];
	$account_type=$row['account_type'];
	$linedesc=$row['linedesc'];
	if($account_type==4)
	$paymentmethodtext="Cheque :";
	else
	$paymentmethodtext="Cash";

	if($m > 13){
	$m=1;
	$pdf->AddPage($pdf->CurOrientation);
	}
	$pdf->SetX($xmargin);
	$pdf->Cell(10,4,$i,0,0,'C');
	$currentx=$pdf->getX();
	$currenty=$pdf->getY();
	$pdf->Cell(120,4,$subject,0,0,'L');

	if($linedesc!=""){
	$pdf->SetXY($currentx,$currenty+5);
	$pdf->MultiCell(0,4,"$linedesc","0",'L');
	//$pdf->Cell(40,4,$paymentmethodtext,0,0,'L');
	$maxy=	$pdf->getY();
	}
	else{
	$maxy=	$pdf->getY()+2;

	}
	$pdf->SetXY($currentx+120,$currenty);
	$pdf->Cell(0,4,$amt,0,1,'R');
	
	
	}

	
	//paymentvoucher AMT number in block (9)
	$pdf->SetXY($xmargin,120+5);
	$pdf->SetFont("Times","",14);
	$pdf->Cell(40,12,"$currency_code : $originalamt","",0,'L');
	$pdf->Line(10,$pdf->GetY()+9,$pdf->GetX()+30,$pdf->GetY()+9);
	$pdf->Line(10,$pdf->GetY()+10,$pdf->GetX()+30,$pdf->GetY()+10);
	$pdf->SetFont("Times","",8);
	$pdf->SetXY($xmargin,127+5);
	if($account_type==4)
	$paymentmethodtext="Cheque ($chequeno)";
	else
	$paymentmethodtext="Cash";
	$pdf->Cell(0,10,"Payment Method: $paymentmethodtext","",'L');



	//Prepared By (10)
	$pdf->SetXY($xmargin+85,120);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(40,12,"Prepared By:","",0,'L');
//	$pdf->Line(10,$pdf->GetY()+9,$pdf->GetX()+30,$pdf->GetY()+9);
	$pdf->Line(100,135,140,135);
	$pdf->SetXY($xmargin+85,131);
       $pdf->SetFont("Times","",8);
       $pdf->Cell(40,12,$preparedby,"",0,'L');

 	$pdf->SetXY($xmargin+135,120);
        $pdf->SetFont("Times","",10);
        $pdf->Cell(40,12,"Received By:","",0,'L');
//      $pdf->Line(10,$pdf->GetY()+9,$pdf->GetX()+30,$pdf->GetY()+9);
        $pdf->Line(150,135,200,135);
 	$pdf->SetXY($xmargin+135,131);
       $pdf->SetFont("Times","",8);
       $pdf->Cell(40,12,$paidto,"",0,'L');

	//$pdf->Ln(10);
	//$pdf->MultiCell(0,10,"$sql","",'L');




	$pdf->Output("bpartnerstatement.pdf","I");
	exit (1);
	}


?>

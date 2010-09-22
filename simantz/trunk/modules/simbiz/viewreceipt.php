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
	if($_POST || $_GET){
	$pdf=new FPDF('L','mm',"A5");  //0=A4,1=Letter
	$pdf->SetAutoPageBreak(true,10 );

	if(is_array($_POST['receipt_idarr'])){

		$receipt_idarr=$_POST['receipt_idarr'];
		$isselect=$_POST['isselect'];
		
	}else{

		if(isset($_POST['receipt_id']))
		$receipt_id=$_POST['receipt_id'];
		if(isset($_GET['receipt_id']))
		$receipt_id=$_GET['receipt_id'];

		$receipt_idarr = array(1=>$receipt_id);
		$isselect = array(1=>"on");

	}


	$i=0;
	foreach($receipt_idarr as $receipt_id){
	$i++;
	$ischecked = $isselect[$i];

	if($ischecked == "on"){

	$sql="SELECT r.receipt_prefix,r.receipt_no,r.receipt_date,r.paidfrom,r.originalamt, r.description, rl.chequeno, cur.currency_code,
	a.account_type,rl.subject,rl.amt 
	FROM $tablereceipt r 
	INNER JOIN $tablereceiptline rl on rl.receipt_id=r.receipt_id 
	INNER JOIN $tablecurrency cur on r.currency_id=cur.currency_id 
	INNER JOIN $tableaccounts a on a.accounts_id=rl.accounts_id 
	where r.receipt_id=$receipt_id";

	$query=$xoopsDB->query($sql);
		if($row=$xoopsDB->fetchArray($query)){
			$receipt_no=$row['receipt_no'];	
			$receipt_prefix=$row['receipt_prefix'];
			$receipt_date=$row['receipt_date'];
			$paidfrom=$row['paidfrom'];
			$originalamt=$row['originalamt'];
			$description=$row['description'];
			$chequeno=$row['chequeno'];
			$currency_code=$row['currency_code'];
			$account_type=$row['account_type'];
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
	$pdf->SetXY(10,10);
	//print transparent random text
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(0,10,"$timetext - $lastword",0,0,'C');

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

	//official receipt label block (3)
	$pdf->SetXY(160,8);
	$pdf->SetFont("Times","BU",14);
	$pdf->Cell(0,12,"Official Receipt","",0,'L');

//paymentvoucher no label block (4)
	$pdf->SetXY($xmargin+145,13);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(10,12,"No. :","",0,'L');
	$pdf->SetFont("Times","B",10);
	$pdf->Cell(0,12,"$receipt_prefix$receipt_no","",0,'R');


	//paymentvoucher Date label block (5)
	$pdf->SetXY($xmargin+145,18);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(10,12,"Date :","",0,'L');
	$pdf->SetFont("times","B",10);
	$pdf->Cell(0,12,"$receipt_date","",0,'R');
	

	//Receipt From label block (6)
	$pdf->SetXY(10,30); // ori Y=60
	$pdf->SetFont("Times","",10);
	$pdf->Cell(40,12,"Received From :","",0,'L');
	$pdf->SetFont("Times","B",10);
	$pdf->Line($pdf->GetX(),$pdf->GetY()+9,$pdf->GetX()+150,$pdf->GetY()+9);
	$pdf->Cell(0,12,"$paidfrom","",0,'L');

	//Receipt AMT in Text label block (7)
	$pdf->SetXY(10,38);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(40,12,"The Sum Of :","",0,'L');
	$pdf->SetFont("Times","",10);
	$pdf->Line($pdf->GetX(),$pdf->GetY()+9,$pdf->GetX()+150,$pdf->GetY()+9);
	//$pdf->Line($pdf->GetX(),86,$pdf->GetX()+150,86);

	//echo ucwords("SAAAS SDA asDDS");
	$txt_sum = ucwords(strtolower(convertNumber($originalamt)));
	$pdf->MultiCell(0,10,$currency_code." ".$txt_sum,"",'L');

	//Receipt AMT in Text label block (8)
	$pdf->SetXY(10,45);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(40,10,"Description :","",0,'L');
	$pdf->SetFont("Times","",10);
	
        $pdf->Line($pdf->GetX(),53,$pdf->GetX()+150,53);
	$pdf->Line($pdf->GetX(),61,$pdf->GetX()+150,61);
        $pdf->MultiCell(0,8,$description,"",'L');
	//detail table
	$pdf->SetXY(10,65);
	$pdf->SetFont("Times","B",8);
	$pdf->Cell(10,5,"No","TB",0,'C');
	$pdf->Cell(90,5,"Item","TB",0,'L');
	$pdf->Cell(40,5,"Payment Method","TB",0,'C');
	$pdf->Cell(0,5,"Amount ($currency_code)","TB",1,'R');

	$query2=$xoopsDB->query($sql);
	$pdf->SetFont("Times","",9);
	$i=0;
	$m=0;
	while($row=$xoopsDB->fetchArray($query2)){
	$i++;
	$m++;
	$chequeno=$row['chequeno'];
	$subject=$row['subject'];
	$amt=$row['amt'];
	$account_type=$row['account_type'];

	if($account_type==4)
	$paymentmethodtext="Cheque :";
	else
	$paymentmethodtext="Cash";

	if($m > 13){
	$m=1;
	$pdf->AddPage($pdf->CurOrientation);
	}

//	$k=0;
//	while($k<2){
	$pdf->Cell(10,4,$i,0,0,'C');
	$pdf->Cell(90,4,$subject,0,0,'L');
	$pdf->Cell(40,4,$paymentmethodtext." ".$chequeno,0,0,'L');
	$pdf->Cell(0,4,$amt,0,1,'R');
//	$k++;
//	}
	
	
	}

	//Receipt AMT number in block (9)
	$pdf->SetXY(10,120+5);
	$pdf->SetFont("Times","",12);
	$pdf->Cell(40,12,"$currency_code : $originalamt","",0,'L');
	$pdf->Line(10,$pdf->GetY()+9,$pdf->GetX()+30,$pdf->GetY()+9);
	$pdf->Line(10,$pdf->GetY()+10,$pdf->GetX()+30,$pdf->GetY()+10);
	$pdf->SetFont("Times","",8);
	$pdf->SetXY(10,127);
	/*
	if($account_type==4)
	$paymentmethodtext="Cheque";
	else
	$paymentmethodtext="Cash";
	$pdf->Cell(0,10,"Payment Method: $paymentmethodtext","",'L');
	*/

	
	
	//Prepared By (10)
	$pdf->SetXY(120,110+5);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(40,12,"Prepared By:","",0,'L');
//	$pdf->Line(10,$pdf->GetY()+9,$pdf->GetX()+30,$pdf->GetY()+9);
	$pdf->Line(120,$pdf->GetY()+20,180,$pdf->GetY()+20);


	
	}//if checked
	}//end of array

	//$pdf->Ln();
	//$pdf->MultiCell(0,10,"$receipt_idarr","",'L');


	$pdf->Output("bpartnerstatement.pdf","I");
	exit (1);
	}


?>

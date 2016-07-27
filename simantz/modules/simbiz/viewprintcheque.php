<?php
	include_once('../simantz/class/fpdf/fpdf.php');
	include_once "system.php";
	//include_once "../system/class/Organization.php";
	include_once "../simantz/class/Period.inc.php";
	include_once "../simantz/class/BPartner.php";
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	$org = new Organization();
	$bp = new BPartner();
	$org->fetchOrganization($defaultorganization_id);

	if(isset($_POST["submit"])){
	$pdf=new FPDF('P','mm',array(175,90));  //0=A4,1=Letter
//$pdf=new FPDF('P','mm',"A4");  //0=A4,1=Letter
	//$pdf->SetAutoPageBreak(true,10 );
	$pdf->AddPage();
	$paymentvoucher_id=$_POST['paymentvoucher_id'];
	$sql="SELECT r.paymentvoucher_no,r.paymentvoucher_date,r.paidto,r.originalamt, r.description, r.chequeno, cur.currency_code,
	a.account_type
	FROM $tablepaymentvoucher r 
	INNER JOIN $tablecurrency cur on r.currency_id=cur.currency_id 
	INNER JOIN $tableaccounts a on a.accounts_id=r.accountsto_id 
	where r.paymentvoucher_id=$paymentvoucher_id";

	$query=$xoopsDB->query($sql);
		if($row=$xoopsDB->fetchArray($query)){
			$paymentvoucher_no=$row['paymentvoucher_no'];	
			$paymentvoucher_date=$row['paymentvoucher_date'];
			$paidto=$row['paidto'];
			$originalamt=$row['originalamt'];
			$description=$row['description'];
			$chequeno=$row['chequeno'];
			$currency_code=$row['currency_code'];
			$account_type=$row['account_type'];
			//$=$row[''];
			//$=$row['']
		
		}
	
	$timetext=time();
	
	$lastword=substr($timetext,-1,1);
	$j=0;
	$randomtext=rand(1,10);
	while($j<rand(1,10)){
	$lastword=$lastword.$randomtext;
	$j++;	
	}
	$pdf->SetFont("Times","",12);
	$pdf->SetXY(10,10);
	//print transparent random text
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(0,10,"$timetext $lastword",0,0,'C');

	//company name block (1)
	$pdf->SetXY(10,11);
	$pdf->SetTextColor(0,0,0);
	//paymentvoucher Date label block (5)
//	$pdf->SetXY(10,10);
//	$pdf->SetFont("Arial","B",14);
	
	$day=substr($paymentvoucher_date,-2,2);

	$month=substr($paymentvoucher_date, -5,2);
	$year=substr($paymentvoucher_date,2,2);
	$pdf->SetXY(132,18);
	$pdf->SetFont("Arial","B",20);
	$pdf->Cell(12,12,$day,"",0,'R');
	$pdf->Cell(12,12,$month,"",0,'R');
	$pdf->Cell(12,12,$year,"",0,'R');


	//paymentvoucher From label block (6)
	$pdf->SetXY(23,28);
	$pdf->SetFont("Times","",10);
	$pdf->Cell(95,10,"$paidto","",0,'L');

	//paymentvoucher AMT in Text label block (7)
	$pdf->SetXY(23,39);
	$pdf->SetFont("Times","",10);
	$pdf->MultiCell(95,9,convertNumber($originalamt) . "------","",'L');

	//paymentvoucher AMT number in block (9)
	$pdf->SetXY(130,39);
	$pdf->SetFont("Times","B",15);
	$pdf->Cell(30,12,"$originalamt","",0,'R');
	//$pdf->AddPage();


	$pdf->Output("bpartnerstatement.pdf","I");
	exit (1);
	}


?>
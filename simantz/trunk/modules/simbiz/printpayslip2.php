<?php
include_once('../../class/fpdf/fpdf.php');
include_once "system.php";
//include_once "menu.php";


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class PDF extends FPDF
{
  public $employee_no="Unknown";
  public $employee_name="Unknown";

  public $payslipdate="Unknown";

  public $endreport='N';
  public $jpn_no;
  public $rob_no;
  public $organization_name;
  public $street1;
  public $street2;
  public $city;
  public $description;
  public $postcode;
  public $state;
  public $country;
  public $no;
  public $employee_epfno;
  public $employee_socsono;
  public $tel_1;
  public $tel_2;
  public $fax;
  public $cur_name;
  public $cur_symbol;
  public $totalincomeamt;
  public $totaldeductamt;
  public $netpayamt;
  public $columnwidth=63;
  public $headerheight=6;
  public $itemheight=5;
  public $startypos=40;
  public $startxpos=10;
  public $containheight=55;
  public $descriptionheight=15;

function Header()
{
	$x1startpos=10;
	$x2startpos=90;
	$x3startpos=150;
	$ystartpos=27;
   // $this->Image('./images/simonlogobk.jpg', 11 , 6 , 90 , '' , 'JPG' , 'payment.php');
	$this->Image('../../images/logo.jpg',10,10,15,'','JPG','payslip.php');
	$this->SetFont('Times','B',15);
	$this->setXY(30,11);
	$this->Cell(93,8,$this->organization_name,0,0,'L');


	$this->SetFont('Times','',7);
	$this->setXY(30,16);

	$this->Cell(93,8,"$this->street1 $this->street2 $this->street3 $this->postcode $this->city  $this->state_i.  Tel: $this->tel_1, ".
	"Fax: $this->fax",0,0,'L');
	$this->setXY(105,14);
	//$this->MultiCell(90,4,"$this->jpn_no   $this->rob_no",0,'L');


	$this->SetFont('Times','',9);
	$this->setXY($x1startpos, $ystartpos);

	$this->MultiCell(180,4,"Emp EE#/Name   : $this->employee_name ($this->employee_no)",0,'L');
	$this->MultiCell(180,4,"Department          : $this->department",0,'L');
	$this->MultiCell(180,4,"Position                : $this->position",0,'L');

	$this->setXY(175,11);
	$this->SetFont('Times','B',20);
	$this->Cell(70,7,"Payslip",0,0,'L',0,"listpayslip.php");
	$this->SetFont('Times','',9);

	$this->setXY($x2startpos,$ystartpos);
	$this->MultiCell(70,4,"Paid Date         : " . $this->payslipdate  ,0,'L');
	$this->setX($x2startpos);
	$this->MultiCell(70,4,"IC No               : " . $this->employee_newicno  ,0,'L');
	$this->setX($x2startpos);
	$this->MultiCell(70,4,"Date From/To  :  $this->datefrom / $this->dateto"  ,0,'L');

	$this->setXY($x3startpos,$ystartpos);
	$this->MultiCell(70,4,"EPF No          : " . $this->employee_epfno  ,0,'L');
	$this->setX($x3startpos);
	$this->MultiCell(70,4,"Socso No       : " . $this->employee_socsono  ,0,'L');
//	$this->setX($x3startpos);
//	$this->MultiCell(70,4,"Date From/To  :  $this->datefrom / $this->dateto"  ,0,'L');


	$columnwidth=$this->columnwidth;
	$headerheight=$this->headerheight;
	$startypos=$this->startypos;
	$startxpos=$this->startxpos;
	$containheight=$this->containheight;
	$this->Rect($startxpos, $startypos,$columnwidth,$headerheight );
	$this->Rect($startxpos + $columnwidth, $startypos,$columnwidth,$headerheight );
	//$this->Rect($columnwidth *2 +$startxpos, $startypos,$columnwidth,$headerheight );

	//$this->Rect($startxpos, $headerheight+$startypos,$columnwidth,$containheight );
	//$this->Rect($startxpos+$columnwidth, $headerheight+$startypos,$columnwidth,$containheight );
	//$this->Rect($startxpos+$columnwidth * 2, $headerheight+$startypos,$columnwidth,$containheight );

	$this->setXY($startxpos,$startypos);
	$this->SetFont('Times','B',10);
	$this->Cell($columnwidth + $columnwidth,$headerheight,"INCOME",0,0,'C',0);
	//$this->Cell($columnwidth,$headerheight,"INCO",0,0,'C',0);
	//$this->Cell($columnwidth,$headerheight,"Total",0,0,'C',0);
        $this->Cell($columnwidth,$headerheight,"",0,1,'C',0);
        //$this->Cell($columnwidth + $columnwidth,$headerheight + 45,"INCOME",1,1,'C',0);
        $this->Rect($startxpos+$columnwidth, $headerheight+40,$columnwidth,$containheight -4 );
        $this->Rect($startxpos+$columnwidth * 2, $headerheight+$startypos,$columnwidth,$containheight -4);
	$this->Cell($columnwidth,$headerheight + 45,"DEDUCTION",1,1,'C',0);
        $this->Rect($startxpos+$columnwidth, $headerheight+40,$columnwidth,$containheight+50 -3 );
        $this->Rect($startxpos+$columnwidth * 2, $headerheight+$startypos,$columnwidth,$containheight+50-3 );
	$this->Cell($columnwidth,$headerheight + 45,"NET PAY",1,1,'C',0);
        $this->Rect($startxpos+$columnwidth, $headerheight+40,$columnwidth,$containheight+100-2);
        $this->Rect($startxpos+$columnwidth * 2, $headerheight+$startypos,$columnwidth,$containheight+100-2 );
        
        
        

//	$this->Rect($startxpos, $containheight+$headerheight+$startypos,$columnwidth,$headerheight );
//	$this->Rect($startxpos + $columnwidth, $containheight+$headerheight+$startypos,$columnwidth,$headerheight );
//	$this->Rect($columnwidth *2 +$startxpos, $containheight+$headerheight+$startypos,$columnwidth,$headerheight );

//	$this->setXY($startxpos, $containheight+$headerheight+$startypos);
//	$this->SetFont('Times','B',10);
//	$this->Cell($columnwidth,$headerheight,"Total Income : $this->totalincomeamt",0,0,'R',0);
//	$this->Cell($columnwidth,$headerheight,"Total Deduct : $this->totaldeductamt",0,0,'R',0);
//	$this->Cell($columnwidth,$headerheight,"Net Pay : $this->netpayamt",0,0,'R',0);

	$this->SetFont('Times','',8);
	//$this->Rect($startxpos, $containheight+ 2* $headerheight+$startypos+2,
	//		$columnwidth*3,$this->descriptionheight );
	$this->setXY($startxpos, $containheight+ 2* $headerheight+$startypos+2);
	$this->MultiCell($columnwidth*3, $this->itemheight-1, $this->description,0,'L' );
	$this->setXY($startxpos, $containheight +
		2* $headerheight+$startypos+2 + $this->descriptionheight+ $this->itemheight *30 -2);
	$this->MultiCell($columnwidth*3, $this->itemheight ,

		"..............................................                ".
		"..............................................",0,'L' );
	$this->MultiCell($columnwidth*3, $this->itemheight,

		"Confirm By:                                           ".
		"Received By:",0,'L' );


} //end of Header

function incometable($data){
$startxpos=$this->startxpos;
$startypos=$this->startypos+$this->headerheight;
$columnwidth=$this->columnwidth;
$itemheight=$this->itemheight;
$this->setXY($startxpos,$startypos);
$w=array(5,40,18);
$i=0;
$j=0;
$this->SetFont('Times','',9);
foreach($data as $row){
$i=0;
$curxpos=$startxpos;

  foreach($row as $col){
	while($this->GetStringWidth($col)>$w[$i])
		$col=substr_replace($col,"",-1);

	if($i==0)
		$alignment="C";
	elseif($i==1)
		$alignment="L";
	else
		$alignment="R";
	if($i==0)
	$this->setX($curxpos);
	$this->Cell($w[$i],$itemheight,$col,0,0,$alignment);


	$i++;

   }
$j++;
$this->Ln();
 }
}

function deducttable($data){
$columnwidth=$this->columnwidth;
$startxpos=$this->startxpos+$columnwidth;
$startypos=$this->startypos+$this->headerheight;
$curxpos=$startxpos;
$itemheight=$this->itemheight;
$this->setXY($startxpos,$startypos);
$w=array(5,40,18);
$i=0;
$j=0;
$this->SetFont('Times','',9);
foreach($data as $row){
$i=0;
  foreach($row as $col){
	while($this->GetStringWidth($col)>$w[$i])
		$col=substr_replace($col,"",-1);

	if($i==0)
		$alignment="C";
	elseif($i==1)
		$alignment="L";
	else
		$alignment="R";

	if($i==0)
	$this->setX($curxpos);
	$this->Cell($w[$i],$itemheight,$col,0,1,$alignment);
	$i++;

   }
$j++;
$this->Ln();
 }
}

function othertable($data){
$columnwidth=$this->columnwidth;
$startxpos=$this->startxpos+$columnwidth*2;
$startypos=$this->startypos+$this->headerheight;
$curxpos=$startxpos;
$itemheight=$this->itemheight;
$this->setXY($startxpos,$startypos);
$w=array(5,40,18);
$i=0;
$j=0;
$this->SetFont('Times','',9);
foreach($data as $row){
$i=0;
  foreach($row as $col){
	while($this->GetStringWidth($col)>$w[$i])
		$col=substr_replace($col,"",-1);

	if($i==0)
		$alignment="C";
	elseif($i==1)
		$alignment="L";
	else
		$alignment="R";

	if($i==0)
	$this->setX($curxpos);
	$this->Cell($w[$i],$itemheight,$col,0,0,$alignment);
	$i++;

   }
$j++;
$this->Ln();
 }
}


}

$payment_id=0;

if(isset($_POST['payslip_id'])){
$payslip_id=$_POST['payslip_id'];

}

if(isset($_GET['payslip_id']) )  {
$payslip_id=$_GET['payslip_id'];

}

/*$tableprefix= XOOPS_DB_PREFIX . "_";
$tableemployee=$tableprefix ."simtrain_employee";
$tablepayslipline=$tableprefix ."simtrain_payslipline";
$tablepayslip=$tableprefix ."simtrain_payslip";
$tableorganization= $tableprefix . "simtrain_organization";
$tableperiod=$tableprefix."simtrain_period";
$tableaddress=$tableprefix."simtrain_address";*/

	//$pdf=new PDF('P','mm','a4');
	//$pdf=new PDF('L','mm', array(90,200));
$pdf=new PDF('P','mm', 'A4');
	//$pdf->AddPage();
	$pdf->SetAutoPageBreak(false ,10);
	$pdf->AliasNbPages();
	$pdf->SetFont('Arial','',10);
	$pdf->cur_name=$cur_name;
	$pdf->cur_symbol=$cur_symbol;
	$sql="SELECT p.payslip_id,e.employee_id, e.employee_no, e.employee_name, e.employee_newicno, e.employee_hpno, e.permanent_telno as tel,
		p.department, p.position, p.datefrom, p.dateto, p.payslipdate, period.period_name,
		p.basicsalary, commissionamt, hourlycommisionamt,employee_epfamt,e.employee_epfno,e.employee_socsono,
		employee_socsoamt,employee_pcbamt,totalincomeamt,totaldeductamt,netpayamt,epfbaseamt,socsobaseamt,
		employer_epfamt,employer_socsoamt, o.organization_name, o.tel_1, o.tel_2, o.fax, o.city,
		o.street1, o.street2, o.street3, o.state as state_i, o.postcode, o.country_id,p.description,p.iscomplete
		FROM $tablepayslip p
		INNER JOIN $tableemployee e on e.employee_id = p.employee_id
		INNER JOIN $tableperiod period on period.period_id = p.period_id
		INNER JOIN $tableorganization o on o.organization_id = e.organization_id
		WHERE p.payslip_id=$payslip_id";
	$query=$xoopsDB->query($sql);
	$organization_id=0;
	if($rowheader=$xoopsDB->fetchArray($query)){
		$iscomplete=$rowheader['iscomplete'];
		//if($iscomplete=='N')
 		//	redirect_header("payslip.php?action=edit&payslip_id=$payslip_id",$pausetime,"This payslip not yet complete, redirect to the payslip.");
		$pdf->organization_name=$rowheader['organization_name'];
		$pdf->employee_no=$rowheader['employee_no'];
		$pdf->employee_name=$rowheader['employee_name'];
		$pdf->employee_newicno=$rowheader['employee_newicno'];
		$pdf->tel_1=$rowheader['tel_1'];
		$pdf->department=$rowheader['department'];
		$pdf->position=$rowheader['position'];
		$pdf->datefrom=$rowheader['datefrom'];
		$pdf->employee_epfno=$rowheader['employee_epfno'];
		$pdf->employee_socsono=$rowheader['employee_socsono'];
		$pdf->dateto=$rowheader['dateto'];
		$pdf->payslipdate=$rowheader['payslipdate'];
		$pdf->period_name=$rowheader['period_name'];

		$pdf->postcode=$rowheader['postcode'];
		$pdf->city=$rowheader['city'];
		$pdf->street1=$rowheader['street1'];
		$pdf->street2=$rowheader['street2'];
		$pdf->street3=$rowheader['street3'];
		$pdf->state_i=$rowheader['state_i'];
		$pdf->country_id=$rowheader['country_id'];
		//$pdf->rob_no=$rowheader['rob_no'];
		//$pdf->jpn_no=$rowheader['jpn_no'];
		$pdf->tel=$rowheader['tel'];
		//$pdf->tel_2=$rowheader['tel_2'];
		$pdf->fax=$rowheader['fax'];
		$pdf->description =$rowheader['description'];


		$basicsalary=$rowheader['basicsalary'];
		$commissionamt =$rowheader['commissionamt'];
		$hourlycommisionamt =$rowheader['hourlycommisionamt'];
		$employee_epfamt =$rowheader['employee_epfamt'];
		$employee_socsoamt =$rowheader['employee_socsoamt'];
		$employee_pcbamt =$rowheader['employee_pcbamt'];
		$pdf->totalincomeamt =$rowheader['totalincomeamt'];
		$pdf->totaldeductamt =$rowheader['totaldeductamt'];
		$pdf->netpayamt =$rowheader['netpayamt'];
		$epfbaseamt =$rowheader['epfbaseamt'];
		$socsobaseamt =$rowheader['socsobaseamt'];
		$employer_epfamt =$rowheader['employer_epfamt'];
		$employer_socsoamt =$rowheader['employer_socsoamt'];
	}
	$dataincome=array();
	$datadeduct=array();
	$dataother=array();
	$pdf->AddPage();
	$no=0;
	if($basicsalary!=0)
	$dataincome[]=array(++$no.")","Basic Salary",$basicsalary);
	if($commissionamt!=0)
	$dataincome[]=array(++$no.")","Commission Amount",$commissionamt);
	if($hourlycommisionamt!=0)
	$dataincome[]=array(++$no.")","Hourly Commission",$hourlycommisionamt);

	$sqlincome="SELECT payslipline_id, seqno, description, amount, linetype, iscalc_epf,
		iscalc_socso FROM $tablepayslipline where payslip_id=$payslip_id AND linetype=1
		order by seqno";


	$queryincome=$xoopsDB->query($sqlincome);

	while($row=$xoopsDB->fetchArray($queryincome)){
		$seqno = $row['seqno'];
		$description = $row['description'];
		$amount = $row['amount'];
	if($amount!=0)
		$dataincome[]=array(++$no.")",$description,$amount);
	}
	$pdf->incometable($dataincome);

	$sqldeduct="SELECT payslipline_id, seqno, description, amount, linetype, iscalc_epf,
		iscalc_socso FROM $tablepayslipline where payslip_id=$payslip_id AND linetype=-1
		order by seqno";


	$querydeduct=$xoopsDB->query($sqldeduct);
	$no=0;
	while($row=$xoopsDB->fetchArray($querydeduct)){

		$seqno = $row['seqno'];
		$description = $row['description'];
		$amount = $row['amount'];
	if($amount!=0)
		$datadeduct[]=array(++$no.")",$description,$amount);
	}
	if($employee_epfamt!=0)
	$datadeduct[]=array(++$no.")","EPF For Employee",$employee_epfamt);
	if($employee_socsoamt!=0)
	$datadeduct[]=array(++$no.")","Socso For Employee",$employee_socsoamt);
	if($employee_pcbamt!=0)
	$datadeduct[]=array(++$no.")","PCB For Employee",$employee_pcbamt);
	$pdf->deducttable($datadeduct);

	$no=0;
	if($employer_epfamt!=0)
	$dataother[]=array(++$no.")","Employer Contribute EPF",$employer_epfamt);
	if($employer_socsoamt!=0)
	$dataother[]=array(++$no.")","Employer Contribute Socso",$employer_socsoamt);
	if($epfbaseamt!=0)
	$dataother[]=array(++$no.")","EPF Base",$epfbaseamt);
	if($socsobaseamt!=0)
	$dataother[]=array(++$no.")","Socso Base",$socsobaseamt);
	$sqlother="SELECT payslipline_id, seqno, description, amount, linetype, iscalc_epf,
		iscalc_socso FROM $tablepayslipline where payslip_id=$payslip_id AND linetype=0
		order by seqno";


	$queryother=$xoopsDB->query($sqlother);

	while($row=$xoopsDB->fetchArray($queryother)){

		$seqno = $row['seqno'];
		$description = $row['description'];
		$amount = $row['amount'];
	if($amount!=0)
		$dataother[]=array(++$no.")",$description,$amount);
	}

	$pdf->othertable($dataother);
	//$pdf->Header();


	$queryLineClass=$xoopsDB->query($sqlpaymentlineclass);
	while($rowLineClass=$xoopsDB->fetchArray($queryLineClass))
		$pdf->BasicTable($rowLineClass,0);


	$queryLineProduct=$xoopsDB->query($sqlpaymentlineproduct);
	while($rowLineProduct=$xoopsDB->fetchArray($queryLineProduct))
		$pdf->BasicTable(array($rowLineProduct['product_no'],'',$rowLineProduct['qty'] . " units ".
 			$rowLineProduct['product_name'] . " " . $rowLineProduct['linedescription'] . " ",
			' ', '','',$rowLineProduct['amt'],''));
	$pdf->endreport='Y';
	//
	//$pdf->setXY(20,40);

	//$pdf->Ln();
	//$pdf->MultiCell(150,3,"$sql",0,'L');
	//display pdf
	$pdf->Output();
	exit (1);

?>
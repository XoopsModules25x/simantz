<?php
//include_once('fpdf/fpdf.php'); //
include_once('fpdf/chinese-unicode.php');
include_once "system.php";
//include_once "menu.php";


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class PDF extends PDF_Unicode
{
  public $student_code="Unknown";
  public $student_name="Unknown"; 
  public $receipt_no="Unknown";
  public $payment_datetime="Unknown";
  public $returnamt="Unknown";
  public $alternate_name="Unknown";
  public $outstandingamt="Unknown";
  public $receivedamt="Unknown";
  public $amt="Unknown";
  public $description="Unknown";
  public $uname="Unknown";
  public $endreport='N';
  public $jpn_no;
  public $rob_no;
  public $organization_name;
  public $street1;
  public $street2;
  public $city;
  public $postcode;
  public $state;
  public $country;
  public $no;
  public $tel_1;
  public $tel_2;
  public $fax;
  public $cur_name;
  public $cur_symbol;

function Header()
{
   // $this->Image('./images/simonlogobk.jpg', 11 , 6 , 90 , '' , 'JPG' , 'payment.php');
	$this->Image('upload/images/logobk.jpg',10,10,20,'','JPG','payment.php');
	$this->SetFont('Times','B',18);
	$this->setXY(30,11);
	$this->Cell(93,8,$this->organization_name,0,0,'L');


	$this->SetFont('Times','',7);
	$this->setXY(30,16);
				
	$this->Cell(93,8,"$this->no, $this->street1,$this->street2 $this->postcode $this->city, $this->state. Tel: $this->tel_1, ".
	"$this->tel_2 Fax: $this->fax",0,0,'L');
	$this->setXY(120,14);
	$this->MultiCell(120,4,"$this->jpn_no   $this->rob_no",0,'L');
	

	$this->SetFont('Times','',12);
	$this->setXY(10,25);
	$this->MultiCell(180,5,"Student Name: ",0,'L');	
	$this->SetFont('Times','B',12);	
	$this->setXY(40,25);
	$namewith=$this->GetStringWidth($this->student_name);
	$this->Cell($namewith,5,$this->student_name,0,0,'L');
	if($this->alternate_name !="" || $this->alternate_name!="-" || $this->alternate_name!=" "){
	$this->isUnicode=true;
	$this->SetFont('uGB','B',10);
	$this->Cell(30,5,"($this->alternate_name)",0,0,'L');
	$this->isUnicode=false;
	}
	$this->setXY(120,25);
	$this->SetFont('Times','',12);
	$this->MultiCell(180,5,"Student Code: ",0,'L');
	$this->SetFont('Times','B',12);
	$this->setXY(147,25);	
	$this->MultiCell(70,5,$this->student_code,0,'L');

	$this->setXY(156,7);
	$this->SetFont('Times','B',14);
	$this->Cell(70,7,"Official Receipt",0,0,'L',0,"listpayment.php");
	$this->SetFont('Times','',8);
	$this->setXY(156,12);
	$this->MultiCell(70,4,"Receipt No: " .$this->receipt_no,0,'L');
	$this->setX(156);
	$this->MultiCell(70,4,"Date: " . $this->payment_datetime  ,0,'L');
	$this->setX(156);
	$this->MultiCell(70,4,"Page: " . $this->PageNo()  . ' / {nb}',0,'L');

	//$this->setXY(5,28);
	//$this->MultiCell(70,5,"Receipt No: " .$this->receipt_no,0,'L');
	$header=array("Ref. No.","Date","Description","Charges($this->cur_symbol)","Transport($this->cur_symbol)","Payable($this->cur_symbol)","Paid Today($this->cur_symbol)","Balance($this->cur_symbol)");
	
	$this->BasicTable($header,1);

} //end of Header

function Footer()
{
    //Position at 1.5 cm from bottom
    $timestamp=date("d/m/y", time());
    $this->SetY(-23);
    //Arial italic 8
    $this->SetFont('Times','I',8);
    //Page number

    $this->Line(10,124,194,124);

    $this->MultiCell(140,3," $this->description",0,'L');
    $this->Cell(9,3,'Casher: ',0,0,'L');
    $this->SetFont('Times','BI',8);
    $this->MultiCell(140,3,' ' . $this->uname,0,'L');
    $this->SetFont('Times','I',8);
    $this->MultiCell(140,3,'Computer Generated, no signature required',0,'L');
    $this->MultiCell(140,3,'All Payments can only be transferred to fees but NOT_REFUNDABLE',0,'L');

//    $this->MultiCell(140,3,'Never Live Without Vision',0,'L');
    $this->SetFont('Times','',7);


    $this->SetY(-23);
	$this->MultiCell(145,3,"Total Charge($this->cur_symbol): ",0,'R');
	$this->MultiCell(145,3,"Paid($this->cur_symbol): ",0,'R');
	$this->MultiCell(145,3,"Change($this->cur_symbol): ",0,'R');
	$this->MultiCell(145,3,"Outstanding Amt($this->cur_symbol): ",0,'R');
	if($this->endreport=='Y'){
		$this->SetFont('Arial','B',8);
		$this->SetY(-23);
		$this->MultiCell(166,3,$this->amt,0,'R');
		$this->MultiCell(166,3, $this->receivedamt,0,'R');
		$this->MultiCell(166,3,$this->returnamt,0,'R');
		$this->MultiCell(166,3,$this->outstandingamt,0,'R');
	}


}//end of footer

function BasicTable($data,$printheader){
//Column widths

    $w=array(18,16,53,20,21,20,22,19); //8 data
	$i=0;
    //Header
    if($printheader==1){
	$this->setXY(10,31);
    	foreach($data as $col)
      	{
	
	$this->SetFont('Times','B',8); 
       	$this->Cell($w[$i],4,$col,1,0,'C');
	$i=$i+1;		
	}	
    $this->Ln();
      }
else{
	$this->setX(10);
      	foreach($data as $col) {
	    $this->SetFont('Times','',8);
		if($i>2)
	           $this->Cell($w[$i],4,$col,0,0,'R');
 		else
			 $this->Cell($w[$i],4,$col,0,0,'L');

	 $i=$i+1;
    	}
        $this->Ln();
 
	}
}//end basictable
}

$payment_id=0;

if(isset($_POST['payment_id'])){
$payment_id=$_POST['payment_id'];
$student_id=$_POST['student_id'];
}

if(isset($_GET['payment_id']) )  {
$payment_id=$_GET['payment_id'];
$student_id=$_GET['student_id'];

}

$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tablestudentclass=$tableprefix ."simtrain_studentclass";
$tabletuitionclass=$tableprefix ."simtrain_tuitionclass";
$tablepayment=$tableprefix ."simtrain_payment";
$tableproductlist=$tableprefix ."simtrain_productlist";
$tablepaymentline=$tableprefix ."simtrain_paymentline";
$tableorganization= $tableprefix . "simtrain_organization";
$tableaddress=$tableprefix."simtrain_address";
$tableperiod=$tableprefix."simtrain_period";
$tableusers=$tableprefix."users";
	//$pdf=new PDF('P','mm','a4'); 
	//$pdf=new PDF('L','mm', array(90,200));
$pdf=new PDF('L','mm', 'A5');
	//$pdf->AddPage();
	$pdf->SetAutoPageBreak(true ,22);
	$pdf->AliasNbPages();
	$pdf->SetFont('Arial','',10);
	$pdf->cur_name=$cur_name;
	$pdf->cur_symbol=$cur_symbol;	
	$sql="SELECT student_code, student_name,alternate_name from $tablestudent WHERE student_id=$student_id";
	$query=$xoopsDB->query($sql);
	$organization_id=0;
	if ($row=$xoopsDB->fetchArray($query)){
		$pdf->student_code=$row['student_code'];
		$pdf->alternate_name=$row['alternate_name'];
		$pdf->student_name=$row['student_name'];
	}

	$sqlpayment="SELECT p.organization_id, p.receipt_no,p.payment_datetime,p.amt,p.returnamt,p.outstandingamt, p.receivedamt,u.name,".
		" p.payment_description  FROM $tablepayment p inner join $tableusers u on u.uid=p.updatedby where ".
		" payment_id=$payment_id  ";
	
	$querypayment=$xoopsDB->query($sqlpayment);
	if ($rowpayment=$xoopsDB->fetchArray($querypayment)){
		$organization_id=$rowpayment['organization_id'];
		$pdf->receipt_no=$rowpayment['receipt_no'];
		$pdf->payment_datetime=$rowpayment['payment_datetime'];
		$pdf->amt=$rowpayment['amt'];
		$pdf->description=$rowpayment['payment_description'];
		$pdf->returnamt=$rowpayment['returnamt'];
		$pdf->outstandingamt=$rowpayment['outstandingamt'];
		$pdf->receivedamt=$rowpayment['receivedamt'];
		$pdf->uname=$rowpayment['name'];
	}
	
	$sqlorganization="SELECT o.organization_name, o.rob_no, o.jpn_no, o.tel_1, o.tel_2, o.fax,a.no, a.street1,a.street2,".
				" a.postcode,a.city,a.state,a.country from $tableorganization o ".
				" inner join $tableaddress a on o.address_id=a.address_id where o.organization_id=$organization_id";
	$qryorganization=$xoopsDB->query($sqlorganization);
	if($roworg=$xoopsDB->fetchArray($qryorganization)){
		$pdf->organization_name=$roworg['organization_name'];
		$pdf->rob_no=$roworg['rob_no'];
		$pdf->jpn_no=$roworg['jpn_no'];
		$pdf->no=$roworg['no'];
		$pdf->street1=$roworg['street1'];
		$pdf->street2=$roworg['street2'];
		$pdf->postcode-$roworg['postcode'];
		$pdf->city=$roworg['city'];
		$pdf->state=$roworg['state'];
		$pdf->country=$roworg['country'];
		$pdf->tel_1=$roworg['tel_1'];
		$pdf->tel_2=$roworg['tel_2'];
		$pdf->fax=$roworg['fax'];
	}

	/*$sqlpaymentlineclass=" SELECT pd.product_no,pr.period_name,tc.description,sc.trainingfees as charge,sc.transportfees,".
			" coalesce((select sum(spl.amt) as amt from $tablepaymentline spl inner join $tablepayment sp on".
			" spl.payment_id=sp.payment_id where sp.iscomplete='Y' and spl.studentclass_id=sc.studentclass_id),0) as payable,".
			" pl.amt, pl.amt - coalesce((select sum(spl.amt) as amt from $tablepaymentline spl ".
			" inner join $tablepayment sp on spl.payment_id=sp.payment_id where sp.iscomplete='Y' and ".
			" spl.studentclass_id=sc.studentclass_id),0) as balance ".
			" FROM $tablestudentclass sc ".
			" inner join $tabletuitionclass tc on tc.tuitionclass_id=sc.tuitionclass_id ".
			" inner join $tableproductlist pd on tc.product_id=pd.product_id ".
			" inner join $tableperiod pr on pr.period_id=tc.period_id ".
			" inner join $tablepaymentline pl on pl.studentclass_id=sc.studentclass_id ".
			" where pl.payment_id=$payment_id group by sc.studentclass_id, tc.tuitionclass_code, pd.product_name,". 
			" sc.trainingfees,sc.transportfees,pr.period_name order by pr.period_name,tc.tuitionclass_code";
	*/
$sqlpaymentlineclass="SELECT (CASE WHEN tc.tuitionclass_id >0 
				THEN tc.tuitionclass_code ELSE pd.product_no END ) as code,sc.transactiondate,
			     (CASE WHEN tc.tuitionclass_id >0 THEN tc.description
				ELSE concat(pd.product_name,'x',i.quantity) END ) as description,	
			 sc.amt as charge, sc.transportfees, payable,
			 pl.amt, payable - pl.amt as balance 
			 FROM sim_simtrain_studentclass sc 
			 left join sim_simtrain_inventorymovement i on sc.movement_id=i.movement_id
			 left join sim_simtrain_tuitionclass tc on tc.tuitionclass_id=sc.tuitionclass_id 
			 left join sim_simtrain_productlist pd on i.product_id=pd.product_id
			 inner join sim_simtrain_paymentline pl on pl.studentclass_id=sc.studentclass_id
			 where pl.payment_id=$payment_id and pl.product_id=0
			 group by
			 sc.studentclass_id, tc.tuitionclass_code, pd.product_name, sc.amt,sc.transportfees
			 order by sc.transactiondate,tc.tuitionclass_code";
	

	$sqlpaymentlineproduct="SELECT p.product_no,p.product_name,pl.amt,pl.qty,linedescription FROM sim_simtrain_paymentline pl ".
				" inner join sim_simtrain_productlist p on p.product_id=pl.product_id where pl.payment_id=$payment_id and pl.product_id>0";
	
	$pdf->AddUniGBhwFont("uGB");

	$pdf->isUnicode=false;
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
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
	//$pdf->MultiCell(150,3,"$sqlorganization",0,'L');
	//display pdf
	$pdf->Output();
	exit (1);

?>

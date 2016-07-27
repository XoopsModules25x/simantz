<?php
include_once('fpdf/fpdf.php');
include_once ('system.php');



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  public $cur_name;
  public $cur_symbol;
  public $uname="unknown";
function Header()
{
   
   $this->Image('upload/images/attlistlogo.jpg', 12 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Arial','B',18);
    $this->SetXY(10,10);
    $this->Cell(0,17," ",1,0,'R');
    $this->SetXY(100,6);
    $this->Cell(0,17,"Daily Payment Received Report",0,0,'R');

  
    $this->SetFont('Times','',9);
    $this->SetXY(110,20);
    $this->Cell(18,7,"Date",1,0,'C');
  $this->SetFont('Times','B',10);  
  $this->Cell(18,7,date("y-m-d", time()),1,0,'C');
    $this->SetFont('Times','',9);
    $this->Cell(23,7,"User",1,0,'C');

 while($this->GetStringWidth($this->uname)>28)
		$this->uname=substr_replace($this->uname,"",-1); 
    $this->SetFont('Times','B',9);
    $this->Cell(31,7,$this->uname,1,0,'C');
    $this->Ln(10);
$i=0;

//    $this->SetFont('Times','B',9);
	$header=array('No','Organization','Student','Time', 'Fees(RM)',"Trans.($this->cur_symbol)", "Changed($this->cur_symbol)", 'Doc No',"Accum.($this->cur_symbol)");
    $w=array(8,20,50,15,20,20,20,15,22);
foreach($header as $col)
      	{
	$this->SetFont('Times','B',9); 
       	$this->Cell($w[$i],7,$col,1,0,'C');
	$i=$i+1;		
	}	
    $this->Ln();
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());
    //Position at 1.5 cm from bottom
    $this->SetY(-7);
    //Arial italic 8
    $this->SetFont('courier','I',8);

    $this->Cell(0,5,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

function BasicTable($data)
{
    $w=array(8,20,50,15,20,20,20,15,22);
	$i=0;


$this->SetFont('Times','',9);
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {

        //chop long string to fit in col uname, student name
	
	  while($this->GetStringWidth($col)>$w[$i])
		$col=substr_replace($col,"",-1);  
	
        if ($i<=3)
            $this->Cell($w[$i],6,$col,1,0,'L');
 	else
	     $this->Cell($w[$i],6,$col,1,0,'R');
	
            $i=$i+1;
            }
        $this->Ln();
    }

}
}
include_once 'class/Student.php';
//include_once 'class/Employee.php';
include_once 'class/Organization.php';
include_once './class/Log.php';
$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tableemployee=$tableprefix . "simtrain_employee";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tablestudentclass=$tableprefix . "simtrain_studentclass";
$tableorganization=$tableprefix . "simtrain_organization";
$tableperiod=$tableprefix . "simtrain_period";
$tablepaymentline=$tableprefix."simtrain_paymentline";
$tablepayment=$tableprefix."simtrain_payment";
$tableusers=$tableprefix."users";
$log = new Log();
//$e = new Employee ($xoopsDB, $tableprefix, $log);
$std = new Student ($xoopsDB, $tableprefix, $log);
$uid=$xoopsUser->getVar('uid');

$datefrom= date("Y-m-d 00:00:00", time()) ;
$dateto= date("Y-m-d 23:59:59", time()) ;

$pdf=new PDF('P','mm','A4'); 
$pdf->AliasNbPages();
$pdf->cur_name=$cur_name;
$pdf->cur_symbol=$cur_symbol;
   

        $organization_id=$_POST["organization_id"];



	$pdf->cur_name=$cur_name;
	$pdf->cur_symbol=$cur_symbol;


	$wherestring="p.payment_datetime between '$datefrom' and '$dateto' AND p.updatedby=$uid";

	$sql="select u.uid,u.uname,s.student_name AS student_name,RIGHT(p.payment_datetime,8) AS payment_datetime,".
		" sum(pl.amt - pl.transportamt) AS fees,sum(pl.transportamt) AS transportamt,".
		" p.returnamt AS returnamt,p.receipt_no AS docno,o.organization_code from $tablepayment p ".
		" join $tablepaymentline pl on pl.payment_id = p.payment_id ".
		" join $tablestudent s on p.student_id = s.student_id ".
		" left join $tableusers u on p.updatedby = u.uid ".
		" join $tableorganization o on o.organization_id = p.organization_id ".
		" where p.iscomplete = 'Y' AND $wherestring and s.organization_id = $defaultorganization_id ".
		" group by u.uid,u.uname,s.student_name,p.receipt_no,p.payment_datetime,p.returnamt order by p.payment_datetime desc";


	$query=$xoopsDB->query($sql);
	$total=0;
	$rowtype="";
	$data=array();
	$i=0;
	while($row=$xoopsDB->fetchArray($query)) {
		$i++;
		$uid=$row['uid'];
		$pdf->uname=$row['uname'];
		$student_name=$row['student_name'];
		$payment_datetime=$row['payment_datetime'];
		$fees=$row['fees'];
		$transportamt=$row['transportamt'];
		$organization_code=$row['organization_code'];
		$returnamt=$row['returnamt'];
		$docno=$row['docno'];
		$total=$total+$fees+$transportamt;
		$data[]=array($i,$organization_code,$student_name,$payment_datetime,$fees,$transportamt,$returnamt,$docno,number_format($total,2));
		//$data[]=array($i,"","","","","","","","","","","","","");
		
	}
	//$querysum=$xoopsDB->query($sqlsummary);
	//$datasum=array();
	//if($rowsum=$xoopsDB->fetchArray($querysum))
	//	$data[]=array('','',"Total($pdf->cur_symbol):",'',$rowsum['fees'],$rowsum['transportamt'],'','','');
	
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
   	//$pdf->MultiCell(0,5,$sql,0,'C');
	$pdf->BasicTable($data);
	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output("DailyFeesCollection-".$pdf->datefrom."_".$pdf->dateto.".pdf","I");

?>


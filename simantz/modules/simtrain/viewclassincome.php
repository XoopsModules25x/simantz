<?php
include_once('fpdf/chinese-unicode.php');
include_once "system.php";



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends PDF_Unicode
{
  public $student_id="Unknown";
  public $student_code="Unknown";
  public $student_name="Unknown"; 
  public $school="Unknown"; 
  public $s_hp_no="Unknown"; 
  public $s_tel_1="Unknown"; 
  public $s_isactive="Unknown";
  public $tuitionclass_id="Unknown";
  public $period_id="Unknown";
  public $tuitionclass_code; 
  public $employee_id="Unknown"; 
  public $description="Unknown"; 
  public $classtype="Unknown";
  public $classcount="Unknown";
  public $time="Unknown";  
  public $employee_name="Unknown"; 
  public $e_hp_no="Unknown";
  public $e_isactive="Unknown";
  public $studentclass_id="Unknown";
  public $r_isactive="Unknown";
  public $amt;

function Header()
{
    $this->Image('upload/images/attlistlogo.jpg', 10 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Times','B',30);
	$this->SetXY(10,10);
    $this->Cell(80,17," ",1,0,'R');
    $this->Cell(40,17,"$this->period_name",1,0,'R');
    $this->Cell(0,17,"$this->tuitionclass_code",1,0,'R');

    $this->SetFont('Times','',10);
	$this->SetXY(62,4);
    $this->Cell(40,17,"Month",0,0,'R');
	$this->SetXY(130,4);
    $this->Cell(0,17,"Class Code",0,0,'L');

    $this->Ln(25);
    $this->SetFont('Arial','B',12);
    $this->Cell(32,8,"Report Title",1,0,'L');
    $this->Cell(0,8,"Fees Collection Report",1,0,'C');

    $this->Ln(11);
    $this->SetFont('Times','',10);
    $this->Cell(32,7,"Class Description",1,0,'L');
    $this->SetFont('Times','B',10);
    while($this->GetStringWidth($this->description)> 57)
			$this->description=substr_replace($this->description,"",-1);
    $this->Cell(58,7,$this->description,1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(19,7,"Fees ($this->cur_symbol)",1,0,'C');
      $this->SetFont('Times','B',10);
  $this->Cell(16,7,$this->amt,1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(10,7,"Day",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(12,7,"$this->day" ,1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(16,7,"Time",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(27,7,$this->time,1,0,'C');
    $this->Ln(); 
    $this->SetFont('Times','',10);
    $this->Cell(32,7,"Tutor(Tel)",1,0,'L');
    $this->SetFont('Times','B',10);
    $this->Cell(58,7,$this->employee_name,1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(19,7,"Class Type",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(16,7,$this->classtype,1,0,'C');

    $this->SetFont('Times','',10);
    $this->Cell(22,7, "Class Count ",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(16,7, $this->classcount,1,0,'C');
    $this->Cell(27,7, " ",1,0,'C');

$this->Ln(9);

$i=0;
	$header=array('No','Code','Student Name', 'School','Contact No.', 'Fees($this->cur_symbol)', 'Paid($this->cur_symbol)','Balance','Last Date');
    $w=array(8,16,50,12,28,15,15,15,10,21);
       	$this->Cell(8,10,'No',1,0,'C');
       	$this->Cell(15,10,'Code',1,0,'C');
       	$this->Cell(54,10,'Student Name',1,0,'C');
       	$this->Cell(16,10,'School',1,0,'C');
       	$this->Cell(28,10,'Contact No.',1,0,'C');
       	$this->Cell(45,5,"Amount In $this->cur_symbol",1,0,'C');
     	$this->Cell(24,10,'Last Date',1,0,'C');

	$this->setXY(131,61);
       	$this->Cell(15,5,'Fees',1,0,'C');
       	$this->Cell(15,5,'Paid',1,0,'C');
       	$this->Cell(15,5,'Balance',1,0,'C');



//foreach($header as $col)
  //    	{
	//$this->SetFont('Arial','B',9); 
       //	$this->Cell($w[$i],7,$col,1,0,'C');
//	$i=$i+1;		
//	}	
    $this->Ln();
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());
    //Position at 1.5 cm from bottom
    $this->SetY(-12);
    //Arial italic 8
    $this->SetFont('courier','I',8);
	
    $this->Cell(0,4,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

function BasicTable($header,$data,$printheader)
{
    $w=array(8,15,54,16,28,15,15,15,24);
	$i=0;
    //Header
/*    if($printheader==1){
    	foreach($header as $col)
      	{

$this->SetFont('Arial','B',9); 
       	$this->Cell($w[$i],7,$col,1,0,'C');
	$i=$i+1;		
	}	
    $this->Ln();
      }*/
    //Data

$this->SetFont('Arial','',9);
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {

	//if ($i==4 || $i==2 || $i==3)
			

        if ($i==2){
            //-------------------------
	
	$break=explode('|||',$col);
	$englishname=$break[count($break)-1];
	$alternatename=$break[0];
	$cellwidth=$w[$i];
	$uGBnamewidth=13;

	$this->SetFont('uGB','',7);
	$this->isUnicode=true;
	while($this->GetStringWidth($alternatename)>$uGBnamewidth && $cellwidth >15)
		$alternatename=substr_replace($alternatename,"",-1);
	$balancewidth=$w[$i]-$uGBnamewidth;
	
//	if($englishname+$uGBnamewidth<$cellwidth ){
//		$balancewidth
	

	if($alternatename=="Total :")
        $this->Cell($uGBnamewidth,6,'',1,0,'C');
	else
        $this->Cell($uGBnamewidth,6,$alternatename,1,0,'C');
 	$this->isUnicode=false;
	$this->SetFont('Times','',8); 
	while($this->GetStringWidth($englishname)> $balancewidth-1)
			$englishname=substr_replace($englishname,"",-1);
        $this->Cell($balancewidth,6,$englishname,1,0,'L');

	}
 	else{
	while($this->GetStringWidth($col)> $w[$i])
			$col=substr_replace($col,"",-1);
	     $this->Cell($w[$i],6,$col,1,0,'C');
	}	
            $i=$i+1;
            }
        $this->Ln();
    }

}
}

$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tableemployee=$tableprefix . "simtrain_employee";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tablestudentclass=$tableprefix . "simtrain_studentclass";
$tableperiod=$tableprefix . "simtrain_period";
$tablepaymentline=$tableprefix."simtrain_paymentline";
$tablepayment=$tableprefix."simtrain_payment";
$tableschool=$tableprefix."simtrain_school";

if (isset($_POST["tuitionclass_id"])){

$tuitionclass_id=$_POST["tuitionclass_id"];

	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true ,15);
	$pdf->cur_name=$cur_name;
	$pdf->cur_symbol=$cur_symbol;
//}
//if (isset($_GET['tuitionclass_id']) || isset($_GET['period_id'])){

//$tuitionclass_id=$_GET["tuitionclass_id"];
//$period_id=$_GET["period_id"];
//}
	$sqlgetheader="SELECT c.tuitionclass_id, c.tuitionclass_code, c.description, c.day, c.starttime, c.endtime, e.employee_id, e.employee_name, e.hp_no, d.period_name, p.amt,c.classtype,c.classcount from $tabletuitionclass c inner join $tableemployee e inner join $tableperiod d inner join $tableproductlist p where c.tuitionclass_id=$tuitionclass_id and c.employee_id=e.employee_id and c.period_id=d.period_id and c.product_id=p.product_id";

	$querygetheader=$xoopsDB->query($sqlgetheader);
	if($rowgetheader=$xoopsDB->fetchArray($querygetheader)){
		$pdf->tuitionclass_code=$rowgetheader["tuitionclass_code"];
		$pdf->period_name=$rowgetheader["period_name"];
		$pdf->description=$rowgetheader["description"];
		$pdf->amt=$rowgetheader["amt"];
		$pdf->classcount=$rowgetheader['classcount'];
		switch($rowgetheader["classtype"]){
		case "S":
		$pdf->day="-";
		$pdf->time="-";
		$pdf->classtype="Special";
		break;
		case "W":
		$pdf->classtype="Weekly";
		$pdf->day=$rowgetheader["day"];
		$pdf->time=$rowgetheader["starttime"].' ~ '.$rowgetheader["endtime"];
		break;
		case "M":
		$pdf->day="-";
		$pdf->classtype="Monthly";
		$pdf->time="-";
		
		break;
		}
//		$pdf->classtype=$rowgetheader["classtype"];
		
		$pdf->employee_name=$rowgetheader["employee_name"] . "(".$rowgetheader["hp_no"].")";
//		$pdf->e_hp_no=$rowgetheader["hp_no"];
	}

//	$header=array('No','Code','Student Name', 'Contact No.', 'School', 'Fees', '1st', '2nd', '3rd', '4th', '5th', 'RMK');
	$subsql="coalesce((SELECT sum(trainingamt) as amt FROM $tablepaymentline pl ".
		" inner join $tablepayment py on py.payment_id=pl.payment_id ".
		" inner join $tablestudentclass sc on pl.studentclass_id=sc.studentclass_id ".
		" where sc.tuitionclass_id=$tuitionclass_id and py.student_id=s.student_id and py.iscomplete='Y'),0)";
	$lastdatesql="(SELECT DATE(max(py.payment_datetime)) as date FROM $tablepaymentline pl ".
		" inner join $tablepayment py on py.payment_id=pl.payment_id ".
		" inner join $tablestudentclass sc on pl.studentclass_id=sc.studentclass_id ".
		" where sc.tuitionclass_id=$tuitionclass_id and py.student_id=s.student_id and py.iscomplete='Y')";

	$sql="SELECT s.student_code, s.student_name, s.alternate_name, s.hp_no,x.amt,$subsql as paidamt,x.amt - $subsql as balance,".
		" sch.school_name,x.comeactive,x.backactive,$lastdatesql as lastdate from $tabletuitionclass c ".
		" inner join $tablestudentclass x on x.tuitionclass_id=c.tuitionclass_id ".
		" inner join $tableperiod d on c.period_id=d.period_id ".
		" inner join $tablestudent s on s.student_id=x.student_id ".
		" inner join $tableschool  sch on s.school_id=sch.school_id ".
		" where x.tuitionclass_id=$tuitionclass_id ".
		" order by s.student_name";

	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;
	$backactive=$row['backactive'];
	$comeactive=$row['comeactive'];
	$transport="";
	if($backactive=='Y' && $comeactive=='Y')
		$transport="D";
	elseif($backactive=="Y")
		$transport="B";		
	elseif($comeactive=='Y')
		$transport="C";
	else
		$transport="";

   	$data[]=array($i,$row['student_code'],$row['alternate_name']. "|||".
		 $row['student_name'] ,$row['school_name'],$row['hp_no'],$row['amt'],$row['paidamt'],
			$row['balance'],$row['lastdate']);
   	}
	while ($i<'36'){
	$i=$i+1;
   	$data[]=array($i,'','','','','','','','','','','');
   	}
	if ($i>'36')
	{
	while ($i<'72'){
	$i=$i+1;
   	$data[]=array($i,'','','','','','','','','','','');
   	}}
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddUniGBhwFont("uGB");
	$pdf->isUnicode=false;
	$pdf->AddPage();
   //	$pdf->MultiCell(0,5,$sqlgetheader,0,'C');
	$pdf->BasicTable($header,$data,1);  

	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output("ClassIncome-".$pdf->tuitionclass_code.".pdf","I");
	exit (1);

}
else {
	require(XOOPS_ROOT_PATH.'/header.php');
echo <<< EOF
	echo "there is some internal error, please contact the developer";
EOF;
	require(XOOPS_ROOT_PATH.'/footer.php');
}
?>


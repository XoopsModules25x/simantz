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
  public $organization_code="Unknown";
  public $period_id="Unknown";
  public $tuitionclass_code; 
  public $employee_id="Unknown"; 
  public $description="Unknown"; 
  public $day="Unknown";
  public $time="Unknown";  
 
  public $employee_name="Unknown"; 
  public $e_hp_no="Unknown";
  public $e_isactive="Unknown";
  public $studentclass_id="Unknown";
  public $r_isactive="Unknown";
  public $cur_symbol="???";
  public $amt;

function Header()
{
 
   $this->Image('upload/images/attlistlogo.jpg', 15 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Times','B',30);
//-------------------------
	$this->SetXY(15,10);
   $this->Cell(150,17," ",1,0,'R');

    $this->Cell(60,17,"$this->period_name",1,0,'R');
	$this->SetX(225);
    $this->Cell(62,17,"$this->tuitionclass_code",1,0,'R');

//----------------
//    $this->Cell(105,17," ",1,0,'R');
    
$this->SetFont('Times','',10);
	$this->SetXY(165,4);
 
  $this->Cell(0,17,"Month",0,0,'L');
	$this->SetXY(225,4);
    $this->Cell(0,17,"Class Code",0,0,'L');

    $this->Ln(25);
    $this->SetFont('Arial','',12);
    $this->Cell(32,8,"Report Title",1,0,'L');
    $this->Cell(0,8,"Attendance Sheet",1,0,'C');

    $this->Ln(11);
    $this->SetFont('Times','',10);
    $this->Cell(32,7,"Class Description",1,0,'L');
    $this->SetFont('Times','B',10);
    //while($this->GetStringWidth($this->description)> 57)
    //$this->description=substr_replace($this->description,"",-1);
    $this->Cell(150,7,$this->description,1,0,'C');
//    $this->SetFont('Times','',10);
   // $this->Cell(31,7,"Standard Fees($this->cur_symbol)",1,0,'C');
   // $this->SetFont('Times','B',10);

//    $this->Cell(19,7,"$this->amt",1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(20,7,"Class Type",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(20,7,"Monthly",1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(20,7,"Time",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(30,7,$this->time,1,0,'C');
    $this->Ln(); 
    $this->SetFont('Times','',10);
    $this->Cell(32,7,"Tutor",1,0,'L');
    $this->SetFont('Times','B',10);
    $this->Cell(100,7,$this->employee_name,1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(50,7,"Tutor Contact",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(40,7,$this->e_hp_no,1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(20,7, "Place",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(30,7, "$this->organization_code",1,0,'C');

$this->Ln(9);


$i=0;
	$header=array('No','Index No','Student Name', 'Description', '1', '2', '3', '4', '5',
 			'6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25',
			'26','27','28','29','30','31','RMK');
   $w=array(6,14,49,25,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,23); //12 data
foreach($header as $col)
      	{
$this->SetFont('Arial','B',9); 
       	$this->Cell($w[$i],7,$col,1,0,'C');
	$i=$i+1;		
	}	
    $this->Ln();
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());
    //Position at 1.5 cm from bottom
    $this->SetY(-25);
   //$this->SetY(-10);
  
   //Arial italic 8
    $this->SetFont('courier','I',8);
    //Page number
   $this->Cell(0,5,"For Administration Use",LTR,0,'L');
$this->Ln();
  $this->Cell(0,10,"",LBR,0,'L');
$this->Ln();
    $this->Cell(0,10,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

function BasicTable($header,$data,$printheader)
{
//$this->isUnicode=false;
//Column widths
//$w=array(7,20,45,20,18,74,38,18,18,18,8);
//No,Code,Student Name, Contact No., School, Fees, 1st, 2nd, 3rd, 4th, 5th, RMK
//no,date,itineray,description,bus,time,customer,sales,rental,profit,id
    
$w=array(6,14,49,25,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,23); //12 data
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

//$this->SetFont('Arial','',9);
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {
	//if ($i==4 || $i==2 || $i==3)
		while($this->GetStringWidth($col)> $w[$i])
			$col=substr_replace($col,"",-1);	

        if ($i==2){
//		$this->isUnicode=true;
//		$this->SetFont('uni','',9);
		$this->Cell($w[$i],6,$col,1,0,'L');
//		$this->isUnicode=false;

		}
 	else
	     $this->Cell($w[$i],6,$col,1,0,'C');
	
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
$tablestandard=$tableprefix . "simtrain_standard";
$tableschool=$tableprefix . "simtrain_school";
$tableorganization=$tableprefix."simtrain_organization";

if (isset($_POST['submit'])){

$tuitionclass_id=$_POST["tuitionclass_id"];
$period_id=$_POST["period_id"];
$pdf=new PDF('L','mm','A4','UTF-8');
if($att_showcontact=='Y')
$pdf->header=array('No','Index No','Student Name', 'Contact No', 'School','T');
$pdf->isUnicode=False;
//$pdf=new PDF();
//$pdf->Open(); 


	$pdf->cur_symbol=$cur_symbol;
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(15);
	$pdf->SetAutoPageBreak(true ,25);

//}
//if (isset($_GET['tuitionclass_id']) || isset($_GET['period_id'])){

//$tuitionclass_id=$_GET["tuitionclass_id"];
//$period_id=$_GET["period_id"];
//}
	$sqlgetheader="SELECT c.tuitionclass_id, c.tuitionclass_code, c.description, c.day, c.starttime, c.endtime, e.employee_id, e.employee_name, e.hp_no, d.period_name, p.amt,o.organization_code
		from $tabletuitionclass c 
		inner join $tableemployee e on c.employee_id=e.employee_id
		inner join $tableperiod d on c.period_id=d.period_id
		inner join $tableproductlist p on c.product_id=p.product_id
		inner join $tableorganization o on c.organization_id=o.organization_id
		where c.tuitionclass_id=$tuitionclass_id";

	$querygetheader=$xoopsDB->query($sqlgetheader);
	while($rowgetheader=$xoopsDB->fetchArray($querygetheader)){
		$pdf->tuitionclass_code=$rowgetheader["tuitionclass_code"];
		$pdf->period_name=$rowgetheader["period_name"];
		$pdf->description=$rowgetheader["description"];
		$pdf->amt=$rowgetheader["amt"];
		$pdf->day=$rowgetheader["day"];
		$pdf->time=$rowgetheader["starttime"].' ~ '.$rowgetheader["endtime"];
		$pdf->employee_name=$rowgetheader["employee_name"];
		$pdf->e_hp_no=$rowgetheader["hp_no"];
		$pdf->organization_code=$rowgetheader["organization_code"];
		}

//	$header=array('No','Code','Student Name', 'Contact No.', 'School', 'Fees', '1st', '2nd', '3rd', '4th', '5th', 'RMK');
	
	//$sql="SELECT s.student_code, s.student_name, s.hp_no,s.tel_1, s.school, x.amt, x.isactive,x.comeactive, x.backactive from $tabletuitionclass c inner join $tablestudentclass x inner join $tableperiod d inner join $tablestudent s where x.tuitionclass_id=$tuitionclass_id and x.tuitionclass_id=c.tuitionclass_id and s.student_id=x.student_id and c.period_id=d.period_id order by s.student_name";
	$sql="SELECT s.student_id,s.student_code,s.alternate_name, s.student_name,
		concat(s.hp_no,'/', s.tel_1) as hp_no,
		 x.amt, x.isactive, x.studentclass_id ".
		",x.comeactive, x.backactive,x.description from $tabletuitionclass c ".
		" inner join $tablestudentclass x inner join $tableperiod d ".
		" inner join $tablestudent s on s.student_id=x.student_id ".

		" where x.tuitionclass_id=$tuitionclass_id and x.tuitionclass_id=c.tuitionclass_id and ".
		" c.period_id=d.period_id  order by s.student_name";

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
   //	$data[]=array($i,$row['student_code'],$row['student_name'],$row['hp_no'].'/'.$row['tel_1'],$row['school_name'],$transport,$row['amt'],'','','','','','');
if($att_showcontact=='N')
	$data[]=array($i,$row['student_code'],$row['alternate_name'].'/'.$row['student_name'],$row['description'],'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
else
	$data[]=array($i,$row['student_code'],$row['alternate_name'].'/'.$row['student_name'],$row['hp_no'],'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
   
   	}
	while ($i<'20'){
	$i=$i+1;
   	$data[]=array($i,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
   	}
	if ($i>'20')
	{
	while ($i<'40'){
	$i=$i+1;
	   $data[]=array($i,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
	}

}
	if ($i>'40')
	{
	while ($i<'60'){
	$i=$i+1;
	   $data[]=array($i,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
	}

}
	if ($i>'60')
	{
	while ($i<'80'){
	$i=$i+1;
	   $data[]=array($i,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
	}

}
	if ($i>'80')
	{
	while ($i<'100'){
	$i=$i+1;
	   $data[]=array($i,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
	}

}	//print header
	$pdf->SetFont('Arial','',10);
//	$pdf->AddUniCNShwFont('uni');
	$pdf->AddUniGBhwFont("uGB");
	$pdf->AddPage();
		$pdf->isUnicode=true;
//		$pdf->SetFont('uni','',9);
	$pdf->SetFont('uGB','',9);
	$pdf->BasicTable($header,$data,1);
		$pdf->isUnicode=false;

	//$pdf->SetFont('uni','',10);
	//$pdf->isUnicode=true;
	//$pdf->MultiCell(180,7,"我喜欢",1,'C');
	//$pdf->isUnicode=false;
	//display pdf
	$pdf->Output();
	exit (1);

}
else {
	require(XOOPS_ROOT_PATH.'/header.php');
	echo "<td>Error during retrieving Invoice ID on viewinvoice.php(~line 206)," . 
		" please contact software developer kstan@simit.com.my</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');
}
?>


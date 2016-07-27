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
  public $organization_code; 
  public $employee_id="Unknown"; 
  public $test_name="Unknown"; 
  public $day="Unknown";
  public $time="Unknown";  
  public $employee_name="Unknown"; 
  public $e_hp_no="Unknown";
  public $e_isactive="Unknown";
  public $studentclass_id="Unknown";
  public $showRMK="";
  public $r_isactive="Unknown";
  public $testdate="Unknown";
  public $averagemark=0;
  public $highestmark=0;
  public $lowestmark=0;
//  public $scheduleheader=array();
  public $header=array('No','Index No','Student Name', 'Result', 'Description','Remarks');
  
function Header()
{
  /*  $this->Image('./images/attlistlogo.jpg', 10 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Arial','B',18);
    $this->Cell(0,17,"Attendance Sheet",1,0,'R');
    $this->Ln(20);
    $this->SetFont('Arial','B',12);
    $this->Cell(26,8,"Class Code",1,0,'L');
    $this->Cell(80,8,$this->tuitionclass_code,1,0,'C');
    $this->Cell(26,8,"Month",1,0,'C');
    $this->Cell(58,8,$this->period_name,1,0,'C');
*/   $this->Image('upload/images/attlistlogo.jpg', 15 , 10 , 60 , '' , 'JPG' , ''); 
   $this->Ln();
    $this->SetFont('Times','B',30);
//-------------------------
	$this->SetXY(15,10);
//	$this->Rect(75,10,130,17);
$this->Rect(15,10,65,17);
$this->Rect(80,10,55,17);
$this->Rect(135,10,65,17);

    $this->Cell(120,17,"$this->testdate",0,0,'R');
	$this->SetX(90);
    $this->Cell(110,17,"$this->tuitionclass_code",0,0,'R');
	$this->SetXY(95,10);
//----------------
//    $this->Cell(105,17," ",1,0,'R');
    $this->SetFont('Times','',10);
	$this->SetXY(49,4);
    $this->Cell(40,17,"Date",0,0,'R');
	$this->SetXY(135,4);
    $this->Cell(0,17,"Class Code",0,0,'L');

    $this->Ln(25);
    $this->SetFont('Arial','',12);
    $this->Cell(32,8,"Report Title",1,0,'L');
    $this->Cell(0,8,"Test Summary Report",1,0,'C');

    $this->Ln(11);
    $this->SetFont('Times','',10);
    $this->Cell(32,7,"Test Name",1,0,'L');
    $this->SetFont('Times','B',8);
    while($this->GetStringWidth($this->test_name)>78)
			$this->test_name=substr_replace($this->test_name,"",-1);
    $this->Cell(77,7,$this->test_name,1,0,'C');
 
    $this->SetFont('Times','',10);
    $this->Cell(10,7,"MAX",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(15,7,$this->highestmark,1,0,'C');

    $this->SetFont('Times','',10);
    $this->Cell(10,7,"MIN",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(15,7,$this->lowestmark,1,0,'C');

    $this->SetFont('Times','',10);
    $this->Cell(10,7,"AVG",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(16,7,$this->averagemark,1,0,'C');
   
 $this->Ln(); 
    $this->SetFont('Times','',10);
    $this->Cell(32,7,"Tutor",1,0,'L');
    $this->SetFont('Times','B',10);
    $this->Cell(55,7,$this->employee_name,1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(22,7,"Tutor Contact",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(25,7,$this->e_hp_no,1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(10,7, "Place",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(41,7, "$this->organization_code",1,0,'C');

$this->Ln(4);
$this->Ln();
$i=0;


   $w=array(6,14,60,20,45,40); //12 data
foreach($this->header as $col)
      	{
	if($i <=10 && $i>=6)
	$this->SetFont('Times','B',7);
	else
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
    $this->SetY(-50);
    //Arial italic 8
    $this->SetFont('courier','I',8);
    //Page number
    $this->Cell(0,5,"For Administration Use",LTR,0,'L');
$this->Ln();
    $this->Cell(0,25,"",LBR,0,'L');
$this->Ln();
    $this->Cell(0,10,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

function BasicTable($header,$data,$printheader)
{
//Column widths
//$w=array(7,20,45,20,18,74,38,18,18,18,8);
//No,Code,Student Name, Contact No., School, Fees, 1st, 2nd, 3rd, 4th, 5th, RMK
//no,date,itineray,description,bus,time,customer,sales,rental,profit,id
    $w=array(6,14,60,20,45,40); //12 data
	$i=0;
  
 foreach($data as $row)
    {
	 $i=0;
    	foreach($row as $col) {

	$this->setFont('Times','',8);
	while($this->GetStringWidth($col)> $w[$i] && $i!=2)
			$col=substr_replace($col,"",-1);	

     if ($i==2){
//-------------------------
	$this->SetFont('uGB','',7);
	$break=explode('|||',$col);
	$englishname=$break[count($break)-1];
	$alternatename=$break[0];
	$cellwidth=$w[$i];
	$uGBnamewidth=13;


	while($this->GetStringWidth($alternatename)>$uGBnamewidth && $cellwidth >15)
		$alternatename=substr_replace($alternatename,"",-1);
	$balancewidth=$w[$i]-$uGBnamewidth;
	
//	if($englishname+$uGBnamewidth<$cellwidth ){
//		$balancewidth
	
	$this->isUnicode=true;
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
$tableattendance=$tableprefix."simtrain_attendance";
$tableclassschedule=$tableprefix."simtrain_classschedule";
$tabletest=$tableprefix."simtrain_test";
$tabletestline=$tableprefix."simtrain_testline";
$schedulecount=0;
$arrayscheduleheader=array();


if (isset($_POST['submit'])){

$test_id=$_POST["test_id"];

$pdf=new PDF('P','mm','A4');

	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(15);
	$pdf->SetAutoPageBreak(true ,50);

//}
//if (isset($_GET['tuitionclass_id']) || isset($_GET['period_id'])){

//$tuitionclass_id=$_GET["tuitionclass_id"];
//$period_id=$_GET["period_id"];
//}
	$sqlgetheader="SELECT c.tuitionclass_id, c.tuitionclass_code, c.description, c.day, c.starttime, 
			c.endtime, e.employee_id, e.employee_name, e.hp_no, d.period_name,t.testdate,
			  o.organization_code,p.amt,t.test_name,t.highestmark,t.lowestmark,t.averagemark
		from $tabletuitionclass c 
		inner join $tableperiod d on c.period_id=d.period_id
		inner join $tableproductlist p on c.product_id=p.product_id
		inner join $tableorganization o on o.organization_id=c.organization_id
		inner join $tabletest t on t.tuitionclass_id=c.tuitionclass_id
		inner join $tableemployee e on t.employee_id=e.employee_id
		where t.test_id=$test_id";

	if($tuitionclass_id>0){
	$sql="SELECT s.schedule_id,concat(day(s.class_datetime),'/',month(s.class_datetime)) as class_datetime
		FROM $tableclassschedule s where s.tuitionclass_id=$tuitionclass_id order by s.schedule_id";

	
	$query=$xoopsDB->query($sql) or die(mysql_error());
	$thschedule="";
	$k=0;

	while($row=$xoopsDB->fetchArray($query)){
		array_push($arrayscheduleheader,$rowschedule['schedule_id']);
		array_push($pdf->header,$rowschedule['class_datetime']);
		$k++;
	}
	$schedulecount=$k;
	}

	$querygetheader=$xoopsDB->query($sqlgetheader);
	while($rowgetheader=$xoopsDB->fetchArray($querygetheader)){
		$pdf->tuitionclass_code=$rowgetheader["tuitionclass_code"];
		$pdf->period_name=$rowgetheader["period_name"];
		$pdf->test_name=$rowgetheader["test_name"];
		$pdf->testdate=$rowgetheader["testdate"];
		$pdf->highestmark=$rowgetheader['highestmark'];
		$pdf->lowestmark=$rowgetheader['lowestmark'];
		$pdf->averagemark=$rowgetheader['averagemark'];
		$pdf->day=$rowgetheader["day"];
		$pdf->organization_code=$rowgetheader['organization_code'];
		$pdf->time=$rowgetheader["starttime"].' ~ '.$rowgetheader["endtime"];
		$pdf->employee_name=$rowgetheader["employee_name"];
		$pdf->e_hp_no=$rowgetheader["hp_no"];}

//	$header=array('No','Code','Student Name', 'Contact No.', 'School', 'Fees', '1st', '2nd', '3rd', '4th', '5th', 'RMK');
	
	//$sql="SELECT s.student_code, s.student_name, s.hp_no,s.tel_1, s.school, x.amt, x.isactive,x.comeactive, x.backactive from $tabletuitionclass c inner join $tablestudentclass x inner join $tableperiod d inner join $tablestudent s where x.tuitionclass_id=$tuitionclass_id and x.tuitionclass_id=c.tuitionclass_id and s.student_id=x.student_id and c.period_id=d.period_id order by s.student_name";
	$sql="SELECT s.student_id,s.student_code,s.alternate_name, s.student_name,
		concat(s.hp_no,'/', s.tel_1) as hp_no, tl.testline_id,tl.result,tl.description
		from $tabletuitionclass c 
		inner join $tabletest t on t.tuitionclass_id=c.tuitionclass_id
		inner join $tabletestline tl on tl.test_id=t.test_id
		inner join $tablestudent s on s.student_id=tl.student_id
		where tl.test_id=$test_id order by s.student_name";

	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;
		$backactive=$row['backactive'];
		$comeactive=$row['comeactive'];
		$student_id=$row['student_id'];
		$description=$row['description'];
		$result=$row['result'];
		$transport="";
		if($backactive=='Y' && $comeactive=='Y')
			$transport="D";
		elseif($backactive=="Y")
			$transport="B";		
		elseif($comeactive=='Y')
			$transport="C";
		else
			$transport="";
	
   $tmparray=array($i,$row['student_code'],$row['alternate_name'].'|||'.$row['student_name'],
			$result,$description,"");

	//get attendance		
  
		array_push($tmparray,' ');
		$data[]=$tmparray;
	
   
   	}
	while ($i<'30'){
	$i=$i+1;
   	$data[]=array($i,'','','','','');
   	}
	if ($i>'30')
	{
	while ($i<'60'){
	$i=$i+1;
   	$data[]=array($i,'','','','','');
   	}}
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddUniGBhwFont("uGB");
	$pdf->isUnicode=false;

	$pdf->AddPage();

	$pdf->BasicTable($header,$data,1);
	$pdf->MultiCell(180,7,$sqlgetheader,1,'C');
	
//	$pdf->isUnicode=false;

 	//$pdf->MultiCell(0,7,$sqlgetheader."lkjoihjohgjvj g f",1,'C');
 	
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


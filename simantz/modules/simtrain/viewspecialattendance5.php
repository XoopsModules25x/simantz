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
  public $description="Unknown"; 
  public $classtype="Unknown";
  public $classcount="Unknown";  
  public $employee_name="Unknown"; 
  public $e_hp_no="Unknown";
  public $e_isactive="Unknown";
  public $studentclass_id="Unknown";
  public $r_isactive="Unknown";
  public $amt;

//  public $scheduleheader=array();
  public $header=array('No','Index No','Student Name', 'Description', 'School','T');
  
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
    $this->Cell(120,17,"$this->period_name",1,0,'R');
	$this->SetX(90);
    $this->Cell(110,17,"$this->tuitionclass_code",1,0,'R');
	$this->SetXY(95,10);
//----------------
//    $this->Cell(105,17," ",1,0,'R');
    $this->SetFont('Times','',10);
	$this->SetXY(67,4);
    $this->Cell(40,17,"Month",0,0,'R');
	$this->SetXY(135,4);
    $this->Cell(0,17,"Class Code",0,0,'L');

    $this->Ln(25);
    $this->SetFont('Arial','',12);
    $this->Cell(32,8,"Report Title",1,0,'L');
    $this->Cell(0,8,"Attendance Sheet",1,0,'C');

    $this->Ln(11);
    $this->SetFont('Times','',10);
    $this->Cell(32,7,"Class Description",1,0,'L');
    $this->SetFont('Times','B',8);
    while($this->GetStringWidth($this->description)> 86)
			$this->description=substr_replace($this->description,"",-1);
    $this->Cell(87,7,$this->description,1,0,'C');
    $this->SetFont('Times','',10);
  //  $this->Cell(16,7,"Fees (RM)",1,0,'C');
  //  $this->SetFont('Times','B',10);
  //  $this->Cell(13,7,$this->amt,1,0,'C');
  //  $this->SetFont('Times','',10);
    $this->Cell(19,7,"Class Type",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(18,7,"Special",1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(19,7,"Day Count",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(10,7,$this->classcount,1,0,'C');
    $this->Ln(); 
    $this->SetFont('Times','',10);
    $this->Cell(32,7,"Tutor",1,0,'L');
    $this->SetFont('Times','B',10);
    $this->Cell(58,7,$this->employee_name,1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(29,7,"Tutor Contact",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(19,7,$this->e_hp_no,1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(18,7, "Place",1,0,'C');
    $this->SetFont('Times','B',10);
    $this->Cell(29,7, "$this->organization_code",1,0,'C');

$this->Ln(4);
$this->Ln();
$i=0;


	//$header=array('No','Index No','Student Name', 'Contact No.', 'School','T');
	//array_push($header,$this->scheduleheader);
   $w=array(6,14,54,39,16,6,6,6,6,6,6,20); //12 data
//array_push($this->header,"RMK");
foreach($this->header as $col)
      	{
	if($i <=10 && $i>=6)
	$this->SetFont('Times','B',7);
	else
	$this->SetFont('Times','B',9);
	 
       	$this->Cell($w[$i],7,$col,1,0,'C');
	$i=$i+1;		

	}
	while($i<=10){//complete show column
	  	$this->Cell($w[$i],7,"",1,0,'C');
		$i++;
	}
	  	$this->Cell($w[$i],7,"RMK",1,0,'C');
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
    $w=array(6,14,54,39,16,6,6,6,6,6,6,20); //12 data
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
$schedulecount=0;
$arrayscheduleheader=array();


if (isset($_POST['submit'])){

$tuitionclass_id=$_POST["tuitionclass_id"];
$period_id=$_POST["period_id"];
$pdf=new PDF('P','mm','A4');
if($att_showcontact=='Y')
$pdf->header=array('No','Index No','Student Name', 'Contact No', 'School','T');
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(15);
	$pdf->SetAutoPageBreak(true ,50);

//}
//if (isset($_GET['tuitionclass_id']) || isset($_GET['period_id'])){

//$tuitionclass_id=$_GET["tuitionclass_id"];
//$period_id=$_GET["period_id"];
//}
	$sqlgetheader="SELECT c.tuitionclass_id, c.tuitionclass_code, c.description, c.day, c.starttime, 
			c.endtime, e.employee_id, e.employee_name, e.hp_no, d.period_name,
			  o.organization_code,p.amt,c.classtype,c.classcount
		from $tabletuitionclass c 
		inner join $tableemployee e on c.employee_id=e.employee_id
		inner join $tableperiod d on c.period_id=d.period_id
		inner join $tableproductlist p on c.product_id=p.product_id
		inner join $tableorganization o on o.organization_id=c.organization_id
		where c.tuitionclass_id=$tuitionclass_id";

	if($tuitionclass_id>0){
	$sqlschedule="SELECT s.schedule_id,concat(day(s.class_datetime),'/',month(s.class_datetime)) as class_datetime
		FROM $tableclassschedule s where s.tuitionclass_id=$tuitionclass_id order by s.schedule_id";

	
	$queryschedule=$xoopsDB->query($sqlschedule) or die(mysql_error());
	$thschedule="";
	$k=0;

	while($rowschedule=$xoopsDB->fetchArray($queryschedule)){
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
		$pdf->description=$rowgetheader["description"];
		$pdf->amt=$rowgetheader["amt"];
		$pdf->classcount=$rowgetheader["classcount"];
		$pdf->organization_code=$rowgetheader['organization_code'];
		$pdf->classtype=$rowgetheader["classtype"];
		$pdf->employee_name=$rowgetheader["employee_name"];
		$pdf->e_hp_no=$rowgetheader["hp_no"];}
//	$header=array('No','Code','Student Name', 'Contact No.', 'School', 'Fees', '1st', '2nd', '3rd', '4th', '5th', 'RMK');
	
	//$sql="SELECT s.student_code, s.student_name, s.hp_no,s.tel_1, s.school, x.amt, x.isactive,x.comeactive, x.backactive from $tabletuitionclass c inner join $tablestudentclass x inner join $tableperiod d inner join $tablestudent s where x.tuitionclass_id=$tuitionclass_id and x.tuitionclass_id=c.tuitionclass_id and s.student_id=x.student_id and c.period_id=d.period_id order by s.student_name";
	$sql="SELECT s.student_id,s.student_code,s.alternate_name, s.student_name,
		concat(s.hp_no,'/', s.tel_1) as hp_no, sch.school_name, std.standard_name,x.amt, 
		x.isactive, x.studentclass_id".
		",x.comeactive, x.backactive,x.description from $tabletuitionclass c ".
		" inner join $tablestudentclass x inner join $tableperiod d ".
		" inner join $tablestudent s on s.student_id=x.student_id ".
		" inner join $tablestandard std on s.standard_id=std.standard_id ".
		" inner join $tableschool  sch on s.school_id=sch.school_id ".
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
		$student_id=$row['student_id'];
		$description=$row['description'];

		$transport="";
		if($backactive=='Y' && $comeactive=='Y')
			$transport="D";
		elseif($backactive=="Y")
			$transport="B";		
		elseif($comeactive=='Y')
			$transport="C";
		else
			$transport="";
if($att_showcontact=='N')		
   $tmparray=array($i,$row['student_code'],$row['alternate_name'].'|||'.$row['student_name'],
			$description,$row['school_name'],$transport);
else
   $tmparray=array($i,$row['student_code'],$row['alternate_name'].'|||'.$row['student_name'],
			$row['hp_no'],$row['school_name'],$transport);

	//get attendance		
   $columncount=0;
   foreach($arrayscheduleheader as $id){
		$sqlscheduleschild="SELECT attendance_id, student_id,attendance_time,schedule_id 
			FROM $tableattendance WHERE schedule_id=$id and student_id=$student_id";


		$queryDetail=$xoopsDB->query($sqlscheduleschild);
		$attendance_id=0;
		$attendance_time="";
		
		if($rowscheduleschild =$xoopsDB->fetchArray($queryDetail)){
				$attendance_id=$rowscheduleschild['attendance_id'];
				$attendance_time=$rowscheduleschild['attendance_time'];
				//$this->log->showLog(3,"Attd id/time: $attendance_id/$attendance_time");
				if($attendance_id>0)
					array_push($tmparray,'X');
				
		}
		else
			array_push($tmparray,' ');
		$columncount++;
	}
		while($columncount<5){
			array_push($tmparray,' ');
			$columncount++;
		}		
		array_push($tmparray,' ');
		$data[]=$tmparray;
	
   
   	}
	while ($i<'30'){
	$i=$i+1;
   	$data[]=array($i,'','','','','','','','','','','','');
   	}
	if ($i>'30')
	{
	while ($i<'60'){
	$i=$i+1;
   	$data[]=array($i,'','','','','','','','','','','','');
   	}}
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddUniGBhwFont("uGB");
	$pdf->isUnicode=false;

	$pdf->AddPage();

	$pdf->BasicTable($header,$data,1);
	//$pdf->MultiCell(180,7,$sqlscheduleschild,1,'C');
	
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


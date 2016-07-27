<?php

include_once('fpdf/chinese-unicode.php');
include_once ('system.php');
include_once('class/Organization.php');
include_once('class/Log.php');


$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  public $student_id="Unknown";
  public $student_code="Unknown";
  public $student_name="Unknown"; 
  public $s_hp_no="Unknown"; 
  public $s_tel_1="Unknown"; 
  public $s_isactive="Unknown";
  public $tuitionclass_id="Unknown";
  public $period_id="Unknown";
  public $tuitionclass_code;  
  public $description="Unknown"; 
  public $tuitiondate="Unknown";
  public $starttime="Unknown";
  public $cur_name="Unknown";
  public $cur_symbol="Unknown";
  public $endtime="Unknown";
  public $rowtitle="Unknown";
  public $studentclass_id="Unknown";
  public $case="??";
  public $headertail="Unknown";
  public $r_isactive="Unknown";
  public $timestamp="Unknown"; 
  public $header="Unknown";
  public $fromto="Unknown"; 
function Header()
{
  
    $this->SetFont('Arial','B',20);

    $this->Cell(0,20,"T",1,0,'L');//unknown reason for pdf can't display well in many tab, use this option to solve.
    $this->SetXY(80,12);
    $this->SetFont('Arial','',10);
    $this->Cell(0,3,"DATE",0,0,'L');
    $this->SetXY(140,12);
    $this->SetFont('Arial','',10);
    $this->Cell(0,3,$this->fromto,0,0,'L');

    $this->SetXY(82,19);
    $this->SetFont('Arial','B',30);
    $this->Cell(0,7,$this->tuitiondate,0,0,'L');

    $this->SetXY(142,19);
    $this->SetFont('Arial','B',30);
    $this->Cell(0,7,$this->headertail,0,0,'L');
    $this->SetXY(11,13);
    $this->SetFont('Arial','',10);
    $this->Cell(0,1,$this->case,0,0,'L'); //use this statement to solve unknown reason cause by open exactly same report in multi-tab, eventhough difference parameter'd submited 

    $this->Image('./images/attlistlogo.jpg', 11 , 11 , 70 , '' , 'JPG' , '');
  
   $this->SetXY(200,25);

	$this->Ln(8);
    $w=array(15,5,30,39,7,44,32,18,15); //10 data
	$i=1;
foreach($this->header as $col)
      	{
$this->SetFont('Arial','B',9); 
       	$this->Cell($w[$i],7,$col,1,0,'C');
	$i=$i+1;		
	}	
$this->Ln();
}

function Footer()
{
    //Position at 1.5 cm from bottom
    $timestamp=date("d/m/y", time());
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(140,10,' ',0,0,'L');
    $this->Cell(0,10,$timestamp.' Page ' . $this->PageNo() . '/{nb}',0,0,'R');
}

function BasicTable($header,$data,$printheader)
{
//Column widths

    $w=array(15,5,30,39,7,44,32,18,15); //10 data
	$i=1;
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

$colold="";

   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {
		if ($i==0)
		{
			if ($col==$colold)
			{
				$this->SetFont('Times','',9);
			}
			else
			{
				$this->SetFont('Times','B',10);
				$this->Cell(0,7,$this->rowtitle.$col,1,0,'L');
				$this->Ln();
			}
			$colold=$col;
		}
		if ($i<=8)
		{
			$this->SetFont('Times','',9);
			while($this->GetStringWidth($col)> $w[$i])
				$col=substr_replace($col,"",-1);
		}

	        if ($i==1 || $i==2 ||  $i==8)
		{
			$this->SetFont('Times','',9);
        		    $this->Cell($w[$i],6,$col,1,0,'L');
		}
		elseif($i==4 && $i==6 && $i==7){
			$this->SetFont('Times','',8);
        		    $this->Cell($w[$i],6,$col,1,0,'L');

		}
		elseif ($i==0)
		{
		}
		else
		{
			$this->SetFont('Times','',8);
	     		$this->Cell($w[$i],6,$col,1,0,'L');
		}
        	$i=$i+1;
    	}
        $this->Ln();
	}
}// end function
}//end class

$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tablestudentclass=$tableprefix . "simtrain_studentclass";
$tableperiod=$tableprefix . "simtrain_period";
$tableaddress=$tableprefix . "simtrain_address";
$tablearea=$tableprefix . "simtrain_area";
$tableorganization=$tableprefix . "simtrain_organization";
$tableattendance=$tableprefix . "simtrain_attendance";
$tableschedule=$tableprefix . "simtrain_classschedule";

$case="";
$log=new Log(0);
$o = new Organization($xoopsDB,$tableprefix,$log);
 
if (isset($_POST['submit'])){
$pdf=new PDF('P','mm','A4');

$organization_id=$_POST["organization_id"];
//$day=$_POST["day"];
$tuitiondate=$_POST["tuitiondate"];
$case=$_POST["transporttype"];
$pdf->tuitiondate=$tuitiondate;

$o->fetchOrganization($organization_id);
$headertail=$o->organization_code;

$pdf->case=$case;
$timetitle="";

switch ($case){
  case "0":
	$pdf->header=array('No','Area Name', 'Student Name', 'No.', 'Address1', 'Contact', 'Class Code', 'Time Out');
	/*$sql="SELECT c.starttime, c.endtime, c.tuitionclass_code, c.description, s.student_name, s.hp_no, s.tel_1, a.no, ".
		" a.street1, a.street2, r.isactive from $tabletuitionclass c ".
		" inner join $tablestudentclass r on c.tuitionclass_id=r.tuitionclass_id ".
		" inner join $tableperiod d on c.period_id=d.period_id ".
		" inner join $tablestudent s on s.student_id=r.student_id ".
		" inner join $tableaddress a on a.address_id=r.comeareafrom_id ".
		" where c.day='$day'  and c.period_id=$period_id  and r.comeactive='Y' and r.isactive='Y' ".
		" and c.organization_id=$organization_id order by c.starttime, a.street2, a.street1, a.no, s.student_name";
	*/
	$sql="SELECT time_format(scc.class_datetime,'%H:%i:%S')  as starttime,
		c.tuitionclass_code,c.description,s.student_name,s.hp_no, s.tel_1,
		a.no,a.street1, a.street2, r.isactive, time_format(DATE_ADD(scc.class_datetime, INTERVAL c.hours HOUR),'%H:%i:%S')  as endtime
		from $tabletuitionclass c
		inner join $tablestudentclass r on c.tuitionclass_id=r.tuitionclass_id
		inner join $tableperiod d on c.period_id=d.period_id
		inner join $tablestudent s on s.student_id=r.student_id
		inner join $tableaddress a on a.address_id=r.comeareafrom_id
		inner join $tableschedule scc on scc.tuitionclass_id=c.tuitionclass_id
		where date(scc.class_datetime) ='$tuitiondate' and r.comeactive='Y' and r.isactive='Y'
		and c.organization_id=$organization_id order by scc.class_datetime, a.street2, a.street1, a.no,
		s.student_name";

	$pdf->fromto="TO";
	$pdf->headertail=$headertail;
	$pdf->rowtitle=" Class Start Time : ";

	$query=$xoopsDB->query($sql) or die(mysql_error());
	$i=0;
	$j=0;


	$data=array();
	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){
	if($i==0)
	$timetitle=$row['starttime'];
	$j++;
	$i=$i+1;
	if($timetitle!=$row['starttime'] ){
		$data[]=array($timetitle,$j++,'','','','','','','');
		$data[]=array($timetitle,$j++,'','','','','','','');
		$data[]=array($timetitle,$j++,'','','','','','','');
	
		$timetitle=$row['starttime'];
		$j=1;

	}

   	$data[]=array($row['starttime'],$j,$row['street2'],$row['student_name'],$row['no'],$row['street1'],$row['hp_no'].'/'. 
		$row['tel_1'],$row['tuitionclass_code'],$row['endtime']);

   	}
  break;
  case "1":
	$pdf->header=array('No','Area Name', 'Student Name', 'No.', 'Address1', 'Contact', 'Class Code', 'Time In');
	
	$sql="SELECT time_format(DATE_ADD(scc.class_datetime, INTERVAL c.hours HOUR),'%H:%i:%S')  as endtime,
		c.tuitionclass_code,c.description,s.student_name,s.hp_no, s.tel_1,
		a.no,a.street1, a.street2, r.isactive,time_format(scc.class_datetime,'%H:%i:%S') as starttime
		from $tabletuitionclass c
		inner join $tablestudentclass r on c.tuitionclass_id=r.tuitionclass_id
		inner join $tableperiod d on c.period_id=d.period_id
		inner join $tablestudent s on s.student_id=r.student_id
		inner join $tableaddress a on a.address_id=r.comeareafrom_id
		inner join $tableschedule scc on scc.tuitionclass_id=c.tuitionclass_id
		where date(scc.class_datetime) ='$tuitiondate' and r.backactive='Y' and r.isactive='Y'
		and c.organization_id=$organization_id order by scc.class_datetime, a.street2, a.street1, a.no,
		s.student_name";
	$pdf->fromto="FROM";
	$pdf->headertail=$headertail;
	$pdf->rowtitle=" Class End Time : ";
	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){
	if($i==0)
	$timetitle=$row['endtime'];
	$j++;
	$i=$i+1;
	if($timetitle!=$row['endtime'] ){
		$data[]=array($timetitle,$j++,'','','','','','','');
		$data[]=array($timetitle,$j++,'','','','','','','');
		$data[]=array($timetitle,$j++,'','','','','','','');
		$timetitle=$row['endtime'];
		$j=0;

	}
  	$data[]=array($row['endtime'],$j,$row['street2'],$row['student_name'],$row['no'],$row['street1'],$row['hp_no'].'/'.$row['tel_1'],$row['tuitionclass_code'],$row['starttime']);
   	}
  break;
  default:
 $pdf->header=array('No','Area Name', 'Student Name', 'No.', 'Address1', 'Contact', 'Class Code', 'Time Out');
	
	$sql="SELECT  time_format(DATE_ADD(scc.class_datetime, INTERVAL c.hours HOUR),'%H:%i:%S')  as endtime,
		c.tuitionclass_code,c.description,s.student_name,s.hp_no, s.tel_1,
		a.no,a.street1, a.street2, r.isactive, time_format(scc.class_datetime,'%H:%i:%S') as starttime
		from $tabletuitionclass c
		inner join $tablestudentclass r on c.tuitionclass_id=r.tuitionclass_id
		inner join $tableperiod d on c.period_id=d.period_id
		inner join $tablestudent s on s.student_id=r.student_id
		inner join $tableaddress a on a.address_id=r.comeareafrom_id
		inner join $tableschedule scc on scc.tuitionclass_id=c.tuitionclass_id
		where date(scc.class_datetime) ='$tuitiondate' and r.backactive='Y' and r.isactive='Y'
		and c.organization_id=$organization_id order by scc.class_datetime, a.street2, a.street1, a.no,
		s.student_name";
	$pdf->$fromto="FROM";
	$pdf->headertail=$headertail;
	$pdf->rowtitle=" Class End Time : ";
	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	
	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){
	if($i==0)
	$timetitle=$row['endtime'];
	$j++;
	$i=$i+1;
	if($timetitle!=$row['endtime'] ){
		$data[]=array($timetitle,$j++,'','','','','','','');
		$data[]=array($timetitle,$j++,'','','','','','','');
		$data[]=array($timetitle,$j++,'','','','','','','');
		$timetitle=$row['endtime'];
		$j=0;
	}
  	$data[]=array($j,$row['endtime'],$j,$row['street2'],$row['student_name'],$row['no'],$row['street1'],$row['hp_no'].'/'.$row['tel_1'],$row['tuitionclass_code'],$row['starttime']);
   	}
}
$j=$j+1;
/*
	while ($i<40){
	$i=$i+1;
	$data[]=array('','','','','','','','','','');
   	}
	if($i>40){
	while ($i<$j){
	$i=$i+1;
	$data[]=array('','','','','','','','','','');
   	}}*/
	//print header
		$data[]=array($timetitle,$j++,'','','','','','','');
		$data[]=array($timetitle,$j++,'','','','','','','');
		$data[]=array($timetitle,$j++,'','','','','','','');

$pdf->SetFont('Arial','',10);
$pdf->AliasNbPages();
$pdf->AddPage();
	$pdf->BasicTable($header,$data,1);  
 //$pdf->MultiCell(0,6,"$sql");

	//display pdf
	$pdf->Output();
	//exit (1);

}
else {
	require(XOOPS_ROOT_PATH.'/header.php');
	echo "<td>Error during retrieving Invoice ID on viewinvoice.php(~line 206)," . 
		" please contact software developer kstan@simit.com.my</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');
}
?>


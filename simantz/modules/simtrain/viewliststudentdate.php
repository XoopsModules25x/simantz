<?php
include_once('fpdf/chinese-unicode.php');
include_once ('system.php');



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends PDF_Unicode
{
 public $tuitiondate;
  public $organization_code="unknown";
function Header()
{
   
   $this->Image('upload/images/attlistlogo.jpg', 12 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Arial','B',18);
    $this->SetXY(10,10);
    $this->Cell(0,17," ",1,0,'R');
    $this->SetXY(100,6);
    $this->Cell(0,17,"Student Vs Date Report",0,0,'R');

  
    $this->SetFont('Times','',9);
    $this->SetXY(110,19);
    $this->Cell(18,8,"Date",1,0,'L');
  $this->SetFont('Times','B',10);  
  $this->Cell(18,8,$this->tuitiondate,1,0,'C');
    $this->SetFont('Times','',9);
    $this->Cell(23,8,"Organization",1,0,'C');

 while($this->GetStringWidth($this->organization_code)>28)
		$this->organization_code=substr_replace($this->organization_code,"",-1); 
    $this->SetFont('Times','B',9);
    $this->Cell(31,8,"$this->organization_code",1,0,'C');
    $this->Ln(10);
$i=0;

//    $this->SetFont('Times','B',9);
	$header=array('No','Index','Student Name','Parent Name', 'Parent Contact',"Tel", "HP No", 'Earliest Time');
    $w=array(8,13,52,30,22,20,20,25);
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
    $w=array(8,13,52,30,22,20,20,25);
	$i=0;


$this->SetFont('Times','',9);
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {

        //chop long string to fit in col uname, student name
	if ($i==2){
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
     else          {
     while($this->GetStringWidth($col)> $w[$i] && $i!=2)
			$col=substr_replace($col,"",-1);
	     $this->Cell($w[$i],6,$col,1,0,'R');
	                 }
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
$orgctrl=$permission->selectionOrg($uid,0);
$organization_id=0;

if (isset($_POST['submit'])){



	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->cur_name=$cur_name;
	$pdf->cur_symbol=$cur_symbol;
   

        $organization_id=$_POST["organization_id"];
	$pdf->tuitiondate=$_POST['tuitiondate'];
	$pdf->organization_code=$_POST['organization_code'];
//	$wherestring="p.payment_datetime between '$pdf->datefrom' and '$pdf->dateto'";
	$sql="SELECT DISTINCT (s.student_id) as student_id, s.student_code, s.student_name,
		s.alternate_name, s.tel_1, s.hp_no,pr.parents_name,pr.parents_contact,o.organization_code,
		min( date_format( scc.class_datetime, '%H:%i:%S' ) ) AS class_datetime
		FROM sim_simtrain_student s
		INNER JOIN sim_simtrain_studentclass sc ON sc.student_id = s.student_id
		INNER JOIN sim_simtrain_tuitionclass t ON sc.tuitionclass_id = t.tuitionclass_id
		INNER JOIN sim_simtrain_parents pr ON pr.parents_id = s.parents_id
		INNER JOIN sim_simtrain_classschedule scc ON scc.tuitionclass_id = t.tuitionclass_id
		INNER JOIN sim_simtrain_organization o ON o.organization_id = t.organization_id
		WHERE s.student_id >0
		AND date_format( scc.class_datetime, '%Y-%m-%d' ) = '$pdf->tuitiondate'
		AND t.organization_id=$organization_id
		GROUP BY s.student_code, s.student_name, s.alternate_name, s.tel_1,
		s.hp_no,pr.parents_name,pr.parents_contact";

	$query=$xoopsDB->query($sql);
	$total=0;
	$rowtype="";
	$data=array();
	$i=0;
	while($row=$xoopsDB->fetchArray($query)) {
			$i++;
		$student_code=$row['student_code'];
		$student_name=$row['student_name'];
		$alternate_name=$row['alternate_name'];
		$student_id=$row['student_id'];

		$organization_code=$row['organization_code'];
		$tel_1=$row['tel_1'];
		$hp_no=$row['hp_no'];
		$class_datetime=$row['class_datetime'];
		$parents_contact=$row['parents_contact'];
		$parents_name=$row['parents_name'];
		$data[]=array($i,$student_code,$alternate_name.'|||'.$student_name,$parents_name,$parents_contact,
			$tel_1,$hp_no,$class_datetime);
		
	}

	//print header
	$pdf->SetFont('Arial','',10);
		$pdf->AddUniGBhwFont("uGB");
	$pdf->isUnicode=false;
	$pdf->AddPage();
   	//$pdf->MultiCell(0,10,$sql,0,'C');
	$pdf->BasicTable($data);
	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output();
	exit (1);

}
	require(XOOPS_ROOT_PATH.'/footer.php');

?>


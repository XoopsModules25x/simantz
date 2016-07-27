<?php
require('fpdf/fpdf.php');
include_once "system.php";


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
public $worker_id	;
public $worker_no	;
public $worker_code	="Unknown";
public $worker_name	="Unknown";
public $dateofbirth	;
public $ic_no	;
public $gender	;
public $races_id	;
public $nationality_id	;
public $passport_no	;
public $home_street1	;
public $home_street2	;
public $home_postcode	;
public $home_city	;
public $home_state	;
public $home_country	;
public $email	;
public $home_tel1	;
public $home_tel2	;
public $handphone	;
public $maritalstatus	;
public $family_contactname	;
public $family_contactno	;
public $relationship	;
public $skill	;
public $educationlevel	;
public $bank_name	;
public $bank_acc	;
public $bankacc_type	;
public $description	;
public $created	;
public $createdby	;
public $updated	;
public $updatedby	;
public $isactive	;
public $arrivaldate	;
public $workerstatus	;
public $departuredate	;
public $nationality_name;
public $races_name	;

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
*/
   $this->Image('./images/attlistlogo.jpg', 15 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Times','B',20);
//-------------------------
	$this->SetXY(15,10);
    $this->Cell(120,17,"$this->worker_code",1,0,'R');
	$this->SetX(90);
    $this->Cell(110,17,"$this->worker_name",1,0,'R');
	$this->SetXY(95,10);
//----------------
//    $this->Cell(105,17," ",1,0,'R');
    $this->SetFont('Times','B',10);
	$this->SetXY(67,4);
    $this->Cell(45,17,"Worker Code",0,0,'R');
	$this->SetXY(135,4);
    $this->Cell(0,17,"Worker Name",0,0,'L');

    $this->Ln(25);
    $this->SetFont('Arial','B',14);
    $this->Cell(32,10,"Report Title",1,0,'L');
    $this->Cell(0,10,"Foreign Worker Profile",1,0,'C');
    
	$this->SetFont('Arial','',12);
	$this->Ln(14);
	$this->Cell(40,5,"Nationality",1,0,'L');
	$this->Cell(80,5,"$this->nationality_name",1,0,'L');
	$this->Ln(5);
	$this->Cell(40,5,"Races",1,0,'L');
	$this->Cell(80,5,"$this->races_name",1,0,'L');
	$this->Ln(5);
	$this->Cell(40,5,"Passport No",1,0,'L');
	$this->Cell(80,5,"$this->passport_no",1,0,'L');
	$this->Ln(5);
	$this->Cell(40,5,"IC No",1,0,'L');
	$this->Cell(80,5,"$this->ic_no",1,0,'L');
	$this->Ln(5);
	$this->Cell(40,5,"Date Of Birth",1,0,'L');
	$this->Cell(80,5,"$this->dateofbirth",1,0,'L');
	$this->Ln(5);
	$this->Cell(40,5,"Gender",1,0,'L');
	$this->Cell(80,5,"$this->gender",1,0,'L');
	$this->Ln(5);
	$this->Cell(40,5,"Marital Status",1,0,'L');
	$this->Cell(80,5,"$this->maritalstatus",1,0,'L');
	$this->Ln(5);
	$this->Cell(40,5,"Arrival Date",1,0,'L');
	$this->Cell(80,5,"$this->arrivaldate",1,0,'L');
	$this->Ln(5);
	$this->Cell(40,5,"Bank",1,0,'L');
	$this->Cell(80,5,"$this->bank_name",1,0,'L');
	$this->Ln(5);
	$this->Cell(40,5,"Account No",1,0,'L');
	$this->Cell(80,5,"$this->bank_acc",1,0,'L');
	$this->Ln(5);
	$this->Cell(40,5,"Hanphone",1,0,'L');
	$this->Cell(80,5,"$this->handphone",1,0,'L');
	$this->Ln(5);
	$this->Cell(40,5,"Email",1,0,'L');
	$this->Cell(80,5,"$this->email",1,0,'L');
	$this->Ln(5);
	$this->Cell(40,5,"Emergency Contact",1,0,'L');
	$this->Cell(80,5,"$this->family_contactname/$this->family_contactno/$this->relationship",1,0,'L');
	$this->Ln(5);
	$this->Cell(40,5,"Education Level",1,0,'L');
	$this->Cell(80,5,"$this->educationlevel",1,0,'L');

	$this->SetXY(135,43);
	$this->Cell(65,70,"",1,0,'L');

	$photoname="./images/photo/$this->worker_id.jpg";
	if(file_exists($photoname) )
		$this->Image("$photoname", 145 ,47 , 45 , "" , 'JPG' , '');
	else
 		$this->Image("./images/photo/0.jpg", 145 ,47 , 45 , '' , 'JPG' , '');


	$this->SetXY(15,120);
	$this->Cell(0,5,"Home Town Contact",1,0,'C');
	$this->Ln(5);

	$this->SetFont('Arial','',12);
	$this->Cell(20,5,"Street 1",1,0,'L');
	$this->Cell(72,5,"$this->home_street1",1,0,'L');
	$this->Cell(20,5,"Street 2",1,0,'L');
	$this->Cell(73,5,"$this->home_street2",1,0,'L');
	$this->Ln(5);
	$this->Cell(20,5,"City",1,0,'L');
	$this->Cell(72,5,"$this->home_city",1,0,'L');
	$this->Cell(20,5,"Postcode",1,0,'L');
	$this->Cell(73,5,"$this->home_postcode",1,0,'L');
	$this->Ln(5);
	$this->Cell(20,5,"State",1,0,'L');
	$this->Cell(72,5,"$this->home_state",1,0,'L');
	$this->Cell(20,5,"Country",1,0,'L');
	$this->Cell(73,5,"$this->home_country",1,0,'L');
	$this->Ln(5);
	$this->Cell(20,5,"Tel 1",1,0,'L');
	$this->Cell(72,5,"$this->home_tel1",1,0,'L');
	$this->Cell(20,5,"Tel 2",1,0,'L');
	$this->Cell(73,5,"$this->home_tel2",1,0,'L');
	$this->Ln(5);
	
	$this->SetXY(15,150);
	$this->Cell(0,5,"Skill",1,0,'C');
	$this->SetXY(15,155);
	$this->Cell(0,40,"",1,0,'L');
	$this->SetXY(15,156);
	$this->MultiCell(0,5,"$this->skill",0,'L');

 
	$this->SetXY(15,200);
	$this->Cell(0,5,"Others Info",1,0,'C');
	$this->SetXY(15,205);
	$this->MultiCell(0,40,"",1,'L');
 	$this->SetXY(15,207);
	$this->MultiCell(0,5,"$this->description",0,'L');
 
   // while($this->GetStringWidth($this->description)> 57)
	//		$this->description=substr_replace($this->description,"",-1);
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

}

$tableprefix= XOOPS_DB_PREFIX . "_";
$tableworker=$tableprefix . "simfworker_worker";
$tablenationality=$tableprefix . "simfworker_nationality";
$tableraces=$tableprefix . "simfworker_races";

if (isset($_POST['submit'])){

$worker_id=$_POST["worker_id"];
//$period_id=$_POST["period_id"];
	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(15);
	$pdf->SetAutoPageBreak(true ,50);

//}
//if (isset($_GET['tuitionclass_id']) || isset($_GET['period_id'])){

//$tuitionclass_id=$_GET["tuitionclass_id"];
//$period_id=$_GET["period_id"];
//}
	$sql="SELECT w.worker_id, w.worker_no, w.worker_code, w.worker_name, w.dateofbirth, w.ic_no,".
		"w.gender, w.races_id, w.nationality_id, w.passport_no, w.home_street1, w.home_street2, ".
		"w.home_postcode, w.home_city, w.home_state, w.home_country, w.email, w.home_tel1, ".
		"w.home_tel2, w.handphone, w.maritalstatus, w.family_contactname, w.family_contactno, ".
		"w.relationship, w.skill, w.educationlevel, w.bank_name, w.bank_acc, w.bankacc_type, ".
		"w.description, w.created, w.createdby, w.updated, w.updatedby, w.isactive,".
		"w.arrivaldate, w.workerstatus, w.departuredate,n.nationality_name, r.races_name FROM $tableworker w ".
		"INNER JOIN $tableraces r on w.races_id=r.races_id ".
		"INNER JOIN $tablenationality n on w.nationality_id=n.nationality_id";

	$query=$xoopsDB->query($sql);
	while($row=$xoopsDB->fetchArray($query)){
		$pdf->worker_id	=$row['worker_id'];
		$pdf->worker_no	=$row['worker_no'];
		$pdf->worker_code	=$row['worker_code'];
		$pdf->worker_name	=$row['worker_name'];
		$pdf->dateofbirth	=$row['dateofbirth'];
		$pdf->ic_no	=$row['ic_no'];
		$pdf->gender	=$row['gender'];
		$pdf->races_id	=$row['races_id'];
		$pdf->nationality_id	=$row['nationality_id'];
		$pdf->passport_no	=$row['passport_no'];
		$pdf->home_street1	=$row['home_street1'];
		$pdf->home_street2	=$row['home_street2'];
		$pdf->home_postcode	=$row['home_postcode'];
		$pdf->home_city	=$row['home_city'];
		$pdf->home_state	=$row['home_state'];
		$pdf->home_country	=$row['home_country'];
		$pdf->email	=$row['email'];
		$pdf->home_tel1	=$row['home_tel1'];
		$pdf->home_tel2	=$row['home_tel2'];
		$pdf->handphone	=$row['handphone'];

		switch($row['gender']){
			case "M":
				$pdf->gender="Male";
			break;
			case "F":
				$pdf->gender="Female";
			break;
		}

		
		switch($row['maritalstatus']){
			case "S":
				$pdf->maritalstatus="Single";
			break;
			case "M":
				$pdf->maritalstatus="Married";
			break;
			case "D":
				$pdf->maritalstatus="Divorced";
			break;
		}

		$pdf->family_contactname	=$row['family_contactname'];
		$pdf->family_contactno	=$row['family_contactno'];
		$pdf->relationship	=$row['relationship'];
		$pdf->skill	=$row['skill'];
		$pdf->educationlevel	=$row['educationlevel'];
		$pdf->bank_name	=$row['bank_name'];
		$pdf->bank_acc	=$row['bank_acc'];
		$pdf->bankacc_type	=$row['bankacc_type'];
		$pdf->description	=$row['description'];
		$pdf->created	=$row['created'];
		$pdf->createdby	=$row['createdby'];
		$pdf->updated	=$row['updated'];
		$pdf->updatedby	=$row['updatedby'];
		$pdf->isactive	=$row['isactive'];
		$pdf->arrivaldate	=$row['arrivaldate'];
		$pdf->workerstatus	=$row['workerstatus'];
		$pdf->departuredate	=$row['departuredate'];
		$pdf->races_name	=$row['races_name'];
		$pdf->nationality_name	=$row['nationality_name'];
}

	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	//$pdf->MultiCell(100,7,"$sql",1,'C');
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


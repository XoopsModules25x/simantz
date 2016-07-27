<?php
require('fpdf/fpdf.php');
include_once "system.php";



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  public $worker_id="Unknown";
  public $worker_code="Unknown";
  public $worker_name="Unknown"; 
 
function Header()
{
    $this->Image('./images/attlistlogo.jpg', 10 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Times','B',17);
    $this->Cell(80,17," ",1,0,'R');
    $this->Cell(40,17,"$this->worker_code",1,0,'L');
    $this->Cell(0,17,"$this->worker_name",1,0,'L');

    $this->SetFont('Times','B',10);
	$this->SetXY(90,4);
    $this->Cell(40,17,"Worker Code ",0,0,'L');
	$this->SetXY(130,4);
    $this->Cell(0,17,"Worker Name",0,0,'L');

    $this->Ln(25);
    $this->SetFont('Arial','B',12);
    $this->Cell(32,8,"Report Title",1,0,'L');
    $this->Cell(0,8,"Worker Employment History",1,0,'C');


//foreach($header as $col)
  //    	{
	//$this->SetFont('Arial','B',9); 
       //	$this->Cell($w[$i],7,$col,1,0,'C');
//	$i=$i+1;		
//	}	
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

function BasicTable($data)
{
    $w=array(7,40,20,18,18,25,25,8,13,16);
	$i=0;

$this->SetFont('Arial','',9);
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {

	//if ($i==4 || $i==2 || $i==3)
		while($this->GetStringWidth($col)> $w[$i])
			$col=substr_replace($col,"",-1);		

      //  if ($i==2)
        //    $this->Cell($w[$i],6,$col,1,0,'L');
 	//else
	     $this->Cell($w[$i],6,$col,1,0,'C');
	
            $i=$i+1;
            }
        $this->Ln();
    }

}
}
$tableprefix= XOOPS_DB_PREFIX . "_";
$tableworker=$tableprefix . "simfworker_worker";
$tablecurrency=$tableprefix . "simfworker_currency";
$tablecompany=$tableprefix . "simfworker_company";
$tableworkercompany=$tableprefix . "simfworker_workercompany";

if (isset($_POST["worker_id"])){

$worker_id=$_POST["worker_id"];
$wherestring=$_POST['wherestring'];
$orderbystring=$_POST['orderbystring'];

	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true ,7);
//}
//if (isset($_GET['tuitionclass_id']) || isset($_GET['period_id'])){

//$tuitionclass_id=$_GET["tuitionclass_id"];
//$period_id=$_GET["period_id"];
//}
	$sql="SELECT w.worker_id,w.worker_code,w.worker_name,c.company_id,c.company_name, wc.worker_no, wc.position, ".
		"wc.currency_id,wc.joindate,wc.resigndate,wc.salary,wc.workerstatus,wc.department,cr.currency_symbol ".
		"FROM $tableworkercompany wc " .
		"INNER JOIN $tableworker w on wc.worker_id=w.worker_id ".
		"INNER JOIN $tablecompany c on wc.company_id=c.company_id ".
		"INNER JOIN $tablecurrency cr on cr.currency_id=wc.currency_id".
		"$wherestring $orderbystring ";

	$query=$xoopsDB->query($sql);
	$data=array();
	$i=0;
	$data[]=array("No","Company Name" ,"Worker No","Join Date", "Resign Date" ,"Department", "Position"
			,"Cur.","Salary","Status");
	while($row=$xoopsDB->fetchArray($query)){
		$i++;
		$pdf->worker_code=$row['worker_code'];
		$pdf->worker_name=$row['worker_name'];
		$worker_no=$row['worker_no'];
		$company_name=$row['company_name'];
		$position=$row['position'];
		$department=$row['department'];
		$joindate=$row['joindate'];
		$resigndate=$row['resigndate'];
		$salary=$row['salary'];
		$currency_symbol=$row['currency_symbol'];
		$workerstatus-$row['workerstatus'];
   	$data[]=array($i,$company_name,$worker_no,$joindate,$resigndate,$department,$position,
				$currency_symbol,$salary,$workerstatus);
		
	}
/*
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

   	$data[]=array($i,$company_name,$worker_no,$joindate,$resigndate,$department,$position,$currency_symbol,$salary,$workerstatus);$data[]=array($i,$row['student_code'],$row['student_name'],$row['school_name'],$row['hp_no'],$row['amt'],$row['paidamt'],
			$row['balance'],$transport,$row['lastdate']);
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
*/
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	$pdf->SetXY(10,40);
   	//$pdf->MultiCell(0,10,$sql,0,'C');
	$pdf->BasicTable($data);  

	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output("employmenthistory.pdf","I");
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


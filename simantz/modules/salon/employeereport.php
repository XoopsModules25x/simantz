<?php
require('fpdf/fpdf.php');
require('system.php');

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  public $employee_id="Unknown";
  public $employee_name="Unknown";
  public $tel1="Unknown";
  public $email="Unknown";
  public $fax="Unknown";
  public $isactive="Unknown";
  public $address1="Unknown";
  public $address2="Unknown";
  public $postcode="Unknown";
  public $city="Unknown";
  public $state="Unknown";
  public $country="Unknown";
  public $rowtitle="Unknown";
  public $headertail="Unknown";
  public $r_isactive="Unknown";
  public $timestamp="Unknown"; 
  public $header="Unknown";

function Header()
{
//    $this->Image('./images/visionlogobk.jpg', 263 , 11 , 20 , '' , 'JPG' , '');
    $this->SetFont('Arial','B',20);
    $this->Cell(0,17,"Employee Summary Report",1,0,'L');
    $this->Ln(4);
    $this->SetFont('Arial','',10);
$this->Ln();
    $w=array(6,52,21,21,50,120,7); //8 data
	$i=0;
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
    $this->Cell(0,10,$timestamp.' - Page ' . $this->PageNo() . '/{nb}',0,0,'R');
}

function BasicTable($header,$data,$printheader)
{
//Column widths

    $w=array(6,52,21,21,50,120,7); //8 data
	$i=1;


$this->SetFont('Arial','',9);

   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {
	$this->SetFont('Arial','',8);
	while($this->GetStringWidth($col)>$w[$i])
	{$col=substr_replace($col,"",-1);}
	if($i==6)
	$this->Cell($w[$i],6,$col,1,0,'C');
	else
	$this->Cell($w[$i],6,$col,1,0,'L');

	$i=$i+1;}
        $this->Ln();
}
}
}

$tableprefix= XOOPS_DB_PREFIX . "_";
$tableemployee=$tableprefix . "simsalon_employee";
$tablearea=$tableprefix . "simsalon_area";

if (isset($_POST['submit'])){

$pdf=new PDF('L','mm','A4'); 
$pdf->AliasNbPages();

	$pdf->header=array('No','Employee Name','Tel','H/P','Email','Address','Y/N');
	$sql="SELECT c.employee_name, c.tel1, c.tel2, c.email, c.address1, c.address2, c.postcode, c.city, a.area_name, c.country, c.isactive FROM $tableemployee c inner join $tablearea a on c.state_id=a.area_id order by isactive desc, employee_name";
	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;
$data[]=array($i,$row['employee_name'],$row['tel1'],$row['tel2'],$row['email'],$row['address1'].",".$row['address2'].",".$row['postcode'].",".$row['city'].",".$row['area_name'].",".$row['country'],$row['isactive']);
}
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
//  $pdf->MultiCell(0,6,$sql,1,'L');
	$pdf->BasicTable($header,$data,1);  

	//display pdf
	
$pdf->Output();
	exit (1);
}
else {
	require(XOOPS_ROOT_PATH.'/header.php');
	echo "<td>Error, please contact software developer kfhoo@simit.com.my</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');
}

?>


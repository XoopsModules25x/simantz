<?php
require('fpdf/fpdf.php');
include_once "system.php";



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  
  public $wherestr="Unknown";
  public $orderstr="Unknown";
  

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
   $this->Image('./images/attlistlogo.jpg', 78 , 10 , 65 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Times','BU',14);
//-------------------------
	 $this->SetXY(89,30);
    $this->Cell(0,17,"Item List",0,0,'L');
	 $this->SetX(90);
    
    //$this->Cell(110,17,"$this->tuitionclass_code",1,0,'R');
	 //$this->SetXY(95,10);
//----------------
//    $this->Cell(105,17," ",1,0,'R');
    $this->SetFont('Times','',10);
//	 $this->SetXY(67,4);
    //$this->Cell(40,17,"List Of Customer",0,0,'R');
	
	// $this->SetXY(135,4);
    //$this->Cell(0,17,"Class Code",0,0,'L');
    
    //$this->Ln(10);
    $this->Ln(18);
	
	
	 $i=0;
	$header=array('No','Item No','Item Description','Item Category',"Active");
   $w=array(10,25,75,45,23); //6 data

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
    $this->SetY(-20);
    //Arial italic 8
    $this->SetFont('courier','I',8);
    //Page number
    //$this->Cell(0,5,"For Administration Use",LTR,0,'L');
	//$this->Ln();
    //$this->Cell(0,25,"",LBR,0,'L');
	$this->Ln();
    $this->Cell(0,10,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

function BasicTable($header,$data,$printheader)
{
//Column widths
    
    //$w=array(6,14,49,39,16,6,6,6,6,6,6,25); //12 data
    $w=array(10,25,75,45,23); //9 data
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
	if ($i==4 || $i==2 || $i==3)
		while($this->GetStringWidth($col)> $w[$i])
			$col=substr_replace($col,"",-1);	

        if ($i==2)
            $this->Cell($w[$i],6,$col,1,0,'L');
 	else
	     $this->Cell($w[$i],6,$col,1,0,'C');
	
            $i=$i+1;
            }
        $this->Ln();
    }

}
}

$tableprefix= XOOPS_DB_PREFIX . "_";
$tableitem=$tableprefix . "tblitem";
$tablecategory=$tableprefix . "tblcategory";

//if (isset($_POST['submit'])){
if ($_POST){
  /*
	if($_POST['wherestr']<>"\'"){	
	$wherestr=str_replace('\\', '',$_POST['wherestr']);
	$wherestr=str_replace('\'WHERE', 'WHERE',$wherestr);
	}
	*/
	
	$wherestr=str_replace("\'", "'",$_POST['wherestr']);
	$orderstr=str_replace("\'","'",$_POST["orderstr"]);
	//$orderstr=str_replace('\\','',$_POST["orderstr"]);
	
	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(15);
	$pdf->SetAutoPageBreak(true ,20);

		$sql = "SELECT a.category_desc,c.item_id,c.item_code,c.item_desc,c.category_id,c.item_amount,c.item_cost,c.created,c.createdby,c.updated, c.updatedby, c.isactive
				FROM $tableitem c, $tablecategory a 
				$wherestr $orderstr";
		

	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;
  	$isactive=$row['isactive'];
  	$item_type=$row['item_type'];
  	  	
	if($isactive==1)
		$isactive='Y';
	else
		$isactive='N'; 

	
	//	$data[]=array($i,$row['student_code'],$row['student_name'],$row['hp_no'].'/'.$row['tel_1'],$row['school_name'],$transport,'','','','','','');
	
	$data[]=array($i,$row['item_code'],$row['item_desc'],$row['category_desc'],$isactive);
   
  	}
   	
/*	while ($i<'35'){
	$i=$i+1;
   	$data[]=array($i,'','','','','');
   }
   
	if ($i>'35'){
	
	while ($i<'70'){
	$i=$i+1;
   	$data[]=array($i,'','','','','');
   }
   }
*/
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();

	$pdf->BasicTable($header,$data,1);
 
	//$pdf->MultiCell(175,7,$sql,1,'C');
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


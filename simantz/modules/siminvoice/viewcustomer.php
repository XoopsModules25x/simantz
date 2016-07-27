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
    $this->Cell(0,17,"Customer List",0,0,'L');
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
	$header=array('No','Customer No','Customer Name','Tel', 'Contact Person', 'Contact No',"Active");
   $w=array(10,22,55,25,40,25,13); //6 data

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
    $w=array(10,22,55,25,40,25,13); //9 data
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
$tablecustomer=$tableprefix . "tblcustomer";

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

/*
	$sqlgetheader="SELECT c.tuitionclass_id, c.tuitionclass_code, c.description, c.day, c.starttime, c.endtime, e.employee_id, e.employee_name, e.hp_no, d.period_name, p.amt from $tabletuitionclass c inner join $tableemployee e inner join $tableperiod d inner join $tableproductlist p where c.tuitionclass_id=$customer_terms and c.employee_id=e.employee_id and   c.period_id=d.period_id and c.product_id=p.product_id";

	$querygetheader=$xoopsDB->query($sqlgetheader);

	
	while($rowgetheader=$xoopsDB->fetchArray($querygetheader)){
		$pdf->tuitionclass_code=$rowgetheader["tuitionclass_code"];
		}
*/

/*
	$sql="SELECT s.student_id,s.student_code, s.student_name,s.hp_no, s.tel_1, sch.school_name, std.standard_name,x.amt, x.isactive, x.studentclass_id ".
		",x.comeactive, x.backactive from $tabletuitionclass c ".
		" inner join $tablestudentclass x inner join $tableperiod d ".
		" inner join $tablestudent s on s.student_id=x.student_id ".
		" inner join $tablestandard std on s.standard_id=std.standard_id ".
		" inner join $tableschool  sch on s.school_id=sch.school_id ".
		" where x.tuitionclass_id=$customer_terms and x.tuitionclass_id=c.tuitionclass_id and ".
		" c.period_id=d.period_id  order by s.student_name";
		*/
	
	$sql = "SELECT c.customer_no,c.customer_name,c.customer_contactperson,c.customer_tel1,c.customer_contactno,c.customer_desc,c.customer_accbank,c.customer_bank,c.terms_id,c.isactive
				from $tablecustomer c  
				$wherestr $orderstr ";	
		
		

	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;
  	$isactive=$row['isactive'];
	if($isactive==1)
		$isactive='Y';
	else
		$isactive='N'; 
	//	$data[]=array($i,$row['student_code'],$row['student_name'],$row['hp_no'].'/'.$row['tel_1'],$row['school_name'],$transport,'','','','','','');
	
	$data[]=array($i,$row['customer_no'],$row['customer_name'],$row['customer_tel1'],$row['customer_contactperson'],$row['customer_contactno'],$isactive);
   
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
 
	//$pdf->MultiCell(185,7,$sql,1,'C');
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


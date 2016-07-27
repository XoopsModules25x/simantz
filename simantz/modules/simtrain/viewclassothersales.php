<?php
include_once('fpdf/chinese-unicode.php');
include_once 'system.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends PDF_Unicode
{
 public $datefrom;
 public $dateto;
 public $cur_name;
 public $cur_symbol;

function Header()
{
    $this->Image('upload/images/attlistlogo.jpg', 12 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Arial','B',18);
   $this->SetXY(12,6);
    $this->Cell(188,21," ",1,0,'R');
    $this->SetXY(100,6);
    $this->Cell(0,17,"Registration & Other Sales Reports",0,0,'R');

    $this->SetFont('Arial','B',12);
    $this->SetXY(96,19);
    $this->Cell(26,8,"Date From",1,0,'L');
    $this->Cell(26,8,$this->datefrom,1,0,'C');
    $this->Cell(26,8,"Date To",1,0,'C');
    $this->Cell(26,8,$this->dateto,1,0,'C');
    $this->Ln(10);
$i=0;

//	$header=array('No','Student','Type','Code','Date', 'Fees(RM)','Trans.(RM)', 'Paid(RM)', 'Due (RM)','Paid Date','Paid To');
   // $w=array(6,40,9,14,16,17,18,17,17,17,17);

	$this->SetFont('Arial','B',9); 
       	$this->Cell(6,6,'No',1,0,'C');
       	$this->Cell(15,6,'Org.',1,0,'C');
       	$this->Cell(15,6,'User',1,0,'C');
       	$this->Cell(20,6,'Index No',1,0,'C');
       	$this->Cell(52,6,'Student',1,0,'C');
       	$this->Cell(11,6,'Type',1,0,'C');
       	$this->Cell(20,6,'Code',1,0,'C');
       	$this->Cell(17,6,'Date',1,0,'C');
       	$this->Cell(16,6,'Fees(RM)',1,0,'C');
       	$this->Cell(16,6,'Trans(RM)',1,0,'C');
 
       //	$this->Cell($w[$i],7,'',1,0,'C');
       //	$this->Cell($w[$i],7,'',1,0,'C');

/*foreach($header as $col)
      	{
	$this->SetFont('Arial','B',9); 
       	$this->Cell($w[$i],7,$col,1,0,'C');
	$i=$i+1;		
	}
*/	
    $this->Ln(6);
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());
    //Position at 1.5 cm from bottom
    $this->SetY(-11);
    //Arial italic 8
    $this->SetFont('courier','I',8);

    $this->Cell(0,5,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

function BasicTable($data)
{
    $w=array(6,15,15,20,52,11,20,17,16,16);
	$i=0;


$this->SetFont('Times','',9);
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {

        //chop long string to fit in col uname, student name
	
	  
	
        if ($i==4){
              //-------------------------
	
	$break=explode('|||',$col);
	$englishname=$break[count($break)-1];
	$alternatename=$break[0];
	$cellwidth=$w[$i];
	$uGBnamewidth=13;

	$this->SetFont('uGB','',7);
	$this->isUnicode=true;
	while($this->GetStringWidth($alternatename)>$uGBnamewidth && $cellwidth >15)
		$alternatename=substr_replace($alternatename,"",-1);

	$balancewidth=$w[$i]-$uGBnamewidth;
	
	if($alternatename=="Total :")
	        $this->Cell($uGBnamewidth,5,'',1,0,'C');
	else
        $this->Cell($uGBnamewidth,5,$alternatename,1,0,'C');
 	$this->isUnicode=false;
	$this->SetFont('Times','',8);

//	while($this->GetStringWidth($englishname)> $balancewidth-1)
//			$englishname=substr_replace($englishname,"",-1);

        $this->Cell($balancewidth,5,$englishname,1,0,'L');
   //$this->Cell($w[$i],5,$col,1,0,'R');
	}
 	else{


	while($this->GetStringWidth($col)>$w[$i])
		$col=substr_replace($col,"",-1);
	$alignment="C";
	if($i>=8)
	$alignment="R";
	    $this->Cell($w[$i],5,$col,1,0,$alignment);

	}
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
$tablepaymentline=$tableprefix."simtrain_paymentline";
$tablepayment=$tableprefix."simtrain_payment";
$tableinventorymove=$tableprefix . "simtrain_inventorymovement";
$tableusers=$tableprefix."users";
$tableorganization=$tableprefix . "simtrain_organization";
if (isset($_POST['submit'])){



	$pdf=new PDF('P','mm','A4');
	$pdf->SetLeftMargin(12);
	$pdf->SetAutoPageBreak(true ,12);

	$pdf->AliasNbPages();
	$pdf->datefrom=$_POST["datefrom"];
	$pdf->dateto=$_POST["dateto"];
	$pdf->cur_name=$cur_name;
	$pdf->cur_symbol=$cur_symbol;
	$wherestring=$_POST['wherestring'];
	$wherestring=str_replace("\'", "'", $wherestring);
	$sql=" SELECT s.student_id,s.student_code,s.alternate_name, s.student_name, sc.tuitionclass_id,sc.movement_id,
		 (CASE WHEN tc.tuitionclass_id >0 
				THEN tc.tuitionclass_code ELSE pd.product_no END ) as code, sc.transactiondate,  
		   (CASE WHEN tc.tuitionclass_id >0 THEN tc.description
				ELSE concat(pd.product_name,'x',i.quantity) END ) as name, sc.amt,sc.transportfees, 
		   (CASE WHEN tc.tuitionclass_id >0 THEN o1.organization_code
				ELSE o2.organization_code END) as organization_code ,u.uname 
		 FROM $tablestudentclass sc 
		 inner join $tablestudent s on s.student_id=sc.student_id 
		 left join $tabletuitionclass tc on sc.tuitionclass_id = tc.tuitionclass_id 
		 left join $tableinventorymove i on sc.movement_id = i.movement_id 
		 left join $tableproductlist pd on i.product_id=pd.product_id 
		 left join $tableorganization o1 on o1.organization_id=tc.organization_id 
		 left join $tableorganization o2 on o2.organization_id=i.organization_id 
		 left join $tableusers u on sc.createdby=u.uid
		 $wherestring and sc.studentclass_id > 0
		 order by sc.transactiondate desc, s.student_name  , sc.created";

	


	$query=$xoopsDB->query($sql);
	$total=0;
	$rowtype="";
	$data=array();
	$i=0;
	$totalfees=0;
	$totaltransport=0;
	$totalpaid=0;
	$totaldue=0;
	while($row=$xoopsDB->fetchArray($query)) {
		$i++;
		$student_name=$row['student_name'];
		$code=$row['code'];
		$description=$row['description'];
		$transactiondate=$row['transactiondate'];
		$amt=$row['amt'];
		$alternate_name=$row['alternate_name'];
		$organization_code=$row['organization_code'];
		$transportfees=$row['transportfees'];
		$uname=$row['uname'];
		$student_code=$row['student_code'];
		$totalfees=$totalfees+$amt;
		$totaltransport=$totaltransport+$transportfees;

		$movement_id=$row['movement_id'];
	if($movement_id>0)
		$type='Item';
	else
		$type='Class';

		$data[]=array($i,$organization_code,$uname,$student_code,$alternate_name."|||".$student_name,$type,$code,$transactiondate,$amt,$transportfees);
		//$data[]=array($i,"","","","","","","","","","","","","");
		
	}

	//$querysum=$xoopsDB->query($sqlsummary);
	//$datasum=array();
	//if($rowsum=$xoopsDB->fetchArray($querysum))
		$data[]=array('','','','','Total :','','','',number_format($totalfees,2), number_format($totaltransport,2),);
	
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddUniGBhwFont("uGB");
	$pdf->isUnicode=false;
	$pdf->AddPage();
   	//$pdf->MultiCell(0,5,$wherestring,0,'C');
	$pdf->BasicTable($data);
	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output("DailyFeesCollection-".$pdf->datefrom."_".$pdf->dateto.".pdf","I");
	exit (1);

}
else {
	require(XOOPS_ROOT_PATH.'/header.php');
	echo "<td>Error during retrieving Invoice ID on viewinvoice.php(~line 206)," . 
		" please contact software developer kstan@simit.com.my</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');
}
?>


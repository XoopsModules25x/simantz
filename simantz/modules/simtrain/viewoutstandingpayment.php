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
    $this->Cell(0,17,"Outstanding Payment Report",0,0,'R');

    $this->SetFont('Arial','B',12);
    $this->SetXY(96,19);
    $this->Cell(26,8,"Date From",1,0,'L');
    $this->Cell(26,8,$this->datefrom,1,0,'C');
    $this->Cell(26,8,"Date To",1,0,'C');
    $this->Cell(26,8,$this->dateto,1,0,'C');
    $this->Ln(10);
$i=0;

//	$header=array('No','Student','Type','Code','Date', 'Fees(RM)','Trans.(RM)', 'Paid(RM)', 'Due (RM)','Paid Date','Paid To');
    $w=array(6,45,9,14,16,17,18,17,17,17,17);

	$this->SetFont('Arial','B',9); 
       	$this->Cell(6,8,'No',1,0,'C');
       	$this->Cell(45,8,'Student',1,0,'C');
       	$this->Cell(9,8,'Type',1,0,'C');
       	$this->Cell(19,8,'Code',1,0,'C');
       	$this->Cell(16,8,'Date',1,0,'C');
       	$this->Cell(60,4,"Amount in ($this->cur_symbol)",1,0,'C');
       	$this->Cell(17,8,'Paid Date',1,0,'C');
       	$this->Cell(17,8,'Paid To',1,0,'C');
$this->SetXY(107,33);
       	$this->Cell(15,4,'Fees',1,0,'C');
       	$this->Cell(15,4,'Trans',1,0,'C');
       	$this->Cell(15,4,'Paid',1,0,'C');
       	$this->Cell(15,4,'Due',1,0,'C');
       //	$this->Cell($w[$i],7,'',1,0,'C');
       //	$this->Cell($w[$i],7,'',1,0,'C');

/*foreach($header as $col)
      	{
	$this->SetFont('Arial','B',9); 
       	$this->Cell($w[$i],7,$col,1,0,'C');
	$i=$i+1;		
	}
*/	
    $this->Ln();
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
    $w=array(6,45,9,19,16,15,15,15,15,17,17);
	$i=0;


$this->SetFont('Times','',8);
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {

       if($i==1){
	$this->SetFont('uGB','',7);
	$break=explode('|||',$col);
	$englishname=$break[count($break)-1];
	$alternatename=$break[0];
	$cellwidth=$w[$i];
	$uGBnamewidth=13;


	while($this->GetStringWidth($alternatename)>$uGBnamewidth && $cellwidth >15)
		$alternatename=substr_replace($alternatename,"",-1);
	$balancewidth=$w[$i]-$uGBnamewidth;
	
	while($this->GetStringWidth($englishname)>$balancewidth -2)
		$englishname=substr_replace($englishname,"",-1);
	
	$this->isUnicode=true;
	if($alternatename=="Total :")
        $this->Cell($uGBnamewidth,6,'',1,0,'C');
	else
        $this->Cell($uGBnamewidth,6,$alternatename,1,0,'C');
 	$this->isUnicode=false;
	$this->SetFont('Times','',8); 
        $this->Cell($balancewidth,6,$englishname,1,0,'L');

	
	}
	else{
	  while($this->GetStringWidth($col)>$w[$i])
		$col=substr_replace($col,"",-1);  
	$align="L";

        if ($i>4)
	$align="R";

            $this->Cell($w[$i],6,$col,1,0,$align);
	
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
$tableusers=$tableprefix."users";
$tableschool=$tableprefix."simtrain_school";
if (isset($_POST['submit'])){



	$pdf=new PDF('P','mm','A4');
	$pdf->SetLeftMargin(12);
	$pdf->SetAutoPageBreak(true ,12);
	$pdf->AddUniGBhwFont("uGB");
	$pdf->isUnicode=false;
	$pdf->AliasNbPages();
	$pdf->datefrom=$_POST["datefrom"];
	$pdf->dateto=$_POST["dateto"];
	$pdf->cur_name=$cur_name;
	$pdf->cur_symbol=$cur_symbol;

	$wherestring=str_replace("\'", "'", $_POST['wherestring']);
	$orderbystring=str_replace("\'", "'", $_POST['orderbystring']);
$sql=" SELECT sc.studentclass_id, s.student_id,concat(s.alternate_name,'|||',s.student_name) as student_name, sc.tuitionclass_id,sc.movement_id, 
		(CASE WHEN tc.tuitionclass_id >0 
				THEN o1.organization_code ELSE o2.organization_code END ) as organization_code, 
		(CASE WHEN tc.tuitionclass_id >0 
				THEN ct1.category_code ELSE ct2.category_code END ) as category_code,
		(CASE WHEN tc.tuitionclass_id >0 
				THEN tc.tuitionclass_code ELSE pd.product_no END ) as code, 
		sc.transactiondate,
		  (CASE WHEN tc.tuitionclass_id >0 THEN tc.description
				ELSE concat(pd.product_name,'x',i.quantity) END ) as name, 
		  (CASE WHEN tc.tuitionclass_id >0 THEN tpd.product_name
				ELSE pd.product_name END ) as product_name, 	
		sc.amt,sc.transportfees,
		coalesce((select sum(pl.amt) from sim_simtrain_paymentline pl
		inner join sim_simtrain_payment p on p.payment_id=pl.payment_id where
		pl.studentclass_id=sc.studentclass_id and p.iscomplete='Y'),0) as paid,
		(select DATE(max(p.payment_datetime)) from sim_simtrain_paymentline pl
		inner join sim_simtrain_payment p on p.payment_id=pl.payment_id
		where pl.studentclass_id=sc.studentclass_id and p.iscomplete='Y') as paiddate,
		(select uname from sim_users where uid=(select max(p.createdby) from sim_simtrain_paymentline pl
		inner join sim_simtrain_payment p on p.payment_id=pl.payment_id 
		where pl.studentclass_id=sc.studentclass_id and p.iscomplete='Y')) as paidto,
		sc.amt+sc.transportfees-coalesce((select sum(pl.amt) from sim_simtrain_paymentline pl
		inner join sim_simtrain_payment p on p.payment_id=pl.payment_id
		where pl.studentclass_id=sc.studentclass_id and p.iscomplete='Y'),0) as due
		FROM sim_simtrain_studentclass sc
		inner join sim_simtrain_student s on s.student_id=sc.student_id
		left join sim_simtrain_tuitionclass tc on sc.tuitionclass_id = tc.tuitionclass_id
		left join sim_simtrain_inventorymovement i on sc.movement_id = i.movement_id
		left join sim_simtrain_productlist pd on i.product_id=pd.product_id
		inner join sim_simtrain_productlist tpd on tpd.product_id=tc.product_id
		inner join sim_simtrain_productcategory ct1 on ct1.category_id=tpd.category_id
		inner join sim_simtrain_productcategory ct2 on ct2.category_id=pd.category_id
		inner join sim_simtrain_organization o1 on tc.organization_id=o1.organization_id
		inner join sim_simtrain_organization o2 on i.organization_id=o2.organization_id 
		$wherestring $orderbystring ";

	/*$sqlsummary="SELECT sum(sc.trainingfees) as totalfees,sum(sc.transportfees) as totaltransport, ".
		" coalesce( ".
		" (select sum(p.amt)  ".
		" from sim_simtrain_paymentline pl  ".
		" inner join sim_simtrain_payment p on p.payment_id=pl.payment_id ".
		" inner join sim_simtrain_studentclass s on pl.studentclass_id=s.studentclass_id ".
		" where date(s.transactiondate) between '$pdf->datefrom' and '$pdf->dateto' and p.iscomplete='Y' ".
		" ),0) as totalpaid, ".
		" sum(sc.trainingfees) + sum(sc.transportfees) - ".
		" coalesce( ".
		" (select sum(p.amt)  ".
		" from sim_simtrain_paymentline pl  ".
		" inner join sim_simtrain_payment p on p.payment_id=pl.payment_id ".
		" inner join sim_simtrain_studentclass s on pl.studentclass_id=s.studentclass_id ".
		" where date(s.transactiondate) between '$pdf->datefrom' and '$pdf->dateto' and p.iscomplete='Y' ".
		" ),0)  ".
		" as totaldue from sim_simtrain_studentclass sc where date(sc.transactiondate) between '$pdf->datefrom' and '$pdf->dateto'"; */


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
		$transportfees=$row['transportfees'];
		$paid=$row['paid'];
		$paiddate=$row['paiddate'];
		$paidto=$row['paidto'];
		$due=$row['due'];
		$totalfees=$totalfees+$amt;
		$totaltransport=$totaltransport+$transportfees;
		$totalpaid=$totalpaid+$paid;
		$totaldue=$totaldue+$due;
		$movement_id=$row['movement_id'];
	if($movement_id>0)
		$type='Item';
	else
		$type='Class';

		$data[]=array($i,$student_name,$type,$code,$transactiondate,$amt,$transportfees,$paid,$due,$paiddate,$paidto);
		//$data[]=array($i,"","","","","","","","","","","","","");
		
	}

	//$querysum=$xoopsDB->query($sqlsummary);
	//$datasum=array();
	//if($rowsum=$xoopsDB->fetchArray($querysum))
		$data[]=array('','Total :','','','',number_format($totalfees,2), number_format($totaltransport,2),
				 number_format($totalpaid,2),number_format($totaldue,2),'','');
	
	//print header
	$pdf->SetFont('Arial','',10);
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


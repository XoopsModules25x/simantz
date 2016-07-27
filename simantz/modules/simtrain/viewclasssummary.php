<?php
include_once('fpdf/fpdf.php');
include_once 'system.php';


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  public $student_id="Unknown";
  public $student_code="Unknown";
  public $student_name="Unknown"; 
  public $school="Unknown"; 
  public $s_hp_no="Unknown"; 
  public $s_tel_1="Unknown"; 
  public $s_isactive="Unknown";
  public $organization_code="Unknown";
  public $tuitionclass_id="Unknown";
  public $period_id="Unknown";
  public $tuitionclass_code; 
  public $cur_name;
  public $cur_symbol;
  public $employee_id="Unknown"; 
  public $description="Unknown"; 
  public $day="Unknown";
  public $time="Unknown";  
  public $employee_name="Unknown"; 
  public $e_hp_no="Unknown";
  public $e_isactive="Unknown";
  public $studentclass_id="Unknown";
  public $r_isactive="Unknown";
  public $amt;

function Header()
{
    $this->Image('upload/images/attlistlogo.jpg', 12 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
$this->SetXY(12,10);
    $this->SetFont('Arial','B',18);
    $this->Cell(188,17,"Tuition Class Summary Report",1,0,'R');
    $this->Ln(20);
    $this->SetXY(105,22);

    $this->SetFont('Arial','',10);
    $this->Cell(15,5,"Month",1,0,'C');
    $this->SetFont('Arial','B',10);
    $this->Cell(20,5,$this->period_name,1,0,'C');
    $this->SetFont('Arial','',10);
    $this->Cell(25,5,"Organization",1,0,'C');
    $this->SetFont('Arial','B',10);
    $this->Cell(35,5,$this->organization_code,1,0,'C');
   
$this->Ln(7);

$i=0;
	$header=array('No','Code','Description', 'Head Count','Class Count','Day', 'Type','Hours',
		 'Tutor',"Total($this->cur_symbol)","Paid($this->cur_symbol)","Commisen($this->cur_symbol)");
    $w=array(7,16,44,10,10,8,9,9,24,15,15,21);
foreach($header as $col)
      	{
//	$ypos="";
	$this->SetFont('Times','B',8); 
	if($i==3){
	$ypos=$this->getY();
       	$this->MultiCell($w[$i],4,$col,1,'C');
	}
	elseif($i==4){
	$this->setXY(89,$ypos);
	//=$this->getY();

       	$this->MultiCell($w[$i],4,$col,1,'C');
	$this->setXY(99,$ypos);
	}
	else
       	$this->Cell($w[$i],8,$col,1,0,'C');

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

function BasicTable($header,$data,$printheader)
{
    $w=array(7,16,44,10,10,8,9,9,24,15,15,21);
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

$this->SetFont('Times','',8);
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {

	
		while($this->GetStringWidth($col)> $w[$i]-1)
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
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tableperiod=$tableprefix . "simtrain_period";
$tableemployee=$tableprefix."simtrain_employee";
$tablestudentclass=$tableprefix."simtrain_studentclass";
$tablepaymentline=$tableprefix."simtrain_paymentline";

if (isset($_POST["wherestr"])){
	$pdf=new PDF('P','mm','A4'); 
	$pdf->SetLeftMargin(12);
	$pdf->AliasNbPages();
	$wherestr=$_POST['wherestr'];

	$pdf->period_name=$_POST['period_name'];
	$pdf->organization_code=$_POST['organization_code'];
	$pdf->cur_name=$cur_name;
	$pdf->cur_symbol=$cur_symbol;
	/*$sql="SELECT t.tuitionclass_id,t.hours,t.product_id,t.period_id, t.employee_id, t.description, t.day, t.starttime,".
	 "t.attachmenturl, t.isactive, t.endtime, t.organization_id,t.createdby, t.created, t.updatedby, t.updated, ".
	 "t.clone_id, t.tuitionclass_code,p.product_name,e.employee_name,t.description,p.amt,pr.period_name ".
	",count(s.studentclass_id) as headcount,sum(s.amt) as totalfees,coalesce(sum(pl.trainingamt),0.00) as receivedamt ".
	" from $tabletuitionclass t ".
	 " inner join $tableperiod pr on pr.period_id=t.period_id ".
	 "  inner join $tableproductlist p on p.product_id=t.product_id ".
	 " inner join $tableemployee e on e.employee_id=t.employee_id ".
	" left join $tablestudentclass s on s.tuitionclass_id =t.tuitionclass_id ".
	" left join $tablepaymentline pl on s.studentclass_id =pl.studentclass_id ".
	" $wherestr ".
	" Group by t.tuitionclass_id,t.hours,t.product_id,t.period_id, t.employee_id, t.description, t.day, t.starttime,".
	 "t.attachmenturl, t.isactive, t.endtime, t.organization_id,t.createdby, t.created, t.updatedby, t.updated, ".
	 "t.clone_id, t.tuitionclass_code,p.product_name,e.employee_name,t.description,p.amt,pr.period_name ".
	" ORDER BY tuitionclass_code";*/
	$sql="SELECT t.tuitionclass_id,t.hours,t.product_id,t.period_id, o.organization_code, t.employee_id, t.description, (CASE WHEN t.classtype='W' THEN t.day ELSE '' END) as day, t.classtype,t.classcount,
	t.starttime,t.attachmenturl, t.isactive, t.endtime, t.organization_id,t.createdby, t.created, t.updatedby, 
	t.updated, t.clone_id, t.tuitionclass_code,p.product_name,e.employee_name,t.description,p.amt,
	pr.period_name ,
	(SELECT count(studentclass_id) FROM sim_simtrain_studentclass WHERE tuitionclass_id=t.tuitionclass_id ) as headcount,
	(SELECT sum(amt) FROM sim_simtrain_studentclass WHERE tuitionclass_id=t.tuitionclass_id) totalfees,
	(SELECT sum(pl.trainingamt) FROM sim_simtrain_studentclass sc 
		INNER JOIN sim_simtrain_paymentline pl on sc.studentclass_id=pl.studentclass_id
		INNER JOIN sim_simtrain_payment py on py.payment_id=pl.payment_id
		WHERE sc.tuitionclass_id=t.tuitionclass_id and py.iscomplete='Y') AS receivedamt
	from sim_simtrain_tuitionclass t 
	inner join sim_simtrain_period pr on pr.period_id=t.period_id 
	inner join sim_simtrain_productlist p on p.product_id=t.product_id 
	inner join sim_simtrain_employee e on e.employee_id=t.employee_id 
	inner join sim_simtrain_organization o on o.organization_id=t.organization_id 
	$wherestr and t.product_id>0 and t.tuitionclass_id >0
	Group by t.tuitionclass_id,t.hours,t.product_id,
			t.period_id, t.employee_id, t.description, t.day, t.starttime,t.attachmenturl, 
			t.isactive, t.endtime, t.organization_id,t.createdby, t.created, t.updatedby, t.updated, t.clone_id,
			t.tuitionclass_code,p.product_name,e.employee_name,t.description,p.amt,pr.period_name 
	ORDER BY tuitionclass_code";
	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	$totalheadcount=0;
	$totalallfees=0;
	$totalreceivedamt=0;
	$totalhours=0;

	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){

	$i=$i+1;

   	$data[]=array($i,$row['tuitionclass_code'],$row['description'],$row['headcount'],$row['classcount'],$row['day'],$row['classtype'],
				$row['hours'],$row['employee_name'],$row['totalfees'],$row['receivedamt'],'');
		$totalreceivedamt=$row['receivedamt']+$totalreceivedamt;
		$totalallfees=$row['totalfees']+$totalallfees;
		$totalhours=$row['hours']+$totalhours;
		$totalheadcount=$row['headcount']+$totalheadcount;
	}
	$data[]=array('','',"Total ($pdf->cur_symbol) :",$totalheadcount,'','',"",'','',number_format($totalallfees,2),number_format($totalreceivedamt,2),'');
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
   	//$pdf->MultiCell(0,5,$sql,0,'L');
	$pdf->BasicTable($header,$data,1);  

	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output();
	exit (1);

}
else {
	require(XOOPS_ROOT_PATH.'/header.php');
	echo "<td>Error during retrieving tuitionclass_id.php(~line 209)," . 
		" please contact software developer kstan@simit.com.my</td>";
	require(XOOPS_ROOT_PATH.'/footer.php');
}
?>


<?php
require('fpdf/fpdf.php');
include_once "system.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  
  public $wherestr="Unknown";
  public $orderstr="Unknown";
  public $dataType=0;
  public $employee_name="";
  public $ic_no="";
  public $epf_no="";
  public $stafftype_description="";
  public $basic_salary="";
  public $start_date="";
  public $end_date="";
  public $payroll_socsoemployee="";
  public $payroll_socsoemployer="";
  public $payroll_epfemployee="";
  public $payroll_epfemployer="";
  public $payroll_amt_comm="";
  public $payroll_amt_totalot="";
  public $total_income;
  public $total_decuction;
  public $payroll_totalamount;
  public $payroll_socsobase;
  public $payroll_epfbase;
  public $payroll_remarks2;

  public $net_pay;
  public $received_name;

function Header()
{
	
	
	$this->Image('./images/attlistlogo.jpg', 10 , 5 , 60 , '' , 'JPG' , '');
	/*
	$this->Ln();
	$this->SetFont('Arial','B',30);
	
	//-------------------------
	$this->SetXY(150,5);
	$this->Cell(50,17,"Payslip",0,0,'R');
	$this->SetX(90);
	
	$this->Ln(18);
			
	$i=0;


	*/
	
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());

	
	
	//Position at 1.5 cm from bottom
	$this->SetY(-22);
	//Arial italic 8
	$this->SetFont('courier','I',8);
	//Page number
//	$this->Ln();
//	$this->Cell(0,10,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');

}

function BasicTable($header,$allowancedata,$leavedata,$printheader)
{

	$this->Ln();
	$this->SetFont('Arial','B',30);

	//-------------------------
	$this->SetXY(150,5);
	$this->Cell(50,17,"Payslip",0,0,'R');
	$this->SetX(90);
	
	$this->Ln(18);
			
	$i=0;


	$this->SetDrawColor(0,0,0);
	
	//write header info
	$this->SetFont('Arial','B',9); 
	$this->Cell(27,4,"Employee Name",0,0,'L','B');
	$this->Cell(5,4,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(60,4,$this->employee_name,0,0,'L');
	
	$this->SetFont('Arial','B',9); 
	$this->Cell(27,4,"Position",0,0,'L','B');
	$this->Cell(5,4,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(60,4,$this->stafftype_description,0,1,'L');

	$this->SetFont('Arial','B',9); 
	$this->Cell(27,4,"I/C No",0,0,'L','B');
	$this->Cell(5,4,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(60,4,$this->ic_no,0,0,'L');

	$this->SetFont('Arial','B',9); 
	$this->Cell(27,4,"EPF No",0,0,'L','B');
	$this->Cell(5,4,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(60,4,$this->epf_no,0,1,'L');

	$this->SetFont('Arial','B',9); 
	$this->Cell(27,4,"Period From",0,0,'L','B');
	$this->Cell(5,4,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(60,4,$this->start_date,0,0,'L');

	$this->SetFont('Arial','B',9); 
	$this->Cell(27,4,"Period To",0,0,'L','B');
	$this->Cell(5,4,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(70,4,$this->end_date,0,0,'L');

	$this->Ln(); 	

	
	$this->SetXY(8,38);
	//write body info
	$this->SetFont('Arial','B',9); 
	$this->Cell(64,6,"INCOME ($this->cur_symbol)",1,0,'C','B');
	$this->Cell(64,6,"DEDUCTION ($this->cur_symbol)",1,0,'C','B');
	$this->Cell(64,6,"OTHERS",1,1,'C','B');
	
	//info
	$this->SetFont('Arial','',8); 
	$this->Cell(32,6,"Basic Pay",0,0,'L','');
	$this->Cell(32,6,$this->basic_salary,0,0,'R','');
	$this->Cell(32,6,"EPF For Employee",0,0,'L','');
	$this->Cell(32,6,$this->payroll_epfemployee,0,0,'R','');
	$this->Cell(32,6,"EPF For Employer",0,0,'L','');
	$this->Cell(32,6,$this->payroll_epfemployer,0,1,'R','');
	//allowance
	$this->Cell(32,6,"Over Time",0,0,'L','');
	$this->Cell(32,6,$this->payroll_amt_totalot,0,1,'R','');
	$this->Cell(32,6,"Commission",0,0,'L','');
	$this->Cell(32,6,$this->payroll_amt_comm,0,1,'R','');
	
	foreach($allowancedata as $row)
	{ $i=0;
		foreach($row as $col) {
			/*
			while($this->GetStringWidth($col)> $w[$i]-1)
				$col=substr_replace($col,"",-1);	*/
		if($i==0)
		$this->Cell(32,6,$col,0,0,'L','');
		else
		$this->Cell(32,6,$col,0,1,'R','');
		
		$i=$i+1;
		}	
		
	}
	
	/*
	$this->SetXY(72,59);
	$this->Cell(32,6,"SOCSO For Employee",0,0,'L','');
	$this->Cell(32,6,$this->payroll_socsoemployee,0,0,'R','');
	$this->Cell(32,6,"SOCSO For Employer",0,0,'L','');
	$this->Cell(32,6,$this->payroll_socsoemployer,0,1,'R','');
	*/
	//deduction
	$this->SetXY(72,50);
	$this->Cell(32,6,"SOCSO For Employee",0,0,'L','');
	$this->Cell(32,6,$this->payroll_socsoemployee,0,0,'R','');
	$this->Cell(32,6,"SOCSO For Employer",0,0,'L','');
	$this->Cell(32,6,$this->payroll_socsoemployer,0,1,'R','');
	
	$this->SetXY(136,56);
	$this->Cell(32,6,"SOCSO (BASE)",0,0,'L','');
	$this->Cell(32,6,$this->payroll_socsobase,0,0,'R','');
	$this->SetXY(136,62);
	$this->Cell(32,6,"EPF (BASE)",0,0,'L','');
	$this->Cell(32,6,$this->payroll_epfbase,0,1,'R','');
	
	$this->SetXY(72,56);
	//leave
	foreach($leavedata as $row)
	{ $i=0;
		foreach($row as $col) {
			/*
			while($this->GetStringWidth($col)> $w[$i]-1)
				$col=substr_replace($col,"",-1);	*/
		if($i==0){
		$this->SetX(72);
		$this->Cell(32,6,$col,0,0,'L','');
		}else{
		$this->Cell(32,6,$col,0,1,'R','');
		}
		
		$i=$i+1;
		}	
		
	}

	
	
	
	

	//---------fix table
	$this->SetXY(8,44);
	$this->Cell(64,50,"",1,0,'C','B');
	$this->Cell(64,50,"",1,0,'C','B');
	$this->Cell(64,50,"",1,1,'C','B');

	//bottom info
	$this->Cell(32,6,"TOTAL",0,0,'L','');
	$this->Cell(32,6,$this->total_income,0,0,'R','');
	$this->Cell(32,6,"TOTAL",0,0,'L','');
	$this->Cell(32,6,$this->total_decuction,0,0,'R','');
	$this->Cell(32,6,"NET PAY",0,0,'L','');
	$this->Cell(32,6,$this->net_pay,0,1,'R','');
	
	/*
	$this->Cell(128,6,"EMPLOYER CONTRIBUTIONS",1,0,'C','');
	$this->Cell(64,6,"",0,1,'L','');
	$this->Cell(32,6,"EPF :",0,0,'L','');
	$this->Cell(32,6,$this->payroll_epfemployer,0,0,'R','');
	$this->Cell(32,6,"SOCSO :",0,0,'L','');
	$this->Cell(32,6,$this->payroll_socsoemployer,0,0,'R','');
	*/
	$this->Cell(128,6,"",1,0,'C','');
//	$this->Cell(64,6,"",0,0,'L','');

	$this->Cell(32,6,"TOTAL PAY",0,0,'L','B');
	$this->Cell(32,6,$this->payroll_totalamount,0,1,'R','');
	

	//-------another fix table
	$this->SetXY(8,94);
	$this->Cell(64,6,"",1,0,'C','B');
	$this->Cell(64,6,"",1,0,'C','B');
	$this->Cell(64,6,"",1,1,'C','B');
	$this->Cell(128,6,"",1,0,'C','B');
	$this->Cell(64,6,"",0,1,'C','B');
	//$this->Cell(64,6,"",1,0,'C','B');
//	$this->Cell(64,6,"",1,1,'C','B');
	$this->SetXY(136,100);
	$this->Cell(64,6,"",1,1,'C','B');
	$this->SetFont('Arial','',7);
	$this->Cell(192,6,$this->payroll_remarks2,1,1,'L','');
//	$this->Ln();
	
	$this->SetY(115);
	$this->SetFont('Arial','',8);
	
	$this->Cell(64,6,"Received By",0,0,'L','B');
	$this->SetX(136);
	$this->Cell(64,6,"Confirmed By",0,1,'L','B');
	$this->SetY(128);
	$this->Cell(64,0,"",1,0,'L','B');
	$this->SetX(136);
	$this->Cell(64,0,"",1,0,'L','B');
	$this->SetY(128);
	$this->Cell(64,4,$this->employee_name,0,0,'L','B');
	$this->SetX(136);
	$this->Cell(64,4,$this->received_name,0,0,'L','B');
    	//Header
    
	/*
	$this->SetFont('Arial','',9);

	foreach($data as $row)
	{ $i=0;
		foreach($row as $col) {
		
			while($this->GetStringWidth($col)> $w[$i]-1)
				$col=substr_replace($col,"",-1);	
		
		if ($i==1)
		$this->Cell($w[$i],5,$col,0,0,'L');
		else
		$this->Cell($w[$i],5,$col,0,0,'C');
		
		$i=$i+1;
		}	
		$this->Ln();
		
	}
	$this->height_tbl = $this->y -55;
	*/
	
}

	function getNameUser($id){
	$val = "";
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$tableusers=$tableprefix . "users";
	
	$sql = "select * from $tableusers where uid = $id ";

	$query=$this->xoopsDB2->query($sql);
	
	if($row=$this->xoopsDB2->fetchArray($query)){
	$val = $row['uname'];

	}

	return $val;
	
	
	}
	function getTypeOfGroup($txt,$type){
	$val = $txt;
	$tableprefix= XOOPS_DB_PREFIX . "_";
	

	$tablegroups_users_link=$tableprefix . "groups_users_link";
	$tablegroups=$tableprefix . "groups";

	$sql = "SELECT b.accesstype FROM $tablegroups_users_link a,$tablegroups b
		WHERE a.groupid = b.groupid
		AND a.uid = $this->uid";
	
	$query=$this->xoopsDB2->query($sql);
	
	while($row=$this->xoopsDB2->fetchArray($query)){
	if($row['accesstype']!=$type)//if not department
	$val = "";
	}

	return $val;
	}


}

$tableprefix= XOOPS_DB_PREFIX . "_";
$tablepayroll=$tableprefix . "simsalon_payroll";
$tableemployee=$tableprefix . "simsalon_employee";
$tablestafftype=$tableprefix . "simsalon_stafftype";
$tableallowancepayroll=$tableprefix . "simsalon_allowancepayroll";
$tableallowanceline=$tableprefix . "simsalon_allowanceline";
$tableleave=$tableprefix . "simsalon_leave";
$tableleaveline=$tableprefix . "simsalon_leaveline";


if (true){

	//$payroll_id = $_GET['payroll_id'];

	if (isset($_POST['payroll_id'])){
	$payroll_id=$_POST['payroll_id'];
	
	}
	elseif(isset($_GET['payroll_id'])){
	$payroll_id=$_GET['payroll_id'];
	}else{
	$payroll_id = "";
	}
	
	$pdf=new PDF('L','mm','A5'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(8);
	$pdf->SetAutoPageBreak(true ,15);

	
	$pdf->uid = $xoopsUser->getVar('uid');
	$pdf->xoopsDB2 = $xoopsDB;
	
	$pdf->received_name = $pdf->getNameUser($pdf->uid);

	//list allowance
	$sqlallowance = "select * from $tableallowancepayroll a 
			where a.payroll_id = $payroll_id ";

	$query=$xoopsDB->query($sqlallowance);
	$i=0;
	$total_allowance=0;
	$allowancedata=array();

	while($row=$xoopsDB->fetchArray($query)){
	$i++;
	
	$allowance_name = $row['allowancepayroll_name'];
	$allowance_amount = $row['allowancepayroll_amount'];
	
	if($allowance_amount > 0)
	$allowancedata[]=array($allowance_name,$allowance_amount);
	
	$total_allowance += $allowance_amount;
	}


	//list leave
	$sqlleave= "select * from $tableleaveline a 
			where a.payroll_id = $payroll_id and a.leaveline_amount > 0";

	$query=$xoopsDB->query($sqlleave);
	$i=0;
	$total_leave=0;
	$leavedata=array();

	while($row=$xoopsDB->fetchArray($query)){
	$i++;
	
	$leave_name = $row['leaveline_name'];
	$leave_amount = $row['leaveline_amount'];

	
	$leavedata[]=array($leave_name,$leave_amount);
	
	$total_leave += $leave_amount;
	}

	

	$sql = "select * from $tablepayroll a, $tableemployee b, $tablestafftype c
		where a.employee_id = b.employee_id and b.stafftype_id = c.stafftype_id
		and a.payroll_id = $payroll_id ";


	$query=$xoopsDB->query($sql);
	$i=0;
	//get data detail
	if($row=$xoopsDB->fetchArray($query)){
	$i++;
	
	$pdf->employee_name = $row['employee_name'];
	$pdf->ic_no = $row['ic_no'];
	$pdf->epf_no = $row['epf_no'];
	$pdf->stafftype_description = $row['stafftype_description'];
	$pdf->payroll_yearof = $row['payroll_yearof'];
	$pdf->payroll_monthof = $row['payroll_monthof'];
	$pdf->payroll_socsoemployee = $row['payroll_socsoemployee'];
	$pdf->payroll_socsoemployer = $row['payroll_socsoemployer'];
	$pdf->payroll_epfemployee = $row['payroll_epfemployee'];
	$pdf->payroll_epfemployer = $row['payroll_epfemployer'];
	$pdf->payroll_amt_ul = $row['payroll_amt_ul'];
	$pdf->payroll_amt_sl = $row['payroll_amt_sl'];
	$pdf->payroll_amt_al = $row['payroll_amt_al'];
	$pdf->payroll_amt_el = $row['payroll_amt_el'];
	$pdf->payroll_amt_comm = $row['payroll_amt_comm'];
	$pdf->payroll_totalamount = $row['payroll_totalamount'];
	$pdf->payroll_amt_allowance1 = $row['payroll_amt_allowance1'];
	$pdf->payroll_amt_allowance2 = $row['payroll_amt_allowance2'];
	$pdf->payroll_amt_allowance3 = $row['payroll_amt_allowance3'];
	$pdf->allowance_name1 = $row['allowance_name1'];
	$pdf->allowance_name2 = $row['allowance_name2'];
	$pdf->allowance_name3 = $row['allowance_name3'];
	
	$pdf->payroll_socsobase = $row['payroll_socsobase'];
	$pdf->payroll_epfbase = $row['payroll_epfbase'];
	$pdf->payroll_remarks2 = $row['payroll_remarks2'];
	
	$pdf->payroll_amt_totalot = number_format(($row['payroll_amt_ot1'] + $row['payroll_amt_ot2'] + $row['payroll_amt_ot3'] +$row['payroll_amt_ot4']), 2, '.','');
	//$pdf->payroll_amt_totalot = number_format($pdf->payroll_amt_totalot, 2, '.','');
	$pdf->basic_salary = $row['payroll_basicsalary'];

	$pdf->total_income = number_format(($pdf->basic_salary + $pdf->payroll_amt_comm + $pdf->payroll_amt_totalot + $total_allowance), 2, '.','');

	$pdf->total_decuction = number_format(($pdf->payroll_socsoemployee + $pdf->payroll_epfemployee + $total_leave), 2, '.','');

	$pdf->net_pay = number_format(($pdf->total_income - $pdf->total_decuction), 2, '.','');

	$YMD = $pdf->payroll_yearof.$pdf->payroll_monthof."01";

	$pdf->start_date = getMonth($YMD,0) ;
	$pdf->end_date = getMonth($YMD,1);




   	}
  	
	
   	$pdf->cur_symbol = $cur_symbol;

	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();

	$pdf->BasicTable($header,$allowancedata,$leavedata,1);
 
//	$pdf->MultiCell(175,7,$sqlleave,1,'C');
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


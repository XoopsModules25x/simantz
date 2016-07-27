<?php
require('fpdf/fpdf.php');
include_once "system.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  
  public $wherestr="Unknown";
  public $orderstr="Unknown";
  public $filter_type="";
  public $start_date="";
  public $end_date="";
  public $employee_id="";
  public $employee_name="";
  public $org_info="";

function Header()
{


	$timestamp= date("Y-m-d", time());
	$date = date("Y-m-d", time());
	$time = date("H:i:s", time());
	
	$this->SetFont('Times','',6);
	$this->SetXY(195,5);
	$this->Multicell(45,4,"$this->org_info",0,'L');


	$this->SetXY(80,5);
	$this->Image('./images/attlistlogo.jpg', 230 , 5 , 50 , '' , 'JPG' , '');
	$this->Ln(12);
	$this->SetFont('Arial','B',13);

	//-------------------------
	
	$this->Cell(0,4,"Performance Summary Report",0,1,'L');
	$this->SetFont('Arial','',6);
	$this->Cell(0,4,"Date : $date Time : $time  Page ".$this->PageNo()." / {nb} ",0,1,'R');
	//$this->Ln();
	$this->Cell(280,0,"",1,1,'L');
	$this->SetX(90);
	
	$this->Ln(4);
	
	/*
	$timestamp= date("Y-m-d", time());
	$this->Image('./images/attlistlogo.jpg', 230 , 5 , 50 , '' , 'JPG' , '');
	$this->Ln();
	$this->SetFont('Times','BU',14);

	//-------------------------
	$this->SetXY(7,10);
	$this->Cell(195,10,"Performance Summary Report",0,1,'L');
	*/
	
	if($this->filter_type=="M"){
	$this->SetFont('Arial','B',8); 
	$this->Cell(20,6,"Date",0,0,'L');
	$this->SetFont('Arial','',8); 
	$this->Cell(20,6,": ".$this->start_date." - ".$this->end_date,0,1,'L');
	}else if($this->filter_type=="S"){
	$this->SetFont('Arial','B',8); 
	$this->Cell(20,6,"Stylist",0,0,'L');
	$this->SetFont('Arial','',8); 
	$this->Cell(20,6,': '.$this->employee_name,0,1,'L');
	}else{
	$this->SetFont('Arial','B',8); 
	$this->Cell(20,6,"Date",0,0,'L');
	$this->SetFont('Arial','',8); 
	$this->Cell(20,6,": ".$this->start_date." - ".$this->end_date,0,1,'L');
	
	if($this->employee_id > 0){
	$this->SetFont('Arial','B',8); 
	$this->Cell(20,6,"Stylist",0,0,'L');
	$this->SetFont('Arial','',8); 
	$this->Cell(20,6,': '.$this->employee_name,0,1,'L');	
	}
	}
	$this->Ln();
		
	$i=0;
	
	
	$header =array("No","Stylist","Month/Year","Product ($this->cur_symbol)","Service ($this->cur_symbol)","Others ($this->cur_symbol)","Total ($this->cur_symbol)","Salary ($this->cur_symbol)");

	$w=array(10,50,20,43,43,43,46,25); // total width = 285

	$this->SetDrawColor(0,0,0);
	$i = 0;
	foreach($header as $col){
	
	$this->SetFont('Arial','B',9); 

	$this->Cell($w[$i],6,$col,1,0,'C');
	$i=$i+1;		
	}
	$this->Ln();

	$header =array("","","","Sales","Commission","Sales","Commission","Sales","Commission","Sales","Commission","");

	$w=array(10,50,20,22,21,22,21,22,21,23,23,25); // total width = 285

	$this->SetDrawColor(0,0,0);
	$i = 0;
	foreach($header as $col){
	
	$this->SetFont('Arial','B',9); 

	$this->Cell($w[$i],6,$col,1,0,'C');
	$i=$i+1;		
	} 	
	$this->Ln();
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());

	
	
	//Position at 1.5 cm from bottom
	$this->SetY(-24);
	//Arial italic 8
	$this->SetFont('courier','I',8);
	//Page number
	$this->Ln();
	$this->Cell(0,10,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');

	/*
	//----------------fix table
	$this->SetXY(8,10);
	$this->SetDrawColor(0,0,0);
	if($this->height_tbl =="")
	$this->height_tbl = 138;
	else
	$this->height_tbl = $this->height_tbl;
	$this->Cell(190,$this->height_tbl,"",1,0,'C');*/
}

function BasicTable($header,$data,$printheader)
{

	//$this->SetDrawColor(210,210,210);
	//Column widths
	$i=0;
	$w=array(10,50,20,22,21,22,21,22,21,23,23,25); // total width = 285
	//$w=array(10,50,30,35,35); // total width = 285
	
    	//Header
    
	$this->SetFont('Arial','',7);

	foreach($data as $row){ 
		$i=0;
		foreach($row as $col) {
			while($this->GetStringWidth($col)> $w[$i]-1)
				$col=substr_replace($col,"",-1);	
	
		
		$this->Cell($w[$i],6,$col,1,0,'C');
		
		$i=$i+1;
		}	
		$this->Ln();
		
	}
	$this->height_tbl = $this->y -55;
	
}

	function getTypeOfGroup($txt,$type){
	$val = $txt;
	$tableprefix= XOOPS_DB_PREFIX . "_";
	

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

	function calculateCommissionType($total,$type){
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$tablecommission=$tableprefix . "simsalon_commission";

	$totalamount = 0;
	// get commission percent
	$sql = "select (commission_percent/100*$total) as total from $tablecommission a 
	where ($total between a.commission_amount and a.commission_amountmax) 
	and a.commission_type = '$type' ";//compare with commission table
	
	$query=$this->xoopsDB2->query($sql);
	if($row=$this->xoopsDB2->fetchArray($query)){
	$totalamount = $row['total'];
	
	if($totalamount=="")
	$totalamount = 0;
	
	}
	
	$totalamount = number_format($totalamount, 2, '.','');
			
	return	$totalamount;
	}


}

$tableprefix= XOOPS_DB_PREFIX . "_";
$tableemployee=$tableprefix . "simsalon_employee";
$tablepayroll=$tableprefix . "simsalon_payroll";
$tablevinvoice=$tableprefix . "simsalon_vinvoice";
$tablevinvoiceline=$tableprefix . "simsalon_vinvoiceline";
$tablesales=$tableprefix . "simsalon_sales";
$tablesalesline=$tableprefix . "simsalon_salesline";
$tablesalesemployeeline=$tableprefix . "simsalon_salesemployeeline";
$tableinternal=$tableprefix . "simsalon_internal";
$tableinternalline=$tableprefix . "simsalon_internalline";
$tableproductlist=$tableprefix . "simsalon_productlist";
$tableproductcategory=$tableprefix . "simsalon_productcategory";


if ($_POST){
	
	$filter = $_POST['filter'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$employee_id = $_POST['employee_id'];

	$start_date = $_POST['start_date'];
	$yearofstart = substr($start_date,0,4);
	$yearofend = substr($end_date,0,4);
	$monthofstart = substr($start_date,5,2);
	$monthofend = substr($end_date,5,2);
	
	$pdf=new PDF('L','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(8);
	$pdf->SetAutoPageBreak(true ,15);

	$pdf->filter_type = $filter;
	$pdf->start_date = $start_date;
	$pdf->end_date = $end_date;
	$pdf->employee_id = $employee_id;
	$pdf->cur_symbol = $cur_symbol;
	
	$pdf->uid = $xoopsUser->getVar('uid');
	$pdf->xoopsDB2 = $xoopsDB;
	$pdf->org_info = getOrganizationInfo($xoopsDB,$tableprefix);

	if($pdf->filter_type=="M"){
	$sql = "select * from $tablepayroll a, $tableemployee b 
		where ( (a.payroll_yearof between $yearofstart and $yearofend) and (a.payroll_monthof between $monthofstart and $monthofend) )
		and a.employee_id = b.employee_id 
		and a.iscomplete = 'Y' order by a.employee_id ";
	}else if($pdf->filter_type=="S"){
	$sql = "select * from $tablepayroll a, $tableemployee b 
		where a.employee_id = $employee_id 
		and a.employee_id = b.employee_id 
		and a.iscomplete = 'Y' order by a.payroll_yearof,a.payroll_monthof ";
	}else{
		if($employee_id > 0)
		$employeewhere = " and a.employee_id = $employee_id ";
		else
		$employeewhere = "";
		

	$sql = "select * from $tablepayroll a, $tableemployee b 
		where ( (a.payroll_yearof between $yearofstart and $yearofend) and (a.payroll_monthof between $monthofstart and $monthofend) )  
		and a.employee_id = b.employee_id 
		and a.iscomplete = 'Y' and a.isactive = 'Y' 
		and b.isactive = 'Y' 
		$employeewhere 
		order by a.payroll_yearof,a.payroll_monthof ";
	}

	

	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	//get data detail

	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;
	$total_servicesales = "0.00";
	$total_productsales = "0.00";
	$total_otherssales = "0.00";

	$total_servicecomm = "0.00";
	$total_productcomm = "0.00";
	$total_otherscomm = "0.00";

	//get sales n commmission
	$employee_id = $row['employee_id'];

	$YMD = $row['payroll_yearof'].$row['payroll_monthof']."01";

	$totalamount = 0;
	$totalamountfinal = 0;
	
	$start_date = getMonth($YMD,0) ;
	$end_date = getMonth($YMD,1) ;
	
	//Y = others, N = product, C = service
  	$retval = "0.00";
	$sql = "select sum(percent/100*salesline_amount) as totsales,e.isitem  
		from $tablesales a, $tablesalesline b, $tablesalesemployeeline c, 
		$tableproductlist d, $tableproductcategory e
		where a.sales_id = b.sales_id and b.salesline_id = c.salesline_id and a.iscomplete = 'Y' and a.isactive = 'Y' 
		and b.product_id = d.product_id and d.category_id = e.category_id  
		and a.sales_date between '$start_date' and '$end_date' 
		and c.employee_id = $employee_id
		group by e.category_id ";//sum total amount
	$query2=$xoopsDB->query($sql);

	while ($row2=$xoopsDB->fetchArray($query2)){

	if($row2['isitem'] == "C")
	$total_servicesales = $row2['totsales'];
	else if($row2['isitem'] == "N")
	$total_productsales = $row2['totsales'];
	else if($row2['isitem'] == "Y")
	$total_otherssales = $row2['totsales'];

	}

	$total_sales = $total_otherssales + $total_servicesales + $total_productsales;

	$totcommission_service = $pdf->calculateCommissionType($total_servicesales,"S");	
	$totcommission_product = $pdf->calculateCommissionType($total_productsales,"P");	
	$totcommission_others = $pdf->calculateCommissionType($total_otherssales,"O");

	$total_commission = $totcommission_service + $totcommission_product + $totcommission_others;

	$total_productsales = number_format($total_productsales, 2, '.','');
	$total_servicesales = number_format($total_servicesales, 2, '.','');
	$total_otherssales = number_format($total_otherssales, 2, '.','');
	$total_sales = number_format($total_sales, 2, '.','');
	$total_commission = number_format($total_commission, 2, '.','');

	$data[]=array($i,
			$row['employee_name'],
			$row['payroll_monthof']."/".$row['payroll_yearof'],
			$total_productsales,
			$totcommission_product,
			$total_servicesales,
			$totcommission_service,
			$total_otherssales,
			$totcommission_others,
			$total_sales,
			$total_commission,
			$row['payroll_totalamount']);
	
	$pdf->employee_name = $row['employee_name'];
   	}
  	
	//$asd = $pdf->getCommission($employee_id);
   	

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

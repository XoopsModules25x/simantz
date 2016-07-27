<?php
require('fpdf/fpdf.php');
include_once "system.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  
  public $wherestr="Unknown";
  public $orderstr="Unknown";
  public $start_date = "";
  public $end_date = "";
  public $org_info = "";

function Header()
{

	$timestamp= date("Y-m-d", time());
	$date = date("Y-m-d", time());
	$time = date("H:i:s", time());

	$this->SetFont('Times','',6);
	$this->SetXY(105,5);
	$this->Multicell(45,4,"$this->org_info",0,'L');

	$this->SetXY(80,5);
	$this->Image('./images/attlistlogo.jpg', 140 , 5 , 60 , '' , 'JPG' , '');
	$this->Ln(12);
	$this->SetFont('Arial','B',13);

	//-------------------------
	
	$this->Cell(0,4,"Profit & Loss Statement",0,1,'L');
	$this->SetFont('Arial','',6);
	$this->Cell(0,4,"Date : $date Time : $time  Page ".$this->PageNo()." / {nb} ",0,1,'R');
	//$this->Ln();
	$this->Cell(190,0,"",1,1,'L');
	$this->SetX(90);
	
	$this->Ln(4);
			
	$i=0;


	//$header =array("No","Code","Status","Remarks");
	//$w=array(10,75,100,100); // total width = 285


	$this->SetDrawColor(0,0,0);
	
	$this->SetFont('Arial','B',9); 

	$this->Cell(25,7,"Statement Period",0,0,'L');
	$this->Cell(5,7,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(50,7, $this->start_date." to ".$this->end_date,0,1,'L');
	$this->SetFont('Arial','B',9); 
	/*
	$this->Cell(25,7,"Date",0,0,'L');
	$this->Cell(5,7,":",0,0,'R');
	$this->SetFont('Arial','',9);
	$this->Cell(50,7,$timestamp,0,1,'L');
	*/
	$this->Ln(); 	
	//$this->Cell(190,210,"",1,0,'L');//fix table
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());

	
	
	//Position at 1.5 cm from bottom
	$this->SetY(-25);
	//Arial italic 8
	$this->SetFont('courier','I',8);
	//Page number
	$this->Ln();
	$this->Cell(0,10,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');

/*
	//----------------fix table
	$this->SetXY(8,55);
	$this->SetDrawColor(0,0,0);
	if($this->height_tbl =="")
	$this->height_tbl = 132;
	else
	$this->height_tbl = $this->height_tbl;
	$this->Cell(285,$this->height_tbl,"",1,0,'C');*/
}

function BasicTable($header,$data,$printheader)
{

	$this->SetDrawColor(210,210,210);
	//Column widths
	$i=0;
	
	$w=array(); // total width = 285
	
	
    	
	
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
$tablesales=$tableprefix . "simsalon_sales";
$tablesalesline=$tableprefix . "simsalon_salesline";
$tableproductlist=$tableprefix . "simsalon_productlist";
$tableproductcategory=$tableprefix . "simsalon_productcategory";
$tablevinvoice=$tableprefix . "simsalon_vinvoice";
$tablevinvoiceline=$tableprefix . "simsalon_vinvoiceline";
$tableexpensescategory=$tableprefix . "simsalon_expensescategory";
$tableexpenseslist=$tableprefix . "simsalon_expenseslist";
$tableexpenses=$tableprefix . "simsalon_expenses";
$tableexpensesline=$tableprefix . "simsalon_expensesline";
$tableainternal=$tableprefix . "simsalon_internal";
$tableainternalline=$tableprefix . "simsalon_internalline";
$tablepayroll=$tableprefix . "simsalon_payroll";



if ($_POST){

	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(10);
	$pdf->SetAutoPageBreak(true ,20);

	$pdf->start_date = $_POST['start_date'];
	$pdf->end_date = $_POST['end_date'];

	$yearofstart = substr($pdf->start_date,0,4);
	$yearofend = substr($pdf->end_date,0,4);
	$monthofstart = substr($pdf->start_date,5,2);
	$monthofend = substr($pdf->end_date,5,2);

	$pdf->uid = $xoopsUser->getVar('uid');
	$pdf->org_info = getOrganizationInfo($xoopsDB,$tableprefix);
	//$pdf->xoopsDB2 = $xoopsDB;
	

	$sqlsales = 	"select sum(b.salesline_amount) as total,d.isitem from $tablesales a,$tablesalesline b,
			$tableproductlist c,$tableproductcategory d
			where a.sales_id = b.sales_id and b.product_id = c.product_id and c.category_id = d.category_id
			and a.iscomplete = 'Y' and a.isactive = 'Y' 
			and a.sales_date between '$pdf->start_date' and '$pdf->end_date' 
			group by d.isitem";

	$sqlothers = 	"select b.salesline_amount as amt ,c.product_name as pname from $tablesales a,$tablesalesline b,
			$tableproductlist c,$tableproductcategory d
			where a.sales_id = b.sales_id and b.product_id = c.product_id and c.category_id = d.category_id
			and a.iscomplete = 'Y' and a.isactive = 'Y'  
			and a.sales_date between '$pdf->start_date' and '$pdf->end_date'
			and d.isitem = 'Y' ";

	$sqlcogs = 	"select sum(a.vinvoice_totalamount) as total from $tablevinvoice a 
			where a.iscomplete = 'Y' and a.isactive = 'Y'  
			and a.vinvoice_date between '$pdf->start_date' and '$pdf->end_date'";

	$sqlvariant = 	"select sum(b.internalline_qty*c.amt) as total from $tableainternal a, $tableainternalline b, $tableproductlist c
			where a.internal_id = b.internal_id  and b.product_id = c.product_id 
			and a.iscomplete = 'Y' and a.isactive = 'Y'  
			and a.internal_type = 'A' 
			and a.internal_date between '$pdf->start_date' and '$pdf->end_date'";

	$sqlexpenses = 	"select sum(a.expenses_totalamount) as total,d.category_id,d.category_description from $tableexpenses a,
			$tableexpenseslist c,$tableexpensescategory d 
			where a.expenseslist_id = c.expenseslist_id and c.category_id = d.category_id 
			and a.isactive = 'Y' and a.isactive = 'Y'  
			and a.expenses_date between '$pdf->start_date' and '$pdf->end_date' 
			group by d.category_id";

	$sqlsalary = 	"select sum(payroll_totalamount) as total_amt from $tablepayroll a 
			where ( (a.payroll_yearof between $yearofstart and $yearofend) and (a.payroll_monthof between $monthofstart and $monthofend) ) and a.iscomplete = 'Y' and a.isactive = 'Y' ";
	

	$querysales=$xoopsDB->query($sqlsales);
	$queryothers=$xoopsDB->query($sqlothers);
	$querycogs=$xoopsDB->query($sqlcogs);
	$queryvariant=$xoopsDB->query($sqlvariant);
	$queryexpenses=$xoopsDB->query($sqlexpenses);
	$querysalary=$xoopsDB->query($sqlsalary);

	$totalothers = "0.00";
	$totalproduct = "0.00";
	$totalservice = "0.00";
	$totalcogs = "0.00";
	$totalvariants = "0.00";
	$totalsalary = "0.00";
	
	//get sales detail
	while($row=$xoopsDB->fetchArray($querysales)){
	
	if($row['isitem']=="Y" && $row['total'] > 0)//others
	$totalothers = number_format($row['total'], 2, '.','');
	if($row['isitem']=="C" && $row['total'] > 0)//service
	$totalservice = number_format($row['total'], 2, '.','');
	if($row['isitem']=="N" && $row['total'] > 0)//product
	$totalproduct = number_format($row['total'], 2, '.','');
		

   	}

	//get cogs detail
	while($row=$xoopsDB->fetchArray($querycogs)){
	
	if($row['total'] > 0)//others
	$totalcogs = number_format($row['total'], 2, '.','');
   	}

	//get variants detail
	while($row=$xoopsDB->fetchArray($queryvariant)){
	
	//if($row['total'] > 0)//others
	$totalvariants = number_format($row['total'], 2, '.','');
   	}


  	
	
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	//$pdf->SetDrawColor(210,210,210);

	//print content -->total width 190
	$pdf->SetXY(10,40);
	$pdf->SetFont('Arial','B',10); 
	//sales
 	$pdf->Cell(60,10,"(+) Sales  $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,"",0,0,'R');
	$pdf->Cell(95,10,"",0,1,'R');
	//sales product
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Product",0,0,'L');
	$pdf->Cell(35,10,"$totalproduct",0,0,'R');
	$pdf->Cell(95,10,"",0,1,'R');
	//sales service
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Service",0,0,'L');
	$pdf->Cell(35,10,$totalservice,0,0,'R');
	$pdf->Cell(95,10,"",0,1,'R');

	//line 1
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(50,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');

	//sales total
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,number_format(($totalproduct+$totalservice), 2, '.',''),0,0,'R');
	$pdf->Cell(95,10,number_format(($totalproduct+$totalservice), 2, '.',''),0,1,'R');
	//COGS
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(155,10,"(-) Cost Of Good Sold $cur_symbol",0,0,'L');
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(35,10,$totalcogs,0,1,'R');
	// line 2
	$pdf->Cell(155,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,1,'R');

	//Gross Profit
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(155,10,"     Gross Profit $cur_symbol",0,0,'L');
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(35,10,number_format(($totalproduct+$totalservice-$totalcogs), 2, '.',''),0,1,'R');

	//Others Income
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(190,10,"(+) Others Income $cur_symbol",0,1,'L');

	$pdf->SetFont('Arial','',10); 
	$i=0;
	$totalamountothers = 0;
	while($row=$xoopsDB->fetchArray($queryothers)){
	$i++;
	$totalothers = "0.00";
	$pname = $row['pname'];
	
	if($row['amt'] > 0){//others
	$amt = number_format($row['amt'], 2, '.','');
	$totalamountothers += $amt;

	//others list
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"$pname",0,0,'L');
	$pdf->Cell(35,10,"$amt",0,0,'R');
	$pdf->Cell(95,10,"",0,1,'R');
	}

	
	}
	
	//line 3
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(50,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');

	//others total
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,number_format($totalamountothers, 2, '.',''),0,0,'R');
	$pdf->Cell(95,10,number_format(($totalproduct+$totalservice+$totalamountothers-$totalcogs), 2, '.',''),0,1,'R');

	//get variants detail
	//Expenses --> looping 

	//Expenses
	$pdf->SetFont('Arial','B',10); 
 	$pdf->Cell(60,10,"(-) Expenses  $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,"",0,0,'R');
	$pdf->Cell(95,10,"",0,1,'R');

	$pdf->SetFont('Arial','',10); 
	$i=0;
	$totalamountexp = 0;
	while($row=$xoopsDB->fetchArray($queryexpenses)){
	$i++;
	$totalexpenses = "0.00";
	$exp = "";
	$expenses_name = $row['category_description'];
	
	if($row['total'] > 0){//others
	$totalexpenses = number_format($row['total'], 2, '.','');
	$totalamountexp += $totalexpenses;
	}

	//expenses
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,$expenses_name,0,0,'L');
	$pdf->Cell(35,10,"$totalexpenses",0,0,'R');
	$pdf->Cell(95,10,"",0,1,'R');
	}

	if($row=$xoopsDB->fetchArray($querysalary)){
	$totalsalary = $row['total_amt'];
	}

	if($totalsalary > 0){

	$totalsalary = number_format($totalsalary, 2, '.','');
	//salary under expenses
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Salary",0,0,'L');
	$pdf->Cell(35,10,"$totalsalary",0,0,'R');
	$pdf->Cell(95,10,"",0,1,'R');
	$totalamountexp = $totalamountexp + $totalsalary;
	}

	//line 4
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(50,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');
	//expenses total
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,number_format($totalamountexp, 2, '.',''),0,0,'R');
	$pdf->Cell(95,10,number_format(($totalproduct+$totalservice+$totalamountothers-$totalcogs-$totalamountexp), 2, '.',''),0,1,'R');

	//variants adjustment
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(155,10,"(-) Variants $cur_symbol",0,0,'L');
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(35,10,$totalvariants,0,1,'R');
	//line 5
	$pdf->Cell(155,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,1,'R');

	
	//Net Profit
	if(($totalproduct+$totalservice-$totalcogs+$totalothers-$totalamountexp-$totalvariants) >= 0 )
	$profitname = 'Net Profit';
	else
	$profitname = 'Net Loss';

	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(155,10,"$profitname $cur_symbol",0,0,'L');
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(35,10,number_format(($totalproduct+$totalservice+$totalamountothers-$totalcogs-$totalamountexp-$totalvariants), 2, '.',''),0,1,'R');

	//line 6
	$pdf->Cell(155,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,1,'R');

	//$pdf->MultiCell(175,7,$sqlvariant,1,'C');
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


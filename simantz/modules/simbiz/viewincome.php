<?php
include_once('../simantz/class/fpdf/fpdf.php');
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
	$this->Image('./images/logo.jpg', 10 , 10 , 60 , '' , 'JPG' , '');
	$this->Ln();
	$this->SetFont('Times','B',20);
	$this->SetXY(10,10);
	$this->Cell(0,17," ",1,0,'R');
	$this->Cell(0,17,"Income Statement",1,0,'R');
	//  $this->Cell(0,17,"$this->tuitionclass_code",1,0,'R');
	
	
	
	$this->Ln(20);
	// $this->SetFont('Arial','B',12);
	
	$this->SetFont('Times','',10);   
	$this->Cell(24,7,"Account From",1,0,'L');
	$this->SetFont('Arial','B',12);
	$this->Cell(25,7,"$this->accounts_codefrom",1,0,'C');
	$this->SetFont('Times','',10);
	$this->Cell(24,7,"Account To",1,0,'L');
	$this->SetFont('Arial','B',12);
	$this->Cell(25,7,"$this->accounts_codeto",1,0,'C');
	
	$this->SetFont('Times','',10);
	$this->Cell(20,7,"Date From",1,0,'C');
	  $this->SetFont('Times','B',10);
	$this->Cell(26,7,"$this->datefromh",1,0,'C');
	$this->SetFont('Times','',10);
	$this->Cell(20,7,"Date To",1,0,'C');
	$this->SetFont('Times','B',10);
	$this->Cell(26,7,"$this->datetoh" ,1,0,'C');

   
$this->Ln(9);
/*
$i=0;
	$header=array("No","Code","Account Name","Debit","Credit","Balance","Batch","Doc. No");
    $w=array(10,20,55,20,20,20,20,25);
   



foreach($header as $col)
     	{
	$this->SetFont('Arial','B',9); 
       	$this->Cell($w[$i],7,$col,1,0,'C');
	$i=$i+1;		
	}	
    $this->Ln();*/
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('courier','I',8);
	
    $this->Cell(0,4,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
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
$tabletransaction=$tableprefix . "simbiz_transaction";
$tablebatch=$tableprefix . "simbiz_batch";
$tableaccounts=$tableprefix . "simbiz_accounts";
$tableaccountgroup=$tableprefix . "simbiz_accountgroup";
$tableaccountclass=$tableprefix . "simbiz_accountclass";




if ($_POST['viewpdf'] == "1"){

	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(10);
	$pdf->SetAutoPageBreak(true ,20);

	$pdf->datefromh = $_POST['datefromh'];
	$pdf->datetoh = $_POST['datetoh'];

	$isselect = $_POST['isselect'];
	$periodid_array = $_POST['periodid_array'];
	$periodname_array = $_POST['periodname_array'];
	
	$pdf->accounts_codefrom=$_POST['accounts_codefrom'];
	$pdf->accounts_codeto=$_POST['accounts_codeto'];
	

	if($_POST['accounts_codefrom']=="")
		$pdf->accounts_codefrom="0000000";
	if($_POST['accounts_codeto']=="")
		$pdf->accounts_codeto="9999999";
	
	$pdf->uid = $xoopsUser->getVar('uid');
	
	$count = count($periodid_array);
	
	$line = 0;
	$line2 = 0;
	while($line < $count){
	
	$line++;
	$period_id = $periodid_array[$line];
	$period_name = $periodname_array[$line];
	$isselectline = $isselect[$line];
	
	if($isselectline == "on"){
	$line2++;
	$wherestr	=	"  and (b.accounts_code between '$pdf->accounts_codefrom' AND '$pdf->accounts_codeto') 
				and d.batch_id > 0 and b.accounts_id > 0 and d.iscomplete = 1 
				and b.organization_id = $defaultorganization_id 
				and c.organization_id = $defaultorganization_id 
				and d.organization_id = $defaultorganization_id 
				and d.period_id = $period_id 
				and b.placeholder = 0 ";

				

	$groupby 	=	"group by b.accounts_id";
	
	// sales -> classtype = S, other sales -> classtype = S, cogs -> classtype = P
	// expenses -> classtype = X, other expenses -> classtype = X
	
	$sqlsales = 
				"select sum(a.amt) as total, b.accounts_name from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e 
				where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
				and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
				and e.classtype = 'S' 
				$wherestr 
				$groupby ";

	$sqlothersincome = 	
				"select sum(a.amt) as total, b.accounts_name from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e  
				where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
				and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
				and e.classtype = 'I' 
				$wherestr 
				$groupby ";

	$sqlcogs = 	
				"select sum(a.amt) as total, b.accounts_name  from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e  
				where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
				and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
				and e.classtype = 'C' 
				$wherestr 
				$groupby ";

	$sqlexpenses = 	
				"select sum(a.amt) as total, b.accounts_name from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e  
				where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
				and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
				and e.classtype = 'X' 
				$wherestr 
				$groupby ";
	


	$querysales=$xoopsDB->query($sqlsales);
	$queryothersincome=$xoopsDB->query($sqlothersincome);
	$querycogs=$xoopsDB->query($sqlcogs);
	$queryexpenses=$xoopsDB->query($sqlexpenses);
	$queryothersexpenses=$xoopsDB->query($sqlothersexpenses);


	$totalsales = "0.00";
	$totalothersincome = "0.00";
	$totalcogs = "0.00";
	$totalexpenses = "0.00";
	$totalothersexpenses = "0.00";
	
	
	//print header
	$pdf->SetFont('Arial','',10);
	
	if($line2 == 1){
	$pdf->AddPage();
	$current_X = 10;
	}else{
	$current_X = 108;
	}
	//$pdf->SetDrawColor(210,210,210);

	//header (period)
	$pdf->SetXY($current_X,40);
	$pdf->SetFont('Arial','B',10); 
	//sales
 	$pdf->Cell(97,6,$period_name,1,1,'C');
//	$pdf->Cell(35,6,"",0,1,'R');
	//end of header
	
	//print content -->total width 190
	$pdf->SetX($current_X);
	$pdf->SetFont('Arial','B',10); 
	//sales
 	$pdf->Cell(60,10,"(+) Sales  $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,"",0,1,'R');
//	$pdf->Cell(95,10,"",0,1,'R');


	$pdf->SetFont('Arial','',10);
	
	$i=0;
	$totalsales = 0;
	while($row=$xoopsDB->fetchArray($querysales)){
	$i++;
	$pdf->SetX($current_X);
	$totalsales += $row['total'];
	 
	$pdf->Cell(10,6,"",0,0,'L');
	$pdf->Cell(50,6,$row['accounts_name'],0,0,'L');
	$pdf->Cell(35,6,number_format($row['total'],2),0,0,'R');
	$pdf->Cell(95,6,"",0,1,'R');
	}


	//line 1
	$pdf->SetX($current_X);
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(50,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');


	//sales total
	$pdf->SetX($current_X);
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,number_format($totalsales, 2),0,1,'R');
//	$pdf->Cell(95,10,number_format($totalsales, 2),0,1,'R');

	
	//COGS
	$pdf->SetX($current_X);
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(155,10,"(-) Cost Of Good Sold $cur_symbol",0,0,'L');
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(35,10,"",0,1,'R');
	/*
	// line 2
	$pdf->Cell(155,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,1,'R');
	*/

	$pdf->SetFont('Arial','',10);
	
	$i=0;
	$totalcogs = 0;
	while($row=$xoopsDB->fetchArray($querycogs)){
	$i++;
	$pdf->SetX($current_X);
	$totalcogs += $row['total']*-1;
	 
	$pdf->Cell(10,6,"",0,0,'L');
	$pdf->Cell(50,6,$row['accounts_name'],0,0,'L');
	$pdf->Cell(35,6,number_format($row['total']*-1,2),0,0,'R');
	$pdf->Cell(95,6,"",0,1,'R');
	}

	//line 1
	$pdf->SetX($current_X);
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(50,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');

	//cogs total
	$pdf->SetX($current_X);
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,number_format($totalcogs, 2),0,1,'R');
//	$pdf->Cell(95,10,number_format($totalcogs, 2),0,1,'R');
	

	//Gross Profit
	$pdf->SetX($current_X);
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(60,10,"     Gross Profit $cur_symbol",0,0,'L');
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(35,10,number_format(($totalsales-$totalcogs), 2),0,1,'R');

	//Others Income
	$pdf->SetX($current_X);
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(190,6,"(+) Others Income $cur_symbol",0,1,'L');

	$pdf->SetFont('Arial','',10); 
	$i=0;
	$totalothersincome = 0;
	while($row=$xoopsDB->fetchArray($queryothersincome)){
	$i++;
	$totalothers = "0.00";
	$pdf->SetX($current_X);
	//if($row['total'] > 0){//others

	$totalothersincome += $row['total'];

	//others list
	$pdf->Cell(10,6,"",0,0,'L');
	$pdf->Cell(50,6,$row['accounts_name'],0,0,'L');
	$pdf->Cell(35,6,number_format($row['total'],2),0,0,'R');
	$pdf->Cell(95,6,"",0,1,'R');
	//}

	
	}
	
	//line 3
	$pdf->SetX($current_X);
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(50,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');

	//others total
	$pdf->SetX($current_X);
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,number_format($totalothersincome, 2),0,1,'R');
//	$pdf->Cell(95,10,number_format(($totalsales+$totalothersincome-$totalcogs), 2),0,1,'R');

	//get variants detail
	//Expenses --> looping 

	//Expenses
	$pdf->SetX($current_X);
	$pdf->SetFont('Arial','B',10); 
 	$pdf->Cell(60,10,"(-) Expenses  $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,"",0,0,'R');
	$pdf->Cell(95,10,"",0,1,'R');

	$pdf->SetFont('Arial','',10); 
	$i=0;
	$totalexpenses = 0;
	while($row=$xoopsDB->fetchArray($queryexpenses)){
	$i++;
	$pdf->SetX($current_X);
	$expenses_name = $row['category_description'];
	
	$totalexpenses += $row['total']*-1;
	
	//expenses
	$pdf->Cell(10,6,"",0,0,'L');
	$pdf->Cell(50,6,$row['accounts_name'],0,0,'L');
	$pdf->Cell(35,6,number_format($row['total']*-1,2),0,0,'R');
	$pdf->Cell(95,6,"",0,1,'R');
	}


	//line 4
	$pdf->SetX($current_X);
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(50,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');
	//expenses total
	$pdf->SetX($current_X);
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,number_format($totalexpenses, 2),0,1,'R');
//	$pdf->Cell(95,10,number_format(($totalsales+$totalothersincome-$totalcogs-$totalexpenses), 2),0,1,'R');
	
	
	
	//line 5
	$pdf->SetX($current_X);
	$pdf->Cell(60,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,1,'R');
	
	//Net Profit
	if(($totalsales+$totalothersincome-$totalcogs-$totalexpenses) >= 0 )
	$profitname = 'Net Profit';
	else
	$profitname = 'Net Loss';

	$pdf->SetX($current_X);
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(60,10,"$profitname $cur_symbol",0,0,'L');
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(35,10,number_format(($totalsales+$totalothersincome-$totalcogs-$totalexpenses), 2),0,1,'R');

	//line 6
	$pdf->SetX($current_X);
	$pdf->Cell(60,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,1,'R');
	
	}
	
//	$pdf->MultiCell(175,7,$isselectline,1,'C');
	
	}

	//display pdf
	$pdf->Output();
	exit (1);


}
else {

include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/SelectCtrl.php';
include_once "../../class/datepicker/class.datepicker.php";
$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$ctrl= new SelectCtrl();
$accountsctrl=$ctrl->getSelectAccounts(0,'N');
$periodfrom=$ctrl->getSelectPeriod(0,'Y',"","period_from");
$periodto=$ctrl->getSelectPeriod(0,'Y',"","period_to");
$showDateFrom=$dp->show("datefrom");
$showDateTo=$dp->show("dateto");

$datefrom = getMonth(date("Ymd", time()),0) ;
$dateto = getMonth(date("Ymd", time()),1) ;
echo <<< EOF
<table border='1'>
<tbody>
<tr><TH colspan='4' style='text-align: center'>Criterial</TH></tr>
	<FORM name='frmIncome' method='POST' atarget="_blank" action="viewincome.php">
	<tr>
		<Td class='head'>Account From</Td>
		<Td  class='odd'><input name='accounts_codefrom' value="$accounts_codefrom"></Td>
		<Td class='head'>Account To</Td>
		<Td class='odd'><input name='accounts_codeto' value="$accounts_codeto"></Td>
		
	</tr>
<!--<tr>
		<Td class='head'>Date From</Td>
		<Td  class='odd'><input id='datefrom' name='datefrom' value="$datefrom">
				<input type='button' value='Date' onclick="$showDateFrom">
		</Td>
		<Td class='head'>Date To</Td>
		<Td class='odd'>
			<input id='dateto' name='dateto' value="$dateto" onclick="$showDateTo">
			<input type='button' value='Date' onclick="$showDateTo">
		</Td>
		
	</tr>-->
	
	<tr>
		<Td class='head'>Period From</Td>
		<Td  class='odd'>$periodfrom</Td>
		<Td class='head'>Period To</Td>
		<Td class='odd'>$periodto</Td>
		
	</tr>

</tbody>
</table>
<INPUT type='reset' name='reset' value='Reset'><INPUT type='submit' name='submit' value='Search'>
<input type="hidden" name="viewpdf" value="0">

</FORM>

EOF;

if($_POST["viewpdf"] == "0"){

	$datefrom=$_POST['period_from'];
	$dateto=$_POST['period_to'];
	$accounts_codefrom=$_POST['accounts_codefrom'];
	$accounts_codeto=$_POST['accounts_codeto'];
	
		
	$datefrom = str_replace("-", "", getPeriodDate($datefrom));
	$dateto = str_replace("-", "", getPeriodDate($dateto));
	
	
	if($datefrom != "")
	$datefrom = 	getMonth($datefrom."01",0);
	if($dateto != "")
	$dateto = 	getMonth($dateto."01",1);
	
	if($datefrom=="")
		$datefrom="0000-00-00";
	if($dateto=="")
		$dateto="9999-12-31";

	//$pdf->datefromh = $datefrom;
	//$pdf->datetoh = $dateto;

	if($_POST['accounts_codefrom']=="")
		$accounts_codefrom="0000000";
	if($_POST['accounts_codeto']=="")
		$accounts_codeto="9999999";
		
	$wherestr	=	" and (d.batchdate between '$datefrom' AND '$dateto') AND 
				(b.accounts_code between '$accounts_codefrom' AND '$accounts_codeto')
				and d.batch_id > 0 and b.accounts_id > 0 and d.iscomplete = 1 
				and b.organization_id = $defaultorganization_id 
				and c.organization_id = $defaultorganization_id 
				and d.organization_id = $defaultorganization_id 
				and b.placeholder = 0  
				and a.amt <> 0 
				";
				
	$groupby 	=	" group by d.period_id ";
	$orderby 	= 	" order by d.period_id ";
		
	$sql		= 
				"select sum(a.amt) as total, d.period_id,e.classtype, b.accounts_name, f.period_name
				from $tabletransaction a, $tableaccounts b, $tableaccountgroup c, $tablebatch d, 
				$tableaccountclass e, $tableperiod f  
				where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
				and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
				and e.classtype in ('S','I','C','X')  and d.period_id = f.period_id 
				$wherestr 
				$groupby $orderby ";

	$sqlS		= 
				"select e.classtype, b.accounts_name 
				from $tabletransaction a, $tableaccounts b, $tableaccountgroup c, $tablebatch d, 
				$tableaccountclass e, $tableperiod f  
				where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
				and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
				and e.classtype in ('S')  and d.period_id = f.period_id 
				$wherestr 
				group by b.accounts_name $orderby ";

	$sqlC		= 
				"select e.classtype, b.accounts_name 
				from $tabletransaction a, $tableaccounts b, $tableaccountgroup c, $tablebatch d, 
				$tableaccountclass e, $tableperiod f  
				where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
				and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
				and e.classtype in ('C')  and d.period_id = f.period_id 
				$wherestr 
				group by b.accounts_name $orderby ";

	$sqlI		= 
				"select e.classtype, b.accounts_name 
				from $tabletransaction a, $tableaccounts b, $tableaccountgroup c, $tablebatch d, 
				$tableaccountclass e, $tableperiod f  
				where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
				and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
				and e.classtype in ('I')  and d.period_id = f.period_id 
				$wherestr 
				group by b.accounts_name $orderby ";

	$sqlX		= 
				"select e.classtype, b.accounts_name 
				from $tabletransaction a, $tableaccounts b, $tableaccountgroup c, $tablebatch d, 
				$tableaccountclass e, $tableperiod f  
				where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
				and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
				and e.classtype in ('X')  and d.period_id = f.period_id 
				$wherestr 
				group by b.accounts_name $orderby ";


echo <<< EOF
	<table border=0><tr><td>

	<table>
	<tr  height="27"><th>Period</th></tr>
EOF;
	echo 	"<tr><td class='head' colspan='2'><b>(+) Sales</b></td></tr>";
	$queryS=$xoopsDB->query($sqlS);
	$ck1 = 0;
	while($row=$xoopsDB->fetchArray($queryS)){
	$accounts_name = $row['accounts_name'];
	echo 	"<tr height=27><td class='even'>$accounts_name</td></tr>";
	$ck1++;
	$ck1_name[$ck1] = $row['accounts_name'];
	}
	
	if($ck1 == 0)
	echo 	"<tr height=27><td class='even'></td></tr>";

	echo 	"<tr><td class='head' colspan='2'><b>(-) Cost Of Good Sold</b></td></tr>";
	$queryC=$xoopsDB->query($sqlC);
	$ck2 = 0;
	while($row=$xoopsDB->fetchArray($queryC)){
	$accounts_name = $row['accounts_name'];
	echo 	"<tr height=27><td class='even'>$accounts_name</td></tr>";
	$ck2++;
	$ck2_name[$ck2] = $row['accounts_name'];
	}

	if($ck2 == 0)
	echo 	"<tr height=27><td class='even'></td></tr>";

	echo "<tr height='27'><td class='head'><b>Gross Profit</b></td></tr>";

	echo 	"<tr><td class='head' colspan='2'><b>(+) Others Income</b></td></tr>";
	$queryI=$xoopsDB->query($sqlI);
	$ck3 = 0;
	while($row=$xoopsDB->fetchArray($queryI)){
	$accounts_name = $row['accounts_name'];
	echo 	"<tr height=27><td class='even'>$accounts_name</td></tr>";
	$ck3++;
	$ck3_name[$ck3] = $row['accounts_name'];
	}

	if($ck3 == 0)
	echo 	"<tr height=27><td class='even'></td></tr>";

	echo 	"<tr><td class='head' colspan='2'><b>(-) Expenses</b></td></tr>";
	$queryX=$xoopsDB->query($sqlX);
	$ck4 = 0;
	while($row=$xoopsDB->fetchArray($queryX)){
	$accounts_name = $row['accounts_name'];
	echo 	"<tr height=27><td class='even'>$accounts_name</td></tr>";
	$ck4++;
	$ck4_name[$ck4] = $row['accounts_name'];
	}

	if($ck4 == 0)
	echo 	"<tr height=27><td class='even'></td></tr>";

	echo "<tr height='27'><td class='head'><b>Net Profit</b></td></tr>";

echo <<< EOF
	</table>
	</td>
EOF;
//start table
echo <<< EOF
	</td><td>

	<form action="viewincome.php" method="POST" target="_BLANK" name='frmIncomeSub'  onsubmit="return validateCheck();">
	<table>
	<input name="datefromh" value="$datefrom" type="hidden">
	<input name="datetoh" value="$dateto" type="hidden">
	<tr>
EOF;
	$query=$xoopsDB->query($sql);
	
	$j = 0;
	while($row=$xoopsDB->fetchArray($query)){
	$j++;
	
	$period_id = $row['period_id'];
	$period_name = $row['period_name'];
echo <<< EOF
	
	<td>
	<table>
	<tr  height="25">
	<th>
	$period_name 
	<input type= "checkbox" name="isselect[$j]" onclick="checkSelect(this,$j)">
	<input type="hidden" name="periodid_array[$j]" value="$period_id">
	<input type="hidden" name="periodname_array[$j]" value="$period_name">
	</th>
	</tr>
EOF;

	$wherestrsub	=	
						" and (d.batchdate between '$datefrom' AND '$dateto') AND 
						(b.accounts_code between '$accounts_codefrom' AND '$accounts_codeto')
						and d.batch_id > 0 and b.accounts_id > 0 and d.iscomplete = 1 
						and b.organization_id = $defaultorganization_id 
						and c.organization_id = $defaultorganization_id 
						and d.organization_id = $defaultorganization_id 
						and b.placeholder = 0  
						and a.amt <> 0 
						
						and d.period_id = $period_id ";
				
	$groupbysub 	=	" group by b.accounts_name ";
	$orderbysub 	= 	" order by d.period_id ";
	
						
	$totalsales = 0;
	$totalcogs = 0;	
	$totalincome = 0;
	$totalexpenses = 0;
	
	// SALES
	echo 	"<tr height='27'><td class='head'></td></tr>";
	$cnt = 0;
	while($cnt < $ck1){
	$cnt++;
		
	$sqlsubsales	= 
				"select sum(a.amt) as total, e.classtype, b.accounts_name  from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e 
				where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
				and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
				and e.classtype = 'S' 
				and b.accounts_name = '$ck1_name[$cnt]'  
				$wherestrsub 
				$groupbysub $orderbysub ";

	$querysubsales=$xoopsDB->query($sqlsubsales);

	if($row=$xoopsDB->fetchArray($querysubsales)){
	$accounts_name = $row['accounts_name'];
	$total = number_format($row['total'],2);	
	$classtype = $row['classtype'];	
	$totalsales += $total;
	
	//echo $count."-".$ck1."-".$ck1_name[$count];

echo <<< EOF
	<tr height="25">
	<td class="even" align="right">$total</td>
	</tr>
EOF;
	}else
	echo 	"<tr height='27' align='right'><td class='even'>0.00</td></tr>";

	}
	
	
	if($cnt == 0)
	echo 	"<tr height='27'><td class='even'></td></tr>";
	
	//COGS
	echo 	"<tr height='27'><td class='head'></td></tr>";
	$cnt = 0;
	while($cnt < $ck2){
	$cnt++;

	$sqlsubcogs	= 
				"select sum(a.amt) as total, e.classtype, b.accounts_name  from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e 
				where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
				and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
				and e.classtype = 'C' 
				and b.accounts_name = '$ck2_name[$cnt]'  
				$wherestrsub 
				$groupbysub $orderbysub ";

	$querysubcogs=$xoopsDB->query($sqlsubcogs);
	
	if($row=$xoopsDB->fetchArray($querysubcogs)){
	
	$accounts_name = $row['accounts_name'];
	$total = number_format($row['total']*-1,2);	
	$classtype = $row['classtype'];	
	$totalcogs += $total;
			
echo <<< EOF
	<tr height="25">
	<td class="even" align="right">$total</td>
	</tr>
EOF;
	}else
	echo 	"<tr height='27' align='right'><td class='even'>0.00</td></tr>";

	}


	if($cnt == 0)
	echo 	"<tr height='27'><td class='even'></td></tr>";
	

	$total_gp = number_format($totalsales - $totalcogs,2);
	//GROSS PROFIT
	echo "<tr height='27'><td class='head'  align='right'>$total_gp</td></tr>";
	
	//OTHERS INCOME
	echo 	"<tr height='27'><td class='head'></td></tr>";

	$cnt = 0;
	while($cnt < $ck3){
	$cnt++;	
	$sqlsubincome	= 
				"select sum(a.amt) as total, e.classtype, b.accounts_name  from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e 
				where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
				and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
				and e.classtype = 'I' 
				and b.accounts_name = '$ck3_name[$cnt]'  
				$wherestrsub 
				$groupbysub $orderbysub ";

	$querysubincome=$xoopsDB->query($sqlsubincome);
	
	if($row=$xoopsDB->fetchArray($querysubincome)){
	
	$accounts_name = $row['accounts_name'];
	$total = number_format($row['total'],2);	
	$classtype = $row['classtype'];	
	$totalincome += $total;
	
echo <<< EOF
	<tr height="25">
	<td class="even" align="right">$total</td>
	</tr>
EOF;
	}else
	echo 	"<tr height='27' align='right'><td class='even'>0.00</td></tr>";

	}
	
	if($cnt == 0)
	echo 	"<tr height='27'><td class='even'></td></tr>";

	//EXPENSES
	echo 	"<tr height='27'><td class='head'></td></tr>";
	$cnt = 0;
	while($cnt < $ck4){
	$cnt++;	
	$sqlsubexpenses	= 
					"select sum(a.amt) as total, e.classtype, b.accounts_name  from $tabletransaction a, 
					$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e 
					where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
					and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
					and e.classtype = 'X' 
					and b.accounts_name = '$ck4_name[$cnt]'  
					$wherestrsub 
					$groupbysub $orderbysub ";

	$querysubexpenses=$xoopsDB->query($sqlsubexpenses);

	if($row=$xoopsDB->fetchArray($querysubexpenses)){	
	$accounts_name = $row['accounts_name'];
	$total = number_format($row['total']*-1,2);	
	$classtype = $row['classtype'];	
	$totalexpenses += $total;
	
echo <<< EOF
	<tr height="25">
	<td class="even" align="right">$total</td>
	</tr>
EOF;
	}else
	echo 	"<tr height='27' align='right'><td class='even'>0.00</td></tr>";

	}
	
	if($cnt == 0)
	echo 	"<tr height='27'><td class='even'></td></tr>";

	
	$total_net = number_format($totalsales - $totalcogs + $totalincome - $totalexpenses,2);
	
	if($total_net >= 0)
	$netname = "Net Profit";
	else
	$netname = "Net Loss";
	
	//NET PROFIT
	echo "<tr height='27'><td class='head' align='right'>$total_net</td></tr>";

echo <<< EOF
	</table>
	</td>
EOF;
	}
echo <<< EOF
	</tr>
	
	<tr>
	<td>
	<input type="submit" value="View PDF">
	<input type="hidden" name="viewpdf" value="1">
	</td>
	</tr>
	</table>
	</form>

	</td></tr><table>
EOF;
}

	require(XOOPS_ROOT_PATH.'/footer.php');
}

?>


<script type='text/javascript'>

function validateCheck(){
	
	var i=0;
	var	istrue = 0
	while(i< document.forms['frmIncomeSub'].elements.length){
	var ctl = document.forms['frmIncomeSub'].elements[i].name; 
	var val = document.forms['frmIncomeSub'].elements[i].checked;
	
	ctlname = ctl.substring(0,ctl.indexOf("["))
	
	if(ctlname == "isselect" && val == true){
	istrue++;
	}
	
	i++;
	}
		
	if(istrue == 0){
	alert("Please select period to View PDF.");
	return false;
	}else{
	return true;
	}

}

function checkSelect(thisone,line){

	var i=0;
	var	istrue = 0
	while(i< document.forms['frmIncomeSub'].elements.length){
		var ctl = document.forms['frmIncomeSub'].elements[i].name; 
		var val = document.forms['frmIncomeSub'].elements[i].checked;
		
		ctlname = ctl.substring(0,ctl.indexOf("["))
		
		if(ctlname == "isselect" && val == true){
		istrue++;
		}
		
		i++;
		}
		
	if(istrue > 2){
		alert('To View PDF, please select 2 period date only.');
		thisone.checked = false;
		/*
		var i=0;
		while(i< document.forms['frmIncomeSub'].elements.length){
		var ctl = document.forms['frmIncomeSub'].elements[i].name; 
		var val = document.forms['frmIncomeSub'].elements[i].checked;
		
		ctlname = ctl.substring(0,ctl.indexOf("["))
		
		if(ctlname == "isselect" && val == true && thisname != ctl){
		document.forms['frmIncomeSub'].elements[i+1].checked = false;
		return;
		}
		i++;
		}*/
	}
				
}
</script>


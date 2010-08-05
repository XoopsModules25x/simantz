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
	$this->Cell(0,17,"Balance Sheet",1,0,'R');
	//  $this->Cell(0,17,"$this->tuitionclass_code",1,0,'R');
	
	
	
	$this->Ln(20);
	// $this->SetFont('Arial','B',12);
	
	$this->SetFont('Times','',10);   
	$this->Cell(35,7,"Account From",1,0,'L');
	$this->SetFont('Arial','B',12);
	$this->Cell(35,7,"$this->accounts_codefrom",1,0,'C');
	$this->SetFont('Times','',10);
	$this->Cell(35,7,"Account To",1,0,'L');
	$this->SetFont('Arial','B',12);
	$this->Cell(35,7,"$this->accounts_codeto",1,0,'C');
	
/*	$this->SetFont('Times','',10);
	$this->Cell(20,7,"Date From",1,0,'C');
	  $this->SetFont('Times','B',10);
	$this->Cell(26,7,"$this->datefrom",1,0,'C');*/

	$this->SetFont('Times','',10);
	$this->Cell(23,7,"Date",1,0,'C');
	$this->SetFont('Times','B',10);
	$this->Cell(27,7,"$this->dateto" ,1,0,'C');

   
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


	function getAccountsID($acc){
	global $xoopsDB,$defaultorganization_id,$tableaccounts;

	$tableprefix= XOOPS_DB_PREFIX . "_";

	$retval = "";
 	$sql  = "select accountcode_full from $tableaccounts 
			where accounts_id = '$acc' ";
  
	$query=$xoopsDB->query($sql);
	if($row=$xoopsDB->fetchArray($query)){
	$retval = $row['accountcode_full'];;
	}
  
  	return $retval;
  
  	}

$tableprefix= XOOPS_DB_PREFIX . "_";
$tabletransaction=$tableprefix . "simbiz_transaction";
$tablebatch=$tableprefix . "simbiz_batch";
$tableaccounts=$tableprefix . "simbiz_accounts";
$tableaccountgroup=$tableprefix . "simbiz_accountgroup";
$tableaccountclass=$tableprefix . "simbiz_accountclass";



if ($_POST){

	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(10);
	$pdf->SetAutoPageBreak(true ,20);


//	$pdf->datefrom=$_POST['datefrom'];
//	$pdf->dateto=$_POST['dateto'];

	$pdf->datefrom=$_POST['period_from'];
	$pdf->dateto=$_POST['period_to'];
	$pdf->accounts_codefrom=getAccountsID($_POST['accounts_codefrom']);
	$pdf->accounts_codeto=getAccountsID($_POST['accounts_codeto']);
	
	$pdf->datefrom = str_replace("-", "", getPeriodDate($pdf->datefrom));
	$pdf->dateto = str_replace("-", "", getPeriodDate($pdf->dateto));
	
	
	if($pdf->datefrom != "")
	$pdf->datefrom = 	getMonth($pdf->datefrom."01",0);
	if($pdf->dateto != "")
	$pdf->dateto = 	getMonth($pdf->dateto."01",1);
	
	
	if($pdf->datefrom=="")
		$pdf->datefrom="0000-00-00";
	if($pdf->dateto=="")
		$pdf->dateto="9999-12-31";
	

	if($pdf->accounts_codefrom=="")
		$pdf->accounts_codefrom="0000000";
	if($pdf->accounts_codeto=="")
		$pdf->accounts_codeto="9999999";
	
	$pdf->uid = $xoopsUser->getVar('uid');

	
	$wherestr	=		" where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
					and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id  
					and ((d.batchdate between '$pdf->datefrom' AND '$pdf->dateto') or d.batchdate = '0000-00-00')
					
					and (b.accountcode_full between '$pdf->accounts_codefrom' AND '$pdf->accounts_codeto') 
					and d.batch_id > 0 and b.accounts_id > 0 and d.iscomplete = 1 
					and b.organization_id = $defaultorganization_id 
					and c.organization_id = $defaultorganization_id 
					and d.organization_id = $defaultorganization_id 
					and b.lastbalance <> 0 
					 ";

	$groupby	=	" group by b.accounts_id ";
	
	// sales -> accountgroup_id = 3, other sales -> accountgroup_id = 6, cogs -> accountgroup_id = 2
	// expenses -> accountgroup_id = 10, other expenses -> accountgroup_id = 7
	// asset ->  accountgroup_id = 1, liablity -> accountgroup_id = 4, equity ->  accountgroup_id = 5
	
	$sqlasset = 
				"select sum(a.amt) as total, b.accounts_name,b.placeholder,b.treelevel from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e  
				$wherestr 
				and e.classtype = 'A' 
				$groupby ";

	$sqlliability = 	
				"select sum(a.amt) as total, b.accounts_name,b.placeholder,b.treelevel from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e  
				$wherestr 
				and e.classtype = 'L' 
				$groupby ";

	$sqlequity = 	
				"select sum(a.amt) as total, b.accounts_name,b.placeholder,b.treelevel  from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e  
				$wherestr 
				and e.classtype = 'E' 
				$groupby ";

	$sqlsales = 
				"select sum(a.amt) as total from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e  
				$wherestr 
				and e.classtype = 'S' ";

	$sqlcogs = 
				"select sum(a.amt) as total from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e  
				$wherestr 
				and e.classtype = 'C' ";

	$sqlincome = 
				"select sum(a.amt) as total from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e  
				$wherestr 
				and e.classtype = 'I' ";

	$sqlexpenses = 
				"select sum(a.amt) as total from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e  
				$wherestr 
				and e.classtype = 'X' ";
	


	$queryasset=$xoopsDB->query($sqlasset);
	$queryliability=$xoopsDB->query($sqlliability);
	$queryequity=$xoopsDB->query($sqlequity);
	$querysales=$xoopsDB->query($sqlsales);
	$querycogs=$xoopsDB->query($sqlcogs);
	$queryincome=$xoopsDB->query($sqlincome);
	$queryexpenses=$xoopsDB->query($sqlexpenses);



	$totalasset = "0.00";
	$totalliability = "0.00";
	$totalequity = "0.00";
	$totalsales = "0.00";
	$totalcogs = "0.00";
	$totalincome = "0.00";
	$totalexpenses = "0.00";
	
	

	/*
	//get cogs detail
	while($row=$xoopsDB->fetchArray($queryequity)){
	
	if($row['total'] > 0)//others
	$totalequity = number_format($row['total'], 2);
   	}*/


  	
	
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	//$pdf->SetDrawColor(210,210,210);

	//print content -->total width 190
	$pdf->SetXY(10,40);
	$pdf->SetFont('Arial','B',10); 
	//sales
 	$pdf->Cell(60,10,"Asset  $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,"",0,0,'R');
	$pdf->Cell(95,10,"",0,1,'R');

	$pdf->SetFont('Arial','',10);
	
	$i=0;
	$totalasset = 0;
	while($row=$xoopsDB->fetchArray($queryasset)){
	$i++;

	$totalasset += $row['total'];

	if($row['total'] == 0)
	$total = "";
	else
	$total = number_format($row['total'],2);

	if($row['placeholder'] == 1 || $total != ""){
	$curX = 2*$row['treelevel']+10;
	$pdf->SetX($curX);
	$pdf->Cell(10,6,"",0,0,'L');
	$pdf->Cell(100-$curX,6,$row['accounts_name'],0,0,'L');
	$pdf->Cell(25,6,$total,0,0,'R');
	$pdf->Cell(95,6,"",0,1,'R');
	}
	}

	//line 1
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(90,0,"",0,0,'L');
	$pdf->Cell(25,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');

	//sales total
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(90,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(25,10,number_format($totalasset, 2),0,1,'R');
	//$pdf->Cell(95,10,number_format($totalasset, 2),0,1,'R');

	$pdf->Ln(9);
	$pdf->Cell(125,0,"",1,1,'L');
	$pdf->Ln(6);

	//Liabilities
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(190,6,"Liability $cur_symbol",0,1,'L');

	$pdf->SetFont('Arial','',10); 
	$i=0;
	$totalliability = 0;
	while($row=$xoopsDB->fetchArray($queryliability)){
	$i++;
	$totalothers = "0.00";

	$totalliability += $row['total']*-1;

	if($row['total'] == 0)
	$total = "";
	else
	$total = number_format($row['total']*-1,2);

	if($row['placeholder'] == 1 || $total != ""){
	$curX = 2*$row['treelevel']+10;
	$pdf->SetX($curX);
	//liabilty list
	$pdf->Cell(10,6,"",0,0,'L');
	$pdf->Cell(100-$curX,6,$row['accounts_name'],0,0,'L');
	$pdf->Cell(25,6,$total,0,0,'R');
	$pdf->Cell(95,6,"",0,1,'R');
	}

	
	}
	
	//line 3
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(90,0,"",0,0,'L');
	$pdf->Cell(25,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');

	//liabilty total
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(90,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(25,10,number_format($totalliability, 2),0,1,'R');
	//$pdf->Cell(95,10,number_format(($totalliability), 2),0,1,'R');
	
	//Equity
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(155,10,"Equity $cur_symbol",0,0,'L');
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(35,10,"",0,1,'R');
	/*
	// line 2
	$pdf->Cell(155,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,1,'R');
	*/
	
	
	$pdf->SetFont('Arial','',10);
	
	$i=0;
	$totalequity = 0;
	while($row=$xoopsDB->fetchArray($queryequity)){
	$i++;

	$totalequity += $row['total']*-1;

	if($row['total'] == 0)
	$total = "";
	else
	$total = number_format($row['total']*-1,2);

	if($row['placeholder'] == 1 || $total != ""){
	$curX = 2*$row['treelevel']+10;
	$pdf->SetX($curX);	 
	$pdf->Cell(10,6,"",0,0,'L');
	$pdf->Cell(100-$curX,6,$row['accounts_name'],0,0,'L');
	$pdf->Cell(25,6,$total,0,0,'R');
	$pdf->Cell(95,6,"",0,1,'R');
	}

	}

	//line 1
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(90,0,"",0,0,'L');
	$pdf->Cell(25,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');
	

	//equity total
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(90,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(25,10,number_format($totalequity, 2),0,1,'R');
	//$pdf->Cell(95,10,number_format($totalequity, 2),0,1,'R');
	

	//Retain earning $totalliability+$totalequity
	$totalsales = 0;
	if($row=$xoopsDB->fetchArray($querysales)){
	$totalsales = $row['total'];
	}

	$totalcogs = 0;
	if($row=$xoopsDB->fetchArray($querycogs)){
	$totalcogs = $row['total']*-1;
	}

	$totalincome = 0;
	if($row=$xoopsDB->fetchArray($queryincome)){
	$totalincome = $row['total'];
	}

	$totalexpenses = 0;
	if($row=$xoopsDB->fetchArray($queryexpenses)){
	$totalexpenses = $row['total']*-1;
	}

	$retainearning = $totalsales - $totalcogs + $totalincome -$totalexpenses;
	
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(100,10,"Retain Earning $cur_symbol",0,0,'L');
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(25,10,number_format($retainearning*-1, 2),0,1,'R');

	$pdf->Ln(1);
	//line 5
	$pdf->Cell(100,0,"",0,0,'L');
	$pdf->Cell(25,0,"",1,1,'R');
	
	//Asset
	$profitname = 'Total Liability + Equity';

	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(100,10,"$profitname $cur_symbol",0,0,'L');
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(25,10,number_format(($totalliability + $totalequity + $retainearning*-1), 2),0,1,'R');

	//line 6
	$pdf->Cell(100,0,"",0,0,'L');
	$pdf->Cell(25,0,"",1,1,'R');

	//$pdf->MultiCell(175,7,$sqlsales,1,'C');
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
//$accountsctrl=$ctrl->getSelectAccounts(0,'N');
$accountsctrlfrom=$ctrl->getSelectAccounts(0,'Y',"","accounts_codefrom");
$accountsctrlto=$ctrl->getSelectAccounts(0,'Y',"","accounts_codeto");
$periodfrom=$ctrl->getSelectPeriod(0,'Y');
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
	<FORM name='frmIncome' method='POST' target="_blank" >
	<tr>
		<!--
		<Td class='head'>Account From</Td>
		<Td  class='odd'><input name='accounts_codefrom' value="$accounts_codefrom"></Td>
		<Td class='head'>Account To</Td>
		<Td class='odd'><input name='accounts_codeto' value="$accounts_codeto"></Td>-->

		<Td class='head'>Account From</Td>
		<Td  class='odd'>$accountsctrlfrom</Td>
		<Td class='head'>Account To</Td>
		<Td class='odd'>$accountsctrlto</Td>
		
	</tr>
<!--	<tr>
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
		<!--<Td class='head'>Period From</Td>
		<Td  class='odd'>$periodfrom</Td>-->
		<Td class='head'>Period</Td>
		<Td class='odd' colspan="3">$periodto</Td>
		
	</tr>

</tbody>
</table>
<INPUT type='reset' name='reset' value='Reset'><INPUT type='submit' name='submit' value='View'>

</FORM>

EOF;


	require(XOOPS_ROOT_PATH.'/footer.php');
}

?>


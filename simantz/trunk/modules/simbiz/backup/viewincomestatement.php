<?php
include_once('../../class/fpdf/fpdf.php');
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
	$this->Cell(26,7,"$this->datefrom",1,0,'C');
	$this->SetFont('Times','',10);
	$this->Cell(20,7,"Date To",1,0,'C');
	$this->SetFont('Times','B',10);
	$this->Cell(26,7,"$this->dateto" ,1,0,'C');

   
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


	$pdf->datefrom=$_POST['datefrom'];
	$pdf->dateto=$_POST['dateto'];
	$pdf->accounts_codefrom=getAccountsID($_POST['accounts_codefrom']);
	$pdf->accounts_codeto=getAccountsID($_POST['accounts_codeto']);
	
	if($pdf->datefrom=="")
		$pdf->datefrom="0000-00-00";
	if($pdf->dateto=="")
		$pdf->dateto="9999-12-31";

	if($pdf->accounts_codefrom=="")
		$pdf->accounts_codefrom="0000000";
	if($pdf->accounts_codeto=="")
		$pdf->accounts_codeto="9999999";
	
	$pdf->uid = $xoopsUser->getVar('uid');

	
	$wherestr	=	" where a.accounts_id = b.accounts_id and b.accountgroup_id = c.accountgroup_id 
				and c.accountclass_id = e.accountclass_id and a.batch_id = d.batch_id 
				and (d.batchdate between '$pdf->datefrom' AND '$pdf->dateto') AND 
				(b.accountcode_full between '$pdf->accounts_codefrom' AND '$pdf->accounts_codeto')
				and d.batch_id > 0 and b.accounts_id > 0 and d.iscomplete = 1 
				and b.organization_id = $defaultorganization_id 
				and c.organization_id = $defaultorganization_id 
				and d.organization_id = $defaultorganization_id 
				and b.placeholder = 0  
				 ";
//and d.isshow =1
				

	$groupby 	=	"group by b.accounts_id";
	
	// sales -> classtype = S, other sales -> classtype = S, cogs -> classtype = P
	// expenses -> classtype = X, other expenses -> classtype = X
	
	$sqlsales = 
				"select sum(a.amt) as total, b.accounts_name from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e 
				$wherestr 
				and e.classtype = 'S' 
				$groupby ";

	$sqlothersincome = 	
				"select sum(a.amt) as total, b.accounts_name from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e  				
				$wherestr 
				and e.classtype = 'I' 
				$groupby ";

	$sqlcogs = 	
				"select sum(a.amt) as total, b.accounts_name  from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e  				
				$wherestr 
				and e.classtype = 'C' 
				$groupby ";

	$sqlexpenses = 	
				"select sum(a.amt) as total, b.accounts_name from $tabletransaction a, 
				$tableaccounts b, $tableaccountgroup c, $tablebatch d, $tableaccountclass e  				
				$wherestr 
				and e.classtype = 'X' 
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
	$pdf->AddPage();
	//$pdf->SetDrawColor(210,210,210);

	//print content -->total width 190
	$pdf->SetXY(10,40);
	$pdf->SetFont('Arial','B',10); 
	//sales
 	$pdf->Cell(60,10,"(+) Sales  $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,"",0,0,'R');
	$pdf->Cell(95,10,"",0,1,'R');

	$pdf->SetFont('Arial','',10);
	
	$i=0;
	$totalsales = 0;
	while($row=$xoopsDB->fetchArray($querysales)){
	$i++;

	$totalsales += $row['total'];
	 
	$pdf->Cell(10,6,"",0,0,'L');
	$pdf->Cell(50,6,$row['accounts_name'],0,0,'L');
	$pdf->Cell(35,6,number_format($row['total'],2),0,0,'R');
	$pdf->Cell(95,6,"",0,1,'R');
	}

	//line 1
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(50,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');

	//sales total
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,number_format($totalsales, 2),0,0,'R');
	$pdf->Cell(95,10,number_format($totalsales, 2),0,1,'R');

	
	//COGS
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

	$totalcogs += $row['total']*-1;
	 
	$pdf->Cell(10,6,"",0,0,'L');
	$pdf->Cell(50,6,$row['accounts_name'],0,0,'L');
	$pdf->Cell(35,6,number_format($row['total']*-1,2),0,0,'R');
	$pdf->Cell(95,6,"",0,1,'R');
	}

	//line 1
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(50,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');

	//cogs total
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,number_format($totalcogs, 2),0,0,'R');
	$pdf->Cell(95,10,number_format($totalcogs, 2),0,1,'R');
	

	//Gross Profit
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(155,10,"     Gross Profit $cur_symbol",0,0,'L');
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(35,10,number_format(($totalsales-$totalcogs), 2),0,1,'R');

	//Others Income
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(190,6,"(+) Others Income $cur_symbol",0,1,'L');

	$pdf->SetFont('Arial','',10); 
	$i=0;
	$totalothersincome = 0;
	while($row=$xoopsDB->fetchArray($queryothersincome)){
	$i++;
	$totalothers = "0.00";
	
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
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(50,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');

	//others total
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,number_format($totalothersincome, 2),0,0,'R');
	$pdf->Cell(95,10,number_format(($totalsales+$totalothersincome-$totalcogs), 2),0,1,'R');

	//get variants detail
	//Expenses --> looping 

	//Expenses
	$pdf->SetFont('Arial','B',10); 
 	$pdf->Cell(60,10,"(-) Expenses  $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,"",0,0,'R');
	$pdf->Cell(95,10,"",0,1,'R');

	$pdf->SetFont('Arial','',10); 
	$i=0;
	$totalexpenses = 0;
	while($row=$xoopsDB->fetchArray($queryexpenses)){
	$i++;

	$expenses_name = $row['category_description'];
	
	//if($row['total'] > 0){//others
//	$totalexpenses = number_format($row['total'], 2);
	$totalexpenses += $row['total']*-1;
	//}

	//expenses
	$pdf->Cell(10,6,"",0,0,'L');
	$pdf->Cell(50,6,$row['accounts_name'],0,0,'L');
	$pdf->Cell(35,6,number_format($row['total']*-1,2),0,0,'R');
	$pdf->Cell(95,6,"",0,1,'R');
	}


	//line 4
	$pdf->Cell(10,0,"",0,0,'L');
	$pdf->Cell(50,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,0,'R');
	$pdf->Cell(95,0,"",0,1,'R');
	//expenses total
	$pdf->Cell(10,10,"",0,0,'L');
	$pdf->Cell(50,10,"Total $cur_symbol",0,0,'L');
	$pdf->Cell(35,10,number_format($totalexpenses, 2),0,0,'R');
	$pdf->Cell(95,10,number_format(($totalsales+$totalothersincome-$totalcogs-$totalexpenses), 2),0,1,'R');
	

	
	//line 5
	$pdf->Cell(155,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,1,'R');
	
	//Net Profit
	if(($totalsales+$totalothersincome-$totalcogs-$totalexpenses) >= 0 )
	$profitname = 'Net Profit';
	else
	$profitname = 'Net Loss';

	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(155,10,"$profitname $cur_symbol",0,0,'L');
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(35,10,number_format(($totalsales+$totalothersincome-$totalcogs-$totalexpenses), 2),0,1,'R');

	//line 6
	$pdf->Cell(155,0,"",0,0,'L');
	$pdf->Cell(35,0,"",1,1,'R');

	//$pdf->MultiCell(175,7,$sqlcogs,1,'C');
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
$accountsctrlfrom=$ctrl->getSelectAccounts(0,'Y',"","accounts_codefrom");
$accountsctrlto=$ctrl->getSelectAccounts(0,'Y',"","accounts_codeto");
$periodctrl=$ctrl->getSelectPeriod(0,'Y');
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
		<Td  class='odd'><input name='accounts_codefrom1' value="$accounts_codefrom"></Td>
		<Td class='head'>Account To</Td>
		<Td class='odd'><input name='accounts_codeto1' value="$accounts_codeto"></Td>-->
		
		<Td class='head'>Account From</Td>
		<Td  class='odd'>$accountsctrlfrom</Td>
		<Td class='head'>Account To</Td>
		<Td class='odd'>$accountsctrlto</Td>
		
	</tr>
	<tr>
		<Td class='head'>Date From</Td>
		<Td  class='odd'><input id='datefrom' name='datefrom' value="$datefrom">
				<input type='button' value='Date' onclick="$showDateFrom">
		</Td>
		<Td class='head'>Date To</Td>
		<Td class='odd'>
			<input id='dateto' name='dateto' value="$dateto" onclick="$showDateTo">
			<input type='button' value='Date' onclick="$showDateTo">
		</Td>
		
	</tr>

</tbody>
</table>
<INPUT type='reset' name='reset' value='Reset'><INPUT type='submit' name='submit' value='View'>

</FORM>

EOF;


	require(XOOPS_ROOT_PATH.'/footer.php');
}

?>


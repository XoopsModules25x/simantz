<?php
include_once('../../class/fpdf/fpdf.php');
include_once "system.php";



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  public $accounts_codefrom="Unknown";
  public $accounts_codeto="Unknown";
  public $datefrom="Unknown";
  public $dateto="Unknown";


function Header()
{
    $this->Image('./images/logo.jpg', 10 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Times','B',20);
	$this->SetXY(10,10);
    $this->Cell(0,17," ",1,0,'R');
   $this->Cell(0,17,"Trial Balance Report",1,0,'R');
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

$i=0;
	$header=array("No","Code","Account Name","Debit","Credit","Balance","Batch","Doc. No");
    $w=array(10,15,70,20,20,20,15,20);
   



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
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('courier','I',8);
	
    $this->Cell(0,4,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

function BasicTable($data)
{
    $w=array(10,15,70,20,20,20,15,20);

	$i=0;
  

$this->SetFont('Times','',9);
	$r=0;
   foreach($data as $row){
	$batch=0;
	$r++;
 	$i=0;
    	foreach($row as $col) {
		while($this->GetStringWidth($col)> $w[$i])
				$col=substr_replace($col,"",-1);
		
		if($i==0)
		$alignment="C";
		elseif($i<3)
		$alignment="L";
		else
		$alignment="R";

		$this->Cell($w[$i],6,$col,1,0,$alignment,0,$url);
            	$i=$i+1;
        }
        $this->Ln();
    }

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

  function getBpartner($accounts_id){
	global $xoopsDB,$defaultorganization_id,$tableaccounts,$tablebpartner;

	$retval = "";
	
	$sql = "select * from $tablebpartner where accounts_id = $accounts_id ";

	$query=$xoopsDB->query($sql);
	if($row=$xoopsDB->fetchArray($query)){
	$retval = $row['bpartner_name'];;
	}

	return $retval;
  }


if (isset($_POST["submit"])){

$wherestr="";



	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true ,17);

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


	$wherestr="(b.batchdate between '$pdf->datefrom' AND '$pdf->dateto') AND 
			(a.accountcode_full between '$pdf->accounts_codefrom' AND '$pdf->accounts_codeto')
			and b.batch_id>0 and a.accounts_id>0 and b.iscomplete=1 and b.organization_id=$defaultorganization_id ";
	
	

	$pdf->SetFont('Arial','',10);

	$sql="SELECT a.accounts_id, a.accountcode_full,a.accounts_name,g.accountgroup_name,t.amt, 
		b.batch_id,b.batchno,b.batch_name,t.reference_id,t.document_no FROM $tablebatch b 
		INNER JOIN $tabletransaction t on b.batch_id=t.batch_id
		INNER JOIN $tableaccounts a on a.accounts_id=t.accounts_id
		INNER JOIN $tableaccountgroup g on a.accountgroup_id=g.accountgroup_id
		WHERE $wherestr 
		order by b.batchdate,b.batchno,t.seqno,t.reference_id desc, a.accountcode_full,a.accounts_name";

	$query=$xoopsDB->query($sql);
	$data=array();
	$i=0;
	$totaldebit=0;
	$totalcredit=0;
	$balanceamt=0;
	while($row=$xoopsDB->fetchArray($query)){
	
		$accounts_id=$row['accounts_id'];
		$accountcode_full=$row['accountcode_full'];
		$accounts_name=$row['accounts_name'];
		$accountgroup_name=$row['accountgroup_name'];
		$batchdate=$row['batchdate'];
		$batchno=$row['batchno'];
		$document_no=$row['document_no'];
		$amt=$row['amt'];
		$debitamt="";
		$creditamt="";
		if($amt>0){
		$debitamt=$amt;
		$totaldebit=$totaldebit+$amt;
		}
		else{
		$creditamt=$amt*-1;
		$totalcredit=$totalcredit + $amt*-1; 
		}
		$balanceamt=number_format($totaldebit-$totalcredit,2);
		$i++;

		if(getBpartner($accounts_id) != "")
		$accounts_name .= " - ".getBpartner($accounts_id);

		$data[]=array($i,$accountcode_full,$accounts_name,number_format($debitamt,2),number_format($creditamt,2),$balanceamt,$batchno,$document_no);

	}
	$data[]=array("","","Total:",number_format($totaldebit,2),number_format($totalcredit,2),number_format($totaldebit-$totalcredit,2),"","");
	$pdf->AddPage();
	//$pdf->MultiCell(0,5,$sql,0,'C');

	$pdf->BasicTable($data);
	
	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output("Accounts.pdf","I");
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
	<FORM name='frmTrialBalance' method='POST' target="_blank" >
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


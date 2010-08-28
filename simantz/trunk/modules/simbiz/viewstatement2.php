<?php
include_once('fpdf/fpdf.php');
include_once "system.php";



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
  public $accounts_name="Unknown";
  public $accounts_code="Unknown";
  public $datefrom="Unknown";
  public $dateto="Unknown";


function Header()
{
    $this->Image('./images/logo.jpg', 10 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Times','B',20);
	$this->SetXY(10,10);
    $this->Cell(0,17," ",1,0,'R');
   $this->Cell(0,17,"Account Transaction Report",1,0,'R');
  //  $this->Cell(0,17,"$this->tuitionclass_code",1,0,'R');



    $this->Ln(20);
    $this->SetFont('Arial','B',12);
    $this->Cell(25,7,"Account",1,0,'L');
    $this->Cell(73,7,"$this->accounts_code - $this->accounts_name",1,0,'C');

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
	$header=array("No","Date","Batch No","Batch Name","Doc No","Doc No 2","Debit","Credit");
    $w=array(10,20,20,50,30,20,20,20);
   



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
    $w=array(10,20,20,50,30,20,20,20);

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
		if($i==0){
			//update link id
			$batch_id=$col;
			//Display accending number, when reach last line, don't show number
			if($col!=""){
				$col=$r;
				$url="batch.php?action=edit&batch_id=$batch_id";
				}
			else
				$url="";
		}
		if($i==3)
		$alignment="L";
		elseif($i>5)
		$alignment="R";
		else
		$alignment="C";

		$this->Cell($w[$i],6,$col,1,0,$alignment,0,$url);
            	$i=$i+1;
        }
        $this->Ln();
    }

}
}



if (isset($_POST["bpartner_id"])){

$wherestr="";

	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true ,17);

$bpartner_id=$_POST["bpartner_id"];

$datefrom=$_POST['datefrom'];
$dateto=$_POST['dateto'];

	if($datefrom=="")
		$pdf->datefrom="0000-00-00";
	else
		$pdf->datefrom=$datefrom;

	if($dateto=="")
		$pdf->dateto="9999-12-31";
	else
		$pdf->dateto=$dateto;

	$wherestr=	"bp.bpartner_id=$bpartner_id and bp.bpartner_id>0 and b.batch_id>0 
			and b.batchdate between '$pdf->datefrom' AND '$pdf->dateto' and b.isshow = 1 ";
	

	$pdf->SetFont('Arial','',10);

	$sql="SELECT bp.accounts_id, a.accounts_code,a.accounts_name,b.batchdate,b.batchno,b.batch_name,b.iscomplete,
			t.amt,t.document_no,t.document_no2,b.batch_id,bp.bpartner_name,bp.bpartner_id
		FROM $tablebatch b
		INNER JOIN $tabletransaction t on b.batch_id=t.batch_id
		INNER JOIN $tableaccounts a on a.accounts_id=t.accounts_id
		INNER JOIN $tablebpartner bp on bp.accounts_id=a.accounts_id
		WHERE $wherestr order by b.batchdate,t.batch_id,t.seqno";
	$query=$xoopsDB->query($sql);
	$data=array();
	$i=0;
	$totaldebit=0;
	$totalcredit=0;

	while($row=$xoopsDB->fetchArray($query)){
	
		$pdf->accounts_code=$row['accounts_code'];
		$pdf->accounts_name=$row['accounts_name'];
		$batchdate=$row['batchdate'];
		$amt=$row['amt'];
		$document_no=$row['document_no'];
		$document_no2=$row['document_no2'];
		$batchno=$row['batchno'];
		$batchname=$row['batchname'];
		$iscomplete=$row['iscomplete'];
		if($iscomplete==1)
			$iscomplete='C';
		else
			$iscomplete='D';
		$debitamt="";
		$creditamt="";
		$batch_id=$row['batch_id'];
		if($amt>0){
		$debitamt=$amt;
		$totaldebit=$totaldebit+$amt;
		}
		else{
		$creditamt=$amt*-1;
		$totalcredit=$totalcredit + $amt*-1; 
		}
		$i++;
		$data[]=array($batch_id,$batchdate,$batchno."/".$iscomplete,$batchname,$document_no,$document_no2,number_format($debitamt,2),number_format($creditamt,2));

	}
	$data[]=array("","","","Total:","","",number_format($totaldebit,2),number_format($totalcredit,2));

	$pdf->AddPage();
//	$pdf->MultiCell(0,5,$sql,0,'C');
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
include_once "datepicker/class.datepicker.php";
$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$ctrl= new SelectCtrl();
$bpartnerctrl=$ctrl->getSelectBPartner(0,'N');
$showDateFrom=$dp->show("datefrom");
$showDateTo=$dp->show("dateto");

$datefrom = getMonth(date("Ymd", time()),0) ;
$dateto = getMonth(date("Ymd", time()),1) ;
echo <<< EOF
<table border='1'>
<tbody>
<tr><TH colspan='4' style='text-align: center'>Criterial</TH></tr>
	<tr><FORM name='frmViewTransaction' method='POST' target="_blank">
		<Td class='head'>Business Partner</Td>
		<Td  class='odd'>$bpartnerctrl</Td>
		<Td class='head'></Td>
		<Td class='odd'></Td>
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


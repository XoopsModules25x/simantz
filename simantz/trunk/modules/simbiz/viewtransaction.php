<?php
include_once('../simantz/class/fpdf/fpdf.php');
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
    $this->Cell(73,7,"$this->accountcode_full - $this->accounts_name",1,0,'C');

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
	$header=array("No","Date","Batch No","Batch Name","Doc No","Cheque No","Status","Debit","Credit");
    $w=array(10,18,18,50,25,18,12,20,20);
   



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
    $w=array(10,18,18,50,25,18,12,20,20);

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
		elseif($i>6)
		$alignment="R";
		else
		$alignment="C";

		$this->Cell($w[$i],5,$col,"TB",0,$alignment,0,$url);
            	$i=$i+1;
        }
        $this->Ln();
    }

}
}



if (isset($_POST["accounts_id"]) ){

$wherestr="";

	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true ,17);

$accounts_id=$_POST["accounts_id"];
$docstatus=$_POST['docstatus'];
$pdf->datefrom=$_POST['datefrom'];
$pdf->dateto=$_POST['dateto'];


	if($period_id>0)
		$wherestr=" b.period_id=$period_id ";
	else
	{
	if($pdf->datefrom=="")
		$pdf->datefrom="0000-00-00";
	
	if($pdf->dateto=="")
		$pdf->dateto="9999-12-31";

	$wherestr=" b.batchdate between '$pdf->datefrom' AND '$pdf->dateto' ";
	
	}

	if($accounts_id > 0)
	$wherestr .= " and t.accounts_id=$accounts_id";

	if($docstatus!="")
	$wherestr .= " and b.iscomplete=$docstatus";

	$pdf->SetFont('Arial','',10);

	$sql="SELECT a.accounts_id, a.accountcode_full,a.accounts_name,b.batchdate,b.batchno,b.batch_name,b.iscomplete,
			t.amt,t.document_no,t.document_no2,b.batch_id
		FROM $tablebatch b 
		INNER JOIN $tabletransaction t on b.batch_id=t.batch_id
		INNER JOIN $tableaccounts a on a.accounts_id=t.accounts_id
		WHERE $wherestr order by b.batchdate,t.batch_id,t.seqno";
	$query=$xoopsDB->query($sql);
	$data=array();
	$i=0;
	$totaldebit=0;
	$totalcredit=0;

	while($row=$xoopsDB->fetchArray($query)){
	
		$pdf->accountcode_full=$row['accountcode_full'];
		$pdf->accounts_name=$row['accounts_name'];
		$batchdate=$row['batchdate'];
		$amt=$row['amt'];
		$document_no=$row['document_no'];
		$document_no2=$row['document_no2'];
		$batchno=$row['batchno'];
		$batchname=$row['batch_name'];
		$iscomplete=$row['iscomplete'];
		if($iscomplete==1)
			$iscomplete='Complete';
		elseif($iscomplete==0)
			$iscomplete='Draft';
		else
			$iscomplete='Reversed';
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
		$data[]=array($batch_id,$batchdate,$batchno,$batchname,$document_no,$document_no2,$iscomplete,
				number_format($debitamt,2),number_format($creditamt,2));

	}
	$data[]=array("","","","Total:","","","",number_format($totaldebit,2),number_format($totalcredit,2));
	
	if($accounts_id < 1){
	$pdf->accountcode_full="";
	$pdf->accounts_name="";
	}

	$pdf->AddPage();
	$pdf->BasicTable($data);

	//$pdf->MultiCell(0,5,$sql,1,'C');	
	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output("viewtransaction.pdf","I");
	exit (1);

}
else {
include_once "menu.php";


include_once "../simantz/class/datepicker/class.datepicker.php";
$dp=new datepicker($url);
$dp->dateFormat='Y-m-d';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$ctrl= new SelectCtrl();
if(isset($_GET["accounts_id"]))
$accounts_id=$_GET["accounts_id"];
else
$accounts_id=0;
$accountsctrl=$simbizctrl->getSelectAccounts($accounts_id,'Y');
$periodctrl=$simbizctrl->getSelectPeriod(0,'Y');
$showDateFrom=$dp->show("datefrom");
$showDateTo=$dp->show("dateto");

$datefrom = getMonth(date("Ymd", time()),0) ;
$dateto = getMonth(date("Ymd", time()),1) ;
echo <<< EOF
<table border='1'>
<tbody>
<tr><TH colspan='4' style='text-align: center'>Criterial</TH></tr>
	<tr><FORM name='frmViewTransaction' method='POST' target="_blank">
		<Td class='head'>Accounts</Td>
		<Td  class='odd' >$accountsctrl</Td>
		<Td class='head'>Status</Td>
		<Td class='odd'><SELECT name='docstatus'>
				 <option value="">Null</option>
				 <option value="1">Completed</option>
				 <option value="0">Draft</option>
				 <option value="-1">Reversed</option>
				</SELECT></Td>
	</tr>
	<tr>
		<Td class='head'>Date From</Td>
		<Td  class='even'><input id='datefrom' name='datefrom' value="$datefrom">
				<input type='button' value='Date' onclick="$showDateFrom">
		</Td>
		<Td class='head'>Date To</Td>
		<Td class='even'>
			<input id='dateto' name='dateto' value="$dateto">
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


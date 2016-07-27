<?php
include_once('../simantz/class/fpdf/fpdf.php');
include_once "system.php";
$org = new Organization();


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class PDF extends FPDF
{
  public $accounts_name="Unknown";
  public $accounts_code="Unknown";
  public $datefrom="Unknown";
  public $dateto="Unknown";


function getTrackName($track_id1){
    global $xoopsDB;

        $sql = sprintf("SELECT * FROM sim_simbiz_track WHERE track_id = '%d' ",$track_id1);
        $query=$xoopsDB->query($sql);
        $retval = "-";
	while($row=$xoopsDB->fetchArray($query)){
        $retval = $row['track_name'];
        }

        return $retval;

}

function Header()
{
    global $organization_code,$track_id1,$track_id2,$track_id3,$track1_name,$track2_name,$track3_name;
    $this->Image('./images/logo.jpg', 10 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();

        /* start tracking name */
        $track_1 = "";
        $track_2 = "";
        $track_3 = "";
        $yPos = 10;
        if($track_id1 > 0){
        $track_1 = "$track1_name : ".$this->getTrackName($track_id1);
        $yPos=$yPos+4;
        $this->SetFont('Times','',8);
        $this->SetXY(10,$yPos);
	$this->Cell(100,5,"$track_1",0,0,'L');
        }if($track_id2 > 0){
        $track_2 = "$track2_name : ".$this->getTrackName($track_id2);
        $yPos=$yPos+4;
        $this->SetFont('Times','',8);
        $this->SetXY(10,$yPos);
	$this->Cell(100,5,"$track_2",0,0,'L');
        }if($track_id3 > 0){
        $track_3 = "$track3_name : ".$this->getTrackName($track_id3);
        $yPos=$yPos+4;
        $this->SetFont('Times','',8);
        $this->SetXY(10,$yPos);
	$this->Cell(100,5,"$track_3",0,0,'L');
        }
        /* end */

        /* set organization text */
        $this->SetFont('Times','',8);
        $this->SetXY(10,10);
	$this->Cell(100,5,"Organization : $organization_code",0,0,'L');
        /* end */

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

        $organization_id=$_REQUEST['organization_id'];

	$org->fetchOrganization($organization_id);
	$companyno=$org->companyno;
	$orgname=$org->organization_name;
        $organization_code=$org->organization_code;

        $track_id1=$_REQUEST['track_id1'];
        $track_id2=$_REQUEST['track_id2'];
        $track_id3=$_REQUEST['track_id3'];

        $wheretrack = "";
        if($track_id1 > 0){
        $wheretrack .= " AND t.track_id1 = $track_id1 ";
        }if($track_id2 > 0){
        $wheretrack .= " AND t.track_id2 = $track_id2 ";
        }if($track_id3 > 0){
        $wheretrack .= " AND t.track_id3 = $track_id3 ";
        }

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
			t.amt,t.document_no,t.document_no2,b.batch_id,b.track1_name,b.track2_name,b.track3_name
		FROM $tablebatch b
		INNER JOIN $tabletransaction t on b.batch_id=t.batch_id and t.branch_id = $organization_id
		INNER JOIN $tableaccounts a on a.accounts_id=t.accounts_id
		WHERE $wherestr $wheretrack order by b.batchdate,t.batch_id,t.seqno";
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

                $track1_name=$row['track1_name'];
                $track2_name=$row['track2_name'];
                $track3_name=$row['track3_name'];

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

$uid = $xoopsUser->getVar('uid');
$orgctrl=$ctrl->selectionOrg($uid,$defaultorganization_id,'N',"",'N');

$track1ctrl=$ctrl->getSelectTracking(0,"Y"," AND trackheader_id = 1 ");
$track2ctrl=$ctrl->getSelectTracking(0,"Y"," AND trackheader_id = 2 ");
$track3ctrl=$ctrl->getSelectTracking(0,"Y"," AND trackheader_id = 3 ");

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

		<tr>
			<td class='head' style="vertical-align:top">Organization</td><td class='even' style="vertical-align:top">$orgctrl</td>

			<td class='head' style="vertical-align:top">Track</td>
                        <td class='even'>
                            Track 1 : <select name="track_id1">$track1ctrl</select><br/>
                            Track 2 : <select name="track_id2">$track2ctrl</select><br/>
                            Track 3 : <select name="track_id3">$track3ctrl</select><br/>
                        </td>
		</tr>

</tbody>
</table>
<INPUT type='reset' name='reset' value='Reset'><INPUT type='submit' name='submit' value='View'>

</FORM>

EOF;
	require(XOOPS_ROOT_PATH.'/footer.php');
}
?>


<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once "../simantz/class/tcpdf/config/lang/eng.php";
include_once "../simantz/class/tcpdf/tcpdf.php";
include_once "system.php";
//include_once "../system/class/Organization.php";
include_once "../hes/class/Student.php";
include_once "../hes/class/Semester.php";
include_once "../hea/class/Course.php";
//include_once "../system/class/Employee.php";

	$org = new Organization();
	$bp = new Student();
    $sm = new Semester();
    $cr= new Course();
	//$emp = new Employee();

	$widthheader = array("30","380","100");

// Extend the TCPDF class to create custom Header and Footer
class OnemoretakePDF extends TCPDF {

    public function Header() {
	global $defaultorganization_id,$org,$bp,$invoiceprefix,$widthheader,$sm,$cr;

	$org->fetchOrganization($defaultorganization_id);


        $tbl = '
	<table border="0">
	<tr align="left">
	<td width="90" rowspan="4">
	<img src="../../images/logo.jpg" border="0" height="51" width="70" align="bottom" />
	</td>
	<td width="410"><font size="14"><b>'.$org->organization_name.' ('.$org->companyno.')</b></font></td>
	</tr>
	<tr align="left">
	<td width="410">'.$org->street1.' '.$org->street2.','.$org->postcode.'  '.$org->city.' '.$org->state.' '.$org->country_name.'</td>
	</tr>
	<tr align="left">
	<td width="410">Tel: '.$org->tel_1.'/'.$org->tel_2.' Fax: '.$org->fax.'</td>
	</tr>
	<tr align="left">
	<td width="410">Website: '.$org->url.'</td>
	</tr>
	</table>';
	
	$title = "RESIT RASMI";


	$tbl .= '
	<table border="0">
	<tr>
	<td colspan="4" align="right" height="15"><font size="12"><b><u>'.$title.'</u></b></font></td>
	</tr>
	<tr height="100" height="10">
	<td width="350" height="12" rowspan="7">
    <table>
    <tr>
    <td width="70" height="20">NAMA</td>
    <td width="5">:</td>
    <td width="275">'.$bp->student_name.'</td>
    </tr>
    <tr>
    <td width="70" height="20">NO MATRIK</td>
    <td width="5">:</td>
    <td width="275">'.$bp->student_no.'</td>
    </tr>
    <tr>
    <td width="70" height="20">NO IC.</td>
    <td width="5">:</td>
    <td width="275">'.$bp->student_newicno.'</td>
    </tr>

    <tr>
    <td width="70" height="20">PROGRAM</td>
    <td width="5">:</td>
    <td width="275">'.$cr->course_name.'</td>
    </tr>

    </table>
    </td>

	<td width="50" height="12">No</td>
	<td width="15" height="12">:</td>
	<td width="95" height="12">'.$this->studentpayment_no.'</td>
	</tr>
	<tr height="100">

	<td width="50" height="12"></td>
	<td width="15" height="12"></td>
	<td width="95" height="12"></td>
	</tr>
	<tr height="100">

	<td width="50" height="12">Tarikh</td>
	<td width="15" height="12">:</td>
	<td width="95" height="12">'.$this->studentpayment_date.'</td>
	</tr>
	<tr height="100">

	<td width="50" height="12"></td>
	<td width="15" height="12"></td>
	<td width="95" height="12"></td>
	</tr>
	<tr height="100">

	<td width="50" height="12">Bayaran</td>
	<td width="15" height="12">:</td>
	<td width="95" height="12">'.$this->payment_method.'</td>
	</tr>
	<tr height="100">

	<td width="50" height="5"></td>
	<td width="15" height="5"></td>
	<td width="95" height="5"></td>
	</tr>
	</table>';

	$tbl .= '
	<br/>
	<table border="1">
	<tr>
	<td width="'.$widthheader[0].'" height="20" align="center"><b>No</b></td>
	<td width="'.$widthheader[1].'" height="20" align="center"><b>Butiran</b></td>
	<td width="'.$widthheader[2].'" height="20" align="center"><b>Amaun (RM)</b></td>
	</tr>
	
	</table>';

	
	$this->SetFont('times', '', 12);
	$this->writeHTML($tbl, false, false, false, false, '');
	
    }
 
    // Page footer
    public function Footer() {
	global $widthheader;

	$filename = "upload/employee/".$this->filename;

	$signature="";
	if(file_exists($filename) && $this->filename != "")
	$signature = '<img src="'.$filename.'" border="0" height="50" width="50" align="bottom" />';

	//$this->invoice_preparedby = str_replace("\n","<br/>",$this->invoice_preparedby);
	$this->invoice_preparedby = str_replace( array("\r\n", "\n","\r"), "<br/>", $this->invoice_preparedby );
	$this->invoice_preparedby = str_replace( " ", "&nbsp;", $this->invoice_preparedby );

     $tbl = '
	<table border="0">
	<tr align="left">
	<td awidth="330">Diterima oleh,</td>
	</tr>
	<tr align="left">
	<td awidth="330" height="40"></td>
	</tr>
	<tr align="left">
	<td awidth="180">Nama :<br/>No i.c :</td>
	</tr>
	</table>';
        

	$tbl2 = '
	<table border="1">
	<tr>
	<td width="'.$widthheader[0].'" height="380" align="center"></td>
	<td width="'.$widthheader[1].'" height="380" align="center"></td>
	<td width="'.$widthheader[2].'" height="380" align="center"></td>
	</tr>
	
	</table>';

	if($this->totalprint==false){
	$tbl2 .= '
	<table border="1">
	<tr>
	<td width="30" height="16" align="center"></td>
	<td width="380" height="16" align="left" colspan="3"><b>JUMLAH KESELURUHAN (RM)</b></td>
	<td width="100" height="16" align="right">'.$this->total_amt.'</td>
	</tr>
	</table>';

//	$this->invoice_remarks = str_replace("\n","<br/>",$this->invoice_remarks);
	$this->invoice_remarks = str_replace( array("\r\n", "\n","\r"), "<br/>", $this->invoice_remarks );
	$this->invoice_remarks = str_replace( " ", "&nbsp;", $this->invoice_remarks );

	if($this->invoice_remarks != ""){

	$tbl2 .= '
	<table border="1">
	<tr>
	<tr>
	<td><font size="10">'.$this->invoice_remarks.'</font></td>
	</tr>
	</table>';
	}

	}else{
	$tbl2 .= '
	<table border="1">
	<tr>
	<td width="30" height="16" align="center"></td>
	<td width="380" height="16" align="right" colspan="3"><b></b></td>
	<td width="100" height="16" align="right"></td>
	</tr>
	</table>';

	$tbl2 .= '
	<table border="1">
	<tr>
	<tr>
	<td><font size="10">Continue Next Page >></font></td>
	</tr>
	<tr>
	<td><font size="10></font></td>
	</tr>
	</table>';
	
	}


	$this->SetFont('times', '', 12);
	$this->setY(245);
	$this->writeHTML($tbl, true, false, false, false, '');
	$this->setY(84);
	$this->writeHTML($tbl2, true, false, false, false, '');
    
	//$this->setXY(0,150);
	$this->Line(15, 265, 55, 265);
	//$this->Line(130, 265, 180, 265);

	
    }



}
 


//$pdf = new OnemoretakePDF (PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
$pdf = new OnemoretakePDF ('P', 'mm', 'A4', true);
// set document information

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 85, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 80);

	

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

if($_POST || $_GET){



$isselect = $_POST['isselect'];

if(isset($_POST['studentpayment_id']))
$studentpayment_id = $_POST['studentpayment_id'];
else
$studentpayment_id = $_GET['studentpayment_id'];
//echo count($studentpayment_id);die;

if(!is_array($studentpayment_id)){
$studentpayment_id = array("1"=>$studentpayment_id);
$isselect = array("1"=>"on");

}

$k = 0;
foreach($studentpayment_id as $id){
$k++;

if($isselect[$k] == "on"){
$pdf->totalprint = false;

$sql = "select si.student_id,si.studentpayment_no,si.studentpayment_date,si.total_amt,
    si.description,sl.studentpayment_lineamt,si.studentpayment_type,
    sl.line_desc,sl.studentpayment_item
	from $tablestudentpayment si
    left join $tablestudentpaymentline sl on sl.studentpayment_id = si.studentpayment_id
    inner join $tablestudent st on st.student_id = si.student_id
    inner join $tablecourse cr on cr.course_id = st.course_id
	where si.studentpayment_id = $id ";

$query=$xoopsDB->query($sql);

$data = "";
$tabledata='<table border="0" acellspacing="0">';
$i=0;
while ($row=$xoopsDB->fetchArray($query)){
$i++;

$pdf->student_id = $row['student_id'];
$pdf->studentpayment_no = $row['studentpayment_no'];
$pdf->studentpayment_date = $row['studentpayment_date'];
$pdf->total_amt = $row['total_amt'];
$pdf->invoice_remarks = $row['description'];
$pdf->semester_id = $row['semester_id'];
$pdf->studentpayment_type = $row['studentpayment_type'];

if($pdf->studentpayment_type == "Q")
$pdf->payment_method = "Cek";
else
$pdf->payment_method = "Tunai";

$row['studentpayment_qty'] = (int)$row['studentpayment_qty'];
$row['studentpayment_uprice'] = number_format($row['studentpayment_uprice'],3,".",",");
$row['studentpayment_lineamt'] = number_format($row['studentpayment_lineamt'],2,".",",");
$pdf->total_amt = number_format($pdf->total_amt,2,".",",");

//$discount_amt = "1568686.50";


$linedesc = str_replace( array("\r\n", "\n","\r"), "<br/>", $row['line_desc'] );
$linedesc = str_replace( " ", "&nbsp;", $linedesc );

$brpage = "";
if($linedesc != "")
$brpage = "<br/>";

//$ij = 0;
//while($ij<10){
//$ij++;
$tabledata .= '<tr>';
$tabledata .= '<td width="'.$widthheader[0].'" align="center" height="20">'.$i.'.</td>';
$tabledata .= '<td width="'.$widthheader[1].'"><b>'.$row['studentpayment_item'].'</b>'.$brpage.''.$linedesc.'</td>';
//$tabledata .= '<td width="'.$widthheader[4].'" align="right">'.$discount_amt.'</td>';
$tabledata .= '<td width="'.$widthheader[2].'" align="right">'.$row['studentpayment_lineamt'].'</td>';
$tabledata .= '</tr>';
//}

//$data = array($i,$row['item_name'],$row['linedesc'],$row['line_qty'],$row['unitprice'],$row['line_amt']);
}

$tabledata .= '</table>';

	// set font
	$pdf->SetFont('times', '', 10);

	$bp->fetchStudent($pdf->student_id);
    $sm->fetchSemester($pdf->semester_id);
    $cr->fetchCourse($bp->course_id);
	// add a page
	$pdf->AddPage();
    $pdf->totalprint = true;
    
	$pdf->setY(85);
	$pdf->SetFont('times', '', 12);
	$pdf->writeHTML($tabledata, true, false, false, false, '');
	//$pdf->writeHTMLCell(0, 0, 0, 0, $tabledata,0, 0, 0, true,'',true);
    $pdf->totalprint = false;
    //$pdf->footerPrint();
	
}
}
	/*
	$tbl = '
	<table border="1">
	<tr>
	<td width="30" height="16" align="center"></td>
	<td width="400" height="16" align="right" colspan="3"><b>Total Amount</b></td>
	<td width="80" height="16" align="right">'.$pdf->invoice_totalamt.'</td>
	</tr>
	
	</table>';*/

	//$pdf->setY(208);
	//$pdf->SetFont('times', '', 12);
	//$pdf->writeHTML($tbl, true, false, false, false, '');



//	$pdf->MultiCell(0,5,$linedesc,1,'C');

//$pdf->writeHTML($tbl, true, false, false, false, '');
//$pdf->Image('../images/image_demo.jpg', 40, 50, 100, 150, '', 'http://www.tcpdf.org', '', true, 150); 

// -----------------------------------------------------------------------------
}

//Close and output PDF document
$pdf->Output('receipt.pdf', 'I');
 
?>
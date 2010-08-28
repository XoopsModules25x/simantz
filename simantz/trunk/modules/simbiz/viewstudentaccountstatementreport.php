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

	$widthheader = array("65","55","195","65","65","65");

// Extend the TCPDF class to create custom Header and Footer
class OnemoretakePDF extends TCPDF {

    public function Header() {
	global $defaultorganization_id,$org,$bp,$invoiceprefix,$widthheader,$sm,$cr;
    $current_date= date("Y-m-d", time()) ;
    
	$org->fetchOrganization($defaultorganization_id);

    if($bp->student_nameinit != $bp->student_name){
    $this->page_no = 1;
    $bp->student_nameinit = $bp->student_name;
    }else{
    $this->page_no++;
    }


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
	
	$title = "STATEMENT OF ACCOUNT";

    

	$tbl .= '
	<table border="0">
	<tr>
	<td colspan="4" align="center" height="15"><font size="12"><b><u>'.$title.'</u></b></font></td>
	</tr>
	<tr height="100" height="10">
	<td width="350" height="12" rowspan="7">
    <table>
    <tr>
    <td awidth="70" height="20" colspan="3">'.$bp->student_name.'</td>
    </tr>
    <tr>
    <td awidth="70" height="20" colspan="3">'.
    $bp->student_address
    .'</td>
    </tr>

    <tr>
    <td awidth="70" height="20" colspan="3">'.$cr->course_name.'</td>
    </tr>

    </table>
    </td>

	<td width="60" height="12">Matrix No</td>
	<td width="10" height="12">:</td>
	<td width="90" height="12">'.$bp->student_no.'</td>
	</tr>
	<tr height="100">

	<td width="60" height="12">IC No</td>
	<td width="10" height="12">:</td>
	<td width="90" height="12">'.$bp->student_newicno.'</td>
	</tr>
	<tr height="100">

	<td width="60" height="12"></td>
	<td width="10" height="12"></td>
	<td width="90" height="12"></td>
	</tr>
    <tr height="100">

	<td width="60" height="12">Date</td>
	<td width="10" height="12">:</td>
	<td width="90" height="12">'.$current_date.'</td>
	</tr>
	<tr height="100">

	<td width="60" height="12"></td>
	<td width="10" height="12"></td>
	<td width="90" height="12"></td>
	</tr>
	<tr height="100">
	<td width="60" height="5">Page</td>
	<td width="10" height="5">:</td>
	<td width="90" height="5">'.$this->page_no .'</td>
	</tr>
	<tr height="100">
	<td width="60" height="5"></td>
	<td width="10" height="5"></td>
	<td width="90" height="5"></td>
	</tr>
	</table>';

	$tbl .= '
	<br/>
	<table border="1">
	<tr>
	<td width="'.$widthheader[0].'" height="20" align="center"><b>Date</b></td>
	<td width="'.$widthheader[1].'" height="20" align="center"><b>Ref No</b></td>
	<td width="'.$widthheader[2].'" height="20" align="center"><b>Description</b></td>
	<td width="'.$widthheader[3].'" height="20" align="center"><b>Debit</b></td>
	<td width="'.$widthheader[4].'" height="20" align="center"><b>Credit</b></td>
	<td width="'.$widthheader[5].'" height="20" align="center"><b>Balance</b></td>
	</tr>
	
	</table>';

	
	$this->SetFont('times', '', 12);
	$this->writeHTML($tbl, false, false, false, false, '');
	
    }
 
    // Page footer
    public function Footer() {
	global $widthheader,$xoopsDB,$tablesemester;

    
    
	$filename = "upload/employee/".$this->filename;

	$signature="";
	//if(file_exists($filename) && $this->filename != "")
	//$signature = '<img src="'.$filename.'" border="0" height="50" width="50" align="bottom" />';

	//$this->invoice_preparedby = str_replace("\n","<br/>",$this->invoice_preparedby);
	//$this->invoice_preparedby = str_replace( array("\r\n", "\n","\r"), "<br/>", $this->invoice_preparedby );
	//$this->invoice_preparedby = str_replace( " ", "&nbsp;", $this->invoice_preparedby );

    /*
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
     * 
     */
        

	$tbl2 = '
	<table border="1">
	<tr>
	<td width="'.$widthheader[0].'" height="450" align="center"></td>
	<td width="'.$widthheader[1].'" height="450" align="center"></td>
	<td width="'.$widthheader[2].'" height="450" align="center"></td>
	<td width="'.$widthheader[3].'" height="450" align="center"></td>
	<td width="'.$widthheader[4].'" height="450" align="center"></td>
	<td width="'.$widthheader[5].'" height="450" align="center"></td>
	</tr>
	
	</table>';

    
	if($this->totalprint==false){

    $this->footter_loop++;
	$tbl2 .= '
	<table border="1">
	<tr>
	<td width="445" height="16" align="left" colspan="4"><b>BAKI YANG PERLU DIJELASKAN (RM)</b></td>
	<td width="65" height="16" align="right">'.$this->balance_linefooter[$this->footter_loop].'</td>
	</tr>
	</table>';



    $tbl2 .='
    <table border="1">';
            
    $sqlsem = "select * from $tablesemester where isactive = 1";

    $querysem=$xoopsDB->query($sqlsem);

    $i = 0;
    while ($rowsem=$xoopsDB->fetchArray($querysem)){
        $i++;

        $semester_id = $rowsem['semester_id'];
        $semInfo = $this->getSemesterInfo($semester_id);

        $sem_name = $semInfo['sem_name'];
        $total_amount = number_format($semInfo['total_amount'],2);

        if($i>6){
        $i=1;
        }

        if($i == 1){
        $tbl2 .='<tr>';
        }


        $tbl2 .='<td align="center">'.$sem_name.'<br/>'.$total_amount.'</td>';

        if($i == 6){
        $tbl2 .='</tr>';
        }


    }

    $tbl2 .='</table>';

    /*
    $tbl2 .='
    <table border="1">
    <tr>
    <td align="center"><br/>0.00</td>
    <td align="center"><br/>0.00</td>
    <td align="center"><br/>0.00</td>
    <td align="center"><br/>0.00</td>
    <td align="center"><br/>0.00</td>
    <td align="center">'.$this->getSemesterInfo(1,"semester_name").'<br/>'.$this->getSemesterInfo(1,"amount").'</td>
    </tr>
    <tr>
    <td align="center"><br/>0.00</td>
    <td align="center"><br/>0.00</td>
    <td align="center"><br/>0.00</td>
    <td align="center"><br/>0.00</td>
    <td align="center"><br/>0.00</td>
    <td align="center"><br/>0.00</td>
    </tr>
    </table>
    ';
     * 
     */

    /*
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
     * 
     */

	}else{
	$tbl2 .= '
	<table border="1">
	<tr>
	<td width="445" height="16" align="center"></td>
	<td width="65" height="16" align="right" colspan="3"><b></b></td>
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
	$this->setY(89);
	$this->writeHTML($tbl2, true, false, false, false, '');
    
	//$this->setXY(0,150);
	//$this->Line(15, 265, 55, 265);
	//$this->Line(130, 265, 180, 265);

	
    }

    function getSemesterInfo($semester){
        global $xoopsDB,$tablestudentinvoice,$tablestudentpayment,$tablestudentinvoiceline,$tablestudentpaymentline;

        $sqlpayment = "select sp.total_amt
        from $tablestudentpayment sp
        inner join $tablestudentpaymentline pl on sp.studentpayment_id = pl.studentpayment_id
        inner join $tablestudentinvoiceline il on pl.studentinvoiceline_id = il.studentinvoiceline_id
        inner join $tablestudentinvoice si on il.studentinvoice_id = si.studentinvoice_id 
        where sp.student_id = $this->student_id
        and sp.iscomplete = 1
        and si.studentinvoice_id = st.studentinvoice_id";
        
        $sql = "select
        (st.total_amt - coalesce(($sqlpayment),0)) as total_balance
        from $tablestudentinvoice st
        where st.student_id = $this->student_id
        and st.iscomplete = 1
        and st.semester_id = $semester ";

        $query=$xoopsDB->query($sql);

        $total_amount = 0;
        if ($row=$xoopsDB->fetchArray($query)){
            $total_amount = $row['total_balance'];
        }
            $sem_name = "Semester $semester";

        return array("sem_name"=>"$sem_name","total_amount"=>$total_amount);
    }


}
 


//$pdf = new OnemoretakePDF (PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
$pdf = new OnemoretakePDF ('P', 'mm', 'A4', true);
// set document information

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 89, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 50);

	

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------
$pdf->xoopsDB = $xoopsDB;

if($_POST || $_GET){

$pdf->footter_loop = 0;

$isselected = $_POST['isselected'];

if(isset($_POST['student_id']))
$student_id = $_POST['student_id'];
else
$student_id = $_GET['student_id'];
//echo count($studentinvoice_id);die;

if(!is_array($student_id)){
$student_id = array("1"=>$student_id);
$isselected = array("1"=>"on");

}

$k = 0;
$jk=0;
foreach($student_id as $id){
$k++;

if($isselected[$k] == "on"){
$pdf->totalprint = false;
$jk++;

$sqlinvoice = "select
si.student_id as student_id,
si.studentinvoice_date as line_date,
si.studentinvoice_no as line_refno,
sum(sl.studentinvoice_lineamt) as total_creditline,
'' as total_debitline,
ac.accounts_name as line_description,
'sales' as line_type,
'' as cheque_no
from $tablestudentinvoice si
left join $tablestudentinvoiceline sl on sl.studentinvoice_id = si.studentinvoice_id
left join $tableaccounts ac on ac.accounts_id = sl.accounts_id
where si.iscomplete = 1
and si.student_id = $id
group by sl.accounts_id";

$sqlpayment = "select
si.student_id as student_id,
si.studentpayment_date as line_date,
si.studentpayment_no as line_refno,
'' as total_creditline,
sum(si.total_amt) as total_debitline,
si.studentpayment_type as line_description,
'payment' as line_type,
si.studentpayment_chequeno as cheque_no
from $tablestudentpayment si
where si.iscomplete = 1
and si.student_id = $id
group by si.studentpayment_id ";

$sql = "select * from ( ($sqlinvoice) union all ($sqlpayment) ) as a order by a.line_date";


$query=$xoopsDB->query($sql);

$linetype_init = "";
$refno_init = "";
$pdf->total_balance = 0;
$pdf->balance_line = 0;
$data = "";
$tabledata='<table border="0" acellspacing="0">';
$pdf->student_id = 0;
$i=0;
while ($row=$xoopsDB->fetchArray($query)){
$i++;

$pdf->student_id = $row['student_id'];
$pdf->line_refno = $row['line_refno'];
$pdf->line_date = $row['line_date'];
$pdf->total_creditline = $row['total_creditline'];
$pdf->total_debitline = $row['total_debitline'];
$pdf->line_description = $row['line_description'];
$pdf->line_type = $row['line_type'];
$pdf->cheque_no = $row['cheque_no'];

if($pdf->line_type == "payment"){
    if($pdf->line_description == "C")
    $pdf->line_description = "Cash";
    else if($pdf->line_description == "Q"){

        if($pdf->cheque_no != "")
        $pdf->cheque_no = "($pdf->cheque_no)";
        $pdf->line_description = "Cheque $pdf->cheque_no";
    }
}

$pdf->total_balance += ($pdf->total_creditline - $pdf->total_debitline);

if($pdf->total_creditline > 0)
$pdf->total_creditline = number_format($pdf->total_creditline,2,".",",");
if($pdf->total_debitline > 0)
$pdf->total_debitline = number_format($pdf->total_debitline,2,".",",");

$pdf->balance_line = number_format($pdf->total_balance,2,".",",");

//$linedesc = str_replace( array("\r\n", "\n","\r"), "<br/>", $row['line_desc'] );
//$linedesc = str_replace( " ", "&nbsp;", $linedesc );

if(($pdf->line_refno != $refno_init) && ($pdf->line_type != $linetype_init)){
$refno_init = $pdf->line_refno;
$linetype_init = $pdf->line_type;
}else{
$pdf->line_refno = "";
$pdf->line_date = "";
}

$brpage = "";
if($linedesc != "")
$brpage = "<br/>";

//$ij = 0;
//while($ij<12){
//$ij++;
$tabledata .= '<tr>';
$tabledata .= '<td width="'.$widthheader[0].'" align="center" height="20">'.$pdf->line_date.'</td>';
$tabledata .= '<td width="'.$widthheader[1].'" align="center">'.$pdf->line_refno.'</td>';
$tabledata .= '<td width="'.$widthheader[2].'" align="left"><font size="10">'.$pdf->line_description.'</font></td>';
$tabledata .= '<td width="'.$widthheader[3].'" align="right">'.$pdf->total_creditline.'</td>';
$tabledata .= '<td width="'.$widthheader[4].'" align="right">'.$pdf->total_debitline.'</td>';
$tabledata .= '<td width="'.$widthheader[5].'" align="right">'.$pdf->balance_line.'</td>';
$tabledata .= '</tr>';
//}

//$data = array($i,$row['item_name'],$row['linedesc'],$row['line_qty'],$row['unitprice'],$row['line_amt']);
}

$tabledata .= '</table>';
        
    //if($i > 0){
    $pdf->balance_linefooter[$jk] =  $pdf->balance_line;
        //echo
        // set font
        $pdf->SetFont('times', '', 10);

        $bp->fetchStudent($pdf->student_id);
        $sm->fetchSemester($pdf->semester_id);
        $cr->fetchCourse($bp->course_id);
        // add a page

        $bp->student_address = str_replace( array("\r\n", "\n","\r"), "<br/>", $bp->student_address );
        $bp->student_address = str_replace( " ", "&nbsp;", $bp->student_address );

        if($bp->student_postcode != "")
        $bp->student_address .= "<br/> $bp->student_postcode";

       if($bp->student_city != "")
        $bp->student_address .= " $bp->student_city";

        if($bp->student_state != "")
        $bp->student_address .= "<br/>$bp->student_state";

        //echo $pdf->balance_line;
        $pdf->AddPage();
        $pdf->totalprint = true;
        //$pdf->writeTotalFooter();

        $pdf->setY(89);
        $pdf->SetFont('times', '', 12);
        $pdf->writeHTML($tabledata, true, false, false, false, '');
        //$pdf->writeHTMLCell(0, 0, 0, 0, $tabledata,0, 0, 0, true,'',true);
        $pdf->totalprint = false;
        //$pdf->footerPrint();
    //}
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
$pdf->Output('invoice.pdf', 'I');
 
?>

<?php
include_once('../simantz/class/fpdf/fpdf.php');
include_once 'system.php';


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

if ($_POST){


class PDF extends FPDF
{
  public $student_id="Unknown";
  public $student_code="Unknown";
  public $student_name="Unknown"; 
  public $school="Unknown"; 
  public $s_hp_no="Unknown"; 
  public $s_tel_1="Unknown"; 
  public $s_isactive="Unknown";
  public $organization_code="Unknown";
  public $tuitionclass_id="Unknown";
  public $period_id="Unknown";
  public $tuitionclass_code; 
  public $cur_name;
  public $cur_symbol;
  public $employee_id="Unknown"; 
  public $description="Unknown"; 
  public $day="Unknown";
  public $time="Unknown";  
  public $employee_name="Unknown"; 
  public $e_hp_no="Unknown";
  public $e_isactive="Unknown";
  public $studentclass_id="Unknown";
  public $r_isactive="Unknown";
  public $amt;

function Header()
{
    $this->Image('../../images/logo.jpg', 12 , 10 , 20 , '' , 'JPG' , '');
    $this->Ln();
$this->SetXY(12,10);
    $this->SetFont('Arial','B',12);
    $this->Cell(130,17,"INSTITUT SAINS DAN TEKNOLOGI DARUL TAKZIM","TBL",0,'R');
    $this->SetFont('Arial','B',18);
    $this->Cell(0,17,"Payroll Summary Report","TBR",0,'R');
    $this->Ln(20);

    $this->SetXY(167,22);
    $this->SetFont('Arial','',10);
    $this->Cell(25,5,"Date From",1,0,'C');
    $this->SetFont('Arial','B',10);
    $this->Cell(35,5,$this->datefrom,1,0,'C');
    $this->SetFont('Arial','',10);
    $this->Cell(25,5,"Date To",1,0,'C');
    $this->SetFont('Arial','B',10);
    $this->Cell(35,5,$this->dateto,1,0,'C');

   
	$this->Ln(7);

	$i=0;
	$header=array("No","Organization","Period", "Employee No.","Employee Name","Basic Salary ($this->cur_symbol)",
			"Total Income($this->cur_symbol)","EPF ($this->cur_symbol)","SOCSO ($this->cur_symbol)","Net Pay($this->cur_symbol)");

    	$w=array(10,20,20,20,55,30,30,30,30,30);
	foreach($header as $col)
      	{
//	$ypos="";
	$this->SetFont('Times','B',8); 
	
       	$this->Cell($w[$i],8,$col,1,0,'C');

	$i=$i+1;		
	}	
    $this->Ln();
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());
    //Position at 1.5 cm from bottom
    $this->SetY(-7);
    //Arial italic 8
    $this->SetFont('courier','I',8);

    $this->Cell(0,5,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

function BasicTable($header,$data,$printheader)
{
    	$w=array(10,20,20,20,55,30,30,30,30,30);
	$i=0;
    //Header
/*    if($printheader==1){
    	foreach($header as $col)
      	{

$this->SetFont('Arial','B',9); 
       	$this->Cell($w[$i],7,$col,1,0,'C');
	$i=$i+1;		
	}	
    $this->Ln();
      }*/
    //Data

$this->SetFont('Times','',8);
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {

	
		while($this->GetStringWidth($col)> $w[$i]-1)
			$col=substr_replace($col,"",-1);		

	     $this->Cell($w[$i],6,$col,1,0,'C');
	
            $i=$i+1;
            }
        $this->Ln();
    }

}

function genWhereString($employee_id,$iscomplete,$datefrom,$dateto,$period_id){
$filterstring="";
$needand="";
if($employee_id > 0 ){
	$filterstring=$filterstring . " p.employee_id=$employee_id AND";

}
if($period_id > 0 ){
	$filterstring=$filterstring . " p.period_id=$period_id AND";

}

if($iscomplete!=""){
$filterstring=$filterstring . "  $needand p.iscomplete = '$iscomplete'  AND";
}

if ($datefrom !="" && $dateto!="")
	$filterstring= $filterstring . "  $needand p.payslipdate between '$datefrom 00:00:00' and '$dateto 23:59:59' AND";

if ($filterstring=="")
	return "";
else {
	$filterstring =substr_replace($filterstring,"",-3);  

	return " $filterstring";
	}
} 

}

$tableprefix= XOOPS_DB_PREFIX . "_";
/*
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tableperiod=$tableprefix . "simtrain_period";
$tableemployee=$tableprefix."simtrain_employee";
$tablestudentclass=$tableprefix."simtrain_studentclass";
$tablepaymentline=$tableprefix."simtrain_paymentline";
$tablepayslip=$tableprefix."simtrain_payslip";
$tablepayslipline=$tableprefix."simtrain_payslipline";
$tableorganization=$tableprefix."simtrain_organization";
 * 
 */


	$pdf=new PDF('L','mm','A4'); 
	$pdf->SetLeftMargin(12);
	$pdf->AliasNbPages();
	
	$datefrom=$_POST['datefrom'];
	$dateto=$_POST['dateto'];
	$period_id=$_POST['period_id'];
	$employee_id=$_POST['employee_id'];
	$iscomplete=$_POST['iscomplete'];
	//$o->isAdmin=$xoopsUser->isAdmin();
	
	$wherestr=$pdf->genWhereString($employee_id,$iscomplete,$datefrom,$dateto,$period_id);


	if ($wherestr!="")
	$wherestr="WHERE ". $wherestr;
	
	if($defaultorganization_id != "")
	$wherestr .= " and e.organization_id = $defaultorganization_id ";

	$orderbystring = "order by p.payslipdate,cast(e.employee_no as signed) asc";

	$pdf->period_name=$_POST['period_name'];
	$pdf->organization_code=$_POST['organization_code'];
	$pdf->cur_name=$cur_name;
	$pdf->cur_symbol='RM';
	$pdf->datefrom=$datefrom;
	$pdf->dateto=$dateto;
	
	$sql="SELECT o.organization_code,period.period_name, e.employee_id,e.employee_name,
		e.employee_no, p.iscomplete, p.payslip_id,e.employee_epfno,e.employee_socsono,
		p.basicsalary, p.netpayamt,p.position, p.department,p.totalincomeamt,
		p.employee_epfamt,p.employee_socsoamt 
		FROM $tablepayslip p 
		INNER JOIN $tableemployee e on e.employee_id=p.employee_id 
		INNER JOIN $tableperiod period on period.period_id=p.period_id
		INNER JOIN $tableorganization o on e.organization_id=o.organization_id
		$wherestr $orderbystring";

	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	
	
	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;

	$employee_no=$row['employee_no'];
	$employee_name=$row['employee_name'];
	$organization_code=$row['organization_code'];
	$department=$row['department'];
	$payslip_id=$row['payslip_id'];
	$period_name=$row['period_name'];
	$position=$row['position'];
	$iscomplete=$row['iscomplete'];
	$employee_id=$row['employee_id'];
	$basicsalary=$row['basicsalary'];
	$totalincomeamt=$row['totalincomeamt'];
	$netpayamt=$row['netpayamt'];
	$employee_epfamt=$row['employee_epfamt'];
	$employee_socsoamt=$row['employee_socsoamt'];

	$totalnet += $netpayamt;

//	$k=0;
//	while($k < 20){
//	$k++;
   	$data[]=array($i,$organization_code,$period_name,$employee_no,$employee_name,$basicsalary,$totalincomeamt,$employee_epfamt,$employee_socsoamt,$netpayamt);
//	}
	
	}
	$data[]=array("","","","","","","","","Total Net",number_format($totalnet,2));

	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
   	//$pdf->MultiCell(0,5,$sql,0,'L');
	$pdf->BasicTable($header,$data,1);  

	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output();
	exit (1);

}
else {

include_once "menu.php";
include_once "system.php";
//include_once ("menu.php");
include_once "class/Log.php";
include_once "class/Employee.php";
include_once "class/Payslip.php";
include_once "../simantz/class/datepicker/class.datepicker.php";
include_once '../system/class/Period.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$url");
$dp->dateFormat='Y-m-d';

$log = new Log();

$o = new Payslip($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);
$period = new Period($xoopsDB,$tableprefix,$log);
$o->showdatefrom=$dp->show("datefrom");
$o->showdateto=$dp->show("dateto");

$action=$_POST['action'];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;


$periodctrl=$ctrl->getSelectPeriod(0,'Y',"","period_id",'');

$employeectrl=$ctrl->getSelectEmployee(0,"Y","","employee_id","$wherestr","employee_id",$employeewidth,"N",0);

echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">View Payroll Summary Report</span></big></big></big></div><br>-->
<form name="frmSearchPayslip" action="viewpayrollreport.php" method="POST" target="_blank">
<table style="text-align: left; width: 100%;" border="0" cellpadding="0" acellspacing="0">
  <tbody>
	<tr>
	<th colspan="4" align="left">Criterial</th>
	</tr>
    <tr>
      <td class="head">Date From</td>
      <td class="odd"><input name='datefrom' id='datefrom' size="10" maxlength="10"><input type='button' onclick="$o->showdatefrom" value='Date'></td>
     <td class="head">Date To</td>
	 <td class="odd"> <input name='dateto' id='dateto' size="10" maxlength="10"><input type='button' onclick="$o->showdateto"  value='Date'></td>
    </tr>
    <tr>
      <td class="head">Completed</td>
      <td class="even"><SELECT name="iscomplete"><option value="">Null</option><option value='Y'>Yes</option><option value='N'>No</option></select></td>
      <td class="head">Period</td>
	<td class="even"> $periodctrl</td>
    </tr>
     <td class="head">Employee</td>
      <td class="even">$employeectrl</td>
      <td class="head"></td>
	<td class="even"> </td>
    </tr>
    <tr>
      <td><input type="reset" value="reset" name="reset"></td>
      <td colspan="3"><input type="submit" value="View Report" name="action"></td>
    </tr>
  </tbody>	
</table>

</form>
EOF;
/*
if (isset($action)){
$datefrom=$_POST['datefrom'];
$dateto=$_POST['dateto'];
$period_id=$_POST['period_id'];
$employee_id=$_POST['employee_id'];
$iscomplete=$_POST['iscomplete'];
$o->isAdmin=$xoopsUser->isAdmin();

$wherestr=genWhereString($employee_id,$iscomplete,$datefrom,$dateto,$period_id);

$log->showLog(3,"Generated Wherestring=$wherestr");


if ($wherestr!="")
	$wherestr="WHERE ". $wherestr;
$o->showPayslipTable( $wherestr,  "order by p.payslipdate,e.employee_name" ); 

}*/

require(XOOPS_ROOT_PATH.'/footer.php');


}
?>

<?php
include_once('fpdf/fpdf.php');
include_once 'system.php';


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
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
    $this->Image('upload/images/attlistlogo.jpg', 12 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
$this->SetXY(12,10);
    $this->SetFont('Arial','B',18);
    $this->Cell(0,17,"New Join Student Class Report",1,0,'R');
    $this->Ln(20);

/*
    $this->SetXY(137,22);
    $this->SetFont('Arial','',10);
    $this->Cell(25,5,"Tuition Class",1,0,'C');
    $this->SetFont('Arial','B',10);
    $this->Cell(65,5,$this->tuitionclass,1,0,'C');
    $this->SetFont('Arial','',10);
    $this->Cell(25,5,"Period",1,0,'C');
    $this->SetFont('Arial','B',10);
    $this->Cell(35,5,$this->period_name,1,0,'C');
*/


   
	$this->Ln(7);

	$i=0;
	$header=array("No","Organization","Student Name","Tuition Class","Period", "IC No","Races","Religion","School","Standard","Gender");

    	$w=array(10,20,40,40,25,25,20,20,30,30,15);
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
    	$w=array(10,20,40,40,25,25,20,20,30,30,15);
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
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tableperiod=$tableprefix . "simtrain_period";
$tableemployee=$tableprefix."simtrain_employee";
$tablestudentclass=$tableprefix."simtrain_studentclass";
$tablepaymentline=$tableprefix."simtrain_paymentline";
$tablepayslip=$tableprefix."simtrain_payslip";
$tablepayslipline=$tableprefix."simtrain_payslipline";
$tableorganization=$tableprefix."simtrain_organization";
$tablestudent=$tableprefix . "simtrain_student";
$tableaddress=$tableprefix . "simtrain_address";
$tableparents=$tableprefix . "simtrain_parents";
$tablestandard=$tableprefix."simtrain_standard";
$tableraces=$tableprefix."simtrain_races";
$tablereligion=$tableprefix."simtrain_religion";
$tableschool=$tableprefix."simtrain_school";
$tablestudentclass=$tableprefix."simtrain_studentclass";
$tabletuitionclass=$tableprefix."simtrain_tuitionclass";

if ($_POST){
	$pdf=new PDF('L','mm','A4'); 
	$pdf->SetLeftMargin(12);
	$pdf->AliasNbPages();
		
	//$datefrom=$_POST['datefrom'];
	//$dateto=$_POST['dateto'];
	$periodfrom_id=$_POST['periodfrom_id'];
	$periodto_id=$_POST['periodto_id'];

	$tuitionclass_code = $_POST['tuitionclass_code'];
	$tuitionclass_id = $_POST['tuitionclass_id'];
	$gender = $_POST['gender'];
	$races_id = $_POST['races_id'];
	$religion_id = $_POST['religion_id'];
	$school_id = $_POST['school_id'];
	$standard_id = $_POST['standard_id'];

	$wherestr = " where 1 ";
	//$wherestr = " and sc.tuitionclass_id = '$tuitionclass_id' ";

	if($periodfrom_id > 0 )
	$wherestr .= " and tc.period_id=$periodfrom_id ";

	if($tuitionclass_code != "")
	$wherestr .= " and tc.tuitionclass_code like '$tuitionclass_code' ";
	if($gender != "")
	$wherestr .= " and s.gender = '$gender' ";
	if($races_id > 0)
	$wherestr .= " and s.races_id = '$races_id' ";
	if($religion_id > 0)
	$wherestr .= " and s.religion_id = '$religion_id' ";
	if($school_id > 0)
	$wherestr .= " and s.school_id = '$school_id' ";
	if($standard_id > 0)
	$wherestr .= " and s.standard_id = '$standard_id' ";
	
	if($defaultorganization_id != "")
	$wherestr .= " and s.organization_id = $defaultorganization_id ";

	$orderbystring = "order by s.student_name ";

	$pdf->period_name=$_POST['period_name'];
	$pdf->organization_code=$_POST['organization_code'];

	$sql="SELECT s.student_id, s.student_code,s.alternate_name, s.student_name, s.isactive, s.dateofbirth,std.standard_name, s.gender, s.ic_no, 
	 sch.school_name, s.hp_no, s.tel_1, s.tel_2, s.parents_id,p.parents_name, p.parents_contact, s.organization_id, s.joindate,
	 r.races_name,s.description,s.email,s.web,s.levela,s.levelb,s.levelc,s.religion_id, re.religion_name,o.organization_code,
	 tc.tuitionclass_code,pr.period_name,sc.classjoindate  
	 FROM $tablestudent s 
	 inner join $tableraces r on r.races_id=s.races_id 
	 inner join $tablestandard std on std.standard_id=s.standard_id 
	 inner join $tableschool sch on sch.school_id=s.school_id 
	 inner join $tableorganization o on o.organization_id=s.organization_id 
	 inner join $tableparents p on p.parents_id=s.parents_id 
	 inner join $tablereligion re on s.religion_id=re.religion_id
	 inner join $tablestudentclass sc on s.student_id=sc.student_id
	 inner join $tabletuitionclass tc on sc.tuitionclass_id=tc.tuitionclass_id 
	 inner join $tableperiod pr on tc.period_id=pr.period_id 
	 $wherestring $wherestr and s.student_id > 0 
	 $orderbystring";

	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	
	//$header=array("No","Organization","Student Name", "IC No","Parents Name","Races","Religion","School","Standard","H/P No","Gender");
	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){


	$student_code=$row['student_code'];
	$student_name=$row['student_name'];
	$alternate_name=$row['alternate_name'];
	$school_name=$row['school_name'];
	$organization_code=$row['organization_code'];
	$hp_no=$row['hp_no'];
	$standard_name=$row['standard_name'];
	$levela=$row['levela'];
	$levelb=$row['levelb'];
	$levelc=$row['levelc'];
	$religion_name=$row['religion_name'];
	$student_id=$row['student_id'];
	$isactive=$row['isactive'];
	$ic_no=$row['ic_no'];
	$parents_id=$row['parents_id'];
	$parents_name=$row['parents_name'];
	$races_name=$row['races_name'];
	$tel_1=$row['tel_1'];
	$email=$row["email"];
	$web=$row["web"];
	$description=$row["description"];
	$gender=$row['gender'];
	$tuitionclass_code=$row['tuitionclass_code'];
	$period_name=$row['period_name'];
	$classjoindate=$row['classjoindate'];

	

//	$k=0;
//	while($k < 40){
//	$k++;

	if($period_name == substr($classjoindate,0,7)){
	$i=$i+1;
   	$data[]=array($i,$organization_code,$student_name,$tuitionclass_code,$period_name,$ic_no,$races_name,$religion_name,$school_name,$standard_name,$gender);
	}
//	}
	
	}

	/*if($tuitionclass_id >0)
	$pdf->tuitionclass = $tuitionclass_code;
	
	//$pdf->tuitionclass = $tuitionclass_code . "-" .$period_name."-".$organization_code;

	if($periodfrom_id >0)
	$pdf->period_name = $period_name;*/

	//$data[]=array("","","","","","","","","Total Net",number_format($totalnet,2));

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

include_once "system.php";
include_once ("menu.php");
include_once 'class/ProductCategory.php';
include_once "class/Log.php";
include_once "class/Employee.php";
//include_once "class/Payslip.php";
include_once './class/Races.php';
include_once './class/Religion.php';
include_once ("datepicker/class.datepicker.php");
include_once 'class/Period.php';
include_once './class/School.php';
include_once './class/Standard.php';
include_once "class/TuitionClass.php";
include_once "class/RegClass.php";
include_once "class/Log.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';

$log = new Log();

$rc = new Races($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$em = new Employee($xoopsDB,$tableprefix,$log);
$rg = new Religion($xoopsDB,$tableprefix,$log);
$sc = new School($xoopsDB,$tableprefix,$log);
$st = new Standard($xoopsDB,$tableprefix,$log);
$rs = new RegClass($xoopsDB,$tableprefix,$log);
$tc = new TuitionClass($xoopsDB,$tableprefix,$log);
$period = new Period($xoopsDB,$tableprefix,$log);
$c = new ProductCategory($xoopsDB,$tableprefix,$log);
//$o->showdatefrom=$dp->show("datefrom");
//$o->showdateto=$dp->show("dateto");

$action=$_POST['action'];
//$o->cur_name=$cur_name;
//$o->cur_symbol=$cur_symbol;

$racesctrl=$rc->getSelectRaces(0,'Y');
$religionctrl=$rg->getSelectReligion(0,'Y');
$schoolctrl=$sc->getSelectSchool(0,'Y');
$orgctrl=$permission->selectionOrg(0,'Y');
$standardctrl=$st->getSelectStandard(0,'Y');
$periodfromctrl=$period->getPeriodList(0,'periodfrom_id','Y');
$periodtoctrl=$period->getPeriodList(0,'periodto_id','Y');
$seachcategoryctrl=$c->getSelectCategory(0,'Y');
/*
$areacf_ctrl=$rs->getcomeAddressList(0);
$areabt_ctrl=$rs->getbackAddressList(0);*/
$classctrl=$tc->getSelectTuitionClass(0,'Y');

echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">View New Join Student Class Report</span></big></big></big></div><br>-->
<form name="frmSearchPayslip" action="viewnewjoinstudentclass.php" method="POST" target='_blank'>
<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
  <tbody>
	<tr>
	<th colspan="4" align="left">Criterial</th>
	</tr>
	<tr>
	<td class="head">Organization</t>
	<td class="even" acoslpan="3">$orgctrl</td>
	<td class="head">Category</t>
	<td class="even">$seachcategoryctrl</td>
	</tr>

	<tr>
	<td class="head">Class Code</t>
	<td class="even" acoslpan="3"><input name="tuitionclass_code" > (BM%, %/P1/%, BI/%/01)</td>
	<td class="head">Period</t>
	<td class="even">$periodfromctrl</td>
	</tr>

	<tr>
	<td class="head">School</t>
	<td class="even">$schoolctrl</td>
	<td class="head">Standard</t>
	<td class="even" colspan="3">$standardctrl</td>
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

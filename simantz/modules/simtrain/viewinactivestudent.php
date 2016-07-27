<?php
include_once('fpdf/chinese-unicode.php');
include_once 'system.php';


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends PDF_Unicode
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
    $this->Cell(0,17,"$this->status_student Student Report",1,0,'R');
    $this->Ln(20);

	/*
    $this->SetXY(167,22);
    $this->SetFont('Arial','',10);
    $this->Cell(25,5,"Date From",1,0,'C');
    $this->SetFont('Arial','B',10);
    $this->Cell(35,5,$this->datefrom,1,0,'C');
    $this->SetFont('Arial','',10);
    $this->Cell(25,5,"Date To",1,0,'C');
    $this->SetFont('Arial','B',10);
    $this->Cell(35,5,$this->dateto,1,0,'C');
	*/

   
	$this->Ln(7);

	$i=0;
	$header=array("No","Organization","Student Name", "IC No","Parents Name","Races","Religion","School","Standard","H/P No","Gender");

    	$w=array(10,20,40,25,40,20,20,30,30,25,15);
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
    	$w=array(10,20,40,25,40,20,20,30,30,25,15);
	$i=0;


$this->SetFont('Times','',8);
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {
 
	if ($i==2){
//-------------------------
	$this->SetFont('uGB','',7);
	$break=explode('|||',$col);
	$englishname=$break[count($break)-1];
	$alternatename=$break[0];
	$cellwidth=$w[$i];
	$uGBnamewidth=13;


	while($this->GetStringWidth($alternatename)>$uGBnamewidth && $cellwidth >15)
		$alternatename=substr_replace($alternatename,"",-1);
	$balancewidth=$w[$i]-$uGBnamewidth;
	
//	if($englishname+$uGBnamewidth<$cellwidth ){
//		$balancewidth
	
	$this->isUnicode=true;
	if($alternatename=="Total :")
        $this->Cell($uGBnamewidth,6,'',1,0,'C');
	else
        $this->Cell($uGBnamewidth,6,$alternatename,1,0,'C');
 	$this->isUnicode=false;
	$this->SetFont('Times','',8); 
	while($this->GetStringWidth($englishname)> $balancewidth-1)
			$englishname=substr_replace($englishname,"",-1);
        $this->Cell($balancewidth,6,$englishname,1,0,'L');

		}
	else{
		while($this->GetStringWidth($col)> $w[$i]-1)
			$col=substr_replace($col,"",-1);		
	     $this->Cell($w[$i],6,$col,1,0,'C');
		}

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

if ($_POST){
	$pdf=new PDF('L','mm','A4'); 
	$pdf->SetLeftMargin(12);
	$pdf->AliasNbPages();
		
	$isactive = $_POST['isactive'];
	$gender = $_POST['gender'];
	$races_id = $_POST['races_id'];
	$religion_id = $_POST['religion_id'];
	$school_id = $_POST['school_id'];
	$standard_id = $_POST['standard_id'];


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
	 r.races_name,s.description,s.email,s.web,s.levela,s.levelb,s.levelc,s.religion_id, re.religion_name,o.organization_code
	 FROM $tablestudent s 
	 inner join $tablestudentclass sc on sc.student_id=s.student_id
	 inner join $tableraces r on r.races_id=s.races_id 
	 inner join $tablestandard std on std.standard_id=s.standard_id 
	 inner join $tableschool sch on sch.school_id=s.school_id 
	 inner join $tableorganization o on o.organization_id=s.organization_id 
	 inner join $tableparents p on p.parents_id=s.parents_id 
	 inner join $tablereligion re on s.religion_id=re.religion_id
	 $wherestring $wherestr and s.student_id > 0 and sc.isactive='N'
	 $orderbystring";

	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	
	$header=array("No","Organization","Student Name", "IC No","Parents Name","Races","Religion","School","Standard","H/P No","Gender");
	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){
	$i=$i+1;

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

//	$k=0;
//	while($k < 20){
//	$k++;
   	$data[]=array($i,$organization_code,$student_name,$ic_no,$parents_name,$races_name,$religion_name,$school_name,$standard_name,$hp_no,$gender);
//	}
	
	}
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

include_once "class/Log.php";
include_once "class/Employee.php";
//include_once "class/Payslip.php";
include_once './class/Races.php';
include_once './class/Religion.php';
include_once ("datepicker/class.datepicker.php");
include_once 'class/Period.php';
include_once './class/School.php';
include_once './class/Standard.php';

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
//$o->showdatefrom=$dp->show("datefrom");
//$o->showdateto=$dp->show("dateto");

$action=$_POST['action'];
//$o->cur_name=$cur_name;
//$o->cur_symbol=$cur_symbol;

$racesctrl=$rc->getSelectRaces(0,'Y');
$religionctrl=$rg->getSelectReligion(0,'Y');
$schoolctrl=$sc->getSelectSchool(0,'Y');
$standardctrl=$st->getSelectStandard(0,'Y');

//$periodctrl=$period->getPeriodList(0,'period_id','Y');

//$employeectrl=$e->getEmployeeList(0,'M','employee_id',"Y");
echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">View Inactive Student Report</span></big></big></big></div><br>-->
<form name="frmSearchPayslip" action="viewinactivestudent.php" method="POST">
<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
  <tbody>
	<tr>
	<th colspan="4" align="left">Criterial</th>
	</tr>
	<tr>
	<td class="head">Gender</t>
	<td class="even">
	<select name="gender">
	<option value="">Null</option>
	<option value="F">Female</option>
	<option value="M">Male</option>
	</select>
	</td>
	<td class="head">Races</t>
	<td class="even">$racesctrl</td>
	</tr>

	<tr>
	<td class="head">Religion</t>
	<td class="even">$religionctrl</td>
	<td class="head">School</t>
	<td class="even">$schoolctrl</td>
	</tr>
	<tr>
	<td class="head">Standard</t>
	<td class="even" colspan="3">$standardctrl</td>
	</tr/.
    <tr>
      <td><input type="reset" value="reset" name="reset"></td>
      <td colspan="3"><input type="submit" value="View Report" name="action"></td>
    </tr>
  </tbody>	
</table>
</form>
EOF;


require(XOOPS_ROOT_PATH.'/footer.php');


}
?>

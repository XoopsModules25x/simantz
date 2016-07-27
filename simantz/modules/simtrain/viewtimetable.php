<?php
include_once('fpdf/fpdf.php');
include_once "system.php";


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
 
  public $organization_code="Unknown";
  public $period_name="Unknown";
//  public $scheduleheader=array();
  public $header=array('STD','Code','Name','Day', 'Tutor', 'Room','Time','Amount');
  
function Header()
{
  /*  $this->Image('./images/attlistlogo.jpg', 10 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Arial','B',18);
    $this->Cell(0,17,"Attendance Sheet",1,0,'R');
    $this->Ln(20);
    $this->SetFont('Arial','B',12);
    $this->Cell(26,8,"Class Code",1,0,'L');
    $this->Cell(80,8,$this->tuitionclass_code,1,0,'C');
    $this->Cell(26,8,"Month",1,0,'C');
    $this->Cell(58,8,$this->period_name,1,0,'C');
*/   $this->Image('upload/images/attlistlogo.jpg', 15 , 10 , 60 , '' , 'JPG' , ''); 
   $this->Ln();
    $this->SetFont('Times','B',30);
//-------------------------
	$this->SetXY(15,10);
    $this->Cell(120,17,"$this->period_name",1,0,'R');
	$this->SetX(90);
    $this->Cell(110,17,"$this->organization_code",1,0,'R');
	$this->SetXY(95,10);
//----------------
//    $this->Cell(105,17," ",1,0,'R');
    $this->SetFont('Times','',10);
	$this->SetXY(67,4);
    $this->Cell(40,17,"Month",0,0,'R');
	$this->SetXY(135,4);
    $this->Cell(0,17,"Organization",0,0,'L');

    $this->Ln(25);
    $this->SetFont('Arial','',12);
    $this->Cell(32,8,"Report Title",1,0,'L');
    $this->Cell(0,8,"Class Time Table",1,0,'C');


$this->Ln(10);
$i=0;

    $this->SetFont('Times','B',10);

	//$header=array('No','Index No','Student Name', 'Contact No.', 'School','T');
	//array_push($header,$this->scheduleheader);
   $w=array(14,14,50,10,35,13,25,25); //12 data

foreach($this->header as $col)
      	{
	
	 
       	$this->Cell($w[$i],7,$col,1,0,'C');
	$i=$i+1;		

	}	
    $this->Ln();
}

function Footer()
{
$timestamp= date("d/m/y H:i:s", time());
    //Position at 1.5 cm from bottom
    $this->SetY(-50);
    //Arial italic 8
    $this->SetFont('courier','I',8);
    //Page number
    $this->Cell(0,5,"For Administration Use",LTR,0,'L');
$this->Ln();
    $this->Cell(0,25,"",LBR,0,'L');
$this->Ln();
    $this->Cell(0,10,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

function BasicTable($header,$data,$printheader)
{
//Column widths
//$w=array(7,20,45,20,18,74,38,18,18,18,8);
//No,Code,Student Name, Contact No., School, Fees, 1st, 2nd, 3rd, 4th, 5th, RMK
//no,date,itineray,description,bus,time,customer,sales,rental,profit,id
   $w=array(14,14,50,10,35,13,25,25); //12 data
	$i=0;
  
 foreach($data as $row)
    {
	 $i=0;
    	foreach($row as $col) {

	$this->setFont('Times','',8);
	while($this->GetStringWidth($col)> $w[$i] && $i!=2)
			$col=substr_replace($col,"",-1);	


	     $this->Cell($w[$i],6,$col,1,0,'C');
	
            $i=$i+1;
            }
        $this->Ln();
    }

}
}

$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tableemployee=$tableprefix . "simtrain_employee";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tablestudentclass=$tableprefix . "simtrain_studentclass";
$tableperiod=$tableprefix . "simtrain_period";
$tablestandard=$tableprefix . "simtrain_standard";
$tableschool=$tableprefix . "simtrain_school";
$tableorganization=$tableprefix."simtrain_organization";
$tableattendance=$tableprefix."simtrain_attendance";
$tableroom=$tableprefix."simtrain_room";
$tuitionclass_id=$_POST["tuitionclass_id"];
$schedulecount=0;
$arrayscheduleheader=array();


if (isset($_POST['wherestring'])){


$period_id=$_POST["period_id"];

$pdf=new PDF('P','mm','A4');


//$pdf->header=array('STD','Code','Name','Day', 'Tutor', 'Room','Time','Amount');
	$pdf->AliasNbPages();
	$pdf->SetLeftMargin(15);
	$pdf->SetAutoPageBreak(true ,50);

//}
//if (isset($_GET['tuitionclass_id']) || isset($_GET['period_id'])){

//$tuitionclass_id=$_GET["tuitionclass_id"];
//$period_id=$_GET["period_id"];
//}
$wherestring=$_POST['wherestring'];

	$sql="SELECT a.product_id,a.tuitionclass_id,a.tuitionclass_code,a.description,
			a.product_no,a.product_name,a.employee_name,a.standard_name,
			a.starttime,a.endtime,a.room_name,a.day,a.classtype,a.dayno,a.amt,
			a.period_name,a.organization_code,a.isactive
			FROM (
			select tc.product_id,tc.tuitionclass_id,tc.tuitionclass_code,tc.description,
			pd.product_no,pd.product_name, e.employee_name,st.standard_name,
			tc.starttime , tc.endtime,rm.room_name,tc.day,tc.classtype,'D1' as dayno,pd.amt,
			period.period_name,o.organization_code,tc.isactive
			FROM $tabletuitionclass  tc
			inner join $tableproductlist pd on pd.product_id=tc.product_id
			inner join $tableemployee e on e.employee_id=tc.employee_id
			inner join $tablestandard st on pd.standard_id=st.standard_id
			inner join $tableroom rm on rm.room_id=tc.room_id
			inner join $tableorganization o on o.organization_id=tc.organization_id
			inner join $tableperiod period on period.period_id=tc.period_id
			where tc.tuitionclass_id>0 and pd.product_id >0 and
			(tc.classtype='V'OR tc.classtype='W') AND $wherestring
			UNION
			select tc.product_id,tc.tuitionclass_id,tc.tuitionclass_code,tc.description,
			pd.product_no,pd.product_name, e.employee_name,st.standard_name,
			tc.starttime2,tc.endtime2,rm.room_name,tc.day2,tc.classtype,'D2' as dayno,pd.amt,
			period.period_name,o.organization_code,tc.isactive
			FROM $tabletuitionclass  tc
			inner join $tableproductlist pd on pd.product_id=tc.product_id
			inner join $tableemployee e on e.employee_id=tc.employee_id
			inner join $tablestandard st on pd.standard_id=st.standard_id
			inner join $tableroom rm on rm.room_id=tc.room_id2
			inner join $tableorganization o on o.organization_id=tc.organization_id
			inner join $tableperiod period on period.period_id=tc.period_id
			where tc.tuitionclass_id>0 and pd.product_id >0 and tc.classtype='V'
			AND $wherestring) a order by
			a.standard_name,a.product_name,
			(CASE WHEN a.day='MON' THEN 1 WHEN a.day='TUE' THEN 2 WHEN a.day='WED' THEN 3
			      WHEN a.day='THU' THEN 4 WHEN a.day='FRI' THEN 5 WHEN a.day='SAT' THEN 6 else 7 end),
			a.starttime";



	$query=$xoopsDB->query($sql);
	$i=0;
	$data=array();
	//get data detail
	while ($row=$xoopsDB->fetchArray($query)){
		$i=$i+1;
		$product_no=$row['product_no'];
		$product_name=$row['product_name'];
		$class_code=$row['tuitionclass_code'];
		$employee_name=$row['employee_name'];
		$day = $row['day'];
		$standard_name=$row['standard_name'];
		$room_name=$row['room_name'];
		$amt=$row['amt'];
		$classtime=$row['starttime'] . "~" . $row['endtime'];
		$pdf->organization_code=$row['organization_code'];
		$pdf->period_name=$row['period_name'];
		$data[]=array($standard_name,$class_code,$product_name,$day, $employee_name, $room_name,$classtime,$amt);
   	}
	
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();

	$pdf->BasicTable($header,$data,1);

 	//$pdf->MultiCell(0,7,$sql,1,'C');
	$pdf->Output();
	exit (1);

}

else {
	require(XOOPS_ROOT_PATH.'/header.php');
	include_once "menu.php";
	include_once "class/Log.php";
	include_once "class/Product.php";
	include_once "class/Period.php";
	include_once "class/Employee.php";
	include_once "class/TuitionClass.php";
	include_once "class/Room.php";

	$log=new Log();
	$e= new Employee($xoopsDB,$tableprefix,$log);
	$period= new Period($xoopsDB,$tableprefix,$log);
	$p= new Product($xoopsDB,$tableprefix,$log);
	$r= new Room($xoopsDB,$tableprefix,$log);

	if(isset($_POST['action'])){
	$organization_id=$_POST['organization_id'];
	$product_id=$_POST['product_id'];
	$period_id=$_POST['period_id'];
	$isactive=$row['isactive'];
	$room_id=$_POST['room_id'];

	$employee_id=$_POST['employee_id'];
	$active=$_POST['active'];
	if($active=='Y')
	$selectstatus="<SELECT name='active'><option value=''>NULL</option>
			<option value='Y' selected='selected'>Yes</option>
			<option value='N'>No</option></select>";
	elseif($active=='N')
	$selectstatus="<SELECT name='active'><option value=''>NULL</option><option 
			value='Y'>Yes</option><option value='N' selected='selected'>No</option></select>";
	else
	$selectstatus="<SELECT name='active'><option value=''  selected='selected'>NULL</option><option 
			value='Y'>Yes</option><option value='N'>No</option></select>";

	}
	else{
	$organization_id=$defaultorganization_id;
	$product_id=0;
	$room_id=0;
	$period_id=1;
	$employee_id=0;
	$selectstatus="<SELECT name='active'><option value=''>NULL</option><option 
			value='Y'>Yes</option><option value='N'>No</option></select>";
	}


	$tuitionclass_code=$_POST['tuitionclass_code'];
	$orgctrl=$permission->selectionOrg($xoopsUser->getVar('uid'),$organization_id);
	$productctrl=$p->getSelectProduct($product_id,'C','onChange="updateDescription()"','Y');
	$periodctrl=$period->getPeriodList($period_id,'period_id','N');
	$empctrl=$e->getEmployeeList($employee_id,0,'employee_id','Y');
	$roomctrl = $r->getSelectRoom($room_id,'Y',"room_id");
	$wont = "won't";

//	$searchempctrl=
	echo <<< EOF

	<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span 
		style="font-weight: bold;">Search Tuition Class</span></big></big></big></div><br>-->
	<form name="frmSearchClass" action="viewtimetable.php" method="POST" >
	<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
	      <td class="head">Class Code</td>
	      <td class="even"><input name="tuitionclass_code" value="$tuitionclass_code" > (BM%, %/P1/%, BI/%/01)</td>
		  <td  class="head">Period</td>
	      <td  class="odd">$periodctrl</td>
	    </tr>
	    <tr>	
	      <td  class="head">Status</td>
	      <td  class="even">$selectstatus</td>
		<td  class="head">Organization</td>
	      <td  class="even">$orgctrl</td>
		</tr>
	    <tr>	
	      <td  class="head">Products</td>
	      <td  class="even">$productctrl</td>
	      <td  class="head">Tutor</td>
	      <td  class="even">$empctrl</td>
	</tr>

	<tr>	
	<td  class="head">Room</td>
	<td  class="even" colspan="3">$roomctrl</td>
	</tr>
	
		<tr>
	      <td  class="head">Operation</td>
	      <td class="odd" colspan='3'><input type="reset" value="reset" name="reset">     <input type="submit" value="search" 
		name="action"> * Special Class and Monthly Class $wont display in this report.</td>
	    </tr>
	  </tbody>	
	</table>

	</form>
	<br>

EOF;
if(isset($_POST['action'])){

$wherestring=convertwherestring($organization_id,$product_id,$period_id,$employee_id,$active,$tuitionclass_code,$room_id);
	$sql="SELECT a.product_id,a.tuitionclass_id,a.tuitionclass_code,a.description,
			a.product_no,a.product_name,a.employee_name,a.standard_name,
			a.starttime,a.endtime,a.room_name,a.day,a.classtype,a.dayno,a.amt,
			a.period_name,a.organization_code,a.isactive
			FROM (
			select tc.product_id,tc.tuitionclass_id,tc.tuitionclass_code,tc.description,
			pd.product_no,pd.product_name, e.employee_name,st.standard_name,
			tc.starttime , tc.endtime,rm.room_name,tc.day,tc.classtype,'D1' as dayno,pd.amt,
			period.period_name,o.organization_code,tc.isactive
			FROM $tabletuitionclass  tc
			inner join $tableproductlist pd on pd.product_id=tc.product_id
			inner join $tableemployee e on e.employee_id=tc.employee_id
			inner join $tablestandard st on pd.standard_id=st.standard_id
			inner join $tableroom rm on rm.room_id=tc.room_id
			inner join $tableorganization o on o.organization_id=tc.organization_id
			inner join $tableperiod period on period.period_id=tc.period_id
			where tc.tuitionclass_id>0 and pd.product_id >0 and
			(tc.classtype='V'OR tc.classtype='W') AND $wherestring
			UNION
			select tc.product_id,tc.tuitionclass_id,tc.tuitionclass_code,tc.description,
			pd.product_no,pd.product_name, e.employee_name,st.standard_name,
			tc.starttime2,tc.endtime2,rm.room_name,tc.day2,tc.classtype,'D2' as dayno,pd.amt,
			period.period_name,o.organization_code,tc.isactive
			FROM $tabletuitionclass  tc
			inner join $tableproductlist pd on pd.product_id=tc.product_id
			inner join $tableemployee e on e.employee_id=tc.employee_id
			inner join $tablestandard st on pd.standard_id=st.standard_id
			inner join $tableroom rm on rm.room_id=tc.room_id2
			inner join $tableorganization o on o.organization_id=tc.organization_id
			inner join $tableperiod period on period.period_id=tc.period_id
			where tc.tuitionclass_id>0 and pd.product_id >0 and tc.classtype='V'
			AND $wherestring) a order by
			a.standard_name,a.product_name,
			(CASE WHEN a.day='MON' THEN 1 WHEN a.day='TUE' THEN 2 WHEN a.day='WED' THEN 3
			      WHEN a.day='THU' THEN 4 WHEN a.day='FRI' THEN 5 WHEN a.day='SAT' THEN 6 else 7 end),
			a.starttime";


		$log->showLog(4,"Run classchedule report with SQL:$sql");
		$query=$xoopsDB->query($sql);


		echo <<< EOF
		<table border='1'>
			<tbody>
			<tr>
				<TH style='text-align:center'>Standard</TH>
				<TH style='text-align:center'>PRD No</TH>
				<TH style='text-align:center'>Name</TH>
				<TH style='text-align:center'>Day</TH>
				<TH style='text-align:center'>Tutor</TH>
				<TH style='text-align:center'>Room</TH>
				<TH style='text-align:center'>Time</TH>
				<TH style='text-align:center'>Amount</TH>
				<TH style='text-align:center'>Active</TH>

			</tr>

EOF;
		

		$i=0;
		while($row=$xoopsDB->fetchArray($query)){
		$i=$i+1;
		$product_no=$row['product_no'];
		$product_name=$row['product_name'];
		$class_code=$row['tuitionclass_code'];
		$employee_name=$row['employee_name'];
		$day = $row['day'];
		$standard_name=$row['standard_name'];
		$room_name=$row['room_name'];
		$amt=$row['amt'];
		$isactive=$row['isactive'];
		$classtime=$row['starttime'] . "~" . $row['endtime'];
		if($rowtype=='odd')
			$rowtype='even';
		else
			$rowtype='odd';

		echo <<< EOF
			<tr>
				<td class='$rowtype' style='text-align:center'>$standard_name</td>
				<td class='$rowtype'>$product_no</td>
				<td class='$rowtype'>$product_name</td>
				<td class='$rowtype' style='text-align:center'>$day</td>
				<td class='$rowtype'>$employee_name</td>
				<td class='$rowtype' style='text-align:center'>$room_name</td>
				<td class='$rowtype' style='text-align:center'>$classtime</td>
				<td class='$rowtype' style='text-align:right'>$amt</td>
				<td class='$rowtype' style='text-align:center'>$isactive</td>

			</tr>

EOF;
		
		}
echo "</tbody></table><br>
<FORM action='viewtimetable.php' target='_blank' method='POST'> 
<input name='wherestring' value='$wherestring' type='hidden'>
<input type='submit' value='Print Preview' name='submit'>
</FORM>";
}


	require(XOOPS_ROOT_PATH.'/footer.php');
}


function convertwherestring($organization_id,$product_id,$period_id,$employee_id,$active,$tuitionclass_code,$room_id){
	$wherestr="tc.organization_id=$organization_id AND tc.period_id=$period_id AND";

	if($room_id>0)
		$wherestr=$wherestr ." rm.room_id=$room_id AND";
	if($product_id>0)
		$wherestr=$wherestr ." pd.product_id=$product_id AND";
	if($employee_id>0)
		$wherestr=$wherestr ." tc.employee_id=$employee_id AND";
	if($active!="")
		$wherestr=$wherestr ." tc.isactive='$active' AND";
	if($tuitionclass_code!="")
		$wherestr=$wherestr ." tc.tuitionclass_code LIKE '$tuitionclass_code' AND";

	$wherestr =substr_replace($wherestr,"",-3);
	return $wherestr;
}
?>


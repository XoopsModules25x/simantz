<?php
include_once('fpdf/fpdf.php');
include_once ('system.php');



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends FPDF
{
 public $datefrom;
 public $dateto;
  public $cur_name;
  public $cur_symbol;
  public $organization_code="unknown";
function Header()
{
   
   $this->Image('upload/images/attlistlogo.jpg', 12 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Arial','B',18);
    $this->SetXY(10,10);
    $this->Cell(0,17," ",1,0,'R');
    $this->SetXY(100,6);
    $this->Cell(0,17,"Fees Collection Report(By Date)",0,0,'R');

  
    $this->SetFont('Times','',9);
    $this->SetXY(74,19);
    $this->Cell(18,8,"Date From",1,0,'L');
  $this->SetFont('Times','B',10);  
  $this->Cell(18,8,$this->datefrom,1,0,'C');
    $this->SetFont('Times','',9);  
  $this->Cell(18,8,"Date To",1,0,'C');
  $this->SetFont('Times','B',10); 
   $this->Cell(18,8,$this->dateto,1,0,'C');
    $this->SetFont('Times','',9);
    $this->Cell(23,8,"Organization",1,0,'C');

 while($this->GetStringWidth($this->organization_name)>28)
		$this->organization_code=substr_replace($this->organization_code,"",-1); 
    $this->SetFont('Times','B',9);
    $this->Cell(31,8,"$this->organization_code",1,0,'C');
    $this->Ln(10);
$i=0;

//    $this->SetFont('Times','B',9);
	$header=array('No','User','Student','Date/Time', 'Fees(RM)',"Trans.($this->cur_symbol)", "Changed($this->cur_symbol)", 'Doc No',"Accum.($this->cur_symbol)");
    $w=array(8,15,38,30,20,20,20,15,24);
foreach($header as $col)
      	{
	$this->SetFont('Times','B',9); 
       	$this->Cell($w[$i],7,$col,1,0,'C');
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

function BasicTable($data)
{
    $w=array(8,15,38,30,20,20,20,15,24);
	$i=0;


$this->SetFont('Times','',9);
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {

        //chop long string to fit in col uname, student name
	if ($i==1 || $i==2)
	  while($this->GetStringWidth($col)>$w[$i])
		$col=substr_replace($col,"",-1);  
	
        if ($i<=3)
            $this->Cell($w[$i],6,$col,1,0,'L');
 	else
	     $this->Cell($w[$i],6,$col,1,0,'R');
	
            $i=$i+1;
            }
        $this->Ln();
    }

}
}
include_once 'class/Student.php';
//include_once 'class/Employee.php';
include_once 'class/Organization.php';
include_once './class/Log.php';
$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tableemployee=$tableprefix . "simtrain_employee";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tablestudentclass=$tableprefix . "simtrain_studentclass";
$tableorganization=$tableprefix . "simtrain_organization";
$tableperiod=$tableprefix . "simtrain_period";
$tablepaymentline=$tableprefix."simtrain_paymentline";
$tablepayment=$tableprefix."simtrain_payment";
$tableusers=$tableprefix."users";
$log = new Log();
//$e = new Employee ($xoopsDB, $tableprefix, $log);
$std = new Student ($xoopsDB, $tableprefix, $log);
$uid=$xoopsUser->getVar('uid');
$orgctrl=$permission->selectionOrg($uid,0);
$organization_id=0;
if (isset($_POST['submit'])){



	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->cur_name=$cur_name;
	$pdf->cur_symbol=$cur_symbol;
   

        $organization_id=$_POST["organization_id"];

        
	if($_POST["datefrom"]!="")
	$pdf->datefrom=$_POST["datefrom"];
	else
	$pdf->datefrom='0000-00-00';

	$pdf->cur_name=$cur_name;
	$pdf->cur_symbol=$cur_symbol;

	if($_POST["dateto"] !="")
	$pdf->dateto=$_POST["dateto"];
	else
	$pdf->dateto='9999-12-31';	

	$wherestring="p.payment_datetime between '$pdf->datefrom 00:00:00' and '$pdf->dateto 23:59:59'";

	if($_POST["student_id"] != "0" )
		$wherestring=$wherestring . " AND s.student_id=".$_POST['student_id'];

	if($_POST["uid"] != "0")
		$wherestring=$wherestring . " AND u.uid=".$_POST['uid'];
//	$wherestring="p.payment_datetime between '$pdf->datefrom' and '$pdf->dateto'";
	$sql="select u.uid,u.uname,s.student_name AS student_name,p.payment_datetime AS payment_datetime,".
		" sum(pl.amt - pl.transportamt) AS fees,sum(pl.transportamt) AS transportamt,".
		" p.returnamt AS returnamt,p.receipt_no AS docno,o.organization_code from $tablepayment p ".
		" join $tablepaymentline pl on pl.payment_id = p.payment_id ".
		" join $tablestudent s on p.student_id = s.student_id ".
		" left join $tableusers u on p.updatedby = u.uid ".
		" join $tableorganization o on o.organization_id = p.organization_id ".
		" where p.iscomplete = 'Y' and p.organization_id=$organization_id AND $wherestring ".
		" group by u.uid,u.uname,s.student_name,p.receipt_no,p.payment_datetime,p.returnamt order by p.payment_datetime desc";
	$sqlsummary="select  sum(pl.amt - pl.transportamt) AS fees,sum(pl.transportamt) AS transportamt".
		" from $tablepayment p ".
		" join $tablepaymentline pl on pl.payment_id = p.payment_id ".
		" join $tablestudent s on p.student_id = s.student_id ".
		" left join $tableusers u on p.updatedby = u.uid ".
		" where p.iscomplete = 'Y' and p.organization_id=$organization_id AND $wherestring ";

	$query=$xoopsDB->query($sql);
	$total=0;
	$rowtype="";
	$data=array();
	$i=0;
	while($row=$xoopsDB->fetchArray($query)) {
		$i++;
		$uid=$row['uid'];
		$uname=$row['uname'];
		$student_name=$row['student_name'];
		$payment_datetime=$row['payment_datetime'];
		$fees=$row['fees'];
		$transportamt=$row['transportamt'];
		$pdf->organization_code=$row['organization_code'];
		$returnamt=$row['returnamt'];
		$docno=$row['docno'];
		$total=$total+$fees+$transportamt;
		$data[]=array($i,$uname,$student_name,$payment_datetime,$fees,$transportamt,$returnamt,$docno,number_format($total,2));
		//$data[]=array($i,"","","","","","","","","","","","","");
		
	}
	$querysum=$xoopsDB->query($sqlsummary);
	$datasum=array();
	if($rowsum=$xoopsDB->fetchArray($querysum))
		$data[]=array('','',"Total($pdf->cur_symbol):",'',$rowsum['fees'],$rowsum['transportamt'],'','','');
	
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
   	//$pdf->MultiCell(0,10,$sql,0,'C');
	$pdf->BasicTable($data);
	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output("DailyFeesCollection-".$pdf->datefrom."_".$pdf->dateto.".pdf","I");
	exit (1);

}
else {

require "datepicker/class.datepicker.php";
include "menu.php";
$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$showCalender1=$dp->show("datefrom");
$showCalender2=$dp->show("dateto");
$employeectrl=$permission->selectAvailableSysUser(0,'Y');
$studentctrl=$std->getStudentSelectBox(-1);
echo <<< EOF

<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Payment Receiving Report</span></big></big></big></div><br>-->
	<table border='1'>
		<tbody>
			<tr><form name='frmincome' action='viewpaymentreceived.php' method='post' target='_blank'>
				<td class='head'>Date From</td>
				<td class='odd'><input name='datefrom' id='datefrom'><input type='button' value='Date' onClick="$showCalender1"></td>
				<td class='head'>Date To</td>
				<td class='odd'><input name='dateto' id='dateto'><input type='button' value='Date' onClick="$showCalender2"></td>
			</tr>
			<tr><td class='head'>User</td><td class='even'>$employeectrl</td>
				<td  class='head'>Student</td><td class='even'>$studentctrl</td></tr>
                        <tr><td class='head'>Payment Made In</td><td class='odd'>$orgctrl</td>
				<td  class='head'></td><td class='even'><input type='submit' value='search' name='submit'></td></tr>
			
		</tbody></form>
	</table>
EOF;
	require(XOOPS_ROOT_PATH.'/footer.php');
}
?>


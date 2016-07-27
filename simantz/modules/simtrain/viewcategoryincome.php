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
 public $organization_code;
 public $organization_name;
 public $uname;

function Header()
{
   /* $this->Image('./images/attlistlogo.jpg', 10 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Arial','B',18);
    $this->Cell(0,17,"Fees Collection Report(By Date)",1,0,'R');
    $this->Ln(20);
    $this->SetFont('Arial','B',12);
    $this->Cell(26,8,"Date From",1,0,'L');
    $this->Cell(69,8,$this->datefrom,1,0,'C');
    $this->Cell(26,8,"Date To",1,0,'C');
    $this->Cell(69,8,$this->dateto,1,0,'C');
    $this->Ln(10);*/
   $this->Image('upload/images/attlistlogo.jpg', 12 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Arial','B',18);
    $this->Cell(0,17," ",1,0,'R');
    $this->SetXY(100,6);
    $this->Cell(0,17,"Fees Collection Report(By Category)",0,0,'R');

    $this->SetFont('Times','B',9);
    $this->SetXY(96,19);
    $this->Cell(20,4,"Date From",1,0,'L');
    $this->Cell(32,4,$this->datefrom,1,0,'C');
    $this->Cell(20,4,"Date To",1,0,'L');
    $this->Cell(32,4,$this->dateto,1,0,'C');
 $this->SetXY(96,23);
    $this->Cell(20,4,"Organization",1,0,'L');
    $this->Cell(32,4,$this->organization_code,1,0,'C');
    $this->Cell(20,4,"User",1,0,'L');
    $this->Cell(32,4,$this->uname,1,0,'C');
    $this->Ln(10);
$i=0;

    $this->SetFont('Times','B',11);
	$header=array('No','Code','Description',"Active","Amount($this->cur_symbol)", "Total($this->cur_symbol)",'Remarks');
    $w=array(8,20,45,15,20,20,62);
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
    $this->SetY(-7);
    //Arial italic 8
    $this->SetFont('courier','I',8);

    $this->Cell(0,5,'Page ' . $this->PageNo() . '/{nb} Generated dated '.$timestamp,0,0,'C');
}

function BasicTable($data)
{
    $w=array(8,20,45,15,20,20,62);
	$i=0;


$this->SetFont('Times','',8);
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {

        //chop long string to fit in col uname, student name
	if ($i==1 || $i==2)
	  while($this->GetStringWidth($col)>$w[$i])
		$col=substr_replace($col,"",-1);  

        if ($i<3)
            $this->Cell($w[$i],6,$col,1,0,'L');
	elseif($i==3)
            $this->Cell($w[$i],6,$col,1,0,'C');
 	else
	     $this->Cell($w[$i],6,$col,1,0,'R');
	
            $i=$i+1;
            }
        $this->Ln();
    }

}
}
include_once 'class/ProductCategory.php';
include_once './class/Log.php';
$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_category";
$tableemployee=$tableprefix . "simtrain_employee";
$tableproductlist=$tableprefix . "simtrain_productlist";
$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tablestudentclass=$tableprefix . "simtrain_studentclass";
$tableperiod=$tableprefix . "simtrain_period";
$tableorganization=$tableprefix."simtrain_organization";
$tableusers=$tableprefix."users";
$tablepaymentline=$tableprefix."simtrain_paymentline";
$tablepayment=$tableprefix."simtrain_payment";
$tableusers=$tableprefix."users";
$log = new Log();

$c = new ProductCategory ($xoopsDB, $tableprefix, $log);

if (isset($_POST['submit'])){



	$pdf=new PDF('P','mm','A4'); 
	$pdf->AliasNbPages();
	$pdf->cur_name=$cur_name;
	$pdf->cur_symbol=$cur_symbol;

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

	$organization_id=$_POST['organization_id'];
	$uid=$_POST['uid'];

	$sqlorg="SELECT organization_name,organization_code from $tableorganization 
			where organization_id=$organization_id";
	$sqluser="SELECT uname,name from $tableusers where uid=$uid";
	$qryorg=$xoopsDB->query($sqlorg);
	if($roworg=$xoopsDB->fetchArray($qryorg))
		$pdf->organization_name=$roworg['organization_code'];

	$qryuser=$xoopsDB->query($sqluser);
	if($rowuser=$xoopsDB->fetchArray($qryuser)){
		$pdf->uname=$rowuser['uname'];
		$pdf->name=$rowuser['name'];
	}

	$wherestring=" and py.payment_datetime between '$pdf->datefrom 00:00:00' and '$pdf->dateto 23:59:59' and ".
			" py.organization_id=$organization_id and py.updatedby=$uid ";
	
	

//	$wherestring="payment_datetime between '$pdf->datefrom' and '$pdf->dateto'";
	$sql="SELECT c.category_code,c.category_description,c.isactive, ".
		" coalesce( ".
		" (select sum(pl.amt)  FROM sim_simtrain_paymentline pl ".
		" inner join sim_simtrain_productlist pd on pd.product_id=pl.product_id ".
		" inner join sim_simtrain_payment py on py.payment_id=pl.payment_id ".
		" where pd.category_id=c.category_id and py.iscomplete='Y' $wherestring) ".
		" , ".
		" (select sum(pl.trainingamt) FROM sim_simtrain_paymentline pl ".
		" inner join sim_simtrain_studentclass sc on pl.studentclass_id=sc.studentclass_id ".
		" inner join sim_simtrain_inventorymovement mi on mi.movement_id=sc.movement_id ".
		" inner join sim_simtrain_payment py on py.payment_id=pl.payment_id ".
		" inner join sim_simtrain_productlist pd on pd.product_id=mi.product_id ".
		" where pd.category_id=c.category_id and py.iscomplete='Y' $wherestring) ".
		" , ".
		" (select sum(pl.trainingamt) FROM sim_simtrain_paymentline pl ".
		" inner join sim_simtrain_studentclass sc on pl.studentclass_id=sc.studentclass_id ".
		" inner join sim_simtrain_tuitionclass tc on tc.tuitionclass_id=sc.tuitionclass_id ".
		" inner join sim_simtrain_payment py on py.payment_id=pl.payment_id ".
		" inner join sim_simtrain_productlist pd on pd.product_id=tc.product_id ".
		" where pd.category_id=c.category_id and py.iscomplete='Y' $wherestring), 0.00 ".
		" ) as amt ".
		" FROM sim_simtrain_productcategory c".
		" WHERE c.category_id>0 AND coalesce( ".
		" (select sum(pl.amt)  FROM sim_simtrain_paymentline pl ".
		" inner join sim_simtrain_productlist pd on pd.product_id=pl.product_id ".
		" inner join sim_simtrain_payment py on py.payment_id=pl.payment_id ".
		" where pd.category_id=c.category_id and py.iscomplete='Y' $wherestring) ".
		" , ".
		" (select sum(pl.trainingamt) FROM sim_simtrain_paymentline pl ".
		" inner join sim_simtrain_studentclass sc on pl.studentclass_id=sc.studentclass_id ".
		" inner join sim_simtrain_inventorymovement mi on mi.movement_id=sc.movement_id ".
		" inner join sim_simtrain_payment py on py.payment_id=pl.payment_id ".
		" inner join sim_simtrain_productlist pd on pd.product_id=mi.product_id ".
		" where pd.category_id=c.category_id and py.iscomplete='Y' $wherestring) ".
		" , ".
		" (select sum(pl.trainingamt) FROM sim_simtrain_paymentline pl ".
		" inner join sim_simtrain_studentclass sc on pl.studentclass_id=sc.studentclass_id ".
		" inner join sim_simtrain_tuitionclass tc on tc.tuitionclass_id=sc.tuitionclass_id ".
		" inner join sim_simtrain_payment py on py.payment_id=pl.payment_id ".
		" inner join sim_simtrain_productlist pd on pd.product_id=tc.product_id ".
		" where pd.category_id=c.category_id and py.iscomplete='Y' $wherestring), 0.00 ".
		" )<>0";

	$query=$xoopsDB->query($sql);
	$total=0;
	$rowtype="";
	$data=array();
	$i=0;
	while($row=$xoopsDB->fetchArray($query)) {
		$i++;
		$category_code=$row['category_code'];
		$category_description=$row['category_description'];
		$isactive=$row['isactive'];
		$amt=$row['amt'];
		$total=$total+$amt;
		$data[]=array($i,$category_code,$category_description,$isactive,number_format($amt,2),
				number_format($total,2),'');
		//$data[]=array($i,"","","","","","","","","","","","","");
	}

	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
 	//$pdf->MultiCell(0,5,$sql,0,'C');
	$pdf->BasicTable($data);

	$pdf->Output("DailyFeesCollection-".$pdf->datefrom."_".$pdf->dateto.".pdf","I");
	exit (1);

}
else {

include_once 'class/Address.php';
include_once 'class/Employee.php';
require "datepicker/class.datepicker.php";
include "menu.php";

$dp=new datepicker("$tableprefix");
$ad = new Address ($xoopsDB, $tableprefix, $log);
//$u = new Employee($xoopsDB, $tableprefix, $log, $ad);

$dp->dateFormat='Y-m-d';
$showCalender1=$dp->show("datefrom");
$showCalender2=$dp->show("dateto");

$uid=$xoopsUser->getVar('uid');
$userctrl= $permission->selectAvailableSysUser(0,'N');
$orgctrl= $permission->selectionOrg($uid,$defaultorganization_id);
echo <<< EOF

<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Fees Collection Report(By Category)</span></big></big></big></div><br>-->
	<table>
		<tbody>
			<tr><form name='frmincome' action='viewcategoryincome.php' method='post' target='_blank'>
				<td class='head'>Organization</td>
				<td class='odd'>$orgctrl</td>
				<td class='head'>User</td>
				<td class='odd'>$userctrl</td>
</tr><tr>
				<td class='head'>Date From</td>
				<td class='odd'><input name='datefrom' id='datefrom'><input type='button' value='Date' onClick="$showCalender1"></td>
				<td class='head'>Date To</td>
				<td class='odd'><input name='dateto' id='dateto'><input type='button' value='Date' onClick="$showCalender2"></td>
			<tr><td><input type='submit' value='search' name='submit'></td></tr>
		</tbody></form>
	</table>
EOF;
	require(XOOPS_ROOT_PATH.'/footer.php');
}
?>


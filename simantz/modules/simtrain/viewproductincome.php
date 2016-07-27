<?php
include_once('fpdf/chinese-unicode.php');
include_once ('system.php');



error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
class PDF extends PDF_Unicode
{
 public $datefrom;
 public $dateto;
  public $cur_name;
  public $cur_symbol;
  public $organization_code="unknown";
function Header()
{
   /* $this->Image('./images/attlistlogo.jpg', 10 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Arial','B',18);
    $this->Cell(0,17,"Fees Collection Report(By Date)",1,0,'R');
    $this->Ln(20);
    $this->SetFont('Arial','B',12);
    $this->Cell(22,8,"Date From",1,0,'L');
    $this->Cell(22,8,$this->datefrom,1,0,'C');
    $this->Cell(22,8,"Date To",1,0,'C');
    $this->Cell(22,8,$this->dateto,1,0,'C');
    $this->Cell(22,8,"Organization",1,0,'C');
    $this->Cell(22,8,"?",1,0,'C');
    $this->Ln(10);*/
   $this->Image('upload/images/attlistlogo.jpg', 12 , 10 , 60 , '' , 'JPG' , '');
    $this->Ln();
    $this->SetFont('Arial','B',18);
    $this->SetXY(10,10);
    $this->Cell(0,17," ",1,0,'R');
    $this->SetXY(100,6);
    $this->Cell(0,17,"Fees Collection Report(By Product)",0,0,'R');

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
		$this->organization_name=substr_replace($this->organization_code,"",-1); 
    $this->SetFont('Times','B',9);
    $this->Cell(31,8,"$this->organization_code",1,0,'C');
    $this->Ln(10);
$i=0;

//    $this->SetFont('Times','B',9);
	$header=array('No','User','Student','Date/Time', 'Product',"Category", "Amount($this->cur_symbol)", 'Doc No',"Accum.($this->cur_symbol)");
    $w=array(8,13,49,26,18,18,20,15,24);
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
    $w=array(8,13,49,26,18,18,20,15,24);
	$i=0;


$this->SetFont('Times','',8);
   foreach($data as $row)
    { $i=0;
    	foreach($row as $col) {

        //chop long string to fit in col uname, student name
	
	
	if ($i==2){
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
	  while($this->GetStringWidth($col)>$w[$i]-1)
			$col=substr_replace($col,"",-1);
		$alignment="";

		if ($i<=2)
			$alignment="L";
		else
			$alignment="R";
	
	     $this->Cell($w[$i],6,$col,1,0,"$alignment");
		}
            $i=$i+1;
            }
        $this->Ln();
    }

}
}
include_once 'class/Student.php';
include_once 'class/Employee.php';
include_once 'class/Product.php';
include_once 'class/ProductCategory.php';

//include_once 'class/Organization.php';
include_once './class/Log.php';
$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tableemployee=$tableprefix . "simtrain_employee";
$tableproductlist=$tableprefix . "simtrain_productlist";

$tablecategory=$tableprefix . "simtrain_productcategory";

$tabletuitionclass=$tableprefix . "simtrain_tuitionclass";
$tablestudentclass=$tableprefix . "simtrain_studentclass";
$tableorganization=$tableprefix . "simtrain_organization";
$tablemovement=$tableprefix."simtrain_inventorymovement";
$tableperiod=$tableprefix . "simtrain_period";
$tablepaymentline=$tableprefix."simtrain_paymentline";
$tablepayment=$tableprefix."simtrain_payment";

$tableusers=$tableprefix."users";
$log = new Log();
$e = new Employee ($xoopsDB, $tableprefix, $log);
$c = new ProductCategory ($xoopsDB, $tableprefix, $log);
$p = new Product ($xoopsDB, $tableprefix, $log);

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

	$wherestring="py.payment_datetime between '$pdf->datefrom 00:00:00' and '$pdf->dateto 23:59:59'";

	if($_POST["student_id"] != "0" )
		$wherestring=$wherestring . " AND s.student_id=".$_POST['student_id'];

	if($_POST["uid"] != "0")
		$wherestring=$wherestring . " AND u.uid=".$_POST['uid'];

	if($_POST['product_id'] !='0')
		$productwherestring="AND p.product_id=".$_POST['product_id'];

	if($_POST['category_id'] !='0')
		$categorywherestring="AND c.category_id=" . $_POST['category_id'];

	$getClassProduct="(SELECT p.product_no from $tablestudentclass sc 
				inner join $tabletuitionclass tc on sc.tuitionclass_id=tc.tuitionclass_id
				inner join $tableproductlist p on tc.product_id=p.product_id where
				sc.studentclass_id=pl.studentclass_id $productwherestring and p.product_id>0)";
	$getMovementProduct="(SELECT p.product_no from $tablestudentclass sc 
				inner join $tablemovement m on m.movement_id=sc.movement_id
				inner join $tableproductlist p on m.product_id=p.product_id where
				sc.studentclass_id=pl.studentclass_id $productwherestring and p.product_id>0)";
	$getChargeProduct="(SELECT p.product_no from $tableproductlist p where p.product_id=pl.product_id $productwherestring and p.product_id>0)";

	$getClassCategory="(SELECT c.category_code from $tablestudentclass sc 
				inner join $tabletuitionclass tc on sc.tuitionclass_id=tc.tuitionclass_id
				inner join $tableproductlist p on tc.product_id=p.product_id 
				inner join $tablecategory c on c.category_id=p.category_id where
				sc.studentclass_id=pl.studentclass_id $categorywherestring and p.product_id>0)";
	$getMovementCategory="(SELECT c.category_code from $tablestudentclass sc 
				inner join $tablemovement m on m.movement_id=sc.movement_id
				inner join $tableproductlist p on m.product_id=p.product_id 
				inner join $tablecategory c on c.category_id=p.category_id where
				sc.studentclass_id=pl.studentclass_id $categorywherestring and p.product_id>0)";
	$getChargeCategory="(SELECT c.category_code from $tableproductlist p 
				inner join $tablecategory c on c.category_id=p.category_id where
				p.product_id=pl.product_id $categorywherestring and p.product_id>0)";

	
//	$wherestring="p.payment_datetime between '$pdf->datefrom' and '$pdf->dateto'";
	$sql="select u.uid,u.uname,s.student_name, s.alternate_name, py.payment_datetime AS payment_datetime,".
		" pl.amt-pl.transportamt AS fees,py.receipt_no AS docno,o.organization_code,".
		" coalesce($getClassProduct,$getMovementProduct,$getChargeProduct) as product_name,".
		" coalesce($getClassCategory,$getMovementCategory,$getChargeCategory) as category_name".
		" from $tablepayment py ".
		" join $tablepaymentline pl on pl.payment_id = py.payment_id ".
		" join $tablestudent s on py.student_id = s.student_id ".
		" left join $tableusers u on py.updatedby = u.uid ".
		" join $tableorganization o on o.organization_id = py.organization_id ".
		" where  (pl.amt-pl.transportamt)<>0 and py.iscomplete = 'Y' and py.organization_id=$organization_id AND $wherestring AND ".
		" coalesce($getClassProduct,$getMovementProduct,$getChargeProduct) <>'' AND" .
		" coalesce($getClassCategory,$getMovementCategory,$getChargeCategory)<>'' ".
		" order by py.payment_datetime desc";

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
		$alternate_name=$row['alternate_name'];
		$category_name=$row['category_name'];
		$fees=$row['fees'];
		$product_name=$row['product_name'];
		$pdf->organization_code=$row['organization_code'];
		$returnamt=$row['returnamt'];
		$payment_datetime=$row['payment_datetime'];
		
		$docno=$row['docno'];
		$total=$total+$fees;
		$data[]=array($i,$uname,$alternate_name."|||".$student_name,$payment_datetime,$product_name,$category_name,$fees,$docno,number_format($total,2));
		//$data[]=array($i,"","","","","","","","","","","","","");
		
	}
	
	//print header
	$pdf->SetFont('Arial','',10);
	$pdf->AddUniGBhwFont("uGB");
	$pdf->isUnicode=false;

	$pdf->AddPage();
	//$pdf->MultiCell(0,4,$sql,0,'C');
	$pdf->BasicTable($data);
	//display pdf
	//$pdf->Output("doc.pdf","D");
	$pdf->Output("FeesCollectionByProduct-".$pdf->datefrom."_".$pdf->dateto.".pdf","I");
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
$productctrl=$p->getSelectProduct(-1,'A');
$categoryctrl=$c->getSelectCategory(-1);

echo <<< EOF

<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Fees Collection Report(By Product)</span></big></big></big></div><br>-->
	<table border='1'>
		<tbody>
			<tr><form name='frmincome' action='viewproductincome.php' method='post' target='_blank'>
				<td class='head'>Date From</td>
				<td class='odd'><input name='datefrom' id='datefrom'><input type='button' value='Date' onClick="$showCalender1"></td>
				<td class='head'>Date To</td>
				<td class='odd'><input name='dateto' id='dateto'><input type='button' value='Date' onClick="$showCalender2"></td>
			</tr>
			<tr>
				<td class='head'>Category</td>
				<td class='even'>$categoryctrl</td>
				<td class='head'>Product</td>
				<td class='odd'>$productctrl</td>
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


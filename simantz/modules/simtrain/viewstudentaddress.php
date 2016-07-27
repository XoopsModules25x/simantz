<?php
include_once('fpdf/chinese-unicode.php');
include_once('fpdf/code128barcode.class.php');
include_once "system.php";
//include_once "menu.php";


$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class PDF extends PDF_Unicode
{
  public $student_code="Unknown";
  public $student_name="Unknown"; 
  public $student_id="";
  public $alternate_name="Unknown";
  public $std_form="Unknown";

function Header()
{
	/*
	$this->setXY(8,21);
	$count = 0;
	$j = 0;
	while($count < 21){

	$count++;
	$j++;

	if($j < 3){
	$ln_enter = 0;
	}else{
	$ln_enter = 1;
	$j = 0;
	}

	$this->Cell(60+5,35+2,"",1,$ln_enter,'L');
	}
	*/

} //end of Header

function printTable($data){
//$this->setXY(8,21);
$this->SetFont('Times','',9);

// modify this value to shift cell
$init_x = 8;
$init_y = 12; 
$init_witdh = 63;
$init_height = 5;
$init_enterpage = 21;
$init_gaprow = 5;
$init_gapcolumn = 5;
$init_totalcell = 3;



	$i = 0;
	$k = 0;
	$enter = 0;
	$coor_x = $init_x;
	$coor_y = $init_y;

	
	foreach($data as $row){ 

	if($enter == $init_enterpage){//new page
	$enter = 0;
	$coor_x = $init_x;
	$coor_y = $init_y;
	$k = 0;
	$this->AddPage($this->CurOrientation);
	}

	$i++;
	$k++;
	$enter++;
	$m = 0;
	

		$this->setXY($coor_x,$coor_y);
		foreach($row as $col){
		$m++;
		$this->setX($coor_x);

		if($m == 2){
		$this->isUnicode=true;
		$this->SetFont('uGB','B',9); 
		$this->Cell($init_witdh,$init_height,$col,0,1,'L');
		
		$this->isUnicode=false;
		}else{
		$this->SetFont('Times','',9);
		$this->Cell($init_witdh,$init_height,$col,0,1,'L');
		
		}

		

		}

	if($k < $init_totalcell){
	$coor_x = $coor_x + $init_witdh + $init_gapcolumn; // a = b + c + d => c : total width , d : gap between column
	}else{
	
	if($enter == ($init_totalcell*5) || $enter == ($init_totalcell*6) || $enter == ($init_totalcell*7))
	$init_gaprow_final = $init_gaprow - 1;
	else
	$init_gaprow_final = $init_gaprow;

	$k = 0;
	$coor_x = $init_x;
	$coor_y = $coor_y + (7*$init_height) + $init_gaprow_final; // a = b + c + d => c : total height cell 5 x 7 = 30, d : gap between rows
	}

	}


}

}

function genbarcode($student_code){
      
//        $code = $_REQUEST['code'];
  //      $string = $code;

        
}



$studentid_address=$_POST['studentid_address'];
$isselect=$_POST['isselect'];

$count = count($studentid_address);

$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tablestudentclass=$tableprefix ."simtrain_studentclass";
$tablestandard=$tableprefix."simtrain_standard";
$tableaddress=$tableprefix."simtrain_address";

$pdf=new PDF('P','mm', 'A4');  


$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(false ,7);

$pdf->AddUniGBhwFont("uGB");
$pdf->isUnicode=false;
$data=array();

$i = 0;
while($i < $count){
$i++;
$student_address = "";

$student_id = $studentid_address[$i];
$isselectstudent = $isselect[$i];



if($isselectstudent == "on"){


	$sql = "select * from $tableaddress a, $tablestudent b
		where a.student_id = b.student_id 
		and a.student_id = $student_id 
		and a.address_name = 'Home' limit 1 ";
	
	$query=$xoopsDB->query($sql);
	
	if ($row=$xoopsDB->fetchArray($query)){
	
	/*	
	$alternate_name = $row['alternate_name'];
	if($alternate_name != "" && $alternate_name != "-")
	$alternate_name = " \\ ".$row['alternate_name'];
	else
	$alternate_name = "";

	$student_address .= $row['student_name'];
	$student_address .= $alternate_name."\n";
	$student_address .= $row['no']." ".$row['street1']."\n";
	$student_address .= $row['postcode'].", ".$row['city']."\n";
	$student_address .= $row['state']."\n";
	$student_address .= $row['country']."\n";
	*/

	$student_name = $row['student_name'];
	$alternate_name = $row['alternate_name'];
	$student_address1 = $row['no']." ".$row['street1'];
	$student_address2 = $row['postcode'].", ".$row['city'];
	$student_address3 = $row['state'];
	$student_address4 = $row['country'];
	$student_contact = $row['tel_1'];
	
	//while($j < 45){
	//$j++;
	$data[]=array($student_name,$alternate_name,$student_address1,$student_address2,$student_address3,$student_address4,$student_contact);
	//}

	}



}

}





	$pdf->AddPage();

	$pdf->Header();
	$pdf->printTable($data);

	

	//display pdf
	
	//$pdf->MultiCell(0,5,$isselectstudent,1,'L');
	$pdf->Output("Student Address List","I");
	exit (1);

?>

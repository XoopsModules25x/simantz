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
  public $sum_namecard = 0;

function Header()
{

	
/*
	$countbox = 8;

	$init_x = 10;
	$init_y = 18; 
	$init_witdh = 94;
	$init_height = 7*8+4;

	$this->setXY($init_x,$init_y);
	$count = 0;
	$j = 0;
	while($count < $countbox){
	
	$count++;
	$j++;

	if($j < 2){
	$ln_enter = 0;
	}else{
	$init_y = $init_y + $init_height;
	//$this->setXY($init_x,$init_y);
	$ln_enter = 1;
	$j = 0;
	}

	$this->Cell($init_witdh,$init_height,"",1,$ln_enter,'L');
	}
	
	
	*/

} //end of Header

function PrintBox($coor_x,$coor_y)
{
	
	$init_witdh = 94;
	$init_height = 7*8+4;

	//$this->setXY($init_x,$init_y);
	$this->setXY($coor_x-2,$coor_y-2);

	$this->Cell($init_witdh,$init_height,"",1,0,'L');
	

} //end of PrintBox



function printTable($data){
//$this->setXY(8,21);
$this->SetFont('Times','',9);

// modify this value to shift cell
$init_x = 12;
$init_y = 20; 
$init_witdh = 90;
$init_height = 4;
$init_enterpage = 8;
$init_gaprow = 4;
$init_gapcolumn = 4;
$init_totalcell = 2;



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
	$this->PrintBox($coor_x,$coor_y);

		$this->setXY($coor_x,$coor_y);
		foreach($row as $col){
		
		$m++;
		$this->setX($coor_x+6);
		
		if(!is_int($i/2)&&$m!=6){
		while($this->GetStringWidth($col)> ($init_witdh-25)-1)
		$col=substr_replace($col,"",-1);	
		}

		

		if($m == 2)
		$cell_desc = "Code";
		else if($m == 3)
		$cell_desc = "Name";
		else if($m == 5)
		$cell_desc = "Standard";

		
		if($m == 1 && is_int($i/2)){
	//	$this->Image('./images/namecardbg.jpg', ($coor_x + 1) , ($coor_y + 1) , 25 , '' , 'JPG' , '');
		$this->Image('upload/images/namecardbgback.jpg', ($coor_x +6) , ($coor_y +6) , 90 -12, '' , 'JPG' , '');
		$this->Image("upload/tmp/$col".".png", ($coor_x + 26) , ($coor_y + 44) , 34 , '' , 'PNG' , '');
		unlink("upload/tmp/$col".".png");
		}else if($m == 1){
		$this->Image('upload/images/namecardbg.jpg', ($coor_x +6) , ($coor_y +6) , 90 -12, '' , 'JPG' , '');

		
		$photoname="upload/students/".$col.".jpg";
		if(file_exists($photoname))
		$this->Image("$photoname",($coor_x+65 ) , ($coor_y+25 ) , 18 , '' , 'JPEG' , '');
		//$this->Image($photoname, ($coor_x ) , ($coor_y ) , 90 , '' , 'JPG' , '');
		}
		

		if(is_int($i/2)){
			$this->SetFont('Times','',7);
			$this->setXY($coor_x+6,$coor_y+6);
			
			if($m == 2)
			$this->MultiCell(86,4,$col,0,'L');

			$this->Ln();
			$this->setXY($coor_x,$coor_y+13);
			$this->SetFont('Times','',6);
			if($m == 3)
			$this->MultiCell(86,3,$col ,0,'C');
			

		}else{

			if($m == 4){

			
			$this->Cell($init_witdh-65,$init_height,"Alternate Name",0,0,'L');
		
			$this->isUnicode=true;
			$this->SetFont('uGB','B',8); 
			$this->Cell($init_witdh-25,$init_height,":".$col,0,1,'L');		
			$this->isUnicode=false;
		
			}else if($m == 2 || $m == 3 || $m == 5){
			$this->SetFont('Times','',8);
			$this->Cell($init_witdh-65,$init_height,"$cell_desc",0,0,'L');
			$this->Cell($init_witdh-25,$init_height,": ".$col,0,1,'L');
			
			}else if($m == 1){
			
			$this->Cell($init_witdh,($init_height + 20),"",0,1,'L');
			}else{
			$this->Cell($init_witdh-65,($init_height ),"Address / Tel No.",0,1,'L');
			$this->setXY($coor_x+($init_witdh-65) +6,$coor_y + ($init_height*9+4));
			//$this->Cell($init_witdh-25,($init_height ),": ".$col,1,1,'L');
			$this->MultiCell($init_witdh-25,$init_height,": ".$col,0,'L');
			
			}

		}


		}
	

	if($k < $init_totalcell){
	$coor_x = $coor_x + $init_witdh + $init_gapcolumn; // a = b + c + d => c : total width , d : gap between column
	}else{
	
	$init_gaprow_final = $init_gaprow + (7*$init_height);
	
	$k = 0;
	$coor_x = $init_x;
	$coor_y = $coor_y + (7*$init_height) + $init_gaprow_final; // a = b + c + d => c : total height cell 5 x 7 = 30, d : gap between rows
	}

	}

	$this->sum_namecard = $i;
}

}

function genbarcode($student_code){
      
//        $code = $_REQUEST['code'];
  //      $string = $code;

        
}


function getTuitionAddress($tableprefix,$xoopsDB){
	$tableorganization = $tableprefix."simtrain_organization";
	$tableaddress = $tableprefix."simtrain_address";
	$tablearea = $tableprefix."simtrain_area";
	$org = "";	

	$sql = "select * from $tableorganization a, $tableaddress b, $tablearea c  
		where a.address_id = b.address_id 
		and b.area_id = c.area_id 
		limit 1";
	
	$query=$xoopsDB->query($sql);

	if ($row=$xoopsDB->fetchArray($query)){
	
	/*$org .= $row['address_name']."\n";
	if($row['street1'] != "")
	$org .= $row['no']." ".$row['street1'].",\n";
	if($row['street2'] != "" && $row['street2'] != "-")
	$org .= $row['street2'].",\n";
	if($row['city'] != "")
	$org .= $row['postcode'].", ".$row['city'].",\n";
	if($row['state'] != "")
	$org .= $row['state'].", ".$row['country'].",\n";
	if($row['tel_1'] != "")
	$org .= "Tel No. : ".$row['tel_1'];
	if($row['tel_2'] != "")
	$org .= " / ".$row['tel_2'];
	*/
	$org=$row['studentcard_info'];
	}
	return $org;
}




$studentid_notarray = $_POST['student_id'];
$studentid_address=$_POST['studentid_address'];
$isselect=$_POST['isselect'];

$count = count($studentid_address);

if($studentid_notarray == "")
$count = count($studentid_address);
else
$count = 1;



$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tablestudentclass=$tableprefix ."simtrain_studentclass";
$tablestandard=$tableprefix."simtrain_standard";
$tableaddress=$tableprefix."simtrain_address";
$tablestandard=$tableprefix . "simtrain_standard";
$pdf=new PDF('P','mm', 'A4');  


$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(false ,7);

$pdf->AddUniGBhwFont("uGB");
$pdf->isUnicode=false;
$data=array();

$tuition_address = getTuitionAddress($tableprefix,$xoopsDB);

$i = 0;
while($i < $count){
$i++;
$student_address = "";
$studentinfo = "";
//$slogan = "SLOGAN HERE SLOGAN HERE SLOGAN HERE SLOGAN HERE SLOGAN HERE";

if($studentid_notarray == "")
$student_id = $studentid_address[$i];
else
$student_id = $studentid_notarray;

$isselectstudent = $isselect[$i];




if($isselectstudent == "on" || $studentid_notarray != ""){


	$sql = "select * from $tablestandard a, $tablestudent b, $tableaddress c 
		where a.standard_id = b.standard_id  
		and b.student_id = $student_id 
		and b.student_id = c.student_id 
		and c.address_name = 'Home' 
		limit 1 ";
	
	$query=$xoopsDB->query($sql);
	
	if ($row=$xoopsDB->fetchArray($query)){
	
	//front
	$student_id = $row['student_id'];
	$student_code = $row['student_code'];
	$student_name = $row['student_name'];
	$alternate_name = $row['alternate_name'];
	$standard_name = $row['standard_name'];
	
	$student_address .= $row['no']." ".$row['street1']."\n";
	$student_address .= "  ".$row['postcode'].", ".$row['city']."\n";
	//$student_address .= $row['state']."\n";
	//$student_address .= $row['country']."\n";
	$student_address .= "  ".$row['tel_1'];

	if($row['hp_no']!="")
	$student_address .= "/".$row['hp_no'];

	// back
	$timestamp = date("Y-m-d", time()) ;
	$studentinfo .= "Name : ".$student_name."\n";
	$studentinfo .= "Issue Date : ".$timestamp."\n";
	
	//while($j < 21){
	//$j++;
	$data[]=array($student_id,$student_code,$student_name,$alternate_name,$standard_name,$student_address);
	$data[]=array($student_code,$studentinfo,$tuition_address,"","","");
	//}

	//generate barcode

	$barcode = new code128barcode();
  
        $code = $barcode->output($student_code);

	if ($code) {
        $height = intval(strlen($code) / 7);
        $width = strlen($code);
        $im = imagecreate($width,intval(($height * 1.33) + 6));
        $white = ImageColorAllocate ($im, 255, 255, 255);
        $black = ImageColorAllocate ($im, 0,0,0);
        $code = preg_split('##',$code);
        array_pop($code);
        array_shift($code);
        for($m = 0 ; array_key_exists($m,$code) ; $m++)
            if ($code[$m] == 0)
                imageline($im,$m,0,$m,$height,$white);
            else
                imageline($im,$m,0,$m,$height,$black);
  	$font=ImagePsLoadFont("fpdf/css/URWGothicL-Demi.pfb");
       
        imagepsencodefont ($font,'fpdf/css/latin1.enc');
        $size = ImagePSBbox($string,$font,($height/3));
        $h = ($width - $size[2]) / 2;
        $v = ($height + 18);
        ImagePsText($im, $string,$font, $height/3, $black, $white, $h, $v);
        
        ImagePng ($im,"upload/tmp/$student_code".".png");
        }


	}



}

}


	
	$pdf->AddPage();
	
	$pdf->printTable($data);
	
	

	//display pdf
	
	//$pdf->MultiCell(0,5,$studentid_notarray."aa",1,'L');
	$pdf->Output("Student Address List","I");
	exit (1);

?>

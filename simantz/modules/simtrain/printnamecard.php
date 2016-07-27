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
  public $textleft=12;
  public $texttop=33;
  public $student_code="Unknown";
  public $student_name="Unknown"; 
  public $student_id="";
  public $alternate_name="Unknown";
  public $std_form="Unknown";

function Header()
{
 $this->Image('upload/images/namecardbg.jpg', 10 , 10 , 90 , '' , 'JPG' , '');

//$photoname="upload/students/$this->student_id.jpg";
$photoname="upload/students/0.jpg";

if(file_exists($photoname) ){

	$this->Image("$photoname", 70 , 14 , 25 , '' , 'JPEG' , '');
}
$this->SetFont('Times','',9);
$this->setXY($this->textleft,$this->texttop);
$this->Cell(0,5,"Student No",0,0,'L');
$this->setX($this->textleft+15);
$this->Cell(0,5,":",0,0,'L');
$this->setX($this->textleft+16);
$this->Cell(0,5,$this->student_code,0,0,'L');
$this->Ln();

$this->setX($this->textleft);
  $this->Cell(0,5,"Name",0,0,'L');
$this->setX($this->textleft+15);
$this->Cell(0,5,":",0,0,'L');
$this->setX($this->textleft+16);
    $this->Cell(0,5,$this->student_name,0,0,'L');
$this->Ln();

$this->setX($this->textleft);
  $this->Cell(0,5,"Alt. Name",0,0,'L');
$this->setX($this->textleft+15);
$this->Cell(0,5,":",0,0,'L');
$this->setX($this->textleft+16);
 $this->isUnicode=true;
$this->SetFont('uGB','',10); 
   $this->Cell(0,5,$this->alternate_name,0,0,'L');
	$this->isUnicode=false;
$this->Ln();

$this->SetFont('Times','',9);
$this->setX($this->textleft);
$this->Cell(0,5,"Standard",0,0,'L');
$this->setX($this->textleft+15);
$this->Cell(0,5,":",0,0,'L');
$this->setX($this->textleft+16);
    $this->Cell(0,5,"$this->std_form",0,0,'L');
//include "studentbarcode.php";
//sleep(1);
$this->Image("upload/tmp/$this->student_code".".png", 50 , 54 , 40 , '' , 'PNG' , '');





} //end of Header

}

function genbarcode($student_code){
      
//        $code = $_REQUEST['code'];
  //      $string = $code;

        
    }

$student_id=$_POST['student_id'];

$tableprefix= XOOPS_DB_PREFIX . "_";
$tablestudent=$tableprefix . "simtrain_student";
$tablestudentclass=$tableprefix ."simtrain_studentclass";
$tablestandard=$tableprefix."simtrain_standard";
//$pdf=new PDF('P','mm','a4');
//	$pdf=new PDF('L','mm', array(60,100));  
	$pdf=new PDF('P','mm', 'A4');  
    
 // $pdf->SetFont('Times','B',10);
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(false ,7);
 // $pdf->AddUniCNShwFont('uni');
	$pdf->AddUniGBhwFont("uGB");
	$pdf->isUnicode=false;

$sql="SELECT s.student_id, s.student_code, s.student_name,s.alternate_name, std.standard_name as standard from $tablestudent s inner join $tablestandard std on std.standard_id=s.standard_id WHERE student_id=$student_id";
$query=$xoopsDB->query($sql);
if ($row=$xoopsDB->fetchArray($query)){
$pdf->student_id=$row['student_id'];
$pdf->student_code=$row['student_code'];
$pdf->student_name=$row['student_name'];
$pdf->alternate_name=$row['alternate_name'];
	$pdf->std_form=$row['standard'];}


	$barcode = new code128barcode();
  
        $code = $barcode->output($pdf->student_code);
//	$code='123456'; 
	if ($code) {
        $height = intval(strlen($code) / 7);
        $width = strlen($code);
        $im = imagecreate($width,intval(($height * 1.33) + 6));
        $white = ImageColorAllocate ($im, 255, 255, 255);
        $black = ImageColorAllocate ($im, 0,0,0);
        $code = preg_split('##',$code);
        array_pop($code);
        array_shift($code);
        for($i = 0 ; array_key_exists($i,$code) ; $i++)
            if ($code[$i] == 0)
                imageline($im,$i,0,$i,$height,$white);
            else
                imageline($im,$i,0,$i,$height,$black);
   $font=ImagePsLoadFont("fpdf/css/URWGothicL-Demi.pfb");
       
     //   $font=ImagePsLoadFont("fpdf/css/URWGothicL-Demi.pfb");
        imagepsencodefont ($font,'fpdf/css/latin1.enc');
        $size = ImagePSBbox($string,$font,($height/3));
        $h = ($width - $size[2]) / 2;
        $v = ($height + 18);
        ImagePsText($im, $string,$font, $height/3, $black, $white, $h, $v);
        
        //header ("Content-type: image/png");
        //header ("Content-disposition: inline; filename=studentbarcode.png");
        ImagePng ($im,"upload/tmp/$pdf->student_code".".png");
        }




	$pdf->AddPage();

	//$pdf->Header();

	//display pdf
	$pdf->Output("$pdf->student_name.pdf","I");
	unlink("upload/tmp/$pdf->student_code".".png");
	exit (1);

?>

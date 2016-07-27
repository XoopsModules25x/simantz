<?php
include_once('../../class/fpdf/fpdf.php');
include_once "system.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$bpartner_array=$_POST['bpartner_array'];
$checkbox_array=$_POST['checkbox_array'];
$reporttype=$_POST['reporttype'];

$count = count($studentid_address);


$pdf=new FPDF('P','mm', 'A4');  


$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true ,15);
$data=array();
$pdf->AddPage();

/*
$marginx=10;
$marginy=10;
$pagefooterheight=15;
$width=63;
$nocontactheight=30;
$withcontactheight=40;

$i = 0;
//$bpartner_array=array(1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10,1,2,3,4,5,6,7,8,9,10);

if($reporttype=="ac")
	$height=$withcontactheight;
else
	$height=$nocontactheight;


foreach($bpartner_array as $bpartner_id){
$rowcount=ceil($i/2);
$colcount=$i % 3;
$xpost= $marginx + $width * $colcount;
$ypost= $marginy + $height * $rowcount;

if($checkbox_array[$i] == "on")
$pdf->Rect($xpost,$ypost,$width,$height);

//$pdf->MultiCell(0,5,"$bpartner_id",0,'L');


$i++;
}
	*/

$cell_height = 4;

if($reporttype=="ac"){
$height=$cell_height*7;
$max_page = 28;
}else{
$height=$cell_height*6;
$max_page = 34;
}

$current_x = 10;
$current_y = 10;
$width = 64;
$rowline_count = 0;
$address = "";
$i = 0;
$label_count = 0;


foreach($bpartner_array as $bpartner_id){
	
	if($checkbox_array[$i] == "on"){

//$j = 0;
//while($j < 20){
//$j++;
	$label_count++;
	if($label_count == $max_page){

	$pdf->AddPage($pdf->CurOrientation);
	if($reporttype=="ac")
	$height=$cell_height*7;
	else
	$height=$cell_height*6;

	$current_x = 10;
	$current_y = 10;
	$width = 64;
	$rowline_count = 0;
	$address = "";
	$i = 0;
	$label_count = 1;
	}


	$address = "";
	if($rowline_count < 3){
	}else{
	$rowline_count = 0;
	$current_x = 10;
	$current_y += $height;
	}
	$rowline_count++;

	$pdf->setXY($current_x,$current_y);
	$current_x += $width;

	$sql = "select * from $tablebpartner a, $tablecountry b 
	where a.bpartner_id = $bpartner_id 
	and a.country_id = b.country_id ";

	$query=$xoopsDB->query($sql);
	$data=array();
	//get data detail
	if ($row=$xoopsDB->fetchArray($query)){
	
	$bpartner_name = $row["bpartner_name"];
	$bpartner_street1 = $row["bpartner_street1"];
	$bpartner_street2 = $row["bpartner_street2"];
	$bpartner_street3 = $row["bpartner_street3"];
	$bpartner_postcode = $row["bpartner_postcode"];
	$bpartner_city = $row["bpartner_city"];
	$bpartner_state = $row["bpartner_state"];
	$country_name = $row["country_name"];
	$contact = "Tel No : ".$row["bpartner_tel_1"]." HP No : ".$row["bpartner_hp_no1"];
	
	}
	$address .= "$bpartner_name"."\n";
	$address .= "$bpartner_street1";

	if($bpartner_street2 != "")
	$address .= ",".$bpartner_street2."\n";
	else
	$address .= "\n";

	
	$address .= "$bpartner_street3"."\n";
	$address .= "$bpartner_postcode".","."$bpartner_city"."\n";
	$address .= "$bpartner_state".","."$country_name"."\n";

	if($reporttype=="ac")
	$address .= "$contact";

	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell($width,$cell_height,$address,1,'L');
	}
//}
	
	$i++;

}

	//$pdf->MultiCell(0,5,"$sql",0,'L');

	//display pdf
//	$pdf->SetFont('Arial','',10);
	//$pdf->MultiCell(0,5,$reporttype,1,'L');
	$pdf->Output("BpartnerAddressLabel","I");
	exit (1);

?>
<?php
	include "system.php";
	$action=$_GET['action'];
	if(!isset($action) || $action=='create'){
	include "class/Accounts.php";

	include "../simantz/class/pchart/pChart/pData.class";
	include "../simantz/class/pchart/pChart/pChart.class";
	include "../simantz/class/Period.inc.php";

	$period=new Period();
	$acc= new Accounts();
	//$oriyear= date("Y",time());
	//$orimonth=date("m",time());
	//$oriyear=2008;
	//$orimonth=8;
	$orimonth=right(left(getDateSession(),7),2);
	$oriyear=left(getDateSession(),4);

	//$period1=$period->getPeriodID($year,$month);
	
	for($i=5;$i>=0;$i--){
	$year= $oriyear;
	$month=$orimonth-$i;
	if($month<=0){
	$month=$month+12;
	$year=$year-1;
	}
	//$period1=$period->getPeriodID($year,$month);
	eval("\$period".(5-$i)."=".$period->getPeriodID($year,$month).";");
	eval("\$periodname".(5-$i)."=\$year.'-'.\$month;");
	
	
	}



		$sales0=$acc->getSalesInPeriod($period0);
		$expenses0=$acc->getCOGSAndExpensesInPeriod($period0);

		$sales1=$acc->getSalesInPeriod($period1);
		$expenses1=$acc->getCOGSAndExpensesInPeriod($period1);

		$sales2=$acc->getSalesInPeriod($period2);
		$expenses2=$acc->getCOGSAndExpensesInPeriod($period2);

		$sales3=$acc->getSalesInPeriod($period3);
		$expenses3=$acc->getCOGSAndExpensesInPeriod($period3);

		$sales4=$acc->getSalesInPeriod($period4);
		$expenses4=$acc->getCOGSAndExpensesInPeriod($period4);

		$sales5=$acc->getSalesInPeriod($period5);
		$expenses5=$acc->getCOGSAndExpensesInPeriod($period5);
/*echo <<< EOF
$period0,$periodname0,$sales0,$expenses0<br/>
$period1,$periodname1,$sales1,$expenses1<br/>
$period2,$periodname2,$sales2,$expenses2<br/>
$period3,$periodname3,$sales3,$expenses3<br/>
$period4,$periodname4,$sales4,$expenses4<br/>
$period5,$periodname5,$sales5,$expenses5<br/>
EOF;
*/
        $DataSet = new pData;

	$DataSet->AddPoint(array($sales0,$sales1,$sales2,$sales3,$sales4,$sales5),"Serie1");
	 $DataSet->AddPoint(array($expenses0,$expenses1,$expenses2,$expenses3,$expenses4,$expenses5),"Serie2");
	 $DataSet->AddPoint(array($periodname0,$periodname1,$periodname2,$periodname3,$periodname4,$periodname5),"Serie3");
	 $DataSet->AddSerie("Serie1");
	 $DataSet->AddSerie("Serie2");
	 $DataSet->SetAbsciseLabelSerie("Serie3");
	 $DataSet->SetSerieName("Sales","Serie1");
 	 $DataSet->SetSerieName("Expenses","Serie2");
	 $DataSet->SetYAxisName("Amount($defcurrencycode)");
	// $DataSet->SetYAxisUnit("RM");

	$Test = new pChart(700,230);
	 $Test->setFontProperties("../system/class/pchart/Fonts/tahoma.ttf",8);
	 $Test->setGraphArea(65,30,650,200);
	 $Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);
	 $Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);
	 $Test->drawGraphArea(255,255,255,TRUE);
	 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);
	 $Test->drawGrid(4,TRUE,230,230,230,50);
  
 // Draw the title
	 $Test->setFontProperties("../simantz/class/pchart/Fonts/pf_arma_five.ttf",8);
	 $Title = "Sales Vs Expenses For $defaultorganization_name";
	 $Test->drawTextBox(65,10,650,25,$Title,0,255,255,255,ALIGN_CENTER,TRUE,0,0,0,30);
  
 // Draw the line graph
	 $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
	 $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,254,254,254);
  
 // Draw the legend
	 $Test->setFontProperties("../simantz/class/pchart/Fonts/tahoma.ttf",8);
	 $Test->drawLegend(610,150,$DataSet->GetDataDescription(),254,254,254);

 // Render the chart
	$photofile="chartcache/salesexpenses_6month.png";
	 $Test->Render($photofile);
//	$chart->setTitle("Sales Vs Expenses For $defaultorganization_name");
//	$chart->getPlot()->setGraphCaptionRatio(0.62);
//	$chart->render("chart/generated/salesexpenses_6month.png");
    if($action!="create"){

	header('Content-type: image/png');
	
	if(!file_exists($photofile)){
	$photofile="chartcache/chart0.png";
	$image=ImageCreateFromPNG($photofile);
	imagepng($image);
	imagedestroy($image);
	}
	else{
	//$photofile="chartcache/chart0.png>";
	$image=ImageCreateFromPNG($photofile);
	imagepng($image);
	imagedestroy($image); 
	unlink($photofile);
	}
}else{
	//header('Content-type: text/png');
	if(!file_exists($photofile))
	echo "cannot create chart!";
	else
	echo "Browse to chartcache/chartissue_byprogrammer.png to check image.";

	}
}
else
{ echo "Cache removed";
unlink("chartcache/salesexpenses_6month.png"); }
?>


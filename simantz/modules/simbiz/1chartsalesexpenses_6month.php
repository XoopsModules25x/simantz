<?php
	include "system.php";
	include "class/Accounts.php";
	include "chart/libchart/classes/libchart.php";
	include "../system/class/Period.php";

	$period=new Period();
	$acc= new Accounts();
	$year= date("Y",time());
	$month=date("m",time());
	$year=2009;
	$month=6;
	
	$period1=$period->getPeriodID($year,$month);
	
	for($i=0;$i<6;$i++){
	$year= date("Y",time());
	$month=date("m",time()-$i);
	if($month<=0){
	$month=$month+12;
	$year=$year-1;
	}
	//$period1=$period->getPeriodID($year,$month);
	eval('$period'.(6-$i)."=".$period->getPeriodID($year,$month).';');
	eval('$periodname'.(6-$i)."=".$year.'-'.$month.';');
	
	}

	echo "\n".$sales1=$acc->getSalesInPeriod($period1);
	echo "\n".	$expenses1=$acc->getCOGSAndExpensesInPeriod($period1);

	echo "\n".	$sales2=$acc->getSalesInPeriod($period2);
	echo "\n".	$expenses2=$acc->getCOGSAndExpensesInPeriod($period2);

	echo "\n".	$sales3=$acc->getSalesInPeriod($period3);
	echo "\n".	$expenses3=$acc->getCOGSAndExpensesInPeriod($period3);

	echo "\n".	$sales4=$acc->getSalesInPeriod($period4);
	echo "\n".	$expenses4=$acc->getCOGSAndExpensesInPeriod($period4);

	echo "\n".	$sales5=$acc->getSalesInPeriod($period5);
	echo "\n".	$expenses5=$acc->getCOGSAndExpensesInPeriod($period5);

	echo "\n".	$sales6=$acc->getSalesInPeriod($period6);
	echo "\n".	$expenses6=$acc->getCOGSAndExpensesInPeriod($period6);
/*	$chart = new LineChart();

	$serie1 = new XYDataSet();
	$serie1->addPoint(new Point($periodname1, $sales1));
	$serie1->addPoint(new Point($periodname2, $sales2));
	$serie1->addPoint(new Point($periodname3, $sales3));
	$serie1->addPoint(new Point($periodname4, $sales4));
	$serie1->addPoint(new Point($periodname5, $sales5));
	$serie1->addPoint(new Point($periodname6, $sales6));
	
	$serie2 = new XYDataSet();
	$serie2->addPoint(new Point($periodname1, $expenses1));
	$serie2->addPoint(new Point($periodname2, $expenses2));
	$serie2->addPoint(new Point($periodname3, $expenses3));
	$serie2->addPoint(new Point($periodname4, $expenses4));
	$serie2->addPoint(new Point($periodname5, $expenses5));
	$serie2->addPoint(new Point($periodname6, $expenses6));
	
	
	$dataSet = new XYSeriesDataSet();
	$dataSet->addSerie("Sales", $serie1);
	$dataSet->addSerie("Expenses", $serie2);
	$chart->setDataSet($dataSet);

	$chart->setTitle("Sales Vs Expenses For XYZ");
	$chart->getPlot()->setGraphCaptionRatio(0.62);
	$chart->render("chart/generated/salesexpenses_6month.png");
	header('Content-type: image/png');
	$photofile="chart/generated/salesexpenses_6month.png";

	if(!file_exists($photofile))
	$photofile="chart/generated/chart0.png>";

	$image=ImageCreateFromPNG($photofile);
	imagepng($image);
	imagedestroy($image); */

?>


<?php
	include "system.php";
	$action=$_GET['action'];
	if(!isset($action) || $action=='create'){


	include "../simantz/class/pchart/pChart/pData.class";
	include "../simantz/class/pchart/pChart/pChart.class";



	//$oriyear= date("Y",time());
	//$orimonth=date("m",time());
	//$oriyear=2008;
	//$orimonth=8;
	$orimonth=right(left(getDateSession(),7),2);
	$oriyear=left(getDateSession(),4);

        $p=array();
        $arrtotalqty=array();
	//$period1=$period->getPeriodID($year,$month);

	for($i=5;$i>=0;$i--){
            $year= $oriyear;
            $month=$orimonth-$i;
            if($month<=0){
                    $month=$month+12;
                    $year=$year-1;
            }
            if(strlen($month)==1)
                $month="0".$month;
            //$period1=$period->getPeriodID($year,$month);



         $curperiodname=$year.'-'.$month;

        array_push($p,$year.'-'.$month);
        $sql="SELECT '$curperiodname',coalesce(count(localamt),0) as totalqty
                FROM sim_bpartner_quotation q
                where q.iscomplete=1 and  left(CAST( q.document_date AS CHAR),7)='$curperiodname'
                group by left(CAST( q.document_date AS CHAR),7)";
                $query=$xoopsDB->query($sql);
                if($row=$xoopsDB->fetchArray($query)){
                   array_push($arrtotalqty,$row['totalqty']);

                }else
                   array_push($arrtotalqty,0);
	}

//print_r($arrtotalamt);
//print_r($p);
//echo "?? $minquoteamtinmonth ???";
//die;
        $DataSet = new pData;

	$DataSet->AddPoint(array($arrtotalqty[0],$arrtotalqty[1],$arrtotalqty[2],$arrtotalqty[3],$arrtotalqty[4],$arrtotalqty[5]),"Serie1");
	 $DataSet->AddPoint(array($minquoteqtyinmonth,$minquoteqtyinmonth,$minquoteqtyinmonth,$minquoteqtyinmonth,$minquoteqtyinmonth,$minquoteqtyinmonth),"Serie2");
	 $DataSet->AddPoint(array($p[0],$p[1],$p[2],$p[3],$p[4],$p[5]),"Serie3");
	 $DataSet->AddSerie("Serie1");
	 $DataSet->AddSerie("Serie2");
	 $DataSet->SetAbsciseLabelSerie("Serie3");
	 $DataSet->SetSerieName("Qty","Serie1");
 	 $DataSet->SetSerieName("Control ($minquoteqtyinmonth)","Serie2");
	 $DataSet->SetYAxisName("Qty");
	// $DataSet->SetYAxisUnit("RM");

	$Test = new pChart(600,230);

	 $Test->setFontProperties("../simantz/class/pchart/Fonts/tahoma.ttf",8);
	 $Test->setGraphArea(65,30,550,200);
	 $Test->drawFilledRoundedRectangle(7,7,593,223,5,240,240,240);
	 $Test->drawRoundedRectangle(5,5,595,225,5,230,230,230);
	 $Test->drawGraphArea(255,255,255,TRUE);
	 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);
	 $Test->drawGrid(4,TRUE,230,230,230,50);
          $Test->writeValues($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie1");
 // Draw the title
	 $Test->setFontProperties("../simantz/class/pchart/Fonts/pf_arma_five.ttf",8);
	 $Title = "QUotation Qty Vs Time For $defaultorganization_name";
	 $Test->drawTextBox(65,10,550,25,$Title,0,255,255,255,ALIGN_CENTER,TRUE,0,0,0,30);

 // Draw the line graph
	 $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
	 $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,254,254,254);

 // Draw the legend
	 $Test->setFontProperties("../simantz/class/pchart/Fonts/tahoma.ttf",8);
	 $Test->drawLegend(10,150,$DataSet->GetDataDescription(),254,254,254);
 // Render the chart
	$photofile=$uploadpath."chartsalequoteamt_6month.png";

	 $Test->Render($photofile);
//	$chart->setTitle("Sales Vs Expenses For $defaultorganization_name");
//	$chart->getPlot()->setGraphCaptionRatio(0.62);
//	$chart->render("chart/generated/salesexpenses_6month.png");
    if($action!="create"){

	header('Content-type: image/png');


	//$photofile="chartcache/chart0.png>";
	$image=ImageCreateFromPNG($photofile);
	imagepng($image);
	imagedestroy($image);
	//unlink($photofile);

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
//unlink($photofile);

}

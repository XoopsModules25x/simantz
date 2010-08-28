<?php

	include_once "system.php";
        
	include_once "../simantz/class/Organization.php";
	include_once "../simantz/class/Period.inc.php";

	include_once "class/Accounts.php";

        $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');

	$org = new Organization();

	$acc = new Accounts();
        $header=array("Accounts","","");
        $w=array(130,30,30);
        $papertype="A4";



if($_POST['action']=='reloadchart'){

          $organization_id=$_REQUEST['organization_id'];

          $seriesname=explode("|||",$_POST['seriesname']);
          $allvalue=explode("|||",$_POST['allvalue']);

          $allmonth=explode(",",$_POST['allmonth']);
          $k=0;
          foreach($allmonth as $m){
              $allmonth[$k]=right($m,5);
              $k++;
          }
            include "../simantz/class/pchart/pChart/pData.class";
            include "../simantz/class/pchart/pChart/pChart.class";
          $DataSet = new pData;
          $i=0;

         foreach($allvalue as $rowarray){
         $i++;
         $tmpvalue=array();
         $arrvalue=explode(",",$rowarray);
         $DataSet->AddPoint($arrvalue,"Serie".$i);

         }
         $i++;
         $seriesname_i=$i;
	 $DataSet->AddPoint($seriesname,"Serie".$i);

         $i++;
         $allmonth_i=$i;
	 $DataSet->AddPoint($allmonth,"Serie".$i);

         $i++;
         for($j=1;$j<$i-2;$j++)
	 $DataSet->AddSerie("Serie".$j);

	 $DataSet->SetAbsciseLabelSerie("Serie".$allmonth_i);
         $z=0;
         foreach($seriesname as $currentseriesname){
         $z++;
	 $DataSet->SetSerieName($currentseriesname,"Serie".$z);
         }
 	// $DataSet->SetSerieName("Expenses","Serie2");
	 $DataSet->SetYAxisName("Amount($defcurrencycode)");
         $Test = new pChart(800,330);
	 $Test->setFontProperties("../system/class/pchart/Fonts/tahoma.ttf",8);
	 $Test->setGraphArea(65,30,650,300);
	 $Test->drawFilledRoundedRectangle(7,7,793,325,5,254,254,254);
	 $Test->drawRoundedRectangle(5,5,794,325,5,130,130,10);
	 $Test->drawGraphArea(254,254,254,TRUE);
	 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);
	 $Test->drawGrid(4,TRUE,230,230,230,50);

 // Draw the title
	 $Test->setFontProperties("../system/class/pchart/Fonts/pf_arma_five.ttf",10);
	 $Title = "Chart Generator From Income Statement($defaultorganization_name)";
	 $Test->drawTextBox(65,12,650,25,$Title,0,0,0,1,ALIGN_CENTER,FALSE,254,254,254,30);

 // Draw the line graph
	 $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
	 $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,254,254,254);

 // Draw the legend
	 $Test->setFontProperties("../system/class/pchart/Fonts/tahoma.ttf",8);
	 $Test->drawLegend(655,20,$DataSet->GetDataDescription(),254,254,254);

 // Render the chart
    $random=rand();
	$photofile="chartcache/incomestatementchartgenerated$random.png";
	 $Test->Render($photofile);

         echo $photofile;
         /*
echo <<< EOF
start
<script type="text/javascript">
 self.parent.document.getElementById("divchart").innerHTML="<img src='chartcache/chart0.png'>";
    self.parent.document.getElementById("divchart").innerHTML="<img src='imagerenderer.php?file=$photofile'>";
</script>
EOF;
          * 
          */
    die;
}else{
    include_once "menu.php";
}


echo "<iframe src='htmlincomestatement_chartgenerator.php' name='nameValidate' id='idValidate' style='display:none' width='100%'></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";



   $datefrom="Unknown";
   $dateto="Unknown";
   $marginx= 10 ;
   $marginy= 10 ;
   $pageheaderheight= 80 ;
   $pagefooterheight= 15 ;
 //  $reversepagefooterheight= 245 ;

   $pagewidth=180;

   $tableheadertype="TB";
//   $orginfo_startx=array(60,60);
//   $orginfo_starty=array(10,10);

   $showaccountcode=0;
   $showplacefolderindicator=1;
   $defaultfont="Times";
   $defaultfontsize="10";
   $defaultfontheight="5";
   $defaultfontstyle=0;


   $headerorgseparator=2; //Space below organization info


   $reporttitle = "Income Statement";
   $reporttitlefont="Times";
   $reporttitlefontsize="10";
   $reporttitlefontheight="5";
   $reporttitlefontstyle="UB";


   $month_term_date_posx=array(150,160);


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

function pageHeader(){
    global $organization_code;
     echo <<<EOF

 <h1 style='text-align: center'>Chart Generator For Income Statement</h1>Organization : $organization_code<br>



 <div id='divchart' style='text-align: center'><img src='chartcache/chart0.png'></div>
  <script type='text/javascript'>




  function reloadChart(){
    var rowcount=document.getElementById("rowcount").value;
    var colcount=document.getElementById("colcount").value;

    var divchart=document.getElementById("divchart");

    var seriesname="";
    var allvalue="";
    var r=0;
  for(i=0;i<rowcount;i++){
    var chk=document.getElementById("chk"+i);
    if(chk!=null)
    if(chk.checked==true){
	
        r++;
        if(r==1)
        seriesname=chk.name;
        else
        seriesname=seriesname+'|||'+chk.name;

        rowallvalue="";

        for(j=0;j<colcount;j++){
            currentvalue=document.getElementById("value"+i+"_"+j).value;
            if(currentvalue=="")
                currentvalue=0;

                if(j==0)
                rowallvalue=currentvalue;
                else
                rowallvalue=rowallvalue+","+currentvalue;
            }

     if(r==1)
         allvalue=rowallvalue;
        else
         allvalue=allvalue+"|||"+rowallvalue;
    }

}
//  htmltext=htmltext+"<input name='submit' value='submit' type='submit'></form>";
//divchart.innerHTML="<img src='chartincomestatment.php'>"+seriesname;
allmonth="";
 for(j=0;j<colcount;j++){
            currentmonth=document.getElementById("period_"+j).value;

                if(j==0)
                allmonth=currentmonth;
                else
                allmonth=allmonth+","+currentmonth;
            }



    //var arr_fld=new Array("action","seriesname","allvalue","allmonth");//name for POST
    //var arr_val=new Array("reloadchart",seriesname,allvalue,allmonth);//value for POST

    //getRequest(arr_fld,arr_val);

    var data = "action=reloadchart&seriesname="+seriesname+"&allvalue"+allvalue+"&allmonth="+allmonth;
    $.ajax({
         url: "htmlincomestatement_chartgenerator.php",type: "POST",data: data,cache: false,
             success: function (xml) {
                document.getElementById("divchart").innerHTML="<img src='chartcache/chart0.png'>";
                document.getElementById("divchart").innerHTML="<img src='imagerenderer.php?file="+xml+"'>";
        }});
        

//document.getElementById("form1").submit.click();
}



  function clearAll(){
     var rowcount=document.getElementById("rowcount").value;
    for(i=0;i<rowcount;i++){
    chk=document.getElementById("chk"+i);
    if(chk!=null)
   chk.checked=false;
    }
  var divchart=document.getElementById("divchart");
    divchart.innerHTML="<img src='chartcache/chart0.png'>";
   }
</script>
EOF;

 }



if (isset($_POST["submit"])){



//	$pdf=new PDF('P','mm',$papertype[$statementpapersource]);  //0=A4,1=Letter
	//$pdf=new PDF('P','mm',"A4");  //0=A4,1=Letter
	////$pdf->AliasNbPages();
	////$pdf->SetAutoPageBreak(true,40 + 1 );

        $organization_id=$_REQUEST['organization_id'];
        
	$org->fetchOrganization($defaultorganization_id);
	$companyno=$org->companyno;
	$orgname=$org->organization_name;
        $organization_code=$org->organization_code;
	$orgstreet1=$org->street1;
	$orgstreet2=$org->street2;
	$orgstreet3=$org->street3;
	$orgcity=$org->city;
	$orgstate=$org->state;
	$orgcountry_name=$org->country_name;
	$orgemail=$org->email;
	$orgurl=$org->url;
	$orgtel1=$org->tel_1;
	$orgtel2=$org->tel_2;
	$orgfax=$org->fax;

	$periodfrom_id=$_POST['periodfrom_id'];
	$periodto_id=$_POST['periodto_id'];
        $period=new Period();
        $arrayperiod=$period->getPeriodArray($periodfrom_id,$periodto_id);
	$reportlevel=$_POST['reportlevel'];
	$showzero=$_POST['showzero'];
	$showaccountcode=$_POST['showaccountcode'];
        $m=0;
        $allsubsql="";
        $hiddenctrlstyle="onclick=alert(this.id) type='hidden'";
       echo "<table border='1'>";

       echo "<tr>";
       echo "<td><a onclick='clearAll()' title='Clear all marks'>[X]</a></td><td><B><U>Account</U></B></td>";
	foreach($arrayperiod as $id){
            if($period->fetchPeriod($id)){

             $monthname[$m]=$period->period_name;
	     $monthid[$m]=$id;
             echo "<td style='text-align:right'><b><u>$period->period_name
                        <input $hiddenctrlstyle id='period_$m' value='$period->period_name'></u></b></td>";
             $allsubsql.="case when (SELECT sum(t.amt) FROM $tablebatch b
                    inner join $tabletransaction t on t.batch_id=b.batch_id
                    where t.accounts_id=a.accounts_id and b.period_id=$id and b.iscomplete=1 and  t.branch_id = $organization_id) is null
		then 0 else (SELECT sum(t.amt) FROM $tablebatch b
                    inner join $tabletransaction t on t.batch_id=b.batch_id
                    where t.accounts_id=a.accounts_id and b.period_id=$id and b.iscomplete=1 and  t.branch_id = $organization_id) end
		 as transactionamt".$m.",";

            }
            $m++;
        }
        echo "</tr>";
        $allsubsql=substr_replace($allsubsql,"",-1);
	if($showaccountcode=="on")
	$orderby = "ORDER BY ac.classtype,a.accountcode_full";
	else
	$orderby = "ORDER BY ac.classtype,a.accountcode_full,a.placeholder desc,a.accounts_name";


	$sql="SELECT a.accountcode_full,a.accounts_id,a.accounts_name,ac.classtype, a.treelevel,a.placeholder,
            a.parentaccounts_id,hierarchy,
                $allsubsql
		FROM $tableaccounts a
		INNER JOIN $tableaccountgroup ag on ag.accountgroup_id=a.accountgroup_id
		INNER JOIN $tableaccountclass ac on ag.accountclass_id=ac.accountclass_id
		WHERE ac.classtype in ('1S','2C','3O','4X')
		$orderby ";

	$query=$xoopsDB->query($sql);
	////$pdf->AddPage();
        pageHeader();

	$prefix="";
	$currentcategory="1S";
	$grossprofit=array();
	$totalsales=array();
	$totalcost=array();
	$totalexpenses=array();
	$totalotherincome=array();
	$netprofit=array();
        $r=0;
	while($row=$xoopsDB->fetchArray($query)){
		$accountcode_full=$row['accountcode_full'] ;

		$placeholder=$row['placeholder'];
		$accounts_id=$row['accounts_id'];
		$classtype=$row['classtype'];
		$hierarchy=explode(']',$row['hierarchy']);
                $treelevel=sizeof($hierarchy)-1;
                //skip to next record if found current record is not under this level
                if($treelevel>$reportlevel){
		   
                    continue;
		}
                $accounts_name=$row['accounts_name'];
		for($k=0;$k<$m;$k++)
		$transactionamt[$k]=$row['transactionamt'.$k];

	  if($showaccountcode=="on")
		$accounts_name=$accountcode_full . '-'.$accounts_name;

	//put prefix at parent account
	  if($treelevel==1)
		$prefix="";
	  elseif($treelevel==2)
		$prefix="&nbsp;&nbsp;&nbsp;&nbsp;";
	  elseif($treelevel==3)
		$prefix="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	  elseif($treelevel==4)
		$prefix="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

	//if display folder indicator = 1, account with placeholder=1 will display as [account]

		$displaytext=$prefix.$accounts_name;



	  if($placeholder==0 ){
              for($k=0;$k<$m;$k++)
              if($classtype=="1S" || $classtype=="3O")
		$displayamt[$k]=number_format($transactionamt[$k]*-1,0,".","");
              else
		$displayamt[$k]=number_format($transactionamt[$k],0,".","");
		}
	  elseif($placeholder==1  && $treelevel<$reportlevel){
              for($k=0;$k<$m;$k++)
		$displayamt[$k]="";
		}
	  else{
              for($k=0;$k<$m;$k++){
                 // $acc->($datefrom1,$dateto1,$accounts_id,0);
                 $datefrom=$monthname[$k]."-01";
                 $dateto=getLastDayByMonth($monthname[$k]);
		$transactionamt[$k]=$acc->getAccountDateRangeValue($datefrom,$dateto,$accounts_id,0,$organization_id);
		//$transactionamt2=$acc->getAccountsPeriodBalance($periodto_id,$accounts_id,0);
              if($classtype=="1S" || $classtype=="3O")
		$displayamt[$k]=number_format($transactionamt[$k]*-1,0,".","");
              else
		$displayamt[$k]=number_format($transactionamt[$k],0,".","");
		}

		}

                $tmparray=array();
                $data=array($prefix.$displaytext);
                for($k=0;$k<$m;$k++)
                $data[]=$displayamt[$k];


		switch($classtype){
		  case "1S":
			for($k=0;$k<$m;$k++)
			$totalsales[$k]=$totalsales[$k]+$transactionamt[$k];


		  break;
		  case "2C":
			for($k=0;$k<$m;$k++)
			$totalcost[$k]=$totalcost[$k]+$transactionamt[$k];

		  break;
		  case "3O":
			for($k=0;$k<$m;$k++)
			$totalotherincome[$k]=$totalotherincome[$k]+$transactionamt[$k];
		  break;
		  case "4X":
			for($k=0;$k<$m;$k++)
			$totalexpenses[$k]=$totalexpenses[$k]+$transactionamt[$k];
		  break;

		}

	//when reach new category, print the summary
	  if($currentcategory !=$classtype){
		//$ypos=//$pdf->GetY();
		//$pdf->Line($w[0],$ypos,$marginx+$w[0]+$w[1]+$w[2],$ypos);
		//$pdf->SetFont($defaultfont,'',$defaultfontsize);
		//$pdf->Cell($w[0],$defaultfontheight,"",0,0,"L");
  	  //echo $accounts_name .",";
		$summaryamt="";
		switch($currentcategory){
		  case "1S":
                      $summaryamt=array();
			for($k=0;$k<$m;$k++)
                        $summaryamt[$k]=number_format(($totalsales[$k]*-1),0,".","");
//			$summaryamt[$k]=number_format(($totalsales[$k]*-1),2,".","") ;
			//echo $summaryamt.",";

                        echo "<tr><td></td>";
                        echo "<td>---------</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>------</td>";
                        echo "</tr>";

                        echo "<tr><td><input type='checkbox' name='Total Sales' id='chk$r' title='Total Sales($r)' onclick='reloadChart()'></td>";

                        echo "<td>Total Sales</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>".$summaryamt[$k].
                            "<input $hiddenctrlstyle id='value".$r."_".$k."' value='".$summaryamt[$k]."'>".
                        "</td>";
                        $r++;
                        echo "</tr>";
                        echo "<tr><td>&nbsp;</td></tr><tr>";
			//$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");
			//$summaryamt=changeNegativeNumberFormat($totalsales2,2);
			//$pdf->Cell($w[2],$defaultfontheight,$summaryamt,0,0,"R");
		  break;
		  case "2C":
                        $summaryamt=array();
			for($k=0;$k<$m;$k++)
			$summaryamt[$k]=number_format($totalcost[$k],0,".","");
                        echo "<tr><td></td>";
                        echo "<td>---------</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>------</td>";

                        echo "</tr>";
                        echo "<tr><td><input type='checkbox' name='Total COGS' title='Total COGS($r)' id='chk$r' onclick='reloadChart()'></td>";

                        echo "<td>Total COGS</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>".$summaryamt[$k].
                            "<input $hiddenctrlstyle id='value".$r."_".$k."' value='".$summaryamt[$k]."'>"."</td>";
                        echo "</tr>";
                        $r++;
			//$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");
			//$summaryamt=changeNegativeNumberFormat($totalcost2,2);
			//$pdf->Cell($w[2],$defaultfontheight,$summaryamt,0,0,"R");

			//$pdf->Ln();
			//$pdf->SetFont($defaultfont,'B',$defaultfontsize+1);
                        echo "<tr><td>&nbsp;</td></tr>";
                        echo "<tr><td><input type='checkbox' name='Gross Profit(Loss)' title='Gross Profit(Loss)($r)' id='chk$r' onclick='reloadChart()'></td>";

                        echo "<td style='text-align: Right'><B>Gross Profit(Loss)</b></td>";
                        for($k=0;$k<$m;$k++)
			$grossprofit[$k]=($totalsales[$k]*-1)-$totalcost[$k];


			for($k=0;$k<$m;$k++){
				$gpdisplay[$k]=number_format($grossprofit[$k],0,".","");

                             //   $gpdisplay[$k]=number_format($gpdisplay[$k],0,".","");
                        echo "<td style='text-align:right'><b>".$gpdisplay[$k].
                        "<input $hiddenctrlstyle id='value".$r."_".$k."' value='".$gpdisplay[$k]."'>"."</b></td>";
                        }
                        $r++;
			echo "</tr>";
                        echo "<tr><td>&nbsp;</td></tr><tr>";
			 //$pdf->Cell($w[0],$defaultfontheight,"Gross Profit(Loss)",0,0,"L");

			 //$pdf->Cell($w[1],$defaultfontheight,$gpdisplay1,0,0,"R");
			 //$pdf->Cell($w[1],$defaultfontheight,$gpdisplay2,0,0,"R");
		  break;
		  case "3O":
                        $summaryamt=array();
			for($k=0;$k<$m;$k++)
			$summaryamt[$k]=number_format(($totalotherincome[$k]*-1),0);

                        echo "<tr><td></td>";
                        echo "<td>---------</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>------</td>";
                        echo "</tr>";
                        echo "<tr><td><input type='checkbox' name='Total Others Income' title='Gross Profit(Loss)($r)' id='chk$r' onclick='reloadChart()'></td>";
                        echo "<td>Total Others Income</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>".$summaryamt[$k].
                                "<input $hiddenctrlstyle id='value".$r."_".$k."' value='".$summaryamt[$k]."'>"."</td>";
                        echo "</tr>";
                     $r++;
                        echo "<tr><td>&nbsp;</td></tr>";
		  break;


	  }

		$currentcategory =$classtype;
		//$pdf->Ln(10);
	  }




	 // $data=array($prefix.$displaytext,$tmparray);
	  //$pdf->SetX($marginx);

	if($showzero == "on")
            $checkzero = 1;
	else{
	//$checkzero = $displayamt[0];
	//
	//	$checkzero = $displayamt[1];
        $checkzero=0;
        for($k=0;$k<$m;$k++){

            if($displayamt[$k] != '0.00' ){
                 $checkzero=$displayamt[$k];
                 //echo $displaytext.",".$checkzero."<br/>";
                 }
            }

	}

	//if(substr($displaytext,0,1) == "[" || $checkzero <> 0){
        if(($showplacefolderindicator==1 && $placeholder==1) || $checkzero <> 0 || $checkzero <> "0.00"){
	  $i=0;
          echo "<tr>";


	  foreach($data as $col)
     	  {
	    if($i==0 ){
		$align='Left';
                $chkdisplay=str_replace("&nbsp;","",$col);
                $chkdisplay=str_replace("&"," and ",$chkdisplay);
                echo "<td><input type='checkbox' title='$chkdisplay($r)' name='$chkdisplay' id='chk$r' onclick='reloadChart()'>$r</td>";
            }
	    else
		$align='Right';
	    //$pdf->SetFont($defaultfont,'',$defaultfontsize);
	    //$pdf->Cell($w[$i],$defaultfontheight,$col,'',0,$align);
            echo "<td style='text-align:$align'>$col".
              "<input $hiddenctrlstyle id='value".$r."_".($i-1)."' value='".$col."'>"."</td>";

	    $i++;
	  }
	echo "</tr>";
	  //$pdf->Ln();
	}
        $r++;
	}
		//display summary for last row
			//$ypos=//$pdf->GetY();
			//$pdf->Line($w[0],$ypos,$marginx+$w[0]+$w[1]+$w[2],$ypos);

			//$pdf->Cell($w[0],$defaultfontheight,"",0,0,"R");
                        $summaryamt=array();
			for($k=0;$k<$m;$k++)
			$summaryamt[$k]=number_format($totalexpenses[$k],0,".","");

                        echo "<tr><td></td>";
                        echo "<td>---------</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>------</td>";
                        echo "</tr>";
                        echo "<tr><td><input type='checkbox' name='Total Expenses' title='Total Expenses($r)' id='chk$r' onclick='reloadChart()'></td>";

                        echo "<td>Total Expenses</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>".$summaryamt[$k].
                            "<input $hiddenctrlstyle id='value".$r."_".$k."' value='".$summaryamt[$k]."'>"."</td>";
                        echo "</tr>";
                        $r++;
                        for($k=0;$k<$m;$k++)
			$netprofit[$k]=$grossprofit[$k]+($totalotherincome[$k]*-1)-$totalexpenses[$k];


                        for($k=0;$k<$m;$k++)
				$displaynp[$k]=number_format($netprofit[$k],0,".","");

                        echo "<tr><td></td>";
                        echo "<td>---------</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>------</td>";
                        echo "</tr>";
                        echo "<tr><td><input type='checkbox' name='Net Profit (Loss)' title='Net Profit (Loss)($r)' id='chk$r' onclick='reloadChart()'>$r</td>";

                        echo "<td style='text-align: Right'><B>Net Profit (Loss)</B></td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'><B>".$displaynp[$k].
                                    "<input $hiddenctrlstyle id='value".$r."_".$k."' value='".$displaynp[$k]."'>"."</B></td>";
                        echo "</tr>";
                         $r++;
			 //$pdf->Cell($w[0],$defaultfontheight,"Net Profit (Loss)",0,0,"L");
			 //$pdf->Cell($w[1],$defaultfontheight,$displaynp1,"TB",0,"R");
			 //$pdf->Cell($w[2],$defaultfontheight,$displaynp2,"TB",0,"R");
			//$pdf->Ln();
			 //$pdf->Line($marginx+$w[0],//$pdf->GetY()+1,$marginx+$w[0]+$w[1]+$w[2],//$pdf->GetY()+1);
	////$pdf->MultiCell(0,5,"$sql",1,"C");
echo "</table><input type='hidden' id='rowcount' value='$r'><input type='hidden' id='colcount' value='$m'>";
	////$pdf->Output("viewincomestatement_single.pdf","I");
	//exit (1);

}
require(XOOPS_ROOT_PATH.'/footer.php');
?>


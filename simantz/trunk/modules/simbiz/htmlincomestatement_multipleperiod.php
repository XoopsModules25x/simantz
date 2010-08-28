<?php

	include_once "system.php";
        include_once "menu.php";
	//include_once "../system/class/Organization.php";
	include_once "../simantz/class/Period.inc.php";
	//include_once "../simantz/class/BPartner.php";
	include_once "class/Accounts.php";

	$org = new Organization();
	//$bp = new BPartner();
	$acc = new Accounts();
        
   $header=array("Accounts","","");
   $w=array(130,30,30);
   $papertype="A4";


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

   $orgnamefont="Times";
   $orgnamefontsize="12";
   $orgnamefontheight="6";
   $orgnamefontstyle="B";
   $orgcontactfont="Times";
   $orgcontactfontsize="10";
   $orgcontactfontheight=4;
   $orgcontactfontstyle="";

   $tableheaderfont="Times";
   $tableheaderfontsize="10";
   $tableheaderfontstyle="B";
   $tableheaderheight="5";
   $tableheadertype="TB";

   $headerorgseparator=2; //Space below organization info


   $reporttitle = "Income Statement";
   $reporttitlefont="Times";
   $reporttitlefontsize="10";
   $reporttitlefontheight="5";
   $reporttitlefontstyle="UB";



   $imagepath="./images/logo.jpg";
   $imagetype="JPG";
   $imagewidth=60;

   $month_term_date_posx=array(150,160);


   $orgname="Unknown";
   $orgstreet1="Unknown";
   $orgstreet2="Unknown";
   $orgstreet3="Unknown";
   $orgcity="Unknown";
   $orgstate="Unknown";
   $orgcountry_name="Unknown";
   $orgemail="Unknown";
   $orgurl="Unknown";
   $orgtel1="Unknown";
   $orgtel2="Unknown";
   $orgfax="Unknown";

   $statementdescription="The outstanding amount state as above, it is greatly appreciated if you can proceed the payment as soon as possible. \nIf there is any discrepancy please inform us within 1 week.\n";

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

function pageHeader(){
    global $organization_code;
     echo "<h1>Income Statement</h1>Organization : $organization_code<br>";

 }



if (isset($_POST["submit"])){


	
//	$pdf=new PDF('P','mm',$papertype[$statementpapersource]);  //0=A4,1=Letter
	//$pdf=new PDF('P','mm',"A4");  //0=A4,1=Letter
	////$pdf->AliasNbPages();
	////$pdf->SetAutoPageBreak(true,40 + 1 );

        $organization_id=$_REQUEST['organization_id'];
        
	$org->fetchOrganization($organization_id);
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

       echo <<< EOF

       <STYLE type="text/css">

                td{
		text-align:right;
	}
            </STYLE>
   <table border='1'>
EOF;
       echo "<tr>";
       echo "<td><B><U>Account</U></B></td>";
	foreach($arrayperiod as $id){
            if($period->fetchPeriod($id)){

             $monthname[$m]=$period->period_name;
	     $monthid[$m]=$id;
             echo "<td style='text-align:right'><b><u>$period->period_name</u></b></td>";
             $allsubsql.="case when (SELECT sum(t.amt) FROM sim_simbiz_batch b
                    inner join sim_simbiz_transaction t on t.batch_id=b.batch_id
                    where t.accounts_id=a.accounts_id and b.period_id=$id and b.iscomplete=1 and  t.branch_id = $organization_id) is null
		then 0 else (SELECT sum(t.amt) FROM sim_simbiz_batch b
                    inner join sim_simbiz_transaction t on t.batch_id=b.batch_id
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

	while($row=$xoopsDB->fetchArray($query)){
		$accountcode_full=$row['accountcode_full'] ;
	
		$placeholder=$row['placeholder'];
		$accounts_id=$row['accounts_id'];
		$classtype=$row['classtype'];
		$hierarchy=explode(']',$row['hierarchy']);
                $treelevel=sizeof($hierarchy)-1;
                //skip to next record if found current record is not under this level
                if($treelevel>$reportlevel)
                    continue;
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
	  if($showplacefolderindicator==1 && $placeholder==1)
		$displaytext=$prefix."[".$accounts_name."]";
	  else
	  	$displaytext=$prefix.$accounts_name;



	  if($placeholder==0 ){
              for($k=0;$k<$m;$k++)
              if($classtype=="1S" || $classtype=="3O")
		$displayamt[$k]=changeNegativeNumberFormat($transactionamt[$k]*-1,2);
              else
		$displayamt[$k]=changeNegativeNumberFormat($transactionamt[$k],2);
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
		$displayamt[$k]=changeNegativeNumberFormat($transactionamt[$k]*-1,2);
              else
		$displayamt[$k]=changeNegativeNumberFormat($transactionamt[$k],2);
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
			$summaryamt[$k]=changeNegativeNumberFormat($totalsales[$k]*-1,2);
			//echo $summaryamt.",";
			
                        echo "<tr>";
                        echo "<td>---------</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>------</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>Total Sales</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>".$summaryamt[$k]."</td>";
                        echo "</tr>";
                        echo "<tr><td>&nbsp;</td></tr><tr>";
			//$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");
			//$summaryamt=changeNegativeNumberFormat($totalsales2,2);
			//$pdf->Cell($w[2],$defaultfontheight,$summaryamt,0,0,"R");
		  break;	
		  case "2C":
                        $summaryamt=array();
			for($k=0;$k<$m;$k++)
			$summaryamt[$k]=changeNegativeNumberFormat($totalcost[$k],2);
                        echo "<tr>";
                        echo "<td>---------</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>------</td>";

                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>Total COGS</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>".$summaryamt[$k]."</td>";
                        echo "</tr>";
			//$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");
			//$summaryamt=changeNegativeNumberFormat($totalcost2,2);
			//$pdf->Cell($w[2],$defaultfontheight,$summaryamt,0,0,"R");

			//$pdf->Ln();
			//$pdf->SetFont($defaultfont,'B',$defaultfontsize+1);
                        echo "<tr><td>&nbsp;</td></tr><tr>";
                        echo "<td style='text-align: Right'><B>Gross Profit(Loss)</b></td>";
                        for($k=0;$k<$m;$k++)
			$grossprofit[$k]=($totalsales[$k]*-1)-$totalcost[$k];

			
			for($k=0;$k<$m;$k++){
			if($grossprofit[$k]<0)
				$gpdisplay[$k]=changeNegativeNumberFormat($grossprofit[$k],2);
			else
				$gpdisplay[$k]=changeNegativeNumberFormat($grossprofit[$k],2);
                        echo "<td style='text-align:right'><b>".$gpdisplay[$k]."</b></td>";
                        }
			echo "</tr>";
                        echo "<tr><td>&nbsp;</td></tr><tr>";
			 //$pdf->Cell($w[0],$defaultfontheight,"Gross Profit(Loss)",0,0,"L");
			
			 //$pdf->Cell($w[1],$defaultfontheight,$gpdisplay1,0,0,"R");
			 //$pdf->Cell($w[1],$defaultfontheight,$gpdisplay2,0,0,"R");
		  break;	
		  case "3O":
                        $summaryamt=array();
			for($k=0;$k<$m;$k++)
			$summaryamt[$k]=changeNegativeNumberFormat($totalotherincome[$k]*-1,2);

                        echo "<tr>";
                        echo "<td>---------</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>------</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>Total Others Income</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>".$summaryamt[$k]."</td>";
                        echo "</tr>";
                    
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
	    if($i==0)
		$align='Left';
	    else
		$align='Right';
	    //$pdf->SetFont($defaultfont,'',$defaultfontsize);
	    //$pdf->Cell($w[$i],$defaultfontheight,$col,'',0,$align);
            echo "<td style='text-align:$align'>$col</td>";

	    $i++;		
	  }	
	echo "</tr>";
	  //$pdf->Ln();
	}

	}
		//display summary for last row
			//$ypos=//$pdf->GetY();
			//$pdf->Line($w[0],$ypos,$marginx+$w[0]+$w[1]+$w[2],$ypos);

			//$pdf->Cell($w[0],$defaultfontheight,"",0,0,"R");
                        $summaryamt=array();
			for($k=0;$k<$m;$k++)
			$summaryamt[$k]=changeNegativeNumberFormat($totalexpenses[$k],2);
                        echo "<tr>";
                        echo "<td>---------</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>------</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>Total Expenses</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>".$summaryamt[$k]."</td>";
                        echo "</tr>";
			//$pdf->Cell($w[1],$defaultfontheight,$summaryamt,0,0,"R");
			//$summaryamt=changeNegativeNumberFormat($totalexpenses2,2);
			//$pdf->Cell($w[2],$defaultfontheight,$summaryamt,0,0,"R");

			//$pdf->Ln();
			//$pdf->Ln();
			//$pdf->SetFont($defaultfont,'B',$defaultfontsize+1);
                        for($k=0;$k<$m;$k++)
			$netprofit[$k]=$grossprofit[$k]+($totalotherincome[$k]*-1)-$totalexpenses[$k];


                        for($k=0;$k<$m;$k++)
			if($netprofit[$k]>=0)
				$displaynp[$k]=changeNegativeNumberFormat($netprofit[$k],2);
			else
				$displaynp[$k]=changeNegativeNumberFormat($netprofit[$k],2);
                        echo "<tr>";
                        echo "<td>---------</td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'>------</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td style='text-align: Right'><B>Net Profit (Loss)</B></td>";
			for($k=0;$k<$m;$k++)
                        echo "<td style='text-align:right'><B>".$displaynp[$k]."</B></td>";
                        echo "</tr>";
			 //$pdf->Cell($w[0],$defaultfontheight,"Net Profit (Loss)",0,0,"L");
			 //$pdf->Cell($w[1],$defaultfontheight,$displaynp1,"TB",0,"R");
			 //$pdf->Cell($w[2],$defaultfontheight,$displaynp2,"TB",0,"R");
			//$pdf->Ln();
			 //$pdf->Line($marginx+$w[0],//$pdf->GetY()+1,$marginx+$w[0]+$w[1]+$w[2],//$pdf->GetY()+1);
	////$pdf->MultiCell(0,5,"$sql",1,"C");
echo "</table>";
	////$pdf->Output("viewincomestatement_single.pdf","I");
	//exit (1);

}
require(XOOPS_ROOT_PATH.'/footer.php');
?>


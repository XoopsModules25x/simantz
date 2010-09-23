<?php

class FinancialYearLine{

public $tablefinancialyear;
public $tablefinancialyearline;
private $xoopsDB;
private $log;

public function financialyearLine(){
global $tabletransaction,$tablebatch,$tabletransaction,$tablefinancialyear,$tablefinancialyearline,
       $tableaccounts,$tableaccountgroup,$tableaccountclass, $xoopsDB,$log,$tableperiod;

$this->tablefinancialyear=$tablefinancialyear;
$this->tablebatch=$tablebatch;
$this->tabletransaction=$tabletransaction;
$this->tablefinancialyearline=$tablefinancialyearline;
$this->tableperiod=$tableperiod;
$this->xoopsDB=$xoopsDB;
$this->tableaccounts=$tableaccounts;
$this->tableaccountgroup=$tableaccountsgroup;
$this->tableaccountclass=$tableaccountsclass;
$this->log=$log;

}

  public function showFinancialYearLine($financialyear_id){
	global $simbizctrl,$defaultorganization_id;
        include "class/Accounts.php";
        $acc = new Accounts();
        
	$result="<tr><td class='head'>Detail 
		<td colspan='3'>
		<table  cellspacing=0 border=0 cellpadding=0'><tbody>
			<tr>
			<td class='head'>No</td>
			<td class='head'>Period</td
			<td class='head'>Is Closed</td>
			<td class='head'>Del</td>

			</tr>
			";
	$sql="SELECT fyl.financialyearline_id,fyl.period_id, fyl.isclosed,p.period_name
		 FROM $this->tablefinancialyearline fyl
		inner join $this->tableperiod p on p.period_id=fyl.period_id
		where fyl.financialyear_id=$financialyear_id order by p.period_name";

	$this->log->showLog(4,"Call purchase invoice line with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	$i=0;
	$rowtype = "";
	while($row=$this->xoopsDB->fetchArray($query)) {
		$period_id=$row['period_id'];
		$isclosed=$row['isclosed'];
		$financialyearline_id=$row['financialyearline_id'];
		$periodctrl=$simbizctrl->getSelectPeriod($period_id,"Y");
                $period_name=$row['period_name'];
//                $rsretainearning=$this->checkRetainEarningBatch($period_id);
//                $batch_id=$rsretainearning['batch_id'];
//                $iscomplete=$rsretainearning['iscomplete'];
//                $batchno=$rsretainearning['batchno'];
//                $amt=$rsretainearning['amt']*-1;
//
//
//                $errortext="";
//                $actualProfitAndLost=$acc->getProfitAndLostInPeriod($period_id);
//
//                if($actualProfitAndLost==0)
//                $actualProfitAndLost=0;
//                if($amt==0)
//                $amt=0;
//                if($actualProfitAndLost!=$amt)
//                $errortext="<b style='color:red'>Warning! Actual Retain Earning Amount = $actualProfitAndLost!
//                        <Input type='button' onclick='rePostRetainEarning($batch_id,$actualProfitAndLost,$financialyearline_id,\"$batchno\")' value='Re-Post'></a>";
//                else
//                $errortext="";
//
//
//                if($iscomplete==1)
//                $completetxt="Posted";
//                else
//                $completetxt="<B style='color:red'>Draft</a>";
//                $closingtext="";
//                if($batch_id>0){
//                $stylehidedelete="style='display: none'";
//                $closingtext="";
//                $retainearningctrl="<div id='divperiod$financialyearline_id'><A href='batch.php?action=view&batch_id=$batch_id'>Amount: $amt ($completetxt as Batch No:$batchno)</A>  $errortext</div>";
//                }
//                else{
//                $stylehidedelete="";
//                $closingtext="* You shall post profit and lost before month end closing";
//                $retainearningctrl="<div id='divperiod$financialyearline_id'>Post Retain Earning: $actualProfitAndLost<input type='button' onclick='this.style.display=\"none\";postRetainEarning($period_id,$actualProfitAndLost,$financialyearline_id,\"$period_name\",this)' value='POST'></div>";
//
//                }
	//	$allowtrans=$this->allowAccountTransaction($defaultorganization_id,$period_id);
		//$allowtrans=$this->allowAccountTransactionInDate($defaultorganization_id,"08-$i-01");
		$nextid=$i+1;
		if($i>0)
		$previousid=$i-1;
		else
		$previousid=0;
		
		if($isclosed==1)
		$checked="CHECKED";
		else
		$checked="";

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

               
		$result=$result."
		<tr><td class='$rowtype'>".($i+1)." <input type='hidden' name='linefinancialyearline_id[$i]' value='$financialyearline_id'></td>
		<td class='$rowtype'>$periodctrl</td>
		
	<td class='$rowtype'><input type='checkbox' $checked name='lineisclosed[$i]' id='lineisclosed$i'
                        onchange='closePeriod($period_id,this.checked,$financialyearline_id)'></td>
		<td class='$rowtype'><input type='checkbox' name='linedel[$i]' id='linedel$i' $stylehidedelete></td>

		</tr>
		";
	$i++;
	}

	return $result."</tbody></table>
                <script type='text/javascript'>
                    document.getElementById('periodqty').value=$nextid;
                </script></tr>";
	}

  public function createFinancialYearLine($financialyear_id,$periodfrom_id,$periodto_id){
	global $defaultorganization_id;
	if($financialyear_id==0 || $periodfrom_id==0 || $periodto_id==0){
		if($financialyear_id==0)
		$this->log->showLog(1,"createFinancialYearLine cancel due to input error ($financialyear_id,$periodfrom_id,$periodto_id)");
		return false;
	}
	else{//process to create financialyearline
	//get list of period to insert into this year
	$sqlgetperiodlist="select a.period_id,a.period_name from (SELECT  pr.period_id, concat(case when length(pr.period_year)=1 then 
			concat('000',pr.period_year) else pr.period_year end  ,
			'-',case when length(pr.period_month) =1 then concat('0',pr.period_month) else pr.period_month end ) as period_name
		FROM $this->tableperiod pr
		WHERE  concat(case when length(pr.period_year)=1 then concat('000',pr.period_year) else pr.period_year end  ,
			'-',case when length(pr.period_month) =1 then concat('0',pr.period_month) else pr.period_month end ) 
			BETWEEN
			(select concat(	 case when length(period_year)=1 then concat('000',period_year) else period_year end  ,
			'-',case when length(period_month) =1 then concat('0',period_month) else period_month end) 
			from  $this->tableperiod where period_id=$periodfrom_id) 
			AND
			(select concat(	 case when length(period_year)=1 then concat('000',period_year) else period_year end  ,
			'-',case when length(period_month) =1 then concat('0',period_month) else period_month end) 
			from  $this->tableperiod where period_id=$periodto_id)
		and pr.period_id>0) a order by a.period_name";
	$this->log->showLog(4,"Get Period range with SQL: $sqlgetperiodlist");
	$qryNewPeriodList=$this->xoopsDB->query($sqlgetperiodlist);
	
	//verified existing year contain how many period (Max 18)
	$sqlgettotalperiod="SELECT count(financialyear_id) as rowcount 
			FROM $this->tablefinancialyearline where financialyear_id=$financialyear_id";

	$rschildperiod=$this->xoopsDB->query($sqlgettotalperiod);
	$rowchildperiod=$this->xoopsDB->fetchArray($rschildperiod);
	if($rowchildperiod['rowcount']=="");
		$rschildperiod['rowcount']=0;
	}
	$this->log->showLog(4,"Get Child ".$rowchildperiod['rowcount']. "record under this financialyear with sql: $sqlgettotalperiod");

	$allowedloopqty=18-$rowchildperiod['rowcount'];
	$i=0;
	$sqlinsert="INSERT INTO $this->tablefinancialyearline (financialyear_id,period_id,organization_id,isclosed) values ";
	while($row=$this->xoopsDB->fetchArray($qryNewPeriodList)){
	if($i==$allowedloopqty){
		continue;
	}

	$period_id=$row['period_id'];
	$sqlinsert.="($financialyear_id,$period_id,$defaultorganization_id,1),";
	
	$i++;
	}
	$sqlinsert=substr_replace($sqlinsert,"",-1);
	$rs=$this->xoopsDB->query($sqlinsert);
	if($rs){
	$this->log->showLog(4,"Create financialperiodline($i) successfully with SQL: $sqlinsert");
	$this->createdline=$i;
	}
	else{
	$this->log->showLog(1,"Create financialperiodline($i) failed it maybe some period used before either in this financial year or others financial year. With SQL: $sql with SQL: $sqlinsert");
	$this->createdline=0;
	}

  }

 public function updateFinancialYearLine(){
	$this->log->showLog(4,"call UpdatefinancialyearLine.");
	$i=0;

	foreach ($this->linefinancialyearline_id as $financialyearline_id){

		if($this->lineisclosed[$i]=='on')
		$isclosed=1;
		else
		$isclosed=0;
		$isdel=$this->linedel[$i];
		//$financialyearline_id
		//
		if($isdel=='on'){
		$this->log->showLog(3,"Delete financialyearline:$financialyearline_id");
		$this->deleteFinancialYearLine($financialyearline_id);
		}
		else{
		$sql="UPDATE $this->tablefinancialyearline SET isclosed=$isclosed
			where financialyearline_id=$financialyearline_id";
		
		$rs=$this->xoopsDB->query($sql);
		if($rs)
		$this->log->showLog(4,"UpdatefinancialyearLine successfully with SQL: $sql");
		else{
		$this->log->showLog(1,"UpdatefinancialyearLine failed with SQL: $sql");
		return false;
		}
		}
	$i++;
	}
	return true;
 }

  public function deleteFinancialYearLine($financialyearline_id){
	$this->log->showLog(2,"Warning: Performing delete financialyear id : $financialyear_id !");
	$sql="DELETE FROM $this->tablefinancialyearline where financialyearline_id=$financialyearline_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: financialyearline ($financialyearline_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"financialyearline ($financialyearline_id) removed from database successfully!");
		return true;
		
	}
 }

	public function allowAccountTransactionInPeriod($organization_id,$period_id){
		$this->log->showLog(3,"Access allowAccountTransactionInPeriod($organization_id,$period_id)");
		$sql="SELECT isclosed FROM $this->tablefinancialyearline where period_id=$period_id and organization_id=$organization_id";
		$query=$this->xoopsDB->query($sql);
		if($row=$this->xoopsDB->fetchArray($query)){
		
			$isclosed=$row['isclosed'];
			if($isclosed==0)
				return true; //period not close then allow transaction
			else
				return false; //if period not found or is closed(1), not allow transaction
		}

	}


	public function allowAccountTransactionInDate($organization_id,$transactiondate){

//echo "allowAccountTransactionInDate($organization_id,$transactiondate)";
		$this->log->showLog(3,"Access allowAccountTransactionInDate($organization_id,$transactiondate)");

		$datearray=explode('-',$transactiondate);
		$year=$datearray[0];
		if(strlen($year)==1)
		$year="200".$year;
		if(strlen($year)==2)
		$year="20".$year;
		if(strlen($year)==3)
		$year="2".$year;

		$month=$datearray[1];
		$sql="SELECT fyl.period_id,fyl.isclosed FROM $this->tablefinancialyearline fyl
			INNER JOIN $this->tableperiod p on fyl.period_id=p.period_id
			where p.period_year=$year and 
			p.period_month=$month  and
			fyl.organization_id=$organization_id";

		$this->log->showLog(4,"With SQL: $sql");
		$query=$this->xoopsDB->query($sql);
		
		if($row=$this->xoopsDB->fetchArray($query)){
		
			$isclosed=$row['isclosed'];
			if($isclosed==0){
				$this->log->showLog(4,"Return isclose =0");
				$this->period_id=$row['period_id'];
				return true; //period not close then allow transaction
			}
			else{
                            	$this->log->showLog(4,"Return isclose !=0");
				$this->period_id=0;
				return false; //if period not found or is closed(1), not allow transaction
			}

		}
			$this->period_id=0;
		return false;//if query failed, not allow transaction
	}
  public function closeFinancialYearLine($financialyear_id){
	$this->log->showLog(2,"Warning: Performing closeFinancialYearLine financialyear id : $financialyear_id !");
	$sql="UPDATE $this->tablefinancialyearline set isclosed = 1 where financialyear_id=$financialyear_id";
	$this->log->showLog(4,"with SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: financialyearline ($financialyearline_id) cannot execute from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"financialyearline ($financialyearline_id) execute from database successfully!");
		return true;
		
	}

	}


          public function checkRetainEarningBatch($period_id){
              global $defaultorganization_id;
              //account_type=6 for retain earning transaction
               $sql="SELECT distinct(b.batch_id) batch_id,b.batchno,b.iscomplete,t.amt FROM $this->tablebatch b
                inner join $this->tabletransaction t on b.batch_id=t.batch_id
                inner join $this->tableaccounts a on a.accounts_id=t.accounts_id
                where b.period_id=$period_id AND a.account_type=6 and b.organization_id=$defaultorganization_id";
                $this->log->showLog(3,"checkRetainEarningBatch($period_id)");
                $this->log->showLog(4,"With SQL: $sql");

              $query=$this->xoopsDB->query($sql);
              
                while($row=$this->xoopsDB->fetchArray($query)){
                $batch_id=$row['batch_id'];
                $iscomplete=$row['iscomplete'];
                $amt=$row['amt'];
                $this->log->showLog(3,"result: batch_id:$batch_id,iscomplete: $iscomplete,amt: $amt");
                return $row;
                }
                $this->log->showLog(3,"result: batch_id:0,iscomplete: 0");
                return array(0,0,0);


          }

   public function getRetainEarningTransaction($batch_id){
       $sql="SELECT trans_id
            FROM $this->tabletransaction
            where batch_id=$batch_id order by trans_id";
            $this->log->showLog(3,"getRetainEarningTransaction($batch_id)");
                $this->log->showLog(4,"With SQL: $sql");
       $query=$this->xoopsDB->query($sql);
       $data=array();
       while($row=$this->xoopsDB->fetchArray($query)){
       $data[]=$row['trans_id'];
            $this->log->showLog(4,"trans_id:".$row['trans_id']);
       }
       return $data;

   }
   public function getNewBatchNo(){
       global $defaultorganization_id;

  $sql="SELECT min(batchno) as batchno
            FROM $this->tablebatch
          where organization_id =$defaultorganization_id ";
            $this->log->showLog(3,"getNewBatchNo");
                $this->log->showLog(4,"With SQL: $sql");
       $query=$this->xoopsDB->query($sql);
      
       while($row=$this->xoopsDB->fetchArray($query)){
      $result=$row['batchno'];
            $this->log->showLog(4,"result:".$result);
       }
       return $result -1;

   }
             
}
?>
<?php

class AccountsAPI {

private $tablebatch;
  public function AccounstAPI(){
	global $xoopsDB,$log,$tableaccounts,$tablebatch,$tabletransaction,$tabletranssumary,$tableperiod,$tablebpartner,$tablecurrency,
	$tableaccountclass,$tableaccountgroup,$defaultorganization_id,$url;

	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
	$this->tableaccounts=$tableaccounts;
	$this->tablebatch=$tablebatch;
	$this->tabletransaction=$tabletransaction;
	$this->tabletranssumary=$tabletranssumary;
	$this->tableperiod=$tableperiod;
	$this->tablebpartner=$tablebpartner;
	$this->tablecurrency=$tablecurrency;
	$this->tableaccountclass=$tableaccountclass;
	$this->tableaccountgroup=$tableaccountgroup;
	$this->defaultorganization_id=$defaultorganization_id;
	$this->url=$url;
  }

	//allow others system post batch to here
	/*
	*parameter: $uid,$date,$systemname,$batchname,$documentno,$description+$batchlinkurl,$totaltransactionamt,
		$accountsarray,$amtarray,$bpartner_idarray,$linetype(0=main,1=ref)
		$transtypearray: (RE)Post Retain Earning
	*   isreadonly=1 for transaction which is user cannot edit
	*/
	public function PostBatch($uid,$date,$systemname,$batch_name,$description,$totaltransactionamt,$documentnoarray,
		$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,$transtypearray,$linetypearray,
		$chequenoarray,$linedesc="",$isreadonly=0,$batchno=""){
		include_once "../simbiz/class/Batch.php";
		include_once "../simbiz/class/Accounts.php";
		include_once "../simbiz/class/Transaction.php";
		include_once "../simbiz/class/FinancialYearLine.php";
                include_once "../simantz/class/Period.inc.php";
//		include_once "system.php";

		global $xoopsDB,$log,$defaultorganization_id,$tableprefix;
		$tablebatch=$tableprefix."simbiz_batch";
		$tabletransaction=$tableprefix."simbiz_transaction";
		$batch = new Batch();
		$acc =  new Accounts();
		$trans = new Transaction();
		$fyl = new FinancialYearLine();
		$period = new Period();
	
                $year=$this->left($date,4);
                $month=$this->right($this->left($date,7),2);
                $period_id=$period->getPeriodID($year,$month);
		$allowtrans=$fyl->allowAccountTransactionInDate($defaultorganization_id,$date);

		if(!$allowtrans){
			$log->showLog(1,"Can't post data due to period in financial year is closed. You can fix this problem on re-opened this period at Financial Year window(under simbiz module)");
			return false;
		}
                $totaltransactionamt=abs($totaltransactionamt);
		//1.get next batch no
                if($batchno=="")
		$batchno = getNewCode($xoopsDB,"batchno",$tablebatch);
		$timestamp= date("y/m/d H:i:s", time()) ;

		//2. Create new batch
		 $sqlinsertbatch="INSERT INTO $tablebatch (organization_id, batchno,batch_name,description,created,createdby,
			updated,updatedby,totaldebit,totalcredit,fromsys,batchdate,iscomplete,isreadonly,period_id) values(
			$defaultorganization_id, '$batchno','$batch_name','$description','$timestamp',$uid,
			'$timestamp',$uid,$totaltransactionamt,$totaltransactionamt,'$systemname','$date',1,$isreadonly,$period_id)";
		$rsinsertbatch=$xoopsDB->query($sqlinsertbatch);
	
		if(!$rsinsertbatch){
			$log->showLog(1,__LINE__."PostBatch Create batch failed with sqlinsertbatch: $sqlinsertbatch ");
			return false;
		}
		else{
			$log->showLog(4,"Create batch successfully with sqlinsertbatch: $sqlinsertbatch ");
			$newbatch_id=$batch->getLatestBatchID();
			$i=0;
			$reference_id=0;
			foreach($accountsarray as $accounts_id){

			//3. Loop to create transaction
					if( $i!=0 && ($i==1 || $linetypearray[$i-1]==0  ) ){
						$reference_id=$this->latestTransactionId();
					}
					elseif($linetypearray[$i]==0 && $i>0)
					$reference_id=0;
				$sqlinserttransaction="INSERT INTO $tabletransaction (
					document_no,batch_id,amt,currency_id,originalamt,
					transtype,accounts_id,multiplyconversion,
					seqno,reference_id,bpartner_id,document_no2,linedesc) 
					VALUES (
					'$documentnoarray[$i]',$newbatch_id,$amtarray[$i],$currencyarray[$i],$originalamtarray[$i],
					'$transtypearray[$i]',$accounts_id,$conversionarray[$i],'$i',$reference_id,$bpartnerarray[$i],
					'$chequenoarray[$i]','$linedesc[$i]')";
					$rsinserttransaction=$xoopsDB->query($sqlinserttransaction);
					if(!$rsinserttransaction){
                                            echo mysql_error();
						$log->showLog(1,__LINE__."PostBatch Create transaction line failed with
							 sqlinserttransaction: $sqlinserttransaction,<br>deleteing batch: $newbatch_id");
						$batch->deleteBatch($newbatch_id);
						return false;


					}
					else{
						$log->showLog(4,__LINE__."PostBatch Create transaction line successfully with
							 sqlinserttransaction: $sqlinserttransaction ");

					}
			$i++;
			}

			//4. update lastbalance for accounts, and parent accounts
			$trans->compileSummary($newbatch_id);

			//5. Update transaction summary
			//6. update last balance for bpartner
			$trans->insertTransactionSummary($newbatch_id,$defaultorganization_id,1);

			//7. put batch id, batch no at resultbatch_id,$resultbatch_no
			$this->resultbatch_id=$newbatch_id;
			$this->resultbatch_no=$batchno;
			//return true or false

			//$acc->repairAccounts();
			return true;

			
		}
		return false;
			
	}

	public function reverseBatch($batch_id){

		include_once "../simbiz/class/Batch.php";
		include_once "../simbiz/class/Accounts.php";
		include_once "../simbiz/class/Transaction.php";
		$batch = new Batch();
		$acc =  new Accounts();
		$trans = new Transaction();
		global $xoopsDB,$log,$defaultorganization_id,$tableprefix;
		$tablebatch=$tableprefix."simbiz_batch";
		$tabletransaction=$tableprefix."simbiz_transaction";
	
		//1. reactivate transaction
		if($batch->fetchBatch($batch_id) ) {
		if($batch->iscomplete==-1 ){
			$log->showLog(1,"This batch already reverse previously. Exit process.");
			return true;
		}
		$trans->reverseSummary($batch_id);
		$trans->insertTransactionSummary($batch_id,$defaultorganization_id,0);
		}

		//2. void transaction
		$sql="Update $tablebatch set iscomplete=-1 where batch_id=$batch_id";
		$rs=$xoopsDB->query($sql);
		if($rs)
			{$log->showLog(3,"Void this batch successfully: $batch_id");
			//$acc->repairAccounts();
			return true;
			}
		else{
			$log->showLog(1,"Failed to void this batch:$batch_id");
			return false;
		}
	}

        public function reActivateBatch($batch_id){

		include_once "../simbiz/class/Batch.php";
		include_once "../simbiz/class/Accounts.php";
		include_once "../simbiz/class/Transaction.php";
		$batch = new Batch();
		$acc =  new Accounts();
		$trans = new Transaction();
		global $xoopsDB,$log,$defaultorganization_id,$tableprefix;
		$tablebatch=$tableprefix."simbiz_batch";
		$tabletransaction=$tableprefix."simbiz_transaction";

		//1. reactivate transaction
		if($batch->fetchBatch($batch_id) ) {
		if($batch->iscomplete==-1 || $batch->iscomplete==0){
			$log->showLog(1,"This batch already reverse/reactivate previously. Exit process.");
			return true;
		}
		$trans->reverseSummary($batch_id);
		$trans->insertTransactionSummary($batch_id,$defaultorganization_id,0);
		}

		//2. void transaction
		$sql="Update $tablebatch set iscomplete=0 where batch_id=$batch_id";
		$rs=$xoopsDB->query($sql);
		if($rs)
			{$log->showLog(3,"Reversed this batch successfully: $batch_id");
			//$acc->repairAccounts();
			return true;
			}
		else{
			$log->showLog(1,"Failed to reversed this batch:$batch_id");
			return false;
		}
	}
        

	public function latestTransactionId(){
		global $xoopsDB,$log,$defaultorganization_id,$tableprefix;
		$tablebatch=$tableprefix."simbiz_batch";
		$tabletransaction=$tableprefix."simbiz_transaction";
	
		$sqllatest="SELECT MAX(trans_id) as trans_id from $tabletransaction;";
		$log->showLog(4,"Checking latest created trans_id with SQL:$sqllatest");

		$querylatest=$xoopsDB->query($sqllatest);
		$rowlatest=$xoopsDB->fetchArray($querylatest); 	
			$log->showLog(3,'Found latest created trans_id:' . $rowlatest['trans_id']);
			return $rowlatest['trans_id'];
	}


   private function right($value, $count){

    $value = substr($value, (strlen($value) - $count), strlen($value));

    return $value;

}


private function left($string, $count){

    return substr($string, 0, $count);

}
//batch_id,totalamt,
public function updateTransactionAmount($batch_id,$totalamt,$arraytrans_id,$arrayamt){
    //get batch_id
    //change totaldebit,totalcredit
    //
    //get array account_id
    //get array debit,credit
    //recomplete account
    include_once "../simbiz/class/Accounts.php";
    include_once "../simbiz/class/Transaction.php";
    $trans = new Transaction();
    global $log,$xoopsDB,$tablebatch,$tabletransaction,$defaultorganization_id;
    $log->showLog(3,"Run updateTransactionAmount($batch_id,$totalamt,$arraytrans_id,$arrayamt)");
    $totalamt=abs($totalamt);
    $sql1="UPDATE $tablebatch set totaldebit=$totalamt,totalcredit=$totalamt,
            iscomplete=1 where batch_id=$batch_id";
    $log->showLog(4,"With SQL1: $sql1");
    $rs1=$xoopsDB->query($sql1);
    $log->showLog();
    $i=0;
    if($rs1){

    $log->showLog(3,"SQL1 run successfully");
    foreach($arraytrans_id as $trans_id){
        $newamt=$arrayamt[$i];
        $sql2="UPDATE $tabletransaction SET amt=$newamt where 
        trans_id=$trans_id";
        $rs2=$xoopsDB->query($sql2);
        if($rs2)
        $log->showLog(4,"SQL2: $sql2 run successfully");
        else
        $log->showLog(1,"SQL2: $sql2 run failed");
        $i++;
    }
    $trans->compileSummary($batch_id);
    $trans->insertTransactionSummary($batch_id,$defaultorganization_id,1);
    return true;
    }else{
         $log->showLog(1,"SQL1 run failed");
        return false;
    }
}

}
?>

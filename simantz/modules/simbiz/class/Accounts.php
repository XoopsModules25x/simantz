<?php

/*deprecated field
 * $lastbalance
 * $tax_id
 * treelevel
 * accounts_code
 * openingbalance
 */
class Accounts
{

  public $accounts_id;
  public $accounts_name;
  public $organization_id;
  public $accountgroup_id;
  public $parentaccounts_id;
  public $account_type;
  public $accountcode_full;
  public $placeholder;
  public $tax_id;
  public $lastbalance;

  public $ishide;
  public $openingbalance;
  public $description;
  public $defaultlevel;
  public $created;
  public $createdby;
  public $updated;
  public $treelevel;
  public $updatedby;
  public $hide;
  public $orgctrl;
  public $accountgroupctrl;
  public $validateerrors;
  private $lastaccounts_id;
  private $chartaccountparentaccountlist;
  private $xoopsDB;
  private $tableprefix;
  private $tableaccounts;
  private $tabletransaction;
  private $tablebatch;
  private $tableaccountgroup;
  private $tableaccountclass;
  private $tabletranssummary;
  private $tableperiod;
  private $accountindex=0;


  private $tablebpartner;

  private $log;

//constructor
   public function Accounts(){
	global $xoopsDB,$log,$tableaccounts,$tablebpartner,$tablebpartnergroup,$tabletax,$tablebatch,$tabletranssummary,$tableperiod,
		$tableorganization,$tableaccountgroup,$tableaccounts,$tablecurrency,$tabletransaction,$tableaccountclass;
  	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
        $this->tableorganization=$tableorganization;
	$this->tablecurrency=$tablecurrency;

	$this->tableaccounts=$tableaccounts;
	$this->tabletax=$tabletax;
	$this->tableaccountgroup=$tableaccountgroup;
	$this->tableaccountclass=$tableaccountclass;
	$this->tabletransaction=$tabletransaction;
	$this->tablebatch=$tablebatch;
	$this->tablebpartner=$tablebpartner;
	$this->tabletranssummary=$tabletranssummary;
	$this->tableperiod=$tableperiod;
	$this->tablename=$tableaccounts;
	
      
   }

   public function fetchAccounts( $accounts_id) {

   global $defaultorganization_id;
	$this->log->showLog(3,"Fetching accounts detail into class Accounts.php.<br>");

	 $sql="SELECT *
		 from $this->tableaccounts where accounts_id=$accounts_id and organization_id=$defaultorganization_id";

	$this->log->showLog(4,"ProductAccounts->fetchAccounts, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query)){
		$this->accountcode_full=$row["accountcode_full"];
		$this->accounts_code=$row["accounts_code"];
		$this->accounts_name=$row["accounts_name"];
		$this->parentaccounts_id=$row["parentaccounts_id"];
                $this->accounts_id=$row["accounts_id"];
		$this->account_type=$row["account_type"];
                $this->ishide=$row['ishide'];
		$this->tax_id=$row["tax_id"];
		$this->accountgroup_id=$row["accountgroup_id"];
		$this->placeholder=$row["placeholder"];
		$this->organization_id=$row['organization_id'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->openingbalance=$row['openingbalance'];
		$this->lastbalance=$row['lastbalance'];
		$this->description=$row['description'];
   	$this->log->showLog(4,"Accounts->fetchAccounts,database fetch into class successfully");
	$this->log->showLog(4,"accounts_name:$this->accounts_name");


		return true;
	}
	
		return false;
	$this->log->showLog(4,"Accounts->fetchAccounts,failed to fetch data into databases:" . mysql_error(). ":$sql");
	
  } // end of member function fetchAccounts

     public function allowDelete($id){
       $this->log->showLog(2,"Call function allowDelete($id)");
       $this->log->showLog(3,"return true");

       return true;
   }


    public function showChildAccountTree($parent,$level,$result){
       $result="";
      global $defaultorganization_id;
      $this->accountindex++;
        $sql = "SELECT * FROM $this->tableaccounts WHERE parentaccounts_id = $parent
                       AND accounts_id>0 and organization_id=$defaultorganization_id
			ORDER BY accountcode_full,accounts_name ";
       
   $query = $this->xoopsDB->query($sql);
 
    while ($row =$this->xoopsDB->fetchArray($query)) {

   		$children++;
                $accounts_id=$row['accounts_id'];
                $accountgroup_id=$row['accountgroup_id'];
                $accounts_code=$row['accounts_code'];
                $accountcode_full=$row['accountcode_full'];
                $accounts_name=$row['accounts_name'];
                $ishide=$row['ishide'];
                if($ishide==1)
                    $hiddentext="[hidden]";
                else
                    $hiddentext="";

    $hyperlink="&nbsp;&nbsp;&nbsp;".
                "<a href='javascript:showAccountsForm($accounts_id)' title='View Window' >".
                   " $accountcode_full - $accounts_name</a> $hiddentext &nbsp;";

    if($row['placeholder']==1){
    $hyperlink.="&nbsp;&nbsp;&nbsp;".
            "<a href=javascript:addChildAccounts($accounts_id) style='color:black'>".
            "[+]</a>";
    $this->chartaccountparentaccountlist.="$accounts_id,";
    }
    else{
//        <form action="transactionsummary.php" method="POST" target="_blank">
//				<input name="action" value="viewledger" type="hidden">
//				<input name="accounts_id" value="31" type="hidden">
//
//				<input name="submit" src="images/history.gif" title="View Transaction Summary History" type="image">
//				</form>
//
    $hyperlink.="&nbsp;&nbsp;&nbsp;".
                "<a href='viewsingleledger.php?submit=submit&accounts_id=$accounts_id&periodfrom_id=0&periodto_id=0&showbatchno=on' title='View Ledger' target='_blank'><img src='images/listledger.gif'></a>
                <a href='batch.php?defaultaccounts_id=$accounts_id&action=new' target='_blank'  title='Add Transaction'><img src='images/edit.gif'></a>
                <a href='transactionsummary.php?accounts_id=$accounts_id' target='_blank'  title='View Transaction Summary'><img src='images/history.gif'></a>";
    }

    
    $result.= "<li id='$list_id' style='list-style: none;'>";
	for($j=0;$j<$level;$j++)
            $result.= "&nbsp;&nbsp;&nbsp;&nbsp;";

    $result.=$hyperlink;
       // call this function again to display this child's children
       $result.=$this->showChildAccountTree($accounts_id,$level+1,$result);
   }
   return $result;

   }


   public function returnAccountsTypeXML($optionvalue=1){
       if($optionvalue==2){
            $select2="selected='selected'";
            $optiontext="Trade Debtor";
       }
       elseif($optionvalue==3){
            $select3="selected='selected'";
            $optiontext="Trade Creditor";
       }
       elseif($optionvalue==4){
            $select4="selected='selected'";
            $optiontext="Bank";
       }
       elseif($optionvalue==5){
            $select5="selected='selected'";
            $optiontext="Opening Balance";
       }
       elseif($optionvalue==6){
            $select6="selected='selected'";
            $optiontext="Retain Earning";
       }
       elseif($optionvalue==7){
            $select7="selected='selected'";
            $optiontext="Cash";
       }
       elseif($optionvalue==8){
            $select8="selected='selected'";
            $optiontext="Retain Earning (Reverse Entry)";
       }
       elseif($optionvalue==9){
            $select9="selected='selected'";
            $optiontext="Tax (GST)";
       }

       else{
            $select1="selected='selected'";
                 $optiontext="Genaral Account";
       }
      if($optionvalue==1 || $optionvalue==2 || $optionvalue==3 ||$optionvalue==4 || $optionvalue==7)
        $result="<option value='1'>General Account</option>
          <option value='2'>Trade Debtor</option>
          <option value='3'>Trade Creditor</option>
          <option value='4'>Bank</option>
          <option value='7'>Cash</option>
          ";
      else
          $result="<option value='$optionvalue'>$optiontext</option>";

      return $result;
   }

   public function getInputForm(){
       
    global $mandatorysign, $defaultorganization_id;
    $accoptionlist=$this->getSelectPlaceHolderAccounts(0);
    include "class/AccountGroup.php";
    $ag = new AccountGroup();
    $accgroupoptionlist=$ag->getSelectAccountGroup(0);
   $accountypeoption=$this->returnAccountsTypeXML(1);
    return "
   <div id='errormsg' class='red' style='display:none'></div>
        <A href=javascript:addChildAccounts(0)>[Add New]</a><br/>
    <form onsubmit='return false' action='accounts.php' id='frmAccount' name='frmAccount'>
       <table>
    <tbody>
    
 <tr>
        <td class='head'>Accounts Code $mandatorysign</td>
        <td class='even' >
	
	<input maxlength='7' size='7' id='accountcode_full' value='$this->accountcode_full'
                onchange= validate(this.value,'numeric','',this)   onblur= validate(this.value,'numeric','',this)></td>
      </tr>
 <tr>
        <td class='head'>Accounts Name $mandatorysign</td>
        <td class='even'>
                <input maxlength='60' size='30' id='accounts_name' value='$this->accounts_name'
                     onchange=validate(this.value,'text','',this)  onblur=validate(this.value,'text','',this)></td>
      </tr>
 <tr>
        <td class='head'>Accounts Group $mandatorysign</td>
        <td class='even'><select id='accountgroup_id' >$accgroupoptionlist</select></td>
      </tr>

 <tr>
        <td class='head'>Account Type</td>
        <td class='even' >
                <select id='account_type'>$accountypeoption</select>
	</td>
      </tr>


    <tr>
        <td class='head'>Parent Account</td>
        <td class='even' >
                <select id='parentaccounts_id' onfocus=refreshparentaccountlist(this.value)>
                    $accoptionlist
                </select>
            </td>
      </tr>
      <tr>
   	<td class='head'>Default Level $mandatorysign</td>
	        <td class='even' ><input maxlength='3' size='3' id='defaultlevel'  value=10
                    value='$this->defaultlevel'  validate(this.value,numeric,'',this)>
	</td>
      </tr>

 <tr>
        <td class='head'>Place Holder</td>
        <td class='even'><input type='checkbox' id='placeholder'></td>
      </tr>
      <tr>
        <td class='head'>Hide</td>
        <td class='even'><input type='checkbox' id='ishide'></td>
      </tr>
    <tr>
        <td class='head'>Description</td>
        <td class='even'><textarea id='description' cols='30'>$this->description</textarea></td>
      </tr>
    </tbody>
  </table>

            <input id='tax_id' value='0' title='tax_id' type='hidden'>
            <input id='accounts_id' value='0'  title='accounts_id' type='hidden'>
            <input id='organization_id' value='$defaultorganization_id' type='hidden'  title='organization_id'>
        <input name='save' onclick='saverecord()' type='submit' id='submit' value='Save'>
        <input name='save' onclick='deleterecord()' type='button' id='delete' value='Delete'>
</form>";
   }

   public function returnaccountsXML(){
 
    echo <<< EOF

<?xml version="1.0" encoding="utf-8" ?>
<Result>
<Account id="a_$this->accounts_id">
    <organization_id >$this->organization_id</organization_id>
    <accounts_id >$this->accounts_id</accounts_id>
    <ishide>$this->ishide</ishide>
    <accountgroup_id>$this->accountgroup_id</accountgroup_id>
    <accountcode_full>$this->accountcode_full</accountcode_full>
    <defaultlevel>$this->defaultlevel</defaultlevel>
    <accounts_name>$this->accounts_name</accounts_name>
    <description>$this->description</description>
    <organization_id>$this->organization_id</organization_id>
    <placeholder>$this->placeholder</placeholder>
    <tax_id>$this->tax_id</tax_id>
    <parentaccounts_id>$this->parentaccounts_id</parentaccounts_id>
    <account_type>$this->account_type</account_type>
</Account>
</Result>

EOF;
}





public function getSelectPlaceHolderAccounts($id){
    global $defaultorganization_id;
    
    $sql="SELECT * FROM $this->tablename where organization_id=$defaultorganization_id and placeholder=1
                    and ishide=0
                    or ( accounts_id=$id and accounts_id>0) order by defaultlevel,accountcode_full";
    $query=$this->xoopsDB->query($sql);
    $result="";
    while($row=$this->xoopsDB->fetchArray($query)){

    $accounts_id=$row['accounts_id'];
    $accounts_name=$row['accounts_name'];
    $accountcode_full=$row['accountcode_full'];
    $selected="";
    if($id==$accounts_id)
        $selected="SELECTED='SELECTED'";
    $result.="<option value='$accounts_id' $selected>$accountcode_full - $accounts_name</option>";

    }
    return $result;
}

public function validateForm(){
 include "../simantz/class/Validation.inc.php";
 $v = new Validation();
 if (!$v->isValidatedNumber($this->accountcode_full) )
	$this->validateerrors ['accountcode_full']= "Please insert correct account code\n";
 if (!$v->isValidatedText($this->accounts_name) )
	$this->validateerrors ['accounts_name']  = "Please fill in proper account name\n";
 if($this->validateerrors)
         return false;
 else
        return true;

}


public function generateValidationError(){
                      echo "<status>-1</status><detail>";


    foreach($this->validateerrors as $name=>$text)
            echo "<field id='$name'><fieldname>$name</fieldname><msg>$text</msg></field>";
    echo "</detail>";
}
 public function insertAccounts( ) {
 global $selectspliter;
     include include "../simantz/class/Save_Data.inc.php";;
    $save = new Save_Data();
          $arrInsertField=array('accounts_name','created','createdby',
	'updated','updatedby','defaultlevel','organization_id','description',
          'parentaccounts_id','account_type','tax_id',
	'placeholder','accountgroup_id','accountcode_full','ishide');

        $arrInsertFieldType=array('%s','%s','%d',
        	'%s','%d','%d','%d','%s','%d','%d','%d','%d','%d','%d','%d');
        
    $arrvalue=array($this->accounts_name,$this->updated,$this->updatedby,
    	$this->updated,$this->updatedby,$this->defaultlevel,$this->organization_id,
            $this->description,
          $this->parentaccounts_id . $selectspliter . $this->parentaccounts_idname,
            $this->account_type. $selectspliter .$this->account_typename,$this->tax_id,
	$this->placeholder,$this->accountgroup_id.$selectspliter.$this->accountgroup_idname,
            $this->accountcode_full,$this->ishide);
  
    if($save->InsertRecord($this->tablename,   $arrInsertField,
            $arrvalue,$arrInsertFieldType,$this->accounts_name,"accounts_id")){
            $this->accounts_id=$save->latestid;
            return true;
            }
    else
            return false;

  }


 public function updateAccounts( ) {
 global $selectspliter;
     include include "../simantz/class/Save_Data.inc.php";;
    $save = new Save_Data();
      $arrUpdateField=array('accounts_name','description',
	'updated','updatedby','defaultlevel','accountgroup_id',
	'organization_id','parentaccounts_id','account_type', 'tax_id',
        'placeholder','accountcode_full','ishide');



        $arrUpdateFieldType=array('%s','%s','%s','%d','%d','%d',
            '%d','%d','%d', '%d','%d', '%d','%d');

    $arrvalue=array($this->accounts_name,$this->description,
	$this->updated,$this->updatedby,$this->defaultlevel,
        $this->accountgroup_id.$selectspliter.$this->accountgroup_idname,
	$this->organization_id,$this->parentaccounts_id.$selectspliter.$this->parentaccounts_idname,
            $this->account_type.$selectspliter.$this->account_typename,
            $this->tax_id,$this->placeholder,
        $this->accountcode_full,$this->ishide);
    
    if( $save->UpdateRecord($this->tablename, "accounts_id",
                $this->accounts_id,
                    $arrUpdateField, $arrvalue,  $arrUpdateFieldType,$accounts_name))
            return true;
    else
            return false;

  }


  public function replicateLastMonthBpartnerTransSummary($period_id,$organization_id){
	$sql="SELECT distinct(ts.accounts_id) as accounts_id,ts.bpartner_id
		FROM $this->tabletranssummary ts
		INNER JOIN $this->tableperiod pr on ts.period_id=pr.period_id
		where ts.organization_id=$organization_id and
		concat(case when length(pr.period_year)=1 then concat('000',pr.period_year) else pr.period_year end  ,
			'-',case when length(pr.period_month) =1 then concat('0',pr.period_month) else pr.period_month end ) <=
			(select concat(	 case when length(period_year)=1 then concat('000',period_year) else period_year end  ,
			'-',case when length(period_month) =1 then concat('0',period_month) else period_month end)
			FROM $this->tableperiod where period_id=$period_id)
		order by ts.accounts_id";
	$query=$this->xoopsDB->query($sql);
	$this->log->showLog(4,"run replicateLastMonthBpartnerTransSummary($period_id,$organization_id) with SQL: $sql");
	while($row=$this->xoopsDB->fetchArray($query)){
		$bpartner_id=$row['bpartner_id'];
		$accounts_id=$row['accounts_id'];

		//validate whether this combination exist
		$sqlcheck="SELECT count(*) as recordcount FROM $this->tabletranssummary ts where
			bpartner_id=$bpartner_id and accounts_id=$accounts_id and
			period_id=$period_id and organization_id=$organization_id";
		$qrycheck=$this->xoopsDB->query($sqlcheck);

		if($row=$this->xoopsDB->fetchArray($qrycheck))
			$recordcount=$row['recordcount'];

		if($recordcount>0) //if record exist, skip to next loop
			continue;
		else{
			$lastbalance=$this->getAccountLastBalanceOnPeriodByBPartner($period_id,$accounts_id,$bpartner_id);
			$sqlinsert="INSERT INTO $this->tabletranssummary (organization_id,period_id,accounts_id,
				bpartner_id,transactionamt,lastbalance) VALUES (
				$organization_id,$period_id,$accounts_id,$bpartner_id,0,$lastbalance)";
			$rs=$this->xoopsDB->query($sqlinsert);
			if($rs)
				$this->log->showLog(4,"Insert new transsummary successfully with SQL: $sqlinsert");
			else{

				$this->log->showLog(1,"Insert new transsummary failed with SQL: $sqlinsert");
				$this->errorbpartner_id=$bpartner_id;
				$this->errorperiod_id=$period_id;
				$this->erroraccounts_id=$accounts_id;
				return false;

				}
		}

	}
	//select distinct(accounts_id),bpartner_id where perioddate before period_id
	//validate in new period contain combination of bpartner_id and accounts_id
	//if not found create new record, if found continue next loop
	return true;
	}

  public function deleteAccounts($accounts_id){
include "../simantz/class/Save_Data.inc.php";
$save = new Save_Data();

   if($this->fetchAccounts($accounts_id)){
       
    return $save->DeleteRecord($this->tablename,"accounts_id",$accounts_id,$this->accounts_name,1);
   }
   else
       return false;

}

  public function checkAccounts($organization_id){
	$retval = true;
	$sql = "select count(*) as rowcount from $this->tableaccountgroup where organization_id = $organization_id ";

	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){

	if($row['rowcount'] == 0){//auto insert accounts
	$retval = true;
	}else{
	$retval = false;
	}

	}

	return $retval;
  }


  public function accBalanceBFAmount($period_id,$accounts_id,$includethismonth='N'){
	if($includethismonth=='Y')
		$operation="<=";
	else
		$operation="<";
	$sql="SELECT ts.lastbalance
		FROM $this->tableperiod pr
		INNER JOIN $this->tabletranssummary ts on pr.period_id=ts.period_id
		WHERE  concat(case when length(pr.period_year)=1 then concat('000',pr.period_year) else pr.period_year end  ,
			'-',case when length(pr.period_month) =1 then concat('0',pr.period_month) else pr.period_month end ) $operation
			(select concat(	 case when length(period_year)=1 then concat('000',period_year) else period_year end  ,
			'-',case when length(period_month) =1 then concat('0',period_month) else period_month end)
			from  $this->tableperiod where period_id=$period_id)
		and pr.period_id>0 and ts.accounts_id=$accounts_id
		order by ts.transum_id DESC";

		$query=$this->xoopsDB->query($sql);
		if($row=$this->xoopsDB->fetchArray($query)){
			$lastbalance=$row['lastbalance'];
			$this->log->showLog(4,"Get Last balance $lastbalance with SQL1: $sql");
		}
		else{
			$sql="SELECT openingbalance from $this->tableaccounts a where a.accounts_id=$accounts_id";
			$query=$this->xoopsDB->query($sql);
			if($row=$this->xoopsDB->fetchArray($query))
				$lastbalance=$row['openingbalance'];
			$this->log->showLog(4,"Get Last balance $lastbalance with SQL2: $sql");
			}
		return $lastbalance;
/*
	$sql="SELECT period_year,period_month FROM $this->tableperiod where period_id=$period_id";
	$this->log->showLog(4,"Call accBalanceBFAmount with SQL1:$sql");
	$year=0;
	$month=0;
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){

	$year=$row['period_year'];
	$month=$row['period_month'];
	}
	else
		return 0;
	$dayfilter="b.batchdate < '$year-$month-01'";
	if($includethismonth=='Y')
		$dayfilter="b.batchdate <= '$year-$month-31'";


	if(strlen($month)==1)
		$month='0'.$month;

	$sqlgetbf="SELECT sum(t.amt) as balanceamt
		FROM $this->tablebatch b
		INNER JOIN $this->tabletransaction t on b.batch_id=t.batch_id
		INNER JOIN $this->tableaccounts a on t.accounts_id=a.accounts_id
		where $dayfilter and a.accounts_id=$accounts_id
		GROUP BY a.accountcode_full,a.accounts_name,a.account_type";
	$this->log->showLog(4,"Call accBalanceBFAmount with SQL2:$sqlgetbf");
	$querygetbf=$this->xoopsDB->query($sqlgetbf);
	if($rowgetbf=$this->xoopsDB->fetchArray($querygetbf))
	 return $rowgetbf['balanceamt'];
	else
	return 0;
*/
  }


 public function getAccountDateRangeValue($datefrom,$dateto,$accounts_id,$bpartner_id,$organization_id=0){

        $wherestr = " and t.branch_id = $organization_id ";
	$sql="SELECT case when sum(t.amt) is null then 0 else sum(t.amt) end as transactionamt
		 from $this->tabletransaction t
                  inner join $this->tablebatch b on t.batch_id=b.batch_id
		 INNER JOIN $this->tableaccounts a on a.accounts_id = t.accounts_id
		 where b.batchdate between '$datefrom' and '$dateto' and
                    t.bpartner_id=$bpartner_id and b.iscomplete=1 and
		 a.hierarchy LIKE '%[$accounts_id]%' $wherestr ";
	$this->log->showLog(4,"Call getAccountDateRangeBalance($datefrom,$dateto,$accounts_id,$bpartner_id) with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		return $row['transactionamt'];
	}
	else
		return 0;//if can't execute sql3, return 0;
  }
  
  
public function getProfitAndLostInPeriod($period_id){
	global $defaultorganization_id;
  $sql="select (SELECT case when sum(t.amt) is null then 0  else sum(t.amt) end as amt
		from $this->tablebatch b
		inner join $this->tabletransaction t on b.batch_id=t.batch_id
		inner join $this->tableaccounts a on a.accounts_id=t.accounts_id
		inner join $this->tableaccountgroup g on a.accountgroup_id=g.accountgroup_id
		inner join $this->tableaccountclass c on c.accountclass_id=g.accountclass_id
		where b.period_id = $period_id and b.iscomplete = 1 and b.organization_id=$defaultorganization_id
		and (c.classtype='1S' OR c.classtype='3O')) +
		(SELECT case when sum(t.amt) is null then 0  else sum(t.amt) end as amt
		from $this->tablebatch b
		inner join $this->tabletransaction t on b.batch_id=t.batch_id
		inner join $this->tableaccounts a on a.accounts_id=t.accounts_id
		inner join $this->tableaccountgroup g on a.accountgroup_id=g.accountgroup_id
		inner join $this->tableaccountclass c on c.accountclass_id=g.accountclass_id
		where b.period_id = $period_id and b.iscomplete = 1 and b.organization_id=$defaultorganization_id
		and (c.classtype='2C' or c.classtype='4X')) as amt from dual";
//echo "<br/>";
	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
	return $row['amt']*-1;
	}
	return 0;
}

public function getSalesInPeriod($period_id){
	global $defaultorganization_id;
	$this->log->showLog(3,"Call getSalesInPeriod with SQL:$sql");

	 $sql="select case when sum(t.amt) is null then 0  else sum(t.amt) end as amt
		from $this->tablebatch b
		inner join $this->tabletransaction t on b.batch_id=t.batch_id
		inner join $this->tableaccounts a on a.accounts_id=t.accounts_id
		inner join $this->tableaccountgroup g on a.accountgroup_id=g.accountgroup_id
		inner join $this->tableaccountclass c on c.accountclass_id=g.accountclass_id
		where b.period_id = $period_id and b.iscomplete = 1 and b.organization_id=$defaultorganization_id
		and (c.classtype='1S' or c.classtype='3O')";
	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
	return $row['amt']*-1;
	}
	return 0;
}
public function bPartnerBalanceBFAmount($period_id,$bpartner_id,$bpartnertype){
	//debtor=>$bpartnertype=2, creditor $$bpartnertype=3
	$sql="SELECT period_year,period_month FROM $this->tableperiod where period_id=$period_id";
	$this->log->showLog(4,"Call accBalanceBFAmount with SQL1:$sql");
	$year=0;
	$month=0;
	$query=$this->xoopsDB->query($sql);	
	$this->log->showLog(4,"Call bPartnerBalanceBFAmount with SQL1:$sql");
	if($row=$this->xoopsDB->fetchArray($query)){
	$year=$row['period_year'];
	$month=$row['period_month'];
	}	
	else
		return 0;

	if(strlen($month)==1)
		$month="0".$month;
	if($bpartnertype==2)
	$sqlgetbf="SELECT case when sum(t.amt) is null then 0 else sum(t.amt) end as balanceamt
		FROM $this->tablebatch b  
		INNER JOIN $this->tabletransaction t on b.batch_id=t.batch_id 
		INNER JOIN $this->tablebpartner bp on bp.bpartner_id=t.bpartner_id
		INNER JOIN $this->tableaccounts a on bp.debtoraccounts_id=a.accounts_id
		where  (b.batchdate ='0000-00-00' OR 
		b.batchdate < '$year-$month-01') 
		AND bp.bpartner_id=$bpartner_id and b.iscomplete=1 And a.account_type=2";
	else
	$sqlgetbf="SELECT case when sum(t.amt) is null then 0 else sum(t.amt) end as balanceamt
		FROM $this->tablebatch b  
		INNER JOIN $this->tabletransaction t on b.batch_id=t.batch_id 
		INNER JOIN $this->tablebpartner bp on bp.bpartner_id=t.bpartner_id
		INNER JOIN $this->tableaccounts a on bp.creditoraccounts_id=a.accounts_id
		where  (b.batchdate ='0000-00-00' OR 
		b.batchdate < '$year-$month-01') 
		AND bp.bpartner_id=$bpartner_id and b.iscomplete=1 And a.account_type=3";

	//generate transaction summary when the record never exist
		if($result=="NORECORD"){
			$sqlinsert="SELECT FROM $this->tabletransaction t 
				inner join $this->tablebatch b on b.batch_id=t.batch_id
				where t.bpartner_id=$bpartner_id and t.accounts_id=$accounts_id
				and";
		}
	
		else



	$this->log->showLog(4,"Call bPartnerBalanceBFAmount with SQL2:$sqlgetbf");
	//echo "Call bPartnerBalanceBFAmount with SQL2:$sqlgetbf";

	$querygetbf=$this->xoopsDB->query($sqlgetbf);
	if($rowbalance=$this->xoopsDB->fetchArray($querygetbf)){
		$balanceamt=$rowbalance['balanceamt'];
		return $balanceamt;
	}
	else
	return 0; 

  }

  public function bPartnerAging($period_id,$monthadjustment,$bpartner_id){


	$sql1="SELECT period_year,period_month FROM $this->tableperiod where period_id=$period_id";
	$this->log->showLog(4,"Call bPartnerHistoryBalance with SQL1:$sql");
	$year=0;
	$month=0;
	$query1=$this->xoopsDB->query($sql1);	
	$this->log->showLog(4,"Call bPartnerBalanceBFAmount with SQL1:$sql1");
	if($row=$this->xoopsDB->fetchArray($query1)){
	$year=$row['period_year'];
	$month=$row['period_month'];
	$year_ori=$row['period_year'];
	$month_ori=$row['period_month'];
	}	
	else
		$result=0; //return 0 if cannot find the period



	//continue program
	if($month <= $monthadjustment){
	$month = $month + 12;
	$year=$year-1;
	}
	
	$month=$month-$monthadjustment;
	

	$sql2="SELECT period_id FROM $this->tableperiod 
		where period_month=$month and period_year =$year ";
	
	$this->log->showLog(4,"Call bPartnerHistoryBalance with SQL2:$sql2");

	$query2=$this->xoopsDB->query($sql2);	
	if($row=$this->xoopsDB->fetchArray($query2)){
		$targetperiod_id=$row['period_id'];
	}	
	else{
		$result=0;
	}

	//continue to find the balance : lastbalance => transactionamt
	/*
	$sql3="SELECT case when transactionamt is null then 0 else transactionamt end as transamt FROM $this->tabletranssummary 
		where bpartner_id=$bpartner_id and period_id=$targetperiod_id";*/

	if(strlen($month) == 1)
	$month = "0".$month;
	
	$batchdatesql = $year."-".$month;

	$sqldebit="select case when sum(amt) is null then 0  else sum(amt) end as amtdebit 
		from $this->tablebatch a, $this->tabletransaction b 
		where a.batch_id = b.batch_id 
		and b.bpartner_id=$bpartner_id and a.batchdate like '$batchdatesql%' 
		and amt > 0 and a.iscomplete = '1' ";

	$sqlcredit="select case when sum(amt) is null then 0  else sum(amt) end as amtcredit 
		from $this->tablebatch a, $this->tabletransaction b 
		where a.batch_id = b.batch_id 
		and b.bpartner_id=$bpartner_id and a.batchdate like '$batchdatesql%' 
		and amt < 0 and a.iscomplete = '1' ";
	
	$sql3 = "select ($sqldebit) as amtdebit,($sqlcredit)*-1 as amtcredit ";
	
	$query3=$this->xoopsDB->query($sql3);
	if($row=$this->xoopsDB->fetchArray($query3)){
		$amtdebit= $row['amtdebit'];
		$amtcredit= $row['amtcredit'];
		$result=1;
	}else{
	$result=0;
	}
	
	if($result==0){
	$amtdebit=0;
	$amtcredit=0;
	}
	
	//echo "<br>";
	//echo "$amtdebit - $amtcredit <br>";
	return array($amtdebit,$amtcredit);

	// end looping

  }
public function getCOGSAndExpensesInPeriod($period_id){
	global $defaultorganization_id;
	$this->log->showLog(3,"Call getSalesInPeriod with SQL:$sql");

	 $sql="select case when sum(t.amt) is null then 0  else sum(t.amt) end as amt
		from $this->tablebatch b
		inner join $this->tabletransaction t on b.batch_id=t.batch_id
		inner join $this->tableaccounts a on a.accounts_id=t.accounts_id
		inner join $this->tableaccountgroup g on a.accountgroup_id=g.accountgroup_id
		inner join $this->tableaccountclass c on c.accountclass_id=g.accountclass_id
		where b.period_id = $period_id and b.iscomplete = 1 and b.organization_id=$defaultorganization_id
		and (c.classtype='2C' or c.classtype='4X')";
	$this->log->showLog(4,"With SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
	return $row['amt'];
	}
	return 0;
}


function getBPartnerCreditStatus($accounts_id,$bpartner_id,$type="D"){ //type D =debtor, type C =creditor
    if($type=="D"){
        $acctype=2;
    }
    else{
        $acctype=3;
    }
$this->log->showLog(3,"Access  getBPartnerCreditStatus($accounts_id,$bpartner_id,$type");
    $sql="SELECT bp.bpartner_id,bp.bpartner_name, sum(t.amt) as balance,
            bp.salescreditlimit, bp.enforcesalescreditlimit,bp.purchasecreditlimit,bp.enforcepurchasecreditlimit
            from sim_simbiz_transaction t
            inner join sim_simbiz_batch b on t.batch_id=b.batch_id
            inner join sim_simbiz_accounts a on a.accounts_id=t.accounts_id
            inner join sim_bpartner bp on t.bpartner_id=bp.bpartner_id
            where t.accounts_id=$accounts_id and t.bpartner_id=$bpartner_id and a.account_type =$acctype and b.iscomplete=1";
$this->log->showLog(4,"With SQL : $sql");

  $query=$this->xoopsDB->query($sql);
    while($row=$this->xoopsDB->fetchArray($query)){
            if($type=="D"){
               return array(abs($row['balance']),$row['salescreditlimit'],$row['enforcesalescreditlimit']);
            }
            else{
               return array(abs($row['balance']),$row['purchasecreditlimit'],$row['enforcepurchasecreditlimit']);
            }

        
    }
    return array(0,0,0);
}


} // end of ClassAccounts

?>

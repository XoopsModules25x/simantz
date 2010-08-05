<?php


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
  private $xoopsDB;
  private $tableprefix;
  private $tableaccounts;
  private $tabletransaction;
  private $tablebatch;
  private $tableaccountgroup;
  private $tableaccountclass;
  private $tabletranssummary;
  private $tableperiod;
  
 

  private $tablebpartner;

  private $log;

//constructor
   public function Accounts(){
	global $xoopsDB,$log,$tableaccounts,$tablebpartner,$tablebpartnergroup,$tabletax,$tablebatch,$tabletranssummary,$tableperiod,
		$tableorganization,$tableaccountgroup,$tableaccounts,$tablecurrency,$tabletransaction,$tableaccountclass;
  	$this->xoopsDB=$xoopsDB;
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

	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int accounts_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $accounts_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	$styleop = "";
	$orgctrl="";
	$stylelevel1 = "";
	
	

	$this->created=0;
	if ($type=="new"){
		$header="New Accounts";
		$action="create";
	 	
		if($accounts_id==0){
			$this->accounts_name="";

			$this->defaultlevel=10;
			$this->openingbalance=0;
			$placeholderchecked="";
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

		$account_typectrl="<select name='account_type' onchange='changeAccountType()'>
			<option value='1' $selectedgeneral>General Account</option>
			<option value='2' $selecteddebtor>Trade Debtor</option>
			<option value='3' $selectedcreditor>Trade Creditor</option>
			<option value='4' $selectedbank>Bank</option>
			<option value='7' $selectedbank>Cash</option></select>";
	}
	else
	{
		
		$action="update";
		if($this->account_type !=5 && $this->account_type !=6 && $this->accounts_name !="Equity")
		$savectrl="<input name='accounts_id' value='$this->accounts_id' type='hidden'>
			<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$tableaccounts' type='hidden'>".
		"<input name='id' value='$this->accounts_id' type='hidden'>".
		"<input name='idname' value='accounts_id' type='hidden'>".
		"<input name='title' value='Accounts' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		if($this->placeholder==1)
			$placeholderchecked="CHECKED";
		else
			$placeholderchecked="";

		if(!$this->allowChangePlaceHolderSetting($this->accounts_id)){
			$placeholderreadonly=' onclick="javascript:if(this.checked==true){this.checked=false;}else{this.checked=true}" ';
			$displayallowchangeplaceholder="Place holder setting can't change";
		}	
		else
			$displayallowchangeplaceholder='';
		switch($this->account_type){
			case "1":
				$account_typectrl="<input name='accountype_text' value='General Account' readonly>";
			break;
			case "2":
				$account_typectrl="<input name='accountype_text' value='Trade Debtor' readonly>";
			break;
			case "3":
				$account_typectrl="<input name='accountype_text' value='Trade Creditor' readonly>";
			break;
			case "4":
				$account_typectrl="<input name='accountype_text' value='Bank' readonly>";
			break;
			case "5":
				$account_typectrl="<input name='accountype_text' value='Opening Balance' readonly>";
			break;
			case "6":
				$account_typectrl="<input name='accountype_text' value='Retain Earning' readonly>";
			break;
			case "7":
				$account_typectrl="<input name='accountype_text' value='Cash' readonly>";
			break;

		}
	
		$account_typectrl=$account_typectrl."<input name='account_type' value='$this->account_type' type='hidden'>";
		$header="Edit Accounts";
		
		if($this->allowDelete($this->accounts_id) && $this->account_type !=5 && $this->account_type !=6)
		$deletectrl="<FORM action='accounts.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this accounts?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->accounts_id' name='accounts_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='accounts.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

		if($this->accounts_name == "Opening Balance" || $this->accounts_name == "Equity")
		$styleop = " readonly ";


		if($this->placeholder == 1)
		$stylelevel1 = " readonly ";
		
		$accountfull = substr($this->accountcode_full,0,(strlen($this->accountcode_full) - strlen($this->accounts_code)));		

    echo <<< EOF


<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateAccounts()" method="post"
 action="accounts.php" name="frmAccounts"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="2" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl</td>
      </tr>
 <tr>
        <td class="head">Accounts Code $mandatorysign</td>
        <td class="even" >
	<input maxlength="10" size="5" value="$accountfull" readonly>
	<input maxlength="10" size="5" name="accounts_code" value="$this->accounts_code"></td>
      </tr>
 <tr>
        <td class="head">Accounts Name $mandatorysign</td>
        <td class="even" ><input maxlength="60" size="30" name="accounts_name" value="$this->accounts_name" $styleop></td>
      </tr>
 <tr>
        <td class="head">Accounts Group $mandatorysign</td>
        <td class="even" >$this->accountgroupctrl</td>
      </tr>

 <tr>
        <td class="head">Account Type</td>
        <td class="even" >
	$account_typectrl	
	</td>
      </tr>


    <tr>
        <td class="head">Parent Account</td>
        <td class="even" >$this->parentaccountsctrl <input name='previousparentaccounts_id' value='$this->parentaccounts_id' type='hidden'></td>
      </tr>

      <tr>
   	<td class="head"><!--Opening Balance $mandatorysign-->Last Balance</td>
        <td class="even" ><div style="display:none"><input name='openingbalance' value=$this->openingbalance $stylelevel1></div> $this->lastbalance
			<input name='previousopeningbalance' value=$this->openingbalance $stylelevel1 type='hidden'></td>
      </tr>
      <tr>
   	<td class="head">Default Level $mandatorysign</td>
	        <td class="even" ><input maxlength="3" size="3" name='defaultlevel' value='$this->defaultlevel'>
	</td>
      </tr>

 <tr>
        <td class="head">Place Holder</td>
        <td class="even"><input type="checkbox" $placeholderchecked name="placeholder" $placeholderreadonly onchange='placeholdercontrol()'>
			$displayallowchangeplaceholder</td>
      </tr>
     <tr style="display:none">
        <td class="head">Tax</td>
        <td class="even" >$this->taxctrl (Reserved For Future Functionality)</td>
      </tr>
    <tr>
        <td class="head">Description</td>
        <td class="even"><input maxlength="60" size="30" name="description" value="$this->description"></td>
      </tr>
	
    </tbody>
  </table>
$mandatorysign Compulsory Field
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td></tbody></table>
  <br>

$recordctrl

EOF;
  } // end of member function getInputForm

  public function getAccountParentCode($parentaccounts_id){
	$retval = '';
	$sql = "select accountcode_full from $this->tableaccounts where accounts_id = $parentaccounts_id ";

	$this->log->showLog(4,"SQL get parent code :" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['accountcode_full'];
	}

	return $retval;
  }

  public function getAccountParentID($accounts_id){
	$retval = '';
	$sql = "select parentaccounts_id from $this->tableaccounts where accounts_id = $accounts_id ";

	$this->log->showLog(4,"SQL get parent ID :" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['parentaccounts_id'];
	}

	return $retval;
  }

//get full account code
  public function updateChildTree($accounts_id){
	$accountparentfull_code = $this->getAccountParentCode($accounts_id);
	

	$sql = "select * from $this->tableaccounts where parentaccounts_id = $accounts_id";

	$this->log->showLog(4,"SQL get list code :" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	while($row=$this->xoopsDB->fetchArray($query)){
	$accounts_code = $row['accounts_code'];
	$accounts_id = $row['accounts_id'];
	$treelevel = $row['treelevel']; 
	
	
	//$accountcode_full = substr($accountparentfull_code,0,$treelevel-1)."$accounts_code";
	$accountcode_full = $accountparentfull_code."$accounts_code";

	$sqlupdate = "update $this->tableaccounts set accountcode_full = '$accountcode_full' where accounts_id = $accounts_id ";
	
	$rs=$this->xoopsDB->query($sqlupdate);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update accounts failed:".mysql_error(). ":$sqlupdate");
		return false;
	}

	$this->updateChildTree($accounts_id);
	}
	
  }
/*
  public function updateHierarchyTop($accounts_id,$hierarchy_parent=""){
	
	if($hierarchy_parent == "")
	$hierarchy_parent = $this->getParentHierarchy($accounts_id);

	$sql = "select * from $this->tableaccounts where parentaccounts_id = $accounts_id";

	$hierarchy_parent = $hierarchy_parent."[$accounts_id]";
	

	$this->log->showLog(4,"SQL get list code :" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	while($row=$this->xoopsDB->fetchArray($query)){
	

	$accounts_code = $row['accounts_code'];
	$accounts_id = $row['accounts_id'];
	$treelevel = $row['treelevel'];
	//$hierarchy = $row['hierarchy'];
	
	
	$hierarchy = $hierarchy_parent."[$accounts_id]";

	$sqlupdate = "update $this->tableaccounts set hierarchy = '$hierarchy' where accounts_id = $accounts_id ";
	
	$rs=$this->xoopsDB->query($sqlupdate);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update hierarchy accounts failed:".mysql_error(). ":$sqlupdate");
		return false;
	}

	$this->updateHierarchy($accounts_id,$hierarchy_parent);
	}
	
  }
*/

//update hierarchy 
  public function updateHierarchy($accounts_id=0,$hierarchy_parent=""){
	
	$hierarchy_1st = "";
	$accounts_id_1st = "";
	$is_1st = $hierarchy_parent;
	if($hierarchy_parent == ""){
	$hierarchy_parent = $this->getParentHierarchy($accounts_id);
	$hierarchy_1st = $hierarchy_parent;
	$accounts_id_1st = $accounts_id;
	}

	$sql = "select * from $this->tableaccounts where parentaccounts_id = $accounts_id and accounts_id > 0 ";

	$hierarchy_parent = $hierarchy_parent."[$accounts_id]";
	

	$this->log->showLog(4,"SQL get list code :" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;

	$accounts_code = $row['accounts_code'];
	$accounts_id = $row['accounts_id'];
	$treelevel = $row['treelevel'];
	//$hierarchy = $row['hierarchy'];
	
	
	$hierarchy = $hierarchy_parent."[$accounts_id]";

	$detectzerohierarchy=substr($hierarchy,0,3);
	if($detectzerohierarchy=="[0]"){
	$hierarchy=substr_replace($hierarchy,"",0,3);
	$this->log->showLog(3, "Detect [0] in hierarchy, replace to $hierarchy");
	}
	else
	$this->log->showLog(3, "Not Detect [0] in hierarchy, current string: $hierarchy");

	$sqlupdate = "update $this->tableaccounts set hierarchy = '$hierarchy' where accounts_id = $accounts_id ";
	
	$rs=$this->xoopsDB->query($sqlupdate);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update hierarchy accounts failed:".mysql_error(). ":$sqlupdate");
		return false;
	}

	$this->updateHierarchy($accounts_id,$hierarchy_parent);
	}

	//if($i == 0){
	if($is_1st == ""){
	$hierarchy_1st = $hierarchy_1st."[$accounts_id_1st]";

	$detectzerohierarchy=substr($hierarchy_1st,0,3);

	if($detectzerohierarchy=="[0]"){
	$hierarchy_1st=substr_replace($hierarchy_1st,"",0,3);
	$this->log->showLog(3, "Detect [0] in hierarchy, replace to $hierarchy_1st");
	}
	else
	$this->log->showLog(3, "Not Detect [0] in hierarchy, current string: $hierarchy_1st");

	$sqlupdate = "update $this->tableaccounts set hierarchy = '$hierarchy_1st' where accounts_id = $accounts_id_1st ";

	$rs=$this->xoopsDB->query($sqlupdate);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update hierarchy accounts failed:".mysql_error(). ":$sqlupdate");
		return false;
	}

	}
	
  }

  public function getParentHierarchy($accounts_id){
	global $hierarchy;
	$retval = "";
	$parentaccounts_id = $this->getAccountParentID($accounts_id);
	
	if($parentaccounts_id > 0)
	$hierarchy = "[$parentaccounts_id]$hierarchy";
	else
	$hierarchy ="";
	$sql = "select * from $this->tableaccounts where accounts_id = $parentaccounts_id and accounts_id > 0";
	
	$this->log->showLog(4,"SQL get list code :" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	$i=0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$accounts_id = $row['accounts_id'];

	$this->getParentHierarchy($accounts_id);
	}
	
	
	return $hierarchy;
  }

  /**
   * Update existing accounts record
   *
   * @return bool
   * @access public
   */
  public function updateAccounts( ) {
	$accountparentfull_code = $this->getAccountParentCode($this->parentaccounts_id);
	$accountcode_full = $accountparentfull_code."$this->accounts_code";
	//$accountcode_full = substr($accountparentfull_code,0,$this->treelevel-1)."$this->accounts_code";


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableaccounts SET 
	accounts_name='$this->accounts_name',description='$this->description',openingbalance=$this->openingbalance,
	updated='$timestamp',updatedby=$this->updatedby,defaultlevel=$this->defaultlevel,accountgroup_id=$this->accountgroup_id,
	organization_id=$this->organization_id,parentaccounts_id=$this->parentaccounts_id,account_type=$this->account_type,
	tax_id=$this->tax_id,accountgroup_id=$this->accountgroup_id,placeholder=$this->placeholder,
	accounts_code='$this->accounts_code',treelevel=$this->treelevel, accountcode_full = '$accountcode_full' 
	WHERE accounts_id='$this->accounts_id'";
	
	$this->log->showLog(3, "Update accounts_id: $this->accounts_id, $this->accounts_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update accounts failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		//$equity_id = $this->getAccountsID($this->organization_id,"Equity");

		//$this->updateChildTree($this->accounts_id);
	/*
		$this->repairAccounts($this->getTopParent($this->accounts_id),"N");
		$this->updateHierarchy($this->accounts_id);
		$this->repairAccounts($this->getTopParent($this->accounts_id),"N");
	*/
		//$this->repairAccounts($equity_id);
		$this->log->showLog(3, "Update accounts successfully.");
		return true;
	}
  } // end of member function updateAccounts
  
   public function toggelAccountHide( ) {
//	$accountparentfull_code = $this->getAccountParentCode($this->parentaccounts_id);
//	$accountcode_full = $accountparentfull_code."$this->accounts_code";
	//$accountcode_full = substr($accountparentfull_code,0,$this->treelevel-1)."$this->accounts_code";
	
	if($this->ishide==0)
		$newhide=1;
	else
		$newhide=0;

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableaccounts SET ishide=$newhide	
	WHERE accounts_id='$this->accounts_id'";
	
	$this->log->showLog(3, "Update accounts_id: $this->accounts_id, $this->accounts_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update accounts failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
	
		$this->log->showLog(3, "Update accounts successfully.");
		return true;
	}
  } // end of member function updateAccounts
  

  /**
   * Save new accounts into database
   *
   * @return bool
   * @access public
   */
  public function insertAccounts( ) {
	$accountparentfull_code = $this->getAccountParentCode($this->parentaccounts_id);
	$accountcode_full = $accountparentfull_code."$this->accounts_code";
	//$accountcode_full = substr($accountparentfull_code,0,$this->treelevel-1)."$this->accounts_code";

   	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new accounts $this->accounts_name");
 	$sql="INSERT INTO $this->tableaccounts (accounts_name,created,createdby,
	updated,updatedby,defaultlevel,organization_id,description,openingbalance,parentaccounts_id,account_type,tax_id,
	placeholder,accountgroup_id,accounts_code,treelevel,accountcode_full,ishide) values(
	'$this->accounts_name','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->defaultlevel,$this->organization_id,'$this->description',$this->openingbalance,
	$this->parentaccounts_id,$this->account_type, $this->tax_id,$this->placeholder,$this->accountgroup_id,'$this->accounts_code',
	$this->treelevel,'$accountcode_full',0)";

	$this->log->showLog(4,"Before insert accounts SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,__FILE__. ", LINE:". __LINE .":Failed to insert accounts code $accounts_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new accounts $accounts_name successfully"); 
		return true;
	}
  } // end of member function insertAccounts

  public function insertBatch($accounts_id,$bpartner_id=0){
  global $defaultorganization_id;
	//$this->accounts_id = $this->getLatestAccountsID();
	$batchno = getNewCode($this->xoopsDB,"batchno",$this->tablebatch);
	$timestamp= date("y/m/d H:i:s", time()) ;

	$sqlbatch=	"INSERT INTO $this->tablebatch 
			(batch_name,
			reuse,
			created,createdby,updated,updatedby,
			period_id,
			organization_id,batchno,iscomplete,isshow) 
			values
			('',0,'$timestamp',$this->createdby,'$timestamp',$this->updatedby,
			0,$defaultorganization_id,'$batchno',1,0)";

	

	
	$this->log->showLog(4,"Before insert batch SQL:$sqlbatch");
	$rs=$this->xoopsDB->query($sqlbatch);
	
	if (!$rs){
		$this->log->showLog(1,__FILE__. ", LINE:". __LINE .":Failed to insert batch account code $accounts_name:" . mysql_error() . ":$sqlbatch");
		return false;
	}else{
		$batch_id = $this->getLatestBatchID();
		$amtob = $this->openingbalance;
		if($this->openingbalance == "")
		$amtob = 0;

		$sqltrans=	"INSERT INTO $this->tabletransaction (seqno,batch_id,accounts_id,amt,bpartner_id)
				VALUES (0,$batch_id,$accounts_id,$amtob,$bpartner_id)";

		$this->log->showLog(4,"Before insert batch SQL:$sqltrans");
		$rs=$this->xoopsDB->query($sqltrans);
		
		if (!$rs){
		$this->log->showLog(1,__FILE__. ", LINE:". __LINE .":Failed to insert transaction account code $accounts_name:" . mysql_error() . ":$sqltrans");
		return false;
		}else{
		//$this->updateOpeningBalance($amtob,0);
		}
	
	}
	
  }

  public function fetchAccounts( $accounts_id) {


	$this->log->showLog(3,"Fetching accounts detail into class Accounts.php.<br>");
		
	$sql="SELECT accounts_id,accounts_name,defaultlevel,organization_id,description,openingbalance,parentaccounts_id,account_type,
		accounts_code,tax_id,accountgroup_id,placeholder,lastbalance,accountcode_full 
		 from $this->tableaccounts where accounts_id=$accounts_id";
	
	$this->log->showLog(4,"ProductAccounts->fetchAccounts, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->accountcode_full=$row["accountcode_full"];
		$this->accounts_code=$row["accounts_code"];
		$this->accounts_name=$row["accounts_name"];
		$this->parentaccounts_id=$row["parentaccounts_id"];
		$this->account_type=$row["account_type"];
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

	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Accounts->fetchAccounts,failed to fetch data into databases:" . mysql_error(). ":$sql");	
	}
  } // end of member function fetchAccounts

  /**
   * Delete particular accounts id
   *
   * @param int accounts_id 
   * @return bool
   * @access public
   */
  public function deleteAccounts( $accounts_id,$batch_id ) {
    	$this->log->showLog(2,"Warning: Performing delete accounts id : $accounts_id !");
	$sql="DELETE FROM $this->tableaccounts where accounts_id=$accounts_id";
	

	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: accounts ($accounts_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{

		if($batch_id > 0){
		$sqlbatchdelete = "delete from $this->tablebatch where batch_id = $batch_id";
		$this->log->showLog(4,"Delete Bacth SQL Statement: $sql");
	
		$rs=$this->xoopsDB->query($sqlbatchdelete);

		if (!$rs){
		$this->log->showLog(1,"Error: batch ($batch_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
		}
	
		}
		$this->log->showLog(3,"accounts ($accounts_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteAccounts


  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllAccounts( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductAccounts->getSQLStr_AllAccounts: $sql");
/* a.accounts_name,a.accounts_code,a.accounts_id,a.organization_id,a.defaultlevel,a.openingbalance,a.lastbalance,
		g.accountgroup_name,g.initial,a.placeholder,a.treelevel,a.accountgroup_id,t.tax_name, c.currency_code*/
	
    $sql="SELECT *
		FROM $this->tableaccounts a 
		inner join $this->tableaccountgroup g on a.accountgroup_id=g.accountgroup_id 
		inner join $this->tabletax t on a.tax_id=t.tax_id 
		inner join $this->tableorganization o on o.organization_id=a.organization_id 
		 $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showaccountstable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllAccounts

 public function showAccountsTable($wherestring,$orderbystring){

	
	//if($showaccountcode=="on")
	//$orderbystring = "ORDER BY a.accountcode_full,a.accounts_name";
	//else
	//$orderbystring = "ORDER BY a.accountgroup_id,a.parentaccounts_id,a.accounts_name";
	
	$orderbystring = "ORDER BY a.accountcode_full,a.accounts_name";

	
	//$orderbystring = "ORDER BY a.accounts_id,a.parentaccounts_id,a.accounts_name";
	global $defcurrencycode;
	$this->log->showLog(3,"Showing Accounts Table");
	$sql=$this->getSQLStr_AllAccounts($wherestring,$orderbystring);
	if($this->isAdmin)
		$repairaccctrl='<td><input type="button" value="Repair Account" onclick="repairAccounts()"></td>';
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='1'>
  		<tbody>
    		
EOF;
	$rowtype="";
	$i=0;
	$hideparent=0;
	$hideaccounts_id=0;
	$parenttreelevel=100;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$parentaccounts_id=$row['parentaccounts_id'];
		$accounts_id=$row['accounts_id'];
		$accountgroup_id=$row['accountgroup_id'];
		$accountgroup_name=$row['accountgroup_name'];
		$accounts_name=$row['accounts_name'];
		$accounts_code=$row['accounts_code'];
		$accountcode_full=$row['accountcode_full'];
		$initial=$row['initial'];
		$treelevel=$row['treelevel'];
		$placeholder=$row['placeholder'];
		$currency_code=$row['currency_code'];
		$lastbalance=$row['lastbalance'];
		$hierarchy=$row['hierarchy'];
		$defaultlevel=$row['defaultlevel'];
		$openingbalance=$row['openingbalance'];
		$tax_name=$row['tax_name'];
		$ishide=$row['ishide'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";


		$prefixpic="";

		for($j=1; $j<$treelevel;$j++){
		$prefixpic=$prefixpic."&nbsp;&nbsp;&nbsp;&nbsp;";
		$divwidth=$treelevel*10;
		}
		//$accountparentfull_code = $this->getAccountParentCode($parentaccounts_id);
		//$accountcode_full = substr($accountparentfull_code,0,$treelevel-1)."$accounts_code";

		if($placeholder==1){
			if($ishide==0){
				$displayicon="images/closeplaceholder.gif";
				if($parenttreelevel>=$treelevel)
				$hideparent=0;
			}
			else{
				if($parenttreelevel>=$treelevel){
					$hideparent=1;
					$parenttreelevel=$treelevel;
					$hideaccounts_id=$accounts_id;				
				}


				$displayicon="images/openplaceholder.gif";
			}
		$accountlink="<div style='width:$divwidthpx; float:left'>$prefixpic </div><div style='width:13px; float:left'>
						<form action='accounts.php' method='POST'>
						<input name='accounts_id' value='$accounts_id' type='hidden'>
						<input name='action' value='hide' type='hidden'>
						<input name='ishide' value='$ishide' type='hidden'>
						<input type='image' src='$displayicon' title='Show/Hide Child Account'>
					</form></div><div style='width:330px; float:left'>
				<A href='accounts.php?action=edit&accounts_id=$accounts_id' title='Edit this account'>$accountcode_full-$accounts_name</A></div>";
		$createchild="<FORM action='accounts.php' method='POST'>
				<input name='action' value='addchild' type='hidden'>
				<input name='parentaccounts_id' value='$accounts_id'  type='hidden'>
				<input name='accountgroup_id' value='$accountgroup_id'  type='hidden'>
				<input name='parentaccounts_code' value='$accounts_code'  type='hidden'>
				<input name='submit' src='images/addaccount.gif' type='image' title='Add child Account'>
				</FORM>";
		
		}
		else{
		//$accountlink="$prefixpic<image src='images/list.gif'>
		//		<A href='accounts.php?action=edit&accounts_id=$accounts_id' title='Edit Account'>
		//		$accounts_code-$accounts_name</A>";

		//$accountparentfull_code = $this->getAccountParentCode($parentaccounts_id);
		//$accountcode_full = substr($accountparentfull_code,0,$treelevel-1)."$accounts_code";

		$accountlink="$prefixpic <A href='accounts.php?action=edit&accounts_id=$accounts_id' title='Edit Account'>
				$accountcode_full-$accounts_name</A>";


		$createchild="";

		}
		

		if($placeholder == 0){
		$viewtrans="<FORM action='viewsingleledger.php' method='POST' target='_blank'>
				<input name='submit' value='viewledger' type='hidden'>
				<input name='accounts_id' value='$accounts_id'  type='hidden'>
				<input name='periodfrom_id' value='0'  type='hidden'>
				<input name='periodto_id' value='0'  type='hidden'>
				<input name='imagebutton' src='images/listledger.gif' type='image'
					title='View this month ledger.'>
				</FORM>";

		$addtrans="<FORM action='batch.php' method='POST' target='_blank'>
				<input name='action' value='viewledger' type='hidden'>
				<input name='defaultaccounts_id' value='$accounts_id'  type='hidden'>
				<input name='submit' src='images/edit.gif' type='image' title='Add Transaction'>
				</FORM>";
		$addhistory="<FORM action='transactionsummary.php' method='POST' target='_blank'>
				<input name='action' value='viewledger' type='hidden'>
				<input name='accounts_id' value='$accounts_id'  type='hidden'>
				<input name='submit' src='images/history.gif' type='image' title='View Transaction Summary History'>
				</FORM>";
		}else{
		$viewtrans = "";
		$addtrans = "";
		$addhistory="";
		}

		
		
		//$lastbalance = $this->getLastBalance($accounts_id);
		
		if($lastbalance<0){
			$lastbalance=number_format($lastbalance*-1,2);
			$lastbalance="<b style='color:red;'>$lastbalance</b>";
		}
		else
			$lastbalance=number_format($lastbalance,2);

		
		if($i == 1){
		echo <<< EOF

		<tr>
			<th style="text-align:center;">No</th>
			<th style="text-align:center;">Group</th>
			<th style="text-align:center;" width='400px'>Accounts</th>
			<th style="text-align:center;"></th>
			<th style="text-align:center;display:none">Opening ($defcurrencycode)</th>
			<th style="text-align:center;">Balance ($defcurrencycode)</th>

		</tr>
EOF;
		}
//($hideparent==0 && $parenttreelevel<=$treelevel  && $parenttreelevel!=100 ) ||
		//when the parent showing hide, child record should hide as well
		if(  $hideaccounts_id==$accounts_id  || $hideparent==0 ){
		echo <<< EOF

		<tr>
			<td  style="text-align:center;" class="$rowtype">$i</td>
			<td  style="text-align:Left;" class="$rowtype">$accountgroup_name </td>
			<td  style="text-align:left;" class="$rowtype" anowrap>$accountlink </td>
			<td  style="text-align:left;" class="$rowtype" anowrap>
				<TABLE border=0><tbody><tr>
				<td width="82%" align="left" anowrap></td>
				<td width="6%" align="right" >$createchild</td>
				<td width="6%" align="right">$viewtrans</td>
				<td width="6%" align="right">$addtrans</td>
				<td width="6%" align="right">$addhistory</td>
				</tbody></tr></TABLE>
			</td>
			<td style="text-align:right;display:none" class="$rowtype">$openingbalance</td>
			<td style="text-align:right;" class="$rowtype">$lastbalance</td>

		</tr>
EOF;
	}
	}
echo <<< EOF
	</tr></tbody>
	</table>
	<table>
	<tr>
	<td ><input type="button" value="Colapse All Tree" onclick="colapseTree()"></td>
	<td ><input type="button" value="Show Tree" onclick="showTree()"></td>
	$repairaccctrl

	</tr>
	</table>

EOF;
 }



	public function getLastBalance($accounts_id){
	
	$totalamount = 0;
	$sql = "select a.parentaccounts_id,b.amt from $this->tableaccounts a, $this->tabletransaction b , $this->tablebatch c 
		where a.accounts_id = b.accounts_id 
		and b.batch_id = c.batch_id 
		and c.iscomplete = 1 
		and a.accounts_id = $accounts_id ";

	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$totalamount += $row['amt'];
	$parentaccounts_id = $row['parentaccounts_id'];

	}

	return $totalamount;
	}

/**
   *
   * @return int
   * @access public
   */
  public function getLatestAccountsID() {
	$sql="SELECT MAX(accounts_id) as accounts_id from $this->tableaccounts;";
	$this->log->showLog(3,'Checking latest created accounts_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created accounts_id:' . $row['accounts_id']);
		return $row['accounts_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tableaccounts;";
	$this->log->showLog(3,'Checking next defaultlevel');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found next defaultlevel:' . $row['defaultlevel']);
		return  $row['defaultlevel'];
	}
	else
	return 10;
	
  } // end

 public function allowDelete($accounts_id){
 
	$sql=	"SELECT count(bpartner_id) as rowcount from $this->tablebpartner 
			where debtoraccounts_id=$accounts_id  or creditoraccounts_id=$accounts_id ";
	$this->log->showLog(3,"Accessing ProductCurrency->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " bpartner found in this account, record not deletable");
			return false;
			}
	else{
		$sql="SELECT count(*) as rowcount from $this->tabletransaction a
				INNER JOIN $this->tableaccounts b on a.accounts_id = b.accounts_id 
				where a.accounts_id=$accounts_id and (a.amt <> 0 or b.placeholder = 1) ";

		$query=$this->xoopsDB->query($sql);
		$count = 0;
		if($row=$this->xoopsDB->fetchArray($query)){
		$count = $row['rowcount'];
		}

		if($count > 0){
		$this->log->showLog(3, $row['rowcount'] . " record found in this transaction, record not deletable");
		return false;
		}else{

			$sql = 	"select count(*) as rowcount from $this->tableaccounts a, $this->tableaccountgroup b, 
					$this->tableaccountclass c 				
					where a.accountgroup_id = b.accountgroup_id 
					and b.accountclass_id = c.accountclass_id 
					and a.accounts_id = $accounts_id 
					and c.classtype = 'E' ";
	
			$query=$this->xoopsDB->query($sql);
			$count = 0;
			if($row=$this->xoopsDB->fetchArray($query)){
			$count = $row['rowcount'];
			}

			if($count > 0){
			$this->log->showLog(3, $row['rowcount'] . " record found in this transaction, record not deletable");
			return false;
			}else{
			$this->log->showLog(3,"No record under this transaction, record deletable.");
			return true;
			}
		}
		
		}
	}

 public function allowChangePlaceHolderSetting($accounts_id){
	$sql1="SELECT count(accounts_id) as childaccountqty FROM $this->tableaccounts where hierarchy LIKE '%[$accounts_id]%'";
	$this->log->showLog(4,"allowChangePlaceHolderSetting detect with SQL1:$sql1");
	$query1=$this->xoopsDB->query($sql1);
	if($row=$this->xoopsDB->fetchArray($query1))
		$childaccountqty=$row['childaccountqty'];
	else
		$childaccountqty=0;

	if($childaccountqty>1){
	$this->log->showLog(3,"$childaccountqty child account found(include this account)");

		return false; //child account found, this place holder cannot change back to child account
	}

	$sql2="SELECT count(trans_id) as trans_count FROM $this->tabletransaction where amt <> 0 and accounts_id=$accounts_id";
	$this->log->showLog(4,"allowChangePlaceHolderSetting detect with SQL2:$sql2");
	$query2=$this->xoopsDB->query($sql2);
	if($row=$this->xoopsDB->fetchArray($query2))
		$trans_count=$row['trans_count'];
	else
		$trans_count=0;

	if($trans_count>0){
	$this->log->showLog(3,"$trans_count child transaction found");
		return false; //child transaction found, the place holder setting cannot be change.
	}
	$this->log->showLog(3,"No child transaction found, user can change placeholder setting");
	return true;

 }
public function getLevel($accounts_id){
	$sql="SELECT treelevel from $this->tableaccounts where accounts_id=$accounts_id;";
	$this->log->showLog(3,"Checking treelevel for created accounts_id: $account_id with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found parent treelevel=' . $row['treelevel']);
		return $row['treelevel'];
	}
	else
	return -1;
 }

public function getNextChildAccountCode($accounts_id){
	
	$sql="SELECT max(CAST(accounts_code AS SIGNED)) as accounts_code from $this->tableaccounts where parentaccounts_id=$accounts_id;";
	$this->log->showLog(3,"Checking getNextChildAccountCode for  accounts_id: $accounts_id with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$accounts_code=$row['accounts_code'];
		
		$this->log->showLog(3,'Found max accounts_code=' . $row['accounts_code']);
		if ($accounts_code!="")
			return $row['accounts_code']+1;
		else
			return "";
	}
	else
	return "";

}

 public function getLatestBatchID() {
	$sql="SELECT MAX(batch_id) as batch_id from $this->tablebatch;";
	$this->log->showLog(3,'Checking latest created batch_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created batch_id:' . $row['batch_id']);
		return $row['batch_id'];
	}
	else
	return -1;
	
  } // end

  public function getPrevOpeningBalance(){
	$retval = 0;
	$sql = "select * from $this->tableaccounts where accounts_id = $this->accounts_id ";
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['openingbalance'];
	}
	return $retval;
  }

  public function checkBatchLine(){
	$retval = true;
	$sql = "select * from $this->tablebatch a, $this->tabletransaction b 
		where a.batch_id = b.batch_id 
		and b.accounts_id = $this->accounts_id 
		and a.isshow = 0 ";

	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = false;
	}
	return $retval;
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
  
  public function insertDefaultAcc($organization_id,$userid){

  $timestamp= date("y/m/d H:i:s", time()) ;
  
  $sqlaccgroup =
  "INSERT INTO $this->tableaccountgroup (`accountgroup_name`, `isactive`, `defaultlevel`, `description`, `accountclass_id`, `created`, `createdby`, `updated`, `updatedby`, `organization_id`, `initial`) VALUES
('Assets', 1, 10, '', 1, '$timestamp', 1, '$timestamp', 1, $organization_id, 1),
('COGS', 1, 10, '', 5, '$timestamp', 1, '$timestamp', 1, $organization_id, 5),
('Sales', 1, 10, '', 4, '$timestamp', 1, '$timestamp', 1, $organization_id, 4),
('Liabilities', 1, 10, '', 2, '$timestamp', 1, '$timestamp', 1, $organization_id, 2),
('Equity', 1, 10, '', 3, '$timestamp', 1, '$timestamp', 1, $organization_id, 3),
('Others Income', 1, 10, '', 8, '$timestamp', 1, '$timestamp', 1, $organization_id, 7),
('Memo', 1, 10, '', 6, '$timestamp', 1, '$timestamp', 1, $organization_id, 8),
('Expenses', 1, 10, '', 7, '$timestamp', 1, '$timestamp', 1, $organization_id, 6);";


	$this->log->showLog(4,"Before insert accounts SQL:$sqlinsert");
	$rs=$this->xoopsDB->query($sqlaccgroup);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert new accounts group :" . mysql_error() . ":$sqlaccgroup");
		return false;
	}
	else{
			$asset = $this->getAccGroupID($organization_id,"Assets");
			$liabilities = $this->getAccGroupID($organization_id,"Liabilities");
			$equity = $this->getAccGroupID($organization_id,"Equity");
			$cogs = $this->getAccGroupID($organization_id,"COGS");
			$expenses = $this->getAccGroupID($organization_id,"Expenses");
			$sales = $this->getAccGroupID($organization_id,"Sales");
			$op = $this->getAccGroupID($organization_id,"Equity");
			$oi = $this->getAccGroupID($organization_id,"Others Income");
			$memo = $this->getAccGroupID($organization_id,"Memo");
 echo $sqlinsert = 
"INSERT INTO $this->tableaccounts (`created`, `createdby`, `updated`, `updatedby`, `accounts_code`, `accounts_name`, `accountgroup_id`, `openingbalance`, `parentaccounts_id`, `placeholder`, `tax_id`, `lastbalance`, `organization_id`, `ishide`, `defaultlevel`, `description`, `treelevel`, `account_type`,`accountcode_full`) VALUES
('$timestamp', $userid, '$timestamp', $userid, '1', 'Assets',       $asset,       '0.00', 0, 1, 0, '0.00', $organization_id, 0, 10, '', 1, 1,'1'),
('$timestamp', $userid, '$timestamp', $userid, '2', 'Liabilities',  $liabilities, '0.00', 0, 1, 0, '0.00', $organization_id, 0, 10, '', 1, 1,'2'),
('$timestamp', $userid, '$timestamp', $userid, '3', 'Equity',       $equity,      '0.00', 0, 1, 0, '0.00', $organization_id, 0, 10, '', 1, 1,'3'),
('$timestamp', $userid, '$timestamp', $userid, '4', 'Sales',        $sales,       '0.00', 0, 1, 0, '0.00', $organization_id, 0, 10, '', 1, 1,'4'),
('$timestamp', $userid, '$timestamp', $userid, '5', 'Cost Of Sales',$cogs,        '0.00', 0, 1, 0, '0.00', $organization_id, 0, 10, '', 1, 1,'5'),
('$timestamp', $userid, '$timestamp', $userid, '6', 'Expenses',     $expenses,    '0.00', 0, 1, 0, '0.00', $organization_id, 0, 10, '', 1, 1,'6'),
('$timestamp', $userid, '$timestamp', $userid, '7', 'Others Income',$oi,          '0.00', 0, 1, 0, '0.00', $organization_id, 0, 10, '', 1, 1,'7'),
('$timestamp', $userid, '$timestamp', $userid, '8', 'Memo',         $memo,        '0.00', 0, 1, 0, '0.00', $organization_id, 0, 10, '', 1, 1,'8')
;";

			$rs=$this->xoopsDB->query($sqlinsert);
		
			if (!$rs){
				$this->log->showLog(1,"Failed to insert new accounts:" . mysql_error() . ":$sqlinsert");
				return false;
			}else{
			
				$equity_id = $this->getAccountsID($organization_id,"Equity");
				$asset_id = $this->getAccountsID($organization_id,"Assets");
				$liabilities_id = $this->getAccountsID($organization_id,"Liabilities");
				$sales_id = $this->getAccountsID($organization_id,"Sales");
				$purchase_id = $this->getAccountsID($organization_id,"Cost Of Sales");
				$memo_id = $this->getAccountsID($organization_id,"Memo");
				$expenses_id = $this->getAccountsID($organization_id,"Expenses");

$sqlupdatehierarchy = "UPDATE $this->tableaccounts SET hierarchy=concat('[',accounts_id,']')";
$rsupdatehierarchy=$this->xoopsDB->query($sqlupdatehierarchy);
if($rsupdatehierarchy){
				$this->log->showLog(3,"Udate hierarchy successfully with SQL:$rsupdatehierarchy");
}else{
	$this->log->showLog(1,"Failed to update hierarchy at line:". __LINE__ .",". mysql_error() . ":$sqlupdatehierarchy");
return false;
}

$sqlinsertdefaultchildacc = 
"INSERT INTO $this->tableaccounts (`created`, `createdby`, `updated`, `updatedby`, `accounts_code`, `accounts_name`, `accountgroup_id`, `openingbalance`, `parentaccounts_id`, `placeholder`, `tax_id`, `lastbalance`, `organization_id`, `ishide`, `defaultlevel`, `description`, `treelevel`, `account_type`,`accountcode_full`) VALUES 
('$timestamp', $userid, '$timestamp', $userid, '1', 'Current Asset',      $asset, '0.00', $asset_id, 1, 0, '0.00', $organization_id, 0, 10, '', 2, 1,'11'),
('$timestamp', $userid, '$timestamp', $userid, '2', 'Fixed Asset',      $asset, '0.00', $asset_id, 1, 0, '0.00', $organization_id, 0, 10, '', 2, 1,'12'),


('$timestamp', $userid, '$timestamp', $userid, '1', 'Trade Creditor',$liabilities,'0.00',$liabilities_id,0,0,'0.00',$organization_id,0,10, '', 2, 3,'21'),


('$timestamp', $userid, '$timestamp', $userid, '1', 'Opening Balance', $op, '0.00', $equity_id, 0, 0, '0.00', $organization_id, 0, 10, '', 2, 5,'31'),
('$timestamp', $userid, '$timestamp', $userid, '2', 'Retain Earning',  $op, '0.00', $equity_id, 0, 0, '0.00', $organization_id, 0, 10, '', 2, 6,'32'),
('$timestamp', $userid, '$timestamp', $userid, '3', 'Capital',         $op, '0.00', $equity_id, 0, 0, '0.00', $organization_id, 0, 10, '', 2, 1,'33'),

('$timestamp', $userid, '$timestamp', $userid, '1', 'Sales',           $sales, '0.00',  $sales_id, 0, 0, '0.00', $organization_id, 0, 10, '', 2, 1,'41'),

('$timestamp', $userid, '$timestamp', $userid, '1', 'Purchase',        $cogs, '0.00',  $purchase_id, 0, 0, '0.00', $organization_id, 0, 10, '', 2, 1,'51'),

('$timestamp', $userid, '$timestamp', $userid, '1', 'Salary',      $expenses, '0.00', $expenses_id, 0, 0, '0.00', $organization_id, 0, 10, '', 2, 1,'61'),
('$timestamp', $userid, '$timestamp', $userid, '2', 'EPF',         $expenses, '0.00', $expenses_id, 0, 0, '0.00', $organization_id, 0, 10, '', 2, 1,'62'),
('$timestamp', $userid, '$timestamp', $userid, '3', 'Socso',       $expenses, '0.00', $expenses_id, 0, 0, '0.00', $organization_id, 0, 10, '', 2, 1,'63'),
('$timestamp', $userid, '$timestamp', $userid, '4', 'Electric',         $expenses, '0.00', $expenses_id, 0, 0, '0.00', $organization_id, 0, 10, '', 2, 1,'64'),
('$timestamp', $userid, '$timestamp', $userid, '5', 'Depreciation',         $expenses, '0.00', $expenses_id, 0, 0, '0.00', $organization_id, 0, 10, '', 2, 1,'65'),
('$timestamp', $userid, '$timestamp', $userid, '1', 'Retain Earning(Reverse Entry)',         $memo, '0.00', $memo_id, 0, 0, '0.00', $organization_id, 0, 10, '', 2, 1,'81');

";
				$rs=$this->xoopsDB->query($sqlinsertdefaultchildacc);
		
				if (!$rs){
					$this->log->showLog(1,"Failed to insert new opening balance:" . mysql_error() . ":$sqlinsertdefaultchildacc");
					return false;
				}else{
				$currentasset_id = $this->getAccountsID($organization_id,"Current Asset");
				$fixasset_id = $this->getAccountsID($organization_id,"Fixed Asset");


				$sqlinsertdefaultchildacc2 = 
				"INSERT INTO $this->tableaccounts (`created`, `createdby`, `updated`, `updatedby`, `accounts_code`, `accounts_name`, `accountgroup_id`, `openingbalance`, `parentaccounts_id`, `placeholder`, `tax_id`, `lastbalance`, `organization_id`, `ishide`, `defaultlevel`, `description`, `treelevel`, `account_type`,`accountcode_full`) VALUES 		
				('$timestamp', $userid, '$timestamp', $userid, '1', 'Checking Account',      $asset, '0.00', $currentasset_id, 0, 0, '0.00', $organization_id, 0, 10, '', 3, 4,'111'),
				('$timestamp', $userid, '$timestamp', $userid, '2', 'Trade Debtor',     $asset, '0.00', $currentasset_id, 0, 0, '0.00', $organization_id, 0, 10, '', 3, 2,'112'),
				('$timestamp', $userid, '$timestamp', $userid, '3', 'Petty Cash',     $asset, '0.00', $currentasset_id, 0, 0, '0.00', $organization_id, 0, 10, '', 3, 7,'113'),
				('$timestamp', $userid, '$timestamp', $userid, '1', 'Office Furniture',     $asset, '0.00', $fixasset_id, 0, 0, '0.00', $organization_id, 0, 10, '', 3, 1,'121'),
				('$timestamp', $userid, '$timestamp', $userid, '2', 'Accum. Depreciation Of Office Furniture',     $asset, '0.00', $fixasset_id, 0, 0, '0.00', $organization_id, 0, 10, '', 3, 1,'122');";
				$rs2=$this->xoopsDB->query($sqlinsertdefaultchildacc2);
				if (!$rs2){
					$this->log->showLog(1,"Failed to insert new opening balance:" . mysql_error() . ":$sqlinsertdefaultchildacc2");
					return false;
				}else{
					$this->updateHierarchy();
					$this->log->showLog(3,"Inserting new accounts successfully"); 
					return true;
				}
	//				$opbalance = $this->getAccountsID($organization_id,"Opening Balance");
	//				$this->insertBatch($opbalance);
	//				$equityid = $this->getAccountsID($organization_id,"Equity");
	//				$this->insertBatch($equityid);
				}
				
			}

	}
  }
  
   
  
  
  public function getAccGroupID($organization_id,$acc){
	$retval = 0;
 	$sql  = "select accountgroup_id from $this->tableaccountgroup 
			where accountgroup_name = '$acc' and organization_id = $organization_id ";
  
 	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['accountgroup_id'];;
	}
  
  	return $retval;
  
  }
  
  public function getAccountsID($organization_id,$acc){
	$retval = 0;
 	$sql  = "select accounts_id from $this->tableaccounts 
			where accounts_name = '$acc' and organization_id = $organization_id ";
  
 	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['accounts_id'];;
	}
  
  	return $retval;
  
  }
  
  public function updateOpeningBalanceAccount($amt,$prev){
  global $defaultorganization_id;
  
  
  $openingbalance_id = $this->getAccountsID($defaultorganization_id,"Opening Balance");
  $equity_id = $this->getAccountsID($defaultorganization_id,"Equity");
  $totalcredit = 0;
  $totaldebit = 0;
  
  /*
  if($amt < 0 )
  $totalcredit = $amt*-1;
  else
  $totaldebit = $amt;*/
  
  if($amt == "")
  $amt = 0;
  
//  $amt = $amt*-1;
  
  
 $sqlupdate = "update $this->tableaccounts 
				set lastbalance = (lastbalance)  + $prev-$amt ,openingbalance = (openingbalance + $prev-$amt )   
				where accounts_id = $openingbalance_id ";

  $sqlequity = "update $this->tableaccounts 
				set lastbalance = (lastbalance + $prev-$amt )
				where accounts_id = $equity_id ";
  $this->log->showLog(4,"Update opening balance: $sqlupdate");
  $this->log->showLog(4,"Update Equity Account: $sqlequity");
  $rs=$this->xoopsDB->query($sqlupdate);

	if (!$rs){
		$this->log->showLog(1,"Failed to update trans opening balance:" . mysql_error() . ":$sqlupdate");
		return false;
	}else{

		$rs=$this->xoopsDB->query($sqlequity);
		if (!$rs){
		$this->log->showLog(1,"Failed to update trans equity :" . mysql_error() . ":$sqlequity");
		return false;
		}
	}
  }


  public function repairAccounts(){

   global $defaultorganization_id;

   if($this->emptyallaccountbalance()){
	$this->log->showLog(3, "Reset all balance successfully");
	if($acc_id>0)
		$wherestring="";

	//get summary for each month, by business partner, accounts, period, order by year, month,then accounts
	$sql="SELECT left(b.batchdate,7), t.accounts_id, bp.bpartner_id, sum(t.amt) as balanceamt,
		pr.period_id,pr.period_year,pr.period_month
		FROM $this->tablebatch b
		INNER JOIN $this->tabletransaction t on b.batch_id=t.batch_id
		INNER JOIN $this->tableaccounts a on t.accounts_id=a.accounts_id
		INNER JOIN $this->tablebpartner bp on t.bpartner_id=bp.bpartner_id
		INNER JOIN $this->tableperiod pr on left(b.batchdate,7)=
			concat(case when length(pr.period_year)=1 then concat('000',pr.period_year) else pr.period_year end  ,'-',
				case when length(pr.period_month) =1 then concat('0',pr.period_month) else pr.period_month end )
		WHERE a.organization_id=$defaultorganization_id and a.accounts_id>0 and b.iscomplete=1 $wherestring
		group by left(b.batchdate,7) , t.accounts_id, bp.bpartner_id,pr.period_id
		ORDER BY concat(case when length(pr.period_year)=1 then concat('000',pr.period_year) else pr.period_year end  ,'-',
				case when length(pr.period_month) =1 then concat('0',pr.period_month) else pr.period_month end ) , t.accounts_id, bp.bpartner_id";
	$this->log->showLog(3, "Get transaction table with SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	$i=0;

	//loop record and insert the summary into transaction summary
	while($row=$this->xoopsDB->fetchArray($query))
	{
		$i++;
		$accounts_id=$row['accounts_id'];
		$bpartner_id=$row['bpartner_id'];
		$period_id=$row['period_id'];
		$balanceamt=$row['balanceamt'];

		//fetch previous summary to calculate last balance
		$sqltranslastbalance="SELECT lastbalance,transum_id FROM $this->tabletranssummary WHERE 
			organization_id=$defaultorganization_id and accounts_id=$accounts_id AND 
			bpartner_id=$bpartner_id order by transum_id DESC"; //get latest lastbalance for selected record
		$qrytranslastbalance=$this->xoopsDB->query($sqltranslastbalance);

		if($rowtranslastbalance=$this->xoopsDB->fetchArray($qrytranslastbalance)){
			$lastbalance=$rowtranslastbalance['lastbalance'];
			$transum_id=$rowtranslastbalance['transum_id'];
		}
		else
			$lastbalance=0;


		$this->log->showLog(4,"Getting old lastbalance :$lastbalance, and amt: $balanceamt,with transum_id:$transum_id with SQL:$sqltranslastbalance");
		$lastbalance=$lastbalance+$balanceamt;

		//insert this new summary as new record
		$sqlinsert="INSERT INTO $this->tabletranssummary (organization_id,period_id,accounts_id,
			bpartner_id,transactionamt,lastbalance) VALUES 
			($defaultorganization_id,$period_id,$accounts_id,$bpartner_id,$balanceamt,$lastbalance)";
		$rsInsert=$this->xoopsDB->query($sqlinsert);
		if($rsInsert)
			$this->log->showLog(3,"$i.Insert 1 trans. summary successfully with SQL: $sqlinsert");
		else
			$this->log->showLog(1,"$i.Failed to insert 1 trans. summary with SQL: $sqlinsert".mysql_error());

	}
	

	$sqlupdatebalance="SELECT a.accounts_id,sum(a.balanceamt) as balanceamt FROM ($sql) a group by a.accounts_id";
	$this->log->showLog(4,"Reset child account lastbalance with SQL:$sqlupdatebalance");
	$queryupdatebalance=$this->xoopsDB->query($sqlupdatebalance);
	$i=0;
	//udate accounts balance amt with total transaction+openingbalance
	while($row=$this->xoopsDB->fetchArray($queryupdatebalance))
	{
		$i++;
		$accounts_id=$row['accounts_id'];
	
		$balanceamt=$row['balanceamt'];
		$sqlupdate="UPDATE $this->tableaccounts SET lastbalance=$balanceamt + openingbalance
			WHERE accounts_id=$accounts_id ";
		$rsUpdate=$this->xoopsDB->query($sqlupdate);
		if($rsUpdate)
			$this->log->showLog(3,"$i.Update 1 acc successfully with SQL: $sqlupdate");
		else
			$this->log->showLog(1,"$i.Failed to update 1 acc with SQL: $sqlupdate");


	}
	
   }
   else
   $this->log->showLog(1, "Failed to reset account balance.");

//update bpartner currentbalance
	$sqlupdatebpbalance="SELECT a.bpartner_id,sum(a.balanceamt) as balanceamt FROM ($sql) a group by a.bpartner_id";
	$this->log->showLog(4,"Reset bpartner account balance with SQL:$sqlupdatebpbalance");
	$qryupdatebpbalance=$this->xoopsDB->query($sqlupdatebpbalance);
	$i=0;

	while($row=$this->xoopsDB->fetchArray($qryupdatebpbalance))
	{
		$i++;
		$bpartner_id=$row['bpartner_id'];
	
		$balanceamt=$row['balanceamt'];
		$sqlupdate="UPDATE $this->tablebpartner SET currentbalance=$balanceamt 
			WHERE bpartner_id=$bpartner_id";
		$rsUpdate=$this->xoopsDB->query($sqlupdate);
		if($rsUpdate)
			$this->log->showLog(3,"$i.Update 1 bpartner successfully with SQL: $sqlupdate");
		else
			$this->log->showLog(1,"$i.Failed to bpartner 1 acc with SQL: $sqlupdate");
	}
//end of update bpartner currentbalance

	$sqlupdatetsbalance="UPDATE $this->tabletranssummary ts inner join
		$this->tableaccounts a on a.accounts_id=ts.accounts_id set ts.lastbalance=a.openingbalance+ts.lastbalance 
		WHERE ts.organization_id=$defaultorganization_id";
	$rsupdatetsbalance=$this->xoopsDB->query($sqlupdatetsbalance);
	if($rsupdatetsbalance)
		$this->log->showLog(4, "Run update transsummary  successfully with additional openingbalance with SQL: $sqlupdatetsbalance");
	else
		$this->log->showLog(1, __LINE__."Run update all transaction summary failed with additional openingbalance with SQL: $sqlupdatetsbalance");
		
 if($this->recalculateAllParentAccounts())
  return true;
 else
  return false;
}
 
  public function emptyallaccountbalance(){
	global $defaultorganization_id;
			
	$sql1="UPDATE $this->tableaccounts set lastbalance=openingbalance WHERE organization_id=$defaultorganization_id";
	$sql2="UPDATE $this->tablebpartner set currentbalance=0 WHERE organization_id=$defaultorganization_id";
	$sql3="DELETE FROM $this->tabletranssummary WHERE organization_id=$defaultorganization_id";
	$this->log->showLog(3, "Run emptyallaccountbalance with SQL: $sql1");
	$this->log->showLog(3, "Run emptyallaccountbalance with SQL: $sql2");
	$this->log->showLog(3, "Run emptyallaccountbalance with SQL: $sql3");
	$rs1=$this->xoopsDB->query($sql1);
	$rs2=$this->xoopsDB->query($sql2);
	$rs3=$this->xoopsDB->query($sql3);

//	if($rs1 && $rs2 && $rs3 )
		return true;
//	else
//		return false;

	}

  public function recalculateAllParentAccounts(){

	$sql="SELECT accounts_id,lastbalance,hierarchy FROM $this->tableaccounts where placeholder=1 order by accountcode_full";
	

	$this->log->showLog(3, "Run recalculateAllParentAccounts with SQL1: $sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$accounts_id=$row['accounts_id'];
		$lastbalance=$row['lastbalance'];
		$hierarchy=$row['hierarchy'];

		$sqlresult="SELECT case when sum(lastbalance) is null then 0 else sum(lastbalance) end as lastbalance from $this->tableaccounts a1 
			where a1.placeholder=0 and a1.hierarchy LIKE '$hierarchy%' and a1.hierarchy <>'$hierarchy'";
		$this->log->showLog(3, "Run recalculateAllParentAccounts with SQL2: $sqlresult");

		$qryresult = $this->xoopsDB->query($sqlresult);
		if($row=$this->xoopsDB->fetchArray($qryresult))
			$lastbalance=$row['lastbalance'];
		else
			$lastbalance=0;
		$sqlupdate="UPDATE $this->tableaccounts set lastbalance=$lastbalance where accounts_id=$accounts_id";

		$rs=$this->xoopsDB->query($sqlupdate);
		if($rs)
			$this->log->showLog(4, "Run recalculateAllParentAccounts successfully SQL3: $sqlupdate");
		else
			$this->log->showLog(1, "Run recalculateAllParentAccounts failed with SQL3: $sqlupdate");

	$this->updateChildTree($accounts_id);
	
	}
//hierarchy
	return true;
  }
  public function getTopParent($accounts_id){
	$retval = "";
	$hierarchy = "";

	$sql = "select hierarchy from $this->tableaccounts where accounts_id = $accounts_id ";

	$this->log->showLog(4,"SQL select for repair: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$hierarchy = $row['hierarchy'];
	}
	//echo $hierarchy." - ";
	$pos = strpos($hierarchy, "]");
	$retval = str_replace("[","",substr($hierarchy,0,$pos));

	return $retval;
  }

  public function repairTransactionSummary($accounts_id){
	$period_id = 0;
	$totalamt = 0;
	$totcredit = 0;
	$totdebit = 0;

	$sql = "select a.batchdate,sum(b.amt) as amt, 'debit' as type from $this->tablebatch a, $this->tabletransaction b 
		where a.batch_id = b.batch_id 
		and b.accounts_id = $accounts_id 
		and a.batchdate > '0000-00-00' 
		and b.amt > 0 
		group by a.batchdate ";

	$sql .= " union ";

	$sql .= "select a.batchdate,sum(b.amt) as amt, 'credit' as type from $this->tablebatch a, $this->tabletransaction b 
		where a.batch_id = b.batch_id 
		and b.accounts_id = $accounts_id 
		and a.batchdate > '0000-00-00' 
		and b.amt < 0 
		group by a.batchdate ";

	/*
	$sql = "select a.batchdate,() as amt_debit from $this->tablebatch a, $this->tabletransaction b 
		where a.batch_id = b.batch_id 
		and b.accounts_id = $accounts_id 
		and a.batchdate > '0000-00-00' 
		group by a.batchdate ";*/

	

	$this->log->showLog(4,"select date from batch with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	
	while($row=$this->xoopsDB->fetchArray($query)){
	$period_id = $this->checkPeriodID($row['batchdate']);

	if($row['amt'] > 0)
	$totdebit = $row['amt'];
	else if($row['amt'] < 0)
	$totcredit = $row['amt']*-1;

	if($period_id > 0){

	if($totdebit > 0){
	$sqlupdate = "update $this->tabletranssummary set debitamt = $totdebit 
			where accounts_id = $accounts_id 
			and period_id = $period_id ";
	}else{
	$sqlupdate = "update $this->tabletranssummary set creditamt = $totcredit 
			where accounts_id = $accounts_id 
			and period_id = $period_id ";
	}

	
	$rs=$this->xoopsDB->query($sqlupdate);

	if (!$rs){
		$this->log->showLog(1,"Failed to update transaction summary : $accounts_id" . mysql_error() . ":$sqlupdate");
		$retval = false;

	}
	}

	}
	
  }

  public function checkPeriodID($date){
	$retval = 0;
	$year = substr($date,0,4);
	$month = (int)substr($date,5,2);
	$sql = "select * from $this->tableperiod 
		where period_year = $year and period_month = $month ";
	
	$this->log->showLog(3,"Checking period date with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['period_id'];
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

  public function bPartnerHistoryBalance($period_id,$monthadjustment,$bpartner_id){


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
		return 0; //return 0 if cannot find the period



	// start looping
	$validate=0;
	while($validate < 1){

	//echo $monthadjustment;
	//echo "<br>";

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
		return 0;
	}

	//continue to find the balance : lastbalance => transactionamt
	$sql3="SELECT case when lastbalance is null then 0 else lastbalance end as balanceamt FROM $this->tabletranssummary 
		where bpartner_id=$bpartner_id and period_id=$targetperiod_id";
	
	
	$query3=$this->xoopsDB->query($sql3);
	if($row=$this->xoopsDB->fetchArray($query3)){

		$result= $row['balanceamt'];

		return $result;
		/*
		if($result > 0){
		return $result;
		}else{
		$month = $month_ori;
		$year = $year_ori;
		$monthadjustment++;
		}*/
	
			
	}else{
	$month = $month_ori;
	$year = $year_ori;
	$monthadjustment++;
	}
	
		//else
		//return 0;//if can't execute sql3, return 0;

	}

	if($validate==0)
	return 0;

	//return $result;
	// end looping

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

  public function getAccountsPeriodBalance($period_id,$accounts_id,$bpartner_id){
	$sql="SELECT case when sum(ts.transactionamt) is null then 0 else sum(ts.transactionamt) end as transactionamt
		 from $this->tabletranssummary ts 
		 INNER JOIN $this->tableaccounts a on a.accounts_id = ts.accounts_id
		 where ts.period_id=$period_id and ts.bpartner_id=$bpartner_id and 
		 a.hierarchy LIKE '%[$accounts_id]%'";
	$this->log->showLog(4,"Call getAccountsPeriodBalance with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		return $row['transactionamt'];
	}
	else
		return 0;//if can't execute sql3, return 0;
  }

  public function getAccountsPeriodLastBalance($period_id,$accounts_id,$bpartner_id){
	$sql="SELECT case when sum(ts.lastbalance) is null then 0 else sum(ts.lastbalance) end as lastbalance
		 from $this->tabletranssummary ts 
		 INNER JOIN $this->tableaccounts a on a.accounts_id = ts.accounts_id
		 where ts.period_id=$period_id and ts.bpartner_id=$bpartner_id and 
		 a.hierarchy LIKE '%[$accounts_id]%'";
	$this->log->showLog(4,"Call getAccountsPeriodBalance with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		return $row['lastbalance'];
	}
	else
		return 0;//if can't execute sql3, return 0;
  }

  public function getAccountsFinancialYearBalance($financialyear_id,$accounts_id,$bpartner_id){
	$sql="SELECT case when sum(ts.transactionamt) is null then 0 else sum(ts.transactionamt) end as transactionamt
		 from $this->tabletranssummary ts 
		 INNER JOIN $this->tableaccounts a on a.accounts_id = ts.accounts_id
		 where ts.period_id=$period_id and ts.bpartner_id=$bpartner_id and 
		 a.hierarchy LIKE '%[$accounts_id]%'";
	$this->log->showLog(4,"Call getAccountsPeriodBalance with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		return $row['transactionamt'];
	}
	else
		return 0;//if can't execute sql3, return 0;
  }


  public function getAccountLastBalanceOnPeriod($period_id,$accounts_id){
	global $defaultorganization_id,$tabletranssumary,$tableperiod,$tabletranssummary,$tableaccounts;
	//get all unique account lastbalance for period <= period_id
	$sql="SELECT case when sum(ts.lastbalance)  is null then 'ISNULL' else sum(ts.lastbalance) end as lastbalance
		 from $tabletranssummary ts 
		 INNER JOIN $tableaccounts a on a.accounts_id = ts.accounts_id
		 where ts.period_id=$period_id and a.accounts_id=$accounts_id";
	$this->log->showLog(4,"Call getAccountLastBalanceOnPeriod with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$result= $row['lastbalance'];

		//when detect null, get from previousmonth
		if($result=="ISNULL"){
			//select lastbalance which is period earlier but nearest
			/*$sqlgetnearestbalance="SELECT sum(ts.lastbalance) as lastbalance
				FROM $tabletranssummary  ts
				inner join $tableperiod p on ts.period_id=p.period_id
				where ts.accounts_id=$accounts_id and 
				p.period_year <= (SELECT period_year FROM $tableperiod where period_id=$period_id) and 
				p.period_month <= (SELECT period_month FROM $tableperiod where period_id=$period_id)
				order by p.period_year DESC, p.period_month DESC";


                       $sqlgetnearestbalance="SELECT sum(ts.lastbalance) as lastbalance
				FROM $tabletranssummary  ts
				where ts.accounts_id=$accounts_id and
				ts.period_id = (select p.period_id
                                from $tableperiod p
                                inner join $tabletranssummary sm on sm.period_id = p.period_id
                                where p.period_year <= (SELECT period_year FROM $tableperiod where period_id=$period_id) and
				p.period_month <= (SELECT period_month FROM $tableperiod where period_id=$period_id)
                                and sm.accounts_id=$accounts_id
                                order by p.period_year DESC, p.period_month DESC limit 1)
				";
                         * 
                         */
                       $sqlgetnearestbalance="SELECT sum(ts.lastbalance) as lastbalance
				FROM $tabletranssummary  ts
				where ts.accounts_id=$accounts_id and
				ts.period_id = (select p.period_id
                                from $tableperiod p
                                inner join $tabletranssummary sm on sm.period_id = p.period_id
                                where cast(replace(p.period_name,'-','') as signed) <= (SELECT cast(replace(period_name,'-','') as signed) FROM $tableperiod where period_id=$period_id)

                                and sm.accounts_id=$accounts_id
                                order by p.period_year DESC, p.period_month DESC limit 1)
				";
              
			$this->log->showLog(4,"Get previous lastbalance with SQL: $sqlgetnearestbalance");

			$qrypreviouslastbalance=$this->xoopsDB->query($sqlgetnearestbalance);
			if($rowpreviouslastbalance=$this->xoopsDB->fetchArray($qrypreviouslastbalance))
				$lastbalance=$rowpreviouslastbalance['lastbalance'];

                                //echo "$lastbalance<br>";

			if($lastbalance==""){
				$sqlgetaccounts="SELECT * FROM $this->tableaccounts where accounts_id=$accounts_id";
				$qryaccounts=$this->xoopsDB->query($sqlgetaccounts);
				if($rowaccounts=$this->xoopsDB->fetchArray($qryaccounts))
					$lastbalance =$rowaccounts['openingbalance'];
				else
					return 0;
			}
			else{
				$this->log->showLog(3,"Found Last balance=$lastbalance");
				return $lastbalance;
			}
				
			//if no record found return last balance from accounts
		}
		else
			return $result;
	}
	else
		return 0;//if can't execute sql3, return 0;
	}

  public function updateLastBalance($accounts_id,$lastbalance,$previouslastbalance,$bpartner_id){
	$effectedamt=$lastbalance-$previouslastbalance;
	$sql1="Update $this->tableaccounts set lastbalance=lastbalance+ ($effectedamt) where accounts_id=$accounts_id";

	$rs1=$this->xoopsDB->query($sql1);
	if($rs1){
		$this->log->showLog(4,"Call updateLastBalance successfully with SQL:$sql1");
		$sql2="UPDATE $this->tabletranssummary set lastbalance=lastbalance+$effectedamt 
			WHERE accounts_id=$accounts_id AND bpartner_id=$bpartner_id";
		$rs2=$this->xoopsDB->query($sql2);
		if($rs2){
			$this->log->showLog(4,"Call updateLastBalance at transaction summary successfully with SQL2:$sql2");
			return true;
		}
		else{
			$this->log->showLog(4,"Call updateLastBalance at transaction summary failed with SQL2:$sql2");
			return false;
		}
	}
	else
	{
		$this->log->showLog(1,"Call updateLastBalance failed with SQL:$sql1");
	return false;}
	
  }

  public function updateOpenBalance($accounts_id,$effectiveamt){
	//$effectedamt=$lastbalance-$previouslastbalance;
	$sql="Update $this->tableaccounts set openingbalance=openingbalance + ($effectiveamt) where accounts_id=$accounts_id";

	$rs=$this->xoopsDB->query($sql);

	if($rs){
		$this->log->showLog(3,"Call updateOpenBalance successfully with SQL: $sql");
			return true;	
	}
	else
	{
		$this->log->showLog(1,"Call updateOpenBalance failed with SQL: $sql");
			return false;
	}

  }


  public function colapseTree(){
	//$effectedamt=$lastbalance-$previouslastbalance;
	global $defaultorganization_id;
	$sql="Update $this->tableaccounts set ishide=1 where organization_id=$defaultorganization_id";

	$rs=$this->xoopsDB->query($sql);


  }

  public function displayTree(){
	global $defaultorganization_id;
	$sql="Update $this->tableaccounts set ishide=0 where organization_id=$defaultorganization_id";

	$rs=$this->xoopsDB->query($sql);

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

  public function getAccountLastBalanceOnPeriodByBPartner($period_id,$accounts_id,$bpartner_id){
	global $defaultorganization_id,$tabletranssumary,$tableperiod,$tabletranssummary,$tableaccounts,$tablebpartner;
	//get all unique account lastbalance for period <= period_id		//when detect null, get from previousmonth

	$sqlgetnearestbalance="SELECT ts.lastbalance as lastbalance
				FROM $tabletranssummary  ts
				inner join $tableperiod p on ts.period_id=p.period_id
				inner join $tablebpartner bp on ts.bpartner_id=bp.bpartner_id
				where ts.accounts_id=$accounts_id and 
				p.period_year <= (SELECT period_year FROM $tableperiod where period_id=$period_id) and 
				p.period_month <= (SELECT period_month FROM $tableperiod where period_id=$period_id) and 
				ts.bpartner_id=$bpartner_id
				order by p.period_year DESC, p.period_month DESC";

	$this->log->showLog(4,"Get previous lastbalance with SQL: $sqlgetnearestbalance");
	$qrypreviouslastbalance=$this->xoopsDB->query($sqlgetnearestbalance);
	if($rowpreviouslastbalance=$this->xoopsDB->fetchArray($qrypreviouslastbalance))
			$lastbalance=$rowpreviouslastbalance['lastbalance'];
				
		if($lastbalance=="")
				return 0;
		else{
			$this->log->showLog(3,"Found Last balance=$lastbalance");
			return $lastbalance;
		}
	}

          public function getAccountsPeriodLastBalanceSheet($period_id,$accounts_id){
//replace(pr1.period_name,'-','') <= replace(pr2.period_name,'-','') and a.hierarchy LIKE '%[$accounts_id]%'
              //ts.period_id=$period_id and
              /*
             $sql="SELECT case when ts.lastbalance is null then 0 else ts.lastbalance end as lastbalance
		 from $this->tabletranssummary ts
		 INNER JOIN $this->tableaccounts a on a.accounts_id = ts.accounts_id
                 LEFT JOIN $this->tableperiod pr1 on pr1.period_id = ts.period_id
                 LEFT JOIN $this->tableperiod pr2 on pr2.period_id = $period_id
		 where cast(replace(pr1.period_name,'-','') as signed) <= cast(replace(pr2.period_name,'-','') as signed)
                 and ts.bpartner_id = 0
                 and a.hierarchy LIKE '%[$accounts_id]%'
                 order by cast(replace(pr1.period_name,'-','') as signed) desc
		 limit 1";
               *
                 $sqlselect="SELECT pr1.period_id
		 from $this->tabletranssummary ts
		 INNER JOIN $this->tableaccounts a on a.accounts_id = ts.accounts_id
                 LEFT JOIN $this->tableperiod pr1 on pr1.period_id = ts.period_id
                 LEFT JOIN $this->tableperiod pr2 on pr2.period_id = $period_id
		 where cast(replace(pr1.period_name,'-','') as signed) <= cast(replace(pr2.period_name,'-','') as signed)
                 and ts.bpartner_id = 0
                 and a.hierarchy LIKE '%[$accounts_id]%'
                 order by cast(replace(pr1.period_name,'-','') as signed) desc
		 ";
               * 
               */

                 
                 $sqlselect="SELECT pr1.period_id
		 from $this->tabletranssummary ts
                 LEFT JOIN $this->tableperiod pr1 on pr1.period_id = ts.period_id
                 LEFT JOIN $this->tableperiod pr2 on pr2.period_id = $period_id
		 where cast(replace(pr1.period_name,'-','') as signed) <= cast(replace(pr2.period_name,'-','') as signed)
                 and ts.accounts_id = ts2.accounts_id
                 order by cast(replace(pr1.period_name,'-','') as signed) desc limit 1
		 ";

                 $sql = "select ($sqlselect) as period_id,ts2.accounts_id
		 from $this->tabletranssummary ts2
		 INNER JOIN $this->tableaccounts a2 on a2.accounts_id = ts2.accounts_id
                 where a2.hierarchy LIKE '%[$accounts_id]%'
                 group by ts2.accounts_id ";

              //echo "<br>";
        $tot_lastbal = 0;
	$this->log->showLog(4,"Call getAccountsPeriodBalance with SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$period_id = $row['period_id'];
                $accounts_id = $row['accounts_id'];
                 
                 $sqllast="SELECT case when sum(ts.lastbalance) is null then 0 else sum(ts.lastbalance) end as lastbalances
		 from $this->tabletranssummary ts
		 where ts.accounts_id = $accounts_id
                 and ts.period_id = $period_id ";
                  
                $tot_lastballine = 0;
                $querylast=$this->xoopsDB->query($sqllast);
                while ($rowlast=$this->xoopsDB->fetchArray($querylast)){

                $tot_lastballine = $rowlast['lastbalances'];
                $tot_lastbal += $tot_lastballine;

                //echo "$tot_lastbal <br>";
                //echo "".$rowlast['lastbalances']." <br>";
                }

                
                if($tot_lastballine==0){
                    $sqlgetaccounts="SELECT * FROM $this->tableaccounts where accounts_id=$accounts_id";
                    $qryaccounts=$this->xoopsDB->query($sqlgetaccounts);
                    if($rowaccounts=$this->xoopsDB->fetchArray($qryaccounts))
                    $tot_lastbal += $rowaccounts['openingbalance'];

                 }
                
                    
                
                
	}

        //echo "$tot_lastbal <br>";
	return $tot_lastbal;
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

public function getProfitAndLostInPeriod($period_id){
	global $defaultorganization_id;
  $sql="select (SELECT case when sum(t.amt) is null then 0  else sum(t.amt) end as amt		from $this->tablebatch b
		inner join $this->tabletransaction t on b.batch_id=t.batch_id
		inner join $this->tableaccounts a on a.accounts_id=t.accounts_id
		inner join $this->tableaccountgroup g on a.accountgroup_id=g.accountgroup_id
		inner join $this->tableaccountclass c on c.accountclass_id=g.accountclass_id
		where b.period_id = $period_id and b.iscomplete = 1 and b.organization_id=$defaultorganization_id
		and (c.classtype='1S' OR c.classtype='3O')) - 
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
} // end of ClassAccounts

?>

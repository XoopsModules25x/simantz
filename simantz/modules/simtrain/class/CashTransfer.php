<?php

class CashTransfer
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

 

  /**
   * if isactive="N", product master no longer can choose this category. Print
   * reports by category won't list this item as well. If this category use by
   * productmaster, you can disable this record, but cannot delete this record.
   * @access public
   */ 
  public $cashtransfer_id;
  public $transferdatetime;
  public $amt;
  public $module_id;
  public $description;
  public $organization_id;
  public $created;
  public $createdby;
  public $updated;
  public $orgctrl;
  public $uid;
  public $updatedby;
  public $defaultamt;
  public $transport_amt;
  public $isAdmin;
  public $defaulttransport_amt;
  public $currentuid;
  public $cur_name;
  public $cur_symbol;
  public $username;
  public $cashtransfer_no;
  public $userctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $tablecashtransfer;
  private $tablepayment;
  private $tablepaymentline;
  private $tableproduct;
  private $tableuser;
  private $tablegroups;
  private $tablegroupusers;
  private $tablegroup_permission;
  private $log;


//constructor
   public function CashTransfer($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tablecashtransfer=$tableprefix . "simtrain_cashtransfer";
	$this->tablepayment=$tableprefix . "simtrain_payment";
	$this->tablepaymentline=$tableprefix . "simtrain_paymentline";
	$this->tableuser=$tableprefix . "users";
	$this->tablegroups=$tableprefix."groups";
	$this->tablegroupusers=$tableprefix."groups_users_link";
	$this->tablegroup_permission=$tableprefix."group_permission";
	$this->log=$log;
   }

 /**
   * Display a table, list current onhand cash
   *
   * @access public
*/

  public function showOnHandCashTable(){
	global $defaultorganization_id;
	$this->log->showLog(3,"Display on hand cash under each user account");
	/*
	$subtransportsql="coalesce((SELECT sum(pl.transportamt) FROM $this->tablepaymentline pl inner join $this->tablepayment py on pl.payment_id=py.payment_id where py.iscomplete='Y' and py.updatedby=u.uid),0)";
	$subtraningsql="coalesce((SELECT sum(pl.amt-pl.transportamt) FROM $this->tablepaymentline pl inner join $this->tablepayment py on pl.payment_id=py.payment_id where py.iscomplete='Y' and py.updatedby=u.uid),0)";
	$subcashtransportsql="coalesce((select sum(c.transport_amt) as amt from $this->tablecashtransfer c where  c.fromuser_id=u.uid),0)";
	$subcashtrainingsql="coalesce((select sum(c.amt) as amt from $this->tablecashtransfer c where  c.fromuser_id=u.uid),0)";
	*/
	$subtransportsql="coalesce((SELECT sum(pl.transportamt) FROM $this->tablepaymentline pl inner join $this->tablepayment py on pl.payment_id=py.payment_id where py.iscomplete='Y' and py.updatedby=u.uid and py.organization_id = $defaultorganization_id),0)";
	$subtraningsql="coalesce((SELECT sum(pl.amt-pl.transportamt) FROM $this->tablepaymentline pl inner join $this->tablepayment py on pl.payment_id=py.payment_id where py.iscomplete='Y' and py.updatedby=u.uid and py.organization_id = $defaultorganization_id),0)";
	$subcashtransportsql="coalesce((select sum(c.transport_amt) as amt from $this->tablecashtransfer c where  c.fromuser_id=u.uid and c.organization_id = $defaultorganization_id),0)";
	$subcashtrainingsql="coalesce((select sum(c.amt) as amt from $this->tablecashtransfer c where  c.fromuser_id=u.uid and c.organization_id = $defaultorganization_id),0)";
	//$this->tableuser=$tableprefix . "users";
	//$this->tablegroups=$tableprefix."groups";
	//$this->tablegroupusers=$tableprefix."groups_users_link";
	//$this->tablegroup_permission=$tableprefix."group_permission";

	$this->log->showLog(4,"The module id: $mid");

/*
	$sql="SELECT uid,name,uname, $subtraningsql as trainingamt, $subtransportsql as transportamt, ".
		" $subcashtrainingsql as tTraningamt, $subcashtransportsql as tTransportamt, ".
		" $subtraningsql - $subcashtrainingsql as balancetraining,  $subtransportsql - $subcashtransportsql as balancetransport".
		" from $this->tableuser ";
*/
	$sql="SELECT u.uid,u.name,u.uname, $subtraningsql as trainingamt, $subtransportsql as transportamt, 
		$subcashtrainingsql as tTraningamt, $subcashtransportsql as tTransportamt, 
		$subtraningsql - $subcashtrainingsql as balancetraining,  $subtransportsql - 
		$subcashtransportsql as balancetransport
		FROM (select distinct(u.uid), u.name , u.uname from sim_groups g 
		inner join sim_groups_users_link gul on g.groupid=gul.groupid
		inner join sim_users u on gul.uid=u.uid
		inner join sim_group_permission gp on gp.gperm_groupid=g.groupid
		inner join sim_modules m on gp.gperm_itemid=m.mid
		where m.mid=$this->module_id and gp.gperm_name='module_read') u";



	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Cash Transfer</span></big></big></big></div><br>-->

	<table border='1' cellspacing='3'>
		<tbody>
		<tr><th colspan="10" style='text-align:center;'>On Hand Cash (By User)</th></tr><tr>
		<th style="text-align:center;">No</th>
		<th style="text-align:center;">User ID</th>
		<th style="text-align:center;">Name</th>
		<th style="text-align:center;">Received <br>Training Fees ($this->cur_symbol)</th>
		<th style="text-align:center;">Received <br>Transport Fees ($this->cur_symbol)</th>
		<th style="text-align:center;">Onhand <br>Training Fees ($this->cur_symbol)</th>
		<th style="text-align:center;">Onhand <br>Transport Fees ($this->cur_symbol)</th>
		<th style="text-align:center;">Action</th>
    </tr>
EOF;
	$i=0;
	$alltrainingamt=0;
	$alltransportamt=0;
	$alltTraningamt=0;
	$alltTransportamt=0;
	$allbalancetraining=0;
	$allbalancetransport=0;

	while($row=$this->xoopsDB->fetchArray($query))
		{	$i++;
			$uid=$row['uid'];
			$uname=$row['uname'];
			$name=$row['name'];
			$transportamt=number_format($row['transportamt'],2);
			$trainingamt=number_format($row['trainingamt'],2);
			$cashtansferamt=number_format($row['cashtansferamt'],2);
			$tTransportamt=number_format($row['tTransportamt'],2);
			$tTraningamt=number_format($row['tTraningamt'],2);
			$balancetransport=number_format($row['balancetransport'],2);
			$balancetraining=number_format($row['balancetraining'],2);

			$alltrainingamt=$alltrainingamt+$trainingamt;
			$alltransportamt=$alltransportamt+$transportamt;
			$alltTraningamt=$alltTraningamt+$tTraningamt;
			$alltTransportamt=$alltTransportamt+$tTransportamt;
			$allbalancetraining=$allbalancetraining+$row['balancetraining'];
			$allbalancetransport=$allbalancetransport+$row['balancetransport'];

			if($rowtype=="odd")
				$rowtype="even";
			else
				$rowtype="odd";
			$transferctrl="";
			$this->log->showLog(3,"current row user=$uid, login uid=$this->currentuid");
			if($uid==$this->currentuid || $this->isAdmin)
			$transferctrl="<form method='POST' action='cashtransfer.php' >".
					"<input type='submit' value='withdraw' name='action' >".
					"<input type='hidden' value='$uid' name='uid'>".
					"<input type='hidden' value='$balancetraining' name='defaultamt'>".
					"<input type='hidden' value='$balancetransport' name='defaulttransport_amt'>".
					"</form>";
	
			echo <<< EOF
			<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$name</td>
			<td class="$rowtype" style="text-align:center;">$uname</td>
			<td class="$rowtype" style="text-align:center;">$trainingamt</td>
			<td class="$rowtype" style="text-align:center;">$transportamt</td>
			<td class="$rowtype" style="text-align:center;">$balancetraining </td>
			<td class="$rowtype" style="text-align:center;">$balancetransport </td>
			<td class="$rowtype" style="text-align:center;">
				$transferctrl
			</td>
			</tr>
EOF;

		}

			$alltrainingamt=number_format($alltrainingamt,2);
			$alltransportamt=number_format($alltransportamt,2);
			$alltTraningamt=number_format($alltTraningamt,2);
			$alltTransportamt=number_format($alltTransportamt,2);
			$allbalancetraining=number_format($allbalancetraining,2);
			$allbalancetransport=number_format($allbalancetransport,2);

echo <<<EOF
	<tr>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;"></td>
			<td class="head" style="text-align:center;">$allbalancetraining</td>
			<td class="head" style="text-align:center;">$allbalancetransport</td>
			<td class="head" style="text-align:center;"></td>
			</tr>
 </tbody></table>
EOF;
  }
 
 /**
  * Get next document number 
  * @return int
  * @access public
  */
  public function getNextCashTransferNo() {
	$sql="SELECT MAX(cashtransfer_no) as cashtransfer_no from $this->tablecashtransfer;";
	$this->log->showLog(3,'Checking next cashtransfer_no');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$newno=$row['cashtransfer_no']+1;
		$this->log->showLog(3,"Found next cashtransfer_no:$newno");
		return $newno;
	}
	else
	return 10000;
	
  } // end

 /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int category_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $cashtransfer_id,$token  ) {
	
	$mandatorysign="<b style='color:red'>*</b>";
    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	
	if ($type=="new"){
		 $timestamp= date("y/m/d H:i:s", time()) ;
		$header="New Cash Transfer";
		$action="create";
		if($cashtransfer_id==0){
	 	$this->amt=$this->defaultamt;
		$this->transport_amt=$this->defaulttransport_amt;
		$this->transferdatetime=$timestamp;
		}		
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$deletectrl="";
		$addnewctrl="";
	}
	else
	{
		$action="update";
		$savectrl="<input name='cashtransfer_id' value='$this->cashtransfer_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		$header="Edit Cash Transfer";
		
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablecashtransfer' type='hidden'>".
		"<input name='id' value='$this->cashtransfer_id' type='hidden'>".
		"<input name='idname' value='cashtransfer_id' type='hidden'>".
		"<input name='title' value='Cash Transfer' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";

		$deletectrl="<FORM action='cashtransfer.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this record?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->cashtransfer_id' name='cashtransfer_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		
		$addnewctrl="<Form action='cashtransfer.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">$header</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateCashTransfer()" method="post"
 action="cashtransfer.php" name="frmCashTransfer"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
        <tr>
        <td class="head">Place Of Transfer</td>
        <td class="odd" colspan="3">$this->orgctrl</td>
      </tr>
      <tr>
        <td class="head">Document No $mandatorysign</td>
        <td class="even" ><input maxlength="10" size="10" name="cashtransfer_no" value="$this->cashtransfer_no"></td>
      <td class="head">Transfer Date/Time $mandatorysign</td>
        <td class="even" ><input name="transferdatetime" value="$this->transferdatetime"></td>
     </tr>
 <tr>
        <td class="head">Transfer From</td>
        <td class="even" colspan="3"><input type="hidden" name="uid" value="$this->uid"> $this->username</td>
</tr><tr>
          <td class="head">Training Fees ($this->cur_symbol) $mandatorysign</td>
        <td class="odd" ><input maxlength="10" size="10" name="amt" value="$this->amt" style="text-align:right;">
          <td class="head">Transport Fees ($this->cur_symbol) $mandatorysign</td>
        <td class="odd" ><input maxlength="10" size="10" name="transport_amt" value="$this->transport_amt" style="text-align:right;">
</td>
      </tr>
 <tr>
        <td class="head" >description</td>
        <td class="even" colspan="3"> <input name="description" value='$this->description' size="80" ></td>
      </tr>
    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td></tbody></table>
  <br>

$recordctrl

EOF;
  } // end of member function getInputForm

  /**
   * Update existing cashtranfer record
   *
   * @return bool
   * @access public
  */
  public function updateCashTransfer( ) {

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablecashtransfer SET transferdatetime='$this->transferdatetime',amt=$this->amt,transport_amt=$this->transport_amt,".
	"cashtransfer_no=$this->cashtransfer_no,fromuser_id=$this->uid,description='$this->description',".
	"updated='$timestamp',updatedby=$this->updatedby,organization_id=$this->organization_id ".
	"WHERE cashtransfer_id='$this->cashtransfer_id'";
	
	$this->log->showLog(3, "Update cashtransfer_id: $this->cashtransfer_id,cashtransfer_no: $this->cashtransfer_no");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update cashtransfer failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update cashtransfer successfully.");
		return true;
	}
  } // end of member function updateCashTransfer

  /**
   * Save new category into database
   *
   * @return bool
   * @access public
  */
  public function insertCashTransfer( ) {

   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new cash transfer activity $this->cashtransfer_no");
 	$sql="INSERT INTO $this->tablecashtransfer (cashtransfer_no,transferdatetime".
	",amt,transport_amt,fromuser_id,description, created,createdby,updated,updatedby,organization_id) values(".
	"$this->cashtransfer_no,'$this->transferdatetime',$this->amt,$this->transport_amt, $this->uid ,'$this->description',".
	"'$timestamp',$this->createdby,'$timestamp',$this->updatedby,$this->organization_id)";
	$this->log->showLog(4,"Before insert cashtransfer SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert cashtransfer code  $this->cashtransfer_no");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new cashtransfer  $this->cashtransfer_no successfully"); 
		return true;
	}
  } // end of member function insertCategory

  /**
   * Pull data from cashtransfer table into class
   * int cashtransfer_id
   * @return bool
   * @access public
  */
  public function fetchCashTransfer( $cashtransfer_id) {
    
	$this->log->showLog(3,"Fetching cashtransfer detail into class CashTransfer.php.");
		
	$sql="SELECT cashtransfer_id,cashtransfer_no,amt,transport_amt,fromuser_id as uid,description,transferdatetime,organization_id ".
		"from $this->tablecashtransfer where cashtransfer_id=$cashtransfer_id";
	
	$this->log->showLog(4,"CashTransfer->fetchCashTransfer, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		
		$this->organization_id=$row["organization_id"];
		$this->cashtransfer_id=$row["cashtransfer_id"];
		$this->transport_amt=$row["transport_amt"];
		$this->cashtransfer_no= $row['cashtransfer_no'];
		$this->uid=$row['uid'];
		$this->description=$row['description'];
   		$this->transferdatetime=$row['transferdatetime'];
		$this->organization_id=$row['organization_id'];
		$this->amt=$row['amt'];
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"CashTransfer->fetchCashTransfer,failed to fetch data into databases.");	
	}
  } // end of member function fetchCategory
 
  /**
   * Delete particular cashtransfer transaction
   *
   * @param int category_id 
   * @return bool
   * @access public
*/
  public function deleteCashTransfer( $cashtransfer_id ) {
    	$this->log->showLog(2,"Warning: Performing delete cash transfer id : $cashtransfer_id !");
	$sql="DELETE FROM $this->tablecashtransfer where cashtransfer_id=$cashtransfer_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: cashtransfer ($cashtransfer_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Cash Transfer ($cashtransfer_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteCategory
   
  /**
   * Return select sql statement for cash transfer.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
  */
  public function getSQLStr_AllCashTransfer( $wherestring,  $orderbystring,  $startlimitno ) {
 
    $sql="SELECT cf.cashtransfer_id,cf.cashtransfer_no,cf.transferdatetime, cf.amt, cf.transport_amt, cf.description, cf.organization_id, u.name,u.uname,cf.fromuser_id as uid FROM ".
		" $this->tablecashtransfer cf inner join $this->tableuser u on u.uid=cf.fromuser_id $wherestring $orderbystring LIMIT 0,50";
 	$this->log->showLog(4,"Running CashTransfer->getSQLStr_AllCashTransfer: $sql");
  return $sql;
  } // end of member function getSQLStr_AllCategory
 
 /** show cashtransfer history
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
*/
 public function showCashTransferTable($wherestring,$orderbystring,$startlimitno){
	
	$this->log->showLog(3,"Showing cashtransfer Table");
	$sql=$this->getSQLStr_AllCashTransfer($wherestring,$orderbystring,0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Document No</th>
				<th style="text-align:center;">User Id</th>
				<th style="text-align:center;">User Name</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Fees Amt($this->cur_symbol)</th>
				<th style="text-align:center;">Trans. Amt($this->cur_symbol)</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Edit</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$cashtransfer_id=$row['cashtransfer_id'];
		$cashtransfer_no=$row['cashtransfer_no'];
		$transport_amt=$row['transport_amt'];
		$transferdatetime=$row['transferdatetime'];
		$amt=$row['amt'];
		$uid=$row['uid'];
		$description=$row['description'];
		$name=$row['name'];
		$uname=$row['uname'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		$editctrl="";
		if($uid==$this->currentuid || $this->isAdmin)
		$editctrl="<form action='cashtransfer.php' method='POST'>".
				"<input type='image' src='images/edit.gif' name='submit' title='Edit this record'>".
				"<input type='hidden' value='$cashtransfer_id' name='cashtransfer_id'>".
				"<input type='hidden' name='action' value='edit'>".
				"</form>";

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$cashtransfer_no</td>
			<td class="$rowtype" style="text-align:center;">$uname</td>
			<td class="$rowtype" style="text-align:center;">$name</td>
			<td class="$rowtype" style="text-alig2008-03-31n:center;">$transferdatetime</td>
			<td class="$rowtype" style="text-align:center;">$amt</td>
			<td class="$rowtype" style="text-align:center;">$transport_amt</td>
			<td class="$rowtype" style="text-align:center;">$description</td>
			<td class="$rowtype" style="text-align:center;">
				$editctrl
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

/**
   *
   * @return int
   * @access public
  */
  public function getLatestCashTransferID() {
	$sql="SELECT MAX(cashtransfer_id) as cashtransfer_id from $this->tablecashtransfer;";
	$this->log->showLog(3,'Checking latest created cashtransfer_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created cashtransfer_id:' . $row['cashtransfer_id']);
		return $row['cashtransfer_id'];
	}
	else
	return -1;
	
  } // end

} // end of ClassCategory
?>

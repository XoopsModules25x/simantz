<?php


class BPartnerGroup
{

  public $bpartnergroup_id;
  public $bpartnergroup_name;
  public $organization_id;
  public $debtoraccountsctrl;
  public $creditoraccountsctrl;
  public $creditoraccounts_id;
  public $debtoraccounts_id;
  public $isactive;
  public $description;
  public $defaultlevel;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tablebpartnergroup;
  private $tablebpartner;

  private $log;


//constructor
   public function BPartnerGroup(){
	global $xoopsDB,$log,$tablebpartnergroup,$tablebpartner,$tablebpartnergroup,$tableorganization,$tableaccounts;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablebpartnergroup=$tablebpartnergroup;
	$this->tablebpartner=$tablebpartner;
	$this->tableaccounts=$tableaccounts;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int bpartnergroup_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $bpartnergroup_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Business Partner Group";
		$action="create";
	 	
		if($bpartnergroup_id==0){
			$this->bpartnergroup_name="";
			$this->isactive="";
			$this->defaultlevel=10;
			$bpartnergroupchecked="CHECKED";

		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

	
	}
	else
	{
		
		$action="update";
		$savectrl="<input name='bpartnergroup_id' value='$this->bpartnergroup_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$tablebpartnergroup' type='hidden'>".
		"<input name='id' value='$this->bpartnergroup_id' type='hidden'>".
		"<input name='idname' value='bpartnergroup_id' type='hidden'>".
		"<input name='title' value='BPartnerGroup' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

		if ($this->accounts_id==1)
			$bpartnergroupchecked="CHECKED";
		else
			$bpartnergroupchecked="";

		$header="Edit Business Partner Group";
		
		if($this->allowDelete($this->bpartnergroup_id))
		$deletectrl="<FORM action='bpartnergroup.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this bpartnergroup?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->bpartnergroup_id' name='bpartnergroup_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='bpartnergroup.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateBPartnerGroup()" method="post"
 action="bpartnergroup.php" name="frmBPartnerGroup"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even">$this->orgctrl</td>
        <td class="head">Business Partner Group Name $mandatorysign</td>
        <td class="even" ><input maxlength="30" size="30" name="bpartnergroup_name" value="$this->bpartnergroup_name">
		&nbsp;Active <input type="checkbox" $checked name="isactive">
 
      </tr>
      <tr>

  	<td class="head">Default Debtor Account $mandatorysign</td>
        <td class="even">$this->debtoraccountsctrl</td>
  	<td class="head">Default Creditor Account $mandatorysign</td>
        <td class="even">$this->creditoraccountsctrl</td>

      </tr>
      <tr>
        <td class="head">Description</td>
        <td class="odd"><input maxlength="70" size="50" name="description" value="$this->description"></td>
   	<td class="head">Default Level $mandatorysign</td>
	        <td class="even" ><input maxlength="3" size="3" name='defaultlevel' value='$this->defaultlevel'>
	</td>
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
   * Update existing bpartnergroup record
   *
   * @return bool
   * @access public
   */
  public function updateBPartnerGroup( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablebpartnergroup SET 
	bpartnergroup_name='$this->bpartnergroup_name',description='$this->description',debtoraccounts_id=$this->debtoraccounts_id,
	creditoraccounts_id=$this->creditoraccounts_id,
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',defaultlevel=$this->defaultlevel,
	organization_id=$this->organization_id WHERE bpartnergroup_id='$this->bpartnergroup_id'";
	
	$this->log->showLog(3, "Update bpartnergroup_id: $this->bpartnergroup_id, $this->bpartnergroup_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update bpartnergroup failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update bpartnergroup successfully.");
		return true;
	}
  } // end of member function updateBPartnerGroup

  /**
   * Save new bpartnergroup into database
   *
   * @return bool
   * @access public
   */
  public function insertBPartnerGroup( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new bpartnergroup $this->bpartnergroup_name");
 	$sql="INSERT INTO $this->tablebpartnergroup (bpartnergroup_name,isactive, created,createdby,
	updated,updatedby,defaultlevel,organization_id,description,debtoraccounts_id,creditoraccounts_id) values(
	'$this->bpartnergroup_name','$this->isactive','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->defaultlevel,$this->organization_id,'$this->description',$this->debtoraccounts_id,$this->creditoraccounts_id)";

	$this->log->showLog(4,"Before insert bpartnergroup SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert bpartnergroup code $bpartnergroup_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new bpartnergroup $bpartnergroup_name successfully"); 
		return true;
	}
  } // end of member function insertBPartnerGroup

  /**
   * Pull data from bpartnergroup table into class
   *
   * @return bool
   * @access public
   */
  public function fetchBPartnerGroup( $bpartnergroup_id) {


	$this->log->showLog(3,"Fetching bpartnergroup detail into class BPartnerGroup.php.<br>");
		
	$sql="SELECT bpartnergroup_id,bpartnergroup_name,isactive,defaultlevel,organization_id,description,debtoraccounts_id,creditoraccounts_id
		 from $this->tablebpartnergroup where bpartnergroup_id=$bpartnergroup_id";
	
	$this->log->showLog(4,"ProductBPartnerGroup->fetchBPartnerGroup, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->bpartnergroup_name=$row["bpartnergroup_name"];
		$this->organization_id=$row['organization_id'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->isactive=$row['isactive'];
		$this->debtoraccounts_id=$row['debtoraccounts_id'];
		$this->creditoraccounts_id=$row['creditoraccounts_id'];
		$this->description=$row['description'];
   	$this->log->showLog(4,"BPartnerGroup->fetchBPartnerGroup,database fetch into class successfully");
	$this->log->showLog(4,"bpartnergroup_name:$this->bpartnergroup_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"BPartnerGroup->fetchBPartnerGroup,failed to fetch data into databases:" . mysql_error(). ":$sql");	
	}
  } // end of member function fetchBPartnerGroup

  /**
   * Delete particular bpartnergroup id
   *
   * @param int bpartnergroup_id 
   * @return bool
   * @access public
   */
  public function deleteBPartnerGroup( $bpartnergroup_id ) {
    	$this->log->showLog(2,"Warning: Performing delete bpartnergroup id : $bpartnergroup_id !");
	$sql="DELETE FROM $this->tablebpartnergroup where bpartnergroup_id=$bpartnergroup_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: bpartnergroup ($bpartnergroup_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"bpartnergroup ($bpartnergroup_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteBPartnerGroup

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllBPartnerGroup( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductBPartnerGroup->getSQLStr_AllBPartnerGroup: $sql");

    $sql="SELECT g.bpartnergroup_name,g.bpartnergroup_id,g.isactive,g.organization_id,g.defaultlevel FROM $this->tablebpartnergroup g
	$wherestring $orderbystring";
    $this->log->showLog(4,"Generate showbpartnergrouptable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllBPartnerGroup

 public function showBPartnerGroupTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing BPartnerGroup Table");
	$sql=$this->getSQLStr_AllBPartnerGroup($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Business Partner Group Name</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Default Level</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$bpartnergroup_id=$row['bpartnergroup_id'];
		$bpartnergroup_name=$row['bpartnergroup_name'];

		$defaultlevel=$row['defaultlevel'];

		$isactive=$row['isactive'];
		
		if($isactive==0)
		{$isactive='N';
		$isactive="<b style='color:red;'>N</b>";
		}
		else
		$isactive='Y';

		if($accounts_id==0)
			$accounts_id="N";
		else
			$accounts_id='Y';

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$bpartnergroup_name</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$defaultlevel</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="bpartnergroup.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this bpartnergroup'>
				<input type="hidden" value="$bpartnergroup_id" name="bpartnergroup_id">
				<input type="hidden" name="action" value="edit">
				</form>
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
  public function getLatestBPartnerGroupID() {
	$sql="SELECT MAX(bpartnergroup_id) as bpartnergroup_id from $this->tablebpartnergroup;";
	$this->log->showLog(3,'Checking latest created bpartnergroup_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created bpartnergroup_id:' . $row['bpartnergroup_id']);
		return $row['bpartnergroup_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablebpartnergroup;";
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

 public function allowDelete($bpartnergroup_id){
	$sql="SELECT count(bpartner_id) as rowcount from $this->tablebpartner where bpartnergroup_id=$bpartnergroup_id";
	$this->log->showLog(3,"Accessing ProductCurrency->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this currency, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this currency, record deletable.");
		return true;
		}
	}


} // end of ClassBPartnerGroup
?>

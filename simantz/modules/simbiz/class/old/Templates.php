<?php


class AccountGroup
{

  public $accountgroup_id;
  public $accountgroup_name;
  public $organization_id;
  public $accountgroup_code;
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
  private $tableaccountgroup;
  private $tablebpartner;

  private $log;


//constructor
   public function AccountGroup(){
	global $xoopsDB,$log,$tableaccountgroup,$tablebpartner,$tablebpartnergroup,$tableorganization;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tableaccountgroup=$tableaccountgroup;
	$this->tablebpartner=$tablebpartner;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int accountgroup_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $accountgroup_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New AccountGroup";
		$action="create";
	 	
		if($accountgroup_id==0){
			$this->accountgroup_name="";
			$this->isactive="";
			$this->defaultlevel=10;
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
		$savectrl="<input name='accountgroup_id' value='$this->accountgroup_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$tableaccountgroup' type='hidden'>".
		"<input name='id' value='$this->accountgroup_id' type='hidden'>".
		"<input name='idname' value='accountgroup_id' type='hidden'>".
		"<input name='title' value='AccountGroup' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

	
		$header="Edit AccountGroup";
		
		if($this->allowDelete($this->accountgroup_id))
		$deletectrl="<FORM action='accountgroup.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this accountgroup?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->accountgroup_id' name='accountgroup_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='accountgroup.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Account Group Master</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateAccountGroup()" method="post"
 action="accountgroup.php" name="frmAccountGroup"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl</td>
   	<td class="head">Account Class</td>
        <td class="even" >$this->accounclassctrl</td>
      </tr>
      <tr>
        <td class="head">Group Name $mandatorysign</td>
        <td class="even" ><input maxlength="30" size="30" name="accountgroup_name" value="$this->accountgroup_name">
		&nbsp;Active <input type="checkbox" $checked name="isactive">
   	<td class="head">Default Level $mandatorysign</td>
	        <td class="even" ><input maxlength="3" size="3" name='defaultlevel' value='$this->defaultlevel'>
	</td>
      </tr>
      <tr>
        <td class="head">Description</td>
        <td class="odd" colspan='3'><input maxlength="70" size="50" name="description" value="$this->description"></td>
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
   * Update existing accountgroup record
   *
   * @return bool
   * @access public
   */
  public function updateAccountGroup( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableaccountgroup SET 
	accountgroup_name='$this->accountgroup_name',description='$this->description',accountclass_id=$this->accountclass_id,
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',defaultlevel=$this->defaultlevel,
	organization_id=$this->organization_id WHERE accountgroup_id='$this->accountgroup_id'";
	
	$this->log->showLog(3, "Update accountgroup_id: $this->accountgroup_id, $this->accountgroup_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update accountgroup failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update accountgroup successfully.");
		return true;
	}
  } // end of member function updateAccountGroup

  /**
   * Save new accountgroup into database
   *
   * @return bool
   * @access public
   */
  public function insertAccountGroup( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new accountgroup $this->accountgroup_name");
 	$sql="INSERT INTO $this->tableaccountgroup (accountgroup_name,isactive, created,createdby,
	updated,updatedby,defaultlevel,organization_id,description,accountclass_id) values(
	'$this->accountgroup_name','$this->isactive','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->defaultlevel,$this->organization_id,'$this->description',$this->accountclass_id)";

	$this->log->showLog(4,"Before insert accountgroup SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert accountgroup code $accountgroup_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new accountgroup $accountgroup_name successfully"); 
		return true;
	}
  } // end of member function insertAccountGroup

  /**
   * Pull data from accountgroup table into class
   *
   * @return bool
   * @access public
   */
  public function fetchAccountGroup( $accountgroup_id) {


	$this->log->showLog(3,"Fetching accountgroup detail into class AccountGroup.php.<br>");
		
	$sql="SELECT accountgroup_id,accountgroup_name,isactive,defaultlevel,organization_id,description,accountclass_id
		 from $this->tableaccountgroup where accountgroup_id=$accountgroup_id";
	
	$this->log->showLog(4,"ProductAccountGroup->fetchAccountGroup, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->accountgroup_name=$row["accountgroup_name"];
		$this->organization_id=$row['organization_id'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->isactive=$row['isactive'];
		$this->accountclass_id=$row['accountclass_id'];
		$this->description=$row['description'];
   	$this->log->showLog(4,"AccountGroup->fetchAccountGroup,database fetch into class successfully");
	$this->log->showLog(4,"accountgroup_name:$this->accountgroup_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"AccountGroup->fetchAccountGroup,failed to fetch data into databases:" . mysql_error(). ":$sql");	
	}
  } // end of member function fetchAccountGroup

  /**
   * Delete particular accountgroup id
   *
   * @param int accountgroup_id 
   * @return bool
   * @access public
   */
  public function deleteAccountGroup( $accountgroup_id ) {
    	$this->log->showLog(2,"Warning: Performing delete accountgroup id : $accountgroup_id !");
	$sql="DELETE FROM $this->tableaccountgroup where accountgroup_id=$accountgroup_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: accountgroup ($accountgroup_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"accountgroup ($accountgroup_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteAccountGroup

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllAccountGroup( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductAccountGroup->getSQLStr_AllAccountGroup: $sql");

    $sql="SELECT accountgroup_name,accountgroup_id,isactive,organization_id,defaultlevel,accountclass_id FROM $this->tableaccountgroup " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showaccountgrouptable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllAccountGroup

 public function showAccountGroupTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing AccountGroup Table");
	$sql=$this->getSQLStr_AllAccountGroup($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">AccountGroup Name</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Default Level</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$accountgroup_id=$row['accountgroup_id'];
		$accountgroup_name=$row['accountgroup_name'];

		$defaultlevel=$row['defaultlevel'];

		$isactive=$row['isactive'];
		
		if($isactive==0)
		{$isactive='N';
		$isactive="<b style='color:red;'>$isactive</b>";
		}
		else
		$isactive='Y';
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$accountgroup_name</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$defaultlevel</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="accountgroup.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this accountgroup'>
				<input type="hidden" value="$accountgroup_id" name="accountgroup_id">
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
  public function getLatestAccountGroupID() {
	$sql="SELECT MAX(accountgroup_id) as accountgroup_id from $this->tableaccountgroup;";
	$this->log->showLog(3,'Checking latest created accountgroup_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created accountgroup_id:' . $row['accountgroup_id']);
		return $row['accountgroup_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tableaccountgroup;";
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

 public function allowDelete($accountgroup_id){
	$sql="SELECT count(bpartner_id) as rowcount from $this->tablebpartner where bpartner_accountgroup_id=$accountgroup_id";
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


} // end of ClassAccountGroup
?>

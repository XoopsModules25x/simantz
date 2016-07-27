<?php


class FollowUpType
{

  public $followuptype_id;
  public $followuptype_name;
  public $organization_id;

  public $isactive;
  public $description;
  public $defaultlevel;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;

  private $xoopsDB;
  private $tableprefix;
  private $tablefollowuptype;
  private $tablebpartner;
  private $defaultorganization_id;
  private $log;


//constructor
   public function FollowUpType(){
	global $xoopsDB,$log,$tablefollowuptype,$tablefollowup,$tablefollowuptype,
        $tablebpartner,$tablebpartnergroup,$tableorganization,$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablefollowuptype=$tablefollowuptype;
        $this->tablefollowup=$tablefollowup;

	$this->tablebpartner=$tablebpartner;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int followuptype_id
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $followuptype_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New FollowUpType";
		$action="create";
	 	
		if($followuptype_id==0){
			$this->followuptype_name="";
			$this->isactive="";
			$this->defaultlevel=10;
			$this->daycount=0;
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
		$savectrl="<input name='followuptype_id' value='$this->followuptype_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$tablefollowuptype' type='hidden'>".
		"<input name='id' value='$this->followuptype_id' type='hidden'>".
		"<input name='idname' value='followuptype_id' type='hidden'>".
		"<input name='title' value='FollowUpType' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

	
		$header="Edit FollowUpType";
		
		if($this->allowDelete($this->followuptype_id))
		$deletectrl="<FORM action='followuptype.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this followuptype?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->followuptype_id' name='followuptype_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='followuptype.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateFollowUpType()" method="post"
 action="followuptype.php" name="frmFollowUpType"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl</td>
   	<td class="head">Default Level $mandatorysign</td>
	        <td class="even" ><input maxlength="3" size="3" name='defaultlevel' value='$this->defaultlevel'>
      </tr>
      <tr>
        <td class="head">FollowUpType Name $mandatorysign</td>
        <td class="even" ><input maxlength="30" size="30" name="followuptype_name" value="$this->followuptype_name">
		&nbsp;Active <input type="checkbox" $checked name="isactive">
   	
	</td>  <td class="head">Description</td>
        <td class="odd"><input name="description" value="$this->description"></td>

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
   * Update existing followuptype record
   *
   * @return bool
   * @access public
   */
  public function updateFollowUpType( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablefollowuptype SET
	followuptype_name='$this->followuptype_name',description='$this->description',
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',defaultlevel=$this->defaultlevel,
	organization_id=$this->organization_id WHERE followuptype_id='$this->followuptype_id'";
	
	$this->log->showLog(3, "Update followuptype_id: $this->followuptype_id, $this->followuptype_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update followuptype failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update followuptype successfully.");
		return true;
	}
  } // end of member function updateFollowUpType

  /**
   * Save new followuptype into database
   *
   * @return bool
   * @access public
   */
  public function insertFollowUpType( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new followuptype $this->followuptype_name");
 	$sql="INSERT INTO $this->tablefollowuptype (followuptype_name,isactive, created,createdby,
	updated,updatedby,defaultlevel,organization_id,description) values(
	'$this->followuptype_name','$this->isactive','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->defaultlevel,$this->organization_id,'$this->description')";

	$this->log->showLog(4,"Before insert followuptype SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert followuptype code $followuptype_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new followuptype $followuptype_name successfully");
		return true;
	}
  } // end of member function insertFollowUpType

  /**
   * Pull data from followuptype table into class
   *
   * @return bool
   * @access public
   */
  public function fetchFollowUpType( $followuptype_id) {


	$this->log->showLog(3,"Fetching followuptype detail into class FollowUpType.php.<br>");
		
	$sql="SELECT followuptype_id,followuptype_name,isactive,defaultlevel,organization_id,description
		 from $this->tablefollowuptype where followuptype_id=$followuptype_id";
	
	$this->log->showLog(4,"ProductFollowUpType->fetchFollowUpType, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->followuptype_name=$row["followuptype_name"];
		$this->organization_id=$row['organization_id'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->isactive=$row['isactive'];

		$this->description=$row['description'];
   	$this->log->showLog(4,"FollowUpType->fetchFollowUpType,database fetch into class successfully");
	$this->log->showLog(4,"followuptype_name:$this->followuptype_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"FollowUpType->fetchFollowUpType,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchFollowUpType

  /**
   * Delete particular followuptype id
   *
   * @param int followuptype_id
   * @return bool
   * @access public
   */
  public function deleteFollowUpType( $followuptype_id ) {
    	$this->log->showLog(2,"Warning: Performing delete followuptype id : $followuptype_id !");
	$sql="DELETE FROM $this->tablefollowuptype where followuptype_id=$followuptype_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: followuptype ($followuptype_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"followuptype ($followuptype_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteFollowUpType

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllFollowUpType( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductFollowUpType->getSQLStr_AllFollowUpType: $sql");

    $sql="SELECT followuptype_name,followuptype_id,isactive,organization_id,description,defaultlevel FROM $this->tablefollowuptype " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showfollowuptypetable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllFollowUpType

 public function showFollowUpTypeTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing FollowUpType Table");
	$sql=$this->getSQLStr_AllFollowUpType($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">FollowUpType Name</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$followuptype_id=$row['followuptype_id'];
		$followuptype_name=$row['followuptype_name'];

		$defaultlevel=$row['defaultlevel'];
		$description=$row['description'];

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
			<td class="$rowtype" style="text-align:center;">$followuptype_name</td>


			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$description</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="followuptype.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this followuptype'>
				<input type="hidden" value="$followuptype_id" name="followuptype_id">
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
  public function getLatestFollowUpTypeID() {
	$sql="SELECT MAX(followuptype_id) as followuptype_id from $this->tablefollowuptype;";
	$this->log->showLog(3,'Checking latest created followuptype_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created followuptype_id:' . $row['followuptype_id']);
		return $row['followuptype_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablefollowuptype;";
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

 public function allowDelete($followuptype_id){
	$sql="SELECT count(followuptype) as rowcount from $this->tablefollowup where followuptype_id=$followuptype_id";
	$this->log->showLog(3,"Accessing Followuptype->allowDelete to verified id:$id is deletable.");
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


} // end of ClassFollowUpType
?>

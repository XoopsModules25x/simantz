<?php


class Terms
{

  public $terms_id;
  public $terms_name;
  public $organization_id;
  public $daycount;
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
  private $tableterms;
  private $tablebpartner;
  private $defaultorganization_id;
  private $log;


//constructor
   public function Terms(){
	global $xoopsDB,$log,$tableterms,$tablebpartner,$tablebpartnergroup,$tableorganization,$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tableterms=$tableterms;
	$this->tablebpartner=$tablebpartner;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int terms_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $terms_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Terms";
		$action="create";
	 	
		if($terms_id==0){
			$this->terms_name="";
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
		$savectrl="<input name='terms_id' value='$this->terms_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$tableterms' type='hidden'>".
		"<input name='id' value='$this->terms_id' type='hidden'>".
		"<input name='idname' value='terms_id' type='hidden'>".
		"<input name='title' value='Terms' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

	
		$header="Edit Terms";
		
		if($this->allowDelete($this->terms_id))
		$deletectrl="<FORM action='terms.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this terms?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->terms_id' name='terms_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='terms.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateTerms()" method="post"
 action="terms.php" name="frmTerms"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl</td>
   	<td class="head">Due Day $mandatorysign</td>
        <td class="even" ><input name='daycount' value=$this->daycount></td>
      </tr>
      <tr>
        <td class="head">Terms Name $mandatorysign</td>
        <td class="even" ><input maxlength="30" size="30" name="terms_name" value="$this->terms_name">
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
   * Update existing terms record
   *
   * @return bool
   * @access public
   */
  public function updateTerms( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableterms SET 
	terms_name='$this->terms_name',description='$this->description',daycount=$this->daycount,
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',defaultlevel=$this->defaultlevel,
	organization_id=$this->organization_id WHERE terms_id='$this->terms_id'";
	
	$this->log->showLog(3, "Update terms_id: $this->terms_id, $this->terms_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update terms failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update terms successfully.");
		return true;
	}
  } // end of member function updateTerms

  /**
   * Save new terms into database
   *
   * @return bool
   * @access public
   */
  public function insertTerms( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new terms $this->terms_name");
 	$sql="INSERT INTO $this->tableterms (terms_name,isactive, created,createdby,
	updated,updatedby,defaultlevel,organization_id,description,daycount) values(
	'$this->terms_name','$this->isactive','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->defaultlevel,$this->organization_id,'$this->description',$this->daycount)";

	$this->log->showLog(4,"Before insert terms SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert terms code $terms_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new terms $terms_name successfully"); 
		return true;
	}
  } // end of member function insertTerms

  /**
   * Pull data from terms table into class
   *
   * @return bool
   * @access public
   */
  public function fetchTerms( $terms_id) {


	$this->log->showLog(3,"Fetching terms detail into class Terms.php.<br>");
		
	$sql="SELECT terms_id,terms_name,isactive,defaultlevel,organization_id,description,daycount
		 from $this->tableterms where terms_id=$terms_id";
	
	$this->log->showLog(4,"ProductTerms->fetchTerms, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->terms_name=$row["terms_name"];
		$this->organization_id=$row['organization_id'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->isactive=$row['isactive'];
		$this->daycount=$row['daycount'];
		$this->description=$row['description'];
   	$this->log->showLog(4,"Terms->fetchTerms,database fetch into class successfully");
	$this->log->showLog(4,"terms_name:$this->terms_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Terms->fetchTerms,failed to fetch data into databases:" . mysql_error(). ":$sql");	
	}
  } // end of member function fetchTerms

  /**
   * Delete particular terms id
   *
   * @param int terms_id 
   * @return bool
   * @access public
   */
  public function deleteTerms( $terms_id ) {
    	$this->log->showLog(2,"Warning: Performing delete terms id : $terms_id !");
	$sql="DELETE FROM $this->tableterms where terms_id=$terms_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: terms ($terms_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"terms ($terms_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteTerms

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllTerms( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductTerms->getSQLStr_AllTerms: $sql");

    $sql="SELECT terms_name,terms_id,isactive,organization_id,defaultlevel,daycount FROM $this->tableterms " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showtermstable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllTerms

 public function showTermsTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing Terms Table");
	$sql=$this->getSQLStr_AllTerms($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Terms Name</th>
				<th style="text-align:center;">Due Day</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Default Level</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$terms_id=$row['terms_id'];
		$terms_name=$row['terms_name'];

		$defaultlevel=$row['defaultlevel'];
		$daycount=$row['daycount'];

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
			<td class="$rowtype" style="text-align:center;">$terms_name</td>
			<td class="$rowtype" style="text-align:center;">$daycount</td>

			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$defaultlevel</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="terms.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this terms'>
				<input type="hidden" value="$terms_id" name="terms_id">
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
  public function getLatestTermsID() {
	$sql="SELECT MAX(terms_id) as terms_id from $this->tableterms;";
	$this->log->showLog(3,'Checking latest created terms_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created terms_id:' . $row['terms_id']);
		return $row['terms_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tableterms;";
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

 public function allowDelete($terms_id){
	$sql="SELECT count(bpartner_id) as rowcount from $this->tablebpartner bp where bp.terms_id=$terms_id";
	$this->log->showLog(3,"Accessing ProductCurrency->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);
	//		echo "$sql";
	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			//$this->log->showLog(1, $row['rowcount'] . " record found in this currency, record not deletable");
			echo $row['rowcount'] . " record found in this currency, record not deletable";
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this currency, record deletable.");
		return true;
		}
	}


} // end of ClassTerms
?>

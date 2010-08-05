<?php


class Tax
{

  public $tax_id;
  public $tax_name;
  public $organization_id;
  public $istax;
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
  private $tabletax;
  private $tablebpartner;

  private $log;


//constructor
   public function Tax(){
	global $xoopsDB,$log,$tabletax,$tablebpartner,$tablebpartnergroup,$tableorganization;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tabletax=$tabletax;
	$this->tablebpartner=$tablebpartner;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int tax_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $tax_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Tax";
		$action="create";
	 	
		if($tax_id==0){
			$this->tax_name="";
			$this->isactive="";
			$this->defaultlevel=10;
			$taxchecked="CHECKED";

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
		$savectrl="<input name='tax_id' value='$this->tax_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$tabletax' type='hidden'>".
		"<input name='id' value='$this->tax_id' type='hidden'>".
		"<input name='idname' value='tax_id' type='hidden'>".
		"<input name='title' value='Tax' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

		if ($this->istax==1)
			$taxchecked="CHECKED";
		else
			$taxchecked="";

		$header="Edit Tax";
		
		if($this->allowDelete($this->tax_id))
		$deletectrl="<FORM action='tax.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this tax?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->tax_id' name='tax_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='tax.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF


<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateTax()" method="post"
 action="tax.php" name="frmTax"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl</td>
   	<td class="head">Declare Tax $mandatorysign</td>
        <td class="even" ><input name='istax' type='checkbox' $taxchecked></td>
      </tr>
      <tr>
        <td class="head">Tax Name $mandatorysign</td>
        <td class="even" ><input maxlength="30" size="30" name="tax_name" value="$this->tax_name">
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
   * Update existing tax record
   *
   * @return bool
   * @access public
   */
  public function updateTax( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tabletax SET 
	tax_name='$this->tax_name',description='$this->description',istax=$this->istax,
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',defaultlevel=$this->defaultlevel,
	organization_id=$this->organization_id WHERE tax_id='$this->tax_id'";
	
	$this->log->showLog(3, "Update tax_id: $this->tax_id, $this->tax_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update tax failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update tax successfully.");
		return true;
	}
  } // end of member function updateTax

  /**
   * Save new tax into database
   *
   * @return bool
   * @access public
   */
  public function insertTax( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new tax $this->tax_name");
 	$sql="INSERT INTO $this->tabletax (tax_name,isactive, created,createdby,
	updated,updatedby,defaultlevel,organization_id,description,istax) values(
	'$this->tax_name','$this->isactive','$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->defaultlevel,$this->organization_id,'$this->description',$this->istax)";

	$this->log->showLog(4,"Before insert tax SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert tax code $tax_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new tax $tax_name successfully"); 
		return true;
	}
  } // end of member function insertTax

  /**
   * Pull data from tax table into class
   *
   * @return bool
   * @access public
   */
  public function fetchTax( $tax_id) {


	$this->log->showLog(3,"Fetching tax detail into class Tax.php.<br>");
		
	$sql="SELECT tax_id,tax_name,isactive,defaultlevel,organization_id,description,istax
		 from $this->tabletax where tax_id=$tax_id";
	
	$this->log->showLog(4,"ProductTax->fetchTax, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->tax_name=$row["tax_name"];
		$this->organization_id=$row['organization_id'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->isactive=$row['isactive'];
		$this->istax=$row['istax'];
		$this->description=$row['description'];
   	$this->log->showLog(4,"Tax->fetchTax,database fetch into class successfully");
	$this->log->showLog(4,"tax_name:$this->tax_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Tax->fetchTax,failed to fetch data into databases:" . mysql_error(). ":$sql");	
	}
  } // end of member function fetchTax

  /**
   * Delete particular tax id
   *
   * @param int tax_id 
   * @return bool
   * @access public
   */
  public function deleteTax( $tax_id ) {
    	$this->log->showLog(2,"Warning: Performing delete tax id : $tax_id !");
	$sql="DELETE FROM $this->tabletax where tax_id=$tax_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: tax ($tax_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"tax ($tax_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteTax

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllTax( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductTax->getSQLStr_AllTax: $sql");

    $sql="SELECT tax_name,tax_id,isactive,organization_id,defaultlevel,istax FROM $this->tabletax " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showtaxtable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllTax

 public function showTaxTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing Tax Table");
	$sql=$this->getSQLStr_AllTax($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Tax Name</th>
				<th style="text-align:center;">Declare Tax</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Default Level</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$tax_id=$row['tax_id'];
		$tax_name=$row['tax_name'];

		$defaultlevel=$row['defaultlevel'];
		$istax=$row['istax'];

		$isactive=$row['isactive'];
		
		if($isactive==0)
		{$isactive='N';
		$isactive="<b style='color:red;'>N</b>";
		}
		else
		$isactive='Y';

		if($istax==0)
			$istax="N";
		else
			$istax='Y';

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$tax_name</td>
			<td class="$rowtype" style="text-align:center;">$istax</td>

			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$defaultlevel</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="tax.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this tax'>
				<input type="hidden" value="$tax_id" name="tax_id">
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
  public function getLatestTaxID() {
	$sql="SELECT MAX(tax_id) as tax_id from $this->tabletax;";
	$this->log->showLog(3,'Checking latest created tax_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created tax_id:' . $row['tax_id']);
		return $row['tax_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tabletax;";
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

 public function allowDelete($tax_id){
	$sql="SELECT count(bpartner_id) as rowcount from $this->tablebpartner where bpartner_tax_id=$tax_id";
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


} // end of ClassTax
?>

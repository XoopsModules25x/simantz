<?php


class Closing
{

  public $closing_id;
  public $period_id;
  public $closing_no;
  public $isactive;
  public $iscomplete;
  public $organization_id;
  public $closing_description;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $periodctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tableclosing;
  private $tablebpartner;
  private $tableperiod;
  private $defaultorganization_id;
  private $log;


//constructor
   public function Closing(){
	global $xoopsDB,$log,$tableclosing,$tablebpartner,$tablebpartnergroup,$tableorganization,$defaultorganization_id,$tableperiod;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tableclosing=$tableclosing;
	$this->tablebpartner=$tablebpartner;
	$this->tableperiod=$tableperiod;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int closing_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $closing_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$completectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Closing";
		$action="create";
	 	
		if($closing_id==0){
			$this->closing_no = getNewCode($this->xoopsDB,"closing_no",$this->tableclosing);
			//$this->closing_name="";
			$this->isactive="";
			$this->iscomplete="";
			
		}
		$savectrl="<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";
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
		$savectrl="<input name='closing_id' value='$this->closing_id' type='hidden'>".
			 "<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$tableclosing' type='hidden'>".
		"<input name='id' value='$this->closing_id' type='hidden'>".
		"<input name='idname' value='closing_id' type='hidden'>".
		"<input name='title' value='Closing' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

		if ($this->iscomplete==1)
			$checked2="CHECKED";
		else
			$checked2="";

	
		$header="Edit Closing";
		
		if($this->allowDelete($this->closing_id))
		$deletectrl="<FORM action='closing.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this closing?"'.")'><input type='submit' value='Delete' name='btnDelete' style='height: 40px;'>".
		"<input type='hidden' value='$this->closing_id' name='closing_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='closing.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";

		

	}
	$addnewctrl="<a href='closing.php'>[ Add New ]</a><a href='closing.php?action=showsearchform'>[ Search ]</a>";
	$completectrl = "<input type='button' value='Complete' name='btnComplete' style='height: 40px;' onclick='completeRecord();'>";

    echo <<< EOF
<table style="width:140px;"><tbody><td nowrap>$addnewctrl</td><td><form onsubmit="return validateClosing()" method="post"
 action="closing.php" name="frmClosing"></td>
<tr>
<td><input name="reset" value="Reset" type="reset"></td>
</tr>
</tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" colspan="3">$this->orgctrl</td>
 
      </tr>
      <tr>
	<td class="head">Closing No $mandatorysign</td>
        <td class="odd"><input name="closing_no" size="10" maxlength="10" value="$this->closing_no"></td>
        <td class="head">Closing Period $mandatorysign</td>
        <td class="odd">$this->periodctrl
		&nbsp;Active <input type="checkbox" $checked name="isactive">
		<div style="display:none">&nbsp;Complete <input type="checkbox" $checked2 name="iscomplete" ></div>
   	
	</td>
      </tr>
      <tr>
        <td class="head">Description</td>
        <td class="even" colspan='3'><input maxlength="70" size="50" name="closing_description" value="$this->closing_description"></td>
      </tr>
 
    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$completectrl</td><td>$deletectrl</td></tbody></table>
  <br>

$recordctrl

EOF;
  } // end of member function getInputForm

  /**
   * Update existing closing record
   *
   * @return bool
   * @access public
   */
  public function updateClosing( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableclosing SET 
	period_id='$this->period_id',closing_description='$this->closing_description',closing_no='$this->closing_no',
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',iscomplete='$this->iscomplete',
	organization_id=$this->organization_id WHERE closing_id='$this->closing_id'";
	
	$this->log->showLog(3, "Update closing_id: $this->closing_id, $this->closing_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update closing failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update closing successfully.");
		return true;
	}
  } // end of member function updateClosing

  /**
   * Save new closing into database
   *
   * @return bool
   * @access public
   */
  public function insertClosing( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new closing $this->closing_name");
 	$sql="INSERT INTO $this->tableclosing (
				period_id,
				isactive,
				iscomplete,  
				created,
				createdby,
				updated,
				updatedby,
				organization_id,
				closing_description,
				closing_no) 
				values(
				'$this->period_id',
				'$this->isactive',
				'$this->iscomplete',
				'$timestamp',
				$this->createdby,
				'$timestamp',
				$this->updatedby,
				$this->organization_id,
				'$this->closing_description',
				'$this->closing_no')";

	$this->log->showLog(4,"Before insert closing SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert closing code $closing_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new closing $closing_name successfully"); 
		return true;
	}
  } // end of member function insertClosing

  /**
   * Pull data from closing table into class
   *
   * @return bool
   * @access public
   */
  public function fetchClosing( $closing_id) {


	$this->log->showLog(3,"Fetching closing detail into class Closing.php.<br>");
		
	$sql="SELECT * 
		 from $this->tableclosing where closing_id=$closing_id";
	
	$this->log->showLog(4,"ProductClosing->fetchClosing, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->period_id=$row["period_id"];
		$this->organization_id=$row['organization_id'];
		$this->isactive=$row['isactive'];
		$this->iscomplete=$row['iscomplete'];
		$this->closing_description=$row['closing_description'];
		$this->closing_no=$row['closing_no'];
   	$this->log->showLog(4,"Closing->fetchClosing,database fetch into class successfully");
	//$this->log->showLog(4,"closing_name:$this->closing_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Closing->fetchClosing,failed to fetch data into databases:" . mysql_error(). ":$sql");	
	}
  } // end of member function fetchClosing

  /**
   * Delete particular closing id
   *
   * @param int closing_id 
   * @return bool
   * @access public
   */
  public function deleteClosing( $closing_id ) {
	
    	$this->log->showLog(2,"Warning: Performing delete closing id : $closing_id !");
	$sql="DELETE FROM $this->tableclosing where closing_id=$closing_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: closing ($closing_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"closing ($closing_id) removed from database successfully!");
		return true;
		
	}
	
	
  } // end of member function deleteClosing

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllClosing( $wherestring,  $orderbystring,$limit="") {
  $this->log->showLog(4,"Running ProductClosing->getSQLStr_AllClosing: $sql");
	
	if($wherestring=="")
	$wherestring .= " WHERE a.period_id = b.period_id ";
	else
	$wherestring .= " AND a.period_id = b.period_id ";

    	$sql="SELECT closing_no,period_name,a.period_id,closing_id,a.isactive,iscomplete,organization_id FROM $this->tableclosing a, $this->tableperiod b 
	$wherestring $orderbystring $limit";
    $this->log->showLog(4,"Generate showclosingtable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllClosing

 public function showClosingTable($wherestring,$orderbystring,$limit=""){
	
	$this->log->showLog(3,"Showing Closing Table");
	//$wherestring .= $this->genWhereString();

	$sql=$this->getSQLStr_AllClosing($wherestring,$orderbystring,$limit);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Closing No</th>
				<th style="text-align:center;">Closing Period</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Complete</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$closing_id=$row['closing_id'];
		$closing_no=$row['closing_no'];
		$period_id=$row['period_id'];
		$period_name=$row['period_name'];
		$isactive=$row['isactive'];
		$iscomplete=$row['iscomplete'];
		
		if($isactive==0)
		{$isactive='N';
		$isactive="<b style='color:red;'>$isactive</b>";
		}
		else
		$isactive='Y';

		if($iscomplete==0)
		{$iscomplete='N';
		$iscomplete="<b style='color:red;'>$iscomplete</b>";
		}
		else
		$iscomplete='Y';

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$closing_no</td>
			<td class="$rowtype" style="text-align:center;">$period_name</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$iscomplete</td>
			<td class="$rowtype" style="text-align:center;">
EOF;
				if($iscomplete == "Y"){
echo <<< EOF
				<form action="closing.php" method="POST" onsubmit="return confirm('Enable this closing?')">
				<input type="submit" value="enable" title="Enable this closing">
				<input type="hidden" value="$closing_id" name="closing_id">
				<input type="hidden" name="action" value="enable">
				</form>
EOF;
				}else{
echo <<< EOF
				<form action="closing.php" method="POST">
				<input type="image" src="images/edit.gif" name="btnEdit" title='Edit this closing'>
				<input type="hidden" value="$closing_id" name="closing_id">
				<input type="hidden" name="action" value="edit">
				</form>
EOF;
				}
echo <<< EOF
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
  public function getLatestClosingID() {
	$sql="SELECT MAX(closing_id) as closing_id from $this->tableclosing;";
	$this->log->showLog(3,'Checking latest created closing_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created closing_id:' . $row['closing_id']);
		return $row['closing_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tableclosing;";
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

 public function allowDelete($closing_id){
	/*
	$sql="SELECT count(bpartner_id) as rowcount from $this->tablebpartner where bpartner_closing_id=$closing_id";
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
		}*/
	return true;
	}

  public function enableClosing(){
	
	$sql = "update $this->tableclosing set iscomplete = 0 where closing_id = $this->closing_id ";

	$this->log->showLog(4,"Before insert closing SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to enable closing code $closing_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"enable closing $closing_name successfully"); 
		return true;
	}
  }

  public function showSearchForm(){
$addnewctrl="<a href='closing.php'>[ Add New ]</a>";
	echo <<< EOF
<table>
<tbody>
<tr>
<td>$addnewctrl</td>
</tr>
<tr>

</tr>
</table>

<form method='POST' action="closing.php">
<table border='1'>
  <tbody>
    <tr>
      <th colspan="4">Search Closing</th>
    </tr>
    <!--<tr>
      <td class='head'>Date From (YYYY-MM-DD)</td>
      <td class='odd'><input id='closingdatefrom' name='closingdatefrom' value="$this->closingdatefrom">
		<input type='button' onclick="$this->showcalendarfrom" value='Date'></td>
      <td class='head'>Date To (YYYY-MM-DD)</td>
      <td class='odd'><input id='closingdateto' name='closingdateto' value="$this->closingdateto">
		<input type='button' onclick="$this->showcalendarto" value='Date'></td>
    </tr>-->

    <tr>
    <td class="head">Closing Period</td>
    <td class="odd" colspan="3">$this->periodctrl</td>
    </tr>
   
    <tr>
      <td class='head'>Closing No (100%, %10,%1001%)</td>
      <td class='even'><input name='closing_no' value='$this->closing_no'></td>
      <td class='head'>Complete</td>
      <td class='even' acolspan="3">
	<select name="iscomplete">
	<option value=""></option>
	<option value="1">Yes</option>
	<option value="0">No</option>
	</select>
      </td>
    </tr>


    <tr>
      <td><input type='reset' name='reset' value='Reset'></td>
      <td colspan="3"><input type='submit' name='btnSearch' value='Search'><input type='hidden' name='action' value='showsearchform'></td>
    </tr>
	

  </tbody>
</table>
</form>

EOF;
  }


    public function genWhereString($datefrom,$dateto,$closing_no,$iscomplete,$period_id){

	/*
	if($datefrom=="")
		$datefrom="0000-00-00";
	if($dateto=="")
		$dateto="9999-12-31";
	*/
	//echo $closing_no;
	
	if($datefrom != "" || $datefrom != ""){
	
	$wherestring=" and b.period_year between '$datefrom' and '$dateto'";
	}

	if($closing_no<>"")
		$wherestring=$wherestring. " and closing_no LIKE '$closing_no' ";

	if($iscomplete !="")
		$wherestring=$wherestring. " and iscomplete = $iscomplete ";

	if($period_id > 0)
		$wherestring=$wherestring. " and a.period_id = $period_id ";
	
	
	//$wherestring=substr_replace($wherestring,"",-3);
	$this->log->showLog(3,"generate wherestring: $wherestring");
	return $wherestring;

  }

  


} // end of ClassClosing
?>

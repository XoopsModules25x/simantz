<?php


class Reminder
{

  public $reminder_id;
  public $reminder_title;
  public $reminder_body;
  public $reminder_footer;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $organization_id;
  public $isactive;
  public $defaultlevel;
  private $xoopsDB;
  private $tableprefix;
  private $tablereminder;
  private $tablebpartner;

  private $log;


//constructor
   public function Reminder(){
	global $xoopsDB,$log,$tablereminder,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablereminder="sim_simedu_reminder";
	$this->tablebpartner=$tablebpartner;	
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type
   * @param int reminder_id
   * @return
   * @access public
   */
  public function getInputForm( $type,  $reminder_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";

	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Reminder";
		$action="create";

		if($reminder_id==0){
			$this->reminder_title="";
			$this->isactive="";
			$this->defaultlevel=10;
			$this->reminder_id = getNewCode($this->xoopsDB,"reminder_id",$this->tablereminder,"");

		}
		$savectrl="<input astyle='height: 40px;' name='submit' value='Save' type='submit'>";
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
		$savectrl="<input name='reminder_id' value='$this->reminder_id' type='hidden'>".
			 "<input astyle='height: 40px;' name='submit' value='Save' type='submit'>";



		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablereminder' type='hidden'>".
		"<input name='id' value='$this->reminder_id' type='hidden'>".
		"<input name='idname' value='reminder_id' type='hidden'>".
		"<input name='title' value='Reminder' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";


		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";


		$header="Edit Reminder";

		if($this->allowDelete($this->reminder_id))
		$deletectrl="<FORM action='reminder.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this reminder?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->reminder_id' name='reminder_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='reminder.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF


<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateReminder()" method="post"
 action="reminder.php" name="frmReminder"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" colspan="3">$this->orgctrl&nbsp;Active <input type="checkbox" $checked name="isactive"></td>
			<td class="head" style="display:none">Default Level $mandatorysign</td>
	        <td class="even"  style="display:none"><input maxlength="3" size="3" name='defaultlevel' value='$this->defaultlevel'>

      </tr>
      <tr>
	<td class="head">Reminder Title $mandatorysign</td>
        <td class="even" ><textarea name="reminder_title" cols="80" rows="2">$this->reminder_title</textarea></td>
      </tr>
      <tr>
        <td class="head">Reminder Description</td>
        <td class="even" colspan='3'><textarea name="reminder_body" cols="80" rows="4">$this->reminder_body</textarea></td>
      </tr>
      <tr>
        <td class="head">Reminder Footer</td>
        <td class="even" colspan='3'><textarea name="reminder_footer" cols="80" rows="2">$this->reminder_footer</textarea></td>
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
   * Update existing semester record
   *
   * @return bool
   * @access public
   */
  public function updateReminder( ) {


 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablereminder SET
	reminder_title='$this->reminder_title',reminder_body='$this->reminder_body',
        reminder_footer = '$this->reminder_footer',
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',defaultlevel=$this->defaultlevel,
	organization_id=$this->organization_id WHERE reminder_id='$this->reminder_id'";
	$this->changesql = $sql;
	$this->log->showLog(3, "Update reminder_id: $this->reminder_id, $this->reminder_title");
	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update Reminder failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update Reminder successfully.");
		return true;
	}
  } // end of member function updateReminder

  /**
   * Save new semester into database
   *
   * @return bool
   * @access public
   */
  public function insertReminder( ) {


   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new reminder $this->reminder_title");
 	$sql="INSERT INTO $this->tablereminder (reminder_title,reminder_body,reminder_footer,
        isactive,created,createdby,updated,updatedby,defaultlevel,organization_id) values(
	'$this->reminder_title','$this->reminder_body','$this->reminder_footer','$this->isactive','$timestamp',$this->createdby,
        '$timestamp','$this->updatedby',$this->defaultlevel,$this->organization_id)";
//$this->changesql = $sql;

	$this->log->showLog(4,"Before insert reminder SQL:$sql");
	$rs=$this->xoopsDB->query($sql);

	if (!$rs){
		$this->log->showLog(1,"Failed to insert reminder $reminder_title:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new reminder $reminder_title successfully");
		return true;
	}
  } // end of member function insertReminder

  /**
   * Pull data from semester table into class
   *
   * @return bool
   * @access public
   */
  public function fetchReminder( $reminder_id) {


	$this->log->showLog(3,"Fetching reminder detail into class Reminder.php.<br>");

	$sql="SELECT reminder_id,reminder_title,reminder_body,reminder_footer,isactive,defaultlevel,organization_id
		 from $this->tablereminder where reminder_id=$reminder_id";

	$this->log->showLog(4,"ProductReminder->fetchReminder, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->reminder_title=$row["reminder_title"];
		$this->reminder_body=$row["reminder_body"];
		$this->reminder_footer=$row['reminder_footer'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->isactive=$row['isactive'];
		$this->organization_id=$row['organization_id'];
   	$this->log->showLog(4,"Reminder->fetchReminder,database fetch into class successfully");
	$this->log->showLog(4,"reminder_title:$this->reminder_title");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Reminder->fetchReminder,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchSemester

  /**
   * Delete particular semester id
   *
   * @param int semester_id
   * @return bool
   * @access public
   */
  public function deleteReminder( $reminder_id ) {
    	$this->log->showLog(2,"Warning: Performing delete reminder id : $reminder_id !");
	$sql="DELETE FROM $this->tablereminder where reminder_id=$reminder_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->changesql = $sql;
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: reminder ($reminder_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"reminder ($reminder_id) removed from database successfully!");
		return true;

	}
  } // end of member function deleteReminder

  /**
   * Return select sql statement.
   *
   * @param string wherestring
   * @param string orderbystring
   * @param int startlimitno
   * @return string
   * @access public
   */
  public function getSQLStr_AllReminder( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductReminder->getSQLStr_AllReminder: $sql");

    $sql="SELECT reminder_id,reminder_title,reminder_body,reminder_footer,organization_id,isactive,defaultlevel FROM $this->tablereminder " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showremindertable with sql:$sql");

  return $sql;
  } // end of member function getSQLStr_AllReminder

 public function showReminderTable($wherestring,$orderbystring){

	$this->log->showLog(3,"Showing Reminder Table");
	$sql=$this->getSQLStr_AllReminder($wherestring,$orderbystring);

	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='0' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Reminder Title</th>
				<th style="text-align:center;">Reminder Description</th>
                                <th style="text-align:center;">Reminder Footer</th>
                                <th style="text-align:center;">Isactive</th>
				<th style="text-align:center;display:none">Default Level</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$reminder_id=$row['reminder_id'];
		$reminder_title=$row['reminder_title'];
		$reminder_body=$row['reminder_body'];
                $reminder_footer=$row['reminder_footer'];
		$defaultlevel=$row['defaultlevel'];
                $organization_id = $row['organization_id'];
		$isactive=$row['isactive'];

		if($isactive==0)
		{$isactive='N';
		$isactive="<b style='color:red;'>N</b>";
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
                        <td class="$rowtype" style="text-align:center;">$reminder_title</td>
			<td class="$rowtype" style="text-align:center;">$reminder_body</td>
                        <td class="$rowtype" style="text-align:center;">$reminder_footer</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;display:none">$defaultlevel</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="reminder.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this reminder'>
				<input type="hidden" value="$reminder_id" name="reminder_id">
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
  public function getLatestReminderID() {
	echo $sql="SELECT MAX(reminder_id) as reminder_id from $this->tablereminder;";
	$this->log->showLog(3,'Checking latest created reminder_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created reminder_id:' . $row['reminder_id']);
		return $row['reminder_id'];
	}
	else
	return -1;

  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablereminder;";
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

 public function allowDelete($reminder_id){

	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where reminder_id = $reminder_id or last_reminder = $reminder_id or next_reminder = $reminder_id ";
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$rowcount = $row['rowcount'];
	}

	if($rowcount > 0)
	return false;
	else
	return true;
//	return $checkistrue;
	}


} // end of ClassReminder
?>

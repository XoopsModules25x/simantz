<?php


/**
 * class ProductRoom
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class Room
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $room_id;
  public $room_name;
  public $room_description;

  /**
   * if isactive="N", product master no longer can choose this room. Print
   * reports by room won't list this item as well. If this room use by
   * productmaster, you can disable this record, but cannot delete this record.
   * @access public
   */
  public $isactive;
  public $organization_id;
  public $created;
  public $createdby;
  public $updated;
  public $orgctrl;
  public $updatedby;
  private $xoopsDB;
  public $cur_name;
  public $cur_symbol;
  private $tableprefix;
  private $tableorganization;
  private $tableroom;
  private $tablestudent;
  private $log;


//constructor
   public function Room($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tabletuitionclass=$tableprefix."simtrain_tuitionclass";
	$this->tablestudent=$tableprefix . "simtrain_student";
	$this->tableroom=$tableprefix."simtrain_room";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int room_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $room_id,$token  ) {
	
	$mandatorysign="<b style='color:red'>*</b>";
    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Room";
		$action="create";
	 	
		if($room_id==0){
			$this->room_name="";
			$this->room_description="";
			$this->isactive="";
			$this->organization_id;
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

		switch($this->isitem){
			case "Y":
				$selectStock="SELECTED='SELECTED'";
				$selectClass="";
				$selectCharge="";
			break;
			case "N":
				$selectClass="";
				$selectStock="";
				$selectCharge="SELECTED='SELECTED'";
			break;
			default:
				$selectCharge="";
				$selectStock="";
				$selectClass="SELECTED='SELECTED'";

			break;
		}
		$itemselect="<SELECT name='isitem'><OPTION value='Y' $selectStock>Control Stock</OPTION>".
				"<option value='N' $selectCharge>Charge</option><option value='C' ".
				" $selectClass>Class</option></SELECT>";
	}
	else
	{
		
		$action="update";
		$savectrl="<input name='room_id' value='$this->room_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableroom' type='hidden'>".
		"<input name='id' value='$this->room_id' type='hidden'>".
		"<input name='idname' value='room_id' type='hidden'>".
		"<input name='title' value='Room' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

	
		$header="Edit Room";
		
		if($this->allowDelete($this->room_id) && $this->room_id>0)
		$deletectrl="<FORM action='room.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this room?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->room_id' name='room_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='room.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Class Room Master</span></big></big></big></div><br>-->

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateRoom()" method="post"
 action="room.php" name="frmRoom"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="3" rowspan="1">$header</th>
      </tr>
        <tr>
        <td class="head">Organization</td>
        <td class="odd" colspan="2">$this->orgctrl</td>
      </tr>
      <tr>
        <td class="head">Room Name $mandatorysign</td>
        <td class="even" colspan="2"><input maxlength="10" size="10"
 name="room_name" value="$this->room_name"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Room Description</td>
        <td class="odd" colspan="2"><input maxlength="40" size="40"
 name="room_description" value="$this->room_description"></td>
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
   * Update existing room record
   *
   * @return bool
   * @access public
   */
  public function updateRoom( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableroom SET ".
	"room_description='$this->room_description',room_name='$this->room_name',".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id ".
	"WHERE room_id='$this->room_id'";
	
	$this->log->showLog(3, "Update room_id: $this->room_id, $this->room_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update room failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update room successfully.");
		return true;
	}
  } // end of member function updateRoom

  /**
   * Save new room into database
   *
   * @return bool
   * @access public
   */
  public function insertRoom( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new room $this->room_name");
 	$sql="INSERT INTO $this->tableroom (room_description,room_name".
	",isactive, created,createdby,updated,updatedby,organization_id) values(".
	"'$this->room_description','$this->room_name','$this->isactive','$timestamp',$this->createdby,'$timestamp',".
	"$this->updatedby,$this->organization_id)";
	$this->log->showLog(4,"Before insert room SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert room code $room_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new room $room_name successfully"); 
		return true;
	}
  } // end of member function insertRoom

  /**
   * Pull data from room table into class
   *
   * @return bool
   * @access public
   */
  public function fetchRoom( $room_id) {
    
	$this->log->showLog(3,"Fetching room detail into class Room.php.<br>");
		
	$sql="SELECT room_id,room_name,room_description,isactive,organization_id from $this->tableroom ". 
			"where room_id=$room_id";
	
	$this->log->showLog(4,"ProductRoom->fetchRoom, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->organization_id=$row["organization_id"];
		$this->room_name=$row["room_name"];
		$this->room_description= $row['room_description'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"Room->fetchRoom,database fetch into class successfully");
	$this->log->showLog(4,"organization_id:$this->organization_id");
	$this->log->showLog(4,"room_name:$this->room_name");
	$this->log->showLog(4,"room_description:$this->room_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Room->fetchRoom,failed to fetch data into databases.");	
	}
  } // end of member function fetchRoom

  /**
   * Delete particular room id
   *
   * @param int room_id 
   * @return bool
   * @access public
   */
  public function deleteRoom( $room_id ) {
    	$this->log->showLog(2,"Warning: Performing delete room id : $room_id !");
	$sql="DELETE FROM $this->tableroom where room_id=$room_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: room ($room_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"room ($room_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteRoom

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllRoom( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running ProductRoom->getSQLStr_AllRoom: $sql");
    $sql="SELECT r.room_name,r.room_description,r.room_id,r.isactive,r.organization_id,o.organization_code
	 FROM $this->tableroom r inner join $this->tableorganization o on r.organization_id=o.organization_id
	 $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showRoomTable with sql:$sql");

  return $sql;
  } // end of member function getSQLStr_AllRoom

 public function showRoomTable(){
	global $defaultorganization_id;
	$this->log->showLog(3,"Showing Room Table");
	$sql=$this->getSQLStr_AllRoom("WHERE room_id>0 and r.organization_id = $defaultorganization_id ","ORDER BY o.organization_code,r.room_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Room Name</th>
				<th style="text-align:center;">Room Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$room_id=$row['room_id'];
		$room_name=$row['room_name'];
		$room_description=$row['room_description'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];
		$organization_code=$row['organization_code'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$organization_code</td>

			<td class="$rowtype" style="text-align:center;">$room_name</td>
			<td class="$rowtype" style="text-align:center;">$room_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="room.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this room'>
				<input type="hidden" value="$room_id" name="room_id">
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
  public function getLatestRoomID() {
	$sql="SELECT MAX(room_id) as room_id from $this->tableroom;";
	$this->log->showLog(3,'Checking latest created room_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created room_id:' . $row['room_id']);
		return $row['room_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectRoom($id,$showNull='N',$ctrlname="room_id") {
	$this->log->showLog(4,"getSelectRoom with id= $id");
	$sql="SELECT room_id,room_name from $this->tableroom where (isactive='Y' or room_id=$id) and room_id>0 order by room_name ;";
	$selectctl="<SELECT name='$ctrlname' >";
	if ( $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"> Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$room_id=$row['room_id'];
		$room_name=$row['room_name'];
	
		if($id==$room_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$room_id' $selected>$room_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	$sql="SELECT count(room_id) as rowcount from $this->tabletuitionclass where room_id=$id";
	$this->log->showLog(3,"Accessing ProductRoom->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this room, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this room, record deletable");
		return true;
		}
	}
} // end of ClassRoom
?>

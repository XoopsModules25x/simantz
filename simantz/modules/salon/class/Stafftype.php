<?php
/************************************************************************
 Class Stafftype.php - Copyright kfhoo
**************************************************************************/

class Stafftype
{

  public $stafftype_id;
  public $stafftype_code;
  public $stafftype_description;
  public $remarks;
  public $isactive;
  public $organization_id;
  public $created;
  public $cur_name;
  public $cur_symbol;
  public $createdby;
  public $updated;
  public $isAdmin;
  public $orgctrl;
  public $updatedby;
  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $tablestafftype;
  private $tableproduct;
  private $tablecustomer;
  private $tableemployee;

  private $log;


//constructor
   public function Stafftype($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simsalon_organization";
	$this->tablestafftype=$tableprefix . "simsalon_stafftype";
	$this->tablecustomer=$tableprefix . "simsalon_customer";
	$this->tableemployee=$tableprefix . "simsalon_employee";

	$this->log=$log;
   }


  public function getInputForm( $type,  $stafftype_id,$token  ) {
	

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Employee Type";
		$action="create";
	 	
		if($stafftype_id==0){
			$this->stafftype_code="";
			$this->stafftype_description="";
			$this->remarks="";
			$this->isactive="";
			$this->organization_id;
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectService="";
		$selectProduct="";

		$this->stafftype_code = getNewCode($this->xoopsDB,"stafftype_code",$this->tablestafftype);

		
	}
	else
	{
		$selectStock="";
		$selectService="";
		$selectProduct="";

		
		$action="update";
		$savectrl="<input name='stafftype_id' value='$this->stafftype_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablestafftype' type='hidden'>".
		"<input name='id' value='$this->stafftype_id' type='hidden'>".
		"<input name='idname' value='stafftype_id' type='hidden'>".
		"<input name='title' value='Stafftype' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		//if ($this->isitem=='Y')
		//	$itemchecked="CHECKED";
		//else
		//	$itemchecked="";
		$header="Edit Employee Type";
		
		if($this->allowDelete($this->stafftype_id) && $this->stafftype_id>0)
		$deletectrl="<FORM action='stafftype.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this stafftype?"'.")'><input type='submit' value='Delete' name='submit' style='height: 40px;'>".
		"<input type='hidden' value='$this->stafftype_id' name='stafftype_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='stafftype.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}
	

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;"> Employee Type</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateStafftype()" method="post"
 action="stafftype.php" name="frmStafftype"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="3" rowspan="1">$header</th>
      </tr>
        <tr style="display:none">
        <td class="head">Organization</td>
        <td class="odd" colspan="2">$this->orgctrl</td>
      </tr>
      <tr>
        <td class="head">Employee Type Code</td>
        <td class="even" colspan="2"><input maxlength="10" size="10"
 name="stafftype_code" value="$this->stafftype_code"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Employee Type Description</td>
        <td class="odd" colspan="2"><input maxlength="40" size="40"
 name="stafftype_description" value="$this->stafftype_description"></td>
      </tr>

	<tr>
		<td class="head">Remarks</td>
		<td class="even" colspan="2"><textarea name="remarks" cols="80" rows="1">$this->remarks</textarea></td>
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


  public function updateStafftype( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablestafftype SET
	stafftype_description='$this->stafftype_description',remarks='$this->remarks',
	stafftype_code='$this->stafftype_code',
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id
	WHERE stafftype_id='$this->stafftype_id'";
	
	$this->log->showLog(3, "Update stafftype_id: $this->stafftype_id, $this->stafftype_code");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update stafftype failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update stafftype successfully.");
		return true;
	}
  } // end of member function updateStafftype


  public function insertStafftype( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new stafftype $this->stafftype_code");
 	$sql="INSERT INTO $this->tablestafftype (stafftype_description,remarks,stafftype_code
	,isactive, created,createdby,updated,updatedby,organization_id) values(
	'$this->stafftype_description','$this->remarks','$this->stafftype_code','$this->isactive',
	'$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->organization_id)";
	$this->log->showLog(4,"Before insert stafftype SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert stafftype code $stafftype_code");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new stafftype $stafftype_code successfully"); 
		return true;
	}
  } // end of member function insertStafftype


  public function fetchStafftype( $stafftype_id) {
    
	$this->log->showLog(3,"Fetching stafftype detail into class Stafftype.php.<br>");
		
	$sql="SELECT * from $this->tablestafftype ". 
			"where stafftype_id=$stafftype_id";
	
	$this->log->showLog(4,"Stafftype->fetchStafftype, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->organization_id=$row["organization_id"];
		$this->stafftype_code=$row["stafftype_code"];
		$this->stafftype_description= $row['stafftype_description'];
		$this->remarks= $row['remarks'];
		$this->isactive=$row['isactive'];
		
   	$this->log->showLog(4,"Stafftype->fetchStafftype,database fetch into class successfully");
	$this->log->showLog(4,"organization_id:$this->organization_id");
	$this->log->showLog(4,"stafftype_code:$this->stafftype_code");
	$this->log->showLog(4,"stafftype_description:$this->stafftype_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Stafftype->fetchStafftype,failed to fetch data into databases.");	
	}
  } // end of member function fetchStafftype


  public function deleteStafftype( $stafftype_id ) {
    	$this->log->showLog(2,"Warning: Performing delete stafftype id : $stafftype_id !");
	$sql="DELETE FROM $this->tablestafftype where stafftype_id=$stafftype_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: stafftype ($stafftype_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"stafftype ($stafftype_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteStafftype


  public function getSQLStr_AllStafftype( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running Stafftype->getSQLStr_AllStafftype: $sql");
    $sql="SELECT * FROM $this->tablestafftype " .
	" $wherestring $orderbystring";
  return $sql;
  } // end of member function getSQLStr_AllStafftype

 public function showStafftypeTable(){
	
	$this->log->showLog(3,"Showing Stafftype Table");
	$sql=$this->getSQLStr_AllStafftype("where stafftype_id>0","ORDER BY stafftype_code",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Employee Type Code</th>
				<th style="text-align:center;">Employee Type Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$stafftype_id=$row['stafftype_id'];
		$stafftype_code=$row['stafftype_code'];
		$stafftype_description=$row['stafftype_description'];
		$remarks=$row['remarks'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$stafftype_code</td>
			<td class="$rowtype" style="text-align:center;">$stafftype_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="stafftype.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this stafftype'>
				<input type="hidden" value="$stafftype_id" name="stafftype_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }


  public function getLatestStafftypeID() {
	$sql="SELECT MAX(stafftype_id) as stafftype_id from $this->tablestafftype;";
	$this->log->showLog(3,'Checking latest created stafftype_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created stafftype_id:' . $row['stafftype_id']);
		return $row['stafftype_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectStafftype($id,$fld='stafftype_id') {
	
	$sql="SELECT stafftype_id,stafftype_description from $this->tablestafftype where (isactive='Y' or stafftype_id=$id )  order by stafftype_description ;";
	$selectctl="<SELECT name=$fld >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$stafftype_id=$row['stafftype_id'];
		$stafftype_description=$row['stafftype_description'];
	
		if($id==$stafftype_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$stafftype_id' $selected>$stafftype_description</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	$sql="SELECT count(stafftype_id) as rowcount from $this->tableemployee where stafftype_id=$id";
	$this->log->showLog(3,"Accessing Stafftype->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this stafftype, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this stafftype, record deletable");
		return true;
		}
	}
} // end of ClassStafftype
?>

<?php
/************************************************************************
 Class Leave.php - Copyright kfhoo
**************************************************************************/

class Leave
{

  public $leave_id;
  public $leave_code;
  public $leave_description;
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
  private $tableleave;
  private $tableproduct;
  private $tablecustomer;
  private $tableproductlist;
  private $tableexpenseslist;

  private $log;


//constructor
   public function Leave($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simsalon_organization";
	$this->tableleave=$tableprefix . "simsalon_leave";
	$this->tablecustomer=$tableprefix . "simsalon_customer";
	$this->tableproductlist=$tableprefix . "simsalon_productlist";
	$this->tableexpenseslist=$tableprefix . "simsalon_expenseslist";

	$this->log=$log;
   }


  public function getInputForm( $type,  $leave_id,$token  ) {
	

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Leave";
		$action="create";
	 	
		if($leave_id==0){
			$this->leave_code="";
			$this->leave_description="";
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

		$this->leave_code = getNewCode($this->xoopsDB,"leave_code",$this->tableleave);

	}
	else
	{
		$selectStock="";
		$selectService="";
		$selectProduct="";

		
		$action="update";
		$savectrl="<input name='leave_id' value='$this->leave_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableleave' type='hidden'>".
		"<input name='id' value='$this->leave_id' type='hidden'>".
		"<input name='idname' value='leave_id' type='hidden'>".
		"<input name='title' value='Leave' type='hidden'>".
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
		$header="Edit Product Leave";
		
		if($this->allowDelete($this->leave_id) && $this->leave_id>0)
		$deletectrl="<FORM action='leave.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this leave?"'.")'><input type='submit' value='Delete' name='submit' style='height: 40px;'>".
		"<input type='hidden' value='$this->leave_id' name='leave_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='leave.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Leave</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateLeave()" method="post"
 action="leave.php" name="frmLeave"><input name="reset" value="Reset" type="reset"></td></tbody></table>

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
        <td class="head">Leave Code</td>
        <td class="even" colspan="2"><input maxlength="10" size="10"
 name="leave_code" value="$this->leave_code"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Leave Description</td>
        <td class="odd" colspan="2"><input maxlength="40" size="40"
 name="leave_description" value="$this->leave_description"></td>
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


  public function updateLeave( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableleave SET
	leave_description='$this->leave_description',remarks='$this->remarks',
	leave_code='$this->leave_code',
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id
	WHERE leave_id='$this->leave_id'";
	
	$this->log->showLog(3, "Update leave_id: $this->leave_id, $this->leave_code");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update leave failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update leave successfully.");
		return true;
	}
  } // end of member function updateLeave


  public function insertLeave( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new leave $this->leave_code");
 	$sql="INSERT INTO $this->tableleave (leave_description,remarks,leave_code
	,isactive, created,createdby,updated,updatedby,organization_id) values(
	'$this->leave_description','$this->remarks','$this->leave_code','$this->isactive',
	'$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->organization_id)";
	$this->log->showLog(4,"Before insert leave SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert leave code $leave_code");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new leave $leave_code successfully"); 
		return true;
	}
  } // end of member function insertLeave


  public function fetchLeave( $leave_id) {
    
	$this->log->showLog(3,"Fetching leave detail into class Leave.php.<br>");
		
	$sql="SELECT * from $this->tableleave ". 
			"where leave_id=$leave_id";
	
	$this->log->showLog(4,"Leave->fetchLeave, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->organization_id=$row["organization_id"];
		$this->leave_code=$row["leave_code"];
		$this->leave_description= $row['leave_description'];
		$this->remarks= $row['remarks'];
		$this->isactive=$row['isactive'];
		
   	$this->log->showLog(4,"Leave->fetchLeave,database fetch into class successfully");
	$this->log->showLog(4,"organization_id:$this->organization_id");
	$this->log->showLog(4,"leave_code:$this->leave_code");
	$this->log->showLog(4,"leave_description:$this->leave_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Leave->fetchLeave,failed to fetch data into databases.");	
	}
  } // end of member function fetchLeave


  public function deleteLeave( $leave_id ) {
    	$this->log->showLog(2,"Warning: Performing delete leave id : $leave_id !");
	$sql="DELETE FROM $this->tableleave where leave_id=$leave_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: leave ($leave_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"leave ($leave_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteLeave


  public function getSQLStr_AllLeave( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running Leave->getSQLStr_AllLeave: $sql");
    $sql="SELECT * FROM $this->tableleave " .
	" $wherestring $orderbystring";
  return $sql;
  } // end of member function getSQLStr_AllLeave

 public function showLeaveTable(){
	
	$this->log->showLog(3,"Showing Leave Table");
	$sql=$this->getSQLStr_AllLeave("where leave_id>0","ORDER BY leave_code",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Leave Code</th>
				<th style="text-align:center;">Leave Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$leave_id=$row['leave_id'];
		$leave_code=$row['leave_code'];
		$leave_description=$row['leave_description'];
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
			<td class="$rowtype" style="text-align:center;">$leave_code</td>
			<td class="$rowtype" style="text-align:center;">$leave_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="leave.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this leave'>
				<input type="hidden" value="$leave_id" name="leave_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }


  public function getLatestLeaveID() {
	$sql="SELECT MAX(leave_id) as leave_id from $this->tableleave;";
	$this->log->showLog(3,'Checking latest created leave_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created leave_id:' . $row['leave_id']);
		return $row['leave_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectLeave($id,$fld='leave_id') {
	
	$sql="SELECT leave_id,leave_description from $this->tableleave where (isactive='Y' or leave_id=$id )  order by leave_description ;";
	$selectctl="<SELECT name=$fld >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$leave_id=$row['leave_id'];
		$leave_description=$row['leave_description'];
	
		if($id==$leave_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$leave_id' $selected>$leave_description</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	
	return true;

	/*
	$val = true;
	$tablelink = array($this->table);
	
	$count = count($tablelink);
	$i = 0;
	while($i<$count){
	

	$sql = "SELECT count(*) as rowcount from $tablelink[$i] where leave_id = $id ";
	$this->log->showLog(4,"SQL:$sql");

	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query))	
		if($row['rowcount']>0){
		$i = $count;
		$this->log->showLog(3,"record found, record not deletable");
		$val = false;
		}

	$i++;
	}


	return $val;

	
	$sql="SELECT count(leave) as rowcount from $this->tablecustomer where leave=$id";
	$this->log->showLog(3,"Accessing Leave->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this leave, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this leave, record deletable");
		return true;
		}*/
	}
	
} // end of ClassLeave
?>

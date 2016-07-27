<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class Access
{

public	$groupid;


public	$groupctrl;


public	$created;
public	$createdby;
public	$updated;
public	$updatedby;
public	$isactive;



public $branchgroupline_id;
public $branch_id;
public $isaccessbranch;
public $deptgroupline_id;
public $dept_id;
public $isaccessdept;
public $windowsgroupline_id;
public $windows_id;
public $isaccesswindows;
public $windows_no;
public $allowadd;
public $allowedit;
public $access_grouptype;

public  $xoopsDB;
public  $tableprefix;
public  $tablegroups;
public  $tablebranchgroup;
public  $tablebranch;
public  $tabledeptgroup;
public  $tabledept;
public  $tablewindowsgroup;
public  $tablewindows;
public  $log;



//constructor
   public function Access($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablegroups=$tableprefix."groups";
	$this->tablebranchgroup=$tableprefix."tblbranchgroup";
	$this->tablebranch=$tableprefix."tblbranch";
	$this->tabledeptgroup=$tableprefix."tbldeptgroup";
	$this->tabledept=$tableprefix."tbldept";
	$this->tablewindowsgroup=$tableprefix."simsalon_tblwindowsgroup";
	$this->tablewindows=$tableprefix."simsalon_tblwindows";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int access_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $access_id, $token  ) {

   $header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	

		$selected_n = ''; 
		$selected_s = '';
		$selected_t = '';
 

 		
		
	$this->created=0;
	if ($type=="new"){
		$header="New Access  Control";
		$action="create";
	 	
		//$savectrl="<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";
		$checked="CHECKED";
		$defaultchecked="";
		$deletectrl="";


	}
	else
	{
		
		$action="update";
		/*$savectrl="<input name='groupid' value='$this->groupid' type='hidden'>".
			 "<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";*/
		
		$savectrl="<input style='height: 40px;' name='btnSave' value='Save' type='button' onclick='return saveGroup();'>";

		

		if($this->isAdmin)
		$recordctrl="";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='1')
			$checked="CHECKED";
		else
			$checked="";
		if ($this->isdefault=='1')
			$defaultchecked="CHECKED";
		else
			$defaultchecked="";
	
		$header="Edit Access Control";
		
		if($this->allowDelete($this->access_id))
		$deletectrl="<FORM action='access.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this access?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->access_id' name='access_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else

		$deletectrl="";
	
	}


	
echo <<< EOF


	<table style="width:140px;"><td><form aonsubmit="return validateAccess()" method="post"
	action="access.php" name="frmAccess"></td></table>
	
	<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	<tbody>
	<tr>
		<th colspan="4" rowspan="1">$header</th>
	</tr>
	<tr>
		<td class="head" width="30%">User Group</td>
		<td class="odd" colspan="3">$this->groupctrl </td>
	</tr>
	
	</tbody>
	</table>
	

EOF;
	

	if($this->groupid!=0)
	$this->showChildGroupTable();

echo <<< EOF
	
	<table style="width:150px;"><tbody><td>$savectrl 
		<input name="action" value="$action" type="hidden">
		<input name="token" value="$token" type="hidden"></td>
		</tbody></form></table>

EOF;

  } // end of member function getInputForm



	public function showChildGroupTable(){
	
	//Group type
	$sql = "SELECT * FROM $this->tablegroups a
		WHERE a.groupid = $this->groupid ";
	
	$this->log->showLog(4, "Before execute SQL statement:$sql");
		
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$accesstype = $row["accesstype"];
	}
	
	$selected1 = "";
	$selected2 = "";
	$selected3 = "";
	$selected4 = "";
	$selected5 = "";
	$selected6 = "";

	if($accesstype==1)
	$selected1 = "SELECTED";
	if($accesstype==2)
	$selected2 = "SELECTED";
	if($accesstype==3)
	$selected3 = "SELECTED";
	if($accesstype==4)
	$selected4 = "SELECTED";
	if($accesstype==5)
	$selected5 = "SELECTED";
	if($accesstype==6)
	$selected6 = "SELECTED";

echo <<< EOF
	
	<table style="text-align: left; width: 100%;display:none" border="1" cellpadding="0" cellspacing="3">
	<tbody>

	<tr>
		<td class="head" width="30%">Group Type</td>
		<td class="odd">
		<select name="access_grouptype">
		<option value=0 $selected6>Anonymous</option>
		<option value=1 $selected1>Admin</option>
		<option value=2 $selected2>Director</option>
		<option value=3 $selected3>Outlet</option>
		<option value=4 $selected4>Department</option>
		<option value=5 $selected5>Customer</option>
		</select>
		</td>
	</tr>
	
	</tbody>
	</table>
	
	<br>
	

EOF;
	
	// insert new record if have
	//$this->insertBranchGroup();
	//$this->insertDeptGroup();
	$this->insertWindowsGroup();
	
	//show table
//	$this->showChildBranchTable();
//	$this->showChildDeptTable();

	$this->showChildWindowsTable();
	

	}


	public function showChildBranchTable(){

	$sql = "SELECT * FROM $this->tablebranchgroup a, $this->tablebranch b
		WHERE a.branch_id = b.branch_id 
		AND a.groupid = $this->groupid 
		AND a.branch_id <> 0 ";
	
	$this->log->showLog(4, "Before execute SQL statement:$sql");
		
	$query=$this->xoopsDB->query($sql);
	
echo <<< EOF

<table border='1'>
<tbody>
			<tr>	
				<th style="text-align:left;" colspan="3">MASTER</th>
			</tr>
    			<tr>
				<th style="text-align:center;" width="5%" >No</th>
				<th style="text-align:center;" width="75%">Outlet Name</th>
				<th style="text-align:center;" width="9%">Access</th>
			</tr>


EOF;

	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$branch_name = $row['branch_name'];
	$isaccess  = $row['isaccess'];
	$branchgroupline_id  = $row['branchgroupline_id'];
	$branch_id  = $row['branch_id'];

	if($isaccess==1)
	$checked = "CHECKED";
	else
	$checked = "";

	// row style
	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

echo <<< EOF

	<tr>		<td style="display:none;"><input type="hidden" name="branchgroupline_id[]" value = "$branchgroupline_id">
			<input type="hidden" name="branch_id[]" value = "$branch_id"></td>
			<td class="$rowtype" style="text-align:center;" >$i</td>
			<td class="$rowtype" style="text-align:center;">$branch_name</td>
			<td class="$rowtype" style="text-align:center;"><input type='checkbox' $checked name='isaccessbranch[$i]'></td>

	</tr>
	

EOF;


	
	}

echo "</tbody></table><br>";
	
	}


	public function showChildDeptTable(){

	$sql = "SELECT * FROM $this->tabledeptgroup a, $this->tabledept b
		WHERE a.dept_id = b.dept_id 
		AND a.groupid = $this->groupid 
		AND a.dept_id <> 0";
	
	$this->log->showLog(4, "Before execute SQL statement:$sql");
		
	$query=$this->xoopsDB->query($sql);

echo <<< EOF

<table border='1'>
<tbody>
			<tr>	
				<th style="text-align:left;" colspan="3">TRANSACTION</th>
			</tr>
    			<tr>	
				<th style="text-align:center;" width="5%">No</th>
				<th style="text-align:center;" width="75%">Department Name</th>
				<th style="text-align:center;" width="9%">Access</th>
			</tr>


EOF;

	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$dept_name = $row['dept_name'];
	$isaccess  = $row['isaccess'];
	$deptgroupline_id  = $row['deptgroupline_id'];
	$dept_id  = $row['dept_id'];

	if($isaccess==1)
	$checked = "CHECKED";
	else
	$checked = "";

	// row style
	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

echo <<< EOF

	<tr>		
			<td style="display:none"><input type="hidden" name="deptgroupline_id[]" value = "$deptgroupline_id">
			<input type="hidden" name="dept_id[]" value = "$dept_id"></td>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$dept_name</td>
			<td class="$rowtype" style="text-align:center;"><input type='checkbox' $checked name='isaccessdept[$i]'></td>

	</tr>
	

EOF;


	
	}

echo "</tbody></table>";
	
	}


	public function showChildWindowsTable(){

	$sql = "SELECT * FROM $this->tablewindowsgroup a, $this->tablewindows b
		WHERE a.windows_id = b.windows_id 
		AND a.groupid = $this->groupid 
		order by b.windows_type,CAST(b.windows_no AS SIGNED) asc ";
	
	$this->log->showLog(4, "Before execute SQL statement:$sql");
		
	$query=$this->xoopsDB->query($sql);

echo <<< EOF


<table border='0'>
<tbody>

	<tr height="10">
	<td colspan="6" align="right"><b>
	<a onclick="selectAll(1)" style="cursor:pointer">[Deselect All]</a>&nbsp;<a onclick="selectAll(2)" style="cursor:pointer">[Select All]</a>
	</b></td>
	</tr>
EOF;
	$windows1 = "";
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	$windows_name = $row['windows_name'];
	$windows_no = $row['windows_no'];
	$windowsgroupline_id  = $row['windowsgroupline_id'];
	$windows_id  = $row['windows_id'];
	$isaccess  = $row['isaccess'];
	$allowadd  = $row['allowadd'];
	$allowedit  = $row['allowedit'];
	$windows2 = $row['windows_type'];

	if($isaccess==1)
	$checked = "CHECKED";
	else
	$checked = "";

	if($allowedit==1)
	$checked3 = "CHECKED";
	else
	$checked3 = "";

	if($allowadd==1)
	$checked2 = "CHECKED";
	else
	$checked2 = "";

	// row style
	if($rowtype=="odd")
		$rowtype="even";
	else
		$rowtype="odd";

	
	if($windows1 != $windows2){
	$windows1 = $windows2;
	$stylecheck = "";

	if($windows1==M)
	$windows_typename = "MASTER";
	else if($windows1==T)
	$windows_typename = "TRANSACTION";
	else{
	$windows_typename = "REPORT";
	$stylecheck = "style='display:none'";
	}
	
echo <<< EOF
		<tr height="15"><td colspan="6"></td></tr>
		<tr>	
			<th style="text-align:left;" colspan="2">$windows_typename</th>
			<th style="text-align:left;"></th>
			<th style="text-align:left;"></th>
			<th style="text-align:left;display:none"></th>
			<th style="text-align:left;display:none"></th>
		</tr>

		<tr>
			<th style="text-align:center;" width="5%">No</th>
			<th style="text-align:center;" width="5%">Sequence</th>
			<th style="text-align:center;" width="60%">Windows Name</th>
			<th style="text-align:center;" width="9%">Access</th>
			<th style="text-align:center;display:none" width="10%">Add</th>
			<th style="text-align:center;display:none" width="10%">Edit</th>
		</tr>
EOF;
	}

echo <<< EOF
	<tr>		
			<td style="display:none"><input type="hidden" name="windowsgroupline_id[]" value = "$windowsgroupline_id">
			<input type="hidden" name="windows_id[]" value = "$windows_id"></td>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;"><input name='windows_no[$i]' value="$windows_no" size="2" max="2"></td>
			<td class="$rowtype" style="text-align:center;">$windows_name</td>
			<td class="$rowtype" style="text-align:center;"><input type='checkbox' $checked name='isaccesswindows[$i]'></td>
			<td class="$rowtype" style="text-align:center;display:none"><input type='checkbox' $checked2 name='allowadd[$i]' $stylecheck></td>
			<td class="$rowtype" style="text-align:center;display:none"><input type='checkbox' $checked3 name='allowedit[$i]' $stylecheck></td>

	</tr>
	

EOF;


	
	}

echo "</tbody></table><br>";
	
	}

	public function insertBranchGroup(){

	$timestamp= date("y/m/d H:i:s", time()) ;
	
	$sql1 = "SELECT branch_id as branch_id
		FROM $this->tablebranchgroup WHERE groupid = $this->groupid ";

 	$sql = "SELECT branch_id as branch_id, isaccess as isaccess,branchgroupline_id as branchgroupline_id
		FROM $this->tablebranchgroup WHERE groupid = 1 UNION

		SELECT branch_id as branch_id, 0 as isaccess,'' as branchgroupline_id
		FROM $this->tablebranch
		WHERE branch_id NOT IN ($sql1)
		";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
		
	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query)){
	$branch_id = $row['branch_id'];
	$isaccess = $row['isaccess'];

		if($row['branchgroupline_id']==""){
		$sqlinsert = "INSERT INTO $this->tablebranchgroup (branch_id,groupid,isaccess,created,createdby) values ($branch_id,$this->groupid,$isaccess,'$timestamp',$this->updatedby) ";
		
		$this->log->showLog(4, "Before execute SQL statement:$sqlinsert");
		$rs=$this->xoopsDB->query($sqlinsert);
		
		if(!$rs){
			$this->log->showLog(2, "Warning! Update access failed");
			return false;
		}
		

		}
		
	}	

	}


	
	
	public function insertDeptGroup(){
	
	$timestamp= date("y/m/d H:i:s", time()) ;

	$sql1 = "SELECT dept_id as dept_id
		FROM $this->tabledeptgroup WHERE groupid = $this->groupid ";

 	$sql = "SELECT dept_id as dept_id, isaccess as isaccess,deptgroupline_id as deptgroupline_id
		FROM $this->tabledeptgroup WHERE groupid = 1 UNION

		SELECT dept_id as dept_id, 0 as isaccess,'' as deptgroupline_id
		FROM $this->tabledept
		WHERE dept_id NOT IN ($sql1)
		";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
		
	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query)){
	$dept_id = $row['dept_id'];
	$isaccess = $row['isaccess'];

		if($row['deptgroupline_id']==""){
		$sqlinsert = "INSERT INTO $this->tabledeptgroup (dept_id,groupid,isaccess,created,createdby) values ($dept_id,$this->groupid,$isaccess,'$timestamp',$this->updatedby) ";
		
		$this->log->showLog(4, "Before execute SQL statement:$sqlinsert");
		$rs=$this->xoopsDB->query($sqlinsert);
		
		if(!$rs){
			$this->log->showLog(2, "Warning! Update access failed");
			return false;
		}
		

		}
		
	}	

	}

	public function insertWindowsGroup(){
	
	$timestamp= date("y/m/d H:i:s", time()) ;

	$sql1 = "SELECT windows_id as windows_id
		FROM $this->tablewindowsgroup WHERE groupid = $this->groupid ";

 	$sql = "SELECT windows_id as windows_id, isaccess as isaccess,windowsgroupline_id as windowsgroupline_id
		FROM $this->tablewindowsgroup WHERE groupid = 1 UNION

		SELECT windows_id as windows_id, 0 as isaccess,'' as windowsgroupline_id
		FROM $this->tablewindows
		WHERE windows_id NOT IN ($sql1)
		";

	$this->log->showLog(4, "Before execute SQL statement:$sql");
		
	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query)){
	$windows_id = $row['windows_id'];
	$isaccess = $row['isaccess'];

		if($row['windowsgroupline_id']==""){
		$sqlinsert = "INSERT INTO $this->tablewindowsgroup (windows_id,groupid,isaccess,created,createdby) values ($windows_id,$this->groupid,$isaccess,'$timestamp',$this->updatedby) ";
		
		$this->log->showLog(4, "Before execute SQL statement:$sqlinsert");
		$rs=$this->xoopsDB->query($sqlinsert);
		
		if(!$rs){
			$this->log->showLog(2, "Warning! Update access failed");
			return false;
		}
		

		}
		
	}	

	}

	public function updateGroup(){
	$timestamp= date("y/m/d H:i:s", time()) ;
	

	/*
	//update group type
	
	$sqlinsert = "UPDATE $this->tablegroups SET accesstype = $this->access_grouptype
		      WHERE groupid = $this->groupid ";
	
	$this->log->showLog(4, "Before execute SQL statement:$sqlinsert");
		
	$rs=$this->xoopsDB->query($sqlinsert);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update access failed");
		return false;
	}

	
	//update branch
	$i = 0;
	foreach($this->branchgroupline_id as $id ){
	
	$branchgroupline_id = $this->branchgroupline_id[$i];
	$branch_id = $this->branch_id[$i];
	$isaccessbranch = $this->isaccessbranch[$i+1];
	
	if($isaccessbranch=="on")
	$isaccessbranch = 1;
	else
	$isaccessbranch = 0;

	$sqlinsert = "UPDATE $this->tablebranchgroup SET isaccess = $isaccessbranch, updated = '$timestamp', updatedby = $this->updatedby
		      WHERE branchgroupline_id = $branchgroupline_id ";

	$this->log->showLog(4, "Before execute SQL statement:$sqlinsert");
		
	$rs=$this->xoopsDB->query($sqlinsert);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update access failed");
		return false;
	}
	
	$i++;
	}


	//update department
	$i = 0;
	foreach($this->deptgroupline_id as $id ){
	
	$deptgroupline_id = $this->deptgroupline_id[$i];
	$dept_id = $this->dept_id[$i];
	$isaccessdept = $this->isaccessdept[$i+1];
	
	if($isaccessdept=="on")
	$isaccessdept = 1;
	else
	$isaccessdept = 0;

	$sqlinsert = "UPDATE $this->tabledeptgroup SET isaccess = $isaccessdept, updated = '$timestamp', updatedby = $this->updatedby
		      WHERE deptgroupline_id = $deptgroupline_id ";

	$this->log->showLog(4, "Before execute SQL statement:$sqlinsert");
		
	$rs=$this->xoopsDB->query($sqlinsert);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update access failed");
		return false;
	}
	
	$i++;
	}
	*/
	
	
	//update windows
	$i = 0;
	foreach($this->windowsgroupline_id as $id ){
	
	$windowsgroupline_id = $this->windowsgroupline_id[$i];
	$windows_id = $this->windows_id[$i];
	$isaccesswindows = $this->isaccesswindows[$i+1];
	$windows_no = $this->windows_no[$i+1];
	$allowadd = $this->allowadd[$i+1];
	$allowedit = $this->allowedit[$i+1];
	
	if($isaccesswindows=="on")
	$isaccesswindows = 1;
	else
	$isaccesswindows = 0;

	//allow add
	if($allowadd=="on")
	$allowadd = 1;
	else
	$allowadd = 0;

	//allow edit
	if($allowedit=="on")
	$allowedit = 1;
	else
	$allowedit = 0;

	$sqlinsert = 	"UPDATE $this->tablewindowsgroup SET isaccess = $isaccesswindows, 
			allowadd = $allowadd, allowedit = $allowedit, updated = '$timestamp', updatedby = $this->updatedby
		      	WHERE windowsgroupline_id = $windowsgroupline_id ";

	$sqlupdatewindows = "UPDATE $this->tablewindows SET windows_no = '$windows_no' where windows_id = $windows_id ";

	$this->log->showLog(4, "Before execute SQL statement:$sqlinsert");
		
	$rs=$this->xoopsDB->query($sqlinsert);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update access failed");
		return false;
	}else{
	$rs=$this->xoopsDB->query($sqlupdatewindows);
	}
	
	$i++;
	}
	
	return true;
	}
 
	public function updateAccess( ) {
		$timestamp= date("y/m/d H:i:s", time()) ;
		$sql="UPDATE $this->tableaccess SET
		access_no='$this->access_no',
		access_name='$this->access_name',
		updated='$timestamp',
		updatedby=$this->updatedby,
		isactive=$this->isactive
		WHERE access_id=$this->access_id";
		
		$this->log->showLog(3, "Update access_id: $this->access_id, $this->access_name");
		$this->log->showLog(4, "Before execute SQL statement:$sql");
		
		$rs=$this->xoopsDB->query($sql);
		if(!$rs){
			$this->log->showLog(2, "Warning! Update access failed");
			return false;
		}
		else{
			$this->log->showLog(3, "Update access successfully.");
			return true;
		}
	} // end of member function updateAccess


  public function insertAccess( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new access $this->access_name");
 	$sql="INSERT INTO $this->tableaccess 
 			(access_no,access_name,createdby,created,updatedby,updated,isactive) 
 			values 	('$this->access_no',
						'$this->access_name',
						 $this->createdby,
						'$timestamp',
						 $this->updatedby,
						'$timestamp',
						 $this->isactive)";
	$this->log->showLog(4,"Before insert access SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert access code $access_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new access $access_name successfully"); 
		return true;
	}
  } // end of member function insertAccess


  public function fetchAccess( $access_id) {
    
    //echo $access_id;
	$this->log->showLog(3,"Fetching access detail into class Access.php.<br>");
		
	$sql="SELECT access_id,access_no,access_name,created,createdby,updated, updatedby, isactive 
			from $this->tableaccess 
			where access_id=$access_id";
	
	$this->log->showLog(4,"ProductAccess->fetchAccess, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$this->access_no=$row['access_no'];
	$this->access_name=$row['access_name'];
	$this->isactive=$row['isactive'];
	
   	$this->log->showLog(4,"Access->fetchAccess,database fetch into class successfully");	
	$this->log->showLog(4,"access_name:$this->access_name");
	

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Access->fetchAccess,failed to fetch data into databases.");	
	}
  } // end of member function fetchAccess

  public function deleteAccess( $access_id ) {
    	$this->log->showLog(2,"Warning: Performing delete access id : $access_id !");
	$sql="DELETE FROM $this->tableaccess where access_id=$access_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: access ($access_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"access ($access_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteAccess

  
  public function getSQLStr_AllAccess( $wherestring,  $orderbystring,  $startlimitno,$recordcount ) {

/*
    $sql="SELECT c.access_id,c.access_no,c.access_name,c.street1,c.street2,".
		"c.postcode,c.city,c.state1,c.country,".
		"c.contactperson,c.contactperson_no,c.tel1,c.tel2,c.fax,c.description,".
		"c.created,c.createdby,c.updated, c.updatedby, c.isactive, c.isdefault,c.currency_id, ".
		"cr.currency_symbol FROM $this->tableaccess c " .
		"left join $this->tablecurrency cr on c.currency_id = cr.currency_id ".
	" $wherestring $orderbystring LIMIT $startlimitno,$recordcount";
	*/
	
	$sql = "SELECT c.access_id,c.access_no,c.access_name,c.created,c.createdby,c.updated, c.updatedby, c.isactive
				FROM $this->tableaccess c 
				$wherestring $orderbystring LIMIT $startlimitno,$recordcount ";
				
  $this->log->showLog(4,"Running ProductAccess->getSQLStr_AllAccess: $sql"); 
 return $sql;
  } // end of member function getSQLStr_AllAccess

 public function showAccessTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0){
	$this->log->showLog(3,"Showing Access Table");
 	$sql=$this->getSQLStr_AllAccess($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Access No</th>
				<th style="text-align:center;">Access Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$access_id=$row['access_id'];
		$access_no=$row['access_no'];
		$access_name=$row['access_name'];
		$isactive=$row['isactive'];
		
	
		// isactive 
		if($isactive=="1")
			$isactive = "Yes";
		else
			$isactive = "No";
	
		// row style
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$access_no</td>
			<td class="$rowtype" style="text-align:center;">$access_name</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="access.php" method="POST">
				<input type="image" src="../images/edit.gif" name="submit" title='Edit this access'>
				<input type="hidden" value="$access_id" name="access_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

  
  
  // start serach table
  
  public function showSearchTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0, $orderctrl="", $fldSort =""){
	$this->log->showLog(3,"Showing Access Control Table");
	
	$sql=$this->getSQLStr_AllAccess($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	
	if($orderctrl=='asc'){
	
	if($fldSort=='access_no')
	$sortimage1 = '../images/sortdown.gif';
	else
	$sortimage1 = '../images/sortup.gif';
	if($fldSort=='access_name')
	$sortimage2 = '../images/sortdown.gif';
	else
	$sortimage2 = '../images/sortup.gif';
	if($fldSort=='isactive')
	$sortimage4 = '../images/sortdown.gif';
	else
	$sortimage4 = '../images/sortup.gif';
	
	}else{
	$sortimage1 = '../images/sortup.gif';
	$sortimage2 = '../images/sortup.gif';
	$sortimage3 = '../images/sortup.gif';
	$sortimage4 = '../images/sortup.gif';
	}


	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Access Code <br><input type='image' src="$sortimage1" name='submit'  title='Sort this record' onclick = " headerSort('access_no');"></th>
				<th style="text-align:center;">Access Description <br><input type='image' src="$sortimage2" name='submit'  title='Sort this record' onclick = " headerSort('access_name');"></th>
				<th style="text-align:center;">Active <br><input type='image' src="$sortimage4" name='submit'  title='Sort this record' onclick = " headerSort('isactive');"></th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$access_id=$row['access_id'];
		$access_no=$row['access_no'];
		$access_name=$row['access_name'];

		$isactive=$row['isactive'];
		
	
	
		// isactive 
		if($isactive=="1")
			$isactive = "Yes";
		else
			$isactive = "No";
		
		// row style
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$access_no</td>
			<td class="$rowtype" style="text-align:center;">$access_name</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="access.php" method="POST">
				<input type="image" src="../images/edit.gif" name="submit" title='Edit this access'>
				<input type="hidden" value="$access_id" name="access_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	
		$printctrl="<tr><td colspan='11' align=right><form action='viewaccess.php' method='POST' target='_blank' name='frmPdf'>
					<input type='image' src='../images/reportbutton.jpg'>
					<input type='hidden' name='wherestr' value=\"$wherestring\">
					<input type='hidden' name='orderstr' value='$orderbystring'>
					</form></td></tr>";
					
	echo $printctrl;

	echo  "</tr></tbody></table>";
 }



   
   
 public function searchAToZ(){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search access easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(access_name,1)) as shortname FROM $this->tableaccess where isactive='1' order by access_name";
	$this->log->showLog(4,"With SQL:$sqlfilter");
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	$firstname="";
/*	
	echo "<b>Access Grouping By Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if access never do filter yet, if will choose 1st access listing
		
		echo "<A style='font-size:12;' href='access.php?filterstring=$shortname'>  $shortname  </A> ";
	}
	
	$this->log->showLog(3,"Complete generate list of short cut");


		echo <<<EOF
<BR>
<A href='access.php?action=new' style='color: GRAY'><img src="../images/addnew.jpg"</A>
<A href='access.php?action=showSearchForm' style='color: gray'><img src="../images/search.jpg"></A>

EOF;*/
return $filterstring;
  }
  
  
  
  


  public function getLatestAccessID() {
	$sql="SELECT MAX(access_id) as access_id from $this->tableaccess;";
	$this->log->showLog(3,'Checking latest created access_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created access_id:' . $row['access_id']);
		return $row['access_id'];
	}
	else
	return -1;
	
  } // end
  
  



	public function getNewAccess() {
			
		$sql="SELECT CAST(access_no AS SIGNED) as access_no, access_no as ori_data from $this->tableaccess WHERE CAST(access_no AS SIGNED) > 0  order by CAST(access_no AS SIGNED) DESC limit 1 ";
	
		$this->log->showLog(3,'Checking latest created access_no');
		$this->log->showLog(4,"SQL: $sql");
		$query=$this->xoopsDB->query($sql);
	
		if($row=$this->xoopsDB->fetchArray($query)){
			$this->log->showLog(3,'Found latest created access_no:' . $row['access_no']);
			$access_no=$row['access_no']+1;
	
			if(strlen($row['access_no']) != strlen($row['ori_data']))
			return str_replace($row['access_no'], '', $row['ori_data'])."".$access_no;
			else
			return $access_no;
			
		}
		else
		return 1;
			
	}
  
  

  public function getSelectAccess($id) {
	
	if($id=="")
	$id = 0;	
	
	$sql="SELECT access_id,access_name from $this->tableaccess where isactive=1 or access_id=$id " .
		" order by access_name";
	$selectctl="<SELECT name='access_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$access_id=$row['access_id'];
		$access_name=$row['access_name'];
	
		if($id==$access_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$access_id' $selected>$access_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end


  public function allowDelete($id){
	$sql="SELECT SUM(r.rowcount) as rowcount FROM (
		SELECT count(access_id) as rowcount from $this->tableinvoice where access_id=$id
		UNION ALL
		SELECT count(access_id) as rowcount from $this->tablequotation where access_id=$id) as r";
	
	$this->log->showLog(3,"Accessing ProductAccess->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this access, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this access, record deletable");
		return true;
		}
	}


 public function showAccessHeader($access_id){
	if($this->fetchAccess($access_id)){
		$this->log->showLog(4,"Showing access header successfully.");
	echo <<< EOF
	<table border='1' cellspacing='3'>
		<tbody>
			<tr>
				<th colspan="4">Access  Control Info</th>
			</tr>
			<tr>
				<td class="head">Access No</td>
				<td class="odd">$this->access_no</td>
				<td class="head">Access Description</td>
				<td class="odd"><A href="access.php?action=edit&access_id=$access_id" 
						target="_blank">$this->access_name</A></td>
			</tr>
		</tbody>
	</table>
EOF;
	}
	else{
		$this->log->showLog(1,"<b style='color:red;'>Showing access header failed.</b>");
	}

   }//showRegistrationHeader
   
   
  
  
 public function showSearchForm($wherestring="",$orderctrl=""){

   echo <<< EOF

	<FORM action="access.php" method="POST" name="frmActionSearch" id="frmActionSearch">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criteria</th>
	    </tr>
	    <tr>
	      <td class='head'>Access No</td>
	      <td class='even'><input name='access_no' value='$this->access_no'> (%, AB%,%AB,%A%B%)</td>
	      <td class='head'>Access Description</td>
	      <td class='even'><input name='access_name' value='$this->access_name'>%ali, %ali%, ali%, %ali%bin%</td>
	    </tr>
	    <tr>
	      <td class='head'>Quick Search</td>
	      <td class='odd'>$this->accessctrl</td>
	      <td class='head'>Is Active</td>
	      <td class='odd'>
		<select name="isactive">
			<option value="-1">Null</option>
			<option value="1" >Y</option>
			<option value="0" >N</option>
		</select>
		</td>
	    </tr>
	    
	
	    
	  </tbody>
	</table>
	<table style="width:150px;">
	  <tbody>
	    <tr>
	      <td><input style="height:40px;" type='submit' value='Search' name='btnSubmit'>
	      <input type='hidden' name='action' value='search'>
			<input type='hidden' name='fldSort' value=''>
			<input type='hidden' name='wherestr' value="$wherestring">
			<input type='hidden' name='orderctrl' value='$orderctrl'>  
	      </td>
	      <td><input type='reset' value='Reset' name='reset'></td>
	    </tr>
	  </tbody>
	</table>
	</FORM>
EOF;
  }

  public function convertSearchString($access_id,$access_no,$access_name,$isactive){
$filterstring="";

if($access_id > 0 ){
	$filterstring=$filterstring . " c.access_id=$access_id AND";
}

if($access_no!=""){
	$filterstring=$filterstring . " c.access_no LIKE '$access_no' AND";
}

if($access_name!=""){
	$filterstring=$filterstring . "  c.access_name LIKE '$access_name' AND";
}

if ($isactive!="-1")
$filterstring=$filterstring . " c.isactive =$isactive AND";

if ($filterstring=="")
	return "";
else {
	$filterstring =substr_replace($filterstring,"",-3);  

	return "WHERE $filterstring";
	}
	
}

  public function getSelectGroup($id,$fld='groupid',$onchange="") {
		
		if($id=="")
		$id = 0;	
		
		$sql="SELECT groupid,description from $this->tablegroups  WHERE 1 or groupid = $id " .
			" order by groupid";
		$selectctl="<SELECT name=$fld onChange='$onchange'>";
		if ($id==-1)
			$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">-- Please Select Group --</OPTION>';
			
		$query=$this->xoopsDB->query($sql);
		$selected="";
		while($row=$this->xoopsDB->fetchArray($query)){
			$groupid=$row['groupid'];
			$description=$row['description'];
		
			if($id==$groupid)
				$selected='SELECTED="SELECTED"';
			else
				$selected="";
			$selectctl=$selectctl  . "<OPTION value='$groupid' $selected>$description</OPTION>";
	
		}
	
		$selectctl=$selectctl . "</SELECT>";
	
		return $selectctl;
	} // end
  	
  

} // end of ClassAccess
?>



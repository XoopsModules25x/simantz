<?php


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);



/**
 * class Organization
 * Difference branches, training/tuition center
 */
class Organization
{

  /** Aggregations: */

  /** Compositions: */

   
  public $organization_id;
  public $organization_name;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $isactive;
  public $address_id;
  public $cur_name;
  public $cur_symbol;
  public $contactemail;
  public $website;
  public $tel_1;
  public $tel_2;
  public $fax;
  public $jpn_no;
  public $rob_no;
  public $groupid;
  public $groupctrl;
  /**
   * @access public
   */
  public $organization_code;
  
  private $xoopsDB;
  private $tableprefix;
  private $tableorganization;
  private $tableaddress;
  private $log;
  private $ad;

  /**
   *
   * @param xoopsDB 
   * @param tableprefix 
   * @access public, constructor
   */
  public function Organization($xoopsDB, $tableprefix,$log,$ad){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->tableaddress=$tableprefix . "simtrain_address";
	$this->log=$log;
	$this->ad=$ad;
   }

  /**
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllOrganization( $wherestring,  $orderbystring,  $startlimitno ) {
    $sql= "SELECT organization_id,organization_code,organization_name,tel_1,tel_2,fax," .
	"contactemail,website,isactive,address_id,jpn_no,rob_no FROM $this->tableorganization $wherestring $orderbystring";
	$this->log->showLog(4,"Calling getSQLStr_AllOrganization:" .$sql);
   return $sql;
   } // end of member function getSQLStr_AllOrganization

  /**
   *
   * @param string type 'new' or 'edit'

   * @param int organization_id 
   * @return bool
   * @access public
   */
  public function getInputForm( $type,  $organization_id,$token ) {
	//include_once ("../class/Address.php");
	//$ad = new Address($this->xoopsDB,$this->tableprefix);
	//$selectorg=$this->selectionOrg(0) . '--' .$this->orgWhereStr(0);
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	if ($type=="new"){
		$header="New Organization";
		$action="create";
		if($organization_id==0){
		$this->organization_name="";
		$this->organization_code="";
		$this->tel_1="";
		$this->tel_2="";
		$this->fax="";
		$this->contactemail="";
		$this->jpn_no="";
		$this->rob_no="";
		$this->website="";
		$this->groupid=0;
		}
		$this->address_id="0";
		$address="Null(Save organization before edit address.)";
		$addressctl="";
		$savectrl="<input name='submit' value='save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
	}
	else
	{
		/*
		*
		* creating address for organization not yet complete.
		*/
		$action="update";
		$address=$this->ad->showAddress($this->address_id);

//		$addressctl="<input type='button' value='Change' name='btnAddress' onClick='showAddressWindow($this->address_id);'>";
		$addressctl="<A href='../address.php?address_id=$this->address_id&action=edit'  onclick='javascript:document.frmOrganization.submit.click()' target='_blank'>Change</A>";
		$savectrl="<input name='organization_id' value='$this->organization_id' type='hidden'>".
			 "<input name='submit' value='save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";
		$header="Edit Organization";
		$deletectrl="<FORM action='organization.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this organization?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->organization_id' name='organization_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		$addnewctrl="<Form action='organization.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<form onsubmit="return validateOrganization()" method="post"
 action="organization.php" name="frmOrganzation">
  <table style="text-align: left; width: 100%;" border="1"
 cellpadding="2" >
    <tbody>
      <tr>
        <th colspan="3" rowspan="1">$header</th>
      </tr>
      <tr>
        <td >Organization Code $selectorg</td>
        <td colspan="2"><input maxlength="10" size="10"
 name="organization_code" value="$this->organization_code"><A>     </A>Active <input type="checkbox" $checked name="isactive">  $this->groupctrl</td>
      </tr>
      <tr>
        <td>Organization Name</td>
        <td colspan="2"><input maxlength="40" size="40"
 name="organization_name" value="$this->organization_name"> </td>
      </tr>
      <tr>
        <td >Tel 1 / Tel 2</td>
        <td colspan="2"><input maxlength="16" size="16"
 name="tel_1" value="$this->tel_1"> / <input
 maxlength="16" size="16" name="tel_2"
 value="$this->tel_2"></td>
      </tr>
      <tr>
        <td>Fax</td>
        <td colspan="2"><input maxlength="16" size="16"
 name="fax" value="$this->fax"></td>
      </tr>
      <tr>
        <td>Website</td>
        <td colspan="2"><input maxlength="100" size="60"
 name="website" value="$this->website"></td>
      </tr>
      <tr>
        <td>ROB/ROC No</td>
        <td colspan="2"><input maxlength="14" size="14"
 name="rob_no" value="$this->rob_no"></td>
 </tr>

      <tr>   
     <td>JPN/License No</td>
        <td colspan="2"><input maxlength="14" size="14"
 name="jpn_no" value="$this->jpn_no"></td>
      </tr>

      <tr>
        <td>Email</td>
        <td colspan="2"><input maxlength="100" size="60"
 name="contactemail" value="$this->contactemail"></td>
      </tr>
      <tr>
        <td>Student Card Into</td>
        <td colspan="2"><textarea cols='60' rows='10' name="studentcard_info">$this->studentcard_info</textarea></td>
      </tr>

      <tr>
        <td style="vertical-align: top;">Address</td>
        <td colspan="2">$address address_id= $this->address_id<br> 
	$addressctl
        </td>
      </tr>
      <tr>
        <td>$savectrl  <input name="reset" value="Reset" type="reset"> 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></form> </td><td>
	  $deletectrl </td><td> $addnewctrl
	</td>
      </tr>
    </tbody>
  </table>
  <br>



EOF;
  } // end of member function getInputForm

  /**
   *
   * @return bool
   * @access public
   */
  public function updateOrganization( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$sql="UPDATE $this->tableorganization SET 
	organization_name='$this->organization_name',organization_code='$this->organization_code',
	tel_1='$this->tel_1',tel_2='$this->tel_2',fax='$this->fax',website='$this->website',contactemail='$this->contactemail'
	,updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',groupid=$this->groupid, 
	jpn_no='$this->jpn_no', rob_no='$this->rob_no',studentcard_info='$this->studentcard_info' 
	WHERE organization_id='$this->organization_id'";
	
	$this->log->showLog(3, "Update organization_id: $this->organization_id, $this->organization_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update organization failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update organization successfully.");
		return true;
	}

  } // end of member function updateOrganization


/**
   *
   * @return int
   * @access public
   */
  public function getLatestOrganizationID() {
	$sql="SELECT MAX(organization_id) as organization_id from $this->tableorganization;";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['organization_id'];
	else
	return -1;
	
  } // end of member function getLatestOrganizationID


  /**
   *
   * @return bool
   * @access public
   */
  public function insertOrganization( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new organization $organization_name");
 	$sql="INSERT INTO $this->tableorganization (organization_name,organization_code,jpn_no,rob_no,
		tel_1,tel_2,fax,website,contactemail,isactive, created,createdby,updated,updatedby,address_id,
		groupid,studentcard_info) values(
		'$this->organization_name','$this->organization_code','$this->jpn_no','$this->rob_no','$this->tel_1',
		'$this->tel_2','$this->fax',
		'$this->website','$this->contactemail','$this->isactive','$timestamp',$this->createdby,'$timestamp',
		$this->updatedby,$this->address_id,$this->groupid,'$this->studentcard_info')";
	$this->log->showLog(4,"Before insert organization SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert organization $organization_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new organization $organization_name successfully"); 
		return true;
	}
} // end of member function insertOrganization

  /**
   *
   * @param int organization_id 
   * @return bool
   * @access public
   */
  public function deleteOrganization( $organization_id ) {
    	$this->log->showLog(2,"Warning: Performing delete organization id : $organization_id !");
	$sql="DELETE FROM $this->tableorganization where organization_id=$organization_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: organization ($organization_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Organization ($organization_id) removed from database successfully!");
		return true;
		
	}
	
  } // end of member function deleteOrganization

/**
   *
   * @param int organization_id 
   * @return bool
   * @access public
   */
  public function fetchOrganization( $organization_id ) {
	
	$this->log->showLog(3,"Fetching organization detail into class Organization.php.<br>");
		
	$sql="SELECT organization_code,organization_name,tel_1,tel_2,fax,website,contactemail,studentcard_info,
		address_id,isactive,groupid,jpn_no,rob_no from $this->tableorganization where organization_id=$organization_id";
	
	$this->log->showLog(4,"Organization->fetchOrganization, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->organization_name=$row["organization_name"];
		$this->organization_code=$row["organization_code"];
		$this->tel_1= $row['tel_1'];
		$this->tel_2=$row['tel_2'];
		$this->rob_no=$row['rob_no'];		
		$this->jpn_no=$row['jpn_no'];
		$this->fax=$row['fax'];
		$this->groupid=$row['groupid'];
		$this->website=$row['website'];
		$this->contactemail=$row['contactemail'];
		$this->isactive=$row['isactive'];
		$this->studentcard_info=$row['studentcard_info'];
		$this->address_id=$row['address_id'];
	$this->log->showLog(4,"Organization->fetchOrganization,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Organization->fetchOrganization,failed to fetch data into databases.");	
	}
  } // end of member function fetchOrganization

/**
   *Control user whether he/she able to access all organization or only a few
   *
   *@param int $uid current login user id
   *return string a selection box, depends on user permission,full list or empty. If assign orgainzation_id=0, it will simply
   *              choose 1st item, if =-1 it will include a blank organization in selection box, else will autoselect particular org
   *@access public
   */
 public function selectionOrg($uid,$organization_id){
  return "<SELECT name='organization_id'><option value='0'>Visi Kota</option><option value='1'>Visi Jaya</option></SELECT>";

  }// end of  selectionOrg($uid)

/**
   *Control user whether he/she able to access all organization or only a few
   *
   *@param int $uid current login user id
   *return string a where istring, sample data is 'organization_id in (1,2)';
   *
   *@access public
   */
 public function orgWhereStr($uid){
  return "organization_id in (0,1,2,3)";
 } // end of orgWhereStr($uid)


/**
   * Display a table for all organization
   *
   * @access public
   */
 public function showOrganizationTable(){
	
	$this->log->showLog(3,"Showing Organization Table");
	$sql=$this->getSQLStr_AllOrganization("","ORDER BY organization_code",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Organization Code</th>
				<th style="text-align:center;">Organization Name</th>
				<th style="text-align:center;">ROB No</th>
				<th style="text-align:center;">JPN No</th>				
				<th style="text-align:center;">Website</th>
				<th style="text-align:center;">Email</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$organization_code=$row['organization_code'];
		$organization_name=$row['organization_name'];
		$website=$row['website'];
		$contactemail=$row['contactemail'];
		$rob_no=$row['rob_no'];
		$jpn_no=$row['jpn_no'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];
		if($rowtype=="odd")
			$rowtype=="even";
		else
			$rowtype=="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$organization_code</td>
			<td class="$rowtype" style="text-align:center;">$organization_name</td>
			<td class="$rowtype" style="text-align:center;">$rob_no</td>
			<td class="$rowtype" style="text-align:center;">$jpn_no</td>
			<td class="$rowtype" style="text-align:center;">$website</td>
			<td class="$rowtype" style="text-align:center;">$contactemail</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="organization.php" method="POST">
				<input type="submit" value="Edit" name="submit">
				<input type="hidden" value="$organization_id" name="organization_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

  public function getAllSystemGroup($gid){
	$this->log->showLog(3,"Retrieve available system groups from database, with preselect id: $id");
	$tablegroups=$this->tableprefix."groups";
//	$tableusersgroups=$this->tableprefix."groups_users_link";
	$sql="SELECT groupid,name FROM $tablegroups";

	
	$this->log->showLog(4,"SQL: $sql");
	$selectctl="<SELECT name='groupid' >";

	
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$groupid=$row['groupid'];
		$name=$row['name'];
	
		if($gid==$groupid)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$groupid' $selected>$name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
	


  } //getAllSystemGroup

} // end of Organization
?>

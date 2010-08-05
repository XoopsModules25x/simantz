<?php


class FollowUp
{

	public $followup_id;
	public $followup_name;
	public $alternatename;
	public $issuedate;
	public $email;
	public $contactperson;
	public $nextfollowupdate;
	public $contactnumber;
	public $fax;
	public $followuptype_id;
	public $position;
	public $department;
	public $uid;
	public $bpartner_id;
	public $description;
	public $organization_id;
	public $created;
	public $createdby;
	public $updated;
	public $updatedby;
	public $isactive;
	public $defaultlevel;
    public $followuptypectrl;
    public $userctrl;
    public $bpartnerctrl;

  public $isAdmin;

  public $orgctrl;

  public $updatesql;

  private $xoopsDB;


  private $tablefollowup;
  private $tablebpartner;
  public $tablefollowuptype;
  public $tableusers;
  private $defaultorganization_id;

  private $log;


//constructor
   public function FollowUp(){
	global $xoopsDB,$log,$tablefollowup,$tablebpartner,$defaultorganization_id,
            $tableusers,$tablefollowuptype;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablefollowup=$tablefollowup;
	$this->tablebpartner=$tablebpartner;
    $this->tablefollowuptype=$tablefollowuptype;
    $this->tableusers=$tableusers;
	$this->log=$log;
    $this->defaultorganization_id=$defaultorganization_id;

   }

  public function getInputForm( $type,  $followup_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";

	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New FollowUp";
		$action="create";

		if($followup_id==0 || $followup_id==""){
			$this->followup_name="";
			$this->isactive="";
			$this->defaultlevel=10;
			$this->followup_type="P";
			$this->defaultsellaccount_id=0;
		}
		$savectrl="<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

		$this->followup_code = getNewCode($this->xoopsDB,"followup_code",$this->tablefollowup);

	}
	else
	{

		$action="update";
		$savectrl="<input name='followup_id' value='$this->followup_id' type='hidden'>".
			 "<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";



		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablefollowup' type='hidden'>".
		"<input name='id' value='$this->followup_id' type='hidden'>".
		"<input name='idname' value='followup_id' type='hidden'>".
		"<input name='title' value='FollowUp' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";


		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

     
		$header="Edit FollowUp";

		if($this->allowDelete($this->followup_id))
		$deletectrl="<FORM action='followup.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this followup?"'.")'>
        <input type='submit' value='Delete' name='btnDelete'>
		<input type='hidden' value='$this->followup_id' name='followup_id'>
        <input type='hidden' value='$this->bpartner_id' name='bpartner_id'>
		<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='followup.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";

		if($this->followup_type == "P")//Standard
		$selectedP = "selected = 'selected'";
		else if($this->followup_type == "C")//Other charges
		$selectedC = "selected = 'selected'";

	}

global $dp;
$showCalender=$dp->show('issuedate');
$showFollowUpCalender=$dp->show('nextfollowupdate');
    echo <<< EOF

<table style="width:140px;"><tbody><td></td><td nowrap>
    <form onsubmit="return validateFollowUp()" method="post"
 action="followup.php" name="frmFollowUp" >
<input name="reset" value="Reset" type="reset">
</td></tbody></table>

  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
    	<td class="head">Issue Date</td>
    	<td class="even" >
        	<input maxlength="10" size="10" name="issuedate" id="issuedate" value="$this->issuedate">
                <input name='btnDate' value='Date' onclick="$showCalender" type='button'>
             <input type="checkbox" $checked name="isactive">Active</td>
       <td class="head">Title</td>
        <td class="even" ><input maxlength="100" size="40" name="followup_name" value="$this->followup_name"> </td>

      </tr>
    <tr>
        <td class="head" >Business Partner</td>
        <td class="even" >$this->bpartnerctrl</td>
       
               <td class="head">Type</td>
        <td class="even">$this->followuptypectrl</td>

   </tr>
    <tr>
        <td class="head">P.I.C</td>
        <td class="even">$this->employeectrl</td>
        <td class="head">Follow Up Date</td>
        <td class="even" ><input size='10' maxlength='10' id="nextfollowupdate" name="nextfollowupdate" value="$this->nextfollowupdate">
                <input name='btnDate' value='Date' onclick="$showFollowUpCalender" type='button'></td>
   </tr>
    <tr>
        <td class="head">Contact Person</td>
        <td class="even"><input name="contactperson" value="$this->contactperson"></td>
        <td class="head">Contact Number</td>
        <td class="even" ><input name="contactnumber" value="$this->contactnumber"></td>

   </tr>
    <tr>
        <td class="head">Description</td>
        <td class="even" colspan='3'><textarea name='description' cols='50'>$this->description</textarea></td>
   </tr>

    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$savectrl
	<input name="action" value="$action" type="hidden">
    <input name="token" value="$token" type="hidden"></td>
	</form><td>
        <a href="bpartner.php?action=view&bpartner_id=$this->bpartner_id">
            <input type='button' value='Cancel'></a>
    </td><td>$deletectrl</td>
<td>$recordctrl</td></tbody></table>
  <br>



EOF;
  } // end of member function getInputForm

  /**
   * Update existing followup record
   *
   * @return bool
   * @access public
   */
  public function updateFollowUp( ) {

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablefollowup SET
		followup_name='$this->followup_name',
		issuedate='$this->issuedate',
		contactperson='$this->contactperson',
		nextfollowupdate='$this->nextfollowupdate',
                employee_id=$this->employee_id,
		contactnumber='$this->contactnumber',
		followuptype_id=$this->followuptype_id,
		bpartner_id=$this->bpartner_id,
		description='$this->description',
		updated='$this->updated',
		updatedby=$this->updatedby,
		isactive=$this->isactive
		WHERE followup_id=$this->followup_id";
	$this->updatesql=$sql;
	$this->log->showLog(3, "Update followup_id: $this->followup_id, $this->followup_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
   // exit(0);
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update followup failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update followup successfully.");
		return true;
	}
  } // end of member function updateFollowUp

  /**
   * Save new followup into database
   *
   * @return bool
   * @access public
   */
  public function insertFollowUp( ) {


   	$timestamp= date("y/m/d H:i:s", time()) ;

	$this->log->showLog(3,"Inserting new followup $this->followup_name");
 	$sql="INSERT INTO $this->tablefollowup
		(
		followup_name,
		issuedate,
		contactperson,
		nextfollowupdate,
		contactnumber,
		followuptype_id,
		bpartner_id,
		description,
		created,
		createdby,
		updated,
		updatedby,
		isactive,
                employee_id
    )

	values(
		'$this->followup_name',
		'$this->issuedate',
		'$this->contactperson',
		'$this->nextfollowupdate',
		'$this->contactnumber',
		$this->followuptype_id,
		$this->bpartner_id,
		'$this->description',
		'$this->created',
		$this->createdby,
		'$this->updated',
		$this->updatedby,
		$this->isactive,
                $this->employee_id
)";
   $this->updatesql=$sql;
	
        $this->log->showLog(4,"Before insert followup SQL:$sql");

	$rs=$this->xoopsDB->query($sql);

	if (!$rs){
		$this->log->showLog(1,"Failed to insert followup code $followup_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new followup $followup_name successfully");
		return true;
	}
  } // end of member function insertFollowUp

  /**
   * Pull data from followup table into class
   *
   * @return bool
   * @access public
   */
  public function fetchFollowUp( $followup_id) {


	$this->log->showLog(3,"Fetching followup($followup_id) detail into class FollowUp.php.<br>");

	$sql="SELECT c.*
            from $this->tablefollowup c
            where c.followup_id=$followup_id ";

	$this->log->showLog(4,"ProductFollowUp->fetchFollowUp, before execute SQL: $sql ");

	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query)){


	$this->followup_name=$row['followup_name'];
	$this->alternatename=$row['alternatename'];
	$this->issuedate=$row['issuedate'];
	$this->contactperson=$row['contactperson'];
	$this->nextfollowupdate=$row['nextfollowupdate'];
	$this->contactnumber=$row['contactnumber'];
	$this->followuptype_id=$row['followuptype_id'];

	$this->bpartner_id=$row['bpartner_id'];
	$this->description=$row['description'];
	$this->created=$row['created'];
	$this->createdby=$row['createdby'];
	$this->updated=$row['updated'];
	$this->updatedby=$row['updatedby'];
	$this->isactive=$row['isactive'];

        $this->employee_id=$row['employee_id'];


   	$this->log->showLog(4,"FollowUp->fetchFollowUp,database fetch into class successfully");
	$this->log->showLog(4,"followup_name:$this->followup_name");

	$this->log->showLog(4,"isactive:$this->isactive");

		return true;
	}
	$this->log->showLog(4,"FollowUp->fetchFollowUp,failed to fetch data into databases:" . mysql_error(). ":$sql");
	return false;


  } // end of member function fetchFollowUp

  /**
   * Delete particular followup id
   *
   * @param int followup_id
   * @return bool
   * @access public
   */
  public function deleteFollowUp( $followup_id ) {
    	$this->log->showLog(2,"Warning: Performing delete followup id : $followup_id !");
	$sql="DELETE FROM $this->tablefollowup where followup_id=$followup_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->updatesql=$sql;
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: followup ($followup_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"followup ($followup_id) removed from database successfully!");
		return true;

	}
  } // end of member function deleteFollowUp

  /**
   * Return select sql statement.
   *
   * @param string wherestring
   * @param string orderbystring
   * @param int startlimitno
   * @return string
   * @access public
   */
  public function getSQLStr_AllFollowUp( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductFollowUp->getSQLStr_AllFollowUp: $sql");

    $sql="SELECT c.*,ft.followuptype_name FROM $this->tablefollowup c
    inner join $this->tablefollowuptype ft on ft.followuptype_id=c.followuptype_id
    	$wherestring $orderbystring";
    $this->log->showLog(4,"Generate showfollowuptable with sql:$sql");

  return $sql;
  } // end of member function getSQLStr_AllFollowUp

 public function showFollowUpTable($bpartner_id,$wherestring,$orderbystring,$token){

	$this->log->showLog(3,"Showing FollowUp Table");
	$sql=$this->getSQLStr_AllFollowUp($wherestring,$orderbystring);

	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
    <script type='text/javascript'>

        function showAddFollowUp(){

            var trShowAddFollowUp=document.getElementById("trShowAddFollowUp");
            var btnAddFollowUp=document.getElementById("btnAddFollowUp");

            if(trShowAddFollowUp.style.display=='none'){
                trShowAddFollowUp.style.display='';
                btnAddFollowUp.value="Cancel";
            }
            else{
                trShowAddFollowUp.style.display='none';
                btnAddFollowUp.value="Add New";
            }
        }
    </script>

	<table border='0' cellspacing='3'>
  		<tbody>
            <tr><th colspan='10' style='text-align:center'>FollowUp Information
                    <Input id='btnAddFollowUp' value='Add New' type='button' onclick='showAddFollowUp()'>
                </th></tr>
            <tr id='trShowAddFollowUp' style='display:none'><td class='even' colspan='10'>
EOF;
        global $ctrl;
        if($bpartner_id>0)
        $this->bpartnerctrl="<input 1type='hidden' name='bpartner_id' value='$bpartner_id'>";
        else
        $this->bpartnerctrl=$ctrl->getSelectBPartner(0,'N');

        $this->followuptypectrl=$ctrl->getSelectfollowuptype(0,'Y');
        $this->employeectrl=$ctrl->getSelectEmployee(0);
       $this->getInputForm('new',0,$token);
    echo <<< EOF
            </td>
            </tr>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Date</th>
				<th style="text-align:center;">Title</th>
				<th style="text-align:center;">Type</th>
				<th style="text-align:center;">Follow Up Date</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Person</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
	$i++;

	$followup_id=$row['followup_id'];
	$followup_name=$row['followup_name'];
        	$followuptype_name=$row['followuptype_name'];
	$isactive=$row['isactive'];
	$isshipment=$row['isshipment'];
	$isinvoice=$row['isinvoice'];
	$followup_street=$row['followup_street'];
	$followup_postcode=$row['followup_postcode'];
	$followup_city=$row['followup_city'];
	$region_id=$row['region_id'];
    $region_name=$row['region_name'];

	$country_id=$row['country_id'];
    $country_name=$row['country_name'];
	$organization_id=$row['organization_id'];
	$bpartner_id=$row['bpartner_id'];
    $issuedate =$row['issuedate'];
	$nextfollowupdate=$row['nextfollowupdate'];
	$contactperson=$row['contactperson'];
    $position=$row['position'];
    $department=$row['department'];
	$email=$row['email'];

	$description=$row['description'];

		if($isactive==0)
		{
                  $isactive='N';
		
		}
		else
		$isactive='Y';

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

                if($nextfollowupdate <= date("Y-m-d",time()))
                    $nextfollowupdate="<b style='color:red'>$nextfollowupdate</b>";

		
		echo <<< EOF
				
		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$issuedate </td>
			<td class="$rowtype" style="text-align:center;">$followup_name</td>
			<td class="$rowtype" style="text-align:center;">$followuptype_name</td>
			<td class="$rowtype" style="text-align:center;">$nextfollowupdate</td>
			<td class="$rowtype" style="text-align:center;">$description</td>
			<td class="$rowtype" style="text-align:center;">$contactperson</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<a href='followup.php?action=edit&followup_id=$followup_id'>
				<img src="images/edit.gif"title='View this followup'></a>
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
  public function getLatestFollowUpID() {
	$sql="SELECT MAX(followup_id) as followup_id from $this->tablefollowup;";
	$this->log->showLog(3,'Checking latest created followup_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created followup_id:' . $row['followup_id']);
		return $row['followup_id'];
	}
	return -1;

  } // end
/*

  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablefollowup
        where organization_id=$this->defaultorganization_id;";
	$this->log->showLog(3,'Checking next defaultlevel');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found next defaultlevel:' . $row['defaultlevel']);
		return  $row['defaultlevel'];
	}

	return 10;

  } // end
*/
 public function allowDelete($followup_id){
	$sql="SELECT count(followup_id) as rowcount from $this->tablewarehouse where followup_id=$followup_id";
	$this->log->showLog(3,"Accessing ProductFollowUp->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this product, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this product, record deletable.");
		return true;
		}
        return true;
	}

/*
  public function showSearchForm($wherestr){


	if($this->issearch != "Y"){
	$this->followup_code = "";
	$this->followup_name = "";
	$this->followup_type = "";
	$this->isactive = "null";
	$this->defaultsellaccount_id = 0;
	}


	if($this->followup_type == "P")
	$selectedP = "selected = 'selected'";
	else if($this->followup_type == "T")
	$selectedT = "selected = 'selected'";
	else if($this->followup_type == "C")
	$selectedC = "selected = 'selected'";
	else if($this->followup_type == "O")
	$selectedO = "selected = 'selected'";
	else
	$selectedNull = "selected = 'selected'";

	//isactive
	if($this->isactive == "1")
	$selectactiveY = "selected = 'selected'";
	else if($this->isactive == "0")
	$selectactiveN = "selected = 'selected'";
	else
	$selectactiveL = "selected = 'selected'";

	//echo $this->isactive;

echo <<< EOF
	<form name="frmFollowUp" action="followup.php" method="POST">
	</form>

	<form name="frmSearch" action="followup.php" method="POST">

	<table>
	<tr>
	<td nowrap><input value="Reset" type="reset">
	<input value="New" type="button" onclick="gotoAction('');"></td>
	</tr>
	</table>

	<table border="0">
	<input name="issearch" value="Y" type="hidden">
	<input name="action" value="search" type="hidden">
	<tr><th colspan="4">Criterial</th></tr>

	<tr>
	<td class="head">FollowUp Code</td>
	<td class="even"><input name="followup_code" value="$this->followup_code"></td>
	<td class="head">FollowUp Name </td>
	<td class="even"><input name="followup_name" value="$this->followup_name"></td>
	</tr>

	<tr>
	<td class="head">FollowUp Type</td>
	<td class="even" colspan='3'>
	<select name="followup_type">
	<option value="" $selectedNull>Null</option>
	<option value="P" $selectedP>Standard Product</option>
	<option value="C" $selectedC>Other Charges</option>
	</select>
	<tr>
	<td class="head">Is Active</td>
	<td class="even" colspan="3">
	<select name="isactive">
	<option value="null" $selectactiveL>Null</option>
	<option value=1 $selectactiveY>Yes</option>
	<option value=0 $selectactiveN>No</option>
	</select>
	</td>
	</tr>

	<tr>
	<th colspan="4"><input type="submit" aonclick="gotoAction('search');" value="Search" ></th>
	</tr>

	</table>
	</form>
	<br>
EOF;
  }
   public function allowEdit($followup_id){
       return true;
   }
	public function getWhereStr(){

	$wherestr = "";

	if($this->followup_code != "")
	$wherestr .= " and followup_code like '$this->followup_code' ";
	if($this->followup_name != "")
	$wherestr .= " and followup_name like '$this->followup_name' ";
	if($this->followup_type != "")
	$wherestr .= " and followup_type like '$this->followup_type' ";
	if($this->defaultsellaccount_id > 0)
	$wherestr .= " and defaultsellaccount_id = $this->defaultsellaccount_id ";
	if($this->isactive == "0" || $this->isactive == "1")
	$wherestr .= " and isactive = $this->isactive ";

	return $wherestr;

	}
*/
} // end of ClassFollowUp
?>

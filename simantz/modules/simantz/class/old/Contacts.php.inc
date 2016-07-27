<?php


class Contacts
{

	public $contacts_id;
	public $contacts_name;
	public $alternatename;
	public $greeting;
	public $email;
	public $hpno;
	public $tel_1;
	public $tel_2;
	public $fax;
	public $address_id;
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
    public $addressctrl;
    public $userctrl;
    public $bpartnerctrl;

  public $isAdmin;

  public $orgctrl;

  public $updatesql;

  private $xoopsDB;


  private $tablecontacts;
  private $tablebpartner;
  public $tableaddress;
  public $tableusers;
  private $defaultorganization_id;

  private $log;


//constructor
   public function Contacts(){
	global $xoopsDB,$log,$tablecontacts,$tablebpartner,$defaultorganization_id,
            $tableusers,$tableaddress;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablecontacts=$tablecontacts;
	$this->tablebpartner=$tablebpartner;
    $this->tableaddress=$tableaddress;
    $this->tableusers=$tableusers;
	$this->log=$log;
    $this->defaultorganization_id=$defaultorganization_id;

    $this->arrInsertField=array("contacts_name","alternatename","greeting","email","hpno",
		                "tel_1","tel_2","fax","address_id","position",
		                "department","uid","bpartner_id","description","organization_id",
		                "created","createdby","updated","updatedby","isactive",
		                "defaultlevel","races_id","religion_id");

    $this->arrInsertFieldType=array("%s","%s","%s","%s","%s",
                                    "%s","%s","%s","%d","%s",
                                    "%s","%d","%d","%s","%d",
                                    "%s","%d","%s","%d","%d",
                                    "%d","%d","%d");

    $this->arrUpdateField=array("contacts_name","alternatename","greeting","email","hpno",
		                "tel_1","tel_2","fax","address_id","position",
		                "department","uid","bpartner_id","description",
		                "created","createdby","updated","updatedby","isactive",
		                "defaultlevel","races_id","religion_id");

    $this->arrUpdateFieldType=array("%s","%s","%s","%s","%s",
                                    "%s","%s","%s","%d","%s",
                                    "%s","%d","%d","%s",
                                    "%s","%d","%s","%d","%d",
                                    "%d","%d","%d");

    $this->tablename="sim_contacts";

   }

  public function getInputForm( $type,  $contacts_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";

	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Contacts";
		$action="create";

		if($contacts_id==0 || $contacts_id==""){
			$this->contacts_name="";
			$this->isactive="";
			$this->defaultlevel=10;
			$this->contacts_type="P";
			$this->defaultsellaccount_id=0;
		}
		$savectrl="<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

		$this->contacts_code = getNewCode($this->xoopsDB,"contacts_code",$this->tablecontacts);

	}
	else
	{

		$action="update";
		$savectrl="<input name='contacts_id' value='$this->contacts_id' type='hidden'>".
			 "<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";



		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablecontacts' type='hidden'>".
		"<input name='id' value='$this->contacts_id' type='hidden'>".
		"<input name='idname' value='contacts_id' type='hidden'>".
		"<input name='title' value='Contacts' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";


		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

     
		$header="Edit Contacts";

		if($this->allowDelete($this->contacts_id))
		$deletectrl="<FORM action='contacts.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this contacts?"'.")'>
        <input type='submit' value='Delete' name='btnDelete'>
		<input type='hidden' value='$this->contacts_id' name='contacts_id'>
        <input type='hidden' value='$this->bpartner_id' name='bpartner_id'>
		<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='contacts.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";

		if($this->contacts_type == "P")//Standard
		$selectedP = "selected = 'selected'";
		else if($this->contacts_type == "C")//Other charges
		$selectedC = "selected = 'selected'";

	}


    echo <<< EOF

<table style="width:140px;"><tbody><td></td><td nowrap>
    <form onsubmit="return validateContacts()" method="post" 
 action="contacts.php" name="frmContacts" >
<input name="reset" value="Reset" type="reset">
</td></tbody></table>

  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
    	<td class="head">Greeting</td>
    	<td class="even" >
        	<input maxlength="30" size="20" name="greeting" value="$this->greeting"></td>
       <td class="head">Contact Name</td>
        <td class="even" ><input maxlength="40" size="20" name="contacts_name" value="$this->contacts_name"> </td>

      </tr>
    <tr>
        <td class="head" >Business Partner</td>
        <td class="even" >$this->bpartnerctrl</td>
        <td class="head">Alternate Name</td>
        <td class="even" ><input name="alternatename" value="$this->alternatename"></td>
   </tr>
    <tr>
        <td class="head" >Position</td>
        <td class="even" ><input name="position" value="$this->position"></td>
        <td class="head">Department</td>
        <td class="even" ><input name="department" value="$this->department"></td>
   </tr>
    <tr>
        <td class="head" >Races</td>
        <td class="even" >$this->racesctrl</td>
        <td class="head">Religion</td>
        <td class="even" >$this->religionctrl</td>
   </tr>
    <tr>
        <td class="head" >Active</td>
        <td class="even" ><input type="checkbox" $checked name="isactive"></td>
        <td class="head">Default Level</td>
        <td class="even" ><input name="defaultlevel" value="$this->defaultlevel"></td>
   </tr>
    <tr>
        <td class="head">Tel 1</td>
        <td class="even" ><input name="tel_1" value="$this->tel_1"></td>
        <td class="head">Tel 2</td>
        <td class="even" ><input name="tel_2" value="$this->tel_2"></td>
   </tr>
    <tr>
        <td class="head">Email</td>
        <td class="even" ><input  name='email' value='$this->email'></td>
        <td class="head">Hand Phone</td>
        <td class="even"><input name="hpno" value="$this->hpno"></td>
   </tr>
    <tr>
        <td class="head">Fax</td>
        <td class="even" ><input  name='fax' value='$this->fax'></td>
        <td class="head">User</td>
        <td class="even" >$this->userctrl</td>
   </tr>
    <tr>
        <td class="head">Address</td>
        <td class="even">$this->addressctrl</td>
        <td class="head">Description</td>
        <td class="even"><input name='description' value='$this->description'></td>
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
   * Update existing contacts record
   *
   * @return bool
   * @access public
   */
  public function updateContacts( ) {

    include "../simantz/class/Save_Data.inc.php";
    $timestamp= date("y/m/d H:i:s", time()) ;
    $save = new Save_Data();
    $arrvalue=array($this->contacts_name,$this->alternatename,$this->greeting,$this->email,$this->hpno,
		    $this->tel_1,$this->tel_2,$this->fax,$this->address_id,$this->position,
		    $this->department,$this->uid,$this->bpartner_id,$this->description,
		    $this->created,$this->createdby,$this->updated,$this->updatedby,$this->isactive,
		    $this->defaultlevel,$this->races_id,$this->religion_id);

    return $save->UpdateRecord($this->tablename, "contacts_id", $this->contacts_id, $this->arrUpdateField, $arrvalue,  $this->arrUpdateFieldType,$this->contacts_name);
 	
  } // end of member function updateContacts

  /**
   * Save new contacts into database
   *
   * @return bool
   * @access public
   */
  public function insertContacts( ) {

    include "../simantz/class/Save_Data.inc.php";
    $timestamp= date("y/m/d H:i:s", time()) ;
    $save = new Save_Data();
    $arrvalue=array($this->contacts_name,$this->alternatename,$this->greeting,$this->email,$this->hpno,
		    $this->tel_1,$this->tel_2,$this->fax,$this->address_id,$this->position,
		    $this->department,$this->uid,$this->bpartner_id,$this->description,$this->organization_id,
		    $this->created,$this->createdby,$this->updated,$this->updatedby,$this->isactive,
		    $this->defaultlevel,$this->races_id,$this->religion_id);

    return $save->InsertRecord($this->tablename, $this->arrInsertField, $arrvalue, $this->arrInsertFieldType, $this->contacts_name,"contacts_id");

   
  } // end of member function insertContacts

  /**
   * Pull data from contacts table into class
   *
   * @return bool
   * @access public
   */
  public function fetchContacts( $contacts_id) {


	$this->log->showLog(3,"Fetching contacts($contacts_id) detail into class Contacts.php.<br>");

	$sql="SELECT c.*
            from $this->tablecontacts c
            where c.contacts_id=$contacts_id and
            c.organization_id=$this->defaultorganization_id";

	$this->log->showLog(4,"ProductContacts->fetchContacts, before execute SQL: $sql ");

	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query)){


	$this->contacts_name=$row['contacts_name'];
	$this->alternatename=$row['alternatename'];
	$this->greeting=$row['greeting'];
	$this->email=$row['email'];
	$this->hpno=$row['hpno'];
	$this->tel_1=$row['tel_1'];
	$this->tel_2=$row['tel_2'];
	$this->fax=$row['fax'];
	$this->address_id=$row['address_id'];
	$this->position=$row['position'];
	$this->department=$row['department'];
	$this->uid=$row['uid'];
	$this->bpartner_id=$row['bpartner_id'];
	$this->description=$row['description'];
	$this->organization_id=$row['organization_id'];
	$this->created=$row['created'];
	$this->createdby=$row['createdby'];
	$this->updated=$row['updated'];
	$this->updatedby=$row['updatedby'];
	$this->isactive=$row['isactive'];
	$this->defaultlevel=$row['defaultlevel'];
        $this->races_id=$row['races_id'];
        $this->religion_id=$row['religion_id'];

   	$this->log->showLog(4,"Contacts->fetchContacts,database fetch into class successfully");
	$this->log->showLog(4,"contacts_name:$this->contacts_name");

	$this->log->showLog(4,"isactive:$this->isactive");

		return true;
	}
	$this->log->showLog(4,"Contacts->fetchContacts,failed to fetch data into databases:" . mysql_error(). ":$sql");
	return false;


  } // end of member function fetchContacts

  /**
   * Delete particular contacts id
   *
   * @param int contacts_id
   * @return bool
   * @access public
   */
  public function deleteContacts( $contacts_id ) {
    
    include "../simantz/class/Save_Data.inc.php";
    $save = new Save_Data();
   
    return $save->DeleteRecord($this->tablename,"contacts_id",$contacts_id,$this->contacts_name,1);

  } // end of member function deleteContacts

  /**
   * Return select sql statement.
   *
   * @param string wherestring
   * @param string orderbystring
   * @param int startlimitno
   * @return string
   * @access public
   */
  public function getSQLStr_AllContacts( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductContacts->getSQLStr_AllContacts: $sql");

    $sql="SELECT c.*,u.uname FROM $this->tablecontacts c
        INNER JOIN $this->tableusers u on c.uid=u.uid
    	$wherestring $orderbystring";
    $this->log->showLog(4,"Generate showcontactstable with sql:$sql");

  return $sql;
  } // end of member function getSQLStr_AllContacts

 public function showContactsTable($bpartner_id,$wherestring,$orderbystring,$token){

	$this->log->showLog(3,"Showing Contacts Table");
	$sql=$this->getSQLStr_AllContacts($wherestring,$orderbystring);

	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
    <script type='text/javascript'>

        function showAddContacts(){

            var trShowAddContacts=document.getElementById("trShowAddContacts");
            var btnAddContacts=document.getElementById("btnAddContacts");

            if(trShowAddContacts.style.display=='none'){
                trShowAddContacts.style.display='';
                btnAddContacts.value="Cancel";
            }
            else{
                trShowAddContacts.style.display='none';
                btnAddContacts.value="Add New";
            }
        }
    </script>

	<table border='0' cellspacing='3'>
  		<tbody>
            <tr><th colspan='10' style='text-align:center'>Contacts Information
                    <Input id='btnAddContacts' value='Add New' type='button' onclick='showAddContacts()'>
                </th></tr>
            <tr id='trShowAddContacts' style='display:none'><td class='even' colspan='10'>
EOF;
        global $ctrl;
        $this->bpartnerctrl="<input 1type='hidden' name='bpartner_id' value='$bpartner_id'>";
        $this->addressctrl=$ctrl->getSelectAddress(0,'Y',"",$bpartner_id);
        $this->userctrl=$ctrl->getSelectUsers(0,'Y');
     $this->getInputForm('new',0,$token);
    echo <<< EOF
            </td>
            </tr>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Contacts Name</th>
				<th style="text-align:center;">Position</th>
				<th style="text-align:center;">Department</th>
				<th style="text-align:center;">Email</th>
				<th style="text-align:center;">Tel</th>
				<th style="text-align:center;">HP No</th>
				<th style="text-align:center;">Default Level</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
	$i++;

	$contacts_id=$row['contacts_id'];
	$contacts_name=$row['contacts_name'];
	$isactive=$row['isactive'];
	$isshipment=$row['isshipment'];
	$isinvoice=$row['isinvoice'];
	$contacts_street=$row['contacts_street'];
	$contacts_postcode=$row['contacts_postcode'];
	$contacts_city=$row['contacts_city'];
	$region_id=$row['region_id'];
    $region_name=$row['region_name'];

	$country_id=$row['country_id'];
    $country_name=$row['country_name'];
	$organization_id=$row['organization_id'];
	$bpartner_id=$row['bpartner_id'];
    $greeting =$row['greeting'];
	$tel_1=$row['tel_1'];
	$hpno=$row['hpno'];
    $position=$row['position'];
    $department=$row['department'];
	$email=$row['email'];

	$defaultlevel=$row['defaultlevel'];

		if($isactive==0)
		{
            $isactive='N';
		$isactive="<b style='color:red;'>$isactive</b>";
		}
		else
		$isactive='Y';
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";


		if($contacts_type == "P")
		$contacts_type = "Standard";
		else
		$contacts_type = "Other Charges";

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$greeting $contacts_name</td>
			<td class="$rowtype" style="text-align:center;">$position</td>
			<td class="$rowtype" style="text-align:center;">$department</td>
			<td class="$rowtype" style="text-align:center;">$email</td>
			<td class="$rowtype" style="text-align:center;">$tel_1</td>
			<td class="$rowtype" style="text-align:center;">$hpno</td>
			<td class="$rowtype" style="text-align:center;">$defaultlevel</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<a href='contacts.php?action=edit&contacts_id=$contacts_id'>
				<img src="images/edit.gif"title='View this contacts'></a>
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
  public function getLatestContactsID() {
	$sql="SELECT MAX(contacts_id) as contacts_id from $this->tablecontacts;";
	$this->log->showLog(3,'Checking latest created contacts_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created contacts_id:' . $row['contacts_id']);
		return $row['contacts_id'];
	}
	return -1;

  } // end
/*

  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablecontacts
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
 public function allowDelete($contacts_id){
	$sql="SELECT count(contacts_id) as rowcount from $this->tablewarehouse where contacts_id=$contacts_id";
	$this->log->showLog(3,"Accessing ProductContacts->allowDelete to verified id:$id is deletable.");
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
	$this->contacts_code = "";
	$this->contacts_name = "";
	$this->contacts_type = "";
	$this->isactive = "null";
	$this->defaultsellaccount_id = 0;
	}


	if($this->contacts_type == "P")
	$selectedP = "selected = 'selected'";
	else if($this->contacts_type == "T")
	$selectedT = "selected = 'selected'";
	else if($this->contacts_type == "C")
	$selectedC = "selected = 'selected'";
	else if($this->contacts_type == "O")
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
	<form name="frmContacts" action="contacts.php" method="POST">
	</form>

	<form name="frmSearch" action="contacts.php" method="POST">

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
	<td class="head">Contacts Code</td>
	<td class="even"><input name="contacts_code" value="$this->contacts_code"></td>
	<td class="head">Contacts Name </td>
	<td class="even"><input name="contacts_name" value="$this->contacts_name"></td>
	</tr>

	<tr>
	<td class="head">Contacts Type</td>
	<td class="even" colspan='3'>
	<select name="contacts_type">
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
   public function allowEdit($contacts_id){
       return true;
   }
	public function getWhereStr(){

	$wherestr = "";

	if($this->contacts_code != "")
	$wherestr .= " and contacts_code like '$this->contacts_code' ";
	if($this->contacts_name != "")
	$wherestr .= " and contacts_name like '$this->contacts_name' ";
	if($this->contacts_type != "")
	$wherestr .= " and contacts_type like '$this->contacts_type' ";
	if($this->defaultsellaccount_id > 0)
	$wherestr .= " and defaultsellaccount_id = $this->defaultsellaccount_id ";
	if($this->isactive == "0" || $this->isactive == "1")
	$wherestr .= " and isactive = $this->isactive ";

	return $wherestr;

	}
*/
} // end of ClassContacts
?>

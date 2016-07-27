<?php


class Address
{

	public $address_id;
	public $address_name;
	public $isactive;
	public $isshipment;
	public $isinvoice;
	public $created;
	public $createdby;
	public $updated;
	public $updatedby;
	public $address_street;
	public $address_postcode;
	public $address_city;
	public $region_id;
	public $country_id;
	public $organization_id;
	public $bpartner_id;
	public $tel_1;
	public $tel_2;
	public $fax;
	public $description;
	public $defaultlevel;
    public $bpartnerctrl;
    public $regionctrl;
    public $countryctrl;
  public $isAdmin;

  public $orgctrl;

  public $updatesql;

  private $xoopsDB;


  private $tableaddress;
  private $tablebpartner;
  public $tablecountry;
  public $tableregion;
  private $defaultorganization_id;

  private $log;


//constructor
   public function Address(){
	global $xoopsDB,$log,$tableaddress,$tablebpartner,$defaultorganization_id,
            $tableregion,$tablecountry;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tableaddress=$tableaddress;
	$this->tablebpartner=$tablebpartner;
    $this->tableregion=$tableregion;
    $this->tablecountry=$tablecountry;
	$this->log=$log;
    $this->defaultorganization_id=$defaultorganization_id;

    $this->arrInsertField=array("address_name","isactive","isshipment","isinvoice","created",
                                "createdby","updated","updatedby","address_street","address_postcode",
	                        "address_city","region_id","country_id","organization_id","bpartner_id",
	                        "tel_1","tel_2","fax","description","defaultlevel");

    $this->arrInsertFieldType=array("%s","%d","%d","%d","%s",
                                    "%d","%s","%d","%s","%s",
                                    "%s","%d","%d","%d","%d",
                                    "%s","%s","%s","%s","%d");

    $this->arrUpdateField=array("address_name","isactive","isshipment","isinvoice",
                                "updated","updatedby","address_street","address_postcode",
	                        "address_city","region_id","country_id","organization_id","bpartner_id",
	                        "tel_1","tel_2","fax","description","defaultlevel");

    $this->arrUpdateFieldType=array("%s","%d","%d","%d",
                                    "%s","%d","%s","%s",
                                    "%s","%d","%d","%d","%d",
                                    "%s","%s","%s","%s","%d");
    $this->tablename="sim_address";

   }
/*
public function viewAddressData($address_id){
        if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$tableaddress' type='hidden'>".
		"<input name='id' value='$this->address_id' type='hidden'>".
		"<input name='idname' value='address_id' type='hidden'>".
		"<input name='title' value='Address' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";


		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableaddress' type='hidden'>".
		"<input name='id' value='$this->address_id' type='hidden'>".
		"<input name='idname' value='address_id' type='hidden'>".
		"<input name='title' value='Address' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";

		if($this->allowDelete($this->address_id))
		$deletectrl="<FORM action='address.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this address?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->address_id' name='address_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";

        if($this->allowEdit($this->address_id))
		$editctrl="<FORM action='address.php' method='POST'>
        <input type='submit' value='Edit' name='btnEdit'>".
		"<input type='hidden' value='$this->address_id' name='address_id'>".
		"<input type='hidden' value='edit' name='action'></form>";

		if($this->address_type == "P")//Standard
		$address_type = "Product";
		else if($this->address_type == "C")//Other charges
		$address_type = "Charges";

echo <<< EOF

<table style="width:140px;"><tbody><td>
        <Form action='address.php' method='POST'><input name='btnNew' value='New' type='submit'></form>
</td><td nowrap>
<form onsubmit="return validateAddress()" method="post"
 action="address.php" name="frmAddress">
<input name="reset" value="Reset" type="reset">
<input name="btnSearch" value="Search" type="button" onclick="gotoAction('search');">
</td></tbody></table>

  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">View Address Info</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" colspan="3">$this->orgctrl
	&nbsp;Active <input type="checkbox" $checked name="isactive" disabled="disabled">
	</td>
      </tr>
      <tr>
	<td class="head">Address Code</td>
	<td class="even" >$this->address_code</td>
	<td class="head">Address Name $mandatorysign</td>
	<td class="even" >$this->address_name</td>
      </tr>
    <tr>
	<td class="head">Default Level</td>
	<td class="even" >$this->defaultlevel</td>
	<td class="head">Address Type</td>
        <td class="even" >$address_type
	</td>
      </tr>

        <tr>
        <td class="head">Default Sell Account</td>
	<td class="even">$this->sellaccountname</td>
        <td class="head">Default Buy Account</td>
	<td class="even">$this->buyaccountname</td>

      </tr>
      <tr>
        <td class="head">Default Issue Account</td>
	<td class="even">$this->issueaccountname</td>
        <td class="head">Default Stock Adjust Account</td>
	<td class="even">$this->stockadjustaccountname</td>

      </tr>


    </tbody>
  </table>
<table style="width:150px;"><tbody>
        <td>$editctrl<td>$deletectrl</td><td>$recordctrl</td></tbody></table>
  <br>

EOF;
}
*/
  public function getInputForm( $type,  $address_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";

	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Address";
		$action="create";

		if($address_id==0 || $address_id==""){
			$this->address_name="";
			$this->isactive="";
			$this->defaultlevel=10;
			$this->address_type="P";
			$this->defaultsellaccount_id=0;
		}
		$savectrl="<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

		$this->address_code = getNewCode($this->xoopsDB,"address_code",$this->tableaddress);

	}
	else
	{

		$action="update";
		$savectrl="<input name='address_id' value='$this->address_id' type='hidden'>".
			 "<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";



		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableaddress' type='hidden'>".
		"<input name='id' value='$this->address_id' type='hidden'>".
		"<input name='idname' value='address_id' type='hidden'>".
		"<input name='title' value='Address' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";


		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

        if ($this->isinvoice==1)
			$isinvoicechecked="CHECKED";
		else
			$isinvoicechecked="";

       	if ($this->isshipment==1)
			$isshipmentchecked="CHECKED";
		else
			$isshipmentchecked="";
		$header="Edit Address";

		if($this->allowDelete($this->address_id))
		$deletectrl="<FORM action='address.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this address?"'.")'>
        <input type='submit' value='Delete' name='btnDelete'>
		<input type='hidden' value='$this->address_id' name='address_id'>
        <input type='hidden' value='$this->bpartner_id' name='bpartner_id'>
		<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='address.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";

		if($this->address_type == "P")//Standard
		$selectedP = "selected = 'selected'";
		else if($this->address_type == "C")//Other charges
		$selectedC = "selected = 'selected'";

	}


    echo <<< EOF

<table style="width:140px;"><tbody><td></td><td nowrap>
    <form onsubmit="return validateAddress()" method="post"
 action="address.php" name="frmAddress">
<input name="reset" value="Reset" type="reset">
</td></tbody></table>

  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
    	<td class="head">Address Name $mandatorysign</td>
    	<td class="even" >
        	<input maxlength="30" size="30" name="address_name" value="$this->address_name"></td>
       <td class="head">Active</td>
        <td class="even" > $this->bpartnerctrl / <input type="checkbox" $checked name="isactive"></td>
      </tr>
    <tr>
        <td class="head" rowspan='4'>Street</td>
        <td class="even" rowspan='4' >
            <textarea name="address_street" rows='4' cols='40'>$this->address_street</textarea>
        </td>
        <td class="head">Postcode</td>
        <td class="even" ><input name="address_postcode" value="$this->address_postcode"></td>
   </tr>
    <tr>
        <td class="head">City</td>
        <td class="even" ><input name="address_city" value="$this->address_city"></td>
   </tr>
    <tr>
        <td class="head">Region</td>
        <td class="even" >$this->regionctrl</td>
   </tr>
    <tr>
        <td class="head">Country</td>
        <td class="even" >$this->countryctrl</td>
   </tr>
    <tr>
        <td class="head">Shipment Address</td>
        <td class="even" ><input name="isshipment" $isshipmentchecked type='checkbox'></td>
        <td class="head">Billing Address</td>
        <td class="even" ><input name="isinvoice" $isinvoicechecked type='checkbox'></td>
   </tr>
    <tr>
        <td class="head">Tel 1</td>
        <td class="even" ><input name="tel_1" value="$this->tel_1"></td>
        <td class="head">Tel 2</td>
        <td class="even" ><input name="tel_2" value="$this->tel_2"></td>
   </tr>
    <tr>
        <td class="head">Default Level $mandatorysign</td>
        <td class="even" ><input maxlength="3" size="3" name='defaultlevel' value='$this->defaultlevel'></td>
        <td class="head">Fax</td>
        <td class="even" ><input name="fax" value="$this->fax"></td>
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
   * Update existing address record
   *
   * @return bool
   * @access public
   */
  public function updateAddress( ) {

    include "../simantz/class/Save_Data.inc.php";
    $timestamp= date("y/m/d H:i:s", time()) ;
    $save = new Save_Data();
    $arrvalue=array($this->address_name,$this->isactive,$this->isshipment,$this->isinvoice,
		    $this->updated,$this->updatedby,$this->address_street,$this->address_postcode,
		    $this->address_city,$this->region_id,$this->country_id,$this->organization_id,$this->bpartner_id,
		    $this->tel_1,$this->tel_2,$this->fax,$this->description,$this->defaultlevel);


    return $save->UpdateRecord($this->tablename, "address_id", $this->address_id, $this->arrUpdateField, $arrvalue,  $this->arrUpdateFieldType,$this->address_name);

  } // end of member function updateAddress

  /**
   * Save new address into database
   *
   * @return bool
   * @access public
   */
  public function insertAddress( ) {

    include "../simantz/class/Save_Data.inc.php";
    $timestamp= date("y/m/d H:i:s", time()) ;
    $save = new Save_Data();
    $arrvalue=array($this->address_name,$this->isactive,$this->isshipment,$this->isinvoice,$this->created,
		    $this->createdby,$this->updated,$this->updatedby,$this->address_street,$this->address_postcode,
		    $this->address_city,$this->region_id,$this->country_id,$this->organization_id,$this->bpartner_id,
		    $this->tel_1,$this->tel_2,$this->fax,$this->description,$this->defaultlevel);

    return $save->InsertRecord($this->tablename, $this->arrInsertField, $arrvalue, $this->arrInsertFieldType, $this->address_name,"address_id");


  } // end of member function insertAddress

  /**
   * Pull data from address table into class
   *
   * @return bool
   * @access public
   */
  public function fetchAddress( $address_id) {


	$this->log->showLog(3,"Fetching address detail into class Address.php.<br>");

	$sql="SELECT c.*
            from $this->tableaddress c
            where c.address_id=$address_id and
            c.organization_id=$this->defaultorganization_id";

	$this->log->showLog(4,"ProductAddress->fetchAddress, before execute SQL: $sql ");

	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query)){

		$this->address_id=$row['address_id'];
		$this->address_name=$row['address_name'];
		$this->isactive=$row['isactive'];
		$this->isshipment=$row['isshipment'];
		$this->isinvoice=$row['isinvoice'];
		$this->created=$row['created'];
		$this->createdby=$row['createdby'];
		$this->updated=$row['updated'];
		$this->updatedby=$row['updatedby'];
		$this->address_street=$row['address_street'];
		$this->address_postcode=$row['address_postcode'];
		$this->address_city=$row['address_city'];
		$this->region_id=$row['region_id'];
		$this->country_id=$row['country_id'];
		$this->organization_id=$row['organization_id'];
		$this->bpartner_id=$row['bpartner_id'];
		$this->tel_1=$row['tel_1'];
		$this->tel_2=$row['tel_2'];
		$this->fax=$row['fax'];
		$this->description=$row['description'];
		$this->defaultlevel=$row['defaultlevel'];


   	$this->log->showLog(4,"Address->fetchAddress,database fetch into class successfully");
	$this->log->showLog(4,"address_name:$this->address_name");

	$this->log->showLog(4,"isactive:$this->isactive");

		return true;
	}
	$this->log->showLog(4,"Address->fetchAddress,failed to fetch data into databases:" . mysql_error(). ":$sql");
	return false;


  } // end of member function fetchAddress

  /**
   * Delete particular address id
   *
   * @param int address_id
   * @return bool
   * @access public
   */
  public function deleteAddress( $address_id ) {

    
    include "../simantz/class/Save_Data.inc.php";
    $save = new Save_Data();
   
    return $save->DeleteRecord($this->tablename,"address_id",$address_id,$this->address_name,1);

  } // end of member function deleteAddress

  /**
   * Return select sql statement.
   *
   * @param string wherestring
   * @param string orderbystring
   * @param int startlimitno
   * @return string
   * @access public
   */
  public function getSQLStr_AllAddress( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductAddress->getSQLStr_AllAddress: $sql");

    $sql="SELECT ad.*, c.country_name,r.region_name FROM $this->tableaddress ad
        INNER JOIN $this->tablecountry c on c.country_id=ad.country_id
        INNER JOIN $this->tableregion r on r.region_id=ad.region_id
    	$wherestring $orderbystring";
    $this->log->showLog(4,"Generate showaddresstable with sql:$sql");

  return $sql;
  } // end of member function getSQLStr_AllAddress

 public function showAddressTable($bpartner_id,$wherestring,$orderbystring,$token){

	$this->log->showLog(3,"Showing Address Table");
	$sql=$this->getSQLStr_AllAddress($wherestring,$orderbystring);

	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
    <script type='text/javascript'>
     
        function showAddAddress(){
    
            var trShowAddAddress=document.getElementById("trShowAddAddress");
            var btnAddAddress=document.getElementById("btnAddAddress");
 
            if(trShowAddAddress.style.display=='none'){
                trShowAddAddress.style.display='';
                btnAddAddress.value="Cancel";
            }
            else{
                trShowAddAddress.style.display='none';
                btnAddAddress.value="Add New";
            }
        }
    </script>

	<table border='0' cellspacing='3'>
  		<tbody>
            <tr><th colspan='10' style='text-align:center'>Address Information
                    <Input id='btnAddAddress' value='Add New' type='button' onclick='showAddAddress()'>
                </th></tr>
            <tr id='trShowAddAddress' style='display:none'><td class='even' colspan='10'>
EOF;
        global $ctrl;
        $this->bpartnerctrl="<input 1type='hidden' name='bpartner_id' value='$bpartner_id'>";
        $this->countryctrl=$ctrl->getSelectCountry(0,'Y');
        $this->regionctrl=$ctrl->getSelectRegion(0,'Y');
     $this->getInputForm('new',0,$token);
    echo <<< EOF
            </td>
            </tr>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Address Name</th>
				<th style="text-align:center;">Street</th>
				<th style="text-align:center;">Postcode</th>
				<th style="text-align:center;">City</th>
				<th style="text-align:center;">Region</th>
				<th style="text-align:center;">Country</th>
				<th style="text-align:center;">Default Level</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
	$i++;
	
	$address_id=$row['address_id'];
	$address_name=$row['address_name'];
	$isactive=$row['isactive'];
	$isshipment=$row['isshipment'];
	$isinvoice=$row['isinvoice'];
	$address_street=$row['address_street'];
	$address_postcode=$row['address_postcode'];
	$address_city=$row['address_city'];
	$region_id=$row['region_id'];
    $region_name=$row['region_name'];

	$country_id=$row['country_id'];
    $country_name=$row['country_name'];
	$organization_id=$row['organization_id'];
	$bpartner_id=$row['bpartner_id'];
	$tel_1=$row['tel_1'];
	$fax=$row['fax'];
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


		if($address_type == "P")
		$address_type = "Standard";
		else
		$address_type = "Other Charges";

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$address_name</td>
			<td class="$rowtype" style="text-align:center;">$address_street</td>
			<td class="$rowtype" style="text-align:center;">$address_postcode</td>
			<td class="$rowtype" style="text-align:center;">$address_city</td>
			<td class="$rowtype" style="text-align:center;">$region_name</td>
			<td class="$rowtype" style="text-align:center;">$country_name</td>
			<td class="$rowtype" style="text-align:center;">$defaultlevel</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<a href='address.php?action=edit&address_id=$address_id'>
				<img src="images/edit.gif"title='View this address'></a>
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
  public function getLatestAddressID() {
	$sql="SELECT MAX(address_id) as address_id from $this->tableaddress;";
	$this->log->showLog(3,'Checking latest created address_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created address_id:' . $row['address_id']);
		return $row['address_id'];
	}
	return -1;

  } // end
/*

  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tableaddress
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
 public function allowDelete($address_id){
	$sql="SELECT count(address_id) as rowcount from $this->tablewarehouse where address_id=$address_id";
	$this->log->showLog(3,"Accessing ProductAddress->allowDelete to verified id:$id is deletable.");
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
	$this->address_code = "";
	$this->address_name = "";
	$this->address_type = "";
	$this->isactive = "null";
	$this->defaultsellaccount_id = 0;
	}


	if($this->address_type == "P")
	$selectedP = "selected = 'selected'";
	else if($this->address_type == "T")
	$selectedT = "selected = 'selected'";
	else if($this->address_type == "C")
	$selectedC = "selected = 'selected'";
	else if($this->address_type == "O")
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
	<form name="frmAddress" action="address.php" method="POST">
	</form>

	<form name="frmSearch" action="address.php" method="POST">

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
	<td class="head">Address Code</td>
	<td class="even"><input name="address_code" value="$this->address_code"></td>
	<td class="head">Address Name </td>
	<td class="even"><input name="address_name" value="$this->address_name"></td>
	</tr>

	<tr>
	<td class="head">Address Type</td>
	<td class="even" colspan='3'>
	<select name="address_type">
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
   public function allowEdit($address_id){
       return true;
   }
	public function getWhereStr(){

	$wherestr = "";

	if($this->address_code != "")
	$wherestr .= " and address_code like '$this->address_code' ";
	if($this->address_name != "")
	$wherestr .= " and address_name like '$this->address_name' ";
	if($this->address_type != "")
	$wherestr .= " and address_type like '$this->address_type' ";
	if($this->defaultsellaccount_id > 0)
	$wherestr .= " and defaultsellaccount_id = $this->defaultsellaccount_id ";
	if($this->isactive == "0" || $this->isactive == "1")
	$wherestr .= " and isactive = $this->isactive ";

	return $wherestr;

	}
*/
} // end of ClassAddress
?>

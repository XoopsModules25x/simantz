<?php
/************************************************************************
Class Vendor.php - Copyright kfhoo
**************************************************************************/

class Vendor
{
  public $vendor_id;
  public $vendor_no;
  public $vendor_name;
  public $vendor_hpno;
  public $vendor_telno;
  public $vendor_faxno;
  public $vendor_street1;
  public $vendor_street2;
  public $vendor_country;
  public $vendor_state;
  public $vendor_city;
  public $vendor_postcode;
  public $vendor_pic;
  public $terms_id;
  public $vendor_remarks;

  public $organization_id;
  public $created;
  public $updated;
  public $createdby;
  public $updatedby;
  public $isactive;
  public $cur_name;
  public $cur_symbol;
  
  public $isAdmin;
  public $orgctrl;
  public $customerctrl;
  public $productctrl;
  public $termsctrl;

  public $tablevendor;
  public $tablevinvoice;

  
  public $tableprefix;
  public $filename;

  public function Vendor($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablevendor=$tableprefix."simsalon_vendor";
	$this->tablevinvoice=$tableprefix."simsalon_vinvoice";
	$this->log=$log;
  }


  public function insertVendor( ) {
	$this->log->showLog(3,"Creating product SQL:$sql");

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new product $this->vendor_no");
	$sql =	"INSERT INTO $this->tablevendor 	(vendor_no,vendor_name,vendor_hpno,
							vendor_telno,vendor_faxno,vendor_street1,vendor_street2,vendor_country,vendor_state,vendor_city,
							vendor_postcode,vendor_remarks,vendor_pic,terms_id,
							isactive,created,createdby,updated,updatedby,organization_id) 
							values('$this->vendor_no',
								'$this->vendor_name',
								'$this->vendor_hpno',
								'$this->vendor_telno',
								'$this->vendor_faxno',
								'$this->vendor_street1',
								'$this->vendor_street2',
								'$this->vendor_country',
								'$this->vendor_state',
								'$this->vendor_city',								
								'$this->vendor_postcode',
								'$this->vendor_remarks',
								'$this->vendor_pic',
								$this->terms_id,
		'$this->isactive','$timestamp',$this->createdby,'$timestamp',$this->updatedby,$this->organization_id)";

	$this->log->showLog(4,"Before insert product SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert vendor name '$vendor_name'");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new vendor name '$vendor_name' successfully"); 
		return true;
	}
  } // end of member function insertClassMaster

  /**
   * Update class information
   *
   * @return bool
   * @access public
   */
  public function updateVendor() {
    $timestamp= date("y/m/d H:i:s", time()) ;
	$sql="";
	
 	$sql=	"UPDATE $this->tablevendor SET
		vendor_no='$this->vendor_no',
		vendor_name='$this->vendor_name',
		vendor_hpno='$this->vendor_hpno',
		vendor_telno='$this->vendor_telno',
		vendor_faxno='$this->vendor_faxno',
		vendor_street1='$this->vendor_street1',
		vendor_street2='$this->vendor_street2',
		vendor_country='$this->vendor_country',
		vendor_state='$this->vendor_state',
		vendor_city='$this->vendor_city',		
		vendor_postcode='$this->vendor_postcode',
		vendor_remarks='$this->vendor_remarks',
		vendor_pic='$this->vendor_pic',
		terms_id=$this->terms_id,
		updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id

		WHERE vendor_id='$this->vendor_id'";

	$this->log->showLog(3, "Update vendor_id: $this->vendor_id, '$this->vendor_name'");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update product failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update product successfully.");
		return true;
	}
  } // end of member function updateClass

  /**
   * Return sql select statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return 
   * @access public
   */
  public function getSqlStr_AllVendor( $wherestring,  $orderbystring,  $startlimitno ) {
  
    $sql= 	"SELECT * FROM $this->tablevendor a
		$wherestring $orderbystring";

   $this->log->showLog(4,"Running Vendor->getSQLStr_AllVendor: $sql");
  return $sql;
  } // end of member function getSqlStr_AllClass

  /**
   * pull data from database into class.
   *
   * @param int masterclass_id 
   * @return bool
   * @access public
   */
  public function fetchVendorInfo( $vendor_id ) {
    
	$this->log->showLog(3,"Fetching product detail into class Vendor.php.<br>");
		
	$sql="SELECT * FROM $this->tablevendor
	where vendor_id=$vendor_id";
	
	$this->log->showLog(4,"Vendor->fetchVendorInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->vendor_id=$row["vendor_id"];
		$this->vendor_no=$row["vendor_no"];
		$this->vendor_name= $row['vendor_name'];
		$this->vendor_hpno= $row['vendor_hpno'];
		$this->vendor_telno=$row['vendor_telno'];
		$this->vendor_faxno=$row['vendor_faxno'];
		$this->vendor_street1=$row['vendor_street1'];
		$this->vendor_remarks=$row['vendor_remarks'];
		$this->vendor_pic=$row['vendor_pic'];
		$this->terms_id=$row['terms_id'];

		$this->vendor_street2=$row['vendor_street2'];
		$this->vendor_country=$row['vendor_country'];
		$this->vendor_state=$row['vendor_state'];
		$this->vendor_city=$row['vendor_city'];		
		$this->vendor_postcode=$row['vendor_postcode'];
		$this->organization_id=$row['organization_id'];
		$this->isactive=$row['isactive'];
	
	   	$this->log->showLog(4,"Vendor->fetchVendorInfo,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Vendor->fetchVendorInfo,failed to fetch data into databases.");	
	}
  } // end of member function fetchVendorInfo


  public function getInputForm( $type,  $vendor_id,$token ) {
	$filectrl="";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$uploadctrl="";
	$option1 = "";
	$option2 = "";
	$option3 = "";

	if ($type=="new"){
		$header="New Organization";
		$action="create";
		if($vendor_id==0){
		$this->vendor_name="";
		$this->vendor_no="";
		$this->organization=0;
		}

		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";

		$this->vendor_no = getNewCode($this->xoopsDB,"vendor_no",$this->tablevendor);
	}
	else
	{
		$action="update";
		$savectrl="<input name='vendor_id' value='$this->vendor_id' type='hidden'>".
			 "<input style='height:40px;' name='submit' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablevendor' type='hidden'>".
		"<input name='id' value='$this->vendor_id' type='hidden'>".
		"<input name='idname' value='vendor_id' type='hidden'>".
		"<input name='title' value='Vendor' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		


		$header="Edit Vendor";
		if($this->allowDelete($this->vendor_id) && $this->vendor_id>0)
		$deletectrl="<FORM action='vendor.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this product?"'.")'><input style='height:40px;' type='submit' value='Delete' name='submit' style='height:40px;'>".
		"<input type='hidden' value='$this->vendor_id' name='vendor_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

		$addnewctrl="<form action='vendor.php' method='post'><input type='submit' value='New' value='New'></form>";
			
		if($this->vendor_hpno=="S")
		$option1 = "SELECTED";
		elseif($this->vendor_hpno=="U")
		$option2 = "SELECTED";
		else
		$option3 = "SELECTED";

	}

    echo <<< EOF
<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateVendor()" method="post"
 action="vendor.php" name="frmVendor"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>

 <table cellspacing='3' border='1'>
  <tbody>
    <tr>
      <th>Description</th>
      <th>Data</th>
      <th>Description</th>
      <th>Data</th>
    </tr>
    <tr>
      <td class="head">Vendor No</td>
      <td class="odd"><input name="vendor_no" value="$this->vendor_no" maxlength='10' size='10'>&nbsp;&nbsp;Active&nbsp;&nbsp;<input type="checkbox" $checked name="isactive" ></td>
		<td class="head">Contact Name</td>
		<td class="even"><input name="vendor_pic"  maxlength="20" size="20"  value="$this->vendor_pic" ></td>
	</tr>
	<tr>
      <td class="head">Company Name</td>
      <td class="odd" colspan="3"><input name="vendor_name" value="$this->vendor_name"  maxlength='100' size='60'></td>
    </tr>

    <tr>
      	<td class="head">HP No</td>
      	<td class="even"><input name="vendor_hpno"  maxlength="20" size="20"  value="$this->vendor_hpno" ></td>
      	<td class="head">Tel No</td>
      	<td class="even"><input name="vendor_telno"  maxlength="20" size="20"  value="$this->vendor_telno" ></td>
    </tr>
    <tr>
		<td class="head">Fax No</td>
		<td class="odd"><input name="vendor_faxno"  maxlength="20" size="20"  value="$this->vendor_faxno" ></td>
		<td class="head">Payment Terms</td>
		<td class="odd">$this->termsctrl</td>

    </tr>

	<tr>
		<td class="head">Street 1</td>
      		<td class="even"><input name="vendor_street1" maxlength="100" size="35" value="$this->vendor_street1" ></td>
		<td class="head">Street 2</td>
      		<td class="even"><input name="vendor_street2" maxlength="100" size="35"  value="$this->vendor_street2" ></td>

    	</tr>
	
	<tr>
		<td class="head">Postcode</td>
		<td class="odd"><input name="vendor_postcode"  maxlength="20" size="20"  value="$this->vendor_postcode" ></td>
		<td class="head">City</td>
   		<td class="odd"><input name="vendor_city" maxlength="30" size="20"  value="$this->vendor_city" ></td>
    	</tr>

	<tr>
				<td class="head">State</td>
   		<td class="even"><input name="vendor_state" maxlength="30" size="20"  value="$this->vendor_state" ></td>

		<td class="head">Country</td>
      		<td class="even"><input name="vendor_country" maxlength="20" size="20" value="$this->vendor_country" ></td>
		
    	</tr>

	 <tr>	
	 	<td class="head">Remarks</td>
      		<td class="odd" colspan="3"><textarea name="vendor_remarks" cols="60" rows="1">$this->vendor_remarks</textarea></td>
		<td class="head" style="display:none">Organization</td>
		<td class="odd" style="display:none">$this->orgctrl</td>
	</tr>
	
  </tbody>
</table>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td></tbody></table>
$recordctrl
EOF;

  } // end of member function getInputForm

  /**
   *
   * @param int productmaster_id 
   * @return bool
   * @access public
   */
  public function deleteVendor( $productmaster_id ) {
   	$this->log->showLog(2,"Warning: Performing delete product id : $this->vendor_id !");
	$sql="DELETE FROM $this->tablevendor where vendor_id=$this->vendor_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: product ($vendor_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Vendor ($vendor_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteVendorMaster


/**
   * Display a product list table
   *
   * 
   * @access public
   */
public function showVendorTable($wherestr=""){
	
	$this->log->showLog(3,"Showing Vendor Table");
	$sql=$this->getSQLStr_AllVendor("where vendor_id>0 $wherestr ","ORDER BY vendor_no",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Vendor No</th>
				<th style="text-align:center;">Name</th>
				<th style="text-align:center;">HP No</th>
				<th style="text-align:center;">Fax No</th>
				<th style="text-align:center;">Tel No</th>
				<th style="text-align:center;">Street 1</th>
				<th style="text-align:center;">Street 2</th>
				<th style="text-align:center;">PIC</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$vendor_id=$row['vendor_id'];
		$vendor_no=$row['vendor_no'];
		$vendor_name=$row['vendor_name'];
		$vendor_hpno=$row['vendor_hpno'];
		$vendor_telno=$row['vendor_telno'];
		$vendor_faxno=$row['vendor_faxno'];
		$vendor_street1=$row['vendor_street1'];
		$vendor_street2=$row['vendor_street2'];
		$vendor_country=$row['vendor_country'];
		$vendor_state=$row['vendor_state'];
		$vendor_city=$row['vendor_city'];		
		$vendor_postcode=$row['vendor_postcode'];
		$vendor_pic=$row['vendor_pic'];
		$terms_id=$row['terms_id'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];
		$category_name=$row['category_description'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$vendor_no</td>
			<td class="$rowtype" style="text-align:center;">$vendor_name</td>
			<td class="$rowtype" style="text-align:center;">$vendor_hpno</td>
			<td class="$rowtype" style="text-align:center;">$vendor_telno</td>
			<td class="$rowtype" style="text-align:center;">$vendor_faxno</td>
			<td class="$rowtype" style="text-align:center;">$vendor_street1</td>
			<td class="$rowtype" style="text-align:center;">$vendor_street2</td>
			<td class="$rowtype" style="text-align:center;">$vendor_pic</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="vendor.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this record'>
				<input type="hidden" value="$vendor_id" name="vendor_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

/**
   * get latest generated product
   * 
   * return int  vendor_id (latest)
   * @access public
   */
  public function getLatestVendorID(){
  	$sql="SELECT MAX(vendor_id) as vendor_id from $this->tablevendor;";
	$this->log->showLog(3, "Retrieveing last product id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['vendor_id'];
	else
	return -1;
	

  }


public function getSelectVendor($id,$isitem='NY',$calledfunction="") {

	$wherestring="";
	
	$wherestring=" WHERE (p.isactive='Y')";

 	$sql="SELECT p.vendor_id,p.vendor_name from $this->tablevendor p
		$wherestring order by vendor_name ;";

	$this->log->showLog(4,"Excute SQL for generate product list: $sql;");
	$selectctl="<SELECT name='vendor_id' $calledfunction>";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$vendor_id=$row['vendor_id'];
		$vendor_name=$row['vendor_name'];
	
		if($id==$vendor_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$vendor_id' $selected>$vendor_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getVendorPrice($id){
	$this->log->showLog(3,"Retrieving default price for product $id");
	$sql="SELECT vendor_name,amt from $this->tablevendor where vendor_id=$id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$price=$row['amt'];
		$vendor_name=$row['vendor_name'];
		$this->log->showLog(3,"vendor_id: have productname: $vendor_name with vendor_id: $id");
		return $price;
	
	}
	else
	{
		$this->log->showLog(1,"Error, can't find vendor_id: $id");
		return 0;
	}
	


  }
  public function savefile($tmpfile,$newfilename){
	move_uploaded_file($tmpfile, "upload/products/$newfilename");
	$sqlupdate="UPDATE $this->tablevendor set filename='$newfilename' where vendor_id=$vendor_id";
	$qryUpdate=$this->xoopsDB->query($sqlupdate);
  }

  public function deletefile($vendor_id){
	$sql="SELECT filename from $this->tablevendor where vendor_id=$vendor_id";
	$query=$this->xoopsDB->query($sql);
	$myfilename="";
	if($row=$this->xoopsDB->fetchArray($query)){
		$myfilename=$row['filename'];
	}
	$myfilename="upload/products/$myfilename";
	$this->log->showLog(3,"This file name: $myfilename");
	unlink("$myfilename ");
	$sqlupdate="UPDATE $this->tablevendor set filename='-' where vendor_id=$vendor_id";
	$qryDelete=$this->xoopsDB->query($sqlupdate);
  }

  public function allowDelete($vendor_id){

	$val = true;
	$tablelink = array($this->tablevinvoice);
	
	$count = count($tablelink);
	$i = 0;
	while($i<$count){
	

	$sql = "SELECT count(*) as rowcount from $tablelink[$i] where vendor_id = $vendor_id ";
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
  
  }

  public function searchAToZ(){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search customer easily. With function searchAToZ()");

	
	$sqlfilter="SELECT DISTINCT(LEFT(vendor_name,1)) as shortname FROM $this->tablevendor b $wherestring order by b.vendor_name";

	$this->log->showLog(4,"With SQL:$sqlfilter");
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	$firstname="";
	
	
	echo "<b>Vendor Grouping By Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if secretarial never do filter yet, if will choose 1st secretarial listing
		
		echo "<A style='font-size:12;' href='vendor.php?filterstring=$shortname'>  $shortname  </A> ";
	}
	
	$this->log->showLog(3,"Complete generate list of short cut");
		echo <<<EOF
<BR>


EOF;
return $filterstring;
  }


} // end of VendorMaster
?>

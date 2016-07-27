<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class Company
{

public	$company_id;
public	$company_no;
public	$company_name;
public	$street1;
public	$street2;
public	$postcode;
public	$city;
public	$state1;
public	$country;
public	$contactperson;
public	$contactperson_no;
public	$tel1;
public	$tel2;
public	$fax;
public	$description;
public	$created;
public	$createdby;
public	$updated;
public	$updatedby;
public	$isactive;
public  $currency_id;
public  $currencyctrl;
public  $isdefault;
public  $xoopsDB;
public  $tableprefix;
public  $tablecompany;
public  $tableworkercompany;
public $tablecurrency;
public  $log;


//constructor
   public function Company($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablecompany=$tableprefix."simfworker_company";
	$this->tableworkercompany=$tableprefix."simfworker_workercompany";
	$this->tablecurrency=$tableprefix."simfworker_currency";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int company_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $company_id, $token  ) {

   	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	

	$this->created=0;
	if ($type=="new"){
		$header="New Company";
		$action="create";
	 	
		if($company_id==0){
			$this->company_no=$this->getNewCompany();
			$this->company_name="";
			$this->description="";
			$this->isactive=0;
			

		}
	

		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$defaultchecked="";
		$deletectrl="";

		$this->currency="MYR";

	}
	else
	{
		
		$action="update";
		$savectrl="<input name='company_id' value='$this->company_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

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
	
		$header="Edit Company";
		
		if($this->allowDelete($this->company_id))
		$deletectrl="<FORM action='company.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this company?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->company_id' name='company_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else

		$deletectrl="";
	
	}

    echo <<< EOF


<table style="width:140px;"><tbody><td><form onsubmit="return validateCompany()" method="post"
 action="company.php" name="frmCompany"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
        <tr>
        <td class="head">Company No</td>
        <td class="odd" ><input name='company_no' value="$this->company_no" maxlength='10' size='15'> 
				
	</td>
 
        <td class="head">Company Name</td>
        <td class="odd"><input maxlength="40" size="50" name="company_name" value="$this->company_name"></td>
      </tr>
	<tr>
		<td class="head">Contact Person</td>
		<td  class="even"><input maxlength="40" size="50" name="contactperson" value="$this->contactperson"></td>
		<td class="head">Contact No</td>
		<td  class="even"><input maxlength="16" size="16" name="contactperson_no" value="$this->contactperson_no"></td>
	</tr>
<tr>
		<td class="head">Active</td>
		<td  class="odd"> <input type='checkbox' $checked name='isactive'></td>
		<td class="head">Default</td>
		<td  class="odd"> <input type='checkbox' $defaultchecked name='isdefault'></td>
	</tr>
	<tr>
		<td class="head">Street 1</td>
		<td  class="even"><input maxlength="50" size="50" name="street1" value="$this->street1"></td>
		<td class="head">Street 2</td>
		<td  class="even"><input maxlength="50" size="50" name="street2" value="$this->street2"></td>
	</tr>
	<tr>
		<td class="head">Postcode</td>
		<td  class="odd"><input maxlength="5" size="5" name="postcode" value="$this->postcode"></td>
		<td class="head">City</td>
		<td  class="odd"><input maxlength="30" size="30" name="city" value="$this->city"></td>
	</tr>
	<tr>
		<td class="head">State</td>
		<td  class="even"><input maxlength="30" size="30" name="state1" value="$this->state1"></td>
		<td class="head">Country</td>
		<td  class="even"><input maxlength="20" size="20" name="country" value="$this->country"></td>
	</tr>
	<tr>
		<td class="head">Tel 1</td>
		<td  class="even"><input maxlength="16" size="16" name="tel1" value="$this->tel1"></td>
		<td class="head">Tel 2</td>
		<td  class="even"><input maxlength="16" size="16" name="tel2" value="$this->tel2"></td>
	</tr>
	<tr>
		<td class="head">Fax</td>
		<td  class="odd"><input maxlength="16" size="16" name="fax" value="$this->fax"></td>
		<td class="head">Currency</td>
		<td  class="odd">$this->currencyctrl</td>

	</tr>
      <tr>
        <td class="head">Company Description <br>(Max 255)</td>
        <td class="even" colspan="3">
		<textarea  name="description" cols='100' maxlength='200' rows='5'>$this->description</textarea></td>
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

 
  public function updateCompany( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablecompany SET ".
	"company_no='$this->company_no',company_name='$this->company_name',".
	"street1='$this->street1',street2='$this->street2',postcode='$this->postcode',city='$this->city', ".
	"state1='$this->state1',country='$this->country',contactperson='$this->contactperson',".
	"contactperson_no='$this->contactperson_no',tel1='$this->tel1',tel2='$this->tel2',fax='$this->fax',".
	"description='$this->description',updated='$timestamp',updatedby=$this->updatedby,isactive=$this->isactive,".
	"isdefault=$this->isdefault,currency_id='$this->currency_id' WHERE company_id='$this->company_id'";
	
	$this->log->showLog(3, "Update company_id: $this->company_id, $this->company_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update company failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update company successfully.");
		return true;
	}
  } // end of member function updateCompany


  public function insertCompany( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new company $this->company_name");
 	$sql="INSERT INTO $this->tablecompany ".
		"(company_no,company_name,street1,street2,".
		"postcode,city,state1,country,".
		"contactperson,contactperson_no,tel1,tel2,fax,description,".
		"created,createdby,updated,updatedby,isactive,isdefault,currency_id".
		") values(".
		"'$this->company_no','$this->company_name','$this->street1','$this->street2',".
		"'$this->postcode','$this->city','$this->state1','$this->country',".
		"'$this->contactperson','$this->contactperson_no','$this->tel1','$this->tel2','$this->fax',".
		"'$this->description',".
		"$this->createdby,'$timestamp',$this->updatedby,'$timestamp',$this->isactive,$this->isdefault,'$this->currency_id')";
	$this->log->showLog(4,"Before insert company SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert company code $company_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new company $company_name successfully"); 
		return true;
	}
  } // end of member function insertCompany


  public function fetchCompany( $company_id) {
    
	$this->log->showLog(3,"Fetching company detail into class Company.php.<br>");
		
	$sql="SELECT company_no,company_name,street1,street2,".
		"postcode,city,state1,country,".
		"contactperson,contactperson_no,tel1,tel2,fax,description,".
		"created,createdby,updated, updatedby, isactive, isdefault,currency_id from $this->tablecompany ". 
			"where company_id=$company_id";
	
	$this->log->showLog(4,"ProductCompany->fetchCompany, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$this->company_no=$row['company_no'];
	$this->company_name=$row['company_name'];
	$this->street1=$row['street1'];
	$this->street2=$row['street2'];
	$this->postcode=$row['postcode'];
	$this->city=$row['city'];
	$this->state1=$row['state1'];
	$this->country=$row['country'];
	$this->contactperson=$row['contactperson'];
	$this->contactperson_no=$row['contactperson_no'];
	$this->tel1=$row['tel1'];
	$this->tel2=$row['tel2'];
	$this->fax=$row['fax'];
	$this->description=$row['description'];
	$this->isactive=$row['isactive'];
	$this->isdefault=$row['isdefault'];
	$this->currency_id=$row['currency_id'];

   	$this->log->showLog(4,"Company->fetchCompany,database fetch into class successfully");	
	$this->log->showLog(4,"company_name:$this->company_name");
	$this->log->showLog(4,"description:$this->description");
	$this->log->showLog(4,"isactive:$this->isactive");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Company->fetchCompany,failed to fetch data into databases.");	
	}
  } // end of member function fetchCompany

  public function deleteCompany( $company_id ) {
    	$this->log->showLog(2,"Warning: Performing delete company id : $company_id !");
	$sql="DELETE FROM $this->tablecompany where company_id=$company_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: company ($company_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"company ($company_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteCompany

  
  public function getSQLStr_AllCompany( $wherestring,  $orderbystring,  $startlimitno,$recordcount ) {

    $sql="SELECT c.company_id,c.company_no,c.company_name,c.street1,c.street2,".
		"c.postcode,c.city,c.state1,c.country,".
		"c.contactperson,c.contactperson_no,c.tel1,c.tel2,c.fax,c.description,".
		"c.created,c.createdby,c.updated, c.updatedby, c.isactive, c.isdefault,c.currency_id, ".
		"cr.currency_symbol FROM $this->tablecompany c " .
		"left join $this->tablecurrency cr on c.currency_id = cr.currency_id ".
	" $wherestring $orderbystring LIMIT $startlimitno,$recordcount";
  $this->log->showLog(4,"Running ProductCompany->getSQLStr_AllCompany: $sql"); 
 return $sql;
  } // end of member function getSQLStr_AllCompany

 public function showCompanyTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0){
	$this->log->showLog(3,"Showing Company Table");
	$sql=$this->getSQLStr_AllCompany($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Company No</th>
				<th style="text-align:center;">Company Name</th>
				<th style="text-align:center;">Company Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$company_id=$row['company_id'];
		$company_no=$row['company_no'];
		$company_name=$row['company_name'];
		$description=$row['description'];

		$isactive=$row['isactive'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$company_no</td>
			<td class="$rowtype" style="text-align:center;">$company_name</td>
			<td class="$rowtype" style="text-align:center;">$description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="company.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this company'>
				<input type="hidden" value="$company_id" name="company_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

  public function getLatestCompanyID() {
	$sql="SELECT MAX(company_id) as company_id from $this->tablecompany;";
	$this->log->showLog(3,'Checking latest created company_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created company_id:' . $row['company_id']);
		return $row['company_id'];
	}
	else
	return -1;
	
  } // end
  public function getNewCompany() {
	$sql="SELECT MAX(company_no) as company_no from $this->tablecompany;";
	$this->log->showLog(3,'Checking latest created company_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created company_no:' . $row['company_no']);
		$company_no=$row['company_no']+1;
		return $company_no;
	}
	else
	return 0;
	
  } // end

  public function getSelectCompany($id) {
	
	$sql="SELECT company_id,company_name from $this->tablecompany where isactive=1 or company_id=$id " .
		" order by isdefault, company_name";
	$selectctl="<SELECT name='company_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$company_id=$row['company_id'];
		$company_name=$row['company_name'];
	
		if($id==$company_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$company_id' $selected>$company_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end


  public function allowDelete($id){
	$sql="SELECT count(company_id) as rowcount from $this->tableworkercompany where company_id=$id";
	$this->log->showLog(3,"Accessing ProductCompany->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this company, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this company, record deletable");
		return true;
		}
	}

 public function showCompanyHeader($worker_id){
	if($this->fetchWorker($worker_id)){
		$this->log->showLog(4,"Showing company header successfully.");
	echo <<< EOF
	<table border='1' cellspacing='3'>
		<tbody>
			<tr>
				<th colspan="4">Company Info</th>
			</tr>
			<tr>
				<td class="head">Company No</td>
				<td class="odd">$this->company_no</td>
				<td class="head">Company Name</td>
				<td class="odd"><A href="company.php?action=edit&company_id=$company_id" 
						target="_blank">$this->company_name</A></td>
			</tr>
		</tbody>
	</table>
EOF;
	}
	else{
		$this->log->showLog(1,"<b style='color:red;'>Showing worker header failed.</b>");
	}

   }//showRegistrationHeader
 public function searchAToZ(){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search worker easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(company_name,1)) as shortname FROM $this->tablecompany where isactive='1' order by company_name";
	$this->log->showLog(4,"With SQL:$sqlfilter");
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	$firstname="";
	echo "<b>Customer Grouping By Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if customer never do filter yet, if will choose 1st customer listing
		
		echo "<A style='font-size:12;' href='company.php?filterstring=$shortname'>  $shortname  </A> ";
	}
	
	$this->log->showLog(3,"Complete generate list of short cut");
		echo <<<EOF
<BR>
<A href='company.php?action=new' style='color: GRAY'> [ADD NEW CUSTOMER]</A>
<A href='company.php?action=showSearchForm' style='color: gray'> [SEARCH CUSTOMER]</A>

EOF;
return $filterstring;
  }
 public function showSearchForm(){

   echo <<< EOF

	<FORM action="company.php" method="POST">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criteria</th>
	    </tr>
	    <tr>
	      <td class='head'>Company No</td>
	      <td class='even'><input name='worker_code' value='$this->worker_code'> (%, AB%,%AB,%A%B%)</td>
	      <td class='head'>Company Name</td>
	      <td class='even'><input name='worker_name' value='$this->worker_name'>%ali, %ali%, ali%, %ali%bin%</td>
	    </tr>
	    <tr>
	      <td class='head'>Quick Search</td>
	      <td class='odd'>$this->companyctrl</td>
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
	      <td><input style="height:40px;" type='submit' value='Search' name='submit'><input type='hidden' name='action' value='search'></td>
	      <td><input type='reset' value='Reset' name='reset'></td>
	    </tr>
	  </tbody>
	</table>
	</FORM>
EOF;
  }

  public function convertSearchString($company_id,$company_no,$company_name,$isactive){
$filterstring="";

if($company_id > 0 ){
	$filterstring=$filterstring . " c.company_id=$company_id AND";
}

if($company_no!=""){
	$filterstring=$filterstring . " c.company_no LIKE '$company_no' AND";
}

if($worker_name!=""){
	$filterstring=$filterstring . "  c.company_name LIKE '$company_name' AND";
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

} // end of ClassCompany
?>

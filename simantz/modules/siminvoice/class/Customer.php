<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class Customer
{

public	$customer_id;
public	$customer_no;
public	$customer_name;
public	$customer_street1;
public	$customer_street2;
public	$customer_postcode;
public	$customer_city;
public	$customer_state;
public	$customer_country;
public	$customer_tel1;
public	$customer_tel2;
public	$customer_fax;
public	$customer_contactperson;
public	$customer_contactno;
public	$customer_contactnohp;
public	$customer_contactfax;
public	$customer_desc;
public	$terms_id;
public	$customer_accbank;
public	$customer_bank;
public	$customerctrl;
public	$termsctrl;
public	$statectrl;

public	$created;
public	$createdby;
public	$updated;
public	$updatedby;
public	$isactive;

public  $xoopsDB;
public  $tableprefix;
public  $tablecustomer;
public  $tableinvoice;
public  $tablequotation;
public  $log;



//constructor
   public function Customer($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablecustomer=$tableprefix."tblcustomer";
	$this->tableinvoice=$tableprefix."tblinvoice";
	$this->tablestate=$tableprefix."tblstate";
	$this->tablequotation=$tableprefix."tblquotation";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int customer_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $customer_id, $token  ) {

   $header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	

	$this->created=0;
	if ($type=="new"){
		$header="New Customer";
		$action="create";
	 	
		if($customer_id==0){
			$this->customer_no=$this->getNewCustomer();
			$this->customer_name="";
			$this->isactive=0;
			

		}
	

		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$defaultchecked="";
		$deletectrl="";


	}
	else
	{
		
		$action="update";
		$savectrl="<input name='customer_id' value='$this->customer_id' type='hidden'>".
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
	
		$header="Edit Customer";
		
		if($this->allowDelete($this->customer_id))
		$deletectrl="<FORM action='customer.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this customer?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->customer_id' name='customer_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else

		$deletectrl="";
	
	}
//$areactrl=$this->getStateList();

    echo <<< EOF


<table style="width:140px;"><tbody><td><form onsubmit="return validateCustomer()" method="post"
 action="customer.php" name="frmCustomer"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        	<td class="head">Customer No *</td>
        	<td class="odd" ><input name='customer_no' value="$this->customer_no" maxlength='10' size='15'> </td>
        	<td class="head">Customer Name *</td>
        	<td class="odd"><input maxlength="100" size="50" name="customer_name" value="$this->customer_name"></td>
      </tr>
      
		<tr>
			<td class="head">Active</td>
			<td  class="odd"> <input type='checkbox' $checked name='isactive'></td>
			<td class="head">Contact Person</td>
			<td  class="odd"><input maxlength="30" size="30" name="customer_contactperson" value="$this->customer_contactperson"></td>
		</tr>
	
	<tr>
		<td class="head">Contact Person Tel No (HP)</td>
		<td  class="odd"><input maxlength="20" size="20" name="customer_contactnohp" value="$this->customer_contactnohp"></td>
		<td class="head">Contact Person Tel No</td>
		<td  class="odd"><input maxlength="20" size="20" name="customer_contactno" value="$this->customer_contactno"></td>
	</tr>
	
	<tr>
		<td class="head">Tel No. 1</td>
		<td  class="odd"><input maxlength="20" size="20" name="customer_tel1" value="$this->customer_tel1"></td>
		<td class="head">Tel No. 2</td>
		<td  class="odd"><input maxlength="30" size="30" name="customer_tel2" value="$this->customer_tel2"></td>
	</tr>
	
	<tr>
		<td class="head">Fax No</td>
		<td  class="odd"><input maxlength="20" size="20" name="customer_contactfax" value="$this->customer_contactfax"></td>
		<td class="head">Terms</td>
		<td  class="odd">$this->termsctrl</td>
	</tr>
	
	<tr>

		<td class="head">Account No</td>
		<td  class="odd"><input maxlength="20" size="20" name="customer_accbank" value="$this->customer_accbank"></td>
		<td class="head">Bank Name</td>
		<td  class="odd"><input maxlength="30" size="30" name="customer_bank" value="$this->customer_bank"></td>
	</tr>
	
	<tr>
		<td class="head">Street 1</td>
		<td  class="odd"><input maxlength="100" size="30" name="customer_street1" value="$this->customer_street1"></td>
		<td class="head">Street 2</td>
		<td  class="odd"><input maxlength="100" size="30" name="customer_street2" value="$this->customer_street2"></td>
	</tr>
	
	<tr>
		<td class="head">Postcode</td>
		<td  class="odd"><input maxlength="30" size="15" name="customer_postcode" value="$this->customer_postcode"></td>
		<td class="head">City</td>
		<td  class="odd"><input maxlength="30" size="30" name="customer_city" value="$this->customer_city"></td>
	</tr> 
	
	<tr>
		<td class="head">State</td>
		<td  class="odd"><input maxlength="30" size="30" name="customer_state" value="$this->customer_state"></td>
		<td class="head">Country</td>
		<td  class="odd"><input maxlength="30" size="30" name="customer_country" value="$this->customer_country"></td>
	</tr> 
		
	<tr>
		<td class="head">Description</td>
		<td colspan='3' class="odd"><textarea  name="customer_desc" cols='80' maxlength='200' rows='5'>$this->customer_desc</textarea></td>
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

 
  public function updateCustomer( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablecustomer SET
	customer_no='$this->customer_no',
	customer_name='$this->customer_name',
	customer_street1='$this->customer_street1',
	customer_street2='$this->customer_street2',
	customer_postcode='$this->customer_postcode',
	customer_city='$this->customer_city',
	customer_state='$this->customer_state',
	customer_country='$this->customer_country',
	customer_tel1='$this->customer_tel1',
	customer_tel2='$this->customer_tel2',
	customer_fax='$this->customer_fax',
	customer_contactperson='$this->customer_contactperson',
	customer_contactno='$this->customer_contactno',
	customer_contactnohp='$this->customer_contactnohp',
	customer_contactfax='$this->customer_contactfax',
	customer_desc='$this->customer_desc',
	terms_id=$this->terms_id,
	customer_accbank='$this->customer_accbank',
	customer_bank='$this->customer_bank',
	updated='$timestamp',
	updatedby=$this->updatedby,
	isactive=$this->isactive
	WHERE customer_id=$this->customer_id";
	
	$this->log->showLog(3, "Update customer_id: $this->customer_id, $this->customer_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update customer failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update customer successfully.");
		return true;
	}
  } // end of member function updateCustomer


  public function insertCustomer( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new customer $this->customer_name");
 	$sql="INSERT INTO $this->tablecustomer 
 			(customer_no,customer_name,customer_street1,customer_street2,customer_postcode,customer_city,customer_state,customer_country,customer_tel1,customer_tel2,customer_fax,customer_contactperson,customer_contactno,customer_contactnohp,customer_contactfax,customer_desc,terms_id,customer_accbank,customer_bank,createdby,created,updatedby,updated,isactive) 
 			values 	('$this->customer_no',
						'$this->customer_name',
						'$this->customer_street1',
						'$this->customer_street2',
						'$this->customer_postcode',
						'$this->customer_city',
						'$this->customer_state',
						'$this->customer_country',
						'$this->customer_tel1',
						'$this->customer_tel2',
						'$this->customer_fax',
						'$this->customer_contactperson',
						'$this->customer_contactno',
						'$this->customer_contactnohp',
						'$this->customer_contactfax',
						'$this->customer_desc',
						$this->terms_id,
						'$this->customer_accbank',
						'$this->customer_bank',
						 $this->createdby,
						'$timestamp',
						 $this->updatedby,
						'$timestamp',
						 $this->isactive)";
	$this->log->showLog(4,"Before insert customer SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert customer code $customer_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new customer $customer_name successfully"); 
		return true;
	}
  } // end of member function insertCustomer


  public function fetchCustomer( $customer_id) {
    
    //echo $customer_id;
	$this->log->showLog(3,"Fetching customer detail into class Customer.php.<br>");
		
	$sql="SELECT c.customer_id,c.customer_no,c.customer_name,c.customer_street1,c.customer_street2,c.customer_postcode,c.customer_city,c.customer_state,c.customer_country,c.customer_tel1,c.customer_tel2,c.customer_fax,c.customer_contactperson,c.customer_contactno,c.customer_contactnohp,c.customer_contactfax,c.customer_desc,c.terms_id,c.customer_accbank,c.customer_bank,c.created,c.createdby,c.updated, c.updatedby, c.isactive 
			from $this->tablecustomer c 
			where customer_id=$customer_id";
	
	$this->log->showLog(4,"ProductCustomer->fetchCustomer, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$this->customer_no=$row['customer_no'];
	$this->customer_name=$row['customer_name'];
	$this->customer_street1=$row['customer_street1'];
	$this->customer_street2=$row['customer_street2'];
	$this->customer_postcode=$row['customer_postcode'];
	$this->customer_city=$row['customer_city'];
	$this->customer_state=$row['customer_state'];
	$this->customer_country=$row['customer_country'];
	$this->customer_tel1=$row['customer_tel1'];
	$this->customer_tel2=$row['customer_tel2'];
	$this->customer_fax=$row['customer_fax'];
	$this->customer_contactperson=$row['customer_contactperson'];
	$this->customer_contactno=$row['customer_contactno'];
	$this->customer_contactnohp=$row['customer_contactnohp'];
	$this->customer_contactfax=$row['customer_contactfax'];
	$this->customer_desc=$row['customer_desc'];
	$this->terms_id=$row['terms_id'];
	$this->customer_accbank=$row['customer_accbank'];
	$this->customer_bank=$row['customer_bank'];
	$this->isactive=$row['isactive'];
	
   $this->log->showLog(4,"Customer->fetchCustomer,database fetch into class successfully");	
	$this->log->showLog(4,"customer_name:$this->customer_name");
	$this->log->showLog(4,"description:$this->description");
	$this->log->showLog(4,"isactive:$this->isactive");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Customer->fetchCustomer,failed to fetch data into databases.");	
	}
  } // end of member function fetchCustomer

  public function deleteCustomer( $customer_id ) {
    	$this->log->showLog(2,"Warning: Performing delete customer id : $customer_id !");
	$sql="DELETE FROM $this->tablecustomer where customer_id=$customer_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: customer ($customer_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"customer ($customer_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteCustomer

  
  public function getSQLStr_AllCustomer( $wherestring,  $orderbystring,  $startlimitno,$recordcount ) {

/*
    $sql="SELECT c.customer_id,c.customer_no,c.customer_name,c.street1,c.street2,".
		"c.postcode,c.city,c.state1,c.country,".
		"c.contactperson,c.contactperson_no,c.tel1,c.tel2,c.fax,c.description,".
		"c.created,c.createdby,c.updated, c.updatedby, c.isactive, c.isdefault,c.currency_id, ".
		"cr.currency_symbol FROM $this->tablecustomer c " .
		"left join $this->tablecurrency cr on c.currency_id = cr.currency_id ".
	" $wherestring $orderbystring LIMIT $startlimitno,$recordcount";
	*/
	
	$sql = "SELECT c.customer_id,c.customer_no,c.customer_name,c.customer_street1,c.customer_street2,c.customer_tel1,c.customer_tel2,c.customer_fax,c.customer_contactperson,c.customer_contactno,c.customer_contactnohp,c.customer_contactfax,c.customer_desc,c.terms_id,c.customer_accbank,c.customer_bank,c.created,c.createdby,c.updated, c.updatedby, c.isactive
				FROM $this->tablecustomer c 
				$wherestring $orderbystring LIMIT $startlimitno,$recordcount ";
				
  $this->log->showLog(4,"Running ProductCustomer->getSQLStr_AllCustomer: $sql"); 
 return $sql;
  } // end of member function getSQLStr_AllCustomer

 public function showCustomerTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0){
	$this->log->showLog(3,"Showing Customer Table");
	$sql=$this->getSQLStr_AllCustomer($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Customer No</th>
				<th style="text-align:center;">Customer Name</th>
				<th style="text-align:center;">Tel</th>
				<th style="text-align:center;">Contact Person</th>
				<th style="text-align:center;">Hand Phone</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$customer_id=$row['customer_id'];
		$customer_no=$row['customer_no'];
		$customer_name=$row['customer_name'];
		$customer_desc=$row['customer_desc'];
		$customer_contactnohp = $row['customer_contactnohp'];
		$customer_contactperson=$row['customer_contactperson'];
		$tel1 = $row['customer_tel1'];
	
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
			<td class="$rowtype" style="text-align:center;">$customer_no</td>
			<td class="$rowtype" style="text-align:center;">$customer_name</td>
			<td class="$rowtype" style="text-align:center;">$tel1</td>
			<td class="$rowtype" style="text-align:center;">$customer_contactperson</td>
			<td class="$rowtype" style="text-align:center;">$customer_contactnohp</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="customer.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this customer'>
				<input type="hidden" value="$customer_id" name="customer_id">
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
	$this->log->showLog(3,"Showing Customer Table");
	
	$sql=$this->getSQLStr_AllCustomer($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	
	if($orderctrl=='asc'){
	
	if($fldSort=='customer_no')
	$sortimage1 = 'images/sortdown.gif';
	else
	$sortimage1 = 'images/sortup.gif';
	if($fldSort=='customer_name')
	$sortimage2 = 'images/sortdown.gif';
	else
	$sortimage2 = 'images/sortup.gif';
	if($fldSort=='isactive')
	$sortimage3 = 'images/sortdown.gif';
	else
	$sortimage3 = 'images/sortup.gif';
	
	}else{
	$sortimage1 = 'images/sortup.gif';
	$sortimage2 = 'images/sortup.gif';
	$sortimage3 = 'images/sortup.gif';
	}


	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Customer No <br><input type='image' src="$sortimage1" name='submit'  title='Sort this record' onclick = " headerSort('customer_no');"></th>
				<th style="text-align:center;">Customer Name <br><input type='image' src="$sortimage2" name='submit'  title='Sort this record' onclick = " headerSort('customer_name');"></th>
				<th style="text-align:center;">Tel</th>
				<th style="text-align:center;">Contact Person</th>
				<th style="text-align:center;">Handphone</th>
				<th style="text-align:center;">Active <br><input type='image' src="$sortimage3" name='submit'  title='Sort this record' onclick = " headerSort('isactive');"></th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$customer_id=$row['customer_id'];
		$customer_no=$row['customer_no'];
		$customer_name=$row['customer_name'];
		$customer_desc=$row['customer_desc'];
		$tel1=$row['customer_tel1'];
		$customer_contactperson=$row['customer_contactperson'];
		$customer_contactnohp=$row['customer_contactnohp'];	
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
			<td class="$rowtype" style="text-align:center;">$customer_no</td>
			<td class="$rowtype" style="text-align:center;">$customer_name</td>
			<td class="$rowtype" style="text-align:center;">$tel1 </td>
			<td class="$rowtype" style="text-align:center;">$customer_contactperson</td>
			<td class="$rowtype" style="text-align:center;">$customer_contactnohp</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="customer.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this customer'>
				<input type="hidden" value="$customer_id" name="customer_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	
		
	$printctrl="<tr><td colspan='11' align=right><form action='viewcustomer.php' method='POST' target='_blank' name='frmPdf'>
					<input type='image' src='images/reportbutton.jpg'>
					<input type='hidden' name='wherestr' value=\"$wherestring\">
					<input type='hidden' name='orderstr' value='$orderbystring'>
					</form></td></tr>";
					
	echo $printctrl;

	echo  "</tr></tbody></table>";
 }



   
   
 public function searchAToZ(){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search customer easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(customer_name,1)) as shortname FROM $this->tablecustomer where isactive='1' order by customer_name";
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
		
		echo "<A style='font-size:12;' href='customer.php?filterstring=$shortname'>  $shortname  </A> ";
	}
	
	$this->log->showLog(3,"Complete generate list of short cut");
		echo <<<EOF
<BR>
<A href='customer.php?action=new' style='color: GRAY'><img src="images/addnew.jpg"</A>
<A href='customer.php?action=showSearchForm' style='color: gray'><img src="images/search.jpg"</A>

EOF;
return $filterstring;
  }
  
  
  
  


  public function getLatestCustomerID() {
	$sql="SELECT MAX(customer_id) as customer_id from $this->tablecustomer;";
	$this->log->showLog(3,'Checking latest created customer_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created customer_id:' . $row['customer_id']);
		return $row['customer_id'];
	}
	else
	return -1;
	
  } // end
  
  
  public function getNewCustomer() {
	
	$sql="SELECT CAST(customer_no AS SIGNED) as customer_no, customer_no as ori_data from $this->tablecustomer WHERE CAST(customer_no AS SIGNED) > 0 order by CAST(customer_no AS SIGNED) DESC limit 1 ";

	$this->log->showLog(3,'Checking latest created customer_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created customer_no:' . $row['customer_no']);
		$customer_no=$row['customer_no']+1;

		if(strlen($row['customer_no']) != strlen($row['ori_data']))
		return str_replace($row['customer_no'], '', $row['ori_data'])."".$customer_no;
		else
		return $customer_no;
		
	}
	else
	return 0;
	
  } // end
  
  

  public function getSelectCustomer($id,$others="") {

	$onchange = ""; 
	
	$sql="SELECT customer_id,customer_name from $this->tablecustomer where isactive=1 or customer_id=$id " .
		" order by customer_name";
		
	if($others=="invoice"||$others=="quotation"){
	$onchange = "onchange=' tryValidate();'";
	}
	
	$selectctl="<SELECT name='customer_id' $onchange >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"> </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$customer_id=$row['customer_id'];
		$customer_name=$row['customer_name'];
	
		if($id==$customer_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$customer_id' $selected>$customer_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end
  
  
   public function getSelectCustomerStatement($id,$others="",$shownull="N") {

	$onchange = ""; 



	$sql="SELECT customer_id,customer_name from $this->tablecustomer where (customer_id>0 and isactive=1) or customer_id=$id " .
		" order by customer_name";
	$this->log->showLog(4,"Get shownull:$shownull -> customer list with: $sql");
	if($others=="invoice"||$others=="quotation"){
	$onchange = "onchange=' validateAttn();'";
	}
	
	$selectctl="<SELECT name='customer_id' $onchange >";

	if($shownull=="Y")
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"> - </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$customer_id=$row['customer_id'];
		$customer_name=$row['customer_name'];
	
		if($id==$customer_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$customer_id' $selected>$customer_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end


/*public function getStateList($id){
	$this->log->showLog(3,"Retrieve available area from database");

	$sql="SELECT customer_state, state from $this->tablestate order by state ";
	$areactrl="<SELECT name='customer_state' >";
	if ($id==-1)
		$areactrl=$areactrl . '<OPTION value="0" SELECTED="SELECTED"> </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$area_id=$row['customer_state'];
		$customer_state=$row['state'];
		if($id==$area_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		
		$areactrl=$areactrl  . "<OPTION value='$area_id' $selected>$customer_state</OPTION>";
		$this->log->showLog(4,"Retrieving area_name:$customer_state");
	}
	$areactrl=$areactrl . "</SELECT>";
	return $areactrl;
}//end of getAreaList*/


  public function allowDelete($id){
	$sql="SELECT count(customer_id) as rowcount from $this->tableinvoice where customer_id=$id";
	
	$this->log->showLog(3,"Accessing ProductCustomer->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this customer, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this customer, record deletable");
		return true;
		}
	}


 public function showCustomerHeader($customer_id){
	if($this->fetchCustomer($customer_id)){
		$this->log->showLog(4,"Showing customer header successfully.");
	echo <<< EOF
	<table border='1' cellspacing='3'>
		<tbody>
			<tr>
				<th colspan="4">Customer Info</th>
			</tr>
			<tr>
				<td class="head">Customer No</td>
				<td class="odd">$this->customer_no</td>
				<td class="head">Customer Name</td>
				<td class="odd"><A href="customer.php?action=edit&customer_id=$customer_id" 
						target="_blank">$this->customer_name</A></td>
			</tr>
		</tbody>
	</table>
EOF;
	}
	else{
		$this->log->showLog(1,"<b style='color:red;'>Showing customer header failed.</b>");
	}

   }//showRegistrationHeader
   
   
  
  
 public function showSearchForm($wherestring="",$orderctrl=""){

   echo <<< EOF

	<FORM action="customer.php" method="POST" name="frmActionSearch" id="frmActionSearch">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criteria</th>
	    </tr>
	    <tr>
	      <td class='head'>Customer No</td>
	      <td class='even'><input name='customer_no' value='$this->customer_no'> (%, AB%,%AB,%A%B%)</td>
	      <td class='head'>Customer Name</td>
	      <td class='even'><input name='customer_name' value='$this->customer_name'>%ali, %ali%, ali%, %ali%bin%</td>
	    </tr>
	    <tr>
	      <td class='head'>Quick Search</td>
	      <td class='odd'>$this->customerctrl</td>
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

  public function convertSearchString($customer_id,$customer_no,$customer_name,$isactive){
$filterstring="";

if($customer_id > 0 ){
	$filterstring=$filterstring . " c.customer_id=$customer_id AND";
}

if($customer_no!=""){
	$filterstring=$filterstring . " c.customer_no LIKE '$customer_no' AND";
}

if($customer_name!=""){
	$filterstring=$filterstring . "  c.customer_name LIKE '$customer_name' AND";
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
  	
  
  

} // end of ClassCustomer
?>



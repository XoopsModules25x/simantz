<?php


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

/**
 * class Customer
 */
class Customer
{
   /*** Attributes: ***/

  public $customer_no;
  public $customer_name;
  public $customer_street1;
  public $isactive;
  public $customer_street2;
  public $showcalendar="";
  public $customer_tel1;
  public $customer_tel2;
  public $customer_fax;
  public $customer_contactperson;
  public $customer_contactno;
  public $customer_desc;
  public $customer_terms;
  public $customer_accbank;
  public $customer_bank;
  public $updated;
  public $updatedby;
  public $created;
  public $createdby;
  public $customerctrl;
  

  
  
  public $xoopsDB;
  public $tableprefix;
  public $tablecustomer;
  private $tableinvoice;
  private $tablequotation;
  private $log;

  /**
   * @access public, constructor
   */
  public function Customer($xoopsDB, $tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$tableprefix= XOOPS_DB_PREFIX . "_";
	$this->tableprefix=$tableprefix;
	$this->tablecustomer=$tableprefix . "tblcustomer";
	$this->tableinvoice=$tableprefix."tblinvoice";
	$this->tablequotation=$tableprefix."tblquotation";
	
	$this->log=$log;
	
   }

  /**
   * Return an SQL Statement to list all customer information.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param string startlimitno 
   * @return string
   * @access public
   */
  public function getSqlStrCustomerList( $wherestring,  $orderbystring,  $startlimitno ) {
    /*$sql= "SELECT s.customer_no, s.customer_name, s.customer_street1, s.isactive, s.customer_street2,std.standard_name, s.customer_tel1, s.customer_tel2, ".
	" sch.school_name, s.customer_contactperson, s.customer_desc, s.customer_terms, s.parent_name, s.parent_tel, s.organization_id, ".
	" r.races_name,s.description,s.customer_accbank,s.customer_bank FROM $this->tablecustomer s ".
	" inner join $this->tableraces r on r.races_id=s.races_id ".
	" inner join $this->tablestandard std on std.standard_id=s.standard_id ".
	" inner join $this->tableschool sch on sch.customer_fax=s.customer_fax ".
	" $wherestring $orderbystring";*/
	
	$sql= "SELECT * FROM $this->tablecustomer s ".
	" $wherestring $orderbystring";
	$this->log->showLog(4,"Calling getSqlStrCustomerList:" .$sql);
   return $sql;
  } // end of member function getSqlStrCustomerList

  /**
   *
   * @param string type 
   * @param int customer_no 
   * @return bool
   * @access public
   */
  public function getInputForm( $type,  $customer_id, $token) {
	 //echo $customer_id;
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$jumptotoregclass="";
	if ($type=="new"){
		$header="New Customer";
		$action="create";
		if($customer_id==0){
		$this->customer_no="";
		$this->customer_no=$this->getNextIndex();
		$this->customer_name="";
		$this->customer_street1="";
		$this->customer_street2="";
		$this->customer_tel1 ="";
		$this->customer_tel2="";
		$this->customer_fax="";
		$this->customer_contactperson="";
		$this->customer_contactno="";
		$this->customer_desc="";
		$this->customer_terms="";
		$this->customer_accbank="";
		$this->customer_bank="";
		
		}
		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
	}
	else
	{
		
		if($this->customer_id>0){
			$action="update";
			
			
			if($this->allowDelCustomer($this->customer_no))
			  $deletectrl="<FORM action='customer.php' method='POST' onSubmit='return confirm(" . 
					'"Confirm to delete this record?"'.")'>".
					"<input type='submit' value='Delete' name='submit'  style='height: 40px;'>".
					"<input type='hidden' value='$this->customer_id' name='customer_id'>".
					"<input type='hidden' value='delete' name='action'>".
					"<input name='token' value='$token' type='hidden'></form>";
		
		$addnewctrl="<Form action='customer.php' method='POST'><input name='submit' value='New' type='submit'></form>";
		$header="Edit Customer";
		}
		else{
		$action="create";
		$header="New Customer";
		}

		
		$savectrl="<input name='customer_id' value='$this->customer_id' type='hidden'>".
			 "<input name='submit' value='Save' type='submit'  style='height: 40px;'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";
		$select_m="";
		$select_f="";
		
		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST' name='frmRecordInfo'>".
			"<input name='tablename' value='$this->tablecustomer' type='hidden'>".
			"<input name='id' value='$this->customer_id' type='hidden'>".
			"<input name='idname' value='customer_id' type='hidden'>".
			"<input name='title' value='Customer' type='hidden'>".
			"<input name='submit' value='View Record Info' type='submit'  style='height: 40px;'>".
			"</form>";

/*
		if ($this->customer_tel1=="M")
			$select_m="SELECTED='SELECTED'";
		else
			$select_f="SELECTED='SELECTED'";*/

		$header="Edit Customer";
		
	

	}
$sqlcustomercount="SELECT count(customer_no) as customerqty from $this->tablecustomer where isactive='Y'";
$querycustomercount=$this->xoopsDB->query($sqlcustomercount);
$customercount=0;
if($row=$this->xoopsDB->fetchArray($querycustomercount))
$customercount=$row['customerqty'];

	echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Customers Record ($customercount active customer)</span></big></big></big></div><br>
<table style="width: 140px;"><tbody><td>$addnewctrl</td><td>
<form action="customer.php" method="post" id="frmCustomer" name='frmCustomer' onSubmit='return validateCustomer()' ><input name="reset" value="Reset" type="reset"></td></tbody></table>
<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
<tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>

	<tr>
		<td class="head">Customer No</th>
		<td class="even"><input name="customer_no" value="$this->customer_no" maxlength="8"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
		
	</tr>
	<tr>
		<td class="head">Name</td>
		<td class="odd"><input size="40" name="customer_name" value="$this->customer_name"></td>
		
	</tr>
	<tr>
		<td class="head">Street 1</td>
		<td class="even"><input size="40" name="customer_street1" value="$this->customer_street1"></td>
		
	</tr>
	<tr>
		<td class="head">Street 2</td>
		<td class="odd"><input size="40" name="customer_street2" value="$this->customer_street2"></td>
				
	</tr>
	<tr>
		<td class="head">Tel 1</td>
		<td class="even"><input maxlength="16" name="customer_tel1" value="$this->customer_tel1"></td>
		
	<tr>
		<td class="head">Tel 2</td>
		<td class="odd"><input maxlength="16" name="customer_tel2" value="$this->customer_tel2"></td>
		
	</tr>
	<tr>
		<td class="head">Fax </td>
		<td class="even"><input maxlength="16" name="customer_fax" value="$this->customer_fax"></td>
		
	</tr>
	<tr>
		<td class="head">Contact Person</td>
		<td class="even"><input size="40" name="customer_contactperson" value="$this->customer_contactperson"></td>
	</tr>
	<tr>
		<td class="head">Contact No</td>
		<td class="even"><input size="40" name="customer_contactno" value="$this->customer_contactno"></td>
	</tr>
	<tr>
		<td class="head">Terms</td>
		<td class="even"><input size="40" name="customer_terms" value="$this->customer_terms"></td>
	</tr>
	<tr>
		<td class="head">Account Bank No.</td>
		<td class="even"><input name="customer_accbank" value="$this->customer_accbank"></td>
	</tr>
	<tr>
		<td class="head">Bank Name</td>
		<td class="even"><input size="40" name="customer_bank" value="$this->customer_bank"></td>
	</tr>
	<tr>
		<td class="head">Description</td>
		<td class="even" colspan='3'><input name="customer_desc" value="$this->customer_desc" size='100' maxlength='100'></td>
	</tr>
	

	
	</tbody>
</table>

<table style="width: 330px;"><tbody><tr><td>
$savectrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden">
	</form></td>
		<td>$deletectrl</td>
		<td>$recordctrl</td></tr></tbody></table><br>
		
<form action="customer.php" method="post" name="frmSearchCustomer"><input type='submit' value='Open Search Form' name='submit'><input type='hidden' value='search' name='action'></form>

EOF;
//<form action="customer.php" method="post" name="frmShowAllCustomer"><input type='submit' value='Show All Customers' //name='submit'><input type='hidden' value='showall' name='action'></form>

  } // end of member function getInputForm

  /**
   *
   * @return bool
   * @access public
   */
  public function updateCustomer( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$sql="UPDATE $this->tablecustomer SET
	customer_no=$this->customer_no,
	customer_name='$this->customer_name',
	customer_street1='$this->customer_street1',
	customer_street2='$this->customer_street2',
	customer_tel1='$this->customer_tel1',
	customer_tel2='$this->customer_tel2',
	customer_fax='$this->customer_fax',
	customer_contactperson='$this->customer_contactperson',
	customer_contactno='$this->customer_contactno',
	customer_desc='$this->customer_desc',
	customer_terms='$this->customer_terms',
	updated='$timestamp',
	updatedby=$this->updatedby,
	customer_bank='$this->customer_bank',
	customer_accbank='$this->customer_accbank',
	isactive='$this->isactive'
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

  /**
   *
   * @return bool
   * @access public
   */
  public function insertCustomer( ) {
  
	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new customer $customer_name");
	$sql="INSERT INTO $this->tablecustomer (customer_no,customer_name,customer_street1,customer_street2,customer_tel1, customer_tel2, customer_fax, customer_contactperson, customer_contactno, customer_desc, customer_terms,customer_accbank,customer_bank,isactive,created,createdby,updated,updatedby)
	values
	($this->customer_no,
	'$this->customer_name',
	'$this->customer_street1',
	'$this->customer_street2',
	'$this->customer_tel1',
	'$this->customer_tel2',
	'$this->customer_fax',
	'$this->customer_contactperson',
	'$this->customer_contactno',
	'$this->customer_desc',
	'$this->customer_terms',
	'$this->customer_accbank',
	'$this->customer_bank',
	'$this->isactive',
	'$timestamp',
	$this->createdby,
	'$timestamp',
	$this->updatedby)";
	
	$this->log->showLog(4,"Before insert customer SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert customer $customer_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new customer $customer_name successfully"); 
		return true;
}
  } // end of member function insertCustomer

  /** Verified db whether this customer allow to delete
   *
   * @param int customer_no 
   * @return bool
   * @access public
   */
  public function allowDelCustomer( $customer_id ) {
  
    	$this->log->showLog(2,"Verify whether customer_no : $customer_no can be remove from database");
		$qty1 = 0;
		$qty2 = 0;
		
		$sql="SELECT count(invoice_id) as qty from $this->tableinvoice where customer_id=$customer_id";
	

		$query=$this->xoopsDB->query($sql);
		
		if($row=$this->xoopsDB->fetchArray($query)){
			$qty1=$row['qty'];
		}
		
		$sql="SELECT count(invoice_id) as qty from $this->tablequotation where customer_id=$customer_id";
	

		$query=$this->xoopsDB->query($sql);
		
		if($row=$this->xoopsDB->fetchArray($query)){
			$qty2=$row['qty'];
		}
		
		if($qty1>0 || $qty2>0){
			$this->log->showLog(3,"Found $qty record under table customer invoice or quotation, this customer undeletable!");
			return false;
		}
		else{
			$this->log->showLog(3,"This customer is deletable after verification!");
			return true;
		}
		
  } // end of member function allowDelCustomer

  /**
   *
   * @param int customer_no 
   * @return bool
   * @access public
   */
  public function delCustomer( $customer_id ) {
   
   $this->log->showLog(2,"Warning: Performing delete customer id : $customer_no !");
	$sql="DELETE FROM $this->tablecustomer where customer_no=$customer_no";

	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);

	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	/*
	$sqlad="DELETE FROM $this->tableaddress where customer_no=$customer_no";
	
	$rsad=$this->xoopsDB->query($sqlad);
	if (!$rsad){
		$this->log->showLog(1,"Error: Customer's address ($customer_no) unable remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Customer's address ($customer_no) removed from database successfully!");
		return true;	
	}
	*/

  } // end of member function delCustomer

  /**
   *
   * @param int customer_no 
   * @return bool
   * @access public
   */
  public function fetchCustomerInfo( $customer_id ) {
  
	$this->log->showLog(3,"Fetching customer detail into class Customer.php.<br>");
		
	$sql="SELECT customer_id,customer_no,customer_name,customer_street1,customer_street2,customer_tel1, customer_tel2, customer_fax, customer_contactperson, customer_contactno, customer_desc, customer_terms,customer_accbank,customer_bank,isactive FROM $this->tablecustomer where customer_id=$customer_id";
	
	$this->log->showLog(4,"Customer->fetchCustomerInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		
		$this->customer_id=$row["customer_id"];
		$this->customer_no=$row["customer_no"];
		$this->customer_name=$row["customer_name"];
		$this->customer_street1=$row["customer_street1"];
		$this->customer_street2=$row["customer_street2"];
		$this->customer_tel1=$row["customer_tel1"];
		$this->customer_tel2=$row["customer_tel2"];
		$this->customer_fax=$row["customer_fax"];
		$this->customer_contactperson=$row["customer_contactperson"];
		$this->customer_contactno=$row["customer_contactno"];
		$this->customer_desc=$row["customer_desc"];
		$this->customer_accbank=$row["customer_accbank"];
		$this->customer_bank=$row["customer_bank"];
		$this->customer_terms=$row["customer_terms"];
		$this->isactive=$row['isactive'];
		
		$this->log->showLog(4,"Customer->fetchCustomer,database fetch into invoice successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Customer->fetchCustomer,failed to fetch data into databases.");	
	}
} // end of member function fetchCustomerInfo

  public function showCustomerTable( $wherestring="",$orderbystring="",$startlimitno=0,$tabletype='customer' ) {
	$this->log->showLog(3,"Showing Customer Table");
	$sql=$this->getSqlStrCustomerList($wherestring,"ORDER BY customer_name",0);
	
	
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table style="text-align:left width: 100%" border="1" cellpadding="0" cellspacing="3">
  		<tbody>
  		
    	<tr>
    			<th style="text-align:center;">No</th>
				<th style="text-align:center;">Customer No</th>
				<th style="text-align:center;">Name</th>
				<!--				
				<th style="text-align:center;">Street 1</th>
				<th style="text-align:center;">Street 2</th>
				<th style="text-align:center;">Tel No. 1</th>
				<th style="text-align:center;">Tel No. 2</th>
				<th style="text-align:center;">Fax No.</th>
				-->
				<th style="text-align:center;">Contact Person</th>
				<th style="text-align:center;">Contact No</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Account Bank No.</th>
				<th style="text-align:center;">Bank Name</th>
				<th style="text-align:center;">Terms</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		
		$customer_id=$row["customer_id"];
		$customer_no=$row["customer_no"];
		$customer_name=$row["customer_name"];
		$customer_street1=$row["customer_street1"];
		$customer_street2=$row["customer_street2"];
		$customer_tel1=$row["customer_tel1"];
		$customer_tel2=$row["customer_tel2"];
		$customer_fax=$row["customer_fax"];
		$customer_contactperson=$row["customer_contactperson"];
		$customer_contactno=$row["customer_contactno"];
		$customer_desc=$row["customer_desc"];
		$customer_accbank=$row["customer_accbank"];
		$customer_bank=$row["customer_bank"];
		$customer_terms=$row["customer_terms"];
		$isactive=$row['isactive'];
		
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

	$actionperform="";
	switch($tabletype){
	case "customer":
		$actionperform="<form action='customer.php' method='POST'>".
			"<input type='image' src='images/edit.gif' name='submit'  title='Edit this record'>".
				"<input type='hidden' value='$customer_id' name='customer_id'>".
				"<input type='hidden' name='action' value='edit'></form>";
	break;
	case "regclass":
		$actionperform="<form action='regclass.php' method='POST'><input type='submit' value='choose' name='submit'>".
				"<input type='hidden' value='$customer_id' name='customer_id'>".
				"<input type='hidden' name='action' value='choosed'></form>";
	break;
	case "regproduct":
		$actionperform="<form action='regproduct.php' method='POST'><input type='submit' value='choose' name='submit'>".
				"<input type='hidden' value='$customer_id' name='customer_id'>".
				"<input type='hidden' name='action' value='choosed'></form>";
	break;

	case "payment":
		$actionperform="<form action='payment.php' method='POST'><input type='submit' value='choose' name='submit'>".
				"<input type='hidden' value='$customer_id' name='customer_id'>".
				"<input type='hidden' name='action' value='choosed'></form>";
	break;
	default:
		$actionperform="";
	break;
	}
	
	
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$customer_no</td>
			<td class="$rowtype" style="text-align:center;"><a href='customer.php?action=edit&customer_id=$customer_id' target="_blank">$customer_name</td>
			
			<!--			
			<td class="$rowtype" style="text-align:center;">$customer_street1</td>
			<td class="$rowtype" style="text-align:center;">$customer_street2</td>
			<td class="$rowtype" style="text-align:center;">$customer_tel1</td>
			<td class="$rowtype" style="text-align:center;">$customer_tel2</td>
			<td class="$rowtype" style="text-align:center;">$customer_fax</td>
			-->			
			
			<td class="$rowtype" style="text-align:center;">$customer_contactperson</td>
			<td class="$rowtype" style="text-align:center;">$customer_contactno</td>
			<td class="$rowtype" style="text-align:center;">$customer_desc</td>
			<td class="$rowtype" style="text-align:center;">$customer_accbank</td>
			<td class="$rowtype" style="text-align:center;">$customer_bank</td>
			<td class="$rowtype" style="text-align:center;">$customer_terms</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$actionperform</td>

		</tr>
EOF;
	}//end of while
echo  "</tr></tbody></table>";
 } //end of showCustomerTable



public function showSearchTable( $wherestring="",$orderbystring="",$orderctrl="",$fldSort ="",$tabletype='customer' ) {
	$this->log->showLog(3,"Showing Customer Table");
	$sql=$this->getSqlStrCustomerList($wherestring,$orderbystring,0);
	
	
	if($orderctrl=='asc'){
	
	if($fldSort=='customer_no')
	$sortimage1 = 'images/sortdown.gif';
	else
	$sortimage1 = 'images/sortup.gif';
	if($fldSort=='customer_name')
	$sortimage2 = 'images/sortdown.gif';
	else
	$sortimage2 = 'images/sortup.gif';
	if($fldSort=='customer_contactperson')
	$sortimage3 = 'images/sortdown.gif';
	else
	$sortimage3 = 'images/sortup.gif';
	if($fldSort=='customer_bank')
	$sortimage4 = 'images/sortdown.gif';
	else
	$sortimage4 = 'images/sortup.gif';
	if($fldSort=='isactive')
	$sortimage5 = 'images/sortdown.gif';
	else
	$sortimage5 = 'images/sortup.gif';
	
	}else{
	$sortimage1 = 'images/sortup.gif';
	$sortimage2 = 'images/sortup.gif';
	$sortimage3 = 'images/sortup.gif';
	$sortimage4 = 'images/sortup.gif';
	$sortimage5 = 'images/sortup.gif';
	}

	$query=$this->xoopsDB->query($sql);

//<a onclick = " headerSort('customer_no');">Customer No</a>
	
	echo <<< EOF
	
	<table style="text-align:left width: 100%" border="1" cellpadding="0" cellspacing="3">
  		<tbody>
  		
  		
  		
    	<tr>
    			<th style="text-align:center;">No</th>
				<th style="text-align:center;">Customer No <input type='image' src="$sortimage1" name='submit'  title='Sort this record' onclick = " headerSort('customer_no');"></th>
				<th style="text-align:center;">Name <input type='image' src="$sortimage2" name='submit'  title='Sort this record' onclick = " headerSort('customer_name');"></th>
				<!--				
				<th style="text-align:center;">Street 1</th>
				<th style="text-align:center;">Street 2</th>
				<th style="text-align:center;">Tel No. 1</th>
				<th style="text-align:center;">Tel No. 2</th>
				<th style="text-align:center;">Fax No.</th>
				-->
				<th style="text-align:center;">Contact Person <input type='image' src="$sortimage3" name='submit'  title='Sort this record' onclick = " headerSort('customer_contactperson');"></th>
				<th style="text-align:center;">Contact No</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Account Bank No.</th>
				<th style="text-align:center;">Bank Name <input type='image' src="$sortimage4" name='submit'  title='Sort this record' onclick = " headerSort('customer_bank');"></th>
				<th style="text-align:center;">Terms</th>
				<th style="text-align:center;">Active <input type='image' src="$sortimage5" name='submit'  title='Sort this record' onclick = " headerSort('isactive');"></th>
				<th style="text-align:center;">Operation</th>
   	</tr>
   	
EOF;


	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		
		$customer_id=$row["customer_id"];
		$customer_no=$row["customer_no"];
		$customer_name=$row["customer_name"];
		$customer_street1=$row["customer_street1"];
		$customer_street2=$row["customer_street2"];
		$customer_tel1=$row["customer_tel1"];
		$customer_tel2=$row["customer_tel2"];
		$customer_fax=$row["customer_fax"];
		$customer_contactperson=$row["customer_contactperson"];
		$customer_contactno=$row["customer_contactno"];
		$customer_desc=$row["customer_desc"];
		$customer_accbank=$row["customer_accbank"];
		$customer_bank=$row["customer_bank"];
		$customer_terms=$row["customer_terms"];
		$isactive=$row['isactive'];
		
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

	$actionperform="";
	switch($tabletype){
	case "customer":
		$actionperform="<form action='customer.php' method='POST'>".
			"<input type='image' src='images/edit.gif' name='submit'  title='Edit this record'>".
				"<input type='hidden' value='$customer_id' name='customer_id'>".
				"<input type='hidden' name='action' value='edit'></form>";
	break;
	case "regclass":
		$actionperform="<form action='regclass.php' method='POST'><input type='submit' value='choose' name='submit'>".
				"<input type='hidden' value='$customer_id' name='customer_id'>".
				"<input type='hidden' name='action' value='choosed'></form>";
	break;
	case "regproduct":
		$actionperform="<form action='regproduct.php' method='POST'><input type='submit' value='choose' name='submit'>".
				"<input type='hidden' value='$customer_id' name='customer_id'>".
				"<input type='hidden' name='action' value='choosed'></form>";
	break;

	case "payment":
		$actionperform="<form action='payment.php' method='POST'><input type='submit' value='choose' name='submit'>".
				"<input type='hidden' value='$customer_id' name='customer_id'>".
				"<input type='hidden' name='action' value='choosed'></form>";
	break;
	default:
		$actionperform="";
	break;
	}
	
	
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$customer_no</td>
			<td class="$rowtype" style="text-align:center;"><a href='customer.php?action=edit&customer_id=$customer_id' target="_blank">$customer_name</td>
			
			<!--			
			<td class="$rowtype" style="text-align:center;">$customer_street1</td>
			<td class="$rowtype" style="text-align:center;">$customer_street2</td>
			<td class="$rowtype" style="text-align:center;">$customer_tel1</td>
			<td class="$rowtype" style="text-align:center;">$customer_tel2</td>
			<td class="$rowtype" style="text-align:center;">$customer_fax</td>
			-->			
			
			<td class="$rowtype" style="text-align:center;">$customer_contactperson</td>
			<td class="$rowtype" style="text-align:center;">$customer_contactno</td>
			<td class="$rowtype" style="text-align:center;">$customer_desc</td>
			<td class="$rowtype" style="text-align:center;">$customer_accbank</td>
			<td class="$rowtype" style="text-align:center;">$customer_bank</td>
			<td class="$rowtype" style="text-align:center;">$customer_terms</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$actionperform</td>

		</tr>
		
EOF;
	}//end of while
	
	//$printctrl="<form action='viewattendance.php' method='POST' target='_blank'><input type='submit' value='Preview' name='submit' style='font-size:22px;' ><input type='hidden' name='tuitionclass_id' value='$tuitionclass_id'><input type='hidden' name='period_id' value='$period_id'></form>";}
	
	$printctrl="<tr><td colspan='11' align=right><form action='viewcustomer.php' method='POST' target='_blank' name='frmPdf'>
					<input type='submit' value='Print Report' name='btnPrint'>
					<input type='hidden' name='wherestr' value=\"'$wherestring\"'>
					<input type='hidden' name='orderstr' value='$orderbystring'>
					</form></td></tr>";
					
echo $printctrl;
echo  "</tr></tbody></table>";
 } //end of showCustomerTable
 
 
 
  public function showAllCustomerTable() {
	$this->log->showLog(3,"Showing All Customer Table");
	$sql=$this->getSqlStrCustomerList("","ORDER BY customer_street1",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Customer List</span></big></big></big></div><br>

	<table style="text-align:left width: 100%" border="1" cellpadding="0" cellspacing="3" id="tblCustomer">
  		<tbody>
    			<tr>
				
    			<th style="text-align:center;">No</th>
				<th style="text-align:center;">Customer No</th>
				<th style="text-align:center;">Name</th>
				
				<!--
				<th style="text-align:center;">Street 1</th>
				<th style="text-align:center;">Street 2</th>
				<th style="text-align:center;">Tel No. 1</th>
				<th style="text-align:center;">Tel No. 2</th>
				<th style="text-align:center;">Fax No.</th>
				-->
				
				<th style="text-align:center;">Contact Person</th>
				<th style="text-align:center;">Contact No</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Account Bank No.</th>
				<th style="text-align:center;">Bank Name</th>
				<th style="text-align:center;">Terms</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		
		$customer_no=$row["customer_no"];
		$customer_name=$row["customer_name"];
		$customer_street1=$row["customer_street1"];
		$customer_street2=$row["customer_street2"];
		$customer_tel1=$row["customer_tel1"];
		$customer_tel2=$row["customer_tel2"];
		$customer_fax=$row["customer_fax"];
		$customer_contactperson=$row["customer_contactperson"];
		$customer_contactno=$row["customer_contactno"];
		$customer_desc=$row["customer_desc"];
		$customer_accbank=$row["customer_accbank"];
		$customer_bank=$row["customer_bank"];
		$customer_terms=$row["customer_terms"];
		$isactive=$row['isactive'];
		
		if($isactive=='N')
			$isactive="<b style='color:red'>$isactive</b>";
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$customer_no</td>
			<td class="$rowtype" style="text-align:center;"><a href='customer.php?action=edit&customer_id=$customer_id' target="_blank">$customer_name</td>
			
			<!--
			<td class="$rowtype" style="text-align:center;">$customer_street1</td>
			<td class="$rowtype" style="text-align:center;">$customer_street2</td>
			<td class="$rowtype" style="text-align:center;">$customer_tel1</td>
			<td class="$rowtype" style="text-align:center;">$customer_tel2</td>
			<td class="$rowtype" style="text-align:center;">$customer_fax</td>
			-->
			
			<td class="$rowtype" style="text-align:center;">$customer_contactperson</td>
			<td class="$rowtype" style="text-align:center;">$customer_contactno</td>
			<td class="$rowtype" style="text-align:center;">$customer_desc</td>
			<td class="$rowtype" style="text-align:center;">$customer_accbank</td>
			<td class="$rowtype" style="text-align:center;">$customer_bank</td>
			<td class="$rowtype" style="text-align:center;">$customer_terms</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			
			<td class="$rowtype" style="text-align:center;"><form action='customer.php' method='POST'>
			<input type='image' src='images/edit.gif' name='submit' title='Edit this record'>
			<input type='hidden' value='$customer_no' name='customer_no'><input type='hidden' name='action' value='edit'></form></td>

		</tr>
EOF;
	}//end of while
echo  "</tr></tbody></table>";
 } //end of showAllCustomerTable

  /**
   *
   * @param int customer_no 
   * @return 
   * @access public
   */

  public function getCustomerSelectBox($id,$showEmpty='N'){
  	$sql="SELECT customer_id,customer_no,customer_name from $this->tablecustomer where isactive='Y' or customer_id=$id order by customer_name ;";
	$selectctl="<SELECT name='customer_id' >";
	if(($id==0 || $id==-1) && $showEmpty='Y')
		$selected='SELECTED="SELECTED"';

	if ($id==-1 || $showEmpty=='Y')
		$selectctl=$selectctl . '<OPTION value="0" $selected>Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$customer_id=$row['customer_id'];
		$customer_no=$row['customer_no'];
		$customer_name=$row['customer_name'];
		if($id==$customer_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$customer_id' $selected>$customer_no ($customer_name)</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  }

  /** retrieve new created customer id
   *
   * @param 
   * @return int last customer id 
   * @access public
   */
  public function getLatestCustomerID() {
	$sql="SELECT MAX(customer_id) as customer_id from $this->tablecustomer;";
	//echo $sql;
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['customer_id'];
	else
	return -1;
  } // end of member function getLatestOrganizationID

 /**Return a long hyperlink string which contrain a 1st letter of all customer name
   *@param 
   *@return string a hyper link name list
   *@access public
   */ 
  public function searchAToZ(){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search customer easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(customer_name,1)) as shortname FROM $this->tablecustomer where isactive='Y' order by customer_name";
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	
	echo "<p>";
	
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if customer never do filter yet, if will choose 1st customer listing
		
		echo "<A href='customer.php?filterstring=$shortname'> $shortname </A> ";
	}
	$this->log->showLog(3,"Complete generate list of short cut");
  }

  public function getNextIndex(){
	$this->log->showLog(3,"Search next available customer_name");
	$sqlcustomer="SELECT MAX(customer_no) as customer_no FROM $this->tablecustomer";
	$query=$this->xoopsDB->query($sqlcustomer);

	$nextcode=0;
	while($row=$this->xoopsDB->fetchArray($query)) {
		$nextcode=$row['customer_no'];

		if($nextcode=="" || $nextcode==0)
			$nextcode=1;
		else
			$nextcode=$nextcode+1;
	
	}
	$this->log->showLog(3,"Get next customer code: $nextcode");
	return $nextcode;
  }

 public function showSearchForm($wherestring="",$orderctrl=""){
 //echo $wherestring;
   echo <<< EOF
	<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Search Customer</span></big></big></big></div><br>
	<FORM action="customer.php" method="POST" name="frmActionSearch" id="frmActionSearch">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criterial</th>
	    </tr>
	    <tr>
	      <td class='head'>Customer No</td>
	      <td class='even'><input name='customer_no' value=''> (%, AB%,%AB,%A%B%)</td>
	      <td class='head'>Customer Name</td>
	      <td class='even'><input name='customer_name' value=''>%ali, %ali%, ali%, %ali%bin%</td>
	    </tr>
	    <tr>
	      <td class='head'>Quick Search</td>
	      <td class='odd'>$this->customerctrl</td>
	      <td class='head'	>Contact Person</td>
	      <td class='odd'><input name='customer_contactperson' value=''></td>
	    </tr>
		<tr>
	      <td class='head'>Street 1</td>
	      <td class='odd'><input name='customer_street1' value=''></td>
	      <td class='head'>Is Active</td>
	      <td class='odd'>
		<select name="isactive">
			<option value="-" >Null</option>
			<option value="Y" >Y</option>
			<option value="N" >N</option>
		</select>
		</td>
	    </tr>
	    <tr>
	      <td class='head'>Street 2</td>
	      <td class='odd'><input name='customer_street1' value=''></td>
	      <td class='head'></td>
	      <td class='odd'></td>
	    </tr>
	   
	  </tbody>
	</table>
		
	<p>
	<table style="width:150px;">
	  <tbody>
	    <tr>
	      <td>
	      <input style="height:30px;" type='submit' value='Search' name='btnSubmit'>
	      <input type='hidden' name='action' value='searchcustomer'>
	      <input type='hidden' name='fldSort' value=''>
			<input type='hidden' name='wherestr' value="$wherestring">
			<input type='hidden' name='orderctrl' value='$orderctrl'>&nbsp;
	      </td>
	      <td>&nbsp;</td>
	      <td><input style="height:30px;" type='reset' value='Reset' name='reset'></td>
	      <td>&nbsp;</td>
	      <td><input style='height:30px;' name='submit' value='Add New Customer' type='button' onclick = " self.location = 'customer.php';"></td>
	    </tr>
	  </tbody>
	</table>
	
	</FORM>
EOF;
  }//showSearchForm


} // end of Customer
?>


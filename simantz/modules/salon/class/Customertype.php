<?php
/************************************************************************
 Class Customertype.php - Copyright kfhoo
**************************************************************************/

class Customertype
{

  public $customertype_id;
  public $customertype_code;
  public $customertype_description;
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
  private $tablecustomertype;
  private $tableproduct;
  private $tablecustomer;
  private $log;


//constructor
   public function Customertype($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simsalon_organization";
	$this->tablecustomertype=$tableprefix . "simsalon_customertype";
	$this->tablecustomer=$tableprefix . "simsalon_customer";
	$this->log=$log;
   }


  public function getInputForm( $type,  $customertype_id,$token  ) {
	

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Customer Type";
		$action="create";
	 	
		if($customertype_id==0){
			$this->customertype_code="";
			$this->customertype_description="";
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

		$this->customertype_code = getNewCode($this->xoopsDB,"customertype_code",$this->tablecustomertype);
	}
	else
	{
		$selectStock="";
		$selectService="";
		$selectProduct="";

		
		$action="update";
		$savectrl="<input name='customertype_id' value='$this->customertype_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablecustomertype' type='hidden'>".
		"<input name='id' value='$this->customertype_id' type='hidden'>".
		"<input name='idname' value='customertype_id' type='hidden'>".
		"<input name='title' value='Customertype' type='hidden'>".
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
		$header="Edit Product Customer Type";
		
		if($this->allowDelete($this->customertype_id) && $this->customertype_id>0)
		$deletectrl="<FORM action='customertype.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this customertype?"'.")'><input type='submit' value='Delete' name='submit' style='height: 40px;'>".
		"<input type='hidden' value='$this->customertype_id' name='customertype_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='customertype.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;"> Customer Type</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateCustomertype()" method="post"
 action="customertype.php" name="frmCustomertype"><input name="reset" value="Reset" type="reset"></td></tbody></table>

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
        <td class="head">Customer Type Code</td>
        <td class="even" colspan="2"><input maxlength="10" size="10"
 name="customertype_code" value="$this->customertype_code"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Customer Type Description</td>
        <td class="odd" colspan="2"><input maxlength="40" size="40"
 name="customertype_description" value="$this->customertype_description"></td>
      </tr>

	<tr>
		<td class="head">Remarks</td>
		<td class="even" colspan="2"><textarea name="remarks" cols="60" rows="1">$this->remarks</textarea></td>
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


  public function updateCustomertype( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablecustomertype SET
	customertype_description='$this->customertype_description',remarks='$this->remarks',
	customertype_code='$this->customertype_code',
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id
	WHERE customertype_id='$this->customertype_id'";
	
	$this->log->showLog(3, "Update customertype_id: $this->customertype_id, $this->customertype_code");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update customertype failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update customertype successfully.");
		return true;
	}
  } // end of member function updateCustomertype


  public function insertCustomertype( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new customertype $this->customertype_code");
 	$sql="INSERT INTO $this->tablecustomertype (customertype_description,remarks,customertype_code
	,isactive, created,createdby,updated,updatedby,organization_id) values(
	'$this->customertype_description','$this->remarks','$this->customertype_code','$this->isactive',
	'$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->organization_id)";
	$this->log->showLog(4,"Before insert customertype SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert customertype code $customertype_code");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new customertype $customertype_code successfully"); 
		return true;
	}
  } // end of member function insertCustomertype


  public function fetchCustomertype( $customertype_id) {
    
	$this->log->showLog(3,"Fetching customertype detail into class Customertype.php.<br>");
		
	$sql="SELECT * from $this->tablecustomertype ". 
			"where customertype_id=$customertype_id";
	
	$this->log->showLog(4,"Customertype->fetchCustomertype, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->organization_id=$row["organization_id"];
		$this->customertype_code=$row["customertype_code"];
		$this->customertype_description= $row['customertype_description'];
		$this->remarks= $row['remarks'];
		$this->isactive=$row['isactive'];
		
   	$this->log->showLog(4,"Customertype->fetchCustomertype,database fetch into class successfully");
	$this->log->showLog(4,"organization_id:$this->organization_id");
	$this->log->showLog(4,"customertype_code:$this->customertype_code");
	$this->log->showLog(4,"customertype_description:$this->customertype_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Customertype->fetchCustomertype,failed to fetch data into databases.");	
	}
  } // end of member function fetchCustomertype


  public function deleteCustomertype( $customertype_id ) {
    	$this->log->showLog(2,"Warning: Performing delete customertype id : $customertype_id !");
	$sql="DELETE FROM $this->tablecustomertype where customertype_id=$customertype_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: customertype ($customertype_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"customertype ($customertype_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteCustomertype


  public function getSQLStr_AllCustomertype( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running Customertype->getSQLStr_AllCustomertype: $sql");
    $sql="SELECT * FROM $this->tablecustomertype " .
	" $wherestring $orderbystring";
  return $sql;
  } // end of member function getSQLStr_AllCustomertype

 public function showCustomertypeTable(){
	
	$this->log->showLog(3,"Showing Customertype Table");
	$sql=$this->getSQLStr_AllCustomertype("where customertype_id>0","ORDER BY customertype_code",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Customer Type Code</th>
				<th style="text-align:center;">Customer Type Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$customertype_id=$row['customertype_id'];
		$customertype_code=$row['customertype_code'];
		$customertype_description=$row['customertype_description'];
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
			<td class="$rowtype" style="text-align:center;">$customertype_code</td>
			<td class="$rowtype" style="text-align:center;">$customertype_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="customertype.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this customertype'>
				<input type="hidden" value="$customertype_id" name="customertype_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }


  public function getLatestCustomertypeID() {
	$sql="SELECT MAX(customertype_id) as customertype_id from $this->tablecustomertype;";
	$this->log->showLog(3,'Checking latest created customertype_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created customertype_id:' . $row['customertype_id']);
		return $row['customertype_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectCustomertype($id,$fld='customertype_id') {
	
	$sql="SELECT customertype_id,customertype_description from $this->tablecustomertype where (isactive='Y' or customertype_id=$id ) order by customertype_description ;";
	$selectctl="<SELECT name=$fld >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$customertype_id=$row['customertype_id'];
		$customertype_description=$row['customertype_description'];
	
		if($id==$customertype_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$customertype_id' $selected>$customertype_description</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	$sql="SELECT count(customertype) as rowcount from $this->tablecustomer where customertype=$id";
	$this->log->showLog(3,"Accessing Customertype->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this customertype, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this customertype, record deletable");
		return true;
		}
	}
} // end of ClassCustomertype
?>

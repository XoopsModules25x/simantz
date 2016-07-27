<?php
/************************************************************************
Class Customerservice.php - Copyright kfhoo
**************************************************************************/

class Customerservice
{
  public $customerservice_id;
  public $customerservice_no;
  public $customerservice_date;
  public $customer_id;
  public $employee_id;
  public $remarks;
  public $start_date;
  public $end_date;
  
  
  public $filterstring;
  public $organization_id;
  public $created;
  public $updated;
  public $createdby;
  public $updatedby;
  public $isactive;
  public $cur_name;
  public $cur_symbol;
  public $customerservice_name;
  public $isAdmin;
  public $orgctrl;
  public $customerctrl;
  public $deleteAttachment;
  public $tablecustomerservice;
  public $tablecategory;
  public $tableuom;
  public $tableprefix;
  public $filename;
  public $employeectrl;


  public function Customerservice($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablecustomerservice=$tableprefix."simsalon_customerservice";
	$this->tableemployee=$tableprefix."simsalon_employee";
	$this->tablecustomer=$tableprefix."simsalon_customer";
	$this->tableuom=$tableprefix."simsalon_uom";
	$this->log=$log;
  }


  public function insertCustomerservice( ) {
	$this->log->showLog(3,"Creating customerservice SQL:$sql");

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new customerservice $this->customerservice_no");
	
 	$sql="INSERT INTO $this->tablecustomerservice (
					customerservice_no,
					customerservice_date,
					remarks,
					customer_id,
					employee_id,
					isactive, created,createdby,updated,updatedby,organization_id) 
				values(
					'$this->customerservice_no',
					'$this->customerservice_date',
					'$this->remarks',
					$this->customer_id,
					$this->employee_id,
					'$this->isactive','$timestamp',$this->createdby,'$timestamp',
					$this->updatedby,$this->organization_id)";

	$this->log->showLog(4,"Before insert customerservice SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert customerservice name '$customerservice_name'");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new customerservice name '$customerservice_name' successfully"); 
		return true;
	}
  } // end of member function insertClassMaster

  /**
   * Update class information
   *
   * @return bool
   * @access public
   */
  public function updateCustomerservice($withfile='N' ) {
    $timestamp= date("y/m/d H:i:s", time()) ;
	$sql="";
	if($withfile=='N'){
 	$sql="UPDATE $this->tablecustomerservice SET 
				customerservice_no='$this->customerservice_no',
				remarks='$this->remarks',
				customer_id=$this->customer_id,
				employee_id=$this->employee_id,
				updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',
				organization_id=$this->organization_id 

	WHERE customerservice_id = $this->customerservice_id";

	}else{

	$sql="UPDATE $this->tablecustomerservice SET 
				customerservice_no='$this->customerservice_no',
				customerservice_date='$this->customerservice_date',
				remarks='$this->remarks',
				customer_id=$this->customer_id,
				employee_id=$this->employee_id,
				updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',
				organization_id=$this->organization_id, 
				filename='$this->filename' 
	WHERE customerservice_id = $this->customerservice_id";
	
	}

	//echo $sql;

	$this->log->showLog(3, "Update customerservice_id: $this->customerservice_id, '$this->customerservice_name'");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update customerservice failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update customerservice successfully.");
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
  public function getSqlStr_AllCustomerservice( $wherestring,  $orderbystring,  $startlimitno ) {
  
	$wherestring .= " and c.customer_id = p.customer_id and p.employee_id = e.employee_id ";

    $sql="SELECT *,p.remarks as remarks1 FROM $this->tablecustomerservice p,  $this->tableemployee e, $this->tablecustomer c
	 $wherestring $orderbystring";
   $this->log->showLog(4,"Running Customerservice->getSQLStr_AllCustomerservice: $sql");
  return $sql;
  } // end of member function getSqlStr_AllClass

  /**
   * pull data from database into class.
   *
   * @param int masterclass_id 
   * @return bool
   * @access public
   */
  public function fetchCustomerserviceInfo( $customerservice_id ) {
    
	$this->log->showLog(3,"Fetching customerservice detail into class Customerservice.php.<br>");
		
	$sql="SELECT * FROM $this->tablecustomerservice ". 
			"where customerservice_id=$customerservice_id";
	
	$this->log->showLog(4,"Customerservice->fetchCustomerserviceInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->customerservice_id=$row["customerservice_id"];
		$this->customerservice_date=$row["customerservice_date"];
		$this->customerservice_no=$row["customerservice_no"];
	
		$this->remarks=$row['remarks'];
		$this->customer_id=$row['customer_id'];
		$this->employee_id=$row['employee_id'];
		$this->organization_id=$row['organization_id'];
		$this->isactive=$row['isactive'];
		$this->filename=$row['filename'];
	
	   	$this->log->showLog(4,"Customerservice->fetchCustomerserviceInfo,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Customerservice->fetchCustomerserviceInfo,failed to fetch data into databases.");	
	}
  } // end of member function fetchTuitionClassMaster


  public function getInputForm( $type,  $customerservice_id,$token ) {
	$filectrl="";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$uploadctrl="";
	$viewdetail="";

	$timestamp= date("Y-m-d", time()) ;

	if ($type=="new"){
		$header="New Organization";
		$action="create";
		if($customerservice_id==0){
		$this->customerservice_no="";
		$this->description="";
		$this->remarks="";
		$this->organization=0;
		}
		$this->customerservice_date=$timestamp;

		$savectrl="<input style='height:40px;' name='btnSave' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";

		$this->customerservice_no = getNewCode($this->xoopsDB,"customerservice_no",$this->tablecustomerservice);
	}
	else
	{
		$action="update";
		$savectrl="<input name='customerservice_id' value='$this->customerservice_id' type='hidden'>".
			 "<input style='height:40px;' name='btnSave' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablecustomerservice' type='hidden'>".
		"<input name='id' value='$this->customerservice_id' type='hidden'>".
		"<input name='idname' value='customerservice_id' type='hidden'>".
		"<input name='title' value='Customerservice' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";
		


		$header="Edit Customerservice";
		if($this->allowDelete($this->customerservice_id) && $this->customerservice_id>0)
		$deletectrl="<FORM action='customerservice.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this customer service?"'.")'><input style='height:40px;' type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->customerservice_id' name='customerservice_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

		$addnewctrl="<form action='customerservice.php' method='post'><input type='submit' value='New' value='New' style='height:40px;'></form>";

		

	}

		$viewdetail="<form target='_blank' action='customer.php' method='POST' name='frmViewDetails' onsubmit='if(customer_id.value < 1) return false;'>
		<input name='customer_id' value='0' type='hidden'>
		<input name='action' type='hidden' value='edit'>
		<input name='btnDetails' value='View Customer Details' type='submit' style='height:40px;' onclick='document.frmViewDetails.customer_id.value = document.frmCustomerservice.customer_id.value;'>
		</form>";


		$filename="upload/customerservices/".$this->filename;
		if(file_exists($filename) && $this->filename !="" && $this->filename !="/" && $this->filename !=" ")
			$filectrl="<a href='$filename' target='_blank' title='Training Material'>Download</a>";
		else
			$filectrl="<b style='color:red;'>No Attachment</b>";
		
		$uploadctrl='<tr><td class="head">Attachment '. $filectrl. '</td> <td class="even" colspan="3">Remove File <input type="checkbox" name="deleteAttachment" title="Choose it if you want to remove this attachment"> <input type="file" name="upload_file" size="50" title="Upload hardcopy here. Format in PDF"></td></tr>';


    echo <<< EOF
<br>
<table style="width:140px;"><tbody><td>$addnewctrl</td><td nowrap><form onsubmit="return validateCustomerservice()" method="post"
 action="customerservice.php" name="frmCustomerservice"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset" style='height:40px;'>
<input name="btnSearch" value="Search" type="button" onclick="showSearch();" style='height:40px;'></td></tbody></table>

 <table cellspacing='3' border='1'>

    <tr>
      <th>Description</th>
      <th>Data</th>
      <th>Description</th>
      <th>Data</th>
    </tr>
    <tr>
      <td class="head">Customer Service No</td>
      <td class="odd"><input name="customerservice_no" value="$this->customerservice_no" maxlength='10' size='10'>
	  &nbsp;&nbsp;Active&nbsp;&nbsp;<input type="checkbox" $checked name="isactive" ></td>
      <td class="head">Customer</td>
      <td class="odd">$this->customerctrl</td>
    </tr>
  <tbody>
 


	<tr>
	<td class="head">Employee</td>
	<td class="even">$this->employeectrl</td>
	<td class="head">Date</td>
	<td class="even">
	<input name='customerservice_date' id='customerservice_date' value="$this->customerservice_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->datectrl">
	</td>
	</tr>

	<tr>
		<td class="head">Remarks</td>
		<td class="odd" colspan="3"><textarea name="remarks" cols="60" rows="1">$this->remarks</textarea></td>
		
		<td class="head" style="display:none">Organization</td>
		<td class="even" style="display:none">$this->orgctrl</td>
    	</tr>


	$uploadctrl
  </tbody>
</table>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$viewdetail</td><td>$deletectrl</td></tbody></table>
$recordctrl
EOF;

  } // end of member function getInputForm

  /**
   *
   * @param int customerservicemaster_id 
   * @return bool
   * @access public
   */
  public function deleteCustomerservice( $customerservicemaster_id ) {
   	$this->log->showLog(2,"Warning: Performing delete customerservice id : $this->customerservice_id !");
	$sql="DELETE FROM $this->tablecustomerservice where customerservice_id=$this->customerservice_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: customerservice ($customerservice_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Customerservice ($customerservice_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteCustomerserviceMaster

public function getWhereString(){
	$retval = "";
	//echo $this->isactive;

	if($this->customerservice_no != "")
	$retval .= " and p.customerservice_no LIKE '$this->customerservice_no' ";
	if($this->customer_id > 0)
	$retval .= " and p.customer_id LIKE '$this->customer_id' ";
	if($this->employee_id > 0)
	$retval .= " and p.employee_id LIKE '$this->employee_id' ";
	if($this->isactive != "X" && $this->isactive != "")
	$retval .= " and p.isactive = '$this->isactive' ";
	if($this->start_date != "" && $this->end_date != "")
	$retval .= " and ( p.customerservice_date between '$this->start_date' and '$this->end_date' ) ";

	return $retval;
	
  }

/**
   * Display a customerservice list table
   *
   * 
   * @access public
   */
public function showCustomerserviceTable($category_id,$categoryselect="",$action=""){
	if($this->start_date=="")
	$this->start_date = getMonth(date("Ymd", time()),0) ;
   	
	if($this->end_date=="")
	$this->end_date = getMonth(date("Ymd", time()),1) ;

	//$wherestring=" and p.customer_id =  ";
	$this->log->showLog(3,"Showing Customerservice Table");
	
	$wherestring .= $this->getWhereString();
	
	
	if($action=="search")
	$sql=$this->getSQLStr_AllCustomerservice("where customerservice_id>0 $wherestring ","ORDER BY customerservice_date asc",0);
	else
	$sql = "";
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF

<form name="frmNew" action="customerservice.php" method="POST">
	<table>
	<tr>
	<td><input type="submit" value="New" style='height:40px;'></td>
	</tr>
	</table>
	</form>

	<form action="customerservice.php" method="POST" name="frmSearch">
	<input type="hidden" name="fldShow" value="">
	<input type="hidden" name="action" value="">
	<input type="hidden" value="" name="customerservice_id">
	<table border='1' cellspacing='3'>
	<tr>
	<td class="head">Customer Service No</td>
	<td class="even"><input type="text" name="customerservice_no" value=""></td>
	<td class="head">Customer</td>
	<td class="even">$this->customerctrl</td>
	<td class="head" style="display:none">Employee</td>
	<td class="even" style="display:none">$this->employeectrl</td>
	</tr>
	
	<tr>
	<td class="head">Active</td>
	<td class="even" colspan="3">
	<select name="isactive">
	<option value="X"></option>
	<option value="Y">Yes</option>
	<option value="N">No</option>
	</select>
	</td>
	<td class="head" style="display:none">Complete</td>
	<td class="even" style="display:none">
	<select name="iscomplete">
	<option value="X"></option>
	<option value="Y">Yes</option>
	<option value="N">No</option>
	</select>
	</tr>

	<tr>
	<td class="head">Date</td>
	<td class="even" colspan="3">
	<input name='start_date' id='start_date' value="$this->start_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->startctrl"> to  
	<input name='end_date' id='end_date' value="$this->end_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->endctrl">
	</td>
	</tr>
	

	
	
	<tr>
	<td class="head" colspan="4"><input type="button" value="Search" onclick="searchCustomer();" style='height:40px;'></td>
	</tr>

	</table></form>
	<br>


	<form name=frmATZ action="customerservice.php" method="POST">
	<div style="display:none">
	<b style="display:none">Customer service Grouping By Category: </b>
	$categoryselect
	<input type="hidden" name="filterstring" value=$this->filterstring style="display:none">
	</form>
	</div>

	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Customer Service No</th>
				<th style="text-align:center;">Customer Service Date</th>
				<th style="text-align:center;">Customer</th>
				<th style="text-align:center;">Remarks</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">View</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$customerservice_id=$row['customerservice_id'];
		$customerservice_no=$row['customerservice_no'];
		$customerservice_date=$row['customerservice_date'];
		$customer_name=$row['customer_name'];
		$employee_name=$row['employee_name'];
		$remarks=$row['remarks1'];
		$filename=$row['filename'];
		
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];
		
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		$path="upload/customerservices/".$filename;
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$customerservice_no</td>
			<td class="$rowtype" style="text-align:center;">$customerservice_date</td>
			<td class="$rowtype" style="text-align:center;">$customer_name</td>
			<td class="$rowtype" style="text-align:center;">$remarks</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>

			<td class="$rowtype" style="text-align:center;">
				<form action="$path" method="POST" target="_blank">
				<input type="image" src="images/list.gif" name="submit" title='View this image'>
				<input type="hidden" value="$customerservice_id" name="customerservice_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

			<td class="$rowtype" style="text-align:center;">
				<form action="customerservice.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this record'>
				<input type="hidden" value="$customerservice_id" name="customerservice_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

/**
   * get latest generated customerservice
   * 
   * return int  customerservice_id (latest)
   * @access public
   */
  public function getLatestCustomerserviceID(){
  	$sql="SELECT MAX(customerservice_id) as customerservice_id from $this->tablecustomerservice;";
	$this->log->showLog(3, "Retrieveing last customerservice id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['customerservice_id'];
	else
	return -1;
	

  }


public function getSelectCustomerservice($id,$isitem='NY',$calledfunction="") {

	$wherestring="";
	/*
	if ($isitem=='YN')
		$wherestring=" WHERE ((p.isactive='Y' and c.isitem <> 'C')";
	elseif($isitem=="Y")
		$wherestring=" WHERE ((p.isactive='Y' and c.isitem = 'Y')";
	elseif($isitem=="N")
		$wherestring=" WHERE ((p.isactive='Y' and c.isitem = 'N')";
	elseif($isitem=="A")
		$wherestring=" WHERE ((p.isactive='Y' )";

	else
		$wherestring=" WHERE ((p.isactive='Y' and c.isitem = 'C' )";
*/
	
	//$wherestring=" WHERE ((p.isactive='Y' and c.isitem = 'C' )";

// 	$sql="SELECT p.customerservice_id,p.customerservice_name from $this->tablecustomerservice p ".
// 		"inner join $this->tablecategory c on c.category_id=p.category_id ".
// 		"$wherestring or (p.customerservice_id=$id)  order by customerservice_name ;";

	$sql = "SELECT * from $this->tablecustomerservice p, $this->tablecategory c where c.category_id=p.category_id order by customerservice_name";

	$this->log->showLog(4,"Excute SQL for generate customerservice list: $sql;");
	$selectctl="<SELECT name='customerservice_id' $calledfunction>";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$customerservice_id=$row['customerservice_id'];
		$customerservice_name=$row['customerservice_name'];
	
		if($id==$customerservice_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$customerservice_id' $selected>$customerservice_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getCustomerservicePrice($id){
	$this->log->showLog(3,"Retrieving default price for customerservice $id");
	$sql="SELECT customerservice_name,amt from $this->tablecustomerservice where customerservice_id=$id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$price=$row['amt'];
		$customerservice_name=$row['customerservice_name'];
		$this->log->showLog(3,"customerservice_id: have customerservicename: $customerservice_name with customerservice_id: $id");
		return $price;
	
	}
	else
	{
		$this->log->showLog(1,"Error, can't find customerservice_id: $id");
		return 0;
	}
	


  }
  public function savefile($tmpfile,$newfilename){

	if(move_uploaded_file($tmpfile, "upload/customerservices/$newfilename")){
	$sqlupdate="UPDATE $this->tablecustomerservice set filename='$newfilename' where customerservice_id=$this->customerservice_id";
	$qryUpdate=$this->xoopsDB->query($sqlupdate);
	}else{
	echo "Cannot Upload File";
	}
  }

  public function deletefile($customerservice_id){
	$sql="SELECT filename from $this->tablecustomerservice where customerservice_id=$customerservice_id";
	$query=$this->xoopsDB->query($sql);
	$myfilename="";
	if($row=$this->xoopsDB->fetchArray($query)){
		$myfilename=$row['filename'];
	}
	$myfilename="upload/customerservices/$myfilename";
	$this->log->showLog(3,"This file name: $myfilename");
	unlink("$myfilename ");
	$sqlupdate="UPDATE $this->tablecustomerservice set filename='-' where customerservice_id=$customerservice_id";
	$qryDelete=$this->xoopsDB->query($sqlupdate);
  }

  public function allowDelete($customerservice_id){
/*
	$tabletuitionclass = $this->tableprefix."simtrain_tuitionclass";
	$tablepaymentline = $this->tableprefix."simtrain_paymentline";
	$tableinventorymovement = $this->tableprefix."simtrain_inventorymovement";

	$sql="select sum(recordcount) as recordcount from (
		SELECT count(customerservice_id) as recordcount FROM $tabletuitionclass where customerservice_id=$customerservice_id
		UNION 
		SELECT count(customerservice_id) as recordcount FROM $tablepaymentline where customerservice_id=$customerservice_id
		UNION 
		SELECT count(customerservice_id) as recordcount FROM $tableinventorymovement where customerservice_id=$customerservice_id
		) as b1";
	
	$this->log->showLog(3,"Verified allowDelete for customerservice_id:$customerservice_id");
	$this->log->showLog(4,"With SQL: $sql");

	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$recordcount=$row['recordcount'];
		$this->log->showLog(3,"Found child record: $recordcount");

		if($recordcount==0 || $recordcount=="")
			return true;
		else
			return false;
	}*/
	return true;
  
}

    public function searchAToZ($categoryselect){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search customer easily. With function searchAToZ()");

echo <<< EOF

	
EOF;
	
	$this->log->showLog(3,"Complete generate list of short cut");
		echo <<<EOF


EOF;

  }

  public function getFirstCategory(){
  $retval = 0;

  $sql = "select category_id from  $this->tablecategory where category_id > 0 order by category_id asc limit 1";

  $this->log->showLog(4,"With SQL:$sql");
  $query=$this->xoopsDB->query($sql);
  if($row=$this->xoopsDB->fetchArray($query)){
  $retval = $row['category_id'];
  }
  return $retval;
  }

  public function updateFileAttachment($id){
	
  $sql = "update $this->tablecustomerservice set ";

  }


} // end of CustomerserviceMaster
?>

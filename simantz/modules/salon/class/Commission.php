<?php
/************************************************************************
Class Commission.php - Copyright kfhoo
**************************************************************************/

class Commission
{
  public $commission_id;
  public $commission_no;
  public $commission_name;
  public $commission_type;
  public $commission_amount = 0;
  public $commission_amountmax = 0;
  public $commission_percent = 0;
  public $commission_remarks;

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

  public $tablecommission;
  
  public $tableprefix;
  public $filename;

  public function Commission($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablecommission=$tableprefix."simsalon_commission";
	$this->log=$log;
  }


  public function insertCommission( ) {
	$this->log->showLog(3,"Creating product SQL:$sql");

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new product $this->commission_no");
 	$sql =	"INSERT INTO $this->tablecommission 	(commission_no,commission_name,commission_type,
							commission_amount,commission_amountmax,commission_percent,commission_remarks,
							isactive,created,createdby,updated,updatedby,organization_id) 
							values('$this->commission_no',
								'$this->commission_name',
								'$this->commission_type',
								$this->commission_amount,
								$this->commission_amountmax,
								$this->commission_percent,
								'$this->commission_remarks',
		'$this->isactive','$timestamp',$this->createdby,'$timestamp',$this->updatedby,$this->organization_id)";

	$this->log->showLog(4,"Before insert product SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert commission name '$commission_name'");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new commission name '$commission_name' successfully"); 
		return true;
	}
  } // end of member function insertClassMaster

  /**
   * Update class information
   *
   * @return bool
   * @access public
   */
  public function updateCommission() {
    $timestamp= date("y/m/d H:i:s", time()) ;
	$sql="";
	
 	$sql=	"UPDATE $this->tablecommission SET
		commission_no='$this->commission_no',
		commission_name='$this->commission_name',
		commission_type='$this->commission_type',
		commission_amount=$this->commission_amount,
		commission_amountmax=$this->commission_amountmax,
		commission_percent=$this->commission_percent,
		commission_remarks='$this->commission_remarks',
		updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id

		WHERE commission_id='$this->commission_id'";

	$this->log->showLog(3, "Update commission_id: $this->commission_id, '$this->commission_name'");
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
  public function getSqlStr_AllCommission( $wherestring,  $orderbystring,  $startlimitno ) {
  
    $sql= 	"SELECT * FROM $this->tablecommission a
		$wherestring $orderbystring";

   $this->log->showLog(4,"Running Commission->getSQLStr_AllCommission: $sql");
  return $sql;
  } // end of member function getSqlStr_AllClass

  /**
   * pull data from database into class.
   *
   * @param int masterclass_id 
   * @return bool
   * @access public
   */
  public function fetchCommissionInfo( $commission_id ) {
    
	$this->log->showLog(3,"Fetching product detail into class Commission.php.<br>");
		
	$sql="SELECT * FROM $this->tablecommission
	where commission_id=$commission_id";
	
	$this->log->showLog(4,"Commission->fetchCommissionInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->commission_id=$row["commission_id"];
		$this->commission_no=$row["commission_no"];
		$this->commission_name= $row['commission_name'];
		$this->commission_type= $row['commission_type'];
		$this->commission_amount=$row['commission_amount'];
		$this->commission_amountmax=$row['commission_amountmax'];
		$this->commission_percent=$row['commission_percent'];
		$this->commission_remarks=$row['commission_remarks'];
		$this->organization_id=$row['organization_id'];
		$this->isactive=$row['isactive'];
	
	   	$this->log->showLog(4,"Commission->fetchCommissionInfo,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Commission->fetchCommissionInfo,failed to fetch data into databases.");	
	}
  } // end of member function fetchCommissionInfo


  public function getInputForm( $type,  $commission_id,$token ) {
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
		if($commission_id==0){
		$this->commission_name="";
		$this->commission_no="";
		$this->description="";
		$this->commission_amount=0;
		$this->commission_amountmax=0;
		$this->organization=0;
		}

		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";

		$this->commission_no = getNewCode($this->xoopsDB,"commission_no",$this->tablecommission);
	}
	else
	{
		$action="update";
		$savectrl="<input name='commission_id' value='$this->commission_id' type='hidden'>".
			 "<input style='height:40px;' name='submit' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablecommission' type='hidden'>".
		"<input name='id' value='$this->commission_id' type='hidden'>".
		"<input name='idname' value='commission_id' type='hidden'>".
		"<input name='title' value='Commission' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		


		$header="Edit Commission";
		if($this->allowDelete($this->commission_id) && $this->commission_id>0)
		$deletectrl="<FORM action='commission.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this product?"'.")'><input style='height:40px;' type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->commission_id' name='commission_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

		$addnewctrl="<form action='commission.php' method='post'><input type='submit' value='New' value='New'></form>";
			
		if($this->commission_type=="S")
		$option1 = "SELECTED";
		else if($this->commission_type=="P")
		$option2 = "SELECTED";
		else
		$option3 = "SELECTED";

	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Commission List</span></big></big></big></div><br>
<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateCommission()" method="post"
 action="commission.php" name="frmCommission"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>

 <table cellspacing='3' border='1'>

    <tr>
      <th>Description</th>
      <th>Data</th>
      <th>Description</th>
      <th>Data</th>
    </tr>
    <tr>
      <td class="head">Commission No</td>
      <td class="odd"><input name="commission_no" value="$this->commission_no" maxlength='10' size='10'>
	  &nbsp;&nbsp;Active&nbsp;&nbsp;<input type="checkbox" $checked name="isactive" ></td>
      <td class="head">Commission Description</td>
      <td class="odd"><input name="commission_name" value="$this->commission_name"  maxlength='100' size='60'></td>
    </tr>
  <tbody>
    
    <tr>
      	<td class="head">Commission Type</td>
      	<td class="even">
	<select name="commission_type">
	<option value="S" $option1>Service</option>
	<option value="P" $option2>Product</option>
	<option value="P" $option3>Others</option>
	</select>
	</td>
      	<td class="head">Minimum Amount($this->cur_symbol)</td>
	<td class="even"><input name="commission_amount" value="$this->commission_amount" ></td>
    </tr>
    
    <tr>
	<td class="head">Percent (%)</td>
	<td class="odd"><input name="commission_percent" value="$this->commission_percent" ></td>
	<td class="head">Maximum Amount($this->cur_symbol)</td>
	<td class="odd"><input name="commission_amountmax" value="$this->commission_amountmax" ></td>
    </tr>

   <tr>
	<td class="head">Remarks</td>
	<td class="even" colspan="3"><textarea name="commission_remarks" cols="80" rows="1">$this->commission_remarks</textarea></td>
	
    </tr>
 <tr style="display:none">
	
	
	
	<td class="head" style="display:none">Organization</td>
	<td class="even" style="display:none">$this->orgctrl</td>
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
  public function deleteCommission( $productmaster_id ) {
   	$this->log->showLog(2,"Warning: Performing delete product id : $this->commission_id !");
	$sql="DELETE FROM $this->tablecommission where commission_id=$this->commission_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: product ($commission_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Commission ($commission_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteCommissionMaster


/**
   * Display a product list table
   *
   * 
   * @access public
   */
public function showCommissionTable(){
	$wherestring="";
	$this->log->showLog(3,"Showing Commission Table");
	$sql=$this->getSQLStr_AllCommission("where commission_id>0","ORDER BY commission_no",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Type</th>
				<th style="text-align:center;">Min Amount($this->cur_symbol)</th>
				<th style="text-align:center;">Max Amount($this->cur_symbol)</th>
				<th style="text-align:center;">Percent (%)</th>
				<th style="text-align:center;">Remarks</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$commission_id=$row['commission_id'];
		$commission_no=$row['commission_no'];
		$commission_name=$row['commission_name'];
		$commission_type=$row['commission_type'];
		$commission_amount=$row['commission_amount'];
		$commission_amountmax=$row['commission_amountmax'];
		$commission_percent=$row['commission_percent'];
		$commission_remarks=$row['commission_remarks'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		if($commission_type=="P")
		$commission_type = "Product";
		else
		$commission_type = "Service";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$commission_no</td>
			<td class="$rowtype" style="text-align:center;">$commission_name</td>
			<td class="$rowtype" style="text-align:center;">$commission_type</td>
			<td class="$rowtype" style="text-align:center;">$commission_amount</td>
			<td class="$rowtype" style="text-align:center;">$commission_amountmax</td>
			<td class="$rowtype" style="text-align:center;">$commission_percent</td>
			<td class="$rowtype" style="text-align:center;">$commission_remarks</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="commission.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this record'>
				<input type="hidden" value="$commission_id" name="commission_id">
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
   * return int  commission_id (latest)
   * @access public
   */
  public function getLatestCommissionID(){
  	$sql="SELECT MAX(commission_id) as commission_id from $this->tablecommission;";
	$this->log->showLog(3, "Retrieveing last product id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['commission_id'];
	else
	return -1;
	

  }


public function getSelectCommission($id,$isitem='NY',$calledfunction="") {

	$wherestring="";
	$tablecategory=$this->tableprefix ."simtrain_commissioncategory";
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

	$sql="SELECT p.commission_id,p.commission_name from $this->tablecommission p ".
		"inner join $tablecategory c on c.category_id=p.category_id ".
		"$wherestring or (p.commission_id=$id)) and p.commission_id>0 order by commission_name ;";

	$this->log->showLog(4,"Excute SQL for generate product list: $sql;");
	$selectctl="<SELECT name='commission_id' $calledfunction>";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$commission_id=$row['commission_id'];
		$commission_name=$row['commission_name'];
	
		if($id==$commission_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$commission_id' $selected>$commission_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getCommissionPrice($id){
	$this->log->showLog(3,"Retrieving default price for product $id");
	$sql="SELECT commission_name,amt from $this->tablecommission where commission_id=$id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$price=$row['amt'];
		$commission_name=$row['commission_name'];
		$this->log->showLog(3,"commission_id: have productname: $commission_name with commission_id: $id");
		return $price;
	
	}
	else
	{
		$this->log->showLog(1,"Error, can't find commission_id: $id");
		return 0;
	}
	


  }
  public function savefile($tmpfile,$newfilename){
	move_uploaded_file($tmpfile, "upload/products/$newfilename");
	$sqlupdate="UPDATE $this->tablecommission set filename='$newfilename' where commission_id=$commission_id";
	$qryUpdate=$this->xoopsDB->query($sqlupdate);
  }

  public function deletefile($commission_id){
	$sql="SELECT filename from $this->tablecommission where commission_id=$commission_id";
	$query=$this->xoopsDB->query($sql);
	$myfilename="";
	if($row=$this->xoopsDB->fetchArray($query)){
		$myfilename=$row['filename'];
	}
	$myfilename="upload/products/$myfilename";
	$this->log->showLog(3,"This file name: $myfilename");
	unlink("$myfilename ");
	$sqlupdate="UPDATE $this->tablecommission set filename='-' where commission_id=$commission_id";
	$qryDelete=$this->xoopsDB->query($sqlupdate);
  }

  public function allowDelete($commission_id){
/*
	$tabletuitionclass = $this->tableprefix."simtrain_tuitionclass";
	$tablepaymentline = $this->tableprefix."simtrain_paymentline";
	$tableinventorymovement = $this->tableprefix."simtrain_inventorymovement";

	$sql="select sum(recordcount) as recordcount from (
		SELECT count(commission_id) as recordcount FROM $tabletuitionclass where commission_id=$commission_id
		UNION 
		SELECT count(commission_id) as recordcount FROM $tablepaymentline where commission_id=$commission_id
		UNION 
		SELECT count(commission_id) as recordcount FROM $tableinventorymovement where commission_id=$commission_id
		) as b1";
	
	$this->log->showLog(3,"Verified allowDelete for commission_id:$commission_id");
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


} // end of CommissionMaster
?>

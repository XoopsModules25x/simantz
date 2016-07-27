<?php
/************************************************************************
Class Expenseslist.php - Copyright kfhoo
**************************************************************************/

class Expenseslist
{
  public $expenseslist_id;
  public $expenseslist_no;
  public $description;
  public $remarks;
  public $category_id;
  public $uom_id;
  public $filterstring;

  public $amt = 0;
  public $organization_id;
  public $created;
  public $updated;
  public $createdby;
  public $updatedby;
  public $isactive;
  public $cur_name;
  public $cur_symbol;
  public $expenseslist_name;
  public $isAdmin;
  public $orgctrl;
  public $uomctrl;
  public $categoryctrl;
  public $deleteAttachment;
  public $tableexpenseslist;
  public $tablecategory;
  public $tableprefix;
  public $filename;

  public function Expenseslist($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableexpenseslist=$tableprefix."simsalon_expenseslist";
	$this->tablecategory=$tableprefix."simsalon_expensescategory";
	$this->log=$log;
  }


  public function insertExpenseslist( ) {
	$this->log->showLog(3,"Creating product SQL:$sql");

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new product $this->expenseslist_no");
 	$sql="INSERT INTO $this->tableexpenseslist (expenseslist_name,expenseslist_no,description,remarks,".
	"category_id,uom_id,amt,isactive, created,createdby,updated,updatedby,organization_id) values(".
	"'$this->expenseslist_name','$this->expenseslist_no','$this->description','$this->remarks',$this->category_id,$this->uom_id,".
	"$this->amt,'$this->isactive','$timestamp',$this->createdby,'$timestamp',".
	"$this->updatedby,$this->organization_id)";
	$this->log->showLog(4,"Before insert product SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert product name '$expenseslist_name'");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new product name '$expenseslist_name' successfully"); 
		return true;
	}
  } // end of member function insertClassMaster

  /**
   * Update class information
   *
   * @return bool
   * @access public
   */
  public function updateExpenseslist($withfile='N' ) {
    $timestamp= date("y/m/d H:i:s", time()) ;
	$sql="";
	if($withfile=='N')
 	$sql="UPDATE $this->tableexpenseslist SET ".
	"expenseslist_no='$this->expenseslist_no',expenseslist_name='$this->expenseslist_name',description='$this->description',".
	"remarks='$this->remarks',category_id=$this->category_id,uom_id=$this->uom_id,amt=$this->amt,".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id ".
	" WHERE expenseslist_id='$this->expenseslist_id'";
	else
	$sql="UPDATE $this->tableexpenseslist SET ".
	"expenseslist_no='$this->expenseslist_no',expenseslist_name='$this->expenseslist_name',description='$this->description',".
	"remarks='$this->remarks',category_id=$this->category_id,uom_id=$this->uom_id,amt=$this->amt,".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id, ".
	"filename='$this->filename' WHERE expenseslist_id='$this->expenseslist_id'";

	
	$this->log->showLog(3, "Update expenseslist_id: $this->expenseslist_id, '$this->expenseslist_name'");
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
  public function getSqlStr_AllExpenseslist( $wherestring,  $orderbystring,  $startlimitno ) {
  
     $sql="SELECT *,p.isactive as isactive_m FROM $this->tableexpenseslist p " .
	" left outer join $this->tablecategory c on c.category_id=p.category_id ".
	" $wherestring $orderbystring";
   $this->log->showLog(4,"Running Expenseslist->getSQLStr_AllExpenseslist: $sql");
  return $sql;
  } // end of member function getSqlStr_AllClass

  /**
   * pull data from database into class.
   *
   * @param int masterclass_id 
   * @return bool
   * @access public
   */
  public function fetchExpenseslistInfo( $expenseslist_id ) {
    
	$this->log->showLog(3,"Fetching product detail into class Expenseslist.php.<br>");
		
	$sql="SELECT * FROM $this->tableexpenseslist ". 
			"where expenseslist_id=$expenseslist_id";
	
	$this->log->showLog(4,"Expenseslist->fetchExpenseslistInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->expenseslist_id=$row["expenseslist_id"];
		$this->expenseslist_no=$row["expenseslist_no"];
		$this->expenseslist_name= $row['expenseslist_name'];
		$this->description=$row['description'];
		$this->remarks=$row['remarks'];
		$this->category_id=$row['category_id'];
		$this->uom_id=$row['uom_id'];
		$this->amt=$row['amt'];
		$this->organization_id=$row['organization_id'];
		$this->isactive=$row['isactive'];
		$this->filename=$row['filename'];
	
	   	$this->log->showLog(4,"Expenseslist->fetchExpenseslistInfo,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Expenseslist->fetchExpenseslistInfo,failed to fetch data into databases.");	
	}
  } // end of member function fetchTuitionClassMaster


  public function getInputForm( $type,  $expenseslist_id,$token ) {
	$filectrl="";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$uploadctrl="";
	if ($type=="new"){
		$header="New Organization";
		$action="create";
		if($expenseslist_id==0){
		$this->expenseslist_name="";
		$this->expenseslist_no="";
		$this->description="";
		$this->remarks="";
		$this->amt=0;
		$this->organization=0;
		}

		$savectrl="<input style='height:40px;' name='btnSave' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";

		$this->expenseslist_no = getNewCode($this->xoopsDB,"expenseslist_no",$this->tableexpenseslist);
	}
	else
	{
		$action="update";
		$savectrl="<input name='expenseslist_id' value='$this->expenseslist_id' type='hidden'>".
			 "<input style='height:40px;' name='btnSave' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableexpenseslist' type='hidden'>".
		"<input name='id' value='$this->expenseslist_id' type='hidden'>".
		"<input name='idname' value='expenseslist_id' type='hidden'>".
		"<input name='title' value='Expenseslist' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";
		


		$header="Edit Expenseslist";
		if($this->allowDelete($this->expenseslist_id) && $this->expenseslist_id>0)
		$deletectrl="<FORM action='expenseslist.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this product?"'.")'><input style='height:40px;' type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->expenseslist_id' name='expenseslist_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

		$addnewctrl="<form action='expenseslist.php' method='post'><input type='submit' value='New' value='New' style='height:40px;'></form>";

		$filename="upload/expenses/".$this->filename;
		if(file_exists($filename) && $this->filename !="" && $this->filename !="/" && $this->filename !=" ")
			$filectrl="<a href='$filename' target='_blank' title='Training Material'>Download</a>";
		else
			$filectrl="<b style='color:red;'>No Attachment</b>";
		
		$uploadctrl='<tr><td class="head">Attachment '. $filectrl. '</td> <td class="even" colspan="3">Remove File <input type="checkbox" name="deleteAttachment" title="Choose it if you want to remove this attachment"> <input type="file" name="upload_file" size="50" title="Upload hardcopy here. Format in PDF"></td></tr>';

	}

    echo <<< EOF
<table style="width:140px;"><tbody><td nowrap>$addnewctrl</td><td nowrap><form onsubmit="return validateExpenseslist()" method="post"
 action="expenseslist.php" name="frmExpenseslist"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset" style='height:40px;'>
<input name="btnSearch" value="Search" type="button" onclick="showSearch();" style='height:40px;'>
<input type="hidden" name="fldShow" value="">
</td></tbody></table>

 <table cellspacing='3' border='1'>

    <tr>
      <th>Description</th>
      <th>Data</th>
      <th>Description</th>
      <th>Data</th>
    </tr>
    <tr>
      <td class="head">Expenses No</td>
      <td class="odd"><input name="expenseslist_no" value="$this->expenseslist_no" maxlength='10' size='10'>
	  &nbsp;&nbsp;Active<input type="checkbox" $checked name="isactive" >&nbsp;&nbsp;</td>
      <td class="head">Expenses Name</td>
      <td class="odd"><input name="expenseslist_name" value="$this->expenseslist_name"  maxlength='60' size='60'></td>
    </tr>
  <tbody>
    
    <tr>
      <td class="head">Category</td>
      <td class="even">$this->categoryctrl</td>
      <td class="head">Unit Of Measurement</td>
      <td class="even">$this->uomctrl</td>
    </tr>
    <tr>
      <td class="head">Description</td>
      <td class="odd" colspan='3'><input name="description" value="$this->description" size="100" maxsize="100"></td>
    </tr>

	
   
    <tr>
      	<td class="head">Amount($this->cur_symbol)</td>
      	<td class="even"><input name="amt" value="$this->amt" ></td>
	<td class="head">Remarks</td>
	<td class="even"><textarea name="remarks" cols="60" rows="1">$this->remarks</textarea></td>
    </tr>
	<tr style="display:none">
      
      <td class="head" style="display:none">Organization</td>
      <td class="odd" style="display:none">$this->orgctrl</td>
    </tr>
	$uploadctrl
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
  public function deleteExpenseslist( $productmaster_id ) {
   	$this->log->showLog(2,"Warning: Performing delete product id : $this->expenseslist_id !");
	$sql="DELETE FROM $this->tableexpenseslist where expenseslist_id=$this->expenseslist_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: product ($expenseslist_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Expenseslist ($expenseslist_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteExpenseslistMaster


/**
   * Display a product list table
   *
   * 
   * @access public
   */
public function showExpenseslistTable($category_id=0,$categoryselect=""){
	//$wherestring=" and p.category_id = $category_id ";

	if($this->start_date=="")
	$this->start_date = getMonth(date("Ymd", time()),0) ;
   	
	if($this->end_date=="")
	$this->end_date = getMonth(date("Ymd", time()),1) ;

	$wherestring = " where expenseslist_id>0 ";
	
	if($this->fldShow=="Y")
	$wherestring .= $this->getWhereString();
	else if($category_id >0){
	if($category_id > 0 && $this->fldShow == "")
	$wherestring .= " and p.category_id = $category_id ";
	}
	
	//$wherestring .= $this->getWhereString();


	$this->log->showLog(3,"Showing Expenseslist Table");
	$sql=$this->getSQLStr_AllExpenseslist(" $wherestring ","ORDER BY expenseslist_no",0);
	
	$query=$this->xoopsDB->query($sql);

	if($this->fldShow != "Y"){
	echo <<< EOF
	
	
	<form name=frmATZ action="expenseslist.php" method="POST">
	<b>Expenses Grouping By Category: </b>
	$categoryselect
	<input type="hidden" name="filterstring" value=$this->filterstring>
	<input type="hidden" name="fldShow" value="">
	</form>
EOF;
	}

	if($this->fldShow=="Y"){

echo <<< EOF
	<form name="frmNew" action="expenseslist.php" method="POST">
	<table>
	<tr>
	<td><input type="submit" value="New" style='height:40px;'>
	<input type="hidden" name="fldShow" value="N">
	</td>
	</tr>
	</table>
	</form>

	<form action="expenseslist.php" method="POST" name="frmSearch">
	<input type="hidden" name="fldShow" value="Y">
	<input type="hidden" name="action" value="">
	<input type="hidden" value="" name="expenseslist_id">
	<table border='1' cellspacing='3'>
	<tr>
	<td class="head">Expenses Code</td>
	<td class="even"><input type="text" name="expenseslist_no" value=""></td>
	<td class="head">Expenses Name</td>
	<td class="even"><input type="text" name="expenseslist_name" value="" size="30"></td>
	</tr>

	
	<tr style="display:none">
	<td class="head">Date (YYYY-MM-DD)</td>
	<td class="even" colspan="3">
	<input name='start_date' id='start_date' value="$this->start_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->startctrl"> to  
	<input name='end_date' id='end_date' value="$this->end_date" maxlength='10' size='10'>
        <input name='btnDate' value="Date" type="button" onclick="$this->endctrl">
	</td>
	</tr>

	<tr>
	<td class="head">Active</td>
	<td class="even" acolspan="3">
	<select name="isactive">
	<option value="X"></option>
	<option value="Y">Yes</option>
	<option value="N">No</option>
	</select>
	</td>

	<td class="head">Category</td>
	<td class="even">$this->categoryctrl</td>
	
	</tr>
	
	<tr>
	<td class="head" colspan="4"><input type="button" value="Search" onclick="searchExpenseslist();" style='height:40px;'></td>
	</tr>

	</table></form>
	<br>
EOF;
	}
	//if($this->fldShow=="Y"){
echo <<< EOF

	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Expenses No</th>
				<th style="text-align:center;">Expenses Name</th>
				<th style="text-align:center;">Category</th>
				<th style="text-align:center;">Amount($this->cur_symbol)</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$expenseslist_id=$row['expenseslist_id'];
		$expenseslist_no=$row['expenseslist_no'];
		$expenseslist_name=$row['expenseslist_name'];
		$amt=$row['amt'];
		$description=$row['description'];
		$remarks=$row['remarks'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive_m'];
		$category_name=$row['category_description'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$expenseslist_no</td>
			<td class="$rowtype" style="text-align:center;">$expenseslist_name</td>
			<td class="$rowtype" style="text-align:center;">$category_name</td>
			<td class="$rowtype" style="text-align:center;">$amt</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="expenseslist.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this record'>
				<input type="hidden" value="$expenseslist_id" name="expenseslist_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
	//}
 }

    public function getWhereString(){
	$retval = "";
	//echo $this->isactive;

	if($this->expenseslist_no != "")
	$retval .= " and p.expenseslist_no LIKE '$this->expenseslist_no' ";

	if($this->expenseslist_name != "")
	$retval .= " and p.expenseslist_name LIKE '$this->expenseslist_name' ";

	if($this->isactive != "X" && $this->isactive != "")
	$retval .= " and p.isactive = '$this->isactive' ";

	if($this->category_id > 0)
	$retval .= " and p.category_id = $this->category_id ";

	/*
	if($this->start_date != "" && $this->end_date != "")
	$retval .= " and ( p.expenseslist_date between '$this->start_date' and '$this->end_date' ) ";
	*/
	return $retval;
	
  }

/**
   * get latest generated product
   * 
   * return int  expenseslist_id (latest)
   * @access public
   */
  public function getLatestExpenseslistID(){
  	$sql="SELECT MAX(expenseslist_id) as expenseslist_id from $this->tableexpenseslist;";
	$this->log->showLog(3, "Retrieveing last product id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['expenseslist_id'];
	else
	return -1;
	

  }


public function getSelectExpenseslist($id,$isitem='NY',$calledfunction="") {

	$wherestring="";
	$tablecategory=$this->tableprefix ."simsalon_expensescategory";

	$wherestring=" WHERE p.isactive='Y' ";

 	$sql="SELECT p.expenseslist_id,p.expenseslist_name from $this->tableexpenseslist p ".
		"inner join $tablecategory c on c.category_id=p.category_id ".
		"$wherestring or p.expenseslist_id=$id order by expenseslist_name ;";

	$this->log->showLog(4,"Excute SQL for generate product list: $sql;");
	$selectctl="<SELECT name='expenseslist_id' $calledfunction>";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$expenseslist_id=$row['expenseslist_id'];
		$expenseslist_name=$row['expenseslist_name'];
	
		if($id==$expenseslist_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$expenseslist_id' $selected>$expenseslist_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getExpenseslistPrice($id){
	$this->log->showLog(3,"Retrieving default price for product $id");
	$sql="SELECT expenseslist_name,amt from $this->tableexpenseslist where expenseslist_id=$id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$price=$row['amt'];
		$expenseslist_name=$row['expenseslist_name'];
		$this->log->showLog(3,"expenseslist_id: have productname: $expenseslist_name with expenseslist_id: $id");
		return $price;
	
	}
	else
	{
		$this->log->showLog(1,"Error, can't find expenseslist_id: $id");
		return 0;
	}
	


  }
  public function savefile($tmpfile,$newfilename){

	if(move_uploaded_file($tmpfile, "upload/expenses/$newfilename")){
	//move_uploaded_file($tmpfile, "upload/category/$newfilename");
	$sqlupdate="UPDATE $this->tableexpenseslist set filename='$newfilename' where expenseslist_id=$this->expenseslist_id";
	$qryUpdate=$this->xoopsDB->query($sqlupdate);
	}else{
	echo "Cannot Upload File";
	}

	
	
  }

  public function deletefile($expenseslist_id){
	$sql="SELECT filename from $this->tableexpenseslist where expenseslist_id=$expenseslist_id";
	$query=$this->xoopsDB->query($sql);
	$myfilename="";
	if($row=$this->xoopsDB->fetchArray($query)){
		$myfilename=$row['filename'];
	}
	$myfilename="upload/expenses/$myfilename";
	$this->log->showLog(3,"This file name: $myfilename");
	unlink("$myfilename ");
	$sqlupdate="UPDATE $this->tableexpenseslist set filename='-' where expenseslist_id=$expenseslist_id";
	$qryDelete=$this->xoopsDB->query($sqlupdate);
  }

  public function allowDelete($expenseslist_id){
/*
	$tabletuitionclass = $this->tableprefix."simtrain_tuitionclass";
	$tablepaymentline = $this->tableprefix."simtrain_paymentline";
	$tableinventorymovement = $this->tableprefix."simtrain_inventorymovement";

	$sql="select sum(recordcount) as recordcount from (
		SELECT count(expenseslist_id) as recordcount FROM $tabletuitionclass where expenseslist_id=$expenseslist_id
		UNION 
		SELECT count(expenseslist_id) as recordcount FROM $tablepaymentline where expenseslist_id=$expenseslist_id
		UNION 
		SELECT count(expenseslist_id) as recordcount FROM $tableinventorymovement where expenseslist_id=$expenseslist_id
		) as b1";
	
	$this->log->showLog(3,"Verified allowDelete for expenseslist_id:$expenseslist_id");
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


} // end of ExpenseslistMaster
?>

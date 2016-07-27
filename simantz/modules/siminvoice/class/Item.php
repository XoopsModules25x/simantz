<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class Item
{

public	$item_id;
public	$item_code;
public	$item_desc;
public	$category_id;
public	$item_amount;
public	$item_cost;
public	$itemctrl;
public 	$categoryctrl;


public	$created;
public	$createdby;
public	$updated;
public	$updatedby;
public	$isactive;

public  $xoopsDB;
public  $tableprefix;
public  $tableitem;
public  $tablecategory;
public  $tablecustomer;
public  $tableinvoice;
public  $tablequotation;
public  $tableinvoiceline;
public  $tablequotationline;
public  $log;



//constructor
   public function Item($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableitem=$tableprefix."tblitem";
	$this->tablecategory=$tableprefix."tblcategory";
	$this->tableincustomer=$tableprefix."tblcustomer";
	$this->tableinvoice=$tableprefix."tblinvoice";
	$this->tablequotation=$tableprefix."tblquotation";
	$this->tableinvoiceline=$tableprefix."tblinvoiceline";
	$this->tablequotationline=$tableprefix."tblquotationline";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int item_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $item_id, $token  ) {

   $header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	if($this->item_cost=="")
		$this->item_cost = 0;
		
	if($this->item_amount=="")
		$this->item_amount = 0;


		
	$this->created=0;
	if ($type=="new"){
		$header="New Item";
		$action="create";
	 	
		if($item_code==0){
			$this->item_code=$this->getNewItem();
			$this->item_desc="";
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
		$savectrl="<input name='item_id' value='$this->item_id' type='hidden'>".
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
	
		$header="Edit Item";
		
		if($this->allowDelete($this->item_id))
		$deletectrl="<FORM action='item.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this item?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->item_id' name='item_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else

		$deletectrl="";
	
	}

    echo <<< EOF


<table style="width:140px;"><tbody><td><form onsubmit="return validateItem()" method="post"
 action="item.php" name="frmItem"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        	<td class="head">Item Code *</td>
        	<td class="odd" ><input name='item_code' value="$this->item_code" maxlength='10' size='15'> </td>
        	<td class="head">Item Description *</td>
        	<td class="odd"><input maxlength="40" size="50" name="item_desc" value="$this->item_desc"></td>
      </tr>
      
		<tr>
			<td class="head">Active</td>
			<td  class="even"> <input type='checkbox' $checked name='isactive'></td>
			<td class="head">Category</td>
			<td  class="even">$this->categoryctrl</td>
		</tr>
		
		<tr>
        	<td class="head">Item Standard Amount (RM) <br>(Selling Price)</td>
        	<td class="odd" ><input name='item_amount' value="$this->item_amount" maxlength='10' size='15' onfocus='this.select();' onclick='this.select();' autocomplete='off'> </td>
        	<td class="head">Item Cost (RM) <br>(Purchase Price)</td>
        	<td class="odd"><input maxlength="10" size="15" name="item_cost" value="$this->item_cost" onfocus='this.select();' onclick='this.select();' autocomplete='off'></td>
      </tr>
      		<tr>
        	<td class="head">Unit Of Measurement</td>
        	<td class="even" ><input name='item_uom' value="$this->item_uom" maxlength='10' size='9'> </td>
        	<td class="head"></td>
        	<td class="even"></td>
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

 
  public function updateItem( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableitem SET
	item_code='$this->item_code',
	item_desc='$this->item_desc',
	category_id='$this->category_id',
	item_amount='$this->item_amount',
	item_cost='$this->item_cost',
	item_uom='$this->item_uom',
	updated='$timestamp',
	updatedby=$this->updatedby,
	isactive=$this->isactive
	WHERE item_id=$this->item_id";
	
	$this->log->showLog(3, "Update item_id: $this->item_id, $this->item_desc");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update item failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update item successfully.");
		return true;
	}
  } // end of member function updateItem


  public function insertItem( ) {
  
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new item $this->item_desc");
 	$sql="INSERT INTO $this->tableitem 
 			(item_code,item_desc,category_id,item_amount,item_cost,item_uom,createdby,created,updatedby,updated,isactive) 
 			values 	('$this->item_code',
						'$this->item_desc',
						'$this->category_id',
						'$this->item_amount',
						'$this->item_cost',
						'$this->item_uom',
						 $this->createdby,
						'$timestamp',
						 $this->updatedby,
						'$timestamp',
						 $this->isactive)";
	$this->log->showLog(4,"Before insert item SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert item code $item_desc");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new item $item_desc successfully"); 
		return true;
	}
  } // end of member function insertItem


  public function fetchItem( $item_id) {
    
    //echo $item_id;
	$this->log->showLog(3,"Fetching item detail into class Item.php.<br>");
		
	$sql="SELECT item_id,item_code,item_uom,item_desc,category_id,item_amount,item_cost,created,createdby,updated, updatedby, isactive 
			from $this->tableitem 
			where item_id=$item_id";
	
	$this->log->showLog(4,"ProductItem->fetchItem, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$this->item_code=$row['item_code'];
	$this->item_desc=$row['item_desc'];
	$this->category_id=$row['category_id'];
	$this->item_amount=$row['item_amount'];
	$this->item_cost=$row['item_cost'];
	$this->item_uom=$row['item_uom'];
	$this->isactive=$row['isactive'];
	
   $this->log->showLog(4,"Item->fetchItem,database fetch into class successfully");	
	$this->log->showLog(4,"item_desc:$this->item_desc");
	$this->log->showLog(4,"description:$this->description");
	$this->log->showLog(4,"isactive:$this->isactive");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Item->fetchItem,failed to fetch data into databases.");	
	}
  } // end of member function fetchItem

  public function deleteItem( $item_id ) {
    	$this->log->showLog(2,"Warning: Performing delete item id : $item_id !");
	$sql="DELETE FROM $this->tableitem where item_id=$item_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: item ($item_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"item ($item_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteItem

  
  public function getSQLStr_AllItem( $wherestring,  $orderbystring,  $startlimitno,$recordcount ) {

/*
    $sql="SELECT c.item_id,c.item_code,c.item_desc,c.street1,c.street2,".
		"c.postcode,c.city,c.state1,c.country,".
		"c.contactperson,c.contactperson_no,c.tel1,c.tel2,c.fax,c.description,".
		"c.created,c.createdby,c.updated, c.updatedby, c.isactive, c.isdefault,c.currency_id, ".
		"cr.currency_symbol FROM $this->tableitem c " .
		"left join $this->tablecurrency cr on c.currency_id = cr.currency_id ".
	" $wherestring $orderbystring LIMIT $startlimitno,$recordcount";
	*/
	
	$sql = "SELECT a.category_desc,c.item_id,c.item_code,c.item_desc,c.category_id,c.item_amount,c.item_cost,c.created,c.createdby,c.updated, c.updatedby, c.isactive
				FROM $this->tableitem c, $this->tablecategory a 
				$wherestring $orderbystring LIMIT $startlimitno,$recordcount ";
				
  $this->log->showLog(4,"Running ProductItem->getSQLStr_AllItem: $sql"); 
 return $sql;
  } // end of member function getSQLStr_AllItem

 public function showItemTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0){
	$this->log->showLog(3,"Showing Item Table");
	$sql=$this->getSQLStr_AllItem($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	$query=$this->xoopsDB->query($sql);
	
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Item No</th>
				<th style="text-align:center;">Item Description</th>
				<th style="text-align:center;">Category</th>
				<th style="text-align:center;">Purchase<br>Price (RM)</th>
				<th style="text-align:center;">Selling<br>Price (RM)</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$item_id=$row['item_id'];
		$item_code=$row['item_code'];
		$item_desc=$row['item_desc'];
		$item_cost=$row['item_cost'];
		$item_amount=$row['item_amount'];
		$category_id=$row['category_id'];
		$category_desc=$row['category_desc'];

		$isactive=$row['isactive'];
	
		// isactive 
		if($isactive=="1")
			$isactive = "Yes";
		else
			$isactive = "No";
			

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$item_code</td>
			<td class="$rowtype" style="text-align:center;">$item_desc</td>
			<td class="$rowtype" style="text-align:center;">$category_desc</td>
			<td class="$rowtype" style="text-align:center;">$item_cost</td>
			<td class="$rowtype" style="text-align:center;">$item_amount</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="item.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this item'>
				<input type="hidden" value="$item_id" name="item_id">
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
	$this->log->showLog(3,"Showing Item Table");
	
	$sql=$this->getSQLStr_AllItem($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	
	if($orderctrl=='asc'){
	
	if($fldSort=='item_code')
	$sortimage1 = 'images/sortdown.gif';
	else
	$sortimage1 = 'images/sortup.gif';
	if($fldSort=='item_desc')
	$sortimage2 = 'images/sortdown.gif';
	else
	$sortimage2 = 'images/sortup.gif';
	if($fldSort=='category_id')
	$sortimage3 = 'images/sortdown.gif';
	else
	$sortimage3 = 'images/sortup.gif';
	if($fldSort=='isactive')
	$sortimage4 = 'images/sortdown.gif';
	else
	$sortimage4 = 'images/sortup.gif';
	
	}else{
	$sortimage1 = 'images/sortup.gif';
	$sortimage2 = 'images/sortup.gif';
	$sortimage3 = 'images/sortup.gif';
	$sortimage4 = 'images/sortup.gif';
	}


	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Item Code <br><input type='image' src="$sortimage1" name='submit'  title='Sort this record' onclick = " headerSort('item_code');"></th>
				<th style="text-align:center;">Item Description <br><input type='image' src="$sortimage2" name='submit'  title='Sort this record' onclick = " headerSort('item_desc');"></th>
				<th style="text-align:center;">Category <br><input type='image' src="$sortimage3" name='submit'  title='Sort this record' onclick = " headerSort('category_id');"></th>
				<th style="text-align:center;">Active <br><input type='image' src="$sortimage4" name='submit'  title='Sort this record' onclick = " headerSort('isactive');"></th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$item_id=$row['item_id'];
		$item_code=$row['item_code'];
		$item_desc=$row['item_desc'];
		$category_id=$row['category_id'];
		$category_desc=$row['category_desc'];

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
			<td class="$rowtype" style="text-align:center;">$item_code</td>
			<td class="$rowtype" style="text-align:center;">$item_desc</td>
			<td class="$rowtype" style="text-align:center;">$category_desc</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="item.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this item'>
				<input type="hidden" value="$item_id" name="item_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	
		
		
		$printctrl="<tr><td colspan='11' align=right><form action='viewitem.php' method='POST' target='_blank' name='frmPdf'>
					<input type='image' src='images/reportbutton.jpg'>
					<input type='hidden' name='wherestr' value=\"$wherestring\">
					<input type='hidden' name='orderstr' value='$orderbystring'>
					</form></td></tr>";
					
	echo $printctrl;

	echo  "</tr></tbody></table>";
 }



   
   
 public function searchAToZ(){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search item easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(item_desc,1)) as shortname FROM $this->tableitem where isactive='1' and item_code <> '0' order by item_desc";
	$this->log->showLog(4,"With SQL:$sqlfilter");
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	$firstname="";
	echo "<b>Item Grouping By Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if item never do filter yet, if will choose 1st item listing
		
		echo "<A style='font-size:12;' href='item.php?filterstring=$shortname'>  $shortname  </A> ";
	}
	
	$this->log->showLog(3,"Complete generate list of short cut");
		echo <<<EOF
<BR>
<A href='item.php?action=new' style='color: GRAY'><img src="images/addnew.jpg"</A>
<A href='item.php?action=showSearchForm' style='color: gray'><img src="images/search.jpg"</A>

EOF;
return $filterstring;
  }
  
  
  
  


  public function getLatestItemID() {
	$sql="SELECT MAX(item_id) as item_id from $this->tableitem;";
	$this->log->showLog(3,'Checking latest created item_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created item_id:' . $row['item_id']);
		return $row['item_id'];
	}
	else
	return -1;
	
  } // end
  
  
  public function getNewItem() {
	$sql="SELECT MAX(item_code) as item_code from $this->tableitem;";
	$this->log->showLog(3,'Checking latest created item_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created item_code:' . $row['item_code']);
		$item_code=$row['item_code']+1;
		return $item_code;
	}
	else
	return 0;
	
  } // end
  
  

  public function getSelectItem($id) {
	
	$sql="SELECT item_id,item_desc from $this->tableitem where isactive=1 or item_id=$id " .
		" order by item_desc";
	$selectctl="<SELECT name='item_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$item_id=$row['item_id'];
		$item_desc=$row['item_desc'];
	
		if($id==$item_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$item_id' $selected>$item_desc</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end
  
  /*
   public function getSelectItemArray($id) {
	
	$sql="SELECT item_id,item_desc from $this->tableitem where isactive=1 or item_id=$id " .
		" order by item_desc";
	$selectctl="<SELECT name='item_id[]' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"></OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$item_id=$row['item_id'];
		$item_desc=$row['item_desc'];
	
		if($id==$item_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$item_id' $selected>$item_desc</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end
  */


 public function getSelectCategory($id) {
	
	$sql="SELECT category_id,category_code,category_desc from $this->tablecategory where isactive=1 or category_id=$id " .
		" order by category_desc";
	$selectctl="<SELECT name='category_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$category_code=$row['category_id'];
		$category_desc=$row['category_desc'];
	
		if($id==$category_code)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$category_code' $selected>$category_desc</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	$sql="SELECT sum(r.rowcount) as rowcount from (
		SELECT count(item_id) as rowcount from $this->tableinvoiceline where item_id=$id
		UNION ALL
		SELECT count(item_id) as rowcount from $this->tablequotationline where item_id=$id
		
	) as r";
	
	$this->log->showLog(3,"Accessing ProductItem->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this item, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this item, record deletable");
		return true;
		}
	}


 public function showItemHeader($item_id){
	if($this->fetchItem($item_id)){
		$this->log->showLog(4,"Showing item header successfully.");
	echo <<< EOF
	<table border='1' cellspacing='3'>
		<tbody>
			<tr>
				<th colspan="4">Item Info</th>
			</tr>
			<tr>
				<td class="head">Item No</td>
				<td class="odd">$this->item_code</td>
				<td class="head">Item Description</td>
				<td class="odd"><A href="item.php?action=edit&item_id=$item_id" 
						target="_blank">$this->item_desc</A></td>
			</tr>
		</tbody>
	</table>
EOF;
	}
	else{
		$this->log->showLog(1,"<b style='color:red;'>Showing item header failed.</b>");
	}

   }//showRegistrationHeader
   
   
  
  
 public function showSearchForm($wherestring="",$orderctrl=""){

   echo <<< EOF

	<FORM action="item.php" method="POST" name="frmActionSearch" id="frmActionSearch">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criteria</th>
	    </tr>
	    <tr>
	      <td class='head'>Item No</td>
	      <td class='even'><input name='item_code' value='$this->item_code'> (%, AB%,%AB,%A%B%)</td>
	      <td class='head'>Item Description</td>
	      <td class='even'><input name='item_desc' value='$this->item_desc'>%ali, %ali%, ali%, %ali%bin%</td>
	    </tr>
	    <tr>
	      <td class='head'>Quick Search</td>
	      <td class='odd'>$this->itemctrl</td>
	      <td class='head'>Is Active</td>
	      <td class='odd'>
		<select name="isactive">
			<option value="-1">Null</option>
			<option value="1" >Y</option>
			<option value="0" >N</option>
		</select>
		</td>
	    </tr>
	    
	<tr>
	      <td class='head'>Category</td>
	      <td class='odd'>$this->categoryctrl</td>
		<td></td>
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

  public function convertSearchString($item_id,$item_code,$item_desc,$isactive,$category_id){
$filterstring="";


if($item_id > 0 ){
	$filterstring=$filterstring . " c.item_id=$item_id AND";
}

if($item_code!=""){
	$filterstring=$filterstring . " c.item_code LIKE '$item_code' AND";
}

if($item_desc!=""){
	$filterstring=$filterstring . "  c.item_desc LIKE '$item_desc' AND";
}

/*
if($category_id!=""){
	$filterstring=$filterstring . "  c.category_id LIKE '$category_id' AND";
}*/


if ($category_id!="0")
$filterstring=$filterstring . " c.category_id =$category_id AND";

if ($isactive!="-1")
$filterstring=$filterstring . " c.isactive =$isactive AND";

if ($filterstring=="")
	return "";
else {
	$filterstring =substr_replace($filterstring,"",-3);  

	return "WHERE $filterstring";
	}
	
}
  	
  

} // end of ClassItem
?>



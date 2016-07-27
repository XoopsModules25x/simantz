<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class Category
{

public	$category_id;
public	$category_code;
public	$category_desc;
public	$category_type;
public	$categoryctrl;


public	$created;
public	$createdby;
public	$updated;
public	$updatedby;
public	$isactive;

public  $xoopsDB;
public  $tableprefix;
public  $tablecategory;
public  $tableitem;
public  $tablecustomer;
public  $tableinvoice;
public  $tablequotation;
public  $log;



//constructor
   public function Category($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablecategory=$tableprefix."tblcategory";
	$this->tableitem=$tableprefix."tblitem";
	$this->tableincustomer=$tableprefix."tblcustomer";
	$this->tableinvoice=$tableprefix."tblinvoice";
	$this->tablequotation=$tableprefix."tblquotation";
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int category_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $category_id, $token  ) {

   $header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	

		$selected_n = ''; 
		$selected_s = '';
		$selected_c = '';
 

 		
		if($this->category_type == '')
		$selected_n = "selected='selected'";
		if($this->category_type == 'S')
		$selected_s = "selected='selected'";
		if($this->category_type == 'C')
		$selected_c = "selected='selected'";
		
	$this->created=0;
	if ($type=="new"){
		$header="New Category";
		$action="create";
	 	
		if($category_code==0){
			$this->category_code=$this->getNewCategory();
			$this->category_desc="";
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
		$savectrl="<input name='category_id' value='$this->category_id' type='hidden'>".
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
	
		$header="Edit Category";
		
		if($this->allowDelete($this->category_id))
		$deletectrl="<FORM action='category.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this category?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->category_id' name='category_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else

		$deletectrl="";
	
	}

    echo <<< EOF


<table style="width:140px;"><tbody><td><form onsubmit="return validateCategory()" method="post"
 action="category.php" name="frmCategory"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        	<td class="head">Category Code *</td>
        	<td class="odd" ><input name='category_code' value="$this->category_code" maxlength='10' size='15'> </td>
        	<td class="head">Category Desc *</td>
        	<td class="odd"><input maxlength="40" size="50" name="category_desc" value="$this->category_desc"></td>
      </tr>
      
		<tr>
			<td class="head">Active</td>
			<td  class="odd"> <input type='checkbox' $checked name='isactive'></td>
			<td class="head">Type</td>
			<td  class="odd">
			<select name="category_type">
			<option value="S" $selected_s>Stock</option>
			<option value="C" $selected_c>Charges</option>
			</select>			
			</td>
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

 
  public function updateCategory( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablecategory SET
	category_code='$this->category_code',
	category_desc='$this->category_desc',
	category_type='$this->category_type',
	updated='$timestamp',
	updatedby=$this->updatedby,
	isactive=$this->isactive
	WHERE category_id=$this->category_id";
	
	$this->log->showLog(3, "Update category_id: $this->category_id, $this->category_desc");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update category failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update category successfully.");
		return true;
	}
  } // end of member function updateCategory


  public function insertCategory( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new category $this->category_desc");
 	$sql="INSERT INTO $this->tablecategory 
 			(category_code,category_desc,category_type,createdby,created,updatedby,updated,isactive) 
 			values 	('$this->category_code',
						'$this->category_desc',
						'$this->category_type',
						 $this->createdby,
						'$timestamp',
						 $this->updatedby,
						'$timestamp',
						 $this->isactive)";
	$this->log->showLog(4,"Before insert category SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert category code $category_desc");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new category $category_desc successfully"); 
		return true;
	}
  } // end of member function insertCategory


  public function fetchCategory( $category_id) {
    
    //echo $category_id;
	$this->log->showLog(3,"Fetching category detail into class Category.php.<br>");
		
	$sql="SELECT category_id,category_code,category_desc,category_type,created,createdby,updated, updatedby, isactive 
			from $this->tablecategory 
			where category_id=$category_id";
	
	$this->log->showLog(4,"ProductCategory->fetchCategory, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$this->category_code=$row['category_code'];
	$this->category_desc=$row['category_desc'];
	$this->category_type=$row['category_type'];
	$this->isactive=$row['isactive'];
	
   $this->log->showLog(4,"Category->fetchCategory,database fetch into class successfully");	
	$this->log->showLog(4,"category_desc:$this->category_desc");
	$this->log->showLog(4,"description:$this->description");
	$this->log->showLog(4,"isactive:$this->isactive");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Category->fetchCategory,failed to fetch data into databases.");	
	}
  } // end of member function fetchCategory

  public function deleteCategory( $category_id ) {
    	$this->log->showLog(2,"Warning: Performing delete category id : $category_id !");
	$sql="DELETE FROM $this->tablecategory where category_id=$category_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: category ($category_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"category ($category_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteCategory

  
  public function getSQLStr_AllCategory( $wherestring,  $orderbystring,  $startlimitno,$recordcount ) {
	
	$sql = "SELECT c.category_id,c.category_code,c.category_desc,c.category_type,c.created,c.createdby,c.updated, c.updatedby, c.isactive
				FROM $this->tablecategory c 
				$wherestring $orderbystring LIMIT $startlimitno,$recordcount ";
				
  $this->log->showLog(4,"Running ProductCategory->getSQLStr_AllCategory: $sql"); 
 return $sql;
  } // end of member function getSQLStr_AllCategory

 public function showCategoryTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0){
	$this->log->showLog(3,"Showing Category Table");
	$sql=$this->getSQLStr_AllCategory($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Category No</th>
				<th style="text-align:center;">Category Description</th>
				<th style="text-align:center;">Category Type</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$category_id=$row['category_id'];
		$category_code=$row['category_code'];
		$category_desc=$row['category_desc'];
		$category_type=$row['category_type'];
		$isactive=$row['isactive'];
		
		// category 
		if($category_type=="S")
			$category_type = "Stock";
		else
			$category_type = "Charges";
	
	
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
			<td class="$rowtype" style="text-align:center;">$category_code</td>
			<td class="$rowtype" style="text-align:center;">$category_desc</td>
			<td class="$rowtype" style="text-align:center;">$category_type</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="category.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this category'>
				<input type="hidden" value="$category_id" name="category_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

  
  
  // start search table
  
  public function showSearchTable( $wherestring="",  $orderbystring="",  $startlimitno=0, $recordcount=0, $orderctrl="", $fldSort =""){
	$this->log->showLog(3,"Showing Category Table");
	
	$sql=$this->getSQLStr_AllCategory($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	
	if($orderctrl=='asc'){
	
	if($fldSort=='category_code')
	$sortimage1 = 'images/sortdown.gif';
	else
	$sortimage1 = 'images/sortup.gif';
	if($fldSort=='category_desc')
	$sortimage2 = 'images/sortdown.gif';
	else
	$sortimage2 = 'images/sortup.gif';
	if($fldSort=='category_type')
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
				<th style="text-align:center;">Category Code <br><input type='image' src="$sortimage1" name='submit'  title='Sort this record' onclick = " headerSort('category_code');"></th>
				<th style="text-align:center;">Category Description <br><input type='image' src="$sortimage2" name='submit'  title='Sort this record' onclick = " headerSort('category_desc');"></th>
				<th style="text-align:center;">Category Type <br><input type='image' src="$sortimage3" name='submit'  title='Sort this record' onclick = " headerSort('category_type');"></th>
				<th style="text-align:center;">Active <br><input type='image' src="$sortimage4" name='submit'  title='Sort this record' onclick = " headerSort('isactive');"></th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$category_id=$row['category_id'];
		$category_code=$row['category_code'];
		$category_desc=$row['category_desc'];
		$category_type=$row['category_type'];

		$isactive=$row['isactive'];
		
		// category 
		if($category_type=="S")
			$category_type = "Stock";
		else
			$category_type = "Charges";
	
	
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
			<td class="$rowtype" style="text-align:center;">$category_code</td>
			<td class="$rowtype" style="text-align:center;">$category_desc</td>
			<td class="$rowtype" style="text-align:center;">$category_type</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="category.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this category'>
				<input type="hidden" value="$category_id" name="category_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	
		
		$printctrl="<tr><td colspan='11' align=right><form action='viewcategory.php' method='POST' target='_blank' name='frmPdf'>
					<input type='image' src='images/reportbutton.jpg'>
					<input type='hidden' name='wherestr' value=\"$wherestring\">
					<input type='hidden' name='orderstr' value='$orderbystring'>
					</form></td></tr>";
					
	echo $printctrl;

	echo  "</tr></tbody></table>";
 }



 public function searchAToZ(){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search category easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(category_desc,1)) as shortname FROM $this->tablecategory where isactive='1' order by category_desc";
	$this->log->showLog(4,"With SQL:$sqlfilter");
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	$firstname="";
		
	$this->log->showLog(3,"Complete generate list of short cut");
		echo <<<EOF
<BR>
<A href='category.php?action=new' style='color: GRAY'><img src="images/addnew.jpg"</A>
<A href='category.php?action=showSearchForm' style='color: gray'><img src="images/search.jpg"</A>

EOF;
return $filterstring;
  }
  
  
  
  


  public function getLatestCategoryID() {
	$sql="SELECT MAX(category_id) as category_id from $this->tablecategory;";
	$this->log->showLog(3,'Checking latest created category_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created category_id:' . $row['category_id']);
		return $row['category_id'];
	}
	else
	return -1;
	
  } // end
  
  
  public function getNewCategory() {
	$sql="SELECT MAX(category_code) as category_code from $this->tablecategory;";
	$this->log->showLog(3,'Checking latest created category_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created category_code:' . $row['category_code']);
		$category_code=$row['category_code']+1;
		return $category_code;
	}
	else
	return 0;
	
  } // end
  
  

  public function getSelectCategory($id,$field_name="category_id",$javascript_function="",$wherestring="category_id>1 and isactive=1",$orderbystring="order by categorystring",$displayfield="concat(category_desc,-,category_id)") {
	
	$sql="SELECT category_id,category_desc from $this->tablecategory where isactive=1 or category_id=$id " .
		" order by category_desc";
	$selectctl="<SELECT name='category_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$category_id=$row['category_id'];
		$category_desc=$row['category_desc'];
	
		if($id==$category_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$category_id' $selected>$category_desc</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end


  public function allowDelete($id){
	$sql="SELECT count(category_id) as rowcount from $this->tableitem where category_id=$id";
	
	$this->log->showLog(3,"Accessing ProductCategory->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this category, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this category, record deletable");
		return true;
		}
	}


 public function showCategoryHeader($category_id){
	if($this->fetchCategory($category_id)){
		$this->log->showLog(4,"Showing category header successfully.");
	echo <<< EOF
	<table border='1' cellspacing='3'>
		<tbody>
			<tr>
				<th colspan="4">Category Info</th>
			</tr>
			<tr>
				<td class="head">Category No</td>
				<td class="odd">$this->category_code</td>
				<td class="head">Category Description</td>
				<td class="odd"><A href="category.php?action=edit&category_id=$category_id" 
						target="_blank">$this->category_desc</A></td>
			</tr>
		</tbody>
	</table>
EOF;
	}
	else{
		$this->log->showLog(1,"<b style='color:red;'>Showing category header failed.</b>");
	}

   }//showRegistrationHeader
   
   
  
  
 public function showSearchForm($wherestring="",$orderctrl=""){

   echo <<< EOF

	<FORM action="category.php" method="POST" name="frmActionSearch" id="frmActionSearch">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criteria</th>
	    </tr>
	    <tr>
	      <td class='head'>Category No</td>
	      <td class='even'><input name='category_code' value='$this->category_code'> (%, AB%,%AB,%A%B%)</td>
	      <td class='head'>Category Description</td>
	      <td class='even'><input name='category_desc' value='$this->category_desc'>%ali, %ali%, ali%, %ali%bin%</td>
	    </tr>
	    <tr>
	      <td class='head'>Quick Search</td>
	      <td class='odd'>$this->categoryctrl</td>
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
	      <td class='head'>Type</td>
	      <td class='odd'>
		<select name="category_type">
			<option value="">Null</option>
			<option value="S" >Stock</option>
			<option value="C" >Charges</option>
		</select>
		</td>
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

  public function convertSearchString($category_id,$category_code,$category_desc,$isactive,$category_type){
$filterstring="";

if($category_id > 0 ){
	$filterstring=$filterstring . " c.category_id=$category_id AND";
}

if($category_code!=""){
	$filterstring=$filterstring . " c.category_code LIKE '$category_code' AND";
}

if($category_desc!=""){
	$filterstring=$filterstring . "  c.category_desc LIKE '$category_desc' AND";
}

if($category_type!=""){
	$filterstring=$filterstring . "  c.category_type LIKE '$category_type' AND";
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
  	
  

} // end of ClassCategory
?>



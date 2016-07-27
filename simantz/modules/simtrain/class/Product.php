<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


/**
 * class ProductMaster
 * This class is can be books, or tuition class
 */
class Product
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  /**
   * system maintain id, transparent to end user
   * @access public
   */
  public $product_id;
  public $product_no;
  public $description;
  public $category_id;
  public $standard_id;
  public $standardctrl;

  public $amt = 0;
  public $weeklyfees = 0;
  public $organization_id;
  public $created;
  public $updated;
  public $createdby;
  public $updatedby;
  public $isactive;
  public $cur_name;
  public $cur_symbol;
  public $product_name;
  public $isAdmin;
  public $orgctrl;
  public $categoryctrl;
  public $deleteAttachment;
  public $tableproduct;
  public $tablecategory;
  public $tableprefix;
  public $filename;

  public function Product($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableproduct=$tableprefix."simtrain_productlist";
	$this->tablestandard=$tableprefix."simtrain_standard";
	$this->tablecategory=$tableprefix."simtrain_productcategory";
	$this->log=$log;
  }
  /**
   * Add new row of data into table
   *
   * @return bool
   * @access public
   */
  public function insertProduct( ) {
	$this->log->showLog(3,"Creating product SQL:$sql");

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new product $this->product_no");
 	$sql="INSERT INTO $this->tableproduct (product_name,product_no,description,".
	"category_id,standard_id,amt,weeklyfees,isactive, created,createdby,updated,updatedby,organization_id) values(".
	"'$this->product_name','$this->product_no','$this->description','$this->category_id',$this->standard_id,".
	"$this->amt,$this->weeklyfees,'$this->isactive','$timestamp',$this->createdby,'$timestamp',".
	"$this->updatedby,$this->organization_id)";
	$this->log->showLog(4,"Before insert product SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert product name '$product_name'");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new product name '$product_name' successfully"); 
		return true;
	}
  } // end of member function insertClassMaster

  /**
   * Update class information
   *
   * @return bool
   * @access public
   */
  public function updateProduct($withfile='N' ) {
    $timestamp= date("y/m/d H:i:s", time()) ;
	$sql="";
	if($withfile=='N')
 	$sql="UPDATE $this->tableproduct SET ".
	"product_no='$this->product_no',product_name='$this->product_name',description='$this->description',".
	"category_id='$this->category_id',standard_id=$this->standard_id,weeklyfees=$this->weeklyfees,amt=$this->amt,".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id ".
	" WHERE product_id='$this->product_id'";
	else
	$sql="UPDATE $this->tableproduct SET ".
	"product_no='$this->product_no',product_name='$this->product_name',description='$this->description',".
	"category_id='$this->category_id',standard_id=$this->standard_id,weeklyfees=$this->weeklyfees,amt=$this->amt,".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id, ".
	"filename='$this->filename' WHERE product_id='$this->product_id'";

	$this->log->showLog(3, "Update product_id: $this->product_id, '$this->product_name'");
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
  public function getSqlStr_AllProduct( $wherestring,  $orderbystring,  $startlimitno ) {
  
    $sql="SELECT p.product_id,p.product_no,p.product_name,p.description,c.category_id,p.standard_id,c.category_description,
	p.amt,p.weeklyfees,p.organization_id,p.isactive, std.standard_name
	FROM $this->tableproduct p
	left outer join $this->tablecategory c on c.category_id=p.category_id
	left outer join $this->tablestandard std on std.standard_id=p.standard_id
	$wherestring $orderbystring";
   $this->log->showLog(4,"Running Product->getSQLStr_AllProduct: $sql");
  return $sql;
  } // end of member function getSqlStr_AllClass

  /**
   * pull data from database into class.
   *
   * @param int masterclass_id 
   * @return bool
   * @access public
   */
  public function fetchProductInfo( $product_id ) {
    
	$this->log->showLog(3,"Fetching product detail into class Product.php.<br>");
		
	$sql="SELECT product_id,product_no,product_name,description,category_id,standard_id,".
	"amt,weeklyfees,organization_id,isactive,filename FROM $this->tableproduct ". 
			"where product_id=$product_id";
	
	$this->log->showLog(4,"Product->fetchProductInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->product_id=$row["product_id"];
		$this->product_no=$row["product_no"];
		$this->product_name= $row['product_name'];
		$this->description=$row['description'];
		$this->category_id=$row['category_id'];
		$this->standard_id=$row['standard_id'];
		$this->amt=$row['amt'];
		$this->weeklyfees=$row['weeklyfees'];
		$this->organization_id=$row['organization_id'];
		$this->isactive=$row['isactive'];
		$this->filename=$row['filename'];
	
	   	$this->log->showLog(4,"Product->fetchProductInfo,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Product->fetchProductInfo,failed to fetch data into databases.");	
	}
  } // end of member function fetchTuitionClassMaster

  /**
   * if type = "new" all field set to "" or 0, if type="edit" the field's data come
   * from database, refer to masterclass_id
   *
   * @param string type accept "new" or "edit"

   * @param int masterclass_id 
   * @return bool
   * @access public
   */
  public function getInputForm( $type,  $product_id,$token ) {
	$mandatorysign="<b style='color:red'>*</b>";
	$filectrl="";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$uploadctrl="";
	if ($type=="new"){
		$header="New Organization";
		$action="create";
		if($product_id==0){
		$this->product_name="";
		$this->product_no="";
		$this->description="";
		$this->amt=0;
		$this->weeklyfees=0;
		$this->standard_id=0;
		$this->organization=0;
		}

		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
	}
	else
	{
		$action="update";
		$savectrl="<input name='product_id' value='$this->product_id' type='hidden'>".
			 "<input style='height:40px;' name='submit' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableproduct' type='hidden'>".
		"<input name='id' value='$this->product_id' type='hidden'>".
		"<input name='idname' value='product_id' type='hidden'>".
		"<input name='title' value='Product' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		


		$header="Edit Product";
		if($this->allowDelete($this->product_id) && $this->product_id>0)
		$deletectrl="<FORM action='product.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this product?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->product_id' name='product_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

		 $addnewctrl="<form action='product.php' method='post'><input type='submit' value='New' value='New'></form>";
		$filename="upload/products/".$this->filename;
		if(file_exists($filename) && $this->filename !="" && $this->filename !="/" && $this->filename !=" ")
			$filectrl="<a href='$filename' target='_blank' title='Training Material'>Download</a>";
		else
			$filectrl="<b style='color:red;'>No Attachment</b>";
		
		$uploadctrl='<tr><td class="head">Attachment '. $filectrl. '</td> <td class="even" colspan="3">Remove File <input type="checkbox" name="deleteAttachment" title="Choose it if you want to remove this attachment"> <input type="file" name="upload_file" size="50" title="Upload attendance hardcopy here. Format in PDF"></td></tr>';

	}

    echo <<< EOF
<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateProduct()" method="post"
 action="product.php" name="frmProduct"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>

 <table cellspacing='3' border='1'>

    <tr>
      <th colspan='4' style='text-align: center'>Product Info</th>
    </tr>
    <tr>
      <td class="head">Product No $mandatorysign</td>
      <td class="odd"><input name="product_no" value="$this->product_no" maxlength='10' size='10'></td>
      <td class="head">Product Name $mandatorysign</td>
      <td class="odd"><input name="product_name" value="$this->product_name"  maxlength='50' size='45'></td>
    </tr>
  <tbody>
    <tr>
      <td class="head">Active</td>
      <td class="even"><input type="checkbox" $checked name="isactive" ></td>
      <td class="head"></td>
      <td class="even"><input type='hidden' value='0' name='organization_id'></td>
    </tr>
    <tr>
      <td class="head">Category</td>
      <td class="odd">$this->categoryctrl</td>
      <td class="head">Standard</td>
      <td class="odd">$this->standardctrl</td>
    </tr>
    <tr>
      <td class="head">Description</td>
      <td class="even" colspan='3'><input name="description" value="$this->description" size="90" maxsize="100"></td>
    </tr>
    <tr>
      <td class="head">Standard Amount($this->cur_symbol) $mandatorysign</td>
      <td class="odd"><input name="amt" value="$this->amt" ></td>
      <td class="head">Weekly Fees($this->cur_symbol) $mandatorysign</td>
      <td class="odd"><input name="weeklyfees" value="$this->weeklyfees" ></td>
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
  public function deleteProduct( $productmaster_id ) {
   	$this->log->showLog(2,"Warning: Performing delete product id : $this->product_id !");
	$sql="DELETE FROM $this->tableproduct where product_id=$this->product_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: product ($product_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Product ($product_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteProductMaster


/**
   * Display a product list table
   *
   * 
   * @access public
   */
public function showProductTable($wherestring,$orderbystring){

	$this->log->showLog(3,"Showing Product Table");
	$sql=$this->getSQLStr_AllProduct($wherestring,$orderbystring,0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Product No</th>
				<th style="text-align:center;">Product Name</th>
				<th style="text-align:center;">Category</th>
				<th style="text-align:center;">Standard</th>
				<th style="text-align:center;">Price($this->cur_symbol)</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$product_id=$row['product_id'];
		$product_no=$row['product_no'];
		$standard_name=$row['standard_name'];
		$product_name=$row['product_name'];
		$amt=$row['amt'];
		$description=$row['description'];
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
			<td class="$rowtype" style="text-align:center;">$product_no</td>
			<td class="$rowtype" style="text-align:center;"><A href='product.php?action=edit&product_id=$product_id' target='_blank'>$product_name</A></td>
			<td class="$rowtype" style="text-align:center;">$category_name</td>
			<td class="$rowtype" style="text-align:center;">$standard_name</td>
			<td class="$rowtype" style="text-align:center;">$amt</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="product.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this record'>
				<input type="hidden" value="$product_id" name="product_id">
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
   * return int  product_id (latest)
   * @access public
   */
  public function getLatestProductID(){
  	$sql="SELECT MAX(product_id) as product_id from $this->tableproduct;";
	$this->log->showLog(3, "Retrieveing last product id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['product_id'];
	else
	return -1;
	

  }

/**
   * get a selection box for list of product(active only)
   * @param int id As product id, 0= non specific item, >0 preselect 1 item, -1 = include 1 empty product(reporting purpose)
   * @param char isitem, by default ='Y' means it won't display tuition class item
   * return string selection box
   * @access public
   */
public function getSelectProduct($id,$isitem='NY',$calledfunction="",$showNull='N') {

	$wherestring="";
	$tablecategory=$this->tableprefix ."simtrain_productcategory";
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

	$sql="SELECT p.product_id,p.product_name from $this->tableproduct p ".
		"inner join $tablecategory c on c.category_id=p.category_id ".
		"$wherestring or (p.product_id=$id)) and p.product_id>0 order by product_name ;";

	$this->log->showLog(4,"Excute SQL for generate product list: $sql;");
	$selectctl="<SELECT name='product_id' $calledfunction>";
	if ($id==-1 || $showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$product_id=$row['product_id'];
		$product_name=$row['product_name'];
	
		if($id==$product_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$product_id' $selected>$product_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  /**
   * Get default price for 1 product (column amt)
   * @param int id As product id
   * return number product price
   * @access public
   */
  public function getProductPrice($id){
	$this->log->showLog(3,"Retrieving default price for product $id");
	$sql="SELECT product_name,amt from $this->tableproduct where product_id=$id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$price=$row['amt'];
		$product_name=$row['product_name'];
		$this->log->showLog(3,"product_id: have productname: $product_name with product_id: $id");
		return $price;
	
	}
	else
	{
		$this->log->showLog(1,"Error, can't find product_id: $id");
		return 0;
	}
	


  }
  public function savefile($tmpfile,$newfilename){
	move_uploaded_file($tmpfile, "upload/products/$newfilename");
	$sqlupdate="UPDATE $this->tableproduct set filename='$newfilename' where product_id=$product_id";
	$qryUpdate=$this->xoopsDB->query($sqlupdate);
  }

  public function deletefile($product_id){
	$sql="SELECT filename from $this->tableproduct where product_id=$product_id";
	$query=$this->xoopsDB->query($sql);
	$myfilename="";
	if($row=$this->xoopsDB->fetchArray($query)){
		$myfilename=$row['filename'];
	}
	$myfilename="upload/products/$myfilename";
	$this->log->showLog(3,"This file name: $myfilename");
	unlink($myfilename);
	$sqlupdate="UPDATE $this->tableproduct set filename='-' where product_id=$product_id";
	$qryDelete=$this->xoopsDB->query($sqlupdate);
  }

  public function allowDelete($product_id){
	$tabletuitionclass = $this->tableprefix."simtrain_tuitionclass";
	$tablepaymentline = $this->tableprefix."simtrain_paymentline";
	$tableinventorymovement = $this->tableprefix."simtrain_inventorymovement";

	$sql="select sum(recordcount) as recordcount from (
		SELECT count(product_id) as recordcount FROM $tabletuitionclass where product_id=$product_id
		UNION 
		SELECT count(product_id) as recordcount FROM $tablepaymentline where product_id=$product_id
		UNION 
		SELECT count(product_id) as recordcount FROM $tableinventorymovement where product_id=$product_id
		) as b1";
	
	$this->log->showLog(3,"Verified allowDelete for product_id:$product_id");
	$this->log->showLog(4,"With SQL: $sql");

	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$recordcount=$row['recordcount'];
		$this->log->showLog(3,"Found child record: $recordcount");

		if($recordcount==0 || $recordcount=="")
			return true;
		else
			return false;
	}
  
  }

 public function searchAToZ(){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search product easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(product_name,1)) as shortname FROM $this->tableproduct where isactive='Y' and product_id>0 order by product_name";
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
echo "<b>Product Grouping By Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if customer never do filter yet, if will choose 1st customer listing
		
		echo "<A href='product.php?filterstring=$shortname'> $shortname </A> ";
	}
		echo <<<EOF
<BR>
<A href='product.php' style='color: GRAY'> [ADD NEW PRODUCT]</A>
<A href='product.php?action=searchproduct' style='color: gray'> [SEARCH PRODUCTS]</A>

EOF;
return $filterstring;

	$this->log->showLog(3,"Complete generate list of short cut");
  }

  public function showSearchForm(){
	
	if($_POST['isactive']=='Y'){
		$selectnull="";
		$selecty='selected="selected"';
		$selectn="";
	}
	elseif($_POST['isactive']=='N'){
		$selectnull="";
		$selecty="";
		$selectn='selected="selected"';
	}	
	else{
		$selectnull='selected="selected"';
		$selecty="";
		$selectn="";

	}
echo <<< EOF

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">Search Products<FORM action='product.php' method='POST'></th>
      </tr>
        <tr>
        <td class="head">Products Name</td>
        <td class="even">
		<input maxlength="50" size="50"
		 	name="product_name" value="$this->product_name">%books, %books%, tuition%, %English%Primary%
	</td>
  	<td class="head">Product No</td>
 	<td class="odd"><input name='product_no' value="$this->product_no"></td>
</tr>
    <tr>
        <td class="head">Category</td>
        <td class="even">$this->categoryctrl</td>
  	<td class="head">Standard</td>
 	<td class="odd">$this->standardctrl</td>
</tr>
<tr>
	<td class="head">Active</td>
 	<td class="odd">
		<select name="isactive">
			<option value="-" $selectnull>Null</option>
			<option value="Y" $selecty>Y</option>
			<option value="N" $selectn>N</option>
		</select></td>

 <td class="head" colspan='2'><input type="submit" value="search" name='action'></form>
</td>
</td>
      </tr>
    </tbody>
  </table>
EOF;

  }


} // end of ProductMaster
?>

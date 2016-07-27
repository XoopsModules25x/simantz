<?php
/************************************************************************
Class Product.php - Copyright kfhoo
**************************************************************************/

class Product
{
  public $product_id;
  public $product_no;
  public $description;
  public $remarks;
  public $uom_id;
  public $category_id;
  public $filterstring;

  public $amt = 0;
  public $lastpurchasecost = 0;
  public $sellingprice = 0;
  public $safety_level;
  public $organization_id;
  public $created;
  public $updated;
  public $createdby;
  public $updatedby;
  public $isactive;
  public $isdefault;
  public $issales;
  public $cur_name;
  public $cur_symbol;
  public $product_name;
  public $isAdmin;
  public $orgctrl;
  public $categoryctrl;
  public $deleteAttachment;
  public $tableproduct;
  public $tablecategory;
  public $tableuom;
  public $tableprefix;
  public $filename;
  public $uomctrl;

  public function Product($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableproduct=$tableprefix."simsalon_productlist";
	$this->tablecategory=$tableprefix."simsalon_productcategory";
	$this->tableuom=$tableprefix."simsalon_uom";
	$this->log=$log;
  }


  public function insertProduct( ) {
	$this->log->showLog(3,"Creating product SQL:$sql");

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new product $this->product_no");
 	$sql="INSERT INTO $this->tableproduct (product_name,product_no,description,remarks,uom_id,".
	"category_id,amt,lastpurchasecost,sellingprice,safety_level,isactive,isdefault,issales, created,createdby,updated,updatedby,organization_id) values(".
	"'$this->product_name','$this->product_no','$this->description','$this->remarks',$this->uom_id,'$this->category_id',".
	"$this->amt,$this->lastpurchasecost,$this->sellingprice,$this->safety_level,'$this->isactive','$this->isdefault','$this->issales','$timestamp',$this->createdby,'$timestamp',".
	"$this->updatedby,$this->organization_id)";
	$this->log->showLog(4,"Before insert product SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
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
	"product_no='$this->product_no',product_name='$this->product_name',description='$this->description',remarks='$this->remarks',".
	"uom_id=$this->uom_id,category_id='$this->category_id',sellingprice=$this->sellingprice,safety_level=$this->safety_level,amt=$this->amt,lastpurchasecost=$this->lastpurchasecost,updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',isdefault='$this->isdefault', issales='$this->issales', organization_id=$this->organization_id ".
	" WHERE product_id='$this->product_id'";
	else
	$sql="UPDATE $this->tableproduct SET ".
	"product_no='$this->product_no',product_name='$this->product_name',description='$this->description',remarks='$this->remarks',".
	"uom_id=$this->uom_id,category_id='$this->category_id',sellingprice=$this->sellingprice,safety_level=$this->safety_level,amt=$this->amt,lastpurchasecost=$this->lastpurchasecost,updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',isdefault='$this->isdefault', issales='$this->issales', organization_id=$this->organization_id, ".
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
  
	$wherestring .= " and c.category_id=p.category_id and p.uom_id = u.uom_id ";
    $sql="SELECT *,p.isactive as isactive_m, p.issales as issales_m, p.isdefault as isdefault_m FROM $this->tableproduct p,  $this->tableuom u, $this->tablecategory c
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
		
	$sql="SELECT * FROM $this->tableproduct ". 
			"where product_id=$product_id";
	
	$this->log->showLog(4,"Product->fetchProductInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->product_id=$row["product_id"];
		$this->product_no=$row["product_no"];
		$this->product_name= $row['product_name'];
		$this->description=$row['description'];
		$this->remarks=$row['remarks'];
		$this->uom_id=$row['uom_id'];
		$this->category_id=$row['category_id'];
		$this->amt=$row['amt'];
		$this->lastpurchasecost=$row['lastpurchasecost'];
		$this->sellingprice=$row['sellingprice'];
		$this->safety_level=$row['safety_level'];
		$this->organization_id=$row['organization_id'];
		$this->isactive=$row['isactive'];
		$this->isdefault=$row['isdefault'];
		$this->issales=$row['issales'];
		$this->filename=$row['filename'];
	
	   	$this->log->showLog(4,"Product->fetchProductInfo,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Product->fetchProductInfo,failed to fetch data into databases.");	
	}
  } // end of member function fetchTuitionClassMaster


  public function getInputForm( $type,  $product_id,$token ) {
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
		$this->remarks="";
		$this->amt=0;
		$this->lastpurchasecost=0;
		$this->sellingprice=0;
		$this->organization=0;
		$this->safety_level=0;
		}

		$savectrl="<input style='height:40px;' name='btnSave' value='Save' type='submit'>";
		$checked="CHECKED";
		$checked2="";
		$checked3="CHECKED";
		$deletectrl="";
		$addnewctrl="";

		$this->product_no = getNewCode($this->xoopsDB,"product_no",$this->tableproduct);
	}
	else
	{
		$action="update";
		$savectrl="<input name='product_id' value='$this->product_id' type='hidden'>".
			 "<input style='height:40px;' name='btnSave' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		if ($this->isdefault=='Y')
			$checked2="CHECKED";
		else
			$checked2="";

		if ($this->issales=='Y')
			$checked3="CHECKED";
		else
			$checked3="";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableproduct' type='hidden'>".
		"<input name='id' value='$this->product_id' type='hidden'>".
		"<input name='idname' value='product_id' type='hidden'>".
		"<input name='title' value='Product' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";
		


		$header="Edit Product";
		if($this->allowDelete($this->product_id) && $this->product_id>0)
		$deletectrl="<FORM action='product.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this product?"'.")'><input style='height:40px;' type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->product_id' name='product_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

		$addnewctrl="<form action='product.php' method='post'><input type='submit' value='New' value='New' style='height:40px;'></form>";

		$filename="upload/products/".$this->filename;
		if(file_exists($filename) && $this->filename !="" && $this->filename !="/" && $this->filename !=" ")
			$filectrl="<img src='$filename' atarget='_blank' atitle='View Pictu'>";
		else
			$filectrl="<b style='color:red;'>No Attachment</b>";
		
		$uploadctrl='<tr><td class="head">Attachment (50 X 50)</td> <td class="even" colspan="3">'.$filectrl.'<br>Remove File <input type="checkbox" name="deleteAttachment" title="Choose it if you want to remove this attachment"> <input type="file" name="upload_file" size="50" title="Upload hardcopy here. Format in PDF"></td></tr>';

	}

    echo <<< EOF
<br>
<table style="width:140px;"><tbody><td nowrap>$addnewctrl</td><td nowrap><form onsubmit="return validateProduct()" method="post"
 action="product.php" name="frmProduct"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset" style='height:40px;'>
<input name="btnSearch" value="Search" type="button" onclick="showSearch();" style='height:40px;'>
<input type="hidden" name="fldShow" value="Y">
</td></tbody></table>

 <table cellspacing='3' border='1'>

    <tr>
      <th>Description</th>
      <th>Data</th>
      <th>Description</th>
      <th>Data</th>
    </tr>
    <tr>
      <td class="head">Product No</td>
      <td class="odd" colspan="3"><input name="product_no" value="$this->product_no" maxlength='10' size='10'>
&nbsp;&nbsp;Active&nbsp;&nbsp;<input type="checkbox" $checked name="isactive" >
	Default <input type="checkbox" $checked2 name="isdefault">&nbsp;&nbsp;
	For Sales <input type="checkbox" $checked3 name="issales">&nbsp;&nbsp;
			</td>
      
    </tr>

	<tr>

      <td class="head">Product Name</td>
      <td class="odd" colspan="3"><input name="product_name" value="$this->product_name"  maxlength='60' size='60'></td>
    </tr>

  <tbody>
  
    
    <tr>
      <td class="head">Description</td>
      <td class="even" colspan='3'><input name="description" value="$this->description" size="100" maxsize="100"></td>
    </tr>


	<tr>
      <td class="head">Category</td>
      <td class="odd">$this->categoryctrl</td>
      <td class="head">Unit Of Measurement</td>
      <td class="odd">$this->uomctrl</td>
    </tr>

	 <tr>
      <td class="head">Average Cost($this->cur_symbol)</td>
      <td class="even"><input name="amt" value="$this->amt" readonly style="background-color:gainsboro"></td>
      <td class="head">Selling Price($this->cur_symbol)</td>
      <td class="even"><input name="sellingprice" value="$this->sellingprice" ></td>
    </tr>
   
	<tr>
	<td class="head">Last Purchase Cost($this->cur_symbol)</td>
        <td class="odd"><input name="lastpurchasecost" value="$this->lastpurchasecost" ></td>
      	<td class="head">Remarks</td>
      	<td class="odd" ><textarea name="remarks" cols="60" rows="1">$this->remarks</textarea></td>
    	</tr>
	 <tr style="display:none">
      <td class="head">Active</td>
      <td class="even" colspan="3"></td>
      <td class="head" style="display:none">Organization</td>
      <td class="even" style="display:none">$this->orgctrl</td>
    </tr>

<tr>
      <td class="head">Safety Level</td>
      <td class="even" colspan="3"><input name="safety_level" value="$this->safety_level" size="6" maxlength="10"></td>
   
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
	if (!rs){
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
public function showProductTable($category_id=0,$categoryselect=""){
	
	if($this->start_date=="")
	$this->start_date = getMonth(date("Ymd", time()),0) ;
   	
	if($this->end_date=="")
	$this->end_date = getMonth(date("Ymd", time()),1) ;

	$wherestring = " where product_id>0 ";
	
	
	
	if($this->fldShow=="Y" )
	$wherestring .= $this->getWhereString();
	else{
	if($category_id > 0 && $this->fldShow != "N")
	$wherestring .= " and p.category_id = $category_id ";
	}
	

	$this->log->showLog(3,"Showing Product Table");
	$sql=$this->getSQLStr_AllProduct(" $wherestring ","ORDER BY product_name, p.category_id ",0);
	
	$query=$this->xoopsDB->query($sql);

	if($this->fldShow != "Y"){
	echo <<< EOF
	<br>
	
	<form name="frmATZ" action="product.php" method="POST">
	<b>Product Grouping By Category: </b>
	$categoryselect
	<input type="hidden" name="filterstring" value=$this->filterstring>
	<input type="hidden" name="fldShow" value="">
	</form>
EOF;
	}
	if($this->fldShow=="Y"){
echo <<< EOF
	<form name="frmNew" action="product.php" method="POST">
	<table>
	<tr>
	<td><input type="submit" value="New" style='height:40px;'>
	<input type="hidden" name="fldShow" value="N">
	</td>
	</tr>
	</table>
	</form>

	<form action="product.php" method="POST" name="frmSearch">
	<input type="hidden" name="fldShow" value="Y">
	<input type="hidden" name="action" value="">
	<input type="hidden" value="" name="product_id">
	<table border='1' cellspacing='3'>
	<tr>
	<td class="head">Product Code</td>
	<td class="even"><input type="text" name="product_no" value=""></td>
	<td class="head">Product Name</td>
	<td class="even"><input type="text" name="product_name" value="" size="30"></td>
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
	<td class="head" colspan="4"><input type="button" value="Search" onclick="searchProduct();" style='height:40px;'></td>
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

				<th style="text-align:center;">Product No</th>
				<th style="text-align:center;">Product Name</th>
				<th style="text-align:center;">Category</th>
				<th style="text-align:center;">Average Cost($this->cur_symbol)</th>
				<th style="text-align:center;">Selling Price($this->cur_symbol)</th>
				<th style="text-align:center;">Last Purchase Cost($this->cur_symbol)</th>
				<th style="text-align:center;">Safety Level</th>		
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
		$product_name=$row['product_name'];
		$amt=$row['amt'];
		$sell_price=$row['sellingprice'];
		$safety_level=$row['safety_level'];
		$lastpurchasecost=$row['lastpurchasecost'];
		$description=$row['description'];
		$remarks=$row['remarks'];
		$uom_id=$row['uom_id'];
		$uom_description=$row['uom_description'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive_m'];
		$isdefault=$row['isdefault_m'];
		$issales=$row['issales_m'];
		$category_name=$row['category_description'];
		$safety_level=$row['safety_level'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$product_no</td>
			<td class="$rowtype" style="text-align:center;">$product_name</td>
			<td class="$rowtype" style="text-align:center;">$category_name</td>
			<td class="$rowtype" style="text-align:center;">$amt</td>
			<td class="$rowtype" style="text-align:center;">$sell_price</td>
			<td class="$rowtype" style="text-align:center;">$lastpurchasecost</td>
			<td class="$rowtype" style="text-align:center;">$safety_level</td>
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
	//}
 }

  public function getWhereString(){
	$retval = "";
	//echo $this->isactive;

	if($this->product_no != "")
	$retval .= " and p.product_no LIKE '$this->product_no' ";

	if($this->product_name != "")
	$retval .= " and p.product_name LIKE '$this->product_name' ";

	if($this->isactive != "X" && $this->isactive != "")
	$retval .= " and p.isactive = '$this->isactive' ";

	if($this->category_id > 0)
	$retval .= " and p.category_id = $this->category_id ";

	/*
	if($this->start_date != "" && $this->end_date != "")
	$retval .= " and ( p.product_date between '$this->start_date' and '$this->end_date' ) ";
	*/
	return $retval;
	
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


public function getSelectProduct($id,$isitem='NY',$calledfunction="",$showNull='Y') {

	$wherestring="";

	if ($isitem=='Y')
		$wherestring="and c.isitem='Y'";
	elseif($isitem=='N')
		$wherestring="and c.isitem='N'";
	elseif($isitem=='C')
		$wherestring="and c.isitem='C'";
	else
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

// 	$sql="SELECT p.product_id,p.product_name from $this->tableproduct p ".
// 		"inner join $this->tablecategory c on c.category_id=p.category_id ".
// 		"$wherestring or (p.product_id=$id)  order by product_name ;";

	$sql = "SELECT * from $this->tableproduct p, $this->tablecategory c where c.category_id=p.category_id and p.product_id>0 $wherestring order by p.isdefault desc,p.product_name asc ";

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
	
	if(move_uploaded_file($tmpfile, "upload/products/$newfilename")){
	//move_uploaded_file($tmpfile, "upload/category/$newfilename");
	$sqlupdate="UPDATE $this->tableproduct set filename='$newfilename' where product_id=$this->product_id";
	$qryUpdate=$this->xoopsDB->query($sqlupdate);
	}else{
	echo "Cannot Upload File";
	}
	
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
	unlink("$myfilename ");
	$sqlupdate="UPDATE $this->tableproduct set filename='-' where product_id=$product_id";
	$qryDelete=$this->xoopsDB->query($sqlupdate);
  }

  public function allowDelete($product_id){
/*
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


} // end of ProductMaster
?>

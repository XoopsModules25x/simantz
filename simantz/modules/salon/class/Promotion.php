<?php
/************************************************************************
Class Promotion.php - Copyright kfhoo
**************************************************************************/

class Promotion
{
  public $promotion_id;
  public $promotion_no;
  public $promotion_desc;
  public $promotion_type;
  public $customer_id;
  public $product_id;
  public $promotion_price = 0;
  public $promotion_buy;
  public $promotion_free;
  public $isonepayment;
  public $promotion_expiry;
  public $promotion_effective;
  public $promotion_remarks;

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

  public $tablepromotion;
  
  public $tableprefix;
  public $filename;

  public function Promotion($xoopsDB,$tableprefix,$log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablepromotion=$tableprefix."simsalon_promotion";
	$this->tablecustomer=$tableprefix."simsalon_customer";
	$this->tableproductlist=$tableprefix."simsalon_productlist";
	$this->log=$log;
  }


  public function insertPromotion( ) {
	$this->log->showLog(3,"Creating product SQL:$sql");

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new product $this->promotion_no");
 	$sql =	"INSERT INTO $this->tablepromotion 	(promotion_no,promotion_desc,promotion_type,
							customer_id,product_id,promotion_price,promotion_buy,promotion_free,isonepayment,
							promotion_expiry,promotion_effective,promotion_remarks,
							isactive,created,createdby,updated,updatedby,organization_id) 
							values('$this->promotion_no',
								'$this->promotion_desc',
								'$this->promotion_type',
								$this->customer_id,
								$this->product_id,
								$this->promotion_price,
								$this->promotion_buy,
								$this->promotion_free,
								'$this->isonepayment',
								'$this->promotion_expiry',
								'$this->promotion_effective',
								'$this->promotion_remarks',
		'$this->isactive','$timestamp',$this->createdby,'$timestamp',$this->updatedby,$this->organization_id)";

	$this->log->showLog(4,"Before insert product SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert promotion name '$promotion_desc'");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new promotion name '$promotion_desc' successfully"); 
		return true;
	}
  } // end of member function insertClassMaster

  /**
   * Update class information
   *
   * @return bool
   * @access public
   */
  public function updatePromotion() {
    $timestamp= date("y/m/d H:i:s", time()) ;
	$sql="";
	
 	$sql=	"UPDATE $this->tablepromotion SET
		promotion_no='$this->promotion_no',
		promotion_desc='$this->promotion_desc',
		promotion_type='$this->promotion_type',
		customer_id=$this->customer_id,
		product_id=$this->product_id,
		promotion_price=$this->promotion_price,
		promotion_buy=$this->promotion_buy,
		promotion_free=$this->promotion_free,
		isonepayment='$this->isonepayment',
		promotion_expiry='$this->promotion_expiry',
		promotion_effective='$this->promotion_effective',
		promotion_remarks='$this->promotion_remarks',
		updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id

		WHERE promotion_id='$this->promotion_id'";

	$this->log->showLog(3, "Update promotion_id: $this->promotion_id, '$this->promotion_name'");
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
  public function getSqlStr_AllPromotion( $wherestring,  $orderbystring,  $startlimitno ) {
	$wherestring .= " and a.customer_id = b.customer_id and a.product_id = c.product_id ";
  
    	$sql= 	"SELECT *,a.isactive as isactive_m FROM $this->tablepromotion a, $this->tablecustomer b, $this->tableproductlist c 
		$wherestring $orderbystring";

   $this->log->showLog(4,"Running Promotion->getSQLStr_AllPromotion: $sql");
  return $sql;
  } // end of member function getSqlStr_AllClass

  /**
   * pull data from database into class.
   *
   * @param int masterclass_id 
   * @return bool
   * @access public
   */
  public function fetchPromotionInfo( $promotion_id ) {
    
	$this->log->showLog(3,"Fetching product detail into class Promotion.php.<br>");
		
	$sql="SELECT * FROM $this->tablepromotion
	where promotion_id=$promotion_id";
	
	$this->log->showLog(4,"Promotion->fetchPromotionInfo, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->promotion_id=$row["promotion_id"];
		$this->promotion_no=$row["promotion_no"];
		$this->promotion_desc= $row['promotion_desc'];
		$this->promotion_type= $row['promotion_type'];
		$this->customer_id=$row['customer_id'];
		$this->product_id=$row['product_id'];
		$this->promotion_price=$row['promotion_price'];
		$this->promotion_buy=$row['promotion_buy'];
		$this->promotion_free=$row['promotion_free'];
		$this->isonepayment=$row['isonepayment'];
		$this->promotion_remarks=$row['promotion_remarks'];

		$this->promotion_expiry=$row['promotion_expiry'];
		$this->promotion_effective=$row['promotion_effective'];
		$this->organization_id=$row['organization_id'];
		$this->isactive=$row['isactive'];
	
	   	$this->log->showLog(4,"Promotion->fetchPromotionInfo,database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Promotion->fetchPromotionInfo,failed to fetch data into databases.");	
	}
  } // end of member function fetchPromotionInfo


  public function getInputForm( $type,  $promotion_id,$token ) {
	$filectrl="";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$uploadctrl="";
	$option1 = "";
	$option2 = "";
	$option3 = "";
	$option4 = "";
	$styletr1 = "style = 'display:none' ";
	$styletr2 = "style = 'display:none' ";
	$styletd = "style = 'display:none' ";

	if ($type=="new"){
		$header="New Organization";
		$action="create";
		if($promotion_id==0){
		$this->promotion_desc="";
		$this->promotion_no="";
		$this->description="";
		$this->promotion_price=0;
		$this->promotion_buy=0;
		$this->promotion_free=0;
		$this->organization=0;
		}

		$savectrl="<input style='height:40px;' name='btnSave' value='Save' type='submit'>";
		$checked="CHECKED";
		$checked2="CHECKED";
		$deletectrl="";
		$addnewctrl="";

		$this->promotion_no = getNewCode($this->xoopsDB,"promotion_no",$this->tablepromotion);
	}
	else
	{
		$action="update";
		$savectrl="<input name='promotion_id' value='$this->promotion_id' type='hidden'>".
			 "<input style='height:40px;' name='btnSave' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		if ($this->isonepayment=='Y')
			$checked2="CHECKED";
		else
			$checked2="";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablepromotion' type='hidden'>".
		"<input name='id' value='$this->promotion_id' type='hidden'>".
		"<input name='idname' value='promotion_id' type='hidden'>".
		"<input name='title' value='Promotion' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";
		


		$header="Edit Promotion";
		if($this->allowDelete($this->promotion_id) && $this->promotion_id>0)
		$deletectrl="<FORM action='promotion.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this product?"'.")'><input style='height:40px;' type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->promotion_id' name='promotion_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

		$addnewctrl="<form action='promotion.php' method='post'><input type='submit' value='New' value='New' style='height:40px;'></form>";
		
			
		if($this->promotion_type=="S"){
		$option1 = "SELECTED";
		}elseif($this->promotion_type=="U"){
		$option2 = "SELECTED";
		$styletr1 = "";
		}elseif($this->promotion_type=="P"){
		$option3 = "SELECTED";
		$styletr2 = "";
		}else{
		$option4 = "SELECTED";
		$styletr2 = "";
		$styletd = "";
		}

	}

    echo <<< EOF
<br>
<table style="width:140px;"><tbody><td nowrap>$addnewctrl</td><td nowrap><form onsubmit="return validatePromotion()" method="post"
 action="promotion.php" name="frmPromotion"  enctype="multipart/form-data"><input name="reset" value="Reset" type="reset" style='height:40px;'>
<input name="btnSearch" value="Search" type="button" onclick="showSearch();" style='height:40px;'>
</td></tbody></table>

 <table cellspacing='3' border='1'>

    <tr>
      <th>Description</th>
      <th>Data</th>
      <th>Description</th>
      <th>Data</th>
    </tr>
    <tr>
      <td class="head">Promotion No</td>
      <td class="odd"><input name="promotion_no" value="$this->promotion_no" maxlength='10' size='10'>
	  &nbsp;&nbsp;Active&nbsp;&nbsp;<input type="checkbox" $checked name="isactive" ></td>
      <td class="head">Promotion Description</td>
      <td class="odd"><input name="promotion_desc" value="$this->promotion_desc"  maxlength='100' size='60'></td>
    </tr>
  <tbody>
	<tr>
		<td class="head" style="display:none">Organization</td>
		<td class="even" style="display:none">$this->orgctrl</td>

		<td class="head">Promotion Type</td>
		<td class="even">
		<select name="promotion_type" onchange="showType(this.value);">
		<option value="S" $option1>Special</option>
		<option value="U" $option2>Customer</option>
		<option value="P" $option3>Product</option>
		<option value="F" $option4>Buy 1 Free 1</option>
		</select>		
		</td>
		<td class="head">Promotion Price($this->cur_symbol)</td>
		<td class="even"><input name="promotion_price" value="$this->promotion_price" ></td>
	</tr>
	
	<tr id="trCustomer" $styletr1>
		<td class="head">Customer</td>
		<td class="odd" colspan="3">$this->customerctrl</td>
	</tr>

	<tr id="trProduct" $styletr2>
		<td class="head">Product</td>
		<td class="odd" colspan="2">$this->productctrl</td>
		<td class="odd" ><div id="idBuyfree" $styletd>
		Buy : <input name="promotion_buy" value="$this->promotion_buy" size="3" maxlength="10">&nbsp;&nbsp;
 		Free : <input name="promotion_free" value="$this->promotion_free" size="3" maxlength="10">&nbsp;&nbsp;
		In one payment? <input type="checkbox" name="isonepayment" $checked2></div>
		</td>
		
	</tr>

	<tr>
		
		<td class="head">Effective Date</td>
		<td class="odd">
		<input name='promotion_effective' id='promotion_effective' value="$this->promotion_effective" maxlength='10' size='10'>
		<input name='btnDate2' value="Date" type="button" onclick="$this->effectivectrl">
		</td>
		<td class="head">Expiry Date</td>
		<td class="odd">
		<input name='promotion_expiry' id='promotion_expiry' value="$this->promotion_expiry" maxlength='10' size='10'>
		<input name='btnDate' value="Date" type="button" onclick="$this->datectrl">
		</td>
	</tr>

	<tr>
		
		<td class="head">Remarks</td>
		<td class="even" colspan="3"><textarea name="promotion_remarks" cols="60" rows="1">$this->promotion_remarks</textarea></td>
	</tr>

	<tr>	

	<tr>
	<td class="head" colspan="4"> 	
		<table border=0>
		<tr>
		<td width="10%" nowrap><b>* Special</b></td>
		<td>"This Promotion will show at all payment's windows"</td>
		</tr>
		<tr>
		<td width="10%" nowrap><b>* Customer</b></td>
		<td>"This Promotion will show When User Select The Customer"</td>
		</tr>
		<tr>
		<td width="10%" nowrap><b>* Product</b></td>
		<td>"This Promotion will show When User Select The Product"</td>
		</tr>
		<tr>
		<td width="10%" nowrap><b>* Buy 1 Free 1</b></td>
		<td>"This Promotion will show when user select the product and fulfilled all terms given."</td>
		</tr>
		</table>
	</td>
	</tr>
		
		
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
  public function deletePromotion( $productmaster_id ) {
   	$this->log->showLog(2,"Warning: Performing delete product id : $this->promotion_id !");
	$sql="DELETE FROM $this->tablepromotion where promotion_id=$this->promotion_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: product ($promotion_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Promotion ($promotion_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deletePromotionMaster


/**
   * Display a product list table
   *
   * 
   * @access public
   */
public function showPromotionTable(){


	$wherestring = " where promotion_id>0 ";
	
	$wherestring .= $this->getWhereString();

	$this->log->showLog(3,"Showing Promotion Table");
	$sql=$this->getSQLStr_AllPromotion(" $wherestring ","ORDER BY promotion_no",0);
	
	$query=$this->xoopsDB->query($sql);

	if($this->start_date=="")
	$this->start_date = getMonth(date("Ymd", time()),0) ;
   	
	if($this->end_date=="")
	$this->end_date = getMonth(date("Ymd", time()),1) ;

	echo <<< EOF
	<br>
	<form name="frmNew" action="promotion.php" method="POST">
	<table>
	<tr>
	<td><input type="submit" value="New" style='height:40px;'></td>
	</tr>
	</table>
	</form>

	<form action="promotion.php" method="POST" name="frmSearch">
	<input type="hidden" name="fldShow" value="">
	<input type="hidden" name="action" value="">
	<input type="hidden" value="" name="promotion_id">
	<table border='1' cellspacing='3'>
	<tr>
	<td class="head">Promotion No</td>
	<td class="even"><input type="text" name="promotion_no" value=""></td>
	<td class="head">Promotion Description</td>
	<td class="even"><input type="text" name="promotion_description" value="" size="30"></td>
	</tr>

	
	<tr>
	<td class="head">Expiry Date (YYYY-MM-DD)</td>
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

	<td class="head">Promotion Type</td>
	<td class="even">
	<select name="promotion_type">
	<option value="" ></option>
	<option value="S" >Special</option>
	<option value="U" >Customer</option>
	<option value="P" >Product</option>
	<option value="F" >Buy 1 Free 1</option>
	</select>
	</td>
	
	</tr>
	
	<tr>
	<td class="head" colspan="4"><input type="button" value="Search" onclick="searchPromotion();" style='height:40px;'></td>
	</tr>

	</table></form>
	<br>
EOF;

	if($this->fldShow=="Y"){
echo <<< EOF


	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Code</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Type</th>
				<th style="text-align:center;">Customer</th>
				<th style="text-align:center;">Product</th>
				<th style="text-align:center;">Price($this->cur_symbol)</th>
				<th style="text-align:center;">Effective</th>
				<th style="text-align:center;">Expiry</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$promotion_id=$row['promotion_id'];
		$promotion_no=$row['promotion_no'];
		$promotion_desc=$row['promotion_desc'];
		$promotion_type=$row['promotion_type'];
		$customer_id=$row['customer_id'];
		$customer_name=$row['customer_name'];
		$product_id=$row['product_id'];
		$product_name=$row['product_name'];
		$promotion_price=$row['promotion_price'];
		$promotion_buy=$row['promotion_buy'];
		$promotion_free=$row['promotion_free'];
		$isonepayment=$row['isonepayment'];
		$promotion_expiry=$row['promotion_expiry'];
		$promotion_effective=$row['promotion_effective'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive_m'];
		$category_name=$row['category_description'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		if($promotion_type=="P")
			$promotion_type = "Product";
		else if($promotion_type=="U")
			$promotion_type = "User";
		else if($promotion_type=="S")
			$promotion_type = "Special";
		else
			$promotion_type = "Buy 1 Free 1";

		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$promotion_no</td>
			<td class="$rowtype" style="text-align:center;">$promotion_desc</td>
			<td class="$rowtype" style="text-align:center;">$promotion_type</td>
			<td class="$rowtype" style="text-align:center;">$customer_name</td>
			<td class="$rowtype" style="text-align:center;">$product_name</td>
			<td class="$rowtype" style="text-align:center;">$promotion_price</td>
			<td class="$rowtype" style="text-align:center;">$promotion_effective</td>
			<td class="$rowtype" style="text-align:center;">$promotion_expiry</td>

			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="promotion.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this record'>
				<input type="hidden" value="$promotion_id" name="promotion_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
	}
 }


  public function getWhereString(){
	$retval = "";
	//echo $this->isactive;

	if($this->promotion_no != "")
	$retval .= " and a.promotion_no LIKE '$this->promotion_no' ";

	if($this->promotion_description != "")
	$retval .= " and a.promotion_description LIKE '$this->promotion_description' ";

	if($this->isactive != "X" && $this->isactive != "")
	$retval .= " and a.isactive = '$this->isactive' ";

	if($this->promotion_type != "")
	$retval .= " and a.promotion_type = '$this->promotion_type' ";

	
	if($this->start_date != "" && $this->end_date != "")
	$retval .= " and ( a.promotion_expiry between '$this->start_date' and '$this->end_date' ) ";
	
	return $retval;
	
  }

/**
   * get latest generated product
   * 
   * return int  promotion_id (latest)
   * @access public
   */
  public function getLatestPromotionID(){
  	$sql="SELECT MAX(promotion_id) as promotion_id from $this->tablepromotion;";
	$this->log->showLog(3, "Retrieveing last product id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['promotion_id'];
	else
	return -1;
	

  }


public function getSelectPromotion($id,$isitem='NY',$calledfunction="") {

	$wherestring="";
	$tablecategory=$this->tableprefix ."simtrain_promotioncategory";
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

	$sql="SELECT p.promotion_id,p.promotion_name from $this->tablepromotion p ".
		"inner join $tablecategory c on c.category_id=p.category_id ".
		"$wherestring or (p.promotion_id=$id)) and p.promotion_id>0 order by promotion_name ;";

	$this->log->showLog(4,"Excute SQL for generate product list: $sql;");
	$selectctl="<SELECT name='promotion_id' $calledfunction>";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$promotion_id=$row['promotion_id'];
		$promotion_name=$row['promotion_name'];
	
		if($id==$promotion_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$promotion_id' $selected>$promotion_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function getPromotionPrice($id){
	$this->log->showLog(3,"Retrieving default price for product $id");
	$sql="SELECT promotion_name,amt from $this->tablepromotion where promotion_id=$id";
	$this->log->showLog(4,"With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$price=$row['amt'];
		$promotion_name=$row['promotion_name'];
		$this->log->showLog(3,"promotion_id: have productname: $promotion_name with promotion_id: $id");
		return $price;
	
	}
	else
	{
		$this->log->showLog(1,"Error, can't find promotion_id: $id");
		return 0;
	}
	


  }
  public function savefile($tmpfile,$newfilename){
	move_uploaded_file($tmpfile, "upload/products/$newfilename");
	$sqlupdate="UPDATE $this->tablepromotion set filename='$newfilename' where promotion_id=$promotion_id";
	$qryUpdate=$this->xoopsDB->query($sqlupdate);
  }

  public function deletefile($promotion_id){
	$sql="SELECT filename from $this->tablepromotion where promotion_id=$promotion_id";
	$query=$this->xoopsDB->query($sql);
	$myfilename="";
	if($row=$this->xoopsDB->fetchArray($query)){
		$myfilename=$row['filename'];
	}
	$myfilename="upload/products/$myfilename";
	$this->log->showLog(3,"This file name: $myfilename");
	unlink("$myfilename ");
	$sqlupdate="UPDATE $this->tablepromotion set filename='-' where promotion_id=$promotion_id";
	$qryDelete=$this->xoopsDB->query($sqlupdate);
  }

  public function allowDelete($promotion_id){
/*
	$tabletuitionclass = $this->tableprefix."simtrain_tuitionclass";
	$tablepaymentline = $this->tableprefix."simtrain_paymentline";
	$tableinventorymovement = $this->tableprefix."simtrain_inventorymovement";

	$sql="select sum(recordcount) as recordcount from (
		SELECT count(promotion_id) as recordcount FROM $tabletuitionclass where promotion_id=$promotion_id
		UNION 
		SELECT count(promotion_id) as recordcount FROM $tablepaymentline where promotion_id=$promotion_id
		UNION 
		SELECT count(promotion_id) as recordcount FROM $tableinventorymovement where promotion_id=$promotion_id
		) as b1";
	
	$this->log->showLog(3,"Verified allowDelete for promotion_id:$promotion_id");
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


} // end of PromotionMaster
?>

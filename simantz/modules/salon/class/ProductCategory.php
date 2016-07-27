<?php
/************************************************************************
 Class ProductCategory.php - Copyright kfhoo
**************************************************************************/

class ProductCategory
{

  public $category_id;
  public $category_code;
  public $category_description;
  public $remarks;
  public $isactive;
  public $isdefault;
  public $issales;
  public $isitem;
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
  private $tablecategory;
  private $tableproduct;
  public $filename;
public $deleteAttachment;
  private $log;


//constructor
   public function ProductCategory($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simsalon_organization";
	$this->tablecategory=$tableprefix . "simsalon_productcategory";
	$this->tableproduct=$tableprefix."simsalon_productlist";
	$this->log=$log;
   }


  public function getInputForm( $type,  $category_id,$token  ) {
	

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";

	$uploadctrl="";
	$filectrl="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Category";
		$action="create";
	 	
		if($category_id==0){
			$this->category_code="";
			$this->category_description="";
			$this->remarks="";
			$this->isactive="";
			$this->organization_id;
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$checked3="CHECKED";
		$checked2="";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectService="";
		$selectProduct="";
		$selectOthers="";

		switch($this->isitem){
			case "Y":
				$selectOthers="SELECTED='SELECTED'";
				$selectService="";
				$selectProduct="";
			break;
			case "N":
				$selectService="";
				$selectOthers="";
				$selectProduct="SELECTED='SELECTED'";
			break;
			default:
				$selectProduct="";
				$selectOthers="";
				$selectService="SELECTED='SELECTED'";

			break;
		}
		$itemselect="<SELECT name='isitem'>
				<option value='Y' $selectOthers>Others</option>
				<option value='N' $selectProduct>Products</option>
				<option value='C'$selectService>Services</option></SELECT>";

		$this->category_code = getNewCode($this->xoopsDB,"category_code",$this->tablecategory);
	}
	else
	{
		$selectStock="";
		$selectService="";
		$selectProduct="";

		switch($this->isitem){
			case "Y":
				$selectOthers="SELECTED='SELECTED'";
				$selectService="";
				$selectProduct="";
			break;
			case "N":
				$selectService="";
				$selectOthers="";
				$selectProduct="SELECTED='SELECTED'";
			break;
			default:
				$selectProduct="";
				$selectOthers="";
				$selectService="SELECTED='SELECTED'";

			break;
		}
		$itemselect="<SELECT name='isitem'>
				<option value='Y' $selectOthers>Others</option>
				<option value='N' $selectProduct>Products</option>
				<option value='C'$selectService>Services</option></SELECT>";

		$action="update";
		$savectrl="<input name='category_id' value='$this->category_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablecategory' type='hidden'>".
		"<input name='id' value='$this->category_id' type='hidden'>".
		"<input name='idname' value='category_id' type='hidden'>".
		"<input name='title' value='Category' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		
		

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

		

		//if ($this->isitem=='Y')
		//	$itemchecked="CHECKED";
		//else
		//	$itemchecked="";
		$header="Edit Product Category";
		
		if($this->allowDelete($this->category_id) && $this->category_id>0)
		$deletectrl="<FORM action='category.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this category?"'.")'><input style='height:40px;' type='submit' value='Delete' name='submit' style='height: 40px;'>".
		"<input type='hidden' value='$this->category_id' name='category_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='category.php' method='POST'><input name='submit' value='New' type='submit'></form>";

		$filename="upload/category/".$this->filename;
		if(file_exists($filename) && $this->filename !="" && $this->filename !="/" && $this->filename !=" ")
			$filectrl="<img src='$filename' atarget='_blank' atitle='View Pict'>";
		else
			$filectrl="<b style='color:red;'>No Attachment</b>";
		
		$uploadctrl='<tr><td class="head">Attachment (50 X 50)</td> <td class="even" colspan="3">'.$filectrl.'<br>Remove File <input type="checkbox" name="deleteAttachment" title="Choose it if you want to remove this attachment"> <input type="file" name="upload_file" size="50" title="Upload hardcopy here. "></td></tr>';
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Product Category</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateCategory()" method="post"
 action="category.php" name="frmCategory" enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>

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
        <td class="head">Category Code</td>
        <td class="even" colspan="2"><input maxlength="10" size="10" name="category_code" value="$this->category_code">
	Active <input type="checkbox" $checked name="isactive">&nbsp;&nbsp;
	Default <input type="checkbox" $checked2 name="isdefault">&nbsp;&nbsp;
	For Sales <input type="checkbox" $checked3 name="issales">&nbsp;&nbsp;
	</td>
      </tr>
      <tr>
        <td class="head">Category Name</td>
        <td class="odd" colspan="2"><input maxlength="40" size="40"
 name="category_description" value="$this->category_description"></td>
      </tr>
 <tr>
        <td class="head">Item Type</td>
        <td class="even" colspan="2"> $itemselect</td>
      </tr>
	
	<tr>
	<td class="head">Remarks</td>
	<td class="odd" colspan="2"><textarea name="remarks" cols="80" rows="1">$this->remarks</textarea></td>
	</tr>

	$uploadctrl

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


  public function updateCategory($withfile='N' ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;

	if($withfile=='N'){
 	$sql="UPDATE $this->tablecategory SET ".
	"category_description='$this->category_description',category_code='$this->category_code',isitem='$this->isitem',".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id, ".
	"remarks='$this->remarks', ".
	"isdefault='$this->isdefault', issales='$this->issales' ".
	" WHERE category_id='$this->category_id'";
	}else{
	$sql="UPDATE $this->tablecategory SET ".
	"category_description='$this->category_description',category_code='$this->category_code',isitem='$this->isitem',".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id, ".
	"remarks='$this->remarks', filename='$this->filename', ".
	"isdefault='$this->isdefault', issales='$this->issales' ".
	" WHERE category_id='$this->category_id'";
	}


	
	$this->log->showLog(3, "Update category_id: $this->category_id, $this->category_code");
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
	$this->log->showLog(3,"Inserting new category $this->category_code");
 	$sql="INSERT INTO $this->tablecategory (category_description,remarks,category_code".
	",isactive,isdefault,issales, created,createdby,updated,updatedby,organization_id,isitem) values(".
	"'$this->category_description','$this->remarks','$this->category_code','$this->isactive','$this->isdefault', '$this->issales', '$timestamp',$this->createdby,'$timestamp',".
	"$this->updatedby,$this->organization_id,'$this->isitem')";
	$this->log->showLog(4,"Before insert category SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert category code $category_code");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new category $category_code successfully"); 
		return true;
	}
  } // end of member function insertCategory


  public function fetchCategory( $category_id) {
    
	$this->log->showLog(3,"Fetching category detail into class Category.php.<br>");
		
	$sql="SELECT * from $this->tablecategory ". 
			"where category_id=$category_id";
	
	$this->log->showLog(4,"ProductCategory->fetchCategory, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->organization_id=$row["organization_id"];
		$this->category_code=$row["category_code"];
		$this->category_description= $row['category_description'];
		$this->remarks= $row['remarks'];
		$this->isactive=$row['isactive'];
		$this->isdefault=$row['isdefault'];
		$this->issales=$row['issales'];
		$this->isitem=$row['isitem'];
		$this->filename=$row['filename'];

   	$this->log->showLog(4,"Category->fetchCategory,database fetch into class successfully");
	$this->log->showLog(4,"organization_id:$this->organization_id");
	$this->log->showLog(4,"category_code:$this->category_code");
	$this->log->showLog(4,"category_description:$this->category_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

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
	if (!rs){
		$this->log->showLog(1,"Error: category ($category_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"category ($category_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteCategory

 public function savefile($tmpfile,$newfilename){

	if(move_uploaded_file($tmpfile, "upload/category/$newfilename")){
	//move_uploaded_file($tmpfile, "upload/category/$newfilename");
	$sqlupdate="UPDATE $this->tablecategory set filename='$newfilename' where category_id=$this->category_id";
	$qryUpdate=$this->xoopsDB->query($sqlupdate);
	}else{
	echo "Cannot Upload File";
	}
	
  }

  public function deletefile($category_id){
	$sql="SELECT filename from $this->tablecategory where category_id=$category_id";
	$query=$this->xoopsDB->query($sql);
	$myfilename="";
	if($row=$this->xoopsDB->fetchArray($query)){
		$myfilename=$row['filename'];
	}
	$myfilename="upload/category/$myfilename";
	$this->log->showLog(3,"This file name: $myfilename");
	unlink("$myfilename ");
	$sqlupdate="UPDATE $this->tablecategory set filename='-' where category_id=$category_id";
	$qryDelete=$this->xoopsDB->query($sqlupdate);
  }


  public function getSQLStr_AllCategory( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running ProductCategory->getSQLStr_AllCategory: $sql");
    $sql="SELECT category_code,category_description,remarks,category_id,isactive,isdefault,issales,organization_id,isitem FROM $this->tablecategory " .
	" $wherestring $orderbystring";
  return $sql;
  } // end of member function getSQLStr_AllCategory

 public function showCategoryTable(){
	
	$this->log->showLog(3,"Showing Category Table");
	$sql=$this->getSQLStr_AllCategory("where category_id>0","ORDER BY category_code",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Category Code</th>
				<th style="text-align:center;">Category Name</th>
				<th style="text-align:center;">Category Type</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Default</th>
				<th style="text-align:center;">For Sales</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$category_id=$row['category_id'];
		$category_code=$row['category_code'];
		$category_description=$row['category_description'];
		$remarks=$row['remarks'];
		$organization_id=$row['organization_id'];
		$isactive=$row['isactive'];
		$isdefault=$row['isdefault'];
		$issales=$row['issales'];
		$isitem=$row['isitem'];

		if($isitem=='Y')
			$isitem="Others";
		elseif($isitem=='N')
			$isitem="Products";
		else
			$isitem="Services";

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$category_code</td>
			<td class="$rowtype" style="text-align:center;">$category_description</td>
			<td class="$rowtype" style="text-align:center;">$isitem</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$isdefault</td>
			<td class="$rowtype" style="text-align:center;">$issales</td>
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

  public function getSelectCategory($id,$function="",$showNull='Y',$isitem="") {

	if ($isitem=='Y')
		$wherestring="and isitem='Y'";
	elseif($isitem=='N')
		$wherestring="and isitem='N'";
	elseif($isitem=='C')
		$wherestring="and isitem='C'";
	else
		$wherestring="";
	
	$sql="SELECT category_id,category_description from $this->tablecategory where (isactive='Y' or category_id=$id ) and category_id>0 $wherestring order by category_description ;";
	$selectctl="<SELECT name='category_id' $function >";
	if ($id==-1 || $showNull='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED"></OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$category_id=$row['category_id'];
		$category_description=$row['category_description'];
	
		if($id==$category_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$category_id' $selected>$category_description</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	$sql="SELECT count(category_id) as rowcount from $this->tableproduct where category_id=$id";
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
} // end of ClassCategory
?>

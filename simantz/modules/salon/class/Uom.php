<?php
/************************************************************************
 Class Uom.php - Copyright kfhoo
**************************************************************************/

class Uom
{

  public $uom_id;
  public $uom_code;
  public $uom_description;
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
  private $tableuom;
  private $tableproduct;
  private $tablecustomer;
  private $tableproductlist;
  private $tableexpenseslist;

  private $log;


//constructor
   public function Uom($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simsalon_organization";
	$this->tableuom=$tableprefix . "simsalon_uom";
	$this->tablecustomer=$tableprefix . "simsalon_customer";
	$this->tableproductlist=$tableprefix . "simsalon_productlist";
	$this->tableexpenseslist=$tableprefix . "simsalon_expenseslist";

	$this->log=$log;
   }


  public function getInputForm( $type,  $uom_id,$token  ) {
	

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Uom";
		$action="create";
	 	
		if($uom_id==0){
			$this->uom_code="";
			$this->uom_description="";
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

		$this->uom_code = getNewCode($this->xoopsDB,"uom_code",$this->tableuom);

	}
	else
	{
		$selectStock="";
		$selectService="";
		$selectProduct="";

		
		$action="update";
		$savectrl="<input name='uom_id' value='$this->uom_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableuom' type='hidden'>".
		"<input name='id' value='$this->uom_id' type='hidden'>".
		"<input name='idname' value='uom_id' type='hidden'>".
		"<input name='title' value='Uom' type='hidden'>".
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
		$header="Edit Product Uom";
		
		if($this->allowDelete($this->uom_id) && $this->uom_id>0)
		$deletectrl="<FORM action='uom.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this uom?"'.")'><input type='submit' value='Delete' name='submit' style='height: 40px;'>".
		"<input type='hidden' value='$this->uom_id' name='uom_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='uom.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;"> Unit Of Measurement</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateUom()" method="post"
 action="uom.php" name="frmUom"><input name="reset" value="Reset" type="reset"></td></tbody></table>

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
        <td class="head">Unit Of Measurement Code</td>
        <td class="even" colspan="2"><input maxlength="10" size="10"
 name="uom_code" value="$this->uom_code"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Unit Of Measurement Description</td>
        <td class="odd" colspan="2"><input maxlength="40" size="40"
 name="uom_description" value="$this->uom_description"></td>
      </tr>

	<tr>
		<td class="head">Remarks</td>
		<td class="even" colspan="2"><textarea name="remarks" cols="80" rows="1">$this->remarks</textarea></td>
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


  public function updateUom( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableuom SET
	uom_description='$this->uom_description',remarks='$this->remarks',
	uom_code='$this->uom_code',
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id
	WHERE uom_id='$this->uom_id'";
	
	$this->log->showLog(3, "Update uom_id: $this->uom_id, $this->uom_code");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update uom failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update uom successfully.");
		return true;
	}
  } // end of member function updateUom


  public function insertUom( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new uom $this->uom_code");
 	$sql="INSERT INTO $this->tableuom (uom_description,remarks,uom_code
	,isactive, created,createdby,updated,updatedby,organization_id) values(
	'$this->uom_description','$this->remarks','$this->uom_code','$this->isactive',
	'$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->organization_id)";
	$this->log->showLog(4,"Before insert uom SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert uom code $uom_code");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new uom $uom_code successfully"); 
		return true;
	}
  } // end of member function insertUom


  public function fetchUom( $uom_id) {
    
	$this->log->showLog(3,"Fetching uom detail into class Uom.php.<br>");
		
	$sql="SELECT * from $this->tableuom ". 
			"where uom_id=$uom_id";
	
	$this->log->showLog(4,"Uom->fetchUom, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->organization_id=$row["organization_id"];
		$this->uom_code=$row["uom_code"];
		$this->uom_description= $row['uom_description'];
		$this->remarks= $row['remarks'];
		$this->isactive=$row['isactive'];
		
   	$this->log->showLog(4,"Uom->fetchUom,database fetch into class successfully");
	$this->log->showLog(4,"organization_id:$this->organization_id");
	$this->log->showLog(4,"uom_code:$this->uom_code");
	$this->log->showLog(4,"uom_description:$this->uom_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Uom->fetchUom,failed to fetch data into databases.");	
	}
  } // end of member function fetchUom


  public function deleteUom( $uom_id ) {
    	$this->log->showLog(2,"Warning: Performing delete uom id : $uom_id !");
	$sql="DELETE FROM $this->tableuom where uom_id=$uom_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: uom ($uom_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"uom ($uom_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteUom


  public function getSQLStr_AllUom( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running Uom->getSQLStr_AllUom: $sql");
    $sql="SELECT * FROM $this->tableuom " .
	" $wherestring $orderbystring";
  return $sql;
  } // end of member function getSQLStr_AllUom

 public function showUomTable(){
	
	$this->log->showLog(3,"Showing Uom Table");
	$sql=$this->getSQLStr_AllUom("where uom_id>0","ORDER BY uom_code",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Uom Code</th>
				<th style="text-align:center;">Uom Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$uom_id=$row['uom_id'];
		$uom_code=$row['uom_code'];
		$uom_description=$row['uom_description'];
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
			<td class="$rowtype" style="text-align:center;">$uom_code</td>
			<td class="$rowtype" style="text-align:center;">$uom_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="uom.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this uom'>
				<input type="hidden" value="$uom_id" name="uom_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }


  public function getLatestUomID() {
	$sql="SELECT MAX(uom_id) as uom_id from $this->tableuom;";
	$this->log->showLog(3,'Checking latest created uom_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created uom_id:' . $row['uom_id']);
		return $row['uom_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectUom($id,$fld='uom_id') {
	
	$sql="SELECT uom_id,uom_description from $this->tableuom where (isactive='Y' or uom_id=$id )  order by uom_description ;";
	$selectctl="<SELECT name=$fld >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$uom_id=$row['uom_id'];
		$uom_description=$row['uom_description'];
	
		if($id==$uom_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$uom_id' $selected>$uom_description</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){

	$val = true;
	$tablelink = array($this->tableproductlist,$this->tableexpenseslist);
	
	$count = count($tablelink);
	$i = 0;
	while($i<$count){
	

	$sql = "SELECT count(*) as rowcount from $tablelink[$i] where uom_id = $id ";
	$this->log->showLog(4,"SQL:$sql");

	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query))	
		if($row['rowcount']>0){
		$i = $count;
		$this->log->showLog(3,"record found, record not deletable");
		$val = false;
		}

	$i++;
	}


	return $val;

	/*
	$sql="SELECT count(uom) as rowcount from $this->tablecustomer where uom=$id";
	$this->log->showLog(3,"Accessing Uom->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this uom, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this uom, record deletable");
		return true;
		}*/
	}
	
} // end of ClassUom
?>

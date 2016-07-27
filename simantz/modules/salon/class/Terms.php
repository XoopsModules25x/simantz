<?php
/************************************************************************
 Class Terms.php - Copyright kfhoo
**************************************************************************/

class Terms
{

  public $terms_id;
  public $terms_code;
  public $terms_description;
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
  private $tableterms;
  private $tableproduct;
  private $tablecustomer;
  private $tablevinvoice;
  private $log;


//constructor
   public function Terms($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableorganization=$tableprefix . "simsalon_organization";
	$this->tableterms=$tableprefix . "simsalon_terms";
	$this->tablecustomer=$tableprefix . "simsalon_customer";
	$this->tablevinvoice=$tableprefix . "simsalon_vinvoice";
	$this->log=$log;
   }


  public function getInputForm( $type,  $terms_id,$token  ) {
	

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Terms";
		$action="create";
	 	
		if($terms_id==0){
			$this->terms_code="";
			$this->terms_description="";
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
		
		$this->terms_code = getNewCode($this->xoopsDB,"terms_code",$this->tableterms);
		
	}
	else
	{
		$selectStock="";
		$selectService="";
		$selectProduct="";

		
		$action="update";
		$savectrl="<input name='terms_id' value='$this->terms_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableterms' type='hidden'>".
		"<input name='id' value='$this->terms_id' type='hidden'>".
		"<input name='idname' value='terms_id' type='hidden'>".
		"<input name='title' value='Terms' type='hidden'>".
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
		$header="Edit Product Terms";
		
		if($this->allowDelete($this->terms_id) && $this->terms_id>0)
		$deletectrl="<FORM action='terms.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this terms?"'.")'><input type='submit' value='Delete' name='submit' style='height: 40px;'>".
		"<input type='hidden' value='$this->terms_id' name='terms_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='terms.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;"> Terms</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateTerms()" method="post"
 action="terms.php" name="frmTerms"><input name="reset" value="Reset" type="reset"></td></tbody></table>

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
        <td class="head">Terms Code</td>
        <td class="even" colspan="2"><input maxlength="10" size="10"
 name="terms_code" value="$this->terms_code"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">Terms Description</td>
        <td class="odd" colspan="2"><input maxlength="40" size="40"
 name="terms_description" value="$this->terms_description"></td>
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


  public function updateTerms( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableterms SET
	terms_description='$this->terms_description',remarks='$this->remarks',
	terms_code='$this->terms_code',
	updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',organization_id=$this->organization_id
	WHERE terms_id='$this->terms_id'";
	
	$this->log->showLog(3, "Update terms_id: $this->terms_id, $this->terms_code");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update terms failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update terms successfully.");
		return true;
	}
  } // end of member function updateTerms


  public function insertTerms( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new terms $this->terms_code");
 	$sql="INSERT INTO $this->tableterms (terms_description,remarks,terms_code
	,isactive, created,createdby,updated,updatedby,organization_id) values(
	'$this->terms_description','$this->remarks','$this->terms_code','$this->isactive',
	'$timestamp',$this->createdby,'$timestamp',
	$this->updatedby,$this->organization_id)";
	$this->log->showLog(4,"Before insert terms SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert terms code $terms_code");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new terms $terms_code successfully"); 
		return true;
	}
  } // end of member function insertTerms


  public function fetchTerms( $terms_id) {
    
	$this->log->showLog(3,"Fetching terms detail into class Terms.php.<br>");
		
	$sql="SELECT * from $this->tableterms ". 
			"where terms_id=$terms_id";
	
	$this->log->showLog(4,"Terms->fetchTerms, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->organization_id=$row["organization_id"];
		$this->terms_code=$row["terms_code"];
		$this->terms_description= $row['terms_description'];
		$this->remarks= $row['remarks'];
		$this->isactive=$row['isactive'];
		
   	$this->log->showLog(4,"Terms->fetchTerms,database fetch into class successfully");
	$this->log->showLog(4,"organization_id:$this->organization_id");
	$this->log->showLog(4,"terms_code:$this->terms_code");
	$this->log->showLog(4,"terms_description:$this->terms_description");
	$this->log->showLog(4,"isactive:$this->isactive");
	

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Terms->fetchTerms,failed to fetch data into databases.");	
	}
  } // end of member function fetchTerms


  public function deleteTerms( $terms_id ) {
    	$this->log->showLog(2,"Warning: Performing delete terms id : $terms_id !");
	$sql="DELETE FROM $this->tableterms where terms_id=$terms_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: terms ($terms_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"terms ($terms_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteTerms


  public function getSQLStr_AllTerms( $wherestring,  $orderbystring,  $startlimitno ) {
  $this->log->showLog(4,"Running Terms->getSQLStr_AllTerms: $sql");
    $sql="SELECT * FROM $this->tableterms " .
	" $wherestring $orderbystring";
  return $sql;
  } // end of member function getSQLStr_AllTerms

 public function showTermsTable(){
	
	$this->log->showLog(3,"Showing Terms Table");
	$sql=$this->getSQLStr_AllTerms("where terms_id>0","ORDER BY terms_code",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Terms Code</th>
				<th style="text-align:center;">Terms Description</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$terms_id=$row['terms_id'];
		$terms_code=$row['terms_code'];
		$terms_description=$row['terms_description'];
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
			<td class="$rowtype" style="text-align:center;">$terms_code</td>
			<td class="$rowtype" style="text-align:center;">$terms_description</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="terms.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this terms'>
				<input type="hidden" value="$terms_id" name="terms_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }


  public function getLatestTermsID() {
	$sql="SELECT MAX(terms_id) as terms_id from $this->tableterms;";
	$this->log->showLog(3,'Checking latest created terms_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created terms_id:' . $row['terms_id']);
		return $row['terms_id'];
	}
	else
	return -1;
	
  } // end

  public function getSelectTerms($id,$fld='terms_id',$function="") {
	
	$sql="SELECT terms_id,terms_description from $this->tableterms where (isactive='Y' or terms_id=$id )  order by terms_description ;";
	$selectctl="<SELECT name=$fld  onchange='$function'>";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$terms_id=$row['terms_id'];
		$terms_description=$row['terms_description'];
	
		if($id==$terms_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$terms_id' $selected>$terms_description</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	$sql="SELECT count(terms_id) as rowcount from $this->tablevinvoice where terms_id=$id";
	$this->log->showLog(3,"Accessing Terms->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this terms, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this terms, record deletable");
		return true;
		}
	}
} // end of ClassTerms
?>

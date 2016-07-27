<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
/**
 * class Area
 */
class Area{

  public $area_id;
  public $area_name;
  public $area_description;
  public $organization_id;
  public $isactive;
  public $created;
  public $createdby;
  public $isAdmin;
  public $updated;
  public $updatedby;
  public $cur_name;
  public $cur_symbol;
  private $xoopsDB;
  private $tableprefix;
  private $tabletransport;
  private $tablearea;
  private $log;

  /**
   * @access public, constructor
   */
  public function Area($xoopsDB, $tableprefix, $log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tablearea=$tableprefix . "simtrain_area";
	$this->log=$log;
   }

  public function getSqlStr_AllArea( $wherestring,  $orderbystring,  $startlimitno ) {
  
    $sql="SELECT area_id,area_name,area_description FROM $this->tablearea $wherestring $orderbystring";
   $this->log->showLog(4,"Running Area->getSQLStr_AllArea: $sql");
  return $sql;
  } // end of member function getSqlStr_AllClass

  public function getInputForm( $type,  $area_id,$token ) {
	$mandatorysign="<b style='color:red'>*</b>";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	if ($type=="new"){
		$header="New Area";
		$action="create";
		if($area_id==0){
		$this->area_name="";
		}
		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$deletectrl="";
		$addnewctrl="";
	}
	else
	{
		$action="update";
		$savectrl="<input name='area_id' value='$this->area_id' type='hidden'>".
			 "<input style='height:40px;' name='submit' value='Save' type='submit'>";

		$header="Edit Area";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablearea' type='hidden'>".
		"<input name='id' value='$this->area_id' type='hidden'>".
		"<input name='idname' value='area_id' type='hidden'>".
		"<input name='title' value='Area' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		
		if($this->area_id>1)
		$deletectrl="<FORM action='area.php' method='POST' onSubmit='return confirm(".
		'"Confirm to remove this area?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->area_id' name='area_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		 $addnewctrl="<form action='area.php' method='post'><input type='submit' value='New' value='New'></form>";
	}

    echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Area List</span></big></big></big></div><br>-->
<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form method="post" action="area.php" name="frmArea" onSubmit="return validateArea()"><input name="reset" value="Reset" type="reset"></td></tbody></table>

 <table cellspacing='3' border='1'>
  <tbody>
    <tr>
      <th  colspan="2">$header</th>
	</tr><tr>
      <td class="head">Area Name $mandatorysign</td>
      <td class="odd"><input name="area_name" value="$this->area_name" ></td>
	</tr><tr>
	 <td class="head">Area Description</td>
	<TD class="even"><textarea cols="70" rows="10" name="area_description">$this->area_description</textarea></TD>
    </tr>
  </tbody>
</table>

<table style="width:150px;"><tbody><td>$savectrl<input name='action' value="$action" type='hidden'>
	<input name='token' value="$token" type='hidden'></td>
	</form><td>$deletectrl</td></tbody></table>
$recordctrl
EOF;

  } // end of member function getInputForm

  public function insertArea() {
	$this->log->showLog(3,"Creating area SQL:$sql");

     	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new area $this->area_id");
 	$sql="INSERT INTO $this->tablearea (area_name,created,createdby,updated,updatedby,area_description) values(".
	"'$this->area_name','$timestamp',$this->createdby,'$timestamp',$this->updatedby,'$this->area_description')";
	$this->log->showLog(4,"Before insert area SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert area name '$area_name'");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new area name '$area_name' successfully"); 
		return true;
	}
  } // end of member function insertClassMaster

  /**
   * Update class information
   *
   * @return bool
   * @access public
   */
  public function updateArea( ) {
    $timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablearea SET ".
	"area_name='$this->area_name',updated='$timestamp',updatedby=$this->updatedby,area_description='$this->area_description' ".
	"WHERE area_id='$this->area_id'";
	
	$this->log->showLog(3, "Update area_id: $this->area_id, '$this->area_name'");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update area failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update area successfully.");
		return true;
	}
  } // end of member function updateClass

  public function deleteArea( $area_id ) {
   	$this->log->showLog(2,"Warning: Performing delete area id : $area_id !");
	$sql="DELETE FROM $this->tablearea where area_id=$area_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: Area ($area_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Area ($area_id) removed from database successfully!");
		return true;
	}
  } // end of member function deleteArea

  public function fetchArea( $area_id ) {
    
	$this->log->showLog(3,"Fetching area detail into class Area.php.<br>");
		
	$sql="SELECT area_id,area_name,area_description FROM $this->tablearea ". 
			"where area_id=$area_id";
	
	$this->log->showLog(4,"Area->fetchArea, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->area_id=$row['area_id'];
		$this->area_name= $row['area_name'];
		$this->area_description=$row['area_description'];
	   	$this->log->showLog(4,"Area->fetch Area, database fetch into class successfully");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Area->fetchArea, failed to fetch data into databases.");	
	}
  } // end of member function fetchArea

  public function getLatestAreaID(){
  	$sql="SELECT MAX(area_id) as area_id from $this->tablearea;";
	$this->log->showLog(3, "Retrieveing last area id");
	$this->log->showLog(4, "With SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['area_id'];
	else
	return -1;
  }

  public function getAreaList($id,$ctrlname="area_id"){
	$this->log->showLog(3,"Retrieve available area from database");

	$sql="SELECT area_id, area_name from $this->tablearea order by area_name ";
	$areactrl="<SELECT name='$ctrlname' >";
	if ($id==-1)
		$areactrl=$areactrl . '<OPTION value="0" SELECTED="SELECTED">-</OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$area_id=$row['area_id'];
		$area_name=$row['area_name'];
		if($id==$area_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		
		$areactrl=$areactrl  . "<OPTION value='$area_id' $selected>$area_name</OPTION>";
		$this->log->showLog(4,"Retrieving area_id:$area_id area_name:$area_name");
	}
	$areactrl=$areactrl . "</SELECT>";
	return $areactrl;
}//end of getAreaList

public function showAreaTable(){
	$wherestring="";
	$this->log->showLog(3,"Showing Area Table");
	$sql=$this->getSQLStr_AllArea($wherestring,"ORDER BY area_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table style="width:400px;" border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Area Name</th>
				<th style="text-align:center;">Area Description</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$area_id=$row['area_id'];
		$area_name=$row['area_name'];
		$area_description=$row['area_description'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
$delctrl="<FORM action='area.php' method='POST' onSubmit='return confirm(".
		'"Confirm to remove this area?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$area_id' name='area_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:left;">$area_name</td>
			<td class="$rowtype" style="text-align:left;">$area_description</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="area.php" method="POST">
				<input type="submit" value="Edit" name="submit">
				<input type="hidden" value="$area_id" name="area_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>	
			</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }
}
?>

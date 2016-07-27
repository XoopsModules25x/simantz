<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
/**
 * class Transport
 */
class Transport
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/


  public $transport_id;
  public $transport_code;
  public $area_id;
  public $doubletrip_fees;
  public $singletrip_fees;
  public $organization_id;
  public $isactive;
  public $created;
  public $cur_name;
  public $cur_symbol;
  public $orgctrl;
  public $createdby;
  public $updated;
  public $updatedby;
  public $areactrl;
  public $isAdmin;
  private $xoopsDB;
  private $tableprefix;
  private $tabletransport;
  private $tablearea;
  private $tableorganization;
  private $log;

  /**
   * @access public, constructor
   */
  public function Transport($xoopsDB, $tableprefix, $log){
	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tabletransport=$tableprefix . "simtrain_transport";
	$this->tablearea=$tableprefix . "simtrain_area";
	$this->tableorganization=$tableprefix . "simtrain_organization";
	$this->log=$log;
   }

  /**
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllTransport( $wherestring,  $orderbystring,  $startlimitno ) {
    $sql= "SELECT t.transport_id, t.transport_code, t.area_id, a.area_name, t.doubletrip_fees, t.singletrip_fees, t.organization_id, o.organization_name, t.isactive, t.created, t.createdby, t.updated, t.updatedby FROM $this->tabletransport t inner join $this->tablearea a on t.area_id=a.area_id inner join $this->tableorganization o on o.organization_id=t.organization_id $wherestring $orderbystring";
	$this->log->showLog(4,"Calling getSQLStr_AllTransport:" .$sql);
   return $sql;
  } // end of member function getSQLStr_AllTransport

  /**
   *
   * @param string type 'new' or 'edit'
   * @param int employee_id 
   * @return bool
   * @access public
   */
  public function getInputForm( $type,  $transport_id, $token ) {
	$mandatorysign="<b style='color:red'>*</b>";
	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$areactrl="";
	$deletectrl="";
	$areactrl=$this->getAreaList($this->area_id);
	if ($type=="new"){
		$header="New Transport Service";
		$action="create";
		if($transport_id==0){
		$this->transport_id="";
		$this->transport_code="";
		$this->area_id=0;
		$this->doubletrip_fees="";
		$this->singletrip_fees="";
		$this->organization_id="";
		$areactrl=$this->getAreaList($this->area_id);
		}

		$savectrl="<input style='height:40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
	}
	else
	{
		$areactrl=$this->getAreaList($this->area_id);
		$action="update";
		$savectrl="<input name='transport_id' value='$this->transport_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tabletransport' type='hidden'>".
		"<input name='id' value='$this->transport_id' type='hidden'>".
		"<input name='idname' value='transport_id' type='hidden'>".
		"<input name='title' value='Transport' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";



		$header="Edit Transport Service";
		$deletectrl="<FORM action='transport.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this transport service?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->transport_id' name='transport_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		$addnewctrl="<Form action='transport.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

echo <<< EOF

<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Transport Service</span></big></big></big></div><br>-->
<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form method="post" action="transport.php" name="frmTransport" onSubmit="return validateTransport()"><input name="reset" value="Reset" type="reset"></td></tbody></table>
<table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
<tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
	<tr>
		<td class="head">Transport Code $mandatorysign</td>
		<td class="odd"><input name="transport_code" value="$this->transport_code"> </td>
		<td class="head">Active</td><td  class="odd"><input type="checkbox" $checked name="isactive"></td>
	</tr>
	<tr>
		<td class="head">Organization</td>
		<td class="even">$this->orgctrl</td>
		<td class="head">Area</td>
		<td class="even">$areactrl</td>
	</tr>
	<tr>
		<td class="head">Single Trip ($this->cur_symbol)$mandatorysign</td>
		<td class="odd"><input name="singletrip_fees" value="$this->singletrip_fees"></td>

		<td class="head">Double Trip ($this->cur_symbol)$mandatorysign</td>
		<td class="odd"><input name="doubletrip_fees" value="$this->doubletrip_fees"></td>
	</tr>
</tbody>
</table>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$deletectrl</td></tbody></table><br>
$recordctrl
EOF;
  } // end of member function getInputForm

public function getAreaList($id){
	$this->log->showLog(3,"Retrieve available area from database");

	$sql="SELECT area_id, area_name from $this->tablearea order by area_name ";
	$areactrl="<SELECT name='area_id' >";
	if ($id==-1)
		$areactrl=$areactrl . '<OPTION value="0" SELECTED="SELECTED"> </OPTION>';
		
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

  /**
   *
   * @param int transport_id 
   * @return bool
   * @access public
   */
  public function deleteTransport( $transport_id ) {
    	$this->log->showLog(2,"Warning: Performing delete transport id : $transport_id !");
	$sql="DELETE FROM $this->tabletransport where transport_id=$transport_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: transport ($transport_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"Transport ($transport_id) removed from database successfully!");
		return true;
		
	}
	

  } // end of member function deleteEmployee

  /**
   *
   * @return bool
   * @access public
   */
  public function updateTransport( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$sql="UPDATE $this->tabletransport SET transport_code='$this->transport_code', area_id='$this->area_id',  doubletrip_fees='$this->doubletrip_fees', singletrip_fees='$this->singletrip_fees', organization_id='$this->organization_id', isactive='$this->isactive', updated='$timestamp', updatedby='$this->updatedby' WHERE transport_id='$this->transport_id'";
	
	$this->log->showLog(3, "Update transport_id: $this->transport_id, $this->area_id");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update transport service failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update transport successfully.");
		return true;
	}

  } // end of member function updateTransport

  public function getLatestTransportID() {
	$this->log->showLog(3, "Getting new created transportation id");
	$sql="SELECT MAX(transport_id) as transport_id from $this->tabletransport;";
	$this->log->showLog(4, $sql);
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query))
		return $row['transport_id'];
	else
	return -1;
	
  } // end of member function getLatestTransportID

  /**
   *
   * @return bool
   * @access public
   */
  public function insertTransport( ) {
	$timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new transport $this->transport_code");
 	$sql="INSERT INTO $this->tabletransport (transport_code, area_id, doubletrip_fees, singletrip_fees, organization_id, isactive, created, createdby, updated, updatedby) values('$this->transport_code', '$this->area_id', '$this->doubletrip_fees', '$this->singletrip_fees', '$this->organization_id', '$this->isactive', '$timestamp', '$this->createdby', '$timestamp', '$this->updatedby')";
	$this->log->showLog(4,"Before insert transport SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert transport $transport_code");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new transport $transport_code successfully"); 
		return true;
	}
} // end of member function insertTransport

  /**
   * Fetch Transport info from database into class
   *
   * @param int transport_id 
   * @return bool
   * @access public
   */
  public function fetchTransport( $transport_id ) {
	$this->log->showLog(3,"Fetching transport detail into class Transport.php.<br>");
		
	$sql="SELECT transport_code, area_id, doubletrip_fees, singletrip_fees, organization_id, isactive from $this->tabletransport where transport_id=$transport_id";
	
	$this->log->showLog(4,"Transport->fetchTransport, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->transport_code=$row["transport_code"];
		$this->area_id=$row["area_id"];
		$this->doubletrip_fees=$row["doubletrip_fees"];
		$this->singletrip_fees=$row["singletrip_fees"];
		$this->organization_id=$row["organization_id"];
		$this->isactive=$row['isactive'];
	$this->log->showLog(4,"Transport->fetchTransport, database fetch into class successfully, ".
				" with organization_id=$this->organization_id");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Transport->fetchTransport,failed to fetch data into databases.");	
	}
  } // end of member function fetchTransport

 public function selectionOrg($uid,$organization_id){

  return "<SELECT name='organization_id'><option value='0'>Visi Kota</option><option value='1'>Visi Jaya</option></SELECT>";

  }// end of  selectionOrg($uid)

/**
   *Control user whether he/she able to access all organization or only a few
   *
   *@param int $uid current login user id
   *return string a where istring, sample data is 'organization_id in (1,2)';
   *
   *@access public
   */
 public function orgWhereStr($uid){
  return "organization_id in (0,1,2,3)";
 } // end of orgWhereStr($uid)

public function selectionArea($uid,$area_id){
  return "<SELECT name='area_id'></SELECT>";

  }// end of  selectionOrg($uid)

 public function showTransportTable(){
	global $defaultorganization_id;
	$this->log->showLog(3,"Showing Transport Table");
	$sql=$this->getSQLStr_AllTransport("where transport_id>0 and t.organization_id = $defaultorganization_id ","ORDER BY area_name",0);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Transport Code</th>
				<th style="text-align:center;">Organization</th>
				<th style="text-align:center;">Area</th>
				<th style="text-align:center;">Double Trip<br>Charges ($this->cur_symbol)</th>
				<th style="text-align:center;">Single Trip<br>Charges ($this->cur_symbol)</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="odd";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$transport_code=$row['transport_code'];
		$transport_id=$row['transport_id'];
		$organization_name=$row['organization_name'];
		$area_id=$row['area_id'];
		$area_name=$row['area_name'];
		$doubletrip_fees=$row['doubletrip_fees'];
		$singletrip_fees=$row['singletrip_fees'];
		$isactive=$row['isactive'];
		$sql="SELECT area_name from $this->tablearea where area_id=$area_id";
	

		if($rowtype=="odd"){
			$rowtype="even";}
		else{
			$rowtype="odd";}
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$transport_code</td>
			<td class="$rowtype" style="text-align:center;">$organization_name</td>
			<td class="$rowtype" style="text-align:center;">$area_name</td>
			<td class="$rowtype" style="text-align:center;">$doubletrip_fees</td>
			<td class="$rowtype" style="text-align:center;">$singletrip_fees</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="transport.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title="Edit this record.">
				<input type="hidden" value="$transport_id" name="transport_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}//end of while
echo  "</tr></tbody></table>";
 } //end of showTransportTable


} // end of Transport
?>

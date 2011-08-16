<?php

/**
 * class ProductActivitysummary
 * Grouping of the products, can be book, english tuition class, malay tuition
 * class or etc.
 */
class Activitysummary
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

  public $activitysummary_id;
  public $activitysummary_name;
  public $functiontype;
  public $filename;
  public $isactive;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  private $xoopsDB;
  private $tableprefix;
  private $tableactivitysummary;
  private $log;


//constructor
   public function Activitysummary($xoopsDB, $tableprefix,$log){
	global $path,$tableprefix;

	include_once $path."/modules/simtrain/tablename.php";
	//echo $this->tablewindows=$tablewindows;
	$this->xoopsDB=$xoopsDB;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int activitysummary_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $activitysummary_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	
	$orgctrl="";
	$this->created=0;
	switch($this->functiontype){
			case "V":
				$isreport="SELECTED='SELECTED'";
				$ismaster="";
				$istrans="";
			break;
			case "F":
				$isreport="";
				$ismaster="SELECTED='SELECTED'";
				$istrans="";
			break;
			case "T":
				$isreport="";
				$ismaster="";
				$istrans="SELECTED='SELECTED'";
			break;
			default :
				$isreport="";
				$ismaster="SELECTED='SELECTED'";
				$istrans="";

			break;
		}
	$functiontypeselect="<SELECT name='functiontype'><OPTION value='M' $ismaster>Master Data</OPTION>
				<option value='V' $isreport>Report</option>
				<option value='T' $istrans>Transaction</option>
				</SELECT>";


	if ($type=="new"){
		$header="New Activitysummary";
		$action="create";
	 	
		if($activitysummary_id==0){
			$this->activitysummary_name="";
			$this->functiontype="";
			$this->isactive="";
			$this->seqno=$this->getNextSeqNo();
		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

	
	}
	else
	{
		
		$action="update";
		$savectrl="<input name='activitysummary_id' value='$this->activitysummary_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tableactivitysummary' type='hidden'>".
		"<input name='id' value='$this->activitysummary_id' type='hidden'>".
		"<input name='idname' value='activitysummary_id' type='hidden'>".
		"<input name='title' value='Activitysummary' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

	
		$header="Edit Activitysummary";
		
		if($this->allowDelete($this->activitysummary_id) && $this->activitysummary_id>0)
		$deletectrl="<FORM action='activitysummary.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this activitysummary?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->activitysummary_id' name='activitysummary_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='activitysummary.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Activity Summary Report</span></big></big></big></div><br>

<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateActivitysummary()" method="post"
 action="activitysummary.php" name="frmActivitysummary"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="3" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Activitysummary Name $mandatorysign</td>
        <td class="even" colspan="2"><input maxlength="50" size="50"
 name="activitysummary_name" value="$this->activitysummary_name"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">File Name $mandatorysign</td>
        <td class="odd" colspan="2"><input maxlength="50" size="50"
 name="filename" value="$this->filename"></td>
      </tr>
      <tr>
        <td class="head">Activitysummary Type</td>
        <td class="odd" colspan="2">$functiontypeselect</td>
      </tr>
      <tr>
        <td class="head">Sequence No $mandatorysign</td>
        <td class="odd" colspan="2"><input name='seqno' value='$this->seqno'></td>
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

  /**
   * Update existing activitysummary record
   *
   * @return bool
   * @access public
   */
  public function updateActivitysummary( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableactivitysummary SET ".
	"functiontype='$this->functiontype',filename='$this->filename',activitysummary_name='$this->activitysummary_name',".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',seqno=$this->seqno ".
	"WHERE activitysummary_id='$this->activitysummary_id'";
	
	$this->log->showLog(3, "Update activitysummary_id: $this->activitysummary_id, $this->activitysummary_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update activitysummary failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update activitysummary successfully.");
		return true;
	}
  } // end of member function updateActivitysummary

  /**
   * Save new activitysummary into database
   *
   * @return bool
   * @access public
   */
  public function insertActivitysummary( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new activitysummary $this->activitysummary_name");
 	$sql="INSERT INTO $this->tableactivitysummary (functiontype,activitysummary_name".
	",isactive, created,createdby,updated,updatedby,filename,seqno) values(".
	"'$this->functiontype','$this->activitysummary_name','$this->isactive','$timestamp',$this->createdby,'$timestamp',".
	"$this->updatedby,'$this->filename',$this->seqno)";
	$this->log->showLog(4,"Before insert activitysummary SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!$rs){
		$this->log->showLog(1,"Failed to insert activitysummary code $activitysummary_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new activitysummary $activitysummary_name successfully"); 
		return true;
	}
  } // end of member function insertActivitysummary

  /**
   * Pull data from activitysummary table into class
   *
   * @return bool
   * @access public
   */
  public function fetchActivitysummary( $activitysummary_id) {
    
	$this->log->showLog(3,"Fetching activitysummary detail into class Activitysummary.php.<br>");
		
	$sql="SELECT activitysummary_id,activitysummary_name,functiontype,filename,isactive,seqno from $this->tableactivitysummary ". 
			"where activitysummary_id=$activitysummary_id";
	
	$this->log->showLog(4,"ProductActivitysummary->fetchActivitysummary, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->filename=$row["filename"];
		$this->activitysummary_name=$row["activitysummary_name"];
		$this->functiontype= $row['functiontype'];
		$this->seqno= $row['seqno'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"Activitysummary->fetchActivitysummary,database fetch into class successfully");
	$this->log->showLog(4,"activitysummary_name:$this->activitysummary_name");
	$this->log->showLog(4,"functiontype:$this->functiontype");
	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Activitysummary->fetchActivitysummary,failed to fetch data into databases.");	
	}
  } // end of member function fetchActivitysummary

  /**
   * Delete particular activitysummary id
   *
   * @param int activitysummary_id 
   * @return bool
   * @access public
   */
  public function deleteActivitysummary( $activitysummary_id ) {
    	$this->log->showLog(2,"Warning: Performing delete activitysummary id : $activitysummary_id !");
	$sql="DELETE FROM $this->tableactivitysummary where activitysummary_id=$activitysummary_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: activitysummary ($activitysummary_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"activitysummary ($activitysummary_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteActivitysummary

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllActivitysummary( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductActivitysummary->getSQLStr_AllActivitysummary: $sql");
    $sql="SELECT activitysummary_name,filename,functiontype,activitysummary_id,isactive,seqno FROM $this->tableactivitysummary " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showactivitysummarytable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllActivitysummary

 public function showActivitysummaryTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing Activitysummary Table");
	$sql=$this->getSQLStr_AllActivitysummary($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' style="width:900px;" cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Activitysummary Name</th>
				<th style="text-align:center;">File Name</th>
				<th style="text-align:center;">Type</th>
				<th style="text-align:center;width:700px;">Active</th>
				<th style="text-align:center;">Seq No</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$activitysummary_id=$row['activitysummary_id'];
		$activitysummary_name=$row['activitysummary_name'];
		$filename=$row['filename'];
		$functiontype=$row['functiontype'];
		$seqno=$row['seqno'];
		if($functiontype=='V')
		 $functiontype="Report";
		elseif($functiontype=='T')
		 $functiontype="Transaction";
		else
		 $functiontype="Master";

		$isactive=$row['isactive'];
		if($isactive=='N')
		$isactive="<b style='color:red;'>$isactive</b>";

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$activitysummary_name</td>
			<td class="$rowtype" style="text-align:center;">$filename</td>
			<td class="$rowtype" style="text-align:center;">$functiontype</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$seqno</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="activitysummary.php" method="POST">
				<input type="image" src="../images/edit.gif" name="submit" title='Edit this activitysummary'>
				<input type="hidden" value="$activitysummary_id" name="activitysummary_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

/**
   *
   * @return int
   * @access public
   */
  public function getLatestActivitysummaryID() {
	$sql="SELECT MAX(activitysummary_id) as activitysummary_id from $this->tableactivitysummary;";
	$this->log->showLog(3,'Checking latest created activitysummary_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created activitysummary_id:' . $row['activitysummary_id']);
		return $row['activitysummary_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {
	$sql="SELECT MAX(seqno) + 10 as seqno from $this->tableactivitysummary;";
	$this->log->showLog(3,'Checking next seqno');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found next seqno:' . $row['seqno']);
		return  $row['seqno'];
	}
	else
	return 10;
	
  } // end
  public function getSelectActivitysummary($id) {
	
	$sql="SELECT activitysummary_id,activitysummary_name from $this->tableactivitysummary where (isactive='Y' or activitysummary_id=$id) and activitysummary_id>0 order by activitysummary_name ;";
	$selectctl="<SELECT name='activitysummary_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$activitysummary_id=$row['activitysummary_id'];
		$activitysummary_name=$row['activitysummary_name'];
	
		if($id==$activitysummary_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$activitysummary_id' $selected>$activitysummary_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end

  public function allowDelete($id){
	$sql="SELECT count(activitysummary_id) as rowcount from $this->tablestudent where activitysummary_id=$id";
	$this->log->showLog(3,"Accessing ProductActivitysummary->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this activitysummary, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this activitysummary, record deletable");
		return true;
		}
	}

  public function showSearchForm(){

	$selectedI = "";
	$selectedU = "";
	$selectedD = "";
	$selectedN = "";

	if($this->activitytype=="I")
	$selectedI = "SELECTED";
	else if($this->activitytype=="U")
	$selectedU = "SELECTED";
	else if($this->activitytype=="D")
	$selectedD = "SELECTED";
	else
	$selectedN = "SELECTED";
echo <<< EOF
	<form action="activitysummary.php" method="POST" name="frmShowSearch">
	<table border=1>
	<tr class="tdListRightTitle">
	<td colspan="4">Search Criterial</td>
	</tr>
	<!--<tr>
	<td class="head">Organization</td>
	<td class="even" colspan="3">$this->orgctrl</td>
	</tr>-->

	<tr>
	<td class="head">Module</td>
	<td class="even">$this->modulectrl</td>
	<td class="head">User</td>
	<td class="even">$this->userctrl</td>
	</tr>
	<tr>
	<td class="head">Windows</td>
	<td class="even">$this->windowsctrl</td>
	<td class="head">Date From</td>
	<td class="even">
	<input name="datefrom" id="datefrom" value="$this->datefrom">
	<input type="button" value='Date' onclick="$this->showcalendar1"></td>
	</td>
	</tr>
	<tr>
	<td class="head">Activity</td>
	<td class="even">
	<select name="activitytype">
	<option value="" $selectedN>Null</option>
	<option value="I" $selectedI>Insert</option>
	<option value="U" $selectedU>Update</option>
	<option value="E" $selectedD>Delete</option>
	</select>
	</td>
        <td class="head">Date To</td>
	<td class="even">
	<input name="dateto" id="dateto" value="$this->dateto">
	<input type="button" value='Date' onclick="$this->showcalendar2">
	</td>
	</tr>

	<tr>
	<td colspan="4"><input type="submit" value="Search"></td>
	</tr>
	<input type="hidden" name="issearch" value="Y">
	</table>
	</form>
EOF;

  }

  public function showSearchResult(){
	global $xoopsDB;
	$wherestr = " where 1 ";

	//if($this->organization_id > 0)
	//$wherestr .= " and at.organization_id = $this->organization_id ";



	if($this->table_name != "" && $this->table_name != "0"){
	$wherestr .= " and at.tablename = '$this->table_name' ";}
	else if($this->table_name == "0" && $this->mid != "0") 
        {
            $sql="select table_name from sim_window where mid ='$this->mid' and table_name != ''";
            $query=$xoopsDB->query($sql);
            $i=0;
            $arrtable_name="";
            while ($row=$xoopsDB->fetchArray($query))
            {
              $i++;
              $table_name=$row['table_name'];
              $arrtable_name .= ",'$table_name'";

             }
          $arrtable_name = substr($arrtable_name,1);
          $wherestr .= " and at.tablename in ($arrtable_name) ";

         }


	if($this->uid > 0)
	$wherestr .= " and at.uid = $this->uid ";
	if($this->activitytype != "")
	$wherestr .= " and at.category = '$this->activitytype' ";

	$datefrom=$this->datefrom;
	$dateto=$this->dateto;

	if($datefrom=="")
	$datefrom = "0000-00-00";
	if($dateto=="")
	$dateto = "9999-12-31";

	$wherestr .= " and ( date(at.updated) between '$datefrom' and '$dateto' ) ";

        $sql="SELECT at.updated,u.uname,at.eventype,at.category,at.changedesc from sim_audit at
		inner join sim_users u on u.uid=at.uid 
		$wherestr 
		order by at.updated";

echo <<< EOF
	<br>
	<form name="frmListSearch" method="POST">
	<table border=1>
	<input type="hidden" name="action" value="">
	<tr>
		<td class="tdListRightTitle" style="text-align:center;" >No</td>
		<td class="tdListRightTitle" style="text-align:center;">Date/Time</td>
		<td class="tdListRightTitle" style="text-align:center;">User</td>
		<td class="tdListRightTitle" style="text-align:center;">Category</td>
		<td class="tdListRightTitle" style="text-align:center;">Event Type</td>
		<td class="tdListRightTitle"  style="text-align:center;">Activity</td>
	</tr>
	<tr align="left" colspan="6"><input type="button" value="Delete All Log" onclick="deleteLog();"></td>
	</tr>
EOF;

$query=$xoopsDB->query($sql);
$i=0;
while ($row=$xoopsDB->fetchArray($query)){
$i++;
$updated=$row['updated'];
$uname=$row['uname'];

switch($row['category']){
case "I":
$category="Insert";
break;
case "U":
$category="Update";
break;
case "E":
$category="Delete";
break;

}
if($row['eventype']=='S')
$eventype='Success';
else
$eventype='Failed';


$sqlstr=$row['changedesc'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

echo <<< EOF

		<tr>
		<td class="$rowtype">$i</td>
		<td class="$rowtype">$updated</td>
		<td class="$rowtype">$uname</td>
		<td class="$rowtype">$category</td>
		<td class="$rowtype">$eventype</td>
		<td class="$rowtype">$sqlstr</td>
		</tr>
EOF;
}

echo <<< EOF
	<input type="hidden" name="wherestring" value="$wherestr">
EOF;
	echo "<input type='hidden' name='rowcount' value='$i'>";
	echo "</table></form>";
EOF;

  }

  public function deleteAllLog($wherestr){
	global $xoopsDB;

	if($wherestr != "")
	$sql = "delete from sim_audittrial $wherestr ";

	$this->log->showLog(4,"Delete All Log :$sql");

	$rs=$xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(3,'Delete All Success:');
		return true;
	}else{
		$this->log->showLog(3,'Delete All Failes:');
		return true;
	}
  }

public function getSelectModule($id,$showNull='Y'){

	$sql="SELECT mid,name from sim_modules where (isactive=1 or mid='$id') and mid>0 and weight > 0 order by name";

	$mselectctl="<SELECT name='mid' onchange='getWindow();' >";
	if ($showNull=='Y')
		$mselectctl=$mselectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';

	$query=$this->xoopsDB->query($sql);
	$mselected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$mid=$row['mid'];
		$name=$row['name'];

		if($id==$mid)
			$mselected='SELECTED="SELECTED"';
		else
			$mselected="";
		$mselectctl=$mselectctl  . "<OPTION value='$mid' $mselected>$name</OPTION>";

	}

	$mselectctl=$mselectctl . "</SELECT>";

	return $mselectctl;
}

public function getSelectWindows($wname,$mid,$showNull='Y'){

  
         $sql="SELECT window_id,window_name,table_name from sim_window where isactive='1' and mid='$mid' and parentwindows_id>0 and table_name!='' order by window_name";

	$selectctl="<SELECT id='window_name' name='window_name' >";
	if ($showNull=='Y')
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null</OPTION>';

	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$table_name=$row['table_name'];
		$window_name=$row['window_name'];

		if($wname==$table_name)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$table_name' $selected>$window_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

 	return $selectctl;
 }
} // end of ClassActivitysummary
?>

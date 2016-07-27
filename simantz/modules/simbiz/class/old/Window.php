<?php


class Window
{


  public $window_id;
  public $window_name;
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
  private $tablewindow;
  private $log;


//constructor
   public function Window(){
	global $xoopsDB, $log, $tablewindow;
  	$this->xoopsDB=$xoopsDB;
	$this->tablewindow= $tablewindow;
	$this->log = $log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int window_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $window_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	$this->log->showLog(3, "File:" . __FILE__ . ", line: " . __LINE__ . "=:Showing Windows window_id: $this->window_id, $this->window_name");
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
		$header="New Window";
		$action="create";
	 	
		if($window_id==0){
			$this->window_name="";
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
		$savectrl="<input name='window_id' value='$this->window_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablewindow' type='hidden'>".
		"<input name='id' value='$this->window_id' type='hidden'>".
		"<input name='idname' value='window_id' type='hidden'>".
		"<input name='title' value='Window' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='Y')
			$checked="CHECKED";
		else
			$checked="";

	
		$header="Edit Window";
		
		if($this->allowDelete($this->window_id) && $this->window_id>0)
		$deletectrl="<FORM action='window.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this window?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->window_id' name='window_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='window.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Window Master</span></big></big></big></div><br>
	<A href='index.php'>Back To This Module Administration Menu</A>
<table style="width:140px;"><tbody><td>$addnewctrl</td><td><form onsubmit="return validateWindow()" method="post"
 action="window.php" name="frmWindow"><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="3" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Window Name $mandatorysign</td>
        <td class="even" colspan="2"><input maxlength="50" size="50"
 name="window_name" value="$this->window_name"><A>     </A>Active <input type="checkbox" $checked name="isactive"></td>
      </tr>
      <tr>
        <td class="head">File Name $mandatorysign</td>
        <td class="odd" colspan="2"><input maxlength="50" size="50"
 name="filename" value="$this->filename"></td>
      </tr>
      <tr>
        <td class="head">Window Type</td>
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
   * Update existing window record
   *
   * @return bool
   * @access public
   */
  public function updateWindow( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tablewindow SET ".
	"functiontype='$this->functiontype',filename='$this->filename',window_name='$this->window_name',".
	"updated='$timestamp',updatedby=$this->updatedby,isactive='$this->isactive',seqno=$this->seqno ".
	"WHERE window_id='$this->window_id'";
	
	$this->log->showLog(3, "__FILE__, __LINE__ =:Update window_id: $this->window_id, $this->window_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update window failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update window successfully.");
		return true;
	}
  } // end of member function updateWindow

  /**
   * Save new window into database
   *
   * @return bool
   * @access public
   */
  public function insertWindow( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new window $this->window_name");
 	$sql="INSERT INTO $this->tablewindow (functiontype,window_name".
	",isactive, created,createdby,updated,updatedby,filename,seqno) values(".
	"'$this->functiontype','$this->window_name','$this->isactive','$timestamp',$this->createdby,'$timestamp',".
	"$this->updatedby,'$this->filename',$this->seqno)";
	$this->log->showLog(4,"Before insert window SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert window code $window_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new window $window_name successfully"); 
		return true;
	}
  } // end of member function insertWindow

  /**
   * Pull data from window table into class
   *
   * @return bool
   * @access public
   */
  public function fetchWindow( $window_id) {
    
	$this->log->showLog(3,"Fetching window detail into class Window.php.<br>");
		
	$sql="SELECT window_id,window_name,functiontype,filename,isactive,seqno from $this->tablewindow ". 
			"where window_id=$window_id";
	
	$this->log->showLog(4,"ProductWindow->fetchWindow, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->filename=$row["filename"];
		$this->window_name=$row["window_name"];
		$this->functiontype= $row['functiontype'];
		$this->seqno= $row['seqno'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"Window->fetchWindow,database fetch into class successfully");
	$this->log->showLog(4,"window_name:$this->window_name");
	$this->log->showLog(4,"functiontype:$this->functiontype");
	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Window->fetchWindow,failed to fetch data into databases.");	
	}
  } // end of member function fetchWindow

  /**
   * Delete particular window id
   *
   * @param int window_id 
   * @return bool
   * @access public
   */
  public function deleteWindow( $window_id ) {
    	$this->log->showLog(2,"Warning: Performing delete window id : $window_id !");
	$sql="DELETE FROM $this->tablewindow where window_id=$window_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: window ($window_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"window ($window_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteWindow

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllWindow( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running ProductWindow->getSQLStr_AllWindow: $sql");
    $sql="SELECT window_name,filename,functiontype,window_id,isactive,seqno FROM $this->tablewindow " .
	" $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showwindowtable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllWindow

 public function showWindowTable($wherestring,$orderbystring){
	
	$this->log->showLog(3,"Showing Window Table");
	$sql=$this->getSQLStr_AllWindow($wherestring,$orderbystring);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>

				<th style="text-align:center;">Window Name</th>
				<th style="text-align:center;">File Name</th>
				<th style="text-align:center;">Type</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Seq No</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$window_id=$row['window_id'];
		$window_name=$row['window_name'];
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
			<td class="$rowtype" style="text-align:center;">$window_name</td>
			<td class="$rowtype" style="text-align:center;">$filename</td>
			<td class="$rowtype" style="text-align:center;">$functiontype</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">$seqno</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="window.php" method="POST">
				<input type="image" src="../images/edit.gif" name="submit" title='Edit this window'>
				<input type="hidden" value="$window_id" name="window_id">
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
  public function getLatestWindowID() {
	$sql="SELECT MAX(window_id) as window_id from $this->tablewindow;";
	$this->log->showLog(3,'Checking latest created window_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created window_id:' . $row['window_id']);
		return $row['window_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {
	$sql="SELECT MAX(seqno) + 10 as seqno from $this->tablewindow;";
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
  

  public function allowDelete($id){
	/*$sql="SELECT count(window_id) as rowcount from $this->tablestudent where window_id=$id";
	$this->log->showLog(3,"Accessing ProductWindow->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this window, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this window, record deletable");
		return true;
		}*/
		return true;
	}
} // end of ClassWindow
?>

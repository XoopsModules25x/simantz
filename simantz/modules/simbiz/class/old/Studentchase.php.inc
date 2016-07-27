<?php


class Studentchase
{

  public $studentchase_id;
  public $studentchase_name;
  public $studentchase_code;
  public $effectivedateto;
  public $nextfollowup_date;
  public $parentstudentchase_id;
  public $studentchase_datetime;
  public $description;
  public $lastfollowup_date;
  public $defaultuseraccount_id;
  public $organization_id;
  public $daycount;
  public $iscomplete;
  public $currency_code;

  public $isAdmin;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $studentchasectrl;
  public $productctrl;
  public $studentchaseline_id;
  public $studentchaseline_type;
  public $updatesql;
  public $showCalenderFrom;
  public $showCalenderTo;
  private $xoopsDB;


  private $tablestudentchase;
  private $tablestudentchaseline;
  private $tableproduct;
  private $defaultorganization_id;
  private $tablebpartner;
  private $tableaddress;
  private $log;


//constructor
   public function studentchase(){
	global $xoopsDB,$log,$tablestudentchase,$tablestudentchaseline,$tableproduct,$defaultorganization_id,$tableaddress,
            $tableusers;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablestudentchase=$tablestudentchase;
    $this->tablestudentchaseline=$tablestudentchaseline;
    $this->tableaddress=$tableaddress;
	$this->tableproduct=$tableproduct;
    $this->tableusers=$tableusers;
	$this->log=$log;
    $this->defaultorganization_id=$defaultorganization_id;

   }

public function viewstudentchaseData($studentchase_id){
        global $isreadonlywindows;
        if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$tablestudentchase' type='hidden'>".
		"<input name='id' value='$this->studentchase_id' type='hidden'>".
		"<input name='idname' value='studentchase_id' type='hidden'>".
		"<input name='title' value='studentchase' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";


		//force iscomplete checkbox been checked if the value in db is 'Y'
		if ($this->iscomplete==1)
			$checked="CHECKED";
		else
			$checked="";


        if($this->allowEdit($this->studentchase_id))
		$editctrl="<FORM action='studentchase.php' method='POST'>
        <input type='submit' value='Edit' name='btnEdit'>".
		"<input type='hidden' value='$this->studentchase_id' name='studentchase_id'>".
		"<input type='hidden' value='edit' name='action'></form>";

    $actionform = 'action="studentchase.php"';
    $this->styleviewwindows = "";
    if($isreadonlywindows==1){
    $addnewctrl = "";
    $deletectrl = "";
    $savectrl = "";
    $actionform = 'onsubmit="return false"';
    $editctrl="";
    $this->styleviewwindows = "style='display:none'";
    }

echo <<< EOF

<table style="width:140px;"><tbody><td>
        <Form action='studentchase.php' method='POST'><input name='btnNew' value='New' type='submit'></form>
</td><td nowrap>
<form method="post" action="studentchase.php" name="frmstudentchase">
<input name="reset" value="Reset" type="reset">
<input name="btnSearch" value="Search" type="button" onclick="gotoAction('search');">
</td></tbody></table>


  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" colspan="3">$this->orgctrl
	&nbsp;Complete <input type="checkbox" $checked name="iscomplete">
	</td>
      </tr>
      <tr>
	<td class="head">Call History No $mandatorysign</td>
	<td class="even" >$this->studentchase_code</td>
	<td class="head">Call History Title $mandatorysign</td>
	<td class="even" >$this->studentchase_name</td>
      </tr>
      <tr>
	<td class="head">Call From</td>
	<td class="even" >$this->callby</td>
	<td class="head">Tel</td>
	<td class="even" >$this->tel</td>
      </tr>
    <tr>
	<td class="head">Call Date</td>
	<td class="even" >$this->studentchase_datetime</td>
	<td class="head">Last Follow Up Date</td>
	<td class="even" >$this->lastfollowup_date</td>

      </tr>
      <tr>
        <td class="head"></td>
    	<td class="even">$this->uname</td>
        <td class="head">Next Follow Up Date</td>
    	<td class="even">$this->nextfollowup_date</td>
      </tr>
   <tr>
        <td class="head">Description</td>
    	<td class="even" colspan='3'>$this->description</td>

      </tr>
    </tbody>
  </table>
<table style="width:150px;"><tbody>
        <td>$editctrl<td>$deletectrl</td><td>$recordctrl</td></tbody></table>
  <br>

EOF;
}

  public function getInputForm( $type,  $studentchase_id,$token  ) {
        global $isreadonlywindows;
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";

	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Student Chase";
		$action="create";
                $this->studentchase_code = getNewCode($this->xoopsDB,"studentchase_code",$this->tablestudentchase,"");
		if($studentchase_id==0 || $studentchase_id==""){
			$this->studentchase_name="";
			$this->iscomplete="";
			$this->nextfollowup_date="0000-00-00";
                        $this->lastfollowup_date="0000-00-00";
			$this->studentchase_datetime=date("Y-m-d H:i:s", time()) ;
		}
		$savectrl="<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";
		$checked="";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";



	}
	else
	{

		$action="update";
		$savectrl="<input name='studentchase_id' value='$this->studentchase_id' type='hidden'>".
			 "<input style='height: 40px;' name='btnSave' value='Save' type='submit'>";

 	if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablestudentchase' type='hidden'>".
		"<input name='id' value='$this->studentchase_id' type='hidden'>".
		"<input name='idname' value='studentchase_id' type='hidden'>".
		"<input name='title' value='studentchase' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";


		//force iscomplete checkbox been checked if the value in db is 'Y'
		if ($this->iscomplete==1)
			$checked="CHECKED";
		else
			$checked="";


		$header="Edit studentchase";

		if($this->allowDelete($this->studentchase_id))
		$deletectrl="<FORM action='studentchase.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this studentchase?"'.")'><input type='submit' value='Delete' name='btnDelete'>".
		"<input type='hidden' value='$this->studentchase_id' name='studentchase_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='studentchase.php' method='POST'><input name='btnNew' value='New' type='submit'></form>";

		if($this->effectivedateto == "P")//Standard
		$selectedP = "selected = 'selected'";
		else if($this->effectivedateto == "C")//Other charges
		$selectedC = "selected = 'selected'";

	}

    $actionform = 'action="studentchase.php"';
    $this->styleviewwindows = "";
    if($isreadonlywindows==1){
    $addnewctrl = "";
    $deletectrl = "";
    $savectrl = "";
    $actionform = 'onsubmit="return false"';
    $this->styleviewwindows = "style='display:none'";
    }
    
    echo <<< EOF

<table style="width:140px;"><tbody><td>$addnewctrl</td><td nowrap>
    <form onsubmit="return validatestudentchase()" method="post"
         action="studentchase.php" name="frmstudentchase">
<input name="reset" value="Reset" type="reset">
<input name="btnSearch" value="Search" type="button" onclick="gotoAction('search');">
</td></tbody></table>

  <table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" colspan="3">$this->orgctrl
	&nbsp;Complete <input type="checkbox" $checked name="iscomplete">
	</td>
      </tr>
<input type="hidden" name="uid" value="$this->uid">
      <tr>
	<td class="head">Call History No $mandatorysign</td>
	<td class="even" ><input maxlength="10" size="9" name="studentchase_code" value="$this->studentchase_code"></td>
	<td class="head">Call History Title $mandatorysign</td>
	<td class="even" ><input maxlength="30" size="30" name="studentchase_name" value="$this->studentchase_name"></td>
      </tr>
      <tr>
	<td class="head">Call From</td>
	<td class="even" ><input name="callby" value="$this->callby"></td>
	<td class="head">Tel</td>
	<td class="even" ><input name="tel" value="$this->tel"></td>
      </tr>
    <tr>
	<td class="head">Call Date</td>
	<td class="even" ><input name='studentchase_datetime' value='$this->studentchase_datetime'></td>
	<td class="head">Last Follow Up Date</td>
	<td class="even" ><input name='lastfollowup_date' value='$this->lastfollowup_date' size='8'></td>

      </tr>
      <tr>
        <td class="head">Attention To</td>
    	<td class="even">$this->usersctrl</td>
        <td class="head">Next Follow Up Date</td>
    	<td class="even"><input name='nextfollowup_date' value='$this->nextfollowup_date' size='8'></td>
      </tr>
   <tr>
        <td class="head">Description</td>
    	<td class="even" colspan='3'><textarea name='description' rows='6' cols='60'>$this->description</textarea></td>

      </tr>
    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$savectrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>
        <a href="studentchase.php?action=view&studentchase_id=$this->studentchase_id">
            <input type='button' value='Cancel'></a>
    </td><td>$deletectrl</td>
<td>$recordctrl</td></tbody></table>
  <br>



EOF;
  } // end of member function getInputForm

  /**
   * Update existing studentchase record
   *
   * @return bool
   * @access public
   */
  public function updatestudentchase( ) {

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql=	"UPDATE $this->tablestudentchase SET
    	studentchase_id=$this->studentchase_id,
        iscomplete=$this->iscomplete,
        updated='$this->updated',
    	updatedby=$this->updatedby,
    	studentchase_code='$this->studentchase_code',
    	studentchase_name='$this->studentchase_name',
    	description='$this->description',
    	nextfollowup_date='$this->nextfollowup_date',
    	studentchase_datetime='$this->studentchase_datetime',
    	lastfollowup_date='$this->lastfollowup_date',
        uid=$this->uid,
        callby='$this->callby',
        tel='$this->tel'
	WHERE studentchase_id=$this->studentchase_id";

	$this->updatesql=$sql;
	$this->log->showLog(3, "Update studentchase_id: $this->studentchase_id, $this->studentchase_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
 //     exit(0);
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update studentchase failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update studentchase successfully.");
		return true;
	}
  } // end of member function updatestudentchase

 public function updatestudentchaseLine( ) {

 	$timestamp= date("y/m/d H:i:s", time()) ;
 	 $sql="UPDATE $this->tablestudentchaseline SET
		studentchase_id=$this->studentchase_id,
		updated='$this->updated',
		updatedby=$this->updatedby,
                linetitle='$this->linetitle',
                linedesc='$this->linedesc',
                line_datetime='$this->line_datetime'
		WHERE studentchaseline_id=$this->studentchaseline_id";
	$this->updatesql=$sql;
	$this->log->showLog(3, "Update studentchaseline_id: $this->studentchaseline_id");
	$this->log->showLog(4, "Before execute SQL statement:$sql");

	$rs=$this->xoopsDB->query($sql);
   // exit(0);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update studentchaseline failed:".mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3, "Update studentchaseline successfully.");
		return true;
	}
  } // end of member function updatestudentchase

  /**
   * Save new studentchase into database
   *
   * @return bool
   * @access public
   */
  public function insertstudentchase( ) {


   	$timestamp= date("y/m/d H:i:s", time()) ;

	$this->log->showLog(3,"Inserting new studentchase $this->studentchase_name");
  $sql="INSERT INTO $this->tablestudentchase
			(
		organization_id,
		iscomplete,
		created,
		createdby,
		updated,
		updatedby,
		studentchase_code,
		studentchase_name,
		description,
		nextfollowup_date,
		studentchase_datetime,
		lastfollowup_date,
                uid,
                callby,
                tel
        )

			values(
		$this->organization_id,
		$this->iscomplete,
		'$this->created',
		$this->createdby,
		'$this->updated',
		$this->updatedby,
		'$this->studentchase_code',
		'$this->studentchase_name',
		'$this->description',
		'$this->nextfollowup_date',
		'$this->studentchase_datetime',
		'$this->lastfollowup_date',
                $this->uid,
                '$this->callby',
                '$this->tel'
        )";
    $this->updatesql=$sql;
    
	$this->log->showLog(4,"Before insert studentchase SQL:$sql");
	$rs=$this->xoopsDB->query($sql);

	if (!$rs){
		$this->log->showLog(1,"Failed to insert studentchase code $studentchase_name:" . mysql_error() . ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new studentchase $studentchase_name successfully");
		return true;
	}
  } // end of member function insertstudentchase


 public function insertstudentchaseLine( ) {


   	$timestamp= date("y/m/d H:i:s", time()) ;

	$this->log->showLog(3,"Inserting new studentchaseline $this->studentchase_name");
 	$sql="INSERT INTO $this->tablestudentchaseline
			(
		studentchase_id,

		createdby,
		created,
		updated,
		updatedby,
		linetitle,
		linedesc,
		line_datetime
        )

			values(
		$this->studentchase_id,
		$this->createdby,
		'$this->created',
		'$this->updated',
		$this->updatedby,
                '$this->linetitle',
                '$this->linedesc',
                 '$this->line_datetime'
)";
    $this->updatesql=$sql;
	$this->log->showLog(4,"Before insert studentchaseline SQL:$sql");
	$rs=$this->xoopsDB->query($sql);

	if (!$rs){
		$this->log->showLog(1,"Failed to insert studentchaseline:" . mysql_error() . ":$sql");
        exit(0);
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new studentchaseline successfully");
		return true;
	}
  }
  /**
   * Pull data from studentchase table into class
   *
   * @return bool
   * @access public
   */
  public function fetchstudentchase( $studentchase_id) {


	$this->log->showLog(3,"Fetching studentchase detail into class studentchase.php. $studentchase_id<br>");

	$sql="SELECT
        wh.studentchase_id,
		wh.organization_id,
		wh.iscomplete,
		wh.created,
		wh.createdby,
		wh.updated,
		wh.updatedby,
		wh.studentchase_code,
		wh.studentchase_name,
		wh.description,
		wh.nextfollowup_date,
		wh.studentchase_datetime,
		wh.lastfollowup_date,
                wh.uid,
                wh.callby,
                wh.tel,
                u.uname
            from $this->tablestudentchase wh
            INNER JOIN $this->tableusers u on wh.uid=u.uid
            where wh.studentchase_id=$studentchase_id and
            wh.organization_id=$this->defaultorganization_id";

	$this->log->showLog(4,"Productstudentchase->fetchstudentchase, before execute SQL: $sql ");

	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query)){
		$this->studentchase_id=$row['studentchase_id'];
		$this->organization_id=$row['organization_id'];
		$this->iscomplete=$row['iscomplete'];
		$this->created=$row['created'];
		$this->createdby=$row['createdby'];
		$this->updated=$row['updated'];
		$this->updatedby=$row['updatedby'];
		$this->studentchase_code=$row['studentchase_code'];
		$this->studentchase_name=$row['studentchase_name'];
		$this->description=$row['description'];
		$this->nextfollowup_date=$row['nextfollowup_date'];
		$this->studentchase_datetime=$row['studentchase_datetime'];
		$this->lastfollowup_date=$row['lastfollowup_date'];
         	$this->tel=$row['tel'];
                $this->uname=$row['uname'];
                $this->uid=$row['uid'];
                $this->callby=$row['callby'];
        

   	$this->log->showLog(4,"studentchase->fetchstudentchase(name:$this->studentchase_name),
        database fetch into class successfully");

		return true;
	}
    //exit(0);
	$this->log->showLog(4,"studentchase->fetchstudentchase,failed to fetch data into databases:" . mysql_error(). ":$sql");
	return false;


  } // end of member function fetchstudentchase

   public function fetchstudentchaseLine( $studentchaseline_id) {


	$this->log->showLog(3,"Fetching studentchase detail into class studentchase.php. $studentchase_id<br>");

	$sql="SELECT l.* FROM $this->tablestudentchaseline l
            where l.studentchaseline_id=$studentchaseline_id ";

	$this->log->showLog(4,"Productstudentchase->fetchstudentchase, before execute SQL: $sql ");

	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query)){

		
		$this->createdby=$row['createdby'];
		$this->created=$row['created'];
		$this->updated=$row['updated'];
		$this->updatedby=$row['updatedby'];
                $this->studentchase_id=$row['studentchase_id'];
		$this->linedesc=$row['linedesc'];
		$this->linetitle=$row['linetitle'];
		$this->line_datetime=$row['line_datetime'];


   	$this->log->showLog(4,"studentchase->fetchstudentchaseLine
        database fetch into class successfully");

		return true;
	}

	$this->log->showLog(4,"studentchase->fetchstudentchaseline,failed to fetch data into databases:" . mysql_error(). ":$sql");
	return false;


  }


  public function deletestudentchase( $studentchase_id ) {
    	$this->log->showLog(2,"Warning: Performing delete studentchase id : $studentchase_id !");
	$sql="DELETE FROM $this->tablestudentchase where studentchase_id=$studentchase_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->updatesql=$sql;
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: studentchase ($studentchase_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"studentchase ($studentchase_id) removed from database successfully!");
		return true;

	}
  } // end of member function deletestudentchase
 public function deletestudentchaseLine( $studentchaseline_id ) {
    	$this->log->showLog(2,"Warning: Performing delete studentchaseline id : $studentchaseline_id !");
	$sql="DELETE FROM $this->tablestudentchaseline where studentchaseline_id=$studentchaseline_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->updatesql=$sql;
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: studentchase ($studentchase_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"studentchase ($studentchase_id) removed from database successfully!");
		return true;

	}
  } // end of member function deletestudentchase

  /**
   * Return select sql statement.
   *
   * @param string wherestring
   * @param string orderbystring
   * @param int startlimitno
   * @return string
   * @access public
   */
  public function getSQLStr_Allstudentchase( $wherestring,  $orderbystring) {
  $this->log->showLog(4,"Running Productstudentchase->getSQLStr_Allstudentchase: $sql");

   $sql="SELECT wh.*,u.uname,u1.uname as receivedby
        FROM $this->tablestudentchase wh
        INNER JOIN $this->tableusers u on wh.uid=u.uid
        INNER JOIN $this->tableusers u1 on wh.createdby=u1.uid

    $wherestring $orderbystring";
    $this->log->showLog(4,"Generate showstudentchasetable with sql:$sql");

  return $sql;
  } // end of member function getSQLStr_Allstudentchase

 public function showstudentchaseTable($wherestring,$orderbystring){

	$this->log->showLog(3,"Showing Studentchase Table");
	$sql=$this->getSQLStr_Allstudentchase($wherestring,$orderbystring);

	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='0' cellspacing='3'>
  		<tbody>
    			<tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Call In Time</th>
				<th style="text-align:center;">Next Follow Up</th>
				<th style="text-align:center;">Last Follow Up</th>
				<th style="text-align:center;">Studentchase No</th>
                                <th style="text-align:center;">Studentchase Name</th>
				<th style="text-align:center;">Call By</th>
				<th style="text-align:center;">Tel</th>
				<th style="text-align:center;">Attention To</th>
				<th style="text-align:center;">Received By</th>
				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Preview</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;

		$organization_id=$row['organization_id'];
		$iscomplete=$row['iscomplete'];
		$created=$row['created'];
		$createdby=$row['createdby'];
		$updated=$row['updated'];
		$updatedby=$row['updatedby'];
        $studentchase_id=$row['studentchase_id'];
		$studentchase_code=$row['studentchase_code'];
		$studentchase_name=$row['studentchase_name'];
		$description=$row['description'];
		$nextfollowup_date=$row['nextfollowup_date'];
		$studentchase_datetime=$row['studentchase_datetime'];
		$lastfollowup_date=$row['lastfollowup_date'];
                $uname=$row['uname'];
                $receivedby=$row['receivedby'];
                $tel=$row['tel'];
                $callby=$row['callby'];
		if($iscomplete==0)
		{$iscomplete='N';
		$iscomplete="<b style='color:red;'>$iscomplete</b>";
		}
		else
		$iscomplete='Y';

       
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";


		echo <<< EOF

		<tr>
				<td style="text-align:center;">$i</td>
				<td style="text-align:center;">$studentchase_datetime</td>
				<td style="text-align:center;">$nextfollowup_date</td>
				<td style="text-align:center;">$lastfollowup_date</td>
				<td style="text-align:center;">$studentchase_code</td>
                                <td style="text-align:center;">$studentchase_name</td>
				<td style="text-align:center;">$callby</td>
				<td style="text-align:center;">$tel</td>
				<td style="text-align:center;">$uname</td>
				<td style="text-align:center;">$receivedby</td>
				<td style="text-align:center;">$iscomplete</td>
				<td style="text-align:center;">
                                    <a href='studentchase.php?action=view&studentchase_id=$studentchase_id'>
                                        <image src='images/edit.gif' title='View'>
                                </a></td>
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
  public function getLateststudentchaseID() {
	$sql="SELECT MAX(studentchase_id) as studentchase_id from $this->tablestudentchase
                where createdby=$this->createdby;";
	$this->log->showLog(3,'Checking latest created studentchase_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created studentchase_id:' . $row['studentchase_id']);
		return $row['studentchase_id'];
	}
	return -1;

  } // end

  public function getLateststudentchaseLineID() {
	$sql="SELECT MAX(studentchase_id) as studentchaseline_id from $tablestudentchaseline;";
	$this->log->showLog(3,'Checking latest created studentchase_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created studentchase_id:' . $row['studentchaseline_id']);
		return $row['studentchaseline_id'];
	}
	return -1;

  }

  public function getNextSeqNo() {

	$sql="SELECT MAX(nextfollowup_date) + 10 as nextfollowup_date from $tablestudentchase
        where organization_id=$defaultorganization_id;";
	$this->log->showLog(3,'Checking next nextfollowup_date');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found next nextfollowup_date:' . $row['nextfollowup_date']);
		return  $row['nextfollowup_date'];
	}

	return 10;

  } // end

 public function allowDelete($studentchase_id){
	$sql="SELECT count(studentchase_id) as rowcount from $tableproduct where studentchase_id=$studentchase_id";
	$this->log->showLog(3,"Accessing Productstudentchase->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	while($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this product, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this product, record deletable.");
		return true;
		}
        return true;
	}


  public function showSearchForm($wherestr){


	if($issearch != "Y"){
	$studentchase_code = "";
	$studentchase_name = "";
	$effectivedateto = "";
	$iscomplete = "null";
	$studentchase_datetime = 0;
        $nextfollowup_date = "";
	}


	if($effectivedateto == "P")
	$selectedP = "selected = 'selected'";
	else if($effectivedateto == "T")
	$selectedT = "selected = 'selected'";
	else if($effectivedateto == "C")
	$selectedC = "selected = 'selected'";
	else if($effectivedateto == "O")
	$selectedO = "selected = 'selected'";
	else
	$selectedNull = "selected = 'selected'";

	//iscomplete
	if($iscomplete == "1")
	$selectactiveY = "selected = 'selected'";
	else if($iscomplete == "0")
	$selectactiveN = "selected = 'selected'";
	else
	$selectactiveL = "selected = 'selected'";

	//echo $iscomplete;

echo <<< EOF
	<form name="frmstudentchase" action="studentchase.php" method="POST">
	</form>

	<form name="frmSearch" action="studentchase.php" method="POST">

	<table>
	<tr>
	<td nowrap><input value="Reset" type="reset">
	<input value="New" type="button" onclick="gotoAction('');"></td>
	</tr>
	</table>

	<table border="0">
	<input name="issearch" value="Y" type="hidden">
	<input name="action" value="search" type="hidden">
	<tr><th colspan="4">Criterial</th></tr>

	<tr>
	<td class="head">Studentchase Code</td>
	<td class="even"><input name="studentchase_code" value="$studentchase_code"></td>
	<td class="head">Studentchase Name </td>
	<td class="even"><input name="studentchase_name" value="$studentchase_name"></td>
	</tr>

	<tr>
	<td class="head">Studentchase Type</td>
	<td class="even" >
	<select name="effectivedateto">
	<option value="" $selectedNull>Null</option>
	<option value="P" $selectedP>Standard Product</option>
	<option value="C" $selectedC>Other Charges</option>
	</select>
        <td class="head">Next Follow Up Date</td>
        <td class="even"><input type='text' name='nextfollowup_date' id='nextfollowup_date' value='$nextfollowup_date'>
        <input type='button' value='Date' name='btnDate' onclick="$this->followUpDate"></td></td>

    </tr>

	<tr>
	<td class="head">Is Active</td>
	<td class="even" colspan="3">
	<select name="iscomplete">
	<option value="null" $selectactiveL>Null</option>
	<option value=1 $selectactiveY>Yes</option>
	<option value=0 $selectactiveN>No</option>
	</select>
	</td>
	</tr>

	<tr>
	<th colspan="4"><input type="submit" aonclick="gotoAction('search');" value="Search" ></th>
	</tr>

	</table>
	</form>
	<br>
EOF;
  }
   public function allowEdit($studentchase_id){
       return true;
   }
	public function getWhereStr(){

	$wherestr .= "";
      

	if($this->studentchase_code != "")
	$wherestr .= " and studentchase_code like '$this->studentchase_code' ";
	if($$this->studentchase_name != "")
	 $wherestr .= " and studentchase_name like '$this->studentchase_name' ";
	if($this->effectivedateto != "")
	 $wherestr .= " and effectivedateto like '$this->effectivedateto' ";
	if($this->studentchase_datetime > 0)
	 $wherestr .= " and studentchase_datetime = $this->studentchase_datetime ";
	if($this->iscomplete == "0" || $this->iscomplete == "1")
	 $wherestr .= " and iscomplete = $this->iscomplete ";
        if($this->nextfollowup_date != "")
         $wherestr .= " and nextfollowup_date = $this->nextfollowup_date ";

	return $wherestr;

	}

  public function showstudentchaseLineTable($studentchase_id,$token){
    global $isreadonlywindows;

    $this->styleviewwindows = "";
    if($isreadonlywindows==1){
    $addnewctrl = "";
    $deletectrl = "";
    $savectrl = "";
    $actionform = 'onsubmit="return false"';
    $editctrl="";
    $this->styleviewwindows = "style='display:none'";
    }
    
    $wherestring="studentchase_id=$studentchase_id";


    echo <<< EOF
    <script type='text/javascript'>

        function showstudentchaseLineForm(){
         var trAddForm= document.getElementById("trAddForm");
         var btnShowAddstudentchaseLine= document.getElementById("btnShowAddstudentchaseLine");

         if(trAddForm.style.display=='none'){
             trAddForm.style.display='';
             btnShowAddstudentchaseLine.value="Hide Form";
         }
         else{
            trAddForm.style.display='none';
            btnShowAddstudentchaseLine.value="Display Form";
            }

    }

    </script>
    <table><tbody><tr $this->styleviewwindows><th colspan='10' style='text-align:center'>
            Studentchase Detail
            <input id='btnShowAddstudentchaseLine' name='btnShowAddstudentchaseLine'
                value='Display Form' onclick='showstudentchaseLineForm()' type='button'>
        </th></tr>
    <tr id='trAddForm' style="display:none"><td colspan='10' class='even'>
EOF;
        $this->studentchasectrl="<input type='hidden' name='studentchase_id'
            value='$this->studentchase_id'>";
        $this->getstudentchaseLineForm("new",$studentchase_id,$token);
    echo <<< EOF
    </td></tr>
    <tr>
        <th>No</th>
        <th>Date Time</th>
        <th>Title</th>
        <th>Description</th>
        <th>Operation</th>

    </tr>

EOF;

      $sql="SELECT * FROM $this->tablestudentchaseline
            WHERE $wherestring order by line_datetime DESC";
      $query=$this->xoopsDB->query($sql);
      $i=0;
      while($row=$this->xoopsDB->fetchArray($query)){
          $i++;
  		$studentchaseline_id=$row['studentchaseline_id'];
		$studentchase_id=$row['studentchase_id'];
		
		$createdby=$row['createdby'];
		$created=$row['created'];
		$updated=$row['updated'];
		$updatedby=$row['updatedby'];
                $linedesc=$row['linedesc'];
                $linetitle=$row['linetitle'];
                $line_datetime=$row['line_datetime'];


          if($rowtype=='odd')
          $rowtype='even';
          else
          $rowtype='odd';
          if($iscomplete==1)
          $iscomplete='Y';
          else
          $iscomplete="<B style='color:red'>N</b>";
          echo <<< EOF
    <tr>
        <td class='$rowtype'>$i</td>
          <td class='$rowtype'>$line_datetime</td>
        <td class='$rowtype'>$linetitle</td>
        <td class='$rowtype'>$linedesc</td>
        <td class='$rowtype'>
            <A href='studentchase.php?action=editstudentchaseline&studentchaseline_id=$studentchaseline_id&studentchase_id=$studentchase_id'>
            <image src='images/edit.gif' title='Edit'></a></td>
    </tr>
EOF;

      }
      echo "</tbody></table>";
  }

 public function getstudentchaseLineForm($formtype="new",$studentchaseline_id,$token){
     $productctrl="";
     $studentchasectrl="";
     global $ctrl,$isreadonlywindows;
     if($formtype=='new'){
            $header="New StudentchaseLine";
   
          $studentchaseline_id=0;
          $this->line_datetime=date("Y-m-d H:i:s",time());
          $action='insertline';
          $savectrl="<input name='submit' value='Save' type='submit'>";
          $checked="checked";
 }
else{
      $header="Edit StudentchaseLine";
        $action='updateline';
        $deletectrl="<input name='submit' value='Delete' type='submit'
                    onclick=\"action.value='deleteline'\">";
         $savectrl="<input name='submit' value='Save' type='submit'
                    onclick=\"action.value='updateline'\">";
         if($this->iscomplete==1)
            $checked="checked";
         else
            $checked="";

        if($isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST' >".
		"<input name='tablename' value='$this->tablestudentchaseline' type='hidden'>".
		"<input name='id' value='$studentchaseline_id' type='hidden'>".
		"<input name='idname' value='studentchaseline_id' type='hidden'>".
		"<input name='title' value='studentchaseLine' type='hidden'>".
		"<input name='btnRecord' value='View Record Info' type='submit'>".
		"</form>";
}



    if($isreadonlywindows==1){
    $addnewctrl = "";
    $deletectrl = "";
    $savectrl = "";
    $actionform = 'onsubmit="return false"';
    $editctrl="";
    $this->styleviewwindows = "style='display:none'";
    }
 echo <<< EOF
<form action='studentchase.php' method='POST' onsubmit='return confirm("Confirm submit this change?")' >
    <table><tbody><tr><th colspan='4'>$header</th></tr>

    <tr>$this->studentchasectrl
            <td class='foot'>Title</td>
            <td class='odd'><input name='linetitle' value='$this->linetitle'></td>
            <td class='foot'>Date Time</td>
            <td class='odd'><input name='line_datetime' value='$this->line_datetime'></td>
    </tr>
    <tr>
            <td class='foot'>Description</td>
            <td class='odd' colspan='3'><textarea name='linedesc' cols='70' rows='6'>$this->linedesc</textarea></td>
    </tr>
    <tr>
            <td >$savectrl</td>
            <td ><input name='reset' value='Reset' type='reset'></td>
            <td ><input name='token' value="$token" type='hidden'>$deletectrl</form></td>
            <td >
                <input name='action' value="$action" type='hidden'>
                <input name='studentchaseline_id' value="$this->studentchaseline_id" type='hidden'>$recordctrl
            </td>
    </tr>
</tbody></table>

EOF;
 }



} // end of Classstudentchase
?>

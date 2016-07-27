<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class Worker
{

public	$worker_id;
public	$worker_no;
public	$worker_code;
public	$worker_name;
public	$dateofbirth;
public	$ic_no;
public	$gender;
public	$races_id;
public	$nationality_id;
public	$passport_no;



public	$home_street1;
public	$home_street2;
public	$home_postcode;
public	$home_city;
public	$home_state;
public	$home_country;
public	$email;
public	$home_tel1;
public	$home_tel2;
public	$handphone;
public	$maritalstatus;
public	$family_contactname;
public	$family_contactno;
public	$relationship;
public	$skill;
public	$educationlevel;
public	$bank_name;
public  $workerctrl;
public	$bank_acc;
public	$bankacc_type;
public	$description;
public	$created;
public	$createdby;
public	$updated;
public	$updatedby;
public	$isactive;
public  $removepic;
public	$arrivaldate;
public  $departuredate;
public  $workerstatus;
public  $xoopsDB;
public  $tableprefix;
public  $tableworker;
public $tablenationality;
public $tableraces;
public $showddateofbirthctrl;
public $showarrivaldatectrl;
public $showdeparturedatectrl;
public  $tableworkerworker;
public  $log;

public $racesctrl;
public $nationalityctrl;


//constructor
   public function Worker($xoopsDB, $tableprefix,$log){
  	$this->xoopsDB=$xoopsDB;
	$this->tableprefix=$tableprefix;
	$this->tableworker=$tableprefix."simfworker_worker";
	$this->tableworkercompany=$tableprefix."simfworker_workercompany";
	$this->tableraces=$tableprefix."simfworker_races";
	$this->tablenationality=$tableprefix."simfworker_nationality";

	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type 
   * @param int worker_id 
   * @return 
   * @access public
   */
  public function getInputForm( $type,  $worker_id, $token  ) {

   	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$employmentctrl="";
	$printprofile="";
	$passportctrl="";
	$genderctrl=$this->selectGender($this->gender,'N');
	$maritalctrl=$this->selectMaritalStatus($this->maritalstatus,'N');
	$this->created=0;
	if ($type=="new"){
		$header="New Worker";
		$action="create";
	 	
		if($worker_id==0){
			$this->worker_no="";
			$this->worker_name="";
			$this->worker_code=$this->getNewWorkerCode();
			$this->description="";
			$this->isactive=0;

			$this->dateofbirth='0000-00-00';
			$this->arrivaldate='0000-00-00';
			$this->departuredate='0000-00-00';

		}
		$imagefile="<img src='images/photo/0.jpg' width='250' height='300'>";

		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$defaultchecked="";
		$deletectrl="";

		$statusctrl=$this->workerStatusSelection("Normal");

	}
	else
	{
		
		$action="update";
		$savectrl="<input name='worker_id' value='$this->worker_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Save' type='submit'>";

		$photoctrl="<input type='checkbox' name='removepic'>Remove <br>".
				"<input type='file' name='workerphoto'>";
		$passportctrl="<input type='checkbox' name='removepassport'>Remove <br>".
				"<input type='file' name='passportphoto'>";

		$photoname="images/photo/$this->worker_id.jpg";
		$passportname="images/passport/$this->worker_id.jpg";

		if(file_exists($photoname) )
			$photofile="<img src='images/photo/$this->worker_id.jpg' width='250' height='300'>";
		else
			$photofile="<img src='images/photo/0.jpg' width='250' height='300'>";

		if(file_exists($passportname) )
			$passportfile="<A href='images/passport/$this->worker_id.jpg' target='_blank'>View Passport</A>";
		else
			$passportfile="<B style='color:red'>No Passport Attached(Attach with .jpg)</B>";

				
		
		if($this->isAdmin)
		$recordctrl="";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive=='1')
			$checked="CHECKED";
		else
			$checked="";

		$header="Edit Worker";
		
		if($this->allowDelete($this->worker_id))
		$deletectrl="<FORM action='worker.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this worker?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->worker_id' name='worker_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";

		$statusctrl=$this->workerStatusSelection($this->workerstatus);
		
		$printprofile="<FORM target='_blank' action='rptworkerdetail.php' method='POST'><input type='hidden' value='$this->worker_id' name='worker_id'><input type='submit' value='Print Worker Info' name='submit' style='height: 40px;'><input type='hidden' name='action' value='Print'></FORM>";
		
	}

    echo <<< EOF

<table style="width:140px;"><tbody>
		<td></td>
		<td><form onsubmit="return validateWorker()" method="post"
 action="worker.php" name="frmWorker" enctype="multipart/form-data"><input name="reset" value="Reset" type="reset"></td></tbody></table>
  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
        <tr>
		<td class='head'>*Worker Code/Status</td>
		<td  class='even'>
			<input name='worker_code' value='$this->worker_code'  maxlength="12" size="12" > / $statusctrl</td>
		
		<td class='even' colspan='2' rowspan='14' style='text-align:center'>
			250x300 Photo(Below 100K)<br> 
			$photofile<br>
			$photoctrl<br><br><br>
			$passportfile (Below 100K)<br>
			$passportctrl

		</td>
	</tr>
<tr>
		<td class='head'>*Worker Name</td>
		<td  class='even'><input name='worker_name' value='$this->worker_name' maxlength="40" size="40" ></td>
	</tr>	
<tr>
		<td class='head'>*Worker No (Worker ID at workspace)</td>
		<td  class='odd'><input name='worker_no' 
			value='$this->worker_no'  maxlength="12" size="12" ></td>
	</tr>
	
	<tr>
		<td class='head'>*Nationality</td>
		<td  class='odd'>$this->nationalityctrl</td>
	</tr>
	<tr>
		<td class='head'>*Identity Card No</td>
		<td  class='even'><input name='ic_no' value='$this->ic_no' maxlength="20" size="20" ></td>
	</tr>
	<tr>
		<td class='head'>Passport No</td>
		<td  class='even'><input name='passport_no' value='$this->passport_no' maxlength="20" size="20" ></td>
	</tr>
	<tr>
		<td class='head'>*Date Of Birth (YYYY-MM-DD)</td>
		<td  class='odd'><input id='dateofbirth' name='dateofbirth' value='$this->dateofbirth' maxlength="10" size="10" >
		<input type='button' value='Date' onclick="$this->showddateofbirthctrl"></td>
	</tr>
	<tr>
		<td class='head'>*Gender</td>
		<td  class='even'>$genderctrl</td>
	</tr>
	<tr>
		<td class='head'>*Races</td>
		<td  class='odd'>$this->racesctrl</td>
	</tr>
	<tr>
		<td class='head'>*Marital Status</td>
		<td  class='even'>$maritalctrl</td>
	</tr>
	<tr>
		<td class='head'>*Arrival Date(YYYY-MM-DD)</td>
		<td  class='odd'><input id='arrivaldate' name='arrivaldate' value='$this->arrivaldate'  maxlength="10" size="10" >
				<input type='button'  value='Date' onclick="$this->showarrivaldatectrl">
	</td>
	</tr>
	<tr>
		<td class='head'>Departure Date(YYYY-MM-DD)</td>
		<td  class='odd'><input name='departuredate' id='departuredate' value='$this->departuredate'  maxlength="10" size="10" >
				<input type='button' value='Date' onclick="$this->showdeparturedatectrl">
	</td>
	</tr>

	<tr>
		<td class='head'>Active</td>
		<td  class='even'><input type='checkbox' name='isactive' $checked></td>
	</tr>
	<tr>
		<td class='head'>Education Level</td>
		<td  class='even'><input name='educationlevel' value="$this->educationlevel"></td>
	</tr>
	<tr>
		<th colspan='4'>Contact Info</th>
	</tr>


	<tr>
		<td class='head'>Handphone</td>
		<td  class='even'><input name='handphone' value='$this->handphone'  maxlength="16" size="16" ></td>
		<td class='head'>Email</td>
		<td  class='even'><input name='email' value='$this->email'  maxlength="80" size="40" ></td>
	</tr>
	<tr>
		<td class='head'>Family Contact Person</td>
		<td  class='odd'><input name='family_contactname' value='$this->family_contactname' maxlength="40" size="40" ></td>
		<td class='head'>Relationship</td>
		<td  class='odd'><input name='relationship' value='$this->relationship' maxlength="30" size="30" ></td>
	</tr>
	<tr>
		<td class='head'>Family Member Contact No</td>
		<td  class='even'><input name='family_contactno' value='$this->family_contactno' maxlength="40" size="40" ></td>
		<td class='head'></td>
		<td  class='even'></td>
	</tr>
	<tr>
		<td class='head'>Street1</td>
		<td  class='odd'><input name='home_street1' value='$this->home_street1' maxlength="100" size="60" ></td>
		<td class='head'>Street2</td>
		<td  class='odd'><input name='home_street2' value='$this->home_street2' maxlength="100" size="60"></td>
	</tr>
	<tr>
		<td class='head'>Postcode</td>
		<td  class='even'><input name='home_postcode' value='$this->home_postcode' maxlength="5" size="5"></td>
		<td class='head'>City</td>
		<td  class='even'><input name='home_city' value='$this->home_city' maxlength="30" size="30"></td>
	</tr>
	<tr>
		<td class='head'>State</td>
		<td  class='odd'><input name='home_state' value='$this->home_state' maxlength="30" size="30"></td>
		<td class='head'>Country</td>
		<td  class='odd'><input name='home_country' value='$this->home_country' maxlength="20" size="20"></td>
	</tr>
	<tr>
		<td class='head'>Tel 1</td>
		<td  class='even'><input name='home_tel1' value='$this->home_tel1' maxlength="16" size="16"></td>
		<td class='head'>Tel 2</td>
		<td  class='even'><input name='home_tel2' value='$this->home_tel2' maxlength="16" size="16"></td>
	</tr>
<tr><th colspan='11'>Bank Info</th></tr>
	<tr>
		<td class='head'>Bank Account No</td>
		<td  class='even'><input name='bank_acc' value='$this->bank_acc' maxlength="30" size="30"></td>
		<td class='head'>Bank Name</td>
		<td  class='even'><input name='bank_name' value='$this->bank_name' maxlength="30" size="30"></td>
	</tr>
	<tr>
		<td class='head'>Bank Account Type</td>
		<td  class='odd'><input name='bankacc_type' value='$this->bankacc_type' maxlength="30" size="30"></td>
		<td class='head'></td>
		<td  class='odd'></td>
	</tr>
<tr><th colspan='11'>Others Info</th></tr>
	<tr>
		<td class='head' >Skill</td>
		<td  class='even'colspan='3'>
			<textarea cols='70' rows='5' name='skill'>$this->skill</textarea>
		</td>
	</tr>
	<tr>
		<td class='head'>Description</td>
		<td  class='odd' colspan='3'>
			<textarea cols='70'  rows='5' name='description'>$this->description</textarea>
		</td>
	</tr>

    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$savectrl 
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></td>
	</form><td>$printprofile</td><td>$deletectrl</td></tbody></table>
  <br>

$recordctrl

EOF;

  } // end of member function getInputForm

 
  public function updateWorker( ) {
 	$timestamp= date("y/m/d H:i:s", time()) ;
 	$sql="UPDATE $this->tableworker SET ".
		"worker_no='$this->worker_no',worker_code='$this->worker_code',worker_name='$this->worker_name',".
		"dateofbirth='$this->dateofbirth',
		ic_no='$this->ic_no',gender='$this->gender',races_id=$this->races_id,".
		"nationality_id=$this->nationality_id,passport_no='$this->passport_no',".
		"home_street1='$this->home_street1',home_street2='$this->home_street2',".
		"home_postcode='$this->home_postcode',home_city='$this->home_city',home_state='$this->home_state',".
		"home_country='$this->home_country',email='$this->email',home_tel1='$this->home_tel1',".
		"home_tel2='$this->home_tel2',handphone='$this->handphone',maritalstatus='$this->maritalstatus',".
		"family_contactname='$this->family_contactname',family_contactno='$this->family_contactno',".
		"relationship='$this->relationship',skill='$this->skill',educationlevel='$this->educationlevel',".
		"bank_name='$this->bank_name',bank_acc='$this->bank_acc',bankacc_type='$this->bankacc_type',".
		"description='$this->description',updated='$timestamp',".
		"updatedby=$this->updatedby,isactive=$this->isactive,arrivaldate='$this->arrivaldate', ".
		"departuredate='$this->departuredate',".
		"workerstatus='$this->workerstatus' WHERE worker_id='$this->worker_id'";
	
	$this->log->showLog(3, "Update worker_id: $this->worker_id, $this->worker_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
		$this->log->showLog(2, "Warning! Update worker failed");
		return false;
	}
	else{
		$this->log->showLog(3, "Update worker successfully.");
		return true;
	}
  } // end of member function updateWorker


  public function insertWorker( ) {
   $timestamp= date("y/m/d H:i:s", time()) ;
	$this->log->showLog(3,"Inserting new worker $this->worker_name");
 	$sql="INSERT INTO $this->tableworker ".
		"(worker_no,worker_code,worker_name,dateofbirth,ic_no,gender,races_id,".
		"nationality_id,passport_no,home_street1,home_street2,".
		"home_postcode,home_city,home_state,home_country,".
		"email,home_tel1,home_tel2,handphone,maritalstatus,".
		"family_contactname,family_contactno,relationship,".
		"skill,educationlevel,bank_name,bank_acc,bankacc_type,".
		"description,created,createdby,updated,updatedby,".
		"isactive,arrivaldate,departuredate,workerstatus) values(".
		"'$this->worker_no','$this->worker_code','$this->worker_name','$this->dateofbirth','$this->ic_no','$this->gender',$this->races_id,".
		"$this->nationality_id,'$this->passport_no','$this->home_street1','$this->home_street2',".
		"'$this->home_postcode','$this->home_city','$this->home_state','$this->home_country',".
		"'$this->email','$this->home_tel1','$this->home_tel2','$this->handphone','$this->maritalstatus',".
		"'$this->family_contactname','$this->family_contactno','$this->relationship',".
		"'$this->skill','$this->educationlevel','$this->bank_name','$this->bank_acc','$this->bankacc_type',".
		"'$this->description','$timestamp','$this->createdby','$timestamp','$this->updatedby',".
		"$this->isactive,'$this->arrivaldate','$this->departuredate','$this->workerstatus')";
	$this->log->showLog(4,"Before insert worker SQL:$sql");
	$rs=$this->xoopsDB->query($sql);
	
	if (!rs){
		$this->log->showLog(1,"Failed to insert worker code $worker_name");
		return false;
	}
	else{
		$this->log->showLog(3,"Inserting new worker $worker_name successfully"); 
		return true;
	}
  } // end of member function insertWorker


  public function fetchWorker( $worker_id) {
    
	$this->log->showLog(3,"Fetching worker detail into class Worker.php.<br>");
		
	$sql="SELECT worker_no,worker_code,worker_name,dateofbirth,ic_no,gender,races_id, ".
		"nationality_id,passport_no,home_street1,home_street2, ".
		"home_postcode,home_city,home_state,home_country, ".
		"email,home_tel1,home_tel2,handphone,maritalstatus, ".
		"family_contactname,family_contactno,relationship, ".
		"skill,educationlevel,bank_name,bank_acc,bankacc_type, ".
		"description,created,createdby,updated,updatedby, ".
		"isactive,arrivaldate,departuredate,workerstatus from $this->tableworker ". 
			"where worker_id=$worker_id";
	
	$this->log->showLog(4,"ProductWorker->fetchWorker, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->worker_no=$row['worker_no'];
		$this->worker_code=$row['worker_code'];
		$this->worker_name=$row['worker_name'];
		$this->dateofbirth=$row['dateofbirth'];
		$this->ic_no=$row['ic_no'];
		$this->gender=$row['gender'];
		$this->races_id=$row['races_id'];
		$this->nationality_id=$row['nationality_id'];
		$this->passport_no=$row['passport_no'];
		$this->home_street1=$row['home_street1'];
		$this->home_street2=$row['home_street2'];
		$this->home_postcode=$row['home_postcode'];
		$this->home_city=$row['home_city'];
		$this->home_state=$row['home_state'];
		$this->home_country=$row['home_country'];
		$this->email=$row['email'];
		$this->home_tel1=$row['home_tel1'];
		$this->home_tel2=$row['home_tel2'];
		$this->handphone=$row['handphone'];
		$this->maritalstatus=$row['maritalstatus'];
		$this->family_contactname=$row['family_contactname'];
		$this->family_contactno=$row['family_contactno'];
		$this->relationship=$row['relationship'];
		$this->skill=$row['skill'];
		$this->educationlevel=$row['educationlevel'];
		$this->bank_name=$row['bank_name'];
		$this->bank_acc=$row['bank_acc'];
		$this->bankacc_type=$row['bankacc_type'];
		$this->description=$row['description'];
		$this->workerstatus=$row['workerstatus'];
		$this->arrivaldate=$row['arrivaldate'];
		$this->departuredate=$row['departuredate'];
		$this->isactive=$row['isactive'];

   	$this->log->showLog(4,"Worker->fetchWorker,database fetch into class successfully");	
	$this->log->showLog(4,"worker_name:$this->worker_name");
	$this->log->showLog(4,"description:$this->description");
	$this->log->showLog(4,"isactive:$this->isactive");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Worker->fetchWorker,failed to fetch data into databases.");	
	}
  } // end of member function fetchWorker

  public function deleteWorker( $worker_id ) {
    	$this->log->showLog(2,"Warning: Performing delete worker id : $worker_id !");
	
	$sql="DELETE FROM $this->tableworker where worker_id=$worker_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	
	$rs=$this->xoopsDB->query($sql);
	if (!rs){
		$this->log->showLog(1,"Error: worker ($worker_id) cannot remove from database!");
		return false;
	}
	else{
		$this->log->showLog(3,"worker ($worker_id) removed from database successfully!");
		$this->deletephoto($worker_id);
		return true;
		
	}
  } // end of member function deleteWorker

  
  public function getSQLStr_AllWorker( $wherestring,  $orderbystring,  $startlimitno,$recordcount ) {

    $sql="SELECT w.worker_id, w.worker_no, w.worker_code, w.worker_name, w.dateofbirth, w.ic_no, w.gender, w.races_id,".
	" w.nationality_id,w.passport_no, w.home_street1, ".
	" w.home_street2, w.home_postcode, w.home_city, w.home_state, w.home_country, w.email, w.home_tel1, w.home_tel2,".
	" w.handphone, w.maritalstatus, w.family_contactname, w.family_contactno, w.relationship,".
	" w.skill, w.educationlevel, w.bank_name, w.bank_acc, w.bankacc_type, w.description, w.created,".
	" w.createdby, w.updated, w.updatedby, w.isactive, w.arrivaldate, w.workerstatus,r.races_name, n.nationality_name, ".
	" w.departuredate FROM $this->tableworker w ".
	" INNER JOIN $this->tablenationality n on n.nationality_id=w.nationality_id ".
	" INNER JOIN $this->tableraces r on r.races_id=w.races_id " .
	"$wherestring $orderbystring LIMIT $startlimitno,$recordcount";
	  $this->log->showLog(4,"Running ProductWorker->getSQLStr_AllWorker: $sql");
  return $sql;
  } // end of member function getSQLStr_AllWorker

 public function showWorkerTable($wherestring,$orderbystring,$startlimitno,$recordcount){
	
	$this->log->showLog(3,"Showing Worker Table");
	$sql=$this->getSQLStr_AllWorker($wherestring,$orderbystring,$startlimitno,$recordcount);
	
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<table border='1'>
  		<tbody>
    			<tr><th colspan='10' style='text-align: center'>Worker Info ($startlimitno to $recordcount)</th></tr><tr>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Worker Code</th>
				<th style="text-align:center;">Worker Name</th>
				<th style="text-align:center;">Worker Description</th>
				<th style="text-align:center;">Passport</th>
				<th style="text-align:center;">Status</th>
				<th style="text-align:center;">Races</th>
				<th style="text-align:center;">Nationality</th>

				<th style="text-align:center;">Active</th>
				<th style="text-align:center;">Operation</th>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$worker_id=$row['worker_id'];
		$worker_code=$row['worker_code'];
		$worker_name=$row['worker_name'];
		$description=$row['description'];
		$nationality_name=$row['nationality_name'];
		$races_name=$row['races_name'];
		$passport_no=$row['passport_no'];
		$workerstatus=$row['workerstatus'];
		$isactive=$row['isactive'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		if($isactive==1)
			$isactive='Y';
		else
			$isactive='N';
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$worker_code</td>
			<td class="$rowtype" style="text-align:center;">$worker_name</td>
			<td class="$rowtype" style="text-align:center;">$description</td>
			<td class="$rowtype" style="text-align:center;">$passport_no</td>
			<td class="$rowtype" style="text-align:center;">$workerstatus</td>
			<td class="$rowtype" style="text-align:center;">$races_name</td>
			<td class="$rowtype" style="text-align:center;">$nationality_name</td>
			<td class="$rowtype" style="text-align:center;">$isactive</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="worker.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title='Edit this worker'>
				<input type="hidden" value="$worker_id" name="worker_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>
EOF;
	}
	echo  "</tr></tbody></table>";
 }

  public function getLatestWorkerID() {
	$sql="SELECT MAX(worker_id) as worker_id from $this->tableworker;";
	$this->log->showLog(3,'Checking latest created worker_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created worker_id:' . $row['worker_id']);
		return $row['worker_id'];
	}
	else
	return -1;
	
  } // end

  public function getNewWorkerCode() {
	$sql="SELECT MAX(worker_code) as worker_code from $this->tableworker;";
	$this->log->showLog(3,'Checking latest created worker_code');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created worker_code:' . $row['worker_code']);
		return $row['worker_code'] + 1;
	}
	else
	return -1;
	
  } // end

  public function getSelectWorker($id) {
	
	$sql="SELECT worker_id,worker_name from $this->tableworker where isactive='1' or worker_id=$id " .
		" order by worker_name";
	$this->log->showLog(4,"Get worker list With SQL: $sql");
	$selectctl="<SELECT name='worker_id' >";
	if ($id==-1)
		$selectctl=$selectctl . '<OPTION value="0" SELECTED="SELECTED">Null </OPTION>';
		
	$query=$this->xoopsDB->query($sql);
	$selected="";
	while($row=$this->xoopsDB->fetchArray($query)){
		$worker_id=$row['worker_id'];
		$worker_name=$row['worker_name'];
	
		if($id==$worker_id)
			$selected='SELECTED="SELECTED"';
		else
			$selected="";
		$selectctl=$selectctl  . "<OPTION value='$worker_id' $selected>$worker_name</OPTION>";

	}

	$selectctl=$selectctl . "</SELECT>";

	return $selectctl;
  } // end


  public function allowDelete($id){
	$sql="SELECT count(worker_id) as rowcount from $this->tableworkercompany where worker_id=$id";
	$this->log->showLog(3,"Accessing ProductWorker->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this worker, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this worker, record deletable");
		return true;
		}
	}

   public function workerStatusSelection($w_status,$includenull='N'){
	
	$isnormal="";
	$isabscon="";
	$isdead="";
	$iswentback="";
	$nullstring="";
	$isnull="";
	
	switch ($w_status){
		case "Normal":
			$isnormal="SELECTED='SELECTED'";
		break;
		case "Absconded":
			$isabscon="SELECTED='SELECTED'";
		break;
		case "Dead":
			$isdead="SELECTED='SELECTED'";
		break;
		case "Go Back":
			$iswentback="SELECTED='SELECTED'";
		break;
		default :
			
		break;
	}
	
	if ($includenull=='Y')
		$nullstring="<option value='-'>Null</option>";

	
	$ctrlstring= "<SELECT name='workerstatus'>".
			$nullstring.
			"<option value='Normal' $isnormal>Normal</option>".
			"<option value='Absconded' $isabscon>Absconded</option>".
			"<option value='Go Back' $iswentback>Went Back</option>".
			"<option value='Dead' $isdead>Dead</option>".
		"</SELECT>";
	return $ctrlstring;
	}


 public function showWorkerHeader($worker_id){
	if($this->fetchWorker($worker_id)){
		$this->log->showLog(4,"Showing worker header successfully.");
	echo <<< EOF
	<table border='1' cellspacing='3'>
		<tbody>
			<tr>
				<th colspan="4">Worker Info</th>
			</tr>
			<tr>
				<td class="head">Worker Code</td>
				<td class="odd">$this->worker_code</td>
				<td class="head">Worker Name</td>
				<td class="odd"><A href="worker.php?action=edit&worker_id=$worker_id" 
						target="_blank">$this->worker_name</A></td>
			</tr>
		</tbody>
	</table><br>
EOF;
	}
	else{
		$this->log->showLog(1,"<b style='color:red;'>Showing worker header failed.</b>");
	}

   }//showRegistrationHeader

 public function showSearchForm(){
	$workerstatusctrl=$this->workerStatusSelection($this->workerstatus,'Y');
   echo <<< EOF
	<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Search Worker</span></big></big></big></div><br>
	<FORM action="worker.php" method="POST">
	  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="3">
	  <tbody>
	    <tr>
		<th colspan='4'>Criteria</th>
	    </tr>
	    <tr>
	      <td class='head'>Worker Code</td>
	      <td class='even'><input name='worker_code' value='$this->worker_code'> (%, AB%,%AB,%A%B%)</td>
	      <td class='head'>Worker Name</td>
	      <td class='even'><input name='worker_name' value='$this->worker_name'>%ali, %ali%, ali%, %ali%bin%</td>
	    </tr>
	    <tr>
	      <td class='head'>Quick Search</td>
	      <td class='odd'>$this->workerctrl</td>
	      <td class='head'>IC Number</td>
	      <td class='odd'><input name='ic_no' value='$this->ic_no'></td>
	    </tr>
	    <tr>
	      <td class='head'>Passport No</td>
	      <td class='odd'><input name='passport_no' value='$this->passport_no'></td>
	      <td class='head'>Worker Status</td>
	      <td class='odd'>$workerstatusctrl</td>
	    </tr>
	    <tr>
	      <td class='head'>Races</td>
	      <td class='odd'>$this->racesctrl</td>
	      <td class='head'>Nationality</td>
	      <td class='odd'>$this->nationalityctrl </td>
	    </tr>
    	<tr>
	      <td class='head'>Date Of Birth</td>
	      <td class='odd'><input name="dateofbirth"></td>
	      <td class='head'>Is Active</td>
	      <td class='odd'>
		<select name="isactive">
			<option value="-1">Null</option>
			<option value="1" >Y</option>
			<option value="0" >N</option>
		</select>
		</td>
	    </tr>
	  </tbody>
	</table>
	<table style="width:150px;">
	  <tbody>
	    <tr>
	      <td><input style="height:40px;" type='submit' value='Search' name='submit'><input type='hidden' name='action' value='search'></td>
	      <td><input type='reset' value='Reset' name='reset'></td>
	    </tr>
	  </tbody>
	</table>
	</FORM>
EOF;
  }//showSearchForm

 public function selectGender($gender,$showNull='N'){
	$nulloption="";
	$ismale="";
	$isfemale="";
	$nogender="";
	if($gender=='M')
	$ismale="SELECTED='SELECTED'";
	elseif($gender=='F')
	$isfemale="SELECTED='SELECTED'";
	else
	$nogender="SELECTED='SELECTED'";

	if($showNull=='Y')
		$nulloption="<OPTION value='-' $nogender>Null</OPTION>";		


	$result="<SELECT name='gender'>".
			"<OPTION value='M' $ismale>Male</OPTION>".
			"<OPTION value='F' $isfemale>Female</OPTION>$nulloption".
		"</SELECT>";
	return $result;

  }

  public function selectMaritalStatus($maritalstatus,$showNull='N'){
	$nulloption="";
	$issingle="";
	$ismarried="";
	$divorse="";
	$nomaritalstatus="";
	if($maritalstatus=='S')
	$issingle="SELECTED='SELECTED'";
	elseif($maritalstatus=='M')
	$ismarried="SELECTED='SELECTED'";
	elseif($maritalstatus=='D')
	$isdivorce="SELECTED='SELECTED'";
	else
	$nomaritalstatus="SELECTED='SELECTED'";

	if($showNull=='Y')
		$nulloption="<OPTION value='-' $nomaritalstatus>Null</OPTION>";		


	$result="<SELECT name='maritalstatus'>".
			"$nulloption<OPTION value='S' $issingle>Single</OPTION>".
			"<OPTION value='M' $ismarried>Married</OPTION>".
			"<OPTION value='D' $isdivorce>Divorced</OPTION>".
		"</SELECT>";
	return $result;

  }
  public function savephoto($phototmpfile){
	
	move_uploaded_file($phototmpfile, "images/photo/$this->worker_id".".jpg");
	$this->log->showLog(4,"Saving worker photo $phototmpfile to images/photo/$this->worker_id".".jpg");
  }
 
  public function deletephoto($worker_id){
	$filename="images/photo/$worker_id".".jpg";
	unlink("$filename");
	$this->log->showLog(4,"Removing images/photo/$worker_id".".jpg");
  }

  public function savepassport($passporttmpfile){
	
	move_uploaded_file($passporttmpfile, "images/passport/$this->worker_id".".jpg");
	$this->log->showLog(4,"Saving worker photo $phototmpfile to images/photo/$this->worker_id".".jpg");
  }
 
  public function deletepassport($worker_id){
	$passportfilename="images/passport/$worker_id".".jpg";
	unlink("$passportfilename");
	$this->log->showLog(4,"Removing images/passport/$worker_id".".jpg");
  }
  
  public function searchAToZ(){
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search worker easily. With function searchAToZ()");
	$sqlfilter="SELECT DISTINCT(LEFT(worker_name,1)) as shortname FROM $this->tableworker where isactive='1' order by worker_name";
	$this->log->showLog(4,"With SQL:$sqlfilter");
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	echo "<b>Worker Grouping By Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if customer never do filter yet, if will choose 1st customer listing
		
		echo "<A style='font-size:12;' href='worker.php?filterstring=$shortname'>  $shortname  </A> ";
	}
	
	$this->log->showLog(3,"Complete generate list of short cut");
		echo <<<EOF
<BR>
<A href='worker.php?action=new' style='color: GRAY'> [ADD NEW WORKER]</A>
<A href='worker.php?action=showSerchForm' style='color: gray'> [SEARCH WORKER]</A>

EOF;
return $filterstring;

  }

  public function convertSearchString($worker_id,$worker_code,$worker_name,$ic_no,$passport_no,$workerstatus,
				$races_id,$nationality_id,$dateofbirth,$isactive){
$filterstring="";

if($worker_id > 0 ){
	$filterstring=$filterstring . " w.worker_id=$worker_id AND";
}

if($worker_code!=""){
	$filterstring=$filterstring . " w.worker_code LIKE '$worker_code' AND";
}

if($worker_name!=""){
	$filterstring=$filterstring . "  w.worker_name LIKE '$worker_name' AND";
}

if($ic_no!=""){
	$filterstring=$filterstring . " w.ic_no LIKE '$ic_no' AND";
}

if ($passport_no!=""){
$filterstring=$filterstring . " w.passport_no LIKE '$passport_no' AND";
}

if ($workerstatus!="-"){
$filterstring=$filterstring . " w.workerstatus = '$workerstatus' AND";
}

if($races_id>0){
$filterstring=$filterstring . "  w.races_id = $races_id AND";
}


if ($nationality_id>0){
$filterstring=$filterstring . " w.nationality_id =  '$nationality_id' AND";
}


if ($dateofbirth!=""){
$filterstring=$filterstring . " w.dateofbirth LIKE '$dateofbirth' AND";
}


if ($isactive!="-1")
$filterstring=$filterstring . " w.isactive =$isactive AND";

if ($filterstring=="")
	return "";
else {
	$filterstring =substr_replace($filterstring,"",-3);  

	return "WHERE $filterstring";
	}
	
	}
} // end of ClassWorker
?>

<?php


class Trackclass
{

  public $trackheader_id;
  public $trackheader_name;
  public $trackheader_code;
  public $organization_id;
  public $isactive;
  public $islecturer;
  public $isovertime;
  public $isfulltime;
  public $isparttime;
  public $trackheader_description;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tabletrackheader;
  private $tablebpartner;

  private $log;


//constructor
   public function Trackclass(){
	global $xoopsDB,$log,$tabletrackheader,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport,$defaultorganization_id;
        $this->defaultorganization_id=$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tabletrackheader=$tabletrackheader;
	$this->tablebpartner=$tablebpartner;
	$this->tabledailyreport=$tabledailyreport;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type
   * @param int trackheader_id
   * @return
   * @access public
   */

  public function fetchTrackclass($trackheader_id) {
	$this->log->showLog(3,"Fetching trackheader detail into class Trackclass.php.<br>");

	$sql="SELECT * from $this->tabletrackheader where trackheader_id=$trackheader_id";

	$this->log->showLog(4,"ProductTrackclass->fetchTrackclass, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->trackheader_name=$row["trackheader_name"];
		$this->trackheader_code=$row["trackheader_code"];
		$this->organization_id=$row['organization_id'];
		$this->seqno= $row['seqno'];
		$this->trackheader_description=$row['trackheader_description'];
		$this->isactive=$row['isactive'];
		$this->trackheader_description=$row['trackheader_description'];
   	$this->log->showLog(4,"Trackclass->fetchTrackclass,database fetch into class successfully");
	$this->log->showLog(4,"trackheader_name:$this->trackheader_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	//$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Trackclass->fetchTrackclass,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchTrackclass

  public function fetchTrack($track_id) {
	$this->log->showLog(3,"Fetching track detail into class Trackclass.php.<br>");

	$sql="SELECT * from sim_simbiz_track where track_id=$track_id";

	$this->log->showLog(4,"ProductTrack->fetchTrack, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->track_name=$row["track_name"];
		$this->organization_id=$row['organization_id'];
		$this->seqno= $row['seqno'];
		$this->isactive=$row['isactive'];

   	$this->log->showLog(4,"track->fetchTrack,database fetch into class successfully");
	$this->log->showLog(4,"track_name:$this->track_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	//$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Trackclass->fetchTrackclass,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchTrackclass
/*
 *public function getNextSeqNo() {
 *
 *	$sql="SELECT MAX(seqno) + 10 as seqno from $this->tabletrackheader;";
 *	$this->log->showLog(3,'Checking next seqno');
 *	$this->log->showLog(4,"SQL: $sql");
 *	$query=$this->xoopsDB->query($sql);
 *	if($row=$this->xoopsDB->fetchArray($query)){
 *		$this->log->showLog(3,'Found next seqno:' . $row['seqno']);
 *		return  $row['seqno'];
 *	}
 *	else
 *	return 10;
 *
 * } // end
 */
 public function showSearchForm(){

  global $isadmin;

  if($isadmin==1)
  $showdeleted="<input type=\"checkbox\" name=\"searchisdeleted\" id=\"searchisdeleted\">".
        "<a onclick=document.getElementById(\"searchisdeleted\").click() title=\"Show deleted records.\">Show Deleted Only</a>";

  echo <<< EOF
<table style="width:100%; display:none;" >
 <tr>
  <td align="center" >

<div id='centercontainer' class="searchformblock" style="width:943px;">
       <form name="frmTrackclass">

    <div align="center" class="searchformheader">Search Employee Group</div>

            <div class="divfield">Employee Group No<br/>
			<input name="searchtrackheader_code" id="searchtrackheader_code"></div>

            <div  class="divfield">Employee Group Name<br/>
			<input name="searchtrackheader_name" id="searchtrackheader_name"></div>

	    <div class="divfield"> Active<br/>
                <select name="searchisactive" id="searchisactive">
                    <option value="-">Null</option>
                    <option value="1" SELECTED="SELECTED">Yes</option>
                    <option value="0">No</option>
                </select></div><br/>
        $showdeleted   <input name="submit" value="Search" type="button" onclick="search()">
</form>
    </div>

</td></tr></table>

EOF;
}

 public function showTrackclass($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    $tablename="sim_simbiz_trackheader";
    $searchtrackheader_code=$_GET['searchtrackheader_code'];
    $searchtrackheader_name=$_GET['searchtrackheader_name'];
    $searchisactive=$_GET['searchisactive'];

   $this->log->showLog(2,"Access ShowTrackclass($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="seqno, trackheader_name";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

     if($searchtrackheader_code !="")
           $wherestring.= " AND trackheader_code LIKE '".$searchtrackheader_code."'";
     if($searchtrackheader_name !="")
           $wherestring.= " AND trackheader_name LIKE '".$searchtrackheader_name."'";
    // if($searchisactive !="-")
         //  $wherestring.= " AND isactive =$searchisactive";


     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("trackheader_code");
     	$getHandler->DefineField("trackheader_name");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("seqno");
        $getHandler->DefineField("info");
        $getHandler->DefineField("trackheader_description");
        $getHandler->DefineField("trackheader_id");
        $getHandler->DefineField("rh");

	$currentRecord = 0; // This will assist us finding the ordinalStart position
            $rh="odd";
      while ($row=$xoopsDB->fetchArray($query))
     {

          if($rh=="even")
            $rh="odd";
          else
            $rh="even";

     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['trackheader_id']);
             $getHandler->DefineRecordFieldValue("trackheader_code", $row['trackheader_code']);
             $getHandler->DefineRecordFieldValue("trackheader_name",$row['trackheader_name']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("seqno", $row['seqno']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['trackheader_id']."&tablename=sim_simbiz_trackheader&idname=trackheader_id&title=Trackclass");
             $getHandler->DefineRecordFieldValue("trackheader_description",$row['trackheader_description']);
             $getHandler->DefineRecordFieldValue("trackheader_id",$row['trackheader_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showTrackclass()");
    }

 public function saveTrackclass(){
    $this->log->showLog(2,"Access saveTrackclass");
        include "../simantz/class/nitobi.xml.php";
        include_once "../simantz/class/Save_Data.inc.php";

        global $xoopsDB,$xoopsUser;
        $saveHandler = new EBASaveHandler();
        $saveHandler->ProcessRecords();
        $timestamp=date("Y-m-d H:i:s",time());
        $createdby=$xoopsUser->getVar('uid');
        $uname=$xoopsUser->getVar('uname');
        $uid=$xoopsUser->getVar('uid');
        $organization=$xoopsUser->getVar('uid');
        $organization_id=$this->defaultorganization_id;
    $tablename="sim_simbiz_trackheader";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
    $arrfield=array("trackheader_code", "trackheader_name","isactive","seqno",
                    "created","createdby","updated","updatedby","trackheader_description","organization_id");
    $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s','%d','%s');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "trackheader_code"),
                $saveHandler->ReturnInsertField($currentRecord, "trackheader_name"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $saveHandler->ReturnInsertField($currentRecord,"trackheader_description"),
                $organization_id);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "trackheader_code");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"trackheader_id");
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{

      $arrfield=array("trackheader_code", "trackheader_name", "isactive","seqno",
            "updated","updatedby","trackheader_description");
      $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s');
 // Yes there are UPDATEs to perform...

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
         $this->log->showLog(3,"***updating record($currentRecord),new trackheader_name:".
                $saveHandler->ReturnUpdateField($currentRecord, "trackheader_name").",id:".
                $saveHandler->ReturnUpdateField($currentRecord)."\n");
                $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "trackheader_code");

 }

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "trackheader_code"),
                $saveHandler->ReturnUpdateField($currentRecord, "trackheader_name"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"trackheader_description"),
                );
        $this->log->showLog(3,"***updating record($currentRecord),new trackheader_name:".
              $saveHandler->ReturnUpdateField($currentRecord, "trackheader_name").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"trackheader_id")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "trackheader_code");

         $save->UpdateRecord($tablename, "trackheader_id", $saveHandler->ReturnUpdateField($currentRecord,"trackheader_id"),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }

 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");
//include "class/Track.inc.php";
//$o = new Trackclass();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $this->fetchTrackclass($record_id);
    $controlvalue=$this->trackheader_code;
    $isdeleted=$this->isdeleted;

    $save->DeleteRecord("sim_simbiz_trackheader","trackheader_id",$record_id,$controlvalue,1);
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }
  }

  }
if($this->failfeedback!="")
$this->failfeedback="Warning!<br/>\n".$this->failfeedback;

$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();


}

 public function allowDelete($trackheader_id){

	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where trackheader_id = $trackheader_id or last_trackheader = $trackheader_id or next_trackheader = $trackheader_id ";
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$rowcount = $row['rowcount'];
	}

	if($rowcount > 0)
	return false;
	else
	return true;
//	return $checkistrue;
	}

 public function showTrack($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    $tablename="sim_simbiz_track";
    $trackheader_id=$_GET['trackheader_id'];


   $this->log->showLog(2,"Access ShowTrackclass($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="seqno, track_name";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

     $wherestring.= " AND trackheader_id =".$trackheader_id;


     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("track_name");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("seqno");
        $getHandler->DefineField("info");
        $getHandler->DefineField("trackheader_id");
        $getHandler->DefineField("track_id");
        $getHandler->DefineField("rh");

	$currentRecord = 0; // This will assist us finding the ordinalStart position
            $rh="odd";
      while ($row=$xoopsDB->fetchArray($query))
     {

          if($rh=="even")
            $rh="odd";
          else
            $rh="even";

     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['track_id']);
             $getHandler->DefineRecordFieldValue("track_name", $row['track_name']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("seqno", $row['seqno']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['track_id']."&tablename=sim_simbiz_track&idname=track_id&title=Track");
             $getHandler->DefineRecordFieldValue("trackheader_id",$row['trackheader_id']) ;
             $getHandler->DefineRecordFieldValue("track_id",$row['track_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showTrack()");
    }

 public function saveTrack(){
    $this->log->showLog(2,"Access saveTrack");
        include "../simantz/class/nitobi.xml.php";
        include_once "../simantz/class/Save_Data.inc.php";

        global $xoopsDB,$xoopsUser;
        $saveHandler = new EBASaveHandler();
        $saveHandler->ProcessRecords();
        $timestamp=date("Y-m-d H:i:s",time());
        $createdby=$xoopsUser->getVar('uid');
        $uname=$xoopsUser->getVar('uname');
        $uid=$xoopsUser->getVar('uid');

        $organization_id=$this->defaultorganization_id;
        $tablename="sim_simbiz_track";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
    $arrfield=array("trackheader_id", "track_name","isactive","seqno",
                    "created","createdby","updated","updatedby","organization_id");
    $arrfieldtype=array('%d','%s','%d','%d','%s','%d','%s','%d','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "trackheader_id"),
                $saveHandler->ReturnInsertField($currentRecord, "track_name"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $organization_id);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "track_name");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"track_name");
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{

      $arrfield=array("track_name", "isactive","seqno",
            "updated","updatedby");
      $arrfieldtype=array('%s','%d','%d','%s','%d');
 // Yes there are UPDATEs to perform...

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
         $this->log->showLog(3,"***updating record($currentRecord),new track_name:".
                $saveHandler->ReturnUpdateField($currentRecord, "track_name").",id:".
                $saveHandler->ReturnUpdateField($currentRecord, "track_id")."\n");
                $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "track_name");

 }

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "track_name"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"seqno"),
                $timestamp,
                $createdby);
        $this->log->showLog(3,"***updating record($currentRecord),new track_name:".
              $saveHandler->ReturnUpdateField($currentRecord, "track_name").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"track_id")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "track_name");

         $save->UpdateRecord($tablename, "track_id", $saveHandler->ReturnUpdateField($currentRecord,"track_id"),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }

 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");
//include "class/Track.inc.php";
//$o = new Trackclass();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $this->fetchTrack($record_id);
    $controlvalue=$this->track_name;
    $isdeleted=$this->isdeleted;

    $save->DeleteRecord("sim_simbiz_track","track_id",$record_id,$controlvalue,1);
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }
  }

  }
if($this->failfeedback!="")
$this->failfeedback="Warning!<br/>\n".$this->failfeedback;

$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();


}

 public function showLookupTrackclass(){
        $this->log->showLog(2,"Run lookup showTrackclass()");
        $tablename="sim_simbiz_trackheader";
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="trackheader_code";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  trackheader_id, trackheader_code, trackheader_name, isactive,seqno
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
    $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["trackheader_id"]);
                       $getHandler->DefineRecordFieldValue("trackheader_id", $row["trackheader_id"]);
                       $getHandler->DefineRecordFieldValue("trackheader_name", $row["trackheader_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }
$getHandler->completeGet();
    }
} // end of ClassTrackclass
?>

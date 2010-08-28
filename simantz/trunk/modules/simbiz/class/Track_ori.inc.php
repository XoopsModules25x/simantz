<?php


class Track
{

  public $track_id;
  public $track_name;
  public $track_description;
  public $organization_id;
  public $isactive;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tabletrack;
  private $tablebpartner;

  private $log;


//constructor
   public function Track(){
	global $xoopsDB,$log,$tabletrack,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport,$defaultorganization_id;
        $this->defaultorganization_id=$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tabletrack=$tabletrack;
	$this->tablebpartner=$tablebpartner;
	$this->tabledailyreport=$tabledailyreport;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type
   * @param int track_id
   * @return
   * @access public
   */

  public function fetchTrack($track_id)
  {
	$this->log->showLog(3,"Fetching track detail into class Track.php.<br>");

	$sql="SELECT * from $this->tabletrack where track_id=$track_id";

	$this->log->showLog(4,"ProductTrack->fetchTrack, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->track_name=$row["track_name"];
		$this->track_description=$row["track_description"];
		$this->organization_id=$row['organization_id'];
		$this->seqno= $row['seqno'];
		$this->isactive=$row['isactive'];
		$this->isdeleted=$row['isdeleted'];
                $this->isparttime=$row['isparttime'];

   	$this->log->showLog(4,"Track->fetchTrack,database fetch into class successfully");
	$this->log->showLog(4,"track_name:$this->track_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	//$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Track->fetchTrack,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchTrack
/*
 *public function getNextSeqNo() {
 *
 *	$sql="SELECT MAX(seqno) + 10 as seqno from $this->tabletrack;";
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
       <form name="frmTrack">

    <div align="center" class="searchformheader">Search Employee Group</div>

            <div class="divfield">Employee Group No<br/>
			<input name="searchtrack_description" id="searchtrack_description"></div>

            <div  class="divfield">Employee Group Name<br/>
			<input name="searchtrack_name" id="searchtrack_name"></div>

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
    $searchtrack_description=$_GET['searchtrack_description'];
    $searchtrack_name=$_GET['searchtrack_name'];
    $searchisactive=$_GET['searchisactive'];
    $searchisdeleted=$_GET['searchisdeleted'];
   $this->log->showLog(2,"Access ShowTrack($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="track_description";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
     if($isadmin!=1)
        $wherestring.= " AND isdeleted=0";
  //   else
   //         $wherestring.= " AND isdeleted=1";
     if($searchtrack_description !="")
           $wherestring.= " AND track_description LIKE '".$searchtrack_description."'";
     if($searchtrack_name !="")
           $wherestring.= " AND track_name LIKE '".$searchtrack_name."'";
    // if($searchisactive !="-")
         //  $wherestring.= " AND isactive =$searchisactive";


     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("track_description");
     	$getHandler->DefineField("track_name");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("seqno");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
        $getHandler->DefineField("organization_id");
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
             $getHandler->DefineRecordFieldValue("track_description", $row['track_description']);
             $getHandler->DefineRecordFieldValue("track_name",$row['track_name']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("seqno", $row['seqno']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['track_id']."&tablename=sim_simbiz_track&idname=track_id&title=Track");
             $getHandler->DefineRecordFieldValue("organization_id",$row['organization_id']);
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
    $arrfield=array("track_description", "track_name","isactive","seqno",
                    "created","createdby","updated","updatedby","organization_id");
    $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s','%d','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "track_description"),
                $saveHandler->ReturnInsertField($currentRecord, "track_name"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
               $organization_id
         );
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "track_description");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"track_id");
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

      $arrfield=array("track_description", "track_name", "isactive","seqno",
            "isdeleted","updated","updatedby");
      $arrfieldtype=array('%s','%s','%d','%d','%d','%s','%d');
 // Yes there are UPDATEs to perform...

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
         $this->log->showLog(3,"***updating record($currentRecord),new track_name:".
                $saveHandler->ReturnUpdateField($currentRecord, "track_name").",id:".
                $saveHandler->ReturnUpdateField($currentRecord)."\n");
                $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "track_description");

 }

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "track_description"),
                $saveHandler->ReturnUpdateField($currentRecord, "track_name"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"seqno"),
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                $timestamp,
                $createdby
                );
        $this->log->showLog(3,"***updating record($currentRecord),new track_name:".
              $saveHandler->ReturnUpdateField($currentRecord, "track_name").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"track_id")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "track_description");

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
//$o = new Track();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $this->fetchTrack($record_id);
    $controlvalue=$this->track_description;
    $isdeleted=$this->isdeleted;

    $save->DeleteRecord("sim_simbiz_track","track_id",$record_id,$controlvalue,1);

  }

  }
if($this->failfeedback!="")
$this->failfeedback="Warning!<br/>\n".$this->failfeedback;

$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();

}

public function showLookupTrack(){
        $this->log->showLog(2,"Run lookup showTrack()");
        $tablename="sim_simbiz_track";
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="track_description";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  track_id, track_description, track_name, isactive,seqno
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
    $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["track_id"]);
                       $getHandler->DefineRecordFieldValue("track_id", $row["track_id"]);
                       $getHandler->DefineRecordFieldValue("track_name", $row["track_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }
$getHandler->completeGet();
    }
} // end of ClassTrack
?>

<?php


class Religion
{

  public $religion_id;
  public $religion_name;
  public $religion_description;
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
  private $tablereligion;
  private $tablebpartner;

  private $log;


//constructor
   public function Religion(){
	global $xoopsDB,$log,$tablereligion,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport,$defaultorganization_id;
        $this->defaultorganization_id=$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablereligion=$tablereligion;
	$this->tablebpartner=$tablebpartner;
	$this->tabledailyreport=$tabledailyreport;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type
   * @param int religion_id
   * @return
   * @access public
   */

  public function fetchReligion($religion_id)
  {
	$this->log->showLog(3,"Fetching religion detail into class Religion.php.<br>");

	$sql="SELECT * from $this->tablereligion where religion_id=$religion_id";

	$this->log->showLog(4,"ProductReligion->fetchReligion, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->religion_name=$row["religion_name"];
		$this->religion_description=$row["religion_description"];
		$this->organization_id=$row['organization_id'];
		$this->seqno= $row['seqno'];
		$this->isactive=$row['isactive'];
                $this->isparttime=$row['isparttime'];

   	$this->log->showLog(4,"Religion->fetchReligion,database fetch into class successfully");
	$this->log->showLog(4,"religion_name:$this->religion_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	//$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Religion->fetchReligion,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchReligion
/*
 *public function getNextSeqNo() {
 *
 *	$sql="SELECT MAX(seqno) + 10 as seqno from $this->tablereligion;";
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

  //if($isadmin==1)
 // $showdeleted="<input type=\"checkbox\" name=\"searchisdeleted\" id=\"searchisdeleted\">".
 //       "<a onclick=document.getElementById(\"searchisdeleted\").click() title=\"Show deleted records.\">Show Deleted Only</a>";

  echo <<< EOF
<table style="width:100%; display:none;" >
 <tr>
  <td align="center" >

<div id='centercontainer' class="searchformblock" style="width:943px;">
       <form name="frmReligion">

    <div align="center" class="searchformheader">Search Employee Group</div>

            <div class="divfield">Employee Group No<br/>
			<input name="searchreligion_description" id="searchreligion_description"></div>

            <div  class="divfield">Employee Group Name<br/>
			<input name="searchreligion_name" id="searchreligion_name"></div>

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

 public function showReligion($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    $tablename="sim_religion";
    $searchreligion_description=$_GET['searchreligion_description'];
    $searchreligion_name=$_GET['searchreligion_name'];
    $searchisactive=$_GET['searchisactive'];
   $this->log->showLog(2,"Access ShowReligion($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="seqno, religion_name";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

     if($searchreligion_description !="")
           $wherestring.= " AND religion_description LIKE '".$searchreligion_description."'";
     if($searchreligion_name !="")
           $wherestring.= " AND religion_name LIKE '".$searchreligion_name."'";


     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("religion_description");
     	$getHandler->DefineField("religion_name");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("seqno");
        $getHandler->DefineField("info");
        $getHandler->DefineField("organization_id");
        $getHandler->DefineField("religion_id");
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
             $getHandler->CreateNewRecord($row['religion_id']);
             $getHandler->DefineRecordFieldValue("religion_description", $row['religion_description']);
             $getHandler->DefineRecordFieldValue("religion_name",$row['religion_name']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("seqno", $row['seqno']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['religion_id']."&tablename=sim_religion&idname=religion_id&title=Religion");
             $getHandler->DefineRecordFieldValue("organization_id",$row['organization_id']);
             $getHandler->DefineRecordFieldValue("religion_id",$row['religion_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showReligion()");
    }

 public function saveReligion(){
    $this->log->showLog(2,"Access saveReligion");
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
        $tablename="sim_religion";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
    $arrfield=array("religion_description", "religion_name","isactive","seqno",
                    "created","createdby","updated","updatedby","organization_id");
    $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s','%d','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "religion_description"),
                $saveHandler->ReturnInsertField($currentRecord, "religion_name"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
               $organization_id
         );
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "religion_description");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"religion_id");
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

      $arrfield=array("religion_description", "religion_name", "isactive","seqno",
            "updated","updatedby");
      $arrfieldtype=array('%s','%s','%d','%d','%s','%d');
 // Yes there are UPDATEs to perform...

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
         $this->log->showLog(3,"***updating record($currentRecord),new religion_name:".
                $saveHandler->ReturnUpdateField($currentRecord, "religion_name").",id:".
                $saveHandler->ReturnUpdateField($currentRecord)."\n");
                $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "religion_description");

 }

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "religion_description"),
                $saveHandler->ReturnUpdateField($currentRecord, "religion_name"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"seqno"),
                $timestamp,
                $createdby
                );
        $this->log->showLog(3,"***updating record($currentRecord),new religion_name:".
              $saveHandler->ReturnUpdateField($currentRecord, "religion_name").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"religion_id")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "religion_description");

         $save->UpdateRecord($tablename, "religion_id", $saveHandler->ReturnUpdateField($currentRecord,"religion_id"),
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
//include "class/Religion.inc.php";
//$o = new Religion();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $this->fetchReligion($record_id);
    $controlvalue=$this->religion_description;
    $isdeleted=$this->isdeleted;

    $save->DeleteRecord("sim_religion","religion_id",$record_id,$controlvalue,1);
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

public function showLookupReligion(){
        $this->log->showLog(2,"Run lookup showReligion()");
        $tablename="sim_religion";
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="religion_description";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  religion_id, religion_description, religion_name, isactive,seqno
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
    $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["religion_id"]);
                       $getHandler->DefineRecordFieldValue("religion_id", $row["religion_id"]);
                       $getHandler->DefineRecordFieldValue("religion_name", $row["religion_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }
$getHandler->completeGet();
    }
} // end of ClassReligion
?>

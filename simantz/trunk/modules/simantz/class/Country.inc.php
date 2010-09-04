<?php


class Country
{

  public $country_id;
  public $country_name;
  public $country_code;
  public $organization_id;
  public $isactive;
  public $islecturer;
  public $isovertime;
  public $isfulltime;
  public $isparttime;
  public $citizenship;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tablecountry;
  private $tablebpartner;

  private $log;


//constructor
   public function Country(){
	global $xoopsDB,$log,$tablecountry,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport,$defaultorganization_id;
        $this->defaultorganization_id=$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablecountry=$tablecountry;
	$this->tablebpartner=$tablebpartner;
	$this->tabledailyreport=$tabledailyreport;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type
   * @param int country_id
   * @return
   * @access public
   */

  public function fetchCountry($country_id) {
	$this->log->showLog(3,"Fetching country detail into class Country.php.<br>");

	$sql="SELECT * from $this->tablecountry where country_id=$country_id";

	$this->log->showLog(4,"ProductCountry->fetchCountry, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->country_name=$row["country_name"];
		$this->country_code=$row["country_code"];
		$this->organization_id=$row['organization_id'];
		$this->seqno= $row['seqno'];
		$this->citizenship=$row['citizenship'];
		$this->isactive=$row['isactive'];
		$this->citizenship=$row['citizenship'];
   	$this->log->showLog(4,"Country->fetchCountry,database fetch into class successfully");
	$this->log->showLog(4,"country_name:$this->country_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	//$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Country->fetchCountry,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchCountry

  public function fetchRegion($region_id) {
	$this->log->showLog(3,"Fetching region detail into class Country.php.<br>");

	$sql="SELECT * from sim_region where region_id=$region_id";

	$this->log->showLog(4,"ProductRegion->fetchRegion, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->region_name=$row["region_name"];
		$this->organization_id=$row['organization_id'];
		$this->seqno= $row['seqno'];
		$this->isactive=$row['isactive'];

   	$this->log->showLog(4,"region->fetchRegion,database fetch into class successfully");
	$this->log->showLog(4,"region_name:$this->region_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	//$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Country->fetchCountry,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchCountry
/*
 *public function getNextSeqNo() {
 *
 *	$sql="SELECT MAX(seqno) + 10 as seqno from $this->tablecountry;";
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
       <form name="frmCountry">

    <div align="center" class="searchformheader">Search Employee Group</div>

            <div class="divfield">Employee Group No<br/>
			<input name="searchcountry_code" id="searchcountry_code"></div>

            <div  class="divfield">Employee Group Name<br/>
			<input name="searchcountry_name" id="searchcountry_name"></div>

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

 public function showCountry($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    $tablename="sim_country";
    $searchcountry_code=$_GET['searchcountry_code'];
    $searchcountry_name=$_GET['searchcountry_name'];
    $searchisactive=$_GET['searchisactive'];

   $this->log->showLog(2,"Access ShowCountry($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="seqno, country_name";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

     if($searchcountry_code !="")
           $wherestring.= " AND country_code LIKE '".$searchcountry_code."'";
     if($searchcountry_name !="")
           $wherestring.= " AND country_name LIKE '".$searchcountry_name."'";
    // if($searchisactive !="-")
         //  $wherestring.= " AND isactive =$searchisactive";


     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("country_code");
     	$getHandler->DefineField("country_name");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("seqno");
        $getHandler->DefineField("info");
        $getHandler->DefineField("citizenship");
        $getHandler->DefineField("country_id");
        $getHandler->DefineField("telcode");
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
             $getHandler->CreateNewRecord($row['country_id']);
             $getHandler->DefineRecordFieldValue("country_code", $row['country_code']);
             $getHandler->DefineRecordFieldValue("country_name",$row['country_name']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("seqno", $row['seqno']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['country_id']."&tablename=sim_country&idname=country_id&title=Country");
             $getHandler->DefineRecordFieldValue("citizenship",$row['citizenship']);
             $getHandler->DefineRecordFieldValue("telcode",$row['telcode']);
             $getHandler->DefineRecordFieldValue("country_id",$row['country_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showCountry()");
    }

 public function saveCountry(){
    $this->log->showLog(2,"Access saveCountry");
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
    $tablename="sim_country";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
    $arrfield=array("country_code", "country_name","isactive","seqno",
                    "created","createdby","updated","updatedby","citizenship","organization_id","telcode");
    $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s','%d','%s','%d','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "country_code"),
                $saveHandler->ReturnInsertField($currentRecord, "country_name"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $saveHandler->ReturnInsertField($currentRecord,"citizenship"),
                $organization_id, $saveHandler->ReturnInsertField($currentRecord,"telcode"));

     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "country_code");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"country_id");
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

      $arrfield=array("country_code", "country_name", "isactive","seqno",
            "updated","updatedby","citizenship","telcode");
      $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s','%d');
 // Yes there are UPDATEs to perform...

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
         $this->log->showLog(3,"***updating record($currentRecord),new country_name:".
                $saveHandler->ReturnUpdateField($currentRecord, "country_name").",id:".
                $saveHandler->ReturnUpdateField($currentRecord)."\n");
                $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "country_code");

 }

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "country_code"),
                $saveHandler->ReturnUpdateField($currentRecord, "country_name"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"citizenship"),
                $saveHandler->ReturnUpdateField($currentRecord,"telcode"));
                
        $this->log->showLog(3,"***updating record($currentRecord),new country_name:".
              $saveHandler->ReturnUpdateField($currentRecord, "country_name").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"country_id")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "country_code");

         $save->UpdateRecord($tablename, "country_id", $saveHandler->ReturnUpdateField($currentRecord,"country_id"),
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
//include "class/Country.inc.php";
//$o = new Country();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $this->fetchCountry($record_id);
    $controlvalue=$this->country_code;
    $isdeleted=$this->isdeleted;

    $save->DeleteRecord("sim_country","country_id",$record_id,$controlvalue,1);
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

 public function allowDelete($country_id){

	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where country_id = $country_id or last_country = $country_id or next_country = $country_id ";
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

 public function showRegion($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    $tablename="sim_region";
    $country_id=$_GET['country_id'];


   $this->log->showLog(2,"Access ShowCountry($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="seqno, region_name";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

     $wherestring.= " AND country_id =".$country_id;


     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("region_name");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("seqno");
        $getHandler->DefineField("info");
        $getHandler->DefineField("country_id");
        $getHandler->DefineField("region_id");
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
             $getHandler->CreateNewRecord($row['region_id']);
             $getHandler->DefineRecordFieldValue("region_name", $row['region_name']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("seqno", $row['seqno']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['region_id']."&tablename=sim_region&idname=region_id&title=Region");
             $getHandler->DefineRecordFieldValue("country_id",$row['country_id']) ;
             $getHandler->DefineRecordFieldValue("region_id",$row['region_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showRegion()");
    }

 public function saveRegion(){
    $this->log->showLog(2,"Access saveRegion");
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
        $tablename="sim_region";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
    $arrfield=array("country_id", "region_name","isactive","seqno",
                    "created","createdby","updated","updatedby","organization_id");
    $arrfieldtype=array('%d','%s','%d','%d','%s','%d','%s','%d','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "country_id"),
                $saveHandler->ReturnInsertField($currentRecord, "region_name"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $organization_id);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "region_name");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"region_name");
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

      $arrfield=array("region_name", "isactive","seqno",
            "updated","updatedby");
      $arrfieldtype=array('%s','%d','%d','%s','%d');
 // Yes there are UPDATEs to perform...

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
         $this->log->showLog(3,"***updating record($currentRecord),new region_name:".
                $saveHandler->ReturnUpdateField($currentRecord, "region_name").",id:".
                $saveHandler->ReturnUpdateField($currentRecord, "region_id")."\n");
                $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "region_name");

 }

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "region_name"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"seqno"),
                $timestamp,
                $createdby);
        $this->log->showLog(3,"***updating record($currentRecord),new region_name:".
              $saveHandler->ReturnUpdateField($currentRecord, "region_name").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"region_id")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "region_name");

         $save->UpdateRecord($tablename, "region_id", $saveHandler->ReturnUpdateField($currentRecord,"region_id"),
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
//include "class/Country.inc.php";
//$o = new Country();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $this->fetchRegion($record_id);
    $controlvalue=$this->region_name;
    $isdeleted=$this->isdeleted;

    $save->DeleteRecord("sim_region","region_id",$record_id,$controlvalue,1);
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

 public function showLookupCountry(){
        $this->log->showLog(2,"Run lookup showCountry()");
        $tablename="sim_country";
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="country_code";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  country_id, country_code, country_name, isactive,seqno
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
    $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["country_id"]);
                       $getHandler->DefineRecordFieldValue("country_id", $row["country_id"]);
                       $getHandler->DefineRecordFieldValue("country_name", $row["country_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }
$getHandler->completeGet();
    }
} // end of ClassCountry
?>

<?php


class Currency
{

  public $currency_id;
  public $currency_name;
  public $currency_code;
  public $organization_id;
  public $isactive;
  public $islecturer;
  public $isovertime;
  public $isfulltime;
  public $isparttime;
  public $country_id;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tablecurrency;
  private $tablebpartner;

  private $log;


//constructor
   public function Currency(){
	global $xoopsDB,$log,$tablecurrency,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport,$defaultorganization_id;
        $this->defaultorganization_id=$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablecurrency=$tablecurrency;
	$this->tablebpartner=$tablebpartner;
	$this->tabledailyreport=$tabledailyreport;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type
   * @param int currency_id
   * @return
   * @access public
   */

  public function fetchCurrency($currency_id)
  {
	$this->log->showLog(3,"Fetching currency detail into class Currency.php.<br>");

	$sql="SELECT * from $this->tablecurrency where currency_id=$currency_id";

	$this->log->showLog(4,"ProductCurrency->fetchCurrency, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->currency_name=$row["currency_name"];
		$this->currency_code=$row["currency_code"];
		$this->organization_id=$row['organization_id'];
		$this->seqno= $row['seqno'];
		$this->country_id=$row['country_id'];
		$this->isactive=$row['isactive'];
		$this->islecturer=$row['islecturer'];
		$this->isovertime=$row['isovertime'];
		//$this->isfulltime=$row['isfulltime'];
		$this->isdeleted=$row['isdeleted'];
                $this->isparttime=$row['isparttime'];
		$this->country_id=$row['country_id'];
   	$this->log->showLog(4,"Currency->fetchCurrency,database fetch into class successfully");
	$this->log->showLog(4,"currency_name:$this->currency_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	//$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Currency->fetchCurrency,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchCurrency
/*
 *public function getNextSeqNo() {
 *
 *	$sql="SELECT MAX(seqno) + 10 as seqno from $this->tablecurrency;";
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
       <form name="frmCurrency">

    <div align="center" class="searchformheader">Search Employee Group</div>

            <div class="divfield">Employee Group No<br/>
			<input name="searchcurrency_code" id="searchcurrency_code"></div>

            <div  class="divfield">Employee Group Name<br/>
			<input name="searchcurrency_name" id="searchcurrency_name"></div>

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

 public function showCurrency($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    $tablename="sim_currency";
    $searchcurrency_code=$_GET['searchcurrency_code'];
    $searchcurrency_name=$_GET['searchcurrency_name'];
    $searchisactive=$_GET['searchisactive'];
    $searchisdeleted=$_GET['searchisdeleted'];
   $this->log->showLog(2,"Access ShowCurrency($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="currency_code";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
     if($isadmin!=1)
        $wherestring.= " AND isdeleted=0";
  //   else
   //         $wherestring.= " AND isdeleted=1";
     if($searchcurrency_code !="")
           $wherestring.= " AND currency_code LIKE '".$searchcurrency_code."'";
     if($searchcurrency_name !="")
           $wherestring.= " AND currency_name LIKE '".$searchcurrency_name."'";
    // if($searchisactive !="-")
         //  $wherestring.= " AND isactive =$searchisactive";


     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("currency_code");
     	$getHandler->DefineField("currency_name");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("seqno");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
        $getHandler->DefineField("country_id");
        $getHandler->DefineField("currency_id");
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
             $getHandler->CreateNewRecord($row['currency_id']);
             $getHandler->DefineRecordFieldValue("currency_code", $row['currency_code']);
             $getHandler->DefineRecordFieldValue("currency_name",$row['currency_name']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("seqno", $row['seqno']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['currency_id']."&tablename=sim_currency&idname=currency_id&title=Currency");
             $getHandler->DefineRecordFieldValue("country_id",$row['country_id']);
             $getHandler->DefineRecordFieldValue("currency_id",$row['currency_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showCurrency()");
    }

 public function saveCurrency(){
    $this->log->showLog(2,"Access saveCurrency");
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
    $tablename="sim_currency";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
    $arrfield=array("currency_code", "currency_name","isactive","seqno",
                    "created","createdby","updated","updatedby","country_id");
    $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s','%d','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "currency_code"),
                $saveHandler->ReturnInsertField($currentRecord, "currency_name"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $saveHandler->ReturnInsertField($currentRecord,"country_id")
         );

     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "currency_code");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"currency_id");
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

      $arrfield=array("currency_code", "currency_name", "isactive","seqno",
            "isdeleted","updated","updatedby","country_id");
      $arrfieldtype=array('%s','%s','%d','%d','%d','%s','%d','%d');
 // Yes there are UPDATEs to perform...

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
         $this->log->showLog(3,"***updating record($currentRecord),new currency_name:".
                $saveHandler->ReturnUpdateField($currentRecord, "currency_name").",id:".
                $saveHandler->ReturnUpdateField($currentRecord)."\n");
                $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "currency_code");

 }

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "currency_code"),
                $saveHandler->ReturnUpdateField($currentRecord, "currency_name"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"seqno"),
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"country_id"),
                );
        $this->log->showLog(3,"***updating record($currentRecord),new currency_name:".
              $saveHandler->ReturnUpdateField($currentRecord, "currency_name").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"currency_id")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "currency_code");

         $save->UpdateRecord($tablename, "currency_id", $saveHandler->ReturnUpdateField($currentRecord,"currency_id"),
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


if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $this->fetchCurrency($record_id);
    $controlvalue=$this->currency_code;
    $isdeleted=$this->isdeleted;

    if($this->allowDelete($record_id))
    $save->DeleteRecord("sim_currency","currency_id",$record_id,$controlvalue,1);
    else
    $save->failfeedback.="Cannot delete currency: $controlvalue <br/>";

  }

  }



  $saveHandler->setErrorMessage($this->failfeedback);

$saveHandler->CompleteSave();

}

 public function allowDelete($currency_id){

	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where currency_id = $currency_id or last_currency = $currency_id or next_currency = $currency_id ";
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

} // end of ClassCurrency
?>

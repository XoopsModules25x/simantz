<?php


class Period
{

  public $jobposition_id;
  public $jobposition_name;
  public $jobposition_no;
  public $department_id;
  public $organization_id;
  public $isactive;
  public $description;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tablejobposition;
  private $tablebpartner;

  private $log;


//constructor
   public function Period(){
	global $xoopsDB,$log,$defaultorganization_id;
        $this->defaultorganization_id=$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
        $this->tablejobposition="sim_hr_jobposition";
	$this->log=$log;
   }
 
  public function fetchPeriod( $period_id) {
	$this->log->showLog(3,"Fetching period detail into class Period.php.");
	$sql="SELECT period_id,period_name,period_year,period_month,isactive,defaultlevel,isdeleted from sim_period
			where period_id=$period_id";
	$this->log->showLog(4,"Period->fetchPeriod, before execute:" . $sql . "<br>");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->period_name=$row["period_name"];
		$this->period_month=$row["period_month"];
		$this->period_year=$row["period_year"];
		$this->defaultlevel= $row['defaultlevel'];
                $this->isdeleted=$row['isdeleted'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"Period->fetchPeriod,database fetch into class successfully");
	$this->log->showLog(4,"period_name:$this->period_name");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Period->fetchPeriod,failed to fetch data into databases:" . mysql_error());
	}
  } // end of member function fetchPeriod

 public function showSearchForm(){

  global $isadmin;

//  if($isadmin==1)
//  $showdeleted="<input type=\"checkbox\" name=\"searchisdeleted\" id=\"searchisdeleted\" onchange=\"hideadd()\">".
//        "<a onclick=document.getElementById(\"searchisdeleted\").click() title=\"Show deleted records.\">Show Deleted Only</a>";
  
  echo <<< EOF
<table style="width:100%;" > 
 <tr>
  <td align="center">

<table id='centercontainer' class="searchformblock" style="width:943px;">
 <tr><td nowrap>
       <form name="frmJobposition">

    <div align="center" class="searchformheader">Search Period</div>

           <div class="divfield" style="width:250px"><label>Period Year &nbsp;
			<input name="searchperiod_year" id="searchperiod_year" ></label></div>

            <div class="divfield" style="width:250px"><label>Period Name &nbsp;
			<input name="searchperiod_name" id="searchperiod_name" ></label></div>

	    <div class="divfield" style="width:120px"> <label>Active &nbsp;
                <select name="searchisactive" id="searchisactive">
                    <option value="-">Null</option>
                    <option value="1" SELECTED="SELECTED">Yes</option>
                    <option value="0">No</option>
                </select></label></div>
           <div class="divfield" style="text-align:right; width:160px"> <input name="submit" value="Search" type="button" onclick="search()"></div>
</form>
 </td></tr>
</table>

</td></tr></table>

EOF;
}

 public function showPeriod($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    $tablename="sim_period";
    $searchperiod_year=$_GET['searchperiod_year'];
    $searchperiod_name=$_GET['searchperiod_name'];
    $searchisactive=$_GET['searchisactive'];

   $this->log->showLog(2,"Access ShowPeriod($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="seqno, period_name";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

     if($searchperiod_year !="")
           $wherestring.= " AND period_year LIKE '".$searchperiod_year."'";
     if($searchperiod_name !="")
           $wherestring.= " AND period_name LIKE '%".$searchperiod_name."%'";
     if($searchisactive !="-" && $searchisactive !="")
           $wherestring.= " AND isactive =$searchisactive";


     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("period_year");
     	$getHandler->DefineField("period_name");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("seqno");
        $getHandler->DefineField("info");
        $getHandler->DefineField("period_month");
        $getHandler->DefineField("period_id");
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
             $getHandler->CreateNewRecord($row['period_id']);
             $getHandler->DefineRecordFieldValue("period_year", $row['period_year']);
             $getHandler->DefineRecordFieldValue("period_name",$row['period_name']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("seqno", $row['seqno']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['period_id']."&tablename=sim_period&idname=period_id&title=Period");
             $getHandler->DefineRecordFieldValue("period_month",$row['period_month']);
             $getHandler->DefineRecordFieldValue("period_id",$row['period_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showPeriod()");
    }

 public function savePeriod(){
    $this->log->showLog(2,"Access savePeriod");
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
       $tablename="sim_period";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
    $arrfield=array("period_year", "period_name","isactive","seqno",
                    "created","createdby","updated","updatedby","period_month");
    $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s','%d','%s');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "period_year"),
                $saveHandler->ReturnInsertField($currentRecord, "period_name"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $saveHandler->ReturnInsertField($currentRecord,"period_month")
         );
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "period_year");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"period_id");
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

      $arrfield=array("period_year", "period_name", "isactive","seqno",
           "updated","updatedby","period_month");
      $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s');
 // Yes there are UPDATEs to perform...

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
         $this->log->showLog(3,"***updating record($currentRecord),new period_name:".
                $saveHandler->ReturnUpdateField($currentRecord, "period_name").",id:".
                $saveHandler->ReturnUpdateField($currentRecord)."\n");
                $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "period_year");

 }

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "period_year"),
                $saveHandler->ReturnUpdateField($currentRecord, "period_name"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"period_month"),
                );
        $this->log->showLog(3,"***updating record($currentRecord),new period_name:".
              $saveHandler->ReturnUpdateField($currentRecord, "period_name").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"period_id")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "period_year");

         $save->UpdateRecord($tablename, "period_id", $saveHandler->ReturnUpdateField($currentRecord,"period_id"),
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
//include "class/Period.inc.php";
//$o = new Period();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $this->fetchPeriod($record_id);
    $controlvalue=$this->period_year;
    $isdeleted=$this->isdeleted;

    $save->DeleteRecord("sim_period","period_id",$record_id,$controlvalue,1);

  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }
  }

  }
//$this->failfeedback.="asdasdpasd<br/>\n";
//$this->failfeedback.="123 3443<br/>\n";
//$this->failfeedback.="234 45656523 234<br/>\n";
//if($this->failfeedback!="")
//    $this->failfeedback .= $this->failfeedback."\n";



  $saveHandler->setErrorMessage($this->failfeedback);
//$this->failfeedback.="Warning!<br/>\n".$this->failfeedback;

$saveHandler->CompleteSave();

}

public function showLookupPeriod(){
        $this->log->showLog(2,"Run lookup showPeriod()");
        $tablename="sim_period";
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="period_year";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  period_id, period_year, period_name, isactive,seqno
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
    $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["period_id"]);
                       $getHandler->DefineRecordFieldValue("period_id", $row["period_id"]);
                       $getHandler->DefineRecordFieldValue("period_name", $row["period_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }
$getHandler->completeGet();
    }

  public function getPeriodArray($periodfrom_id,$periodto_id){
           $this->fetchPeriod($periodfrom_id);
            $periodfrom=$this->period_name;

           $this->fetchPeriod($periodto_id);
           $periodto=$this->period_name;

        $sql="SELECT period_id,period_name from $this->tableperiod
                where period_name between '$periodfrom' and '$periodto' order by period_name ASC";
          $query=$this->xoopsDB->query($sql);
          $data=array();
          while($row=$this->xoopsDB->fetchArray($query))
          $data[]=$row['period_id'];
	return $data;
       }

  public function getPeriodID($year,$month){
        $sql="SELECT period_id from $this->tableperiod
                where period_year =$year and period_month=$month order by period_name ASC";
          $query=$this->xoopsDB->query($sql);
          $data=array();
          while($row=$this->xoopsDB->fetchArray($query))
          return $row['period_id'];
	return 0;
       }
 
} // end of ClassJobposition
?>

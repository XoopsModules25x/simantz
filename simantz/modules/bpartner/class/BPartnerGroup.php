<?php


class BPartnerGroup
{

  public $bpartnergroup_id;
  public $bpartnergroup_name;
  public $description;
  public $organization_id;
  public $isactive;
  public $isdeleted;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;

  public $orgctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tablejobposition;
  private $tablebpartner;

  private $log;


//constructor
   public function BPartnerGroup(){
	global $xoopsDB,$log,$defaultorganization_id;
        $this->defaultorganization_id=$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
        $this->tablebpartnergroup="sim_bpartnergroup";
	$this->log=$log;
   }

  public function fetchBPartnerGroup($bpartnergroup_id) {


	$this->log->showLog(3,"Fetching bpartnergroup detail into class BPartnerGroup.php.<br>");

	$sql="SELECT * from $this->tablebpartnergroup where bpartnergroup_id=$bpartnergroup_id";

	$this->log->showLog(4,"ProductBpartnergroup->fetchBPartnergroup, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->jobposition_name=$row["bpartnergroup_name"];
		$this->organization_id=$row['organization_id'];
		$this->seqno= $row['seqno'];
		$this->isactive=$row['isactive'];
		$this->isdeleted=$row['isdeleted'];
		$this->description=$row['description'];

   	$this->log->showLog(4,"bpartnergroup->fetchBPartnergroup,database fetch into class successfully");
	$this->log->showLog(4,"bpartnergroup Name:$this->bpartnergroup_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	//$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"bpartnergroup->fetchbpartnergroup,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchJobposition

  public function showSearchForm(){

  global $isadmin;

//  if($isadmin==1)
//  $showdeleted="<input type=\"checkbox\" name=\"searchisdeleted\" id=\"searchisdeleted\" onchange=\"hideadd()\">".
//        "<a onclick=document.getElementById(\"searchisdeleted\").click() title=\"Show deleted records.\">Show Deleted Only</a>";

  echo <<< EOF
   <br>
          <form name="frmBPartnergroup">
<table style="width:100%;" >
 <tr>
  <td align="center" >

<table id='centercontainer' class="searchformblock" style="width:943px;">
 <tr><td nowrap>

    <div align="center" class="searchformheader">Search Business Partner Group</div>

            <div class="divfield">Group Name
			<input name="searchbpartnergroup_name" id="searchbpartnergroup_name"></div>

           <div class="divfield"> Active
                <select name="searchisactive" id="searchisactive">
                    <option value="-" SELECTED="SELECTED">Null</option>
                    <option value="1" >Yes</option>
                    <option value="0">No</option>
                </select></div>

           <div class="divfield" align="right"><input name="submit" value="Search" type="button" onclick="search()"> <input name="resetbtn" value="Reset" type="reset" onclick="resetsearch()"></div>


 </td></tr>
</table>


</td></tr></table>
</form>
EOF;
}

  public function showBPartnerGroup($wherestring){
    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();
    $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin,$defaultorganization_id;

    $tablename="sim_bpartnergroup";
    $searchbpartnergroup_name=$_GET['searchbpartnergroup_name'];
    $searchisactive=$_GET['searchisactive'];

    $this->log->showLog(2,"Access showBPartnerGroup($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="seqno,bpartnergroup_name ";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

       if($searchisactive !="-" && $searchisactive !="" )
          $wherestring.= " AND isactive =$searchisactive";


     if($searchbpartnergroup_name !="")
           $wherestring.= " AND bpartnergroup_name LIKE '%".$searchbpartnergroup_name."%'";
     
           $wherestring.= " AND organization_id =$defaultorganization_id";
     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
     	$getHandler->DefineField("bpartnergroup_name");
     	$getHandler->DefineField("description");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("seqno");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
        $getHandler->DefineField("bpartnergroup_id");
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
             $getHandler->CreateNewRecord($row['bpartnergroup_id']);
             $getHandler->DefineRecordFieldValue("bpartnergroup_name",$row['bpartnergroup_name']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("seqno", $row['seqno']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['bpartnergroup_id']."&tablename=sim_bpartnergroup&idname=bpartnergroup_id&title=Business Partner Group");
             $getHandler->DefineRecordFieldValue("description",$row['description']);
             $getHandler->DefineRecordFieldValue("bpartnergroup_id",$row['bpartnergroup_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showBPartnerGroup()");
    }

  public function saveBPartnerGroup(){
    $this->log->showLog(2,"Access saveBPartnerGroup");
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
        $tablename="sim_bpartnergroup";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
      $arrfield=array("bpartnergroup_name","isactive","seqno","created","createdby","updated","updatedby","organization_id","description");
      $arrfieldtype=array('%s','%d','%d','%s','%d','%s','%d','%d','%s');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array(
                $saveHandler->ReturnInsertField($currentRecord, "bpartnergroup_name"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $organization_id,
                $saveHandler->ReturnInsertField($currentRecord,"description"));
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "bpartnergroup_name");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"bpartnergroup_id");
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

      $arrfield=array("bpartnergroup_name","isactive","seqno","updated","updatedby","description");
      $arrfieldtype=array('%s','%d','%d','%s','%d','%s');
 // Yes there are UPDATEs to perform...

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
         $this->log->showLog(3,"***updating record($currentRecord),new bpartnergroup_name:".
                $saveHandler->ReturnUpdateField($currentRecord, "bpartnergroup_name").",id:".
                $saveHandler->ReturnUpdateField($currentRecord)."\n");
                $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "bpartnergroup_id");

 }

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array(
                $saveHandler->ReturnUpdateField($currentRecord, "bpartnergroup_name"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"description"));

        $this->log->showLog(3,"***updating record($currentRecord),new bpartnergroup_name:".
              $saveHandler->ReturnUpdateField($currentRecord, "bpartnergroup_name").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"bpartnergroup_id")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "bpartnergroup_name");

         $save->UpdateRecord($tablename, "bpartnergroup_id", $saveHandler->ReturnUpdateField($currentRecord,"bpartnergroup_id"),
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

    $this->fetchBPartnerGroup($record_id);
    $controlvalue=$this->bpartnergroup_name;
    $isdeleted=$this->isdeleted;

    $save->DeleteRecord("sim_bpartnergroup","bpartnergroup_id",$record_id,$controlvalue,1);
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


} // end of ClassJobposition
?>

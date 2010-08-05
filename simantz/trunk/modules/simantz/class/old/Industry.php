<?php


class Industry
{

  public $industry_id;
  public $industry_name;
  public $description;
  public $organization_id;
  public $isactive;
  public $isdeleted;
  public $defaultlevel;
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
   public function Industry(){
	global $xoopsDB,$log,$defaultorganization_id;
        $this->defaultorganization_id=$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
        $this->tableindustry="sim_industry";
	$this->log=$log;
   }
 
  public function fetchIndustry($industry_id) {


	$this->log->showLog(3,"Fetching industry detail into class Industry.php.<br>");
		
	$sql="SELECT * from $this->tableindustry where industry_id=$industry_id";
	
	$this->log->showLog(4,"ProductIndustry->fetchIndustry, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->jobposition_name=$row["industry_name"];
		$this->organization_id=$row['organization_id'];
		$this->defaultlevel= $row['defaultlevel'];
		$this->isactive=$row['isactive'];
		$this->isdeleted=$row['isdeleted'];
		$this->description=$row['description'];
        
   	$this->log->showLog(4,"Industry->fetchIndustry,database fetch into class successfully");
	$this->log->showLog(4,"Industry Name:$this->industry_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	//$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Industry->fetchIndustry,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchJobposition

  public function showSearchForm(){

  global $isadmin;

//  if($isadmin==1)
//  $showdeleted="<input type=\"checkbox\" name=\"searchisdeleted\" id=\"searchisdeleted\" onchange=\"hideadd()\">".
//        "<a onclick=document.getElementById(\"searchisdeleted\").click() title=\"Show deleted records.\">Show Deleted Only</a>";
  
  echo <<< EOF
<table style="width:100%;" > 
 <tr>
  <td align="center" >

<div id='centercontainer' class="searchformblock" style="width:943px;">
       <form name="frmJobposition">

    <div align="center" class="searchformheader">Search Industry</div>

            <div class="divfield">Industry Name
			<input name="searchjobposition_no" id="searchindustry_name"></div>

           <div class="divfield"> Active
                <select name="searchisactive" id="searchisactive">
                    <option value="-">Null</option>
                    <option value="1" SELECTED="SELECTED">Yes</option>
                    <option value="0">No</option>
                </select></div>
           <div align="right"><input name="submit" value="Search" type="button" onclick="search()">&nbsp;</div>
</form>
    </div>

</td></tr></table>

EOF;
}

  public function showIndustry($wherestring){
    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();
    $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;
      
    $tablename="sim_industry";
    $searchindustry_name=$_GET['searchindustry_name'];
    $searchisactive=$_GET['searchisactive'];
    $searchisdeleted=$_GET['searchisdeleted'];
    $this->log->showLog(2,"Access showIndustry($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="defaultlevel";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
        
     if($searchisdeleted!="true")
           $wherestring.= " AND isdeleted=0";
     else
            $wherestring.= " AND isdeleted=1";

     if($searchindustry_name !="")
           $wherestring.= " AND industry_name LIKE '%".$searchindustry_name."%'";

    if($searchisactive !="-")
          $wherestring.= " AND isactive =$searchisactive";


     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);
        
        $getHandler->ProcessRecords();
     	$getHandler->DefineField("industry_name");
     	$getHandler->DefineField("description");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("defaultlevel");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
        $getHandler->DefineField("industry_id");
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
             $getHandler->CreateNewRecord($row['industry_id']);
             $getHandler->DefineRecordFieldValue("industry_name",$row['industry_name']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("defaultlevel", $row['defaultlevel']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);             
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['industry_id']."&tablename=sim_industry&idname=industry_id&title=Industry");
             $getHandler->DefineRecordFieldValue("description",$row['description']);  
             $getHandler->DefineRecordFieldValue("industry_id",$row['industry_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showIndustry()");
    }

  public function saveIndustry(){
    $this->log->showLog(2,"Access saveIndustry");
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
        $tablename="sim_industry";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
      $arrfield=array("industry_name","isactive","defaultlevel","created","createdby","updated","updatedby","organization_id","description");
      $arrfieldtype=array('%s','%d','%d','%s','%d','%s','%d','%d','%s');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array(
                $saveHandler->ReturnInsertField($currentRecord, "industry_name"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $organization_id,
                $saveHandler->ReturnInsertField($currentRecord,"description"));
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "industry_name");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"industry_id");
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

      $arrfield=array("industry_name","isactive","defaultlevel","updated","updatedby","organization_id","description");
      $arrfieldtype=array('%s','%d','%d','%s','%d','%d','%s');
 // Yes there are UPDATEs to perform...

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
         $this->log->showLog(3,"***updating record($currentRecord),new industry_name:".
                $saveHandler->ReturnUpdateField($currentRecord, "industry_name").",id:".
                $saveHandler->ReturnUpdateField($currentRecord)."\n");
                $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "jobposition_id");
         
 }

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array(
                $saveHandler->ReturnUpdateField($currentRecord, "industry_name"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"defaultlevel"),
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"description"));
        
        $this->log->showLog(3,"***updating record($currentRecord),new industry_name:".
              $saveHandler->ReturnUpdateField($currentRecord, "industry_name").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"industry_id")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "industry_name");
          
         $save->UpdateRecord($tablename, "industry_id", $saveHandler->ReturnUpdateField($currentRecord,"industry_id"),
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

    $this->fetchIndustry($record_id);
    $controlvalue=$this->industry_name;
    $isdeleted=$this->isdeleted;

    $save->DeleteRecord("sim_industry","industry_id",$record_id,$controlvalue,$isdeleted);
 
  }

  }

if($this->failfeedback!="")
$this->failfeedback="Warning!<br/>\n".$this->failfeedback;
$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();

}

  public function allowDelete($industry_id){
	
	$rowcount=0;
	$sql = "select count(*) as rowcount from $this->tabledailyreport where jobposition_id = $jobposition_id or last_jobposition = $jobposition_id or next_jobposition = $jobposition_id ";
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
 
} // end of ClassJobposition
?>

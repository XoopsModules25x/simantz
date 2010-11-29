<?php


class User
{

  public $uid;
  public $name;
  public $uname;
  public $email;
  public $pass;
  public $user_user_isactive;
  
  private $xoopsDB;
  private $tableprefix;
  private $tablejobposition;
  private $tablebpartner;

  private $log;


//constructor
   public function User(){
	global $xoopsDB,$log;
  	$this->xoopsDB=$xoopsDB;
        $this->tablename="sim_users";
	$this->log=$log;
   }
 
  public function fetchUser( $uid) {
	$this->log->showLog(3,"Fetching period detail into class User.php.");
	 $sql="SELECT uid,uname,name,email,user_isactive,pass from sim_users
			where uid=$uid";
	$this->log->showLog(4,"User->fetchUser, before execute:" . $sql . "<br>");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->uname=$row["uname"];
		$this->email=$row["email"];
		$this->name=$row["name"];
		$this->pass= $row['pass'];
                $this->isdeleted=$row['isdeleted'];
		$this->user_isactive=$row['user_isactive'];
   	$this->log->showLog(4,"User->fetchUser,database fetch into class successfully");
	$this->log->showLog(4,"uname:$this->uname");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"User->fetchUser,failed to fetch data into databases:" . mysql_error());
	}
  } // end of member function fetchUser

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

    <div align="center" class="searchformheader">Search User</div>

           <div class="divfield" style="width:250px"><label>User Year &nbsp;
			<input name="searchname" id="searchname" ></label></div>

            <div class="divfield" style="width:250px"><label>User Name &nbsp;
			<input name="searchuname" id="searchuname" ></label></div>

	    <div class="divfield" style="width:120px"> <label>Active &nbsp;
                <select name="searchuser_isactive" id="searchuser_isactive">
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

 public function showUser($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    $tablename="sim_users";
    $searchname=$_GET['searchname'];
    $searchuname=$_GET['searchuname'];
    $searchuser_isactive=$_GET['searchuser_isactive'];

   $this->log->showLog(2,"Access ShowUser($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="pass, uname";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

     if($searchname !="")
           $wherestring.= " AND name LIKE '".$searchname."'";
     if($searchuname !="")
           $wherestring.= " AND uname LIKE '%".$searchuname."%'";
     if($searchuser_isactive !="-" && $searchuser_isactive !="")
           $wherestring.= " AND user_isactive =$searchuser_isactive";


     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("name");
     	$getHandler->DefineField("uname");
     	$getHandler->DefineField("user_isactive");
        $getHandler->DefineField("pass");
        $getHandler->DefineField("info");
        $getHandler->DefineField("email");
        $getHandler->DefineField("uid");
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
             $getHandler->CreateNewRecord($row['uid']);
             $getHandler->DefineRecordFieldValue("name", $row['name']);
             $getHandler->DefineRecordFieldValue("uname",$row['uname']);
             $getHandler->DefineRecordFieldValue("user_isactive", $row['user_isactive']);
             $getHandler->DefineRecordFieldValue("pass", $row['pass']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['uid']."&tablename=sim_users&idname=uid&title=User");
             $getHandler->DefineRecordFieldValue("email",$row['email']);
             $getHandler->DefineRecordFieldValue("uid",$row['uid']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showUser()");
    }

 public function saveUser(){
    $this->log->showLog(2,"Access saveUser");
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
       $tablename="sim_users";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
    $arrfield=array("name", "uname","user_isactive","pass",
                    "created","createdby","updated","updatedby","email");
    $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s','%d','%s');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "name"),
                $saveHandler->ReturnInsertField($currentRecord, "uname"),
                $saveHandler->ReturnInsertField($currentRecord,"user_isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"pass"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $saveHandler->ReturnInsertField($currentRecord,"email")
         );
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "name");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"uid");
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

      $arrfield=array("name", "uname", "user_isactive","pass",
           "updated","updatedby","email");
      $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s');
 // Yes there are UPDATEs to perform...

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
         $this->log->showLog(3,"***updating record($currentRecord),new uname:".
                $saveHandler->ReturnUpdateField($currentRecord, "uname").",id:".
                $saveHandler->ReturnUpdateField($currentRecord)."\n");
                $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "name");

 }

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "name"),
                $saveHandler->ReturnUpdateField($currentRecord, "uname"),
                $saveHandler->ReturnUpdateField($currentRecord,"user_isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"pass"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"email"),
                );
        $this->log->showLog(3,"***updating record($currentRecord),new uname:".
              $saveHandler->ReturnUpdateField($currentRecord, "uname").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"uid")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "name");

         $save->UpdateRecord($tablename, "uid", $saveHandler->ReturnUpdateField($currentRecord,"uid"),
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
//include "class/User.inc.php";
//$o = new User();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $this->fetchUser($record_id);
    $controlvalue=$this->name;
    $isdeleted=$this->isdeleted;

    $save->DeleteRecord("sim_users","uid",$record_id,$controlvalue,1);

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

public function showLookupUser(){
        $this->log->showLog(2,"Run lookup showUser()");
        $tablename="sim_users";
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  uid, name, uname, user_isactive,pass
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
    $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["uid"]);
                       $getHandler->DefineRecordFieldValue("uid", $row["uid"]);
                       $getHandler->DefineRecordFieldValue("uname", $row["uname"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }
$getHandler->completeGet();
    }

  public function getUserArray($periodfrom_id,$periodto_id){
      global $tableperiod;
           $this->fetchUser($periodfrom_id);
          $periodfrom=$this->uname;

           $this->fetchUser($periodto_id);
          $periodto=$this->uname;

        $sql="SELECT uid,uname from $tableperiod
                where uname between '$periodfrom' and '$periodto' order by uname ASC";
          $query=$this->xoopsDB->query($sql);
          $data=array();
          while($row=$this->xoopsDB->fetchArray($query))
          $data[]=$row['uid'];
	return $data;
       }

  public function getUserID($year,$month){
        $sql="SELECT uid from $this->tableperiod
                where name =$year and email=$month order by uname ASC";
          $query=$this->xoopsDB->query($sql);
          $data=array();
          while($row=$this->xoopsDB->fetchArray($query))
          return $row['uid'];
	return 0;
       }
 
} // end of ClassJobposition
?>

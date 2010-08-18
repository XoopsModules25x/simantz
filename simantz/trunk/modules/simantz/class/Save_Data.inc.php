<?php
/*
 * This class store important save activity, control field type as %s,%d, and %f only
 * Save activity category include I-Insert, U-Update, D-TemporaryDelete,E-Permanently Delete
 * Event typ include: S-success,F-failed
 */

class Save_Data{

private $xoopsDB;
private $log;
public $failfeedback;
public $latestid;
private $selectspliter;
public function Save_Data(){
    global $xoopsDB,$log,$selectspliter;
    $this->xoopsDB=$xoopsDB;
    $this->log=$log;
    $this->selectspliter=$selectspliter;
    }

private function sprintf_array($format, $arr,$arrfieldtype){
    $this->log->showLog(2,"access sprintf_array($format,$arr)");

    $i=0;
    $arrsize=count($arr);
 

    for($i=0;$i<$arrsize;$i++){
        $this->log->showLog(4,"original text:". $arr[$i].",".$arrfieldtype[$i]);
        $value=explode($this->selectspliter,$arr[$i]);
        if($arrfieldtype[$i]=="%s")
          $arr[$i] = $this->xoopsDB->quoteString($this->addEscapeString( $value[0] ));
        }
        $this->log->showLog(3,"exit sprintf_array");

    return call_user_func_array('sprintf', array_merge((array)$format, $arr));
}

private function addEscapeString($value){
   if( get_magic_quotes_gpc()){
            $this->log->showLog(4,"addEscapeString($value) found magic quote gpc, need to test");
            return $value;
        }
        else{
        // $value= mysql_real_escape_string($value);
            $this->log->showLog(4,"addEscapeString($value) No GPC found, return  original text");
        }
    return $value;
}

public function prepareAuditHistory($category,$tablename,$primarykey,$record_id,$arrfield,$arrvalue){
        $this->log->showLog(2,"Access prepareAuditHistory($category,$tablename,$primarykey,$record_id,$arrfield,$arrvalue)");
	global $xoopsDB,$userid, $uname,$_SERVER;
        $fieldstring="";
        $ip=$_SERVER["REMOTE_ADDR"];
	$updated=date("y/m/d H:i:s", time()) ;
        $arrsize=count($arrvalue);
        $changedesc="";
        //only update will compare history record
        if($category=='U'){
            $this->log->showLog(2,"Updating $tablename:");

            //generate field list from $arrfield become field1, field2, field3, ...
            foreach($arrfield as $fieldname)
                $fieldstring.= $fieldname.",";

            $fieldstring=substr_replace($fieldstring,"",-1); //replace last ','

            $sqlgetvalue="SELECT $fieldstring FROM $tablename
                    WHERE $primarykey=$record_id";
            $this->log->showLog(3,"Check previous data with sqlgetvalue:$sqlgetvalue");


           $querygetvalue=$this->xoopsDB->query($sqlgetvalue);
           if(!$querygetvalue){
            $this->failfeedback.="Function prepareAuditHistory failed with SQL $sqlgetvalue due to: ".mysql_error();
            $this->log->showLog(1,$this->failfeedback);

           }
           else{
               
             while($row=$this->xoopsDB->fetchArray($querygetvalue)){
            
                $changecount=0;
                for($i=0;$i<$arrsize;$i++){
                   // $this->log->showLog(4,"$i.".$arrfield[$i].": ".$row[$arrfield[$i]]." => ".$arrvalue[$i]);
                    $value=explode($this->selectspliter,$arrvalue[$i]);
                    if($value[0] != $row[$arrfield[$i]]){
                        if($arrfield[$i]!="created" && $arrfield[$i]!= "updated" && $arrfield[$i]!="createdby" && $arrfield[$i]!="updatedby" ){
                        $changecount++;
                        
                        if($value[1]!="")
                            $changedesc.=$arrfield[$i]."='".$value[1]."'(".$value[0]."),<br/>";
                        else
                            $changedesc.=$arrfield[$i]."='".$value[0]."',<br/>";
                         $this->log->showLog(2,"$i.".$arrfield[$i].": ".$row[$arrfield[$i]]." => ".$arrvalue[$i]);
                        }
                   }
                }
                 $changedesc=substr_replace($changedesc,"",-5);
                 if($changecount==0) return "";
             }
             
           }

        }
        elseif($category=='I'){
              for($i=0;$i<$arrsize;$i++){
               $value=explode($this->selectspliter,$arrvalue[$i]);
               if($value[1]=="")
               $changedesc.=$arrfield[$i]."='".$value[0]."',<br/>";
               else
                   $changedesc.=$arrfield[$i]."='".$value[1]."(".$value[0].")',<br/>";
                $changedesc=substr_replace($changedesc,"",-6);
              }
        }
      elseif($category=='D'){
        $changedesc.="isdeleted=1";
      }
      elseif($category=='E'){
        $changedesc.="Record deleted permanently";
      }
      $changedesc=substr_replace($changedesc,"",-1);
      return $changedesc;
 }

public function completeAuditHistory($category,$status,$tablename,$primarykey,$record_id,$changedesc,$controlvalue){
        $this->log->showLog(2,"Access completeAuditHistory($category,$status,$tablename,$primarykey,$record_id,$changedesc,$controlvalue)");

	global $xoopsDB,$xoopsUser, $uname,$_SERVER;

        $uid= $xoopsUser->getVar('uid');
        $fieldstring="";
        $ip=$_SERVER["REMOTE_ADDR"];
	$updated=date("y/m/d H:i:s", time()) ;

        $sql="INSERT INTO sim_audit(tablename,primarykey,record_id,category,eventype,uid,uname,ip,changedesc,updated,controlvalue) VALUES
            ('%s','%s','%s','%s','%s',%d,'%s','%s','%s','%s','%s')";

        $sql=sprintf($sql,$tablename,$primarykey,$record_id,$category,$status,$uid,
                mysql_real_escape_string($uname),$ip,mysql_real_escape_string($changedesc),$updated,$this->addEscapeString($controlvalue));
         $this->log->showLog(3,"with sql: $sql");
         
        $rs=$this->xoopsDB->query($sql);
        if(!$rs){
            
            $this->failfeedback.="completeAuditHistory fail with SQL ($sql) on: ".mysql_error();
            return false;
        }
        else{
            

        return true;
        }

 }

public function InsertRecord($tablename,$arrfield,$arrvalue,$arrfieldtype,$controlvalue,$primarykey){
    global $xoopsUser;
    $uid= $xoopsUser->getVar('uid');
    $this->log->showLog(2,"Access InsertRecord($tablename,$arrfield,$arrvalue,$arrfieldtype,$controlvalue)");
    $fieldname="";
    $fieldtype="";
    $fieldcount=count($arrfield);



    for($i=0;$i<$fieldcount;$i++){
    	$this->log->showLog(4,"Field sequence:".$arrfield[$i].",".$arrfieldtype[$i]);
        $fieldname.=$arrfield[$i].",";
         $fieldtype.=$arrfieldtype[$i].",";
    }

    $fieldname=substr_replace($fieldname,"",-1);
    $fieldtype=substr_replace($fieldtype,"",-1);

    
    
    $sql  = "INSERT INTO $tablename ($fieldname) VALUES ($fieldtype)";
    $this->log->showLog(4,"pre-SQL: $sql");

   
    $changedesc=$this->prepareAuditHistory("I",$tablename,"","",$arrfield,$arrvalue);
    if(!$changedesc)
        return false;
    
    $sql=$this->sprintf_array($sql,$arrvalue,$arrfieldtype);
    $this->log->showLog(3,"Before run InsertRecord With SQL: $sql");

    $rs=$this->xoopsDB->query($sql);
    $status="";
    if(!$rs){

        if(mysql_errno()==1062){
        $this->failfeedback.="Cannot insert record into database due to: Data Duplicate!<br/>\n";
        }
        else
        $this->failfeedback.="Cannot insert record into database! due to Error no:".mysql_errno()."<br/>\n";
        //$this->failfeedback.="Cannot insert record into database ($sql) due to: ".mysql_error()."!";
        $status="F";
        return false;
    }
    else{
        $status="S";
        $sqllatest="SELECT max($primarykey) as record_id FROM $tablename WHERE createdby=$uid";
        $rslatest=$this->xoopsDB->query($sqllatest);
        while($rowlatest=$this->xoopsDB->fetchArray($rslatest))
            $record_id=$rowlatest['record_id'];
        $this->latestid=$record_id;
        $this->log->showLog(4,"Record '$controlvalue' save successfully with record_id=$record_id (With sqllatest: $sqllatest)");
    }

    $this->completeAuditHistory("I",$status,$tablename,$primarykey,$record_id,$changedesc,$controlvalue);
    if($status=="S"){
          $this->failfeedback="";
            return true;
    }
    else
            return false;

}

public function UpdateRecord($tablename,$primarykey,$record_id,$arrfield,$arrvalue,$arrfieldtype,$controlvalue){
 
    $this->log->showLog(2,"Access UpdateRecord($tablename,$primarykey,$record_id,$arrfield,$arrvalue,$arrfieldtype,$controlvalue)");
    $fieldname="";
    $fieldtype="";
    $sql  = "UPDATE $tablename SET ";
    $fieldcount=count($arrfield);
    


    for($i=0;$i<$fieldcount;$i++){
    $this->log->showLog(4,"Field Type sequence:".$arrfieldtype[$i]);

          $sql.=$arrfield[$i]."=".$arrfieldtype[$i].",";
          $arrvalue[$i]=htmlspecialchars_decode($arrvalue[$i]);
    }
    $sql=substr_replace($sql,"",-1) . " WHERE $primarykey=$record_id";
    $this->log->showLog(4,"pre-SQL: $sql");
  
     $sql=$this->sprintf_array($sql,$arrvalue,$arrfieldtype);
    $this->log->showLog(3,"Before run UpdateRecord With SQL: $sql");
  
    $changedesc=$this->prepareAuditHistory("U",$tablename,$primarykey,$record_id,$arrfield,$arrvalue);
    
    if($changedesc==""){
         $this->failfeedback.="Have some data are nothing change!<br/>\n";
        return false;
    }
    $rs=$this->xoopsDB->query($sql);
    $status="";
    if(!$rs){
        if(mysql_errno()==1062)
        $this->failfeedback.="Cannot insert record into database due to: Data Duplicate!<br/>\n";
        else
        $this->failfeedback.="Cannot insert record into database! due to Error no:".mysql_errno()."<br/>\n";
                //$this->failfeedback.="Cannot insert record into database ($sql) due to: ".mysql_error()."!";
        $status="F";
        $this->completeAuditHistory("U","F",$tablename,$primarykey,$record_id,$changedesc,$controlvalue);
        return false;
    }
    else{
        $status="S";
       $this->completeAuditHistory("U","S",$tablename,$primarykey,$record_id,$changedesc,$controlvalue);
        return true;
    }

}

public function DeleteRecord($tablename,$primarykey,$record_id,$controlvalue,$isdeleted){
    global $isadmin;
    $this->log->showLog(2,"access DeleteRecord($tablename,$primarykey,$record_id,$controlvalue,$ispurge)");
    //first delete is hide record, 2nd delete only can remove data permanently
    if($isdeleted==0){
        $changedesc=$this->prepareAuditHistory("D",$tablename,$primarykey,$record_id,array(),array());
        $sql = "UPDATE $tablename SET isdeleted=1, isactive=0 WHERE $primarykey = $record_id" ;
        $this->log->showLog(4,"Delete data with sql: $sql");
    }
    elseif($isdeleted==1 ){
            $changedesc=$this->prepareAuditHistory("E",$tablename,$primarykey,$record_id,array(),array());
            $sql = "DELETE FROM $tablename WHERE $primarykey = $record_id" ;
            $this->log->showLog(4,"Purge data (run as admin group) sql: $sql");
    }
    else{
            $changedesc=$this->prepareAuditHistory("E",$tablename,$primarykey,$record_id,array(),array());
            $this->log->showLog(4,"Run purge data (without admin permission)");
            $this->completeAuditHistory("E","F",$tablename,$primarykey,$record_id,"Purge data without admin permission",$controlvalue);
            return false;
    }

    
  // Now we execute this query
    $rs=$this->xoopsDB->query($sql);
        $err1=mysql_error();

    
    if($rs){
     $status="S";
         $this->log->showLog(3,"Delete data successfully:$err1");
         if($isdeleted==1)
         $this->completeAuditHistory("E",$status,$tablename,$primarykey,$record_id,$changedesc,$controlvalue);
         else
         $this->completeAuditHistory("D",$status,$tablename,$primarykey,$record_id,$changedesc,$controlvalue);

             return true;
    }
    else{
        $status="F";
         $this->log->showLog(1,"Error! Cannot remove data:\"$controlvalue\" due to: ".$err1);

       if(mysql_errno()==1451)
         $this->failfeedback.="Error! Cannot remove data: \"$controlvalue\" due to: Data are use in other place.";
       else
         $this->failfeedback.="Error! Cannot remove data: \"$controlvalue\" due to error no: ".mysql_errno();

         if($isdeleted==1)
         $this->completeAuditHistory("E",$status,$tablename,$primarykey,$record_id,$changedesc,$controlvalue);
         else
         $this->completeAuditHistory("D",$status,$tablename,$primarykey,$record_id,$changedesc,$controlvalue);

             return false;
    }
    
            
}

public function savePeriod(){
$this->log->showLog(2,"Access savePeriod");
    global $xoopsDB,$saveHandler,$createdby,$timestamp;
    $tablename="sim_period";

$insertCount = $saveHandler->ReturnInsertCount();
$this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
      $arrfield=array("period_name", "period_year","period_month", "isactive","defaultlevel",
            "created","createdby","updated","updatedby");
      $arrfieldtype=array('%s','%d','%d','%d','%d','%s','%d','%s','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {
   
     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "period_name"),
                $saveHandler->ReturnInsertField($currentRecord, "period_year"),
                $saveHandler->ReturnInsertField($currentRecord, "period_month"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "period_name");
     $this->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"period_id");
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{ 

    $arrfield=array("period_name", "period_year", "period_month","isactive","defaultlevel","updated","updatedby","isdeleted");
      $arrfieldtype=array('%s','%d','%d','%d','%d','%s','%d','%d');
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {
    
        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "period_name"),
                $saveHandler->ReturnUpdateField($currentRecord, "period_year"),
                $saveHandler->ReturnUpdateField($currentRecord, "period_month"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                );

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "period_name");

         $this->UpdateRecord($tablename, "period_id",$saveHandler->ReturnUpdateField($currentRecord),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);
                       
 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");
include "class/Period.inc.php";
$o = new Period();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);
   
    $o->fetchPeriod($record_id);
    $controlvalue=$o->period_name;
    $isdeleted=$o->isdeleted;
    if($o->allowDelete($record_id))
    $this->DeleteRecord("sim_period","period_id",$record_id,$controlvalue,$isdeleted);
    else
    $this->failfeedback.="Cannot delete period: $controlvalue <br/>";

  }

  }
//$this->failfeedback.="asdasdpasd<br/>\n";
//$this->failfeedback.="123 3443<br/>\n";
//$this->failfeedback.="234 45656523 234<br/>\n";
if($this->failfeedback!="")
$this->failfeedback.="Warning!<br/>\n".$this->failfeedback;
$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();

}


public function saveRegion(){
$this->log->showLog(2,"Access saveRegion");
    global $xoopsDB,$saveHandler,$createdby,$timestamp;
    $tablename="sim_region";
    $pkey="region_id";
    $keyword="Region";
    $controlfieldname="region_name";
$insertCount = $saveHandler->ReturnInsertCount();
$this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
      $arrfield=array($controlfieldname, "country_id", "isactive","defaultlevel",
            "created","createdby","updated","updatedby");
      $arrfieldtype=array('%s','%d','%d','%d','%s','%d','%s','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, $controlfieldname),
                $saveHandler->ReturnInsertField($currentRecord, "country_id"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, $controlfieldname);
     $this->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,$pkey);
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{

    $arrfield=array($controlfieldname, "country_id", "isactive","defaultlevel","updated","updatedby","isdeleted");
      $arrfieldtype=array('%s','%d','%d','%d','%s','%d','%d');
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, $controlfieldname),
                $saveHandler->ReturnUpdateField($currentRecord, "country_id"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                );

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, $controlfieldname);

         $this->UpdateRecord($tablename, $pkey,$saveHandler->ReturnUpdateField($currentRecord),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);

 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");
include "class/$keyword.inc.php";
$o = new Region();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $o->fetchRegion($record_id);
    $controlvalue=$o->region_name;
    $isdeleted=$o->isdeleted;
    
    if($o->allowDelete($record_id))
    $this->DeleteRecord($tablename,$pkey,$record_id,$controlvalue,$isdeleted);
    else
    $this->failfeedback.="Cannot delete $keyword: $controlvalue <br/>";
  }
}
//$this->failfeedback.="asdasdpasd<br/>\n";
//$this->failfeedback.="123 3443<br/>\n";
//$this->failfeedback.="234 45656523 234<br/>\n";
if($this->failfeedback!="")
$this->failfeedback.="Warning!<br/>\n".$this->failfeedback;
$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();

}

public function saveWindow(){
$this->log->showLog(2,"Access saveWindow");
    global $xoopsDB,$saveHandler,$createdby,$timestamp;
    $tablename="sim_window";

$insertCount = $saveHandler->ReturnInsertCount();
$this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
      $arrfield=array("window_name","mid","parentwindows_id","description","windowsetting", "filename",
                "isactive","seqno", "created","createdby","updated","updatedby");
      $arrfieldtype=array('%s','%d','%d','%s','%s','%s','%d','%d','%s','%d','%s','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "window_name"),
                $saveHandler->ReturnInsertField($currentRecord, "mid"),
                $saveHandler->ReturnInsertField($currentRecord, "parentwindows_id"),
                $saveHandler->ReturnInsertField($currentRecord, "description"),
                $saveHandler->ReturnInsertField($currentRecord, "windowsetting"),
                $saveHandler->ReturnInsertField($currentRecord, "filename"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "window_name");
     $this->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"window_id");
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{

    $arrfield=array("window_name","mid","parentwindows_id","description","windowsetting", "filename",
                     "isactive","seqno","updated","updatedby","isdeleted");
      $arrfieldtype=array('%s','%d','%d','%s','%s','%s','%d','%d','%s','%d','%d');
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "window_name"),
                $saveHandler->ReturnUpdateField($currentRecord, "mid"),
                $saveHandler->ReturnUpdateField($currentRecord, "parentwindows_id"),
                $saveHandler->ReturnUpdateField($currentRecord, "description"),
                $saveHandler->ReturnUpdateField($currentRecord, "windowsetting"),
                $saveHandler->ReturnUpdateField($currentRecord, "filename"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                );

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "window_name");

         $this->UpdateRecord($tablename, "window_id",$saveHandler->ReturnUpdateField($currentRecord),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);

 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");
include "../class/Window.inc.php";
$window = new Window();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $window->fetchWindow($record_id);
    $controlvalue=$window->window_name;
    $isdeleted=$window->isdeleted;
    $this->DeleteRecord("sim_window","window_id",$record_id,$controlvalue,$isdeleted);
  }

  }
//$this->failfeedback.="asdasdpasd<br/>\n";
//$this->failfeedback.="123 3443<br/>\n";
//$this->failfeedback.="234 45656523 234<br/>\n";
if($this->failfeedback!="")
$this->failfeedback.="Warning!<br/>\n".$this->failfeedback;
$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();

}

public function saveCurrency(){
$this->log->showLog(2,"Access saveCurrency");
    global $xoopsDB,$saveHandler,$createdby,$timestamp;
    $tablename="sim_currency";

$insertCount = $saveHandler->ReturnInsertCount();
$this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
      $arrfield=array("currency_code", "currency_name", "country_id","isactive","defaultlevel",
            "created","createdby","updated","updatedby");
      $arrfieldtype=array('%s','%s','%d','%d','%d','%s','%d','%s','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "currency_code"),
                $saveHandler->ReturnInsertField($currentRecord, "currency_name"),
                $saveHandler->ReturnInsertField($currentRecord, "country_id"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "currency_code");
     $this->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"currency_id");
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{

    $arrfield=array("currency_code", "currency_name", "country_id","isactive","defaultlevel","updated","updatedby","isdeleted");
      $arrfieldtype=array('%s','%s','%d','%d','%d','%s','%d','%d');
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "currency_code"),
                $saveHandler->ReturnUpdateField($currentRecord, "currency_name"),
                $saveHandler->ReturnUpdateField($currentRecord, "country_id"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                );

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "currency_code");

         $this->UpdateRecord($tablename, "currency_id",$saveHandler->ReturnUpdateField($currentRecord),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);

 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");
include "class/Currency.inc.php";
$o = new Currency();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $o->fetchCurrency($record_id);
    $controlvalue=$o->currency_code;
    $isdeleted=$country->isdeleted;
    $this->DeleteRecord("sim_currency","currency_id",$record_id,$controlvalue,$isdeleted);
  }

  }
//$this->failfeedback.="asdasdpasd<br/>\n";
//$this->failfeedback.="123 3443<br/>\n";
//$this->failfeedback.="234 45656523 234<br/>\n";
if($this->failfeedback!="")
$this->failfeedback.="Warning!<br/>\n".$this->failfeedback;
$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();

}

public function saveConversionRate(){
    
        $choosecurrencyfrom_id=$_REQUEST['choosecurrencyfrom_id'];


$this->log->showLog(2,"Access saveConversionRate, currencyfrom_id: $choosecurrencyfrom_id");
    global $xoopsDB,$saveHandler,$createdby,$timestamp,$defaultorganization_id;
    $tablename="sim_conversionrate";
$insertCount = $saveHandler->ReturnInsertCount();
$this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
      $arrfield=array("currencyfrom_id", "currencyto_id",
          "multiplyvalue","effectivedate","organization_id","description",
          "isactive", "created","createdby","updated","updatedby");
      $arrfieldtype=array('%d','%d','%d','%s','%s','%d','%s','%d','%s','%d','%s','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($choosecurrencyfrom_id,
                $saveHandler->ReturnInsertField($currentRecord, "currencyto_id"),
                $saveHandler->ReturnInsertField($currentRecord, "multiplyvalue"),
                $saveHandler->ReturnInsertField($currentRecord, "effectivedate"),
                $defaultorganization_id,
                $saveHandler->ReturnInsertField($currentRecord, "description"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "description");
     $this->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"conversion_id");
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{

    $arrfield=array("currencyto_id", "multiplyvalue", "effectivedate","description","isactive","updated","updatedby","isdeleted");
      $arrfieldtype=array('%d','%d','%s','%s','%s','%d','%s','%d','%d');
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array(
            $saveHandler->ReturnUpdateField($currentRecord, "currencyto_id"),
                $saveHandler->ReturnUpdateField($currentRecord, "multiplyvalue"),
                $saveHandler->ReturnUpdateField($currentRecord, "effectivedate"),
                $saveHandler->ReturnUpdateField($currentRecord,"description"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                );

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "description");

         $this->UpdateRecord($tablename, "conversion_id",$saveHandler->ReturnUpdateField($currentRecord),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);

 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");
include "class/ConversionRate.inc.php";
$o = new ConversionRate();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){

    $record_id=$saveHandler->ReturnDeleteField($currentRecord);
    if($o->allowDelete($record_id)){
    $o->fetchConversionRate($record_id);
    $controlvalue=$o->description;
    $isdeleted=$country->isdeleted;
    $this->DeleteRecord("sim_conversionrate","conversion_id",$record_id,$controlvalue,1);
    }
    else{
        $this->failfeedback.="Current record id:$currentRecord is not deletetable<br/>\n";
    }
  }

  }

if($this->failfeedback!="")
$this->failfeedback.="Warning!<br/>\n".$this->failfeedback;
$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();

}

public function saveRaces(){

$this->log->showLog(2,"Access saveRaces()");
   // die;

    global $xoopsDB,$saveHandler,$createdby,$timestamp,$defaultorganization_id;
    $tablename="sim_races";
    $pkey="races_id";
    $keyword="Races";
    $controlfieldname="races_name";

$insertCount = $saveHandler->ReturnInsertCount();
$this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
      $arrfield=array($controlfieldname, "races_description", "isactive","defaultlevel",
            "created","createdby","updated","updatedby","organization_id");
      $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s','%d','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, $controlfieldname),
                $saveHandler->ReturnInsertField($currentRecord, "races_description"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $defaultorganization_id);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, $controlfieldname);
     $this->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,$pkey);
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{

    $arrfield=array($controlfieldname, "races_description", "isactive","defaultlevel","updated","updatedby","isdeleted");
      $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%d');
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {


        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, $controlfieldname),
                $saveHandler->ReturnUpdateField($currentRecord, "races_description"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                );

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, $controlfieldname);

         $this->UpdateRecord($tablename, $pkey,$saveHandler->ReturnUpdateField($currentRecord),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);

 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");
include "class/$keyword.inc.php";
$o = new Races();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $o->fetchRaces($record_id);
    $controlvalue=$o->races_name;
    $isdeleted=$o->isdeleted;
    if($o->allowDelete($record_id))
    $this->DeleteRecord($tablename,$pkey,$record_id,$controlvalue,$isdeleted);
    else
    $this->failfeedback.="Cannot delete $keyword: $o->races_name <br/>";
    
  }

  }
//$this->failfeedback.="asdasdpasd<br/>\n";
//$this->failfeedback.="123 3443<br/>\n";
//$this->failfeedback.="234 45656523 234<br/>\n";
if($this->failfeedback!="")
$this->failfeedback.="Warning!<br/>\n".$this->failfeedback;
$saveHandler->setErrorMessage($this->failfeedback);
die;
$saveHandler->CompleteSave();

}

public function saveReligion(){

$this->log->showLog(2,"Access saveReligion()");
   // die;

    global $xoopsDB,$saveHandler,$createdby,$timestamp,$defaultorganization_id;
    $tablename="sim_religion";
    $pkey="religion_id";
    $keyword="Religion";
    $controlfieldname="religion_name";

$insertCount = $saveHandler->ReturnInsertCount();
$this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
      $arrfield=array($controlfieldname, "religion_description", "isactive","defaultlevel",
            "created","createdby","updated","updatedby","organization_id");
      $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s','%d','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, $controlfieldname),
                $saveHandler->ReturnInsertField($currentRecord, "religion_description"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $defaultorganization_id);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, $controlfieldname);
     $this->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,$pkey);
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{

    $arrfield=array($controlfieldname, "religion_description", "isactive","defaultlevel","updated","updatedby","isdeleted");
      $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%d');
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, $controlfieldname),
                $saveHandler->ReturnUpdateField($currentRecord, "religion_description"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                );

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, $controlfieldname);

         $this->UpdateRecord($tablename, $pkey,$saveHandler->ReturnUpdateField($currentRecord),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);

 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");

$classname="class/$keyword.inc.php";
include $classname;
$this->log->showLog(3,"Include $classname successfully");

$o = new Religion();
$this->log->showLog(3,"Inilialize Religion()");

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $o->fetchReligion($record_id);
    $controlvalue=$o->religion_name;
    $isdeleted=$o->isdeleted;
    if($o->allowDelete($record_id))
    $this->DeleteRecord($tablename,$pkey,$record_id,$controlvalue,$isdeleted);
    else
    $this->failfeedback.="Cannot delete $keyword: $o->religion_name <br/>";

  }

  }
//$this->failfeedback.="asdasdpasd<br/>\n";
//$this->failfeedback.="123 3443<br/>\n";
//$this->failfeedback.="234 45656523 234<br/>\n";
if($this->failfeedback!="")
$this->failfeedback.="Warning!<br/>\n".$this->failfeedback;
$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();

}

public function saveTerms(){

$this->log->showLog(2,"Access saveTerms()");
   // die;

    global $xoopsDB,$saveHandler,$createdby,$timestamp,$defaultorganization_id;
    $tablename="sim_terms";
    $pkey="terms_id";
    $keyword="Terms";
    $controlfieldname="terms_name";

$insertCount = $saveHandler->ReturnInsertCount();
$this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
      $arrfield=array($controlfieldname, "daycount","description", "isactive","defaultlevel",
            "created","createdby","updated","updatedby","organization_id");
      $arrfieldtype=array('%s','%d','%s','%d','%d','%s','%d','%s','%d','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, $controlfieldname),
             $saveHandler->ReturnInsertField($currentRecord, "daycount"),
                $saveHandler->ReturnInsertField($currentRecord, "description"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $defaultorganization_id);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, $controlfieldname);
     $this->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,$pkey);
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{

    $arrfield=array($controlfieldname,  "daycount","description", "isactive","defaultlevel","updated","updatedby","isdeleted");
      $arrfieldtype=array('%s','%d','%s','%d','%d','%s','%d','%d');
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, $controlfieldname),
                            $saveHandler->ReturnUpdateField($currentRecord, "daycount"),
                $saveHandler->ReturnUpdateField($currentRecord, "description"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                );

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, $controlfieldname);

         $this->UpdateRecord($tablename, $pkey,$saveHandler->ReturnUpdateField($currentRecord),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);

 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");

$classname="class/$keyword.inc.php";
include $classname;
$this->log->showLog(3,"Include $classname successfully");

$o = new Terms();
$this->log->showLog(3,"Inilialize $keyword()");

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $o->fetchTerms($record_id);
    $controlvalue=$o->terms_name;
    $isdeleted=$o->isdeleted;
    if($o->allowDelete($record_id))
    $this->DeleteRecord($tablename,$pkey,$record_id,$controlvalue,$isdeleted);
    else
    $this->failfeedback.="Cannot delete $keyword: $o->terms_name <br/>";

  }

  }
//$this->failfeedback.="asdasdpasd<br/>\n";
//$this->failfeedback.="123 3443<br/>\n";
//$this->failfeedback.="234 45656523 234<br/>\n";
if($this->failfeedback!="")
$this->failfeedback.="Warning!<br/>\n".$this->failfeedback;
$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();

}

public function saveBPartnerGroup(){

$this->log->showLog(2,"Access saveBPartnerGroup()");
   // die;

    global $xoopsDB,$saveHandler,$createdby,$timestamp,$defaultorganization_id;
    $tablename="sim_bpartnergroup";
    $pkey="bpartnergroup_id";
    $keyword="BPartnerGroup";
    $controlfieldname="bpartnergroup_name";

$insertCount = $saveHandler->ReturnInsertCount();
$this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
      $arrfield=array($controlfieldname, "debtoraccounts_id","creditoraccounts_id","description", "isactive","defaultlevel",
            "created","createdby","updated","updatedby","organization_id");
      $arrfieldtype=array('%s','%d','%d','%s','%d','%d','%s','%d','%s','%d','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, $controlfieldname),
             $saveHandler->ReturnInsertField($currentRecord, "debtoraccounts_id"),
             $saveHandler->ReturnInsertField($currentRecord, "creditoraccounts_id"),
                $saveHandler->ReturnInsertField($currentRecord, "description"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $defaultorganization_id);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, $controlfieldname);
     $this->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,$pkey);
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{

    $arrfield=array($controlfieldname,  "debtoraccounts_id","creditoraccounts_id","description", "isactive","defaultlevel","updated","updatedby","isdeleted");
      $arrfieldtype=array('%s','%d','%d','%s','%d','%d','%s','%d','%d');
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, $controlfieldname),
                $saveHandler->ReturnUpdateField($currentRecord, "debtoraccounts_id"),
                $saveHandler->ReturnUpdateField($currentRecord, "creditoraccounts_id"),
                $saveHandler->ReturnUpdateField($currentRecord, "description"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                );

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, $controlfieldname);

         $this->UpdateRecord($tablename, $pkey,$saveHandler->ReturnUpdateField($currentRecord),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);

 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");

$classname="class/$keyword.inc.php";
include $classname;
$this->log->showLog(3,"Include $classname successfully");

$o = new BPartnerGroup();
$this->log->showLog(3,"Inilialize $keyword()");

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $o->fetchBPartnerGroup($record_id);
    $controlvalue=$o->bpartnergroup_name;
    $isdeleted=$o->isdeleted;
    if($o->allowDelete($record_id))
    $this->DeleteRecord($tablename,$pkey,$record_id,$controlvalue,$isdeleted);
    else
    $this->failfeedback.="Cannot delete $keyword: $o->bpartnergroup_name <br/>";

  }

  }
//$this->failfeedback.="asdasdpasd<br/>\n";
//$this->failfeedback.="123 3443<br/>\n";
//$this->failfeedback.="234 45656523 234<br/>\n";
if($this->failfeedback!="")
$this->failfeedback.="Warning!<br/>\n".$this->failfeedback;
$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();

}

public function saveFollowUpType(){

$this->log->showLog(2,"Access saveFollowUpType()");
   // die;

    global $xoopsDB,$saveHandler,$createdby,$timestamp,$defaultorganization_id;
    $tablename="sim_followuptype";
    $pkey="followuptype_id";
    $keyword="FollowUpType";
    $controlfieldname="followuptype_name";

$insertCount = $saveHandler->ReturnInsertCount();
$this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
      $arrfield=array($controlfieldname,"description", "isactive","defaultlevel",
            "created","createdby","updated","updatedby","organization_id");
      $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s','%d','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, $controlfieldname),
                $saveHandler->ReturnInsertField($currentRecord, "description"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $defaultorganization_id);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, $controlfieldname);
     $this->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,$pkey);
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{

    $arrfield=array($controlfieldname, "description", "isactive","defaultlevel","updated","updatedby","isdeleted");
      $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%d');
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, $controlfieldname),
                $saveHandler->ReturnUpdateField($currentRecord, "description"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                );

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, $controlfieldname);

         $this->UpdateRecord($tablename, $pkey,$saveHandler->ReturnUpdateField($currentRecord),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);

 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");

$classname="class/$keyword.inc.php";
include $classname;
$this->log->showLog(3,"Include $classname successfully");

$o = new FollowUpType();
$this->log->showLog(3,"Inilialize $keyword()");

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $o->fetchFollowUpType($record_id);
    
    $controlvalue=$o->followuptype_name;
    $isdeleted=$o->isdeleted;
    if($o->allowDelete($record_id))
    $this->DeleteRecord($tablename,$pkey,$record_id,$controlvalue,$isdeleted);
    else
    $this->failfeedback.="Cannot delete $keyword: $o->followuptype_name <br/>";

  }

  }
//$this->failfeedback.="asdasdpasd<br/>\n";
//$this->failfeedback.="123 3443<br/>\n";
//$this->failfeedback.="234 45656523 234<br/>\n";
if($this->failfeedback!="")
$this->failfeedback.="Warning!<br/>\n".$this->failfeedback;
$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();

}

public function saveBPartnerFromTableList(){

$this->log->showLog(2,"Access saveBPartnerFromTableList()");
   // die;

    global $xoopsDB,$saveHandler,$createdby,$timestamp,$defaultorganization_id;
    $tablename="sim_bpartner";
    $pkey="bpartner_id";
    $keyword="BPartner";
    $controlfieldname="bpartner_no";

$insertCount = $saveHandler->ReturnInsertCount();
$this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
      $arrfield=array($controlfieldname,"bpartner_name","companyno","bpartnergroup_id","industry_id","terms_id", "isactive","defaultlevel",
            "created","createdby","updated","updatedby","organization_id");
      $arrfieldtype=array('%s','%s','%s','%d','%d','%d','%d','%d','%s','%d','%s','%d','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, $controlfieldname),
                $saveHandler->ReturnInsertField($currentRecord, "bpartner_name"),
                $saveHandler->ReturnInsertField($currentRecord, "companyno"),
                $saveHandler->ReturnInsertField($currentRecord, "bpartnergroup_id"),
                $saveHandler->ReturnInsertField($currentRecord, "industry_id"),
                $saveHandler->ReturnInsertField($currentRecord, "terms_id"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $defaultorganization_id);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, $controlfieldname);
     $this->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,$pkey);
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{

    $arrfield=array($controlfieldname, "bpartner_name","companyno","bpartnergroup_id","industry_id","terms_id",
            "isactive","defaultlevel","updated","updatedby","isdeleted");
      $arrfieldtype=array('%s','%s','%s','%d','%d','%d','%d','%d','%s','%d','%d');
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, $controlfieldname),
                $saveHandler->ReturnUpdateField($currentRecord, "bpartner_name"),
                $saveHandler->ReturnUpdateField($currentRecord, "companyno"),
                $saveHandler->ReturnUpdateField($currentRecord, "bpartnergroup_id"),
                $saveHandler->ReturnUpdateField($currentRecord, "industry_id"),
                $saveHandler->ReturnUpdateField($currentRecord, "terms_id"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"defaultlevel"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                );

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, $controlfieldname);

         $this->UpdateRecord($tablename, $pkey,$saveHandler->ReturnUpdateField($currentRecord),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);

 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");

$classname="class/$keyword.inc.php";
include $classname;
$this->log->showLog(3,"Include $classname successfully");

$o = new BPartner();
$this->log->showLog(3,"Inilialize $keyword()");

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $o->fetchBPartner($record_id);

    $controlvalue=$o->bpartner_no;
    $isdeleted=$o->isdeleted;
    if($o->allowDelete($record_id))
    $this->DeleteRecord($tablename,$pkey,$record_id,$controlvalue,$isdeleted);
    else
    $this->failfeedback.="Cannot delete $keyword: $o->followuptype_name <br/>";

  }

  }
//$this->failfeedback.="asdasdpasd<br/>\n";
//$this->failfeedback.="123 3443<br/>\n";
//$this->failfeedback.="234 45656523 234<br/>\n";
if($this->failfeedback!="")
$this->failfeedback.="Warning!<br/>\n".$this->failfeedback;
$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();

}


    public function saveWorkflow(){
    global $defaultorganization_id;

    $this->log->showLog(2,"Access saveWorkflow");
        global $xoopsDB,$saveHandler,$createdby,$timestamp;
        $tablename="sim_workflow";

    $insertCount = $saveHandler->ReturnInsertCount();
    $this->log->showLog(3,"Start Insert($insertCount records)");

    if ($insertCount > 0)
    {
          $arrfield=array("workflow_code", "workflow_name", "workflow_description", "workflow_owneruid",
                "workflow_ownergroup", "workflow_email",
                "isactive","created","createdby","updated","updatedby","organization_id");
          $arrfieldtype=array('%s','%s','%s','%d','%d','%s','%d','%s','%d','%s','%d','%d');

    // Yes there are INSERTs to perform...
     for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
     {

         $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "workflow_code"),
                    $saveHandler->ReturnInsertField($currentRecord, "workflow_name"),
                    $saveHandler->ReturnInsertField($currentRecord,"workflow_description"),
                    $saveHandler->ReturnInsertField($currentRecord,"workflow_owneruid"),
                    $saveHandler->ReturnInsertField($currentRecord,"workflow_ownergroup"),
                    $saveHandler->ReturnInsertField($currentRecord,"workflow_email"),
                    $saveHandler->ReturnInsertField($currentRecord,"isactive"),                    
                    $timestamp,
                    $createdby,
                    $timestamp,
                    $createdby,
                    $defaultorganization_id);
         $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "workflow_code");
         $this->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"workflow_id");
      // Now we execute this query
     }
    }

    $updateCount = $saveHandler->ReturnUpdateCount();
    $this->log->showLog(3,"Start update($updateCount records)");

    if ($updateCount > 0)
    {

        $arrfield=array("workflow_code", "workflow_name", 
                "workflow_description", "workflow_owneruid",
                "workflow_ownergroup", "workflow_email",
            "isactive","updated","updatedby","isdeleted");
          $arrfieldtype=array('%s','%s','%s','%d','%d','%s','%d','%s','%d','%d');
     // Yes there are UPDATEs to perform...
     for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
     {

            $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "workflow_code"),
                    $saveHandler->ReturnUpdateField($currentRecord, "workflow_name"),
                    $saveHandler->ReturnUpdateField($currentRecord,"workflow_description"),
                    $saveHandler->ReturnUpdateField($currentRecord,"workflow_owneruid"),
                    $saveHandler->ReturnUpdateField($currentRecord,"workflow_ownergroup"),
                    $saveHandler->ReturnUpdateField($currentRecord,"workflow_email"),
                    $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                    $timestamp,
                    $createdby,
                    $saveHandler->ReturnUpdateField($currentRecord,"isdeleted"),
                    );

             $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "workflow_code");

             $this->UpdateRecord($tablename, "workflow_id",$saveHandler->ReturnUpdateField($currentRecord),
                        $arrfield, $arrvalue, $arrfieldtype,$controlvalue);

     }
    }

    $ispurge=0;
    $deleteCount = $saveHandler->ReturnDeleteCount();
    $this->log->showLog(3,"Start delete/purge($deleteCount records)");
    include "class/Workflow.inc.php";
    $o = new Workflow();

    if ($deleteCount > 0){
      for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
        $record_id=$saveHandler->ReturnDeleteField($currentRecord);

        $o->fetchWorkflow($record_id);
        $controlvalue=$o->workflow_code;
        $isdeleted=$o->isdeleted;
            $isdeleted=$o->isdeleted;
        if($o->allowDelete($record_id))
        $this->DeleteRecord("sim_workflow","workflow_id",$record_id,$controlvalue,1);
        else
        $this->failfeedback.="Cannot delete workflow: $controlvalue <br/>";

      }

      }

    if($this->failfeedback!="")
    $this->failfeedback.="Warning!<br/>\n".$this->failfeedback;
    $saveHandler->setErrorMessage($this->failfeedback);
    $saveHandler->CompleteSave();

    }

    /*
     * run checking version record
     */
     public function checkCurrentVersionRecord($field_name,$tablename,$field_value,$primarykey_name,$primarykey_value){
         global $checkrecord_interval;
         
         $url_xoops = XOOPS_URL;

         if($checkrecord_interval == "")
         $checkrecord_interval = "300000";//default is 300000 : 5 minute
     
echo <<< EOF
   <script type="text/javascript">
                checkRecordVersion();

                function checkRecordVersion(){
                
                var data="field_name=$field_name&tablename=$tablename&field_value=$field_value&primarykey_name=$primarykey_name&primarykey_value=$primarykey_value";

                $.ajax({
                url: "$url_xoops/checkrecord.php",type: "POST",data: data,cache: false,
                success: function (xml) {
                        jsonObj = eval( '(' + xml + ')');

                        var version_fld  = jsonObj.version_fld;
                        var status  = jsonObj.status;

                        if(version_fld != ""){

                            if(status == "ko"){

                                if (confirm("Your current data is outdated. Please Click 'OK' to refresh page OR click 'Cancel' to stay with your data.\\nYour data might be lost if you click 'OK'")){
                                window.location.reload();
                                }
                            }
                        }

                        }
                });

                // run every 5 minute = 300000
                setTimeout("checkRecordVersion();",'$checkrecord_interval');
                
                }

                
   </script>
EOF;
     }

}
?>
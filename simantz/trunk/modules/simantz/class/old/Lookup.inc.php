<?php

class Lookup{
private $log;
private $xoopsDB;

public function Lookup(){
    global $log,$xoopsDB;
    $this->log=$log;
    $this->xoopsDB=$xoopsDB;
}

public function showModule(){
            $this->log->showLog(2,"Run lookup showModule()");
            $tablename="sim_modules";
    global $xoopsDB,$getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="weight";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  mid, name  FROM $tablename
            $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
                $this->log->showLog(4," with SQL: $sql");

        $query = $xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["mid"]);
                       $getHandler->DefineRecordFieldValue("mid", $row["mid"]);
                       $getHandler->DefineRecordFieldValue("name", $row["name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }
    
public function showCountry(){
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
    
    }

public function showCurrency($wherestring){
        $this->log->showLog(2,"Run lookup showCurrency($wherestring)");
        $tablename="sim_currency";
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
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
      $sql = "SELECT  currency_id, currency_code
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
    $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["currency_id"]);
                       $getHandler->DefineRecordFieldValue("currency_id", $row["currency_id"]);
                       $getHandler->DefineRecordFieldValue("currency_code", $row["currency_code"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

public function showWindow($wherestring=""){
            $this->log->showLog(2,"Run lookup showWindow($wherestring)");

    global $xoopsDB,$getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    $tablename="sim_window";
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="seqno";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  window_id, window_name  FROM $tablename
            $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
                $this->log->showLog(4," with SQL: $sql");

        $query = $xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["window_id"]);
                       $getHandler->DefineRecordFieldValue("window_id", $row["window_id"]);
                       $getHandler->DefineRecordFieldValue("window_name", $row["window_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

public function showLibWindow($wherestring=""){
            $this->log->showLog(2,"Run lookup showWindow($wherestring)");

    global $xoopsDB,$getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    $tablename="sim_simedu_libwindow";
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="seqno";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  window_id, window_name  FROM $tablename
            $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
                $this->log->showLog(4," with SQL: $sql");

        $query = $xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["window_id"]);
                       $getHandler->DefineRecordFieldValue("window_id", $row["window_id"]);
                       $getHandler->DefineRecordFieldValue("window_name", $row["window_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }


public function showBPartnerGroup($wherestring){
        
        $this->log->showLog(2,"Run lookup showBPartnerGroup($wherestring)");
        $tablename="sim_bpartnergroup";
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="bpartnergroup_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  bpartnergroup_id, bpartnergroup_name
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["bpartnergroup_id"]);
                       $getHandler->DefineRecordFieldValue("bpartnergroup_id", $row["bpartnergroup_id"]);
                       $getHandler->DefineRecordFieldValue("bpartnergroup_name", $row["bpartnergroup_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

    public function showIndustry($wherestring){

        $this->log->showLog(2,"Run lookup showIndustry($wherestring)");
        $tablename="sim_industry";
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="industry_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  industry_id, industry_name
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["industry_id"]);
                       $getHandler->DefineRecordFieldValue("industry_id", $row["industry_id"]);
                       $getHandler->DefineRecordFieldValue("industry_name", $row["industry_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

   public function showTerms($wherestring){

        $this->log->showLog(2,"Run lookup showTerms($wherestring)");
        $tablename="sim_terms";
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="terms_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  terms_id, terms_name
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["terms_id"]);
                       $getHandler->DefineRecordFieldValue("terms_id", $row["terms_id"]);
                       $getHandler->DefineRecordFieldValue("terms_name", $row["terms_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

public function showUsergroup(){
        $this->log->showLog(2,"Run lookup showUsergroup()");
        $tablename="sim_groups";
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
      $sql = "SELECT  * 
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
    $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["groupid"]);
                       $getHandler->DefineRecordFieldValue("groupid", $row["groupid"]);
                       $getHandler->DefineRecordFieldValue("name", $row["name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

public function showEmployee($wherestring){

        $this->log->showLog(2,"Run lookup showEmployee($wherestring)");
        $tablename="sim_simedu_employee";
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="employee_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  employee_id, employee_name
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["employee_id"]);
                       $getHandler->DefineRecordFieldValue("employee_id", $row["employee_id"]);
                       $getHandler->DefineRecordFieldValue("employee_name", $row["employee_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }
}
?>

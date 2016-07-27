<?php

class Load_Data{
private $log;
private $xoopsDB;
public function Load_Data(){
    global $log,$xoopsDB;
    $this->log=$log;
    $this->xoopsDB=$xoopsDB;
}

public function showWindow($wherestring){
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    $tablename="sim_window";
    $searchmodule_id=$_GET['searchmodule_id'];
    $searchwindow_name=$_GET['searchwindow_name'];
    $searchfilename=$_GET['searchfilename'];
    $searchisactive=$_GET['searchisactive'];
    $searchisdeleted=$_GET['searchisdeleted'];


    $this->log->showLog(2,"Access ShowWindow($wherestring)");
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="mid";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

     if($searchisdeleted!="true")
           $wherestring.= " AND isdeleted=0";
     else
            $wherestring.= " AND isdeleted=1";

     if($searchfilename !="")
           $wherestring.= " AND filename LIKE '".$searchfilename."'";
    
    if($searchmodule_id >0)
           $wherestring.= " AND mid = ".$searchmodule_id."";
     if($searchwindow_name !="")
           $wherestring.= " AND window_name LIKE '".$searchwindow_name."'";

     if($searchisactive !="-")
           $wherestring.= " AND isactive =$searchisactive";


$newQuery = "SELECT  window_id, window_name, filename, description, windowsetting, parentwindows_id,
         isactive,seqno,mid,isdeleted
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $this->log->showLog(4,"With SQL: $newQuery");
        $query = $this->xoopsDB->query($newQuery);

         $getHandler->ProcessRecords();
        $getHandler->DefineField("filename");
     	$getHandler->DefineField("window_name");
        $getHandler->DefineField("filename");
        $getHandler->DefineField("description");
        $getHandler->DefineField("windowsetting");
        $getHandler->DefineField("parentwindows_id");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("seqno");
        $getHandler->DefineField("mid");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
	$currentRecord = 0; // This will assist us finding the ordinalStart position

      while ($row=$this->xoopsDB->fetchArray($query))
     {
                    $this->log->showLog(4,"SQL OK");

     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['window_id']);
             $getHandler->DefineRecordFieldValue("window_name", $row['window_name']);
             $getHandler->DefineRecordFieldValue("filename", $row['filename']);
             $getHandler->DefineRecordFieldValue("description", $row['description']);
             $getHandler->DefineRecordFieldValue("windowsetting", $row['windowsetting']);
             $getHandler->DefineRecordFieldValue("parentwindows_id", $row['parentwindows_id']);
             $getHandler->DefineRecordFieldValue("mid", $row['mid']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("seqno", $row['seqno']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);
             $getHandler->DefineRecordFieldValue("info","../recordinfo.php?id=".$row['window_id']."&tablename=sim_window&idname=window_id&title=Window");
             $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }
        $this->log->showLog(2,"complete ShowWindow()");

    }


public function showCurrency($wherestring){
    global $xoopsDB,$getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    $tablename="sim_currency";
    $searchcurrency_code=$_GET['searchcurrency_code'];
    $searchcurrency_name=$_GET['searchcurrency_name'];
    $searchisactive=$_GET['searchisactive'];
    $searchisdeleted=$_GET['searchisdeleted'];


    $this->log->showLog(2,"Access ShowCurrency($wherestring)");
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

     if($searchisdeleted!="true")
           $wherestring.= " AND isdeleted=0";
     else
            $wherestring.= " AND isdeleted=1";

     if($searchcurrency_code !="")
           $wherestring.= " AND currency_code LIKE '".$searchcurrency_code."'";

     if($searchcurrency_name !="")
           $wherestring.= " AND currency_name LIKE '".$searchcurrency_name."'";

     if($searchisactive !="-")
           $wherestring.= " AND isactive =$searchisactive";


$newQuery = "SELECT  currency_id, currency_code, currency_name, country_id, isactive,defaultlevel,isdeleted
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $this->log->showLog(4,"With SQL: $newQuery");
        $query = $xoopsDB->query($newQuery);

         $getHandler->ProcessRecords();
        $getHandler->DefineField("currency_code");
     	$getHandler->DefineField("currency_name");
     	$getHandler->DefineField("country_id");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("defaultlevel");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['currency_id']);
             $getHandler->DefineRecordFieldValue("currency_code", $row['currency_code']);
             $getHandler->DefineRecordFieldValue("currency_name",$row['currency_name']);
             $getHandler->DefineRecordFieldValue("country_id",$row['country_id']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("defaultlevel", $row['defaultlevel']);
             $getHandler->DefineRecordFieldValue("currency_id",$row['currency_id']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['currency_id']."&tablename=sim_currency&idname=currency_id&title=Currency");
             $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

public function showConversionRate($wherestring){
    global $xoopsDB,$getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring,$defaultorganization_id;
    $searchcurrency_id=$_GET['searchcurrency_id'];
    $tablename="sim_conversionrate";
    if($searchcurrency_id=="")
    $searchcurrency_id=0;

    $wherestring.=" AND currencyfrom_id=$searchcurrency_id";
    
    $this->log->showLog(2,"Access showConversionRate($wherestring)");
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="effectivedate";
        }

        if(empty($sortdirection)){
           $sortdirection="DESC";
        }

     if($searchisdeleted!="true")
           $wherestring.= " AND isdeleted=0";
     else
            $wherestring.= " AND isdeleted=1";



$newQuery = "SELECT  conversion_id, currencyfrom_id, currencyto_id, multiplyvalue,effectivedate, organization_id,description,
        isactive,isdeleted
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $this->log->showLog(4,"With SQL a: $newQuery");
        $query = $xoopsDB->query($newQuery);

         $getHandler->ProcessRecords();
        $getHandler->DefineField("currencyfrom_id");
        $getHandler->DefineField("currencyto_id");
        $getHandler->DefineField("multiplyvalue");
        $getHandler->DefineField("effectivedate");
        $getHandler->DefineField("description");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['conversion_id']);
             $getHandler->DefineRecordFieldValue("currencyfrom_id", $row['currencyfrom_id']);
             $getHandler->DefineRecordFieldValue("currencyto_id",$row['currencyto_id']);
             $getHandler->DefineRecordFieldValue("multiplyvalue",$row['multiplyvalue']);
             $getHandler->DefineRecordFieldValue("effectivedate",$row['effectivedate']);
             $getHandler->DefineRecordFieldValue("description",$row['description']);
             $getHandler->DefineRecordFieldValue("multiplyvalue",$row['multiplyvalue']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['conversion_id']."&tablename=sim_conversionrate&idname=conversion_id&title=Conversion");
             $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

public function showPeriod($wherestring){
    global $xoopsDB,$getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    $tablename="sim_period";
    $searchperiod_name=$_GET['searchperiod_name'];
    $searchisactive=$_GET['searchisactive'];
    $searchisdeleted=$_GET['searchisdeleted'];


    $this->log->showLog(2,"Access showPeriod($wherestring)");
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="period_name";
        }

        if(empty($sortdirection)){
           $sortdirection="DESC";
        }

     if($searchisdeleted!="true")
           $wherestring.= " AND isdeleted=0";
     else
            $wherestring.= " AND isdeleted=1";

     if($searchperiod_name !="")
           $wherestring.= " AND period_name LIKE '".$searchperiod_name."'";

     if($searchisactive !="-")
           $wherestring.= " AND isactive =$searchisactive";


$newQuery = "SELECT  period_id, period_name, isactive,defaultlevel,isdeleted,period_year,period_month
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $this->log->showLog(4,"With SQL: $newQuery");
        $query = $xoopsDB->query($newQuery);

         $getHandler->ProcessRecords();
        
     	$getHandler->DefineField("period_name");
        $getHandler->DefineField("period_year");
        $getHandler->DefineField("period_month");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("defaultlevel");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['period_id']);
             $getHandler->DefineRecordFieldValue("period_name", $row['period_name']);
             $getHandler->DefineRecordFieldValue("period_year",$row['period_year']);
             $getHandler->DefineRecordFieldValue("period_month",$row['period_month']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("defaultlevel", $row['defaultlevel']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);

             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['period_id']."&tablename=sim_period&idname=period_id&title=Period");
             $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

public function showRaces($wherestring){
    global $xoopsDB,$getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    $tablename="sim_races";
    $searchraces_name=$_GET['searchraces_name'];
    $searchisactive=$_GET['searchisactive'];
    $searchisdeleted=$_GET['searchisdeleted'];


    $this->log->showLog(2,"Access showRaces($wherestring)");
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="races_name";
        }

        if(empty($sortdirection)){
           $sortdirection="DESC";
        }

     if($searchisdeleted!="true")
           $wherestring.= " AND isdeleted=0";
     else
            $wherestring.= " AND isdeleted=1";

     if($searchraces_name !="")
           $wherestring.= " AND races_name LIKE '".$searchraces_name."'";

     if($searchisactive !="-")
           $wherestring.= " AND isactive =$searchisactive";


$newQuery = "SELECT  races_id, races_name, isactive,defaultlevel,isdeleted,races_description
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $this->log->showLog(4,"With SQL: $newQuery");
        $query = $xoopsDB->query($newQuery);

         $getHandler->ProcessRecords();

     	$getHandler->DefineField("races_name");
        $getHandler->DefineField("races_description");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("defaultlevel");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$xoopsDB->fetchArray($query))
     {
        $row['races_description']= $row['races_description'];
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['races_id']);
             $getHandler->DefineRecordFieldValue("races_name", $row['races_name']);
             $getHandler->DefineRecordFieldValue("races_description",$row['races_description']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("defaultlevel", $row['defaultlevel']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);

             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['races_id']."&tablename=$tablename&idname=races_id_id&title=Races");
             $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

public function showReligion($wherestring){
     global $xoopsDB,$getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    $tablename="sim_religion";
    $searchreligion_name=$_GET['searchreligion_name'];
    $searchisactive=$_GET['searchisactive'];
    $searchisdeleted=$_GET['searchisdeleted'];


    $this->log->showLog(2,"Access showReligion($wherestring)");
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="religion_name";
        }

        if(empty($sortdirection)){
           $sortdirection="DESC";
        }

     if($searchisdeleted!="true")
           $wherestring.= " AND isdeleted=0";
     else
            $wherestring.= " AND isdeleted=1";

     if($searchreligion_name !="")
           $wherestring.= " AND religion_name LIKE '".$searchreligion_name."'";

     if($searchisactive !="-")
           $wherestring.= " AND isactive =$searchisactive";


$newQuery = "SELECT  religion_id, religion_name, isactive,defaultlevel,isdeleted,religion_description
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $this->log->showLog(4,"With SQL: $newQuery");
        $query = $xoopsDB->query($newQuery);

         $getHandler->ProcessRecords();

     	$getHandler->DefineField("religion_name");
        $getHandler->DefineField("religion_description");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("defaultlevel");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['religion_id']);
             $getHandler->DefineRecordFieldValue("religion_name", $row['religion_name']);
             $getHandler->DefineRecordFieldValue("religion_description",$row['religion_description']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("defaultlevel", $row['defaultlevel']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);

             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['races_id']."&tablename=$tablename&idname=religion_id_id&title=Religion");
             $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

public function showTerms($wherestring){
    global $xoopsDB,$getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    $tablename="sim_terms";
    $searchterms_name=$_GET['searchterms_name'];
    $searchisactive=$_GET['searchisactive'];
    $searchisdeleted=$_GET['searchisdeleted'];


    $this->log->showLog(2,"Access showTerms($wherestring)");
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
           $sortdirection="DESC";
        }

     if($searchisdeleted!="true")
           $wherestring.= " AND isdeleted=0";
     else
            $wherestring.= " AND isdeleted=1";

     if($searchterms_name !="")
           $wherestring.= " AND terms_name LIKE '".$searchterms_name."'";

     if($searchisactive !="-")
           $wherestring.= " AND isactive =$searchisactive";


$newQuery = "SELECT  terms_id, terms_name, daycount,isactive,defaultlevel,isdeleted,description
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $this->log->showLog(4,"With SQL: $newQuery");
        $query = $xoopsDB->query($newQuery);

         $getHandler->ProcessRecords();

     	$getHandler->DefineField("terms_name");
        $getHandler->DefineField("description");
        $getHandler->DefineField("daycount");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("defaultlevel");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['terms_id']);
             $getHandler->DefineRecordFieldValue("terms_name", $row['terms_name']);
             $getHandler->DefineRecordFieldValue("daycount", $row['daycount']);
             $getHandler->DefineRecordFieldValue("description",$row['description']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("defaultlevel", $row['defaultlevel']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);

             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['terms_id']."&tablename=$tablename&idname=terms_id&title=Terms");
             $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

public function showBPartnerGroup($wherestring){
    global $xoopsDB,$getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    $tablename="sim_bpartnergroup";
    $searchbpartnergroup_name=$_GET['searchbpartnergroup_name'];
    $searchisactive=$_GET['searchisactive'];
    $searchisdeleted=$_GET['searchisdeleted'];


    $this->log->showLog(2,"Access showBPartnerGroup($wherestring)");
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
           $sortdirection="DESC";
        }

     if($searchisdeleted!="true")
           $wherestring.= " AND isdeleted=0";
     else
            $wherestring.= " AND isdeleted=1";

     if($searchbpartnergroup_name !="")
           $wherestring.= " AND bpartnergroup_name LIKE '".$searchbpartnergroup_name."'";

     if($searchisactive !="-")
           $wherestring.= " AND isactive =$searchisactive";


$newQuery = "SELECT  bpartnergroup_id, bpartnergroup_name, debtoraccounts_id,creditoraccounts_id,isactive,defaultlevel,isdeleted,description
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $this->log->showLog(4,"With SQL: $newQuery");
        $query = $xoopsDB->query($newQuery);

         $getHandler->ProcessRecords();

     	$getHandler->DefineField("bpartnergroup_name");
        $getHandler->DefineField("debtoraccounts_id");
        $getHandler->DefineField("creditoraccounts_id");
        $getHandler->DefineField("description");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("defaultlevel");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['bpartnergroup_id']);
             $getHandler->DefineRecordFieldValue("bpartnergroup_name", $row['bpartnergroup_name']);
             $getHandler->DefineRecordFieldValue("debtoraccounts_id", $row['debtoraccounts_id']);
             $getHandler->DefineRecordFieldValue("creditoraccounts_id", $row['creditoraccounts_id']);
             $getHandler->DefineRecordFieldValue("description",$row['description']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("defaultlevel", $row['defaultlevel']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);

             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['bpartnergroup_id']."&tablename=$tablename&idname=bpartnergroup_id&title=BPartnerGroup");
             $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

public function showFollowUpType($wherestring){
    global $xoopsDB,$getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    $tablename="sim_followuptype";
    $searchfollowuptype_name=$_GET['searchfollowuptype_name'];
    $searchisactive=$_GET['searchisactive'];
    $searchisdeleted=$_GET['searchisdeleted'];


    $this->log->showLog(2,"Access showFollowUpType($wherestring)");
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="followuptype_name";
        }

        if(empty($sortdirection)){
           $sortdirection="DESC";
        }

     if($searchisdeleted!="true")
           $wherestring.= " AND isdeleted=0";
     else
            $wherestring.= " AND isdeleted=1";

     if($searchfollowuptype_name !="")
           $wherestring.= " AND followuptype_name LIKE '".$searchfollowuptype_name."'";

     if($searchisactive !="-")
           $wherestring.= " AND isactive =$searchisactive";


$newQuery = "SELECT  followuptype_id, followuptype_name,isactive,defaultlevel,isdeleted,description
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $this->log->showLog(4,"With SQL: $newQuery");
        $query = $xoopsDB->query($newQuery);

         $getHandler->ProcessRecords();

     	$getHandler->DefineField("followuptype_name");
        $getHandler->DefineField("description");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("defaultlevel");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['followuptype_id']);
             $getHandler->DefineRecordFieldValue("followuptype_name", $row['followuptype_name']);
             $getHandler->DefineRecordFieldValue("description",$row['description']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("defaultlevel", $row['defaultlevel']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);

             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['followuptype_id']."&tablename=$tablename&idname=followuptype_id&title=FollowUpType");
             $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

    public function showBPartner($wherestring){
    global $xoopsDB,$getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    $tablename="sim_bpartner";
    $searchbpartner_name=$_GET['searchbpartner_name'];
    $searchisactive=$_GET['searchisactive'];
    $searchisdeleted=$_GET['searchisdeleted'];


    $this->log->showLog(2,"Access showBPartner($wherestring)");
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="bpartner_name";
        }

        if(empty($sortdirection)){
           $sortdirection="DESC";
        }

     if($searchisdeleted!="true")
           $wherestring.= " AND isdeleted=0";
     else
            $wherestring.= " AND isdeleted=1";

     if($searchbpartner_name !="")
           $wherestring.= " AND bpartner_name LIKE '".$searchbpartner_name."'";

     if(isset($_GET['filterstring'])){
         if($_GET['filterstring']!="all")
             $wherestring.= " AND bpartner_name LIKE '".$_GET['filterstring']."%'";

         }

     if($searchisactive =="1")
           $wherestring.= " AND isactive =1";
     elseif($searchisactive =="0")
           $wherestring.= " AND isactive =0";
     elseif($searchisactive =="")
           $wherestring.= " AND isactive =999"; // hide all data

$newQuery = "SELECT  bpartner_id,bpartner_no, bpartner_name, bpartnergroup_id, companyno, industry_id,terms_id,isactive,
            defaultlevel,isdeleted,description
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $this->log->showLog(4,"With SQL: $newQuery");
        $query = $xoopsDB->query($newQuery);

         $getHandler->ProcessRecords();

     	$getHandler->DefineField("bpartner_no");
        $getHandler->DefineField("bpartner_name");
        $getHandler->DefineField("bpartnergroup_id");
        $getHandler->DefineField("companyno");
        $getHandler->DefineField("industry_id");
        $getHandler->DefineField("terms_id");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("defaultlevel");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['bpartner_id']);
             $getHandler->DefineRecordFieldValue("bpartner_no", $row['bpartner_no']);
             $getHandler->DefineRecordFieldValue("bpartner_name", $row['bpartner_name']);
             $getHandler->DefineRecordFieldValue("companyno", $row['companyno']);
             $getHandler->DefineRecordFieldValue("bpartnergroup_id", $row['bpartnergroup_id']);
             $getHandler->DefineRecordFieldValue("industry_id",$row['industry_id']);
             $getHandler->DefineRecordFieldValue("terms_id",$row['terms_id']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("defaultlevel", $row['defaultlevel']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['bpartner_id']."&tablename=$tablename&idname=bpartner_id&title=BPartner");
             $getHandler->DefineRecordFieldValue("bpartner_id", $row['bpartner_id']);

            $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }

    }

public function showWorkflow($wherestring){
    global $xoopsDB,$getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    $tablename="sim_workflow";
    $searchworkflow_code=$_GET['searchworkflow_code'];
    $searchworkflow_name=$_GET['searchworkflow_name'];
    $searchisactive=$_GET['searchisactive'];

    $this->log->showLog(2,"Access ShowWorkflow($wherestring)");
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="workflow_code";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

     if($searchisdeleted!="true")
           $wherestring.= " AND isdeleted=0";
     else
            $wherestring.= " AND isdeleted=1";

     if($searchworkflow_code !="")
           $wherestring.= " AND workflow_code LIKE '%".$searchworkflow_code."%'";

     if($searchworkflow_name !="")
           $wherestring.= " AND workflow_name LIKE '%".$searchworkflow_name."%'";

     if($searchisactive !="-")
           $wherestring.= " AND isactive =$searchisactive";


$newQuery = "SELECT  *
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $this->log->showLog(4,"With SQL: $newQuery");
        $query = $xoopsDB->query($newQuery);

         $getHandler->ProcessRecords();
         $getHandler->DefineField("workflow_id");
        $getHandler->DefineField("workflow_code");
     	$getHandler->DefineField("workflow_name");
     	$getHandler->DefineField("workflow_description");
     	$getHandler->DefineField("workflow_ownergroup");
        $getHandler->DefineField("workflow_owneruid");
        $getHandler->DefineField("workflow_email");
     	$getHandler->DefineField("isactive");
        //$getHandler->DefineField("defaultlevel");
        $getHandler->DefineField("isdeleted");
        $getHandler->DefineField("info");
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
                $getHandler->CreateNewRecord($row['workflow_id']);
                $getHandler->DefineRecordFieldValue("workflow_id", $row['workflow_id']);
                $getHandler->DefineRecordFieldValue("workflow_code", $row['workflow_code']);
                $getHandler->DefineRecordFieldValue("workflow_name",$row['workflow_name']);
                $getHandler->DefineRecordFieldValue("workflow_description",$row['workflow_description']);
                $getHandler->DefineRecordFieldValue("workflow_ownergroup",$row['workflow_ownergroup']);
                $getHandler->DefineRecordFieldValue("workflow_owneruid",$row['workflow_owneruid']);
                $getHandler->DefineRecordFieldValue("workflow_email",$row['workflow_email']);
                $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
                //$getHandler->DefineRecordFieldValue("defaultlevel", $row['defaultlevel']);
                $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);
                $getHandler->DefineRecordFieldValue("rh",$rh);
                $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['workflow_id']."&tablename=sim_workflow&idname=workflow_id&title=Workflow");
                $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }
            $this->log->showLog(2,"complete function showWorkflow()");

    }

}


?>

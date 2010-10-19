<?php

class BPartnerLookup extends Lookup{

    public function BPartnerLookup(){
        
        global $log,$xoopsDB;
        $this->log=$log;
        $this->xoopsDB=$xoopsDB;
    }


      public function showBPartnerCombo($wherestring){

             global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$showNull;


    $bpartnertype=$_GET['bpartnertype'];
    $bpartnertypecontrolstr="";
    if($bpartnertype=="isdebtor")
         $bpartnertypecontrolstr.=" and isdebtor=1";
    elseif($bpartnertype=="iscreditor")
         $bpartnertypecontrolstr.=" and iscreditor=1";

  if($showNull!="Y")
            $showNullsubstr=" and bpartner_id >0 and isactive=1 $bpartnertypecontrolstr";
  else
            $showNullsubstr=" and (bpartner_id >0 and isactive=1 $bpartnertypecontrolstr) or bpartner_id=0";

    $bpartner_id=$_GET['bpartner_id'];
  if($bpartner_id>0)
    $showNullsubstr.=" or bpartner_id=$bpartner_id";

        $pageSize = 0;
	if (isset($_GET['PageSize'])) {
		$pageSize = $_GET['PageSize'];
	}

	if ($pageSize < 1) {
		$pageSize=25;
	}

	$startingRecordIndex = 0;
	if (isset($_GET['StartingRecordIndex'])) {
		$startingRecordIndex = $_GET['StartingRecordIndex'];
	}

	if ($startingRecordIndex < 1) {
		$startingRecordIndex=0;
	}

	$searchSubString = "";
	if (isset($_GET['SearchSubstring']) && $_GET['SearchSubstring'] != "Please Select") {
		$searchSubString = $_GET['SearchSubstring'];
	}

	$lastString = "";
	if (isset($_GET['LastString'])) {
		$lastString = $_GET['LastString'];
	}

        $orderstring = " ORDER BY bpartner_name ASC ";

       $newpagesize=$startingRecordIndex+$pageSize;


      $sql = "SELECT  bpartner_id, concat(bpartner_name,'(',bpartner_no,')') as bpartner_name ".
                " FROM sim_bpartner WHERE concat(bpartner_name,'(',bpartner_no,')') LIKE '%s'  $showNullsubstr ".
               " $orderstring LIMIT $startingRecordIndex, $newpagesize";

       $sql = sprintf($sql,"%".$searchSubString."%","%".$searchSubString."%");

                $this->log->showLog(4," showBPartnerCombo with SQL: $sql:".print_r($_GET,true));

        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["bpartner_id"]);
                       $getHandler->DefineRecordFieldValue("bpartner_id", $row["bpartner_id"]);
                       $getHandler->DefineRecordFieldValue("bpartner_name", $row["bpartner_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }
    }



      public function showBPartnerGridLookup($wherestring){

            $this->log->showLog(2,"Run lookup getSelectBpartner()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;

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
           $sortdirection="ASC";
        }
       $sql = "SELECT * FROM sim_bpartner lk
              $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

       $currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["bpartner_id"]);
                       $getHandler->DefineRecordFieldValue("bpartner_id", $row["bpartner_id"]);
                       $getHandler->DefineRecordFieldValue("bpartner_name", $row["bpartner_name"] );
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }
    }
  
}
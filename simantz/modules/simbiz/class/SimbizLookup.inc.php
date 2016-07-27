<?php
class SimbizLookup extends Lookup{

    public function SimbizLookup(){
        global $log,$xoopsDB;
        $this->log=$log;
        $this->xoopsDB=$xoopsDB;
    }


      public function showBPartnerCombo($wherestring){

             global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$showNull;

  if($showNull!="Y")
            $showNullsubstr=" and bpartner_id >0 and isactive=1";
  else
            $showNullsubstr=" and (bpartner_id >0 and isactive=1) or bpartner_id=0";

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

                $this->log->showLog(4," with SQL: $sql");

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



public function getSelectAccountGridLookup($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectAccount()");
        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring,$iseditbpartner,$searchstring;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="accountcode_full";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }


        if($iseditbpartner == "N")
        $wherestring .= " and ac.account_type NOT IN (2,3) ";

   // $wherestring .= " and concat(ac.accountcode_full,'-',ac.accounts_name) LIKE '%$searchstring%'";
       $sql = "SELECT ac.accounts_id,concat(ac.accountcode_full,'-',ac.accounts_name) as accounts_name FROM sim_simbiz_accounts ac ".
            " $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql," );
       $this->log->showLog(4," search string: $searchstring, Request:".print_r($_REQUEST,true) );

       $query = $this->xoopsDB->query($sql);

      $currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["accounts_id"]);
                       $getHandler->DefineRecordFieldValue("accounts_id", $row["accounts_id"]);
                       $getHandler->DefineRecordFieldValue("accounts_name", $row["accounts_name"] );
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }
  
  }

  public function getSelectBranch($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectBranch()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring,$uid;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="org.organization_code";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }


        $wheregroup = " AND groupid IN (SELECT groupid FROM sim_groups_users_link WHERE uid = '%d' ) ";

      $sql = sprintf("SELECT * FROM sim_organization org $wherestring $wheregroup ORDER BY " . $sortcolumn . " " . $sortdirection .";",$uid);


       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

       $currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["organization_id"]);
                       $getHandler->DefineRecordFieldValue("organization_id", $row["organization_id"]);
                       $getHandler->DefineRecordFieldValue("organization_code", $row["organization_code"]);
                       $getHandler->SaveRecord();
                       $this->log->showLog(4," with CurrentRecord: $currentRecord");
           //  $getHandler->CompleteGet();

            }
      }
  }

public function getSelectTrack($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectTrack()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="track_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
       $sql = "SELECT * FROM sim_simbiz_track tr
              $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

       $currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["track_id"]);
                       $getHandler->DefineRecordFieldValue("track_id", $row["track_id"]);
                       $getHandler->DefineRecordFieldValue("track_name", $row["track_name"] );
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }
  }


public function getSelectTax($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectTax()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="tax_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
       $sql = "SELECT * FROM sim_simbiz_tax lk
              $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

       $currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["tax_id"]);
                       $getHandler->DefineRecordFieldValue("tax_id", $row["tax_id"]);
                       $getHandler->DefineRecordFieldValue("tax_name", $row["tax_name"] );
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }
  }


  
}
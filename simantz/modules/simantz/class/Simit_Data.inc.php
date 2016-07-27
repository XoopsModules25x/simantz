<?php
/*
 * This class store important save activity, control field type as %s,%d, and %f only
 * Save activity category include I-Insert, U-Update, D-TemporaryDelete,E-Permanently Delete
 * Event typ include: S-success,F-failed
 */

class Simit_Data{

private $xoopsDB;
private $log;
public $failfeedback;
public $latestid;
public function Simit_Data(){
    global $xoopsDB,$log;
    $this->xoopsDB=$xoopsDB;
    $this->log=$log;
    
    }

public function SelectRecord($sql,$arrvalue){

    $query=$this->xoopsDB->query($sql);

    return $query;
}



}
?>
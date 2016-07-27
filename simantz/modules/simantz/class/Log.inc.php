<?php

class Log{
/*
 *0=no log,1=error,2=warning,3=activity,4=All Information
 */
public $loglvl;
private $updatestr="";

public function Log(){
global $loglevel,$logfile;
$this->logfile=$logfile;
$this->loglvl=$loglevel;
$this->showLog(4,"initialize log");
}

public function showLog($evenlvl,$msg){

        
	if($this->loglvl>=$evenlvl){
            
            $fh = fopen($this->logfile, 'a') or die("can't open log file: $this->logfile");
            $timestamp= date("y/m/d H:i:s", time());
            fwrite($fh, "$timestamp($evenlvl): $msg\n");
            fclose($fh);
	}
}/*
public function showLog($evenlvl,$msg){

        
	if($this->loglvl>=$evenlvl){
		if($evenlvl==1)
		echo "<b style='color:red'>$msg</b><br/>";
		else
		echo "$msg<br/>";
   	}
}
*/

public function cleanLog(){

            $myFile = "log.txt";
            $fh = fopen($myFile, 'w') or die("can't open file");
            $timestamp= date("y/m/d H:i:s", time());
            fwrite($fh, "$timestamp: log cleaned\n");
            fclose($fh);
	
}

public function saveLog($recordid,$tablename,$sql,$category,$eventype){
		global $xoopsDB,$userid;
		$updated=date("y/m/d H:i:s", time()) ;
		$sql=str_replace('"', "\"", $sql );
		$sql=str_replace("'", "\'", $sql );
	$sql="Insert into sim_audittrial (tablename,sqlstr,category,uid,updated,record_id,eventype)
			values('$tablename','$sql','$category',$userid,'$updated',$recordid,'$eventype')";
	//echo $sql;
		$rs=$xoopsDB->query($sql);
 // $log->saveLog(0,"sim_simtrain_room","$o->changesql","I","F");
 // I = insert, U=update, D=Delete
 //O = success, F = Failed
	}

        
}
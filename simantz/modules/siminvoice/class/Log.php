<?php

class Log{
/*
 *0=no log,1=error,2=warning,3=activity,4=All Information
 */
public $loglvl;

public function Log($loglvl=0){
$this->loglvl=$loglvl;
}

public function showLog($evenlvl,$msg){
$timestamp= date("y/m/d H:i:s", time());
	if($this->loglvl>$evenlvl)
		echo "$timestamp: $msg<br>";
	
}

}

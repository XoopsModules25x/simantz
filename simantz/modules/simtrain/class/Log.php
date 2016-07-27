<?php

class Log{
/*
 *0=no log,1=error,2=warning,3=activity,4=All Information
 */
public $loglvl;

public function Log(){
global $loglevel;
$this->loglvl=$loglevel;
}

public function showLog($evenlvl,$msg){
$timestamp= date("y/m/d H:i:s", time());
	if($this->loglvl>=$evenlvl){
		if($evenlvl==1)
		echo "<b style='color:red'>$timestamp: $msg</b><br>";
		else
		echo "$timestamp: $msg<br>";
	}
}

}

<?php

class SendMessage{

public $smsurl="";
public $smsowner_id=0;
public $smspassword="";
public $smssender_name="";
public $msg="";
public $lang_type="E";
public $subscriber_number="";
public $arraynumber;
public $urlchecksmsbalance;
public $smtpserver="";
public $smtpuser="";
public $smtppassword="";
public $message="";
public $emailtitle="";
public $receipient="";
public $log;

public function SendMessage(){
global $smtpserver,$smtpuser,$smtppassword,$senderuser,$smsurl,$smsid,
        $smspassword,$smssender_name,$log,$urlchecksmsbalance;
	$this->smsurl=$smsurl;
        $this->urlchecksmsbalance=$urlchecksmsbalance;
	$this->smsowner_id=$smsid; 
        $this->smspassword=$smspassword;
	$this->smssender_name=$smssender_name;
        $this->subscriber_number="";
	$this->lang_type="E";
	$this->smtpserver=$smtpserver;
	$this->smtpuser=$smtpuser;
	$this->smtppassword=$smtppassword;
	$this->message="";
	$this->emailtitle="";

}

public function convertArrayToNumber(){
global $defaulttelcode;

 $removestring=array("(", ")", "-", " ","\n","\0","\t","\r");

 foreach($this->arraynumber as $num){
	
        if($defaulttelcode==60){//Malaysia Standard
            if(substr($num,0,1)=="0")
                        $num="6".$num;
            if(strlen($num)!=11)
                $num="";
            else
                $this->subscriber_number.=$num."@";
        }
        else{
	$this->subscriber_number.=$num."@";
        }
  }
 
 } 


public function sendsms(){


    //echo "owner_id=$this->smsowner_id&password=$this->smspassword&sender_name=$this->smssender_name&lang_type=$this->lang_type&subscriber_num=$this->subscriber_number&msg=$this->message <br>";

    //echo "Balance Credit:";
	$curl_connection = curl_init($this->smsurl);
	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl_connection, CURLOPT_USERAGENT,
		"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, false);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl_connection, CURLOPT_POST ,1);
	curl_setopt ($curl_connection, CURLOPT_POSTFIELDS, 
	"owner_id=$this->smsowner_id&password=$this->smspassword&sender_name=$this->smssender_name&lang_type=$this->lang_type&subscriber_num=$this->subscriber_number&msg=$this->message");
	 curl_setopt ($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
	 $result= curl_exec ($curl_connection);
 	curl_close ($curl_connection);
    
//    $curl_connection=curl_init( $this->urlchecksmsbalance);
//	curl_setopt($curl_connection, CURLOPT_USERAGENT,
//		"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
//	 curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, false);
//	 curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt ($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
//	 $result= curl_exec ($curl_connection);
// 	 curl_close ($curl_connection);
     sleep(5);
//     echo " SMS";
  }


  }
?>



































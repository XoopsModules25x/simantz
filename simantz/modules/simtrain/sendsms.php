<?php
include_once "system.php";
include_once "menu.php";

$url=$smsurl;
$owner_id=$smsid;
$password=$smspassword;
$sender_name=$smssender_name;
$msg=$_POST["msg"];
$lang_type=$_POST["lang_type"];
$parentshplist=$_POST["parentshplist"];
$parentshplist2=$_POST["parentshplist2"];
$studenthplist=$_POST["studenthplist"];
$subscriber_number=$studenthplist.$parentshplist.$parentshplist2 . "";


if(isset($_POST["submit"])){



$postdata="";
$removestring=array("(", ")", "-", " ","\n","\0","\t","\r");
$subscriber_number=str_replace($removestring,  "", $subscriber_number);
//$subscriber_number=trim($subscriber_number);

$arraynumber=array_merge(array_unique(explode(",",$subscriber_number)));
//print_r($arraynumber);

$subscriber_number=implode("@",$arraynumber);
$subscriber_number=str_replace(",",  "@",$subscriber_number);
//echo "....".substr($subscriber_number,-2,1 )."..<br>";
//echo "<textarea cols=100 rows=20>$subscriber_number</textarea>";
while(substr($subscriber_number,-1 )=="@" || substr($subscriber_number,-1 )=="\n")
	$subscriber_number=substr_replace($subscriber_number,"",-1);


echo <<< EOF
url=$url<br>
owner_id=$owner_id<br>
password=$password<br>
sender_name=$sender_name<br>
lang_type=$lang_type<br>
subscriber_number=$subscriber_number<br>
msg=$msg

EOF;

	$curl_connection = curl_init($url);
	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl_connection, CURLOPT_USERAGENT,
		"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, false);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl_connection, CURLOPT_POST ,1);
	curl_setopt ($curl_connection, CURLOPT_POSTFIELDS, 
		"owner_id=$owner_id&password=$password&sender_name=$sender_name&lang_type=$lang_type&subscriber_number=$subscriber_number&msg=$msg");
//	curl_setopt ($curl_connection, CURLOPT_POSTFIELDS, 
//		"username=0127095123&password=abcabc");
	 curl_setopt ($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
	 $result= curl_exec ($curl_connection);
//print_r(curl_getinfo($curl_connection));
 	curl_close ($curl_connection);

//echo "result: $result <br>owner_id=$owner_id&password=$password&sender_name=$sender_name&msg=$msg&lang_type=$lang_type&subscriber_num=$subscriber_number<br>";

}

?>

<?php
include_once "../simantz/class/PHPJasperXML.inc";
include_once('../simantz/class/fpdf/fpdf.php');
include_once('../../mainfile.php');

/*$data=$_POST['a'];
$select=$_POST['select'];
$i=0;
$para="";
	foreach($data as $line){
	$line ."->".$select[$i]."<br>";
	if($select[$i]=="on")
	$para=$para.$line.",";
	$i++;
	}
$para=substr($para,0,-1);
*/

$para=$_GET['reminder_id'];

$xml = simplexml_load_file('student_reminder.jrxml'); //file name
$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->arrayParameter=array("reminder_id"=>$para);
$PHPJasperXML->xml_dismantle($xml);
$PHPJasperXML->transferDBtoArray(XOOPS_DB_HOST,XOOPS_DB_USER,XOOPS_DB_PASS,XOOPS_DB_NAME);//$PHPJasperXML->transferDBtoArray(url,dbuser,dbpassword,db);
$PHPJasperXML->outpage("I");	//page output method I:standard output	D:Download file	F:Save to local file	S:Return as a string
//$PHPJasperXML->test();//test's function

?>


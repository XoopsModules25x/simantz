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

if(isset($_POST['overtime_id']))
$overtime_id = $_POST['overtime_id'];
else
$overtime_id = $_GET['overtime_id'];

$xml = simplexml_load_file('viewovertime.jrxml'); //file name
$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->arrayParameter=array("ot_id"=>$overtime_id);
$PHPJasperXML->xml_dismantle($xml);
$PHPJasperXML->transferDBtoArray(XOOPS_DB_HOST,XOOPS_DB_USER,XOOPS_DB_PASS,XOOPS_DB_NAME);//$PHPJasperXML->transferDBtoArray(url,dbuser,dbpassword,db);
$PHPJasperXML->outpage("I");	//page output method I:standard output	D:Download file	F:Save to local file	S:Return as a string
//$PHPJasperXML->test();//test's function


/*
include_once('../../class/fpdf/fpdf.php');
include_once('../system/class/XMLReportLibrary.php');
include "system.php";

if($_POST || $_GET){


if(isset($_POST['overtime_id']))
$overtime_id = $_POST['overtime_id'];
else
$overtime_id = $_GET['overtime_id'];

$fp = fopen("viewovertime.jrxml","r");
//$fp = fopen("purchaseorder.jrxml","r");
$xml = fread($fp, 1000000);
fclose($fp);
$xml_parser = new xml(XOOPS_DB_HOST,XOOPS_DB_USER,XOOPS_DB_PASS,XOOPS_DB_NAME);
$xml_parser->arrayParameter=array("ot_id"=>$overtime_id);
//$xml_parser->arrayParameter=array("salesorder_id"=>"14");
$xml_parser->parse($xml);
$dom = $xml_parser->dom;
$xml_parser->disconnect();
}
else{

include_once footer();
}
*/


?>

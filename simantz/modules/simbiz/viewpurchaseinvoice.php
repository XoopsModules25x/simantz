<?php
include "system.php";
include_once('../simantz/class/fpdf/fpdf.php');
include_once("../simantz/class/PHPJasperXML.inc");

//$fp = fopen("jasperxml/salesquotation.jrxml","r");
$xml =  simplexml_load_file("purchaseinvoice.jrxml");
//fclose($fp);
$invoice_id=$_GET['invoice_id'];
$PHPJasperXML = new PHPJasperXML();
//$PHPJasperXML->debugsql=true;
$PHPJasperXML->arrayParameter=array("invoice_id"=>"$invoice_id");
$PHPJasperXML->xml_dismantle($xml);

$PHPJasperXML->transferDBtoArray(XOOPS_DB_HOST,XOOPS_DB_USER,XOOPS_DB_PASS,XOOPS_DB_NAME);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file
?>

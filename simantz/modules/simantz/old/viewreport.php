<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
	include_once ('../../mainfile.php');
	include_once (XOOPS_ROOT_PATH.'/header.php');

include_once('class/tcpdf/tcpdf.php');
include_once("class/PHPJasperXML.inc");



$xml =  simplexml_load_file("viewreport.jrxml");

$id=1;
$PHPJasperXML = new PHPJasperXML("en","TCPDF");
$PHPJasperXML->debugsql=false;
$PHPJasperXML->arrayParameter=array("id"=>$id);
$PHPJasperXML->xml_dismantle($xml);
//echo XOOPS_DB_HOST.XOOPS_DB_USER.XOOPS_DB_PASS.XOOPS_DB_NAME;
$PHPJasperXML->transferDBtoArray(XOOPS_DB_HOST,XOOPS_DB_USER,XOOPS_DB_PASS,XOOPS_DB_NAME);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file


?>


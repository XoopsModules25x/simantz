<?php
include "system.php";
include_once('../simantz/class/fpdf/fpdf.php');
include_once("../simantz/class/PHPJasperXML.inc");
$companyname= "$o->company_name ($o->companyno)";
$company_addressinfo= "$o->street1 $o->street2 	$o->street3\n".
        "$o->city $o->state $o->country_name\n".
        "Tel: $o->tel_1 $o->tel_2 Fax: $o->fax \nWeb:$o->url Email: $o->email";
//$fp = fopen("jasperxml/salesquotation.jrxml","r");
$xml =  simplexml_load_file("bpartnerstatement.jrxml");
//fclose($fp);
$bpartnerlist=implode(",",$_GET['bpartner_array']);

$reporttype=$_GET['reporttype'];
if($reporttype=='d')
    $accounttype="debtor";
elseif($reporttype=='c')
    $accounttype="creditor";
else
    {
    echo "Cannot generate this report due to parameter error";
    exit(1);
    }

$enddate=$_GET['enddate'];
$startdate=$_GET['startdate'];
$statementdate=$_GET['statementdate'];
//echo print_r($_GET);
$PHPJasperXML = new PHPJasperXML();
//$PHPJasperXML->debugsql=true;
$PHPJasperXML->arrayParameter=array("statementdate"=>$statementdate,"bpartnerlist"=>$bpartnerlist,
        "accounttype"=>$accounttype,"startdate"=>$startdate,"enddate"=>$enddate,
        "company_name"=>$companyname,"company_addressinfo"=>$company_addressinfo);

$PHPJasperXML->xml_dismantle($xml);

$PHPJasperXML->transferDBtoArray(XOOPS_DB_HOST,XOOPS_DB_USER,XOOPS_DB_PASS,XOOPS_DB_NAME);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file

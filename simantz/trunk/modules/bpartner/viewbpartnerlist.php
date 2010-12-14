<?php
include "system.php";
include_once "../simantz/class/PHPJasperXML.inc";
include_once "../simantz/class/fpdf/fpdf.php";

//include_once "../simantz/class/tcpdf/tcpdf.php";
//include_once "../simantz/class/Organization.inc.php";
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


if(isset($_POST['pubReport'])){
$org=new Organization();
$org->fetchOrganization($defaultorganization_id);
$organization_name=$org->organization_name;
$company_no=$org->companyno;

$searchbpartner_no=$_POST['searchbpartner_no'];
$searchbpartnergroup_id=$_POST['searchbpartnergroup_id'];
$companyno=$_POST['companyno'];

$searchindustry_id=$_POST['searchindustry_id'];
$bpartner_name=$_POST['bpartner_name'];

$searchterms_id=$_POST['searchterms_id'];
$searchtype=$_POST['searchtype'];
$searchisactive=$_POST['searchisactive'];

$xml = simplexml_load_file('businesspartnerlist.jrxml'); //file name

$PHPJasperXML = new PHPJasperXML();
//$PHPJasperXML->debugsql=true;



if($searchbpartner_no != 0 && $searchbpartner_no!="")
    $wherestring .=" AND bp.bpartner_no='$searchbpartner_no'";
if($searchbpartnergroup_id != 0 && $searchbpartnergroup_id!="")
    $wherestring .=" AND bp.bpartnergroup_id='$searchbpartnergroup_id'";
if($companyno != 0 && $companyno!="")
    $wherestring .=" AND bp.companyno='$companyno'";

if($bpartner_name != 0 && $bpartner_name!="")
    $wherestring .=" AND bp.bpartner_name='$bpartner_name'";
if($searchindustry_id != 0 && $searchindustry_id!="")
    $wherestring .=" AND bp.industry_id='$searchindustry_id'";

if($searchterms_id != 0 && $searchterms_id!="")
    $wherestring .=" AND bp.terms_id='$searchterms_id'";

if($searchtype =="C")
    $wherestring .=" AND bp.isdebtor=1";
else if($searchtype =="S")
    $wherestring .=" AND bp.iscreditor=1";

if($searchisactive != -1 && $searchisactive!="")
    $wherestring .=" AND bp.isactive='$searchisactive'";

$PHPJasperXML->arrayParameter=array("companyname"=>$organization_name, "companyno"=>$company_no, "wherestring"=>$wherestring);
$PHPJasperXML->xml_dismantle($xml);
$PHPJasperXML->transferDBtoArray(XOOPS_DB_HOST,XOOPS_DB_USER,XOOPS_DB_PASS,XOOPS_DB_NAME);//$PHPJasperXML->transferDBtoArray(url,dbuser,dbpassword,db);
$PHPJasperXML->outpage("I");
}
else {
    include "menu.php";
    include_once "../bpartner/class/Report.inc.php";
    include_once "../simantz/class/SelectCtrl.inc.php";
    $o=new Report();
    $ctrl= new SelectCtrl();
    $year=date("Y", time()) ;
 
    $o->searchbpartnergroupctrl=$bpctrl->getSelectBPartnerGroup('','Y');
    $o->searchindustryctrl=$bpctrl->getSelectIndustry('','Y');
    $o->searchtermsctrl=$bpctrl->getSelectTerms('','Y');

    $o->showBpartnerListForm();

    require(XOOPS_ROOT_PATH.'/footer.php');
}

?>

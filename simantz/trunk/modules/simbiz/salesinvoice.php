<?php
include_once "system.php";
include_once 'class/Invoice.inc.php';

include "class/nitobi.xml.php";
if($havewriteperm==1){
   $permctrl=" rowinsertenabled=\"true\"      rowdeleteenabled=\"true\"      toolbarenabled=\"true\"      ";
}
else{
   $permctrl=" rowinsertenabled=\"false\"   autosaveenabled=\"false\"   rowdeleteenabled=\"false\"      toolbarenabled=\"false\"      ";
}

$action=$_REQUEST['action'];

$o = new Invoice();

$o->issotrx=1;
$o->documenttype=1;//1=invoice, 2=cashbill saverecord
$o->updated=date("Y-m-d H:i:s",time());
$o->updatedby=$xoopsUser->getVar("uid");

//display standard web component
if($action=="edit" || $action=="" || $action="showsearchform")
    {
        include "menu.php";
        $xoTheme->addStylesheet("$url/modules/simantz/include/popup.css");
        $xoTheme->addScript("$url/modules/simantz/include/popup.js");
        $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.css");
        $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.toolkit.js");
        $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.js");
        $xoTheme->addScript("$url/modules/simantz/include/firefox3_6fix.js");
        $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
    }
    
switch($action){
    case "showsearchform":
       echo $o->showSearchForm();
       require(XOOPS_ROOT_PATH.'/footer.php');
    break;
    case "ajaxsearch":
        
        break;
    case "edit":
        
        if($o->fetchInvoice($_GET['invoice_id']))
        {

        echo $o->gridjs();
        echo $o->getInputForm();
        
        }
          else{
            echo "cannot access database";
       
          }
        require(XOOPS_ROOT_PATH.'/footer.php');
      
        break;
    case "ajaxtest":

        $o->getGrid($_GET['invoice_id']);
        break;
    case "ajaxsave":
    $o->invoice_id=$_POST['invoice_id'];
    $o->document_no=$_POST['document_no'];
    $o->document_date=$_POST['document_date'];
    
    $o->baseamt=$_POST['baseamt'];
    $o->currency_id=$_POST['currency_id'];
    $o->exchangerate=$_POST['exchangerate'];
    $o->originalamt=$_POST['originalamt'];
    $o->ref_no=$_POST['ref_no'];
    $o->description=$_POST['description'];
    $o->bpartner_id=$_POST['bpartner_id'];
    $o->iscomplete=$_POST['iscomplete'];
    $o->bpartneraccounts_id=51;//$_POST[''];
    $o->spinvoice_prefix=$_POST['spinvoice_prefix'];
    $o->terms_id=$_POST['terms_id'];
    $o->contacts_id=$_POST['contacts_id'];
    $o->preparedbyuid=$_POST['preparedbyuid'];
    $o->salesagentname=$_POST['salesagentname'];
    $o->localamt=$_POST['localamt'];
    $o->address_text=$_POST['address_text'];
    $o->branch_id=$_POST['branch_id'];
    $o->tracking1_id=$_POST['tracking1_id'];
    $o->tracking2_id=$_POST['tracking2_id'];
    $o->tracking3_id=$_POST['tracking3_id'];
    $o->griddata=$_POST['griddata'];
    $o->itemqty=0;
    
    $xobj=simplexml_load_string($o->griddata);
    $arrayvalue=$xobj->datasources->datasource->data->e;

    foreach($arrayvalue as $e )
               $o->gridvaluearray[]=$e;

   $o->saveGridLine();

   echo "<?xml version='1.0' encoding='utf-8' ?><Result></Result>";
   
if($o->validateForm()){
    if( $o->invoice_id>0)
            if($o->updateInvoice())
                      echo "<status>0</status><detail><msg>Record save successfully $mytext</msg></detail>";
            else
                      echo "<status>0</status><detail><msg>Cannot save record due to internal error</msg></detail>";

    else
            if($o->insertInvoice())
                      echo "<status>1</status><invoice_id id='$o->invoice_id'>$o->invoice_id</invoice_id><detail><msg>Record save successfully</msg></detail>";
            else
                      echo "<status>0</status><detail><msg>Cannot save record due to internal error</msg></detail>";

}
else{
   $o->generateValidationError();
}
echo "</Result>";
        break;

case "ajaxdelete":
    $o->invoice_id=$_POST['invoice_id'];
     echo "<?xml version='1.0' encoding='utf-8' ?><Result>";
    if(!$o->deleteInvoice($o->invoice_id))
            echo "<status>0</status><detail><msg>Cannot delete this record due to internal error</msg></detail>";
    else
            echo "<status>1</status><detail><msg>C</msg></detail>";
    echo "</Result>";
    break;
    default:
        echo $o->gridjs();
        echo $o->getInputForm();
        require(XOOPS_ROOT_PATH.'/footer.php');
    break;
}
?>

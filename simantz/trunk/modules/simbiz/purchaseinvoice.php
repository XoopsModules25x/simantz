<?php
include_once "system.php";
include_once 'class/Invoice.inc.php';

include "class/nitobi.xml.php";
   $readwritepermctrl=" rowinsertenabled=\"true\"      rowdeleteenabled=\"true\"      toolbarenabled=\"true\"      ";
   $readonlypermctrl=" rowinsertenabled=\"false\"   autosaveenabled=\"false\"   rowdeleteenabled=\"false\"    editable=\"false\"  toolbarenabled=\"false\"      ";

if($havewriteperm==1){
    $permctrl=$readwritepermctrl;
}
else{
    $permctrl=$readonlypermctrl;
}

$action=$_REQUEST['action'];



$o = new Invoice();

$o->issotrx=0;
$o->invoicefilename="purchaseinvoice.php";
$o->spinvoice_prefix=$prefix_spi2;
$o->documenttype=1;//1=invoice, 2=cashbill saverecord
$o->updated=date("Y-m-d H:i:s",time());
$o->updatedby=$xoopsUser->getVar("uid");

//display standard web component
if($action=="view"|| $action=="edit" || $action=="" || $action=="search")
    {
        include "menu.php";
        $xoTheme->addStylesheet("$url/modules/simantz/include/popup.css");
        $xoTheme->addScript("$url/modules/simantz/include/popup.js");
        $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.css");
           $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.combo/nitobi.combo.css");

        $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.toolkit.js");
        $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.js");
        $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.combo/nitobi.combo.js");
        $xoTheme->addScript("$url/modules/simantz/include/firefox3_6fix.js");
        $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
        include_once "../simantz/class/datepicker/class.datepicker.php";
        $dp=new datepicker("$url");
        $dp->dateFormat='Y-m-d';
            $o->showCalendar= $dp->show("document_date");


$o->defineHeaderButton();
    }
    
switch($action){
    case "search":
       echo $o->showSearchForm();
       require(XOOPS_ROOT_PATH.'/footer.php');
    break;
    case "ajaxsearch":
        $o->showSearchGrid("where i.issotrx=1 and i.invoice_id>0 ");
        break;

    case "view":
        echo $o->gridjs();
        if($o->fetchInvoice($_GET['invoice_id']))
        {

    if($o->iscomplete==0)
                redirect_header("$o->invoicefilename?action=edit&invoice_id=$o->invoice_id","2", "This transaction not yet complete, redirect to edit mode.");

        echo $o->viewInputForm();

        }
          else{
            echo "cannot access database";

          }
        require(XOOPS_ROOT_PATH.'/footer.php');
        die;
        break;
    case "edit":
        
        if($o->fetchInvoice($_GET['invoice_id']))
        {
    if($o->iscomplete==1)
                redirect_header("$o->invoicefilename?action=view&invoice_id=$o->invoice_id","2", "This transaction not yet complete, redirect to edit mode.");

        echo $o->gridjs();
        echo $o->getInputForm("edit");
        
        }
          else{
            echo "cannot access database";
       
          }
        require(XOOPS_ROOT_PATH.'/footer.php');
        die;
        break;
   case "getbpartnerinfo":
    include_once "../simantz/class/SelectCtrl.inc.php";
    $ctrl= new SelectCtrl();
    include "../bpartner/class/BPSelectCtrl.inc.php";
    $bpctrl = new BPSelectCtrl();
    include "../bpartner/class/BPartner.php";
    $bp = new BPartner();
    $bpartner_id=$_REQUEST['bpartner_id'];
    $bp->fetchBpartnerData($bpartner_id);

    $addressxml=  str_replace(">","}}}",str_replace("<", "{{{",$bpctrl->getSelectAddress(0,"N",$bpartner_id)));
    $termsxml=  str_replace(">","}}}",str_replace("<", "{{{",$bpctrl->getSelectTerms($bp->terms_id,"N")));
    $contactxml=  str_replace(">","}}}",str_replace("<", "{{{",$bpctrl->getSelectContacts(0,'N',"",""," and bpartner_id=$bpartner_id")));
    $currencyxml=  str_replace(">","}}}",str_replace("<", "{{{",$ctrl->getSelectCurrency($bp->currency_id)));

    
    $salesagent=$bp->inchargeperson;
    echo "<result><address>$addressxml</address><terms>$termsxml</terms><contact>$contactxml</contact><currency>$currencyxml</currency><salesagent>$salesagent</salesagent><bpartneraccounts_id>$bp->creditoraccounts_id</bpartneraccounts_id><status>1</status></result>";
die;
   break;
  case "checkaddresstext":
      include "../bpartner/class/Address.inc.php";
      $add = new Address();
      $add->fetchAddress($_REQUEST['address_id']);
      echo $add->address_street;
      die;
      break;
  case "searchinvoiceline":
      $log->showLog(4,"access action:searchinvoiceline");
       $wherestring=" WHERE invoice_id=".$_REQUEST['invoice_id'];
    $o->showInvoiceline($wherestring);
      die;
  break;
    case "ajaxsave":
        
    $o->invoice_id=$_POST['invoice_id'];
    $o->document_no=$_POST['document_no'];
    $o->document_date=$_POST['document_date'];
    
    $o->baseamt=$_POST['baseamt'];
    $o->currency_id=$_POST['currency_id'];
    $o->exchangerate=$_POST['exchangerate'];
    $o->subtotal=$_POST['subtotal'];
    $o->ref_no=$_POST['ref_no'];
    $o->description=$_POST['description'];
    $o->bpartner_id=$_POST['cmbbpartner_idSelectedValue0'];
    $o->bpartner_name=$_POST['cmbbpartner_idSelectedValue1'];
    $o->iscomplete=$_POST['iscomplete'];
    $o->bpartneraccounts_id=$_POST['bpartneraccounts_id'];
    $o->spinvoice_prefix=$_POST['spinvoice_prefix'];
    $o->terms_id=$_POST['terms_id'];
    $o->contacts_id=$_POST['contacts_id'];
    $o->preparedbyuid=$_POST['preparedbyuid'];
    $o->note=$_POST['note'];
    $o->salesagentname=$_POST['salesagentname'];
    $o->localamt=$_POST['localamt'];
    $o->address_id=$_POST['address_id'];
    $o->address_text=$_POST['address_text'];
    $o->organization_id=$_POST['organization_id'];
    $o->track1_name=$_POST['track1_name'];
    $o->track2_name=$_POST['track2_name'];
    $o->track3_name=$_POST['track3_name'];
        $o->track1_id=$_POST['track1_id'];
    $o->track2_id=$_POST['track2_id'];
    $o->track3_id=$_POST['track3_id'];

    $o->isprinted=$_POST['isprinted'];
    $o->contacts_id=$_POST['contacts_id'];
    $o->terms_id=$_POST['terms_id'];
    $o->preparedbyuid=$_POST['preparedbyuid'];
    $o->salesagentname=$_POST['salesagentname'];
    $o->localamt=$_POST['localamt'];
    $o->address_text=$_POST['address_text'];
    $o->granttotalamt=$_POST['granttotalamt'];
        $o->totalgstamt=$_POST['totalgstamt'];

    $o->itemqty=0;
 
 //  $o->saveGridLine();

   
if($o->validateForm()){
    if( $o->invoice_id>0)
            if($o->updateInvoice())
                                 echo "<result><status>1</status><detail><msg>Record save successfully $mytext</msg></detail></result>";                        
            else
                      echo "<result><status>0</status><detail><msg>Cannot save record due to internal error</msg></detail></result>";

    else
            if($o->insertInvoice())
                                   echo "<result><status>1</status><detail><msg>Record save successfully $mytext</msg><invoice_id>$o->invoice_id</invoice_id></detail></result>";
                      else 
                             echo "<result><status>0</status><detail><msg>Cannot save record due to internal error</msg></detail></result>";

}
else{
   $o->generateValidationError();
}

        break;
case "posting":
       if($o->fetchInvoice($_POST['invoice_id'])){
                       if($o->posting())
                        echo "<result><status>1</status><detail><msg>Record post successfully.</msg></detail></result>";
                            else
                         echo "<result><status>0</status><detail><msg>Error, you cannot post record</msg></detail></result>";
       }
       else
                            echo "<result><status>0</status><detail><msg>Error, you cannot post record due to cannot fetch invoice from database</msg></detail></result>";
                            die;
               
    break;
case "reactivate":
     $invoice_id=$_POST['invoice_id'];
     if($o->fetchInvoice($invoice_id)){
      include "../simbiz/class/AccountsAPI.php";
       $acc = new AccountsAPI();
   if($acc->reverseBatch($o->batch_id)){
     $o->iscomplete=0;

     if($xoopsDB->query("update sim_simbiz_invoice set iscomplete=0 where invoice_id=".$invoice_id))
         $arr = array("status"=>1);
     else
         $arr = array("status"=>0,"msg"=>"cannot update invoice status to not complete, probably due to sql error");
     }
     else
         $arr = array("status"=>0,"msg"=>"Cannot reverse transaction, probably due to financial year issue");
     }
     else{
         $arr = array("status"=>0,"msg"=>"Cannot reverse transaction, fetch sql error");
     }
    echo json_encode($arr);
     

    die;

    break;
case "saveInvoiceline":
    $log->showLog(4,"save invoiceline");
    $o->saveInvoiceLine();
    die;
    break;
case "ajaxgetTaxInfo":
    include "../simbiz/class/Tax.php";
    $tax_id=$_REQUEST["tax_id"];
    $rowno=$_REQUEST["rowno"];
    $tax = new Tax();
    $tax->fetchTax($tax_id);

    $arr = array("rowno"=>$rowno,"total_tax"=>$tax->total_tax,"status"=>1);
    echo json_encode($arr);
    break;
case "getAccountInfo":
        include "../simbiz/class/Accounts.php";

     $accounts_id=$_REQUEST["accounts_id"];
    $rowno=$_REQUEST["rowno"];
    $acc = new Accounts();
    $acc->fetchAccounts($accounts_id);

    $arr = array("rowno"=>$rowno,"tax_id"=>$acc->tax_id,"status"=>1);
    echo json_encode($arr);
    break;
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

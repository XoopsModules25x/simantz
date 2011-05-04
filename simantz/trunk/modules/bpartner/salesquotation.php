<?php

include_once "system.php";
include_once 'class/Quotation.inc.php';

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



$o = new Quotation();

$o->issotrx=1;
$o->quotationfilename="salesquotation.php";
$o->spquotation_prefix=$spquotation_prefix;
$o->documenttype=1;//1=quotation, 2=cashbill saverecord
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
        $o->showSearchGrid("where i.issotrx=1 and i.quotation_id>0 ");
        break;

    case "view":
        echo $o->gridjs();
        if($o->fetchQuotation($_GET['quotation_id']))
        {
     if($o->iscomplete==0)
                redirect_header("$o->quotationfilename?action=edit&quotation_id=$o->quotation_id","2", "This transaction not yet complete, redirect to edit mode.");


        echo $o->viewInputForm();

        }
          else{
            echo "cannot access database";

          }
        require(XOOPS_ROOT_PATH.'/footer.php');
        die;
        break;
    case "edit":
        
        if($o->fetchQuotation($_GET['quotation_id']))
        {
            

     if($o->iscomplete==1)
                redirect_header("$o->quotationfilename?action=view&quotation_id=$o->quotation_id","2", "This transaction not yet complete, redirect to edit mode.");

        echo $o->gridjs();
        echo $o->getInputForm("edit");
             $o->includeTempFormJavescript();
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
    echo "<result><address>$addressxml</address><terms>$termsxml</terms><contact>$contactxml</contact><currency>$currencyxml</currency><salesagent>$salesagent</salesagent><status>1</status></result>";
die;
   break;
  case "checkaddresstext":
      include "../bpartner/class/Address.inc.php";
      $add = new Address();
      $add->fetchAddress($_REQUEST['address_id']);
      echo $add->address_street."\n$add->address_postcode $add->address_city\n$add->region_name, $add->country_name";
      die;
      break;
  case "searchquotationline":
      $log->showLog(4,"access action:searchquotationline");
       $wherestring=" WHERE quotation_id=".$_REQUEST['quotation_id'];
    $o->showQuotationline($wherestring);
      die;
  break;
    case "ajaxsave":
        
    $o->quotation_id=$_POST['quotation_id'];
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
    
    $o->spquotation_prefix=$_POST['spquotation_prefix'];
    $o->terms_id=$_POST['terms_id'];
    $o->contacts_id=$_POST['contacts_id'];
    $o->preparedbyuid=$_POST['preparedbyuid'];
    $o->note=$_POST['note'];
    $o->salesagentname=$_POST['salesagentname'];
    $o->localamt=$_POST['localamt'];
    $o->address_id=$_POST['address_id'];
    $o->address_text=$_POST['address_text'];
    $o->organization_id=$_POST['organization_id'];
        $o->quotation_title=$_POST['quotation_title'];
        $o->quotation_status=$_POST['quotation_status'];
    $o->isprinted=$_POST['isprinted'];
    $o->contacts_id=$_POST['contacts_id'];
    $o->terms_id=$_POST['terms_id'];
    $o->preparedbyuid=$_POST['preparedbyuid'];
    $o->salesagentname=$_POST['salesagentname'];
    $o->localamt=$_POST['localamt'];
    $o->address_text=$_POST['address_text'];

    $o->itemqty=0;
 
 //  $o->saveGridLine();

   
if($o->validateForm()){
    if( $o->quotation_id>0)
            if($o->updateQuotation())
                                 echo "<result><status>1</status><detail><msg>Record save successfully $mytext</msg></detail></result>";                        
            else
                      echo "<result><status>0</status><detail><msg>Cannot save record due to internal error</msg></detail></result>";

    else
            if($o->insertQuotation())
                                   echo "<result><status>1</status><detail><msg>Record save successfully $mytext</msg><quotation_id>$o->quotation_id</quotation_id></detail></result>";
                      else 
                             echo "<result><status>0</status><detail><msg>Cannot save record due to internal error</msg></detail></result>";

}
else{
   $o->generateValidationError();
}

        break;
case "reactivate":
     $quotation_id=$_POST['quotation_id'];
     if($o->fetchQuotation($quotation_id)){

     if($xoopsDB->query("update sim_bpartner_quotation set iscomplete=0 where quotation_id=".$quotation_id))
         $arr = array("status"=>1);
     else
         $arr = array("status"=>0,"msg"=>"cannot update quotation status to not complete, probably due to sql error");
     }
    echo json_encode($arr);
    die;

    break;
case "saveQuotationline":
    $log->showLog(4,"save quotationline");
    $o->saveQuotationLine();
    die;
    break;
case "ajaxdelete":
    $o->quotation_id=$_POST['quotation_id'];
    $log->showLog(3,"action: ajaxdelete, quotation_id=$o->quotation_id");
     echo "<?xml version='1.0' encoding='utf-8' ?><Result>";
    if(!$o->deleteQuotation($o->quotation_id))
            echo "<status>0</status><detail><msg>Cannot delete this record due to internal error</msg></detail>";
    else
            echo "<status>1</status><detail><msg>C</msg></detail>";
    echo "</Result>";
    break;


case "gettempwindow":
   $o->GetTempWindow();
   exit;
break;

case "savetemp" :

$o->descriptiontemp_name=$_POST['descriptiontemp_name'];
$o->descriptiontemp_content=$_POST['descriptiontemp_content'];

	if($o->saveTemp()){
            $msg = "<a class='statusmsg'>Record saved successfully.</a>";
            $arr = array("msg"=>$msg,"status"=>1);
            echo json_encode($arr);
	}else {
            $msg = "<a class='statusmsg'>Failed to saved Record. Please try again.</a>";
            $arr = array("msg"=>$msg,"status"=>2);
            echo json_encode($arr);
        }
break;
case "deletetemp" :
$o->descriptiontemp_id=$_POST['descriptiontemp_id'];

	if($o->deleteTemp($o->descriptiontemp_id)){
            $msg = "<a class='statusmsg'>Record delete successfully.</a>";
            $arr = array("msg"=>$msg,"status"=>1);
            echo json_encode($arr);
	}else {
            $msg = "<a class='statusmsg'>Failed to delete Record. Please try again.</a>";
            $arr = array("msg"=>$msg,"status"=>2);
            echo json_encode($arr);
        }
break;

case "getsavetempwindow":
   $o->GetSaveTempWindow();
   exit;

break;
case "duplicate":
        $o->quotation_id=$_POST['quotation_id'];
    if(  $o->quotation_id>0){
     $result=$o->duplicateQuotation();
     $qid=$result[0];
     $qno=$result[1];
     if($result[0]>0){
      $msg = "Record duplicated successfully, new quotation is: <a href='salesquotation.php?action=edit&quotation_id=$qid'>$qno</a>";
       $status=1;
     }
     else{
        $msg = "cannot duplicate this quotation due to sql error";
          $status=0;

     }
    }
    else{
       $msg = "Cannot duplicate quotation id=0";
       $status=0;
    }
       
            $arr = array("msg"=>$msg,"status"=>$status);
            echo json_encode($arr);
    exit;
       break;

    default:

        $o->iscomplete=0;
        $o->quotation=0;
        $o->bpartner_id=0;
        
        echo $o->gridjs();
        echo $o->getInputForm();
             $o->includeTempFormJavescript();
        require(XOOPS_ROOT_PATH.'/footer.php');
    break;
}

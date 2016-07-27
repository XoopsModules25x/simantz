<?php
include "system.php";
include 'class/Quotation.inc.php';

if($havewriteperm==1) {
    $permctrl=$readwritepermctrl;
}
else {
    $permctrl=$readonlypermctrl;
}

$action=$_REQUEST['action'];
$o = new Quotation();

$o->issotrx=1;
$o->quotationfilename="salesquotation.php";
$o->spquotation_prefix=$prefix_spi;
//$o->documenttype='I';//1=quotation, 2=cashbill saverecord
$o->updated=date("Y-m-d H:i:s",time());
$o->updatedby=$xoopsUser->getVar("uid");

switch($action){
    
   case "html":
       
       $o->showHtmlTable($_POST["quotation_id"]);
       
       break;
    
   case "checkaddresstext":
      include "../bpartner/class/Address.inc.php";
      $add = new Address();
      $addtxt=$add->getAddressTxt($_REQUEST['address_id']);
      echo $addtxt;
      break;

case "create":
   if($havewriteperm==0)
			 redirect_header("$o->quotationfilename",$pausetime+3,"Sorry, you don't have write permission.");
         //   include "../simbiz/class/Track.inc.php";
			include "../bpartner/class/Address.inc.php";
           // $track = new Trackclass();
			$add = new Address();
           /* $track_array = $track->getTrackName();
            $o->track1_name = $track_array['track1_name'];
            $o->track2_name = $track_array['track2_name'];
            $o->track3_name = $track_array['track3_name'];
			*/
			$o->document_no=$_POST['document_no'];
			$o->document_date=$_POST['document_date'];
			$o->currency_id=$_POST['currency_id'];
			if($o->currency_id==$defaultcurrency_id)
			$o->exchangerate=1;
			else
			$o->exchangerate=$o->GetCurrency();
			$o->ref_no=$_POST['ref_no'];
			$o->description=$_POST['description'];
			$o->bpartner_id=$_POST['bpartner_id'];
			$o->saleagent_id =$_POST['saleagent_id'];    
			$o->bpartneraccounts_id=$_POST['bpartneraccounts_id'];
			$o->spquotation_prefix=$_POST['spquotation_prefix'];
			$o->terms_id=$_POST['terms_id'];
			$o->contacts_id=$_POST['contacts_id'];
			$o->preparedbyuid=$_POST['preparedbyuid'];
			$o->address_id=$_POST['address_id'];
			$o->address_text=$add->getAddressTxt($o->address_id);
    		$o->organization_id=$_POST['organization_id'];
			$o->track1_name=$_POST['track1_name'];
			$o->track2_name=$_POST['track2_name'];
			$o->track3_name=$_POST['track3_name'];
			$o->organization_id=$defaultorganization_id;
  if($o->insertQuotation()){
	  
			 redirect_header("$o->quotationfilename?action=edit&quotation_id=$o->quotation_id",$pausetime,"Your data is created.");
		  }
	else
		echo "0";

break;
case "update":

    $o->quotation_id=$_POST['quotation_id'];
    $o->document_no=$_POST['document_no'];
    $o->document_date=$_POST['document_date'];
    
    $o->baseamt=$_POST['baseamt'];
    $o->currency_id=$_POST['currency_id'];
    $o->exchangerate=$_POST['exchangerate'];
    $o->subtotal=$_POST['subtotal'];
    $o->ref_no=$_POST['ref_no'];
    $o->description=$_POST['description'];
    $o->bpartner_id=$_POST['bpartner_id'];
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

    $o->isprinted=$_POST['isprinted'];
    $o->contacts_id=$_POST['contacts_id'];
    $o->terms_id=$_POST['terms_id'];
    $o->preparedbyuid=$_POST['preparedbyuid'];
    $o->salesagentname=$_POST['salesagentname'];
    $o->address_text=$_POST['address_text'];

    $o->itemqty=0;
 $o->erromsg='';
 if($o->saveQuotationLine()){

	if($o->updateQuotation())
          $arr = array("status"=>1,"msg"=>"Record save successfully.");
      else
          $arr = array("status"=>0,"msg"=>"Cannot completely save quotation line due to internal error");
	}
else
                $arr = array("status"=>0,"msg"=>"Cannot save quotation header due to internal error");
echo json_encode($arr);
break;
case "getcurrency":
   $o->currency_id=$_POST['currency_id'];
   $o->GetCurrency();
   $arr = array("currency_rate"=>$o->currency_rate);
   echo json_encode($arr);
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

case "refreshsubtable":
	include "../simantz/class/FormElement.php";
	include "../bpartner/class/BPartnerFormElement.inc.php";
$fe=new FormElement();
$sbfe=new BPartnerFormElement();

$o->quotation_id=$_REQUEST['quotation_id'];
$o->fetchQuotation($o->quotation_id);
echo $o->subtable();
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

	if($o->issotrx==1)
		$acc_id=$bp->debtoraccounts_id;
	else
		$acc_id=$bp->creditoraccounts_id;

	$arrcredit=$bp->checkCreditLimit($bpartner_id,$defaultorganization_id,$o->issotrx);
	
	$control=$arrcredit["control"];
	$limitamt=$arrcredit["limitamt"];
	$usage=$arrcredit["usage"];
	
    echo "<result><address>$addressxml</address><terms>$termsxml</terms><contact>$contactxml</contact>".
		"<currency>$currencyxml</currency><bpartneraccounts_id>$acc_id</bpartneraccounts_id><status>1</status>".
		"<limitamt>$limitamt</limitamt><usage>$usage</usage><control>$control</control></result>";
    die;
    break;

case "search":
		include "menu.php";
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/base/jquery.ui.all.css");  
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.core.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.widget.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.button.js");
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.datepicker.js");
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.autocomplete.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.position.js"); 
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/demos.css"); 
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/ui-lightness/jquery.ui.datepicker.css"); 
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/ui-lightness/jquery.ui.autocomplete.css"); 
		$xoTheme->addScript("$url/modules/simantz/include/validatetext.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqjs.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.dataTables.js"); 
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/ui-lightness/datatable.css"); 
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/ui-lightness/datatablepage.css"); 
		$xoTheme->addScript("$url/modules/simantz/include/popup.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/popup.css"); 

		$o->showSearchForm();
        require(XOOPS_ROOT_PATH.'/footer.php');
		die;
break;
case "searchresult":
		$o->showResult();
break;
case "duplicate":
        $o->quotation_id=$_POST['quotation_id'];
    if(  $o->quotation_id>0){
     $result=$o->duplicateQuotation();
     $qid=$result[0];
     $qno=$result[1];
    }
   die;
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
case "edit":
        if($o->fetchQuotation($_REQUEST['quotation_id'])){
			
           if($o->iscomplete==1 ||$o->iscomplete==-1){
               redirect_header("$o->quotationfilename?action=view&quotation_id=$o->quotation_id","2", "This transaction is readonly, redirect to view mode.");
			}
		else{
			
			
		include "menu.php";
	include "../simantz/class/FormElement.php";
	include "../bpartner/class/BPartnerFormElement.inc.php";
		$fe=new FormElement();
		$sbfe=new BPartnerFormElement();
		$sbfe->activateAutoComplete();


		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/base/jquery.ui.all.css");  
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.core.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.widget.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.button.js");
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.datepicker.js");
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.autocomplete.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.position.js"); 
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/demos.css"); 
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/ui-lightness/jquery.ui.datepicker.css"); 
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/ui-lightness/jquery.ui.autocomplete.css"); 
		$xoTheme->addScript("$url/modules/simantz/include/validatetext.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqjs.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/popup.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/popup.css"); 
		$o->editJS(); 


           echo $o->getInputForm();
	   }
        
        }else{
            echo "cannot find record from database (Or SQL Error).";       
          }
        require(XOOPS_ROOT_PATH.'/footer.php');
        die;
break;

case "getsavetempwindow":
	$o->GetSaveTempWindow();
	exit;
break;
case "deleteline":


	  if($o->deleteLine($_POST['quotationline_id']))
          $arr = array("status"=>1,"msg"=>"Line deleted successfully.");
			else
			$arr = array("status"=>0,"msg"=>"Cannot delete current line!");
   echo json_encode($arr);
die;

  
case "reactivate":
     $quotation_id=$_POST['quotation_id'];
    
   

 	
     if($xoopsDB->query("update sim_bpartner_quotation set iscomplete=0 where quotation_id=".$quotation_id))
         $arr = array("status"=>1);
     else
         $arr = array("status"=>0,"msg"=>"cannot update quotation status to not complete, probably due to sql error");
 
 
    echo json_encode($arr);
     

    die;

    break;
  

case "pdf":
include_once('../simantz/class/fpdf/fpdf.php');
include_once("../simantz/class/PHPJasperXML.inc");

//$fp = fopen("jasperxml/salesquotation.jrxml","r");
$xml =  simplexml_load_file("salesquotation.jrxml");
//fclose($fp);
$quotation_id=$_REQUEST['quotation_id'];
$PHPJasperXML = new PHPJasperXML();
//$PHPJasperXML->debugsql=true;
$PHPJasperXML->arrayParameter=array("quotation_id"=>"$quotation_id");
$PHPJasperXML->xml_dismantle($xml);

$PHPJasperXML->transferDBtoArray(XOOPS_DB_HOST,XOOPS_DB_USER,XOOPS_DB_PASS,XOOPS_DB_NAME);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file

break;
case "view":
      if($o->fetchQuotation($_GET['quotation_id'])){
         if($o->iscomplete==0)
            redirect_header("$o->quotationfilename?action=edit&quotation_id=$o->quotation_id","2", "This transaction not yet complete, redirect to edit mode.");
		include "menu.php";
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/base/jquery.ui.all.css");  
	
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.core.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.position.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.widget.js"); 
		
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.mouse.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.draggable.js");
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.resizable.js");
	
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.button.js");
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.datepicker.js");
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.button.js");
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/ui-lightness/jquery.ui.dialog.css"); 
	
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.dialog.js"); 
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/demos.css"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqjs.js"); 
            echo $o->viewInputForm();
      }else{
            echo "cannot access database";
      }
      require(XOOPS_ROOT_PATH.'/footer.php');
      die;
      break;
case "search":
include "menu.php";
$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/base/jquery.ui.all.css");  
$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.core.js"); 
$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.widget.js"); 
$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.button.js");
$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.datepicker.js");
$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.autocomplete.js"); 
$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.position.js"); 
$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/demos.css"); 
$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/ui-lightness/jquery.ui.datepicker.css"); 
$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/ui-lightness/jquery.ui.autocomplete.css"); 
$xoTheme->addScript("$url/modules/simantz/include/validatetext.js"); 
$xoTheme->addScript("$url/modules/simantz/include/jqjs.js"); 
$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.dataTables.js"); 
$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/ui-lightness/datatable.css"); 
$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/ui-lightness/datatablepage.css"); 
$xoTheme->addScript("$url/modules/simantz/include/popup.js"); 
$xoTheme->addScript("$url/modules/simantz/include/popup.css"); 

$o->showSearchForm();
require(XOOPS_ROOT_PATH.'/footer.php');
die;
break;
case "searchresult":
$o->showResult();
break;

	default:
	include "menu.php";
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/base/jquery.ui.all.css");  
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.core.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.widget.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.button.js");
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.datepicker.js");
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.autocomplete.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqueryui/ui/jquery.ui.position.js"); 
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/demos.css"); 
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/ui-lightness/jquery.ui.datepicker.css"); 
		$xoTheme->addStylesheet("$url/modules/simantz/include/jqueryui/themes/ui-lightness/jquery.ui.autocomplete.css"); 
		$xoTheme->addScript("$url/modules/simantz/include/validatetext.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/jqjs.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/popup.js"); 
		$xoTheme->addScript("$url/modules/simantz/include/popup.css"); 
		$o->quotation_id=0;
		$o->editJS(); 
		$o->showCreateForm();

        require(XOOPS_ROOT_PATH.'/footer.php');

break;
	}

<?php
include "system.php";
include_once "../simantz/class/SelectCtrl.inc.php";
//include_once 'class/Log.php';
include_once 'class/BPartner.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
include_once "../simantz/class/datepicker/class.datepicker.php";
//include_once "../system/class/Period.php";
$dp=new datepicker($url);
$dp->dateFormat='Y-m-d';

$log = new Log();
$o = new BPartner();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
$orgctrl="";

if(file_exists("../simbiz/class/AccountsAPI.php") ){
include_once "../simbiz/class/SimbizSelectCtrl.inc.php";
$simbizctrl = new SimbizSelectCtrl();
$issimbiz = true;
}
$action=$_REQUEST['action'];
$mode=$_REQUEST['mode'];
$o->mode=$_REQUEST['mode'];
$isaddnew=$_REQUEST['isaddnew'];
// get POST/GET data
$o->bpartner_id = $_REQUEST['bpartner_id'];
$o->bpartner_name = $_REQUEST['bpartner_name'];

// end

// define tab iframe
$bpartneridonly= "bpartner_id=$o->bpartner_id";
$bpartnertab = "mode=$mode&bpartner_id=$o->bpartner_id";

// end
switch ($action){

case "search":
                
$o->searchchar=$_GET['filter'];
include_once "menu.php";
  //$o->getIncludeFileMenu();
  $o->filterstring=$_GET["filterstring"];
if($o->industry_id=="")
         $o->industry_id=0;
if($o->bpartnergroup_id=="")
         $o->bpartnergroup_id=0;

        $o->bpartnergroupctrl=$bpctrl->getSelectBPartnerGroup($o->bpartnergroup_id,'Y');
        $o->industryctrl=$bpctrl->getSelectIndustry($o->industry_id,'Y');
  $o->includeGeneralFile();

  $o->getBpartnerSearchForm();
  $o->getShowResultForm();

require(XOOPS_ROOT_PATH.'/footer.php');
    break;

case "searchbpartner": //return xml table to grid

    $wherestring=" WHERE bp.bpartner_id>0";
    $o->showSearchResult($wherestring);
    exit; //after return xml shall not run more code.
    break;

case "sendemail":
    include "../simantz/class/SendMessage.php.inc";
    include "../simantz/class/Mail.php";
    $m=new SendMessage();

    $o->employeeselected = $_POST['employeeselected'];
    $m->emailtitle=$_POST['emailtitle'];
    $m->message=$_POST['msg'];
    $m->textlength=$_POST['textlength'];
    $m->receipient=$o->getEmail();


	        $headers = array ('Subject' => $m->emailtitle,'From' => $smtpuser,
		'To' => $m->receipient);
		$smtp = Mail::factory('smtp',
		array ('host' => "$m->smtpserver",
		'auth' => true,
		'username' => $m->smtpuser,
		'password' => $m->smtppassword));

	        $mail = $smtp->send($m->receipient, $headers, $m->message);

		if (PEAR::isError($mail)) {
		echo("<p>" . $mail->getMessage() . "</p>");
		} else {
		echo("<p>Message sent! click <a href='index.php'>here</a> for back to home.</p> The receipient as below:<br>$m->receipient");
		}

//    $m->sendemail();
    break;

case "sendsms":
    global $sendsmsgroup;

    if($o->isGroup($sendsmsgroup)){
        include_once "../simantz/class/SendMessage.php.inc";
        $m=new SendMessage();

        $o->employeeselected = $_POST['employeeselected'];
        $m->emailtitle=$_POST['emailtitle'];
        $m->message=$_POST['msg'];
        $m->textlength=$_POST['textlength'];
        $m->subscriber_number=$o->getNumber();
        $m->sendsms();
    }else
        redirect_header("employee.php?action=search",$pausetime,"You do not have a permission to send SMS");
    break;

case "viewsummary": //return xml table to grid
include_once "menu.php";
   $o->showSummary();
require(XOOPS_ROOT_PATH.'/footer.php');
    break;

case "tablist":
    include_once "menu.php";
    $o->getIncludeFileMenu();
$o->fetchBpartnerData($o->bpartner_id);
    $o->showTabList();

    require(XOOPS_ROOT_PATH.'/footer.php');
break;

//frontpage of add new bpartner
case "bpartner":
 include_once "menu.php";

$o->bpartnergroup_id=$_POST['bpartnergroup_id'];
$o->bpartner_no=$_POST['bpartner_no'];
$o->bpartner_name=$_POST['bpartner_name'];
$o->isactive=$_POST['isactive'];
$o->seqno=$_POST['seqno'];

$o->organization_id=$_POST['organization_id'];
$o->employeecount=$_POST['employeecount'];
$o->alternatename=$_POST['alternatename'];
$o->companyno=$_POST['companyno'];
$o->industry_id=$_POST['industry_id'];

$o->tooltips=$_POST['tooltips'];
$o->bpartner_url=$_POST['bpartner_url'];
$o->inchargeperson=$_POST['inchargeperson'];
$o->description=$_POST['description'];
$o->shortremarks=$_POST['shortremarks'];

//$o->tax_id=$_POST['tax_id'];
//$o->currentbalance=$_POST['currentbalance'];

$o->isdebtor=$_POST['isdebtor'];
$o->iscreditor=$_POST['iscreditor'];
$o->istransporter=$_POST['istransporter'];
$o->isdealer=$_POST['isdealer'];
$o->isprospect=$_POST['isprospect'];
$o->currency_id=$_POST['currency_id'];

$o->creditoraccounts_id=$_POST['creditoraccounts_id'];
$o->debtoraccounts_id=$_POST['debtoraccounts_id'];
$o->salescreditlimit=$_POST['salescreditlimit'];
$o->purchasecreditlimit=$_POST['purchasecreditlimit'];
$o->groupid=$_POST['groupid'];
$o->enforcesalescreditlimit=$_POST['enforcesalescreditlimit'];
$o->enforcepurchasecreditlimit=$_POST['enforcepurchasecreditlimit'];
$o->currentsalescreditstatus=$_POST['currentsalescreditstatus'];
$o->currentpurchasecreditstatus=$_POST['currentpurchasecreditstatus'];

$o->terms_id=$_POST['terms_id'];
$o->bankaccountname=$_POST['bankaccountname'];
$o->bankname=$_POST['bankname'];
$o->bankaccountno=$_POST['bankaccountno'];

$o->pricelist_id=$_POST['pricelist_id'];
if($o->pricelist_id=="")
$o->pricelist_id=0;


if ($o->isdebtor==1 or $o->isdebtor=="on")
$o->isdebtor=1;
else
$o->isdebtor=0;

if ($o->iscreditor==1 or $o->iscreditor=="on")
$o->iscreditor=1;
else
$o->iscreditor=0;

if ($o->enforcesalescreditlimit==1 or $o->enforcesalescreditlimit=="on")
$o->enforcesalescreditlimit=1;
else
$o->enforcesalescreditlimit=0;

if ($o->enforcepurchasecreditlimit==1 or $o->enforcepurchasecreditlimit=="on")
$o->enforcepurchasecreditlimit=1;
else
$o->enforcepurchasecreditlimit=0;

if ($o->isdealer==1 or $o->isdealer=="on")
$o->isdealer=1;
else
$o->isdealer=0;

if ($o->istransporter==1 or $o->istransporter=="on")
$o->istransporter=1;
else
$o->istransporter=0;

if ($o->isprospect==1 or $o->isprospect=="on")
$o->isprospect=1;
else
$o->isprospect=0;

$o->isactive=$_POST["isactive"];
if($o->isactive == "on")
       $o->isactive =1;
if($o->organization_id=="")
         $o->organization_id=0;
if($o->industry_id=="")
         $o->industry_id=0;
if($o->bpartnergroup_id=="")
         $o->bpartnergroup_id=0;
if($o->currency_id=="")
         $o->currency_id=0;
if($o->terms_id=="")
         $o->terms_id=0;

if($o->debtoraccounts_id=="")
         $o->debtoraccounts_id=0;
if($o->creditoraccounts_id=="")
         $o->creditoraccounts_id=0;

                $o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
                $o->bpartnergroupctrl=$bpctrl->getSelectBPartnerGroup($o->bpartnergroup_id,'Y');
                $o->industryctrl=$bpctrl->getSelectIndustry($o->industry_id,'Y');

                $o->pricelistctrl="<input name='pricelist_id' value='0' type='hidden'>";
                $o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N');
                $o->termsctrl=$bpctrl->getSelectTerms($o->terms_id,'Y');
                
        if($issimbiz){
                $o->debtoraccountsctrl=$simbizctrl->getSelectAccounts($o->debtoraccounts_id,'Y',"onchange=''","debtoraccounts_id","");
                $o->creditoraccountsctrl=$simbizctrl->getSelectAccounts($o->creditoraccounts_id,'Y',"onchange=''","creditoraccounts_id","");
        }
        else{
               $o->debtoraccountsctrl="<input type='text' name='debtoraccounts_id' value='$o->debtoraccounts_id'>";
               $o->creditoraccountsctrl="<input type='text' name='creditoraccounts_id' value='$o->creditoraccounts_id'>";
//                $o->debtoraccountsctrl="Accounting Module doesn't exist <input type='hidden' name='debtoraccounts_id' value=0>";
//                $o->creditoraccountsctrl="Accounting Module doesn't exist <input type='hidden' name='creditoraccounts_id' value=0>";
        }

 if($mode == "new"){//go to new record
    $o->getInputForm("new","0");
 }
 else if($mode == "save"){//insert new record

      if($o->saveBPartner()){
          if($isaddnew == "1"){
             redirect_header("bpartner.php",$pausetime,"Your data is saved, redirect to add employee.");
          }
          else{
             $getid=$o->getLatestBPartnerID();
             redirect_header("bpartner.php?action=tablist&mode=edit&bpartner_id=$getid",$pausetime,"Your data is saved, redirect to employee details.");
          }
      }
      else{

         echo "<div align='center'><font style='color:red;font-weight:bold'>Failed to saved data. Please try again.</font></div>";
         $o->getInputForm("new");
       }

    }

    require(XOOPS_ROOT_PATH.'/footer.php');
break;

/* start iframe bpartner nitobi */

case "bpartnerinfo"://bpartnerinfo tab
echo '<html  xmlns:ntb="http://www.nitobi.com">';
include_once "class/BPSelectCtrl.inc.php";
$bpctrl = new BPSelectCtrl();
$o->fetchBpartnerData($o->bpartner_id);

//$o->pricelist_id=$_POST['pricelist_id'];
//if($o->pricelist_id=="")
//$o->pricelist_id=0;


if($o->organization_id=="")
         $o->organization_id=0;
if($o->industry_id=="")
         $o->industry_id=0;
if($o->bpartnergroup_id=="")
         $o->bpartnergroup_id=0;
if($o->currency_id=="")
         $o->currency_id=0;

                $o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
                $o->bpartnergroupctrl=$bpctrl->getSelectBPartnerGroup($o->bpartnergroup_id,'Y');
                $o->industryctrl=$bpctrl->getSelectIndustry($o->industry_id,'Y');
                $o->groupctrl=$ctrl->getUserGroup($o->groupid,'Y');
                $o->pricelistctrl="<input name='pricelist_id' value='0' type='hidden'>";
                $o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N');
                $o->termsctrl=$bpctrl->getSelectTerms($o->terms_id,'Y');
                
       if($issimbiz){
                $o->debtoraccountsctrl=$simbizctrl->getSelectAccounts($o->debtoraccounts_id,'Y',"onchange=''","debtoraccounts_id"," and a.account_type=2 ");
                $o->creditoraccountsctrl=$simbizctrl->getSelectAccounts($o->creditoraccounts_id,'Y',"onchange=''","creditoraccounts_id"," and a.account_type=3 ");
        }
        else{
               $o->debtoraccountsctrl="<input type='text' name='debtoraccounts_id' value='$o->debtoraccounts_id'>";
               $o->creditoraccountsctrl="<input type='text' name='creditoraccounts_id' value='$o->creditoraccounts_id'>";
//                $o->debtoraccountsctrl="Accounting Module doesn't exist <input type='hidden' name='debtoraccounts_id' value=0>";
//                $o->creditoraccountsctrl="Accounting Module doesn't exist <input type='hidden' name='creditoraccounts_id' value=0>";
        }
                
 $o->includeGeneralFile();
  if($mode == "edit"){//show form with employee data
        $o->getBpartnerForm();
  }else if($mode == "view"){//show preview with employee data
        $o->getBpartnerview();

  }else if($mode == "save"){//update / insert record here

$o->bpartnergroup_id=$_POST['bpartnergroup_id'];
$o->bpartner_no=$_POST['bpartner_no'];
$o->bpartner_name=$_POST['bpartner_name'];
$o->isactive=$_POST['isactive'];
$o->seqno=$_POST['seqno'];

$o->organization_id=$_POST['organization_id'];
$o->employeecount=$_POST['employeecount'];
$o->alternatename=$_POST['alternatename'];
$o->companyno=$_POST['companyno'];
$o->industry_id=$_POST['industry_id'];

$o->tooltips=$_POST['tooltips'];
$o->bpartner_url=$_POST['bpartner_url'];
$o->inchargeperson=$_POST['inchargeperson'];
$o->description=$_POST['description'];
$o->shortremarks=$_POST['shortremarks'];

//$o->tax_id=$_POST['tax_id'];
//$o->currentbalance=$_POST['currentbalance'];

$o->isdebtor=$_POST['isdebtor'];
$o->iscreditor=$_POST['iscreditor'];
$o->istransporter=$_POST['istransporter'];
$o->isdealer=$_POST['isdealer'];
$o->isprospect=$_POST['isprospect'];
$o->currency_id=$_POST['currency_id'];
$o->groupid=$_POST['groupid'];

$o->creditoraccounts_id=$_POST['creditoraccounts_id'];
$o->debtoraccounts_id=$_POST['debtoraccounts_id'];
$o->salescreditlimit=$_POST['salescreditlimit'];
$o->purchasecreditlimit=$_POST['purchasecreditlimit'];

$o->enforcesalescreditlimit=$_POST['enforcesalescreditlimit'];
$o->enforcepurchasecreditlimit=$_POST['enforcepurchasecreditlimit'];
$o->currentsalescreditstatus=$_POST['currentsalescreditstatus'];
$o->currentpurchasecreditstatus=$_POST['currentpurchasecreditstatus'];

$o->terms_id=$_POST['terms_id'];
$o->bankaccountname=$_POST['bankaccountname'];
$o->bankname=$_POST['bankname'];
$o->bankaccountno=$_POST['bankaccountno'];


$o->isactive=$_POST["isactive"];
if($o->isactive == "on")
       $o->isactive =1;

if ($o->isdebtor==1 or $o->isdebtor=="on")
$o->isdebtor=1;
else
$o->isdebtor=0;

if ($o->iscreditor==1 or $o->iscreditor=="on")
$o->iscreditor=1;
else
$o->iscreditor=0;

if ($o->enforcesalescreditlimit==1 or $o->enforcesalescreditlimit=="on")
$o->enforcesalescreditlimit=1;
else
$o->enforcesalescreditlimit=0;

if ($o->enforcepurchasecreditlimit==1 or $o->enforcepurchasecreditlimit=="on")
$o->enforcepurchasecreditlimit=1;
else
$o->enforcepurchasecreditlimit=0;

if ($o->isdealer==1 or $o->isdealer=="on")
$o->isdealer=1;
else
$o->isdealer=0;

if ($o->istransporter==1 or $o->istransporter=="on")
$o->istransporter=1;
else
$o->istransporter=0;

if ($o->isprospect==1 or $o->isprospect=="on")
$o->isprospect=1;
else
$o->isprospect=0;

        if($o->saveBPartner()){// do your save here
        //if success
        $getid=$o->bpartner_id;

         redirect_header("bpartner.php?action=bpartnerinfo&mode=view&bpartner_id=$getid",$pausetime,"Your data is saved, redirect to employee details.");
        }else{
        //if failed
           $getid=$o->bpartner_id;
           redirect_header("bpartner.php?action=bpartnerinfo&mode=edit&bpartner_id=$o->bpartner_id",$pausetime,"Error! Connot save the data!");
        }

        $o->getBPartnerform();// show form again
   }
   else if($mode == "delete"){
          if($o->deleteBPartner($o->bpartner_id)){

			redirect_header("bpartner.php",$pausetime,"Data removed successfully.");
          }else{

			redirect_header("bpartner.php?action=tablist&mode=edit&bpartner_id=$o->bpartner_id",$pausetime,"Warning! Can't delete data from database due to this employee have be used.");
          }

   }

echo '</html>';

  break;


/* start Contact nitobi */
case "searchcontact": //return xml table to grid
    $wherestring=" WHERE bpartner_id=$o->bpartner_id";
    $o->showContact($wherestring);
    exit; //after return xml shall not run more code.
break;
case "savecontact": //process submited xml data from grid
     $o->saveContact();
break;
case "contact":
echo '<html  xmlns:ntb="http://www.nitobi.com">';
$o->includeGeneralFile();
$o->getContactform();//use nitobi
echo '</html>';
break;
case "races": //return xml table to grid
include_once "../simantz/class/EBAGetHandler.php";
header('Content-type: text/xml');
$lookupdelay=1000;
$pagesize=&$_GET["pagesize"];
$ordinalStart=&$_GET["startrecordindex"];
$sortcolumn=&$_GET["sortcolumn"];
$sortdirection=&$_GET["sortdirection"];
$getHandler = new EBAGetHandler();
$getHandler->ProcessRecords();
$getHandler->DefineField("races_id");
$wherestring=" WHERE isactive!=0";
$o->getSelectRaces($wherestring);
$getHandler->completeGet();
break;
case "religion": //return xml table to grid
include_once "../simantz/class/EBAGetHandler.php";
header('Content-type: text/xml');
$lookupdelay=1000;
$pagesize=&$_GET["pagesize"];
$ordinalStart=&$_GET["startrecordindex"];
$sortcolumn=&$_GET["sortcolumn"];
$sortdirection=&$_GET["sortdirection"];
$getHandler = new EBAGetHandler();
$getHandler->ProcessRecords();
$getHandler->DefineField("religion_id");
$wherestring=" WHERE isactive!=0";
$o->getSelectReligion($wherestring);
$getHandler->completeGet();
break;
case "addresslist": //return xml table to grid
include_once "../simantz/class/EBAGetHandler.php";
header('Content-type: text/xml');
$lookupdelay=1000;
$pagesize=&$_GET["pagesize"];
$ordinalStart=&$_GET["startrecordindex"];
$sortcolumn=&$_GET["sortcolumn"];
$sortdirection=&$_GET["sortdirection"];
$getHandler = new EBAGetHandler();
$getHandler->ProcessRecords();
$getHandler->DefineField("address_id");
$wherestring=" WHERE isactive!=0 and bpartner_id=$o->bpartner_id";
$o->getSelectAddress($wherestring);
$getHandler->completeGet();
break;
/* end Contact */


/* start address nitobi */
case "searchaddress": //return xml table to grid
    $wherestring=" WHERE bpartner_id=$o->bpartner_id";
    $o->showAddress($wherestring);
    exit; //after return xml shall not run more code.
break;
case "saveaddress": //process submited xml data from grid
     $o->saveAddress();
break;
case "address":
echo '<html  xmlns:ntb="http://www.nitobi.com">';
$o->includeGeneralFile();
$o->getAddressform();//use nitobi
echo '</html>';
break;
case "countrylist": //return xml table to grid
include_once "../simantz/class/EBAGetHandler.php";
header('Content-type: text/xml');
$lookupdelay=1000;
$pagesize=&$_GET["pagesize"];
$ordinalStart=&$_GET["startrecordindex"];
$sortcolumn=&$_GET["sortcolumn"];
$sortdirection=&$_GET["sortdirection"];
$getHandler = new EBAGetHandler();
$getHandler->ProcessRecords();
$getHandler->DefineField("country_id");
$wherestring=" ";
$o->getSelectCountry($wherestring);
$getHandler->completeGet();
break;
case "regionlist": //return xml table to grid
include_once "../simantz/class/EBAGetHandler.php";
header('Content-type: text/xml');
$lookupdelay=1000;
$pagesize=&$_GET["pagesize"];
$ordinalStart=&$_GET["startrecordindex"];
$sortcolumn=&$_GET["sortcolumn"];
$sortdirection=&$_GET["sortdirection"];
$getHandler = new EBAGetHandler();
$getHandler->ProcessRecords();
$getHandler->DefineField("region_id");
$wherestring=" ";
$o->getSelectRegion($wherestring);
$getHandler->completeGet();
break;

/* end address */


/* start followup nitobi */
case "searchfollowup": //return xml table to grid
    $wherestring=" WHERE bpartner_id=$o->bpartner_id";
    $o->showFollowup($wherestring);
    exit; //after return xml shall not run more code.
break;
case "savefollowup": //process submited xml data from grid
     $o->saveFollowup();
break;
case "followup":
echo '<html  xmlns:ntb="http://www.nitobi.com">';
$o->includeGeneralFile();
$o->getFollowupform();//use nitobi
echo '</html>';
break;

case "getfollowuptype": //return xml table to grid
include_once "../simantz/class/EBAGetHandler.php";
header('Content-type: text/xml');
$lookupdelay=1000;
$pagesize=&$_GET["pagesize"];
$ordinalStart=&$_GET["startrecordindex"];
$sortcolumn=&$_GET["sortcolumn"];
$sortdirection=&$_GET["sortdirection"];
$getHandler = new EBAGetHandler();
$getHandler->ProcessRecords();
$getHandler->DefineField("followup_type");
$wherestring=" WHERE isactive!=0 ";
$o->getSelectFollowuptype($wherestring);
$getHandler->completeGet();
break;
case "editfollowuplayer":
    $followup_id=$_POST['followup_id'];
    $o->showEditFollowUpLayer($followup_id);
    die;
    break;
case "savefollowuplayer";
    $o->saveFollowUpLayer();
    die;
    break;

case "getemployeelist": //return xml table to grid
include_once "../simantz/class/EBAGetHandler.php";
header('Content-type: text/xml');
$lookupdelay=1000;
$pagesize=&$_GET["pagesize"];
$ordinalStart=&$_GET["startrecordindex"];
$sortcolumn=&$_GET["sortcolumn"];
$sortdirection=&$_GET["sortdirection"];
$getHandler = new EBAGetHandler();
$getHandler->ProcessRecords();
$getHandler->DefineField("employee_id");
$wherestring=" WHERE isactive!=0 ";
$o->getSelectEmployeeList($wherestring);
$getHandler->completeGet();
break;
/* end followup */


default :
    include_once "menu.php";
if($o->debtoraccounts_id=="")
         $o->debtoraccounts_id=0;
if($o->creditoraccounts_id=="")
         $o->creditoraccounts_id=0;
        if($issimbiz){
                $o->debtoraccountsctrl=$simbizctrl->getSelectAccounts($o->debtoraccounts_id,'Y',"onchange=''","debtoraccounts_id"," and a.account_type=2 ");
                $o->creditoraccountsctrl=$simbizctrl->getSelectAccounts($o->creditoraccounts_id,'Y',"onchange=''","creditoraccounts_id"," and a.account_type=3 ");
        }
        else{
               $o->debtoraccountsctrl="<input type='text' name='debtoraccounts_id' value='$o->debtoraccounts_id'>";
               $o->creditoraccountsctrl="<input type='text' name='creditoraccounts_id' value='$o->creditoraccounts_id'>";
//                $o->debtoraccountsctrl="Accounting Module doesn't exist <input type='hidden' name='debtoraccounts_id' value=0>";
//                $o->creditoraccountsctrl="Accounting Module doesn't exist <input type='hidden' name='creditoraccounts_id' value=0>";

        }

if($o->organization_id=="")
         $o->organization_id=0;
if($o->industry_id=="")
         $o->industry_id=0;
if($o->bpartnergroup_id=="")
         $o->bpartnergroup_id=0;
if($o->currency_id=="")
         $o->currency_id=0;
if($o->terms_id=="")
         $o->terms_id=0;
                $o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
                $o->bpartnergroupctrl=$bpctrl->getSelectBPartnerGroup($o->bpartnergroup_id,'Y');
                $o->industryctrl=$bpctrl->getSelectIndustry($o->industry_id,'Y');
                $o->groupctrl=$ctrl->getUserGroup($o->groupid,'Y');

                $o->pricelistctrl="<input name='pricelist_id' value='0' type='hidden'>";
                $o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'Y');
                $o->termsctrl=$bpctrl->getSelectTerms($o->terms_id,'Y');

    $o->getInputForm("new","0");

    require(XOOPS_ROOT_PATH.'/footer.php');
break;

}

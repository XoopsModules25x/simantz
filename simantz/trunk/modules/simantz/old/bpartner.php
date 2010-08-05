<?php
include "system.php";
include "menu.php";
include_once 'class/Log.php';
include_once 'class/BPartner.php';
include_once 'class/SelectCtrl.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();
$o = new BPartner();
$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
$orgctrl="";


$action="";

//marhan add here --> ajax
echo "<iframe src='bpartner.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF
<A href='bpartner.php' style='color: GRAY'> [ADD NEW BUSINESS PARTNER]</A>
<A href='bpartner.php?action=search' style='color: gray'> [SEARCH BUSINESS PARTNER]</A>
<br>
<script type="text/javascript">

function sortList(idSort){

	var str = document.getElementById(idSort).src;
	var lengthStr = str.length;
	var type = str.substring(lengthStr-6,lengthStr-4);
	var fldName = idSort.replace("ids_", "");
	var wherestr = document.forms['frmSearchForm'].wherestr.value;

	//set all 'down'
	var i=0;
	while(i< document.forms['frmSearchForm'].elements.length){
	var ctlname = document.forms['frmSearchForm'].elements[i].name; 
	var data = document.forms['frmSearchForm'].elements[i].value;

	if(ctlname.substring(0,4) == "ids_"){
	document.getElementById(ctlname).src = "images/sortdown.gif";
	}
	
	i++;	
	}

	//set fld selected
	if(type == "up"){
	document.getElementById(idSort).src = "images/sortdown.gif";
	type_sort = "asc";
	}else{
	document.getElementById(idSort).src = "images/sortup.gif";
	type_sort = "desc";
	}

	
	// start ajax
	var arr_fld=new Array("action","fld_sort","type_sort","wherestr","idSort");//name for POST
	var arr_val=new Array("sortlist",fldName,type_sort,wherestr,idSort);//value for POST
	
	getRequest(arr_fld,arr_val);
	
	//eval("document.frmSearchForm."+idSort+".value = 'desc';");

}

function autofocus(){
checkaccounts();}

function IsNumeric(sText)
{
   var ValidChars = "0123456789.-";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
   }


	function validateBPartner(){
		//alert(document.forms['frmBPartner'].accounts_id.value);
		var name=document.forms['frmBPartner'].bpartner_name.value;
		var defaultlevel=document.forms['frmBPartner'].defaultlevel.value;
		var bpartnergroup=document.forms['frmBPartner'].bpartnergroup_id.value;
	
		if(confirm("Save record?")){
		if(name =="" || !IsNumeric(defaultlevel) || defaultlevel=="" || bpartnergroup==0){
			alert('Please make sure Business Partner Group and Name is filled in, Default Level filled with numeric value');
			return false;
		}
		else
			return true;
		}
		else
			return false;
	}

	function getDefaultAccount(value){
	//alert(value);
	var arr_fld=new Array("action","bpartnergroup_id");//name for POST
	var arr_val=new Array("getdefaultacc",value);//value for POST
	
	getRequest(arr_fld,arr_val);

	}

  function checkaccounts(){
	var account_id=document.forms['frmBPartner'].accounts_id.value;
	if(account_id==0)
		document.forms['frmBPartner'].openingbalance.readOnly=true;
	else
		document.forms['frmBPartner'].openingbalance.readOnly=false;
	}
</script>

EOF;

$o->bpartner_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->bpartner_id=$_POST["bpartner_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->bpartner_id=$_GET["bpartner_id"];

}
else
$action="";

$token=$_POST['token'];



$accountmoduleexist=false;
	if(file_exists("../simbiz/class/Accounts.php")){
		$log->showLog(3,"Account module exist");
		$accountmoduleexist=true;
	}
	else{
		$log->showLog(3,"Account module exist");
		$accountmoduleexist=false;
	}


    $o->createdby=$xoopsUser->getVar('uid');
    $o->updatedby=$xoopsUser->getVar('uid');
 	$timestamp= date("y/m/d H:i:s", time()) ;
    $o->updated=$timestamp;
    $o->created=$timestamp;
    $o->isAdmin=$xoopsUser->isAdmin();
	$o->bpartnergroup_id=$_POST['bpartnergroup_id'];
	$o->bpartner_no=$_POST['bpartner_no'];
	$o->bpartner_name=$_POST['bpartner_name'];
	$o->isactive=$_POST['isactive'];
	$o->defaultlevel=$_POST['defaultlevel'];
	$o->currency_id=$_POST['currency_id'];
	$o->terms_id=$_POST['terms_id'];
	$o->salescreditlimit=$_POST['salescreditlimit'];
	$o->organization_id=$_POST['organization_id'];
	$o->bpartner_url=$_POST['bpartner_url'];
	$o->debtoraccounts_id=$_POST['debtoraccounts_id'];
	$o->description=$_POST['description'];
	$o->tax_id=$_POST['tax_id'];
	$o->currentbalance=$_POST['currentbalance'];
	$o->creditoraccounts_id=$_POST['creditoraccounts_id'];
	$o->isdebtor=$_POST['isdebtor'];
	$o->iscreditor=$_POST['iscreditor'];
	$o->istransporter=$_POST['istransporter'];
	$o->purchasecreditlimit=$_POST['purchasecreditlimit'];
	$o->enforcesalescreditlimit=$_POST['enforcesalescreditlimit'];
	$o->enforcepurchasecreditlimit=$_POST['enforcepurchasecreditlimit'];
	$o->currentsalescreditstatus=$_POST['currentsalescreditstatus'];
	$o->currentpurchasecreditstatus=$_POST['currentpurchasecreditstatus'];
	$o->bankaccountname=$_POST['bankaccountname'];
	$o->bankname=$_POST['bankname'];
	$o->bankaccountno=$_POST['bankaccountno'];
	$o->isdealer=$_POST['isdealer'];
	$o->isprospect=$_POST['isprospect'];
	$o->employeecount=$_POST['employeecount'];
	$o->alternatename=$_POST['alternatename'];
	$o->companyno=$_POST['companyno'];
	$o->industry_id=$_POST['industry_id'];
    $o->tooltips=$_POST['tooltips'];

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

if($action != "search"){
if ($o->isactive==1 or $o->isactive=="on")
	$o->isactive=1;
else
	$o->isactive=0;
}
//$o->openingbalance=$_POST['openingbalance'];
//$o->previousopeningbalance=$_POST['previousopeningbalance'];

$filterstring = $_GET['filterstring'];

/*
	if($filterstring=="")
	$filterstring=$o->searchAToZ();
	else{
	$o->searchAToZ();
	}
*/
$o->searchAToZ();
	



 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with bpartner name=$o->bpartner_name");

	if ($s->check(true,$token,"CREATE_BPARTNER")){
		

		
	if($o->insertBPartner()){

		 $latest_id=$o->getLatestBPartnerID();
        $log->saveLog($latest_id, $tablebpartner, $o->updatesql, "I", "O");
/*		if($accountmoduleexist==true && $o->accounts_id>0){
		include_once "../simbiz/class/Accounts.php";
			$acc = new Accounts();
			$acc->fetchAccounts($o->accounts_id);
			$acc->openingbalance=$o->openingbalance+$acc->openingbalance;
			$acc->createdby=$o->createdby;
			$acc->updatedby=$o->updatedby;
			$effectedamt=$o->openingbalance-$o->previousopeningbalance;

			$acc->updateLastBalance($o->accounts_id,$o->openingbalance,$o->previousopeningbalance,$latest_id);
			$acc->updateOpenBalance($o->accounts_id,$effectedamt);
			$acc->updateOpeningBalanceAccount($o->openingbalance,$o->previousopeningbalance);

			$acc->recalculateAllParentAccounts();

//			$acc->recalculateAllParentAccounts();	
		}
*/			redirect_header("bpartner.php?action=view&bpartner_id=$o->bpartner_id",$pausetime,"Your data is saved, Create More Record.");
			 //redirect_header("bpartner.php?action=edit&bpartner_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
			$token=$s->createToken($tokenlife,"CREATE_BPARTNER");
            $log->saveLog(0, $tablebpartner, $o->updatesql, "I", "F");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->bpartnergroupctrl=$ctrl->getSelectBPartnerGroup($o->bpartnergroup_id,'Y',"onchange='getDefaultAccount(this.value)'");
		    $o->industryctrl=$ctrl->getSelectIndustry($o->industry_id,'N');
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N');
		$o->termsctrl=$ctrl->getSelectTerms($o->terms_id,'Y');
		$o->taxctrl=$ctrl->getSelectTax($o->tax_id,'Y');
		if($accountmoduleexist==true){
			$o->debtoraccountsctrl=$ctrl->getSelectAccounts($o->debtoraccounts_id,'Y',"onchange=''","debtoraccounts_id","");
			$o->creditoraccountsctrl=$ctrl->getSelectAccounts($o->creditoraccounts_id,'Y',"onchange=''","creditoraccounts_id","");
		}
		else{
          
			$o->debtoraccountsctrl="Accounting Module doesn't exist <input type='hidden' name='debtoraccounts_id' value=0>";
			$o->creditoraccountsctrl="Accounting Module doesn't exist <input type='hidden' name='creditoraccounts_id' value=0>";

		}

//		$o->accountsctrl=$ctrl->getSelectAccounts($o->accounts_id,'Y',"onchange=''","accounts_id","");

		$o->getInputForm("new",-1,$token);
		$o->showBPartnerTable("WHERE bpartner_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,bp.bpartner_no,bpartner_name"); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_BPARTNER");
          $log->saveLog(0, $tablebpartner, $o->updatesql, "I", "F");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->bpartnergroupctrl=$ctrl->getSelectBPartnerGroup($o->bpartnergroup_id,'Y',"onchange='getDefaultAccount(this.value)'");
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N');
        	    $o->industryctrl=$ctrl->getSelectIndustry($o->industry_id,'N');
		$o->termsctrl=$ctrl->getSelectTerms($o->terms_id,'Y');
		$o->taxctrl=$ctrl->getSelectTax($o->tax_id,'Y');
		if($accountmoduleexist==true){
			$o->debtoraccountsctrl=$ctrl->getSelectAccounts($o->debtoraccounts_id,'Y',"onchange=''","debtoraccounts_id","");
			$o->creditoraccountsctrl=$ctrl->getSelectAccounts($o->creditoraccounts_id,'Y',"onchange=''","creditoraccounts_id","");
		}
		else{
			$o->debtoraccountsctrl="Accounting Module doesn't exist <input type='hidden' name='debtoraccounts_id' value=0>";
			$o->creditoraccountsctrl="Accounting Module doesn't exist <input type='hidden' name='creditoraccounts_id' value=0>";

		}	
		$o->getInputForm("new",-1,$token);
		$o->showBPartnerTable("WHERE bpartner_id>0 and organization_id=$defaultorganization_id","ORDER BY defaultlevel,bp.bpartner_no,bpartner_name"); 
	}
 
break;
	//when user request to edit particular organization
    case "view":
       if($o->fetchBPartner($o->bpartner_id)){
        		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
                $o->viewBpartnerInfo();		

                $tokenadd=$s->createToken($tokenlife,"CREATE_ADD");
                $tokencontacts=$s->createToken($tokenlife,"CREATE_CONTACTS");
                include_once "class/Address.php.inc";
                include_once "class/Contacts.php.inc";
                $add = new Address();
                $contacts = new Contacts();
                $add->showAddressTable($o->bpartner_id,"WHERE ad.bpartner_id=$o->bpartner_id",
                            "ORDER BY ad.defaultlevel,ad.address_name",$tokenadd);
                echo "<BR>";
                $contacts->showContactsTable($o->bpartner_id,"WHERE c.bpartner_id=$o->bpartner_id",
                            "ORDER BY c.defaultlevel,c.contacts_name",$tokencontacts);
        }
       	else	//if can't find particular organization from database, return error message
    		redirect_header("bpartner.php",3,"Some error on viewing your bpartner data, probably database corrupted");
        break;
  case "edit" :

	if($o->fetchBPartner($o->bpartner_id)){

	
//		if($o->bpartnergroup_id > 0){
//		$account_type = $o->getAccountType($o->bpartnergroup_id);
//		$whereaccount = " and account_type =  $account_type ";
//		}else
//		$whereaccount = "";

		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_BPARTNER");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->bpartnergroupctrl=$ctrl->getSelectBPartnerGroup($o->bpartnergroup_id,'Y',"onchange='getDefaultAccount(this.value)'");
	    $o->industryctrl=$ctrl->getSelectIndustry($o->industry_id,'N');
		$o->currencyctrl=$ctrl->getSelectCurrency($o->currency_id,'N');
		$o->termsctrl=$ctrl->getSelectTerms($o->terms_id,'Y');
		$o->taxctrl=$ctrl->getSelectTax($o->tax_id,'Y');
		if($accountmoduleexist==true){
			if($o->debtoraccounts_id>0)
			$o->debtoraccountsctrl=$ctrl->getSelectAccounts($o->debtoraccounts_id,'Y',"onchange=''","debtoraccounts_id","","Y");
			else
			$o->debtoraccountsctrl=$ctrl->getSelectAccounts($o->debtoraccounts_id,'Y',"onchange=''","debtoraccounts_id","","N");

			if($o->creditoraccounts_id>0)
			$o->creditoraccountsctrl=$ctrl->getSelectAccounts($o->creditoraccounts_id,'Y',"onchange=''","creditoraccounts_id","","Y");
			else
			$o->creditoraccountsctrl=$ctrl->getSelectAccounts($o->creditoraccounts_id,'Y',"onchange=''","creditoraccounts_id","","N");
		
		}
		else{
			$o->debtoraccountsctrl="Accounting Module doesn't exist <input type='hidden' name='debtoraccounts_id' value=0>";
			$o->creditoraccountsctrl="Accounting Module doesn't exist <input type='hidden' name='creditoraccounts_id' value=0>";

		}

//		$o->accountsctrl=$ctrl->getSelectAccounts($o->accounts_id,'Y',"onchange=''","accounts_id",$whereaccount,'Y');
		$o->getInputForm("edit",$o->bpartner,$token);
	//	$o->showBPartnerTable("WHERE bpartner_id>0 and organization_id=$defaultorganization_id AND bpartner_name LIKE '$filterstring%' AND isactive=1","ORDER BY defaultlevel,bpartner_name"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("bpartner.php",3,"Some error on viewing your bpartner data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(true,$token,"CREATE_BPARTNER")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateBPartner()){ //if data save successfully
/*			if($accountmoduleexist==true && 
				$o->accounts_id>0 && 
				(($o->openingbalance!=$o->previousopeningbalance) || ($o->previousaccounts_id!=$o->accounts_id))) {
					include_once "../simbiz/class/Accounts.php";
					include_once "../simbiz/class/Transaction.php";
					$acc = new Accounts();
					$effectedamt=$o->openingbalance-$o->previousopeningbalance;
					//if change debtor

					$acc->updateLastBalance($o->accounts_id,$o->openingbalance,$o->previousopeningbalance,$o->bpartner_id);
					$acc->updateOpenBalance($o->accounts_id,$effectedamt);
					$acc->updateOpeningBalanceAccount($o->openingbalance,$o->previousopeningbalance);
					$acc->recalculateAllParentAccounts();
				//	$acc->updateLastBalance($o->accounts_id,$effectedamt);
					//update debtor/creditor lastbalance
					//if change amt, update debtor/creditor lastbalance
					//propogate lastbalance on transaction summary 


		}
*/
        $log->saveLog($o->bpartner_id, $tablebpartner, $o->updatesql, "U", "O");
		redirect_header("bpartner.php?action=edit&bpartner_id=$o->bpartner_id",$pausetime,"Your data is saved,change amt:$effectedamt.");
		}
		else{
             $log->saveLog($o->bpartner_id, $tablebpartner, $o->updatesql, "U", "F");
			redirect_header("bpartner.php?action=edit&bpartner_id=$o->bpartner_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
        }
		}
	else{
        $log->saveLog($o->bpartner_id, $tablebpartner, $o->updatesql, "U", "F");
		redirect_header("bpartner.php?action=edit&bpartner_id=$o->bpartner_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(true,$token,"CREATE_BPARTNER")){
		if($o->deleteBPartner($o->bpartner_id)){
            $log->saveLog($o->bpartner_id, $tablebpartner, $o->updatesql, "D", "O");
			redirect_header("bpartner.php",$pausetime,"Data removed successfully.");
        }
		else{
            $log->saveLog($o->bpartner_id, $tablebpartner, $o->updatesql, "D", "F");
			redirect_header("bpartner.php?action=edit&bpartner_id=$o->bpartner_id",$pausetime,"Warning! Can't delete data from database.");
        }
	}
	else{
                    $log->saveLog($o->bpartner_id, $tablebpartner, $o->updatesql, "D", "F");
		redirect_header("bpartner.php?action=edit&bpartner_id=$o->bpartner_id",$pausetime,"Warning! Can't delete data from database due to token expired.");
    }
  break;

  case "getdefaultacc" :

	$value = $_POST['bpartnergroup_id'];

	
	$o->getDefaultAccount($value);
	$debtoraccountsctrl=$ctrl->getSelectAccounts($o->defdebtoraccounts_id,'Y',"","debtoraccounts_id"," and account_type =  2 ","N");
	$creditoraccountsctrl=$ctrl->getSelectAccounts($o->defcreditoraccounts_id,'Y',"","creditoraccounts_id"," and account_type =  3 ","N");

echo <<< EOF
	<script type="text/javascript">
	//alert("$account_type");
	self.parent.document.getElementById("iddebtoraccountsctrl").innerHTML ="$debtoraccountsctrl";
	self.parent.document.getElementById("idcreditoraccountsctrl").innerHTML ="$creditoraccountsctrl";
	//self.parent.document.forms['frmBPartner'].accounts_id.value = "$accounts_id";

	</script>
EOF;

  break;
  
  case "search" :
  	$issearch=$_POST['issearch'];
	
  	if($o->accounts_id == "")
	$o->accounts_id = 0;
	if($o->tax_id == "")
	$o->tax_id = 0;
	if($o->bpartnergroup_id == "")
	$o->bpartnergroup_id = 0;
	
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	$o->bpartnergroupctrl=$ctrl->getSelectBPartnerGroup($o->bpartnergroup_id,'Y',"");

	$o->currencyctrl=$ctrl->getSelectCurrency(0,'N');
	$o->countryctrl=$ctrl->getSelectCountry(0,'N');
	$o->termsctrl=$ctrl->getSelectTerms(0,'Y');
	$o->taxctrl=$ctrl->getSelectTax($o->tax_id,'Y');
		if($accountmoduleexist==true)
			$o->accountsctrl=$ctrl->getSelectAccounts($o->accounts_id,'Y',"onchange=''","accounts_id","");
		else
			$o->accountsctrl="Accounting Module doesn't exist <input type='hidden' name='accounts_id' value=0>";
//	$o->accountsctrl=$ctrl->getSelectAccounts($o->accounts_id,'Y',"onchange=''","accounts_id",$whereaccount);
	$o->showSearchForm();
	
	//$where = $o->getWhereStr($o->bpartner_no,$o->bpartner_name,$o->accounts_id,$o->tax_id,$o->isactive);
	$wherestr	= " WHERE bp.bpartner_id>0 and bp.organization_id=$defaultorganization_id ";
	$wherestr .= $o->getWhereStr();
	
	if($issearch == 1)
	$limit = "";
	else
	$limit = " limit $rowperpage ";

	if($issearch == 1)
	$o->showBPartnerTable($wherestr,"ORDER BY bp.defaultlevel,bp.bpartner_no,bp.bpartner_name",$limit);
  break;

  case "sortlist" :
	$wherestr = str_replace("~", "'",$_POST['wherestr']);
	$type_sort = $_POST['type_sort'];
	$fld_sort = $_POST['fld_sort'];
	$idSort = $_POST['idSort'];

 	echo $orderstr = " order by $fld_sort $type_sort";
	$htmlList = $o->sortList("$wherestr","$orderstr");

echo <<< EOF
	<script type='text/javascript'>
	self.parent.document.getElementById('idListHTML').innerHTML = "$htmlList";

	if("$type_sort" == "asc"){
	self.parent.document.getElementById("$idSort").src = "images/sortdown.gif";
	}else{
	self.parent.document.getElementById("$idSort").src = "images/sortup.gif";
	}

	</script>
EOF;
	
  break;
  
  default :
	$token=$s->createToken($tokenlife,"CREATE_BPARTNER");
	$log->showLog(3,"default org_id: $defaultorganization_id");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N',"",'Y');
	$o->bpartnergroupctrl=$ctrl->getSelectBPartnerGroup(0,'Y',"onchange='getDefaultAccount(this.value)'");

	$o->currencyctrl=$ctrl->getSelectCurrency(0,'N');
	$o->termsctrl=$ctrl->getSelectTerms(0,'Y');
    $o->industryctrl=$ctrl->getSelectIndustry(0,'N');
	$o->taxctrl=$ctrl->getSelectTax(0,'Y');
		if($accountmoduleexist==true)
			$o->accountsctrl=$ctrl->getSelectAccounts(0,'N',"onchange=''","accounts_id",$whereaccount);
		else
			$o->accountsctrl="Accounting Module doesn't exist <input type='hidden' name='accounts_id' value=0>";
//	$o->accountsctrl=$ctrl->getSelectAccounts(0,'Y',"onchange=''","accounts_id",$whereaccount);

	if($filterstring == "")
	$o->getInputForm("new",0,$token);
	
	if($filterstring != ""){

	if($filterstring == "all")
	$filterstring = "%";
	$o->showBPartnerTable("WHERE bp.bpartner_id>0 and bp.organization_id=$defaultorganization_id AND bp.bpartner_name LIKE '$filterstring%' AND bp.isactive=1","ORDER BY bp.defaultlevel,bp.bpartner_no,bp.bpartner_name");
	}
	
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

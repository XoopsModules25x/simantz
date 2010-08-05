<?php

	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class BPartner
{

    public $bpartner_id;
    public $bpartner_no;
    public $bpartner_name;
    public $bpartnergroup_id;
    public $companyno;
    public $alternatename;
    public $employeecount;
    public $employee_id;
    public $isactive;
    public $isdebtor;
    public $iscreditor;
    public $isdealer;
    public $isprospect;
    public $istransporter;
    public $currency_id;
    public $defaultlevel;
    public $tooltips;
    public $bpartner_url;
    public $description;

  //selection list
  public $bpartnergroupctrl;
  public $industry_name;
  public $terms_name;
  public $employee_name;
  public $currency_name;
  public $tax_name;
  public $salespricelist_name;
  public $purchasepricelist_name;
  public $errormessage;
  private $xoopsDB;


  private $log;


//constructor
   public function BPartner(){
	global $xoopsDB,$log;
  	$this->xoopsDB=$xoopsDB;

	$this->tablebpartner=$tablebpartner;
	$this->tablebpartner=$tablebpartner;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type
   * @param int bpartner_id
   * @return
   * @access public
   */
  public function getBasicInputForm($type) {
global $ctrl;
if($this->isactive==1)$isactivechecked="checked";
if($this->isdebtor==1)$isdebtorchecked="checked";
if($this->iscreditor==1)$iscreditorchecked="checked";
if($this->istransporter==1)$istransporterchecked="checked";
if($this->isdealer==1)$isdealerchecked="checked";
if($this->isprospect==1)$isprospectchecked="checked";
$this->bpartnergroupctrl= $ctrl->getSelectBPartnerGroup($this->bpartnergroup_id, "bpartnergroup_id", "", "", "classic",$this->bpartnergroup_name);
$this->currencyctrl= $ctrl->getSelectCurrency($this->currency_id, "currency_id", "", "", "classic",$this->currency_name);
$this->termsctrl= $ctrl->getSelectTerms($this->terms_id, "terms_id", "", "", "classic",$this->terms_name);
$this->industryctrl= $ctrl->getSelectIndustry($this->industry_id, "industry_id", "", "", "classic",$this->industry_name);
$this->employeectrl= $ctrl->getSelectEmployee($this->employee_id, "employee_id", "", "", "classic",$this->employee_name);
$this->salespricelist_idctrl=$ctrl->getSelectPriceList($this->salespricelist_id, "salespricelist_id", "", "", "classic",$this->salespricelist_name);
$this->purchasepricelist_idctrl=$ctrl->getSelectPriceList($this->purchasepricelist_id, "purchasepricelist_id", "", "", "classic",$this->purchasepricelist_name);
$this->bpartner_noctrl=$ctrl->getTextField("bpartner_no", "$this->bpartner_no", "bpartner_no", "");
$this->bpartner_namectrl=$ctrl->getTextField("bpartner_name", "$this->bpartner_name", "bpartner_name", "maxlength=\"50\" size=\"40\"");
$this->companynoctrl=$ctrl->getTextField("companyno",$this->companyno,"companyno","maxlength=\"20\" size=\"12\"");
$this->alternatenamectrl=$ctrl->getTextField("alternatename", $this->alternatename, "alternatename", "maxlength=\"40\" size=\"30\"");
$this->employeecountctrl=$ctrl->getTextField("employeecount", $this->employeecount, "employeecount", "maxlength=\"5\" size=\"5\"");
$this->defaultlevelctrl= $ctrl->getTextField("defaultlevel", $this->defaultlevel, "defaultlevel", "maxlength=\"3\" size=\"3\"");
$this->tooltipsctrl=$ctrl->getTextField("tooltips", $this->tooltips, "tooltips", "maxlength=\"200\" size=\"50\"");
$this->bpartner_urlctrl=$ctrl->getTextField("bpartner_url", $this->bpartner_url, "bpartner_url", "maxlength=\"200\" size=\"50\"");
$this->basicsavebuttonctrl=$ctrl->getButton("basicsaveaction", "Save", "basicsaveaction","button",array("saveonly"=>"Save Only","saveaddnew"=>"Save and add new record"), "onclick=\"validation()\"");
$this->descriptionctrl=$ctrl->getTextArea("description",$this->description,"description"," rows=\"4\" cols=\"80\"");
$this->isdebtorctrl=$ctrl->getCheckBox("isdebtor",$isdebtorchecked,$fieldvalue,"isdebtor","");
$this->isprospectctrl=$ctrl->getCheckBox("isprospect",$isprospectchecked,$fieldvalue,"isprospect","");
$this->istransporterctrl=$ctrl->getCheckBox("istransporter",$istransporterchecked,$fieldvalue,"istransporter","");
$this->iscreditorctrl=$ctrl->getCheckBox("iscreditor",$iscreditorchecked,$fieldvalue,"iscreditor","");
$this->isdealerctrl=$ctrl->getCheckBox("isdealer",$isdealerchecked,$fieldvalue,"isdealer","");
$this->isactivectrl=$ctrl->getCheckBox("isactive",$isactivechecked,$fieldvalue,"isactive","");

echo <<< EOF
<table><td>
  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">Basic Info</th>
      </tr>
      <tr>
       <td class="head">Business Partner No $mandatorysign</td>
        <td class="even" >$this->bpartner_noctrl
	&nbsp;Active $this->isactivectrl
        <td class="head">Business Partner Name $mandatorysign</td>
        <td class="even" >$this->bpartner_namectrl
      </td>
      </tr>
      <tr>
   	<td class="head">Group $mandatorysign</td>
        <td class="even" >$this->bpartnergroupctrl</td>
    	<td class="head">Industry $mandatorysign</td>
	    <td class="even" >$this->industryctrl</td>
      </tr>
      <tr>
    	<td class="head">Company No</td>
	    <td class="even" >$this->companynoctrl</td>
        <td class="head">Alternate Name</td>
	    <td class="even" >$this->alternatenamectrl</td>
      </tr>
      <tr>
        <td class="head">Employee Count</td>
	    <td class="even">$this->employeecountctrl</td>
      <td class="head">Company Representative</td>
        <td class="even">$this->employeectrl</td>
    	</tr>
     <tr>
    	<td class="head">Is Customer</td>
	    <td class="even">$this->isdebtorctrl</td>
        <td class="head">Is Supplier</td>
	    <td class="even" >$this->iscreditorctrl</td>
      </tr>
     <tr>
    	<td class="head">Sales Price List</td>
	    <td class="even">$this->salespricelist_idctrl</td>
        <td class="head">Purchase Price List</td>
	    <td class="even" >$this->purchasepricelist_idctrl</td>
      </tr>     <tr>
    	<td class="head">Is Transporter</td>
	    <td class="even" >$this->istransporterctrl</td>
        <td class="head">Is Dealer</td>
	    <td class="even" >$this->isdealerctrl</td>
      </tr>
     <tr>
    	<td class="head">Prospect Customer</td>
	    <td class="even">$this->isprospectctrl</td>
        <td class="head">Terms</td>
	    <td class="even" >$this->termsctrl</td>
      </tr>
     <tr>
        <td class="head">Currency</td>
        <td class="even" >$this->currencyctrl</td>
        <td class="head">Default Level List</td>
	    <td class="even">$this->defaultlevelctrl</td>
      </tr>

       <tr>
        <td class="head">Tooltips</td>
	    <td class="even">$this->tooltipsctrl</td>
        <td class="head">Website</td>
	    <td class="even">$this->bpartner_urlctrl</td>
      </tr>
      <tr>
        <td class="head">Description</td>
	    <td class="even" colspan="3">
                $this->descriptionctrl
        </td>
      </tr>
    </tbody>
  </table>
  $this->basicsavebuttonctrl
</td>
<td><div id="basicsavediv"></div></td>
</table>

EOF;

  } // end of member function getInputForm

  public function getAccountingInputForm($type) {
global $ctrl;
if($this->isactive==1)$isactivechecked="checked";

$this->bankaccountnamectrl=$ctrl->getTextField("bankaccountname", $this->bankaccountname, "bankaccountname", "maxlength=\"40\" size=\"30\"");
$this->bankaccountnoctrl=$ctrl->getTextField("bankaccountno", $this->bankaccountno, "bankaccountno", "maxlength=\"25\" size=\"25\"");
$this->salescreditlimitctrl=$ctrl->getTextField("salescreditlimit", $this->salescreditlimit, "salescreditlimit", "maxlength=\"40\" size=\"30\"");
$this->purchasecreditlimitctrl=$ctrl->getTextField("purchasecreditlimit", $this->purchasecreditlimit, "purchasecreditlimit", "maxlength=\"40\" size=\"30\"");
$this->currentsalescreditstatusctrl=$ctrl->getTextField("currentsalescreditstatus", $this->currentsalescreditstatus, "currentsalescreditstatus", "maxlength=\"40\" size=\"30\"");
$this->currentpurchasecreditstatusctrl=$ctrl->getTextField("currentpurchasecreditstatus", $this->currentpurchasecreditstatus, "currentpurchasecreditstatus", "maxlength=\"40\" size=\"30\"");
$this->banknamectrl=$ctrl->getTextField("bankname", $this->bankname, "bankname", "maxlength=\"40\" size=\"30\"");
$this->enforcesalescreditlimitctrl=$ctrl->getCheckBox("enforcesalescreditlimit",$enforcesalescreditlimitchecked,"","enforcesalescreditlimit","");
$this->enforcepurchasecreditlimitctrl=$ctrl->getCheckBox("enforcepurchasecreditlimit",$enforcepurchasecreditlimitchecked,"","enforcepurchasecreditlimit","");
$this->previousdebtoraccounts_idctrl=$ctrl->getHiddenField("previousdebtoraccounts_id", $fieldvalue, "previousdebtoraccounts_id",$option);
$this->previouscreditoraccounts_idctrl=$ctrl->getHiddenField("previouscreditoraccounts_id", $fieldvalue, "previouscreditoraccounts_id",$option);
$this->accountsavebuttonctrl=$ctrl->getButton("accountsaveaction", "Save", "accountsaveaction","button",array("saveonly"=>"Save Only","saveaddnew"=>"Save and add new record"), "onclick=\"accountvalidation()\"");

$this->debtoraccounts_idctrl=$ctrl->getSelectAccounts($recordid=0,$ctrlid="debtoraccounts_id",$onchangefunction="",$filterstring="",$mode="classic",$initialsearch="");
$this->creditoraccounts_idctrl=$ctrl->getSelectAccounts($recordid=0,$ctrlid="creditoraccounts_id",$onchangefunction="",$filterstring="",$mode="classic",$initialsearch="");
$this->tax_idctrl=$ctrl->getSelectTax($this->tax_id, "tax_id","", "", "classic", $this->tax_name);

echo <<< EOF
<table><td>
  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
 <tbody>
 <tr><th colspan="4" rowspan="1">Accounting Info</th></tr>
           <tr>
            <td class="foot">Debtor Account</td>
	        <td class="odd">
                    $this->debtoraccounts_idctrl
                    $this->previousdebtoraccounts_idctrl
                </td>
            <td class="foot">Creditor Account</td>
	        <td class="odd">
                    $this->creditoraccounts_idctrl
                    $this->previouscreditoraccounts_idctrl
                </td>

           </tr>
           <tr>
            <td class="foot">Sales Credit Limit</td>
	        <td class="odd">$this->salescreditlimitctrl</td>
            <td class="foot">Purchase Credit Limit</td>
	        <td class="odd">$this->purchasecreditlimitctrl</td>
           </tr>
           <tr>

            <td class="foot">Control Sales Credit Limit</td>
	        <td class="odd">$this->enforcesalescreditlimitctrl</td>
            <td class="foot">Control Purchase Credit Limit</td>
	        <td class="odd">$this->enforcepurchasecreditlimitctrl</td>
           </tr>
           <tr>
            <td class="foot">Current Sales Limit Status</td>

	        <td class="odd">$this->currentsalescreditstatusctrl</td>
            <td class="foot">Current Purchase Limit Status</td>
	        <td class="odd">$this->currentpurchasecreditstatusctrl</td>
           </tr>
           <tr>
            <td class="foot">Tax</td>
	        <td class="odd">$this->tax_idctrl</td>

            <td class="foot">Bank Name</td>
	        <td class="odd">$this->banknamectrl</td>
           </tr>
           <tr>
            <td class="foot">Bank Account Name</td>
	        <td class="odd">$this->bankaccountnamectrl</td>
            <td class="foot">Bank Account No</td>

	        <td class="odd">$this->bankaccountnoctrl</td>
           </tr>
       </tbody>
  </table>
  $this->accountsavebuttonctrl

</td>
<td><div id="accountsavediv"></div></td>
</table>

EOF;

  }

public function updateBPartnerBasicInfo( ) {
    global $xoopsDB,$saveHandler,$userid,$timestamp,$defaultorganization_id;
    $tablename="sim_bpartner";
    $pkey="bpartner_id";
    $keyword="BPartner";
    $controlfieldname="bpartner_no";

    $this->log->showLog(2,"Access into updateBPartnerBasicInfo() event");
    
      $arrfield=array($controlfieldname,  "bpartner_name","bpartnergroup_id","industry_id",
            "companyno","alternatename","employeecount","employee_id","isdebtor","iscreditor","salespricelist_id","purchasepricelist_id",
            "istransporter","isdealer","isprospect","currency_id","tooltips","terms_id",
            "bpartner_url", "description", "isactive","defaultlevel","updated","updatedby");
      $arrfieldtype=array('%s','%s','%d','%d','%s','%s','%d','%d','%d','%d','%d','%d','%d','%d','%d','%d','%s','%d','%s','%s','%d','%d','%s','%d');
 // Yes there are UPDATEs to perform...

        $arrvalue=array($this->bpartner_no,$this->bpartner_name,$this->bpartnergroup_id,$this->industry_id,
                $this->companyno,$this->alternatename,$this->employeecount,$this->employee_id,$this->isdebtor,$this->iscreditor,
                    $this->salespricelist_id,$this->purchasepricelist_id,
                $this->istransporter,$this->isdealer,$this->isprospect,$this->currency_id,$this->tooltips,$this->terms_id,
                $this->bpartner_url,$this->description,$this->isactive,$this->defaultlevel,$userid,$timestamp);
         $controlvalue=$this->bpartner_no;

         include_once "class/Save_Data.inc.php";
         $save=new Save_Data();
         
         if($save->UpdateRecord($tablename, $pkey,$this->bpartner_id,$arrfield, $arrvalue, $arrfieldtype,$controlvalue)){
           
                $this->errormessage="";
                return true;
         }
         else{
         
             $this->errormessage=$save->failfeedback;
             return false;
         }

} // end of member function updateBPartner

  /**
   * Save new bpartner into database
   *
   * @return bool
   * @access public
   */
  public function insertBPartner( ) {


  } // end of member function insertBPartner

  /**
   * Pull data from bpartner table into class
   *
   * @return bool
   * @access public
   */
  public function fetchBPartner( $bpartner_id) {
	$this->log->showLog(3,"Fetching bpartner detail into class BPartner.php.");
        global $defaultorganization_id;
	 $sql="SELECT bp.bpartner_id,
                    bp.bpartnergroup_id,
                    bp.bpartner_no,
                    bp.bpartner_name,
                    bp.isactive,
                    bp.defaultlevel,
                    bp.created,
                    bp.createdby,
                    bp.updated,
                    bp.updatedby,
                    bp.currency_id,
                    bp.terms_id,
                    bp.salescreditlimit,
                    bp.organization_id,
                    bp.bpartner_url,
                    bp.debtoraccounts_id,
                    bp.description,
                    bp.tax_id,
                    bp.currentbalance,
                    bp.creditoraccounts_id,
                    bp.isdebtor,
                    bp.iscreditor,
                    bp.istransporter,
                    bp.purchasecreditlimit,
                    bp.enforcesalescreditlimit,
                    bp.enforcepurchasecreditlimit,
                    bp.currentsalescreditstatus,
                    bp.currentpurchasecreditstatus,
                    bp.bankaccountname,
                    bp.bankname,
                    bp.bankaccountno,
                    bp.isdealer,
                    bp.isprospect,
                    bp.employeecount,
                    bp.alternatename,
                    bp.companyno,
                    bp.industry_id,
                    bp.tooltips,
                    bp.salespricelist_id,
                    bp.purchasepricelist_id,
                    bp.employee_id,
                    bp.isdeleted,
                    bpg.bpartnergroup_name,
                    i.industry_name,
                    t.terms_name,
                    e.employee_name,
                    c.currency_name,
                    spl.pricelist_name as salespricelist_name,
                    ppl.pricelist_name as purchasepricelist_name
                from sim_bpartner bp
                    inner join sim_bpartnergroup bpg on bp.bpartnergroup_id=bpg.bpartnergroup_id
                    inner join sim_industry i on i.industry_id=bp.industry_id
                    inner join sim_terms t on t.terms_id=bp.terms_id
                    inner join sim_simiterp_employee e on e.employee_id=bp.employee_id
                    inner join sim_currency c on bp.currency_id=c.currency_id
                    inner join sim_simiterp_pricelist spl on bp.salespricelist_id=spl.pricelist_id
                    inner join sim_simiterp_pricelist ppl on bp.purchasepricelist_id=ppl.pricelist_id
			where bp.bpartner_id=$bpartner_id and bp.organization_id=$defaultorganization_id";
	$this->log->showLog(4,"BPartner->fetchBPartner, before execute:" . $sql . "<br>");
	$query=$this->xoopsDB->query($sql);
	while($row=$this->xoopsDB->fetchArray($query)){
                $this->bpartner_id  =$row['bpartner_id'];
                $this->bpartnergroup_id =$row['bpartnergroup_id'];
                $this->bpartner_no =$row['bpartner_no'];
                $this->bpartner_name =$row['bpartner_name'];
                $this->isactive =$row['isactive'];
                $this->defaultlevel =$row['defaultlevel'];
                $this->created =$row['created'];
                $this->createdby =$row['createdby'];
                $this->updated =$row['updated'];
                $this->updatedby =$row['updatedby'];
                $this->currency_id =$row['currency_id'];
                $this->terms_id =$row['terms_id'];
                $this->salescreditlimit =$row['salescreditlimit'];
                $this->organization_id =$row['organization_id'];
                $this->bpartner_url =$row['bpartner_url'];
                $this->debtoraccounts_id =$row['debtoraccounts_id'];
                $this->description =$row['description'];
                $this->tax_id =$row['tax_id'];
                $this->currentbalance =$row['currentbalance'];
                $this->creditoraccounts_id =$row['creditoraccounts_id'];
                $this->isdebtor =$row['isdebtor'];
                $this->iscreditor =$row['iscreditor'];
                $this->istransporter =$row['istransporter'];
                $this->salespricelist_name=$row['salespricelist_name'];
                $this->purchasepricelist_name=$row['purchasepricelist_name'];
                $this->purchasecreditlimit =$row['purchasecreditlimit'];
                $this->enforcesalescreditlimit =$row['enforcesalescreditlimit'];
                $this->enforcepurchasecreditlimit =$row['enforcepurchasecreditlimit'];
                $this->currentsalescreditstatus =$row['currentsalescreditstatus'];
                $this->currentpurchasecreditstatus =$row['currentpurchasecreditstatus'];
                $this->bankaccountname =$row['bankaccountname'];
                $this->bankname =$row['bankname'];
                $this->bankaccountno =$row['bankaccountno'];
                $this->isdealer =$row['isdealer'];
                $this->isprospect =$row['isprospect'];
                $this->employeecount =$row['employeecount'];
                $this->alternatename =$row['alternatename'];
                $this->companyno =$row['companyno'];
                $this->industry_id =$row['industry_id'];
                $this->tooltips =$row['tooltips'];
                $this->pricelist_id =$row['pricelist_id'];
                $this->employee_id =$row['employee_id'];
                $this->isdeleted=$row['isdeleted'];
                $this->bpartnergroup_name=$row['bpartnergroup_name'];
                $this->industry_name=$row['industry_name'];
                $this->terms_name=$row['terms_name'];
                $this->employee_name=$row['employee_name'];
                $this->currency_name=$row['currency_name'];
   	$this->log->showLog(4,"BPartner->fetchBPartner,database fetch into class successfully");
	$this->log->showLog(4,"bpartner_name:$this->bpartner_name");
		return true;
	}
	$this->log->showLog(4,"BPartner->fetchBPartner,failed to fetch data into databases:" . mysql_error());
		return false;
  } // end of member function fetchBPartner

  public function deleteBPartner( $bpartner_id ) {
  } // end of member function deleteBPartner
  public function getSQLStr_AllBPartner( $wherestring,  $orderbystring) {
  } // end of member function getSQLStr_AllBPartner

 public function showBPartnerTable($wherestring,$orderbystring){
     global $permctrl, $windowsetting,$nitobigridthemes,$isadmin,$isactive,$filterstring,$lookupdelay;
     echo <<< EOF
 
     <table><tr><td>
    <ntb:grid id="DataboundGrid"
     mode="livescrolling"
     $permctrl $windowsetting
     ondatareadyevent="dataready();"
     rowhighlightenabled="false"
     width="630"
     height="407"
     oncellclickevent="clickrecord(eventArgs)"
     keygenerator="GetNewRecordID();"
     onhandlererrorevent="showError()"
     gethandler="load_data.php?action=bpartner&filterstring=$filterstring&searchisactive=$isactive"
     savehandler="save_data.php?action=savebpartnerfromtablelist"
     onbeforesaveevent="validateSave()"
     onaftersaveevent="savedone(eventArgs)"
     theme="$nitobigridthemes"
     rowsperpage="1">
   <ntb:columns>
       <ntb:textcolumn maxlength="7"  label="Code"  xdatafld="bpartner_no" ></ntb:textcolumn>
       <ntb:textcolumn maxlength="40"  label="Name"  xdatafld="bpartner_name" ></ntb:textcolumn>
       <ntb:textcolumn maxlength="40"  label="Reg.No"  xdatafld="companyno" ></ntb:textcolumn>
       <ntb:textcolumn  label="Group"  xdatafld="bpartnergroup_id">
            <ntb:lookupeditor  delay="'.$lookupdelay.'" gethandler="lookup.php?action=bpartnergroup" displayfields="bpartnergroup_name" valuefield="bpartnergroup_id" >
            </ntb:lookupeditor>
       </ntb:textcolumn>
       <ntb:textcolumn  label="Industry"  xdatafld="industry_id" >
            <ntb:lookupeditor  delay="'.$lookupdelay.'" gethandler="lookup.php?action=industry" displayfields="industry_name" valuefield="industry_id" >
            </ntb:lookupeditor>
       </ntb:textcolumn>
       <ntb:textcolumn  label="Terms"  xdatafld="terms_id" >
            <ntb:lookupeditor  delay="'.$lookupdelay.'" gethandler="lookup.php?action=terms" displayfields="terms_name" valuefield="terms_id" >
            </ntb:lookupeditor>
       </ntb:textcolumn>
       <ntb:textcolumn      label="Active"   width="45"  xdatafld="isactive"   sortenabled="false">
             <ntb:checkboxeditor datasource="[{value:'1',display:'Yes'},{value:'0',display:'No'}]"
                    checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value">
            </ntb:checkboxeditor>
       </ntb:textcolumn>
       <ntb:numbercolumn   maxlength="4" label="Default Level"  width="100" xdatafld="defaultlevel" mask="###0"></ntb:numbercolumn>
EOF;


//only admin user will see record info and isdeleted column
if($isadmin==1)
{
echo<<< EOF
<ntb:textcolumn  label="Log"   xdatafld="info"    width="50"  sortenabled="false" >
            <ntb:linkeditor></ntb:linkeditor openwindow="true" >
       </ntb:textcolumn>
       <ntb:textcolumn      label="Deleted"   width="50"  xdatafld="isdeleted">
            <ntb:checkboxeditor datasource="[{valuedd:'1',displaydd:'Yes'},{valuedd:'0',displaydd:'No'}]"
                    checkedvalue="1" uncheckedvalue="0" displayfields="displaydd" valuefield="valuedd">
           </ntb:checkboxeditor>
       </ntb:textcolumn>
       <ntb:numbercolumn width="10"  label="ID"  xdatafld="bpartner_id" ></ntb:textcolumn>

EOF;
}

 echo <<< EOF
 </ntb:grid>
  </td><td>
Status:
<div id="msgbox" class="blockContent"></div>
</td></tr></table>
EOF;
 }

    public function allowDelete($id){
       $this->log->showLog(2,"Call function allowDelete($id)");
        $this->log->showLog(3,"return true");
       return true;
   }


  public function showSearchForm(){

  global $isadmin;

  if($isadmin==1)
  $showdeleted="<input type=\"checkbox\" name=\"searchisdeleted\" id=\"searchisdeleted\">".
        "<a onclick=document.getElementById(\"searchisdeleted\").click() title=\"Show deleted records.\">Show Deleted Only</a>";

  echo <<< EOF
    <form name="frmBPartner">
    <table>
        <tr><th colspan="4">Search BPartner</th></tr>
        <tr>
            <td class="fieldtitle">BPartner Name</td>
            <td class="field"><input name="searchbpartner_name" id="searchbpartner_name"></td>
            <td class="fieldtitle">BPartner Name</td>
            <td class="field"><input name="searchbpartner_name" id="searchbpartner_name"></td>
            </tr>
            <tr>
            <td class="fieldtitle">Active</td>
            <td class="field">
                <select name="searchisactive" id="searchisactive">
                    <option value="-">Null</option>
                    <option value="1" SELECTED="SELECTED">Yes</option>
                    <option value="0">No</option>
                </select>
                </td>
        	<td class="head">Business Partner Group</td>
        	<td class="even">$this->searchbpartnergroupctrl</td>
	</tr>


        <tr><td><input name="submit" value="Search" type="button" onclick="search()">$showdeleted </td></tr>
    </table>
EOF;
}



public function searchAToZ(){
	global $defaultorganization_id;
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search student easily. With function searchAToZ()");
	$sqlfilter=	"SELECT DISTINCT(LEFT(bpartner_name,1)) as shortname FROM sim_bpartner
			where isactive=1 and bpartner_id>0 and isdeleted=0
			and organization_id = $defaultorganization_id
			order by bpartner_name";
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
$displaystring= "<b>Filter By business partner name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if customer never do filter yet, if will choose 1st customer listing

		$displaystring.= "<A href=\"bpartner.php?filterstring=$shortname\"> $shortname </A> ";
	}

		$displaystring.= "<A href=\"bpartner.php?filterstring=all\"> -<u>Show All</u>- </A> ";
return array($displaystring,$filterstring);

	$this->log->showLog(3,"Complete generate list of short cut");
  }



} // end of ClassBPartner
?>
